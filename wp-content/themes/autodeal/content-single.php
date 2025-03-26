<?php
/**
 * @package autodeal
 */
global $themesflat_thumbnail;
$themesflat_thumbnail = 'themesflat-blog';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post blog-single' ); ?>>

	<!-- begin feature-post single  -->
	<div class="content-post-sigle-title">
		<?php if ( themesflat_get_opt('blog_featured_title') != '' ): ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
	</div>

	<div class="content-post-single">
		<div class="meta">
			<?php 
				echo '<span class="item-meta post-author">';
						printf(
						'<a class="meta-text" href="%s" title="%s" rel="author"><i class="icon-autodeal-user"></i>  <span>%s</span> </a>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )),
						esc_attr( sprintf( esc_html__( 'View all posts by %s', 'autodeal' ), get_the_author() ) ),get_the_author());
				echo '</span>';
				echo '<span class="item-meta post-categories"><i class="icon-autodeal-folder"></i>'.esc_html__("",'autodeal');
                	the_category( ', ' );
            	echo '</span>';
				echo'<span class="item-meta post-comments"><span class="meta-text"><i class="icon-autodeal-chat"></i> ';
                    comments_number ();
            	echo '</span></span>';
				echo '<span class="item-meta post-date">';   
                $archive_year  = get_the_time('Y'); 
                $archive_month = get_the_time('m'); 
                $archive_day   = get_the_time('d');                 
                echo '<span class="meta-text"><i class="icon-autodeal-date1"></i> '.get_the_date().'</span>';
            echo '</span>';
			?>
		</div>
				
	</div><!-- /.entry-post -->

	<?php get_template_part( 'tpl/feature-post-single'); ?>
	<!-- end feature-post single-->

	
	

	<div class="main-post">		
		<div class="entry-content clearfix">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'autodeal' ),
				'after'  => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>'
				) );
				?>
		</div><!-- .entry-content -->
	</div><!-- /.main-post -->
</article><!-- #post-## -->
<?php if( themesflat_get_opt('show_entry_footer_content') == 1 ): ?>		
	<?php themesflat_entry_footer(); ?>
<?php endif; ?>