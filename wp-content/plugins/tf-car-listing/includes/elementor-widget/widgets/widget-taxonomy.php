<?php
class Widget_Taxonomy extends \Elementor\Widget_Base {
	public function get_name() {
		return 'tf_taxonomy';
	}

	public function get_title() {
		return esc_html__( 'TF Listing Type', 'tf-car-listing' );
	}

	public function get_categories() {
		return [ 'themesflat_car_listing_addons' ];
	}

	public function get_style_depends() {
		return [ 'owl-carousel', 'listing-taxonomy-style' ];
	}

	public function get_script_depends() {
		return [ 'owl-carousel', 'taxonomy-script' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_taxonomy_settings',
			[ 
				'label' => esc_html__( 'Settings', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'item_per_page',
			[ 
				'label'   => esc_html__( 'Items Per Page', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '4',
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
					'style3' => esc_html__( 'Style car body 3 column', 'tf-car-listing' ),
					'style4' => esc_html__( 'Style body with icon', 'tf-car-listing' ),
					'style5' => esc_html__( 'Style Text', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'order_by',
			[ 
				'label'   => esc_html__( 'Order By', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'term_id',
				'options' => [ 
					'term_id' => esc_html__( 'ID', 'tf-car-listing' ),
					'name'    => esc_html__( 'Name', 'tf-car-listing' ),
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
			'taxonomy',
			[ 
				'label'   => esc_html__( 'Taxonomy', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'make',
				'options' => [ 
					'make'  => esc_html__( get_option('custom_name_make'), 'tf-car-listing' ),
					'model' => esc_html__( get_option('custom_name_model'), 'tf-car-listing' ),
					'body'  => esc_html__( get_option('custom_name_body'), 'tf-car-listing' )
				],
			]
		);

		$this->add_control(
			'taxonomy_render_image',
			[ 
				'label'   => esc_html__( 'Image/Icon Show', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [ 
					'image'  => esc_html__( 'Image', 'tf-car-listing' ),
					'icon' => esc_html__( 'Icon', 'tf-car-listing' ),
				],
				'condition'   => [ 
					'taxonomy' => "body",
				],
			]
		);

		$this->add_control(
			'icon_tax_color',
			[ 
				'label'     => esc_html__( 'Icon Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-taxonomy-wrap .image-wrap svg *' => 'fill: {{VALUE}}',
				],
				'condition'   => [ 
					'taxonomy_render_image' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_tax_gap',
			[ 
				'label'          => esc_html__( 'Gap Item', 'tf-car-listing' ),
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
					'{{WRAPPER}} .tf-taxonomy-wrap.style4 .tf-taxonomy-inner' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [ 
					'taxonomy_render_image' => 'icon',
					'style' => 'style4',
				],
			]
		);

		$this->add_control(
			'text_tax_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-taxonomy-wrap.style4 .image-wrap' => 'color: {{VALUE}} !important',
				],
				'condition'   => [ 
					'taxonomy_render_image' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[ 
				'label'          => esc_html__( 'Image Height', 'tf-car-listing' ),
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
					'{{WRAPPER}} .tf-taxonomy-wrap .item .taxonomy-post .feature-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'taxonomy_make',
			[ 
				'label'       => esc_html__( get_option('custom_name_make'), 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'make' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy' => "make",
				],
			]
		);

		$this->add_control(
			'taxonomy_model',
			[ 
				'label'       => esc_html__( get_option('custom_name_model'), 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'model' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy' => "model",
				],
			]
		);

		$this->add_control(
			'taxonomy_body',
			[ 
				'label'       => esc_html__( get_option('custom_name_body'), 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => tfcl_get_taxonomies( 'body' ),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'taxonomy' => "body",
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
					'column-5' => esc_html__( '5', 'tf-car-listing' ),
					'column-6' => esc_html__( '6', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'layout_tablet',
			[ 
				'label'   => esc_html__( 'Columns Tablet', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'column-tablet-3',
				'options' => [ 
					'column-tablet-1' => esc_html__( '1', 'tf-car-listing' ),
					'column-tablet-2' => esc_html__( '2', 'tf-car-listing' ),
					'column-tablet-3' => esc_html__( '3', 'tf-car-listing' ),
					'column-tablet-4' => esc_html__( '4', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'layout_mobile',
			[ 
				'label'   => esc_html__( 'Columns Mobile', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'column-mobile-1',
				'options' => [ 
					'column-mobile-1' => esc_html__( '1', 'tf-car-listing' ),
					'column-mobile-2' => esc_html__( '2', 'tf-car-listing' ),
					'column-mobile-3' => esc_html__( '3', 'tf-car-listing' ),
					'column-mobile-4' => esc_html__( '4', 'tf-car-listing' )
				],
			]
		);
		$this->end_controls_section();

		// Start Carousel        
		$this->start_controls_section(
			'section_areas_carousel',
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
				'default'   => '3',
				'options'   => [ 
					'1' => esc_html__( '1', 'tf-car-listing' ),
					'2' => esc_html__( '2', 'tf-car-listing' ),
					'3' => esc_html__( '3', 'tf-car-listing' ),
					'4' => esc_html__( '4', 'tf-car-listing' ),
					'5' => esc_html__( '5', 'tf-car-listing' ),
					'6' => esc_html__( '6', 'tf-car-listing' ),
					'7' => esc_html__( '7', 'tf-car-listing' ),
					'8' => esc_html__( '8', 'tf-car-listing' ),
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
				'default'   => '3',
				'options'   => [ 
					'1' => esc_html__( '1', 'tf-car-listing' ),
					'2' => esc_html__( '2', 'tf-car-listing' ),
					'3' => esc_html__( '3', 'tf-car-listing' ),
					'4' => esc_html__( '4', 'tf-car-listing' ),
					'5' => esc_html__( '5', 'tf-car-listing' ),
					'6' => esc_html__( '6', 'tf-car-listing' ),
					'7' => esc_html__( '7', 'tf-car-listing' ),
					'8' => esc_html__( '8', 'tf-car-listing' ),
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
					'4' => esc_html__( '4', 'tf-car-listing' ),
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
				'label'        => esc_html__( 'Item Loop', 'tf-car-listing' ),
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

		$this->add_control(
			'carousel_center',
			[ 
				'label'        => esc_html__( 'Item Active Center', 'tf-car-listing' ),
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

		$this->add_control(
			'carousel_arrow',
			[ 
				'label'        => esc_html__( 'Arrow', 'tf-car-listing' ),
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
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .tf-taxonomy-wrap.has-carousel .owl-prev, {{WRAPPER}} .tf-taxonomy-wrap.has-carousel .owl-next' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 
					'carousel' => 'yes',
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
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .tf-taxonomy-wrap.has-carousel .owl-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 
					'carousel' => 'yes',
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
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .tf-taxonomy-wrap.has-carousel .owl-right' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 
					'carousel' => 'yes',
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
			'bullet_vertical',
			[
				'label' => esc_html__( 'Bullet Vertical Position', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-taxonomy-wrap .owl-dots' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [ 
					'carousel' => 'yes',
					'carousel_bullet' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_spacing',
			[ 
				'label'   => esc_html__( 'Spacing', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '30',
			]
		);
		$this->end_controls_section();
		// /.End Carousel	

		$this->start_controls_section(
			'style_section',
			[ 
				'label' => esc_html__( 'General', 'tf-car-listing' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'general_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'tf-car-listing' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [ 
					'{{WRAPPER}} .tf-taxonomy-wrap.tf-taxonomy .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'general_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'tf-car-listing' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [ 
					'{{WRAPPER}} .tf-taxonomy-wrap .box-card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'general_boder_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'tf-car-listing' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'selectors'  => [ 
					'{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[ 
				'label' => esc_html__( 'Normal', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'border_color_normal',
			[ 
				'label'     => esc_html__( 'Border Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-taxonomy:not(.style2) .item .taxonomy-post, {{WRAPPER}} .tf-taxonomy-wrap.style2 .feature-image' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bg_color_normal',
			[ 
				'label'     => esc_html__( 'Background Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-taxonomy:not(.style2) .item .taxonomy-post, {{WRAPPER}} .tf-taxonomy-wrap.style2 .feature-image' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'text_color_normal',
			[ 
				'label'     => esc_html__( 'Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-taxonomy .item .taxonomy-post h3.name a,{{WRAPPER}} .tf-taxonomy .item .taxonomy-post .count-listing' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			[ 
				'label' => esc_html__( 'Hover', 'tf-car-listing' ),
			]
		);
		$this->add_control(
			'bg_color_hover',
			[ 
				'label'     => esc_html__( 'Background Color', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tf-taxonomy .item:hover .taxonomy-post, {{WRAPPER}} .tf-taxonomy-wrap.style2 .item:hover .feature-image' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			[ 
				'label' => esc_html__( 'Content', 'tf-car-listing' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'h_name',
			[ 
				'label'     => esc_html__( 'Name', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => esc_html__( 'Typography', 'tf-car-listing' ),
				'selector' => '{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post .name, {{WRAPPER}} .tf-taxonomy-wrap.style4 .image-wrap',
			]
		);

		$this->add_control( 
			'name_color',
			[
				'label' => esc_html__( 'Color', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post .name a, {{WRAPPER}} .tf-taxonomy-wrap.style4 .image-wrap, {{WRAPPER}} .tf-taxonomy-wrap.style5 .tf-taxonomy-inner *' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control( 
			'name_margin',
			[
				'label' => esc_html__( 'Margin', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post .name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'h_count',
			[ 
				'label'     => esc_html__( 'Count', 'tf-car-listing' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'count_typography',
				'label' => esc_html__( 'Typography', 'tf-car-listing' ),
				'selector' => '{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post .count-property',
			]
		);

		$this->add_control( 
			'count_color',
			[
				'label' => esc_html__( 'Color', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post .count-property' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control( 
			'count_margin',
			[
				'label' => esc_html__( 'Margin', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-taxonomy-wrap .taxonomy-post .count-property' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$has_carousel = '';
		if ( $settings['carousel'] == 'yes' ) {
			$has_carousel = 'has-carousel';
		}

		$css_class = '';
		if ( ! empty( $settings['taxonomy'] ) ) {
			$css_class = 'tf-taxonomy-' . $settings['taxonomy'] . ' ';
		}
		if ( ! empty( $settings['layout_mobile'] ) ) {
			$css_class .= $settings['layout_mobile'] . ' ';
		}

		if ( ! empty( $settings['layout_tablet'] ) ) {
			$css_class .= $settings['layout_tablet'];
		}

		$this->add_render_attribute( 'tf_taxonomy_wrap', [ 'id' => "tf-taxonomy-{$this->get_id()}", 'class' => [ 'tf-taxonomy-wrap', 'tf-taxonomy', $css_class, $settings['style'], $has_carousel ], 'data-tabid' => $this->get_id() ] );

		$query_args = array(
			'taxonomy'   => $settings['taxonomy'],
			'number'     => $settings['item_per_page'],
			'hide_empty' => false,
			'count'      => true,
		);

		if ( ! empty( $settings['taxonomy_make'] ) ) {
			$query_args['slug'] = $settings['taxonomy_make'];
		}

		if ( ! empty( $settings['taxonomy_body'] ) ) {
			$query_args['slug'] = $settings['taxonomy_body'];
		}

		if ( ! empty( $settings['exclude'] ) ) {
			if ( ! is_array( $settings['exclude'] ) )
				$exclude = explode( ',', $settings['exclude'] );

			$query_args['exclude'] = $exclude;
		}

		$query_args['orderby'] = $settings['order_by'];
		$query_args['order']   = $settings['order'];

		if ( $settings['sort_by_id'] != '' ) {
			$sort_by_id            = array_map( 'trim', explode( ',', $settings['sort_by_id'] ) );
			$query_args['include'] = $sort_by_id;
			$query_args['orderby'] = 'include';
			$query_args['order']   = 'ASC';
		}

		$taxonomies = get_terms( $query_args );

		if ( ! empty( $taxonomies ) && ! is_wp_error( $taxonomies ) ) : ?>
			<div <?php echo $this->get_render_attribute_string( 'tf_taxonomy_wrap' ); ?>>
				<div class="tf-taxonomy-inner row <?php echo esc_attr( $settings['layout'] ); ?>">
					<?php if ( $settings['style'] == 'style5' ) : ?>
						<div class="text-trend">
							<i class="icon-autodeal-icon-88"></i>
							<?php echo esc_html( 'Trending:', 'tf-car-listing' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( $settings['carousel'] == 'yes' ) : ?>
						<div class="owl-carousel"
							data-arrow="<?php echo esc_attr( $settings['carousel_arrow'] ) ?>"
							data-loop="<?php echo esc_attr( $settings['carousel_loop'] ) ?>"
							data-center="<?php echo esc_attr( $settings['carousel_center'] ) ?>"
							data-bullets="<?php echo esc_attr( $settings['carousel_bullet'] ) ?>"
							data-column="<?php echo esc_attr( isset( $settings['carousel_column_desk'] ) ? $settings['carousel_column_desk'] : ' ' ); ?>"
							data-column1="<?php echo esc_attr( isset( $settings['carousel_column_laptop'] ) ? $settings['carousel_column_laptop'] : ' ' ); ?>"
							data-column2="<?php echo esc_attr( isset( $settings['carousel_column_tablet'] ) ? $settings['carousel_column_tablet'] : ' ' ); ?>"
							data-column3="<?php echo esc_attr( isset( $settings['carousel_column_mobile'] ) ? $settings['carousel_column_mobile'] : ' ' ); ?>"
							data-prev_icon="icon-autodeal-angle-left" data-next_icon="icon-autodeal-angle-right"
							data-spacing="<?php echo esc_attr( isset( $settings['carousel_spacing'] ) ? $settings['carousel_spacing'] : '' ); ?>">
						<?php endif; ?>

						<?php foreach ( $taxonomies as $taxonomy ) : ?>
							<?php
							$attr['settings'] = $settings;
							$attr['taxonomy'] = $taxonomy;
							tfcl_get_template_widget_elementor( "templates/taxonomy/{$settings['style']}", $attr );
							?>
						<?php endforeach; ?>

						<?php if ( $settings['carousel'] == 'yes' ) : ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php else :
			esc_html_e( 'No item found', 'tf-car-listing' );
		endif;
	}
}