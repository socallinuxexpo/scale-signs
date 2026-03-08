// react-display/src/contexts/TimeContext/useTime.ts

import React from 'react';
import { TimeContext } from './timeContext';
import { TimeContextType } from './types';

// Create a custom hook to use the time context
export function useTime(): TimeContextType {
	// Using React 19's 'use' API for context
	const context = React.use(TimeContext);

	if (context === undefined) {
		throw new Error('useTime must be used within a TimeProvider');
	}

	return context;
}
