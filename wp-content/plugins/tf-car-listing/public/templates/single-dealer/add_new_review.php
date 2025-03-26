<div class="tfcl_dealer_add_new_review">
	<div class="add_new_review">
		<h2 class="form_heading"><?php esc_html_e( 'Leave a Reply', 'tf-car-listing' ); ?></h2>
		<?php
		if ( ! is_user_logged_in() ) {
			$login_page = esc_url(tfcl_get_permalink( 'login_page' ));
			echo sprintf(wp_kses_post('<h5 class="review-title">You need to <a href="%s"> login </a> in order to post a review.</h5>', 'tf-car-listing'), $login_page);
		} else {
			?>
			<form action="post" id="dealer_add_new_review">
				<div class="ratings-detail">
					<div class="rating-box">
						<div class="customer-service-rating">
							<label for="rating_customer_service"><?php esc_html_e( 'Whats your rating?', 'tf-car-listing' ); ?></label>
							<div id="rating_customer_service" class="rating-box star-rating">
								<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
									<i class="icon-autodeal-star" data-rating="<?php echo esc_attr( $i ); ?>"></i>
								<?php endfor; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="review-content">
					<label for="review-content" class="form-label"><?php esc_html_e( 'Review', 'tf-car-listing' ); ?></label>
					<label id="review-message-error" style="display:none;"></label>
					<textarea name="review" id="review-content" placeholder="<?php echo esc_attr( esc_html__( 'Your Message:', 'tf-car-listing' ) ); ?>" rows="3"></textarea>
				</div>
				<button type="submit" class="tfcl_submit_dealer_review"><?php echo esc_html_e( 'Post Comment', 'tf-car-listing' ); ?>
				</button>
				<?php wp_nonce_field( 'tfcl_submit_dealer_review_ajax_nonce', 'tfcl_security_submit_dealer_review' ); ?>
				<input type="hidden" name="action" value="tfcl_submit_dealer_review_ajax">
				<input type="hidden" name="dealer_id" value="<?php the_ID(); ?>">
				<input type="hidden" id="rating-submit" value="5" name="rating">
				<input type="hidden" id="rating_customer_service_submit" name="rating_customer_service">
				<input type="hidden" id="rating_buying_submit" name="rating_buying">
				<input type="hidden" id="rating_overall_submit" name="rating_overall">
				<input type="hidden" id="rating_speed_submit" name="rating_speed">
			</form>
		<?php } ?>
	</div>
</div>