<?php
/**
 * The template for displaying the footer copyright
 *
 * @package Musican
 */

?>

<div class="footer-widget">
    <?php 
    if ( is_dynamic_sidebar( 'footer' ) ) {
        dynamic_sidebar( 'footer' );
    }
    ?>
</div>

<div class="site-info">
    <?php do_action( 'musican_footer_copyright' ); ?>
</div><!-- .site-info -->