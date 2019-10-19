<?php
/*
Widget Name: Timelines Horizontal
Description: An Timelines to squeeze a lot of content into a small space.
Author: Ex-Themes
Author URI: https://exthemes.net/
*/

class SiteOrigin_Widget_WPTL_Hozi_Widget extends SiteOrigin_Widget {
	function __construct() {
		
		parent::__construct(
			'wpex_timeline_hoz',
			__( 'Timelines Horizontal', 'wp-timeline' ),
			array(
				'description' => __( 'A timeline Horizontal widget.', 'wp-timeline' ),
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
					'wpex-ex_s_lick',
					WPEX_TIMELINE . 'js/ex_s_lick/ex_s_lick.js',
					array( 'jquery' ),
					'3.2'
				)
			)
		);
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
					'wpex-horiz-css',
					WPEX_TIMELINE . 'css/horiz-style.css',
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
				'label'			=> esc_html__( 'Style', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Left side', 'wp-timeline'),
					'full-width'=> esc_html__('Full Width', 'wp-timeline'),
				),
			),
			'layout' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Layout', 'wp-timeline'),
				'default'		=> 'horizontal',
				'options'		=> array(
					'horizontal' => esc_html__('Horizontal', 'wp-timeline'),
					'hozsteps' => esc_html__('Horizontal Step', 'wp-timeline'),
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
			'slidesshow' => array(
				'type' => 'text',
				'label'			=> esc_html__( 'Number item visible', 'wp-timeline'),
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
			'start_on' => array(
				'type' => 'text',
				'label'			=> esc_html__("Slide to start on", "wp-timeline"),
				'default' => '',
				"description" => esc_html__("Enter number, Default:0", "wp-timeline"),
			),
			'header_align' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Header alignment', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Default', 'wp-timeline'),
					'center'=> esc_html__('Center', 'wp-timeline'),
					'left'=> esc_html__('Left', 'wp-timeline')
				),
			),
			'content_align' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Content alignment', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Center', 'wp-timeline'),
					'left'=> esc_html__('Left', 'wp-timeline')
				),
			),
			'arrow_position' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Arrow buttons position', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('Center', 'wp-timeline'),
					'top'=> esc_html__('In timeline bar', 'wp-timeline')
				),
			),
			'toolbar_position' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Timeline bar position', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'top' => esc_html__('Top', 'wp-timeline'),
					'bottom'=> esc_html__('Bottom', 'wp-timeline')
				),
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
			'show_label' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show label', 'wp-timeline'),
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
			
			'show_all' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Show all items', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => esc_html__("Show all items on timeline bar", "wp-timeline"),
			),
			'hide_thumb' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Hide thubnails', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
				"description" => ''
			),
			'autoplay' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Autoplay', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
			),
			'autoplayspeed' => array(
				'type' => 'text',
				'label'			=> esc_html__( 'Autoplay Speed', 'wp-timeline'),
				'default'		=> '',
				'description'		=> esc_html__("Autoplay Speed in milliseconds. Default:3000", "wp-timeline"),
			),
			'loading_effect' => array(
				'type' => 'select',
				'label'			=> esc_html__( 'Enable Loading effect', 'wp-timeline'),
				'default'		=> '',
				'options'		=> array(
					'' => esc_html__('No', 'wp-timeline'),
					'1'=> esc_html__('Yes', 'wp-timeline')
				),
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
        return 'tlhoz-shortcode';
    }

    function get_style_name($instance) {
        return 'tpl';
    }
}

siteorigin_widget_register('wpex_timeline_hoz', __FILE__, 'SiteOrigin_Widget_WPTL_Hozi_Widget');
