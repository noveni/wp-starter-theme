<?php

/**
 * Load composer dependencies.
 */
if ( file_exists( './vendor/autoload.php' ) ) {
	require_once './vendor/autoload.php';
}

/**
 * Ecran Noir Starter Theme
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */
define( 'THEME_ROOT_DIR', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
define( 'THEME_ROOT_URI', get_theme_root_uri('wp-starter-theme', 'wp-starter-theme') . DIRECTORY_SEPARATOR );
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

/**
 * EcranNoir Class files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. 
 */
array_map(function ($file) use ($en_error) {
    $file = "./app/classes/class-ecrannoir-{$file}.php";
    if (!locate_template($file, true, true)) {
        $en_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'ecrannoir'), $file), 'File not found');
    }
}, ['meta-tag', 'widget-link-page', 'script-loader', 'svg-icons']);

/**
 * EcranNoir Helpers files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. 
 */
array_map(function ($file) use ($en_error) {
    $file = "./app/helpers/{$file}.php";
    if (!locate_template($file, true, true)) {
        $en_error(sprintf('Error locating <code>%s</code> for inclusion.', $file), 'File not found');
    }
}, ['assets', 'blocks', 'clean', 'config', 'svg-icons', 'content', 'meta', 'title']);

/**
 * EcranNoir Modules files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. 
 */
array_map(function ($file) use ($en_error) {
    $file = "./app/modules/{$file}.php";
    if (!locate_template($file, true, true)) {
        $en_error(sprintf('Error locating <code>%s</code> for inclusion.', $file), 'File not found');
    }
}, ['contactform7', 'password-protected']);

/**
 * EcranNoir Hooks files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. 
 */
array_map(function ($file) use ($en_error) {
    $file = "./app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $en_error(sprintf('Error locating <code>%s</code> for inclusion.', $file), 'File not found');
    }
}, ['admin', 'actions', 'filters']);

/**
 * EcranNoir Setup files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. 
 */
array_map(function ($file) use ($en_error) {
    $file = "./app/setup/{$file}.php";
    if (!locate_template($file, true, true)) {
        $en_error(sprintf('Error locating <code>%s</code> for inclusion.', $file), 'File not found');
    }
}, ['assets', 'clean', 'theme', 'menu', 'widgets']);
