<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $hide_compare_fields;
$custom_name_condition = get_option('custom_name_condition', 'condition');
$custom_name_body = get_option('custom_name_body', 'Body');
$custom_name_make = get_option('custom_name_make', 'Make');
$custom_name_model = get_option('custom_name_model', 'Model');
$custom_name_transmission = get_option('custom_name_transmission', 'transmission');
$custom_name_cylinders = get_option('custom_name_cylinders', 'cylinders');
$custom_name_drive_type = get_option('custom_name_drive_type', 'Drive Type');
$custom_name_fuel_type = get_option('custom_name_fuel_type', 'Fuel Type');
$custom_name_color = get_option('custom_name_color', 'Color');
$custom_name_features_type = get_option('custom_name_features_type', 'Features Type');
$custom_name_features = get_option('custom_name_features', 'Features');
$custom_name_stock_number = get_option('custom_name_stock_number', 'Stock Number');
$custom_name_vin_number = get_option('custom_name_vin_number', 'Vin Number');
$custom_name_city_mpg = get_option('custom_name_city_mpg', 'City Mpg');
$custom_name_highway_mpg = get_option('custom_name_highway_mpg', 'Highway Mpg');
$custom_name_year = get_option('custom_name_year', 'Year');
$custom_name_door = get_option('custom_name_door', 'Door');
$custom_name_seat = get_option('custom_name_seat', 'Seat');
$custom_name_mileage = get_option('custom_name_mileage', 'Mileage');
$custom_name_engine_size = get_option('custom_name_engine_size', 'Engine Size');
$hide_compare_fields = tfcl_get_option( 'show_hide_compare_fields', array() );
if ( ! is_array( $hide_compare_fields ) ) {
	$hide_compare_fields = array();
}
TFCL_Compare::tfcl_open_session();
$listing_ids = ! empty( $_SESSION['tfcl_compare_listings'] ) ? $_SESSION['tfcl_compare_listings'] : '';

