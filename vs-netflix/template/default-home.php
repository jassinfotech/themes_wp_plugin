<?php
global $vs_dropdown_details;
$wpvs_theme_video_manager = new WPVS_Theme_Video_Manager();
$wpvs_show_recently_added = get_theme_mod('wpvs_show_recently_added', 0);

$videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');?>
<div id="wpvs-theme-slide-loader" class="drop-loading"><label class="net-loader"></label></div>
<div id="video-list-container" class="ease5 home-video-list">
<?php
    if( is_user_logged_in() ) {
        global $wpvs_my_list_enabled;
        global $wpvs_current_user;
        $show_my_list = get_theme_mod('wpvs_my_list_show_on_home', 1);
        $wpvs_show_continue_watching = get_theme_mod('wpvs_show_continue_watching', 1);
        if( $wpvs_current_user && $wpvs_show_continue_watching ) {
            $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
            $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
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
                    echo wpvs_theme_create_slider_from_videos($continue_watching_videos, __('Continue Watching', 'wpvs-theme'), null, array());
                }
            }
        }
        if( $wpvs_my_list_enabled && $show_my_list ) {
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
                echo wpvs_theme_create_slider_from_videos($my_list_videos, $my_list_home_title, null, array());
            }
        }
    }

    if($wpvs_show_recently_added) {
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
            echo wpvs_theme_create_slider_from_videos($recently_added_video_list, __('Recently Added', 'wpvs-theme'), null, array());
        }
    }
    $video_categories = get_terms(array(
        'taxonomy' => 'rvs_video_category',
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
        global $wpvs_genre_slug_settings;
        foreach($video_categories as $video_category) {
            $title_category_url = '/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug;
            $title_category_link = home_url($title_category_url);
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
                $wpvs_theme_video_manager->set_default_video_args($video_args);
                $wpvs_theme_video_manager->apply_video_ordering_filters();
                $video_list = $wpvs_theme_video_manager->get_videos();
            }
            if( ! empty($video_list) ) {
                echo wpvs_theme_create_slider_from_videos($video_list, $video_category->name, $title_category_link, array());
            }
        }
    } ?>
</div>
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
    <?php endwhile; ?>
<?php endif; wp_reset_query(); ?>
