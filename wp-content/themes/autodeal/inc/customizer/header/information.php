<?php 

// Email
$wp_customize->add_setting(
    'information_email',
    array(
        'default' => themesflat_customize_default('information_email'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'information_email',
    array(
        'label' => esc_html__( 'Email', 'autodeal' ),
        'section' => 'section_information',
        'type' => 'text',
        'priority' => 1,
    )
);

// Phone
$wp_customize->add_setting(
    'information_phone',
    array(
        'default' => themesflat_customize_default('information_phone'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'information_phone',
    array(
        'label' => esc_html__( 'Phone', 'autodeal' ),
        'section' => 'section_information',
        'type' => 'text',
        'priority' => 2,
    )
);

// Address
$wp_customize->add_setting(
    'information_address',
    array(
        'default' => themesflat_customize_default('information_address'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'information_address',
    array(
        'label' => esc_html__( 'Address', 'autodeal' ),
        'section' => 'section_information',
        'type' => 'text',
        'priority' => 3,
    )
);

// Time
$wp_customize->add_setting(
    'information_datetime',
    array(
        'default' => themesflat_customize_default('information_datetime'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'information_datetime',
    array(
        'label' => esc_html__( 'Time', 'autodeal' ),
        'section' => 'section_information',
        'type' => 'text',
        'priority' => 4,
    )
);


