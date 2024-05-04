</div><!-- End Wrapper-->
<footer class="ease3">
    <div class="container row">
        <?php if ( is_active_sidebar( 'footer_left' ) ) :
            echo '<div class="footer-widget border-box">';
            dynamic_sidebar( 'footer_left' );
            echo '</div>';
        endif; ?>

        <?php if ( is_active_sidebar( 'footer_middle' ) ) :
            echo '<div class="footer-widget border-box">';
            dynamic_sidebar( 'footer_middle' );
            echo '</div>';
        endif; ?>

        <?php if ( is_active_sidebar( 'footer_right' ) ) :
            echo '<div class="footer-widget border-box">';
            dynamic_sidebar( 'footer_right' );
            echo '</div>';
        endif; ?>
    </div>
    <div id="lower-footer">
        <div class="container row">
            <div class="col-12">
                <?php get_template_part('social-media'); ?>
                <?php if ( has_nav_menu( 'footer' ) ) { ?>
                    <nav id="footer-nav">
                    <?php
                        $defaults = array(
                            'container' =>false,
                             'theme_location' => 'footer',
                             'menu_class' => 'ease3',
                             'echo' => true,
                             'before' => '',
                             'after' => '',
                             'link_before' => '',
                             'link_after' => '',
                             'depth' => 0
                        );
                        wp_nav_menu( $defaults );
                    ?>
                    </nav>
                <?php }
                    global $wpvs_theme_google_tracking;
                    if( ! empty($wpvs_theme_google_tracking) && isset($wpvs_theme_google_tracking['cookie-notice']) ) {
                        $cookie_notice_options = get_option('cookie_notice_options');
                        if( ! empty($cookie_notice_options) && isset($cookie_notice_options['revoke_text']) ) {
                            $wpvs_revoke_text = $cookie_notice_options['revoke_text'];
                        } else {
                            $wpvs_revoke_text = __('Cookie Settings', 'wpvs-theme');
                        }
                    ?>
                    <div class="wpvs-cookie-notice">
                        <a href="#" class="cn-revoke-cookie" title="<?php echo $wpvs_revoke_text; ?>"><?php echo $wpvs_revoke_text; ?></a>
                    </div>
                <?php } ?>
                <div class="copyright">
                    <p>
                    <?php
                        $wpvs_theme_copyright_text = get_option('wpvs_theme_footer_copyright_text');
                        if( ! empty($wpvs_theme_copyright_text) ) {
                            echo $wpvs_theme_copyright_text; ?>
                        <?php } else { ?>
                        &copy; <?php echo get_bloginfo('name'); ?> <?php echo date('Y'); ?>
                    <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
<?php if(is_admin_bar_showing()) { ?>
<script>
    jQuery(document).ready(function() {
        wpvs_check_wp_admin_bar();
    });
    jQuery(window).scroll(function() {
        wpvs_check_wp_admin_bar();
    });
    function wpvs_check_wp_admin_bar() {
        var adminBarHeight = jQuery('#wpadminbar').height();
        jQuery('#header, nav#mobile, #vs-search, .category-top').css('margin-top', adminBarHeight);
        if( jQuery('.vs-full-screen-video').length > 0 ) {
            jQuery('.vs-full-screen-video, .wpvs-video-overlay').css('top', adminBarHeight);
        }
        if( jQuery(window).width() < 960) {
            jQuery('#vs-search-button').css('margin-top', adminBarHeight);
        } else {
            jQuery('label#menuOpen, #vs-search-button').removeAttr('style');
        }
    }
    window.onresize = wpvs_check_wp_admin_bar;
</script>
<?php }
$wpvs_theme_custom_js = get_theme_mod('custom_js');
if( ! empty($wpvs_theme_custom_js) ) {
    echo '<script>' . $wpvs_theme_custom_js . '</script>';
}
global $wpvs_theme_google_tracking;
if( ! empty($wpvs_theme_google_tracking) ) {
    $wpvs_add_google_tracking_scripts = false;
    if( isset($wpvs_theme_google_tracking['cookie-notice']) && function_exists('cn_cookies_accepted') ) {
        if( cn_cookies_accepted() ) {
            $wpvs_add_google_tracking_scripts = true;
        }
    } else {
        $wpvs_add_google_tracking_scripts = true;
    }
    if( $wpvs_add_google_tracking_scripts && isset($wpvs_theme_google_tracking['analytics-id']) && ! empty($wpvs_theme_google_tracking['analytics-id']) ) { ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $wpvs_theme_google_tracking['analytics-id']; ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo $wpvs_theme_google_tracking['analytics-id']; ?>');
    </script>
<?php } }
$wpvs_disable_font_loading = get_theme_mod('wpvs_disable_font_output', 0);
$wpvs_headings_font = get_theme_mod('wpvs_heading_font', 'Open Sans');
$wpvs_body_font = get_theme_mod('wpvs_body_font', 'Open Sans');
$load_google_fonts = array($wpvs_body_font);
if( $wpvs_headings_font != $wpvs_body_font) {
    $load_google_fonts[] = $wpvs_headings_font;
}
if( ! $wpvs_disable_font_loading ) {
?>
<script>
WebFontConfig = {
    google: { families: [ <?php
        if( ! empty($load_google_fonts) ) {
            foreach($load_google_fonts as $font) {
                if( $font == end($load_google_fonts) ) {
                    echo "'".$font."'";
                } else {
                    echo "'".$font."',";
                }
            }
        } else {
            echo "'Open Sans'";
        }
    ?> ] } };
  (function() {
    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })();
</script>
<?php } ?>
    </body>
</html>
