<?php

function wpvs_theme_updates_version_checks() {
    if( get_option('wpvs_memberships_plugin_is_activated') ) {
        $wpvs_video_memberships_current_version = get_option('rvs_memberships_version');
        if(!empty($wpvs_video_memberships_current_version)) {
            $wpvs_video_memberships_update_version = intval(str_replace(".","",$wpvs_video_memberships_current_version));
            if($wpvs_video_memberships_update_version < 335) {
                add_action( 'admin_notices', 'wpvs_video_memberships_update_message_335' );
                function wpvs_video_memberships_update_message_335() {
                  echo '<div class="update-nag">';
                  _e( 'IMPORTANT: WP Video Memberships needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 3.3.5</a>', 'wpvs-theme' );
                  echo '</div>';
                }
            }
            if($wpvs_video_memberships_update_version < 415) {
                add_action( 'admin_notices', 'wpvs_video_memberships_update_message_415' );
                function wpvs_video_memberships_update_message_415() {
                  echo '<div class="update-nag">';
                  _e( 'IMPORTANT: WP Video Memberships needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 4.1.5</a>', 'wpvs-theme' );
                  echo '</div>';
                }
            }
        }
    }
}
add_action('admin_init', 'wpvs_theme_updates_version_checks');
