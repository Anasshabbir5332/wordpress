<?php
return array(
	'title'  => esc_html__( 'Archive Listing', 'tf-car-listing' ),
	'id'     => 'archive-listing-options',
	'desc'   => '',
	'icon'   => 'el el-folder-close',
	'fields' => array(
		array(
			'id'       => 'layout_archive_listing',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Layout', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Select main layout for archive listing page. Choose between grid or list layout.', 'tf-car-listing' ),
			'options'  => array(
				'grid' => array(
					'alt'   => esc_html__( 'grid', 'tf-car-listing' ),
					'img'   => TF_PLUGIN_URL . 'public/assets/image/icon/option/square-grid.svg',
					'class' => 'layout-archive-listing-grid'
				),
				'list' => array(
					'alt'   => esc_html__( 'list', 'tf-car-listing' ),
					'img'   => TF_PLUGIN_URL . 'public/assets/image/icon/option/list-items.svg',
					'class' => 'layout-archive-listing-list'
				),
			),
			'default'  => 'grid'
		),
		array(
			'id'       => 'begin_layout_grid_options',
			'type'     => 'section',
			'title'    => esc_html__( 'Layout Grid', 'tf-car-listing' ),
			'indent'   => true,
			'required' => array( 'layout_archive_listing', '=', 'grid' )
		),
		array(
			'id'       => 'column_layout_grid',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Columns', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose columns of archive listing', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'2' => 'Column 2',
				'3' => 'Column 3',
				'4' => 'Column 4',
			),
			'default'  => '4',
			'required' => array( 'layout_archive_listing', '=', 'grid' )
		),
		array(
			'id'       => 'end_layout_grid_options',
			'type'     => 'section',
			'indent'   => false,
			'required' => array( 'layout_archive_listing', '=', 'grid' )
		),

		array(
			'id'       => 'begin_layout_list_options',
			'type'     => 'section',
			'title'    => esc_html__( 'Layout List', 'tf-car-listing' ),
			'indent'   => true,
			'required' => array( 'layout_archive_listing', '=', 'list' )
		),
		array(
			'id'       => 'column_layout_list',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Columns', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose columns of archive listing', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'1' => 'Column 1',
				'2' => 'Column 2',
			),
			'default'  => '1',
			'required' => array( 'layout_archive_listing', '=', 'list' )
		),
		array(
			'id'       => 'end_layout_list_options',
			'type'     => 'section',
			'indent'   => false,
			'required' => array( 'layout_archive_listing', '=', 'list' )
		),
		array(
			'id'       => 'archive_listing_search_form',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Search Form', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Enable/Disable Search Form.', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'enable'  => 'Enable',
				'disable' => 'Disable',
			),
			'default'  => 'enable',
		),
		array(
			'id'       => 'archive_listing_search_form_position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Search Form Position', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose Position for Search Form', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'top'  => esc_html__( 'Top' ),
				'side' => esc_html__( 'Sidebar' )
			),
			'default'  => 'top',
            'required' => array( array('archive_listing_search_form', '=', 'enable') )
		),
        array(
			'id'       => 'archive_listing_sidebar',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sidebar', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Enable/Disable sidebar.', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'enable'  => 'Enable',
				'disable' => 'Disable',
			),
			'default'  => 'disable',
			'required' => array(
				array( 'map_position', '=', array( 'hide-map', 'map-header' ) )
			)
		),
		array(
			'id'       => 'archive_listing_sidebar_position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sidebar Position', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose sidebar position.', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'sidebar-left'  => 'Sidebar Left',
				'sidebar-right' => 'Sidebar Right',
			),
			'default'  => 'sidebar-left',
			'required' => array( 'archive_listing_sidebar', '=', 'enable' )
		),
		array(
			'id'       => 'map_position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Map Position', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose map position.', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'hide-map'       => 'Hide Map',
				'map-header'       => 'Map Header',
				'half-map-left'       => 'Half Map Left',
				'half-map-right'       => 'Half Map Right',
			),
			'default'  => 'hide-map',
		),
		array(
            'id'      => 'hide_map_mobile',
            'type'    => 'button_set',
            'title'   => esc_html__('Hide Map On Mobile', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
			'id'       => 'item_per_page_archive_listing',
			'type'     => 'text',
			'title'    => esc_html__( 'Item Per Page', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Set number of item per page archive listing.', 'tf-car-listing' ),
			'default'  => esc_html__( '9', 'tf-car-listing' )
		),
		array(
			'id'       => 'begin_information_card_listing',
			'type'     => 'section',
			'title'    => esc_html__( 'List Information Card Listing', 'tf-car-listing' ),
			'indent'   => true,
		),
		array(
            'id'      => 'enable_counter_gallery',
            'type'    => 'button_set',
            'title'   => esc_html__('Counter Gallery', 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) Counter Gallery', 'tf-car-listing' ),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_year_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_year')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_year')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_fuel_type_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_fuel_type'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_fuel_type')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_mileages_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_mileage')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_mileage')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_transmission_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_transmission'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_transmission')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_make_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_make'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_make')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_model_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_model'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_model')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_body_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_body'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_body')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_stock_number_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_stock_number')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_stock_number')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_vin_number_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_vin_number')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_vin_number')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_drive_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_drive_type'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_drive_type')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_engine_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_engine_size')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_engine_size')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_cylinders_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_cylinders'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_cylinders')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_door_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_door')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_door')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_color_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_color'), 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_color')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_seat_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_seat')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_seat')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_city_mpg_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_city_mpg')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_city_mpg')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_highway_mpg_listing',
            'type'    => 'button_set',
            'title'   => esc_html__(get_option('custom_name_highway_mpg')),
			'subtitle' => esc_html__( '(Show/Hide) ', 'tf-car-listing' ) . esc_html(get_option('custom_name_highway_mpg')),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'n',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_author_listing',
            'type'    => 'button_set',
            'title'   => esc_html__('Author Listing', 'tf-car-listing'),
			'subtitle' => esc_html__( '(Show/Hide) Author', 'tf-car-listing' ),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
			'id'       => 'text_card_button',
			'type'     => 'text',
			'title'    => esc_html__( 'Text Button', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'This option changes the display name for the card button', 'tf-car-listing' ),
			'default'  => esc_html__( 'View car', 'tf-car-listing' )
		),
		array(
			'id'       => 'end_information_card_listing',
			'type'     => 'section',
			'indent'   => false,
		),
		array(
			'id'       => 'begin_actions_card_listing',
			'type'     => 'section',
			'title'    => esc_html__( 'Actions Card Listing', 'tf-car-listing' ),
			'indent'   => true,
		),
		array(
            'id'      => 'enable_sort_by_option',
            'type'    => 'button_set',
            'title'   => esc_html__('Sort By Option', 'tf-car-listing'),
			'subtitle' => esc_html__( '(Enable/Disable) Sort By Option', 'tf-car-listing' ),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
            'id'      => 'enable_switch_layout_button',
            'type'    => 'button_set',
            'title'   => esc_html__('Switch Layout button', 'tf-car-listing'),
			'subtitle' => esc_html__( '(Enable/Disable) Switch Layout button', 'tf-car-listing' ),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'      => 'enable_switch_layout_column_button',
            'type'    => 'button_set',
            'title'   => esc_html__('Switch Layout Column button', 'tf-car-listing'),
			'subtitle' => esc_html__( '(Enable/Disable) Switch Layout button', 'tf-car-listing' ),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
		array(
			'id'       => 'end_actions_card_listing',
			'type'     => 'section',
			'indent'   => false,
		),
	)
);