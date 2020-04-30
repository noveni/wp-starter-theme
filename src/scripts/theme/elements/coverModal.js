
export default {
  init: function() {
    if ( document.querySelector( '.cover-modal' ) ) {
      // Handle cover modals when they're toggled
      this.onToggle();

      // When toggled, untoggle if visitor clicks on the wrapping element of the modal
      this.outsideUntoggle();

      // Close on escape key press
      this.closeOnEscape();

      // Hide and show modals before and after their animations have played out
      this.hideAndShowModals();
    }
  },

  // Handle cover modals when they're toggled
  onToggle: function() {
    document.querySelectorAll( '.cover-modal' ).forEach( function( element ) {
      element.addEventListener( 'toggled', function( event ) {
        var modal = event.target,
          body = document.body;

        if ( modal.classList.contains( 'active' ) ) {
          body.classList.add( 'showing-modal' );
        } else {
          body.classList.remove( 'showing-modal' );
          body.classList.add( 'hiding-modal' );

          // Remove the hiding class after a delay, when animations have been run
          setTimeout( function() {
            body.classList.remove( 'hiding-modal' );
          }, 500 );
        }
      } );
    } );
  },
  // Close modal on outside click
  outsideUntoggle: function() {
    document.addEventListener( 'click', function( event ) {
      var target = event.target;
      var modal = document.querySelector( '.cover-modal.active' );

      if ( target === modal ) {
        this.untoggleModal( target );
      }
    }.bind( this ) );
  },

  // Close modal on escape key press
  closeOnEscape: function() {
    document.addEventListener( 'keydown', function( event ) {
      if ( event.keyCode === 27 ) {
        event.preventDefault();
        document.querySelectorAll( '.cover-modal.active' ).forEach( function( element ) {
          this.untoggleModal( element );
        }.bind( this ) );
      }
    }.bind( this ) );
  },

  // Hide and show modals before and after their animations have played out
  hideAndShowModals: function() {
    const _doc = document,
      _win = window,
      modals = _doc.querySelectorAll( '.cover-modal' ),
      htmlStyle = _doc.documentElement.style,
      adminBar = _doc.querySelector( '#wpadminbar' );

    function getAdminBarHeight( negativeValue ) {
      var height,
        currentScroll = _win.pageYOffset;

      if ( adminBar ) {
        height = currentScroll + adminBar.getBoundingClientRect().height;

        return negativeValue ? -height : height;
      }

      return currentScroll === 0 ? 0 : -currentScroll;
    }

    function htmlStyles() {
      var overflow = _win.innerHeight > _doc.documentElement.getBoundingClientRect().height;

      return {
        'overflow-y': overflow ? 'hidden' : 'scroll',
        position: 'fixed',
        width: '100%',
        top: getAdminBarHeight( true ) + 'px',
        left: 0
      };
    }
    // Show the modal
    modals.forEach( function( modal ) {

      modal.addEventListener( 'toggle-target-before-inactive', function( event ) {
        var styles = htmlStyles(),
          offsetY = _win.pageYOffset,
          paddingTop = ( Math.abs( getAdminBarHeight() ) - offsetY ) + 'px',
          mQuery = _win.matchMedia( '(max-width: 600px)' );

        if ( event.target !== modal ) {
          return;
        }

        Object.keys( styles ).forEach( function( styleKey ) {
          htmlStyle.setProperty( styleKey, styles[ styleKey ] );
        } );

        _win.ecrannoir.scrolled = parseInt( styles.top, 10 );

        if ( adminBar ) {
          _doc.body.style.setProperty( 'padding-top', paddingTop );

          if ( mQuery.matches ) {
            if ( offsetY >= getAdminBarHeight() ) {
              modal.style.setProperty( 'top', 0 );
            } else {
              modal.style.setProperty( 'top', ( getAdminBarHeight() - offsetY ) + 'px' );
            }
          }
        }

        modal.classList.add( 'show-modal' );
      } );

      // Hide the modal after a delay, so animations have time to play out
      modal.addEventListener( 'toggle-target-after-inactive', function( event ) {
        if ( event.target !== modal ) {
          return;
        }

        setTimeout( function() {
          var clickedEl = ecrannoir.toggles.clickedEl;

          modal.classList.remove( 'show-modal' );

          Object.keys( htmlStyles() ).forEach( function( styleKey ) {
            htmlStyle.removeProperty( styleKey );
          } );

          if ( adminBar ) {
            _doc.body.style.removeProperty( 'padding-top' );
            modal.style.removeProperty( 'top' );
          }

          if ( clickedEl !== false ) {
            clickedEl.focus();
            clickedEl = false;
          }

          _win.scrollTo( 0, Math.abs( _win.ecrannoir.scrolled + getAdminBarHeight() ) );

          _win.ecrannoir.scrolled = 0;
        }, 500 );
      } );
    } );
  },

  // Untoggle a modal
  untoggleModal: function( modal ) {
    var modalTargetClass,
      modalToggle = false;

    // If the modal has specified the string (ID or class) used by toggles to target it, untoggle the toggles with that target string
    // The modal-target-string must match the string toggles use to target the modal
    if ( modal.dataset.modalTargetString ) {
      modalTargetClass = modal.dataset.modalTargetString;

      modalToggle = document.querySelector( '*[data-toggle-target="' + modalTargetClass + '"]' );
    }

    // If a modal toggle exists, trigger it so all of the toggle options are included
    if ( modalToggle ) {
      modalToggle.click();

      // If one doesn't exist, just hide the modal
    } else {
      modal.classList.remove( 'active' );
    }
  },
  
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
