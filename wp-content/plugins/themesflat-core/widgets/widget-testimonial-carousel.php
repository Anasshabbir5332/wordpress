<?php
class TFTestimonialCarousel_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-testimonial-carousel';
    }
    
    public function get_title() {
        return esc_html__( 'TF Testimonial Carousel', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['owl-carousel','tf-testimonial'];
	}

	public function get_script_depends() {
		return ['owl-carousel','tf-testimonial'];
	}

	protected function register_controls() {
        // Start Carousel Setting        
			$this->start_controls_section( 
				'section_carousel',
	            [
	                'label' => esc_html__('Testimonial Carousel', 'themesflat-core'),
	            ]
	        );

	        $this->add_control(
				'testimonial_style',
				[
					'label' => esc_html__( 'Layout Style', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'style1',
					'options' => [
						'style1'  => esc_html__( 'Style 1', 'themesflat-core' ),
						'style2' => esc_html__( 'Style 2', 'themesflat-core' ),
						'style3' => esc_html__( 'Style 3', 'themesflat-core' ),
					],
				]
			);	    

			$this->add_control(
				'show_hover_cursor',
				[ 
					'label'        => esc_html__( 'Enable Custom Mouse Hover', 'themesflat-core' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Show', 'themesflat-core' ),
					'label_off'    => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default'      => 'no'
				]
			);

			$this->add_control(
				'disable_overflow',
				[ 
					'label'        => esc_html__( 'Disable Overflow Hidden', 'themesflat-core' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Show', 'themesflat-core' ),
					'label_off'    => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default'      => 'no'
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'include' => [],
					'default' => 'full',
				]
			);
			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'avatar',
				[
					'label' => esc_html__( 'Choose Avatar', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_THEME."assets/img/placeholder.jpg",
					],
				]
			);

			$repeater->add_control(
				'name',
				[
					'label' => esc_html__( 'Name', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Eugene Freeman', 'themesflat-core' ),
				]
			);	

			$repeater->add_control(
				'position',
				[
					'label' => esc_html__( 'Position', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Tincidunt', 'themesflat-core' ),
				]
			);

			$repeater->add_control(
				'date',
				[
					'label' => esc_html__( 'Date Published', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( '15 May 2020 9:30 am', 'themesflat-core' ),
				]
			);

			$repeater->add_control(
				'description',
				[
					'label' => esc_html__( 'Description', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'rows' => 10,
					'default' => esc_html__( 'Phasellus ultrices ut tortor at porta. Praesent maximus, lacus sed rutrum aliquet, lacus tellus tincidunt nisl, vitae molestie nisi sapien et dolor suspendisse mi est ', 'themesflat-core' ),
				]
			);

			$repeater->add_control(
				'rating',
				[
					'label' => esc_html__( 'Rating', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '5',
					'options' => [
						'1'  => esc_html__( '1 star', 'themesflat-core' ),
						'2'  => esc_html__( '2 stars', 'themesflat-core' ),
						'3'  => esc_html__( '3 stars', 'themesflat-core' ),
						'4'  => esc_html__( '4 stars', 'themesflat-core' ),
						'5' => esc_html__( '5 stars', 'themesflat-core' ),
					],
				]
			);

			$repeater->add_control(
				'icon_quote',
				[
					'label' => esc_html__( 'Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'icon-autodeal-icon-111',
						'library' => 'theme_icon',
					],
				]
			);

			$this->add_control( 
				'carousel_list',
					[					
						'type' => \Elementor\Controls_Manager::REPEATER,
						'fields' => $repeater->get_controls(),
						'default' => [
							[ 
								'name' => 'Alice Guzman',
								'position' => 'Designer manager',
								'description'=> 'Phasellus ultrices ut tortor at porta. Praesent maximus, lacus sed rutrum aliquet, lacus tellus tincidunt nisl, vitae molestie nisi sapien et dolor suspendisse mi est',
							],
							[ 
								'name' => 'Kelly Coleman',
								'position' => 'Designer manager',
								'description'=> 'Phasellus ultrices ut tortor at porta. Praesent maximus, lacus sed rutrum aliquet, lacus tellus tincidunt nisl, vitae molestie nisi sapien et dolor suspendisse mi est',
							],
							[ 
								'name' => 'Eugene Freeman',
								'position' => 'Designer manager',
								'description'=> 'Phasellus ultrices ut tortor at porta. Praesent maximus, lacus sed rutrum aliquet, lacus tellus tincidunt nisl, vitae molestie nisi sapien et dolor suspendisse mi est',
							],
						],					
					]
				);
				

			
			$this->end_controls_section();
        // /.End Carousel	

        // Start Setting        
			$this->start_controls_section( 
				'section_setting',
	            [
	                'label' => esc_html__('Setting', 'themesflat-core'),
	            ]
	        );	

			$this->add_control( 
	        	'carousel_column_desk',
				[
					'label' => esc_html__( 'Columns Desktop', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '2',
					'options' => [
						'1' => esc_html__( '1', 'themesflat-core' ),
						'2' => esc_html__( '2', 'themesflat-core' ),
						'3' => esc_html__( '3', 'themesflat-core' ),
						'4' => esc_html__( '4', 'themesflat-core' ),
					],				
				]
			);

			$this->add_control( 
	        	'carousel_column_tablet',
				[
					'label' => esc_html__( 'Columns Tablet', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '2',
					'options' => [
						'1' => esc_html__( '1', 'themesflat-core' ),
						'2' => esc_html__( '2', 'themesflat-core' ),
						'3' => esc_html__( '3', 'themesflat-core' ),
					],				
				]
			);

			$this->add_control( 
	        	'carousel_column_mobile',
				[
					'label' => esc_html__( 'Columns Mobile', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( '1', 'themesflat-core' ),
						'2' => esc_html__( '2', 'themesflat-core' ),
					],				
				]
			);

			$this->add_control(
				'spacing_item_carousel',
				[
					'label' => esc_html__( 'Spacing', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'default' => 30,
				]
			);

			$this->add_control( 
				'carousel_loop',
				[
					'label' => esc_html__( 'Loop', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'no',				
					'description'	=> 'Just show when you have two slide',
					'separator' => 'before',
				]
			);

	        $this->end_controls_section();
        // /.End Setting

		// Start bullet        
		$this->start_controls_section( 
			'section_bullet',
			[
				'label' => esc_html__('Bullet', 'themesflat-core'),
			]
		);

		$this->add_control( 
			'carousel_bullet',
			[
				'label' => esc_html__( 'Bullet', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'themesflat-core' ),
				'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
				'return_value' => 'yes',
				'default' => 'no',				
				'description'	=> 'Just show when you have two slide',
				'separator' => 'before',
			]
		);

		$this->add_control( 
			'bullet_vetical',
			[
				'label' => esc_html__( 'Bullet Vertical', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .tf-testimonial-carousel .owl-dots' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control( 
			'Bullet_left',
			[
				'label' => esc_html__( 'Bullet Horizon', 'themesflat-core' ),
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
					'{{WRAPPER}}  .tf-testimonial-carousel .owl-dots' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'general_border_bullet',
				'label' => esc_html__( 'Border', 'themesflat-core' ),
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .owl-carousel .owl-dots .owl-dot',
			]
		);

		$this->add_control( 
			'bullet_bg_color',
			[
				'label' => esc_html__( 'Bullet Background Color', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .owl-carousel .owl-dots .owl-dot' => 'background-color: {{VALUE}};',				
				],
			]
		);

		$this->add_control( 
			'bullet_bg_color_active',
			[
				'label' => esc_html__( 'Bullet Active Background Color', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .owl-carousel .owl-dots .owl-dot.active' => 'background-color: {{VALUE}} !important; border-color: {{VALUE}} !important;',				
				],
			]
		);

		$this->end_controls_section();
        // /.End bullet

		// Start General
		$this->start_controls_section( 
			'section_style_general',
			[
				'label' => esc_html__( 'Style', 'themesflat-core' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		); 

		$this->add_control(
			'heading_avatar',
			[
				'label' => esc_html__( 'Avatar', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,					
				'separator' => 'before',
			]
		);	

		$this->add_control( 
			'image_height',
			[
				'label' => esc_html__( 'Image Size', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .group-author .thumb img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'general_border_image',
				'label' => esc_html__( 'Border', 'themesflat-core' ),
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .group-author .thumb img',
			]
		);

		$this->add_control(
			'heading_content',
			[
				'label' => esc_html__( 'Content', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,					
				'separator' => 'before',
			]
		);	

		$this->add_control( 
			'general_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .item-testimonial' => 'background-color: {{VALUE}}',				
				],
			]
		);

		$this->add_responsive_control( 
			'general_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .item-testimonial' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'general_border_border',
				'label' => esc_html__( 'Border', 'themesflat-core' ),
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .item-testimonial',
			]
		);

		$this->add_group_control( 
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'general_border_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .item-testimonial',
			]
		);

		$this->add_responsive_control( 
			'padding_general',
			[
				'label' => esc_html__( 'Padding', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .item-testimonial' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .tf-testimonial-carousel .item-testimonial' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],					
			]
		);

		$this->add_control(
			'heading_desc',
			[
				'label' => esc_html__( 'Description', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,					
				'separator' => 'before',
			]
		);	

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .description',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .description' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .tf-testimonial-carousel .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_name',
			[
				'label' => esc_html__( 'Name', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,					
				'separator' => 'before',
			]
		);	

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .group-author h6',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Color', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .group-author h6' => 'color: {{VALUE}};',
				],
			]
		);	

		$this->add_control(
			'name_margin',
			[
				'label' => esc_html__( 'Margin', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .group-author h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_position',
			[
				'label' => esc_html__( 'Position', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,					
				'separator' => 'before',
			]
		);	

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'postion_typography',
				'selector' => '{{WRAPPER}} .tf-testimonial-carousel .group-author p',
			]
		);

		$this->add_control(
			'postion_color',
			[
				'label' => esc_html__( 'Color', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .group-author p' => 'color: {{VALUE}};',
				],
			]
		);	

		$this->add_control(
			'postion_margin',
			[
				'label' => esc_html__( 'Margin', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tf-testimonial-carousel .group-author p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
        // /.End General 

	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();
		
		$carousel_arrow = 'no-arrow';

		$custom_cursor = '';
		if ( $settings['show_hover_cursor'] == 'yes' ) {
			$custom_cursor = 'has-custom-cusor';
		}

		$overflow = '';
		if ( $settings['disable_overflow'] == 'yes' ) {
			$overflow = 'disable-overflow';
		}

		?>
		<div class="tf-testimonial-carousel <?php echo esc_attr($custom_cursor);  ?> <?php echo esc_attr($overflow);  ?> <?php echo esc_attr($settings['testimonial_style']); ?>  " data-loop="<?php echo esc_attr($settings['carousel_loop']) ?>" data-auto="false" data-column="<?php echo esc_attr($settings['carousel_column_desk']); ?>" data-column2="<?php echo esc_attr($settings['carousel_column_tablet']); ?>" data-column3="<?php echo esc_attr($settings['carousel_column_mobile']); ?>" data-spacer="<?php echo esc_attr($settings['spacing_item_carousel']); ?>" data-prev_icon="icon-realty-right-slide" data-next_icon="icon-realty-right-slide" data-arrow="false" data-bullets="<?php echo esc_attr($settings['carousel_bullet']) ?>">
			<div class="owl-carousel owl-theme">
				<?php
					$attr['settings'] = $settings; 
					tf_get_template_widget("testimonials/{$settings['testimonial_style']}", $attr);
				?>
			</div>
			<?php if ( $settings['show_hover_cursor'] == 'yes' ) :?>
				<div class="tfmouseCursor cursor-inner"><?php esc_html_e('DRAG', 'themesflat-core'); ?></div>
			<?php endif; ?>
		</div>
		<?php	
	}

}