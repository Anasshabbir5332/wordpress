<?php 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * get all listing of current author
 */
$author_id = get_the_author_meta('ID');
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$post_per_page = tfcl_get_option('item_per_page_archive_listing');

$args = array(
    'post_type'       => 'listing',
    'post_status'     => 'publish',
    'posts_per_page'  => $post_per_page,
    'author'          => $author_id,
    'offset' => (max(1, get_query_var('paged')) - 1) * $post_per_page,
    'paged'           => $paged
);

$selected_order   = wp_unslash(isset($_GET['orderBy']) ? sanitize_text_field(wp_unslash($_GET['orderBy'])) : '');

switch ($selected_order) {
    case 'name_asc':
        $args['orderby'] = 'name';
        $args['order'] = 'asc';
        break;
    case 'name_desc':
        $args['orderby'] = 'name';
        $args['order'] = 'desc';
        break;
    case 'latest':
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    default:
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
}

$query = new WP_Query( $args );

$css_class_col = 'col-lg-3 col-md-6';

$list_order      = array(
    'default'    => esc_html__('Sort by (Defaut)', 'tf-car-listing'),
    'latest'     => esc_html__('Sort by latest', 'tf-car-listing'),
    'name_desc'  => esc_html__('Sort by name (A-Z)','tf-car-listing'),
    'name_asc'   => esc_html__( 'Sort by name (Z-A)','tf-car-listing' )
);

$max_num_pages = $query->max_num_pages;

tfcl_get_template_with_arguments('listing/listing-list-grid-view.php',array(
    'query'           => $query,   
    'list_order'      => $list_order, 
    'max_num_pages'   => $max_num_pages,
    'css_class_col'   => $css_class_col
));