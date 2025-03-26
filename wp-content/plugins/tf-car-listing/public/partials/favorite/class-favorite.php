<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('TFCL_Favorite')) {
    class TFCL_Favorite {
        public static function tfcl_my_favorite_shortcode () {
            ob_start();
            $posts_per_page = tfcl_get_option('item_per_page_my_favorite', 8);
			global $current_user;
			wp_get_current_user();
			$user_id      = $current_user->ID;
            $my_favorites = get_user_meta( $user_id, 'favorites_listing', true );
			if ( empty( $my_favorites ) ) {
				$my_favorites = array( 0 );
			}
            
            $args = array(
                'post_type'             => 'listing',
                'post__in'              => $my_favorites,
                'ignore_sticky_posts'   => 1,
                'posts_per_page'        => $posts_per_page,
                'offset'                => ( max( 1, get_query_var( 'paged' ) ) - 1 ) * $posts_per_page,
                'orderby'               => 'date',
				'order'                 => 'desc',
            );
            $favorites = new WP_Query( $args );
            wp_reset_postdata();
            tfcl_get_template_with_arguments(
                '/favorite/my-favorite.php',
                array(
                    'favorites'     => $favorites->posts,
				    'max_num_pages' => $favorites->max_num_pages
                )
            );
            return ob_get_clean();
        }
    }
}
