<div class="item">
	<?php
	$listing_id              = get_the_ID();
	$car_regular_price_value = get_post_meta( $listing_id, 'regular_price', true );
	$car_sale_price_value    = get_post_meta( $listing_id, 'sale_price', true );
	$car_price_prefix        = get_post_meta( $listing_id, 'price_prefix', true );
	$car_price_suffix        = get_post_meta( $listing_id, 'price_suffix', true );
	$car_date                = get_post_meta( $listing_id, 'year', true );
	$measurement_units       = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
	$car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );
	$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
	
	// taxonomy

	$car_fuel_type     = get_the_terms( $listing_id, 'fuel-type' );
	$car_fuel_type_att = array();
	if ( ! empty( $car_fuel_type ) ) {
		foreach ( $car_fuel_type as $car_fuel_type1 ) {
			array_push( $car_fuel_type_att, $car_fuel_type1->name );
		}
	}
	$car_fuel_type_att = implode( ",", $car_fuel_type_att );

	$car_transmission     = get_the_terms( $listing_id, 'transmission' );
	$car_transmission_att = array();
	if ( ! empty( $car_transmission ) ) {
		foreach ( $car_transmission as $car_transmission1 ) {
			array_push( $car_transmission_att, $car_transmission1->name );
		}
	}
	$car_transmission_att = implode( ",", $car_transmission_att );

	$car_make     = get_the_terms( $listing_id, 'make' );
	$car_make_att = array();
	if ( ! empty( $car_make ) ) {
		foreach ( $car_make as $car_make1 ) {
			array_push( $car_make_att, $car_make1->name );
		}
	}
	$car_make_att = implode( ",", $car_make_att );

	$car_model     = get_the_terms( $listing_id, 'model' );
	$car_model_att = array();
	if ( ! empty( $car_model ) ) {
		foreach ( $car_model as $car_model1 ) {
			array_push( $car_model_att, $car_model1->name );
		}
	}
	$car_model_att = implode( ",", $car_model_att );

	$car_body     = get_the_terms( $listing_id, 'body' );
	$car_body_att = array();
	if ( ! empty( $car_body ) ) {
		foreach ( $car_body as $car_body1 ) {
			array_push( $car_body_att, $car_body1->name );
		}
	}
	$car_body_att = implode( ",", $car_body_att );

	$car_drive_type     = get_the_terms( $listing_id, 'drive-type' );
	$car_drive_type_att = array();
	if ( ! empty( $car_drive_type ) ) {
		foreach ( $car_drive_type as $car_drive_type1 ) {
			array_push( $car_drive_type_att, $car_drive_type1->name );
		}
	}
	$car_drive_type_att = implode( ",", $car_drive_type_att );

	$car_cylinders     = get_the_terms( $listing_id, 'cylinders' );
	$car_cylinders_att = array();
	if ( ! empty( $car_cylinders ) ) {
		foreach ( $car_cylinders as $car_cylinders1 ) {
			array_push( $car_cylinders_att, $car_cylinders1->name );
		}
	}
	$car_cylinders_att = implode( ",", $car_cylinders_att );

	$car_car_color     = get_the_terms( $listing_id, 'car-color' );
	$car_car_color_att = array();
	if ( ! empty( $car_car_color ) ) {
		foreach ( $car_car_color as $car_car_color1 ) {
			array_push( $car_car_color_att, $car_car_color1->name );
		}
	}
	$car_car_color_att = implode( ",", $car_car_color_att );

	// metaboxes
	$car_mileage             = get_post_meta( $listing_id, 'mileage', true ) ? get_post_meta( $listing_id, 'mileage', true ) . ' ' . $measurement_units : 0;
	$car_stock_number             = get_post_meta( $listing_id, 'stock_number', true ) ? get_post_meta( $listing_id, 'stock_number', true ) : 0;
	$car_vin_number             = get_post_meta( $listing_id, 'vin_number', true ) ? get_post_meta( $listing_id, 'vin_number', true ) : 0;
	$car_engine_size             = get_post_meta( $listing_id, 'engine_size', true ) ? get_post_meta( $listing_id, 'engine_size', true ) : 0;
	$car_door             = get_post_meta( $listing_id, 'door', true ) ? get_post_meta( $listing_id, 'door', true ) : 0;
	$car_seat             = get_post_meta( $listing_id, 'seat', true ) ? get_post_meta( $listing_id, 'seat', true ) : 0;
	$car_city_mpg             = get_post_meta( $listing_id, 'city_mpg', true ) ? get_post_meta( $listing_id, 'city_mpg', true ) : 0;
	$car_highway_mpg             = get_post_meta( $listing_id, 'highway_mpg', true ) ? get_post_meta( $listing_id, 'highway_mpg', true ) : 0;
	

	
	$car_featured            = get_post_meta( $listing_id, 'car_featured', true ) ? get_post_meta( $listing_id, 'car_featured', true ) : false;
	$car_status              = get_post_meta( $listing_id, 'car_status', true ) ? get_post_meta( $listing_id, 'car_status', true ) : false;
	$car_status_text         = get_post_meta( $listing_id, 'car_status_text', true );
	$width           	     = tfcl_get_option( 'image_width_listing', 600 );
	$height          	     = tfcl_get_option( 'image_height_listing', 450 );
	$car_gallery_images      = get_post_meta( $listing_id, 'gallery_images', true ) ? get_post_meta( $listing_id, 'gallery_images', true ) : '';
	$car_gallery_first_image = is_array( json_decode( $car_gallery_images ) ) ? json_decode( $car_gallery_images )[0] : '';
	$gallery_thumb           = tfcl_image_resize_id( get_post_thumbnail_id( $listing_id ), $width, $height, true );
	$car_gallery_images_list = get_sources_listing_gallery_images( $car_gallery_images );
	if ( is_array( $car_gallery_images_list ) ) {
		if ( get_post_thumbnail_id( $listing_id ) != $car_gallery_first_image ) {
			array_unshift( $car_gallery_images_list, $gallery_thumb );
		}
	}

	// dealer
	global $post;
	$author_id  = $post->post_author;
	$dealer_id  = ! empty( get_post_meta( $listing_id, 'listing_dealer_info', true ) ) ? get_post_meta( $listing_id, 'listing_dealer_info', true ) : get_the_author_meta( 'author_dealer_id', $author_id );
	if ( isset( $dealer_id ) && ! empty( $dealer_id ) ) {
		$dealer_post_meta_data = get_post_custom( $dealer_id );
		$full_name             = get_the_title( $dealer_id );
		$email                 = isset( $dealer_post_meta_data['dealer_email'] ) ? $dealer_post_meta_data['dealer_email'][0] : '';
		$phone                 = isset( $dealer_post_meta_data['dealer_phone_number'] ) ? $dealer_post_meta_data['dealer_phone_number'][0] : '';
		$author_id             = get_post_field( 'post_author', $dealer_id );
	} else {
		$first_name = get_the_author_meta( 'first_name', $author_id );
		$last_name  = get_the_author_meta( 'last_name', $author_id );
		$full_name  = $first_name . ' ' . $last_name;
		$email      = get_the_author_meta( 'user_email', $author_id );
		$phone      = get_the_author_meta( 'user_phone', $author_id );
	}
	$user_avatar = get_the_author_meta( 'profile_image_id', $author_id );
	$no_avatar            = get_avatar_url( get_the_author_meta( 'ID' ) );
	$default_image_src    = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : $no_avatar;

	//setting favorite
	global $current_user;
	wp_get_current_user();
	$check_is_favorite = false;
	$user_id           = $current_user->ID;
	$my_favorites      = get_user_meta( $user_id, 'favorites_listing', true );

	if ( ! empty( $my_favorites ) ) {
		$check_is_favorite = array_search( $listing_id, $my_favorites );
	}
	$title_not_favorite = $title_favorited = '';
	$icon_favorite     = apply_filters( 'tfcl_icon_favorite', 'far fa-heart' );
	$icon_not_favorite = apply_filters( 'tfcl_icon_not_favorite', 'far fa-heart' );

	if ( $check_is_favorite !== false ) {
		$css_class = $icon_favorite;
		$title     = esc_attr__( 'It is your favorite', 'tf-car-listing' );
	} else {
		$css_class = $icon_not_favorite;
		$title     = esc_attr__( 'Add to Favorite', 'tf-car-listing' );
	}

	$featured_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' ).'/?condition=all&enable-search-features=0&featured=true' : '#';
	$year_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' )."?condition=all&enable-search-features=0&min-year=".$car_date."&max-year=".$car_date."" : '#';

	?>
	<div class="listing-post listing-post-<?php the_ID(); ?>">
		<div class="featured-property">
			<div class="group-meta">
				<div class="inner">
					<?php if ( $car_featured == true ) : ?>
						<a href="<?php echo esc_url($featured_url); ?>" target="_blank">
							<span class="features"><?php esc_html_e( 'Featured', 'tf-car-listing' ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $car_status == true && !empty($car_status_text) ) : ?>
						<span class="status"><?php echo esc_html( $car_status_text ); ?></span>
					<?php endif; ?>
					<?php if ( is_array( $car_gallery_images_list ) && $settings['show_counter'] ) : ?>
						<span class="count-list-gallery view-gallery" data-mfp-event
							data-gallery="<?php echo esc_attr( json_encode( $car_gallery_images_list ) ); ?>"><i class="icon-autodeal-image"></i><?php echo esc_html( count( $car_gallery_images_list ) ); ?></span>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $car_date ) && $settings['show_year'] ) : ?>
					<a href="<?php echo esc_url($year_url); ?>" target="_blank"><span class="date-car"><?php echo esc_html( $car_date ); ?></span></a>
				<?php endif; ?>
			</div>
			<?php if ( $settings['enable_compare_listing'] == 'yes' || $settings['enable_favorite_listing'] == 'yes' ) : ?>
				<ul class="list-controller">
				<?php if ( $settings['enable_compare_listing'] == 'yes' ) : ?>
					<li>
						<a class="compare tfcl-compare-listing hv-tool" href="javascript:void(0)"
							data-listing-id="<?php the_ID() ?>" data-toggle="tooltip"
							data-tooltip="<?php echo esc_attr_e( 'Add Compare', 'tf-car-listing' ); ?>"
							title="<?php echo esc_attr_e( 'Compare', 'tf-car-listing' ); ?>">
							<i class="far fa-plus"></i>
						</a>
					</li>
				<?php endif; ?>
				<?php if ( $settings['enable_favorite_listing'] == 'yes' ) : ?>
					<li>
						<a href="javascript:void(0)"
							class="tfcl-listing-favorite hv-tool <?php esc_attr_e( $check_is_favorite !== false ? 'active' : '' ); ?>"
							data-tfcl-car-id="<?php echo esc_attr( intval( $listing_id ) ) ?>" data-toggle="tooltip"
							data-tooltip="<?php echo esc_attr( $title ) ?>"
							data-tfcl-title-not-favorite="<?php esc_attr_e( 'Add to Favorite', 'tf-car-listing' ) ?>"
							data-tfcl-title-favorited="<?php esc_attr_e( 'It is your favorite', 'tf-car-listing' ); ?>"
							data-tfcl-icon-not-favorite="<?php echo esc_attr( $icon_not_favorite ) ?>"
							data-tfcl-icon-favorited="<?php echo esc_attr( $icon_favorite ) ?>"><i
								class="<?php echo esc_attr( $css_class ); ?>" aria-hidden="true"></i></a>
					</li>
				<?php endif; ?>
				</ul>
			<?php endif; ?>
			<?php if ( $settings['swiper_image_box'] == 'yes' ) : ?>
				<?php if ( is_array( $car_gallery_images_list ) && count( $car_gallery_images_list ) > 1 ) : ?>
					<div class="swiper-container carousel-image-box img-style">
						<div class="swiper-wrapper ">
							<?php foreach ( $car_gallery_images_list as $key => $value ) : ?>
								<?php if ( $key < $settings['limit_swiper_images'] ) : ?>
										<div class="swiper-slide">
											<a href="<?php echo get_the_permalink(); ?>" class="listing-item"
												title="<?php echo esc_attr( get_the_title() ); ?>">
												<img loading="lazy" src="<?php echo esc_attr( $value ); ?>" class="swiper-image"
													alt="images">
											</a>
										</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>
				<?php else : ?>
					<a class="view-gallery listing-item" href="<?php echo get_the_permalink(); ?>">
						<?php
						$get_id_post_thumbnail = get_post_thumbnail_id( $listing_id );
						echo sprintf( '<img loading="lazy" src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
						?>
					</a>
				<?php endif; ?>
			<?php else : ?>
				<a class="view-gallery listing-item" data-mfp-event
					data-gallery="<?php echo esc_attr( json_encode( $car_gallery_images_list ) ); ?>"
					href="<?php echo get_the_permalink(); ?>">
					<?php
					$get_id_post_thumbnail = get_post_thumbnail_id( $listing_id );
					echo sprintf( '<img src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
					?>
				</a>
			<?php endif; ?>
		</div>
		<div class="content">
			<?php if ( ! empty( $car_body_att ) ) : ?>
				<a href="<?php echo esc_url( get_term_link( $car_body[0] ) ) ?>" class="car-body"><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></a>
			<?php endif; ?>
			<h3 class="title">
				<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
			</h3>
			<div class="description">
				<ul>
				<?php if ( $settings['show_mileages'] == 'yes' ) : ?>
						<li class="listing-information mileages">
						<?php echo themesflat_svg('dashboard'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_mileage ); ?></p>
							</div>
						</li>
					<?php endif; ?>
				<?php if ( $settings['show_type_fuel'] == 'yes' ) : ?>
						<li class="listing-information fuel">
							<?php echo themesflat_svg('fuel'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_fuel_type_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_transmission'] == 'yes' ) : ?>
						<li class="listing-information transmission">
						<?php echo themesflat_svg('transmission2'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_transmission_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_make'] == 'yes' ) : ?>
						<li class="listing-information make">
							<?php echo themesflat_svg('car'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_make_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_model'] == 'yes' ) : ?>
						<li class="listing-information model">
							<?php echo themesflat_svg('car'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_model_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_body'] == 'yes' ) : ?>
						<li class="listing-information body">
							<?php echo themesflat_svg('car'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_stock_number'] == 'yes' ) : ?>
						<li class="listing-information stock-number">
							<?php echo themesflat_svg('checklist'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_stock_number, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_vin_number'] == 'yes' ) : ?>
						<li class="listing-information vin-number">
						<?php echo themesflat_svg('checklist'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_vin_number, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_drive_type'] == 'yes' ) : ?>
						<li class="listing-information drive-type">
						<?php echo themesflat_svg('drive'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_drive_type_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_engine_size'] == 'yes' ) : ?>
						<li class="listing-information engine">
						<?php echo themesflat_svg('engine'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_engine_size, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_cylinders'] == 'yes' ) : ?>
						<li class="listing-information cylinders">
						<?php echo themesflat_svg('cylinder'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_cylinders_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_door'] == 'yes' ) : ?>
						<li class="listing-information door">
						<?php echo themesflat_svg('door'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_door, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_color'] == 'yes' ) : ?>
						<li class="listing-information color">
						<?php echo themesflat_svg('color'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_car_color_att, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_seat'] == 'yes' ) : ?>
						<li class="listing-information seat">
						<?php echo themesflat_svg('seat'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_seat, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_city_mpg'] == 'yes' ) : ?>
						<li class="listing-information city-mpg">
						<?php echo themesflat_svg('performance'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_city_mpg, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( $settings['show_highway_mpg'] == 'yes' ) : ?>
						<li class="listing-information highway-mpg">
						<?php echo themesflat_svg('performance'); ?>
							<div class="inner">
								<p><?php echo esc_html( $car_highway_mpg, 'tf-car-listing' ); ?></p>
							</div>
						</li>
					<?php endif; ?>
				</ul>
			</div>
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
			<div class="bottom-content">
			<?php if ( $settings['enable_author_listing'] == 'yes' ) : ?>
					<div class="avatar-thumb">
						<img alt="<?php echo esc_attr( $full_name ); ?>"
							src="<?php echo esc_attr( tfcl_image_resize_id( $user_avatar, '50', '50', true ) ); ?>"
							onerror="this.src = '<?php echo esc_url( $default_image_src ) ?>';" class="avatar avatar-96 photo"
							loading="lazy"><span><?php echo esc_attr( $full_name ); ?></span>
						</div>
					<?php endif; ?>

				<div class="button-details">
					<a href="<?php echo get_the_permalink(); ?>"><?php echo esc_html__( $settings['button_text'] ); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>