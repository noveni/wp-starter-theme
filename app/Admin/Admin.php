<?php

namespace Admin;

/**
 * Custom icons for this theme.
 *
 * @package WordPress
 
 * @since 1.0.0
 */

if ( ! class_exists( 'Admin\Admin' ) ) {

    class Admin
    {

        public static function init() {

            show_admin_bar(false);

            // Clean the Dashboard
            add_action('wp_dashboard_setup', [\Admin\Admin::class, 'cleanDashboard']);

            add_action('admin_init', function() {
                remove_submenu_page('index.php', 'update-core.php');
                remove_filter('update_footer', 'core_update_footer');
                self::removeMenuItems();
            });

            add_action('admin_menu', function() {
                remove_action('admin_notices', 'update_nag', 3);
            });

            add_filter('admin_footer_text', function() {
                return "<span id=\"footer-thankyou\">Propuslé par <a href=\"https://wpfr.net\">WordPress</a> - Avec  <a href=\"https://ecrannoir.be\">Ecran Noir</a>.</span>";
            });

            add_action('wp_before_admin_bar_render', [\Admin\Admin::class, 'removeToolbarItems']);
            
            
        }


        public static function cleanDashboard() {
            // Remove Meta Box
            // Remove Welcome panel
            remove_action( 'welcome_panel', 'wp_welcome_panel' );
            // Remove the rest of the dashboard widgets
            remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
            remove_meta_box( 'health_check_status', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
            remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal');
        }

        public static function removeToolbarItems()
        {
            global $wp_admin_bar;
            // // General
            // if (in_array('logo', $this->config) || in_array('all', $this->config)) {
            //     $wp_admin_bar->remove_node('wp-logo');
            // }
            // Hide updates
            $wp_admin_bar->remove_node('updates');

            // Comments
            $wp_admin_bar->remove_node('comments');
            // Customizer
            $wp_admin_bar->remove_node('customize');
            // New
            $wp_admin_bar->remove_node('new-media');
            $wp_admin_bar->remove_node('new-user');
        }

        public static function removeMenuItems()
        {
            // remove_menu_page('index.php');
            remove_submenu_page('index.php', 'update-core.php');
            
            // Comments
            remove_menu_page('edit-comments.php');
            // Appearance
            remove_menu_page('themes.php');
            remove_submenu_page('themes.php', 'theme-editor.php');
            // Plugins
            /* remove_menu_page('plugins.php');
            remove_submenu_page('plugins.php', 'plugin-install.php'); */
            remove_submenu_page('plugins.php', 'plugin-editor.php');
            // Users
            /* remove_menu_page('users.php');
            remove_submenu_page('users.php', 'user-new.php');
            remove_menu_page('profile.php');
            remove_submenu_page('users.php', 'profile.php'); */
            // Tools
            /* remove_menu_page('tools.php');
            remove_submenu_page('tools.php', 'import.php');
            remove_submenu_page('tools.php', 'export.php'); */
            // Settings
            /* remove_menu_page('options-general.php');
            remove_submenu_page('options-general.php', 'options-writing.php');
            remove_submenu_page('options-general.php', 'options-reading.php');
            remove_submenu_page('options-general.php', 'options-media.php');
            remove_submenu_page('options-general.php', 'options-permalink.php');
            remove_submenu_page('options-general.php', 'options-discussion.php');
            remove_submenu_page('options-general.php', 'options-media.php');
            remove_submenu_page('options-general.php', 'disable_comments_settings'); */
            // // Advanced Custom Fields
            // if (in_array('acf', $this->config) || in_array('all', $this->config) || in_array('danger-zone', $this->config)) {
            //     remove_menu_page('edit.php?post_type=acf-field-group');
            // }
            // if (in_array('acf-new', $this->config)) {
            //     remove_submenu_page('edit.php?post_type=acf-field-group', 'post-new.php?post_type=acf-field-group');
            // }
            // if (in_array('acf-tools', $this->config)) {
            //     remove_submenu_page('edit.php?post_type=acf-field-group', 'acf-settings-tools');
            // }
            // if (in_array('acf-updates', $this->config)) {
            //     remove_submenu_page('edit.php?post_type=acf-field-group', 'acf-settings-updates');
            // }
        }
    }
}
