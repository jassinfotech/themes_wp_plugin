<?php
function wpvs_filter_update_checks($queryArgs) {
    global $wpvs_this_theme_product_slug;
    $wpvs_account_theme_license = get_option('wpvs_account_theme_license_key');
    $check_current_time = current_time('timestamp', 0);
    if( ! empty($wpvs_account_theme_license) && isset($wpvs_account_theme_license['is_valid']) && $wpvs_account_theme_license['is_valid'] && $wpvs_account_theme_license['expires'] > $check_current_time ) {
        $queryArgs['has_rvs_access'] = true;
        $queryArgs['site'] = home_url();
        $queryArgs['product'] = $wpvs_this_theme_product_slug;
        $queryArgs['license_key'] = $wpvs_account_theme_license['license_key'];
    }
    return $queryArgs;
}
