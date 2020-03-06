<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Musican
 */

get_header();
?>

	<section id="primary" class="content-area">
		<div class="container">
            <div class="row">

                <main id="main" class="site-main col-lg-9">

                     <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            /* translators: %s: search query. */
                            printf( esc_html__( 'Search Results for: %s', 'musican' ), '<span>' . get_search_query() . '</span>' );
                            ?>
                        </h1>
                    </header><!-- .page-header -->

                    <div class="row">
                        <?php if ( have_posts() ) : ?>

                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();

                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'template-parts/content/content', get_post_type() );

                        endwhile;

                        the_posts_navigation();

                        else :

                        get_template_part( 'template-parts/content/content', 'none' );

                        endif;
                        ?>
                    </div>

                </main><!-- #main -->
                
                <?php get_sidebar() ?>

            </div>
        </div>
	</section><!-- #primary -->

<?php
get_footer();
