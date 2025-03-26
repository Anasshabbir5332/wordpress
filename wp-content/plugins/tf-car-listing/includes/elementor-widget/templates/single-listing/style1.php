<div class="item">
	<?php
	$latest_post_query       = get_posts( "post_type=listing&post_status=publish&numberposts=1&order=DESC" );
	$latest_post_id          = is_array($latest_post_query) ? $latest_post_query[0]->ID : 0;
	$listing_id              = ! empty( $settings['listing_id'] ) ? $settings['listing_id'] : $latest_post_id;
	$car_regular_price_value = get_post_meta( $listing_id, 'regular_price', true );
	$car_sale_price_value    = get_post_meta( $listing_id, 'sale_price', true );
	$car_price_prefix        = get_post_meta( $listing_id, 'price_prefix', true );
	$car_price_suffix        = get_post_meta( $listing_id, 'price_suffix', true );
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
		$full_name  = $first_name . ' ' . $last_name;
		$position      = get_the_author_meta( 'user_position', $author_id );
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
	<?php if ( 'listing' === get_post_type( $listing_id ) && 'publish' === get_post_status( $listing_id ) ) : ?>
		<div class="listing-post listing-post-<?php echo $listing_id; ?>">
			<div class="content">
				<?php if ( ! empty( $car_body_att ) ) : ?>
					<a href="<?php echo esc_url( get_term_link( $car_body[0] ) ) ?>" class="car-body"><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></a>
				<?php endif; ?>
				<h2 class="title">
					<a href="<?php echo get_the_permalink( $listing_id ); ?>"><?php echo get_the_title( $listing_id ); ?></a>
				</h2>
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

			<div class="bottom-content">
					<div class="avatar-thumb">
						<img alt="<?php echo esc_attr( $full_name ); ?>"
							src="<?php echo esc_attr( tfcl_image_resize_id( $user_avatar, '120', '120', true ) ); ?>"
							onerror="this.src = '<?php echo esc_url( $default_image_src ) ?>';" class="avatar avatar-96 photo"
							loading="lazy">
							<div class="inner">
								<p class="position"><?php echo esc_attr( $position ); ?></p>
								<h6><?php echo esc_attr( $full_name ); ?></h6>
							</div>
						</div>

				<div class="button-details">
					<a href="<?php echo get_the_permalink(); ?>"><?php echo esc_html__( $settings['button_text'] ); ?></a>
				</div>
			</div>

			<div class="inner-bottom">
				<div class="price">
					<?php if ( ! empty( $car_sale_price_value ) ) : ?>
						<span class="inner regular_price">
							<?php if ( ! empty( $car_price_prefix ) ) : ?>
								<?php echo $car_price_prefix; ?>
							<?php endif; ?>
							<?php echo tfcl_format_price( $car_sale_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
							<?php if ( ! empty( $car_price_suffix ) ) : ?>
								<?php echo $car_price_suffix; ?>
							<?php endif; ?>
						</span>
					<?php endif; ?>
					<?php if ( ! empty( $car_regular_price_value ) ) : ?>
						<span class="inner sale_price">
							<?php if ( ! empty( $car_price_prefix ) ) : ?>
								<?php echo $car_price_prefix; ?>
							<?php endif; ?>
							<?php echo tfcl_format_price( $car_regular_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
							<?php if ( ! empty( $car_price_suffix ) ) : ?>
								<?php echo $car_price_suffix; ?>
							<?php endif; ?>
						</span>
					<?php endif; ?>
				</div>
				<?php if ( $settings['enable_compare_listing'] == 'yes' || $settings['enable_favorite_listing'] == 'yes' ) : ?>
				<ul class="list-controller">
				<?php if ( $settings['enable_compare_listing'] == 'yes' ) : ?>
					<li>
						<a class="compare tfcl-compare-listing hv-tool" href="javascript:void(0)"
							data-listing-id="<?php echo esc_attr( intval( $listing_id ) ) ?>" data-toggle="tooltip"
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
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php esc_html_e( 'Sorry! Not found listing.', 'tf-car-listing' ); ?>
	<?php endif; ?>
</div>