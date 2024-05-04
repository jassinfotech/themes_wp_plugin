<?php

/*
* Simple manager class for shows and videos
*/

class WPVS_Theme_Video_Manager {
    public $video_args;
    public function __construct() {
    }

    public function set_default_video_args($video_args) {
        if( is_array($video_args) ) {
            $this->video_args = $video_args;
        }
    }

    public function apply_video_ordering_filters() {
        if( is_array($this->video_args) ) {
            $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
            $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
            if( $rvs_video_order_settings == 'random' ) {
                $this->video_args['orderby'] = 'rand';
                $this->video_args['order'] = 'ASC';
            }
            if($rvs_video_order_settings == 'videoorder') {
                $this->video_args['meta_key'] = 'rvs_video_post_order';
                $this->video_args['orderby'] = 'meta_value_num';
                $this->video_args['order'] = $rvs_video_order_direction;
            }
            if( $rvs_video_order_settings == 'alpha' ) {
                $this->video_args['orderby'] = 'title';
                $this->video_args['order'] = $rvs_video_order_direction;
            }
        }
    }

    public function get_videos() {
        return get_posts($this->video_args);
    }

    public function get_related_widget_videos($video_id, $display_video_category, $display_video_cast) {
        $found_related_videos = array();
        $video_categories = wp_get_post_terms($video_id, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
        if( ! empty($video_categories) ) {
            $parent_cat_position = (count($video_categories) - 1);
            $wpvs_category = $video_categories[$parent_cat_position];
            $wpvs_category_id = $wpvs_category->term_id;
            $this->video_args['tax_query'] = array(
                array(
                    'taxonomy' => 'rvs_video_category',
                    'field' => 'term_id',
                    'terms' => $wpvs_category_id
                ),
            );
            $wpvs_related_videos = get_posts($this->video_args);
            if( ! empty($wpvs_related_videos) ) {
                $found_related_videos = $this->append_widget_videos( $wpvs_related_videos, $display_video_category, $display_video_cast );
            }
        }
        return $found_related_videos;
    }

    public function append_widget_videos( $video_items, $display_video_category, $display_video_cast ) {
        $wpvs_video_list = array();
        if( ! empty($video_items) ) {
            foreach($video_items as $video_item) {
                $video_thumbnail = wpvs_theme_get_video_thumbnail($video_item->ID, null);
                $add_video_to_list = (object) array(
                    'video_id' => $video_item->ID,
                    'video_title' => $video_item->post_title,
                    'video_link' => get_permalink($video_item->ID),
                    'video_thumbnail' => $video_thumbnail,
                );
                if( $display_video_category ) {
                    $video_categories = wp_get_post_terms( $video_item->ID, 'rvs_video_category', array( 'fields' => 'names'));
                    if( ! empty($video_categories) ) {
                        $video_category_title = $video_categories[0];
                        $add_video_to_list->video_term_title = $video_category_title;
                    }
                }
                if( $display_video_cast ) {
                    $video_actors = wp_get_post_terms( $video_item->ID, 'rvs_actors', array( 'fields' => 'names'));
                    if( ! empty($video_actors) ) {
                        $video_actor_title = $video_actors[0];
                        $add_video_to_list->video_actor_title = $video_actor_title;
                    }
                }
                $wpvs_video_list[] = $add_video_to_list;
            }
        }
        return $wpvs_video_list;
    }

    public function find_tv_show_term_ids($parent_term_id, $exclude_ids) {
        $found_tv_show_ids = array();
        $wpvs_search_term_params = array(
            'taxonomy' => 'rvs_video_category',
            'parent'   => $parent_term_id,
            'fields'   => 'ids',
            'hide_empty' => false,
            'meta_query' => array(
                array(
                    'key'  => 'cat_contains_shows',
                    'value' => 1
                ),
            ),
        );

        $wpvs_sub_term_ids = get_terms($wpvs_search_term_params);

        if( ! empty($wpvs_sub_term_ids) ) {
            foreach($wpvs_sub_term_ids as $sub_term_id) {
                $tv_show_search_params = array(
                    'taxonomy' => 'rvs_video_category',
                    'parent'   => $sub_term_id,
                    'fields'   => 'ids',
                    'hide_empty' => false,
                    'meta_query' => array(
                        array(
                            'key'  => 'cat_has_seasons',
                            'value' => 1
                        ),
                    ),
                );
                if( ! empty($exclude_ids) ) {
                    $tv_show_search_params['exclude'] = $exclude_ids;
                }
                $tv_show_ids = get_terms($tv_show_search_params);
                if( ! empty($tv_show_ids) ) {
                    $found_tv_show_ids = array_merge($found_tv_show_ids, $tv_show_ids);
                }
            }
        }
        return $found_tv_show_ids;
    }
}

/*
* TV Show Class for getting TV Show Info
*/

class WPVS_TV_Series extends WPVS_Theme_Video_Manager {
    public $series_id;
    public $season_id;

