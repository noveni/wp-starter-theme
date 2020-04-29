<?php
/**
 * Config helpers.
 */

/**
 * Redirect always to https
 */
function ecrannoir_theme_redirect() {
    if (!is_ssl()) {
        wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit();
    }
}


/**
 * Activate WordPress Maintenance Mode
 */
function ecrannoir_theme_maintenance_mode(){
    if(!current_user_can('edit_themes') || !is_user_logged_in()){
        $site_title = get_bloginfo( 'name' );
        wp_die('<div style="text-align:center"><h1 style="color:black">' + $site_title + '</h1><p>Nous effectuons une maintenance. Nous serons de retour en ligne sous peu!</p></div>');
    }
}

/**
 * Get unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function ecrannoir_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}


/**
 * Changes the URL of the logo on the login screen.
 *
 * @return string Link to the Homepage.
 */
function ecrannoir_filter_login_headerurl() {
	return home_url( '/' );
}

/**
 * Changes the text of the logo on the login Screen.
 *
 * @return string Site Title.
 */
function ecrannoir_filter_login_headertext() {
	return get_bloginfo( 'name' );
}