<?php
namespace Musican\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;

class Musican_Recent_Posts extends Widget_Base {

	public function get_name() {
		return 'musican-recent-posts';
	}

	public function get_title() {
		return __( 'Recent Posts', 'musican' );
	}

	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-post-grid';
	}

	public function get_categories() {
		return [ 'musican-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Recent Posts', 'musican' ),
			]
		);


		$this->add_control(
			'number_posts',
			[
				'label' => __( 'Number of posts to show', 'musican' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '3'
			]
        );
        
        $this->add_control(
			'order',
			[
				'label'       => __( 'Order', 'musican' ),
				'label_block' => true,
				'description' => __( 'Ascending or descending order', 'musican' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'desc',
				'options'     => [
					'desc' => __( 'DESC', 'musican' ),
					'asc'  => __( 'ASC', 'musican' ),
				],
			]
		);
		$this->add_control(
			'orderby',
			[
				'label'       => __( 'Orderby', 'musican' ),
				'label_block' => true,
				'description' => __( 'Sort retrieved posts/pages by parameter', 'musican' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => [
					''      => __( 'None', 'musican' ),
					'ID'    => __( 'ID', 'musican' ),
					'title' => __( 'Title', 'musican' ),
					'name'  => __( 'Name', 'musican' ),
					'rand'  => __( 'Random', 'musican' ),
					'date'  => __( 'Date', 'musican' ),
				],
			]
		);

        $this->add_control(
			'hide_thumbnail',
			[
				'label'       => __( 'Hide Thumbnail', 'musican' ),
				'label_block' => false,
				'description' => __( 'Hide the post featured image.', 'musican' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'musican' ),
				'label_off' => __( 'Hide', 'musican' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
        );
        
		$this->add_control(
			'more_text',
			[
				'label' => __( 'Custom more text', 'musican' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View Our Blog', 'musican' )
			]
        );
        
        $this->add_control(
			'blog_link',
			[
				'label' => __( 'Blog Link', 'musican' ),
				'type' => \Elementor\Controls_Manager::URL,
				'show_external' => false
			]
		);

		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
        $settings = $this->get_settings();

        $hide_thumbnail = $settings['hide_thumbnail'];
        $more_text      = $settings['more_text'];
        $blog_link	    = $settings['blog_link'];
        
        $args    = array(
			'posts_per_page' => $settings['number_posts'],
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'order'          => $settings['order'],
			'orderby'        => $settings['orderby']
        );
        
        $recent_posts = new \WP_Query( $args );

        if ( $recent_posts->have_posts() ) {
            echo '<div id="recent_posts" class="row">';
            while ( $recent_posts->have_posts() ) {
                $recent_posts->the_post();

                set_query_var( 'hide_thumbnail', $hide_thumbnail );
                get_template_part( 'template-parts/content/content', 'recentpost' );
                
            }
            echo '</div>';
        }
        wp_reset_postdata();

        if ( $more_text != '' ) {
           echo '<div class="view-all-blog"><a class="" href="'. $blog_link['url'] .'">'. $more_text .'</a></div>';
        }
	}

	
}
