<?php
/**
 * @var $css_class_field
 * @var $value_engine_size
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$engine_size_placeholder = esc_html__( 'Enter ', 'tf-car-listing' ) . get_option('custom_name_engine_size');
?>
<div class="form-group form-item">
	<label for="search_engine_size"><?php esc_html_e( get_option('custom_name_engine_size') ); ?></label>
	<input type="text" class="form-control search-field" id="search_engine_size" data-default-value=""
		value="<?php echo esc_attr( $value_engine_size ); ?>" name="engine_size"
		placeholder="<?php echo esc_attr( $engine_size_placeholder ) ?>">
</div>