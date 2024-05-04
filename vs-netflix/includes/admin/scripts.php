<?php

function wpvs_theme_register_admin_global_css( $hook ) {
    global $wpvs_theme_current_version;
    $wpvs_theme_directory = get_template_directory_uri();
    wp_register_style('wpvs-theme-update-loading-css', $wpvs_theme_directory . '/css/wpvs-theme-loading.css','', $wpvs_theme_current_version);
    wp_register_style('wpvs-theme-global-admin-css', $wpvs_theme_directory . '/css/admin/global.css','', $wpvs_theme_current_version);
    wp_register_style('wpvs-theme-admin-css', $wpvs_theme_directory . '/css/admin/wpvs-theme-admin.css','', $wpvs_theme_current_version);
    wp_register_style('wpvs-theme-genre-edits', $wpvs_theme_directory . '/css/admin/category-edit.css','', $wpvs_theme_current_version);
    wp_enqueue_style('wpvs-theme-update-loading-css');
    wp_enqueue_style('wpvs-theme-global-admin-css');
    wp_enqueue_style('wpvs-theme-genre-edits');

}
add_action( 'admin_enqueue_scripts', 'wpvs_theme_register_admin_global_css' );

function wpvs_theme_register_admin_global_js( $hook ) {
    global $wpvs_theme_current_version;
    $current_wp_admin_screen = get_current_screen();
    $wpvs_theme_directory = get_template_directory_uri();
    wp_register_script( 'wpvs-theme-update-loading', $wpvs_theme_directory . '/js/wpvs-theme-loading.js',array('jquery'), $wpvs_theme_current_version);
    wp_register_script('wpvs-rest-api-setup', $wpvs_theme_directory.'/js/admin/wpvs-rest-api-setup.js', array('jquery'), $wpvs_theme_current_version, true);
    wp_register_script('wpvs-video-image-upload', $wpvs_theme_directory . '/js/admin/thumbnail-upload.js', array('jquery'), $wpvs_theme_current_version);
    wp_register_script('wpvs-cat-thumbnails', $wpvs_theme_directory . '/js/admin/cat-thumbnail.js', array('jquery'), $wpvs_theme_current_version);
    wp_register_script('wpvs-upload-thumbnails', $wpvs_theme_directory . '/js/admin/wpvs-thumbnails.js', array('jquery'), $wpvs_theme_current_version);
    wp_register_script('wpvs-theme-admin-js', $wpvs_theme_directory . '/js/admin/wpvs-theme-admin.js', array('jquery'), $wpvs_theme_current_version);
    wp_register_script( 'wpvs-video-editing-js', $wpvs_theme_directory . '/js/admin/video-editing.js', array('jquery'), '', true);

    wp_enqueue_script('wpvs-theme-update-loading');
    wp_enqueue_script('wpvs-theme-admin-js');
}
add_action( 'admin_enqueue_scripts', 'wpvs_theme_register_admin_global_js' );


function wpvs_load_theme_block_editor_scripts() {
    global $wpvs_theme_current_version;
    $wpvs_theme_directory = get_template_directory_uri();
    wp_enqueue_style( 'slick-css', $wpvs_theme_directory . '/css/slick.css','', $wpvs_theme_current_version);
    wp_enqueue_style( 'slick-theme-css', $wpvs_theme_directory . '/css/slick-theme.css','', $wpvs_theme_current_version);
    wp_enqueue_style( 'wpvs-slick-global', $wpvs_theme_directory . '/css/wpvs-slick-global.css','', $wpvs_theme_current_version);

    $slider_count_variables = array(
        'large'   => get_theme_mod('wpvs_visible_slide_count_large', 6),
        'desktop' => get_theme_mod('wpvs_visible_slide_count_desktop', 5),
        'laptop'  => get_theme_mod('wpvs_visible_slide_count_laptop', 4),
        'tablet'  => get_theme_mod('wpvs_visible_slide_count_tablet', 3),
        'mobile'  => get_theme_mod('wpvs_visible_slide_count_mobile', 2)
    );

    wp_enqueue_script( 'slick-js', $wpvs_theme_directory . '/js/slick.min.js', array('jquery'), $wpvs_theme_current_version, true );
    wp_enqueue_script( 'netslider-js', $wpvs_theme_directory . '/js/net-slider.js', array('jquery', 'slick-js'), $wpvs_theme_current_version, true );
    wp_localize_script( 'netslider-js', 'slickslider', array( 'count' => $slider_count_variables));
}
add_action( 'enqueue_block_editor_assets', 'wpvs_load_theme_block_editor_scripts' );
