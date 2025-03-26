<?php
class TFTabs_Widget_Free extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tftabs';
    }
    
    public function get_title() {
        return esc_html__( 'TF Tabs', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-tab'];
	}
	public function get_script_depends() {
		return ['tf-tab'];
	}

	protected function register_controls() {
        // Start Tab Setting        
			$this->start_controls_section( 'section_tabs',
	            [
	                'label' => esc_html__('Tabs', 'themesflat-core'),
	            ]
	        );	 
	        $this->add_control( 'show_icon',
				[
					'label' => esc_html__( 'Show Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);       
	        $repeater = new \Elementor\Repeater();
	        $repeater->add_control( 'set_active',
				[
					'label' => esc_html__( 'Set Active Tab', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'themesflat-core' ),
					'label_off' => esc_html__( 'No', 'themesflat-core' ),
					'return_value' => 'set-active-tab',
					'default' => 'inactive',
				]
			);
	        $repeater->add_control( 'heading_icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);
			$repeater->add_control( 'icon_style',
				[
					'label' => esc_html__( 'Icon Style', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'icon' => [
							'title' => esc_html__( 'Icon', 'themesflat-core' ),
							'icon' => 'eicon-favorite',
						],
						'image' => [
							'title' => esc_html__( 'Image', 'themesflat-core' ),
							'icon' => 'eicon-image',
						],
					],
					'default' => 'icon',
				]
			);			
			$repeater->add_control( 'icon_tabs',
				[
					'label' => esc_html__( 'Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_tab',
					'default' => [
						'value' => 'fas fa-user',
						'library' => 'fa-solid',
					],
					'condition' => [
                        'icon_style' => 'icon',
                    ],
				]
			);
			$repeater->add_control( 'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'condition' => [
                        'icon_style' => 'image',
                    ],
				]
			);			
			$repeater->add_control( 'heading_title',
				[
					'label' => esc_html__( 'Nav', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
	        $repeater->add_control( 'list_title', [
					'label' => esc_html__( 'Nav text', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Tab' , 'themesflat-core' ),
					'label_block' => true,
				]
			);
			$repeater->add_control( 'heading_content',
				[
					'label' => esc_html__( 'Content', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$repeater->add_control( 'list_content_text_type',
				[
					'label' => esc_html__( 'Content type', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'editor',
					'options' => [
						'editor'  => esc_html__( 'Editor', 'themesflat-core' ),
						'template' => esc_html__( 'Template', 'themesflat-core' ),
					],
				]
			);	
			$repeater->add_control( 'list_content', [
					'label' => esc_html__( 'Content text', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi utaliquip commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.' , 'themesflat-core' ),
					'label_block' => true,
					'condition' => [
                        'list_content_text_type' => 'editor',
                    ],
				]
			);
			$repeater->add_control( 'list_content_template',
				[
					'label' => esc_html__( 'Choose Template', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => ThemesFlat_Addon_For_Elementor_autodeal::tf_get_template_elementor(),
					'condition' => [
                        'list_content_text_type' => 'template',
                    ],
				]
			);
	        $this->add_control( 'tab_list',
				[					
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Tab 1', 'themesflat-core' ),
							'list_content' => esc_html__( 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi utaliquip commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.', 'themesflat-core' ),
						],
						[
							'list_title' => esc_html__( 'Tab 2', 'themesflat-core' ),
							'list_content' => esc_html__( 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi utaliquip commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.', 'themesflat-core' ),
						],
						[
							'list_title' => esc_html__( 'Tab 3', 'themesflat-core' ),
							'list_content' => esc_html__( 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi utaliquip commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit ess cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.', 'themesflat-core' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
				]
			);
			$this->add_control( 'hr_tab_type',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
			$this->add_control( 'tab_type',
				[
					'label' => esc_html__( 'Type', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal'  => esc_html__( 'Horizontal', 'themesflat-core' ),
						'vertical' => esc_html__( 'Vertical', 'themesflat-core' ),
					],
				]
			);	
			$this->end_controls_section();
        // /.End Tab Setting 

	    // Start Style Icon
	        $this->start_controls_section( 'section_style_icon',
	            [
	                'label' => esc_html__( 'Tab Icon', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control( 'icon_position',
				[
					'label' => esc_html__( 'Position', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'default' => 'icon-position-left',
					'options' => [
						'icon-position-left' => [
							'title' => esc_html__( 'Left', 'themesflat-core' ),
							'icon' => 'eicon-h-align-left',
						],
						'icon-position-top' => [
							'title' => esc_html__( 'Top', 'themesflat-core' ),
							'icon' => 'eicon-v-align-top',
						],
						'icon-position-right' => [
							'title' => esc_html__( 'Right', 'themesflat-core' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'toggle' => false,
				]
			);

	        $this->add_responsive_control( 'icon_size',
				[
					'label' => esc_html__( 'Size', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 0.5,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li img, {{WRAPPER}} .tf-tabs .tf-tabnav ul > li svg' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control( 'icon_gap',
				[
					'label' => esc_html__( 'Gap', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .tf-tabs.icon-position-left .tf-tabnav ul > li img, {{WRAPPER}} .tf-tabs.icon-position-left .tf-tabnav ul > li svg, {{WRAPPER}} .tf-tabs.icon-position-left .tf-tabnav ul > li i' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-tabs.icon-position-top .tf-tabnav ul > li img, {{WRAPPER}} .tf-tabs.icon-position-top .tf-tabnav ul > li svg, {{WRAPPER}} .tf-tabs.icon-position-top .tf-tabnav ul > li i' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-tabs.icon-position-right .tf-tabnav ul > li img, {{WRAPPER}} .tf-tabs.icon-position-right .tf-tabnav ul > li svg, {{WRAPPER}} .tf-tabs.icon-position-right .tf-tabnav ul > li i' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);			
	        
	        $this->end_controls_section();    
	    // /.End Style Icon 

	    // Start Style Title
	        $this->start_controls_section( 'section_style_title',
	            [
	                'label' => esc_html__( 'Tab Nav', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control( 'heading_wrap_nav',
				[
					'label' => esc_html__( 'Wrap Nav', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

			$this->add_responsive_control( 'nav_align',
				[
					'label' => esc_html__( 'Alignment', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'default' => 'nav-justify',
					'toggle' => false,
					'options' => [
						'nav-left'    => [
							'title' => esc_html__( 'Left', 'themesflat-core' ),
							'icon' => 'eicon-text-align-left',
						],
						'nav-center' => [
							'title' => esc_html__( 'Center', 'themesflat-core' ),
							'icon' => 'eicon-text-align-center',
						],
						'nav-right' => [
							'title' => esc_html__( 'Right', 'themesflat-core' ),
							'icon' => 'eicon-text-align-right',
						],
						'nav-justify' => [
							'title' => esc_html__( 'Justified', 'themesflat-core' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'condition' => [
                        'tab_type' => 'horizontal',
                    ],
				]
			);									

			$this->add_responsive_control( 'wrap_nav_padding',
	            [
	                'label' => esc_html__( 'Padding', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs  .tf-tabnav ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );	

	        $this->add_responsive_control( 'wrap_nav_margin',
	            [
	                'label' => esc_html__( 'Margin', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs  .tf-tabnav' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_control( 'wrap_nav_background',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .tf-tabs .tf-tabnav ul' => 'background-color: {{VALUE}}',
					],
				]
			);        

	        $this->add_control( 'heading_nav',
				[
					'label' => esc_html__( 'Item Nav', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);				

	        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li .tab-title-text',
				]
			);

			$this->add_responsive_control( 'title_padding',
	            [
	                'label' => esc_html__( 'Padding', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );			

	        $this->add_responsive_control( 'title_margin',
	            [
	                'label' => esc_html__( 'Margin', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],	                
	            ]
	        );

	        $this->add_control( 'title_hover_animation',
				[
					'label' => esc_html__( 'Hover Animation', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,	
				]
			);

	        $this->start_controls_tabs( 'title_style_tabs' );
	        	$this->start_controls_tab( 'title_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'themesflat-core' ),
					]
					);	        		
			        $this->add_control( 'title_color',
						[
							'label' => esc_html__( 'Color Text', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li .tab-title-text' => 'color: {{VALUE}}',
							],
						]
					);
					$this->add_group_control( \Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'title_background_color',
							'label' => esc_html__( 'Background Type', 'themesflat-core' ),
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li',
						]
					);
					$this->add_group_control( \Elementor\Group_Control_Border::get_type(),
			            [
			                'name' => 'title_border',
			                'label' => esc_html__( 'Border', 'themesflat-core' ),
			                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li',
			            ]
			        );
			        $this->add_responsive_control( 'title_border_radius',
			            [
			                'label' => esc_html__('Border Radius', 'themesflat-core'),
			                'type' => \Elementor\Controls_Manager::DIMENSIONS,
			                'size_units' => ['px', 'em', '%'],
			                'selectors' => [
			                    '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                ],
			            ]
			        );
			        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(),
			            [
			                'name' => 'title_shadow',	                
			                'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
			                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li',
			            ]
			        );
			        $this->add_control( 'heading_icon_normal',
						[
							'label' => esc_html__( 'Icon', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::HEADING,
						]
					);
					$this->add_control( 'icon_color',
						[
							'label' => esc_html__( 'Color', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li i' => 'color: {{VALUE}}',
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li svg' => 'fill: {{VALUE}};',
							],
						]
					);

				$this->end_controls_tab();
				$this->start_controls_tab( 'title_style_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'themesflat-core' ),
					]
					);
					$this->add_control( 'title_color_hover',
						[
							'label' => esc_html__( 'Color Text', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover .tab-title-text' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control( \Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'title_background_color_hover',
							'label' => esc_html__( 'Background Type', 'themesflat-core' ),
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover',
						]
					);
					$this->add_group_control( \Elementor\Group_Control_Border::get_type(),
			            [
			                'name' => 'title_border_hover',
			                'label' => esc_html__( 'Border', 'themesflat-core' ),
			                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover',
			            ]
			        );
			        $this->add_responsive_control( 'title_border_radius_hover',
			            [
			                'label' => esc_html__('Border Radius', 'themesflat-core'),
			                'type' => \Elementor\Controls_Manager::DIMENSIONS,
			                'size_units' => ['px', 'em', '%'],
			                'selectors' => [
			                    '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                ],
			            ]
			        );
			        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(),
			            [
			                'name' => 'title_shadow_hover',	                
			                'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
			                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover',
			            ]
			        );
			        $this->add_control( 'heading_icon_hover',
						[
							'label' => esc_html__( 'Icon', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::HEADING,
						]
					);
					$this->add_control( 'icon_color_hover',
						[
							'label' => esc_html__( 'Color', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover i' => 'color: {{VALUE}};',
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li:hover svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab( 'title_style_active_tab',
					[
						'label' => esc_html__( 'Active', 'themesflat-core' ),
					]
					);
					$this->add_control( 'title_color_active',
						[
							'label' => esc_html__( 'Color Text', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active .tab-title-text' => 'color: {{VALUE}};',
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab .tab-title-text' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control( \Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'title_background_color_active',
							'label' => esc_html__( 'Background Type', 'themesflat-core' ),
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active, {{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab',
						]
					);
					$this->add_group_control( \Elementor\Group_Control_Border::get_type(),
			            [
			                'name' => 'title_border_active',
			                'label' => esc_html__( 'Border', 'themesflat-core' ),
			                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active, {{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab',
			            ]
			        );
			        $this->add_responsive_control( 'title_border_radius_active',
			            [
			                'label' => esc_html__('Border Radius', 'themesflat-core'),
			                'type' => \Elementor\Controls_Manager::DIMENSIONS,
			                'size_units' => ['px', 'em', '%'],
			                'selectors' => [
			                    '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                    '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                ],
			            ]
			        );
			        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(),
			            [
			                'name' => 'title_shadow_active',	                
			                'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
			                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active, {{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab',
			            ]
			        );
			        $this->add_control( 'heading_icon_active',
						[
							'label' => esc_html__( 'Icon', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::HEADING,
						]
					);
					$this->add_control( 'icon_color_active',
						[
							'label' => esc_html__( 'Color', 'themesflat-core' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active i' => 'color: {{VALUE}};',
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.active svg' => 'fill: {{VALUE}};',
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab i' => 'color: {{VALUE}};',
								'{{WRAPPER}} .tf-tabs .tf-tabnav ul > li.set-active-tab svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
	        
	        $this->end_controls_section();    
	    // /.End Style Title 

	    // Start Tab Style Content 
	        $this->start_controls_section( 'section_style_content',
	            [
	                'label' => esc_html__( 'Tab Content', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-tabs .tf-tabcontent',
				]
			);

			$this->add_control( 'content_color',
				[
					'label' => esc_html__( 'Color Text', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-tabs .tf-tabcontent' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control( \Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'content_background_color',
					'label' => esc_html__( 'Background Type', 'themesflat-core' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .tf-tabs .tf-tabcontent',
				]
			);

			$this->add_responsive_control( 'content_padding',
	            [
	                'label' => esc_html__( 'Padding', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs .tf-tabcontent' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_responsive_control( 'content_margin',
	            [
	                'label' => esc_html__( 'Margin', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs .tf-tabcontent' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_group_control( \Elementor\Group_Control_Border::get_type(),
	            [
	                'name' => 'content_border',
	                'label' => esc_html__( 'Border', 'themesflat-core' ),
	                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabcontent',
	            ]
	        );
	        
	        $this->add_responsive_control( 'content_border_radius',
	            [
	                'label' => esc_html__('Border Radius', 'themesflat-core'),
	                'type' => \Elementor\Controls_Manager::DIMENSIONS,
	                'size_units' => ['px', 'em', '%'],
	                'selectors' => [
	                    '{{WRAPPER}} .tf-tabs .tf-tabcontent' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	                ],
	            ]
	        );

	        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(),
	            [
	                'name' => 'content_shadow',	                
	                'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
	                'selector' => '{{WRAPPER}} .tf-tabs .tf-tabcontent',	                
	            ]
	        );

			$this->add_control( 'content_entrance_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'label_block' => true,
					'default' => 'fadeIn',
					'options' => [
						'none' => esc_html__( 'None', 'themesflat-core' ),
						'fadeIn'  => esc_html__( 'Fade In', 'themesflat-core' ),						
						'fadeInDown' => esc_html__( 'Fade In Down', 'themesflat-core' ),
						'fadeInLeft' => esc_html__( 'Fade In Left', 'themesflat-core' ),
						'fadeInRight' => esc_html__( 'Fade In Right', 'themesflat-core' ),
						'fadeInUp' => esc_html__( 'Fade In Up', 'themesflat-core' ),
						'zoomIn'  => esc_html__( 'Zoom In', 'themesflat-core' ),						
						'zoomInDown' => esc_html__( 'Zoom In Down', 'themesflat-core' ),
						'zoomInLeft' => esc_html__( 'Zoom In Left', 'themesflat-core' ),
						'zoomInRight' => esc_html__( 'Zoom In Right', 'themesflat-core' ),
						'zoomInUp' => esc_html__( 'Zoom In Up', 'themesflat-core' ),
						'bounceIn'  => esc_html__( 'Bounce In', 'themesflat-core' ),						
						'bounceInDown' => esc_html__( 'Bounce In Down', 'themesflat-core' ),
						'bounceInLeft' => esc_html__( 'Bounce In Left', 'themesflat-core' ),
						'bounceInRight' => esc_html__( 'Bounce In Right', 'themesflat-core' ),
						'bounceInUp' => esc_html__( 'Bounce In Up', 'themesflat-core' ),
						'slideInDown' => esc_html__( 'Slide In Down', 'themesflat-core' ),
						'slideInLeft' => esc_html__( 'Slide In Left', 'themesflat-core' ),
						'slideInRight' => esc_html__( 'Slide In Right', 'themesflat-core' ),
						'slideInUp' => esc_html__( 'Slide In Up', 'themesflat-core' ),
						'rotateIn'  		=> esc_html__( 'Rotate In', 'themesflat-core' ),						
						'rotateInDownLeft' 	=> esc_html__( 'Rotate In Down Left', 'themesflat-core' ),
						'rotateInDownRight' => esc_html__( 'Rotate In Down Right', 'themesflat-core' ),
						'rotateInUpLeft' 	=> esc_html__( 'Rotate In Up Left', 'themesflat-core' ),
						'rotateInUpRight' => esc_html__( 'Rotate In Up Right', 'themesflat-core' ),
						'bounce'  => esc_html__( 'Bounce', 'themesflat-core' ),						
						'flash' => esc_html__( 'Flash', 'themesflat-core' ),
						'pulse' => esc_html__( 'Pulse', 'themesflat-core' ),
						'rubberBand' => esc_html__( 'Rubber Band', 'themesflat-core' ),
						'shake' => esc_html__( 'Shake', 'themesflat-core' ),
						'headShake'  => esc_html__( 'Head Shake', 'themesflat-core' ),						
						'swing' => esc_html__( 'Swing', 'themesflat-core' ),
						'tada' => esc_html__( 'Tada', 'themesflat-core' ),
						'wobble' => esc_html__( 'Wobble', 'themesflat-core' ),
						'jello' => esc_html__( 'Jello', 'themesflat-core' ),
						'lightSpeedIn' => esc_html__( 'Light Speed In', 'themesflat-core' ),
						'rollIn' => esc_html__( 'Roll In', 'themesflat-core' ),
					],
				]
			);
	        
	        $this->end_controls_section();    
	    // /.End Tab Style Content 

        // Start Tab Style Triger
	        $this->start_controls_section( 'section_style_triger',
	            [
	                'label' => esc_html__( 'Tab Active Triger', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_control(
				'show_triger',
				[
					'label' => esc_html__( 'Show Triger', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);

	        $this->add_control( 'triger_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-tabs.horizontal .tf-tabnav > ul > li.active:after' => 'border-top-color: {{VALUE}}',
						'{{WRAPPER}} .tf-tabs.vertical .tf-tabnav > ul > li.active:after' => 'border-left-color: {{VALUE}};',
						'{{WRAPPER}} .tf-tabs.horizontal .tf-tabnav > ul > li.set-active-tab:after' => 'border-top-color: {{VALUE}}',
						'{{WRAPPER}} .tf-tabs.vertical .tf-tabnav > ul > li.set-active-tab:after' => 'border-left-color: {{VALUE}};',
					],
					'condition' => [
                        'show_triger' => 'yes',
                    ],
				]
			);

			$this->add_responsive_control( 'triger_size',
				[
					'label' => esc_html__( 'Triger Size', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],						
					],
					'condition' => [
                        'show_triger' => 'yes',
                    ],
					'selectors' => [
						'{{WRAPPER}} .tf-tabs.horizontal .tf-tabnav > ul > li.active:after' => 'border-width: {{SIZE}}{{UNIT}}; bottom: -{{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-tabs.vertical .tf-tabnav > ul > li.active:after' => 'border-width: {{SIZE}}{{UNIT}}; right: -{{SIZE}}{{UNIT}}; top: calc(50% - {{SIZE}}{{UNIT}});',
						'{{WRAPPER}} .tf-tabs.horizontal .tf-tabnav > ul > li.set-active-tab:after' => 'border-width: {{SIZE}}{{UNIT}}; bottom: -{{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-tabs.vertical .tf-tabnav > ul > li.set-active-tab:after' => 'border-width: {{SIZE}}{{UNIT}}; right: -{{SIZE}}{{UNIT}}; top: calc(50% - {{SIZE}}{{UNIT}});',
					],
				]
			);

	        $this->end_controls_section();   
	    // /.End Tab Style Triger 
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'tf_tabs_wrapper', ['id' => "tf-tabs-{$this->get_id()}", 'class' => ['tf-tabs', $settings['tab_type'], 'tabs-'.$settings['tab_type'], $settings['icon_position'], 'show-triger-'.$settings['show_triger'], $settings['nav_align'] ], 'data-tabid' => $this->get_id()] );

		$migrated = isset( $settings['__fa4_migrated']['icon_tabs'] );	
		$is_new = empty( $settings['icon_tab'] );

		$count_li = 0;
		$count_content = 0;		
		?>
		<div <?php echo $this->get_render_attribute_string('tf_tabs_wrapper'); ?>>
			<div class="tf-tabnav">
				<ul>
					<?php foreach ($settings['tab_list'] as $tab): $count_li ++;?>
					<li class="tablinks <?php echo esc_attr($tab['set_active']); ?> elementor-animation-<?php echo esc_attr($settings['title_hover_animation']); ?>" data-tab="tab-<?php echo esc_attr($count_li); ?>">	
						<?php if ( $settings['show_icon'] == 'yes' ) {
							echo '<span class="wrap-icon">';
							if ( $tab['icon_style'] == 'image' ) {								
								echo '<img src="' . esc_url($tab['image']['url']) . '" alt="image"/>'; 
							} else {
								if ( $is_new || $migrated ) {
									if ( isset($tab['icon_tabs']['value']['url']) ) {
										\Elementor\Icons_Manager::render_icon( $tab['icon_tabs'], [ 'aria-hidden' => 'true' ] );
									}else {
										echo '<i class="' . esc_attr($tab['icon_tabs']['value']) . '" aria-hidden="true"></i>';
									}									
								} else {
									echo '<i class="' . esc_attr($tab['icon_tab']) . ' aria-hidden="true""></i>';
								}								
							}
							echo '</span>';
						} ?>						
						<?php if ( $tab['list_title'] != '' ) : ?>
							<span class="tab-title-text"><?php echo esc_attr($tab['list_title']); ?></span>
						<?php endif; ?>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="tf-tabcontent">
				<?php foreach ($settings['tab_list'] as $tab): $count_content ++; ?>
				<div id="tab-<?php echo esc_attr($count_content); ?>" class="tf-tabcontent-inner <?php echo esc_attr($tab['set_active']); ?> animated <?php echo esc_attr($settings['content_entrance_animation']); ?>">
					<?php 
					if ( $tab['list_content_text_type'] == 'template' ) {
						if ( !empty($tab['list_content_template']) ) {
				            $post_id = flat_get_post_page_content($tab['list_content_template']);
				            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($post_id);
				        }
					}else {
						echo do_shortcode( $tab['list_content'] ); 
					}

					
				?>

				</div>
				<?php endforeach;?>
			</div>
		</div>
		
		<?php
		
	}

	

}