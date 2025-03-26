<?php
	$listing_id              = get_the_ID();
	$car_regular_price_value = get_post_meta( $listing_id, 'regular_price', true );
	$car_sale_price_value    = get_post_meta( $listing_id, 'sale_price', true );
	$car_price_prefix        = get_post_meta( $listing_id, 'price_prefix', true );
	$car_price_suffix        = get_post_meta( $listing_id, 'price_suffix', true );
	$car_date                = get_post_meta( $listing_id, 'year', true );
	$measurement_units       = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
	$car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );

	// taxonomy
	$car_fuel_type           = get_the_terms( $listing_id, 'fuel-type', true );
	$car_fuel_type_att       = ! empty( $car_fuel_type[0]->name ) ? $car_fuel_type[0]->name : 'none';
	$car_body                = get_the_terms( $listing_id, 'body', true );
	$car_body_att            = ! empty( $car_body[0]->name ) ? $car_body[0]->name : '';
	$car_transmission        = get_the_terms( $listing_id, 'transmission' );
	$car_transmission_att    = ! empty( $car_transmission[0]->name ) ? $car_transmission[0]->name : 'none';
	$car_make        = get_the_terms( $listing_id, 'make' );
	$car_make_att    = ! empty( $car_make[0]->name ) ? $car_make[0]->name : 'none';
	$car_model        = get_the_terms( $listing_id, 'model' );
	$car_model_att    = ! empty( $car_model[0]->name ) ? $car_model[0]->name : 'none';
	$car_body        = get_the_terms( $listing_id, 'body' );
	$car_body_att    = ! empty( $car_body[0]->name ) ? $car_body[0]->name : 'none';
	$car_drive_type        = get_the_terms( $listing_id, 'drive-type' );
	$car_drive_type_att    = ! empty( $car_drive_type[0]->name ) ? $car_drive_type[0]->name : 'none';
	$car_cylinders        = get_the_terms( $listing_id, 'cylinders' );
	$car_cylinders_att    = ! empty( $car_cylinders[0]->name ) ? $car_cylinders[0]->name : 'none';
	$car_car_color        = get_the_terms( $listing_id, 'car-color' );
	$car_car_color_att    = ! empty( $car_car_color[0]->name ) ? $car_car_color[0]->name : 'none';
	$car_condition        = get_the_terms( $listing_id, 'condition' );
	$car_condition_att    = ! empty( $car_condition[0]->name ) ? $car_condition[0]->name : '';

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
		$position                 = isset( $dealer_post_meta_data['dealer_position'] ) ? $dealer_post_meta_data['dealer_position'][0] : '';
		$phone                 = isset( $dealer_post_meta_data['dealer_phone_number'] ) ? $dealer_post_meta_data['dealer_phone_number'][0] : '';
		$author_id             = get_post_field( 'post_author', $dealer_id );
	} else {
		$first_name = get_the_author_meta( 'first_name', $author_id );
		$last_name  = get_the_author_meta( 'last_name', $author_id );
		$position      = get_the_author_meta( 'user_position', $author_id );
		$full_name  = $first_name . ' ' . $last_name;
		$email      = get_the_author_meta( 'user_email', $author_id );
		$phone      = get_the_author_meta( 'user_phone', $author_id );
	}
	$user_avatar = get_the_author_meta( 'profile_image_id', $author_id );
	$no_avatar            = get_avatar_url( get_the_author_meta( 'ID' ) );
	$default_image_src    = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : $no_avatar;
    $link_btn = !empty($settings['link']['url']) ? esc_url($settings['link']['url']) : get_the_permalink();
	?>
	<div class="slider-post listing-post-<?php the_ID(); ?>">
		<div class="content-left">
        	<ul>
        	    <li class="listing-information">
					<?php echo themesflat_svg('trans3'); ?>
						<div class="inner">
        	                <p class="sub"><?php esc_html_e( get_option('custom_name_transmission') ); ?></p>
        	                <p><?php echo esc_html( $car_transmission_att, 'tf-car-listing' ); ?></p>
						</div>
				</li>
        	    <li class="listing-information">
					<?php echo themesflat_svg('engine3'); ?>
						<div class="inner">
        	                <p class="sub"><?php esc_html_e( get_option('custom_name_engine_size') ); ?></p>
        	                <p><?php echo esc_html( $car_engine_size, 'tf-car-listing' ); ?></p>
						</div>
				</li>
        	    <li class="listing-information">
					<?php echo themesflat_svg('stock3'); ?>
						<div class="inner">
        	                <p class="sub"><?php esc_html_e( get_option('custom_name_stock_number') ); ?></p>
        	                <p><?php echo esc_html( $car_stock_number, 'tf-car-listing' ); ?></p>
						</div>
				</li>
        	    <li class="listing-information">
					<?php echo themesflat_svg('vin3'); ?>
						<div class="inner">
        	                <p class="sub"><?php esc_html_e( get_option('custom_name_vin_number') ); ?></p>
        	                <p><?php echo esc_html( $car_vin_number, 'tf-car-listing' ); ?></p>
						</div>
				</li>
        	</ul>
			<a href="<?php echo get_the_permalink(); ?>" class="viewmore"><?php esc_html_e( 'See full specs', 'tf-car-listing' ); ?> <i class="icon-autodeal-icon-86"></i> </a>
		</div>
		<div class="content">
			<h1 class="title">
				<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
			</h1>
            <p class="desc">
				<?php echo get_post_field( 'post_content', $listing_id ); ?>
            </p>
            <?php if ( $settings['show_button'] == 'yes' ) : ?>
                <div class="button-details">
                    <a href="<?php echo $link_btn; ?>"><?php echo esc_attr( $settings['button_text'] ); ?></a>
                </div>
            <?php endif ?>
		</div>
	</div>