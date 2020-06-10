import 'styles/popup/index.scss';

import { ecrannoirDomReady } from 'scripts/utils/dom';

const modalTargetClass = ".popup-modal";

ecrannoirDomReady(() => {
  const popupModal = document.querySelectorAll( '.popup-modal' )
  const modalToggle = document.querySelector( '*[data-toggle-target="' + modalTargetClass + '"]' );
  if (modalToggle) {
    setTimeout( () => {
      modalToggle.click();
    }, 500 );
  }
})

