<?php
/**
 * The template for displaying excerpt of archive
 *
 */

?>

<article <?php post_class('article-card'); ?> id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>">

    <div class="article-inner">

        <div class="article-head">
            <div class="tag-wrapper">
                <?php
                foreach (get_the_category() as $tag):
                ?>
                <span class="tag-term"><?php echo $tag->name ?></span>
                    <?php
                endforeach;
                ?>
            </div>
        </div>

        <div class="article-image">
            <?php get_template_part( 'templates/template-parts/featured-image' ); ?>
        </div>

        <div class="article-central">
        <?php
    
            the_title( '<h2 class="heading-size-4">', '</h2>' );

            the_excerpt();

        ?>
        </div>

        <div class="article-foot">
            <a class="post-author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author( ); ?></a>  
            <span class="post-time">/ <?php the_time( get_option( 'date_format' ) ); ?></span>
        </div>
    
    </div>

</a></article><!-- .post -->
