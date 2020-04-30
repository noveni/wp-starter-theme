import { createEvent } from '../../utils/dom';

/* Toggle an attribute ----------------------- */
const ecrannoirToggleAttribute = ( element, attribute, trueVal, falseVal ) => {
  if ( trueVal === undefined ) {
    trueVal = true;
  }
  if ( falseVal === undefined ) {
    falseVal = false;
  }
  if ( element.getAttribute( attribute ) !== trueVal ) {
    element.setAttribute( attribute, trueVal );
  } else {
    element.setAttribute( attribute, falseVal );
  }
}

/**
 * Toggle a menu item on or off.
 *
 * @param {HTMLElement} target
 * @param {number} duration
 */
const ecrannoirMenuToggle = ( target, duration ) => {
  var initialParentHeight, finalParentHeight, menu, menuItems, transitionListener,
    initialPositions = [],
    finalPositions = [];

  if ( ! target ) {
    return;
  }

  menu = target.closest( '.menu-wrapper' );

  // Step 1: look at the initial positions of every menu item.
  menuItems = menu.querySelectorAll( '.menu-item' );

  menuItems.forEach( function( menuItem, index ) {
    initialPositions[ index ] = { x: menuItem.offsetLeft, y: menuItem.offsetTop };
  } );
  initialParentHeight = target.parentElement.offsetHeight;

  target.classList.add( 'toggling-target' );

  // Step 2: toggle target menu item and look at the final positions of every menu item.
  target.classList.toggle( 'active' );

  menuItems.forEach( function( menuItem, index ) {
    finalPositions[ index ] = { x: menuItem.offsetLeft, y: menuItem.offsetTop };
  } );
  finalParentHeight = target.parentElement.offsetHeight;

  // Step 3: close target menu item again.
  // The whole process happens without giving the browser a chance to render, so it's invisible.
  target.classList.toggle( 'active' );

  // Step 4: prepare animation.
  // Position all the items with absolute offsets, at the same starting position.
  // Shouldn't result in any visual changes if done right.
  menu.classList.add( 'is-toggling' );
  target.classList.toggle( 'active' );
  menuItems.forEach( function( menuItem, index ) {
    var initialPosition = initialPositions[ index ];
    if ( initialPosition.y === 0 && menuItem.parentElement === target ) {
      initialPosition.y = initialParentHeight;
    }
    menuItem.style.transform = 'translate(' + initialPosition.x + 'px, ' + initialPosition.y + 'px)';
  } );

  // The double rAF is unfortunately needed, since we're toggling CSS classes, and
  // the only way to ensure layout completion here across browsers is to wait twice.
  // This just delays the start of the animation by 2 frames and is thus not an issue.
  requestAnimationFrame( function() {
    requestAnimationFrame( function() {
      // Step 5: start animation by moving everything to final position.
      // All the layout work has already happened, while we were preparing for the animation.
      // The animation now runs entirely in CSS, using cheap CSS properties (opacity and transform)
      // that don't trigger the layout or paint stages.
      menu.classList.add( 'is-animating' );
      menuItems.forEach( function( menuItem, index ) {
        var finalPosition = finalPositions[ index ];
        if ( finalPosition.y === 0 && menuItem.parentElement === target ) {
          finalPosition.y = finalParentHeight;
        }
        if ( duration !== undefined ) {
          menuItem.style.transitionDuration = duration + 'ms';
        }
        menuItem.style.transform = 'translate(' + finalPosition.x + 'px, ' + finalPosition.y + 'px)';
      } );
      if ( duration !== undefined ) {
        target.style.transitionDuration = duration + 'ms';
      }
    } );

    // Step 6: finish toggling.
    // Remove all transient classes when the animation ends.
    transitionListener = function() {
      menu.classList.remove( 'is-animating' );
      menu.classList.remove( 'is-toggling' );
      target.classList.remove( 'toggling-target' );
      menuItems.forEach( function( menuItem ) {
        menuItem.style.transform = '';
        menuItem.style.transitionDuration = '';
      } );
      target.style.transitionDuration = '';
      target.removeEventListener( 'transitionend', transitionListener );
    };

    target.addEventListener( 'transitionend', transitionListener );
  } );
}

