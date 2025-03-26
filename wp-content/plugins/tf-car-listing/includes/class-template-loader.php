<?php

/**
 * The template loader functionality of the plugin.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Template_Loader' ) ) {
	class Template_Loader {
		private static $_instance;

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
		}

		public function is_listing_taxonomy() {
			return is_tax( get_object_taxonomies( 'listing' ) );
		}

		public function template_loader($template) {
            $file     = '';
            $file_arr = array();

            if (is_embed()) {
                return $template;
            }

            if (is_single()) {
                if (get_post_type() == 'listing') {
                    $file = 'single-listing.php';
                }
                if (get_post_type() == 'dealer') {
                    $file = 'single-dealer.php';
                }
                $file_arr[] = $file;
                $file_arr[] = TF_PLUGIN_PATH . '/public/templates/' . $file;
            } else if ($this->is_listing_taxonomy()) {
                $term = get_queried_object();
                if ( is_tax( 'condition' ) || is_tax( 'body' ) || is_tax( 'make' ) || is_tax( 'model' ) || is_tax( 'transmission' ) || is_tax( 'cylinders' ) || is_tax( 'drive-type' ) || is_tax( 'fuel-type' ) || is_tax( 'car-color' ) || is_tax( 'features-type' ) || is_tax( 'features' ) ) {
                    $file = 'taxonomy.php';
                } else {
                    $file = 'archive-listing.php';
                }
                $file_arr[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
                $file_arr[] = TF_PLUGIN_PATH . '/public/templates/' . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
                $file_arr[] = 'taxonomy-' . $term->taxonomy . '.php';
                $file_arr[] = TF_PLUGIN_PATH . '/public/templates/' . 'taxonomy-' . $term->taxonomy . '.php';
                $file_arr[] = $file;
                $file_arr[] = TF_PLUGIN_PATH . '/public/templates/' . $file;
            } else if (is_post_type_archive('listing') || is_page('listings')) {
                $map_position = tfcl_get_option('map_position');
                $file         =  'archive-listing.php';
                $file_arr[]   = $file;
                $file_arr[]   = TF_PLUGIN_PATH . '/public/templates/' . $file;
            } else if (is_post_type_archive('dealer') || is_page('dealers')) {
                $file       = 'archive-dealer.php';
                $file_arr[] = $file;
                $file_arr[] = TF_PLUGIN_PATH . '/public/templates/' . $file;
            } else if (is_author()) {
                $file       = 'author.php';
                $file_arr[] = $file;
                $file_arr[] = TF_PLUGIN_PATH . '/public/templates/' . $file;
            }

            if ($file) {
                $template = locate_template(array_unique($file_arr));
                if (!$template) {
                    $template = TF_PLUGIN_PATH . '/public/templates/' . $file;
                }
            }
            return $template;
        }
	}
}