// react-display/src/components/ScheduleCarousel/ScheduleCarousel.tsx

import { useState, useEffect, useRef } from 'react';
import { useSchedule } from '../../contexts/ScheduleContext';
import { SessionWithStatus } from '../../contexts/ScheduleContext/types';
import { useTime } from '../../contexts/TimeContext';
import { Spinner } from '../Spinner';
import { ScheduleItem } from './ScheduleItem';

interface ScheduleCarouselProps {
	maxDisplay?: number;
	rotationInterval?: number; // in milliseconds
	autoRotate?: boolean;
}

export function ScheduleCarousel({
	maxDisplay = 6,
	rotationInterval = 10000, // 10 seconds
	autoRotate = true,
}: ScheduleCarouselProps) {
	const { isLoading, error, getCurrentAndUpcomingSessions } = useSchedule();
	const { currentTime } = useTime();
	const [sessions, setSessions] = useState<SessionWithStatus[]>([]);
	const [startIndex, setStartIndex] = useState(0);
	const lastRefreshTime = useRef<number>(0);

	const showLoading = isLoading || (sessions.length === 0 && !error);

	// Update sessions when the schedule or current time changes
	useEffect(() => {
		// On initial mount or when sessions are empty, immediately load data
		if (sessions.length === 0) {
			const currentAndUpcoming = getCurrentAndUpcomingSessions();
			setSessions(currentAndUpcoming);
			lastRefreshTime.current = Date.now();
			return;
		}

		// For subsequent updates, only refresh if it's been at least 1 minute
		const now = Date.now();
		if (now - lastRefreshTime.current > 60000) {
			// 1 minute
			const currentAndUpcoming = getCurrentAndUpcomingSessions();
			setSessions(currentAndUpcoming);
			// Only reset start index if we have a completely different set of sessions
			if (currentAndUpcoming.length !== sessions.length) {
				setStartIndex(0);
			}
			lastRefreshTime.current = now;
		}
	}, [getCurrentAndUpcomingSessions, currentTime, sessions.length]);

	// Auto-rotate through sessions
	useEffect(() => {
		if (!autoRotate || sessions.length <= maxDisplay) {
			return;
		}

		const rotationTimer = setInterval(() => {
			setStartIndex((prevIndex) => {
				// Calculate the next starting index, with wrap-around
				const nextIndex = prevIndex + maxDisplay;
				return nextIndex >= sessions.length ? 0 : nextIndex;
			});
		}, rotationInterval);

		return () => {
			clearInterval(rotationTimer);
		};
	}, [autoRotate, rotationInterval, sessions.length, maxDisplay]);

	// Calculate the slice of sessions to display, ensure we don't exceed array bounds
	const displaySessions =
		sessions.length > 0
			? sessions.slice(
					Math.min(startIndex, Math.max(0, sessions.length - 1)),
					Math.min(startIndex + maxDisplay, sessions.length)
			  )
			: [];

	// Create a placeholder session object
	const emptySession = (): SessionWithStatus => ({
		Name: '',
		Description: '',
		Location: '',
		StartTime: new Date().toISOString(),
		EndTime: new Date().toISOString(),
		Speakers: '',
		Topic: '',
		status: {
			isInProgress: false,
			isStartingSoon: false,
			isPast: false,
			minutesRemaining: 0,
			minutesUntilStart: 0,
		},
	});

	// Create padded array with empty sessions as needed
	const paddedSessions = [...displaySessions];
	while (paddedSessions.length < maxDisplay) {
		paddedSessions.push(emptySession());
	}

	return (
		<div className='bg-[#aeb0b5] w-full h-full rounded-lg overflow-hidden px-6 p-4'>
			{/* Main content container */}
			<div className='w-full h-full flex flex-col justify-between'>
				{showLoading ? (
					<div className='flex items-center justify-center h-full'>
						<div className='flex flex-col items-center text-gray-300'>
							<Spinner
								size='lg'
								className='text-white mb-4'
							/>
							<div className='text-lg'>Loading schedule...</div>
						</div>
					</div>
				) : error ? (
					<div className='flex items-center justify-center h-full'>
						<div className='text-lg text-red-400 animate-bounce'>
							Failed to load schedule: {error.message}
						</div>
					</div>
				) : sessions.length === 0 ? (
					<div className='flex items-center justify-center h-full'>
						<div className='text-lg text-gray-400 italic'>
							No current or upcoming sessions found.
						</div>
					</div>
				) : (
					// Display each session card with equal spacing
					<div className='flex flex-col justify-between h-full'>
						{paddedSessions.map((session, index) => (
							<ScheduleItem
								key={`session-${String(index)}-${
									session.Name ? encodeURIComponent(session.Name) : 'empty'
								}`}
								session={session}
								isEmpty={!session.Name}
							/>
						))}
					</div>
				)}
			</div>
		</div>
	);
}
