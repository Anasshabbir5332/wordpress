<?php
if(!defined('ABSPATH')) {
	exit;
}
if(!class_exists('Package_Public')) {
	class Package_Public {
		private static $_instance;

		public static function getInstance() {
			if(self::$_instance == null) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function tfcl_package_list_shortcode() {
			ob_start();
			tfcl_get_template_with_arguments('package/package.php', array());
			return ob_get_clean();
		}

		public function tfcl_my_package_shortcode() {
			ob_start();
			global $current_user;
			wp_get_current_user();
			$current_user_id = $current_user->ID;
			$package_id      = get_the_author_meta('package_id', $current_user_id);
			tfcl_get_template_with_arguments('package/my-package.php', array( 'package_id' => $package_id, 'current_user_id' => $current_user_id ));
			return ob_get_clean();
		}
	}
}