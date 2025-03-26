<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
require_once( TF_PLUGIN_PATH . 'includes/class-background-emailer.php' );
function get_capabilities() {
	$capabilities = array();

	$capability_post_types = array( 'listing', 'dealer', 'invoice', 'user-package', 'transaction-log' );

	foreach ( $capability_post_types as $capability_post_type ) {

		$capabilities[ $capability_post_type ] = array(
			// Post type
			"create_{$capability_post_type}",
			"edit_{$capability_post_type}",
			"read_{$capability_post_type}",
			"delete_{$capability_post_type}",
			"edit_{$capability_post_type}s",
			"edit_others_{$capability_post_type}s",
			"publish_{$capability_post_type}s",
			"read_private_{$capability_post_type}s",
			"delete_{$capability_post_type}s",
			"delete_private_{$capability_post_type}s",
			"delete_published_{$capability_post_type}s",
			"delete_others_{$capability_post_type}s",
			"edit_private_{$capability_post_type}s",
			"edit_published_{$capability_post_type}s",

			// Terms
			"manage_{$capability_post_type}_terms",
			"edit_{$capability_post_type}_terms",
			"delete_{$capability_post_type}_terms",
			"assign_{$capability_post_type}_terms"
		);
	}

	return $capabilities;
}

function tfcl_get_option( $key, $default = '' ) {
	global $tfcl_options;
	return ( isset( $tfcl_options[ $key ] ) && ! empty( $tfcl_options[ $key ] ) ) ? $tfcl_options[ $key ] : $default;
}

function tf_get_template_widget_elementor( $template_name, $args = array(), $return = false ) {
	$template_file  = $template_name . '.php';
	$default_folder = TF_PLUGIN_PATH . 'includes/elementor-widget/';
	$theme_folder   = TF_PLUGIN_PATH;
	$template       = locate_template( $theme_folder . '/' . $template_file );
	if ( ! $template ) {
		$template = $default_folder . $template_file;
	}
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}
	if ( $return ) {
		ob_start();
	}
	if ( file_exists( $template ) ) {
		include $template;
	}
	if ( $return ) {
		return ob_get_clean();
	}
	return null;
}

function tfcl_image_resize_id( $images_id, $width = NULL, $height = NULL, $crop = true, $retina = false ) {
	$output    = '';
	$image_src = wp_get_attachment_image_src( $images_id, 'full' );
	if ( is_array( $image_src ) ) {
		$resize = tfcl_image_resize_url( $image_src[0], $width, $height, $crop, $retina );
		if ( $resize != null && is_array( $resize ) ) {
			$output = $resize['url'];
		}
	}
	return $output;
}

function tfcl_image_resize_url( $url, $width = NULL, $height = NULL, $crop = true, $retina = false ) {

	global $wpdb;

	if ( empty( $url ) )
		return new WP_Error( 'no_image_url', esc_html__( 'No image URL has been entered.', 'tf-car-listing' ), $url );

	if ( class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'photon', Jetpack::get_active_modules() ) ) {
		$args_crop = array(
			'resize' => $width . ',' . $height,
			'crop'   => '0,0,' . $width . 'px,' . $height . 'px'
		);
		$url       = jetpack_photon_url( $url, $args_crop );
	}

	// Get default size from database
	$width  = ( $width ) ? $width : get_option( 'thumbnail_width' );
	$height = ( $height ) ? $height : get_option( 'thumbnail_height' );

	// Allow for different retina sizes
	$retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

	// Get the image file path
	$file_path        = parse_url( $url );
	$file_path        = sanitize_text_field( $_SERVER['DOCUMENT_ROOT'] ) . $file_path['path'];
	$wp_upload_folder = wp_upload_dir();
	$wp_upload_folder = $wp_upload_folder['basedir'];
	$file_path        = explode( '/uploads/', $file_path );
	if ( is_array( $file_path ) ) {
		if ( count( $file_path ) > 1 ) {
			$file_path = $wp_upload_folder . '/' . $file_path[1];
		} elseif ( count( $file_path ) > 0 ) {
			$file_path = $wp_upload_folder . '/' . $file_path[0];
		} else {
			$file_path = '';
		}
	}

	// Check for Multisite
	if ( is_multisite() ) {
		global $blog_id;
		$blog_details = get_blog_details( $blog_id );
		$file_path    = str_replace( $blog_details->path . 'files/', '/wp-content/blogs.dir/' . $blog_id . '/files/', $file_path );
	}

	// Destination width and height variables
	$dest_width  = $width * $retina;
	$dest_height = $height * $retina;

	// File name suffix (appended to original file name)
	$suffix = "{$dest_width}x{$dest_height}";

	// Some additional info about the image
	$info = pathinfo( $file_path );
	$dir  = ! empty( $info['dirname'] ) ? $info['dirname'] : '';
	$ext  = ! empty( $info['extension'] ) ? $info['extension'] : '';
	$name = wp_basename( $file_path, ".$ext" );

	if ( 'bmp' == $ext ) {
		return new WP_Error( 'bmp_mime_type', esc_html__( 'Image is BMP. Please use either JPG or PNG.', 'tf-car-listing' ), $url );
	}

	// Suffix applied to filename
	$suffix = "{$dest_width}x{$dest_height}";

	$file_name = "{$name}-{$suffix}.{$ext}";
	$file_name = sanitize_file_name( $file_name );

	// Get the destination file name
	$dest_file_name = "{$dir}/{$file_name}";

	if ( ! file_exists( $dest_file_name ) ) {
		$query          = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
		$get_attachment = $wpdb->get_results( $query );
		if ( ! $get_attachment )
			return array( 'url' => $url, 'width' => $width, 'height' => $height );

		// Load Wordpress Image Editor
		$editor = wp_get_image_editor( $file_path );
		if ( is_wp_error( $editor ) )
			return array( 'url' => $url, 'width' => $width, 'height' => $height );

		// Get the original image size
		$size        = $editor->get_size();
		$orig_width  = $size['width'];
		$orig_height = $size['height'];

		$src_x = $src_y = 0;
		$src_w = $orig_width;
		$src_h = $orig_height;

		if ( $crop ) {

			$cmp_x = $orig_width / $dest_width;
			$cmp_y = $orig_height / $dest_height;

			// Calculate x or y coordinate, and width or height of source
			if ( $cmp_x > $cmp_y ) {
				$src_w = round( $orig_width / $cmp_x * $cmp_y );
				$src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
			} else if ( $cmp_y > $cmp_x ) {
				$src_h = round( $orig_height / $cmp_y * $cmp_x );
				$src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
			}

		}

		// Time to crop the image!
		$editor->crop( $src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height );

		// Now let's save the image
		$saved = $editor->save( $dest_file_name );

		if ( is_a( $saved, 'WP_Error' ) ) {
			$image_array = array(
				'url'    => str_replace( wp_basename( $url ), wp_basename( $dest_file_name ), $url ),
				'width'  => $dest_width,
				'height' => $dest_height,
				'type'   => $ext
			);
		} else {
			$resized_url    = str_replace( wp_basename( $url ), wp_basename( $saved['path'] ), $url );
			$resized_width  = $saved['width'];
			$resized_height = $saved['height'];
			$resized_type   = $saved['mime-type'];

			$metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
			if ( isset( $metadata['image_meta'] ) ) {
				$metadata['image_meta']['resized_images'][] = $resized_width . 'x' . $resized_height;
				wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
			}

			// Create the image array
			$image_array = array(
				'url'    => $resized_url,
				'width'  => $resized_width,
				'height' => $resized_height,
				'type'   => $resized_type
			);
		}

	} else {
		$image_array = array(
			'url'    => str_replace( wp_basename( $url ), wp_basename( $dest_file_name ), $url ),
			'width'  => $dest_width,
			'height' => $dest_height,
			'type'   => $ext
		);
	}

	// Return image array
	return $image_array;

}

function tfcl_get_multiple_taxonomy_by_post_id( $post_id, $taxonomy_name, $is_value_by_id = false, $show_default = true, $is_multiple = false, $parent = 0, $prefix = '', $value = null ) {
	$taxonomy_terms = get_categories(
		array(
			'taxonomy'   => $taxonomy_name,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
			'parent'     => $parent
		)
	);
	$value_by_id    = $value_by_slug = $value != null ? $value : ( $is_multiple ? array() : 0 );
	$tax_terms = $value != null ? '' : get_the_terms( $post_id, $taxonomy_name );

	if ( ! empty( $tax_terms ) ) {
		foreach ( $tax_terms as $tax_term ) {
			if ( $is_multiple ) {
				if ( $is_value_by_id ) {
					$value_by_id[] = $tax_term->term_id;
				} else {
					$value_by_slug[] = $tax_term->slug;
				}

			} else {
				if ( $is_value_by_id ) {
					$value_by_id = $tax_term->term_id;
				} else {
					$value_by_slug = $tax_term->slug;
				}
				break;
			}
		}
	}
	if ( $show_default && $parent === 0 ) {
		if ( empty( $value_by_id ) || empty( $value_by_slug ) ) {
			echo '<option value="" selected>' . esc_html__( 'None', 'tf-car-listing' ) . '</option>';
		} else {
			echo '<option value="">' . esc_html__( 'None', 'tf-car-listing' ) . '</option>';
		}
	}

	if ( ! empty( $taxonomy_terms ) ) {
		foreach ( $taxonomy_terms as $term ) {
			if ( empty( $term ) || ( ! isset( $term->parent ) ) ) {
				continue;
			}
			if ( ( (int) $term->parent !== (int) $parent ) || ( $parent === null ) || ( $term->parent === null ) ) {
				continue;
			}
			if ( $is_value_by_id ) {
				if ( ( is_array( $value_by_id ) && in_array( $term->term_id, $value_by_id ) ) || ( $value_by_id == $term->term_id ) ) {
					echo '<option value="' . esc_attr( $term->term_id ) . '" selected>' . esc_html( $prefix . $term->name ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $term->term_id ) . '">' . esc_html( $prefix . $term->name ) . '</option>';
				}
			} else {
				if ( ( is_array( $value_by_slug ) && in_array( $term->slug, $value_by_slug ) ) || ( $value_by_slug == $term->slug ) ) {
					echo '<option value="' . esc_attr( $term->slug ) . '" selected>' . esc_html( $prefix . $term->name ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $prefix . $term->name ) . '</option>';
				}
			}

			tfcl_get_multiple_taxonomy_by_post_id( $post_id, $taxonomy_name, $is_value_by_id, $show_default, $is_multiple, $term->term_id, $prefix . '&#8212;', $value_by_id );
		}
	}
}

function get_sources_listing_gallery_images( $listing_gallery_Id, $is_vertical = false ) {
	if ( $listing_gallery_Id === '' ) {
		return;
	}
	$listing_gallery_Id = json_decode( $listing_gallery_Id );
	$listing_gallery    = array();
	foreach ( $listing_gallery_Id as $image_id ) {
		$image_src = wp_get_attachment_image_src( $image_id, ( $is_vertical ? 'themesflat-listing-thumbnail-vertical'
			: 'themesflat-listing-thumbnail' ) );
		if ( is_array( $image_src ) ) {
			$listing_gallery[] = $image_src[0];
		}
	}
	$listing_gallery_count = count( $listing_gallery );
	if ( $listing_gallery_count === 0 ) {
		return;
	}
	return $listing_gallery;
}

function tfcl_format_price( $price_value = '', $price_unit = '', $decimals = false, $short_price_unit = false ) {
	if ( ! $decimals ) {
		$decimals = 0;
	}

	$price_value         = doubleval( $price_value );
	$currency_sign       = tfcl_get_option( 'currency_sign', '' );
	$currency_position   = tfcl_get_option( 'currency_sign_position', esc_html__( 'before', 'tf-car-listing' ) );
	$decimal_separator   = tfcl_get_option( 'decimal_separator', '.' );
	$thousands_separator = tfcl_get_option( 'thousand_separator', ',' );
	$thousand_text       = esc_html__( 'thousand', 'tf-car-listing' );
	$million_text        = esc_html__( 'million', 'tf-car-listing' );
	$billion_text        = esc_html__( 'billion', 'tf-car-listing' );
	$thousand_short_text = tfcl_get_option( 'thousand_text', $thousand_text );
	$million_short_text  = tfcl_get_option( 'million_text', $million_text );
	$billion_short_text  = tfcl_get_option( 'billion_text', $billion_text );
	$format_price        = number_format( $price_value, $decimals, $decimal_separator, $thousands_separator );

	if ( $price_unit !== '' ) {
		$unit_text  = '';
		$price_unit = intval( $price_unit );
		switch ( $price_unit ) {
			case 1000:
				$unit_text = $short_price_unit ? $thousand_short_text : $thousand_text;
				break;
			case 1000000:
				$unit_text = $short_price_unit ? $million_short_text : $million_text;
				break;
			case 1000000000:
				$unit_text = $short_price_unit ? $billion_short_text : $billion_text;
				break;
		}
		if ( $unit_text !== '' ) {
			$format_price = $format_price . ' ' . $unit_text . ' ';
		}
	}

	if ( $currency_position == 'before' ) {
		$format_price = $currency_sign . $format_price;
	} else {
		$format_price = $format_price . $currency_sign;
	}
	return $format_price;
}

function tfcl_is_zero_decimal_currency( $currency_code ) {
	$zero_decimal_currencies = array(
		'BIF',
		'CLP',
		'DJF',
		'GNF',
		'JPY',
		'KMF',
		'KRW',
		'MGA',
		'PYG',
		'RWF',
		'UGX',
		'VND',
		'VUV',
		'XAF',
		'XOF',
		'XPF',
	);
	if ( in_array( $currency_code, $zero_decimal_currencies ) ) {
		return true;
	}
	return false;
}

function tfcl_get_permalink( $page ) {
	$page_id = tfcl_get_option( $page );
	if ( $page_id ) {
		$page_id = absint( function_exists( 'pll_get_post' ) ? pll_get_post( $page_id ) : $page_id );
	} else {
		$page_id = 0;
	}
	return get_permalink( $page_id );
}

function tfcl_required_field( $field, $option_name ) {
	$required_fields = tfcl_get_option( $option_name, array() );
	if ( ( count( $required_fields ) > 0 ) && ( $required_fields[ $field ] == 1 ) ) {
		return '*';
	}
	return '';
}

function tfcl_get_taxonomy_options( $taxonomy_name, $selected_value = '', $is_value_slug = false, $display_default = true, $parent = 0, $prefix = '' ) {
	$taxonomies = get_categories(
		array(
			'taxonomy'   => $taxonomy_name,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
			'parent'     => $parent
		)
	);
	if ( $display_default && $parent === 0 ) {
		echo '<option value="" selected>' . esc_html__( 'None', 'tf-car-listing' ) . '</option>';
	}
	if ( ! empty( $taxonomies ) ) {
		foreach ( $taxonomies as $taxonomy ) {
			if ( empty( $taxonomy ) || ( ! isset( $taxonomy->parent ) ) )
				continue;
			if ( ( (int) $taxonomy->parent !== (int) $parent ) || ( $parent === null ) || ( $taxonomy->parent === null ) )
				continue;

			if ( $is_value_slug ) {
				echo '<option ' . selected( $selected_value, $taxonomy->slug, false ) . ' value="' . esc_attr( $taxonomy->slug ) . '">' . esc_html( $prefix . $taxonomy->name ) . '</option>';
			} else {
				echo '<option ' . selected( $selected_value, $taxonomy->term_id, false ) . ' value="' . esc_attr( $taxonomy->term_id ) . '">' . esc_html( $prefix . $taxonomy->name ) . '</option>';
			}

			tfcl_get_taxonomy_options( $taxonomy_name, $selected_value, $is_value_slug, $display_default, $taxonomy->term_id, $prefix . '' );
		}
	}
}

function tfcl_get_single_taxonomy_by_post_id( $post_id, $taxonomy_name, $is_value_slug ) {
	$tax_terms = get_the_terms( $post_id, $taxonomy_name );
	$tax_name  = '';
	if ( ! empty( $tax_terms ) ) {
		foreach ( $tax_terms as $tax_term ) {
			if ( is_object( $tax_term ) ) {
				if ( $is_value_slug ) {
					$tax_name = $tax_term->slug;
				} else {
					$tax_name = $tax_term->name;
				}
			}
			break;
		}
	}
	return $tax_name;
}

function tfcl_check_required_field( $field, $option_name ) {
	$required_fields = tfcl_get_option( $option_name, array() );
	if ( ( count( $required_fields ) > 0 ) && ( $required_fields[ $field ] == 1 ) ) {
		return true;
	}
	return false;
}

function tfcl_get_show_hide_field( $field, $option_name ) {
	$required_fields = tfcl_get_option( $option_name, array() );
	if ( ( count( $required_fields ) > 0 ) && ( $required_fields[ $field ] == 1 ) ) {
		return true;
	}
	return false;
}

function tfcl_get_template_with_arguments( $template_name, $arguments = array(), $template_path = '', $default_path = '' ) {
	if ( ! empty( $arguments ) && is_array( $arguments ) ) {
		extract( $arguments );
	}

	if ( ! $template_path ) {
		$template_path = TF_PLUGIN_PATH;
	}

	if ( ! $default_path ) {
		$default_path = TF_PLUGIN_PATH . '/public/templates/';
	}

	$template = locate_template( $template_name . '.php', false );

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	if ( ! file_exists( $template ) ) {
		return;
	}

	include( $template );
}

function tfcl_get_template_widget_elementor( $template_name, $args = array(), $return = false ) {
	$template_file  = $template_name . '.php';
	$default_folder = TF_PLUGIN_PATH . 'includes/elementor-widget/';
	$theme_folder   = TF_PLUGIN_PATH;
	$template       = locate_template( $theme_folder . '/' . $template_file );
	if ( ! $template ) {
		$template = $default_folder . $template_file;
	}
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}
	if ( $return ) {
		ob_start();
	}
	if ( file_exists( $template ) ) {
		include $template;
	}
	if ( $return ) {
		return ob_get_clean();
	}
	return null;
}

function tfcl_get_all_pages( $multi = false ) {
	$args  = array(
		'sort_order'   => 'asc',
		'sort_column'  => 'post_title',
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'authors'      => '',
		'child_of'     => 0,
		'parent'       => -1,
		'offset'       => 0,
		'post_type'    => 'page',
		'post_status'  => 'publish'
	);
	$data  = array();
	$pages = get_pages( $args );
	if ( $multi ) {
		$data[] = array( 'value' => '', 'label' => '' );
	}
	foreach ( (array) $pages as $page ) {
		if ( $multi ) {
			$data[] = array( 'value' => $page->ID, 'label' => $page->post_title );
		} else {
			$data[ $page->ID ] = $page->post_title;
		}
	}
	return $data;
}

function tfcl_is_dealer( $user_id = 0 ) {
	global $current_user;
	wp_get_current_user();
	$user_id   = ! empty( $user_id ) ? $user_id : $current_user->ID;
	$dealer_id = get_user_meta( $user_id, 'author_dealer_id', true );
	if ( ! empty( $dealer_id ) && ( get_post_type( $dealer_id ) == 'dealer' ) && ( get_post_status( $dealer_id ) == 'publish' ) ) {
		return true;
	}
	return false;
}

function tfcl_allow_submit_listing() {
	$allow_submit_listing_from_frontend = tfcl_get_option( 'allow_submit_listing_from_fe', 'y' );
	$all_user_can_submit_listing        = tfcl_get_option( 'all_user_can_submit_listing', 'y' );
	$is_dealer                          = tfcl_is_dealer();
	$allow_submit                       = true;
	if ( $allow_submit_listing_from_frontend != 'y' ) {
		$allow_submit = false;
	} else {
		if ( ! current_user_can( 'administrator' ) && ! $is_dealer && $all_user_can_submit_listing != 'y' ) {
			$allow_submit = false;
		}
	}
	return $allow_submit;
}

function tfcl_get_menu_user_login() {
	$menus           = array();
	$allow_submit    = tfcl_allow_submit_listing();
	$permalink       = get_permalink();
	$total_favorites = Car_Listing::tfcl_get_total_my_favorites();

	if ( tfcl_get_permalink( 'dashboard_page' ) ) {
		$menus[] = array(
			'priority' => 10,
			'label'    => esc_html__( 'Dashboard', 'tf-car-listing' ),
			'url'      => tfcl_get_permalink( 'dashboard_page' ),
			'icon'     => '<i class="icon-autodeal-dashboard"></i>',
			'total'    => false,
		);
	}

	if ( tfcl_get_permalink( 'my_listing_page' ) ) {
		$menus[] = array(
			'priority' => 20,
			'label'    => esc_html__( 'My Listing', 'tf-car-listing' ),
			'url'      => tfcl_get_permalink( 'my_listing_page' ),
			'icon'     => '<i class="icon-autodeal-note"></i>',
			'total'    => false,
		);
	}

	$enable_favorite = tfcl_get_option( 'enable_favorite', 'y' );
	if ( $enable_favorite == 'y' && tfcl_get_permalink( 'my_favorites_page' ) ) {
		$menus[] = array(
			'priority' => 30,
			'label'    => esc_html__( 'My Favorites', 'tf-car-listing' ),
			'url'      => tfcl_get_permalink( 'my_favorites_page' ),
			'icon'     => '<i class="icon-autodeal-love"></i>',
			'total'    => $total_favorites,
		);
	}

	if ( tfcl_get_permalink( 'my_reviews_page' ) ) {
		$menus[] = array(
			'priority' => 40,
			'label'    => esc_html__( 'My Reviews', 'tf-car-listing' ),
			'url'      => tfcl_get_permalink( 'my_reviews_page' ),
			'icon'     => '<i class="icon-autodeal-mail-account"></i>',
			'total'    => false,
		);
	}

	if ( tfcl_get_option( 'enable_package') == 'y' ) {
		if ( tfcl_get_permalink( 'package_page' ) ) {
			$menus[] = array(
				'priority' => 60,
				'label'    => esc_html__( 'My Package', 'tf-car-listing' ),
				'url'      => tfcl_get_permalink( 'package_page' ),
				'icon'     => '<i class="icon-autodeal-checklist"></i>',
				'total'    => false
			);
		}
	}

	if ( tfcl_get_permalink( 'my_profile_page' ) ) {
		$menus[] = array(
			'priority' => 70,
			'label'    => esc_html__( 'My Profile', 'tf-car-listing' ),
			'url'      => tfcl_get_permalink( 'my_profile_page' ),
			'icon'     => '<i class="icon-autodeal-user5"></i>',
			'total'    => false,
		);
	}

	if ( $allow_submit && tfcl_get_permalink( 'add_listing_page' ) ) {
		$menus[] = array(
			'priority' => 80,
			'label'    => esc_html__( 'Add Listing', 'tf-car-listing' ),
			'url'      => tfcl_get_permalink( 'add_listing_page' ),
			'icon'     => '<i class="icon-autodeal-note"></i>',
			'total'    => false,
		);
	}

	$menus[] = array(
		'priority' => 90,
		'label'    => esc_html__( 'Logout', 'tf-car-listing' ),
		'url'      => wp_logout_url( $permalink ),
		'icon'     => '<i class="icon-autodeal-logout"></i>',
		'total'    => false,
	);

	return $menus;
}

function tfcl_get_taxonomies( $category = 'category' ) {
	$category_posts_name = [];
	$category_posts      = get_terms(
		array(
			'taxonomy'   => $category,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => false,
		)
	);
	if ( ! empty( $category_posts ) ) {
		foreach ( $category_posts as $category_post ) {
			$category_posts_name[ $category_post->slug ] = $category_post->name;
		}

	}
	return $category_posts_name;
}

function tfcl_get_number_text( $number, $many_text, $singular_text ) {
	if ( $number == 0 || $number != 1 ) {
		return $many_text;
	} else {
		return $singular_text;
	}
}

function tfcl_get_link_order_dealer( $order ) {
	$link_order = add_query_arg( array( 'orderBy' => $order ) );
	return $link_order;
}


function tfcl_count_comments_by_meta( $comment_post_id, $meta_key, $meta_value ) {
	global $wpdb;

	$comments_table    = $wpdb->prefix . 'comments';
	$commentmeta_table = $wpdb->prefix . 'commentmeta';

	$sql = $wpdb->prepare(
		"SELECT COUNT(*) as total_count
		FROM $comments_table c
		JOIN $commentmeta_table m ON c.comment_ID = m.comment_id
		WHERE c.comment_post_ID = %d
			AND c.comment_approved = 1
			AND m.meta_key = %s
			AND m.meta_value = %s",
		$comment_post_id,
		$meta_key,
		$meta_value
	);

	return $wpdb->get_var( $sql );
}

