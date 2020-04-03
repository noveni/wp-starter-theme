<?php
get_header();
?>
<main id="site-content" role="main">
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {

            the_post();

            ?>
            <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <div class="post-inner">

                    <div class="entry-content section-inner">

                        <?php
                        if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
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
                    ?>
                </div>
            </article>

            <?php
        }
    }
    ?>

    <?php echo get_the_posts_pagination(
            array(
                'mid_size'  => 1,
                'prev_text' => $prev_text,
                'next_text' => $next_text,
            )
        );
        ?>
    <?php get_template_part( 'templates/template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php
get_footer();
