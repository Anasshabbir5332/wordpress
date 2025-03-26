<?php
add_action( 'admin_init', 'themesflat_page_options_init' );

function themesflat_page_options_init() {

    new themesflat_meta_boxes(array(
        // Blog
        'id'    => 'blog-options',
        'label' => esc_html__( 'Post settings', 'themesflat' ),
        'post_types'    => array('post','faq'),
        'context'     => 'normal',
        'priority'    => 'default',
        'sections' => array(
            'blog'   => array( 'title' => esc_html__( 'Post Format', 'themesflat' ) ),
            ),
        'options' => themesflat_post_options_fields()
    ));   
}

/* Option Blog
===================================*/
function themesflat_post_options_fields() {
    $options['gallery_images_heading'] = array(
        'type' => 'heading',
        'section' => 'blog',
        'title' => esc_html__( 'Post Format: Gallery .', 'themesflat' ),
        'description' => esc_html__( '', 'themesflat' )
    );

    $options['gallery_images'] = array(
        'type'    => 'image-control',
        'section' => 'blog',
        'title' => esc_html__( 'Images', 'themesflat' ),
        'default' => ''
    );

    $options['video_url_heading'] = array(
        'type' => 'heading',
        'section' => 'blog',
        'title' => esc_html__( 'Post Format: Video ( Embeded video from youtube, vimeo ...).', 'themesflat' ),
        'description' => esc_html__( '', 'themesflat' )
    );
    $options['video_url'] = array(
        'type'    => 'textarea',
        'section' => 'blog',
        'title' => esc_html__( 'iframe video link', 'themesflat' ),
        'default' => ''
    );

    $options['audio_url_heading'] = array(
        'type' => 'heading',
        'section' => 'blog',
        'title' => esc_html__( 'Post Format: Audio', 'themesflat' ),
        'description' => esc_html__( '', 'themesflat' )
    );
    $options['audio_url'] = array(
        'type'    => 'textarea',
        'section' => 'blog',
        'title' => esc_html__( 'iframe audio link (https://soundcloud.com/)', 'themesflat' ),
        'default' => ''
    );
    return $options;
}