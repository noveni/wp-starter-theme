<?php
/**
 * The template for displaying the Front Page.
 *
 */

ecrannoir_get_theme_header();
?>

<main id="site-content" role="main">

	<?php

	if ( have_posts() ) :

		while ( have_posts() ) :
			the_post();

			?>

			<div class="entry-content">

				<?php
				if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
					the_excerpt();
				} else {
					the_content( __( 'Continue reading', 'ecrannoir' ) );
				}
				?>

			</div><!-- .entry-content -->

			<?php
		endwhile;
	endif;

	?>

</main><!-- #site-content -->

<?php ecrannoir_get_theme_footer(); ?>
