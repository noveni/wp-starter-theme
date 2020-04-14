<?php
/**
 * Declare theme functionality support.
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 *
 * @hook    after_setup_theme
 */

add_action('after_setup_theme', function () {

    load_theme_textdomain('ecrannoir', get_template_directory() . '/languages');
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


    
    // Block Editor Palette.
    add_theme_support( 'editor-color-palette',
		array(
            array(
                'name' => 'black',
                'slug' => 'black',
                'color' => '#000000'
            ),
            array(
                'name' => 'white',
                'slug' => 'white',
                'color' => '#ffffff'
            ),
            array(
                'name' => 'grey',
                'slug' => 'grey',
                'color' => '#888888',
            ),
            array(
                'name' => 'blue-tone',
                'slug' => 'blue-tone',
                'color' => '#0d6ae0',
            ),
            array(
                'name' => 'blue-deep',
                'slug' => 'blue-deep',
                'color' => '#1b243d',
            ),
            array(
                'name' => 'blue-flash',
                'slug' => 'blue-flash',
                'color' => '#009fe3',
            ),
            array(
                'name' => 'blue-electric',
                'slug' => 'blue-electric',
                'color' => '#006ae8',
            ),
            array(
                'name' => 'red',
                'slug' => 'red',
                'color' => '#e30613',
            ),
            array(
                'name' => 'green',
                'slug' => 'green',
                'color' => '#3aaa35',
            ),
            array(
                'name' => 'orange',
                'slug' => 'orange',
                'color' => '#f39200',
            ),
		)
    );

    add_theme_support( 'disable-custom-colors' );
    
    add_theme_support(
        'editor-font-sizes',
        array(
            array(
                'name' => 'Small',
                'shortName' => 'S',
                'size' => 12,
                'slug' => 'small'
            ),
            array(
                'name' => 'Regular',
                'shortName' => 'M',
                'size' => 15,
                'slug' => 'normal'
            ),
            array(
                'name' => 'Large',
                'shortName' => 'L',
                'size' => 21,
                'slug' => 'large'
            ),
         )
    );
});
