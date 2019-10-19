<?php
if(exwptl_get_option('exwptl_icon_vers','exwptl_js_css_file_options')!='5'){
	?>
    .wpex-timeline > li .wpex-timeline-icon .fa{font-weight: normal;}
    <?php
}
$wptl_main_color = exwptl_get_option('exwptl_color');
if($wptl_main_color !=''){?>
	.wpextl-loadicon,
    .wpextl-loadicon::before,
	.wpextl-loadicon::after{ border-left-color:<?php echo esc_html($wptl_main_color);?>}
    .wpex-filter > .fa,
    .wpex-endlabel.wpex-loadmore span, .wpex-tltitle.wpex-loadmore span, .wpex-loadmore .loadmore-timeline,
    .wpex-timeline-list.show-icon .wpex-timeline > li:after, .wpex-timeline-list.show-icon .wpex-timeline > li:first-child:before,
    .wpex-timeline-list.show-icon .wpex-timeline.style-center > li .wpex-content-left .wpex-leftdate,
    .wpex-timeline-list.show-icon li .wpex-timeline-icon .fa,
    .wpex .timeline-details .wptl-readmore > a:hover,
    .wpex-spinner > div,
    .wpex.horizontal-timeline .ex_s_lick-prev:hover, .wpex.horizontal-timeline .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-prev:hover,
    .wpex.horizontal-timeline .horizontal-nav li.ex_s_lick-current span.tl-point:before,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.ex_s_lick-current span.tl-point i,
    .timeline-navigation a.btn,
    .timeline-navigation div > a,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li .wpex_point:before,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li.ex_s_lick-current .wpex_point:before,
    .wpex.wpex-horizontal-3.ex-multi-item .horizontal-nav  h2 a,
    .wpex-timeline-list:not(.show-icon) .wptl-feature-name span,
    .wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li span.wpex_point,
    .wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li span.wpex_point,
    .show-wide_img .wpex-timeline > li .wpex-timeline-time span.tll-date,
    .wpex-timeline-list.show-bg.left-tl li .wpex-timeline-label .wpex-content-left .wpex-leftdate,
    .wpex-timeline-list.show-simple:not(.show-simple-bod) ul li .wpex-timeline-time .tll-date,
    .show-box-color .tlb-time,
    .sidebyside-tl.show-classic span.tll-date,
    .wptl-back-to-list a,
    .wpex-timeline > li .wpex-timeline-icon .fa{ background:<?php echo esc_html($wptl_main_color);?>}
    .wpex-timeline-list.show-icon li .wpex-timeline-icon .fa:before,
    .wpex-filter span.active,
    .wpex-timeline-list.show-simple.show-simple-bod ul li .wpex-timeline-time .tll-date,
    .wpex-timeline-list.show-simple .wptl-readmore-center a,
    .wpex.horizontal-timeline .ex_s_lick-prev, .wpex.horizontal-timeline .ex_s_lick-next,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.prev_item:not(.ex_s_lick-current) span.tl-point i,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li span.wpex_point i,
    .wpex-timeline-list.show-clean .wpex-timeline > li .wpex-timeline-label h2,
    .wpex-timeline-list.show-simple li .wpex-timeline-icon .fa:not(.no-icon):before,
    .wpex.horizontal-timeline .extl-hoz-sbs .horizontal-nav li span.tl-point i,
    .show-wide_img.left-tl .wpex-timeline > li .wpex-timeline-icon .fa:not(.no-icon):not(.icon-img):before,
    .wpex-timeline > li .wpex-timeline-time span:last-child{ color:<?php echo esc_html($wptl_main_color);?>}
    .wpex .timeline-details .wptl-readmore > a,
    .wpex.horizontal-timeline .ex_s_lick-prev:hover, .wpex.horizontal-timeline .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-prev:hover,
    .wpex.horizontal-timeline .horizontal-nav li.ex_s_lick-current span.tl-point:before,
    .wpex.horizontal-timeline .ex_s_lick-prev, .wpex.horizontal-timeline .ex_s_lick-next,
    .wpex.horizontal-timeline .timeline-pos-select,
    .wpex.horizontal-timeline .horizontal-nav li.prev_item span.tl-point:before,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.ex_s_lick-current span.tl-point i,
    .wpex.horizontal-timeline.tl-hozsteps .timeline-hr, .wpex.horizontal-timeline.tl-hozsteps .timeline-pos-select,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.prev_item span.tl-point i,
    .wpex-timeline-list.left-tl.show-icon .wptl-feature-name,
    .wpex-timeline-list.show-icon .wptl-feature-name span,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li span.wpex_point i,
    .wpex.horizontal-timeline.ex-multi-item.wpex-horizontal-4 .wpextt_templates .wptl-readmore a,
    .wpex-timeline-list.show-box-color .style-center > li:nth-child(odd) .wpex-timeline-label,
	.wpex-timeline-list.show-box-color .style-center > li .wpex-timeline-label,
	.wpex-timeline-list.show-box-color .style-center > li:nth-child(odd) .wpex-timeline-icon .fa:after,
	.wpex-timeline-list.show-box-color li .wpex-timeline-icon i:after,
    .wpex.horizontal-timeline .extl-hoz-sbs .horizontal-nav li span.tl-point i,
    .wpex.wpex-horizontal-3.ex-multi-item .horizontal-nav .wpextt_templates .wptl-readmore a{border-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex-timeline > li .wpex-timeline-label:before,
    .show-wide_img .wpex-timeline > li .wpex-timeline-time span.tll-date:before, 
    .wpex-timeline > li .wpex-timeline-label:before,
    .wpex-timeline-list.show-wide_img.left-tl .wpex-timeline > li .wpex-timeline-time span.tll-date:before,
    .wpex-timeline-list.show-icon.show-bg .wpex-timeline > li .wpex-timeline-label:after,
    .wpex-timeline-list.show-icon .wpex-timeline.style-center > li .wpex-timeline-label:after
    {border-right-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex-filter span,
    .wpex-timeline > li .wpex-timeline-label{border-left-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex-timeline-list.show-wide_img .wpex-timeline > li .timeline-details,
    .wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li span.wpex_point:after{border-top-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex.wpex-horizontal-3.ex-multi-item .wpex-timeline-label .timeline-details:after{border-bottom-color: <?php echo esc_html($wptl_main_color);?>;}
    @media (min-width: 768px){
        .wpex-timeline.style-center > li:nth-child(odd) .wpex-timeline-label{border-right-color: <?php echo esc_html($wptl_main_color);?>;}
        .show-wide_img .wpex-timeline > li:nth-child(even) .wpex-timeline-time span.tll-date:before,
        .wpex-timeline.style-center > li:nth-child(odd) .wpex-timeline-label:before,
        .wpex-timeline-list.show-icon .style-center > li:nth-child(odd) .wpex-timeline-label:after{border-left-color: <?php echo esc_html($wptl_main_color);?>;}
    }
	<?php 
    $wpex_rtl_mode = exwptl_get_option('exwptl_enable_rtl','exwptl_js_css_file_options');
    if($wpex_rtl_mode=='yes'){?>
        .left-tl:not(.show-icon) .wpex-timeline > li .wpex-timeline-label{border-right-color: <?php echo esc_html($wptl_main_color);?>;}
        .left-tl .wpex-timeline > li .wpex-timeline-label:before{border-left-color: <?php echo esc_html($wptl_main_color);?>;}
        <?php
    }
}
$wptl_fontfamily = exwptl_get_option('exwptl_font_family');
if($wptl_fontfamily !=''){?>
	.wpex-timeline-list,
    .wpex .wptl-excerpt,
    .wpex-single-timeline,
    .glightbox-clean .gslide-desc,
    .extl-hoz-sbd-ct,
	.wpex{font-family: "<?php echo esc_html($wptl_fontfamily);?>", sans-serif;}
<?php 
}

$exwptl_ctcolor = exwptl_get_option('exwptl_ctcolor');
if($exwptl_ctcolor !=''){?>
    .wptl-excerpt,
    .glightbox-clean .gslide-desc,
    .extl-hoz-sbd-ct,
    .wptl-filter-box select,
    .wpex-timeline > li .wpex-timeline-label{color: <?php echo esc_html($exwptl_ctcolor);?>;}
<?php 
}

$wptl_fontsize = exwptl_get_option('exwptl_font_size');
if($wptl_fontsize !=''){?>
    .wpex-timeline-list,
    .wpex .wptl-excerpt,
    .wpex-single-timeline,
	.wpex,
    .wptl-filter-box select,
    .glightbox-clean .gslide-desc,
    .wpex-timeline > li .wpex-timeline-label{font-size:<?php echo esc_html($wptl_fontsize);?>;}
<?php 
}
$exwptl_hdcolor = exwptl_get_option('exwptl_hdcolor');
$wpex_hfont = exwptl_get_option('exwptl_headingfont_family');
if($wpex_hfont !='' || $exwptl_hdcolor!=''){?>
	.wpex-single-timeline h1.tl-title,
	.wpex-timeline-list.show-icon li .wpex-content-left,
    .wpex-timeline-list .wptl-feature-name span,
    .wpex .wpex-dates a, .wpex h2, .wpex h2 a, .wpex .timeline-details h2,
    .wpex-timeline > li .wpex-timeline-time span:last-child,
    .extl-lb .gslide-description.description-right h3.lb-title,
    .wpex-timeline > li .wpex-timeline-label h2 a,
    .wpex.horizontal-timeline .extl-hoz-sbs h2 a, 
    .wpex.horizontal-timeline .wpex-timeline-label h2 a,
    .wpex .timeline-details h2{
        <?php echo $wpex_hfont!='' ? 'font-family: "'.$wpex_hfont.'", sans-serif;' : ''; ?>
        <?php echo $exwptl_hdcolor!='' ? 'color:'.$exwptl_hdcolor.';' : ''; ?>
    }
<?php 
}

$wpex_hfontsize = exwptl_get_option('exwptl_headingfont_size');
if($wpex_hfontsize !=''){?>
	.wpex-single-timeline h1.tl-title,
    .wpex-timeline-list .wptl-feature-name span,
    .wpex-timeline > li .wpex-timeline-time span:last-child,
    .extl-lb .gslide-description.description-right h3.lb-title,
	.wpex h2, .wpex h2 a, .wpex .timeline-details h2, .wpex .timeline-details h2{font-size: <?php echo esc_html($wpex_hfontsize);?>;}
<?php 
}

$wpex_metafont = exwptl_get_option('exwptl_metafont_family');
if($wpex_metafont !=''){?>
	.wptl-more-meta span a, .wptl-more-meta span,
	.wpex-endlabel.wpex-loadmore span, .wpex-tltitle.wpex-loadmore span, .wpex-loadmore .loadmore-timeline,
    .wpex .timeline-details .wptl-readmore > a,
    .wpex-timeline > li .wpex-timeline-time span.info-h,
	li .wptl-readmore-center > a{font-family: "<?php echo esc_html($wpex_metafont);?>", sans-serif;}
<?php 
}
$wpex_matafontsize = exwptl_get_option('exwptl_metafont_size');
if($wpex_matafontsize !=''){?>
	.wptl-more-meta span a, .wptl-more-meta span,
	.wpex-endlabel.wpex-loadmore span, .wpex-tltitle.wpex-loadmore span, .wpex-loadmore .loadmore-timeline,
    .wpex-timeline > li .wpex-timeline-time span.info-h,
    .wpex .timeline-details .wptl-readmore > a,
	li .wptl-readmore-center > a{font-size: <?php echo esc_html($wpex_matafontsize);?>;}
<?php 
}
$wpex_disable_link = exwptl_get_option('exwptl_disable_single','exwptl_advanced_options');
if($wpex_disable_link=='yes'){?>
	.timeline-media > a{display: inline-block; box-shadow: none;}
    .wpex-timeline > li .wpex-timeline-label h2 a,
    .wpex-timeline-icon > a,
    .wpex.horizontal-timeline .wpex-timeline-label h2 a,
    .timeline-media > a, time.wpex-timeline-time > a, .wpex-leftdate + a, a.img-left { pointer-events: none;} .wptl-readmore-center, .wptl-readmore { display: none !important;} 
    
    .wpex-timeline-list.left-tl.wptl-lightbox .wpex-leftdate + a,
    .wpex-timeline-list.wptl-lightbox a.img-left {
        pointer-events: auto;
    }
    <?php
}
//.wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.prev_item:not(.ex_s_lick-current) a i {
//    border-color: #EEEEEE;
//    color: #7d7d7d;
//}

$wpex_custom_css = exwptl_get_option('exwptl_custom_css','exwptl_custom_code_options');
if($wpex_custom_css!=''){
	echo $wpex_custom_css;
}