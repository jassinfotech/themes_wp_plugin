var wpvs_search_videos_ajax;
var wpvs_search_videos_timeout;

jQuery(document).ready( function() {
    jQuery('.wpvs-search-slide-video').keyup( function() {
        clearTimeout(wpvs_search_videos_timeout);
        if(wpvs_search_videos_ajax && typeof(wpvs_search_videos_ajax) != 'undefined') {
            wpvs_search_videos_ajax.abort();
        }
        jQuery('.wpvs-found-video-list').html('').hide();
        var search_title = jQuery(this).val();
        var found_box = jQuery(this).next('.wpvs-found-video-list');
        wpvs_search_videos_timeout = setTimeout(function() {
            wpvs_search_slide_videos(search_title, found_box)
        }, 800);
    });
    
    jQuery('body').delegate('.select-video-as-slide', 'click', function() {
        var selected_video = jQuery(this);
        var found_box = selected_video.parent();
        var new_video_title = selected_video.data('title');
        var new_video_id = selected_video.data('videoid');
        var new_video_link = selected_video.data('link');
        var current_editing = selected_video.parents('.homeBlockEdit');
        var update_title = current_editing.find('.homeTitle');
        var update_image_alt = current_editing.find('.imageAlt');
        var update_video_id = current_editing.find('.wpvs-set-video-id');
        var update_link = current_editing.find('.link');
        update_title.val(new_video_title);
        update_image_alt.val(new_video_title);
        update_link.val(new_video_link);
        update_video_id.val(new_video_id);
        if( selected_video.data('image').length > 0 ) {
            var new_slide_image = selected_video.data('image');
            var update_image_input = current_editing.find('.upload-url');
            var update_image_preview = current_editing.find('.changeImage');
            update_image_input.val(new_slide_image);
            update_image_preview.attr('src', new_slide_image);
        }
        found_box.hide();
        
    });
    
    jQuery('.wpvs-set-video').click(function() {
        var set_button = jQuery(this);
        var current_editing = set_button.parents('.homeBlockEdit');
        current_editing.find('.wpvs-select-background-video').slideDown();
    });

    jQuery('input').keypress(function(event){

        if (event.keyCode == 10 || event.keyCode == 13) {
            event.preventDefault();
        }
    });

    jQuery('#addNewSection').click( function() {

        var newSection = jQuery("#newBlockSection").val();

        jQuery.ajax({
            url: ajaxurl,
            async: false,
            data: {
                'action':'newblocksection_ajax_request',
                'sectionId' : newSection
            },
            success:function(data) {
                window.location.reload(true);
            },
            error: function(errorThrown){
            }
        });
    });

    jQuery('.deleteSection').click( function() {
        if(window.confirm('Are you sure you want to delete this slider?')) {
            var newSection = jQuery(this).parents('.rogueDynamicSlider').find(".sectionNumber").val();
            jQuery.ajax({
                url: ajaxurl,
                async: false,
                data: {
                    'action':'deleteblocksection_ajax_request',
                    'sectionId' : newSection
                },
                success:function(data) {
                    window.location.reload(true);
                },
                error: function(errorThrown){
                }
            });
        }
    });

    jQuery('.addNewBlock, #wpvs-add-new-slide').click( function() {

        var homeBlockId = jQuery(this).parents('.rogueDynamicSlider').find('.sectionCount').val();
        var newSection = jQuery(this).parents('.rogueDynamicSlider').find('.sectionNumber').val();

        jQuery.ajax({
            url: ajaxurl,
            async: false,
            data: {
                'action':'block_ajax_request',
                'homeBlockId' : homeBlockId,
                'sectionId' : newSection
            },
            success:function(data) {
                window.location.reload(true);
            },
            error: function(errorThrown){
            }
        });
    });

    jQuery('.rogue-edit-slider').click( function() {
        jQuery(this).parent().css('max-height', 'none');
        jQuery(this).hide();
    });


    jQuery('.button-delete').click( function() {
        if(window.confirm('Are you sure you want to delete this slide?')) {
            var editing_block = jQuery(this).parents('.homeBlockEdit');
            var homeBlockId = editing_block.attr('id');
            var newSection = jQuery(this).parents('.rogueDynamicSlider').find('.sectionNumber').val();

            jQuery.ajax({
                url: ajaxurl,
                async: false,
                data: {
                    'action':'deleteblock_ajax_request',
                    'homeBlockId' : homeBlockId,
                    'sectionId' : newSection
                },
                success:function(data) {
                    window.location.reload(true);
                },
                error: function(errorThrown){
                }
            });
        }
    });

    jQuery('.button-save').click( function() {
        var editing_slide = jQuery(this).parents('.homeBlockEdit');

        var thisSave = editing_slide.find('.saving-slider-block');
        thisSave.html('Saving...').fadeIn();

        var homeBlockId = editing_slide.attr('id');

        var homeBlockImage = editing_slide.find('.upload-url').val();

        var homeBlockImageAlt = editing_slide.find('.imageAlt').val();

        var homeBlockTitle = editing_slide.find('.homeTitle').val();

        var homeBlockDescription = editing_slide.find('.slideDescription').val();

        var homeBlockLinkText = editing_slide.find('.slideLinkText').val();
        
        var homeBlockButtonSize = editing_slide.find('.wpvs-slide-button-size').val();

        var homeBlockLink = editing_slide.find('.link').val();
        
        var homeBlockAlign = editing_slide.find('.select-alignment').val();

        var homeBlockTab = editing_slide.find('input.newTab');

        var homeBlockWhole = editing_slide.find('input.wholeslide');
        
        var wpvs_slide_video_id = editing_slide.find('input.wpvs-set-video-id').val();
        
        var wpvs_slide_video_url = editing_slide.find('input.slide-video-url').val();
        
        var wpvs_slide_background_type = editing_slide.find('input.wpvs-slide-background-type').val();
        
        var wpvs_slide_youtube_url = editing_slide.find('input.set-slide-trailer-youtube').val();
        
        var wpvs_slide_youtube_id = editing_slide.find('input.set-slide-youtube-id').val();
        
        var wpvs_slide_vimeo_url = editing_slide.find('input.set-slide-trailer-vimeo').val();
        
        var wpvs_slide_vimeo_id = editing_slide.find('input.set-slide-vimeo-id').val();
        
        var wpvs_slide_video_muted = editing_slide.find('input.set-slide-muted-video');
        
        var wpvs_slide_video_aspect_ratio = editing_slide.find('select.set-video-aspect-ratio').val();
        
        var wpvs_custom_iframe_code = editing_slide.find('.set-slide-custom-iframe').val();
        
        var wpvs_mute_slide = 0;
        if(wpvs_slide_video_muted.is(':checked')) {
            wpvs_mute_slide = 1;
        }

        homeBlockTitle = homeBlockTitle.replace(/'/g, "`");

        if(homeBlockTab.is(':checked')) {
            homeBlockTab = 1;
        } else {
            homeBlockTab = 0;
        }

        if(homeBlockWhole.is(':checked')) {
            homeBlockWhole = 1;
        } else {
            homeBlockWhole = 0;
        }

        var newSection = jQuery(this).parents('.rogueDynamicSlider').find('.sectionNumber').val();

        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action':'saveblock_ajax_request',
                'homeBlockId' : homeBlockId,
                'homeBlockImage' : homeBlockImage,
                'homeBlockImageAlt' : homeBlockImageAlt,
                'homeBlockTitle' : homeBlockTitle,
                'homeBlockDescription' : homeBlockDescription,
                'homeBlockLinkText' : homeBlockLinkText,
                'homeBlockLink' : homeBlockLink,
                'homeBlockButtonSize': homeBlockButtonSize,
                'homeBlockAlign': homeBlockAlign,
                'homeBlockTab' : homeBlockTab,
                'homeBlockWhole' : homeBlockWhole,
                'sectionId' : newSection,
                'videoId': wpvs_slide_video_id,
                'video_url': wpvs_slide_video_url,
                'background_type': wpvs_slide_background_type,
                'youtube_url': wpvs_slide_youtube_url,
                'youtube_id': wpvs_slide_youtube_id,
                'vimeo_url':  wpvs_slide_vimeo_url,
                'vimeo_id': wpvs_slide_vimeo_id,
                'mute': wpvs_mute_slide,
                'aspect_ratio': wpvs_slide_video_aspect_ratio,
                'custom_iframe': wpvs_custom_iframe_code
            },
            success:function(data) {
                thisSave.html('Saved').fadeOut();
            },
            error: function(errorThrown){
                thisSave.html('Erroe').fadeOut();
            }
        });
    });
    
    jQuery('.wpvs-button-hide').click( function() {
        var editing_slide = jQuery(this).parents('.homeBlockEdit');
        editing_slide.css('max-height', '220px').find('.rogue-edit-slider').show();
        jQuery('html, body').animate({
            scrollTop: (editing_slide.offset().top - 50)
        }, 800);
    });

    jQuery('.sliderTitle').keyup( function() {
        jQuery(this).parent().find('.saveTitle').fadeIn();
    });

    jQuery('.saveTitle').click( function() {

        jQuery(this).html('Saving...');
        jQuery('#wpvs-update-text').html('Saving...');
        jQuery('#makingChanges').fadeIn('fast');
        var newTitle = jQuery(this).parent().find('.sliderTitle').val();

        newTitle = newTitle.replace(/'/g, "`");

        var newSection = jQuery(this).parents('.rogueDynamicSlider').find('.sectionNumber').val();

        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action':'newslidertitle_ajax_request',
                'sectionId' : newSection,
                'newTitle' : newTitle
            },
            success:function(data) {
                jQuery('.saveTitle').html('Save Title');
                jQuery('.saveTitle').fadeOut();
                jQuery('#makingChanges').fadeOut('fast');
            },
            error: function(errorThrown){
                jQuery('#makingChanges').fadeOut('fast');
            }
        });
    });
    
    jQuery('.save-slider-settings').click( function(e) {
        var save_settings_button = jQuery(this);
        save_settings_button.html('Saving...');
        var new_max_height = jQuery(this).parent().find('.slider-max-height').val();
        var newSection = jQuery(this).parents('.rogueDynamicSlider').find('.sectionNumber').val();
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action':'wpvs_slider_settings_ajax_request',
                'sectionId' : newSection,
                'new_max_height' : new_max_height
            },
            success:function(data) {
                save_settings_button.html('Saved!');
                setTimeout( function() {
                    save_settings_button.html('Save Settings');
                }, 500 );
            },
            error: function(errorThrown){
                save_settings_button.html('Save Settings');
            }
        });
    });

    jQuery('.selectPage').change( function() {
        var thisSelect = jQuery(this);
        thisSelect.parent().parent().find("input.link").val(thisSelect.find(":selected").val());

        var titleUpdate = thisSelect.find(":selected").text();
        thisSelect.parent().parent().find('.imageContain .homeTitle').val(titleUpdate);
        var current_editing = thisSelect.parents('.homeBlockEdit');
        var update_video_id = current_editing.find('.wpvs-set-video-id');
        update_video_id.val('');
    });
    
    if( jQuery('.wpvs-featured-area-sort').length > 0 ) {
        jQuery('.wpvs-featured-area-sort').sortable({
            update: function(event, ui) {
                var slide_container = jQuery(this);
                var ordered_items = slide_container.sortable('toArray');
                var slider_id = slide_container.parent('.rogueDynamicSlider').find('.sectionNumber').val();
                wpvs_update_featured_area_slides_order(slider_id, ordered_items);

            }
        });
    }
});

