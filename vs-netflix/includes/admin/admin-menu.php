<?php $vs_screen = $_GET['page']; $wpvs_theme_updates = get_option('wpvs-theme-updates-seen'); ?>

<label id="rvs-dropdown-menu" for="rvs-menu-checkbox"><span class="dashicons dashicons-menu"></span> Menu</label>
<div id="rvs-admin-menu" class="border-box">
    <a href="<?php echo admin_url('admin.php?page=wpvs-theme-settings'); ?>" title="API Keys" class="rvs-tab <?=($vs_screen == "wpvs-theme-settings") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-star-filled"></span> <?php _e('Theme Styling', 'wpvs-theme'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-google-tracking'); ?>" title="Google Tracking" class="rvs-tab <?=($vs_screen == "wpvs-google-tracking") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-chart-line"></span> <?php _e('Google Tracking', 'wpvs-theme'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-social-options'); ?>" title="Social Media" class="rvs-tab <?=($vs_screen == "wpvs-social-options") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-share"></span> <?php _e('Social Media', 'wpvs-theme'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-shortcodes'); ?>" title="Shortcodes" class="rvs-tab <?=($vs_screen == "wpvs-shortcodes") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-editor-code"></span> <?php _e('Shortcodes', 'wpvs-theme'); ?></a>
    <a href="<?php echo admin_url('admin.php?page=wpvs-theme-updates'); ?>" title="Updates" class="rvs-tab <?=($vs_screen == "wpvs-theme-updates") ? 'rvs-tab-active' : ''?>"><span class="dashicons dashicons-update"></span> <?php _e('Updates', 'wpvs-theme'); ?><?=(!$wpvs_theme_updates) ? '<span class="dashicons dashicons-warning wpvs-update-needed"></span>' : ''?></a>
</div>
