<?php
class Widget_Listing extends \Elementor\Widget_Base {

	public function get_name() {
		return 'tf_listing_list';
	}

	public function get_title() {
		return esc_html__( 'TF Listings Car', 'tf-car-listing' );
	}

	public function get_icon() {
		return 'eicon-archive';
	}

	public function get_categories() {
		return [ 'themesflat_car_listing_addons' ];
	}

	public function get_keywords() {
		return [ 'listing', 'list' ];
	}

	public function get_style_depends() {
		return [ 'magnific-popup', 'owl-carousel', 'listing-styles' ];
	}

	public function get_script_depends() {
		return [ 'magnific-popup', 'owl-carousel', 'listing-script' ];
	}

	protected function register_controls() {
		// Start listing Query        
		$this->start_controls_section(
			'section_listing_query',
			[ 
				'label' => esc_html__( 'Query', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Layout Style', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'style1' => [
						'title' => esc_html__( 'Style Grid', 'tf-car-listing' ),
						'icon' => 'eicon-posts-grid',
					],
					'style2' => [
						'title' => esc_html__( 'Style List', 'tf-car-listing' ),
						'icon' => 'eicon-post-list',
					],
				],
				'default' => 'style1',
				'toggle' => false,
			]
		);

		$this->add_control(
			'style_grid',
			[ 
				'label'   => esc_html__( 'Styles Grid', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'grid1',
				'options' => [ 
					'grid1' => esc_html__( 'Grid Style 1', 'tf-car-listing' ),
					'grid2' => esc_html__( 'Grid Style 2', 'tf-car-listing' ),
					'grid3' => esc_html__( 'Grid Style 3', 'tf-car-listing' ),
				],
				'condition' => [
					'style' => 'style1',
				],
			]
		);

		$this->add_control(
			'style_list',
			[ 
				'label'   => esc_html__( 'Styles List', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'list1',
				'options' => [ 
					'list1' => esc_html__( 'List Style 1', 'tf-car-listing' ),
					'list2' => esc_html__( 'List Style 2', 'tf-car-listing' ),
				],
				'condition' => [
					'style' => 'style2',
				],
			]
		);

		$this->add_control(
			'listing_per_page',
			[ 
				'label'   => esc_html__( 'listing Per Page', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '6',
			]
		);

		$this->add_control(
			'order_by',
			[ 
				'label'   => esc_html__( 'Order By', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [ 
					'date'  => esc_html__( 'Date', 'tf-car-listing' ),
					'ID'    => esc_html__( 'Post ID', 'tf-car-listing' ),
					'title' => esc_html__( 'Title', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'order',
			[ 
				'label'   => esc_html__( 'Order', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [ 
					'desc' => esc_html__( 'Descending', 'tf-car-listing' ),
					'asc'  => esc_html__( 'Ascending', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'exclude',
			[ 
				'label'       => esc_html__( 'Exclude', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Post Ids Will Be Ignored. Ex: 1,2,3', 'tf-car-listing' ),
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'sort_by_id',
			[ 
				'label'       => esc_html__( 'Sort By ID', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Post Ids Will Be Sort. Ex: 1,2,3', 'tf-car-listing' ),
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_counter',
			[ 
				'label'        => esc_html__( 'Show Counter Gallery', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_year',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_year'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_type_fuel',
			[ 
				'label'        => esc_html__( 'Show  ', 'tf-car-listing' ) . get_option('custom_name_fuel_type'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_mileages',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_mileage'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_transmission',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_transmission'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_make',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_make'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_model',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_model'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_body',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_body'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_stock_number',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_stock_number'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_vin_number',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_vin_number'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_drive_type',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_drive_type'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_engine_size',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_engine_size'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_cylinders',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_cylinders'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_door',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_door'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_color',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_color'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_seat',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_seat'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_city_mpg',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_city_mpg'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_highway_mpg',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_highway_mpg'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'color_icon_taxonomy',
			[ 
				'label'     => esc_html__( 'Icon Taxonomy Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-listing-wrap .wrap-listing-post .item .listing-post .description ul li svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'enable_author_listing',
			[ 
				'label'        => esc_html__( 'Show Author Listing', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'enable_compare_listing',
			[ 
				'label'        => esc_html__( 'Show Compare Listing', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'enable_favorite_listing',
			[ 
				'label'        => esc_html__( 'Show Favorite Listing', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'button_text',
			[ 
				'label'   => esc_html__( 'Text Button View Details', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View car', 'tf-car-listing' ),
			]
		);

		$this->add_responsive_control(
			'image_height',
			[ 
				'label'          => esc_html__( 'Height', 'tf-car-listing' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'default'        => [ 
					'unit' => 'px',
				],
				'tablet_default' => [ 
					'unit' => 'px',
				],
				'mobile_default' => [ 
					'unit' => 'px',
				],
				'size_units'     => [ 'px', '%', 'vh' ],
				'range'          => [ 
					'px' => [ 
						'min' => 1,
						'max' => 1000,
					],
					'%'  => [ 
						'min' => 1,
						'max' => 100,
					],
					'vh' => [ 
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .tf-listing-wrap .wrap-listing-post .item .listing-post .featured-property a img, {{WRAPPER}} .tf-listing-wrap .wrap-listing-post .item .listing-post .featured-property .swiper-container .swiper-slide img,{{WRAPPER}} .tf-listing-wrap.style2 .wrap-listing-post .item .listing-post .featured-property .swiper-container' => 'height: {{SIZE}}{{UNIT}};width: 100%;',
					'{{WRAPPER}} .hover-listing-image'                                                                                                                                                                                                                                                                                                         => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_object_fit',
			[ 
				'label'     => esc_html__( 'Object Fit', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'condition' => [ 
					'image_height[size]!' => '',
				],
				'options'   => [ 
					''        => esc_html__( 'Default', 'tf-car-listing' ),
					'fill'    => esc_html__( 'Fill', 'tf-car-listing' ),
					'cover'   => esc_html__( 'Cover', 'tf-car-listing' ),
					'contain' => esc_html__( 'Contain', 'tf-car-listing' ),
				],
				'default'   => '',
				'selectors' => [ 
					'{{WRAPPER}} .tf-listing-wrap .wrap-listing-post .item .listing-post .featured-property img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'layout',
			[ 
				'label'   => esc_html__( 'Columns', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'column-4',
				'options' => [ 
					'column-1' => esc_html__( '1', 'tf-car-listing' ),
					'column-2' => esc_html__( '2', 'tf-car-listing' ),
					'column-3' => esc_html__( '3', 'tf-car-listing' ),
					'column-4' => esc_html__( '4', 'tf-car-listing' ),
				],
			]
		);


		$this->end_controls_section();
		// /.End listing Query

		// Start Taxonomy Tabs
		$this->start_controls_section(
			'section_taxonomy_tabs',
			[ 
				'label' => esc_html__( 'Taxonomy Tabs', 'tf-car-listing' ),
			]
		);
		
		$this->add_control(
			'taxonomy_tabs',
			[ 
				'label'        => esc_html__( 'Taxonomy Tabs', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'taxonomy_list',
			[ 
				'label'     => esc_html__( 'Taxonomy Types', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'condition',
				'options'   => [ 
					'condition' =>  esc_html__("Listing ", 'tf-car-listing') . get_option('custom_name_condition', 'condition'),
					'make'      => esc_html__( 'Listing ', 'tf-car-listing' ) . get_option('custom_name_make', 'make'),
					'model'     => esc_html__( 'Listing ', 'tf-car-listing' ) . get_option('custom_name_model', 'model'),
					'body'      => esc_html__( 'Listing ', 'tf-car-listing' ) . get_option('custom_name_body', 'body'),
				],
				'condition' => [ 
					'taxonomy_tabs' => 'yes',
				],
			]
		);

		$this->add_control(
			'condition',
			[ 
				'label'       => esc_html__( 'Taxonomy ', 'tf-car-listing' ) . get_option('custom_name_condition', 'condition'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'condition' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy_list' => 'condition',
				],
			]
		);

		$this->add_control(
			'make',
			[ 
				'label'       => esc_html__( 'Taxonomy ', 'tf-car-listing' ) . get_option('custom_name_make', 'make'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'make' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy_list' => 'make',
				],
			]
		);

		$this->add_control(
			'model',
			[ 
				'label'       => esc_html__( 'Taxonomy ', 'tf-car-listing' ) . get_option('custom_name_model', 'model'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'model' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy_list' => 'model'
				]
			]
		);

		$this->add_control(
			'body',
			[ 
				'label'       => esc_html__( 'Taxonomy ', 'tf-car-listing' ) . get_option('custom_name_body', 'body'),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'body' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy_list' => 'body'
				]
			]
		);

		$this->add_control(
			'taxonomy_spacing',
			[ 
				'label'      => esc_html__( 'Spacing', 'themesflat-elementor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 
					'px' => [ 
						'min'  => 0,
						'max'  => 300,
						'step' => 1,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .tf-listing-wrap .filter-bar' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'taxonomy_tabs_align',
			[ 
				'label'       => esc_html__( 'Taxonomy Tabs Alignment', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => true,
				'options'     => [ 
					'flex-start' => [ 
						'title' => esc_html__( 'Left', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [ 
						'title' => esc_html__( 'Center', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [ 
						'title' => esc_html__( 'Right', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'flex-start',
				'toggle'      => true,
				'condition'   => [ 
					'taxonomy_tabs' => 'yes',
				],
			]
		);

		
		$this->add_responsive_control(
			'margin_tab_tax',
			[
				'label' => esc_html__( 'Margin', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .filter-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [ 
					'taxonomy_tabs' => 'yes',
				],
			]
		);	

		$this->end_controls_section();
		// /.End Taxonomy Tabs

		// Start Taxonomy Tabs
		$this->start_controls_section(
			'section_budget_tabs',
			[ 
				'label' => esc_html__( 'Price Budget Tabs', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'taxonomy_budget',
			[ 
				'label'        => esc_html__( 'Price Budget Tabs', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_responsive_control(
			'budget_tabs_align',
			[ 
				'label'       => esc_html__( 'Budget Tabs Alignment', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::CHOOSE,
				'label_block' => true,
				'options'     => [ 
					'flex-start' => [ 
						'title' => esc_html__( 'Left', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [ 
						'title' => esc_html__( 'Center', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [ 
						'title' => esc_html__( 'Right', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'flex-start',
				'toggle'      => true,
				'condition'   => [ 
					'taxonomy_budget' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'margin_tab_budget',
			[
				'label' => esc_html__( 'Margin', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .filter-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [ 
					'taxonomy_budget' => 'yes',
				],
			]
		);	

		$this->add_control(
			'price_prefix',
			[
				'label' => esc_html__( 'Price Prefix', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::TEXT,					
				'default' => esc_html__( '$', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'price_suffix',
			[
				'label' => esc_html__( 'Price Siffix', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::TEXT,					
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'price_min',
			[ 
				'label'          => esc_html__( 'Price Min', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '20000',
			]
		);

		$repeater->add_control(
			'price_max',
			[ 
				'label'          => esc_html__( 'Price Max', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '50000',
			]
		);

		$this->add_control( 
			'price_list',
			[					
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 
						'price_min' => '20000',
						'price_max' => '50000',
					],
					[ 
						'price_min' => '50000',
						'price_max' => '70000',
					],
					[ 
						'price_min' => '70000',
						'price_max' => '90000',
					],
					[ 
						'price_min' => '90000',
						'price_max' => '120000',
					],
				],					
			]
		);

		$this->end_controls_section();
		// /.End Taxonomy Tabs

		// Start Carousel        
		$this->start_controls_section(
			'section_listing_carousel',
			[ 
				'label' => esc_html__( 'Carousel', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'carousel',
			[ 
				'label'        => esc_html__( 'Carousel', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'carousel_column_desk',
			[ 
				'label'     => esc_html__( 'Columns Desktop', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [ 
					'1' => esc_html__( '1', 'tf-car-listing' ),
					'2' => esc_html__( '2', 'tf-car-listing' ),
					'3' => esc_html__( '3', 'tf-car-listing' ),
					'4' => esc_html__( '4', 'tf-car-listing' ),
				],
				'condition' => [ 
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_column_laptop',
			[ 
				'label'     => esc_html__( 'Columns Laptop', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [ 
					'1' => esc_html__( '1', 'tf-car-listing' ),
					'2' => esc_html__( '2', 'tf-car-listing' ),
					'3' => esc_html__( '3', 'tf-car-listing' ),
					'4' => esc_html__( '4', 'tf-car-listing' ),
				],
				'condition' => [ 
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_column_tablet',
			[ 
				'label'     => esc_html__( 'Columns Tablet', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [ 
					'1' => esc_html__( '1', 'tf-car-listing' ),
					'2' => esc_html__( '2', 'tf-car-listing' ),
					'3' => esc_html__( '3', 'tf-car-listing' ),
				],
				'condition' => [ 
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_column_mobile',
			[ 
				'label'     => esc_html__( 'Columns Mobile', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [ 
					'1' => esc_html__( '1', 'tf-car-listing' ),
					'2' => esc_html__( '2', 'tf-car-listing' ),
				],
				'condition' => [ 
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_loop',
			[ 
				'label'        => esc_html__( 'Loop', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'carousel_arrow',
			[ 
				'label'        => esc_html__( 'Arrow', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 
					'carousel' => 'yes',
				],
				'separator'    => 'before',
			]
		);

		$this->add_responsive_control( 
			'button_vetical',
			[
				'label' => esc_html__( 'Button Arrow Vertical', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .tf-listing-wrap.has-carousel .owl-carousel .owl-nav button' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'carousel_arrow' => 'yes',
				],
			]
		);

		$this->add_responsive_control( 
			'button_left',
			[
				'label' => esc_html__( 'Button Arrow Left', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-listing-wrap.has-carousel .owl-carousel .owl-nav .owl-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'carousel_arrow' => 'yes',
				],
			]
		);

		$this->add_responsive_control( 
			'button_right',
			[
				'label' => esc_html__( 'Button Arrow Right', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .tf-listing-wrap.has-carousel .owl-carousel .owl-nav .owl-next' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'carousel_arrow' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_bullet',
			[ 
				'label'        => esc_html__( 'Bullet', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 
					'carousel' => 'yes',
				],
				'separator'    => 'before',
			]
		);

		$this->add_responsive_control(
			'bullet_position_horizon',
			[
				'label' => esc_html__( 'Bullet Horizon Position', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-listing-wrap .owl-carousel .owl-dots' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 
					'carousel_bullet' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'bullet_position_vertical',
			[
				'label' => esc_html__( 'Bullet Vertical Position', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-listing-wrap .owl-carousel .owl-dots' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 
					'carousel_bullet' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		// .End Carousel	

		// Start Flex Slider        
		$this->start_controls_section(
			'section_listing_swiper',
			[ 
				'label'     => esc_html__( 'Swiper Image Box', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'swiper_image_box',
			[ 
				'label'        => esc_html__( 'Swiper', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'limit_swiper_images',
			[ 
				'label'     => esc_html__( 'Limit Swiper Images', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 3,
				'condition' => [ 
					'swiper_image_box' => 'yes',
				]
			]
		);

		$this->end_controls_section();
		// .End Flex Slider	

	}

	protected function render( $instance = [] ) {

		$settings       = $this->get_settings_for_display();
		$has_carousel   = '';
		$overlay        = '';
		$taxonomy_query = array();
		if ( $settings['carousel'] == 'yes' ) {
			$has_carousel = 'has-carousel';
		}

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		$query_args = array(
			'post_type'      => 'listing',
			'post_status'    => 'publish',
			'posts_per_page' => $settings['listing_per_page'],
			'paged'          => $paged
		);

		if ( ! empty( $settings['condition'] ) ) {
			$taxonomy_query[] = array(
				'taxonomy' => 'condition',
				'field'    => 'slug',
				'terms'    => $settings['condition']
			);
		}

		if ( ! empty( $settings['make'] ) ) {
			$taxonomy_query[] = array(
				'taxonomy' => 'make',
				'field'    => 'slug',
				'terms'    => $settings['make']
			);
		}

		if ( ! empty( $settings['model'] ) ) {
			$taxonomy_query[] = array(
				'taxonomy' => 'model',
				'field'    => 'slug',
				'terms'    => $settings['model']
			);
		}

		if ( ! empty( $settings['body'] ) ) {
			$taxonomy_query[] = array(
				'taxonomy' => 'body',
				'field'    => 'slug',
				'terms'    => $settings['body']
			);
		}

		if ( count( $taxonomy_query ) > 0 ) {
			$query_args['tax_query'] = array(
				'relation' => 'OR',
				$taxonomy_query
			);
		}

		if ( ! empty( $settings['exclude'] ) ) {
			if ( ! is_array( $settings['exclude'] ) )
				$exclude = explode( ',', $settings['exclude'] );

			$query_args['post__not_in'] = $exclude;
		}

		$query_args['orderby'] = $settings['order_by'];
		$query_args['order']   = $settings['order'];

		if ( $settings['sort_by_id'] != '' ) {
			$sort_by_id             = array_map( 'trim', explode( ',', $settings['sort_by_id'] ) );
			$query_args['post__in'] = $sort_by_id;
			$query_args['orderby']  = 'post__in';
		}

		$query = new WP_Query( $query_args );

		/* Taxonomy Tabs */
		$show_filter_tabs = '';
		if ( $settings['taxonomy_tabs'] == 'yes' || $settings['taxonomy_budget'] == 'yes' ) {
			$show_filter_tabs = 'show_filter_tabs';
		}

		/* Style & Layout */
		$style_layout = '';
		if ( $settings['style'] == 'style1' ) {
			$style_layout = $settings['style_grid'];
		} else {
			$style_layout = $settings['style_list'];
		}

		$has_swiper = 'no-swiper';

		if ( $settings['swiper_image_box'] == 'yes' ) {
			wp_enqueue_style( 'swiper-min-style' );
			wp_enqueue_script( 'swiper-min-script' );
			$has_swiper = 'has-swiper';
		} else {
			$has_swiper = 'no-swiper';
		}

		$this->add_render_attribute( 'tf_listing_wrap', [ 'id' => "tf-listing-{$this->get_id()}", 'class' => [ 'tf-listing-wrap', 'themesflat-listing-taxonomy', $settings['style'], $has_carousel, $show_filter_tabs, $style_layout, $has_swiper ], 'data-tabid' => $this->get_id() ] );

		if ( $query->have_posts() ) : ?>

			<div <?php echo $this->get_render_attribute_string( 'tf_listing_wrap' ); ?>>
				<div class="wrap-listing-post <?php echo esc_attr( $settings['layout'] ); ?> carousel-desktop-col-<?php echo esc_attr( $settings['carousel_column_desk'] ); ?>"
					data-listing-per-page = "<?php echo $settings['listing_per_page']?>"
					data-taxonomy-list = "<?php echo $settings['taxonomy_list']?>"
					data-carousel = "<?php echo $settings['carousel']?>"
					data-show-year = "<?php echo $settings['show_year']?>"
					data-enable-compare-listing = "<?php echo $settings['enable_compare_listing']?>"
					data-enable-favorite-listing = "<?php echo $settings['enable_favorite_listing']?>"
					data-limit-swiper-images = "<?php echo $settings['limit_swiper_images']?>"
					data-show-mileages = "<?php echo $settings['show_mileages']?>"
					data-show-type_fuel = "<?php echo $settings['show_type_fuel']?>"
					data-show-transmission = "<?php echo $settings['show_transmission']?>"
					data-show-make = "<?php echo $settings['show_make']?>"
					data-show-model = "<?php echo $settings['show_model']?>"
					data-show-body = "<?php echo $settings['show_body']?>"
					data-show-stock-number = "<?php echo $settings['show_stock_number']?>"
					data-show-vin-number = "<?php echo $settings['show_vin_number']?>"
					data-show-drive-type = "<?php echo $settings['show_drive_type']?>"
					data-show-engine-size = "<?php echo $settings['show_engine_size']?>"
					data-show-cylinders = "<?php echo $settings['show_cylinders']?>"
					data-show-door = "<?php echo $settings['show_door']?>"
					data-show-color = "<?php echo $settings['show_color']?>"
					data-show-seat = "<?php echo $settings['show_seat']?>"
					data-show-city-mpg = "<?php echo $settings['show_city_mpg']?>"
					data-show-highway-mpg = "<?php echo $settings['show_highway_mpg']?>"
					data-button-text = "<?php echo $settings['button_text']?>"
					data-order-by = "<?php echo $settings['order_by']?>"
					data-order = "<?php echo $settings['order']?>"
					data-style = "<?php echo $settings['style']?>"
					data-swiper-image-box = "<?php echo $settings['swiper_image_box']?>"
					
					>
					<?php if ( $settings['taxonomy_tabs'] == 'yes' ) {
						$taxonomy_selected = $settings['taxonomy_list'];
						$taxonomies        = $settings[ $taxonomy_selected ];
						echo '<div class="filter-bar '.$settings['taxonomy_tabs_align']. $settings['budget_tabs_align'].'"> <a class="filter-listing filter-listing-ajax active" data-slug="all" data-tooltip="' . esc_html__( 'All Cars', 'tf-car-listing' ) . '">' . esc_html__( 'All Cars', 'tf-car-listing' ) . '</a>';
						if ( is_array( $taxonomies ) ) {
							foreach ( $taxonomies as $key => $tax ) {
								$term = get_term_by( 'slug', $tax, $taxonomy_selected );
								if ( $term ) {
									$args_tab_tax          = array(
										'post_type'      => 'listing',
										'post_status'    => 'publish',
										'posts_per_page' => $settings['listing_per_page'],
										'tax_query'      => array(
											array(
												'taxonomy' => $taxonomy_selected,
												'field'    => 'slug',
												'terms'    => $term->slug
											)
										),
									);
									$query_listing_tab_tax = new WP_Query( $args_tab_tax );
									?>
									<a class="filter-listing filter-listing-ajax" data-slug="<?php echo esc_attr( $term->slug ) ?>"
										data-tooltip="<?php echo sprintf( esc_html( '%s ' . tfcl_get_number_text( $query_listing_tab_tax->found_posts, 'listing', 'listing' ), 'tf-car-listing' ), $query_listing_tab_tax->found_posts ); ?>"><?php echo esc_html( $term->name ); ?></a>
									<?php
								}
							}
						}
						echo '</div>';
					} ?>

					<?php if ( $settings['taxonomy_budget'] == 'yes' ) :?>
						<?php echo '<div class="filter-bar filter-listing-ajax'.$settings['taxonomy_tabs_align']. $settings['budget_tabs_align'].'"> <a class="filter-listing filter-listing-ajax active" data-slug="all" data-tooltip="' . esc_html__( 'All Cars', 'tf-car-listing' ) . '">' . esc_html__( 'All Cars', 'tf-car-listing' ) . '</a>'; ?>
								<?php foreach ( $settings['price_list'] as $key => $price ):?>
									<a class="filter-listing  filter-listing-ajax" data-slug="<?php echo esc_attr( $key ) ?>" data-price-min="<?php echo $price['price_min'] ?>" data-price-max="<?php echo $price['price_max'] ?>">
											<?php echo sprintf( '<span>%3$s%1$s%4$s</span> <span>%3$s%2$s%4$s</span>' ,$price['price_min'], $price['price_max'], $settings['price_prefix'], $settings['price_suffix']); ?>
										</a>
								<?php endforeach; ?>
						<?php echo '</div>'; ?>
					<?php endif; ?>


					<div class="content-tab">
						<div class="content-tab-inner tab-inner-all">
							<div class="listing row">
								<?php if ( $settings['carousel'] == 'yes' ) : ?>
									<div class="owl-carousel <?php echo esc_attr( $overlay ); ?>"
										data-loop="<?php echo esc_attr( $settings['carousel_loop'] ) ?>" data-auto="false"
										data-column="<?php echo esc_attr( $settings['carousel_column_desk'] ); ?>"
										data-column2="<?php echo esc_attr( $settings['carousel_column_tablet'] ); ?>"
										data-column3="<?php echo esc_attr( $settings['carousel_column_mobile'] ); ?>"
										data-column4="<?php echo esc_attr( $settings['carousel_column_laptop'] ); ?>" data-arrow="<?php echo esc_attr( $settings['carousel_arrow'] ) ?>"
										data-prev_icon="icon-autodeal-angle-left" data-next_icon="icon-autodeal-angle-right" data-spacing="30"
										data-bullets="<?php echo esc_attr( $settings['carousel_bullet'] ) ?>">
								<?php endif; ?>
									<?php while ( $query->have_posts() ) :
										$query->the_post(); ?>
										<?php
										$attr['settings'] = $settings;
										tf_get_template_widget_elementor( "templates/listing/{$settings['style']}", $attr );
										?>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								<?php if ( $settings['carousel'] == 'yes' ) : ?>
									</div>
								<?php endif; ?>
							</div>
						</div>



					</div>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
			<?php
		else :
			esc_html_e( 'No listing found', 'tf-car-listing' );
		endif;
	}
}