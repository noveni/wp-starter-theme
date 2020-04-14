<?php

add_filter('body_class', 'ecrannoir_theme_filter_body_class');
add_filter('excerpt_more', 'ecrannoir_theme_filter_excerpt_more');
add_filter('excerpt_length', 'ecrannoir_theme_filter_excerpt_length');
add_filter('the_content_more_link', 'ecrannoir_theme_filter_the_content_more_link');

add_filter('upload_mimes', 'ecrannoir_theme_filter_upload_mimes');

add_filter('walker_nav_menu_start_el', 'ecrannoir_theme_walker_nav_menu_start_el' ,10, 4);

add_filter('sanitize_file_name', 'ecrannoir_theme_sanitize_file_name');

/**
 * Login
 */
add_filter( 'login_headerurl', 'ecrannoir_filter_login_headerurl' );
if ( version_compare( get_bloginfo( 'version' ), '5.2', '<' ) ) {
	add_filter( 'login_headertitle', 'ecrannoir_filter_login_headertext' );
}
add_filter( 'login_headertext', 'ecrannoir_filter_login_headertext' );

// add_filter('password_protected_theme_file', function($file){
//     die($file);
// });
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

add_filter( 'password_protected_process_login', 'ecrannoir_filter_is_password_protected', 10, 2);