    public function __construct($series_id) {
        if( empty($series_id) ) {
            return;
        }
        $this->series_id = $series_id;
    }

    public function get_series_seasons() {
        $season_args = array(
            'taxonomy' =>'rvs_video_category',
            'parent' => $this->series_id,
            'meta_key' => 'video_cat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'hide_empty' => false
        );
        $seasons = get_terms( $season_args );
        return $seasons;
    }

    public function get_series_season_ids() {
        $season_args = array(
            'taxonomy' =>'rvs_video_category',
            'parent' => $this->series_id,
            'meta_key' => 'video_cat_order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'hide_empty' => false,
            'fields' =>'ids'
        );
        $seasons = get_terms( $season_args );
        return $seasons;
    }

    public function set_season($season_id) {
        $this->season_id = $season_id;
    }

    public function get_season_episodes($season_id) {
        if( empty($this->video_args) ) {
            $default_video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1
            );
            $this->set_default_video_args($default_video_args);
            $this->apply_video_ordering_filters();
        }
        $episode_query = array(
            array(
                'taxonomy' => 'rvs_video_category',
                'field' => 'term_id',
                'terms' => $season_id
            )
        );
        if( isset($this->video_args['fields']) ) {
            unset($this->video_args['fields']);
        }
        $this->video_args['tax_query'] = $episode_query;
        $episodes = get_posts( $this->video_args );
        return $episodes;
    }

    public function get_season_episode_ids($season_id, $episodes_filter) {
        if( empty($this->video_args) ) {
            $default_video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1,
                'fields' => 'ids'
            );
            $this->set_default_video_args($default_video_args);
            $this->apply_video_ordering_filters();
        }
        if( ! isset($this->video_args['fields']) || ( isset($this->video_args['fields']) && $this->video_args['fields'] != 'ids' ) ) {
            $this->video_args['fields'] = 'ids';
        }
        $episode_query = array(
            array(
                'taxonomy' => 'rvs_video_category',
                'field' => 'term_id',
                'terms' => $season_id
            )
        );
        if( ! empty($episodes_filter) ) {
            $episodes_filter['terms'] = intval($episodes_filter['terms']);
            $episode_query[] = $episodes_filter;
            $episode_query['relation'] = 'AND';
        }

        $this->video_args['tax_query'] = $episode_query;

