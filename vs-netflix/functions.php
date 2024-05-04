<?php

if (!defined('WPVS_THEME_VERSION')) {
    define('WPVS_THEME_VERSION', '5.9.0');
}

if(!defined('WPVS_THEME_BASE_DIR')) {
	define('WPVS_THEME_BASE_DIR', dirname(__FILE__));
}

if(!defined('WPVS_THEME_BASE_URL')) {
	define('WPVS_THEME_BASE_URL', get_template_directory_uri());
}

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

require_once('memberships/wpvs-membership-checks.php');
require_once('includes/global-variables.php');
require_once('includes/theme-init.php');
require_once('includes/wpvs-video-class.php');
require_once('includes/wpvs-theme-manager.php');
require_once('custom/setup.php');
require_once('rest/wpvs-rest-theme-class.php');
require_once('rest/wpvs-rest-api-functions.php');

require_once('includes/scripts.php');
require_once('includes/admin/scripts.php');
require_once('includes/walkers.php');
require_once('includes/admin/admin-pages.php');

require_once('includes/dynamic-slider.php');
require_once('includes/customize.php');
require_once('includes/custom-ajax.php');
require_once('includes/custom-functions.php');
require_once('includes/shortcodes.php');
require_once('includes/theme-widgets.php');
require_once('includes/backup-functions.php');
require_once('includes/review-functions.php');
require_once('includes/wpvs-theme-rest.php');
require_once('gutenberg-blocks/setup.php');

if(is_admin()) {
    require_once('includes/admin/dynamic-slider-admin.php');
    require_once('includes/admin/scripts.php');
    require_once('includes/admin/wpvs-product-checks.php');
    require_once('includes/admin/wpvs-theme-admin-functions.php');
    require_once('includes/admin/wpvs-theme-ajax.php');
    require_once('includes/admin/wpvs-theme-activation.php');
}

function wpvs_load_theme_things() {
    global $wpvs_theme_current_version;
    update_option('wpvs_theme_active', true);
    load_theme_textdomain( 'wpvs-theme', get_template_directory().'/languages/' );
    if(WPVS_THEME_VERSION !== $wpvs_theme_current_version) {
        run_wpvs_theme_update();
    }
}
add_action( 'after_setup_theme', 'wpvs_load_theme_things' );

function wpvstheme_is_active_setting($oldtheme_name, $oldtheme) {
    if (version_compare(PHP_VERSION, '5.5') < 0) {
        // Info message: Theme not activated
        add_action( 'admin_notices', 'wpvs_theme_not_activated' );
        function wpvs_theme_not_activated() {
          echo '<div class="update-nag">';
          _e( 'WPVS Theme not activated: You need to upgrade your PHP Version to at least 5.5.', 'wpvs-theme' );
          echo '</div>';
        }
        switch_theme( $oldtheme->stylesheet );
        return false;
    }
    update_option('wpvs_theme_active', true);
    if( empty(get_option('wpvs_my_list_page') ) ) {
        $wpvs_my_list_page_args = array(
          'post_type' => 'page',
          'post_title'    => 'My List',
          'post_content' => '[rvs_user_my_list]',
          'post_status'   => 'publish'
        );
        $new_user_my_list_page = wp_insert_post( $wpvs_my_list_page_args );
        if($new_user_my_list_page) {
            update_option('wpvs_my_list_page', $new_user_my_list_page);
        }
    }
}
add_action('after_switch_theme', 'wpvstheme_is_active_setting', 10, 2);

function wpvstheme_is_disabled_setting () {
    update_option('wpvs_theme_active', false);
}
add_action('switch_theme', 'wpvstheme_is_disabled_setting');
function run_wpvs_theme_update() {
    global $wpvs_theme_current_version;
    $needs_update = false;
    if(!empty($wpvs_theme_current_version)) {
        $current_version_number = intval(str_replace(".","",$wpvs_theme_current_version));
        if($current_version_number < 500) {
            require_once(WPVS_THEME_BASE_DIR.'/updates/update-theme-settings.php');
        }
        if($current_version_number < 507) {
            require_once(WPVS_THEME_BASE_DIR.'/updates/update-page-templates.php');
        }
        if($current_version_number < 509) {
            require_once(WPVS_THEME_BASE_DIR.'/updates/update-season-taxonomies.php');
        }
        if($current_version_number < 525) {
            require_once(WPVS_THEME_BASE_DIR.'/updates/update-video-thumbnails.php');
        }
        if($current_version_number < 535) {
            if( ! empty(get_option('rvs-username-access')) ) {
                update_option('wpvs_username_email_activation', get_option('rvs-username-access'));
                delete_option('rvs-username-access');
                get_option('wpvs-owned-themes');
                delete_option('rvs-access-check-time');
                delete_option('rvs-theme-access');
                delete_option('rvs-plugin-access');
                delete_option('wpvs-access-check-token');
            }
        }

    }
    update_option('wpvs_theme_current_version', '5.9.0');
}

if( is_admin() ) {
    require_once(WPVS_THEME_BASE_DIR.'/updates/wpvs-theme-filters.php');
    require_once(WPVS_THEME_BASE_DIR.'/updates/plugin-update-checker.php');
    $wpvs_theme_updates = Puc_v4_Factory::buildUpdateChecker(
        'https://www.wpvideosubscriptions.com/updates/?action=get_metadata&slug=vs-netflix',
        __FILE__,
        'wpvs-theme'
    );
    $wpvs_theme_updates->addQueryArgFilter('wpvs_filter_update_checks');
    if(strpos($_SERVER['REQUEST_URI'], 'update-core.php') || strpos($_SERVER['REQUEST_URI'], 'themes.php')) {
        $wpvs_theme_updates->checkForUpdates();
    }
    require_once(WPVS_THEME_BASE_DIR.'/updates/version-checks.php');
}
require_once('yoast-seo/config.php');
