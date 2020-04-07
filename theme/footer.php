        <footer id="site-footer" role="contentinfo">
            <div class="footer-credits">
                <p class="footer-copyright">
                    <?php
                    echo date_i18n(
                        /* translators: Copyright date format, see https://secure.php.net/date */
                        _x( 'Y', 'copyright date format', 'mythemename' )
                    );
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                </p><!-- .footer-copyright -->
            </div><!-- .footer-credits -->
        </footer><!-- #site-footer -->
    </body>
</html>
