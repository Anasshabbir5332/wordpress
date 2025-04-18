<?php
return array(
    'title'  => esc_html__('Compare Options', 'tf-car-listing'),
    'id'     => 'compare-options',
    'desc'   => '',
    'icon'   => 'el el-filter',
    'fields' => array(
        array(
            'id'      => 'enable_compare',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Compare Listing', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'    => 'max_items_compare',
            'type'  => 'text',
            'title' => esc_html__('Max Items Compare', 'tf-car-listing'),
        ),
        // Show Hide Compare Fields Accordion
        array(
            'id'       => 'begin_show_hide_compare_fields',
            'type'     => 'accordion',
            'title'    => esc_html__('Show Compare Fields', 'tf-car-listing'),
            'position' => 'start',
            'open'     => false
        ),
        array(
            'id'       => 'show_hide_compare_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__('Show Compare Fields', 'tf-car-listing'),
            'subtitle' => esc_html__('Choose which fields you want to show on compare page?', 'tf-car-listing'),
            'options'  => array(
                'listing-make'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_make')),
                'listing-model'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_model')),
                'listing-body'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_body')),
                'listing-price'     => esc_html__('Listing Price', 'tf-car-listing'),
                'listing-condition' => esc_html__("Listing ", 'tf-car-listing') . esc_html(get_option('custom_name_condition')),
                'listing-stock-number'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_stock_number')),
                'listing-vin-number'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_vin_number')),
                'listing-year'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_year')),
                'listing-mileage'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_mileage')),
                'listing-transmission'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_transmission')),
                'listing-drive-type'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_drive_type')),
                'listing-engine-size'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_engine_size')),
                'listing-cylinders'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_cylinders')),
                'listing-fuel-type'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_fuel_type')),
                'listing-door'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_door')),
                'listing-color'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_color')),
                'listing-seats'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_seat')),
                'listing-city-mpg'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_city_mpg')),
                'listing-highway-mpg'     => esc_html__('Listing ', 'tf-car-listing') . esc_html(get_option('custom_name_highway_mpg')),
                'listing-location'     => esc_html__('Listing Location', 'tf-car-listing'),
            ),
            'default' => array(
                'listing_make'     => 1,
                'listing_model'     => 1,
                'listing_body'     => 1,
                'listing_price'     => 1,
                'listing_condition'     => 1,
                'listing_stock_number'     => 1,
                'listing_vin_number'     => 1,
                'listing_year'     => 1,
                'listing_mileage'     => 1,
                'listing_transmission'     => 1,
                'listing_drive_type'     => 1,
                'listing_engine_size'     => 1,
                'listing_cylinders'     => 1,
                'listing_fuel_type'     => 1,
                'listing_door'     => 1,
                'listing_color'     => 1,
                'listing_seats'     => 1,
                'listing_city_mpg'     => 1,
                'listing_highway_mpg'     => 1,
                'listing_location'     => 1,
            )
        ),
        array(
            'id'       => 'end_show_hide_compare_fields',
            'type'     => 'accordion',
            'position' => 'end',
        ),
    )
);