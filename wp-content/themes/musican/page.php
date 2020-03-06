<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Musican
 */

get_header();
$col = ! is_active_sidebar( 'sidebar-1' ) ? 12 : 9;

?>

	<div id="primary" class="content-area">
		
        <div class="container">

            <div class="row">

                <main id="main" class="site-main col-lg-<?php echo intval( $col ); ?>">
                <?php
                while ( have_posts() ) :
                    the_post();

                    get_template_part( 'template-parts/content/content', 'page' );

                endwhile; // End of the loop.
                ?>
                </main><!-- #main -->

                <?php get_sidebar() ?>
                
            </div>
            

        </div>

	</div><!-- #primary -->

<?php

get_footer();
