<?php
function parse_wpex_timeline_horizontal_func($atts, $content){
	global $style,$posttype,$show_media,$show_label,$taxonomy,$full_content,$hide_thumb,$back_p;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$style = isset($atts['style']) && $atts['style']!='' ? $atts['style'] : 'left';
	if($style=='left-side'){ $style = 'left';}
	$layout 		= isset($atts['layout']) && $atts['layout']!='' ? $atts['layout'] : 'horizontal';
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$taxonomy 		=isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '6';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$meta_value 	= isset($atts['meta_value']) ? $atts['meta_value'] : '';
	$slidesshow = isset($atts['slidesshow']) && $atts['slidesshow']!='' ? $atts['slidesshow'] : 5;
	$autoplay 		= isset($atts['autoplay']) && $atts['autoplay'] == 1 ? 1 : 0;
	$class 		= isset($atts['class']) && $atts['class'] !='' ? $atts['class'] : '';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$show_label 		= isset($atts['show_label']) ? $atts['show_label'] : '0';
	$show_all 		= isset($atts['show_all']) ? $atts['show_all'] : '0';
	$header_align 		= isset($atts['header_align']) ? $atts['header_align'] : '';
	$content_align 		= isset($atts['content_align']) ? $atts['content_align'] : '1';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	$hide_thumb 		= isset($atts['hide_thumb']) ? $atts['hide_thumb'] : '0';
	$arrow_position 		= isset($atts['arrow_position']) ? $atts['arrow_position'] : '';
	$toolbar_position 		= isset($atts['toolbar_position']) ? $atts['toolbar_position'] : 'top';
	$autoplayspeed 		= isset($atts['autoplayspeed']) && is_numeric($atts['autoplayspeed']) ? $atts['autoplayspeed'] : '';
	$start_on 		= isset($atts['start_on']) && $atts['start_on']!='' ? $atts['start_on'] : '0';
	
	$loading_effect 		= isset($atts['loading_effect']) ? $atts['loading_effect'] : '';
	$enable_back 		= isset($atts['enable_back']) ? $atts['enable_back'] : '';
	$infinite 		= isset($atts['infinite']) ? $atts['infinite'] : '';
	$back_p ='';
	if($enable_back=='yes'){
		global $wp_query; $page_idcr =  $wp_query->queried_object_id;
		$back_p 		= isset($atts['back_p']) ? $atts['back_p'] : $page_idcr;
		if(!isset($atts['back_p']) || $atts['back_p']==''){ $atts['back_p'] = $back_p;}
	}
	if($arrow_position=='top'){
		$class = $class.' arrow-top';
	}
	if($layout=='hozsteps'){
		$class = $class.' tl-hozsteps';
		if($header_align==''){ $header_align = 'left';}
	}
	if($content_align=='left'){
		$class = $class.' tl-ct-left';
	}
	$args = wpex_timeline_query($posttype, $count, $order, $orderby, $cat, $tag, $taxonomy, $meta_key, $ids,false,false, $meta_value);
	ob_start();
	$the_query = new WP_Query( $args );
	$it = $the_query->post_count;
	if($it < ($start_on + 1)){ $start_on = 0;}
	if($it <= $slidesshow){
		$slidesshow = $it;
		$class = $class.' tlhl-full';
	}
	if($arrow_position != 'top'){
		$class = $class.' no-arr-top';
	}
	if($show_all==1){
		$slidesshow = $it;
		$header_align = 'left';
		$class = $class.' show-all-items';
	}
	if($loading_effect == 1){
		$class = $class.' ld-screen';
	}
	$wpex_load_css = exwptl_get_option('exwptl_css_load','exwptl_js_css_file_options');
	$wpex_rtl_mode = exwptl_get_option('exwptl_enable_rtl','exwptl_js_css_file_options');
	if($wpex_load_css =='shortcode'){
		wp_enqueue_style( 'wpex-ex_s_lick', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick.css');
		wp_enqueue_style( 'wpex-ex_s_lick-theme', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick-theme.css');
		wp_enqueue_style('wpex-timeline-css');
		wp_enqueue_style('wpex-horiz-css');
		wp_enqueue_style('wpex-timeline-dark-css');
		if($wpex_rtl_mode=='yes'){
			wp_enqueue_style('wpex-timeline-rtl-css', WPEX_TIMELINE.'css/rtl.css');
		}
	}
	if($full_content=='lightbox'){
		wp_enqueue_style('extl-lightbox', WPEX_TIMELINE .'css/glightbox.css','1.0');
		wp_enqueue_script( 'extl-lightbox', WPEX_TIMELINE .'/js/glightbox.min.js', array( 'jquery' ),'1.0', true );
	}
	wp_enqueue_script( 'wpex-ex_s_lick', WPEX_TIMELINE.'js/ex_s_lick/ex_s_lick.js', array( 'jquery' ) );
	wp_enqueue_script( 'wpex-timeline', WPEX_TIMELINE.'js/template.min.js', array( 'jquery' ) );
	if($the_query->have_posts()){?>
        <div class="wpex horizontal-timeline wpex-horizontal-<?php echo esc_attr($style);?> <?php echo esc_attr($class);?>" data-layout="<?php echo esc_attr($layout);?>" data-autoplay="<?php echo esc_attr($autoplay)?>" data-speed="<?php echo esc_attr($autoplayspeed)?>" data-rtl="<?php echo esc_attr($wpex_rtl_mode)?>" id="horizontal-tl-<?php echo esc_attr($ID)?>" data-id="horizontal-tl-<?php echo esc_attr($ID)?>" data-slidesshow="<?php echo esc_attr($slidesshow)?>" data-arrowpos="<?php echo esc_attr($arrow_position)?>" data-center="<?php echo esc_attr($header_align)?>" data-start_on="<?php echo esc_attr($start_on)?>" data-count="<?php echo esc_attr($it);?>" data-infinite="<?php echo esc_attr($infinite);?>">
        	<?php if($loading_effect==1){?>
                <div class="wpextl-loadcont"><div class="wpextl-loadicon"></div></div>
                <script>
                    jQuery(window).load(function(e) {
						jQuery("#horizontal-tl-<?php echo esc_attr($ID)?>").addClass('at-childdiv');
					});
					setTimeout(function() {
                        jQuery("#horizontal-tl-<?php echo esc_attr($ID)?>").addClass('at-childdiv');
                    }, 7000);
                </script>
            <?php }
			if($toolbar_position=='bottom'){?>
            <ul class="horizontal-content">
                    <?php while($the_query->have_posts()){ $the_query->the_post(); 
                        wpex_template_plugin('content-slider');?>
                    <?php }?>
            </ul>
            <?php }?>
            <div class="hor-container">
            <span class="timeline-hr"></span>
            <span class="timeline-pos-select"></span>
            <ul class="horizontal-nav">
				<?php while($the_query->have_posts()){ $the_query->the_post();
                    $posttypes = exwptl_get_option('exwptl_posttype','exwptl_advanced_options');
					if($posttype == 'wp-timeline' || (is_array($posttypes) && in_array($posttype,$posttypes))){
                        if($show_label==1){
                            $wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
                        }else{
                            $wpex_sublabel = wpex_date_tl();
                        }
                    }else{
                        $date_id = get_the_date( get_option( 'date_format' ) );
                        $wpex_sublabel = date_i18n( 'd', strtotime( $date_id ) ).' - '.date_i18n( 'M', strtotime( $date_id ) );
                    }
                    if($wpex_sublabel==''){ $wpex_sublabel = "&nbsp;";}
					$icon = get_post_meta( get_the_ID(), 'wpex_icon', true ) !='' ? get_post_meta( get_the_ID(), 'wpex_icon', true ) : 'fa-circle no-icon';
					?>
                    <li class="<?php echo 'ictl-'.get_the_ID();?>">
                    	<span class="tl-point"><?php echo $wpex_sublabel;?><i class="fa <?php echo esc_attr($icon);?>"></i></span>
                    	<?php 
						$we_eventcolor = get_post_meta( get_the_ID(), 'we_eventcolor', true );
						$wpex_icon_img = get_post_meta( get_the_ID(), 'wpex_icon_img', true );
						if(($we_eventcolor!='' || $wpex_icon_img!='') && $layout=='hozsteps'){?>
						<style type="text/css">
							<?php if($wpex_icon_img!=''){?>
							.wpex.horizontal-timeline.tl-hozsteps ul.horizontal-nav li.ictl-<?php echo get_the_ID();?> > .tl-point > i.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;color: transparent;}
							<?php }
							if($we_eventcolor!=''){?>
							.wpex.horizontal-timeline.tl-hozsteps ul.horizontal-nav li.ictl-<?php echo get_the_ID();?> > .tl-point > i{
								color:<?php echo esc_attr($we_eventcolor);?>;
							}
							<?php }?>
						</style>
						<?php }?>
                    </li>
                <?php }?>
            </ul>
            </div>
            <?php if($toolbar_position!='bottom'){?>
            <ul class="horizontal-content">
                    <?php while($the_query->have_posts()){ $the_query->the_post(); 
                        wpex_template_plugin('content-slider');?>
                    <?php }?>
            </ul>
            <?php }?>
        </div>
        <?php 
		
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'wpex_timeline_horizontal', 'parse_wpex_timeline_horizontal_func' );
