<?php
/**
 * @var $listing_data
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$listing_id               = $listing_data ? $listing_data->ID : null;
$car_text_brochures             = $listing_data ? get_post_meta( $listing_data->ID, 'text_brochures', true ) : '';
if (isset($listing_data)) {
    $listing_attachment_meta  = get_post_meta($listing_data->ID, 'attachments_file', false);
    $listing_attachments_file = (isset($listing_attachment_meta) && is_array($listing_attachment_meta) && count($listing_attachment_meta) > 0) ? $listing_attachment_meta[0] : '';
    $listing_attachments_file = !empty($listing_attachments_file) ? json_decode($listing_attachments_file) : array();
    $listing_attachments_file = array_unique($listing_attachments_file);

}
$show_hide_listing_fields = tfcl_get_option('show_hide_listing_fields', array());
?>
<?php if ( $show_hide_listing_fields['attachments_file'] == 1 ) : ?>
<div class="tfcl-field-wrap tfcl-file-attachment">
    <div class="tfcl-field-title">
        <h4><?php esc_html_e('Attachments', 'tf-car-listing'); ?></h4>
    </div>
    <div class="tfcl-field tfcl-listing-attachment">
		<div class="form-group">
			<label
				for="text_brochures"><?php echo esc_html__( 'Text Attachments File', 'tf-car-listing' ); ?></label>
			<input type="text" id="text_brochures" class="form-control" name="text_brochures"
				value="<?php echo esc_attr( $car_text_brochures ); ?>">
		</div>
        <div class="form-group">
            <div class="media-attachment">
                <div id="tfcl_listing_attachment_container" class="row">
                    <?php
                        if (!empty($listing_attachments_file) && is_array($listing_attachments_file)) {
                            foreach ($listing_attachments_file as $attach_id) {
                                $attach_url = wp_get_attachment_url($attach_id);
                                if ($attach_url) {
                                    $file_type      = wp_check_filetype($attach_url);
                                    $file_type_name = isset($file_type['ext']) ? $file_type['ext'] : '';
                                    $thumb_url      = TF_PLUGIN_URL . 'public/assets/image/attachment/attach-' . $file_type_name . '.png';  
                                    $file_name      = basename($attach_url);
                                    echo '<div class="col-xl-2 col-lg-3 col-md-4 file-attachment-wrap __thumb">';
                                    echo '<figure class="attachment-file">';
                                    echo '<img loading="lazy" src="' . esc_url($thumb_url) . '">';
                                    echo '<a href="' . esc_url($attach_url) . '">' . esc_html($file_name) . '</a>';
                                    echo '<div class="media-item-actions">';
                                    echo '<a class="icon icon-delete" data-listing-id="' . esc_attr(intval($listing_data->ID)) . '" data-attachment-id="' . esc_attr(intval($attach_id)) . '" href="javascript:void(0)">';
                                    echo '<i class="fa fa-times"></i>';
                                    echo '</a>';
                                    echo '<input type="hidden" class="attachments_file" name="attachments_file[]" value="' . esc_attr(intval($attach_id)) . '">';
                                    echo '<span style="display: none;" class="icon icon-loader">';
                                    echo '<i class="fa fa-spinner fa-spin"></i>';
                                    echo '</span>';
                                    echo '</div>';
                                    echo '</figure>';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    <div id="tfcl_attachment_plupload_container" class="col-xl-2 col-lg-3 col-md-4 media-drag-drop">
                        <div class="card-upload-media">
                            <button type="button" id="tfcl_choose_attachment_files">
                                <span class="icon"><?php echo themesflat_svg('upload'); ?></span>
                                <span><?php esc_html_e('Upload file', 'tf-car-listing'); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tfcl_attachment_errors"></div>
        </div>
    </div>
</div>
<?php endif; ?>