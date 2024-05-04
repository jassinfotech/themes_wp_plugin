var wpvs_user_video_muted;
var wpvs_current_slide;
jQuery(document).ready(function($) {
    wpvs_user_video_muted = wpvs_get_user_muted_setting('wpvsmuted');
    var wpvs_slide_show_speed = parseInt(wpvsslider.speed);
    var flexslider_options;
    if(wpvs_slide_show_speed > 0) {
        flexslider_options = {
            slideshowSpeed: wpvs_slide_show_speed,
            pauseOnHover: wpvsslider.pause_on_hover
        };
    } else {
        flexslider_options = {
            slideshow: false
        };
    }

    flexslider_options.start = function(slider) {
        if(typeof(slider.slides) != 'undefined') {
            wpvs_play_featured_slide_video(slider.slides.eq(slider.currentSlide));
            wpvs_current_slide = slider.slides.eq(slider.currentSlide);
        } else {
            var wpvs_single_slide = jQuery('.wpvs-flexslider ul.slides li');
            wpvs_single_slide.addClass('flex-active-slide');
            wpvs_play_featured_slide_video(wpvs_single_slide);
            wpvs_current_slide = wpvs_single_slide;
        }
        wpvs_set_current_slide_height(wpvs_current_slide);
    };

    flexslider_options.before = function(slider) {
        wpvs_stop_featured_slide_video(slider.slides.eq(slider.currentSlide));
    };

    flexslider_options.after = function(slider) {
        wpvs_play_featured_slide_video(slider.slides.eq(slider.currentSlide));
        wpvs_current_slide = slider.slides.eq(slider.currentSlide);
        wpvs_set_current_slide_height(wpvs_current_slide);
    };

    $('.wpvs-flexslider').flexslider(flexslider_options);

    jQuery('body').delegate('.wpvs-slide-mute-button', 'click', function() {
        wpvs_set_user_muted_setting('wpvsmuted', '', -1);
        var slide_mute_button = jQuery(this);
        if(slide_mute_button.hasClass('muted')) {
            wpvs_set_user_muted_setting('wpvsmuted', '0', 1);
            wpvs_play_featured_slide_video(wpvs_current_slide);
        } else {
            wpvs_set_user_muted_setting('wpvsmuted', '1', 1);
            wpvs_play_featured_slide_video(wpvs_current_slide);
        }
    });
});

jQuery(window).resize(function(){wpvs_set_current_slide_height(wpvs_current_slide)});

