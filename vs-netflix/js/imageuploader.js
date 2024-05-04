jQuery(document).ready(function() {

    var frame;
    jQuery('.upload_button').click( function( event ){

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( frame ) {
          frame.open();
          return;
        }

        targetfield = jQuery(this).prev('.upload-url');
        updateimage = jQuery(this).siblings(".imageContain").children("img");

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
            // We set multiple to false so only get one image from the uploader
            attachment = frame.state().get('selection').first().toJSON();
            if(attachment.sizes.header) {
                imgurl = attachment.sizes.header.url;
            } else {
                imgurl = attachment.url;
            }
            targetfield.attr("value", imgurl);
            updateimage.attr({src:  imgurl});
        });

        // Finally, open the modal
        frame.open();
    });
});
