<?php
/*
* WPVS THEME MANAGER
*/
class WPVS_THEME_INIT_MANAGER {

    public function __construct() {
        add_action( 'init' , array($this, 'wpvs_add_theme_support' ));
        add_filter('image_size_names_choose', array($this, 'wpvs_theme_custom_image_sizes'));
        add_filter( 'excerpt_length', array($this, 'wpvs_theme_set_excerpt_length'), 999);
    }

    public function wpvs_add_theme_support() {
        global $wpvs_theme_thumbnail_sizing;
        global $wpvs_theme_video_manager;
		$wpvs_theme_video_manager = new WPVS_Theme_Video_Manager();
        add_theme_support( 'menus' );
        add_theme_support('post-thumbnails');
        add_theme_support( 'html5', array( 'search-form' ) );
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'editor-styles' );
        add_editor_style( 'style-editor.css' );
        add_theme_support( 'dark-editor-style' );
        add_post_type_support( 'page', 'excerpt' );
        add_image_size('video-thumbnail', 640, 360, true);
        add_image_size('video-portrait', 380, 590, true);
        add_image_size('wpvs-theme-header', 1920, 0, false);
        register_nav_menus( array(
            'main' => 'Main',
            'footer' => 'Footer',
            'user' => 'User Menu'
        ));
        $wpvs_theme_directory_uri = get_template_directory_uri();
        $wpvs_thumbnail_layout = get_theme_mod('vs_thumbnail_style', 'landscape');
        if( $wpvs_thumbnail_layout == 'custom' ) {
            $wpvs_custom_thumbnail_width = get_theme_mod('wpvs_custom_thumbnail_size_width', '640');
            $wpvs_custom_thumbnail_height = get_theme_mod('wpvs_custom_thumbnail_size_height', '360');
            add_image_size('wpvs-custom-thumbnail-size', $wpvs_custom_thumbnail_width, $wpvs_custom_thumbnail_height, true);
        }

        $wpvs_theme_thumbnail_sizing = (object) array(
            'style'            => $wpvs_thumbnail_layout,
            'layout'           => 'video-thumbnail',
            'recommended_size' => '640px by 360px',
            'placeholder'      => $wpvs_theme_directory_uri.'/images/set-landscape.jpg',
            'width'            => 640,
            'height'           => 360,
        );
        if($wpvs_thumbnail_layout == 'portrait') {
            $wpvs_theme_thumbnail_sizing->layout = 'video-portrait';
            $wpvs_theme_thumbnail_sizing->recommended_size = '380px by 590px';
            $wpvs_theme_thumbnail_sizing->placeholder = $wpvs_theme_directory_uri.'/images/set-portrait.jpg';
            $wpvs_theme_thumbnail_sizing->width = 380;
            $wpvs_theme_thumbnail_sizing->height = 590;
        }
        if($wpvs_thumbnail_layout == 'custom') {
            $wpvs_custom_thumbnail_width = get_theme_mod('wpvs_custom_thumbnail_size_width', '640');
            $wpvs_custom_thumbnail_height = get_theme_mod('wpvs_custom_thumbnail_size_height', '360');
            $wpvs_theme_thumbnail_sizing->layout = 'wpvs-custom-thumbnail-size';
            $wpvs_theme_thumbnail_sizing->recommended_size = $wpvs_custom_thumbnail_width.'px by '.$wpvs_custom_thumbnail_height.'px';
            $wpvs_theme_thumbnail_sizing->width = $wpvs_custom_thumbnail_width;
            $wpvs_theme_thumbnail_sizing->height = $wpvs_custom_thumbnail_height;
        }
    }

    public function wpvs_theme_custom_image_sizes($sizes) {
        $custom_sizes = array(
            'video-thumbnail' => __('Video Landscape', 'wpvs-theme'),
            'video-portrait' => __('Video Portrait', 'wpvs-theme'),
            'wpvs-theme-header' => __('Featured Header', 'wpvs-theme'),
            'wpvs-custom-thumbnail-size' => __('Custom Video Thumbnail', 'wpvs-theme'),
        );
        return array_merge( $sizes, $custom_sizes );
    }

    public function wpvs_theme_set_excerpt_length( $length ) {
        return 35;
    }

    public function create_theme_widget($widget_name, $widget_id, $widget_description) {
    	register_sidebar(array(
    		'name' => $widget_name,
    		'id' => $widget_id,
    		'description' => $widget_description,
    		'before_widget' => '',
    		'after_widget' => '',
    		'before_title' => '<h5>',
    		'after_title' => '</h5>'
    	));
    }
}

$wpvs_init_theme_manager = new WPVS_THEME_INIT_MANAGER();
$wpvs_init_theme_manager->create_theme_widget(__( 'Left Footer', 'wpvs-theme'), 'footer_left', __( 'Displays in the left of the footer', 'wpvs-theme'));
$wpvs_init_theme_manager->create_theme_widget(__( 'Middle Footer', 'wpvs-theme'), 'footer_middle', __( 'Displays in the middle of the footer', 'wpvs-theme'));
$wpvs_init_theme_manager->create_theme_widget(__( 'Right Footer', 'wpvs-theme'), 'footer_right', __( 'Displays in the right of the footer', 'wpvs-theme'));
$wpvs_init_theme_manager->create_theme_widget(__( 'Video Sidebar', 'wpvs-theme'), 'video_right', __( 'Displays in the right of the video pages.', 'wpvs-theme'));
$wpvs_init_theme_manager->create_theme_widget(__( 'Page Sidebar', 'wpvs-theme'), 'page_right', __( 'Displays on the right side of page.', 'wpvs-theme'));
$wpvs_init_theme_manager->create_theme_widget(__( 'Blog Sidebar', 'wpvs-theme'), 'blog_right', __( 'Displays on the right side of blog posts and blog page.', 'wpvs-theme'));
