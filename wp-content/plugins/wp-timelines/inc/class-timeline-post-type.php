<?php
include 'admin/metadata-functions.php';
class WPEX_TL_Posttype {
	public function __construct()
    {
        add_action( 'init', array( &$this, 'register_post_type' ) );
		add_action( 'init', array( &$this, 'register_category_taxonomies' ) );
		add_action( 'save_post', array($this,'add_meta_date_order'),1 );
    }
	function add_meta_date_order($post_id){
		if(isset($_POST['wpex_pkdate'])){
			$wpex_pkdate = $_POST['wpex_pkdate'];
			if(isset($wpex_pkdate['exc_mb-field-0'])){
				$order_mtk = explode("/",$wpex_pkdate['exc_mb-field-0']);
			}else{
				$order_mtk = explode("/",$wpex_pkdate);
			}
			if(!empty($order_mtk)){
				update_post_meta( $post_id, 'wptl_orderdate', $order_mtk[2].$order_mtk[0].$order_mtk[1] );
			}
		}
	}
	function register_post_type(){
		$labels = array(
			'name'               => esc_html__('Timeline','wp-timeline'),
			'singular_name'      => esc_html__('Timeline','wp-timeline'),
			'add_new'            => esc_html__('Add New Timeline','wp-timeline'),
			'add_new_item'       => esc_html__('Add New Timeline','wp-timeline'),
			'edit_item'          => esc_html__('Edit Timeline','wp-timeline'),
			'new_item'           => esc_html__('New Timeline','wp-timeline'),
			'all_items'          => esc_html__('All Timelines','wp-timeline'),
			'view_item'          => esc_html__('View Timeline','wp-timeline'),
			'search_items'       => esc_html__('Search Timeline','wp-timeline'),
			'not_found'          => esc_html__('No Timeline found','wp-timeline'),
			'not_found_in_trash' => esc_html__('No Timeline found in Trash','wp-timeline'),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__('Timeline','wp-timeline')
		);
		$wpex_timeline_slug = exwptl_get_option('exwptl_single_slug');
		if($wpex_timeline_slug==''){
			$wpex_timeline_slug = 'timeline';
		}
		if ( $wpex_timeline_slug ){
			$rewrite =  array( 'slug' => untrailingslashit( $wpex_timeline_slug ), 'with_front' => false, 'feeds' => true );
		}else{
			$rewrite = false;
		}
		$args = array(  
			'labels' => $labels,  
			'menu_position' => 8, 
			'supports' => array('title','editor','thumbnail', 'excerpt','custom-fields','author'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon' =>  'dashicons-editor-ul',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'rewrite' => $rewrite,
		);
		if(exwptl_get_option('exwptl_disable_cm','exwptl_advanced_options') == 'yes'){
			$args['supports'] = array('title','editor','thumbnail', 'excerpt','custom-fields','comments','author');
		}
		register_post_type('wp-timeline',$args);  
	}
	function register_category_taxonomies(){
		$labels = array(
			'name'              => esc_html__( 'Category', 'wp-timeline' ),
			'singular_name'     => esc_html__( 'Category', 'wp-timeline' ),
			'search_items'      => esc_html__( 'Search','wp-timeline' ),
			'all_items'         => esc_html__( 'All category','wp-timeline' ),
			'parent_item'       => esc_html__( 'Parent category' ,'wp-timeline'),
			'parent_item_colon' => esc_html__( 'Parent category:','wp-timeline' ),
			'edit_item'         => esc_html__( 'Edit category' ,'wp-timeline'),
			'update_item'       => esc_html__( 'Update category','wp-timeline' ),
			'add_new_item'      => esc_html__( 'Add New category' ,'wp-timeline'),
			'menu_name'         => esc_html__( 'Categories','wp-timeline' ),
		);			
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'timeline-category' ),
		);
		
		$labels = array(
			'name'              => esc_html__( 'Year', 'wp-timeline' ),
			'singular_name'     => esc_html__( 'Year', 'wp-timeline' ),
			'search_items'      => esc_html__( 'Search','wp-timeline' ),
			'all_items'         => esc_html__( 'All Year','wp-timeline' ),
			'parent_item'       => esc_html__( 'Parent Year' ,'wp-timeline'),
			'parent_item_colon' => esc_html__( 'Parent Year:','wp-timeline' ),
			'edit_item'         => esc_html__( 'Edit Year' ,'wp-timeline'),
			'update_item'       => esc_html__( 'Update Year','wp-timeline' ),
			'add_new_item'      => esc_html__( 'Add New Year' ,'wp-timeline'),
			'menu_name'         => esc_html__( 'Year','wp-timeline' ),
		);			
		$args_tl = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'wpex_timeline' ),
		);
		
		register_taxonomy('wpex_category', 'wp-timeline', $args);
		if(get_option('wpex_year_tax')=='on'){
			register_taxonomy('wpex_year', 'wp-timeline', $args_tl);
		}
	}
	
}
$WPEX_TL_Posttype = new WPEX_TL_Posttype();