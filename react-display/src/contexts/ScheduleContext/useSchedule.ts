// react-display/src/contexts/ScheduleContext/useSchedule.ts

import React from 'react';
import { ScheduleContext } from './scheduleContext';
import { ScheduleContextType } from './types';

// Create a custom hook to use the Schedule context
export function useSchedule(): ScheduleContextType {
	// Using React 19's 'use' API for context
	const context = React.use(ScheduleContext);

	if (context === undefined) {
		throw new Error('useSchedule must be used within a ScheduleProvider');
	}

	return context;
}
