<?php
/**
 * @var $type
 * @var $check_package_available
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
wp_enqueue_script( 'chart' );
?>
<div class="access-permission">
	<div class="alert alert-warning" role="alert">
		<?php
		switch ( $type ) :
			case 'not_login':
				?>
				<p class="account-sign-in"><?php esc_html_e( 'You need login to continue.', 'tf-car-listing' ); ?></p>
				<?php
				break;
			case 'not_permission':
				echo wp_kses_post( __( '<strong>Access Denied!</strong> You can\'t access this feature', 'tf-car-listing' ) );
				break;
			case 'not_allow_submit_listing':
				$enable_submit_listing_from_frontend = tfcl_get_option( 'allow_submit_listing_from_fe', 'y' );
				$all_user_can_submit_listing = tfcl_get_option( 'all_user_can_submit_listing', 'y' );
				if ( $enable_submit_listing_from_frontend != 'y' ) {
					echo wp_kses_post( __( '<strong>Access Denied!</strong> You can\'t access this feature', 'tf-car-listing' ) );
				} else {
					if ( ! current_user_can( 'administrator' ) && $all_user_can_submit_listing != 'y' ) {
						echo wp_kses_post( __( '<strong>Access Denied!</strong> You need to become an dealer to access this feature.', 'tf-car-listing' ) );
					}
				}
				break;
			case 'check_user_package_available':
				if ( $check_package_available != 1 ) {
					switch ( $check_package_available ) {
						case 0:
							echo wp_kses_post( esc_html__( 'You are not yet subscribed package to submit listing! Please click the button below to select a new package.', 'tf-car-listing' ) );
							break;
						case -1:
							echo wp_kses_post( esc_html__( 'Your current listing package has expired! Please click the button below to select a new package.', 'tf-car-listing' ) );
							break;
						case -2:
							echo wp_kses_post( esc_html__( 'Your current listing package doesn\'t allow you to publish any more listing! Please click the button below to select a new package.', 'tf-car-listing' ) );
							break;
					}
				}
				break;
			default:
				break;
		endswitch;
		?>
	</div>
	<?php if ( $type == 'not_login' ) : ?>
		<button title="<?php esc_attr_e( 'Login Or Register', 'tf-car-listing' ); ?>" type="button" class="button"
			data-toggle="modal" data-target="#tfcl_login_register_modal">
			<?php esc_html_e( 'Login Or Register', 'tf-car-listing' ); ?>
		</button>
	<?php endif; ?>
	<?php if ( $type == 'not_permission' ) : ?>
		<a class="button" href="<?php echo esc_url( tfcl_get_permalink( 'my_profile_page' ) ); ?>"
			title="<?php esc_attr_e( 'Go to my profile', 'tf-car-listing' ) ?>"><?php esc_html_e( 'My Profile', 'tf-car-listing' ) ?></a>
	<?php endif; ?>
	<?php if ( $type == 'not_allow_submit_listing' ) : ?>
		<a class="button" href="<?php echo esc_url( tfcl_get_permalink( 'my_profile_page' ) ); ?>"
			title="<?php esc_attr_e( 'Become A Dealer', 'tf-car-listing' ) ?>"><?php esc_html_e( 'Become A Dealer', 'tf-car-listing' ) ?></a>
	<?php endif; ?>
	<?php if ( $type == 'check_user_package_available' ) :
		$packages_link = tfcl_get_permalink( 'package_page' );
		if ( $check_package_available != 1 ) {
			?>
			<a class="button"
				href="<?php echo esc_url( $packages_link ); ?>"><?php $check_package_available == 0 ? esc_html_e( 'Get a listing package', 'tf-car-listing' ) : esc_html_e( 'Upgrade listing package', 'tf-car-listing' ); ?></a>
		<?php } ?>
	<?php endif; ?>
	<a class="button-outline" href="<?php echo esc_url( home_url() ); ?>"
		title="<?php esc_attr_e( 'Back To Home', 'tf-car-listing' ) ?>"><?php esc_html_e( 'Home Page', 'tf-car-listing' ) ?></a>
</div>