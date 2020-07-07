<?php

/**
 * Register Menus
 *
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_theme_support('starter-content', array(
        // Specify the core-defined pages to create and add custom thumbnails to some of them.
        'widgets' => array(
            // Place one core-defined widgets in the first footer widget area.
			'widget-footer-top' => array(
                'text',
            ),
			// Place one core-defined widgets in the second footer widget area.
			'widget-footer-left' => array(
                'text_about',
            ),
			// Place one core-defined widgets in the second footer widget area.
			'widget-footer-right' => array(
                'text_business_info'
            ),
        ),
        'posts'     => array(
            'front' => array(
                'post_type'    => 'page',
                'post_title'   => _x( 'Home', 'ecrannoir' ),
                'post_content' => join(
                    '',
                    array(
                        '<!-- wp:heading {"level":2} -->',
						'<h2>' . __( 'Hello World', 'ecrannoir' ) . '</h2>',
						'<!-- /wp:heading -->',
                    )
                ),
            ),
            'about',
            'contact',
            'blog',
            'blocks' => array(
                'post_type'    => 'page',
                'post_title'   => _x( 'Blocks', 'ecrannoir' ),
                'post_content' => join(
                    '',
                    array(
                        '<!-- wp:group {"align":"wide"} -->',
                        '<div class="wp-block-group alignwide"><div class="wp-block-group__inner-container"><!-- wp:heading {"align":"center"} -->',
                        '<h2 class="has-text-align-center">' . __( 'WP Block Group.', 'ecrannoir' ) . '</h2>',
						'<!-- /wp:heading --></div></div>',
						'<!-- /wp:group -->',
                    )
                ),
            ),
            'style' => array(
                'post_type'    => 'page',
                'post_title'   => _x( 'Style Guide', 'ecrannoir' ),
                'post_content' => join(
                    '',
                    array(
                        '<!-- wp:heading {"level":2} -->',
						'<h2>' . __( 'Style Guide', 'ecrannoir' ) . '</h2>',
						'<!-- /wp:heading -->',
                    )
                ),
            )
        ),

        // Default to a static front page and assign the front and posts pages.
		'options'     => array(
			'show_on_front'  => 'page',
			'page_on_front'  => '{{front}}',
            'page_for_posts' => '{{blog}}',
            'blogdescription' => '',
            'users_can_register' => 0,
            'posts_per_page' => 20,
            'permalink_structure' => '/%postname%/',
            'show_avatars' => 0,
		),
        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus'   => array(
            // Assign a menu to the "primary" location.
            'primary'  => array(
				'name'  => __( 'Primary', 'ecrannoir' ),
				'items' => array(
					'front', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
                    'page_contact',
                    'page_blocks'=> array(
                        'type' => 'post_type',
						'object' => 'page',
						'object_id' => '{{blocks}}',
                    ),
                    'page_style' => array(
                        'type' => 'post_type',
						'object' => 'page',
						'object_id' => '{{style}}',
                    ),
				),
            ),
            // Assign a menu to the "social" location.
			'social'   => array(
				'name'  => __( 'Social Links Menu', 'ecrannoir' ),
				'items' => array(
					'link_facebook',
					'link_instagram',
					'link_email',
				),
			),

        )
));
