// react-display/src/contexts/TimeContext/timeContext.ts

import { createContext } from 'react';
import { TimeContextType } from './types';

// Create the context with an undefined default value
export const TimeContext = createContext<TimeContextType | undefined>(
	undefined
);
