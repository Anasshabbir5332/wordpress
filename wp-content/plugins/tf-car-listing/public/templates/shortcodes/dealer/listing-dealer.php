<?php
/**
 * auto load listing of user
 */
$combined_results = $added_post_ids = $data = array();
$dealer_name   = $user_id = $view = '';
$dealer_name   = Dealer_Public::tfcl_get_dealer_info_by_id( $dealer_id )['dealer_name'];
$css_class_col = 'col-md-6 col-xs-12';

$users_with_meta = get_users(
	array(
		'meta_key'     => 'author_dealer_id',
		'meta_value'   => $dealer_id,
		'meta_compare' => '=',
	)
);

if ( ! empty( $users_with_meta ) ) {
	foreach ( $users_with_meta as $user ) {
		$user_id = $user->ID;
	}
}

$item_per_page_archive_listing = -1;
if ( ! empty( $user_id ) ) {
	$args_author  = array(
		'post_type'           => 'listing',
		'post_status'         => 'publish',
		'posts_per_page'      => $item_per_page_archive_listing,
		'offset'              => ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $item_per_page_archive_listing,
		'ignore_sticky_posts' => 1,
		'author'              => $user_id,
	);
	$query_author = new WP_Query( $args_author );

	if ( $query_author->have_posts() ) {
		while ( $query_author->have_posts() ) {
			$query_author->the_post();
			if ( ! in_array( get_the_ID(), $added_post_ids ) ) {
				$combined_results[] = $query_author->post;
				$added_post_ids[]   = get_the_ID();
			}
		}
		wp_reset_postdata();
	}
}

$args_meta_query = array(
	'post_type'           => 'listing',
	'post_status'         => 'publish',
	'posts_per_page'      => $item_per_page_archive_listing,
	'offset'              => ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $item_per_page_archive_listing,
	'ignore_sticky_posts' => 1,
	'meta_query'          => array(
		array(
			'key'     => 'listing_dealer_info',
			'value'   => $dealer_id,
			'compare' => 'IN',
		),
	),
);

$query_meta_query = new WP_Query( $args_meta_query );

if ( $query_meta_query->have_posts() ) {
	while ( $query_meta_query->have_posts() ) {
		$query_meta_query->the_post();
		if ( ! in_array( get_the_ID(), $added_post_ids ) ) {
			$combined_results[] = $query_meta_query->post;
			$added_post_ids[]   = get_the_ID();
		}
	}
	wp_reset_postdata();
}

$selected_order = '';
if ( ! empty( $_REQUEST['orderBy'] ) ) {
	$selected_order = wp_unslash( $_REQUEST['orderBy'] );
	switch ( $selected_order ) {
		case 'name_asc':
			$args['orderby'] = 'title';
			$args['order'] = 'asc';
			break;
		case 'name_esc':
			$args['orderby'] = 'title';
			$args['order'] = 'esc';
			break;
		default:
			$args['orderby'] = 'date';
			$args['order'] = 'esc';
			break;
	}
} else {
	$selected_order = 'date_esc';
}

$width          = $height = 35;
$default_avatar = tfcl_get_option( 'default_user_avatar', '' );
if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
	$no_poster_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
}
$poster_id        = get_post_thumbnail_id( $dealer_id );
$poster_src       = tfcl_image_resize_id( $poster_id, $width, $height, true );
$dealer_permalink = get_post_permalink( $dealer_id );

wp_enqueue_style( 'owl.carousel' );
wp_enqueue_script( 'owl.carousel' );