export default {
  clickedEl: false,
  init: function() {
    // Do the toggle
    this.toggle();

    // Check for toggle/untoggle on resize
    this.resizeCheck();

    // Check for untoggle on escape key press
    this.untoggleOnEscapeKeyPress();
  },
  performToggle: function( element, instantly ) {
    var target, timeOutTime, classToToggle,
      self = this,
      _doc = document,
      // Get our targets
      toggle = element,
      targetString = toggle.dataset.toggleTarget,
      activeClass = 'active';

    // Elements to focus after modals are closed
    if ( ! _doc.querySelectorAll( '.show-modal' ).length ) {
      self.clickedEl = _doc.activeElement;
    }

    if ( targetString === 'next' ) {
      target = toggle.nextSibling;
    } else {
      target = _doc.querySelector( targetString );
    }

    // Trigger events on the toggle targets before they are toggled
    if ( target.classList.contains( activeClass ) ) {
      target.dispatchEvent( createEvent( 'toggle-target-before-active' ) );
    } else {
      target.dispatchEvent( createEvent( 'toggle-target-before-inactive' ) );
    }

    // Get the class to toggle, if specified
    classToToggle = toggle.dataset.classToToggle ? toggle.dataset.classToToggle : activeClass;

    // For cover modals, set a short timeout duration so the class animations have time to play out
    timeOutTime = 0;

    if ( target.classList.contains( 'cover-modal' ) ) {
      timeOutTime = 10;
    }

    setTimeout( function() {
      var focusElement,
        subMenued = target.classList.contains( 'sub-menu' ),
        newTarget = subMenued ? toggle.closest( '.menu-item' ).querySelector( '.sub-menu' ) : target,
        duration = toggle.dataset.toggleDuration;

      // Toggle the target of the clicked toggle
      if ( toggle.dataset.toggleType === 'slidetoggle' && ! instantly && duration !== '0' ) {
        ecrannoirMenuToggle( newTarget, duration );
      } else {
        newTarget.classList.toggle( classToToggle );
      }

      // If the toggle target is 'next', only give the clicked toggle the active class
      if ( targetString === 'next' ) {
        toggle.classList.toggle( activeClass );
      } else if ( target.classList.contains( 'sub-menu' ) ) {
        toggle.classList.toggle( activeClass );
      } else {
        // If not, toggle all toggles with this toggle target
        _doc.querySelector( '*[data-toggle-target="' + targetString + '"]' ).classList.toggle( activeClass );
        _doc.querySelector( '*[data-toggle-target="' + targetString + '"]' ).classList.toggle( 'is-active' );
      }

      // Toggle aria-expanded on the toggle
      ecrannoirToggleAttribute( toggle, 'aria-expanded', 'true', 'false' );

      if ( self.clickedEl && -1 !== toggle.getAttribute( 'class' ).indexOf( 'close-' ) ) {
        ecrannoirToggleAttribute( self.clickedEl, 'aria-expanded', 'true', 'false' );
      }

      // Toggle body class
      if ( toggle.dataset.toggleBodyClass ) {
        _doc.body.classList.toggle( toggle.dataset.toggleBodyClass );
      }

      // Check whether to set focus
      if ( toggle.dataset.setFocus ) {
        focusElement = _doc.querySelector( toggle.dataset.setFocus );

        if ( focusElement ) {
          if ( target.classList.contains( activeClass ) ) {
            focusElement.focus();
          } else {
            focusElement.blur();
          }
        }
      }

      // Trigger the toggled event on the toggle target
      target.dispatchEvent( createEvent( 'toggled' ) );

      // Trigger events on the toggle targets after they are toggled
      if ( target.classList.contains( activeClass ) ) {
        target.dispatchEvent( createEvent( 'toggle-target-after-active' ) );
      } else {
        target.dispatchEvent( createEvent( 'toggle-target-after-inactive' ) );
      }
    }, timeOutTime );
  },

  // Do the toggle
  toggle: function() {
    var self = this;

    document.querySelectorAll( '*[data-toggle-target]' ).forEach( function( element ) {
      element.addEventListener( 'click', function( event ) {
        event.preventDefault();
        self.performToggle( element );
      } );
    } );
  },

  // Check for toggle/untoggle on screen resize
  resizeCheck: function() {
    if ( document.querySelectorAll( '*[data-untoggle-above], *[data-untoggle-below], *[data-toggle-above], *[data-toggle-below]' ).length ) {
      window.addEventListener( 'resize', function() {
        var winWidth = window.innerWidth,
          toggles = document.querySelectorAll( '.toggle' );

        toggles.forEach( function( toggle ) {
          var unToggleAbove = toggle.dataset.untoggleAbove,
            unToggleBelow = toggle.dataset.untoggleBelow,
            toggleAbove = toggle.dataset.toggleAbove,
            toggleBelow = toggle.dataset.toggleBelow;

          // If no width comparison is set, continue
          if ( ! unToggleAbove && ! unToggleBelow && ! toggleAbove && ! toggleBelow ) {
            return;
          }

          // If the toggle width comparison is true, toggle the toggle
          if (
            ( ( ( unToggleAbove && winWidth > unToggleAbove ) ||
              ( unToggleBelow && winWidth < unToggleBelow ) ) &&
              toggle.classList.contains( 'active' ) ) ||
            ( ( ( toggleAbove && winWidth > toggleAbove ) ||
              ( toggleBelow && winWidth < toggleBelow ) ) &&
              ! toggle.classList.contains( 'active' ) )
          ) {
            toggle.click();
          }
        } );
      } );
    }
  },

  // Close toggle on escape key press
  untoggleOnEscapeKeyPress: function() {
    document.addEventListener( 'keyup', function( event ) {
      if ( event.key === 'Escape' ) {
        document.querySelectorAll( '*[data-untoggle-on-escape].active' ).forEach( function( element ) {
          if ( element.classList.contains( 'active' ) ) {
            element.click();
          }
        } );
      }
    } );
  }
}