        $episodes = get_posts( $this->video_args );
        return $episodes;
    }

    public function get_next_episode_id($episode_id) {
        $next_episode_id = null;
        $current_episode_order = get_post_meta($episode_id, 'rvs_video_post_order', true);
        if( $current_episode_order >= 0 ) {
            if( empty($this->video_args) ) {
                $default_video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => -1,
                    'post__not_in' => array($episode_id),
                    'fields' => 'ids'
                );
                $this->set_default_video_args($default_video_args);
                $this->apply_video_ordering_filters();
            }
            if( ! isset($this->video_args['post__not_in']) || ( isset($this->video_args['post__not_in']) && $this->video_args['post__not_in'] != $episode_id ) ) {
                $this->video_args['post__not_in'] = array($episode_id);
            }

            $this->video_args['meta_query'] = array(
                array(
                    'key' => 'rvs_video_post_order',
                    'value' => intval($current_episode_order),
                    'compare' => '>',
                ),
            );

            $episode_query = array(
                array(
                    'taxonomy' => 'rvs_video_category',
                    'field' => 'term_id',
                    'terms' => $this->season_id
                )
            );
            $this->video_args['tax_query'] = $episode_query;
            $episodes = get_posts( $this->video_args );

            if( ! empty($episodes) ) {
                $next_episode_id = $episodes[0];
            }
        }
        return $next_episode_id;
    }

    public function get_first_episode_id() {
        $first_episode_id = null;
        if( empty($this->video_args) ) {
            $default_video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1,
                'fields' => 'ids'
            );
            $this->set_default_video_args($default_video_args);
            $this->apply_video_ordering_filters();
        }

        if( isset($this->video_args['meta_query']) ) {
            unset($this->video_args['meta_query']);
        }
        $episode_query = array(
            array(
                'taxonomy' => 'rvs_video_category',
                'field' => 'term_id',
                'terms' => $this->season_id
            )
        );
        $this->video_args['tax_query'] = $episode_query;
        $episodes = get_posts( $this->video_args );

        if( ! empty($episodes) ) {
            $first_episode_id = $episodes[0];
        }
        return $first_episode_id;
    }
}

class WPVS_Single_Video_Manager {
    public $video_id;
    public $trailer_type;

    public function __construct($video_post) {
        if( empty($video_post) ) {
            return;
        }
        $this->video_id = $video_post->ID;
        $this->trailer_type = 'vimeo';
    }

    public function get_trailer() {
        $trailer_html = '';
        $trailer_enabled = get_post_meta($this->video_id, 'rvs_trailer_enabled', true);
        if($trailer_enabled) {
            $this->trailer_type = get_post_meta($this->video_id, '_rvs_trailer_type', true);
            if($this->trailer_type == "wordpress") {
                $rvs_trailer_wordpress_code = get_post_meta($this->video_id, 'rvs_trailer_wordpress_code', true);
                if( ! empty($rvs_trailer_wordpress_code) ) {
                     $trailer_html = do_shortcode($rvs_trailer_wordpress_code);
                }
            }

            if($this->trailer_type == "vimeo") {
                $trailer_vimeo_id = get_post_meta($this->video_id, 'rvs_trailer_vimeo_id', true);
                $trailer_html = '<div id="wpvs-vimeo-trailer" class="wpvs-vimeo-video-player" data-vimeo-id="'.$trailer_vimeo_id.'"></div>';
            }

            if($this->trailer_type == "youtube") {
                $trailer_html = get_post_meta($this->video_id, 'rvs_trailer_html', true);
            }

            if($this->trailer_type == "custom") {
                $trailer_html = get_post_meta($this->video_id, 'rvs_trailer_custom_code', true);
            }

            if($this->trailer_type == "jwplayer") {
                $trailer_html = get_post_meta($this->video_id, 'rvs_trailer_custom_code', true);
            }
        }
        return $trailer_html;
    }

    public function get_background_trailer() {
        $trailer_html = array();
        $trailer_enabled = get_post_meta($this->video_id, 'rvs_trailer_enabled', true);
        if($trailer_enabled) {
            $this->trailer_type = get_post_meta($this->video_id, '_rvs_trailer_type', true);
            if($this->trailer_type == "wordpress") {
                $trailer_wordpress_id = get_post_meta($this->video_id, 'rvs_trailer_wordpress_id', true);
                if( ! empty($trailer_wordpress_id) ) {
                    $trailer_video_src = wp_get_attachment_url( $trailer_wordpress_id );
                    if( ! empty($trailer_video_src) ) {
                        $trailer_html['html'] = '<video class="wpvs-background-trailer" preload="metadata" loop data-player="wordpress"><source type="video/mp4" src="'.$trailer_video_src.'"></video>';
                    }
                }
            }
            $trailer_html['type'] = $this->trailer_type;
        }
        return $trailer_html;
    }
}
