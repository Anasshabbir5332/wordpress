<?php 
// Show Bottom
$wp_customize->add_setting ( 
    'show_bottom',
    array (
        'sanitize_callback' => 'themesflat_sanitize_checkbox' ,
        'default' => themesflat_customize_default('show_bottom'),     
    )
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'show_bottom',
    array(
        'type'      => 'checkbox',
        'label'     => esc_html__('Bottom ( OFF | ON )', 'autodeal'),
        'section'   => 'section_bottom',
        'priority'  => 1
    ))
);

//Logo Footer
$wp_customize->add_setting(
    'site_logo_footer',
    array(
        'default' => themesflat_customize_default('site_logo_footer'),
        'sanitize_callback' => 'esc_url_raw',
    )
);    
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'site_logo_footer',
        array(
           'label'          => esc_html__( 'Upload Logo On Footer', 'autodeal' ),
           'description'    => esc_html__( 'If you don\'t display logo please remove it your website display 
            Site Title default in General', 'autodeal' ),
           'type'           => 'image',
           'section'   => 'section_bottom',
           'priority'       => 2,
        )
    )
);
  
// Footer Copyright
$wp_customize->add_setting(
    'footer_copyright',
    array(
        'default' => themesflat_customize_default('footer_copyright'),
        'sanitize_callback' => 'themesflat_sanitize_text',
    )
);
$wp_customize->add_control(
    'footer_copyright',
    array(
        'label' => esc_html__( 'Copyright', 'autodeal' ),
        'section' => 'section_bottom',
        'type' => 'textarea',
        'priority' => 2
    )
);

//Socials
$wp_customize->add_setting(
    'social_bottom',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('social_bottom'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'social_bottom',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Social ( OFF | ON )', 'autodeal'),
          'section' => 'section_bottom',
          'priority' => 3,
      ))
  );