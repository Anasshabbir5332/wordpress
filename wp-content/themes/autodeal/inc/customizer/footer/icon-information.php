<?php 
$wp_customize->add_setting(
    'show_icon_information',
    array(
        'default'   => themesflat_customize_default('show_icon_information'),
        'sanitize_callback'  => 'themesflat_sanitize_checkbox',
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
        'show_icon_information',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Icon Information ( OFF | ON )', 'autodeal'),
            'section'   => 'section_icon_infor',
            'priority'  => 1
        )
    )
);

// image
$wp_customize->add_setting(
    'footer_info_image',
    array(
        'default' => themesflat_customize_default('footer_info_image'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'footer_info_image',
        array(
           'label'          => esc_html__( 'Upload Your Image ', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display image please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'   => 'section_icon_infor',
           'priority'       => 2,
        )
    )
);
// Heading
$wp_customize->add_setting(
    'footer_info_text',
    array(
        'default'   =>  themesflat_customize_default('footer_info_text'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_text',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Heading', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  3
    )
);
// Description
$wp_customize->add_setting(
    'footer_info_description',
    array(
        'default'   =>  themesflat_customize_default('footer_info_description'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_description',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Description', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  4
    )
);

// image
$wp_customize->add_setting(
    'footer_info_image2',
    array(
        'default' => themesflat_customize_default('footer_info_image2'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'footer_info_image2',
        array(
           'label'          => esc_html__( 'Upload Your Image ', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display image please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'   => 'section_icon_infor',
           'priority'       => 5,
        )
    )
);
// Heading
$wp_customize->add_setting(
    'footer_info_text2',
    array(
        'default'   =>  themesflat_customize_default('footer_info_text2'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_text2',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Heading', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  6
    )
);
// Description
$wp_customize->add_setting(
    'footer_info_description2',
    array(
        'default'   =>  themesflat_customize_default('footer_info_description2'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_description2',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Description', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  7
    )
);

// image
$wp_customize->add_setting(
    'footer_info_image3',
    array(
        'default' => themesflat_customize_default('footer_info_image3'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'footer_info_image3',
        array(
           'label'          => esc_html__( 'Upload Your Image ', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display image please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'   => 'section_icon_infor',
           'priority'       => 8,
        )
    )
);
// Heading
$wp_customize->add_setting(
    'footer_info_text3',
    array(
        'default'   =>  themesflat_customize_default('footer_info_text3'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_text3',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Heading', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  9
    )
);
// Description
$wp_customize->add_setting(
    'footer_info_description3',
    array(
        'default'   =>  themesflat_customize_default('footer_info_description3'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_description3',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Description', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  10
    )
);

// image
$wp_customize->add_setting(
    'footer_info_image4',
    array(
        'default' => themesflat_customize_default('footer_info_image4'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'footer_info_image4',
        array(
           'label'          => esc_html__( 'Upload Your Image ', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display image please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'   => 'section_icon_infor',
           'priority'       => 11,
        )
    )
);
// Heading
$wp_customize->add_setting(
    'footer_info_text4',
    array(
        'default'   =>  themesflat_customize_default('footer_info_text4'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_text4',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Heading', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  12
    )
);
// Description
$wp_customize->add_setting(
    'footer_info_description4',
    array(
        'default'   =>  themesflat_customize_default('footer_info_description4'),
        'sanitize_callback'  =>  'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'footer_info_description4',
    array(
        'type'      =>  'text',
        'label'     =>  esc_html__('Description', 'autodeal'),
        'section'   =>  'section_icon_infor',
        'priority'  =>  13
    )
);