<?php
/**
 * @var $listing_data
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$listing_images = array();
if (isset($listing_data)) {
    $listing_images = get_post_meta($listing_data->ID, 'gallery_images', true);
    $listing_images = !empty($listing_images) ? json_decode($listing_images) : array();
    $listing_images = array_unique($listing_images);
}
$show_hide_listing_fields = tfcl_get_option('show_hide_listing_fields', array());
?>
<?php if ( $show_hide_listing_fields['gallery_images'] == 1 ) : ?>
<div class="tfcl-field-wrap tfcl-upload-media">
    <div class="tfcl-field-title">
        <h3><?php esc_html_e('Upload Photo', 'tf-car-listing'); ?></h3>
    </div>
    <div class="tfcl-field tfcl-listing-gallery">
            <div class="form-group">
                <div id="tfcl_gallery_plupload_container" class="media-drag-drop">
                    <div class="card-upload-media">
                            <button type="button" id="tfcl_choose_gallery_images">
                            <i class="icon-autodeal-image"></i>
                            <span><?php esc_html_e('Select photos', 'tf-car-listing'); ?></span>
                        </button>
                        <div class="desc"><?php esc_html_e('or drag photos here', 'tf-car-listing'); ?> <br> <span><?php esc_html_e('(Up to 10 photos)', 'tf-car-listing'); ?></span> </div>
                    </div>
                </div>
                <div class="media-gallery">
                    <div id='sortable'>
                        <ul id="tfcl_listing_gallery_container" class="row">
                            <?php
                                if (!empty($listing_images) && is_array($listing_images)) {
                                    foreach ($listing_images as $attach_id) {
                                        if (wp_get_attachment_image_url($attach_id)) {
                                            echo '<li class="sortable_item col-sm-2 media-gallery-wrap __thumb">';
                                            echo '<figure class="media-thumb">';
                                            echo '<img loading="lazy" src="' . esc_attr(wp_get_attachment_image_url( $attach_id, true )) . '"/>';
                                            echo '<div class="media-item-actions">';
                                            echo '<a class="icon icon-delete" data-listing-id="' . esc_attr(intval($listing_data->ID)) . '" data-img-id="' . esc_attr(intval($attach_id)) . '" href="javascript:void(0)">';
                                            echo '<i class="icon-autodeal-trash"></i>';
                                            echo '</a>';
                                            echo '<input type="hidden" class="gallery_images" name="gallery_images[]" value="' . esc_attr(intval($attach_id)) . '">';
                                            echo '<span style="display: none;" class="icon icon-loader">';
                                            echo '<i class="fa fa-spinner fa-spin"></i>';
                                            echo '</span>';
                                            echo '</div>';
                                            echo '</figure>';
                                            echo '</li>';
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div id="tfcl_gallery_errors"></div>
            </div>
    </div>
</div>
<?php endif; ?>