if ( isset( $_REQUEST['view'] ) && ! empty( $_REQUEST['view'] ) ) {
	$view = $_REQUEST['view'];
}
?>
<div class="tfcl-dealer-listing-shortcode dealer-inventory">
	<?php if ( count( $combined_results ) > 0 ) { ?>
		<div class="dealer-inventory-header">
			<h4 class="tfcl-dealer-inventory-title">
				<?php echo sprintf( '%s (%s)',$heading, count($combined_results)  ); ?>
			</h4>
		</div>
		<div class="dealer-inventory-content">
			<div class="row">
				<?php
				if ( ! empty( $combined_results ) ) {
					foreach ( $combined_results as $post ) {
						setup_postdata( $post );
						$listing_id                  = $post->ID;
						$listing_title               = $post->post_title;
						$listing_regular_price_value = get_post_meta( $post->ID, 'regular_price', true );
						$listing_sale_price_value    = get_post_meta( $post->ID, 'sale_price', true );
						$listing_price_prefix        = get_post_meta( $post->ID, 'price_prefix', true );
						$listing_price_suffix        = get_post_meta( $post->ID, 'price_suffix', true );
						$listing_address             = get_post_meta( $post->ID, 'listing_address', true );
						$listing_date                = get_post_meta( $post->ID, 'year', true );
						$listing_engine_size         = get_post_meta( $post->ID, 'engine_size', true ) ? get_post_meta( $listing_id, 'engine_size', true ) : 0;
						$measurement_units           = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
						$listing_mileage             = get_post_meta( $listing_id, 'mileage', true ) ? get_post_meta( $listing_id, 'mileage', true ) . ' ' . $measurement_units : 0;
						$listing_fuel_type           = get_the_terms( $post->ID, 'fuel-type', true );
						$listing_fuel_type_att       = ! empty( $listing_fuel_type[0]->name ) ? $listing_fuel_type[0]->name : 'no infor';
						$listing_transmission        = get_the_terms( $post->ID, 'transmission' );
						$listing_transmission_att    = ! empty( $listing_transmission[0]->name ) ? $listing_transmission[0]->name : 'no infor';
						$listing_features            = get_the_terms( $post->ID, 'features' );
						$listing_features_att        = ! empty( $listing_features[0]->name ) ? $listing_features[0]->name : '';
						$listing_body                = get_the_terms( $post->ID, 'body', true );
						$listing_body_att            = ! empty( $listing_body[0]->name ) ? $listing_body[0]->name : '';
						$is_featured                 = get_post_meta( $post->ID, 'listing_featured', true );
						$listing_gallery_images      = get_post_meta( $post->ID, 'gallery_images', true ) ? get_post_meta( $post->ID, 'gallery_images', true ) : '';
						$listing_thumb               = tfcl_image_resize_id( get_post_thumbnail_id( $post->ID ), '425', '338', true );
						$listing_gallery_images      = get_sources_listing_gallery_images( $listing_gallery_images );
						$attach_id                   = get_post_thumbnail_id();

						if ( is_array( $listing_gallery_images ) ) {
							if ( attachment_url_to_postid( $listing_thumb ) != attachment_url_to_postid( $listing_gallery_images[0] ) ) {
								array_unshift( $listing_gallery_images, $listing_thumb );
							}
						}

						global $current_user;
						wp_get_current_user();
						$check_is_favorite = false;
						$user_id           = $current_user->ID;
						$my_favorites      = get_user_meta( $user_id, 'favorites_listing', true );
						if ( ! empty( $my_favorites ) ) {
							$check_is_favorite = array_search( $listing_id, $my_favorites );
						}
						$title_not_favorite = $title_favorited = '';
						$icon_favorite     = apply_filters( 'tfcl_icon_favorite', 'far fa-bookmark' );
						$icon_not_favorite = apply_filters( 'tfcl_icon_not_favorite', 'far fa-bookmark' );

						if ( $check_is_favorite !== false ) {
							$css_class    = $icon_favorite;
							$title_action = esc_attr__( 'It is your favorite', 'tf-car-listing' );
						} else {
							$css_class    = $icon_not_favorite;
							$title_action = esc_attr__( 'Add to Favorite', 'tf-car-listing' );
						}

						$data[] = array(
							'listing_id'                  => $listing_id,
							'listing_title'               => $listing_title,
							'listing_permalink'           => get_permalink( $listing_id ),
							'listing_gallery_images'      => $listing_gallery_images,
							'listing_fuel_type_att'       => $listing_fuel_type_att,
							'listing_engine_size'         => $listing_engine_size,
							'listing_mileage'             => $listing_mileage,
							'listing_transmission'        => $listing_transmission,
							'listing_transmission_att'    => $listing_transmission_att,
							'listing_price_prefix'        => $listing_price_prefix,
							'listing_price_suffix'        => $listing_price_suffix,
							'listing_regular_price_value' => $listing_regular_price_value,
							'listing_sale_price_value'    => $listing_sale_price_value,
							'listing_date'                => $listing_date,
							'is_featured'                 => $is_featured,
							'listing_features'            => $listing_features,
							'listing_features_att'        => $listing_features_att,
							'listing_body_att'            => $listing_body_att,
							'check_is_favorite'           => $check_is_favorite,
							'icon_favorite'               => $icon_favorite,
							'icon_not_favorite'           => $icon_not_favorite,
							'title_action'                => $title_action,
							'attach_id'                   => $attach_id,
							'css_class'                   => $css_class,
							'css_class_col'               => $css_class_col
						);

						
							tfcl_get_template_with_arguments( 'listing/card-item-listing.php',
								array(
									'listing_id'    => $listing_id,
									'attach_id'     => $attach_id,
									'css_class_col' => 'col-md-12 style-list'
								)
							);
					}
					wp_reset_postdata();
				}
				?>
			</div>
			<?php if ( count( $combined_results ) > 3 ): ?>
				<div class="view-more-button">
				<?php esc_html_e( 'View all car', 'tf-car-listing' ); ?> <i class="icon-autodeal-icon-166"></i>
			</div>
			<?php endif; ?>
		</div>
	<?php } else {
		$data['message_error'] = esc_html__( 'No data found', 'tf-car-listing' );
	} ?>
</div>