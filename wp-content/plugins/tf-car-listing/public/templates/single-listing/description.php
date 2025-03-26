<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$content          = get_the_content();
$listing_id              = get_the_ID();
$show_description = is_array( tfcl_get_option( 'single_listing_panels_manager' ) ) ? tfcl_get_option( 'single_listing_panels_manager' )['description'] : false;
$listing_attachment_meta  = get_post_meta( get_the_ID(), 'attachments_file', false );
$listing_attachments_file = ( isset( $listing_attachment_meta ) && is_array( $listing_attachment_meta ) && count( $listing_attachment_meta ) > 0 ) ? $listing_attachment_meta[0] : '';
$listing_attachments_file = ! empty( $listing_attachments_file ) ? json_decode( $listing_attachments_file ) : array();
$listing_attachments_file = array_unique( $listing_attachments_file );
$car_text_brochures       = get_post_meta( $listing_id, 'text_brochures', true ) ? get_post_meta( $listing_id, 'text_brochures', true ) : '';
if ( $show_description == true ) :
	if ( isset( $content ) && ! empty( $content ) ) : ?>
		<div id="description" class="single-listing-element listing-description">
			<div class="tfcl-listing-header">
				<h4><?php esc_html_e( 'Description', 'tf-car-listing' ); ?></h4>
			</div>
			<div class="tfcl-listing-info tf-show-hide-description" data-show="<?php esc_attr_e( 'Show More', 'tf-car-listing' ); ?>" data-hide="<?php esc_attr_e( 'Hide Less', 'tf-car-listing' ); ?>">
				<div class="inner <?php echo strlen($content) > 500 ? 'hide-content' : ''; ?>">
					<?php the_content();?>
				</div>
			<?php if ( strlen($content) > 500 ) : ?>
				<span class="button-show-hide hide"><?php esc_attr_e( 'Show More', 'tf-car-listing' ); ?></span>
			<?php endif;?>
			</div>

			<div class="list-file">
			<?php
				foreach ( $listing_attachments_file as $attach_id ) :
					$attach_url     = isset($attach_id) ? wp_get_attachment_url( $attach_id ) : '';
					$file_type      = wp_check_filetype( $attach_url );
					$file_type_name = isset( $file_type['ext'] ) ? $file_type['ext'] : '';

					if ( ! empty( $file_type_name ) && $attach_url ) :
						$thumb_url = TF_PLUGIN_URL . 'public/assets/image/attachment/attach-' . $file_type_name . '.png';
						$file_name = basename( $attach_url );
						$name = $car_text_brochures != '' ? $car_text_brochures : $file_name;  
						?>
						<a target="_blank" href="<?php echo esc_url( $attach_url ); ?>" class="button"> <img loading="lazy" src="<?php echo esc_url( $thumb_url ); ?>"
						alt="<?php echo esc_html( $file_name ) ?>"> <?php echo esc_html($name, 'tf-car-listing'); ?></a>
						<?php
					endif;
				endforeach;
				?>
			</div>
		</div>
	<?php endif;
endif; ?>