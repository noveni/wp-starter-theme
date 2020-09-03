<?php
/**
 * Header file for the theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @since 1.0.0
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >

    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>

    <?php if (GA_MEASUREMENT_ID !== false): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162787679-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-162787679-1');
    </script>
    <?php endif; ?>
</head>
<body <?php body_class(); ?>>

    <?php
    wp_body_open();
    ?>

    <header id="site-header" class="header-footer-group" role="banner">

        <div class="header-inner section-inner">

            <div class="header-titles-wrapper">

                <?php

                // Check whether the header search is activated in the customizer.
                $enable_header_search = get_theme_mod( 'enable_header_search', true );

                if ( true === $enable_header_search ) {

                    ?>

                    <button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                        <span class="toggle-inner">
                            <span class="toggle-icon">
                                <?php ecrannoir_the_theme_svg( 'search' ); ?>
                            </span>
                            <span class="toggle-text"><?php _e( 'Search', 'ecrannoir' ); ?></span>
                        </span>
                    </button><!-- .search-toggle -->

                <?php } ?>

                <div class="header-titles">

                    <?php
                        // Site title or logo.
                        ecrannoir_theme_site_logo();

                    ?>

                </div><!-- .header-titles -->

                <button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
                    <span class="toggle-inner">
                        <span class="toggle-icon">
                            <?php ecrannoir_the_theme_svg( 'ellipsis' ); ?>
                        </span>
                        <span class="toggle-text"><?php _e( 'Menu', 'ecrannoir' ); ?></span>
                    </span>
                </button><!-- .nav-toggle -->

            </div><!-- .header-titles-wrapper -->

            <div class="header-navigation-wrapper">

                <?php
                if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
                    ?>

                        <nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'ecrannoir' ); ?>" role="navigation">

                            <ul class="primary-menu reset-list-style">

                            <?php
                            if ( has_nav_menu( 'primary' ) ) {

                                wp_nav_menu(
                                    array(
                                        'container'  => '',
                                        'items_wrap' => '%3$s',
                                        'theme_location' => 'primary',
                                    )
                                );

                            } elseif ( ! has_nav_menu( 'expanded' ) ) {

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

                    <?php
                }

                if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
                    ?>

                    <div class="header-toggles hide-no-js">

                    <?php
                    if ( has_nav_menu( 'expanded' ) ) {
                        ?>

                        <div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

                            <button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
                                <span class="toggle-inner">
                                    <span class="toggle-text"><?php _e( 'Menu', 'ecrannoir' ); ?></span>
                                    <span class="toggle-icon">
                                        <?php ecrannoir_the_theme_svg( 'ellipsis' ); ?>
                                    </span>
                                </span>
                            </button><!-- .nav-toggle -->

                        </div><!-- .nav-toggle-wrapper -->

                        <?php
                    }

                    if ( true === $enable_header_search ) {
                        ?>

                        <div class="toggle-wrapper search-toggle-wrapper">

                            <button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                <span class="toggle-inner">
                                    <?php ecrannoir_the_theme_svg( 'search' ); ?>
                                    <span class="toggle-text"><?php _e( 'Search', 'ecrannoir' ); ?></span>
                                </span>
                            </button><!-- .search-toggle -->

                        </div>

                        <?php
                    }
                    ?>

                    </div><!-- .header-toggles -->
                    <?php
                }
                ?>

            </div><!-- .header-navigation-wrapper -->

        </div><!-- .header-inner -->

        <?php
        // Output the search modal (if it is activated in the customizer).
        if ( true === $enable_header_search ) {
            get_template_part( 'templates/template-parts/modal-search' );
        }
        ?>

    </header><!-- #site-header -->
    
    <?php
    // Output the menu modal.
    get_template_part( 'templates/template-parts/modal-menu' );
