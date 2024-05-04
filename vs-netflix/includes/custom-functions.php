<?php

function rvs_featured_youtube_url($url) {
    $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}

if( ! function_exists('wpvs_theme_get_video_thumbnail')) {
function wpvs_theme_get_video_thumbnail($post_id, $get_wpvs_image_size) {
    global $wpvs_theme_thumbnail_sizing;
    $wpvs_image_thumbnail_size = $wpvs_theme_thumbnail_sizing->layout;
    $wpvs_image_thumbnail_width = $wpvs_theme_thumbnail_sizing->width;
    $wpvs_image_thumbnail_height = $wpvs_theme_thumbnail_sizing->height;
    if( ! empty($get_wpvs_image_size) && $get_wpvs_image_size != $wpvs_theme_thumbnail_sizing->style ) {
        if( $get_wpvs_image_size == 'landscape' ) {
            $wpvs_image_thumbnail_size = 'video-thumbnail';
            $wpvs_image_thumbnail_width = 640;
            $wpvs_image_thumbnail_height = 360;
        }
        if($get_wpvs_image_size == 'portrait') {
            $wpvs_image_thumbnail_size = 'video-portrait';
            $wpvs_image_thumbnail_width = 380;
            $wpvs_image_thumbnail_height = 590;
        }
        if($get_wpvs_image_size == 'custom') {
            $wpvs_image_thumbnail_size = 'wpvs-custom-thumbnail-size';
        }
    }

    $wpvs_video_image_src = null;
    $wpvs_video_image_srcset = null;
    $video_thumbnail_id = get_post_meta($post_id, 'wpvs_thumbnail_image_id', true);
    if( ! empty($video_thumbnail_id) ) {
        $wpvs_video_image_src = wp_get_attachment_image_src($video_thumbnail_id, $wpvs_image_thumbnail_size, false);
        if( ! empty($wpvs_video_image_src) && isset($wpvs_video_image_src[0]) ) {
            $wpvs_video_image_src = $wpvs_video_image_src[0];
        }
        $wpvs_video_image_srcset = wp_get_attachment_image_srcset($video_thumbnail_id, array($wpvs_image_thumbnail_width,$wpvs_image_thumbnail_height));
    } else {
        $wpvs_video_image_src = get_post_meta($post_id, 'rvs_thumbnail_image', true);
    }
    if( empty($wpvs_video_image_src) && has_post_thumbnail($post_id) ) {
        $video_thumbnail_id = get_post_thumbnail_id($post_id);
        $wpvs_video_image_src = wp_get_attachment_image_src($video_thumbnail_id, $wpvs_image_thumbnail_size, false)[0];
        $wpvs_video_image_srcset = wp_get_attachment_image_srcset($video_thumbnail_id, array($wpvs_image_thumbnail_width,$wpvs_image_thumbnail_height));
    }
    return (object) array('src' => $wpvs_video_image_src, 'srcset' => $wpvs_video_image_srcset);
}
}


if( ! function_exists('wpvs_theme_get_video_header_image')) {
function wpvs_theme_get_video_header_image($post_id) {
    if(has_post_thumbnail($post_id)) {
        $featured_id = get_post_thumbnail_id($post_id);
        $video_image = wp_get_attachment_image_src($featured_id, 'wpvs-theme-header', true)[0];
        if(empty($video_image)) {
            $video_image = wp_get_attachment_image_src($featured_id, 'full', true)[0];
        }
    } else {
        $video_image = get_post_meta($post_id, 'wpvs_featured_image', true);
    }
    if( empty($video_image) ) {
        $video_image = get_template_directory_uri() . '/images/video-featured.jpg';
    }
    return $video_image;
}
}

