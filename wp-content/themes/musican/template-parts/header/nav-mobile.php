<?php
/**
 * Template part for navigation on mobile
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Musican
 */
?>

<div class="nav-form">
    <div class="nav-content">
        <div class="nav-spec">
            <nav class="nav-menu">
               
                <div class="mobile-menu nav-is-visible"><span></span></div>
              
                <?php 
                if ( has_nav_menu( 'primary-menu' ) ) { 
                    wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_id' => 'primary-menu',  'container'  => false, 'after' => '<span class="arrow"></span>' ) );
                } 
                ?>
            </nav>

            <?php get_template_part( 'template-parts/header/social', 'icon' ); ?>
            
        </div>
    </div>
</div>