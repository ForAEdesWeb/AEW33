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
(function($){
    $(document).ready(function($){
        playVideo = function(){
            var $embed = $('.video-shuffle').find('iframe');
            var src = $embed.attr('src') + '?autoplay=1&html5=1&showinfo=0';
            var autoEmbed = '<iframe src="' + src + '" width="'+$embed.attr('width')+'" height="'+$embed.attr('height')+'" frameborder="0" allowfullscreen></iframe>';
            $('.box-video').prepend(autoEmbed).fadeIn(300, function(){
                $('html').css("overflow", "hidden");
            });
        }

        // Close video
        closeVideo = function(){
            $('.box-video').fadeOut(100, function() {
                $('iframe', this).remove().fadeOut(200);
                $('html').css("overflow", "auto");
            });
        }

        // Handle to open
        $('.play-video').on('click', function(e) {
            playVideo();
            e.preventDefault();
        });

        //handle event to close video
        $('.close-video').on('click', function(e) {
            closeVideo();
        });
        $(document).on('keyup', function(e) {
            if(e.keyCode == 27)
                closeVideo();
        });

    });

})(jQuery);

