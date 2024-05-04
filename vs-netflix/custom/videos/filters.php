<?php

add_filter('post_link', 'wpvs_theme_custom_type_permalinks', 1, 3);
add_filter('post_type_link', 'wpvs_theme_custom_type_permalinks', 1, 3);

function wpvs_theme_custom_type_permalinks($permalink, $post_id, $leavename) {
    global $wpvs_video_slug_settings;

    if (strpos($permalink, '%rvs_video_category%') === FALSE) return $permalink;
        $post = get_post($post_id);
        if (!$post) return $permalink;
        $terms = wp_get_object_terms($post->ID, 'rvs_video_category');
        if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0]))
        	$taxonomy_slug = $terms[0]->slug;
        else $taxonomy_slug = $wpvs_video_slug_settings['single-slug'];

    return str_replace('%rvs_video_category%', $taxonomy_slug, $permalink);
}

function wpvs_order_custom_video_type_posts( $query ) {
    if( ! is_admin() ) {
        if( is_wpvs_custom_taxonomy() ) {
            $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
            $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
            if( $rvs_video_order_settings == 'random' ) {
                set_query_var('orderby', 'rand');
                set_query_var('order', 'ASC');
            }
            if($rvs_video_order_settings == 'videoorder') {
                set_query_var('meta_key', 'rvs_video_post_order');
                set_query_var('orderby', 'meta_value_num');
                set_query_var('order', $rvs_video_order_direction);
            }
            if($rvs_video_order_settings == 'alpha') {
                set_query_var('orderby', 'title');
                set_query_var('order', $rvs_video_order_direction);
            }
        }
    }
}

add_action( 'pre_get_posts', 'wpvs_order_custom_video_type_posts' );
