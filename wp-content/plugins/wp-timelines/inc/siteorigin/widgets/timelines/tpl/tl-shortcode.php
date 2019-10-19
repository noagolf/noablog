<?php
/**
 * @var array $instance
 */

	$atts = $instance;
	$style = isset($atts['style']) ? $atts['style'] : '';
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$cat 		= isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$taxonomy 		= isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '9';
	$posts_per_page 		= isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '3';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$alignment 		= isset($atts['alignment']) && $atts['alignment']!='' ? $atts['alignment'] : 'center';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$show_history 		= isset($atts['show_history']) ? $atts['show_history'] : '';
	$feature_label 		= isset($atts['feature_label']) ? $atts['feature_label'] : '';
	$hide_title 		= isset($atts['hide_title']) ? $atts['hide_title'] : '';
	$hide_img 		= isset($atts['hide_img']) ? $atts['hide_img'] : '';
	$img_fullwidth 		= isset($atts['img_fullwidth']) ? $atts['img_fullwidth'] : '0';
	$img_size 		= isset($atts['img_size']) ? $atts['img_size'] : '';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';	
	$lightbox 		= isset($atts['lightbox']) ? $atts['lightbox'] : '0';
	$page_navi 		= isset($atts['page_navi']) ? $atts['page_navi'] : '0';			
	$filter_cat 		= isset($atts['filter_cat']) ? $atts['filter_cat'] : '';
	$start_label 		= isset($atts['start_label']) ? $atts['start_label'] : '';
	$end_label 		= isset($atts['end_label']) ? $atts['end_label'] : '';
	$animations 		= isset($atts['animations']) ? $atts['animations'] : '';
	$enable_back 		= isset($atts['enable_back']) ? $atts['enable_back'] : '';
	echo do_shortcode('[wpex_timeline style="'.$style.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$taxonomy.'" ids="'.$ids.'" count="'.$count.'" posts_per_page="'.$posts_per_page.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" alignment="'.$alignment.'" show_media="'.$show_media.'" show_history="'.$show_history.'" feature_label="'.$feature_label.'" full_content="'.$full_content.'" hide_img="'.$hide_img.'" hide_title="'.$hide_title.'"  img_size="'.$img_size.'" lightbox="'.$lightbox.'" page_navi="'.$page_navi.'" enable_back="'.$enable_back.'" start_label="'.$start_label.'" end_label="'.$end_label.'" animations="'.$animations.'" filter_cat="'.$filter_cat.'"]');
