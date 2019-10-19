<?php
class WPEX_TL_SCPosttype {
	public function __construct()
    {
        add_action( 'init', array( &$this, 'register_post_type' ) );
		add_action( 'save_post', array($this,'save_shortcode'),1 );
		add_shortcode( 'extlsc', array($this,'timeline_scbd') );
		add_filter( 'the_content', array($this,'preview_timeline'), 99 );
		add_action( 'cmb2_admin_init', array(&$this,'register_metabox') );
		add_filter( 'manage_wptl_scbd_posts_columns', array($this,'_edit_adm_columns'),99 );
		add_action( 'manage_wptl_scbd_posts_custom_column', array($this,'_edit_adm_columns_content'),12);
    }
	function preview_timeline($content){
		if ( is_singular('wptl_scbd') ){
			$sc = get_post_meta( get_the_ID(), '_tlsc', true );
			return do_shortcode($sc);
		}
		return $content;
	}

	function timeline_scbd($atts, $content){
		$id = isset($atts['id']) ? $atts['id'] : '';
		$sc = get_post_meta( $id, '_tlsc', true );
		if($id=='' || $sc==''){ return;}
		return do_shortcode($sc);
	}
	function save_shortcode($post_id){
		if('wptl_scbd' != get_post_type()){ return;}
		if(isset($_POST['sc_type'])){
			$posttype =='';
			if(is_array($_POST['posttype']) && !empty($_POST['posttype'])){
				$posttype = implode(",",array_unique($_POST['posttype']));
			}else{
				$posttype = $_POST['posttype'];
			}
			$style = isset($_POST['style']) ? $_POST['style'] : '';
			$alignment = isset($_POST['alignment']) ? $_POST['alignment'] : '';
			$layout = isset($_POST['layout']) ? $_POST['layout'] : '';
			$ids = isset($_POST['ids']) ? $_POST['ids'] : '';
			$count = isset($_POST['count']) ? $_POST['count'] : '';
			$posts_per_page = isset($_POST['posts_per_page']) ? $_POST['posts_per_page'] : '';
			$slidesshow = isset($_POST['slidesshow']) ? $_POST['slidesshow'] : '';
			$cat   = isset($_POST['cat']) ? $_POST['cat'] : '';
			$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
			$qr_cttaxo   = isset($_POST['qr_cttaxo']) ? $_POST['qr_cttaxo'] : '';
			$order = isset($_POST['order']) ? $_POST['order'] : '';
			$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : '';
			$meta_key = isset($_POST['meta_key']) ? $_POST['meta_key'] : '';
			$meta_value = isset($_POST['meta_value']) ? $_POST['meta_value'] : '';
			$number_excerpt = isset($_POST['number_excerpt']) ? $_POST['number_excerpt'] : '';
			$start_label = isset($_POST['start_label']) ? $_POST['start_label'] : '';
			$end_label = isset($_POST['end_label']) ? $_POST['end_label'] : '';
			$full_content = isset($_POST['full_content']) ? $_POST['full_content'] : '';
			$show_media = isset($_POST['show_media']) ? $_POST['show_media'] : '';
			$show_history   = isset($_POST['show_history']) ? $_POST['show_history'] : '';
			$filter_cat   = isset($_POST['filter_cat']) ? $_POST['filter_cat'] : '';
			$hide_title = isset($_POST['hide_title']) ? $_POST['hide_title'] : '';
			$hide_thumb = isset($_POST['hide_thumb']) ? $_POST['hide_thumb'] : '';
			$animations = isset($_POST['animations']) ? $_POST['animations'] : '';
			$img_size = isset($_POST['img_size']) ? $_POST['img_size'] : '';
			$lightbox = isset($_POST['lightbox']) ? $_POST['lightbox'] : '';
			$page_navi = isset($_POST['page_navi']) ? $_POST['page_navi'] : '';
			$enable_back = isset($_POST['enable_back']) ? $_POST['enable_back'] : '';

			$start_on = isset($_POST['start_on']) ? $_POST['start_on'] : '';
			$header_align = isset($_POST['header_align']) ? $_POST['header_align'] : '';
			$content_align   = isset($_POST['content_align']) ? $_POST['content_align'] : '';
			$toolbar_position   = isset($_POST['toolbar_position']) ? $_POST['toolbar_position'] : '';
			$arrow_position = isset($_POST['arrow_position']) ? $_POST['arrow_position'] : '';
			$loading_effect = isset($_POST['loading_effect']) ? $_POST['loading_effect'] : '';
			$show_label = isset($_POST['show_label']) ? $_POST['show_label'] : '';
			$feature_label = isset($_POST['feature_label']) ? $_POST['feature_label'] : '';
			$show_all = isset($_POST['show_all']) ? $_POST['show_all'] : '';
			$autoplay = isset($_POST['autoplay']) ? $_POST['autoplay'] : '';
			$autoplayspeed = isset($_POST['autoplayspeed']) ? $_POST['autoplayspeed'] : '';

			$infinite = isset($_POST['infinite']) ? $_POST['infinite'] : '';
			$class = isset($_POST['class']) ? $_POST['class'] : '';
			
			if($_POST['sc_type'] == 'hoz'){
				$sc = '[wpex_timeline_horizontal style="'.$style.'" layout="'.$layout.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$qr_cttaxo.'" ids="'.$ids.'" count="'.$count.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" autoplay="'.$autoplay.'" show_media="'.$show_media.'" show_label="'.$show_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" arrow_position="'.$arrow_position.'" show_all="'.$show_all.'" header_align="'.$header_align.'" content_align="'.$content_align.'" toolbar_position="'.$toolbar_position.'" autoplayspeed="'.$autoplayspeed.'" start_on="'.$start_on.'" slidesshow="'.$slidesshow.'" loading_effect="'.$loading_effect.'" enable_back="'.$enable_back.'" class="'.$class.'"]';
			}elseif($_POST['sc_type'] == 'hoz-multi'){
				$sc = '[timeline_horizontal_multi style="'.$style.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$qr_cttaxo.'" ids="'.$ids.'" count="'.$count.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" autoplay="'.$autoplay.'" show_media="'.$show_media.'" show_label="'.$show_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" arrow_position="'.$arrow_position.'" autoplayspeed="'.$autoplayspeed.'" start_on="'.$start_on.'" slidesshow="'.$slidesshow.'" loading_effect="'.$loading_effect.'" enable_back="'.$enable_back.'" class="'.$class.'"]';
			}else{
				$sc = '[wpex_timeline style="'.$style.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$qr_cttaxo.'" ids="'.$ids.'" count="'.$count.'" posts_per_page="'.$posts_per_page.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" alignment="'.$alignment.'" show_media="'.$show_media.'" show_history="'.$show_history.'" feature_label="'.$feature_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" hide_title="'.$hide_title.'"  img_size="'.$img_size.'" lightbox="'.$lightbox.'" page_navi="'.$page_navi.'" enable_back="'.$enable_back.'" start_label="'.$start_label.'" end_label="'.$end_label.'" animations="'.$animations.'" filter_cat="'.$filter_cat.'" class="'.$class.'"]';
			}
			if($sc!=''){
				update_post_meta( $post_id, '_tlsc', $sc );
			}
			update_post_meta( $post_id, '_shortcode', '[extlsc id="'.$post_id.'"]' );
		}
	}
	function register_post_type(){
		$labels = array(
			'name'               => esc_html__('Shortcodes','wp-timeline'),
			'singular_name'      => esc_html__('Shortcodes','wp-timeline'),
			'add_new'            => esc_html__('Add New Shortcodes','wp-timeline'),
			'add_new_item'       => esc_html__('Add New Shortcodes','wp-timeline'),
			'edit_item'          => esc_html__('Edit Shortcodes','wp-timeline'),
			'new_item'           => esc_html__('New Shortcode','wp-timeline'),
			'all_items'          => esc_html__('Shortcodes builder','wp-timeline'),
			'view_item'          => esc_html__('View Shortcodes','wp-timeline'),
			'search_items'       => esc_html__('Search Shortcodes','wp-timeline'),
			'not_found'          => esc_html__('No Shortcode found','wp-timeline'),
			'not_found_in_trash' => esc_html__('No Shortcode found in Trash','wp-timeline'),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__('Shortcodes','wp-timeline')
		);
		
		$rewrite = false;
		$args = array(  
			'labels' => $labels,  
			'menu_position' => 8, 
			'supports' => array('title','custom-fields'),
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=wp-timeline',
			'menu_icon' =>  'dashicons-editor-ul',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'rewrite' => $rewrite,
		);  
		register_post_type('wptl_scbd',$args);  
	}

