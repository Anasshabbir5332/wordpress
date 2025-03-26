<?php 
if(!function_exists('flat_get_post_page_content')){
    function flat_get_post_page_content( $slug ) {
        $content_post = get_posts(array(
            'name' => $slug,
            'posts_per_page' => 1,
            'post_type' => 'elementor_library',
            'post_status' => 'publish'
        ));
        if (array_key_exists(0, $content_post) == true) {
            $id = $content_post[0]->ID;
            return $id;
        }
    }
}

if(!function_exists('tf_header_enabled')){
    function tf_header_enabled() {
        $header_id = ThemesFlat_Addon_For_Elementor_autodeal::get_settings( 'type_header', '' );
        $status    = false;

        if ( '' !== $header_id ) {
            $status = true;
        }

        return apply_filters( 'tf_header_enabled', $status );
    }
}

if(!function_exists('tf_footer_enabled')){
    function tf_footer_enabled() {
        $header_id = ThemesFlat_Addon_For_Elementor_autodeal::get_settings( 'type_footer', '' );
        $status    = false;

        if ( '' !== $header_id ) {
            $status = true;
        }

        return apply_filters( 'tf_footer_enabled', $status );
    }
}

if(!function_exists('get_header_content')){
    function get_header_content() {
        $tf_get_header_id = ThemesFlat_Addon_For_Elementor_autodeal::tf_get_header_id();
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tf_get_header_id);
    }
}

if(!function_exists('tf_get_template_widget')){
    function tf_get_template_widget($template_name, $args = null, $return = false){
        $template_file = $template_name . '.php';
        $default_folder = plugin_dir_path(__FILE__) . 'templates/';
        $theme_folder = apply_filters('tf_templates_folder', dirname(plugin_basename(__FILE__)));
        $template = locate_template($theme_folder . '/' . $template_file);
        if (!$template) {
            $template = $default_folder . $template_file;
        }
        if ($args && is_array($args)) {
            extract($args);
        }
        if ($return) {
            ob_start();
        }
        if (file_exists($template)) {
            include $template;
        }
        if ($return) {
            return ob_get_clean();
        }
        return null;
    }
}

// Hide render sidebar container css
remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );
remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );

add_filter( 'render_block', function( $block_content, $block ) {
    if ( $block['blockName'] === 'core/group' ) {
        return $block_content;
    }

    return wp_render_layout_support_flag( $block_content, $block );
}, 10, 2 );

/* Custom Pagination Shortcodes
===================================*/
function themesflat_pagination_posttype( $query = '' , $paging_style = '' ) {    
    $prev_arrow = 'icon-autodeal-angle-left';
    $next_arrow = 'icon-autodeal-angle-right';
    
    // Get global $query
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    $post_type = $query->query["post_type"];

    // Set vars
    $total  = $query->max_num_pages;
    $big    = 999999999;

    // Display pagination
    if ( $total > 1 ) {

        // Get current page
        if ( $current_page = get_query_var( 'paged' ) ) {
            $current_page = $current_page;
        } elseif ( $current_page = get_query_var( 'page' ) ) {
            $current_page = $current_page;
        } else {
            $current_page = 1;
        }

        // Get permalink structure
        if ( get_option( 'permalink_structure' ) ) {
            if ( is_page() ) {
                $format = 'page/%#%/';
            } else {
                $format = '/%#%/';
            }
        } else {
            $format = '&paged=%#%';
        }

        $links = array(
            'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
            'format'    => $format,
            'current'   => max( 1, $current_page ),
            'total'     => $total,
            'mid_size'  => 3,
            'prev_text' => '<i class="'. $prev_arrow .'"></i>',
            'next_text' => '<i class="'. $next_arrow .'"></i>',
        );
        $more_link = get_next_posts_link( esc_html__('Load More','themesflat'), $query->max_num_pages );

        // Output pagination        
        ?>
            <nav class="navigation  paging-navigation pager-numeric <?php echo esc_attr($post_type); ?>" role="navigation">
                <div class="pagination loop-pagination">
                    <?php echo paginate_links( $links ); ?>
                </div>
            </nav>
    <?php
    }
}
