<?php
/**
 * Header file for the theme.
 *
 */

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >

    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class('template-full-width'); ?>>

    <?php
    wp_body_open();
    ?>

    <header id="site-header" class="sticky-header" role="banner">
    <?php
        get_template_part( 'templates/partials/header-styles/header', 'style1' );
    ?>
    </header>
   
    <?php
    // Output the menu modal.
    get_template_part( 'templates/template-parts/modal-menu' );
