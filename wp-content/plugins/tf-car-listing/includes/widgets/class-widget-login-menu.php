<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Widget_Login_Menu' ) ) {
	class Widget_Login_Menu extends WP_Widget {
		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct(
				'login_menu_widget',
				__( 'Login Menu Widget', 'tf-car-listing' ),
				array( 'description' => __( 'Show Login and Logout menu.', 'tf-car-listing' ) )
			);
		}
		/**
		 * Output widget
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			echo tfcl_get_template_with_arguments( 'widgets/login-menu/login-menu.php', array( 'args' => $args, 'instance' => $instance ) );
			echo $args['after_widget'];
		}
	}
}