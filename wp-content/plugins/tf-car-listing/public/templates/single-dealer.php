<?php
wp_enqueue_script( 'star-rating' );
wp_enqueue_script( 'dealer-script' );
wp_enqueue_style( 'dealer-style' );
wp_enqueue_style( 'listing-css' );
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
$has_sidebar = tfcl_get_option( 'single_dealer_sidebar' ) == 'enable' ? true : false;
if ( $has_sidebar ) {
	$dealer_sidebar_position = tfcl_get_option( 'single_dealer_sidebar_position' );
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<?php if ( $has_sidebar && $dealer_sidebar_position == 'sidebar-left' ) : ?>
					<div class="col-xl-4 col-md-12 sidebar-single-listing">
						<div class="overlay-sidebar"></div>
						<div class="tfcl_single_sidebar">
							<span class="btn-toggle-sidebar">
								<i class="icon-autodeal-icon-157"></i>
							</span>
							<div class="inner">
								<div class="tfcl-sidebar-dealer">
									<?php themesflat_dynamic_sidebar( 'single-dealer-sidebar' ); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="<?php echo ( ( $dealer_sidebar_position == 'sidebar-right' ) || ( $dealer_sidebar_position == 'sidebar-left' ) ? 'col-xl-8 col-md-12' : 'col-md-12' ); ?>">
					<div id="primary" class="content-area">
						<main id="main" class="site-main">
							<?php while ( have_posts() ) :
								the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="entry-content">
										<?php do_action( 'tfcl_single_dealer_summary' ); ?>
										<?php echo do_shortcode( '[listing_dealer]' ); ?>
										<?php do_action( 'tfcl_single_dealer_review' ); ?>
									</div>
								</article>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</main>
					</div>
				</div>

				<?php if ( $has_sidebar && $dealer_sidebar_position == 'sidebar-right' ) : ?>
					<div class="col-xl-4 col-md-12 sidebar-single-listing">
						<div class="overlay-sidebar"></div>
						<div class="tfcl_single_sidebar">
							<span class="btn-toggle-sidebar">
								<i class="icon-autodeal-icon-157"></i>
							</span>
							<div class="inner">
								<div class="tfcl-sidebar-dealer">
									<?php themesflat_dynamic_sidebar( 'single-dealer-sidebar' ); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>