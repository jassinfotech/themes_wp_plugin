<?php

class WPVS_THEME_SHORTCODE_MANAGER {

    protected $grid_count_variables;
    protected $show_drop_down;
    protected $watch_now_text;
    protected $profile_image;
    public function __construct() {
        global $vs_dropdown_details;
        global $wpvs_watch_now_text;
        $this->profile_image = WPVS_THEME_BASE_URL .'/images/profile.png';
        add_shortcode('netflix-category', array($this, 'wpvs_theme_category_shortcode'));
        add_shortcode('netflix-categories', array($this, 'wpvs_theme_categories_shortcode'));
        add_shortcode('wpvs-theme-continue-watching', array($this, 'wpvs_theme_continue_watching_shortcode'));
        add_shortcode('wpvs-theme-my-list', array($this, 'wpvs_theme_my_list_shortcode'));
        add_shortcode('rvs_user_my_list', array($this, 'wpvs_users_saved_video_list'));
        add_shortcode('wpvs_display_actors', array($this, 'wpvs_theme_actors_shortcode'));
        add_shortcode('wpvs_display_directors', array($this, 'wpvs_theme_directors_shortcode'));
        if( get_option('wpvs_memberships_plugin_is_activated') ) {
            add_shortcode('rvs_user_rentals', array($this, 'wpvs_theme_user_rentals'));
            add_shortcode('rvs_user_purchases', array($this, 'wpvs_theme_user_purchases'));
        }
        add_shortcode('wpvs_display_recently_added', array($this, 'wpvs_recently_added_videos_shortcode'));
        add_shortcode('wpvs_single_video', array($this, 'wpvs_theme_single_video_shortcode'));
        // ADMIN COLUMNS
        add_filter('manage_edit-rvs_video_category_columns' , array($this, 'wpvs_theme_video_category_columns'));

        // SHARED VARIABLES
        $this->grid_count_variables = array(
            'large'   => get_theme_mod('wpvs_grid_count_large', 6),
            'desktop' => get_theme_mod('wpvs_grid_count_desktop', 5),
            'laptop'  => get_theme_mod('wpvs_grid_count_laptop', 4),
            'tablet'  => get_theme_mod('wpvs_grid_count_tablet', 3),
            'mobile'  => get_theme_mod('wpvs_grid_count_mobile', 2)
        );
        $this->show_drop_down = $vs_dropdown_details;
        $this->watch_now_text = $wpvs_watch_now_text;
    }

    public function wpvs_theme_category_shortcode( $atts ) {
        global $wpvs_genre_slug_settings;
        global $wpvs_theme_thumbnail_sizing;
        $wpvs_video_category_content = "";
        $get_video_category = shortcode_atts( array(
            'cat' => '0',
            'count' => 'all',
            'style' => null,
            'image_size' => $wpvs_theme_thumbnail_sizing->layout,
        ), $atts );

        $video_category = get_term($get_video_category['cat'], 'rvs_video_category');
        $videos_per_slide = $get_video_category['count'];
        if($videos_per_slide == "all") {
            $videos_per_slide = -1;
        }
        $video_list = wpvs_generate_term_slide_thumbnails($video_category);
        if( empty($video_list) ) {
          $video_args = array(
              'post_type' => 'rvs_video',
              'posts_per_page' => $videos_per_slide,
              'tax_query' => array(
                    array(
                       'taxonomy' => 'rvs_video_category',
                       'field' => 'term_id',
                       'terms' => $video_category->term_id
                  )
              )
          );
          $wpvs_theme_video_manager = new WPVS_Theme_Video_Manager();
          $wpvs_theme_video_manager->set_default_video_args($video_args);
          $wpvs_theme_video_manager->apply_video_ordering_filters();
          $video_list = $wpvs_theme_video_manager->get_videos();
        }
        if( ! empty($video_list) ) {
            $category_link = '/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug;
            $wpvs_video_category_content .= wpvs_theme_create_slider_from_videos($video_list, $video_category->name, $category_link, $get_video_category);
        }
        return $wpvs_video_category_content;
    }

