<?php 
// Menu Background
$wp_customize->add_setting(
    'header_backgroundcolor',
    array(
        'default'           => themesflat_customize_default('header_backgroundcolor'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'header_backgroundcolor',
        array(
            'label'         => esc_html__('Header Background', 'autodeal'),
            'description'   => esc_html__(' Opacity =1 for Background Color', 'autodeal'),
            'section'       => 'color_header',
            'priority'      => 1
        )
    )
);

// Header Background sticky
$wp_customize->add_setting(
    'header_backgroundcolor_sticky',
    array(
        'default'           => themesflat_customize_default('header_backgroundcolor_sticky'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'header_backgroundcolor_sticky',
        array(
            'label'         => esc_html__('Sticky Header Background', 'autodeal'),
            'section'       => 'color_header',
            'priority'      => 2
        )
    )
); 

// Menu a color
$wp_customize->add_setting(
    'mainnav_color',
    array(
        'default'           => themesflat_customize_default('mainnav_color'),
        'sanitize_callback' => 'esc_attr'
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'mainnav_color',
        array(
            'label' => esc_html__('Menu color', 'autodeal'),
            'section' => 'color_header',
            'priority' => 4
        )
    )
);

// Menu hover color
$wp_customize->add_setting(
    'mainnav_hover_color',
    array(
        'default'           => themesflat_customize_default('mainnav_hover_color'),
        'sanitize_callback' => 'esc_attr'
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'mainnav_hover_color',
        array(
            'label' => esc_html__('Menu Hover', 'autodeal'),
            'section' => 'color_header',
            'priority' => 5
        )
    )
);

// Menu active color
$wp_customize->add_setting(
    'mainnav_active_color',
    array(
        'default'           => themesflat_customize_default('mainnav_active_color'),
        'sanitize_callback' => 'esc_attr'
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'mainnav_active_color',
        array(
            'label' => esc_html__('Menu Active', 'autodeal'),
            'section' => 'color_header',
            'priority' => 6
        )
    )
);

// Sub menu a color
$wp_customize->add_setting(
    'sub_nav_color',
    array(
        'default'           => themesflat_customize_default('sub_nav_color'),
        'sanitize_callback' => 'esc_attr'
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'sub_nav_color',
        array(
            'label' => esc_html__('SubMenu color', 'autodeal'),
            'section' => 'color_header',
            'priority' => 23
        )
    )
);    

// Sub nav background hover
$wp_customize->add_setting(
    'sub_nav_color_hover',
    array(
        'default'   => themesflat_customize_default('sub_nav_color_hover'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'sub_nav_color_hover',
        array(
            'label' => esc_html__('SubMenu Hover & Active', 'autodeal'),
            'section' => 'color_header',
            'priority' => 24
        )
    )
);

// Sub nav background
$wp_customize->add_setting(
    'sub_nav_background',
    array(
        'default'           => themesflat_customize_default('sub_nav_background'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'sub_nav_background',
        array(
            'label' => esc_html__('SubMenu Background', 'autodeal'),
            'section' => 'color_header',
            'priority' => 25
        )
    )
);

// Sub nav background hover
$wp_customize->add_setting(
    'sub_nav_background_hover',
    array(
        'default'   => themesflat_customize_default('sub_nav_background_hover'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'sub_nav_background_hover',
        array(
            'label' => esc_html__('SubMenu Background Hover & Active', 'autodeal'),
            'section' => 'color_header',
            'priority' => 26
        )
    )
);

// Sub nav line color between link
$wp_customize->add_setting(
    'sub_nav_border_color',
    array(
        'default'           => themesflat_customize_default('sub_nav_border_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control(
    new themesflat_ColorOverlay(
        $wp_customize,
        'sub_nav_border_color',
        array(
            'label' => esc_html__('SubMenu Border Line', 'autodeal'),
            'section' => 'color_header',
            'priority' => 27
        )
    )
);