<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Admin_Dealer' ) ) {
	/**
	 * Class Admin_Dealer
	 */
	class Admin_Dealer {
		/**
		 * @param $actions
		 * @param $post
		 *
		 * @return mixed
		 */
		public function modify_list_row_actions( $actions, $post ) {
			// Check for your post type.
			if ( $post->post_type == 'dealer' ) {
				if ( in_array( $post->post_status, array( 'pending' ) ) ) {
					$actions['dealer-approve'] = '<a href="' . wp_nonce_url( add_query_arg( 'approve_dealer', $post->ID ), 'approve_dealer' ) . '">' . esc_html__( 'Approve', 'tf-car-listing' ) . '</a>';
				}
			}
			return $actions;
		}

		/**
		 * Approve dealer
		 */
		public function tfcl_approve_dealer() {
			$approve_dealer = isset( $_GET['approve_dealer'] ) ? absint( wp_unslash( $_GET['approve_dealer'] ) ) : '';
			$_wpnonce       = isset( $_REQUEST['_wpnonce'] ) ? wp_unslash( $_REQUEST['_wpnonce'] ) : '';
			if ( $approve_dealer !== '' && wp_verify_nonce( $_wpnonce, 'approve_dealer' ) ) {
				$dealer_data = array(
					'ID'          => $approve_dealer,
					'post_status' => 'publish',
					'post_type'   => 'dealer',
				);
				wp_update_post( $dealer_data );

				$author_id                        = get_post_field( 'post_author', $approve_dealer );
				$user                             = get_user_by( 'id', $author_id );
				$user_email                       = $user->user_email;
				$dealer_name                      = $user->user_login;
				$email_args                       = array(
					'email'       => $user_email,
					'dealer_name' => $dealer_name
				);
				$enable_user_email_approve_dealer = tfcl_get_option( 'enable_user_email_approve_dealer', 'y' );
				if ( $enable_user_email_approve_dealer == 'y' ) {
					tfcl_send_email( $user_email, 'user_email_approve_dealer', $email_args );
				}
				wp_redirect( remove_query_arg( 'approve_dealer', add_query_arg( 'approve_dealer', $approve_dealer, admin_url( 'edit.php?post_type=dealer' ) ) ) );
				exit;
			}
		}
	}
}