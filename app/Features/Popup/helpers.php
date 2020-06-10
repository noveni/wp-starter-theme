<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function ecrannoir_get_popups() {

    // TODO Make multiple popup possible, Right now, only the ultimate Popup Post is Shown
    $limit = 1;

    $args = array(
        'post_type'        => 'ecrannoir_popup_pt',
		'posts_per_page'   => $limit,
        'post_status'      => 'publish',
        'orderby'          => 'ID',
        'order'            => 'DESC',
		'suppress_filters' => false,
    );

    $popups = new WP_Query( $args );
    return $popups;
}
