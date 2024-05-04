/*  Table of Contents 
01. MENU ACTIVATION
02. FITVIDES RESPONSIVE VIDEOS
03. MOBILE MENU
04. GALLERY JS
05. SCROLL TO TOP MENU JS 
06. prettyPhoto JS
07. PRELOADER JS
08. STICKY HEADER JS
09. Add to Favorites Menu ON/Off
10. Social Icons ON/Off
11. Circle JS Rating
12. Comment JS
13. Video App Header On/Off Clickable Items
14. Range Slider in Header Search
15. AUTHOR JS TABS
*/

jQuery(document).ready(function($) {
	 'use strict';

/*
=============================================== 01. MENU ACTIVATION  ===============================================
*/
	 jQuery('nav#site-navigation ul.sf-menu, nav#sidebar-nav-pro ul.sf-menu').superfish({
			 	popUpSelector: 'ul.sub-menu,.sf-mega', 	// within menu context
	 			delay:      	200,                	// one second delay on mouseout
	 			speed:      	0,               		// faster \ speed
		 		speedOut:    	200,             		// speed of the closing animation
				animation: 		{opacity: 'show'},		// animation out
				animationOut: 	{opacity: 'hide'},		// adnimation in
		 		cssArrows:     	true,              		// set to false
			 	autoArrows:  	true,                    // disable generation of arrow mark-up
		 		disableHI:      true,
	 });
	 
/*
=============================================== 02. FITVIDES RESPONSIVE VIDEOS  ===============================================
*/
	 $(".episode-video-list-embed-video, .progression-studios-feaured-image, .progression-blog-content, #skrn-single-video-embed").fitVids();
	 
	 
/*
=============================================== 03. MOBILE MENU  ===============================================
*/
	 	
   	$('ul.mobile-menu-pro').slimmenu({
   	    resizeWidth: '960',
   	    collapserTitle: 'Menu',
   	    easingEffect:'easeInOutQuint',
   	    animSpeed:350,
   	    indentChildren: false,
   		childrenIndenter: '- '
   	});
	
	
	$('#mobile-menu-icon-pro').click(function(e){
		e.preventDefault();
		$('#main-nav-mobile').slideToggle(350);
		$("#boxed-layout-pro").toggleClass("active-mobile-icon-pro");
	});
	



/*
=============================================== 04. GALLERY JS  ===============================================
*/	
    $('.progression-studios-gallery').flexslider({
		animation: "fade",      
		slideDirection: "horizontal", 
		slideshow: false,   
		smoothHeight: false,
		slideshowSpeed: 7000,  
		animationSpeed: 1000,        
		directionNav: true,             
		controlNav: true,
		prevText: "",   
		nextText: "",
    });


/*
=============================================== 05. SCROLL TO TOP MENU JS  ===============================================
*/
  	// browser window scroll (in pixels) after which the "back to top" link is shown
	$('#pro-scroll-top').hide();
	
    $(window).scroll(function(){
		if ($(this).scrollTop() > 200) {
			$('#pro-scroll-top').fadeIn();
		} else {
			$('#pro-scroll-top').fadeOut();
		}
	 });

	 // Click event to scroll to top
     $('#pro-scroll-top').click(function(){
         $('html, body').animate({scrollTop : 0},800);
         return false;
     }); 
	 
	 var offset_scroll = 150;
 
	
	/* Scroll to link inside page */
	$('a.scroll-to-link').click(function(){
	  $('html, body').animate({
	    scrollTop: $( $.attr(this, 'href') ).offset_scroll().top - pro_top_offset
	  }, 400);
	  return false;
	});
	
	



/*
=============================================== 06. prettyPhoto JS  ===============================================
*/

  	$(".progression-studios-feaured-image a[data-rel^='prettyPhoto']").prettyPhoto({
			theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
  			hook: 'data-rel',
			opacity: 0.7,
  			show_title: false, /* true/false */
  			deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
  			overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
  			custom_markup: '',
			default_width: 1100,
			default_height: 619,
  			social_tools: '' /* html or false to disable */
  	});
	
	
  	$("a.lightbox, .lightbox a").prettyPhoto({
			theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
  			hook: 'class',
			opacity: 0.7,
  			show_title: false, /* true/false */
  			deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
  			overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
  			custom_markup: '',
			default_width: 1100,
			default_height: 619,
  			social_tools: '' /* html or false to disable */
  	});


/*
=============================================== 07. PRELOADER JS  ===============================================
*/
	(function($) {
		var didDone = false;
		    function done() {
		        if(!didDone) {
		            didDone = true;
					$("#page-loader-pro").addClass('finished-loading');
					$("#boxed-layout-pro").addClass('progression-preloader-completed');
		        }
		    }
		    var loaded = false;
		    var minDone = false;
		    //The minimum timeout.
		    setTimeout(function(){
		        minDone = true;
		        //If loaded, fire the done callback.
		        if(loaded)  {  done(); } }, 400);
		    //The maximum timeout.
		    setTimeout(function(){  done();   }, 2000);
		    //Bind the load listener.
		    $(window).load(function(){  loaded = true;
		        if(minDone) { done(); }
		    });
	})(jQuery);


/*
=============================================== 08. STICKY HEADER JS  ===============================================
*/	
	
	/* HEADER HEIGHT FOR SPACING OF ONE PAGE NAV AND STICKY HEADER */
	var pro_top_offset = $('header#masthead-pro').height();  // get height of fixed navbar
	
	var pro_top_offset_sidebar = $('#progression-sticky-header').height() + 30 ; 
	
	
	$('#progression-sticky-header').scrollToFixed({ minWidth: 767 });
	

	$(window).resize(function() {
	   var width_progression = $(document).width();
	      if (width_progression > 767) {
				/* STICKY HEADER CLASS */
				$(window).on('load scroll resize orientationchange', function () {
					
				    var scroll = $(window).scrollTop();
				    if (scroll >=  pro_top_offset - 1  ) {
				        $("#progression-sticky-header").addClass("progression-sticky-scrolled");
				    } else {
				        $("#progression-sticky-header").removeClass("progression-sticky-scrolled");
				    }
				});
			} else {
				$('#progression-sticky-header').trigger('detach.ScrollToFixed');
			}
		
	}).resize();
	
    /* Sitcky Video Sidebar */
    $('nav#sidebar-nav-pro.sticky-sidebar-js').hcSticky({
   	 top:0
    });
 
 
/*
=============================================== 09. Add to Favorites Menu ON/Off  ===============================================
*/
	$(".progression-studios-slider-more-options").hover(function() {
		var $this = $(".progression-studios-slider-more-options");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});	

/*
=============================================== 10. Social Icons ON/Off  ===============================================
*/
	
	$(".share-this-hero").click(function() {
		var $this = $("#blog-single-social-sharing-container");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	$("#close-social-sharing-skrn").click(function() {
		var $this = $("#blog-single-social-sharing-container");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	
	
	
	
	$("li.write-review-hero").click(function() {
		var $this = $("#comment-review-pop-up-fullscreen");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	$("#close-pop-up-full-review-skrn, .content-sidebar-section a.button-progression, .rating-click-to-rate-skrn").click(function() {
		var $this = $("#comment-review-pop-up-fullscreen");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	
	
/*
=============================================== 11. Circle JS Rating  ===============================================
*/
	
    $('.circle-rating-pro').circleProgress();


/*
=============================================== 12. Comment JS ===============================================
*/
	/* Comment Avatar BG */
	$('.skrn-review-full-avatar').css('background-image', function() {
	    return 'url(' + $(this).find('img').attr('src') + ')'
	  });
	
	
	$('.sidebar-excerpt-more-click').click(function(){
		$(this).find(".sidebar-comment-exerpt-text").hide();
		$(this).find(".read-more-comment-sidebar").hide();
		$(this).find(".sidebar-comment-full").show();
	});
	
	
	$("#comment-review-form-container button.button").click(function() {
		var $this = $("#comment-review-form-container");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	
/*
=============================================== 13. Video App Header On/Off Clickable Items ===============================================
*/	
	$("#header-user-profile-click").click(function() {
		var $this = $("#header-user-profile");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	
	$("#header-user-notification-click").click(function() {
		var $this = $("#header-user-notification");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	
	$("#search-icon-more").click(function() {
		var $this = $("#video-search-header");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	
	$("#tablet-mobile-search-icon-more").click(function() {
		var $this = $("#skrn-mobile-video-search-header");
	    if ($this.hasClass('active')) {
	        $this.removeClass('active').addClass('hide');
	    } else {
	        $this.addClass('active');
	    }		
	});
	
	/* If clicking outside of boxes, automatically hide */
	$(document).click(function(e) {
	    if (e.target.id != 'header-user-profile' && !$('#header-user-profile').find(e.target).length) {
	        if ($("#header-user-profile").hasClass('active')) {
	        	$("#header-user-profile").removeClass('active').addClass('hide');
	        }
	    }
		
	    if (e.target.id != 'header-user-notification' && !$('#header-user-notification').find(e.target).length) {
	        if ($("#header-user-notification").hasClass('active')) {
	        	$("#header-user-notification").removeClass('active').addClass('hide');
	        }
	    }
		
	    if (e.target.id != 'video-search-header' && !$('#video-search-header').find(e.target).length) {
	        if ($("#video-search-header").hasClass('active')) {
	        	$("#video-search-header").removeClass('active').addClass('hide');
	        }
	    }
	});
	
	
/*
=============================================== 14. Range Slider in Header Search ===============================================
*/	
		
    $(".rating-range-search-skrn").asRange({
		range: true,
		limit: false,
		tip: true,
    });


	

/*
=============================================== 15. AUTHOR JS TABS ===============================================
*/	
  // Get URL
    var progression_studios_url = window.location.href;
    // Get DIV
    var favoritesmsg = document.getElementById('skrn-progression-favorites-div-container');
	var watchlistmsg = document.getElementById('skrn-progression-watchlist-div-container');
	var reviewstmsg = document.getElementById('skrn-progression-reviews-div-container');
    // Check if URL contains the keyword
    if( progression_studios_url.search( 'favorites' ) > 0 ) {
        // Display the message
        favoritesmsg.style.display = "block";
		watchlistmsg.style.display = "none";
    }
	
    if( progression_studios_url.search( 'reviews' ) > 0 ) {
        // Display the message
        reviewstmsg.style.display = "block";
		watchlistmsg.style.display = "none";
    }
	

});