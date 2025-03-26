<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Save_Advanced_Search' ) ) {
	class Save_Advanced_Search {

		protected $alert_message;

        public function tfcl_enqueue_styles_saved_advanced_search() {
            wp_enqueue_style('tfcl-saved-shortcode-advanced', TF_PLUGIN_URL .  'public/assets/css/shortcode-saved-advanced-search.css');
        }

        public function tfcl_my_saved_advanced_search_shortcode() {
            ob_start();
            global $wpdb, $current_user;
            wp_get_current_user();
            $user_id        = $current_user->ID;
            $query          = "SELECT * FROM {$wpdb->prefix}save_advanced_search WHERE user_id =" . $user_id;
            $total_query    = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
            $total          = $wpdb->get_var($total_query);
            $items_per_page = tfcl_get_option('item_per_page_saved_advanced_search', 10);
            $totalPage      = ceil($total / $items_per_page);
            $page           = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $offset         = ($page * $items_per_page) - $items_per_page;
            $results        = $wpdb->get_results($query . " ORDER BY id DESC LIMIT {$offset}, {$items_per_page}");
            echo $this->alert_message;
            tfcl_get_template_with_arguments(
                'advanced-search/my-saved-advanced-search.php',
                array(
                    'list_save_advanced_search' => $results,
                    'max_num_pages'             => $totalPage
                )
            );
            return ob_get_clean();
        }
		public function tfcl_save_advanced_search_ajax() {
            global $wpdb, $current_user;
            wp_get_current_user();

            $nonce = isset($_REQUEST['tfcl_save_search_nonce']) ? (wp_unslash($_REQUEST['tfcl_save_search_nonce'])) : '';
            if (!wp_verify_nonce($nonce, 'tfcl_save_search_nonce_field')) {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => esc_html__("Permission error!", 'tf-car-listing'),
                    )
                );
                wp_die();
            }
            
            $title        = isset($_REQUEST['title']) ? (wp_unslash($_REQUEST['title'])) : '';
            $parameters   = isset($_REQUEST['parameters']) ? (wp_unslash($_REQUEST['parameters'])) : '';
            $search_query = isset($_REQUEST['search_query']) ? (wp_unslash($_REQUEST['search_query'])) : '';
            $url_request  = isset($_REQUEST['url_request']) ? sanitize_url(wp_unslash($_REQUEST['url_request'])) : '';
            $table_name   = $wpdb->prefix . 'save_advanced_search';
            $wpdb->insert(
                $table_name,
                array(
                    'title'        => $title,
                    'parameters'   => $parameters,
                    'search_query' => $search_query,
                    'url_request'  => $url_request,
                    'user_id'      => $current_user->ID,
                    'user_email'   => $current_user->user_email,
                    'time_saved'   => current_time('mysql'),
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s'
                )
            );

            echo json_encode(array( 'success' => true, 'msg' => esc_html__('Save successfully', 'tf-car-listing') ));
            wp_die();
        }

		public static function tfcl_create_table_save_advanced_search() {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name      = $wpdb->prefix . 'save_advanced_search';
            $sql             = "CREATE TABLE $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
              title longtext DEFAULT '' NOT NULL,
              parameters longtext DEFAULT '' NOT NULL,
              search_query longtext NOT NULL,
              url_request longtext DEFAULT '' NOT NULL,
			  user_id mediumint(9) NOT NULL,
			  user_email longtext DEFAULT '' NOT NULL,
			  time_saved datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  PRIMARY KEY  (id)
			) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
	}
}
?>