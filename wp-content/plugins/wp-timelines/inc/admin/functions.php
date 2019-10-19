<?php
// edit column admin 
add_filter( 'manage_wp-timeline_posts_columns', 'wpex_edit_columns',99 );
function wpex_edit_columns( $columns ) {
	global $wpdb;
	unset($columns['date']);
	$columns['wpex_date'] = esc_html__( 'Timeline Date' , 'wp-timeline' );
	$columns['wpex_ctdate'] = esc_html__( 'Custom Date' , 'wp-timeline' );
	$columns['wpex_order'] = esc_html__( 'Order' , 'wp-timeline' );
	$columns['wpex_color'] = esc_html__( 'Color' , 'wp-timeline' );
	$columns['wpex_icon_adm'] = esc_html__( 'Icon' , 'wp-timeline' );
	$columns['date'] = esc_html__( 'Publish date' , 'wp-timeline' );		
	return $columns;
}
add_action( 'manage_wp-timeline_posts_custom_column', 'wpex_custom_columns',12);
function wpex_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'wpex_date':
			$wpex_date = wpex_safe_strtotime(get_post_meta( $post->ID, 'wpex_pkdate', true ),'');
			echo '<span>'.esc_attr($wpex_date).'</span>';
			break;
		case 'wpex_ctdate':
			$wpex_customdate = get_post_meta($post->ID, 'wpex_date', true);
			echo '<input type="text" data-id="' . $post->ID . '" name="wpex_timeline_date" value="'.esc_attr($wpex_customdate).'">';
			break;
		case 'wpex_order':
			$wpex_order = get_post_meta($post->ID, 'wpex_order', true);
			echo '<input type="text" data-id="' . $post->ID . '" name="wpex_timeline_sort" value="'.esc_attr($wpex_order).'">';
			break;
		case 'wpex_color':
			$we_eventcolor = get_post_meta($post->ID, 'we_eventcolor', true);
			echo '<span style=" background-color:'.esc_attr($we_eventcolor).'; width: 15px;
    height: 15px; border-radius: 50%; display: inline-block;"></span>';
			break;	
		case 'wpex_icon_adm':
			$wpex_icon = get_post_meta($post->ID, 'wpex_icon', true);
			$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img', true );
			if(!is_numeric($wpex_icon_img)){
				$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img_id', true );
			}
			if($wpex_icon!=''){
				if(exwptl_get_option('exwptl_icon_vers','exwptl_js_css_file_options')!='5'){
					wp_enqueue_style('wpex-font-awesome', WPEX_TIMELINE.'css/font-awesome/css/font-awesome.min.css');
				}else{
					wp_enqueue_style('wpex-font-awesome-5', WPEX_TIMELINE.'css/font-awesome-5/css/all.min.css');
					wp_enqueue_style('wpex-font-awesome-shims', WPEX_TIMELINE.'css/font-awesome-5/css/v4-shims.min.css');
				}
				echo '<span class="wpex-icon-img"><i class="fa '.esc_attr($wpex_icon).'"></i></span>';
			}else if($wpex_icon_img !=''){
				echo '<img class="wpex-icon-img" src="'.esc_url(wp_get_attachment_thumb_url( $wpex_icon_img )).'" style="max-width:80%; height:auto">';
			}
			break;		
	}
}
add_action('wp_ajax_wpex_change_timeline_sort', 'wpex_change_timeline_func' );
function wpex_change_timeline_func(){
	$post_id = $_POST['post_id'];
	$value = $_POST['value'];
	if(isset($post_id) && $post_id != 0)
	{
		update_post_meta($post_id, 'wpex_order', esc_attr(str_replace(' ', '', $value)));
	}
	die;
}
add_action('wp_ajax_wpex_change_timeline_date', 'wpex_change_date_timeline_func' );
function wpex_change_date_timeline_func(){
	$post_id = $_POST['post_id'];
	$value = $_POST['value'];
	if(isset($post_id) && $post_id != 0)
	{
		update_post_meta($post_id, 'wpex_date', $value);
	}
	die;
}