if( ! function_exists('wpvs_theme_get_video_details')) {
function wpvs_theme_get_video_details($post_id, $echo) {
    global $wpvs_genre_slug_settings;
    global $wpvs_actor_slug_settings;
    global $wpvs_director_slug_settings;
    $wpvs_video_review_ratings = get_theme_mod('wpvs_video_review_ratings', 0);
    $video_details = "";
    $tags = get_the_terms($post_id, 'rvs_video_tags');
    $genres = get_the_terms($post_id, 'rvs_video_category');

    $actor_term_args = array(
        'order' => 'ASC',
    );
    if( isset($wpvs_actor_slug_settings['ordering']) && $wpvs_actor_slug_settings['ordering'] == 'order' ) {
        $actor_term_args['meta_key'] = 'wpvs_display_order';
        $actor_term_args['orderby']  =  'meta_value_num';
    }
    $actors = wp_get_post_terms($post_id, 'rvs_actors', $actor_term_args);

    $director_term_args = array(
        'order' => 'ASC',
    );
    if( isset($wpvs_director_slug_settings['ordering']) && $wpvs_director_slug_settings['ordering'] == 'order' ) {
        $director_term_args['meta_key'] = 'wpvs_display_order';
        $director_term_args['orderby']  =  'meta_value_num';
    }
    $directors = wp_get_post_terms($post_id, 'rvs_directors', $director_term_args);

    if( $wpvs_video_review_ratings && comments_open($post_id) ) {
        $video_details .= '<div class="wpvs-video-average-rating">';
        $current_video_link = get_permalink($post_id) . '#comments';
        $video_average_rating = get_post_meta($post_id, 'wpvs_video_average_rating', true);
        $video_review_args = array(
            'post_id' => $post_id,
            'fields' => 'ids',
            'status' => 'approve',
            'meta_query' => array(
                array(
                    'key' => 'wpvs_video_rating',
                    'compare' => 'EXISTS'
                )
            )
        );
        $video_reviews = get_comments($video_review_args);
        $count_video_ratings = 0;
        if( ! empty($video_average_rating) && ! empty($video_reviews) ) {
            $count_video_ratings = count($video_reviews);
            for( $rating_a = 1; $rating_a <= 5; $rating_a++ ) {
                if( $rating_a <= $video_average_rating ) {
                    $video_details .= '<span class="dashicons dashicons-star-filled wpvs-video-rating-star-complete active"></span>';
                } else if($rating_a == ceil($video_average_rating) && fmod($video_average_rating, 1) != 0 ) {
                    $video_details .= '<span class="dashicons dashicons-star-half wpvs-video-rating-star-complete active"></span>';
                } else {
                    $video_details .= '<span class="dashicons dashicons-star-empty wpvs-video-rating-star-complete"></span>';
                }
            }
            $video_details .= '<label class="wpvs-video-rating-based">'.sprintf(__('based on <a class="wpvs-review-anchor" href="%s">%d reviews</a>', 'wpvs-theme'), $current_video_link, $count_video_ratings).'</label></div>';
        } else {
            $video_details .= '<label class="wpvs-video-rating-based">'.sprintf(__('No reviews yet. <a class="wpvs-review-anchor" href="%s">Leave A Review</a>', 'wpvs-theme'), $current_video_link).'</label></div>';
        }
    }

    if(!empty($actors)) {
        $video_details .= '<div id="wpvs-actor-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_actor_slug_settings['icon'].'"></span>'.$wpvs_actor_slug_settings['name-plural'].': ';
        foreach($actors as $actor) {
            $actor_link = get_term_link($actor->term_id);
            $video_details .= '<a href="'.$actor_link.'">'.$actor->name.'</a>';
            if ($actor != end($actors)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if(!empty($directors)) {
        if(count($directors) > 1) {
            $directors_text = $wpvs_director_slug_settings['name-plural'];
        } else {
            $directors_text = $wpvs_director_slug_settings['name'];
        }
        $video_details .= '<div id="wpvs-director-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_director_slug_settings['icon'].'"></span>'.$directors_text.': ';
        foreach($directors as $director) {
            $director_link = get_term_link($director->term_id);
            $video_details .= '<a href="'.$director_link.'">'.$director->name.'</a>';
            if ($director != end($directors)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if(!empty($genres)) {
        $video_details .= '<div id="wpvs-genre-info-section" class="rvs-info-section"><span class="dashicons dashicons-'.$wpvs_genre_slug_settings['icon'].'"></span>'.$wpvs_genre_slug_settings['name-plural'].': ';
        foreach($genres as $genre) {
            $genre_link = get_term_link($genre->term_id);
            $video_details .= '<a href="'.$genre_link.'">'.$genre->name.'</a>';
            if ($genre != end($genres)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if(!empty($tags)) {
        $video_details .= '<div id="wpvs-tag-info-section" class="rvs-info-section"><span class="dashicons dashicons-tag"></span>';
        foreach($tags as $tag) {
            $tag_link = get_term_link($tag->term_id);
            $video_details .= '<a href="'.$tag_link.'">'.$tag->name.'</a>';
            if ($tag != end($tags)) {
                $video_details .= ', ';
            }
        }
        $video_details .= '</div>';
    }

    if($echo) {
        echo $video_details;
    } else {
        return $video_details;
    }
}
}

if( ! function_exists('wpvs_theme_get_audio_player')) {
function wpvs_theme_get_audio_player($post_id) {
    $wpvs_audio_player_code = "";
    $wpvs_audio_file_url = get_post_meta($post_id, 'wpvs_audio_file_url', true);
    $wpvs_audio_custom_html = get_post_meta($post_id, 'wpvs_audio_custom_html', true);
    if( ! empty($wpvs_audio_file_url) ) {
        $wpvs_audio_player_code = '<audio id="wpvs_audio_player" src="'.$wpvs_audio_file_url.'" controls controlsList="nodownload"></audio>';
    }
    if( empty($wpvs_audio_player_code) && ! empty($wpvs_audio_custom_html) ) {
        $wpvs_audio_player_code = $wpvs_audio_custom_html;
    }
    return $wpvs_audio_player_code;
}
}

if( ! function_exists('wpvs_theme_get_video_information')) {
function wpvs_theme_get_video_information($post_id) {
    global $wpvs_theme_rating_icons;
    $video_information_string = "";
    $wpvs_video_information = get_post_meta($post_id, 'wpvs_video_information', true);
    $wpvs_video_length = get_post_meta($post_id, 'wpvs_video_length', true);
    $wpvs_video_rating = get_post_meta($post_id, 'wpvs_video_rating', true);

    if( empty($wpvs_video_information) && ! empty($wpvs_video_length) ) {
        $wpvs_video_hours = intval(gmdate("H", $wpvs_video_length));
        $wpvs_video_minutes = intval(gmdate("i", $wpvs_video_length));
        $wpvs_video_information = array(
            'length' => $wpvs_video_length,
            'hours' => $wpvs_video_hours,
            'minutes' => $wpvs_video_minutes,
            'date_released' => ""
        );
    }

    if( ! empty($wpvs_video_information) ) {
        $video_information_string .= '<div class="wpvs-video-information-section">';

        if( isset($wpvs_video_information['date_released']) && ! empty($wpvs_video_information['date_released']) ) {
            $video_information_string .= '<span class="wpvs-video-release-date">'.$wpvs_video_information['date_released'].'</span>';
        }
        if( ( isset($wpvs_video_information['hours']) && ! empty($wpvs_video_information['hours']) ) || ( isset($wpvs_video_information['minutes']) && ! empty($wpvs_video_information['minutes']) ) ) {
            $video_information_string .= ' <span class="wpvs-video-length"><span class="dashicons dashicons-clock"></span>';
            if( isset($wpvs_video_information['hours']) && ! empty($wpvs_video_information['hours']) ) {
                $video_information_string .= $wpvs_video_information['hours'].'h ';
            }
            if( isset($wpvs_video_information['minutes']) && ! empty($wpvs_video_information['minutes']) ) {
                $video_information_string .= $wpvs_video_information['minutes'].'m';
            }
            $video_information_string .= '</span>';
        }
        if( ! empty($wpvs_video_rating) && ! empty($wpvs_theme_rating_icons) ) {
            $video_information_string .= '<span class="wpvs-video-rating">'.$wpvs_theme_rating_icons->$wpvs_video_rating.'</span>';
        }
        $video_information_string .= '</div>';
    }
    return $video_information_string;
}
}

if( ! function_exists('wpvs_add_user_menu')) {
function wpvs_add_user_menu( $items, $args ) {
    $wpvs_show_login = get_theme_mod('vs_menu_login', 0);
    if($wpvs_show_login && $args->theme_location == "main") {
        if(is_user_logged_in()) {
            ob_start();
            include(WPVS_THEME_BASE_DIR.'/user/user-menu.php');
            $items .= ob_get_contents();
            ob_end_clean();
        } else {
            $wpvs_sign_in_text = get_theme_mod('vs_menu_login_text', 'Sign In');
            $wpvs_login_link = get_theme_mod('wpvs_login_link');
            if($wpvs_login_link != "default" && !empty(get_permalink($wpvs_login_link))) {
                $user_login_link = get_permalink($wpvs_login_link);
            } else {
                $user_login_link = wp_login_url();
            }
            $items .= '<li><a class="sign-in-link" href="' . $user_login_link . '"><span class="dashicons dashicons-admin-users"></span> ' . $wpvs_sign_in_text . '</a></li>';
        }
    }
    return $items;
}
}
add_filter( 'wp_nav_menu_items', 'wpvs_add_user_menu', 10, 2 );

// GET VIDEO HTML CODE
if( ! function_exists('wpvs_get_video_html_code')) {
function wpvs_get_video_html_code($post_id) {
    $video_html = array();
    $rvs_video_type = get_post_meta($post_id, '_rvs_video_type', true);
    if(empty($rvs_video_type)) {
        $rvs_video_type = "vimeo";
    }
    if($rvs_video_type == "wordpress") {
        $rvs_wordpress_code = get_post_meta($post_id, 'rvs_video_wordpress_code', true);
        if( ! empty($rvs_wordpress_code) ) {
             $video_html['video'] = do_shortcode($rvs_wordpress_code);
        }
    }

    if($rvs_video_type == "shortcode") {
        $rvs_shortcode_video = get_post_meta($post_id, 'rvs_shortcode_video', true);
        $rvs_shortcode_video_check = get_post_meta($post_id, 'rvs_shortcode_video_check', true);
        if(! empty($rvs_shortcode_video_check) && shortcode_exists($rvs_shortcode_video_check)) {
            $video_html['video'] = do_shortcode($rvs_shortcode_video);
        } else {
            $video_html['video'] = '<div class="text-align-center">'. __('Something is wrong with this videos Shortcode', 'wpvs-theme') . '</div>';
        }
    }

    if($rvs_video_type == "vimeo") {
        $video_vimeo_id = get_post_meta($post_id, 'rvs_video_post_vimeo_id', true);
        $video_html['video'] = '<div id="wpvs-vimeo-video" class="wpvs-vimeo-video-player" data-vimeo-id="'.$video_vimeo_id.'"></div>';
    }

    if($rvs_video_type == "youtube") {
        $video_html['video'] = get_post_meta($post_id, 'rvs_video_post_vimeo_html', true);
    }

    if($rvs_video_type == "custom") {
        $video_html['video'] = get_post_meta($post_id, 'rvs_video_custom_code', true);
    }

    if($rvs_video_type == "jwplayer") {
        $video_html['video'] = get_post_meta($post_id, 'rvs_video_custom_code', true);
    }

    // GET TRAILER
    $wpvs_video_trailer_enabled = get_post_meta($post_id, 'rvs_trailer_enabled', true); // Check if trailer is enabled
    if($wpvs_video_trailer_enabled) {
        $rvs_trailer_type = get_post_meta($post_id, '_rvs_trailer_type', true);
        if(empty($rvs_trailer_type)) {
            $rvs_trailer_type = "vimeo";
        }
        if($rvs_trailer_type == "wordpress") {
            $rvs_trailer_wordpress_code = get_post_meta($post_id, 'rvs_trailer_wordpress_code', true);
            if( ! empty($rvs_trailer_wordpress_code) ) {
                 $video_html['trailer'] = do_shortcode($rvs_trailer_wordpress_code);
            }
        }

        if($rvs_trailer_type == "vimeo") {
            $trailer_vimeo_id = get_post_meta($post_id, 'rvs_trailer_vimeo_id', true);
            $video_html['trailer'] = '<div id="wpvs-vimeo-trailer" class="wpvs-vimeo-video-player" data-vimeo-id="'.$trailer_vimeo_id.'"></div>';
        }

        if($rvs_trailer_type == "youtube") {
            $video_html['trailer'] = get_post_meta($post_id, 'rvs_trailer_html', true);
        }

        if($rvs_trailer_type == "custom") {
            $video_html['trailer'] = get_post_meta($post_id, 'rvs_trailer_custom_code', true);
        }

        if($rvs_trailer_type == "jwplayer") {
            $video_html['trailer'] = get_post_meta($post_id, 'rvs_trailer_custom_code', true);
        }
    }
    return $video_html;
}
}

if( ! function_exists('wpvs_theme_get_show_thumbnail')) {
function wpvs_theme_get_show_thumbnail($term_id, $get_wpvs_image_size) {
    global $wpvs_theme_thumbnail_sizing;

    $wpvs_image_thumbnail_size = $wpvs_theme_thumbnail_sizing->layout;
    $wpvs_image_thumbnail_width = $wpvs_theme_thumbnail_sizing->width;
    $wpvs_image_thumbnail_height = $wpvs_theme_thumbnail_sizing->height;
    if( ! empty($get_wpvs_image_size) && $get_wpvs_image_size != $wpvs_theme_thumbnail_sizing->style ) {
        if($get_wpvs_image_size == 'landscape' ) {
            $wpvs_image_thumbnail_size = 'video-thumbnail';
            $wpvs_image_thumbnail_width = 640;
            $wpvs_image_thumbnail_height = 360;
        }
        if($get_wpvs_image_size == 'portrait') {
            $wpvs_image_thumbnail_size = 'video-portrait';
            $wpvs_image_thumbnail_width = 380;
            $wpvs_image_thumbnail_height = 590;
        }
        if($get_wpvs_image_size == 'custom') {
            $wpvs_image_thumbnail_size = 'wpvs-custom-thumbnail-size';
        }
    }

    $wpvs_video_image_src = null;
    $wpvs_video_image_srcset = null;

    $cat_thumbnail_image_id = get_term_meta($term_id, 'wpvs_video_cat_attachment', true);
    if( ! empty($cat_thumbnail_image_id) ) {
        $wpvs_video_image_src = wp_get_attachment_image_src($cat_thumbnail_image_id, $wpvs_image_thumbnail_size, false)[0];
        $wpvs_video_image_srcset = wp_get_attachment_image_srcset($cat_thumbnail_image_id, array($wpvs_image_thumbnail_width,$wpvs_image_thumbnail_height));
    } else {
        $wpvs_video_image_src =  get_term_meta($term_id, 'wpvs_video_cat_thumbnail', true);
    }
    return (object) array('src' => $wpvs_video_image_src, 'srcset' => $wpvs_video_image_srcset);
}
}

function wpvs_create_my_list_button($video_id) {
    global $wpvs_current_user;
    $trans_my_list = __('My List', 'wpvs-theme');
    $button_text = '<span class="dashicons dashicons-plus"></span>'.$trans_my_list;
    $add_to_list_button = array('id' => $video_id, 'type' => 'video', 'html' => $button_text, 'add' => true);
    if($wpvs_current_user) {

        // CHECK USER VIDEO LIST
        $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
        if( ! empty($users_video_list) ) {
            foreach($users_video_list as $video_list_item) {
                if($video_list_item['id'] == $add_to_list_button['id']) {
                    $add_to_list_button['html'] = '<span class="dashicons dashicons-yes"></span>'.$trans_my_list;
                    $add_to_list_button['add'] = false;
                }
            }
        }
    }
    return $add_to_list_button;
}

if( ! function_exists('wpvs_get_video_link')) {
    function wpvs_get_video_link($video_id) {
        $video_link = get_permalink($video_id);
        $video_link_setting = get_post_meta($video_id, 'rvs_video_home_link', true);
        $video_custom_url = get_post_meta($video_id, 'wpvs_video_custom_slide_link', true);
        switch($video_link_setting) {
            case 'video':
            break;
            case 'customurl':
                $video_link = get_post_meta($video_id, 'wpvs_video_custom_slide_link', true);
            break;
            default:
                if( ! empty($video_link_setting) && $video_link_setting != 'video' ) {
                    if( ! is_wp_error( get_term_link(intval($video_link_setting), 'rvs_video_category') ) ) {
                        $video_link = get_term_link(intval($video_link_setting), 'rvs_video_category');
                    }
                }
        }

        $wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
        if( $wpvs_open_videos_in_full_screen && $video_link_setting != 'customurl' ) {
            if(strpos($video_link, '?page_id') || strpos($video_link, '?')) {
                $video_link .= '&';
            } else {
                $video_link .= '?';
            }
            $video_link .= 'wpvsopen=1';
        }
        return $video_link;
    }
}

if( ! function_exists('wpvs_generate_thumbnail_link')) {
    function wpvs_generate_thumbnail_link($url) {
        $wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
        if( $wpvs_open_videos_in_full_screen ) {
            if(strpos($url, '?page_id') || strpos($url, '?')) {
                $url .= '&';
            } else {
                $url .= '?';
            }
            $url .= 'wpvsopen=1';
        }
        return $url;
    }
}

function wpvs_generate_term_slide_thumbnails($video_category) {
    $video_slides = array();
    $contains_shows = get_term_meta($video_category->term_id, 'cat_contains_shows', true);
    $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($video_category->term_id);
    $children_shows = get_terms($wpvs_taxonomy_settings);
    if($contains_shows) {
        if( ! empty($children_shows) ) {
            foreach($children_shows as $child) {
                $video_slides[] = (object) array(
                    'ID'   => $child->term_id,
                    'type' => 'show',
                );
            }
        }
    } else {
        if( ! empty($children_shows) ) {
            foreach($children_shows as $show_child) {
                $child_contains_shows = get_term_meta($show_child->term_id, 'cat_contains_shows', true);
                if($child_contains_shows) {
                    $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($show_child->term_id);
                    $sub_child_shows = get_terms($wpvs_taxonomy_settings);
                    if( ! empty($sub_child_shows) ) {
                        foreach($sub_child_shows as $sub_show_child) {
                            $sub_child_has_seasons = get_term_meta($sub_show_child->term_id, 'cat_has_seasons', true);
                            if($sub_child_has_seasons) {
                                $video_slides[] = (object) array(
                                    'ID'   => $sub_show_child->term_id,
                                    'type' => 'show',
                                );
                            }
                        }
                    }
                }
            }
        }
    }
    return $video_slides;
}

function wpvs_generate_video_slide_thumbnail($video_id, $video_type, $wpvs_term) {
    global $wpvs_current_user;
    $users_continue_watching_list = array();
    if( ! empty($wpvs_current_user) ) {
        $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
        $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
    }
    $video_slide_details = (object) array('video_id' => $video_id, 'type' => $video_type);

    if( $video_type == 'video' && ! empty( get_post($video_id) ) ) {
        $video_title = get_the_title($video_id);
        $video_link = get_the_permalink($video_id);
        $video_link = wpvs_generate_thumbnail_link($video_link);
        $video_thumbnail = wpvs_theme_get_video_thumbnail($video_id, null);
        $video_excerpt = get_the_excerpt($video_id);
        $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
        $video_slide_details->video_title = $video_title;
        $video_slide_details->video_excerpt = $video_excerpt;
        $video_slide_details->video_thumbnail = $video_thumbnail;
        $video_slide_details->video_link = $video_link;
        $video_slide_details->new_tab = $open_in_new_tab;

        // CHECK CONINUE WATCHING LIST
        if( ! empty($users_continue_watching_list) ) {
            $percentage_complete = $wpvs_theme_user->get_video_percentage_complete($video_id);
            $video_slide_details->percent_complete = $percentage_complete;
        }
    }

    if( $video_type == 'show' ) {
        $term_id = intval($video_id);
        $wpvs_term_link = get_term_link($term_id, 'rvs_video_category');
        $wpvs_term_title = $wpvs_term->name;
        $show_thumbnail_image = wpvs_theme_get_show_thumbnail($term_id, null);
        if( ! empty($wpvs_term->parent) ) {
            $wpvs_parent_term = get_term(intval($wpvs_term->parent), 'rvs_video_category' );
            if( ! empty($wpvs_parent_term) && ! is_wp_error($wpvs_parent_term) ) {
                $wpvs_term_title .= ' ('.$wpvs_parent_term->name.')';
            }
        }
        $video_slide_details->video_title = $wpvs_term_title;
        $video_slide_details->video_excerpt = wp_strip_all_tags($wpvs_term->description);
        $video_slide_details->video_thumbnail = $show_thumbnail_image;
        $video_slide_details->video_link = $wpvs_term_link;
        $video_slide_details->new_tab = 0;
    }

    return $video_slide_details;
}

function wpvs_theme_create_slider_from_videos($video_list, $title, $title_link, $wpvs_parameters) {
    global $vs_dropdown_details;
    global $wpvs_theme_thumbnail_sizing;
    $wpvs_slider_content = "";
    $wpvs_clean_layout = false;
    $get_wpvs_image_size = null;
    $video_slides = array();
    $users_continue_watching_list = null;
    $wpvs_disable_lazy_load_slide_images = get_option('wpvs_disable_lazy_load_slide_images', 0);
    $wpvs_slide_info_position = get_option('wpvs_video_slide_info_position', 'overlay');
    $wpvs_show_see_all_link = get_option('wpvs_show_see_all_link_about_sliders', 0);

    if( is_user_logged_in() ) {
        global $wpvs_current_user;
        if( $wpvs_current_user ) {
            $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
            $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
        }
    }

    if( isset($wpvs_parameters['style']) && $wpvs_parameters['style'] == "clean" ) {
        $wpvs_clean_layout = true;
    }


    if( isset($wpvs_parameters['image_size']) && ! empty($wpvs_parameters['image_size']) ) {
        $get_wpvs_image_size = sanitize_text_field($wpvs_parameters['image_size']);
    }

    if( ! empty($video_list) ) {
        foreach($video_list as $video) {
            $add_video_details = (object) array('id' => $video->ID, 'type' => 'video');
            if( isset($video->type) ) {
                $add_video_details->type = $video->type;
            }

            if( $add_video_details->type == 'show' ) {
                $term_id = intval($video->ID);
                $wpvs_term = get_term($term_id, 'rvs_video_category');
                if( $wpvs_term ) {
                    $wpvs_term_title = $wpvs_term->name;
                    $wpvs_term_link =  get_term_link($term_id);
                    $show_thumbnail_image = wpvs_theme_get_show_thumbnail($term_id, $get_wpvs_image_size);
                    if( ! empty($wpvs_term->parent) ) {
                        $wpvs_parent_term = get_term(intval($wpvs_term->parent), 'rvs_video_category' );
                        if( ! empty($wpvs_parent_term) && ! is_wp_error($wpvs_parent_term) ) {
                            $wpvs_term_title .= ' ('.$wpvs_parent_term->name.')';
                        }
                    }
                    $add_video_details->title = $wpvs_term_title;
                    $add_video_details->link = $wpvs_term_link;
                    $add_video_details->image = $show_thumbnail_image;
                    $add_video_details->description = wp_strip_all_tags($wpvs_term->description);
                }
            } else {
                $video_link = wpvs_get_video_link($video->ID);
                $video_thumbnail = wpvs_theme_get_video_thumbnail($video->ID, $get_wpvs_image_size);
                $open_in_new_tab = get_post_meta($video->ID, 'wpvs_open_video_in_new_tab', true);
                $add_video_details->title = $video->post_title;
                $add_video_details->link = $video_link;
                $add_video_details->image = $video_thumbnail;
                $add_video_details->description = wp_strip_all_tags($video->post_excerpt);
                $add_video_details->new_tab = $open_in_new_tab;
                $add_video_details->text_label = get_post_meta($video->ID, 'wpvs_thumbnail_label', true);

                if( ! isset($video->percent_complete) ) {
                    // CHECK CONINUE WATCHING LIST
                    if( ! empty($users_continue_watching_list) ) {
                        $percentage_complete = $wpvs_theme_user->get_video_percentage_complete($video->ID);
                        $add_video_details->percent_complete = $percentage_complete;
                    }
                } else {
                    $add_video_details->percent_complete = $video->percent_complete;
                }
            }
            if( isset($add_video_details->title) ) {
                $video_slides[] = $add_video_details;
            }
        }
        if( ! empty($video_slides) ) {
            $recent_item_count = count($video_slides);
            $wpvs_slider_content .= '<div class="video-category slide-category slide-container';
            if( $wpvs_clean_layout ) {
                $wpvs_slider_content .= ' slide-shortcode';
                if( ! empty($wpvs_slide_info_position) && $wpvs_slide_info_position == 'below' ) {
                    $wpvs_slider_content .= ' wpvs-slide-info-below';
                }
            }
            $wpvs_slider_content .= '"><div class="wpvs-slider-title border-box';

            if( empty($title_link) ) {
                $wpvs_slider_content .= '">';
                $wpvs_slider_content .= '<h3>'.$title.'</h3>';
            } else {
                if($wpvs_show_see_all_link ) {
                    $wpvs_slider_content .= ' wpvs-grid-slider-title';
                }
                $wpvs_slider_content .= '">';
                $wpvs_slider_content .= '<a href="'.$title_link.'"><h3>'.$title;
                if( ! $wpvs_show_see_all_link ) {
                    $wpvs_slider_content .= ' <span class="dashicons dashicons-arrow-right-alt2"></span>';
                }
                $wpvs_slider_content .= '</h3></a>';
                if($wpvs_show_see_all_link ) {
                    $wpvs_slider_content .= '<a href="'.$title_link.'" class="wpvs-see-all-link">'.__('See All', 'wpvs-theme').' <span class="dashicons dashicons-arrow-right-alt2"></span></a>';
                }
            }
            $wpvs_slider_content .= '</div>'; // end slider title section

            $wpvs_slider_content .= '<div class="video-list-slider" data-items="'.$recent_item_count.'">';
            foreach($video_slides as $slide) {
                $wpvs_slider_content .= '<a class="video-slide" href="'.$slide->link.'"';
                if( isset($slide->new_tab) && $slide->new_tab ) {
                    $wpvs_slider_content .= ' target="_blank" ';
                }
                $wpvs_slider_content .= '>';
                $wpvs_slider_content .= '<div class="video-slide-image border-box">';
                if( isset($slide->image->src) && ! empty($slide->image->src) ) {
                    if( empty($wpvs_disable_lazy_load_slide_images) ) {
                        $wpvs_slider_content .= '<img src="'.$wpvs_theme_thumbnail_sizing->placeholder.'" data-lazy="'.$slide->image->src.'" alt="'.$slide->title.'" ';
                    } else {
                        $wpvs_slider_content .= '<img src="'.$slide->image->src.'" alt="'.$slide->title.'" ';
                    }
                    if( isset($slide->image->srcset) && ! empty($slide->image->srcset) ) {
                        $wpvs_slider_content .= 'srcset="'.$slide->image->srcset.'"';
                    }
                    $wpvs_slider_content .= ' />';
                } else {
                    $wpvs_slider_content .= '<div class="wpvs-no-slide-image"></div>';
                }

                if( isset($slide->percent_complete) && ! empty($slide->percent_complete) ) {
                    $wpvs_slider_content .= '<span class="wpvs-cw-progress-bar border-box" style="width: '.$slide->percent_complete.'%"></span>';
                }
                if( isset($slide->text_label) && ! empty($slide->text_label) ) {
                    $wpvs_slider_content .= '<span class="wpvs-thumbnail-text-label border-box">'.$slide->text_label.'</span>';
                }

                if($vs_dropdown_details) {
                    $wpvs_slider_content .= '<label class="show-vs-drop ease3" data-video="'.$slide->id.'" data-type="'.$slide->type.'"><span class="dashicons dashicons-arrow-down-alt2"></span></label>';
                }

                $wpvs_slider_content .= '</div>';
                $wpvs_slider_content .= '<div class="video-slide-details border-box">';
                $wpvs_slider_content .= '<h4>'.$slide->title.'</h4>';
                $wpvs_slider_content .= '<p class="slide-text">'.$slide->description.'</p></div>';
                $wpvs_slider_content .= '</a>';
            }
            $wpvs_slider_content .= '</div></div>';
            if($vs_dropdown_details) {
                $wpvs_slider_content .= '<div class="vs-video-description-drop border-box';
                if( $wpvs_clean_layout ) {
                    $wpvs_slider_content .= ' wpvs-shortcode-drop';
                }
                $wpvs_slider_content .= '"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>';
            }
        }
    }
    return $wpvs_slider_content;
}

if( ! function_exists('wpvs_theme_set_child_taxonomy_filters')) {
    function wpvs_theme_set_child_taxonomy_filters($term_id) {
        $order_sub_categories = get_term_meta($term_id, 'wpvs_sub_cat_order', true);
        $wpvs_taxonomy_settings = array(
            'taxonomy' => 'rvs_video_category',
            'parent' => $term_id,
        );
        if( ! empty($order_sub_categories) ) {
            if( $order_sub_categories == 'order' ) {
                $wpvs_taxonomy_settings['meta_key'] = 'video_cat_order';
                $wpvs_taxonomy_settings['orderby'] = 'meta_value_num';
                $wpvs_taxonomy_settings['order'] = 'ASC';
            } else {
                $wpvs_taxonomy_settings['orderby'] = $order_sub_categories;
            }
        }
        return $wpvs_taxonomy_settings;
    }
}

if( ! function_exists('wpvs_theme_get_price_starting_at_label')) {
    function wpvs_theme_get_price_starting_at_label($object_id, $object_type) {
        $wpvs_price_starting_at_text = __('Get Access', 'wpvs-theme');
        if( function_exists('wpvs_currency_label') ) {
            $set_wpvs_price_label = '';
            if( $object_type == 'video' ) {
                $video_purchase_price = get_post_meta( $object_id, '_rvs_onetime_price', true ); // GET ONETIME PRICE
                $video_rental_price = get_post_meta( $object_id, 'rvs_rental_price', true ); // GET RENTAL PRICE
                if( ! empty($video_purchase_price) ) {
                    $set_wpvs_price_label = wpvs_currency_label($video_purchase_price, 0, 0, false);
                }
                if( ! empty($video_rental_price) ) {
                    if( empty($video_purchase_price) || $video_rental_price < $video_purchase_price ) {
                        $set_wpvs_price_label = wpvs_currency_label($video_rental_price, 0, 0, false);
                    }
                }
            }
            if( ! empty($set_wpvs_price_label) ) {
                $wpvs_price_starting_at_text = get_option('wpvs_price_start_at_text', __( 'From', 'wpvs-theme' ));
                if( empty($wpvs_price_starting_at_text) ) {
                    $wpvs_price_starting_at_text = '';
                }
                $wpvs_price_starting_at_text .= ' ' . $set_wpvs_price_label;
            }
        }
        return $wpvs_price_starting_at_text;
    }
}
