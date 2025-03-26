<?php 
// Customize Blog Featured Title
$wp_customize->add_setting (
    'blog_featured_title',
    array(
        'default' => themesflat_customize_default('blog_featured_title'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'blog_featured_title',
    array(
        'type'      => 'text',
        'label'     => esc_html__('Customize Blog Featured Title', 'autodeal'),
        'section'   => 'section_content_blog_single',
        'priority'  => 1
    )
);   


//Blog Single Layout
$wp_customize->add_setting(
    'blog_layout_single',
    array(
        'default'           => themesflat_customize_default('blog_layout_single'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( 
    'blog_layout_single',
    array (
        'type'      => 'select',           
        'section'   => 'section_content_blog_single',
        'priority'  => 1,
        'label'         => esc_html__('Sidebar Single Position', 'autodeal'),
        'choices'   => array (
            'sidebar-right'     => esc_html__( 'Sidebar Right','autodeal' ),
            'sidebar-left'      =>  esc_html__( 'Sidebar Left','autodeal' ),
        ),
    )
);

// Enable Entry Footer Content
$wp_customize->add_setting(
  'show_entry_footer_content',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('show_entry_footer_content'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_entry_footer_content',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Entry Footer ( OFF | ON )', 'autodeal'),
        'section' => 'section_content_blog_single',
        'priority' => 4,
    ))
);