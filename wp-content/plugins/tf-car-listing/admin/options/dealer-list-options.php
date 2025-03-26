<?php
return array(
    'title'  => esc_html__('Dealer List', 'tf-car-listing'),
    'id'     => 'dealer-list-options',
    'desc'   => '',
    'icon'   => 'el el-folder-close',
    'fields' => array(
        array(
            'id'       => 'item_per_page_archive_dealer',
            'type'     => 'text',
            'title'    => esc_html__('Item Per Page', 'tf-car-listing'),
            'subtitle' => esc_html__('Set number of item per page archive dealer.', 'tf-car-listing'),
            'default'  => esc_html__('6', 'tf-car-listing')
        ),
        array(
            'id'       => 'archive_dealer_sidebar',
            'type'     => 'button_set',
            'title'    => esc_html__('Sidebar', 'tf-car-listing'),
            'subtitle' => esc_html__('Enable/Disable sidebar.', 'tf-car-listing'),
            'class'    => 'hide-icon-blank',
            'options'  => array(
                'enable'  => 'Enable',
                'disable' => 'Disable',
            ),
            'default'  => 'disable',
        ),
        array(
            'id'       => 'archive_dealer_sidebar_position',
            'type'     => 'button_set',
            'title'    => esc_html__('Sidebar Position', 'tf-car-listing'),
            'subtitle' => esc_html__('Choose sidebar position.', 'tf-car-listing'),
            'class'    => 'hide-icon-blank',
            'options'  => array(
                'sidebar-left'  => 'Sidebar Left',
                'sidebar-right' => 'Sidebar Right',
            ),
            'default'  => 'sidebar-right',
            'required' => array( 'archive_dealer_sidebar', '=', 'enable' )
        ),

        array(
            'id'       => 'pagination_dealer_archive',
            'type'     => 'button_set',
            'title'    => esc_html__('Pagination', 'tf-car-listing'),
            'subtitle' => esc_html__('Enable/Disable pagination.', 'tf-car-listing'),
            'class'    => 'hide-icon-blank',
            'options'  => array(
                'enable'  => 'Enable',
                'disable' => 'Disable',
            ),
            'default'  => 'enable',
        ),
    )
);