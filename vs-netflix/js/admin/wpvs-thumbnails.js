jQuery(document).ready(function() {
    var frame;
    jQuery('.wpvs-cat-thumb-icon').click( function( event ){

        event.preventDefault();

        var update_label = jQuery(this);
        var update_preview = update_label.prev('.wpvs-select-thumbnail');;
        var target_field =  update_label.next('.wpvs-set-thumbnail');
        var attachment_id =  update_label.parent().find('.wpvs-thumbnail-attachment');
        var thumbnail_size = update_preview.data('size');
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
            if(update_preview.hasClass('update-video-cat-attachment')) {
                attachment_id.val(attachment.id)
            }

        });

        frame.open();
    });
    
});


