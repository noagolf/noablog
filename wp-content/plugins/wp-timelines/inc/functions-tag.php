<?php
if( !function_exists('wpex_tmbigdate')){
	function wpex_tmbigdate($show_thumb=false,$link_lb=false){
		global $posttype,$show_media;
		$posttypes = exwptl_get_option('exwptl_posttype','exwptl_advanced_options');
		if(is_array($posttype)){
			$posttype = get_post_type(get_the_ID());
		}
		if($posttype == 'wp-timeline' || (is_array($posttypes) && in_array($posttype,$posttypes))){
			$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
			$wpex_date = wpex_date_tl();
			$sb_dt = explode(" ",$wpex_date);
			if(isset($sb_dt[1])){
				$wpex_first = $sb_dt[0];
				$wpex_last = $sb_dt[1];
				if(isset($sb_dt[2])){
					$wpex_last = $sb_dt[1].' '.$sb_dt[2];
				}
			}else{
				$sb_dt = explode("/",$wpex_date);
				if(isset($sb_dt[1])){
					$wpex_first = $sb_dt[0];
					$wpex_last = $sb_dt[1];
					if(isset($sb_dt[2])){
						$wpex_last = $sb_dt[1].'/'.$sb_dt[2];
					}
				}else{
					$sb_dt = explode(",",$wpex_date);
					if(isset($sb_dt[1])){
						$wpex_first = $sb_dt[0];
						$wpex_last = $sb_dt[1];
						if(isset($sb_dt[2])){
							$wpex_last = $sb_dt[1].','.$sb_dt[2];
						}
					}else{
						$sb_dt = explode("-",$wpex_date);
						if(isset($sb_dt[1])){
							$wpex_first = $sb_dt[0];
							$wpex_last = $sb_dt[1];
							if(isset($sb_dt[2])){
								$wpex_last = $sb_dt[1].'-'.$sb_dt[2];
							}
						}else{
							$wpex_first = $wpex_date;
							$wpex_last ='';
						}
					}
				}
			}
			if(get_post_meta( get_the_ID(), 'wpex_date', true )==''){
				if(!is_numeric($wpex_first) && strlen($wpex_first) > 5) $wpex_first = substr($wpex_first, 0, 5);
			} 
		}else{
			$wpex_sublabel = get_the_date('l');
			$wpex_first = get_the_date('d');
			$wpex_last = get_the_date( 'F' ).', '.get_the_date( 'Y' );
		}
		if($wpex_sublabel==''){ $wpex_sublabel = "&nbsp;";}
		if($wpex_last==''){ $wpex_last = "&nbsp;";}
		$html ='
		<div class="wpex-content-left">
            <div class="wpex-leftdate">
                <span class="tlday">'.$wpex_first.'</span>
                <div>
                    <span>'.$wpex_sublabel.'</span>
                    <span>'.$wpex_last.'</span>
                </div>
            </div>';
			if(isset($link_lb) && $link_lb!=''){
				$url_lb = $link_lb;
			}else{
				$url_lb = get_permalink(get_the_ID());
			}
			if( $show_thumb == true){
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					$html .= wptl_audio_video_iframe();
				}elseif(has_post_thumbnail(get_the_ID())){
					$html .='
					<a href="'.$url_lb.'" title="'.the_title_attribute('echo=0').'">
						<span class="info-img">'.get_the_post_thumbnail(get_the_ID(),'wptl-320x220').'</span>
					</a>';
				}
            }
			$html .='
        </div>
		';
		$html = apply_filters( 'wpex_tmbigdate', $html, $show_thumb );
		echo $html;
	}
}
if( !function_exists('wpex_tmfulldate')){
	function wpex_tmfulldate($hide_lb=false){
		global $posttype;
		$posttypes = exwptl_get_option('exwptl_posttype','exwptl_advanced_options');
		if($posttype == 'wp-timeline' || (is_array($posttypes) && in_array($posttype,$posttypes))){
			$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
			$wpex_date = wpex_date_tl();
		}else{
			$wpex_sublabel = get_the_date('l');
			$wpex_date = get_the_date( get_option( 'date_format' ) );
		}
		$html ='';
		if(!isset($hide_lb) || $hide_lb!=true){
			$html .='
			<span class="info-h">'.$wpex_sublabel.'</span>';
		}
		$html .='
		<span class="tll-date">
			'.$wpex_date.'
		</span>';
		$html = apply_filters( 'wpex_tmfulldate', $html );
		echo $html;
	}
}
// Html cat filter
if(!function_exists('extl_show_child_inline')){
	function extl_show_child_inline($id,$tax,$term,$count_stop,$inline){
		if ($count_stop < 2) {
			return;
		}
		$charactor ='';
		if ($count_stop == 5) {
			$charactor ='— ';
		}elseif ($count_stop == 4) {
			$charactor ='—— ';
		}elseif ($count_stop == 3) {
			$charactor ='——— ';
		}elseif ($count_stop == 2) {
			$charactor ='———— ';
		}
		$args_child = array(
			'child_of' => $term->term_id,
			'parent' => $term->term_id,
			'hide_empty'        => true,
		);
		// if (!empty($cats) && !is_numeric($cats[0])) {
		// 	$args_child['slug'] = $cats;
		// }else if (!empty($cats)) {
		// 	$args_child['include'] = $cats;
		// }
		$second_level_terms = get_terms($tax, $args_child);
		ob_start();
		if ($second_level_terms) {
			$count_stop = $count_stop -1;
			if ($inline != 'inline') {
				foreach ($second_level_terms as $second_level_term) {
					echo '<option value="'. $second_level_term->slug .'" data-id="'.$id.'">'.$charactor. $second_level_term->name .'</option>';
					echo extl_show_child_inline($id,$tax,$second_level_term,$count_stop,'');
				}
			}else{
				echo '<span class="extl-caret"></span>';
		        echo '<ul class="extl-ul-child">';
		        foreach ($second_level_terms as $second_level_term) {
		            $second_term_name = $second_level_term->name;
		            echo '<li class="extp-child" data-id="'.$id.'" data-tax="'.$tax.'" data-value="'. $second_level_term->slug .'">'.$second_term_name .'';
		            echo extl_show_child_inline($id,$tax,$second_level_term,$count_stop,'inline');
		            echo '</li>';
		        }

		        echo '</ul>';
		    }
	    }
	    $html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
if( !function_exists('wpex_filterby_cat')){
	function wpex_filterby_cat($tax,$cat,$ID){
		global $posttype;
		if($tax ==''){
			if($posttype == 'wp-timeline'){
				$tax = 'wpex_category';
			}elseif($posttype == 'post'){ $tax = 'category';}
		}
		if($tax==''){ return;}
		$args = array(
			'hide_empty'        => true,
			'parent'        => '0',
		);
		if($cat!=''){
			$cat = explode(",", $cat);
			if(is_numeric($cat[0])){
				$args['include'] = $cat;
			}else{
				$args['slug'] = $tax;
			}
		}
		$terms = get_terms($tax, $args);
		$html = $$options = '';
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ 
			$html .='
			<ul class="wpex-taxonomy-filter">
				<li class="item-pr active crr-at" data-id="'.$ID.'" data-tax="'.$tax.'" data-value="">'. esc_html__('All','wp-timeline') .'</li>';
				$options .= '<option value="" data-id="'.$ID.'" data-tax="'.$tax.'">'. esc_html__('All','wp-timeline') .'</option>';
				foreach ( $terms as $term ) {
					$html .= '<li class="item-pr" data-id="'.$ID.'" data-tax="'.$tax.'" data-value="'. $term->slug .'">'. $term->name .''.extl_show_child_inline($ID,$tax,$term,5,'inline').'</li>';
					$options .= '<option value="'. $term->slug .'" data-id="'.$ID.'" data-tax="'.$tax.'">'. $term->name .'</option>';
					$options .= extl_show_child_inline($ID,$tax,$term,5,'');
				}
			$html .='</ul>';
			$selectbox = '<select name="wpex_taxonomy" class="wpex-taxonomy-select">'.$options.'</select>';
			$html = '<div class="wptl-filter-box">'.$html.$selectbox.'</div>';
		}
		$html = apply_filters( 'wpex_filterby_cat', $html );
		echo $html;
	}
}

if( !function_exists('wpex_filterby_year')){
	function wpex_filterby_year($year,$ID){
		$tax = 'wpex_year';
		$args = array(
			'hide_empty'        => true, 
		);
		if($year!=''){
			$year = explode(",", $year);
			if(is_numeric($year[0])){
				$args['include'] = $year;
			}else{
				$args['slug'] = $tax;
			}
		}
		$terms = get_terms($tax, $args);
		$html = '';
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ 
			$nub_t = count($terms);
				$i=0;
				foreach ( $terms as $term ) {
					$i++;
					$html .='<span data-id="'.$ID.'" id="tl-'.$term->slug.'" data-value="'. $term->term_id .'">'. $term->name .'</span>';
				}
		}
		$html = apply_filters( 'wpex_filterby_year', $html );
		return $html;
	}
}




