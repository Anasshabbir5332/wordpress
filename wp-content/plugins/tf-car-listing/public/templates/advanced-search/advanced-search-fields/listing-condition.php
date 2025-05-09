<?php 
/**
 * @var $css_class_field
 * @var $value_condition
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$custom_name_condition = get_option('custom_name_condition', 'condition');
?>
<div class="form-group form-item">
    <label><?php esc_html_e($custom_name_condition,'tf-car-listing'); ?></label>
    <select name="condition" id="condition" title="<?php esc_attr_e('Listing ', 'tf-car-listing') . esc_attr($custom_name_condition); ?>"
        class="search-field" data-default-value="">
        <option value="">
            <?php esc_html_e($custom_name_condition, 'tf-car-listing') ?>
        </option>
        <?php tfcl_get_option_advanced_search($value_condition,'','condition'); ?>
    </select>
</div>