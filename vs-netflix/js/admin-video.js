jQuery(document).ready( function() {
    jQuery('input[name="wpvs-slider-type"]').change( function() {
        var slide_type = jQuery(this).val();
        jQuery('.wpvs-select-featured-type').hide();
        if(slide_type == "default") {
            jQuery('#wpvs-select-featured-slider').show();
        }
        if(slide_type == "shortcode") {
            jQuery('#wpvs-set-featured-shortcode').show();
        }
    });

});
    