<?php
/**
 * @var $listing_id
 * @var $attach_id
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! empty( $data ) && is_array( $data ) ) {
	if ( ! empty( $data['message_error'] ) ) {
		echo esc_html__( $data['message_error'], 'tf-car-listing' );
	} else {
		foreach ( $data as $data_item ) {
			extract( $data_item );
		}
		$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
		$measurement_units           = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
		$car_regular_price_value     = get_post_meta( $listing_id, 'regular_price', true );
		$car_sale_price_value        = get_post_meta( $listing_id, 'sale_price', true );
		$car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );
		$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
		$car_price_prefix            = get_post_meta( $listing_id, 'price_prefix', true );
		$car_price_suffix            = get_post_meta( $listing_id, 'price_suffix', true );
		$car_mileage                 = get_post_meta( $listing_id, 'mileage', true ) ? get_post_meta( $listing_id, 'mileage', true ) . ' ' . $measurement_units : 0;
		$car_fuel_type               = get_the_terms( $listing_id, 'fuel-type' );
		$car_fuel_type_att           = ! empty( $car_fuel_type[0]->name ) ? $car_fuel_type[0]->name : 'none';
		$car_body                    = get_the_terms( $listing_id, 'body', true );
		$car_body_att                = ! empty( $car_body[0]->name ) ? $car_body[0]->name : '';
		$car_featured                = get_post_meta( $listing_id, 'car_featured', true ) ? get_post_meta( $listing_id, 'car_featured', true ) : false;
		$car_date                    = get_post_meta( $listing_id, 'year', true );
		$car_transmission            = get_the_terms( $listing_id, 'transmission' );
		$car_transmission_att        = ! empty( $car_transmission[0]->name ) ? $car_transmission[0]->name : 'none';
		$car_address                 = get_post_meta( $listing_id, 'listing_address', true );
		$car_location                = $listing_id ? get_post_meta( $listing_id, 'listing_location', true ) : '';
		$car_gallery_images          = get_post_meta( $listing_id, 'gallery_images', true ) ? get_post_meta( $listing_id, 'gallery_images', true ) : '';
		$car_gallery_first_image     = is_array( json_decode( $car_gallery_images ) ) ? json_decode( $car_gallery_images )[0] : '';
		$car_gallery_images_list     = get_sources_listing_gallery_images( $car_gallery_images );
		$gallery_thumb               = get_the_post_thumbnail_url( $listing_id, 'medium' );

		if ( is_array( $car_gallery_images_list ) ) {
			if ( get_post_thumbnail_id( $listing_id ) != $car_gallery_first_image ) {
				array_unshift( $car_gallery_images_list, $gallery_thumb );
			}
		}
		$width           = tfcl_get_option( 'image_width_listing', 660 );
		$height          = tfcl_get_option( 'image_height_listing', 471 );
		$no_image_src    = tfcl_get_option( 'default_listing_image', '' )['url'] != '' ? tfcl_get_option( 'default_listing_image', '' )['url'] : TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
		$image_src       = tfcl_image_resize_id( $attach_id, $width, $height, true );
		$enable_compare  = tfcl_get_option( 'enable_compare', 'y' );
		$enable_favorite = tfcl_get_option( 'enable_favorite', 'y' );
		$class           = isset( $class ) ? $class : '';
		$featured_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' ).'/?condition=all&enable-search-features=0&featured=true' : '#';
		$year_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' )."?condition=all&enable-search-features=0&min-year=".$car_date."&max-year=".$car_date."" : '#';
	
		?>
		<div class="wrap-tfcl-listing-card cards-item <?php echo esc_attr( $css_class_col ); ?>"
			data-col="<?php echo esc_attr( $css_class_col ); ?>">
			<div class="tfcl-listing-card">
				<div class="featured-property tfcl-image-map" title="<?php echo esc_attr( $listing_title ); ?>"
					data-image="<?php echo esc_url( $image_src ? $image_src : $no_image_src ) ?>"
					data-id="<?php echo esc_attr( $listing_id ) ?>"
					data-location="<?php echo esc_attr( ! empty( $car_address ) ? $car_address : '' ); ?>"
					data-price-prefix="<?php echo esc_attr( $car_price_prefix ); ?>"
					data-price-suffix="<?php echo esc_attr( $car_price_suffix ); ?>"
					data-price="<?php echo tfcl_format_price( $car_sale_price_value, $car_price_unit ) ?>">
					<div class="group-meta">
						<?php if ( $car_featured == true ) : ?>
							<a href="<?php echo esc_url($featured_url); ?>" target="_blank">
										<span class="features"><?php esc_html_e( 'Featured', 'tf-car-listing' ); ?></span>
									</a>
						<?php endif; ?>
						<?php if ( tfcl_get_option( 'enable_counter_gallery') == 'y' ) : ?>
							<?php if ( is_array( $car_gallery_images_list ) ) : ?>
								<span class="count-list-gallery view-gallery" data-mfp-event
									data-gallery="<?php echo esc_attr( json_encode( $car_gallery_images_list ) ); ?>"><img
										src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/camera.svg'; ?>"
										alt="icon-map"><?php echo esc_html( count( $car_gallery_images_list ) ); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( tfcl_get_option( 'enable_year_listing') == 'y' ) : ?>
							<?php if ( ! empty( $car_date ) ) : ?>
								<a href="<?php echo esc_url($year_url); ?>" target="_blank"><span class="date-car"><?php echo esc_html( $car_date ); ?></span></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<?php if ( is_array( $car_gallery_images_list ) && count( $car_gallery_images_list ) > 1 ) : ?>
						<a href="<?php echo get_the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
						<div class="listing-images">
							<div class="hover-listing-image">
								<div class="wrap-hover-listing">
									<?php foreach ( $car_gallery_images_list as $key => $value ) : ?>
										<?php if ( $key < 4 ) : ?>
											<?php if ( $key === 3 && ( count( $car_gallery_images_list ) - 4 ) != 0 ) : ?>
												<div class="listing-item view-gallery" data-mfp-event
													data-gallery="<?php echo esc_attr( json_encode( $car_gallery_images_list ) ); ?>"
													title="<?php echo esc_attr( get_the_title() ); ?>">
													<div class="images">
														<img src="<?php echo esc_attr( $value ); ?>" class="swiper-image tfcl-light-gallery"
															alt="images">
														<div class="overlay-limit">
															<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/picture.svg'; ?>"
																class="icon-img" alt="icon-map">
															<p><?php echo esc_html( count( $car_gallery_images_list ) - 4 ); ?>
																<?php esc_html_e( 'more photos', 'tf-car-listing' ); ?></p>
														</div>
													</div>
												</div>
											<?php else : ?>
												<div class="listing-item">
													<div class="images">
														<img src="<?php echo esc_attr( $value ); ?>"
															class="swiper-image lazy tfcl-light-gallery" alt="images">
													</div>
												</div>
											<?php endif; ?>
										<?php endif; ?>
									<?php endforeach; ?>
									<?php if ( count( $car_gallery_images_list ) > 1 ) : ?>
										<div class="bullet-hover-listing">
											<?php foreach ( $car_gallery_images_list as $key => $value ) : ?>
												<?php if ( $key < 4 ) : ?>
													<div class="bl-item"></div>
												<?php endif; ?>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</a>
					<?php else : ?>
						<a class="view-gallery" href="<?php echo esc_url( $listing_permalink ); ?>">
							<?php
							$get_id_post_thumbnail = get_post_thumbnail_id( $listing_id );
							echo sprintf( '<img src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
							?>
						</a>
					<?php endif; ?>
				</div>
				<div class="card-content">
					<?php if ( ! empty( $car_body_att ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( $car_body[0] ) ) ?>" class="car-body"><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></a>
					<?php endif; ?>
					<h3 class="tfcl-listing-title">
						<a title="<?php the_title() ?>"
							href="<?php echo esc_url( get_permalink( $listing_id ) ); ?>"><?php echo esc_html( $listing_title ); ?></a>
					</h3>
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
				<?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y' || tfcl_get_option( 'enable_mileages_listing') == 'y' || tfcl_get_option( 'enable_transmission_listing') == 'y' ) : ?>
					<ul class="infor-description">
						<?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y') :?>
						<li class="listing-information fuel">
							<img src="<?php echo TF_PLUGIN_URL . 'public/assets/image/icon/listing/gasoline-pump.svg'; ?>"
								alt="icon-map">
							<div class="inner">
								<span><?php esc_html_e( 'Fuel type', 'tf-car-listing' ); ?></span>
								<p><?php esc_html_e( $car_fuel_type_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
						<?php endif; ?>
						<?php if ( tfcl_get_option( 'enable_mileages_listing') == 'y') :?>
						<li class="listing-information mileage">
							<img src="<?php echo TF_PLUGIN_URL . 'public/assets/image/icon/listing/dashboard.svg'; ?>"
								alt="icon-map">
							<div class="inner">
								<span><?php esc_html_e( 'Mileage', 'tf-car-listing' ); ?></span>
								<p><?php esc_html_e( $car_mileage, 'tf-car-listing' ); ?></p>
							</div>
						</li>
						<?php endif; ?>
						<?php if ( tfcl_get_option( 'enable_transmission_listing') == 'y') :?>
						<li class="listing-information transmission">
							<img src="<?php echo TF_PLUGIN_URL . 'public/assets/image/icon/listing/gearbox.svg'; ?>"
								alt="icon-map">
							<div class="inner">
								<span><?php esc_html_e( 'Transmission', 'tf-car-listing' ); ?></span>
								<p><?php esc_html_e( $car_transmission_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
					<div class="bottom-content">
						<div class="card-button">
							<a title="<?php echo esc_attr( $listing_title ); ?>"
								href="<?php echo esc_url( $listing_permalink ); ?>"
								class="btn-listing"><?php echo esc_html(tfcl_get_option( 'text_card_button', 'View Details')) ?> <i
									class="icon-autodeal-readmore"></i></a>
						</div>

						<?php if ( tfcl_get_option( 'enable_compare') == 'y' || tfcl_get_option( 'enable_favorite') == 'y' ) : ?>
					<ul class="list-controller">
						<?php if ( tfcl_get_option( 'enable_favorite') == 'y' ) : ?>
							<li>
								<?php do_action( 'tfcl_favorite_action' ); ?>
							</li>
						<?php endif; ?>
						<?php if ( tfcl_get_option( 'enable_compare') == 'y' ) : ?>
							<li>
								<a class="compare tfcl-compare-listing hv-tool" href="javascript:void(0)"
								data-listing-id="<?php the_ID() ?>" data-toggle="tooltip"
								data-tooltip="<?php echo esc_attr_e( 'Add Compare', 'tf-car-listing' ); ?>"
								title="<?php echo esc_attr_e( 'Compare', 'tf-car-listing' ); ?>">
								<i class="far fa-plus"></i>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php }
}
?>