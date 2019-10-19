var Wptl_El_Sp = {
    timelines_hoz : function() {
		jQuery(window).resize(function() {
			jQuery('.horizontal-timeline:not(.ex-multi-item)').each(function(){
				var $this = jQuery(this);
				setTimeout(function() {
					var id =  $this.data('id');
					var $slide = jQuery('#'+id+' ul.horizontal-nav li.ex_s_lick-current');
					var crrleft = $slide.offset();
					var ct_left = jQuery('#'+id+' .horizontal-nav').offset();
					var ct_width = $slide.width();
					var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
					jQuery('#'+id+' .timeline-pos-select').css( 'width',ps_width);
				}, 200);
			});
		});
		jQuery('.horizontal-timeline:not(.ex-multi-item)').each(function(){
			if(jQuery(this).hasClass('hoz-at')){ return;}
			else{ jQuery(this).addClass('hoz-at')}
			var $this = jQuery(this);
			if($this.hasClass('tl-hozsteps')){center_mode = false}
			var style = $this.data('layout');
			var id =  $this.data('id');
			var count_it =  $this.data('count');
			var slidesshow =  $this.data('slidesshow');
			if(slidesshow==''){ slidesshow = 3;}
			var arrowpos =  $this.data('arrowpos');
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var auto_speed = $this.data('speed');
			var rtl_mode = $this.data('rtl');
			
			var start_on =  $this.data('start_on') > 0 ? $this.data('start_on') : 0;
			if($this.data('infinite')=='0'){
				var infinite = 0;
			}else{
				var infinite =  $this.data('infinite') == 'yes' || $this.data('infinite') == '1' ? true : false;
			}
			
			var center_mode = $this.data('center');
			
			jQuery('#'+id+' .horizontal-content')
			
			.on('beforeChange', function(event, EX_ex_s_lick, currentSlide, nextSlide){
				if(infinite==1 || infinite==0){
					$indx = EX_ex_s_lick.currentSlide;
					var $slide = jQuery('#'+id+' ul.horizontal-nav li[data-ex_s_lick-index="'+$indx+'"]');
					$slide.prevAll().addClass('prev_item');
					$slide.removeClass('prev_item');
					$slide.nextAll().removeClass('prev_item');
				}else{
					$li_curr = nextSlide + 1;
					jQuery('#'+id+' .horizontal-nav li.ex_s_lick-slide:nth-child('+$li_curr+')').prevAll().addClass('prev_item');
					jQuery('#'+id+' .horizontal-nav li.ex_s_lick-slide:nth-child('+$li_curr+')').nextAll().removeClass('prev_item');
				}
			  }
			)
			.on('afterChange', function(event, EX_ex_s_lick, direction,nextSlide){
				if(infinite==1){
					$indx = EX_ex_s_lick.currentSlide;
					var $slide = jQuery('#'+id+' ul.horizontal-nav li[data-ex_s_lick-index="'+$indx+'"]');
					if(count_it==slidesshow){
						var crrleft = $slide.offset();
						var ct_left = jQuery('#'+id+' .horizontal-nav').offset();
						var ct_width = $slide.width();
						var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
						jQuery('#'+id+' .timeline-pos-select').css( 'width',ps_width);
					}
				}else{
					$indx = EX_ex_s_lick.currentSlide;
					if($indx==0 && infinite== 0){
						jQuery('#'+id).resize()
					}
					for (var i = 0; i < EX_ex_s_lick.$slides.length; i++)
					{
						var $slide = jQuery(EX_ex_s_lick.$slides[i]);
						if ($slide.hasClass('ex_s_lick-current')) {
							/* update width */
							$pos_c = i + 1;
							//var $slide = jQuery(EX_ex_s_lick.$slides[i]);
							var $slide = jQuery('#'+id+' ul.horizontal-nav li:nth-child('+$pos_c+')');
							var crrleft = $slide.offset();
							var ct_left = jQuery('#'+id+' .horizontal-nav').offset();
							var ct_width = $slide.width();
							var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
							jQuery('#'+id+' .timeline-pos-select').css( 'width',ps_width);
							//$slide.removeClass('prev_item');
							//$slide.nextAll().removeClass('prev_item');
							break;
						}
					}
				}
				$slide.prevAll().addClass('prev_item');
				$slide.removeClass('prev_item');
				$slide.nextAll().removeClass('prev_item');
			  }
			)
			
			.EX_ex_s_lick({
				infinite: infinite,
				speed:auto_speed!='' ? auto_speed : 250,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight:true,
				autoplay: auto_play==1 && count_it <= slidesshow ? true : false,
				arrows: arrowpos !='top' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',
				fade: true,
				asNavFor: '#'+id+' .horizontal-nav',
			});
			jQuery('#'+id+' .horizontal-nav')
			.on('init', function(event, EX_ex_s_lick, direction){
				if(start_on!='' && jQuery.isNumeric(start_on)){
					var $slide = jQuery(EX_ex_s_lick.$slides[start_on]);
					$slide.addClass('ex_s_lick-current');
					jQuery(EX_ex_s_lick.$slides[0]).removeClass('ex_s_lick-current');
					$slide.nextAll().removeClass('prev_item');
					$slide.prevAll().addClass('prev_item');
				}else{
					var $slide = jQuery(EX_ex_s_lick.$slides[0]);
				}
				//console.log($slide);
				if ($slide.hasClass('ex_s_lick-current')) {
					var crrleft = $slide.offset();
					var ct_left = jQuery('#'+id+' .horizontal-nav').offset();
					var ct_width = $slide.width();
					var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
				}
				jQuery('#'+id+' .timeline-pos-select').css( 'width',ps_width);
				if(infinite==1 || infinite==0){
					$indx = EX_ex_s_lick.currentSlide;
					var $slide = jQuery('#'+id+' ul.horizontal-nav li[data-ex_s_lick-index="'+$indx+'"]');
					$slide.prevAll().addClass('prev_item');
					$slide.removeClass('prev_item');
					$slide.nextAll().removeClass('prev_item');
				}
			})
			.EX_ex_s_lick({
				infinite: infinite,
				speed:auto_speed!='' ? auto_speed : 250,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',	
				slidesToShow: slidesshow,
				slidesToScroll: 1,
				asNavFor: '#'+id+' .horizontal-content',
				dots: false,
				autoplay: auto_play==1 ? true : false,
				autoplaySpeed: auto_speed!='' ? auto_speed : 3000,
				arrows: arrowpos =='top' ? true : false,
				centerMode: center_mode !='left' ? true : false,
				focusOnSelect: true,
				responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: slidesshow,
						slidesToScroll: 1,
					  }
					},
					{
					  breakpoint: 767,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
				  ]
				
			});
		});
        return this;
    },
	/*--Hoz multi--*/
	timelines_hoz_multi : function() {
		jQuery('.horizontal-timeline.ex-multi-item').each(function(){
			var $this = jQuery(this);
			if(jQuery(this).hasClass('hoz-at')){ return;}
			else{ jQuery(this).addClass('hoz-at')}
			var id =  $this.data('id');
			var slidesshow =  $this.data('slidesshow');
			if(slidesshow==''){ slidesshow = 3;}
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var auto_speed = $this.data('speed');
			var rtl_mode = $this.data('rtl');
			var start_on =  $this.data('start_on') > 0 ? $this.data('start_on') : 0;
			if($this.data('infinite')=='0'){
				var infinite = 0;
			}else{
				var infinite =  $this.data('infinite') == 'yes' || $this.data('infinite') == '1' ? true : false;
			}
			$resps = [{
			  breakpoint: 1024,
			  settings: {
				slidesToShow: slidesshow,
				slidesToScroll: 1,
			  }
			},
			{
			  breakpoint: 767,
			  settings: {
				slidesToShow: jQuery('#'+id+' .horizontal-sl-2').length ? 2 : 1,
				slidesToScroll: 1
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: jQuery('#'+id+' .horizontal-sl-2').length ? 2 : 1,
				slidesToScroll: 1
			  }
			}];
			jQuery('#'+id+' .horizontal-nav').EX_ex_s_lick({
				infinite: infinite,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',	
				slidesToShow: slidesshow,
				slidesToScroll: 1,
				dots: false,
				autoplay: auto_play==1 ? true : false,
				autoplaySpeed: auto_speed!='' ? auto_speed : 3000,
				arrows: true,
				centerMode:  false,
				focusOnSelect: true,
				adaptiveHeight: true,
				asNavFor: jQuery('#'+id+' .horizontal-sl-2').length ? '#'+id+' .horizontal-sl-2' : '',
				responsive: $resps
				
			});
			if(jQuery('#'+id+' .horizontal-sl-2').length){
				jQuery('#'+id+' .horizontal-sl-2').EX_ex_s_lick({
					infinite: infinite,
					initialSlide:start_on,
					rtl: rtl_mode =='yes' ? true : false,
					slidesToShow: slidesshow,
					slidesToScroll: 1,
					dots: false,
					arrows: false,
					centerMode:  false,
					focusOnSelect: true,
					adaptiveHeight: true,
					asNavFor: '#'+id+' .extl-nav',
					responsive: $resps
				});
			}
		});
		return this;
	}
	
};
(function($){

	$(document).ready(function($) {
		function exwptl_lightbox(){
			if(!$('.extllightbox').length){ return;}
			$('.extllightbox').each(function(){
				var $class = $(this).data('class');
				var lightbox = GLightbox();
				var lightboxDescription = GLightbox({
				  selector: $class,
				  moreLength:0,
				  touchNavigation: true,
				  type:'inline',
				  lightboxHtml : '<div id="glightbox-body" class="extl-lb glightbox-container">\
				      <div class="gloader visible"></div>\
				      <div class="goverlay"></div>\
				      <div class="gcontainer">\
				         <div id="glightbox-slider" class="gslider"></div>\
				         <a class="gnext"></a>\
				         <a class="gprev"></a>\
				         <a class="gclose"></a>\
				      </div>\
				  </div>',
				});
			});
			return false;
		};
		exwptl_lightbox();
		function wpex_isScrolledInto_View(elem){ //in visible
			var docViewTop = jQuery(window).scrollTop();
			var docViewBottom = docViewTop + jQuery(window).height();
			var elemTop = jQuery(elem).offset().top;
			var elemBottom = elemTop + jQuery(elem).height();
			return ((elemBottom <= docViewBottom + 200) && (elemTop >= docViewTop));
		}
		function wpex_infinite_scroll(){
			$('.wpex-timeline-list.wpex-infinite').each(function(){
				var Id_tm = jQuery(this).attr("id");
				if(!$("#"+Id_tm+" .wpex-loadmore a.loadmore-timeline").length ){
					return;
				}
				var $loadmore = $("#"+Id_tm+" .wpex-loadmore a.loadmore-timeline");
				if (wpex_isScrolledInto_View("#"+Id_tm+" .wpex-loadmore a.loadmore-timeline") && !$loadmore.hasClass('loading') && !$("#"+Id_tm+" .wpex-loadmore").hasClass('hidden')) {
					$loadmore.trigger('click');
				}
			});
		}
		function wpex_timeline_gellary(){
			if($('.extl-gallery-carousel').length){
				var rtl_mode = $('.wpex-timeline-list').data('rtl');
				$('.extl-gallery-carousel:not(.glled)').EX_ex_s_lick({
					dots: true,
					slidesToShow: 1,
					infinite: true,
					speed: 500,
					fade: true,
					cssEase: 'linear',
					adaptiveHeight: true,
					arrows: true,
					prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
					nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',
					rtl:rtl_mode =='yes' ? true : false,
				});
				$('.extl-gallery-carousel').addClass('glled');
				$('.wpex-timeline-list:not(.wptl-lightbox) .extl-gallery-carousel').on('click',function(e) {
			        e.stopPropagation();
			    });
			}
		};
		wpex_timeline_gellary();
		function wpex_timeline_scroll(){
			var $this = $(this);
			$(".wpex-timeline-list").each(function(){
				var Id_tm = jQuery(this).attr("id");
				var this_tl = $(this);
				var $tl_top = this_tl.offset().top;
				var $tl_end = $tl_top + this_tl.height();
				$tl_top =  $tl_top -200;
				$tl_end =  $tl_end;
				if (($(document).scrollTop() >= $tl_top) && ($(document).scrollTop() <= $tl_end)) {
					$("#"+Id_tm+" .wpex-filter").addClass('active');
				}else{
					$("#"+Id_tm+" .wpex-filter").removeClass('active');
				}
				var windowHeight = $(window).height(),
				gridTop = windowHeight * .3;
				var scrollTop = $this.scrollTop();
				$("#"+Id_tm+" ul li").each(function(){
					var ftid = $(this).data('id');
					var thisTop = $(this).offset().top - $(window).scrollTop();
					var thisBt =  thisTop + $(this).height(); 
					if (thisTop >= gridTop) {
						$('#'+ftid).removeClass('active');
					} else {
						$('#'+ftid).addClass('active');
					}
					/*-- If animation enable --*/
					var animations  		= $("#"+Id_tm).data('animations');
					if((animations !='') && (thisTop < windowHeight * .7)){
						$(this).children(":first").removeClass('scroll-effect').addClass( animations+' animated');
						if($(this).find('.extl-gallery-carousel:not(.glled)').length){
							$(this).find('.extl-gallery-carousel:not(.glled)').EX_ex_s_lick({
								dots: true,
								slidesToShow: 1,
								infinite: true,
								speed: 500,
								fade: true,
								cssEase: 'linear',
								adaptiveHeight: true,
								arrows: true,
								prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
								nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',
								rtl:false,
							});
							$(this).find('.extl-gallery-carousel').addClass('glled');
						}
					}
					/*var topDistance = $(this).offset().top;
					var ftid = $(this).data('id');
					var btDistance = topDistance + $(this).height();
					if ( (scrollTop >= topDistance) && ( scrollTop <= btDistance)) {
						$('#'+ftid).addClass('active');
					}else {
						$('#'+ftid).removeClass('active');
					}*/
				});
			});
		};
		$(".wpex-filter:not(.year-ft)").on('click', 'div span',function() {
			var contenId = jQuery(this).attr("id");
			var windowHeight = $(window).height();
			$('html,body').animate({
				scrollTop: $("."+contenId).offset().top - windowHeight * .2},
				'slow');
		});
		if($(".wpex-timeline-list").length ){
			wpex_timeline_scroll();
			wpex_infinite_scroll()
			$(document).scroll(function() {
				wpex_timeline_scroll();
				wpex_infinite_scroll()
			});
		}
		/*--year filter--*/
		$(".wpex-filter.year-ft").on('click', 'div span',function() {
			var $this_click = $(this);
			var timelineId = jQuery(this).data('id');
			$('#timeline-'+timelineId).addClass("loading no-more");
			var id_crsc = 'timeline-'+timelineId;
			$('#'+id_crsc+' .wpex-filter.year-ft div span').removeClass("active");
			$this_click.addClass('active');
			var tax = jQuery(this).data('value');
			var mult ='';
			if($('#'+id_crsc+' .wpex-taxonomy-filter li a.active').length ){
				mult = $('#'+id_crsc+' .wpex-taxonomy-filter li a.active').data('value');
			}
			var ajax_url  		= $('#timeline-'+timelineId+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#timeline-'+timelineId+' input[name=param_shortcode]').val();
			$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
			$('#timeline-'+timelineId+' ul.wpex-timeline li').fadeOut(300, function() { $(this).remove(); });
			var param = {
				action: 'wpex_filter_year',
				taxonomy_id : tax,
				mult : mult,
				param_shortcode: param_shortcode,
			};
			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'json',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data != ''){ 
							var $_container = $('#'+id_crsc+' ul.wpex');
							$_container.html('');
							if(data.html_content != ''){ 
								$('#'+id_crsc+' .wpex-tltitle.wpex-loadmore').prepend('<span class="yft">'+$this_click.html()+'</span>');
								$('#'+id_crsc+' .wpex-loadmore:not(.lbt)').removeClass("hidden");
								$_container.append(data.html_content);
							}else{
								$('#'+id_crsc+' .wpex-loadmore').addClass("hidden");
								$_container.append('<h2 style="text-align: center;">'+data.massage+'</h2>');
							}
							setTimeout(function(){ 
								$('#'+id_crsc+' ul.wpex > li').addClass("active");
							}, 200);
							$('#'+id_crsc).removeClass("loading");
						}
						wpex_timeline_scroll();
						wpex_infinite_scroll();
						wpex_timeline_gellary();
						$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
					}else{$('.row.loadmore').html('error');}
				}
			});
			return false;
		});
		/*--Taxonomy filter--*/
		function wpex_taxonomy_filter(id_crsc,tax){
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#'+id_crsc+' input[name=param_shortcode]').val();
			$('#'+id_crsc).addClass("loading");
			$('#'+id_crsc+' ul.wpex-timeline li').fadeOut(300, function() { $(this).remove(); });
			$('#'+id_crsc+' input[name=num_page_uu]').val(1);
			$('#'+id_crsc+' input[name=current_page]').val(1);
			$('#'+id_crsc+' .wpex-tltitle.wpex-loadmore .yft').remove();
			var param = {
				action: 'wpex_filter_taxonomy',
				taxonomy_id : tax,
				param_shortcode: param_shortcode,
			};
			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'json',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data == ''){ 
							$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
						}
						else{
							var $_container = $('#'+id_crsc+' ul.wpex');
							$_container.html('');
							$_container.append(data.html_content);
							$('#'+id_crsc+' .wpex-filter:not(.year-ft) div span').remove();
							$('#'+id_crsc+' .wpex-filter:not(.year-ft) div').append(data.date);
							setTimeout(function(){ 
								$('#'+id_crsc+' ul.wpex > li').addClass("active");
							}, 200);
							$('#'+id_crsc).removeClass("loading");
							$('#'+id_crsc+' input[name=param_query]').val(JSON.stringify(data.data_query));
						}
						if(data.more != 1){
							$('#'+id_crsc).addClass("no-more");
							$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
						}else{
							$('#'+id_crsc).removeClass("no-more");
						}
						exwptl_lightbox();
						wpex_timeline_scroll();
						wpex_timeline_gellary();
						$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
					}else{$('.row.loadmore').html('error');}
				}
			});
		}
		$(".wpex-taxonomy-filter").on('click', 'li',function() {
			var $this_click = $(this);
			var id_crsc = 'timeline-'+jQuery(this).data('id');
			$('#'+id_crsc+' .wpex-taxonomy-filter li').removeClass("active");
			$('#'+id_crsc+' .wpex-taxonomy-filter li').removeClass("crr-at");
			$('#'+id_crsc+' .wpex-filter.year-ft div span').removeClass("active");
			$('#'+id_crsc+' .wpex-loadmore').removeClass("hidden");
			$this_click.addClass('active crr-at');
			$this_click.parents('li').addClass('active');
			var tax = jQuery(this).data('value');
			$("#"+id_crsc+" .wpex-taxonomy-select option[value='" + tax + "']").attr("selected","selected");
			wpex_taxonomy_filter(id_crsc,tax);
			return false;
		});
		$('.wptl-filter-box select[name=wpex_taxonomy]').on('change',function(event) {
			event.preventDefault();
			var $this_click = $(this);
			var id_crsc = 'timeline-'+jQuery(this).find(':selected').data('id');
			var tax = jQuery(this).find(':selected').val();
			$('#'+id_crsc+' .wpex-taxonomy-filter li').removeClass("active");
			$("#"+id_crsc+" .wpex-taxonomy-filter li[data-value='" + tax + "']").addClass('active');
			$("#"+id_crsc+" .wpex-taxonomy-filter li[data-value='" + tax + "']").parents('li').addClass('active');
			wpex_taxonomy_filter(id_crsc,tax);
			return false;
		});
		/*-loadmore-*/
		$('.loadmore-timeline').on('click',function() {
			var $this_click = $(this);
			$this_click.addClass('disable-click');
			var id_crsc  		= $this_click.data('id');
			var n_page = $('#'+id_crsc+' input[name=num_page_uu]').val();
			$('#'+id_crsc+' .loadmore-timeline').addClass("loading");
			var param_query  		= $('#'+id_crsc+' input[name=param_query]').val();
			var page  		= $('#'+id_crsc+' input[name=current_page]').val();
			var num_page  		= $('#'+id_crsc+' input[name=num_page]').val();
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#'+id_crsc+' input[name=param_shortcode]').val();
			var crr_y = '';
			var tl_language  		= $this_click.data('tl_language');
			if($('#'+id_crsc+' li:last-child > input.crr-year').length){
				crr_y = $('#'+id_crsc+' li:last-child > input.crr-year').val();
			}
				var param = {
					action: 'wpex_loadmore_timeline',
					param_query: param_query,
					page: page*1+1,
					param_shortcode: param_shortcode,
					param_year: crr_y,
					lang: tl_language,
				};
	
				$.ajax({
					type: "post",
					url: ajax_url,
					dataType: 'json',
					data: (param),
					success: function(data){
						if(data != '0')
						{
							n_page = n_page*1+1;
							$('#'+id_crsc+' input[name=num_page_uu]').val(n_page)
							if(data.html_content == ''){ 
								$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
							}
							else{
								$('#'+id_crsc+' input[name=current_page]').val(page*1+1);
								var $_container = $('#'+id_crsc+' ul.wpex');
								$_container.append(data.html_content);
								$('#'+id_crsc+' .wpex-filter:not(.year-ft) div').append(data.date);
								setTimeout(function(){ 
									$('#'+id_crsc+' ul.wpex > li').addClass("active");
								}, 200);
							}
							if(n_page == num_page){
								$('#'+id_crsc).addClass("no-more");
								$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
							}
							wpex_timeline_scroll();
							exwptl_lightbox();
							wpex_timeline_gellary();
							$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
							$('#'+id_crsc+' .loadmore-timeline').removeClass("loading");
							$this_click.removeClass('disable-click');
						}else{$('.row.loadmore').html('error');}
					}
				});
			return false;	
		});
		/*----*/
		$(".wpex-timeline-list .wpex-filter").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
		$(".wpex-timeline-list .wpex-filter > .fa").on('click',function() {
			var id_crsc  		= $(this).data('id');
			if(!$('#'+id_crsc+' .wpex-filter').hasClass('show-filter')){
				$('#'+id_crsc+' .wpex-filter').addClass('show-filter');
				$('#'+id_crsc+' .wpex-filter').css("right", 0);
			}else{
				$('#'+id_crsc+' .wpex-filter').removeClass('show-filter');
				$('#'+id_crsc+' .wpex-filter').css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
			}
		});
		/*--Light box--*/
		wpex_timeline_lightbox();
		function wpex_timeline_lightbox(){
			$('.wpex-timeline-list').each(function(){
				var $this = $(this);
				var id =  $this.attr("id");
				if($($this).hasClass('wptl-lightbox')){
					if($('#'+id).hasClass('left-tl') && $('#'+id).hasClass('show-icon') && !$('#'+id).hasClass('show-box-color') ){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .wpex-content-left > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('show-clean')){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: ' .wpex-timeline-label > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('show-wide_img') || $('#'+id).hasClass('show-simple-bod') || $('#'+id).hasClass('show-box-color')){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: ' .timeline-details > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('left-tl') || ($('#'+id).hasClass('center-tl') && !$('#'+id).hasClass('show-icon') && !$('#'+id).hasClass('sidebyside-tl'))){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .wpex-timeline-time > a',
							useHistoryApi: true
						});
					}else{
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .timeline-details > a',
							useHistoryApi: true
						});
					}
					/*-support gallery-*/
					$('#'+id+' ul.wpex-timeline').slickLightbox({
						itemSelector: '> li .extl-gallery-carousel a',
						useHistoryApi: true
					});
				}
			});
		}
		/*--Slider timeline--*/
		Wptl_El_Sp.timelines_hoz_multi();
		$('.horizontal-timeline:not(.ex-multi-item) ul.horizontal-nav li').on('click',function() {
			$(this).prevAll().addClass('prev_item');
			$(this).nextAll().removeClass('prev_item');
		});
		Wptl_El_Sp.timelines_hoz();
	});
}(jQuery));