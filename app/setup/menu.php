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
    'primary'  => __( 'Header Menu', 'ecrannoir' ),
    'expanded' => __( 'Desktop Expanded Menu', 'ecrannoir' ),
    'mobile'   => __( 'Mobile Menu', 'ecrannoir' ),
    'footer'   => __( 'Footer Menu', 'ecrannoir' ),
    'social'   => __( 'Social Menu', 'ecrannoir' ),
    'header-secondary' =>  __( 'Header Secondary Menu', 'ecrannoir' ),
    'lang' => __('Langue Menu', 'ecrannoir'),
    'menu404' => 'Page 404 Menu'
);

register_nav_menus( $locations );
