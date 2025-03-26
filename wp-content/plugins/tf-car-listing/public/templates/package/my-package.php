<?php
/**
 * @var $package_id
 */

if(!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if(!is_user_logged_in()) {
	tfcl_get_template_with_arguments('global/access-permission.php', array( 'type' => 'not_login' ));
	return;
}
wp_enqueue_style('tf-pricetable');
$package_currency_position = tfcl_get_option('package_currency_position', 'before');
$package_currency_sign     = tfcl_get_option('package_currency_sign', '$');
$package_unlimited_time    = get_post_meta($package_id, 'package_unlimited_time', true);
$package_number_listing    = get_user_meta($current_user_id, 'package_number_listing', true);
$package_unlimited_listing = get_post_meta($package_id, 'package_unlimited_listing', true);
$package_price             = get_post_meta($package_id, 'package_price', true);
$package_free              = get_post_meta($package_id, 'package_free', true);

if($package_unlimited_time == 1) {
	$package_expiry_date = esc_html__('Never Expires', 'tf-car-listing');
} else {
	$package_expiry_date = User_Package_Public::tfcl_get_expired_date($package_id, $current_user_id);
}

if($package_unlimited_listing == 1) {
	$package_number_listing = esc_html__('Unlimited', 'tf-car-listing');
} else {
	$package_number_listing = !empty($package_number_listing) && ($package_number_listing > 0) ? $package_number_listing : 0;
}

if($package_free == 1) {
	$package_price = 0;
}

if($package_currency_position == 'before') {
	$package_price = '<span class="currency-sign">'.esc_html($package_currency_sign).'</span><span class="price">'.tfcl_get_format_number(floatval($package_price)).'</span>';
} else {
	$package_price = '<span class="price">'.tfcl_get_format_number(floatval($package_price)).'</span><span class="currency-sign">'.esc_html($package_currency_sign).'</span>';
}

$package_link = tfcl_get_permalink('package_page');
?>
<div class="package-wrap row px-5">
	<?php if(!empty($package_id)): ?>
		<div class="tf-pricetable setactive col-md-6 col-xl-4">
			<div class="header-price">
				<div class="title">
					<?php esc_html_e(get_the_title($package_id)); ?>
				</div>
				<div class="content-price">
					<?php echo __($package_price); ?>
				</div>
			</div>
			<div class="content-list">
				<div class="inner-content-list">
					<div class="item">
						<span class="wrap-icon"><i class="icon-autodeal-icon-144"></i></span>
						<span
							class="text"><?php echo sprintf(__('Active Listing Quota: <strong>%s</strong>', 'tf-car-listing'), $package_number_listing); ?></span>
					</div>
					<div class="item">
						<span class="wrap-icon"><i class="icon-autodeal-icon-144"></i></span>
						<span
							class="text"><?php echo sprintf(__('Expiration Date: <strong>%s</strong>', 'tf-car-listing'), $package_expiry_date); ?></span>
					</div>
				</div>
			</div>
			<div class="wrap-button">
				<a href="<?php echo esc_url($package_link); ?>"
					class="tf-btn"><?php esc_html_e('Upgrade', 'tf-car-listing') ?><span></span></a>
			</div>
		</div>
	<?php else: ?>
		<div class="alert alert-warning" role="alert">
			<?php echo __('You hasn\'t package yet. If you would like, you can buy package.', 'tf-car-listing'); ?>
		</div>
		<div class="wrap-button">
			<a href="<?php echo esc_url($package_link); ?>" class="tf-btn">
				<?php esc_html_e('Buy Package', 'tf-car-listing') ?>
			</a>
		</div>
	<?php endif; ?>
</div>