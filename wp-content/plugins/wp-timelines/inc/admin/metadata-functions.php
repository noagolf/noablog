<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

function exwptl_get_option( $key = '', $tab=false, $default = false ) {
	if(isset($tab) && $tab!=''){
		$option_key = $tab;
	}else{
		$option_key = 'exwptl_options';
	}
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( $option_key, $key, $default );
	}
	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( $option_key, $default );
	$val = $default;
	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}
	return $val;
}

add_action( 'cmb2_admin_init', 'exwptl_register_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function exwptl_register_metabox() {
	$prefix = 'exwptl_';

	/**
	 * Timeline general info
	 */
	$mt_pt = array('wp-timeline');	
	$posttypes = exwptl_get_option('exwptl_posttype','exwptl_advanced_options');
	if(is_array($posttypes) && !empty($posttypes)){
		$mt_pt = array_merge($mt_pt,$posttypes);
	}
	$timeline_info = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'General', 'wp-timeline' ),
		'object_types'  => $mt_pt, // Post type
	) );

	$timeline_info->add_field( array(
		'name'       => esc_html__( 'Date', 'wp-timeline' ),
		'desc'       => esc_html__( 'Select date from 01/01/1000, if your date does not exit in date picker, you just need to use custom date instead', 'wp-timeline' ),
		'id'         => 'wpex_pkdate',
		'type'       => 'text',
		'classes'		 => 'column-1',
	) );
	$timeline_info->add_field( array(
		'name'       => esc_html__( 'Custom date', 'wp-timeline' ),
		'desc'       => esc_html__( 'Enter custom date or anything you want to replace with timeline date', 'wp-timeline' ),
		'id'         => 'wpex_date',
		'type'       => 'text',
		'classes'		 => 'column-1',
	) );
	$timeline_info->add_field( array(
		'name'       => esc_html__( 'Color', 'wp-timeline' ),
		'desc'       => esc_html__( 'Select custom color for this timeline', 'wp-timeline' ),
		'id'         => 'we_eventcolor',
		'type'       => 'colorpicker',
		'classes'		 => '',
	) );
	$timeline_info->add_field( array(
		'name'       => esc_html__( 'External/ Custom link', 'wp-timeline' ),
		'desc'       => esc_html__( 'Enter custom link to replace single timeline link', 'wp-timeline' ),
		'id'         => 'wpex_link',
		'type'       => 'text',
		'classes'		 => '',
	) );
	
	
	// custom metadata

	$advanced = new_cmb2_box( array(
		'id'            => $prefix . 'mtadvanced',
		'title'         => esc_html__( 'Advanced', 'wp-timeline' ),
		'object_types'  => $mt_pt,
	) );
	$advanced->add_field( array(
		'name'       => esc_html__( 'Sub label', 'wp-timeline' ),
		'desc'       => esc_html__( 'Enter Sub label for each timeline', 'wp-timeline' ),
		'id'         => 'wpex_sublabel',
		'type'       => 'text',
		'classes'		 => 'column-2',
	) );
	$advanced->add_field( array(
		'name'       => esc_html__( 'Feature label', 'wp-timeline' ),
		'desc'       => esc_html__( 'Only use for Timeline Listing shortcode', 'wp-timeline' ),
		'id'         => 'wpex_felabel',
		'type'       => 'text',
		'classes'		 => 'column-2',
	) );
	$icon_des = esc_html__('Set Icon font for this timeline (Ex: fa-star)', 'wp-timeline');
	if(exwptl_get_option('exwptl_icon_vers','exwptl_js_css_file_options')=='5'){
		$icon_des = esc_html__('Enter full class of Font Awesome 5 (Ex: fab fa-app-store)', 'wp-timeline') ;
	}
	$advanced->add_field( array(
		'name'       => esc_html__( 'Font Awesome Icon', 'teampress' ),
		'desc'       => $icon_des,
		'id'         => 'wpex_icon',
		'type'       => 'text',
		'classes'		 => '',
		'after_field'  => 'wpextl_font_awesome_picker_html',

	) );
	$advanced->add_field( array(
		'name'       => esc_html__( 'Icon Image', 'teampress' ),
		'desc'       => esc_html__( 'Set Icon image instead of icon font', 'wp-timeline' ),
		'id'         => 'wpex_icon_img',
		'type'       => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'classes'		 => '',
		'text'    => array(
			'add_upload_file_text' => esc_html__( 'Select Image', 'wp-timeline' ),
		),
		'preview_size' => array( 80, 80 ),
	) );
	if(exwptl_get_option('exwptl_image_gallery','exwptl_advanced_options') == 'yes'){
		$advanced->add_field( array(
			'name' => esc_html__( 'Image gallery', 'wp-timeline' ),
			'desc'       => esc_html__( 'Set Image gallery, only use in timeline vertial', 'wp-timeline' ),
			'id'   => 'wpex_gallery',
			'type' => 'file_list',
			'query_args' => array( 'type' => 'image' ), // Only images attachment
		) );
	}
	$advanced->add_field( array(
		'name'       => esc_html__( 'Custom metadata', 'teampress' ),
		'desc'       => esc_html__( 'Only use in single timeline page', 'wp-timeline' ),
		'id'         => 'wpex_custom_metadata',
		'repeatable'  => true,
		'show_option_none' => false,
		'type'       => 'text',
		'classes'		 => '',

	) );
	// Custom order
	$ctorder = new_cmb2_box( array(
		'id'            => $prefix . 'order',
		'title'         => esc_html__( 'Order Timeline', 'wp-timeline' ),
		'object_types'  => $mt_pt,
		'context'      => 'side', 
	) );
	$ctorder->add_field( array(
		'name'       => esc_html__( 'Custom Order', 'wp-timeline' ),
		'desc'       => esc_html__( 'Set custom order value for this timeline (enter number)', 'wp-timeline' ),
		'id'         => 'wpex_order',
		'type'       => 'text',
		'default'    => '0',
		'classes'		 => '',
		'after_field'  => '',
	) );

}
//Font awesome
function wpextl_font_awesome_picker_html() {
	if(exwptl_get_option('exwptl_icon_vers','exwptl_js_css_file_options')!='5'){
		wp_enqueue_style( 'wpex-icon', WPEX_TIMELINE . 'inc/admin/font-awesome-select/simple-iconpicker.css');
		wp_enqueue_style('wpex-font-awesome', WPEX_TIMELINE.'css/font-awesome/css/font-awesome.min.css');
		wp_enqueue_script( 'wpex-icon-js', WPEX_TIMELINE . 'inc/admin/font-awesome-select/simple-iconpicker.min.js', array( 'jquery' ) );
	}else{
		wp_enqueue_style( 'wpex-icon', WPEX_TIMELINE . 'inc/admin/font-awesome-select/simple-iconpicker.css');
		wp_enqueue_style('wpex-font-awesome-5', WPEX_TIMELINE.'css/font-awesome-5/css/all.min.css');
		wp_enqueue_style('wpex-font-awesome-shims', WPEX_TIMELINE.'css/font-awesome-5/css/v4-shims.min.css');
		wp_enqueue_script( 'wpex-icon-js', WPEX_TIMELINE . 'inc/admin/font-awesome-select/simple-iconpicker-5.min.js', array( 'jquery' ) );
	}?>
	<script>
    jQuery(document).ready(function(){
		<?php //if(exwptl_get_option('exwptl_icon_vers','exwptl_js_css_file_options')!='5'){?>
			jQuery('input#wpex_icon').iconpicker("input#wpex_icon");
		<?php //}?>
		jQuery('.select-ico').on('click',function() {
			jQuery('input#wpex_icon').val('');
		});
    });
    </script>
    <span class="button select-ico" aria-hidden="true" style=""><?php esc_html_e('Remove','wp-timeline');?></span>

<?php }
// Regiter metadata fo menu
add_action( 'cmb2_admin_init', 'exwptl_register_taxonomy_metabox' );
function exwptl_register_taxonomy_metabox() {
	$prefix = 'exwptl_menu_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'data',
		'title'            => esc_html__( 'Category Metabox', 'wp-timeline' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'exwptl_cat'), // Tells CMB2 which taxonomies should have these fields
		'new_term_section' => true, // Will display in the "Add New Category" section
	) );
	/*$cmb_term->add_field( array(
		'name' => esc_html__( 'Menu Image', 'wp-timeline' ),
		'desc' => esc_html__( 'Set image url for menu', 'wp-timeline' ),
		'id'   => $prefix . 'img',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		),
		'text'    => array(
			'add_upload_file_text' => esc_html__( 'Select Image', 'wp-timeline' ),
		),
	) );*/
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Menu Icon', 'wp-timeline' ),
		'desc' => esc_html__( 'Set icon image for menu', 'wp-timeline' ),
		'id'   => $prefix . 'icon',
		'type' => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
				'image/svg',
			),
		),
		'preview_size' => 'medium',
		'text'    => array(
			'add_upload_file_text' => esc_html__( 'Select Image', 'wp-timeline' ),
		),
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Order Menu', 'wp-timeline' ),
		'id'   => $prefix .'order',
		'type' => 'text',
			'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
	        'escape_cb'       => 'absint',
	) );
}




