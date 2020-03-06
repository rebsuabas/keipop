<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Musican
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function musican_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( is_page_template( 'full-width.php' ) ) {
		$classes[] = 'no-sidebar';
    }
    


    if( is_front_page() && !is_home() ) {
        $classes[] = 'header-transparent';
    }

    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }
	return $classes;
}
add_filter( 'body_class', 'musican_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function musican_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'musican_pingback_header' );


add_action( 'tgmpa_register', 'musican_register_required_plugins' );
function musican_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => esc_html__('Elementor', 'musican'),
			'slug'      => 'elementor',
			'required'  => false,
		),

        array(
			'name'      => esc_html__('The Events Calendar', 'musican'),
			'slug'      => 'the-events-calendar',
			'required'  => false,
        ),
        
		array(
			'name'      => esc_html__('One Click Demo Import', 'musican'),
			'slug'      => 'one-click-demo-import',
			'required'  => false,
		),


	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'musican',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		
	);

	tgmpa( $plugins, $config );
}


/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function musican_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div>
        <label class="screen-reader-text" for="s">' . __( 'Search:', 'musican' ) . '</label>
        <input type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="'. esc_attr__( 'Search...', 'musican' ) .'" />
        <button type="submit" class="search-submit">
            <i class="fa fa-search"></i>
        </button>
    </div>
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'musican_search_form' );



function musican_footer_info() {
  

    printf( 'Copyright &copy; %1$s <a href="%2$s" title="%3$s">%4$s</a>  - %5$s <a href="https://www.filathemes.com">FilaThemes</a>',
        date_i18n('Y'),
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) ),
        esc_html( get_bloginfo( 'name' ) ),
        __( 'Musican theme by ', 'musican' )
	);
    
}
add_action( 'musican_footer_copyright', 'musican_footer_info' );


// Elementor wigets
class Musican_Elementors {
	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		$this->add_actions();
	}
	private function add_actions() {
		add_action( 'elementor/init', array( $this, 'add_elementor_category' ) );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
	}
	public function add_elementor_category()
	{
		$elementor = \Elementor\Plugin::$instance;
		// Add element category in panel
		$elementor->elements_manager->add_category(
			'musican-elements',
			[
				'title' => __( 'Theme Elements', 'musican' ),
				'icon' => 'font',
			],
			1
		);
	}
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}
	private function includes()
	{
		// Theme Elements
	
        require_once __DIR__ . '/elementors/audio-playlist.php';
        require_once __DIR__ . '/elementors/upcoming-events.php';
        require_once __DIR__ . '/elementors/recent-posts.php';

	}
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Musican\Widgets\Musican_Audio_Playlist() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Musican\Widgets\Musican_Upcoming_Events() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Musican\Widgets\Musican_Recent_Posts() );
	}
}
new Musican_Elementors();
