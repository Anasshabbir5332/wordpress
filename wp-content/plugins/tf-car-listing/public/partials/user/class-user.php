<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'User_Public' ) ) {
	class User_Public {

		const ACCESS_TOKEN = 'access_token';

		public $google_client;

		public function __construct( Google_Client $client ) {
			$this->google_client = $client;
		}

		function tfcl_enqueue_user_scripts() {
			wp_enqueue_script( 'user-script', TF_PLUGIN_URL . '/public/assets/js/user.js', array( 'jquery' ), null, true );
			wp_localize_script(
				'user-script',
				'user_script_variables',
				array(
					'ajaxUrl'                         => TF_AJAX_URL,
					'nonce'                           => wp_create_nonce( 'custom-ajax-nonce' ),
					'enable_login_popup'              => tfcl_get_option( 'enable_login_register_popup', 'y' ),
					'login_page'                      => tfcl_get_permalink( 'login_page' ),
					'register_page'                   => tfcl_get_permalink( 'register_page' ),
					'confirm_become_dealer_text'      => esc_html__( 'Are you sure you want to become a Dealer?', 'tf-car-listing' ),
					'confirm_leave_dealer_text'       => esc_html__( 'Are you sure you want to remove Dealer Account?', 'tf-car-listing' ),
					'confirm_reset_profile_form_text' => esc_html( 'Are you sure?', 'tf-car-listing' ),
					'required_profile_fields'         => array(
						'first_name'     => tfcl_check_required_field( 'first_name', 'require_profile_fields' ),
						'last_name'      => tfcl_check_required_field( 'last_name', 'require_profile_fields' ),
						'user_phone'     => tfcl_check_required_field( 'user_phone', 'require_profile_fields' ),
						'user_email'     => tfcl_check_required_field( 'user_email', 'require_profile_fields' ),
						'user_facebook'  => tfcl_check_required_field( 'user_facebook', 'require_profile_fields' ),
						'user_twitter'   => tfcl_check_required_field( 'user_twitter', 'require_profile_fields' ),
						'user_linkedin'  => tfcl_check_required_field( 'user_linkedin', 'require_profile_fields' ),
						'user_instagram' => tfcl_check_required_field( 'user_instagram', 'require_profile_fields' ),
						'user_dribble'   => tfcl_check_required_field( 'user_dribble', 'require_profile_fields' ),
						'user_skype'     => tfcl_check_required_field( 'user_skype', 'require_profile_fields' ),
					)
				)
			);
		}

		function tfcl_enqueue_user_styles() {
			wp_enqueue_style( 'author-custom-page', TF_PLUGIN_URL . 'public/assets/css/author.css', array(), '', 'all' );
		}

		public function tfcl_register_form_shortcode() {
			ob_start();
			include TF_THEME_PATH . '/user/register.php';
			return ob_get_clean();
		}

		public function tfcl_login_form_shortcode() {
			ob_start();
			$login_google_url = User_Public::tfcl_enable_google_login() ? $this->google_client->tfcl_get_authorization_url() : '';
			include TF_THEME_PATH . '/user/login.php';
			return ob_get_clean();
		}

		public function tfcl_login_register_modal() {
			if ( ! is_user_logged_in() ) {
				echo tfcl_get_template_with_arguments(
					'user/login-register-modal.php',
					array()
				);
			}
		}

		public function tfcl_register_ajax_handler() {
			check_ajax_referer( 'custom-ajax-nonce', 'security' );
			$username         = sanitize_user( $_POST['username'] );
			$email            = sanitize_email( $_POST['email'] );
			$password         = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];

			$response = array(
				'status'  => false,
				'message' => ''
			);

			header( 'Content-Type: application/json' );
			if ( empty( $username ) || empty( $email ) || empty( $password ) || empty( $confirm_password ) ) {
				$response['message'] = esc_html__( 'All fields are required.', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			if ( username_exists( $username ) ) {
				$response['message'] = esc_html__( 'Username already exists. Please choose a different username.', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			if ( ! is_email( $email ) ) {
				$response['message'] = esc_html__( 'Invalid email address.', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			if ( email_exists( $email ) ) {
				$response['message'] = esc_html__( 'Email address is already registered.', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			if ( $password !== $confirm_password ) {
				$response['message'] = esc_html__( 'Passwords do not match.', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			// If no errors, create the user
			if ( empty( $errors ) ) {
				$user_id = wp_create_user( $username, $password, $email );
				if ( ! is_wp_error( $user_id ) ) {
					wp_set_current_user( $user_id );
					wp_set_auth_cookie( $user_id );
					wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );
					$response['status']  = true;
					$response['message'] = esc_html__( 'Your account was created, login now!', 'tf-car-listing' );
					echo json_encode( $response );
					wp_die();

				} else {
					$response['message'] = esc_html__( 'Cannot create a new account!', 'tf-car-listing' );
					wp_die();
				}
			}
		}

		public function tfcl_login_ajax_handler() {
			check_ajax_referer( 'custom-ajax-nonce', 'security' );
			$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
			$password = isset( $_POST['password'] ) ? $_POST['password'] : '';

			$response = array(
				'status'  => false,
				'message' => null
			);
			header( 'Content-Type: application/json' );

			$credentials = array(
				'user_login'    => $username,
				'user_password' => $password,
			);

			$user = wp_signon( $credentials, false );

			if ( is_wp_error( $user ) ) {
				// Login failed, handle the error
				$response['message'] = esc_html__( 'A account or password is invalid!', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			} else {
				// Login successful
				wp_set_current_user( $user->ID );
				wp_set_auth_cookie( $user->ID );
				$response['status']       = true;
				$response['message']      = esc_html__( 'Login successful', 'tf-car-listing' );
				$response['redirect_url'] = home_url();
				echo json_encode( $response );
				wp_die();
			}
		}

		public function tfcl_reset_password_ajax_handler() {
			check_ajax_referer( 'tfcl_reset_password_ajax_nonce', 'tfcl_security_reset_password' );
			$user_login = isset( $_POST['user_login'] ) ? wp_unslash( $_POST['user_login'] ) : '';

			if ( empty( $user_login ) ) {
				echo json_encode( array( 'success' => false, 'message' => esc_html__( 'Enter a username or email address.', 'tf-car-listing' ) ) );
				wp_die();
			}
			$login     = trim( $user_login );
			$user_data = get_user_by( 'login', $login );
			// Check user by username first
			if ( empty( $user_data ) ) {
				// Check user by email
				$user_data = get_user_by( 'email', $login );
				if ( empty( $user_data ) ) {
					echo json_encode( array( 'success' => false, 'message' => esc_html__( 'There is no user registered with that email or username.', 'tf-car-listing' ) ) );
					wp_die();
				}
			}
			$user_login = $user_data->user_login;
			$user_email = $user_data->user_email;
			$key        = get_password_reset_key( $user_data );
			if ( is_wp_error( $key ) ) {
				echo json_encode( array( 'success' => false, 'message' => $key ) );
				wp_die();
			}

			$message = esc_html__( 'You have requested to reset your password.', 'tf-car-listing' ) . "\r\n\r\n";
			$message .= sprintf( esc_html__( 'Username: %s', 'tf-car-listing' ), $user_login ) . "\r\n\r\n";
			$message .= esc_html__( 'If you did not request a password reset, please ignore this email.', 'tf-car-listing' ) . "\r\n\r\n";
			$message .= esc_html__( 'To reset your password, visit the following address:', 'tf-car-listing' ) . "\r\n\r\n";
			$message .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n";
			$subject = sprintf( esc_html__( 'Password Reset Request', 'tf-car-listing' ) );
			$subject = apply_filters( 'retrieve_password_title', $subject, $user_login, $user_data );
			$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );
			if ( $message && ! wp_mail( $user_email, $subject, $message ) ) {
				echo json_encode( array( 'success' => false, 'message' => esc_html__( 'The email could not be sent.', 'tf-car-listing' ) . "<br />\n" . esc_html__( 'Possible reason: your host may have disabled the mail() function.', 'tf-car-listing' ) ) );
				wp_die();
			} else {
				echo json_encode( array( 'success' => true, 'message' => esc_html__( 'Please check your email for reset password!', 'tf-car-listing' ) ) );
				wp_die();
			}
		}

		public function tfcl_my_profile_shortcode() {
			$user_id              = get_current_user_id();
			$first_name           = get_user_meta( $user_id, 'first_name', true );
			$last_name            = get_user_meta( $user_id, 'last_name', true );
			$user_description     = get_user_meta( $user_id, 'user_description', true );
			$user_email           = get_the_author_meta( 'user_email', $user_id );
			$user_phone           = get_the_author_meta( 'user_phone', $user_id );
			$user_sales_phone     = get_the_author_meta( 'user_sales_phone', $user_id );
			$user_location        = get_the_author_meta( 'user_location', $user_id );
			$user_sales_hour      = get_the_author_meta( 'user_sales_hour', $user_id );
			$user_company         = get_the_author_meta( 'user_company', $user_id );
			$user_position        = get_the_author_meta( 'user_position', $user_id );
			$user_website         = get_the_author_meta( 'user_website', $user_id );
			$user_facebook        = get_the_author_meta( 'user_facebook', $user_id );
			$user_twitter         = get_the_author_meta( 'user_twitter', $user_id );
			$user_linkedin        = get_the_author_meta( 'user_linkedin', $user_id );
			$user_instagram       = get_the_author_meta( 'user_instagram', $user_id );
			$user_dribble         = get_the_author_meta( 'user_dribble', $user_id );
			$user_skype           = get_the_author_meta( 'user_skype', $user_id );
			$user_youtube         = get_the_author_meta( 'user_youtube', $user_id );
			$user_vimeo           = get_the_author_meta( 'user_vimeo', $user_id );
			$user_pinterest       = get_the_author_meta( 'user_pinterest', $user_id );
			$user_tiktok          = get_the_author_meta( 'user_tiktok', $user_id );
			$user_avatar          = get_the_author_meta( 'profile_image', $user_id );
			$user_avatar_name     = get_the_author_meta( 'profile_image_name', $user_id );
			$agree_term_condition = get_the_author_meta( 'agree_term_condition', $user_id );
			$dealer_id            = get_the_author_meta( 'author_dealer_id', $user_id );
			$dealer_poster        = get_the_post_thumbnail_url( $dealer_id, 'full' );
			$user_data            = array(
				'user_id'              => $user_id,
				'dealer_id'            => $dealer_id,
				'first_name'           => $first_name,
				'last_name'            => $last_name,
				'user_email'           => $user_email,
				'user_phone'           => $user_phone,
				'user_description'     => $user_description,
				'user_sales_phone'     => $user_sales_phone,
				'user_sales_hour'      => $user_sales_hour,
				'user_company'         => $user_company,
				'user_position'        => $user_position,
				'user_location'        => $user_location,
				'user_website'         => $user_website,
				'user_facebook'        => $user_facebook,
				'user_twitter'         => $user_twitter,
				'user_linkedin'        => $user_linkedin,
				'user_instagram'       => $user_instagram,
				'user_dribble'         => $user_dribble,
				'user_skype'           => $user_skype,
				'user_youtube'         => $user_youtube,
				'user_vimeo'           => $user_vimeo,
				'user_pinterest'       => $user_pinterest,
				'user_tiktok'          => $user_tiktok,
				'user_avatar'          => $user_avatar,
				'user_avatar_name'     => $user_avatar_name,
				'dealer_poster'        => $dealer_poster,
				'agree_term_condition' => $agree_term_condition,
			);

			ob_start();
			tfcl_get_template_with_arguments(
				'user/my-profile.php',
				array(
					'user_data' => $user_data,
				)
			);
			return ob_get_clean();
		}

		public function tfcl_profile_update_ajax_handler() {
			check_ajax_referer( 'custom-ajax-nonce', 'security' );

			$response = array(
				'status'  => false,
				'message' => ''
			);

			header( 'Content-Type: application/json' );

			$user_id              = get_current_user_id();
			$first_name           = isset( $_POST['first_name'] ) ? $_POST['first_name'] : '';
			$last_name            = isset( $_POST['last_name'] ) ? $_POST['last_name'] : '';
			$user_email           = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';
			$user_phone           = isset( $_POST['user_phone'] ) ? $_POST['user_phone'] : '';
			$user_sales_phone     = isset( $_POST['user_sales_phone'] ) ? $_POST['user_sales_phone'] : '';
			$user_description     = isset( $_POST['user_description'] ) ? $_POST['user_description'] : '';
			$user_sales_hour      = isset( $_POST['user_sales_hour'] ) ? $_POST['user_sales_hour'] : '';
			$user_company         = isset( $_POST['user_company'] ) ? $_POST['user_company'] : '';
			$user_position        = isset( $_POST['user_position'] ) ? $_POST['user_position'] : '';
			$user_location        = isset( $_POST['user_location'] ) ? $_POST['user_location'] : '';
			$user_website         = isset( $_POST['user_website'] ) ? $_POST['user_website'] : '';
			$user_facebook        = isset( $_POST['user_facebook'] ) ? $_POST['user_facebook'] : '';
			$user_twitter         = isset( $_POST['user_twitter'] ) ? $_POST['user_twitter'] : '';
			$user_linkedin        = isset( $_POST['user_linkedin'] ) ? $_POST['user_linkedin'] : '';
			$user_instagram       = isset( $_POST['user_instagram'] ) ? $_POST['user_instagram'] : '';
			$user_skype           = isset( $_POST['user_skype'] ) ? $_POST['user_skype'] : '';
			$user_dribble         = isset( $_POST['user_dribble'] ) ? $_POST['user_dribble'] : '';
			$user_youtube         = isset( $_POST['user_youtube'] ) ? $_POST['user_youtube'] : '';
			$user_vimeo           = isset( $_POST['user_vimeo'] ) ? $_POST['user_vimeo'] : '';
			$user_pinterest       = isset( $_POST['user_pinterest'] ) ? $_POST['user_pinterest'] : '';
			$user_tiktok          = isset( $_POST['user_tiktok'] ) ? $_POST['user_tiktok'] : '';
			$agree_term_condition = isset( $_POST['agree_term_condition'] ) ? $_POST['agree_term_condition'] : false;
			$avatar_url           = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : get_avatar_url( $user_id );
			$user_avatar          = get_the_author_meta( 'profile_image', $user_id ) ? get_the_author_meta( 'profile_image', $user_id ) : $avatar_url;
			wp_update_user(
				array(
					'ID'         => $user_id,
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'user_email' => $user_email,
				)
			);
			update_user_meta( $user_id, 'user_description', $user_description );
			update_user_meta( $user_id, 'user_phone', $user_phone );
			update_user_meta( $user_id, 'user_sales_phone', $user_sales_phone );
			update_user_meta( $user_id, 'user_sales_hour', $user_sales_hour );
			update_user_meta( $user_id, 'user_location', $user_location );
			update_user_meta( $user_id, 'user_position', $user_position );
			update_user_meta( $user_id, 'user_website', $user_website );
			update_user_meta( $user_id, 'user_company', $user_company );
			update_user_meta( $user_id, 'user_facebook', $user_facebook );
			update_user_meta( $user_id, 'user_twitter', $user_twitter );
			update_user_meta( $user_id, 'user_linkedin', $user_linkedin );
			update_user_meta( $user_id, 'user_instagram', $user_instagram );
			update_user_meta( $user_id, 'user_skype', $user_skype );
			update_user_meta( $user_id, 'user_dribble', $user_dribble );
			update_user_meta( $user_id, 'user_vimeo', $user_vimeo );
			update_user_meta( $user_id, 'user_youtube', $user_youtube );
			update_user_meta( $user_id, 'user_pinterest', $user_pinterest );
			update_user_meta( $user_id, 'user_tiktok', $user_tiktok );

			// update info dealer if user is dealer
			if ( tfcl_is_dealer() ) {
				$dealer_id = get_user_meta( $user_id, 'author_dealer_id', true );

				if ( ! empty( $first_name ) && ! empty( $last_name ) ) {
					$new_dealer_full_name = $first_name . ' ' . $last_name;
					$new_dealer_title     = array(
						'ID'         => $dealer_id,
						'post_title' => $new_dealer_full_name,
					);
					if ( ! empty( $new_dealer_full_name ) ) {
						wp_update_post( $new_dealer_title );
					}
				}

				// Update the post into the database

				update_post_meta( $dealer_id, 'dealer_user_id', $user_id );
				update_post_meta( $dealer_id, 'dealer_email', $user_email );
				update_post_meta( $dealer_id, 'dealer_phone_number', $user_phone );
				update_post_meta( $dealer_id, 'dealer_sales_phone', $user_sales_phone );
				update_post_meta( $dealer_id, 'dealer_office_address', $user_location );
				update_post_meta( $dealer_id, 'dealer_sales_hour', $user_sales_hour );
				update_post_meta( $dealer_id, 'dealer_des_info', $user_description );
				update_post_meta( $dealer_id, 'dealer_company_name', $user_company );
				update_post_meta( $dealer_id, 'dealer_position', $user_position );
				update_post_meta( $dealer_id, 'dealer_website', $user_website );

				update_post_meta( $dealer_id, 'dealer_facebook', $user_facebook );
				update_post_meta( $dealer_id, 'dealer_instagram', $user_instagram );
				update_post_meta( $dealer_id, 'dealer_twitter', $user_twitter );
				update_post_meta( $dealer_id, 'dealer_dribble', $user_dribble );
				update_post_meta( $dealer_id, 'dealer_linkedin', $user_linkedin );
				update_post_meta( $dealer_id, 'dealer_skype', $user_skype );
				update_post_meta( $dealer_id, 'dealer_youtube', $user_youtube );
				update_post_meta( $dealer_id, 'dealer_vimeo', $user_vimeo );
				update_post_meta( $dealer_id, 'dealer_tiktok', $user_tiktok );
				update_post_meta( $dealer_id, 'user_pinterest', $user_pinterest );
			}

			update_user_meta( $user_id, 'agree_term_condition', $agree_term_condition );

			$response['status']     = true;
			$response['message']    = esc_html__( 'Profile updated successfully', 'tf-car-listing' );
			$response['avatar_url'] = $avatar_url;

			echo json_encode( $response );
			wp_die();
		}

		public function tfcl_upload_avatar_ajax_handler() {
			$response = array(
				'status'  => false,
				'message' => ''
			);
			header( 'Content-Type: application/json' );
			$user_id = get_current_user_id();
			// Handle the profile image upload, if provided
			if ( ! empty( $_FILES['tfcl_avatar'] ) ) {
				$file       = $_FILES['tfcl_avatar'];
				$file_name  = $_FILES['tfcl_avatar']['name'];
				$upload_dir = wp_upload_dir();

				// Handle the avatar image upload
				$uploaded_avatar = wp_handle_upload( $file, array( 'test_form' => false ) );
				if ( $uploaded_avatar && ! isset( $uploaded_avatar['error'] ) ) {
					// Avatar uploaded successfully
					$avatar_url = $uploaded_avatar['url'];
					move_uploaded_file( $file['tmp_name'], $avatar_url );
					update_user_meta( $user_id, 'profile_image', $avatar_url );
					update_user_meta( $user_id, 'profile_image_name', $file_name );
					$file_type          = wp_check_filetype( $uploaded_avatar['file'] );
					$attachment_details = array(
						'guid'           => $avatar_url,
						'post_mime_type' => $file_type['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);

					$attach_id   = wp_insert_attachment( $attachment_details, $uploaded_avatar['file'] );
					$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_avatar['file'] );
					wp_update_attachment_metadata( $attach_id, $attach_data );
					update_user_meta( $user_id, 'profile_image_id', $attach_id );
					$response['status']     = true;
					$response['avatar_url'] = $avatar_url;
					$response['message']    = esc_html__( 'Avatar uploaded successfully', 'tf-car-listing' );
					echo json_encode( $response );
					wp_die();
				} else {
					$response['message'] = esc_html__( 'Avatar upload failed.', 'tf-car-listing' );
					echo json_encode( $response );
					wp_die();
				}
			}
		}

		public function tfcl_upload_dealer_poster_ajax_handler() {
			$response = array(
				'status'  => false,
				'message' => ''
			);
			header( 'Content-Type: application/json' );
			$current_user = wp_get_current_user();
			$user_id      = $current_user->ID;
			// Handle the profile image upload, if provided
			if ( ! empty( $_FILES['tfcl_dealer_poster'] ) ) {
				$file       = $_FILES['tfcl_dealer_poster'];
				$file_name  = $_FILES['tfcl_dealer_poster']['name'];
				$upload_dir = wp_upload_dir();

				// Handle the avatar image upload
				$uploaded_dealer_poster = wp_handle_upload( $file, array( 'test_form' => false ) );
				if ( $uploaded_dealer_poster && ! isset( $uploaded_dealer_poster['error'] ) ) {
					// Avatar uploaded successfully
					$dealer_poster_url = $uploaded_dealer_poster['url'];
					move_uploaded_file( $file['tmp_name'], $dealer_poster_url );
					$file_type          = wp_check_filetype( $uploaded_dealer_poster['file'] );
					$attachment_details = array(
						'guid'           => $uploaded_dealer_poster['url'],
						'post_mime_type' => $file_type['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);
					$attach_id          = wp_insert_attachment( $attachment_details, $uploaded_dealer_poster['file'] );
					$attach_data        = wp_generate_attachment_metadata( $attach_id, $uploaded_dealer_poster['file'] );
					wp_update_attachment_metadata( $attach_id, $attach_data );

					$dealer_id = get_the_author_meta( 'author_dealer_id', $user_id );

					if ( ! empty( $dealer_id ) && ( get_post_type( $dealer_id ) == 'dealer' ) && ( get_post_status( $dealer_id ) == 'publish' ) ) {
						update_post_meta( $dealer_id, '_thumbnail_id', $attach_id );
					}

					$response['status']            = true;
					$response['dealer_poster_url'] = $dealer_poster_url;
					$response['message']           = esc_html__( 'Dealer poster uploaded successfully', 'tf-car-listing' );
					echo json_encode( $response );
					wp_die();
				} else {
					$response['message'] = esc_html__( 'Dealer poster upload failed.', 'tf-car-listing' );
					echo json_encode( $response );
					wp_die();
				}
			}
		}

		public function tfcl_change_password_ajax_handler() {
			check_ajax_referer( 'tfcl_change_password_ajax_nonce', 'tfcl_security_change_password' );

			$user_id      = get_current_user_id();
			$old_pass     = isset( $_POST['old_pass'] ) ? wp_unslash( $_POST['old_pass'] ) : '';
			$new_pass     = isset( $_POST['new_pass'] ) ? wp_unslash( $_POST['new_pass'] ) : '';
			$confirm_pass = isset( $_POST['confirm_pass'] ) ? wp_slash( $_POST['confirm_pass'] ) : '';

			$response = array(
				'status'  => false,
				'message' => null
			);

			if ( $new_pass == '' || $confirm_pass == '' ) {
				$response['message'] = esc_html__( 'New password or confirm password is required', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			if ( $new_pass != $confirm_pass ) {
				$response['message'] = esc_html__( 'Passwords do not match', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			$user = get_user_by( 'id', $user_id );

			// Not allow change password demo account
			if ( $user->data->user_login == 'demo' ) {
				$response['message'] = esc_html__( 'Demo account are not allowed to change password', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			if ( $user && wp_check_password( $old_pass, $user->data->user_pass, $user_id ) ) {
				wp_set_password( $new_pass, $user_id );
				wp_set_current_user( $user_id );
				wp_set_auth_cookie( $user_id );
				$response['success'] = true;
				$response['message'] = esc_html__( 'Password changed successfully', 'tf-car-listing' );
				echo json_encode( $response );
			} else {
				$response['message'] = esc_html__( 'Old password is not correct', 'tf-car-listing' );
				echo json_encode( $response );
			}
			wp_die();
		}

		public function tfcl_single_author_summary() {
			tfcl_get_template_with_arguments( 'single-author/author-introduce.php' );
		}

		public function tfcl_single_author_listing() {
			tfcl_get_template_with_arguments( 'single-author/author-listing.php' );
		}

		public function tfcl_become_dealer() {
			$user_can_become_dealer = tfcl_get_option( 'user_can_become_dealer', 'y' );
			if ( $user_can_become_dealer == 'y' ) {
				check_ajax_referer( 'custom-ajax-nonce', 'security' );
				$response = array(
					'status'  => false,
					'message' => ''
				);
				global $current_user;
				wp_get_current_user();

				$user_id = $current_user->ID;

				$first_name       = get_the_author_meta( 'first_name', $current_user->ID );
				$last_name        = get_the_author_meta( 'last_name', $current_user->ID );
				$user_description = get_the_author_meta( 'user_description', $current_user->ID );
				$user_location    = get_the_author_meta( 'user_location', $current_user->ID );
				$user_email       = $current_user->user_email;
				$user_phone       = get_the_author_meta( 'user_phone', $current_user->ID );
				$user_sales_phone = get_the_author_meta( 'user_sales_phone', $current_user->ID );
				$user_sales_hour  = get_the_author_meta( 'user_sales_hour', $current_user->ID );
				$user_company     = get_the_author_meta( 'user_company', $current_user->ID );

				$user_avatar_id = get_the_author_meta( 'profile_image_id', $current_user->ID );
				$user_login     = get_the_author_meta( 'user_login', $current_user->ID );

				// social links
				$user_facebook  = get_the_author_meta( 'user_facebook', $current_user->ID );
				$user_instagram = get_the_author_meta( 'user_instagram', $current_user->ID );
				$user_twitter   = get_the_author_meta( 'user_twitter', $current_user->ID );
				$user_dribble   = get_the_author_meta( 'user_dribble', $current_user->ID );
				$user_linkedin  = get_the_author_meta( 'user_linkedin', $current_user->ID );
				$user_skype     = get_the_author_meta( 'user_skype', $current_user->ID );
				$user_youtube   = get_the_author_meta( 'user_youtube', $current_user->ID );
				$user_vimeo     = get_the_author_meta( 'user_vimeo', $current_user->ID );
				$user_pinterest = get_the_author_meta( 'user_pinterest', $current_user->ID );
				$user_tiktok    = get_the_author_meta( 'user_tiktok', $current_user->ID );

				$post_status          = 'pending';
				$auto_approved_dealer = tfcl_get_option( 'auto_approve_dealer', 'n' );
				if ( $auto_approved_dealer == 'y' ) {
					$post_status = 'publish';
				}

				// insert dealer
				$dealer_id = wp_insert_post(
					array(
						'post_title'   => $user_login,
						'post_type'    => 'dealer',
						'post_status'  => $post_status,
						'post_content' => $user_description
					)
				);

				if ( $dealer_id > 0 ) {
					update_user_meta( $user_id, 'author_dealer_id', $dealer_id );
					update_post_meta( $dealer_id, 'dealer_user_id', $user_id );
					update_post_meta( $dealer_id, 'dealer_email', $user_email );
					update_post_meta( $dealer_id, 'dealer_phone_number', $user_phone );
					update_post_meta( $dealer_id, 'dealer_sales_phone', $user_sales_phone );
					update_post_meta( $dealer_id, 'dealer_location', $user_location );
					update_post_meta( $dealer_id, 'dealer_sales_hour', $user_sales_hour );
					update_post_meta( $dealer_id, 'dealer_des_info', $user_description );
					update_post_meta( $dealer_id, 'dealer_company_name', $user_company );


					update_post_meta( $dealer_id, 'dealer_facebook', $user_facebook );
					update_post_meta( $dealer_id, 'dealer_instagram', $user_instagram );
					update_post_meta( $dealer_id, 'dealer_twitter', $user_twitter );
					update_post_meta( $dealer_id, 'dealer_dribble', $user_dribble );
					update_post_meta( $dealer_id, 'dealer_linkedin', $user_linkedin );
					update_post_meta( $dealer_id, 'dealer_skype', $user_skype );
					update_post_meta( $dealer_id, 'dealer_youtube', $user_youtube );
					update_post_meta( $dealer_id, 'dealer_vimeo', $user_vimeo );
					update_post_meta( $dealer_id, 'dealer_tiktok', $user_tiktok );
					update_post_meta( $dealer_id, 'user_pinterest', $user_pinterest );

					$admin_email = get_option( 'new_admin_email' );
					$email_args  = array(
						'email'       => $admin_email,
						'dealer_name' => $user_login
					);

					$enable_admin_email_approve_dealer = tfcl_get_option( 'enable_admin_email_approve_dealer', 'y' );
					if ( $enable_admin_email_approve_dealer == 'y' ) {
						tfcl_send_email( $admin_email, 'admin_email_approve_dealer', $email_args );
					}

					if ( $auto_approved_dealer == 'y' ) {
						$response['status']  = true;
						$response['message'] = esc_html__( 'You have successfully registered!', 'tf-car-listing' );
					} else {
						$response['status']  = true;
						$response['message'] = esc_html__( 'You have successfully registered and is pending approval by an admin!', 'tf-car-listing' );
					}

				} else {
					$response['message'] = esc_html__( 'Become A Dealer Failed!', 'tf-car-listing' );
				}
				echo json_encode( $response );
				wp_die();
			} else {
				$response = array(
					'status'  => false,
					'message' => esc_html__( 'We do not allow to become a dealer.', 'tf-car-listing' ),
				);
				echo json_encode( $response );
				wp_die();
			}
		}

		public function tfcl_leave_dealer() {
			check_ajax_referer( 'custom-ajax-nonce', 'security' );
			global $current_user;
			wp_get_current_user();
			$user_id   = $current_user->ID;
			$dealer_id = get_the_author_meta( 'author_dealer_id', $user_id );
			$response  = array(
				'status'  => false,
				'message' => ''
			);
			if ( ! empty( $dealer_id ) && ( get_post_type( $dealer_id ) == 'dealer' ) ) {
				wp_delete_post( $dealer_id );
				update_user_meta( $user_id, 'author_dealer_id', '' );
				$response['status']  = true;
				$response['message'] = esc_html__( 'Remove Dealer Account successfully!', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			} else {
				$response['message'] = esc_html__( 'Dealer not found!', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}
		}

		function tfcl_set_access_token_google() {
			check_ajax_referer( 'custom-ajax-nonce', 'security' );
			$response = array(
				'status' => false,
			);
			if ( isset( $_POST['code'] ) ) {
				$get_access_token = $this->google_client->tfcl_get_access_token( $_POST['code'] );
				// Start a session to persist credentials.
				session_start();
				$_SESSION[ self::ACCESS_TOKEN ] = isset( $get_access_token[ self::ACCESS_TOKEN ] ) ? $get_access_token[ self::ACCESS_TOKEN ] : null;
				$response['status']             = true;
			}
			echo json_encode( $response );
			wp_die();
		}

		function tfcl_handle_google_login_ajax() {
			check_ajax_referer( 'custom-ajax-nonce', 'security' );
			$response = array(
				'status' => false,
			);
			header( 'Content-Type: application/json' );
			// Start a session to persist credentials.
			session_start();
			if ( $_SESSION[ self::ACCESS_TOKEN ] ) {
				$user = $this->google_client->tfcl_get_user_info($_SESSION[self::ACCESS_TOKEN]);
				$this->tfcl_login_by_google_user( $user );
				$response = array(
					'status'       => true,
					'redirect_url' => tfcl_get_permalink( 'dashboard_page' ),
				);
			}
			echo json_encode( $response );
			wp_die();
		}

		function tfcl_login_by_google_user( $response ) {
			// if there is any error, send the error back to client
			if ( isset( $response->error ) ) {
				wp_send_json_error( $response->error_description );
			} else {
				// check if user already exists in WordPress users
				$first_name      = isset( $response['given_name'] ) ? $response['given_name'] : '';
				$last_name       = isset( $response['family_name'] ) ? $response['family_name'] : '';
				$user_picture    = isset( $response['picture'] ) ? $response['picture'] : '';
				$user_picture_id = tfcl_save_image_from_url( $user_picture );
				$name            = isset( $response['name'] ) ? $response['name'] : '';
				$email           = isset( $response['email'] ) ? $response['email'] : '';
				$email_exists    = email_exists( $email );
				if ( ! $email_exists ) {
					// user does not exists
					// generate a random hashed password
					$random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
					// insert the user as WordPress user
					$user_id = wp_insert_user( [ 
						"user_email"   => $email,
						"user_pass"    => $random_password,
						"user_login"   => $email,
						"display_name" => $name,
						"nickname"     => $name,
						"first_name"   => $first_name,
						"last_name"    => $last_name
					] );
					wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );
					// set user profile picture         
					update_user_meta( $user_id, "profile_image", $user_picture );
					update_user_meta( $user_id, "profile_image_id", $user_picture_id );
				}

				// do login
				$user = get_user_by( 'email', $email );

				if ( ! is_wp_error( $user ) ) {
					wp_clear_auth_cookie();
					wp_set_current_user( $user->ID, $user->user_login );
					wp_set_auth_cookie( $user->ID );
				}
			}
		}

		public static function tfcl_enable_google_login() {
			if ( tfcl_get_option( 'enable_google_login' ) == 'y' ) {
				return true;
			}
			return false;
		}
	}
}