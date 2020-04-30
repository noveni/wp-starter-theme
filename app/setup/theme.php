<?php
/**
 * Declare theme functionality support.
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 *
 * @hook    after_setup_theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
* Let WordPress manage the document title.
* By adding theme support, we declare that this theme does not use a
* hard-coded <title> tag in the document head, and expect WordPress to
* provide it for us.
* 
* @link https://codex.wordpress.org/Title_Tag
*/
add_theme_support( 'title-tag' );

/**
 * Enable post thumbnails
 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
 */
add_theme_support('post-thumbnails');


/*
* Switch default core markup for search form, comment form, and comments
* to output valid HTML5.
*/
add_theme_support(
'html5',
array(
    'search-form',
    'comment-form', 
    'comment-list', 
    'gallery', 
    'caption',
    'script',
    'style'
)
);


// Add support for full and wide align images.
add_theme_support( 'align-wide' );

/**
 * Support default editor block styles.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
add_theme_support( 'wp-block-styles' );

/*
* Make theme available for translation.
* Translations can be filed in the /languages/ directory.
* If you're building a theme based on Ecran Noir, use a find and replace
* to change 'ecrannoir' to the name of your theme in all the template files.
*/
load_theme_textdomain('ecrannoir');

/**
 * Enable selective refresh for widgets in customizer
 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
 */
add_theme_support('customize-selective-refresh-widgets');




$editorColor = getConfigValue('color');
$editorColorPalette = [];
foreach ($editorColor as $colorName => $colorHex) {
    $editorColorPalette[] = array(
        'name' => $colorName,
        'slug' => $colorName,
        'color' => $colorHex,
    );
}
add_theme_support( 'editor-color-palette', $editorColorPalette );

add_theme_support( 'disable-custom-colors' );

$configFontSizes = getConfigValue('fontSize');
$editorFontSizes = [];
foreach ($configFontSizes as $fontSizeName => $fontSizeValue) {
    $editorFontSizes[] = array(
        'name' => $fontSizeName,
        'shortName' => $fontSizeName,
        'size' => $fontSizeValue,
        'slug' => $fontSizeName,
    );
}
add_theme_support( 'editor-font-sizes', $editorFontSizes );
