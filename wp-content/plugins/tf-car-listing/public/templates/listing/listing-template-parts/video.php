<?php
/**
 * @var $listing_data
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$video_url_value = '';
if ($listing_data) {
    $video_url       = get_post_meta($listing_data->ID, 'video_url', true);
    $video_url_value = isset($video_url) ? $video_url : '';
}
$show_hide_listing_fields = tfcl_get_option('show_hide_listing_fields', array());
?>
<?php if ( $show_hide_listing_fields['listing_video_url'] == 1 ) : ?>
<div class="tfcl-field-wrap tfcl-video-sc">
    <div class="tfcl-field-title">
        <h4><?php esc_html_e('Video', 'tf-car-listing'); ?></h4>
        <p><?php esc_html_e('Listing with video gets 6 times higher exposure to buyers. Put your video link here!', 'tf-car-listing'); ?></p>
    </div>
    <div class="tfcl-field tfcl-listing-video">
            <div class="form-group">
                <label><?php esc_html_e('Video URL', 'tf-car-listing'); ?></label>
                <input type="text" class="form-control" name="video_url" id="listing_video_url"
                    placeholder="<?php esc_attr_e('Your URL', 'tf-car-listing'); ?>"
                    value="<?php echo esc_attr($video_url_value); ?>">
            </div>
    </div>
</div>
<?php endif; ?>