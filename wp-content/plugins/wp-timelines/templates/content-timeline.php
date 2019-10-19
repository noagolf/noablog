<?php
global $style, $post, $ajax_load, $ID, $animations, $posttype,$show_media, $taxonomy,$full_content,$feature_label,$lightbox,$hide_img,$img_size,$hide_title,$back_p;
if($img_size=='' && $style=='wide_img'){ $img_size = 'wptl-560x340';}
else if($img_size==''){ $img_size = 'wptl-320x220';}
$class = 'filter-'.$ID.'_'.get_the_ID();
if($animations!=''){
	$animations = ' scroll-effect';
}
if($ajax_load==1){ $class .=' de-active';}
$icon = get_post_meta( $post->ID, 'wpex_icon', true ) !='' ? get_post_meta( $post->ID, 'wpex_icon', true ) : 'fa-square no-icon';
$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img', true );
$we_eventcolor = get_post_meta( $post->ID, 'we_eventcolor', true );
$custom_link = wpex_custom_link($back_p);
$wpex_felabel ='';
if($feature_label==1){
	$wpex_felabel = get_post_meta( $post->ID, 'wpex_felabel', true );
	if($posttype!='wp-timeline' && $wpex_felabel==''){
		global $year_post;
		if(!isset($year_post) || $year_post==''){
			$wpex_felabel = $year_post = get_the_date('Y');
		}elseif($year_post!= get_the_date('Y')){
			$wpex_felabel = $year_post = get_the_date('Y');
		}
	}
	if($wpex_felabel!=''){
		$class .=' wptl-feature';
	}
}
$link_lb = '';
if($lightbox==1){
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
	$link_lb  = isset($image_src[0]) ? $image_src[0] : '';
}
if($full_content=='1' || $full_content=='lightbox'){
    $no_link = 'javascript:;';
    $custom_link = apply_filters( 'wptl_link_in_fullcontent', $no_link, $custom_link);
}
?>
<li <?php post_class($class.' '.ex_wptl_lightbox($full_content,$ID,'class'));?> <?php echo 'data-id="filter-'.$ID.'_'.get_the_ID().'"';?> <?php echo ex_wptl_lightbox($full_content,$ID,'data'); ?>>
    <div class="<?php echo esc_attr($animations);?>">
        <?php ex_wptl_lightbox($full_content,$ID,''); ?>
        <time class="wpex-timeline-time" datetime="<?php echo esc_attr(get_the_date( get_option( 'time_format' ) ).' '.get_the_date( get_option( 'date_format' ) ));?>">
            <?php if(has_post_thumbnail(get_the_ID()) && $style!='wide_img' && $hide_img!=1){?>
                <a href="<?php echo $link_lb!='' ? $link_lb : $custom_link;?>" title="<?php the_title_attribute();?>">
                <span class="info-img">
                	<?php the_post_thumbnail('post-thumbnail');?>
                </span>
                </a>
            <?php }?>
            <span class="exclearfix"></span>
            <?php 
			$hide_lb= false;
			if($style=='wide_img'){ $hide_lb = true;}
            if($style!='icon'){wpex_tmfulldate($hide_lb);}?>
        </time>
        <div class="wpex-timeline-label">
            <?php 
            if($style=='icon' && $hide_img!=1){
				if($link_lb==''){ $link_lb = $custom_link;}
				wpex_tmbigdate($show_thumb=true,$link_lb);
			}
			if($style!='icon' && $style!='wide_img' && $show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
				echo '<div class="wpex-content-left">'.wptl_audio_video_iframe().'</div>';
			}
			?>
            <div class="timeline-details">
                <?php
				if($style=='wide_img' && $show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo wptl_audio_video_iframe();
				}elseif(($style=='wide_img') && has_post_thumbnail(get_the_ID())){?>
                    <a class="img-left" href="<?php echo $link_lb!='' ? $link_lb : $custom_link;?>" title="<?php the_title_attribute();?>">
                        <span class="info-img">
							<?php  the_post_thumbnail($img_size);?>
                        </span>
                    </a>
                <?php }?>
                <div class="tlct-shortdes">
                    <?php
					wptl_title_html($hide_title,$custom_link); 
                    $cat_html = wptl_show_cat($posttype, $taxonomy);
                    if($cat_html!=''){?>
                    <div class="wptl-more-meta">
                        <?php echo $cat_html;?>
                    </div>
                    <?php }?>
                    <div class="wptl-excerpt">
                    	<?php  echo wptl_timeline_desc($full_content,$show_media); ?>
                    </div>
                </div>
                <?php if($style!='wide_img' && $full_content!='1'){?>
                <div class="wptl-readmore">
                    <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                        <?php echo exwptl_get_option('exwptl_text_ct','exwptl_advanced_options')!='' ? exwptl_get_option('exwptl_text_ct','exwptl_advanced_options') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
                <?php }?>
            </div>
            <div class="exclearfix"></div>
        </div>
        <?php if($style=='wide_img' && $full_content!='1'){?>
            <div class="wptl-readmore-center">
                <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                    <?php echo exwptl_get_option('exwptl_text_ct','exwptl_advanced_options')!='' ? exwptl_get_option('exwptl_text_ct','exwptl_advanced_options') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        <?php }?>
    </div>
    <div class="wpex-timeline-icon">
    	<?php if($wpex_icon_img!=''){ $icon = str_replace("no-icon","icon-img",$icon);}?>
        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa.icon-img:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
			.wpex li.post-<?php the_ID();?> .timeline-details .wptl-readmore > a:hover,
			#timeline-<?php echo esc_attr($ID);?> li.post-<?php the_ID();?> .wpex-timeline-icon .fa{ background:<?php echo esc_attr($we_eventcolor);?>}
			.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
			.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
			.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-time span:last-child,
			.wpex-timeline-list.show-icon li.post-<?php the_ID();?> .wpex-timeline-icon .fa:not(.no-icon):not(.icon-img):before{color:<?php echo esc_attr($we_eventcolor);?>;}
			.wpex li.post-<?php the_ID();?> .timeline-details .wptl-readmore > a{ border-color:<?php echo esc_attr($we_eventcolor);?>;}
			<?php 
            $wpex_rtl_mode = exwptl_get_option('exwptl_enable_rtl','exwptl_js_css_file_options');
			if($wpex_rtl_mode=='yes'){?>
				.left-tl:not(.show-icon) .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label{border-right-color: <?php echo esc_html($we_eventcolor);?>;}
				.left-tl .wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before{border-left-color: <?php echo esc_html($we_eventcolor);?>;}
				<?php
			}
		
		}?>
    </style>
    <?php } ?>
    <?php if($wpex_felabel!=''){
			echo '<div class="wptl-feature-name"><span>'.$wpex_felabel.'</span></div>';
	}?>
    <?php echo isset($year_post) && $year_post!='' ? '<input type="hidden" class="crr-year" value="'.$year_post.'">' : ''; ?>
</li>