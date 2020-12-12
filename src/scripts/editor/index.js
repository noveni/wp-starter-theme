// import 'styles/editor/index.scss';
import domReady from '@wordpress/dom-ready';

import { unregisterBlockStyle, registerBlockStyle } from '@wordpress/blocks';

import './ExampleEditableBlock'
import './ExampleDynamicBlock'
/**
 * Remove unused blocks
 *
 * @since 1.0.0
 */
domReady( () => {
  unregisterBlockStyle( 'core/button', [ 'outline', 'fill' ] );
  unregisterBlockStyle( 'core/quote', [ 'default', 'large' ] );
  unregisterBlockStyle( 'core/image', [ 'default', 'rounded', 'editorskit-circular', 'editorskit-rounded', 'editorskit-diagonal', 'editorskit-inverted-diagonal', 'editorskit-shadow' ] );
  unregisterBlockStyle( 'core/columns', ['default', 'gapless']);

  // registerBlockStyle( 'core/cover', {
  //   name: 'bg-size-100',
  //   label: 'Background-Size: 100%'
  // });
});
