<?php
class TFIconBox_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tficonbox';
    }
    
    public function get_title() {
        return esc_html__( 'TF Icon Box', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-icon-box';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-iconbox'];
	}


	protected function _register_controls() {
        // Start Icon Box Setting        
			$this->start_controls_section( 
				'section_tficonbox',
	            [
	                'label' => esc_html__('Icon Box', 'themesflat-core'),
	            ]
	        );

			$this->add_control(
				'style',
				[
					'label' => esc_html__( 'Style', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'style1',
					'options' => [
						'style1'  => esc_html__( 'Style1', 'themesflat-core' ),
						'style2'  => esc_html__( 'Style 2', 'themesflat-core' ),
						'style3'  => esc_html__( 'Style 3', 'themesflat-core' ),
					],
				]
			);

			$this->add_control(
				'icon_style',
				[
					'label' => esc_html__( 'Icon Style', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'none' => [
							'title' => esc_html__( 'None', 'themesflat-core' ),
							'icon' => 'fa fa-ban',
						],
						'icon' => [
							'title' => esc_html__( 'Icon', 'themesflat-core' ),
							'icon' => 'fa fa-paint-brush',
						],
						'image' => [
							'title' => esc_html__( 'Image', 'themesflat-core' ),
							'icon' => 'eicon-image',
						],
					],
					'default' => 'icon',
					'toggle' => false,
				]
			);

			$this->add_control(
				'icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'icon-autodeal-car',
						'library' => 'theme_icon',
					],
					'condition' => [
						'icon_style' => 'icon',
					],
				]
			);

			$this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_THEME."assets/img/placeholder.jpg",
					],
					'condition' => [
						'icon_style' => 'image',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'include' => [],
					'default' => 'large',
				]
			);	

			$this->add_control(
				'title_text',
				[
					'label' => esc_html__( 'Title', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'label_block' => true,
					'default' => esc_html__( 'Trusted Car Dealership', 'themesflat-core' ),
				]
			);

			$this->add_control(
				'description_text',
				[
					'label' => 'Description',
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consect adipiscing elit.', 'themesflat-core' ),
				]
			);		

			$this->add_control(
				'position',
				[
					'label' => esc_html__( 'Icon Position', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'default' => 'top',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'themesflat-core' ),
							'icon' => 'eicon-h-align-left',
						],
						'top' => [
							'title' => esc_html__( 'Top', 'themesflat-core' ),
							'icon' => 'eicon-v-align-top',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'themesflat-core' ),
							'icon' => 'eicon-h-align-right',
						],
					],
				]
			);
			
	        $this->end_controls_section();
        // /.End Icon Box Setting

		// Start Read More        
		$this->start_controls_section( 
			'section_button',
			[
				'label' => esc_html__('Read More', 'themesflat-core'),
			]
		);
		$this->add_control(
			'show_button',
			[
				'label' => esc_html__( 'Show Button', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themesflat-core' ),
				'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control( 
			'icon_button',
			[
				'label' => esc_html__( 'Icon Button', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon_bt',
				'default' => [
					'value' => 'icon-autodeal-icon-86',
					'library' => 'theme_icon',
				],				
			]
		);
		$this->add_control( 
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'themesflat-core' ),
				'condition' => [
					'show_button'	=> 'yes',
				],
			]
		);
		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-core' ),
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => [
					'show_button' => 'yes'
				]
			]
		);
		$this->end_controls_section();
	// /.End Read More	    


		// Start General
		$this->start_controls_section( 
			'section_style_general',
			[
				'label' => esc_html__( 'General', 'themesflat-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		); 

		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themesflat-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'themesflat-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themesflat-core' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'themesflat-core' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tficonbox' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control( 
			'padding_general',
			[
				'label' => esc_html__( 'Padding', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tficonbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],					
			]
		);	

		$this->add_responsive_control( 
			'margin_general',
			[
				'label' => esc_html__( 'Margin', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tficonbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);  

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'general_border',
				'label' => esc_html__( 'Border', 'themesflat-core' ),
				'selector' => '{{WRAPPER}} .tficonbox',
			]
		);

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'general_shadow',	                
			'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
			'selector' => '{{WRAPPER}} .tficonbox',
		]
	);

	$this->add_control( 
		'general_background_hover',
		[
			'label' => esc_html__( 'Background Color', 'themesflat-core' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tficonbox' => 'background: {{VALUE}};',
			],
		]
	);

		$this->end_controls_section();
        // /.End General 

		// Start Image Style 
		$this->start_controls_section( 
			'section_style_image',
			[
				'label' => esc_html__( 'image', 'themesflat-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon_style' => 'image',
				],
			]
		);

		$this->add_control( 
			'image_size_height',
			[
				'label' => esc_html__( 'Width', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tficonbox .wrap-image img ' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control( 
			'image_padding',
			[
				'label' => esc_html__( 'Padding', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tficonbox .wrap-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control( 
			'image_margin',
			[
				'label' => esc_html__( 'Margin', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tficonbox .wrap-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
        // /.End Image

	    // Start Icon Style 
		    $this->start_controls_section( 
		    	'section_style_icon',
	            [
	                'label' => esc_html__( 'Icon', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	                'condition' => [
						'icon_style' => 'icon',
					],
	            ]
	        ); 

	        $this->add_control(
				'icon_showcase',
				[
					'label' => esc_html__( 'Type', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'themesflat-core' ),
						'circle' => esc_html__( 'Circle', 'themesflat-core' ),
						'square' => esc_html__( 'Square', 'themesflat-core' ),
						'circle-outline' => esc_html__( 'Circle Outline', 'themesflat-core' ),
						'square-outline' => esc_html__( 'Square Outline', 'themesflat-core' ),
					],
					'default' => 'default',
					'condition' => [
						'icon[value]!' => '',
					],
				]
			);

	        $this->add_control( 
	        	'icon_size',
				[
					'label' => esc_html__( 'Size', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tficonbox .wrap-icon-inner svg,{{WRAPPER}} .tficonbox .wrap-icon-inner img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control( 
	        	'wrap_icon_size',
				[
					'label' => esc_html__( 'Wrap Icon Size', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 100,
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tficonbox .wrap-icon.square .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square-outline .wrap-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'icon_showcase!' => 'default'
					],
				]
			);

			$this->add_control(
				'rotate',
				[
					'label' => esc_html__( 'Rotate', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);

			$this->add_control(
				'rotate_icon',
				[
					'label' => esc_html__( 'Rotate Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner i, {{WRAPPER}} .tficonbox .wrap-icon-inner svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
						'{{WRAPPER}} .tficonbox .wrap-icon-inner img' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);

			$this->add_control(
				'icon_border_width',
				[
					'label' => esc_html__( 'Border Width', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 20,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 3,
					],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner' => 'border-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'width: calc(100% + 2 * {{SIZE}}{{UNIT}}); height: calc(100% + 2 * {{SIZE}}{{UNIT}}); border-width: {{SIZE}}{{UNIT}}; top: -{{SIZE}}{{UNIT}}; left: -{{SIZE}}{{UNIT}};',

					],
					'condition' => [
						'icon_showcase' => array('circle-outline','square-outline')
					],
				]
			);

			$this->add_control(
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'icon_showcase!' => 'default',
					],
				]
			);

			$this->add_responsive_control(
				'icon_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .wrap-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( 'icon_tabs' );				

				$this->start_controls_tab( 
					'icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'themesflat-core' ),						
					]
				);

				$this->add_control( 
					'icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tficonbox .wrap-icon-inner *, {{WRAPPER}} .tficonbox .wrap-icon-inner svg' => 'color: {{VALUE}}; fill: {{VALUE}}',
							'{{WRAPPER}} .tficonbox .wrap-icon .wrap-icon-inner svg path' => 'stroke: {{VALUE}};',
							'{{WRAPPER}} .tficonbox .wrap-icon .wrap-icon-inner svg path.fill' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'icon_background',
						'label' => esc_html__( 'Background', 'themesflat-core' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tficonbox .wrap-icon.circle .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before',
						'condition' => [
							'icon_showcase' => ['circle','square']
						]
					]
				);

				$this->add_control( 
					'border_icon_color',
					[
						'label' => esc_html__( 'Border Color', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .tficonbox .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-color: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);

				$this->add_control(
					'border_style_icon',
					[
						'label' => esc_html__( 'Border Type', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'solid' => esc_html__( 'Solid', 'themesflat-core' ),
							'double' => esc_html__( 'Double', 'themesflat-core' ),
							'dotted' => esc_html__( 'Dotted', 'themesflat-core' ),
							'dashed' => esc_html__( 'Dashed', 'themesflat-core' ),
							'groove' => esc_html__( 'Groove', 'themesflat-core' ),
						],
						'selectors' => [
							'{{WRAPPER}} .tficonbox .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-style: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);	

				$this->end_controls_tab();

				$this->start_controls_tab( 
			    	'icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'themesflat-core' ),
					]
				);

				$this->add_control( 
					'icon_color_hover',
					[
						'label' => esc_html__( 'Icon Color', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tficonbox:hover .wrap-icon-inner *' => 'color: {{VALUE}}; fill: {{VALUE}}',
							'{{WRAPPER}} .tficonbox:hover .wrap-icon .wrap-icon-inner svg path' => 'stroke: {{VALUE}};',
							'{{WRAPPER}} .tficonbox:hover .wrap-icon .wrap-icon-inner svg path.fill' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'icon_background_hover',
						'label' => esc_html__( 'Background', 'themesflat-core' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .tficonbox:hover .wrap-icon.circle .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon.square .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon-spin-around:before',
						'condition' => [
							'icon_showcase' => ['circle','square']
						]
					]
				);				

				$this->add_control( 
					'border_icon_color_hover',
					[
						'label' => esc_html__( 'Border Color', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .tficonbox:hover .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon-spin-around:before' => 'border-color: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);	

				$this->add_control(
					'border_style_icon_hover',
					[
						'label' => esc_html__( 'Border Type', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => 'solid',
						'options' => [
							'solid' => esc_html__( 'Solid', 'themesflat-core' ),
							'double' => esc_html__( 'Double', 'themesflat-core' ),
							'dotted' => esc_html__( 'Dotted', 'themesflat-core' ),
							'dashed' => esc_html__( 'Dashed', 'themesflat-core' ),
							'groove' => esc_html__( 'Groove', 'themesflat-core' ),
						],
						'selectors' => [
							'{{WRAPPER}} .tficonbox:hover .wrap-icon.circle-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox:hover .wrap-icon.square-outline .wrap-icon-inner, {{WRAPPER}} .tficonbox .wrap-icon-spin-around:before' => 'border-style: {{VALUE}}',
						],
						'condition' => [
							'icon_showcase' => ['circle-outline','square-outline']
						]
					]
				);

				$this->end_controls_tab();

	        $this->end_controls_tabs();

		    $this->end_controls_section();
	    // /.End Icon Style

	    // Start Content Style 
		    $this->start_controls_section( 
		    	'section_style_content',
	            [
	                'label' => esc_html__( 'Content', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );  

			$this->add_control(
				'heading_title',
				[
					'label' => esc_html__( 'Title', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,					
					'separator' => 'before',
				]
			);		

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .tficonbox .content .title',
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .title, {{WRAPPER}} .tficonbox .content .title a' => 'color: {{VALUE}};',
					],
				]
			);	

			$this->add_control(
				'title_tag',
				[
					'label' => esc_html__( 'Title Tag', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'h3',
					'options' => [
						'h1'  => esc_html__( 'H1', 'themesflat-core' ),
						'h2'  => esc_html__( 'H2', 'themesflat-core' ),
						'h3'  => esc_html__( 'H3', 'themesflat-core' ),
						'h4'  => esc_html__( 'H4', 'themesflat-core' ),
						'h5'  => esc_html__( 'H5', 'themesflat-core' ),
						'h6'  => esc_html__( 'H6', 'themesflat-core' ),
					],
				]
			);

			$this->add_control(
				'title_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'heading_description',
				[
					'label' => esc_html__( 'Description', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,					
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'selector' => '{{WRAPPER}} .tficonbox .content .description',
				]
			);

			$this->add_control(
				'description_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .description' => 'color: {{VALUE}};',
					]
				]
			);		 
			
			$this->add_responsive_control( 
				'desc_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'heading_button',
				[
					'label' => esc_html__( 'Button', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,					
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .tficonbox .content .tf-button-container a',
				]
			);

			$this->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .tf-button-container a' => 'color: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'button_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .tf-button-container a' => 'background: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'border_color',
				[
					'label' => esc_html__( 'Border Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .tf-button-container a' => 'border-color: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'button_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .tf-button-container a:hover' => 'color: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'button_bg_color_hover',
				[
					'label' => esc_html__( 'Background Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .tf-button-container a:hover' => 'background: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'border_color_hover',
				[
					'label' => esc_html__( 'Border Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tficonbox .content .tf-button-container a:hover' => 'border-color: {{VALUE}};',
					]
				]
			);	

		    $this->end_controls_section();
    	// /.End Content Style

	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		if (!empty($settings['link'])) {
			$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
		}

		if (!empty($settings['link'])) {
			$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
		}


		$migrated = isset( $settings['__fa4_migrated']['icon_button'] );	
		$is_new = empty( $settings['icon_bt'] );

		if ($settings['image'] != '') {
			$url = esc_attr($settings['image']['url']);
			$image = sprintf( '<img src="%1s" alt="image">',$url);
		}

		?>
			<div class="tficonbox <?php echo esc_attr($settings['position']); ?> <?php echo esc_attr($settings['style']); ?>">
				<?php if ($settings['style'] == 'style3'): ?>
						<div class="inner">
							<?php if ($settings['icon_style'] == 'icon'): ?>
								<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
									<div class="wrap-icon-inner  <?php echo esc_attr($settings['icon_style']); ?> ">
										<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</div>
								</div>
							<?php elseif($settings['icon_style'] == 'image'): ?>
								<div class="wrap-image">
									<?php echo $image; ?>
								</div>
							<?php endif; ?>
							<<?php echo esc_attr($settings['title_tag']);?> class="title"><?php echo esc_attr($settings['title_text']); ?></<?php echo esc_attr($settings['title_tag']);?>>
						</div>
						<div class="content">
								<?php echo sprintf('<div class="description">%s</div>', $settings['description_text']); ?>
							<?php if (  $settings['button_text'] != '' ) : ?>
								<div class="tf-button-container">
									<a href="<?php echo esc_url( $settings['link']['url'] ) ?>" class="tf-button" <?php echo $target; echo $nofollow; ?>>
										<span><?php echo esc_attr( $settings['button_text'] ); ?></span>
										<?php echo \Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					<?php else: ?>
						<?php if ($settings['icon_style'] == 'icon'): ?>
							<div class="wrap-icon <?php echo esc_attr($settings['icon_showcase']); ?>">
								<div class="wrap-icon-inner  <?php echo esc_attr($settings['icon_style']); ?> ">
									<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</div>
							</div>
						<?php elseif($settings['icon_style'] == 'image'): ?>
							<div class="wrap-image">
								<?php echo $image; ?>
							</div>
						<?php endif; ?>
	
						<div class="content">
								<<?php echo esc_attr($settings['title_tag']);?> class="title"><?php echo esc_attr($settings['title_text']); ?></<?php echo esc_attr($settings['title_tag']);?>>
								<?php echo sprintf('<div class="description">%s</div>', $settings['description_text']); ?>
							<?php if (  $settings['button_text'] != '' ) : ?>
								<div class="tf-button-container">
									<a href="<?php echo esc_url( $settings['link']['url'] ) ?>" class="tf-button" <?php echo $target; echo $nofollow; ?>>
										<span><?php echo esc_attr( $settings['button_text'] ); ?></span>
										<?php echo \Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $settings['icon_button'], [ 'aria-hidden' => 'true' ] ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
				<?php endif; ?>
			</div>
		<?php
	}	

}