<?php
/**
 * Register and enqueue scripts styles.
 * 
 */

/**
 * Enqueue front-end assets.
 */
add_action('wp_enqueue_scripts', function ($hook) {

    $script_asset_path = get_template_directory() . '/dist/scripts/theme.asset.php';
    $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
    // Enqueue Scripts
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/dist/scripts/theme.js', $script_asset['dependencies'], $script_asset['version'], true);
    wp_script_add_data('theme-scripts', 'async', true );

    // Enqueue Styles
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/dist/theme.css', array(), $script_asset['version'], 'all');
    
});

/**
 * Enqueue admin assets.
 */
add_action('admin_enqueue_scripts', function($hook) {


    $script_asset_path = get_template_directory() . '/dist/scripts/admin.asset.php';
    $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
    // Enqueue Scripts
    wp_enqueue_script('theme-admin-scripts', get_template_directory_uri() . '/dist/scripts/admin.js', $script_asset['dependencies'], $script_asset['version'], true);

    // Enqueue Styles
    wp_enqueue_style('theme-admin-styles', get_template_directory_uri() . '/dist/admin.css', array(), $script_asset['version']);
});

/**
 * Enqueue editor assets.
 */
add_action('enqueue_block_editor_assets', function($hook) {
    // Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
    $script_asset_path = get_template_directory() . '/dist/scripts/editor.asset.php';

    $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));

    wp_register_script(
		'ecrannoir-blocks-editor',
		get_template_directory_uri() . "/dist/scripts/editor.js",
		$script_asset['dependencies'],
        $script_asset['version']
    );
    register_block_type( 'ecrannoir/blocks', array(
		'editor_script' => 'ecrannoir-blocks-editor',
	));
    // Enqueue the editor script.
    // wp_enqueue_script( 'theme-block_editor-scripts', get_template_directory_uri() . '/dist/scripts/editor.js' , $script_asset['dependencies'], $script_asset['version'], true );
    
    // Enqueue the editor styles.
    wp_enqueue_style( 'ecrannoir-block-editor-styles', get_template_directory_uri() . '/dist/editor.css' , array(), $script_asset['version'], 'all' );
});

/**
 * Enqueue Login Assets
 */
add_action( 'login_enqueue_scripts', function() {
    if ( $GLOBALS['pagenow'] !== 'wp-login.php' ) {

        $script_asset_path = get_template_directory() . '/dist/scripts/admin.asset.php';
        $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime( $script_path ));
        // Enqueue Scripts
        wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/dist/scripts/login.js', $script_asset['dependencies'], $script_asset['version'], true);
        // Enqueue Styles
        wp_enqueue_style('theme-styles', get_template_directory_uri() . '/dist/login.css', array(), $script_asset['version'], 'all');
    } else { ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url(<?php echo get_template_directory_uri() . '/dist/img/logo-color.svg'; ?>);
                background-size: 80%;
                height: 100px;
                width: 100%;
            }
        </style>
        <?php
    }
});
