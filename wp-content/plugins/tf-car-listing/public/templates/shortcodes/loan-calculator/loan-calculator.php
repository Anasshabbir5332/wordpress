<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_script( 'loan-calculator' );
wp_enqueue_style( 'loan-calculator' );
?>
<form id="loan_calculator_form" class="loan-calculator-form">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="total_amount" class="required"><?php esc_html_e( 'Total Price', 'tf-car-listing' ); ?></label>
				<input type="text" id="total_amount" class="form-control" name="total_amount" value="10000" placeholder="10,000">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="down_payment"><?php esc_html_e( 'Down payment', 'tf-car-listing' ); ?></label>
				<input type="text" id="down_payment" class="form-control" name="down_payment" value="3000" placeholder="3,000">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="amortization_period" class="required"><?php esc_html_e( 'Amortization Period (months)', 'tf-car-listing' ); ?></label>
				<select id="amortization_period" class="form-control" name="amortization_period">
                    <option value="1"><?php esc_html_e('Select Amortization Period', 'tf-car-listing'); ?></option>
                    <option value="1"><?php esc_html_e('1 month', 'tf-car-listing'); ?></option>
                    <option value="2"><?php esc_html_e('2 months', 'tf-car-listing'); ?></option>
                    <option value="3"><?php esc_html_e('3 months', 'tf-car-listing'); ?></option>
                    <option value="4"><?php esc_html_e('4 months', 'tf-car-listing'); ?></option>
                    <option value="5"><?php esc_html_e('5 months', 'tf-car-listing'); ?></option>
                    <option value="6"><?php esc_html_e('6 months', 'tf-car-listing'); ?></option>
                    <option value="7"><?php esc_html_e('7 months', 'tf-car-listing'); ?></option>
                    <option value="8"><?php esc_html_e('8 months', 'tf-car-listing'); ?></option>
                    <option value="9"><?php esc_html_e('9 months', 'tf-car-listing'); ?></option>
                    <option value="10"><?php esc_html_e('10 months', 'tf-car-listing'); ?></option>
                    <option value="11"><?php esc_html_e('11 months', 'tf-car-listing'); ?></option>
                    <option value="12"><?php esc_html_e('12 months', 'tf-car-listing'); ?></option>
                </select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="interest_rate" class="required"><?php esc_html_e( 'Interest rate', 'tf-car-listing' ); ?></label>
				<input type="number" id="interest_rate" class="form-control" name="interest_rate" value="5" placeholder="5">
			</div>
		</div>
		<div class="col-md-12">
			<div class="group-calculator">
				<div class="list-total">
					<span class="label-calculator"><?php esc_html_e( 'Down payment amount', 'tf-car-listing' ); ?></span>
					<span id="down-payment-value" data-sign-currency="<?php echo esc_attr( tfcl_get_option( 'currency_sign' ) ); ?>"></span>
				</div>
				<div class="list-total payment-value">
					<span class="label-calculator"><?php esc_html_e( 'Monthly payment', 'tf-car-listing' ); ?></span>
					<span id="monthly-payment-value" data-sign-currency="<?php echo esc_attr( tfcl_get_option( 'currency_sign' ) ); ?>"></span>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group btn-group">
				<button id="btn_loan_calculate"><?php esc_html_e( 'Apply for a loan', 'tf-car-listing' ) ?></button>
			</div>
		</div>
	</div>
</form>