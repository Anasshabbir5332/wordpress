<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Search_By_Filter' ) ) {
	class Search_By_Filter {

		public function tfcl_enqueue_style_search_filter() {
			wp_enqueue_style( 'tfcl-shortcode-search-filter', TF_PLUGIN_URL . 'public/assets/css/shortcode-search-filter.css' );
		}

		public function tfcl_enqueue_script_search_filter() {

		}

		public function tfcl_search_by_filter_shortcode( $atts ) {
			extract(
				shortcode_atts(
					array(
						'search_form_position' => '',
					),
					$atts
				)
			);
			ob_start();
			tfcl_get_template_with_arguments( "shortcodes/search-by-filter/search-filter.php",
				array(
					'search_form_position' => $search_form_position,
				) );
			return ob_get_clean();
		}
	}
}