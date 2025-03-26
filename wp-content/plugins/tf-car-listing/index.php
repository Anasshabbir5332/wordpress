<?php

/*

Plugin Name: TF Car Listing

Description: Manage car listing

Author: Themesflat

Text Domain: tf-car-listing

Version: 1.0

*/


if ( ! defined( 'WPINC' ) ) {
	die;
}

// Global PATH
if ( ! defined( 'TF_THEME_PATH' ) ) {
	define( 'TF_THEME_PATH', dirname( __FILE__ ) . '/public/templates' );
}

if ( ! defined( 'TF_PLUGIN_PROTOCOL' ) ) {
	define( 'TF_PLUGIN_PROTOCOL', ( is_ssl() ) ? 'https' : 'http' );
}

if ( ! defined( 'TF_PLUGIN_PATH' ) ) {
	$plugin_dir = plugin_dir_path( __FILE__ );
	define( 'TF_PLUGIN_PATH', $plugin_dir );
}

if ( ! defined( 'TF_PLUGIN_URL' ) ) {
	$plugin_url = plugins_url( '/', __FILE__ );
	define( 'TF_PLUGIN_URL', $plugin_url );
}

if ( ! defined( 'TF_AJAX_URL' ) ) {
	$ajax_url = admin_url( 'admin-ajax.php' );
	define( 'TF_AJAX_URL', $ajax_url );
}

// Init helper functions
require_once( TF_PLUGIN_PATH . 'includes/helper.php' );

// Init Loader hooks
require_once( TF_PLUGIN_PATH . 'includes/class-loader.php' );
$loader = new Loader();

function tfcl_register_sidebar() {
	register_sidebar( array(
		'name'          => __( 'Sidebar Single Dealer', 'tf-car-listing' ),
		'id'            => 'single-dealer-sidebar',
		'description'   => __( 'Sidebar widgets in this single dealer page.', 'tf-car-listing' ),
		'before_widget' => '<ul class="tfcl-sidebar"><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Archive Dealer', 'tf-car-listing' ),
		'id'            => 'archive-dealer-sidebar',
		'description'   => __( 'Sidebar widgets in this archive dealer page.', 'tf-car-listing' ),
		'before_widget' => '<ul class="tfcl-sidebar"><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Themesflat Custom Listing Sidebar', 'tf-car-listing' ),
		'id'            => 'themesflat-custom-listing-sidebar',
		'description'   => __( 'Sidebar contains widgets to display customizations to pages.', 'tf-car-listing' ),
		'before_widget' => '<ul class="tfcl-sidebar"><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Single Listing', 'tf-car-listing' ),
		'id'            => 'single-listing-sidebar',
		'description'   => __( 'Sidebar contains widgets to display customizations to pages.', 'tf-car-listing' ),
		'before_widget' => '<ul class="tfcl-single-listing-sidebar"><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Archive Listing', 'tf-car-listing' ),
		'id'            => 'archive-listing-sidebar',
		'description'   => __( 'Sidebar widgets in this archive listing page.', 'tf-car-listing' ),
		'before_widget' => '<ul class="tfcl-sidebar"><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar Seller', 'tf-car-listing' ),
		'id'            => 'seller-sidebar',
		'description'   => __( 'Sidebar widgets in this seller page.', 'tf-car-listing' ),
		'before_widget' => '<ul class="tfcl-sidebar"><li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li></ul>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

// Activation plugin 
function tfcl_image_size_setup() {
	add_image_size( 'themesflat-listing-thumbnail', 660, 471, true ); // (cropped)
	add_image_size( 'themesflat-listing-thumbnail-vertical', 471, 660, true ); // (cropped)
}

add_action( 'after_setup_theme', 'tfcl_image_size_setup' );

function tfcl_activation() {
	require_once( TF_PLUGIN_PATH . '/includes/class-activation.php' );
	Activation::activate();
	add_action( 'widgets_init', 'tfcl_register_sidebar' );
}

register_activation_hook( __FILE__, 'tfcl_activation' );

add_action( 'after_setup_theme', 'tfcl_activation', 5 );

// Deactivation plugin 
function tfcl_deactivation() {

	require_once( TF_PLUGIN_PATH . '/includes/class-deactivation.php' );

	Deactivation::deactivate();

}

register_deactivation_hook( __FILE__, 'tfcl_deactivation' );

