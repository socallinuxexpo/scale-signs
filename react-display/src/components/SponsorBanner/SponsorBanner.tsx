// react-display/src/components/SponsorBanner/SponsorBanner.tsx

import { useState, useEffect, useRef } from 'react';
import { useSponsor } from '../../contexts/SponsorContext';
import { SponsorItem } from './SponsorItem';

interface SponsorBannerProps {
	displayCount?: number;
	rotationInterval?: number;
}

export function SponsorBanner({
	displayCount = 3,
	rotationInterval = 10000,
}: SponsorBannerProps) {
	const { getRandomSponsorUrls, isLoading, error } = useSponsor();
	const [sponsorUrls, setSponsorUrls] = useState<string[]>([]);
	const rotationTimerRef = useRef<number | null>(null);

	// Initialize with random sponsor images
	useEffect(() => {
		if (!isLoading && !error) {
			setSponsorUrls(getRandomSponsorUrls(displayCount));
		}
	}, [isLoading, error, getRandomSponsorUrls, displayCount]);

	// Rotate sponsors at the specified interval
	useEffect(() => {
		if (isLoading || error) return;

		// Clear any existing timer when rotation interval or dependencies change
		if (rotationTimerRef.current !== null) {
			clearInterval(rotationTimerRef.current);
		}

		// Set up new rotation timer
		rotationTimerRef.current = window.setInterval(() => {
			setSponsorUrls(getRandomSponsorUrls(displayCount));
		}, rotationInterval);

		// Cleanup on unmount
		return () => {
			if (rotationTimerRef.current !== null) {
				clearInterval(rotationTimerRef.current);
				rotationTimerRef.current = null;
			}
		};
	}, [isLoading, error, getRandomSponsorUrls, displayCount, rotationInterval]);

	if (isLoading) {
		return (
			<div className='h-full w-full p-4 text-center bg-gray-100 rounded-lg flex items-center justify-center'>
				Loading sponsors...
			</div>
		);
	}

	if (error) {
		return (
			<div className='h-full w-full p-4 text-center bg-red-100 text-red-800 rounded-lg flex items-center justify-center'>
				Failed to load sponsors: {error.message}
			</div>
		);
	}

	return (
		<div className='h-full w-full bg-[#aeb0b5] rounded-lg p-4 shadow-md'>
			<div className='flex flex-col justify-around items-center h-full gap-4'>
				{sponsorUrls.map((url, index) => (
					<div
						key={`${String(index)}-${url.split('/').pop() ?? url}`}
						className='w-full max-w-[200px] mx-auto'
					>
						<SponsorItem
							url={url}
							index={index}
						/>
					</div>
				))}
			</div>
		</div>
	);
}
