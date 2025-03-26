<?php
/**
 * @var $invoice_id
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$invoice = get_post( $invoice_id );
if ( $invoice->post_type !== 'invoice' ) {
	esc_html_e( 'Invoice ineligible to print!', 'tf-car-listing' );
	return;
}

wp_enqueue_script( 'jquery' );
wp_dequeue_script( 'datetimepicker' );
wp_add_inline_script( 'jquery', "jQuery(window).on('load',function(){ print(); });" );

$page_name                 = get_bloginfo( 'name', '' );
$package_currency_sign     = tfcl_get_option( 'package_currency_sign', '$' );
$package_currency_position = tfcl_get_option( 'package_currency_sign_position', 'before' );
$company_address           = tfcl_get_option( 'invoice_company_address', '' );
$company_name              = tfcl_get_option( 'invoice_company_name', '' );
$company_phone             = tfcl_get_option( 'invoice_company_phone', '' );
$payment_method            = get_post_meta( $invoice_id, 'invoice_payment_method', true );
$payment_status            = get_post_meta( $invoice_id, 'invoice_payment_status', true );
$price                     = get_post_meta( $invoice_id, 'invoice_price', true );
$purchase_date             = get_post_meta( $invoice_id, 'invoice_purchase_date', true );
$package_id                = get_post_meta( $invoice_id, 'invoice_package_id', true );
$package_name              = get_the_title( $package_id );
$user_id                   = get_post_meta( $invoice_id, 'invoice_user_id', true );
$dealer_id                 = get_the_author_meta( 'author_dealer_id', $user_id );
$dealer_status             = get_post_status( $dealer_id );

if ( $dealer_id != '' ) {
	if ( $dealer_status == 'publish' ) {
		$dealer_name  = get_the_title( $dealer_id );
		$dealer_email = get_post_meta( $dealer_id, 'dealer_email', true );
	} else {
		$user_first_name = get_the_author_meta( 'first_name', $user_id );
		$user_last_name  = get_the_author_meta( 'last_name', $user_id );
		$user_email      = get_the_author_meta( 'user_email', $user_id );
		if ( empty( $user_first_name ) && empty( $user_last_name ) ) {
			$dealer_name = get_the_author_meta( 'user_login', $user_id );
		} else {
			$dealer_name = $user_first_name . ' ' . $user_last_name;
		}
		$dealer_email = $user_email;
	}
}
?>
<html <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
</head>
<body>
	<div class="single-invoice-wrap invoice-details">
		<div class="card card-body invoice-details-body">
			<div class="page-info mb-2 text-center">
				<div class="invoice-info mb-4">
					<h3 class="invoice-title">
						<?php printf( __( 'Invoice from %s', 'tf-car-listing' ), $page_name ); ?>
					</h3>
					<p class="invoice-id">
						<?php printf( __( 'Invoice #%s', 'tf-car-listing' ), $invoice_id ); ?>
					</p>
				</div>
			</div>
			<div class="single-invoice-info row mb-4">
				<div class="dealer-company-info col-md-6 mb-4 mb-md-0">
					<p class="invoice-info-label">
						<strong><?php esc_html_e( 'Invoice from', 'tf-car-listing' ) ?></strong>
					</p>
					<?php if ( ! empty( $company_name ) ) : ?>
						<div class="invoice-name">
							<?php echo esc_html( $company_name ); ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $company_address ) ) : ?>
						<div class="invoice-details company-address">
							<?php echo esc_html( $company_address ); ?>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $company_phone ) ) : ?>
						<div class="invoice-details company-phone">
							<?php echo esc_html( $company_phone ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="dealer-main-info col-md-6 mb-4 text-md-end">
					<div class="text-md-start float-md-end">
						<p class="invoice-info-label">
							<strong><?php esc_html_e( 'Invoice to', 'tf-car-listing' ) ?></strong>
						</p>
						<?php if ( ! empty( $dealer_name ) ) : ?>
							<div class="invoice-name">
								<?php echo esc_html( $dealer_name ); ?>
							</div>
						<?php endif; ?>
						<?php if ( ! empty( $dealer_email ) ) : ?>
							<div class="invoice-details dealer-email">
								<?php echo esc_html( $dealer_email ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="invoice-info">
				<table class="table table-mobile">
					<tbody>
						<tr>
							<th><?php esc_html_e( 'Package Name:', 'tf-car-listing' ); ?></th>
							<td><?php echo esc_html( $package_name ); ?></td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Payment Method:', 'tf-car-listing' ); ?></th>
							<td><?php echo esc_html( Invoice_Public::tfcl_get_invoice_payment_method( $payment_method ) ); ?>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Purchase Date:', 'tf-car-listing' ); ?></th>
							<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $purchase_date ) ); ?>
							</td>
						</tr>
						<tr>
							<th><?php esc_html_e( 'Total Price:', 'tf-car-listing' ); ?></th>
							<td><?php
							if ( $package_currency_position == 'before' ) {
								$price = '<span class="price-currency-sign">' . esc_html( $package_currency_sign ) . '</span><span class="price">' . tfcl_get_format_number( floatval( $price ) ) . '</span>';
							} else {
								$price = '<span class="price">' . tfcl_get_format_number( floatval( $price ) ) . '</span><span
								class="price-currency-sign">' . esc_html( $package_currency_sign ) . '</span>';
							}
							echo __( $price ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>