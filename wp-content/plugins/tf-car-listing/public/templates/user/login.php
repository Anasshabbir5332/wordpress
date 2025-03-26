<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	echo esc_html_e( 'You are logged in!', 'tf-car-listing' );
	return;
}
$show_demo_account = tfcl_get_option( 'show_demo_account', 'y' );
?>
<div class="tfcl_login-form tfcl_account" id="tfcl_login_section">
	<div class="error_message tfcl_message"></div>
	<h4>
		<?php esc_html_e( 'Login', 'tf-car-listing' ); ?>
	</h4>
	<?php if ( $show_demo_account == 'y' ) : ?>
		<ul class="client-account">
			<li><?php esc_html_e( 'Username: ', 'tf-car-listing' ); ?><span><?php esc_html_e( 'demo', 'tf-car-listing' ); ?></span>
			</li>
			<li><?php esc_html_e( 'Password: ', 'tf-car-listing' ); ?><span><?php esc_html_e( 'demo', 'tf-car-listing' ); ?></span>
			</li>
		</ul>
	<?php endif; ?>
	<form class="tfcl_login" method="post" enctype="multipart/form-data" id="tfcl_custom-login-form">
		<div class="form-group">
			<label>
				<?php esc_html_e( 'Account:', 'tf-car-listing' ); ?>
			</label>
			<div class="field-name">
				<input type="text" name="username"
				placeholder="<?php esc_attr_e( 'Your name', 'tf-car-listing' ); ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label>
				<?php esc_html_e( 'Password:', 'tf-car-listing' ); ?>
			</label>
			<div class="input-group show_hide_password field-pass">
				<input type="password" name="password" class="password"
					placeholder="<?php esc_attr_e( 'Your password', 'tf-car-listing' ); ?>" required>
				<div class="input-group-addon">
					<i class="far icon-autodeal-view togglepassword login"
						style="    cursor: pointer;position: absolute;top: 50%;right: 15px;transform: translateY(-50%);font-size: 20px;color: #A3ABB0;"></i>
				</div>
			</div>
		</div>
		<div>
			<a href="javascript:void(0)" class="tfcl-reset-password" id="tfcl-reset-password">
				<?php esc_html_e( 'Forgot password', 'tf-car-listing' ) ?>
			</a>
		</div>
		<button type="submit">
			<?php esc_html_e( 'Login', 'tf-car-listing' ); ?>
		</button>
		<div class="container tfcl_register tfcl_notification" id="tfcl_register_redirect">
			<p>
				<?php esc_html_e( 'Don\'t you have an account?', 'tf-car-listing' ); ?>
				<a href="javascript:void(0)" class="tfcl_register_button">
					<?php esc_html_e( 'Register', 'tf-car-listing' ); ?>
				</a>.
			</p>
		</div>
		<div class="form-group media-login">
			<?php if ( User_Public::tfcl_enable_google_login() ) : ?>
				<div class="or-login"> <span><?php esc_html_e( 'or login with', 'tf-car-listing' ); ?></span> </div>
				<a class="tfcl-login-google" href="<?php echo esc_url( $login_google_url ); ?>"><img src="<?php echo TF_PLUGIN_URL . 'public/assets/image/icon/option/google.svg'; ?>" class="icon-single" alt="icon-single"> <?php esc_html_e( 'Login Google', 'tf-car-listing' ); ?></a>
			<?php endif; ?>
		</div>
	</form>
</div>
<div id="tfcl-reset-password-section" style="display: none">
	<?php echo tfcl_get_template_with_arguments( 'user/reset-password.php' ); ?>
	<a href="javascript:void(0)" class="tfcl_login_redirect">
		<?php esc_html_e( 'Back to Login', 'tf-car-listing' ) ?>
	</a>
</div>
<div id="tfcl_register_section" style="display: none">
	<?php echo do_shortcode( '[register_form]' ); ?>
</div>
