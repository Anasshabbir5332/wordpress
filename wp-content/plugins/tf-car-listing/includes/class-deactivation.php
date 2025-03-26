<?php
/**
 * Fired during plugin deactivation
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('Deactivation')) {
	class Deactivation
	{
		/**
		 * Run when plugin deactivated
		 */
		public static function deactivate() {
			self::remove_roles_for_admin();
		}

		public static function remove_roles_for_admin() {
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
					$wp_roles->remove_cap('administrator', $cap);
				}
			}
		}
	}
}