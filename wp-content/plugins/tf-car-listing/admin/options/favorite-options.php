<?php
return array(
    'title'  => esc_html__('Favorite', 'tf-car-listing'),
    'id'     => 'favorite-options',
    'desc'   => '',
    'icon'   => 'el el-star',
    'fields' => array(
        array(
            'id'      => 'enable_favorite',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Favorite Listing', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'    => 'item_per_page_my_favorite',
            'type'  => 'text',
            'title' => esc_html__('Item Per Page My Favorite', 'tf-car-listing'),
        ),
    )
);