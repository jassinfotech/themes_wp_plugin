jQuery(document).ready(function() {
    if(wpvs_theme_ajax_requests.user != null) {
        jQuery('body').delegate('.wpvs-add-to-list', 'click', function() {
            var add_to_list_button = jQuery(this);
            var video_id = add_to_list_button.data('videoid');
            var video_type = add_to_list_button.data('videotype');
            var add_video = 1;
            if(add_to_list_button.hasClass('remove')) {
                add_video = "";
                add_to_list_button.html('<span class="dashicons dashicons-update wpvs-list-spin"></span>'+wpvs_user_js_vars.list_removing_text);
            } else {
                add_to_list_button.html('<span class="dashicons dashicons-update wpvs-list-spin"></span>'+wpvs_user_js_vars.list_adding_text);
            }
            jQuery.ajax({
                url: wpvs_theme_ajax_requests.ajaxurl,
                type: "POST",
                data: {
                    'action': 'wpvs_add_video_to_user_list',
                    'video_id': video_id,
                    'video_type': video_type,
                    'add_video': add_video
                },
                success:function(response) {
                    jQuery('#wpvs-updating-box').fadeOut('fast');
                    if(add_video) {
                        add_to_list_button.html('<span class="dashicons dashicons-yes"></span>'+wpvs_user_js_vars.list_button_text).addClass('remove');
                        jQuery('.wpvs-add-to-list[data-videoid="'+video_id+'"]').each(function(index, list_button) {
                            var update_button = jQuery(this);
                            update_button.html('<span class="dashicons dashicons-yes"></span>'+wpvs_user_js_vars.list_button_text).addClass('remove');
                        });
                    } else {
                        add_to_list_button.html('<span class="dashicons dashicons-plus"></span>'+wpvs_user_js_vars.list_button_text).removeClass('remove');
                        jQuery('.wpvs-add-to-list[data-videoid="'+video_id+'"]').each(function(index, list_button) {
                            var update_button = jQuery(this);
                            update_button.html('<span class="dashicons dashicons-plus"></span>'+wpvs_user_js_vars.list_button_text).removeClass('remove');
                        });
                    }
                },
                error: function(response){
                    show_rvs_error(response.responseText);
                }
            });
        });
    } else {
        jQuery('body').delegate('.wpvs-add-to-list', 'click', function() {
            show_rvs_error(wpvs_user_js_vars.notloggedin);
            jQuery('#wpvs-updating-box').fadeIn('fast');
        });
    }
    
});