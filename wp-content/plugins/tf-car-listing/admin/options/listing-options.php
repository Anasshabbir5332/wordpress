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

$custom_name_stock_number = get_option('custom_name_stock_number', 'Stock Number');
$custom_name_vin_number = get_option('custom_name_vin_number', 'Vin Number');
$custom_name_city_mpg = get_option('custom_name_city_mpg', 'City Mpg');
$custom_name_highway_mpg = get_option('custom_name_highway_mpg', 'Highway Mpg');
$custom_name_year = get_option('custom_name_year', 'Year');
$custom_name_door = get_option('custom_name_door', 'Door');
$custom_name_seat = get_option('custom_name_seat', 'Seat');
$custom_name_mileage = get_option('custom_name_mileage', 'Mileage');
$custom_name_engine_size = get_option('custom_name_engine_size', 'Engine Size');
return array(
	'title'  => esc_html__( 'Listing', 'tf-car-listing' ),
	'id'     => 'listing-options',
	'desc'   => '',
	'icon'   => 'el el-th-list',
	'fields' => array(
		array(
			'id'      => 'allow_submit_listing_from_fe',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Allow to submit listing from frontend', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'all_user_can_submit_listing',
			'type'    => 'button_set',
			'title'   => esc_html__( 'All User can submit listing', 'tf-car-listing' ),
			'desc'    => esc_html__( 'If "No", only admin or dealer can submit listing', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'auto_publish_submitted',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Automatically publish the submitted listing?', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'auto_publish_edited',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Automatically publish the edited listing?', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'       => 'add_listing_panels_manager',
			'type'     => 'sortable',
			'title'    => esc_html__( 'Add Listing Panels Manager', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Define and reorder these however you want.', 'tf-car-listing' ),
			'mode'     => 'checkbox',
			'options'  => array(
				'upload-media'    => esc_html__( 'Upload Media', 'tf-car-listing' ),
				'information'     => esc_html__( 'Information', 'tf-car-listing' ),
				'amenities'       => esc_html__( 'Amenities', 'tf-car-listing' ),
				'price'           => esc_html__( 'Price', 'tf-car-listing' ),
				'location'        => esc_html__( 'Location', 'tf-car-listing' ),
				'video'           => esc_html__( 'Video', 'tf-car-listing' ),
				'file-attachment' => esc_html__( 'File Attachment', 'tf-car-listing' ),
			),
			'default'  => array(
				'upload-media'    => true,
				'information'     => true,
				'amenities'       => true,
				'price'           => true,
				'location'        => true,
				'video'           => true,
				'file-attachment' => true,
			),
		),
		array(
			'id'       => 'single_listing_panels_manager',
			'type'     => 'sortable',
			'title'    => esc_html__( 'Single Listing Panels Manager', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Show Hide these however you want.', 'tf-car-listing' ),
			'mode'     => 'checkbox',
			'options'  => array(
				'gallery'         => esc_html__( 'Gallery', 'tf-car-listing' ),
				'description'     => esc_html__( 'Description', 'tf-car-listing' ),
				'overview'        => esc_html__( 'Overview', 'tf-car-listing' ),
				'features'        => esc_html__( 'Features', 'tf-car-listing' ),
				'loan-calculator' => esc_html__( 'Loan Calculator', 'tf-car-listing' ),
				'map-location'    => esc_html__( 'Map Address', 'tf-car-listing' ),
				'video'           => esc_html__( 'Video ', 'tf-car-listing' ),
				'review'          => esc_html__( 'Review', 'tf-car-listing' ),
			),
			'default'  => array(
				'gallery'         => true,
				'description'     => true,
				'overview'        => true,
				'features'        => true,
				'loan-calculator' => true,
				'map-location'    => true,
				'video'           => true,
				'virtual-360'     => true,
				'review'          => true,
			),
		),
		array(
			'id'    => 'item_per_page_my_listing',
			'type'  => 'text',
			'title' => esc_html__( 'Item Per Page My Listing', 'tf-car-listing' ),
		),
		array(
			'id'    => 'add_listing_button_text',
			'type'  => 'text',
			'title' => esc_html__( 'Add Listing Button Text', 'tf-car-listing' ),
		),
		array(
			'id'    => 'update_listing_button_text',
			'type'  => 'text',
			'title' => esc_html__( 'Update Listing Button Text', 'tf-car-listing' ),
		),
		array(
			'id'    => 'maximum_images',
			'type'  => 'text',
			'title' => esc_html__( 'Maximum Images', 'tf-car-listing' ),
			'desc'  => esc_html__( 'Maximum number of images allowed for single listing', 'tf-car-listing' ),
		),
		array(
			'id'    => 'maximum_image_size',
			'type'  => 'text',
			'title' => esc_html__( 'Maximum Image Size', 'tf-car-listing' ),
			'desc'  => esc_html__( 'Maximum upload image file size. For example 10kb, 500kb, 1mb, 10m, 100mb', 'tf-car-listing' ),
		),
		array(
			'id'    => 'image_types',
			'type'  => 'text',
			'title' => esc_html__( 'Image Types', 'tf-car-listing' ),
			'desc'  => esc_html__( 'Allow only comma separated numbers. Ex: jpg,jpeg,gif,png', 'tf-car-listing' ),
		),
		array(
			'id'      => 'image_width_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Image Width', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Set image width for listing.', 'tf-car-listing' ),
		),
		array(
			'id'      => 'image_height_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Image Height', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Set image height for listing.', 'tf-car-listing' ),
		),
		array(
			'id'    => 'maximum_attachments',
			'type'  => 'text',
			'title' => esc_html__( 'Maximum Attachments', 'tf-car-listing' ),
			'desc'  => esc_html__( 'Maximum number of attachments allowed for single listing', 'tf-car-listing' ),
		),
		array(
			'id'    => 'maximum_attachment_size',
			'type'  => 'text',
			'title' => esc_html__( 'Maximum Attachment Size', 'tf-car-listing' ),
			'desc'  => esc_html__( 'Maximum upload attachment file size. For example 10kb, 500kb, 1mb, 10m, 100mb', 'tf-car-listing' ),
		),
		array(
			'id'    => 'attachment_types',
			'type'  => 'text',
			'title' => esc_html__( 'Attachment Types', 'tf-car-listing' ),
			'desc'  => esc_html__( 'Allow only comma separated numbers. Ex: pdf,txt,doc,docx', 'tf-car-listing' ),
		),
		array(
			'id'      => 'default_listing_image',
			'type'    => 'media',
			'url'     => true,
			'title'   => esc_html__( 'Default Listing Image', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Display this image if listing no image', 'tf-car-listing' ),
			'default' => array(
				'url' => ''
			),
		),
		array(
			'id'      => 'measurement_units',
			'type'    => 'select',
			'title'   => esc_html__( 'Measurement units', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Choose Measurement units.', 'tf-car-listing' ),
			'options' => array(
				'miles'   => esc_html__( 'Miles (miles)', 'tf-car-listing' ),
				'km'     => esc_html__( 'Kilometers (km)', 'tf-car-listing' ),
				'custom' => esc_html__( 'Custom Unit', 'tf-car-listing' )
			),
			'default' => 'miles',
		),
		array(
			'id'       => 'custom_measurement_units',
			'type'     => 'text',
			'title'    => esc_html__( 'Custom Measurement Units ', 'tf-car-listing' ),
			'required' => [ 'measurement_units', '=', 'custom' ]
		),
		// Related Listing
		array(
			'id'       => 'begin_related_listing',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Related Listing', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'      => 'heading_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Heading', 'tf-car-listing' ),
			'default' => esc_html__( 'Featured listing', 'tf-car-listing' )
		),
		array(
			'id'      => 'description_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Description', 'tf-car-listing' ),
			'default' => esc_html__( 'Explore all the different types of listing so you can choose the best option for you.', 'tf-car-listing' )
		),
		array(
			'id'      => 'item_per_page_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Item per page', 'tf-car-listing' ),
			'default' => esc_html__( '6' )
		),
		array(
			'id'      => 'related_by_taxonomy',
			'type'    => 'select',
			'title'   => esc_html__( 'Related by taxonomy', 'tf-car-listing' ),
			'options' => array(
				'condition'     => esc_html__( $custom_name_condition, 'tf-car-listing' ),
				'body'          => esc_html__( $custom_name_body, 'tf-car-listing' ),
				'make'          => esc_html__( $custom_name_make, 'tf-car-listing' ),
				'model'         => esc_html__( $custom_name_model, 'tf-car-listing' ),
				'transmission'  => esc_html__( $custom_name_transmission, 'tf-car-listing' ),
				'cylinders'     => esc_html__( $custom_name_cylinders, 'tf-car-listing' ),
				'drive-type'    => esc_html__( $custom_name_drive_type, 'tf-car-listing' ),
				'fuel-type'     => esc_html__( $custom_name_fuel_type, 'tf-car-listing' ),
				'car-color'     => esc_html__( $custom_name_color, 'tf-car-listing' ),
				'features-type' => esc_html__( $custom_name_features_type, 'tf-car-listing' ),
				'features'      => esc_html__( $custom_name_features, 'tf-car-listing' ),
			),
			'default' => 'condition',
		),
		array(
			'id'      => 'enable_loop_related_listing',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Loop', 'tf-car-listing' ),
			'default' => 0,
		),
		array(
			'id'      => 'enable_auto_loop_related_listing',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Auto Loop', 'tf-car-listing' ),
			'default' => 0,
		),
		array(
			'id'      => 'enable_bullets_related_listing',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Bullets', 'tf-car-listing' ),
			'default' => 1,
		),
		array(
			'id'      => 'spacing_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Spacing Item', 'tf-car-listing' ),
			'default' => esc_html__( '30' )
		),
		array(
			'id'      => 'carousel_column_desk_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Column Desk', 'tf-car-listing' ),
			'default' => esc_html__( '4' )
		),
		array(
			'id'      => 'carousel_column_laptop_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Column Laptop', 'tf-car-listing' ),
			'default' => esc_html__( '3' )
		),
		array(
			'id'      => 'carousel_column_tablet_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Column Tablet', 'tf-car-listing' ),
			'default' => esc_html__( '2' )
		),
		array(
			'id'      => 'carousel_column_mobile_related_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Column Mobile', 'tf-car-listing' ),
			'default' => esc_html__( '1' )
		),
		array(
			'id'       => 'end_related_listing',
			'type'     => 'accordion',
			'position' => 'end'
		),
		// Price Format Accordion
		array(
			'id'       => 'begin_price_format',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Price Format', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'      => 'enable_price_unit',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Price Unit', 'tf-car-listing' ),
			'default' => 1,
		),
		array(
			'id'      => 'enable_short_price_unit',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Short Price Unit', 'tf-car-listing' ),
			'default' => 0,
		),
		array(
			'id'    => 'thousand_text',
			'type'  => 'text',
			'title' => esc_html__( 'Thousand Text', 'tf-car-listing' ),
			'desc'  => esc_html__( 'K, k or Thousand', 'tf-car-listing' )
		),
		array(
			'id'    => 'million_text',
			'type'  => 'text',
			'title' => esc_html__( 'Million Text', 'tf-car-listing' ),
			'desc'  => esc_html__( 'M, m or Million', 'tf-car-listing' )
		),
		array(
			'id'    => 'billion_text',
			'type'  => 'text',
			'title' => esc_html__( 'Billion Text', 'tf-car-listing' ),
			'desc'  => esc_html__( 'B, b or Billion', 'tf-car-listing' )
		),
		array(
			'id'    => 'currency_sign',
			'type'  => 'text',
			'title' => esc_html__( 'Currency Sign', 'tf-car-listing' ),
		),
		array(
			'id'      => 'currency_sign_position',
			'type'    => 'select',
			'title'   => esc_html__( 'Currency Sign Position', 'tf-car-listing' ),
			'options' => array(
				'before' => esc_html__( 'Before ($1,000)', 'tf-car-listing' ),
				'after'  => esc_html__( 'After (1,000$)', 'tf-car-listing' ),
			),
			'default' => 'before',
		),
		array(
			'id'    => 'thousand_separator',
			'type'  => 'text',
			'title' => esc_html__( 'Thousand Separator', 'tf-car-listing' ),
			'desc'  => esc_html__( 'This sets the thousand separator of displayed prices.', 'tf-car-listing' )
		),
		array(
			'id'    => 'decimal_separator',
			'type'  => 'text',
			'title' => esc_html__( 'Decimal Separator', 'tf-car-listing' ),
			'desc'  => esc_html__( 'This sets the decimal separator of displayed prices.', 'tf-car-listing' )
		),
		array(
			'id'    => 'price_to_call_text',
			'type'  => 'text',
			'title' => esc_html__( 'Price to Call Text', 'tf-car-listing' ),
		),
		array(
			'id'       => 'end_price_format',
			'type'     => 'accordion',
			'position' => 'end'
		),
		// Show Hide Listing Form Fields Accordion
		array(
			'id'       => 'begin_show_hide_listing_fields',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Show Listing Form Fields', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'show_hide_listing_fields',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Show Listing Form Fields', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which fields you want to show on Add/Edit Listing page?', 'tf-car-listing' ),
			'options'  => array(
				// Information
				'listing_description'       => esc_html__( 'Description', 'tf-car-listing' ),
				'make'                      => esc_html__( $custom_name_make, 'tf-car-listing' ),
				'model'                     => esc_html__( $custom_name_model, 'tf-car-listing' ),
				'body'                      => esc_html__( $custom_name_body, 'tf-car-listing' ),
				'condition'                 => esc_html__( $custom_name_condition, 'tf-car-listing' ),
				'transmission'              => esc_html__( $custom_name_transmission, 'tf-car-listing' ),
				'drive-type'                => esc_html__( $custom_name_drive_type, 'tf-car-listing' ),
				'cylinders'                 => esc_html__( $custom_name_cylinders, 'tf-car-listing' ),
				'fuel-type'                 => esc_html__( $custom_name_fuel_type, 'tf-car-listing' ),
				'car-color'                 => esc_html__( $custom_name_color, 'tf-car-listing' ),
				'year'                      => esc_html__( $custom_name_year, 'tf-car-listing' ),
				'stock_number'              => esc_html__( $custom_name_stock_number, 'tf-car-listing' ),
				'vin_number'                => esc_html__( $custom_name_vin_number, 'tf-car-listing' ),
				'mileage'                   => esc_html__( $custom_name_mileage, 'tf-car-listing' ),
				'engine_size'               => esc_html__( $custom_name_engine_size, 'tf-car-listing' ),
				'door'                      => esc_html__( $custom_name_door, 'tf-car-listing' ),
				'seat'                      => esc_html__( $custom_name_seat, 'tf-car-listing' ),
				'city_mpg'                  => esc_html__( $custom_name_city_mpg, 'tf-car-listing' ),
				'highway_mpg'               => esc_html__( $custom_name_highway_mpg, 'tf-car-listing' ),
				// Additional Detail
				'listing_additional_detail' => esc_html__( 'Additional Detail', 'tf-car-listing' ),
				// Gallery
				'gallery_images'            => esc_html__( 'Gallery Images', 'tf-car-listing' ),
				// File Attachments
				'attachments_file'          => esc_html__( 'Attachments File', 'tf-car-listing' ),
				// amenities
				'features'                  => esc_html__( $custom_name_features, 'tf-car-listing' ),
				// location
				'listing_address'           => esc_html__( 'Address', 'tf-car-listing' ),
				'listing_location'          => esc_html__( 'Location', 'tf-car-listing' ),
				// price
				'regular_price'             => esc_html__( 'Regular Price', 'tf-car-listing' ),
				'sale_price'                => esc_html__( 'Sale Price', 'tf-car-listing' ),
				'price_custom_label'        => esc_html__( 'Price Custom Label', 'tf-car-listing' ),
				'listing_price_unit'        => esc_html__( 'Price Unit', 'tf-car-listing' ),
				'price_prefix'              => esc_html__( 'Price Prefix', 'tf-car-listing' ),
				'price_suffix'              => esc_html__( 'Price Suffix', 'tf-car-listing' ),
				// video
				'listing_video_url'         => esc_html__( 'Video Url', 'tf-car-listing' )
			),
			'default'  => array(
				// Information
				'listing_description'       => 1,
				'make'                      => 1,
				'model'                     => 1,
				'body'                      => 1,
				'condition'                 => 1,
				'transmission'              => 1,
				'drive-type'                => 1,
				'cylinders'                 => 1,
				'fuel-type'                 => 1,
				'car-color'                 => 1,
				'year'                      => 1,
				'stock_number'              => 1,
				'vin_number'                => 1,
				'mileage'                   => 1,
				'engine_size'               => 1,
				'door'                      => 1,
				'seat'                      => 1,
				'city_mpg'                  => 1,
				'highway_mpg'               => 1,
				// Additional Detail
				'listing_additional_detail' => 1,
				// Gallery
				'gallery_images'            => 1,
				// Attachments File
				'attachments_file'          => 1,
				// Amenities
				'features'                  => 1,
				// Location
				'listing_address'           => 1,
				'listing_location'          => 1,
				// Price
				'regular_price'             => 1,
				'sale_price'                => 1,
				'price_custom_label'        => 1,
				'listing_price_unit'        => 1,
				'price_prefix'              => 1,
				'price_suffix'              => 1,
				// Video
				'listing_video_url'         => 1
			),
		),
		array(
			'id'       => 'end_show_hide_listing_fields',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Required Listing Form Fields Accordion
		array(
			'id'       => 'begin_required_listing_fields',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Required Listing Form Fields', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'required_listing_fields',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Required Listing Form Fields', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which fields you want to that fields required', 'tf-car-listing' ),
			'options'  => array(
				// Information
				'listing_title' => esc_html__( 'Title', 'tf-car-listing' ),
				'make'          => esc_html__( $custom_name_make, 'tf-car-listing' ),
				'model'         => esc_html__( $custom_name_model, 'tf-car-listing' ),
				'body'          => esc_html__( $custom_name_body, 'tf-car-listing' ),
				'condition'     => esc_html__( $custom_name_condition, 'tf-car-listing' ),
				'transmission'  => esc_html__( $custom_name_transmission, 'tf-car-listing' ),
				'drive-type'    => esc_html__( $custom_name_drive_type, 'tf-car-listing' ),
				'cylinders'     => esc_html__( $custom_name_cylinders, 'tf-car-listing' ),
				'fuel-type'     => esc_html__( $custom_name_fuel_type, 'tf-car-listing' ),
				'car-color'     => esc_html__( $custom_name_color, 'tf-car-listing' ),
				'year'          => esc_html__( $custom_name_year, 'tf-car-listing' ),
				'stock_number'  => esc_html__( $custom_name_stock_number, 'tf-car-listing' ),
				'vin_number'    => esc_html__( $custom_name_vin_number, 'tf-car-listing' ),
				'mileage'       => esc_html__( $custom_name_mileage, 'tf-car-listing' ),
				'engine_size'   => esc_html__( $custom_name_engine_size, 'tf-car-listing' ),
				'door'          => esc_html__( $custom_name_door, 'tf-car-listing' ),
				'seat'          => esc_html__( $custom_name_seat, 'tf-car-listing' ),
				'city_mpg'      => esc_html__( $custom_name_city_mpg, 'tf-car-listing' ),
				'highway_mpg'   => esc_html__( $custom_name_highway_mpg, 'tf-car-listing' ),
				// Amenities
				'features'      => esc_html__( $custom_name_features, 'tf-car-listing' ),
				// Price
				'regular_price' => esc_html__( 'Regular Price', 'tf-car-listing' ),
				'sale_price'    => esc_html__( 'Sale Price', 'tf-car-listing' ),
			),
			'default'  => array(
				// Information
				'listing_title' => 1,
				'make'          => 1,
				'model'         => 1,
				'body'          => 1,
				'condition'     => 1,
				'transmission'  => 1,
				'drive-type'    => 1,
				'cylinders'     => 1,
				'fuel-type'     => 1,
				'car-color'     => 1,
				'year'          => 1,
				'stock_number'  => 1,
				'vin_number'    => 1,
				'mileage'       => 1,
				'engine_size'   => 1,
				'door'          => 1,
				'seat'          => 1,
				'city_mpg'      => 1,
				'highway_mpg'   => 1,
				// Amenities
				'features'      => 1,
				// Price
				'regular_price' => 1,
				'sale_price'    => 1
			),
		),
		array(
			'id'       => 'end_required_listing_fields',
			'type'     => 'accordion',
			'position' => 'end',
		),
	)
);
?>