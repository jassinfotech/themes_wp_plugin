<?php

add_action( 'wp_ajax_wpvs_theme_search_videos_ajax', 'wpvs_theme_search_videos_ajax' );
add_action( 'wp_ajax_nopriv_wpvs_theme_search_videos_ajax', 'wpvs_theme_search_videos_ajax' );

function wpvs_theme_search_videos_ajax() {
    if(isset($_POST['search_term']) && !empty($_POST['search_term'])) {
        global $wpvs_genre_slug_settings;
        global $wpvs_actor_slug_settings;
        global $wpvs_director_slug_settings;
        global $wpvs_theme_video_manager;
        $match_term = $_POST['search_term'];
        $found_videos = array();
        $found_genres = array();
        $found_actors = array();
        $found_tags = array();
        $include_actors = array();
        $include_directors = array();
        $include_tags = array();
        $excluded_found_videos = array();
        $found_directors = array();
        $wpvs_home_url = home_url();

        $wpvs_profile_backup = get_template_directory_uri() .'/images/profile.png';
        $video_genres = get_terms(array(
            'taxonomy' => 'rvs_video_category',
            'hide_empty' => true
        ));

        $video_actors = get_terms(array(
            'taxonomy' => 'rvs_actors',
            'hide_empty' => false
        ));

        $video_directors = get_terms(array(
            'taxonomy' => 'rvs_directors',
            'hide_empty' => false
        ));

        $video_tags = get_terms(array(
            'taxonomy' => 'rvs_video_tags',
            'hide_empty' => false
        ));

        if( ! empty($video_genres) ) {
            foreach( $video_genres as $genre) {
                if(stripos($genre->name, $match_term) !== false) {
                    $genre_link = $wpvs_home_url.'/'.$wpvs_genre_slug_settings['slug'].'/'. $genre->slug;
                    $found_genres[] = array('genre_link' => $genre_link, 'genre_title' => $genre->name);
                }
            }
        }

        if( ! empty($video_actors) ) {
            foreach($video_actors as $actor) {
                if(stripos($actor->name, $match_term) !== false) {
                    $profile_image = get_term_meta($actor->term_id, 'wpvs_actor_profile', true);
                    if( empty($profile_image) ) {
                        $profile_image = $wpvs_profile_backup;
                    }
                    $imdb_link = get_term_meta($actor->term_id, 'wpvs_actor_imdb_link', true);
                    $actor_link = $wpvs_home_url.'/'.$wpvs_actor_slug_settings['slug'].'/'. $actor->slug;
                    $found_actors[] = array('actor_link' => $actor_link, 'actor_title' => $actor->name, 'actor_image' => $profile_image);
                    $include_actors[] = $actor->term_id;
                }
            }
        }

        if( ! empty($video_directors) ) {
            foreach($video_directors as $director) {
                if(stripos($director->name, $match_term) !== false) {
                    $profile_image = get_term_meta($director->term_id, 'wpvs_actor_profile', true);
                    if( empty($profile_image) ) {
                        $profile_image = $wpvs_profile_backup;
                    }
                    $director_link = $wpvs_home_url.'/'.$wpvs_director_slug_settings['slug'].'/'. $director->slug;
                    $found_directors[] = array('director_link' => $director_link, 'director_title' => $director->name, 'director_image' => $profile_image);
                    $include_directors[] = $director->term_id;
                }
            }
        }

        if( ! empty($video_tags) ) {
            foreach( $video_tags as $video_tag) {
                if(stripos($video_tag->name, $match_term) !== false) {
                    $tag_link = $wpvs_home_url.'/video-tag/'.$video_tag->slug;
                    $found_tags[] = array('tag_link' => $tag_link, 'tag_title' => $video_tag->name);
                    $include_tags[] = $video_tag->term_id;
                }
            }
        }
        $video_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => -1,
            'nopaging' => true,
            'fields' => 'ids',
            's' => $match_term
        );
        $wpvs_theme_video_manager->set_default_video_args($video_args);
        $video_list = $wpvs_theme_video_manager->get_videos();

        if( ! empty($video_list) ) {
            foreach($video_list as $video_id) {
                $video_title = get_the_title($video_id);
                $video_link = get_the_permalink($video_id);
                $video_link = wpvs_generate_thumbnail_link($video_link);
                $video_excerpt = get_the_excerpt($video_id);
                $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
                $video_thumbnail = wpvs_theme_get_video_thumbnail($video_id, null);
                $found_videos[] = array(
                    'video_id' => $video_id,
                    'video_link' => $video_link,
                    'video_title' => $video_title,
                    'video_excerpt' => $video_excerpt,
                    'video_thumbnail' => $video_thumbnail,
                    'type' => 'video',
                    'new_tab' => $open_in_new_tab
                );
                $excluded_found_videos[] = $video_id;
            }
        }

        if( ! empty($include_actors) || ! empty($include_directors) || ! empty($include_tags) ) {
            $term_video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1,
                'nopaging' => true,
                'fields' => 'ids',
                'post__not_in' => $excluded_found_videos
            );

            $term_video_args['tax_query'] = array( 'relation' => 'OR' );

            if( ! empty($include_actors) ) {
                $term_video_args['tax_query'][] = array(
                    'taxonomy' => 'rvs_actors',
                    'field'    => 'term_id',
                    'terms'    => $include_actors,
                );
            }
            if( ! empty($include_directors) ) {
                $term_video_args['tax_query'][] = array(
                    'taxonomy' => 'rvs_directors',
                    'field'    => 'term_id',
                    'terms'    =>$include_directors,
                );
            }
            if( ! empty($include_tags) ) {
                $term_video_args['tax_query'][] = array(
                    'taxonomy' => 'rvs_video_tags',
                    'field'    => 'term_id',
                    'terms'    => $include_tags,
                );
            }
            $wpvs_theme_video_manager->set_default_video_args($term_video_args);
            $term_video_list = $wpvs_theme_video_manager->get_videos();

            if(!empty($term_video_list)) {
                foreach($term_video_list as $video_id) {
                    $video_title = get_the_title($video_id);
                    $video_link = get_the_permalink($video_id);
                    $video_link = wpvs_generate_thumbnail_link($video_link);
                    $video_excerpt = get_the_excerpt($video_id);
                    $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
                    $video_thumbnail = wpvs_theme_get_video_thumbnail($video_id, null);
                    $found_videos[] = array(
                        'video_id' => $video_id,
                        'video_link' => $video_link,
                        'video_title' => $video_title,
                        'video_excerpt' => $video_excerpt,
                        'video_thumbnail' => $video_thumbnail,
                        'type' => 'video',
                        'new_tab' => $open_in_new_tab
                    );
                }
            }
        }

        $found_results = array('videos' => $found_videos, 'genres' => $found_genres, 'actors' => $found_actors, 'directors' => $found_directors, 'tags' => $found_tags);
        echo json_encode($found_results);

    } else {
        _e('Please enter a search term', 'wpvs-theme');
    }
    wp_die();
}

