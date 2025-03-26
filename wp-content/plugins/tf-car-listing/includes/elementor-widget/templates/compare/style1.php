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
	?>
	<div class="compare-item listing-post-<?php the_ID(); ?>">
		<div class="featured-property">
				<a class="view-gallery listing-item" data-mfp-event
					data-gallery="<?php echo esc_attr( json_encode( $car_gallery_images_list ) ); ?>"
					href="<?php echo get_the_permalink(); ?>">
					<?php
					$get_id_post_thumbnail = get_post_thumbnail_id( $listing_id );
					echo sprintf( '<img src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
					?>
				</a>
                <span class="icon-compare">VS</span>
		</div>
		<div class="content">
				<a href="<?php echo esc_url( get_term_link( $car_make[0] ) ) ?>" class="car-body"><?php echo esc_html( $car_make_att, 'tf-car-listing' ); ?></a>
			<h3 class="title">
				<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
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
		</div>
</div>
</div>