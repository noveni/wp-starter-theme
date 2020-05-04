<?php

/**
 * Block Setup For the Starter Theme
 * 
 * 
 */


/**
 * Remove blocks, by let only the allowed blocks from whitelits
 * 
 * TODO: Improve the portability beetween Projet, Maybe Create a an array in a config theme file way
 */

function ecrannoirwptheme_allowed_block_types( $allowed_blocks, $post ) {

    $default_allowed_blocks = array(
        // Common
        'core/paragraph',
        'core/image',
        'core/heading',
        'core/gallery',
        'core/list',
        'core/quote',
        'core/audio',
        'core/file',
        'core/video',
        // Formatting category
        'core/table',
        'core/verse',
        'core/code',
        'core/freeform',
        'core/html',
        'core/preformatted',
        'core/pullquote',
        // Layout Elements category
        'core/buttons',
        'core/text-columns',
        'core/media-text',
        'core/more',
        'core/nextpage',
        'core/separator',
        'core/spacer',
        // Widgets category
        'core/shortcode',
        'core/archives',
        'core/categories',
        'core/latest-comments',
        'core/latest-posts',
        'core/calendar',
        'core/rss',
        'core/search',
        'core/tag-cloud',
        // Embeds category
        'core/embed',
        'core-embed/twitter',
        'core-embed/youtube',
        'core-embed/facebook',
        'core-embed/instagram',
        'core-embed/wordpress',
        'core-embed/soundcloud',
        'core-embed/spotify',
        'core-embed/flickr',
        'core-embed/vimeo',
        'core-embed/animoto',
        'core-embed/cloudup',
        'core-embed/collegehumor',
        'core-embed/dailymotion',
        'core-embed/funnyordie',
        'core-embed/hulu',
        'core-embed/imgur',
        'core-embed/issuu',
        'core-embed/kickstarter',
        'core-embed/meetup-com',
        'core-embed/mixcloud',
        'core-embed/photobucket',
        'core-embed/polldaddy',
        'core-embed/reddit',
        'core-embed/reverbnation',
        'core-embed/screencast',
        'core-embed/scribd',
        'core-embed/slideshare',
        'core-embed/smugmug',
        'core-embed/speaker',
        'core-embed/ted',
        'core-embed/tumblr',
        'core-embed/videopress',
        'core-embed/wordpress-tv',
    );

    $return_allowed_blocks = $allowed_blocks;

    // get widget blocks and registered by plugins blocks
    $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
    $registered_blocks = array_keys( $registered_blocks );

    // // Remove Defaults Blocks From Registered blocks
    $registered_blocks = array_diff($registered_blocks, $default_allowed_blocks);

    $theme_allowed_blocks_type = array(
		'core/image',
		'core/paragraph',
		'core/heading',
        'core/list',
        'core/gallery',
        'core/media-text',
        'core/list',
        'core/quote',
        'ecrannoir/blocks-example-editable',
        'ecrannoir/blocks-example-dynamic'
    );

    

    if( $post->post_type === 'app_custom_post_type' ) {
		$theme_allowed_blocks_type[] = 'core/shortcode';
    }

    // Take the default core blocks and remove whitelist blocks
    $filtered_allowed_blocks_to_disable = array_merge($theme_allowed_blocks_type, $registered_blocks);
    
    if (!empty($theme_allowed_blocks_type)) {
        $return_allowed_blocks = $filtered_allowed_blocks_to_disable;
    }
    return $return_allowed_blocks;

}

add_filter( 'allowed_block_types', 'ecrannoirwptheme_allowed_block_types', 10, 2 );
