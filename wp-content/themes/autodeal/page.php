<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package autodeal
 */

get_header();
?>	
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="wrap-content-area">
				<div id="primary" class="content-area">	
				
					<main id="main" class="main-content" role="main">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content', 'page' ); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if (is_single() && (comments_open() || get_comments_number())) :
									comments_template();
								endif;
							?>
						<?php endwhile; // end of the loop. ?>
					</main><!-- #main -->
				</div><!-- #primary -->
				<?php 
				if ( themesflat_get_opt_elementor( 'page_sidebar_layout' ) == 'sidebar-left' || themesflat_get_opt_elementor( 'page_sidebar_layout' ) == 'sidebar-right' ) :
					get_sidebar();
				endif;
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>