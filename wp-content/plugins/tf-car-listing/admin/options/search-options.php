<?php
return array(
	'title'  => esc_html__( 'Search', 'tf-car-listing' ),
	'id'     => 'search-options',
	'desc'   => '',
	'icon'   => 'el el-search',
	'fields' => array(
		array(
			'id'       => 'begin_advanced_search',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Advanced Search', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => true
		),
		array(
			'id'      => 'enable_advanced_search_form',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Advanced Search Form', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'enable_button_avanced_search',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Extend Advanced Search', 'tf-car-listing' ),
			'desc'    => esc_html__( 'This option will display extend for Advanced Search', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Enable', 'tf-car-listing' ),
				'n' => esc_html__( 'Disable', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'enable_condition_search',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Status Tabs', 'tf-car-listing' ),
			'desc'    => esc_html__( 'This option will display status tabs on the search bar', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Enable', 'tf-car-listing' ),
				'n' => esc_html__( 'Disable', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'search_criteria_keyword_field',
			'type'    => 'select',
			'title'   => esc_html__( 'Search Criteria Keyword Field', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Choose one search criteria for the keyword field', 'tf-car-listing' ),
			'options' => array(
				'criteria_title'   => esc_html__( 'Title', 'tf-car-listing' ),
				'criteria_address' => esc_html__( 'Address, street, zip or listing ID', 'tf-car-listing' )
			),
			'default' => 'criteria_title',
		),
		array(
			'id'      => 'price_search_field_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Price Field', 'tf-car-listing' ),
			'options' => array(
				'dropdown' => esc_html__( 'Dropdown', 'tf-car-listing' ),
				'slider'   => esc_html__( 'Slider', 'tf-car-listing' ),
			),
			'default' => 'dropdown',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'year_search_field_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Year Field', 'tf-car-listing' ),
			'options' => array(
				'dropdown' => esc_html__( 'Dropdown', 'tf-car-listing' ),
				'slider'   => esc_html__( 'Slider', 'tf-car-listing' ),
			),
			'default' => 'dropdown',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'mileage_search_field_type',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Mileage Field', 'tf-car-listing' ),
			'options' => array(
				'dropdown' => esc_html__( 'Dropdown', 'tf-car-listing' ),
				'slider'   => esc_html__( 'Slider', 'tf-car-listing' ),
			),
			'default' => 'dropdown',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'      => 'toggle_listing_features',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Toggle Listing Features', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'y',
			'class'   => 'hide-icon-blank',
		),
		array(
			'id'       => 'text_title_sidebar_form',
			'type'     => 'text',
			'title'    => esc_html__( 'Title Sidebar Search Sidebar', 'tf-car-listing' ),
			'default'  => 'Filters and Sort',
		),
		array(
			'id'     => 'begin_section_custom_search_label_button',
			'type'   => 'section',
			'title'  => esc_html__( 'Button Search', 'tf-car-listing' ),
			'indent' => true
		),

		array(
			'id'      => 'enable_custom_search_label_button',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Customize The Search Button Label', 'tf-car-listing' ),
			'desc'    => esc_html__( 'This option changes the display name for the search button.', 'tf-car-listing' ),
			'options' => array(
				'y' => esc_html__( 'Yes', 'tf-car-listing' ),
				'n' => esc_html__( 'No', 'tf-car-listing' ),
			),
			'default' => 'n',
			'class'   => 'hide-icon-blank',
		),

		array(
			'id'       => 'text_custom_search_label',
			'type'     => 'text',
			'title'    => esc_html__( 'Button Label', 'tf-car-listing' ),
			'desc'    => esc_html__( 'Enter the name you want to display for the button.', 'tf-car-listing' ),
			'required' => array( 'enable_custom_search_label_button', '=', 'y' )
		),
		array(
            'id'     => 'end__section_custom_search_label_button',
            'type'   => 'section',
            'indent' => false,
        ),
		array(
			'id'       => 'end_advanced_search',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Price Field Value
		array(
			'id'       => 'begin_price_field',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Price Field', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'minimum_prices_dropdown',
			'type'     => 'text',
			'title'    => esc_html__( 'Minimum Prices Dropdown', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Allow only comma separated numbers list', 'tf-car-listing' ),
			'required' => array( 'price_search_field_type', '=', 'dropdown' )
		),
		array(
			'id'       => 'maximum_prices_dropdown',
			'type'     => 'text',
			'title'    => esc_html__( 'Maximum Prices Dropdown', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Allow only comma separated numbers list', 'tf-car-listing' ),
			'required' => array( 'price_search_field_type', '=', 'dropdown' )
		),
		array(
			'id'       => 'minimum_prices_slider',
			'type'     => 'text',
			'title'    => esc_html__( 'Minimum Prices Slider', 'tf-car-listing' ),
			'validate' => 'numeric',
			'required' => array( 'price_search_field_type', '=', 'slider' )
		),
		array(
			'id'       => 'maximum_prices_slider',
			'type'     => 'text',
			'title'    => esc_html__( 'Maximum Prices Slider', 'tf-car-listing' ),
			'validate' => 'numeric',
			'required' => array( 'price_search_field_type', '=', 'slider' )
		),
		array(
			'id'       => 'end_price_field',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Year Field Value
		array(
			'id'       => 'accordion_year_field_start',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Year Field', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'minimum_years_dropdown',
			'type'     => 'text',
			'title'    => esc_html__( 'Minimum Years Dropdown', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Allow only comma separated numbers list', 'tf-car-listing' ),
			'required' => array( 'year_search_field_type', '=', 'dropdown' )
		),
		array(
			'id'       => 'maximum_years_dropdown',
			'type'     => 'text',
			'title'    => esc_html__( 'Maximum Years Dropdown', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Allow only comma separated numbers list', 'tf-car-listing' ),
			'required' => array( 'year_search_field_type', '=', 'dropdown' )
		),
		array(
			'id'       => 'minimum_years_slider',
			'type'     => 'text',
			'title'    => esc_html__( 'Minimum Years Slider', 'tf-car-listing' ),
			'validate' => 'numeric',
			'required' => array( 'year_search_field_type', '=', 'slider' )
		),
		array(
			'id'       => 'maximum_years_slider',
			'type'     => 'text',
			'title'    => esc_html__( 'Maximum Years Slider', 'tf-car-listing' ),
			'validate' => 'numeric',
			'required' => array( 'year_search_field_type', '=', 'slider' )
		),
		array(
			'id'       => 'accordion_year_field_end',
			'type'     => 'accordion',
			'position' => 'end',
		),
		// Mileage Field
		array(
			'id'       => 'accordion_mileage_field_start',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Mileage Field', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'minium_mileage_dropdown',
			'type'     => 'text',
			'title'    => esc_html__( 'Minium Mileage Dropdown', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Allow only comma separated numbers list', 'tf-car-listing' ),
			'required' => array( 'mileage_search_field_type', '=', 'dropdown' )
		),
		array(
			'id'       => 'maximum_mileage_dropdown',
			'type'     => 'text',
			'title'    => esc_html__( 'Maximum Mileage Dropdown', 'tf-car-listing' ),
			'desc'     => esc_html__( 'Allow only comma separated numbers list', 'tf-car-listing' ),
			'required' => array( 'mileage_search_field_type', '=', 'dropdown' )
		),
		array(
			'id'       => 'minimum_mileage_slider',
			'type'     => 'text',
			'title'    => esc_html__( 'Minimum Mileage Slider', 'tf-car-listing' ),
			'validate' => 'numeric',
			'required' => array( 'mileage_search_field_type', '=', 'slider' )
		),
		array(
			'id'       => 'maximum_mileage_slider',
			'type'     => 'text',
			'title'    => esc_html__( 'Maximum Mileage Slider', 'tf-car-listing' ),
			'validate' => 'numeric',
			'required' => array( 'mileage_search_field_type', '=', 'slider' )
		),
		array(
			'id'       => 'accordion_mileage_field_end',
			'type'     => 'accordion',
			'position' => 'end',
		),
		
		// Show Hide Advanced Form Fields Accordion
		array(
			'id'       => 'begin_show_hide_advanced_search_fields',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Sort and Show Advanced Search Fields', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'advanced_search_fields',
			'type'     => 'sortable',
			'mode'     => 'checkbox',
			'title'    => esc_html__( 'Show Advanced Search Form Fields', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which fields you want to show on search form? (The first 4 fields are in the main search form, the remaining fields are in the advanced search)', 'tf-car-listing' ),
			'options'  => array(
				'listing-make'         => esc_html__( 'Listing Make', 'tf-car-listing' ),
				'listing-model'        => esc_html__( 'Listing Model', 'tf-car-listing' ),
				'listing-body'         => esc_html__( 'Listing Body', 'tf-car-listing' ),
				'listing-featured'     => esc_html__( 'Featured', 'tf-car-listing' ),
				'listing-keyword'      => esc_html__( 'Listing keyword', 'tf-car-listing' ),
				'listing-price'        => esc_html__( 'Listing Price', 'tf-car-listing' ),
				'listing-fuel-type'    => esc_html__( 'Listing Fuel Type', 'tf-car-listing' ),
				'listing-transmission' => esc_html__( 'Listing Transmission', 'tf-car-listing' ),
				'listing-driver-type'  => esc_html__( 'Listing Driver Type', 'tf-car-listing' ),
				'listing-mileage'      => esc_html__( 'Listing Mileage', 'tf-car-listing' ),
				'listing-door'         => esc_html__( 'Listing Door', 'tf-car-listing' ),
				'listing-cylinder'     => esc_html__( 'Listing Cylinder', 'tf-car-listing' ),
				'listing-color'        => esc_html__( 'Listing Color', 'tf-car-listing' ),
				'listing-year'         => esc_html__( 'Listing Year', 'tf-car-listing' ),
				'listing-engine-size'     => esc_html__( 'Listing Engine Size', 'tf-car-listing' ),
				'listing-features'     => esc_html__( 'Listing Features', 'tf-car-listing' ),
			),
			'default'  => array(
				'listing-make'         => true,
				'listing-model'        => true,
				'listing-body'         => true,
				'listing-fuel-type'    => true,
				'listing-keyword'      => false,
				'listing-transmission' => true,
				'listing-driver-type'  => true,
				'listing-cylinder'     => true,
				'listing-door'         => true,
				'listing-color'        => true,
				'listing-mileage'      => true,
				'listing-price'        => true,
				'listing-year'         => true,
				'listing-engine-size'     => false,
				'listing-featured'     => true,
				'listing-features'     => true,
			),
		),
		// Show Hide Search Filter Form Fields Accordion
		array(
			'id'       => 'begin_show_hide_search_filter_fields',
			'type'     => 'accordion',
			'title'    => esc_html__( 'Sort And Show Hide Search Filter Form Fields', 'tf-car-listing' ),
			'position' => 'start',
			'open'     => false
		),
		array(
			'id'       => 'search_filter_fields',
			'type'     => 'sortable',
			'mode'     => 'checkbox',
			'title'    => esc_html__( 'Sort And Show Hide Search Filter Form Fields', 'tf-car-listing' ),
			'subtitle' => esc_html__( 'Choose which fields you want to show on search filter form?', 'tf-car-listing' ),
			'options'  => array(
				'listing-make'         => esc_html__( 'Listing Make', 'tf-car-listing' ),
				'listing-model'        => esc_html__( 'Listing Model', 'tf-car-listing' ),
				'listing-body'         => esc_html__( 'Listing Body', 'tf-car-listing' ),
				'listing-featured'     => esc_html__( 'Featured', 'tf-car-listing' ),
				'listing-keyword'      => esc_html__( 'Listing keyword', 'tf-car-listing' ),
				'listing-price'        => esc_html__( 'Listing Price', 'tf-car-listing' ),
				'listing-fuel-type'    => esc_html__( 'Listing Fuel Type', 'tf-car-listing' ),
				'listing-transmission' => esc_html__( 'Listing Transmission', 'tf-car-listing' ),
				'listing-driver-type'  => esc_html__( 'Listing Driver Type', 'tf-car-listing' ),
				'listing-mileage'      => esc_html__( 'Listing Mileage', 'tf-car-listing' ),
				'listing-door'         => esc_html__( 'Listing Door', 'tf-car-listing' ),
				'listing-cylinder'     => esc_html__( 'Listing Cylinder', 'tf-car-listing' ),
				'listing-color'        => esc_html__( 'Listing Color', 'tf-car-listing' ),
				'listing-year'         => esc_html__( 'Listing Year', 'tf-car-listing' ),
				'listing-engine-size'     => esc_html__( 'Listing Engine Size', 'tf-car-listing' ),
				'listing-features'     => esc_html__( 'Listing Features', 'tf-car-listing' ),
			),
			'default'  => array(
				'listing-make'         => true,
				'listing-model'        => true,
				'listing-body'         => true,
				'listing-fuel-type'    => true,
				'listing-keyword'      => false,
				'listing-price'        => true,
				'listing-door'         => true,
				'listing-color'        => true,
				'listing-year'         => true,
				'listing-transmission' => true,
				'listing-driver-type'  => true,
				'listing-mileage'      => true,
				'listing-cylinder'     => true,
				'listing-engine-size'     => false,
				'listing-featured'     => true,
				'listing-features'     => true,
			),
		),
		array(
			'id'       => 'end_show_hide_search_filter_fields',
			'type'     => 'accordion',
			'position' => 'end',
		),
	)
);