<?php
return array(
	'title'  => esc_html__( 'Invoice Options', 'tf-car-listing' ),
	'id'     => 'invoice-options',
	'desc'   => '',
	'icon'   => 'el el-list-alt',
	'fields' => array(
        array(
            'id'       => 'invoice_company_name',
            'type'     => 'text',
            'title'    => esc_html__('Company Name', 'tf-car-listing'),
            'default'  => ''
        ),
		array(
            'id'       => 'invoice_company_phone',
            'type'     => 'text',
            'title'    => esc_html__('Company Phone', 'tf-car-listing'),
            'default'  => ''
        ),
		array(
            'id'       => 'invoice_company_address',
            'type'     => 'text',
            'title'    => esc_html__('Company Address', 'tf-car-listing'),
            'default'  => ''
        ),
    )
);