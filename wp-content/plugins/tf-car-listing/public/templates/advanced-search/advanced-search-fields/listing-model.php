<?php
/**
 * @var $css_class_field
 * @var $value_model
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( isset( $_GET['make'] ) ) {
	$valueMake = wp_unslash( $_GET['make'] );
}
$custom_name_model = get_option('custom_name_model');
?>
<div class="form-group form-item listing-select-meta-box-wrap">
		<label><?php esc_html_e( $custom_name_model, 'tf-car-listing' ); ?></label>
	<select name="model" title="<?php esc_attr_e( 'Listing ', 'tf-car-listing' ) . esc_attr($custom_name_model); ?>"
		class="search-field tfcl-listing-models-ajax" data-default-value="">
		<option value="">
			<?php esc_html_e( get_option('custom_name_model') ) ?>
		</option>
		<?php
		if ( ! empty( $valueMake ) ) {
			tfcl_get_option_advanced_search( $value_model, '', 'model', 'make', $valueMake );
		} else {
			tfcl_get_option_advanced_search( $value_model, '', 'model', null, null );
		}
		?>
	</select>
</div>