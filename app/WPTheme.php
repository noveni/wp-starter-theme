<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

use Assets\Scripts;
use Admin\Admin;


class WPTheme
{

	public static function init() {

		require_once __DIR__ . '/helpers/config.php';
		require_once __DIR__ . '/helpers/assets.php';
		require_once __DIR__ . '/helpers/svg-icons.php';
		require_once __DIR__ . '/helpers/meta.php';
		require_once __DIR__ . '/helpers/blocks.php';
		require_once __DIR__ . '/helpers/content.php';

		self::setup();
		self::adminSetup();

		self::generalActions();

		self::actions();
		self::filters();
	}

	public static function setup() {

		add_action('after_setup_theme', function () {

			load_theme_textdomain('ecrannoir', get_template_directory() . '/languages');

			require_once __DIR__ . '/setup/clean.php';
			require_once __DIR__ . '/setup/theme.php';
			require_once __DIR__ . '/setup/menu.php';

		});

		self::enqueueScripts();

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
		add_action('enqueue_block_editor_assets', function($hook) {
			// Skip block registration if Gutenberg is not enabled/merged.
			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			Scripts::toRegisterScript('editor', 'ecrannoir-blocks-editor');
			register_block_type( 'ecrannoir/blocks', array( 'editor_script' => 'ecrannoir-blocks-editor'));
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

	public static function adminSetup() {
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

}
