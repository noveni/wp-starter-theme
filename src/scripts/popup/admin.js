import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { registerPlugin } from '@wordpress/plugins';
import { Fragment } from '@wordpress/element';
import { PanelBody, PanelRow, TextControl, Button, DateTimePicker } from '@wordpress/components';
import { compose, withState } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { dateI18n, format, __experimentalGetSettings } from '@wordpress/date';

const MetaDateControl = compose(
  withDispatch( ( dispatch, props ) => {
    return {
			setMetaValue: ( metaValue ) => { 
        dispatch( 'core/editor' ).editPost( { meta: { [ props.metaKey ]: metaValue } } );
			}
		}
  }),
  withSelect( ( select, props ) => {
    return {
      metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ props.metaKey ]
    }
  }),
  withState( {
    showPicker: false,
    date: new Date(),
  }))( ( { title, metaValue, labelEmpty, date, setMetaValue, showPicker, setState } ) => {
    const dateFormat = __experimentalGetSettings().formats.date;
    const hasMeta = metaValue != '';
    const buttonContent = hasMeta ? dateI18n( dateFormat, metaValue ) : labelEmpty;
    return (
      <>
      <PanelRow>
        <span>{title}</span>
        <Button isLink
          onClick={ () => setState( { showPicker: !showPicker }) }
          >
          { buttonContent }
        </Button>
        <Button isLink
          onClick={ () => {
            setMetaValue( '' );
            setState( { showPicker: false });
          }}
          >
          Reset
        </Button>
      </PanelRow>
      {showPicker && 
        <DateTimePicker
          currentDate={ date }
          onChange={ ( date ) => {
              setMetaValue( date );
              setState( { showPicker: false });
            } 
          }
          is12Hour={ false }
        />
      }
      </>
    )
  } );

const PluginSidebarTest = () => {  
  return (
      <PluginSidebar
          name="plugin-sidebar-popup"
          title="Popup"
      >
        <PanelBody>
          <MetaDateControl
            title="Date de début"
            labelEmpty="Immédiatement"
            metaKey="ecrannoir_popup_pt_date_start"
           />
          <MetaDateControl
            title="Date de fin"
            labelEmpty="Toujourss"
            metaKey="ecrannoir_popup_pt_date_end"
           />
        </PanelBody>
      </PluginSidebar>
  );
};
registerPlugin( 'plugin-sidebar-popup', { render: PluginSidebarTest } );

