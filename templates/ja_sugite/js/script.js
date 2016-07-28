/**
 * ------------------------------------------------------------------------
 * JA Sugite Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */
(function ($) {
	//moible video helper 
	$.fn.mobileVideo = function (element) {
		return this.each(function () {

			var orgvideo = this,
				video = document.createElement('video'),
				image = document.createElement('img'),
				loaded = false,
				videoplayed = function () {
					video.play();

					if (loaded) {
						$(document).off('touchstart', videoplayed);
					}
				},
				onresize = function () {
					video.width = window.innerWidth;
					video.height = window.innerWidth * (video.videoHeight || 9) / (video.videoWidth || 16);
				};

			video.src = $(orgvideo).find('source[type="video/mp4"]').attr('src'); //mp4 is fine
			video.poster = orgvideo.poster;
			video.preload = orgvideo.preload;
			video.loop = orgvideo.loop;

			$(video).addClass('mobile-video').insertAfter(orgvideo);
			$(orgvideo).remove();

			$(image).css({
				position: 'absolute',
				top: '0',
				left: '0',
				width: window.innerWidth,
				height: (window.innerWidth * 9 / 16)
			}).attr('src', video.poster).insertAfter(video);

			$(video).on('loadeddata play', function () {
				loaded = true;

				//remove it
				$(image).remove();
			});

			//mobile device required user interaction
			$(document).on('touchstart', videoplayed);

			//autoplay if possible
			video.load();
			video.play();

			//resize when
			$(window).on('resize orientationchange', function () {
				setTimeout(onresize, 200)
			});
			onresize();
		})
	};

})(jQuery);


(function ($) {

	$(document).ready(function ($) {
 
    
		//Check div message show
		if ($("#system-message").children().length) {
			$("#system-message-container").show();
			$("#system-message a.close").click(function () {
				setTimeout(function () {
					if (!$("#system-message").children().length) $("#system-message-container").hide();
				}, 100);
			});
		} else {
			$("#system-message-container").hide();
		}

		//inview events
		$('.row-feature').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
			if (visible) {
				if (visiblePartY == 'bottom' || visiblePartY == 'both') {
					if(!$(this).hasClass('section-mask')){
						$(this).addClass('inview');
					}
				}
			}
		});

	});
})(jQuery);


(function($) {

    var scrollLastPos = 0,
        scrollDir = 0, // -1: up, 1: down
        scrollTimeout = 0;
	$(window).on ('scroll', function (e) {
        var st = $(this).scrollTop();
        //Determines up-or-down scrolling
        if (st < 1) {
            if (scrollDir != 0) {
                scrollDir = 0;
                scrollToggle();
            }
        } else if (st > scrollLastPos){
            //Replace this with your function call for downward-scrolling
            if (scrollDir != 1) {
                scrollDir = 1;
                scrollToggle();
            }
        } else if (st < scrollLastPos){
            //Replace this with your function call for upward-scrolling
            if (scrollDir != -1) {
                scrollDir = -1;
                scrollToggle();
            }
        }
        //Updates scroll position
        scrollLastPos = st;
    });

    $('.ja-header').on ('hover', function () {
        $('html').removeClass ('scrollDown scrollUp').addClass ('hover');
        scrollDir = 0;
    })

    scrollToggle = function () {
        $('html').removeClass ('hover');
        if (scrollDir == 1) {
            $('html').addClass ('scrollDown').removeClass ('scrollUp');
        } else if (scrollDir == -1) {
            $('html').addClass ('scrollUp').removeClass ('scrollDown');
        } else {
            $('html').removeClass ('scrollUp scrollDown');
        }
		$('html').addClass ('animating');
		setTimeout(function(){ $('html').removeClass ('animating'); }, 1000);
    }

})(jQuery);

// Tab
(function($){
  $(document).ready(function(){
    if($('.nav.nav-tabs').length > 0){
      $('.nav.nav-tabs a').click(function (e) {
                      e.preventDefault();
                      $(this).tab('show');
                  })
     }
  });
})(jQuery);

