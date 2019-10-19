<?php
get_header();
?>
<div class="wpex-single-timeline">
	<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
		$wpex_custom_metadata = get_post_meta( get_the_ID(), 'wpex_custom_metadata', true );
		if(!is_array($wpex_custom_metadata) || empty($wpex_custom_metadata)){
			$wpex_custom_metadata = get_post_meta( get_the_ID(), 'wpex_custom_metadata', false );
		}?>
        <div class="wpex-info-sp">
            <div class="speaker-details">
            	<div class="tl-thumbnail">
					<?php
					if(wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){ 
						echo wptl_audio_video_iframe();
					}else{
						the_post_thumbnail('full');
					}?>
                </div>
                <h1 class="tl-title">
                    <?php echo '<span>'.wpex_date_tl().' - </span>'; the_title();?>
                </h1>
                <div class="tl-info-left">
					<?php if(is_array($wpex_custom_metadata) && !empty($wpex_custom_metadata)){?>
                        <div class="wpex-custom-meta-info <?php echo count($wpex_custom_metadata)==1 ? 'one-p' : '';?>">
                            <?php 
                            foreach($wpex_custom_metadata as $item){?>
                                <p><?php  echo !is_array($item) && $item!='' ? $item : '';?></p>
                                <?php
                            }?>
                        </div>
                    <?php }
					if(is_active_sidebar('wptimeline-sidebar')){
						dynamic_sidebar( 'wptimeline-sidebar' );
					}
					if(exwptl_get_option('exwptl_disable_social','exwptl_advanced_options')!='yes'){?>
                    <div class="wpex-social-share"><?php  echo wptl_social_share();?></div>
                    <?php }?>
                    <div class="exclearfix"></div>
                </div>
                <div class="timeline-info">
                    <div class="timeline-content">
						<?php 
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
						echo apply_filters('the_content',$content);?>
                    </div>
                    <?php
                    if ( (exwptl_get_option('exwptl_disable_cm','exwptl_advanced_options') == 'yes') && (comments_open() || get_comments_number()) ) {
						comments_template();
					}
					if(isset($_GET['bpage']) && is_numeric($_GET['bpage']) && get_permalink($_GET['bpage'])!=false){?>
                        <div class="wptl-back-to-list">
                            <div class="bt-back">
                            	<a href="<?php echo esc_url(get_permalink($_GET['bpage']));?>"><i class="fa fa-angle-left" aria-hidden="true"></i><?php esc_html_e('Back to timeline page','exthemes');?></a>
                            </div>
                        </div>
                        <?php
                    }?>
                </div>
                <?php 
				$we_sevent_navi = exwptl_get_option('exwptl_disable_nepre','exwptl_advanced_options');
				if($we_sevent_navi!='no'){
					$wpex_navi_order = exwptl_get_option('exwptl_np_order','exwptl_advanced_options');
					$preevtrsl = exwptl_get_option('exwptl_text_pa','exwptl_advanced_options');
					$preevtrsl = $preevtrsl !='' ?  $preevtrsl : esc_html__('Previous article','wp-timeline');
					$nextevtrsl = exwptl_get_option('exwptl_text_na','exwptl_advanced_options');
					$nextevtrsl = $nextevtrsl !='' ? $nextevtrsl : esc_html__('Next article','wp-timeline');
					if($wpex_navi_order!='ct_order'){ ?>
						<div class="timeline-navigation defa">
							<div class="next-timeline">
								<?php next_post_link('%link', $nextevtrsl) ?>
							</div>
							<div class="previous-timeline">
								<?php previous_post_link('%link', $preevtrsl) ?>
							</div>
						</div>
						<?php 
					}else{
						wpex_next_previous_timeline($preevtrsl,$nextevtrsl);
					}
				}?>
                <div class="exclearfix"></div>
            </div>
        </div>
		<?php
	endwhile;?>
</div>
<?php get_footer(); ?>
