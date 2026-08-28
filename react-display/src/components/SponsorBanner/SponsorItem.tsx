// react-display/src/components/SponsorBanner/SponsorItem.tsx

import { useState, useEffect } from 'react';
import nocPenguin from '../../assets/noc-penguin.png';

interface SponsorItemProps {
	url: string;
}

// Must match the Tailwind duration-800 on the image layers
const FADE_DURATION_MS = 800;

export function SponsorItem({ url }: SponsorItemProps) {
	const [currentUrl, setCurrentUrl] = useState(url);
	const [prevUrl, setPrevUrl] = useState<string | null>(null);
	const [loaded, setLoaded] = useState(false);

	// When a new URL arrives, keep the old one around so it can fade out
	// (https://react.dev/learn/you-might-not-need-an-effect#adjusting-some-state-when-a-prop-changes)
	if (url !== currentUrl) {
		setPrevUrl(currentUrl);
		setCurrentUrl(url);
		setLoaded(false);
	}

	// Drop the outgoing image once its fade-out has finished
	useEffect(() => {
		if (prevUrl === null) return;

		const timeoutId = window.setTimeout(() => {
			setPrevUrl(null);
		}, FADE_DURATION_MS);

		return () => {
			window.clearTimeout(timeoutId);
		};
	}, [prevUrl]);

	// Both layers live in one keyed list so the outgoing <img> keeps its DOM node
	// and actually transitions from opacity-100 to opacity-0.
	const layers = [
		...(prevUrl !== null ? [{ url: prevUrl, visible: false }] : []),
		{ url: currentUrl, visible: loaded },
	];

	return (
		<div className='relative w-full aspect-square bg-white rounded-md shadow-sm overflow-hidden transition-transform'>
			{layers.map((layer) => (
				<img
					key={layer.url}
					src={layer.url}
					alt={layer.url === currentUrl ? 'Sponsor' : 'Sponsor fading out'}
					className={`absolute inset-0 w-full h-full object-contain transition-opacity duration-800 ${
						layer.visible ? 'opacity-100 z-20' : 'opacity-0 z-10'
					}`}
					onLoad={() => {
						if (layer.url === currentUrl) {
							setLoaded(true);
						}
					}}
					onError={(e) => {
						const target = e.currentTarget;
						target.src = nocPenguin;
						target.alt = 'Sponsor (image unavailable)';
						if (layer.url === currentUrl) {
							setLoaded(true);
						}
					}}
				/>
			))}
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
