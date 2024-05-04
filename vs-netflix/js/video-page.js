jQuery(document).ready( function() {
    jQuery('#main-content iframe[src*="youtube.com"], #main-content iframe[src*="vimeo.com"], #sidebar iframe[src*="youtube.com"], #sidebar iframe[src*="vimeo.com"]').wrap('<div class="videoWrapper"></div>');
    jQuery('#main-content object, #sidebar object').wrap('<div class="videoWrapper"></div>');
    jQuery('#main-content video, #sidebar video').wrap('<div class="videoWrapper"></div>');
    jQuery('#main-content embed, #sidebar embed').wrap('<div class="videoWrapper"></div>');
});
