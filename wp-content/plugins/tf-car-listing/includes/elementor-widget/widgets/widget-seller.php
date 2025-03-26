<?php
class Widget_Seller extends \Elementor\Widget_Base {

	protected $social_links;

	protected $social_links_default;

	public function get_name() {
		return 'tf_seller';
	}

	public function get_title() {
		return esc_html__( 'TF Seller', 'tf-car-listing' );
	}

	public function get_icon() {
		return 'eicon-archive';
	}

	public function get_categories() {
		return [ 'themesflat_car_listing_addons' ];
	}

	public function get_style_depends() {
		return [ 'owl-carousel', 'seller-styles' ];
	}

	public function get_script_depends() {
		return [ 'owl-carousel', 'seller-script' ];
	}

	protected function register_controls() {

		$this->social_links = array(
			'facebook_link'  => esc_html__( 'Facebook', 'tf-car-listing' ),
			'twitter_link'   => esc_html__( 'Twitter', 'tf-car-listing' ),
			'youtube_link'   => esc_html__( 'Youtube', 'tf-car-listing' ),
			'instagram_link' => esc_html__( 'Instagram', 'tf-car-listing' ),
			'vimeo_link'     => esc_html__( 'Vimeo', 'tf-car-listing' ),
			'dribble_link'   => esc_html__( 'Dribble', 'tf-car-listing' ),
			'skype_link'     => esc_html__( 'Skype', 'tf-car-listing' ),
			'pinterest_link' => esc_html__( 'Pinterest', 'tf-car-listing' ),
			'tiktok_link'    => esc_html__( 'TikTok', 'tf-car-listing' ),
			'linkedin_link'       => esc_html__( 'Linkedin', 'tf-car-listing' )
		);

		$this->social_links_default = array(
			'facebook_link',
			'twitter_link',
			'linkedin_link',
			'instagram_link'
		);

		// Start Seller Query        
		$this->start_controls_section(
			'section_seller_query',
			[ 
				'label' => esc_html__( 'Query', 'tf-car-listing' ),
			]
		);

		$this->add_control(
			'seller_per_page',
			[ 
				'label'   => esc_html__( 'Seller Per Page', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '4',
			]
		);

		$this->add_control(
			'order_by',
			[ 
				'label'   => esc_html__( 'Order By', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [ 
					'ID'    => esc_html__( 'User ID', 'tf-car-listing' ),
					'name'  => esc_html__( 'User Name', 'tf-car-listing' ),
					'email' => esc_html__( 'Email', 'tf-car-listing' )
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
			'layout',
			[ 
				'label'   => esc_html__( 'Columns', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'lg-column-4',
				'options' => [ 
					'lg-column-1' => esc_html__( '1', 'tf-car-listing' ),
					'lg-column-2' => esc_html__( '2', 'tf-car-listing' ),
					'lg-column-3' => esc_html__( '3', 'tf-car-listing' ),
					'lg-column-4' => esc_html__( '4', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'layout_tablet',
			[ 
				'label'   => esc_html__( 'Columns Tablet', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'md-column-2',
				'options' => [ 
					'md-column-1' => esc_html__( '1', 'tf-car-listing' ),
					'md-column-2' => esc_html__( '2', 'tf-car-listing' ),
					'md-column-3' => esc_html__( '3', 'tf-car-listing' ),
				],
			]
		);

		$this->add_control(
			'layout_mobile',
			[ 
				'label'   => esc_html__( 'Columns Mobile', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'xs-column-1',
				'options' => [ 
					'xs-column-1' => esc_html__( '1', 'tf-car-listing' ),
					'xs-column-2' => esc_html__( '2', 'tf-car-listing' ),
				],
			]
		);

		$this->add_responsive_control(
			'gap_column',
			[ 
				'label'      => esc_html__( 'Gap', 'tf-car-listing' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 
					'px' => [ 
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					]
				],
				'selectors'  => [ 
					'{{WRAPPER}} .tfcl-seller-content .row'   => 'margin-right: -{{SIZE}}{{UNIT}};margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tfcl-seller-content .row>*' => 'padding-right: {{SIZE}}{{UNIT}};padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'choose_seller',
			[ 
				'label'   => esc_html__( 'Choose Seller Type', 'tf-car-listing' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'seller_is_dealer',
				'options' => [ 
					'seller_is_dealer' => esc_html__( 'All Dealers', 'tf-car-listing' ),
				]
			]
		);

		$this->add_control(
			'show_name',
			[ 
				'label'        => esc_html__( 'Show Name', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_position',
			[ 
				'label'        => esc_html__( 'Show Position', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_social',
			[ 
				'label'        => esc_html__( 'Show Social', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'social_media',
			[ 
				'label'       => esc_html__( 'Socials Media Links', 'tf-car-listing' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $this->social_links,
				'label_block' => true,
				'multiple'    => true,
				'default'     => $this->social_links_default,
				'condition'   => [ 
					'show_social' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_phone',
			[ 
				'label'        => esc_html__( 'Show Phone Call', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_email',
			[ 
				'label'        => esc_html__( 'Show Email', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_pagination',
			[ 
				'label'        => esc_html__( 'Show Pagination', 'tf-car-listing' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'tf-car-listing' ),
				'label_off'    => esc_html__( 'Hide', 'tf-car-listing' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		$settings = $this->get_settings_for_display();
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
		
		if ( $settings['choose_seller'] == 'seller_is_dealer' ) {
			$query_args = array(
				'post_type'      => 'dealer',
				'post_status'    => 'publish',
				'posts_per_page' => $settings['seller_per_page'],
				'orderby'        => $settings['order_by'],
				'order'          => $settings['order'],
				'paged'   => $paged,
			);
			$sellers    = get_posts( $query_args );
			$queryPagination = new WP_Query( $query_args );
		} else {
			$query_args = array(
				'orderby' => $settings['order_by'],
				'order'   => $settings['order'],
				'number'  => $settings['seller_per_page'],
				'paged'   => $paged,
			);
			$sellers    = get_users( $query_args );
		}

		$this->add_render_attribute( 'tfcl_seller_wrap', [ 'id' => "tfcl-seller-{$this->get_id()}", 'class' => [ 'tfcl-seller-widget-wrap' ], 'data-tabid' => $this->get_id() ] );

		if ( $sellers ) :
			?>
			<div <?php echo $this->get_render_attribute_string( 'tfcl_seller_wrap' ); ?>>
				<div class="tfcl-seller-content <?php echo esc_attr( $settings['layout'] ); ?> <?php echo esc_attr( $settings['layout_tablet'] ); ?> <?php echo esc_attr( $settings['layout_mobile'] ); ?>">
					<div class="sellers row">
						<!-- handle data seller before render -->
						<?php foreach ( $sellers as $seller ) : ?>
							<?php
							$seller_id = ( $settings['choose_seller'] == 'seller_is_dealer' ) ? get_post_meta( $seller->ID, 'dealer_user_id', true ) : $seller->ID;
							if ( ! empty( $seller_id ) ) {
								$seller_social = $seller_data = array();
								$seller_career = $seller_name = $seller_avatar_url = $seller_link_profile = '';

								if ( $settings['choose_seller'] == 'seller_is_dealer' ) {
									$dealer_id            = $seller->ID;
									$seller_profile_image = get_the_post_thumbnail_url( $dealer_id );
									$seller_name          = get_the_title( $dealer_id );
									$seller_link_profile  = get_the_permalink( $dealer_id );
									$seller_meta   = get_post_meta( $dealer_id );

									if ( ! empty( $seller_meta['dealer_position'] ) ) {
										$seller_career = $seller_meta['dealer_position'][0];
									}

									if ( ! empty( $seller_meta['dealer_phone_number'] ) ) {
										$seller_phone = $seller_meta['dealer_phone_number'][0];
									}

									if ( ! empty( $seller_meta['dealer_email'] ) ) {
										$seller_email = $seller_meta['dealer_email'][0];
									}

									if ( ! empty( $settings['social_media'] ) ) {
										if ( in_array( 'facebook_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-facebook'] = ! empty( $seller_meta['dealer_facebook'][0] ) ? $seller_meta['dealer_facebook'][0] : '';
										}
	
										if ( in_array( 'twitter_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-twitter'] = ! empty( $seller_meta['dealer_twitter'][0] ) ? $seller_meta['dealer_twitter'][0] : '';
										}
	
										if ( in_array( 'youtube_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-youtube'] = ! empty( $seller_meta['dealer_youtube'][0] ) ? $seller_meta['dealer_youtube'][0] : '';
										}
	
										if ( in_array( 'instagram_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-instagram1'] = ! empty( $seller_meta['dealer_instagram'][0] ) ? $seller_meta['dealer_instagram'][0] : '';
										}
	
										if ( in_array( 'vimeo_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-vimeo'] = ! empty( $seller_meta['dealer_vimeo'][0] ) ? $seller_meta['dealer_vimeo'][0] : '';
										}
	
										if ( in_array( 'skype_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-skype'] = ! empty( $seller_meta['user_skype'][0] ) ? $seller_meta['user_skype'][0] : '';
										}
	
										if ( in_array( 'pinterest_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-pinterest'] = ! empty( $seller_meta['dealer_pinterest'][0] ) ? $seller_meta['dealer_pinterest'][0] : '';
										}
	
										if ( in_array( 'tiktok_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-tiktok'] = ! empty( $seller_meta['dealer_tiktok'][0] ) ? $seller_meta['dealer_tiktok'][0] : '';
										}
	
										if ( in_array( 'dribble_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-dribble'] = ! empty( $seller_meta['user_dribble'][0] ) ? $seller_meta['user_dribble'][0] : '';
										}

										if ( in_array( 'linkedin_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-linkedin'] = ! empty( $seller_meta['user_linkedin'][0] ) ? $seller_meta['user_linkedin'][0] : '';
										}
									}
								} else {
									$seller_profile_image = get_the_author_meta( 'profile_image', $seller_id );
									$seller_info          = get_userdata( $seller_id );
									$seller_name          = ! empty( $seller_info ) ? ( $seller_info->first_name . ' ' . $seller_info->last_name ) : '';
									$seller_link_profile  = get_author_posts_url( $seller_id );
									$seller_meta   = get_user_meta( $seller_id );
									
									if ( ! empty( $seller_meta['user_position'] ) ) {
										$seller_career = $seller_meta['user_position'][0];
									}

									if ( ! empty( $seller_meta['user_phone'] ) ) {
										$seller_phone = $seller_meta['user_phone'][0];
									}

									if ( ! empty( $seller_meta['user_email'] ) ) {
										$seller_email = $seller_meta['user_email'][0];
									}

									if ( ! empty( $settings['social_media'] ) ) {
										if ( in_array( 'facebook_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-facebook'] = ! empty( $seller_meta['user_facebook'][0] ) ? $seller_meta['user_facebook'][0] : '';
										}
	
										if ( in_array( 'twitter_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-twitter'] = ! empty( $seller_meta['user_twitter'][0] ) ? $seller_meta['user_twitter'][0] : '';
										}
	
										if ( in_array( 'youtube_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-youtube'] = ! empty( $seller_meta['user_youtube'][0] ) ? $seller_meta['user_youtube'][0] : '';
										}
	
										if ( in_array( 'instagram_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-instagram1'] = ! empty( $seller_meta['user_instagram'][0] ) ? $seller_meta['user_instagram'][0] : '';
										}
	
										if ( in_array( 'vimeo_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-vimeo'] = ! empty( $seller_meta['user_vimeo'][0] ) ? $seller_meta['user_vimeo'][0] : '';
										}
	
										if ( in_array( 'skype_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-skype'] = ! empty( $seller_meta['user_skype'][0] ) ? $seller_meta['user_skype'][0] : '';
										}
	
										if ( in_array( 'pinterest_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-pinterest'] = ! empty( $seller_meta['user_pinterest'][0] ) ? $seller_meta['user_pinterest'][0] : '';
										}
	
										if ( in_array( 'tiktok_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-tiktok'] = ! empty( $seller_meta['user_tiktok'][0] ) ? $seller_meta['user_tiktok'][0] : '';
										}
	
										if ( in_array( 'dribble_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-dribble'] = ! empty( $seller_meta['user_dribble'][0] ) ? $seller_meta['user_dribble'][0] : '';
										}

										if ( in_array( 'linkedin_link', $settings['social_media'] ) ) {
											$seller_social['icon-autodeal-linkedin'] = ! empty( $seller_meta['user_linkedin'][0] ) ? $seller_meta['user_linkedin'][0] : '';
										}
									}
								}
								$seller_avatar_url = ! empty( $seller_profile_image ) ? $seller_profile_image : get_avatar_url( $seller_id );

								$seller_data = array(
									'seller_id'           => $seller_id,
									'seller_avatar_url'   => $seller_avatar_url,
									'seller_social'       => $seller_social,
									'seller_career'       => $seller_career,
									'seller_name'         => $seller_name,
									'seller_phone'         => $seller_phone,
									'seller_email'         => $seller_email,
									'seller_link_profile' => $seller_link_profile
								);

								$attr['settings']    = $settings;
								$attr['seller_data'] = $seller_data;
								tf_get_template_widget_elementor( "templates/seller/style1", $attr );
							}
							?>
						<?php endforeach; ?>
						<?php if ( $settings['show_pagination'] == 'yes' ):?>
							<?php themesflat_pagination_posttype($queryPagination, 'pager'); ?> 
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php else : ?>
			<?php echo esc_html__( 'Not Found', 'tf-car-listing' ); ?>
		<?php endif; ?>
	<?php
	}
}
?>