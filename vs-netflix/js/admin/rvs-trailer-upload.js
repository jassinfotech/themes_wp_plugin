var trailer_uploader = null;
jQuery(document).ready(function() {
    jQuery('#choose-wordpress-trailer').click( function( event ) {
        wpvs_upload_trailer_video();
    });
});
function wpvs_upload_trailer_video() {
    trailer_uploader = wp.media({
        frame:    'select',
        library: {
            type: ['video']
        },
        button: {
            text: 'Select video'
        },
        multiple:  false
    });
    trailer_uploader.on( 'select', function() {
        // We set multiple to false so only get one image from the uploader
        var video_details = trailer_uploader.state().get('selection').first().toJSON();
        var video_type = video_details.subtype;
        if(video_type == "quicktime") {
            alert('Please try another video type.');
            trailer_uploader.open();
        } else {
            var video_id = video_details.id;
            var video_width = video_details.width;
            var video_height = video_details.height;
            var video_src = video_details.url;
            var video_shortcode = '[video width="'+video_width+'" height="'+video_height+'" '+video_type+'="'+video_src+'"][/video]';
            jQuery('#rvs-trailer-wordpress-id').val(video_id);
            jQuery('#rvs-trailer-wordpress-code').html(video_shortcode);
            wpvs_create_video_html('trailer',video_src, video_width, video_height, video_type);
        }
    });
    trailer_uploader.open();
}