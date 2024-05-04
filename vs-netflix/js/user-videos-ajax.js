jQuery(document).ready(function() {
    jQuery('body').delegate('.video-item', 'click', function(e) {
        var video_item = jQuery(this);
        if ( jQuery(e.target).hasClass('wpvs-video-download-link') || jQuery(e.target).parent().hasClass('wpvs-video-download-link') ) {
            e.preventDefault();
            var download_button = video_item.find('.wpvs-video-download-link');
            var video_download_link = download_button.data('download');
            var download_url = decodeURIComponent(video_download_link);
            if(download_url != "") {
                window.location.href = download_url;
            }
        }
    });
});
