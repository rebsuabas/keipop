<?php
/**
 * Template part for navigation
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Musican
 */
?>

<nav id="site-navigation" class="main-navigation">
    
    <?php
    if ( has_nav_menu( 'primary-menu' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary-menu',
            'menu_id'        => 'primary-menu',
            'container'      => false
        ) );
    }
    
    ?>
</nav><!-- #site-navigation -->