if ( ! empty( $listing_ids ) ) {
	$listing_ids = array_diff( $listing_ids, [ "0" ] );
	$args        = array(
		'post_type'      => 'listing',
		'post__in'       => $listing_ids,
		'post_status'    => 'publish',
		'orderby'        => 'post__in',
		'posts_per_page' => sizeof( $listing_ids )
	);
	$data        = new WP_Query( $args );

	$listing_demo = $body = $mileage = $fuel_type = $year = $transmission = $engine = $drive = $condition = $car_color = $door = $cylinders = $seat = $make = $model = $price = $stock_number = $vin_number = $city_mpg = $highway_mpg = $address = '';

	$empty_field = '<td class="check-no">n/a</td>';
	if ( $data->have_posts() ) :
		while ( $data->have_posts() ) :
			$data->the_post();
			$listing_id        = get_the_ID();
			$listing_meta_data = get_post_custom( $listing_id );
			$listing_body      = get_the_terms( $listing_id, 'body' );
			$listing_body_arr  = array();

			if ( $listing_body && ! is_wp_error( $listing_body ) ) {
				foreach ( $listing_body as $label ) {
					$listing_body_arr[] = $label->name;
				}
			}

			$listing_fuel_type     = get_the_terms( $listing_id, 'fuel-type' );
			$listing_fuel_type_arr = array();
			if ( $listing_fuel_type && ! is_wp_error( $listing_fuel_type ) ) {
				foreach ( $listing_fuel_type as $label ) {
					$listing_fuel_type_arr[] = $label->name;
				}
			}

			$listing_transmission     = get_the_terms( $listing_id, 'transmission' );
			$listing_transmission_arr = array();
			if ( $listing_transmission && ! is_wp_error( $listing_transmission ) ) {
				foreach ( $listing_transmission as $label ) {
					$listing_transmission_arr[] = $label->name;
				}
			}

			$listing_drive_type     = get_the_terms( $listing_id, 'drive-type' );
			$listing_drive_type_arr = array();
			if ( $listing_drive_type && ! is_wp_error( $listing_drive_type ) ) {
				foreach ( $listing_drive_type as $label ) {
					$listing_drive_type_arr[] = $label->name;
				}
			}

			$listing_condition     = get_the_terms( $listing_id, 'condition' );
			$listing_condition_arr = array();
			if ( $listing_condition && ! is_wp_error( $listing_condition ) ) {
				foreach ( $listing_condition as $label ) {
					$listing_condition_arr[] = $label->name;
				}
			}

			$listing_car_color     = get_the_terms( $listing_id, 'car-color' );
			$listing_car_color_arr = array();
			if ( $listing_car_color && ! is_wp_error( $listing_car_color ) ) {
				foreach ( $listing_car_color as $label ) {
					$listing_car_color_arr[] = $label->name;
				}
			}

			$listing_cylinders     = get_the_terms( $listing_id, 'cylinders' );
			$listing_cylinders_arr = array();
			if ( $listing_cylinders && ! is_wp_error( $listing_cylinders ) ) {
				foreach ( $listing_cylinders as $label ) {
					$listing_cylinders_arr[] = $label->name;
				}
			}

			$listing_make     = get_the_terms( $listing_id, 'make' );
			$listing_make_arr = array();
			if ( $listing_make && ! is_wp_error( $listing_make ) ) {
				foreach ( $listing_make as $label ) {
					$listing_make_arr[] = $label->name;
				}
			}

			$listing_model     = get_the_terms( $listing_id, 'model' );
			$listing_model_arr = array();
			if ( $listing_model && ! is_wp_error( $listing_model ) ) {
				foreach ( $listing_model as $label ) {
					$listing_model_arr[] = $label->name;
				}
			}

			$listing_mileage     = isset( $listing_meta_data['mileage'] ) ? $listing_meta_data['mileage'][0] : '';
			$listing_year        = isset( $listing_meta_data['year'] ) ? $listing_meta_data['year'][0] : '';
			$listing_engine_size = isset( $listing_meta_data['engine_size'] ) ? $listing_meta_data['engine_size'][0] : '';
			$listing_door        = isset( $listing_meta_data['door'] ) ? $listing_meta_data['door'][0] : '';
			$listing_seat        = isset( $listing_meta_data['seat'] ) ? $listing_meta_data['seat'][0] : '';
			$listing_stock_number       = isset( $listing_meta_data['stock_number'] ) ? $listing_meta_data['stock_number'][0] : '';
			$listing_vin_number       = isset( $listing_meta_data['vin_number'] ) ? $listing_meta_data['vin_number'][0] : '';
			$listing_city_mpg       = isset( $listing_meta_data['city_mpg'] ) ? $listing_meta_data['city_mpg'][0] : '';
			$listing_highway_mpg       = isset( $listing_meta_data['highway_mpg'] ) ? $listing_meta_data['highway_mpg'][0] : '';
			$listing_listing_address       = isset( $listing_meta_data['listing_address'] ) ? $listing_meta_data['listing_address'][0] : '';
			$car_price_prefix            = isset( $listing_meta_data['price_prefix'] ) ? $listing_meta_data['price_prefix'][0] : '';
			$car_price_suffix            = isset( $listing_meta_data['price_suffix'] ) ? $listing_meta_data['price_suffix'][0] : '';
			$listing_regular_price       = isset( $listing_meta_data['regular_price'] ) ? $listing_meta_data['regular_price'][0] : '';
			$listing_sale_price       = isset( $listing_meta_data['sale_price'] ) ? $listing_meta_data['sale_price'][0] : '';
			$listing_regular_price_attr       = !empty($listing_regular_price) ? tfcl_format_price($listing_regular_price) : 'empty-regular-price';
			$listing_sale_price_attr       = !empty($listing_sale_price) ? tfcl_format_price($listing_sale_price) : 'empty-sale-price';
			$listing_address       = isset( $listing_meta_data['listing_address'] ) ? $listing_meta_data['listing_address'][0] : '';
			$measurement_units       = tfcl_get_option('measurement_units') == 'custom' ? tfcl_get_option('custom_measurement_units') : tfcl_get_option('measurement_units');

			$group_price = sprintf('<div class="group-price %1$s %2$s"><span class="inner sale-price">%3$s %2$s %4$s</span><span class="inner regular-price">%3$s %1$s %4$s</span></div>', $listing_regular_price_attr, $listing_sale_price_attr, $car_price_prefix, $car_price_suffix);

			$width           = tfcl_get_option( 'image_width_listing', 660 );
			$height          = tfcl_get_option( 'image_height_listing', 471 );
			$default_image = '';
			$attach_id     = get_post_thumbnail_id();
			$no_image_src  = tfcl_get_option( 'default_listing_image', '' )['url'] != '' ? tfcl_get_option( 'default_listing_image', '' )['url'] : TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
			$image_src     = tfcl_image_resize_id( $attach_id, $width, $height, true );
			$listing_link  = get_the_permalink();

			if ($hide_compare_fields["listing-make"] == 1) {
				if (! empty( $listing_make ) ) {
					$make .= '<td>' . esc_html( join( ', ', $listing_make_arr ) ) . '</td>';
				} else {
					$make .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-model"] == 1) {
				if ( ! empty( $listing_model ) ) {
					$model .= '<td>' . esc_html( join( ', ', $listing_model_arr ) ) . '</td>';
				} else {
					$model .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-body"] == 1) {
				if ( ! empty( $listing_body ) ) {
					$body .= '<td>' . esc_html( join( ', ', $listing_body_arr ) ) . '</td>';
				} else {
					$body .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-price"] == 1 ) {
				if ( ! empty( $listing_regular_price ) || ! empty( $listing_sale_price ) ) {
					$price .= '<td class="compare-price">'. wp_kses_post( $group_price ) . '</td>';
				} else {
					$price .= $empty_field;
				}
			}

			if (  $hide_compare_fields["listing-condition"] == 1 ) {
				if ( ! empty( $listing_condition ) ) {
					$condition .= '<td>' . esc_html( join( ', ', $listing_condition_arr ) ) . '</td>';
				} else {
					$condition .= $empty_field;
				}
			}

			if (  $hide_compare_fields["listing-stock-number"] == 1) {
				if ( ! empty( $listing_stock_number ) ) {
					$stock_number .= '<td>' . esc_html( $listing_stock_number) . '</td>';
				} else {
					$stock_number .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-vin-number"] == 1) {
				if ( ! empty( $listing_vin_number ) ) {
					$vin_number .= '<td>' . esc_html( $listing_vin_number ) . '</td>';
				} else {
					$vin_number .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-year"] == 1) {
				if ( ! empty( $listing_year ) ) {
					$year .= '<td>' . esc_html( $listing_year ) . '</td>';
				} else {
					$year .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-mileage"] == 1) {
				if ( ! empty( $listing_mileage ) ) {
					$mileage .= '<td>' . esc_html($listing_mileage) . ' ' . esc_html($measurement_units) . '</td>';
				} else {
					$mileage .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-transmission"] == 1) {
				if (  ! empty( $listing_transmission ) ) {
					$transmission .= '<td>' . esc_html( join( ', ', $listing_transmission_arr ) ) . '</td>';
				} else {
					$transmission .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-drive-type"] == 1) {
				if (  ! empty( $listing_drive_type ) ) {
					$drive .= '<td>' . esc_html( join( ', ', $listing_drive_type_arr ) ) . '</td>';
				} else {
					$drive .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-engine-size"] == 1) {
				if (! empty( $listing_engine_size ) ) {
					$engine .= '<td>' . esc_html( $listing_engine_size ) . '</td>';
				} else {
					$engine .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-cylinders"] == 1) {
				if ( ! empty( $listing_cylinders ) ) {
					$cylinders .= '<td>' . esc_html( join( ', ', $listing_cylinders_arr ) ) . '</td>';
				} else {
					$cylinders .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-fuel-type"] == 1) {
				if ( ! empty( $listing_fuel_type ) ) {
					$fuel_type .= '<td>' . esc_html( join( ', ', $listing_fuel_type_arr ) ) . '</td>';
				} else {
					$fuel_type .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-door"] == 1) {
				if ( ! empty( $listing_door ) ) {
					$door .= '<td>' . esc_html( $listing_door ) . '</td>';
				} else {
					$door .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-color"] == 1 ) {
				if ( ! empty( $listing_car_color ) ) {
					$car_color .= '<td>' . esc_html( join( ', ', $listing_car_color_arr ) ) . '</td>';
				} else {
					$car_color .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-seats"] == 1 ) {
				if ( ! empty( $listing_seat ) ) {
					$seat .= '<td>' . esc_html( $listing_seat ) . '</td>';
				} else {
					$seat .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-city-mpg"] == 1  ) {
				if (  ! empty( $listing_city_mpg ) ) {
					$city_mpg .= '<td>' . esc_html( $listing_city_mpg ) . '</td>';
				} else {
					$city_mpg .= $empty_field;
				}
			}

			if ( $hide_compare_fields["listing-highway-mpg"] == 1  ) {
				if (  ! empty( $listing_highway_mpg ) ) {
					$highway_mpg .= '<td>' . esc_html( $listing_highway_mpg ) . '</td>';
				} else {
					$highway_mpg .= $empty_field;
				}
			}

			if ($hide_compare_fields["listing-location"] == 1 ) {
				if (  ! empty( $listing_address ) ) {
					$address .= '<td>' . esc_html( $listing_address ) . '</td>';
				} else {
					$address .= $empty_field;
				}
			}

		endwhile;
	endif;
	?>
	<div class="content-table-compare">
		<div class="inner">
			<div class="wrap-compare-listing-item">
				<?php if ( $data->have_posts() ) :
					while ( $data->have_posts() ) :
						$data->the_post();
						$listing_id = get_the_ID();
						$attach_id  = get_post_thumbnail_id();
						tfcl_get_template_with_arguments(
							'listing/card-item-listing.php',
							array(
								'listing_id'    => $listing_id,
								'attach_id'     => $attach_id,
								'css_class_col' => ''
							)
						);
						?>
					<?php endwhile;
					wp_reset_postdata();
				else : ?>
					<div class="item-not-found"><?php esc_html_e( 'No item compare', 'tf-car-listing' ); ?></div>
				<?php endif; ?>
			</div>
	
			<div class="tfcl-compare-table table-overview">
				<h2><?php esc_html_e( 'Car Overview', 'tf-car-listing' ); ?></h2>
				<table class="compare-tables table-striped ">
					<tbody>
						
						<?php if ( ! empty( $make ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_make, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $make ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $model ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_model, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $model ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $body ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_body, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $body ); ?>
	
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $condition ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_condition, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $condition ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $price ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( 'Money', 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $price ); ?>
	
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $fuel_type ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_fuel_type, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $fuel_type ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $mileage ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e($custom_name_fuel_type ); ?></td>
							</tr>
							<tr>
								<?php echo ( $mileage ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $year ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( 'Registration ', 'tf-car-listing' ) . esc_html($custom_name_year); ?></td>
							</tr>
							<tr>
								<?php echo ( $year ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $transmission ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_transmission, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $transmission ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $seat ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_seat ); ?></td>
							</tr>
							<tr>
								<?php echo ( $seat ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $engine ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_engine_size ); ?></td>
							</tr>
							<tr>
								<?php echo ( $engine ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $stock_number ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_stock_number ); ?></td>
							</tr>
							<tr>
								<?php echo ( $stock_number ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $vin_number ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_vin_number ); ?></td>
							</tr>
							<tr>
								<?php echo ( $vin_number ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $drive ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_drive_type, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $drive ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $cylinders ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_cylinders, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $cylinders ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $door ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_door ); ?></td>
							</tr>
							<tr>
								<?php echo ( $door ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $car_color ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_color, 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $car_color ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $city_mpg ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e($custom_name_city_mpg ); ?></td>
							</tr>
							<tr>
								<?php echo ( $city_mpg ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $highway_mpg ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( $custom_name_highway_mpg ); ?></td>
							</tr>
							<tr>
								<?php echo ( $highway_mpg ); ?>
							</tr>
						<?php } ?>
	
						<?php if ( ! empty( $address ) ) { ?>
							<tr class="desc-tr">
								<td colspan="3" class="title-desc"><?php esc_html_e( 'Car location', 'tf-car-listing' ); ?></td>
							</tr>
							<tr>
								<?php echo ( $address ); ?>
							</tr>
						<?php } ?>
	
						<?php
						$all_listing_feature = tfcl_get_categories( 'features' );
	
						$compare_terms = array();
						foreach ( $listing_ids as $post_id ) {
							$compare_terms[ $post_id ] = wp_get_post_terms( $post_id, 'features', array( 'fields' => 'ids' ) );
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	wp_reset_postdata();
} else { ?>
	<div class="item-not-found"><?php esc_html_e( 'No item compare', 'tf-car-listing' ); ?></div>
<?php } ?>
