<?php
/**
 * Template part for site hero image
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Musican
 */
?>
<div class="section-hero">
    
        <div class="site-hero">
            
            <div class="hero-wrapper">
                <div class="content-center">
                    <h1 class="hero-heading"><?php echo esc_html( get_theme_mod('hero_heading', 'Music is Life') ) ?></h1>
                    <a href="<?php echo esc_url( get_theme_mod( 'hero_btn_link', '#' ) ) ?>"><?php echo esc_html( get_theme_mod('hero_btn_text', 'Get Started') ) ?></a>
                </div>
            </div>
           
        </div>
    
</div>