<?php
/**
 * Register Widget
 */

// register My_Widget
add_action( 'widgets_init', function(){
    register_widget( 'EcranNoir_Widget_Link_Page' );
    
    $config = [
        'before_title'  => '<h3 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h3>',
        'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
    ];

    register_sidebar(
        array_merge(
            $config,
            array(
                'name'          => __('Footer Top', 'ecrannoir'),
                'id'            => 'widget-footer-top',
                'description' => __( 'Widgets in this area will be displayed on the top of the footer.', 'ecrannoir' ),
                'before_title'  => '<div class="section-inner"><h3 class="widget-title subheading heading-size-3">',
		        'after_title'   => '</h3><a class="button btn-noline" href="https://www.instagram.com/jehannemoll/"><i>@jehannemoll</i></a></div>',
            )
        )
    );
    // Footer Left Column
    register_sidebar(
        array_merge(
            $config,
            array(
                'name'          => __('Footer Left Column', 'ecrannoir'),
                'id'            => 'widget-footer-left',
                'description'   => __( 'Widgets in this area will be displayed in the first column in the footer.', 'ecrannoir' ),
            )
        )
    );
    // Footer Right Column
    register_sidebar(
        array_merge(
            $config,
            array(
                'name'          => __('Footer Right Column', 'ecrannoir'),
                'id'            => 'widget-footer-right',
                'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'ecrannoir' ),
            )
        )
    );
});
