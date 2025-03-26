<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $current_user;
$current_user_id                = $current_user->ID;
$show_review                    = is_array( tfcl_get_option( 'single_listing_panels_manager' ) ) ? tfcl_get_option( 'single_listing_panels_manager' )['review'] : false;
$percent_overall_rating         = ( $overall_rating / 5 ) * 100;
if ( $show_review == true ) :
	?>
	<div id="review" class="single-listing-element listing-reviews">
		<div class="reviews-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="tfcl-listing-header">
						<div class="row">
							<div class="col-lg-8 col-md-6 col-sm-12">
								<h3 class="reviews-count">
									<?php esc_html_e( 'Car User Reviews & Rating', 'tf-car-listing' ); ?>
								</h3>
							</div>
						</div>
					</div>
					<div class="listing-customer-review">
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
					</div>
				</div>
			</div>
			<div class="title-content-review">
				<h5><?php echo sprintf( __( '%s Rating and Reviews', 'tf-car-listing' ), count($get_comments) ); ?></h5>
			</div>
			<ul class="reviews-list viewmore-action">
				<?php if ( ! is_null( $get_comments ) ) {
					foreach ( $get_comments as $comment ) {
						$author_picture = get_the_author_meta( 'profile_image', $comment->user_id );
						$width          = 60;
						$height         = 60;
						$no_avatar_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
						$default_avatar = tfcl_get_option( 'default_user_avatar', '' );
						if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
							$no_avatar_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
						}
						$author_first_name              = get_the_author_meta( 'first_name', $comment->user_id );
						$author_last_name               = get_the_author_meta( 'last_name', $comment->user_id );
						$author_full_name               = $author_first_name . ' ' . $author_last_name;
						$current_rating_comfort         = get_comment_meta( $comment->comment_id, 'listing_comfort_rating', true );
						$current_rating_performance     = get_comment_meta( $comment->comment_id, 'listing_performance_rating', true );
						$current_rating_interior_design = get_comment_meta( $comment->comment_id, 'listing_interior_design_rating', true );
						$current_rating_speed           = get_comment_meta( $comment->comment_id, 'listing_speed_rating', true );
						?>
						<li class="review-item">
								<div class="review-media">
									<img loading="lazy" width="<?php echo esc_attr( $width ) ?>"
										height="<?php echo esc_attr( $height ) ?>"
										src="<?php echo esc_url( $author_picture ? $author_picture : '' ) ?>"
										onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';" alt="<?php esc_attr_e( 'avatar', 'tf-car-listing' ); ?>">
										<div class="media-heading">
											<div class="content">
												<a href="javascript:void(0)"><?php echo esc_html( $author_full_name ); ?></a>
												<div class="rating-wrap">
													<div class="form-group rating-box-group">
														<div class="rating-box">
															<div id="rating_comfort_service" class="star-rating-review star-rating">
																<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
																	<i
																		class="star disabled-click icon-autodeal-star <?php echo esc_attr( $i <= $current_rating_comfort ? 'active' : '' ); ?>"></i>
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
								<form method="POST"
									id="tfcl-form-edit-review-<?php echo esc_attr( $comment->comment_ID ); ?>"
									class="tfcl-form-edit-review" data-id="<?php echo esc_attr( $comment->comment_ID ); ?>">
									<div class="edit-star-rating-box star-rating-review">
										<div class="rating-box-group">
											<div class="rating-box">
												<label> <?php esc_html_e( 'Rating', 'tf-car-listing' ); ?>
												</label>
												<div id="rating_comfort_service" class="star-rating">
													<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
														<i class="icon-autodeal-star <?php echo esc_attr( $i <= $current_rating_comfort ? 'active' : '' ); ?>"
															data-rating="<?php echo esc_attr( $i ); ?>"></i>
													<?php endfor; ?>
												</div>
											</div>
										</div>
									</div>
									<textarea
										id="tfcl-edit-review-<?php echo esc_attr( $comment->comment_ID ); ?>"><?php echo trim( esc_html( $comment->comment_content ) ); ?></textarea>
									<input type="hidden" class="edit_rating" name="edit_rating" value="5">
									<input type="hidden" id="edit_rating_comfort" name="edit_rating_comfort">
									<input type="hidden" id="edit_rating_performance" name="edit_rating_performance">
									<input type="hidden" id="edit_rating_interior_design" name="edit_rating_interior_design">
									<input type="hidden" id="edit_rating_speed" name="edit_rating_speed">
									<button
										class="button tfcl-btn-update-review"><?php esc_html_e( 'Update', 'tf-car-listing' ); ?></button>
									<?php wp_nonce_field( 'tfcl_update_review_ajax_nonce', 'tfcl_security_update_review' ); ?>
								</form>
								</div>
							<?php
							if ( is_user_logged_in() && $comment->user_id == $current_user_id ) {
								?>
								<a href="javascript:void(0)" class="tfcl-btn-edit-review">
									<i class="fas fa-pen"></i>
									<?php esc_html_e( 'Edit', 'tf-car-listing' ); ?>
								</a>
								<?php
							}
							?>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php if ( count($get_comments) > 3  ):?>
				<div class="view-more-button">
					<?php esc_html_e( 'View more reviews', 'tf-car-listing' ); ?> <i class="icon-autodeal-icon-166"></i>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( tfcl_get_option( 'enable_comment_review_listing', 'hide' ) != 'hide' ) :
			?>
			<div class="tfcl-listing-element">
				<div class="tfcl-listing-header">
					<h3><?php esc_html_e( 'Leave a Reply', 'tf-car-listing' ); ?></h3>
				</div>
				<div class="add-new-review">
					<?php
					if ( ! is_user_logged_in() ) {
						$login_page = esc_url(tfcl_get_permalink( 'login_page' ));
						echo sprintf(wp_kses_post('<h5 class="review-title">You need to <a href="%s"> login </a> in order to post a review.</h5>', 'tf-car-listing'), $login_page);
					} else {
						?>
						<form method="post" id="tfcl_review_form">
							<div class="form-group">
								<label for="review"> <?php esc_html_e( 'Review', 'tf-car-listing' ); ?> </label>
								<label id="review-message-error"></label>
								<textarea id="review" name="review"
									placeholder="<?php esc_attr_e( 'Your Message:', 'tf-car-listing' ); ?>" required></textarea>
							</div>
							<div class="rating-box-group">
								<div class="rating-box">
									<label> <?php esc_html_e( 'Rating', 'tf-car-listing' ); ?> </label>
									<div id="rating_comfort_service" class="star-rating">
										<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
											<i class="icon-autodeal-star" data-rating="<?php echo esc_attr( $i ); ?>"></i>
										<?php endfor; ?>
									</div>
								</div>
							</div>
							<button type="submit"
								class="tfcl-submit-listing-rating button"><?php esc_html_e( 'Post Comment', 'tf-car-listing' ); ?></button>
							<?php wp_nonce_field( 'tfcl_submit_review_single_listing_ajax_nonce', 'tfcl_security_submit_review_single_listing' ); ?>
							<input type="hidden" id="rating_submit" value="" name="rating">
							<input type="hidden" id="rating_comfort_submit" name="rating_comfort">
							<input type="hidden" id="rating_performance_submit" name="rating_performance">
							<input type="hidden" id="rating_interior_design_submit" name="rating_interior_design">
							<input type="hidden" id="rating_speed_submit" name="rating_speed">
							<input type="hidden" name="action" value="tfcl_submit_review_single_listing_ajax">
							<input type="hidden" name="listing_id" value="<?php the_ID(); ?>">
						</form>
						<?php
					}
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>