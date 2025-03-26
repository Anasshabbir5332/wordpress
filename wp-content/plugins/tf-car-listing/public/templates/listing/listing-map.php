<?php
/**
 * The template for displaying listing map view (AutoTrader API version).
 * 
 * @package Car_Listing
 */

if (!defined('ABSPATH')) exit;

// Get vehicles from API (passed via shortcode)
$vehicles = $args['vehicles'] ?? [];
?>

<div class="tf-listing-map-wrapper">
    <!-- Search Form (Unchanged) -->
    <?php if (!empty($args['search_form'])) : ?>
        <div class="tf-listing-search-form-wrapper">
            <?php tfcl_get_template('listing/listing-search-form.php', $args); ?>
        </div>
    <?php endif; ?>

    <div class="tf-listing-map-content <?php echo esc_attr($args['map_position']); ?>">
        <!-- Map Container (Unchanged) -->
        <div class="tf-listing-map-container">
            <div id="map" style="height: 100%; width: 100%;"></div>
        </div>

        <!-- Listing Results (Modified for API) -->
        <div class="tf-listing-results">
            <!-- Top Bar (Sorting - Unchanged) -->
            <div class="tf-listing-top-bar">
                <div class="tf-listing-view-mode">
                    <a href="#" class="layout-grid active" data-layout="grid"><i class="fas fa-th"></i></a>
                    <a href="#" class="layout-list" data-layout="list"><i class="fas fa-list"></i></a>
                </div>
                <div class="tf-listing-sorting">
                    <form method="get">
                        <select name="orderby" onchange="this.form.submit()">
                            <?php foreach ($args['list_order'] as $key => $label) : ?>
                                <option value="<?php echo esc_attr($key); ?>" <?php selected($_GET['orderby'] ?? 'default', $key); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Vehicle Listing (Modified for API) -->
            <div class="tf-listing-items <?php echo esc_attr($args['layout_listing']); ?>">
                <?php if (!empty($vehicles)) : ?>
                    <?php foreach ($vehicles as $vehicle) : ?>
                        <div class="tf-listing-item">
                            <div class="tf-listing-item-inner">
                                <!-- Image -->
                                <div class="tf-listing-item-image">
                                    <?php if (!empty($vehicle['images'][0]['url'])) : ?>
                                        <img src="<?php echo esc_url($vehicle['images'][0]['url']); ?>" 
                                             alt="<?php echo esc_attr($vehicle['make'] . ' ' . $vehicle['model']); ?>">
                                        <span class="tf-listing-item-status">Available</span>
                                    <?php else : ?>
                                        <div class="tf-no-image"><?php esc_html_e('No Image', 'tf-car-listing'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Content -->
                                <div class="tf-listing-item-content">
                                    <h3><a href="#"><?php echo esc_html($vehicle['make'] . ' ' . $vehicle['model']); ?></a></h3>
                                    
                                    <!-- Meta (Year/Mileage/Fuel) -->
                                    <div class="tf-listing-item-meta">
                                        <?php if (!empty($vehicle['year'])) : ?>
                                            <span><i class="far fa-calendar-alt"></i> <?php echo esc_html($vehicle['year']); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($vehicle['mileage']['value'])) : ?>
                                            <span><i class="fas fa-tachometer-alt"></i> <?php echo number_format($vehicle['mileage']['value']); ?> <?php echo esc_html($vehicle['mileage']['unit']); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($vehicle['fuelType'])) : ?>
                                            <span><i class="fas fa-gas-pump"></i> <?php echo esc_html($vehicle['fuelType']); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Price -->
                                    <div class="tf-listing-item-price">
                                        £<?php echo number_format($vehicle['price']['amount'], 2); ?>
                                    </div>

                                    <!-- Footer (Unchanged) -->
                                    <div class="tf-listing-item-footer">
                                        <a href="#" class="tf-button"><i class="far fa-eye"></i> View Details</a>
                                        <a href="#" class="tf-button outline"><i class="far fa-heart"></i> Save</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="tf-no-results">
                        <?php esc_html_e('No vehicles found in AutoTrader stock.', 'tf-car-listing'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Map Script (Modified for API) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const vehicles = <?php echo json_encode(array_map(function($v) {
        return [
            'id' => $v['vehicleId'],
            'title' => $v['make'] . ' ' . $v['model'],
            'lat' => $v['location']['latitude'] ?? 0,
            'lng' => $v['location']['longitude'] ?? 0,
            'price' => '£' + <?php echo number_format($v['price']['amount'], 2); ?>,
            'image' => $v['images'][0]['url'] ?? ''
        ];
    }, $vehicles)); ?>;
    
    // Initialize map with vehicles (ensure your JS handles this structure)
    if (typeof initListingMap === 'function') {
        initListingMap(vehicles);
    }
});
</script>