<?php 
/**
 * @var $css_class_field
 * @var $value_color
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (isset($_GET['car_color'])) {
    $value_color = $_GET['car_color'];
}
$custom_name_color = get_option('custom_name_color');
?>
<div class="form-group form-item">
    <label><?php esc_html_e($custom_name_color,'tf-car-listing'); ?></label>
    <select name="car_color" title="<?php esc_attr_e($custom_name_color, 'tf-car-listing') ?>"
        class="search-field" data-default-value="">
        <option value="">
            <?php esc_html_e($custom_name_color, 'tf-car-listing') ?>
        </option>
        <?php tfcl_get_option_advanced_search($value_color,'','car-color'); ?>
    </select>
</div>