<?php

class WPVS_THEME_REST_API_MODIFIER {

    public $added_term_ids;

    public function __construct() {
        add_action( 'rest_api_init', array($this, 'wpvs_rest_api_video_meta_fields') );
        add_action( 'rest_api_init', array($this, 'wpvs_rest_api_taxonomy_filters') );
        add_action( 'rest_api_init', array($this, 'wpvs_rest_api_register_theme_endpoint_routes') );
        $this->added_term_ids = array();
    }

    public function wpvs_rest_api_register_theme_endpoint_routes() {
        if( is_user_logged_in() ) {
            register_rest_route( 'wpvsuser/v1', '/videos/', array(
                    'methods'  => 'GET',
                    'callback' => array($this, 'wpvs_list_user_videos'),
                    'args' => array(
                        'type' => array(
                            'validate_callback' => function($param, $request, $key) {
                                return ! empty( $param );
                            }
                        ),
                    ),
                    'permission_callback' => '__return_true'
                )
            );
        }

        register_rest_route( 'wpvsuser/v1', 'mylist', array(
                'methods'  => 'POST',
                'callback' => array($this, 'wpvs_update_user_my_list'),
                'args' => array(),
                'permission_callback' => array($this, 'verify_user_api_access_token')
            )
        );
    }

    public function verify_user_api_access_token($request) {
        $is_valid_token = false;
        $access_token = $request->get_param('wpvstoken');
        if( ! empty($access_token) ) {
            $wpvs_rest_controller = new WPVS_REST_Theme_Controller();
            $is_valid_token = $wpvs_rest_controller->wpvs_validate_rest_api_user_access_token($access_token);
        }
        return $is_valid_token;
    }

    public function wpvs_list_user_videos($request) {
        global $wpvs_current_user;
        $list_user_videos = array();
        $purchase_type = $request->get_param('type');
        $check_user_id = $request->get_param('userid');
        if( ! empty($wpvs_current_user) && ! empty($purchase_type) && ($check_user_id == $wpvs_current_user->ID) ) {
            if($purchase_type == 'purchases') {
                if( class_exists('WPVS_Customer') ) {
                    $wpvs_customer = new WPVS_Customer($wpvs_current_user);
                    $user_purchases = $wpvs_customer->get_user_purchases();
                    foreach($user_purchases as $purchase) {
                        $add_video_details = $this->create_json_data($purchase['id'], 'video', null);
                        if( isset($add_video_details->title->rendered) ) {
                            $video_download_link = get_post_meta($purchase['id'], 'rvs_video_download_link', true );
                            if( ! empty($video_download_link) ) {
                                $add_video_details->user_data->download_link = $video_download_link;
                            }
                            $list_user_videos[] = $add_video_details;
                        }
                    }

                    $user_term_purchases = $wpvs_customer->get_user_term_purchases();
                    if( ! empty($user_term_purchases) ) {
                        foreach($user_term_purchases as $purchase) {
                            $add_show_details = $this->create_json_data($purchase['id'], 'show', $purchase['term']);
                            if( isset($add_show_details->name) ) {
                                $list_user_videos[] = $add_show_details;
                            }
                        }
                    }
                }
            }

            if($purchase_type == 'rentals') {
                if( class_exists('WPVS_Customer') ) {
                    $wpvs_customer = new WPVS_Customer($wpvs_current_user);
                    $user_rentals = $wpvs_customer->get_user_rentals();
                    if(!empty($user_rentals)) {
                        foreach($user_rentals as $rental) {
                            $add_video_details = $this->create_json_data($rental['id'], 'video', null);
                            if( isset($add_video_details->title->rendered) ) {
                                $hour_diff = "";
                                $rental_expires = $rental['expires'];
                                if($rental_expires > time()) {
                                    $hour_diff = round(($rental_expires - time())/3600, 0);
                                }
                                $add_video_details->user_data->rental_time_left = $hour_diff;
                                $list_user_videos[] = $add_video_details;
                            }
                        }
                    }
                }
            }

            if($purchase_type == 'mylist') {
                $users_video_list = get_user_meta($wpvs_current_user->ID, 'wpvs-user-video-list', true);
                if(!empty($users_video_list)) {
                    foreach($users_video_list as $saved_video) {
                        if($saved_video['type'] == 'video') {
                            $video_id = $saved_video['id'];
                            $add_video_details = $this->create_json_data($video_id, 'video', null);
                            if( isset($add_video_details->title->rendered) ) {
                                $list_user_videos[] = $add_video_details;
                            }
                        } else {
                            $term_id = intval($saved_video['id']);
                            $wpvs_term = get_term($term_id, 'rvs_video_category');
                            $add_show_details = $this->create_json_data($term_id, 'show', $wpvs_term);
                            if( isset($add_show_details->name) ) {
                                $list_user_videos[] = $add_show_details;
                            }
                        }
                    }
                }
            }
            $request_params = $request->get_params();
            $request_offset = 0;
            $request_per_page = 100;
            if( isset($request_params['offset']) && ! empty($request_params['offset']) ) {
                $request_offset = $request_params['offset'];
            }
            if( isset($request_params['per_page']) && ! empty($request_params['per_page']) ) {
                $request_per_page = $request_params['per_page'];
            }
            $list_user_videos = array_slice($list_user_videos, $request_offset, $request_per_page);
        }
        return new WP_REST_Response( $list_user_videos, 200 );
    }

