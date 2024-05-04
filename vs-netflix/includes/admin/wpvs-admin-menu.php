<?php $wpv_screen = $_GET['page']; ?>
<label id="rvs-dropdown-menu" for="rvs-menu-checkbox"><span class="dashicons dashicons-menu"></span> Menu</label>
<div id="rvs-admin-menu" class="border-box">
    <?php if( ! get_option('is-wp-videos-multi-site')) { ?>
        <a href="<?php echo admin_url('admin.php?page=wpvs-activation'); ?>" title="Activate Website" class="rvs-tab <?=($wpv_screen == "wpvs-activation") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-star-filled"></span> Activate Website</a>
    <?php } ?>
    <a href="<?php echo admin_url('admin.php?page=wpvs-theme-video-settings'); ?>" title="WP Video Settings" class="rvs-tab <?=($wpv_screen == "wpvs-theme-video-settings") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-admin-generic"></span> Video Settings</a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-theme-api-keys'); ?>" title="API Keys" class="rvs-tab <?=($wpv_screen == "wpvs-theme-api-keys") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-admin-network"></span> API Keys</a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-custom-player-settings'); ?>" title="Custom Player Settings" class="rvs-tab <?=($wpv_screen == "wpvs-custom-player-settings") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-editor-code"></span> Custom Player</a>
    <?php do_action( 'rvs_membership_admin_items' ); ?>
</div>
