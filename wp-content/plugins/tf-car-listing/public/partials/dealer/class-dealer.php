<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Dealer_Public' ) ) {
	class Dealer_Public {

		public function __construct() {
		}

		// register style for dealer
		public function tfcl_enqueue_dealer_style() {
			wp_register_style( 'dealer-style', TF_PLUGIN_URL . 'public/assets/css/dealer.css', array(), '', 'all' );
		}

		public function tfcl_enqueue_dealer_scripts() {
			$dealer_filter_listing_nonce = wp_create_nonce( 'dealer_filter_listing_nonce' );
			// pass parameter to handle at client
			wp_register_script( 'dealer-script', TF_PLUGIN_URL . 'public/assets/js/dealer.js', array( 'jquery' ), null, true );
			wp_localize_script(
				'dealer-script',
				'dealer_variables',
				array(
					'ajax_url'                    => admin_url( 'admin-ajax.php' ),
					'dealer_filter_listing_nonce' => $dealer_filter_listing_nonce
				)
			);
		}

		public static function tfcl_get_dealer_info_by_id( $id ) {
			$args  = array(
				'post_type'   => 'dealer',
				'post_status' => 'publish',
				'orderby'     => 'date',
				'order'       => 'DESC',
				'p'           => $id
			);
			$query = new WP_Query( $args );
			$data  = array();
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$post_id             = get_the_ID();
					$post_title          = get_the_title();
					$post_content        = get_the_content();
					$post_date           = get_the_date();
					$data['dealer_name'] = $post_title;
				}
				wp_reset_postdata();
			} else {
				echo esc_html__( 'Dealer not found.', 'tf-car-listing' );
			}
			return $data;
		}

		public static function tfcl_get_dealer_info() {
			global $post;
			$data = array();
			if ( 'dealer' == get_post_type() ) {
				$dealer_id             = get_the_ID();
				$dealer_post_meta_data = get_post_custom( $dealer_id );

				$data['custom_dealer_image_size_single'] = tfcl_get_option( 'custom_dealer_image_size_single', '350x210' );
				$data['dealer_full_name']                = isset( $dealer_post_meta_data['dealer_full_name'] ) ? $dealer_post_meta_data['dealer_full_name'][0] : '';
				$data['dealer_full_name']                = empty( get_the_title( $dealer_id ) ) ? $data['dealer_full_name'] : get_the_title( $dealer_id );
				$data['dealer_description']              = isset( $dealer_post_meta_data['dealer_des_info'] ) ? $dealer_post_meta_data['dealer_des_info'][0] : '';
				$data['dealer_company']                  = isset( $dealer_post_meta_data['dealer_company_name'] ) ? $dealer_post_meta_data['dealer_company_name'][0] : '';
				$data['dealer_logo']                     = isset( $dealer_post_meta_data['dealer_logo'] ) ? $dealer_post_meta_data['dealer_logo'][0] : '';
				$data['dealer_job']                      = isset( $dealer_post_meta_data['dealer_job'] ) ? $dealer_post_meta_data['dealer_job'][0] : '';
				$data['dealer_email']                    = isset( $dealer_post_meta_data['dealer_email'] ) ? $dealer_post_meta_data['dealer_email'][0] : '';
				$data['dealer_phone']                    = isset( $dealer_post_meta_data['dealer_phone_number'] ) ? $dealer_post_meta_data['dealer_phone_number'][0] : '';
				$data['dealer_location']                 = isset( $dealer_post_meta_data['dealer_location'] ) ? $dealer_post_meta_data['dealer_location'][0] : '';
				$data['dealer_socials']                  = isset( $dealer_post_meta_data['dealer_socials'] ) ? $dealer_post_meta_data['dealer_socials'][0] : '';
				$data['dealer_avatar']                   = isset( $dealer_post_meta_data['dealer_avatar'] ) ? $dealer_post_meta_data['dealer_avatar'][0] : '';
				$data['dealer_position']                 = isset( $dealer_post_meta_data['dealer_position'] ) ? $dealer_post_meta_data['dealer_position'][0] : '';
				$data['dealer_office_number']            = isset( $dealer_post_meta_data['dealer_office_number'] ) ? $dealer_post_meta_data['dealer_office_number'][0] : '';
				$data['dealer_office_address']           = isset( $dealer_post_meta_data['dealer_office_address'] ) ? $dealer_post_meta_data['dealer_office_address'][0] : '';
				$data['dealer_location']                 = empty( $dealer_office_address ) ? $data['dealer_location'] : $dealer_office_address;
				$data['dealer_licenses']                 = isset( $dealer_post_meta_data['dealer_licenses'] ) ? $dealer_post_meta_data['dealer_licenses'][0] : '';
				$data['dealer_facebook']                 = isset( $dealer_post_meta_data['dealer_facebook'] ) ? $dealer_post_meta_data['dealer_facebook'][0] : '';
				$data['dealer_twitter']                  = isset( $dealer_post_meta_data['dealer_twitter'] ) ? $dealer_post_meta_data['dealer_twitter'][0] : '';
				$data['dealer_linkedin']                 = isset( $dealer_post_meta_data['dealer_linkedin'] ) ? $dealer_post_meta_data['dealer_linkedin'][0] : '';
				$data['dealer_website']                  = isset( $dealer_post_meta_data['dealer_website'] ) ? $dealer_post_meta_data['dealer_website'][0] : '';
				$data['dealer_instagram']                = isset( $dealer_post_meta_data['dealer_instagram'] ) ? $dealer_post_meta_data['dealer_instagram'][0] : '';
				$data['dealer_pinterest']                = isset( $dealer_post_meta_data['dealer_pinterest'] ) ? $dealer_post_meta_data['dealer_pinterest'][0] : '';
				$data['dealer_vimeo']                    = isset( $dealer_post_meta_data['dealer_vimeo'] ) ? $dealer_post_meta_data['dealer_vimeo'][0] : '';
				$data['dealer_youtube']                  = isset( $dealer_post_meta_data['dealer_youtube'] ) ? $dealer_post_meta_data['dealer_youtube'][0] : '';
				$data['dealer_tiktok']                   = isset( $dealer_post_meta_data['dealer_tiktok'] ) ? $dealer_post_meta_data['dealer_tiktok'][0] : '';
				$data['dealer_user_id']                  = isset( $dealer_post_meta_data['dealer_user_id'] ) ? $dealer_post_meta_data['dealer_user_id'][0] : '';
				$data['user']                            = get_user_by( 'id', $data['dealer_user_id'] );
				$data['dealer_id']                       = $dealer_id;
			}

			if ( empty( $user ) ) {
				$data['dealer_user_id'] = 0;
			}

			return $data;
		}

		public static function tfcl_get_list_dealer( $get_all_list = false ) {
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$args = array(
				'post_type'   => 'dealer',
				'post_status' => 'publish'
			);

			if ( $get_all_list ) {
				$args['posts_per_page'] = -1;
				$args['paged']          = $paged;
			} else {
				$args['posts_per_page'] = tfcl_get_option( 'item_per_page_archive_dealer' );
				$args['paged']          = $paged;
			}

			if ( ! empty( $_REQUEST['orderBy'] ) ) {
				$selected_order = wp_unslash( $_REQUEST['orderBy'] );
				switch ( $selected_order ) {
					case 'name_asc':
						$args['orderby'] = 'title';
						$args['order'] = 'asc';
						break;
					case 'name_desc':
						$args['orderby'] = 'title';
						$args['order'] = 'desc';
						break;
					default:
						$args['orderby'] = 'date';
						$args['order'] = 'desc';
						break;
				}
			}

			$query         = new WP_Query( $args );
			$max_num_pages = $query->max_num_pages;
			$data          = array();
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$dealer_id        = get_the_ID();
					$dealer_meta_data = get_post_custom( $dealer_id );
					$post_data        = array(
						'ID'               => $dealer_id,
						'title'            => get_the_title(),
						'permalink'        => get_permalink(),
						'dealer_meta_data' => $dealer_meta_data

					);
					$data[]           = $post_data;
				}
				wp_reset_postdata();
			}
			return [ 
				'data'          => $data,
				'max_num_pages' => $max_num_pages
			];
		}

		// get template property for single dealer
		public function tfcl_single_dealer_property() {
			tfcl_get_template_with_arguments( 'single-dealer/dealer-property.php', $this->tfcl_get_dealer_info() );
		}

		public function tfcl_single_dealer_info() {
			tfcl_get_template_with_arguments( 'single-dealer/dealer-info-content.php', $this->tfcl_get_dealer_info() );
		}

		public function tfcl_single_dealer_review() {
			wp_reset_postdata();
			$dealer_id = get_the_ID();
			tfcl_get_template_with_arguments( 'single-dealer/dealer-review.php', array(
				'dealer_id' => $dealer_id
			) );
		}

		public function tfcl_dealer_add_new_comment() {
			tfcl_get_template_with_arguments( 'single-dealer/add_new_review.php' );
		}

		// shortcode listing of dealer
		public function tfcl_listing_dealer_shortcode( $atts ) {
			$dealer_id = '';
			if ( is_singular( 'dealer' ) ) {
				wp_reset_postdata();
				$dealer_id = (int) get_the_ID();
			} else {
				$user_id   = get_current_user_id();
				$dealer_id = get_user_meta( $user_id, 'author_dealer_id', true ) ? get_user_meta( $user_id, 'author_dealer_id', true ) : '';
			}

			extract(
				shortcode_atts( array(
					'heading' => ''
				), $atts )
			);

			$heading_default = tfcl_get_option( 'heading_listing_dealer_shortcode' );
			if ( empty( $heading ) ) {
				if ( ! empty( $heading_default ) ) {
					$heading = $heading_default;
				}
			}

			$info_dealer = $this->tfcl_get_dealer_info();

			$list_order = array(
				'date_esc'  => esc_html__( 'Recently Added', 'tf-car-listing' ),
				'name_desc' => esc_html__( 'Sort by name (A-Z)', 'tf-car-listing' ),
				'name_asc'  => esc_html__( 'Sort by name (Z-A)', 'tf-car-listing' ),
			);

			ob_start();
			if ( ! empty( $dealer_id ) ) {
				tfcl_get_template_with_arguments(
					'shortcodes/dealer/listing-dealer.php',
					array(
						'dealer_id'   => $dealer_id,
						'heading'     => $heading,
						'info_dealer' => $info_dealer,
						'list_order'  => $list_order
					)
				);
			} else {
				echo esc_html__( 'Cannot found dealer!', 'tf-car-listing' );
			}
			return ob_get_clean();
		}

		// shortcode list dealer
		public function tfcl_list_all_dealer_shortcode( $atts ) {
			extract(
				shortcode_atts( array(
					'heading' => ''
				), $atts )
			);
			wp_enqueue_style( 'dealer-style' );
			$list_dealer   = $this->tfcl_get_list_dealer();
			$max_num_pages = $list_dealer['max_num_pages'];
			ob_start();
			tfcl_get_template_with_arguments(
				'shortcodes/dealer/list-dealer.php',
				array(
					'heading'       => $heading,
					'list_dealer'   => $list_dealer['data'],
					'max_num_pages' => $max_num_pages
				)
			);
			return ob_get_clean();
		}

		public function tfcl_get_all_listing_by_condition_ajax() {
			check_ajax_referer( 'dealer_filter_listing_nonce', 'nonce' );

			if ( isset( $_POST['condition'] ) ) {
				$condition = sanitize_text_field( $_POST['condition'] );
				$dealer_id = isset( $_POST['dealer_id'] ) ? $_POST['dealer_id'] : '';
				if ( ! empty( $dealer_id ) ) {
					wp_reset_postdata();
					$args          = array(
						'post_type'      => 'listing',
						'posts_per_page' => -1,
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'   => 'listing_dealer_info',
								'value' => $dealer_id
							)
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'condition',
								'field'    => 'slug',
								'terms'    => $condition,
							),
						),
					);
					$listing_query = new WP_Query( $args );
					if ( $listing_query->have_posts() ) {
						ob_start();
						while ( $listing_query->have_posts() ) {
							$listing_query->the_post();
							$listing_id                  = get_the_ID();
							$listing_regular_price_value = get_post_meta( $listing_id, 'regular_price', true );
							$listing_sale_price_value    = get_post_meta( $listing_id, 'sale_price', true );
							$listing_price_prefix        = get_post_meta( $listing_id, 'price_prefix', true );
							$listing_price_suffix        = get_post_meta( $listing_id, 'price_suffix', true );
							$listing_address             = get_post_meta( $listing_id, 'listing_address', true );
							$car_price_unit              = get_post_meta( $listing_id, 'listing_price_unit', true );
							$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;

							$listing_date                = get_post_meta( $listing_id, 'year', true );
							$measurement_units           = tfcl_get_option( 'measurement_units' ) == 'custom' ? tfcl_get_option( 'custom_measurement_units' ) : tfcl_get_option( 'measurement_units' );
							$listing_mileage             = get_post_meta( $listing_id, 'mileage', true ) ? get_post_meta( $listing_id, 'mileage', true ) . ' ' . $measurement_units : 0;
							$listing_fuel_type           = get_the_terms( $listing_id, 'fuel-type', true );
							$listing_fuel_type_att       = ! empty( $listing_fuel_type[0]->name ) ? $listing_fuel_type[0]->name : 'no infor';
							$listing_transmission        = get_the_terms( $listing_id, 'transmission' );
							$listing_transmission_att    = ! empty( $listing_transmission[0]->name ) ? $listing_transmission[0]->name : 'no infor';
							$listing_body                = get_the_terms( $listing_id, 'body', true );
							$listing_body_att            = ! empty( $listing_body[0]->name ) ? $listing_body[0]->name : '';
							$listing_features            = get_the_terms( $listing_id, 'features' );
							$is_featured                 = get_post_meta( $listing_id, 'car_featured', true );
							$listing_features_att        = ! empty( $listing_features[0]->name ) ? $listing_features[0]->name : '';
							$listing_gallery_images      = get_post_meta( $listing_id, 'gallery_images', true ) ? get_post_meta( $listing_id, 'gallery_images', true ) : '';
							$listing_thumb               = tfcl_image_resize_id( get_post_thumbnail_id( $listing_id ), '425', '338', true );
							$listing_gallery_images      = get_sources_listing_gallery_images( $listing_gallery_images );
							if ( is_array( $listing_gallery_images ) ) {
								if ( attachment_url_to_postid( $listing_thumb ) != attachment_url_to_postid( $listing_gallery_images[0] ) ) {
									array_unshift( $listing_gallery_images, $listing_thumb );
								}
							}

							global $current_user;
							wp_get_current_user();
							$check_is_favorite = false;
							$user_id           = $current_user->ID;
							$my_favorites      = get_user_meta( $user_id, 'favorites_listing', true );
							if ( ! empty( $my_favorites ) ) {
								$check_is_favorite = array_search( $listing_id, $my_favorites );
							}

							$icon_favorite     = apply_filters( 'tfcl_icon_favorite', 'far fa-bookmark' );
							$icon_not_favorite = apply_filters( 'tfcl_icon_not_favorite', 'far fa-bookmark' );

							if ( $check_is_favorite !== false ) {
								$css_class = $icon_favorite;
								$title     = esc_attr__( 'It is your favorite', 'tf-car-listing' );
							} else {
								$css_class = $icon_not_favorite;
								$title     = esc_attr__( 'Add to Favorite', 'tf-car-listing' );
							}
							$featured_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' ).'/?condition=all&enable-search-features=0&featured=true' : '#';
							$year_url = !empty(tfcl_get_permalink( 'advanced_search_page' )) ? tfcl_get_permalink( 'advanced_search_page' )."?condition=all&enable-search-features=0&min-year=".$listing_date."&max-year=".$listing_date."" : '#';
							?>
							<div class="listing-post listing-post-<?php the_ID(); ?>">
								<div class="featured-listing">
									<div class="group-meta">
										<?php if ( $is_featured ) : ?>
											<a href="<?php echo esc_url($featured_url); ?>" target="_blank">
										<span class="features"><?php esc_html_e( 'Featured', 'tf-car-listing' ); ?></span>
									</a>
										<?php endif; ?>
										<?php if ( tfcl_get_option( 'enable_counter_gallery') == 'y' ) : ?>
											<?php if ( ! empty( $listing_gallery_images ) ) : ?>
												<span class="count-list-gallery view-gallery" data-mfp-event
													data-gallery="<?php echo esc_attr( json_encode( $listing_gallery_images ) ); ?>"><img
														src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/camera.svg'; ?>"
														alt="icon-map"><?php echo esc_html( count( $listing_gallery_images ) ); ?></span>
											<?php endif; ?>
										<?php endif; ?>
										<?php if (tfcl_get_option( 'enable_year_listing') == 'y' ) : ?>
											<?php if ( ! empty( $listing_date )) : ?>
												<a href="<?php echo esc_url($year_url); ?>" target="_blank"><span class="date-car"><?php echo esc_html( $listing_date ); ?></span></a>
											<?php endif; ?>
										<?php endif; ?>
									</div>
									<?php if ( is_array( $listing_gallery_images ) && count( $listing_gallery_images ) > 1 ) : ?>
										<a href="<?php echo get_the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
											<div class="listing-images">
												<div class="hover-listing-image">
													<div class="wrap-hover-listing">
														<?php foreach ( $listing_gallery_images as $key => $value ) : ?>
															<div class="listing-item">
																<div class="images">
																	<img src="<?php echo esc_attr( $value ); ?>"
																		class="swiper-image lazy tfcl-light-gallery" alt="images">
																</div>
															</div>
														<?php endforeach; ?>
														<div class="bullet-hover-listing">
															<?php foreach ( $listing_gallery_images as $key => $value ) : ?>
																<div class="bl-item"></div>
															<?php endforeach; ?>
														</div>
													</div>
												</div>
											</div>
										</a>
									<?php endif; ?>
								</div>
								<div class="content">
									<?php if ( ! empty( $listing_body_att ) ) : ?>
										<a href="<?php echo esc_url( get_term_link( $listing_body[0] ) ) ?>" class="car-body"><?php echo esc_html( $listing_body_att, 'tf-car-listing' ); ?></a>
									<?php endif; ?>
									<h3 class="title">
										<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
									</h3>
									<div class="price">
										<span class="sale_price">
											<?php if ( $listing_price_prefix != '' ) : ?>
												<?php echo $listing_price_prefix; ?>
											<?php endif; ?>
											<?php echo tfcl_format_price( $listing_sale_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
											<?php if ( $listing_price_suffix != '' ) : ?>
												<?php echo $listing_price_suffix; ?>
											<?php endif; ?>
										</span>
										<span class="regular_price">
											<?php if ( $listing_price_prefix != '' ) : ?>
												<?php echo $listing_price_prefix; ?>
											<?php endif; ?>
											<?php echo tfcl_format_price( $listing_regular_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
											<?php if ( $listing_price_suffix != '' ) : ?>
												<?php echo $listing_price_suffix; ?>
											<?php endif; ?>
										</span>
									</div>
									<?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y' || tfcl_get_option( 'enable_mileages_listing') == 'y' || tfcl_get_option( 'enable_transmission_listing') == 'y' ) : ?>
									<div class="description">
										<ul>
										<?php if ( tfcl_get_option( 'enable_fuel_type_listing') == 'y') :?>
											<li class="listing-information fuel">
												<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/fuel.svg'; ?>"
													alt="icon-fuel">
												<div class="inner">
													<span><?php esc_html_e( 'Fuel type', 'tf-car-listing' ); ?></span>
													<p><?php echo esc_html( $listing_fuel_type_att, 'tf-car-listing' ); ?></p>
												</div>
											</li>
										<?php endif; ?>
										<?php if ( tfcl_get_option( 'enable_mileages_listing') == 'y') :?>
											<li class="listing-information mileage">
												<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/dashboard.svg'; ?>"
													alt="icon-mileage">
												<div class="inner">
													<span><?php esc_html_e( 'Mileage', 'tf-car-listing' ); ?></span>
													<p><?php echo esc_html( $listing_mileage ); ?></p>
												</div>
											</li>
										<?php endif; ?>
										<?php if ( tfcl_get_option( 'enable_transmission_listing') == 'y') :?>
											<li class="listing-information transmission">
												<img src="<?php echo TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/icons/transmission.svg'; ?>"
													alt="icon-transmission">
												<div class="inner">
													<span><?php esc_html_e( 'Transmission', 'tf-car-listing' ); ?></span>
													<p><?php echo esc_html( $listing_transmission_att, 'tf-car-listing' ); ?></p>
												</div>
											</li>
										<?php endif; ?>
										</ul>
									</div>
									<?php endif; ?>
									<div class="bottom-content">
										<a href="<?php echo esc_attr( get_the_permalink() ); ?>"><?php echo esc_html(tfcl_get_option( 'text_card_button', 'View Details')) ?> <i
												class="icon-autodeal-arrow-right"></i></a>
									<?php if ( tfcl_get_option( 'enable_compare') == 'y' || tfcl_get_option( 'enable_favorite') == 'y' ) : ?>
										<ul class="list-controller">
											<?php if ( tfcl_get_option( 'enable_favorite') == 'y' ) : ?>
												<li>
													<?php do_action( 'tfcl_favorite_action' ); ?>
												</li>
												<?php endif; ?>
											<?php if ( tfcl_get_option( 'enable_compare') == 'y' ) : ?>
												<li>
													<a class="compare tfcl-compare-listing hv-tool" href="javascript:void(0)"
														data-listing-id="<?php the_ID() ?>" data-toggle="tooltip"
														data-tooltip="<?php echo esc_attr_e( 'Add Compare', 'tf-car-listing' ); ?>"
														title="<?php echo esc_attr_e( 'Compare', 'tf-car-listing' ); ?>">
														<i class="icon-autodeal-compare2"></i>
													</a>
												</li>
											<?php endif; ?>
										</ul>
									<?php endif; ?>
									</div>
								</div>
							</div>
							<?php
						}
						$html = ob_get_clean();
						wp_die( $html );
					} else {
						wp_die( 'No data found!' );
					}
				} else {
					wp_die( 'Not found dealer' );
				}
			}
		}

		// shortcode filter list Listing of dealer 
		public function tfcl_filter_list_dealer_shortcode( $atts ) {
			$dealer_id         = '';
			$list_condition    = tfcl_get_taxonomies( 'condition' );
			$default_condition = array_key_first( $list_condition );
			if ( is_singular( 'dealer' ) ) {
				wp_reset_postdata();
				$dealer_id = get_the_ID();
			} else {
				$user_id   = get_current_user_id();
				$dealer_id = get_user_meta( $user_id, 'author_dealer_id', true );
			}

			ob_start();
			if ( empty( $dealer_id ) ) {
				echo esc_html__( 'Cannot found data!', 'tf-car-listing' );
			} else {
				tfcl_get_template_with_arguments(
					'shortcodes/dealer/filter-list-listing-dealer.php',
					array(
						'list_condition'    => $list_condition,
						'default_condition' => $default_condition,
						'dealer_id'         => $dealer_id
					)
				);
			}
			return ob_get_clean();
		}
	}
}