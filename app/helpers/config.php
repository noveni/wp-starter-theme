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
        wp_die('<div style="text-align:center"><h1 style="color:black">' . $site_title . '</h1><p>Nous effectuons une maintenance. Nous serons de retour en ligne sous peu!</p></div>');
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


/**
 * Get Config Path File
 */
function getConfigData() {
    return (array) json_decode(utf8_encode(file_get_contents(get_template_directory() . '/themeConfig.json')), true);
}

/**
 * Get config value
 */
function getConfigValue($key = false) {
    $configData = getConfigData();
    $return_value = $configData['variables'];

    if ($key) {
        if (key_exists($key, $configData['variables'])) {
            $return_value = $configData['variables'][$key];
        }
    }

    return $return_value;
}


/**
 * Retrieves the theme header
* Replaces the standard get_header call that WordPress uses
 */
function ecrannoir_get_theme_header() {
    get_template_part('templates/header');
}

/**
 * Retrieves the theme footer
 * Replaces the standard get_footer call that WordPress uses
 */
function ecrannoir_get_theme_footer() {
    get_template_part('templates/footer');
}
