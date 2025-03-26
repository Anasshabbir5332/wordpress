<?php
/**
 * @var $parameters
 * @var $search_query
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
wp_enqueue_script( 'chart' );
?>
<div class="modal fade save_search_advanced_modal" id="save_search_advanced_modal" tabindex="-1" role="dialog"
    aria-labelledby="SaveSearchModalLabel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" id="SaveSearchModalLabel"><?php esc_html_e('Saved Search', 'tf-car-listing'); ?>
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form></form><!-- don't remove this form, to save search form not hidden -->
                <div class="alert alert-warning" role="alert">
                    <i class="fa fa-info-circle"></i>
                    <?php esc_html_e('You will receive an email notification whenever have a new car that matching with your condition advanced search saved.', 'tf-car-listing'); ?>
                </div>
                <form id="tfcl_save_search_form" method="post">
                    <div class="form-group">
                        <label for="tfcl_title"><?php esc_html_e('Title', 'tf-car-listing'); ?></label>
                        <input type="text" name="title" id="tfcl_title"
                            placeholder="<?php esc_attr_e('Input title', 'tf-car-listing'); ?>" class="form-control"
                            value="" aria-describedby="parameters" required>
                        <input type="hidden" name="parameters"
                            value="<?php echo esc_attr(base64_encode($parameters)); ?>">
                        <input type="hidden" name="search_query"
                            value="<?php echo esc_attr(base64_encode(serialize($search_query))); ?>">
                        <input type="hidden" name="url_request"
                            value="<?php echo esc_url(sanitize_url($_SERVER['REQUEST_URI'])) ?>">
                        <input type="hidden" name="action" value='tfcl_save_advanced_search_ajax'>
                        <input type="hidden" name="tfcl_save_search_nonce"
                            value="<?php echo wp_create_nonce('tfcl_save_search_nonce_field') ?>">
                        <small id="parameters"
                            class="form-text text-muted"><?php echo wp_kses_post(sprintf(esc_html__('Parameters: %s', 'tf-car-listing'), $parameters)); ?></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-default"
                    data-dismiss="modal"><?php esc_html_e('Close', 'tf-car-listing'); ?></button>
                <button id="tfcl_save_search" class="btn btn-primary" type="button"><?php esc_html_e('Save', 'tf-car-listing'); ?></button>
            </div>
        </div>
    </div>
</div>