    public function wpvs_update_user_my_list($request) {

        $my_list_updated = false;
        if( function_exists('wpvs_rest_api_get_access_token_user_id') ) {
            $access_token = $request->get_param('wpvstoken');
            $user_id = wpvs_rest_api_get_access_token_user_id($access_token);
            if( ! empty($user_id) ) {
                $video_exists = false;
                $users_video_list = get_user_meta($user_id, 'wpvs-user-video-list', true);
                $video_id = $request->get_param('videoid');
                $video_type = $request->get_param('videotype'); // show or video
                $mylist_action = $request->get_param('wpvsaction');

                if( empty($users_video_list) ) {
                    $users_video_list = array();
                } else {
                    foreach($users_video_list as $video_list_item) {
                        if($video_list_item['id'] == $video_id) {
                            $video_exists = true;
                            break;
                        }
                    }
                }
                if( $mylist_action == 'add' ) {
                    if( ! $video_exists ) {
                        $new_video_item = array('id' => $video_id, 'type' => $video_type);
                        $users_video_list[] = $new_video_item;
                        $my_list_updated = update_user_meta($user_id, 'wpvs-user-video-list', $users_video_list);
                    }
                }

                if( $mylist_action == 'remove' ) {
                    if( ! empty($users_video_list) ) {
                        foreach($users_video_list as $key => $video_list_item) {
                            if($video_list_item['id'] == $video_id && $video_list_item['type'] == $video_type) {
                                unset($users_video_list[$key]);
                                break;
                            }
                        }
                    }
                    $my_list_updated = update_user_meta($user_id, 'wpvs-user-video-list', $users_video_list);
                }
            }
        }
        return new WP_REST_Response( array('updated' => $my_list_updated), 200);
    }

