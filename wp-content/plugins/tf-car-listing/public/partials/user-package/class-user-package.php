<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'User_Package_Public' ) ) {
	class User_Package_Public {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function tfcl_handle_insert_user_package( $user_id, $package_id ) {
			$user_info = get_userdata( $user_id );
			$args      = array(
				'post_type'     => 'user-package',
				'post_per_page' => -1,
				'meta_query'    => array(
					array(
						'key'     => 'package_user_id',
						'value'   => $user_id,
						'compare' => '='
					)
				)
			);

			$user_package = new WP_Query( $args );
			wp_reset_postdata();
			$existed_user_package = $user_package->found_posts;
			if ( $existed_user_package < 1 ) {
				$args            = array(
					'post_title'  => 'Package Of ' . $user_info->display_name . ' (UserID: ' . $user_id . ')',
					'post_type'   => 'user-package',
					'post_status' => 'publish'
				);
				$user_package_id = wp_insert_post( $args );
				update_post_meta( $user_package_id, 'package_user_id', $user_id );
			}
			$package_number_listings   = get_post_meta( $package_id, 'package_number_listing', true );
			$package_unlimited_listing = get_post_meta( $package_id, 'package_unlimited_listing', true );

			if ( $package_unlimited_listing == 1 ) {
				$package_number_listings = -1;
			}

			$time = time();
			$date = date( 'Y-m-d H:i:s', $time );
			update_user_meta( $user_id, 'package_number_listing', $package_number_listings );
			update_user_meta( $user_id, 'package_activate_date', $date );
			update_user_meta( $user_id, 'package_id', $package_id );
		}

		public static function tfcl_get_expired_date( $package_id, $user_id ) {
			$package_unlimited_time = get_post_meta( $package_id, 'package_unlimited_time', true );
			if ( $package_unlimited_time == 1 ) {
				$expired_date = esc_html__( 'Never Expires', 'tf-car-listing' );
			} else {
				$expired_date = User_Package_Public::tfcl_get_expired_time( $package_id, $user_id );
				$expired_date = date_i18n( get_option( 'date_format' ), $expired_date );
			}

			return $expired_date;
		}

		public static function tfcl_get_expired_time( $package_id, $user_id ) {
			$package_time_unit        = get_post_meta( $package_id, 'package_time_unit', true );
			$package_number_time_unit = get_post_meta( $package_id, 'package_number_time_unit', true );
			$package_activate_date    = strtotime( get_user_meta( $user_id, 'package_activate_date', true ) );
			$package_unlimited_time = get_post_meta( $package_id, 'package_unlimited_time', true );
			$seconds                  = 0;

			if ( $package_unlimited_time == 1 ) {
				switch ( $package_time_unit ) {
					case 'day':
						$seconds = 60 * 60 * 24;
						break;
					case 'week':
						$seconds = 60 * 60 * 24 * 7;
						break;
					case 'month':
						$seconds = 60 * 60 * 24 * 30;
						break;
					case 'year':
						$seconds = 60 * 60 * 24 * 365;
						break;
				}
				$expired_time = $package_activate_date + ( $seconds * $package_number_time_unit );
			} else {
				$expired_time = $package_activate_date + (9999 * 9999);
			}

			return $expired_time;
		}

		public static function tfcl_check_user_package_available( $user_id ) {
			$package_available = 1;
			$package_id        = get_user_meta( $user_id, 'package_id', true );

			if ( tfcl_get_option( 'enable_package') == 'n' ) {
				$package_available = 1;
			}
			elseif ( empty( $package_id ) ) {
				$package_available = 0;
			} else {
				$package_unlimited_time = get_post_meta( $package_id, 'package_unlimited_time', true );
				if ( $package_unlimited_time == 0 ) {
					$expired_time = User_Package_Public::tfcl_get_expired_time( $package_id, $user_id );
					$today        = time();
					if ( $today > $expired_time ) {
						$package_available = -1;
					}
				}
				if ( $package_available != -1 ) {
					$package_number_listing = get_user_meta( $user_id, 'package_number_listing', true );
					if ( $package_number_listing != -1 && $package_number_listing < 1 ) {
						$package_available = -2;
					}
				}
			}
			return $package_available;
		}
	}
}