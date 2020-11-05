    <div class="header-inner section-inner">
        <!-- Logo -->
        <div class="header-titles">
            <?php
                // Site title or logo.
                ecrannoir_theme_site_logo();

            ?>
        </div><!-- .header-titles -->


        <!-- Menu -->

        <nav class="primary-menu-wrapper header-nav" aria-label="<?php esc_attr_e( 'Horizontal', 'ecrannoir' ); ?>" role="navigation">

            <ul class="primary-menu reset-list-style">

            <?php
            if ( has_nav_menu( 'primary' ) ) {

                wp_nav_menu(
                    array(
                        'container'  => '',
                        'items_wrap' => '%3$s',
                        'theme_location' => 'primary',
                        'walker' => new Assets\EcranNoirWalkerMenu()
                    )
                );

            } else {

                wp_list_pages(
                    array(
                        'match_menu_classes' => true,
                        'show_sub_menu_icons' => true,
                        'title_li' => false,
                    )
                );

            }
            ?>

            </ul>

        </nav><!-- .primary-menu-wrapper -->

        <!-- Toggles -->
        <div class="header-toggle-wrapper">
            <button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                <span class="toggle-inner">
                    <?php ecrannoir_the_theme_svg( 'search' ); ?>
                </span>
            </button><!-- .search-toggle -->
                
            <button class="toggle nav-toggle mobile-nav-toggle hamburger hamburger--stand" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button><!-- .nav-toggle -->
        </div>
    </div>
    <?php
        // get_template_part( 'templates/partials/inline-search' );
        get_template_part( 'templates/template-parts/modal-search' );
    ?>
