import { registerBlockType } from '@wordpress/blocks';
import { RichText } from '@wordpress/block-editor';


registerBlockType('ecrannoir/blocks-example-editable', {
  title: 'Example Editable Block',
  icon: 'universal-access-alt',
  category: 'layout',
  supports: {
    align: ['full', 'wide'],
    default: 'full',
  },
  attributes: {
    title: {
      type: 'string',
      source: 'html',
      selector: 'h3',
    },
    description: {
      type: 'array',
      source: 'children',
      selector: 'p',
    }
  },
  example: {
    attributes: {
      title: 'Example Block',
      description: 'Hello World',
    },
  },
  edit: (props) => {
    const {
      isSelected,
      className,
      attributes: {
        title,
        description
      },
      setAttributes
    } = props;

    const onChangeTitle = title => setAttributes({ title: title })
    const onChangeDescription = value => setAttributes({ description: value })

    return (
      <div className={className}>
        <div className="block-heading">
          { isSelected ? (
            <RichText
              tagName="h3"
              onChange={(value) => onChangeTitle(value)}
              value={title}
              placeholder="Titre du block"
            />
          ) : (
            <RichText.Content tagName="h3" value={ title } />
          )}
        </div>
        <div className="block-description">
          { isSelected ? (
            <RichText
              tagName="p"
              className="soin-description"
              onChange={(value) => onChangeDescription(value)}
              value={ description }
              placeholder="Description du block"
            />
          ) : (
            <RichText.Content tagName="p" value={ description } />
          )}
        </div>
      </div>
    );
  },
  save: (props) => {
    const {
      className,
      attributes: {
        title,
        description
      }
    } = props;
    return (
      <div className={className}>
        <div className="block-heading">
          <RichText.Content tagName="h3" value={ title } />
        </div>
        <div className="block-description">
          <RichText.Content tagName="p" value={ description } />
        </div>
      </div>
    );
  }
});
