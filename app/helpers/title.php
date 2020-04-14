<?php
/**
 * The title 
 */

function ecrannoir_theme_the_title()
{
    if (is_home()) {
        if ($home = get_option('page_for_posts', true)) {
            return get_the_title($home);
        }
        return __('Latest Posts', 'ecrannoir');
    }
    if (is_post_type_archive()) {
        return post_type_archive_title( '', false );
    }
    if (is_archive()) {
        return get_the_archive_title();
    }
    if (is_search()) {
        return sprintf(__('Search Results for %s', 'ecrannoir'), get_search_query());
    }
    if (is_404()) {
        return __('Not Found', 'ecrannoir');
    }
    return get_the_title();
}
