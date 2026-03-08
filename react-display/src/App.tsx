// react-display/src/App.tsx

import { TimeProvider } from './contexts/TimeContext';
import { SponsorProvider } from './contexts/SponsorContext';
import { ScheduleProvider } from './contexts/ScheduleContext';
import { Header } from './components/Header';
import { SponsorBanner } from './components/SponsorBanner';
import { ScheduleCarousel } from './components/ScheduleCarousel';

function App() {
	return (
		<div className='flex flex-col h-screen w-full overflow-hidden'>
			<TimeProvider>
				{/* Header with logo, clock and wifi info */}
				<Header />

				<div className='flex flex-1 bg-white overflow-hidden'>
					{/* Main content area - 80% width */}
					<div className='w-4/5 p-2 overflow-y-auto'>
						{/* Schedule Carousel showing current and upcoming sessions */}
						<ScheduleProvider refreshInterval={60000}>
							<ScheduleCarousel
								maxDisplay={6}
								rotationInterval={15000}
							/>
						</ScheduleProvider>
					</div>

					{/* Sponsor banner - 20% width, vertically aligned */}
					<div className='w-1/5 p-2'>
						<SponsorProvider>
							<SponsorBanner
								displayCount={3}
								rotationInterval={10000}
							/>
						</SponsorProvider>
					</div>
				</div>
			</TimeProvider>
		</div>
	);
}

export default App;