function exwptl_allow_metadata_save_html( $original_value, $args, $cmb2_field ) {
    return $original_value; // Unsanitized value.
}
function exwptl_add_js_for_repeatable_titles() {
	add_action( is_admin() ? 'admin_footer' : 'wp_footer', 'exwptl_js_repeatable_titles_custom_data' );
}
function exwptl_js_repeatable_titles_custom_data() {
	exwptl_js_for_repeatable_titles('exwptl_custom_data');
}
function exwptl_repeatable_titles_for_options() {
	add_action( is_admin() ? 'admin_footer' : 'wp_footer', 'exwptl_js_repeatable_titles_options' );
}
function exwptl_js_repeatable_titles_options() {
	exwptl_js_for_repeatable_titles('exwptl_addition_options');
}
function exwptl_js_for_repeatable_titles($id) {
	
}
/**
 * Callback to define the optionss-saved message.
 *
 * @param CMB2  $cmb The CMB2 object.
 * @param array $args {
 *     An array of message arguments
 *
 *     @type bool   $is_options_page Whether current page is this options page.
 *     @type bool   $should_notify   Whether options were saved and we should be notified.
 *     @type bool   $is_updated      Whether options were updated with save (or stayed the same).
 *     @type string $setting         For add_settings_error(), Slug title of the setting to which
 *                                   this error applies.
 *     @type string $code            For add_settings_error(), Slug-name to identify the error.
 *                                   Used as part of 'id' attribute in HTML output.
 *     @type string $message         For add_settings_error(), The formatted message text to display
 *                                   to the user (will be shown inside styled `<div>` and `<p>` tags).
 *                                   Will be 'Settings updated.' if $is_updated is true, else 'Nothing to update.'
 *     @type string $type            For add_settings_error(), Message type, controls HTML class.
 *                                   Accepts 'error', 'updated', '', 'notice-warning', etc.
 *                                   Will be 'updated' if $is_updated is true, else 'notice-warning'.
 * }
 */
