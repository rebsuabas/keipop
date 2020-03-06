<?php
namespace Musican\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Musican_Upcoming_Events extends Widget_Base {

	public function get_name() {
		return 'musican-upcoming-event';
	}

	public function get_title() {
		return __( 'Upcoming Events', 'musican' );
	}

	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'fa fa-calendar';
	}

	public function get_categories() {
		return [ 'musican-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Upcoming Events', 'musican' ),
			]
		);


		$this->add_control(
			'number_posts',
			[
				'label' => __( 'Number of event to show', 'musican' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '3'
			]
		);

		$this->add_control(
			'more_text',
			[
				'label' => __( 'Custom more text', 'musican' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View All Shows', 'musican' )
			]
		);

		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		global $post;
		$settings = $this->get_settings();
		$args = array(
			'posts_per_page' => $settings['number_posts'],
			'eventDisplay' => 'list'
		);

		if ( is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
			$events = tribe_get_events( $args );
			?>

			<div class="upcoming-events">
                <ul>
                    <?php
                    if ( $events ) :
                        foreach ( $events as $post ) {
                            setup_postdata( $post );
                            $start_date = tribe_get_start_date( $post, false, 'd' );
                            $start_month = tribe_get_start_date( $post, false, 'M' );
                            $start_time = tribe_get_start_date( $post, false, 'g:i a' );
                        ?>
                        <li>
                            <a href="<?php the_permalink() ?>">
                                <div class="event_list_entry event_date">
                                    <div class="event_list_date_container">
                                        <strong><?php echo $start_date ?></strong>
                                        <span><?php echo $start_month ?></span>
                                    </div>
                                </div>
                                <div class="event_list_entry event_title">
                                    <div class="event_img">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                    <div class="event_list_title_loc">
                                        <h3><?php the_title() ?></h3>
                                        <span><?php echo tribe_get_city() . ', ' . tribe_get_state() . ', ' .tribe_get_country(); ?></span>
                                    </div>
                                </div>
                                <div class="event_list_entry event_venue">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <?php echo tribe_get_address(); ?>
                                </div>

                                <?php if ( tribe_get_start_date($post) ) : ?>
                                <div class="event_list_entry event_time">
                                    <span><i class="fa fa-clock-o"></i> <?php echo $start_time; ?></span>
                                </div>
                                <?php endif; ?>

                                <div class="event_list_entry event_buy">
                                    <span><?php echo esc_html__('View Event', 'musican') ?></span>
                                </div>
                            </a>
                            
                        </li>
                        <?php
                        }
                    else : ?>
                        <p><?php printf( esc_html__( 'There are no event at this time.', 'musican' ) ); ?></p>
                    <?php endif; ?>
                </ul>

                <div class="all-events-btn">
                    <a href="#"><?php echo $settings['more_text'] ?></a>
                </div>
			</div>

			<?php
		} else {
			echo esc_html__('You need to active The Events Calendar plugin to use this widget.','musican' );
		}
	}

	protected function _content_template() {}
}

