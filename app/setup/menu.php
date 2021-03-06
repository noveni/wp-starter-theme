<?php

/**
 * Register Menus
 *
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */

$locations = array(
    'primary'   => __( 'Header Menu', 'ecrannoir' ),
    'mobile'    => __( 'Mobile Menu', 'ecrannoir' ),
    'footer'    => __( 'Footer Menu', 'ecrannoir' ),
    'social'    => __( 'Social Menu', 'ecrannoir' ),
    // 'lang' => __('Langue Menu', 'ecrannoir'),
    'menu404'   => __( '404 Menu', 'ecrannoir' ),
);

register_nav_menus( $locations );
