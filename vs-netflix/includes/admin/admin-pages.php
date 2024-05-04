<?php

add_action( 'admin_menu', 'wpvs_theme_register_theme_admin_pages' );
add_action( 'admin_init', 'wpvs_theme_register_theme_admin_settings' );

if( !function_exists('wpvs_theme_register_theme_admin_settings')) {
    function wpvs_theme_register_theme_admin_settings() {

        register_setting( 'net-theme-tracking', 'google-tracking' );
        register_setting( 'wpvs-social-options', 'social-media-links' );

        // ORIGINALLY WP VIDEOS PLUGIN SETTINGS
        register_setting( 'wpvs-rest-api-keys', 'wpvs_rest_api_client_id' );
        register_setting( 'wpvs-rest-api-keys', 'wpvs_rest_api_secret' );
        register_setting( 'wpvs-video-settings', 'rvs_video_ordering' );
        register_setting( 'wpvs-video-settings', 'rvs_video_order_direction' );
        register_setting( 'wpvs-video-settings', 'rvs_video_autoplay' );
        register_setting( 'wpvs-video-settings', 'wpvs_autoplay_timer' );

        register_setting( 'wpvs-video-settings', 'wpvs-video-slug-settings' );
        register_setting( 'wpvs-video-settings', 'wpvs-genre-slug-settings' );
        register_setting( 'wpvs-video-settings', 'wpvs-actor-slug-settings' );
        register_setting( 'wpvs-video-settings', 'wpvs-director-slug-settings' );

        register_setting( 'wpvs-customer-access', 'wpvs_username_email_activation' );
        register_setting( 'wpvs-customer-access', 'wpvs_account_theme_license_key' );
        register_setting( 'wpvs-customer-access', 'wpvs_account_plugin_license_key' );

        register_setting( 'wpvs-custom-player-settings', 'wpvs-custom-player' );
    }
}

if( !function_exists('wpvs_theme_register_theme_admin_pages')) {
    function wpvs_theme_register_theme_admin_pages() {
        add_theme_page( 'Theme Options', 'Theme Options', 'manage_options', 'wpvs-theme-settings', 'wpvs_theme_settings_init', 5);
        add_submenu_page( null, 'Google Tracking', 'Google Tracking', 'manage_options', 'wpvs-google-tracking', 'wpvs_google_tracking' );
        add_submenu_page( null, 'Social Media', 'Social Media', 'manage_options', 'wpvs-social-options', 'wpvs_social_options' );
        add_submenu_page( null, 'Shortcodes', 'Shortcodes', 'manage_options', 'wpvs-shortcodes', 'wpvs_theme_shortcodes_init' );
        add_submenu_page( null, 'Updates', 'Updates', 'manage_options', 'wpvs-theme-updates', 'wpvs_theme_updates' );

        // ORIGINALLY WP VIDEOS PLUGIN ADMIN PAGES
        add_menu_page( 'WP Videos', 'WP Videos', 'manage_options', 'wpvs-theme-video-settings', 'wpvs_theme_video_settings', 'dashicons-video-alt3');
        if( ! get_option('is-wp-videos-multi-site')) {
            add_submenu_page( 'wpvs-theme-video-settings', 'Activation', 'Activation', 'manage_options', 'wpvs-activation', 'wpvs_theme_website_activation' );
        }
        add_submenu_page( 'wpvs-theme-video-settings', 'API Keys', 'API Keys', 'manage_options', 'wpvs-theme-api-keys', 'wpvs_api_key_setup');
        add_submenu_page( 'wpvs-theme-video-settings', 'Custom Player', 'Custom Player', 'manage_options', 'wpvs-custom-player-settings', 'wpvs_custom_player_settings');
        if( ! get_option('wpvs_memberships_plugin_is_activated') ) {
            add_submenu_page( 'wpvs-theme-video-settings', 'Subscriptions', 'Subscriptions', 'manage_options', 'rvs-membership-add-on', 'wpvs_membership_add_on_admin_page' );
        } else {
			if( has_action('rvs_add_membership_menu_items') ) {
				do_action( 'rvs_add_membership_menu_items' );
			}
        }
    }
}

