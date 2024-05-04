<div class="wrap">
    <?php include('admin-menu.php'); ?>
    <div class="vimeosync">
        <div class="rvsPadding">
            <div class="net-theme-settings">
                <form method="post" action="options.php">
                    <?php settings_fields( 'wpvs-social-options' );
                        if(get_option('social-media-links')) {
                            $socialMediaLinks = get_option('social-media-links');
                        }
                        if( empty($socialMediaLinks['facebook']) ) {
                            $socialMediaLinks['facebook'] = "";
                        }
                        if( empty($socialMediaLinks['twitter']) ) {
                            $socialMediaLinks['twitter'] = "";
                        }
                        if( empty($socialMediaLinks['google']) ) {
                            $socialMediaLinks['google'] = "";
                        }
                        if( empty($socialMediaLinks['instagram']) ) {
                            $socialMediaLinks['instagram'] = "";
                        }
                        if( empty($socialMediaLinks['linkedin']) ) {
                            $socialMediaLinks['linkedin'] = "";
                        }
                        if( empty($socialMediaLinks['pinterest']) ) {
                            $socialMediaLinks['pinterest'] = "";
                        }
                        if( empty($socialMediaLinks['youtube']) ) {
                            $socialMediaLinks['youtube'] = "";
                        }

                    ?>
                    <h3><?php _e('Social Media', 'wpvs-theme'); ?></h3>
                    <div class="rvs-container">
                        <div class="rvs-col-6">
                            <table class="form-table">
                                <tbody>
                                    <tr>
                                        <th scope="row"><label><?php _e('Facebook', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[facebook]" name="social-media-links[facebook]" type="url" value="<?php echo esc_attr( $socialMediaLinks['facebook'] ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label><?php _e('Twitter', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[twitter]" name="social-media-links[twitter]" type="url" value="<?php echo esc_attr( $socialMediaLinks['twitter'] ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label><?php _e('Google+', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[google]" name="social-media-links[google]" type="url" value="<?php echo esc_attr( $socialMediaLinks['google'] ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label><?php _e('Instagram', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[instagram]" name="social-media-links[instagram]" type="url" value="<?php echo esc_attr( $socialMediaLinks['instagram'] ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label><?php _e('YouTube', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[youtube]" name="social-media-links[youtube]" type="url" value="<?php echo esc_attr( $socialMediaLinks['youtube'] ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label><?php _e('LinkedIn', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[linkedin]" name="social-media-links[linkedin]" type="url" value="<?php echo esc_attr( $socialMediaLinks['linkedin'] ); ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><label><?php _e('Pinterest', 'wpvs-theme'); ?>:</label></th>
                                        <td><input class="regular-text" id="social-media-links[pinterest]" name="social-media-links[pinterest]" type="url" value="<?php echo esc_attr( $socialMediaLinks['pinterest'] ); ?>" /></td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                    </div>
                <?php submit_button(); ?>
                </form>
                <p>Please <a href="mailto:support@wpvideosubscriptions.com?subject=New Social Account for WPVS Theme">send us an email</a> to request additional social media accounts.</p>
            </div>
        </div>
    </div>
</div>
