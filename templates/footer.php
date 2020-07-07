<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 
 * @since 1.0.0
 */
$sep = function() {
	echo '<span class="separator"> | </span>';
}
?>
			<?php get_template_part( 'templates/template-parts/footer-menus-widgets' ); ?>
			<footer id="site-footer" role="contentinfo" class="header-footer-group">

				<div class="section-inner">
					
				</div>
				<div class="section-inner">

					<div class="footer-credits">
						<p>
							<span>&copy; <?php echo date_i18n(_x( 'Y', 'copyright date format', 'ecrannoir' )); /* translators: Copyright date format, see https://secure.php.net/date */?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
							</span>
							<?php $sep() ?>
							<span>Tous droits réservés</span>
							<?php $sep() ?>
							<span><?php _e( 'Site crée par', 'ecrannoir' ); ?> <a href="https://tampala.be/">Tampala Studio</a> & <a href="https://ecrannoir.be/">Ecran Noir</a></span>
							<?php $sep() ?>
							<span class="cgv"><a href="#">Politique de confidentialité</a></span>
							<?php $sep() ?>
							<span class="legal"><a href="#">Mentions légales</a></span>
						</p><!-- .footer-copyright -->

					</div><!-- .footer-credits -->

					<a class="to-the-top" href="#site-header">
						<span class="to-the-top-long">
							<?php
							/* translators: %s: HTML character for up arrow */
							printf( __( 'To the top %s', 'ecrannoir' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
							?>
						</span><!-- .to-the-top-long -->
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
