import { registerBlockType } from '@wordpress/blocks';

import edit from './edit'

registerBlockType('ecrannoir/blocks-example-dynamic', {
  title: 'Example Dynamic Block',
  icon: 'universal-access-alt',
  category: 'layout',
  supports: {
    align: ['full', 'wide'],
    default: 'full',
    html: false,
  },
  edit,
});
