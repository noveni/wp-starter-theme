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

		self::setup();
		self::adminSetup();

		self::generalActions();
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

}
