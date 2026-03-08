// react-display/src/contexts/SponsorContext/types.ts

export interface SponsorContextType {
	// Get a random sponsor image URL that hasn't been used in the current cycle
	getRandomSponsorUrl: () => string;

	// Get a specific number of random sponsor image URLs
	getRandomSponsorUrls: (count: number) => string[];

	// Force a refresh of the sponsor list from the server
	refreshSponsors: () => Promise<void>;

	// Get all available sponsor URLs
	getAllSponsorUrls: () => string[];

	// Check if sponsors are currently loading
	isLoading: boolean;

	// Check if there was an error loading sponsors
	error: Error | null;
}
