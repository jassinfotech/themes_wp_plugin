<?php

// requires WPVS Memberships plugin
class WPVS_REST_Theme_Controller {
    public function wpvs_validate_rest_api_user_access_token($token) {
        $access_is_valid = false;
        $user_id = wpvs_rest_api_get_access_token_user_id($token);
        $current_time = current_time('timestamp', 1);
        if( ! empty($user_id) ) {
            $user_api_access = get_user_meta($user_id, 'wpvs_api_access_token', true);
            if( ! empty($user_api_access) && isset($user_api_access['token']) && isset($user_api_access['expires']) ) {
                if( intval($user_api_access['expires']) > $current_time && $user_api_access['token'] == $token ) {
                    $access_is_valid = true;
                }
            }
        }
        return $access_is_valid;
    }
}

if( ! function_exists('wpvs_rest_api_get_access_token_user_id') ) {
function wpvs_rest_api_get_access_token_user_id($token) {
    global $wpdb;
    $wpvs_rest_api_table_name = $wpdb->prefix . 'wpvs_api_access';
    $user_id = null;
    $access_token = $wpdb->get_results("SELECT * FROM $wpvs_rest_api_table_name WHERE token = '$token'");
    if( ! empty($access_token) && isset($access_token[0]->user_id) ) {
        $user_id = $access_token[0]->user_id;
    }
    return $user_id;
}
}
