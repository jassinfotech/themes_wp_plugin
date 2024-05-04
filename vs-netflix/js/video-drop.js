var wpvs_trailer_background_player;
var wpvs_trailer_player_type;
var wpvs_trailer_player_video_id;
var wpvs_display_dropdown_background_timeout;
var wpvs_loading_drop_down_id;
var wpvs_is_loading_drop_down_section = false;
jQuery(document).ready(function() {
    jQuery('body').delegate('.video-slide, .video-item', 'click', function(e) {
        if(jQuery(e.target).hasClass('show-vs-drop') || jQuery(e.target).parent().hasClass('show-vs-drop')) {
            e.preventDefault();
            jQuery(this).parent().addClass('active-slide');
            var drop_label = jQuery(this).find('.show-vs-drop');
            var video_id = drop_label.data('video');
            var slide_type = drop_label.data('type');
            var parent_slider = jQuery(this).parents('.slide-category');
            var displaybox = parent_slider.next('.vs-video-description-drop');
            if( ! displaybox.hasClass('open') ) {
                displaybox.addClass('open');
                displaybox.slideDown();
            }
            vs_drop_video_details(video_id, displaybox, slide_type);
        }
    });
    if( ! vsdrop.is_mobile ) {
        jQuery('body').delegate('.video-slide, .video-item','mouseenter', function(e) {
            if( ! jQuery(this).hasClass('active-slide')) {
                jQuery('.video-slide, .video-item').removeClass('active-slide');
                jQuery(this).addClass('active-slide');
                var parent_slider = jQuery(this).parents('.slide-category');
                var displaybox = parent_slider.next('.vs-video-description-drop');
                if(displaybox.hasClass('open')) {
                    var drop_label = jQuery(this).find('.show-vs-drop');
                    var video_id = drop_label.data('video');
                    var slide_type = drop_label.data('type');
                    vs_drop_video_details(video_id, displaybox, slide_type);
                }
            }
        });
    }

     jQuery('body').delegate('.wpvs-close-video-drop','click', function() {
         var parent_drop_down = jQuery(this).parent();
         parent_drop_down.slideUp().removeClass('open');
         var parent_slick_slider = parent_drop_down.prev('.slide-category');
         if( parent_slick_slider.hasClass('active-slide') ) {
             parent_slick_slider.removeClass('active-slide');
         } else {
             parent_slick_slider.find('.active-slide').removeClass('active-slide');
         }
         wpvs_disable_drop_down_players();

    });

});

