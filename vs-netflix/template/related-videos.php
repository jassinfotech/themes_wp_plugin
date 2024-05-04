<?php
global $post;
global $vs_dropdown_details;
global $wpvs_current_user;
global $wpvs_theme_video_manager;
if( $wpvs_current_user ) {
    $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
    $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
}

$video_categories = wp_get_post_terms( $post->ID, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
$wpvs_show_related_videos = get_theme_mod('wpvs_show_related_videos', true);
$wpvs_related_videos_count = get_theme_mod('wpvs_related_videos_count', 7); ?>
<div class="row">
<?php if($wpvs_show_related_videos) {
    if( ! empty($video_categories) ) {
        $cat_position = (count($video_categories) - 1);
        $use_category = $video_categories[$cat_position]->term_id;
        $video_cat_name = $video_categories[$cat_position]->name;
        $same_cat_args = array(
            'post_type' => 'rvs_video',
            'posts_per_page' => $wpvs_related_videos_count,
            'post__not_in' => array($post->ID),
            'tax_query' => array(
                  array(
                      'taxonomy' => 'rvs_video_category',
                      'field' => 'term_id',
                      'terms' => $use_category
                  )
              )
        );

        if( empty(get_posts($same_cat_args)) ) {
            $cat_position = (count($video_categories) - 2);
            if(!isset($video_categories[$cat_position])) {
                $cat_position = (count($video_categories) - 1);
            }
            $use_category = $video_categories[$cat_position]->term_id;

            $video_cat_name = $video_categories[$cat_position]->name;
            $same_cat_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => $wpvs_related_videos_count,
                'post__not_in' => array($post->ID),
                'tax_query' => array(
                      array(
                          'taxonomy' => 'rvs_video_category',
                          'field' => 'term_id',
                          'terms' => $use_category
                      )
                  )
            );
        }
    }

    $other_video_array = array($post->ID);

    if( ! empty($same_cat_args) ) {
        $wpvs_theme_video_manager->set_default_video_args($same_cat_args);
        $wpvs_theme_video_manager->apply_video_ordering_filters();

        if( ! empty($wpvs_theme_video_manager->video_args) && isset($wpvs_theme_video_manager->video_args['post_type']) ) {
            $same_cat_videos = $wpvs_theme_video_manager->get_videos();
            $same_cat_count = count($same_cat_videos);
        }
    }

    // SAME CATEGORY VIDEOS
    if( ! empty($same_cat_videos) ) {
        echo wpvs_theme_create_slider_from_videos($same_cat_videos, $video_cat_name, null, array());
    }
} // END IF SHOW RELATED VIDEOS

$vs_show_recently_added = get_theme_mod('vs_show_recently_added', true);
$wpvs_recently_added_count = get_theme_mod('wpvs_recently_added_count', 7);
if($vs_show_recently_added) {
    $video_args = array(
        'post_type' => 'rvs_video',
        'posts_per_page' => $wpvs_recently_added_count,
        'post__not_in' => $other_video_array
    );
    $other_videos = get_posts($video_args);
    $other_vid_count = count($other_videos);

    // RECENTLY ADDED VIDEOS
    if(!empty($other_videos)) {
        echo wpvs_theme_create_slider_from_videos($other_videos, __('Recently Added', 'wpvs-theme'), null, array());
    }
} ?>
</div>
