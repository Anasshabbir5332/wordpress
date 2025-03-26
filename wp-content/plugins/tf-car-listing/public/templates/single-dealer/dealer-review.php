<div class="dealer-customer-review">
	<?php
	wp_reset_postdata();
	global $wpdb, $current_user;
	$current_user_id    = $current_user->ID;
	$list_filter_review = array( 'newest', 'oldest' );
	$orderBy            = isset( $_GET['reviewOrderby'] ) ? sanitize_text_field( $_GET['reviewOrderby'] ) : '';
	$order              = 'ASC';
	if ( $orderBy == 'newest' ) {
		$order = 'DESC';
	}
	$order          = isset( $order ) ? $order : '';
	$comments_query = $wpdb->prepare( "SELECT * FROM {$wpdb->comments}  as comment INNER JOIN {$wpdb->commentmeta} as meta WHERE  comment.comment_post_ID = %d  AND  meta.comment_id = comment.comment_ID AND (comment.comment_approved = 1) GROUP BY meta.comment_ID ORDER BY comment.comment_date " . $order, get_the_ID() );
	$get_comments   = $wpdb->get_results( $comments_query );

	// calculate for overall rating customer_service
	$customer_service_rating_info  = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_customer_service_rating' );
	$overall_rate_customer_service = $customer_service_rating_info['overall_rate'];
	$percent_rate_customer_service = $customer_service_rating_info['percent_rate'];

	// calculate for overall rating Buying Process
	$buying_rating_info          = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_buying_rating' );
	$overall_rate_buying_process = $buying_rating_info['overall_rate'];
	$percent_rate_buying_process = $buying_rating_info['percent_rate'];

	// calculate for dealer_overall_rating experience
	$overall_rating_info             = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_overall_rating' );
	$overall_rate_overall_experience = $overall_rating_info['overall_rate'];
	$percent_rate_overall_experience = $overall_rating_info['percent_rate'];

	// calculate for dealer speed rating 
	$speed_rating_info  = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_speed_rating' );
	$overall_rate_speed = $speed_rating_info['overall_rate'];
	$percent_rate_speed = $speed_rating_info['percent_rate'];

	// calculate average overall rating
	$total_reviews  = count( $get_comments );
	if ( $total_reviews != 0 ) {
		$overall_rating         = floatval( ( $overall_rate_customer_service + $overall_rate_buying_process + $overall_rate_overall_experience + $overall_rate_speed ) );
	}
	?>
	<?php if ( $total_reviews != 0 ) :?>
	<h2 class="reviews-count"><?php esc_html_e( 'Car User Reviews & Rating', 'tf-car-listing' ); ?></h2>
	<div class="overall-rating">
		<div class="overall-inner">
								<div class="number-overall">
									<i class="icon-autodeal-star"></i>
									<?php echo esc_html__( number_format( $overall_rating, 1 ) ); ?>
								</div>
								<div class="content">
									<p><?php esc_html_e( 'Overall Rating', 'tf-car-listing' ); ?></p>
									<p><?php echo sprintf( __( 'Base on <b> %s Reviews </b>', 'tf-car-listing' ), count($get_comments) ); ?></p>
								</div>
							</div>
	</div>

	<div class="title-content-review">
				<h5><?php echo sprintf( __( '%s Rating and Reviews', 'tf-car-listing' ), count($get_comments) ); ?></h5>
			</div>
	<?php endif; ?>
	<ul class="reviews-list viewmore-action">
		<?php if ( ! is_null( $get_comments ) ) {
			foreach ( $get_comments as $comment ) {
				$author_avatar  = get_the_author_meta( 'profile_image', $comment->user_id );
				$width          = 60;
				$height         = 60;
				$no_avatar_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
				$default_avatar = tfcl_get_option( 'default_user_avatar', '' );
				if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
					$no_avatar_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
				}
				$user_link                              = get_author_posts_url( $comment->user_id );
				$first_name                             = get_the_author_meta( 'first_name', $comment->user_id );
				$last_name                              = get_the_author_meta( 'last_name', $comment->user_id );
				$full_name                              = $first_name . ' ' . $last_name;
				$current_dealer_customer_service_rating = get_comment_meta( $comment->comment_id, 'dealer_customer_service_rating', true );
				$current_dealer_buying_rating           = get_comment_meta( $comment->comment_id, 'dealer_buying_rating', true );
				$current_dealer_overall_rating          = get_comment_meta( $comment->comment_id, 'dealer_overall_rating', true );
				$current_dealer_speed_rating            = get_comment_meta( $comment->comment_id, 'dealer_speed_rating', true );
				?>
				<li class="review-item">
					
					<div class="review-media">
						<img loading="lazy" width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>" src="<?php echo esc_url( $author_avatar ? $author_avatar : '' ) ?>" onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';" alt="<?php esc_attr_e( 'avatar', 'tf-car-listing' ); ?>">
										<div class="media-heading">
											<div class="content">
												<a href="javascript:void(0)"><?php echo esc_html( $full_name ); ?></a>
												<div class="rating-wrap">
													<div class="form-group rating-box-group">
														<div class="rating-box">
															<div id="dealer_customer_service_rating" class="star-rating-review star-rating">
																<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
																	<i class="star disabled-click icon-autodeal-star <?php echo esc_attr( $i <= $current_dealer_customer_service_rating ? 'active' : '' ); ?>"></i>
																<?php endfor; ?>
															</div>
														</div>
													</div>
												</div>
											</div>
												<span class="review-date"><?php echo esc_html( tfcl_get_comment_time( $comment->comment_id ) ); ?></span>
										</div>
					</div>

					<div class="review-body">
					<p class="review-content"> <?php echo esc_html( $comment->comment_content ); ?> </p>
					<div class="tfcl_update_review_message"></div>
						<form method="POST" id="tfcl-form-edit-review-<?php echo esc_attr( $comment->comment_ID ); ?>"
							class="tfcl-form-edit-review" data-id="<?php echo esc_attr( $comment->comment_ID ); ?>">
							<div class="edit-star-rating-box star-rating-review">
								<div class="rating-box-group">
									<div class="rating-box">
										<label>
											<?php esc_html_e( 'Rating', 'tf-car-listing' ); ?>
										</label>
										<div id="dealer_customer_service_rating" class="star-rating">
											<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
												<i class="icon-autodeal-star <?php echo esc_attr( $i <= $current_dealer_customer_service_rating ? 'active' : '' ); ?>" data-rating="<?php echo esc_attr( $i ); ?>"></i>
											<?php endfor; ?>
										</div>
									</div>
								</div>
							</div>
							<textarea id="tfcl-edit-review-<?php echo esc_attr( $comment->comment_ID ); ?>"><?php echo trim( esc_html( $comment->comment_content ) ); ?></textarea>
							<input type="hidden" class="edit_rating" name="edit_rating" value="5">
							<input type="hidden" id="edit_rating_customer_service" name="edit_rating_customer_service">
							<input type="hidden" id="edit_rating_buying_process" name="edit_rating_buying_process">
							<input type="hidden" id="edit_rating_overall_experience" name="edit_rating_overall_experience">
							<input type="hidden" id="edit_rating_speed" name="edit_rating_speed">
							<button class="button tfcl-btn-update-review-dealer"><?php esc_html_e( 'Update', 'tf-car-listing' ); ?></button>
							<?php wp_nonce_field( 'tfcl_update_review_ajax_nonce', 'tfcl_security_update_review' ); ?>
						</form>
					</div>

				
					<?php
					if ( is_user_logged_in() && $comment->user_id == $current_user_id  ) {
						?>
						<a href="javascript:void(0)" class="tfcl-btn-edit-review-dealer">
							<i class="fas fa-pen"></i>
							<?php esc_html_e( 'Edit', 'tf-car-listing' ); ?>
						</a>
						<?php
					}
					?>
				</li>
			<?php }
		} ?>
	</ul>
	<?php if ( count($get_comments) > 3  ):?>
				<div class="view-more-button">
					<?php esc_html_e( 'View more reviews', 'tf-car-listing' ); ?> <i class="icon-autodeal-icon-166"></i>
				</div>
			<?php endif; ?>
</div>