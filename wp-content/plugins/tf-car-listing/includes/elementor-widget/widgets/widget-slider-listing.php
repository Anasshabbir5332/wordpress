<?php
class Widget_Slider_Listing extends \Elementor\Widget_Base {
	public function get_name() {
		return 'tf_slider_listing';
	}

	public function get_title() {
		return esc_html__( 'TF Slider Listing', 'tf-car-listing' );
	}

	public function get_icon() {
		return 'eicon-single-page';
	}

	public function get_categories() {
		return [ 'themesflat_car_listing_addons' ];
	}

	public function get_keywords() {
		return [ 'listing', 'single' ];
	}

	public function get_style_depends() {
		return [ 'owl-carousel', 'slider-listing' ];
	}

    public function get_script_depends() {
		return [ 'owl-carousel', 'slider-listing' ];
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
				'label'   => esc_html__( 'Styles', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [ 
					'style1' => esc_html__( 'Style 1', 'tf-car-listing' ),
					'style2' => esc_html__( 'Style 2', 'tf-car-listing' ),
					'style3' => esc_html__( 'Style 3', 'tf-car-listing' ),
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'media',
			[
				'label' => esc_html__( 'Thumbnail', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image.jpg",
				],
			]
		);

		$repeater->add_control(
			'sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Over 95,000 classified ads listing', 'tf-car-listing' ),
				'label_block' => true,
			]
		);	

