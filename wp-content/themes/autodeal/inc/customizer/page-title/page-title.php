<?php 

$wp_customize->add_setting('themesflat_options[info]', array(
        'type'              => 'info_control',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',            
    )
);
$wp_customize->add_control( new themesflat_Info( $wp_customize, 'page-title', array(
    'label' => esc_html__('Page Title', 'autodeal'),
    'section' => 'section_page_title',
    'settings' => 'themesflat_options[info]',
    'priority' => 1
    ) )
);

// Page title heading
$wp_customize->add_setting(
    'page_title_heading_enabled',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('page_title_heading_enabled'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'page_title_heading_enabled',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Heading ( OFF | ON )', 'autodeal'),
          'section' => 'section_page_title',
          'priority' => 2,
      ))
  );

  // Social Share
$wp_customize->add_setting(
    'show_social_share',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('show_social_share'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'show_social_share',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Social Media Share Page ( OFF | ON )', 'autodeal'),
          'section' => 'section_page_title',
          'priority' => 3,
      ))
  );

// Page Title Overlay
$wp_customize->add_setting(
    'page_title_background_color',
    array(
        'default'           => themesflat_customize_default('page_title_background_color'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_ColorOverlay(
        $wp_customize,
        'page_title_background_color',
        array(
            'label'         => esc_html__('Background Color', 'autodeal'),
            'section'       => 'section_page_title',
            'priority'      => 6
        )
    )
);   

$wp_customize->add_setting(
    'page_title_background_color_opacity',
    array(
        'default'   =>  themesflat_customize_default('page_title_background_color_opacity'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_Slide_Control( $wp_customize,
    'page_title_background_color_opacity',
        array(
            'type'      =>  'slide-control',
            'section'   =>  'section_page_title',
            'label'     =>  'Opacity for Background Color (%)',
            'priority'  => 7,
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
        )

    )
);  

// Box control
$wp_customize->add_setting(
    'page_title_controls',
    array(
        'default' => themesflat_customize_default('page_title_controls'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control( new themesflat_BoxControls($wp_customize,
    'page_title_controls',
    array(
        'label' => esc_html__( 'Page Title Controls (px)', 'autodeal' ),
        'section' => 'section_page_title',
        'type' => 'box-controls',
        'priority' => 8,
    ))
);  