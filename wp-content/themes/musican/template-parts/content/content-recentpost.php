<?php
/**
 * Template part for displaying posts in Recent Posts widget
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Musican
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-lg-4' ); ?>>

    <?php if ( 'yes' != $hide_thumbnail ) {
       musican_post_thumbnail();
    }  ?>

    <?php if ( 'post' === get_post_type() ) : ?>
        <div class="entry-meta">
            <?php
            musican_posted_on();
            musican_posted_by();
            ?>
        </div><!-- .entry-meta -->
    <?php endif; ?>

	
    <?php
    the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
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

		?>
    </div><!-- .entry-content -->
    


</article><!-- #post-<?php the_ID(); ?> -->