//Portfolio page - Used JQuery Isotope & infinitescroll
(function($){
    // Modified Isotope methods for gutters in masonry
    $.Isotope.prototype._getMasonryGutterColumns = function() {
        var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;

        containerWidth = this.element.width();

        this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
            // Or use the size of the first item
            this.$filteredAtoms.outerWidth(true) ||
            // If there's no items, use size of container
            containerWidth;

        this.masonry.columnWidth += gutter;

        this.masonry.cols = Math.floor((containerWidth + gutter) / this.masonry.columnWidth);
        this.masonry.cols = Math.max(this.masonry.cols, 1);
    };

    $.Isotope.prototype._masonryReset = function() {
        // Layout-specific props
        this.masonry = {};
        // FIXME shouldn't have to call this again
        this._getMasonryGutterColumns();
        var i = this.masonry.cols;
        this.masonry.colYs = [];
        while (i--) {
            this.masonry.colYs.push(0);
        }
    };

    $.Isotope.prototype._masonryResizeChanged = function() {
        var prevSegments = this.masonry.cols;
        // Update cols/rows
        this._getMasonryGutterColumns();
        // Return if updated cols/rows is not equal to previous
        return (this.masonry.cols !== prevSegments);
    };
})(jQuery);
(function($){
	$(document).ready(function(){
		//Checking div grid.blog - used only Portfolio page 
        if($('.ja-masonry-wrap').find('.grid').length > 0){
            //isotope grid
            var $container = $('.grid.blog'),
                paginfo = $('#page-next-link'),
                nextbtn = $('#infinity-next'),
                gutter = parseInt(T3JSVars.gutter),
				iOS = parseFloat(('' + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent) || [0,''])[1]).replace('undefined', '3_2').replace('_', '.').replace('_', '')) || false;
                firstLoad = function(){
                    if(!(nextbtn.attr('data-fixel-infinity-end') || nextbtn.attr('data-fixel-infinity-done'))){
                        nextbtn.removeClass('hidden');
                    }
                },
                pathobject = {
                    init: function(link){
                        var pagenext = $('#page-next-link'),
                            fromelm = false;
                        if(!link) {
                            fromelm = true;
                            link = pagenext.attr('href') || '';
                        }
                        this.path = link;
                        var match = this.path.match(/((page|limitstart|start)[=-])(\d*)(&*)/i);
                        if(match){
                            this.type = match[2].toLowerCase();
                            this.number = parseInt(match[3]);
                            this.limit = this.type == 'page' ? 1 : this.number;
                            this.number = this.type == 'page' ? this.number : 1;
                            this.init = 0;
                            var limit = parseInt(pagenext.attr('data-limit')),
                                init = parseInt(pagenext.attr('data-start'));
                            if(isNaN(limit)){
                                limit = 0;
                            }
                            if(isNaN(init)){
                                init = 0;
                            }
                            if(fromelm && this.limit != limit && (this.type == 'start' || this.type == 'limitstart')){
                                this.init = Math.max(0, init);
                                this.number = 1;
                                this.limit = limit;
                            }

                        } else {
                            this.type = 'unk';
                            this.number = 2;
                            this.path = this.path + (this.path.indexOf('?') == -1 ? '?' : '') + 'start=';
                        }

                        var urlparts = this.path.split('#');
                        if(urlparts[0].indexOf('?') == -1){
                            urlparts[0] += '?tmpl=component';
                        } else {
                            urlparts[0] += '&tmpl=component';
                        }

                        this.path = urlparts.join('#');
                    },

                    join: function(){
                        if(pathobject.type == 'unk'){
                            return pathobject.path + pathobject.number++;
                        } else{
                            return pathobject.path.replace(/((page|limitstart|start)[=-])(\d*)(&*)/i, '$1' + (pathobject.init + pathobject.limit * pathobject.number++) + '$4');
                        }
                    }
                },
                colWidth = function () {
                    var w = $container.width(),
                        columnNum = 1,
                        columnWidth = 0;
                    if ($(window).width() > 1200) {
                        columnNum  = T3JSVars.itemlg;
                    } else if ($(window).width() >= 992) {
                        columnNum  = T3JSVars.itemmd;
                    } else if ($(window).width() >= 768) {
                        columnNum  = T3JSVars.itemsm;
                    } else if ($(window).width() >= 480) {
                        columnNum  = T3JSVars.itemsmx;
                    }else{
                        columnNum  = T3JSVars.itemxs;
                    }
                    columnWidth = Math.floor((w - gutter*(columnNum-1))/columnNum);

                    $container.find('.item').each(function() {
                        var $item = $(this),
                            $itemimg = $item.find('img'),
							columnw = $item.attr('class').match(/item-w(\d)/),
                            multiplier_w = columnw?((columnw[1] > columnNum) ? columnNum : columnw[1]):'',
							
							roww = $item.attr('class').match(/item-h(\d)/),
                            multiplier_h = roww?((roww[1] > columnNum) ? columnNum : roww[1]):'',
							
                            width = multiplier_w ? (columnWidth*multiplier_w)+gutter*(multiplier_w-1) : columnWidth,
                            height = multiplier_h ? columnWidth*multiplier_h +gutter*(multiplier_h-1) : columnWidth;
                        
                        $item.css({
                            width: width,
                            height: height+gutter
                        });
                        //Set item article height
                        $item.find('article').css({
                            height: height
                        });

                        //add maxwidth or maxheight
                        if($itemimg.length >0){
                            $itemimg.each(function(){
                                //Remove all style before add
                                $(this).removeAttr('style');
								if($container.hasClass('grid-list')){
									$(this).css("max-height","100%");
								}else{
                                    (width/height ) > ($(this).prop('naturalWidth')/$(this).prop('naturalHeight'))?$(this).css("max-width","100%"):$(this).css("max-height","100%");
								}
                            });
                        }
						if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || iOS) {
							// some code..
							$item.find('.item-desc').css('display','block');
						}
                    });
                    return columnWidth;
                },
                isotope = function(){
                    $container.isotope({
                        resizable: true,
                        layoutMode : 'masonry',
                        itemSelector: '.item',
                        masonry: {
                            columnWidth: colWidth(),
                            gutterWidth : gutter
                        },
                        animationEngine:'jQuery',
                        animationOptions: {
                            duration: 500,
                            easing: 'linear',
                            queue: false
                        }
                    },firstLoad());
                };

            pathobject.init();

            $container.infinitescroll({
                    navSelector  : '#page-nav',    // selector for the paged navigation
                    nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
                    itemSelector : '.item',     // selector for all items you'll retrieve
                    loading: {
                        finished: function(){
                            $('#infscr-loading').remove();
                        },
                        finishedMsg: T3JSVars.finishedMsg,
                        img: T3JSVars.tplUrl + '/images/ajax-load.gif',
                        msgText : '',
                        speed : 'fast',
                        start: undefined
                    },
                    state: {
                        isDuringAjax: false,
                        isInvalidPage: false,
                        isDestroyed: false,
                        isDone: false, // For when it goes all the way through the archive.
                        isPaused: false,
                        currPage: 0
                    },
                    pathParse: pathobject.join,
                    path: pathobject.join,
                    binder: $(window), // used to cache the selector for the element that will be scrolling
                    extraScrollPx: 150,
                    dataType: 'html',
                    appendCallback: true,
                    bufferPx: 350,
                    debug : false,
                    errorCallback: function () {
                        nextbtn.addClass('disabled').html(T3JSVars.finishedMsg);
                    },
                    prefill: false, // When the document is smaller than the window, load data until the document is larger or links are exhausted
                    maxPage: parseInt(nextbtn.attr('data-page-total')) // to manually control maximum page (when maxPage is undefined, maximum page limitation is not work)
                },
                // call Isotope as a callback
                function( items ) {
                    $container.isotope( 'appended', $( items ) );
                    if((items.length < parseInt(paginfo.attr('data-limit') || nextbtn.attr('data-limit') || 0)) || (parseInt(paginfo.attr('data-total')) == $container.find('.item.isotope-item').length)){
                        nextbtn.addClass('disabled').html(T3JSVars.finishedMsg);
                    }
                    //update disqus if needed
                    if(typeof DISQUSWIDGETS != 'undefined'){
                        DISQUSWIDGETS.getCount();
                    }
                    isotope();
            });

            isotope();

            $(window).unbind('.infscr');

            $(window).smartresize(isotope);
            //Next click
			var btnEvent = 'ontouchstart' in document.documentElement ? 'touchstart' : 'click';
            if(nextbtn.length){
                nextbtn.on(btnEvent, function(){
                    if(!nextbtn.hasClass('finished')){
                        $container.infinitescroll('retrieve');
                    }
                    return false;
                });
            }
        }	
	});
})(jQuery)

