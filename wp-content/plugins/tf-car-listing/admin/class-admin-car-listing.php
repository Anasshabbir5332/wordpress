<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Admin_Car_Listing' ) ) {
	/*
	 * Class Admin_Car_Listing 
	 */
	class Admin_Car_Listing {
		public function tfcl_modify_list_row_actions( $actions, $post ) {
			// Check for your post type.
			if ( $post->post_type == 'listing' ) {
				if ( in_array( $post->post_status, array( 'pending' ) ) && current_user_can( 'publish_listings', $post->ID ) ) {
					$actions['listing-approve'] = '<a href="' . wp_nonce_url( add_query_arg( 'approve_listing', $post->ID ), 'approve_listing' ) . '">' . esc_html__( 'Approve', 'tf-car-listing' ) . '</a>';
				}
				if ( in_array( $post->post_status, array( 'publish' ) ) && current_user_can( 'publish_listings', $post->ID ) ) {
					$actions['listing-hidden'] = '<a href="' . wp_nonce_url( add_query_arg( 'hidden_listing', $post->ID ), 'hidden_listing' ) . '">' . esc_html__( 'Hide', 'tf-car-listing' ) . '</a>';
				}
				if ( in_array( $post->post_status, array( 'hidden' ) ) && current_user_can( 'publish_listings', $post->ID ) ) {
					$actions['listing-show'] = '<a href="' . wp_nonce_url( add_query_arg( 'show_listing', $post->ID ), 'show_listing' ) . '">' . esc_html__( 'Show', 'tf-car-listing' ) . '</a>';
				}
			}
			return $actions;
		}

		public function tfcl_approve_listing() {
			if ( ! empty( $_GET['approve_listing'] ) && wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce'] ), 'approve_listing' ) && current_user_can( 'publish_post', $_GET['approve_listing'] ) ) {
				$post_id      = absint( wp_unslash( $_GET['approve_listing'] ) );
				$listing_data = array(
					'ID'          => $post_id,
					'post_status' => 'publish'
				);
				wp_update_post( $listing_data );

				$author_id  = get_post_field( 'post_author', $post_id );
				$user       = get_user_by( 'id', $author_id );
				$user_email = $user->user_email;
				$user_name  = $user->user_login;

				$email_args = array(
					'user_name'     => $user_name,
					'listing_title' => get_the_title( $post_id ),
					'listing_url'   => get_permalink( $post_id )
				);

				$enable_user_email_approve_listing = tfcl_get_option( 'enable_user_email_approve_listing', 'y' );
				if ( $enable_user_email_approve_listing ) {
					tfcl_send_email( $user_email, 'user_email_approve_listing', $email_args );
				}

				wp_redirect( remove_query_arg( 'approve_listing', add_query_arg( 'approve_listing', $post_id, admin_url( 'edit.php?post_type=listing' ) ) ) );
				exit;
			}
		}

		public function tfcl_hidden_listing() {
			if ( ! empty( $_GET['hidden_listing'] ) && wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce'] ), 'hidden_listing' ) && current_user_can( 'publish_post', $_GET['hidden_listing'] ) ) {
				$post_id      = absint( wp_unslash( $_GET['hidden_listing'] ) );
				$listing_data = array(
					'ID'          => $post_id,
					'post_status' => 'hidden'
				);
				wp_update_post( $listing_data );
				wp_redirect( remove_query_arg( 'hidden_listing', add_query_arg( 'hidden_listing', $post_id, admin_url( 'edit.php?post_type=listing' ) ) ) );
				exit;
			}
		}

		public function tfcl_show_listing() {
			if ( ! empty( $_GET['show_listing'] ) && wp_verify_nonce( wp_unslash( $_REQUEST['_wpnonce'] ), 'show_listing' ) && current_user_can( 'publish_post', $_GET['show_listing'] ) ) {
				$post_id      = absint( wp_unslash( $_GET['show_listing'] ) );
				$listing_data = array(
					'ID'          => $post_id,
					'post_status' => 'publish'
				);
				wp_update_post( $listing_data );
				wp_redirect( remove_query_arg( 'show_listing', add_query_arg( 'show_listing', $post_id, admin_url( 'edit.php?post_type=listing' ) ) ) );
				exit;
			}
		}

		public function tfcl_filter_restrict_manage_listings() {
			global $post_type;
			$post_type_listing = 'listing';
			if ( $post_type == $post_type_listing ) {
				$listing_author   = isset( $_GET['listing_author'] ) ? $_GET['listing_author'] : '';
				$listing_identity = isset( $_GET['listing_identity'] ) ? $_GET['listing_identity'] : '';
				$taxonomy_array   = array( 'condition', 'make', 'model', 'body', 'features' );
				foreach ( $taxonomy_array as $key => $tax ) {
					$tax_selected  = isset( $_GET[ $tax ] ) ? $_GET[ $tax ] : '';
					$info_taxonomy = get_taxonomy( $tax );
					wp_dropdown_categories(
						array(
							'show_option_all' => sprintf( esc_html( 'All %s', 'tf-car-listing' ), esc_html( $info_taxonomy->label ) ),
							'taxonomy'        => $tax,
							'name'            => $tax,
							'orderby'         => 'name',
							'selected'        => $tax_selected,
							'show_count'      => true,
							'hide_empty'      => false,
						) );
				}
				?>
				<input type="text" placeholder="<?php esc_attr_e( 'Listing Author', 'tf-car-listing' ); ?>" name="listing_author"
					value="<?php echo esc_attr( $listing_author ); ?>">
				<input type="text" placeholder="<?php esc_attr_e( 'Listing ID', 'tf-car-listing' ); ?>" name="listing_identity"
					value="<?php echo esc_attr( $listing_identity ); ?>">
				<?php
			}
		}

		public function tfcl_handle_filter_listings( $query ) {
			global $pagenow;
			$post_type  = 'listing';
			$query_vars = &$query->query_vars;
			if ( $pagenow == 'edit.php' && isset( $query_vars['post_type'] ) && $query_vars['post_type'] == $post_type ) {
				$taxonomy_array = array( 'condition', 'make', 'model', 'body', 'features' );
				foreach ( $taxonomy_array as $key => $tax ) {
					if ( isset( $query_vars[ $tax ] ) && is_numeric( $query_vars[ $tax ] ) && $query_vars[ $tax ] != 0 ) {
						$term               = get_term_by( 'id', $query_vars[ $tax ], $tax );
						$query_vars[ $tax ] = $term->slug;
					}
				}

				if ( isset( $_GET['listing_author'] ) && $_GET['listing_author'] != '' ) {
					$query_vars['author_name'] = wp_unslash( $_GET['listing_author'] );
				}

				if ( isset( $_GET['listing_identity'] ) && $_GET['listing_identity'] != '' ) {
					$query_vars['meta_key']     = 'listing_identity';
					$query_vars['meta_value']   = wp_unslash( $_GET['listing_identity'] );
					$query_vars['meta_type']    = 'CHAR';
					$query_vars['meta_compare'] = '=';
				}
			}
		}

		public function tfcl_register_new_post_status() {

			register_post_status( 'expired', array(

				'label'                     => _x( 'Expired', 'post status', 'tf-car-listing' ),

				'public'                    => true,

				'protected'                 => true,

				'exclude_from_search'       => true,

				'show_in_admin_all_list'    => true,

				'show_in_admin_status_list' => true,

				'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'tf-car-listing' ),

			) );

			register_post_status( 'hidden', array(

				'label'                     => _x( 'Hidden', 'post status', 'tf-car-listing' ),

				'public'                    => true,

				'protected'                 => true,

				'exclude_from_search'       => true,

				'show_in_admin_all_list'    => true,

				'show_in_admin_status_list' => true,

				'label_count'               => _n_noop( 'Hidden <span class="count">(%s)</span>', 'Hidden <span class="count">(%s)</span>', 'tf-car-listing' ),

			) );

			register_post_status( 'sold', array(

				'label'                     => _x( 'Sold', 'post status', 'tf-car-listing' ),

				'public'                    => true,

				'protected'                 => true,

				'exclude_from_search'       => true,

				'show_in_admin_all_list'    => true,

				'show_in_admin_status_list' => true,

				'label_count'               => _n_noop( 'Sold <span class="count">(%s)</span>', 'Sold <span class="count">(%s)</span>', 'tf-car-listing' ),

			) );
		}
	}
}