// react-display/src/components/ScheduleCarousel/ScheduleItem.tsx

import { SessionWithStatus } from '../../contexts/ScheduleContext/types';
import { useTime } from '../../contexts/TimeContext';

interface ScheduleItemProps {
	session: SessionWithStatus;
	isEmpty?: boolean;
}

export function ScheduleItem({ session, isEmpty = false }: ScheduleItemProps) {
	const { currentTime } = useTime();

	// Skip rendering details for empty placeholders
	if (isEmpty || !session.Name) {
		return (
			<div className='rounded-md p-4 mb-2 transition-all duration-300 bg-black/20'></div>
		);
	}

	// Format the time for display
	const formatTime = (timeString: string): string => {
		const date = new Date(timeString);
		return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
	};

	// Check if session is tomorrow
	const isTomorrow = (): boolean => {
		const today = new Date(currentTime);
		today.setHours(0, 0, 0, 0); // Start of today

		const tomorrow = new Date(today);
		tomorrow.setDate(tomorrow.getDate() + 1); // Start of tomorrow

		const sessionDate = new Date(session.StartTime);
		sessionDate.setHours(0, 0, 0, 0); // Start of session day

		return sessionDate.getTime() === tomorrow.getTime();
	};

	// Check if this is a keynote session by topic only
	const isKeynote = (): boolean => {
		// Only check the topic field
		return session.Topic.toLowerCase().includes('keynote');
	};

	// Determine background color based on keynote status
	const bgColor = isKeynote() ? 'bg-[#2c2c42]' : 'bg-[#212121]';

	// Apply keynote visual effects
	const keynoteClasses = isKeynote()
		? 'transform translate-y-[-2px] shadow-lg ring-2 ring-yellow-300 ring-opacity-50'
		: '';

	return (
		<div
			className={`rounded-md p-2 mb-2 transition-all duration-300 ${bgColor} text-white ${keynoteClasses}`}
		>
			<div className='flex justify-between items-start'>
				{/* Left side - Session title and time */}
				<div className='flex-1 pr-4'>
					<div className='text-2xl font-bold text-white mb-1 line-clamp-2 px-2'>
						{session.Name}
					</div>

					{/* Speakers and topic in a row */}
					<div className='flex flex-wrap mt-1 text-xl px-2 py-2'>
						{session.Topic && (
							<span className='bg-[#02bfe7] font-bold text-[#212121] px-2 py-1 rounded-md mr-2 whitespace-nowrap flex-shrink-0'>
								{session.Topic}
							</span>
						)}
						{/* Speaker names */}
						<span className='text-xl text-white font-bold italic mb-1 break-words py-1'>
							{session.Speakers}
						</span>
					</div>
				</div>

				{/* Right side - Room, status, and time */}
				<div className='flex flex-col items-end min-w-[180px] py-1'>
					{/* Status indicator */}
					{session.status.isInProgress && (
						<span className='text-xl font-bold py-1 px-4 rounded-md whitespace-nowrap bg-[#2e8540] text-white mb-1'>
							In Progress
						</span>
					)}
					{session.status.isStartingSoon && (
						<span className='text-xl font-bold py-1 px-4 rounded-md whitespace-nowrap bg-[#f9c642] text-[#212121] mb-1 animate-pulse'>
							Starting in {String(session.status.minutesUntilStart)} min
						</span>
					)}
					{!session.status.isInProgress &&
						!session.status.isStartingSoon &&
						isTomorrow() && (
							<span className='text-xl font-bold py-1 px-4 rounded-md whitespace-nowrap bg-[#f9dede] text-[#212121] mb-1'>
								Tomorrow
							</span>
						)}
					{!session.status.isInProgress &&
						!session.status.isStartingSoon &&
						!isTomorrow() && (
							<span className='text-xl font-bold py-1 px-4 rounded-md whitespace-nowrap bg-[#205493] text-white mb-1'>
								{session.status.minutesUntilStart > 59
									? 'Upcoming'
									: `Upcoming in ${String(
											session.status.minutesUntilStart
									  )} min`}
							</span>
						)}

					{/* Room and time in a row */}
					<div className='flex justify-end mt-1 text-xl mt-auto py-2'>
						<span className='text-white text-l font-bold px-4 py-1'>
							{formatTime(session.StartTime)} - {formatTime(session.EndTime)}
						</span>
						<span className='bg-[#dce4ef] text-[#212121] font-bold px-4 py-1 rounded-md'>
							{session.Location}
						</span>
					</div>
				</div>
			</div>
		</div>
	);
}
