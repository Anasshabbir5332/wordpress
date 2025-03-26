<?php
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
?>
<div class="container">
	<div class="col-md-12">
		<?php tfcl_get_template_with_arguments( 'single-author/author-infor.php' ); ?>
	</div>
	<div class="row wrap-single-seller">
		<div class="single-seller-content col-md-12">
			<div class="content-inner">
				<main id="main" class="site-main">
					<article id="post-<?php the_author_meta( 'ID' ); ?>" <?php post_class(); ?>>
						<div class="entry-content">
							<?php do_action( 'tfcl_single_author_summary' ); ?>
						</div>
					</article>
				</main>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>