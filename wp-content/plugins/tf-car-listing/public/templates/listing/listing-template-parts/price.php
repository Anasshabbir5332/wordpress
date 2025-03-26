<?php
/**
 * @var $listing_data
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$decimal_point              = tfcl_get_option( 'decimal_separator', '.' );
$listing_price_short_format = '^[0-9]+([' . $decimal_point . '][0-9]+)?$';
$regular_price              = $listing_data ? get_post_meta( $listing_data->ID, 'regular_price', true ) : '';
$listing_sale_price         = $listing_data ? get_post_meta( $listing_data->ID, 'sale_price', true ) : '';
$listing_price_prefix       = $listing_data ? get_post_meta( $listing_data->ID, 'price_prefix', true ) : '';
$listing_price_suffix       = $listing_data ? get_post_meta( $listing_data->ID, 'price_suffix', true ) : '';
$listing_price_custom_label = $listing_data ? get_post_meta( $listing_data->ID, 'price_custom_label', true ) : '';
$listing_price_unit_value 	= $listing_data ? get_post_meta( $listing_data->ID, 'listing_price_unit', true ) : '';
$show_hide_listing_fields   = tfcl_get_option( 'show_hide_listing_fields', array() );
?>
<div class="tfcl-field-wrap tfcl-listing-price-sc">
	<div class="tfcl-field-title">
		<h4><?php esc_html_e( 'Car price', 'tf-car-listing' ); ?></h4>
	</div>
	<div class="listing-fields listing-price row">
		<?php if ( $show_hide_listing_fields['regular_price'] == 1 ) : ?>
			<div class="col-xl-6">
				<div class="form-group">
					<label for="listing_price_value">
						<?php echo esc_html_e( 'Regular Price', 'tf-car-listing' ) . tfcl_required_field( 'regular_price', 'required_listing_fields' ); ?>
					</label>
					<input pattern="<?php echo esc_attr( $listing_price_short_format ) ?>" type="number"
						id="listing_price_value" class="form-control" name="regular_price"
						value="<?php echo esc_attr( $regular_price ); ?>"
						placeholder="<?php echo sprintf( esc_html__( 'Example Value: 12345%s05', 'tf-car-listing' ), $decimal_point ) ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['sale_price'] == 1 ) : ?>
			<div class="col-xl-6">
				<div class="form-group">
					<label for="listing_sale_price">
						<?php echo esc_html_e( 'Sale Price', 'tf-car-listing' ) . tfcl_required_field( 'sale_price', 'required_listing_fields' ); ?>
					</label>
					<input pattern="<?php echo esc_attr( $listing_price_short_format ) ?>" type="number"
						id="listing_sale_price" class="form-control" name="sale_price"
						value="<?php echo esc_attr( $listing_sale_price ); ?>"
						placeholder="<?php echo sprintf( esc_html__( 'Example Value: 12345%s05', 'tf-car-listing' ), $decimal_point ) ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['price_custom_label'] == 1 ) : ?>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_price_custom_label"><?php echo esc_html_e( 'Price Custom Label', 'tf-car-listing' ); ?></label>
					<input type="text" id="listing_price_custom_label" class="form-control" name="price_custom_label"
						value="<?php echo esc_attr( $listing_price_custom_label ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ($show_hide_listing_fields['listing_price_unit'] == 1): ?>
			<div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label
                        for="listing_price_unit"><?php echo esc_html_e('Unit price', 'tf-car-listing'); ?></label>
                    <select name="listing_price_unit" id="listing_price_unit" class="form-control">
                        <option <?php tfcl_check_value_is_selected_option($listing_price_unit_value, '1') ?> value="1"><?php esc_html_e('None', 'tf-car-listing'); ?></option>
                        <option <?php tfcl_check_value_is_selected_option($listing_price_unit_value, '1000') ?>
                            value="1000"><?php esc_html_e('Thousand', 'tf-car-listing'); ?></option>
                        <option <?php tfcl_check_value_is_selected_option($listing_price_unit_value, '1000000') ?>
                            value="1000000"><?php esc_html_e('Million', 'tf-car-listing'); ?></option>
                        <option <?php tfcl_check_value_is_selected_option($listing_price_unit_value, '1000000000') ?>
                            value="1000000000"><?php esc_html_e('Billion', 'tf-car-listing'); ?></option>
                    </select>
                </div>
            </div>
        <?php endif; ?>
		<?php if ( $show_hide_listing_fields['price_prefix'] == 1 ) : ?>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_price_prefix"><?php echo esc_html_e( 'Before Price Label', 'tf-car-listing' ); ?></label>
					<input type="text" id="listing_price_prefix" class="form-control" name="price_prefix"
						value="<?php echo esc_attr( $listing_price_prefix ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['price_suffix'] == 1 ) : ?>
			<div class="col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_price_postfix"><?php echo esc_html_e( 'After Price Label', 'tf-car-listing' ); ?></label>
					<input type="text" id="listing_price_postfix" class="form-control" name="price_suffix"
						value="<?php echo esc_attr( $listing_price_suffix ); ?>">
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>