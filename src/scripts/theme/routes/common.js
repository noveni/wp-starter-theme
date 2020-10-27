import coverModals from '../elements/coverModal';
import modalMenu from '../elements/modalMenu';
import primaryMenu from '../elements/primaryMenu';
import toggles from '../elements/toggles';

import { touchEnabled, intrinsicRatioVideos } from '../../utils/dom';

export const getHeaderHeight = () => {
  const header = document.getElementById('site-header');
  if (header) {
    return header.offsetHeight;
  }
  return 0;
}

const addHeaderHeightAsMarginToElement = (selector) => {

	const addMargin = (elementSelector) => {
		const element = document.querySelector(elementSelector);
		const headerInner = document.querySelector('#site-header .header-inner');
		const height = headerInner ? headerInner.offsetHeight : getHeaderHeight();
	
		if (element) {
			element.style.marginTop = `-${height}px`;
		}
	
	}
	
	addMargin(selector);
	window.addEventListener( 'resize', () => {
		addMargin(selector);
	});
	
}

export default {
  init() {

		let ecrannoir = ecrannoir || {};

		// Set a default value for scrolled.
		ecrannoir.scrolled = 0;

		document.documentElement.classList.remove('no-js');
		window.ecrannoir = ecrannoir;
		toggles.init();	// Handle toggles
		coverModals.init(toggles.clickedEl);	// Handle cover modals
		intrinsicRatioVideos();	// Retain aspect ratio of videos on window resize
		modalMenu.init(toggles.clickedEl);	// Modal Menu
		primaryMenu();	// Primary Menu
		touchEnabled();	// Add class to body if device is touch-enabled

		// addHeaderHeightAsMarginToElement('#site-content');

	},
	finalize() {
	}
}
