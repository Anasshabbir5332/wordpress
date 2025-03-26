<?php
return array(
	'title'  => esc_html__( 'Package Options', 'tf-car-listing' ),
	'id'     => 'package-options',
	'desc'   => '',
	'icon'   => 'el el-folder',
	'fields' => array(
		array(
			'id'      => 'enable_package',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Package', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
        array(
			'id'    => 'package_currency_sign',
			'type'  => 'text',
			'title' => esc_html__( 'Currency Sign', 'tf-car-listing' ),
		),
        array(
			'id'      => 'package_currency_sign_position',
			'type'    => 'select',
			'title'   => esc_html__( 'Currency Sign Position', 'tf-car-listing' ),
			'options' => array(
				'before' => esc_html__( 'Before ($1,000)', 'tf-car-listing' ),
				'after'  => esc_html__( 'After (1,000$)', 'tf-car-listing' ),
			),
			'default' => 'before',
		),
    )
);