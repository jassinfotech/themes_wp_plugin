<?php

/*
* Simple class for checking video details
*/

class WPVS_Theme_User {
    public $user;
    public $user_id;

    public function __construct($wp_user) {
        if( empty($wp_user) ) {
            return;
        }
        $this->user = $wp_user;
        $this->user_id = $wp_user->ID;
    }

    public function get_continue_watching_list() {
        return $users_continue_watching_list = get_user_meta($this->user_id, 'wpvs_users_continue_watching_list', true);
    }

    public function get_continue_watching_ids() {
        $currently_watching_ids = array();
        $users_continue_watching_list = get_user_meta($this->user_id, 'wpvs_users_continue_watching_list', true);
        if( ! empty($users_continue_watching_list) ) {
            foreach($users_continue_watching_list as $continue_video) {
                $currently_watching_ids[] = $continue_video['id'];
            }
        }
        return $currently_watching_ids;
    }

    public function get_video_percentage_complete($video_id) {
        $found_percentage = null;
        $continue_watching_list = $this->get_continue_watching_list();
        if( ! empty($continue_watching_list)  ) {
            foreach($continue_watching_list as $video_item) {
                if( $video_item['id'] == $video_id ) {
                    $found_percentage = $video_item['percent_complete'];
                    break;
                }
            }
        }
        return $found_percentage;
    }
}
