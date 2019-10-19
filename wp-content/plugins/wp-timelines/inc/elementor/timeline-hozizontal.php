<?php
namespace Elementor;
if(!class_exists('WPTL_Hozizontal_Elementor_Widget')){
	class WPTL_Hozizontal_Elementor_Widget extends Widget_Base {
		public function get_name() {
			return 'wptl_hozizontal';
		}
		
		public function get_title() {
			return esc_html__( 'Timeline hozizontal', 'wp-timeline');
		}
	
		public function get_icon() {
			return 'fa fa-youtube-square';
		}
		
		public function get_categories() {
			return [ 'wp_timelines' ];
		}
		
		protected function _register_controls() {
			$this->start_controls_section(
				'wptl_hoz_global_settings',
				[
					'label' 		=> esc_html__( 'Timeline hozizontal', 'wp-timeline')
				]
			);
			$this->add_control(
				'style',
				[
					'label'			=> esc_html__( 'Style', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Left side', 'wp-timeline'),
						'full-width'=> esc_html__('Full Width', 'wp-timeline'),
					),
				]
			);
			$this->add_control(
				'layout',
				[
					'label'			=> esc_html__( 'Layout', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> 'horizontal',
					'options'		=> array(
						'horizontal' => esc_html__('Horizontal', 'wp-timeline'),
						'hozsteps' => esc_html__('Horizontal Step', 'wp-timeline'),
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
					'default' => 6,
					'description'		=> esc_html__("Number of posts", 'wp-timeline'),
				]
			);
			$this->add_control(
				'slidesshow',
				[
					'label'			=> esc_html__( 'Number item visible', 'wp-timeline'),
					'type'			=> Controls_Manager::NUMBER,
					'default' => 5,
					'description'		=> '',
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
				'start_on',
				[
					'label'			=> esc_html__("Slide to start on", "wp-timeline"),
					'type'			=> Controls_Manager::TEXT,
					'default' => '',
					"description" => esc_html__("Enter number, Default:0", "wp-timeline"),
				]
			);
			$this->add_control(
				'header_align',
				[
					'label'			=> esc_html__( 'Header alignment', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Default', 'wp-timeline'),
						'center'=> esc_html__('Center', 'wp-timeline'),
						'left'=> esc_html__('Left', 'wp-timeline')
					),
				]
			);
			$this->add_control(
				'content_align',
				[
					'label'			=> esc_html__( 'Content alignment', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Center', 'wp-timeline'),
						'left'=> esc_html__('Left', 'wp-timeline')
					),
				]
			);
			
			$this->add_control(
				'arrow_position',
				[
					'label'			=> esc_html__( 'Arrow buttons position', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('Center', 'wp-timeline'),
						'top'=> esc_html__('In timeline bar', 'wp-timeline')
					),
				]
			);
			$this->add_control(
				'toolbar_position',
				[
					'label'			=> esc_html__( 'Timeline bar position', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'top' => esc_html__('Top', 'wp-timeline'),
						'bottom'=> esc_html__('Bottom', 'wp-timeline')
					),
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
				'show_label',
				[
					'label'			=> esc_html__( 'Show label', 'wp-timeline'),
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
				'show_all',
				[
					'label'			=> esc_html__( 'Show all items', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
					"description" => esc_html__("Show all items on timeline bar", "wp-timeline"),
				]
			);
			$this->add_control(
				'hide_thumb',
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
				'autoplay',
				[
					'label'			=> esc_html__( 'Autoplay', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
				]
			);
			$this->add_control(
				'autoplayspeed',
				[
					'label'			=> esc_html__( 'Autoplay Speed', 'wp-timeline'),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> '',
					'description'		=> esc_html__("Autoplay Speed in milliseconds. Default:3000", "wp-timeline"),
				]
			);
			$this->add_control(
				'loading_effect',
				[
					'label'			=> esc_html__( 'Enable Loading effect', 'wp-timeline'),
					'type'			=> Controls_Manager::SELECT,
					'default'		=> '',
					'options'		=> array(
						'' => esc_html__('No', 'wp-timeline'),
						'1'=> esc_html__('Yes', 'wp-timeline')
					),
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
			return [ 'wpex-ex_s_lick','wpex-timeline' ];
		}

		protected function render() {
			$atts = $this->get_settings();
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
			
			echo do_shortcode('[wpex_timeline_horizontal style="'.$style.'" layout="'.$layout.'" posttype="'.$posttype.'" cat="'.$cat.'" tag="'.$tag.'" taxonomy="'.$taxonomy.'" ids="'.$ids.'" count="'.$count.'" order="'.$order.'" orderby="'.$orderby.'" meta_key="'.$meta_key.'" autoplay="'.$autoplay.'" show_media="'.$show_media.'" show_label="'.$show_label.'" full_content="'.$full_content.'" hide_thumb="'.$hide_thumb.'" arrow_position="'.$arrow_position.'" show_all="'.$show_all.'" header_align="'.$header_align.'" content_align="'.$content_align.'" toolbar_position="'.$toolbar_position.'" autoplayspeed="'.$autoplayspeed.'" start_on="'.$start_on.'" slidesshow="'.$slidesshow.'" loading_effect="'.$loading_effect.'" enable_back="'.$enable_back.'"]').'<script>if (typeof (Wptl_El_Sp) !== "undefined" && Wptl_El_Sp!==null) { Wptl_El_Sp.timelines_hoz(); }</script>';
		}
		
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new WPTL_Hozizontal_Elementor_Widget() );