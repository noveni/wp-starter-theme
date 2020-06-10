<?php
$popups = ecrannoir_get_popups();

?>
<?php if( $popups->have_posts() ): ?>
<button class="toggle popup-toggle helper-toggle-popup"
    data-toggle-target=".popup-modal" data-toggle-body-class="showing-popup-modal" aria-expanded="false" data-set-focus=".close-popup-toggle">
    <span class="toggle-text"><?php _e( 'Open Popup', 'ecrannoir' ); ?></span>
</button>
<div class="popup-modal cover-modal">
    <?php
    // TODO Handle Multiple Popup
    ?>
    <div class="popup-modal-inner">
        <div class="popup-header section-inner">
            <button class="toggle close-popup-toggle" data-toggle-target=".popup-modal" data-toggle-body-class="showing-popup-modal" aria-expanded="false" data-set-focus=".popup-modal">
                <span class="toggle-text"><?php _e( 'Close Popup', 'ecrannoir' ); ?></span>
                <?php ecrannoir_the_theme_svg( 'cross' ); ?>
            </button><!-- .nav-toggle -->
        </div>
        <div class="popup-content section-inner">
            <?php while( $popups->have_posts() ) : ?>
                <?php 
                $popup = $popups->the_post();
                the_content();
                ?>
            <?php endwhile; wp_reset_postdata();?>
        </div>
    </div>
</div>
<?php endif; ?>
