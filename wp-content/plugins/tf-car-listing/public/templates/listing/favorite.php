<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $current_user;
wp_get_current_user();
$check_is_favorite = false;
$user_id           = $current_user->ID;
$my_favorites      = get_user_meta( $user_id, 'favorites_listing', true );

$listing_id = get_the_ID();
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
<a href="javascript:void(0)"
	class="tfcl-listing-favorite hv-tool <?php esc_attr_e( $check_is_favorite !== false ? 'active' : '' ); ?>"
	data-tfcl-car-id="<?php echo esc_attr( intval( $listing_id ) ) ?>" data-toggle="tooltip"
	data-tooltip="<?php echo $title; ?>"
	data-tfcl-title-not-favorite="<?php esc_attr_e( 'Add to Favorite', 'tf-car-listing' ) ?>"
	data-tfcl-title-favorited="<?php esc_attr_e( 'It is your favorite', 'tf-car-listing' ); ?>"
	data-tfcl-icon-not-favorite="<?php echo esc_attr( $icon_not_favorite ) ?>"
	data-tfcl-icon-favorited="<?php echo esc_attr( $icon_favorite ) ?>"><i class="<?php echo esc_attr( $css_class ); ?>"
		aria-hidden="true"></i></a>