var video_shifted = false;
var wpvs_single_video_background_trailer_player;
var wpvs_single_trailer_player_type;

jQuery(document).ready( function() {
    vs_set_content_height();
    if( jQuery('#wpvs-single-background-trailer').length > 0 ) {
        wpvs_load_single_background_trailer_player();
    }
    
    if( typeof(wpvs_vimeo_player) != 'undefined' && wpvs_vimeo_player != null ) {
        jQuery('#vs-video-back').click(function() {
            wpvs_vimeo_player.pause();
        });
        jQuery('#vs-play-video').click(function() {
            wpvs_vimeo_player.play();
            if( typeof(wpvs_single_trailer_player_type) != 'undefined' ) {
                if( wpvs_single_trailer_player_type == 'wordpress' ) {
                    wpvs_single_video_background_trailer_player.pause();
                }
            }
        });
    }

    if( typeof(wpvs_vimeo_trailer_player) != 'undefined' && wpvs_vimeo_trailer_player != null ) {
        jQuery('#vs-video-back').click(function() {
            wpvs_vimeo_trailer_player.pause();
        });
        jQuery('#vs-play-trailer').click(function() {
            wpvs_vimeo_trailer_player.play();
            if( typeof(wpvs_single_trailer_player_type) != 'undefined' ) {
                if( wpvs_single_trailer_player_type == 'wordpress' ) {
                    wpvs_single_video_background_trailer_player.pause();
                }
            }
        });
    }

    jQuery('#vs-video-back').click(function() {
        jQuery('.vs-full-screen-video').removeClass('show-full-screen-video');
        jQuery('body').removeClass('wpvs-hide-overflow');
        if(typeof(wpvs_count_down_interval) != 'undefined' && wpvs_count_down_interval) {
            clearInterval(wpvs_count_down_interval);
            jQuery('#wpvs-autoplay-countdown').hide();
            wpvs_load_video_count_down = wpvideosinfo.timer;
            jQuery('#wpvs-autoplay-count').text(wpvs_load_video_count_down);
        }
        if( typeof(wpvs_single_trailer_player_type) != 'undefined' ) {
            if( wpvs_single_trailer_player_type == 'wordpress' && ! wpvs_single_video_data.is_mobile ) {
                wpvs_single_video_background_trailer_player.play();
            }
        }
    });

    jQuery('#vs-play-video, .wpvs-show-pricing').click(function() {
        jQuery('#rvs-trailer-video').hide();
        jQuery('#rvs-main-video').show();
        jQuery('.vs-full-screen-video').addClass('show-full-screen-video');
        jQuery('body').addClass('wpvs-hide-overflow');
    });

    jQuery('.wpvs-show-pricing').click(function() {
        var display_purchase_type = jQuery(this).data('type');
        if( display_purchase_type == 'purchase' ) {

        }
        if( display_purchase_type == 'rental' ) {

        }
    });

    jQuery('#vs-play-trailer').click(function() {
        jQuery('#rvs-main-video').hide();
        jQuery('#rvs-trailer-video').show();
        jQuery('.vs-full-screen-video').addClass('show-full-screen-video');
        jQuery('body').addClass('wpvs-hide-overflow');
    });

    if( wpvs_single_video_data.videotype == "youtube" ) {
        jQuery( document ).bind('wpvsYouTubePlayerReady', function() {
            if(typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                wpvs_youtube_player.addEventListener('onReady', 'onWPVSYouTubePlayerReady');
            }
        });

        jQuery('#vs-video-back').click(function() {
            if(typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                if(jQuery.isFunction(wpvs_youtube_player.pauseVideo)) {
                    wpvs_youtube_player.pauseVideo();
                }
            }
        });
        jQuery('#vs-play-video').click(function() {
            if(typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                if(jQuery.isFunction(wpvs_youtube_player.playVideo)) {
                    wpvs_youtube_player.playVideo();
                }
            }
        });
    }

    if( wpvs_single_video_data.trailertype == "youtube" ) {
        jQuery( document ).bind('wpvsYouTubeTrailerPlayerReady', function() {
            if(typeof(wpvs_youtube_trailer_player) != 'undefined' && wpvs_youtube_trailer_player != null) {
                wpvs_youtube_trailer_player.addEventListener('onReady', 'onWPVSYouTubeTrailerPlayerReady');
            }
        });

        jQuery('#vs-video-back').click(function() {
            if(typeof(wpvs_youtube_trailer_player) != 'undefined' && wpvs_youtube_trailer_player != null) {
                if(jQuery.isFunction(wpvs_youtube_trailer_player.pauseVideo)) {
                    wpvs_youtube_trailer_player.pauseVideo();
                }
            }
        });
        jQuery('#vs-play-trailer').click(function() {
            if(typeof(wpvs_youtube_trailer_player) != 'undefined' && wpvs_youtube_trailer_player != null) {
                if(jQuery.isFunction(wpvs_youtube_trailer_player.playVideo)) {
                    wpvs_youtube_trailer_player.playVideo();
                }
            }
        });
    }

    if(wpvs_single_video_data.videotype == "wordpress" && jQuery('#rvs-main-video .videoWrapper').length > 0) {
        var wpvs_main_video_element = jQuery('#rvs-main-video .videoWrapper video').first();
        if(typeof(wpvs_main_video_element) !== "undefined") {
            jQuery('#vs-play-video').click(function() {
                wpvs_main_video_element[0].play();
            });
            jQuery('#vs-video-back').click(function() {
                wpvs_main_video_element[0].pause();
            });
        }
    }

    if(wpvs_single_video_data.trailertype == "wordpress" && jQuery('#rvs-trailer-video .videoWrapper').length > 0) {
        var wpvs_trailer_video_element = jQuery('#rvs-trailer-video .videoWrapper video').first();
        if(typeof(wpvs_trailer_video_element) !== "undefined") {
            jQuery('#vs-play-trailer').click(function() {
                wpvs_trailer_video_element[0].play();
            });
            jQuery('#vs-video-back').click(function() {
                wpvs_trailer_video_element[0].pause();
            });
        }
    }
});