function render_search_fields( $search_fields, $no_class = false ) {

	$attrs = array(
		'make_enable'         => tfcl_get_show_hide_field( 'listing-make', 'advanced_search_fields' ),
		'model_enable'        => tfcl_get_show_hide_field( 'listing-model', 'advanced_search_fields' ),
		'body_enable'         => tfcl_get_show_hide_field( 'listing-body', 'advanced_search_fields' ),
		'features_enable'     => tfcl_get_show_hide_field( 'listing-features', 'advanced_search_fields' ),
		'featured_enable'     => tfcl_get_show_hide_field( 'listing-featured', 'advanced_search_fields' ),
		'keyword_enable'      => tfcl_get_show_hide_field( 'listing-keyword', 'advanced_search_fields' ),
		'price_enable'        => tfcl_get_show_hide_field( 'listing-price', 'advanced_search_fields' ),
		'price_is_slider'     => ( tfcl_get_option( 'price_search_field_type', '' ) == 'slider' ),
		'fuel_type_enable'    => tfcl_get_show_hide_field( 'listing-fuel-type', 'advanced_search_fields' ),
		'transmission_enable' => tfcl_get_show_hide_field( 'listing-transmission', 'advanced_search_fields' ),
		'driver_type_enable'  => tfcl_get_show_hide_field( 'listing-driver-type', 'advanced_search_fields' ),
		'mileage_enable'      => tfcl_get_show_hide_field( 'listing-mileage', 'advanced_search_fields' ),
		'mileage_is_slider'   => ( tfcl_get_option( 'mileage_search_field_type', '' ) == 'slider' ),
		'door_enable'         => tfcl_get_show_hide_field( 'listing-door', 'advanced_search_fields' ),
		'door_is_slider'      => ( tfcl_get_option( 'door_search_field_type', '' ) == 'slider' ),
		'cylinder_enable'     => tfcl_get_show_hide_field( 'listing-cylinder', 'advanced_search_fields' ),
		'color_enable'        => tfcl_get_show_hide_field( 'listing-color', 'advanced_search_fields' ),
		'year_enable'         => tfcl_get_show_hide_field( 'listing-year', 'advanced_search_fields' ),
		'year_is_slider'      => ( tfcl_get_option( 'year_search_field_type', '' ) == 'slider' ),
		'engine_size_enable'      => tfcl_get_show_hide_field( 'listing-engine-size', 'advanced_search_fields' ),

	);

	$condition_enable = $make_enable = $model_enable = $features_enable = $door_enable = $door_is_slider = $featured_enable = $keyword_enable = $engine_size_enable = $price_enable = $price_is_slider = $fuel_type_enable = $transmission_enable = $driver_type_enable = $mileage_enable = $mileage_is_slider = $cylinder_enable = $color_enable = $year_enable = $year_is_slider = $body_enable = '';

	extract(
		shortcode_atts(
			array(
				'condition_enable'    => 'true',
				'make_enable'         => 'true',
				'body_enable'         => 'true',
				'model_enable'        => 'true',
				'featured_enable'     => 'true',
				'features_enable'     => 'true',
				'keyword_enable'      => 'true',
				'price_enable'        => 'true',
				'price_is_slider'     => 'true',
				'fuel_type_enable'    => 'true',
				'transmission_enable' => 'true',
				'driver_type_enable'  => 'true',
				'mileage_enable'      => 'true',
				'mileage_is_slider'   => 'true',
				'cylinder_enable'     => 'true',
				'color_enable'        => 'true',
				'door_enable'         => 'false',
				'door_is_slider'      => 'false',
				'year_enable'         => 'true',
				'year_is_slider'      => 'true',
				'engine_size_enable'      => 'true'
			),
			$attrs
		)
	);

	$condition_default      = '';
	$value_condition        = isset( $_GET['condition'] ) ? ( wp_unslash( $_GET['condition'] ) ) : $condition_default;
	$value_make             = isset( $_GET['make'] ) ? ( wp_unslash( $_GET['make'] ) ) : '';
	$value_model            = isset( $_GET['model'] ) ? ( wp_unslash( $_GET['model'] ) ) : '';
	$value_body             = isset( $_GET['body'] ) ? ( wp_unslash( $_GET['body'] ) ) : '';
	$value_keyword          = isset( $_GET['keyword'] ) ? ( wp_unslash( $_GET['keyword'] ) ) : '';
	$value_fuel_type        = isset( $_GET['fuel_type'] ) ? ( wp_unslash( $_GET['fuel_type'] ) ) : '';
	$value_transmission     = isset( $_GET['transmission'] ) ? ( wp_unslash( $_GET['transmission'] ) ) : '';
	$value_driver_type      = isset( $_GET['driver_type'] ) ? ( wp_unslash( $_GET['driver_type'] ) ) : '';
	$value_cylinder         = isset( $_GET['cylinder'] ) ? ( wp_unslash( $_GET['cylinder'] ) ) : '';
	$value_max_door         = isset( $_GET['max-door'] ) ? ( wp_unslash( $_GET['max-door'] ) ) : '';
	$value_min_door         = isset( $_GET['min-door'] ) ? ( wp_unslash( $_GET['min-door'] ) ) : '';
	$value_min_mileage      = isset( $_GET['min-mileage'] ) ? ( wp_unslash( $_GET['min-mileage'] ) ) : '';
	$value_max_mileage      = isset( $_GET['max-mileage'] ) ? ( wp_unslash( $_GET['max-mileage'] ) ) : '';
	$value_color            = isset( $_GET['car-color'] ) ? ( wp_unslash( $_GET['car-color'] ) ) : '';
	$value_min_price        = isset( $_GET['min-price'] ) ? ( wp_unslash( $_GET['min-price'] ) ) : '';
	$value_max_price        = isset( $_GET['max-price'] ) ? ( wp_unslash( $_GET['max-price'] ) ) : '';
	$value_min_year         = isset( $_GET['min-year'] ) ? ( wp_unslash( $_GET['min-year'] ) ) : '';
	$value_max_year         = isset( $_GET['max-year'] ) ? ( wp_unslash( $_GET['max-year'] ) ) : '';
	$enable_search_features = isset( $_GET['enable-search-features'] ) ? ( wp_unslash( $_GET['enable-search-features'] ) ) : ( tfcl_get_option( 'toggle_listing_features', 'n' ) == 'y' ? '0' : '1' );
	$value_features         = isset( $_GET['features'] ) ? ( wp_unslash( $_GET['features'] ) ) : '';
	$value_featured         = isset( $_GET['featured'] ) ? ( wp_unslash( $_GET['featured'] ) ) : '';
	$value_engine_size          = isset( $_GET['engine_size'] ) ? ( wp_unslash( $_GET['engine_size'] ) ) : '';
	$css_class_field        = '';

	if ( ! empty( $value_features ) ) {
		$value_features = explode( ',', $value_features );
	}

	if ( $search_fields ) :
		foreach ( $search_fields as $field => $value ) {
			switch ( $field ) {
				case 'listing-condition':
					if ( $condition_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_condition' => $value_condition,
							)
						);
					}
					break;
				case 'listing-make':
					if ( $make_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_make' => $value_make,
							)
						);
					}
					break;
				case 'listing-model':
					if ( $model_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_model' => $value_model,
							)
						);
					}
					break;
				case 'listing-body':
					if ( $body_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_body' => $value_body,
							)
						);
					}
					break;
				case 'listing-price':
					if ( $price_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_min_price' => $value_min_price,
								'value_max_price' => $value_max_price,
								'price_is_slider' => $price_is_slider,
							)
						);
					}
					break;
				case 'listing-features':
					if ( $features_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'css_class_field'                => $css_class_field,
								'enable_search_features'         => $enable_search_features,
								'enable_toggle_listing_features' => tfcl_get_option( 'toggle_listing_features', 'n' ),
								'value_features'                 => $value_features,
							)
						);
					}
					break;
				case 'listing-featured':
					if ( $featured_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_featured' => $value_featured
							)
						);
					}
					break;
				case 'listing-mileage':
					if ( $mileage_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_min_mileage' => $value_min_mileage,
								'value_max_mileage' => $value_max_mileage,
								'mileage_is_slider' => $mileage_is_slider,
							)
						);
					}
					break;
				case 'listing-door':
					if ( $door_enable == 'true' ) {
						if ( tfcl_get_option( 'door_search_field_type' ) == 'dropdown' ) {
							$value_door = isset( $_GET['door'] ) ? ( wp_unslash( $_GET['door'] ) ) : '';
							tfcl_get_template_with_arguments(
								'advanced-search/advanced-search-fields/' . $field . '.php',
								array(
									'value_door'     => $value_door,
									'door_is_slider' => $door_is_slider,
								)
							);
						} else {
							tfcl_get_template_with_arguments(
								'advanced-search/advanced-search-fields/' . $field . '.php',
								array(
									'value_min_door' => $value_min_door,
									'value_max_door' => $value_max_door,
									'door_is_slider' => $door_is_slider,
								)
							);
						}

					}
					break;
				case 'listing-keyword':
					if ( $keyword_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_keyword' => $value_keyword
							)
						);
					}
					break;
				case 'listing-fuel-type':
					if ( $fuel_type_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_fuel_type' => $value_fuel_type
							)
						);
					}
					break;
				case 'listing-color':
					if ( $color_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_color' => $value_color,
							)
						);
					}
					break;
				case 'listing-transmission':
					if ( $transmission_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_transmission' => $value_transmission
							)
						);
					}
					break;
				case 'listing-cylinder':
					if ( $cylinder_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_cylinder' => $value_cylinder,
							)
						);
					}
					break;
				case 'listing-driver-type':
					if ( $driver_type_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_drive_type' => $value_driver_type
							)
						);
					}
					break;
				case 'listing-year':
					if ( $year_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_min_year' => $value_min_year,
								'value_max_year' => $value_max_year,
								'year_is_slider' => $year_is_slider,
							)
						);
					}
					break;
				case 'listing-engine-size':
					if ( $engine_size_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_engine_size' => $value_engine_size
							)
						);
					}
					break;
				default:
					break;
			}
		}
	endif;
}

function render_search_filter_fields( $search_fields, $no_class = false ) {

	$attrs = array(
		'make_enable'         => tfcl_get_show_hide_field( 'listing-make', 'search_filter_fields' ),
		'model_enable'        => tfcl_get_show_hide_field( 'listing-model', 'search_filter_fields' ),
		'body_enable'         => tfcl_get_show_hide_field( 'listing-body', 'search_filter_fields' ),
		'features_enable'     => tfcl_get_show_hide_field( 'listing-features', 'search_filter_fields' ),
		'featured_enable'     => tfcl_get_show_hide_field( 'listing-featured', 'search_filter_fields' ),
		'keyword_enable'      => tfcl_get_show_hide_field( 'listing-keyword', 'search_filter_fields' ),
		'door_enable'         => tfcl_get_show_hide_field( 'listing-door', 'search_filter_fields' ),
		'door_is_slider'      => ( tfcl_get_option( 'door_search_field_type', '' ) == 'slider' ),
		'mileage_enable'      => tfcl_get_show_hide_field( 'listing-mileage', 'search_filter_fields' ),
		'mileage_is_slider'   => ( tfcl_get_option( 'mileage_search_field_type', '' ) == 'slider' ),
		'price_enable'        => tfcl_get_show_hide_field( 'listing-price', 'search_filter_fields' ),
		'price_is_slider'     => ( tfcl_get_option( 'price_search_field_type', '' ) == 'slider' ),
		'fuel_type_enable'    => tfcl_get_show_hide_field( 'listing-fuel-type', 'search_filter_fields' ),
		'transmission_enable' => tfcl_get_show_hide_field( 'listing-transmission', 'search_filter_fields' ),
		'driver_type_enable'  => tfcl_get_show_hide_field( 'listing-driver-type', 'search_filter_fields' ),
		'cylinder_enable'     => tfcl_get_show_hide_field( 'listing-cylinder', 'search_filter_fields' ),
		'color_enable'        => tfcl_get_show_hide_field( 'listing-color', 'search_filter_fields' ),
		'year_enable'         => tfcl_get_show_hide_field( 'listing-year', 'search_filter_fields' ),
		'year_is_slider'      => ( tfcl_get_option( 'year_search_field_type', '' ) == 'slider' ),
		'engine_size_enable'      => tfcl_get_show_hide_field( 'listing-engine-size', 'search_filter_fields' ),

	);

	$condition_enable = $make_enable = $model_enable = $features_enable = $door_enable = $featured_enable = $keyword_enable = $engine_size_enable = $price_enable = $price_is_slider = $fuel_type_enable = $transmission_enable = $driver_type_enable = $mileage_enable = $mileage_is_slider = $cylinder_enable = $color_enable = $year_enable = $year_is_slider = $body_enable = '';

	extract(
		shortcode_atts(
			array(
				'condition_enable'    => 'true',
				'make_enable'         => 'true',
				'body_enable'         => 'true',
				'model_enable'        => 'true',
				'featured_enable'     => 'true',
				'features_enable'     => 'true',
				'keyword_enable'      => 'true',
				'door_enable'         => 'true',
				'door_is_slider'      => 'true',
				'price_enable'        => 'true',
				'price_is_slider'     => 'true',
				'fuel_type_enable'    => 'true',
				'transmission_enable' => 'true',
				'driver_type_enable'  => 'true',
				'mileage_enable'      => 'true',
				'mileage_is_slider'   => 'true',
				'cylinder_enable'     => 'true',
				'color_enable'        => 'true',
				'year_enable'         => 'true',
				'year_is_slider'      => 'true',
				'engine_size_enable'      => 'true'
			),
			$attrs
		)
	);

	$condition_default      = '';
	$value_condition        = isset( $_GET['condition'] ) ? ( wp_unslash( $_GET['condition'] ) ) : $condition_default;
	$value_make             = isset( $_GET['make'] ) ? ( wp_unslash( $_GET['make'] ) ) : '';
	$value_model            = isset( $_GET['model'] ) ? ( wp_unslash( $_GET['model'] ) ) : '';
	$value_body             = isset( $_GET['body'] ) ? ( wp_unslash( $_GET['body'] ) ) : '';
	$value_keyword          = isset( $_GET['keyword'] ) ? ( wp_unslash( $_GET['keyword'] ) ) : '';
	$value_fuel_type        = isset( $_GET['fuel_type'] ) ? ( wp_unslash( $_GET['fuel_type'] ) ) : '';
	$value_transmission     = isset( $_GET['transmission'] ) ? ( wp_unslash( $_GET['transmission'] ) ) : '';
	$value_driver_type      = isset( $_GET['driver_type'] ) ? ( wp_unslash( $_GET['driver_type'] ) ) : '';
	$value_cylinder         = isset( $_GET['cylinder'] ) ? ( wp_unslash( $_GET['cylinder'] ) ) : '';
	$value_max_door         = isset( $_GET['max-door'] ) ? ( wp_unslash( $_GET['max-door'] ) ) : '';
	$value_min_door         = isset( $_GET['min-door'] ) ? ( wp_unslash( $_GET['min-door'] ) ) : '';
	$value_min_price        = isset( $_GET['min-price'] ) ? ( wp_unslash( $_GET['min-price'] ) ) : '';
	$value_max_price        = isset( $_GET['max-price'] ) ? ( wp_unslash( $_GET['max-price'] ) ) : '';
	$value_min_year         = isset( $_GET['min-year'] ) ? ( wp_unslash( $_GET['min-year'] ) ) : '';
	$value_max_year         = isset( $_GET['max-year'] ) ? ( wp_unslash( $_GET['max-year'] ) ) : '';
	$value_min_mileage      = isset( $_GET['min-mileage'] ) ? ( wp_unslash( $_GET['min-mileage'] ) ) : '';
	$value_max_mileage      = isset( $_GET['max-mileage'] ) ? ( wp_unslash( $_GET['max-mileage'] ) ) : '';
	$enable_search_features = isset( $_GET['enable-search-features'] ) ? ( wp_unslash( $_GET['enable-search-features'] ) ) : ( tfcl_get_option( 'toggle_listing_features', 'n' ) == 'y' ? '0' : '1' );
	$value_features         = isset( $_GET['features'] ) ? ( wp_unslash( $_GET['features'] ) ) : '';
	$value_featured         = isset( $_GET['featured'] ) ? ( wp_unslash( $_GET['featured'] ) ) : '';
	$value_color            = isset( $_GET['car_color'] ) ? ( wp_unslash( $_GET['car_color'] ) ) : '';
	$value_engine_size      = isset( $_GET['engine_size'] ) ? ( wp_unslash( $_GET['engine_size'] ) ) : '';
	$css_class_field        = '';

	if ( ! empty( $value_features ) ) {
		$value_features = explode( ',', $value_features );
	}

	if ( $search_fields ) :
		foreach ( $search_fields as $field => $value ) {
			switch ( $field ) {
				case 'listing-condition':
					if ( $condition_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_condition' => $value_condition,
							)
						);
					}
					break;
				case 'listing-make':
					if ( $make_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_make' => $value_make,
							)
						);
					}
					break;
				case 'listing-model':
					if ( $model_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_model' => $value_model,
							)
						);
					}
					break;
				case 'listing-body':
					if ( $body_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_body' => $value_body,
							)
						);
					}
					break;
				case 'listing-price':
					if ( $price_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_min_price' => $value_min_price,
								'value_max_price' => $value_max_price,
								'price_is_slider' => $price_is_slider,
							)
						);
					}
					break;
				case 'listing-features':
					if ( $features_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'css_class_field'                => $css_class_field,
								'enable_search_features'         => $enable_search_features,
								'enable_toggle_listing_features' => tfcl_get_option( 'toggle_listing_features', 'n' ),
								'value_features'                 => $value_features,
							)
						);
					}
					break;
				case 'listing-featured':
					if ( $featured_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_featured' => $value_featured
							)
						);
					}
					break;
				case 'listing-mileage':
					if ( $mileage_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_min_mileage' => $value_min_mileage,
								'value_max_mileage' => $value_max_mileage,
								'mileage_is_slider' => $mileage_is_slider,
							)
						);

					}
					break;
				case 'listing-door':
					if ( $door_enable == 'true' ) {
						if ( tfcl_get_option( 'door_search_field_type' ) == 'dropdown' ) {
							$value_door = isset( $_GET['door'] ) ? ( wp_unslash( $_GET['door'] ) ) : '';
							tfcl_get_template_with_arguments(
								'advanced-search/advanced-search-fields/' . $field . '.php',
								array(
									'value_door'     => $value_door,
									'door_is_slider' => $door_is_slider,
								)
							);
						} else {
							tfcl_get_template_with_arguments(
								'advanced-search/advanced-search-fields/' . $field . '.php',
								array(
									'value_min_door' => $value_min_door,
									'value_max_door' => $value_max_door,
									'door_is_slider' => $door_is_slider,
								)
							);
						}

					}
					break;
				case 'listing-keyword':
					if ( $keyword_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_keyword' => $value_keyword
							)
						);
					}
					break;
				case 'listing-fuel-type':
					if ( $fuel_type_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_fuel_type' => $value_fuel_type
							)
						);
					}
					break;
				case 'listing-color':
					if ( $color_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_color' => $value_color,
							)
						);
					}
					break;
				case 'listing-transmission':
					if ( $transmission_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_transmission' => $value_transmission
							)
						);
					}
					break;
				case 'listing-cylinder':
					if ( $cylinder_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_cylinder' => $value_cylinder,
							)
						);
					}
					break;
				case 'listing-driver-type':
					if ( $driver_type_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_drive_type' => $value_driver_type
							)
						);
					}
					break;
				case 'listing-year':
					if ( $year_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_min_year' => $value_min_year,
								'value_max_year' => $value_max_year,
								'year_is_slider' => $year_is_slider,
							)
						);
					}
					break;
				case 'listing-engine-size':
					if ( $engine_size_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_engine_size' => $value_engine_size
							)
						);
					}
					break;
				default:
					break;
			}
		}
	endif;
}

function render_search_fields_widget_elementor( $search_fields_type, $settings, $no_class = false ) {
	$search_fields = $settings[ $search_fields_type ];
	$attrs         = array(
		'make_enable'         => tfcl_get_show_hide_field( 'listing-make', 'advanced_search_fields' ),
		'model_enable'        => tfcl_get_show_hide_field( 'listing-model', 'advanced_search_fields' ),
		'body_enable'         => tfcl_get_show_hide_field( 'listing-body', 'advanced_search_fields' ),
		'features_enable'     => tfcl_get_show_hide_field( 'listing-features', 'advanced_search_fields' ),
		'featured_enable'     => tfcl_get_show_hide_field( 'listing-featured', 'advanced_search_fields' ),
		'keyword_enable'      => tfcl_get_show_hide_field( 'listing-keyword', 'advanced_search_fields' ),
		'mileage_enable'      => tfcl_get_show_hide_field( 'listing-mileage', 'advanced_search_fields' ),
		'mileage_is_slider'   => ( tfcl_get_option( 'mileage_search_field_type', '' ) == 'slider' ),
		'door_enable'         => tfcl_get_show_hide_field( 'listing-door', 'advanced_search_fields' ),
		'door_is_slider'      => ( tfcl_get_option( 'door_search_field_type', '' ) == 'slider' ),
		'price_enable'        => tfcl_get_show_hide_field( 'listing-price', 'advanced_search_fields' ),
		'price_is_slider'     => ( tfcl_get_option( 'price_search_field_type', '' ) == 'slider' ),
		'fuel_type_enable'    => tfcl_get_show_hide_field( 'listing-fuel-type', 'advanced_search_fields' ),
		'transmission_enable' => tfcl_get_show_hide_field( 'listing-transmission', 'advanced_search_fields' ),
		'driver_type_enable'  => tfcl_get_show_hide_field( 'listing-driver-type', 'advanced_search_fields' ),
		'cylinder_enable'     => tfcl_get_show_hide_field( 'listing-cylinder', 'advanced_search_fields' ),
		'color_enable'        => tfcl_get_show_hide_field( 'listing-color', 'advanced_search_fields' ),
		'year_enable'         => tfcl_get_show_hide_field( 'listing-year', 'advanced_search_fields' ),
		'year_is_slider'      => ( tfcl_get_option( 'year_search_field_type', '' ) == 'slider' ),
		'engine_size_enable'      => tfcl_get_show_hide_field( 'listing-engine-size', 'advanced_search_fields' ),

	);

	$condition_enable = $make_enable = $model_enable = $features_enable = $featured_enable = $body_enable = $keyword_enable = $engine_size_enable = $price_enable = $price_is_slider = $fuel_type_enable = $transmission_enable = $driver_type_enable = $mileage_enable = $mileage_is_slider = $door_enable = $door_is_slider = $cylinder_enable = $color_enable = $year_enable = $year_is_slider = '';

	extract(
		shortcode_atts(
			array(
				'condition_enable'    => 'true',
				'make_enable'         => 'true',
				'model_enable'        => 'true',
				'body_enable'         => 'true',
				'features_enable'     => 'true',
				'featured_enable'     => 'true',
				'keyword_enable'      => 'true',
				'price_enable'        => 'true',
				'price_is_slider'     => 'true',
				'fuel_type_enable'    => 'true',
				'transmission_enable' => 'true',
				'driver_type_enable'  => 'true',
				'mileage_enable'      => 'true',
				'mileage_is_slider'   => 'true',
				'door_enable'         => 'true',
				'door_is_slider'      => 'true',
				'cylinder_enable'     => 'true',
				'color_enable'        => 'true',
				'year_enable'         => 'true',
				'year_is_slider'      => 'true',
				'engine_size_enable'        => 'true',
			),
			$attrs
		)
	);


	$condition_default    = '';
	$value_condition      = isset( $_GET['condition'] ) ? ( wp_unslash( $_GET['condition'] ) ) : $condition_default;
	$css_class_field      = $no_class ? '' : 'col-xl-3 col-md-6 col-xs-12';
	$css_class_half_field = $no_class ? '' : 'col-xl-3 col-md-6 col-xs-12';
	$value_make           = '';
	$value_min_price      = isset( $_GET['min-price'] ) ? ( wp_unslash( $_GET['min-price'] ) ) : '';
	$value_max_price      = isset( $_GET['max-price'] ) ? ( wp_unslash( $_GET['max-price'] ) ) : '';
	$value_min_year       = isset( $_GET['min-year'] ) ? ( wp_unslash( $_GET['min-year'] ) ) : '';
	$value_max_year       = isset( $_GET['max-year'] ) ? ( wp_unslash( $_GET['max-year'] ) ) : '';
	$value_max_mileage    = isset( $_GET['max-mileage'] ) ? ( wp_unslash( $_GET['max-mileage'] ) ) : '';
	$value_min_mileage    = isset( $_GET['min-mileage'] ) ? ( wp_unslash( $_GET['min-mileage'] ) ) : '';
	$value_max_door       = isset( $_GET['max-door'] ) ? ( wp_unslash( $_GET['max-door'] ) ) : '';
	$value_min_door       = isset( $_GET['min-door'] ) ? ( wp_unslash( $_GET['min-door'] ) ) : '';

	$enable_search_features = isset( $_GET['enable-search-features'] ) ? ( wp_unslash( $_GET['enable-search-features'] ) ) : ( tfcl_get_option( 'toggle_listing_features', 'n' ) == 'y' ? '0' : '1' );
	$value_features         = isset( $_GET['features'] ) ? ( wp_unslash( $_GET['features'] ) ) : '';
	$value_color            = isset( $_GET['car-color'] ) ? ( wp_unslash( $_GET['car-color'] ) ) : '';
	$value_engine_size            = isset( $_GET['engine_size'] ) ? ( wp_unslash( $_GET['engine_size'] ) ) : '';

	if ( ! empty( $value_features ) ) {
		$value_features = explode( ',', $value_features );
	}

	$value_featured = isset( $_GET['featured'] ) ? ( wp_unslash( $_GET['featured'] ) ) : '';

	if ( $search_fields ) :
		foreach ( $search_fields as $field => $value ) {
			switch ( $value ) {
				case 'listing-condition':
					if ( $condition_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $field . '.php',
							array(
								'value_condition' => $value_condition,
							)
						);
					}
					break;
				case 'listing-make':
					if ( $make_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_make' => $value_make,
								'settings'   => $settings
							)
						);
					}
					break;
				case 'listing-model':
					if ( $model_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_model' => '',
								'settings'    => $settings
							)
						);
					}
					break;
				case 'listing-body':
					if ( $body_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_body' => '',
								'settings'   => $settings
							)
						);
					}
					break;
				case 'listing-features':
					if ( $features_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'css_class_field'                => $css_class_field,
								'enable_search_features'         => $enable_search_features,
								'enable_toggle_listing_features' => tfcl_get_option( 'toggle_listing_features', 'n' ),
								'value_features'                 => $value_features,
							)
						);
					}
					break;
				case 'listing-featured':
					if ( $featured_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_featured' => $value_featured,
							)
						);
					}
					break;
				case 'listing-price':
					if ( $price_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_min_price' => $value_min_price,
								'value_max_price' => $value_max_price,
								'price_is_slider' => $price_is_slider,
								'settings'        => $settings
							)
						);
					}
					break;
				case 'listing-keyword':
					if ( $keyword_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_keyword' => '',
								'settings'      => $settings
							)
						);
					}
					break;
				case 'listing-mileage':
					if ( $mileage_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_min_mileage' => $value_min_mileage,
								'value_max_mileage' => $value_max_mileage,
								'mileage_is_slider' => $mileage_is_slider,
								'settings'          => $settings
							)
						);
					}
					break;
				case 'listing-door':
					if ( $door_enable == 'true' ) {
						if ( tfcl_get_option( 'door_search_field_type' ) == 'dropdown' ) {
							$value_door = isset( $_GET['door'] ) ? ( wp_unslash( $_GET['door'] ) ) : '';
							tfcl_get_template_with_arguments(
								'advanced-search/advanced-search-fields/' . $value . '.php',
								array(
									'value_door'     => $value_door,
									'door_is_slider' => $door_is_slider,
									'settings'       => $settings
								)
							);
						} else {
							tfcl_get_template_with_arguments(
								'advanced-search/advanced-search-fields/' . $value . '.php',
								array(
									'value_min_door' => $value_min_door,
									'value_max_door' => $value_max_door,
									'door_is_slider' => $door_is_slider,
									'settings'       => $settings
								)
							);
						}
					}
					break;
				case 'listing-fuel-type':
					if ( $fuel_type_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_type' => '',
								'settings'   => $settings
							)
						);
					}
					break;
				case 'listing-color':
					if ( $color_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_color' => $value_color,
								'settings'    => $settings
							)
						);
					}
					break;
				case 'listing-transmission':
					if ( $transmission_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_transmission' => '',
								'settings'           => $settings
							)
						);
					}
					break;
				case 'listing-cylinder':
					if ( $cylinder_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_cylinder' => '',
								'settings'       => $settings
							)
						);
					}
					break;
				case 'listing-driver-type':
					if ( $driver_type_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_drive_type' => '',
								'settings'         => $settings
							)
						);
					}
					break;
				case 'listing-year':
					if ( $year_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_min_year' => $value_min_year,
								'value_max_year' => $value_max_year,
								'year_is_slider' => $year_is_slider,
								'settings'       => $settings
							)
						);
					}
					break;
				case 'listing-engine-size':
					if ( $engine_size_enable == 'true' ) {
						tfcl_get_template_with_arguments(
							'advanced-search/advanced-search-fields/' . $value . '.php',
							array(
								'value_engine_size' => '',
								'settings'      => $settings
							)
						);
					}
					break;
				default:
					break;
			}
		}
	endif;
}

