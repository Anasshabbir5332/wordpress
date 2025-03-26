<?php
return array(
	'title'  => esc_html__( 'Payment Options', 'tf-car-listing' ),
	'id'     => 'payment-options',
	'desc'   => '',
	'icon'   => 'el el-shopping-cart',
	'fields' => array(
		array(
			'id'      => 'currency_code',
			'type'    => 'text',
			'title'   => esc_html__( 'Currency Code For Payment', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Provide the currency code that you want to use to payment. Ex. USD', 'tf-car-listing' ),
			'default' => 'USD'
		),
		// Paypal setting
		array(
			'id'     => 'begin_paypal_setting',
			'type'   => 'section',
			'title'  => esc_html__( 'Paypal Setting', 'tf-car-listing' ),
			'indent' => true
		),
		array(
			'id'      => 'enable_paypal_setting',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Paypal setting', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'       => 'paypal_api',
			'type'     => 'select',
			'title'    => esc_html__( 'Paypal Api', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Sandbox = test API. LIVE = real payments API', 'tf-car-listing' ),
			'options'  => array(
				'sandbox' => esc_html__( 'Sandbox', 'tf-car-listing' ),
				'live'    => esc_html__( 'Live', 'tf-car-listing' ),
			),
			'default'  => 'sandbox',
			'required' => array( 'enable_paypal_setting', '=', 'y' )
		),
		array(
			'id'       => 'paypal_client_id',
			'type'     => 'text',
			'title'    => esc_html__( 'Paypal Client ID', 'tf-car-listing' ),
			'default'  => '',
			'required' => array( 'enable_paypal_setting', '=', 'y' )
		),
		array(
			'id'       => 'paypal_client_secret_key',
			'type'     => 'text',
			'title'    => esc_html__( 'Paypal Client Secret Key', 'tf-car-listing' ),
			'default'  => '',
			'required' => array( 'enable_paypal_setting', '=', 'y' )
		),
		array(
			'id'     => 'end_paypal_setting',
			'type'   => 'section',
			'indent' => false,
		),

		// Wire Transfer Setting
		array(
			'id'     => 'begin_wire_transfer_setting',
			'type'   => 'section',
			'title'  => esc_html__( 'Wire Transfer Setting', 'tf-car-listing' ),
			'indent' => true
		),
		array(
			'id'      => 'enable_wire_transfer_setting',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Wire Transfer Setting', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'       => 'wire_transfer_information',
			'type'     => 'editor',
			'title'    => esc_html__( 'Wire Transfer Information', 'tf-car-listing' ),
			'args'     => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => 15,
				'quicktags'     => true,
			),
			'required' => array( 'enable_wire_transfer_setting', '=', 'y' ),
			'default'  => esc_html__( 'Bank Account Information:

                Bank Name
                
                Account ID
                
                Account Name
                
                Note: Payment directly into our bank account before click "Pay Now"

                ', 'tf-car-listing' ),
		),
		array(
			'id'     => 'end_wire_transfer_setting',
			'type'   => 'section',
			'indent' => false,
		),
		// Stripe Setting
		array(
			'id'     => 'begin_stripe_setting',
			'type'   => 'section',
			'title'  => esc_html__( 'Stripe Setting', 'tf-car-listing' ),
			'indent' => true
		),
		array(
			'id'      => 'enable_stripe_setting',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Stripe setting', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'       => 'stripe_publishable_key',
			'type'     => 'text',
			'title'    => esc_html__( 'Publishable Key', 'tf-car-listing' ),
			'default'  => '',
			'required' => array( 'enable_stripe_setting', '=', 'y' )
		),
		array(
			'id'       => 'stripe_secret_key',
			'type'     => 'text',
			'title'    => esc_html__( 'Secret Key', 'tf-car-listing' ),
			'default'  => '',
			'required' => array( 'enable_stripe_setting', '=', 'y' )
		),
		array(
			'id'     => 'end_stripe_setting',
			'type'   => 'section',
			'indent' => false,
		),

		// Payment Completed Setting
		array(
			'id'     => 'begin_payment_completed_setting',
			'type'   => 'section',
			'title'  => esc_html__( 'Payment Completed Setting', 'tf-car-listing' ),
			'indent' => true
		),

		array(
			'id'      => 'thankyou_title',
			'type'    => 'text',
			'title'   => esc_html__( 'Title', 'tf-car-listing' ),
			'default' => esc_html__( 'Thank you for your purchase package in our page', 'tf-car-listing' ),
		),

		array(
			'id'      => 'thankyou_paypal_stripe_content',
			'type'    => 'editor',
			'title'   => esc_html__( 'Thank-you note after payment via Paypal', 'tf-car-listing' ),
			'args'    => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => 15,
				'quicktags'     => true,
			),
			'default' => '',
		),

		array(
			'id'      => 'thankyou_wire_transfer_content',
			'type'    => 'editor',
			'title'   => esc_html__( 'Thank-you note after payment via Wire Transfer', 'tf-car-listing' ),
			'args'    => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => 15,
				'quicktags'     => true,
			),
			'default' => esc_html__( 'Make your payment directly into our bank account. Please use your Invoice ID as payment reference', 'tf-car-listing' ),
		),

		array(
			'id'     => 'end_payment_completed_setting',
			'type'   => 'section',
			'indent' => false,
		),
	)
);