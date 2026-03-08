// react-display/src/components/Header/Header.tsx

import { Clock } from '../Clock';
import scaleLogo from '../../assets/logo.png';
import scaleWifi from '../../assets/wifi.png';

export function Header() {
	return (
		<header className='w-full bg-white shadow-md flex justify-between items-center h-[10vh] py-2 px-2 p-2'>
			<div className='flex items-center'>
				<img
					src={scaleLogo}
					className='h-16 mr-4'
					alt='SCaLE Logo'
				/>
			</div>

			<Clock />

			<div className='flex items-center'>
				<img
					src={scaleWifi}
					className='h-16 ml-4'
					alt='WiFi Information'
				/>
			</div>
		</header>
	);
}
