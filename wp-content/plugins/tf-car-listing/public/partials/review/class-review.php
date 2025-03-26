<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Review' ) ) {
	class Review {
		function tfcl_enqueue_review_scripts() {
			wp_enqueue_script( 'review-js', TF_PLUGIN_URL . '/public/assets/js/review.js', array( 'jquery' ), null, false );
			wp_localize_script( 'review-js', 'review_variables', array(
				'ajaxUrl'                        => TF_AJAX_URL,
				'message_required_review'        => esc_html__( 'Please enter your review.', 'tf-car-listing' ),
				'calc_overall_rating_ajax_nonce' => wp_create_nonce( 'calc_overall_rating_ajax_nonce' ),
			) );
		}

		public function tfcl_get_dealer_rating( $comment_post_id ) {
			$dealer_rating    = array();
			$dealer_rating[1] = tfcl_count_comments_by_meta( $comment_post_id, 'dealer_rating', 1 );
			$dealer_rating[2] = tfcl_count_comments_by_meta( $comment_post_id, 'dealer_rating', 2 );
			$dealer_rating[3] = tfcl_count_comments_by_meta( $comment_post_id, 'dealer_rating', 3 );
			$dealer_rating[4] = tfcl_count_comments_by_meta( $comment_post_id, 'dealer_rating', 4 );
			$dealer_rating[5] = tfcl_count_comments_by_meta( $comment_post_id, 'dealer_rating', 5 );

			$star_rating_total     = $dealer_rating[1] + $dealer_rating[2] + $dealer_rating[3] + $dealer_rating[4] + $dealer_rating[5];
			$dealer_overall_rating = ( 1 * $dealer_rating[1] + 2 * $dealer_rating[2] + 3 * $dealer_rating[3] + 4 * $dealer_rating[4] + 5 * $dealer_rating[5] ) / $star_rating_total;

			return $dealer_overall_rating;
		}

		public function tfcl_submit_review_dealer_ajax() {
			check_ajax_referer( 'tfcl_submit_dealer_review_ajax_nonce', 'tfcl_security_submit_dealer_review' );
			global $wpdb, $current_user;
			wp_get_current_user();
			$user_id                 = $current_user->ID;
			$user                    = get_user_by( 'id', $user_id );
			$dealer_id               = isset( $_POST['dealer_id'] ) ? wp_unslash( $_POST['dealer_id'] ) : '';
			$rating_customer_service = isset( $_POST['rating_customer_service'] ) ? wp_unslash( $_POST['rating_customer_service'] ) : '';
			$rating_buying           = isset( $_POST['rating_buying'] ) ? wp_unslash( $_POST['rating_buying'] ) : '';
			$rating_overall          = isset( $_POST['rating_overall'] ) ? wp_unslash( $_POST['rating_overall'] ) : '';
			$rating_speed            = isset( $_POST['rating_speed'] ) ? wp_unslash( $_POST['rating_speed'] ) : '';

			$data                         = array();
			$user                         = $user->data;
			$data['comment_post_ID']      = $dealer_id;
			$data['comment_content']      = isset( $_POST['review'] ) ? wp_filter_post_kses( $_POST['review'] ) : '';
			$data['comment_date']         = current_time( 'mysql' );
			$data['comment_author']       = $user->user_login;
			$data['comment_author_email'] = $user->user_email;
			$data['comment_author_url']   = $user->user_url;
			$data['user_id']              = $user_id;

			$comment_id = wp_insert_comment( $data );
			add_comment_meta( $comment_id, 'dealer_customer_service_rating', $rating_customer_service );
			add_comment_meta( $comment_id, 'dealer_buying_rating', $rating_buying );
			add_comment_meta( $comment_id, 'dealer_overall_rating', $rating_overall );
			add_comment_meta( $comment_id, 'dealer_speed_rating', $rating_speed );

			wp_send_json_success();
		}

		public function tfcl_update_review_dealer_ajax() {
			check_ajax_referer( 'tfcl_update_review_ajax_nonce', 'tfcl_security_update_review' );
			global $current_user;
			wp_get_current_user();
			$current_user_id               = $current_user->ID;
			$review_id                     = isset( $_POST['reviewID'] ) ? intval( $_POST['reviewID'] ) : 0;
			$new_review                    = isset( $_POST['newReview'] ) ? sanitize_text_field( $_POST['newReview'] ) : '';
			$new_rating                    = isset( $_POST['newRating'] ) ? floatval( $_POST['newRating'] ) : '';
			$new_rating_customer_service   = isset( $_POST['newRatingCustomerService'] ) ? wp_unslash( $_POST['newRatingCustomerService'] ) : '';
			$new_rating_buying_process     = isset( $_POST['newRatingBuyingProcess'] ) ? wp_unslash( $_POST['newRatingBuyingProcess'] ) : '';
			$new_rating_overall_experience = isset( $_POST['newRatingOverallExperience'] ) ? wp_unslash( $_POST['newRatingOverallExperience'] ) : '';
			$new_rating_speed              = isset( $_POST['newRatingSpeed'] ) ? wp_unslash( $_POST['newRatingSpeed'] ) : '';

			$current_comment                   = get_comment( $review_id );
			$current_review                    = $current_comment->comment_content;
			$current_rating_customer_service   = get_comment_meta( $review_id, 'dealer_customer_service_rating', true );
			$current_rating_buying_process     = get_comment_meta( $review_id, 'dealer_buying_rating', true );
			$current_rating_overall_experience = get_comment_meta( $review_id, 'dealer_overall_rating', true );
			$current_rating_speed              = get_comment_meta( $review_id, 'dealer_speed_rating', true );

			$updated_comment = $message = '';
			$success = true;

			if ( ( $current_comment->user_id == $current_user_id ) && ! empty( $new_review ) || ! empty( $new_rating ) ) {
				if ( $new_review != $current_review ) {
					$updated_comment = wp_update_comment(
						array(
							'comment_ID'      => $review_id,
							'comment_content' => $new_review,
						)
					);
				}

				if ( $new_rating_customer_service != $current_rating_customer_service ) {
					$updated_meta = update_comment_meta( $review_id, 'dealer_customer_service_rating', $new_rating_customer_service );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_buying_process != $current_rating_buying_process ) {
					$updated_meta = update_comment_meta( $review_id, 'dealer_buying_rating', $new_rating_buying_process );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_overall_experience != $current_rating_overall_experience ) {
					$updated_meta = update_comment_meta( $review_id, 'dealer_overall_rating', $new_rating_overall_experience );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_speed != $current_rating_speed ) {
					$updated_meta = update_comment_meta( $review_id, 'dealer_speed_rating', $new_rating_speed );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}
			} else {
				$success = false;
				$message = esc_html__( 'Update Comment Failed!', 'tf-car-listing' );
			}

			if ( $success ) {
				$updated_comment = get_comment( $review_id );
				$message         = esc_html__( 'Comment updated successfully!', 'tf-car-listing' );
				wp_send_json(
					array(
						'content'                 => htmlspecialchars_decode( $updated_comment->comment_content ),
						'message'                 => $message,
						'rating'                  => $new_rating,
						'ratingCustomerService'   => $new_rating_customer_service,
						'ratingBuyingProcess'     => $new_rating_buying_process,
						'ratingOverallExperience' => $new_rating_overall_experience,
						'ratingSpeed'             => $new_rating_speed,
						'status'                  => $success,
					)
				);
			} else {
				wp_send_json(
					array(
						'message' => $message,
						'status'  => $success,
					)
				);
			}
			wp_die();
		}

		public function tfcl_calc_overall_rating_dealer_ajax() {
			check_ajax_referer( 'calc_overall_rating_ajax_nonce', 'tfcl_security_calc_overall_rating' );
			global $wpdb;
			$dealer_id      = isset( $_POST['dealerId'] ) ? $_POST['dealerId'] : '';
			$order          = 'DESC';
			$comments_query = $wpdb->prepare( "SELECT * FROM {$wpdb->comments}  as comment INNER JOIN {$wpdb->commentmeta} as meta WHERE  comment.comment_post_ID = %d  AND  meta.comment_id = comment.comment_ID AND (comment.comment_approved = 1) GROUP BY meta.comment_ID ORDER BY comment.comment_date " . $order, $dealer_id );
			$get_comments   = $wpdb->get_results( $comments_query );
			$overall_rating = 0;
			if ( ! is_null( $get_comments ) ) {
				foreach ( $get_comments as $comment ) {
					$comment_meta              = get_comment_meta( $comment->comment_ID );
					$customer_service_rating   = $customer_service_rating + intval( $comment_meta['dealer_customer_service_rating'][0] );
					$buying_process_rating     = $buying_process_rating + intval( $comment_meta['dealer_buying_rating'][0] );
					$overall_experience_rating = $overall_experience_rating + intval( $comment_meta['dealer_overall_rating'][0] );
					$speed_rating              = $speed_rating + intval( $comment_meta['dealer_speed_rating'][0] );
				}
				$total_reviews = count( $get_comments );
				if ( $total_reviews != 0 ) {
					$total_customer_service_rating   = floatval( $customer_service_rating / $total_reviews );
					$total_buying_process_rating     = floatval( $buying_process_rating / $total_reviews );
					$total_overall_experience_rating = floatval( $overall_experience_rating / $total_reviews );
					$total_speed_rating              = floatval( $speed_rating / $total_reviews );
					$overall_rating                  = floatval( ( $total_customer_service_rating + $total_buying_process_rating + $total_overall_experience_rating + $total_speed_rating ) / 4 );
				}
			}
			echo json_encode( number_format( $overall_rating, 1 ) );
			wp_die();
		}

		public function tfcl_submit_review_single_listing_ajax() {
			check_ajax_referer( 'tfcl_submit_review_single_listing_ajax_nonce', 'tfcl_security_submit_review_single_listing' );
			global $wpdb, $current_user;
			wp_get_current_user();
			$user_id    = $current_user->ID;
			$user       = get_user_by( 'id', $user_id );
			$listing_id = isset( $_POST['listing_id'] ) ? wp_unslash( $_POST['listing_id'] ) : '';

			$rating_comfort         = isset( $_POST['rating_comfort'] ) ? wp_unslash( $_POST['rating_comfort'] ) : '';
			$rating_performance     = isset( $_POST['rating_performance'] ) ? wp_unslash( $_POST['rating_performance'] ) : '';
			$rating_interior_design = isset( $_POST['rating_interior_design'] ) ? wp_unslash( $_POST['rating_interior_design'] ) : '';
			$rating_speed           = isset( $_POST['rating_speed'] ) ? wp_unslash( $_POST['rating_speed'] ) : '';
			$rating_value           = floatval( $rating_comfort + $rating_interior_design + $rating_performance + $rating_speed ) / 4;

			$data                         = array();
			$user                         = $user->data;
			$data['comment_post_ID']      = $listing_id;
			$data['comment_content']      = isset( $_POST['review'] ) ? wp_filter_post_kses( $_POST['review'] ) : '';
			$data['comment_date']         = current_time( 'mysql' );
			$data['comment_author']       = $user->user_login;
			$data['comment_author_email'] = $user->user_email;
			$data['comment_author_url']   = $user->user_url;
			$data['user_id']              = $user_id;

			$comment_id = wp_insert_comment( $data );

			add_comment_meta( $comment_id, 'listing_rating', $rating_value );
			add_comment_meta( $comment_id, 'listing_comfort_rating', $rating_comfort );
			add_comment_meta( $comment_id, 'listing_performance_rating', $rating_performance );
			add_comment_meta( $comment_id, 'listing_interior_design_rating', $rating_interior_design );
			add_comment_meta( $comment_id, 'listing_speed_rating', $rating_speed );

			do_action( 'tfcl_listing_rating_meta', $listing_id, $rating_value );
			wp_send_json_success();
		}

		public function tfcl_update_review_listing_ajax() {
			check_ajax_referer( 'tfcl_update_review_ajax_nonce', 'tfcl_security_update_review' );
			global $current_user;
			wp_get_current_user();
			$current_user_id            = $current_user->ID;
			$review_id                  = isset( $_POST['reviewID'] ) ? intval( $_POST['reviewID'] ) : 0;
			$new_review                 = isset( $_POST['newReview'] ) ? sanitize_text_field( $_POST['newReview'] ) : '';
			$new_rating                 = isset( $_POST['newRating'] ) ? floatval( $_POST['newRating'] ) : '';
			$new_rating_comfort         = isset( $_POST['newRatingComfort'] ) ? wp_unslash( $_POST['newRatingComfort'] ) : '';
			$new_rating_performance     = isset( $_POST['newRatingPerformance'] ) ? wp_unslash( $_POST['newRatingPerformance'] ) : '';
			$new_rating_interior_design = isset( $_POST['newRatingInteriorDesign'] ) ? wp_unslash( $_POST['newRatingInteriorDesign'] ) : '';
			$new_rating_speed           = isset( $_POST['newRatingSpeed'] ) ? wp_unslash( $_POST['newRatingSpeed'] ) : '';

			$current_comment                = get_comment( $review_id );
			$current_review                 = $current_comment->comment_content;
			$current_rating                 = get_comment_meta( $review_id, 'listing_rating', true );
			$current_rating_comfort         = get_comment_meta( $review_id, 'listing_comfort_rating', true );
			$current_rating_performance     = get_comment_meta( $review_id, 'listing_performance_rating', true );
			$current_rating_interior_design = get_comment_meta( $review_id, 'listing_interior_design_rating', true );
			$current_rating_speed           = get_comment_meta( $review_id, 'listing_speed_rating', true );

			$updated_comment = $message = '';
			$success = true;
			if ( ( $current_comment->user_id == $current_user_id ) && ! empty( $new_review ) || ! empty( $new_rating ) ) {
				if ( $new_review != $current_review ) {
					$updated_comment = wp_update_comment(
						array(
							'comment_ID'      => $review_id,
							'comment_content' => $new_review,
						)
					);
				}

				if ( $new_rating != $current_rating ) {
					$updated_meta = update_comment_meta( $review_id, 'listing_rating', $new_rating );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_comfort != $current_rating_comfort ) {
					$updated_meta = update_comment_meta( $review_id, 'listing_comfort_rating', $new_rating_comfort );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_performance != $current_rating_performance ) {
					$updated_meta = update_comment_meta( $review_id, 'listing_performance_rating', $new_rating_performance );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_interior_design != $current_rating_interior_design ) {
					$updated_meta = update_comment_meta( $review_id, 'listing_interior_design_rating', $new_rating_interior_design );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}

				if ( $new_rating_speed != $current_rating_speed ) {
					$updated_meta = update_comment_meta( $review_id, 'listing_speed_rating', $new_rating_speed );

					if ( $updated_meta == false ) {
						$success = false;
						$message = esc_html__( 'Update Comment Meta Failed!', 'tf-car-listing' );
					}
				}
			} else {
				$success = false;
				$message = esc_html__( 'Update Comment Failed!', 'tf-car-listing' );
			}

			if ( $success ) {
				$updated_comment = get_comment( $review_id );
				$message         = esc_html__( 'Comment updated successfully!', 'tf-car-listing' );
				wp_send_json(
					array(
						'content'              => htmlspecialchars_decode( $updated_comment->comment_content ),
						'message'              => $message,
						'rating'               => $new_rating,
						'ratingComfort'        => $new_rating_comfort,
						'ratingPerformance'    => $new_rating_performance,
						'ratingInteriorDesign' => $new_rating_interior_design,
						'ratingSpeed'          => $new_rating_speed,
						'status'               => $success,
					)
				);
			} else {
				wp_send_json(
					array(
						'message' => $message,
						'status'  => $success,
					)
				);
			}
			wp_die();
		}

		public function tfcl_rating_meta_filter( $listing_id, $rating_value, $comment_exist = true, $old_rating_value = 0 ) {
			$listing_rating = get_post_meta( $listing_id, 'listing_rating', true );
			if ( $comment_exist == true ) {
				if ( is_array( $listing_rating ) && isset( $listing_rating[ $rating_value ] ) ) {
					$listing_rating[ $rating_value ]++;
				} else {
					$listing_rating    = array();
					$listing_rating[1] = 0;
					$listing_rating[2] = 0;
					$listing_rating[3] = 0;
					$listing_rating[4] = 0;
					$listing_rating[5] = 0;
					$listing_rating[ $rating_value ]++;
				}
			} else {
				$listing_rating[ $old_rating_value ]--;
				$listing_rating[ $rating_value ]++;
			}
			update_post_meta( $listing_id, 'listing_rating', $listing_rating );
		}

		public function tfcl_calc_overall_rating_single_listing_ajax() {
			check_ajax_referer( 'calc_overall_rating_ajax_nonce', 'tfcl_security_calc_overall_rating' );
			global $wpdb;
			$listing_id     = isset( $_POST['listingId'] ) ? $_POST['listingId'] : '';
			$order          = 'DESC';
			$comments_query = $wpdb->prepare( "SELECT * FROM {$wpdb->comments}  as comment INNER JOIN {$wpdb->commentmeta} as meta WHERE  comment.comment_post_ID = %d AND meta.meta_key = 'listing_rating' AND  meta.comment_id = comment.comment_ID AND (comment.comment_approved = 1) GROUP BY meta.comment_ID ORDER BY comment.comment_date " . $order, $listing_id );
			$get_comments   = $wpdb->get_results( $comments_query );
			$overall_rating = 0;
			if ( ! is_null( $get_comments ) ) {
				foreach ( $get_comments as $comment ) {
					$comment_meta           = get_comment_meta( $comment->comment_ID );
					$comfort_rating         = $comfort_rating + intval( $comment_meta['listing_comfort_rating'][0] );
					$performance_rating     = $performance_rating + intval( $comment_meta['listing_performance_rating'][0] );
					$interior_design_rating = $interior_design_rating + intval( $comment_meta['listing_interior_design_rating'][0] );
					$speed_rating           = $speed_rating + intval( $comment_meta['listing_speed_rating'][0] );
				}
				$total_reviews = count( $get_comments );
				if ( $total_reviews != 0 ) {
					$total_comfort_rating         = floatval( $comfort_rating / $total_reviews );
					$total_performance_rating     = floatval( $performance_rating / $total_reviews );
					$total_interior_design_rating = floatval( $interior_design_rating / $total_reviews );
					$total_speed_rating           = floatval( $speed_rating / $total_reviews );
					$overall_rating               = floatval( ( $total_comfort_rating) / 1 );
				}
			}
			echo json_encode( number_format( $overall_rating, 1 ) );
			wp_die();
		}

		public function tfcl_single_listing_review() {
			ob_start();
			global $wpdb;
			$list_filter_review = array( 'newest' => esc_html__( 'newest', 'tf-car-listing' ), 'oldest' => esc_html__( 'oldest', 'tf-car-listing' ) );
			$current_user       = wp_get_current_user();
			$user_id            = $current_user->ID;
			$orderBy            = isset( $_GET['reviewOrderby'] ) ? sanitize_text_field( $_GET['reviewOrderby'] ) : '';
			$order              = '';
			if ( $orderBy == 'newest' ) {
				$order = 'DESC';
			} else {
				$order = 'ASC';
			}
			$listing_id     = get_the_ID();
			$overall_rating = $total_comfort_rating = $total_performance_rating = $total_interior_design_rating = $total_speed_rating = $total_reviews = $total_stars = $comfort_rating = $performance_rating = $interior_design_rating = $speed_rating = 0;
			$comments_query = $wpdb->prepare( "SELECT * FROM {$wpdb->comments}  as comment INNER JOIN {$wpdb->commentmeta} as meta WHERE  comment.comment_post_ID = %d AND meta.meta_key = 'listing_rating' AND  meta.comment_id = comment.comment_ID AND (comment.comment_approved = 1) GROUP BY meta.comment_ID ORDER BY comment.comment_date " . $order, $listing_id );
			$get_comments   = $wpdb->get_results( $comments_query );
			$my_review      = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->comments} as comment INNER JOIN {$wpdb->commentmeta} as meta WHERE comment.comment_post_ID = %d AND comment.user_id = %d AND meta.meta_key = 'listing_rating' AND meta.comment_id = comment.comment_ID ORDER BY comment.comment_ID DESC", $listing_id, $user_id ) );
			if ( ! is_null( $get_comments ) ) {
				foreach ( $get_comments as $comment ) {
					$comment_meta           = get_comment_meta( $comment->comment_ID );
					$comfort_rating         = $comfort_rating + intval( $comment_meta['listing_comfort_rating'][0] );
					$performance_rating     = $performance_rating + intval( $comment_meta['listing_performance_rating'][0] );
					$interior_design_rating = $interior_design_rating + intval( $comment_meta['listing_interior_design_rating'][0] );
					$speed_rating           = $speed_rating + intval( $comment_meta['listing_speed_rating'][0] );
				}
				$total_reviews = count( $get_comments );
				if ( $total_reviews != 0 ) {
					$total_comfort_rating         = floatval( $comfort_rating / $total_reviews );
					$total_performance_rating     = floatval( $performance_rating / $total_reviews );
					$total_interior_design_rating = floatval( $interior_design_rating / $total_reviews );
					$total_speed_rating           = floatval( $speed_rating / $total_reviews );
					$overall_rating               = floatval( ( $total_comfort_rating ) / 1 );
				}
			}
			tfcl_get_template_with_arguments( 'single-listing/review.php',
				array(
					'overall_rating'               => $overall_rating,
					'total_comfort_rating'         => $total_comfort_rating,
					'total_performance_rating'     => $total_performance_rating,
					'total_interior_design_rating' => $total_interior_design_rating,
					'total_speed_rating'           => $total_speed_rating,
					'total_reviews'                => $total_reviews,
					'get_comments'                 => $get_comments,
					'listing_id'                   => $listing_id,
					'selected_filter_review'       => $orderBy,
					'list_filter_review'           => $list_filter_review,
				)
			);
			echo ob_get_clean();
		}

		public static function tfcl_my_rating_shortcode () {
            ob_start();
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
				'/rating/my-rating.php',
				array(
					'reviews'                 => $comments
				)
			);
            return ob_get_clean();
        }
	}
}