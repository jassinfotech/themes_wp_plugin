var wpvs_trailer_code_mirror_editor;
var wpvs_trailer_code_js_mirror_editor;
jQuery(document).ready( function() {

    if( jQuery('#custom-trailer-code').parent().find('.CodeMirror').length > 0) {
        wpvs_trailer_code_mirror_editor = jQuery('#custom-trailer-code').parent().find('.CodeMirror')[0].CodeMirror;
    }

    if( jQuery('#wpvs-custom-trailer-js-code').parent().find('.CodeMirror').length > 0) {
        wpvs_trailer_code_js_mirror_editor = jQuery('#wpvs-custom-trailer-js-code').parent().find('.CodeMirror')[0].CodeMirror;
    }

    jQuery('#select-trailer-type').change( function() {
        var trailer_type = jQuery(this).val();
        jQuery('.rvs-trailer-type-area').removeClass('rvs-display-area');
        if(trailer_type == "vimeo") {
            jQuery('#trailer-vimeo-type-option').addClass('rvs-display-area');
            if(jQuery('#wpvs_vimeo_trailer_id').val() !== "") {
                wpvs_set_vimeo_trailer_iframe(jQuery('#wpvs_vimeo_trailer_id').val());
            }
        }

        if(trailer_type == "wordpress") {
            jQuery('#trailer-wordpress-type-option').addClass('rvs-display-area');
        }

        if(trailer_type == "youtube") {
            jQuery('#trailer-youtube-type-option').addClass('rvs-display-area');
            var set_trailer_url = jQuery('#trailer-youtube-video-url').val();
            if(set_trailer_url != "") {
                rvs_set_youtube_trailer(set_trailer_url);
            }
        }

        if(trailer_type == "custom" || trailer_type == "jwplayer") {
            jQuery('#trailer-custom-type-option').addClass('rvs-display-area');
            var custom_trailer_code = jQuery('textarea#custom-trailer-code');

            var set_iframe_code = custom_trailer_code.val();
            if(set_iframe_code != "") {
                jQuery('#rvs-trailer-video-holder').html(set_iframe_code);
                jQuery('#new-trailer-html').val(set_iframe_code);
            }
            if(custom_trailer_code.parent().find('.CodeMirror').length <= 0) {
                wp.codeEditor.initialize( "custom-trailer-code", jQuery.parseJSON(wpvstrailerpost.code_mirror_trailer_html) );
                wp.codeEditor.initialize( "wpvs-custom-trailer-js-code", jQuery.parseJSON(wpvstrailerpost.code_mirror_trailer_js) );
                wpvs_trailer_code_mirror_editor = custom_trailer_code.parent().find('.CodeMirror')[0].CodeMirror;
                wpvs_trailer_code_js_mirror_editor = jQuery('#wpvs-custom-trailer-js-code').parent().find('.CodeMirror')[0].CodeMirror;
            }
        }

        if(trailer_type == "jwplayer") {
            jQuery('#wpvs-jw-player-trailer-media-id-input').removeClass('rvs-hidden-code');
            jQuery('#trailer-jwplayer-type-option').addClass('rvs-display-area');
        } else {
            jQuery('#wpvs-jw-player-trailer-media-id-input').addClass('rvs-hidden-code');
            jQuery('#trailer-jwplayer-type-option').removeClass('rvs-display-area');
        }
    });

    if(jQuery('#select-trailer-type').val() == 'youtube' && jQuery('#trailer-youtube-video-url').val() != "" && jQuery('#new-trailer-html').val() == "") {
        var youtube_link = jQuery('#trailer-youtube-video-url').val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            rvs_set_youtube_trailer(u_youtube_link);
        }
    }

    jQuery('input#wpvs_vimeo_trailer_id').keyup(function() {
        wpvs_set_vimeo_trailer_iframe(jQuery(this).val());
    });

    jQuery('input#trailer-youtube-video-url').keyup(function() {
        var youtube_link = jQuery(this).val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            rvs_set_youtube_trailer(u_youtube_link);
        }
    });

    wpvs_create_trailer_code_mirror_events();

    setTimeout(function() {
        wpvs_refresh_code_mirror_trailer_editors();
    },500);

});

function wpvs_create_trailer_code_mirror_events() {
    if( typeof(wpvs_trailer_code_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_mirror_editor.on('change', function() {
            var custom_trailer_html = wpvs_trailer_code_mirror_editor.getValue();
            jQuery('#rvs-trailer-video-holder').html(custom_trailer_html);
            jQuery('#custom-trailer-code').val(custom_trailer_html);
            jQuery('#new-trailer-html').val(custom_trailer_html);

        });
    }

    if( typeof(wpvs_trailer_code_js_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_js_mirror_editor.on('change', function() {
            var custom_trailer_js = wpvs_trailer_code_js_mirror_editor.getValue();
            jQuery('#wpvs-custom-trailer-js-code').html(custom_trailer_js);
        });
    }
}

function wpvs_refresh_code_mirror_trailer_editors() {
    if( typeof(wpvs_trailer_code_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_mirror_editor.refresh();
    }
    if( typeof(wpvs_trailer_code_js_mirror_editor) != 'undefined' ) {
        wpvs_trailer_code_js_mirror_editor.refresh();
    }
}


function wpvs_set_vimeo_trailer_iframe(vimeo_id) {
    var set_vimeo_trailer_html = '<div id="wpvs-vimeo-trailer" class="wpvs-vimeo-video-player" data-vimeo-id="'+vimeo_id+'"></div>';
    jQuery('#rvs-trailer-video-holder').html(set_vimeo_trailer_html);
    jQuery('#new-trailer-html').val(set_vimeo_trailer_html);
    wpvs_display_vimeo_trailer();
}

function rvs_set_youtube_trailer(youtube_url) {
    var youtube_style = jQuery('#wpvs-theme-youtube-url-params').val();
    var new_youtube = wpvs_get_youtube_id(youtube_url);
    if(new_youtube != "error") {
        new_youtube += youtube_style;
        var youtube_html = '<iframe class="wpvs-youtube-trailer-player" width="560" height="315" src="//www.youtube.com/embed/'
        + new_youtube + '" frameborder="0" allowfullscreen="" allow="autoplay"></iframe>';
        jQuery('#rvs-trailer-video-holder').html(youtube_html).show();
        jQuery('#new-trailer-html').val(youtube_html).html(youtube_html);
    }
}

function wpvs_display_vimeo_trailer() {
    wpvs_vimeo_trailer = new Vimeo.Player('wpvs-vimeo-trailer');
}
