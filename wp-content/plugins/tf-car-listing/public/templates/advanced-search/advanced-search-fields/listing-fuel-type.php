<?php
/**
 * @var $css_class_field
 * @var $value_fuel_type
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$custom_name_fuel_type = get_option('custom_name_fuel_type');
?>
<div class="form-group form-item">
		<label><?php esc_html_e( $custom_name_fuel_type, 'tf-car-listing' ); ?></label>
	<select name="fuel_type" title="<?php esc_attr_e( 'Listing ', 'tf-car-listing' ) . esc_attr($custom_name_fuel_type); ?>"
		class="search-field" data-default-value="">
		<option value="">
			<?php esc_html_e( $custom_name_fuel_type, 'tf-car-listing' ) ?>
		</option>
		<?php tfcl_get_option_advanced_search( $value_fuel_type, '', 'fuel-type' ); ?>
	</select>
</div>