	function register_metabox() {
		/**
		 * Shortcode builder options
		 */
		$prefix = 'exwptl_';
		$layout = new_cmb2_box( array(
			'id'            => $prefix.'sc_shortcode',
			'title'         => esc_html__( 'Shortcode type', 'wp-timeline' ),
			'object_types'  => array( 'wptl_scbd' ), // Post type
		) );
	
		$layout->add_field( array(
			'name'             => esc_html__( 'Type', 'wp-timeline' ),
			'desc'             => esc_html__( 'Select type of shortcode', 'wp-timeline' ),
			'id'               => 'sc_type',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'grid',
			'options'          => array(
				'list' => esc_html__('Vertical Listing', 'wp-timeline'), 
				'hoz' => esc_html__('Horizontal', 'wp-timeline'),
				'hoz-multi' => esc_html__('Horizontal Multi items', 'wp-timeline'),
			),
		) );
		if(isset($_GET['post']) && is_numeric($_GET['post'])){
			$layout->add_field( array(
				'name'       => esc_html__( 'Shortcode', 'wp-timeline' ),
				'desc'       => esc_html__( 'Copy this shortcode and paste it into your post, page, or text widget content:', 'wp-timeline' ),
				'id'         => '_shortcode',
				'type'       => 'text',
				'classes'             => '',
				'attributes'  => array(
					'readonly' => 'readonly',
				),
			) );
		}
		$sc_option = new_cmb2_box( array(
			'id'            => $prefix.'sc_option',
			'title'         => esc_html__( 'Options', 'wp-timeline' ),
			'object_types'  => array( 'wptl_scbd' ),
		) );
		
		$args = array(
		   'public'   => true,
		);
		$output = 'objects';
		$post_types = get_post_types( $args, $output );
		$listpt = array();
		$listpt['wp-timeline'] = esc_html__( 'Timelines', 'wp-timeline' );
		foreach ( $post_types  as $post_type ) {
			if($post_type->name!='attachment' && $post_type->name!='elementor_library' && $post_type->name!='wp-timeline'){
				$listpt[$post_type->name] = $post_type->label;
			}
		}
		$sc_option->add_field( array(
			'name'             => esc_html__( 'Post types', 'wp-timeline' ),
			'desc'             => esc_html__( 'Select Post types to show timeline', 'wp-timeline' ),
			'id'               => 'posttype',
			'type'             => 'select',
			'classes'             => 'column-1',
			'show_option_none' => false,
			'default'          => 'wp-timeline',
			'options'          => $listpt
		) );
		$sc_option->add_field( array(
			'name'             => esc_html__( 'Style', 'wp-timeline' ),
			'desc'             => esc_html__( 'Select style of shortcode', 'wp-timeline' ),
			'id'               => 'style',
			'type'             => 'select',
			'classes'             => 'column-3',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('Classic', 'wp-timeline'),
				'modern'=> esc_html__('Modern', 'wp-timeline'),
				'wide_img'=> esc_html__('Wide image', 'wp-timeline'),
				'bg'=> esc_html__('Background', 'wp-timeline'),
				'box-color'=> esc_html__('Box color', 'wp-timeline'),
				'simple'=> esc_html__('Simple', 'wp-timeline'),
				'simple-bod'=> esc_html__('Simple bod', 'wp-timeline'),
				'simple-cent'=> esc_html__('Simple cent', 'wp-timeline'),
				'clean'=> esc_html__('Clean', 'wp-timeline'),
				'left' => esc_html__('Left side', 'wp-timeline'),
				'full-width'=> esc_html__('Full Width', 'wp-timeline'),
				'1' => esc_html__('1', 'wp-timeline'),
				'2' => esc_html__('2', 'wp-timeline'),
				'3' => esc_html__('3', 'wp-timeline'),
				'4' => esc_html__('4', 'wp-timeline'),
				'5' => esc_html__('5', 'wp-timeline'),
				'6' => esc_html__('6', 'wp-timeline'),
				'7' => esc_html__('7', 'wp-timeline'),
				
			),
		) );
		$sc_option->add_field( array(
			'name'             => esc_html__( 'Alignment', 'wp-timeline' ),
			'desc'             => esc_html__( 'Select Alignment for Vertical Listing', 'wp-timeline' ),
			'id'               => 'alignment',
			'type'             => 'select',
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('Center', 'wp-timeline'),
				'left' => esc_html__('Left', 'wp-timeline'),
				'sidebyside' => esc_html__('Side by side', 'wp-timeline'),
			),
		) );
		$sc_option->add_field( array( 
			'id' => 'layout', 
			'name' => esc_html__('Layout', 'wp-timeline'),
			'desc'             => esc_html__( 'Select Layout for Horizontal timeline', 'wp-timeline' ),
			'type' => 'select', 
			'classes'             => 'column-3 hide-inlist hide-inhoz_multi',
			'options' => array( 
					'horizontal' => esc_html__('Horizontal', 'wp-timeline'),
					'hozsteps' => esc_html__('Horizontal Step', 'wp-timeline'),
			),
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'IDs', 'wp-timeline' ),
			'desc'       => esc_html__( 'Specify post IDs to retrieve', 'wp-timeline' ),
			'id'         => 'ids',
			'type'       => 'text',
			'classes'             => 'column-1',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Count', 'wp-timeline' ),
			'desc'       => esc_html__( 'Total Number of posts', 'wp-timeline' ),
			'id'         => 'count',
			'type'       => 'text',
			'classes'             => 'column-3',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Posts per page', 'wp-timeline' ),
			'desc'       => esc_html__( 'Number post per page', 'wp-timeline' ),
			'id'         => 'posts_per_page',
			'type'       => 'text',
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Number items visible', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter number item visible in timeline', 'wp-timeline' ),
			'id'         => 'slidesshow',
			'type'       => 'text',
			'classes'             => 'column-3 hide-inlist',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Category', 'wp-timeline' ),
			'desc'       => esc_html__( 'List of cat ID (or slug), separated by a comma', 'wp-timeline' ),
			'id'         => 'cat',
			'type'       => 'text',
			'classes'             => 'column-3',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Tags', 'wp-timeline' ),
			'desc'       => esc_html__( 'List of tags, separated by a comma', 'wp-timeline' ),
			'id'         => 'tag',
			'type'       => 'text',
			'classes'             => 'column-3',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Custom Taxonomy', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter name of Custom Taxonomy to query', 'wp-timeline' ),
			'id'         => 'qr_cttaxo',
			'type'       => 'text',
			'classes'             => 'column-3',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Order', 'wp-timeline' ),
			'desc'       => '',
			'id'         => 'order',
			'type'             => 'select',
			'classes'             => 'column-2',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'DESC' => esc_html__('DESC', 'wp-timeline'),
				'ASC'   => esc_html__('ASC', 'wp-timeline'),
			),
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Order by', 'wp-timeline' ),
			'desc'       => '',
			'id'         => 'orderby',
			'type'             => 'select',
			'classes'             => 'column-2',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'date' => esc_html__('Publish Date', 'wp-timeline'),
				'timeline_date' => esc_html__('Timeline Date', 'wp-timeline'),
				'ID' => esc_html__('ID', 'wp-timeline'),
				'author' => esc_html__('Author', 'wp-timeline'),
				'title' => esc_html__('Title', 'wp-timeline'),
				'name' => esc_html__('Name', 'wp-timeline'),
				'modified' => esc_html__('Modified', 'wp-timeline'),
				'parent' => esc_html__('Parent', 'wp-timeline'),
				'rand' => esc_html__('Random', 'wp-timeline'),
				'comment_count' => esc_html__('Comment count', 'wp-timeline'),
				'menu_order' => esc_html__('Menu order', 'wp-timeline'),
				'meta_value' => esc_html__('Meta value', 'wp-timeline'),
				'meta_value_num' => esc_html__('Meta value num', 'wp-timeline'),
				'post__in' => esc_html__('Post__in', 'wp-timeline'),
				'none' => esc_html__('None', 'wp-timeline'),
			),
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Meta key', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter meta key to query', 'wp-timeline' ),
			'id'         => 'meta_key',
			'type'       => 'text',
			'classes'             => 'column-2',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Meta value', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter meta value to query', 'wp-timeline' ),
			'id'         => 'meta_value',
			'type'       => 'text',
			'classes'             => 'column-2',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Number of Excerpt', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter number', 'wp-timeline' ),
			'id'         => 'number_excerpt',
			'type'       => 'text',
			'classes'             => 'column-1 hide-inhoz',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Start label', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter Start label for vertical listing', 'wp-timeline' ),
			'id'         => 'start_label',
			'type'       => 'text',
			'classes'             => 'column-2 hide-inhoz hide-inhoz_multi',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'End label', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter End label for vertical listing', 'wp-timeline' ),
			'id'         => 'end_label',
			'type'       => 'text',
			'classes'             => 'column-2 hide-inhoz hide-inhoz_multi',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Full content in', 'wp-timeline' ),
			'desc'       => esc_html__( 'Show full information of timeline in', 'wp-timeline' ),
			'id'         => 'full_content',
			'type'             => 'select',
			'classes'             => 'column-1',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('No', 'wp-timeline'),
				'1'=> esc_html__('Instead of Excerpt', 'wp-timeline'),
				'lightbox'=> esc_html__('In Lightbox', 'wp-timeline')
			),
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Show media', 'wp-timeline' ),
			'desc'       => esc_html__( 'Show Audio or video on timeline', 'wp-timeline' ),
			'id'         => 'show_media',
			'type'             => 'select',
			'classes'             => 'column-3',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'1' => esc_html__('Yes', 'wp-timeline'),
				'0'=> esc_html__('No', 'wp-timeline')
			),
		) );

		$sc_option->add_field( array( 
			'id' => 'show_history', 
			'name' => esc_html__('Show history bar', 'wp-timeline'), 
			'type' => 'select', 
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'show_option_none' => false,
			'default'          => '',
			'desc' => esc_html__('Show fixed timeline bar on right timeline', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Show Filter by category', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enble show Filter on top', 'wp-timeline' ),
			'id'         => 'filter_cat',
			'type'             => 'select',
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		) );
		$sc_option->add_field( array( 
			'id' => 'hide_title', 
			'name' => esc_html__('Hide Title', 'wp-timeline'), 
			'type' => 'select', 
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'desc' => esc_html__( 'Hide timeline title', 'wp-timeline' ),
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'hide_thumb', 
			'name' => esc_html__('Hide thumbnails', 'wp-timeline'), 
			'type' => 'select', 
			'desc' => esc_html__( 'Hide thumbnails image', 'wp-timeline' ),
			'classes'             => 'column-3',
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'animations', 
			'name' => esc_html__('Animations', 'wp-timeline'), 
			'type' => 'select', 
			'desc' => esc_html__( 'Select Animations when scroll timeline', 'wp-timeline' ),
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'options' => array( 
					'' => esc_html__('None', 'wp-timeline'),
					'bounce'=> esc_html__('bounce', 'wp-timeline'),
					'flash'=> esc_html__('flash', 'wp-timeline'),
					'pulse'=> esc_html__('pulse', 'wp-timeline'),
					'rubberBand'=> esc_html__('rubberBand', 'wp-timeline'),
					'shake'=> esc_html__('shake', 'wp-timeline'),
					'headShake'=> esc_html__('headShake', 'wp-timeline'),
					'swing'=> esc_html__('swing', 'wp-timeline'),
					'tada'=> esc_html__('tada', 'wp-timeline'),
					'wobble'=> esc_html__('wobble', 'wp-timeline'),
					'jello'=> esc_html__('jello', 'wp-timeline'),
					'bounceIn'=> esc_html__('bounceIn', 'wp-timeline'),
					'bounceInLeft'=> esc_html__('bounceInLeft', 'wp-timeline'),
					'bounceInRight'=> esc_html__('bounceInRight', 'wp-timeline'),
					'bounceInUp'=> esc_html__('bounceInUp', 'wp-timeline'),
					'fadeIn'=> esc_html__('fadeIn', 'wp-timeline'),
					'fadeInDown'=> esc_html__('fadeInDown', 'wp-timeline'),
					'fadeInDownBig'=> esc_html__('fadeInDownBig', 'wp-timeline'),
					'fadeInLeft'=> esc_html__('fadeInLeft', 'wp-timeline'),
					'fadeInLeftBig'=> esc_html__('fadeInLeftBig', 'wp-timeline'),
					'fadeInRight'=> esc_html__('fadeInRight', 'wp-timeline'),
					'fadeInRightBig'=> esc_html__('fadeInRightBig', 'wp-timeline'),
					'fadeInUp'=> esc_html__('fadeInUp', 'wp-timeline'),
					'fadeInUpBig'=> esc_html__('fadeInUpBig', 'wp-timeline'),
					'flipInX'=> esc_html__('flipInX', 'wp-timeline'),
					'flipInY'=> esc_html__('flipInY', 'wp-timeline'),
					'lightSpeedIn'=> esc_html__('lightSpeedIn', 'wp-timeline'),
					'rotateIn'=> esc_html__('rotateIn', 'wp-timeline'),
					'rotateInDownLeft'=> esc_html__('rotateInDownLeft', 'wp-timeline'),
					'rotateInDownRight'=> esc_html__('rotateInDownRight', 'wp-timeline'),
					'rotateInUpLeft'=> esc_html__('rotateInUpLeft', 'wp-timeline'),
					'rotateInUpRight'=> esc_html__('rotateInUpRight', 'wp-timeline'),
					'bounceInRight'=> esc_html__('bounceInRight', 'wp-timeline'),
					'rollIn'=> esc_html__('rollIn', 'wp-timeline'),
					'zoomIn'=> esc_html__('zoomIn', 'wp-timeline'),
					'zoomInDown'=> esc_html__('zoomInDown', 'wp-timeline'),
					'zoomInLeft'=> esc_html__('zoomInLeft', 'wp-timeline'),
					'zoomInRight'=> esc_html__('zoomInRight', 'wp-timeline'),
					'zoomInUp'=> esc_html__('zoomInUp', 'wp-timeline'),
					'slideIn'=> esc_html__('slideIn', 'wp-timeline'),
					'slideInDown'=> esc_html__('slideInDown', 'wp-timeline'),
					'slideInLeft'=> esc_html__('slideInLeft', 'wp-timeline'),
					'slideInRight'=> esc_html__('slideInRight', 'wp-timeline'),
					'bounceInRight'=> esc_html__('bounceInRight', 'wp-timeline'),
			),
		));
		$sc_option->add_field( array(
			'id' => 'img_size', 
			'name' => esc_html__('Featured Image size', 'wp-timeline'), 
			'default'=> '', 
			'type' => 'text',
			'classes'             => 'column-1 hide-inhoz hide-inhoz_multi',
			'desc' => esc_html__('Enter your custom image size', 'wp-timeline') , 
		));
		$sc_option->add_field( array( 
			'id' => 'lightbox', 
			'name' => esc_html__('Image lightbox', 'wp-timeline'), 
			'type' => 'select', 
			'desc' => esc_html__('Enable image lightbox', 'wp-timeline'),
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'page_navi', 
			'name' => esc_html__('Page navigation', 'wp-timeline'), 
			'type' => 'select', 
			'desc' => esc_html__('Select type of Page navigation', 'wp-timeline'),
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi',
			'options' => array( 
					'' => esc_html__('Load more', 'wp-timeline'),
					'inf'=> esc_html__('Infinite Scroll', 'wp-timeline'),
					'pag'=> esc_html__('Page links', 'wp-timeline')
			),
			));
		$sc_option->add_field( array( 
			'id' => 'enable_back', 
			'name' => esc_html__('Enable Back to timeline page', 'wp-timeline'), 
			'type' => 'select', 
			'classes'             => 'column-3',
			'desc' => esc_html__('Only work with timeline post type', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'yes'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Slide to start on', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enter number, Default:0', 'wp-timeline' ),
			'id'         => 'start_on',
			'classes'             => 'column-1 hide-inlist',
			'type'             => 'text',
		) );
		$sc_option->add_field( array( 
			'id' => 'header_align', 
			'name' => esc_html__('Header alignment', 'wp-timeline'), 
			'type' => 'select',
			'desc'       => esc_html__( 'Select alignment for timeline bar', 'wp-timeline' ),
			'classes'             => 'column-2 hide-inlist hide-inhoz_multi',
			'options' => array( 
				'' => esc_html__('Default', 'wp-timeline'),
				'center'=> esc_html__('Center', 'wp-timeline'),
				'left'=> esc_html__('Left', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'content_align', 
			'name' => esc_html__('Content alignment', 'wp-timeline'), 
			'type' => 'select',
			'classes'             => 'column-2 hide-inlist hide-inhoz_multi',
			'desc' => esc_html__('Select alignment for timeline content', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('Center', 'wp-timeline'),
					'left'=> esc_html__('Left', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'toolbar_position', 
			'name' => esc_html__('Timeline bar position', 'wp-timeline'), 
			'type' => 'select', 
			'classes'             => 'column-3 hide-inlist hide-inhoz_multi',
			'desc' => esc_html__('Select position of timeline bar', 'wp-timeline'),
			'options' => array( 
					'top' => esc_html__('Top', 'wp-timeline'),
					'bottom'=> esc_html__('Bottom', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'arrow_position', 
			'name' => esc_html__('Arrow buttons position', 'wp-timeline'), 
			'type' => 'select',
			'classes'             => 'column-3 hide-inlist',
			'desc' => esc_html__('Select position of arrow button', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('Center', 'wp-timeline'),
					'top'=> esc_html__('In timeline bar', 'wp-timeline')
			),
		));
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Loading effect', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enable Loading effect', 'wp-timeline' ),
			'id'         => 'loading_effect',
			'type'             => 'select',
			'classes'             => 'column-3 hide-inlist',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('No', 'wp-timeline'),
				'1'   => esc_html__('Yes', 'wp-timeline'),
			),
		) );

		$sc_option->add_field( array( 
			'id' => 'show_label', 
			'name' => esc_html__('Show label', 'wp-timeline'), 
			'type' => 'select', 
			'classes'             => 'column-3 hide-inlist',
			'desc' => esc_html__('Show label instead of date on timeline bar', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'feature_label', 
			'name' => esc_html__('Show Feature label', 'wp-timeline'), 
			'type' => 'select', 
			'classes'             => 'column-3 hide-inhoz hide-inhoz_multi', 
			'cols' => 4, 
			'desc' => esc_html__('Show Feature label in vertical listing timeline', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));
		$sc_option->add_field( array( 
			'id' => 'show_all', 
			'name' => esc_html__('Show all items', 'wp-timeline'), 
			'type' => 'select',
			'classes'             => 'column-3 hide-inhoz_multi hide-inlist', 
			'desc' =>  esc_html__('Show all items on timeline bar', 'wp-timeline'),
			'options' => array( 
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
			),
		));

		$sc_option->add_field( array(
			'name'       => esc_html__( 'Autoplay', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enable Autoplay', 'wp-timeline' ),
			'id'         => 'autoplay',
			'type'             => 'select',
			'classes'             => 'column-3 hide-inlist',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('No', 'wp-timeline'),
				'1'   => esc_html__('Yes', 'wp-timeline'),
			),
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Autoplay Speed', 'wp-timeline' ),
			'desc'       => esc_html__( 'Autoplay Speed in milliseconds. Default:3000', 'wp-timeline' ),
			'id'         => 'autoplayspeed',
			'type'             => 'text',
			'classes'             => 'column-3 hide-inlist',
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Infinite', 'wp-timeline' ),
			'desc'       => esc_html__( 'Enable auto back to first item when end loop', 'wp-timeline' ),
			'id'         => 'infinite',
			'type'             => 'select',
			'classes'             => 'column-3 hide-inlist',
			'show_option_none' => false,
			'default'          => '',
			'options'          => array(
				'' => esc_html__('No', 'wp-timeline'),
				'yes'   => esc_html__('Yes', 'wp-timeline'),
			),
		) );
		$sc_option->add_field( array(
			'name'       => esc_html__( 'Class', 'wp-timeline' ),
			'desc'       => esc_html__( 'Add a class name and refer to it in custom CSS.', 'wp-timeline' ),
			'id'         => 'class',
			'type'             => 'text',
		) );
	
	}
	function _edit_adm_columns( $columns ) {
		global $wpdb;
		unset($columns['date']);
		$columns['wpex_sc'] = esc_html__( 'Shortcode' , 'wp-timeline' );
		$columns['date'] = esc_html__( 'Publish date' , 'wp-timeline' );		
		return $columns;
	}
	function _edit_adm_columns_content( $column ) {
		global $post;
		switch ( $column ) {
			case 'wpex_sc':
				$_shortcode = get_post_meta( $post->ID, '_shortcode', true );
				echo '<input type="text" data-id="' . $post->ID . '" name="wpex_sc" value="'.esc_attr($_shortcode).'" readonly="readonly">';
				break;
		}
	}
	
}
$WPEX_TL_SCPosttype = new WPEX_TL_SCPosttype();