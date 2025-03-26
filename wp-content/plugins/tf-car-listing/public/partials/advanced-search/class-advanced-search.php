<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Advanced_Search' ) ) {
	class Advanced_Search {
		public function tfcl_enqueue_style_advanced_search() {
			wp_enqueue_style( 'tfcl-range-slider', TF_PLUGIN_URL . 'public/assets/css/range-slider.css' );
			wp_enqueue_style( 'tfcl-shortcode-advanced', TF_PLUGIN_URL . 'public/assets/css/shortcode-advanced-search.css' );
		}

		public function tfcl_enqueue_script_advanced_search() {
			$tfcl_listing_advanced_search_vars = array(
				'ajaxUrl'     => TF_AJAX_URL,
				'inElementor' => false,

			);
			wp_enqueue_script( 'tfcl-advanced-search-form', TF_PLUGIN_URL . 'public/assets/js/advanced-search.js', array( 'jquery' ), null, true );
			wp_localize_script( 'tfcl-advanced-search-form', 'advancedSearchVars', $tfcl_listing_advanced_search_vars );
			wp_enqueue_script( 'tfcl-range-slider', TF_PLUGIN_URL . 'public/assets/js/range-slider.js' );

		}
		public function tfcl_advanced_search_shortcode() {
			ob_start();
			tfcl_get_template_with_arguments( "advanced-search/advanced-search.php" );
			return ob_get_clean();
		}

		public function tfcl_listing_advanced_search_form() {
			tfcl_get_template_with_arguments( "shortcodes/advanced-search/advanced-search-form.php" );
		}

		public function tfcl_mapping_make_model_ajax() {
			if ( ! isset( $_POST['make'] ) ) {
				return;
			}
			$make = wp_unslash( $_POST['make'] );
			$type = isset( $_POST['type'] ) ? wp_unslash( $_POST['type'] ) : '';

			if ( ! empty( $make ) ) {
				$taxonomy_terms = get_categories(
					array(
						'taxonomy'   => 'model',
						'orderby'    => 'name',
						'order'      => 'ASC',
						'hide_empty' => false,
						'parent'     => 0,
						'meta_query' => array(
							array(
								'key'     => 'model_of_make',
								'value'   => $make,
								'compare' => '=',
							)
						)
					)
				);

				array_unshift( $taxonomy_terms, (object) array(
					'term_id'          => 0,
					'name'             => esc_html__( 'None', 'tf-car-listing' ),
					'slug'             => '',
					'taxonomy'         => 'model',
					'term_group'       => 0,
					'term_taxonomy_id' => 0,
					'parent'           => 0,
					'count'            => 0,
					'filter'           => 'raw',
				) );

				$selected_index = count( $taxonomy_terms ) >= 2 ? 1 : 0;
			} else {
				$taxonomy_terms = tfcl_get_categories( 'model' );
				array_unshift( $taxonomy_terms, (object) array(
					'term_id'          => 0,
					'name'             => esc_html__( 'None', 'tf-car-listing' ),
					'slug'             => '',
					'taxonomy'         => 'model',
					'term_group'       => 0,
					'term_taxonomy_id' => 0,
					'parent'           => 0,
					'count'            => 0,
					'filter'           => 'raw',
				) );
				$selected_index = 0;
			}

			$html = '';

			if ( ! empty( $taxonomy_terms ) ) {
				if ( isset( $_POST['is_slug'] ) && ( $_POST['is_slug'] == '0' ) ) {
					foreach ( $taxonomy_terms as $index => $term ) {
						$selected = ( $type == 1 && $index === $selected_index ) ? ' selected' : '';
						$html .= '<option value="' . esc_attr( $term->term_id ) . '"' . $selected . '>' . esc_html( $term->name ) . '</option>';
					}
				} else {
					foreach ( $taxonomy_terms as $index => $term ) {
						$selected = ( $type == 1 && $index === $selected_index ) ? ' selected' : '';
						$html .= '<option value="' . esc_attr( $term->slug ) . '"' . $selected . '>' . esc_html( $term->name ) . '</option>';
					}
				}
			} else {
				$html .= '<option value="">' . esc_html__( 'None', 'tf-car-listing' ) . '</option>';
			}

			echo wp_kses( $html, array(
				'option' => array(
					'value'    => true,
					'selected' => true
				)
			) );
			wp_die();
		}

		public function tfcl_get_quantity_listing_ajax() {
			$args = array(
				'post_type'           => 'listing',
				'ignore_sticky_posts' => 1,
				'post_status'         => 'publish',
			);

			if ( isset( $_GET['queryData'] ) ) {
				$query_data = sanitize_text_field( $_GET['queryData'] );
				parse_str( $query_data, $parsed_data );
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

				foreach ( $parsed_data as $key => $value ) {
					switch ( $key ) {
						case 'min-price':
							$this->add_price_query( $metabox_query, $value, $key, 'regular_price' );
							break;
						case 'max-price':
							$this->add_price_query( $metabox_query, $value, $key, 'regular_price' );
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

				wp_send_json(
					array(
						'total_post' => $total_post,
						''
					)
				);
				wp_die();
			}
		}

		public function add_price_query( &$metabox_query, $value, $key, $type_price ) {
			$price = doubleval( sanitize_text_field( $value ) );
			if ( $price >= 0 ) {
				if ( $key === 'min-price' ) {
					$metabox_query[] = array(
						'key'     => $type_price,
						'value'   => $price,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					);
				} elseif ( $key === 'max-price' ) {
					$metabox_query[] = array(
						'key'     => $type_price,
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