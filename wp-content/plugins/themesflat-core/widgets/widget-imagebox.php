<?php
class TFImageBox_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tfimagebox';
    }
    
    public function get_title() {
        return esc_html__( 'TF Image Box', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-image-box';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-imagebox'];
	}


	protected function _register_controls() {
        // Start Icon Box Setting        
			$this->start_controls_section( 
				'section_tfimagebox',
	            [
	                'label' => esc_html__('Image Box', 'themesflat-core'),
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
				'label' => esc_html__( 'Content', 'themesflat-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		); 

		$this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Background Color', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox' => 'background: {{VALUE}};',
                ]
            ]
        );	

		$this->add_responsive_control( 
			'padding_general',
			[
				'label' => esc_html__( 'Padding', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-imagebox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .tf-imagebox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);  
		
        $this->add_control(
            'heading_image',
            [
                'label' => esc_html__( 'Image', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,					
                'separator' => 'before',
            ]
        );	

        $this->add_control( 
			'image_width',
			[
				'label' => esc_html__( 'Width', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-imagebox .wrap-image ' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control( 
			'image_height',
			[
				'label' => esc_html__( 'Height', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-imagebox .wrap-image img' => 'height: {{SIZE}}{{UNIT}};    object-fit: cover;    width: 100%;',
				],
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
                'selector' => '{{WRAPPER}} .tf-imagebox .content .title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .title, {{WRAPPER}} .tf-imagebox .content .title a' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .tf-imagebox .content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .tf-imagebox .content .description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__( 'Color', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .description' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .tf-imagebox .content .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .tf-imagebox .content .tf-button-container a',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Color', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .tf-button-container a' => 'color: {{VALUE}};',
                ]
            ]
        );	

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .tf-button-container a' => 'background: {{VALUE}};',
                ]
            ]
        );	

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__( 'Border Color', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .tf-button-container a' => 'border-color: {{VALUE}};',
                ]
            ]
        );	

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__( 'Color Hover', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .tf-button-container a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );	

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__( 'Background Color Hover', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .tf-button-container a:hover' => 'background: {{VALUE}};',
                ]
            ]
        );	

        $this->add_control(
            'border_color_hover',
            [
                'label' => esc_html__( 'Border Color Hover', 'themesflat-core' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tf-imagebox .content .tf-button-container a:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );	


		$this->end_controls_section();
        // /.End General 

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
			$image = sprintf( '<img src="%1s" width="210" height="171" alt="image">',$url);
		}

		?>
			<div class="tf-imagebox">
				<div class="wrap-image">
					<?php echo $image; ?>
				</div>
				<div class="content">
						<h3 class="title"><?php echo esc_attr($settings['title_text']); ?></h3>
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
			</div>
		<?php
	}	

}