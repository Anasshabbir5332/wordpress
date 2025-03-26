<?php
return array(
	'title'  => esc_html__( 'Single Listing', 'tf-car-listing' ),
	'id'     => 'single-listing-options',
	'desc'   => '',
	'icon'   => 'el el-info-circle',
	'fields' => array(
        array(
			'id'     => 'begin_gallery_single_listing',
			'type'   => 'section',
			'title'  => esc_html__( 'Gallery Single Listing', 'tf-car-listing' ),
			'indent' => true,
		),
		array(
			'id'       => 'gallery_default_single',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Gallery Default Single', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose Gallery Default Single', 'tf-car-listing' ),
			'class'    => 'hide-icon-blank',
			'options'  => array(
				'gallery-style-grid' => 'Grid',
				'gallery-style-slider' => 'Slider',
				'gallery-style-slider-2' => 'Slider 2',
				'gallery-style-slider-3' => 'Slider 3',
			),
			'default'  => 'gallery-style-grid',
		),
		array(
			'id'     => 'end_gallery_single_listing',
			'type'   => 'section',
			'indent' => true,
		),
        array(
			'id'     => 'begin_actions_single_listing',
			'type'   => 'section',
			'title'  => esc_html__( 'Listing Actions Button', 'tf-car-listing' ),
			'indent' => true,
		),
		array(
            'id'       => 'show_hide_actions_button',
            'type'     => 'checkbox',
            'title'    => esc_html__('Show Actions Button', 'tf-car-listing'),
            'subtitle' => esc_html__('Choose which button actions you want to show on single page.', 'tf-car-listing'),
            'options'  => array(
                'compare-actions-button'     => esc_html__('Compare Button', 'tf-car-listing'),
                'favorite-actions-button'     => esc_html__('Favorite Button', 'tf-car-listing'),
                'social-actions-button'     => esc_html__('Social Share Button', 'tf-car-listing'),
                'print-actions-button'     => esc_html__('Print Button', 'tf-car-listing'),
            ),
            'default' => array(
                'compare-actions-button'     => 1,
                'favorite-actions-button'     => 1,
                'social-actions-button'     => 1,
                'print-actions-button'     => 1,
            )
        ),
		array(
			'id'     => 'end_actions_single_listing',
			'type'   => 'section',
			'indent' => true,
		),
    )
);