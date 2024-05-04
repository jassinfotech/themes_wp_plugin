jQuery(document).ready( function() {
    jQuery('.page-container iframe[src*="youtube.com"], .vs-container iframe[src*="youtube.com"], .page-container iframe[src*="vimeo.com"], .vs-container iframe[src*="vimeo.com"]').each( function() {
        var this_video_element = jQuery(this);
        if( this_video_element.parent('.wp-block-embed__wrapper').length < 1) {
            this_video_element.wrap('<div class="videoWrapper"></div>');
        }
    });

    jQuery('.page-container object, .vs-container object, .page-container video, .vs-container video, .page-container embed, .vs-container embed').each( function() {
        var this_video_element = jQuery(this);
        if( this_video_element.parent('.wp-block-embed__wrapper').length < 1) {
            this_video_element.wrap('<div class="videoWrapper"></div>');
        }
    });
});
