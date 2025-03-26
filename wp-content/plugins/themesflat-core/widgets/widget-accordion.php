<?php
class TFAccordion_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tfaccordion';
    }
    
    public function get_title() {
        return esc_html__( 'TF Accordion', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-accordion';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
		return [ 'tf-accordion' ];
	}

    public function get_script_depends() {
		return [ 'tf-accordion' ];
	}

	protected function _register_controls() {
        // Start Accordion        
			$this->start_controls_section( 
				'section_accordion',
	            [
	                'label' => esc_html__('Accordion', 'themesflat-core'),
	            ]
	        );	

	    	$this->add_control( 'heading_icon',
				[
					'label' => esc_html__( 'Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
				]
			);

			$this->add_control( 'icon_style',
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
							'icon' => 'eicon-favorite',
						],
					],
					'default' => 'icon',
				]
			);	

			$this->add_control( 
				'icon_position',
				[
					'label' => esc_html__( 'Icon Position', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'icon_after',
					'options' => [
						'icon_after' => esc_html__( 'Right', 'themesflat-core' ),
					],
					'condition' => [
						'icon_style!' => 'none',
					],
				]
			);

			$this->add_control( 'icon_accodion',
				[
					'label' => esc_html__( 'Left Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_accodion4',
					'default' => [
						'value' => 'icon-autodeal-icon-81',
						'library' => 'theme_icon',
					],
					'condition' => [
	                    'icon_style' => 'icon',
	                    'icon_position' => ['icon_before', 'icon_before_after'],
	                ],
				]
			);

			$this->add_control( 'icon_accodion_active',
				[
					'label' => esc_html__( 'Left Icon Active', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_accodion_active4',
					'default' => [
						'value' => 'icon-autodeal-icon-80',
						'library' => 'theme_icon',
					],
					'condition' => [
	                    'icon_style' => 'icon',
	                    'icon_position' => ['icon_before', 'icon_before_after'],
	                ],
				]
			);

			$this->add_control( 'icon_accodion_right',
				[
					'label' => esc_html__( 'Right Icon', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_accodion4_right',
					'default' => [
						'value' => 'icon-autodeal-icon-81',
						'library' => 'theme_icon',
					],
					'condition' => [
	                    'icon_style' => 'icon',
	                    'icon_position' => ['icon_after', 'icon_before_after'],
	                ],
				]
			);

			$this->add_control( 'icon_accodion_right_active',
				[
					'label' => esc_html__( 'Right Icon Active', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_accodion_active4_right',
					'default' => [
						'value' => 'icon-autodeal-icon-80',
						'library' => 'theme_icon',
					],
					'condition' => [
	                    'icon_style' => 'icon',
	                    'icon_position' => ['icon_after', 'icon_before_after'],
	                ],
				]
			);

	        $repeater = new \Elementor\Repeater();
	        	$repeater->add_control( 'set_active',
					[
						'label' => esc_html__( 'Set Active Item', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'themesflat-core' ),
						'label_off' => esc_html__( 'No', 'themesflat-core' ),
						'return_value' => 'active',
						'default' => 'inactive',
					]
				);		        
		        $repeater->add_control( 'list_title', [
						'label' => esc_html__( 'Nav text', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => esc_html__( 'Accordion' , 'themesflat-core' ),
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
						],
					]
				);	
				$repeater->add_control( 'list_content', [
						'label' => esc_html__( 'Content text', 'themesflat-core' ),
						'type' => \Elementor\Controls_Manager::WYSIWYG,
						'default' => esc_html__( 'Good strategy is the antidote to competition. Strategic thinking is the process of developing a strategy that defines your value proposition and your unique value chain. This process includes market and competitive research as well as an assessment of the company’s capabilities and the industry forces impacting it.' , 'themesflat-core' ),
						'label_block' => true,
						'condition' => [
	                        'list_content_text_type' => 'editor',
	                    ],
					]
				);
		        $this->add_control( 'accordion_list',
					[					
						'type' => \Elementor\Controls_Manager::REPEATER,
						'fields' => $repeater->get_controls(),
						'default' => [
							[	
								'set_active' => 'active',
								'list_title' => esc_html__( 'Ornare laoreet mi tempus neque ', 'themesflat-core' ),
								'list_content' => esc_html__( "Timperdiet gravida scelerisque odio nunc. Eget felis, odio bibendum quis eget sit lorem donec diam. " ),
							],
							[
								'set_active' => 'inactive',
								'list_title' => esc_html__( 'Rhoncus nullam aliquam nam proin', 'themesflat-core' ),
								'list_content' => esc_html__( "Timperdiet gravida scelerisque odio nunc. Eget felis, odio bibendum quis eget sit lorem donec diam. " ),
							],
							[
								'set_active' => 'inactive',
								'list_title' => esc_html__( 'Duis enim bibendum dui ut fringilla ', 'themesflat-core' ),
								'list_content' => esc_html__( "Timperdiet gravida scelerisque odio nunc. Eget felis, odio bibendum quis eget sit lorem donec diam. " ),
							],
							[
								'set_active' => 'inactive',
								'list_title' => esc_html__( 'Lectus fringilla volutpat egestas nisi', 'themesflat-core' ),
								'list_content' => esc_html__( "Timperdiet gravida scelerisque odio nunc. Eget felis, odio bibendum quis eget sit lorem donec diam. " ),
							],
							[
								'set_active' => 'inactive',
								'list_title' => esc_html__( 'Vitae sollicitudin vitae libero tincidunt', 'themesflat-core' ),
								'list_content' => esc_html__( "Timperdiet gravida scelerisque odio nunc. Eget felis, odio bibendum quis eget sit lorem donec diam. " ),
							],
						],
						'title_field' => '{{{ list_title }}}',
					]
				);

			$this->end_controls_section();
        // /.End Accordion		
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();
		
		$accordion_item = $html_title = $icon_title = $icon_title_right = $icon_accodion_close = $icon_accodion_open = $icon_accodion_right_close = $icon_accodion_right_open = $html_content = $set_active = '';		

		foreach ($settings['accordion_list'] as $key => $value) {


			if ( $settings['icon_style'] == 'icon' ) {
				if ( $settings['icon_position'] == 'icon_after' || $settings['icon_position'] == 'icon_before_after' ) {
					$icon_accodion_right_close =  \Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $settings['icon_accodion_right'] );
				}
				if ( $settings['icon_position'] == 'icon_after' || $settings['icon_position'] == 'icon_before_after' ) {
					$icon_accodion_right_open =  \Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $settings['icon_accodion_right_active'] );
				}
			}

			if ( $settings['icon_style'] != 'none' ) {
				$icon_title = sprintf('		
				<span class="wrap-accordion-icon wrap-accordion-icon-left">		
				<span class="accordion-icon accordion-icon-close">%1$s</span>
				<span class="accordion-icon accordion-icon-open">%2$s</span>
				</span>'
				, $icon_accodion_close, $icon_accodion_open );

				$icon_title_right = sprintf('		
				<span class="wrap-accordion-icon wrap-accordion-icon-right">		
				<span class="accordion-icon accordion-icon-close">%1$s</span>
				<span class="accordion-icon accordion-icon-open">%2$s</span>
				</span>'
				, $icon_accodion_right_close, $icon_accodion_right_open );
			}

			if ($value['list_title'] != '') {
				if ($settings['icon_position'] == 'icon_before_after') {
					$html_title = sprintf('<div class="accordion-title %4$s %5$s">%2$s <span class="title-text">%1$s</span> %3$s</div>', $value['list_title'], $icon_title, $icon_title_right, $settings['icon_position'], $value['set_active']);
				}else{
					$html_title = sprintf('<div class="accordion-title %3$s %4$s"><span class="title-text">%1$s</span> %2$s</div>', $value['list_title'], $icon_title_right, $settings['icon_position'], $value['set_active']);
				}
				
			}


			$html_content = sprintf('<div class="accordion-content">%1$s</div>', do_shortcode( $value['list_content'] ));

			$accordion_item .= sprintf('<div class="tf-accordion-item %3$s">%1$s %2$s</div>', $html_title, $html_content, $value['set_active']);
		}


		echo sprintf ( 
			'<div class="tf-accordion"> 
				%1$s
            </div>',
            $accordion_item
        );
	}	

}