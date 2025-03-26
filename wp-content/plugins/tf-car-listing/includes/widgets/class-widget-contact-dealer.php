<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Widget_Contact_Dealer' ) ) {
	class Widget_Contact_Dealer extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'dealer_contact_widget',
				esc_html__( 'Dealer Contact Single Listing', 'tf-car-listing' ),
				array(
					'description' => esc_html__( 'Widget for display Dealer infomation contact', 'tf-car-listing' )
				)
			);
		}

		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			echo tfcl_get_template_with_arguments( 'widgets/dealer/dealer-contact.php', array( 'args' => $args, 'instance' => $instance ) );
			echo $args['after_widget'];
		}
	}
}
?>