// react-display/src/contexts/ScheduleContext/scheduleContext.ts

import { createContext } from 'react';
import { ScheduleContextType } from './types';

// Create a context with undefined as default value
// The actual implementation will be provided by ScheduleProvider
export const ScheduleContext = createContext<ScheduleContextType | undefined>(
	undefined
);
