jQuery(document).ready(function() {
    var wpvs_image_selector_frame;
    jQuery('.wpvs-remove-selected-image').click(function() {
        var image_selector_box = jQuery(this).parent();
        image_selector_box.find('.wpvs-set-selected-image').val('');
        image_selector_box.find('.wpvs-thumbnail-image-container').val('').html('');
        image_selector_box.find('.wpvs-set-selected-image-id').val('');
    });
    jQuery('.wpvs-select-image').click( function( event ) {
        event.preventDefault();
        var image_selector_box = jQuery(this).parent();
        var set_image_box = image_selector_box.find('.wpvs-thumbnail-image-container');
        var set_image_el = set_image_box.find('.wpvs-set-image');
        var set_image_id_el = image_selector_box.find('.wpvs-set-selected-image-id');
        var target_field = image_selector_box.find('.wpvs-set-selected-image');
        var image_url;

        wpvs_image_selector_frame = wp.media({
            title: 'Choose An Image',
            button: {
            text: 'Select',
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected, run a callback.
        wpvs_image_selector_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = wpvs_image_selector_frame.state().get('selection').first().toJSON();
            if(typeof attachment.sizes[wpvsimageloader.thumbnail] != "undefined") {
                image_url = attachment.sizes[wpvsimageloader.thumbnail].url;
            } else {
                image_url = attachment.url;
            }
            target_field.val(image_url);

            if( set_image_el.length > 0 ) {
                set_image_el.attr('src', image_url);
            } else {
                var set_img_html = '<img class="wpvs-set-image" src="'+image_url+'" />';
                set_image_box.html(set_img_html);
            }
            set_image_id_el.val(attachment.id);
        });

        // Finally, open the modal
        wpvs_image_selector_frame.open();
    });
});
