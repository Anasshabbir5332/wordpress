<?php
class Widget_Single_Listing extends \Elementor\Widget_Base {
	public function get_name() {
		return 'tf_single_listing';
	}

	public function get_title() {
		return esc_html__( 'TF Single Listing', 'tf-car-listing' );
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
		return [ 'listing-styles' ];
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
			'listing_id',
			[ 
				'label'       => esc_html__( 'Listing ID', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Listing Id Will Be Display. Ex: 123', 'tf-car-listing' ),
				'default'     => '',
				'label_block' => true,
			]
		);

		$this->add_control(
			'enable_compare_listing',
			[ 
				'label'        => esc_html__( 'Show Compare Listing', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'enable_favorite_listing',
			[ 
				'label'        => esc_html__( 'Show Favorite Listing', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Off', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_type_fuel',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_fuel_type'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_mileages',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_mileage'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_transmission',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_transmission'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_make',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_make'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_model',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_model'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_body',
			[ 
				'label'        => esc_html__( 'Show Body', 'tf-car-listing' ) . get_option('custom_name_body'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_stock_number',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_stock_number'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_vin_number',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_vin_number'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_drive_type',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_drive_type'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_engine_size',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_engine_size'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'show_cylinders',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_cylinders'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_door',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_door'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_color',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing') . get_option('custom_name_color'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_seat',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_seat'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_city_mpg',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_city_mpg'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_highway_mpg',
			[ 
				'label'        => esc_html__( 'Show ', 'tf-car-listing' ) . get_option('custom_name_highway_mpg'),
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
				'label'   => esc_html__( 'Text Button Buy Now', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View car', 'tf-car-listing' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		$settings         = $this->get_settings_for_display();
		$attr['settings'] = $settings;
		?>
		<div class="tf-listing-wrap widget-single-listing">
			<div class="wrap-listing-post">
				<?php tf_get_template_widget_elementor( "templates/single-listing/style1", $attr ); ?>
			</div>
		</div>
		<?php
	}
}