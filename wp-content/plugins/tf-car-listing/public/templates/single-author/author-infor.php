<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$author_id                       = get_the_author_meta( 'ID' );
$author_meta_data                = get_user_meta( $author_id );
$custom_author_image_size_single = tfcl_get_option( 'custom_author_image_size_single', '110x110' );
$author_full_name                = get_user_meta( $author_id, 'first_name', true ) . ' ' . get_user_meta( $author_id, 'last_name', true );
if ( empty( $author_full_name ) ) {
	$author_full_name = get_the_author_meta( 'user_login', $author_id );
}
$user_facebook       = get_the_author_meta( 'user_facebook', $author_id );
$user_twitter       = get_the_author_meta( 'user_twitter', $author_id );
$user_linkedin       = get_the_author_meta( 'user_linkedin', $author_id );
$user_instagram       = get_the_author_meta( 'user_instagram', $author_id );
$user_dribble       = get_the_author_meta( 'user_dribble', $author_id );
$user_skype       = get_the_author_meta( 'user_skype', $author_id );
$author_email       = get_the_author_meta( 'user_email', $author_id );
$author_phone       = get_the_author_meta( 'user_phone', $author_id );
$author_sales_phone = get_the_author_meta( 'user_sales_phone', $author_id );
$author_position    = get_the_author_meta( 'user_position', $author_id );
$author_description = get_user_meta( $author_id, 'user_description', true );
$formatted_phone    = ! empty( $author_sales_phone ) ? substr( $author_sales_phone, 0, 2 ) . str_repeat( '*', strlen( $author_sales_phone ) - 2 ) : '';
$location           = get_the_author_meta( 'user_location', $author_id );
$sales_hour         = get_the_author_meta( 'user_sales_hour', $author_id );
$is_dealer          = tfcl_is_dealer( $author_id );
$basic_info         = array();

if ( ! empty( $author_sales_phone ) ) {
	$basic_info['author_sales_phone'] = [ 
		'content'    => [ 
			'icon'  => 'icon-autodeal-phone',
			'label' => 'Sales Phone',
			'value' => $formatted_phone
		],
		'fullnumber' => $author_sales_phone
	];
}

if ( ! empty( $location ) ) {
	$basic_info['author_location'] = [ 
		'content' => [ 
			'icon'  => 'icon-autodeal-pin1',
			'label' => 'Location',
			'value' => $location
		]
	];
}

if ( ! empty( $author_email ) ) {
	$basic_info['author_email'] = [ 
		'content' => [ 
			'icon'  => 'icon-autodeal-email2',
			'label' => $is_dealer ? esc_html__( 'Seller Email', 'tf-car-listing' ) : esc_html__( 'Author Email', 'tf-car-listing' ),
			'value' => sprintf(
				'<a href="mailto:%s">%s</a>',
				esc_attr( $author_email ),
				esc_html( $author_email )
			)
		]
	];
}

if ( ! empty( $sales_hour ) ) {
	$basic_info['sales_hour'] = [ 
		'content' => [ 
			'icon'  => 'icon-autodeal-hours',
			'label' => 'Sales hour',
			'value' => $sales_hour
		]
	];
}

$avatar_id      = get_user_meta( $author_id, 'profile_image_id', true );
$no_avatar      = get_avatar_url( $author_id );
$width          = 500;
$height         = 500;
$no_avatar_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
$default_avatar = tfcl_get_option( 'default_user_avatar', '' );

if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
	$no_avatar_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
} else {
	$no_avatar_src = $no_avatar;
}
$avatar_src = tfcl_image_resize_id( $avatar_id, $width, $height, true );
?>
<div class="single-author-element author-single">
	<div class="author-single-inner">
		<div class="author-single-header-info">
				<div class="author-avatar">
					<img loading="lazy" width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>"
						src="<?php echo esc_url( $avatar_src ) ?>"
						onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';"
						alt="<?php echo esc_attr( $author_full_name ) ?>"
						title="<?php echo esc_attr( $author_full_name ) ?>">
				</div>
                <div class="author-title">
                    <h2 class="author-name"><?php echo esc_html($author_full_name); ?></h2>
					<p class="description">
						<?php if ( ! empty( $author_description ) ) : ?>
							<?php echo esc_html( $author_description ); ?>
						<?php else : ?>
							<?php echo esc_html_e( 'No data', 'tf-car-listing' ); ?>
						<?php endif; ?>
					</p>
					<ul class="list-infor">
						<?php if ( ! empty( $author_phone ) ) : ?>
						<li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
