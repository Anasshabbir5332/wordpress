<?php
class Widget_Advanced_Search extends \Elementor\Widget_Base {
	protected $fields_search_advanced;
	protected $fields_search_top_default;
	protected $fields_search_budget_default;
	protected $fields_search_brand_default;
	protected $fields_search_bottom_default;
	protected $fields_search_mobile_default;

	public function get_name() {
		return 'tf_search';
	}

	public function get_title() {
		return esc_html__( 'TF Search', 'tf-car-listing' );
	}

	public function get_icon() {
		return ' eicon-search';
	}

	public function get_categories() {
		return [ 'themesflat_car_listing_addons' ];
	}

	public function get_style_depends() {
		return [ 'search-style' ];
	}

	public function get_script_depends() {
		return [ 'search-script' ];
	}

	protected function register_controls() {

		$this->fields_search_advanced = array(
			'listing-make'         => esc_html__( get_option('custom_name_make') ),
			'listing-model'        => esc_html__( get_option('custom_name_model') ),
			'listing-keyword'      => esc_html__( 'Keyword', 'tf-car-listing' ),
			'listing-price'        => esc_html__( 'Price', 'tf-car-listing' ),
			'listing-fuel-type'    => esc_html__( get_option('custom_name_fuel_type'),  ),
			'listing-transmission' => esc_html__( get_option('custom_name_transmission'),  ),
			'listing-driver-type'  => esc_html__( get_option('custom_name_drive_type'),  ),
			'listing-mileage'      => esc_html__( get_option('custom_name_mileage') ),
			'listing-door'         => esc_html__( get_option('custom_name_door') ),
			'listing-year'         => esc_html__( get_option('custom_name_year') ),
			'listing-body'         => esc_html__( get_option('custom_name_body'),  ),
			'listing-color'        => esc_html__( get_option('custom_name_color'),  ),
			'listing-cylinder'     => esc_html__( get_option('custom_name_cylinders'),  ),
			'listing-engine-size'     => esc_html__( get_option('custom_name_engine_size') ),
			'listing-featured'     => esc_html__( 'Featured', 'tf-car-listing' ),
			'listing-features'     => esc_html__( get_option('custom_name_features') ),
		);

		$this->fields_search_top_default = array(
			'listing-make',
			'listing-model',
			'listing-door',
			'listing-body',
		);

		$this->fields_search_budget_default = array(
			'listing-price',
			'listing-year',
		);

		$this->fields_search_brand_default = array(
			'listing-model',
			'listing-body',
		);

		$this->fields_search_bottom_default = array(
			'listing-fuel-type',
			'listing-transmission',
			'listing-driver-type',
			'listing-mileage',
			'listing-cylinder',
			'listing-color',
			'listing-year',
			'listing-featured',
			'listing-features'
		);

		$this->fields_search_mobile_default = array(
			'listing-fuel-type',
			'listing-transmission',
			'listing-driver-type',
			'listing-body',
			'listing-cylinder',
			'listing-color',
			'listing-year',
			'listing-featured',
			'listing-features'
		);

		// start setting

		$this->start_controls_section(
			'section_search_settings',
			[ 
				'label' => esc_html__( 'Settings', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'search_advanced_top',
			[ 
				'label'       => esc_html__( 'Advanced Search Fields Main', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->fields_search_advanced,
				'label_block' => true,
				'multiple'    => true,
				'default'     => $this->fields_search_top_default,
			]
		);

		$this->add_control(
			'search_advanced_top_budget',
			[ 
				'label'       => esc_html__( 'Advanced Search Fields Budget', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->fields_search_advanced,
				'label_block' => true,
				'multiple'    => true,
				'default'     => $this->fields_search_budget_default,
				'condition'   => [ 
					'style' => 'style4'
				]
			]
		);

		$this->add_control(
			'search_advanced_top_brand',
			[ 
				'label'       => esc_html__( 'Advanced Search Fields Brand', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->fields_search_advanced,
				'label_block' => true,
				'multiple'    => true,
				'default'     => $this->fields_search_brand_default,
				'condition'   => [ 
					'style' => 'style4'
				]
			]
		);

		$this->add_control(
			'search_advanced_bottom',
			[ 
				'label'       => esc_html__( 'Advanced Search Fields Bottom', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->fields_search_advanced,
				'label_block' => true,
				'multiple'    => true,
				'default'     => $this->fields_search_bottom_default,
			]
		);

		$this->add_control(
			'search_advanced_mobile',
			[ 
				'label'       => esc_html__( 'Advanced Search Fields Mobile', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->fields_search_advanced,
				'label_block' => true,
				'multiple'    => true,
				'default'     => $this->fields_search_mobile_default,
			]
		);

		$this->add_control(
			'style',
			[ 
				'label'   => esc_html__( 'Styles', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [ 
					'style1' => esc_html__( 'Style 1', 'tf-car-listing' ),
					'style2' => esc_html__( 'Style 2', 'tf-car-listing' ),
					'style3' => esc_html__( 'Style 3', 'tf-car-listing' ),
					'style4' => esc_html__( 'Style 4', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'text_heading',
			[
				'label' => esc_html__( 'Text Heading Style 4', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::TEXT,					
				'default' => esc_html__( 'Find your right car', 'tf-car-listing' ),
				'label_block' => true,
				'condition'   => [ 
					'style' => 'style4'
				]
			]
		);

		$this->add_control(
			'show_status',
			[ 
				'label'        => esc_html__( 'Show Status ', 'tf-car-listing' ) . get_option('custom_name_condition', 'condition'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_filter',
			[ 
				'label'        => esc_html__( 'Show Advanced Search Desktop', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_filter_mobile',
			[ 
				'label'        => esc_html__( 'Show Advanced Search Mobile', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'text_button',
			[
				'label' => esc_html__( 'Text Button Search', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::TEXT,					
				'default' => esc_html__( 'Find cars', 'tf-car-listing' ),
				'label_block' => true,
			]
		);


		$this->end_controls_section();

		// start tab style
		$this->start_controls_section(
			'style_section',
			[ 
				'label' => esc_html__( 'General', 'tf-car-listing' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'h_condition_tab',
			[ 
				'label'     => esc_html__( 'Condition Tab', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'condition_align',
			[ 
				'label'     => esc_html__( 'Alignment', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [ 
					'left'   => [ 
						'title' => esc_html__( 'Left', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [ 
						'title' => esc_html__( 'Center', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [ 
						'title' => esc_html__( 'Right', 'tf-car-listing' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => [ 
					'{{WRAPPER}} .tf-search-condition-tab' => 'justify-content:{{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs(
			'style_search_tabs'
		);

		$this->start_controls_tab(
			'style_search_normal_tab',
			[ 
				'label' => esc_html__( 'Normal', 'tf-car-listing' ),
			]
		);
		$this->add_control(
			'color_search_tab_normal',
			[ 
				'label'     => esc_html__( 'Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-search-condition-tab a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color_search_tab_normal',
			[ 
				'label'     => esc_html__( 'Background Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-search-condition-tab a' => 'background: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_search_active_tab',
			[ 
				'label' => esc_html__( 'active', 'tf-car-listing' ),
			]
		);
		$this->add_control(
			'color_search_tab_active',
			[ 
				'label'     => esc_html__( 'Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-search-condition-tab a.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color_search_tab_active',
			[ 
				'label'     => esc_html__( 'Background Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-search-condition-tab a.active, {{WRAPPER}} .tf-search-condition-tab a.active::after, {{WRAPPER}} .tf-search-condition-tab a:hover' => 'background: {{VALUE}}; border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'h_search_form',
			[ 
				'label'     => esc_html__( 'Search Form', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_form_boder_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'tf-car-listing' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [ 
					'{{WRAPPER}} .tf-search-wrap .search-form-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'search_form_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
				'selector' => '{{WRAPPER}} .tf-search-wrap .search-form-content',
			]
		);

		$this->add_control(
			'background_color_search_form',
			[ 
				'label'     => esc_html__( 'Background Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-search-wrap.style1 .search-form-content' => 'background: {{VALUE}};',
				],

			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'tf_search_wrap', [ 'id' => "tf-search-{$this->get_id()}", 'class' => [ 'tf-search-wrap style1', $settings['style'] ], 'data-tabid' => $this->get_id() ] );
		?>
		<div <?php echo $this->get_render_attribute_string( 'tf_search_wrap' ) ?>>
			<div class="form-search-wrap">
				<div class="form-search-inner">
					<?php
					$attr['settings'] = $settings;
					tfcl_get_template_widget_elementor( "templates/search/{$settings['style']}", $attr );
					?>
				</div>
			</div>
		</div>
		<?php
	}
}
?>