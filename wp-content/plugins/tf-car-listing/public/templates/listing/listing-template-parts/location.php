<?php
/**
 * @var $listing_data
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$listing_full_address_value = $listing_data ? get_post_meta( $listing_data->ID, 'listing_address', true ) : '';
$listing_location_value     = $listing_data ? get_post_meta( $listing_data->ID, 'listing_location', true ) : '';
$show_hide_listing_fields   = tfcl_get_option( 'show_hide_listing_fields', array() );
?>
<?php if ( $show_hide_listing_fields['listing_address'] == 1 && $show_hide_listing_fields['listing_location'] == 1 ) : ?>
	<div class="tfcl-field-wrap tfcl-listing-location">
		<div class="tfcl-field-title">
			<h4><?php esc_html_e( 'Location', 'tf-car-listing' ); ?></h4>
		</div>
		<div class="listing-fields listing-location row">
			<?php if ( $show_hide_listing_fields['listing_address'] == 1 ) : ?>
				<div class="col-lg-6 address-form">
					<div class="form-group">
						<label for="full_address"><?php echo esc_html__( 'Full Address', 'tf-car-listing' ); ?></label>
						<input type="text" class="form-control" name="listing_address" id="full_address"
							value="<?php echo esc_attr( $listing_full_address_value ); ?>"
							placeholder="<?php esc_attr_e( 'Enter listing full address', 'tf-car-listing' ); ?>">
					</div>
				</div>
			<?php endif; ?>
			<?php if ( $show_hide_listing_fields['listing_location'] == 1 ) : ?>
				<div class="col-lg-6">
					<div class="map-container">
						<input data-field-control="" class="latlng_searching tfcl-map-latlng-field" type="hidden"
							name="listing_location[]"
							value="<?php echo esc_attr( is_array( $listing_location_value ) ? $listing_location_value[0] : '' ); ?>" />
						<div class="tfcl-map-address-field">
							<div class="tfcl-map-address-field-input">
								<label
									for="address_searching"><?php echo esc_html__( 'Map Location', 'tf-car-listing' ); ?></label>
								<div class="group-map-address-field">
									<input data-field-control="" class="address_searching" id="address_searching" type="text"
										name="listing_location[]"
										value="<?php echo esc_attr( is_array( $listing_location_value ) ? $listing_location_value[1] : '' ); ?>" />
									<button type="button" class="button-location">
										<i class="icon-autodeal-map"></i>
									</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<div class="col-md-12">
					<div class="map" id="map-add-listing" style="height: 520px; border-radius: 16px;">
							</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>