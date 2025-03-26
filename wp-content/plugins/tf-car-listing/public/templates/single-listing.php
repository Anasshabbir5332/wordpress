<?php

wp_enqueue_script( 'star-rating' );
wp_enqueue_script( 'mapbox-gl' );
wp_enqueue_script( 'mapbox-gl-geocoder' );
wp_enqueue_style( 'mapbox-gl-geocoder' );
wp_enqueue_style( 'listing-css' );
wp_enqueue_style( 'mapbox-gl' );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$panels          = tfcl_get_option( 'single_listing_panels_manager' );
$listing_gallery_default              = tfcl_get_option( 'gallery_default_single');
$listing_gallery_image_type   = get_post_meta(get_the_ID(), 'gallery_image_types', true);
$single_listing_gallery_style = !empty ($listing_gallery_image_type) ? $listing_gallery_image_type : $listing_gallery_default;
get_header();
$tabs = [
	'description' => __('Description', 'tf-car-listing'),
	'overview' => __('Overview', 'tf-car-listing'),
	'features' => __('Features', 'tf-car-listing'),
	'loan-calculator' => __('Loan Calculator', 'tf-car-listing'),
	'map-location' => __('Map Location', 'tf-car-listing'),
	'review' => __('Review', 'tf-car-listing')
];
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content <?php echo esc_attr($single_listing_gallery_style); ?>">
					<?php if ($single_listing_gallery_style == 'gallery-style-slider-2' || $single_listing_gallery_style == 'gallery-style-slider-3'): ?>
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<?php do_action( 'tfcl_single_listing_summary_header' ); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($single_listing_gallery_style != 'gallery-style-slider'): ?>
					<div class="tfcl-listing-gallery-single">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">

									<?php do_action( 'tfcl_single_listing_summary_gallery' ); ?>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="container">
						<div class="row">
							<?php if ($single_listing_gallery_style != 'gallery-style-slider'): ?>
								<div class="col-md-12">
									<div class="listing-tab-item">
                            	        	<ul class="tab-item">
											<?php 
    												foreach ($tabs as $key => $label) {
    												    if (isset($panels[$key]) && $panels[$key] == 1) {
    												        echo '<li><a href="#' . esc_attr($key) . '" class="item-nav">' . esc_html($label) . '</a></li>';
    												    }
    												}
    												?>
                            	        	</ul>
									</div>
								</div>
							<?php endif; ?>
							<div class="col-lg-8 col-md-12 content-single-right">
									<?php if ($single_listing_gallery_style == 'gallery-style-slider'): ?>
										<?php do_action( 'tfcl_single_listing_summary_gallery' ); ?>
										<div class="col-md-12">
											<div class="listing-tab-item">
                            	        	<ul class="tab-item">
											<?php 
    												foreach ($tabs as $key => $label) {
    												    if (isset($panels[$key]) && $panels[$key] == 1) {
    												        echo '<li><a href="#' . esc_attr($key) . '" class="item-nav">' . esc_html($label) . '</a></li>';
    												    }
    												}
    												?>
                            	        	</ul>
											</div>
										</div>
									<?php endif; ?>

									<?php if ($single_listing_gallery_style == 'gallery-style-grid'): ?>
										<?php do_action( 'tfcl_single_listing_summary_header' ); ?>
									<?php endif; ?>
									<?php do_action( 'tfcl_single_listing_summary' ); ?>
									<?php do_action( 'tfcl_single_review' ); ?>
							</div>
							<div class="col-lg-4 col-md-12 sidebar-single-listing">
								<div class="overlay-sidebar"></div>
								<div class="tfcl_single_sidebar">
									<span class="btn-toggle-sidebar">
										<i class="icon-autodeal-icon-157"></i>
									</span>
									<div class="inner">
										<?php if ($single_listing_gallery_style == 'gallery-style-slider'): ?>
											<?php do_action( 'tfcl_single_listing_summary_header' ); ?>
											<?php tfcl_get_template_with_arguments( 'single-listing/overview.php' ); ?>
										<?php endif; ?>
										<?php themesflat_dynamic_sidebar( 'single-listing-sidebar' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</main>
</div>
<?php get_footer(); ?>