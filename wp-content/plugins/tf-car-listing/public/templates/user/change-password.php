<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}
?>
<div class="change-password-container">
	<h3 class="heading form-title"><?php esc_html_e( 'Password change request', 'tf-car-listing' ); ?></h3>
	<div class="profile-wrap change-password">
		<form action="#" class="tfcl-change-password">
			<div id="password_reset_msgs" class="tfcl_message message"></div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label for="old_pass"><?php esc_html_e( 'Old Password', 'tf-car-listing' ); ?></label>
						<div class="input-group" id="show_hide_old_pass">
							<input id="old_pass" value="" name="old_pass" type="password">
							<div class="input-group-addon">
								<i class="far icon-autodeal-view" id="toggleOldPass"
									style="    cursor: pointer;position: absolute;top: 50%;right: 15px;transform: translateY(-50%);font-size: 20px;color: #A3ABB0;"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label for="new_pass"><?php esc_html_e( 'New Password ', 'tf-car-listing' ); ?></label>
						<div class="input-group" id="show_hide_new_pass">
							<input id="new_pass" value="" name="new_pass" type="password">
							<div class="input-group-addon">
								<i class="far icon-autodeal-view" id="toggleNewPass"
									style="    cursor: pointer;position: absolute;top: 50%;right: 15px;transform: translateY(-50%);font-size: 20px;color: #A3ABB0;"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<label for="confirm_pass"><?php esc_html_e( 'Confirm Password', 'tf-car-listing' ); ?></label>
						<div class="input-group" id="show_hide_confirm_password">
							<input id="confirm_pass" value="" name="confirm_pass" type="password">
							<div class="input-group-addon">
								<i class="far icon-autodeal-view confirmpassword" id="toggleConfirmPassword"
									style="    cursor: pointer;position: absolute;top: 50%;right: 15px;transform: translateY(-50%);font-size: 20px;color: #A3ABB0;"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php wp_nonce_field( 'tfcl_change_password_ajax_nonce', 'tfcl_security_change_password' ); ?>
			<button type="button" class="button display-block" id="tfcl_change_pass">
				<span><?php esc_html_e( 'Update Password', 'tf-car-listing' ); ?></span>
			</button>
		</form>
	</div>
</div>