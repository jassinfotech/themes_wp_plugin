var trailer_select = false;
var wpvs_video_code_mirror_editor;
var wpvs_video_code_js_mirror_editor;
jQuery(document).ready( function() {
    if( jQuery('#custom-video-code').parent().find('.CodeMirror').length > 0) {
        wpvs_video_code_mirror_editor = jQuery('#custom-video-code').parent().find('.CodeMirror')[0].CodeMirror;
    } else {
        wp.codeEditor.initialize( "custom-video-code", jQuery.parseJSON(wpvsvideopost.code_mirror_video_html) );
        wpvs_video_code_mirror_editor = jQuery('#custom-video-code').parent().find('.CodeMirror')[0].CodeMirror;
    }

    if( jQuery('#wpvs-custom-video-js-code').parent().find('.CodeMirror').length > 0) {
        wpvs_video_code_js_mirror_editor = jQuery('#wpvs-custom-video-js-code').parent().find('.CodeMirror')[0].CodeMirror;
    } else {
         wp.codeEditor.initialize( "wpvs-custom-video-js-code", jQuery.parseJSON(wpvsvideopost.code_mirror_video_js) );
         wpvs_video_code_js_mirror_editor = jQuery('#wpvs-custom-video-js-code').parent().find('.CodeMirror')[0].CodeMirror;
    }

    jQuery('#select-video-type').change( function() {
        var video_type = jQuery(this).val();
        jQuery('.rvs-type-area').removeClass('rvs-display-area');
        if(video_type == "vimeo") {
            jQuery('#vimeo-type-option').addClass('rvs-display-area');
            if(jQuery('#wpvs_video_vimeo_id').val() !== "") {
                wpvs_set_vimeo_html(jQuery('#wpvs_video_vimeo_id').val());
            }
        }

        if(video_type == "wordpress") {
            jQuery('#wordpress-type-option').addClass('rvs-display-area');
        }

        if(video_type == "youtube") {
            jQuery('#youtube-type-option').addClass('rvs-display-area');
            var set_iframe_url = jQuery('#youtube-video-url').val();
            if(set_iframe_url != "") {
                rvs_set_youtube_iframe(set_iframe_url);
            }
        }

        if(video_type == "custom" || video_type == "jwplayer") {
            jQuery('#custom-type-option').addClass('rvs-display-area');
            if(video_type == "jwplayer") {
                jQuery('#jwplayer-type-option').addClass('rvs-display-area');
            }
            var custom_textarea = jQuery('textarea#custom-video-code');
            var set_iframe_code = custom_textarea.val();
            if(set_iframe_code != "") {
                jQuery('#currentRVSVideo').html(set_iframe_code);
            }
        }

        if(video_type == "jwplayer") {
            jQuery('#wpvs-jw-player-media-id-input').removeClass('rvs-hidden-code');
        } else {
            jQuery('#wpvs-jw-player-media-id-input').addClass('rvs-hidden-code');
        }

        if(video_type == "shortcode") {
            jQuery('#shortcode-type-option').addClass('rvs-display-area');
        }
    });

    if(jQuery('#select-video-type').val() == 'youtube' && jQuery('#youtube-video-url').val() != "" && jQuery('#new-video-html').val() == "") {
        var youtube_link = jQuery('#youtube-video-url').val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            rvs_set_youtube_iframe(u_youtube_link);
        }
    }

    jQuery('input#wpvs_video_vimeo_id').keyup(function() {

        wpvs_set_vimeo_html(jQuery(this).val());

    });

    jQuery('input#youtube-video-url').keyup(function() {
        var youtube_link = jQuery(this).val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            rvs_set_youtube_iframe(u_youtube_link);
        }
    });

    wpvs_create_code_mirror_events();

    setTimeout(function() {
        wpvs_refresh_code_mirror_editors();
    },500);

});

function wpvs_create_code_mirror_events() {
    if( typeof(wpvs_video_code_mirror_editor) != 'undefined' ) {
        wpvs_video_code_mirror_editor.on('change', function() {
            var custom_video_html = wpvs_video_code_mirror_editor.getValue();
            jQuery('#currentRVSVideo').html(custom_video_html);
            jQuery('#custom-video-code').val(custom_video_html);
        });
    }
    if( typeof(wpvs_video_code_js_mirror_editor) != 'undefined' ) {
        wpvs_video_code_js_mirror_editor.on('change', function() {
            var custom_video_js = wpvs_video_code_js_mirror_editor.getValue();
            jQuery('#wpvs-custom-video-js-code').html(custom_video_js);
        });
    }
}

function wpvs_refresh_code_mirror_editors() {
    if( typeof(wpvs_video_code_mirror_editor) != 'undefined' ) {
        wpvs_video_code_mirror_editor.refresh();
    }
    if( typeof(wpvs_video_code_js_mirror_editor) != 'undefined' ) {
        wpvs_video_code_js_mirror_editor.refresh();
    }
}

function wpvs_get_youtube_id(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}

function wpvs_set_vimeo_html(vimeo_id) {
    var set_vimeo_html_code = '<div id="wpvs-vimeo-video" class="wpvs-vimeo-video-player" data-vimeo-id="'+vimeo_id+'"></div>';
    jQuery('#currentRVSVideo').html(set_vimeo_html_code);
    jQuery('#new-video-html').val(set_vimeo_html_code);
    wpvs_display_vimeo_player();
}

function rvs_set_youtube_iframe(youtube_url) {
    var youtube_style = jQuery('#wpvs-theme-youtube-url-params').val();
    var new_youtube = wpvs_get_youtube_id(youtube_url);
    if(new_youtube != "error") {
        new_youtube += youtube_style;
        var youtube_html = '<iframe class="wpvs-youtube-video-player" width="560" height="315" src="//www.youtube.com/embed/'
        + new_youtube + '" frameborder="0" allowfullscreen="" allow="autoplay"></iframe>';
        jQuery('#currentRVSVideo').html(youtube_html).show();
        jQuery('#new-video-html').val(youtube_html).html(youtube_html);
    }
}

function wpvs_display_vimeo_player() {
    wpvs_vimeo_player = new Vimeo.Player('wpvs-vimeo-video');
}