if(!function_exists('wptl_social_share')){
	function wptl_social_share( $id = false){
		$id = get_the_ID();
		$tl_share_button = array('fb','tw','li','tb','gg','pin','vk','em',);
		ob_start();
		if(is_array($tl_share_button) && !empty($tl_share_button)){
			?>
			<div class="wptl-social-share">
				<?php if(in_array('fb', $tl_share_button)){ ?>
					<span class="facebook">
						<a class="trasition-all" title="<?php esc_html_e('Share on Facebook','exthemes');?>" href="#" target="_blank" rel="nofollow" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+'<?php echo urlencode(get_permalink($id)); ?>','facebook-share-dialog','width=626,height=436');return false;"><i class="fa fa-facebook"></i><?php esc_html_e('Share on Facebook','exthemes');?>
						</a>
					</span>
				<?php }
	
				if(in_array('tw', $tl_share_button)){ ?>
					<span class="twitter">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on Twitter','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://twitter.com/share?text=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;url=<?php echo urlencode(get_permalink($id)); ?>','twitter-share-dialog','width=626,height=436');return false;"><i class="fa fa-twitter"></i>
                        <?php esc_html_e('Share on Twitter','exthemes');?>
						</a>
					</span>
				<?php }
	
				if(in_array('li', $tl_share_button)){ ?>
						<span class="linkedin">
							<a class="trasition-all" href="#" title="<?php esc_html_e('Share on LinkedIn','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($id)); ?>&amp;title=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;source=<?php echo urlencode(get_bloginfo('name')); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fa fa-linkedin"></i>
                            <?php esc_html_e('Share on LinkedIn','exthemes');?>
							</a>
						</span>
				<?php }
	
				if(in_array('tb', $tl_share_button)){ ?>
					<span class="tumblr">
					   <a class="trasition-all" href="#" title="<?php esc_html_e('Share on Tumblr','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($id)); ?>&amp;name=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>','tumblr-share-dialog','width=626,height=436');return false;"><i class="fa fa-tumblr"></i>
                       <?php esc_html_e('Share on Tumblr','exthemes');?>
					   </a>
					</span>
				<?php }
	
				if(in_array('gg', $tl_share_button)){ ?>
					 <span class="google-plus">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on Google Plus','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($id)); ?>','googleplus-share-dialog','width=626,height=436');return false;"><i class="fa fa-google-plus"></i>
                        <?php esc_html_e('Share on Google Plus','exthemes');?>
						</a>
					 </span>
				 <?php }
	
				 if(in_array('pin', $tl_share_button)){ ?>
					 <span class="pinterest">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Pin this','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($id)) ?>&amp;media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($id))); ?>&amp;description=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fa fa-pinterest"></i>
                        <?php esc_html_e('Pin this','exthemes');?>
						</a>
					 </span>
				 <?php }
				 
				 if(in_array('vk', $tl_share_button)){ ?>
					 <span class="vk">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on VK','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//vkontakte.ru/share.php?url=<?php echo urlencode(get_permalink(get_the_ID())); ?>','vk-share-dialog','width=626,height=436');return false;"><i class="fa fa-vk"></i>
                        <?php esc_html_e('Share on VK','exthemes');?>
						</a>
					 </span>
				 <?php }
	
				 if(in_array('em', $tl_share_button)){ ?>
					<span class="email">
						<a class="trasition-all" href="mailto:?subject=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;body=<?php echo urlencode(get_permalink($id)) ?>" title="<?php esc_html_e('Email this','exthemes');?>"><i class="fa fa-envelope"></i>
                        <?php esc_html_e('Email this','exthemes');?>
						</a>
					</span>
				<?php }?>
			</div>
			<?php
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}

