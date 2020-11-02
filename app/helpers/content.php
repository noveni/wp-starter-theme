<?php
/**
 * Content Helper
 */


/**
 * Add "… Continued" to the excerpt
 */
function ecrannoir_theme_filter_excerpt_more() {
    return ' &hellip;';
}

/** 
 * Limit excert length
 */

function ecrannoir_theme_filter_excerpt_length($length) {
    if ( is_admin() ) {
        return $length;
    }
    return 10;
}


/**
 * Add <body> classes
 */
function ecrannoir_theme_filter_body_class(array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // /** Add class if sidebar is active */
    // if (display_sidebar()) {
    //     $classes[] = 'sidebar-primary';
    // }

    // Remove unnecessary classes
    $home_id_class = 'page-id-' . get_option('page_on_front');
    $remove_classes = [
        'page-template-default',
        $home_id_class
    ];
    $classes = array_diff($classes, $remove_classes);

    return $classes;
}


/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 *
 * @return string $html
 */
function ecrannoir_theme_filter_the_content_more_link($html) {
    return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

/**
 * Return a separator Character ' | '
 */
function ecsep($class = false) {
	echo '<span class="separator '.$class.'"> | </span>';
}
