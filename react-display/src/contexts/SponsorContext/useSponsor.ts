// react-display/src/contexts/SponsorContext/useSponsor.ts

import React from 'react';
import { SponsorContext } from './sponsorContext';
import { SponsorContextType } from './types';

// Custom hook to use the SponsorContext
export function useSponsor(): SponsorContextType {
	// Using React 19's 'use' API for context
	const context = React.use(SponsorContext);

	if (context === undefined) {
		throw new Error('useSponsor must be used within a SponsorProvider');
	}

	return context;
}
