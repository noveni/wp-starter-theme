import coverModals from '../elements/coverModal';
import modalMenu from '../elements/modalMenu';
import primaryMenu from '../elements/primaryMenu';
import toggles from '../elements/toggles';

import { ecrannoirDomReady, touchEnabled, intrinsicRatioVideos } from '../../utils/dom';

export default {
  init() {

		let ecrannoir = ecrannoir || {};

		// Set a default value for scrolled.
		ecrannoir.scrolled = 0;

		ecrannoirDomReady( () => {
			document.documentElement.classList.remove('no-js');
			window.ecrannoir = ecrannoir;
			toggles.init();	// Handle toggles
			coverModals.init();	// Handle cover modals
			intrinsicRatioVideos();	// Retain aspect ratio of videos on window resize
			modalMenu.init();	// Modal Menu
			primaryMenu();	// Primary Menu
			touchEnabled();	// Add class to body if device is touch-enabled
		} );

	},
	finalize() {
	}
}
