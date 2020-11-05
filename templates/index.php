<?php
/**
 * The main template file
 *
 */

ecrannoir_get_theme_header();
?>
<main id="site-content" role="main">

	<div class="section-inner article-wrapper-section">
		<div class="article-wrapper">
		<?php

		if ( have_posts() ) {

			while ( have_posts() ) {
				the_post();

				get_template_part( 'templates/template-parts/article', get_post_type() );

			}
		} 
		?>
		</div>
	</div>
	<?php get_template_part( 'templates/template-parts/pagination' ); ?>
</main><!-- #site-content -->



<?php
ecrannoir_get_theme_footer();
