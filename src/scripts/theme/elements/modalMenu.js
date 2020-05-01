
import { ecrannoirFindParents } from '../../utils/dom'

export default {
  clickedEl: false,
  init: function(togglesClickedEl) {
    this.clickedEl = togglesClickedEl;
    // If the current menu item is in a sub level, expand all the levels higher up on load
    this.expandLevel();
    this.keepFocusInModal();
  },
  expandLevel: function() {
    var modalMenus = document.querySelectorAll( '.modal-menu' );

    modalMenus.forEach( function( modalMenu ) {
      var activeMenuItem = modalMenu.querySelector( '.current-menu-item' );

      if ( activeMenuItem ) {
        const activeMenuItemParents = ecrannoirFindParents( activeMenuItem, 'li' );
        activeMenuItemParents.forEach( function( element ) {
          var subMenuToggle = element.querySelector( '.sub-menu-toggle' );
          if ( subMenuToggle ) {
            ecrannoir.toggles.performToggle( subMenuToggle, true );
          }
        } );
      }
    } );
  },

  keepFocusInModal: function() {
    var _doc = document;
    
    _doc.addEventListener( 'keydown', ( event ) => {
      var toggleTarget, modal, selectors, elements, menuType, bottomMenu, activeEl, lastEl, firstEl, tabKey, shiftKey,
        clickedEl = this.clickedEl;

      if ( clickedEl && _doc.body.classList.contains( 'showing-modal' ) ) {
        toggleTarget = clickedEl.dataset.toggleTarget;
        selectors = 'input, a, button';
        modal = _doc.querySelector( toggleTarget );

        elements = modal.querySelectorAll( selectors );
        elements = Array.prototype.slice.call( elements );

        if ( '.menu-modal' === toggleTarget ) {
          menuType = window.matchMedia( '(min-width: 1000px)' ).matches;
          menuType = menuType ? '.expanded-menu' : '.mobile-menu';

          elements = elements.filter( function( element ) {
            return null !== element.closest( menuType ) && null !== element.offsetParent;
          } );

          elements.unshift( _doc.querySelector( '.close-nav-toggle' ) );

          bottomMenu = _doc.querySelector( '.menu-bottom > nav' );

          if ( bottomMenu ) {
            bottomMenu.querySelectorAll( selectors ).forEach( function( element ) {
              elements.push( element );
            } );
          }
        }

        lastEl = elements[ elements.length - 1 ];
        firstEl = elements[0];
        activeEl = _doc.activeElement;
        tabKey = event.keyCode === 9;
        shiftKey = event.shiftKey;

        if ( ! shiftKey && tabKey && lastEl === activeEl ) {
          event.preventDefault();
          firstEl.focus();
        }

        if ( shiftKey && tabKey && firstEl === activeEl ) {
          event.preventDefault();
          lastEl.focus();
        }
      }
    } );
  }
}
