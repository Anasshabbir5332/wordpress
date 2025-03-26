<?php
if (!defined('ABSPATH')) {
	exit;
}
if (!class_exists('Register_Widgets')) {
	class Register_Widgets
	{
		/**
		 * Construct
		 */
		public function __construct() {
			require_once TF_PLUGIN_PATH . 'includes/widgets/class-widget-login-menu.php';
			require_once TF_PLUGIN_PATH . 'includes/widgets/class-widget-contact-dealer.php';
			require_once TF_PLUGIN_PATH . 'includes/widgets/class-widget-contact-dealer2.php';
			require_once TF_PLUGIN_PATH . 'includes/widgets/class-widget-dealer-location.php';
			require_once TF_PLUGIN_PATH . 'includes/widgets/class-widget-listing-sidebar.php';
		}

		/**
		 * register styles widget
		 */
		public function tfcl_enqueue_styles_widget() {
			wp_enqueue_style( 'widget-style',TF_PLUGIN_URL . 'public/assets/css/widgets.css', array(), '', 'all');
		}

		/**
		 * Register Widgets.
		 */
		public function register_widgets() {
			register_widget('Widget_Login_Menu');
			register_widget('Widget_Contact_Dealer');
			register_widget('Widget_Contact_Dealer2');
			register_widget('Widget_Dealer_Location');
			register_widget('Widget_Listing_Sidebar');
		}
	}
}