<?php
if(!class_exists('WPTL_Timeline_SiteOrigin') && class_exists('SiteOrigin_Widget')){
	class WPTL_Timeline_SiteOrigin {
		public function __construct()
		{
			add_action( 'after_setup_theme', array($this, 'load_widget_plugins'), 11 );
		}	
		/**
		 * Load the widgets
		 *
		 * @action plugins_loaded
		 */
		function load_widget_plugins(){
			include_once plugin_dir_path(__FILE__) . 'widgets/timelines/timelines.php';
			include_once plugin_dir_path(__FILE__) . 'widgets/timelines-hozizontal/timelines-hozizonal.php';
			include_once plugin_dir_path(__FILE__) . 'widgets/timelines-hozizontal-multi/timelines-hozizonal-multi.php';
		}
	}
	new WPTL_Timeline_SiteOrigin();
}