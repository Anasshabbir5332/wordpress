<?php
/**
 * @var $css_class_field
 * @var $css_class_half_field
 * @var $value_min_door
 * @var $value_max_door
 * @var $door_is_slider
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="form-group form-item">
	<?php
		$doors      = tfcl_get_option( 'door_dropdown', '2,4,6,8' );
		$doors      = explode( ',', $doors );
		$value_door = isset( $value_door ) ? $value_door : '';
		?>
        <label class="label-door"><?php esc_html_e(get_option('custom_name_door')); ?></label>
		<select name="door" title="<?php esc_attr_e( 'Listing ', 'tf-car-listing' ) . esc_html(get_option('custom_name_dor')) ?>" class="search-field"
			data-default-value="">
			<option value="">
				<?php esc_html_e( get_option('custom_name_door') ) ?>
			</option>
			<?php if ( is_array( $doors ) && ! empty( $doors ) ) {
				foreach ( $doors as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( selected( $value, $value_door ) ); ?>>
						<?php esc_html_e( $value, 'tf-car-listing' ); ?>
					</option>
				<?php }
			} ?>
		</select>
</div>