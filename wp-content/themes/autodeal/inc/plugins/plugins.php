<?php
// Register action to declare required plugins
add_action('tgmpa_register', 'themesflat_recommend_plugin');
function themesflat_recommend_plugin() {
    
    $plugins = array(
        array(
            'name' => esc_html__('Elementor', 'autodeal'),
            'slug' => 'elementor',
            'required' => true
        ),
        array(
            'name' => esc_html__('ThemesFlat Core', 'autodeal'),
            'slug' => 'themesflat-core',
            'source' => THEMESFLAT_DIR . 'inc/plugins/themesflat-core.zip',
            'required' => true
        ),
        array(
            'name' => esc_html__('TF Car Listing', 'autodeal'),
            'slug' => 'tf-car-listing',
            'source' => 'https://themesflat.co/3rdplugins/autodeal-listing.zip',
            'required' => true
        ),
        array(
            'name' => esc_html__('Redux Framework', 'autodeal'),
            'slug' => 'redux-framework',
            'required' => true
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'autodeal'),
            'slug' => 'contact-form-7',
            'required' => false
        ),    
        array(
            'name' => esc_html__('Mailchimp', 'autodeal'),
            'slug' => 'mailchimp-for-wp',
            'required' => false
        ),     
        array(
            'name' => esc_html__('WP Mail SMTP', 'autodeal'),
            'slug' => 'wp-mail-smtp',
            'required' => false
        ),   
        array(
            'name' => esc_html__('One Click Demo Import', 'autodeal'),
            'slug' => 'one-click-demo-import',
            'required' => false
        )   
    );
    
    tgmpa($plugins);
}

