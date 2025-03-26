<?php 
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
 } elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
 } else {
    $paged = 1;
 }
$query_args = array(
    'post_type' => 'post',
    'posts_per_page' => $settings['posts_per_page'],
    'paged'     => $paged
);
if (! empty( $settings['posts_categories'] )) {
    $query_args['category_name'] = implode(',', $settings['posts_categories']);
}        
if ( ! empty( $settings['exclude'] ) ) {				
    if ( ! is_array( $settings['exclude'] ) )
        $exclude = explode( ',', $settings['exclude'] );

    $query_args['post__not_in'] = $exclude;
}
$query_args['orderby'] = $settings['order_by'];
$query_args['order'] = $settings['order'];	
$query = new WP_Query( $query_args );

?>
<?php while ( $query->have_posts() ) : $query->the_post();?>
<?php 
$get_id_post_thumbnail = get_post_thumbnail_id();
$featured_image = sprintf('<img src="%s" alt="image">', \Elementor\Group_Control_Image_Size::get_attachment_image_src( $get_id_post_thumbnail, 'thumbnail', $settings ));  
$archive_year  = get_the_time('Y'); 
$archive_month = get_the_time('m'); 
$archive_day   = get_the_time('d');
?>
<div class="item">
    <div class="entry blog-post "> 
        <?php if ( $settings['show_image'] == 'yes' ): ?>                                    
        <div class="featured-post">
            <a href="<?php echo esc_url( get_permalink() ) ?>">
                <?php echo sprintf('%s',$featured_image); ?>
                <span class="blog-plus"></span>
            </a>   
        </div>
        <?php endif; ?>
        <div class="content">
            <?php if ( $settings['show_meta'] == 'yes' ): ?> 
                <ul class="meta-post">
                    <?php if ( $settings['show_user'] == 'yes' ): ?>
                    <li class="author-post">
                        <div class="name"><?php echo get_the_author(); ?></div>
                    </li>
                    <?php endif; ?> 
                    <?php if ( $settings['show_category'] == 'yes' ): ?>
                    <li class="category-post">
                        <?php the_category( ' ' ); ?>
                    </li>
                    <?php endif; ?> 
                    <?php if ( $settings['show_date'] == 'yes' ): ?>
                    <li class="meta-date-post">
                        <?php echo get_the_date(); ?>
                    </li>  
                    <?php endif; ?> 
                </ul>
            <?php endif; ?> 
            <?php if ( $settings['show_title'] == 'yes' ): ?>
                <h3 class="title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo get_the_title(); ?></a></h3>
            <?php endif; ?>
            <?php if ( $settings['show_excerpt'] == 'yes' ): ?>
                <div class="description"><?php echo wp_trim_words( get_the_content(), $settings['excerpt_lenght'], '' ); ?></div>
            <?php endif; ?>  
            <?php if ( $settings['show_button'] == 'yes' && $settings['button_text'] != '' ): ?>
                <div class="tf-button-container">
                <a href="<?php echo esc_url( get_permalink() ) ?>" class="tf-button">
                    <span><?php echo esc_attr( $settings['button_text'] ); ?></span>
                    <?php echo \Elementor\Addon_Elementor_Icon_manager_autodeal::render_icon( $settings['post_icon_readmore'], [ 'aria-hidden' => 'true' ] );?>
                </a>
                </div>
            <?php endif; ?> 
        </div>                      
    </div>
</div>
<?php endwhile; ?>