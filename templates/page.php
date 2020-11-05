<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @since 1.0.0
 */

ecrannoir_get_theme_header();
?>

<main id="site-content" role="main">
	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'templates/template-parts/content', get_post_type() );
		}
	}

	?>

</main><!-- #site-content -->

<?php ecrannoir_get_theme_footer(); ?>
