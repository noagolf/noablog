<?php
/**
 * @var array $instance
 */

	$atts = $instance;
	$style = isset($atts['style']) && $atts['style']!='' ? $atts['style'] : '';
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$taxonomy 		=isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '6';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$slidesshow = isset($atts['slidesshow']) && isset($atts['slidesshow']) > 0 ? $atts['slidesshow'] : '4';
	$number_excerpt =  isset($atts['number_excerpt'])&& $atts['number_excerpt']!='' ? $atts['number_excerpt'] : '10';
	$autoplay 		= isset($atts['autoplay']) && $atts['autoplay'] == 1 ? 1 : 0;
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$show_label 		= isset($atts['show_label']) ? $atts['show_label'] : '0';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	$hide_thumb 		= isset($atts['hide_thumb']) ? $atts['hide_thumb'] : '0';
	$autoplayspeed 		= isset($atts['autoplayspeed']) && is_numeric($atts['autoplayspeed']) ? $atts['autoplayspeed'] : '';
	$arrow_position 		= isset($atts['arrow_position']) ? $atts['arrow_position'] : '';
	$start_on 		= isset($atts['start_on']) ? $atts['start_on'] : '';
	$loading_effect 		= isset($atts['loading_effect']) ? $atts['loading_effect'] : '';
	$enable_back 		= isset($atts['enable_back']) ? $atts['enable_back'] : '';
	
	echo do_shortcode('[timeline_horizontal_multi style="'.$style.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$taxonomy.'" ids="'.$ids.'" count="'.$count.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" autoplay="'.$autoplay.'" show_media="'.$show_media.'" show_label="'.$show_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" arrow_position="'.$arrow_position.'" autoplayspeed="'.$autoplayspeed.'" start_on="'.$start_on.'" slidesshow="'.$slidesshow.'" loading_effect="'.$loading_effect.'" enable_back="'.$enable_back.'"]');