function tfcl_get_option_make_advanced_search( $value_make = '', $prefix = '' ) {
	$options = tfcl_get_categories( 'make' );
	if ( ! empty( $options ) ) {
		foreach ( $options as $term ) {
			if ( $value_make == $term->slug ) {
				echo '<option value="' . esc_attr( $term->slug ) . '" data-id="' . $term->term_id . '" selected>' . esc_html( $prefix . $term->name ) . '</option>';
			} else {
				echo '<option value="' . esc_attr( $term->slug ) . '" data-id="' . $term->term_id . '">' . esc_html( $prefix . $term->name ) . '</option>';
			}
		}
	}
}

function tfcl_get_option_model_advanced_search( $value_model = '', $prefix = '' ) {
	$options = tfcl_get_categories( 'model' );
	if ( ! empty( $options ) ) {
		foreach ( $options as $term ) {
			if ( $value_model == $term->slug ) {
				echo '<option value="' . esc_attr( $term->slug ) . '" selected>' . esc_html( $prefix . $term->name ) . '</option>';
			} else {
				echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $prefix . $term->name ) . '</option>';
			}
		}
	}
}

function tfcl_get_option_transmission_advanced_search( $value_transmission = '', $prefix = '' ) {
	$options = tfcl_get_categories( 'transmission' );
	if ( ! empty( $options ) ) {
		foreach ( $options as $term ) {
			if ( $value_transmission == $term->slug ) {
				echo '<option value="' . esc_attr( $term->slug ) . '" selected>' . esc_html( $prefix . $term->name ) . '</option>';
			} else {
				echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $prefix . $term->name ) . '</option>';
			}
		}
	}
}

function tfcl_get_option_advanced_search( $value = '', $prefix = '', $cate = '', $parentField = '', $parentFieldValue = '' ) {
	$options = tfcl_get_categories( $cate );

	if ( ! empty( $options ) ) {
		if ( is_tax() ) {
			$current_term = get_queried_object();
		}
		if ( ! empty( $parentField ) && $parentField == 'make' ) {
			if ( ! empty( $parentFieldValue ) ) {
				$optionsModel = onloadModelByMake( $parentFieldValue, 1, '1' );
				echo $optionsModel;
			}
		} else {
			foreach ( $options as $term ) {
				$is_selected = ( $value === $term->slug || ( ! empty( $current_term ) && $current_term->slug === $term->slug ) );

				echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $is_selected, true, false ) . '>' . esc_html( $prefix . $term->name ) . '</option>';
			}
		}

	}
}

function onloadModelByMake( $make, $type, $is_slug ) {
	$selected_index = 0;
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

		$selected_index = count( $taxonomy_terms ) >= 2 ? 1 : 0;
	} else {
		$taxonomy_terms = tfcl_get_categories( 'model' );
		$selected_index = 0;
	}

	$html = '';

	if ( ! empty( $taxonomy_terms ) ) {
		if ( isset( $is_slug ) && ( $is_slug == '0' ) ) {
			foreach ( $taxonomy_terms as $index => $term ) {
				if ( $_GET['model'] == $term->slug ) {
					$selected_index = $index;
				}
				$selected = ( $type == 1 && $index === $selected_index ) ? ' selected' : '';
				$html .= '<option value="' . esc_attr( $term->term_id ) . '"' . $selected . '>' . esc_html( $term->name ) . '</option>';
			}
		} else {
			foreach ( $taxonomy_terms as $index => $term ) {
				if ( $_GET['model'] == $term->slug ) {
					$selected_index = $index;
				}
				$selected = ( $type == 1 && $index === $selected_index ) ? ' selected' : '';
				$html .= '<option value="' . esc_attr( $term->slug ) . '"' . $selected . '>' . esc_html( $term->name ) . '</option>';
			}
		}
	} else {
		$html .= '<option value="">' . esc_html__( 'None', 'tf-car-listing' ) . '</option>';
	}

	return wp_kses( $html, array(
		'option' => array(
			'value'    => true,
			'selected' => true
		)
	) );
}

function tfcl_count_review_dealer( $comment_post_id ) {
	global $wpdb;
	$comments_table = $wpdb->prefix . 'comments';
	$sql            = $wpdb->prepare(
		"SELECT COUNT(*)
		FROM $comments_table c
		WHERE c.comment_post_ID = %d
		AND c.comment_approved = 1
		",
		$comment_post_id
	);

	return $wpdb->get_var( $sql );
}


// calculate overall rating for dealer
function tfcl_cal_overall_rating_dealer( $dealer_id, $key ) {
	$ratings      = array();
	$ratings['1'] = tfcl_count_comments_by_meta( $dealer_id, $key, 1 );
	$ratings['2'] = tfcl_count_comments_by_meta( $dealer_id, $key, 2 );
	$ratings['3'] = tfcl_count_comments_by_meta( $dealer_id, $key, 3 );
	$ratings['4'] = tfcl_count_comments_by_meta( $dealer_id, $key, 4 );
	$ratings['5'] = tfcl_count_comments_by_meta( $dealer_id, $key, 5 );
	$total_star   = array_sum( $ratings );

	$overall_rate = 0;
	$percent_rate = 0;
	if ( $total_star > 0 ) {
		$overall_rate = round( ( 1 * $ratings['1'] + 2 * $ratings['2'] + 3 * $ratings['3'] + 4 * $ratings['4'] + 5 * $ratings['5'] ) / $total_star, 1 );
		$percent_rate = ( $overall_rate / 5 ) * 100;
	}
	return [ 
		'overall_rate' => $overall_rate,
		'percent_rate' => $percent_rate
	];
}


function tfcl_get_categories( $category_name ) {
	$list_categories = get_categories(
		array(
			'taxonomy'   => $category_name,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'parent'     => 0
		)
	);
	return $list_categories;
}

function tfcl_get_additional_fields() {
	$additional_fields  = tfcl_get_option( 'additional_fields' );
	$configs            = array();
	$first_option_value = '';
	if ( $additional_fields && is_array( $additional_fields ) ) {
		foreach ( $additional_fields as $key => $field ) {
			switch ( $key ) {
				case 'additional_field_icon':
					for ( $i = 0; $i <= count( $field ) - 1; $i++ ) {
						$configs[ $additional_fields['additional_field_name'][ $i ] ]['icon']   = $field[ $i ];
					}
					break;
				case 'additional_field_label':
					for ( $i = 0; $i <= count( $field ) - 1; $i++ ) {
						$configs[ $additional_fields['additional_field_name'][ $i ] ]['title']   = $field[ $i ];
						$configs[ $additional_fields['additional_field_name'][ $i ] ]['section'] = 'additional-custom-fields';
					}
					break;
				case 'additional_field_type':
					for ( $i = 0; $i <= count( $field ) - 1; $i++ ) {
						$configs[ $additional_fields['additional_field_name'][ $i ] ]['type'] = $field[ $i ];
					}
					break;
				case 'additional_field_option_value':
					for ( $i = 0; $i <= count( $field ) - 1; $i++ ) {
						$choices = array();
						if ( in_array( $additional_fields['additional_field_type'][ $i ], array( 'radio', 'checkbox' ) ) ) {
							foreach ( $field[ $i ] as $key => $value ) {
								$choices[ preg_replace( "/[-]+/i", "-", str_replace( " ", "-", $value ) ) ] = array(
									'label' => esc_html__( $value ),
								);
							}
							$configs[ $additional_fields['additional_field_name'][ $i ] ]['choices'] = $choices;
							$first_option_value                                                      = preg_replace( "/[-]+/i", "-", str_replace( " ", "-", $field[ $i ][0] ) );
							$configs[ $additional_fields['additional_field_name'][ $i ] ]['default'] = $first_option_value;
						} else if ( $additional_fields['additional_field_type'][ $i ] == 'select' ) {
							foreach ( $field[ $i ] as $key => $value ) {
								$choices[ preg_replace( "/[-]+/i", "-", str_replace( " ", "-", $value ) ) ] = esc_html__( $value );
							}
							$configs[ $additional_fields['additional_field_name'][ $i ] ]['choices'] = $choices;
						}
					}
					break;
				default:
					# code...
					break;
			}
		}
	}
	return $configs;
}

function tfcl_get_payment_method( $payment_method ) {
	$payment_text = '';
	switch ( $payment_method ) {
		case 'paypal':
			$payment_text = esc_html__( 'Paypal', 'tf-car-listing' );
			break;
		case 'wire_transfer':
			$payment_text = esc_html__( 'Wire Trasfer', 'tf-car-listing' );
			break;
		case 'free_package':
			$payment_text = esc_html__( 'Free Package', 'tf-car-listing' );
			break;
		case 'stripe':
			$payment_text = esc_html__( 'Stripe', 'tf-car-listing' );
			break;
		default:
			# code...
			break;
	}
	return $payment_text;
}

function tfcl_get_format_number( $number, $decimals = 0 ) {
	if ( $number === '' ) {
		return 0;
	}

	$number_floor = floor( $number );

	$decimal_sep   = tfcl_get_option( 'decimal_separator', '.' );
	$thousands_sep = tfcl_get_option( 'thousand_separator', ',' );
	$number_floor  = number_format( $number_floor, $decimals, $decimal_sep, $thousands_sep );


	$number_decimal       = $number . '';
	$number_decimal_index = strpos( $number_decimal, $decimal_sep );

	if ( $number_decimal_index !== false ) {
		$number_decimal = substr( $number_decimal, $number_decimal_index + 1 );
		if ( $number_decimal !== '' ) {
			for ( $i = strlen( $number_decimal ) - 1; $i >= 0; $i-- ) {
				if ( $number_decimal[ $i ] !== '0' ) {
					break;
				}
			}
			$number_decimal = substr( $number_decimal, 0, $i + 1 );
		}
	} else {
		$number_decimal = '';
	}

	return $number_decimal === '' ? $number_floor : $number_floor . $decimal_sep . $number_decimal;
}

function tfcl_send_email( $email, $email_template, $args = array() ) {
	$tfcl_background_emailer = new Email_Background_Process();

	$tfcl_background_emailer->task(
		array(
			'email_template' => $email_template,
			'email'          => $email,
			'args'           => $args
		)
	);
}

function tfcl_get_year_time( $year_past ) {
	$current_time = current_time( 'Y' );
	if ( empty( $year_past ) ) {
		return '';
	}
	if ( $year_past <= $current_time ) {
		$year_built = $current_time - $year_past;
		if ( $year_built > 1 ) {
			return sprintf( __( '%s years ago', 'tf-car-listing' ), $year_built );
		} else if ( $year_built == 0 ) {
			return __( 'Built this year', 'tf-car-listing' );
		} else {
			return sprintf( __( '%s year ago', 'tf-car-listing' ), $year_built );
		}
	} else {
		$year_built = $year_past - $current_time;
		if ( $year_built > 1 ) {
			return sprintf( __( '%s years later', 'tf-car-listing' ), $year_built );
		} else {
			return sprintf( __( '%s year later', 'tf-car-listing' ), $year_built );
		}
	}
}

function tfcl_get_comment_time( $comment_id = 0 ) {
	return sprintf(
		_x( '%s ago', 'Human-readable time', 'tf-car-listing' ),
		human_time_diff(
			get_comment_date( 'U', $comment_id ),
			current_time( 'timestamp' )
		)
	);
}

function wp_relative_date($post_date)
{
    return human_time_diff( $post_date , current_time( 'timestamp' ) ) . ' ago';
}

function tfcl_check_features_type_has_item_by_term_id( $feature_type_term_id, $features_terms_id ) {
	$has_item     = false;
	$get_features = get_terms( array(
		'hide_empty' => false,
		'meta_query' => array(
			array(
				'key'     => 'type_of_features',
				'value'   => $feature_type_term_id,
				'compare' => 'LIKE'
			)
		),
		'taxonomy'   => 'features',
	) );
	foreach ( $get_features as $key => $features ) {
		if ( in_array( $features->term_id, $features_terms_id ) ) {
			$has_item = true;
		}
	}
	return $has_item;
}

function tfcl_check_features_type_has_item_by_slug( $feature_type_slug, $features_terms_slug ) {
	$has_item     = false;
	$get_features = get_terms( array(
		'hide_empty' => false,
		'meta_query' => array(
			array(
				'key'     => 'type_of_features',
				'value'   => $feature_type_slug,
				'compare' => 'LIKE'
			)
		),
		'taxonomy'   => 'features',
	) );
	foreach ( $get_features as $key => $features ) {
		if ( in_array( $features->slug, $features_terms_slug ) ) {
			$has_item = true;
		}
	}
	return $has_item;
}

function tfcl_redirect( $redirect_url ) {
	if ( ! $redirect_url ) {
		$redirect_url = home_url( '/' );
	}

	wp_redirect( $redirect_url );
	exit();
}

function tfcl_save_image_from_url( $image_url ) {
	include_once( ABSPATH . 'wp-admin/includes/image.php' );
	$image_type = end( explode( '/', getimagesize( $image_url )['mime'] ) );
	$uniq_name  = date( 'dmY' ) . '' . (int) microtime( true );
	$filename   = $uniq_name . '.' . $image_type;

	$upload_dir  = wp_upload_dir();
	$upload_file = $upload_dir['path'] . '/' . $filename;
	$contents    = file_get_contents( $image_url );
	$save_file   = fopen( $upload_file, 'w' );
	fwrite( $save_file, $contents );
	fclose( $save_file );

	$wp_filetype = wp_check_filetype( basename( $filename ), null );
	$attachment  = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title'     => $filename,
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	$attach_id      = wp_insert_attachment( $attachment, $upload_file );
	$image_new      = get_post( $attach_id );
	$full_size_path = get_attached_file( $image_new->ID );
	$attach_data    = wp_generate_attachment_metadata( $attach_id, $full_size_path );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;
}

function tfcl_add_taxonomy_query_search( &$taxonomy_query, $taxonomy, $value ) {
	$value = sanitize_text_field( $value );
	if ( ! empty( $value ) && $value !== 'all' ) {
		$taxonomy_query[] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $value,
		);
	}
}

