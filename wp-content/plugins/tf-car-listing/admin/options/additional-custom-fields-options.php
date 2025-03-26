<?php
return array(
    'title'  => esc_html__('Additional Fields', 'tf-car-listing'),
    'id'     => 'additional-custom-fields-options',
    'desc'   => '',
    'icon'   => 'el el-file-new',
    'fields' => array(
        array(
			'id'           => 'additional_fields',
			'type'         => 'repeater',
			'title'        => esc_html__( 'Listing Detail Fields', 'tf-car-listing' ),
			'subtitle'     => esc_html__( 'Add more custom additional field for listing detail', 'tf-car-listing' ),
			'group_values' => true,
			'sortable' => true,
			'fields'       => array(
				array(
					'id'          => 'additional_field_icon',
					'type'    => 'media',
					'title'       => esc_html__( 'Icon', 'tf-car-listing' ),
					'placeholder' => esc_html__( 'Icon', 'tf-car-listing' ),
				),
				array(
					'id'          => 'additional_field_label',
					'type'        => 'text',
					'title'       => esc_html__( 'Label', 'tf-car-listing' ),
					'placeholder' => esc_html__( 'Label', 'tf-car-listing' ),
				),
				array(
					'id'          => 'additional_field_name',
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'tf-car-listing' ),
					'placeholder' => esc_html__( 'Name', 'tf-car-listing' ),
				),
				array(
					'id'          => 'additional_field_type',
					'type'        => 'select',
					'title'       => esc_html__( 'Select Field Type', 'tf-car-listing' ),
					'options'     => array(
						'text'     => esc_html__( 'Text', 'tf-car-listing' ),
						'textarea' => esc_html__( 'Textarea', 'tf-car-listing' ),
						'select'   => esc_html__( 'Select', 'tf-car-listing' ),
						'radio'    => esc_html__( 'Radio', 'tf-car-listing' ),
						'checkbox' => esc_html__( 'Checkbox', 'tf-car-listing' ),
						'date' => esc_html__( 'Date Picker', 'tf-car-listing' ),
					),
					'placeholder' => esc_html__( 'Field Type', 'tf-car-listing' ),
				),
				array(
					'id'       => 'additional_field_option_value',
					'type'     => 'multi_text',
					'title'    => esc_html__( 'Options Value', 'tf-car-listing' ),
					'required' => array(
						array( 'additional_field_type', '=', array( 'select', 'radio', 'checkbox' ) )
					)
				),
			)
		)
    )
);