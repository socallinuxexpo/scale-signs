// react-display/src/components/ScheduleCarousel/ScheduleCarousel.tsx

import { useState, useEffect, useMemo } from 'react';
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
	const [startIndex, setStartIndex] = useState(0);

	// Derive the session list from the schedule and the current minute, so it is
	// recomputed at most once a minute (or immediately when the schedule changes)
	const minuteMs = Math.floor(currentTime.getTime() / 60000) * 60000;
	const sessions = useMemo(
		() => getCurrentAndUpcomingSessions(new Date(minuteMs)),
		[getCurrentAndUpcomingSessions, minuteMs]
	);

	const showLoading = isLoading || (sessions.length === 0 && !error);

	// If the list shrank under us, fall back to the first page
	const safeStartIndex = startIndex < sessions.length ? startIndex : 0;

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
					safeStartIndex,
					Math.min(safeStartIndex + maxDisplay, sessions.length)
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
