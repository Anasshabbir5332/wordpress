<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$css_class_col = 'col-md-3 col-sm-4 col-xs-12';
?>
<div class="tfcl_message"></div>
<div class="cards-container row">
    <?php if ($listing->have_posts()):
        while ($listing->have_posts()):
            $listing->the_post();
            $listing_id = get_the_ID();
            $attach_id   = get_post_thumbnail_id();
            tfcl_get_template_with_arguments(
                'listing/card-item-listing.php',
                array(
                    'listing_id'   => $listing_id,
                    'attach_id'     => $attach_id,
                    'css_class_col' => $css_class_col
                )
            );
        endwhile;
    else: ?>
        <div class="item-not-found"><?php esc_html_e('No item found', 'tf-car-listing'); ?></div>
        <?php endif; ?>
        <?php tfcl_get_template_with_arguments( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
</div>
<?php
wp_reset_postdata();