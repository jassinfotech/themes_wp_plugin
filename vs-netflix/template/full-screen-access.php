<?php
$wpvs_login_args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
	'form_id'        => 'vsform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => __( 'Username or Email', 'wpvs-theme' ),
	'label_password' => __( 'Password', 'wpvs-theme' ),
	'label_remember' => __( 'Remember Me', 'wpvs-theme' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
);
?>

<div class="wpvs-login-form">
    <div class="wpvs-login-labels">
        <label class="wpvs-login-label border-box active" data-show="wpvs-signin"><?php _e('Sign In', 'wpvs-theme'); ?></label>
        <label class="wpvs-login-label border-box" data-show="wpvs-create-account"><?php _e('Create Account', 'wpvs-theme'); ?></label>
    </div>
    <div id="wpvs-signin" class="wpvs-login-section active">
        <?php echo rvs_check_login_errors(); ?>
        <?php wp_login_form($wpvs_login_args); ?>
        <div id="vs-login-buttons">
            <a class="rvs-forgot-password" href="<?php echo wp_lostpassword_url(); ?>" title="<?php _e('Forgot Password', 'wpvs-theme'); ?>"><?php _e('Forgot Password', 'wpvs-theme'); ?></a>
        </div>
    </div>
    <div id="wpvs-create-account" class="wpvs-login-section">
        <?php echo do_shortcode('[rvs_create_account]');?>
    </div>
</div>
