<?php/** * Template part for displaying posts * * @package minimal-portfolio */?><?php	$minimal_portfolio_single_blog_meta_date = minimal_portfolio_get_option( 'minimal_portfolio_single_blog_meta_date' );	$minimal_portfolio_single_blog_meta_author = minimal_portfolio_get_option( 'minimal_portfolio_single_blog_meta_author' );	$minimal_portfolio_single_blog_meta_category = minimal_portfolio_get_option( 'minimal_portfolio_single_blog_meta_category' );	$minimal_portfolio_single_blog_meta_comments = minimal_portfolio_get_option( 'minimal_portfolio_single_blog_meta_comments' );	$minimal_portfolio_single_blog_meta_tags = minimal_portfolio_get_option( 'minimal_portfolio_single_blog_meta_tags' );	$minimal_portfolio_single_blog_meta_share = minimal_portfolio_get_option( 'minimal_portfolio_single_blog_meta_share' );	$post_id = get_the_ID();	?>	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	<div class="post-inner-wrapper">				<?php if ( has_post_thumbnail() ) : ?>			<div class="post-thumbnail">				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">					<?php the_post_thumbnail(); ?>				</a>			</div>		<?php endif; ?>		<ul class="post-meta">				<?php if( $minimal_portfolio_single_blog_meta_date ): ?>				<li class="post-date list-inline-item">					<?php minimal_portfolio_post_date(); ?>			</li>		<?php endif; ?>				<?php if( $minimal_portfolio_single_blog_meta_author ): ?>
			<li class="post-author list-inline-item">				<?php minimal_portfolio_post_author(); ?>			</li>		<?php endif; ?>					<?php if( $minimal_portfolio_single_blog_meta_category ): ?>
			<li class="post-categories list-inline-item">				<?php minimal_portfolio_post_categories(); ?>			</li>		<?php endif; ?>
					<?php if( $minimal_portfolio_single_blog_meta_comments ): ?>
			<li class="post-comment list-inline-item">				<i class="fa fa-comment-o" aria-hidden="true"></i>				<?php minimal_portfolio_post_comment();?>			</li>		<?php endif; ?>
		</ul>				<div class="entry-content">			<?php the_content(); ?>		</div><!-- .entry-content -->		<div class="post-bottom-meta clearfix">			<?php if( $minimal_portfolio_single_blog_meta_tags ): ?>
				<?php if( has_tag() ) : ?>				<div class="post-tag float-left">					 <?php minimal_portfolio_post_tags(); ?>				</div>				<?php endif; ?>			<?php endif; ?>									<?php if( $minimal_portfolio_single_blog_meta_share ): ?>								<div class="post-share <?php if($minimal_portfolio_single_blog_meta_tags && has_tag() != '' ) { echo 'float-right' ; } ?>">					<span><?php echo esc_html__('Share:', 'minimal-portfolio' ); ?></span>					<ul class="links-wrap list-inline">						<li class="facebook list-inline-item">							<a href="//www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink( $post_id ) ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" target="blank">								<i class="fa fa-facebook" aria-hidden="true"></i>							</a>						</li>						<li class="twitter list-inline-item">							<a href="//twitter.com/home?status=Reading:<?php echo urlencode(get_the_title()); ?>-<?php echo  esc_url( home_url( '/' ) )."/?p=". esc_attr( $post_id ); ?>"  title="<?php esc_attr_e( 'Click to send this page to Twitter!', 'minimal-portfolio' ); ?>" target="_blank">								<i class="fa fa-twitter" aria-hidden="true"></i>							</a>						</li>						<li class="linkedin list-inline-item">							<a href="//www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( the_permalink() ); ?>&title=<?php echo urlencode( get_the_title() ); ?>&summary=&source=<?php echo urlencode( get_bloginfo('name') ); ?>" target="blank">								<i class="fa fa-linkedin" aria-hidden="true"></i>							</a>						</li>						<li class="pinterest list-inline-item">							<a href="//pinterest.com/pin/create/button/?url=<?php urlencode( the_permalink() ); ?>&amp;media=<?php echo ( ! empty( $image[0] ) ? $image[0] : '' ); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="blank">								<i class="fa fa-pinterest" aria-hidden="true"></i>							</a>						</li>															</ul>				</div>							<?php endif; ?>		</div>
	</div></article>