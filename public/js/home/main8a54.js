(function ( $ ) {

	/*-------------------------------------
	Local Navigation
	-------------------------------------*/

	//if($('body').hasClass('page-id-815045345')){
        if ( $( ".executive-block" ).length ) {
		createLocalNav();
	}

	function createLocalNav(){

		$('nav.local .toolbar').html($('nav.local li:first-child a').html());

		// Setup nav

		$('<nav class="local"><div class="container"><div class="toolbar" /><div class="nav-container"><ul /></div /></nav>').insertAfter('.module__hero');

		$('.module__lead-info').each(function(){
			$('nav.local ul').append('<li><a href="#">' + $(this).find('header h2').html() + '</a></li>');
		});

		$('nav.local .toolbar').html($('nav.local ul li:first-child a').html());

		$('nav.local ul li:first-child').addClass('active');

		// Sticky functionality

		$(window).on('scroll resize', function(){
			if($(window).scrollTop() > $('nav.local').offset().top){
				if(!$('nav.local.clone').length){
					$('nav.local').clone().addClass('clone').appendTo('.main-wrapper');
				}
			}else{
				if($('nav.local.clone').length){
					$('nav.local.clone').remove();
				}
			}
		});

		// Mobile toolbar Click

		$('.main-wrapper').on('click', 'nav.local .toolbar', toolbarClick);

		function toolbarClick(e){
			e.preventDefault();

			if(!$('nav.local .toolbar').hasClass('active')){
				
				// Open Toolbar

				$('nav.local .toolbar').addClass('active');
				$('nav.local .nav-container').animate({
					height: $('nav.local .nav-container > ul').outerHeight()
				}, 500, "easeInOutExpo");
			}else{

				// Close Toolbar

				closeLocalNav();
			}
		}

		function closeLocalNav(){
			if($('nav.local .toolbar').hasClass('active')){
				$('nav.local .toolbar').removeClass('active');
				$('nav.local .nav-container').animate({
					height: 0
				}, 500, "easeInOutExpo", function(){
					$('nav.local .nav-container').attr('style', '');
				});
			}
		}

		// Nav item click

		$('.main-wrapper').on('click', 'nav.local a', function(e){
			e.preventDefault();

			closeLocalNav();

			var i = $(this).parent().index(),
				contentPosition = $('body').find('.module__lead-info').eq(i).position().top - $('nav.local.clone').height();
			
			$('html, body').animate({
				scrollTop: contentPosition
			}, 1000, "easeInOutExpo");
		});
	}

	// Highlight nav on scroll

	$('.module__lead-info').each(function(){
		var $content = $(this);

		$(window).on('scroll resize', function(){
			var contentHeight = $content.position().top + $content.height() + $content.next().height() - $('nav.local').height();
			
			if($(window).scrollTop() > $content.position().top - $('nav.local').height() - 1 && $(window).scrollTop() < contentHeight){
				var i = $('body').find('.module__lead-info').index($content);

				$('nav.local .toolbar').html($('nav.local li').eq(i).find('a').html());

				if(!$('nav.local li').eq(i).hasClass('active')){
					$('nav.local li.active').removeClass('active');
					$('nav.local li').eq(i).add($('nav.local.clone li').eq(i)).addClass('active');
				}
			}
		});
	});

	/*-------------------------------------
	Global
	-------------------------------------*/

	$.Window = $(window);
	var $mobileBreakpoint = 767,
		$windowSize,
		$isMobile = false;

	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) $isMobile = true;

	function sizeCheck(){
		if($.Window.width() <= $mobileBreakpoint){
			$windowSize = 'mobile';
		}else{
			$windowSize = 'desktop';
		}
	}

	$(document).ready(function() {
		sizeCheck();
	});

	$.Window.bind("resize", function() {
		sizeCheck();
	});

	/*-------------------------------------
	Table Jawn
	-------------------------------------*/
	
	$.fn.tableJawn = function(){
		var $stage = $(this),
			$row = $stage.find('tr');
		
		function tableWrap(){
			if($stage.outerWidth() > $stage.closest('article').width()){
				if(!$stage.parent('.mobile-table').length){
					$stage.wrap('<div class="mobile-table" />')
					$stage.parent().after('<div class="table-instructions">Scroll to view entire table</div>');
				}
			}else{
				if($stage.parent('.mobile-table').length){
					$stage.parent().next().remove();
					$stage.unwrap();
				}
			}
		}

		$.Window.bind("resize load", tableWrap);
	};

	$('table').each(function(){
		$(this).tableJawn();
	});

	/*-------------------------------------
	Sticky Footer
	-------------------------------------*/

	function stickyFooter(){
		if($windowSize == 'desktop') {
			var bodyHeight = $("body").height(),
				vwptHeight = $(window).height();
			if (vwptHeight > bodyHeight) {
				if(!$("footer.main").hasClass('sticky')){
					$("footer.main").addClass('sticky');
				}
			}else{
				$("footer.main").removeClass('sticky');
			}
		}else{
			$("footer.main").removeClass('sticky');
		}
	}

	if(!$('body').is('.page-template-page-all-case-studies, .tax-news-type, .page-template-page-fleet-wire, .page-template-page-fleet-safety')){
		if($('body').find('.articles-desktop').length == 0){
			$.Window.bind("load resize", function() {
				stickyFooter();
			});
		}
	}

	/*-------------------------------------
	BTT
	-------------------------------------*/

	$('body').append('<span class="btt-wrap"><span class="btt"></span></span>');

	$(".btt").click(function(e){
		e.preventDefault();
		$('html, body').animate({
	        scrollTop: 0
	    }, 500, "easeInOutExpo");
	});

	var bottom_of_window = $(window).scrollTop() + $(window).height();

	$.Window.bind("scroll load", function() {
	 	if($(window).scrollTop() > $(window).height()){
	 		
	 		if(!$(".btt-wrap").hasClass('active')){
				$(".btt-wrap").addClass('active');
	 			$(".btt-wrap").css({'display':'block', 'opacity':0});
		 		$(".btt-wrap").animate({
			        opacity: 1
			    }, 500, "easeInOutExpo");
	 		}
	 	
	 	}else{
	 		if($(".btt-wrap").hasClass('active')){
		 		$(".btt-wrap").removeClass('active');
		 		$(".btt-wrap").animate({
			        opacity: 0
			    }, 500, "easeInOutExpo", function(){
			    	$(".btt-wrap").css('display','none');
			    });
		 	}
	 	}
    });	 

	/*-------------------------------------
	Back to top functionality
	-------------------------------------*/

	$(".jump-top").each(function(){
		$(this).before('<div class="jump-space"></div>');
		$('.jump-space').height($(this).outerHeight());
		$(this).css('margin-top', -$('.jump-space').height());
	});

	$(".jump-top a").click(function(e){
		e.preventDefault();
		$('html, body').animate({
	        scrollTop: 0
	    }, 500, "easeInOutExpo");
	});

	/*-------------------------------------
	Fade in while scrolling
	-------------------------------------*/

	// if($('section.fade-in:not(.module__hero)').length){
	// 	function fader(){
	// 		if ($isMobile == false) {
	// 	        $('section.fade-in').each( function(i){        
	// 	            var bottom_of_object = $(this).position().top + ($(window).height()/2);
	// 	            var bottom_of_window = $(window).scrollTop() + $(window).height();	            
	// 	            bottom_of_window = bottom_of_window+200;  
	// 	            if(bottom_of_window > bottom_of_object ){
	// 	                $(this).addClass('hello');
	// 	            }
	// 	        });
	// 	    }
	// 	}
	// 	$.Window.bind("scroll load", function() {
	// 	 	fader();
	//     });
	// }

	/*-------------------------------------
	Flip two-column-item layouts on mobile
	-------------------------------------*/

	if($('.module__two-column.magazine').length){
		$.Window.bind("load resize", function() {
			$('.magazine .two-column-text').each(function(){
				var $stage = $(this);
				$stage.attr('style', '');
			});

		 	if($windowSize == 'mobile') {
		 		if(!$('.module__two-column.magazine').hasClass('mobile')){
		 			$('.module__two-column.magazine').addClass('mobile');
			 		$('.module__two-column.magazine > .clearfix').each(function(){
			 			var $stage = $(this);
			 			if(!$stage.hasClass('right')){
			 				$stage.find('.two-column-item:not(.img)').insertAfter($stage.find('.two-column-item.img'));
			 			}
			 		});
			 	}
		 	}else{
		 		$('.magazine .two-column-text').each(function(){
					var $stage = $(this);
					$stage.css('margin-top', ($stage.parent().parent().find('.two-column-item.img').outerHeight(true) - $stage.height())/2);
				});

		 		if($('.module__two-column.magazine').hasClass('mobile')){
			 		$('.module__two-column.magazine').removeClass('mobile');
			 		$('.module__two-column.magazine > .clearfix').each(function(){
			 			var $stage = $(this);
			 			if(!$stage.hasClass('right')){
			 				$stage.find('.two-column-item:not(.img)').insertBefore($stage.find('.two-column-item.img'));
			 			}
			 		});
			 	}
			}
		});
	}
	
	/*-------------------------------------
	Add external link icon to Web Tools
	-------------------------------------*/
	
	if($('.utilities-webtools li.external').length){
		$('.utilities-webtools li.external').each(function(){
			$('<span></span>').appendTo($(this).find('a'));
		});
	}
	
	/*-------------------------------------
	Video Page
	-------------------------------------*/

	$.fn.videoGallery = function(e){
		var $stage = $(this),
			$container = $stage.find('.video-page-container'),
			$mp4 = $stage.data('video-mp4'),
			$webm = $stage.data('video-webm'),
			$ogv = $stage.data('video-ogv'),
			$poster = $stage.data('poster'),
			mobileVid,
			$count = e;

		$.Window.bind("load", function() {
			if ($isMobile == true && $windowSize == 'mobile') {

				/* Mobile */
				
				var thisVid = 'vid-'+$count;
				$('<video id="'+thisVid+'" poster="'+$poster+'" muted="muted" controls preload="auto" class="video-js vjs-default-skin"><source src="'+$mp4+'"  type="video/mp4"><source src="'+$ogv+'" type="video/ogg"><source src="'+$webm+'"  type="video/webm"></video>').prependTo($stage.find('.video-page-container'));
				$stage.find('p a').remove();
				$stage.find('video').css('height', 'auto');

			}else{

				/* Desktop */

				$stage.click(function(e) {
					e.preventDefault();

					$('body').addClass('stop-scrolling');

					$('<div class="video-player"><div class="close"></div><div class="next-video"><div><div class="play"><div class="icon"><div id="progressCircle"></div></div></div><div class="title"><div class="next">Next video</div><div class="description"></div></div></div></div><video id="div_video" poster="'+$poster+'" controls preload="auto" class="video-js vjs-default-skin"><source src="'+$mp4+'"  type="video/mp4"><source src="'+$ogv+'" type="video/ogg"><source src="'+$webm+'"  type="video/webm"></video></div>').appendTo($container);

					var bar = new ProgressBar.Circle(progressCircle, {
						strokeWidth: 4,
						duration: 10000,
						color: '#21c3f1',
						trailWidth: 0,
						svgStyle: null
					});

					var $player = $stage.find('.video-player');

					$left = $stage.offset().left;
					$top = $stage.offset().top;
					$width = $stage.width();

					var total = $stage.parent().find('> article').length,
						current = $stage.parent().find($stage).index()+1,
						clicked = current;
					
					if(current == total) {
						var nexttitle = $stage.parent().find('> article:nth-child(1) h2').text();
					}else{
						var nexttitle = $stage.parent().find('> article:nth-child('+(current+1)+') h2').text();
					}

					$('.next-video .title .description').html(nexttitle);
					
					if($windowSize == 'mobile'){
						$height = parseInt($stage.css('padding-top'));
						$stage.height($stage.height());
					}else{
						$height = $stage.height();
					}

					var vidTitle = $stage.find('h2').text();
					
					videojs('div_video', {}, function() {
					  this.ga({'eventLabel' : vidTitle});
					});

					var myPlayer = videojs("div_video");

					/* NEXT FUNCTIONALITY START */

					//if(!$('body').hasClass('page-id-585')){

						var $nextbutton = $('<button id="vjs-next-button" class="vjs-next vjs-button vjs-control" />');

						$nextbutton.insertBefore($('.vjs-volume-menu-button'));

						$nextbutton.add($('.next-video .play')).on('click', function(){
							nextVideo();
						});

						function nextVideo(){
						
							if(current == total) {
								current = 1;
							}else{
								current++;
							}					

							var nextmp4 = $stage.parent().find('> article:nth-child('+current+')').data('video-mp4'),
								nextogv = $stage.parent().find('> article:nth-child('+current+')').data('video-ogv'),
								nextwebm = $stage.parent().find('> article:nth-child('+current+')').data('video-webm'),
								nextposter = $stage.parent().find('> article:nth-child('+(current)+')').data('poster');
							
							$left = $stage.parent().find('> article:nth-child('+current+')').offset().left;
							$top = $stage.parent().find('> article:nth-child('+current+')').offset().top;
							$width = $stage.parent().find('> article:nth-child('+current+')').width();

							if($windowSize == 'mobile'){
								$height = parseInt($stage.parent().find('> article:nth-child('+current+')').css('padding-top'));
								$stage.parent().find('> article:nth-child('+current+')').height($stage.height());
							}else{
								$height = $stage.parent().find('> article:nth-child('+current+')').height();
							}

							$('.video-page-container.active').css('background-image', 'url('+nextposter+')');
							
							if(current == total) {
								nexttitle = $stage.parent().find('> article:nth-child(1) h2').text();
							}else{
								nexttitle = $stage.parent().find('> article:nth-child('+(current+1)+') h2').text();
							}

							$('#div_video .vjs-poster').css('background-image', 'url('+nextposter+')');
							$('#div_video video, .video-js.vjs-has-started').attr('poster', nextposter);

							var source = $("#div_video video").attr("src"),
								extension = source.substr((source.lastIndexOf('.')+1));

							if(extension == 'mp4'){
								$("#div_video video").attr("src", nextmp4);
							}

							if(extension == 'ogv'){
								$("#div_video video").attr("src", nextogv);
							}

							if(extension == 'webm'){
								$("#div_video video").attr("src", nextwebm);
							}
							
							$("#div_video source:nth-child(1)").attr("src", nextmp4);
							$("#div_video source:nth-child(2)").attr("src", nextogv);
							$("#div_video source:nth-child(3)").attr("src", nextwebm);

							if($('.next-video').hasClass('active')){
								$('.next-video').removeClass('active');
							}

							$('.next-video .title .description').html(nexttitle);
							
							myPlayer.load();

							myPlayer.play();
						}
						
						/*
						var timer,
							timeractive = false;
						*/

						/*
						function stopTimer(){
							timeractive=false;
							clearInterval(timer);
						}
						*/

						/*function startTimer(){
							timer = setInterval(function(){$nextbutton.trigger('click')}, 10000);
							timeractive=true;
						}*/

						timeractive=false;
						
						myPlayer.on("ended", function(){ 
							$('.next-video').addClass('active');
							bar.set(0);
							bar.animate(1.0,{},function(){
								$nextbutton.trigger('click')
							});
							timeractive=true;
						});

						myPlayer.on("play", function(){ 
							if($('.next-video').hasClass('active')){
								$('.next-video').removeClass('active');
							}
							if(timeractive == true){
								timeractive=false;
								bar.set(0);
								bar.stop();
							}
						});

						myPlayer.on('timeupdate', function(){
							var duration_time =  Math.floor(this.duration());
							var current_time =  Math.floor(this.currentTime());

							if ( current_time != duration_time ){
							    if($('.next-video').hasClass('active')){
									$('.next-video').removeClass('active');
								}
								if(timeractive == true){
									//stopTimer();
									timeractive=false;
									bar.set(0);
									bar.stop();
								}
							}
						});
					//}

					/* NEXT FUNCTIONALITY END */

					$container.css({
							'left' : $left,
							'top' : $top,
							'width' : $width,
							'height' : $height
						})
						.appendTo('body');

					$player.css('opacity', 0);

					$('#div_video').css({
						'height': $.Window.height(),
						'width':$.Window.width(),
					});

					$container.addClass('active').stop().animate({
						'left' : 0,
						'top' : $.Window.scrollTop(),
						'width' : $.Window.width(),
						'height' : $.Window.height()
					}, 500, "easeInOutExpo", function(){
						
						myPlayer.play();

						//console.log(nexttitle);
				    	
						$player.css('opacity', 0).animate({
							'opacity' : 1
						}, 500, "easeInOutExpo", function(){

							function fullWin(){
								$player.add($container).add('.video-js').css({
									'width' : $.Window.width(),
									'height' : $.Window.height()
								});
							}

							$.Window.bind("resize", fullWin);

							$(document).keyup(function(e) {
							     if (e.keyCode == 27) {
							     	$player.find('.close').trigger('click');
							    }
							});
							
							//Close Button

							$player.find('.close').click(function(e) {
								e.preventDefault();
								$container.find('video').attr('id', '');
								$.Window.unbind("resize", fullWin);
								$player.animate({
									'opacity' : 0
								}, 500, "easeInOutExpo", function(){
									
								});

								myPlayer.dispose();
									$('.video-player').remove();
									$('body').removeClass('stop-scrolling');

								$container.stop().animate({
									'left' : $left,
									'top' : $top,
									'width' : $width,
									'height' : $height
								}, 500, "easeInOutExpo", function(){
									$container.appendTo($stage).css({
										left: '0',
										top: '0',
										width: '100%',
										height: '100%'
									});

									//console.log(current);
									
									var prevposter = $stage.parent().find('> article:nth-child('+(clicked)+')').data('poster');
									
									$('.video-page-container.active').css('background-image', 'url('+prevposter+')');

									$container.removeClass('active');
									$stage.height('');
								});
							});
						});
					});
				});
			}
		});
	};

	if($('.module__videos .video-item').length){
		var $count = 0;
		$('.module__videos .video-item').each(function(){
			$count++;
			$(this).videoGallery($count);
		});
	}

	/*-------------------------------------
	Video Slider
	-------------------------------------*/

	$.fn.videoSlider = function(e){
		var $stage = $(this),
			$play = $stage.find('a'),
			$container = $stage.find('.video-container'),
			$mp4 = $stage.data('video-mp4'),
			$webm = $stage.data('video-webm'),
			$ogv = $stage.data('video-ogv'),
			$poster = $stage.data('poster'),
			$count = e;

		$.Window.bind("load", function() {
			$stage.click(function(e) {
				e.preventDefault();
		    	if ($isMobile == true && $windowSize == 'mobile') {
		    		$('<video id="div_video_slider" class="video-js vjs-default-skin" controls preload="auto" data-setup="{}" poster="'+$poster+'"><source src="'+$mp4+'"  type="video/mp4"><source src="'+$ogv+'"  type="video/ogg"><source src="'+$webm+'"  type="video/webm"></video>').prependTo($stage);
			    	$stage.find('.video-container').hide();
			    }else{
			    	$('<div class="video-player"><div class="close"></div><video id="div_video_slider" class="video-js vjs-default-skin" controls preload="auto" data-setup="{}" poster="'+$poster+'"><source src="'+$mp4+'"  type="video/mp4"><source src="'+$ogv+'"  type="video/ogg"><source src="'+$webm+'"  type="video/webm"></video></div>').insertAfter('.module__video-slider header');
			    	
			    	var $player = $stage.find('.video-player');

			    	function fullWin(){
						$player.add('.video-js').css({
							'width' : $('.module__video-slider').width(),
							'height' : $('.module__video-slider').outerHeight()
						});
					}

					var myPlayer = videojs("div_video_slider");

					myPlayer.ready(function(){
						fullWin();
					})

					$.Window.bind("resize", fullWin);
					
					$('.video-player')
					.css('display', 'block')
					.animate({
						'opacity' : 1
					}, 500, "easeInOutExpo", function(){
						myPlayer.play();
					});

					$('.video-player').find('.close').click(function(e) {
						$('.video-player')
						.animate({
							'opacity' : 0
						}, 500, "easeInOutExpo", function(){
							videojs("div_video_slider").dispose();
							$(this).remove();
							$.Window.unbind("resize", fullWin);
						});
					});
				}
			});
		});
	};

	if($('.module__video-slider .video-slider-item').length){
		var $count2 = 0;
		$('.module__video-slider .video-slider-item').each(function(){
			$count2++;
			$(this).videoSlider($count2);
		});
	}

	/*-------------------------------------
	Alert Box
	-------------------------------------*/

	if($('.alert-msg .close').length){
		$('.alert-msg .close').click(function(e) {
			e.preventDefault();
			var $alert = $(this).closest('.alert-msg');
			$alert.stop().animate({height:0}, 500, "easeInOutExpo");
		});
	}

	/*-------------------------------------
	Clocks
	-------------------------------------*/

	$.fn.Clock_dg = function(){
		var $clock = $(this),
			props = 'transform WebkitTransform MozTransform OTransform msTransform'.split(' '),
	        prop,
	        el = document.createElement('div'),
	        $offset = 0;

	    for(var i = 0, l = props.length; i < l; i++) {
	        if(typeof el.style[props[i]] !== "undefined") {
	            prop = props[i];
	            break;
	        }
	    }

	    if($(this).hasClass('london')){
	    	$offset = 5;
	    }else if($(this).hasClass('frankfurt')){
	    	$offset = 6;
	    }else if($(this).hasClass('tokyo')){
	    	$offset = 1;
	    }

	    var h = serverHour + $offset;

	    //console.log(serverDate);

	    if(h > 12) {
            h = h - 12;
        }

        var hour = h,
        	minute = serverMin,
        	second = serverSec;

        setInterval(function(){
        	var angle = 360/60,
        		hourAngle = (360/12) * hour + (360/(12*60)) * minute;

	        $clock.find('.minute')[0].style[prop] = 'rotate(' + angle * minute + 'deg)';
	        $clock.find('.second')[0].style[prop] = 'rotate(' + angle * second + 'deg)';
	        $clock.find('.hour')[0].style[prop] = 'rotate(' + hourAngle + 'deg)';

	        if(second < 59){
	        	second++;
	        }else{
	        	second=0;
	        	if(minute < 59){
		        	minute++;
		        }else{
		        	minute=0;
		        	hour++;
		        }
	        }
        },1000);
	};

	if($('.clock').length){
		$('.clock').each(function(){
			$(this).Clock_dg();
		});
	}
	
	/*-------------------------------------
	Match Height
	-------------------------------------*/

	if($('.lead-item').length){
		$('.lead-item').matchHeight();
	}

	if($('.related-item').length){
		$('.related-item').matchHeight();
	}

	if($('.two-column-item.with-icon').length){
		$('.two-column-item.with-icon').matchHeight();
	}

	/*-------------------------------------
	History Section
	-------------------------------------*/

	if($('.history-hero').length){
		$('.history-hero').slick({
			infinite: false,
			speed: 300,
			slidesToShow: 4,
			dots: false,
			arrows: false,
			focusOnSelect: false,
			responsive: [
				{
					breakpoint: $mobileBreakpoint,
					settings: {
						slidesToShow: 2,
						dots: true
					}
				},
				{
					breakpoint: 460,
					settings: {
						slidesToShow: 1,
						dots: true
					}
				}
			]
		});

		$('.history-hero-2').slick({
			infinite: false,
			speed: 300,
			slidesToShow: 2,
			dots: false,
			arrows: false,
			focusOnSelect: false,
			responsive: [
				{
					breakpoint: $mobileBreakpoint,
					settings: {
						slidesToShow: 1,
						dots: true
					}
				}
			]
		});

		$('.history-hero-3').slick({
			infinite: false,
			speed: 300,
			slidesToShow: 3,
			dots: false,
			arrows: false,
			focusOnSelect: false,
			responsive: [
				{
					breakpoint: $mobileBreakpoint,
					settings: {
						slidesToShow: 2,
						dots: true
					}
				},
				{
					breakpoint: 460,
					settings: {
						slidesToShow: 1,
						dots: true
					}
				}
			]
		});
	}

	/*-------------------------------------
	Content Slider
	-------------------------------------*/
	
	$.fn.contentSlider = function(){
		var $stage = $(this),
			$item = $stage.find('article'),
			$scrollwidth = 0;

		$stage.contents().wrapAll('<div class="scroller"></div>');
		
		$.Window.bind("load resize", function() {
			if($windowSize == 'desktop') {
				$stage.removeClass('mobile');
				if(!$stage.hasClass('desktop')){
					$stage.addClass('desktop');
					scrollSize();
				}
			}else{
				$stage.removeClass('desktop');
				if(!$stage.hasClass('mobile')){
					$stage.addClass('mobile');
					scrollSize();
				}
			}
		});

		function scrollSize(){
			if($('.mCSB_container').length){
				$stage.mCustomScrollbar("destroy");
			}
			
			$stage.find('.scroller').css('width', 0);
			$scrollwidth = 0;
			$item.each(function() {
			    $scrollwidth += parseInt($(this).outerWidth(true));
			});
			$stage.find('.scroller').css({
				'width': $scrollwidth,
	    		'margin' : '0 auto'
			});
			
			$stage.mCustomScrollbar({
				axis:'x',
				theme:"dark-2",
				scrollInertia: 6,
				mouseWheel:{ invert: true }
			});
		}
	};

	$(document).ready(function() {
		if($('.module__video-slider > .container').length){
			$('.module__video-slider > .container').contentSlider();
		}
		if($('.module__industry > .container').length){
			$('.module__industry > .container').contentSlider();
		}
		if($('.module__case-study > .container').length){
			$('.module__case-study > .container').contentSlider();
		}
	});

	/*-------------------------------------
	Play Header Video
	-------------------------------------*/

	$(document).ready(function() {
		if($('.module__hero-v2 video').length){
			$('.module__hero-v2 video').get(0).play();
		}

		if($('.module__hero video').length){
			$('.module__hero video').get(0).play();
		}
	});
	
	/*-------------------------------------
	News
	-------------------------------------*/

	$(window).load(function() {
		
		setTimeout(function(){
			$(".news-search .filter select").select2();
		}, 100);

		setTimeout(function(){
			$("#search-news .filter select").select2();
		}, 100);

		$(".select2-search, .select2-focusser").remove();
	});

	/*-------------------------------------
	Marketo
	-------------------------------------*/

	$(window).load(function() {
		$('.mktoForm select, .form-control select').select2();

		$(".select2-search, .select2-focusser").remove();
	});

	/*-------------------------------------
	Resources
	-------------------------------------*/

	$(window).load(function() {
		$(".resources-filter select").select2();
	});

	/*-------------------------------------
	Tabs
	-------------------------------------*/

	$(document).ready(function() {
		$("#contact select").select2();
		$(".select2-search, .select2-focusser").remove();
	});

	$('ul.tabs').each(function(){
		// For each set of tabs, we want to keep track of
		// which tab is active and it's associated content
		var $active, $content, $links = $(this).find('a');

		// If the location.hash matches one of the links, use that as the active tab.
		// If no match is found, use the first link as the initial active tab.
		$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
		$active.addClass('selected');

		$content = $($active[0].hash);

		// Hide the remaining content
		$links.not($active).each(function () {
		  $(this.hash).hide();
		});

		// Bind the click event handler
		$(this).on('click', 'a', function(e){
		  // Make the old tab inactive.
		  $active.removeClass('selected');
		  $content.hide();

		  // Update the variables with the new link and content
		  $active = $(this);
		  $content = $(this.hash);

		  // Make the tab active.
		  $active.addClass('selected');
		  $content.show();

		  // Prevent the anchor's default click action
		  e.preventDefault();
		});
	});

	/*-------------------------------------
	Show hidden table rows
	-------------------------------------*/

	$('.modal').click(function(e) {
		e.preventDefault();
	});

	$(function(){
		var treeTable = {
			parentClass : 'show-tr',
			childClassPrefix : '',
			collapsedClass : 'collapsed',
			init : function(parentClass, collapsedClass, childClassPrefix) {
				if (parentClass !== undefined) {
					this.parentClass = parentClass;
				}
				if (collapsedClass !== undefined) {
					this.collapsedClass = collapsedClass;
				}
				if (childClassPrefix !== undefined) {
					this.childClassPrefix = childClassPrefix;
				}
				$('table').on('click', 'tr.'+treeTable.parentClass, function () { 
					treeTable.toggleRowChildren($(this));
				});
			},
			toggleRowChildren : function(parentRow) {
				var childClass = this.childClassPrefix+parentRow.attr('id');
				var childrenRows = $('tr', parentRow.parent()).filter('.'+childClass);
				childrenRows.slideToggle();
				childrenRows.each(function(){
					if ($(this).hasClass(treeTable.parentClass) && !$(this).hasClass(treeTable.collapsedClass)) {
						treeTable.toggleRowChildren($(this));
					}
				});
				parentRow.toggleClass(this.collapsedClass);
			}
		};
		treeTable.init();
	});

	$(document).ready(function(){
		$(".hide-table").toggle();
	});

    $(".show-table").on("click", function(){
        $(this).next().next().slideToggle();
        $(this).next().next().next().toggleClass('hidden');
        $(this).next().next().next().next().toggleClass('hidden');
        $(this).children().children().toggleText();
    });

    $.fn.toggleText = function(){
		if (this.text() == '+') this.text('-');
		else this.text('+');
		return this;
	};
	
	$(document).ready(function(){ 
		$(".module__resources table").tablesorter({
		    cssChildRow: "hidden"
		});
	}); 

	/*-------------------------------------
	Navigation: Desktop
	-------------------------------------*/

	var $nav = $('nav.main'),
		$body = $('body');

	$.fn.desktop_init = function(options){
		var $reset = options.reset;
		
		if($reset == true){
			
			// Undo mobile DOM modifications
			$('#btn-burger').unbind('click');
			$('.btn-top a').unbind('click');
			$('.menu-item-has-children > a').unbind('click');
			$('#btn-burger').removeClass('active');
			$('nav.mobile a').css('display', 'block');
			$('nav.mobile div').remove();
			$('#page, nav.mobile').contents().unwrap();
			$.fn.mobile_undo = function(){
				var $e = $('.'+$(this).attr('id')+'-container');
				$e.append($(this));
			};
			$('#menu-region, #menu-web-tools, #menu-main, #menu-header').each(function(){
				$(this).mobile_undo();
			});
			$('nav.main').insertBefore($('.header-search'));
		}

		// Modify
		$('#menu-main > li.menu-item-has-children > ul.sub-menu').each(function(){
		    $(this).wrap('<nav class="desktop-drop ' + $(this).parent().attr('id') + '"><div class="container"></div></nav>');
 		});

 		$('header.main').append($('.desktop-drop'));

		//Desktop Nav Operation

		$('.menu-desktop #menu-main > li.menu-item-has-children > a').click(function(e) {
			e.preventDefault();

			var $drop = $('.desktop-drop.' + $(this).parent().attr('id'));
			
			if(!$(this).hasClass('active')){

				setTimeout(function(){
					$('body').addClass('drop-menu-active');
				},100);

				var prevIndex = $('.menu-desktop #menu-main > li.menu-item-has-children > a.active').parent().index(),
					currentIndex = $(this).parent().index();
				
				if(prevIndex != -1){
					if(prevIndex < currentIndex){
						$drop.find('.container').css('left', '300px')
								.stop()
								.animate({
									'left' : 0
								}, 500, "easeOutExpo");
					}else{
						$drop.find('.container').css('left', '-300px')
								.stop()
								.animate({
									'left' : 0
								}, 500, "easeOutExpo");
					}
				}

				$('.desktop-drop.active, .menu-desktop #menu-main > li.menu-item-has-children > a.active').removeClass('active');
				
				$('header.main').addClass('active');
				$(this).add($drop).addClass('active');

				// Add alignment class if less than four items in desktop-drop

				if($drop.find('> .container > .sub-menu > li').length < 4){
					$drop.find('> .container > .sub-menu:not(.centered)').addClass('centered');
				}

				// Prevent height issues on sub menu

				var menuHeight = 0;

				$drop.find('.menu-second-column, .menu-third-column, .menu-fourth-column').each(function(){
					if($(this).outerHeight() > menuHeight) {
						menuHeight = $(this).outerHeight();
					}
				});

				var $subMenu = $drop.find('.container > .sub-menu');

				if($subMenu.height() < menuHeight) {
					$subMenu.height(menuHeight);
				}

			}else{
				$('body').removeClass('drop-menu-active');
				$('header.main').removeClass('active');
	            $(this).add($drop).removeClass('active');
	            $drop.find('.container > .sub-menu').attr('style', '');
			}
		});
	};

	// Clicked Outside

	$('html').click(function(e) {
		if($(window).width() >= 768) {
			if (!e.target.classList.contains('desktop-drop') && $(e.target).parents('.desktop-drop').length == 0 && $(e.target).parents('nav.main').length == 0 && $('body').hasClass('drop-menu-active')) {
				$('body').removeClass('drop-menu-active');
	            $('header.main, .desktop-drop, #menu-main > li.menu-item-has-children > a.active').removeClass('active');
			}
		}
	});

	/*-------------------------------------
	Navigation: Mobile
	-------------------------------------*/

	$.fn.mobile_init = function(options){
		var $reset 	= options.reset,
			$burger = $('#btn-burger'),
			$level = 0;

		if($reset == true){
			
			// Undo desktop DOM modifications
			$('.desktop-drop').each(function(){
				$('#menu-main').find('#' + $(this).attr('class').split(' ')[1]).append($(this));
			});
			$('.desktop-drop .container > .sub-menu').unwrap().unwrap();

		}

		//Init
		$('.sub-menu.active').removeClass('active');
		$('body').wrapInner('<div id="page"></div>');
		$('#menu-region, #menu-web-tools, #menu-main, #menu-header').wrapAll('<nav class="mobile"></nav>');
		$('#menu-region, #menu-web-tools, #menu-header').insertAfter('#menu-main');
		$('nav.mobile').insertBefore($('#page'));
		$('<div class="btn-top"><a></a></div>').prependTo('nav.mobile');
		$('<div class="btn-parent"><a></a></div>').insertAfter('.btn-top').css('display', 'none');

		var $page = $('#page'),
			$nav = $('nav.mobile'),
			$button = $('.btn-top'),
			$button_link = $button.find('a'),
			$parent = $('.btn-parent'),
			$parent_link = $parent.find('a');

		//Events
		$burger.click(function(e){
			e.preventDefault();
			$burger.toggleClass('active');
			$page.toggleClass('active');
	 		if($page.hasClass('active')){
	 			$page.stop().animate({marginLeft: '-=250px'}, 300, "easeInOutExpo");
	 		}else{
	 			$page.stop().animate({marginLeft: '0'}, 300, "easeInOutExpo");
	 		}
		});

		//Set up menu on page load
		if($('nav.mobile #menu-main .current_page_item').length && $('nav.mobile #menu-main .current_page_item:not(.current-menu-ancestor)').parentsUntil($nav).length > 1){
			$('nav.mobile ul.menu a').css('display', 'none');
			$('nav.mobile #menu-main .current_page_item:not(.current-menu-ancestor)').parent().addClass('active').find('> li > a').css('display', 'block');
			// console.log('NOW-A')
		}else if ($('nav.mobile #menu-main .current-menu-item').length && $('nav.mobile #menu-main .current-menu-item').parentsUntil($nav).length > 1){
			$('nav.mobile ul.menu a').css('display', 'none');
			$('nav.mobile #menu-main .current-menu-item').parent().addClass('active').find('> li > a').css('display', 'block');
			// console.log('NOW-B')
		}else if ($('nav.mobile #menu-main .current-menu-parent').length && $('nav.mobile #menu-main .current-menu-parent').parentsUntil($nav).length > 1){
			$('nav.mobile ul.menu a').css('display', 'none');
			$('nav.mobile #menu-main .current-menu-parent').parent().addClass('active').find('> li > a').css('display', 'block');
			// console.log('NOW-C')
		}else if ($('nav.mobile #menu-main .current-menu-item-post').length && $('nav.mobile #menu-main .current-menu-item-post').parentsUntil($nav).length > 1){
			$('nav.mobile ul.menu a').css('display', 'none');
			$('nav.mobile #menu-main .current-menu-item-post').parent().addClass('active').find('> li > a').css('display', 'block');
			// console.log('NOW-D')
		}else{
			$('nav.mobile ul.menu a').css('display', 'none');
			$('nav.mobile ul.menu > li > a').css('display', 'block');
		}

		//Click item with parent
		$nav.find('.menu-item-has-children > a').click(function(e){
			e.preventDefault();
			var $current = $(this);
			$('nav.mobile ul.active').removeClass('active');
			$('nav.mobile ul.menu a, .btn-parent').stop().animate({opacity:0}, 300, "easeInOutExpo").promise().done(function(){
				$('nav.mobile ul.menu a, .btn-parent').css({
					display : 'none',
					opacity : 1
				});
				$current.parent().find('> ul').addClass('active').find('> li > a').css({display : 'block', opacity : 0, 'margin-left' : 20}).stop().animate({opacity:1, marginLeft:0}, 300, "easeInOutExpo");
				updateButton();
			});
		});

		$parent_link.click(function(e){
			if($(this).attr('href') == ''){
				e.preventDefault();
			}
		})

		//Click top button
		$button_link.click(function(e){
			if($('ul.menu').hasClass('active') || !$('nav.mobile ul').hasClass('active')){
				
			}else{
				e.preventDefault();
				$('nav.mobile ul.menu a, .btn-parent').stop().animate({opacity:0}, 300, "easeInOutExpo").promise().done(function(){
					$('nav.mobile ul.menu a, .btn-parent').css({
						display : 'none',
						opacity : 1
					});
					$('nav.mobile ul.active').removeClass('active').parent().parent().addClass('active').find('> li > a').css({display : 'block', opacity : 0, 'margin-left' : -20}).stop().animate({opacity:1, marginLeft:0}, 300, "easeInOutExpo");
					if($('ul.menu').hasClass('active')){
						$('nav.mobile ul.menu > li > a').css({display : 'block', opacity : 0, 'margin-left' : -20 }).stop().animate({opacity:1, marginLeft:0}, 300, "easeInOutExpo");
					}
					updateButton();
				});
			}
		});

		//Update top button and parent button
		function updateButton(){
			if($('nav.mobile ul.menu').hasClass('active') || !$('nav.mobile ul').hasClass('active')){
				//Root
				$button_link.addClass('home').attr('href', '/').html('Home');
				$parent.css('display', 'none');
			}else if($('nav.mobile ul.active').parent().parent().hasClass('menu')){
				//Second level
				$button_link.removeClass('home').html('Menu').attr('href', '');
				$parent.css({display : 'block', opacity : 0}).stop().animate({opacity:1}, 300, "easeInOutExpo");

				var $select = $('nav.mobile ul.active').parent().find('> a').data('select');
				
				if($select == undefined){
					$parent_link.html($('nav.mobile ul.active').parent().find('> a').html()).attr('href', '');
					//console.log($select);
				}else{
					$parent_link.html($select);
					//console.log('Write parent link title now')
				}
			}else{
				//Third level and beyond
				$parent.css({display : 'block', opacity : 0}).stop().animate({opacity:1}, 300, "easeInOutExpo");
				$parent_link.html($('nav.mobile ul.active').parent().find('> a').html()).attr('href', $('nav.mobile ul.active').parent().find('> a').attr('href'));
				$button_link.attr('href', '').removeClass('home').html($('nav.mobile ul.active').parent().parent().parent().find('> a').html());
			}
		}

		updateButton();
	};

	$.Window.bind("load resize", function() {
		if($windowSize == 'desktop') {
			
			//Desktop
			if(!$body.hasClass('menu-desktop')){
				if($body.hasClass('menu-mobile')){
					$body.removeClass('menu-mobile').addClass('menu-desktop').desktop_init({reset : true});
				}else{
					$body.addClass('menu-desktop').desktop_init({reset : false});
				}
			}
		}else{
			
			//Mobile
			if(!$body.hasClass('menu-mobile')){
				if($body.hasClass('menu-desktop')){
					$body.removeClass('menu-desktop').addClass('menu-mobile').mobile_init({reset : true});
				}else{
					$body.addClass('menu-mobile').mobile_init({reset : false});
				}
			}
		}
	});

	/*-------------------------------------
	Case Studies
	-------------------------------------*/

	$.fn.csMove = function(){

		function moveContainer(){
			var $scrollpos = $.Window.scrollTop()-$topmargin;
			$('#case_studies_ajax > div').css('top', -$scrollpos);
		}

		function slideArticles(){
			$('section.hero-case-study').each(function(){
				var $stage = $(this);
				if($stage.data('offset') < $.Window.scrollTop()){
					$difference = ($stage.data('offset') - $.Window.scrollTop());
					$stage.css( { 'transform' : 'translateY(' + -($difference*.5) + 'px)'});
				}else{
					$stage.css( { 'transform' : 'translateY(' + 0 + 'px)'});
				}
			});
		}

		if($windowSize == 'desktop') {
			if($('body').hasClass('no-parallax')){
				$('body').removeClass('no-parallax');
			};

			$('.module__hero.hero-case-study').each(function(){
				var $stage = $(this);
				if($stage.find('.hero-text.cs').hasClass('modified')){
					$stage.find('.hero-text.cs').appendTo($stage.find('> .container')).removeClass('modified');
				}
			});

			if(!$('body').hasClass('parallax')){
				$('body').addClass('parallax');
				
				$('#case_studies_ajax').height($('#case_studies_ajax > div').height());
				$topmargin = $('header.main').height() + $('.module__header-only').height() + $('.module__hero-breadcrumbs').height();

				//Set offsets
				$('section.hero-case-study').each(function(){
					$(this).data('offset', $(this).offset().top-$.Window.scrollTop());
				});

				//Move fixed container
				$.Window.bind("scroll", moveContainer);

				//Move CS articles
				$.Window.bind("scroll", slideArticles);

			}
		}else{
			if($('body').hasClass('parallax')){
				$('body').removeClass('parallax')
			}

			$('.module__hero.hero-case-study').each(function(){
				var $stage = $(this);
				if(!$stage.find('.hero-text.cs').hasClass('modified')){
					$stage.find('.hero-text.cs').attr('style', '').insertAfter($stage.find('.hero-content')).addClass('modified');
				}
			});
			
			if(!$('body').hasClass('no-parallax')){
				$('body').addClass('no-parallax');
				$.Window.unbind("scroll", moveContainer);
				$.Window.unbind("scroll", slideArticles);
				$('#case_studies_ajax, #case_studies_ajax > div').attr('style', '');
			}
		}
	}

	if($('.page-template-page-all-case-studies-php').length){
		$.Window.bind("resize load", function() {
			$('.page-template-page-all-case-studies-php').csMove();
		});
	}

	$(".cs-inactive").click(function(){
		loadCS($(this));
	});


	var reloadStatus = false;

	function loadCS(el){
		$stage = el;
		$stage.unbind('click');
		$.ajax({
			method: 'POST',
			url: "/wp-content/themes/ari_theme/case-studies-ajax.php",
			data: { csid: $stage.data('csid') }
		})
		.done(function(html) {
			$(html).insertAfter('.cs-inactive');
			
			$('.module__hero:not(.cs-inactive)').next().andSelf().wrapAll('<div class="delete-me" />');
			
			$stage.find('.hero-nav').css('opacity', 0);
			
			$stage.find('.hero-text').animate({
				opacity:0
		    }, 300, "easeInOutExpo", function(){
		    	$('html,body').animate({ scrollTop: $('header.main').outerHeight()}, 700, "easeInOutExpo");
		    	$stage.prev().css('overflow', 'hidden').animate({
					opacity:0,
			        height: 0
			    }, 700, "easeInOutExpo", function(){
			    	$('.delete-me').remove();
			    	$stage.find('.hero-text').add($stage.find('.hero-nav')).animate({
						opacity:1
				    }, 300, "easeInOutExpo");

				    history.pushState('{foo: "bar"}', '', '/customer-story/'+$('.module__article').data('url'));
				    reloadStatus = true;

				    $(document).prop('title', $('.hero-text h3').html() + ' - ARI');
			    });

		    	//console.log($('.module__article').css('background-color', 'red').data('url'));

				$stage.removeClass('cs-inactive');

				$(".cs-inactive").click(function(){
					loadCS($(this));
				});

				$('section.module__hero').each(function(){
					$(this).heroBanner();
				});
		    });
		});
	}

	$(window).bind("popstate", function(e) {
		var state = e.originalEvent.state;
		//console.log(state);
		if ( reloadStatus != false || state != null ) { 
		    location.reload();
		}
	});

	/*-------------------------------------
	Region Selection Tool
	-------------------------------------*/

	$.fn.regionSelection = function(){
		var $stage = $(this),
			$region = $stage.find('> li > a'),
			$label = $region.html(),
			$select = $region.data('select');

		if($select == undefined){
			$select = 'Select Region';
		}

		$.Window.bind("load resize", function() {
			if($windowSize == 'mobile') {
				if(!$stage.hasClass('mobile')){
					$stage.addClass('mobile').removeClass('desktop');
					$('#menu-region a').off('hover').hover(
						function() {
							$region.html($label);
						}, function() {
							$region.html($label);
						}
					);
				}
			}else{
				if(!$stage.hasClass('desktop')){
					$stage.addClass('desktop').removeClass('mobile');
					$region.html($label);
					$('#menu-region a').hover(
						function() {
							$region.html($select);
						}, function() {
							$region.html($label);
						}
					);
				}
			}
		});	
	};

	$(document).ready(function() {
		$('#menu-region').regionSelection();
	});

	/*-------------------------------------
	Push when logged in
	-------------------------------------*/

	if($body.hasClass('logged-in')){
		$.Window.bind("load resize", function() {
			$('.desktop-drop').each(function(){
				$(this).css('margin-top', $('#wpadminbar').height()-1);
			});
		});
	}

	$('#select-anchor').change( function () {
		var targetPosition = $($(this).val()).offset().top;
		$('html,body').animate({ scrollTop: targetPosition}, 'slow');
	});

	/*
	>>================================================================================>
	Module: Solutions Carousel
	>>================================================================================>
	*/

	$('.module__solutions-carousel .carousel > ul').slick({
		infinite: false,
		speed: 300,
		slidesToShow: 3,
		arrows: true,
		focusOnSelect: false,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					dots: false
				}
			},
			{
				breakpoint: 460,
				settings: {
					slidesToShow: 1,
					dots: false
				}
			}
		]
	});

	$('.module__solutions-carousel button.header').on('click', function(){
		
		var $content = $(this).next(),
			$links = $content.find('ul');

		$(this).toggleClass('active');

		if($(this).hasClass('active')){
			$content.animate({
				height: $links.outerHeight(true)
			}, 500, "easeInOutExpo");
		}else{
			$content.animate({
				height: 0
			}, 500, "easeInOutExpo");
		}
	});

	/*
	>>================================================================================>
	Expandable Component
	>>================================================================================>
	*/

	$('.expandable-component button.header').on('click', function(){
		
		var $component = $(this).parent(),
			$content = $(this).next(),
			contentHeight = $content.find('.expandable-content-container').outerHeight();

		
		if(!$component.hasClass('active')){
			$component.addClass('active');
			$content.animate({
				height: contentHeight
			}, 500, "easeInOutExpo", function(){
				$component.addClass('expanded');
				$content.attr('style', '');
			});
		}else{
			$content.css('height', $content.height());
			$component.removeClass('expanded');
			$content.css('height', $content.height());
			$component.removeClass('active');
			$content.animate({
				height: 0
			}, 500, "easeInOutExpo", function(){
				
			});
		}
	});

	/*
	>>================================================================================>
	Sticky Navigation Right
	>>================================================================================>
	*/

	// if($('[data-nav-item]').length && $('#sticky-nav-right').length){
	// 	$('#sticky-nav-right').append('<ul />');

	// 	$('[data-nav-item]').each(function(){
	// 		var title = $(this).html(),
	// 			$list_item = $('<li />').append('<button><span></span></button>'),
	// 			$button = $list_item.find('button'),
	// 			$parent = $(this).closest('section');

	// 		$button.find('span').html(title);

	// 		$('#sticky-nav-right ul').append($list_item)

	// 		$button.on('click', function(){
	// 			$('html, body').animate({
	// 		        scrollTop: $parent.offset().top + 1
	// 		    }, 500, "easeInOutExpo");
	// 		});

	// 		$(window).on('scroll resize', function(){
	// 			if($(window).scrollTop() > ($parent.offset().top - $(window).height() * .25) && $(window).scrollTop() < $parent.offset().top + $parent.outerHeight()){
	// 				if(!$list_item.hasClass('active')) {
	// 					$('#sticky-nav-right li.active').removeClass('active');
	// 					$list_item.addClass('active');
	// 				}
	// 			}
	// 		})
	// 	})
	// }

	/*
	>>================================================================================>
	Sticky Navigation Bar
	>>================================================================================>
	*/

	if($('[data-nav-item]').length && $('#sticky-navigation-bar').length){

		$('body').addClass('has-sticky-navigation-bar');

		$('#sticky-navigation-bar nav').append('<ul />');

		$('[data-nav-item]').each(function(){
			var title = $(this).html(),
				$list_item = $('<li />').append('<button />'),
				$button = $list_item.find('button'),
				$parent = $(this).closest('section');

			$button.html(title);

			$('#sticky-navigation-bar ul').append($list_item)

			$button.on('click', function(){
				$('html, body').animate({
			        scrollTop: $parent.offset().top + 1 - $('#sticky-navigation-bar').height()
			    }, 500, "easeInOutExpo");
			});

			$(window).on('scroll resize', function(){
				if($(window).scrollTop() > ($parent.offset().top - $(window).height() * .25) && $(window).scrollTop() < $parent.offset().top + $parent.outerHeight()){
					if(!$list_item.hasClass('active')) {
						$('#sticky-navigation-bar li.active').removeClass('active');
						$list_item.addClass('active');
					}
				}
			})
		})
	}

	if($('#sticky-navigation-bar').length){
		$(window).on('scroll resize', function(){
			if(!$isMobile && $(window).scrollTop() >= $('#sticky-navigation-bar').offset().top){
				$('#sticky-navigation-bar').addClass('sticky');
			}else{
				$('#sticky-navigation-bar').removeClass('sticky');
			}
		})
	}

	/*
	>>================================================================================>
	Module: Story Carousel
	>>================================================================================>
	*/

	$('.module__story-carousel .carousel').slick({
		infinite: false,
		speed: 300,
		slidesToShow: 1,
		dots: true,
		arrows: false,
		focusOnSelect: false,
	});

	/*
	>>================================================================================>
	Site Header Functionality
	>>================================================================================>
	*/

	var lastScrollTop = 0;
	
	$(window).on('scroll', function(){
		var st = $(this).scrollTop();
		   if (st > lastScrollTop){
		       if(st > $('header.main').outerHeight()){
		       		$('body:not(.past-header').addClass('past-header')
		       }
		   } else {
		      $('body.past-header').removeClass('past-header')
		   }
		   lastScrollTop = st;
	})

	if($('.module__hero-v2').length) {
		$(window).on('scroll', function(){
			if($(window).scrollTop() > $('.module__hero-v2').offset().top && $(window).scrollTop() < $('.module__hero-v2').outerHeight() + 45) {
				$('body:not(.light-logo)').addClass('light-logo');
			}else{
				$('body.light-logo').removeClass('light-logo');
			}
		})
	}

	if($('.module__hero').length) {
		$(window).on('scroll', function(){
			if($(window).scrollTop() > $('.module__hero').offset().top && $(window).scrollTop() < $('.module__hero').outerHeight() + 45) {
				$('body:not(.light-logo)').addClass('light-logo');
			}else{
				$('body.light-logo').removeClass('light-logo');
			}
		})
	}

	if($('.bg-blue').length) {
		$(window).on('scroll', function(){
			// console.log('now');
			if($(window).scrollTop() > $('.bg-blue').offset().top && $(window).scrollTop() < $('.bg-blue').outerHeight() + 45) {
				$('body:not(.light-logo)').addClass('light-logo');
			}else{
				$('body.light-logo').removeClass('light-logo');
			}
		})
	}

    /*
	>>================================================================================>
	Lil' Search
	>>================================================================================>
	*/

	$('header.main .search-trigger').on('click', function(){
		setTimeout(function(){
			if($('body').hasClass('search-active')){
				$('#lilsearch input.search-field').focus();
			}
		}, 200);
	})

    $('.search-trigger, .close-search, #btn-search').on('click', function(e){
       e.preventDefault();
       $('body').toggleClass('search-active');
    });

    // Click outside search

    $('html').click(function(e) {
    	if($(window).width() >= 768) {
    		if (!$(e.target).parent().hasClass('search-trigger') && $(e.target).parents('#lilsearch').length == 0 && $('body').hasClass('search-active')) {
    			$('body').removeClass('search-active');
    		}
    	}
    });

    /*
	>>================================================================================>
	Module: Learn More Search
	>>================================================================================>
	*/

	function openSuggestions(){
		$('#search-block-section').addClass('active');
		$('#search-suggestion').show('slow');
		$('#search-output').addClass('active');
		clearInterval(autoSuggest);
	}

	$('#search-submit-btn').click(function(e) {
		if(!$('#search-block-section').hasClass('active')){
			openSuggestions();
		}else{
			window.location.href = $('#search-output').find('a.active').attr('href');
		}
	});

	$('#search-output').on('click', 'a', function(e){
		if(!$('#search-block-section').hasClass('active')){
			e.preventDefault();
			openSuggestions();
		}
	});

	var sugs = [];

	$('.module__learn-more-search #search-suggestion li').each(function(){
		sugs.push($(this).html());
	});

	$.each(sugs, function(key, value) {
	    $('#search-output').append(sugs[key]);
	});

	var sugNum = 0;

	function suggestionRotate(){
		sugNum++;

		if(sugNum > sugs.length) {
			sugNum = 1;
		}

		$('#search-output a.active, #search-suggestion li.active').removeClass('active');
		$('#search-output a:nth-child(' + sugNum + ')').addClass('active');
		$('#search-suggestion li:nth-child(' + sugNum + ')').addClass('active');
	}

	autoSuggest = setInterval(suggestionRotate, 3000);

	suggestionRotate();

	/*
	>>================================================================================>
	Two full width images
	>>================================================================================>
	*/

	$('.module__article-v2 img.full-width').each(function(){

		var $parent = $(this).parent(),
			$nextParent = $parent.next();

		if($nextParent.find('img.full-width').length == 1){
			$parent.add($nextParent).wrapAll('<div class="two-image-wrap" />');
		}
	});

	$('.module__article-v2 .two-image-wrap img.full-width').removeClass('full-width');

	/*-------------------------------------
	Module: Hero
	-------------------------------------*/

	$.fn.heroBanner = function(){
		var $stage = $(this),
			$content = $(this).find('.hero-content'),
			$offset = 0,
			BV;

		if($content.hasClass('video')){
			if ($isMobile == false && $windowSize == 'desktop') {
				var $mp4 = $content.data('video-mp4'),
					$webm = $content.data('video-webm'),
					$ogv = "//test.arifleet.com/ari_web_us_investment.ogg",
					$poster = $content.data('poster');
			    
			    if (!Modernizr.touch) {
			    	BV = new $.BigVideo({container: $content, useFlashForFirefox:false});
			    	BV.init();
				    BV.show([
				        { type: "video/mp4",  src: $mp4 },
				        { type: "video/webm", src: $webm },
				        { type: "video/ogg",  src: $ogv }
			    	],{ambient:true});
			    	BV.getPlayer().on('ended', function() {
			    		BV.dispose();
					});
				} 
			}
		}

		function resizeBanner(){
			if($windowSize == 'desktop'){
				
				$content.css('height','100%');  
				
				//Full height hero
				if($stage.hasClass('full-height')){
					$stage.height($.Window.height()-$('header.main').height());
					if($stage.find('.hero-text').length){
						var $minHeight = $stage.find('.hero-text').height() + 280;
						if($stage.height() < $minHeight){
							$stage.height($minHeight);
						}
					}
				}

				//Hero with "This It" text
				if($stage.find('.this-it').length){
					$offset = 84;
					$('.hero-text').css('margin-top', $offset);
				}

				//Hero with arrow
				if($('.hero-arrow').length){
					$('.hero-arrow').css('top', ($stage.height()-$('.hero-arrow').height())-115)
					.unbind().click(function(){
						$('html, body').animate({
					        scrollTop: $('section.module__hero').position().top + $('section.module__hero').height()
					    }, 500, "easeInOutExpo");
					});
					$('.hero-text').css('top', (($stage.height()/2)-($('.hero-text').height())/2)-$('.hero-arrow').height());
				}else{
					$stage.find('.hero-text').css('top', (($stage.height()/2)-($stage.find('.hero-text').height())/2));
				}
			}else{
				$stage.attr('style','');
				if($('#big-video-wrap').length){
					BV.dispose();
				}
				$stage.find('.hero-content').not('.cs').css('height', $('.hero-text').height()+200);
				$stage.find('.hero-text').not('.cs').css({
					'margin-top': 0,
					'top' : ($stage.height()/2)-($stage.find('.hero-text').height()/2)
				});
			}
		}

		$.Window.bind("load resize", function() {
			resizeBanner();
		});

		$.Window.bind("load", function() {
			$stage.addClass('hello');
		});

		$(document).ready(function() {
			resizeBanner();
		});
	};

	$(document).ready(function() {
		if($('section.module__hero.hero-case-study-details').length){
			$('section.module__hero.hero-case-study-details').each(function(){
				$(this).heroBanner();
			});
		}
	});

}(jQuery));