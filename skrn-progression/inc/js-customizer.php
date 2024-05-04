<?php
/**
 * Progression JS Customizer
 *
 * @package pro
 */

function progression_studios_enqueue_script() {
	
	if ( is_singular( 'video_skrn' )) {
			
	   wp_add_inline_script( 'skrn-progression-scripts', '	
			jQuery(document).ready(function($) { 
			"use strict";
			// Get URL
			var progression_studios_vayvo_url = window.location.href;
	      // Check if URL contains the keyword
	      if( progression_studios_vayvo_url.search( "show_season_one" ) > 0 ) {
	         $(".vayvo-progression-video-season-container").addClass("select_vayvo_season_1");
				$("html,body").animate({
				    scrollTop: $(".select_vayvo_season_1").offset().top - 70
				}, 1000);
	      }
			
	      if( progression_studios_vayvo_url.search( "show_season_two" ) > 0 ) {
	         $(".vayvo-progression-video-season-container").addClass("select_vayvo_season_2");
				$("html,body").animate({
				    scrollTop: $(".select_vayvo_season_2").offset().top - 70
				}, 1000);
	      }
	
	      if( progression_studios_vayvo_url.search( "show_season_three" ) > 0 ) {
	         $(".vayvo-progression-video-season-container").addClass("select_vayvo_season_3");
				$("html,body").animate({
				    scrollTop: $(".select_vayvo_season_3").offset().top - 70
				}, 1000);
	      }
			
	      if( progression_studios_vayvo_url.search( "show_season_four" ) > 0 ) {
	         $(".vayvo-progression-video-season-container").addClass("select_vayvo_season_4");
				$("html,body").animate({
				    scrollTop: $(".select_vayvo_season_4").offset().top - 70
				}, 1000);
	      }
			
	      if( progression_studios_vayvo_url.search( "show_season_five" ) > 0 ) {
	         $(".vayvo-progression-video-season-container").addClass("select_vayvo_season_5");
				$("html,body").animate({
				    scrollTop: $(".select_vayvo_season_5").offset().top - 70
				}, 1000);
	      }
				
			});
		' 
		);
	}
	
	
	
   wp_add_inline_script( 'skrn-progression-scripts', '	
		jQuery(document).ready(function($) { 
		"use strict";
		
		$(".skrn-genre-select2").select2({
			placeholder: "' . esc_html__( 'All Genres', 'skrn-progression' ) . '",
			allowClear: true,
			language: {
				noResults: function () {
				    return "' . esc_html__( 'No genres found', 'skrn-progression' ) . '";
				 }
			},
			minimumResultsForSearch: -1
		});
		
		$(".skrn-duration-select2").select2({
			placeholder: "' . esc_html__( 'Any Duration', 'skrn-progression' ) . '",
			allowClear: true,
			minimumResultsForSearch: -1
		});
		
		$(".skrn-category-select2").select2({
			placeholder: "' . esc_html__( 'All Categories', 'skrn-progression' ) . '",
			allowClear: true,
			language: {
				noResults: function () {
				    return "' . esc_html__( 'No categories found', 'skrn-progression' ) . '";
				 }
			},
			minimumResultsForSearch: -1
		});
		
		$(".skrn-director-select2").select2({
			placeholder: "' . esc_html__( 'All Directors', 'skrn-progression' ) . '",
			allowClear: true,
			language: {
				noResults: function () {
				    return "' . esc_html__( 'No directors found', 'skrn-progression' ) . '";
				 }
			},
			minimumResultsForSearch: -1
		});
		
		$("#configreset, #mobile-configure-rest").click(function(){
			$(".advanced-searchform-video-header, .mobile-searchform-video-header").trigger("reset");
			$(".advanced-searchform-video-header input:checked, .mobile-searchform-video-header input:checked").removeAttr("checked");
			$(".skrn-director-select2, .skrn-category-select2, .skrn-genre-select2, .skrn-duration-select2").val("").trigger("change");
			$(".skrn-director-select2 option[selected], .skrn-category-select2 option[selected], .skrn-genre-select2 option[selected], .skrn-duration-select2 option[selected]").removeAttr("selected");
			
			$(this).parents("form").find(".rating-range-search-skrn").val("0,10");
			var api = $(this).parents("form").find(".rating-range-search-skrn").data("asRange");
			api.set([0,10]);
		});
	
		
		});
	' 
	);
	
	if ( is_author() ) {
		
	   wp_add_inline_script( 'skrn-progression-scripts', '	
			jQuery(document).ready(function($) { 
				"use strict";
		
				/* Default Isotope Load Code */
				var $container = $(".progression-blog-index-masonry").isotope();
				$container.imagesLoaded( function() {
					$(".progression-masonry-item").addClass("opacity-progression");
					$container.isotope({
						itemSelector: ".progression-masonry-item",				
						percentPosition: true,
						layoutMode: "' . esc_attr(get_theme_mod( "progression_studios_blog_masonry_fit", "fitRows")) . '" 
			 		});
				});
				/* END Default Isotope Code */
		
			});
		' 
		);
		
	}
	
	if ( is_post_type_archive( 'video_skrn' ) || is_tax( 'video-genres' ) || is_tax( 'video-type' ) || is_tax( 'video-category' ) || is_tax( 'video-director' ) || is_tax( 'video-cast' ) || is_singular( 'video_skrn' )) {
   wp_add_inline_script( 'skrn-progression-scripts', '	
		jQuery(document).ready(function($) { 
			"use strict";
		
			/* Default Isotope Load Code */
			var $container = $(".progression-blog-index-masonry").isotope();
			$container.imagesLoaded( function() {
				$(".progression-masonry-item").addClass("opacity-progression");
				$container.isotope({
					itemSelector: ".progression-masonry-item",				
					percentPosition: true,
					layoutMode: "' . esc_attr(get_theme_mod( "progression_studios_blog_masonry_fit", "fitRows")) . '" 
		 		});
			});
			/* END Default Isotope Code */
		
		});
	' 
	);
	}
	
	
}
add_action( 'wp_enqueue_scripts', 'progression_studios_enqueue_script' );