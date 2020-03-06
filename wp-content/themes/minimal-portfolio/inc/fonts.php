<?php
/*--------------------------------------------------------------------*/
/*     Register Google Fonts
/*--------------------------------------------------------------------*/
function minimal_portfolio_fonts_url() {
	
    $fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Poppins:300,400,500,600,700,800,900','Roboto:300,400,500,700,900');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return esc_url_raw($fonts_url);
}
function minimal_portfolio_scripts_styles() {
    wp_enqueue_style( 'minimal-portfolio-google-fonts', minimal_portfolio_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'minimal_portfolio_scripts_styles' );
?>