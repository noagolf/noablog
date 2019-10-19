<?php

if (!class_exists('CoolTimelineShortcode')) {

    class CoolTimelineShortcode {

        /**
         * The Constructor
         */
        public function __construct() {
            // register actions
            add_action('init', array($this, 'cooltimeline_register_shortcode'));

            add_action('wp_enqueue_scripts', array($this, 'ctl_load_assets'));
          
            add_action('wp_enqueue_scripts', array('CooltimelineStyles','ctl_custom_styles'));
            add_action('wp_head', array('CooltimelineStyles', 'ctl_navigation_styles'));

            // Call actions and filters in after_setup_theme hook
            add_action('after_setup_theme', array($this, 'ctl_pro_read_more'), 999);
            add_filter('excerpt_length', array($this, 'ctl_ex_len'), 999);
            add_filter( 'body_class', array($this, 'ctl_body_class') );

          //  add_filter( 'the_content', array($this,'ctl_back_to_timeline'));
        }
      
        /*
          Register Shortcode for cooltimeline 
         */
        function cooltimeline_register_shortcode() {
            add_shortcode('cool-timeline', array($this, 'cooltimeline_view'));

        }
        /*
          Timeline Views
         */
        function cooltimeline_view($atts, $content = null) {
          
            $attribute = shortcode_atts(array(
                'show-posts' => '',
                'order' => '',
                'category' => 0,
                'layout' => 'default',
                'designs'=>'',
                'items'=>'',
                'skin' =>'',
                'type'=>'',
                'icons' =>'',
                'animations'=>'',
                'animation'=>'',
                'date-format'=>'',
                'based'=>'default',
                'story-content'=>'',
                'pagination'=>'default',
                'compact-ele-pos'=>'main-date',
                'filters'=>'no',
                'autoplay'=>'false',
                'start-on'=>0
               ), $atts);
               
               $design_cls='';
               $type='';
               $pagination=$attribute['pagination'];
            
             if(isset($attribute['type'])&& !empty($attribute['type'])){

                if($attribute['type']=="default"){
                   $layout=$attribute['layout'];
                    $type=$attribute['layout'];
                  }else{
                     $layout=$attribute['type'];
                      $type=$attribute['type'];
                  }
                }else{
                $layout=$attribute['layout'] ?$attribute['layout']:'default';
                  }
                $tm_active_design='';
            if(isset($attribute['designs']))
              {
                $tm_active_design=$attribute['designs'];
              }else{
                 $tm_active_design='default';
              }

            /*
              Loading CSS and JS
            */
             //loading all required assets
             ctl_load_global_assets();
             // loading layout specifc assets
            clt_conditional_assets($layout,$type,$tm_active_design);

            // generates  wp query object
            require('ctl-build-query.php');
              // loads horizontal layout content
           if($layout && $layout=="horizontal"){
             $clt_hori_view='';
              require('views/story-horizontal-layout.php');

             return $clt_hori_view;

            }else {
                // if layout type is vertical

                // if users has enabled ajax load more then pass ajax url and other attributes
             if(($pagination=="ajax_load_more"|| $attribute['filters']=="yes")){
               wp_localize_script( 'ctl-ajax-load-more', 'ctlloadmore',
                 array( 'url' => admin_url( 'admin-ajax.php' ),'attribute'=>$attribute) );
               }

             // set vars for later use  
               $output = ''; $ctl_html = ''; $ctl_format_html = '';
               $ctl_animation='';$last_year='';  $alternate=0;
               $ctl_avtar_html = ''; $timeline_id = '';$clt_icons='';


               // creates classes based on design type
           if($attribute['designs'])
                {
                    $design_cls='main-'.$attribute['designs'];
                    $design=$attribute['designs'];
                   }else{
                    $design_cls='main-default';
                    $design='default';
                  }
                  $old_animations=array("bounceInUp","bounceInDown","bounceInLeft","bounceInRight","slideInDown","slideInUp",
                  "bounceIn","slideInLeft","slideInRight","shake","wobble","swing","jello","flip","fadein",
                  "rotatein","zoomIn");
                  // set stories animations
                 
                if (isset($attribute['animations'])) {
                    $ctl_animation=$attribute['animations'];
                }elseif($attribute['animation']){
                  $ctl_animation=$attribute['animation'];
                 }else{
                  $ctl_animation ='fade-in';
                     }
                  if(in_array($ctl_animation,$old_animations)){
                    $ctl_animation ='fade-in';
                  }  
              
                  // icon settings   
                if (isset($attribute['icons']) && $attribute['icons']=="YES"){
                    $clt_icons='icons_yes';
                }else{
                    $clt_icons='icons_no';
                }

                // Timeline main title 

                // show category name if category based timeline else show admin dynamic text
                if ($attribute['category']) {
                  if(is_numeric($attribute['category'])){
                         $ctl_term = get_term_by('id', $attribute['category'], 'ctl-stories');
                        }else{
                    $ctl_term = get_term_by('slug', $attribute['category'], 'ctl-stories');
                      }
                
                    if (isset($ctl_term->name) && $ctl_term->name == "Timeline Stories") {
                        $ctl_title_text =isset($ctl_options_arr['title_text'])? $ctl_options_arr['title_text'] : 'Timeline';
                    } else {
                        $ctl_title_text = isset($ctl_term->name)?$ctl_term->name:"";
                    }
                    $catId = $attribute['category'];
                    $timeline_id = "timeline-$catId";
                } else {
                    // admin dynamic text 
                    $ctl_title_text = isset($ctl_options_arr['title_text'])? $ctl_options_arr['title_text'] : 'Timeline';
                    $timeline_id = "timeline-".rand(1,10);
                }
                  
             $ctl_html_no_cont = ''; $layout_wrp = '';
                // add custom wrapper if layout is compact
                if($attribute['layout']=="compact"){
                    $compact_id="ctl-compact-pro-".rand(1,20);
                    $ctl_html .='<div id="'.$compact_id.'" class="clt-compact-cont"><div class="center-line"></div>';
              }

              //loads content vertical layout 
             require("views/story-vertical-layout.php");
             
             // add clear fix if layout mode is compact 
              $ctl_html .= '<div  class="end-timeline clearfix"></div>';
                if($attribute['layout']=="compact"){
                    $ctl_html .='</div>';
                }

                // creating dynamic classes for timeline main wrapper
         $main_wrp_id='tm-'.$attribute['layout'].'-'.$attribute['designs'].'-'.rand(1,20);
        $main_wrp_cls=array();
        $main_wrp_cls[]="cool_timeline";
        $main_wrp_cls[]="cool-timeline-wrapper";
        $main_wrp_cls[]=$layout_wrp;
        $main_wrp_cls[]=$wrapper_cls;
        $main_wrp_cls[]=$design_cls;
        $main_wrp_cls=apply_filters('ctl_wrapper_clasess',$main_wrp_cls);     
    

     // timeline wrapper html    
    $output .='<!========= Cool Timeline PRO '.CTLPV.' =========>';

    // main div with settings
    $output .= '<div style="opacity:0;" 
    data-showposts="'.$attribute['show-posts'].'"
     class="'.implode(" ",$main_wrp_cls).'" 
     id="'. $main_wrp_id.'"  
     data-pagination="' . $enable_navigation . '"  
     data-pagination-position="' . $navigation_position . '">';

    // main top title html
     $output .=ctl_main_title($ctl_options_arr,$ctl_title_text,$ttype='default_timeline');
     
     // generate categories html if user have enable cateogry filters
     if($attribute['filters']=="yes"){
            $output.=ctl_categories_filters($taxo="ctl-stories",$select_cat=$attribute['category'] ,$type="story-tm",$layout);
         }

         // timeline content div
     $output .= '<div class="cool-timeline ultimate-style ' . $layout_cls . ' ' . $wrp_cls . '">';
     // preloader container
     $output .='<div  class="filter-preloaders"><img src="'.CTP_PLUGIN_URL.'/images/clt-compact-preloader.gif"></div>';
         // timeline container
     $output .= '<div data-animations="'.$ctl_animation.'"  id="' . $timeline_id . '" class="cooltimeline_cont  clearfix '.$clt_icons.'">';
    
    //  stories content
     $output .= $ctl_html;
     $output .= '</div>';
        

     // stories pagination


        if($pagination=="ajax_load_more"){
            //ajax load more
                //if($ctl_loop->max_num_pages>1){
             $output.='<button data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>'.__(' Loading','cool-timeline').'" data-max-num-pages="'.$ctl_loop->max_num_pages.'" 
             data-timeline-type="'.$layout.'"   class="ctl_load_more">'.__('Load More','cool-timeline').'</button>';
                 //}
                }else{
              if ($enable_pagination == "yes") {
                  // default numbers pagination
                  if (function_exists('ctl_pro_pagination')) {
                      $output .= ctl_pro_pagination($ctl_loop->max_num_pages, "", $paged);
                  }
              }
              }
            $output .= $ctl_html_no_cont;
            $output .= '</div></div>  <!-- end
================================================== -->';
              // loads dynamic style
              $stories_styles='<style type="text/css">'.$story_styles.'</style>';
              
              // return final output
              return $output.$stories_styles;

            }

        }

        /*
          Read more button for timeline stories
         */

        function ctl_pro_read_more() {

            // add more link to excerpt
            function ctl_p_excerpt_more($more) {
                global $post;
                $ctl_options_arr = get_option('cool_timeline_options');
                $r_more= $ctl_options_arr['display_readmore']?$ctl_options_arr['display_readmore']:"yes";

                    $read_more='';
                    if(isset($ctl_options_arr['read_more_lbl'])&& !empty($ctl_options_arr['read_more_lbl']))
                        {
                    $read_more=__($ctl_options_arr['read_more_lbl'],'cool-timeline');
                         } else{
                         $read_more=__('Read More', 'cool-timeline');
                         }  
                
                if ($post->post_type == 'cool_timeline' && !is_single()) {

                     $custom_link = get_post_meta($post->ID, 'story_custom_link', true);
                    if ($r_more == 'yes') {

                    
                    if($custom_link){
                        return '..<a  target="_blank" class="read_more ctl_read_more" href="' . $custom_link. '">' .$read_more. '</a>';
                         }else{
                        return '..<a class="read_more ctl_read_more" href="' . get_permalink($post->ID) . '">' .$read_more. '</a>';
                        }
                    }
                } else {
                    return $more;
                }
            }

            add_filter('excerpt_more', 'ctl_p_excerpt_more', 999);
        }

        function ctl_ex_len($length) {
            global $post;
            $ctl_options_arr = get_option('cool_timeline_options');
            $ctl_content_length = $ctl_options_arr['content_length'] ? $ctl_options_arr['content_length'] : 100;
            if ($post->post_type == 'cool_timeline' && !is_single()) {
                return $ctl_content_length;
            }
            return $length;
        }

        /*
         * Include this plugin's public JS & CSS files on posts.
         */

        function ctl_load_assets() {
             ctl_common_assets();
           }

        // add dyanmic classes on page body tag
        function ctl_body_class( $c ) {
            global $post;
            if( isset($post->post_content) && has_shortcode( $post->post_content, 'cool-timeline' ) ) {
                $c[] = 'cool-timeline-page';
            }
            return $c;
        }

    }

} // end class


