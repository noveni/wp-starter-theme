<?php

namespace Admin;


if ( ! class_exists( 'Admin\Options' ) ) {

    class Options
    {
        /**
         * Holds the values to be used in the fields callbacks
         */
        private $options;

        public function __construct() {
            add_action( 'admin_menu', [$this, 'addPage']);
            add_action( 'admin_init', [$this, 'pageInit']);
        }

        public static function init()
        {
            new \Admin\Options();
        }

        public function addPage()
        {
            add_options_page(
                'Theme Options', // page <title>Title</title>
                'Theme options', // menu link text
                'manage_options', // capability to access the page
                'ecrannoir-theme-settings', // page URL slug
                [$this, 'addContent'], // callback function with content
                2 // priority
            );
        }

        public function addContent()
        {
            $this->options = get_option( 'ecrannoir-settings-option' );
            ?>
            <div class="wrap">
                <h1>Thème settings</h1>
                <form method="post" action="options.php">
                    <?php settings_fields( 'ecrannoir-settings' ); ?>
                    <?php do_settings_sections( 'ecrannoir-theme-settings' ); ?>
                    <?php submit_button(); ?>
                </form>
            </div>

            <?php
        }

        public function pageInit()
        {

            register_setting(
                'ecrannoir-settings', // settings group name
                'ecrannoir-settings-option', // option name
                [$this, 'sanitize'] // sanitization function
            );

            add_settings_section(
                'setting_section_general', // ID
                'General settings', // Title
                '', // array( $this, 'printSectionInfo', ['Setup general control:'] ), // Callback
                'ecrannoir-theme-settings' // Page
            );

            add_settings_field(
                'ga_measurement_id', // ID
                'Google Analytics Code', // Title 
                array( $this, 'googleAnalyticsFieldHtml' ), // Callback
                'ecrannoir-theme-settings', // Page
                'setting_section_general' // Section           
            );  

            add_settings_field(
                'maintenance_mode', // ID
                'Maintenance Mode', // Title 
                array( $this, 'maintenanceModeCallback' ), // Callback
                'ecrannoir-theme-settings', // Page
                'setting_section_general' // Section           
            );  

            add_settings_section(
                'setting_section_template', // ID
                'Template Settings', // Title
                '', //array( $this, 'printSectionInfo', ['Choose the layout of the template'] ), // Callback
                'ecrannoir-theme-settings' // Page
            );

            add_settings_field(
                'header_layout', // ID
                'Header Layout', // Title 
                array( $this, 'headerLayoutHtml' ), // Callback
                'ecrannoir-theme-settings', // Page
                'setting_section_template' // Section           
            );  
        }

        /**
         * Sanitize each setting field as needed
         *
         * @param array $input Contains all settings fields as array keys
         */
        public function sanitize( $input )
        {
            $new_input = array();
            if( isset( $input['maintenance_mode'] ) )
                $new_input['maintenance_mode'] = boolval( $input['maintenance_mode'] === 'on' ? true : false );

            if( isset( $input['header_layout'] ) )
                $new_input['header_layout'] = sanitize_text_field( $input['header_layout'] );
                
            if( isset( $input['ga_measurement_id'] ) )
                $new_input['ga_measurement_id'] = sanitize_text_field( $input['ga_measurement_id'] );

            return $new_input;
        }


        /** 
         * Print the Section text
         */
        public function printSectionInfo($text = '')
        {
            print $text;
        }

        public function maintenanceModeCallback()
        {
            $field_value = isset( $this->options['maintenance_mode'] ) ? boolval( $this->options['maintenance_mode']) : false;
            ?>
            <div>
            <input type="radio" id="maintenance_mode_off" name="ecrannoir-settings-option[maintenance_mode]" value="off" <?php echo $field_value === false ? 'checked' : '' ?>>
            <label for="maintenance_mode_off">Off</label>
            </div>
            <div>
                <input type="radio" id="maintenance_mode_on" name="ecrannoir-settings-option[maintenance_mode]" value="on" <?php echo $field_value === true ? 'checked' : '' ?>>
                <label for="maintenance_mode_on">On</label>
            </div>
            <?php
        }

        public function headerLayoutHtml()
        {
            $field_value = isset( $this->options['header_layout'] ) ? esc_attr( $this->options['header_layout']) : '';
            ?>
            <select name="ecrannoir-settings-option[header_layout]" id="header-layout-select">
                <option value="">--Please choose an option--</option>
                <option value="style-1" <?php echo $field_value === 'style-1' ? 'selected' : '' ?>>Style 1</option>
                <option value="style-2" <?php echo $field_value === 'style-2' ? 'selected' : '' ?>>Style 2</option>
            </select>

            <?php
        }


        public function googleAnalyticsFieldHtml()
        {
            $field_value = $this->options['ga_measurement_id'] ?? '';

            printf(
                '<input type="text" id="ga_measurement_id" name="ecrannoir-settings-option[ga_measurement_id]" value="%s" />',
                esc_attr( $field_value )
            );

        }

    }
    

}
