<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Admin_Taxonomy' ) ) {
	class Admin_Taxonomy {
		private $screen = array();
		function tfcl_get_config_taxonomy_list() {
			$taxonomies = array();

			// custom slug
			$custom_url_listing_condition = tfcl_get_option( 'custom_url_listing_condition', 'condition');
			$custom_url_listing_body = tfcl_get_option( 'custom_url_listing_body', 'body');
			$custom_url_listing_make = tfcl_get_option( 'custom_url_listing_make', 'make');
			$custom_url_listing_model = tfcl_get_option( 'custom_url_listing_model', 'model');
			$custom_url_listing_transmission = tfcl_get_option( 'custom_url_listing_transmission', 'transmission');
			$custom_url_listing_cylinders = tfcl_get_option( 'custom_url_listing_cylinders', 'cylinders');
			$custom_url_listing_drive = tfcl_get_option( 'custom_url_listing_drive', 'drive-type');
			$custom_url_listing_fuel = tfcl_get_option( 'custom_url_listing_fuel', 'fuel-type');
			$custom_url_listing_color = tfcl_get_option( 'custom_url_listing_color', 'car-color');
			$custom_url_listing_features = tfcl_get_option( 'custom_url_listing_features', 'features');
			$custom_url_listing_features_type = tfcl_get_option( 'custom_url_listing_features_type', 'features-type');

			$taxonomies['condition'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_condition', 'condition'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_condition', 'condition'), 'tf-cal-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_condition),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['body'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_body', 'Body'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_body', 'Body'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_body),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['make'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_make', 'Make'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_make', 'Make'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_make),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['model'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_model', 'Model'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_model', 'Model'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_model),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['transmission'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_transmission', 'transmission'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_transmission', 'transmission'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_transmission),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['cylinders'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_cylinders', 'cylinders'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_cylinders', 'cylinders'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_cylinders),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['drive-type'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_drive_type', 'Drive Type'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_drive_type', 'Drive Type'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_drive),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['fuel-type'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_fuel_type', 'Fuel Type'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'meta_box_cb'                     => array( $this, 'tfcl_taxonomy_select_meta_box' ),
				'label'                           => esc_html__( get_option('custom_name_fuel_type', 'Fuel Type'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_fuel),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['car-color'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_color', 'Color'), 'tf-car-listing' ),
				'hierarchical'                    => true,
				'label'                           => esc_html__( get_option('custom_name_color', 'Color'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_color),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			$taxonomies['features-type'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_features_type', 'Features Type'), 'tf-car-listing' ),
				'hierarchical'                    => false,
				'label'                           => esc_html__( get_option('custom_name_features_type', 'Features Type'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_features_type),
				'show_ui'                         => true,
				'show_admin_column'               => false,
				'enable_taxonomy_parent_dropdown' => false,
				'meta_box_cb'                     => false,
			);

			$taxonomies['features'] = array(
				'post_type'                       => array( 'listing' ),
				'singular_name'                   => esc_html__( get_option('custom_name_features', 'Features'), 'tf-car-listing' ),
				'hierarchical'                    => true,
				'label'                           => esc_html( get_option('custom_name_features', 'Features'), 'tf-car-listing' ),
				'rewrite'  	  => array( 'slug' => $custom_url_listing_features),
				'show_ui'                         => true,
				'show_admin_column'               => true,
				'enable_taxonomy_parent_dropdown' => false,
			);

			return $taxonomies;
		}

		public function tfcl_taxonomy_select_meta_box( $post, $box ) {
			$defaults = array( 'taxonomy' => 'category' );

			if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
				$args = array();
			} else {
				$args = $box['args'];
			}
			$taxonomy = '';
			extract( wp_parse_args( $args, $defaults ) );
			$tax          = get_taxonomy( $taxonomy );
			$selected     = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
			$hierarchical = $tax->hierarchical;
			?>
			<div id="taxonomy-<?php echo esc_attr( $taxonomy ); ?>" class="selectdiv listing-select-meta-box-wrap">
				<?php if ( current_user_can( $tax->cap->edit_terms ) ) : ?>
					<?php
					$class = 'widefat';
					if ( $taxonomy == 'make' ) {
						$class .= ' tfcl-listing-make-admin-ajax';
					} elseif ( $taxonomy == 'model' ) {
						$class .= ' tfcl-listing-model-admin-ajax';
					} elseif ( $taxonomy == 'condition' ) {
						$class .= ' tfcl-listing-condition-admin';
					} elseif ( $taxonomy == 'body' ) {
						$class .= ' tfcl-listing-body-admin';
					} elseif ( $taxonomy == 'transmission' ) {
						$class .= ' tfcl-listing-transmission-admin';
					} elseif ( $taxonomy == 'cylinders' ) {
						$class .= ' tfcl-listing-cylinders-admin';
					} elseif ( $taxonomy == 'drive-type' ) {
						$class .= ' tfcl-listing-drive-type-admin';
					} elseif ( $taxonomy == 'fuel-type' ) {
						$class .= ' tfcl-listing-fuel-type-admin';
					} elseif ( $taxonomy == 'car-color' ) {
						$class .= ' tfcl-listing-car-color-admin';
					}

					if ( $hierarchical ) {
						wp_dropdown_categories( array(
							'taxonomy'        => $taxonomy,
							'class'           => $class,
							'hide_empty'      => false,
							'name'            => "tax_input[$taxonomy][]",
							'selected'        => count( $selected ) >= 1 ? $selected[0] : '',
							'orderby'         => 'name',
							'hierarchical'    => false,
							'show_option_all' => esc_html__( 'None', 'tf-car-listing' )
						) );
					} else {
						?>
						<select name="<?php echo esc_attr( "tax_input[$taxonomy][]" ); ?>" class="<?php echo esc_attr( $class ); ?>"
							data-selected="<?php echo esc_attr( tfcl_get_single_taxonomy_by_post_id( $post->ID, $taxonomy, true ) ); ?>">
							<option value=""><?php esc_html_e( 'None', 'tf-car-listing' ); ?></option>
							<?php
							$terms = get_categories(
								array(
									'taxonomy'   => $taxonomy,
									'orderby'    => 'name',
									'order'      => 'ASC',
									'hide_empty' => false,
									'parent'     => 0
								)
							);
							foreach ( $terms as $term ) : ?>
								<option value="<?php echo esc_attr( $term->slug ); ?>" <?php echo selected( $term->term_id, count( $selected ) >= 1 ? $selected[0] : '' ); ?>><?php echo esc_html( $term->name ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php
					}
					?>
				<?php endif; ?>
			</div>
			<?php
		}

		public function tfcl_register_taxonomy() {
			$taxonomies = $this->tfcl_get_config_taxonomy_list();
			foreach ( $taxonomies as $taxonomy => $argument ) {
				if ( ! isset( $argument ) && ! is_array( $argument ) ) {
					return;
				}

				if ( ! isset( $argument['post_type'] ) ) {
					return;
				}

				if ( $argument['enable_taxonomy_parent_dropdown'] == false ) {
					$this->screen[] = $taxonomy;
				}

				$post_type     = array_unique( (array) $argument['post_type'] );
				$singular_name = isset( $argument['singular_name'] ) ? $argument['singular_name'] : '';
				$label         = isset( $argument['label'] ) ? $argument['label'] : '';

				$default_arguments = array(
					'label'     => $label,
					'query_var' => true,
					'rewrite'      => array(
						'slug'       => $taxonomy,
						'with_front' => false
					),
					'labels'    => array(
						'name'                       => $singular_name,
						'singular_name'              => $singular_name,
						'menu_name'                  => $label,
						'search_items'               => sprintf( esc_html( 'Search %s', 'tf-car-listing' ), $label ),
						'popular_items'              => sprintf( esc_html( 'Popular %s', 'tf-car-listing' ), $label ),
						'all_items'                  => sprintf( esc_html( 'All %s', 'tf-car-listing' ), $label ),
						'parent_item'                => sprintf( esc_html( 'Parent %s', 'tf-car-listing' ), $singular_name ),
						'parent_item_colon'          => sprintf( esc_html( 'Parent %s:', 'tf-car-listing' ), $singular_name ),
						'edit_item'                  => sprintf( esc_html( 'Edit %s', 'tf-car-listing' ), $singular_name ),
						'view_item'                  => sprintf( esc_html( 'View %s', 'tf-car-listing' ), $singular_name ),
						'update_item'                => sprintf( esc_html( 'Update %s', 'tf-car-listing' ), $singular_name ),
						'add_new_item'               => sprintf( esc_html( 'Add New %s', 'tf-car-listing' ), $singular_name ),
						'new_item_name'              => sprintf( esc_html( 'New %s New', 'tf-car-listing' ), $singular_name ),
						'separate_items_with_commas' => sprintf( esc_html( 'Separate %s with commas', 'tf-car-listing' ), strtolower( $label ) ),
						'add_or_remove_items'        => sprintf( esc_html( 'Add or remove %s', 'tf-car-listing' ), strtolower( $label ) ),
						'choose_from_most_used'      => sprintf( esc_html( 'Choose from the most used %s', 'tf-car-listing' ), strtolower( $label ) ),
						'not_found'                  => sprintf( esc_html( 'No %s found.', 'tf-car-listing' ), strtolower( $label ) ),
						'no_terms'                   => sprintf( esc_html( 'No %s', 'tf-car-listing' ), strtolower( $label ) ),
						'items_list_navigation'      => sprintf( esc_html( '%s list navigation', 'tf-car-listing' ), $label ),
						'items_list'                 => sprintf( esc_html( '%s list', 'tf-car-listing' ), $label ),
						'back_to_items'              => sprintf( esc_html( '←︎︎ Back to %s', 'tf-car-listing' ), $label ),
					)
				);

				$argument = wp_parse_args( $argument, $default_arguments );
				unset( $argument['enable_taxonomy_parent_dropdown'] );
				$argument['labels'] = wp_parse_args( $argument['labels'], $default_arguments['labels'] );
				register_taxonomy( $taxonomy, $post_type, $argument );
			}
		}

		public function tfcl_remove_tax_parent_dropdown() {
			$screen = get_current_screen();
			$parent = null;
			if ( in_array( $screen->taxonomy, $this->screen ) ) {
				if ( 'edit-tags' == $screen->base ) {
					$parent = "$('label[for=parent]').parent()";
				} elseif ( 'term' == $screen->base ) {
					$parent = "$('label[for=parent]').parent().parent()";
				}
			}
			if ( $parent ) {
				echo __( '<script type="text/javascript">' );
				echo __( 'jQuery(document).ready(function ($){' );
				echo __( $parent . '.remove();' );
				echo __( '});' );
				echo __( '</script>' );
			}
		}

		function tfcl_get_list_term_meta_control( $taxonomy ) {
			$list_makes = $list_features_types = array();

			if ( $taxonomy == 'model' ) {
				$terms_make = get_categories(
					array(
						'taxonomy'   => 'make',
						'hide_empty' => 0,
						'parent'     => 0,
						'show_count' => 1,
						'orderby'    => 'name',
						'order'      => 'ASC',
					)
				);
				foreach ( $terms_make as $key => $value ) {
					$list_makes[ $value->slug ] = $value->name;
				}
			}

			if ( $taxonomy == 'features' ) {
				$terms_features_type = get_categories(
					array(
						'taxonomy'   => 'features-type',
						'hide_empty' => 0,
						'parent'     => 0,
						'show_count' => 1,
						'orderby'    => 'name',
						'order'      => 'ASC',
					)
				);
				foreach ( $terms_features_type as $key => $value ) {
					$list_features_types[ $value->slug ] = $value->name;
				}
			}

			$controls = array();

			switch ( $taxonomy ) {
				case 'body':
					$controls['body_image'] = array(
						'type'    => 'single-image-control',
						'section' => 'body-settings',
						'title'   => esc_html__( 'Image', 'tf-car-listing' ),
					);
					$controls['body_icon'] = array(
						'type'    => 'single-image-control',
						'section' => 'body-settings',
						'title'   => esc_html__( 'Icon', 'tf-car-listing' )
					);
					break;
				case 'make':
					$controls['make_image'] = array(
						'type'    => 'single-image-control',
						'section' => 'make-settings',
						'title'   => esc_html__( 'Image', 'tf-car-listing' ),
					);
					break;
				case 'model':
					$controls['model_of_make'] = array(
						'type'    => 'select',
						'section' => 'model-settings',
						'title'   => esc_html__( get_option('custom_name_make', 'Make'), 'tf-car-listing' ),
						'choices' => $list_makes,
					);
					break;
				case 'features':
					$controls['type_of_features'] = array(
						'type'    => 'select',
						'section' => 'features-settings',
						'title'   => esc_html__( get_option('custom_name_features_type', 'Features Type'), 'tf-car-listing' ),
						'choices' => $list_features_types,
					);
					break;
				default:
					break;
			}

			return $controls;
		}

		function tfcl_register_term_meta_control() {
			new Term_Meta_Control(
				array(
					'id'         => 'body',
					'label'      => esc_html__( get_option('custom_name_body', 'Body') . ' Settings ', 'tf-car-listing' ),
					'post_types' => 'listing',
					'taxonomy'   => array( 'body' ),
					'priority'   => 'high',
					'sections'   => array(
						'body-settings' => array( 'title' => esc_html__( get_option('custom_name_body', 'Body') . ' Settings ', 'tf-car-listing' ) )
					),
					'options'    => $this->tfcl_get_list_term_meta_control( 'body' )
				)
			);

			new Term_Meta_Control(
				array(
					'id'         => 'make',
					'label'      => esc_html__( get_option('custom_name_make', 'Make') . ' Settings ', 'tf-car-listing' ),
					'post_types' => 'listing',
					'taxonomy'   => array( 'make' ),
					'priority'   => 'high',
					'sections'   => array(
						'make-settings' => array( 'title' => esc_html__( get_option('custom_name_make', 'Make') . ' Settings ', 'tf-car-listing' ) ),
					),
					'options'    => $this->tfcl_get_list_term_meta_control( 'make' )
				)
			);

			new Term_Meta_Control(
				array(
					'id'         => 'model',
					'label'      => esc_html__( get_option('custom_name_model', 'Model') . ' Settings ', 'tf-car-listing' ),
					'post_types' => 'listing',
					'taxonomy'   => array( 'model' ),
					'priority'   => 'high',
					'sections'   => array(
						'model-settings' => array( 'title' => esc_html__( get_option('custom_name_model', 'Model') . ' Settings ', 'tf-car-listing' ) ),
					),
					'options'    => $this->tfcl_get_list_term_meta_control( 'model' )
				)
			);

			new Term_Meta_Control(
				array(
					'id'         => 'features',
					'label'      => esc_html__( get_option('custom_name_features', 'Features') . ' Settings ', 'tf-car-listing' ),
					'post_types' => 'listing',
					'taxonomy'   => array( 'features' ),
					'priority'   => 'high',
					'sections'   => array(
						'features-settings' => array( 'title' => esc_html__( get_option('custom_name_features', 'Features') . ' Settings ', 'tf-car-listing' ) ),
					),
					'options'    => $this->tfcl_get_list_term_meta_control( 'features' )
				)
			);
		}

		function tfcl_add_columns_taxonomy_model( $columns ) {
			$columns['cb']          = "<input type=\"checkbox\" />";
			$columns['name']        = esc_html__( 'Name', 'tf-car-listing' );
			$columns['description'] = esc_html__( 'Description', 'tf-car-listing' );
			$columns['slug']        = esc_html__( 'Slug', 'tf-car-listing' );
			$columns['make']        = esc_html__( 'Make', 'tf-car-listing' );
			$new_columns            = array();
			$custom_columns         = array(
				'cb',
				'name',
				'description',
				'slug',
				'make'
			);
			foreach ( $custom_columns as $key => $column ) {
				$new_columns[ $column ] = $columns[ $column ];
			}
			return $new_columns;
		}

		function tfcl_add_columns_data_taxonomy_model( $content, $column_name, $term_id ) {
			if ( $column_name !== 'make' ) {
				return $content;
			}

			$make_taxonomy_id = get_term_meta( $term_id, 'model_of_make', true );
			if ( ! empty( $make_taxonomy_id ) ) {
				$make_taxonomy = get_term_by( 'slug', $make_taxonomy_id, 'make' );
				if ( ! empty( $make_taxonomy ) && isset( $make_taxonomy->name ) ) {
					$content .= esc_html( $make_taxonomy->name );
				}
			}

			return $content;
		}
	}
}