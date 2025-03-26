<?php
return array(
    'title'  => esc_html__('Comment & Review', 'tf-car-listing'),
    'id'     => 'comment-review-options',
    'desc'   => '',
    'icon'   => 'el el-comment',
    'fields' => array(
        array(
            'id'    => 'item_per_page_my_review',
            'type'  => 'text',
            'title' => esc_html__('Item Per Page My Reviews', 'tf-car-listing'),
        ),
        // Listing
        array(
            'id'       => 'begin_comment_review_for_listing',
            'type'     => 'accordion',
            'title'    => esc_html__('Listing', 'tf-car-listing'),
            'position' => 'start',
            'open'     => false
        ),
        array(
            'id'      => 'enable_comment_review_listing',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Comment & Review Listing', 'tf-car-listing'),
            'options' => array(
                'hide'    => esc_html__('Hide', 'tf-car-listing'),
                'comment' => esc_html__('Comment', 'tf-car-listing'),
                'review'  => esc_html__('Review', 'tf-car-listing'),
            ),
            'default' => 'comment',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'enable_review_listing_approve_by_admin',
            'type'     => 'button_set',
            'title'    => esc_html__('Enable Review Listing Approve By Admin', 'tf-car-listing'),
            'options'  => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default'  => 'n',
            'class'    => 'hide-icon-blank',
            'required' => array( 'enable_comment_review_listing', '=', 'review' )
        ),
        array(
            'id'       => 'end_comment_review_for_listing',
            'type'     => 'accordion',
            'position' => 'end',
        ),
    )
);