/* react-display/src/components/Clock/Clock.tsx */

import { useEffect, useState } from 'react';
import { useTime } from '../../contexts/TimeContext';

export function Clock() {
	const { currentTime } = useTime();
	const [displayTime, setDisplayTime] = useState<Date>(currentTime);

	// Update local state when context time changes
	useEffect(() => {
		setDisplayTime(currentTime);
	}, [currentTime]);

	// Format the time in 12-hour format with AM/PM
	const formatTime = () => {
		const hours = displayTime.getHours();
		const minutes = displayTime.getMinutes().toString().padStart(2, '0');
		const ampm = hours >= 12 ? 'PM' : 'AM';
		const displayHours = (hours % 12 || 12).toString().padStart(2, '0'); // Convert 0 to 12 for 12 AM and pad with 0

		return `${displayHours}:${minutes} ${ampm}`;
	};

	// Format the date as Day, Month DD, YYYY
	const options: Intl.DateTimeFormatOptions = {
		weekday: 'long',
		year: 'numeric',
		month: 'long',
		day: 'numeric',
	};
	const dateString = displayTime.toLocaleDateString('en-US', options);

	return (
		<div className='bg-[#aeb0b5] bg-opacity-70 text-[#212121] p-4 rounded-lg text-center my-4 shadow-md inline-block min-w-[300px] font-mono'>
			<div className='text-4xl font-bold mb-2'>{formatTime()}</div>
			<div className='text-lg font-bold'>{dateString}</div>
		</div>
	);
}
