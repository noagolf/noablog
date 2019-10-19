<?php
global $ID,$style, $post, $posttype,$show_media ,$show_label , $taxonomy, $number_excerpt, $full_content, $hide_thumb,$back_p;
$thumb_size = 'wptl-600x450';
if($style=='full-width'){
	$thumb_size = 'full';
}
if($full_content=='1' || $full_content=='lightbox'){
    $no_link = 'javascript:;';
    $custom_link = apply_filters( 'wptl_link_in_fullcontent', $no_link, $custom_link);
}
global $tl_query;
$i = 0;
$html_sl1 = $html_sl2 = $css ='';
while($tl_query->have_posts()){ $tl_query->the_post();
	$i++;
	$custom_link = wpex_custom_link($back_p);
	if($full_content=='1' || $full_content=='lightbox'){
	    $no_link = 'javascript:;';
	    $custom_link = apply_filters( 'wptl_link_in_fullcontent', $no_link, $custom_link);
	}
	$posttypes = exwptl_get_option('exwptl_posttype','exwptl_advanced_options');
	if($posttype == 'wp-timeline' || (is_array($posttypes) && in_array($posttype,$posttypes))){
        $datetl = wpex_date_tl();
    }else{
        $datetl = get_the_date( get_option( 'date_format' ) );
    }
	if($show_label!=1){
		$date_tl = $datetl;
		$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
	}else{
		$wpex_sublabel = $datetl;
		$date_tl = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
	}
	$wpex_sublabel = $wpex_sublabel!='' ? '<div class="wptl-more-meta"><span>'.$wpex_sublabel.'</span></div>' : '';
	$icon = get_post_meta( get_the_ID(), 'wpex_icon', true ) !='' ? get_post_meta( get_the_ID(), 'wpex_icon', true ) : 'fa-circle no-icon';
	$wpex_icon_img = get_post_meta( get_the_ID(), 'wpex_icon_img', true );
	if($wpex_icon_img==''){ $icon = $icon.' no-ic-img';}
	$tlp = '<span class="tl-point"><i class="fa '.esc_attr($icon).'"></i></span>';
	$mda ='';
	if($hide_thumb!='1' && $style!='3'){
		if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
				$mda.= '<div class="timeline-media">'.wptl_audio_video_iframe().'</div>';
		}elseif(has_post_thumbnail(get_the_ID())){
			$mda.= '<div class="timeline-media">
				<a href="'.$custom_link.'" title="'.the_title_attribute('echo=0').'">
				'.get_the_post_thumbnail(get_the_ID(),$thumb_size).'
				<span class="bg-opacity"></span>
				</a>
			</div>';
		}
	}
	$cttl= '';
	if($full_content=='1' && $hide_thumb!='1' && $show_media=='1'){
		$content =  preg_replace ('#<embed(.*?)>(.*)#is', ' ', get_the_content(),1);
		$content =  preg_replace ('@<iframe[^>]*?>.*?</iframe>@siu', ' ', $content,1);
		$content =  preg_replace ('/<source\s+(.+?)>/i', ' ', $content,1);
		$content =  preg_replace ('/\<object(.*)\<\/object\>/is', ' ', $content,1);
		$content =  preg_replace ('#\[video\s*.*?\]#s', ' ', $content,1);
		$content =  preg_replace ('#\[audio\s*.*?\]#s', ' ', $content,1);
		$content =  preg_replace ('#\[/audio]#s', ' ', $content,1);
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match);
		foreach ($match[0] as $amatch) {
			if(strpos($amatch,'soundcloud.com') !== false){
				$content = str_replace($amatch, '', $content);
			}elseif(strpos($amatch,'youtube.com') !== false){
				$content = str_replace($amatch, '', $content);
			}
		}
		$content = preg_replace('%<object.+?</object>%is', '', $content,1);
		$cttl .= apply_filters('the_content',$content);
	}elseif($full_content=='1'){
		$cttl .= apply_filters('the_content', get_the_content());
	}else if($number_excerpt!='0'){
		$cttl .= wp_trim_words(get_the_excerpt(),$number_excerpt,$more = '...');
	}
	$rm = '';
	if($full_content!='1'){
		$trslt = exwptl_get_option('exwptl_text_ct','exwptl_advanced_options')!='' ? exwptl_get_option('exwptl_text_ct','exwptl_advanced_options') : esc_html__('Continue reading','wp-timeline');
	    $rm .= '<div class="wptl-readmore"><a href="'.$custom_link.'" title="'.the_title_attribute('echo=0').'">'.$trslt.'</a></div>';
	}
	$postClass = join( ' ', get_post_class(ex_wptl_lightbox($full_content,$ID,'class')));
	if($i%2 == 1){
		$html_sl1 .= '
		<li class="extl-sbd-1 ictl-'.get_the_ID().'">
			'.$tlp.'
			<div class="extl-sbd-details timeline-details '.$postClass.'" '.ex_wptl_lightbox($full_content,$ID,'data').'>
				'.ex_wptl_lightbox($full_content,$ID,'html').'
				'.$mda.'
				<h2><a href="'.$custom_link.'">'.get_the_title().'</a></h2>
				'.$wpex_sublabel.'
				<div class="extl-hoz-sbd-ct">'. $cttl.'</div>
				'.$rm.'
			</div>
		</li>
		';
		$html_sl2 .= '<li class="extl-sbd-2 tl-ifdate ictl-'.get_the_ID().'"><span class="extl-date">'.$date_tl.'</span></li>';
	}else{
		$html_sl1 .= '<li class="extl-sbd-1 tl-ifdate ictl-'.get_the_ID().'">'.$tlp.'<span class="extl-date">'.$date_tl.'</span></li>';
		$html_sl2 .= '
		<li class="extl-sbd-2 ictl-'.get_the_ID().'">
			<div class="extl-sbd-details timeline-details '.$postClass.'" '.ex_wptl_lightbox($full_content,$ID,'data').'>
				'.ex_wptl_lightbox($full_content,$ID,'html').'
				'.$mda.'
				<h2><a href="'.$custom_link.'">'.get_the_title().'</a></h2>
				'.$wpex_sublabel.'
				<div class="extl-hoz-sbd-ct">'. $cttl.'</div>
				'.$rm.'
			</div>
		</li>';
	}
	$we_eventcolor = get_post_meta( get_the_ID(), 'we_eventcolor', true );
	if(($we_eventcolor!='' || $wpex_icon_img!='')){
		if($wpex_icon_img!=''){
			$css .= '
			#horizontal-tl-'.$ID.' .extl-hoz-sbs li.ictl-'.get_the_ID().' > .tl-point > .fa.no-icon{ 
				background-image:url('.esc_url(wp_get_attachment_thumb_url( $wpex_icon_img )).'); 
				background-repeat: no-repeat; width:40px; visibility:visible;background-size: 100% auto; background-position: center; color:transparent;
			}
			#horizontal-tl-'.$ID.' .extl-hoz-sbs li.ictl-'.get_the_ID().' > .tl-point > i{
				color:'.esc_attr($we_eventcolor).';
				border-color:'.esc_attr($we_eventcolor).';
			}
			';
		}
	}



}
$class_st = 'style-'.$style;
echo '
<div class="extl-hoz-sbs '.esc_attr($class_st).'">
	<ul class="horizontal-nav extl-nav">'.$html_sl1.'</ul>
	<div class="sbs-line"></div>
	<ul class="horizontal-sl-2">'.$html_sl2.'</ul>
</div>
<style type="text/css">
	'.$css.'
</style>';