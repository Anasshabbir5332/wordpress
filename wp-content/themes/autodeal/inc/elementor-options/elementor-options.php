<?php 
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use Elementor\Modules\DynamicTags\Module as TagsModule;


class themesflat_options_elementor {
	public function __construct(){	
        add_action('elementor/documents/register_controls', [$this, 'themesflat_elementor_register_options'], 10);
        add_action('elementor/editor/before_enqueue_scripts', function() { wp_enqueue_script( 'elementor-preview-load', THEMESFLAT_LINK . 'js/elementor/elementor-preview-load.js', array( 'jquery' ), null, true );
        }, 10, 3);
    }

    public function themesflat_elementor_register_options($element){
        $post_id = $element->get_id();
        $post_type = get_post_type($post_id);

        if ( ($post_type !== 'post') ) {
        	$this->themesflat_options_page_header($element);
            $this->themesflat_options_page_footer($element);                      
        }

        $this->themesflat_options_page($element);
        $this->themesflat_options_page_pagetitle($element);

    }

    public function themesflat_options_page_header($element) {
        // TF Header
        $element->start_controls_section(
            'themesflat_header_options',
            [
                'label' => esc_html__('TF Header & TopBar', 'autodeal'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $element->add_control(
            'topbar_show',
            [
                'label'     => esc_html__( 'TopBar Show/Hide', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                	'' => esc_html__( 'Theme Setting', 'autodeal'),
                    '0' => esc_html__( 'Hide TopBar', 'autodeal'),
                    '1' => esc_html__( 'Show TopBar', 'autodeal'),
                ],
            ]
        );


        $element->add_control(
            'style_header',
            [
                'label'     => esc_html__( 'Header Style', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                	'' => esc_html__( 'Theme Setting', 'autodeal'),
                    'header-default' => esc_html__( 'Header Default', 'autodeal'),
                    'header-02' => esc_html__( 'Header 02', 'autodeal'),
                ],
            ]
        );

        $element->add_control(
            'header_absolute',
            [
                'label'     => esc_html__( 'Header Absolute', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                	'' => esc_html__( 'Theme Setting', 'autodeal'),
                    '1' => esc_html__( 'Enable', 'autodeal'),
                    '0' => esc_html__( 'Disable', 'autodeal'),
                ],
            ]
        );

        $element->add_control(
            'header_sticky',
            [
                'label'     => esc_html__( 'Header Sticky', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                	'' => esc_html__( 'Theme Setting', 'autodeal'),
                    '1' => esc_html__( 'Enable', 'autodeal'),
                    '0' => esc_html__( 'Disable', 'autodeal'),
                ],
            ]
        );

        $element->add_control(
            'text_header_color',
            [
                'label' => esc_html__( 'Text Color', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #header .header-infor-phone .content a, {{WRAPPER}} #header .header-infor-phone .content p, {{WRAPPER}} #header .header-infor-phone .icon, {{WRAPPER}} #mainnav > ul > li > a, {{WRAPPER}} #header .show-search a, {{WRAPPER}} .phone-header-box .inner, {{WRAPPER}} .widget_login_menu_widget .user-dropdown .user-display-name.dropdown-toggle::after, {{WRAPPER}} #header:not(.header-sticky) .themesflat-socials li a, {{WRAPPER}} .show-search a, {{WRAPPER}} .widget_login_menu_widget .user-dropdown .user-display-name span.display-name, {{WRAPPER}} #header .header-ct-right .icon-login * , {{WRAPPER}} .header-ct-right .login-header::before, {{WRAPPER}} .header-ct-right .login-header ul li:not(:last-child)::after, {{WRAPPER}} .header-ct-right .login-header * , {{WRAPPER}} #header .tf-btn, {{WRAPPER}} .tfcl-header-favorite' => 'color: {{VALUE}};',                  
                    '{{WRAPPER}} .btn-menu span, {{WRAPPER}} .btn-menu:before, {{WRAPPER}} .btn-menu:after' => 'background: var(--theme-primary-color);',                  
                    '{{WRAPPER}} #header .tf-btn' => 'border-color: {{VALUE}} ;',                  
                ],
            ]
        );

        $element->add_control(
            'menu_active_color',
            [
                'label' => esc_html__( 'Menu Active Color', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #mainnav > ul > li > a:hover, {{WRAPPER}} #mainnav > ul > li.current-menu-item > a, {{WRAPPER}} #mainnav > ul > li.current-menu-ancestor > a, {{WRAPPER}} #mainnav > ul > li.current-menu-parent > a' => 'color: {{VALUE}} !important;',                  
                    '{{WRAPPER}} #mainnav>ul>li>a::before ' => 'background: {{WRAPPER}}; !important ',                  
                ],
            ]
        );

        $element->add_control(
            'header_background',
            [
                'label' => esc_html__( 'Background Header', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #header, {{WRAPPER}} .themesflat-top' => 'background: {{VALUE}} !important;',                  
                ],
            ]
        );

        $element->add_control(
            'header_sticky_background',
            [
                'label' => esc_html__( 'Background Header Sticky', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #header.header-sticky' => 'background: {{VALUE}} !important;',                  
                ],
            ]
        );

        $element->add_responsive_control( 
			'navigation_height',
			[
				'label' => esc_html__( 'Height Header', 'autodeal' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  #mainnav > ul > li > a, {{WRAPPER}} #header .show-search, {{WRAPPER}} header .block a, {{WRAPPER}} #header .mini-cart-header .cart-count, {{WRAPPER}} #header .mini-cart .cart-count, {{WRAPPER}} .button-menu' => 'line-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

        $element->add_control(
            'site_logo',
            [
                'label'   => esc_html__( 'Custom Logo', 'autodeal' ),
                'type'    => Controls_Manager::MEDIA,
            ]
        );

        $element->add_responsive_control( 
			'width_logo',
			[
				'label' => esc_html__( 'Logo Size', 'autodeal' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  #header #logo a img' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

        $element->add_control(
            'site_logo_fixed',
            [
                'label'   => esc_html__( 'Custom Logo Fixed', 'autodeal' ),
                'type'    => Controls_Manager::MEDIA,
            ]
        );

        $element->add_control(
            'text_header_color_fixed',
            [
                'label' => esc_html__( 'Text Color Header Fixed', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #header.fixed-show .header-infor-phone .content a, {{WRAPPER}} #header.fixed-show .header-infor-phone .content p, {{WRAPPER}} #header.fixed-show .header-infor-phone .icon, {{WRAPPER}} #header.fixed-show #mainnav > ul > li > a, {{WRAPPER}} #header.fixed-show .show-search a, {{WRAPPER}} #header.fixed-show .phone-header-box .inner, {{WRAPPER}} #header.fixed-show .widget_login_menu_widget .user-dropdown .user-display-name.dropdown-toggle::after, {{WRAPPER}} #header.fixed-show:not(.header-sticky) .themesflat-socials li a, {{WRAPPER}} #header.fixed-show .show-search a, {{WRAPPER}} #header.fixed-show .widget_login_menu_widget .user-dropdown .user-display-name span.display-name, {{WRAPPER}} #header.fixed-show .header-ct-right .icon-login * , {{WRAPPER}} #header.fixed-show .header-ct-right .login-header::before, {{WRAPPER}} #header.fixed-show .header-ct-right .login-header ul li:not(:last-child)::after, {{WRAPPER}} #header.fixed-show .header-ct-right .login-header * ,  {{WRAPPER}} #header.fixed-show .tfcl-header-favorite' => 'color: {{VALUE}};',                  
                    '{{WRAPPER}} #header.fixed-show .btn-menu span, {{WRAPPER}} #header.fixed-show .btn-menu:before, {{WRAPPER}} #header.fixed-show .btn-menu:after' => 'background: var(--theme-primary-color);',                  
                ],
            ]
        );

        //Extra Classes Header
        $element->add_control(
            'extra_classes_header',
            [
                'label'   => esc_html__( 'Extra Classes', 'autodeal' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $element->end_controls_section();
    }

    public function themesflat_options_page_pagetitle($element) {
        // TF Page Title
        $element->start_controls_section(
            'themesflat_pagetitle_options',
            [
                'label' => esc_html__('TF Page Title', 'autodeal'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );       

        $element->add_control(
            'hide_pagetitle',
            [
                'label'     => esc_html__( 'Hide Page Title', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'autodeal'),
                    'block'      => esc_html__( 'No', 'autodeal'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} .page-title' => 'display: {{VALUE}};',
                ],
            ]
        ); 

        $element->add_control(
            'hide_heading_title',
            [
                'label'     => esc_html__( 'Hide Heading Title', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'autodeal'),
                    'block'      => esc_html__( 'No', 'autodeal'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} .page-title .inner-heading ' => 'display: {{VALUE}};',
                ],
            ]
        ); 

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'pagetitle_bg',
                'label' => esc_html__( 'Background', 'autodeal' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .page-title',
                'condition' => [ 'hide_pagetitle' => 'block' ]
            ]
        );

        $element->add_control(
            'pagetitle_overlay_color',
            [
                'label' => esc_html__( 'Overlay Color', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .page-title .overlay' => 'background: {{VALUE}}; opacity: 100%;filter: alpha(opacity=100);',
                ],
                'condition' => [ 'hide_pagetitle' => 'block' ]
            ]
        );

        //Extra Classes Page Title
        $element->add_control(
            'extra_classes_pagetitle',
            [
                'label'   => esc_html__( 'Extra Classes', 'autodeal' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $element->end_controls_section();
    }

    public function themesflat_options_page_footer($element) {
        // TF Footer
        $element->start_controls_section(
            'themesflat_footer_options',
            [
                'label' => esc_html__('TF Footer', 'autodeal'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $element->add_control(
            'footer_heading',
            [
                'label'     => esc_html__( 'Footer', 'autodeal'),
                'type'      => Controls_Manager::HEADING,
            ]
        );       

        $element->add_control(
            'hide_footer',
            [
                'label'     => esc_html__( 'Hide Footer', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'autodeal'),
                    'block'      => esc_html__( 'No', 'autodeal'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} #footer' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .footer-information-icon-box' => 'display: {{VALUE}};' 
                ],
            ]
        );

        $element->add_responsive_control(
            'footer_padding',
            [
                'label' => esc_html__( 'Padding', 'autodeal' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} #footer' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );
        $element->add_responsive_control(
            'footer_margin',
            [
                'label' => esc_html__( 'margin', 'autodeal' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .footer_background ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'footer_bg',
                'label' => esc_html__( 'Background', 'autodeal' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .footer_background .overlay-footer',
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );

        $element->add_control(
            'footer_bg_overlay',
            [
                'label' => esc_html__( 'Background Overlay', 'autodeal' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .footer_background' => 'background-color: {{VALUE}}',
                ],
                'condition' => [ 'hide_footer' => 'block' ]
            ]
        );

        // Bottom
        $element->add_control(
            'bottom_heading',
            [
                'label'     => esc_html__( 'Bottom', 'autodeal'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $element->add_control(
            'hide_bottom',
            [
                'label'     => esc_html__( 'Hide?', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    'none'       => esc_html__( 'Yes', 'autodeal'),
                    'block'      => esc_html__( 'No', 'autodeal'),
                ],
                'selectors'  => [
                    '{{WRAPPER}} #bottom' => 'display: {{VALUE}};' 
                ],
            ]
        );

        //Extra Classes Footer
        $element->add_control(
            'extra_classes_footer',
            [
                'label'   => esc_html__( 'Extra Classes', 'autodeal' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $element->end_controls_section();
    }

    public function themesflat_options_page($element) {
        // TF Page
        $element->start_controls_section(
            'themesflat_page_options',
            [
                'label' => esc_html__('TF Page', 'autodeal'),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );

        $element->add_control(
            'page_sidebar_layout',
            [
                'label'     => esc_html__( 'Sidebar Position', 'autodeal'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    '' => esc_html__( 'No Sidebar', 'autodeal'),
                    'sidebar-right'     => esc_html__( 'Sidebar Right','autodeal' ),
                    'sidebar-left'      =>  esc_html__( 'Sidebar Left','autodeal' ),
                    'fullwidth'         =>   esc_html__( 'Full Width','autodeal' ),
                    'fullwidth-small'   =>   esc_html__( 'Full Width Small','autodeal' ),
                    'fullwidth-center'  =>   esc_html__( 'Full Width Center','autodeal' ),
                ],
            ]
        );

        $element->add_control(
            'main_content_heading',
            [
                'label'     => esc_html__( 'Main Content', 'autodeal'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $element->add_responsive_control(
            'main_content_padding',
            [
                'label' => esc_html__( 'Padding', 'autodeal' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} #themesflat-content' => 'padding-top: {{TOP}}{{UNIT}} !important; padding-bottom: {{BOTTOM}}{{UNIT}} !important;',
                ],
            ]
        ); 

        $element->add_responsive_control(
            'main_content_margin',
            [
                'label' => esc_html__( 'Margin', 'autodeal' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} #themesflat-content' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        //Extra Classes Page Title
        $element->add_control(
            'extra_classes_page',
            [
                'label'   => esc_html__( 'Extra Classes', 'autodeal' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'separator' => 'before'
            ]
        );

        $element->end_controls_section();
    }
}

new themesflat_options_elementor();