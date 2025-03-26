<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$listing_id                   = get_the_ID();
$listing_title                = get_the_title();
$listing_meta_data            = get_post_custom( $listing_id );
$listing_address              = isset( $listing_meta_data['listing_address'] ) ? $listing_meta_data['listing_address'][0] : '';
$listing_year                 = isset( $listing_meta_data['year'] ) ? $listing_meta_data['year'][0] : '';
$car_regular_price_value = get_post_meta( $listing_id, 'regular_price', true );
$car_sale_price_value    = get_post_meta( $listing_id, 'sale_price', true );
$car_price_prefix        = get_post_meta( $listing_id, 'price_prefix', true );
$car_price_suffix        = get_post_meta( $listing_id, 'price_suffix', true );
$car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );
$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
$measurement_units       = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
$car_mileage                  = get_post_meta( $listing_id, 'mileage', true ) ? get_post_meta( $listing_id, 'mileage', true ) . ' ' . $measurement_units : 0;
$car_fuel_type           = get_the_terms( $listing_id, 'fuel-type', true );
$car_fuel_type_att       = ! empty( $car_fuel_type[0]->name ) ? $car_fuel_type[0]->name : 'none';
$car_transmission        = get_the_terms( $listing_id, 'transmission' );
$car_transmission_att    = ! empty( $car_transmission[0]->name ) ? $car_transmission[0]->name : 'none';
$car_make        = get_the_terms( $listing_id, 'make' );
$car_make_att    = ! empty( $car_make[0]->name ) ? $car_make[0]->name : 'none';
$prop_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
global $show_hide_actions_button;
$show_hide_actions_button = tfcl_get_option( 'show_hide_actions_button', array() );
if ( ! is_array( $show_hide_actions_button ) ) {
	$show_hide_actions_button = array();
}
?>
<div class="single-listing-element listing-info-header listing-info-action">
	<div class="tfcl-listing-floor">
		<div class="row">
			<div class="col-md-12">
				<div class="infor-header-inner">
					<?php if ( ! empty( $listing_title ) ) : ?>
						<h2><?php the_title(); ?></h2>
					<?php endif; ?>
					<ul class="list-information">
						<li class="listing-information mileages">
							<?php echo themesflat_svg('dashboard'); ?>
								<div class="inner">
									<p><?php echo esc_html( $car_mileage ); ?></p>
								</div>
							</li>
						<li class="listing-information fuel">
							<?php echo themesflat_svg('fuel'); ?>
							<div class="inner">
								<p><a href="<?php echo esc_url( get_term_link( $car_fuel_type[0] ) ) ?>"><?php echo esc_html( $car_fuel_type_att, 'tf-car-listing' ); ?></a></p>
							</div>
						</li>
						<li class="listing-information transmission">
							<?php echo themesflat_svg('transmission2'); ?>
							<div class="inner">
								<p><a href="<?php echo esc_url( get_term_link( $car_transmission[0] ) ) ?>"><?php echo esc_html( $car_transmission_att, 'tf-car-listing' ); ?></a></p>
							</div>
						</li>
						<li class="listing-information make">
							<?php echo themesflat_svg('car'); ?>
							<div class="inner">
							<p> <a href="<?php echo esc_url( get_term_link( $car_make[0] ) ) ?>"><?php echo esc_html( $car_make_att, 'tf-car-listing' ); ?></a> </p>
							</div>
						</li>
					</ul>
					<div class="price">
				<?php if ( ! empty( $car_sale_price_value ) ) : ?>
					<span class="inner regular_price">
						<?php if ( $car_price_prefix != '' ) : ?>
							<?php echo $car_price_prefix; ?>
						<?php endif; ?>
						<?php echo tfcl_format_price( $car_sale_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
						<?php if ( $car_price_suffix != '' ) : ?>
							<?php echo $car_price_suffix; ?>
						<?php endif; ?>
					</span>
				<?php endif; ?>
				<?php if ( ! empty( $car_regular_price_value ) ) : ?>
					<span class="inner sale_price">
						<?php if ( $car_price_prefix != '' ) : ?>
							<?php echo $car_price_prefix; ?>
						<?php endif; ?>
						<?php echo tfcl_format_price( $car_regular_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
						<?php if ( $car_price_suffix != '' ) : ?>
							<?php echo $car_price_suffix; ?>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			</div>
					<div class="listing-action">
						<div class="listing-action-inner clearfix">
							<?php
							if ( $show_hide_actions_button["favorite-actions-button"] == 1 ) {
								tfcl_get_template_with_arguments( 'listing/favorite.php' );
							}
							if ( $show_hide_actions_button["compare-actions-button"] == 1 ) {
								tfcl_get_template_with_arguments( 'listing/compare-button.php' );
							}
							if ( $show_hide_actions_button["social-actions-button"] == 1 ) {
								tfcl_get_template_with_arguments( 'listing/share-listing.php' );
							}
							?>
							<?php if ( $show_hide_actions_button["print-actions-button"] == 1 ) :?>
							<a href="#" class="tfcl-listing-print hv-tool" data-toggle="tooltip"
								data-tooltip="<?php esc_attr_e( 'Print', 'tf-car-listing' ); ?>"><i
									class="far fa-print"></i></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>