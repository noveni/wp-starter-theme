<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

use Assets\Scripts;
use Admin\Admin;
use PostType\ExampleCpt;
use WP_Error as WP_Error;


class EcrannoirWPTheme
{
	/**
     * Determines whether a class has already been instanciated.
     *
     * @access private
     */
	private static $instance = null;   
	
	/** 
     * Constructor. This allows the class to be only initialized once.
     */
    private function __construct() {
        $this->init();
    }


	public static function instance()
	{
		$class = get_called_class();
        if ( ! isset(self::$instance[$class]) ) {
            self::$instance[$class] = new $class();
        }

        return self::$instance[$class];
	}
	
	public function init() {

		/**
         * Loads our translations before loading anything else
         */
        if( is_dir( get_stylesheet_directory() . '/languages' ) ) {
            $path = get_stylesheet_directory() . '/languages';
        } else {
            $path = get_template_directory() . '/languages'; 
        }

		load_theme_textdomain('ecrannoir', $path);

		// Load Utilities
		require_once (__DIR__ . '/helpers/config.php');
		require_once __DIR__ . '/helpers/assets.php';
		require_once __DIR__ . '/helpers/svg-icons.php';
		require_once __DIR__ . '/helpers/meta.php';
		require_once __DIR__ . '/helpers/content.php';

		$this->setup();
		$this->adminSetup();

		/**
         * Flush our rewrite rules for new posts
         */
        add_action('after_switch_theme', function() { 
            flush_rewrite_rules(); 
        });

		$this::generalActions();

		$this::actions();
		$this::filters();

		$this->view();
	}

	public function setup() {

		add_action('after_setup_theme', function () {
			require_once __DIR__ . '/setup/clean.php';
			require_once __DIR__ . '/setup/theme.php';
			require_once __DIR__ . '/setup/menu.php';
			require_once __DIR__ . '/setup/starter-content.php';

		});

		ExampleCpt::instance();

		$this::enqueueScripts();

		add_action('widgets_init', function() {
			require_once __DIR__ . '/setup/widgets.php';
		});
	}

	/**
	 * Register and enqueue scripts styles.
	 * 
	 */
	public static function enqueueScripts() {

		/**
		 * Enqueue front-end assets.
		 */
		add_action('wp_enqueue_scripts', function ($hook) {
			Scripts::toEnqueueScript('theme', 'ecrannoir-wptheme-theme-scripts');
			wp_script_add_data('ecrannoir-wptheme-theme-scripts', 'async', true );
			Scripts::toEnqueueStyle('theme');
		});

		/**
		 * Enqueue admin assets.
		 */
		add_action('admin_enqueue_scripts', function($hook) {
			Scripts::toEnqueueScript('admin');
			Scripts::toEnqueueStyle('admin');
		});

		/**
		 * Enqueue editor assets.
		 */
		add_action('init', function($hook) {
			// Skip block registration if Gutenberg is not enabled/merged.
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			Scripts::toRegisterScript('editor', 'ecrannoir-blocks-editor');
			require_once __DIR__ . '/helpers/blocks.php';
			Scripts::toEnqueueStyle( 'editor', 'ecrannoir-block-editor-styles' );
		});

		/**
		 * Enqueue Login Assets
		 */
		add_action( 'login_enqueue_scripts', function() {
			Scripts::toEnqueueScript('login');
			Scripts::toEnqueueStyle('login');

			$style = function() {
				?>
				<style type="text/css">
				#login h1 a, .login h1 a {
					background-image: url(<?php echo get_template_directory_uri() . '/dist/img/logo.svg'; ?>);
					background-size: 80%;
					height: 100px;
					width: 100%;
				}
				</style>
				<?php
			};
			$style();
				
		});


	}

	public function adminSetup() {
		Admin::init();
	}

	public static function generalActions()
	{
		/**
		 * non theme action
		 */

		add_action('template_redirect', 'ecrannoir_theme_redirect' );
		// add_action('get_header', 'ecrannoir_theme_maintenance_mode');
	}

	public static function actions()
	{
		add_action( 'wp_head', [\Assets\Meta::class, 'print_meta'], 5);
		
	}

	public static function filters() {
		// add_filter( 'wp_get_attachment_image_attributes', [\Assets\Image::class, 'filterGetAttachmentImgAttributes']);
		// add_filter('the_content', [\Assets\Image::class, 'filterTheContent'], 15);
		
		add_filter('body_class', 'ecrannoir_theme_filter_body_class');
		add_filter('excerpt_more', 'ecrannoir_theme_filter_excerpt_more');
		add_filter('excerpt_length', 'ecrannoir_theme_filter_excerpt_length');
		add_filter('the_content_more_link', 'ecrannoir_theme_filter_the_content_more_link');

		add_filter('upload_mimes', 'ecrannoir_theme_filter_upload_mimes');

		add_filter('walker_nav_menu_start_el', 'ecrannoir_theme_walker_nav_menu_start_el' ,10, 4);

		add_filter('sanitize_file_name', 'ecrannoir_theme_sanitize_file_name');

		/**
		 * Login
		 */
		add_filter( 'login_headerurl', 'ecrannoir_filter_login_headerurl' );
		if ( version_compare( get_bloginfo( 'version' ), '5.2', '<' ) ) {
			add_filter( 'login_headertitle', 'ecrannoir_filter_login_headertext' );
		}
		add_filter( 'login_headertext', 'ecrannoir_filter_login_headertext' );


		// // Modules
		// add_filter( 'wpcf7_load_js', '__return_false' );
		// add_filter( 'wpcf7_load_css', '__return_false' );

	}

	public static function title() {
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

	public function view() {
		$files = ['index','404','archive','author','category','tag','taxonomy','date’, ’embed','home','frontpage','privacypolicy','page','paged','search','single','singular','attachment'];
		
		foreach( $files as $type ) {
            add_action("{$type}_template_hierarchy", function($templates) {
                
                $return = [];
                
                foreach($templates as $template) {
                    $return[] = 'templates/' . $template;    
                }
                
                return $return;
                
            });
        }   
	}

}
