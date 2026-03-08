// react-display/src/contexts/ScheduleContext/ScheduleProvider.tsx

import React, { useState, useEffect, useCallback, useMemo } from 'react';
import { ScheduleContext } from './scheduleContext';
import { ScheduleData, SessionWithStatus, Presentation } from './types';
import { useTime } from '../TimeContext';

interface ScheduleProviderProps {
	children: React.ReactNode;
	refreshInterval?: number; // in milliseconds, default: 60000 (1 minute)
	minSessionCount?: number; // minimum number of sessions to display, default: 6
}

export function ScheduleProvider({
	children,
	refreshInterval = 60000,
	minSessionCount = 6,
}: ScheduleProviderProps) {
	const { currentTime } = useTime();
	const [schedule, setSchedule] = useState<ScheduleData | null>(null);
	const [isLoading, setIsLoading] = useState<boolean>(true);
	const [error, setError] = useState<Error | null>(null);
	const [lastHash, setLastHash] = useState<string>('');
	const [lastRefreshTime, setLastRefreshTime] = useState<number>(0);
	const [hasInitialLoad, setHasInitialLoad] = useState<boolean>(false);

	const fetchSchedule = useCallback(async () => {
		// Only show loading state on initial load
		if (!hasInitialLoad) {
			setIsLoading(true);
		}

		try {
			const response = await fetch('/schedule');
			if (!response.ok) {
				throw new Error(
					`Failed to fetch schedule: ${String(response.status)} ${
						response.statusText
					}`
				);
			}

			const data = (await response.json()) as ScheduleData;

			// If hash matches, no need to update the state
			if (data.contentHash === lastHash && lastHash !== '') {
				console.log('Schedule hash matches, no update needed');
				setError(null);
				setLastRefreshTime(Date.now());
				return;
			}

			// Update the schedule state and hash
			console.log(
				`Updating schedule: ${String(
					data.Presentations.length || 0
				)} sessions, hash: ${data.contentHash}`
			);
			setSchedule(data);
			setLastHash(data.contentHash);
			setError(null);
			setLastRefreshTime(Date.now());
			setHasInitialLoad(true);
		} catch (err) {
			console.error('Error fetching schedule:', err);
			// Only set error state if we don't have any schedule data yet
			if (!schedule) {
				setError(err instanceof Error ? err : new Error(String(err)));
			} else {
				// If we already have data, just log the error but don't update error state
				console.log('Fetch failed, using cached schedule data');
			}
		} finally {
			// Always set loading to false when done
			setIsLoading(false);
		}
	}, [lastHash, schedule, hasInitialLoad]);

	// Initial fetch and set up interval for refreshing
	useEffect(() => {
		// Initial fetch
		void fetchSchedule();

		// Set up interval for refreshing
		const intervalId = setInterval(() => {
			void fetchSchedule();
		}, refreshInterval);

		// Cleanup interval on unmount
		return () => {
			clearInterval(intervalId);
		};
	}, [fetchSchedule, refreshInterval]);

	// Calculate session status based on current time
	const getSessionStatus = useCallback(
		(session: Presentation) => {
			// Parse start and end times - ensure proper Date objects
			const startTime = new Date(session.StartTime);
			const endTime = new Date(session.EndTime);

			// Use timestamp comparison for more reliable results
			const now = currentTime.getTime();
			const startTimestamp = startTime.getTime();
			const endTimestamp = endTime.getTime();

			// Calculate time differences directly in milliseconds for precision
			const millisUntilStart = startTimestamp - now;
			const minutesUntilStart = Math.max(
				0,
				Math.ceil(millisUntilStart / 60000)
			);

			const millisRemaining = endTimestamp - now;
			const minutesRemaining = Math.max(0, Math.ceil(millisRemaining / 60000));

			// Check if session is currently in progress
			const isInProgress = now >= startTimestamp && now < endTimestamp;

			// Check if session is in the past (ended)
			const isPast = now >= endTimestamp;

			// Check if session is starting soon (within 10 minutes)
			const isStartingSoon =
				!isInProgress && !isPast && minutesUntilStart <= 10;

			return {
				isInProgress,
				isStartingSoon,
				isPast,
				minutesUntilStart,
				minutesRemaining,
			};
		},
		[currentTime]
	);

	// Helper function to determine if a date is the same day as the reference date
	const isSameDay = useCallback((date1: Date, date2: Date) => {
		return (
			date1.getFullYear() === date2.getFullYear() &&
			date1.getMonth() === date2.getMonth() &&
			date1.getDate() === date2.getDate()
		);
	}, []);

	// Helper function to group sessions by day
	const groupSessionsByDay = useCallback(
		(sessions: SessionWithStatus[]) => {
			const today = new Date(currentTime);
			const tomorrow = new Date(today);
			tomorrow.setDate(tomorrow.getDate() + 1); // Start of tomorrow

			return {
				today: sessions.filter((session) =>
					isSameDay(new Date(session.StartTime), today)
				),
				tomorrow: sessions.filter((session) =>
					isSameDay(new Date(session.StartTime), tomorrow)
				),
				future: sessions.filter((session) => {
					const sessionDate = new Date(session.StartTime);
					return (
						!isSameDay(sessionDate, today) && !isSameDay(sessionDate, tomorrow)
					);
				}),
			};
		},
		[currentTime, isSameDay]
	);

	// Helper function to group sessions by start time
	const groupSessionsByStartTime = useCallback(
		(sessions: SessionWithStatus[]) => {
			// Create a map of start times to arrays of sessions
			const groupedSessions = new Map<number, SessionWithStatus[]>();

			// Group sessions by their exact start timestamp
			sessions.forEach((session) => {
				const startTimestamp = new Date(session.StartTime).getTime();
				if (!groupedSessions.has(startTimestamp)) {
					groupedSessions.set(startTimestamp, []);
				}
				groupedSessions.get(startTimestamp)?.push(session);
			});

			// Sort the start times
			const sortedTimestamps = Array.from(groupedSessions.keys()).sort(
				(a, b) => a - b
			);

			// Return both the grouped map and the sorted timestamps for easy access
			return {
				groups: groupedSessions,
				sortedTimestamps,
			};
		},
		[]
	);

	// Get current and upcoming sessions based on our requirements
	const getCurrentAndUpcomingSessions = useCallback(() => {
		if (!schedule?.Presentations || schedule.Presentations.length === 0) {
			return [];
		}

		console.log(`Getting sessions at ${currentTime.toLocaleTimeString()}`);

		// Process all sessions with their statuses
		const allSessions = schedule.Presentations.map((session) => {
			const status = getSessionStatus(session);
			return { ...session, status } as SessionWithStatus;
		});

		// Filter out past sessions (already ended)
		const nonPastSessions = allSessions.filter(
			(session) => !session.status.isPast
		);

		// Group sessions by day
		const sessionsByDay = groupSessionsByDay(nonPastSessions);
		console.log(
			`Found ${String(sessionsByDay.today.length)} sessions for today, ${String(
				sessionsByDay.tomorrow.length
			)} for tomorrow`
		);

		// If there are no sessions for today, go directly to tomorrow's sessions
		if (sessionsByDay.today.length === 0) {
			console.log("No sessions for today, using tomorrow's sessions");

			if (sessionsByDay.tomorrow.length === 0) {
				console.log('No sessions for tomorrow either');
				return [];
			}

			// Group tomorrow's sessions by start time
			const { groups, sortedTimestamps } = groupSessionsByStartTime(
				sessionsByDay.tomorrow
			);

			// Collect sessions until we have at least minSessionCount or run out of sessions
			const tomorrowSessions: SessionWithStatus[] = [];

			for (const timestamp of sortedTimestamps) {
				const sessionsAtTime = groups.get(timestamp) ?? [];
				tomorrowSessions.push(...sessionsAtTime);

				// If we have enough sessions, we can stop
				if (tomorrowSessions.length >= minSessionCount) {
					break;
				}
			}

			// Sort the final list
			tomorrowSessions.sort((a, b) => {
				// Then by start time
				return (
					new Date(a.StartTime).getTime() - new Date(b.StartTime).getTime()
				);
			});

			console.log(
				`Found ${String(tomorrowSessions.length)} sessions for tomorrow`
			);
			return tomorrowSessions;
		}

		// We have some sessions for today
		// First, get all sessions for today, filtering out in-progress sessions with <= 5 min remaining
		const todaySessions = sessionsByDay.today.filter(
			(session) =>
				!session.status.isInProgress || session.status.minutesRemaining > 5
		);

		console.log(
			`Found ${String(
				sessionsByDay.today.length
			)} total sessions for today, ${String(
				todaySessions.length
			)} after filtering out sessions ending in <= 5 minutes`
		);

		// Sort today's sessions
		todaySessions.sort((a, b) => {
			// Current sessions first
			if (a.status.isInProgress && !b.status.isInProgress) return -1;
			if (!a.status.isInProgress && b.status.isInProgress) return 1;

			// Then by start time
			return new Date(a.StartTime).getTime() - new Date(b.StartTime).getTime();
		});

		// Group today's sessions by start time for ensuring we include all sessions that start at the same time
		const { groups: todayGroups, sortedTimestamps: todayTimestamps } =
			groupSessionsByStartTime(todaySessions);

		// First try the 45-minute window filter
		const sessionsIn45Minutes: SessionWithStatus[] = [];

		// Find all current sessions and sessions starting within 45 minutes
		for (const timestamp of todayTimestamps) {
			const sessionsAtTime = todayGroups.get(timestamp) ?? [];
			const sessionSample = sessionsAtTime[0]; // Take a representative session

			// If this session is in progress with > 5 min remaining or starts within 45 min, include it
			if (
				(sessionSample.status.isInProgress &&
					sessionSample.status.minutesRemaining > 5) ||
				(!sessionSample.status.isInProgress &&
					sessionSample.status.minutesUntilStart <= 45)
			) {
				// For in-progress sessions, only include those with > 5 minutes remaining
				if (sessionSample.status.isInProgress) {
					// Filter each session in this time group individually
					const filteredSessions = sessionsAtTime.filter(
						(s) => s.status.minutesRemaining > 5
					);
					sessionsIn45Minutes.push(...filteredSessions);
				} else {
					// For non-in-progress sessions, include all
					sessionsIn45Minutes.push(...sessionsAtTime);
				}
			}
		}

		console.log(
			`45-minute window found ${String(sessionsIn45Minutes.length)} sessions`
		);

		// Check if we have enough sessions from the 45-minute window
		if (sessionsIn45Minutes.length >= minSessionCount) {
			console.log(
				`45-minute window yielded ${String(
					sessionsIn45Minutes.length
				)} sessions, which is enough`
			);
			return sessionsIn45Minutes;
		}

		// We didn't get enough sessions from the 45-minute window
		// Let's extend to include more of today's sessions
		console.log(
			`45-minute window only yielded ${String(
				sessionsIn45Minutes.length
			)} sessions, extending to more today's sessions`
		);

		// Find the start times we've already included
		const includedStartTimes = new Set(
			sessionsIn45Minutes.map((s) => new Date(s.StartTime).getTime())
		);

		// Add more sessions from today until we have enough
		const result = [...sessionsIn45Minutes];

		for (const timestamp of todayTimestamps) {
			// Skip timestamps we've already included
			if (includedStartTimes.has(timestamp)) continue;

			const sessionsAtTime = todayGroups.get(timestamp) ?? [];
			result.push(...sessionsAtTime);

			// If we now have enough, stop adding
			if (result.length >= minSessionCount) {
				break;
			}
		}

		// Sort the result again to ensure proper order
		result.sort((a, b) => {
			// Current sessions first
			if (a.status.isInProgress && !b.status.isInProgress) return -1;
			if (!a.status.isInProgress && b.status.isInProgress) return 1;

			// Then by start time
			return new Date(a.StartTime).getTime() - new Date(b.StartTime).getTime();
		});

		// Check if we still don't have enough sessions, if not, look at tomorrow's sessions
		if (result.length < minSessionCount && sessionsByDay.tomorrow.length > 0) {
			console.log(
				`Only found ${String(
					result.length
				)} sessions for today, adding tomorrow's sessions to reach minimum`
			);

			// Group tomorrow's sessions by start time
			const { groups: tomorrowGroups, sortedTimestamps: tomorrowTimestamps } =
				groupSessionsByStartTime(sessionsByDay.tomorrow);

			// Keep adding tomorrow's sessions until we reach the minimum count
			for (const timestamp of tomorrowTimestamps) {
				const sessionsAtTime = tomorrowGroups.get(timestamp) ?? [];

				// Add all sessions with this timestamp
				result.push(...sessionsAtTime);

				// If we now have enough, stop adding
				if (result.length >= minSessionCount) {
					break;
				}
			}
		}

		// Final sort of the results - today's sessions first, then tomorrow's
		result.sort((a, b) => {
			// Today's sessions first
			const aDate = new Date(a.StartTime);
			const bDate = new Date(b.StartTime);
			const aIsToday = isSameDay(aDate, currentTime);
			const bIsToday = isSameDay(bDate, currentTime);

			if (aIsToday && !bIsToday) return -1;
			if (!aIsToday && bIsToday) return 1;

			// For same day: current sessions first
			if (a.status.isInProgress && !b.status.isInProgress) return -1;
			if (!a.status.isInProgress && b.status.isInProgress) return 1;

			// Then by start time
			return aDate.getTime() - bDate.getTime();
		});

		console.log(`Final result has ${String(result.length)} sessions`);

		// Debug information
		if (result.length > 0) {
			const firstSessionTime = new Date(result[0].StartTime);
			console.log(
				`First session: "${
					result[0].Name
				}" at ${firstSessionTime.toLocaleTimeString()}`
			);
		}

		return result;
	}, [
		schedule,
		getSessionStatus,
		groupSessionsByDay,
		groupSessionsByStartTime,
		minSessionCount,
		currentTime,
		isSameDay,
	]);

	// Check if we're using stale data (data older than 5 minutes)
	const isStaleData = useMemo(() => {
		if (!lastRefreshTime) return false;
		return Date.now() - lastRefreshTime > 5 * 60 * 1000; // 5 minutes
	}, [lastRefreshTime]);

	// Memoize context value to prevent unnecessary renders
	const contextValue = useMemo(
		() => ({
			schedule,
			isLoading: isLoading && !hasInitialLoad,
			error: !schedule ? error : null, // Only show error if we have no schedule data
			isStaleData,
			lastRefreshTime,
			refreshSchedule: fetchSchedule,
			getCurrentAndUpcomingSessions,
		}),
		[
			schedule,
			isLoading,
			error,
			isStaleData,
			lastRefreshTime,
			fetchSchedule,
			getCurrentAndUpcomingSessions,
			hasInitialLoad,
		]
	);

	return <ScheduleContext value={contextValue}>{children}</ScheduleContext>;
}
