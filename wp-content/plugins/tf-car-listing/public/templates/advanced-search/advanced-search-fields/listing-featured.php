<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="form-group form-item features d-flex align-items-center">
	<div class="checkbox">
		<label><input type="checkbox" name="featured" <?php echo esc_attr( ( ! empty( $value_featured ) && $value_featured == 'true' ) ? 'checked' : '' ); ?> value="" /><?php esc_html_e( 'Featured', 'tf-car-listing' ); ?></label>
	</div>
</div>