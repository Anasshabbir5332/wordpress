<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_style( 'dashboard-css' );
$payment_public = new Payment_Public();
$payment_method = isset( $_GET['payment_method'] ) ? absint( wp_unslash( $_GET['payment_method'] ) ) : -1;
?>
<div class="payment-complete-wrap">
	<?php
	if ( $payment_method == 1 ) {
		$payment_public->tfcl_payment_completed_by_paypal();
		?>
		<div class="heading">
			<h2><?php echo wp_kses_post( tfcl_get_option( 'thankyou_title', '' ) ); ?></h2>
		</div>
		<div class="payment-completed-content">
			<?php
			$html_info = tfcl_get_option( 'thankyou_paypal_stripe_content', '' );
			echo wpautop( $html_info );
			?>
		</div>
		<?php
	} else if ( $payment_method == 2 ) {
		?>
			<div class="heading">
				<h2><?php echo wp_kses_post( tfcl_get_option( 'thankyou_title', '' ) ); ?></h2>
			</div>
			<div class="payment-completed-content">
				<?php
				$html_info = tfcl_get_option( 'thankyou_wire_transfer_content', '' );
				echo wpautop( $html_info );
				?>
			</div>
		<?php
	} else if ( $payment_method == 3 ) {
		?>
				<div class="heading">
					<h2><?php echo wp_kses_post( tfcl_get_option( 'thankyou_title', '' ) ); ?></h2>
				</div>
		<?php
	} else if ( $payment_method == 4 ) {
		$payment_public->tfcl_payment_completed_by_stripe();
		?>
					<div class="heading">
						<h2><?php echo wp_kses_post( tfcl_get_option( 'thankyou_title', '' ) ); ?></h2>
					</div>
					<div class="payment-completed-content">
				<?php
				$html_info = tfcl_get_option( 'thankyou_paypal_stripe_content', '' );
				echo wpautop( $html_info );
				?>
					</div>
		<?php
	} else {
		?>
					<div class="heading">
						<h2><?php echo wp_kses_post( __( 'Transaction Failed', 'tf-car-listing' ) ); ?></h2>
					</div>
		<?php
	}
	?>
	<a href="<?php echo esc_url( tfcl_get_permalink( 'dashboard_page' ) ); ?>"
		class="btn-submit"><?php esc_html_e( 'Go Back', 'tf-car-listing' ); ?></a>
</div>