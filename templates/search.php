<?php
/**
 * The Search template file
 *
 * @package WordPress
 * @since 1.0.0
 */

ecrannoir_get_theme_header();
?>

<main id="site-content" role="main">

	<?php

	$archive_title    = '';
	$archive_subtitle = '';

    global $wp_query;

    $archive_title = sprintf(
        '%1$s %2$s',
        '<span class="color-accent">' . __( 'Search:', 'ecrannoir' ) . '</span>',
        '&ldquo;' . get_search_query() . '&rdquo;'
    );

    if ( $wp_query->found_posts ) {
        $archive_subtitle = sprintf(
            /* translators: %s: Number of search results */
            _n(
                'We found %s result for your search.',
                'We found %s results for your search.',
                $wp_query->found_posts,
                'ecrannoir'
            ),
            number_format_i18n( $wp_query->found_posts )
        );
    } else {
        $archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'ecrannoir' );
    }

    ?>

    <header class="archive-header has-text-align-center">

        <div class="archive-header-inner section-inner medium">

            <?php if ( $archive_title ) { ?>
                <h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
            <?php } ?>

            <?php if ( $archive_subtitle ) { ?>
                <div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
            <?php } ?>

        </div><!-- .archive-header-inner -->

    </header><!-- .archive-header -->

    <div class="section-inner article-wrapper-section">
		<div class="article-wrapper">
    <?php

	if ( have_posts() ) {

		$i = 0;

		while ( have_posts() ) {
			the_post();

			get_template_part( 'templates/template-parts/article', get_post_type() );

		}
	} elseif ( is_search() ) {
		?>

		<div class="no-search-results-form section-inner thin">

			<?php
			get_search_form(
				array(
					'label' => __( 'search again', 'ecrannoir' ),
				)
			);
			?>

		</div><!-- .no-search-results -->

		<?php
	}
    ?>
        </div>
	</div>

	<?php get_template_part( 'templates/template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php
ecrannoir_get_theme_footer();
