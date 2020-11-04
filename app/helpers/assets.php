<?php
/**
 * Asset helpers.
 */

use Assets\Icons;

/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 *
 * @return string $html Compiled HTML based on our arguments.
 */
function ecrannoir_theme_site_logo( $args = array(), $echo = true, $color = false) {
	$logo       = get_custom_logo();
	$site_title = get_bloginfo( 'name' );
	$contents   = '';
	$classname  = '';

	$defaults = array(
		'logo'        => '<a href="%1$s">%2$s<span class="screen-reader-text">%3$s</span></a>',
		'logo_class'  => 'site-logo',
		'title'       => '<a href="%1$s">%2$s</a>',
		'title_class' => 'site-title',
		'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
		'single_wrap' => '<div class="%1$s">%2$s</div>',
		'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
    );
    
    if (!has_custom_logo()) {
        $logo = Icons::get_svg('logo', 'brand', $color);
    }

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the arguments for `ecrannoir_theme_site_logo()`.
	 *
	 * @param array  $args     Parsed arguments.
	 * @param array  $defaults Function's default arguments.
	 */
	$args = apply_filters( 'ecrannoir_theme_site_logo_args', $args, $defaults );

	if ( has_custom_logo() || $logo ) {
		$contents  = sprintf( $args['logo'], esc_url( get_home_url( null, '/' ) ), $logo, esc_html( $site_title ) );
		$classname = $args['logo_class'];
	} else {
		$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
		$classname = $args['title_class'];
	}

	$wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';

	$html = sprintf( $args[ $wrap ], $classname, $contents );

	/**
	 * Filters the arguments for `ecrannoir_theme_site_logo()`.
	 *
	 * @param string $html      Compiled html based on our arguments.
	 * @param array  $args      Parsed arguments.
	 * @param string $classname Class name based on current view, home or single.
	 * @param string $contents  HTML for site title or logo.
	 */
	$html = apply_filters( 'ecrannoir_theme_site_logo', $html, $args, $classname, $contents );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}


/** 
 * Allow SVG through WordPress Media Uploader 
 * */
function ecrannoir_theme_filter_upload_mimes($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}


/**
 * Display SVG icons in social links menu.
 * Copied From TwentyTwenty
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function ecrannoir_theme_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
    // Change SVG icon inside social links menu if there is supported URL.
    if ( 'social' === $args->theme_location ) {
		$svg = Icons::get_social_link_svg( $item->url );
		if ( empty( $svg ) ) {
			$svg = ecrannoir_get_theme_svg( 'link' );
		}
        $item_output = str_replace( $args->link_after, '</span>' . $svg, $item_output );
    }
	return $item_output;
}



function ecrannoir_theme_sanitize_file_name($filename){
    $sanitized_filename = remove_accents($filename); // Convert to ASCII

	// Standard replacements
	$invalid = array(
		' ' => '-',
		'%20' => '-',
		'_' => '-'
	);
	$sanitized_filename = str_replace(array_keys($invalid), array_values($invalid), $sanitized_filename);

	$sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
	$sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
	$sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
	$sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
	$sanitized_filename = strtolower($sanitized_filename); // Lowercase

	return $sanitized_filename;
}


/**
 * Retrieve Image Id of eedee/block-gutenslider plugin
 * 
 * @return array Ids of images
 */
function get_slider_img() {
	global $post;

	if (has_block('eedee/block-gutenslider', $post)) {
		$blocks = parse_blocks( $post->post_content );
		$images = array();
		foreach ( $blocks as $block ) {
			if ( 'eedee/block-gutenslider' === $block['blockName'] ) {
				$innerBlocks = $block['innerBlocks'];
				foreach ( $innerBlocks as $innerBlock ) {
					if ( 'eedee/block-gutenslide' === $innerBlock['blockName'] ) {
						if (array_key_exists('attrs', $innerBlock)) {
							if ($innerBlock['attrs']['mediaType'] === 'image') {
								$imgID = $innerBlock['attrs']['mediaId'];
								$images[] = $imgID;
							}
						}
					}
				}
			}
		}
		return !empty($images) ? $images : false;
	}

	return false;
}
