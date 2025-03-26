<?php 
//Logo
$wp_customize->add_setting(
    'site_logo',
    array(
        'default' => themesflat_customize_default('site_logo'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'site_logo',
        array(
           'label'          => esc_html__( 'Upload Logo On Header', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display logo please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'        => 'section_logo',
           'priority'       => 1,
        )
    )
);

// Logo Size    
$wp_customize->add_setting(
    'logo_width',
    array(
        'default'   =>  themesflat_customize_default('logo_width'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_Slide_Control( $wp_customize,
    'logo_width',
        array(
            'type'      =>  'slide-control',
            'section'   =>  'section_logo',
            'label'     =>  'Logo Size Width(px)',
            'priority'  => 2,
            'input_attrs' => array(
                'min' => 0,
                'max' => 500,
                'step' => 1,
            ),
        )

    )
);

//Logo
$wp_customize->add_setting(
    'site_logo_fixed',
    array(
        'default' => themesflat_customize_default('site_logo_fixed'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'site_logo_fixed',
        array(
           'label'          => esc_html__( 'Upload Logo Fixed', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display logo please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'        => 'section_logo',
           'priority'       => 1,
        )
    )
);

//Logo
$wp_customize->add_setting(
    'site_logo_mobile',
    array(
        'default' => themesflat_customize_default('site_logo_mobile'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'site_logo_mobile',
        array(
           'label'          => esc_html__( 'Upload Logo On Mobile', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display logo please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'        => 'section_logo',
           'priority'       => 3,
        )
    )
);

// Logo Dashboard
$wp_customize->add_setting(
    'site_logo_dashboard',
    array(
        'default' => themesflat_customize_default('site_logo_dashboard'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'site_logo_dashboard',
        array(
           'label'          => esc_html__( 'Upload Logo Dashboard', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display logo please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section' => 'section_logo',
           'priority'       => 4,
        )
    )
);