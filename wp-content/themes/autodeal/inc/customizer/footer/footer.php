<?php 

// Show Footer
$wp_customize->add_setting ( 
    'show_footer',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('show_footer'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_footer',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Footer ( OFF | ON )', 'autodeal'),
        'section' => 'section_footer',
        'priority'  => 1
    ))
);

// Columns Footer
$wp_customize->add_setting(
    'footer_widget_areas',
    array(
        'default'           => themesflat_customize_default('footer_widget_areas'),
        'sanitize_callback' => 'themesflat_sanitize_grid_post_related',
    )
);
$wp_customize->add_control(
    'footer_widget_areas',
    array(
        'type'      => 'select',           
        'section'   => 'section_footer',
        'priority'  => 1,
        'label'     => esc_html__('Columns Footer', 'autodeal'),
        'choices'   => array(                
            2     => esc_html__( '2 Columns', 'autodeal' ),
            3     => esc_html__( '3 Columns', 'autodeal' ),
            4     => esc_html__( '4 Columns', 'autodeal' ),                  
        )
    )
); 

$wp_customize->add_setting(
    'tab_footer',
    array(
        'default'   => themesflat_customize_default('tab_footer'),
        'sanitize_callback'  => 'themesflat_sanitize_checkbox',
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
        'tab_footer',
        array(
            'type'      => 'checkbox',
            'label'     => esc_html__('Collapse Widget Footer on Mobile ( OFF | ON )', 'autodeal'),
            'section' => 'section_footer',
            'description'    => esc_html__( 'This function only working on mobile devices', 'autodeal' ),
            'priority'  => 4,
        )
    )
);

// Footer Box control
$wp_customize->add_setting(
    'footer_controls',
    array(
        'default' => themesflat_customize_default('footer_controls'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control( new themesflat_BoxControls($wp_customize,
    'footer_controls',
    array(
        'label' => esc_html__( 'Footer Box Controls (px)', 'autodeal' ),
        'section' => 'section_footer',
        'type' => 'box-controls',
        'priority' => 5
    ))
);