<div class="wrap">
    <?php include('wpvs-admin-menu.php'); ?>
    <div class="vimeosync">
        <h3><?php _e('WPVS REST API', 'wpvs-theme'); ?></h3>
        <p><?php _e('The following are required to make restricted video content REST API requests', 'wpvs-theme'); ?></p>
            <?php
                $wpvs_rest_api_client_id = get_option('wpvs_rest_api_client_id', "");
                $wpvs_rest_api_secret = get_option('wpvs_rest_api_secret', "");
                $wpvs_rest_api_description = '<a href="https://www.wpvideosubscriptions.com/video-memberships/" target="_blank">WP Video Memberships</a> is not active.';
                if( wpvs_check_for_membership_add_on() ) {
                    if( empty($wpvs_rest_api_client_id) ) {
                        $wpvs_rest_api_client_id = wpvs_generate_secure_random_bytes(32);
                        if( ! empty($wpvs_rest_api_client_id) ) {
                            update_option('wpvs_rest_api_client_id', $wpvs_rest_api_client_id);
                        }
                    }
                    if( empty($wpvs_rest_api_secret) ) {
                        $wpvs_rest_api_secret = wpvs_generate_secure_random_bytes(32);
                        if( ! empty($wpvs_rest_api_secret) ) {
                            update_option('wpvs_rest_api_secret', $wpvs_rest_api_secret);
                        }
                    }
                    $wpvs_rest_api_description = __('WP Video Memberships is active! Use the following details to make restricted video content REST API requests.', 'wpvs-theme');
                }
            ?>
            <div class="rvs-container rvs-box">
                <p><?php echo $wpvs_rest_api_description; ?></p>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e('Client ID', 'wpvs-theme'); ?></th>
                        <td><input type="text"  class="regular-text" name="wpvs_rest_api_client_id" value="<?php echo esc_attr( $wpvs_rest_api_client_id ); ?>" readonly onClick="this.select();"/>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('Secret', 'wpvs-theme'); ?></th>
                        <td><input type="password"  class="regular-text" name="wpvs_rest_api_secret" id="wpvs_rest_api_secret" value="<?php echo esc_attr( $wpvs_rest_api_secret ); ?>" readonly onClick="this.select();"/>
                            <label id="show-wpvs-rest-secret"><?php _e('Show Secret', 'wpvs-theme'); ?></label>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div>
        </div>
    </div>
</div>
