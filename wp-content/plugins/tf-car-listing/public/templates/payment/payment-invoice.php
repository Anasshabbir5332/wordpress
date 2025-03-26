<?php
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
wp_enqueue_style( 'tf-pricetable' );
wp_enqueue_script( 'stripe-v3' );
wp_enqueue_script( 'payment-script' );
wp_enqueue_style( 'dashboard-css' );

$package_currency_sign       = tfcl_get_option( 'package_currency_sign', '$' );
$package_currency_position   = tfcl_get_option( 'package_currency_sign_position', 'before' );
$enable_paypal               = tfcl_get_option( 'enable_paypal_setting', 'n' );
$enable_wire_transfer        = tfcl_get_option( 'enable_wire_transfer_setting', 'n' );
$enable_stripe               = tfcl_get_option( 'enable_stripe_setting', 'n' );
$package_page_link           = tfcl_get_permalink( 'package_page' );
$payment_term_condition_link = tfcl_get_permalink( 'payment_term_condition' );
$allowed_html                = array(
	'a'      => array(
		'href'   => array(),
		'title'  => array(),
		'target' => array()
	),
	'strong' => array()
);

global $current_user;
$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
$package_id   = isset( $_GET['package_id'] ) ? absint( wp_unslash( $_GET['package_id'] ) ) : '';
if ( empty( $package_id ) ) {
	return;
}
$package_title           = get_the_title( $package_id );
$user_package_id         = get_the_author_meta( 'package_id', $user_id );
$check_package_available = User_Package_Public::tfcl_check_user_package_available( $user_id );
$package_free            = get_post_meta( $package_id, 'package_free', true );
$package_price           = floatval( get_post_meta( $package_id, 'package_price', true ) );
$user_package_price      = floatval( get_post_meta( $user_package_id, 'package_price', true ) );
if ( $package_free == 1 ) {
	$package_price       = 0;
	$package_price_value = $package_price;
}
if ( $package_currency_position == 'before' ) {
	$package_price_value = '<span class="price-type">' . esc_html( $package_currency_sign ) . '</span><span class="price">' . tfcl_get_format_number( floatval( $package_price ) ) . '</span>';
} else {
	$package_price_value = '<span class="price">' . tfcl_get_format_number( floatval( $package_price ) ) . '</span><span class="price-type">' . esc_html( $package_currency_sign ) . '</span>';
}

$package_unlimited_listing = get_post_meta( $package_id, 'package_unlimited_listing', true );
$package_number_listing    = get_post_meta( $package_id, 'package_number_listing', true );
$package_unlimited_time    = get_post_meta( $package_id, 'package_unlimited_time', true );

if ( $package_unlimited_time == 1 ) {
	$package_time_unit         = esc_html__( 'Never Expires', 'tf-car-listing' );
	$package_time_unit_content = $package_time_unit;
} else {
	$package_time_unit        = get_post_meta( $package_id, 'package_time_unit', true );
	$package_number_time_unit = get_post_meta( $package_id, 'package_number_time_unit', true );
	if ( $package_number_time_unit > 1 ) {
		$package_time_unit .= 's';
	}
	$package_time_unit_content = ( ! empty( $package_number_time_unit ) ? $package_number_time_unit : 0 ) . ' ' . $package_time_unit;
}

