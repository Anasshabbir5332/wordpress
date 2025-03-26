<?php
return array(
	'title'  => esc_html__( 'Single Dealer & Seller', 'tf-car-listing' ),
	'id'     => 'single-dealer-seller-options',
	'desc'   => '',
	'icon'   => 'el el-info-circle',
	'fields' => array(
		array(
			'id'     => 'begin_seller_setting',
			'type'   => 'section',
			'title'  => esc_html__( 'Seller Setting', 'tf-car-listing' ),
			'indent' => true
		),
		array(
			'id'      => 'default_heading_seller_listing',
			'type'    => 'text',
			'title'   => esc_html__( 'Default Heading Seller Listing', 'tf-car-listing' ),
			'default' => esc_html__( 'Seller Inventory', 'tf-car-listing' )
		),

		array(
			'id'     => 'end_seller_setting',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'     => 'begin_dealer_setting',
			'type'   => 'section',
			'title'  => esc_html__( 'Dealer Setting', 'tf-car-listing' ),
			'indent' => true
		),
            array(
                'id'       => 'heading_listing_dealer_shortcode',
                'type'     => 'text',
                'title'    => esc_html__('Default Heading Dealer Listing', 'tf-car-listing'),
                'default'  => esc_html__('Dealership inventory','tf-car-listing')
            ),
            array(
                'id'       => 'limit_show_image',
                'type'     => 'text',
                'title'    => esc_html__('Limit Show Images', 'tf-car-listing'),
                'subtitle' => esc_html__('Set number of images displayed in dealer listing', 'tf-car-listing'),
                'default'  => esc_html__('3', 'tf-car-listing')
            ),
			array(
				'id'       => 'single_dealer_sidebar',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Sidebar', 'tf-car-listing' ),
				'subtitle' => esc_html__( 'Enable/Disable sidebar.', 'tf-car-listing' ),
				'class'    => 'hide-icon-blank',
				'options'  => array(
					'enable'  => esc_html__( 'Enable', 'tf-car-listing' ),
					'disable' => esc_html__( 'Disable', 'tf-car-listing' ),
				),
				'default'  => 'enable',
			),
			array(
				'id'       => 'single_dealer_sidebar_position',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Sidebar Position', 'tf-car-listing' ),
				'subtitle' => esc_html__( 'Choose sidebar position.', 'tf-car-listing' ),
				'class'    => 'hide-icon-blank',
				'options'  => array(
					'sidebar-left'  => esc_html__( 'Sidebar Left', 'tf-car-listing' ),
					'sidebar-right' => esc_html__( 'Sidebar Right', 'tf-car-listing' ),					
				),
				'default'  => 'sidebar-right',
				'required' => array( 'single_dealer_sidebar', '=', 'enable' )
			),	
					
        array(
            'id'     => 'end_dealer_setting',
            'type'   => 'section',
            'indent' => false,
        ),
    )
);