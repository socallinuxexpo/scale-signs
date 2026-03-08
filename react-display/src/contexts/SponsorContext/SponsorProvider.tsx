// react-display/src/contexts/SponsorContext/SponsorProvider.tsx

import React, { useState, useEffect, useCallback, useRef } from 'react';
import { SponsorContext } from './sponsorContext';

export function SponsorProvider({ children }: { children: React.ReactNode }) {
	const [sponsorImages, setSponsorImages] = useState<string[]>([]);
	const [isLoading, setIsLoading] = useState<boolean>(true);
	const [error, setError] = useState<Error | null>(null);

	// Use a ref for used images instead of state
	const usedImagesRef = useRef<Set<string>>(new Set());

	const fetchSponsorImages = useCallback(async () => {
		setIsLoading(true);
		setError(null);
		try {
			const response = await fetch('/sponsors/all');
			if (!response.ok) {
				throw new Error(
					`Failed to fetch sponsors: ${String(response.status)} ${
						response.statusText
					}`
				);
			}
			const data: unknown = await response.json();
			if (!Array.isArray(data)) {
				throw new Error(
					'Expected an array of strings but received a different data structure'
				);
			}
			const images = data.filter(
				(item): item is string => typeof item === 'string'
			);
			setSponsorImages(images);
			// Reset the used images ref when new data comes in
			usedImagesRef.current = new Set();
		} catch (err) {
			console.error('Error fetching sponsor images:', err);
			setError(err instanceof Error ? err : new Error(String(err)));
		} finally {
			setIsLoading(false);
		}
	}, []);

	useEffect(() => {
		void fetchSponsorImages();
	}, [fetchSponsorImages]);

	const getRandomSponsorUrl = useCallback((): string => {
		if (sponsorImages.length === 0) {
			return ''; // No images available
		}

		// If all images have been used, reset the ref
		if (usedImagesRef.current.size >= sponsorImages.length) {
			usedImagesRef.current = new Set();
		}

		// Filter images that haven’t been used
		const availableImages = sponsorImages.filter(
			(img) => !usedImagesRef.current.has(img)
		);
		const imagePool =
			availableImages.length > 0 ? availableImages : sponsorImages;

		// Pick a random image
		const randomIndex = Math.floor(Math.random() * imagePool.length);
		const selectedImage = imagePool[randomIndex];

		// Update the ref with the selected image
		usedImagesRef.current.add(selectedImage);

		return `/sponsors/images/${selectedImage}`;
	}, [sponsorImages]);

	const getRandomSponsorUrls = useCallback(
		(count: number): string[] => {
			const safeCount = Math.min(count, sponsorImages.length);
			const urls: string[] = [];
			for (let i = 0; i < safeCount; i++) {
				urls.push(getRandomSponsorUrl());
			}
			return urls;
		},
		[getRandomSponsorUrl, sponsorImages.length]
	);

	const getAllSponsorUrls = useCallback((): string[] => {
		return sponsorImages.map((img) => `/sponsors/images/${img}`);
	}, [sponsorImages]);

	const contextValue = React.useMemo(
		() => ({
			getRandomSponsorUrl,
			getRandomSponsorUrls,
			refreshSponsors: fetchSponsorImages,
			getAllSponsorUrls,
			isLoading,
			error,
		}),
		[
			getRandomSponsorUrl,
			getRandomSponsorUrls,
			fetchSponsorImages,
			getAllSponsorUrls,
			isLoading,
			error,
		]
	);

	return <SponsorContext value={contextValue}>{children}</SponsorContext>;
}
