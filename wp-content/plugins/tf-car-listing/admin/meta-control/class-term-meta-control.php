<?php
/**
 * Register meta box options for the post types
 * 
 * @return  void
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Term_Meta_Control' ) ) {
	class Term_Meta_Control {
		public $options;
		public $controls;
		public $label;
		public $id;
		public $priority;
		public $sections;
		public $post_types;
		public $type;
		public $taxonomy;

		public function __construct( $args ) {

			foreach ( array_keys( get_object_vars( $this ) ) as $key ) {
				if ( isset( $args[ $key ] ) )
					$this->$key = $args[ $key ];
			}

			foreach ( $this->options as $key => $_options ) {
				$_options['id']                         = $key;
				$this->controls[ $_options['section'] ][] = $_options;
			}

			$this->tfcl_hook();
			$this->tfcl_setup();
		}

		public function tfcl_hook() {
			wp_enqueue_script( 'wp-plupload' );
			wp_enqueue_style( 'wp-color-picker' );
			add_action( 'save_post', array( $this, 'tfcl_save_term_meta_control' ) );
		}

		public function tfcl_setup() {
			$taxonomy_priority = ( isset( $this->priority ) ? $this->priority : 'default' );
			$taxonomies        = isset( $this->taxonomy ) ? (array) $this->taxonomy : array();
			foreach ( $taxonomies as $taxonomy ) {
				add_action( $taxonomy . '_add_form_fields', array( $this, 'tfcl_add_term_meta_control_display' ), $taxonomy_priority, 2 );
				add_action( $taxonomy . '_edit_form_fields', array( $this, 'tfcl_edit_term_meta_control_display' ), $taxonomy_priority, 2 );

				add_action( 'created_' . $taxonomy, array( $this, 'tfcl_save_term_meta_control' ), $taxonomy_priority, 2 );
				add_action( 'edited_' . $taxonomy, array( $this, 'tfcl_save_term_meta_control' ), $taxonomy_priority, 2 );
			}
		}

		public function tfcl_add_term_meta_control_display( $taxonomy ) {
			$this->tfcl_render( $taxonomy, 'add' );
		}

		public function tfcl_edit_term_meta_control_display( $taxonomy ) {
			$this->tfcl_render( $taxonomy, 'edit' );
		}

		public function tfcl_render( $taxonomy, $type_screen ) {
			$controls = $this->controls;
			?>
			<div>
				<div class="tfcl-options-container-content">
					<?php
					foreach ( $controls as $key => $_controls ) { ?>
						<div id="<?php echo esc_attr( $key ); ?>">
							<?php $this->tfcl_render_content( $key, $_controls, $taxonomy, $type_screen ); ?>
						</div>
					<?php }
					?>
				</div>
			</div>
			<?php
			wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
		}

		function tfcl_render_content( $key, $controls, $taxonomy, $type_screen ) {
			switch ( $type_screen ) {
				case 'add':
					?>
					<div id="tfcl-options-section-<?php echo esc_attr( $key ) ?>">
						<ul class="tfcl-options-section-controls">
							<?php
							foreach ( $controls as $control ) :
								$this->tfcl_render_controls( $control );
							endforeach;
							?>
						</ul>
					</div>
					<?php
					break;
				case 'edit':
					foreach ( $controls as $control ) : ?>
						<tr class="form-field">
							<th scope="row">
								<label for="tfcl-options-section-<?php echo esc_attr( $key ) ?>">
									<?php esc_html_e( $control['title'], 'tf-car-listing' ) ?>
								</label>
							</th>
							<td>
								<div id="tfcl-options-section-<?php echo esc_attr( $key ) ?>">
									<ul class="tfcl-options-section-controls">
										<?php $this->tfcl_render_controls( $control ); ?>
									</ul>
								</div>
							</td>
						</tr>
						<?php
					endforeach;
					break;
				default:
					break;
			}
		?>
		<?php
		}

		public function tfcl_render_controls( $control, $is_dynamic_control_children = false, $is_blank_control = false, $dynamic_control_children_value = null, $dynamic_field_id = 0 ) {
			$term_id = isset( $_GET['tag_ID'] ) ? $_GET['tag_ID'] : '0';
			global $wp_registered_sidebars;

			$dynamic_fields = get_term_meta( $term_id, 'dynamic_fields', true );

			if ( get_term_meta( $term_id, $control['id'], true ) == '' ) {
				$value = ( isset( $control['default'] ) ? $control['default'] : '' );
			} else {
				$value = get_term_meta( $term_id, $control['id'], true );
			}

			if ( $is_dynamic_control_children && $is_blank_control ) {
				$value            = '';
				$dynamic_field_id = null;
			} else {
				if ( isset( $dynamic_control_children_value ) ) {
					$keys = array_keys( $dynamic_control_children_value );
					if ( in_array( $control['id'], $keys ) ) {
						$value = $dynamic_control_children_value[ $control['id'] ];
					}
				}
			}

			$class = '';
			if ( $value == 1 ) {
				$class = 'active';
			}

			$name        = ( $is_dynamic_control_children == true ? "_tf_options[{$control['id']}][]" : "_tf_options[{$control['id']}]" );
			$title       = ( isset( $control['title'] ) ? $control['title'] : '' );
			$choices     = ( isset( $control['choices'] ) ? $control['choices'] : '' );
			$children    = ( isset( $control['children'] ) ? $control['children'] : array() );
			$children    = array_map( function ($value) {
				return '#tfcl-options-control-' . $value;
			}, $children );
			$children    = implode( ",", $children );
			$description = ( isset( $control['description'] ) ? '<p>' . $control['description'] . '</p>' : '' );
			$placeholder = ( isset( $control['placeholder'] ) ? $control['placeholder'] : '' );
			printf( '<li class = "tfcl-options-control tfcl-options-control-%2$s %3$s" id="tfcl-options-control-%1$s">', esc_attr( $control['id'] ), esc_attr( $control['type'] ), esc_attr( $class ) );

			switch ( $control['type'] ) {
				case 'toggle':
					printf( '<h4 class="tfcl-options-control-title">%3$s</h4>%4$s
                    <label class="switch tfcl-power options-%5$s-%6$s">
                      <input value="0" name="%2$s" type="hidden"><input children="%7$s" type="checkbox" value="1" %1$s name="%2$s">
                      <div class="slider round"></div>
                    </label>', esc_attr( checked( true, $value, false ) ), esc_attr( $name ), $title, $description, esc_attr( $control['type'] ), esc_attr( $control['id'] ), esc_attr( $children ) );
					break;
				case 'heading':
					printf( '<label class="options-%3$s-%4$s"><h3>%1$s</h3></label>%2$s', $title, $description, esc_attr( $control['type'] ), esc_attr( $control['id'] ) );
					break;
				case 'radio': ?>
					<span class="tfcl-options-control-title">
						<?php echo esc_html( $title ); ?>
					</span>
					<div class="tfcl-options-control-field">
						<?php foreach ( $choices as $_key => $_value ) :
							$children_controls = isset( $_value['children'] ) && is_array( $_value['children'] ) ? $_value['children'] : array();
							$children_controls = array_map( function ($value) {
								return '#tfcl-options-control-' . $value;
							}, $children_controls );
							$children_controls = implode( ",", $children_controls );
							?>
							<label>
								<input type="radio" value="<?php echo esc_attr( $_key ) ?>" name="<?php echo esc_attr( $name ); ?>"
									children="<?php echo esc_attr( $children_controls ); ?>" <?php echo checked( $value, $_key ) ?> />
								<span>
									<?php echo esc_html( $_value['label'] ) ?>
								</span>
							</label>
						<?php endforeach; ?>
					</div>
					<?php break;
				case 'select': ?>
					<span class="tfcl-options-control-title">
						<?php echo esc_html( $title ); ?>
					</span>
					<div class="tfcl-options-control-field">
						<select name="<?php echo esc_attr( $name ); ?>">
							<option value=""><?php echo esc_html__( 'None', 'tf-car-listing' ); ?></option>
							<?php foreach ( $choices as $_value => $params ) :
								printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $_value ), esc_attr( selected( $value, $_value ) ), $params ); ?>
							<?php endforeach; ?>
						</select>
					</div>
					<?php break;
				case 'dropdown-sidebar': ?>
					<label>
						<span class="customize-category-select-control">
							<?php esc_html( $title ); ?>
						</span>
						<select name="<?php esc_attr( $name ) ?>">
							<?php
							foreach ( $wp_registered_sidebars as $sidebar ) {
								$selected = ( strcmp( $value, $sidebar['id'] ) == 0 ? 1 : 0 );
								printf( '<option value="%1$s" %2$s>%3$s</option>', $sidebar['id'], selected( $selected ), $sidebar['name'] );
							}
							?>
						</select>
					</label>
					<?php break;
				case 'textarea': ?>
					<span class="tfcl-options-control-title">
						<?php echo esc_html( $title ); ?>
					</span>
					<div class="tfcl-options-control-inputs">
						<textarea name="<?php echo esc_attr( $name ); ?>"
							id="<?php echo esc_attr( $control['id'] ) ?>"><?php echo esc_html__( $value, 'tf-car-listing' ); ?></textarea>
					</div>
					<?php break;
				case 'datetime':
					printf( '<span class="tfcl-options-control-title">%3$s</span></label> %4$s<div class="tfcl-options-control-inputs">
                <input name="_tf_options[%1$s]" id="tf-date-time" type="text" value="%2$s"/></div>', esc_attr( $control['id'] ), esc_attr( $value ), $title, $description );
					break;
				case 'color-picker': ?>
					<span class="tfcl-options-control-title">
						<?php echo esc_html( $title ); ?>
					</span>
					<div class="background-color">
						<div class="tfcl-options-control-color-picker">
							<div class="tfcl-options-control-inputs">
								<input type="text" class='tf-color-picker wp-color-picker' id="<?php echo esc_attr( $name ) ?>-color"
									name="<?php echo esc_attr( $name ); ?>" data-default-color value="<?php echo esc_attr( $value ) ?>" />
							</div>
						</div>
					</div>
					<?php break;
				case 'attachments-control': ?>
					<?php
					$decoded_value = json_decode( $value );
					?>
					<div class="tfcl-options-control-multi-attachments-picker background-image"
						data-customizer-link="<?php echo esc_attr( $control['id'] ); ?>">
						<span class="tfcl-options-control-title">
							<?php echo esc_html( $title );
							echo wp_get_attachment_image( $decoded_value ); ?>
						</span>
						<div class="tfcl-options-control-inputs">
							<div class="upload-dropzone">

								<input type="hidden" data-listing="id" />
								<input type="hidden" data-listing="thumbnail" />
								<ul class="upload-preview">
									<?php
									if ( is_array( $decoded_value ) ) {
										foreach ( $decoded_value as $val ) :
											if ( empty( $val ) ) {
												continue;
											}
											$file_metadata = get_post( $val );
											if ( $file_metadata === null ) {
												continue;
											}

											printf( '
                                                <li>
                                                    <a href="%1$s" target="_blank">  
                                                        <span class="dashicons dashicons-media-default"></span>
                                                    </a>
                                                    <div class="tf-file-info">
                                                        <a class="tf-file-title" href="%1$s" target="_blank">%2$s (%3$s)</a>
                                                        <div class="tf-file-name">%4$s </div>
                                                        <a href="#" id="%5$s" class="button tf-remove-media" title="Remove">
                                                        Remove
                                                        </a>
                                                    </div>
                                                </li>
                                                ', esc_url( get_edit_post_link( $val ) ), esc_html( $file_metadata->post_title ), esc_html( $file_metadata->post_mime_type ), esc_html( wp_basename( $file_metadata->guid ) ), esc_attr( $val ) );
										endforeach;
									}
									?>
								</ul>
								<span class="upload-message">
									<a href="#" class="button browse-media">
										<?php esc_html_e( 'Add files', 'tf-car-listing' ) ?>
									</a>
									<a href="#" class="upload"></a>
									<a href="#" class="button remove-all">
										<?php esc_html_e( 'Remove All', 'tf-car-listing' ) ?>
									</a>
								</span>
							</div>
						</div>
						<input class="file-value" type="hidden" name="<?php echo esc_attr( $name ); ?>"
							value="<?php echo esc_attr( $value ) ?>" />
					</div>
					<?php
					break;
				case 'image-control': ?>
					<?php
					$showupload = '_show';
					$showremove = '_hide';
					if ( $value != '' ) {
						$showupload = '_hide';
						$showremove = '_show';
					}
					$decoded_value = json_decode( $value );
					?>
					<div class="tfcl-options-control-multi-media-picker background-image"
						data-customizer-link="<?php echo esc_attr( $control['id'] ); ?>">
						<span class="tfcl-options-control-title">
							<?php echo esc_html( $title ); ?>
						</span>
						<div class="tfcl-options-control-inputs">
							<div class="upload-dropzone">

								<input type="hidden" data-listing="id" />
								<input type="hidden" data-listing="thumbnail" />
								<ul class="upload-preview">
									<?php
									if ( is_array( $decoded_value ) ) {
										foreach ( $decoded_value as $val ) :
											printf( '<li>
                                                            %s
                                                            <a href="#" id="%d" class="tf-remove-media" title="Remove">
                                                                <span class="dashicons dashicons-no-alt"></span>
                                                            </a>
                                                        </li>
                                                        ', wp_get_attachment_image( $val ), esc_attr( $val ) );
										endforeach;
									}
									?>
								</ul>
								<span class="upload-message <?php echo esc_attr( $showupload ); ?> ">
									<a href="#" class="button browse-media">
										<?php esc_html_e( 'Add files', 'tf-car-listing' ) ?>
									</a>
									<a href="#" class="upload"></a>
									<a href="#"
										class="button remove-all <?php echo esc_attr( $showremove ); ?>"><?php esc_html_e( 'Remove All', 'tf-car-listing' ) ?></a>
								</span>
							</div>
						</div>
						<input class="image-value" type="hidden" name="<?php echo esc_attr( $name ); ?>"
							value="<?php echo esc_attr( $value ) ?>" />
					</div>
					<?php
					break;
				case 'single-image-control': ?>
					<?php
					$showupload = '_show';
					$showremove = '_hide';
					if ( $value != '' ) {
						$showupload = '_hide';
						$showremove = '_show';
					}
					?>
					<div class="tfcl-options-control-media-picker background-image"
						data-customizer-link="<?php echo esc_attr( $control['id'] ); ?>">
						<span class="tfcl-options-control-title">
							<?php echo esc_html( $title ); ?>
						</span>
						<div class="tfcl-options-control-inputs">
							<div class="upload-dropzone">
								<input type="hidden" data-listing="id" />
								<input type="hidden" data-listing="thumbnail" />
								<ul id="<?php echo esc_attr( $control['id'] . '_' . $dynamic_field_id ); ?>" class="upload-preview">
									<?php
									printf( '
                                            <li>
                                                <img loading="lazy" src="%s"/>
                                                <a href="#" id="%s" class="tf-remove-media" title="Remove">
                                                    <span data-id-field="%3$s" class="dashicons dashicons-no-alt"></span>
                                                </a>
                                            </li>
                                            ', esc_attr( wp_get_attachment_image_url( $value ) ), esc_attr( $value ), esc_attr( $control['id'] . '_' . $dynamic_field_id ) );
									?>
								</ul>
								<span class="upload-message <?php echo esc_attr( $showupload ); ?> ">
									<a data-id-field="<?php echo esc_attr( $control['id'] . '_' . $dynamic_field_id ); ?>" href="#"
										class="button browse-media <?php echo esc_attr( $control['id'] . '_' . $dynamic_field_id ); ?>">
										<?php esc_html_e( 'Add file', 'tf-car-listing' ) ?>
									</a>
									<a href="#" class="upload"></a>
								</span>
							</div>
						</div>
						<input id="<?php echo esc_attr( $control['id'] . '_' . $dynamic_field_id ); ?>" class="single-image-value"
							type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					</div>
					<?php
					break;
				case 'map':
					?>
					<span class="tfcl-options-control-title">
						<?php echo esc_html( $title ); ?>
					</span>
					<div class="map-container">
						<input data-field-control="" type="hidden" class="tfcl-map-location-field" name="<?php echo esc_attr( $name ); ?>[]"
							value="<?php echo ( is_array( $value ) ? esc_attr( $value[0] ) : '' ); ?>" />
						<?php if ( tfcl_get_option( "map_service" ) == 'map-box' ) : ?>
							<div class="tfcl-map-address-field">
								<div class="tfcl-map-address-field-text">
									<input data-field-control="" type="hidden" placeholder="<?php echo esc_attr( $placeholder ); ?>"
										name="<?php echo esc_attr( $name ); ?>[]"
										value="<?php echo ( is_array( $value ) ? esc_attr( $value[1] ) : '' ); ?>" />
								</div>
							</div>
						<?php endif; ?>
						<?php if ( tfcl_get_option( "map_service" ) == 'google-map' ) : ?>
							<div class="tfcl-map-address-field">
								<div class="tfcl-map-address-field-text">
									<input data-field-control="" type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>"
										name="<?php echo esc_attr( $name ); ?>[]"
										value="<?php echo ( is_array( $value ) ? esc_attr( $value[1] ) : '' ); ?>" />
								</div>
								<button type="button" class="button">
									<?php echo esc_html__( 'Find Address', 'tf-car-listing' ); ?>
								</button>
							</div>
						<?php endif; ?>
						<div id="map" class="map" style="height:400px"></div>
					</div>
					<?php
					break;
				case 'panel-dynamic':
					?>
					<div class="container-dynamic-panel">
						<?php
						if ( $dynamic_fields ) {
							foreach ( $dynamic_fields as $k => $field ) {
								?>
								<section class="wrapper-dynamic-panel">
									<div class="header-dynamic-panel">
										<span class="dynamic-panel-title">
											<?php echo esc_html( $title ); ?>
										</span>
										<span class="dynamic-panel-button-remove"><i class="dashicons dashicons-no-alt"></i></span>
									</div>
									<div class="body-dynamic-panel">
										<ul class="tfcl-options-section-controls">
											<?php
											if ( isset( $control['children-dynamic-controls'] ) ) {
												foreach ( $control['children-dynamic-controls'] as $key => $ctrl ) {
													$ctrl['id'] = $key;
													$this->tfcl_render_controls( $ctrl, true, false, $field, $k );
												}
											}
											?>
										</ul>
									</div>
								</section>
							<?php }
						} else {
							?>
							<section class="wrapper-dynamic-panel">
								<div class="header-dynamic-panel">
									<span class="dynamic-panel-title">
										<?php echo esc_html( $title ); ?>
									</span>
									<span class="dynamic-panel-button-remove"><i class="dashicons dashicons-no-alt"></i></span>
								</div>
								<div class="body-dynamic-panel">
									<ul class="tfcl-options-section-controls">
										<?php
										if ( isset( $control['children-dynamic-controls'] ) ) {
											foreach ( $control['children-dynamic-controls'] as $key => $ctrl ) {
												$ctrl['id'] = $key;
												$this->tfcl_render_controls( $ctrl, true, false );
											}
										}
										?>
									</ul>
								</div>
							</section>
						<?php } ?>
						<section class="wrapper-dynamic-panel-sample empty-row screen-reader-text">
							<div class="header-dynamic-panel">
								<span class="dynamic-panel-title">
									<?php echo esc_html( $title ); ?>
								</span>
								<span class="dynamic-panel-button-remove"><i class="dashicons dashicons-no-alt"></i></span>
							</div>
							<div class="body-dynamic-panel">
								<ul class="tfcl-options-section-controls">
									<?php
									if ( isset( $control['children-dynamic-controls'] ) ) {
										foreach ( $control['children-dynamic-controls'] as $key => $ctrl ) {
											$ctrl['id'] = $key;
											$this->tfcl_render_controls( $ctrl, true, true );
										}
									}
									?>
								</ul>
							</div>
						</section>
					</div>
					<button data-control-id="<?php echo esc_attr( $control['id'] ); ?>" data-id-field-latest="<?php if ( $dynamic_fields && is_array( $dynamic_fields ) )
						   echo count( $dynamic_fields ) ?>" class="dynamic-panel-button-add button" type="button"><?php echo esc_html__( '+ Add ', 'tf-car-listing' ); ?> <?php echo esc_html( $title ); ?></button>
					<?php
					break;
				default:
					printf( '<span class="tfcl-options-control-title">%5$s</span></label> %6$s<div class="tfcl-options-control-inputs">
                    <input id="%1$s" name="%2$s" type="%3$s" value="%4$s" placeholder="%7$s"/></div>', esc_attr( $control['id'] ), esc_attr( $name ), esc_attr($control['type']), esc_html( $value ), $title, esc_html__( $description, 'tf-car-listing' ), esc_attr( $placeholder ) );
					break;
			}
			echo '</li>';
		}

		function tfcl_save_term_meta_control( $term_id ) {
			/*
			 * We need to verify this came from the our screen and with proper authorization,
			 * because save_post can be triggered at other times.
			 */

			$nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
			$nonce_action = 'custom_nonce_action';

			// Check if nonce is set.
			if ( ! isset( $nonce_name ) ) {
				return;
			}

			// Check if nonce is valid.
			if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
				return;
			}
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $term_id;
			}

			if ( empty( $_POST ) || ! isset( $_POST['taxonomy'] ) ) {
				return;
			}

			/* OK, it's safe for us to save the data now. */
			if ( isset( $_REQUEST ) && isset( $_REQUEST['_tf_options'] ) ) {
				$datas              = stripslashes_deep( $_REQUEST['_tf_options'] );
				$old_dynamic_fields = get_term_meta( $term_id, 'dynamic_fields', true );
				$new_dynamic_fields = array();
				foreach ( $datas as $key => $value ) {
					if ( is_array( $value ) && $key != 'agency_location' ) {
						$count_fields = count( $value );
						for ( $i = 0; $i < $count_fields; $i++ ) {
							if ( $value[ $i ] != '' && $value[ $i ] != 'No Image' ) {
								$new_dynamic_fields[ $i ][ $key ] = stripslashes( strip_tags( $value[ $i ] ) );
							}
						}
					} else {
						update_term_meta( $term_id, $key, $value );
					}
				}
				if ( ! empty( $new_dynamic_fields ) && $new_dynamic_fields != $old_dynamic_fields )
					update_term_meta( $term_id, 'dynamic_fields', $new_dynamic_fields );
				elseif ( empty( $new_dynamic_fields ) && $old_dynamic_fields )
					update_term_meta( $term_id, 'dynamic_fields', $old_dynamic_fields );
			}
		}
	}
}
?>