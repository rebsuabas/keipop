<?php
/**
 * Sound Lite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Musican
 */


if ( ! function_exists( 'musican_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function musican_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Sound Lite, use a find and replace
		 * to change 'musican' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'musican', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support( 'post-thumbnails' );
        
        // Used in featured content
        add_image_size( 'musican-featured', 640, 480, true ); // Ratio 4:3
        
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
            'primary-menu' => esc_html__( 'Primary', 'musican' ),
            'social-menu' => esc_html__( 'Social Links', 'musican' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 36,
			'width'       => 180,
			'flex-width'  => true,
			'flex-height' => true,
        ) );
        
         // Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );
		// Add support for responsive embeds.
        add_theme_support( 'responsive-embeds' );
        
		add_theme_support('woocommerce' );
	}
endif;
add_action( 'after_setup_theme', 'musican_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function musican_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'musican_content_width', 640 );
}
add_action( 'after_setup_theme', 'musican_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function musican_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'musican' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'musican' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
    ) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'musican' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here.', 'musican' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>'
	) );
}
add_action( 'widgets_init', 'musican_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function musican_scripts() {

    wp_enqueue_style( 'musican-fonts', musican_fonts_url(), array(), null );

    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.3.1', '' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.7.0', '' );

	wp_enqueue_style( 'musican-style', get_stylesheet_uri() );

	wp_enqueue_script( 'musican-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'wp-playlist' ), '20151215', true );

	wp_enqueue_script( 'musican-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( function_exists( 'musican_custom_style' ) ) {
		wp_add_inline_style( 'musican-style', musican_custom_style() );
    }
    
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'musican_scripts' );

if ( ! function_exists( 'musican_fonts_url' ) ) :
	/**
	 * Register Google fonts.
	 * Create your own wp_blog_fonts_url() function to override in a child theme.
	 */
	function musican_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';
		/* translators: If there are characters in your language that are not supported by Playfair Display, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'PT Sans font: on or off', 'musican' ) ) {
			$fonts[] = 'PT Sans:400,400i,700,700i';
		}
		
		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}
		return $fonts_url;
	}
endif;

/**
 * TGM
 */
require_once get_template_directory() . '/inc/tgm.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



