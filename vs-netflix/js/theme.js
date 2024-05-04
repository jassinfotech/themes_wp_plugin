var wpvs_audio_player;
jQuery(document).ready(function() {
    jQuery("label#menuOpen").click(function () {
        jQuery(this).toggleClass('menu-button-open');
        jQuery('nav#mobile').toggleClass('show-mobile-menu');
        jQuery('header#header #logo, #wrapper, footer').toggleClass('move-content-left');
        jQuery('header#header .header-icons').toggleClass('move-icons-left');
    });

    jQuery("nav#mobile .mobile-arrow").click(function () {
        jQuery(this).prev('.sub-menu').slideToggle();
    });

    jQuery("nav#mobile .userArrow").click(function () {
        jQuery('ul#user-sub-menu').slideToggle();
    });

    jQuery("nav#desktop .sub-arrow").click(function () {
        jQuery(this).prev('.sub-menu').slideToggle();
    });

    jQuery(window).scroll( function() {
       if(jQuery(window).scrollTop() > 50) {
           jQuery('#header').addClass('header-background');
           if( jQuery('.category-top').length > 0 ) {
               jQuery('.category-top').addClass('hug-header');
           }
       } else {
           jQuery('#header').removeClass('header-background');
           if( jQuery('.category-top').length > 0 ) {
               jQuery('.category-top').removeClass('hug-header');
           }
       }
    });

    jQuery('#open-sub-video-cats').click(function() {
        jQuery('#select-sub-category').slideToggle();
    });

    jQuery('nav#desktop ul li').hover( function() {
        var this_menu_item = jQuery(this);
        jQuery('.wpvs-theme-full-menu ul.sub-menu').removeClass('show-full-width-menu');
        if( this_menu_item.hasClass('wpvs-theme-full-menu') ) {
       		this_menu_item.find('ul.sub-menu').addClass('show-full-width-menu');
        }
    });

    jQuery('#header').mouseleave( function() {
        jQuery('ul.sub-menu').removeClass('show-full-width-menu');
    });

    wpvs_reset_main_menu();

    if( jQuery('#wpvs_audio_file_container').length > 0 ) {
        if( jQuery('#wpvs_audio_player').length > 0 ) {
            wpvs_audio_player = jQuery('#wpvs_audio_player')[0];
            jQuery('#wpvs_play_audio_file').click(function() {
                if( wpvs_audio_player.paused ) {
                    wpvs_audio_player.play();
                } else {
                    wpvs_audio_player.pause();
                }
            });
        }
        jQuery('#wpvs_play_audio_file').click(function() {
            if( jQuery(this).hasClass('listening') ) {
                jQuery(this).removeClass('listening');
                jQuery('#wpvs_audio_file_container').removeClass('show');
            } else {
                jQuery(this).addClass('listening');
                jQuery('#wpvs_audio_file_container').addClass('show');
            }
        });
    }
});

jQuery(window).resize(wpvs_reset_main_menu);

function wpvs_reset_main_menu() {
    if(jQuery(window).width() >= 768) {
        jQuery('ul#user-sub-menu').slideUp();
    }

    if(jQuery(window).width() >= 960) {
        var wpvs_desktop_menu = jQuery('nav#desktop');
        var wpvs_menu_space = wpvs_desktop_menu.width() + 300;
        if( wpvs_menu_space <= jQuery(window).width() ) {
            jQuery('header#header').addClass('show-desktop-menu');
            jQuery("label#menuOpen").removeClass('menu-button-open');
            jQuery('nav#mobile').removeClass('show-mobile-menu');
            jQuery('header#header #logo, #wrapper, footer').removeClass('move-content-left');
            jQuery('header#header .header-icons').removeClass('move-icons-left');
        } else {
            jQuery('header#header').removeClass('show-desktop-menu');
        }
    } else {
        jQuery('header#header').removeClass('show-desktop-menu');
    }
}
