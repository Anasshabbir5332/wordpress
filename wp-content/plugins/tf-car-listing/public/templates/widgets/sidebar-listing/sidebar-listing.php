<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$query_args           = array(
    'post_type'      => 'listing',
    'posts_per_page' => $args['number_of_listing'],
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$listing           = new WP_Query($query_args);

?>
<p class="listing-count"><?php echo sprintf( __( 'Showing %s more cars you might like', 'tf-car-listing' ), count($query_args) ); ?></p>
<div class="tfcl-list-featured-listing-wrap">
    <ul class="tfcl-list-featured-listing">
        <?php if ($listing->found_posts > 0): ?>
                <?php
                $no_image_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
                $default_image = tfcl_get_option('default_property_image', '');
                if (is_array($default_image) && $default_image['url'] != '') {
                    $no_image_src = tfcl_image_resize_url($default_image['url'], 260, 196, true)['url'];
                }
                if ($listing->have_posts()):
                    while ($listing->have_posts()):
                        $listing->the_post();
                        $listing_id                              = get_the_ID();
                        $listing_title                           = get_the_title($listing_id);
                        $listing_link                            = get_the_permalink($listing_id);
                        $car_regular_price_value                 = get_post_meta( $listing_id, 'regular_price', true );
                        $car_sale_price_value                    = get_post_meta( $listing_id, 'sale_price', true );
	                    $car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );
                        $car_price_prefix                        = get_post_meta( $listing_id, 'price_prefix', true );
                        $car_price_suffix                        = get_post_meta( $listing_id, 'price_suffix', true );
                        $image_id                                = get_post_thumbnail_id($listing_id);
                        $listing_image_src                       = tfcl_image_resize_id($image_id, 260, 196, true);
$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
                        ?>
                        <li class="item property-item">
                            <div class="property-image">
                                <a title="<?php echo esc_attr($listing_title) ?>" href="<?php echo esc_url($listing_link) ?>">
                                    <img loading="lazy" src="<?php echo esc_url($listing_image_src) ?>"
                                        onerror="this.src = '<?php echo esc_url($no_image_src) ?>';"
                                        alt="<?php echo esc_attr($listing_title) ?>"
                                        title="<?php echo esc_attr($listing_title) ?>">
                                </a>
                            </div>
                            <div class="property-info">
                                <?php if (!empty($listing_title)): ?>
                                    <h6 class="property-title"><a title="<?php echo esc_attr($listing_title) ?>"
                                            href="<?php echo esc_url($listing_link) ?>"><?php echo esc_html($listing_title) ?></a>
                                    </h6>
                                <?php endif; ?>
                                <div class="price">
				                    <?php if ( ! empty( $car_sale_price_value ) ) : ?>
				                    	<span class="inner regular_price">
				                    		<?php if ( $car_price_prefix != '' ) : ?>
				                    			<?php echo $car_price_prefix; ?>
				                    		<?php endif; ?>
						                    <?php echo tfcl_format_price( $car_sale_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
				                    		<?php if ( $car_price_suffix != '' ) : ?>
				                    			<?php echo $car_price_suffix; ?>
				                    		<?php endif; ?>
				                    	</span>
				                    <?php endif; ?>
				                    <?php if ( ! empty( $car_regular_price_value ) ) : ?>
				                    	<span class="inner sale_price">
				                    		<?php if ( $car_price_prefix != '' ) : ?>
				                    			<?php echo $car_price_prefix; ?>
				                    		<?php endif; ?>
						                    <?php echo tfcl_format_price( $car_regular_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
				                    		<?php if ( $car_price_suffix != '' ) : ?>
				                    			<?php echo $car_price_suffix; ?>
				                    		<?php endif; ?>
				                    	</span>
				                    <?php endif; ?>
			                    </div>
                            </div>
                        </li>
                    <?php endwhile;
                endif; ?>
        <?php else: ?>
            <div class="item-not-found"><?php esc_html_e('No item found', 'tf-car-listing'); ?></div>
            <?php endif; ?>
        </ul>
        <div class="view-more-button">
            <a href="<?php echo esc_url( tfcl_get_permalink( 'listing_page' ) ); ?>"><?php esc_html_e( 'View more listings', 'tf-car-listing' ); ?> <i class="icon-autodeal-icon-166"></i></a>
        </div>
</div>