if( !function_exists('wpvs_theme_settings_init')) {
    function wpvs_theme_settings_init() {
        require_once('theme-settings.php');
    }
}

if( !function_exists('wpvs_google_tracking')) {
    function wpvs_google_tracking() {
        wp_enqueue_style('wpvs-theme-admin-css');
        require_once('theme-google-tracking.php');
    }
}

if( !function_exists('wpvs_social_options')) {
    function wpvs_social_options() {
        wp_enqueue_style('wpvs-theme-admin-css');
        require_once('theme-social-settings.php');
    }
}

if( !function_exists('wpvs_theme_shortcodes_init')) {
    function wpvs_theme_shortcodes_init() {
        wp_enqueue_style('wpvs-theme-admin-css');
        require_once('theme-shortcodes.php');
    }
}

if( !function_exists('wpvs_theme_updates')) {
    function wpvs_theme_updates() {
        wp_enqueue_style('wpvs-theme-admin-css');
        require_once('run-updates.php');
    }
}


// ORIGINALLY WP VIDEOS PLUGIN PAGES

if( !function_exists('wpvs_membership_add_on_admin_page')) {
    function wpvs_membership_add_on_admin_page() {
        require_once('wpvs-membership-add-on.php');
    }
}

if( !function_exists('wpvs_theme_video_settings')) {
    function wpvs_theme_video_settings() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script('wp-color-picker' );
        require_once('wpvs-videos-setup.php');
    }
}

if( !function_exists('wpvs_custom_player_settings')) {
    function wpvs_custom_player_settings() {
        $js_editor = wp_enqueue_code_editor( array( 'type' => 'text/javascript') );
        $css_editor = wp_enqueue_code_editor( array( 'type' => 'text/css') );
        $js_file_editor = wp_enqueue_code_editor( array( 'type' => 'text/html') );
        $css_file_editor = wp_enqueue_code_editor( array( 'type' => 'text/html') );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-js-editor", %s ); } );',
                wp_json_encode( $js_editor )
            )
        );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-css-editor", %s ); } );',
                wp_json_encode( $css_editor )
            )
        );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-js-file-editor", %s ); } );',
                wp_json_encode( $js_file_editor )
            )
        );
        wp_add_inline_script('code-editor',
        sprintf(
                'jQuery( function() { wp.codeEditor.initialize( "wpvs-css-file-editor", %s ); } );',
                wp_json_encode( $css_file_editor )
            )
        );
        require_once('wpvs-custom-player-settings.php');
    }
}



if( !function_exists('wpvs_api_key_setup')) {
    function wpvs_api_key_setup() {
        wp_enqueue_script('wpvs-rest-api-setup' );
        require_once('wpvs-api-keys.php');
    }
}

if( ! function_exists('wpvs_theme_website_activation') ) {
    function wpvs_theme_website_activation() {
        require_once('wpvs-activation.php');
    }
}

function wpvs_theme_slug_changes_check($old_value, $new_value) {
    if($old_value['slug'] != $new_value['slug']) {
        wp_schedule_single_event(time(), 'wpvs_run_flush_rewrite_event');
    }
}

function wpvs_theme_flush_rewrite_on_slug_changes() {
    flush_rewrite_rules();
}

add_action( 'wpvs_run_flush_rewrite_event', 'wpvs_theme_flush_rewrite_on_slug_changes' );

add_action('update_option_wpvs-video-slug-settings', 'wpvs_theme_slug_changes_check', 10, 2);
add_action('update_option_wpvs-genre-slug-settings', 'wpvs_theme_slug_changes_check', 10, 2);
add_action('update_option_wpvs-actor-slug-settings', 'wpvs_theme_slug_changes_check', 10, 2);
add_action('update_option_wpvs-director-slug-settings', 'wpvs_theme_slug_changes_check', 10, 2);