if( jQuery('#wpvs-single-background-trailer').length > 0 ) {
    jQuery(window).resize(wpvs_set_single_background_trailer_size);
}

function onWPVSYouTubePlayerReady(event) {
    jQuery('#vs-video-back').click(function() {
        event.target.pauseVideo();
    });
    jQuery('#vs-play-video').click(function() {
        event.target.playVideo();
    });
}

function onWPVSYouTubeTrailerPlayerReady(event) {
    jQuery('#vs-video-back').click(function() {
        event.target.pauseVideo();
    });
    jQuery('#vs-play-trailer').click(function() {
        event.target.playVideo();
    });
}

jQuery(window).resize(vs_set_content_height);
function vs_set_content_height() {
    var video_image = jQuery('.vs-video-header img.video-image');
    var image_width = video_image.width();
    if(wpvs_single_video_data.panning && !video_shifted) {
        if(image_width > jQuery(window).width()) {
            var change_interval = 80000;
            var image_difference = image_width - jQuery(window).width();
            if(jQuery(window).width() >= 960) {
                change_interval = 60000;
            }

            if(jQuery(window).width() >= 1200) {
                change_interval = 50000;
            }
            vs_shift_video_image(video_image, image_difference, change_interval);
        } else {
            vs_remove_shift_video_image(video_image);
        }
    }
}

function wpvs_load_single_background_trailer_player() {
    var wpvs_single_trailer_box = jQuery('#wpvs-single-background-trailer');
    var wpvs_single_trailer_player = wpvs_single_trailer_box.find('.wpvs-background-trailer');
    wpvs_single_trailer_player_type = wpvs_single_trailer_player.data('player');
    if( wpvs_single_trailer_player_type == 'wordpress' ) {
        wpvs_single_video_background_trailer_player = wpvs_single_trailer_player[0];
        wpvs_single_video_background_trailer_player.muted = true;
        wpvs_single_video_background_trailer_player.loop = false;
        wpvs_single_video_background_trailer_player.play();
        wpvs_single_video_background_trailer_player.addEventListener('ended', (event) => {
            wpvs_remove_single_background_trailer();
        });
    }
    if( typeof(wpvs_single_trailer_player_type) != 'undefined' ) {
        setTimeout( function() {
            wpvs_set_single_background_trailer_size();
            jQuery('#wpvs-single-background-trailer').addClass('show-background-trailer');
        }, 1500);
    }
}

function vs_shift_video_image(image, space, interval) {
    video_shifted = true;
    var set_timeout_int = interval / 2;
    image.css({
        'transform' : 'translateX(-'+space+'px) scale(1.2)',
        '-webkit-transform' : 'translateX(-'+space+'px) scale(1.2)',
        '-moz-transform' : 'translateX(-'+space+'px) scale(1.2)'
    });
    setTimeout(vs_remove_shift_video_image, set_timeout_int, image);
}

function vs_remove_shift_video_image(image) {
    image.css({
        'transform' : 'translateX(0) scale(1)',
        '-webkit-transform' : 'translateX(0) scale(1)',
        '-moz-transform' : 'translateX(-0) scale(1)'
    });
}

function wpvs_set_single_background_trailer_size() {
    var wpvs_trailer_wrapper = jQuery('#wpvs-single-background-trailer').find('.trailer-wrapper');
    if( wpvs_single_trailer_player_type == 'wordpress' ) {
        if( wpvs_single_video_background_trailer_player.videoWidth < jQuery('#wpvs-single-background-trailer').width() ) {
            wpvs_trailer_wrapper.addClass('stretch-trailer');
        } else {
            wpvs_trailer_wrapper.removeClass('stretch-trailer');
        }
    }
}

function wpvs_remove_single_background_trailer() {
    jQuery('#wpvs-single-background-trailer').removeClass('show-background-trailer');
    setTimeout( function() {
        jQuery('#wpvs-single-background-trailer').remove();
    }, 1500);
    delete wpvs_single_video_background_trailer_player;
    delete wpvs_single_trailer_player_type;
}
