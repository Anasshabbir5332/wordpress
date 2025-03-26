<?php
/**
 * @var $current_listing_id
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_script( 'related-listings' );

$condition     = get_the_terms( $current_listing_id, 'condition' );
$body          = get_the_terms( $current_listing_id, 'body' );
$make          = get_the_terms( $current_listing_id, 'make' );
$model         = get_the_terms( $current_listing_id, 'model' );
$transmission  = get_the_terms( $current_listing_id, 'transmission' );
$cylinders     = get_the_terms( $current_listing_id, 'cylinders' );
$drive_type    = get_the_terms( $current_listing_id, 'drive-type' );
$fuel_type     = get_the_terms( $current_listing_id, 'fuel-type' );
$color         = get_the_terms( $current_listing_id, 'car-color' );
$features      = get_the_terms( $current_listing_id, 'features' );
$features_type = get_the_terms( $current_listing_id, 'features-type' );

// Options related listings
$heading             = tfcl_get_option( 'heading_related_listing', 'Featured listings' );
$description         = tfcl_get_option( 'description_related_listing', '' );
$related_by_taxonomy = tfcl_get_option( 'related_by_taxonomy', 'condition' );
$item_per_page       = tfcl_get_option( 'item_per_page_related_listing', 6 );
$loop                = tfcl_get_option( 'enable_loop_related_listing', 0 ) == 1 ? true : false;
$auto_loop           = tfcl_get_option( 'enable_auto_loop_related_listing', 0 ) == 1 ? true : false;
$bullets             = tfcl_get_option( 'enable_bullets_related_listing', 1 ) == 1 ? true : false;
$spacing             = tfcl_get_option( 'spacing_related_listing', 30 );
$column_desk         = tfcl_get_option( 'carousel_column_desk_related_listing', 3 );
$column_laptop       = tfcl_get_option( 'carousel_column_laptop_related_listing', 3 );
$column_tablet       = tfcl_get_option( 'carousel_column_tablet_related_listing', 2 );
$column_mobile       = tfcl_get_option( 'carousel_column_mobile_related_listing', 1 );

$args           = array(
	'posts_per_page'      => $item_per_page,
	'post__not_in'        => array( $current_listing_id ),
	'post_type'           => 'listing',
	'orderby'             => array(
		'date' => 'DESC',
	),
	'offset'              => ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $item_per_page,
	'ignore_sticky_posts' => 1,
	'post_status'         => 'publish',
);
$taxonomy_query = array();

function get_array_terms_value( $array_terms ) {
	$array_terms_value = array();
	if($array_terms){
		foreach ( $array_terms as $term ) {
			array_push( $array_terms_value, $term->slug );
		}
	}
	return $array_terms_value;
}

switch ( $related_by_taxonomy ) {
	case 'condition':
		$taxonomy_query[] = array(
			'taxonomy' => 'condition',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $condition )
		);
		break;
	case 'body':
		$taxonomy_query[] = array(
			'taxonomy' => 'body',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $body )
		);
		break;
	case 'make':
		$taxonomy_query[] = array(
			'taxonomy' => 'make',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $make )
		);
		break;
	case 'model':
		$taxonomy_query[] = array(
			'taxonomy' => 'model',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $model )
		);
		break;
	case 'transmission':
		$taxonomy_query[] = array(
			'taxonomy' => 'transmission',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $transmission )
		);
		break;
	case 'cylinders':
		$taxonomy_query[] = array(
			'taxonomy' => 'cylinders',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $cylinders )
		);
		break;
	case 'drive-type':
		$taxonomy_query[] = array(
			'taxonomy' => 'drive-type',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $drive_type )
		);
		break;
	case 'fuel-type':
		$taxonomy_query[] = array(
			'taxonomy' => 'fuel-type',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $fuel_type )
		);
		break;
	case 'car-color':
		$taxonomy_query[] = array(
			'taxonomy' => 'car-color',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $color )
		);
		break;
	case 'features-type':
		$taxonomy_query[] = array(
			'taxonomy' => 'features-type',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $features_type )
		);
		break;
	case 'features':
		$taxonomy_query[] = array(
			'taxonomy' => 'features',
			'field'    => 'slug',
			'terms'    => get_array_terms_value( $features )
		);
		break;
	default:
		# code...
		break;
}

$args['tax_query'] = array(
	'relation' => 'AND',
	$taxonomy_query
);
$query             = new WP_Query( $args );
?>
<div class="related-listings row col-desk-<?php echo esc_attr( $column_desk ); ?>">
	<h2 class="heading"><?php esc_html_e( $heading, 'tf-car-listing' ); ?></h2>
		<?php if ( !empty($description) ) :?>
			<div class="description">
				<p><?php esc_html_e( $description, 'tf-car-listing' ); ?></p>
			</div>
		<?php endif; ?>
	<div class="owl-carousel" data-loop="<?php echo esc_attr( $loop ); ?>"
		data-auto="<?php echo esc_attr( $auto_loop ); ?>" data-desk="<?php echo esc_attr( $column_desk ); ?>"
		data-laptop="<?php echo esc_attr( $column_laptop ); ?>" data-tablet="<?php echo esc_attr( $column_tablet ); ?>"
		data-mobile="<?php echo esc_attr( $column_mobile ); ?>" data-arrow="false"
		data-spacing="<?php echo esc_attr( $spacing ) ?>" data-bullets="<?php echo esc_attr( $bullets ) ?>">
		<?php if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();
				$listing_id      = get_the_ID();
				$attach_id       = get_post_thumbnail_id();
				$class_image_map = 'tfcl-image-map';
				$css_class_col   = 'col-sm-12';
				tfcl_get_template_with_arguments(
					'listing/card-item-listing.php',
					array(
						'listing_id'      => $listing_id,
						'attach_id'       => $attach_id,
						'class_image_map' => $class_image_map,
						'css_class_col'   => $css_class_col
					)
				);
				?>
			<?php endwhile; 
				wp_reset_postdata();
			?>
			
		<?php else : ?>
			<div class="item-not-found"><?php esc_html_e( 'No item found', 'tf-car-listing' ); ?></div>
		<?php endif; ?>
	</div>
</div>
<?php
tfcl_get_template_with_arguments( 'global/listing-quick-view-modal.php', array() );