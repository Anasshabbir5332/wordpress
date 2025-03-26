<?php
return array(
	'title'  => esc_html__( 'User', 'tf-car-listing' ),
	'id'     => 'user-options',
	'desc'   => '',
	'icon'   => 'el el-user',
	'fields' => array(
		array(
			'id'      => 'show_demo_account',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Show Demo Account', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'user_can_become_dealer',
			'type'    => 'button_set',
			'title'   => esc_html__( 'User can register become a dealer ?', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank'
		),
		array(
			'id'      => 'auto_approve_dealer',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Automatically approved user become a dealer ?', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'enable_login_register_popup',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Login & Register Popup', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'default_user_avatar',
			'type'    => 'media',
			'url'     => true,
			'title'   => esc_html__( 'Default User Avatar', 'tf-car-listing' ),
			'default' => array(
				'url' => ''
			),
		),
		array(
			'id'      => 'login_thumbnail',
			'type'    => 'media',
			'url'     => true,
			'title'   => esc_html__( 'Login Thumbnail Popup', 'tf-car-listing' ),
			'default' => array(
				'url' => ''
			),
		),
		array(
			'id'      => 'register_thumbnail',
			'type'    => 'media',
			'url'     => true,
			'title'   => esc_html__( 'Register Thumbnail Popup', 'tf-car-listing' ),
			'default' => array(
				'url' => ''
			),
		),
		// Google Login
		array(
			'id'       => 'begin_google_login',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Google Login', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'      => 'enable_google_login',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Google Login', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'       => 'google_login_client_id',
			'type'     => 'text',
			'title'    => esc_html__( 'Client ID', 'tf-car-listing' ),
			'required' => array( 'enable_google_login', '=', 'y' )
		),
		array(
			'id'       => 'google_login_client_secret',
			'type'     => 'text',
			'title'    => esc_html__( 'Client Secret', 'tf-car-listing' ),
			'required' => array( 'enable_google_login', '=', 'y' )
		),
		array(
			'id'       => 'google_login_dev_api_key',
			'type'     => 'text',
			'title'    => esc_html__( 'API Key', 'tf-car-listing' ),
			'required' => array( 'enable_google_login', '=', 'y' )
		),
		array(
			'id'       => 'end_google_login',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Show Hide Dealer Information Accordion
		array(
			'id'       => 'begin_show_hide_dealer_information',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Show Dealer Information', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'show_hide_dealer_information',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Show Dealer Information', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which information you want to show on Dealer page?', 'tf-car-listing' ),
			'options'  => array(
				// Information
				'user_email'   => esc_html__( 'Email', 'tf-car-listing' ),
				'user_phone'   => esc_html__( 'Phone', 'tf-car-listing' ),
			),
			'default'  => array(
				// Information
				'user_email'   => 1,
				'user_phone'   => 1,
			)
		),
		array(
			'id'       => 'end_show_hide_dealer_information',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Show Hide Profile Form Fields Accordion
		array(
			'id'       => 'begin_show_hide_profile_fields',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Show Profile Fields', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'show_hide_profile_fields',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Show Profile Form Fields', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which fields you want to show on Profile page?', 'tf-car-listing' ),
			'options'  => array(
				// Information
				'first_name'       => esc_html__( 'First Name', 'tf-car-listing' ),
				'last_name'        => esc_html__( 'Last Name', 'tf-car-listing' ),
				'user_description' => esc_html__( 'Description', 'tf-car-listing' ),
				'user_email'       => esc_html__( 'Email', 'tf-car-listing' ),
				'user_phone'       => esc_html__( 'Phone', 'tf-car-listing' ),
				'user_sales_phone' => esc_html__( 'Sales Phone', 'tf-car-listing' ),
				'user_location'    => esc_html__( 'Location', 'tf-car-listing' ),
				'user_sales_hour'  => esc_html__( 'Business Hours', 'tf-car-listing' ),
				'user_company'     => esc_html__( 'Company', 'tf-car-listing' ),
				'user_position'    => esc_html__( 'Position', 'tf-car-listing' ),
				'user_website'     => esc_html__( 'Website', 'tf-car-listing' ),

				// Social
				'user_facebook'    => esc_html__( 'Facebook', 'tf-car-listing' ),
				'user_twitter'     => esc_html__( 'Twitter', 'tf-car-listing' ),
				'user_linkedin'    => esc_html__( 'Linkedin', 'tf-car-listing' ),
				'user_instagram'   => esc_html__( 'Instagram', 'tf-car-listing' ),
				'user_dribble'     => esc_html__( 'Dribble', 'tf-car-listing' ),
				'user_skype'       => esc_html__( 'Skype', 'tf-car-listing' ),
				'user_youtube'     => esc_html__( 'Youtube', 'tf-car-listing' ),
				'user_vimeo'       => esc_html__( 'Vimeo', 'tf-car-listing' ),
				'user_pinterest'   => esc_html__( 'Pinterest', 'tf-car-listing' ),
				'user_tiktok'      => esc_html__( 'TikTok', 'tf-car-listing' )
			),
			'default'  => array(
				// Information
				'first_name'       => 1,
				'last_name'        => 1,
				'user_email'       => 1,
				'user_phone'       => 1,
				'user_description' => 1,
				'user_location'    => 1,
				'user_company'     => 1,
				'user_position'    => 1,
				'user_website'     => 1,


				// Social
				'user_facebook'    => 1,
				'user_twitter'     => 1,
				'user_linkedin'    => 1,
				'user_instagram'   => 1,
				'user_dribble'     => 1,
				'user_skype'       => 1,
				'user_youtube'     => 1,
				'user_pinterest'   => 1,

			)
		),
		array(
			'id'       => 'end_show_hide_profile_fields',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Require Profile Form Fields Accordion
		array(
			'id'       => 'begin_require_profile_fields',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Require Profile Fields', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'require_profile_fields',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Require Profile Form Fields', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which fields you want to require on Profile page?', 'tf-car-listing' ),
			'options'  => array(
				// Information
				'first_name'       => esc_html__( 'First Name', 'tf-car-listing' ),
				'last_name'        => esc_html__( 'Last Name', 'tf-car-listing' ),
				'user_email'       => esc_html__( 'Email', 'tf-car-listing' ),
				'user_phone'       => esc_html__( 'Phone', 'tf-car-listing' ),
				'user_description' => esc_html__( 'Description', 'tf-car-listing' ),
				'user_sales_phone' => esc_html__( 'Sales Phone', 'tf-car-listing' ),
				'user_location'    => esc_html__( 'Location', 'tf-car-listing' ),
				'user_sales_hour'  => esc_html__( 'Business Hours', 'tf-car-listing' ),
				'user_company'     => esc_html__( 'Company', 'tf-car-listing' ),
				'user_position'    => esc_html__( 'Position', 'tf-car-listing' ),
				'user_website'     => esc_html__( 'Website', 'tf-car-listing' ),
				// Social
				'user_facebook'    => esc_html__( 'Facebook', 'tf-car-listing' ),
				'user_twitter'     => esc_html__( 'Twitter', 'tf-car-listing' ),
				'user_linkedin'    => esc_html__( 'Linkedin', 'tf-car-listing' ),
				'user_instagram'   => esc_html__( 'Instagram', 'tf-car-listing' ),
				'user_dribble'     => esc_html__( 'Dribble', 'tf-car-listing' ),
				'user_skype'       => esc_html__( 'Skype', 'tf-car-listing' ),
				'user_youtube'     => esc_html__( 'Youtube', 'tf-car-listing' ),
				'user_vimeo'       => esc_html__( 'Vimeo', 'tf-car-listing' ),
				'user_pinterest'   => esc_html__( 'Pinterest', 'tf-car-listing' ),
				'user_tiktok'      => esc_html__( 'TikTok', 'tf-car-listing' )
			),
			'default'  => array(
				// Information
				'first_name'       => 1,
				'last_name'        => 1,
				'user_email'       => 1,
				'user_phone'       => 1,
				'user_description' => 1,
				'user_location'    => 1,
				'user_company'     => 1,
				'user_position'    => 1,
				'user_website'     => 0,

				// Social
				'user_facebook'    => 0,
				'user_twitter'     => 0,
				'user_linkedin'    => 0,
				'user_instagram'   => 0,
				'user_dribble'     => 0,
				'user_skype'       => 0,
				'user_youtube'     => 0,
				'user_vimeo'       => 0,
				'user_pinterest'   => 0,
			)
		),
		array(
			'id'       => 'end_require_profile_fields',
			'type'     => 'accordion',
			'position' => 'end',
		),
	)
);