if ( $package_unlimited_listing == 1 ) {
	$package_number_listing = esc_html__( 'Unlimited', 'tf-car-listing' );
} else {
	$package_number_listing = ( ! empty( $package_number_listing ) && $package_number_listing > 0 ) ? $package_number_listing : 0;
}
$package_number_listing_content = $package_number_listing;
$package_popular                = get_post_meta( $package_id, 'package_popular', true );
?>
<div class="package-wrap-table">
<div class="payment-invoice-wrap row">
	<div class="col-lg-4 col-md-12">
		<div class="payment-invoice">
			<h2 class="panel-heading">
				<?php esc_html_e( 'Selected Package', 'tf-car-listing' ); ?>
			</h2>
			<div class="tf-pricetable setactive">
				<div class="header-price">
					<div class="title"><?php esc_html_e( $package_title ); ?></div>
					<div class="content-price"><?php echo __( $package_price_value ); ?></div>
				</div>
				<div class="content-list">
					<div class="inner-content-list">
						<div class="item">
							<span class="wrap-icon"><i class="icon-autodeal-icon-144"></i></span>
							<span
								class="text"><?php echo sprintf( __( 'Active Listing Quota: <strong>%s</strong>', 'tf-car-listing' ), $package_number_listing_content ) ?></span>
						</div>
						<div class="item">
							<span class="wrap-icon"><i class="icon-autodeal-icon-144"></i></span>
							<span
								class="text"><?php echo sprintf( __( 'Expiration Date: <strong>%s</strong>', 'tf-car-listing' ), $package_time_unit_content ); ?></span>
						</div>
					</div>
				</div>
				<div class="wrap-button">
					<a href="<?php echo esc_url( $package_page_link ); ?>" class="tf-btn">
						<?php esc_html_e( 'Change Package', 'tf-car-listing' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-12">
		<?php if ( ( $check_package_available == 1 ) && ( $package_id == $user_package_id ) ) : ?>
			<div class="alert alert-warning" role="alert">
				<?php echo sprintf( __( 'Your currently "%s" package hasn\'t expired yet, so you can\'t buy it at this time. If you would like, you can buy another package.', 'tf-car-listing' ), $package_title ); ?>
			</div>
		<?php elseif ( ( $check_package_available == 1 ) && ( $package_price < $user_package_price ) ) : ?>
			<div class="alert alert-warning" role="alert">
				<?php echo sprintf( __( 'If you would like upgrade your package, you have to buy another package with price more than currently package.', 'tf-car-listing' ), $package_title ); ?>
			</div>
		<?php else : ?>
			<?php if ( is_numeric( $package_price ) && $package_price > 0 ) : ?>
				<div class="payment-method-wrap">
					<div class="heading">
						<h2><?php esc_html_e( 'Payment Method', 'tf-car-listing' ); ?></h2>
					</div>
					<?php if ( $enable_paypal != 'n' ) : ?>
						<label for="payment-paypal">
							<input type="radio" id="payment-paypal" class="payment-paypal" name="payment_method" value="paypal"
								checked />
							<?php esc_html_e( 'Pay with Paypal', 'tf-car-listing' ); ?>
						</label>
					<?php endif; ?>
					<?php if ( $enable_wire_transfer != 'n' ) : ?>
						<label for="payment-wire-transfer">
							<input type="radio" id="payment-wire-transfer" class="payment-wire-transfer" name="payment_method"
								value="wire_transfer" />
							<?php esc_html_e( 'Wire Transfer', 'tf-car-listing' ); ?>
						</label>
						<div class="wire-transfer-info">
							<?php
							$wire_transfer_information = tfcl_get_option( 'wire_transfer_information' );
							echo wpautop( $wire_transfer_information );
							?>
						</div>
					<?php endif; ?>
					<?php if ( $enable_stripe != 'n' ) : ?>
						<label for="payment-stripe">
							<input type="radio" id="payment-stripe" class="payment-stripe" name="payment_method" value="stripe" />
							<?php esc_html_e( 'Stripe', 'tf-car-listing' ); ?>
						</label>
						<?php if ( tfcl_get_option( 'stripe_version', 'legacy' ) == 'legacy' ) {
							Payment_Public::tfcl_handle_payment_invoice_by_stripe( $package_id );
						} ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<p class="term-condition">
				<?php echo sprintf( wp_kses( __( 'Please read <a target="_blank" href="%s"><strong>Terms & Conditions</strong></a> first', 'tf-car-listing' ), $allowed_html ), $payment_term_condition_link ); ?>
			</p>
			<?php if ( is_numeric( $package_price ) && $package_price > 0 ) : ?>
				<button id="payment_per_package" type="submit" class="btn-submit">
					<?php esc_html_e( 'Pay Now', 'tf-car-listing' ); ?>
				</button>
			<?php else :
				$user_free_package = get_the_author_meta( 'free_package', $user_id );
				if ( $user_free_package == 'yes' ) : ?>
					<div class="tfcl-message alert alert-warning" role="alert">
						<?php esc_html_e( 'You have already used your first free package, please choose different package.', 'tf-car-listing' ); ?>
					</div>
				<?php else : ?>
					<button id="free_package" type="submit" class="btn-submit">
						<?php esc_html_e( 'Get Free Package', 'tf-car-listing' ); ?>
					</button>
				<?php endif; ?>
			<?php endif; ?>
			<input type="hidden" name="package_id" value="<?php echo esc_attr( $package_id ); ?>" />
			<?php wp_nonce_field( 'tfcl_payment_ajax_nonce', 'tfcl_security_payment' ); ?>
		<?php endif; ?>
	</div>
</div>
				</div>