<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 
 * @since 1.0.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part( 'templates/template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'templates/template-parts/featured-image' );
	}

	?>

	<div class="post-inner">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'ecrannoir' ) );
			}
			?>

		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'ecrannoir' ) . '"><span class="label">' . __( 'Pages:', 'ecrannoir' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);


		// Single bottom post meta.
		ecrannoir_the_post_meta( get_the_ID(), 'single-bottom' );

		if ( is_single() ) {

			get_template_part( 'templates/template-parts/entry-author-bio' );

		}
		?>

	</div><!-- .section-inner -->

	<?php

	if ( is_single() ) {

		get_template_part( 'templates/template-parts/navigation' );

	}

	?>

</article><!-- .post -->
