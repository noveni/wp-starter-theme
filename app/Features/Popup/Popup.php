<?php

namespace Features\Popup;

use Assets\Scripts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'Features\Popup\Popup' ) ) {

	class Popup
	{

		/**
		 * Determines whether a class has already been instanciated.
		 *
		 * @access private
		 */
		private static $instance = null;   

		public static function instance()
		{
			$class = get_called_class();
			if ( ! isset(self::$instance[$class]) ) {
				self::$instance[$class] = new $class();
			}

			return self::$instance[$class];
		}

		/** 
		 * Constructor. This allows the class to be only initialized once.
		 */
		public function __construct() {

			require_once(__DIR__ . '/helpers.php');
			
			// require_once __DIR__ . '/F/clean.php';
			// Set our properties based upon the arrays defined within a view
			// $this->setConfigurations();

			// add_action('init', [$this, 'initPostType']);

			$popupCpt = PopupCpt::instance();
			add_action('init', [$popupCpt, 'setMeta']);

			add_action( 'enqueue_block_editor_assets', function(){

				$screen = get_current_screen();
				if( $screen->post_type !== 'ecrannoir_popup_pt' ) return; // disabled for Pages
				Scripts::toEnqueueScript('adminPopup');
			 
			});
			// Enqueue front-end assets.
			add_action('wp_enqueue_scripts', function ($hook) {
				Scripts::toEnqueueScript('popup');
				Scripts::toEnqueueStyle('popup', false, ['ecrannoir-wptheme-theme-styles']);
			}, 11);
		}
	}

}
