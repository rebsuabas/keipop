<?php
/**
 * Sound Lite Theme Customizer
 *
 * @package Musican
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function musican_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'musican_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'musican_customize_partial_blogdescription',
        ) );
        $wp_customize->selective_refresh->add_partial( 'hero_heading', array(
			'selector'        => '.hero-heading',
			'render_callback' => 'musican_customize_partial_hero_heading'
        ) );
        $wp_customize->selective_refresh->add_partial( 'hero_btn_text', array(
			'selector'        => '.site-hero a',
			'render_callback' => 'musican_customize_partial_hero_btn_text'
		) );
    }

    /* Primary color */
	$wp_customize->add_setting( 'primary_color' , array(
		'sanitize_callback'	=> 'sanitize_hex_color',
		'default'     => '#fb3b64',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
		'label'        => esc_html__( 'Primary Color', 'musican' ),
		'section'    => 'colors',
		'settings'   => 'primary_color',
	) ) );
    

    // Hero Heading
    $wp_customize->add_setting( 'hero_heading', array(
		'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Music is Life', 'musican' ),
        'transport'         => 'postMessage'
	) );
	$wp_customize->add_control( 'hero_heading',
		array(
			'label'       => esc_html__('Hero Heading', 'musican'),
			'section'     => 'header_image'
		)
    );
    $wp_customize->add_setting( 'hero_btn_text', array(
		'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Get Started', 'musican' ),
        'transport'         => 'postMessage'
	) );
	$wp_customize->add_control( 'hero_btn_text',
		array(
			'label'       => esc_html__('Button Text', 'musican'),
			'section'     => 'header_image'
		)
    );
    $wp_customize->add_setting( 'hero_btn_link', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '#'
	) );
	$wp_customize->add_control( 'hero_btn_link',
		array(
			'label'       => esc_html__('Button URL', 'musican'),
			'section'     => 'header_image'
		)
	);
   

}
add_action( 'customize_register', 'musican_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function musican_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function musican_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function musican_customize_partial_hero_heading() {
    return esc_html( get_theme_mod( 'hero_heading' ) );
}

function musican_customize_partial_hero_btn_text() {
    return esc_html( get_theme_mod( 'hero_btn_text' ) );
}

function musican_checkbox_sanitize( $input ){
    //returns true if checkbox is checked
    return ( ( $input == 1 ) ? 1 : '' );
}
function musican_sanitize_number_absint( $number, $setting ) {
    // Ensure $number is an absolute integer (whole number, zero or greater).
    $number = absint( $number );
    // If the input is an absolute integer, return it; otherwise, return the default
    return ( $number ? $number : $setting->default );
}
function musican_sanitize_select( $input, $setting ) {
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function musican_customize_preview_js() {
	wp_enqueue_script( 'musican-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview',  'jquery' ), '20151215', true );
}
add_action( 'customize_preview_init', 'musican_customize_preview_js' );
