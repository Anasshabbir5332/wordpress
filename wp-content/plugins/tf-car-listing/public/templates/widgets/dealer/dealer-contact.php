<?php
wp_enqueue_style( 'mapbox-gl' );
wp_enqueue_script( 'mapbox-gl' );
wp_enqueue_style( 'mapbox-gl-geocoder' );
wp_enqueue_script( 'mapbox-gl-geocoder' );
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );
wp_reset_postdata();
global $post;
$author_id  = $post->post_author;
$dealer_id  = ! empty( get_post_meta( get_the_ID(), 'listing_dealer_info', true ) ) ? get_post_meta( get_the_ID(), 'listing_dealer_info', true ) : get_the_author_meta( 'author_dealer_id', $author_id );
$dealer_meta   = get_post_meta( $dealer_id );
$poster_id     = get_post_thumbnail_id( $dealer_id );
$poster_src    = tfcl_image_resize_id( $poster_id, 100, 100, true );
$overall_rating = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_rating' )['overall_rate'];
$review_count  = tfcl_count_review_dealer( $dealer_id );
if ( isset( $dealer_id ) && ! empty( $dealer_id ) ) {
	$dealer_post_meta_data = get_post_custom( $dealer_id );
	$full_name             = get_the_title( $dealer_id );
	$email                 = isset( $dealer_post_meta_data['dealer_email'] ) ? $dealer_post_meta_data['dealer_email'][0] : '';
	$position                 = isset( $dealer_post_meta_data['dealer_position'] ) ? $dealer_post_meta_data['dealer_position'][0] : '';
	$phone                 = isset( $dealer_post_meta_data['dealer_phone_number'] ) ? $dealer_post_meta_data['dealer_phone_number'][0] : '';
	$author_id             = get_post_field( 'post_author', $dealer_id );
	$dealer_office_address = isset( $dealer_post_meta_data['dealer_office_address'] ) ? $dealer_post_meta_data['dealer_office_address'][0] : '';
} else {
	$first_name = get_the_author_meta( 'first_name', $author_id );
	$last_name  = get_the_author_meta( 'last_name', $author_id );
	$position      = get_the_author_meta( 'user_position', $author_id );
	$full_name  = $first_name . ' ' . $last_name;
	$email      = get_the_author_meta( 'user_email', $author_id );
	$phone      = get_the_author_meta( 'user_phone', $author_id );
	$dealer_office_address = get_the_author_meta( 'user_location', $author_id );
}
?>
<div class="widget-dealer-contact">
	<div class="inner-widget">
		<div class="dealer-avatar">
			<img loading="lazy" src="<?php echo esc_url( $poster_src ) ?>" alt="<?php esc_attr_e( 'avatar', 'tf-car-listing' ); ?>">
			<div class="dealer-name">
				<h4><?php echo esc_html( $full_name ); ?></h4>
				<p class="position"><?php echo themesflat_svg('verify'); ?> <?php esc_html_e( 'Verified dealer', 'tf-car-listing' ); ?></p>
			</div>
		</div>
		<?php if(!empty($dealer_office_address) ): ?>
		<div class="map-dealer-listing">
			<div class="address-dealer">
				<?php echo themesflat_svg('map'); ?> <?php echo esc_html( $dealer_office_address ); ?>
			</div>
			<input type="hidden" id="dealer-location-info" value="<?php echo esc_attr($dealer_office_address); ?>">
        	<div id="map-dealer" style="width: 100%; height: 190px; border-radius: 16px;margin-bottom: 32px;"></div>   
		</div>
		<?php endif; ?>
		<h6><?php echo esc_html_e( 'Contact dealer', 'tf-car-listing' ); ?></h6>
		<div class="wrap-contact-dealder">
			<?php if(!empty($phone) ): ?>
			<a href="tel:<?php echo esc_attr($phone); ?>" class="dealer-contact-btn phone">
				<i class="icon-autodeal-mobile"></i>
				<?php echo esc_html_e( 'Call to seller', 'tf-car-listing' ); ?>
			</a>
			<?php endif; ?>
			<?php if(!empty($email) ): ?>
			<a href="mailto:<?php echo esc_attr($email); ?>" class="dealer-contact-btn email">
				<i class="icon-autodeal-icon-164"></i>
				<?php echo esc_html_e( 'Chat', 'tf-car-listing' ); ?>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>