function vs_drop_video_details(videoid, displaybox, slide_type) {
    wpvs_loading_drop_down_id = videoid;
    displaybox.find('.drop-display').removeClass('active');
    var drop_box_exists = displaybox.find('[data-drop-box="'+videoid+'"]');
    wpvs_disable_drop_down_players();
    if(drop_box_exists.length > 0) {
        drop_box_exists.addClass('active');
        wpvs_load_background_trailer_player(displaybox, videoid);
    } else {
        displaybox.find('.drop-loading').show();
        var drop_down_info_request = {
            'action': 'wpvs_get_video_drop_down_details',
            'videoid': videoid,
            'slide_type': slide_type
        };

        if( typeof(wpvsapimanager) != 'undefined' && wpvsapimanager.episodes_filter ) {
            drop_down_info_request.episodes_filter = wpvsapimanager.episodes_filter;
        }
        if( ! wpvs_is_loading_drop_down_section ) {
            wpvs_is_loading_drop_down_section = true;
            jQuery.ajax({
                url: vsdrop.url,
                type: "POST",
                data: drop_down_info_request,
                success:function(response) {
                    if(response != "Missing video id" && response.length > 0) {
                        var videodetails = JSON.parse(response);
                        var video_title = videodetails.video_title;
                        var video_description = videodetails.video_description;
                        var video_details = videodetails.video_details;
                        var video_information = videodetails.video_information;
                        var video_link = videodetails.video_link;
                        var video_percent_complete = videodetails.percent_complete;

                        if(vsdrop.fullscreen && video_link) {
                            if ( (video_link.indexOf("?") > -1) || (video_link.indexOf("?page_id") > -1) ) {
                                video_link += '&';
                            } else {
                                video_link += '?';
                            }
                            video_link += 'wpvsopen=1';
                        }
                        var video_image = videodetails.video_image;
                        var video_title_image = videodetails.video_title_image;
                        var add_to_list_button = videodetails.added_to_list;
                        var new_drop_display = '<div class="drop-display';

                        if( wpvs_loading_drop_down_id == videoid ) {
                            new_drop_display += ' active';
                        }

                        new_drop_display += '" style="background-image: url('+video_image+');" data-drop-box="'+videoid+'">';

                        if( videodetails.trailer && ! vsdrop.is_mobile ) {
                            new_drop_display += '<div class="trailer-background-container border-box" data-playerid="'+videoid+'"><div class="trailer-wrapper '+videodetails.trailer.type+'">'+videodetails.trailer.html+'</div></div>';
                        }
                        new_drop_display += '<div class="vs-drop-details">';
                        if( video_title_image != "" ) {
                            new_drop_display += '<img class="video-title-image" src="'+video_title_image+'" alt="'+video_title+'" />';
                        } else {
                            new_drop_display += '<h3 class="drop-title">'+video_title+'</h3>';
                        }
                        new_drop_display += video_information+'<p class="drop-description">'+video_description+'</p><div class="drop-info">'+video_details+'</div><a href="'+video_link+'" class="button vs-drop-button vs-drop-link wpvs-play-button">';
                        if( video_percent_complete && video_percent_complete != 0 ) {
                            new_drop_display += vsdrop.resume_text;
                        } else {
                            new_drop_display += vsdrop.watchtext;
                        }
                        new_drop_display += ' <span class="dashicons dashicons-controls-play"></span></a>'+add_to_list_button+'</div><a href="'+video_link+'" class="vs-drop-link vs-drop-play-button border-box"><span class="dashicons dashicons-controls-play"></span></a>';

                        if( videodetails.episodes.length > 0 ) {
                            new_drop_display += '<div class="video-category slide-category episode-slider">';
                            new_drop_display += '<h4>'+vsdrop.more_episodes+'</h4>';
                            new_drop_display += '<div class="video-list-slider episode-slider-list" data-items="'+videodetails.episodes.length+'">';
                            jQuery(videodetails.episodes).each( function(num, episode) {
                                new_drop_display += '<a class="video-slide" href="'+episode.episode_link+'">';
                                new_drop_display += '<div class="video-slide-image border-box">';
                                if( episode.episode_image.src ) {
                                    new_drop_display += '<img src="'+episode.episode_image.src+'" alt="'+episode.episode_title+'" ';
                                    if( episode.episode_image.srcset ) {
                                        new_drop_display += 'srcset="'+episode.episode_image.srcset+'" ';
                                    }
                                    new_drop_display += '/>';
                                } else {
                                    new_drop_display += '<div class="wpvs-no-slide-image"></div>';
                                }

                                if( episode.percent_complete && episode.percent_complete != 0 ) {
                                    new_drop_display += '<span class="wpvs-cw-progress-bar border-box" style="width: '+episode.percent_complete+'%"></span>';
                                }
                                new_drop_display += '</div>';
                                new_drop_display += '<div class="video-slide-details border-box"><h4>'+episode.episode_title+'</h4></div></a>';
                            });
                            new_drop_display += '</div></div>';
                        }
                        new_drop_display += '</div>';
                        displaybox.find('.drop-loading').hide();
                        displaybox.append(new_drop_display);
                        var episode_slider = displaybox.find('.episode-slider-list');
                        if( episode_slider ) {
                            wpvs_load_inner_episode_slider(episode_slider);
                        }
                        if( videodetails.trailer && ! vsdrop.is_mobile ) {
                            wpvs_load_background_trailer_player(displaybox, videoid);
                        }

                    }
                    wpvs_is_loading_drop_down_section = false;

                },
                error: function(response) {
                    wpvs_is_loading_drop_down_section = false;
                }
            });
        }
    }
}

function wpvs_load_background_trailer_player(drop_down_section, video_id) {
    var trailer_player_box = jQuery(drop_down_section).find('.trailer-background-container[data-playerid="'+video_id+'"]').find('.wpvs-background-trailer');
    wpvs_trailer_player_type = trailer_player_box.data('player');
    wpvs_trailer_player_video_id = video_id;
    if( wpvs_trailer_player_type == 'wordpress' ) {
        wpvs_trailer_background_player = trailer_player_box[0];
        wpvs_trailer_background_player.play();
    }
    if( wpvs_display_dropdown_background_timeout ) {
        clearTimeout(wpvs_display_dropdown_background_timeout);
    }
    wpvs_display_dropdown_background_timeout = setTimeout( function() {
        wpvs_set_dropdown_background_trailer_size(drop_down_section, video_id);
    }, 1500);

}

function wpvs_disable_drop_down_players() {
    if( typeof(wpvs_trailer_background_player) != 'undefined' ) {
        if( wpvs_trailer_player_type == 'wordpress' ) {
            wpvs_trailer_background_player.pause();
        }
    }
}

function wpvs_set_dropdown_background_trailer_size(drop_down_section, video_id) {
    var wpvs_bg_trailer_container = jQuery(drop_down_section).find('.trailer-background-container[data-playerid="'+video_id+'"]');
    var wpvs_trailer_wrapper = wpvs_bg_trailer_container.find('.trailer-wrapper');
    if( wpvs_trailer_player_type == 'wordpress' ) {
        if( typeof(wpvs_trailer_background_player) != 'undefined' ) {
            if( wpvs_trailer_background_player.videoWidth < wpvs_trailer_wrapper.width() ) {
                wpvs_trailer_wrapper.addClass('stretch-trailer');
            } else {
                wpvs_trailer_wrapper.removeClass('stretch-trailer');
            }
        }
    }
    wpvs_bg_trailer_container.addClass('show-background-trailer');
}
