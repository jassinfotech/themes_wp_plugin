jQuery(document).ready(function() {
    var frame;
    jQuery('.upload_button').click( function(){
        
        var upload_button = jQuery(this);
        var targetfield = upload_button.prev('.upload-url');
        var updateimage = upload_button.parent().prev().find('.changeImage');
        var updating_slide = upload_button.parents('.homeBlockEdit');

        // If the media frame already exists, reopen it.
        if ( frame ) {
          frame.remove();
        } 
        frame = wp.media({
            title: 'Choose An Image',
            button: {
            text: 'Select',
            },
            library: {
                type: ['image']
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });
        

        frame.on( 'select', function() { 
            var new_image_url = "";
            attachment = frame.state().get('selection').first().toJSON();
            if(attachment.sizes['wpvs-theme-header']) {
                new_image_url = attachment.sizes['wpvs-theme-header'].url;
            }
            if( new_image_url == "" && attachment.sizes.header) {
                new_image_url = attachment.sizes.header.url;
            }
            
            if(new_image_url == "") {
                new_image_url = attachment.url;
            }
            targetfield.val(new_image_url);
            updateimage.attr('src', new_image_url);
            updating_slide.find('.wpvs-slide-background-type').val('image');
            updating_slide.find('.imageContain').show();
            updating_slide.find('.wpvs-video-contain').hide();
        });

        // Finally, open the modal
        frame.open();
    });
    
    jQuery('.set-slide-wordpress-video').click( function() {
        var updating_slide = jQuery(this).parents('.homeBlockEdit');
        wpvs_slide_upload_video(updating_slide);
    });
    
    jQuery('input.set-slide-trailer-youtube').focusout(function() {
        var updating_slide = jQuery(this).parents('.homeBlockEdit');
        var youtube_link = jQuery(this).val();
        var u_youtube_link = youtube_link.split("&")[0];
        jQuery(this).val(u_youtube_link);
        if(u_youtube_link != "") {
            wpvs_set_slide_youtube_iframe(u_youtube_link, updating_slide);
        }
    });
    
    jQuery('input.set-slide-trailer-vimeo').focusout(function() {
        var updating_slide = jQuery(this).parents('.homeBlockEdit');
        var vimeo_link = jQuery(this).val();
        if(vimeo_link  != "") {
            wpvs_set_slide_vimeo_iframe(vimeo_link, updating_slide);
        }
    });
    
    jQuery('textarea.set-slide-custom-iframe').focusout(function() {
        var updating_slide = jQuery(this).parents('.homeBlockEdit');
        var custom_html = jQuery(this).val();
        if(custom_html != "") {
            wpvs_set_slide_custom_iframe(custom_html, updating_slide);
        }
    });
});

function wpvs_slide_upload_video(updating_slide) {
    var wpvs_video_uploader;
    if ( wpvs_video_uploader ) {
      wpvs_video_uploader.remove();
    } 
    wpvs_video_uploader = wp.media({
        frame:    'select',
        library: {
            type: ['video']
        },
        button: {
            text: 'Select video'
        },
        multiple:  false
    });
    wpvs_video_uploader.on( 'select', function() {
        // We set multiple to false so only get one image from the uploader
        var video_details = wpvs_video_uploader.state().get('selection').first().toJSON();
        var video_type = video_details.subtype;
        if(video_type == "quicktime") {
            alert('Please try another video type.');
            wpvs_video_uploader.open();
        } else {
            var video_id = video_details.id;
            var video_width = video_details.width;
            var video_height = video_details.height;
            var video_src = video_details.url;
            var video_html = '<video width="'+video_details.width+'" height="'+video_details.height+'" preload="metadata" autoplay="on" muted><source type="video/mp4" src="'+video_src+'"></video>';
            updating_slide.find('.slide-video-url').val(video_src);
            updating_slide.find('.imageContain').hide();
            updating_slide.find('.wpvs-video-contain').html(video_html).show();
            updating_slide.find('.wpvs-slide-background-type').val('video');
            updating_slide.find('input.set-slide-trailer-vimeo').val('');
            updating_slide.find('.set-slide-vimeo-id').val('');
            updating_slide.find('input.set-slide-trailer-youtube').val('');
            updating_slide.find('.set-slide-youtube-id').val('');
            
        }
    });
    wpvs_video_uploader.open();
}

function wpvs_set_slide_youtube_iframe(youtube_url, updating_slide) {
    var new_youtube = wpvs_get_youtube_slide_id(youtube_url);
    if(new_youtube != "error") {
        var new_youtube_url = '//www.youtube.com/embed/' + new_youtube + '?controls=0&showinfo=0&rel=0&enablejsapi=1&playlist='+new_youtube;
        var youtube_html = '<iframe width="410" height="220" src="'+new_youtube_url+'" frameborder="0" allowfullscreen></iframe>';
        updating_slide.find('.imageContain').hide();
        updating_slide.find('.wpvs-video-contain').html(youtube_html).show();
        updating_slide.find('.set-slide-youtube-id').val(new_youtube);
        updating_slide.find('.wpvs-slide-background-type').val('youtube');
        updating_slide.find('input.set-slide-trailer-vimeo').val('');
        updating_slide.find('textarea.set-slide-custom-iframe').val('');
        updating_slide.find('.set-slide-vimeo-id').val('');
    }
}

function wpvs_get_youtube_slide_id(url) { 
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}

function wpvs_set_slide_vimeo_iframe(vimeo_url, updating_slide) {
    var set_vimeo_id = wpvs_get_vimeo_slide_id(vimeo_url);
    if(set_vimeo_id != "error") {
        var new_vimeo_url = 'https://player.vimeo.com/video/' + set_vimeo_id + '?background=1';
        var vimeo_html = '<iframe width="410" height="220" src="'+new_vimeo_url+'" frameborder="0" allowfullscreen></iframe>';
        updating_slide.find('.imageContain').hide();
        updating_slide.find('.wpvs-video-contain').html(vimeo_html).show();
        updating_slide.find('.set-slide-vimeo-id').val(set_vimeo_id);
        updating_slide.find('.wpvs-slide-background-type').val('vimeo');
        updating_slide.find('input.set-slide-trailer-youtube').val('');
        updating_slide.find('textarea.set-slide-custom-iframe').val('');
        updating_slide.find('.set-slide-youtube-id').val('');
    }
}

function wpvs_set_slide_custom_iframe(custom_html, updating_slide) {
    updating_slide.find('.imageContain').hide();
    updating_slide.find('.wpvs-video-contain').html(custom_html).show();
    updating_slide.find('.wpvs-slide-background-type').val('custom');
    updating_slide.find('input.set-slide-trailer-youtube').val('');
    updating_slide.find('input.set-slide-trailer-vimeo').val('');
    updating_slide.find('.set-slide-youtube-id').val('');
    updating_slide.find('.set-slide-vimeo-id').val('');
}

function wpvs_get_vimeo_slide_id(url) {
    var regExp = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
    var match = url.match(regExp);

    if (match){
        return match[5];
    }
    else{
        return 'error';
    }
}