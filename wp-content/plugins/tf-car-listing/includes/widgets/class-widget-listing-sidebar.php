<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Widget_Listing_Sidebar' ) ) {
	class Widget_Listing_Sidebar extends WP_Widget {
		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'listing_sidebar_widget',
				__( 'Listing Sidebar Widget', 'tf-car-listing' ),
				array( 'description' => __( 'Listing Sidebar Widget.', 'tf-car-listing' ) )
			);
		}

		/**
		 * Output widget
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			$title                        = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'tf-car-listing' );
			$args['number_of_listing'] = ! empty( $instance['number_of_listing'] ) ? $instance['number_of_listing'] : __( '5', 'tf-car-listing' );

			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo tfcl_get_template_with_arguments( 'widgets/sidebar-listing/sidebar-listing.php', array( 'args' => $args, 'instance' => $instance ) );
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 * @param array $instance
		 */
		public function form( $instance ) {
			$title                = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'tf-car-listing' );
			$number_of_listing = ! empty( $instance['number_of_listing'] ) ? $instance['number_of_listing'] : __( '5', 'tf-car-listing' );
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_name( 'title' )); ?>"><?php _e( 'Title:', 'tf-car-listing' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"
					name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label
					for="<?php echo esc_attr($this->get_field_name( 'number_of_listing' )); ?>"><?php _e( 'Number of listing:', 'tf-car-listing' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_of_listing' )); ?>"
					name="<?php echo esc_attr($this->get_field_name( 'number_of_listing' )); ?>" type="text"
					value="<?php echo esc_attr( $number_of_listing ); ?>" />
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 * @param array $new_instance
		 * @param array $old_instance
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                         = array();
			$instance['title']                = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number_of_listing'] = ( ! empty( $new_instance['number_of_listing'] ) ) ? strip_tags( $new_instance['number_of_listing'] ) : '';
			return $instance;
		}
	}
}