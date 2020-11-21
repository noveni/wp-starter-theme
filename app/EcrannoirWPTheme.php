<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

use Assets\Scripts;
use Admin\Admin;
use Admin\Options;
use PostType\ExampleCpt;
use WP_Error as WP_Error;


class EcrannoirWPTheme
{

	private $theme_settings;
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

		// Retrieve Theme Settings From Database
		$this->theme_settings = get_option( 'ecrannoir-settings-option' );

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
		require_once __DIR__ . '/helpers/assets.php';
		require_once __DIR__ . '/helpers/config.php';
		require_once __DIR__ . '/helpers/content.php';
		require_once __DIR__ . '/helpers/meta.php';
		require_once __DIR__ . '/helpers/svg-icons.php';

		$this->setup();
		$this->comment();
		$this->adminSetup();

		/**
         * Flush our rewrite rules for new posts
         */
        add_action('after_switch_theme', function() { 
            flush_rewrite_rules(); 
        });

		$this->generalActions();

		$this->actions();
		$this::filters();

		$this->view();
	}

	public function setup() {

		add_action('after_setup_theme', function () {
			require_once __DIR__ . '/setup/clean.php';
			require_once __DIR__ . '/setup/menu.php';
			require_once __DIR__ . '/setup/starter-content.php';
			require_once __DIR__ . '/setup/theme.php';
		});

		ExampleCpt::instance();

		$this::enqueueScripts();

		add_action('widgets_init', function() {
			require_once __DIR__ . '/Widgets/widgets.php';
		});

		add_filter( 'wp_revisions_to_keep', function( $num, $post ) {

			if (defined('ECRANNOIR_POST_REVISIONS')) {
				$num = ECRANNOIR_POST_REVISIONS;// Limit revisions otherwise
			}
			
			return $num;
		}, 10, 2 );

		add_image_size( 'custom-size', 220, 180 );
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
		add_action('enqueue_block_editor_assets', function($hook) {
			// Skip block registration if Gutenberg is not enabled/merged.
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			Scripts::toRegisterScript('editor', 'ecrannoir-blocks-editor');
			require_once (THEME_ROOT_DIR_THEME . 'dist/blocks/dynamicblock.php');

			register_block_type( 'ecrannoir/blocks', array( 
				'editor_script' => 'ecrannoir-blocks-editor',
			));
			Scripts::toEnqueueStyle( 'editor', 'ecrannoir-block-editor-styles' );
		});

		add_action( 'init', function($hook) {

			// require_once (THEME_ROOT_DIR_THEME . 'dist/blocks/dynamicblock.php');
		} );

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

		if (is_admin()) {
			$theme_setting = new Options();
		}
	}

	public function generalActions()
	{
		/**
		 * non theme action
		 */

		add_action('template_redirect', 'ecrannoir_theme_redirect' );
		$maintenance_mode = boolval( $this->theme_settings['maintenance_mode'] ?? false);
		if ($maintenance_mode === true) {
			add_action('get_header', 'ecrannoir_theme_maintenance_mode');
		}
	}

	public function actions()
	{
		add_action( 'wp_head', [\Assets\Meta::class, 'print_meta'], 5);
		add_action( 'wp_head', [\Assets\Meta::class, 'printFavicon'], 101);

		if (isset($this->theme_settings['ga_measurement_id'])) {
			add_action( 'wp_head', function() {
				\Assets\Meta::addAnalytics($this->theme_settings['ga_measurement_id']);
			}, 102);
		}
		
		
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

	public function comment() {

		$disable_comment = true;
		
		if ($disable_comment) {

			add_action( 'widgets_init', function() {

				unregister_widget( 'WP_Widget_Recent_Comments' );
				/**
				 * The widget has added a style action when it was constructed - which will
				 * still fire even if we now unregister the widget... so filter that out
				 */
				add_filter( 'show_recent_comments_widget_style', '__return_false' );
			} );

			add_filter( 'wp_headers', function( $headers ) {
				unset( $headers['X-Pingback'] );
				return $headers;
			} );

			add_action( 'template_redirect', function() {
				if ( is_comment_feed() ) {
					wp_die( __( 'Comments are closed.', 'disable-comments' ), '', array( 'response' => 403 ) );
				}
			}, 9 );   // before redirect_canonical.

			// Admin bar filtering has to happen here since WP 3.6.
			add_action( 'template_redirect', [ self::class, 'comment_disable_admin_bar' ] );
			add_action( 'admin_init', [ self::class, 'comment_disable_admin_bar' ] );

			// Disable Comments REST API Endpoint
			add_filter( 'rest_endpoints', function( $endpoints ) {
				unset( $endpoints['comments'] );
				return $endpoints;
			} );

			add_action('wp_before_admin_bar_render', [\Admin\Admin::class, 'removeToolbarItems']);
		}
	}

	public static function comment_disable_admin_bar() {
		if ( is_admin_bar_showing() ) {
			// Remove comments links from admin bar.
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
			if ( is_multisite() ) {
				add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
					if ( $this->networkactive && is_user_logged_in() ) {
						foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
							$wp_admin_bar->remove_menu( 'blog-' . $blog->userblog_id . '-c' );
						}
					} else {
						// We have no way to know whether the plugin is active on other sites, so only remove this one.
						$wp_admin_bar->remove_menu( 'blog-' . get_current_blog_id() . '-c' );
					}
				}, 500 );
			}
		}
	}

}
