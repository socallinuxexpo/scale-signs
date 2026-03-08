// react-display/src/contexts/SponsorContext/sponsorContext.ts

import { createContext } from 'react';
import { SponsorContextType } from './types';

// Create a context with undefined as default value
// The actual implementation will be provided by SponsorProvider
export const SponsorContext = createContext<SponsorContextType | undefined>(
	undefined
);
