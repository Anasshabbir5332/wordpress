<?php
class TFListCarousel extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-list-carousel';
    }
    
    public function get_title() {
        return esc_html__( 'TF Features Carousel', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return ['tf-testimonial'];
	}

	protected function register_controls() {
        // Start Carousel Setting        
			$this->start_controls_section( 
				'section_carousel',
	            [
	                'label' => esc_html__('TF Slider  Listing', 'themesflat-core'),
	            ]
	        );	

			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'media',
				[
					'label' => esc_html__( 'Media', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_THEME."assets/img/placeholder-2.jpg",
					],
				]
			);

			$repeater->add_control(
				'name',
				[
					'label' => esc_html__( 'Title', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( '2024 Hyundai Staria Premium Review', 'themesflat-core' ),
				]
			);

			$repeater->add_control(
				'desc',
				[
					'label' => esc_html__( 'Description', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam non egestas justo. Vestibulum ac commodo enim, eget fringilla lectus.', 'themesflat-core' ),
				]
			);

			$repeater->add_control(
				'text_button',
				[
					'label' => esc_html__( 'Text Button', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Review detail', 'themesflat-core' ),
				]
			);

			$repeater->add_control(
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
				]
			);

			$this->add_control( 
				'carousel_list',
				[					
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[ 
							'name' => '2024 Hyundai Staria Premium Review',
							'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam non egestas justo. Vestibulum ac commodo enim, eget fringilla lectus.',
							'text_button' => 'Review detail',
							'link' => '#',
						],
						[ 
							'name' => '2024 Hyundai Staria Premium Review',
							'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam non egestas justo. Vestibulum ac commodo enim, eget fringilla lectus.',
							'text_button' => 'Review detail',
							'link' => '#',
						],
						[ 
							'name' => '2024 Hyundai Staria Premium Review',
							'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam non egestas justo. Vestibulum ac commodo enim, eget fringilla lectus.',
							'text_button' => 'Review detail',
							'link' => '#',
						],
					],					
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'default' => 'thumbnail',
				]
			);

			$this->add_control(
	        	'layout',
				[
					'label' => esc_html__( 'Columns', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( '1', 'themesflat-core' ),
						'2' => esc_html__( '2', 'themesflat-core' ),
						'3' => esc_html__( '3', 'themesflat-core' ),
					],
				]
			);

			$this->add_control( 
	        	'layout_tablet',
				[
					'label' => esc_html__( 'Columns Tablet', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( '1', 'themesflat-core' ),
						'2' => esc_html__( '2', 'themesflat-core' ),
						'3' => esc_html__( '3', 'themesflat-core' ),
					],
				]
			);

			$this->add_control( 
	        	'layout_mobile',
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
			
			$this->end_controls_section();
        // /.End Carousel	

        // Start Style        
			$this->start_controls_section( 
				'section_style',
	            [
	                'label' => esc_html__('Style', 'themesflat-core'),
	            ]
	        );	

			$this->add_control(
				'h_before_title',
				[
					'label' => esc_html__( 'Title', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'typography_before_title',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-list-carousel h2',
				]
			);
			$this->add_control( 
				'color_before_title',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel h2' => 'color: {{VALUE}}',					
					],
				]
			);

			$this->add_control(
				'h_before_desc',
				[
					'label' => esc_html__( 'Description', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'typography_before_desc',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-list-carousel p',
				]
			);
			$this->add_control( 
				'color_before_desc',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel p' => 'color: {{VALUE}}',					
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
					'selector' => '{{WRAPPER}} .tf-list-carousel a',
				]
			);

			$this->add_control(
				'button_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel a' => 'color: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'button_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel a' => 'background: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'border_color',
				[
					'label' => esc_html__( 'Border Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel a' => 'border-color: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'button_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel a:hover' => 'color: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'button_bg_color_hover',
				[
					'label' => esc_html__( 'Background Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel a:hover' => 'background: {{VALUE}};',
					]
				]
			);	

			$this->add_control(
				'border_color_hover',
				[
					'label' => esc_html__( 'Border Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-list-carousel a:hover' => 'border-color: {{VALUE}};',
					]
				]
			);	


	        $this->end_controls_section();
        // /.End Style

        // Start Arrow        
			$this->start_controls_section( 
				'section_arrow',
	            [
	                'label' => esc_html__('Arrow', 'themesflat-core'),
	            ]
	        );

			$this->add_control( 
				'carousel',
				[
					'label' => esc_html__( 'Carousel', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'themesflat-core' ),
					'label_off' => esc_html__( 'Off', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);  

	        $this->add_control( 
				'carousel_arrow',
				[
					'label' => esc_html__( 'Arrow', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',				
					'description'	=> 'Just show when you have two slide',
					'separator' => 'before',
				]
			);

	        $this->end_controls_section();
        // /.End Arrow
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		if ( $settings['carousel'] == 'yes' ) {
			wp_enqueue_script( 'owl-carousel');
			wp_enqueue_script( 'tf-testimonial');
			$has_swiper = 'has-slide';
		} else {
			$has_swiper = 'no-slide';
		}

		?>
		<div class="tf-list-carousel <?php echo esc_attr($has_swiper);?>" data-column="<?php echo esc_attr($settings['layout']) ?>" data-column2="<?php echo esc_attr($settings['layout_tablet']) ?>"  data-column3="<?php echo esc_attr($settings['layout_mobile']) ?>" data-loop="true" data-auto="false" data-spacer="24" data-arrow="<?php echo esc_attr($settings['carousel_arrow']) ?>">
				<div class="wrap-testimonial">
					<?php if ( $settings['carousel'] == 'yes' ): ?>
						<div class="owl-carousel">
					<?php endif; ?>
						<?php foreach ($settings['carousel_list'] as $carousel): ?>
							<?php 
								$target = $carousel['link']['is_external'] ? ' target="_blank"' : '';
								$nofollow = $carousel['link']['nofollow'] ? ' rel="nofollow"' : '';
								$url = esc_attr($carousel['link']['url']);	
							?>
                            <div class="item">
                                <div class="images">
                                    <?php if ($carousel['media']['id']): ?>
                                        <img src="<?php echo esc_url(\Elementor\Group_Control_Image_Size::get_attachment_image_src( $carousel['media']['id'], 'thumbnail', $settings )); ?>" width="210" height="171" alt="image">
                                    <?php else: ?>
                                        <img src="<?php echo esc_attr($carousel['media']['url']); ?>" width="210" height="171" alt="image">
                                    <?php endif ?>
                                </div>
								<div class="content">
									<?php if ($carousel['name'] != ''): ?>
											<?php
												echo sprintf( '<h2 class="name">%1$s</h2>', $carousel['name'] );
											?>
									<?php endif; ?> 
									<?php if ($carousel['desc'] != ''): ?>
										<p>
											<?php echo esc_html($carousel['desc']); ?>
										</p>
									<?php endif; ?> 
									<?php if ($carousel['text_button'] != ''): ?>
										<a href="<?php echo $url ?>" <?php echo $target; echo $nofollow; ?>><?php echo esc_attr($carousel['text_button']); ?></a>
									<?php endif; ?> 
								</div>

                            </div>
					    <?php endforeach;?>
						<?php if ( $settings['carousel'] == 'yes' ): ?>
							</div>
						<?php endif; ?>
				</div>
		</div>
		<?php	
	}

}