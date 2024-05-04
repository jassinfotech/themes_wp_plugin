var wpvs_update_time_interval = 10;
jQuery(document).ready( function() {
    if( typeof(wpvs_video_tracking) != 'undefined' && typeof(wpvs_theme_ajax_requests) != "undefined" && wpvs_theme_ajax_requests.user != null ) {

        if(wpvs_video_tracking.video_type == 'vimeo' ) {
            if( typeof(wpvs_vimeo_player) != 'undefined' && wpvs_vimeo_player != null ) {
                wpvs_vimeo_player.on('timeupdate', function(data) {
                    if(data.seconds >= wpvs_update_time_interval && wpvs_update_time_interval != 0 ) {
                        wpvs_update_users_current_video_time(data.seconds, data.duration);
                    }
                });

                wpvs_vimeo_player.on('loaded', function(data) {
                    if(wpvs_video_tracking.start_at != null) {
                        wpvs_vimeo_player.setCurrentTime(wpvs_video_tracking.start_at);
                    }
                });

                wpvs_vimeo_player.on('ended', function(data) {
                    if(data.seconds >= wpvs_update_time_interval && wpvs_update_time_interval != 0 ) {
                        wpvs_update_users_current_video_time(data.seconds, data.duration);
                    }
                });
            }
        }

        if(wpvs_video_tracking.video_type == "wordpress") {

            if( jQuery('#rvs-main-video .videoWrapper').length > 0 ) {
                var wpvs_main_video = jQuery('#rvs-main-video .videoWrapper video').first()[0];
            }

            if( jQuery('#wpvs-main-video').length > 0 ) {
                var wpvs_main_video = jQuery('#wpvs-main-video video').first()[0];
            }

            if(typeof(wpvs_main_video) !== 'undefined') {
                wpvs_main_video.addEventListener('timeupdate', function() {
                    if( wpvs_main_video.currentTime >= wpvs_update_time_interval && wpvs_update_time_interval != 0 ) {
                        wpvs_update_users_current_video_time(wpvs_main_video.currentTime, wpvs_main_video.duration);
                    }
                });

                wpvs_main_video.addEventListener('loadedmetadata', function() {
                    if(wpvs_video_tracking.start_at != null) {
                        wpvs_main_video.currentTime = wpvs_video_tracking.start_at;
                    }
                });

                wpvs_main_video.addEventListener('ended', function() {
                    wpvs_update_users_current_video_time(wpvs_main_video.duration, wpvs_main_video.duration);
                });
            }
        }

        if(wpvs_video_tracking.video_type == "youtube") {
            if( typeof(wpvs_youtube_player) != 'undefined' && wpvs_youtube_player != null) {
                if(wpvs_video_tracking.start_at != null) {
                    wpvs_youtube_player.addEventListener('onReady', function(event) {
                        wpvs_youtube_player.seekTo(wpvs_video_tracking.start_at);
                    });
                }

                wpvs_youtube_player.addEventListener('onStateChange', function(event) {
                    if(wpvs_youtube_player.getCurrentTime() >= wpvs_update_time_interval && wpvs_update_time_interval != 0 ) {
                        wpvs_update_users_current_video_time(wpvs_youtube_player.getCurrentTime(), wpvs_youtube_player.getDuration());
                    }

                    if( event.data == 0 ) {
                        wpvs_update_users_current_video_time(wpvs_youtube_player.getDuration(), wpvs_youtube_player.getDuration());
                    }
                });
            }
        }
    }
});

function wpvs_update_users_current_video_time(current_time, video_length) {
    wpvs_update_time_interval = current_time + 10;
    var wpvs_ajax_action = 'wpvs_add_video_continue_watching_list';
    if( (video_length - current_time) <= 10 ) {
        wpvs_ajax_action = 'wpvs_remove_video_continue_watching_list';
    }
    jQuery.ajax({
        url: wpvs_theme_ajax_requests.ajaxurl,
        type: "POST",
        data: {
            'action': wpvs_ajax_action,
            'video_id': wpvs_video_tracking.current_video_id,
            'video_current_time': current_time,
            'video_length': video_length
        },
        success:function(response) {
        },
        error: function(response) {
            wpvs_update_time_interval = 0;
        }
    });
}

function wpvs_run_jw_player_created_events() {
    if( typeof(wpvs_jw_player) != 'undefined' && wpvs_jw_player != null ) {
        var wpvs_jw_player_seek_played = false;
        wpvs_jw_player.on('time', function(data) {
            if(data.position >= wpvs_update_time_interval && wpvs_update_time_interval != 0 ) {
                wpvs_update_users_current_video_time(data.position, data.duration);
            }
        });

        wpvs_jw_player.on('play', function(data) {
            if(wpvs_video_tracking.start_at != null && ! wpvs_jw_player_seek_played ) {
                wpvs_jw_player_seek_played = true;
                wpvs_jw_player.seek(wpvs_video_tracking.start_at);
            }
        });

        wpvs_jw_player.on('complete', function(data) {
            wpvs_update_users_current_video_time(10, 10); // removes from continue watching
            if(wpvs_video_tracking.autoplay && typeof(wpvs_load_next_video) == 'function') {
                wpvs_load_next_video();
            }
        });
    }
}
