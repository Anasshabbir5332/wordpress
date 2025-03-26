<?php
/**
 * @var $css_class_field
 * @var $css_class_half_field
 * @var $value_min_year
 * @var $value_max_year
 * @var $year_is_slider
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="form-group form-item">
	<?php
	if ( $year_is_slider == 'true' ) {
		$min_year        = tfcl_get_option( 'minimum_years_slider', 1970 );
		$max_year        = tfcl_get_option( 'maximum_years_slider', date( "Y" ) );
		$min_year_change = ( $value_min_year == '' ) ? $min_year : $value_min_year;
		$max_year_change = ( $value_max_year == '' ) ? $max_year : $value_max_year;
		?>
		<div class="tfcl-slider-range-year-wrap <?php echo esc_attr( isset( $css_class_field ) ? $css_class_field : '' ); ?>">
			<div class="tfcl-range-slider-year tfcl-range-slider-filter"
				data-min-default="<?php echo esc_attr( $min_year ) ?>"
				data-max-default="<?php echo esc_attr( $max_year ); ?>"
				data-min="<?php echo esc_attr( $min_year_change ) ?>"
				data-max="<?php echo esc_attr( $max_year_change ); ?>">
				<label class="filter-ranger"><?php esc_attr_e( get_option('custom_name_year') . ':' ) ?> <span class="output output-year outputOne"></span> - <span class="output output-year outputTwo"></span></label>
				<section class="range-slider">
					<span class="full-range"></span>
					<span class="incl-range"></span>
					<input name="range-year-one" class="range-year-one" value="<?php echo esc_attr( $min_year_change ); ?>"
						min="<?php echo esc_attr( $min_year ) ?>" max="<?php echo esc_attr( $max_year ) ?>" step="1"
						type="range">
					<input name="range-year-two" class="range-year-two" value="<?php echo esc_attr( $max_year_change ) ?>"
						min="<?php echo esc_attr( $min_year ) ?>" max="<?php echo esc_attr( $max_year ) ?>" step="1"
						type="range">
					<input type="hidden" name="min-year"
						class="min-year-input-request min-input-request" value="<?php echo esc_attr( $min_year_change ) ?>">
					<input type="hidden" name="max-year"
						class="max-year-input-request max-input-request" value="<?php echo esc_attr( $max_year_change ) ?>">
				</section>
			</div>
		</div>
		<?php
	} else {
		$listing_year_dropdown_min = tfcl_get_option( 'minimum_years_dropdown', '1970' );
		$listing_year_dropdown_max = tfcl_get_option( 'maximum_years_dropdown', date( "Y" ) );
		?>
		<label><?php esc_html_e( get_option('custom_name_year') ); ?></label>
		<div class="group-two-input">
			<div class="<?php echo esc_attr( $css_class_half_field ); ?> form-group">
				<select name="min-year" title="<?php esc_attr_e( 'Min ', 'tf-car-listing' ) . get_option('custom_name_year') ?>"
					class="search-field form-control" data-default-value="">
					<option value="">
						<?php esc_html_e( 'Min ', 'tf-car-listing' ) . get_option('custom_name_year'); ?>
					</option>
					<?php $listing_year_array = explode( ',', $listing_year_dropdown_min ); ?>
					<?php if ( is_array( $listing_year_array ) && ! empty( $listing_year_array ) ) : ?>
						<?php foreach ( $listing_year_array as $year ) : ?>
							<option <?php selected( $value_min_year, $year ) ?> value="<?php echo esc_attr( $year ) ?>">
								<?php echo esc_html( $year ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<div class="<?php echo esc_attr( $css_class_half_field ); ?> form-group">
				<select name="max-year" title="<?php esc_attr_e( 'Max ', 'tf-car-listing' ) . get_option('custom_name_year') ?>"
					class="search-field form-control" data-default-value="">
					<option value="">
						<?php esc_html_e( 'Max ', 'tf-car-listing' ) . get_option('custom_name_year') ?>
					</option>
					<?php $listing_year_array = explode( ',', $listing_year_dropdown_max ); ?>
					<?php if ( is_array( $listing_year_array ) && ! empty( $listing_year_array ) ) : ?>
						<?php foreach ( $listing_year_array as $year ) : ?>
							<option <?php selected( $value_max_year, $year ) ?> value="<?php echo esc_attr( $year ) ?>">
								<?php echo esc_html( $year ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
	<?php } ?>
</div>