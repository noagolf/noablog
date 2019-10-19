<?php
if(!class_exists('WPTL_Hozizontal_Elementor')){
	
	class WPTL_Hozizontal_Elementor {
		public function __construct() {
			add_action( 'elementor/init', array( $this, 'addons' ) );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets') );
			add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		}
		
		public function widgets() {
			 require_once( wpex_get_plugin_url(). 'inc/elementor/timeline-list.php' );
			 require_once( wpex_get_plugin_url(). 'inc/elementor/timeline-hozizontal.php' );
			 require_once( wpex_get_plugin_url(). 'inc/elementor/timeline-hozizontal-multi.php' );
		}
		public function widget_scripts() {
			wp_register_script( 'wpex-ex_s_lick', WPEX_TIMELINE.'js/ex_s_lick/ex_s_lick.js', array( 'jquery' ) );
			wp_register_script( 'wpex-timeline', WPEX_TIMELINE.'js/template.min.js', array( 'jquery' ) );
		}
		
		public function addons() {
			Elementor\Plugin::instance()->elements_manager->add_category(
				'wp_timelines',
				array(
					'title' => esc_html__( 'WP Timelines', 'wp-timeline'),
				),
				1
			);
		}	
	}
	
}
new WPTL_Hozizontal_Elementor();