<path d="M9.5 6.5V3.5M9.5 6.5H12.5M9.5 6.5L13.5 2.5M11.5 14.5C5.97733 14.5 1.5 10.0227 1.5 4.5V3C1.5 2.60218 1.65804 2.22064 1.93934 1.93934C2.22064 1.65804 2.60218 1.5 3 1.5H3.91467C4.25867 1.5 4.55867 1.734 4.642 2.068L5.37933 5.01667C5.45267 5.31 5.34333 5.618 5.10133 5.79867L4.23933 6.44533C4.11595 6.53465 4.02467 6.66138 3.97903 6.8067C3.93339 6.95202 3.93584 7.10818 3.986 7.252C4.38725 8.34341 5.02094 9.33456 5.84319 10.1568C6.66544 10.9791 7.65659 11.6128 8.748 12.014C9.042 12.122 9.36667 12.0113 9.55467 11.7607L10.2013 10.8987C10.2898 10.7805 10.4113 10.6911 10.5504 10.6416C10.6895 10.5922 10.8401 10.5849 10.9833 10.6207L13.932 11.358C14.2653 11.4413 14.5 11.7413 14.5 12.0853V13C14.5 13.3978 14.342 13.7794 14.0607 14.0607C13.7794 14.342 13.3978 14.5 13 14.5H11.5Z" stroke="#8E8E93" stroke-linecap="round" stroke-linejoin="round"/>
</svg><?php echo esc_html($author_phone); ?></li>
						<?php endif; ?>
						<?php if ( ! empty( $author_email ) ) : ?>
						<li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
<path d="M14.5 4.5V11.5C14.5 11.8978 14.342 12.2794 14.0607 12.5607C13.7794 12.842 13.3978 13 13 13H3C2.60218 13 2.22064 12.842 1.93934 12.5607C1.65804 12.2794 1.5 11.8978 1.5 11.5V4.5M14.5 4.5C14.5 4.10218 14.342 3.72064 14.0607 3.43934C13.7794 3.15804 13.3978 3 13 3H3C2.60218 3 2.22064 3.15804 1.93934 3.43934C1.65804 3.72064 1.5 4.10218 1.5 4.5M14.5 4.5V4.662C14.5 4.9181 14.4345 5.16994 14.3096 5.39353C14.1848 5.61712 14.0047 5.80502 13.7867 5.93933L8.78667 9.016C8.55014 9.16169 8.2778 9.23883 8 9.23883C7.7222 9.23883 7.44986 9.16169 7.21333 9.016L2.21333 5.94C1.99528 5.80569 1.81525 5.61779 1.69038 5.3942C1.56551 5.1706 1.49997 4.91876 1.5 4.66267V4.5" stroke="#8E8E93" stroke-linecap="round" stroke-linejoin="round"/>
</svg><?php echo esc_html($author_email); ?></li>
						<?php endif; ?>
					</ul>
					<ul class="list-social-author">
						<?php if ( ! empty( $user_facebook ) ) : ?>
						<li><a href="<?php echo esc_url($user_facebook); ?>"> <i class="icon-autodeal-facebook"></i> </a></li>
						<?php endif; ?>
						<?php if ( ! empty( $user_linkedin ) ) : ?>
						<li><a href="<?php echo esc_url($user_linkedin); ?>"><i class="icon-autodeal-linkedin"></i> </a></li>
						<?php endif; ?>
						<?php if ( ! empty( $user_twitter ) ) : ?>
						<li><a href="<?php echo esc_url($user_twitter); ?>"><i class="icon-autodeal-twitter"></i> </a></li>
						<?php endif; ?>
						<?php if ( ! empty( $user_instagram ) ) : ?>
						<li><a href="<?php echo esc_url($user_instagram); ?>"><i class="icon-autodeal-instagram"></i> </a></li>
						<?php endif; ?>
						<?php if ( ! empty( $user_dribble ) ) : ?>
						<li><a href="<?php echo esc_url($user_dribble); ?>"><i class="icon-autodeal-dribble"></i> </a></li>
						<?php endif; ?>
						<?php if ( ! empty( $user_skype ) ) : ?>
						<li><a href="<?php echo esc_url($user_skype); ?>"><i class="icon-autodeal-skype"></i> </a></li>
						<?php endif; ?>
					</ul>
					<?php if ( ! empty( $author_phone ) ) : ?>
					<a href="tel:<?php echo esc_attr($author_phone); ?>" class="get-quote"><?php esc_html_e( 'Get quote', 'tf-car-listing' ); ?></a>
					<?php endif; ?>
                </div>
        </div>
    </div>
</div>