function wpvs_search_slide_videos(video_title, found_video_box) {
    found_video_box.html('<label class="wpvs-searching-label border-box"><span class="dashicons dashicons-search wpvs-search-ani"></span>Searching...').show();
    wpvs_search_videos_ajax = jQuery.ajax({
		url: ajaxurl,
		data: {
			'action':'wpvs_slide_video_title_search_ajax_request',
			'videotitle' : video_title,
		},
		success:function(data) {
            if(data == "novideos") {
                found_video_box.html('<label>No videos found</label>').show();
            } else {
                var found_videos = JSON.parse(data);
                var add_to_list = "";
                
                if(found_videos.length > 0) {
                    jQuery.each(found_videos, function(index, video) {
                        add_to_list += '<label class="select-video-as-slide" data-link="'+video.video_link+'" data-videoid="'+video.video_id+'" data-title="'+video.video_title+'" data-image="'+video.video_header+'">'+video.video_title+'</label>';
                    });
                    found_video_box.html(add_to_list).show();
                } else {
                    found_video_box.html('<label>No videos found</label>').show();
                }
            }
		},
		error: function(error){
            
		}
	});
}

function wpvs_update_featured_area_slides_order(slider_id, slide_item_ids) {
    if( slider_id != "" && slide_item_ids.length > 0) {
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                'action':'wpvs_update_featured_area_order',
                'slider_id' : slider_id,
                'slide_order' : slide_item_ids,
            },
            success:function(data) {
            },
            error: function(errorThrown){
                
            }
        });
    }
}