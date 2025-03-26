<?php
class TFImageWithList_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return 'tf-image-list';
    }
    
    public function get_title() {
        return esc_html__( 'TF Image with List', 'themesflat-core' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }
    
    public function get_categories() {
        return [ 'themesflat_addons' ];
    }


	protected function register_controls() {
		// Start List Setting        
			$this->start_controls_section( 'section_setting',
	            [
	                'label' => esc_html__('Setting', 'themesflat-core'),
	            ]
	        );


			$this->add_control(
				'image',
				[
					'label' => esc_html__( 'Choose Image', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => URL_THEMESFLAT_ADDONS_ELEMENTOR_THEME."assets/img/placeholder.jpg",
					],
				]
			);

            $this->add_control(
				'heading',
				[
					'label' => esc_html__( 'Heading', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,					
					'default' => esc_html__( 'Chevrolet car price', 'themesflat-core' ),
					'label_block' => true,
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'thumbnail',
					'include' => [],
					'default' => 'full',
				]
			);

			$repeater = new \Elementor\Repeater();

	        $repeater->add_control(
				'text_list',
				[
					'label' => esc_html__( 'Name', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Chevrolet Colorado', 'themesflat-core' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'link',
				[
					'label' => esc_html__( 'Link', 'themesflat-core' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'themesflat-core' ),
					'default' => [
						'url' => '#',
						'is_external' => false,
						'nofollow' => false,
					],
				]
			);

			$this->add_control(
				'list',
				[
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'text_list' => esc_html__( 'Chevrolet Colorado', 'themesflat-core' ),
							'link' => '#',
						],
	
					],
				]
			);

	        
			$this->end_controls_section();
        // /.End List Setting              
	}

	protected function render($instance = []) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'tf_image_list', ['id' => "tf-image-list-{$this->get_id()}", 'class' => ['tf-image-list'], 'data-tabid' => $this->get_id()] );	
			
		?>
		<div <?php echo $this->get_render_attribute_string('tf_image_list') ?>>
			<?php
			if ($settings['image'] != '') {
					$url = esc_attr($settings['image']['url']);
					echo sprintf( '<div class="image"><img src="%1s" alt="image"></div>',$url);
			}
			?>
            <div class="content">
                <?php if (!empty($settings['heading'])) : ?>
                <h5><?php echo esc_html($settings['heading']); ?></h5>
                <?php endif; ?>
                <ul>
                    <?php foreach ( $settings['list'] as $item ): 
						$target = $item['link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
						$url = esc_attr($item['link']['url']);	
                    ?>
                        <li><a href="<?php echo $url ?>" <?php echo $target; echo $nofollow; ?>><?php echo esc_attr($item['text_list']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
	    </div>
	<?php	
	}

}