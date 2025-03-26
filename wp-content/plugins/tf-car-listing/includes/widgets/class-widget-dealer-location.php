<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Widget_Dealer_Location' ) ) {
	class Widget_Dealer_Location extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'dealer_location_widget',
				__( 'Dealer Location Widget', 'tf-car-listing' ),
				array(
					'description' => __( 'Widget for display location of Dealer in map', 'tf-car-listing' )
				)
			);
		}
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			$current_post_type = get_post_type();
			if ( $current_post_type == 'dealer' ) {
				$dealer_id = get_the_ID();
				if ( $dealer_id ) {
					$dealer_meta     = get_post_custom( $dealer_id );
					$dealer_location = isset( $dealer_meta['dealer_location'] ) ? $dealer_meta['dealer_location'][0] : $dealer_meta['dealer_office_address'][0];
					if ( empty( $dealer_location ) ) {
						$dealer_location = '';
					}
					echo tfcl_get_template_with_arguments( 'widgets/dealer/dealer-location.php', array(
						'args'     => $args,
						'instance' => $instance,
						'location' => $dealer_location
					) );
				} else {
					echo esc_html__( 'Can not found data', 'tf-car-listing' );
				}
			} elseif ( is_author() ) {
				global $current_user;
				wp_get_current_user();
				$author_location = get_the_author_meta( 'user_location', $current_user->ID );
				if ( ! empty( $author_location ) ) {
					echo tfcl_get_template_with_arguments( 'widgets/dealer/dealer-location.php', array(
						'args'     => $args,
						'instance' => $instance,
						'location' => $author_location
					) );
				}
			}
			echo $args['after_widget'];
		}
		public function form( $instance ) {
			$widget_title = ! empty( $instance['widget_title'] ) ? $instance['widget_title'] : esc_html__( 'Dealer Location', 'tf-car-listing' );
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e( 'Title:', 'tf-car-listing' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>"
					name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text"
					value="<?php echo esc_attr( $widget_title ); ?>">
			</p>
			<?php
		}
		public function update( $new_instance, $old_instance ) {
			$instance                 = $old_instance;
			$instance['widget_title'] = sanitize_text_field( $new_instance['widget_title'] );
			return $instance;
		}
	}
}