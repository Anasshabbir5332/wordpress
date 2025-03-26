<?php
/**
 * @var $css_class_field
 * @var $value_make
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$custom_name_make = get_option('custom_name_make');
?>
<div class="form-group form-item listing-select-meta-box-wrap">
			<label><?php esc_html_e( $custom_name_make, 'tf-car-listing' ); ?></label>
	<select name="make" title="<?php esc_attr_e( 'Listing Make', 'tf-car-listing' ) . esc_attr($custom_name_make); ?>"
		class="search-field tfcl-listing-make-ajax" data-default-value="">
		<option value="">
			<?php esc_html_e( $custom_name_make, 'tf-car-listing' ) ?>
		</option>
		<?php tfcl_get_option_advanced_search( $value_make, '', 'make' ); ?>
	</select>
</div>