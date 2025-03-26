<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}
global $current_user;
$current_user_id              = $current_user->ID;
?>

<h1 class="tfre-review-list"><?php esc_html_e( 'All review', 'tf-car-listing' ); ?></h1>

<div class="tfcl-dashboard-middle-right col-md-12">
				<div class="tfcl-card tfcl-dashboard-reviews tfre-review-list-page">
					<?php if ( ! $reviews ) : ?>
						<span><?php esc_html_e( 'Don\'t have any reviews.', 'tf-car-listing' ); ?></span>
					<?php else : ?>
						<ul>
							<?php
							foreach ( $reviews as $review ) :
								$author_picture = get_the_author_meta( 'profile_image', $review->user_id );
								$no_avatar_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
								$width          = 56;
								$height         = 56;
								$default_avatar = tfcl_get_option( 'default_user_avatar', '' );
								if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
									$no_avatar_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
								}
								$user_link = get_author_posts_url( $review->user_id );
								?>
								<li class="comment-by-user">
									<div class="group-author">
										<img loading="lazy" class="avatar" width="<?php echo esc_attr( $width ) ?>"
											height="<?php echo esc_attr( $height ) ?>"
											src="<?php echo esc_url( $author_picture ? $author_picture : '' ) ?>"
											onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';" alt="avatar">
										<?php
										$user_info = get_userdata( $review->user_id );
										?>
										<div class="group-name">
											<div class="review-name">
												<?php echo sprintf( __( '<b>%s</b>', 'tf-car-listing' ), $user_info ? $user_info->user_nicename : '' ) ?>
												<span class="review-date"><?php echo esc_html( tfcl_get_comment_time( $review->comment_ID ) ); ?></span>
											</div>
										</div>
									</div>
									<div class="content">
										<p><?php echo esc_html( $review->comment_content ); ?></p>
									</div>
									<div class="rating-wrap">
												<div class="form-group">
													<div class="star-rating-review">
														<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
															<i class="star disabled-click icon-autodeal-star <?php echo esc_attr( $i <= get_comment_meta( $review->comment_ID, 'listing_comfort_rating', true ) ? 'active' : '' ); ?>"
																data-rating="<?php echo esc_attr( $i ); ?>"></i>
														<?php endfor; ?>
													</div>
												</div>
											</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>