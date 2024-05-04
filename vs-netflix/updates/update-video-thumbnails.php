<?php

function wpvs_theme_update_video_post_thumbnail_images() {
    $wpvs_video_args = array(
        'post_type' => 'rvs_video',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            array(
                'key' => '_rvs_video_thumbnails',
                'compare' => 'EXISTS'
            ),
        )
    );
    $wpvs_video_posts = get_posts($wpvs_video_args);
    if( ! empty($wpvs_video_posts) ) {
        foreach($wpvs_video_posts as $video_id) {
            $wpvs_video_image_src = null;
            $video_thumbnails = get_post_meta($video_id, '_rvs_video_thumbnails', true);
            if( ! empty($video_thumbnails) ) {
                $check_image_index = 7;
                while($check_image_index > 2) {
                    if( isset($video_thumbnails[$check_image_index]) && ! empty($video_thumbnails[$check_image_index])) {
                        $wpvs_video_image_src = $video_thumbnails[$check_image_index];
                        break;
                    }
                    $check_image_index--;
                }
                if( ! empty($wpvs_video_image_src) && empty(get_post_meta($video_id, 'rvs_thumbnail_image', true)) ) {
                    if( strpos($wpvs_video_image_src, '&src=') !== FALSE ) {
                        $wpvs_video_image_src = explode('&src=', $wpvs_video_image_src);
                        $wpvs_video_image_src = $wpvs_video_image_src[0];
                    }
                    update_post_meta($video_id, 'rvs_thumbnail_image', $wpvs_video_image_src);
                }
            }
            delete_post_meta($video_id, '_rvs_video_thumbnails');
        }
    }
}
add_action('init', 'wpvs_theme_update_video_post_thumbnail_images');