function tfcl_add_meta_query_price( &$metabox_query, $value, $key ) {
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

function tfcl_add_numeric_meta_query( &$metabox_query, $value, $query_key, $compare ) {
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

function tfcl_add_featured_query( &$metabox_query, $value ) {
	$featured = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
	if ( $featured ) {
		$metabox_query[] = array(
			'key'     => 'car_featured',
			'value'   => true,
			'compare' => '=',
		);
	}
}

function tfcl_get_all_car_listing() {
	$args       = array(
		'post_type'           => 'listing',
		'ignore_sticky_posts' => 1,
		'post_status'         => 'publish',
	);
	$post_count = wp_count_posts( 'listing', $args );
	$total_cars = $post_count->publish;
	return $total_cars;
}

function tfcl_pagination_ajax( $query = null, $paged = 1 ) {
	global $wp_query, $wp_rewrite;
	if ( $query )
		$main_query = $query;
	else
		$main_query = $wp_query;
	$total = isset( $main_query->max_num_pages ) ? $main_query->max_num_pages : '';
	if ( $total > 1 )
		echo '<div class="tfcl-pagination paging-navigation paging-navigation-ajax clearfix">';
	echo paginate_links( array(
		'base'      => '%_%',
		'format'    => '?paged=%#%',
		'current'   => max( 1, $paged ),
		'total'     => $total,
		'mid_size'  => '1',
		'prev_text' => wp_kses( '<i class="icon-autodeal-angle-left"></i>', 'tf-car-listing' ),
		'next_text' => wp_kses( '<i class="icon-autodeal-angle-right"></i>', 'tf-car-listing' ),
	) );
	if ( $total > 1 )
		echo '</div>';
}

function tfcl_check_value_is_selected_option( $listing_price_unit_value, $value ) {

	if ( $listing_price_unit_value == $value ) {
		echo ( 'selected' );
	}
}

function tfcl_check_value_is_checked_option( $listing_price_unit_value, $value ) {

	if ( $listing_price_unit_value == $value ) {
		echo ( 'checked' );
	}
}

function themesflat_svg( $icon ) {
    $svg = array(
        'cart' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34"><path d="M6.7,30.2c0,1.1,0.9,2.1,2.1,2.1s2.1-0.9,2.1-2.1c0-1.1-0.9-2.1-2.1-2.1S6.7,29,6.7,30.2z M25.3,30.2c0,1.1,0.9,2.1,2.1,2.1s2.1-0.9,2.1-2.1c0-1.1-0.9-2.1-2.1-2.1S25.3,29,25.3,30.2z M0.5,4.4c0,0.6,0.5,1,1,1h2.1l1.3,5.5l1.8,9c0,0.1,0,0.1,0,0.2l-1.1,4.7c-0.1,0.3,0,0.6,0.2,0.9c0.2,0.2,0.5,0.4,0.8,0.4h23.5c0.6,0,1-0.5,1-1c0-0.6-0.5-1-1-1H8l0.5-2.1c0.1,0,0.2,0.1,0.3,0.1h18.9c1.1,0,1.8-0.2,2.4-1.6l3.4-10.3c0.6-1.8-0.7-2.6-1.8-2.6H6.7c-0.2,0-0.3,0.1-0.5,0.1L5.5,4.1c-0.1-0.5-0.5-0.8-1-0.8h-3C0.9,3.3,0.5,3.8,0.5,4.4z M6.8,9.5h24.6l-3.3,10.1c0,0.1-0.1,0.2-0.1,0.2c-0.1,0-0.2,0-0.3,0H8.8v-0.2l0-0.2L6.8,9.5z"/></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34"><path d="M20.3,0.9c-7.2,0-13,5.8-13,13c0,3.1,1.1,5.9,2.9,8.2l-8.6,8.6c-0.5,0.5-0.5,1.4,0,2s1.4,0.5,2,0l8.6-8.6c2.2,1.8,5.1,2.9,8.2,2.9c7.2,0,13-5.8,13-13S27.5,0.9,20.3,0.9z M20.3,24.9c-6.1,0-11-4.9-11-11s4.9-11,11-11s11,4.9,11,11S26.4,24.9,20.3,24.9z"/></svg>',
        'menu' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M28.5,4.5h-27C0.7,4.5,0,3.8,0,3s0.7-1.5,1.5-1.5h27C29.3,1.5,30,2.2,30,3S29.3,4.5,28.5,4.5z M15,13.5H1.5C0.7,13.5,0,12.8,0,12s0.7-1.5,1.5-1.5H15c0.8,0,1.5,0.7,1.5,1.5S15.8,13.5,15,13.5z M28.5,22.5h-27C0.7,22.5,0,21.8,0,21s0.7-1.5,1.5-1.5h27c0.8,0,1.5,0.7,1.5,1.5S29.3,22.5,28.5,22.5z"/></svg>',
        'door' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.125 16.875H16.25V3.125C16.25 2.79348 16.1183 2.47554 15.8839 2.24112C15.6495 2.0067 15.3315 1.875 15 1.875H5C4.66848 1.875 4.35054 2.0067 4.11612 2.24112C3.8817 2.47554 3.75 2.79348 3.75 3.125V16.875H1.875C1.70924 16.875 1.55027 16.9408 1.43306 17.0581C1.31585 17.1753 1.25 17.3342 1.25 17.5C1.25 17.6658 1.31585 17.8247 1.43306 17.9419C1.55027 18.0592 1.70924 18.125 1.875 18.125H18.125C18.2908 18.125 18.4497 18.0592 18.5669 17.9419C18.6842 17.8247 18.75 17.6658 18.75 17.5C18.75 17.3342 18.6842 17.1753 18.5669 17.0581C18.4497 16.9408 18.2908 16.875 18.125 16.875ZM5 3.125H15V16.875H5V3.125ZM13.125 10.3125C13.125 10.4979 13.07 10.6792 12.967 10.8333C12.864 10.9875 12.7176 11.1077 12.5463 11.1786C12.375 11.2496 12.1865 11.2682 12.0046 11.232C11.8227 11.1958 11.6557 11.1065 11.5246 10.9754C11.3935 10.8443 11.3042 10.6773 11.268 10.4954C11.2318 10.3135 11.2504 10.125 11.3214 9.95373C11.3923 9.78243 11.5125 9.63601 11.6667 9.533C11.8208 9.42998 12.0021 9.375 12.1875 9.375C12.4361 9.375 12.6746 9.47377 12.8504 9.64959C13.0262 9.8254 13.125 10.0639 13.125 10.3125Z" fill="#B6B6B6"/></svg>',
        'drive' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 11.875C9.81458 11.875 9.63333 11.82 9.47916 11.717C9.32499 11.614 9.20482 11.4676 9.13387 11.2963C9.06291 11.125 9.04434 10.9365 9.08052 10.7546C9.11669 10.5727 9.20598 10.4057 9.33709 10.2746C9.4682 10.1435 9.63525 10.0542 9.81711 10.018C9.99896 9.98184 10.1875 10.0004 10.3588 10.0714C10.5301 10.1423 10.6765 10.2625 10.7795 10.4167C10.8825 10.5708 10.9375 10.7521 10.9375 10.9375C10.9375 11.1861 10.8387 11.4246 10.6629 11.6004C10.4871 11.7762 10.2486 11.875 10 11.875ZM18.125 10C18.125 11.607 17.6485 13.1779 16.7557 14.514C15.8629 15.8502 14.594 16.8916 13.1093 17.5065C11.6247 18.1215 9.99099 18.2824 8.4149 17.9689C6.8388 17.6554 5.39106 16.8815 4.25476 15.7452C3.11846 14.6089 2.34463 13.1612 2.03112 11.5851C1.71762 10.009 1.87852 8.37535 2.49348 6.8907C3.10844 5.40605 4.14985 4.1371 5.486 3.24431C6.82214 2.35152 8.39303 1.875 10 1.875C12.1542 1.87727 14.2195 2.73403 15.7427 4.25727C17.266 5.78051 18.1227 7.84581 18.125 10ZM3.125 10V10.0258C5.04463 8.39521 7.48132 7.5 10 7.5C12.5187 7.5 14.9554 8.39521 16.875 10.0258V10C16.875 8.17664 16.1507 6.42795 14.8614 5.13864C13.5721 3.84933 11.8234 3.125 10 3.125C8.17664 3.125 6.42796 3.84933 5.13864 5.13864C3.84933 6.42795 3.125 8.17664 3.125 10ZM8.39844 16.6859L7.06641 13.125H3.87735C4.33037 14.0089 4.96881 14.7846 5.74906 15.3991C6.52932 16.0137 7.43302 16.4526 8.39844 16.6859ZM10 16.875C10.0648 16.875 10.1297 16.875 10.1945 16.875L11.7625 12.6898C11.8525 12.4517 12.0128 12.2465 12.2221 12.1015C12.4314 11.9566 12.6798 11.8786 12.9344 11.8781H16.6156C16.6453 11.7758 16.6719 11.6719 16.6938 11.5656C15.8209 10.6751 14.7792 9.96761 13.6295 9.48464C12.4799 9.00167 11.2454 8.7529 9.99844 8.7529C8.75147 8.7529 7.51702 9.00167 6.36737 9.48464C5.21773 9.96761 4.17598 10.6751 3.30313 11.5656C3.32735 11.6703 3.35391 11.7742 3.38125 11.8781H7.06641C7.32108 11.8788 7.56952 11.9569 7.7788 12.102C7.98809 12.2471 8.14833 12.4524 8.23828 12.6906L9.80078 16.875C9.86797 16.875 9.9336 16.875 10 16.875ZM16.1227 13.125H12.9336L11.5984 16.6867C12.5645 16.4538 13.4689 16.0149 14.2497 15.4002C15.0306 14.7855 15.6694 14.0094 16.1227 13.125Z" fill="#B6B6B6"/></svg>',
        'engine' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.75 8.125H17.7586L15 5.36641C14.8843 5.24983 14.7467 5.1574 14.595 5.0945C14.4433 5.0316 14.2806 4.99948 14.1164 5H10.9375V3.125H12.8125C12.9783 3.125 13.1372 3.05915 13.2544 2.94194C13.3717 2.82473 13.4375 2.66576 13.4375 2.5C13.4375 2.33424 13.3717 2.17527 13.2544 2.05806C13.1372 1.94085 12.9783 1.875 12.8125 1.875H7.8125C7.64674 1.875 7.48777 1.94085 7.37056 2.05806C7.25335 2.17527 7.1875 2.33424 7.1875 2.5C7.1875 2.66576 7.25335 2.82473 7.37056 2.94194C7.48777 3.05915 7.64674 3.125 7.8125 3.125H9.6875V5H5C4.66848 5 4.35054 5.1317 4.11612 5.36612C3.8817 5.60054 3.75 5.91848 3.75 6.25V10.3125H1.875V8.4375C1.875 8.27174 1.80915 8.11277 1.69194 7.99556C1.57473 7.87835 1.41576 7.8125 1.25 7.8125C1.08424 7.8125 0.925268 7.87835 0.808058 7.99556C0.690848 8.11277 0.625 8.27174 0.625 8.4375V13.4375C0.625 13.6033 0.690848 13.7622 0.808058 13.8794C0.925268 13.9967 1.08424 14.0625 1.25 14.0625C1.41576 14.0625 1.57473 13.9967 1.69194 13.8794C1.80915 13.7622 1.875 13.6033 1.875 13.4375V11.5625H3.75V13.1789C3.74948 13.3431 3.7816 13.5058 3.8445 13.6575C3.9074 13.8092 3.99983 13.9468 4.11641 14.0625L7.1875 17.1336C7.30315 17.2502 7.44082 17.3426 7.59251 17.4055C7.7442 17.4684 7.90688 17.5005 8.07109 17.5H14.1164C14.2806 17.5005 14.4433 17.4684 14.595 17.4055C14.7467 17.3426 14.8843 17.2502 15 17.1336L17.7586 14.375H18.75C19.0815 14.375 19.3995 14.2433 19.6339 14.0089C19.8683 13.7745 20 13.4565 20 13.125V9.375C20 9.04348 19.8683 8.72554 19.6339 8.49112C19.3995 8.2567 19.0815 8.125 18.75 8.125ZM18.75 13.125H17.5C17.4179 13.1249 17.3366 13.141 17.2607 13.1724C17.1848 13.2038 17.1159 13.2498 17.0578 13.3078L14.1164 16.25H8.07109L5 13.1789V6.25H14.1164L17.0578 9.19219C17.1159 9.25021 17.1848 9.29622 17.2607 9.32759C17.3366 9.35895 17.4179 9.37506 17.5 9.375H18.75V13.125Z" fill="#B6B6B6"/></svg>',
        'fuel' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M15.0625 4.35375L13.8538 3.14625C13.7599 3.05243 13.6327 2.99972 13.5 2.99972C13.3673 2.99972 13.2401 3.05243 13.1462 3.14625C13.0524 3.24007 12.9997 3.36732 12.9997 3.5C12.9997 3.63268 13.0524 3.75993 13.1462 3.85375L14.3538 5.0625C14.447 5.15589 14.4996 5.28238 14.5 5.41437V10.5C14.5 10.6326 14.4473 10.7598 14.3536 10.8536C14.2598 10.9473 14.1326 11 14 11C13.8674 11 13.7402 10.9473 13.6464 10.8536C13.5527 10.7598 13.5 10.6326 13.5 10.5V8C13.5 7.60218 13.342 7.22064 13.0607 6.93934C12.7794 6.65804 12.3978 6.5 12 6.5H11V3.5C11 3.10218 10.842 2.72064 10.5607 2.43934C10.2794 2.15804 9.89782 2 9.5 2H4.5C4.10218 2 3.72064 2.15804 3.43934 2.43934C3.15804 2.72064 3 3.10218 3 3.5V13H2C1.86739 13 1.74021 13.0527 1.64645 13.1464C1.55268 13.2402 1.5 13.3674 1.5 13.5C1.5 13.6326 1.55268 13.7598 1.64645 13.8536C1.74021 13.9473 1.86739 14 2 14H12C12.1326 14 12.2598 13.9473 12.3536 13.8536C12.4473 13.7598 12.5 13.6326 12.5 13.5C12.5 13.3674 12.4473 13.2402 12.3536 13.1464C12.2598 13.0527 12.1326 13 12 13H11V7.5H12C12.1326 7.5 12.2598 7.55268 12.3536 7.64645C12.4473 7.74021 12.5 7.86739 12.5 8V10.5C12.5 10.8978 12.658 11.2794 12.9393 11.5607C13.2206 11.842 13.6022 12 14 12C14.3978 12 14.7794 11.842 15.0607 11.5607C15.342 11.2794 15.5 10.8978 15.5 10.5V5.41437C15.5008 5.21745 15.4625 5.02233 15.3874 4.84028C15.3123 4.65824 15.2019 4.49288 15.0625 4.35375ZM4 13V3.5C4 3.36739 4.05268 3.24021 4.14645 3.14645C4.24021 3.05268 4.36739 3 4.5 3H9.5C9.63261 3 9.75979 3.05268 9.85355 3.14645C9.94732 3.24021 10 3.36739 10 3.5V13H4ZM9 7C9 7.13261 8.94732 7.25979 8.85355 7.35355C8.75979 7.44732 8.63261 7.5 8.5 7.5H5.5C5.36739 7.5 5.24021 7.44732 5.14645 7.35355C5.05268 7.25979 5 7.13261 5 7C5 6.86739 5.05268 6.74021 5.14645 6.64645C5.24021 6.55268 5.36739 6.5 5.5 6.5H8.5C8.63261 6.5 8.75979 6.55268 8.85355 6.64645C8.94732 6.74021 9 6.86739 9 7Z" fill="#696665"/></svg>',
        'milleage' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1825_7309)"><path d="M20.3792 8.57012L19.1492 10.4201C19.7424 11.6032 20.0328 12.915 19.9944 14.2378C19.956 15.5607 19.59 16.8534 18.9292 18.0001H5.0692C4.21036 16.5102 3.85449 14.7832 4.05434 13.0752C4.25418 11.3671 4.99911 9.76895 6.17867 8.51755C7.35824 7.26615 8.90966 6.42816 10.6029 6.12782C12.2962 5.82747 14.0412 6.08076 15.5792 6.85012L17.4292 5.62012C15.5457 4.41234 13.3115 3.87113 11.0841 4.08306C8.85665 4.29499 6.76464 5.24782 5.14269 6.78913C3.52074 8.33045 2.46256 10.3712 2.13741 12.5849C1.81227 14.7987 2.23895 17.0575 3.3492 19.0001C3.52371 19.3024 3.77428 19.5537 4.07603 19.7292C4.37777 19.9046 4.72017 19.998 5.0692 20.0001H18.9192C19.2716 20.0015 19.6181 19.9098 19.9237 19.7342C20.2293 19.5586 20.483 19.3053 20.6592 19.0001C21.5806 17.404 22.043 15.5844 21.9953 13.7421C21.9477 11.8998 21.3918 10.1064 20.3892 8.56012L20.3792 8.57012ZM10.5892 15.4101C10.7749 15.5961 10.9955 15.7436 11.2383 15.8442C11.4811 15.9449 11.7414 15.9967 12.0042 15.9967C12.267 15.9967 12.5273 15.9449 12.7701 15.8442C13.0129 15.7436 13.2334 15.5961 13.4192 15.4101L19.0792 6.92012L10.5892 12.5801C10.4032 12.7659 10.2557 12.9864 10.1551 13.2292C10.0544 13.472 10.0026 13.7323 10.0026 13.9951C10.0026 14.258 10.0544 14.5182 10.1551 14.761C10.2557 15.0038 10.4032 15.2244 10.5892 15.4101Z" fill="#0B0E28"/></g><defs><clipPath id="clip0_1825_7309"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>',
        'performance' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.4312 15.5469C18.3594 15.5873 18.2804 15.6132 18.1986 15.623C18.1168 15.6328 18.0339 15.6263 17.9546 15.604C17.8753 15.5816 17.8012 15.5438 17.7366 15.4927C17.672 15.4416 17.6181 15.3782 17.5781 15.3062L12.1343 5.625H10.625V6.25C10.625 6.41576 10.5591 6.57473 10.4419 6.69194C10.3247 6.80915 10.1657 6.875 9.99996 6.875C9.8342 6.875 9.67523 6.80915 9.55801 6.69194C9.4408 6.57473 9.37496 6.41576 9.37496 6.25V5.625H7.86558L2.42183 15.3062C2.34061 15.4513 2.2051 15.5581 2.0451 15.6033C1.88511 15.6484 1.71375 15.6281 1.56871 15.5469C1.42367 15.4657 1.31683 15.3301 1.27171 15.1701C1.22658 15.0102 1.24686 14.8388 1.32808 14.6938L6.43121 5.625H1.87496C1.7092 5.625 1.55023 5.55915 1.43302 5.44194C1.3158 5.32473 1.24996 5.16576 1.24996 5C1.24996 4.83424 1.3158 4.67527 1.43302 4.55806C1.55023 4.44085 1.7092 4.375 1.87496 4.375H18.125C18.2907 4.375 18.4497 4.44085 18.5669 4.55806C18.6841 4.67527 18.75 4.83424 18.75 5C18.75 5.16576 18.6841 5.32473 18.5669 5.44194C18.4497 5.55915 18.2907 5.625 18.125 5.625H13.5687L18.6718 14.6938C18.7123 14.7655 18.7382 14.8446 18.748 14.9263C18.7578 15.0081 18.7513 15.0911 18.7289 15.1703C18.7066 15.2496 18.6687 15.3237 18.6177 15.3883C18.5666 15.453 18.5032 15.5068 18.4312 15.5469ZM9.99996 8.75C9.8342 8.75 9.67523 8.81585 9.55801 8.93306C9.4408 9.05027 9.37496 9.20924 9.37496 9.375V10.625C9.37496 10.7908 9.4408 10.9497 9.55801 11.0669C9.67523 11.1842 9.8342 11.25 9.99996 11.25C10.1657 11.25 10.3247 11.1842 10.4419 11.0669C10.5591 10.9497 10.625 10.7908 10.625 10.625V9.375C10.625 9.20924 10.5591 9.05027 10.4419 8.93306C10.3247 8.81585 10.1657 8.75 9.99996 8.75ZM9.99996 13.125C9.8342 13.125 9.67523 13.1908 9.55801 13.3081C9.4408 13.4253 9.37496 13.5842 9.37496 13.75V15C9.37496 15.1658 9.4408 15.3247 9.55801 15.4419C9.67523 15.5592 9.8342 15.625 9.99996 15.625C10.1657 15.625 10.3247 15.5592 10.4419 15.4419C10.5591 15.3247 10.625 15.1658 10.625 15V13.75C10.625 13.5842 10.5591 13.4253 10.4419 13.3081C10.3247 13.1908 10.1657 13.125 9.99996 13.125Z" fill="#B6B6B6"/></svg>',
        'seat' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M17.5 18.1252C17.5 18.2909 17.4341 18.4499 17.3169 18.5671C17.1997 18.6843 17.0407 18.7502 16.875 18.7502H8.74998C8.58422 18.7502 8.42525 18.6843 8.30804 18.5671C8.19083 18.4499 8.12498 18.2909 8.12498 18.1252C8.12498 17.9594 8.19083 17.8004 8.30804 17.6832C8.42525 17.566 8.58422 17.5002 8.74998 17.5002H16.875C17.0407 17.5002 17.1997 17.566 17.3169 17.6832C17.4341 17.8004 17.5 17.9594 17.5 18.1252ZM17.5 12.5002V15.0002C17.5 15.3317 17.3683 15.6496 17.1339 15.884C16.8994 16.1185 16.5815 16.2502 16.25 16.2502H8.91482C8.68238 16.2509 8.45439 16.1865 8.25666 16.0643C8.05893 15.9421 7.89938 15.767 7.79607 15.5588L3.25623 6.49626C3.16991 6.32242 3.125 6.13097 3.125 5.93688C3.125 5.7428 3.16991 5.55134 3.25623 5.37751L4.98435 1.94001C5.13103 1.64729 5.38671 1.4238 5.69642 1.31759C6.00613 1.21139 6.34515 1.23093 6.6406 1.37204L9.27263 2.48298L9.30935 2.50016C9.60567 2.6485 9.83097 2.90843 9.93571 3.22281C10.0405 3.5372 10.0161 3.88031 9.86795 4.17673C9.86555 4.18268 9.86268 4.18843 9.85935 4.19391L8.74998 6.25016L11.2328 11.2502H16.25C16.5815 11.2502 16.8994 11.3819 17.1339 11.6163C17.3683 11.8507 17.5 12.1686 17.5 12.5002ZM16.25 12.5002H11.232C10.9997 12.5009 10.7718 12.4365 10.5741 12.3143C10.3765 12.1921 10.2171 12.017 10.114 11.8088L7.63045 6.80876C7.54434 6.63528 7.49953 6.44423 7.49953 6.25055C7.49953 6.05688 7.54434 5.86583 7.63045 5.69235L7.63982 5.67516L8.74998 3.61891L6.13826 2.51657C6.12574 2.51176 6.11348 2.50628 6.10154 2.50016L4.37498 5.93766L8.91404 15.0002H16.25V12.5002Z" fill="#B6B6B6"/></svg>',
        'sedan' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.75 8.125H17.9062L15.7359 3.24219C15.6377 3.02127 15.4775 2.83358 15.2748 2.70185C15.0721 2.57012 14.8355 2.5 14.5938 2.5H5.40625C5.16448 2.5 4.92791 2.57012 4.72518 2.70185C4.52245 2.83358 4.36228 3.02127 4.26406 3.24219L2.09375 8.125H1.25C1.08424 8.125 0.925268 8.19085 0.808058 8.30806C0.690848 8.42527 0.625 8.58424 0.625 8.75C0.625 8.91576 0.690848 9.07473 0.808058 9.19194C0.925268 9.30915 1.08424 9.375 1.25 9.375H1.875V15.625C1.875 15.9565 2.0067 16.2745 2.24112 16.5089C2.47554 16.7433 2.79348 16.875 3.125 16.875H5C5.33152 16.875 5.64946 16.7433 5.88388 16.5089C6.1183 16.2745 6.25 15.9565 6.25 15.625V14.375H13.75V15.625C13.75 15.9565 13.8817 16.2745 14.1161 16.5089C14.3505 16.7433 14.6685 16.875 15 16.875H16.875C17.2065 16.875 17.5245 16.7433 17.7589 16.5089C17.9933 16.2745 18.125 15.9565 18.125 15.625V9.375H18.75C18.9158 9.375 19.0747 9.30915 19.1919 9.19194C19.3092 9.07473 19.375 8.91576 19.375 8.75C19.375 8.58424 19.3092 8.42527 19.1919 8.30806C19.0747 8.19085 18.9158 8.125 18.75 8.125ZM5.40625 3.75H14.5938L16.5383 8.125H3.46172L5.40625 3.75ZM5 15.625H3.125V14.375H5V15.625ZM15 15.625V14.375H16.875V15.625H15ZM16.875 13.125H3.125V9.375H16.875V13.125ZM4.375 11.25C4.375 11.0842 4.44085 10.9253 4.55806 10.8081C4.67527 10.6908 4.83424 10.625 5 10.625H6.25C6.41576 10.625 6.57473 10.6908 6.69194 10.8081C6.80915 10.9253 6.875 11.0842 6.875 11.25C6.875 11.4158 6.80915 11.5747 6.69194 11.6919C6.57473 11.8092 6.41576 11.875 6.25 11.875H5C4.83424 11.875 4.67527 11.8092 4.55806 11.6919C4.44085 11.5747 4.375 11.4158 4.375 11.25ZM13.125 11.25C13.125 11.0842 13.1908 10.9253 13.3081 10.8081C13.4253 10.6908 13.5842 10.625 13.75 10.625H15C15.1658 10.625 15.3247 10.6908 15.4419 10.8081C15.5592 10.9253 15.625 11.0842 15.625 11.25C15.625 11.4158 15.5592 11.5747 15.4419 11.6919C15.3247 11.8092 15.1658 11.875 15 11.875H13.75C13.5842 11.875 13.4253 11.8092 13.3081 11.6919C13.1908 11.5747 13.125 11.4158 13.125 11.25Z" fill="#B6B6B6"/></svg>',
        'speed' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1825_7309)"><path d="M20.3792 8.57012L19.1492 10.4201C19.7424 11.6032 20.0328 12.915 19.9944 14.2378C19.956 15.5607 19.59 16.8534 18.9292 18.0001H5.0692C4.21036 16.5102 3.85449 14.7832 4.05434 13.0752C4.25418 11.3671 4.99911 9.76895 6.17867 8.51755C7.35824 7.26615 8.90966 6.42816 10.6029 6.12782C12.2962 5.82747 14.0412 6.08076 15.5792 6.85012L17.4292 5.62012C15.5457 4.41234 13.3115 3.87113 11.0841 4.08306C8.85665 4.29499 6.76464 5.24782 5.14269 6.78913C3.52074 8.33045 2.46256 10.3712 2.13741 12.5849C1.81227 14.7987 2.23895 17.0575 3.3492 19.0001C3.52371 19.3024 3.77428 19.5537 4.07603 19.7292C4.37777 19.9046 4.72017 19.998 5.0692 20.0001H18.9192C19.2716 20.0015 19.6181 19.9098 19.9237 19.7342C20.2293 19.5586 20.483 19.3053 20.6592 19.0001C21.5806 17.404 22.043 15.5844 21.9953 13.7421C21.9477 11.8998 21.3918 10.1064 20.3892 8.56012L20.3792 8.57012ZM10.5892 15.4101C10.7749 15.5961 10.9955 15.7436 11.2383 15.8442C11.4811 15.9449 11.7414 15.9967 12.0042 15.9967C12.267 15.9967 12.5273 15.9449 12.7701 15.8442C13.0129 15.7436 13.2334 15.5961 13.4192 15.4101L19.0792 6.92012L10.5892 12.5801C10.4032 12.7659 10.2557 12.9864 10.1551 13.2292C10.0544 13.472 10.0026 13.7323 10.0026 13.9951C10.0026 14.258 10.0544 14.5182 10.1551 14.761C10.2557 15.0038 10.4032 15.2244 10.5892 15.4101Z" fill="#0B0E28"/></g><defs><clipPath id="clip0_1825_7309"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>',
        'transmission' => '<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.7992 2.99031C18.7992 1.78131 17.8382 0.820312 16.6292 0.820312C15.4202 0.820312 14.4592 1.78131 14.4592 2.99031C14.4592 3.98231 15.1102 4.78831 16.0092 5.06731V8.88031H10.1192V5.06731C11.0182 4.78831 11.6692 3.98231 11.6692 2.99031C11.6692 1.78131 10.7082 0.820312 9.49922 0.820312C8.29022 0.820312 7.32922 1.78131 7.32922 2.99031C7.32922 3.98231 7.98022 4.78831 8.87922 5.06731V8.88031H2.98922V5.06731C3.88822 4.78831 4.53922 3.98231 4.53922 2.99031C4.53922 1.78131 3.57822 0.820312 2.36922 0.820312C1.16022 0.820312 0.199219 1.78131 0.199219 2.99031C0.199219 3.98231 0.850219 4.78831 1.74922 5.06731V13.9333C0.850219 14.2123 0.199219 15.0183 0.199219 16.0103C0.199219 17.2193 1.16022 18.1803 2.36922 18.1803C3.57822 18.1803 4.53922 17.2193 4.53922 16.0103C4.53922 15.0183 3.88822 14.2123 2.98922 13.9333V10.1203H8.87922V13.9333C7.98022 14.2123 7.32922 15.0183 7.32922 16.0103C7.32922 17.2193 8.29022 18.1803 9.49922 18.1803C10.7082 18.1803 11.6692 17.2193 11.6692 16.0103C11.6692 15.0183 11.0182 14.2123 10.1192 13.9333V10.1203H16.6292C16.9702 10.1203 17.2492 9.84131 17.2492 9.50031V5.06731C18.1482 4.81931 18.7992 3.98231 18.7992 2.99031ZM8.56922 2.99031C8.56922 2.49431 8.97222 2.06031 9.49922 2.06031C9.99522 2.06031 10.4292 2.46331 10.4292 2.99031C10.4292 3.48631 10.0262 3.92031 9.49922 3.92031C9.00322 3.92031 8.56922 3.51731 8.56922 2.99031ZM1.43922 2.99031C1.43922 2.49431 1.84222 2.06031 2.36922 2.06031C2.86522 2.06031 3.29922 2.46331 3.29922 2.99031C3.29922 3.48631 2.89622 3.92031 2.36922 3.92031C1.84222 3.92031 1.43922 3.51731 1.43922 2.99031ZM3.29922 16.0103C3.29922 16.5063 2.89622 16.9403 2.36922 16.9403C1.87322 16.9403 1.43922 16.5373 1.43922 16.0103C1.43922 15.4833 1.84222 15.0803 2.36922 15.0803C2.86522 15.0803 3.29922 15.4833 3.29922 16.0103ZM10.4292 16.0103C10.4292 16.5063 10.0262 16.9403 9.49922 16.9403C9.00322 16.9403 8.56922 16.5373 8.56922 16.0103C8.56922 15.4833 8.97222 15.0803 9.49922 15.0803C9.99522 15.0803 10.4292 15.4833 10.4292 16.0103ZM16.6292 3.92031C16.1332 3.92031 15.6992 3.51731 15.6992 2.99031C15.6992 2.49431 16.1022 2.06031 16.6292 2.06031C17.1562 2.06031 17.5592 2.46331 17.5592 2.99031C17.5592 3.51731 17.1562 3.92031 16.6292 3.92031Z" fill="#1E1919"/></svg>',
        'car' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.75 8.125H17.9062L15.7359 3.24219C15.6377 3.02127 15.4775 2.83358 15.2748 2.70185C15.0721 2.57012 14.8355 2.5 14.5938 2.5H5.40625C5.16448 2.5 4.92791 2.57012 4.72518 2.70185C4.52245 2.83358 4.36228 3.02127 4.26406 3.24219L2.09375 8.125H1.25C1.08424 8.125 0.925268 8.19085 0.808058 8.30806C0.690848 8.42527 0.625 8.58424 0.625 8.75C0.625 8.91576 0.690848 9.07473 0.808058 9.19194C0.925268 9.30915 1.08424 9.375 1.25 9.375H1.875V15.625C1.875 15.9565 2.0067 16.2745 2.24112 16.5089C2.47554 16.7433 2.79348 16.875 3.125 16.875H5C5.33152 16.875 5.64946 16.7433 5.88388 16.5089C6.1183 16.2745 6.25 15.9565 6.25 15.625V14.375H13.75V15.625C13.75 15.9565 13.8817 16.2745 14.1161 16.5089C14.3505 16.7433 14.6685 16.875 15 16.875H16.875C17.2065 16.875 17.5245 16.7433 17.7589 16.5089C17.9933 16.2745 18.125 15.9565 18.125 15.625V9.375H18.75C18.9158 9.375 19.0747 9.30915 19.1919 9.19194C19.3092 9.07473 19.375 8.91576 19.375 8.75C19.375 8.58424 19.3092 8.42527 19.1919 8.30806C19.0747 8.19085 18.9158 8.125 18.75 8.125ZM5.40625 3.75H14.5938L16.5383 8.125H3.46172L5.40625 3.75ZM5 15.625H3.125V14.375H5V15.625ZM15 15.625V14.375H16.875V15.625H15ZM16.875 13.125H3.125V9.375H16.875V13.125ZM4.375 11.25C4.375 11.0842 4.44085 10.9253 4.55806 10.8081C4.67527 10.6908 4.83424 10.625 5 10.625H6.25C6.41576 10.625 6.57473 10.6908 6.69194 10.8081C6.80915 10.9253 6.875 11.0842 6.875 11.25C6.875 11.4158 6.80915 11.5747 6.69194 11.6919C6.57473 11.8092 6.41576 11.875 6.25 11.875H5C4.83424 11.875 4.67527 11.8092 4.55806 11.6919C4.44085 11.5747 4.375 11.4158 4.375 11.25ZM13.125 11.25C13.125 11.0842 13.1908 10.9253 13.3081 10.8081C13.4253 10.6908 13.5842 10.625 13.75 10.625H15C15.1658 10.625 15.3247 10.6908 15.4419 10.8081C15.5592 10.9253 15.625 11.0842 15.625 11.25C15.625 11.4158 15.5592 11.5747 15.4419 11.6919C15.3247 11.8092 15.1658 11.875 15 11.875H13.75C13.5842 11.875 13.4253 11.8092 13.3081 11.6919C13.1908 11.5747 13.125 11.4158 13.125 11.25Z" fill="#B6B6B6"/></svg>',
        'checklist' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.75 14.9998H18.125V7.70836C18.125 7.50265 18.0742 7.30011 17.9772 7.11872C17.8802 6.93733 17.7399 6.78269 17.5688 6.66852L10.6938 2.08493C10.4884 1.94804 10.2472 1.875 10.0004 1.875C9.75362 1.875 9.51236 1.94804 9.30703 2.08493L2.43203 6.66852C2.26076 6.7826 2.12031 6.9372 2.02314 7.1186C1.92597 7.3 1.87508 7.50258 1.875 7.70836V14.9998H1.25C1.08424 14.9998 0.925268 15.0656 0.808058 15.1828C0.690848 15.3 0.625 15.459 0.625 15.6248C0.625 15.7905 0.690848 15.9495 0.808058 16.0667C0.925268 16.1839 1.08424 16.2498 1.25 16.2498H18.75C18.9158 16.2498 19.0747 16.1839 19.1919 16.0667C19.3092 15.9495 19.375 15.7905 19.375 15.6248C19.375 15.459 19.3092 15.3 19.1919 15.1828C19.0747 15.0656 18.9158 14.9998 18.75 14.9998ZM3.125 7.70836L10 3.12477L16.875 7.70758V14.9998H15V10.6248C15 10.459 14.9342 10.3 14.8169 10.1828C14.6997 10.0656 14.5408 9.99977 14.375 9.99977H5.625C5.45924 9.99977 5.30027 10.0656 5.18306 10.1828C5.06585 10.3 5 10.459 5 10.6248V14.9998H3.125V7.70836ZM13.75 11.2498V12.4998H10.625V11.2498H13.75ZM9.375 12.4998H6.25V11.2498H9.375V12.4998ZM6.25 13.7498H9.375V14.9998H6.25V13.7498ZM10.625 13.7498H13.75V14.9998H10.625V13.7498Z" fill="#B6B6B6"/></svg>',
        'color' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.3227 10.8649C18.4237 10.8312 18.5144 10.7723 18.5862 10.6937C18.6581 10.6151 18.7086 10.5195 18.7331 10.4159C18.7576 10.3123 18.7552 10.2041 18.7262 10.1017C18.6972 9.99925 18.6425 9.90593 18.5672 9.83057L9.54459 0.807913C9.42739 0.690792 9.26848 0.625 9.10279 0.625C8.9371 0.625 8.77819 0.690792 8.661 0.807913L5.48834 3.98448L3.56646 2.05791C3.44919 1.94074 3.29017 1.87496 3.12439 1.87503C2.95861 1.8751 2.79965 1.94103 2.68248 2.0583C2.56531 2.17558 2.49952 2.3346 2.4996 2.50038C2.49967 2.66616 2.5656 2.82512 2.68287 2.94229L4.60475 4.86416L1.17193 8.29463C0.82033 8.64626 0.622803 9.12315 0.622803 9.62041C0.622803 10.1177 0.82033 10.5946 1.17193 10.9462L7.80396 17.5782C8.15559 17.9298 8.63249 18.1274 9.12975 18.1274C9.627 18.1274 10.1039 17.9298 10.4555 17.5782L16.5876 11.4462L18.3227 10.8649ZM15.8079 10.4556L9.57115 16.6923C9.45395 16.8094 9.29504 16.8752 9.12936 16.8752C8.96367 16.8752 8.80476 16.8094 8.68756 16.6923L2.05787 10.0626C1.94075 9.9454 1.87496 9.78649 1.87496 9.6208C1.87496 9.45511 1.94075 9.29621 2.05787 9.17901L5.48834 5.74776L7.76334 8.02276C7.51366 8.48508 7.43874 9.02183 7.55226 9.53486C7.66579 10.0479 7.96019 10.5029 8.38162 10.8167C8.80305 11.1305 9.32335 11.2822 9.8474 11.2439C10.3714 11.2056 10.8642 10.98 11.2356 10.6083C11.6069 10.2366 11.8321 9.74367 11.8699 9.21959C11.9077 8.69552 11.7556 8.17534 11.4414 7.75419C11.1273 7.33304 10.672 7.03904 10.1588 6.92597C9.64572 6.8129 9.10904 6.8883 8.64693 7.13838L6.37271 4.86416L9.10709 2.13369L16.968 10.0001L16.0524 10.3048C15.9604 10.3356 15.8767 10.3872 15.8079 10.4556ZM9.02428 8.4001C9.20062 8.18975 9.45323 8.05799 9.72664 8.03374C10 8.0095 10.2719 8.09475 10.4825 8.27078C10.6931 8.44681 10.8253 8.69923 10.8499 8.9726C10.8745 9.24598 10.7897 9.51796 10.614 9.72882C10.4383 9.93969 10.186 10.0722 9.9127 10.0972C9.63936 10.1223 9.36725 10.0378 9.15613 9.86244C8.94501 9.68703 8.81213 9.435 8.78668 9.1617C8.76122 8.8884 8.84527 8.61617 9.02037 8.40479C9.02037 8.40479 9.02428 8.40088 9.02428 8.4001ZM18.6454 12.7751C18.5883 12.6894 18.511 12.6191 18.4202 12.5704C18.3294 12.5218 18.228 12.4964 18.1251 12.4964C18.0221 12.4964 17.9207 12.5218 17.8299 12.5704C17.7391 12.6191 17.6618 12.6894 17.6047 12.7751C17.4665 12.9868 16.2501 14.8509 16.2501 16.2501C16.2501 16.7474 16.4476 17.2243 16.7992 17.5759C17.1509 17.9276 17.6278 18.1251 18.1251 18.1251C18.6223 18.1251 19.0993 17.9276 19.4509 17.5759C19.8025 17.2243 20.0001 16.7474 20.0001 16.2501C20.0001 14.8509 18.7837 12.9868 18.6454 12.7782V12.7751ZM18.1251 16.8751C17.9593 16.8751 17.8003 16.8093 17.6831 16.692C17.5659 16.5748 17.5001 16.4159 17.5001 16.2501C17.5001 15.7189 17.8126 14.9751 18.1251 14.3689C18.4376 14.9751 18.7501 15.7235 18.7501 16.2501C18.7501 16.4159 18.6842 16.5748 18.567 16.692C18.4498 16.8093 18.2908 16.8751 18.1251 16.8751Z" fill="#B6B6B6"/></svg>',
        'cylinder' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M15.625 5V3.125C15.625 2.79348 15.4933 2.47554 15.2589 2.24112C15.0245 2.0067 14.7065 1.875 14.375 1.875H5.625C5.29348 1.875 4.97554 2.0067 4.74112 2.24112C4.5067 2.47554 4.375 2.79348 4.375 3.125V5C4.375 5.33152 4.5067 5.64946 4.74112 5.88388C4.97554 6.1183 5.29348 6.25 5.625 6.25H6.14375L4.38281 17.4023C4.35695 17.566 4.39715 17.7333 4.49457 17.8673C4.592 18.0014 4.73867 18.0913 4.90234 18.1172C4.93463 18.1224 4.96729 18.125 5 18.125C5.14868 18.1248 5.29241 18.0716 5.40538 17.9749C5.51836 17.8783 5.59318 17.7445 5.61641 17.5977L6.225 13.75H13.775L14.3828 17.5977C14.4061 17.7446 14.481 17.8785 14.5941 17.9752C14.7073 18.0718 14.8512 18.125 15 18.125C15.033 18.1251 15.0659 18.1224 15.0984 18.1172C15.2621 18.0913 15.4088 18.0014 15.5062 17.8673C15.6036 17.7333 15.6438 17.566 15.618 17.4023L13.8562 6.25H14.375C14.7065 6.25 15.0245 6.1183 15.2589 5.88388C15.4933 5.64946 15.625 5.33152 15.625 5ZM5.625 3.125H14.375V5H5.625V3.125ZM13.5773 12.5H6.42266L7.40937 6.25H12.5906L13.5773 12.5Z" fill="#B6B6B6"/></svg>',
        'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M7.14604 9.6463L13.146 3.6463C13.1925 3.59985 13.2476 3.563 13.3083 3.53786C13.369 3.51272 13.4341 3.49978 13.4998 3.49978C13.5655 3.49978 13.6305 3.51272 13.6912 3.53786C13.7519 3.563 13.8071 3.59985 13.8535 3.6463C13.9 3.69276 13.9368 3.74791 13.962 3.8086C13.9871 3.8693 14.0001 3.93436 14.0001 4.00005C14.0001 4.06575 13.9871 4.1308 13.962 4.1915C13.9368 4.2522 13.9 4.30735 13.8535 4.3538L7.85354 10.3538C7.80709 10.4003 7.75194 10.4371 7.69124 10.4622C7.63054 10.4874 7.56549 10.5003 7.49979 10.5003C7.43409 10.5003 7.36904 10.4874 7.30834 10.4622C7.24765 10.4371 7.1925 10.4003 7.14604 10.3538C7.09959 10.3073 7.06274 10.2522 7.03759 10.1915C7.01245 10.1308 6.99951 10.0658 6.99951 10.0001C6.99951 9.93436 7.01245 9.8693 7.03759 9.8086C7.06274 9.74791 7.09959 9.69276 7.14604 9.6463ZM7.99979 5.50005C8.43411 5.4995 8.86561 5.5698 9.27729 5.70818C9.3398 5.73034 9.40609 5.73984 9.4723 5.73614C9.53851 5.73243 9.60333 5.7156 9.66297 5.6866C9.72262 5.65761 9.7759 5.61704 9.81971 5.56725C9.86352 5.51747 9.89699 5.45947 9.91818 5.39663C9.93936 5.33378 9.94783 5.26735 9.94309 5.20121C9.93836 5.13506 9.92051 5.07051 9.89059 5.01133C9.86067 4.95215 9.81927 4.89951 9.76881 4.85647C9.71835 4.81344 9.65983 4.78088 9.59667 4.76068C8.79987 4.49206 7.94819 4.42872 7.12043 4.57654C6.29266 4.72435 5.51554 5.07853 4.86096 5.60632C4.20637 6.13412 3.69547 6.81847 3.3755 7.59607C3.05554 8.37368 2.93685 9.21942 3.03042 10.0551C3.04394 10.1773 3.10203 10.2902 3.19357 10.3723C3.28512 10.4544 3.4037 10.4999 3.52667 10.5001C3.54479 10.5001 3.56354 10.5001 3.58229 10.4969C3.71406 10.4823 3.83463 10.416 3.9175 10.3125C4.00036 10.209 4.03873 10.0768 4.02417 9.94505C4.00789 9.79728 3.99976 9.64872 3.99979 9.50005C4.00095 8.43954 4.42275 7.4228 5.17264 6.6729C5.92254 5.92301 6.93928 5.50121 7.99979 5.50005ZM14.2335 6.31255C14.2036 6.25411 14.1624 6.20215 14.1124 6.15962C14.0623 6.1171 14.0044 6.08485 13.9419 6.06471C13.8794 6.04457 13.8135 6.03694 13.7481 6.04225C13.6826 6.04757 13.6189 6.06572 13.5604 6.09568C13.502 6.12564 13.45 6.16681 13.4075 6.21685C13.365 6.26689 13.3327 6.32482 13.3126 6.38732C13.2924 6.44983 13.2848 6.51569 13.2901 6.58114C13.2954 6.6466 13.3136 6.71036 13.3435 6.7688C13.7135 7.49523 13.9319 8.28924 13.9856 9.10265C14.0393 9.91607 13.9272 10.7319 13.656 11.5007L2.33729 11.4963C2.02149 10.5911 1.92666 9.62346 2.06069 8.67414C2.19472 7.72482 2.55373 6.82129 3.1078 6.03887C3.66186 5.25645 4.39493 4.61781 5.2459 4.17618C6.09686 3.73455 7.04106 3.50274 7.99979 3.50005H8.05479C8.98599 3.50591 9.90276 3.73071 10.731 4.1563C10.7896 4.18855 10.8541 4.20872 10.9206 4.2156C10.9872 4.22249 11.0544 4.21596 11.1184 4.19639C11.1823 4.17683 11.2417 4.14463 11.293 4.1017C11.3443 4.05878 11.3865 4.006 11.417 3.94648C11.4475 3.88697 11.4658 3.82194 11.4708 3.75523C11.4757 3.68853 11.4672 3.62151 11.4458 3.55815C11.4244 3.49479 11.3905 3.43636 11.3461 3.38634C11.3017 3.33632 11.2477 3.29571 11.1873 3.26693C9.94039 2.62826 8.53054 2.37842 7.1401 2.54973C5.74966 2.72105 4.44262 3.30563 3.38804 4.22787C2.33346 5.15011 1.57986 6.36756 1.22473 7.72275C0.869602 9.07795 0.929279 10.5085 1.39604 11.8294C1.46499 12.0251 1.59286 12.1947 1.76208 12.3148C1.93129 12.4348 2.13355 12.4996 2.34104 12.5001H13.6579C13.8653 12.5002 14.0676 12.4358 14.2368 12.3159C14.406 12.196 14.5337 12.0264 14.6023 11.8307C14.9176 10.9337 15.0476 9.98211 14.9842 9.03347C14.9208 8.08482 14.6654 7.15893 14.2335 6.31193V6.31255Z" fill="#696665"/></svg>',
        'transmission2' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M14.5 3.99997C14.4998 3.62594 14.3947 3.25947 14.1967 2.94216C13.9987 2.62485 13.7157 2.36942 13.3798 2.20489C13.0439 2.04035 12.6686 1.9733 12.2965 2.01135C11.9245 2.0494 11.5705 2.19103 11.2749 2.42015C10.9792 2.64926 10.7538 2.95669 10.6241 3.30751C10.4944 3.65833 10.4657 4.03849 10.5412 4.40481C10.6167 4.77113 10.7935 5.10894 11.0513 5.37986C11.3092 5.65078 11.6379 5.84396 12 5.93747V6.99997C12 7.13258 11.9473 7.25975 11.8536 7.35352C11.7598 7.44729 11.6326 7.49997 11.5 7.49997H6C5.82963 7.49992 5.66051 7.52909 5.5 7.58622V5.93747C5.97133 5.81577 6.3821 5.52635 6.65531 5.12347C6.92851 4.72058 7.0454 4.23188 6.98406 3.74897C6.92273 3.26606 6.68737 2.8221 6.32212 2.50031C5.95687 2.17851 5.48679 2.00098 5 2.00098C4.51322 2.00098 4.04314 2.17851 3.67789 2.50031C3.31264 2.8221 3.07728 3.26606 3.01595 3.74897C2.95461 4.23188 3.0715 4.72058 3.3447 5.12347C3.61791 5.52635 4.02868 5.81577 4.5 5.93747V10.0625C4.02868 10.1842 3.61791 10.4736 3.3447 10.8765C3.0715 11.2794 2.95461 11.7681 3.01595 12.251C3.07728 12.7339 3.31264 13.1778 3.67789 13.4996C4.04314 13.8214 4.51322 13.999 5 13.999C5.48679 13.999 5.95687 13.8214 6.32212 13.4996C6.68737 13.1778 6.92273 12.7339 6.98406 12.251C7.0454 11.7681 6.92851 11.2794 6.65531 10.8765C6.3821 10.4736 5.97133 10.1842 5.5 10.0625V8.99997C5.5 8.86736 5.55268 8.74018 5.64645 8.64642C5.74022 8.55265 5.8674 8.49997 6 8.49997H11.5C11.8978 8.49997 12.2794 8.34193 12.5607 8.06063C12.842 7.77933 13 7.39779 13 6.99997V5.93747C13.4292 5.826 13.8092 5.57532 14.0807 5.22472C14.3521 4.87411 14.4996 4.44337 14.5 3.99997ZM4 3.99997C4 3.80219 4.05865 3.60885 4.16854 3.4444C4.27842 3.27995 4.4346 3.15178 4.61732 3.07609C4.80005 3.0004 5.00111 2.9806 5.1951 3.01918C5.38908 3.05777 5.56726 3.15301 5.70711 3.29286C5.84696 3.43271 5.9422 3.6109 5.98079 3.80488C6.01938 3.99886 5.99957 4.19993 5.92388 4.38265C5.8482 4.56538 5.72002 4.72156 5.55557 4.83144C5.39113 4.94132 5.19779 4.99997 5 4.99997C4.73479 4.99997 4.48043 4.89461 4.2929 4.70708C4.10536 4.51954 4 4.26519 4 3.99997ZM6 12C6 12.1978 5.94136 12.3911 5.83147 12.5555C5.72159 12.72 5.56541 12.8482 5.38269 12.9238C5.19996 12.9995 4.9989 13.0193 4.80491 12.9808C4.61093 12.9422 4.43275 12.8469 4.2929 12.7071C4.15305 12.5672 4.0578 12.389 4.01922 12.1951C3.98063 12.0011 4.00044 11.8 4.07613 11.6173C4.15181 11.4346 4.27999 11.2784 4.44443 11.1685C4.60888 11.0586 4.80222 11 5 11C5.26522 11 5.51957 11.1053 5.70711 11.2929C5.89465 11.4804 6 11.7348 6 12ZM12.5 4.99997C12.3022 4.99997 12.1089 4.94132 11.9444 4.83144C11.78 4.72156 11.6518 4.56538 11.5761 4.38265C11.5004 4.19993 11.4806 3.99886 11.5192 3.80488C11.5578 3.6109 11.653 3.43271 11.7929 3.29286C11.9328 3.15301 12.1109 3.05777 12.3049 3.01918C12.4989 2.9806 12.7 3.0004 12.8827 3.07609C13.0654 3.15178 13.2216 3.27995 13.3315 3.4444C13.4414 3.60885 13.5 3.80219 13.5 3.99997C13.5 4.26519 13.3946 4.51954 13.2071 4.70708C13.0196 4.89461 12.7652 4.99997 12.5 4.99997Z" fill="#696665"/></svg>',
        'car3' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none"><path d="M25.406 12.1967C25.051 11.5568 24.5392 11.0175 23.9187 10.6294L22.5255 9.75818H24.7453C25.229 9.75818 25.6226 9.36467 25.6226 8.88091V8.06775C25.6226 7.80817 25.4111 7.59675 25.1512 7.59675H24.2332C23.2864 7.59675 22.4907 8.25748 22.2838 9.14208L20.9763 6.54314C20.5914 5.77812 20.0028 5.1362 19.2738 4.68689C18.5448 4.23757 17.7071 4 16.8506 4H9.15131C8.29478 4 7.45674 4.23757 6.72776 4.68689C5.99878 5.1362 5.41011 5.77812 5.02521 6.54314L3.70883 9.16026C3.48816 8.29448 2.7021 7.65255 1.76872 7.65255H0.850634C0.59074 7.65255 0.379316 7.86398 0.379316 8.12387V8.93672C0.379316 9.42047 0.772825 9.81398 1.25658 9.81398H3.38676L2.08282 10.6291C1.46354 11.0162 0.94949 11.5583 0.595523 12.1967C0.241269 12.8372 0.0551925 13.557 0.0546875 14.2889V17.5952C0.0546875 17.9944 0.1258 18.3864 0.265792 18.7607L0.35253 18.9929C0.457444 19.2719 0.638254 19.5076 0.878696 19.6788V21.0395C0.878696 21.5692 1.30983 22 1.83951 22H4.69229C5.22228 22 5.6531 21.5692 5.6531 21.0395V18.9221L6.16205 18.5538L19.8389 18.6144L20.3488 18.9833V21.0395C20.3488 21.5692 20.7796 22 21.3096 22H24.1624C24.692 22 25.1232 21.5692 25.1232 21.0395V19.6785C25.3614 19.5079 25.5463 19.2671 25.649 18.9929L25.7358 18.7607C25.8761 18.3867 25.9472 17.9948 25.9472 17.5952V14.2889C25.9472 13.5587 25.76 12.8355 25.406 12.1967ZM5.74877 16.4517H2.86984C2.32486 16.4517 1.8816 16.0084 1.8816 15.4634V14.5243C1.8816 14.2379 2.11471 14.0048 2.40107 14.0048H3.46138C4.72258 14.0048 5.74877 15.031 5.74877 16.2922V16.4517ZM18.3685 16.0993H7.6334V15.1426H18.3685V16.0993ZM18.3481 12.6626C18.1086 12.8801 17.8608 13.1049 17.6242 13.3291L16.9663 12.6342C17.2106 12.4034 17.4619 12.175 17.7049 11.9544C18.4437 11.2841 19.1513 10.6412 19.7056 9.8937C19.7448 9.84109 19.7831 9.78815 19.8201 9.73426C19.857 9.68164 19.8928 9.62871 19.9278 9.57481H6.07403C6.10911 9.62871 6.14483 9.68164 6.18182 9.73426C6.21881 9.78815 6.25708 9.84109 6.2963 9.8937C6.85021 10.6412 7.55782 11.2837 8.29669 11.9544C8.53968 12.175 8.79129 12.4034 9.03524 12.6342L8.37769 13.3291C8.14075 13.1049 7.89329 12.8801 7.65381 12.6626C6.7437 11.8367 5.80553 10.9849 5.14447 9.8937C5.11258 9.84109 5.08133 9.78783 5.05104 9.73426C5.02074 9.68164 4.99172 9.62871 4.96334 9.57481H4.92795L6.1646 7.1165C6.73573 5.98094 7.88022 5.27555 9.15131 5.27555H16.8506C18.1217 5.27555 19.2658 5.98094 19.837 7.1165L21.0736 9.57481H21.0382C21.0098 9.62871 20.9808 9.68164 20.9505 9.73426C20.9202 9.78783 20.8893 9.84109 20.8574 9.8937C20.196 10.9849 19.2582 11.8367 18.3481 12.6626ZM24.1203 15.4634C24.1203 16.0084 23.6767 16.4517 23.1317 16.4517H20.2531V16.2922C20.2531 15.031 21.279 14.0048 22.5405 14.0048H23.6005C23.8872 14.0048 24.1203 14.2379 24.1203 14.5243V15.4634Z" fill="white"/></svg>',
        'dashboard3' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none"><path d="M13.0201 1.36567C6.01644 1.36567 0.338867 7.04319 0.338867 14.0469C0.338867 17.5621 1.76949 20.7429 4.0797 23.0397L5.9713 21.1482C4.21609 19.4062 3.10579 17.0174 3.0217 14.3695H4.4646C4.53121 14.3695 4.59717 14.3564 4.65872 14.3309C4.72026 14.3055 4.77618 14.2681 4.82328 14.221C4.87038 14.1739 4.90774 14.118 4.93323 14.0564C4.95871 13.9949 4.97182 13.9289 4.97181 13.8623C4.97181 13.5823 4.74478 13.3552 4.4646 13.3552H3.04011C3.19341 11.1113 4.08583 9.0715 5.47678 7.47599L6.51366 8.51297C6.71168 8.71114 7.03293 8.71114 7.23095 8.51297C7.42912 8.31485 7.42912 7.99375 7.23095 7.79568L6.18096 6.74554C7.85526 5.17655 10.0676 4.17518 12.5129 4.05314V5.37779C12.5129 5.65781 12.74 5.88484 13.0201 5.88484C13.3002 5.88484 13.5273 5.65781 13.5273 5.37779V4.05304C16.0066 4.17674 18.2463 5.20489 19.9286 6.81153L18.9446 7.79558C18.7465 7.99365 18.7465 8.31475 18.9446 8.51287C19.1427 8.71104 19.4638 8.71104 19.6619 8.51287L20.6263 7.54842C21.9813 9.13307 22.8492 11.1451 23.0001 13.3551H21.4342C21.1542 13.3551 20.927 13.5822 20.927 13.8622C20.927 14.1424 21.1542 14.3694 21.4342 14.3694H23.0184C22.9344 17.0174 21.8239 19.4061 20.0688 21.1481L21.9603 23.0396C24.2707 20.7427 25.7012 17.562 25.7012 14.0468C25.7012 7.04314 20.0237 1.36567 13.0201 1.36567Z" fill="white"/><path d="M18.3226 9.01872C17.9481 8.69788 17.4941 9.2079 17.0806 9.57169L11.9705 14.3412C11.6574 14.6758 11.7415 15.2637 12.1586 15.6542L12.2426 15.7325C12.6596 16.1229 13.2518 16.1681 13.5651 15.8336L17.8246 10.3619C18.2099 9.85707 18.6592 9.35106 18.3769 9.07041L18.3226 9.01872Z" fill="white"/></svg>',
        'price' => '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none"><g clip-path="url(#clip0_2002_24800)"><path d="M13.0001 0.222775C5.95485 0.222775 0.222852 5.95478 0.222852 13C0.222852 20.0452 5.95485 25.7772 13.0001 25.7772C20.0453 25.7772 25.7773 20.0452 25.7773 13C25.7773 5.95478 20.0453 0.222775 13.0001 0.222775ZM13.0001 23.8051C7.04202 23.8051 2.195 18.9581 2.195 13C2.195 7.04195 7.04202 2.19493 13.0001 2.19493C18.9581 2.19493 23.8051 7.04195 23.8051 13C23.8051 18.9581 18.9581 23.8051 13.0001 23.8051Z" fill="white" stroke="white" stroke-width="0.4"/><path d="M13 12.1875C11.6789 12.1875 10.5625 11.4433 10.5625 10.5625C10.5625 9.68175 11.6789 8.9375 13 8.9375C13.7475 8.9375 14.4398 9.1715 14.898 9.57775C14.9777 9.64877 15.0707 9.70335 15.1716 9.73837C15.2724 9.77338 15.3792 9.78814 15.4858 9.7818C15.5924 9.77546 15.6967 9.74814 15.7927 9.70142C15.8887 9.65469 15.9745 9.58947 16.0452 9.5095C16.3442 9.17475 16.3134 8.66125 15.977 8.36225C15.4082 7.85687 14.6445 7.51562 13.8125 7.38075V6.5C13.8125 6.0515 13.4485 5.6875 13 5.6875C12.5515 5.6875 12.1875 6.0515 12.1875 6.5V7.3775C10.335 7.67975 8.9375 8.99275 8.9375 10.5625C8.9375 12.3549 10.7607 13.8125 13 13.8125C14.3211 13.8125 15.4375 14.5568 15.4375 15.4375C15.4375 16.3182 14.3211 17.0625 13 17.0625C12.2525 17.0625 11.5602 16.8285 11.102 16.4222C10.7672 16.1233 10.2537 16.1525 9.95475 16.4905C9.65575 16.8252 9.68663 17.3387 10.023 17.6378C10.5918 18.1448 11.3555 18.4844 12.1875 18.6209V19.5C12.1875 19.9485 12.5515 20.3125 13 20.3125C13.4485 20.3125 13.8125 19.9485 13.8125 19.5V18.6225C15.665 18.3203 17.0625 17.0072 17.0625 15.4375C17.0625 13.6451 15.2393 12.1875 13 12.1875Z" fill="white"/></g><defs><clipPath><rect width="26" height="26" fill="white"/></clipPath></defs></svg>',
        'trans3' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.66646 3.75C5.47229 3.78221 4.33783 4.27922 3.50458 5.13525C2.67133 5.99128 2.20508 7.13872 2.20508 8.33333C2.20508 9.52795 2.67133 10.6754 3.50458 11.5314C4.33783 12.3874 5.47229 12.8845 6.66646 12.9167C7.86064 12.8845 8.99509 12.3874 9.82835 11.5314C10.6616 10.6754 11.1278 9.52795 11.1278 8.33333C11.1278 7.13872 10.6616 5.99128 9.82835 5.13525C8.99509 4.27922 7.86064 3.78221 6.66646 3.75ZM6.66646 6.25C7.219 6.25 7.7489 6.46949 8.1396 6.86019C8.5303 7.2509 8.7498 7.7808 8.7498 8.33333C8.7498 8.88587 8.5303 9.41577 8.1396 9.80647C7.7489 10.1972 7.219 10.4167 6.66646 10.4167C6.11393 10.4167 5.58403 10.1972 5.19332 9.80647C4.80262 9.41577 4.58313 8.88587 4.58313 8.33333C4.58313 7.7808 4.80262 7.2509 5.19332 6.86019C5.58403 6.46949 6.11393 6.25 6.66646 6.25ZM6.66646 27.0833C5.47229 27.1155 4.33783 27.6126 3.50458 28.4686C2.67133 29.3246 2.20508 30.4721 2.20508 31.6667C2.20508 32.8613 2.67133 34.0087 3.50458 34.8647C4.33783 35.7208 5.47229 36.2178 6.66646 36.25C7.86064 36.2178 8.99509 35.7208 9.82835 34.8647C10.6616 34.0087 11.1278 32.8613 11.1278 31.6667C11.1278 30.4721 10.6616 29.3246 9.82835 28.4686C8.99509 27.6126 7.86064 27.1155 6.66646 27.0833ZM6.66646 29.5833C6.94005 29.5833 7.21096 29.6372 7.46372 29.7419C7.71648 29.8466 7.94615 30.0001 8.1396 30.1935C8.33306 30.387 8.48652 30.6166 8.59121 30.8694C8.69591 31.1222 8.7498 31.3931 8.7498 31.6667C8.7498 31.9403 8.69591 32.2112 8.59121 32.4639C8.48652 32.7167 8.33306 32.9464 8.1396 33.1398C7.94615 33.3333 7.71648 33.4867 7.46372 33.5914C7.21096 33.6961 6.94005 33.75 6.66646 33.75C6.11393 33.75 5.58403 33.5305 5.19332 33.1398C4.80262 32.7491 4.58313 32.2192 4.58313 31.6667C4.58313 31.1141 4.80262 30.5842 5.19332 30.1935C5.58403 29.8028 6.11393 29.5833 6.66646 29.5833ZM19.9998 3.75C18.8056 3.78221 17.6712 4.27922 16.8379 5.13525C16.0047 5.99128 15.5384 7.13872 15.5384 8.33333C15.5384 9.52795 16.0047 10.6754 16.8379 11.5314C17.6712 12.3874 18.8056 12.8845 19.9998 12.9167C21.194 12.8845 22.3284 12.3874 23.1617 11.5314C23.9949 10.6754 24.4612 9.52795 24.4612 8.33333C24.4612 7.13872 23.9949 5.99128 23.1617 5.13525C22.3284 4.27922 21.194 3.78221 19.9998 3.75ZM19.9998 6.25C20.5523 6.25 21.0822 6.46949 21.4729 6.86019C21.8636 7.2509 22.0831 7.7808 22.0831 8.33333C22.0831 8.88587 21.8636 9.41577 21.4729 9.80647C21.0822 10.1972 20.5523 10.4167 19.9998 10.4167C19.4473 10.4167 18.9174 10.1972 18.5267 9.80647C18.136 9.41577 17.9165 8.88587 17.9165 8.33333C17.9165 7.7808 18.136 7.2509 18.5267 6.86019C18.9174 6.46949 19.4473 6.25 19.9998 6.25ZM19.9998 27.0833C18.8056 27.1155 17.6712 27.6126 16.8379 28.4686C16.0047 29.3246 15.5384 30.4721 15.5384 31.6667C15.5384 32.8613 16.0047 34.0087 16.8379 34.8647C17.6712 35.7208 18.8056 36.2178 19.9998 36.25C21.194 36.2178 22.3284 35.7208 23.1617 34.8647C23.9949 34.0087 24.4612 32.8613 24.4612 31.6667C24.4612 30.4721 23.9949 29.3246 23.1617 28.4686C22.3284 27.6126 21.194 27.1155 19.9998 27.0833ZM19.9998 29.5833C20.2734 29.5833 20.5443 29.6372 20.7971 29.7419C21.0498 29.8466 21.2795 30.0001 21.4729 30.1935C21.6664 30.387 21.8198 30.6166 21.9245 30.8694C22.0292 31.1222 22.0831 31.3931 22.0831 31.6667C22.0831 31.9403 22.0292 32.2112 21.9245 32.4639C21.8198 32.7167 21.6664 32.9464 21.4729 33.1398C21.2795 33.3333 21.0498 33.4867 20.7971 33.5914C20.5443 33.6961 20.2734 33.75 19.9998 33.75C19.4473 33.75 18.9174 33.5305 18.5267 33.1398C18.136 32.7491 17.9165 32.2192 17.9165 31.6667C17.9165 31.1141 18.136 30.5842 18.5267 30.1935C18.9174 29.8028 19.4473 29.5833 19.9998 29.5833ZM33.3331 3.75C32.139 3.78221 31.0045 4.27922 30.1712 5.13525C29.338 5.99128 28.8717 7.13872 28.8717 8.33333C28.8717 9.52795 29.338 10.6754 30.1712 11.5314C31.0045 12.3874 32.139 12.8845 33.3331 12.9167C34.5273 12.8845 35.6618 12.3874 36.495 11.5314C37.3283 10.6754 37.7945 9.52795 37.7945 8.33333C37.7945 7.13872 37.3283 5.99128 36.495 5.13525C35.6618 4.27922 34.5273 3.78221 33.3331 3.75ZM33.3331 6.25C33.8857 6.25 34.4156 6.46949 34.8063 6.86019C35.197 7.2509 35.4165 7.7808 35.4165 8.33333C35.4165 8.88587 35.197 9.41577 34.8063 9.80647C34.4156 10.1972 33.8857 10.4167 33.3331 10.4167C32.7806 10.4167 32.2507 10.1972 31.86 9.80647C31.4693 9.41577 31.2498 8.88587 31.2498 8.33333C31.2498 7.7808 31.4693 7.2509 31.86 6.86019C32.2507 6.46949 32.7806 6.25 33.3331 6.25ZM33.3331 27.0833C32.139 27.1155 31.0045 27.6126 30.1712 28.4686C29.338 29.3246 28.8717 30.4721 28.8717 31.6667C28.8717 32.8613 29.338 34.0087 30.1712 34.8647C31.0045 35.7208 32.139 36.2178 33.3331 36.25C34.5273 36.2178 35.6618 35.7208 36.495 34.8647C37.3283 34.0087 37.7945 32.8613 37.7945 31.6667C37.7945 30.4721 37.3283 29.3246 36.495 28.4686C35.6618 27.6126 34.5273 27.1155 33.3331 27.0833ZM33.3331 29.5833C33.6067 29.5833 33.8776 29.6372 34.1304 29.7419C34.3832 29.8466 34.6128 30.0001 34.8063 30.1935C34.9997 30.387 35.1532 30.6166 35.2579 30.8694C35.3626 31.1222 35.4165 31.3931 35.4165 31.6667C35.4165 31.9403 35.3626 32.2112 35.2579 32.4639C35.1532 32.7167 34.9997 32.9464 34.8063 33.1398C34.6128 33.3333 34.3832 33.4867 34.1304 33.5914C33.8776 33.6961 33.6067 33.75 33.3331 33.75C32.7806 33.75 32.2507 33.5305 31.86 33.1398C31.4693 32.7491 31.2498 32.2192 31.2498 31.6667C31.2498 31.1141 31.4693 30.5842 31.86 30.1935C32.2507 29.8028 32.7806 29.5833 33.3331 29.5833Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M5.4165 11.6667V28.3333C5.4165 28.6649 5.5482 28.9828 5.78262 29.2172C6.01704 29.4516 6.33498 29.5833 6.6665 29.5833C6.99802 29.5833 7.31597 29.4516 7.55039 29.2172C7.78481 28.9828 7.9165 28.6649 7.9165 28.3333V11.6667C7.9165 11.3351 7.78481 11.0172 7.55039 10.7828C7.31597 10.5484 6.99802 10.4167 6.6665 10.4167C6.33498 10.4167 6.01704 10.5484 5.78262 10.7828C5.5482 11.0172 5.4165 11.3351 5.4165 11.6667ZM18.7498 11.6667V28.3333C18.7498 28.6649 18.8815 28.9828 19.116 29.2172C19.3504 29.4516 19.6683 29.5833 19.9998 29.5833C20.3314 29.5833 20.6493 29.4516 20.8837 29.2172C21.1181 28.9828 21.2498 28.6649 21.2498 28.3333V11.6667C21.2498 11.3351 21.1181 11.0172 20.8837 10.7828C20.6493 10.5484 20.3314 10.4167 19.9998 10.4167C19.6683 10.4167 19.3504 10.5484 19.116 10.7828C18.8815 11.0172 18.7498 11.3351 18.7498 11.6667Z" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M32.0832 11.6667V18.3333C32.0832 18.4438 32.0393 18.5498 31.9611 18.628C31.883 18.7061 31.777 18.75 31.6665 18.75H6.6665C6.33498 18.75 6.01704 18.8817 5.78262 19.1161C5.5482 19.3505 5.4165 19.6685 5.4165 20C5.4165 20.3315 5.5482 20.6495 5.78262 20.8839C6.01704 21.1183 6.33498 21.25 6.6665 21.25H31.6665C32.4401 21.25 33.1819 20.9427 33.7289 20.3957C34.2759 19.8487 34.5832 19.1069 34.5832 18.3333V11.6667C34.5832 11.3351 34.4515 11.0172 34.2171 10.7828C33.9826 10.5484 33.6647 10.4167 33.3332 10.4167C33.0017 10.4167 32.6837 10.5484 32.4493 10.7828C32.2149 11.0172 32.0832 11.3351 32.0832 11.6667Z" fill="white"/></svg>',
        'engine3' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M35.7143 11.5179H34.2857C33.9068 11.5179 33.5435 11.6684 33.2756 11.9363C33.0077 12.2042 32.8571 12.5675 32.8571 12.9464V17.2321H28.5714V14.375C28.5714 13.6172 28.2704 12.8905 27.7346 12.3547C27.1988 11.8189 26.472 11.5179 25.7143 11.5179H20V8.66071H25.7143C26.0932 8.66071 26.4565 8.5102 26.7244 8.2423C26.9923 7.97439 27.1429 7.61102 27.1429 7.23214V5.80357C27.1429 5.42469 26.9923 5.06133 26.7244 4.79342C26.4565 4.52551 26.0932 4.375 25.7143 4.375H10C9.62112 4.375 9.25776 4.52551 8.98985 4.79342C8.72194 5.06133 8.57143 5.42469 8.57143 5.80357V7.23214C8.57143 7.61102 8.72194 7.97439 8.98985 8.2423C9.25776 8.5102 9.62112 8.66071 10 8.66071H15.7143V11.5179H10C9.24224 11.5179 8.51551 11.8189 7.97969 12.3547C7.44388 12.8905 7.14286 13.6172 7.14286 14.375V20.0893H4.28571V15.8036C4.28571 15.4247 4.1352 15.0613 3.8673 14.7934C3.59939 14.5255 3.23602 14.375 2.85714 14.375H1.42857C1.04969 14.375 0.686328 14.5255 0.418419 14.7934C0.15051 15.0613 0 15.4247 0 15.8036V28.6607C0 29.0396 0.15051 29.403 0.418419 29.6709C0.686328 29.9388 1.04969 30.0893 1.42857 30.0893H2.85714C3.23602 30.0893 3.59939 29.9388 3.8673 29.6709C4.1352 29.403 4.28571 29.0396 4.28571 28.6607V24.375H7.14286V28.0779C7.14289 28.4851 7.22996 28.8876 7.39824 29.2584C7.56652 29.6292 7.81212 29.9597 8.11857 30.2279L12.05 33.6679C12.57 34.1236 13.2386 34.375 13.93 34.375H25.7143C26.472 34.375 27.1988 34.074 27.7346 33.5382C28.2704 33.0023 28.5714 32.2756 28.5714 31.5179V27.2321H32.8571V31.5179C32.8571 31.8967 33.0077 32.2601 33.2756 32.528C33.5435 32.7959 33.9068 32.9464 34.2857 32.9464H35.7143C36.8509 32.9464 37.941 32.4949 38.7447 31.6912C39.5485 30.8874 40 29.7974 40 28.6607V15.8036C40 14.6669 39.5485 13.5768 38.7447 12.7731C37.941 11.9694 36.8509 11.5179 35.7143 11.5179ZM22.6171 23.7393L19.76 28.025C19.3214 28.6821 18.5714 28.6607 18.5714 28.6607V24.375H15.7143C15.4559 24.3749 15.2023 24.3046 14.9807 24.1718C14.759 24.039 14.5776 23.8485 14.4556 23.6207C14.3336 23.3929 14.2757 23.1363 14.2881 22.8782C14.3004 22.6201 14.3826 22.3701 14.5257 22.155L17.3829 17.8693C17.82 17.2107 18.5714 17.2321 18.5714 17.2321V21.5179H21.4286C21.6872 21.5178 21.941 21.588 22.1629 21.7209C22.3847 21.8538 22.5664 22.0444 22.6884 22.2725C22.8104 22.5005 22.8682 22.7574 22.8557 23.0157C22.8431 23.2741 22.7607 23.5241 22.6171 23.7393Z" fill="white"/></svg>',
        'stock3' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M20.0011 1.252C17.3316 1.24714 14.692 1.81421 12.2601 2.91502C12.1834 2.94992 12.1147 2.99992 12.0578 3.06202C12.001 3.12411 11.9572 3.19704 11.9292 3.27643C11.9012 3.35583 11.8895 3.44005 11.8948 3.52407C11.9001 3.60809 11.9223 3.69018 11.96 3.76543L13.0774 6.00248C13.1497 6.14651 13.2748 6.2571 13.4266 6.31122C13.5784 6.36534 13.7452 6.35883 13.8924 6.29304C15.8148 5.4367 17.8966 4.99636 20.0011 5.00089C22.7249 4.99953 25.3976 5.74042 27.732 7.14395C30.0663 8.54748 31.9741 10.5606 33.2502 12.9669C34.5264 15.3733 35.1227 18.0819 34.9751 20.8017C34.8275 23.5215 33.9415 26.1496 32.4124 28.4037L30.4423 26.4312C30.3545 26.3447 30.2431 26.286 30.1221 26.2626C30.0011 26.2391 29.8758 26.2519 29.7621 26.2993C29.6483 26.3467 29.551 26.4267 29.4825 26.5292C29.414 26.6316 29.3773 26.7521 29.3769 26.8753V33.7495C29.3769 34.0944 29.6533 34.3755 29.9982 34.3778H36.8723C36.9966 34.3784 37.1182 34.342 37.2217 34.2733C37.3251 34.2045 37.4058 34.1066 37.4535 33.9918C37.5011 33.8771 37.5135 33.7507 37.4891 33.6289C37.4647 33.5071 37.4046 33.3953 37.3165 33.3077L35.1007 31.0919C37.4732 27.8809 38.7532 23.9936 38.7527 20.0012C38.7502 15.0287 36.7738 10.2607 33.2577 6.7446C29.7417 3.22855 24.9736 1.2545 20.0011 1.252ZM3.12286 5.62216C2.99932 5.62252 2.87864 5.65942 2.77602 5.72823C2.67341 5.79704 2.59345 5.89468 2.54622 6.00884C2.49899 6.123 2.4866 6.24859 2.5106 6.36978C2.53461 6.49098 2.59394 6.60236 2.68112 6.6899L4.89691 8.90569C2.52612 12.119 1.24856 16.008 1.25196 20.0012C1.25441 23.1361 2.04241 26.2205 3.54394 28.9724C5.04548 31.7244 7.21269 34.0562 9.84756 35.7548C12.4824 37.4534 15.5009 38.4647 18.6273 38.6963C21.7537 38.9278 24.8883 38.3722 27.7446 37.0803C27.821 37.0451 27.8896 36.995 27.9462 36.9328C28.0028 36.8706 28.0463 36.7976 28.074 36.7183C28.1018 36.6389 28.1133 36.5547 28.1079 36.4708C28.1024 36.3869 28.0801 36.305 28.0423 36.2298L26.9225 33.9952C26.8502 33.8517 26.7256 33.7416 26.5743 33.6875C26.423 33.6334 26.2568 33.6395 26.1099 33.7046C24.1876 34.5617 22.1059 35.0028 20.0011 34.9991C17.2771 35.0015 14.604 34.2614 12.269 32.8585C9.93398 31.4557 8.02545 29.4429 6.74852 27.0368C5.47158 24.6306 4.87453 21.9219 5.02152 19.2018C5.16851 16.4818 6.05399 13.8532 7.58279 11.5987L9.56 13.5711C9.6478 13.6577 9.75919 13.7163 9.8802 13.7398C10.0012 13.7633 10.1265 13.7505 10.2402 13.7031C10.354 13.6556 10.4513 13.5757 10.5198 13.4732C10.5883 13.3707 10.625 13.2503 10.6254 13.127V6.25288C10.6254 6.08686 10.5594 5.92763 10.442 5.81024C10.3246 5.69284 10.1654 5.62688 9.99938 5.62688L3.12286 5.62216ZM21.2177 9.37341C21.1176 9.37895 21.0203 9.40844 20.934 9.45942C20.8476 9.51039 20.7748 9.58135 20.7216 9.66633L13.2239 21.5414C13.1646 21.6357 13.1315 21.7441 13.1282 21.8555C13.1248 21.9668 13.1512 22.0771 13.2046 22.1748C13.2581 22.2725 13.3366 22.3543 13.4322 22.4115C13.5278 22.4687 13.6369 22.4994 13.7483 22.5004H18.6995L18.1279 29.9533C18.0806 30.5982 18.9263 30.8793 19.2759 30.336L26.7784 18.4586C26.838 18.3638 26.8711 18.2547 26.8742 18.1428C26.8773 18.0308 26.8502 17.9201 26.796 17.8221C26.7417 17.7242 26.6621 17.6426 26.5655 17.5858C26.469 17.5291 26.3589 17.4993 26.2469 17.4996H21.298L21.8744 10.049C21.882 9.96021 21.8704 9.87082 21.8405 9.78686C21.8106 9.7029 21.763 9.62633 21.701 9.56231C21.639 9.49828 21.564 9.4483 21.481 9.41571C21.3981 9.38313 21.3067 9.36871 21.2177 9.37341Z" fill="white"/></svg>',
        'vin3' => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><g clip-path="url(#clip0_2002_25237)"><path d="M18.5874 19.996L13.629 15.0376C12.4547 13.8659 10.5533 13.8659 9.37899 15.0376L6.54541 17.8712C5.37374 19.0455 5.37374 20.9469 6.54541 22.1212L11.5042 27.0796L18.5874 19.996ZM24.9624 26.3711L20.0042 21.4128L12.9206 28.496L17.879 33.4546C19.0533 34.6264 20.9547 34.6264 22.129 33.4546L24.9625 30.6212C26.1342 29.4469 26.1342 27.5455 24.9625 26.3712L24.9624 26.3711ZM3.00382 27.0796L5.8374 24.246L15.7542 34.1628L12.9206 36.9962L3.00382 27.0796ZM0.879107 29.2044C-0.293036 30.3787 -0.293036 32.2801 0.879107 33.4544L2.29543 34.8712C1.51923 35.6547 1.52176 36.9181 2.30172 37.6984C3.08167 38.4784 4.34548 38.4809 5.129 37.7044L6.54541 39.1211C7.71972 40.2928 9.6211 40.2928 10.7954 39.1211L11.5042 38.4128L1.58741 28.496L0.879107 29.2044ZM39.1292 5.12084C40.294 3.94588 40.29 2.05032 39.1197 0.880058C37.9498 -0.289831 36.0544 -0.293869 34.8793 0.870854L31.3373 4.41245L35.5877 8.66244L39.1292 5.12084ZM34.8793 15.0376C36.051 13.8633 36.051 11.9619 34.8793 10.7876L29.2125 5.12084C28.0382 3.94917 26.1368 3.94917 24.9625 5.12084L15.7542 14.3292L25.6709 24.246L34.8793 15.0376Z" fill="white"/></g><defs><clipPath><rect width="40" height="40" fill="white"/></clipPath></defs></svg>',
        'view' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M30.9137 15.595C30.87 15.4963 29.8112 13.1475 27.4575 10.7937C24.3212 7.6575 20.36 6 16 6C11.64 6 7.67874 7.6575 4.54249 10.7937C2.18874 13.1475 1.12499 15.5 1.08624 15.595C1.02938 15.7229 1 15.8613 1 16.0012C1 16.1412 1.02938 16.2796 1.08624 16.4075C1.12999 16.5062 2.18874 18.8538 4.54249 21.2075C7.67874 24.3425 11.64 26 16 26C20.36 26 24.3212 24.3425 27.4575 21.2075C29.8112 18.8538 30.87 16.5062 30.9137 16.4075C30.9706 16.2796 31 16.1412 31 16.0012C31 15.8613 30.9706 15.7229 30.9137 15.595ZM16 24C12.1525 24 8.79124 22.6012 6.00874 19.8438C4.86704 18.7084 3.89572 17.4137 3.12499 16C3.89551 14.5862 4.86686 13.2915 6.00874 12.1562C8.79124 9.39875 12.1525 8 16 8C19.8475 8 23.2087 9.39875 25.9912 12.1562C27.1352 13.2912 28.1086 14.5859 28.8812 16C27.98 17.6825 24.0537 24 16 24ZM16 10C14.8133 10 13.6533 10.3519 12.6666 11.0112C11.6799 11.6705 10.9108 12.6075 10.4567 13.7039C10.0026 14.8003 9.88377 16.0067 10.1153 17.1705C10.3468 18.3344 10.9182 19.4035 11.7573 20.2426C12.5965 21.0818 13.6656 21.6532 14.8294 21.8847C15.9933 22.1162 17.1997 21.9974 18.2961 21.5433C19.3924 21.0892 20.3295 20.3201 20.9888 19.3334C21.6481 18.3467 22 17.1867 22 16C21.9983 14.4092 21.3657 12.884 20.2408 11.7592C19.1159 10.6343 17.5908 10.0017 16 10ZM16 20C15.2089 20 14.4355 19.7654 13.7777 19.3259C13.1199 18.8864 12.6072 18.2616 12.3045 17.5307C12.0017 16.7998 11.9225 15.9956 12.0768 15.2196C12.2312 14.4437 12.6122 13.731 13.1716 13.1716C13.731 12.6122 14.4437 12.2312 15.2196 12.0769C15.9956 11.9225 16.7998 12.0017 17.5307 12.3045C18.2616 12.6072 18.8863 13.1199 19.3259 13.7777C19.7654 14.4355 20 15.2089 20 16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20Z" fill="white"/></svg>',
        'plus' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M28 16C28 16.2652 27.8946 16.5196 27.7071 16.7071C27.5196 16.8946 27.2652 17 27 17H17V27C17 27.2652 16.8946 27.5196 16.7071 27.7071C16.5196 27.8946 16.2652 28 16 28C15.7348 28 15.4804 27.8946 15.2929 27.7071C15.1054 27.5196 15 27.2652 15 27V17H5C4.73478 17 4.48043 16.8946 4.29289 16.7071C4.10536 16.5196 4 16.2652 4 16C4 15.7348 4.10536 15.4804 4.29289 15.2929C4.48043 15.1054 4.73478 15 5 15H15V5C15 4.73478 15.1054 4.48043 15.2929 4.29289C15.4804 4.10536 15.7348 4 16 4C16.2652 4 16.5196 4.10536 16.7071 4.29289C16.8946 4.48043 17 4.73478 17 5V15H27C27.2652 15 27.5196 15.1054 27.7071 15.2929C27.8946 15.4804 28 15.7348 28 16Z" fill="white"/></svg>',
        'camera' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M13.125 8.75L17.0583 4.81667C17.1457 4.72937 17.2571 4.66993 17.3782 4.64586C17.4994 4.62179 17.625 4.63417 17.7391 4.68143C17.8532 4.72869 17.9508 4.80871 18.0195 4.91139C18.0882 5.01407 18.1249 5.1348 18.125 5.25833V14.7417C18.1249 14.8652 18.0882 14.9859 18.0195 15.0886C17.9508 15.1913 17.8532 15.2713 17.7391 15.3186C17.625 15.3658 17.4994 15.3782 17.3782 15.3541C17.2571 15.3301 17.1457 15.2706 17.0583 15.1833L13.125 11.25M3.75 15.625H11.25C11.7473 15.625 12.2242 15.4275 12.5758 15.0758C12.9275 14.7242 13.125 14.2473 13.125 13.75V6.25C13.125 5.75272 12.9275 5.27581 12.5758 4.92417C12.2242 4.57254 11.7473 4.375 11.25 4.375H3.75C3.25272 4.375 2.77581 4.57254 2.42417 4.92417C2.07254 5.27581 1.875 5.75272 1.875 6.25V13.75C1.875 14.2473 2.07254 14.7242 2.42417 15.0758C2.77581 15.4275 3.25272 15.625 3.75 15.625Z" stroke="#24272C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'image' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1.875 13.125L6.17417 8.82583C6.34828 8.65172 6.55498 8.51361 6.78246 8.41938C7.00995 8.32515 7.25377 8.27665 7.5 8.27665C7.74623 8.27665 7.99005 8.32515 8.21754 8.41938C8.44502 8.51361 8.65172 8.65172 8.82583 8.82583L13.125 13.125M11.875 11.875L13.0492 10.7008C13.2233 10.5267 13.43 10.3886 13.6575 10.2944C13.885 10.2001 14.1288 10.1516 14.375 10.1516C14.6212 10.1516 14.865 10.2001 15.0925 10.2944C15.32 10.3886 15.5267 10.5267 15.7008 10.7008L18.125 13.125M3.125 16.25H16.875C17.2065 16.25 17.5245 16.1183 17.7589 15.8839C17.9933 15.6495 18.125 15.3315 18.125 15V5C18.125 4.66848 17.9933 4.35054 17.7589 4.11612C17.5245 3.8817 17.2065 3.75 16.875 3.75H3.125C2.79348 3.75 2.47554 3.8817 2.24112 4.11612C2.0067 4.35054 1.875 4.66848 1.875 5V15C1.875 15.3315 2.0067 15.6495 2.24112 15.8839C2.47554 16.1183 2.79348 16.25 3.125 16.25ZM11.875 6.875H11.8817V6.88167H11.875V6.875ZM12.1875 6.875C12.1875 6.95788 12.1546 7.03737 12.096 7.09597C12.0374 7.15458 11.9579 7.1875 11.875 7.1875C11.7921 7.1875 11.7126 7.15458 11.654 7.09597C11.5954 7.03737 11.5625 6.95788 11.5625 6.875C11.5625 6.79212 11.5954 6.71263 11.654 6.65403C11.7126 6.59542 11.7921 6.5625 11.875 6.5625C11.9579 6.5625 12.0374 6.59542 12.096 6.65403C12.1546 6.71263 12.1875 6.79212 12.1875 6.875Z" stroke="#24272C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'file' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><path d="M26.8125 2.20341V27.7961C26.8125 28.1471 26.6731 28.4837 26.4248 28.7319C26.1766 28.9801 25.84 29.1196 25.489 29.1196H4.51103C4.16001 29.1196 3.82336 28.9801 3.57515 28.7319C3.32694 28.4837 3.1875 28.1471 3.1875 27.7961V6.19165H7.18015C7.53117 6.19165 7.86781 6.0522 8.11602 5.804C8.36423 5.55579 8.50368 5.21914 8.50368 4.86812V0.879883H25.489C25.84 0.879883 26.1766 1.01933 26.4248 1.26754C26.6731 1.51575 26.8125 1.85239 26.8125 2.20341Z" fill="#E9EDF4"/><path d="M3.1875 6.19165H7.18015C7.53117 6.19165 7.86781 6.0522 8.11602 5.804C8.36423 5.55579 8.50368 5.21914 8.50368 4.86812V0.879883L3.1875 6.19165Z" fill="#D2DBEA"/><path d="M28.2352 17.2884V23.4296C28.2352 23.7806 28.0958 24.1172 27.8476 24.3654C27.5994 24.6136 27.2627 24.7531 26.9117 24.7531H3.08818C2.73716 24.7531 2.40051 24.6136 2.1523 24.3654C1.90409 24.1172 1.76465 23.7806 1.76465 23.4296V17.2884C1.76465 16.9374 1.90409 16.6007 2.1523 16.3525C2.40051 16.1043 2.73716 15.9648 3.08818 15.9648H26.9117C27.2627 15.9648 27.5994 16.1043 27.8476 16.3525C28.0958 16.6007 28.2352 16.9374 28.2352 17.2884Z" fill="var(--theme-primary-color)"/><path d="M23.1764 9.92459C23.1764 10.2414 22.924 10.4937 22.6073 10.4937H7.39285C7.24191 10.4937 7.09715 10.4337 6.99042 10.327C6.88369 10.2203 6.82373 10.0755 6.82373 9.92459C6.82373 9.77365 6.88369 9.62889 6.99042 9.52216C7.09715 9.41543 7.24191 9.35547 7.39285 9.35547H22.6073C22.924 9.35547 23.1764 9.60782 23.1764 9.92459ZM23.1764 12.8408C23.1764 13.1575 22.924 13.4099 22.6073 13.4099H7.39285C7.24191 13.4099 7.09715 13.3499 6.99042 13.2432C6.88369 13.1365 6.82373 12.9917 6.82373 12.8408C6.82373 12.6898 6.88369 12.5451 6.99042 12.4383C7.09715 12.3316 7.24191 12.2716 7.39285 12.2716H22.6073C22.924 12.2716 23.1764 12.5244 23.1764 12.8408Z" fill="#D2DBEA"/><path d="M9.38751 22.4589C9.36125 22.4331 9.34057 22.4021 9.32676 22.368C9.31295 22.3338 9.3063 22.2972 9.30721 22.2604V18.4667C9.30721 18.3886 9.33368 18.3211 9.38751 18.2655C9.41283 18.2384 9.44361 18.2169 9.47782 18.2024C9.51203 18.188 9.54891 18.1809 9.58604 18.1817H10.9991C11.3918 18.1817 11.7121 18.2479 11.9596 18.3802C12.2079 18.5126 12.3853 18.682 12.4934 18.8885C12.6002 19.0949 12.6544 19.3182 12.6544 19.5577C12.6544 19.7973 12.6002 20.021 12.4929 20.2274C12.3853 20.4339 12.2079 20.6033 11.9596 20.7357C11.7121 20.868 11.3913 20.9342 10.9991 20.9342H9.87104V22.2604C9.87177 22.2975 9.86468 22.3344 9.85024 22.3686C9.8358 22.4028 9.81433 22.4335 9.78721 22.4589C9.73162 22.5123 9.66412 22.5392 9.58559 22.5392C9.50706 22.5392 9.44089 22.5127 9.38751 22.4589ZM10.9435 20.4008C11.3649 20.4008 11.6613 20.3201 11.8325 20.1591C12.0041 19.998 12.0897 19.7973 12.0897 19.5577C12.0897 19.3182 12.0041 19.1174 11.8325 18.9564C11.6613 18.7954 11.3649 18.7146 10.9435 18.7146H9.87104V20.4008H10.9435Z" fill="white"/><path d="M9.58552 22.6498C9.53431 22.6504 9.4835 22.6407 9.43613 22.6212C9.38875 22.6017 9.34579 22.5729 9.30979 22.5365C9.27313 22.5006 9.2442 22.4575 9.22478 22.41C9.20536 22.3625 9.19585 22.3116 9.19685 22.2603V18.4666C9.19685 18.359 9.23435 18.2654 9.30847 18.1887C9.34406 18.1511 9.38704 18.1212 9.43472 18.101C9.4824 18.0808 9.53375 18.0707 9.58552 18.0713H10.9991C11.408 18.0713 11.7486 18.1423 12.0116 18.2826C12.278 18.4247 12.4726 18.6113 12.5908 18.8372C12.7055 19.0591 12.7646 19.3013 12.7646 19.5576C12.7646 19.814 12.706 20.0562 12.5908 20.2781C12.473 20.504 12.278 20.6906 12.0116 20.8331C11.7491 20.9729 11.4085 21.044 10.9991 21.044H9.98126V22.2603C9.98188 22.3122 9.97177 22.3637 9.95158 22.4115C9.93139 22.4593 9.90154 22.5025 9.86391 22.5382C9.82717 22.5741 9.78371 22.6024 9.73601 22.6215C9.68832 22.6406 9.63733 22.6501 9.58597 22.6494L9.58552 22.6498ZM9.58552 18.2919C9.56339 18.2912 9.54136 18.2953 9.52095 18.3039C9.50054 18.3125 9.48223 18.3254 9.46729 18.3418C9.45094 18.3581 9.43809 18.3776 9.42952 18.3991C9.42095 18.4205 9.41684 18.4435 9.41744 18.4666V22.2603C9.41744 22.3097 9.43244 22.3481 9.46552 22.3803C9.5317 22.4465 9.64067 22.4469 9.71126 22.379C9.72755 22.3638 9.74039 22.3453 9.74891 22.3248C9.75744 22.3042 9.76145 22.2821 9.76067 22.2598V20.8234H10.9991C11.3718 20.8234 11.6776 20.7612 11.9079 20.6381C12.1346 20.5172 12.2983 20.3619 12.3954 20.1762C12.4938 19.9865 12.5441 19.7782 12.5441 19.5576C12.5441 19.337 12.4938 19.1293 12.3954 18.9391C12.2983 18.7538 12.1342 18.5981 11.9079 18.4772C11.6771 18.3541 11.3714 18.2919 10.9991 18.2919H9.58552ZM10.9435 20.511H9.76067V18.6043H10.943C11.3974 18.6043 11.7138 18.6929 11.9079 18.876C12.102 19.0582 12.1999 19.2876 12.1999 19.5576C12.1999 19.8276 12.102 20.057 11.9079 20.2393C11.7138 20.4223 11.3979 20.511 10.9435 20.511ZM9.98126 20.2904H10.943C11.3335 20.2904 11.6074 20.219 11.757 20.0787C11.907 19.9375 11.9793 19.7676 11.9793 19.5576C11.9793 19.3476 11.9066 19.1773 11.757 19.037C11.6074 18.8959 11.3335 18.8253 10.9435 18.8253H9.98126V20.2904ZM13.553 22.4275C13.5267 22.4017 13.5059 22.3708 13.492 22.3366C13.4782 22.3025 13.4714 22.2658 13.4723 22.229V18.4666C13.4723 18.3885 13.4988 18.321 13.553 18.2654C13.5783 18.2383 13.609 18.2169 13.6431 18.2024C13.6773 18.188 13.7141 18.1809 13.7511 18.1816H14.997C15.4677 18.1816 15.8679 18.2862 16.1966 18.4948C16.5134 18.6909 16.7698 18.9708 16.9373 19.3035C17.1023 19.6344 17.1848 19.9812 17.1848 20.3447C17.1848 20.7082 17.1023 21.0554 16.9373 21.3863C16.7696 21.7191 16.5131 21.999 16.1961 22.195C15.8679 22.4041 15.4682 22.5082 14.997 22.5082H13.7516C13.7147 22.5091 13.6781 22.5024 13.6439 22.4885C13.6098 22.4746 13.5788 22.4538 13.553 22.4275ZM14.9291 21.9815C15.2674 21.9815 15.5648 21.9122 15.8211 21.7737C16.0704 21.6422 16.2769 21.4421 16.4163 21.197C16.5566 20.9513 16.6271 20.6676 16.6271 20.3451C16.6271 20.0226 16.5566 19.7385 16.4163 19.4928C16.2768 19.2478 16.0704 19.0478 15.8211 18.9162C15.5652 18.7776 15.2674 18.7088 14.9291 18.7088H14.0361V21.9815H14.9291Z" fill="white"/><path d="M14.9969 22.6185H13.7515C13.7002 22.6192 13.6494 22.6096 13.6019 22.5902C13.5545 22.5708 13.5114 22.542 13.4753 22.5056C13.4387 22.4697 13.4097 22.4267 13.3903 22.3792C13.3709 22.3317 13.3614 22.2807 13.3624 22.2294V18.4666C13.3624 18.359 13.3999 18.2654 13.474 18.1887C13.5096 18.151 13.5527 18.1211 13.6005 18.1009C13.6482 18.0807 13.6996 18.0707 13.7515 18.0713H14.9974C15.4875 18.0713 15.9106 18.1825 16.2561 18.4018C16.5895 18.6088 16.8594 18.9037 17.0361 19.2541C17.2065 19.5925 17.2952 19.9661 17.2952 20.3449C17.2952 20.7238 17.2065 21.0974 17.0361 21.4357C16.8594 21.7862 16.5895 22.0811 16.2561 22.2881C15.9106 22.5073 15.4871 22.6185 14.9969 22.6185ZM13.7511 18.2919C13.7288 18.2911 13.7067 18.2952 13.6862 18.3038C13.6657 18.3124 13.6474 18.3254 13.6324 18.3418C13.616 18.3581 13.6032 18.3776 13.5946 18.3991C13.586 18.4205 13.5819 18.4435 13.5825 18.4666V22.2294C13.5825 22.2784 13.5975 22.3168 13.6311 22.3494C13.6466 22.3653 13.6653 22.3783 13.686 22.3866C13.7066 22.3949 13.7288 22.3987 13.7511 22.3979H14.9969C15.4447 22.3979 15.8281 22.2982 16.1374 22.1023C16.437 21.9165 16.6795 21.6517 16.8384 21.3369C16.9937 21.0293 17.0746 20.6895 17.0746 20.3449C17.0746 20.0003 16.9937 19.6606 16.8384 19.3529C16.6795 19.0384 16.4369 18.7737 16.1374 18.5879C15.8281 18.3916 15.4447 18.2923 14.9969 18.2923H13.7515L13.7511 18.2919ZM14.929 22.0918H13.9258V18.5981H14.929C15.2837 18.5981 15.6018 18.6726 15.8736 18.8187C16.1471 18.9669 16.3619 19.1751 16.5119 19.4376C16.6619 19.7001 16.7374 20.0054 16.7374 20.3451C16.7374 20.6848 16.6619 20.9901 16.5119 21.2518C16.3622 21.5145 16.1408 21.7292 15.8736 21.8707C15.6022 22.0172 15.2841 22.0918 14.929 22.0918ZM14.1463 21.8712H14.929C15.2471 21.8712 15.5299 21.8054 15.7686 21.6771C16.005 21.5491 16.1908 21.3691 16.3205 21.1423C16.4506 20.9143 16.5168 20.646 16.5168 20.3451C16.5168 20.0443 16.4506 19.776 16.3205 19.5475C16.1908 19.3209 15.9996 19.1356 15.769 19.0132C15.5294 18.8844 15.2471 18.8191 14.929 18.8191H14.1463V21.8712ZM18.2078 22.4588C18.1816 22.433 18.1609 22.402 18.1471 22.3679C18.1333 22.3337 18.1266 22.2971 18.1275 22.2603V18.4666C18.1275 18.3885 18.154 18.321 18.2078 18.2654C18.2331 18.2383 18.2639 18.2168 18.2981 18.2023C18.3323 18.1879 18.3692 18.1808 18.4063 18.1816H20.8174C20.8915 18.1816 20.9546 18.2076 21.0062 18.2593C21.0578 18.3109 21.0838 18.374 21.0838 18.4481C21.0838 18.5222 21.0578 18.5848 21.0062 18.6343C20.9546 18.6837 20.8915 18.7084 20.8174 18.7084H18.6913V20.0782H20.6003C20.6753 20.0782 20.738 20.1047 20.7896 20.1559C20.8412 20.2075 20.8672 20.2706 20.8672 20.3451C20.8672 20.4193 20.8412 20.4815 20.7896 20.5309C20.738 20.5803 20.6749 20.605 20.6003 20.605H18.6913V22.2603C18.6921 22.2974 18.685 22.3343 18.6706 22.3685C18.6561 22.4027 18.6346 22.4335 18.6075 22.4588C18.5519 22.5122 18.4844 22.5391 18.4063 22.5391C18.3283 22.5391 18.2616 22.5126 18.2078 22.4588Z" fill="white"/><path d="M18.4058 22.6499C18.3546 22.6504 18.3038 22.6407 18.2564 22.6212C18.2091 22.6017 18.1661 22.5729 18.1301 22.5365C18.0934 22.5006 18.0645 22.4576 18.0451 22.4101C18.0257 22.3626 18.0162 22.3116 18.0172 22.2603V18.4666C18.0172 18.359 18.0547 18.2655 18.1288 18.1887C18.1644 18.151 18.2075 18.1212 18.2552 18.101C18.303 18.0808 18.3544 18.0707 18.4063 18.0713H20.8173C20.8669 18.0705 20.9161 18.0798 20.962 18.0986C21.0079 18.1175 21.0495 18.1454 21.0842 18.1807C21.1195 18.2157 21.1474 18.2573 21.1663 18.3033C21.1852 18.3492 21.1946 18.3984 21.1941 18.4481C21.194 18.4973 21.1841 18.5459 21.165 18.5912C21.146 18.6365 21.1181 18.6776 21.0831 18.7121C21.048 18.7466 21.0065 18.7737 20.9609 18.792C20.9153 18.8103 20.8665 18.8194 20.8173 18.8187H18.8016V19.968H20.6002C20.6499 19.9672 20.6993 19.9765 20.7452 19.9954C20.7912 20.0143 20.8328 20.0423 20.8676 20.0778C20.9031 20.1126 20.9311 20.1542 20.95 20.2002C20.9689 20.2461 20.9782 20.2955 20.9775 20.3452C20.9781 20.3947 20.9686 20.4439 20.9494 20.4896C20.9302 20.5353 20.9017 20.5765 20.8658 20.6107C20.8306 20.6448 20.7891 20.6716 20.7435 20.6896C20.6979 20.7075 20.6492 20.7162 20.6002 20.7153H18.8016V22.2603C18.8022 22.3122 18.7922 22.3636 18.7721 22.4115C18.752 22.4593 18.7222 22.5024 18.6847 22.5382C18.6479 22.5742 18.6043 22.6025 18.5566 22.6216C18.5088 22.6407 18.4577 22.6501 18.4063 22.6494L18.4058 22.6499ZM18.4058 18.2919C18.3837 18.2912 18.3617 18.2953 18.3413 18.3039C18.3209 18.3125 18.3025 18.3254 18.2876 18.3418C18.2713 18.3581 18.2584 18.3776 18.2498 18.3991C18.2413 18.4205 18.2372 18.4435 18.2377 18.4666V22.2603C18.2377 22.3097 18.2527 22.3481 18.2863 22.3803C18.3525 22.4465 18.461 22.4469 18.5316 22.379C18.5479 22.3638 18.5607 22.3453 18.5692 22.3248C18.5778 22.3042 18.5818 22.2821 18.581 22.2599V20.4952H20.6002C20.6211 20.4959 20.6419 20.4924 20.6613 20.4848C20.6807 20.4772 20.6984 20.4657 20.7132 20.451C20.7276 20.4376 20.739 20.4211 20.7466 20.4029C20.7541 20.3846 20.7576 20.3649 20.7569 20.3452C20.7569 20.3002 20.7427 20.2649 20.7114 20.234C20.6801 20.2031 20.6452 20.1885 20.6002 20.1885H18.581V18.5981H20.8177C20.8384 18.5988 20.859 18.5953 20.8783 18.5878C20.8975 18.5803 20.9151 18.5689 20.9298 18.5544C20.9443 18.5409 20.9556 18.5245 20.9632 18.5062C20.9707 18.488 20.9742 18.4683 20.9735 18.4485C20.9742 18.4278 20.9705 18.4071 20.9627 18.3879C20.9549 18.3686 20.9431 18.3513 20.928 18.3369C20.9138 18.3222 20.8966 18.3106 20.8776 18.3029C20.8586 18.2951 20.8382 18.2914 20.8177 18.2919H18.4058Z" fill="white"/></svg>',
        'number' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M17.5 10.0004C17.5 10.1662 17.4342 10.3252 17.317 10.4424C17.1998 10.5596 17.0408 10.6254 16.875 10.6254H8.12503C7.95927 10.6254 7.8003 10.5596 7.68309 10.4424C7.56588 10.3252 7.50003 10.1662 7.50003 10.0004C7.50003 9.83469 7.56588 9.67572 7.68309 9.55851C7.8003 9.4413 7.95927 9.37545 8.12503 9.37545H16.875C17.0408 9.37545 17.1998 9.4413 17.317 9.55851C17.4342 9.67572 17.5 9.83469 17.5 10.0004ZM8.12503 5.62545H16.875C17.0408 5.62545 17.1998 5.5596 17.317 5.44239C17.4342 5.32518 17.5 5.16621 17.5 5.00045C17.5 4.83469 17.4342 4.67572 17.317 4.55851C17.1998 4.4413 17.0408 4.37545 16.875 4.37545H8.12503C7.95927 4.37545 7.8003 4.4413 7.68309 4.55851C7.56588 4.67572 7.50003 4.83469 7.50003 5.00045C7.50003 5.16621 7.56588 5.32518 7.68309 5.44239C7.8003 5.5596 7.95927 5.62545 8.12503 5.62545ZM16.875 14.3754H8.12503C7.95927 14.3754 7.8003 14.4413 7.68309 14.5585C7.56588 14.6757 7.50003 14.8347 7.50003 15.0004C7.50003 15.1662 7.56588 15.3252 7.68309 15.4424C7.8003 15.5596 7.95927 15.6254 8.12503 15.6254H16.875C17.0408 15.6254 17.1998 15.5596 17.317 15.4424C17.4342 15.3252 17.5 15.1662 17.5 15.0004C17.5 14.8347 17.4342 14.6757 17.317 14.5585C17.1998 14.4413 17.0408 14.3754 16.875 14.3754ZM3.40472 4.30982L3.75003 4.13638V8.12545C3.75003 8.29121 3.81588 8.45018 3.93309 8.56739C4.0503 8.6846 4.20927 8.75045 4.37503 8.75045C4.5408 8.75045 4.69977 8.6846 4.81698 8.56739C4.93419 8.45018 5.00003 8.29121 5.00003 8.12545V3.12545C5.00011 3.01886 4.97293 2.91402 4.92106 2.8209C4.8692 2.72777 4.79438 2.64946 4.70372 2.59341C4.61306 2.53735 4.50957 2.50541 4.40309 2.50063C4.29661 2.49585 4.19067 2.51837 4.09535 2.56607L2.84535 3.19107C2.69699 3.26525 2.58418 3.39532 2.53173 3.55268C2.50576 3.63059 2.49539 3.71286 2.50121 3.79478C2.50703 3.8767 2.52893 3.95668 2.56566 4.03014C2.60239 4.10359 2.65323 4.1691 2.71527 4.22291C2.77732 4.27672 2.84935 4.31778 2.92727 4.34375C3.08462 4.39621 3.25637 4.384 3.40472 4.30982ZM6.23207 12.2442C6.1975 11.9967 6.11325 11.7587 5.98436 11.5445C5.85548 11.3304 5.68462 11.1445 5.48207 10.9981C5.07637 10.7035 4.57246 10.5772 4.07578 10.6457C3.5791 10.7141 3.12813 10.972 2.81722 11.3653C2.69839 11.5179 2.60428 11.6882 2.53832 11.87C2.50387 11.9482 2.48585 12.0327 2.48536 12.1182C2.48487 12.2037 2.50193 12.2884 2.53548 12.367C2.56903 12.4457 2.61835 12.5166 2.6804 12.5754C2.74245 12.6342 2.81591 12.6797 2.89623 12.709C2.97655 12.7382 3.06202 12.7507 3.14737 12.7457C3.23271 12.7406 3.31611 12.7181 3.3924 12.6795C3.4687 12.6409 3.53626 12.5871 3.59092 12.5214C3.64559 12.4556 3.68618 12.3794 3.71019 12.2973C3.73207 12.2374 3.76317 12.1812 3.80238 12.1309C3.91263 11.9935 4.0716 11.904 4.24622 11.8808C4.42084 11.8577 4.59766 11.9028 4.73988 12.0067C4.80829 12.0551 4.86615 12.1169 4.90993 12.1883C4.95372 12.2598 4.98251 12.3394 4.99457 12.4223C5.00559 12.502 5.00041 12.583 4.97933 12.6606C4.95826 12.7382 4.92172 12.8108 4.87191 12.8739C4.86963 12.8766 4.86755 12.8795 4.86566 12.8825L2.62425 15.8762C2.5548 15.9691 2.51257 16.0795 2.50229 16.1951C2.49202 16.3106 2.51411 16.4268 2.56608 16.5305C2.61806 16.6342 2.69787 16.7214 2.79659 16.7823C2.89531 16.8432 3.00903 16.8755 3.12503 16.8754H5.62503C5.7908 16.8754 5.94977 16.8096 6.06698 16.6924C6.18419 16.5752 6.25003 16.4162 6.25003 16.2504C6.25003 16.0847 6.18419 15.9257 6.06698 15.8085C5.94977 15.6913 5.7908 15.6254 5.62503 15.6254H4.37503L5.86566 13.6309C6.01679 13.4363 6.12713 13.2131 6.19008 12.9749C6.25304 12.7366 6.26731 12.4881 6.23207 12.2442Z" fill="#B6B6B6"/></svg>',
        'year' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M16.25 2.5H14.375V1.875C14.375 1.70924 14.3092 1.55027 14.1919 1.43306C14.0747 1.31585 13.9158 1.25 13.75 1.25C13.5842 1.25 13.4253 1.31585 13.3081 1.43306C13.1908 1.55027 13.125 1.70924 13.125 1.875V2.5H6.875V1.875C6.875 1.70924 6.80915 1.55027 6.69194 1.43306C6.57473 1.31585 6.41576 1.25 6.25 1.25C6.08424 1.25 5.92527 1.31585 5.80806 1.43306C5.69085 1.55027 5.625 1.70924 5.625 1.875V2.5H3.75C3.41848 2.5 3.10054 2.6317 2.86612 2.86612C2.6317 3.10054 2.5 3.41848 2.5 3.75V16.25C2.5 16.5815 2.6317 16.8995 2.86612 17.1339C3.10054 17.3683 3.41848 17.5 3.75 17.5H16.25C16.5815 17.5 16.8995 17.3683 17.1339 17.1339C17.3683 16.8995 17.5 16.5815 17.5 16.25V3.75C17.5 3.41848 17.3683 3.10054 17.1339 2.86612C16.8995 2.6317 16.5815 2.5 16.25 2.5ZM5.625 3.75V4.375C5.625 4.54076 5.69085 4.69973 5.80806 4.81694C5.92527 4.93415 6.08424 5 6.25 5C6.41576 5 6.57473 4.93415 6.69194 4.81694C6.80915 4.69973 6.875 4.54076 6.875 4.375V3.75H13.125V4.375C13.125 4.54076 13.1908 4.69973 13.3081 4.81694C13.4253 4.93415 13.5842 5 13.75 5C13.9158 5 14.0747 4.93415 14.1919 4.81694C14.3092 4.69973 14.375 4.54076 14.375 4.375V3.75H16.25V6.25H3.75V3.75H5.625ZM16.25 16.25H3.75V7.5H16.25V16.25ZM13.2547 9.55781C13.3128 9.61586 13.3589 9.68479 13.3904 9.76066C13.4218 9.83654 13.438 9.91787 13.438 10C13.438 10.0821 13.4218 10.1635 13.3904 10.2393C13.3589 10.3152 13.3128 10.3841 13.2547 10.4422L9.50469 14.1922C9.44664 14.2503 9.37771 14.2964 9.30184 14.3279C9.22596 14.3593 9.14463 14.3755 9.0625 14.3755C8.98037 14.3755 8.89904 14.3593 8.82316 14.3279C8.74729 14.2964 8.67836 14.2503 8.62031 14.1922L6.74531 12.3172C6.62804 12.1999 6.56215 12.0409 6.56215 11.875C6.56215 11.7091 6.62804 11.5501 6.74531 11.4328C6.86259 11.3155 7.02165 11.2497 7.1875 11.2497C7.35335 11.2497 7.51241 11.3155 7.62969 11.4328L9.0625 12.8664L12.3703 9.55781C12.4284 9.4997 12.4973 9.4536 12.5732 9.42215C12.649 9.3907 12.7304 9.37451 12.8125 9.37451C12.8946 9.37451 12.976 9.3907 13.0518 9.42215C13.1277 9.4536 13.1966 9.4997 13.2547 9.55781Z" fill="#B6B6B6"/></svg>',
        'city' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M18.75 16.25H18.125V6.875C18.125 6.70924 18.0592 6.55027 17.9419 6.43306C17.8247 6.31585 17.6658 6.25 17.5 6.25H12.5C12.3342 6.25 12.1753 6.31585 12.0581 6.43306C11.9408 6.55027 11.875 6.70924 11.875 6.875V10H8.125V3.125C8.125 2.95924 8.05915 2.80027 7.94194 2.68306C7.82473 2.56585 7.66576 2.5 7.5 2.5H2.5C2.33424 2.5 2.17527 2.56585 2.05806 2.68306C1.94085 2.80027 1.875 2.95924 1.875 3.125V16.25H1.25C1.08424 16.25 0.925268 16.3158 0.808058 16.4331C0.690848 16.5503 0.625 16.7092 0.625 16.875C0.625 17.0408 0.690848 17.1997 0.808058 17.3169C0.925268 17.4342 1.08424 17.5 1.25 17.5H18.75C18.9158 17.5 19.0747 17.4342 19.1919 17.3169C19.3092 17.1997 19.375 17.0408 19.375 16.875C19.375 16.7092 19.3092 16.5503 19.1919 16.4331C19.0747 16.3158 18.9158 16.25 18.75 16.25ZM13.125 7.5H16.875V16.25H13.125V7.5ZM11.875 11.25V16.25H8.125V11.25H11.875ZM3.125 3.75H6.875V16.25H3.125V3.75ZM5.625 5.625V6.875C5.625 7.04076 5.55915 7.19973 5.44194 7.31694C5.32473 7.43415 5.16576 7.5 5 7.5C4.83424 7.5 4.67527 7.43415 4.55806 7.31694C4.44085 7.19973 4.375 7.04076 4.375 6.875V5.625C4.375 5.45924 4.44085 5.30027 4.55806 5.18306C4.67527 5.06585 4.83424 5 5 5C5.16576 5 5.32473 5.06585 5.44194 5.18306C5.55915 5.30027 5.625 5.45924 5.625 5.625ZM5.625 9.375V10.625C5.625 10.7908 5.55915 10.9497 5.44194 11.0669C5.32473 11.1842 5.16576 11.25 5 11.25C4.83424 11.25 4.67527 11.1842 4.55806 11.0669C4.44085 10.9497 4.375 10.7908 4.375 10.625V9.375C4.375 9.20924 4.44085 9.05027 4.55806 8.93306C4.67527 8.81585 4.83424 8.75 5 8.75C5.16576 8.75 5.32473 8.81585 5.44194 8.93306C5.55915 9.05027 5.625 9.20924 5.625 9.375ZM5.625 13.125V14.375C5.625 14.5408 5.55915 14.6997 5.44194 14.8169C5.32473 14.9342 5.16576 15 5 15C4.83424 15 4.67527 14.9342 4.55806 14.8169C4.44085 14.6997 4.375 14.5408 4.375 14.375V13.125C4.375 12.9592 4.44085 12.8003 4.55806 12.6831C4.67527 12.5658 4.83424 12.5 5 12.5C5.16576 12.5 5.32473 12.5658 5.44194 12.6831C5.55915 12.8003 5.625 12.9592 5.625 13.125ZM9.375 14.375V13.125C9.375 12.9592 9.44085 12.8003 9.55806 12.6831C9.67527 12.5658 9.83424 12.5 10 12.5C10.1658 12.5 10.3247 12.5658 10.4419 12.6831C10.5592 12.8003 10.625 12.9592 10.625 13.125V14.375C10.625 14.5408 10.5592 14.6997 10.4419 14.8169C10.3247 14.9342 10.1658 15 10 15C9.83424 15 9.67527 14.9342 9.55806 14.8169C9.44085 14.6997 9.375 14.5408 9.375 14.375ZM14.375 14.375V13.125C14.375 12.9592 14.4408 12.8003 14.5581 12.6831C14.6753 12.5658 14.8342 12.5 15 12.5C15.1658 12.5 15.3247 12.5658 15.4419 12.6831C15.5592 12.8003 15.625 12.9592 15.625 13.125V14.375C15.625 14.5408 15.5592 14.6997 15.4419 14.8169C15.3247 14.9342 15.1658 15 15 15C14.8342 15 14.6753 14.9342 14.5581 14.8169C14.4408 14.6997 14.375 14.5408 14.375 14.375ZM14.375 10.625V9.375C14.375 9.20924 14.4408 9.05027 14.5581 8.93306C14.6753 8.81585 14.8342 8.75 15 8.75C15.1658 8.75 15.3247 8.81585 15.4419 8.93306C15.5592 9.05027 15.625 9.20924 15.625 9.375V10.625C15.625 10.7908 15.5592 10.9497 15.4419 11.0669C15.3247 11.1842 15.1658 11.25 15 11.25C14.8342 11.25 14.6753 11.1842 14.5581 11.0669C14.4408 10.9497 14.375 10.7908 14.375 10.625Z" fill="#B6B6B6"/></svg>',
        'map' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M7.5 5.62525V12.5003M12.5 7.50025V14.3753M12.9192 17.2903L16.9817 15.2594C17.2992 15.1011 17.5 14.7761 17.5 14.4211V4.01692C17.5 3.32025 16.7667 2.86692 16.1433 3.17859L12.9192 4.79025C12.655 4.92275 12.3442 4.92275 12.0808 4.79025L7.91917 2.71025C7.78901 2.6452 7.64551 2.61133 7.5 2.61133C7.35449 2.61133 7.21098 2.6452 7.08083 2.71025L3.01833 4.74109C2.7 4.90025 2.5 5.22525 2.5 5.57942V15.9836C2.5 16.6803 3.23333 17.1336 3.85667 16.8219L7.08083 15.2103C7.345 15.0778 7.65583 15.0778 7.91917 15.2103L12.0808 17.2911C12.345 17.4228 12.6558 17.4228 12.9192 17.2911V17.2903Z" stroke="#B6B6B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'verify' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none"><path d="M6 9.00024L7.5 10.5002L10 7.00024M8 2.30957C6.49049 3.74306 4.48018 4.52929 2.39867 4.50024C2.13389 5.30689 1.99932 6.15057 2 6.99957C2 10.7276 4.54934 13.8596 8 14.7482C11.4507 13.8602 14 10.7282 14 7.00024C14 6.1269 13.86 5.28624 13.6013 4.49957H13.5C11.3693 4.49957 9.43334 3.66757 8 2.30957Z" stroke="#7ED321" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'filter' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M8.75 5H16.875M8.75 5C8.75 5.33152 8.6183 5.64946 8.38388 5.88388C8.14946 6.1183 7.83152 6.25 7.5 6.25C7.16848 6.25 6.85054 6.1183 6.61612 5.88388C6.3817 5.64946 6.25 5.33152 6.25 5M8.75 5C8.75 4.66848 8.6183 4.35054 8.38388 4.11612C8.14946 3.8817 7.83152 3.75 7.5 3.75C7.16848 3.75 6.85054 3.8817 6.61612 4.11612C6.3817 4.35054 6.25 4.66848 6.25 5M6.25 5H3.125M8.75 15H16.875M8.75 15C8.75 15.3315 8.6183 15.6495 8.38388 15.8839C8.14946 16.1183 7.83152 16.25 7.5 16.25C7.16848 16.25 6.85054 16.1183 6.61612 15.8839C6.3817 15.6495 6.25 15.3315 6.25 15M8.75 15C8.75 14.6685 8.6183 14.3505 8.38388 14.1161C8.14946 13.8817 7.83152 13.75 7.5 13.75C7.16848 13.75 6.85054 13.8817 6.61612 14.1161C6.3817 14.3505 6.25 14.6685 6.25 15M6.25 15H3.125M13.75 10H16.875M13.75 10C13.75 10.3315 13.6183 10.6495 13.3839 10.8839C13.1495 11.1183 12.8315 11.25 12.5 11.25C12.1685 11.25 11.8505 11.1183 11.6161 10.8839C11.3817 10.6495 11.25 10.3315 11.25 10M13.75 10C13.75 9.66848 13.6183 9.35054 13.3839 9.11612C13.1495 8.8817 12.8315 8.75 12.5 8.75C12.1685 8.75 11.8505 8.8817 11.6161 9.11612C11.3817 9.35054 11.25 9.66848 11.25 10M11.25 10H3.125" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'location' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 7C10 7.53043 9.78929 8.03914 9.41421 8.41421C9.03914 8.78929 8.53043 9 8 9C7.46957 9 6.96086 8.78929 6.58579 8.41421C6.21071 8.03914 6 7.53043 6 7C6 6.46957 6.21071 5.96086 6.58579 5.58579C6.96086 5.21071 7.46957 5 8 5C8.53043 5 9.03914 5.21071 9.41421 5.58579C9.78929 5.96086 10 6.46957 10 7Z" stroke="#B6B6B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 7C13 11.7613 8 14.5 8 14.5C8 14.5 3 11.7613 3 7C3 5.67392 3.52678 4.40215 4.46447 3.46447C5.40215 2.52678 6.67392 2 8 2C9.32608 2 10.5979 2.52678 11.5355 3.46447C12.4732 4.40215 13 5.67392 13 7Z" stroke="#B6B6B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'date-dash' => '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none"><path d="M5.5625 2.25V3.9375M13.4375 2.25V3.9375M2.75 14.0625V5.625C2.75 5.17745 2.92779 4.74823 3.24426 4.43176C3.56072 4.11529 3.98995 3.9375 4.4375 3.9375H14.5625C15.0101 3.9375 15.4393 4.11529 15.7557 4.43176C16.0722 4.74823 16.25 5.17745 16.25 5.625V14.0625M2.75 14.0625C2.75 14.5101 2.92779 14.9393 3.24426 15.2557C3.56072 15.5722 3.98995 15.75 4.4375 15.75H14.5625C15.0101 15.75 15.4393 15.5722 15.7557 15.2557C16.0722 14.9393 16.25 14.5101 16.25 14.0625M2.75 14.0625V8.4375C2.75 7.98995 2.92779 7.56073 3.24426 7.24426C3.56072 6.92779 3.98995 6.75 4.4375 6.75H14.5625C15.0101 6.75 15.4393 6.92779 15.7557 7.24426C16.0722 7.56073 16.25 7.98995 16.25 8.4375V14.0625M9.5 9.5625H9.506V9.5685H9.5V9.5625ZM9.5 11.25H9.506V11.256H9.5V11.25ZM9.5 12.9375H9.506V12.9435H9.5V12.9375ZM7.8125 11.25H7.8185V11.256H7.8125V11.25ZM7.8125 12.9375H7.8185V12.9435H7.8125V12.9375ZM6.125 11.25H6.131V11.256H6.125V11.25ZM6.125 12.9375H6.131V12.9435H6.125V12.9375ZM11.1875 9.5625H11.1935V9.5685H11.1875V9.5625ZM11.1875 11.25H11.1935V11.256H11.1875V11.25ZM11.1875 12.9375H11.1935V12.9435H11.1875V12.9375ZM12.875 9.5625H12.881V9.5685H12.875V9.5625ZM12.875 11.25H12.881V11.256H12.875V11.25Z" stroke="#B6B6B6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'search-dash' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M15.7506 15.7506L11.8528 11.8528M11.8528 11.8528C12.9078 10.7979 13.5004 9.36711 13.5004 7.87521C13.5004 6.38331 12.9078 4.95252 11.8528 3.89759C10.7979 2.84265 9.36711 2.25 7.87521 2.25C6.38331 2.25 4.95252 2.84265 3.89759 3.89759C2.84265 4.95252 2.25 6.38331 2.25 7.87521C2.25 9.36711 2.84265 10.7979 3.89759 11.8528C4.95252 12.9078 6.38331 13.5004 7.87521 13.5004C9.36711 13.5004 10.7979 12.9078 11.8528 11.8528Z" stroke="#B6B6B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'pen' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M11.2413 2.9915L12.366 1.86616C12.6005 1.63171 12.9184 1.5 13.25 1.5C13.5816 1.5 13.8995 1.63171 14.134 1.86616C14.3685 2.10062 14.5002 2.4186 14.5002 2.75016C14.5002 3.08173 14.3685 3.39971 14.134 3.63416L4.55467 13.2135C4.20222 13.5657 3.76758 13.8246 3.29 13.9668L1.5 14.5002L2.03333 12.7102C2.17552 12.2326 2.43442 11.7979 2.78667 11.4455L11.242 2.9915H11.2413ZM11.2413 2.9915L13 4.75016" stroke="#B6B6B6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'sold' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M12.2427 12.2427C13.3679 11.1175 14.0001 9.59135 14.0001 8.00004C14.0001 6.40873 13.3679 4.8826 12.2427 3.75737C11.1175 2.63214 9.59135 2 8.00004 2C6.40873 2 4.8826 2.63214 3.75737 3.75737M12.2427 12.2427C11.1175 13.3679 9.59135 14.0001 8.00004 14.0001C6.40873 14.0001 4.8826 13.3679 3.75737 12.2427C2.63214 11.1175 2 9.59135 2 8.00004C2 6.40873 2.63214 4.8826 3.75737 3.75737M12.2427 12.2427L3.75737 3.75737" stroke="#B6B6B6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'trash' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M9.82667 6.00035L9.596 12.0003M6.404 12.0003L6.17333 6.00035M12.8187 3.86035C13.0467 3.89501 13.2733 3.93168 13.5 3.97101M12.8187 3.86035L12.1067 13.1157C12.0776 13.4925 11.9074 13.8445 11.63 14.1012C11.3527 14.3579 10.9886 14.5005 10.6107 14.5003H5.38933C5.0114 14.5005 4.64735 14.3579 4.36999 14.1012C4.09262 13.8445 3.92239 13.4925 3.89333 13.1157L3.18133 3.86035M12.8187 3.86035C12.0492 3.74403 11.2758 3.65574 10.5 3.59568M3.18133 3.86035C2.95333 3.89435 2.72667 3.93101 2.5 3.97035M3.18133 3.86035C3.95076 3.74403 4.72416 3.65575 5.5 3.59568M10.5 3.59568V2.98501C10.5 2.19835 9.89333 1.54235 9.10667 1.51768C8.36908 1.49411 7.63092 1.49411 6.89333 1.51768C6.10667 1.54235 5.5 2.19901 5.5 2.98501V3.59568M10.5 3.59568C8.83581 3.46707 7.16419 3.46707 5.5 3.59568" stroke="#B6B6B6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'upload' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><path d="M15.0003 20.6243V12.1868M15.0003 12.1868L18.7503 15.9368M15.0003 12.1868L11.2503 15.9368M8.43776 24.3743C7.09955 24.3757 5.80466 23.9001 4.78563 23.0327C3.7666 22.1652 3.0902 20.963 2.87789 19.6417C2.66559 18.3204 2.93129 16.9668 3.62728 15.8238C4.32327 14.6808 5.40396 13.8234 6.67526 13.4055C6.34863 11.732 6.6862 9.99704 7.61649 8.56806C8.54677 7.13908 9.99671 6.12829 11.6593 5.74973C13.3218 5.37118 15.0665 5.65458 16.5237 6.53994C17.981 7.42529 19.0364 8.84307 19.4665 10.493C20.1315 10.2768 20.8438 10.2507 21.5228 10.4179C22.2018 10.5851 22.8206 10.9388 23.3091 11.4391C23.7977 11.9394 24.1367 12.5663 24.2878 13.2491C24.4388 13.9319 24.396 14.6433 24.164 15.303C25.1873 15.6939 26.0415 16.4307 26.5785 17.3855C27.1154 18.3403 27.3012 19.4529 27.1035 20.5304C26.9059 21.6078 26.3374 22.5821 25.4966 23.2842C24.6558 23.9864 23.5957 24.372 22.5003 24.3743H8.43776Z" stroke="var(--theme-primary-color)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'searchx' => '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="80" height="80" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m226 251.591 30 30 30 30M286 251.591l-30 30-30 30M375.91 56.591H20c-5.52 0-10 4.47-10 10v350c0 5.52 4.48 10 10 10h64.22" style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M415.915 66.591c12.869 0 12.89-20 0-20-12.869 0-12.89 20 0 20z" fill="var(--theme-primary-color)" opacity="1" data-original="#000000" class=""></path><path d="M139.28 426.591H492c5.52 0 10-4.48 10-10v-350c0-5.53-4.48-10-10-10h-36.085" style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="m197.24 368.631-80.92 80.92c-7.81 7.81-20.48 7.81-28.29 0s-7.81-20.47 0-28.28l80.93-80.93" style="stroke-width:20;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M90 96.589h94.889" style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M10 136.589h492" style="stroke-width:20;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></path><path d="M50 106.589c12.869 0 12.89-20 0-20-12.869 0-12.89 20 0 20z" fill="var(--theme-primary-color)" opacity="1" data-original="#000000" class=""></path><circle cx="256" cy="281.589" r="105" style="stroke-width:20;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="var(--theme-primary-color)" stroke-width="20" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="" opacity="1"></circle></g></svg>',
        'card' => '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="17" viewBox="0 0 8 17" fill="none"><rect x="0.75" y="0.75" width="6.5" height="6.5" rx="3.25" stroke="black" stroke-width="1"/><rect x="0.75" y="9.75" width="6.5" height="6.5" rx="3.25" stroke="black" stroke-width="1"/></svg>',
    );

    if ( array_key_exists( $icon, $svg) ) {
        return $svg[$icon];
    } else {
        return null;
    }
}

?>