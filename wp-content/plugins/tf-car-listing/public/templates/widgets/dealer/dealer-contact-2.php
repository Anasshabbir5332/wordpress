<?php
wp_reset_postdata();
wp_enqueue_style( 'mapbox-gl' );
wp_enqueue_script( 'mapbox-gl' );
wp_enqueue_style( 'mapbox-gl-geocoder' );
wp_enqueue_script( 'mapbox-gl-geocoder' );
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );
global $post;
$author_id  = $post->post_author;
$dealer_id  = ! empty( get_post_meta( get_the_ID(), 'listing_dealer_info', true ) ) ? get_post_meta( get_the_ID(), 'listing_dealer_info', true ) : get_the_author_meta( 'author_dealer_id', $author_id );
$dealer_meta   = get_post_meta( $dealer_id );
$poster_id     = get_post_thumbnail_id( $dealer_id );
$poster_src    = tfcl_image_resize_id( $poster_id, 100, 100, true );
$overall_rating = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_rating' )['overall_rate'];
$review_count  = tfcl_count_review_dealer( $dealer_id );
if ( isset( $dealer_id ) && ! empty( $dealer_id ) ) {
	$dealer_post_meta_data = get_post_custom( $dealer_id );
	$full_name             = get_the_title( $dealer_id );
	$email                 = isset( $dealer_post_meta_data['dealer_email'] ) ? $dealer_post_meta_data['dealer_email'][0] : '';
	$position                 = isset( $dealer_post_meta_data['dealer_position'] ) ? $dealer_post_meta_data['dealer_position'][0] : '';
	$phone                 = isset( $dealer_post_meta_data['dealer_phone_number'] ) ? $dealer_post_meta_data['dealer_phone_number'][0] : '';
	$author_id             = get_post_field( 'post_author', $dealer_id );
	$dealer_office_address = isset( $dealer_post_meta_data['dealer_office_address'] ) ? $dealer_post_meta_data['dealer_office_address'][0] : '';
	$business_hours      = isset( $dealer_post_meta_data['dealer_sales_hour'] ) ? $dealer_post_meta_data['dealer_sales_hour'][0] : '';
} else {
	$first_name = get_the_author_meta( 'first_name', $author_id );
	$last_name  = get_the_author_meta( 'last_name', $author_id );
	$position      = get_the_author_meta( 'user_position', $author_id );
	$full_name  = $first_name . ' ' . $last_name;
	$email      = get_the_author_meta( 'user_email', $author_id );
	$phone      = get_the_author_meta( 'user_phone', $author_id );
}

global $wpdb, $current_user;
	$current_user_id    = $current_user->ID;
	$list_filter_review = array( 'newest', 'oldest' );
	$orderBy            = isset( $_GET['reviewOrderby'] ) ? sanitize_text_field( $_GET['reviewOrderby'] ) : '';
	$order              = 'ASC';
	if ( $orderBy == 'newest' ) {
		$order = 'DESC';
	}
	$order          = isset( $order ) ? $order : '';
	$comments_query = $wpdb->prepare( "SELECT * FROM {$wpdb->comments}  as comment INNER JOIN {$wpdb->commentmeta} as meta WHERE  comment.comment_post_ID = %d  AND  meta.comment_id = comment.comment_ID AND (comment.comment_approved = 1) GROUP BY meta.comment_ID ORDER BY comment.comment_date " . $order, get_the_ID() );
	$get_comments   = $wpdb->get_results( $comments_query );

	// calculate for overall rating customer_service
	$customer_service_rating_info  = tfcl_cal_overall_rating_dealer( $dealer_id, 'dealer_customer_service_rating' );
	$overall_rate_customer_service = $customer_service_rating_info['overall_rate'];
	$percent_rate_customer_service = $customer_service_rating_info['percent_rate'];

?>
<div class="widget-dealer-contact ct2">
    <h2><?php echo esc_html( $full_name ); ?></h2>
    <ul class="list-authencation">
        <li><i class="icon-autodeal-icon-144"></i> <?php esc_html_e( 'Certified seller', 'tf-car-listing' ); ?> </li>
        <li><i class="icon-autodeal-icon-144"></i><?php esc_html_e( 'Verified contact', 'tf-car-listing' ); ?> </li>
    </ul>
	<?php if(!empty($business_hours) ): ?>
    	<?php echo wp_kses_post($business_hours); ?>
	<?php endif; ?>
	<div class="rating">
        <div class="content-left">
            <p><?php echo sprintf( __( '%s Reviews', 'tf-car-listing' ), count($get_comments) ); ?></p>
        </div>
        <div class="content-right">
            <div class="overall-rating-detail-star">
                                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                    <i class="star disabled-click icon-autodeal-star <?php echo esc_attr( $i <= $overall_rate_customer_service ? 'active' : '' ); ?>" data-rating="<?php echo esc_attr( $i ); ?>"></i>
                                <?php endfor; ?>
                                <span><?php echo esc_html__( number_format( $overall_rate_customer_service, 1 ) ); ?></span>
                            </div>
        </div>
    </div>
	<?php if(!empty($args['title_form_1']) ): ?>
		<a href="#" class="button-form-1"><?php echo $args['title_form_1']; ?></a>
	<?php endif; ?>
	<?php if(!empty($args['title_form_2']) ): ?>
		<a href="#" class="button-form-2"><?php echo $args['title_form_2']; ?></a>
	<?php endif; ?>
</div>