function wpvs_play_featured_slide_video(current_slide) {
    var slide_content = current_slide.find('.wpvs-video-flex-container');
    var video_muted = parseInt(slide_content.data('muted'));
    if(slide_content.hasClass('youtube')) {
        var slide_youtube_player;
        if( ! slide_content.data('youtubeplayer') ) {
            var youtube_id = slide_content.data('videoid');
            var set_player_id = 'youtube-'+youtube_id;
            var wpvs_youtube_iframe = slide_content.find('iframe');
            wpvs_youtube_iframe.attr('id', set_player_id);
            if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
                window.onYouTubeIframeAPIReady = function() {
                slide_youtube_player = new YT.Player(set_player_id, {
                    events: {
                      'onReady': onPlayerReady
                    }
                });
              };
              jQuery.getScript('//www.youtube.com/iframe_api');
            } else {
                slide_youtube_player = new YT.Player(set_player_id, {
                    events: {
                      'onReady': onPlayerReady
                    }
                });
            }

            function onPlayerReady(event) {
                if(current_slide.hasClass('flex-active-slide')) {
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                    event.target.mute();
                    event.target.playVideo();
                }
                slide_content.data('youtubeplayer', slide_youtube_player);
            }
        } else {
            slide_youtube_player = slide_content.data('youtubeplayer');
            if(wpvs_user_video_muted != "") {
                if(wpvs_user_video_muted == 1) {
                    slide_youtube_player.mute();
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                } else {
                    slide_youtube_player.unMute();
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeon"></span>').removeClass('muted');
                }
            } else {
                if(video_muted == 1) {
                    slide_youtube_player.mute();
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                }
            }
            slide_youtube_player.playVideo();
        }
    }

    if(slide_content.hasClass('vimeo')) {
        var slide_vimeo_player;
        if( ! slide_content.data('vimeoplayer') ) {
            var vimeo_id = slide_content.data('videoid');
            var set_player_id = 'vimeo-'+vimeo_id;
            var vimeo_options = {
                id: vimeo_id,
                autoplay: true,
                byline: false,
                portrait: false,
                title: false
            }
            slide_vimeo_player = new Vimeo.Player(slide_content, vimeo_options);
            slide_content.data('vimeoplayer', slide_vimeo_player);
            slide_vimeo_player.setCurrentTime(0);
        } else {
            slide_vimeo_player = slide_content.data('vimeoplayer');
        }

        if(current_slide.hasClass('flex-active-slide')) {
            if(wpvs_user_video_muted != "") {
                if(wpvs_user_video_muted == 1) {
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                    slide_vimeo_player.setVolume(0);
                } else {
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeon"></span>').removeClass('muted');
                    slide_vimeo_player.setVolume(1);
                }
            } else {
                if(video_muted == 1) {
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                    slide_vimeo_player.setVolume(0);
                } else {
                    slide_vimeo_player.setVolume(1);
                    current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeon"></span>').removeClass('muted');
                }
            }
        }

        slide_vimeo_player.play();
    }

    if(slide_content.hasClass('video')) {
        var slide_video_element = slide_content.find('video');
        var slide_video_player = slide_video_element[0];
        if(wpvs_user_video_muted != "") {
            if(wpvs_user_video_muted == 1) {
                current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                slide_video_element.prop('muted', true);
            } else {
                current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeon"></span>').removeClass('muted');
                slide_video_element.prop('muted', false);
            }
        } else {
            if(video_muted == 1) {
                current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeoff"></span>').addClass('muted');
                slide_video_element.prop('muted', true);
            } else {
                current_slide.find('.wpvs-slide-mute-button').html('<span class="dashicons dashicons-controls-volumeon"></span>').removeClass('muted');
                slide_video_element.prop('muted', false);
            }
        }
        slide_video_player.play();
    }
}

function wpvs_stop_featured_slide_video(current_slide) {
    var slide_content = current_slide.find('.wpvs-video-flex-container');
    if(slide_content.hasClass('youtube')) {
        var slide_youtube_player = slide_content.data('youtubeplayer');
        if(typeof(slide_youtube_player) != 'undefined') {
            slide_youtube_player.pauseVideo();
        }
    }

    if(slide_content.hasClass('vimeo')) {
        var slide_vimeo_player = slide_content.data('vimeoplayer');
        slide_vimeo_player.pause();
    }

    if(slide_content.hasClass('video')) {
        var slide_video_player = slide_content.find('video')[0];
        slide_video_player.pause();
    }

}

function wpvs_set_user_muted_setting(cname, cvalue, cdays) {
    var mute_set_time = new Date();
    mute_set_time.setTime(mute_set_time.getTime() + (cdays*24*60*60*1000));
    var mute_expires = "expires="+ mute_set_time.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + mute_expires + ";path=/";
    wpvs_user_video_muted = cvalue;
}

function wpvs_get_user_muted_setting(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function wpvs_set_current_slide_height(container) {
    if(container && jQuery(window).width() >= 960 ) {
        var set_slide_height = 0;
        if( container.find('.wpvs-video-flex-container').length > 0) {
            set_slide_height = container.find('.wpvs-video-flex-container').outerHeight();
        }
        if(set_slide_height > 0) {
            container.css('height', set_slide_height);
        }
    } else {
        var set_slide_padding = 0;
        if( container.find('.wpvs-video-flex-container').length > 0) {
            set_slide_padding = container.find('.wpvs-video-flex-container').outerHeight();
        }
        if(set_slide_padding > 0) {
            var slide_content_area = container.find('.wpvs-featured-slide-content');
            slide_content_area.css('padding-top', set_slide_padding);
        }
    }
}
