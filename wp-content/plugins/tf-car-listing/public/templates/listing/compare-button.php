<?php
if (!defined('ABSPATH')) {
   exit; // Exit if accessed directly
}
$enable_compare = tfcl_get_option('enable_compare', 'y');
?>
<?php if ($enable_compare == 'y'): ?>
   <a class="tfcl-compare-listing hv-tool" data-tooltip="<?php esc_attr_e('Compare', 'tf-car-listing') ?>" href="javascript:void(0)" data-listing-id="<?php the_ID() ?>"
      >
      <i class="fa fa-plus"></i>
   </a>
<?php endif; ?>