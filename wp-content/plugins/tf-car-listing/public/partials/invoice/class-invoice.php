<?php
if(!defined('ABSPATH')) {
	exit;
}
if(!class_exists('Invoice_Public')) {
	class Invoice_Public {
		private static $_instance;

		public static function getInstance() {
			if(self::$_instance == null) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function tfcl_register_invoice_script() {
			wp_register_script('invoice-script', TF_PLUGIN_URL.'public/assets/js/invoice.js', array( 'jquery' ), '', true);
		}

		public function tfcl_my_invoice_shortcode() {
			ob_start();
			global $current_user;
			wp_get_current_user();
			$user_id        = $current_user->ID;
			$date_query     = $meta_query = array();
			$invoice_status = $invoice_payment_method = $start_date = $end_date = '';
			$meta_query[] = array(
				'key'     => 'invoice_user_id',
				'compare' => '=',
				'value'   => $user_id
			);

			if(!empty($invoice_status)) {
				$meta_query[] = array(
					'key'     => 'invoice_payment_status',
					'compare' => '=',
					'type'    => 'NUMERIC',
					'value'   => $invoice_status
				);
			} else {
				if(isset($_REQUEST['invoice_status']) && $_REQUEST['invoice_status'] != '') {
					$invoice_status = absint(wp_unslash($_REQUEST['invoice_status']));
					$meta_query[]   = array(
						'key'     => 'invoice_payment_status',
						'compare' => '=',
						'type'    => 'NUMERIC',
						'value'   => $invoice_status
					);
				}
			}

			if(!empty($invoice_payment_method)) {
				$meta_query[] = array(
					'key'     => 'invoice_payment_method',
					'compare' => 'LIKE',
					'type'    => 'CHAR',
					'value'   => $invoice_payment_method
				);
			} else {
				if(isset($_REQUEST['invoice_payment_method']) && $_REQUEST['invoice_payment_method'] != '') {
					$invoice_payment_method = wp_unslash($_REQUEST['invoice_payment_method']);
					$meta_query[]           = array(
						'key'     => 'invoice_payment_method',
						'compare' => 'LIKE',
						'type'    => 'CHAR',
						'value'   => $invoice_payment_method
					);
				}
			}

			if(!empty($start_date) && !empty($end_date)) {
				$date_query[] = array(
					'after'  => $start_date,
					'before' => $end_date
				);
			} else {
				if(isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != '' && isset($_REQUEST['end_date']) && $_REQUEST['end_date'] != '') {
					$start_date         = wp_unslash($_REQUEST['start_date']);
					$end_date           = wp_unslash($_REQUEST['end_date']);
					$increment_end_date = wp_unslash(date('d-m-Y', strtotime('+1 day', strtotime($end_date))));
					$date_query         = array(
						'after'     => $start_date,
						'before'    => $increment_end_date,
						'inclusive' => true
					);
				}
			}

			$post_per_page = 10;
			$args          = array(
				'post_type'           => 'invoice',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'post_per_page'       => $post_per_page,
				'offset'              => (max(1, get_query_var('paged')) - 1) * $post_per_page,
				'orderby'             => 'date',
				'order'               => 'desc',
				'meta_query'          => $meta_query,
				'date_query'          => $date_query
			);
			$invoice_query = new WP_Query($args);
			$invoices      = $invoice_query->posts;
			wp_reset_postdata();
			tfcl_get_template_with_arguments('/invoice/my-invoice.php', array(
				'invoices'               => $invoices,
				'max_num_pages'          => $invoice_query->max_num_pages,
				'invoice_status'         => $invoice_status,
				'invoice_payment_method' => $invoice_payment_method,
				'start_date'             => $start_date,
				'end_date'               => $end_date
			));
			return ob_get_clean();
		}

		public static function tfcl_get_invoice_payment_method($payment_method) {
			$payment_text = '';
			switch( $payment_method ) {
				case 'paypal':
					$payment_text = esc_html__('Paypal', 'tf-car-listing');
					break;
				case 'stripe':
					$payment_text = esc_html__('Stripe', 'tf-car-listing');
					break;
				case 'wire_transfer':
					$payment_text = esc_html__('Wire Transfer', 'tf-car-listing');
					break;
				case 'free_package':
					$payment_text = esc_html__('Free Package', 'tf-car-listing');
					break;
			}
			return $payment_text;
		}

		public function tfcl_handle_insert_invoice($package_id = 0, $user_id = 0, $payment_method = 'wire_transfer', $payment_id = '', $payer_id = '', $paid = 0) {
			global $current_user;
			wp_get_current_user();
			$user_id      = $current_user->ID;
			$package_free = get_post_meta($package_id, 'package_free', true);
			$total_money  = 0;
			if($package_free == '1') {
				$total_money = 0;
			} else {
				$total_money = get_post_meta($package_id, 'package_price', true);
			}

			$time                   = time();
			$invoice_date           = date('Y-m-d H:i:s', $time);
			$invoice                = array();
			$invoice['post_author'] = $user_id;
			$invoice['post_type']   = 'invoice';
			$invoice['post_status'] = 'publish';
			$invoice['post_title']  = 'Invoice';
			$invoice_id             = wp_insert_post($invoice, true);
			if($invoice_id) {
				update_post_meta($invoice_id, 'invoice_user_id', $user_id);
				update_post_meta($invoice_id, 'invoice_payment_method', $payment_method);
				update_post_meta($invoice_id, 'invoice_payment_status', $paid);
				update_post_meta($invoice_id, 'invoice_package_id', $package_id);
				update_post_meta($invoice_id, 'invoice_price', $total_money);
				update_post_meta($invoice_id, 'invoice_purchase_date', $invoice_date);
				update_post_meta($invoice_id, 'invoice_buyer_id', $user_id);
				update_post_meta($invoice_id, 'transaction_payment_id', $payment_id);
				update_post_meta($invoice_id, 'transaction_payer_id', $payer_id);

				$update_invoice = array(
					'ID'         => $invoice_id,
					'post_title' => 'Invoice '.$invoice_id
				);
				wp_update_post($update_invoice);
				$transaction_log = new Transaction_Logs_Public();
				$transaction_log->tfcl_handle_insert_transaction_log($package_id, $user_id, $payment_method, $payment_id, $payer_id, $paid);
				return $invoice_id;
			}
			return null;
		}

		public function tfcl_handle_print_invoice() {
			if(!isset($_POST['invoice_id']) || !is_numeric($_POST['invoice_id'])) {
				return;
			}
			$invoice_id = absint(wp_unslash($_POST['invoice_id']));
			tfcl_get_template_with_arguments('invoice/invoice-print.php', array( 'invoice_id' => $invoice_id ));
			wp_die();
		}
	}
}