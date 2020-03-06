<?php
/**
 * Template part for site-branding
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Musican
 */

?>
<div class="site-branding">
    <?php
    the_custom_logo();
    ?>

    <div class="site-identity">
        <?php
        if ( is_front_page() && is_home() ) :
            ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php
        else :
            ?>
            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php
        endif;
        $musican_description = get_bloginfo( 'description', 'display' );
        if ( $musican_description || is_customize_preview() ) :
            ?>
            <p class="site-description"><?php echo $musican_description; /* WPCS: xss ok. */ ?></p>
        <?php endif; ?>
    </div>
</div><!-- .site-branding -->