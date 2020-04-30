<?php

namespace Assets;

if ( ! class_exists( 'Assets\Scripts' ) ) {

    class Scripts
    {
        /**
		 * Adds async/defer attributes to enqueued / registered scripts.
		 *
		 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
		 *
		 * @link https://core.trac.wordpress.org/ticket/12009
		 *
		 * @param string $tag    The script tag.
		 * @param string $handle The script handle.
		 * @return string Script HTML string.
		 */
		public function filter_script_loader_tag( $tag, $handle ) {
			foreach ( [ 'async', 'defer' ] as $attr ) {
				if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
					continue;
				}
				// Prevent adding attribute when already added in #12009.
				if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
				}
				// Only allow async or defer, not both.
				break;
			}
			return $tag;
        }
        
        public static function toEnqueueScript($scriptName, $customHandleScriptName = '') {

            $script_asset_path = get_template_directory() . '/dist/scripts/' . $scriptName . '.asset.php';
			$script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
			
			$handleFileName = $customHandleScriptName !== '' ?? 'ecrannoir-wptheme-' . $styleName . '-scripts';
            // Enqueue Scripts
            wp_enqueue_script($handleFileName, get_template_directory_uri() . '/dist/scripts/' . $scriptName . '.js', $script_asset['dependencies'], $script_asset['version'], true);
        }

        public static function toEnqueueStyle($styleName, $customHandleStyleName = '') {

            $script_asset_path = get_template_directory() . '/dist/scripts/' . $styleName . '.asset.php';
			$script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
			
			$handleFileName = $customHandleStyleName !== '' ?? 'ecrannoir-wptheme-' . $styleName . '-styles';
            // Enqueue Style
            wp_enqueue_style($handleFileName, get_template_directory_uri() . '/dist/' . $styleName . '.css', array(), $script_asset['version'], 'all');
		}
		
		public static function toRegisterScript($scriptName, $customHandleScriptName) {

			$script_asset_path = get_template_directory() . '/dist/scripts/' . $scriptName . '.asset.php';
			$script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
			
			wp_register_script($customHandleScriptName, get_template_directory_uri() . '/dist/scripts/' . $scriptName . '.js', $script_asset['dependencies'], $script_asset['version']);
		}
    }
    

}
