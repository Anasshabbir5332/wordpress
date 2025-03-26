<?php if ( !empty($list_condition) ): ?>
    <?php $archive_listing_column_layout = tfcl_get_option('column_layout_grid'); ?>
    <div class="filter-dealer-listing-shortcode">    
        <div class="filter-listing-tabs">   
            <div class="dealer-listing-titles">
                <div class="wrapp-dealer-listing-title" id="wrapp-dealer-listing-title" data-tabdefault="<?php echo esc_attr($default_condition); ?>" data-dealer="<?php echo esc_attr($dealer_id); ?>" >
                    <?php foreach ($list_condition as $key => $condition) : ?>
                        <div class="dealer-tab-title dealer-condition-tab" data-condition="<?php echo esc_attr($key); ?>"  ><?php echo $condition; ?></div>
                    <?php endforeach; ?>
                </div>                                             
            </div>
            <div id="filter-tab-content" class="filter-listing-tab-content">  
                <div class="overlay-filter-tab">
                    <div class="filter-loader"></div>
                </div>
                <div id="filter-tab-content-inner" class="<?php echo esc_attr( 'grid-column-'.$archive_listing_column_layout.' ' ); ?>"></div>
            </div>
        </div>        
    </div>
<?php endif; ?>