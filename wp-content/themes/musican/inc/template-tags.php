<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Musican
 */

if ( ! function_exists( 'musican_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function musican_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'on %s', 'post date', 'musican' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'musican_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function musican_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'musican' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'musican_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function musican_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'musican' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in: %1$s', 'musican' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'musican' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged: %1$s', 'musican' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'musican' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

	}
endif;

if ( ! function_exists( 'musican_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function musican_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'musican-featured', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


if ( ! function_exists( 'musican_comments' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @return void
	 */
	function musican_comments( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
                <li class="pingback">
                <p><?php esc_html_e( 'Pingback:', 'musican' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'musican' ), ' ' ); ?></p>
				<?php
				break;
			default :
				?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <div class="comment-author fn vcard">
						<?php echo get_avatar( $comment, 60 ); ?>
						<?php //printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
                    </div><!-- .comment-author .vcard -->

                    <div class="comment-wrapper">
						<?php if ( $comment->comment_approved == '0' ) : ?>
                            <em><?php esc_html_e( 'Your comment is awaiting moderation.', 'musican' ); ?></em>
						<?php endif; ?>

                        <div class="comment-meta comment-metadata">
                            <strong><?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?></strong>
                            <span class="says"><?php esc_html_e( 'says:', 'musican' ) ?></span><br>
                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
									<?php
									/* translators: 1: date, 2: time */
									printf( esc_html__( '%1$s at %2$s', 'musican' ), get_comment_date(), get_comment_time() ); ?>
                                </time></a>
                        </div><!-- .comment-meta .commentmetadata -->
                        <div class="comment-content"><?php comment_text(); ?></div>
                        <div class="comment-actions">
							<?php comment_reply_link( array_merge( array( 'after' => '<i class="fa fa-reply"></i>' ), array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                        </div><!-- .reply -->
                    </div> <!-- .comment-wrapper -->

                </article><!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
endif;


/*
Custom style
*/
function musican_custom_style() {
    $custom_css = '';

    $primary_color   = esc_html( get_theme_mod( 'primary_color', '#fb3b64' ) );
    $header_image = get_header_image();

    $custom_css .= "
        a:hover,
        .upcoming-events .all-events-btn a,
        .entry-meta a,
        .view-all-blog a,
        .blog a.more-link .meta-nav, .archive a.more-link .meta-nav,
        .main-navigation ul ul a:hover, .main-navigation ul ul a.focus,
        .header-transparent .site-header .social_header_icons a:hover {
            color: $primary_color;
        }

        button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"],
        .site-header,
        .hero-wrapper a,
        .site-footer {
            background-color: $primary_color;
        }

        button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"],
        .wp-block-quote:not(.is-large):not(.is-style-large),
        .hero-wrapper a {
            border-color: $primary_color;
        }
    ";

    if ( $header_image ) {
        $custom_css .= ".section-hero { background-image: url('". $header_image ."')}";
    }

    return $custom_css;
}