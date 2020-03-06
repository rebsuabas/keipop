<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Musican
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
//wp_body_open hook from WordPress 5.2
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'musican' ); ?></a>

    <?php get_template_part( 'template-parts/header/nav', 'mobile' ); ?>

	<header id="masthead" class="site-header">
		
        <div class="container-fluid">

            <?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
            
            <?php get_template_part( 'template-parts/header/navigation', 'primary' ); ?>  

            <a href="#" class="mobile-menu" id="mobile-open"><span></span></a>

            <?php get_template_part( 'template-parts/header/social', 'icon' ); ?>
            
        </div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">

        <?php 
        if ( is_front_page() && ! is_home() ) {
            get_template_part( 'template-parts/header/site', 'hero' );
        }
        ?>  