<?php
$custom_name_condition = get_option('custom_name_condition', 'condition');
$custom_name_body = get_option('custom_name_body', 'Body');
$custom_name_make = get_option('custom_name_make', 'Make');
$custom_name_model = get_option('custom_name_model', 'Model');
$custom_name_transmission = get_option('custom_name_transmission', 'transmission');
$custom_name_cylinders = get_option('custom_name_cylinders', 'cylinders');
$custom_name_drive_type = get_option('custom_name_drive_type', 'Drive Type');
$custom_name_fuel_type = get_option('custom_name_fuel_type', 'Fuel Type');
$custom_name_color = get_option('custom_name_color', 'Color');
$custom_name_features_type = get_option('custom_name_features_type', 'Features Type');
$custom_name_features = get_option('custom_name_features', 'Features');
return array(
    'title'  => esc_html__('General', 'tf-car-listing'),
    'id'     => 'general-options',
    'desc'   => '',
    'icon'   => 'el el-cog',
    'fields' => array(
        array(
            'id'      => 'map_service',
            'type'    => 'button_set',
            'title'   => esc_html__('Map Service', 'tf-car-listing'),
            'options' => array(
                'google-map' => esc_html__('Google Map', 'tf-car-listing'),
                'map-box'    => esc_html__('MapBox', 'tf-car-listing'),
            ),
            'default' => 'map-box',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'google_map_api_key',
            'type'     => 'text',
            'title'    => esc_html__('Google Map API Key', 'tf-car-listing'),
            'desc'     => sprintf(esc_html__('Get your %s google map API key %s for accurate and long-term use.', 'tf-car-listing'), '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">', '</a>'),
            'required' => array( 'map_service', '=', 'google-map' )
        ),
        array(
            'id'       => 'map_box_api_key',
            'type'     => 'text',
            'title'    => esc_html__('MapBox API Key', 'tf-car-listing'),
            'desc'     => sprintf(esc_html__('Get your %s MapBox API key %s for accurate and long-term use.', 'tf-car-listing'), '<a href="https://www.mapbox.com" target="_blank">', '</a>'),
            'required' => array( 'map_service', '=', 'map-box' )
        ),
        array(
            'id'            => 'map_zoom',
            'type'          => 'slider',
            'title'         => esc_html__('Map Zoom', 'tf-car-listing'),
            "default"       => 10,
            "min"           => 1,
            "step"          => 1,
            "max"           => 25,
            'display_value' => 'text'
        ),
        array(
            'id'      => 'default_marker_image',
            'type'    => 'media',
            'url'     => true,
            'title'   => esc_html__('Default Marker Image', 'tf-car-listing'),
            'default' => array(
                'url' => ''
            ),
        ),
        array(
            'id'       => 'marker_image_width',
            'type'     => 'text',
            'title'    => esc_html__('Marker Image Width', 'tf-car-listing'),
            'subtitle' => esc_html__('Set marker image width. (Ex: 30px)', 'tf-car-listing'),
        ),
        array(
            'id'       => 'marker_image_height',
            'type'     => 'text',
            'title'    => esc_html__('Marker Image Height', 'tf-car-listing'),
            'subtitle' => esc_html__('Set marker image height. (Ex: 40px)', 'tf-car-listing'),
        ),
        array(
			'id'     => 'begin_custom_url_postype_heading',
			'type'   => 'section',
			'title'  => esc_html__( 'Custom Slug PostType', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'When you make changes, please go to the permalinks settings and press "Save Changes" to refresh the URL. ', 'tf-car-listing' ),
			'indent' => true,
		),
		array(
			'id'       => 'custom_url_listings',
			'type'     => 'text',
			'title'    => esc_html__( 'Listings', 'tf-car-listing' ),
		),
		array(
			'id'       => 'custom_url_listing_condition',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_condition),
		),
		array(
			'id'       => 'custom_url_listing_body',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_body),
		),
		array(
			'id'       => 'custom_url_listing_make',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_make),
		),
		array(
			'id'       => 'custom_url_listing_model',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_model),
		),
		array(
			'id'       => 'custom_url_listing_transmission',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_transmission),
		),
		array(
			'id'       => 'custom_url_listing_cylinders',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_cylinders),
		),
		array(
			'id'       => 'custom_url_listing_drive',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_drive_type),
		),
        array(
			'id'       => 'custom_url_listing_fuel',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_fuel_type),
		),
        array(
			'id'       => 'custom_url_listing_color',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_color),
		),
        array(
			'id'       => 'custom_url_listing_features',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_features),
		),
        array(
			'id'       => 'custom_url_listing_features_type',
			'type'     => 'text',
			'title'    => esc_html__( 'Listing ', 'tf-car-listing' ) . esc_html($custom_name_features_type),
		),
		array(
			'id'       => 'custom_url_dealer',
			'type'     => 'text',
			'title'    => esc_html__( 'Dealer', 'tf-car-listing' ),
		),
        array(
			'id'       => 'custom_url_package',
			'type'     => 'text',
			'title'    => esc_html__( 'Package', 'tf-car-listing' ),
		),		
        array(
			'id'       => 'custom_url_invoice',
			'type'     => 'text',
			'title'    => esc_html__( 'Invoice', 'tf-car-listing' ),
		),		
        array(
			'id'       => 'custom_url_user_package',
			'type'     => 'text',
			'title'    => esc_html__( 'User Package', 'tf-car-listing' ),
		),		
        array(
			'id'       => 'custom_url_transaction_log',
			'type'     => 'text',
			'title'    => esc_html__( 'Transaction Log', 'tf-car-listing' ),
		),	
		array(
			'id'       => 'end_custom_url_postype_heading',
			'type'     => 'accordion',
			'position' => 'end'
		),
    )
);