    public function create_json_data($video_id, $video_type, $wpvs_term) {
        global $wpvs_current_user;
        $users_continue_watching_list = array();
        if( ! empty($wpvs_current_user) ) {
            $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
            $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
        }
        $video_json_data = array(
            'id' => $video_id,
            'wpvs_type' => $video_type,
            'user_data' => array(
                'download_link' => "",
                'rental_time_left' => "",
                'percentage_complete' => 0
            ));

        if( $video_type == 'video' && ! empty( get_post($video_id) ) ) {
            $video_title = get_the_title($video_id);
            $video_link = get_the_permalink($video_id);
            $video_link = wpvs_generate_thumbnail_link($video_link);
            $wpvs_thumbnail_image = wpvs_theme_get_video_thumbnail($video_id, null);
            $video_excerpt = get_the_excerpt($video_id);
            $open_in_new_tab = get_post_meta($video_id, 'wpvs_open_video_in_new_tab', true);
            $video_json_data['title']['rendered'] = $video_title;
            $video_json_data['excerpt']['rendered'] = '<p>'.$video_excerpt.'</p>';
            $video_json_data['link'] = $video_link;
            $video_json_data['new_tab'] = $open_in_new_tab;

            if( ! empty($wpvs_thumbnail_image->src) ) {
                $video_json_data['images']['thumbnail'] = $wpvs_thumbnail_image->src;
            }
            if( ! empty($wpvs_thumbnail_image->srcset) ) {
                $video_json_data['images']['srcset'] = $wpvs_thumbnail_image->srcset;
            }

            // CHECK CONINUE WATCHING LIST
            if( ! empty($users_continue_watching_list) ) {
                $percentage_complete = $wpvs_theme_user->get_video_percentage_complete($video_id);
                $video_json_data['user_data']['percentage_complete'] = $percentage_complete;
            }
        }

        if( $video_type == 'show' ) {
            $term_id = intval($video_id);
            $wpvs_term_link = get_term_link($term_id, 'rvs_video_category');
            $wpvs_term_title = $wpvs_term->name;
            $wpvs_thumbnail_image = wpvs_theme_get_show_thumbnail($term_id, null);
            if( ! empty($wpvs_term->parent) ) {
                $wpvs_parent_term = get_term(intval($wpvs_term->parent), 'rvs_video_category' );
                if( ! empty($wpvs_parent_term) && ! is_wp_error($wpvs_parent_term) ) {
                    $wpvs_term_title .= ' ('.$wpvs_parent_term->name.')';
                }
            }
            $video_json_data['name'] = $wpvs_term_title;
            $video_json_data['description'] = wp_strip_all_tags($wpvs_term->description);
            $video_json_data['link'] = $wpvs_term_link;

            if( ! empty($wpvs_thumbnail_image->src) ) {
                $video_json_data['images']['thumbnail'] = $wpvs_thumbnail_image->src;
            }
            if( ! empty($wpvs_thumbnail_image->srcset) ) {
                $video_json_data['images']['srcset'] = $wpvs_thumbnail_image->srcset;
            }
        }

        $video_json_data = json_encode($video_json_data);
        $video_json_data = json_decode($video_json_data);

        return (object) $video_json_data;
    }

    public function wpvs_rest_api_video_meta_fields() {

        // Set video player type
        register_rest_field( 'rvs_video', 'video_type', array(
            'get_callback' => function( $video_object ) {
                $video_type = get_post_meta($video_object['id'], '_rvs_video_type', true);
                if( empty($video_type)) {
                    $video_type = "";
                }
                return (string) $video_type;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Video type.' ),
                'type'        => 'string'
            ),
        ) );

        // Set video or show
        register_rest_field( 'rvs_video', 'wpvs_type', array(
            'get_callback' => function( $video_object ) {
                $wpvs_type = 'video';
                return (string) $wpvs_type;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'WPVS Video type. (Show or Video)' ),
                'type'        => 'string'
            ),
        ) );

