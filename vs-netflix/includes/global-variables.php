<?php

global $wpvs_videos_per_page;
global $wpvs_theme_current_version;
global $wpvs_current_user;
global $vs_dropdown_details;
global $wpvs_my_list_enabled;
global $wpvs_watch_now_text;
global $wpvs_profile_browsing;
global $wpvs_theme_google_tracking;
global $wpvs_theme_thumbnail_sizing;
global $wpvs_theme_rating_icons;
global $wpvs_custom_player;
global $wpvs_this_theme_product_slug;
global $wpvs_theme_is_active;
$wpvs_this_theme_product_slug = 'vs-netflix';
$wpvs_my_list_enabled = get_theme_mod('wpvs_my_list_enabled', 1);
$vs_dropdown_details = get_theme_mod('vs_video_drop_details', 1);
$wpvs_watch_now_text = get_theme_mod('wpvs_watch_now_text', __('Watch Now', 'wpvs-theme'));
$wpvs_profile_browsing = get_theme_mod('wpvs_profile_browsing', 1);
$wpvs_theme_google_tracking = get_option('google-tracking');
$wpvs_custom_player = get_option('wpvs-custom-player');
$wpvs_theme_is_active = get_option('wpvs_theme_active');
if( ini_get('allow_url_fopen') ) {
$wpvs_theme_rating_icons = (object) array(
    'g'        => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-g.svg'),
    'pg'       => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-pg.svg'),
    'pg13'     => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-pg13.svg'),
    'r'        => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-r.svg'),
    'nc17'     => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-nc17.svg'),
    'notrated' => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-nr.svg'),
    'unrated'  => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-unrated.svg'),
    'tvma'     => file_get_contents(WPVS_THEME_BASE_DIR . '/icons/ratings/rating-tvma.svg'),
);
}
if(is_user_logged_in()) {
    $wpvs_current_user = wp_get_current_user();
    require_once('user-functions.php');
    require_once(__DIR__.'/../user/theme-user.php');
}
$wpvs_videos_per_page = get_theme_mod('vs_videos_per_page', '20');
$wpvs_theme_current_version = get_option('wpvs_theme_current_version');
