<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Admin_Custom_Post_Type' ) ) {
	class Admin_Custom_Post_Type {
		/**
		 * Define list custom post type
		 */
		function tfcl_get_list_custom_post_type() {
			$custom_post_types = array();
			$package_enable = tfcl_get_option( 'enable_package') == 'n' ? false : true;

			$custom_url_listings = tfcl_get_option( 'custom_url_listings', 'listing' );
			$custom_url_dealer = tfcl_get_option( 'custom_url_dealer', 'dealer' );
			$custom_url_package = tfcl_get_option( 'custom_url_package', 'package' );
			$custom_url_invoice = tfcl_get_option( 'custom_url_invoice', 'invoice' );
			$custom_url_user_package = tfcl_get_option( 'custom_url_user_package', 'user-package' );
			$custom_url_transaction_log = tfcl_get_option( 'custom_url_transaction_log', 'transaction-log' );

			$custom_post_types['listing'] = array(
				'name'                => __( 'Listings', 'tf-car-listing' ),
				'singular_name'       => __( 'Listing', 'tf-car-listing' ),
				'description'         => __( 'Holds our custom article post specific data', 'tf-car-listing' ),
				'public'              => true,
				'publicly_queryable'  => true,
				'slug_post_type'  	  => $custom_url_listings,
				'menu_position'       => 2,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'query_var'           => true,
				'menu_icon'           => 'dashicons-car',
				'can_export'          => true,
				'map_meta_cap'        => true,
				'supports'            => array(),
				'exclude_from_search' => false,
				'capability_type'     => array( 'listing', 'listings' ),
				'capabilities'        => array(),
			);


			$custom_post_types['dealer'] = array(
				'name'                => __( 'Dealers', 'tf-car-listing' ),
				'singular_name'       => __( 'Dealer', 'tf-car-listing' ),
				'description'         => __( 'Holds our custom article post specific data', 'tf-car-listing' ),
				'public'              => true,
				'publicly_queryable'  => true,
				'slug_post_type'  	  => $custom_url_dealer,
				'menu_position'       => 3,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'map_meta_cap'        => true,
				'query_var'           => true,
				'menu_icon'           => 'dashicons-businessperson',
				'can_export'          => true,
				'supports'            => array(),
				'exclude_from_search' => false,
				'capability_type'     => array( 'dealer', 'dealers' ),
				'capabilities'        => array(
					'create_posts'       => 'do_not_allow',
					'read_post'          => 'read_dealer',
					'edit_post'          => 'edit_dealer',
					'edit_posts'         => 'edit_dealers',
					'publish_posts'      => 'publish_dealers',
					'edit_publish_posts' => 'edit_publish_dealers',
					'delete_post'        => 'delete_dealer'
				),
			);

			$custom_post_types['package'] = array(
				'name'                => __( 'Package', 'tf-car-listing' ),
				'singular_name'       => __( 'Package', 'tf-car-listing' ),
				'description'         => __( 'Holds our custom article post specific data', 'tf-car-listing' ),
				'public'              => true,
				'publicly_queryable'  => false,
				'slug_post_type'  	  => $custom_url_package,
				'menu_position'       => 3,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => $package_enable,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'map_meta_cap'        => true,
				'query_var'           => false,
				'menu_icon'           => 'dashicons-archive',
				'can_export'          => true,
				'capability_type'     => array( 'package', 'packages' ),
				'capabilities'        => array(),
				'supports'            => array(),
				'exclude_from_search' => false,
			);

			$custom_post_types['invoice'] = array(
				'name'                => __( 'Invoice', 'tf-car-listing' ),
				'singular_name'       => __( 'Invoice', 'tf-car-listing' ),
				'description'         => __( 'Holds our custom article post specific data', 'tf-car-listing' ),
				'public'              => true,
				'publicly_queryable'  => false,
				'slug_post_type'  	  => $custom_url_invoice,
				'menu_position'       => 4,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => $package_enable,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'map_meta_cap'        => true,
				'query_var'           => false,
				'menu_icon'           => 'dashicons-text-page',
				'can_export'          => true,
				'capability_type'     => array( 'invoice', 'invoices' ),
				'capabilities'        => array(
					'create_posts' => 'do_not_allow',
					'edit_post'    => 'edit_invoices',
					'delete_posts' => 'delete_invoices'
				),
				'supports'            => array( 'title', 'excerpt' ),
				'exclude_from_search' => true,
			);

			$custom_post_types['user-package'] = array(
				'name'                => __( 'User Packages', 'tf-car-listing' ),
				'singular_name'       => __( 'User Package', 'tf-car-listing' ),
				'description'         => __( 'Holds our custom article post specific data', 'tf-car-listing' ),
				'public'              => true,
				'publicly_queryable'  => false,
				'slug_post_type'  	  => $custom_url_user_package,
				'menu_position'       => 5,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => $package_enable,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'map_meta_cap'        => true,
				'query_var'           => false,
				'menu_icon'           => 'dashicons-id-alt',
				'can_export'          => true,
				'capability_type'     => array( 'user-package', 'user-packages' ),
				'capabilities'        => array(
					'create_posts' => 'do_not_allow',
					'edit_post'    => 'edit_user-packages',
					'delete_posts' => 'delete_user-packages'
				),
				'supports'            => array( 'title', 'excerpt' ),
				'exclude_from_search' => true,
			);

			$custom_post_types['transaction-log'] = array(
				'name'                => __( 'Transaction Log', 'tf-car-listing' ),
				'singular_name'       => __( 'Transaction Log', 'tf-car-listing' ),
				'description'         => __( 'Holds our custom article post specific data', 'tf-car-listing' ),
				'public'              => true,
				'publicly_queryable'  => false,
				'slug_post_type'  	  => $custom_url_transaction_log,
				'menu_position'       => 6,
				'has_archive'         => true,
				'hierarchical'        => true,
				'show_ui'             => $package_enable,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'map_meta_cap'        => true,
				'query_var'           => false,
				'menu_icon'           => 'dashicons-feedback',
				'can_export'          => true,
				'capability_type'     => array( 'transaction-log', 'transaction-logs' ),
				'capabilities'        => array(
					'create_posts' => 'do_not_allow',
					'edit_post'    => 'edit_transaction-logs',
					'delete_posts' => 'delete_transaction-logs'
				),
				'supports'            => array( 'title', 'excerpt' ),
				'exclude_from_search' => true,
			);

			return $custom_post_types;
		}

		/**
		 * Register custom post type
		 */
		function tfcl_register_custom_post_type() {
			$list_custom_post_type = $this->tfcl_get_list_custom_post_type();

			foreach ( $list_custom_post_type as $post_type => $value ) {
				$post_type_name = $value['name'];

				$default_args = array(
					'labels'              => array(
						'name'               => sprintf( esc_html( '%s', 'tf-car-listing' ), $post_type_name ),
						'singular_name'      => sprintf( esc_html( '%s', 'tf-car-listing' ), $value['singular_name'] ),
						'add_new'            => sprintf( esc_html( 'Add New %s', 'tf-car-listing' ), $value['singular_name'] ),
						'add_new_item'       => sprintf( esc_html( 'Add New %s', 'tf-car-listing' ), $value['singular_name'] ),
						'edit_item'          => sprintf( esc_html( 'Edit %s', 'tf-car-listing' ), $value['singular_name'] ),
						'new_item'           => sprintf( esc_html( 'New %s', 'tf-car-listing' ), $value['singular_name'] ),
						'all_items'          => sprintf( esc_html( 'All %s', 'tf-car-listing' ), $value['singular_name'] ),
						'view_item'          => sprintf( esc_html( 'View %s', 'tf-car-listing' ), $value['singular_name'] ),
						'search_items'       => sprintf( esc_html( 'Search %s', 'tf-car-listing' ), $value['singular_name'] ),
						'featured_image'     => esc_html( 'Poster', 'tf-car-listing' ),
						'set_featured_image' => esc_html( 'Add Poster', 'tf-car-listing' )
					),
					'description'         => $value['description'],
					'public'              => $value['public'],
					'publicly_queryable'  => $value['publicly_queryable'],
					'menu_position'       => $value['menu_position'],
					'rewrite'             => array( 'slug' => $value['slug_post_type'] ),
					'supports'            => count( $value['supports'] ) > 0 ? $value['supports'] : array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'author', 'trackbacks' ),
					'has_archive'         => $value['has_archive'],
					'hierarchical'        => $value['hierarchical'],
					'show_ui'             => $value['show_ui'],
					'show_in_menu'        => $value['show_in_menu'],
					'show_in_admin_bar'   => $value['show_in_admin_bar'],
					'show_in_nav_menus'   => $value['show_in_nav_menus'],
					'query_var'           => $value['query_var'],
					'menu_icon'           => $value['menu_icon'],
					'can_export'          => $value['can_export'],
					'exclude_from_search' => $value['exclude_from_search'],
				);

				if ( count( $value['capabilities'] ) > 0 ) {
					$default_args['capability_type'] = $value['capability_type'];
					$default_args['capabilities']    = $value['capabilities'];
				}

				register_post_type( $post_type, $default_args );
			}
		}
	}
}