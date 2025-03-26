<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
$prop_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
?>
<div class="tfcl_message"></div>
<h1 class="admin-title favorite"><?php esc_html_e( 'My favorite', 'tf-car-listing' ); ?></h1>
<div class="tfcl-favorite-page">

        <?php if ( ! $favorites ) : ?>
			<p class="no-listing-found"><?php esc_html_e( 'You don\'t have any favorites.', 'tf-car-listing' ); ?></p>
        <?php else : ?>
	<?php echo sprintf( __('<div class="count-favorite"><b>%d</b> Car listing </div>', 'tf-car-listing'), count($favorites)) ?>
	<div class="inner-card">
        <?php foreach ( $favorites as $favorite ) : ?>
                <?php
						$listing_id = $favorite->ID;
						$measurement_units           = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
						$car_regular_price_value     = get_post_meta( $favorite->ID, 'regular_price', true );
						$car_sale_price_value        = get_post_meta( $favorite->ID, 'sale_price', true );
						$car_price_unit              = get_post_meta( $favorite->ID, 'listing_price_unit', true );
						$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
						$car_price_prefix            = get_post_meta( $favorite->ID, 'price_prefix', true );
						$car_price_suffix            = get_post_meta( $favorite->ID, 'price_suffix', true );
                        $car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
						
						
						// taxonomy
						$car_fuel_type           = get_the_terms( $favorite->ID, 'fuel-type', true );
						$car_fuel_type_att       = ! empty( $car_fuel_type[0]->name ) ? $car_fuel_type[0]->name : 'none';
						$car_body                = get_the_terms( $favorite->ID, 'body', true );
						$car_body_att            = ! empty( $car_body[0]->name ) ? $car_body[0]->name : '';
						$car_transmission        = get_the_terms( $favorite->ID, 'transmission' );
						$car_transmission_att    = ! empty( $car_transmission[0]->name ) ? $car_transmission[0]->name : 'none';
						$car_make        = get_the_terms( $favorite->ID, 'make' );
						$car_make_att    = ! empty( $car_make[0]->name ) ? $car_make[0]->name : 'none';
						$car_model        = get_the_terms( $favorite->ID, 'model' );
						$car_model_att    = ! empty( $car_model[0]->name ) ? $car_model[0]->name : 'none';
						$car_body        = get_the_terms( $favorite->ID, 'body' );
						$car_body_att    = ! empty( $car_body[0]->name ) ? $car_body[0]->name : 'none';
						$car_drive_type        = get_the_terms( $favorite->ID, 'drive-type' );
						$car_drive_type_att    = ! empty( $car_drive_type[0]->name ) ? $car_drive_type[0]->name : 'none';
						$car_cylinders        = get_the_terms( $favorite->ID, 'cylinders' );
						$car_cylinders_att    = ! empty( $car_cylinders[0]->name ) ? $car_cylinders[0]->name : 'none';
						$car_car_color        = get_the_terms( $favorite->ID, 'car-color' );
						$car_car_color_att    = ! empty( $car_car_color[0]->name ) ? $car_car_color[0]->name : 'none';
						
						// metaboxes
						$car_mileage             = get_post_meta( $favorite->ID, 'mileage', true ) ? get_post_meta( $favorite->ID, 'mileage', true ) . ' ' . $measurement_units : 0;
						$car_stock_number             = get_post_meta( $favorite->ID, 'stock_number', true ) ? get_post_meta( $favorite->ID, 'stock_number', true ) : 0;
						$car_vin_number             = get_post_meta( $favorite->ID, 'vin_number', true ) ? get_post_meta( $favorite->ID, 'vin_number', true ) : 0;
						$car_engine_size             = get_post_meta( $favorite->ID, 'engine_size', true ) ? get_post_meta( $favorite->ID, 'engine_size', true ) : 0;
						$car_door             = get_post_meta( $favorite->ID, 'door', true ) ? get_post_meta( $favorite->ID, 'door', true ) : 0;
						$car_seat             = get_post_meta( $favorite->ID, 'seat', true ) ? get_post_meta( $favorite->ID, 'seat', true ) : 0;
						$car_city_mpg             = get_post_meta( $favorite->ID, 'city_mpg', true ) ? get_post_meta( $favorite->ID, 'city_mpg', true ) : 0;
						$car_highway_mpg             = get_post_meta( $favorite->ID, 'highway_mpg', true ) ? get_post_meta( $favorite->ID, 'highway_mpg', true ) : 0;
						
						$car_featured                = get_post_meta( $favorite->ID, 'car_featured', true ) ? get_post_meta( $favorite->ID, 'car_featured', true ) : false;
						$car_date                    = get_post_meta( $favorite->ID, 'year', true );
						$car_address                 = get_post_meta( $favorite->ID, 'listing_address', true );
						$car_location                = $favorite->ID ? get_post_meta( $favorite->ID, 'listing_location', true ) : '';
						$car_status                  = get_post_meta( $favorite->ID, 'car_status', true ) ? get_post_meta( $favorite->ID, 'car_status', true ) : false;
						$car_status_text             = get_post_meta( $favorite->ID, 'car_status_text', true );
						$car_gallery_images          = get_post_meta( $favorite->ID, 'gallery_images', true ) ? get_post_meta( $favorite->ID, 'gallery_images', true ) : '';
						$car_gallery_first_image     = is_array( json_decode( $car_gallery_images ) ) ? json_decode( $car_gallery_images )[0] : '';
						$car_gallery_images_list     = get_sources_listing_gallery_images( $car_gallery_images );
						$gallery_thumb               = get_the_post_thumbnail_url( $favorite->ID, 'themesflat-listing-thumbnail' );
						
						if ( is_array( $car_gallery_images_list ) ) {
							if ( get_post_thumbnail_id( $favorite->ID ) != $car_gallery_first_image ) {
								array_unshift( $car_gallery_images_list, $gallery_thumb );
							}
						}
						$attach_id = get_post_thumbnail_id( $listing_id );
						$width           = tfcl_get_option( 'image_width_listing', 660 );
						$height          = tfcl_get_option( 'image_height_listing', 471 );
						$no_image_src    = tfcl_get_option( 'default_listing_image', '' )['url'] != '' ? tfcl_get_option( 'default_listing_image', '' )['url'] : TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
						$image_src       = tfcl_image_resize_id( $attach_id, $width, $height, true );
						$enable_compare  = tfcl_get_option( 'enable_compare', 'y' );
						$enable_favorite = tfcl_get_option( 'enable_favorite', 'y' );
						$class           = isset( $class ) ? $class : '';
						
						$price_formated = '';
						if ( ! empty( $car_sale_price_value ) ) {
							$price_formated = tfcl_format_price( $car_sale_price_value, $car_price_unit, false, false );
						} else {
							$price_formated = tfcl_format_price( $car_regular_price_value, $car_price_unit, false, false );
						}
						// dealer
						global $post;
						$author_id  = $post->post_author;
						$dealer_id  = ! empty( get_post_meta( $favorite->ID, 'listing_dealer_info', true ) ) ? get_post_meta( $favorite->ID, 'listing_dealer_info', true ) : get_the_author_meta( 'author_dealer_id', $author_id );
						if ( isset( $dealer_id ) && ! empty( $dealer_id ) ) {
							$full_name             = get_the_title( $dealer_id );
							$author_id             = get_post_field( 'post_author', $dealer_id );
						} else {
							$first_name = get_the_author_meta( 'first_name', $author_id );
							$last_name  = get_the_author_meta( 'last_name', $author_id );
							$full_name  = $first_name . ' ' . $last_name;
						}
						$user_avatar = get_the_author_meta( 'profile_image_id', $author_id );
						$no_avatar            = get_avatar_url( get_the_author_meta( 'ID' ) );
						$default_image_src    = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : $no_avatar;
						$featured_map = $car_featured == true ? esc_attr( 'Featured', 'tf-car-listing' ) : '';
                        $featured_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' ).'/?condition=all&enable-search-features=0&featured=true' : '#';
	$year_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' )."?condition=all&enable-search-features=0&min-year=".$car_date."&max-year=".$car_date."" : '#';

				?>
                	<div class="tfcl-listing-card">
                	    <div class="featured-property tfcl-image-map" title="<?php the_title() ?>"
                        data-image="<?php echo esc_url( $image_src ? $image_src : $no_image_src ) ?>"
                        data-id="<?php echo esc_attr( $listing_id ) ?>"
                        data-location="<?php echo esc_attr( ! empty( $car_address ) ? $car_address : '' ); ?>"
                        data-featured="<?php echo $featured_map; ?>" data-year="<?php echo esc_attr( $car_date ); ?>"
                        data-condition="<?php echo esc_attr( $car_body_att, 'tf-car-listing' ); ?>"
                        data-mileage="<?php echo esc_html( $car_mileage ); ?>"
                        data-fuel="<?php echo esc_html( $car_fuel_type_att ); ?>"
                        data-trans="<?php echo esc_html( $car_transmission_att ); ?>"
                        data-price-prefix="<?php echo esc_attr( $car_price_prefix ); ?>"
                        data-price-suffix="<?php echo esc_attr( $car_price_suffix ); ?>"
                        data-price="<?php echo esc_attr( $price_formated ); ?>">
                        <?php
										$actions              = array( 'id' => 'remove', 'label' => __( 'Remove', 'tf-car-listing' ), 'tooltip' => __( 'Remove Favorite', 'tf-car-listing' ), 'nonce' => true, 'confirm' => esc_html__( 'Are you sure you want to remove this favorite?', 'tf-car-listing' ) );
										$my_listing_page_link = tfcl_get_permalink( 'my_listing_page' );
										$action_url           = add_query_arg( array( 'action' => $actions, 'listing_id' => $favorite->ID ), $my_listing_page_link );
										if ( $actions['nonce'] ) {
											$action_url = wp_nonce_url( $action_url, 'tfcl_my_favorite_actions' );
										}
										?>
										<a href="javascript:void(0)"
											data-tfcl-car-id="<?php echo esc_attr( intval( $favorite->ID ) ) ?>"
											data-toggle="tooltip" data-placement="bottom"
											data-tooltip="<?php echo esc_attr( $actions['tooltip'] ); ?>"
											class="tfcl-favorite-remove hv-tool tfcl-dashboard-action-<?php echo esc_attr( $actions['id'] ); ?>">
											<i class="fas fa-trash"></i>
										</a>
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
                                <?php if ( tfcl_get_option( 'enable_counter_gallery') == 'y' ) : ?>
                                <?php if ( is_array( $car_gallery_images_list ) ) : ?>
                                <span class="count-list-gallery view-gallery" data-mfp-event
                                    data-gallery="<?php echo esc_attr( json_encode( $car_gallery_images_list ) ); ?>"><i
                                        class="icon-autodeal-image"></i><?php echo esc_html( count( $car_gallery_images_list ) ); ?></span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <?php if ( tfcl_get_option( 'enable_year_listing') == 'y' ) : ?>
                            <?php if ( ! empty( $car_date ) ) : ?>
								<a href="<?php echo esc_url($year_url); ?>" target="_blank"><span class="date-car"><?php echo esc_html( $car_date ); ?></span></a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="listing-images">
                            <a class="view-gallery image-item" href="<?php echo get_the_permalink(); ?>">
                                <?php
								$get_id_post_thumbnail = get_post_thumbnail_id( $listing_id );
								echo sprintf( '<img src="%s" alt="image">', empty( $get_id_post_thumbnail ) ? TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image-314-225.jpg" : tfcl_image_resize_id( $get_id_post_thumbnail, $width, $height, true ) );
								?>
                            </a>
                        </div>
                	    </div>
                	    <div class="card-content content">
                        <h3 class="tfcl-listing-title title">
                            <a
                                href="<?php echo esc_url(get_permalink($favorite->ID)); ?>"><?php echo esc_html($favorite->post_title); ?></a>
                        </h3>
                        <ul class="infor-description description">
                            <?php if ( tfcl_get_option( 'enable_mileages_listing') == 'y') :?>
                            <li class="listing-information mileages">
                                <?php echo themesflat_svg('dashboard'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_mileage ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y') :?>
                            <li class="listing-information fuel">
                                <?php echo themesflat_svg('fuel'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_fuel_type_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_transmission_listing') == 'y') :?>
                            <li class="listing-information transmission">
                                <?php echo themesflat_svg('transmission2'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_transmission_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_make_listing') == 'y' ) : ?>
                            <li class="listing-information make">
                                <?php echo themesflat_svg('car'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_make_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_model_listing') == 'y' ) : ?>
                            <li class="listing-information model">
                                <?php echo themesflat_svg('car'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_model_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_body_listing') == 'y' ) : ?>
                            <li class="listing-information body">
                                <?php echo themesflat_svg('car'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_stock_number_listing') == 'y' ) : ?>
                            <li class="listing-information stock-number">
                                <?php echo themesflat_svg('checklist'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_stock_number, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_vin_number_listing') == 'y' ) : ?>
                            <li class="listing-information vin-number">
                                <?php echo themesflat_svg('checklist'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_vin_number, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_drive_listing') == 'y' ) : ?>
                            <li class="listing-information drive-type">
                                <?php echo themesflat_svg('drive'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_drive_type_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_engine_listing') == 'y' ) : ?>
                            <li class="listing-information engine">
                                <?php echo themesflat_svg('engine'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_engine_size, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_cylinders_listing') == 'y' ) : ?>
                            <li class="listing-information cylinders">
                                <?php echo themesflat_svg('cylinder'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_cylinders_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_door_listing') == 'y' ) : ?>
                            <li class="listing-information door">
                                <?php echo themesflat_svg('door'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_door, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_color_listing') == 'y' ) : ?>
                            <li class="listing-information color">
                                <?php echo themesflat_svg('color'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_car_color_att, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_seat_listing') == 'y' ) : ?>
                            <li class="listing-information seat">
                                <?php echo themesflat_svg('seat'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_seat, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_city_mpg_listing') == 'y' ) : ?>
                            <li class="listing-information city-mpg">
                                <?php echo themesflat_svg('performance'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_city_mpg, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( tfcl_get_option( 'enable_highway_mpg_listing') == 'y' ) : ?>
                            <li class="listing-information highway-mpg">
                                <?php echo themesflat_svg('performance'); ?>
                                <div class="inner">
                                    <p><?php echo esc_html( $car_highway_mpg, 'tf-car-listing' ); ?></p>
                                </div>
                            </li>
                            <?php endif; ?>
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
                        <div class="bottom-content">
                        <?php if ( tfcl_get_option( 'enable_author_listing') == 'y' ) : ?>
                            <div class="avatar-thumb">
                                <img alt="<?php echo esc_attr( $full_name ); ?>"
                                    src="<?php echo esc_attr( tfcl_image_resize_id( $user_avatar, '50', '50', true ) ); ?>"
                                    onerror="this.src = '<?php echo esc_url( $default_image_src ) ?>';"
                                    class="avatar avatar-96 photo"
                                    loading="lazy"><span><?php echo esc_attr( $full_name ); ?></span>
                            </div>
                            <?php endif; ?>


                            <div class="button-details">
                                <a title="<?php the_title() ?>"
                                    href="<?php echo esc_url( get_permalink( $listing_id ) ); ?>"
                                    class="btn-listing"><?php echo esc_html(tfcl_get_option( 'text_card_button', 'View Details')) ?>
                                    <i class="icon-autodeal-readmore"></i></a>
                            </div>
                        </div>
                	    </div>
                	</div>
                <?php endforeach; ?>
			</div>
			<?php tfcl_get_template_with_arguments( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
			<?php endif; ?>
</div>