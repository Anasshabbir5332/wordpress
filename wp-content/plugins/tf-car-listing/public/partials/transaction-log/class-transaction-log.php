<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Transaction_Logs_Public' ) ) {
	class Transaction_Logs_Public {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function tfcl_handle_insert_transaction_log( $package_id, $user_id, $payment_method, $payment_id = '', $payer_id = '', $paid = 0, $status = 1, $message = '' ) {
			$package_free = get_post_meta( $package_id, 'package_free', true );
			$total_money  = 0;
			if ( $package_free == '1' ) {
				$total_money = 0;
			} else {
				$total_money = get_post_meta( $package_id, 'package_price', true );
			}

			$time                 = time();
			$transaction_log_date = date( 'Y-m-d H:i:s', $time );
			$transaction_log_args = array(
				'post_title'  => 'Transaction Log',
				'post_status' => 'publish',
				'post_type'   => 'transaction-log'
			);

			$transaction_log_id = wp_insert_post( $transaction_log_args );
			if ( $transaction_log_id ) {
				update_post_meta( $transaction_log_id, 'transaction_log_buyer_id', $user_id );
				update_post_meta( $transaction_log_id, 'transaction_log_package_id', $package_id );
				update_post_meta( $transaction_log_id, 'transaction_log_price', $total_money );
				update_post_meta( $transaction_log_id, 'transaction_log_date', $transaction_log_date );
				update_post_meta( $transaction_log_id, 'transaction_log_payment_method', $payment_method );
				update_post_meta( $transaction_log_id, 'transaction_log_payment_status', $paid );
				update_post_meta( $transaction_log_id, 'transaction_log_payment_id', $payment_id );
				update_post_meta( $transaction_log_id, 'transaction_log_payer_id', $payer_id );
				update_post_meta( $transaction_log_id, 'transaction_log_status', $status );
				update_post_meta( $transaction_log_id, 'transaction_log_message', $message );

				$transaction_update_args = array(
					'ID'         => $transaction_log_id,
					'post_title' => 'Transaction Log ' . $transaction_log_id,
				);
				wp_update_post( $transaction_update_args );
				return $transaction_log_id;
			}
			return null;
		}
	}
}