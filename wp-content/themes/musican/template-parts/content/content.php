<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Musican
 */
$class = is_singular() ? '' : 'col-lg-6 col-sm-6';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>

    <?php musican_post_thumbnail(); ?>

    <?php if ( 'post' === get_post_type() ) : ?>
        <div class="entry-meta">
            <?php
            musican_posted_on();
            musican_posted_by();
            ?>
        </div><!-- .entry-meta -->
    <?php endif; ?>

	
    <?php
    if ( is_singular() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
    else :
        the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
    endif;
    ?>
		

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span> <span class="meta-nav">&rarr;</span>', 'musican' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'musican' ),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->
    
    <?php
    if ( is_single() ) {
        musican_entry_footer();
    }
    ?>

    
</article><!-- #post-<?php the_ID(); ?> -->
