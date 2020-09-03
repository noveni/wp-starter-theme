<?php
/**
 * Ecran Noir Starter Theme
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */



/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$en_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Ecran Noir &rsaquo; Error', 'ecrannoir');
    $footer = '<a href="https://ecrannoir.be/">ecrannoir.be</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $en_error(__('You must be using WordPress 4.7.0 or greater.', 'ecrannoir'), __('Invalid WordPress version', 'ecrannoir'));
}



define( 'THEME_ROOT_DIR', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
define( 'THEME_ROOT_DIR_THEME', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define( 'THEME_ROOT_URI', get_theme_root_uri('wp-starter-theme', 'wp-starter-theme') . DIRECTORY_SEPARATOR );
define( 'GA_MEASUREMENT_ID', false );
define( 'ECRANNOIR_POST_REVISIONS', 0 );

// https://github.com/makeitworkpress/wordpress-autoload-class/blob/master/functions.php
spl_autoload_register( function($classnames) {

    // Regular
    $class      = str_replace( '\\', DIRECTORY_SEPARATOR, strtolower($classnames) ); 
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $class . '.php';

    // WordPress
    $parts      = explode('\\', $classnames);
    $class      = 'class-' . strtolower( array_pop($parts) );
    $folders    = strtolower( implode(DIRECTORY_SEPARATOR, $parts) );
    $wppath     = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $folders . DIRECTORY_SEPARATOR . $class . '.php';
    
    if ( file_exists( $classpath ) ) {
        include_once $classpath;
    } elseif(  file_exists( $wppath ) ) {
        include_once $wppath;
    }
   
} );

/**
 * Load composer dependencies.
 */
if ( file_exists( './vendor/autoload.php' ) ) {
	require_once './vendor/autoload.php';
}


$theme = EcrannoirWPTheme::instance();
