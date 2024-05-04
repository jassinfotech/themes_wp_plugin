jQuery(document).ready( function() {
    jQuery('.thumbnail-select').click( function() {
        var image_update = jQuery(this).find('img');
        var remove_image = jQuery(this).siblings().find('img').removeClass('set-active');
        image_update.addClass('set-active');
    });
});
    