function exwptl_options_page_message_( $cmb, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'wp-timeline' ), $cmb->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}


function exwptl_register_setting_options() {
	/**
	 * Registers main options page menu item and form.
	 */
	$args = array(
		'id'           => 'exwptl_options_page',
		'title'        => esc_html__('Settings','wp-timeline'),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'exwptl_options',
		'parent_slug'  => 'edit.php?post_type=wp-timeline',
		'tab_group'    => 'exwptl_options',
		'tab_title'    => esc_html__('General','wp-timeline'),
		'message_cb'      => 'exwptl_options_page_message_',
	);
	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'exwptl_options_display_with_tabs';
	}
	$main_options = new_cmb2_box( $args );
	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	$main_options->add_field( array(
		'name'    => esc_html__('Main Color','wp-timeline'),
		'desc'    => esc_html__('Choose Main Color for plugin','wp-timeline'),
		'id'      => 'exwptl_color',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Content Font Family', 'wp-timeline' ),
		'desc'       => esc_html__('Enter Google font-family name . For example, if you choose "Source Sans Pro" Google Font, enter Source Sans Pro','wp-timeline'),
		'id'         => 'exwptl_font_family',
		'type'       => 'text',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Content Font Size', 'wp-timeline' ),
		'desc'       => esc_html__('Enter size of main font, default:13px, Ex: 14px','wp-timeline'),
		'id'         => 'exwptl_font_size',
		'type'       => 'text',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'    => esc_html__('Content Font Color','wp-timeline'),
		'desc'    => esc_html__('Choose Content Font Color for plugin','wp-timeline'),
		'id'      => 'exwptl_ctcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Heading Font Family', 'wp-timeline' ),
		'desc'       => esc_html__('Enter Google font-family name. For example, if you choose "Oswald" Google Font, enter Oswald','wp-timeline'),
		'id'         => 'exwptl_headingfont_family',
		'type'       => 'text',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Heading Font Size', 'wp-timeline' ),
		'desc'       => esc_html__('Enter size of heading font, default: 20px, Ex: 22px','wp-timeline'),
		'id'         => 'exwptl_headingfont_size',
		'type'       => 'text',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'    => esc_html__('Heading Font Color','wp-timeline'),
		'desc'    => esc_html__('Choose Heading Font Color for plugin','wp-timeline'),
		'id'      => 'exwptl_hdcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Meta Font Family', 'wp-timeline' ),
		'desc'       => esc_html__('Enter Google font-family name. For example, if you choose "Ubuntu" Google Font, enter Ubuntu','wp-timeline'),
		'id'         => 'exwptl_metafont_family',
		'type'       => 'text',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'       => esc_html__( 'Meta Font Size', 'wp-timeline' ),
		'desc'       => esc_html__('Enter size of metadata font, default:13px, Ex: 12px','wp-timeline'),
		'id'         => 'exwptl_metafont_size',
		'type'       => 'text',
		'default' => '',
	) );
	$main_options->add_field( array(
		'name'    => esc_html__('Meta Font Color','wp-timeline'),
		'desc'    => esc_html__('Choose Meta Font Color for plugin','wp-timeline'),
		'id'      => 'exwptl_mtcolor',
		'type'    => 'colorpicker',
		'default' => '',
	) );
	
	$main_options->add_field( array(
		'name'             => esc_html__( 'Timeline slug', 'wp-timeline' ),
		'desc'             => esc_html__( 'Remember to save the permalink settings again in Settings > Permalinks', 'wp-timeline' ),
		'show_on_cb' => 'exwptl_hide_if_disable_single',
		'id'               => 'exwptl_single_slug',
		'type'       => 'text',
		'default' => '',
	) );
	/**
	 * Registers Advanced options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'exwptl_advanced',
		'menu_title'   => '',
		'object_types' => array( 'options-page' ),
		'option_key'   => 'exwptl_advanced_options',
		'parent_slug'  => 'edit.php?post_type=wp-timeline',
		'tab_group'    => 'exwptl_options',
		'tab_title'    => esc_html__('Advanced','wp-timeline'),
	);
	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'exwptl_options_display_with_tabs';
	}
	$adv_options = new_cmb2_box( $args );

	$args = array(
	   'public'   => true,
	);
	$output = 'objects';
	$post_types = get_post_types( $args, $output );
	$listpt = array();
	foreach ( $post_types  as $post_type ) {
		if($post_type->name!='attachment' && $post_type->name!='elementor_library'&&$post_type->name!='wp-timeline'){
			$listpt[$post_type->name] = $post_type->label;
		}
	}
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Post types', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select Post types to Enable timeline metadata (This feature only effect to timeline shortcode, it will not change anything in single post)', 'wp-timeline' ),
		'id'               => 'exwptl_posttype',
		'type'             => 'multicheck_inline',
		'classes'             => 'column-1',
		'show_option_none' => false,
		'default'          => 'wp-timeline',
		'options'          => $listpt
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Enable Image gallery', 'wp-timeline' ),
		'desc'             => esc_html__( 'Enable image gallery field, only use in timeline vertial', 'wp-timeline' ),
		'id'               => 'exwptl_image_gallery',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'yes'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	// Frontend Static text
	$adv_options->add_field( array(
		'name' => esc_html__('Frontend Static text','wp-timeline'),
		'desc' => '',
		'id'   => 'exwptl_fe_text',
		'type'        => 'title', 
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Continue reading', 'wp-timeline' ),
		'desc'             => esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
		'id'               => 'exwptl_text_ct',
		'type'       => 'text',
		'default' => esc_html__('Continue reading','wp-timeline'),
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Load more', 'wp-timeline' ),
		'desc'             => esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
		'id'               => 'exwptl_text_lm',
		'type'       => 'text',
		'default' => esc_html__('Load more','wp-timeline'),
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Next article', 'wp-timeline' ),
		'desc'             => esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
		'id'               => 'exwptl_text_na',
		'type'       => 'text',
		'default' => '',
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Previous article', 'wp-timeline' ),
		'desc'             => esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
		'id'               => 'exwptl_text_pa',
		'type'       => 'text',
		'default' => '',
	) );
	// Single timeline
	$adv_options->add_field( array(
		'name' => esc_html__('Single Timeline','wp-timeline'),
		'desc' => '',
		'id'   => 'exwptl_single_tl',
		'type'        => 'title', 
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Disable link & Single timeline page', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select yes to disable link and single timeline page', 'wp-timeline' ),
		'id'               => 'exwptl_disable_single',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'yes'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Disable social share', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select yes to disable social share in single timeline page', 'wp-timeline' ),
		'id'               => 'exwptl_disable_social',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'yes'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Show Next & Previous', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select No to disable next & previous link in Single timeline page', 'wp-timeline' ),
		'id'               => 'exwptl_disable_nepre',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			''   => esc_html__( 'Yes', 'wp-timeline' ),
			'no' => esc_html__( 'No', 'wp-timeline' ),
		),
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Next & Previous order by', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select order for next & previous link', 'wp-timeline' ),
		'id'               => 'exwptl_np_order',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			''   => esc_html__( 'Publish date', 'wp-timeline' ),
			'ct_order' => esc_html__( 'Custom order field', 'wp-timeline' ),
		),
	) );
	$adv_options->add_field( array(
		'name'             => esc_html__( 'Enable Comment', 'wp-timeline' ),
		'desc'             => esc_html__( 'Enable Comment form for Single timeline page', 'wp-timeline' ),
		'id'               => 'exwptl_disable_cm',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'yes'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	
	/**
	 * Registers secondary options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'exwptl_custom_code',
		'menu_title'   => '',
		'object_types' => array( 'options-page' ),
		'option_key'   => 'exwptl_custom_code_options',
		'parent_slug'  => 'edit.php?post_type=wp-timeline',
		'tab_group'    => 'exwptl_options',
		'tab_title'    => esc_html__('Custom Code','wp-timeline'),
	);
	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'exwptl_options_display_with_tabs';
	}
	$customcode_options = new_cmb2_box( $args );
	$customcode_options->add_field( array(
		'name' => esc_html__('Custom Css','wp-timeline'),
		'desc' => esc_html__('Paste your custom Css code','wp-timeline'),
		'id'   => 'exwptl_custom_css',
		'type' => 'textarea_code',
		'attributes' => array(
			'data-codeeditor' => json_encode( array(
				'codemirror' => array(
					'mode' => 'css'
				),
			) ),
		),
	) );
	$customcode_options->add_field( array(
		'name' => esc_html__('Custom Js','wp-timeline'),
		'desc' => esc_html__('Paste your custom Js code','wp-timeline'),
		'id'   => 'exwptl_custom_js',
		'type' => 'textarea_code',
		'attributes' => array(
			'data-codeeditor' => json_encode( array(
				'codemirror' => array(
					'mode' => 'javascript'
				),
			) ),
		),
	) );
	/**
	 * Registers tertiary options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'exwptl_js_css_file',
		'menu_title'   => '',
		'object_types' => array( 'options-page' ),
		'option_key'   => 'exwptl_js_css_file_options',
		'parent_slug'  => 'edit.php?post_type=wp-timeline',
		'tab_group'    => 'exwptl_options',
		'tab_title'    => esc_html__('Js + Css file','wp-timeline'),
	);
	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'exwptl_options_display_with_tabs';
	}
	$file_options = new_cmb2_box( $args );

	$file_options->add_field( array(
		'name'             => esc_html__( 'Loading css file on', 'wp-timeline' ),
		'desc'             => '',
		'id'               => 'exwptl_css_load',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' => esc_html__( 'Site-wide', 'wp-timeline' ),
			'page'   => esc_html__( 'Page with content contain timeline', 'wp-timeline' ),
			'shortcode'   => esc_html__( 'Only in timeline shortcode', 'wp-timeline' ),
		),
	) );

	$file_options->add_field( array(
		'name'             => esc_html__( 'Turn off Font Awesome', 'wp-timeline' ),
		'desc'             => esc_html__( "Turn off loading plugin's Font Awesome, select yes if your theme has already loaded this library", 'wp-timeline' ),
		'id'               => 'exwptl_disable_awesome',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'on'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	$file_options->add_field( array(
		'name'             => esc_html__( 'Font Awesome version', 'wp-timeline' ),
		'desc'             => esc_html__( 'Choose Font Awesome version are you want to use. You may need enter full class of some icon again when switch from 4.7 to 5.3', 'wp-timeline' ),
		'id'               => 'exwptl_icon_vers',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' => esc_html__( '4.7', 'wp-timeline' ),
			'5'   => esc_html__( '5.9', 'wp-timeline' ),
		),
	) );
	$file_options->add_field( array(
		'name'             => esc_html__( 'Turn off Google Font', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select yes if you do not use Google Font', 'wp-timeline' ),
		'id'               => 'exwptl_disable_ggfont',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'on'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );

	$file_options->add_field( array(
		'name'             => esc_html__( 'Turn off css file of timeline side by side', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select yes if you do not use timeline side by side', 'wp-timeline' ),
		'id'               => 'exwptl_css_sbs',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'on'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	$file_options->add_field( array(
		'name'             => esc_html__( 'Turn off css file of timeline horizontal', 'wp-timeline' ),
		'desc'             => esc_html__( 'Select yes if you do not use Timeline Side by side', 'wp-timeline' ),
		'id'               => 'exwptl_css_hoz',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'on'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
	$file_options->add_field( array(
		'name'             => esc_html__( 'RTL mode', 'wp-timeline' ),
		'desc'             => esc_html__( 'Enable RTL css for RTL language', 'wp-timeline' ),
		'id'               => 'exwptl_enable_rtl',
		'type'             => 'select',
		'show_option_none' => false,
		'default' => '',
		'options'          => array(
			'' => esc_html__( 'No', 'wp-timeline' ),
			'yes'   => esc_html__( 'Yes', 'wp-timeline' ),
		),
	) );
}
add_action( 'cmb2_admin_init', 'exwptl_register_setting_options' );

function exwptl_hide_if_disable_single( $field ) {
	if ( exwptl_get_option('exwptl_disable_single','exwptl_advanced_options') =='yes' ) {
		return false;
	}
	return true;
}
/**
 * A CMB2 options-page display callback override which adds tab navigation among
 * CMB2 options pages which share this same display callback.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 */
function exwptl_options_display_with_tabs( $cmb_options ) {
	$tabs = exwptl_options_page_tabs( $cmb_options );
	?>
	<div class="wrap cmb2-options-page option-<?php echo esc_attr($cmb_options->option_key); ?>">
		<?php if ( get_admin_page_title() ) : ?>
			<h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
		<?php endif; ?>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $option_key => $tab_title ) : ?>
				<a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
			<?php endforeach; ?>
		</h2>
		<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo esc_attr($cmb_options->cmb->cmb_id); ?>" enctype="multipart/form-data" encoding="multipart/form-data">
			<input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
			<?php $cmb_options->options_page_metabox(); ?>
			<?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
		</form>
	</div>
	<?php
}
/**
 * Gets navigation tabs array for CMB2 options pages which share the given
 * display_cb param.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 *
 * @return array Array of tab information.
 */
function exwptl_options_page_tabs( $cmb_options ) {
	$tab_group = $cmb_options->cmb->prop( 'tab_group' );
	$tabs      = array();
	foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
		if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
			$tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
				? $cmb->prop( 'tab_title' )
				: $cmb->prop( 'title' );
		}
	}
	return $tabs;
}