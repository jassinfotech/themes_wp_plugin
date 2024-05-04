<?php
class WPVS_Theme_Active_Plugins_Checker {
    public function __construct() {}
    public function plugin_is_active($plugin_file) {
        $plugin_active = false;
        if( ! function_exists('is_plugin_active') ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if( is_plugin_active($plugin_file) ) {
            $plugin_active = true;
        }
        return $plugin_active;
    }
}

$wpvs_theme_active_plugins_checker = new WPVS_Theme_Active_Plugins_Checker();
if( $wpvs_theme_active_plugins_checker->plugin_is_active('wordpress-seo/wp-seo.php') || $wpvs_theme_active_plugins_checker->plugin_is_active('wordpress-seo-premium/wp-seo-premium.php') ) {
    require_once('meta-filters.php');
}
