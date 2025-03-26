<?php
/**
 * @package autodeal
 */
//Output all custom styles for this theme

function themesflat_custom_styles( $custom ) {
	$custom = '';

	//GROUP FONT
		$font = themesflat_get_json('typography_body');

		$font_style = themesflat_font_style($font['style']);

		/*Typography Body*/
			$body_fonts = $font['family'];
			$body_line_height = $font['line_height'];
			$body_font_weight = $font_style[0];
			$body_font_style = $font_style[1];
			$body_size = $font['size'];
		
			// font family
			if ( $body_fonts !='' ) {
				$custom .= "body,button,input,select,textarea { font-family:" . $body_fonts . ";}"."\n";
			}

			// font family important
			if ( $body_fonts !='' ) {
				$custom .= ".blog-single .entry-content .icon-list { font-family:" . $body_fonts . "!important;}"."\n";
			}

			// font weight
			if ( $body_font_weight !='' ) {
				$custom .= "body,button,input,select,textarea { font-weight:" . $body_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $body_font_style ) ) {
		        $custom .= "body,button,input,select,textarea { font-style:" . $body_font_style . "; }"."\n";        
			}
		    // font size
		    if ( $body_size !=''  ) {
		        $custom .= "body,button,input,select,textarea { font-size:" . intval( $body_size ) . "px; }"."\n";    
		    }
		    // line height
		    if ( $body_line_height != '' ) {
		        $custom .= "body,button,input,select,textarea { line-height:" . $body_line_height . ";}"."\n";    
		    }

		/*Typography Headings*/
			$headings_fonts_ = themesflat_get_json('typography_headings');
			$headings_fonts_family = $headings_fonts_['family'];
			$headings_style = themesflat_font_style( $headings_fonts_['style'] );
			$headings_font_weight = $headings_style[0];
			$headings_font_style = $headings_style[1];
			$headings_line_height = $headings_fonts_['line_height'];
	    	    	
			// font family
			if ( $headings_fonts_family !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { font-family:" . $headings_fonts_family . ";}"."\n";

			}
			//font weight
			if ( $headings_font_weight !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { font-weight:" . $headings_font_weight . ";}"."\n";
			}
			//line height
			if ( $headings_line_height !='' ) {
				$custom .= "h1,h2,h3,h4,h5,h6 { line-height:" . $headings_line_height . ";}"."\n";
			}

			// font style
			if ( isset( $headings_font_style )) {
		        $custom .= "h1,h2,h3,h4,h5,h6  { font-style:" . $headings_font_style . "; }"."\n";
			}

			// H1 font size
			if ( $h1_size = themesflat_get_opt( 'h1_size' ) ) {
				$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
			}
		    // H2 font size
		    if ( $h2_size = themesflat_get_opt( 'h2_size' ) ) {
		        $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
		    }
		    // H3 font size
		    if ( $h3_size = themesflat_get_opt( 'h3_size' ) ) {
		        $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
		    }
		    // H4 font size
		    if ( $h4_size = themesflat_get_opt( 'h4_size' ) ) {
		        $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
		    }
		    // H5 font size
		    if ( $h5_size = themesflat_get_opt( 'h5_size' ) ) {
		        $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
		    }
		    // H6 font size
		    if ( $h6_size = themesflat_get_opt( 'h6_size' ) ) {
		        $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
		    }

		/*Typography Menu*/	
			$menu_fonts_ = themesflat_get_json('typography_menu');
			$menu_fonts_family = $menu_fonts_['family'];
			$menu_fonts_size = $menu_fonts_['size'];
			$menu_line_height = $menu_fonts_['line_height'];
			$menu_style = themesflat_font_style( $menu_fonts_['style'] );
			$menu_font_weight = $menu_style[0];
			$menu_font_style = $menu_style[1];
				
			// font family
			if ( $menu_fonts_family != '') {
				$custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text, header .flat-information li { font-family:" . $menu_fonts_family . " !important;}"."\n";
			}
			// font weight
			if ( $menu_font_weight != '' ) {
				$custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text { font-weight:" . $menu_font_weight . " !important;}"."\n";
			}
			// font style
			if ( isset( $menu_font_style )) {
		        $custom .= "#mainnav > ul > li > a, .header-modal-menu-left-btn .text  { font-style:" . $menu_font_style . " !important; }"."\n";   
			}
		    // font size
		    if ( $menu_fonts_size != '' ) {
		        $custom .= "#mainnav ul li a, .header-modal-menu-left-btn .text, header .flat-information li { font-size:" . intval($menu_fonts_size) . "px !important;}"."\n";
		    }
		    // line height
		    if ( $menu_line_height != '' ) {
		        $custom .= "#mainnav > ul > li > a, #header.header-sticky #mainnav > ul > li > a { line-height:" . $menu_line_height . " !important;}"."\n";
		    }


		/*Typography Sub menu*/
			$sub_menu_fonts_ = themesflat_get_json('typography_sub_menu');
			$sub_menu_fonts_family = $sub_menu_fonts_['family'];
			$sub_menu_fonts_size = $sub_menu_fonts_['size'];
			$sub_menu_line_height = $sub_menu_fonts_['line_height'];
			$sub_menu_style = themesflat_font_style( $sub_menu_fonts_['style'] );
			$sub_menu_font_weight = $sub_menu_style[0];
			$sub_menu_font_style = $sub_menu_style[1];
		
			// font family
			if ( $sub_menu_fonts_family != '') {
				$custom .= "#mainnav ul.sub-menu > li > a { font-family:" . $sub_menu_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $sub_menu_font_weight != '' ) {
				$custom .= "#mainnav ul.sub-menu > li > a { font-weight:" . $sub_menu_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $sub_menu_font_style )) {
		        $custom .= "#mainnav ul.sub-menu > li > a  { font-style:" . $sub_menu_font_style . "; }"."\n";   
			}
		    // font size
		    if ( $sub_menu_fonts_size != '' ) {
		        $custom .= "#mainnav ul.sub-menu > li > a { font-size:" . intval($sub_menu_fonts_size) . "px !important;}"."\n";
		    }
		    // line height
		    if ( $sub_menu_line_height != '' ) {
		        $custom .= "#mainnav ul.sub-menu > li > a { line-height:" . $sub_menu_line_height . ";}"."\n";
		    } 

		/*Typography Blockquote*/	
		    $blockquote_fonts_ = themesflat_get_json('typography_blockquote');
			$blockquote_fonts_family = $blockquote_fonts_['family'];
			$blockquote_fonts_size = $blockquote_fonts_['size'];
			$blockquote_line_height = $blockquote_fonts_['line_height'];
			$blockquote_style = themesflat_font_style( $blockquote_fonts_['style'] );
			$blockquote_font_weight = $blockquote_style[0];
			$blockquote_font_style = $blockquote_style[1]; 
			// font family
			if ( $blockquote_fonts_family != '') {
				$custom .= "blockquote { font-family:" . $blockquote_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blockquote_font_weight != '' ) {
				$custom .= "blockquote { font-weight:" . $blockquote_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blockquote_font_style )) {
		        $custom .= "blockquote { font-style:" . $blockquote_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blockquote_fonts_size != '' ) {
		        $custom .= "blockquote { font-size:" . intval($blockquote_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blockquote_line_height != '' ) {
		        $custom .= "blockquote { line-height:" . $blockquote_line_height . ";}"."\n";
		    } 

		/*Typography blog post title*/ 
			$blog_post_title_fonts_ = themesflat_get_json('typography_blog_post_title');
			$blog_post_title_fonts_family = $blog_post_title_fonts_['family'];
			$blog_post_title_fonts_size = $blog_post_title_fonts_['size'];
			$blog_post_title_line_height = $blog_post_title_fonts_['line_height'];
			$blog_post_title_style = themesflat_font_style( $blog_post_title_fonts_['style'] );
			$blog_post_title_font_weight = $blog_post_title_style[0];
			$blog_post_title_font_style = $blog_post_title_style[1]; 
			// font family
			if ( $blog_post_title_fonts_family != '') {
				$custom .= "article .entry-title { font-family:" . $blog_post_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_post_title_font_weight != '' ) {
				$custom .= "article .entry-title { font-weight:" . $blog_post_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_post_title_font_style )) {
		        $custom .= "article .entry-title { font-style:" . $blog_post_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_post_title_fonts_size != '' ) {
		        $custom .= "article .entry-title { font-size:" . intval($blog_post_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_post_title_line_height != '' ) {
		        $custom .= "article .entry-title { line-height:" . $blog_post_title_line_height . ";}"."\n";
		    } 

		/*Typography blog post title*/ 
			$blog_post_meta_fonts_ = themesflat_get_json('typography_blog_post_meta');
			$blog_post_meta_fonts_family = $blog_post_meta_fonts_['family'];
			$blog_post_meta_fonts_size = $blog_post_meta_fonts_['size'];
			$blog_post_meta_line_height = $blog_post_meta_fonts_['line_height'];
			$blog_post_meta_style = themesflat_font_style( $blog_post_meta_fonts_['style'] );
			$blog_post_meta_font_weight = $blog_post_meta_style[0];
			$blog_post_meta_font_style = $blog_post_meta_style[1]; 
			// font family
			if ( $blog_post_meta_fonts_family != '') {
				$custom .= "article .post-meta .item-meta, .blog-single .content-post-single .item-meta  { font-family:" . $blog_post_meta_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_post_meta_font_weight != '' ) {
				$custom .= "article .post-meta .item-meta, .blog-single .content-post-single .item-meta  { font-weight:" . $blog_post_meta_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_post_meta_font_style )) {
		        $custom .= "article .post-meta .item-meta, .blog-single .content-post-single .item-meta  { font-style:" . $blog_post_meta_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_post_meta_fonts_size != '' ) {
		        $custom .= "article .post-meta .item-meta, .blog-single .content-post-single .item-meta  { font-size:" . intval($blog_post_meta_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_post_meta_line_height != '' ) {
		        $custom .= "article .post-meta .item-meta, .blog-single .content-post-single .item-meta  { line-height:" . $blog_post_meta_line_height . ";}"."\n";
		    } 
	

		/*Typography blog post buttons*/	
		    $blog_post_buttons_fonts_ = themesflat_get_json('typography_blog_post_buttons');
			$blog_post_buttons_fonts_family = $blog_post_buttons_fonts_['family'];
			$blog_post_buttons_fonts_size = $blog_post_buttons_fonts_['size'];
			$blog_post_buttons_line_height = $blog_post_buttons_fonts_['line_height'];
			$blog_post_buttons_style = themesflat_font_style( $blog_post_buttons_fonts_['style'] );
			$blog_post_buttons_font_weight = $blog_post_buttons_style[0];
			$blog_post_buttons_font_style = $blog_post_buttons_style[1]; 
			// font family
			if ( $blog_post_buttons_fonts_family != '') {
				$custom .= "article .themesflat-btn-blog { font-family:" . $blog_post_buttons_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_post_buttons_font_weight != '' ) {
				$custom .= "article .themesflat-btn-blog { font-weight:" . $blog_post_buttons_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_post_buttons_font_style )) {
		        $custom .= "article .themesflat-btn-blog { font-style:" . $blog_post_buttons_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_post_buttons_fonts_size != '' ) {
		        $custom .= "article .themesflat-btn-blog { font-size:" . intval($blog_post_buttons_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_post_buttons_line_height != '' ) {
		        $custom .= "article .themesflat-btn-blog { line-height:" . $blog_post_buttons_line_height . ";}"."\n";
		    } 
	

		/*Typography blog single title*/	
		    $blog_single_title_fonts_ = themesflat_get_json('typography_blog_single_title');
			$blog_single_title_fonts_family = $blog_single_title_fonts_['family'];
			$blog_single_title_fonts_size = $blog_single_title_fonts_['size'];
			$blog_single_title_line_height = $blog_single_title_fonts_['line_height'];
			$blog_single_title_style = themesflat_font_style( $blog_single_title_fonts_['style'] );
			$blog_single_title_font_weight = $blog_single_title_style[0];
			$blog_single_title_font_style = $blog_single_title_style[1]; 
			// font family
			if ( $blog_single_title_fonts_family != '') {
				$custom .= ".single article .entry-title { font-family:" . $blog_single_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_single_title_font_weight != '' ) {
				$custom .= ".single article .entry-title { font-weight:" . $blog_single_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_single_title_font_style )) {
		        $custom .= ".single article .entry-title { font-style:" . $blog_single_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_single_title_fonts_size != '' ) {
		        $custom .= ".single article .entry-title { font-size:" . intval($blog_single_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_single_title_line_height != '' ) {
		        $custom .= ".single article .entry-title { line-height:" . $blog_single_title_line_height . ";}"."\n";
		    } 
	

		/*Typography blog single comment title*/	
		    $blog_single_comment_title_fonts_ = themesflat_get_json('typography_blog_single_comment_title');
			$blog_single_comment_title_fonts_family = $blog_single_comment_title_fonts_['family'];
			$blog_single_comment_title_fonts_size = $blog_single_comment_title_fonts_['size'];
			$blog_single_comment_title_line_height = $blog_single_comment_title_fonts_['line_height'];
			$blog_single_comment_title_style = themesflat_font_style( $blog_single_comment_title_fonts_['style'] );
			$blog_single_comment_title_font_weight = $blog_single_comment_title_style[0];
			$blog_single_comment_title_font_style = $blog_single_comment_title_style[1]; 
			// font family
			if ( $blog_single_comment_title_fonts_family != '') {
				$custom .= ".comment-title, .comment-reply-title, .comment-reply-title a { font-family:" . $blog_single_comment_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $blog_single_comment_title_font_weight != '' ) {
				$custom .= ".comment-title, .comment-reply-title, .comment-reply-title a { font-weight:" . $blog_single_comment_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $blog_single_comment_title_font_style )) {
		        $custom .= ".comment-title, .comment-reply-title, .comment-reply-title a { font-style:" . $blog_single_comment_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $blog_single_comment_title_fonts_size != '' ) {
		        $custom .= ".comment-title, .comment-reply-title, .comment-reply-title a { font-size:" . intval($blog_single_comment_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $blog_single_comment_title_line_height != '' ) {
		        $custom .= ".comment-title, .comment-reply-title, .comment-reply-title a { line-height:" . $blog_single_comment_title_line_height . ";}"."\n";
		    } 

		/*Typography sidebar widget title*/	
		    $sidebar_widget_title_fonts_ = themesflat_get_json('typography_sidebar_widget_title');
			$sidebar_widget_title_fonts_family = $sidebar_widget_title_fonts_['family'];
			$sidebar_widget_title_fonts_size = $sidebar_widget_title_fonts_['size'];
			$sidebar_widget_title_line_height = $sidebar_widget_title_fonts_['line_height'];
			$sidebar_widget_title_style = themesflat_font_style( $sidebar_widget_title_fonts_['style'] );
			$sidebar_widget_title_font_weight = $sidebar_widget_title_style[0];
			$sidebar_widget_title_font_style = $sidebar_widget_title_style[1]; 
			// font family
			if ( $sidebar_widget_title_fonts_family != '') {
				$custom .= ".sidebar .widget .widget-title, .sidebar .widget h2, .sidebar .wp-block-search .wp-block-search__label, .sidebar .wc-block-product-search .wc-block-product-search__label { font-family:" . $sidebar_widget_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $sidebar_widget_title_font_weight != '' ) {
				$custom .= ".sidebar .widget .widget-title, .widget h2, .sidebar .wp-block-search .wp-block-search__label, .sidebar .wc-block-product-search .wc-block-product-search__label { font-weight:" . $sidebar_widget_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $sidebar_widget_title_font_style )) {
		        $custom .= ".sidebar .widget .widget-title, .widget h2, .sidebar .wp-block-search .wp-block-search__label, .sidebar .wc-block-product-search .wc-block-product-search__label { font-style:" . $sidebar_widget_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $sidebar_widget_title_fonts_size != '' ) {
		        $custom .= ".sidebar .widget .widget-title, .widget h2, .sidebar .wp-block-search .wp-block-search__label, .sidebar .wc-block-product-search .wc-block-product-search__label { font-size:" . intval($sidebar_widget_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $sidebar_widget_title_line_height != '' ) {
		        $custom .= ".sidebar .widget .widget-title, .widget h2, .sidebar .wp-block-search .wp-block-search__label, .sidebar .wc-block-product-search .wc-block-product-search__label { line-height:" . $sidebar_widget_title_line_height . ";}"."\n";
		    } 

		/*Typography footer widget title*/	
		    $footer_widget_title_fonts_ = themesflat_get_json('typography_footer_widget_title');
			$footer_widget_title_fonts_family = $footer_widget_title_fonts_['family'];
			$footer_widget_title_fonts_size = $footer_widget_title_fonts_['size'];
			$footer_widget_title_line_height = $footer_widget_title_fonts_['line_height'];
			$footer_widget_title_style = themesflat_font_style( $footer_widget_title_fonts_['style'] );
			$footer_widget_title_font_weight = $footer_widget_title_style[0];
			$footer_widget_title_font_style = $footer_widget_title_style[1]; 
			// font family
			if ( $footer_widget_title_fonts_family != '') {
				$custom .= "#footer .footer-widgets .widgets-areas > .widget-title,footer .widget .widget-title, footer .widget h2, footer .wp-block-search .wp-block-search__label { font-family:" . $footer_widget_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $footer_widget_title_font_weight != '' ) {
				$custom .= "#footer .footer-widgets .widgets-areas > .widget-title,footer .widget .widget-title, footer .widget h2, footer .wp-block-search .wp-block-search__label { font-weight:" . $footer_widget_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $footer_widget_title_font_style )) {
		        $custom .= "#footer .footer-widgets .widgets-areas > .widget-title,footer .widget .widget-title, footer .widget h2, footer .wp-block-search .wp-block-search__label { font-style:" . $footer_widget_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $footer_widget_title_fonts_size != '' ) {
		        $custom .= "#footer .footer-widgets .widgets-areas > .widget-title,footer .widget .widget-title, footer .widget h2, footer .wp-block-search .wp-block-search__label { font-size:" . intval($footer_widget_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $footer_widget_title_line_height != '' ) {
		        $custom .= "#footer .footer-widgets .widgets-areas > .widget-title,footer .widget .widget-title, footer .widget h2, footer .wp-block-search .wp-block-search__label { line-height:" . $footer_widget_title_line_height . ";}"."\n";
		    } 

			/*Typography footer widget title*/	
			$footer_widget_title_fonts_ = themesflat_get_json('typography_footer');
			$footer_widget_title_fonts_family = $footer_widget_title_fonts_['family'];
			$footer_widget_title_fonts_size = $footer_widget_title_fonts_['size'];
			$footer_widget_title_line_height = $footer_widget_title_fonts_['line_height'];
			$footer_widget_title_style = themesflat_font_style( $footer_widget_title_fonts_['style'] );
			$footer_widget_title_font_weight = $footer_widget_title_style[0];
			$footer_widget_title_font_style = $footer_widget_title_style[1]; 
			// font family
			if ( $footer_widget_title_fonts_family != '') {
				$custom .= "footer .footer-widgets .widget.widget_text, .infor-ft li, footer .wrap-widgets p, footer .widget.widget_nav_menu ul li a { font-family:" . $footer_widget_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $footer_widget_title_font_weight != '' ) {
				$custom .= "footer .footer-widgets .widget.widget_text, .infor-ft li, footer .wrap-widgets p, footer .widget.widget_nav_menu ul li a { font-weight:" . $footer_widget_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $footer_widget_title_font_style )) {
				$custom .= "footer .footer-widgets .widget.widget_text, .infor-ft li, footer .wrap-widgets p, footer .widget.widget_nav_menu ul li a { font-style:" . $footer_widget_title_font_style . "; }"."\n";  
			}
			// font size
			if ( $footer_widget_title_fonts_size != '' ) {
				$custom .= "footer .footer-widgets .widget.widget_text, .infor-ft li, footer .wrap-widgets p, footer .widget.widget_nav_menu ul li a { font-size:" . intval($footer_widget_title_fonts_size) . "px;}"."\n";
			}
			// line height
			if ( $footer_widget_title_line_height != '' ) {
				$custom .= "footer .footer-widgets .widget.widget_text, .infor-ft li, footer .wrap-widgets p, footer .widget.widget_nav_menu ul li a { line-height:" . $footer_widget_title_line_height . ";}"."\n";
			} 

		/*Typography page title*/	
		    $page_title_fonts_ = themesflat_get_json('typography_page_title');
			$page_title_fonts_family = $page_title_fonts_['family'];
			$page_title_fonts_size = $page_title_fonts_['size'];
			$page_title_line_height = $page_title_fonts_['line_height'];
			$page_title_style = themesflat_font_style( $page_title_fonts_['style'] );
			$page_title_font_weight = $page_title_style[0];
			$page_title_font_style = $page_title_style[1]; 
			// font family
			if ( $page_title_fonts_family != '') {
				$custom .= ".page-title .page-title-heading { font-family:" . $page_title_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $page_title_font_weight != '' ) {
				$custom .= ".page-title .page-title-heading { font-weight:" . $page_title_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $page_title_font_style )) {
		        $custom .= ".page-title .page-title-heading { font-style:" . $page_title_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $page_title_fonts_size != '' ) {
		        $custom .= ".page-title .page-title-heading { font-size:" . intval($page_title_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $page_title_line_height != '' ) {
		        $custom .= ".page-title .page-title-heading { line-height:" . $page_title_line_height . ";}"."\n";
		    } 

		/*Typography breadcrumb*/	
		    $breadcrumb_fonts_ = themesflat_get_json('typography_breadcrumb');
			$breadcrumb_fonts_family = $breadcrumb_fonts_['family'];
			$breadcrumb_fonts_size = $breadcrumb_fonts_['size'];
			$breadcrumb_line_height = $breadcrumb_fonts_['line_height'];
			$breadcrumb_style = themesflat_font_style( $breadcrumb_fonts_['style'] );
			$breadcrumb_font_weight = $breadcrumb_style[0];
			$breadcrumb_font_style = $breadcrumb_style[1]; 
			// font family
			if ( $breadcrumb_fonts_family != '') {
				$custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-family:" . $breadcrumb_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $breadcrumb_font_weight != '' ) {
				$custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-weight:" . $breadcrumb_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $breadcrumb_font_style )) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-style:" . $breadcrumb_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $breadcrumb_fonts_size != '' ) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { font-size:" . intval($breadcrumb_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $breadcrumb_line_height != '' ) {
		        $custom .= ".breadcrumbs, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span { line-height:" . $breadcrumb_line_height . ";}"."\n";
		    } 

		/*Typography buttons*/	
		    $buttons_fonts_ = themesflat_get_json('typography_buttons');
			$buttons_fonts_family = $buttons_fonts_['family'];
			$buttons_fonts_size = $buttons_fonts_['size'];
			$buttons_line_height = $buttons_fonts_['line_height'];
			$buttons_style = themesflat_font_style( $buttons_fonts_['style'] );
			$buttons_font_weight = $buttons_style[0];
			$buttons_font_style = $buttons_style[1]; 
			// font family
			if ( $buttons_fonts_family != '') {
				$custom .= ".themesflat-button, .tf-btn, #commentform .wrap-input-submit input[type=\"submit\"], .themesflat-action-box .tf-btn-ac, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-family:" . $buttons_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $buttons_font_weight != '' ) {
				$custom .= ".themesflat-button, .tf-btn, #commentform .wrap-input-submit input[type=\"submit\"], .themesflat-action-box .tf-btn-ac, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-weight:" . $buttons_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $buttons_font_style )) {
		        $custom .= ".themesflat-button, .tf-btn, #commentform .wrap-input-submit input[type=\"submit\"], .themesflat-action-box .tf-btn-ac, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-style:" . $buttons_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $buttons_fonts_size != '' ) {
		        $custom .= ".themesflat-button, .tf-btn, #commentform .wrap-input-submit input[type=\"submit\"], .themesflat-action-box .tf-btn-ac, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-size:" . intval($buttons_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $buttons_line_height != '' ) {
		        $custom .= ".themesflat-button, .tf-btn, #commentform .wrap-input-submit input[type=\"submit\"], .themesflat-action-box .tf-btn-ac, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { line-height:" . $buttons_line_height . ";}"."\n";
		    } 

		/*Typography pagination*/	
		    $pagination_fonts_ = themesflat_get_json('typography_pagination');
			$pagination_fonts_family = $pagination_fonts_['family'];
			$pagination_fonts_size = $pagination_fonts_['size'];
			$pagination_line_height = $pagination_fonts_['line_height'];
			$pagination_style = themesflat_font_style( $pagination_fonts_['style'] );
			$pagination_font_weight = $pagination_style[0];
			$pagination_font_style = $pagination_style[1]; 
			// font family
			if ( $pagination_fonts_family != '') {
				$custom .= ".navigation a, .pagination > span, .navigation.paging-navigation span, .page-links a, .page-links > span { font-family:" . $pagination_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $pagination_font_weight != '' ) {
				$custom .= ".navigation a, .pagination > span, .navigation.paging-navigation span, .page-links a, .page-links > span { font-weight:" . $pagination_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $pagination_font_style )) {
		        $custom .= ".navigation a, .pagination > span, .navigation.paging-navigation span, .page-links a, .page-links > span { font-style:" . $pagination_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $pagination_fonts_size != '' ) {
		        $custom .= ".navigation a, .pagination > span, .navigation.paging-navigation span, .page-links a, .page-links > span { font-size:" . intval($pagination_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $pagination_line_height != '' ) {
		        $custom .= ".navigation a, .pagination > span, .navigation.paging-navigation span, .page-links a, .page-links > span { line-height:" . $pagination_line_height . ";}"."\n";
		    } 

		/*Typography copyright*/	
		    $copyright_fonts_ = themesflat_get_json('typography_bottom_copyright');
			$copyright_fonts_family = $copyright_fonts_['family'];
			$copyright_fonts_size = $copyright_fonts_['size'];
			$copyright_line_height = $copyright_fonts_['line_height'];
			$copyright_style = themesflat_font_style( $copyright_fonts_['style'] );
			$copyright_font_weight = $copyright_style[0];
			$copyright_font_style = $copyright_style[1]; 
			// font family
			if ( $copyright_fonts_family != '') {
				$custom .= ".copyright { font-family:" . $copyright_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $copyright_font_weight != '' ) {
				$custom .= ".copyright { font-weight:" . $copyright_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $copyright_font_style )) {
		        $custom .= ".copyright { font-style:" . $copyright_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $copyright_fonts_size != '' ) {
		        $custom .= ".copyright { font-size:" . intval($copyright_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $copyright_line_height != '' ) {
		        $custom .= ".copyright { line-height:" . $copyright_line_height . ";}"."\n";
		    } 

		/*Typography bottom menu*/	
		    $bottom_menu_fonts_ = themesflat_get_json('typography_bottom_menu');
			$bottom_menu_fonts_family = $bottom_menu_fonts_['family'];
			$bottom_menu_fonts_size = $bottom_menu_fonts_['size'];
			$bottom_menu_line_height = $bottom_menu_fonts_['line_height'];
			$bottom_menu_style = themesflat_font_style( $bottom_menu_fonts_['style'] );
			$bottom_menu_font_weight = $bottom_menu_style[0];
			$bottom_menu_font_style = $bottom_menu_style[1]; 
			// font family
			if ( $bottom_menu_fonts_family != '') {
				$custom .= ".bottom { font-family:" . $bottom_menu_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $bottom_menu_font_weight != '' ) {
				$custom .= ".bottom { font-weight:" . $bottom_menu_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $bottom_menu_font_style )) {
		        $custom .= ".bottom { font-style:" . $bottom_menu_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $bottom_menu_fonts_size != '' ) {
		        $custom .= ".bottom { font-size:" . intval($bottom_menu_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $bottom_menu_line_height != '' ) {
		        $custom .= ".bottom { line-height:" . $bottom_menu_line_height . ";}"."\n";
		    } 

	//GROUP LAYOUT
		$content_controls = themesflat_decode(themesflat_get_opt('content_controls'));
	    themesflat_render_box_position("#themesflat-content",$content_controls);

	//GROUP TOP BAR 
	    if ( themesflat_get_opt( 'topbar_background_color' ) !='' ) {
			$custom .= ".header-boxed .themesflat-top { background-color:" . esc_attr(themesflat_get_opt ('topbar_background_color')) ."; } "."\n";
	    }
	    if ( themesflat_get_opt( 'topbar_textcolor' ) !='' ) {
			$custom .= ".themesflat-top, .themesflat-top.style-01 .infor-topbar, .themesflat-top .infor-topbar i { color:" . esc_attr( themesflat_get_opt( 'topbar_textcolor' ) ) .";} "."\n";
	    }
	    if ( themesflat_get_opt( 'topbar_link_color' ) !='' ) {
			$custom .= ".themesflat-top a,.themesflat-top.select-2 a,.themesflat-top.select-2 .themesflat-socials li a, .themesflat-top .themesflat-socials li a { color:" . esc_attr( themesflat_get_opt( 'topbar_link_color' ) ) ." ;} "."\n";
	    }
	    if ( themesflat_get_opt( 'topbar_link_color_hover' ) !='' ) {
			$custom .= ".themesflat-top a:hover, .themesflat-top .list-infor-topbar li a:hover, .themesflat-top.style-01 .themesflat-socials a:hover, .themesflat-top .themesflat-socials a:hover { color:" . esc_attr( themesflat_get_opt( 'topbar_link_color_hover' ) ) ." !important;} "."\n";
	    }

	    $topbar_controls = themesflat_decode(themesflat_get_opt('topbar_controls'));
	    themesflat_render_box_position(".header-boxed .themesflat-top",$topbar_controls);
		
	    /*Typography Topbar*/	
		    $topbar_fonts_ = themesflat_get_json('typography_topbar');
			$topbar_fonts_family = $topbar_fonts_['family'];
			$topbar_fonts_size = $topbar_fonts_['size'];
			$topbar_line_height = $topbar_fonts_['line_height'];
			$topbar_style = themesflat_font_style( $topbar_fonts_['style'] );
			$topbar_font_weight = $topbar_style[0];
			$topbar_font_style = $topbar_style[1]; 
			// font family
			if ( $topbar_fonts_family != '') {
				$custom .= ".themesflat-top, .themesflat-top.select-2 .content-left ul li { font-family:" . $topbar_fonts_family . ";}"."\n";
			}
			// font weight
			if ( $topbar_font_weight != '' ) {
				$custom .= ".themesflat-top, .themesflat-top.select-2 .content-left ul li { font-weight:" . $topbar_font_weight . ";}"."\n";
			}
			// font style
			if ( isset( $topbar_font_style )) {
		        $custom .= ".themesflat-top, .themesflat-top.select-2 .content-left ul li { font-style:" . $topbar_font_style . "; }"."\n";  
			}
		    // font size
		    if ( $topbar_fonts_size != '' ) {
		        $custom .= ".themesflat-top, .themesflat-top.select-2 .content-left ul li { font-size:" . intval($topbar_fonts_size) . "px;}"."\n";
		    }
		    // line height
		    if ( $topbar_line_height != '' ) {
		        $custom .= ".themesflat-top, .themesflat-top.select-2 .content-left ul li { line-height:" . $topbar_line_height . ";}"."\n";
		    } 

	//GROUP HEADER
	    $header_backgroundcolor = themesflat_get_opt( 'header_backgroundcolor');
		if ( $header_backgroundcolor !='' ) {
			$custom .= "#header.header-default,#header.header-02 { background:" . esc_attr($header_backgroundcolor) . ";}"."\n";
		}

		$header_backgroundcolor_sticky = themesflat_get_opt( 'header_backgroundcolor_sticky');
		if ( $header_backgroundcolor_sticky !='' ) {		
			$custom .= "#header.header-sticky { background:" . esc_attr( $header_backgroundcolor_sticky ) . ";}"."\n";
		}

		$mainnav_color = themesflat_get_opt( 'mainnav_color');
		if ( $mainnav_color !='' ) {
			$custom .= "#mainnav > ul > li > a, #header.header-02 #mainnav > ul > li > a, .header-modal-menu-left-btn .text, header .flat-information li, header .flat-information li a { color:" . esc_attr($mainnav_color) . ";}"."\n";
			$custom .= ".header-modal-menu-left-btn .modal-menu-left-btn .line { background:" . esc_attr($mainnav_color) . ";}"."\n";
		}

		$mainnav_hover_color = themesflat_get_opt( 'mainnav_hover_color');
		if ( $mainnav_hover_color !='' ) {
			$custom .= "#mainnav > ul > li > a:hover { color:" . esc_attr($mainnav_hover_color) . "!important;}"."\n";
		}

		$mainnav_active_color = themesflat_get_opt( 'mainnav_active_color');
		if ( $mainnav_active_color !='' ) {
			$custom .= "#mainnav > ul > li.current-menu-item > a, #mainnav > ul > li.current-menu-ancestor > a, #mainnav > ul > li.current-menu-parent > a { color:" . esc_attr($mainnav_active_color) . "!important;}"."\n";
		}

		//Subnav a color
		$sub_nav_color = themesflat_get_opt( 'sub_nav_color');
		if ( $sub_nav_color !='' ) {
			$custom .= "#mainnav ul.sub-menu > li > a, #mainnav li.megamenu > ul.sub-menu > .menu-item-has-children > a { color:" . esc_attr( $sub_nav_color ) . ";}"."\n";
		}

		//Subnav background color
		$sub_nav_background = themesflat_get_opt( 'sub_nav_background');
		if ( $sub_nav_background !='' ) {
			$custom .= "#mainnav ul.sub-menu { background-color:" . esc_attr( $sub_nav_background ) . ";}"."\n";			
		}
		
		//sub_nav_color_hover
		$sub_nav_color_hover = themesflat_get_opt( 'sub_nav_color_hover');
		if ( $sub_nav_color_hover !='' ) {
			$custom .= "#mainnav ul.sub-menu > li > a:hover, #mainnav ul.sub-menu > li.current-menu-item > a, #mainnav-mobi ul li.current-menu-item > a, #mainnav-mobi ul li.current-menu-ancestor > a, #mainnav ul.sub-menu > li.current-menu-ancestor > a, #mainnav-mobi ul li .current-menu-item > a, #mainnav-mobi ul li.current-menu-item .btn-submenu:before, #mainnav-mobi ul li .current-menu-item .btn-submenu:before { color:" . esc_attr( $sub_nav_color_hover ) . ";}"."\n";
			$custom .= " #mainnav ul.sub-menu > li > a::after { background:" . esc_attr( $sub_nav_color_hover ) . ";}"."\n";
		}
		//sub_nav_background_hover
		$sub_nav_background_hover = themesflat_get_opt( 'sub_nav_background_hover');
		if ( $sub_nav_background_hover !='' ) {
			$custom .= " #mainnav ul.sub-menu > li > a:hover, #mainnav ul.sub-menu > li.current-menu-item a { background-color:" . esc_attr($sub_nav_background_hover) . ";}"."\n";
		}
		//sub_nav_border_color
		$sub_nav_border_color = themesflat_get_opt( 'sub_nav_border_color');
		if ( $sub_nav_border_color !='' ) {
			$custom .= "#mainnav ul.sub-menu > li { border-top-color:" . esc_attr($sub_nav_border_color) . ";}"."\n";
		}

		$logo_controls = themesflat_decode(themesflat_get_opt('logo_controls'));
	    themesflat_render_box_position("#header #logo",$logo_controls);

	    $logo_width = themesflat_get_opt( 'logo_width');
		if ( $logo_width !='' ) {
			$custom .= "#header #logo a img, #logo-mobi .site-logo, .top-search .top-inner-search .logo-footer, .modal-menu__panel-footer .logo-panel a img { max-width:" . esc_attr($logo_width) . "px;height: auto;}"."\n";
		}

		$menu_distance_between = themesflat_get_opt( 'menu_distance_between');
		if ( $menu_distance_between !='' ) {
			$custom .= "#mainnav > ul > li { margin-left:" . esc_attr($menu_distance_between) . "px; margin-right:". esc_attr($menu_distance_between) ."px;}"."\n";
		}

	//GROUP FOOTER
		$footer_controls = themesflat_decode(themesflat_get_opt('footer_controls'));
	    themesflat_render_box_position("#footer",$footer_controls);

	    $footer_background_color = themesflat_get_opt( 'footer_background_color');
		if ( $footer_background_color !='' ) {
			$custom .= ".footer_background { background:" . esc_attr($footer_background_color) . ";}"."\n";
		}
		$footer_background_image = themesflat_get_opt('footer_background_image');
		$footer_image_size = themesflat_get_opt('footer_image_size');
	    if ( $footer_background_image !='' ) { 
		    $custom .= '.footer_background .overlay-footer {background-image: url('.$footer_background_image.');}'."\n";
		    $custom .= '.footer_background .overlay-footer {background-size: '.$footer_image_size.';}'."\n";    
		}
		$footer_title_widget_color = themesflat_get_opt( 'footer_title_widget_color');
		if ( $footer_title_widget_color !='' ) {
			$custom .= "#footer .widget-title, #footer h2, #footer h3, #footer h4, #footer h5, #footer h6, #footer .wp-block-search .wp-block-search__label { color:" . esc_attr($footer_title_widget_color) . ";}"."\n";
		}
		$footer_text_color = themesflat_get_opt( 'footer_text_color');
		if ( $footer_text_color !='' ) {
			$custom .= "#footer, #footer a, .infor-ft li, footer .widget.widget-recent-news li .text .post-date,  #footer .footer-widgets .widget.widget_themesflat_socials ul li a, footer select option, footer .widget.widget_recent_entries ul li .post-date, #footer .wp-block-latest-posts__post-author, #footer .wp-block-latest-posts__post-date { color:" . esc_attr($footer_text_color) . ";}"."\n";
		}
		if ( $footer_text_color !='' ) {
			$custom .= "#footer .footer-widgets .widget.widget_themesflat_socials ul li a:hover { color:" . esc_attr($footer_text_color) . ";}"."\n";
		}
		$footer_text_color_hover = themesflat_get_opt( 'footer_text_color_hover');
		if ( $footer_text_color_hover !='' ) {
			$custom .= "#footer a:hover, :not(footer) .widget.widget_nav_menu ul li a::before { color:" . esc_attr($footer_text_color_hover) . ";}"."\n";
			$custom .= "footer .widget.widget_product_categories ul > li > a:before, footer .widget.widget_categories ul > li > a:before, footer .widget.widget_pages ul > li > a:before, footer .widget.widget_archive ul > li > a:before, footer .widget.widget_meta ul > li > a:before, footer .widget.widget_block ul > li > a:before { background:" . esc_attr($footer_text_color_hover) . ";}"."\n";
		}		

		$bottom_background_color = themesflat_get_opt( 'bottom_background_color');
		if ( $bottom_background_color !='' ) {
			$custom .= ".bottom { background:" . esc_attr($bottom_background_color) . ";}"."\n";
		}
		$bottom_text_color = themesflat_get_opt( 'bottom_text_color');
		if ( $bottom_text_color !='' ) {
			$custom .= ".bottom .copyright { color:" . esc_attr($bottom_text_color) . ";}"."\n";
		}
		$bottom_link_color = themesflat_get_opt( 'bottom_link_color');
		if ( $bottom_link_color !='' ) {
			$custom .= ".bottom .copyright a, .bottom ul li a, .bottom .copyright span a { color:" . esc_attr($bottom_link_color) . ";}"."\n";
		}
		$bottom_text_color_hover = themesflat_get_opt( 'bottom_text_color_hover');
		if ( $bottom_text_color_hover !='' ) {
			$custom .= ".bottom a:hover, .bottom ul li a:hover, .bottom .copyright span a:hover, .bottom .copyright a:hover, .bottom .copyright a:hover { color:" . esc_attr($bottom_text_color_hover) . ";}"."\n";
			$custom .= ".bottom .copyright a:before, .bottom .copyright span a:hover::before, .bottom .copyright a:before { background:" . esc_attr($bottom_text_color_hover) . ";}"."\n";
		}

    //GROUP PAGE TITLE
		$page_title_controls = themesflat_decode(themesflat_get_opt('page_title_controls'));
	    themesflat_render_box_position(".page-title",$page_title_controls);

	    //  Page Title Opacity
		$page_title_background_color = themesflat_get_opt( 'page_title_background_color');
		$custom .= ".page-title { background: ". esc_attr($page_title_background_color) .";}"."\n";

		$page_title_background_color_opacity = themesflat_get_opt( 'page_title_background_color_opacity');
		if ( $page_title_background_color_opacity !='' ) {
			$custom .= ".page-title { opacity:" . esc_attr($page_title_background_color_opacity) . "%; filter:alpha(opacity=" . esc_attr($page_title_background_color_opacity) . "); }"."\n";
		}
		
		$custom .= ".page-title h1, .page-title .pagetitle-description {color:" . themesflat_get_opt('page_title_text_color') . ";}"."\n";
		$custom .= ".page-title.parallax h1:after, .page-title.video h1:after {background:" . themesflat_get_opt('page_title_text_color') . ";}"."\n";

		$custom .= ".breadcrumbs span, .breadcrumbs span a, .breadcrumbs a, .breadcrumbs span i, .breadcrumbs span.trail-browse i {color:" . themesflat_get_opt('breadcrumb_color') . ";}"."\n";
				

	//GROUP BODY
		// Body color
		$body_text = themesflat_get_opt( 'body_text_color' );
		if ($body_text !='') {
			$custom .= "body, input, select, textarea { color:" . esc_attr($body_text) . "}"."\n";
			$custom .= "ul.iconlist .list-title .testimonial-content blockquote,.testimonial-content .author-info,.themesflat_counter.style2 .themesflat_counter-content-right,.themesflat_counter.style2 .themesflat_counter-content-left, .page-links a:focus,.widget_search .search-form input[type=search],.entry-meta ul,.entry-meta ul.meta-right,.entry-footer strong, .themesflat_button_container .themesflat-button.no-background, .blog-single .entry-footer .tags-links a, .navigation.posts-navigation .nav-links li a .meta-nav, .themesflat-price-product del { color:" . esc_attr($body_text) . "}"."\n";
			//border bodycolor
			$custom .= ".widget .widget-title:after, .widget .widget-title:before,ul.iconlist li.circle:before { background-color:" . esc_attr($body_text) . "}"."\n";
		}

		// background bodycolor
	    if ( themesflat_get_opt ('body_background_color') !='' ) {
			$custom .= "body, .page-wrap, .boxed .themesflat-boxed { background-color:" . esc_attr(themesflat_get_opt ('body_background_color')) ." ; } "."\n";
	    }
	
	    // Primary color
		$primary_color = themesflat_get_opt('primary_color');
		if (themesflat_get_opt_elementor('primary_color') != '') {
		    $primary_color = themesflat_get_opt_elementor('primary_color');
		}
    	if ( $primary_color !='' ) {

			$custom .= ' :root { --theme-primary-color:' . esc_attr($primary_color) . " }"."\n";
			$custom .= ".logged-in-as a:hover,a:hover, .comments-area ol.comment-list article .comment_content .comment_meta .comment_author a:hover, .comment-list .comement_reply a, .widget.widget_block ul.wp-block-latest-posts li a:hover, .widget ul li a:hover, .widget ol li a:hover, article .entry-title a:hover,article .entry-title a:hover, .item article .entry-title a:hover { color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= ".go-top:hover, .wp-block-button__link, .is-style-outline>.wp-block-button__link, .wp-block-button__link.is-style-outline { background:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= "textarea:focus, input[type=\"text\"]:focus, input[type=\"password\"]:focus, input[type=\"datetime\"]:focus, input[type=\"datetime-local\"]:focus, input[type=\"date\"]:focus, input[type=\"month\"]:focus, input[type=\"time\"]:focus, input[type=\"week\"]:focus, input[type=\"number\"]:focus, input[type=\"email\"]:focus, input[type=\"url\"]:focus, input[type=\"search\"]:focus, input[type=\"tel\"]:focus, input[type=\"color\"]:focus, .sidebar .wpcf7-form textarea:focus, input[type='radio']:checked { border-color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= " input[type=\"button\"]:hover, input[type=\"reset\"]:hover, input[type=\"submit\"]:hover, mark, ins, .draw-border a,input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], .wp-block-file .wp-block-file__button,  input[type='radio']:checked:before, .block-get-a-quote .overlay-color, .themesflat-top .btn-topbar { background:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= "select:focus, .draw-border.second-color a:hover::before, .draw-border.second-color a:hover::after, .draw-border.second-color button:hover > span::before, .draw-border.second-color button:hover > span::after, .widget_search form input[type=\"search\"]:focus, .wp-block-search .wp-block-search__input:focus, .footer .mc4wp-form input[type=\"email\"]:focus { border-color:" . esc_attr($primary_color) . " !important;}"."\n";
    		$custom .= '#mainnav ul.sub-menu > li > a > span, #mainnav_canvas ul li a > span   { background-color:' . esc_attr($primary_color) . " }"."\n";
		
			//color
			$custom .= "  blockquote em a:hover, blockquote i,blockquote cite a, .navigation.posts-navigation .nav-links a:hover, .widget_calendar table #today:hover, .widget_calendar table #today a:hover, .widget_calendar table tbody tr a:hover, .widget_calendar nav a:hover, article .post-meta .item-meta a:hover, .widget.widget_latest_news li .text .post-date i, .widget.widget-recent-news li .text h6 a:hover, .widget.widget_latest_news li .text h6 a:hover, blockquote a:hover, .widget.widget_recent_entries ul li a:hover, #mainnav_canvas ul li.current-menu-item > a, #mainnav_canvas ul li.current_page_item > a, #mainnav_canvas ul li.current-menu-ancestor > a, #mainnav_canvas ul li.current-menu-parent > a, .tags-links a:hover, .post-meta a:hover, #mainnav_canvas ul li a:hover, .sidebar .widget.widget_nav_menu ul li a:hover, .widget.widget_meta ul li a:hover{ color:" . esc_attr($primary_color) . ";}"."\n";
			
			//sidebar
			$custom .= ".draw-border.second-color a:hover, .draw-border.second-color button:hover,  .wishlist_table span.wishlist-in-stock, #footer .widget_calendar nav a:hover, #footer .widget_calendar table tbody tr a:hover { color:" . esc_attr($primary_color) . "!important;}"."\n";
			$custom .= ".double-bounce3, .double-bounce4, .widget .widget-title:after, .widget .tagcloud a:hover, .btn-menu:before, .btn-menu:after, .btn-menu span, .info-footer .wrap-info-item  { background: ". esc_attr($primary_color) .";}"."\n";
			
			// Color RGBA
			$primary_color_rgba = themesflat_hex2rgba($primary_color, 0.06);
			$custom .= ' :root { --theme-primary-rgba:' . esc_attr($primary_color_rgba) . " }"."\n";
		} 			    

	$custom = apply_filters('themesflat/render/style',$custom);
	wp_add_inline_style( 'themesflat-inline-css', $custom );

}

add_action( 'wp_enqueue_scripts', 'themesflat_custom_styles' );