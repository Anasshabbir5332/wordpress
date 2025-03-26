<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Dashboard_Public' ) ) {
	class Dashboard_Public {
		function tfcl_enqueue_dashboard_scripts() {
			wp_register_script( 'chart', TF_PLUGIN_URL . 'public/assets/third-party/chart/js/chart.js', array(), null, true );
			wp_register_script( 'dashboard-js', TF_PLUGIN_URL . '/public/assets/js/dashboard.js', array( 'jquery' ), null, false );
			wp_localize_script( 'dashboard-js', 'dashboard_variables',
				array(
					'ajax_url' => TF_AJAX_URL,
					'confirm_action_listing_text' => esc_html__( 'Are you sure you want to ', 'tf-car-listing' ),
					'nonce'                        => wp_create_nonce( 'dashboard-ajax-nonce' ),
				)
			);
		}
		public function tfcl_dashboard_shortcode() {
			ob_start();
			$posts_per_page   = '10';
			$list_post_status = array(
				'publish' => esc_html__( 'publish', 'tf-car-listing' ),
				'expired' => esc_html__( 'expired', 'tf-car-listing' ),
				'pending' => esc_html__( 'pending', 'tf-car-listing' ),
				'hidden'  => esc_html__( 'hidden', 'tf-car-listing' ),
				'sold'    => esc_html__( 'sold', 'tf-car-listing' ) );
			$total_post       = wp_count_posts( 'listing' );
			$total_count      = 0;

			// Sum up the counts for all post statuses
			foreach ( $total_post as $status => $statusCount ) {
				$total_count += $statusCount;
			}

			$selected_post_status = $title_search = '';
			$from_date = ! empty( $_REQUEST['from_date'] ) ? wp_unslash( $_REQUEST['from_date'] ) : '';
			$to_date   = ! empty( $_REQUEST['to_date'] ) ? wp_unslash( $_REQUEST['to_date'] ) : '';

			$current_user = wp_get_current_user();
			$author_id    = $current_user->ID;
			// count review by user 
			$total_review    = get_comments( array(
				'user_id' => $author_id,
				'type'    => 'comment',
				'count'   => true
			) );
			$total_favorites = Car_Listing::tfcl_get_total_my_favorites();
			$class_listing  = new Car_Listing();

			$title_search = ! empty( $_REQUEST['title_search'] ) ? wp_unslash( $_REQUEST['title_search'] ) : '';

			// get list pending listing by user.
			$pending_listing_by_user_args = array(
				'post_type'      => 'listing',
				'author'         => $author_id,
				'posts_per_page' => -1,
				'post_status'    => 'pending',
			);
			if ( current_user_can( 'administrator' ) ) {
				$pending_listing_by_user_args['author'] = 0;
			}
			$pending_data            = new WP_Query( $pending_listing_by_user_args );
			$pending_post_by_user    = $pending_data->found_posts;
			$publish_listing_by_user = count_user_posts( $author_id, 'listing', true );
			$args                    = array(
				'post_type'           => 'listing',
				'post_status'         => $list_post_status,
				'author'              => $author_id,
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => $posts_per_page,
				'offset'              => ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $posts_per_page,
				'orderby'             => 'date',
				'order'               => 'desc',
				's'                   => $title_search,
				'date_query'          => array(
					'after'     => $from_date,
					'before'    => $to_date,
					'inclusive' => true,
				),
			);

			if ( current_user_can( 'administrator' ) ) {
				$args['author']      = 0;
				$args['post_status'] = array( 'any', 'expired', 'hidden', 'sold' );
			}

			if ( ! empty( $_REQUEST['post_status'] ) && $_REQUEST['post_status'] != 'default' ) {
				$selected_post_status = wp_unslash( $_REQUEST['post_status'] );
				$args['post_status']  = $selected_post_status;
			} else {
				$args['post_status'] = array( 'any', 'expired', 'hidden', 'sold' );
			}

			$listings           = new WP_Query( $args );
			$total_post_listing = $listings->found_posts;
			// Get review data
			$comments = get_comments( array(
				'post_type'           => 'listing',
				'status'              => 'approve',
				'ignore_sticky_posts' => 1,
				'number'              => 5,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'meta_query'          => array(
					'key' => 'listing_rating'
				)
			) );
			wp_reset_postdata();
			tfcl_get_template_with_arguments(
				'/dashboard/dashboard.php',
				array(
					'listings'                => $listings->posts,
					'pending_listings'        => $pending_post_by_user,
					'publish_listing_by_user' => current_user_can( 'administrator' ) ? $total_post_listing : $publish_listing_by_user,
					'total_post'              => $total_count,
					'total_post_listing'      => $total_post_listing,
					'max_num_pages'            => $listings->max_num_pages,
					'list_post_status'         => $list_post_status,
					'selected_post_status'     => $selected_post_status,
					'search'                   => $title_search,
					'from_date'                => $from_date,
					'to_date'                  => $to_date,
					'total_favorite'          => $total_favorites,
					'total_review'            => $total_review,
					'reviews'                 => $comments
				)
			);
			return ob_get_clean();
		}

		public function tfcl_handle_actions_listing_dashboard() {
			check_ajax_referer( 'dashboard-ajax-nonce', 'security' );
			if ( ! empty( $_REQUEST['listing_action'] ) ) {
				$listing_action = isset( $_REQUEST['listing_action'] ) ? wp_unslash( $_REQUEST['listing_action'] ) : '';
				$listing_id     = isset( $_REQUEST['listing_id'] ) ? absint( wp_unslash( $_REQUEST['listing_id'] ) ) : '';
				$response        = array(
					'status' => false
				);
				try {
					switch ( $listing_action ) {
						case 'delete':
							wp_trash_post( $listing_id );
							$response['status'] = true;
							echo json_encode( $response );
							wp_die();
							break;
						case 'sold':
							$data_update = array(
								'ID'          => $listing_id,
								'post_type'   => 'listing',
								'post_status' => 'sold'
							);
							wp_update_post( $data_update );
							$response['status'] = true;
							echo json_encode( $response );
							wp_die();
							break;
						default:
							# code...
							break;
					}
				} catch (\Throwable $th) {
					//throw $th;
				}
			}
		}

		public static function tfcl_get_chart_data() {
			global $current_user;
			wp_get_current_user();
			$tracking_view_day = ! empty( $_REQUEST['tracking_view_day'] ) ? $_REQUEST['tracking_view_day'] : 7;
			$tracking_view_day--;

			$all_listings = get_posts( array(
				'author'      => current_user_can( 'administrator' ) ? 0 : $current_user->ID,
				'post_type'   => 'listing',
				'post_status' => array( 'publish' )
			) );

			$array_data = array();
			for ( $i = $tracking_view_day; $i >= 0; $i-- ) {
				$date  = date( "Y-m-d", strtotime( "-" . $i . " day" ) );
				$total = 0;
				foreach ( $all_listings as $key => $value ) {
					$views_by_date = get_post_meta( $value->ID, 'listings_views_by_date', true );
					if ( ! is_array( $views_by_date ) ) {
						$views_by_date = array();
					}

					if ( isset( $views_by_date[ $date ] ) ) {
						$total += $views_by_date[ $date ];
					}
				}
				$array_data[] = $total;
			}
			return $array_data;
		}

		public static function tfcl_get_chart_labels() {
			$tracking_view_day = ! empty( $_REQUEST['tracking_view_day'] ) ? $_REQUEST['tracking_view_day'] : 7;
			$tracking_view_day--;

			$array_labels = array();
			for ( $i = $tracking_view_day; $i >= 0; $i-- ) {
				$date           = strtotime( date( "Y-m-d", strtotime( "-" . $i . "day" ) ) );
				$array_labels[] = date_i18n( get_option( 'date_format' ), $date );
			}
			return $array_labels;
		}

		public function tfcl_dashboard_chart_ajax() {
			$response = array(
				'status'  => false,
				'message' => esc_html__( 'Error, try again!', 'tf-car-listing' ),
			);

			if ( ! is_user_logged_in() ) {
				$response['message'] = esc_html__( 'You are not login!', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			$nonce = isset( $_POST['nonce'] ) ? wp_unslash( $_POST['nonce'] ) : '';
			if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'dashboard-ajax-nonce' ) ) {
				$response['message'] = esc_html__( 'Check nonce failed!', 'tf-car-listing' );
				echo json_encode( $response );
				wp_die();
			}

			$response = array(
				'status'       => true,
				'message'      => esc_html__( 'Successfully', 'tf-car-listing' ),
				'chart_labels' => Dashboard_Public::tfcl_get_chart_labels(),
				'chart_data'   => Dashboard_Public::tfcl_get_chart_data(),
				'chart_label'  => esc_html__( 'Page Views', 'tf-car-listing' ),
				'chart_type'   => 'line',
			);

			echo json_encode( $response );
			wp_die();
		}
	}
}