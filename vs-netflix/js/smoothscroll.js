jQuery(document).ready(function() {
    jQuery('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                event.preventDefault();
                if( (target.selector == '#comments' && jQuery('#wpvs-video-reviews-container').length > 0) || (target.selector == '#respond') ) {

                } else {
                    jQuery('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                }
            }
        }
    });
});
