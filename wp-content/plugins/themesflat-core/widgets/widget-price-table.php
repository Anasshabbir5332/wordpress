<?php
class TFPriceTable_Widget extends \Elementor\Widget_Base {

  public function get_name() {
        return 'tf-pricetable';
    }
    
    public function get_title() {
        return esc_html__( 'TF Price Table', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }

    public function get_style_depends() {
        return ['tf-pricetable'];
    }

    protected function register_controls() {
        // Start Price Table Header  
            $this->start_controls_section( 
                'section_price_header',
                [
                    'label' => esc_html__('Header', 'themesflat-core'),
                ]
            );

            $this->add_control(
                'active',
                [
                    'label' => esc_html__( 'Active', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'noactive',
                    'options' => [
                        'noactive'  => esc_html__( 'No', 'themesflat-core' ),
                        'setactive' => esc_html__( 'Yes', 'themesflat-core' ),
                    ],
                ]
            );

            $this->add_control(
                'price',
                [
                    'label' => esc_html__( 'Price', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( '40', 'themesflat-core' ),
                ]
            );

            $this->add_control(
                'price_type',
                [
                    'label' => esc_html__( 'Price Type', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( '$', 'themesflat-core' ),
                ]
            );

            $this->add_control(
                'time',
                [
                    'label' => esc_html__( 'Time', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( '/Mth', 'themesflat-core' ),
                ]
            );

            $this->add_control(
                'badge',
                [
                    'label' => esc_html__( 'Badge', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Recommended', 'themesflat-core' ),
                ]
            );

            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Standard', 'themesflat-core' ),
                ]
            );

            $this->add_control(
                'subtitle',
                [
                    'label' => esc_html__( 'Sub Title', 'themesflat-core' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Save 29% on First Year', 'themesflat-core' ),
                ]
            );
            
            $this->end_controls_section();
        // /.End Price Table Header

        // Start Price Table Content  
            $this->start_controls_section( 
                'section_price_content',
                [
                    'label' => esc_html__('Content', 'themesflat-core'),
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'item',
                [
                    'label' => esc_html__( 'Item', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                ]
            );

            $repeater->add_control(
                'icon',
                [
                    'label' => esc_html__( 'Icon', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'icon-autodeal-icon-144',
                        'library' => 'theme_icon',
                    ],
                ]
            );

            $repeater->add_control(
                'icon_color',
                [
                    'label' => esc_html__( 'Icon Color', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .wrap-icon i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} {{CURRENT_ITEM}} .wrap-icon svg' => 'fill: {{VALUE}}',
                    ],
                ]
            );       
            
            $repeater->add_control(
                'icon_color_bg',
                [
                    'label' => esc_html__( 'Icon Background Color', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .wrap-icon' => 'background: {{VALUE}};border-color: {{VALUE}}',
                    ],
                ]
            );

            $repeater->add_control(
                'text',
                [
                    'label' => esc_html__( 'Text', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Content price', 'tf-addon-for-elementer' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'text_color',
                [
                    'label' => esc_html__( 'Text Color', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .text' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'items',
                [
                    'label' => esc_html__( 'Items', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'show_label' => true,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [   
                            'text' => esc_html__( 'Listing free', 'tf-addon-for-elementer' ),
                        ],
                        [   
                            'text' => esc_html__( 'Support 24/7', 'tf-addon-for-elementer' ),
                        ],
                        [   
                            'text' => esc_html__( 'Quick access to customers', 'tf-addon-for-elementer' ),
                        ],
                        [   
                            'text' => esc_html__( 'Auto refresh ads', 'tf-addon-for-elementer' ),
                        ],
                    ],
                    'title_field' => '{{{ text }}}',
                ]
            );            

            $this->end_controls_section();
        // /.End Price Table Content

        // Start Price Table Button  
            $this->start_controls_section( 
                'section_price_button',
                [
                    'label' => esc_html__('Button', 'themesflat-core'),
                ]
            );
            $this->add_control(
                'button_text',
                [
                    'label' => esc_html__( 'Button Text', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Get started', 'tf-addon-for-elementer' ),
                ]
            );

            $this->add_control(
                'post_icon_readmore',
                [
                    'label' => esc_html__( 'Post Icon ', 'autodeal' ),
                    'type' => \Elementor\Controls_Manager::ICONS,
                ]
            );

            $this->add_control(
                'link',
                [
                    'label' => esc_html__( 'Link', 'tf-addon-for-elementer' ),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', 'tf-addon-for-elementer' ),
                    'default' => [
                        'url' => '#',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ]
            );
            $this->end_controls_section();
        // /.End Price Table Button


    }

    protected function render($instance = []) {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'tf_pricetable', ['id' => "tf-pricetable-{$this->get_id()}", 'class' => ['tf-pricetable', $settings['active']],  'data-tabid' => $this->get_id()] );  

        $header = $content = $button = $subtitle = $subtitle2  = $icon =  $item_list = $number_order = $time = '';

        foreach ( $settings['items'] as $index => $item ) {
            $item_list .= '<div class="item elementor-repeater-item-' . $item['_id'] . '">
                            <span class="wrap-icon">'.\Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $item['icon'] ).'</span>
                            <span class="text">'.$item['text'].'</span>
                        </div>';
        }
        $post_icon_readmore = \Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $settings['post_icon_readmore'], [ 'aria-hidden' => 'true' ] );
        $price_type = $settings['price_type'] ? '<span class="price-type">'.$settings['price_type'].'</span>' : '';
        $price = $settings['price'] ? '<span class="price">'.$settings['price'].'</span>' : '0';
        $title = $settings['title'] ? '<div class="title">'.$settings['title'].'</div>' : '';
        $badge = $settings['badge'] ? '<div class="badge-table"><span>'.$settings['badge'].'</span></div>' : '';
       
        $time = '<span class="time">'.$settings['time'].'</span>';

        if (!empty($settings['subtitle'])) {
            $subtitle = '<h4 class="subtitle">'.$settings['subtitle'].'</h4>';
        }    

        if (!empty($settings['subtitle2'])) {
            $subtitle2 = '<h4 class="subtitle2">'.$settings['subtitle2'].'</h4>';
        } 

        $header = sprintf( '<div class="header-price">
                                 %1$s
                                 %5$s 
                                <div class="content-price"> %4$s %2$s %3$s</div>
                            </div>',$title,$price,$time,$price_type,$subtitle);

        $content = sprintf( '<div class="content-list">
                                <div class="inner-content-list">%1$s</div>
                            </div>',$item_list);

        $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
        $button = sprintf( '<div class="wrap-button">
                                <a href="%2$s" class="tf-btn" %3$s %4$s> <span>%1$s</span>  %5$s</a>
                            </div>',$settings['button_text'], $settings['link']['url'], $target, $nofollow, $post_icon_readmore);

            echo sprintf ( 
                '
                <div %1$s>  
                    %5$s
                    %2$s
                    %3$s
                    %4$s
                </div>',
                    $this->get_render_attribute_string('tf_pricetable'),
                    $header,
                    $content,
                    $button,
                    $badge

            );
    }

}