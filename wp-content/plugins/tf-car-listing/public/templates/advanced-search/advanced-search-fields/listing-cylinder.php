<?php 
/**
 * @var $css_class_field
 * @var $value_cylinder
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$custom_name_cylinders = get_option('custom_name_cylinders');
?>
<div class="form-group form-item">
    <label><?php esc_html_e($custom_name_cylinders,'tf-car-listing'); ?></label>
    <select name="cylinders" title="<?php esc_attr_e('Listing ', 'tf-car-listing') . esc_attr($custom_name_cylinders); ?>"
        class="search-field" data-default-value="">
        <option value="">
            <?php esc_html_e($custom_name_cylinders, 'tf-car-listing') ?>
        </option>
        <?php tfcl_get_option_advanced_search($value_cylinder,'','cylinders'); ?>
    </select>
</div>