// Admin enqueue common styles and scripts
function tfcl_add_admin_styles() {
	if ( tfcl_get_option( "map_service" ) == 'map-box' ) {
		wp_enqueue_style( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css', array(), '2.15.0' );

		wp_enqueue_style( 'mapbox-gl-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css', array(), '5.0.0' );
	}
	wp_enqueue_style( 'jquery-ui', TF_PLUGIN_URL . 'admin/assets/css/jquery-ui.min.css' );
	wp_enqueue_style( 'main', TF_PLUGIN_URL . 'admin/assets/css/main.css' );
	wp_enqueue_style( 'wp-color-picker' );
}

add_action( 'admin_enqueue_scripts', 'tfcl_add_admin_styles' );

function tfcl_add_admin_script() {
	global $typenow;
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
	wp_enqueue_script( 'jquery-ui', TF_PLUGIN_URL . 'admin/assets/js/jquery-ui.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'controls', TF_PLUGIN_URL . '/admin/assets/js/controls.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'admin-main', TF_PLUGIN_URL . '/admin/assets/js/main.js', array( 'wp-color-picker', 'jquery-ui-tabs' ), false, true );
	$tfcl_main_vars = array(
		'ajax_url'           => TF_AJAX_URL,
		'confirm_reset_text' => __( 'Are you sure?', 'tf-car-listing' ),
		'post_type_now'      => $typenow,
	);
	wp_localize_script( 'admin-main', 'tfcl_main_vars', $tfcl_main_vars );

	// Google map api
	if ( tfcl_get_option( "map_service" ) == 'google-map' ) {
		$api_key        = tfcl_get_option( 'google_map_api_key', 'AIzaSyBtUFP8EwyrVM8aOMNahK3619QG5ikA83A' );
		$google_map_url = 'https://maps.googleapis.com/maps/api/js?key=' . $api_key;
		wp_enqueue_script( 'google_map_api', esc_url_raw( $google_map_url ), array(), false, true );
		wp_enqueue_script( 'google_map', esc_url_raw( TF_PLUGIN_URL . '/admin/assets/js/google-map.js' ), array(), false, true );
	}

	// Mapbox api
	if ( tfcl_get_option( "map_service" ) == 'map-box' ) {
		wp_enqueue_script( 'mapbox-gl', esc_url_raw( 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js' ), array(), '2.15.0', true );
		wp_enqueue_script( 'mapbox-gl-geocoder', esc_url_raw( 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js' ), array(), '5.0.0', true );
		wp_enqueue_script( 'map-box-script', esc_url_raw( TF_PLUGIN_URL . '/admin/assets/js/map-box.js' ), array( 'jquery' ), false, true );
		$map_box_variables = array(
			'plugin_url'           => TF_PLUGIN_URL,
			'ajax_url'             => TF_AJAX_URL,
			'map_service'          => tfcl_get_option( 'map_service' ),
			'api_key_google_map'   => tfcl_get_option( 'google_map_api_key' ),
			'api_key_map_box'      => tfcl_get_option( 'map_box_api_key' ),
			'map_zoom'             => tfcl_get_option( 'map_zoom' ),
			'default_marker_image' => tfcl_get_option( 'default_marker_image' )['url'] != '' ? tfcl_get_option( 'default_marker_image' )['url'] : '',
			'marker_image_width'   => tfcl_get_option( 'marker_image_width' ) != '' ? tfcl_get_option( 'marker_image_width' ) : '90px',
			'marker_image_height'  => tfcl_get_option( 'marker_image_height' ) != '' ? tfcl_get_option( 'marker_image_height' ) : '119px',
		);
		wp_localize_script( 'map-box-script', 'map_box_variables', $map_box_variables );
	}
}

add_action( 'admin_enqueue_scripts', 'tfcl_add_admin_script' );

// Enqueue common public styles and scripts
function tfcl_add_public_styles() {
	wp_register_style( 'select2', TF_PLUGIN_URL . 'public/assets/third-party/select2/css/select2.min.css', array(), null, 'all' );
	wp_enqueue_style( 'bootstrap', TF_PLUGIN_URL . 'public/assets/third-party/bootstrap/css/bootstrap.min.css', array(), '4.6.2' );
	wp_enqueue_style( 'jquery-ui', TF_PLUGIN_URL . 'public/assets/third-party/jquery-ui/jquery-ui.min.css', array(), '1.11.4', 'all' );
	
	if ( tfcl_get_option( "map_service" ) == 'map-box' ) {
		wp_register_style( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css', array(), '2.15.0' );
		wp_register_style( 'mapbox-gl-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css', array(), '5.0.0' );
	}

	wp_register_style( 'map-styles', TF_PLUGIN_URL . 'public/assets/css/map.css' );
	wp_register_style( 'bootstrap-datepicker', TF_PLUGIN_URL . 'public/assets/third-party/bootstrap-datepicker/css/bootstrap-datepicker.min.css', array(), 'v1.9.0' );
}

add_action( 'wp_enqueue_scripts', 'tfcl_add_public_styles' );

function tfcl_add_public_script() {
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_register_script( 'select2', TF_PLUGIN_URL . 'public/assets/third-party/select2/js/select2.full.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'nice-select', TF_PLUGIN_URL . 'public/assets/third-party/nice-select/nice-select.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'jquery-validate', TF_PLUGIN_URL . 'public/assets/js/jquery.validate.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'jquery-ui-touch-punch', TF_PLUGIN_URL . 'public/assets/third-party/jquery-ui/jquery.ui.touch-punch.min.js', array( 'jquery' ), '0.2.3', true );
	wp_enqueue_script( 'jquery-ui-min', TF_PLUGIN_URL . 'public/assets/third-party/jquery-ui/jquery-ui.min.js', array( 'jquery' ), '1.12.1', true );
	wp_enqueue_script( 'bootstrap-bundle-min', TF_PLUGIN_URL . 'public/assets/third-party/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ), '4.6.2', true );
	wp_register_script( 'bootstrap-datepicker', TF_PLUGIN_URL . 'public/assets/third-party/bootstrap-datepicker/js/bootstrap-datepicker.min.js', array( 'jquery' ), 'v1.9.0', true );
	wp_register_script( 'star-rating', TF_PLUGIN_URL . 'public/assets/js/star-rating.min.js', array( 'jquery' ), null, true );
	wp_register_script( 'stripe-checkout', 'https://checkout.stripe.com/checkout.js', array(), null, true );
	wp_register_script( 'stripe-v3', 'https://js.stripe.com/v3', array(), null, true );

	// Google map
	if ( tfcl_get_option( "map_service" ) == 'google-map' ) {
		$api_key        = tfcl_get_option( 'google_map_api_key', 'AIzaSyBtUFP8EwyrVM8aOMNahK3619QG5ikA83A' );
		$google_map_url = 'https://maps.googleapis.com/maps/api/js?libraries=geometry,places&key=' . $api_key;
		wp_enqueue_script( 'google_map', esc_url_raw( $google_map_url ), array(), false, true );
		wp_enqueue_script( 'google-map-js', TF_PLUGIN_URL . 'public/assets/js/google-map.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'google_map_marker_cluster', esc_url_raw( 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js' ), array(), false, true );
	}
	if ( tfcl_get_option( "map_service" ) == 'map-box' ) {
		// Map box
		wp_register_script( 'mapbox-gl', 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js', array(), '2.15.0', true );
		wp_register_script( 'mapbox-gl-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js', array(), '5.0.0', true );
	}
	$main_variables = array(
		'toggle_lazy_load' => tfcl_get_option( 'toggle_lazy_load' ),
		'ajaxUrl'          => TF_AJAX_URL
	);

	wp_enqueue_script( 'public-main', TF_PLUGIN_URL . 'public/assets/js/main.js', array( 'jquery' ), false, true );
	wp_localize_script( 'public-main', 'main_variables', $main_variables );
}

add_action( 'wp_enqueue_scripts', 'tfcl_add_public_script' );

// Register Widget
require_once( TF_PLUGIN_PATH . '/includes/class-widgets.php' );
$widgets = new Register_Widgets();
$loader->tfcl_add_action( 'widgets_init', $widgets, 'register_widgets' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', $widgets, 'tfcl_enqueue_styles_widget' ); // enqueue style for widgets

// Template Loader
require_once( TF_PLUGIN_PATH . '/includes/class-template-loader.php' );
$template_loader = new Template_Loader();
$loader->tfcl_add_filter( 'template_include', $template_loader, 'template_loader' );

// Init Admin plugin options
require_once( TF_PLUGIN_PATH . '/admin/class-admin-plugin-options.php' );
$admin_plugin_options = new Admin_Plugin_Options();
$loader->tfcl_add_action( 'after_setup_theme', @$admin_plugin_options, 'tfcl_init_plugin_options' );

// Init Custom Post Type
require_once( TF_PLUGIN_PATH . '/admin/class-admin-custom-post-type.php' );
$admin_custom_post_type = new Admin_Custom_Post_Type();
$loader->tfcl_add_action( 'init', @$admin_custom_post_type, 'tfcl_register_custom_post_type' );

// Car listing post type
$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
require_once( TF_PLUGIN_PATH . 'admin/class-admin-car-listing.php' );
$admin_car_listing = new Admin_Car_Listing();
$loader->tfcl_add_filter( 'admin_init', $admin_car_listing, 'tfcl_approve_listing' );
$loader->tfcl_add_filter( 'admin_init', $admin_car_listing, 'tfcl_hidden_listing' );
$loader->tfcl_add_filter( 'admin_init', $admin_car_listing, 'tfcl_show_listing' );
if ( ( $pagenow == 'edit.php' ) && ( $post_type == 'listing' ) ) {
	$loader->tfcl_add_filter( 'page_row_actions', $admin_car_listing, 'tfcl_modify_list_row_actions', 10, 2 );
}
$loader->tfcl_add_action( 'restrict_manage_posts', $admin_car_listing, 'tfcl_filter_restrict_manage_listings' );
$loader->tfcl_add_filter( 'parse_query', $admin_car_listing, 'tfcl_handle_filter_listings' );
$loader->tfcl_add_action( 'init', $admin_car_listing, 'tfcl_register_new_post_status' );

// Init Admin Taxonomy
require_once( TF_PLUGIN_PATH . '/admin/class-admin-taxonomy.php' );
$admin_taxonomy = new Admin_Taxonomy();
$loader->tfcl_add_action( 'init', $admin_taxonomy, 'tfcl_register_taxonomy', 0 );
$loader->tfcl_add_filter( 'manage_edit-model_columns', $admin_taxonomy, 'tfcl_add_columns_taxonomy_model' );
$loader->tfcl_add_filter( 'manage_model_custom_column', $admin_taxonomy, 'tfcl_add_columns_data_taxonomy_model', 10, 3 );

// Remove parent dropdown in taxonomy
$loader->tfcl_add_action( 'admin_head-edit-tags.php', $admin_taxonomy, 'tfcl_remove_tax_parent_dropdown' );
$loader->tfcl_add_action( 'admin_head-term.php', $admin_taxonomy, 'tfcl_remove_tax_parent_dropdown' );
$loader->tfcl_add_action( 'admin_head-post.php', $admin_taxonomy, 'tfcl_remove_tax_parent_dropdown' );
$loader->tfcl_add_action( 'admin_head-post-new.php', $admin_taxonomy, 'tfcl_remove_tax_parent_dropdown' );

// Init Meta Control
require_once( TF_PLUGIN_PATH . '/admin/meta-control/class-term-meta-control.php' );
$loader->tfcl_add_action( 'init', $admin_taxonomy, 'tfcl_register_term_meta_control', 0 );

// Init MetaBox
require_once( TF_PLUGIN_PATH . '/admin/meta-control/class-meta-box-control.php' );
require_once( TF_PLUGIN_PATH . '/admin/class-admin-meta-box.php' );
$admin_meta_box = new Admin_Meta_Box();
$loader->tfcl_add_action( 'admin_init', @$admin_meta_box, 'tfcl_register_meta_boxes' );
$loader->tfcl_add_action( 'updated_post_meta', @$admin_meta_box, 'tfcl_change_author_when_update_any_listing', 10, 4 );

// Init User Public
require_once( TF_PLUGIN_PATH . 'includes/libraries/Google-Client/class-google-client.php' );
$google_client = new Google_Client();
$loader->tfcl_add_action('init', $google_client, 'get_instance');
require_once( TF_PLUGIN_PATH . '/public/partials/user/class-user.php' );
$user_public = new User_Public($google_client);

$loader->tfcl_add_action( 'wp_enqueue_scripts', @$user_public, 'tfcl_enqueue_user_scripts' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$user_public, 'tfcl_enqueue_user_styles' );
$loader->tfcl_add_action( 'tfcl_single_author_summary', @$user_public, 'tfcl_single_author_summary', 5 );
$loader->tfcl_add_action( 'tfcl_single_author_summary', @$user_public, 'tfcl_single_author_listing', 10 );
$loader->tfcl_add_action( 'wp_footer', $user_public, 'tfcl_login_register_modal' );

// Register
$loader->tfcl_add_action( 'wp_ajax_register_new_user', @$user_public, 'tfcl_register_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_register_new_user', @$user_public, 'tfcl_register_ajax_handler' );
$loader->tfcl_add_shortcode( 'register_form', @$user_public, 'tfcl_register_form_shortcode' );

// Login
$loader->tfcl_add_action( 'wp_ajax_user_login', @$user_public, 'tfcl_login_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_user_login', @$user_public, 'tfcl_login_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_set_access_token_google', @$user_public, 'tfcl_set_access_token_google' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_set_access_token_google', @$user_public, 'tfcl_set_access_token_google' );
$loader->tfcl_add_action( 'wp_ajax_google_login_ajax', @$user_public, 'tfcl_handle_google_login_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_google_login_ajax', @$user_public, 'tfcl_handle_google_login_ajax' );
$loader->tfcl_add_shortcode( 'login_form', $user_public, 'tfcl_login_form_shortcode' );

// Reset password
$loader->tfcl_add_action( 'wp_ajax_reset_password_ajax', $user_public, 'tfcl_reset_password_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_reset_password_ajax', $user_public, 'tfcl_reset_password_ajax_handler' );

// My Profile
$loader->tfcl_add_shortcode( 'my_profile', $user_public, 'tfcl_my_profile_shortcode' );
$loader->tfcl_add_action( 'wp_ajax_profile_update', $user_public, 'tfcl_profile_update_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_profile_update', $user_public, 'tfcl_profile_update_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_upload_avatar', $user_public, 'tfcl_upload_avatar_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_upload_avatar', $user_public, 'tfcl_upload_avatar_ajax_handler' );

// Become dealer
$loader->tfcl_add_action( 'wp_ajax_become_dealer', $user_public, 'tfcl_become_dealer' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_become_dealer', @$user_public, 'tfcl_become_dealer' );

// Leave dealer
$loader->tfcl_add_action( 'wp_ajax_leave_dealer', $user_public, 'tfcl_leave_dealer' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_leave_dealer', @$user_public, 'tfcl_leave_dealer' );

// Upload dealer poster
$loader->tfcl_add_action( 'wp_ajax_dealer_upload_poster', $user_public, 'tfcl_upload_dealer_poster_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_dealer_upload_poster', $user_public, 'tfcl_upload_dealer_poster_ajax_handler' );

// Init Listing Public hooks
require_once( TF_PLUGIN_PATH . '/public/partials/listing/class-listing.php' );

$listing_public = new Car_Listing();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$listing_public, 'tfcl_enqueue_listing_scripts' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$listing_public, 'tfcl_enqueue_listing_styles' );
$loader->tfcl_add_action( 'wp_ajax_img_upload', @$listing_public, 'tfcl_listing_image_upload_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_img_upload', @$listing_public, 'tfcl_listing_image_upload_ajax' );
$loader->tfcl_add_action( 'wp_ajax_file_attachment_upload', @$listing_public, 'tfcl_listing_attachment_upload_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_file_attachment_upload', @$listing_public, 'tfcl_listing_attachment_upload_ajax' );
$loader->tfcl_add_action( 'wp_ajax_delete_img_or_file', @$listing_public, 'tfcl_delete_listing_image_or_file_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_delete_img_or_file', @$listing_public, 'tfcl_delete_listing_image_or_file_ajax' );
$loader->tfcl_add_action( 'wp_ajax_save_listing', @$listing_public, 'tfcl_handle_save_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_save_listing', @$listing_public, 'tfcl_handle_save_listing_ajax' );
$loader->tfcl_add_action( 'wp', @$listing_public, 'tfcl_handle_actions_my_listing' );
$loader->tfcl_add_action( 'wp_ajax_get_listing_detail', $listing_public, 'tfcl_get_listing_detail' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_get_listing_detail', $listing_public, 'tfcl_get_listing_detail' );
$loader->tfcl_add_action( 'template_redirect', @$listing_public, 'tfcl_set_views', 99999 );
$loader->tfcl_add_shortcode( 'my_listing', @$listing_public, 'tfcl_my_listing_shortcode' );
$loader->tfcl_add_shortcode( 'save_listing', @$listing_public, 'tfcl_save_listing_shortcode' );
$loader->tfcl_add_shortcode( 'car_listing', @$listing_public, 'tfcl_car_listing_shortcode' );
$loader->tfcl_add_shortcode( 'listing_with_map', @$listing_public, 'tfcl_listing_map_shortcode' );
$loader->tfcl_add_shortcode( 'listing_with_url', @$listing_public, 'tfcl_listing_map_get_url' );
$loader->tfcl_add_action( 'wp_ajax_get_model_by_make_ajax', @$listing_public, 'tfcl_get_model_by_make_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_get_model_by_make_ajax', @$listing_public, 'tfcl_get_model_by_make_ajax' );

// Single Listing
$loader->tfcl_add_action( 'tfcl_single_listing_summary_header', @$listing_public, 'tfcl_single_listing_header', 5 );
$loader->tfcl_add_action( 'tfcl_single_listing_summary_gallery', @$listing_public, 'tfcl_single_listing_gallery', 10 );
$loader->tfcl_add_action( 'tfcl_single_listing_summary', @$listing_public, 'tfcl_single_listing_description', 15 );
$loader->tfcl_add_action( 'tfcl_single_listing_summary', @$listing_public, 'tfcl_single_listing_overview', 20 );
$loader->tfcl_add_action( 'tfcl_single_listing_summary', @$listing_public, 'tfcl_single_listing_features', 25 );
$loader->tfcl_add_action( 'tfcl_single_listing_summary', @$listing_public, 'tfcl_single_listing_loan_calculator', 30 );
$loader->tfcl_add_action( 'tfcl_single_listing_summary', @$listing_public, 'tfcl_single_listing_location', 35 );

// Shortcode loan calculator
$loader->tfcl_add_shortcode( 'loan_calculator', @$listing_public, 'tfcl_loan_calculator_shortcode' );

// Shortcode related listing
$loader->tfcl_add_shortcode( 'related_listing', @$listing_public, 'tfcl_related_listing_shortcode' );

// Shortcode author contact
$loader->tfcl_add_shortcode( 'author_contact_listing', @$listing_public, 'tfcl_author_listing_shortcode' );

// Favorites
$loader->tfcl_add_action( 'tfcl_favorite_action', @$listing_public, 'tfcl_listing_favorite', 10, 2 );
$loader->tfcl_add_action( 'wp_ajax_tfcl_favorite_ajax', $listing_public, 'tfcl_favorite_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_favorite_ajax', $listing_public, 'tfcl_favorite_ajax' );
require_once( TF_PLUGIN_PATH . '/public/partials/favorite/class-favorite.php' );
$class_favorite = new TFCL_Favorite();
$loader->tfcl_add_shortcode( 'my_favorite', @$class_favorite, 'tfcl_my_favorite_shortcode' );

// Compare
require_once( TF_PLUGIN_PATH . '/public/partials/listing/class-compare.php' );
$compare = TFCL_Compare::getInstance();
$loader->tfcl_add_action( 'tfcl_compare_action', @$listing_public, 'tfcl_listing_compare', 10, 2 );
$loader->tfcl_add_action( 'wp_logout', $compare, 'tfcl_close_session' );
$loader->tfcl_add_action( 'tfcl_show_compare', $compare, 'tfcl_show_compare_listings', 5 );
$loader->tfcl_add_action( 'wp_ajax_tfcl_compare_add_remove_listing_ajax', $compare, 'tfcl_compare_add_remove_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_compare_add_remove_listing_ajax', $compare, 'tfcl_compare_add_remove_listing_ajax' );
$loader->tfcl_add_action( 'wp_footer', $compare, 'tfcl_template_compare_listing' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$compare, 'tfcl_enqueue_compare_scripts' );
$loader->tfcl_add_shortcode( 'tfcl_compare', @$compare, 'tfcl_compare_shortcode' );

// Dealer Admin
require_once( TF_PLUGIN_PATH . 'admin/class-admin-dealer.php' );
$admin_dealer = new Admin_Dealer();
$post_type    = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
if ( ( $pagenow == 'edit.php' ) && ( $post_type == 'dealer' ) ) {
	$loader->tfcl_add_filter( 'post_row_actions', $admin_dealer, 'modify_list_row_actions', 10, 2 );
	$loader->tfcl_add_filter( 'page_row_actions', $admin_dealer, 'modify_list_row_actions', 10, 2 );
}
$loader->tfcl_add_filter( 'admin_init', $admin_dealer, 'tfcl_approve_dealer' );

// Taxonomy Public
require_once( TF_PLUGIN_PATH . 'public/partials/taxonomy/class-taxonomy.php' );
$taxonomy_public = new Public_Taxonomy();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$taxonomy_public, 'tfcl_enqueue_taxonomy_scripts' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$taxonomy_public, 'tfcl_enqueue_taxonomy_styles' );
$loader->tfcl_add_action( 'wp_ajax_filter_archive_listing_ajax', @$taxonomy_public, 'tfcl_filter_archive_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_filter_archive_listing_ajax', @$taxonomy_public, 'tfcl_filter_archive_listing_ajax' );

// Initial dealer object
require_once( TF_PLUGIN_PATH . '/public/partials/dealer/class-dealer.php' );
$dealer_public = new Dealer_Public();

// Single dealer
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$dealer_public, 'tfcl_enqueue_dealer_style' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$dealer_public, 'tfcl_enqueue_dealer_scripts' );
$loader->tfcl_add_action( 'tfcl_single_dealer_summary', @$dealer_public, 'tfcl_single_dealer_info', 5 );
$loader->tfcl_add_action( 'tfcl_single_dealer_summary', @$dealer_public, 'tfcl_single_dealer_property', 10 );
$loader->tfcl_add_action( 'tfcl_single_dealer_review', @$dealer_public, 'tfcl_single_dealer_review', 15 );
$loader->tfcl_add_action( 'tfcl_single_dealer_review', @$dealer_public, 'tfcl_dealer_add_new_comment', 20 );
$loader->tfcl_add_shortcode( 'listing_dealer', @$dealer_public, 'tfcl_listing_dealer_shortcode' );

// List dealer
$loader->tfcl_add_shortcode( 'list_dealer', @$dealer_public, 'tfcl_list_all_dealer_shortcode' );
$loader->tfcl_add_shortcode( 'filter_listing_dealer', @$dealer_public, 'tfcl_filter_list_dealer_shortcode' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_get_all_listing_by_condition_ajax', @$dealer_public, 'tfcl_get_all_listing_by_condition_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_get_all_listing_by_condition_ajax', @$dealer_public, 'tfcl_get_all_listing_by_condition_ajax' );

// Review
require_once( TF_PLUGIN_PATH . '/public/partials/review/class-review.php' );
$review = new Review();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$review, 'tfcl_enqueue_review_scripts' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_submit_dealer_review_ajax', @$review, 'tfcl_submit_review_dealer_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_submit_dealer_review_ajax', @$review, 'tfcl_submit_review_dealer_ajax' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_update_review_dealer_ajax', @$review, 'tfcl_update_review_dealer_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_update_review_dealer_ajax', @$review, 'tfcl_update_review_dealer_ajax' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_calc_overall_rating_dealer_ajax', @$review, 'tfcl_calc_overall_rating_dealer_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_calc_overall_rating_dealer_ajax', @$review, 'tfcl_calc_overall_rating_dealer_ajax' );
$loader->tfcl_add_action( 'tfcl_single_review', @$review, 'tfcl_single_listing_review', 10, 2 );
$loader->tfcl_add_action( 'wp_ajax_tfcl_submit_review_single_listing_ajax', @$review, 'tfcl_submit_review_single_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_submit_review_single_listing_ajax', @$review, 'tfcl_submit_review_single_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_update_review_listing_ajax', @$review, 'tfcl_update_review_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_update_review_listing_ajax', @$review, 'tfcl_update_review_listing_ajax' );
$loader->tfcl_add_action( 'tfcl_listing_rating_meta', @$review, 'tfcl_rating_meta_filter', 4, 9 );
$loader->tfcl_add_action( 'wp_ajax_tfcl_calc_overall_rating_single_listing_ajax', @$review, 'tfcl_calc_overall_rating_single_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_calc_overall_rating_single_listing_ajax', @$review, 'tfcl_calc_overall_rating_single_listing_ajax' );

// Rating Shortcode
$loader->tfcl_add_shortcode( 'my_rating', @$review, 'tfcl_my_rating_shortcode' );

// Advanced Search
require_once( TF_PLUGIN_PATH . '/public/partials/advanced-search/class-advanced-search.php' );
$advanced_search = new Advanced_Search();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$advanced_search, 'tfcl_enqueue_style_advanced_search' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$advanced_search, 'tfcl_enqueue_script_advanced_search' );
$loader->tfcl_add_shortcode( 'advanced_search', @$advanced_search, 'tfcl_advanced_search_shortcode' );
$loader->tfcl_add_action( 'listing_advanced_search_form', @$advanced_search, 'tfcl_listing_advanced_search_form' );
$loader->tfcl_add_action( 'wp_ajax_mapping_make_model_ajax', @$advanced_search, 'tfcl_mapping_make_model_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_mapping_make_model_ajax', @$advanced_search, 'tfcl_mapping_make_model_ajax' );
$loader->tfcl_add_action( 'wp_ajax_get_quantity_listing_ajax', @$advanced_search, 'tfcl_get_quantity_listing_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_get_quantity_listing_ajax', @$advanced_search, 'tfcl_get_quantity_listing_ajax' );

// Save advanced search
require_once( TF_PLUGIN_PATH . '/public/partials/advanced-search/class-save-advanced-search.php' );
$save_advanced_search = new Save_Advanced_Search();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$save_advanced_search, 'tfcl_enqueue_styles_saved_advanced_search' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_save_advanced_search_ajax', @$save_advanced_search, 'tfcl_save_advanced_search_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_save_advanced_search_ajax', @$save_advanced_search, 'tfcl_save_advanced_search_ajax' );
$loader->tfcl_add_shortcode( 'my_saved_advanced_search', @$save_advanced_search, 'tfcl_my_saved_advanced_search_shortcode' );

// Search filter
require_once( TF_PLUGIN_PATH . '/public/partials/search-by-filter/class-search-by-filter.php' );
$search_filter = new Search_By_Filter();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$search_filter, 'tfcl_enqueue_style_search_filter' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$search_filter, 'tfcl_enqueue_script_search_filter' );
$loader->tfcl_add_shortcode( 'search_by_filter', @$search_filter, 'tfcl_search_by_filter_shortcode' );

// Invoice Public
require_once( TF_PLUGIN_PATH . '/public/partials/invoice/class-invoice.php' );
$invoice_public = new Invoice_Public();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$invoice_public, 'tfcl_register_invoice_script' );
$loader->tfcl_add_shortcode( 'my_invoice', @$invoice_public, 'tfcl_my_invoice_shortcode' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_handle_print_invoice', @$invoice_public, 'tfcl_handle_print_invoice' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_handle_print_invoice', @$invoice_public, 'tfcl_handle_print_invoice' );

// Invoice Admin
require_once( TF_PLUGIN_PATH . '/admin/class-admin-invoice.php' );
$admin_invoice = new Admin_Invoice();
if ( ( $pagenow == 'edit.php' ) && ( $post_type == 'invoice' ) ) {
	$loader->tfcl_add_filter( 'manage_edit-invoice_columns', $admin_invoice, 'tfcl_register_column_titles' );
	$loader->tfcl_add_action( 'manage_invoice_posts_custom_column', $admin_invoice, 'tfcl_display_column_value' );
	$loader->tfcl_add_action( 'restrict_manage_posts', $admin_invoice, 'tfcl_filter_restrict_manage_invoices' );
	$loader->tfcl_add_filter( 'parse_query', $admin_invoice, 'tfcl_handle_filter_restrict_manage_invoices' );
	$loader->tfcl_add_filter( 'pre_get_posts', $admin_invoice, 'tfcl_set_page_order_in_admin' );
}

// User Package Public 
require_once( TF_PLUGIN_PATH . '/public/partials/user-package/class-user-package.php' );
$user_package_public = new User_Package_Public();

// User Package Admin
require_once( TF_PLUGIN_PATH . '/admin/class-admin-user-package.php' );
$admin_user_package = new Admin_User_Package();
if ( ( $pagenow == 'edit.php' ) && ( $post_type == 'user-package' ) ) {
	$loader->tfcl_add_filter( 'manage_edit-user-package_columns', $admin_user_package, 'tfcl_register_custom_column_titles' );
	$loader->tfcl_add_action( 'manage_user-package_posts_custom_column', $admin_user_package, 'tfcl_display_column_value' );
	$loader->tfcl_add_action( 'restrict_manage_posts', $admin_user_package, 'tfcl_filter_restrict_manage_user_package' );
	$loader->tfcl_add_filter( 'parse_query', $admin_user_package, 'tfcl_handle_filter_restrict_manage_user_package' );
	$loader->tfcl_add_action( 'before_delete_post', $admin_user_package, 'tfcl_delete_user_package' );
}

// Transaction Log Public
require_once( TF_PLUGIN_PATH . 'public/partials/transaction-log/class-transaction-log.php' );
$transaction_log_public = new Transaction_Logs_Public();

// Transaction Log Admin
require_once( TF_PLUGIN_PATH . '/admin/class-admin-transaction-log.php' );
$admin_transaction_log = new Admin_Transaction_Log();
if ( ( $pagenow == 'edit.php' ) && ( $post_type == 'transaction-log' ) ) {
	$loader->tfcl_add_filter( 'manage_edit-transaction-log_columns', $admin_transaction_log, 'tfcl_register_custom_column_titles' );
	$loader->tfcl_add_action( 'manage_transaction-log_posts_custom_column', $admin_transaction_log, 'tfcl_display_column_value' );
	$loader->tfcl_add_action( 'restrict_manage_posts', $admin_transaction_log, 'tfcl_filter_restrict_manage_transaction_log' );
	$loader->tfcl_add_filter( 'parse_query', $admin_transaction_log, 'tfcl_handle_filter_restrict_manage_transaction_log' );
	$loader->tfcl_add_filter( 'pre_get_posts', $admin_transaction_log, 'tfcl_set_page_order_in_admin' );
}

// Package Public
require_once( TF_PLUGIN_PATH . 'public/partials/package/class-package.php' );
$package_public = new Package_Public();
$loader->tfcl_add_shortcode( 'package_list', @$package_public, 'tfcl_package_list_shortcode' );
$loader->tfcl_add_shortcode( 'my_package', @$package_public, 'tfcl_my_package_shortcode' );

// Payment Public
require_once( TF_PLUGIN_PATH . 'public/partials/payment/class-payment.php' );
// require_once( TF_PLUGIN_PATH . '/includes/libraries/stripe-php/init.php' );
$payment_public = new Payment_Public();
$loader->tfcl_add_shortcode( 'payment_invoice', @$payment_public, 'tfcl_payment_invoice_shortcode' );
$loader->tfcl_add_shortcode( 'payment_completed', @$payment_public, 'tfcl_payment_completed_shortcode' );
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$payment_public, 'tfcl_register_payment_scripts' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_handle_payment_invoice_by_paypal', @$payment_public, 'tfcl_handle_payment_invoice_by_paypal' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_handle_payment_invoice_by_paypal', @$payment_public, 'tfcl_handle_payment_invoice_by_paypal' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_handle_payment_invoice_by_wire_transfer', @$payment_public, 'tfcl_handle_payment_invoice_by_wire_transfer' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_handle_payment_invoice_by_wire_transfer', @$payment_public, 'tfcl_handle_payment_invoice_by_wire_transfer' );
$loader->tfcl_add_action( 'wp_ajax_tfcl_handle_free_package', @$payment_public, 'tfcl_handle_free_package' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_tfcl_handle_free_package', @$payment_public, 'tfcl_handle_free_package' );
$loader->tfcl_add_action( 'wp_ajax_stripe_payment_init', @$payment_public, 'tfcl_handle_payment_invoice_by_stripe' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_stripe_payment_init', @$payment_public, 'tfcl_handle_payment_invoice_by_stripe' );

// Init Dashboard Public
require_once( TF_PLUGIN_PATH . '/public/partials/dashboard/class-dashboard.php' );
$class_dashboard = new Dashboard_Public();
$loader->tfcl_add_action( 'wp_enqueue_scripts', @$class_dashboard, 'tfcl_enqueue_dashboard_scripts' );
$loader->tfcl_add_shortcode( 'dashboard', @$class_dashboard, 'tfcl_dashboard_shortcode' );
$loader->tfcl_add_action( 'wp_ajax_action_listing_dashboard', @$class_dashboard, 'tfcl_handle_actions_listing_dashboard' );
$loader->tfcl_add_action( 'wp_ajax_dashboard_chart_ajax', @$class_dashboard, 'tfcl_dashboard_chart_ajax' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_dashboard_chart_ajax', @$class_dashboard, 'tfcl_dashboard_chart_ajax' );

// Elementor Widgets
function tf_elementor_addon() {
	// Load plugin file
	require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/elementor-widget-addon.php' );

	// Run the plugin
	$tf_elementor_widget_addon = new TF_Elementor_Widget_Addon();
	$tf_elementor_widget_addon::instance();
}

add_action( 'plugins_loaded', 'tf_elementor_addon' );

// fix error pagination with custom post type
function tfcl_paginate_cpt( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( $query->is_author() ) {
			$post_per_page = tfcl_get_option( 'item_per_page_archive_listing' );
			$query->set( 'post_type', array( 'listing' ) );
			$query->set( 'posts_per_page', $post_per_page );
		}
	}
	if ( is_post_type_archive( 'dealer' ) ) {
		$post_per_page = tfcl_get_option( 'item_per_page_archive_dealer' );
		$query->set( 'posts_per_page', $post_per_page );
	}
}

add_action( 'pre_get_posts', 'tfcl_paginate_cpt' );

// run hooks
$loader->tfcl_add_action( 'wp_ajax_change_password', $user_public, 'tfcl_change_password_ajax_handler' );
$loader->tfcl_add_action( 'wp_ajax_nopriv_change_password', $user_public, 'tfcl_change_password_ajax_handler' );
$loader->tfcl_add_action( 'init', @$loader, 'i18n' );

// Run hooks
$loader->tfcl_run();

function custom_admin_page() {
    add_menu_page(
        'Custom Name Taxonomy & Metabox Listing Options', // Tên trang
        'Custom Name Taxonomy & Metabox Listing Options', // Tên menu
        'manage_options', // Quyền cần thiết
        'custom-options', // Slug
        'custom_options_page_html', // Hàm callback hiển thị nội dung
        'dashicons-admin-generic', // Icon
        3 // Vị trí menu
    );
}
add_action('admin_menu', 'custom_admin_page');

function custom_options_page_html() {
    // Kiểm tra quyền truy cập
    if (!current_user_can('manage_options')) {
        return;
    }

    // Kiểm tra và lưu giá trị mặc định vào cơ sở dữ liệu nếu chưa tồn tại
    $custom_name_condition = get_option('custom_name_condition');
    if ($custom_name_condition === false) {
        $default_value = 'Condition';
        add_option('custom_name_condition', $default_value);
        $custom_name_condition = $default_value;
    }

    $custom_name_body = get_option('custom_name_body');
    if ($custom_name_body === false) {
        $default_value = 'Body';
        add_option('custom_name_body', $default_value);
        $custom_name_body = $default_value;
    }

    $custom_name_make = get_option('custom_name_make');
    if ($custom_name_make === false) {
        $default_value = 'Make';
        add_option('custom_name_make', $default_value);
        $custom_name_make = $default_value;
    }

    $custom_name_model = get_option('custom_name_model');
    if ($custom_name_model === false) {
        $default_value = 'Model';
        add_option('custom_name_model', $default_value);
        $custom_name_model = $default_value;
    }

    $custom_name_transmission = get_option('custom_name_transmission');
    if ($custom_name_transmission === false) {
        $default_value = 'Transmission';
        add_option('custom_name_transmission', $default_value);
        $custom_name_transmission = $default_value;
    }

    $custom_name_cylinders = get_option('custom_name_cylinders');
    if ($custom_name_cylinders === false) {
        $default_value = 'Cylinders';
        add_option('custom_name_cylinders', $default_value);
        $custom_name_cylinders = $default_value;
    }

    $custom_name_drive_type = get_option('custom_name_drive_type');
    if ($custom_name_drive_type === false) {
        $default_value = 'Drive Type';
        add_option('custom_name_drive_type', $default_value);
        $custom_name_drive_type = $default_value;
    }

    $custom_name_fuel_type = get_option('custom_name_fuel_type');
    if ($custom_name_fuel_type === false) {
        $default_value = 'Fuel Type';
        add_option('custom_name_fuel_type', $default_value);
        $custom_name_fuel_type = $default_value;
    }

    $custom_name_color = get_option('custom_name_color');
    if ($custom_name_color === false) {
        $default_value = 'Color';
        add_option('custom_name_color', $default_value);
        $custom_name_color = $default_value;
    }

    $custom_name_features = get_option('custom_name_features');
    if ($custom_name_features === false) {
        $default_value = 'Features';
        add_option('custom_name_features', $default_value);
        $custom_name_features = $default_value;
    }

    $custom_name_features_type = get_option('custom_name_features_type');
    if ($custom_name_features_type === false) {
        $default_value = 'Features Type';
        add_option('custom_name_features_type', $default_value);
        $custom_name_features_type = $default_value;
    }

    // metabox

    $custom_name_stock_number = get_option('custom_name_stock_number');
    if ($custom_name_stock_number === false) {
        $default_value = 'Stock Number';
        add_option('custom_name_stock_number', $default_value);
        $custom_name_stock_number = $default_value;
    }

    $custom_name_vin_number = get_option('custom_name_vin_number');
    if ($custom_name_vin_number === false) {
        $default_value = 'Vin Number';
        add_option('custom_name_vin_number', $default_value);
        $custom_name_vin_number = $default_value;
    }

    $custom_name_city_mpg = get_option('custom_name_city_mpg');
    if ($custom_name_city_mpg === false) {
        $default_value = 'City MPG';
        add_option('custom_name_city_mpg', $default_value);
        $custom_name_city_mpg = $default_value;
    }

    $custom_name_highway_mpg = get_option('custom_name_highway_mpg');
    if ($custom_name_highway_mpg === false) {
        $default_value = 'Highway MPG';
        add_option('custom_name_highway_mpg', $default_value);
        $custom_name_highway_mpg = $default_value;
    }

    $custom_name_year = get_option('custom_name_year');
    if ($custom_name_year === false) {
        $default_value = 'Year';
        add_option('custom_name_year', $default_value);
        $custom_name_year = $default_value;
    }

    $custom_name_door = get_option('custom_name_door');
    if ($custom_name_door === false) {
        $default_value = 'Door';
        add_option('custom_name_door', $default_value);
        $custom_name_door = $default_value;
    }

    $custom_name_seat = get_option('custom_name_seat');
    if ($custom_name_seat === false) {
        $default_value = 'Seat';
        add_option('custom_name_seat', $default_value);
        $custom_name_seat = $default_value;
    }

    $custom_name_mileage = get_option('custom_name_mileage');
    if ($custom_name_mileage === false) {
        $default_value = 'Mileage';
        add_option('custom_name_mileage', $default_value);
        $custom_name_mileage = $default_value;
    }

    $custom_name_engine_size = get_option('custom_name_engine_size');
    if ($custom_name_engine_size === false) {
        $default_value = 'Engine Size';
        add_option('custom_name_engine_size', $default_value);
        $custom_name_engine_size = $default_value;
    }

    // Xử lý lưu trữ form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra và lưu trữ dữ liệu form
        if (isset($_POST['custom_name_condition']) && !empty($_POST['custom_name_condition'])) {
            $custom_name_condition = sanitize_text_field($_POST['custom_name_condition']);
            update_option('custom_name_condition', $custom_name_condition);
        }

        if (isset($_POST['custom_name_body']) && !empty($_POST['custom_name_body'])) {
            $custom_name_body = sanitize_text_field($_POST['custom_name_body']);
            update_option('custom_name_body', $custom_name_body);
        }

        if (isset($_POST['custom_name_make']) && !empty($_POST['custom_name_make'])) {
            $custom_name_make = sanitize_text_field($_POST['custom_name_make']);
            update_option('custom_name_make', $custom_name_make);
        }

        if (isset($_POST['custom_name_model']) && !empty($_POST['custom_name_model'])) {
            $custom_name_model = sanitize_text_field($_POST['custom_name_model']);
            update_option('custom_name_model', $custom_name_model);
        }

        if (isset($_POST['custom_name_transmission']) && !empty($_POST['custom_name_transmission'])) {
            $custom_name_transmission = sanitize_text_field($_POST['custom_name_transmission']);
            update_option('custom_name_transmission', $custom_name_transmission);
        }

        if (isset($_POST['custom_name_cylinders']) && !empty($_POST['custom_name_cylinders'])) {
            $custom_name_cylinders = sanitize_text_field($_POST['custom_name_cylinders']);
            update_option('custom_name_cylinders', $custom_name_cylinders);
        }

        if (isset($_POST['custom_name_drive_type']) && !empty($_POST['custom_name_drive_type'])) {
            $custom_name_drive_type = sanitize_text_field($_POST['custom_name_drive_type']);
            update_option('custom_name_drive_type', $custom_name_drive_type);
        }

        if (isset($_POST['custom_name_fuel_type']) && !empty($_POST['custom_name_fuel_type'])) {
            $custom_name_fuel_type = sanitize_text_field($_POST['custom_name_fuel_type']);
            update_option('custom_name_fuel_type', $custom_name_fuel_type);
        }

        if (isset($_POST['custom_name_color']) && !empty($_POST['custom_name_color'])) {
            $custom_name_color = sanitize_text_field($_POST['custom_name_color']);
            update_option('custom_name_color', $custom_name_color);
        }

        if (isset($_POST['custom_name_features_type']) && !empty($_POST['custom_name_features_type'])) {
            $custom_name_features_type = sanitize_text_field($_POST['custom_name_features_type']);
            update_option('custom_name_features_type', $custom_name_features_type);
        }

        if (isset($_POST['custom_name_features']) && !empty($_POST['custom_name_features'])) {
            $custom_name_features = sanitize_text_field($_POST['custom_name_features']);
            update_option('custom_name_features', $custom_name_features);
        }

        if (isset($_POST['custom_name_stock_number']) && !empty($_POST['custom_name_stock_number'])) {
            $custom_name_stock_number = sanitize_text_field($_POST['custom_name_stock_number']);
            update_option('custom_name_stock_number', $custom_name_stock_number);
        }

        if (isset($_POST['custom_name_vin_number']) && !empty($_POST['custom_name_vin_number'])) {
            $custom_name_vin_number = sanitize_text_field($_POST['custom_name_vin_number']);
            update_option('custom_name_vin_number', $custom_name_vin_number);
        }

        if (isset($_POST['custom_name_city_mpg']) && !empty($_POST['custom_name_city_mpg'])) {
            $custom_name_city_mpg = sanitize_text_field($_POST['custom_name_city_mpg']);
            update_option('custom_name_city_mpg', $custom_name_city_mpg);
        }

        if (isset($_POST['custom_name_highway_mpg']) && !empty($_POST['custom_name_highway_mpg'])) {
            $custom_name_highway_mpg = sanitize_text_field($_POST['custom_name_highway_mpg']);
            update_option('custom_name_highway_mpg', $custom_name_highway_mpg);
        }
        
        if (isset($_POST['custom_name_year']) && !empty($_POST['custom_name_year'])) {
            $custom_name_year = sanitize_text_field($_POST['custom_name_year']);
            update_option('custom_name_year', $custom_name_year);
        }

        if (isset($_POST['custom_name_door']) && !empty($_POST['custom_name_door'])) {
            $custom_name_door = sanitize_text_field($_POST['custom_name_door']);
            update_option('custom_name_door', $custom_name_door);
        }

        if (isset($_POST['custom_name_seat']) && !empty($_POST['custom_name_seat'])) {
            $custom_name_seat = sanitize_text_field($_POST['custom_name_seat']);
            update_option('custom_name_seat', $custom_name_seat);
        }

        if (isset($_POST['custom_name_mileage']) && !empty($_POST['custom_name_mileage'])) {
            $custom_name_mileage = sanitize_text_field($_POST['custom_name_mileage']);
            update_option('custom_name_mileage', $custom_name_mileage);
        }

        if (isset($_POST['custom_name_engine_size']) && !empty($_POST['custom_name_engine_size'])) {
            $custom_name_engine_size = sanitize_text_field($_POST['custom_name_engine_size']);
            update_option('custom_name_engine_size', $custom_name_engine_size);
        }

        echo '<div class="updated"><p>Option saved successfully.</p></div>';
    }

    // Lấy giá trị hiện tại từ DB
    $custom_name_condition = get_option('custom_name_condition', 'Condition');
    $custom_name_body = get_option('custom_name_body', 'Body');
    $custom_name_make = get_option('custom_name_make', 'Make');
    $custom_name_model = get_option('custom_name_model', 'Model');
    $custom_name_transmission = get_option('custom_name_transmission', 'Transmission');
    $custom_name_cylinders = get_option('custom_name_cylinders', 'Cylinders');
    $custom_name_drive_type = get_option('custom_name_drive_type', 'Drive Type');
    $custom_name_fuel_type = get_option('custom_name_fuel_type', 'Fuel Type');
    $custom_name_color = get_option('custom_name_color', 'Color');
    $custom_name_features_type = get_option('custom_name_features_type', 'Features Type');
    $custom_name_features = get_option('custom_name_features', 'Features');

    $custom_name_stock_number = get_option('custom_name_stock_number', 'Stock Number');
    $custom_name_vin_number = get_option('custom_name_vin_number', 'Vin Number');
    $custom_name_city_mpg = get_option('custom_name_city_mpg', 'City Mpg');
    $custom_name_highway_mpg = get_option('custom_name_highway_mpg', 'Highway Mpg');
    $custom_name_year = get_option('custom_name_year', 'Year');
    $custom_name_door = get_option('custom_name_door', 'Door');
    $custom_name_seat = get_option('custom_name_seat', 'Seat');
    $custom_name_mileage = get_option('custom_name_mileage', 'Mileage');
    $custom_name_engine_size = get_option('custom_name_engine_size', 'Engine Size');

    // Here you can continue to display your form or other HTML content
?>

	
    <div class="wrap">
        <h1><?php echo esc_html__('Custom Name Taxonomy Listings', 'tf-car-listing'); ?></h1>
        <form method="post" action="">
            <div class="inner-table-listing">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <h2><?php echo esc_html__('Custom Name Taxonomy Listings', 'tf-car-listing'); ?></h2>
                        </th>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_condition"><?php echo esc_html__('Custom Name Condition', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_condition" name="custom_name_condition" value="<?php echo esc_attr($custom_name_condition); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_body"><?php echo esc_html__('Custom Name Body', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_body" name="custom_name_body" value="<?php echo esc_attr($custom_name_body); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_make"><?php echo esc_html__('Custom Name Make', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_make" name="custom_name_make" value="<?php echo esc_attr($custom_name_make); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_model"><?php echo esc_html__('Custom Name Model', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_model" name="custom_name_model" value="<?php echo esc_attr($custom_name_model); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_transmission"><?php echo esc_html__('Custom Name Transmission', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_transmission" name="custom_name_transmission" value="<?php echo esc_attr($custom_name_transmission); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_cylinders"><?php echo esc_html__('Custom Name Cylinders', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_cylinders" name="custom_name_cylinders" value="<?php echo esc_attr($custom_name_cylinders); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_drive_type"><?php echo esc_html__('Custom Name Drive Type', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_drive_type" name="custom_name_drive_type" value="<?php echo esc_attr($custom_name_drive_type); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_color"><?php echo esc_html__('Custom Name Color', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_color" name="custom_name_color" value="<?php echo esc_attr($custom_name_color); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_fuel_type"><?php echo esc_html__('Custom Name Fuel Type', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_fuel_type" name="custom_name_fuel_type" value="<?php echo esc_attr($custom_name_fuel_type); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_features_type"><?php echo esc_html__('Custom Name Features Type', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_features_type" name="custom_name_features_type" value="<?php echo esc_attr($custom_name_features_type); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_features"><?php echo esc_html__('Custom Name Features', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_features" name="custom_name_features" value="<?php echo esc_attr($custom_name_features); ?>" class="regular-text">
                        </td>
                    </tr>
                </table>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <h2><?php echo esc_html__('Custom Name Metabox Listings', 'tf-car-listing'); ?></h2>
                        </th>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_stock_number"><?php echo esc_html__('Custom Name Stock Number', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_stock_number" name="custom_name_stock_number" value="<?php echo esc_attr($custom_name_stock_number); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_vin_number"><?php echo esc_html__('Custom Name Vin Number', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_vin_number" name="custom_name_vin_number" value="<?php echo esc_attr($custom_name_vin_number); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_city_mpg"><?php echo esc_html__('Custom Name City MPG', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_city_mpg" name="custom_name_city_mpg" value="<?php echo esc_attr($custom_name_city_mpg); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_highway_mpg"><?php echo esc_html__('Custom Name Highway MPG', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_highway_mpg" name="custom_name_highway_mpg" value="<?php echo esc_attr($custom_name_highway_mpg); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_year"><?php echo esc_html__('Custom Name Year', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_year" name="custom_name_year" value="<?php echo esc_attr($custom_name_year); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_door"><?php echo esc_html__('Custom Name Door', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_door" name="custom_name_door" value="<?php echo esc_attr($custom_name_door); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_seat"><?php echo esc_html__('Custom Name Seat', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_seat" name="custom_name_seat" value="<?php echo esc_attr($custom_name_seat); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_mileage"><?php echo esc_html__('Custom Name Mileage', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_mileage" name="custom_name_mileage" value="<?php echo esc_attr($custom_name_mileage); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="custom_name_engine_size"><?php echo esc_html__('Custom Name Engine Size', 'tf-car-listing'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="custom_name_engine_size" name="custom_name_engine_size" value="<?php echo esc_attr($custom_name_engine_size); ?>" class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}