<?php

if( ! function_exists('wpvs_check_for_membership_add_on')) {
    function wpvs_check_for_membership_add_on() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if( is_plugin_active('vimeo-sync-memberships/vimeo-sync-memberships.php') ) {
            return true;
        }
        return false;
    }
}
