<?php
/**
 * Fired during plugin activation
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('Activation')) {
	require_once TF_PLUGIN_PATH . '/includes/libraries/TGM-Plugin-Activation/install-plugin-activation.php';
	class Activation
	{
		/**
		 * Run when plugin activated
		 */
		public static function activate() {
			self::create_roles_for_admin();
		}

		public static function create_roles_for_admin() {
			global $wp_roles;

			if (!class_exists('WP_Roles')) {
				return;
			}

			if (!isset($wp_roles)) {
				$wp_roles = new WP_Roles();
			}

			$capabilities = get_capabilities();

			foreach ($capabilities as $cap_group) {
				foreach ($cap_group as $cap) {
					$wp_roles->add_cap('administrator', $cap);
				}
			}
		}
	}
}
?>