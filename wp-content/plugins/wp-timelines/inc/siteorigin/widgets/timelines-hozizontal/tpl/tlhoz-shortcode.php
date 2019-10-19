<?php
/**
 * @var array $instance
 */

	$atts = $instance;
	$style = isset($atts['style']) && $atts['style']!='' ? $atts['style'] : 'left';
	$layout 		= isset($atts['layout']) && $atts['layout']!='' ? $atts['layout'] : 'horizontal';
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'wp-timeline';
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$taxonomy 		=isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '6';
	$slidesshow = isset($atts['slidesshow']) && $atts['slidesshow']!='' ? $atts['slidesshow'] : 5;
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$startit = isset($atts['position_start']) ? $atts['position_start'] : 1;
	$autoplay 		= isset($atts['autoplay']) && $atts['autoplay'] == 1 ? 1 : 0;
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$show_label 		= isset($atts['show_label']) ? $atts['show_label'] : '0';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	$hide_thumb 		= isset($atts['hide_thumb']) ? $atts['hide_thumb'] : '0';
	$arrow_position 		= isset($atts['arrow_position']) ? $atts['arrow_position'] : '';
	$show_all 		= isset($atts['show_all']) ? $atts['show_all'] : '0';
	$header_align 		= isset($atts['header_align']) ? $atts['header_align'] : '';
	$content_align 		= isset($atts['content_align']) ? $atts['content_align'] : '1';
	$toolbar_position 		= isset($atts['toolbar_position']) ? $atts['toolbar_position'] : 'top';
	$autoplayspeed 		= isset($atts['autoplayspeed']) ? $atts['autoplayspeed'] : '';
	$start_on 		= isset($atts['start_on']) ? $atts['start_on'] : '';
	$enable_back 		= isset($atts['enable_back']) ? $atts['enable_back'] : '';
	$loading_effect 		= isset($atts['loading_effect']) ? $atts['loading_effect'] : '';
			
			echo do_shortcode('[wpex_timeline_horizontal style="'.$style.'" layout="'.$layout.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$taxonomy.'" ids="'.$ids.'" count="'.$count.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" autoplay="'.$autoplay.'" show_media="'.$show_media.'" show_label="'.$show_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" arrow_position="'.$arrow_position.'" show_all="'.$show_all.'" header_align="'.$header_align.'" content_align="'.$content_align.'" toolbar_position="'.$toolbar_position.'" autoplayspeed="'.$autoplayspeed.'" start_on="'.$start_on.'" slidesshow="'.$slidesshow.'" loading_effect="'.$loading_effect.'" enable_back="'.$enable_back.'"]');
