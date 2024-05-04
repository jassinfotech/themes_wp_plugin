<?php

function wpvs_theme_ajax_url_variables() {
    global $wpvs_current_user;
    $wpvs_js_user_id = null;
    if($wpvs_current_user) {
        $wpvs_js_user_id = $wpvs_current_user->ID;
    }
?>
    <script type="text/javascript">
        var wpvs_theme_ajax_requests = <?php echo json_encode( array('ajaxurl' => admin_url( "admin-ajax.php" ), 'user' => $wpvs_js_user_id ) ); ?>;
    </script>
<?php }
add_action ( 'wp_head', 'wpvs_theme_ajax_url_variables' );

function wpvs_load_theme_styles() {
    global $post;
    global $vs_hide_search;
    global $wpvs_theme_current_version;
    $select_style = get_theme_mod('style_color', 'dark');
    $mobile_device_display = get_theme_mod('wpvs_slide_mobile_display', 0);
    $vs_thumbnail_hover_effect = get_theme_mod('vs_video_slide_hover_effect', 1);
    $wpvs_load_gutenberg_css = get_theme_mod('wpvs_load_gutenberg_css', 1);
    global $wpvs_theme_google_tracking;
    $wpvs_theme_directory = get_template_directory_uri();
    wp_register_style('wpvs-theme-update-loading-css', $wpvs_theme_directory . '/css/wpvs-theme-loading.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-slide-hover', $wpvs_theme_directory . '/css/slide-hover.css','', $wpvs_theme_current_version);
    wp_register_style( 'flexslider-styles',  $wpvs_theme_directory . '/css/flexslider.css' );
    wp_register_style( 'wpvs-featured-area', $wpvs_theme_directory . '/css/featured-sliders.css',array('flexslider-styles'), $wpvs_theme_current_version);
    wp_register_style( 'wordpress', $wpvs_theme_directory . '/css/wordpress.css','', $wpvs_theme_current_version);
	wp_register_style( 'normalize', $wpvs_theme_directory . '/css/normalize.css','', $wpvs_theme_current_version);
    wp_register_style( 'transitions', $wpvs_theme_directory . '/css/transitions.css','', $wpvs_theme_current_version);
    wp_register_style( 'layout', $wpvs_theme_directory . '/css/layout.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-buttons', $wpvs_theme_directory . '/css/buttons.css','', $wpvs_theme_current_version);
    wp_register_style( 'slick-css', $wpvs_theme_directory . '/css/slick.css','', $wpvs_theme_current_version);
    wp_register_style( 'slick-theme-css', $wpvs_theme_directory . '/css/slick-theme.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-slick-global', $wpvs_theme_directory . '/css/wpvs-slick-global.css','', $wpvs_theme_current_version);
    wp_register_style( 'header', $wpvs_theme_directory . '/css/header.css','', $wpvs_theme_current_version);
    wp_register_style( 'menu', $wpvs_theme_directory . '/css/menu.css','', $wpvs_theme_current_version);
	wp_register_style( 'main', $wpvs_theme_directory . '/style.css', '', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-user', $wpvs_theme_directory . '/css/user.css','', $wpvs_theme_current_version);
    wp_register_style( 'vs-forms', $wpvs_theme_directory . '/css/forms.css','', $wpvs_theme_current_version);
    wp_register_style( 'vs-search', $wpvs_theme_directory . '/css/search.css','', $wpvs_theme_current_version);
    wp_register_style( ''.$select_style.'', $wpvs_theme_directory . '/css/'.$select_style.'.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-theme-video', $wpvs_theme_directory . '/css/wpvs-theme-video.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-listings', $wpvs_theme_directory . '/css/video-listings.css','', $wpvs_theme_current_version);
    wp_register_style( 'font-awesome-brands', $wpvs_theme_directory . '/css/font-awesome/brands.css','', $wpvs_theme_current_version);
    wp_register_style( 'font-awesome', $wpvs_theme_directory . '/css/font-awesome/fontawesome.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-theme-mobile', $wpvs_theme_directory . '/css/mobile.css','', $wpvs_theme_current_version);
    wp_register_style( 'wpvs-theme-shortcodes', $wpvs_theme_directory . '/css/shortcodes.css',array('main'), $wpvs_theme_current_version);
    wp_register_style( 'wpvs-theme-memberships', $wpvs_theme_directory . '/css/memberships.css',array('main'), $wpvs_theme_current_version);
    wp_register_style( 'wpvs-video-reviews', $wpvs_theme_directory . '/css/wpvs-reviews.css',array('main'), $wpvs_theme_current_version);
    wp_register_style( 'wpvs-theme-gutenberg', $wpvs_theme_directory . '/css/gutenberg.css',array('main'), $wpvs_theme_current_version);
    wp_register_style( 'wpvs-cookie-notice', $wpvs_theme_directory . '/css/cookie-notice.css', '', $wpvs_theme_current_version);

    wp_enqueue_style('wpvs-theme-update-loading-css');
    wp_enqueue_style( 'wordpress' );
    wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'normalize' );
    wp_enqueue_style( 'transitions' );
    wp_enqueue_style( 'layout' );
    wp_enqueue_style( 'wpvs-buttons' );
    wp_enqueue_style( 'slick-css' );
    wp_enqueue_style( 'slick-theme-css' );
    wp_enqueue_style( 'wpvs-slick-global' );
    wp_enqueue_style( 'header' );
    wp_enqueue_style( 'menu' );
    wp_enqueue_style( 'wpvs-featured-area' );
	wp_enqueue_style( 'main' );
    wp_enqueue_style( 'wpvs-user' );
    wp_enqueue_style( 'vs-forms' );
    wp_enqueue_style( 'font-awesome-brands' );
    wp_enqueue_style( 'font-awesome' );
    wp_enqueue_style( ''.$select_style.'' );
    wp_enqueue_style( 'wpvs-theme-video' );
    wp_enqueue_style( 'wpvs-listings' );
    wp_enqueue_style( 'wpvs-theme-shortcodes' );
    if( $wpvs_load_gutenberg_css ) {
        wp_enqueue_style( 'wpvs-theme-gutenberg' );
    }
    if( get_option('wpvs_memberships_plugin_is_activated') ) {
        wp_enqueue_style( 'wpvs-theme-memberships' );
    }

    if(!$vs_hide_search) {
         wp_enqueue_style( 'vs-search' );
    }

    if($vs_thumbnail_hover_effect) {
        wp_enqueue_style( 'wpvs-slide-hover');
    }

    if(wp_is_mobile() && $mobile_device_display) {
         wp_enqueue_style( 'wpvs-theme-mobile' );
    }

    if( $post ) {
        $wpvs_page_featured_area = get_post_meta( $post->ID, 'wpvs_featured_area_slider', true );
        if( ! empty($wpvs_page_featured_area) ) {
            wp_enqueue_style( 'flexslider-styles' );
            wp_enqueue_style( 'wpvs-featured-area' );
        }
    }

    if( ! empty($wpvs_theme_google_tracking) && isset($wpvs_theme_google_tracking['cookie-notice']) ) {
        wp_enqueue_style( 'wpvs-cookie-notice' );
    }

    wp_enqueue_style( 'wpvs-video-reviews' );
}
add_action( 'wp_enqueue_scripts', 'wpvs_load_theme_styles' );


