<?php
/**
 * @var $css_class_field
 * @var $value_transmission
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$custom_name_transmission = get_option('custom_name_transmission');
?>
<div class="form-group form-item">
		<label><?php esc_html_e( $custom_name_transmission, 'tf-car-listing' ); ?></label>
	<select name="transmission" title="<?php esc_attr_e( 'Listing ', 'tf-car-listing' ) . esc_attr($custom_name_transmission); ?>" class="search-field" data-default-value="">
		<option value="">
			<?php esc_html_e( $custom_name_transmission, 'tf-car-listing' ) ?>
		</option>
		<?php tfcl_get_option_advanced_search( $value_transmission, '', 'transmission' ); ?>
	</select>
</div>