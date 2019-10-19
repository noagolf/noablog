<?php
/*
Widget Name: Hello world widget
Description: An example widget which displays 'Hello world!'.
Author: Me
Author URI: http://example.com
Widget URI: http://example.com/hello-world-widget-docs,
Video URI: http://example.com/hello-world-widget-video
*/
class SiteOrigin_Widget_WPTL_Widget extends SiteOrigin_Widget {
	function __construct() {
		
		parent::__construct(
			'wpex_timeline',
			__( 'Timelines', 'wp-timeline' ),
			array(
				'description' => __( 'A timeline widget.', 'wp-timeline' ),
				'help' => '',
			),
			array(),
			false,
			plugin_dir_path( __FILE__ )
		);
	}
	
	/**
	 * Initialize the accordion widget.
	 */
	function initialize() {
		$this->register_frontend_scripts(
			array(
				array(
					'wpex-timeline',
					WPEX_TIMELINE . 'js/template.min.js',
					array( 'jquery' ),
					'3.2'
				)
			)
		);
		$this->register_frontend_styles(
			array(
				array(
					'wpex-timeline-css',
					WPEX_TIMELINE . 'css/style.css',
					array(),
					'3.2'
				),
			)
		);
		$this->register_frontend_styles(
			array(
				array(
					'wpex-timeline-sidebyside',
					WPEX_TIMELINE . 'css/style-sidebyside.css',
					array(),
					'3.2'
				),
			)
		);
	}
	
	function get_widget_form() {
		$args = array(
		   'public'   => true,
		);
		$output = 'objects';
		$post_types = get_post_types( $args, $output );
		$listpt = array();
		foreach ( $post_types  as $post_type ) {
			if($post_type->name!='attachment'){
				$listpt[$post_type->name] = $post_type->label;
			}
		}
		return array(
			'style' => array(
				'type' => 'select',
				'label' => esc_html__('Style', 'wp-timeline'),
				'default' => 'modern',
				'options' => array(
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
			),
			'alignment' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Alignment', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Center', 'wp-timeline'),
					'left' => esc_html__('Left', 'wp-timeline'),
					'sidebyside' => esc_html__('Side by side', 'wp-timeline'),
				),
			),
			'posttype' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Post types', 'wp-timeline'),
				'default'		=> 'wp-timeline',
				'options'		=> $listpt
			),
			'ids' => array(
				'type' => 'text',
				'label'			=> esc_html__( 'IDs', 'wp-timeline'),
				'description'		=> esc_html__("Specify post IDs to retrieve", "wp-timeline"),
			),
			'count' => array(
				'type' => 'text',
				'label'			=> esc_html__( 'Count', 'wp-timeline'),
				'default' => 6,
				'description'		=> esc_html__("Number of posts", 'wp-timeline'),
			),
			'posts_per_page' => array(
				'type' => 'text',
				'label'			=> esc_html__( 'Posts per page', 'wp-timeline'),
				'default' => '',
				'description'		=> esc_html__("Number item per page", 'wp-timeline'),
			),
			'cat' => array(
				'type' => 'text',
				'label'			=> esc_html__( 'Category', 'wp-timeline'),
				'default' => '',
				'description'		=> esc_html__("List of cat ID (or slug), separated by a comma", "wp-timeline"),
			),
			'tag' => array(
				'type' => 'text',
				'label'			=> esc_html__("Tags", "wp-timeline"),
				'default' => '',
				'description'		=> esc_html__("List of tags, separated by a comma", "wp-timeline"),
			),
			'taxonomy' => array(
				'type' => 'text',
				'label'			=> esc_html__("Custom Taxonomy", "wp-timeline"),
				'default' => '',
				'description'		=> esc_html__("Name of custom taxonomy", "wp-timeline"),
			),
			'order' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Order', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'DESC' => esc_html__('DESC', 'wp-timeline'),
					'ASC'=> esc_html__('ASC', 'wp-timeline')
				),
			),
			'orderby' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Order by', 'wp-timeline'),
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
			),
			'meta_key' => array(
				'type' => 'text',
				'label'			=> esc_html__("Meta key", "wp-timeline"),
				'default' => '',
				'description'		=> esc_html__("Enter meta key to query", "wp-timeline"),
			),
			'start_label' => array(
				'type' => 'text',
				'label'			=> esc_html__("Start label", "wp-timeline"),
				'default' => '',
				"description" => esc_html__("Enter text", "wp-timeline"),
			),
			'end_label' => array(
				'type' => 'text',
				'label'			=> esc_html__("End label", "wp-timeline"),
				'default' => '',
				"description" => esc_html__("Enter text", "wp-timeline"),
			),
			'show_media' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show media', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'1' => esc_html__('Yes', 'wp-timeline'),
					'0'=> esc_html__('No', 'wp-timeline')
				),
			),
			'show_history' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show history bar', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => esc_html__("Show label instead of date on timeline bar", "wp-timeline")
			),
			'full_content' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show full Content', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => esc_html__("Show full Content instead of Excerpt", "wp-timeline")
			),
			'filter_cat' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show Filter by category', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => '',
			),
			'feature_label' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show Feature label', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => '',
			),
			'hide_title' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Hide Title', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => ''
			),
			'hide_img' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Hide thubnails', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => ''
			),
			'animations' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Animations', 'wp-timeline'),
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
			),
			'img_size' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Image size', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Default', 'wp-timeline'),
					'full'=> esc_html__('Full', 'wp-timeline')
				),
				'description'		=> '',
			),
			'lightbox' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Enable image lightbox', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				'description'		=> '',
			),
			'page_navi' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Page navigation', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Load more', 'wp-timeline'),
					'inf'=> esc_html__('Infinite Scroll', 'wp-timeline'),
					'pag'=> esc_html__('Page links', 'wp-timeline')
				),
				'description'		=> '',
			),
			'enable_back' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Enable Back to timeline page', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'yes'=> esc_html__('Yes', 'wp-timeline')
				),
				'description'		=> esc_html__("Only work with timeline post type", "wp-timeline"),
			),

			
		);
	}
	
	function get_template_name($instance) {
        return 'tl-shortcode';
    }

    function get_style_name($instance) {
        return 'tpl';
    }
}

siteorigin_widget_register('wpex_timeline', __FILE__, 'SiteOrigin_Widget_WPTL_Widget');
