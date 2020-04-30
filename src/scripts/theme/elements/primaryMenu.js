export default () => {
  
  // The focusMenuWithChildren() function implements Keyboard Navigation in the Primary Menu
  // by adding the '.focus' class to all 'li.menu-item-has-children' when the focus is on the 'a' element.
  
  const focusMenuWithChildren = () => {
    // Get all the link elements within the primary menu.
    var links, i, len,
      menu = document.querySelector( '.primary-menu-wrapper' );

    if ( ! menu ) {
      return false;
    }

    links = menu.getElementsByTagName( 'a' );

    // Each time a menu link is focused or blurred, toggle focus.
    for ( i = 0, len = links.length; i < len; i++ ) {
      links[i].addEventListener( 'focus', toggleFocus, true );
      links[i].addEventListener( 'blur', toggleFocus, true );
    }

    //Sets or removes the .focus class on an element.
    function toggleFocus() {
      var self = this;

      // Move up through the ancestors of the current link until we hit .primary-menu.
      while ( -1 === self.className.indexOf( 'primary-menu' ) ) {
        // On li elements toggle the class .focus.
        if ( 'li' === self.tagName.toLowerCase() ) {
          if ( -1 !== self.className.indexOf( 'focus' ) ) {
            self.className = self.className.replace( ' focus', '' );
          } else {
            self.className += ' focus';
          }
        }
        self = self.parentElement;
      }
    }
  }

  focusMenuWithChildren();
}
