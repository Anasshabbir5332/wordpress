<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$login_thumbnail    = !empty(tfcl_get_option( 'login_thumbnail', '' )['url']) ? tfcl_get_option( 'login_thumbnail', '' )['url'] : TF_PLUGIN_URL . "admin/assets/image/login.webp" ;
$register_thumbnail    = !empty(tfcl_get_option( 'register_thumbnail', '' )['url']) ? tfcl_get_option( 'register_thumbnail', '' )['url'] : TF_PLUGIN_URL . "admin/assets/image/register.webp" ;
?>
<div class="modal modal-login fade" id="tfcl_login_register_modal" tabindex="-1" role="dialog">
    <div class="modal-align-item">
        <div class="modal-dialog" role="document">
            <div class="tfcl-login-form">
                <div class="feature-login-form">
					<img alt="author avatar"
						src="<?php echo esc_url($login_thumbnail); ?>" class="thumb-login">
					<img alt="author avatar"
					src="<?php echo esc_url($register_thumbnail); ?>" class="thumb-register">
				</div>
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><i class="icon-autodeal-close"></i></span></button>
                    <?php echo do_shortcode('[login_form]'); ?>
                </div>
            </div>
        </div>
    </div>
</div>