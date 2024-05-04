<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php global $wpvs_theme_google_tracking;
        $wpvs_add_head_tracking = false;
        if( ! empty($wpvs_theme_google_tracking) ) {
            if( isset($wpvs_theme_google_tracking['cookie-notice']) && function_exists('cn_cookies_accepted') ) {
                if( cn_cookies_accepted() ) {
                    $wpvs_add_head_tracking = true;
                }
            } else {
                $wpvs_add_head_tracking = true;
            }
            if( $wpvs_add_head_tracking && isset($wpvs_theme_google_tracking['tag-manager-id']) && ! empty($wpvs_theme_google_tracking['tag-manager-id']) ) { ?>
            <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer', '<?php echo $wpvs_theme_google_tracking['tag-manager-id']; ?>')</script>
            <!-- End Google Tag Manager -->
        <?php }
            if( isset($wpvs_theme_google_tracking['meta-tag']) && ! empty($wpvs_theme_google_tracking['meta-tag']) ) {
                echo '<meta name="google-site-verification" content="'.$wpvs_theme_google_tracking['meta-tag'].'" />';
            }
        }
    ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <?php wp_head(); ?>
</head>
<?php $vs_hide_search = get_theme_mod('vs_hide_search', 0); ?>
<body ontouchstart="" <?php body_class(); ?>>
<?php if( $wpvs_add_head_tracking && isset($wpvs_theme_google_tracking['tag-manager-id']) && ! empty($wpvs_theme_google_tracking['tag-manager-id']) ) { ?>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $wpvs_theme_google_tracking['tag-manager-id']; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php }
$wpvs_theme_main_navigation_args = array();
if( has_nav_menu('main') ) {
    $wpvs_theme_main_navigation_args = array(
        'container' =>false,
         'theme_location' => 'main',
         'menu_class' => 'ease3',
         'echo' => true,
         'before' => '',
         'after' => '',
         'link_before' => '',
         'link_after' => '',
         'depth' => 0
    );
}
?>
<header id="header" class="ease3">
    <div class="header-container">
        <div id="logo" class="ease3">
            <a href="<?php echo home_url(); ?>">
                <?php
                    $desktop_theme_logo = esc_url( get_theme_mod( 'rogue_company_logo' ) );
                    $mobile_theme_logo = esc_url( get_theme_mod( 'wpvs_company_mobile_logo' ) );
                    $wpvs_logo_output = "";
                    if( $desktop_theme_logo && empty($mobile_theme_logo) ) {
                        $wpvs_logo_output = '<img class="border-box" src="' . $desktop_theme_logo . '" alt="' . get_bloginfo( 'name') . '">';
                    }

                    if( $mobile_theme_logo && empty($desktop_theme_logo) ) {
                        $wpvs_logo_output = '<img class="border-box" src="' . $mobile_theme_logo . '" alt="' . get_bloginfo( 'name') . '">';
                    }

                    if( $mobile_theme_logo && $desktop_theme_logo ) {
                        $wpvs_logo_output = '<img id="wpvs-mobile-logo" class="border-box" src="' . $mobile_theme_logo . '" alt="' . get_bloginfo( 'name') . '"><img id="wpvs-desktop-logo" class="border-box" src="' . $desktop_theme_logo . '" alt="' . get_bloginfo( 'name') . '">';
                    }

                    if( empty($wpvs_logo_output) ) {
                        echo '<h3 id="site-title">' . get_bloginfo( 'name', 'raw') . '</h3>';
                    } else {
                        echo $wpvs_logo_output;
                    }
                ?>
            </a>
        </div>
        <?php $vs_hide_front_menu = get_theme_mod('vs_primary_menu_home', 0);
            if(!$vs_hide_front_menu) { ?>
            <nav id="desktop" class="ease3">
                <?php
                    if( ! empty($wpvs_theme_main_navigation_args) ) {
                        $wpvs_theme_main_navigation_args['walker'] = new wpvs_theme_desktop_menu_walker();
                        wp_nav_menu( $wpvs_theme_main_navigation_args );
                    }
                ?>
            </nav>
        <?php } ?>
        <div class="header-icons ease3">
            <?php if(!$vs_hide_search) { ?>
                <label id="vs-open-search" class="ease3"><span class="dashicons dashicons-search"></span></label>
            <?php } ?>
            <label id="menuOpen" class="primary-color">
                <span></span>
            </label>
        </div>
    </div>
</header>
<?php if(!$vs_hide_front_menu) { ?>
<nav id="mobile" class="ease3 primary border-box">
    <?php
    if( ! empty($wpvs_theme_main_navigation_args) ) {
        $wpvs_theme_main_navigation_args['walker'] = new wpvs_theme_mobile_menu_walker();
        wp_nav_menu( $wpvs_theme_main_navigation_args );
    }
    ?>
</nav>
<?php }
if(!$vs_hide_search) { get_template_part('template/vs-search'); } ?>
<div id="wrapper" class="ease3">
