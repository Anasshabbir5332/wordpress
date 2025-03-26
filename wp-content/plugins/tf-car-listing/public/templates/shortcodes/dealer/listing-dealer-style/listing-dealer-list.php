<?php
$width  = tfcl_get_option( 'image_width_listing', 660 );
$height = tfcl_get_option( 'image_height_listing', 471 );
$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
if ( ! empty( $data ) && is_array( $data ) ) {
	if ( ! empty( $data['message_error'] ) ) {
		echo esc_html__( $data['message_error'], 'tf-car-listing' );
	} else {
		foreach ( $data as $key => $item ) {
			extract( $item );
		}
		$featured_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' ).'/?condition=all&enable-search-features=0&featured=true' : '#';
	$year_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' )."?condition=all&enable-search-features=0&min-year=".$listing_date."&max-year=".$listing_date."" : '#';

		?>
		<div class="item">
			<div class="listing-post listing-post-<?php echo esc_attr( $listing_id ); ?>">
				<div class="featured-listing">
					<div class="group-meta">
						<?php if ( $is_featured ) : ?>
							<a href="<?php echo esc_url($featured_url); ?>" target="_blank">
										<span class="features"><?php esc_html_e( 'Featured', 'tf-car-listing' ); ?></span>
									</a>
						<?php endif; ?>
						<?php if ( tfcl_get_option( 'enable_year_listing') == 'y' ) : ?>
							<?php if ( ! empty( $listing_date ) ) : ?>
								<a href="<?php echo esc_url($year_url); ?>" target="_blank"><span class="date-car"><?php echo esc_html( $listing_date ); ?></span></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<?php if ( is_array( $listing_gallery_images ) && count( $listing_gallery_images ) > 1 ) : ?>
						<div class="swiper-container carousel-image-box img-style">
							<div class="swiper-wrapper ">
								<?php foreach ( $listing_gallery_images as $key => $value ) : ?>
									<?php if ( $key < tfcl_get_option( 'limit_show_image' ) ) : ?>
										<?php if ( $key === ( tfcl_get_option( 'limit_show_image' ) - 1 ) && ( count( $listing_gallery_images ) - tfcl_get_option( 'limit_show_image' ) ) != 0 ) : ?>
											<div class="swiper-slide">
												<div class="listing-item view-gallery" data-mfp-event
													data-gallery="<?php echo esc_attr( json_encode( $listing_gallery_images ) ); ?>"
													title="<?php echo esc_attr( $listing_title ); ?>">
													<div class="images">
														<img src="<?php echo esc_attr( $value ); ?>" class="swiper-image tfcl-light-gallery"
															alt="images">
														<div class="overlay-limit">
															<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/picture.svg'; ?>"
																class="icon-img" alt="icon-map">
															<p><?php echo esc_html( count( $listing_gallery_images ) - tfcl_get_option( 'limit_show_image' ) ); ?>
																<?php esc_html_e( 'more photos', 'tf-car-listing' ); ?></p>
														</div>
													</div>
												</div>
											</div>
										<?php else : ?>
											<div class="swiper-slide">
												<a href="<?php echo esc_url( $listing_permalink ); ?>" class="listing-item"
													title="<?php echo esc_attr( $listing_title ); ?>">
													<img loading="lazy" src="<?php echo esc_attr( $value ); ?>" class="swiper-image"
														alt="images">
												</a>
											</div>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
							<div class="swiper-button-next2"><i class="far fa-arrow-right"></i></div>
							<div class="swiper-button-prev2"><i class="far fa-arrow-left"></i> </div>
						</div>
					<?php else : ?>
						<a class="view-gallery" href="<?php echo get_the_permalink(); ?>">
							<?php
							$get_id_post_thumbnail = get_post_thumbnail_id( $listing_id );
							if ( isset( $toggle_lazy_load ) && $toggle_lazy_load == 'on' ) {
								echo sprintf( '<img loading="lazy" class="lazy" src="" data-src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
							} else {
								echo sprintf( '<img loading="lazy" src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
							}
							?>
						</a>
					<?php endif; ?>
				</div>
				<div class="content">
					<?php if ( ! empty( $listing_body ) ) : ?>
						<a href="<?php echo esc_url( get_term_link( $listing_body[0] ) ) ?>" class="car-body"><?php echo esc_html( $listing_body_att, 'tf-car-listing' ); ?></a>
					<?php endif; ?>
					<h3 class="title">
						<a href="<?php echo get_the_permalink(); ?>"><?php echo esc_html( $listing_title ); ?></a>
					</h3>
					<div class="price">
						<?php if ( ! empty( $listing_sale_price_value ) ) : ?>
							<span class="inner regular_price">
								<?php if ( $listing_price_prefix != '' ) : ?>
									<?php echo $listing_price_prefix; ?>
								<?php endif; ?>
								<?php echo tfcl_format_price( $listing_sale_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
								<?php if ( $listing_price_suffix != '' ) : ?>
									<?php echo $listing_price_suffix; ?>
								<?php endif; ?>
							</span>
						<?php endif; ?>
						<?php if ( ! empty( $listing_regular_price_value ) ) : ?>
							<span class="inner sale_price">
								<?php if ( $listing_price_prefix != '' ) : ?>
									<?php echo $listing_price_prefix; ?>
								<?php endif; ?>
								<?php echo tfcl_format_price( $listing_regular_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>

								<?php if ( $listing_price_suffix != '' ) : ?>
									<?php echo $listing_price_suffix; ?>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</div>
				<?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y' || tfcl_get_option( 'enable_mileages_listing') == 'y' || tfcl_get_option( 'enable_transmission_listing') == 'y' ) : ?>
					<div class="description">
						<ul>
							<?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y') :?>
							<li class="listing-information fuel">
								<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/fuel.svg'; ?>"
									alt="icon-fuel">
								<div class="inner">
									<span><?php esc_html_e( 'Fuel type', 'tf-car-listing' ); ?></span>
									<p><?php echo esc_html( $listing_fuel_type_att, 'tf-car-listing' ); ?></p>
								</div>
							</li>
							<?php endif; ?>
							<?php if ( tfcl_get_option( 'enable_mileages_listing') == 'y') :?>
							<li class="listing-information size-engine">
								<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/dashboard.svg'; ?>"
									alt="icon-mileage">
								<div class="inner">
									<span><?php esc_html_e( 'Mileage', 'tf-car-listing' ); ?></span>
									<p><?php echo esc_html( $listing_mileage ); ?></p>
								</div>
							</li>
							<?php endif; ?>
							<?php if ( tfcl_get_option( 'enable_transmission_listing') == 'y') :?>
							<li class="listing-information transmission">
								<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/transmission.svg'; ?>"
									alt="icon-transmission">
								<div class="inner">
									<span><?php esc_html_e( 'Transmission', 'tf-car-listing' ); ?></span>
									<p><?php echo esc_html( $listing_transmission_att, 'tf-car-listing' ); ?></p>
								</div>
							</li>
							<?php endif; ?>
						</ul>
					</div>
				<?php endif; ?>
					<div class="bottom-content">
						<div class="card-button">
							<a title="<?php the_title() ?>"
								href="<?php echo esc_url( get_permalink( $listing_id ) ); ?>"
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
		<?php
	}
}
?>