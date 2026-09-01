// react-display/src/contexts/TimeContext/TimeProvider.tsx

import { useState, useEffect, useMemo } from 'react';
import { TimeContext } from './timeContext';

interface TimeProviderProps {
	children: React.ReactNode;
}

// Get initial time based on URL parameters or current time
function getInitialTime(now: Date): Date {
	const params = new URLSearchParams(window.location.search);

	const year = parseInt(params.get('year') ?? '', 10);
	const month = parseInt(params.get('month') ?? '', 10);
	const day = parseInt(params.get('day') ?? '', 10);
	const hour = parseInt(params.get('hour') ?? '', 10);
	const minute = parseInt(params.get('minute') ?? '', 10);

	return new Date(
		isNaN(year) ? now.getFullYear() : year,
		isNaN(month) ? now.getMonth() : month - 1, // 0-indexed month
		isNaN(day) ? now.getDate() : day,
		isNaN(hour) ? now.getHours() : hour,
		isNaN(minute) ? now.getMinutes() : minute,
		now.getSeconds()
	);
}

// Offset between the (possibly URL-shifted) display time and the wall clock.
// It only depends on the page URL, so it is fixed for the lifetime of the page.
const TIME_OFFSET_MS = (() => {
	const now = new Date();
	return getInitialTime(now).getTime() - now.getTime();
})();

const shiftedNow = (): Date => new Date(Date.now() + TIME_OFFSET_MS);

export function TimeProvider({ children }: TimeProviderProps) {
	const [currentTime, setCurrentTime] = useState<Date>(shiftedNow);

	useEffect(() => {
		const intervalId = window.setInterval(() => {
			setCurrentTime(shiftedNow());
		}, 1000);

		return () => {
			window.clearInterval(intervalId);
		};
	}, []);

	// Memoize the context value to prevent unnecessary renders
	const contextValue = useMemo(() => ({ currentTime }), [currentTime]);

	return <TimeContext value={contextValue}>{children}</TimeContext>;
}
