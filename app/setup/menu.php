<?php

/**
 * Register Menus
 *
 *
 */


/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
add_action( 'after_setup_theme', function() {

    $locations = array(
        'primary'  => __( 'Header Menu', 'ecrannoir' ),
        'footer' => __('Footer Menu', 'ecrannoir'),
        'header-secondary' =>  __( 'Header Secondary Menu', 'ecrannoir' ),
        'social'   => __( 'Social Menu', 'ecrannoir' ),
        'lang' => __('Langue Menu', 'ecrannoir'),
        'menu404' => 'Page 404 Menu'
	);

	register_nav_menus( $locations );
});
