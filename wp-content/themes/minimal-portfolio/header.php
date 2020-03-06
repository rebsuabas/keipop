<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package minimal-portfolio
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
<?php  $minimal_portfolio_sticky_header_status = minimal_portfolio_get_option( 'minimal_portfolio_sticky_header_status' ); 
	   $minimal_portfolio_breadcrumb_status    = minimal_portfolio_get_option( 'minimal_portfolio_breadcrumb_status' );
?> 
	<header id="masthead" class="site-header">
		<div class="header-menu <?php if( $minimal_portfolio_sticky_header_status ): ?> sticky-activated <?php endif;?>">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<ul class="navbar-items nav pull-right navigation-section">
								<div class="mobile-menu-wrapper">
									<span class="mobile-menu-icon"><i class="icon-menu"></i></span>
								</div>
								<li id="site-navigation" class="main-navigation nav-item" role="navigation">
									<?php wp_nav_menu( array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
										'menu_class' 	 => 'main-menu nav',
									) ); 
									?>
								</li>
							</ul><!-- .navigation-section -->
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
	<?php $disable_page_title = get_post_meta( get_the_ID(), 'minimal_portfolio_page_title', true ); 		$minimal_portfolio_page_title_bgimage = minimal_portfolio_get_option( 'minimal_portfolio_page_title_bgimage' );			
		if( $disable_page_title !== 'on' ): ?>
			<?php if( !is_front_page()):  ?>
				<section class="page-header jumbotron <?php if ( $minimal_portfolio_page_title_bgimage ) : ?>bg-image<?php endif; ?>"  <?php if ( $minimal_portfolio_page_title_bgimage ) : ?> style="background-image:url('<?php echo esc_url( $minimal_portfolio_page_title_bgimage ); ?>');" <?php endif; ?>>
				<?php if ( $minimal_portfolio_page_title_bgimage ) : ?><span class="bg-overlay"></span><?php endif; ?>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="title-wrap">
									<?php if( is_page() || is_single() ){ ?>
											<h2 class="page-title"><?php echo esc_html( get_the_title() ); ?></h2>
				
										<?php } elseif( is_search() ){ ?>
										<?php /* translators: %s: search term */
											$page_title = sprintf( esc_html__( 'Search Results for: %s', 'minimal-portfolio' ),  get_search_query() ); 
										?>
										<h2 class="page-title"><?php echo esc_html( $page_title ); ?></h2>
					
										<?php }elseif( is_404() ){ ?>
					
										<h2 class="page-title"><?php echo esc_html( 'Page Not Found: 404', 'minimal-portfolio' ); ?></h2>
					
										<?php }elseif( is_home() ){ ?>
					
										<h2 class="page-title"><?php single_post_title(); ?></h2>
					
										<?php } else{
					
											the_archive_title( '<h2 class="page-title">', '</h2>' );
										}
										
										if( $minimal_portfolio_breadcrumb_status ):
											minimal_portfolio_breadcrumbs();
										endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php endif;
		endif; ?>
