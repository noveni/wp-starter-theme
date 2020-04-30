<?php

namespace Widgets;

/**
 * Custom Widget to add a link of internal page
 *
 * @package WordPress
 
 * @since 1.0.0
 */
if ( class_exists( 'WP_Widget' ) && ! class_exists( 'EcranNoir_Widget_Link_Page' ) ) {

    class LinkPage extends \WP_Widget {
        
        public function __construct() {
            $widget_ops = array( 
                'classname' => 'widget_link_page',
                'description' => 'Widget used to add dynamic link page',
            );
            parent::__construct( 'widget_link_page', 'Ecran Noir Widget Page Link', $widget_ops );
        }
        
        // output the widget content on the front-end
        public function widget( $args, $instance ) {
            echo $args['before_widget'];
            $page_link = '';
            $cta_label = esc_html__( 'Call To Action', 'ecrannoir' );
            if( !empty( $instance['selected_page']) ){ 
                $selected_page = get_post( $instance['selected_page'] );
                $page_link = get_permalink( $selected_page->ID );
                $cta_label = $selected_page->post_title;
            } 
            if( !empty( $instance['cta_label']) ){ 
                $cta_label = $instance['cta_label'];
            }
            ?>
            <div class="wp-block-button is-style-underline-center">
                <a class="button wp-block-button__link" href="<?php echo $page_link; ?>"><span><?php echo $cta_label; ?></span></a>
            </div>
            <?php
            echo $args['after_widget'];
        }
    
        // output the option form field in admin Widgets screen
        public function form( $instance ) {
            

            $pages = get_pages();
            $selected_page = !empty($instance['selected_page']) ? $instance['selected_page'] : false;
            ?>
            <ul>
                <?php foreach ( $pages as $page ) { ?>
                    <li>
                        <input
                            type="radio"
                            name="<?php echo esc_attr( $this->get_field_name( 'selected_page' ) ); ?>" 
                            value="<?php echo $page->ID; ?>"
                            <?php checked($selected_page, $page->ID ); ?> >
                            <?php echo get_the_title( $page->ID ); ?></li>
                    </li>
                <?php } ?>
            </ul>
            <?php
            $cta_label = ! empty( $instance['cta_label'] ) ? $instance['cta_label'] : esc_html__( 'Call To Action', 'ecrannoir' );
            ?>
            <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>">
            <?php esc_attr_e( 'Title:', 'ecrannoir' ); ?>
            </label> 
            
            <input 
                class="widefat" 
                id="<?php echo esc_attr( $this->get_field_id( 'cta_label' ) ); ?>" 
                name="<?php echo esc_attr( $this->get_field_name( 'cta_label' ) ); ?>" 
                type="text" 
                value="<?php echo esc_attr( $cta_label ); ?>">
            </p>
            <?php
        }
    
        // save options
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['cta_label'] = ( ! empty( $new_instance['cta_label'] ) ) ? strip_tags( $new_instance['cta_label'] ) : '';
                
            $instance['selected_page'] = (!empty($new_instance['selected_page'])) ? sanitize_text_field($new_instance['selected_page']) : '';

            return $instance;
        }
    }
}
