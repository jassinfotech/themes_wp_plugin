<?php

if( ! function_exists('is_wpvs_custom_taxonomy') ) {
function is_wpvs_custom_taxonomy() {
    $is_wpvs_custom_taxonomy = false;
    if(is_post_type_archive('rvs_video') || is_tax('rvs_video_category') || is_tax('rvs_video_tags') || is_tax('rvs_actors') || is_tax('rvs_directors')) {
        $is_wpvs_custom_taxonomy = true;
    }
    return $is_wpvs_custom_taxonomy;
}
}
