<?php 
//Header Style
$wp_customize->add_setting(
    'style_header',
    array(
        'default'           => themesflat_customize_default('style_header'),
        'sanitize_callback' => 'esc_attr',
    )
);
$wp_customize->add_control( new themesflat_RadioImages($wp_customize,
    'style_header',
    array (
        'type'      => 'radio-images',           
        'section'   => 'section_options',
        'priority'  => 1,
        'label'         => esc_html__('Header Style', 'autodeal'),
        'choices'   => array (
            'header-default' => array (
                'tooltip'   => esc_html__( 'Header Default','autodeal' ),
                'src'       => THEMESFLAT_LINK . 'images/controls/header-default.jpg'
            ),
            'header-02' => array (
                'tooltip'   => esc_html__( 'Header 02','autodeal' ),
                'src'       => THEMESFLAT_LINK . 'images/controls/header-02.jpg'
            ),
        ),
    ))
); 

// Enable Header Absolute
$wp_customize->add_setting(
  'header_absolute',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_absolute'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_absolute',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Header Absolute ( OFF | ON )', 'autodeal'),
        'section' => 'section_options',
        'priority' => 2,
        'active_callback' => function () use ( $wp_customize ) {
            return 'header-03' != $wp_customize->get_setting( 'style_header' )->value();
        },
    ))
);

// Enable Header Sticky
$wp_customize->add_setting(
  'header_sticky',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_sticky'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_sticky',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Header Sticky ( OFF | ON )', 'autodeal'),
        'section' => 'section_options',
        'priority' => 3,
    ))
);    

// Show search 
$wp_customize->add_setting(
  'header_search_box',
    array(
        'sanitize_callback' => 'themesflat_sanitize_checkbox',
        'default' => themesflat_customize_default('header_search_box'),     
    )   
);
$wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
    'header_search_box',
    array(
        'type' => 'checkbox',
        'label' => esc_html__('Search Box ( OFF | ON )', 'autodeal'),
        'section' => 'section_options',
        'priority' => 4,
    ))
);

// Show Favorite 
$wp_customize->add_setting(
    'header_favorite',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('header_favorite'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'header_favorite',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Favorite ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 4,
      ))
  );

  $wp_customize->add_setting(
    'header_user',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('header_user'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'header_user',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Header Login ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 8,
      ))
  );

  $wp_customize->add_setting(
    'header_button',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('header_button'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'header_button',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Header Button ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 8,
      ))
  );

$wp_customize->add_setting( 
    'infor_menu_mobile_show',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('infor_menu_mobile_show'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'infor_menu_mobile_show',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Information Mobile Menu ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 9,
      ))
); 

$wp_customize->add_control( new themesflat_Info( $wp_customize, 'header_button_label', array(
    'label'    => esc_html__( 'Button', 'autodeal' ),
    'section'  => 'section_options',
    'settings' => 'themesflat_options[info]',
    'priority' => 16,
    'active_callback' => function () use ( $wp_customize ) {
        return 1 === $wp_customize->get_setting( 'header_button' )->value();
    }, 
) )
);

// Button Text
$wp_customize->add_setting(
    'header_button_text',
    array(
        'default' => themesflat_customize_default('header_button_text'),
        'sanitize_callback' => 'themesflat_sanitize_text'
    )
);
$wp_customize->add_control(
    'header_button_text',
    array(
        'label' => esc_html__( 'Button Text', 'autodeal' ),
        'section' => 'section_options',
        'type' => 'text',
        'priority' => 17,
        'active_callback' => function () use ( $wp_customize ) {
            return 1 === $wp_customize->get_setting( 'header_button' )->value();
        }, 
    )
);

//add setting
$wp_customize->add_setting( 
    'header_button_url', 
    array(
    'default' => '',
    'sanitize_callback' => 'themesflat_sanitize_text'
));

//add control
$wp_customize->add_control( 'header_button_url', array(
    'label' => 'Select page for button link to',
    'priority' => 19,
    'active_callback' => function () use ( $wp_customize ) {
        return 1 === $wp_customize->get_setting( 'header_button' )->value();
    }, 
    'type'  => 'dropdown-pages',
    'section' => 'section_options',
    'settings' => 'header_button_url'
));


$wp_customize->add_control( new themesflat_Info( $wp_customize, 'header_topbar_label', array(
    'label'    => esc_html__( 'TopBar', 'autodeal' ),
    'section'  => 'section_options',
    'settings' => 'themesflat_options[info]',
    'priority' => 19,
) )
);

// Top bar show
$wp_customize->add_setting( 
    'topbar_show',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('topbar_show'),     
      )   
  );
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'topbar_show',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Topbar ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 20,
      ))
); 

// Social Topbar
$wp_customize->add_setting(
    'social_topbar',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('social_topbar'),     
      )   
  );
  
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'social_topbar',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Social ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 21,
          'active_callback' => function () use ( $wp_customize ) {
            return 'header-02' != $wp_customize->get_setting( 'style_header' )->value();
        },
      ))
  );
  
  // Address Topbar
$wp_customize->add_setting(
    'topbar_address_active',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('topbar_address_active'),     
      )   
  );
  
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'topbar_address_active',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Show Address ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 22,
      ))
  );

    // Datetime Topbar
$wp_customize->add_setting(
    'topbar_date_active',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('topbar_date_active'),     
      )   
  );
  
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'topbar_date_active',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Show Date ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 23,
      ))
  );

      // Phone Topbar
$wp_customize->add_setting(
    'topbar_phone_active',
      array(
          'sanitize_callback' => 'themesflat_sanitize_checkbox',
          'default' => themesflat_customize_default('topbar_phone_active'),     
      )   
  );
  
  $wp_customize->add_control( new themesflat_Checkbox( $wp_customize,
      'topbar_phone_active',
      array(
          'type' => 'checkbox',
          'label' => esc_html__('Show Phone ( OFF | ON )', 'autodeal'),
          'section' => 'section_options',
          'priority' => 24,
      ))
  );
  
  // Topbar Box control
  $wp_customize->add_setting(
      'topbar_controls',
      array(
          'default' => themesflat_customize_default('topbar_controls'),
          'sanitize_callback' => 'themesflat_sanitize_text',
      )
  );
  $wp_customize->add_control( new themesflat_BoxControls($wp_customize,
      'topbar_controls',
      array(
          'label' => esc_html__( 'Box Controls (px)', 'autodeal' ),
          'section' => 'section_options',
          'type' => 'box-controls',
          'priority' => 25
      ))
  );