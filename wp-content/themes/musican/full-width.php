<?php
/**
 *Template Name: Full Width
 *
 * @package Musican
 */
get_header();
?>

	<div id="primary" class="content-area">
		
        <div class="container">

                <main id="main" class="site-main ">
                <?php
                while ( have_posts() ) :
                    the_post();

                    get_template_part( 'template-parts/content/content', 'page' );

                endwhile; // End of the loop.
                ?>
                </main><!-- #main -->
        </div>

	</div><!-- #primary -->

<?php
get_footer();