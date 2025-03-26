<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="tfcl-resset-password tfcl_account">
	<div class="tfcl_messages message tfcl_messages_reset_password"></div>
	<form method="post" enctype="multipart/form-data">
		<h4>
			<?php esc_html_e( 'Forgot your password?', 'tf-car-listing' ); ?>
		</h4>
		<div class="form-group control-username">
			<input name="user_login" class="form-control control-icon reset_password_user_login"
				placeholder="<?php esc_attr_e( 'Enter your username or email', 'tf-car-listing' ); ?>">
			<input type="hidden" name="tfcl_security_reset_password" value="<?php echo wp_create_nonce( 'tfcl_reset_password_ajax_nonce' ); ?>" />
			<input type="hidden" name="action" value="reset_password_ajax">
			<button type="submit" class=" tfcl_forgetpass">
				<?php esc_html_e( 'Get new password', 'tf-car-listing' ); ?>
			</button>
		</div>
	</form>
</div>