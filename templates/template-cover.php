<?php
/**
 * Template Name: Cover Template
 * Template Post Type: post, page
 *
 * @package WordPress
 
 * @since 1.0
 */

ecrannoir_get_theme_header();
?>

<main id="site-content" role="main">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'templates/template-parts/content-cover' );
		}
	}

	?>

</main><!-- #site-content -->

<?php ecrannoir_get_theme_header(); ?>
