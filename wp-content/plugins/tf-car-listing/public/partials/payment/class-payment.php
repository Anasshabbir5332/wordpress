<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Payment_Public' ) ) {
	class Payment_Public {
		private static $_instance;

		public $tfcl_package;
		public $tfcl_invoice;
		public $tfcl_user_package;
		public $tfcl_transaction_log;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->tfcl_package         = new Package_Public();
			$this->tfcl_invoice         = new Invoice_Public();
			$this->tfcl_user_package    = new User_Package_Public();
			$this->tfcl_transaction_log = new Transaction_Logs_Public();
		}

		public function tfcl_register_payment_scripts() {
			$payment_variables = array(
				'ajax_url'               => TF_AJAX_URL,
				'stripe_version'         => tfcl_get_option( 'stripe_version', 'legacy' ),
				'stripe_publishable_key' => tfcl_get_option( 'stripe_publishable_key' )
			);
			wp_register_script( 'payment-script', TF_PLUGIN_URL . 'public/assets/js/payment.js', array( 'jquery' ), false, true );
			wp_localize_script( 'payment-script', 'payment_variables', $payment_variables );
		}

		public function tfcl_payment_invoice_shortcode() {
			ob_start();
			tfcl_get_template_with_arguments( 'payment/payment-invoice.php', array() );
			return ob_get_clean();
		}

		public function tfcl_payment_completed_shortcode() {
			ob_start();
			tfcl_get_template_with_arguments( 'payment/payment-completed.php', array() );
			return ob_get_clean();
		}

		private function tfcl_get_paypal_access_token() {
			$paypal_api               = tfcl_get_option( 'paypal_api' );
			$host_url                 = $paypal_api == 'live' ? 'https://api.paypal.com' : 'https://api.sandbox.paypal.com';
			$url_request              = $host_url . '/v1/oauth2/token';
			$paypal_client_id         = tfcl_get_option( 'paypal_client_id' );
			$paypal_client_secret_key = tfcl_get_option( 'paypal_client_secret_key' );
			$authentication           = base64_encode( $paypal_client_id . ':' . $paypal_client_secret_key );
			$response                 = wp_remote_post( $url_request, array(
				'sslverify' => false,
				'headers'   => array(
					'Authorization' => "Basic {$authentication}"
				),
				'body'      => 'grant_type=client_credentials'
			) );
			$status                   = wp_remote_retrieve_response_code( $response );
			if ( $status == 200 || $status == 201 ) {
				$content = json_decode( wp_remote_retrieve_body( $response ) );
				return $content->access_token;
			}
			return null;
		}

		private function tfcl_execute_paypal_request( $url_request, $request_json, $access_token ) {
			$response = wp_remote_post( $url_request, array(
				'sslverify' => false,
				'headers'   => array(
					'Authorization' => "Bearer {$access_token}",
					'Accept'        => 'application/json',
					'Content-Type'  => 'application/json'
				),
				'body'      => $request_json
			) );
			$status   = wp_remote_retrieve_response_code( $response );
			if ( $status === 200 || $status === 201 ) {
				$content = json_decode( wp_remote_retrieve_body( $response ), true );
				return $content;
			}
			return wp_remote_retrieve_response_message( $response );
		}

		public function tfcl_handle_payment_invoice_by_paypal() {
			check_ajax_referer( 'tfcl_payment_ajax_nonce', 'tfcl_security_payment' );
			if ( ! is_user_logged_in() ) {
				exit();
			}
			global $current_user;
			wp_get_current_user();
			$user_id                      = $current_user->ID;
			$home_url                     = esc_url( home_url() );
			$package_id                   = isset( $_POST['package_id'] ) ? absint( wp_unslash( $_POST['package_id'] ) ) : 0;
			$user_package_id              = get_the_author_meta( 'package_id', $user_id );
			$user_package_price           = floatval( get_post_meta( $user_package_id, 'package_price', true ) );
			$package_price                = floatval( get_post_meta( $package_id, 'package_price', true ) );
			$package_name                 = get_the_title( $package_id );
			$check_user_package_available = $this->tfcl_user_package->tfcl_check_user_package_available( $user_id );

			if ( empty( $package_id ) && empty( $package_price ) ) {
				exit();
			}

			if ( ! empty( $user_package_id ) && ( $check_user_package_available == 1 ) && ( $package_price < $user_package_price ) ) {
				exit();
			}

			$currency_code               = tfcl_get_option( 'currency_code', 'USD' );
			$payment_description         = esc_html( 'Membership Payment ', 'tf-car-listing' ) . $package_name . esc_html( ' on ', 'tf-car-listing' ) . $home_url;
			$paypal_api                  = tfcl_get_option( 'paypal_api' );
			$host_url                    = $paypal_api == 'live' ? 'https://api.paypal.com' : 'https://api.sandbox.paypal.com';
			$paypal_url                  = $host_url . '/v1/payments/payment';
			$access_token                = $this->tfcl_get_paypal_access_token();
			$payment_completed_page_link = tfcl_get_permalink( 'payment_completed_page' );
			$return_url                  = add_query_arg( array( 'payment_method' => 1 ), $payment_completed_page_link );
			$cancel_url                  = tfcl_get_permalink( 'dashboard_page' );
			if ( $access_token == null ) {
				echo sanitize_url( remove_query_arg( array( 'payment_method' ), $return_url ) );
				exit();
			}

			$payment_request = array(
				'intent'        => 'sale',
				'payer'         => array( "payment_method" => "paypal" ),
				"redirect_urls" => array(
					"return_url" => $return_url,
					"cancel_url" => $cancel_url
				),
			);

			$payment_request['transactions'][0] = array(
				'amount'          => array(
					'total'    => $package_price,
					'currency' => $currency_code,
					'details'  => array(
						'subtotal' => $package_price,
						'tax'      => '0.00',
						'shipping' => '0.00'
					)
				),
				'description'     => $payment_description,
				'payment_options' => array(
					'allowed_payment_method' => 'INSTANT_FUNDING_SOURCE'
				),
				'item_list'       => array(
					'items' => array(
						array(
							'quantity' => '1',
							'name'     => esc_html__( 'Payment Package', 'tf-car-listing' ),
							'price'    => $package_price,
							'currency' => $currency_code,
							'sku'      => $package_name . ' ' . esc_html__( 'Payment Package', 'tf-car-listing' )
						)
					)
				)
			);

			$payment_request_json = json_encode( $payment_request );
			$json_response        = $this->tfcl_execute_paypal_request( $paypal_url, $payment_request_json, $access_token );
			$payment_approval_url = $payment_execute_url = "";
			foreach ( $json_response["links"] as $key => $link ) {
				if ( $link['rel'] == 'execute' ) {
					$payment_execute_url = $link['href'];
				} else if ( $link['rel'] == 'approval_url' ) {
					$payment_approval_url = $link['href'];
				}
			}

			$transfer_data['payment_execute_url'] = $payment_execute_url;
			$transfer_data['access_token']        = $access_token;
			$transfer_data['package_id']          = $package_id;
			update_user_meta( $user_id, 'paypal_transfer', $transfer_data );
			echo sanitize_url( $payment_approval_url );
			wp_die();
		}

		public function tfcl_payment_completed_by_paypal() {
			global $current_user;
			wp_get_current_user();
			$user_id        = $current_user->ID;
			$user_email     = $current_user->user_email;
			$admin_email    = get_bloginfo( 'admin-email' );
			$payment_method = 'paypal';
			try {
				if ( isset( $_GET['token'] ) && isset( $_GET['PayerID'] ) ) {
					$payer_id      = wp_unslash( $_GET['PayerID'] );
					$payment_id    = wp_unslash( $_GET['paymentId'] );
					$transfer_data = get_user_meta( $user_id, 'paypal_transfer', true );
					if ( empty( $transfer_data ) ) {
						return;
					}
					$payment_execute_url = $transfer_data['payment_execute_url'];
					$access_token        = $transfer_data['access_token'];
					$package_id          = $transfer_data['package_id'];
					$payment_execute     = array(
						'payer_id' => $payer_id
					);
					$json                = json_encode( $payment_execute );
					$json_response       = $this->tfcl_execute_paypal_request( $payment_execute_url, $json, $access_token );
					delete_user_meta( $user_id, 'paypal_transfer' );
					if ( $json_response['state'] == 'approved' ) {
						$package_price = floatval( get_post_meta( $package_id, 'package_price', true ) );
						$this->tfcl_user_package->tfcl_handle_insert_user_package( $user_id, $package_id );
						$invoice_id       = $this->tfcl_invoice->tfcl_handle_insert_invoice( $package_id, $user_id, $payment_method, $payment_id, $payer_id, 1 );
						$args_admin_email = array(
							'invoice_no'  => $invoice_id,
							'total_price' => tfcl_get_format_number( $package_price )
						);
						tfcl_send_email( $admin_email, 'admin_email_paid_package', $args_admin_email );
						tfcl_send_email( $user_email, 'user_email_paid_package', array() );
					} else {
						$message = esc_html( 'Transaction Failed!', 'tf-car-listing' );
						$this->tfcl_transaction_log->tfcl_handle_insert_transaction_log( $package_id, $user_id, $payment_method, $payment_id, $payer_id, 0, 0, $message );
						$error = '<div class="alert alert-danger" role="alert">' . wp_kses_post( __( '<strong>Error!</strong> Transaction failed', 'tf-car-listing' ) ) . '</div>';
						echo wp_kses_post( $error );
					}
					exit;
				}
			} catch (\Exception $e) {
				//throw $th;
				$error = '<div class="alert alert-danger" role="alert"><strong>' . esc_html__( 'Error!', 'tf-car-listing' ) . '</strong>' . wp_kses_post( $e->getMessage() ) . '</div>';
				echo wp_kses_post( $error );
			}
		}

		public function tfcl_handle_payment_invoice_by_wire_transfer() {
			check_ajax_referer( 'tfcl_payment_ajax_nonce', 'tfcl_security_payment' );
			if ( ! is_user_logged_in() ) {
				exit();
			}
			global $current_user;
			$current_user            = wp_get_current_user();
			$user_id                 = $current_user->ID;
			$user_email              = $current_user->user_email;
			$admin_email             = get_bloginfo( 'admin_email' );
			$package_id              = isset( $_POST['package_id'] ) ? absint( wp_unslash( $_POST['package_id'] ) ) : 0;
			$package_price           = floatval( get_post_meta( $package_id, 'package_price', true ) );
			$user_package_id         = absint( get_the_author_meta( 'package_id', $user_id ) );
			$user_package_price      = floatval( get_post_meta( $user_package_id, 'package_price', true ) );
			$check_package_available = $this->tfcl_user_package->tfcl_check_user_package_available( $user_id );

			if ( empty( $package_id ) ) {
				exit();
			}

			if ( ! empty( $user_package_id ) && ( $check_package_available == 1 ) && ( $package_price < $user_package_price ) ) {
				exit();
			}

			$payment_method = 'wire_transfer';
			$invoice_id     = $this->tfcl_invoice->tfcl_handle_insert_invoice( $package_id, $user_id, $payment_method, '', '', 0 );
			$args_email     = array(
				'invoice_no'  => $invoice_id,
				'total_price' => tfcl_get_format_number( $package_price ),
			);
			tfcl_send_email( $admin_email, 'admin_email_wire_transfer', $args_email );
			tfcl_send_email( $user_email, 'user_email_wire_transfer', $args_email );
			$payment_completed_page_link = tfcl_get_permalink( 'payment_completed_page' );
			$return_url                  = add_query_arg( array( 'payment_method' => 2 ), $payment_completed_page_link );
			echo sanitize_url( $return_url );
			wp_die();
		}

		public function tfcl_handle_free_package() {
			check_ajax_referer( 'tfcl_payment_ajax_nonce', 'tfcl_security_payment' );
			if ( ! is_user_logged_in() ) {
				exit();
			}

			global $current_user;
			wp_get_current_user();
			$user_id                     = $current_user->ID;
			$user_free_package           = get_the_author_meta( 'free_package', $user_id );
			$payment_completed_page_link = tfcl_get_permalink( 'payment_completed_page' );
			if ( empty( $user_free_package ) ) {
				$package_id = isset( $_POST['package_id'] ) ? absint( wp_unslash( $_POST['package_id'] ) ) : 0;
				$this->tfcl_user_package->tfcl_handle_insert_user_package( $user_id, $package_id );
				$payment_method = 'free_package';
				$this->tfcl_invoice->tfcl_handle_insert_invoice( $package_id, $user_id, $payment_method, '', '', 1 );
				update_user_meta( $user_id, 'free_package', 'yes' );
				$return_url = add_query_arg( array( 'payment_method' => 3 ), $payment_completed_page_link );
				echo sanitize_url( $return_url );
				wp_die();
			} else {
				echo sanitize_url( $payment_completed_page_link );
				wp_die();
			}
		}

		public static function tfcl_handle_payment_invoice_by_stripe( $package_id = null ) {
			if ( tfcl_get_option( 'stripe_version', 'legacy' ) == 'new' ) {
				check_ajax_referer( 'tfcl_payment_ajax_nonce', 'tfcl_security_payment' );
			}
			require_once( TF_PLUGIN_PATH . '/includes/libraries/stripe-php/init.php' );
			$stripe_publishable_key = tfcl_get_option( 'stripe_publishable_key' );
			$stripe_secret_key      = tfcl_get_option( 'stripe_secret_key' );
			\Stripe\Stripe::setApiKey( $stripe_secret_key );
			global $current_user;
			$user_id    = $current_user->ID;
			$user_email = get_the_author_meta( 'user_email', $user_id );
			if ( $package_id == null ) {
				$package_id = isset( $_POST['packageID'] ) ? absint( wp_unslash( $_POST['packageID'] ) ) : 0;
			}
			$package_name  = get_the_title( $package_id );
			$package_price = floatval( get_post_meta( $package_id, 'package_price', true ) );
			$currency_code = tfcl_get_option( 'currency_code', 'USD' );
			if ( ! tfcl_is_zero_decimal_currency( $currency_code ) ) {
				$package_price = $package_price * 100;
			}

			$payment_completed_page_link = tfcl_get_permalink( 'payment_completed_page' );
			$stripe_success_link         = add_query_arg( array( 'payment_method' => 4 ), $payment_completed_page_link );
			$stripe_cancel_url           = tfcl_get_permalink( 'dashboard_page' );
			$stripe_version              = tfcl_get_option( 'stripe_version', 'legacy' );
			if ( $stripe_version == 'new' ) {
				try {
					$session = \Stripe\Checkout\Session::create( [ 
						'payment_method_types' => [ 'card' ],
						'line_items'           => [ [ 
							'price_data' => [ 
								'currency'     => $currency_code,
								'unit_amount'  => $package_price,
								'product_data' => [ 
									'name' => $package_name,
								],
							],
							'quantity'   => 1,
						] ],
						'mode'                 => 'payment',
						'success_url'          => add_query_arg( array( 'session_id' => '{CHECKOUT_SESSION_ID}', 'package_id' => $package_id ), $stripe_success_link ),
						'cancel_url'           => $stripe_cancel_url,
					] );

					$response = array(
						'status'  => 1,
						'message' => 'Checkout Session created successfully!',
						'session' => $session
					);
				} catch (\Throwable $th) {
					//throw $th;
					$response = array(
						'status'  => 0,
						'message' => 'Checkout Session created failed!',
						'session' => $session
					);
				}

				echo json_encode( $response );
				wp_die();
			} else {
				wp_enqueue_script( 'stripe-checkout' );
				wp_localize_script( 'stripe-checkout', 'stripe_variables', array(
					'stripe_payment' => array(
						'key'  => $stripe_publishable_key,
						'data' => array(
							'amount'         => $package_price,
							'email'          => $user_email,
							'currency'       => $currency_code,
							'zipCode'        => true,
							'billingAddress' => true,
							'name'           => esc_html__( 'Payment Package', 'tf-car-listing' ),
							'description'    => wp_kses_post( sprintf( __( '%s Payment', 'tf-car-listing' ), $package_name ) )
						)
					)
				) );
				?>
				<form class="stripe-payment-form" id="stripe_payment" action=<?php echo esc_url( $stripe_success_link ); ?>
					method="post">
					<button class="stripe-checkout-button" style="display: none !important">
					</button>
					<input type="hidden" id="package_id" name="package_id" value="<?php echo esc_attr( $package_id ); ?>" />
					<input type="hidden" id="payment_amount" name="payment_amount" value="<?php echo esc_attr( $package_price ); ?>" />
				</form>
				<?php
			}
		}

		public function tfcl_payment_completed_by_stripe() {
			require_once( TF_PLUGIN_PATH . '/includes/libraries/stripe-php/init.php' );
			$stripe_publishable_key = tfcl_get_option( 'stripe_publishable_key' );
			$stripe_secret_key      = tfcl_get_option( 'stripe_secret_key' );
			\Stripe\Stripe::setApiKey( $stripe_secret_key );
			global $current_user;
			wp_get_current_user();
			$user_id        = $current_user->ID;
			$user_email     = $current_user->user_email;
			$admin_email    = get_bloginfo( 'admin-email' );
			$payment_method = 'stripe';
			$currency_code  = tfcl_get_option( 'currency_code', 'USD' );
			$payment_id     = $payer_id = '';
			$stripe_version = tfcl_get_option( 'stripe_version', 'legacy' );
			if ( $stripe_version == 'new' ) {
				try {
					if ( ! empty( $_GET['session_id'] ) ) {
						$session_id = $_GET['session_id'];

						// Fetch the Checkout Session to display the JSON result on the success page
						try {
							$checkout_session = \Stripe\Checkout\Session::retrieve( $session_id );
						} catch (Exception $e) {
							$api_error = $e->getMessage();
						}

						if ( empty( $api_error ) && $checkout_session ) {
							// Retrieve the details of a PaymentIntent
							try {
								$intent = \Stripe\PaymentIntent::retrieve( $checkout_session->payment_intent );
							} catch (\Stripe\Exception\ApiErrorException $e) {
								$api_error = $e->getMessage();
							}

							if ( $checkout_session->customer == NULL ) {
								// Add customer to stripe 
								try {
									$name  = isset( $checkout_session->customer_details->name ) ? $checkout_session->customer_details->name : '';
									$email = isset( $checkout_session->customer_details->email ) ? $checkout_session->customer_details->email : '';
									if ( ! empty( $name ) && ! empty( $email ) ) {
										$customer = \Stripe\Customer::create( array(
											'name'  => $name,
											'email' => $email,
										) );
									}
								} catch (Exception $e) {
									$api_error = $e->getMessage();
								}

								// Retrieves the details of customer
								try {
									$customer = \Stripe\Customer::retrieve( $customer->id );
								} catch (\Stripe\Exception\ApiErrorException $e) {
									$api_error = $e->getMessage();
								}

								if ( empty( $api_error ) && $customer ) {
									try {
										// Update PaymentIntent with the customer ID 
										\Stripe\PaymentIntent::update( $intent->id, [ 
											'customer' => $customer->id
										] );
									} catch (Exception $e) {
										// log or do what you want 
									}
								}
							} else {
								// Retrieves the details of customer
								try {
									$customer = \Stripe\Customer::retrieve( $checkout_session->customer );
								} catch (\Stripe\Exception\ApiErrorException $e) {
									$api_error = $e->getMessage();
								}
							}

							if ( empty( $api_error ) && $intent ) {
								$payer_id   = $customer->id;
								$payment_id = $intent->id;
								$package_id = absint( wp_unslash( $_GET['package_id'] ) );
								if ( $intent->status == 'succeeded' ) {
									if ( isset( $_GET['package_id'] ) && ! is_numeric( wp_unslash( $_GET['package_id'] ) ) ) {
										die();
									}
									$package_price = floatval( get_post_meta( $package_id, 'package_price', true ) );
									$this->tfcl_user_package->tfcl_handle_insert_user_package( $user_id, $package_id );
									$invoice_id       = $this->tfcl_invoice->tfcl_handle_insert_invoice( $package_id, $user_id, $payment_method, $payment_id, $payer_id, 1 );
									$args_admin_email = array(
										'invoice_no'  => $invoice_id,
										'total_price' => tfcl_get_format_number( $package_price )
									);
									tfcl_send_email( $admin_email, 'admin_email_paid_package', $args_admin_email );
									tfcl_send_email( $user_email, 'user_email_paid_package', array() );

								} else {
									$message = esc_html( 'Your Payment has been Failed!', 'tf-car-listing' );
									$this->tfcl_transaction_log->tfcl_handle_insert_transaction_log( $package_id, $user_id, $payment_method, $payment_id, $payer_id, 0, 0, $message );
									$error = '<div class="alert alert-danger" role="alert">' . wp_kses_post( __( '<strong>Error1!</strong> Transaction failed', 'tf-car-listing' ) ) . '</div>';
									echo wp_kses_post( $error );
								}

							}

						}
					}
				} catch (\Exception $e) {
					$error = '<div class="alert alert-danger" role="alert"><strong>' . esc_html__( 'Error!', 'tf-car-listing' ) . '</strong>' . wp_kses_post( $e->getMessage() ) . '</div>';
					echo wp_kses_post( $error );
				}

			} else {
				$stripe_email = '';
				if ( isset( $_POST['stripeEmail'] ) && is_email( $_POST['stripeEmail'] ) ) {
					$stripe_email = sanitize_email( wp_unslash( $_POST['stripeEmail'] ) );
				}

				if (isset($_POST['package_id']) && !is_numeric((wp_unslash($_POST['package_id'])) )) {
					die();
				}
	
				if (isset($_POST['payment_amount']) && !is_numeric((wp_unslash($_POST['payment_amount'])) )) {
					die();
				}
				try {
					$stripe_token   = isset( $_POST['stripeToken'] ) ? wp_unslash( $_POST['stripeToken'] ) : '';
					$payment_amount = isset( $_POST['payment_amount'] ) ? floatval( wp_unslash( $_POST['payment_amount'] ) ) : 0;
					$package_id     = isset( $_POST['package_id'] ) ? absint( wp_unslash( $_POST['package_id'] ) ) : 0;

					$customer = \Stripe\Customer::create( array(
						'email'  => $stripe_email,
						'source' => $stripe_token
					) );

					$charge = \Stripe\Charge::create( array(
						'amount'   => $payment_amount,
						'customer' => $customer->id,
						'currency' => $currency_code
					) );
					if ( isset( $charge->id ) && ( ! empty( $charge->id ) ) ) {
						$payment_id = $charge->id;
					}

					if ( isset( $customer->id ) && ( ! empty( $customer->id ) ) ) {
						$payer_id = $customer->id;
					}

					if ( isset( $charge->status ) && ( ! empty( $charge->status ) ) ) {
						if ( $charge->status == 'succeeded' ) {
							$package_price = floatval( get_post_meta( $package_id, 'package_price', true ) );
							$this->tfcl_user_package->tfcl_handle_insert_user_package( $user_id, $package_id );
							$invoice_id       = $this->tfcl_invoice->tfcl_handle_insert_invoice( $package_id, $user_id, $payment_method, $payment_id, $payer_id, 1 );
							$args_admin_email = array(
								'invoice_no'  => $invoice_id,
								'total_price' => tfcl_get_format_number( $package_price )
							);
							tfcl_send_email( $admin_email, 'admin_email_paid_package', $args_admin_email );
							tfcl_send_email( $user_email, 'user_email_paid_package', array() );
						} else {
							$message = esc_html( 'Your Payment has been Failed!', 'tf-car-listing' );
							$this->tfcl_transaction_log->tfcl_handle_insert_transaction_log( $package_id, $user_id, $payment_method, $payment_id, $payer_id, 0, 0, $message );
							$error = '<div class="alert alert-danger" role="alert">' . wp_kses_post( __( '<strong>Error!</strong> Transaction failed', 'tf-car-listing' ) ) . '</div>';
							echo wp_kses_post( $error );
						}
					}
				} catch (\Exception $e) {
					$error = '<div class="alert alert-danger" role="alert"><strong>' . esc_html__( 'Error!', 'tf-car-listing' ) . '</strong>' . wp_kses_post( $e->getMessage() ) . '</div>';
					echo wp_kses_post( $error );
				}
			}
		}
	}
}