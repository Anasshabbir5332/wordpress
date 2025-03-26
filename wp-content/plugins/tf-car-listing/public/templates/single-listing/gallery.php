<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
wp_enqueue_style('owl.carousel');
wp_enqueue_script('owl.carousel');
wp_enqueue_style('light-gallery');
wp_enqueue_script('light-gallery');
global $post;
$listing_gallery              = get_post_meta(get_the_ID(), 'gallery_images', true);
$listing_gallery_default              = tfcl_get_option( 'gallery_default_single');
$listing_gallery_image_type   = get_post_meta(get_the_ID(), 'gallery_image_types', true);
$single_listing_gallery_style = !empty ($listing_gallery_image_type) ? $listing_gallery_image_type : $listing_gallery_default;
$listing_location             = get_post_meta(get_the_ID(), 'listing_location', true);
$listing_video                = get_post_meta(get_the_ID(), 'video_url', true);
$show_gallery = is_array(tfcl_get_option( 'single_listing_panels_manager' )) ? tfcl_get_option( 'single_listing_panels_manager' )['gallery'] : false;
$width           = tfcl_get_option( 'image_width_listing', 660 );
$height          = tfcl_get_option( 'image_height_listing', 471 );
if($show_gallery == true) {
    if ($listing_gallery):
        $listing_gallery = json_decode($listing_gallery, true);
        ?>
                      <div class="single-listing-element listing-gallery-wrap">
                        <?php if ($single_listing_gallery_style == 'gallery-style-slider' || $single_listing_gallery_style == 'gallery-style-slider-2'): ?>
                            <div class="tfcl-listing-info single-gallery-slider">
                                <div class="single-listing-image-main slider-1 owl-carousel manual tfcl-carousel-manual">
                                    <?php
                                    $gallery_id = 'tfcl-' . rand();
                                    foreach ($listing_gallery as $image):
                                        $image_full_src = wp_get_attachment_image_src($image, 'full');
                                        if (!empty($image_full_src) && is_array($image_full_src)) {
                                            ?>
                                            <div class="item listing-gallery-item tfcl-light-gallery">
                                                <img loading="lazy" src="<?php echo esc_url($image_full_src[0]) ?>" alt="<?php the_title(); ?>"
                                                    title="<?php the_title(); ?>">
                                                    <a data-thumb-src="<?php echo esc_url($image_full_src[0]); ?>"
                                                            data-gallery-id="<?php echo esc_attr($gallery_id); ?>" data-rel="tfcl_light_gallery"
                                                            href="<?php echo esc_url($image_full_src[0]); ?>" class="zoomGallery">
                                                            
                                                    </a>
                                                            <ul class="list-control-gallery">
                                                                <?php if (!empty($listing_video)): ?>
                                                                    <li>
                                                                        <span data-src="<?php echo esc_url($listing_video); ?>" class="tfcl-view-video"><?php echo themesflat_svg('camera'); ?><?php esc_html_e( 'Video', 'tf-car-listing' ); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <li>
                                                                    <span class="show-gallery"> <?php echo themesflat_svg('image'); ?> <?php esc_html_e( 'All image', 'tf-car-listing' ); ?></span>
                                                                </li>
                                                            </ul>
                                            </div>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php elseif ($single_listing_gallery_style == 'gallery-style-slider-3'): ?>
                            <div class="tfcl-listing-info single-gallery-slider">
                                <div class="single-listing-image-main slider-3 owl-carousel manual tfcl-carousel-manual">
                                    <?php
                                    $gallery_id = 'tfcl-' . rand();
                                    foreach ($listing_gallery as $image):
                                        $image_full_src = wp_get_attachment_image_src($image, 'full');
                                        if (!empty($image_full_src) && is_array($image_full_src)) {
                                            ?>
                                            <div class="item listing-gallery-item tfcl-light-gallery">
                                                <img loading="lazy" src="<?php echo esc_url($image_full_src[0]) ?>" alt="<?php the_title(); ?>"
                                                    title="<?php the_title(); ?>">
                                                    <a data-thumb-src="<?php echo esc_url($image_full_src[0]); ?>"
                                                            data-gallery-id="<?php echo esc_attr($gallery_id); ?>" data-rel="tfcl_light_gallery"
                                                            href="<?php echo esc_url($image_full_src[0]); ?>" class="zoomGallery">
                                                            
                                                    </a>
                                                            <ul class="list-control-gallery">
                                                            <?php if (!empty($listing_video)): ?>
                                                                    <li>
                                                                        <span data-src="<?php echo esc_url($listing_video); ?>" class="tfcl-view-video"><?php echo themesflat_svg('camera'); ?><?php esc_html_e( 'Video', 'tf-car-listing' ); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <li>
                                                                    <span class="show-gallery"> <?php echo themesflat_svg('image'); ?> <?php esc_html_e( 'All image', 'tf-car-listing' ); ?></span>
                                                                </li>
                                                            </ul>
                                            </div>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="container-grid-gallery">
                                <div class="row">
                                    <div class="tfcl-listing-info style-grid slider-4 owl-carousel">
                                        <?php
                                        $gallery_id = 'tfcl-' . rand();
                                        $key        = 1;
                                        foreach ($listing_gallery as $image):
                                            $max_item       = count($listing_gallery) - 6;
                                            $image_full_src = wp_get_attachment_image_src($image, 'full');
                                            $setactive = $key == 2 ? 'active' : '';
                                            if (!empty($image_full_src) && is_array($image_full_src)) {
                                                ?>
                                                <div class="item listing-gallery-item tfcl-light-gallery item-<?php echo esc_attr($key); ?> <?php echo $setactive; ?>">
                                                    <img loading="lazy" src="<?php echo esc_url($image_full_src[0]) ?>" alt="<?php the_title(); ?>"
                                                        title="<?php the_title(); ?>">

                                                            <ul class="list-control-gallery">
                                                            <?php if (!empty($listing_video)): ?>
                                                                    <li>
                                                                        <span data-src="<?php echo esc_url($listing_video); ?>" class="tfcl-view-video"><?php echo themesflat_svg('camera'); ?><?php esc_html_e( 'Video', 'tf-car-listing' ); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <li>
                                                                <a data-thumb-src="<?php echo esc_url($image_full_src[0]); ?>"
                                                        data-gallery-id="<?php echo esc_attr($gallery_id); ?>" data-rel="tfcl_light_gallery"
                                                        href="<?php echo esc_url($image_full_src[0]); ?>" class="zoomGallery"><span class="show-gallery"> <?php echo themesflat_svg('image'); ?> <?php esc_html_e( 'All image', 'tf-car-listing' ); ?></span></a>
                                                                    
                                                                </li>
                                                            </ul>
                                                        
                                                        
                                                        
                                                </div>
                                            <?php } ?>
                                            <?php $key++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
    <?php endif; 
}?>