function wpvs_load_theme_js() {
    global $post;
    global $vs_hide_search;
    global $vs_dropdown_details;
    global $wpvs_watch_now_text;
    global $wpvs_theme_current_version;
    global $wpvs_profile_browsing;
    global $wpvs_current_user;
    $wpvs_theme_enable_smoothscroll = get_theme_mod('wpvs_theme_enable_smoothscroll', 1);
    $wpvs_is_mobile_browser = false;
    if( function_exists('wp_is_mobile') ) {
        $wpvs_is_mobile_browser = wp_is_mobile();
    }
    $wpvs_grid_count_variables = array(
        'large'   => get_theme_mod('wpvs_grid_count_large', 6),
        'desktop' => get_theme_mod('wpvs_grid_count_desktop', 5),
        'laptop'  => get_theme_mod('wpvs_grid_count_laptop', 4),
        'tablet'  => get_theme_mod('wpvs_grid_count_tablet', 3),
        'mobile'  => get_theme_mod('wpvs_grid_count_mobile', 2)
    );
    $wpvs_js_api_manager_params = array(
        'dropdown'    => $vs_dropdown_details,
        'count'       => $wpvs_grid_count_variables,
        'watchtext'   => $wpvs_watch_now_text,
        'resume_text' => __('Resume', 'wpvs-theme'),
        'url'         => rest_url('wp/v2/wpvsvideos'),
    );
    $wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
    $wpvs_show_more_videos_below_standard = get_theme_mod('wpvs_show_more_videos_below_standard', 0);
    $wpvs_theme_directory = get_template_directory_uri();
    wp_register_script( 'wpvs-theme-update-loading', $wpvs_theme_directory . '/js/wpvs-theme-loading.js',array('jquery'), $wpvs_theme_current_version);
    wp_register_script( 'flexslider-js', $wpvs_theme_directory . '/js/flexslider.js',array('jquery'), '', true );
    wp_register_script( 'google-maps-api', ("//maps.googleapis.com/maps/api/js?key=AIzaSyAmuO4M-_IoI2ZSfJcJ_33vrpEzeRhjGeQ&libraries=places"), false, '', true);
    wp_register_script( 'google-maps', $wpvs_theme_directory . '/js/google-maps.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'slick-js', $wpvs_theme_directory . '/js/slick.min.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'netslider-js', $wpvs_theme_directory . '/js/net-slider.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'video-ajax-js', $wpvs_theme_directory . '/js/video-ajax.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'user-videos-ajax-js', $wpvs_theme_directory . '/js/user-videos-ajax.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'vs-search-js', $wpvs_theme_directory . '/js/search.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-theme-js', $wpvs_theme_directory . '/js/theme.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'drop-details-js', $wpvs_theme_directory . '/js/video-drop.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-user-theme', $wpvs_theme_directory . '/js/wpvs-user.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'responsive-video-js', $wpvs_theme_directory . '/js/responsive-video.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'responsive-video-page-js', $wpvs_theme_directory . '/js/video-page.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-theme-video-js', $wpvs_theme_directory . '/js/wpvs-theme-video.js', array('jquery', 'vimeo-player-js', 'youtube-player-js'), $wpvs_theme_current_version, true );
    wp_register_script( 'vs-featured-slider', $wpvs_theme_directory . '/js/slider.js', array('jquery', 'flexslider-js', 'youtube-player-js', 'vimeo-player-js'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-theme-memberships-js', $wpvs_theme_directory . '/js/memberships.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-video-reviews-js', $wpvs_theme_directory . '/js/wpvs-reviews.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-user-video-tracking-js', $wpvs_theme_directory . '/js/wpvs-user-tracking.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_register_script( 'wpvs-theme-smooth-scrolling', $wpvs_theme_directory . '/js/smoothscroll.js', array('jquery'), $wpvs_theme_current_version, true );


    wp_enqueue_script('jquery');
    wp_enqueue_script('wpvs-theme-update-loading');
    wp_enqueue_script('wpvs-theme-js');
    if( $wpvs_theme_enable_smoothscroll ) {
        wp_enqueue_script('wpvs-theme-smooth-scrolling');
    }
    wp_enqueue_script( 'drop-details-js');
    wp_localize_script( 'drop-details-js', 'vsdrop',
        array(
            'url' => admin_url( 'admin-ajax.php' ),
            'watchtext' => $wpvs_watch_now_text,
            'fullscreen' => $wpvs_open_videos_in_full_screen,
            'is_mobile' => $wpvs_is_mobile_browser,
            'more_episodes' => __('More Episodes', 'wpvs-theme'),
            'resume_text' => __('Resume', 'wpvs-theme'),
            'is_mobile' => $wpvs_is_mobile_browser
        )
    );

    if( get_option('wpvs_memberships_plugin_is_activated') ) {
        wp_enqueue_script( 'wpvs-theme-memberships-js');
    }

    if( ! is_singular('rvs_video') ) {
        wp_enqueue_script( 'responsive-video-js' );
    } else {
        wp_enqueue_script( 'responsive-video-page-js' );
        $vs_display_layout = get_post_meta($post->ID, 'rvs_video_template', true);
        if(empty($vs_display_layout) || $vs_display_layout == "default") {
            $vs_display_layout = get_theme_mod('vs_single_layout', 'netflix');
        }

        $rvs_video_type = get_post_meta($post->ID, '_rvs_video_type', true);

        if($vs_display_layout == "netflix") {
            wp_enqueue_script( 'wpvs-theme-video-js' );
            $background_pan = get_theme_mod('vs_moving_background');
            if(empty($rvs_video_type)) {
                $rvs_video_type = "vimeo";
            }

            // GET TRAILER TYPE
            $rvs_trailer_type = get_post_meta($post->ID, '_rvs_trailer_type', true);

            if(empty($rvs_trailer_type)) {
                $rvs_trailer_type = "vimeo";
            }

            if($rvs_video_type == "vimeo" && !wp_script_is('vimeo-player-js', 'enqueued')) {
                wp_enqueue_script('vimeo-player-js');
            }

            if($rvs_video_type == "youtube" && ! wp_script_is('youtube-player-js', 'enqueued') ) {
                wp_enqueue_script('youtube-player-js' );
            }

            if($rvs_trailer_type == "vimeo" && !wp_script_is('vimeo-player-js', 'enqueued')) {
                wp_enqueue_script('vimeo-player-js');
            }

            if($rvs_trailer_type == "youtube" && !wp_script_is('youtube-player-js', 'enqueued')) {
                wp_enqueue_script('youtube-player-js' );
            }

            wp_localize_script( 'wpvs-theme-video-js', 'wpvs_single_video_data',
                array(
                    'videoid' => $post->ID,
                    'videotype' => $rvs_video_type,
                    'trailertype' => $rvs_trailer_type,
                    'websiteurl' => home_url(),
                    'panning' => $background_pan,
                    'is_mobile' => $wpvs_is_mobile_browser,
                )
            );
        }

        if($wpvs_show_more_videos_below_standard && ($vs_display_layout == "youtube" || $vs_display_layout == "standard") ) {
            $video_categories = wp_get_post_terms( $post->ID, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
            if( ! empty($video_categories) ) {
                $current_term_id = $video_categories[0]->term_id;
                $wpvs_js_api_manager_params['term_id'] = $current_term_id;
                $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsvideos?wpvsgenres='.$current_term_id);
                $wpvs_js_api_manager_params['video_id'] = $post->ID;
                wp_enqueue_script( 'video-ajax-js');
                wp_localize_script( 'video-ajax-js', 'wpvsapimanager', $wpvs_js_api_manager_params);
            }
        }

        if( is_user_logged_in() && get_post_type() == 'rvs_video' ) {
            $wpvs_video_type = get_post_type();
            if( $wpvs_video_type == 'rvs_video' ) {
                $wpvs_autoplay_enabled = get_option('rvs_video_autoplay', 0);
                $start_video_at = null;
                $users_continue_watching_list = get_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', true);
                if( ! empty($users_continue_watching_list) ) {
                    foreach($users_continue_watching_list as $continue_video) {
                        if($continue_video['id'] == $post->ID ) {
                            $start_video_at = $continue_video['current_time'];
                        }
                    }
                }
                wp_enqueue_script( 'wpvs-user-video-tracking-js' );
                wp_localize_script( 'wpvs-user-video-tracking-js', 'wpvs_video_tracking', array(
                    'video_type' => $rvs_video_type,
                    'current_video_id' => $post->ID,
                    'start_at' => $start_video_at,
                    'autoplay' => $wpvs_autoplay_enabled,
                ));
            }
        }
    }

    $slider_count_variables = array(
        'large'   => get_theme_mod('wpvs_visible_slide_count_large', 6),
        'desktop' => get_theme_mod('wpvs_visible_slide_count_desktop', 5),
        'laptop'  => get_theme_mod('wpvs_visible_slide_count_laptop', 4),
        'tablet'  => get_theme_mod('wpvs_visible_slide_count_tablet', 3),
        'mobile'  => get_theme_mod('wpvs_visible_slide_count_mobile', 2)
    );

    wp_enqueue_script( 'slick-js');
    wp_enqueue_script( 'netslider-js');
    wp_localize_script( 'netslider-js', 'slickslider', array(
        'count' => $slider_count_variables,
        'disable_lazy_load' => get_option('wpvs_disable_lazy_load_slide_images', 0),
    ));

    if( is_wpvs_custom_taxonomy() ) {
        global $wp_query;
        global $wpvs_videos_per_page;
        $current_term_type = null;
        $wpvs_current_term = $wp_query->get_queried_object();
        if( isset($wpvs_current_term->term_id) ) {
          $current_term_id = $wpvs_current_term->term_id;
        } else {
          $current_term_id = $wp_query->get_queried_object_id();
        }
        if( ! empty($current_term_id) ) {
          $video_cat_slideshow = get_term_meta($current_term_id, 'video_cat_slideshow', true);
        }
        if(is_tax('rvs_video_category')) {
            $current_term_type = 'category';
            $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsvideos?wpvsgenres='.$current_term_id);
            $wpvs_term_contains_shows = get_term_meta($current_term_id, 'cat_contains_shows', true);
            if( $wpvs_term_contains_shows ) {
                $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsgenres?parent='.$current_term_id);
            } else {
                $wpvs_term_has_seasons = get_term_meta($current_term_id, 'cat_has_seasons', true);
                if( $wpvs_term_has_seasons ) {
                    $wpvs_series_seasons = get_term_children($current_term_id, 'rvs_video_category');
                    if( ! empty($wpvs_series_seasons) ) {
                        $wpvs_js_api_manager_params['season_ids'] = $wpvs_series_seasons;
                        $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsvideos');
                    }
                } else {
                    /*
                    * this assumes we are viewing an empty category with sub categories that contain Series
                    * only loaded on Grid View
                    */
                    if( empty($wpvs_current_term->count) ) {
                        $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsgenres?tvshows=1');
                    }
                }
                if( get_term_meta($current_term_id, 'wpvs_is_season', true) ) {
                    $wpvs_js_api_manager_params['is_season'] = true;
                }
            }
        }
        if(is_tax('rvs_video_tags')) {
            $current_term_type = 'tag';
            $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsvideos?wpvsvideotags='.$current_term_id);
        }
        if(is_tax('rvs_actors')) {
            $current_term_type = 'actor';
            $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsvideos?wpvsactors='.$current_term_id);
            $wpvs_js_api_manager_params['episodes_filter'] = array(
                'taxonomy' => 'rvs_actors',
                'field' => 'term_id',
                'terms' => $current_term_id
            );
        }
        if(is_tax('rvs_directors')) {
            $current_term_type = 'director';
            $wpvs_js_api_manager_params['url'] = rest_url('wp/v2/wpvsvideos?wpvsdirectors='.$current_term_id);
            $wpvs_js_api_manager_params['episodes_filter'] = array(
                'taxonomy' => 'rvs_directors',
                'field' => 'term_id',
                'terms' => $current_term_id
            );
        }

        if( ! empty($current_term_id) ) {
            $wpvs_js_api_manager_params['term_id'] = $current_term_id;
        }

        if( ! empty($current_term_type) ) {
            $wpvs_js_api_manager_params['term_type'] = $current_term_type;
        }

        if( is_post_type_archive('rvs_video') && empty($current_term_id) ) {

        }

        wp_enqueue_script( 'video-ajax-js');
        wp_localize_script( 'video-ajax-js', 'wpvsapimanager', $wpvs_js_api_manager_params);

        if( ! empty($video_cat_slideshow) ) {
            wp_enqueue_script('youtube-player-js');
            wp_enqueue_script('vimeo-player-js');
            wp_enqueue_script( 'flexslider-js' );
            wp_enqueue_script( 'vs-featured-slider' );
            $slider_speed = get_theme_mod('vs_slide_speed', '4000');
            wp_localize_script( 'vs-featured-slider', 'wpvsslider',
                array(
                    'speed' => $slider_speed,
                    'pause_on_hover' => get_option('wpvs_featured_slides_hover', 1),
                )
            );
        }
    }
    if(is_page() || is_single()) {
        wp_enqueue_script( 'comment-reply' );
        wp_enqueue_script( 'wpvs-video-reviews-js');
    }

    if(!$vs_hide_search) {
        wp_enqueue_script('vs-search-js');
        wp_localize_script('vs-search-js', 'rvssearch', array( 'url' => admin_url( 'admin-ajax.php' ), 'profiles' => $wpvs_profile_browsing));
    }

    wp_enqueue_script('wpvs-user-theme');
    wp_localize_script('wpvs-user-theme', 'wpvs_user_js_vars', array( 'list_button_text' => __('My List', 'wpvs-theme'), 'list_adding_text' => __('Adding', 'wpvs-theme'), 'list_removing_text' => __('Removing', 'wpvs-theme'), 'notloggedin' => __('You must be logged in.', 'wpvs-theme')));

    if( $post ) {
        $wpvs_page_featured_area = get_post_meta( $post->ID, 'wpvs_featured_area_slider', true );
        $wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
    }

    if( ! empty($wpvs_page_featured_area) && ( empty($wpvs_page_featured_area_type) || $wpvs_page_featured_area_type == 'default') ) {
        wp_enqueue_script('youtube-player-js');
        wp_enqueue_script('vimeo-player-js');
        wp_enqueue_script( 'flexslider-js' );
        wp_enqueue_script( 'vs-featured-slider' );
        $slider_speed = get_theme_mod('vs_slide_speed', '4000');
        wp_localize_script( 'vs-featured-slider', 'wpvsslider',
            array(
                'speed' => $slider_speed,
                'pause_on_hover' => get_option('wpvs_featured_slides_hover', 1),
            )
        );
    }

}
add_action( 'wp_enqueue_scripts', 'wpvs_load_theme_js' );
