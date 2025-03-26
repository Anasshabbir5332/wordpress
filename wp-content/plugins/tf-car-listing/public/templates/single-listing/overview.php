<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
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
$listing_id                = get_the_ID();
$listing_meta_data         = get_post_custom( $listing_id );
$listing_year              = isset( $listing_meta_data['year'] ) ? $listing_meta_data['year'][0] : '';
$listing_stock_number      = isset( $listing_meta_data['stock_number'] ) ? $listing_meta_data['stock_number'][0] : '0';
$listing_vin_number        = isset( $listing_meta_data['vin_number'] ) ? $listing_meta_data['vin_number'][0] : '0';
$listing_mileage           = isset( $listing_meta_data['mileage'] ) ? $listing_meta_data['mileage'][0] : '0';
$listing_measurement_units = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
$listing_engine_size       = isset( $listing_meta_data['engine_size'] ) ? $listing_meta_data['engine_size'][0] : '0';
$listing_door              = isset( $listing_meta_data['door'] ) ? $listing_meta_data['door'][0] : '0';
$listing_seat              = isset( $listing_meta_data['seat'] ) ? $listing_meta_data['seat'][0] : '0';
$listing_city_mpg          = isset( $listing_meta_data['city_mpg'] ) ? $listing_meta_data['city_mpg'][0] : '0';
$listing_highway_mpg       = isset( $listing_meta_data['highway_mpg'] ) ? $listing_meta_data['highway_mpg'][0] : '0';

$listing_conditions     = get_the_terms( $listing_id, 'condition' );
$listing_condition_text = array();
if ( ! empty( $listing_conditions ) ) {
	foreach ( $listing_conditions as $listing_condition ) {
		array_push( $listing_condition_text, $listing_condition->name );
	}
}
$listing_condition_text = implode( ",", $listing_condition_text );

$listing_transmissions      = get_the_terms( $listing_id, 'transmission' );
$listing_transmissions_text = array();
if ( ! empty( $listing_transmissions ) ) {
	foreach ( $listing_transmissions as $listing_transmission ) {
		array_push( $listing_transmissions_text, $listing_transmission->name );
	}
}
$listing_transmissions_text = implode( ",", $listing_transmissions_text );

$listing_drive_types     = get_the_terms( $listing_id, 'drive-type' );
$listing_drive_type_text = array();
if ( ! empty( $listing_drive_types ) ) {
	foreach ( $listing_drive_types as $listing_drive_type ) {
		array_push( $listing_drive_type_text, $listing_drive_type->name );
	}
}
$listing_drive_type_text = implode( ",", $listing_drive_type_text );

$listing_cylinders      = get_the_terms( $listing_id, 'cylinders' );
$listing_cylinders_text = array();
if ( ! empty( $listing_cylinders ) ) {
	foreach ( $listing_cylinders as $listing_cylinder ) {
		array_push( $listing_cylinders_text, $listing_cylinder->name );
	}
}
$listing_cylinders_text = implode( ",", $listing_cylinders_text );

$listing_fuel_types     = get_the_terms( $listing_id, 'fuel-type' );
$listing_fuel_type_text = array();
if ( ! empty( $listing_fuel_types ) ) {
	foreach ( $listing_fuel_types as $listing_fuel_type ) {
		array_push( $listing_fuel_type_text, $listing_fuel_type->name );
	}
}
$listing_fuel_type_text = implode( ",", $listing_fuel_type_text );

$listing_car_colors     = get_the_terms( $listing_id, 'car-color' );
$listing_car_color_text = array();
if ( ! empty( $listing_car_colors ) ) {
	foreach ( $listing_car_colors as $listing_car_color ) {
		array_push( $listing_car_color_text, $listing_car_color->name );
	}
}
$listing_car_color_text = implode( ",", $listing_car_color_text );

$listing_additional_detail = isset( $listing_meta_data['listing_additional_detail'] ) ? $listing_meta_data['listing_additional_detail'][0] : '';
$listing_additional_detail = unserialize( $listing_additional_detail );

