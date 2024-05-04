jQuery(document).ready(function() {
    var frame;
    jQuery('.wpvs-cat-thumb-icon').click( function( event ){

        event.preventDefault();

        var update_label = jQuery(this);
        var update_preview = update_label.prev('.wpvs-select-thumbnail');;
        var target_field =  update_label.next('.wpvs-set-thumbnail');
        var thumbnail_size =  'video-'+update_preview.data('size');
        var image_url;
        // Create the media frame.
        frame = wp.media({
            title: 'Choose An Image',
            button: {
            text: 'Select',
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            if(typeof attachment.sizes[thumbnail_size] != "undefined") {
                image_url = attachment.sizes[thumbnail_size].url;
            } else {
                image_url = attachment.url;
            }
            target_field.val(image_url);
            update_preview.attr('src', image_url);
            jQuery('#wpvs_video_cat_attachment').val(attachment.id)
        });

        frame.open();
    });
    
    jQuery('#cat_contains_shows').change( function()  {
        if(jQuery(this).is(':checked')) {
            jQuery('.wpvs-is-tv-show').hide();
            jQuery('#cat_has_seasons').attr('checked', false);
        } else {
            jQuery('.wpvs-is-tv-show').show();
        }
    });
    
    jQuery('#cat_has_seasons').change( function()  {
        if(jQuery(this).is(':checked')) {
            jQuery('.wpvs-contains-tv-shows').hide();
            jQuery('#cat_contains_shows').attr('checked', false);
        } else {
            jQuery('.wpvs-contains-tv-shows').show();
        }
    });
});


