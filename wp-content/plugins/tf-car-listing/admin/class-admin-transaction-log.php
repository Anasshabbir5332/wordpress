<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Admin_Transaction_Log' ) ) {
	/**
	 * Class Admin_Transaction_Log
	 */
	class Admin_Transaction_Log {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function tfcl_register_custom_column_titles( $columns ) {
			$columns['cb']                     = "<input type=\"checkbox\" />";
			$columns['title']                  = esc_html__( 'title', 'tf-car-listing' );
			$columns['payment_method']         = esc_html__( 'Payment Method', 'tf-car-listing' );
			$columns['transaction_log_price']  = esc_html__( 'Price', 'tf-car-listing' );
			$columns['buyer_id']               = esc_html__( 'Buyer', 'tf-car-listing' );
			$columns['transaction_log_status'] = esc_html__( 'Status', 'tf-car-listing' );
			$columns['date']                   = esc_html__( 'Date', 'tf-car-listing' );
			$new_columns                       = array();
			$custom_order                      = array(
				'cb',
				'title',
				'payment_method',
				'transaction_log_price',
				'buyer_id',
				'transaction_log_status',
				'date'
			);
			foreach ( $custom_order as $key => $colname ) {
				$new_columns[ $colname ] = $columns[ $colname ];
			}
            return $new_columns;
		}

        function tfcl_set_page_order_in_admin( $wp_query ) {
			global $pagenow;
			if ( is_admin() && $_GET['post_type'] == 'transaction-log' && 'edit.php' == $pagenow && !isset($_GET['orderby'])) {
				$wp_query->set( 'orderby', 'date' );
				$wp_query->set( 'order', 'desc' );
			}
		}

        public function tfcl_display_column_value($column){
            global $post;
            $payment_method = get_post_meta($post->ID, 'transaction_log_payment_method', true);
            $price = get_post_meta($post->ID, 'transaction_log_price', true);
            $buyer_id = get_post_meta($post->ID, 'transaction_log_buyer_id', true);
            $status = get_post_meta($post->ID, 'transaction_log_status', true);
            switch ($column) {
                case 'payment_method':
                    echo esc_html__(tfcl_get_payment_method($payment_method));
                    break;
                case 'transaction_log_price':
                    echo esc_html__(tfcl_get_format_number(floatval($price)));
                    break;
                case 'buyer_id':
                    $user_info = get_userdata( $buyer_id );
					if ( $user_info ) {
						echo esc_html( $user_info->display_name );
					}
                    break;
                case 'transaction_log_status':
                    echo ($status == 1 ? '<span>'.esc_html__('Succeeded', 'tf-car-listing').'</span>' : '<span>'.esc_html__('Failed', 'tf-car-listing').'</span>');
                    break;
                default:
                    # code...
                    break;
            }
        }

        public function tfcl_filter_restrict_manage_transaction_log(){
            global $typenow;
            if($typenow == 'transaction-log'){
                // Invoice status
                $status_values = array(
                    1 => esc_html__('Succeeded', 'tf-car-listing'),
                    0 => esc_html__('Failed', 'tf-car-listing')
                );
                $current_value = isset($_GET['transaction_log_status']) ? wp_unslash($_GET['transaction_log_status']) :'';
                ?>
                <select name="transaction_log_status">
                    <option value=""><?php esc_html_e('All Status', 'tf-car-listing'); ?></option>
                    <?php foreach ($status_values as $key => $value) {
                        ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($key, $current_value); ?>><?php echo esc_html__($value); ?></option>
                        <?php
                    }?>
                </select>
                <?php
                // Payment method
                $payment_method_values = array(
                    'paypal' => esc_html__('Paypal', 'tf-car-listing'),
                    'wire_transfer' => esc_html__('Wire Transfer', 'tf-car-listing'),
                    'free_package' => esc_html__('Free Package', 'tf-car-listing')
                );
                $current_value = isset($_GET['payment_method']) ? wp_unslash($_GET['payment_method']) :'';
                ?>
                <select name="payment_method">
                    <option value=""><?php esc_html_e('All Payment Method', 'tf-car-listing'); ?></option>
                    <?php foreach($payment_method_values as $key => $value): ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($key, $current_value); ?>>
                            <?php echo esc_html__($value); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php
                // Buyer
                $buyer = isset($_GET['buyer']) ? wp_unslash($_GET['buyer']) : '';
                ?>
                <input type="text" placeholder="<?php esc_attr_e('Buyer', 'tf-car-listing'); ?>" name="buyer" value="<?php echo esc_attr($buyer); ?>" />
                <?php
            }
        }

        public function tfcl_handle_filter_restrict_manage_transaction_log($query){
            global $pagenow;
			$query_vars   = &$query->query_vars;
			$filter_array = array();

            if ( $pagenow == 'edit.php' && isset( $query_vars['post_type'] ) && $query_vars['post_type'] == 'transaction-log' ) {
                $buyer = isset( $_GET['buyer'] ) ? wp_unslash( $_GET['buyer'] ) : '';
				if ( $buyer != '' ) {
					$user    = get_user_by( 'login', $buyer );
					$user_id = -1;
					if ( $user ) {
						$user_id = $user->ID;
					}
					$filter_array[] = array(
						'key'     => 'transaction_log_buyer_id',
						'value'   => $user_id,
						'compare' => 'IN',
					);
			
                }

                $current_transaction_log_status = isset( $_GET['transaction_log_status'] ) ? wp_unslash( $_GET['transaction_log_status']) : '';
                if($current_transaction_log_status != ''){
                    $filter_array[] = array(
                        'key' => 'transaction_log_status',
                        'value' =>  $current_transaction_log_status,
                        'compare' => '='
                    );
                }

                $current_transaction_log_payment_method = isset( $_GET['payment_method'] ) ? wp_unslash( $_GET['payment_method'] ) : '';
                if($current_transaction_log_payment_method != ''){
                    $filter_array[] = array(
                        'key' => 'transaction_log_payment_method',
                        'value' => $current_transaction_log_payment_method,
                        'compare' => '='
                    );
                }

                if(!empty($filter_array)){
                    $query_vars['meta_query'] = $filter_array;
                }
            }
        }
	}
}