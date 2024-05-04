<?php
function wpvs_load_check_theme_admin_updates() {
    $wp_videos_current_version = get_option('wpv_vimeosync_current_version');
    if( ! empty($wp_videos_current_version) ) {
        $wp_videos_current_updates_version = intval(str_replace(".","",$wp_videos_current_version));
        if($wp_videos_current_updates_version < 254) {
            add_action( 'admin_notices', 'wp_videos_update_message_254' );
            function wp_videos_update_message_254() {
              echo '<div class="update-nag">';
              echo 'IMPORTANT: The WP Videos plugin needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 2.5.4</a>';
              echo '</div>';
            }
        }
    }
}
add_action( 'admin_init', 'wpvs_load_check_theme_admin_updates' );

function wpvs_theme_version_updates_check() {
    if( wpvs_check_for_membership_add_on() ) {
        $wpvs_memberships_current_version = get_option('rvs_memberships_version');
        if( ! empty($wpvs_memberships_current_version) ) {
            $wpvs_membership_updates_version = intval(str_replace(".","",$wpvs_memberships_current_version));
            if($wpvs_membership_updates_version < 314) {
                $wpvs_membership_update_required = true;
                add_action( 'admin_notices', 'wpvs_wpvideos_update_message_314' );
                function wpvs_wpvideos_update_message_314() {
                  echo '<div class="update-nag">';
                  _e( 'IMPORTANT: WP Video Memberships needs an update. Please <a href="'.admin_url('plugins.php').'">upgrade to version 3.1.4</a>', 'wpvs-theme' );
                  echo '</div>';
                }
            }
        }
    }
}
add_action('admin_init', 'wpvs_theme_version_updates_check');
