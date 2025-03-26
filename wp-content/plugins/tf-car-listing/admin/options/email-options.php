<?php
return array(
    'title'  => esc_html__('Email', 'tf-car-listing'),
    'id'     => 'email-options',
    'desc'   => '',
    'icon'   => 'el el-envelope',
    'fields' => array(
        // Matching new listing with saved searches
        array(
            'id'     => 'begin_user_email_matching_new_listing',
            'type'   => 'section',
            'title'  => esc_html__('Admin Email matching new listing with saved searches', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_user_email_matching_new_listing',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_user_email_matching_new_listing',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('You have new listing matching with your saved advanced searches', 'tf-car-listing'),
            'required' => array( 'enable_user_email_matching_new_listing', '=', 'y' ),
        ),
        array(
            'id'       => 'user_email_matching_new_listing',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hello, You have new listing matching with your saved advanced searches:
            $links_matching
            If you don\'t want to be receive this mail anymore in the future. Please login your dashboard and delete the saved advanced search.
            Thank you!', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_user_email_matching_new_listing', '=', 'y' )
        ),
        array(
            'id'     => 'end_user_email_matching_new_listing',
            'type'   => 'section',
            'indent' => false,
        ),

        // Approve Listing
        array(
            'id'     => 'begin_user_email_approve_listing',
            'type'   => 'section',
            'title'  => esc_html__('User Email Approve Listing', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_user_email_approve_listing',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_user_email_approve_listing',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('Your listing approved!', 'tf-car-listing'),
            'required' => array( 'enable_user_email_approve_listing', '=', 'y' ),
        ),
        array(
            'id'       => 'user_email_approve_listing',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hi $user_name,
            Your listing on $website_url has been approved.
            
            Listing Title: $listing_title
            Listing Url: $listing_url
            Thank you!', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_user_email_approve_listing', '=', 'y' )
        ),
        array(
            'id'     => 'end_user_email_approve_listing',
            'type'   => 'section',
            'indent' => false,
        ),

        // Approve Dealer
        array(
            'id'     => 'begin_user_email_approve_dealer',
            'type'   => 'section',
            'title'  => esc_html__('User Email Approve Dealer', 'tf-car-listing'),
            'indent' => true
        ),
            array(
                'id'      => 'enable_user_email_approve_dealer',
                'type'    => 'button_set',
                'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
                'options' => array(
                    'y' => esc_html__('Yes', 'tf-car-listing'),
                    'n' => esc_html__('No', 'tf-car-listing'),
                ),
                'default' => 'y',
                'class'   => 'hide-icon-blank',
            ),
            array(
                'id'       => 'subject_user_email_approve_dealer',
                'type'     => 'text',
                'title'    => esc_html__('Subject', 'tf-car-listing'),
                'default'  => esc_html__('Approved Dealer', 'tf-car-listing'),
                'required' => array( 'enable_user_email_approve_dealer', '=', 'y' )
            ),

            array(
                'id'       => 'user_email_approve_dealer',
                'type'     => 'editor',
                'title'    => esc_html__('Mail Body', 'tf-car-listing'),
                'default'  => esc_html__('Hi $dealer_name,
                Your account on $website_url has been approved to dealer account.
                Dealer Name: $dealer_name
                Thank you!', 'tf-car-listing'),
                'args'     => array(
                    'wpautop'       => true,
                    'media_buttons' => true,
                    'textarea_rows' => 15,
                    'quicktags'     => true,
                ),
                'required' => array( 'enable_user_email_approve_dealer', '=', 'y' )
            ),

        array(
            'id'     => 'end_user_email_approve_dealer',
            'type'   => 'section',
            'indent' => false,
        ),

        array(
            'id'     => 'begin_admin_email_approve_dealer',
            'type'   => 'section',
            'title'  => esc_html__('Admin Email Approve dealer', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_admin_email_approve_dealer',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_admin_email_approve_dealer',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('Dealer Approval', 'tf-car-listing'),
            'required' => array( 'enable_admin_email_approve_dealer', '=', 'y' ),
        ),
        array(
            'id'       => 'admin_email_approve_dealer',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hello Admin, 
            A new dealer $dealer_name is waiting for approval.
            Thank you!', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_admin_email_approve_dealer', '=', 'y' )
        ),
        array(
            'id'     => 'end_admin_email_approve_dealer',
            'type'   => 'section',
            'indent' => false,
        ),

        // Paid Package
        array(
            'id'     => 'begin_user_email_paid_package',
            'type'   => 'section',
            'title'  => esc_html__('User Email Paid Package', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_user_email_paid_package',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_user_email_paid_package',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('Your purchase was successfully!', 'tf-car-listing'),
            'required' => array( 'enable_user_email_paid_package', '=', 'y' ),
        ),
        array(
            'id'       => 'user_email_paid_package',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hi there,
            Welcome to $website_name and thank you for purchasing a package with us. We are excited you have chosen $website_name .
            Your package on $website_url purchasing successfully! You can now list your listings according with your plan.', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_user_email_paid_package', '=', 'y' )
        ), 
        array(
            'id'     => 'end_user_email_paid_package',
            'type'   => 'section',
            'indent' => false,
        ),

        array(
            'id'     => 'begin_admin_email_paid_package',
            'type'   => 'section',
            'title'  => esc_html__('Admin Email Paid Package', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_admin_email_paid_package',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_admin_email_paid_package',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('Somebody ordered a new Package!', 'tf-car-listing'),
            'required' => array( 'enable_admin_email_paid_package', '=', 'y' ),
        ),
        array(
            'id'       => 'admin_email_paid_package',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hi there,
            Have new ordered package payment request on $website_url !
            Please follow the information below in order to activated package as soon as possible.
            The invoice number is: $invoice_no, Amount: $total_price.', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_admin_email_paid_package', '=', 'y' )
        ), 
        array(
            'id'     => 'end_admin_email_paid_package',
            'type'   => 'section',
            'indent' => false,
        ),

        // Wire Transfer
        array(
            'id'     => 'begin_user_email_wire_transfer',
            'type'   => 'section',
            'title'  => esc_html__('User Email Wire Transfer', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_user_email_wire_transfer',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_user_email_wire_transfer',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('You ordered a new Wire Transfer!', 'tf-car-listing'),
            'required' => array( 'enable_user_email_wire_transfer', '=', 'y' ),
        ),
        array(
            'id'       => 'user_email_wire_transfer',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hi there,
            We received your Wire Transfer payment request on $website_url !
            Please follow the information below in order to start submitting listings as soon as possible.
            The invoice number is: $invoice_no, Amount: $total_price.', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_user_email_wire_transfer', '=', 'y' )
        ), 
        array(
            'id'     => 'end_user_email_wire_transfer',
            'type'   => 'section',
            'indent' => false,
        ),


        array(
            'id'     => 'begin_admin_email_wire_transfer',
            'type'   => 'section',
            'title'  => esc_html__('Admin Email Wire Transfer', 'tf-car-listing'),
            'indent' => true
        ),
        array(
            'id'      => 'enable_admin_email_wire_transfer',
            'type'    => 'button_set',
            'title'   => esc_html__('Enable Send Email', 'tf-car-listing'),
            'options' => array(
                'y' => esc_html__('Yes', 'tf-car-listing'),
                'n' => esc_html__('No', 'tf-car-listing'),
            ),
            'default' => 'y',
            'class'   => 'hide-icon-blank',
        ),
        array(
            'id'       => 'subject_admin_email_wire_transfer',
            'type'     => 'text',
            'title'    => esc_html__('Subject', 'tf-car-listing'),
            'default'  => esc_html__('Somebody ordered a new Wire Transfer!', 'tf-car-listing'),
            'required' => array( 'enable_admin_email_wire_transfer', '=', 'y' ),
        ),
        array(
            'id'       => 'admin_email_wire_transfer',
            'type'     => 'editor',
            'title'    => esc_html__('Mail Body', 'tf-car-listing'),
            'default'  => esc_html__('Hi there,
            A new Wire Transfer payment request on $website_url !
            The invoice number is: $invoice_no, Amount: $total_price.', 'tf-car-listing'),
            'args'     => array(
                'teeny'         => true,
                'textarea_rows' => 15
            ),
            'required' => array( 'enable_admin_email_wire_transfer', '=', 'y' )
        ), 
        array(
            'id'     => 'end_admin_email_wire_transfer',
            'type'   => 'section',
            'indent' => false,
        ),
    )
);