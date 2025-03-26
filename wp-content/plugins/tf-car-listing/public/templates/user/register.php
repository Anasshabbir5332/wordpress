<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (is_user_logged_in()) {
    echo esc_html_e('You are logged in!', 'tf-car-listing');
    return;
}
$login_google_url = User_Public::tfcl_enable_google_login() ? $this->google_client->tfcl_get_authorization_url() : '';
?>
<div class="tfcl_registration-form tfcl_account">
    <div class="error_message tfcl_message"></div>
    <h4>
        <?php esc_html_e('Register', 'tf-car-listing'); ?>
    </h4>
    <form class="tfcl_register" method="post" enctype="multipart/form-data" id="tfcl_custom-register-form">
            <div class="form-group">
                <label>
                    <?php esc_html_e('User Name:', 'tf-car-listing'); ?>
                </label>
                <div class="inner field-name">
                    <input type="text" name="username" placeholder="<?php esc_attr_e('User name', 'tf-car-listing'); ?>"
                        required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">
                    <?php esc_html_e('Email:', 'tf-car-listing'); ?>
                </label>
                <div class="inner field-mail">
                    <input type="email" name="email" id="email"
                        placeholder="<?php esc_attr_e('Your Email', 'tf-car-listing'); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <?php esc_html_e('Password:', 'tf-car-listing'); ?>
                </label>
                <div class="input-group show_hide_password field-pass">
                    <input type="password" name="password" class="password"
                        placeholder="<?php esc_attr_e('Your password', 'tf-car-listing'); ?>" required>
                    <div class="input-group-addon">
                        <i class="far icon-autodeal-view togglepassword register"
                            style="    cursor: pointer;position: absolute;top: 50%;right: 15px;transform: translateY(-50%);font-size: 20px;color: #A3ABB0;"></i>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">
                    <?php esc_html_e('Confirm Password:', 'tf-car-listing'); ?>
                </label>
                <div class="input-group field-pass" id="show_hide_confirm_password">
                    <input type="password" name="confirm_password" id="confirm_password"
                        placeholder="<?php esc_attr_e('Confirm password', 'tf-car-listing'); ?>" required>
                    <div class="input-group-addon">
                        <i class="far icon-autodeal-view confirmpassword" id="toggleConfirmPassword"
                            style="    cursor: pointer;position: absolute;top: 50%;right: 15px;transform: translateY(-50%);font-size: 20px;color: #A3ABB0;"></i>
                    </div>
                </div>
            </div>
            <button type="submit">
                <?php esc_html_e('Sign Up', 'tf-car-listing'); ?>
            </button>
        <div class="container tfcl_signin tfcl_login_redirect tfcl_notification" id="tfcl_login_redirect">
            <p>
                <?php esc_html_e('Already have an account?', 'tf-car-listing'); ?>
                <a href="#" class="tfcl_login_redirect_button">
                    <?php esc_html_e('Sign in', 'tf-car-listing'); ?>
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