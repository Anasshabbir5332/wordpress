<?php
class TFPosts_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tfposts';
    }
    
    public function get_title() {
        return esc_html__( 'TF Posts', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

	public function get_style_depends() {
		return ['tf-posts', 'owl-carousel'];
	}

	public function get_script_depends() {
		return ['tf-posts', 'owl-carousel'];
	}

	protected function register_controls() {
        // Start Posts Query        
			$this->start_controls_section( 
				'section_posts_query',
	            [
	                'label' => esc_html__('Query', 'themesflat-core'),
	            ]
	        );	

			$this->add_control( 
	        	'style',
				[
					'label' => esc_html__( 'Layout Style', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'style1',
					'options' => [
						'style1' => esc_html__( 'Style 1', 'themesflat-core' ),
						'style2' => esc_html__( 'Style 2', 'themesflat-core' ),
						'style3' => esc_html__( 'Style 3', 'themesflat-core' ),
						'style4' => esc_html__( 'Style 4', 'themesflat-core' ),
					],
				]
			);

			$this->add_control( 
				'posts_per_page',
	            [
	                'label' => esc_html__( 'Posts Per Page', 'themesflat-core' ),
	                'type' => \Elementor\Controls_Manager::NUMBER,
	                'default' => '3',
	            ]
	        );

	        $this->add_control( 
	        	'order_by',
				[
					'label' => esc_html__( 'Order By', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [						
			            'date' => 'Date',
			            'ID' => 'Post ID',			            
			            'title' => 'Title',
					],
				]
			);

			$this->add_control( 
				'order',
				[
					'label' => esc_html__( 'Order', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'options' => [						
			            'desc' => 'Descending',
			            'asc' => 'Ascending',	
					],
				]
			);

			$this->add_control( 
				'posts_categories',
				[
					'label' => esc_html__( 'Categories', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'options' => ThemesFlat_Addon_For_Elementor_autodeal::tf_get_taxonomies(),
					'label_block' => true,
	                'multiple' => true,
				]
			);

			$this->add_control( 
				'exclude',
				[
					'label' => esc_html__( 'Exclude', 'themesflat-core' ),
					'type'	=> \Elementor\Controls_Manager::TEXT,	
					'description' => esc_html__( 'Post Ids Will Be Inorged. Ex: 1,2,3', 'themesflat-core' ),
					'default' => '',
					'label_block' => true,				
				]
			);

			$this->add_control(
				'sort_by_id',
				[ 
					'label'       => esc_html__( 'Sort By ID', 'themesflat-core' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'description' => esc_html__( 'Post Ids Will Be Sort. Ex: 1,2,3', 'themesflat-core' ),
					'default'     => '',
					'label_block' => true,
				]
			);

			$this->add_control( 
				'show_pagination',
				[
					'label' => esc_html__( 'Show Pagination', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);

			$this->add_control( 
				'show_btn_view',
				[
					'label' => esc_html__( 'Show Button Wrap Blog', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'no',
					'condition' => [
						'style' => 'style4'
					],
				]
			);

			$this->add_control( 
				'button_view_all',
				[
					'label' => esc_html__( 'Button Text', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'View all news', 'themesflat-core' ),
					'condition' => [
	                    'show_btn_view'	=> 'yes',
	                ],
				]
			);

			$this->add_control(
				'link_btn',
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
	                    'show_btn_view'	=> 'yes',
	                ],
				]
			);


			$this->end_controls_section();
        // /.End Posts Query

		// Start Layout        
			$this->start_controls_section( 
				'section_posts_layout',
	            [
	                'label' => esc_html__('Layout', 'themesflat-core'),
	            ]
	        );	

	        $this->add_control(
	        	'posts_layout',
				[
					'label' => esc_html__( 'Columns', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'column-3',
					'options' => [
						'column-1' => esc_html__( '1', 'themesflat-core' ),
						'column-2' => esc_html__( '2', 'themesflat-core' ),
						'column-3' => esc_html__( '3', 'themesflat-core' ),
						'column-4' => esc_html__( '4', 'themesflat-core' ),
					],
				]
			);

			$this->add_control( 
	        	'posts_layout_tablet',
				[
					'label' => esc_html__( 'Columns Tablet', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'tablet-column-1',
					'options' => [
						'tablet-column-1' => esc_html__( '1', 'themesflat-core' ),
						'tablet-column-2' => esc_html__( '2', 'themesflat-core' ),
						'tablet-column-3' => esc_html__( '3', 'themesflat-core' ),
					],
				]
			);

			$this->add_control( 
	        	'posts_layout_mobile',
				[
					'label' => esc_html__( 'Columns Mobile', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'mobile-column-1',
					'options' => [
						'mobile-column-1' => esc_html__( '1', 'themesflat-core' ),
						'mobile-column-2' => esc_html__( '2', 'themesflat-core' ),
					],
				]
			);

			$this->add_control(
				'layout_align',
				[
					'label' => esc_html__( 'Alignment', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
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
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'themesflat-core' ),
							'icon' => 'eicon-text-align-justify',
						],
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

			$this->add_group_control( 
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'default' => 'full',
				]
			);

			$this->add_responsive_control( 
				'h_image_height',
				[
					'label' => esc_html__( 'Image Height', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .featured-post img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control( 
				'show_image',
				[
					'label' => esc_html__( 'Show Image', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
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
				'show_title',
				[
					'label' => esc_html__( 'Show Title', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control( 
				'show_excerpt',
				[
					'label' => esc_html__( 'Show Excerpt', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$this->add_control( 
				'excerpt_lenght',
				[
					'label' => esc_html__( 'Excerpt Length', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 500,
					'step' => 1,
					'default' => 20,
					'condition' => [
						'show_excerpt' => 'yes'
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
				'button_text',
				[
					'label' => esc_html__( 'Button Text', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Read more', 'themesflat-core' ),
					'condition' => [
	                    'show_button'	=> 'yes',
	                ],
				]
			);		

			$this->add_control(
				'post_icon_readmore',
				[
					'label' => esc_html__( 'Button Icon ', 'autodeal' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'default' => [
						'value' => 'icon-autodeal-icon-133',
						'library' => 'theme_icon',
					],
				]
			);

			$this->add_control( 
				'heading_meta',
				[
					'label' => esc_html__( 'Meta', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control( 
				'show_meta',
				[
					'label' => esc_html__( 'Show Meta', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			); 

			$this->add_control( 
				'show_category',
				[
					'label' => esc_html__( 'Show Category', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
	                    'show_meta'	=> 'yes',
	                ],
				]
			);

			$this->add_control( 
				'show_user',
				[
					'label' => esc_html__( 'Show User', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
	                    'show_meta'	=> 'yes',
	                ],
				]
			);

			$this->add_control( 
				'show_date',
				[
					'label' => esc_html__( 'Show Date', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'themesflat-core' ),
					'label_off' => esc_html__( 'Hide', 'themesflat-core' ),
					'return_value' => 'yes',
					'default' => 'yes',
					'condition' => [
	                    'show_meta'	=> 'yes',
	                ],
				]
			);  
			
			$this->end_controls_section();
        // /.End Layout

		// Start Carousel        
		$this->start_controls_section( 
			'section_posts_carousel',
			[
				'label' => esc_html__('Carousel', 'themesflat-core'),
				'condition' => [
					'show_pagination!'	=> 'yes',
					'style!' => 'style4',
				],
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
				'default' => 'no',
			]
		);     
		
		$this->add_control( 
			'carousel_space',
			[
				'label' => esc_html__( 'Gap', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '30',
				'condition' => [
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control( 
			'carousel_loop',
			[
				'label' => esc_html__( 'Loop', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'themesflat-core' ),
				'label_off' => esc_html__( 'Off', 'themesflat-core' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control( 
			'carousel_auto',
			[
				'label' => esc_html__( 'Auto Play', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'themesflat-core' ),
				'label_off' => esc_html__( 'Off', 'themesflat-core' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control( 
			'carousel_column_desk',
			[
				'label' => esc_html__( 'Columns Desktop', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => esc_html__( '1', 'themesflat-core' ),
					'2' => esc_html__( '2', 'themesflat-core' ),
					'3' => esc_html__( '3', 'themesflat-core' ),
					'4' => esc_html__( '4', 'themesflat-core' ),
				],
				'condition' => [
					'carousel' => 'yes',
				],
			]
		);

		$this->add_control( 
			'carousel_column_tablet',
			[
				'label' => esc_html__( 'Columns Tablet', 'themesflat-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( '1', 'themesflat-core' ),
					'2' => esc_html__( '2', 'themesflat-core' ),
					'3' => esc_html__( '3', 'themesflat-core' ),
				],
				'condition' => [
					'carousel' => 'yes',
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
				'condition' => [
					'carousel' => 'yes',
				],
			]
		);	

		$this->end_controls_section();
	// /.End Carousel	

        // Start General Style 
	        $this->start_controls_section( 
	        	'section_style_general',
	            [
	                'label' => esc_html__( 'General', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	       
	        $this->add_responsive_control(
	        	'padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'default' => [
						'top' => '15',
						'right' => '15',
						'bottom' => '15',
						'left' => '15',
						'unit' => 'px',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],										
				]
			);
			$this->add_responsive_control( 
				'margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control( 
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'label' => esc_html__( 'Box Shadow', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-posts .blog-post, {{WRAPPER}} .tf-posts.style1 .blog-post.wg-post-1:hover',
				]
			);
			$this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-posts .blog-post',
				]
			);
			$this->add_responsive_control( 
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' , '%' ],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
					],
				]
			);

	        $this->end_controls_section();    
	    // /.End General Style

	    // Start Image Style 
	        $this->start_controls_section( 
	        	'section_style_image',
	            [
	                'label' => esc_html__( 'Image', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );	        

			$this->add_responsive_control( 
				'w_image_height',
				[
					'label' => esc_html__( 'Width Box Height', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .featured-post' => 'width: {{SIZE}}{{UNIT}};flex-shrink: 0;',
					],
				]
			);

			$this->add_responsive_control( 
				'w_image_height_h',
				[
					'label' => esc_html__( 'Height Image', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .featured-post img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

	        $this->add_responsive_control( 
	        	'padding_image',
				[
					'label' => esc_html__( 'Padding', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .featured-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					]
				]
			);	

			$this->add_responsive_control( 
				'margin_image',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],				
					'selectors' => [
						'{{WRAPPER}} .tf-posts .featured-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);  

			$this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border_image',
					'label' => esc_html__( 'Border', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-posts .featured-post',
				]
			); 

			$this->add_responsive_control( 
				'border_radius_image',
				[
					'label' => esc_html__( 'Border Radius', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' , '%' ],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .featured-post img, {{WRAPPER}} .tf-posts .featured-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			); 

	        $this->end_controls_section();    
	    // /.End Image Style

	    // Start Content Style 
		    $this->start_controls_section( 
		    	'section_style_content',
	            [
	                'label' => esc_html__( 'Content', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        $this->add_responsive_control( 
				'content_padding',
				[
					'label' => esc_html__( 'Padding', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control( 
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border_image_content',
					'label' => esc_html__( 'Border', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-posts .blog-post .content',
				]
			); 
			$this->add_control( 
				'bg_content_s2',
				[
					'label' => esc_html__( 'Background', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .content, {{WRAPPER}} .tf-posts .blog-post' => 'background: {{VALUE}}',
					],
				]
			);
			$this->add_control( 
				'bg_content_s2_hover',
				[
					'label' => esc_html__( 'Background Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post:hover .content, {{WRAPPER}} .tf-posts .blog-post:hover' => 'background: {{VALUE}}',
					],
				]
			);
		    $this->end_controls_section();
	    // /.End Content Style

        // Start Title Style 
		    $this->start_controls_section( 
		    	'section_style_title',
	            [
	                'label' => esc_html__( 'Title', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	            ]
	        );
	        $this->add_control( 
				'title_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .title a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control( 
				'title_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .title a:hover' => 'color: {{VALUE}}',
					],
				]
			);
	        $this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_s1_typography',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),
					
					'selector' => '{{WRAPPER}} .tf-posts .blog-post .title',
				]
			);

			$this->add_responsive_control( 
				'title_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		    $this->end_controls_section();
	    // /.End Title Style

	    // Start Excerpt Style 
		    $this->start_controls_section( 
		    	'section_style_text',
	            [
	                'label' => esc_html__( 'Excerpt', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
					'condition' => [
	                    'show_excerpt'	=> 'yes',
	                ],
	            ]
	        );
	        $this->add_control( 
				'text_color',
				[
					'label' => esc_html__( 'Color', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .description' => 'color: {{VALUE}}',
					],
				]
			);
	        $this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'text_typography',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),
					'selector' => '{{WRAPPER}} .tf-posts .blog-post .description',
				]
			);
			$this->add_responsive_control( 
				'text_margin',
				[
					'label' => esc_html__( 'Margin', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		    $this->end_controls_section();
	    // /.End Excerpt Style

	    // Start Button Style 
		    $this->start_controls_section( 
		    	'section_style_button',
	            [
	                'label' => esc_html__( 'Button', 'themesflat-core' ),
	                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
	                'condition' => [
	                    'show_button'	=> 'yes',
	                ],
	            ]
	        );
	        $this->add_group_control( 
	        	\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'button_s1_typography',
					'label' => esc_html__( 'Typography', 'themesflat-core' ),

					'selector' => '{{WRAPPER}} .tf-posts .blog-post .tf-button',
				]
			);
			$this->add_control( 
				'button_color',
				[
					'label' => esc_html__( 'Color ', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}  .tf-posts .blog-post .tf-button a, {{WRAPPER}} .tf-posts .blog-post .content .tf-button-container a' => 'color: {{VALUE}}',
					],
				]
			); 
			$this->add_control( 
				'button_color_hover',
				[
					'label' => esc_html__( 'Color Hover', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .tf-button a:hover, {{WRAPPER}} .tf-posts .blog-post .content .tf-button-container a:hover' => 'color: {{VALUE}}',
					],
				]
			); 

			$this->add_control( 
				'heading_button_icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			); 
			
			$this->add_control( 
				'button_icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tf-posts .blog-post .content .tf-button-container a i ' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tf-posts .blog-post .content .tf-button-container a i svg ' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			); 

		    $this->end_controls_section();
	    // /.End Button Style

	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$has_carousel = 'no-carousel';
		if ( $settings['carousel'] == 'yes' ) {
			$has_carousel = 'has-carousel';
		}

		$this->add_render_attribute( 'tf_posts', ['id' => "tf-posts-{$this->get_id()}", 'class' => ['tf-posts',$settings['layout_align'],$settings['style'], $settings['posts_layout'], $settings['posts_layout_tablet'], $settings['posts_layout_mobile'],$has_carousel ], 'data-tabid' => $this->get_id()] );

		if ( get_query_var('paged') ) {
           $paged = get_query_var('paged');
        } elseif ( get_query_var('page') ) {
           $paged = get_query_var('page');
        } else {
           $paged = 1;
        }
		$query_args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_per_page'],
            'paged'     => $paged
        );
        if (! empty( $settings['posts_categories'] )) {
        	$query_args['category_name'] = implode(',', $settings['posts_categories']);
        }        
        if ( ! empty( $settings['exclude'] ) ) {				
			if ( ! is_array( $settings['exclude'] ) )
				$exclude = explode( ',', $settings['exclude'] );

			$query_args['post__not_in'] = $exclude;
		}
		$query_args['orderby'] = $settings['order_by'];
		$query_args['order'] = $settings['order'];
		
		if ( $settings['sort_by_id'] != '' ) {	
			$sort_by_id = array_map( 'trim', explode( ',', $settings['sort_by_id'] ) );
			$query_args['post__in'] = $sort_by_id;
			$query_args['orderby'] = 'post__in';
		}
		
		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) : ?>
			<div <?php echo $this->get_render_attribute_string('tf_posts'); ?> data-space="<?php echo esc_attr($settings['carousel_space']); ?>"  data-loop="<?php echo esc_attr($settings['carousel_loop']); ?>" data-auto="<?php echo esc_attr($settings['carousel_auto']); ?>" data-column="<?php echo esc_attr($settings['carousel_column_desk']); ?>" data-column2="<?php echo esc_attr($settings['carousel_column_tablet']); ?>" data-column3="<?php echo esc_attr($settings['carousel_column_mobile']); ?>">
			<?php if ( $settings['carousel'] == 'yes' ): ?>
				<div class="owl-carousel">
				<?php endif; ?>	
					<?php
						$attr['settings'] = $settings; 
						tf_get_template_widget("posts/{$settings['style']}", $attr);
					?>
					<?php if ( $settings['show_pagination'] == 'yes' ):?>
						<div class="pagination-post">
							<?php themesflat_pagination_posttype($query, 'pager'); ?> 
						</div>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				<?php if ( $settings['carousel'] == 'yes' ): ?>
				</div>
				<?php endif; ?>
			</div>
		<?php
		else:
			esc_html_e('No posts found', 'themesflat-core');
		endif;		
		
	}

	

	

}