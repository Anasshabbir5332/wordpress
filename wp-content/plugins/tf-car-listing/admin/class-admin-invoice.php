<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Admin_Invoice' ) ) {
	/**
	 * Class Admin_Invoice
	 */
	class Admin_Invoice {
		public function tfcl_register_column_titles( $columns ) {
			$columns['cb']             = "<input type=\"checkbox\" />";
			$columns["title"]          = esc_html__( 'Title', 'tf-car-listing' );
			$columns['payment_method'] = esc_html__( 'Payment Method', 'tf-car-listing' );
			$columns['payment_status'] = esc_html__( 'Payment Status', 'tf-car-listing' );
			$columns['invoice_price']  = esc_html__( 'Price', 'tf-car-listing' );
			$columns['buyer']          = esc_html__( 'Buyer', 'tf-car-listing' );
			$columns['date']           = esc_html__( 'Date', 'tf-car-listing' );
			$new_columns               = array();
			$custom_order              = array(
				'cb',
				'title',
				'payment_method',
				'payment_status',
				'invoice_price',
				'buyer',
				'date'
			);

			foreach ( $custom_order as $key => $col_name ) {
				$new_columns[ $col_name ] = $columns[ $col_name ];
			}

			return $new_columns;
		}

		function tfcl_set_page_order_in_admin( $wp_query ) {
			global $pagenow;
			if ( is_admin() && $_GET['post_type'] == 'invoice' && 'edit.php' == $pagenow && ! isset( $_GET['orderby'] ) ) {
				$wp_query->set( 'orderby', 'date' );
				$wp_query->set( 'order', 'desc' );
			}
		}

		public function tfcl_display_column_value( $column_name ) {
			global $post;
			$payment_method = get_post_meta( $post->ID, 'invoice_payment_method', true );
			$payment_status = get_post_meta( $post->ID, 'invoice_payment_status', true );
			$invoice_price  = get_post_meta( $post->ID, 'invoice_price', true );
			$buyer_id       = get_post_meta( $post->ID, 'invoice_buyer_id', true );
			switch ( $column_name ) {
				case 'payment_status':
					echo '<span>' . esc_html__( ( $payment_status == 0 ? 'Not Paid' : 'Paid' ), 'tf-car-listing' ) . '</span>';
					break;
				case 'payment_method':
					echo esc_html__( tfcl_get_payment_method( $payment_method ) );
					break;
				case 'invoice_price':
					echo esc_html__( tfcl_get_format_number( floatval( $invoice_price ) ) );
					break;
				case 'buyer':
					$user = get_userdata( $buyer_id );
					if ( $user ) {
						echo esc_html__( $user->user_login );
					}
					break;
				default:
					# code...
					break;
			}
		}

		public function tfcl_filter_restrict_manage_invoices() {
			global $typenow;
			if ( $typenow == 'invoice' ) {
				// Buyer
				$invoice_buyer = isset( $_GET['invoice_buyer'] ) ? wp_unslash( $_GET['invoice_buyer'] ) : '';
				?>
				<input type="text" placeholder="<?php echo esc_attr( 'Buyer', 'tf-car-listing' ); ?>" name="invoice_buyer"
					value="<?php echo esc_attr( $invoice_buyer ); ?>" />
				<?php
				// Payment Status
				$values = array(
					0 => esc_html__( 'Not Paid', 'tf-car-listing' ),
					1 => esc_html__( 'Paid', 'tf-car-listing' ),
				);
				?>
				<select name="payment_status">
					<option value=""><?php echo esc_html__( 'All Payment Status', 'tf-car-listing' ); ?></option>
					<?php
					$curr_value = isset( $_GET['payment_status'] ) ? wp_unslash( $_GET['payment_status'] ) : '';
					foreach ( $values as $value => $label ) {
						printf(
							'<option value="%s" %s>%s</option>',
							$value,
							$value == $curr_value ? 'selected=selected' : '',
							$label
						);
					}
					?>
				</select>
				<?php
				// Payment method
				$values = array(
					'paypal'        => esc_html__( 'Paypal', 'tf-car-listing' ),
					'wire_transfer' => esc_html__( 'Wire Transfer', 'tf-car-listing' ),
					'free_package'  => esc_html__( 'Free Package', 'tf-car-listing' ),
				);
				?>
				<select name="payment_method">
					<option value=""><?php echo esc_html__( 'All Payment Method', 'tf-car-listing' ); ?></option>
					<?php $curr_value = isset( $_GET['payment_method'] ) ? wp_unslash( $_GET['payment_method'] ) : '';
					foreach ( $values as $value => $label ) {
						printf(
							'<option value="%s" %s>%s</option>',
							$value,
							$value == $curr_value ? 'selected=selected' : '',
							$label
						);
					}
					?>
				</select>
				<?php
			}
		}

		public function tfcl_handle_filter_restrict_manage_invoices( $query ) {
			global $pagenow;
			$query_vars   = &$query->query_vars;
			$filter_array = array();

			if ( $pagenow == 'edit.php' && isset( $query_vars['post_type'] ) && $query_vars['post_type'] == 'invoice' ) {
				$invoice_buyer = isset( $_GET['invoice_buyer'] ) ? wp_unslash( $_GET['invoice_buyer'] ) : '';
				if ( $invoice_buyer != '' ) {
					$user    = get_user_by( 'login', $invoice_buyer );
					$user_id = -1;
					if ( $user ) {
						$user_id = $user->ID;
					}

					$filter_array[''] = array(
						'key'     => 'invoice_buyer_id',
						'value'   => $user_id,
						'compare' => 'IN'
					);
				}

				$curr_payment_method = isset( $_GET['payment_method'] ) ? wp_unslash( $_GET['payment_method'] ) : '';
				if ( $curr_payment_method != '' ) {
					$filter_array[] = array(
						'key'     => 'invoice_payment_method',
						'value'   => $curr_payment_method,
						'compare' => '='
					);
				}

				$curr_payment_status = isset( $_GET['payment_status'] ) ? wp_unslash( $_GET['payment_status'] ) : '';
				if ( $curr_payment_status != '' ) {
					$filter_array[] = array(
						'key'     => 'invoice_payment_status',
						'value'   => $curr_payment_status,
						'compare' => '='
					);
				}

				if ( ! empty( $filter_array ) ) {
					$query_vars['meta_query'] = $filter_array;
				}
			}
		}
	}
}