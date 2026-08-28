// react-display/src/components/SponsorBanner/SponsorBanner.tsx

import { useState, useEffect } from 'react';
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
	const { isLoading, error } = useSponsor();

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
		<SponsorRotation
			displayCount={displayCount}
			rotationInterval={rotationInterval}
		/>
	);
}

// A fixed on-screen position that shows a (rotating) sponsor image
interface SponsorSlot {
	id: number;
	url: string;
}

function pickSlots(
	getRandomSponsorUrls: (count: number) => string[],
	count: number
): SponsorSlot[] {
	return getRandomSponsorUrls(count).map((url, id) => ({ id, url }));
}

// Only rendered once the sponsor list has loaded, so the initial pick can be
// a lazy state initializer and the only setState happens in the rotation timer.
function SponsorRotation({
	displayCount,
	rotationInterval,
}: Required<SponsorBannerProps>) {
	const { getRandomSponsorUrls } = useSponsor();
	const [slots, setSlots] = useState<SponsorSlot[]>(() =>
		pickSlots(getRandomSponsorUrls, displayCount)
	);

	// Rotate sponsors at the specified interval
	useEffect(() => {
		const timerId = window.setInterval(() => {
			setSlots(pickSlots(getRandomSponsorUrls, displayCount));
		}, rotationInterval);

		return () => {
			window.clearInterval(timerId);
		};
	}, [getRandomSponsorUrls, displayCount, rotationInterval]);

	return (
		<div className='h-full w-full bg-[#aeb0b5] rounded-lg p-4 shadow-md'>
			<div className='flex flex-col justify-around items-center h-full gap-4'>
				{/* Keyed by slot position so SponsorItem persists across rotations and can cross-fade */}
				{slots.map((slot) => (
					<div
						key={slot.id}
						className='w-full max-w-[12.5rem] mx-auto'
					>
						<SponsorItem url={slot.url} />
					</div>
				))}
			</div>
		</div>
	);
}