$show_overview = is_array( tfcl_get_option( 'single_listing_panels_manager' ) ) ? tfcl_get_option( 'single_listing_panels_manager' )['overview'] : false;
?>
<?php if ( $show_overview == true ) : ?>
	<div id="overview" class="single-listing-element listing-info-overview">
		<div class="tfcl-listing-overview">
			<div class="tfcl-listing-header">
				<h4><?php echo esc_html__( 'Car overview', 'tf-car-listing' ); ?></h4>
			</div>
			<div class="tfcl-listing-info">
				<div class="row">
					<?php if ( ! empty( $listing_conditions ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('car'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title">
										<?php
										echo esc_html__( $custom_name_condition . ':', 'tf-car-listing' );
										?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_condition_text ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_cylinders ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('cylinder'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_cylinders . ': ', 'tf-car-listing' );
									?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_cylinders_text ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_stock_number ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('checklist'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title">
										<?php
										echo esc_html__( $custom_name_stock_number . ':' );
										?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_stock_number ) ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_fuel_types ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('fuel'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_fuel_type . ':', 'tf-car-listing' );
									?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_fuel_type_text ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_vin_number ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('number'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title">
										<?php
										echo esc_html__( $custom_name_vin_number . ':' );
										?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_vin_number ) ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_door ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('door'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo ( tfcl_get_number_text( $listing_door, esc_html__( $custom_name_door . 's' ), esc_html__( $custom_name_door ) ));
									?></span>
									<p class="listing-info-value">
										<?php echo esc_html__( tfcl_get_format_number( intval( $listing_door ) ) ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_year ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('year'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title">
										<?php
										echo esc_html__( $custom_name_year . ':' );
										?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_year ); ?>
									</p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_car_colors ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('color'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_color . ':', 'tf-car-listing' );
									?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_car_color_text ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_seat ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('seat'); ?>
								</div>
								<div class="content-listing-info">
								<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_seat . ':' );
									?></span>
									<p class="listing-info-value">
										<?php echo esc_html__( tfcl_get_format_number( intval( $listing_seat ) ) ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_transmissions ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('transmission2'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_transmission . ':', 'tf-car-listing' );
									?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_transmissions_text ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_city_mpg ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('city'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_city_mpg . ':' );
									?></span>
									<p class="listing-info-value">
										<?php echo esc_html__( tfcl_get_format_number( intval( $listing_city_mpg ) ) ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_engine_size ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('engine'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_engine_size . ':' );
									?></span>
									<p class="listing-info-value">
										<?php echo esc_html__( $listing_engine_size ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_highway_mpg ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('performance'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_highway_mpg . ':' );
									?></span>
									<p class="listing-info-value">
										<?php echo esc_html__( tfcl_get_format_number( intval( $listing_highway_mpg ) ) ); ?>
									</p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $listing_drive_types ) ) : ?>
						<div class="col-xl-6 col-md-6 item">
							<div class="inner listing-infor-box">
								<div class="icon">
									<?php echo themesflat_svg('drive'); ?>
								</div>
								<div class="content-listing-info">
									<span class="listing-info-title"><?php
									echo esc_html__( $custom_name_drive_type . ':', 'tf-car-listing' );
									?></span>
									<p class="listing-info-value"><?php echo esc_html__( $listing_drive_type_text ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php $get_additional_fields = tfcl_get_additional_fields();
					if ( is_array( $get_additional_fields ) && count( $get_additional_fields ) > 0 ) {
						foreach ( $get_additional_fields as $key => $field ) {
							$listing_field_value = get_post_meta( $listing_id, $key, true );
							if ( $field['type'] == 'checkbox' ) {
								$listing_field_content = array();
								if ( is_array( $listing_field_value ) && count( $listing_field_value ) > 0 ) {
									foreach ( $listing_field_value as $k => $v ) {
										$listing_field_content[] = $field['choices'][ $v ]['label'];
									}
									?>
									<div class="col-md-6">
										<div class="inner listing-infor-box">
											<div class="content-listing-info">
											<?php if ( ! empty( $field['icon']['url'] )) :?>
																	<div class="icon">
																		<img src="<?php echo esc_url( $field['icon']['url']); ?>" alt="icon">
																	</div>
																<?php endif; ?>
												<span
													class="listing-info-title"><?php esc_html_e( $field['title'] . ':', 'tf-car-listing' ); ?></span>
												<p class="listing-info-value">
													<?php echo esc_html__( implode( ', ', $listing_field_content ) ); ?></p>
											</div>
										</div>
									</div>
									<?php
								}
							} else if ( $field['type'] == 'radio' ) {
								if ( $listing_field_value != -1 ) {
									$listing_field_content = '';
									$listing_field_content = $field['choices'][ $listing_field_value ]['label'];
									if ( ! empty( $listing_field_content ) ) {
										?>
											<div class="col-md-6">
												<div class="inner listing-infor-box">
													<div class="content-listing-info">
													<?php if ( ! empty( $field['icon']['url'] )) :?>
																	<div class="icon">
																		<img src="<?php echo esc_url( $field['icon']['url']); ?>" alt="icon">
																	</div>
																<?php endif; ?>
														<span
															class="listing-info-title"><?php esc_html_e( $field['title'] . ':', 'tf-car-listing' ); ?></span>
														<p class="listing-info-value"><?php echo esc_html__( $listing_field_content ); ?></p>
													</div>
												</div>
											</div>
										<?php
									}
								}
							} else if ( $field['type'] == 'select' ) {
								if ( $listing_field_value != -1 ) {
									$listing_field_content = '';
									$listing_field_content = $field['choices'][ $listing_field_value ];
									if ( ! empty( $listing_field_content ) ) {
										?>
												<div class="col-md-6">
													<div class="inner listing-infor-box">
														<div class="content-listing-info">
														<?php if ( ! empty( $field['icon']['url'] )) :?>
																	<div class="icon">
																		<img src="<?php echo esc_url( $field['icon']['url']); ?>" alt="icon">
																	</div>
																<?php endif; ?>
															<span
																class="listing-info-title"><?php esc_html_e( $field['title'] . ':', 'tf-car-listing' ); ?></span>
															<p class="listing-info-value"><?php echo esc_html__( $listing_field_content ); ?></p>
														</div>
													</div>
												</div>
										<?php
									}
								}
							} else if ( $field['type'] == 'textarea' ) {
								$listing_field_value = wpautop( $listing_field_value );
								if ( ! empty( $listing_field_value ) ) {
									?>
												<div class="col-md-6">
													<div class="inner listing-infor-box">
														<div class="content-listing-info">
														<?php if ( ! empty( $field['icon']['url'] )) :?>
																	<div class="icon">
																		<img src="<?php echo esc_url( $field['icon']['url']); ?>" alt="icon">
																	</div>
																<?php endif; ?>
															<span
																class="listing-info-title"><?php esc_html_e( $field['title'] . ':', 'tf-car-listing' ); ?></span>
															<p class="listing-info-value"><?php echo wp_kses_post( $listing_field_value ); ?></p>
														</div>
													</div>
												</div>
									<?php
								}
							} else if ( $field['type'] == 'text' ) {
								if ( ! empty( $listing_field_value ) ) {
									?>
													<div class="col-md-6">
														<div class="inner listing-infor-box">
															<div class="content-listing-info">

																<?php if ( ! empty( $field['icon']['url'] )) :?>
																	<div class="icon">
																		<img src="<?php echo esc_url( $field['icon']['url']); ?>" alt="icon">
																	</div>
																<?php endif; ?>

																<span
																	class="listing-info-title"><?php esc_html_e( $field['title'] . ':', 'tf-car-listing' ); ?></span>
																<p class="listing-info-value">
													<?php echo wp_kses_post( is_numeric( $listing_field_value ) ? tfcl_get_format_number( intval( $listing_field_value ) ) : $listing_field_value ); ?>
																</p>
															</div>
														</div>
													</div>
									<?php
								}
							} else if ( $field['type'] == 'date' ) {
								if ( ! empty( $listing_field_value ) ) {
									?>
													<div class="col-md-6">
														<div class="inner listing-infor-box">
															<div class="content-listing-info">

																<?php if ( ! empty( $field['icon']['url'] )) :?>
																	<div class="icon">
																		<img src="<?php echo esc_url( $field['icon']['url']); ?>" alt="icon">
																	</div>
																<?php endif; ?>

																<span
																	class="listing-info-title"><?php esc_html_e( $field['title'] . ':', 'tf-car-listing' ); ?></span>
																<p class="listing-info-value">
																	<?php echo wp_kses_post( is_numeric( $listing_field_value ) ? tfcl_get_format_number( intval( $listing_field_value ) ) : $listing_field_value ); ?>
																</p>
															</div>
														</div>
													</div>
									<?php
								}
							}
						}
					}
					?>
					<?php if ( ! empty( $listing_additional_detail ) && is_array( $listing_additional_detail ) && count( $listing_additional_detail ) > 0 ) : ?>
						<?php foreach ( $listing_additional_detail as $key => $value ) {
							if ( ! empty( $value['additional_detail_title'] ) || ! empty( $value['additional_detail_value'] ) ) {
								?>
								<div class="col-xl-6 col-md-6 item">
									<div class="inner listing-infor-box">
										<div class="content-listing-info">
											<?php if ( ! empty( $value['additional_detail_icon'] )) :
												$ad_icon = $value['additional_detail_icon'];
												$icon_src = wp_get_attachment_image_src($value['additional_detail_icon'], 'full');
											?>
												<div class="icon add-icon"> 
													<?php 
															if (strlen($ad_icon) < 10): ?>
																 <img src="<?php echo esc_url( $icon_src[0]); ?>" alt="icon">
															<?php else: ?>
																<?php echo $ad_icon; ?>
															<?php endif; ?>
												</div>
											<?php endif; ?>
											<span
												class="listing-info-title"><?php esc_html_e( $value['additional_detail_title'], 'tf-car-listing' ); ?></span>
											<p class="listing-info-value">
												<?php echo esc_html__( is_numeric( $value['additional_detail_value'] ) ? tfcl_get_format_number( intval( $value['additional_detail_value'] ) ) : $value['additional_detail_value'] ); ?>
											</p>
										</div>
									</div>
								</div>
								<?php
							}
						} ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>