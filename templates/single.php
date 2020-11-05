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
			?>
			<div class="entry-content">
				<div class="wp-block-cover alignfull has-background-dim" style="background-image:url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>)">
					<div class="wp-block-cover__inner-container">
						<?php the_title( '<h1 class="entry-title has-text-align-center">', '</h1>' ); ?>
						<p class="has-text-align-center">
							<span class="post-time"><?php the_time( get_option( 'date_format' ) ); ?></span>
							•
							<span><?php 
								printf(
									/* translators: %s: Author name */
									__( 'By %s', 'ecrannoir' ),
									'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>'
								);
							?></span>
							•
							<span><?php the_category( ', ' ); ?></span>
						</p>
					</div>
				</div>
			</div>
			<div class="post-inner section-inner">

				<div class="entry-content">

					<?php
					if ( is_search() || ! is_singular() ) {
						the_excerpt();
					} else {
						the_content( __( 'Continue reading', 'ecrannoir' ) );
					}
					?>
					<?php 
					wp_link_pages(
						array(
							'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'ecrannoir' ) . '"><span class="label">' . __( 'Pages:', 'ecrannoir' ) . '</span>',
							'after'       => '</nav>',
							'link_before' => '<span class="page-number">',
							'link_after'  => '</span>',
						)
					);
					
					get_template_part( 'templates/template-parts/navigation' );
					?>
				</div><!-- .entry-content -->

			</div><!-- .post-inner -->
			<?php

			
		}
	}

	?>

</main><!-- #site-content -->

<?php ecrannoir_get_theme_footer(); ?>
