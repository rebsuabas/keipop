<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Musican
 */

get_header();
?>

	<div id="primary" class="content-area">
		<div class="container">
            <main id="main" class="site-main">

                <section class="error-404 not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'musican' ); ?></h1>
                    </header><!-- .page-header -->

                    <div class="page-content">
                        <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'musican' ); ?></p>

                       <a href="<?php echo esc_url( home_url( '/' ) ); ?>">&larr; <?php echo esc_html__('Back to home', 'musican'); ?></a>

                    </div><!-- .page-content -->
                </section><!-- .error-404 -->

            </main><!-- #main -->
        </div>
	</div><!-- #primary -->

<?php
get_footer();
