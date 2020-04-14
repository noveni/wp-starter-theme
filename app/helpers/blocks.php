<?php
/**
 * Blocks helpers.
 */

/**
 * Change the render of latest blog post
 */
function ecrannoir_theme_render_block_latests_posts( $attributes ) {
    $a = 0;
}
function ecrannoir_theme_register_block() {
    register_block_type( 'core/latest-posts', array(
		'render_callback' => 'ecrannoir_theme_render_block_latests_posts',
	));
}