add_action( 'wp_ajax_wpvs_get_video_drop_down_details', 'wpvs_get_video_drop_down_details' );
add_action( 'wp_ajax_nopriv_wpvs_get_video_drop_down_details', 'wpvs_get_video_drop_down_details' );

function wpvs_get_video_drop_down_details() {
    if ( isset($_POST['videoid']) && !empty($_POST['videoid']) ) {
        $slide_type = "video";
        if ( isset($_POST['slide_type']) && ! empty($_POST['slide_type']) ) {
            $slide_type = $_POST['slide_type'];
        }
        global $wpvs_current_user;
        global $wpvs_my_list_enabled;
        $users_continue_watching_list = array();
        $percentage_complete = 0;
        $title_image = null;
        $video_trailer = array();
        $show_episodes = array();
        if( $wpvs_current_user ) {
            $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
            $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
        }
        if($wpvs_my_list_enabled) {
            $list_video_id = $_POST['videoid'];
            $list_slide_type = $slide_type;
            $this_video_categories = wp_get_post_terms($list_video_id, 'rvs_video_category', array( 'fields' => 'all'));
            if( ! empty($this_video_categories) ) {
                foreach($this_video_categories as $video_category) {
                    if($video_category->parent) {
                        $this_cat_has_seasons = get_term_meta($video_category->parent, 'cat_has_seasons', true);
                        if($this_cat_has_seasons) {
                            $list_video_id = $video_category->parent;
                            $list_slide_type = "show";
                        }

                    }
                }
            }

            $added_to_list_html = '<label class="button wpvs-add-to-list" data-videoid="'.$list_video_id.'" data-videotype="'.$list_slide_type.'"><span class="dashicons dashicons-plus"></span>'.__('My List', 'wpvs-theme').'</label>';
            if($wpvs_current_user && wpvs_added_to_user_list($list_video_id)) {
                $added_to_list_html = '<label class="button wpvs-add-to-list remove" data-videoid="'.$list_video_id.'" data-videotype="'.$list_slide_type.'"><span class="dashicons dashicons-yes"></span>'.__('My List', 'wpvs-theme').'</label>';
            }
        } else {
            $added_to_list_html = "";
        }

        if($slide_type == "video") {
            $video = get_post($_POST['videoid']);
            $wpvs_video_manager = new WPVS_Single_Video_Manager($video);
            $title = $video->post_title;
            $video_description = $video->post_excerpt;
            if(empty($video_description)) {
                $video_description = wp_strip_all_tags( $video->post_content, true );
            }
            $video_link = get_permalink($video->ID);
            $video_image = wpvs_theme_get_video_header_image($video->ID);
            $title_image = get_post_meta($video->ID, 'wpvs_title_image', true);
            $video_trailer = $wpvs_video_manager->get_background_trailer();
            $get_video = $video->ID;
            // CHECK CONINUE WATCHING LIST
            if( ! empty($users_continue_watching_list) ) {
                $percentage_complete = $wpvs_theme_user->get_video_percentage_complete($video->ID);
            }
        }

        if($slide_type == "show") {
            $series_id = $_POST['videoid'];
            $show = get_term($series_id, 'rvs_video_category');
            $title = $show->name;
            $video_description = $show->description;
            $video_cat_attachment_id = get_term_meta($show->term_id, 'wpvs_video_cat_attachment', true);
            $video_image = wp_get_attachment_url($video_cat_attachment_id);
            $title_image_id = get_term_meta($show->term_id, 'wpvs_term_title_image_id', true);
            if( ! empty($title_image_id) ) {
                $title_image = wp_get_attachment_url($title_image_id);
            }
            $wpvs_series_manager = new WPVS_TV_Series($show->term_id);
            $episodes = array();
            $episodes_filter = array();
            // GET SEAONS FOR THIS SERIES
            $series_seasons = $wpvs_series_manager->get_series_seasons();


            // GET VIDEOS IN ORDER FOR EACH SEASON
            if( ! empty($series_seasons) ) {
                if ( isset($_POST['episodes_filter']) && ! empty($_POST['episodes_filter']) ) {
                    $episodes_filter = $_POST['episodes_filter'];
                }
                foreach($series_seasons as $season) {
                    $more_episodes = $wpvs_series_manager->get_season_episode_ids($season->term_id, $episodes_filter);
                    if( ! empty($more_episodes) ) {
                        $episodes = array_merge($episodes, $more_episodes);
                    }
                }
            } else {
                $episodes = $wpvs_series_manager->get_season_episode_ids($series_id, $episodes_filter);
            }

            if( ! empty($episodes) ) {
                if( empty($get_video) ) {
                    $get_video = $episodes[0];
                    $video_link = get_permalink($get_video);
                    unset($episodes[0]);
                }
                foreach($episodes as $episode_id) {
                    $episode_info = array(
                        'episode_title' => get_the_title($episode_id),
                        'episode_link' => get_permalink($episode_id),
                        'episode_image' => wpvs_theme_get_video_thumbnail($episode_id, null),
                        'percent_complete' => 0
                    );
                    // CHECK CONINUE WATCHING LIST
                    if( ! empty($users_continue_watching_list) ) {
                        $percentage_complete = $wpvs_theme_user->get_video_percentage_complete($episode_id);
                        $episode_info['percent_complete'] = $percentage_complete;
                    }
                    $show_episodes[] = $episode_info;
                }
            }
            if( empty($video_link) ) {
                $video_link = get_term_link($show->term_id, 'rvs_video_category');
            }
        }

        if( empty($video_image) && ! empty($get_video) ) {
            $video_image = wpvs_theme_get_video_header_image($get_video);
        }

        if( empty($title_image) ) {
            $title_image = "";
        }

        if( empty($video_description) && ! empty($get_video) ) {
            $video = get_post($get_video);
            $video_description = $video->post_excerpt;
            if(empty($video_description)) {
                $video_description = wp_strip_all_tags( $video->post_content, true );
            }
        }

        $video_description = wp_trim_words($video_description, 50);
        $video_details = wpvs_theme_get_video_details($get_video, false);
        $video_information = wpvs_theme_get_video_information($get_video);

        $return_video = array(
            'video_title' => $title,
            'video_description' => $video_description,
            'video_details' => $video_details,
            'video_information' => $video_information,
            'video_link' => $video_link,
            'video_image' => $video_image,
            'video_title_image' => $title_image,
            'added_to_list' => $added_to_list_html,
            'episodes' => $show_episodes,
            'percent_complete' => $percentage_complete
        );
        if( ! empty($video_trailer) ) {
            $return_video['trailer'] = $video_trailer;
        }
        echo json_encode($return_video);

    } else {
        echo "Missing video id";
    }
    wp_die();
}

function wpvs_exit_ajax_request($request_message, $error_code) {
    if( empty($error_code) ) {
        $error_code = 400;
    }
    status_header($error_code);
    echo $request_message;
    exit;
}
