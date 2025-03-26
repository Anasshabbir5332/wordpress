<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Admin_Meta_Box' ) ) {
	class Admin_Meta_Box {
		public function __construct() {
		}

		public function tfcl_get_meta_box_config_list( $post_type ) {
			$options        = array();
			$list_dealer    = array();
			$get_all_dealer = Dealer_Public::tfcl_get_list_dealer(true)['data'];

			foreach ( $get_all_dealer as $key => $value ) {
				$list_dealer[ $value['ID'] ] = $value['title'];
			}

			switch ( $post_type ) {
				case 'listing':
					// Detail
					$options['listing_detail_heading'] = array(
						'type'    => 'heading',
						'section' => 'listing-detail',
						'title'   => esc_html__( 'Listing Detail', 'tf-car-listing' ),
					);
					$options['car_featured'] = array(
						'type'    => 'toggle',
						'title'   => esc_html__( 'Mark this car as featured ?', 'tf-car-listing' ),
						'section' => 'listing-detail',
						'default' => false
					);
					$options['car_status'] = array(
						'type'    => 'toggle',
						'title'   => esc_html__( 'Enable Car Status ?', 'tf-car-listing' ),
						'section' => 'listing-detail',
						'children' => array(
							'car_status_text',
						),
						'default' => false
					);
					$options['car_status_text'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Car Status Text', 'tf-car-listing' ),
						'section'     => 'listing-detail',
						'placeholder' => 'Ex: new, old, sold ...etc',
					);
					$options['stock_number'] = array(
						'type'        => 'text',
						'title'       => esc_html__( get_option('custom_name_stock_number') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['vin_number'] = array(
						'type'        => 'text',
						'title'       => esc_html__( get_option('custom_name_vin_number') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['city_mpg'] = array(
						'type'        => 'number',
						'title'       => esc_html__( get_option('custom_name_city_mpg') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['highway_mpg'] = array(
						'type'        => 'number',
						'title'       => esc_html__( get_option('custom_name_highway_mpg') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['year'] = array(
						'type'        => 'number',
						'title'       => esc_html__( get_option('custom_name_year') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['door'] = array(
						'type'        => 'number',
						'title'       => esc_html__( get_option('custom_name_door') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['seat'] = array(
						'type'        => 'number',
						'title'       => esc_html__( get_option('custom_name_seat') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['mileage'] = array(
						'type'        => 'number',
						'title'       => esc_html__( get_option('custom_name_mileage') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['engine_size'] = array(
						'type'        => 'text',
						'title'       => esc_html__( get_option('custom_name_engine_size') ),
						'section'     => 'listing-detail',
						'placeholder' => '',
					);
					$options['listing_additional_detail'] = array(
						'type'                      => 'panel-dynamic',
						'title'                     => esc_html__( 'Additional detail', 'tf-car-listing' ),
						'section'                   => 'listing-detail',
						'children-dynamic-controls' => array(
							'additional_detail_icon' => array(
								'type'    => 'single-image-control',
								'title'       => esc_html__( 'Icon', 'tf-car-listing' ),
								'section'     => 'listing_additional_detail',
								'placeholder' => '',
							),
							'additional_detail_title' => array(
								'type'        => 'text',
								'title'       => esc_html__( 'Title', 'tf-car-listing' ),
								'section'     => 'listing_additional_detail',
								'placeholder' => '',
							),
							'additional_detail_value' => array(
								'type'        => 'text',
								'title'       => esc_html__( 'Value', 'tf-car-listing' ),
								'section'     => 'listing_additional_detail',
								'placeholder' => '',
							),
						)
					);
					// Additional Custom Fields
					$configs = tfcl_get_additional_fields();
					foreach ( $configs as $key => $config ) {
						$options[ $key ] = $config;
					}
					// Price
					$options['price_heading'] = array(
						'type'    => 'heading',
						'section' => 'price',
						'title'   => esc_html__( 'Price', 'tf-car-listing' ),
					);
					$options['regular_price'] = array(
						'type'        => 'number',
						'title'       => esc_html__( 'Regular Price', 'tf-car-listing' ),
						'section'     => 'price',
						'placeholder' => '',
					);
					$options['sale_price'] = array(
						'type'        => 'number',
						'title'       => esc_html__( 'Sale Price', 'tf-car-listing' ),
						'section'     => 'price',
						'placeholder' => '',
					);
					$options['price_prefix'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Price Prefix', 'tf-car-listing' ),
						'section'     => 'price',
						'placeholder' => '',
					);
					$options['price_suffix'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Price Suffix', 'tf-car-listing' ),
						'section'     => 'price',
						'placeholder' => '',
					);
					$options['price_custom_label'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Price Custom Label', 'tf-car-listing' ),
						'section'     => 'price',
						'placeholder' => '',
					);
					$options['listing_price_unit'] = array(
						'type'    => 'radio',
						'title'   => esc_html__( 'Price Unit', 'tf-car-listing' ),
						'section'     => 'price',
						'default' => '1',
						'choices' => array(
							'1'          => array(
								'label'    => esc_html__( 'None', 'tf-car-listing' ),
								'children' => array(),
							),
							'1000'       => array(
								'label'    => esc_html__( 'Thousand', 'tf-car-listing' ),
								'children' => array(),
							),
							'1000000'    => array(
								'label'    => esc_html__( 'Million', 'tf-car-listing' ),
								'children' => array(),
							),
							'1000000000' => array(
								'label'    => esc_html__( 'Billion', 'tf-car-listing' ),
								'children' => array(),
							),
						),
					);
					//Location
					$options['location_heading'] = array(
						'type'    => 'heading',
						'section' => 'location',
						'title'   => esc_html__( 'Location', 'tf-car-listing' ),
					);
					$options['listing_address'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Address', 'tf-car-listing' ),
						'section'     => 'location',
						'placeholder' => '',
					);
					$options['listing_location'] = array(
						'type'        => 'map',
						'title'       => esc_html__( 'Location at Map', 'tf-car-listing' ),
						'section'     => 'location',
						'placeholder' => esc_html__( 'map location', 'tf-car-listing' ),
					);
					// Gallery
					$options['gallery_image_heading'] = array(
						'type'    => 'heading',
						'section' => 'gallery-image',
						'title'   => esc_html__( 'Gallery Image', 'tf-car-listing' ),
					);
					$options['gallery_image_types'] = array(
						'type'    => 'radio',
						'title'   => esc_html__( 'Gallery Image Type', 'tf-car-listing' ),
						'section' => 'gallery-image',
						'default' => '',
						'choices' => array(
							'gallery-style-grid'     => array(
								'label' => esc_html__( 'Grid', 'tf-car-listing' ),
							),
							'gallery-style-slider'   => array(
								'label' => esc_html__( 'Slider (Style 1)', 'tf-car-listing' ),
							),
							'gallery-style-slider-2' => array(
								'label' => esc_html__( 'Slider (Style 2)', 'tf-car-listing' ),
							),
							'gallery-style-slider-3' => array(
								'label' => esc_html__( 'Slider (Style 3)', 'tf-car-listing' ),
							),
						),
					);
					$options['gallery_images'] = array(
						'type'    => 'image-control',
						'section' => 'gallery-image',
						'title'   => esc_html__( 'Image List', 'tf-car-listing' ),
						'default' => ''
					);
					// Attachment
					$options['attachment_file_heading'] = array(
						'type'    => 'heading',
						'section' => 'attachments-file',
						'title'   => esc_html__( 'Attachments File', 'tf-car-listing' ),
					);
					$options['text_brochures'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Text Attachments File', 'tf-car-listing' ),
						'section' => 'attachments-file',
						'placeholder' => '',
					);
					$options['attachments_file'] = array(
						'type'    => 'attachments-control',
						'section' => 'attachments-file',
						'title'   => esc_html__( 'Attachments List', 'tf-car-listing' ),
						'default' => ''
					);
					// Video
					$options['listing_video_heading'] = array(
						'type'    => 'heading',
						'section' => 'listing-video',
						'title'   => esc_html__( 'Listing Video', 'tf-car-listing' ),
					);
					$options['video_url'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Video URL', 'tf-car-listing' ),
						'section'     => 'listing-video',
						'placeholder' => esc_html__( 'Input only URL. YouTube, Vimeo', 'tf-car-listing' ),
					);
					// Create By
					$options['create_by_heading'] = array(
						'type'    => 'heading',
						'section' => 'create-by',
						'title'   => esc_html__( 'Create By', 'tf-car-listing' ),
					);

					$options['create_information_options'] = array(
						'type'    => 'radio',
						'title'   => esc_html__( 'Choose one option to display dealer information:', 'tf-car-listing' ),
						'section' => 'create-by',
						'default' => 'dealer_info',
						'choices' => array(
							'dealer_info' => array(
								'label'    => esc_html__( 'Dealer', 'tf-car-listing' ),
								'children' => array( 'listing_dealer_info'),
							),
						),
					);

					$options['listing_dealer_info'] = array(
						'type'    => 'select',
						'section' => 'create-by',
						'title'   => esc_html__( 'Dealer', 'tf-car-listing' ),
						'choices' => $list_dealer,
					);

					break;

				case 'dealer':
					// Basic Information
					$options['basic_info_heading'] = array(
						'type'    => 'heading',
						'section' => 'basic-information',
						'title'   => esc_html__( 'Basic Information', 'tf-car-listing' )
					);
					$options['dealer_email'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Email', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Email', 'tf-car-listing' ),
					);

					$options['dealer_phone_number'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Phone Number', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Phone Number', 'tf-car-listing' ),
					);

					$options['dealer_sales_phone'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Sales Phone', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Sales Phone', 'tf-car-listing' ),
					);

					$options['dealer_sales_hour'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Business Hour', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Business Hour', 'tf-car-listing' ),
					);

					$options['dealer_fax_number'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Fax Number', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Fax Number', 'tf-car-listing' ),
					);

					$options['dealer_company_name'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Company Name', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Company Name', 'tf-car-listing' ),
					);

					$options['dealer_office_address'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Office Address', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Office Address', 'tf-car-listing' ),
					);

					$options['dealer_position'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Position', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Position', 'tf-car-listing' ),
					);

					$options['dealer_des_info'] = array(
						'type'    => 'textarea',
						'title'   => esc_html__( 'Description', 'tf-car-listing' ),
						'section' => 'basic-information',
					);

					$options['dealer_website'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Website', 'tf-car-listing' ),
						'section'     => 'basic-information',
						'placeholder' => esc_html__( 'Enter your website url', 'tf-car-listing' ),
					);

					$options['dealer_logo'] = array(
						'type'    => 'image-control',
						'title'   => esc_html__( 'Logo', 'tf-car-listing' ),
						'section' => 'basic-information',
					);

					// Social information

					$options['dealer_facebook'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Facebook', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Facebook', 'tf-car-listing' ),
					);

					$options['dealer_twitter'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Twitter', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Twitter', 'tf-car-listing' ),
					);

					$options['dealer_instagram'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Instagram', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Instagram', 'tf-car-listing' ),
					);

					$options['dealer_pinterest'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Pinterest', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Pinterest', 'tf-car-listing' ),
					);

					$options['dealer_linkedin'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'LinkedIn', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'LinkedIn', 'tf-car-listing' ),
					);

					$options['dealer_vimeo'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Vimeo', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Vimeo', 'tf-car-listing' ),
					);

					$options['dealer_youtube'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Youtube', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Youtube', 'tf-car-listing' ),
					);

					$options['dealer_tiktok'] = array(
						'type'        => 'text',
						'title'       => esc_html__( 'Tiktok', 'tf-car-listing' ),
						'section'     => 'social-infomation',
						'placeholder' => esc_html__( 'Tiktok', 'tf-car-listing' ),
					);

					break;
				case 'package':
					$options['package_free'] = array(
						'type'      => 'toggle',
						'title'     => esc_html__( 'Is Free Package ?', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'default'   => 0,
						'children'  => array( 'package_price' ),
						'row_index' => 0
					);
					$options['package_price'] = array(
						'type'      => 'text',
						'title'     => esc_html__( 'Package Price', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'row_index' => 0
					);
					$options['package_unlimited_listing'] = array(
						'type'      => 'toggle',
						'title'     => esc_html__( 'Is Unlimited Listing?', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'default'   => 0,
						'children'  => array( 'package_number_listing' ),
						'row_index' => 1
					);
					$options['package_number_listing'] = array(
						'type'      => 'text',
						'title'     => esc_html__( 'Number Listing', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'row_index' => 1,
					);
					$options['package_unlimited_time'] = array(
						'type'      => 'toggle',
						'title'     => esc_html__( 'Is Unlimited Time', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'default'   => 0,
						'children'  => array( 'package_time_unit', 'package_number_time_unit' ),
						'row_index' => 2
					);
					$options['package_time_unit'] = array(
						'type'      => 'radio',
						'title'     => esc_html__( 'Time Unit', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'default'   => 'month',
						'choices'   => array(
							'day'   => array(
								'label' => esc_html__( 'Day', 'tf-car-listing' ),
							),
							'week'  => array(
								'label' => esc_html__( 'Week', 'tf-car-listing' ),
							),
							'month' => array(
								'label' => esc_html__( 'Month', 'tf-car-listing' ),
							),
							'year'  => array(
								'label' => esc_html__( 'Year', 'tf-car-listing' ),
							),
						),
						'row_index' => 2
					);
					$options['package_number_time_unit'] = array(
						'type'      => 'text',
						'title'     => esc_html__( 'Number Of Time Unit', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'row_index' => 2
					);
					$options['package_popular'] = array(
						'type'      => 'toggle',
						'title'     => esc_html__( 'Is Popular Package ?', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'default'   => 0,
						'row_index' => 3
					);
					$options['package_visible'] = array(
						'type'      => 'toggle',
						'title'     => esc_html__( 'Hidden Package', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'default'   => 0,
						'row_index' => 3
					);
					$options['package_order_display'] = array(
						'type'      => 'text',
						'title'     => esc_html__( 'Order Display', 'tf-car-listing' ),
						'section'   => 'package-detail',
						'row_index' => 3
					);
					break;
				default:
					break;
			}

			return $options;
		}

		public function tfcl_register_meta_boxes() {
			$listing_management_sections = array(
				'listing-detail'   => array( 'title' => esc_html__( 'Listing Detail', 'tf-car-listing' ) ),
				'price'            => array( 'title' => esc_html__( 'Price', 'tf-car-listing' ) ),
				'location'         => array( 'title' => esc_html__( 'Location', 'tf-car-listing' ) ),
				'gallery-image'    => array( 'title' => esc_html__( 'Gallery', 'tf-car-listing' ) ),
				'attachments-file' => array( 'title' => esc_html__( 'Attachments File', 'tf-car-listing' ) ),
				'listing-video'    => array( 'title' => esc_html__( 'Listing Video', 'tf-car-listing' ) ),
				'create-by'        => array( 'title' => esc_html__( 'Create by', 'tf-car-listing' ) )
			);
			$get_additional_fields       = tfcl_get_additional_fields();
			new Meta_Box_Control(
				array(
					'id'         => 'listing-management',
					'label'      => esc_html__( 'Listing Management ', 'tf-car-listing' ),
					'post_types' => 'listing',
					'context'    => 'normal',
					'priority'   => 'high',
					'sections'   => count( $get_additional_fields ) > 0 ? array_merge( array_slice( $listing_management_sections, 0, 1 ), array( 'additional-custom-fields' => array( 'title' => esc_html( 'Additional Custom Fields', 'tf-car-listing' ) ) ), array_slice( $listing_management_sections, 1 ) ) : $listing_management_sections,
					'options'    => $this->tfcl_get_meta_box_config_list( 'listing' )
				)
			);

			new Meta_Box_Control(
				array(
					'id'         => 'dealer-infomation',
					'label'      => esc_html__( 'Dealer Information ', 'tf-car-listing' ),
					'post_types' => 'dealer',
					'context'    => 'normal',
					'priority'   => 'high',
					'sections'   => array(
						'basic-information' => array( 'title' => esc_html__( 'Basic Information', 'tf-car-listing' ) ),
						'social-infomation' => array( 'title' => esc_html__( 'Socials Information', 'tf-car-listing' ) ),
					),
					'options'    => $this->tfcl_get_meta_box_config_list( 'dealer' )
				)
			);

			new Meta_Box_Control(
				array(
					'id'         => 'package-detail',
					'label'      => esc_html__( 'Package', 'tf-car-listing' ),
					'post_types' => 'package',
					'context'    => 'normal',
					'priority'   => 'high',
					'sections'   => array(
						'package-detail' => array( 'title' => esc_html__( 'Package Detail', 'tf-car-listing' ) )
					),
					'options'    => $this->tfcl_get_meta_box_config_list( 'package' )
				)
			);

			new Meta_Box_Control(
				array(
					'id'         => 'invoice-detail',
					'label'      => esc_html__( 'Invoice Detail', 'tf-car-listing' ),
					'post_types' => 'invoice',
					'context'    => 'normal',
					'priority'   => 'high',
					'callback'   => 'tfcl_render_invoice_meta_boxes',
					'sections'   => array(),
					'options'    => array(),
				)
			);

			new Meta_Box_Control(
				array(
					'id'         => 'user-package-detail',
					'label'      => esc_html__( 'User Package Detail', 'tf-car-listing' ),
					'post_types' => 'user-package',
					'context'    => 'normal',
					'priority'   => 'high',
					'callback'   => 'tfcl_render_user_package_meta_boxes',
					'sections'   => array(),
					'options'    => array()
				)
			);

			new Meta_Box_Control(
				array(
					'id'         => 'transaction-log-detail',
					'label'      => esc_html__( 'Transaction Log', 'tf-car-listing' ),
					'post_types' => 'transaction-log',
					'context'    => 'normal',
					'priority'   => 'high',
					'callback'   => 'tfcl_render_transaction_log_meta_boxes',
					'sections'   => array(),
					'options'    => array(),
				)
			);
		}

		public function tfcl_change_author_when_update_any_listing( $meta_id, $object_id, $meta_key, $_meta_value ) {
			if ( $meta_key === 'listing_dealer_info' ) {
				$dealer_id = get_post_meta( $object_id, $meta_key, true );
				$author_id = get_post_field( 'post_author', $dealer_id );
				$author_id = !empty($author_id) ? $author_id : 0;
				if ( ! empty( $author_id ) ) {
					wp_update_post( array(
						'ID'          => $object_id,
						'post_author' => $author_id,
					) );
				}
			}
		}
	}
}
?>