<?php
/**
 * Post Meta.
 *
 * Here, you can register custom post meta fields using the Carbon Fields library.
 *
 * @link https://carbonfields.net/docs/containers-post-meta/
 *
 * @package WPEmergeCli
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;


// phpcs:disable
Container::make( 'post_meta', __( 'Event Data', 'app' ) )
	->where( 'post_type', '=', 'fn_event' )
	->add_fields( array(
        Field::make( 'date', 'crb_event_start_date', __( 'Event Start Date' ) ),
        Field::make( 'date', 'crb_event_end_date', __( 'Event End Date' ) ),
		Field::make( 'text', 'crb_event_location', __('Lieu de l\'event') )
    ));
// phpcs:enable
