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
    $(document).ready(function ($) {
        var $container = $('.ja-testimonial-wrap'),
            $elements = $('#ja-testimonial-list').children('li'),
            maxWidthOnMobile = parseInt($('body').data('screen-md')),
            currentIndex = 0,
            lastMode = '',
            sliderDuration = 5000,
            sliderInterval = '';

        if (!maxWidthOnMobile)
            maxWidthOnMobile = 768;

        initialize = function () {
            //buid review holder
            if (!$('#ja-testimonial').length) {
                var $testimonial = $('<blockquote id="ja-testimonial" class="text-center box-center col-md-8 col-xs-12 col-sm-10"></blockquote >').appendTo($container);
                var $image = $elements.filter('.active').find('img'),
                    testimonialText = "\"" + $image.attr('alt') + "\"<br/>" + "<small>" + $image.attr('title') + "</small>"
                $testimonial.html(testimonialText);
            }
        }

        activate = function ($elem) {
            if ($elem.hasClass('active')) return;
            $elements.removeClass('active');
            $elem.addClass('active');
            var $image = $elem.find('img'),
                testimonialText = "\"" + $image.attr('alt') + "\"<br/>" + "<small>" + $image.attr('title') + "</small>";

            $('#ja-testimonial').fadeOut(300, function () {
                $(this).html(testimonialText).fadeIn(300)
            });
        }

        hoverEvent = function (e) {
            activate($(this));
        }

        initialize();

        $(window).on("load resize", function () {
            var currentMode = ($(window).width() <= maxWidthOnMobile) ? 'small_screen' : 'large_screen';
            if (currentMode != lastMode) { // has change mode
                if (currentMode == 'small_screen') {
                    //remove first interval event
                    $elements.off('hover', hoverEvent);
                    //set interval event
                    sliderInterval = setInterval(function () {
                        //update current index
                        currentIndex = (currentIndex == $elements.length - 1) ? 0 : ++currentIndex;
                        //run slide
                        activate($($elements[currentIndex]));
                    }, sliderDuration);
                } else { // on Desktop
                    //remove interval event
                    clearInterval(sliderInterval);
                    $elements.on('hover', hoverEvent);
                }
                lastMode = currentMode;
            }
        });
    });

})(jQuery);
