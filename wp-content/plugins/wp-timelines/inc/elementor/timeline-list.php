<?php
namespace Elementor;
if(!class_exists('WPTL_List_Elementor_Widget')){
	class WPTL_List_Elementor_Widget extends Widget_Base {
		public function get_name() {
			return 'wptl_vertical_list';
		}
		
		public function get_title() {
			return esc_html__( 'Timeline', 'wp-timeline');
		}
	
		public function get_icon() {
			return 'fa fa-youtube-square';
		}
		
		public function get_categories() {
			return [ 'wp_timelines' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'wptl_list_global_settings',
				[
					'label' 		=> esc_html__( 'Timeline', 'wp-timeline')
				]
			);
			$this->add_control(
				'style',
				[
					'label'			=> esc_html__( 'Style', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'modern',
					'options'		=> array(
						'' => esc_html__('Classic', 'wp-timeline'),
						'modern'=> esc_html__('Modern', 'wp-timeline'),
						'wide_img'=> esc_html__('Wide image', 'wp-timeline'),
						'bg'=> esc_html__('Background', 'wp-timeline'),
						'box-color'=> esc_html__('Box color', 'wp-timeline'),
						'simple'=> esc_html__('Simple', 'wp-timeline'),
						'simple-bod'=> esc_html__('Simple bod', 'wp-timeline'),
						'simple-cent'=> esc_html__('Simple cent', 'wp-timeline'),
						'clean'=> esc_html__('Clean', 'wp-timeline'),
					),
				]
			);
			$this->add_control(
				'alignment',
				[
					'label'			=> esc_html__( 'Alignment', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Center', 'wp-timeline'),
						'left' => esc_html__('Left', 'wp-timeline'),
						'sidebyside' => esc_html__('Side by side', 'wp-timeline'),
					),
				]
			);
			$args = array(
			   'public'   => true,
			);
			$output = 'objects';
			$post_types = get_post_types( $args, $output );
			$listpt = array();
			foreach ( $post_types  as $post_type ) {
				if($post_type->name!='attachment' && $post_type->name!='elementor_library'){
					$listpt[$post_type->name] = $post_type->label;
				}
			}
			$this->add_control(
				'posttype',
				[
					'label'			=> esc_html__( 'Post types', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'wp-timeline',
					'options'		=> $listpt
				]
			);
			$this->add_control(
				'ids',
				[
					'label'			=> esc_html__( 'IDs', 'wp-timeline'),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> '',
					'description'		=> esc_html__("Specify post IDs to retrieve", "wp-timeline"),
				]
			);
			$this->add_control(
				'count',
				[
					'label'			=> esc_html__( 'Count', 'wp-timeline'),
					'type'			=> Controls_Manager::NUMBER,
					'default' => 9,
					'description'		=> esc_html__("Number of posts", 'wp-timeline'),
				]
			);
			$this->add_control(
				'posts_per_page',
				[
					'label'			=> esc_html__( 'Posts per page', 'wp-timeline'),
					'type'			=> Controls_Manager::NUMBER,
					'default' => '',
					'description'		=> esc_html__("Number item per page", 'wp-timeline'),
				]
			);
			$this->add_control(
				'cat',
				[
					'label'			=> esc_html__( 'Category', 'wp-timeline'),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					'description'		=> esc_html__("List of cat ID (or slug), separated by a comma", "wp-timeline"),
				]
			);
			$this->add_control(
				'tag',
				[
					'label'			=> esc_html__("Tags", "wp-timeline"),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					'description'		=> esc_html__("List of tags, separated by a comma", "wp-timeline"),
				]
			);
			$this->add_control(
				'taxonomy',
				[
					'label'			=> esc_html__("Custom Taxonomy", "wp-timeline"),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					'description'		=> esc_html__("Name of custom taxonomy", "wp-timeline"),
				]
			);
			$this->add_control(
				'order',
				[
					'label'			=> esc_html__( 'Order', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'DESC' => esc_html__('DESC', 'wp-timeline'),
						'ASC'=> esc_html__('ASC', 'wp-timeline')
					),
				]
			);
			$this->add_control(
				'orderby',
				[
					'label'			=> esc_html__( 'Order by', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'date' => esc_html__('Date', 'wp-timeline'),
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
				]
			);
			$this->add_control(
				'meta_key',
				[
					'label'			=> esc_html__("Meta key", "wp-timeline"),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					'description'		=> esc_html__("Enter meta key to query", "wp-timeline"),
				]
			);
			$this->add_control(
				'start_label',
				[
					'label'			=> esc_html__("Start label", "wp-timeline"),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					"description" => esc_html__("Enter text", "wp-timeline"),
				]
			);
			$this->add_control(
				'end_label',
				[
					'label'			=> esc_html__("End label", "wp-timeline"),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					"description" => esc_html__("Enter text", "wp-timeline"),
				]
			);
			
			$this->add_control(
				'show_media',
				[
					'label'			=> esc_html__( 'Show media', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'1' => esc_html__('Yes', 'wp-timeline'),
						'0'=> esc_html__('No', 'wp-timeline')
					),
				]
			);
			$this->add_control(
				'show_history',
				[
					'label'			=> esc_html__( 'Show history bar', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => esc_html__("Show label instead of date on timeline bar", "wp-timeline")
				]
			);
			$this->add_control(
				'full_content',
				[
					'label'			=> esc_html__( 'Show full Content', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => esc_html__("Show full Content instead of Excerpt", "wp-timeline")
				]
			);
			$this->add_control(
				'filter_cat',
				[
					'label'			=> esc_html__( 'Show Filter by category', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => '',
				]
			);
			$this->add_control(
				'feature_label',
				[
					'label'			=> esc_html__( 'Show Feature label', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => '',
				]
			);
			
			$this->add_control(
				'hide_title',
				[
					'label'			=> esc_html__( 'Hide Title', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => ''
				]
			);
			
			$this->add_control(
				'hide_img',
				[
					'label'			=> esc_html__( 'Hide thubnails', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => ''
				]
			);
			
			$this->add_control(
				'animations',
				[
					'label'			=> esc_html__( 'Animations', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
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
				]
			);
			
			$this->add_control(
				'img_size',
				[
					'label'			=> esc_html__( 'Image size', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Default', 'wp-timeline'),
						'full'=> esc_html__('Full', 'wp-timeline')
					),
					'description'		=> '',
				]
			);
			$this->add_control(
				'lightbox',
				[
					'label'			=> esc_html__( 'Enable image lightbox', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					'description'		=> '',
				]
			);
			$this->add_control(
				'page_navi',
				[
					'label'			=> esc_html__( 'Page navigation', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Load more', 'wp-timeline'),
						'inf'=> esc_html__('Infinite Scroll', 'wp-timeline'),
						'pag'=> esc_html__('Page links', 'wp-timeline')
					),
					'description'		=> '',
				]
			);
			$this->add_control(
				'enable_back',
				[
					'label'			=> esc_html__( 'Enable Back to timeline page', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'yes'=> esc_html__('Yes', 'wp-timeline')
					),
					'description'		=> esc_html__("Only work with timeline post type", "wp-timeline"),
				]
			);


		}
		public function get_script_depends() {
			return [ 'wpex-timeline' ];
		}

		protected function render() {
			$atts = $this->get_settings();
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
			
			echo do_shortcode('[wpex_timeline style="'.$style.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$taxonomy.'" ids="'.$ids.'" count="'.$count.'" posts_per_page="'.$posts_per_page.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" alignment="'.$alignment.'" show_media="'.$show_media.'" show_history="'.$show_history.'" feature_label="'.$feature_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" hide_title="'.$hide_title.'"  img_size="'.$img_size.'" lightbox="'.$lightbox.'" page_navi="'.$page_navi.'" enable_back="'.$enable_back.'" start_label="'.$start_label.'" end_label="'.$end_label.'" animations="'.$animations.'" filter_cat="'.$filter_cat.'"]').'<script>if (typeof (Wptl_El_Sp) !== "undefined" && Wptl_El_Sp!==null) { Wptl_El_Sp.timelines_hoz(); }</script>';
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new WPTL_List_Elementor_Widget() );