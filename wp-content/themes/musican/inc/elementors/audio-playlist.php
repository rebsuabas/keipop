<?php
namespace Musican\Widgets;
use  Elementor\Widget_Base;
use  Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Musican_Audio_Playlist extends Widget_Base {
	public function get_name() {
		return 'musican-playlist';
	}
	public function get_title() {
		return __( 'Audio Playlist', 'musican' );
	}
	public function get_icon() {
		return 'fa fa-music';
	}
	public function get_categories() {
		return [ 'musican-elements' ];
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Audio Playlist', 'musican' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'musican' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Playlist', 'musican' )
			]
        );

        $this->add_control(
            'playlists',
            [
                'label'       => __( 'Audio ID', 'musican' ),
                'label_block' => true,
                'description' => __( 'Enter the audio ID, seperate by commas.', 'musican' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => ''
            ]
        );
        
        
		$this->end_controls_section();
	}
	protected function render( $instance = [] ) {
		$settings = $this->get_settings();
        
        $playlists = $settings['playlists'];

        if ( $playlists ) {
            echo do_shortcode('[playlist ids="'.$playlists.'"]');
        }
        
		
	}
}