<?php
$feature_post = '';
global $themesflat_thumbnail;

$archive_month = get_the_time('m'); 
$archive_day   = get_the_time('d'); 

switch ( get_post_format() ) {	
	case 'video':	
		$video = themesflat_meta('video_url');
		if ( !$video ) 
			break;
		global $_wp_additional_image_sizes;	
		$video_size = array( 
			'height' => $_wp_additional_image_sizes[$themesflat_thumbnail]['height'],
			'width' => $_wp_additional_image_sizes[$themesflat_thumbnail]['width']
			);
		$end = "";
		if ( has_post_thumbnail() ){
			$feature_post .= '<div class="themesflat_video_embed">';
			$feature_post .= get_the_post_thumbnail(null,$themesflat_thumbnail).'
			<div class="video-video-box-overlay">
				<div class="video-video-box-button-sm video-box-button-lg">					
					<button class="video-video-play-icon" data-izimodal-open="#format-video">
						<i class="fas fa-play"></i>
					</button>
				</div>					
			</div>';
			$end = '</div>
			<div class="izimodal" id="format-video" data-izimodal-width="850px" data-iziModal-fullscreen="true">
			    <iframe height="430" src="'.esc_url($video).'" class="full-width shadow-primary" style="width: 100%; max-width: 100%;"></iframe>
			</div>';
		}
		$feature_post .= $end;
	break;

	case 'audio':
		$audio_url = themesflat_meta('audio_url');
		echo '<div class="themesflat_audio">'.$audio_url.'</div>';
	break;

	default:

		$size = is_single() ? 'themesflat-blog' : $themesflat_thumbnail;
		
		$thumb = get_the_post_thumbnail( get_the_ID(), $size );
		if ( empty( $thumb ) )
			return;

		$feature_post .= get_the_post_thumbnail( get_the_ID(), $size );
}

if ( $feature_post ): ?>
	<div class="featured-post"> 
	<?php echo wp_kses($feature_post, themesflat_kses_allowed_html()); ?>
	</div>

<?php
endif;
?>