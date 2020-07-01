<?php

namespace Assets;

/**
 * Javascript Loader Class
 *
 * Allow `async` and `defer` while enqueuing Javascript.
 *
 * Based on a solution in WP Rig.
 *
 * @package WordPress
 
 * @since 1.0.0
 */

if ( ! class_exists( 'Assets\Meta' ) ) {

    class Meta {

        /**
         * List of default directories.
         *
         * @since 2.8.0
         * @var array
         */
        public static $default_cpt = ['post'];

        public static function print_meta()
        {
            echo '<meta name="description" content="' . self::description()  . '" />' . "\n";
            self::print_all_OG();
        }
        
        public static function print_all_OG()
        {
            echo '<meta property="og:title" content="'. self::title() .'" />'. "\n";
            echo '<meta property="og:type" content="' . self::ogType() . '" />'. "\n";
            echo '<meta property="og:url" content="' . self::getOGPermalink() . '" />'. "\n";
            echo '<meta property="og:description" content="' . self::description()  . '"/>' . "\n";
            echo '<meta property="og:locale" content="' . get_locale() . '"/>' . "\n";
            echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>' . "\n";
            $ogImages = self::getOgImages();
            self::printOgImages($ogImages);
            
        }

        /**
         * Return the correct permalink of page, archive cp, post, tax
         * 
         * @return String Url of page
         */
        public static function getOGPermalink()
        {
            if ( is_tax() ) { 
                $permalink = get_term_link( get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            }
            elseif( is_post_type_archive() ) {
                $permalink = get_post_type_archive_link( get_query_var('post_type') );
            }
            elseif (is_home()) {
                if ($home = get_option('page_for_posts', true)) {
                    $permalink = get_permalink($home);
                } else {
                    $permalink = get_permalink();
                }
            }
            else {
                $permalink = get_permalink();
            }
            return $permalink;
        }
        
        /**
         * Print the meta og tag for image
         * Handle multiple image
         * 
         * @param array $images the images elements
         */
        public static function printOgImages($images) {
            if ( ! $images ) {
                return;
            }
            foreach ($images as $image) {
                echo '<meta property="og:image" content="' . $image['url']. '"/>' . "\n";
                echo '<meta property="og:image:width" content="' . $image['width'] . '"/>' . "\n";
                echo '<meta property="og:image:height" content="' . $image['height'] . '"/>' . "\n";
                echo '<meta property="og:image:type" content="' . $image['type'] . '"/>' . "\n";
            }
        }
        /**
         * Get Post Image or default image and print Tag
         * 
         * @return array Array of images
         */
        public static function getOgImages()
        {
            $default_image = array(
                'url' => get_template_directory_uri() . '/dist/img/logo.svg',
                'height' => 1080,
                'width' => 1080,
                'type' => 'image/png'
            );

            $images = array();

            // For this theme we know there is slide, so we try to get images
            if (is_front_page()) {
                $slider_img_ids = get_slider_img();
                if ($slider_img_ids) {
                    $images = array($default_image);
                    foreach ($slider_img_ids as $slider_img_id) {
                        $slider_img = wp_get_attachment_image_src($slider_img_id, 'large');
                        $images[] = array(
                            'url' => $slider_img[0],
                            'height' => $slider_img[1],
                            'width' => $slider_img[2],
                            'type' => 'image/jpg',
                        );
                    }
                    return $images;
                }
            }

            if(has_post_thumbnail()) {
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                if ($thumbnail) {
                    $images[] = array(
                        'url' => $thumbnail[0],
                        'height' => $thumbnail[1],
                        'width' => $thumbnail[2],
                        'type' => 'image/jpg',
                    );
                    $images[] = $default_image;
                    return $images;
                }
                
            }
            
            $images[] = $default_image;
            return $images;
        }

        

        public static function title()
        {
            if (is_home()) {
                if ($home = get_option('page_for_posts', true)) {
                    return get_the_title($home);
                }
                return __('Latest Posts', 'ecrannoir');
            }
            if (is_post_type_archive()) {
                return post_type_archive_title( '', false );
            }
            if (is_archive()) {
                return get_the_archive_title();
            }
            if (is_search()) {
                return sprintf(__('Search Results for %s', 'ecrannoir'), get_search_query());
            }
            if (is_404()) {
                return __('Not Found', 'ecrannoir');
            }
            return get_the_title();
        }

        /**
         * Short description of site or post or custom post type 
         * 
         * @return String 
         */
        public static function description()
        {
            if (is_singular(self::$default_cpt)) {
                $excerpt = wp_strip_all_tags( get_the_excerpt(), true );
                if ($excerpt) {
                    return $excerpt;
                }
                // if (empty($excerpt)) { //If no excerpt we need to get the post content
                //     $des_post = wp_strip_all_tags( get_the_content(), true );
                //     $excerpt = mb_substr( $des_post, 0, 300, 'utf8' );
                // }
                // return $excerpt;
            }
            if ( is_post_type_archive() ) {
                $description_archive =  wp_strip_all_tags(get_the_archive_description(), true);
                if ( $description_archive ) {
                    return $description_archive;
                }
            }
            return get_bloginfo( 'description' );
        }

        /**
         * Get the type of content for the Open Graph
         * 
         * @return String 'website' || 'article'
         */
        public static function ogType()
        {
            
            if ( is_singular( self::$default_cpt ) ) { 
                // OG tags gonna go only of specific page
                return 'article';
            }

            return 'website';
        }

        /**
         * Print the article meta
         */
        public static function printOgTypeArticle()
        {
            $author = get_the_author_meta();
            $date = '';
        }

        public static function addAnalytics($ga_measurement_id)
        {
            ob_start();
            ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_measurement_id; ?>"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?php echo $ga_measurement_id; ?>>');
            </script>
            <?php

            $meta_output = ob_get_clean();
            // If there is meta to output, return it.
            if ( $meta_output ) {
                echo $meta_output;
            }
        }

       
    }
    
}
