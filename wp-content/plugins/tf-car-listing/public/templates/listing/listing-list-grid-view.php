<?php 
    /**
     * parameters
     * @param $query
     * @param $list_order
     * @param $css_col_class
     */
    $listing_public = new Car_Listing;
    $order_by    = isset($_GET['orderBy']) ? sanitize_text_field(wp_unslash($_GET['orderBy'])) : '';

    $seller_heading_listing = tfcl_get_option('default_heading_seller_listing');
?>
<div class="listing-list-grid-view">
    <div class="listing-list-inner row">
        <div class="col-lg-6 col-md-12">        
            <h2><?php esc_html_e($seller_heading_listing, 'tf-car-listing'); ?></h2>
        </div>
        <div class="col-lg-6 col-md-12 sort-listing">
            <div class="form-group">
                <select name="sortby" id="listing_order_by" class="form-control"
                    title="<?php esc_attr_e('Sort By', 'tf-car-listing') ?>">
                    <?php foreach ($list_order as $key => $order): ?>
                        <option value="<?php echo $listing_public->tfcl_get_link_order_listing($key) ?>" <?php selected($key, $order_by); ?>>
                            <?php printf(__($order, 'tf-car-listing')); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
				<a class="btn btn-display-listing-grid"><i class="icon-autodeal-grid"></i></a>
			</div>
			<div class="form-group">
				<a class="btn btn-display-listing-list"><i class="icon-autodeal-icon-157"></i></a>
			</div>
        </div>
    </div>
    <div class="group-card-item-listing row">
        <?php if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                $listing_id     = get_the_ID();
                $attach_id       = get_post_thumbnail_id();            
                tfcl_get_template_with_arguments(
                    'listing/card-item-listing.php',
                    array(
                        'listing_id'     => $listing_id,
                        'attach_id'       => $attach_id,                    
                        'css_class_col'   => $css_class_col
                    )
                );
                ?>
            <?php endwhile;            
        else: ?>
            <div class="item-not-found"><?php esc_html_e('No item found', 'tf-car-listing'); ?></div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php tfcl_get_template_with_arguments('global/pagination.php', array( 'max_num_pages' => $max_num_pages )); ?>
</div>