    public function wpvs_theme_categories_shortcode( $atts ) {
        global $wpvs_genre_slug_settings;
        global  $wpvs_theme_thumbnail_sizing;
        if( is_user_logged_in() ) {
            global $wpvs_current_user;
            if( $wpvs_current_user ) {
                $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
                $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
            }
        }
        $wpvs_slider_style = array();
        $wpvs_video_categories_content = "";
        $theme_videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
        $get_per_slide = shortcode_atts( array(
            'perslide' => $theme_videos_per_slide,
            'style' => null,
            'image_size' => $wpvs_theme_thumbnail_sizing->layout,
        ), $atts );

        if( isset($get_per_slide['style']) && $get_per_slide['style'] == "clean" ) {
            $wpvs_slider_style['style'] = 'clean';
        }
        if( isset($get_per_slide['image_size']) && ! empty($get_per_slide['image_size']) ) {
            $wpvs_slider_style['image_size'] = sanitize_text_field($get_per_slide['image_size']);
        }

        if( isset($get_per_slide['perslide']) && ! empty($get_per_slide['perslide']) ) {
            $videos_per_slide = $get_per_slide['perslide'];
            if($videos_per_slide == "all") {
                $videos_per_slide = -1;
            }
        }

        $video_categories = get_terms(array(
            'taxonomy' => 'rvs_video_category',
            'parent' => 0,
            'hide_empty' => false,
            'meta_key' => 'video_cat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                'relation' => 'OR',
                 array(
                     'key' => 'video_cat_hide',
                     'value' => '0',
                     'compare' => '='

                 ),
                 array(
                     'key' => 'video_cat_hide',
                     'compare' => 'NOT EXISTS'
                 )
             )
        ));
        if( ! empty($video_categories) ) {
            foreach($video_categories as $video_category) {
                $video_list = array();
                $title_category_url = '/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug;
                $title_category_link = home_url($title_category_url);
                $contains_shows = get_term_meta($video_category->term_id, 'cat_contains_shows', true);
                if($contains_shows) {
                    $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($video_category->term_id);
                    $children_cats = get_terms($wpvs_taxonomy_settings);
                    if( ! empty($children_cats) ) {
                        foreach($children_cats as $child) {
                            $child_has_seasons = get_term_meta($child->term_id, 'cat_has_seasons', true);
                            if($child_has_seasons) {
                                $video_list[] = (object) array(
                                    'ID' => $child->term_id,
                                    'type' => 'show',
                                );
                            }
                        }
                    }
                } else {
                    $video_args = array(
                        'post_type' => 'rvs_video',
                        'posts_per_page' => $videos_per_slide,
                        'tax_query' => array(
                              array(
                                 'taxonomy' => 'rvs_video_category',
                                 'field' => 'term_id',
                                 'terms' => $video_category->term_id
                            )
                        ),
                        'meta_query' => array(
                            'relation' => 'OR',
                             array(
                                 'key' => 'rvs_hide_on_home',
                                 'value' => '0',
                                 'compare' => '='

                             ),
                             array(
                                 'key' => 'rvs_hide_on_home',
                                 'compare' => 'NOT EXISTS'
                             )
                         )
                    );
                    $wpvs_theme_video_manager = new WPVS_Theme_Video_Manager();
                    $wpvs_theme_video_manager->set_default_video_args($video_args);
                    $wpvs_theme_video_manager->apply_video_ordering_filters();
                    $video_list = $wpvs_theme_video_manager->get_videos();
                }
                if( ! empty($video_list) ) {
                    $wpvs_video_categories_content .= wpvs_theme_create_slider_from_videos($video_list, $video_category->name, $title_category_link, $wpvs_slider_style);
                }
            }
        }
        return $wpvs_video_categories_content;
    }

    // CONTINUE WATCHING SHORTCODE
    public function wpvs_theme_continue_watching_shortcode() {
        $wpvs_theme_shortcode_html = "";
        if( is_user_logged_in() ) {
            global $wpvs_current_user;
            if( $wpvs_current_user ) {
                $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
                $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
            }
            if( ! empty($users_continue_watching_list) ) {
                $continue_watching_videos = array();
                foreach($users_continue_watching_list as $continue_video) {
                    $video_id = $continue_video['id'];
                    $video_post = get_post($video_id);
                    if($video_post && $video_post->post_type == "rvs_video") {
                        $percent_complete = $continue_video['percent_complete'];
                        $continue_watching_videos[] = (object) array(
                            'ID' => $video_id,
                            'post_title' => $video_post->post_title,
                            'post_excerpt' => $video_post->post_excerpt,
                            'type' => 'video',
                            'percent_complete' => $percent_complete
                        );
                    }
                }
                if( ! empty($continue_watching_videos) ) {
                    $wpvs_theme_shortcode_html = wpvs_theme_create_slider_from_videos($continue_watching_videos, __('Continue Watching', 'wpvs-theme'), null, array());
                }
            }
        } else {
            $wpvs_theme_shortcode_html = __('You must be logged in to view this content', 'wpvs-theme');
        }
        return $wpvs_theme_shortcode_html;
    }

    // MY LIST SHORTCODE
    public function wpvs_theme_my_list_shortcode() {
        $wpvs_theme_shortcode_html = "";
        if( is_user_logged_in() ) {
            global $wpvs_current_user;
            global $wpvs_my_list_enabled;
            if( $wpvs_my_list_enabled ) {
                $my_list_home_title = get_theme_mod('wpvs_my_list_home_title', __('My List', 'wpvs-theme'));
                $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
                $my_list_videos = array();
                if( ! empty($users_video_list) ) {
                    foreach($users_video_list as $saved_video) {
                        if($saved_video['type'] == 'video') {
                            $video_id = $saved_video['id'];
                            $video_post = get_post($video_id);
                            if($video_post && $video_post->post_type == "rvs_video") {
                                $my_list_videos[] = (object) array(
                                    'ID' => $video_id,
                                    'post_title' => $video_post->post_title,
                                    'post_excerpt' => $video_post->post_excerpt,
                                    'type' => 'video',
                                );
                            }
                        } else {
                            $my_list_videos[] = (object) array(
                                'ID' => $saved_video['id'],
                                'type' => 'show'
                            );
                        }
                    }
                }

                if( ! empty($my_list_videos) ) {
                    $wpvs_theme_shortcode_html = wpvs_theme_create_slider_from_videos($my_list_videos, $my_list_home_title, null, array());
                }
            }
        } else {
            $wpvs_theme_shortcode_html = __('You must be logged in to view this content', 'wpvs-theme');
        }
        return $wpvs_theme_shortcode_html;
    }

    public function wpvs_theme_actors_shortcode( $atts ) {
        $wpvs_actors_content = '<div class="wpvs-profile-list">';

        $wpvs_shortcode_atts = shortcode_atts( array(
            'orderby' => '',
            'term_ids'  => '',
        ), $atts );

        $wpvs_actor_args = array(
            'taxonomy' => 'rvs_actors',
            'hide_empty' => false,
            'order' => 'ASC',
            'fields' => 'id=>name'
        );

        if( isset($wpvs_shortcode_atts['orderby']) && ! empty($wpvs_shortcode_atts['orderby']) ) {
            $wpvs_actor_args['orderby'] = $wpvs_shortcode_atts['orderby'];
        } else {
            $wpvs_actor_args['meta_key'] = 'wpvs_display_order';
            $wpvs_actor_args['orderby'] = 'meta_value_num';
        }

        if( isset($wpvs_shortcode_atts['term_ids']) && ! empty($wpvs_shortcode_atts['term_ids']) ) {
            $term_ids = explode(',', $wpvs_shortcode_atts['term_ids']);
            $wpvs_actor_args['term_taxonomy_id'] = $term_ids;
        }
        $wpvs_actors = get_terms($wpvs_actor_args);
        if( ! empty($wpvs_actors) ) {
            foreach($wpvs_actors as $term_id => $term_name) {
                $term_link = get_term_link($term_id, 'rvs_actors');
                $profile_image = get_term_meta($term_id, 'wpvs_actor_profile', true);
                if( empty($profile_image) ) {
                    $profile_image = $this->profile_image;
                }
                $wpvs_actors_content .= '<div class="wpvs-profile-item"><a href="'.$term_link.'"><img src="'.$profile_image.'" alt="'.$term_name.'" /></a>';
                $wpvs_actors_content .= '<a class="wpvs-term-name" href="'.$term_link.'">'.$term_name.'</a>';
                $wpvs_actors_content .= '</div>';
            }
        }
        $wpvs_actors_content .= '</div>';
        return $wpvs_actors_content;
    }

    public function wpvs_theme_directors_shortcode( $atts ) {
        $wpvs_directors_content = '<div class="wpvs-profile-list">';

        $wpvs_shortcode_atts = shortcode_atts( array(
            'orderby' => '',
            'term_ids'  => '',
        ), $atts );

        $wpvs_director_args = array(
            'taxonomy' => 'rvs_directors',
            'hide_empty' => false,
            'order' => 'ASC',
            'fields' => 'id=>name'
        );

        if( isset($wpvs_shortcode_atts['orderby']) && ! empty($wpvs_shortcode_atts['orderby']) ) {
            $wpvs_director_args['orderby'] = $wpvs_shortcode_atts['orderby'];
        } else {
            $wpvs_director_args['meta_key'] = 'wpvs_display_order';
            $wpvs_director_args['orderby'] = 'meta_value_num';
        }

        if( isset($wpvs_shortcode_atts['term_ids']) && ! empty($wpvs_shortcode_atts['term_ids']) ) {
            $term_ids = explode(',', $wpvs_shortcode_atts['term_ids']);
            $wpvs_director_args['term_taxonomy_id'] = $term_ids;
        }
        $wpvs_directors = get_terms($wpvs_director_args);
        if( ! empty($wpvs_directors) ) {
            foreach($wpvs_directors as $term_id => $term_name) {
                $term_link = get_term_link($term_id, 'rvs_directors');
                $profile_image = get_term_meta($term_id, 'wpvs_actor_profile', true);
                if( empty($profile_image) ) {
                    $profile_image = $this->profile_image;
                }
                $wpvs_directors_content .= '<div class="wpvs-profile-item"><a href="'.$term_link.'"><img src="'.$profile_image.'" alt="'.$term_name.'" /></a>';
                $wpvs_directors_content .= '<a class="wpvs-term-name" href="'.$term_link.'">'.$term_name.'</a>';
                $wpvs_directors_content .= '</div>';
            }
        }
        $wpvs_directors_content .= '</div>';
        return $wpvs_directors_content;
    }

    // USER SAVED VIDEOS ACCOUNT PAGE
    public function wpvs_users_saved_video_list( $atts ) {
        $wpvs_user_my_list_content = "";
        if(is_user_logged_in()) {
            $wpvs_atts = shortcode_atts( array(
                'show_customer_menu' => '0'
            ), $atts );
            global $wpvs_my_list_enabled;
            global $wpvs_current_user;
            $remove_video_list_padding = false;

            if( ! wp_script_is( 'user-videos-ajax-js', 'enqueued' ) ) {
                wp_enqueue_script( 'user-videos-ajax-js');
            }
            if( ! wp_script_is( 'video-ajax-js', 'enqueued' ) ) {
                wp_enqueue_script( 'video-ajax-js');
            }
            wp_localize_script( 'video-ajax-js', 'wpvsapimanager', array(
                'userid' =>$wpvs_current_user->ID,
                'url'   => rest_url('/wpvsuser/v1/videos?type=mylist'),
                'watchtext' =>  $this->watch_now_text,
                'dropdown' => $this->show_drop_down,
                'count' => $this->grid_count_variables,
                'hourstext' =>  __('hours left', 'wpvs-theme'),
            ));

            $rvs_account_sub_menu = get_option('rvs_account_sub_menu', 1);
            if( $rvs_account_sub_menu && function_exists('wpvs_generate_customer_menu') && $wpvs_atts['show_customer_menu'] ) {
                $wpvs_user_my_list_content .= wpvs_generate_customer_menu("mylist");
                $remove_video_list_padding = true;
            }
            if($wpvs_my_list_enabled) {
                $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
                if( ! empty($users_video_list) ) {
                    $wpvs_user_my_list_content .= '<div class="video-list';
                    if( $remove_video_list_padding ) {
                        $wpvs_user_my_list_content .= ' account-video-list';
                    }
                    $wpvs_user_my_list_content .= '"><div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div><div id="video-list-loaded" data-type="mylist"><div id="video-list"></div></div></div>';
                } else {
                    global $wpvs_video_slug_settings;
                    $videos_link = home_url('/'.$wpvs_video_slug_settings['slug']);
                    $wpvs_user_my_list_content .= '<h4>'.__('You have not added any videos to your list.', 'wpvs-theme').'</h4>';
                    $wpvs_user_my_list_content .= '<a class="rvs-button rvs-primary-button" href="'.$videos_link.'">'.__('Browse videos', 'wpvs-theme').'</a>';
                }
            } else {
                $wpvs_user_my_list_content .= '<p>'.__('The site administrator has disabled the My List feature.', 'wpvs-theme').'</p>';
            }
        }
        return $wpvs_user_my_list_content;
    }

    // USER RENTALS
    public function wpvs_theme_user_rentals( $atts ) {
        $wpvs_user_rentals_content = "";
        if(is_user_logged_in()) {
            $wpvs_atts = shortcode_atts( array(
                'show_customer_menu' => '0'
            ), $atts );
            global $wpvs_current_user;
            $remove_video_list_padding = false;
            if( ! wp_script_is( 'user-videos-ajax-js', 'enqueued' ) ) {
                wp_enqueue_script( 'user-videos-ajax-js');
            }

            if( ! wp_script_is( 'video-ajax-js', 'enqueued' ) ) {
                wp_enqueue_script( 'video-ajax-js');
            }
            wp_localize_script( 'video-ajax-js', 'wpvsapimanager', array(
                'userid' =>$wpvs_current_user->ID,
                'url'   => rest_url('/wpvsuser/v1/videos?type=rentals'),
                'watchtext' =>  $this->watch_now_text,
                'dropdown' => $this->show_drop_down,
                'count' => $this->grid_count_variables,
                'hourstext' =>  __('hours left', 'wpvs-theme'),
            ));
            $rvs_account_sub_menu = get_option('rvs_account_sub_menu', 1);
            if( $rvs_account_sub_menu && function_exists('wpvs_generate_customer_menu') && $wpvs_atts['show_customer_menu'] ) {
                $wpvs_user_rentals_content .= wpvs_generate_customer_menu("rentals");
                $remove_video_list_padding = true;
            }
            rvs_check_rentals_purchases($wpvs_current_user->ID);
            $user_rentals = rvs_get_user_rentals($wpvs_current_user->ID);
            if( empty($user_rentals) ) {
                global $wpvs_video_slug_settings;
                $videos_link = home_url('/'.$wpvs_video_slug_settings['slug']);
                $wpvs_user_rentals_content .= '<h4>'.__('You have not rented any videos', 'wpvs-theme').'</h4>';
                $wpvs_user_rentals_content .= '<a class="rvs-button rvs-primary-button" href="'.$videos_link.'">'.__('Browse videos', 'wpvs-theme').'</a>';
            } else {
                $wpvs_user_rentals_content .= '<div class="video-list';
                if( $remove_video_list_padding ) {
                    $wpvs_user_rentals_content .= ' account-video-list';
                }
                $wpvs_user_rentals_content .= '"><div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div><div id="video-list-loaded" data-type="rentals"><div id="video-list"></div></div></div>';
            }
        }
        return $wpvs_user_rentals_content;
    }

    // USER PURCHASES
    public function wpvs_theme_user_purchases( $atts ) {
        $wpvs_user_purchases_content = "";
        if(is_user_logged_in()) {
            $wpvs_atts = shortcode_atts( array(
                'show_customer_menu' => '0'
            ), $atts );
            global $wpvs_current_user;
            $remove_video_list_padding = false;
            if( ! wp_script_is( 'user-videos-ajax-js', 'enqueued' ) ) {
                wp_enqueue_script( 'user-videos-ajax-js');
            }

            if( ! wp_script_is( 'video-ajax-js', 'enqueued' ) ) {
                wp_enqueue_script( 'video-ajax-js');
            }

            wp_localize_script( 'video-ajax-js', 'wpvsapimanager', array(
                'userid' =>$wpvs_current_user->ID,
                'url'   => rest_url('/wpvsuser/v1/videos?type=purchases'),
                'watchtext' =>  $this->watch_now_text,
                'dropdown' => $this->show_drop_down,
                'count' => $this->grid_count_variables,
                'hourstext' =>  __('hours left', 'wpvs-theme'),
            ));

            $rvs_account_sub_menu = get_option('rvs_account_sub_menu', 1);
            if( $rvs_account_sub_menu && function_exists('wpvs_generate_customer_menu') && $wpvs_atts['show_customer_menu'] ) {
                $wpvs_user_purchases_content .= wpvs_generate_customer_menu("purchases");
                $remove_video_list_padding = true;
            }
            rvs_check_rentals_purchases($wpvs_current_user->ID);
            $user_purchases = rvs_get_user_purchases($wpvs_current_user->ID);
            $user_term_purchases = wpvs_get_user_term_purchases($wpvs_current_user->ID);
            if( empty($user_purchases) && empty($user_term_purchases) ) {
                global $wpvs_video_slug_settings;
                $videos_link = home_url('/'.$wpvs_video_slug_settings['slug']);
                $wpvs_user_purchases_content .= '<h4>'.__('You have not purchased any videos', 'wpvs-theme').'</h4>';
                $wpvs_user_purchases_content .= '<a class="rvs-button rvs-primary-button" href="'.$videos_link.'">'.__('Browse videos', 'wpvs-theme').'</a>';
            } else {
                $wpvs_user_purchases_content .= '<div class="video-list';
                if( $remove_video_list_padding ) {
                    $wpvs_user_purchases_content .= ' account-video-list';
                }
                $wpvs_user_purchases_content .= '"><div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div><div id="video-list-loaded" data-type="purchases"><div id="video-list"></div></div></div>';
            }
        }
        return $wpvs_user_purchases_content;
    }

    public function wpvs_recently_added_videos_shortcode( $atts ) {
        $videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
        $wpvs_parameters = shortcode_atts( array(
            'perslide' => $videos_per_slide,
            'style' => null
        ), $atts );

        if( isset($wpvs_parameters['perslide']) && ! empty($wpvs_parameters['perslide']) ) {
            $videos_per_slide = $wpvs_parameters['perslide'];
            if($videos_per_slide == "all") {
                $videos_per_slide = -1;
            }
        }

        $wpvs_recently_added_content = "";
        $recent_video_slides = array();
        $recently_added_video_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => $videos_per_slide,
            'meta_query' => array(
                'relation' => 'OR',
                 array(
                     'key' => 'wpvs_hide_from_recently_added',
                     'value' => '0',
                     'compare' => '='

                 ),
                 array(
                     'key' => 'wpvs_hide_from_recently_added',
                     'compare' => 'NOT EXISTS'
                 )
             )
        );
        $recently_added_video_list = get_posts($recently_added_video_args);
        if( ! empty($recently_added_video_list) ) {
            $wpvs_recently_added_content .= wpvs_theme_create_slider_from_videos($recently_added_video_list, __('Recently Added', 'wpvs-theme'), null, $wpvs_parameters);
        }
        return $wpvs_recently_added_content;
    }

    // ADD SHORTCODES TO COLUMNS
    public function wpvs_theme_video_category_columns( $columns ) {
    	$columns['video_shortcode'] = __('Shortcode', 'wpvs-theme');
    	return $columns;
    }


    public function wpvs_theme_video_category_columns_content( $content, $column_name, $term_id ) {
        if ( 'video_shortcode' == $column_name ) {
            $content = '[netflix-category cat="'.$term_id.'" count="6"]';
        }
    	return $content;
    }

    public function wpvs_theme_single_video_shortcode( $atts ) {
        global $wpvs_plugin_text_domain;
        $attributes = shortcode_atts( array(
            'video_id' => null,
        ), $atts );
	    if( isset($attributes['video_id']) && ! empty($attributes['video_id'])) {
			$wpvs_single_video = new WPVS_SINGLE_VIDEO(intval($attributes['video_id']));
			return $wpvs_single_video->get_video_player();
	    } else {
	        return '<div class="wpvs-single-video-error">'.__('Please provide a Video ID.', $wpvs_plugin_text_domain).'</div>';
	    }
	}

}

$wpvs_theme_shortcodes_manager = new WPVS_THEME_SHORTCODE_MANAGER();
add_filter('manage_rvs_video_category_custom_column', [$wpvs_theme_shortcodes_manager, 'wpvs_theme_video_category_columns_content'], 10, 3 );
