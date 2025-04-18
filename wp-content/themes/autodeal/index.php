<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package autodeal
 */

get_header(); ?>
<?php 
	$blog_layout = themesflat_get_opt('blog_archive_layout');
	$columns =  themesflat_get_opt('blog_grid_columns') ;
	$imgs = array(
		'blog-grid' => 'themesflat-blog-grid',
		'blog-list' => 'themesflat-blog',
		);
	$class_names = array(
		1 => 'blog-one-column',
		2 => 'blog-two-columns',
		3 => 'blog-three-columns',
		4 => 'blog-four-columns',
		);		
	global $themesflat_thumbnail;
	$themesflat_thumbnail = $imgs[$blog_layout];
	$class = array('blog-archive');
	$class[] = $blog_layout;
	$class[] =  $class_names[$columns];
?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="wrap-content-area clearfix">
					<div id="primary" class="content-area">
						<main id="main" class="post-wrap" role="main">
							<?php if ( have_posts() ) : ?>
							<div class="wrap-blog-article <?php echo esc_attr(implode(" ",$class));?> has-post-content">
								<?php /* Start the Loop */ ?>
								<?php while ( have_posts() ) : the_post(); ?>

									<?php
										/* Include the Post-Format-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
										 */
										get_template_part( 'content', get_post_type() );
									?>

								<?php endwhile; ?>		
							</div>	
							<?php else : ?>

								<?php get_template_part( 'content', 'none' ); ?>

							<?php endif; ?>
						</main><!-- #main -->
						<div class="clearfix">
						<?php
							global $themesflat_paging_style, $themesflat_paging_for;
							$themesflat_paging_for = 'blog';
					        $themesflat_paging_style = themesflat_get_opt('blog_archive_pagination_style');		        
							get_template_part( 'tpl/pagination' );
						?>			
						</div>
					</div><!-- #primary -->

					<?php 
					if ( themesflat_get_opt( 'sidebar_layout' ) == 'sidebar-left' || themesflat_get_opt( 'sidebar_layout' ) == 'sidebar-right' ) :
						get_sidebar();
					endif;
					?>
				</div><!-- /.wrap-content-area -->
			</div><!-- /.col-md-12 -->
		</div><!-- /.row -->
	</div>


<?php get_footer(); ?>