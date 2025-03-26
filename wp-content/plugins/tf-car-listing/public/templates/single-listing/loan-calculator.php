<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$show_loan_calculator = is_array( tfcl_get_option( 'single_listing_panels_manager' ) ) ? tfcl_get_option( 'single_listing_panels_manager' )['loan-calculator'] : false;
if ( $show_loan_calculator == true ) : ?>
	<div id="loan-calculator" class="single-listing-element listing-loan-calculator">
		<div class="tfcl-listing-header">
			<h4><?php esc_html_e( 'Auto Loan Calculator', 'tf-car-listing' ); ?></h4>
			<p><?php esc_html_e( 'Use our calculator to estimate your monthly car payments.', 'tf-car-listing' ); ?></p>
		</div>
		<div class="listing-element row">
			<?php echo do_shortcode( '[loan_calculator]' ); ?>
		</div>
	</div>
<?php endif; ?>