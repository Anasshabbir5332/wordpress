<?php
/**
 * @var $listing_id
 * @var $attach_id
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$measurement_units           = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
$car_regular_price_value     = get_post_meta( $listing_id, 'regular_price', true );
$car_sale_price_value        = get_post_meta( $listing_id, 'sale_price', true );
$car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );
$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
$car_price_prefix            = get_post_meta( $listing_id, 'price_prefix', true );
$car_price_suffix            = get_post_meta( $listing_id, 'price_suffix', true );
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

// Metaboxes
$car_mileage       = get_post_meta($listing_id, 'mileage', true) ? get_post_meta($listing_id, 'mileage', true) . ' ' . $measurement_units : 0;
$car_stock_number  = get_post_meta($listing_id, 'stock_number', true) ?: 0;
$car_vin_number    = get_post_meta($listing_id, 'vin_number', true) ?: 0;
$car_engine_size   = get_post_meta($listing_id, 'engine_size', true) ?: 0;
$car_door          = get_post_meta($listing_id, 'door', true) ?: 0;
$car_seat          = get_post_meta($listing_id, 'seat', true) ?: 0;
$car_city_mpg      = get_post_meta($listing_id, 'city_mpg', true) ?: 0;
$car_highway_mpg   = get_post_meta($listing_id, 'highway_mpg', true) ?: 0;

$car_featured          = get_post_meta($listing_id, 'car_featured', true) ?: false;
$car_date              = get_post_meta($listing_id, 'year', true);
$car_address           = get_post_meta($listing_id, 'listing_address', true);
$car_location          = $listing_id ? get_post_meta($listing_id, 'listing_location', true) : '';
$car_status            = get_post_meta($listing_id, 'car_status', true) ?: false;
$car_status_text       = get_post_meta($listing_id, 'car_status_text', true);
$car_gallery_images    = get_post_meta($listing_id, 'gallery_images', true) ?: '';
$car_gallery_first_image = is_array(json_decode($car_gallery_images)) ? json_decode($car_gallery_images)[0] : '';
$car_gallery_images_list = get_sources_listing_gallery_images($car_gallery_images);
$gallery_thumb         = get_the_post_thumbnail_url($listing_id, 'themesflat-listing-thumbnail');

if (is_array($car_gallery_images_list) && get_post_thumbnail_id($listing_id) != $car_gallery_first_image) {
    array_unshift($car_gallery_images_list, $gallery_thumb);
}

$width          = tfcl_get_option('image_width_listing', 660);
$height         = tfcl_get_option('image_height_listing', 471);
$no_image_src   = tfcl_get_option('default_listing_image', '')['url'] ?: TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
$image_src      = tfcl_image_resize_id($attach_id, $width, $height, true);
$enable_compare = tfcl_get_option('enable_compare', 'y');
$enable_favorite = tfcl_get_option('enable_favorite', 'y');
$class          = isset($class) ? $class : '';

$price_formated = !empty($car_sale_price_value)
    ? tfcl_format_price($car_sale_price_value, $car_price_unit, false, false)
    : tfcl_format_price($car_regular_price_value, $car_price_unit, false, false);

// Dealer
global $post;
$author_id = $post->post_author;
$dealer_id = get_post_meta($listing_id, 'listing_dealer_info', true) ?: get_the_author_meta('author_dealer_id', $author_id);

if (!empty($dealer_id)) {
    $full_name = get_the_title($dealer_id);
    $author_id = get_post_field('post_author', $dealer_id);
} else {
    $first_name = get_the_author_meta('first_name', $author_id);
    $last_name  = get_the_author_meta('last_name', $author_id);
    $full_name  = $first_name . ' ' . $last_name;
}

$user_avatar        = get_the_author_meta('profile_image_id', $author_id);
$no_avatar          = get_avatar_url(get_the_author_meta('ID'));
$default_image_src  = tfcl_get_option('default_user_avatar', '')['url'] ?: $no_avatar;
$featured_map       = $car_featured ? esc_attr('Featured', 'tf-car-listing') : '';
$featured_url       = tfcl_get_permalink('advanced_search_page') ? tfcl_get_permalink('advanced_search_page') . '/?condition=all&enable-search-features=0&featured=true' : '#';
$year_url           = tfcl_get_permalink('advanced_search_page') ? tfcl_get_permalink('advanced_search_page') . "?condition=all&enable-search-features=0&min-year=$car_date&max-year=$car_date" : '#';
?>
<div class="wrap-tfcl-listing-card cards-item <?php echo esc_attr( $css_class_col ); ?> <?php echo ( isset($layout_archive_listing) && $layout_archive_listing == 'list' ? 'style-list' : '' ); ?>"
    data-col="<?php echo esc_attr( $css_class_col ); ?>">
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
            <?php if ( ! empty( $car_body_att ) ) : ?>
            <a href="<?php echo esc_url( get_term_link( $car_body[0] ) ) ?>"
                class="car-body"><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></a>
            <?php endif; ?>
            <h3 class="tfcl-listing-title title">
                <a title="<?php the_title() ?>"
                    href="<?php echo esc_url( get_permalink( $listing_id ) ); ?>"><?php the_title() ?></a>
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
                    <?php if ( ! empty( $car_fuel_type_att ) ) : ?>
                        <li class="listing-information fuel">
                            <?php echo themesflat_svg('fuel'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_fuel_type_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ( tfcl_get_option( 'enable_transmission_listing') == 'y') :?>
                    <?php if ( ! empty( $car_transmission_att ) ) : ?>
                        <li class="listing-information transmission">
                            <?php echo themesflat_svg('transmission2'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_transmission_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ( tfcl_get_option( 'enable_make_listing') == 'y' ) : ?>
                    <?php if ( ! empty( $car_make_att ) ) : ?>
                        <li class="listing-information make">
                            <?php echo themesflat_svg('car'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_make_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ( tfcl_get_option( 'enable_model_listing') == 'y' ) : ?>
                    <?php if ( ! empty($car_model_att ) ) : ?>
                    <li class="listing-information model">
                        <?php echo themesflat_svg('car'); ?>
                        <div class="inner">
                            <p><?php echo esc_html( $car_model_att, 'tf-car-listing' ); ?></p>
                        </div>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ( tfcl_get_option( 'enable_body_listing') == 'y' ) : ?>
                    <?php if ( ! empty( $car_body_att ) ) : ?>
                        <li class="listing-information body">
                            <?php echo themesflat_svg('car'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_body_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
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
                    <?php if ( ! empty( $car_drive_type_att ) ) : ?>
                        <li class="listing-information drive-type">
                            <?php echo themesflat_svg('drive'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_drive_type_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
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
                    <?php if ( ! empty( $car_cylinders_att ) ) : ?>
                        <li class="listing-information cylinders">
                            <?php echo themesflat_svg('cylinder'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_cylinders_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
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
                    <?php if ( ! empty( $car_car_color_att ) ) : ?>
                        <li class="listing-information color">
                            <?php echo themesflat_svg('color'); ?>
                            <div class="inner">
                                <p><?php echo esc_html( $car_car_color_att, 'tf-car-listing' ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>
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
                        class="avatar avatar-96 photo" loading="lazy"><span><?php echo esc_attr( $full_name ); ?></span>
                </div>
                <?php endif; ?>

                <div class="button-details">
                    <a title="<?php the_title() ?>" href="<?php echo esc_url( get_permalink( $listing_id ) ); ?>"
                        class="btn-listing"><?php echo esc_html(tfcl_get_option( 'text_card_button', 'View Details')) ?>
                        <i class="icon-autodeal-readmore"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>