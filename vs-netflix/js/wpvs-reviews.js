jQuery(document).ready(function() {
    jQuery('.wpvs-video-rating-star').hover( function() {
        var this_rating_star = jQuery(this);
        this_rating_star.parent().find('.wpvs-video-rating-star').removeClass('active');
        this_rating_star.prevAll().addClass('active');
    });
    
    jQuery('.wpvs-video-rating-star').mouseleave( function() {
        var this_rating_star = jQuery(this);
        this_rating_star.parent().find('.wpvs-video-rating-star').removeClass('active');
    });
    
    jQuery('.wpvs-video-rating-star').click( function() {
        var this_rating_star = jQuery(this);
        var new_rating = this_rating_star.data('rating');
        var previous_stars = this_rating_star.prevAll();
        this_rating_star.parent().find('.dashicons-star-filled').removeClass('setactive').removeClass('dashicons-star-filled').addClass('dashicons-star-empty');
        if( new_rating == jQuery('#wpvs_video_rating').val() ) {
            this_rating_star.removeClass('setactive');
            new_rating = "";
        } else {
            previous_stars.removeClass('dashicons-star-empty').addClass('setactive dashicons-star-filled');
            this_rating_star.removeClass('dashicons-star-empty').addClass('setactive dashicons-star-filled');
        }
        jQuery('#wpvs_video_rating').val(new_rating);
    });
    
    jQuery('.comment-reply-link').click( function() {
        jQuery('.wpvs-rating-container').hide();
        jQuery('.wpvs-video-rating-star').removeClass('setactive');
        jQuery('#wpvs_video_rating').val("");
    });
    
    jQuery('#cancel-comment-reply-link').click( function() {
        jQuery('.wpvs-rating-container').show();
    });
    
    jQuery('form.wpvs-review-form').submit( function(e) {
        if(jQuery('#wpvs_video_rating').val() == "") {
            e.preventDefault();
            jQuery('#wpvs-missing-rating').addClass('show-wpvs-review-error');
        } else {
            jQuery('#wpvs-missing-rating').removeClass('show-wpvs-review-error');
        }
    });
    
    if(jQuery('#wpvs-video-reviews-container').length > 0) {
        jQuery('.vs-video-details').find('.wpvs-review-anchor').click( function() {
            jQuery('#wpvs-video-reviews-container').addClass('show-reviews');
        });
        
        jQuery('#close-wpvs-reviews').click( function() {
            jQuery('#wpvs-video-reviews-container').removeClass('show-reviews');
        });
        jQuery(document).mouseup(function(e) {
            var reviews_container = jQuery('#wpvs-video-reviews-container');
            if (!reviews_container.is(e.target) && reviews_container.has(e.target).length === 0) {
                jQuery('#wpvs-video-reviews-container').removeClass('show-reviews');
            }
        });
        
        if( (window.location.hash && window.location.hash == '#comments') || (window.location.hash && window.location.hash.indexOf('#comment-') != -1) ) {
            jQuery('#wpvs-video-reviews-container').addClass('show-reviews');
        }
    }
});