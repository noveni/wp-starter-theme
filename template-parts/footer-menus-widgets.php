<?php
/**
 * Displays the menus and widgets at the end of the main element.
 * Visually, this output is presented as part of the footer element.
 *
 * @package WordPress
 
 * @since 1.0.0
 */

$has_footer_menu = has_nav_menu( 'footer' );
$has_social_menu = has_nav_menu( 'social' );

$widget_footer_top = is_active_sidebar( 'widget-footer-top' );
$widget_footer_left = is_active_sidebar( 'widget-footer-left' );
$widget_footer_right = is_active_sidebar( 'widget-footer-right' );

// Only output the container if there are elements to display.
if ( $has_footer_menu || $has_social_menu || $widget_footer_top || $widget_footer_left || $widget_footer_right ) {
	?>

	<div class="footer-nav-widgets-wrapper header-footer-group">

		<div class="footer-inner section-inner">

			<?php

			$footer_top_classes = '';

			$footer_top_classes .= $has_footer_menu ? ' has-footer-menu' : '';
			$footer_top_classes .= $has_social_menu ? ' has-social-menu' : '';

			if ( $has_footer_menu || $has_social_menu || $widget_footer_top) {
				?>
				<div class="footer-top<?php echo $footer_top_classes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
					<?php if ( $has_footer_menu ) { ?>

						<nav aria-label="<?php esc_attr_e( 'Footer', 'ecrannoir' ); ?>" role="navigation" class="footer-menu-wrapper">

							<ul class="footer-menu reset-list-style">
								<?php
								wp_nav_menu(
									array(
										'container'      => '',
										'depth'          => 1,
										'items_wrap'     => '%3$s',
										'theme_location' => 'footer',
									)
								);
								?>
							</ul>

						</nav><!-- .site-nav -->

					<?php } ?>
					<?php if ( $has_social_menu ) { ?>

						<nav aria-label="<?php esc_attr_e( 'Social links', 'ecrannoir' ); ?>" class="footer-social-wrapper">

							<ul class="social-menu footer-social reset-list-style social-icons fill-children-current-color">

								<?php
								wp_nav_menu(
									array(
										'theme_location'  => 'social',
										'container'       => '',
										'container_class' => '',
										'items_wrap'      => '%3$s',
										'menu_id'         => '',
										'menu_class'      => '',
										'depth'           => 1,
										'link_before'     => '<span class="screen-reader-text">',
										'link_after'      => '</span>',
										'fallback_cb'     => '',
									)
								);
								?>

							</ul><!-- .footer-social -->

						</nav><!-- .footer-social-wrapper -->

					<?php } ?>
					<?php if ( $widget_footer_top) { ?>
						<div class="footer-widgets-wrapper">
							<div class="footer-widgets">
								<?php dynamic_sidebar( 'widget-footer-top' ); ?>
							</div>
						</div>
					<?php } ?>
				</div><!-- .footer-top -->

			<?php } ?>

			<?php if ( $widget_footer_left || $widget_footer_right ) { ?>

				<aside class="footer-widgets-outer-wrapper" role="complementary">

					<div class="footer-widgets-wrapper">

						<?php if ( $widget_footer_left ) { ?>

							<div class="footer-widgets column-one grid-item">
								<?php dynamic_sidebar( 'widget-footer-left' ); ?>
							</div>

						<?php } ?>

						<?php if ( $widget_footer_right ) { ?>

							<div class="footer-widgets column-two grid-item">
								<?php dynamic_sidebar( 'widget-footer-right' ); ?>
							</div>

						<?php } ?>

					</div><!-- .footer-widgets-wrapper -->

				</aside><!-- .footer-widgets-outer-wrapper -->

			<?php } ?>

		</div><!-- .footer-inner -->

	</div><!-- .footer-nav-widgets-wrapper -->

<?php } ?>
