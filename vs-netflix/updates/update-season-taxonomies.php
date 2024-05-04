<?php

function wpvs_update_series_terms_child_seasons_meta() {
    $wpvs_video_category_term_args = array(
        'taxonomy' => 'rvs_video_category',
        'hide_empty' => false,
        'meta_key' => 'cat_has_seasons',
        'meta_value' => 1,
        'fields' => 'ids',
    );
    $wpvs_video_category_terms = get_terms($wpvs_video_category_term_args);
    foreach($wpvs_video_category_terms as $series_id) {
        $series_seasons = get_term_children($series_id, 'rvs_video_category');
        if( ! empty($series_seasons) ) {
            foreach($series_seasons as $season_id) {
                update_term_meta($season_id, 'wpvs_is_season', 1);
            }
        }
    }
}
add_action('admin_init', 'wpvs_update_series_terms_child_seasons_meta');