        // Set thumbnail and featured images
        register_rest_field( 'rvs_video', 'images', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $wpvs_thumbnail_image = wpvs_theme_get_video_thumbnail($video_id, null);
                if(has_post_thumbnail($video_id)) {
                    $featured_id = get_post_thumbnail_id($video_id);
                    $featured_image = wp_get_attachment_image_src($featured_id, 'vs-netflix-header', true)[0];
                    if(empty($featured_image)) {
                        $featured_image = wp_get_attachment_image_src($featured_id, 'full', true)[0];
                    }
                }
                if( empty($featured_image) ) {
                    $featured_image = get_post_meta($video_id, 'wpvs_featured_image', true);
                }

                $wpvs_thumbnail_label = get_post_meta($video_id, 'wpvs_thumbnail_label', true);

                $wpvs_video_thumbnails = array();
                if( ! empty($wpvs_thumbnail_image->src) ) {
                    $wpvs_video_thumbnails['thumbnail'] = $wpvs_thumbnail_image->src;
                }
                if( ! empty($wpvs_thumbnail_image->srcset) ) {
                    $wpvs_video_thumbnails['srcset'] = $wpvs_thumbnail_image->srcset;
                }
                if( ! empty($featured_image) ) {
                    $wpvs_video_thumbnails['featured'] = $featured_image;
                }
                if( ! empty($wpvs_thumbnail_label) ) {
                    $wpvs_video_thumbnails['thumbnail_label'] = $wpvs_thumbnail_label;
                }
                return (array) $wpvs_video_thumbnails;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Video Images.' ),
                'type'        => 'array'
            ),
        ) );

        // Set Vimeo information
        register_rest_field( 'rvs_video', 'vimeo', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $vimeo_id = get_post_meta($video_id, 'rvs_video_post_vimeo_id', true);
                if( empty($vimeo_id)) {
                    $vimeo_id = "";
                    $vimeo_video_url = "";
                } else {
                    $vimeo_video_url = 'https://vimeo.com/'.$vimeo_id;
                }
                return (array) array('id' => $vimeo_id, 'url' => $vimeo_video_url);
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Vimeo details.' ),
                'type'        => 'array'
            ),
        ) );

        // Set YouTube information
        register_rest_field( 'rvs_video', 'youtube', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $youtube_url = get_post_meta($video_id, 'rvs_youtube_url', true);
                if( empty($youtube_url)) {
                    $youtube_url = "";
                }
                return (array) array('url' => $youtube_url);
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'YouTube details.' ),
                'type'        => 'array'
            ),
        ) );

        // Set video details
        register_rest_field( 'rvs_video', 'video_details', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $wpvs_video_information = get_post_meta($video_id, 'wpvs_video_information', true);
                $wpvs_video_length = get_post_meta($video_id, 'wpvs_video_length', true);

                if( empty($wpvs_video_length) ) {
                    $wpvs_video_length = 0;
                }

                $wpvs_video_hours = intval(gmdate("H", $wpvs_video_length));
                $wpvs_video_minutes = intval(gmdate("i", $wpvs_video_length));

                if( empty($wpvs_video_information) ) {
                    $wpvs_video_information = array(
                        'length' => $wpvs_video_length,
                        'hours' => $wpvs_video_hours,
                        'minutes' => $wpvs_video_minutes,
                        'date_released' => ""
                    );
                } else {
                    if( ! isset($wpvs_video_information['length']) ) {
                        $wpvs_video_information['length'] = $wpvs_video_length;
                    }
                    if( ! isset($wpvs_video_information['hours']) ) {
                        $wpvs_video_information['hours'] = $wpvs_video_hours;
                    }
                    if( ! isset($wpvs_video_information['minutes']) ) {
                        $wpvs_video_information['minutes'] = $wpvs_video_minutes;
                    }
                    if( ! isset($wpvs_video_information['date_released']) ) {
                        $wpvs_video_information['date_released'] = "";
                    }
                }
                return (array) array($wpvs_video_information);
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Video Details' ),
                'type'        => 'array'
            )
        ) );

        register_rest_field( 'rvs_video', 'actors', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $wpvs_video_actor_ids = wp_get_post_terms($video_id, 'rvs_actors', true);
                $wpvs_video_actors = array();
                if( ! empty($wpvs_video_actor_ids) ) {
                    foreach($wpvs_video_actor_ids as $actor) {
                        $wpvs_video_actors[] = array(
                            'name' => $actor->name,
                            'slug' => $actor->slug
                        );
                    }
                }
                return (array) array($wpvs_video_actors);
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Video Actor Names' ),
                'type'        => 'array'
            )
        ) );

        register_rest_field( 'rvs_video', 'directors', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $wpvs_video_director_ids = wp_get_post_terms($video_id, 'rvs_directors', true);
                $wpvs_video_directors = array();
                if( ! empty($wpvs_video_director_ids) ) {
                    foreach($wpvs_video_director_ids as $director) {
                        $wpvs_video_directors[] = array(
                            'name' => $director->name,
                            'slug' => $director->slug
                        );
                    }
                }
                return (array) array($wpvs_video_directors);
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Video Director Names' ),
                'type'        => 'array'
            )
        ) );

        // CHECK IF VIDEO IS EPISODE
        register_rest_field( 'rvs_video', 'series', array(
            'get_callback' => function( $video_object ) {
                $video_id = $video_object['id'];
                $series_data = array(
                    'is_episode' => false,
                );
                $wpvs_video_season_terms = wp_get_post_terms( $video_id, 'rvs_video_category', array(
                    'meta_key' => 'wpvs_is_season',
                    'meta_value' => 1,
                    'number' => 1
                ));
                if( ! empty($wpvs_video_season_terms) ) {
                    $wpvs_season = $wpvs_video_season_terms[0];
                    if( ! empty($wpvs_season->parent) ) {
                        $series_id = $wpvs_season->parent;
                        $series_term = get_term($series_id, 'rvs_video_category');
                        $series_data['name'] = $series_term->name;
                        $series_data['description'] = wp_strip_all_tags($series_term->description);
                        $series_data['link'] = get_term_link($series_id, 'rvs_video_category');
                        $series_data['id'] = $series_id;
                        $series_data['is_episode'] = true;
                        $wpvs_series_images = wpvs_theme_get_show_thumbnail($series_id, null);
                        $wpvs_series_title_image = get_term_meta($series_id, 'wpvs_term_title_image', true);
                        if( ! empty($wpvs_series_images->src) ) {
                            $series_data['images']['thumbnail'] = $wpvs_series_images->src;
                        }
                        if( ! empty($wpvs_series_images->srcset) ) {
                            $series_data['images']['srcset'] = $wpvs_series_images->srcset;
                        }
                        if( ! empty($wpvs_series_title_image) ) {
                            $series_data['images']['title_image'] = $wpvs_series_title_image;
                        }
                        $this->added_term_ids[] = $series_id;
                    }
                }

                // Checks for no season series
                if( ! $series_data['is_episode'] ) {
                    $wpvs_compact_to_series = false;
                    $term_id = null;
                    // ACTOR ARCHIVE PAGE
                    if( ! empty($_GET['wpvsactors']) ) {
                        $term_id = intval($_GET['wpvsactors']);
                    }
                    // DIRECTOR ARCHIVE PAGE
                    if( ! empty($_GET['wpvsdirectors']) ) {
                        $term_id = intval($_GET['wpvsdirectors']);
                    }
                    if( ! empty($term_id) ) {
                        $wpvs_show_all_episodes = get_term_meta($term_id, 'wpvs_term_show_all_episodes', true);
                        if( ! $wpvs_show_all_episodes ) {
                            $wpvs_compact_to_series = true;
                        }
                    } else {
                        if( empty($_GET['wpvsgenres']) && empty($_GET['wpvsvideotags']) ) {
                            $wpvs_compact_to_series = true;
                        }
                    }

                    if( $wpvs_compact_to_series ) {
                        $wpvs_video_series_terms = wp_get_post_terms( $video_id, 'rvs_video_category', array(
                            'meta_key' => 'cat_has_seasons',
                            'meta_value' => 1,
                            'number' => 1
                        ));
                        if( ! empty($wpvs_video_series_terms) ) {
                            $wpvs_series = $wpvs_video_series_terms[0];
                            $series_id = $wpvs_series->term_id;
                            $series_term = get_term($series_id, 'rvs_video_category');
                            $series_data['name'] = $series_term->name;
                            $series_data['description'] = wp_strip_all_tags($series_term->description);
                            $series_data['link'] = get_term_link($series_id, 'rvs_video_category');
                            $series_data['id'] = $series_id;
                            $series_data['is_episode'] = true;
                            $wpvs_series_images = wpvs_theme_get_show_thumbnail($series_id, null);
                            $wpvs_series_title_image = get_term_meta($series_id, 'wpvs_term_title_image', true);
                            if( ! empty($wpvs_series_images->src) ) {
                                $series_data['images']['thumbnail'] = $wpvs_series_images->src;
                            }
                            if( ! empty($wpvs_series_images->srcset) ) {
                                $series_data['images']['srcset'] = $wpvs_series_images->srcset;
                            }
                            if( ! empty($wpvs_series_title_image) ) {
                                $series_data['images']['title_image'] = $wpvs_series_title_image;
                            }
                            $this->added_term_ids[] = $series_id;
                        }
                    }
                }
                return (array) $series_data;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'Is this video an episode' ),
                'type'        => 'array'
            )
        ) );

        // ADD LOGGED IN USER FIELDS
        if( is_user_logged_in() ) {
            register_rest_field( 'rvs_video', 'user_data', array(
                'get_callback' => function( $video_object ) {
                    global $wpvs_current_user;
                    $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
                    $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
                    $video_id = $video_object['id'];
                    $wpvs_user_video_data = array();
                    if( ! empty($users_continue_watching_list) ) {
                        $percentage_complete = $wpvs_theme_user->get_video_percentage_complete($video_id);
                    }
                    if( ! empty($percentage_complete) ) {
                        $wpvs_user_video_data['percentage_complete'] = $percentage_complete;
                    }
                    return (array) $wpvs_user_video_data;
                },
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'User Video Data' ),
                    'type'        => 'object'
                )
            ) );
        }

        if( ! wpvs_check_for_membership_add_on() ) {
            register_rest_field( 'rvs_video', 'video_html', array(
                'get_callback' => function( $video_object ) {
                    $video_id = $video_object['id'];
                    $video_type = get_post_meta($video_id, '_rvs_video_type', true);

                    if($video_type == "vimeo") {
                        $video_vimeo_id = get_post_meta($video_id, 'rvs_video_post_vimeo_id', true);
                        $video_html = '<div id="wpvs-vimeo-video" class="wpvs-vimeo-video-player" data-vimeo-id="'.$video_vimeo_id.'"></div>';
                    }

                    if($video_type == "youtube") {
                        $video_html = get_post_meta($video_id, 'rvs_video_post_vimeo_html', true);
                    }
                    if($video_type == "custom" || $video_type == "jwplayer") {
                        $video_html = get_post_meta($video_id, 'rvs_video_custom_code', true);
                    }
                    if( empty($video_html) ) {
                        $video_html = "";
                    }
                    return (string) $video_html;
                },
                'update_callback' => null,
                'schema' => array(
                    'description' => __( 'Video HTML code.' ),
                    'type'        => 'string'
                )
            ) );
        }
    }

    public function wpvs_rest_api_taxonomy_filters() {

        register_rest_field( 'rvs_video_category', 'wpvs_type', array(
            'get_callback' => function( $video_object ) {
                $wpvs_type = 'show';
                return (string) $wpvs_type;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'WPVS Show type.' ),
                'type'        => 'string'
            ),
        ) );

        register_rest_field( 'rvs_video_category', 'access', array(
            'get_callback' => function( $term_object ) {
                $term_id = $term_object['id'];
                $wpvs_access_data = array();
                $wpvs_memberships = get_term_meta($term_id, 'wpvs_category_memberships', true);
                $wpvs_purchase_price = get_term_meta($term_id, 'wpvs_category_purchase_price', true);
                if( ! empty($wpvs_memberships) ) {
                    $wpvs_access_data['memberships'] = $wpvs_memberships;
                }
                if( ! empty($wpvs_purchase_price) ) {
                    $wpvs_access_data['price'] = $wpvs_purchase_price;
                }
                return (array) $wpvs_access_data;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'WPVS Memberships Access Info.' ),
                'type'        => 'array'
            ),
        ) );

        register_rest_field( 'rvs_video_category', 'details', array(
            'get_callback' => function( $term_object ) {
                $term_id = $term_object['id'];
                $wpvs_video_category_details = array(
                    'contains_shows' => get_term_meta($term_id, 'cat_contains_shows', true),
                    'has_seasons'    => get_term_meta($term_id, 'cat_has_seasons', true),
                    'order'          => get_term_meta($term_id, 'video_cat_order', true)
                );
                return (array) $wpvs_video_category_details;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'WPVS Category Information.' ),
                'type'        => 'array'
            ),
        ) );

        register_rest_field( 'rvs_video_category', 'images', array(
            'get_callback' => function( $term_object ) {
                $term_id = $term_object['id'];
                $wpvs_thumbnail_image = wpvs_theme_get_show_thumbnail($term_id, null);
                $wpvs_series_title_image = get_term_meta($term_id, 'wpvs_term_title_image', true);
                $wpvs_video_thumbnails = array();
                if( ! empty($wpvs_thumbnail_image->src) ) {
                    $wpvs_video_thumbnails['thumbnail'] = $wpvs_thumbnail_image->src;
                }
                if( ! empty($wpvs_thumbnail_image->srcset) ) {
                    $wpvs_video_thumbnails['srcset'] = $wpvs_thumbnail_image->srcset;
                }
                if( ! empty($wpvs_series_title_image) ) {
                    $wpvs_video_thumbnails['title_image'] = $wpvs_series_title_image;
                }
                return (array) $wpvs_video_thumbnails;
            },
            'update_callback' => null,
            'schema' => array(
                'description' => __( 'WPVS Category Thumbnails.' ),
                'type'        => 'array'
            ),
        ) );
    }
}
$wpvs_theme_rest_api_modifier = new WPVS_THEME_REST_API_MODIFIER();
