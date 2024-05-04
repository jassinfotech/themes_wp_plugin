class WPVS_Theme_Video_API_Manager {

    constructor() {
        this.video_offset = 0;
        this.videos_per_page = 18;
        this.video_terms_added = [];
        this.video_list_width = 0;
        this.videos_loaded = false;
        this.missing_image_timeout;
    }

    set_video_list_width(width) {
        this.video_list_width = width;
        if(this.video_list_width < 768) {
            this.videos_per_page = 18;
        }
        if(this.video_list_width >= 768) {
            this.videos_per_page = 33;
        }
        if(this.video_list_width >= 1200) {
            this.videos_per_page = 44;
        }
        if(this.video_list_width >= 1400) {
            this.videos_per_page = 60;
        }
    }

    check_load_position() {
        if(jQuery('#wpvs-load-more-marker').length > 0) {
            var window_height = jQuery(window).height();
            var load_location = jQuery('#wpvs-load-more-marker').offset().top;
            var check_load_position = load_location - jQuery(window).scrollTop();
            if(check_load_position <= (window_height) && ! this.videos_loaded) {
                this.videos_loaded = true;
                this.request_videos();
            }
        }
    }

    wpvs_create_grid_items() {
        if(jQuery('#video-list-loaded').length > 0) {
            this.set_video_list_width(jQuery('#video-list-loaded').width());
        } else {
            this.set_video_list_width(jQuery(window).width());
        }
        var items_per_grid = wpvsapimanager.count.mobile;
        if(this.video_list_width >= 600) {
            items_per_grid = wpvsapimanager.count.tablet;
        }
        if(this.video_list_width >= 960) {
            items_per_grid = wpvsapimanager.count.laptop;
        }
        if(this.video_list_width >= 1200) {
            items_per_grid = wpvsapimanager.count.desktop;
        }
        if(this.video_list_width >= 1600) {
            items_per_grid = wpvsapimanager.count.large;
        }

        var last_video_grid = jQuery('.video-item-grid').last();
        var last_video_grid_count = last_video_grid.find('.video-item').length;

        if( last_video_grid_count ) {
            while(last_video_grid_count < items_per_grid ) {
                jQuery('#video-list .video-item').first().remove().clone().appendTo(last_video_grid);
                last_video_grid_count++;
            }
        }

        var video_items = jQuery('#video-list .video-item');

        jQuery('#video-list-loaded').data('items-per-row', items_per_grid).attr('items-per-row', items_per_grid);
        for(var i = 0; i < video_items.length; i+= parseInt(items_per_grid) ) {
          video_items.slice(i, i+items_per_grid).wrapAll('<div class="video-item-grid slide-category"></div>');
        }
        if(wpvsapimanager.dropdown) {
            jQuery('#video-list .video-item-grid').after('<div class="vs-video-description-drop browse-drop border-box"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>');
        }
        this.wpvs_show_video_list();
    }

    wpvs_reset_grid_items() {
        if(this.video_list_width != jQuery(window).width()) {
            this.set_video_list_width(jQuery(window).width());
            jQuery('.vs-video-description-drop').remove();
            if(jQuery('#video-list-loaded').length > 0) {
                this.set_video_list_width(jQuery('#video-list-loaded').width());
            }
            var items_per_grid = wpvsapimanager.count.mobile;
            if(this.video_list_width >= 600) {
                items_per_grid = wpvsapimanager.count.tablet;
            }
            if(this.video_list_width >= 960) {
                items_per_grid = wpvsapimanager.count.laptop;
            }
            if(this.video_list_width >= 1200) {
                items_per_grid = wpvsapimanager.count.desktop;
            }
            if(this.video_list_width >= 1600) {
                items_per_grid = wpvsapimanager.count.large;
            }

            jQuery('#video-list-loaded .video-item').unwrap();
            jQuery('#video-list-loaded').data('items-per-row', items_per_grid).attr('items-per-row', items_per_grid);
            var video_items = jQuery('#video-list-loaded .video-item');
            for(var i = 0; i < video_items.length; i+= parseInt(items_per_grid) ) {
              video_items.slice(i, i+items_per_grid).wrapAll('<div class="video-item-grid slide-category"></div>');
            }
            if(wpvsapimanager.dropdown) {
                if( jQuery('#video-list-container').length > 0 ) {
                    jQuery('#video-list-container .slide-category').after('<div class="vs-video-description-drop browse-drop border-box"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>');
                }
                if( jQuery('#video-list-loaded').length > 0 ) {
                    jQuery('#video-list-loaded .slide-category').after('<div class="vs-video-description-drop browse-drop border-box"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>');
                }
            }
            this.set_missing_image_heights();
        }
    }

    wpvs_show_video_list() {
         if(jQuery('#loading-video-list').length > 0) {
            jQuery('#loading-video-list').fadeOut('slow').remove();
            jQuery('#video-list-loaded').delay(600).fadeIn('slow');
         }
         jQuery('#video-list').contents().unwrap();
         jQuery('#video-list-loaded').append('<div id="wpvs-load-more-marker"></div>');
         this.set_missing_image_heights();
    }

    set_request_param(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }

    request_videos() {
        var wpvs_requester = this;
        jQuery('#wpvs-load-more-marker').remove();
        if(jQuery('#video-list').length < 1) {
            jQuery('#video-list-loaded').append('<div id="video-list"></div>');
        }

        var wpvs_term_request_url = wpvsapimanager.url;

        wpvs_term_request_url = this.set_request_param(wpvsapimanager.url, 'per_page', this.videos_per_page);
        if( this.video_offset && this.video_offset > 0 ) {
            wpvs_term_request_url = this.set_request_param(wpvs_term_request_url, 'offset', this.video_offset);
        }

        if( this.video_terms_added.length > 0 ) {
            wpvs_term_request_url = this.set_request_param(wpvs_term_request_url, 'exclude_terms', this.video_terms_added);
        }

        if( wpvsapimanager.video_id ) {
            wpvs_term_request_url = this.set_request_param(wpvs_term_request_url, 'video_id', wpvsapimanager.video_id);
        }

        if( wpvsapimanager.season_ids ) {
            wpvs_term_request_url = this.set_request_param(wpvs_term_request_url, 'wpvsgenres', wpvsapimanager.season_ids);
        }

        if( wpvsapimanager.userid ) {
            wpvs_term_request_url = this.set_request_param(wpvs_term_request_url, 'userid', wpvsapimanager.userid);
        }

        jQuery.ajax({
            url: wpvs_term_request_url,
            type: "GET",
            success:function(wpvs_videos) {
                if( wpvs_videos.length > 0 ) {
                    var add_to_list = "";
                    jQuery.each(wpvs_videos, function(index, video) {
                        if( ! wpvsapimanager.season_ids && ! wpvsapimanager.is_season && video.series && video.series.id ) {
                            if( video.series && video.series.id && ( jQuery.inArray(video.series.id, wpvs_requester.video_terms_added) > -1 ) ) {
                                wpvs_requester.video_offset++;
                                return;
                            }
                        }
                        add_to_list += wpvs_requester.create_video_item(video, video.wpvs_type);
                        wpvs_requester.video_offset++;
                    });
                    jQuery('#video-list').append(add_to_list);
                    wpvs_requester.videos_loaded = false;
                    if( wpvs_videos.length < wpvs_requester.videos_per_page) {
                        wpvs_requester.videos_loaded = true
                    }
                    if(wpvs_videos.added && wpvs_videos.added.length > 0) {
                        jQuery.each(wpvs_videos.added, function(index, term) {
                            if (jQuery.inArray(term, wpvs_requester.video_terms_added) < 0) {
                                wpvs_requester.video_terms_added.push(term);
                            }
                        });
                    }
                } else {
                    wpvs_requester.videos_loaded = true
                }
                wpvs_requester.wpvs_create_grid_items();
            },
            error: function(response){
            }
        });
    }

    create_video_item(item, wpvs_type) {
        var item_title;
        var item_description;
        var item_link;
        var item_id;
        var item_thumbnail;
        var item_image_srcset;
        var item_thumbnail_label;
        if( ! wpvsapimanager.season_ids && ! wpvsapimanager.is_season && item.series && item.series.id ) {
            item_id = item.series.id;
            item_title = item.series.name;
            item_description = item.series.description;
            item_description = item_description.replace(/(<([^>]+)>)/gi, "");
            item_description = '<p>'+item_description+'</p>';
            item_link = item.series.link;
            if( item.series.images.thumbnail ) {
                item_thumbnail = item.series.images.thumbnail;
            }
            if( item.series.images.srcset ) {
                item_image_srcset = item.series.images.srcset;
            }
            wpvs_type = 'show';
            if( jQuery.inArray(item.series.id, this.video_terms_added) == -1 ) {
                this.video_terms_added.push(item.series.id);
            }
        } else {
            item_link = item.link;
            item_id = item.id;
            if( item.images ) {
                if( item.images.thumbnail ) {
                    item_thumbnail = item.images.thumbnail;
                }
                if( item.images.srcset ) {
                    item_image_srcset = item.images.srcset;
                }
                if( item.images.thumbnail_label ) {
                    item_thumbnail_label = item.images.thumbnail_label;
                }
            }
            if( wpvs_type == 'show' ) {
                item_title = item.name;
                item_description = item.description;
                item_description = item_description.replace(/(<([^>]+)>)/gi, "");
                item_description = '<p>'+item_description+'</p>';
                if( jQuery.inArray(item.id, this.video_terms_added) == -1 ) {
                    this.video_terms_added.push(item.id);
                }
            }

            if( wpvs_type == 'video' ) {
                item_title = item.title.rendered;
                item_description = item.excerpt.rendered;
            }
        }

        var open_new_tab = (item.new_tab == 1) ? 'target="_blank"' : '';
        var new_item_html = "";
        new_item_html += '<a class="video-item border-box" href="'+item_link+'" '+open_new_tab+'><div class="video-item-content"><div class="video-slide-image border-box">';
        if( item_thumbnail && typeof(item_thumbnail) != 'undefined' ) {
            new_item_html += '<img loading="lazy" src="'+item_thumbnail+'" alt="'+item_title+'" ';
            if( item_image_srcset ) {
                new_item_html += 'srcset="'+item_image_srcset+'" ';
            }
            new_item_html += '/>';
        } else {
            new_item_html += '<div class="wpvs-no-slide-image"></div>';
        }
        if( item.user_data ) {
            if( item.user_data.percentage_complete && item.user_data.percentage_complete != 0 ) {
                new_item_html += '<span class="wpvs-cw-progress-bar border-box" style="width: '+item.user_data.percentage_complete+'%"></span>';
            }
        }
        if( item_thumbnail_label && typeof(item_thumbnail_label) != 'undefined' ) {
            new_item_html += '<span class="wpvs-thumbnail-text-label border-box">'+item_thumbnail_label+'</span>';
        }
        if(wpvsapimanager.dropdown) {
            new_item_html += '<label class="show-vs-drop ease3" data-video="'+item_id+'" data-type="'+wpvs_type+'"><span class="dashicons dashicons-arrow-down-alt2"></span></label>';
        }
        new_item_html += '</div>';
        new_item_html += '<div class="video-slide-details border-box"><h4>'+item_title+'</h4>'+item_description+'</div>';

        if( item.user_data ) {
            if(item.user_data.download_link && item.user_data.download_link != "") {
                new_item_html += '<label class="wpvs-video-download-link" data-download="'+item.user_data.download_link+'" download><span class="dashicons dashicons-download"></span></label>';
            }
            if(item.user_data.rental_time_left && item.user_data.rental_time_left != "") {
                new_item_html += '<label class="rental-time-left border-box">'+item.user_data.rental_time_left+' '+wpvsapimanager.hourstext+'</label>';
            }
        }

        new_item_html += '</div>';
        new_item_html += '</a>';
        return new_item_html;
    }

    set_missing_image_heights() {
        if( jQuery('.wpvs-no-slide-image').length > 0 ) {
            if( this.missing_image_timeout ) {
                clearTimeout(this.missing_image_timeout);
            }
            this.missing_image_timeout = setTimeout( function() {
                var set_missing_image_slide_height;
                if( jQuery('.video-slide-image img').length > 0 ) {
                    set_missing_image_slide_height = jQuery('.video-slide-image img').first().height();
                } else {
                    set_missing_image_slide_height = 150;
                }
                jQuery('.wpvs-no-slide-image').css({'height': set_missing_image_slide_height});
            }, 1200);
        }
    }
}

wpvs_theme_api_manager = new WPVS_Theme_Video_API_Manager();
jQuery(document).ready( function() {
    if(jQuery('#loading-video-list').length > 0) {
        wpvs_theme_api_manager.set_video_list_width(jQuery('#loading-video-list').width());
        wpvs_theme_api_manager.request_videos();
    }
});
jQuery(window).scroll(function(){wpvs_theme_api_manager.check_load_position()});
jQuery(window).resize(function(){wpvs_theme_api_manager.wpvs_reset_grid_items()});
