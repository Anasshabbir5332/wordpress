<?php
class Widget_Compare_Listing extends \Elementor\Widget_Base {
	public function get_name() {
		return 'tf_compare_listing';
	}

	public function get_title() {
		return esc_html__( 'TF Compare 2 Item', 'tf-car-listing' );
	}

	public function get_icon() {
		return 'eicon-single-page';
	}

	public function get_categories() {
		return [ 'themesflat_car_listing_addons' ];
	}

	public function get_style_depends() {
		return [ 'compare-listing' ];
	}

	public function get_script_depends() {
		return [ 'compare-listing' ];
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
			'button_text',
			[ 
				'label'   => esc_html__( 'Text Button', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Compare', 'tf-car-listing' ),
			]
		);

		$this->end_controls_section();
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
			'posts_per_page' => 2,
			'paged'          => $paged
		);

		$query_args['orderby'] = $settings['order_by'];
		$query_args['order']   = $settings['order'];

		if ( $settings['sort_by_id'] != '' ) {
			$sort_by_id             = array_map( 'trim', explode( ',', $settings['sort_by_id'] ) );
			$query_args['post__in'] = $sort_by_id;
			$query_args['orderby']  = 'post__in';
		}

		$query = new WP_Query( $query_args );
		?>

		<div class="tf-compare-elementor">
			<div class="tf-compare-widget">
				<div class="inner-item">
					<?php while ( $query->have_posts() ) :
						$query->the_post(); ?>
							<?php
								$attr['settings'] = $settings;
								tf_get_template_widget_elementor( "templates/compare/style1", $attr );
							?>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
				<div class="btn-action-compare">
					<?php echo esc_attr( $settings['button_text'] ); ?>
				</div>
			</div>
			<div class="table-compare">
				<div class="overlay"></div>
				<div class="inner-list">
					<div class="close"><i class="icon-autodeal-close"></i></div>
					<ul class="heading-content content-list">
						<li class="preview-s1"><?php esc_html_e( 'Compare', 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_make', 'make'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_model', 'model'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_body', 'body'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( 'Price', 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_condition', 'condition'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_stock_number') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_vin_number') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_year') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_transmission', 'transmission'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_drive_type', 'drive type'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_engine_size') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_cylinders', 'cylinders'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_fuel_type', 'fuel type'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_door') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_color', 'Color'), 'tf-car-listing' ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_seat') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_city_mpg') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_highway_mpg') ); ?></li>
						<li><?php esc_html_e( get_option('custom_name_mileage') ); ?></li>
					</ul>
				<?php while ( $query->have_posts() ) :
							$query->the_post(); ?>
								<?php
									$attr['settings'] = $settings;
									tf_get_template_widget_elementor( "templates/compare/list", $attr );
									?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}