		$repeater->add_control( 'sub_title_id_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}-subtitle' => 'color: {{VALUE}}',					
				],
			]
		);

		$repeater->add_control(
			'heading',
			[
				'label' => esc_html__( 'Heading', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::TEXT,					
				'default' => esc_html__( 'Find what are you looking for', 'tf-car-listing' ),
				'label_block' => true,
			]
		);

		$repeater->add_control( 'heading_id_color',
			[
				'label' => esc_html__( 'Heading Color', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}-title' => 'color: {{VALUE}}',					
				],
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,					
				'default' => esc_html__( 'Explore the worlds largest database to buy, sell, trade or simply rent a car', 'tf-car-listing' ),
				'label_block' => true,
			]
		);	

		$repeater->add_control( 'desc_id_color',
			[
				'label' => esc_html__( 'Descriptopn Color', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}-desc' => 'color: {{VALUE}}',					
				],
			]
		);

		$repeater->add_control( 
			'background_media',
			[
				'label' => esc_html__( 'Background Overlay', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}-media:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control( 
			'media_list',
			[					
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 
						'media' => TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image.jpg",
					],
					[ 
						'media' => TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no-image.jpg",
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
						'max' => 2000,
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
					'{{WRAPPER}} .tf-slider-listing .slider-content .thumb' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'maxwidth_container',
			[ 
				'label'          => esc_html__( 'Maxwidth Container', 'tf-car-listing' ),
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
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 1,
						'max' => 3000,
					],
					'%'  => [ 
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .tf-slider-listing .slider-content .slider-post' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'show_content',
			[ 
				'label'        => esc_html__( 'Show Content Listing', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_button',
			[ 
				'label'        => esc_html__( 'Show Button', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'button_text',
			[ 
				'label'   => esc_html__( 'Text Button', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View Detail', 'tf-car-listing' ),
				'condition'   => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'tf-car-listing' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'tf-car-listing' ),
				'condition'   => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_loop',
			[ 
				'label'        => esc_html__( 'Enable Loop Slider', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'   => [ 
					'show_content!' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// Start Style
		$this->start_controls_section( 'section_style',
		[
			'label' => esc_html__( 'Style', 'tf-car-listing' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);	

	$this->add_responsive_control(
		'align_title',
		[
			'label' => esc_html__( 'Alignment', 'themesflat-core' ),
			'type' => \Elementor\Controls_Manager::CHOOSE,
			'default' => 'left',
			'options' => [
				'left'    => [
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
				]
			],
			'selectors' => [
				'{{WRAPPER}} .tf-slider-listing .slider-content .slider-post' => 'text-align: {{VALUE}}',
			],
			'condition'   => [ 
				'show_content!' => 'yes',
			],
		]
	);

	$this->add_responsive_control(
		'padding_content',
		[
			'label' => esc_html__( 'Padding Content', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'allowed_dimensions' => [ 'top', 'bottom' ],
			'selectors' => [
				'{{WRAPPER}} .tf-slider-listing .slider-content .slider-post' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
			],
		]
	);	

	$this->add_control(
		'h_sub_title',
		[
			'label' => esc_html__( 'Sub Title', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$this->add_group_control( 
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'typography_sub_title',
			'label' => esc_html__( 'Typography', 'tf-car-listing' ),
			'selector' => '{{WRAPPER}} .tf-slider-listing .slider-content .subtitle',
		]
	); 

	$this->add_control( 
		'color_sub_title',
		[
			'label' => esc_html__( 'Color', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tf-slider-listing .slider-content .subtitle' => 'color: {{VALUE}}',					
			],
		]
	);


	$this->add_responsive_control(
		'margin_sub_title',
		[
			'label' => esc_html__( 'Margin', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .tf-slider-listing .slider-content .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);		

	$this->add_control(
		'h_heading',
		[
			'label' => esc_html__( 'Heading', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$this->add_group_control( 
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'typography',
			'label' => esc_html__( 'Typography', 'tf-car-listing' ),
			'selector' => '{{WRAPPER}} .tf-slider-listing .slider-content h1',
		]
	); 

	$this->add_control( 
		'heading_color',
		[
			'label' => esc_html__( 'Color', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .tf-slider-listing .slider-content h1, {{WRAPPER}} .tf-slider-listing .slider-content h1 a' => 'color: {{VALUE}}',					
			],
		]
	);	

	$this->add_responsive_control(
		'heading_margin',
		[
			'label' => esc_html__( 'Margin', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .tf-slider-listing .slider-content h1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_control(
		'h_description',
		[
			'label' => esc_html__( 'Description', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);
	
	$this->add_group_control( 
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'typography_desc',
			'label' => esc_html__( 'Typography', 'tf-car-listing' ),
			'selector' => '{{WRAPPER}}  .tf-slider-listing .slider-content .desc',
		]
	); 

	$this->add_control( 
		'description_color_desc',
		[
			'label' => esc_html__( 'Color', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}  .tf-slider-listing .slider-content .desc' => 'color: {{VALUE}}',					
			],
		]
	);		

	$this->add_responsive_control(
		'description_margin_desc',
		[
			'label' => esc_html__( 'Margin', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}}  .tf-slider-listing .slider-content .desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_control(
		'h_button',
		[
			'label' => esc_html__( 'Button', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);
	
	$this->add_group_control( 
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'typography_button',
			'label' => esc_html__( 'Typography', 'tf-car-listing' ),
			'selector' => '{{WRAPPER}}  .tf-slider-listing .slider-content .button-details a',
		]
	); 

	$this->add_control( 
		'button_color_desc',
		[
			'label' => esc_html__( 'Color', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}  .tf-slider-listing .slider-content .button-details a' => 'color: {{VALUE}}',					
			],
		]
	);	
	
	$this->add_responsive_control(
		'button_padding_desc',
		[
			'label' => esc_html__( 'Padding', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}}  .tf-slider-listing .slider-content .button-details a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_responsive_control(
		'button_margin_desc',
		[
			'label' => esc_html__( 'Margin', 'tf-car-listing' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}}  .tf-slider-listing .slider-content .button-details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->end_controls_section();    
// /.End Style 


	}

	protected function render( $instance = [] ) {
		$settings         = $this->get_settings_for_display();

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

		$attr['settings'] = $settings;
		?>
		<div class="tf-slider-listing <?php echo esc_attr($settings['style']); ?>">
            <div class="listing">
					<div class="owl-carousel" data-loop="<?php echo esc_attr( $settings['carousel_loop'] ) ?>" data-auto="false"
						data-column="1"
						data-column2="1"
						data-column3="1"
						data-column4="1" data-arrow="yes"
						data-prev_icon="icon-autodeal-icon-85" data-next_icon="icon-autodeal-icon-86" data-spacing="0"
						data-bullets="false">
					<?php $count = 0; while ( $query->have_posts() ) :
						$query->the_post(); ?>
						<div class="item">
							<div class="slider-content">
								<?php foreach ($settings['media_list'] as $key => $carousel ): ?>
									<?php if ( $count == $key ) : ?>
										<div class="media-inner elementor-repeater-item-<?php echo esc_attr($carousel['_id']); ?>-media">
											<?php if ($carousel['media']['id']): ?>
														<img src="<?php echo esc_url(\Elementor\Group_Control_Image_Size::get_attachment_image_src( $carousel['media']['id'], 'thumbnail', $settings )); ?>" class="thumb" alt="image">
											<?php else: ?>
														<img src="<?php echo esc_attr($carousel['media']['url']); ?>" class="thumb" alt="image">
											<?php endif ?>
										</div>
										<?php if ( $settings['show_content'] != 'yes' ) : ?>
											<div class="content-title slider-post">
												<?php if (!empty($carousel['sub_title'])): ?>
													 <p class="subtitle elementor-repeater-item-<?php echo esc_attr($carousel['_id']); ?>-subtitle">
														 <?php echo sprintf( '%s',$carousel['sub_title'] ); ?>
													 </p>
												<?php endif ?>
												<?php if (!empty($carousel['heading'])): ?>
													 <h1 class="title elementor-repeater-item-<?php echo esc_attr($carousel['_id']); ?>-title"><?php echo sprintf( '%s',$carousel['heading'] ); ?></h1>
												<?php endif ?>
												<?php if (!empty($carousel['description'])): ?>
													 <p class="desc elementor-repeater-item-<?php echo esc_attr($carousel['_id']); ?>-desc">
														 <?php echo sprintf( '%s',$carousel['description'] ); ?>
													 </p>
												<?php endif ?>
												<?php if ( $settings['show_button'] == 'yes' ) : ?>
													<div class="button-details">
														<a href="<?php echo esc_url( $settings['link']['url'] ) ?>"><?php echo esc_attr( $settings['button_text'] ); ?></a>
													</div>
												<?php endif ?>
											</div>
										<?php endif ?>
									<?php endif ?>
								<?php endforeach;?>


							<?php if ( $settings['show_content'] == 'yes' ) : ?>
								<?php
									$attr['settings'] = $settings;
									tf_get_template_widget_elementor( "templates/slider-listing/{$settings['style']}", $attr );
								?>
							<?php endif ?>
							</div>
						</div>
					<?php $count++; endwhile; ?>
					<?php wp_reset_postdata(); ?>
			</div>
			</div>
		</div>
		<?php
	}
}