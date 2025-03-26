<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor_Widget_Addon class.
 *
 * The main class that initiates and runs the addon.
 *
 * @since 1.0.0
 */
final class TF_Elementor_Widget_Addon {

	/**
	 * Addon Version
	 *
	 * @since 1.0.0
	 * @var string The addon version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the addon.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.7.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the addon.
	 */
	const MINIMUM_PHP_VERSION = '5.2';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 * @var \Elementor_Test_Addon\Elementor_Widget_Addon The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return \Elementor_Test_Addon\Elementor_Widget_Addon An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ], 100 );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ], 100 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ], 100 );
	}

	/**
	 * Compatibility Checks
	 *
	 * Checks whether the site meets the addon requirement.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) )
			unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'tf-car-listing' ),
			'<strong>' . esc_html__( 'Themesflat Addons For Elementor', 'tf-car-listing' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'tf-car-listing' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) )
			unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'tf-car-listing' ),
			'<strong>' . esc_html__( 'Themesflat Addons For Elementor', 'tf-car-listing' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'tf-car-listing' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) )
			unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'tf-car-listing' ),
			'<strong>' . esc_html__( 'Themesflat Addons For Elementor', 'tf-car-listing' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'tf-car-listing' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Initialize
	 *
	 * Load the addons functionality only after Elementor is initialized.
	 *
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		add_action( 'elementor/elements/categories_registered', function () {
			$elementsManager = \Elementor\Plugin::instance()->elements_manager;
			$elementsManager->add_category(
				'themesflat_car_listing_addons',
				array(
					'title' => 'Themesflat Car Listing Addons',
					'icon'  => 'fonts',
				) );
		} );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// tab listing ajax
		add_action( 'wp_ajax_tfcl_get_listing_by_taxonomy', [ $this, 'tfcl_get_listing_by_taxonomy' ], 100 );
		add_action( 'wp_ajax_nopriv_tfcl_get_listing_by_taxonomy', [ $this, 'tfcl_get_listing_by_taxonomy' ], 100 );
	}

	public function widget_scripts() {
		// 3rd
		wp_register_script( 'owl-carousel', TF_PLUGIN_URL . 'public/assets/third-party/owl-carousel/owl.carousel.min.js', [ 'jquery' ], false, true );
		wp_enqueue_script( 'magnific-popup', TF_PLUGIN_URL . 'public/assets/third-party/magnific-popup/jquery.magnific-popup.min.js', [ 'jquery' ], false, true );
		wp_register_script( 'swiper-min-script', TF_PLUGIN_URL . 'public/assets/third-party/swiper/swiper-bundle.min.js', [ 'jquery' ], false, true );
		// widget
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'slider-listing', TF_PLUGIN_URL . 'includes/elementor-widget/assets/js/slider-listing.js', array( 'jquery' ), false, true );
		wp_register_script( 'listing-script', TF_PLUGIN_URL . 'includes/elementor-widget/assets/js/listing.js', array( 'jquery' ), false, true );
		wp_register_script( 'taxonomy-script', TF_PLUGIN_URL . 'includes/elementor-widget/assets/js/taxonomy.js', array( 'jquery' ), false, true );
		wp_register_script( 'compare-listing', TF_PLUGIN_URL . 'includes/elementor-widget/assets/js/compare-listing.js', array( 'jquery' ), false, true );
		$tf_listing_vars = array(
			'ajax_url'   => TF_AJAX_URL,
			'ajax_nonce' => wp_create_nonce( 'nonce_filter_listing' ),
		);
		wp_localize_script( 'listing-script', 'tf_listing_vars', $tf_listing_vars );
		wp_register_script( 'seller-script', TF_PLUGIN_URL . 'includes/elementor-widget/assets/js/seller.js', array( 'jquery' ), false, true );
		wp_register_script( 'search-script', TF_PLUGIN_URL . 'includes/elementor-widget/assets/js/search.js', array( 'jquery' ), false, true );

		$tfcl_listing_advanced_search_vars = array(
			'ajaxUrl'     => TF_AJAX_URL,
			'inElementor' => true,
		);

		wp_register_script( 'search-listing-script', TF_PLUGIN_URL . 'public/assets/js/advanced-search.js', array( 'jquery' ), false, true );
		wp_localize_script( 'search-listing-script', 'advancedSearchVars', $tfcl_listing_advanced_search_vars );
	}

	public function widget_styles() {

		// 3rd
		wp_register_style( 'owl-carousel', TF_PLUGIN_URL . 'public/assets/third-party/owl-carousel/owl.carousel.min.css' );
		wp_enqueue_style( 'magnific-popup', TF_PLUGIN_URL . 'public/assets/third-party/magnific-popup/magnific-popup.min.css' );
		wp_register_style( 'swiper-min-style', TF_PLUGIN_URL . 'public/assets/third-party/swiper/swiper-bundle.min.css' );
		// widget
		wp_register_style( 'listing-styles', TF_PLUGIN_URL . 'includes/elementor-widget/assets/css/listing.css' );
		wp_register_style( 'slider-listing', TF_PLUGIN_URL . 'includes/elementor-widget/assets/css/slider-listing.css' );
		wp_register_style( 'listing-taxonomy-style', TF_PLUGIN_URL . 'includes/elementor-widget/assets/css/taxonomy.css' );
		wp_register_style( 'seller-styles', TF_PLUGIN_URL . 'includes/elementor-widget/assets/css/seller.css' );
		wp_register_style( 'search-style', TF_PLUGIN_URL . 'includes/elementor-widget/assets/css/search.css' );
		wp_register_style( 'compare-listing', TF_PLUGIN_URL . 'includes/elementor-widget/assets/css/compare-listing.css' );
	}


	public function admin_scripts() {
		wp_enqueue_style( 'select2_css', TF_PLUGIN_URL . 'public/assets/third-party/select2/css/select2.min.css', array(), null, 'all' );
		wp_enqueue_script( 'select2_js', TF_PLUGIN_URL . 'public/assets/third-party/select2/js/select2.full.min.js', array( 'jquery' ), null, true );
	}

	/**
	 * Register Widgets
	 *
	 * Load widgets files and register new Elementor widgets.
	 *
	 * Fired by `elementor/widgets/register` action hook.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-listing.php' );
		$widgets_manager->register( new Widget_Listing() );
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-taxonomy.php' );
		$widgets_manager->register( new Widget_Taxonomy() );
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-seller.php' );
		$widgets_manager->register( new Widget_Seller() );
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-search.php' );
		$widgets_manager->register( new Widget_Advanced_Search() );
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-single-listing.php' );
		$widgets_manager->register( new Widget_Single_Listing() );
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-compare.php' );
		$widgets_manager->register( new Widget_Compare_Listing() );
		require_once( TF_PLUGIN_PATH . '/includes/elementor-widget/widgets/widget-slider-listing.php' );
		$widgets_manager->register( new Widget_Slider_Listing() );
	}

	public function tfcl_get_listing_by_taxonomy() {
		$listing_slug = $_POST['listing_slug'];
		$price_min = $_POST['price_min'];
		$price_max = $_POST['price_max'];
		$listing_per_page = $_POST['listing_per_page'];
		$taxonomy_list = $_POST['taxonomy_list'];
		$style = $_POST['style'];

		$settings['show_counter'] = isset( $_POST['show_counter'] ) ? $_POST['show_counter'] : 'yes';
		$settings['show_year'] =  isset( $_POST['show_year'] ) ? $_POST['show_year'] : 'yes';
		$settings['enable_compare_listing'] =  isset( $_POST['enable_compare_listing'] ) ? $_POST['enable_compare_listing'] : 'yes';
		$settings['enable_favorite_listing'] =  isset( $_POST['enable_favorite_listing'] ) ? $_POST['enable_favorite_listing'] : 'yes';
		$settings['swiper_image_box'] = isset( $_POST['swiper_image_box'] ) ? $_POST['swiper_image_box'] : 'yes';
		$settings['limit_swiper_images'] = isset( $_POST['limit_swiper_images'] ) ? $_POST['limit_swiper_images'] : 3;
		$settings['show_mileages'] =  isset( $_POST['show_mileages'] ) ? $_POST['show_mileages'] : 'yes';
		$settings['show_type_fuel'] = isset( $_POST['show_type_fuel'] ) ? $_POST['show_type_fuel'] : 'yes';
		$settings['show_transmission'] = isset( $_POST['show_transmission'] ) ? $_POST['show_transmission'] : 'yes';
		$settings['show_make'] = isset( $_POST['show_make'] ) ? $_POST['show_make'] : 'yes';
		$settings['show_model'] = isset( $_POST['show_model'] ) ? $_POST['show_model'] : 'yes';
		$settings['show_body'] = isset( $_POST['show_body'] ) ? $_POST['show_body'] : 'yes';
		$settings['show_stock_number'] = isset( $_POST['show_stock_number'] ) ? $_POST['show_stock_number'] : 'yes';
		$settings['show_vin_number'] = isset( $_POST['show_vin_number'] ) ? $_POST['show_vin_number'] : 'yes';
		$settings['show_drive_type'] = isset( $_POST['show_drive_type'] ) ? $_POST['show_drive_type'] : 'yes';
		$settings['show_engine_size'] = isset( $_POST['show_engine_size'] ) ? $_POST['show_engine_size'] : 'yes';
		$settings['show_cylinders'] = isset( $_POST['show_cylinders'] ) ? $_POST['show_cylinders'] : 'yes';
		$settings['show_door'] = isset( $_POST['show_door'] ) ? $_POST['show_door'] : 'yes';
		$settings['show_color'] = isset( $_POST['show_color'] ) ? $_POST['show_color'] : 'yes';
		$settings['show_seat'] = isset( $_POST['show_seat'] ) ? $_POST['show_seat'] : 'yes';
		$settings['show_city_mpg'] = isset( $_POST['show_city_mpg'] ) ? $_POST['show_city_mpg'] : 'yes';
		$settings['show_highway_mpg'] = isset( $_POST['show_highway_mpg'] ) ? $_POST['show_highway_mpg'] : 'yes';
		$settings['button_text'] = isset( $_POST['button_text'] ) ? $_POST['button_text'] : 'View car';

		$settings['order_by'] = isset( $_POST['order_by'] ) ? $_POST['order_by'] : 'date';
		$settings['order'] = isset( $_POST['order'] ) ? $_POST['order'] : 'desc';

		if ($listing_slug == 'all') {
			$args_tab_tax          = array(
				'post_type'      => 'listing',
				'post_status'    => 'publish',
				'posts_per_page' => $listing_per_page ,				
			);			
		} else if (isset($price_min) ||isset($price_max) ) {
				$args_tab_tax          = array(
					'post_type'      => 'listing',
					'post_status'    => 'publish',
					'posts_per_page' => $listing_per_page ,	
					'meta_query' => [
						[
							'key' => 'regular_price',
							'value' => [$price_min, $price_max],
							'compare' => 'BETWEEN',
							'type' => 'numeric',
						]
					],
				);
			} else {
				$args_tab_tax          = array(
					'post_type'      => 'listing',
					'post_status'    => 'publish',
					'posts_per_page' => $listing_per_page ,
					'tax_query'      => array(
						array(
							'taxonomy' => $taxonomy_list,
							'field'    => 'slug',
							'terms'    => $listing_slug
						)
					),
				);
		}
		

		

		$args_tab_tax['orderby'] = $settings['order_by'];
		$args_tab_tax['order']   = $settings['order'];

		$query_listing_tab_tax = new WP_Query( $args_tab_tax );

		ob_start();
		while ( $query_listing_tab_tax->have_posts() ) :
			$query_listing_tab_tax->the_post(); 
			tf_get_template_widget_elementor( "templates/listing/{$style}",array(
				        'settings' => $settings,
				    ));
		endwhile;
		wp_reset_postdata(); 		
		$content = ob_get_contents();
		ob_get_clean();

		$response['content'] = $content;
		echo json_encode( $response );
		wp_die();
	}
}