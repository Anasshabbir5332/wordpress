<?php /* Template Name: Page Dashboard */ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="<?php echo THEMESFLAT_PROTOCOL ?>://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php 
	global $current_user;
    wp_get_current_user();
	$user_login        = $current_user->user_login;
	$user_email        = $current_user->user_email;
	$user_id           = $current_user->ID;
	$user_avatar       = get_the_author_meta('profile_image', $user_id);
	$no_avatar         = get_avatar_url($user_id);
	$default_image_src = THEMESFLAT_LINK . 'images/avatar-default.png';
	$menus             = tfcl_get_menu_user_login();
	$logo_site         = themesflat_get_opt('site_logo_dashboard');
	if (!empty(themesflat_get_opt_elementor('site_logo_dashboard'))) {
	    if (themesflat_get_opt_elementor('site_logo_dashboard')['url'] != '') {
	        $logo_site = themesflat_get_opt_elementor('site_logo_dashboard')['url'];
	    }else {
	        $logo_site = themesflat_get_opt('site_logo_dashboard');
	    }    
	}
?>

	<div class="dashboard-overlay"></div>
	<aside class="sidebar-dashboard">
		<div class="db-content db-logo pad-30">
			<a href="<?php echo esc_url( home_url('/') ); ?>"  title="<?php bloginfo('name'); ?>">
            	<?php if  (!empty($logo_site)) { ?>
            	    <img class="site-logo"  src="<?php echo esc_url($logo_site); ?>" alt="<?php bloginfo('name'); ?>"/>
            	<?php } ?>
        	</a>
		</div>
		
		<?php if(!empty($user_login)):?>
		<div class="db-content db-author pad-30">
					<h6 class="db-title"><?php esc_html_e('Profile', 'autodeal'); ?></h6>
					<div class="author">
						<div class="avatar">
							<img loading="lazy" id="tfre_avatar_thumbnail" src="<?php echo esc_attr($user_avatar); ?>" onerror="this.src = '<?php echo esc_url($default_image_src) ?>';" alt="<?php echo esc_attr($user_login); ?>" title="<?php echo esc_attr($user_login); ?>">
						</div>
						<div class="content">
							<div class="name"><?php echo esc_html($user_login); ?></div>
							<div class="author-email">
								<?php echo esc_attr($user_email); ?>
							</div>
						</div>
					</div>
		</div>
		<?php endif;?>

		<div class="db-content db-list-menu">
			<h6 class="db-title"><?php esc_html_e( 'Menu', 'autodeal' ); ?></h6>
			<div class="db-dashboard-menu">
				<ul>
            		<?php $key = 1; foreach ($menus as $menu): ?>
            		    <li>
            		        <a href="<?php echo esc_url($menu['url']); ?>" class="menu-index-<?php echo esc_attr($key);  ?>">
            		            <?php echo wp_kses_post($menu['icon']);
            		            echo esc_html($menu['label']); ?>
								<?php if (!empty($menu['total'])): ?>
            		            <span class="count-page"><?php echo esc_html($menu['total']) ? sprintf(("%s"),$menu['total']) : ''; ?></span>
								<?php endif; ?>
							</a>
            		    </li>
            		    <?php
            		$key++; endforeach; ?>
            	</ul>
			</div>
		</div>

	</aside>

<div class="themesflat-boxed has-dashboard">	
	<div class="header-boxed">
		<?php
			get_template_part( 'tpl/header/header-default');        		
		?>
	</div>
	<div id="main-content" class="site-main clearfix ">
		<div class="dashboard-toggle"><i class="icon-autodeal-icon-157"></i> <?php esc_html_e( 'Show DashBoard', 'autodeal' ); ?></div>
		<div id="themesflat-content" class="page-wrap <?php echo esc_attr( themesflat_blog_layout() ); ?>">	
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
            								if ( comments_open() || get_comments_number() ) :
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