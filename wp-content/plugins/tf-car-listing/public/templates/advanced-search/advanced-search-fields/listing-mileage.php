<?php
/**
 * @var $css_class_field
 * @var $css_class_half_field
 * @var $value_min_mileage
 * @var $value_max_mileage
 * @var $mileage_is_slider
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="form-group form-item">
	<?php
	if ( $mileage_is_slider == 'true' ) {
		$min_mileage        = tfcl_get_option( 'minimum_mileage_slider', 0 );
		$max_mileage        = tfcl_get_option( 'maximum_mileage_slider', 10000 );
		$min_mileage_change = ( $value_min_mileage != '' ) ? $value_min_mileage : $min_mileage;
		$max_mileage_change = ( $value_max_mileage != '' ) ? $value_max_mileage : $max_mileage;
		$measurement_units       = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
		?>
		<div class="tfcl-slider-range-mileage-wrap <?php echo esc_attr( ! empty( $css_class_field ) ? $css_class_field : ' ' ); ?>">
			<div class="tfcl-range-slider-mileage tfcl-range-slider-filter"
				data-min-default="<?php echo esc_attr( $min_mileage ); ?>"
				data-max-default="<?php echo esc_attr( $max_mileage ); ?>"
				data-min="<?php echo esc_attr( $min_mileage_change ); ?>"
				data-max="<?php echo esc_attr( $max_mileage_change ); ?>">
				<label class="filter-ranger"><span class="output output-mileage outputOne"></span> <?php echo $measurement_units; ?> - <span class="output output-mileage outputTwo"></span> <?php echo $measurement_units; ?></label>
				<section class="range-slider">
					<span class="full-range"></span>
					<span class="incl-range"></span>
					<input name="range-mileage-one" class="range-mileage-one" value="<?php echo esc_attr( $min_mileage_change ); ?>"
						min="<?php echo esc_attr( $min_mileage ); ?>" max="<?php echo esc_attr( $max_mileage ); ?>" step="1"
						type="range">
					<input name="range-mileage-two" class="range-mileage-two" value="<?php echo esc_attr( $max_mileage_change ); ?>"
						min="<?php echo esc_attr( $min_mileage ); ?>" max="<?php echo esc_attr( $max_mileage ); ?>" step="1"
						type="range">
					<input type="hidden" name="min-mileage"
						class="min-mileage-input-request min-input-request"
						value="<?php echo esc_attr( $min_mileage_change ); ?>">
					<input type="hidden" name="max-mileage"
						class="max-mileage-input-request max-input-request"
						value="<?php echo esc_attr( $max_mileage_change ); ?>">
				</section>
			</div>
		</div>
		<?php
	} else {
		$listing_mileage_dropdown_min = tfcl_get_option( 'minium_mileage_dropdown', '0,1000,3000,5000,7000,9000,11000,13000,15000,17000,19000' );
		$listing_mileage_dropdown_max = tfcl_get_option( 'maximum_mileage_dropdown', '2000,4000,6000,8000,10000,12000,14000,16000,18000,20000' );
		if ( isset( $settings['style'] ) && $settings['style'] == 'style1' ) : ?>
			<label for="mileage"><?php esc_html_e( get_option('custom_name_mileage') ); ?></label>
		<?php endif; ?>
	<label><?php esc_html_e( get_option('custom_name_mileage') ); ?></label>
		<div class="group-two-input">
			<div class="<?php echo esc_attr( $css_class_half_field ); ?> form-group">
				<select name="min-mileage" title="<?php esc_attr_e( 'Min ', 'tf-car-listing' ) . esc_html(get_option('custom_name_mileage')); ?>"
					class="search-field form-control" data-default-value="">
					<option value="">
						<?php esc_html_e( 'Min ', 'tf-car-listing' ) . esc_html(get_option('custom_name_mileage')); ?>
					</option>
					<?php $listing_mileage_array = explode( ',', $listing_mileage_dropdown_min ); ?>
					<?php if ( is_array( $listing_mileage_array ) && ! empty( $listing_mileage_array ) ) : ?>
						<?php foreach ( $listing_mileage_array as $mileage ) : ?>
							<option <?php selected( $value_min_mileage, $mileage ) ?> value="<?php echo esc_attr( $mileage ) ?>">
								<?php esc_html_e( $mileage, 'tf-car-listing' ); ?>
							</option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<div class="<?php echo esc_attr( $css_class_half_field ); ?> form-group">
				<select name="max-mileage" title="<?php esc_attr_e( 'Max Mileage', 'tf-car-listing' ) ?>"
					class="search-field form-control" data-default-value="">
					<option value="">
						<?php esc_html_e( 'Max ', 'tf-car-listing' ) . esc_html(get_option('custom_name_mileage')) ?>
					</option>
					<?php $listing_mileage_array = explode( ',', $listing_mileage_dropdown_max ); ?>
					<?php if ( is_array( $listing_mileage_array ) && ! empty( $listing_mileage_array ) ) : ?>
						<?php foreach ( $listing_mileage_array as $mileage ) : ?>
							<option <?php selected( $value_max_mileage, $mileage ) ?> value="<?php echo esc_attr( $mileage ) ?>">
								<?php esc_html_e( $mileage, 'tf-car-listing' ); ?>
							</option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
	<?php } ?>
</div>