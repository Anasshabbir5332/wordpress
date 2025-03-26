<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Public_Taxonomy' ) ) {
	class Public_Taxonomy {
		public function tfcl_enqueue_taxonomy_scripts() {
			$taxonomy_variables = array(
				'plugin_url'       => TF_PLUGIN_URL,
				'ajax_url'         => TF_AJAX_URL,
				'home_url'         => home_url(),
				'listing_page_url' => tfcl_get_permalink( 'listing_page' ),
				'text_results'     => esc_html__( 'results', 'tf-car-listing' ),
				'text_result'      => esc_html__( 'result', 'tf-car-listing' ),
			);

			wp_enqueue_script( 'archive-taxonomy-js', TF_PLUGIN_URL . 'public/assets/js/taxonomy.js', array( 'jquery' ), null, true );
			wp_localize_script( 'archive-taxonomy-js', 'taxonomy_variables', $taxonomy_variables );
		}

		public function tfcl_enqueue_taxonomy_styles() {
			wp_enqueue_style( 'archive-taxonomy-style', TF_PLUGIN_URL . 'public/assets/css/taxonomy.css', array(), '', 'all' );
		}

		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function tfcl_filter_archive_listing_ajax() {
			$item_per_page_archive_listing = tfcl_get_option( 'item_per_page_archive_listing', '-1' );
			$args                          = array(
				'post_type'           => 'listing',
				'posts_per_page'      => $item_per_page_archive_listing,
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
			);

			// options
			$layout_archive_listing = isset( $_GET['layoutArchiveListing'] ) ? wp_unslash( $_GET['layoutArchiveListing'] ) : tfcl_get_option( 'layout_archive_listing' );
			$column_layout_default  = $layout_archive_listing == 'grid' ? tfcl_get_option( 'column_layout_grid' ) : tfcl_get_option( 'column_layout_list' );
			$column_layout          = isset( $_GET['columnLayout'] ) ? wp_unslash( $_GET['columnLayout'] ) : $column_layout_default;
			$css_class_col          = 'col-md-4 col-sm-3 col-xs-12';

			if ( $layout_archive_listing == 'list' ) {
				switch ( $column_layout ) {
					case '1':
						$css_class_col = 'col-md-12';
						break;
					case '2':
						$css_class_col = 'col-md-6';
						break;
					default:
						break;
				}
			}

			if ( $layout_archive_listing == 'grid' ) {
				switch ( $column_layout ) {
					case '2':
						$css_class_col = 'col-md-6';
						break;
					case '3':
						$css_class_col = 'col-md-4';
						break;
					case '4':
						$css_class_col = 'col-xl-3 col-md-6 col-6';
						break;
					default:
						break;
				}
			}

			if ( isset( $_GET['queryData'] ) ) {
				$query_data = sanitize_text_field( $_GET['queryData'] );
				parse_str( $query_data, $parsed_data );
				$page         = isset( $parsed_data['page'] ) ? intval( $parsed_data['page'] ) : '';
				$current_tax  = isset( $_GET['currentTax'] ) ? wp_unslash( $_GET['currentTax'] ) : '';
				$current_term = isset( $_GET['currentTerm'] ) ? wp_unslash( $_GET['currentTerm'] ) : '';
				if ( $page > 0 ) {
					$args['paged'] = $page;
				}

				$taxonomy_query = $metabox_query = array();
				$taxonomies = array(
					'condition',
					'make',
					'model',
					'body',
					'cylinders',
					'transmission',
					'features',
				);

				if ( $current_tax != '' && $current_term != '' ) {
					if ( ! array_key_exists( $current_tax, $parsed_data ) ) {
						$this->add_taxonomy_query( $taxonomy_query, $current_tax, $current_term );
					}
				}

				foreach ( $parsed_data as $key => $value ) {
					switch ( $key ) {
						case 'min-price':
						case 'max-price':
							$this->add_price_query( $metabox_query, $value, $key );
							break;
						case 'min-year':
							$this->add_numeric_meta_query( $metabox_query, $value, 'year', '>=' );
							break;
						case 'max-year':
							$this->add_numeric_meta_query( $metabox_query, $value, 'year', '<=' );
							break;
						case 'min-mileage':
							$this->add_numeric_meta_query( $metabox_query, $value, 'mileage', '>=' );
							break;
						case 'max-mileage':
							$this->add_numeric_meta_query( $metabox_query, $value, 'mileage', '<=' );
							break;
						case 'min-door':
							$this->add_numeric_meta_query( $metabox_query, $value, 'door', '>=' );
							break;
						case 'max-door':
							$this->add_numeric_meta_query( $metabox_query, $value, 'door', '<=' );
							break;
						case 'door':
							$this->add_numeric_meta_query( $metabox_query, $value, 'door', '=' );
							break;
						case 'car_color':
						case 'driver_type':
							$this->add_taxonomy_query( $taxonomy_query, 'drive-type', $value );
							break;
						case 'fuel_type':
							$this->add_taxonomy_query( $taxonomy_query, $key, $value );
							break;
						case 'featured':
							$this->add_featured_query( $metabox_query, $value );
							break;
						case 'orderBy':
							switch ( $value ) {
								case 'name_asc':
									$args['orderby'] = 'title';
									$args['order'] = 'asc';
									break;
								case 'name_desc':
									$args['orderby'] = 'title';
									$args['order'] = 'desc';
									break;
								case 'price_asc':
									$args['meta_key'] = 'regular_price';
									$args['orderby'] = 'meta_value_num';
									$args['order'] = 'asc';
									break;
								case 'price_desc':
									$args['meta_key'] = 'regular_price';
									$args['orderby'] = 'meta_value_num';
									$args['order'] = 'desc';
									break;
								default:
									$args['orderby'] = 'date';
									$args['order'] = 'desc';
									break;
							}
							break;
						case 'keyword':
							if ( $value !== '' ) {
								$keyword_field = tfcl_get_option( 'search_criteria_keyword_field', 'criteria_title' );

								$value = sanitize_text_field( $value );
								if ( $keyword_field === 'criteria_address' ) {
									$metabox_query[] = array(
										'key'     => 'listing_address',
										'value'   => $value,
										'type'    => 'CHAR',
										'compare' => 'LIKE',
									);
								}

								if ( $keyword_field == 'criteria_title' ) {
									$args['s'] = $value;
								}
							}
							break;
						case 'engine_size':
							if ( $value !== '' ) {

								$value = sanitize_text_field( $value );

								$metabox_query[] = array(
										'key'     => 'engine_size',
										'value'   => $value,
										'type'    => 'CHAR',
										'compare' => 'LIKE',
								);
							}
							break;
						default:
							if ( in_array( $key, $taxonomies ) ) {
								$this->add_taxonomy_query( $taxonomy_query, $key, $value );
							}
							break;
					}
				}

				$this->apply_tax_and_meta_queries( $args, $taxonomy_query, $metabox_query );

				$query      = new WP_Query( $args );
				$total_post = $query->found_posts;
				$post_count = $query->post_count;
				$response   = array();
				if ( $query->have_posts() ) {
					ob_start();
					while ( $query->have_posts() ) :
						$query->the_post();
						$listing_id = get_the_ID();
						$attach_id  = get_post_thumbnail_id();
						tfcl_get_template_with_arguments(
							'listing/card-item-listing.php',
							array(
								'listing_id'    => $listing_id,
								'attach_id'     => $attach_id,
								'css_class_col' => $css_class_col
							)
						);
					?>
					<?php endwhile;
					
					wp_reset_postdata();

					tfcl_pagination_ajax( $query, $page );
					$html     = ob_get_clean();
					$response = array(
						'html'       => $html,
						'total_post' => $total_post,
						'post_count' => $post_count
					);
					wp_send_json( $response );

				?>
				<?php } else {
					$response = array(
						'message' => sprintf( '<div class="item-not-found">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="80" height="80" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m226 251.591 30 30 30 30M286 251.591l-30 30-30 30M375.91 56.591H20c-5.52 0-10 4.47-10 10v350c0 5.52 4.48 10 10 10h64.22" style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M415.915 66.591c12.869 0 12.89-20 0-20-12.869 0-12.89 20 0 20z" fill="var(--theme-primary-color)" opacity="1" data-original="#000000" class=""></path><path d="M139.28 426.591H492c5.52 0 10-4.48 10-10v-350c0-5.53-4.48-10-10-10h-36.085" style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="m197.24 368.631-80.92 80.92c-7.81 7.81-20.48 7.81-28.29 0s-7.81-20.47 0-28.28l80.93-80.93" style="stroke-width:20;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M90 96.589h94.889" style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M10 136.589h492" style="stroke-width:20;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M50 106.589c12.869 0 12.89-20 0-20-12.869 0-12.89 20 0 20z" fill="var(--theme-primary-color)" opacity="1" data-original="#000000" class=""></path><circle cx="256" cy="281.589" r="105" style="stroke-width:20;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></circle></g></svg>						
						<h3>%1$s</h3>
						<p>%2$s</p>
						<span class="btn-clear-filter">%3$s <i class="icon-autodeal-reload"></i></span>
					</div>', esc_html( 'Not found any car based on your search filter', 'tf-car-listing' ), esc_html( 'Try another filter, location or keywords', 'tf-car-listing' ), esc_html( 'Reset filters', 'tf-car-listing' ) ),
					);
					wp_send_json( $response );
				}
				wp_die();
			}
		}

		public function add_price_query( &$metabox_query, $value, $key ) {
			$price = doubleval( sanitize_text_field( $value ) );
			if ( $price >= 0 ) {
				if ( $key === 'min-price' ) {
					$metabox_query[] = array(
						'key'     => 'regular_price',
						'value'   => $price,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					);
				} elseif ( $key === 'max-price' ) {
					$metabox_query[] = array(
						'key'     => 'regular_price',
						'value'   => $price,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					);
				}
			}
		}

		public function add_numeric_meta_query( &$metabox_query, $value, $query_key, $compare ) {
			$numeric_value = doubleval( sanitize_text_field( $value ) );
			if ( $numeric_value >= 0 ) {
				$metabox_query[] = array(
					'key'     => $query_key,
					'value'   => $numeric_value,
					'type'    => 'NUMERIC',
					'compare' => $compare,
				);
			}
		}

		public function add_taxonomy_query( &$taxonomy_query, $taxonomy, $value ) {
			$taxonomy_value = sanitize_text_field( $value );
			if ( ! empty( $taxonomy_value ) && $taxonomy_value !== 'all' ) {
				$taxonomy = str_replace( '_', '-', $taxonomy );
				if ( $taxonomy == 'features' ) {
					if ( ! empty( $taxonomy_value ) ) {
						$features                  = explode( ',', $taxonomy_value );
						$features_taxonomy_queries = array( 'relation' => 'OR' );
						foreach ( $features as $feature ) {
							$features_taxonomy_queries[] = array(
								'taxonomy' => $taxonomy,
								'field'    => 'slug',
								'terms'    => $feature,
								'operator' => 'IN'
							);
						}
						$taxonomy_query[] = $features_taxonomy_queries;
					}
				} else {
					$taxonomy_query[] = array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $taxonomy_value,
					);
				}
			}
		}

		public function add_featured_query( &$metabox_query, $value ) {
			$featured = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
			if ( $featured ) {
				$metabox_query[] = array(
					'key'     => 'car_featured',
					'value'   => true,
					'compare' => '=',
				);
			}
		}

		public function apply_tax_and_meta_queries( &$args, &$taxonomy_query, &$metabox_query ) {
			$taxonomy_count = count( $taxonomy_query );
			if ( $taxonomy_count > 0 ) {
				$args['tax_query'] = array(
					'relation' => 'AND',
					$taxonomy_query,
				);
			}

			$metabox_count = count( $metabox_query );
			if ( $metabox_count > 0 ) {
				$args['meta_query'] = array(
					'relation' => 'AND',
					array(
						'relation' => 'AND',
						$metabox_query,
					),
				);
			}
		}
	}
}