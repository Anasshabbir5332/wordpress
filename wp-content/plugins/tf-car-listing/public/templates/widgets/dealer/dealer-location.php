<?php
wp_reset_postdata();
wp_enqueue_style( 'mapbox-gl' );
wp_enqueue_script( 'mapbox-gl' );
wp_enqueue_style( 'mapbox-gl-geocoder' );
wp_enqueue_script( 'mapbox-gl-geocoder' );
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );
global $post;
$author_id  = $post->post_author;
$dealer_id  = ! empty( get_post_meta( get_the_ID(), 'listing_dealer_info', true ) ) ? get_post_meta( get_the_ID(), 'listing_dealer_info', true ) : get_the_author_meta( 'author_dealer_id', $author_id );
$dealer_meta   = get_post_meta( $dealer_id );
if ( isset( $dealer_id ) && ! empty( $dealer_id ) ) {
	$dealer_post_meta_data = get_post_custom( $dealer_id );
	$dealer_office_address = isset( $dealer_post_meta_data['dealer_office_address'] ) ? $dealer_post_meta_data['dealer_office_address'][0] : '';
} else {
	$dealer_office_address = get_the_author_meta( 'user_location', $author_id );
}
?>
<div class="widget-dealer-location">
    <div class="widget-inner">
        <h4 class="widget-title"><?php esc_html_e( $instance['widget_title'] , 'tf-car-listing'); ?></h4> 
        <?php if(!empty($dealer_office_address)): ?>        
        <div class="address-dealer">
			<?php echo themesflat_svg('map'); ?> <?php echo esc_html( $dealer_office_address ); ?>
		</div>
            <input type="hidden" id="dealer-location-info" value="<?php echo esc_attr($dealer_office_address); ?>">
            <div id="map-dealer" style="width: 100%; height: 380px; border-radius: 16px;margin-bottom: 29px;"></div>
            <a href="http://maps.google.com/maps?q=<?php echo esc_attr($dealer_office_address); ?>" class="location-link" target="__blank"><?php esc_html_e( 'View map', 'tf-car-listing' ); ?></a>
        <?php else: ?>
            <p><?php esc_html_e( 'There is no address information available for this Dealer!', 'tf-car-listing' ); ?></p>
        <?php endif; ?>
    </div>
</div>