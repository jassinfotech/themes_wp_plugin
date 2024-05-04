var slides_to_show;
var slides_to_show_1;
var slides_to_show_2;
var slides_to_show_3;
var slides_to_show_4;
jQuery(document).ready(function() {
    slides_to_show = parseInt(slickslider.count.large);
    slides_to_show_1 = parseInt(slickslider.count.desktop);
    slides_to_show_2 = parseInt(slickslider.count.laptop);
    slides_to_show_3 = parseInt(slickslider.count.tablet);
    slides_to_show_4 = parseInt(slickslider.count.mobile);
    wpvs_theme_load_slick_slider_browsing();
});

function wpvs_theme_load_slick_slider_browsing() {
    var wpvs_slick_slider_settings = {
        infinite: true,
        slidesToShow: slides_to_show,
        slidesToScroll: slides_to_show,
        arrows: true,
        prevArrow: '<button class="slick-prev slick-arrow"></button>',
        nextArrow: '<button class="slick-next slick-arrow"></button>',
        responsive: [
            {
              breakpoint: 1600,
              settings: {
                slidesToShow: slides_to_show_1,
                slidesToScroll: slides_to_show_1
              }
            },
            {
              breakpoint: 1200,
              settings: {
                slidesToShow: slides_to_show_2,
                slidesToScroll: slides_to_show_2,
                infinite: true,
              }
            },
            {
              breakpoint: 960,
              settings: {
                slidesToShow: slides_to_show_3,
                slidesToScroll: slides_to_show_3
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: slides_to_show_4,
                slidesToScroll: slides_to_show_4
              }
            }
        ]
    };
    if( ! slickslider.disable_lazy_load ) {
        wpvs_slick_slider_settings.lazyload = 'ondemand';
    }
    var carousel_load = jQuery('.video-list-slider').not('.slick-initialized').slick(wpvs_slick_slider_settings);

    jQuery('.video-slide').hover( function () {
        var prev_slide = jQuery(this).prevAll();
        var next_slide = jQuery(this).nextAll();
        prev_slide.toggleClass('shift-left');
        next_slide.toggleClass('shift-right');
    });

    jQuery.when(carousel_load).done( function() {
        jQuery('#wpvs-theme-slide-loader').remove();
        jQuery('#video-list-container').css({'opacity': '1', 'max-height': 'none'});
    });

    jQuery('body').delegate('.episode-slider-list', 'init', function(slick) {
        var current_slider = jQuery(this);
        current_slider.find('.slick-current').addClass('slick-first');
        current_slider.find('.slick-active:first').addClass('slick-first');
        current_slider.find('.slick-active:last').addClass('slick-last');
        current_slider.addClass('show-list-slider');
        current_slider.find('.wpvs-no-slide-image').css({'height': current_slider.find('.slick-track').height()});
    });

    jQuery('body').delegate('.episode-slider-list', 'afterChange', function(slick, currentSlide) {
        var current_slider = jQuery(this);
        current_slider.find('.slick-active').removeClass('slick-first');
        current_slider.find('.slick-slide').removeClass('slick-last');
        current_slider.find('.slick-active:first').addClass('slick-first');
        current_slider.find('.slick-active:last').addClass('slick-last');
    });
}

jQuery('.video-list-slider').on('afterChange', function(slick, currentSlide) {
    var current_slider = jQuery(this);
    current_slider.find('.slick-active').removeClass('slick-first');
    current_slider.find('.slick-slide').removeClass('slick-last');
    current_slider.find('.slick-active:first').addClass('slick-first');
    current_slider.find('.slick-active:last').addClass('slick-last');
});

jQuery('.video-list-slider').on('init', function(slick) {
    var current_slider = jQuery(this);
    current_slider.find('.slick-current').addClass('slick-first');
    current_slider.find('.slick-active:first').addClass('slick-first');
    current_slider.find('.slick-active:last').addClass('slick-last');
    current_slider.addClass('show-list-slider');
    current_slider.find('.wpvs-no-slide-image').css({'height': current_slider.find('.slick-track').height()});
});

function wpvs_load_inner_episode_slider(slider_element) {
    slider_element.not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: slides_to_show,
        slidesToScroll: slides_to_show,
        arrows: true,
        prevArrow: '<button class="slick-prev slick-arrow"></button>',
        nextArrow: '<button class="slick-next slick-arrow"></button>',
        responsive: [
        {
          breakpoint: 1600,
          settings: {
            slidesToShow: slides_to_show_1,
            slidesToScroll: slides_to_show_1
          }
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: slides_to_show_2,
            slidesToScroll: slides_to_show_2,
            infinite: true,
          }
        },
        {
          breakpoint: 960,
          settings: {
            slidesToShow: slides_to_show_3,
            slidesToScroll: slides_to_show_3
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: slides_to_show_4,
            slidesToScroll: slides_to_show_4
          }
        }
        ]
    });
}
