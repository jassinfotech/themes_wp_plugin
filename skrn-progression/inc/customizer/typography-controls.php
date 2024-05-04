<?php
/**
 * progression Theme Customizer
 *
 * @package progression
 */

function progression_studios_add_tab_to_panel( $tabs ) {
	
	
   $tabs['progression-studios-dashboard-search'] = array(
       'name'        => 'progression-studios-dashboard-search',
       'panel'       => 'progression_studios_header_dashboard_panel',
       'title'       => esc_html__('Search Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
	
   $tabs['progression-studios-dashboard-sidebar-options'] = array(
       'name'        => 'progression-studios-dashboard-sidebar-options',
       'panel'       => 'progression_studios_header_dashboard_panel',
       'title'       => esc_html__('Sidebar Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-dashboard-sidebar-sub-navigation'] = array(
       'name'        => 'progression-studios-dashboard-sidebar-sub-navigation',
       'panel'       => 'progression_studios_header_dashboard_panel',
       'title'       => esc_html__('Sidebar Sub-Navigation', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-navigation-font'] = array(
       'name'        => 'progression-studios-navigation-font',
       'panel'       => 'progression_studios_header_panel',
       'title'       => esc_html__('Navigation', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-sub-navigation-font'] = array(
       'name'        => 'progression-studios-sub-navigation-font',
       'panel'       => 'progression_studios_header_panel',
       'title'       => esc_html__('Sub-Navigation', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-top-header-font'] = array(
       'name'        => 'progression-studios-top-header-font',
       'panel'       => 'progression_studios_header_panel',
       'title'       => esc_html__('Top Header Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-body-font'] = array(
       'name'        => 'progression-studios-body-font',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('Body Main', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-page-title'] = array(
       'name'        => 'progression-studios-page-title',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('Page Title', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-widgets-font'] = array(
       'name'        => 'progression-studios-widgets-font',
       'panel'       => 'progression_studios_footer_panel',
       'title'       => esc_html__('Footer Main', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	


   $tabs['progression-studios-footer-nav-font'] = array(
       'name'        => 'progression-studios-footer-nav-font',
       'panel'       => 'progression_studios_footer_panel',
       'title'       => esc_html__('Footer Navigation', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
	
	
   $tabs['progression-studios-default-headings'] = array(
       'name'        => 'progression-studios-default-headings',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('H1-H6 Headings', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
  
	
   $tabs['progression-studios-sidebar-headings'] = array(
       'name'        => 'progression-studios-sidebar-headings',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('Sidebar Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-header-button-typography'] = array(
       'name'        => 'progression-studios-header-button-typography',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('Header Login Button Styles', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-button-typography'] = array(
       'name'        => 'progression-studios-button-typography',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('Button/Input Styles', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-profile-page'] = array(
       'name'        => 'progression-studios-profile-page',
       'panel'       => 'progression_studios_body_panel',
       'title'       => esc_html__('Profile Page Settings', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	


	
   $tabs['progression-studios-blog-headings'] = array(
       'name'        => 'progression-studios-blog-headings',
       'panel'       => 'progression_studios_blog_panel',
       'title'       => esc_html__('Blog Default Styles', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );

	
   $tabs['progression-studios-blog-post-options'] = array(
       'name'        => 'progression-studios-blog-post-options',
       'panel'       => 'progression_studios_blog_panel',
       'title'       => esc_html__('Blog Post Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-blog-post-styles'] = array(
       'name'        => 'progression-studios-blog-post-styles',
       'panel'       => 'progression_studios_blog_panel',
       'title'       => esc_html__('Blog Post Styles', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-video-index-options'] = array(
       'name'        => 'progression-studios-video-index-options',
       'panel'       => 'progression_studios_videos_panel',
       'title'       => esc_html__('Video Index Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-video-post-options'] = array(
       'name'        => 'progression-studios-video-post-options',
       'panel'       => 'progression_studios_videos_panel',
       'title'       => esc_html__('Video Post Options', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['progression-studios-video-rating-options'] = array(
       'name'        => 'progression-studios-video-rating-options',
       'panel'       => 'progression_studios_videos_panel',
       'title'       => esc_html__('Video Rating Styles', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['progression-studios-profile-header'] = array(
       'name'        => 'progression-studios-profile-header',
       'panel'       => 'progression_studios_header_dashboard_panel',
       'title'       => esc_html__('Profile Header', 'skrn-progression'),
       'description' => '',
       'sections'    => array(),
   );

	
    // Return the tabs.
    return $tabs;
}
add_filter( 'tt_font_get_settings_page_tabs', 'progression_studios_add_tab_to_panel' );

/**
 * How to add a font control to your tab
 *
 * @see  parse_font_control_array() - in class EGF_Register_Options
 *       in includes/class-egf-register-options.php to see the full
 *       properties you can add for each font control.
 *
 *
 * @param   array $controls - Existing Controls.
 * @return  array $controls - Controls with controls added/removed.
 *
 * @since 1.0
 * @version 1.0
 *
 */
function progression_studios_add_control_to_tab( $controls ) {

    /**
     * 1. Removing default styles because we add-in our own
     */
    unset( $controls['tt_default_body'] );
    unset( $controls['tt_default_heading_1'] );
    unset( $controls['tt_default_heading_2'] );
    unset( $controls['tt_default_heading_3'] );
    unset( $controls['tt_default_heading_4'] );
    unset( $controls['tt_default_heading_5'] );
    unset( $controls['tt_default_heading_6'] );
	 
	 
    /**
     * 2. Now custom examples that are theme specific
     */
	 
	 
    $controls['progression_studios_sidebar_nav_font_family'] = array(
        'name'       => 'progression_studios_sidebar_nav_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Navigation Font', 'skrn-progression'),
        'tab'        => 'progression-studios-dashboard-sidebar-options',
        'properties' => array( 'selector'   => '#sidebar-nav-pro ul.sf-menu' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['progression_studios_sidebar_sub_nav_font_family'] = array(
        'name'       => 'progression_studios_sidebar_sub_nav_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sub-Navigation Font', 'skrn-progression'),
        'tab'        => 'progression-studios-dashboard-sidebar-sub-navigation',
        'properties' => array( 'selector'   => '#sidebar-nav-pro ul.sf-menu ul' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['progression_studios_nav_font_family'] = array(
        'name'       => 'progression_studios_nav_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Navigation Font Family', 'skrn-progression'),
        'tab'        => 'progression-studios-navigation-font',
        'properties' => array( 'selector'   => 'nav#site-navigation, #main-nav-mobile, ul.mobile-menu-pro li a' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );

	 
    $controls['progression_studios_sub_nav_font_family'] = array(
        'name'       => 'progression_studios_sub_nav_font_family',
 	'type'        => 'font',
        'title'      =>  esc_html__('Sub-Navigation Font Family', 'skrn-progression'),
        'tab'        => 'progression-studios-sub-navigation-font',
        'properties' => array( 'selector'   => '.sf-menu ul' ),
 	'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	
    $controls['progression_studios_body_font_family'] = array(
        'name'       => 'progression_studios_body_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Body Font', 'skrn-progression'),
        'tab'        => 'progression-studios-body-font',
        'properties' => array( 'selector'   => 'body,  body input, body textarea, select' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['progression_studios_heading_h1'] = array(
        'name'       => 'progression_studios_heading_h1',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 1', 'skrn-progression'),
        'tab'        => 'progression-studios-default-headings',
        'properties' => array( 'selector'   => 'h1' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['progression_studios_heading_h2'] = array(
        'name'       => 'progression_studios_heading_h2',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 2', 'skrn-progression'),
        'tab'        => 'progression-studios-default-headings',
        'properties' => array( 'selector'   => 'h2' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['progression_studios_heading_h3'] = array(
        'name'       => 'progression_studios_heading_h3',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 3', 'skrn-progression'),
        'tab'        => 'progression-studios-default-headings',
        'properties' => array( 'selector'   => 'h3' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['progression_studios_heading_h4'] = array(
        'name'       => 'progression_studios_heading_h4',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 4', 'skrn-progression'),
        'tab'        => 'progression-studios-default-headings',
        'properties' => array( 'selector'   => 'h4' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['progression_studios_heading_h5'] = array(
        'name'       => 'progression_studios_heading_h5',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 5', 'skrn-progression'),
        'tab'        => 'progression-studios-default-headings',
        'properties' => array( 'selector'   => 'h5' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['progression_studios_heading_h6'] = array(
        'name'       => 'progression_studios_heading_h6',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 6', 'skrn-progression'),
        'tab'        => 'progression-studios-default-headings',
        'properties' => array( 'selector'   => 'h6' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
	 
    $controls['progression_studios_page_title_font_family'] = array(
        'name'       => 'progression_studios_page_title_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Page Title Font', 'skrn-progression'),
        'tab'        => 'progression-studios-page-title',
        'properties' => array( 'selector'   => '#page-title-pro h1' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['progression_studios_page_sub_title_font_family'] = array(
        'name'       => 'progression_studios_page_sub_title_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Page Sub-Title Font', 'skrn-progression'),
        'tab'        => 'progression-studios-page-title',
        'properties' => array( 'selector'   => '#page-title-pro h4' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
	 
    $controls['progression_studios_blog_title_font'] = array(
        'name'       => 'progression_studios_blog_title_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Title', 'skrn-progression'),
        'tab'        => 'progression-studios-blog-headings',
        'properties' => array( 'selector'   => 'h2.progression-blog-title' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['progression_studios_blog_byline_font'] = array(
        'name'       => 'progression_studios_blog_byline_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Post Meta', 'skrn-progression'),
        'tab'        => 'progression-studios-blog-headings',
        'properties' => array( 'selector'   => 'ul.progression-post-meta li, ul.progression-post-meta li a' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['progression_studios_blog_byline_link_font_hover'] = array(
        'name'       => 'progression_studios_blog_byline_link_font_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Post Meta Hover', 'skrn-progression'),
        'tab'        => 'progression-studios-blog-headings',
        'properties' => array( 'selector'   => 'ul.progression-post-meta li a:hover' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['progression_studios_header_button_font_family'] = array(
        'name'       => 'progression_studios_header_button_font_family',
 	'type'        => 'font',
        'title'      =>  esc_html__('Header Login Button Font', 'skrn-progression'),
        'tab'        => 'progression-studios-header-button-typography',
        'properties' => array( 'selector'   => '#skrn-landing-login-logout-header a, #skrn-header-user-profile-login a.arm_form_popup_link' ),
 	'default' => array(
		'subset'                     => 'latin',
		'text_decoration'            => 'none',
 		),
    );
	 
	 
    $controls['progression_studios_button_font_family'] = array(
        'name'       => 'progression_studios_button_font_family',
 	'type'        => 'font',
        'title'      =>  esc_html__('Button Font Family', 'skrn-progression'),
        'tab'        => 'progression-studios-button-typography',
        'properties' => array( 'selector'   => 'a.progression-studios-skrn-slider-button, .tablet-mobile-video-search-header-buttons input, #skrn-landing-mobile-login-logout-header a, .video-search-header-buttons input, .tags-progression a, .tagcloud a, .post-password-form input[type=submit], #respond input.submit, .wpcf7-form input.wpcf7-submit' ),
 	'default' => array(
		'subset'                     => 'latin',
		'text_decoration'            => 'none',
 		),
    );
	 
	 
    $controls['progression_studios_sidebar_heading'] = array(
        'name'       => 'progression_studios_sidebar_heading',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Heading', 'skrn-progression'),
        'tab'        => 'progression-studios-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar h4.widget-title, .sidebar h2.widget-title' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
    $controls['progression_studios_sidebar_default'] = array(
        'name'       => 'progression_studios_sidebar_default',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Default Text', 'skrn-progression'),
        'tab'        => 'progression-studios-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
    $controls['progression_studios_sidebar_link'] = array(
        'name'       => 'progression_studios_sidebar_link',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Default Link', 'skrn-progression'),
        'tab'        => 'progression-studios-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar a' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['progression_studios_sidebar_link_hover'] = array(
        'name'       => 'progression_studios_sidebar_link_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Link Hover', 'skrn-progression'),
        'tab'        => 'progression-studios-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar ul li.current-cat, .sidebar ul li.current-cat a, .sidebar a:hover' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
    $controls['progression_studios_video_index_title'] = array(
        'name'       => 'progression_studios_video_index_title',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Title', 'skrn-progression'),
        'tab'        => 'progression-studios-video-index-options',
        'properties' => array( 'selector'   => 'h2.progression-video-title a' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 $controls['progression_studios_video_index_title_hover'] = array(
        'name'       => 'progression_studios_video_index_title_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Title Hover', 'skrn-progression'),
        'tab'        => 'progression-studios-video-index-options',
        'properties' => array( 'selector'   => 'h2.progression-video-title a:hover' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 $controls['progression_studios_video_index_excerpt'] = array(
        'name'       => 'progression_studios_video_index_excerpt',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Excerpt', 'skrn-progression'),
        'tab'        => 'progression-studios-video-index-options',
        'properties' => array( 'selector'   => '.progression-studios-video-index-excerpt' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
	 
	 $controls['progression_studios_video_post_title_video'] = array(
        'name'       => 'progression_studios_video_post_title_video',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Post Title', 'skrn-progression'),
        'tab'        => 'progression-studios-video-post-options',
        'properties' => array( 'selector'   => 'h2.content-sidebar-sub-header' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 $controls['progression_studios_video_post_meta_title_meta'] = array(
        'name'       => 'progression_studios_video_post_meta_title_meta',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Meta Headings', 'skrn-progression'),
        'tab'        => 'progression-studios-video-post-options',
        'properties' => array( 'selector'   => 'h4.content-sidebar-sub-header' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 $controls['progression_studios_video_post_meta_content'] = array(
        'name'       => 'progression_studios_video_post_meta_content',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Meta Text', 'skrn-progression'),
        'tab'        => 'progression-studios-video-post-options',
        'properties' => array( 'selector'   => '.content-sidebar-short-description, ul.video-director-mega-sidebar, .no-recent-reviews' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
	 
    $controls['progression_studios_search_headings'] = array(
        'name'       => 'progression_studios_search_headings',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Search Headings', 'skrn-progression'),
        'tab'        => 'progression-studios-dashboard-search',
        'properties' => array( 'selector'   => 'ul.skrn-video-search-columns h5' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
    $controls['progression_studios_username_font'] = array(
        'name'       => 'progression_studios_username_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Username Font', 'skrn-progression'),
        'tab'        => 'progression-studios-profile-header',
        'properties' => array( 'selector'   => '#header-user-profile-click' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
    $controls['progression_studios_username_font_hover'] = array(
        'name'       => 'progression_studios_username_font_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Username Hover', 'skrn-progression'),
        'tab'        => 'progression-studios-profile-header',
        'properties' => array( 'selector'   => '#header-user-profile.active #header-user-profile-click, #header-user-profile-click:hover' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['progression_studios_username_drop_down'] = array(
        'name'       => 'progression_studios_username_drop_down',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Dropdown Link', 'skrn-progression'),
        'tab'        => 'progression-studios-profile-header',
        'properties' => array( 'selector'   => '#header-user-profile-menu ul li a' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['progression_studios_username_drop_down_hover'] = array(
        'name'       => 'progression_studios_username_drop_down_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Dropdown Link Hover', 'skrn-progression'),
        'tab'        => 'progression-studios-profile-header',
        'properties' => array( 'selector'   => '#header-user-profile-menu ul li a:hover' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
	 
	 
	 
	// Return the controls.
    return $controls;
}
add_filter( 'tt_font_get_option_parameters', 'progression_studios_add_control_to_tab' );