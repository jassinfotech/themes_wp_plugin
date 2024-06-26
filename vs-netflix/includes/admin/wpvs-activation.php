<?php
$wpvs_account_theme_license = get_option('wpvs_account_theme_license_key');
$wpvs_account_plugin_license = get_option('wpvs_account_plugin_license_key');
?>

<div class="wrap">
    <?php include('wpvs-admin-menu.php'); ?>
    <div class="vimeosync">
            <div class="rvs-container wpvs-activation-box">
                <h3>WP Video Subscriptions Activation</h3>
                <p>If you have an account at <a href="https://www.wpvideosubscriptions.com" target="_blank">wpvideosubscriptions.com</a> this page allows you to activate:
                <ul>
                    <li><a href="https://www.wpvideosubscriptions.com/video-memberships" target="_blank">WP Video Memberships</a> and <a href="https://www.wpvideosubscriptions.com/wordpress-netflix-theme" target="_blank">Themes</a> by WP Video Subscriptions</li>
                </ul>
                <div class="rvs-col-6 rvs-edit-form">
                    <h3><?php _e('Account Email', 'wpvs-theme'); ?></h3>
                    <p>Enter the email address for your account at <a href="https://www.wpvideosubscriptions.com/account" target="_blank">wpvideosubscriptions.com</a>.</p>
                    <input type="text" name="wpvs-user-email-address" id="wpvs-user-email-address" value="<?php echo esc_attr( get_option('wpvs_username_email_activation') ); ?>" autocomplete="off" placeholder="Email address"/>
                </div>
                <div class="rvs-col-6">
                    <div class="rvs-activation-errors">Error messages</div>
                </div>

            </div>
            <div class="rvs-container wpvs-activation-box">
                <div class="rvs-col-6 rvs-edit-form">
                    <h3><?php _e('Theme Activation', 'wpvs-theme'); ?></h3>
                    <p><?php _e('Enter a license key for any WPVS WordPress theme', 'wpvs-theme'); ?>.</p>
                    <input type="text" name="wpvs-enter-theme-license-key" id="wpvs-enter-theme-license-key" value="<?= (isset($wpvs_account_theme_license['license_key'])) ? $wpvs_account_theme_license['license_key']: ''; ?>" autocomplete="off" placeholder="Enter a valid license key..."/>
                    <div class="wpvs-activation-buttons">
                    <?php if( isset($wpvs_account_theme_license['is_valid']) && $wpvs_account_theme_license['is_valid'] ) : ?>
                        <label class="rvs-site-is-activated rvs-success"><?php _e('Theme Activated', 'wpvs-theme'); ?></label>
                        <label class="wpvs-activate-site-button rvs-button rvs-error-button" data-type="theme" data-action="deactivate"><?php _e('Deactivate', 'wpvs-theme'); ?></label>
                    <?php else : ?>
                        <label class="wpvs-activate-site-button rvs-button" data-type="theme" data-action="activate"><?php _e('Activate', 'wpvs-theme'); ?></label>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="rvs-container wpvs-activation-box">
                <div class="rvs-col-6 rvs-edit-form">
                    <h3><?php _e('WP Video Memberships Activation', 'wpvs-theme'); ?></h3>
                    <p><?php _e('Enter a license key for the WP Video Memberships plugin', 'wpvs-theme'); ?>.</p>
                    <input type="text" name="wpvs-enter-plugin-license-key" id="wpvs-enter-plugin-license-key" value="<?= (isset($wpvs_account_plugin_license['license_key'])) ? $wpvs_account_plugin_license['license_key']: ''; ?>" autocomplete="off" placeholder="Enter a valid license key..."/>
                    <div class="wpvs-activation-buttons">
                    <?php if( isset($wpvs_account_plugin_license['is_valid']) && $wpvs_account_plugin_license['is_valid'] ) :  ?>
                        <label class="rvs-site-is-activated rvs-success"><?php _e('WP Video Subscriptions Activated', 'wpvs-theme'); ?></label>
                        <label class="wpvs-activate-site-button rvs-button rvs-error-button" data-type="plugin" data-action="deactivate"><?php _e('Deactivate', 'wpvs-theme'); ?></label>
                    <?php else : ?>
                        <label class="wpvs-activate-site-button rvs-button" data-type="plugin" data-action="activate"><?php _e('Activate', 'wpvs-theme'); ?></label>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>
</div>