add_action( 'init', 'wptl_update_order_new_update' );
if(!function_exists('wptl_update_order_new_update')){
	function wptl_update_order_new_update() {
		 if( isset( $_GET['update_order'] ) && $_GET['update_order'] == 1) {
			 if ( is_user_logged_in() && current_user_can( 'manage_options' )){
				$my_posts = get_posts( array('post_type' => 'wp-timeline', 'numberposts' => -1 ) );
				foreach ( $my_posts as $post ):
					$wpex_pkdate = get_post_meta($post->ID,'wpex_pkdate', true );
					$order_mtk = explode("/",$wpex_pkdate);
					update_post_meta( $post->ID, 'wptl_orderdate', $order_mtk[2].$order_mtk[0].$order_mtk[1] );
				endforeach;
			 }
		 }
	}
}
// update new metadata
add_action( 'init', 'wptl_update_database' );
if(!function_exists('wptl_update_database')){
	function wptl_update_database() {
		if (get_option('wpextl_option_new')!='yes' && is_user_logged_in() && current_user_can( 'manage_options' )){
			// update option page
			$new_option = array(
				'exwptl_color' => get_option( 'wptl_main_color' ),
				'exwptl_font_family' => get_option( 'wptl_fontfamily' ),
				'exwptl_font_size' => get_option( 'wptl_fontsize' ),
				'exwptl_headingfont_family' => get_option( 'wpex_hfont' ),
				'exwptl_headingfont_size' => get_option( 'wpex_hfontsize' ),
				'exwptl_metafont_family' => get_option( 'wpex_metafont' ),
				'exwptl_metafont_size' => get_option( 'wpex_matafontsize' ),
				'exwptl_single_slug' => get_option( 'wpex_timeline_slug' ),
			);
			update_option( 'exwptl_options', $new_option );
			$adv_option = array(
				'exwptl_posttype' => get_option( 'wpex_posttypes' ),
				'exwptl_text_ct' => get_option( 'wpex_text_conread' ),
				'exwptl_text_lm' => get_option( 'wpex_text_loadm' ),
				'exwptl_text_na' => get_option( 'wpex_text_next' ),
				'exwptl_text_pa' => get_option( 'wpex_text_prev' ),
				'exwptl_disable_single' => get_option( 'wpex_disable_link' ),
				'exwptl_disable_social' => get_option( 'wpex_disable_social' ),
				'exwptl_disable_nepre' => get_option( 'wpex_navi' ),
				'exwptl_np_order' => get_option( 'wpex_navi_order' ),
			);
			update_option( 'exwptl_advanced_options', $adv_option );

			$ctcode_option = array(
				'exwptl_custom_css' => get_option( 'wpex_custom_css' ),
				'exwptl_custom_js' => get_option( 'wpex_custom_code' ),
			);
			update_option( 'exwptl_custom_code_options', $ctcode_option );

			$file_option = array(
				'exwptl_css_load' => get_option( 'wpex_load_css' ),
				'exwptl_disable_awesome' => get_option( 'wpex_fontawesome' ),
				'exwptl_icon_vers' => get_option( 'wpex_fontawesome_ver' ),
				'exwptl_disable_ggfont' => get_option( 'wpex_ggfonts' ),
				'exwptl_css_sbs' => get_option( 'wpex_style_sbs' ),
				'exwptl_css_hoz' => get_option( 'wpex_style_hoz' ),
				'exwptl_enable_rtl' => get_option( 'wpex_rtl_mode' ),
			);
			update_option( 'exwptl_js_css_file_options', $file_option );
			//echo '<pre>';print_r($adv_option);exit;
			// update metadata
			$my_posts = get_posts( array('post_type' => 'wp-timeline', 'numberposts' => -1 ) );
			foreach ( $my_posts as $post ):
				// update metadata
				$wpex_custom_metadata = get_post_meta( $post->ID, 'wpex_custom_metadata', false );
				//
				if(isset($wpex_custom_metadata[0]) && !is_array($wpex_custom_metadata[0])){
					delete_post_meta($post->ID, 'wpex_custom_metadata');
					update_post_meta( $post->ID, 'wpex_custom_metadata', $wpex_custom_metadata );
				}
				// update icon
				$old_icon = get_post_meta( $post->ID, 'wpex_icon_img',true );
				if(is_numeric($old_icon)){
					update_post_meta( $post->ID, 'wpex_icon_img', wp_get_attachment_thumb_url( $old_icon ) );
					update_post_meta( $post->ID, 'wpex_icon_img_id', $old_icon );
				}

			endforeach;
			update_option( 'wpextl_option_new', 'yes' );
		}
	}
}


add_action( 'init', 'wptl_convert_from_rlep' );
if(!function_exists('wptl_convert_from_rlep')){
	function wptl_convert_from_rlep() {
		if( isset( $_GET['cv_tlep'] ) && $_GET['cv_tlep'] == 1) {
			if (is_user_logged_in() && current_user_can( 'manage_options' )){
				
				$my_posts = get_posts( array('post_type' => 'te_announcements', 'numberposts' => -1 ) );
				foreach ( $my_posts as $post ):
					set_post_type( $post->ID, 'wp-timeline'  );
					// update metadata
					$date = get_post_meta( $post->ID, 'announcement_date',true );
					if($date!=''){
						update_post_meta( $post->ID, 'wpex_pkdate', date('m/d/Y',$date) );
						update_post_meta( $post->ID, 'wptl_orderdate', date('Ymd',$date) );
					}
					$img_id = get_post_meta( $post->ID, 'announcement_image_id',true );
					if($img_id!=''){
						set_post_thumbnail( $post->ID, $img_id );
					}
					$color = get_post_meta( $post->ID, 'announcement_color',true );
					if($color!=''){
						update_post_meta( $post->ID, 'we_eventcolor', $color );
					}
					$icon = get_post_meta( $post->ID, 'announcement_icon',true );
					if($icon!=''){
						update_post_meta( $post->ID, 'wpex_icon', $icon );
					}
					// update icon
				endforeach;
			}
		}
	}
}