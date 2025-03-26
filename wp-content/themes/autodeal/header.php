<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package autodeal
 */

 $header_absolute = themesflat_get_opt('header_absolute');
 if (themesflat_get_opt_elementor('header_absolute') != '') {
	 $header_absolute = themesflat_get_opt_elementor('header_absolute');
 }
 $header_sticky = themesflat_get_opt('header_sticky');
 if (themesflat_get_opt_elementor('header_sticky') != '') {
	 $header_sticky = themesflat_get_opt_elementor('header_sticky');
 }	

 $style_header = themesflat_get_opt('style_header');
 if (themesflat_get_opt_elementor('style_header') != '') {
	 $style_header = themesflat_get_opt_elementor('style_header');
 }	

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
<link rel="profile" href="<?php echo THEMESFLAT_PROTOCOL ?>://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="themesflat-boxed <?php echo esc_attr($style_header); ?> <?php echo esc_attr($header_absolute == 1 ? 'header-absolute' : ''); ?> <?php echo esc_attr( $header_sticky == 1 ? 'header_sticky' : ''); ?>">	
	<div class="header-boxed">
		<?php
			get_template_part( 'tpl/site-header');        		
		?>
	</div>
	<!-- Page Title -->
	<?php get_template_part( 'tpl/page-title'); ?>	
	<div id="main-content" class="site-main clearfix ">
		<div id="themesflat-content" class="page-wrap <?php echo esc_attr( themesflat_blog_layout() ); ?>">