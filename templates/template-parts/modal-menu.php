<?php
/**
 * Displays the menu icon and modal
 *
 * @package WordPress
 
 * @since 1.0.0
 */

?>

<div class="menu-modal cover-modal" data-modal-target-string=".menu-modal">

	<div class="menu-modal-inner modal-inner">

		<div class="menu-wrapper">

			<div class="menu-top section-inner">

				<button class="toggle close-nav-toggle fill-children-current-color" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".menu-modal">
					<span class="toggle-text"><?php _e( 'Close Menu', 'ecrannoir' ); ?></span>
					<?php ecrannoir_the_theme_svg( 'cross' ); ?>
				</button><!-- .nav-toggle -->

			</div><!-- .menu-top -->

			<div class="menu-central">

				<?php

				$mobile_menu_location = '';

				// If the mobile menu location is not set, use the primary and expanded locations as fallbacks, in that order.
				if ( has_nav_menu( 'mobile' ) ) {
					$mobile_menu_location = 'mobile';
				} elseif ( has_nav_menu( 'primary' ) ) {
					$mobile_menu_location = 'primary';
				}

				?>

				<nav class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'ecrannoir' ); ?>" role="navigation">

					<ul class="modal-menu reset-list-style">

					<?php
					if ( $mobile_menu_location ) {

						wp_nav_menu(
							array(
								'container'      => '',
								'items_wrap'     => '%3$s',
								'show_toggles'   => true,
								'theme_location' => $mobile_menu_location,
							)
						);

					} else {

						wp_list_pages(
							array(
								'match_menu_classes' => true,
								'show_toggles'       => true,
								'title_li'           => false,
							)
						);

					}
					?>

					</ul>

			</nav>
			</div><!-- .menu-central -->

			<div class="menu-bottom section-inner">

				<?php if ( has_nav_menu( 'social' ) ) { ?>

					<nav aria-label="<?php esc_attr_e( 'Expanded Social links', 'ecrannoir' ); ?>" role="navigation">
						<ul class="social-menu reset-list-style social-icons fill-children-current-color">

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
					</nav><!-- .social-menu -->

				<?php } ?>

			</div><!-- .menu-bottom -->

		</div><!-- .menu-wrapper -->

	</div><!-- .menu-modal-inner -->

</div><!-- .menu-modal -->
