<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 */

?>
			
			<footer id="site-footer" role="contentinfo">

				<div class="section-inner col-r">
					<div class="colm-12 col-4 col-osr-1 footer-titles-wrapper">
						<a class="footer-logo" href="<?php echo esc_url( get_home_url( null, '/' ) ) ?>">
							<?php echo \Assets\Icons::get_svg('logo', 'brand'); ?>
						</a>
						<div class="footer-description">
							<?php if (is_active_sidebar('widget-footer-description')): ?>
								<?php dynamic_sidebar( 'widget-footer-description' ); ?>
							<?php endif; ?>
						</div>
						<?php if (has_nav_menu( 'footer' )) : ?>
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
							</ul>
						</nav>
						<?php endif; ?>
					</div>
					<div class="colm-6 col-3">
						<?php if (has_nav_menu( 'footer' )) : ?>						
						<nav aria-label="<?php esc_attr_e( 'Footer', 'ecrannoir' ); ?>" role="navigation" class="footer-menu-wrapper">
							<h3>Menu</h3>
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
						</nav><!-- .footer-menu-wrapper -->
						<?php endif; ?>
					</div>
					<div class="colm-6 col-3 col-osr-1">
						<div class="footer-contact">
							<?php 

							if ( is_active_sidebar('widget-footer-description') ) :
								dynamic_sidebar( 'widget-footer-contact' );
							endif;

							?>
						</div>

					</div>
				</div>
				<div class="section-inner">

					<div class="footer-credits">
						<p>
							<span>&copy; <?php echo date_i18n(_x( 'Y', 'copyright date format', 'ecrannoir' )); /* translators: Copyright date format, see https://secure.php.net/date */?>
								- <strong><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></strong>	
							<?php ecsep(); ?>
							<span>Tous droits réservés</span>
							<?php ecsep('hide-on-mobile'); ?>
							<span class="created-by"><?php _e( 'Site créé par', 'ecrannoir' ); ?> <a href="https://tampala.be/" target="_blank" rel="noopener noreferrer"><strong>Tampala Studio</strong></a> & <a href="https://ecrannoir.be/" target="_blank" rel="noopener noreferrer"><strong>Ecran Noir</strong></a></span>
							<?php echo "<br>"; ?>
							<span class="cgv"><a href="#">Politique de confidentialité</a></span>
							<?php ecsep(); ?>
							<span class="legal"><a href="#">Mentions légales</a></span>
						</p><!-- .footer-copyright -->

					</div><!-- .footer-credits -->

					<a class="to-the-top" href="#site-header">
						<span class="to-the-top-short">
							<?php
							/* translators: %s: HTML character for up arrow */
							printf( __( 'Up %s', 'ecrannoir' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
							?>
						</span><!-- .to-the-top-short -->
					</a><!-- .to-the-top -->

				</div><!-- .section-inner -->

			</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

	</body>
</html>
