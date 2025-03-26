<?php
/**
 * @var $css_class_field
 * @var $css_class_half_field
 * @var $value_min_price
 * @var $value_max_price
 * @var $price_is_slider
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="form-group form-item">
	<?php
	if ( $price_is_slider == 'true' ) {
		$min_price = tfcl_get_option( 'minimum_prices_slider', 0 );
		$max_price = tfcl_get_option( 'maximum_prices_slider', 500000 );
        $min_price_change = ( $value_min_price == '' ) ? $min_price : $value_min_price;
		$max_price_change = ( $value_max_price == '' ) ? $max_price : $value_max_price;
		?>
		<div class="tfcl-slider-range-price-wrap">
			<div class="tfcl-range-slider-price tfcl-range-slider-filter"
				data-min-default="<?php echo esc_attr( $min_price ) ?>"
				data-max-default="<?php echo esc_attr( $max_price ); ?>"
				data-min="<?php echo esc_attr( $min_price_change ) ?>"
				data-max="<?php echo esc_attr( $max_price_change ); ?>"
				data-sign-currency="<?php echo esc_attr( tfcl_get_option( 'currency_sign' ) ); ?>">
				<label class="filter-ranger"><?php esc_attr_e( 'Price:', 'tf-car-listing' ) ?> <span class="output outputOne"></span> - <span class="output outputTwo"></span></label>
				<section class="range-slider">
					<span class="full-range"></span>
					<span class="incl-range"></span>
					<input name="rangeOne" class="rangeOne"
						value="<?php echo esc_attr( $min_price_change ); ?>" min="<?php echo esc_attr( $min_price ) ?>"
						max="<?php echo esc_attr( $max_price ) ?>" step="1" type="range">
					<input name="rangeTwo" class="rangeTwo"
						value="<?php echo esc_attr( $max_price_change ) ?>" min="<?php echo esc_attr( $min_price ) ?>"
						max="<?php echo esc_attr( $max_price ) ?>" step="1" type="range">

					<input type="hidden" name="min-price" class="min-input-request"
						value="<?php echo esc_attr( $min_price_change ) ?>">
					<input type="hidden" name="max-price" class="max-input-request"
						value="<?php echo esc_attr( $max_price_change ) ?>">
				</section>
			</div>
		</div>
	<?php } else {
		$listing_price_dropdown_min = tfcl_get_option( 'minimum_prices_dropdown', '0,10000,30000,50000,70000,90000' );
		$listing_price_dropdown_max = tfcl_get_option( 'maximum_prices_dropdown', '20000,40000,60000,80000,100000' );
		?>
	<label><?php esc_html_e( 'Price', 'tf-car-listing' ); ?></label>
		<div class="group-two-input">
			<div class="<?php echo esc_attr( $css_class_half_field ); ?> form-group">
				<select name="min-price" title="<?php esc_attr_e( 'Min Price', 'tf-car-listing' ) ?>"
					class="search-field form-control" data-default-value="">
					<option value="">
						<?php esc_html_e( 'Min Price', 'tf-car-listing' ) ?>
					</option>
					<?php $listing_price_array = explode( ',', $listing_price_dropdown_min ); ?>
					<?php if ( is_array( $listing_price_array ) && ! empty( $listing_price_array ) ) : ?>
						<?php foreach ( $listing_price_array as $price ) : ?>
							<option <?php selected( $value_min_price, $price ) ?> value="<?php echo esc_attr( $price ) ?>">
								<?php echo tfcl_format_price( $price ) ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<div class="<?php echo esc_attr( $css_class_half_field ); ?> form-group">
				<select name="max-price" title="<?php esc_attr_e( 'Max Price', 'tf-car-listing' ) ?>"
					class="search-field form-control" data-default-value="">
					<option value="">
						<?php esc_html_e( 'Max Price', 'tf-car-listing' ) ?>
					</option>
					<?php $listing_price_array = explode( ',', $listing_price_dropdown_max ); ?>
					<?php if ( is_array( $listing_price_array ) && ! empty( $listing_price_array ) ) : ?>
						<?php foreach ( $listing_price_array as $price ) : ?>
							<option <?php selected( $value_max_price, $price ) ?> value="<?php echo esc_attr( $price ) ?>">
								<?php echo tfcl_format_price( $price ) ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
		</div>
	<?php } ?>
</div>