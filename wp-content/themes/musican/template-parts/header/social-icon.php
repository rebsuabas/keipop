<?php
/**
 * Template part for header social icons
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Musican
 */

?>

<div class="social-links">

    <?php
    if ( has_nav_menu( 'social-menu' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'social-menu',
            'container'      => false,
            'link_before' => '<span class="screen-reader-text">',  
            'link_after'   => '</span>'  
        ) );
    }
    
    ?>

</div>