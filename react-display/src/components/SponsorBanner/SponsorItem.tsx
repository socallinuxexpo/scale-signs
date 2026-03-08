// react-display/src/components/SponsorBanner/SponsorItem.tsx

import { useState, useEffect, useRef } from 'react';
import nocPenguin from '../../assets/noc-penguin.png';

interface SponsorItemProps {
	url: string;
	index: number; // Added index to help with unique identification
}

export function SponsorItem({ url, index }: SponsorItemProps) {
	const [currentUrl, setCurrentUrl] = useState(url);
	const [prevUrl, setPrevUrl] = useState<string | null>(null);
	const [loaded, setLoaded] = useState(false);
	const timeoutRef = useRef<number | null>(null);

	useEffect(() => {
		if (url !== currentUrl) {
			// When a new URL is received, set the current one as previous
			setPrevUrl(currentUrl);
			setCurrentUrl(url);
			setLoaded(false);

			// Clear any existing timeout to prevent memory leaks
			if (timeoutRef.current !== null) {
				clearTimeout(timeoutRef.current);
			}

			// Clear previous after the fade duration (800ms)
			timeoutRef.current = window.setTimeout(() => {
				setPrevUrl(null);
				timeoutRef.current = null;
			}, 800);
		}

		// Cleanup on unmount or when URL changes
		return () => {
			if (timeoutRef.current !== null) {
				clearTimeout(timeoutRef.current);
			}
		};
	}, [url, currentUrl]);

	// Key the image with both URL and index to ensure proper re-rendering
	const imageKey = `${String(index)}-${
		currentUrl.split('/').pop() ?? currentUrl
	}`;
	const prevImageKey = prevUrl
		? `prev-${String(index)}-${prevUrl.split('/').pop() ?? prevUrl}`
		: null;

	return (
		<div className='relative w-full aspect-square bg-white rounded-md shadow-sm overflow-hidden transition-transform'>
			{/* Render previous image for fade-out, if available */}
			{prevUrl && (
				<img
					key={prevImageKey}
					src={prevUrl}
					alt='Sponsor fading out'
					className='absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-800 z-10'
					onError={(e) => {
						const target = e.target as HTMLImageElement;
						target.src = nocPenguin;
						target.alt = 'Sponsor (image unavailable)';
					}}
				/>
			)}
			<img
				key={imageKey}
				src={currentUrl}
				alt='Sponsor'
				className={`absolute inset-0 w-full h-full object-contain transition-opacity duration-800 ${
					loaded ? 'opacity-100 z-20' : 'opacity-0'
				}`}
				onLoad={() => {
					setLoaded(true);
				}}
				onError={(e) => {
					const target = e.target as HTMLImageElement;
					target.src = nocPenguin;
					target.alt = 'Sponsor (image unavailable)';
					setLoaded(true);
				}}
			/>
			{/* Hidden preloading of fallback image */}
			<div className='hidden'>
				<img
					src={nocPenguin}
					alt='preload nocPenguin'
				/>
			</div>
		</div>
	);
}
