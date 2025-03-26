	<?php
	$listing_id              = get_the_ID();

	$measurement_units       = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
	// taxonomy
	$car_fuel_type           = get_the_terms( $listing_id, 'fuel-type', true );
	$car_fuel_type_att       = ! empty( $car_fuel_type[0]->name ) ? $car_fuel_type[0]->name : 'none';
	$car_condition        = get_the_terms( $listing_id, 'condition' );
	$car_condition_att    = ! empty( $car_condition[0]->name ) ? $car_condition[0]->name : '';
	$car_mileage             = get_post_meta( $listing_id, 'mileage', true ) ? get_post_meta( $listing_id, 'mileage', true ) . ' ' . $measurement_units : 0;

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

	?>
	<div class="slider-post listing-post-<?php the_ID(); ?>">
		<div class="content">
			<h1 class="title">
				<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
			</h1>
			<ul class="details-car">
				<li class="listing-information condition">
					<?php echo themesflat_svg('car3'); ?>
						<div class="inner">
							<p><?php echo esc_html( $car_condition_att, 'tf-car-listing' ); ?></p>
						</div>
				</li>
				<li class="listing-information mileages">
					<?php echo themesflat_svg('dashboard3'); ?>
						<div class="inner">
							<p><?php echo esc_html( $car_mileage ); ?></p>
						</div>
				</li>
				<li class="listing-information fuel">
					<?php echo themesflat_svg('price'); ?>
						<div class="inner">
							<p><?php echo esc_html( $car_fuel_type_att, 'tf-car-listing' ); ?></p>
						</div>
				</li>
			</ul>
			<div class="bottom-slider">
					<?php if ( $settings['show_button'] == 'yes' ) : ?>
						<div class="button-details">
							<a href="<?php echo esc_url( $settings['link']['url'] ) ?>"><?php echo esc_attr( $settings['button_text'] ); ?></a>
						</div>
					<?php endif ?>
					<div class="avatar-thumb">
						<img alt="<?php echo esc_attr( $full_name ); ?>"
							src="<?php echo esc_attr( tfcl_image_resize_id( $user_avatar, '50', '50', true ) ); ?>"
							onerror="this.src = '<?php echo esc_url( $default_image_src ) ?>';" class="avatar avatar-96 photo"
							loading="lazy">
							<div class="inner">
								<div class="name"><?php echo esc_attr( $full_name ); ?></div>
								<p class="position"><?php echo esc_attr( $position ); ?></p>
							</div>
						</div>
			</div>
		</div>
	</div>