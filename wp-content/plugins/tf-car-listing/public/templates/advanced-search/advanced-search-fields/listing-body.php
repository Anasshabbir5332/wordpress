<?php
/**
 * @var $css_class_field
 * @var $value_body
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$custom_name_body = get_option('custom_name_body', 'Body');
?>
<div class="form-group form-item">
    <label><?php esc_html_e($custom_name_body,'tf-car-listing'); ?></label>
    <select name="body" title="<?php esc_attr_e('Listing ', 'tf-car-listing') . esc_attr($custom_name_body) ?>"
        class="search-field" data-default-value="">
        <option value="">
            <?php esc_html_e($custom_name_body, 'tf-car-listing') ?>
        </option>
        <?php tfcl_get_option_advanced_search($value_body,'','body'); ?>
    </select>
</div>