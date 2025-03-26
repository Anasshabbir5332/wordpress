<?php
/**
 * @var $listing
 * @var $submit_mode
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<div class="alert-handle-listing">
    <div class="tfcl-message alert alert-success" role="alert">
        <?php
        if (isset($listing)) {
            switch ($listing->post_status):
                case 'publish':
                    if ($submit_mode === 'listing-add') {
                        printf(wp_kses_post(__('Add your listing successfully. To view your listing <a class="accent-color" href="%s">click here</a>.', 'tf-car-listing')), get_permalink($listing->ID));
                    } else {
                        printf(wp_kses_post(__('Your changes have been saved. To view your listing edited <a class="accent-color" href="%s">click here</a>.', 'tf-car-listing')), get_permalink($listing->ID));
                    }
                    break;
                case 'pending':
                    if ($submit_mode === 'listing-add') {
                        printf(wp_kses_post(__('Add your listing successfully. Your listing need approved, it will be visible.', 'tf-car-listing')), get_permalink($listing->ID));
                    } else {
                        echo wp_kses_post(__('Your changes have been saved. Your changes need approved.', 'tf-car-listing'));
                    }
                    break;
                default:
                    break;
            endswitch;
        }
        ?>
    </div>
</div>