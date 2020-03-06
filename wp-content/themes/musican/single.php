<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

                    get_template_part( 'template-parts/content/content', get_post_type() );

                    the_post_navigation(
                        array(
                            'prev_text'    => __( '<span>&larr; prev post</span> %title', 'musican' ),
                            'next_text'    => __( '<span>next post &rarr;</span> %title', 'musican' ),
                        )
                    );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>

                </main><!-- #main -->

                <?php get_sidebar() ?>

            </div>
        </div>
	</div><!-- #primary -->

<?php

get_footer();