if(!function_exists('wptl_show_cat')){
	function wptl_show_cat($post_type, $tax=false, $show_once= false){
		if($post_type == 'wp-timeline'){
			return;
		}
		ob_start();
		if(isset($post_type) && $post_type!='post'){
			if($post_type == 'product' && class_exists('Woocommerce')){
				$tax = 'product_cat';
			}
			if(isset($tax) && $tax!=''){
				$terms = get_the_terms(get_the_ID(), $tax);
				if(!empty($terms) && ! is_wp_error( $terms )){
					$c_tax = count($terms);
					?>
					<span class="info-cat">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i>
						<?php
						$i=0;
						foreach ( $terms as $term ) {
							$i++;
							echo '<a href="'.get_term_link( $term ).'" title="' . esc_html__('View all posts in ') . $term->name . '">'. $term->name .'</a>';
							if($i != $c_tax){ echo ', ';}
						}
						?>
                    </span>
                    <?php
				}
			}
		}else{
			$category = get_the_category();
			if(!isset($show_once) || $show_once!='1'){
				if(!empty($category)){
					?>
					<span class="info-cat">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i>
						<?php the_category(', '); ?>
					</span>
					<?php  
				}
			}else{
				if(!empty($category)){
					?>
					<span class="info-cat">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i>
						<?php
						foreach($category as $cat_item){
							if(is_array($cat_item) && isset($cat_item[0]))
								$cat_item = $cat_item[0];
								echo '
									<a href="' . esc_url(get_category_link( $cat_item->term_id )) . '" title="' . esc_html__('View all posts in ') . $cat_item->name . '">' . $cat_item->name . '</a>';
								if($show_once==1){
									break;
								}
							}
							?>
                    </span>
                    <?php
				}
			}
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
if(!function_exists('wptl_audio_video_iframe')){
	function wptl_audio_video_iframe(){
		ob_start();
		echo '<div class="wptl-embed">';
		global $post;
		preg_match("/<embed\s+(.+?)>/i", $post->post_content, $matches_emb); if(isset($matches_emb[0])){ echo $matches_emb[0];}
		preg_match("/<source\s+(.+?)>/i", $post->post_content, $matches_sou) ;
		preg_match('/\<object(.*)\<\/object\>/is', $post->post_content, $matches_oj); 
		preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $post->post_content, $matches);
		preg_match( '#\[audio\s*.*?\]#s', $post->post_content, $matches_sc );
		preg_match( '#\[video\s*.*?\]#s', $post->post_content, $matches_scvd );
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $post->post_content, $match);
		if(!isset($matches_emb[0]) && isset($matches_sou[0])){
			echo $matches_sou[0];
		}else if(!isset($matches_sou[0]) && isset($matches_oj[0])){
			echo $matches_oj[0];
		}else if( !isset($matches_oj[0]) && isset($matches[0])){
			echo $matches[0];
		}else if( !isset($matches[0]) && isset($matches_sc[0])){
			 echo do_shortcode($matches_sc[0]);
		}else if( !isset($matches_sc[0]) && isset($matches_scvd[0])){
			 echo do_shortcode($matches_scvd[0]);
		}else if( !isset($matches_scvd[0]) && isset($match[0])){
			foreach ($match[0] as $matc) {
				if(strpos($matc,'soundcloud.com') !== false || strpos($matc,'youtube.com') !== false){
					echo wp_oembed_get($matc);
					break;
				}
			}
		}
		echo '</div>';
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}

if(!function_exists('wptl_timeline_desc')){
	function wptl_timeline_desc($full_content,$show_media){
		if($full_content=='1' && $show_media=='1'){
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
			if(class_exists('WPBMap') && method_exists('WPBMap', 'addAllMappedShortcodes')) { 
				WPBMap::addAllMappedShortcodes();
			}
			echo apply_filters('the_content',$content);
		}elseif($full_content=='1'){
			if(class_exists('WPBMap') && method_exists('WPBMap', 'addAllMappedShortcodes')) { 
				WPBMap::addAllMappedShortcodes();
			}
			$content = get_the_content();
			$content_ft = apply_filters('the_content', $content);
			if($content_ft=='' && $content!=''){
				echo do_shortcode( get_the_content() );
			}else{
				echo $content_ft;
			}
		}else{
			echo get_the_excerpt();
		}
	}
}
if(!function_exists('wptl_timeline_pagenavi')){
	function wptl_timeline_pagenavi($the_query){
		if(function_exists('paginate_links')) {
			echo '<div class="wptimelines-pagination">';
			echo paginate_links( array(
				'base'         => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
				'format'       => '',
				'add_args'     => false,
				'current' => max( 1, get_query_var('paged') ),
				'total' => $the_query->max_num_pages,
				'prev_text'    => '&larr;',
				'next_text'    => '&rarr;',
				'type'         => 'list',
				'end_size'     => 3,
				'mid_size'     => 3
			) );
			echo '</div>
			<style type="text/css">
				.wptimelines-pagination{ margin-top:60px;}
				.wptimelines-pagination ul{text-align: center;}
				.wptimelines-pagination ul li{ list-style:none; width:auto; display: inline-block;}
				.wptimelines-pagination ul li a,
				.wptimelines-pagination ul li span{
					display: inline-block;
					background: none;
					background-color: #FFFFFF;
					padding: 5px 15px 0 15px;
					color: rgba(153,153,153,1.0);
					margin: 0px 10px 10px 0;
					min-width: 40px;
					min-height: 40px;
					text-align: center;
					text-decoration: none;
					vertical-align: top;
					font-size: 16px;
					border-radius: 0px;
					box-shadow: 0 0 1px rgba(0, 0, 0, 0.15);
					transition: all .2s;
					border: 1px solid rgba(0, 0, 0, 0.15);
					line-height: 1.7;
				}
				.wptimelines-pagination ul li a:hover,
				.wptimelines-pagination ul li span.current{ color: rgba(119,119,119,1.0); background-color: rgba(238,238,238,1.0);}
			}
			</style>';
		}
	}
}
if(!function_exists('wptl_title_html')){
	function wptl_title_html($hide_title, $custom_link, $css=false){
		if($hide_title=='1'){ return;}
		?>
        <h2 <?php echo isset($css) && $css!='' ? $css :''; ?>>
            <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                <?php the_title();?>
            </a>
        </h2>
        <?php
	}
}

if(!function_exists('ex_wptl_lightbox')){
	function ex_wptl_lightbox($fullcontent_in,$ID,$return){
		if ($fullcontent_in != 'lightbox') {
			return;
		}
		$datacl = 'exlb-'.$ID;
		if($return == 'class'){
			return 'extllightbox '.$datacl;
		}elseif($return == 'data'){
			return ' href="'.get_the_post_thumbnail_url().'" data-glightbox="descPosition: right;" data-class="'.$datacl.'"';
		}else{ 
			ob_start();
			?>
			<div class="glightbox-desc" style="display: none;">
		      <?php wpex_template_plugin('content-lightbox');?>
		    </div>
    		<?php
    		$html_lightbox = ob_get_contents();
			ob_end_clean();
			if($return == 'html'){
				return $html_lightbox;
			}else{
				echo $html_lightbox;
			}
		}
		
	}
}
// Image gallery
if(!function_exists('ex_wptl_image_gallery')){
	function ex_wptl_image_gallery($hide_thub=false){
		if(exwptl_get_option('exwptl_image_gallery','exwptl_advanced_options') != 'yes'){
			return;
		}
		wp_enqueue_script( 'wpex-ex_s_lick', WPEX_TIMELINE.'js/ex_s_lick/ex_s_lick.js', array( 'jquery' ) );
		$gallery = get_post_meta( get_the_ID(), 'wpex_gallery', true );
		if(is_array($gallery) && !empty($gallery)){
			ob_start();
			$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
			$link_lb  = isset($image_src[0]) ? $image_src[0] : '';
			?>
			<div class="extl-gallery-carousel extl-gl-<?php echo esc_attr(get_the_ID());?>">
				<?php if($link_lb!='' && $hide_thub!='1'){?>
					<div><a href="<?php echo esc_url($link_lb);?>"><?php echo get_the_post_thumbnail(get_the_ID(),'full'); ?></a></div>
					<?php 
				}
				foreach ($gallery as $item ) {
					echo '<div>
						<a href="'.$item.'">
							<img src="'.$item.'" alt="'.esc_attr(get_the_title( get_the_ID() )).'"/>
						</a>
					</div>';
				}
				?>
			</div>
			<script type="text/javascript">
				
			</script>
			<?php
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;
		}else{
			return ;
		}
	}
}
