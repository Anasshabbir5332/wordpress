<?php
wp_enqueue_style( 'select2' );
wp_enqueue_script( 'select2' );
wp_enqueue_style( 'mapbox-gl' );
wp_enqueue_script( 'mapbox-gl' );
wp_enqueue_style( 'mapbox-gl-geocoder' );
wp_enqueue_script( 'mapbox-gl-geocoder' );
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
wp_enqueue_style( 'shortcode-listing-css' );
/**
 * @var $listing_id
 * @var $mode
 * @var $action
 * @var $submit_button_text
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}

$tfcl_allow_submit_listing = tfcl_allow_submit_listing();
if ( ! $tfcl_allow_submit_listing ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_allow_submit_listing' ) );
	return;
}

global $listing_data, $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
if ( $mode == 'listing-edit' ) {
	$listing_data = get_post( $listing_id );
	if ( $user_id != 1 && $listing_data->post_author != $user_id ) {
		tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_permission' ) );
		return;
	}
} else {
	$check_package_available = User_Package_Public::tfcl_check_user_package_available( $user_id );
	if ( $check_package_available == 0 || $check_package_available == -1 || $check_package_available == -2 ) {
		tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'check_user_package_available', 'check_package_available' => $check_package_available ) );
		return;
	}
}
$panels = tfcl_get_option( 'add_listing_panels_manager', array( 'upload-media' => 1, 'information' => 1, 'price' => 1, 'amenities' => 1, 'location' => 1, 'video' => 1, 'file-attachment' => 1 ) );
$keys   = array_keys( $panels );
?>

<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit_listing_form" class="tfcl-listing-form tfcl-save-listing"
	enctype="multipart/form-data">
	<div class="tfcl_message"></div>
	<h1 class="tfcl-add-listing-title"><?php esc_html_e( 'Add listing', 'tf-car-listing' ); ?></h1>
	<?php foreach ( $panels as $key => $value ) { ?>
		<?php if ( $panels[ $key ] == 1 ) : ?>
			<fieldset id="<?php echo esc_attr( $key ); ?>">
				<?php
				tfcl_get_template_with_arguments( 'listing/listing-template-parts/' . $key . '.php', array( 'listing_data' => $listing_data ) ); ?>
			</fieldset>
		<?php endif; ?>
	<?php } ?>
	<button type="submit" class="button button-save-listing btn-big-spacing">
		<span><?php echo $submit_button_text; ?></span>
	</button>
	<input type="hidden" name="listing_mode" value="<?php echo esc_attr( $mode ); ?>" />
	<input type="hidden" name="listing_id" value="<?php echo esc_attr( $listing_id ); ?>" />
	<?php if ( $mode == 'listing-edit' ) : ?>
		<input type="hidden" name="listing_author" value="<?php echo esc_attr( $listing_data->post_author ); ?>" />
	<?php endif; ?>
</form>