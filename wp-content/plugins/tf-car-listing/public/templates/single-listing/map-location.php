<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$listing_id        = get_the_ID();
$listing_meta_data = get_post_custom( $listing_id );
$listing_location  = get_post_meta( $listing_id, 'listing_location', true );
$listing_address   = isset( $listing_meta_data['listing_address'] ) ? $listing_meta_data['listing_address'][0] : '';
$listing_zip       = isset( $listing_meta_data['listing_zip'] ) ? $listing_meta_data['listing_zip'][0] : '';
$show_map_address  = is_array( tfcl_get_option( 'single_listing_panels_manager' ) ) ? tfcl_get_option( 'single_listing_panels_manager' )['map-location'] : false;
?>
<?php if ( $show_map_address == true ) : ?>
	<div id="map-location" class="single-listing-element listing-location">
		<div class="tfcl-listing-location">
			<div class="tfcl-listing-header">
				<h4><?php esc_html_e( 'Location', 'tf-car-listing' ); ?></h4>
			</div>
			<div class="tfcl-listing-info">
				<div class="row">
					<?php if ( ! empty( $listing_address ) ) : ?>
						<div class="col-md-12">
							<div class="listing-address">
								<?php echo themesflat_svg('map'); ?> <?php echo esc_html( $listing_address ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="map-container">
					<input data-field-control="" class="latlng_searching tfcl-map-latlng-field" type="hidden"
						name="listing_location[]"
						value="<?php echo esc_attr( is_array( $listing_location ) ? $listing_location[0] : '' ); ?>" />
					<div class="tfcl-map-address-field">
						<div class="tfcl-map-address-field-input">
							<input data-field-control="" class="address_searching" type="hidden" name="listing_location[]"
								value="<?php echo esc_attr( is_array( $listing_location ) ? $listing_location[1] : '' ); ?>" />
						</div>
					</div>
					<div id="map-single" class="map"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>