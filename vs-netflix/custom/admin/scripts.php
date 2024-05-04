<?php

function wpvs_theme_register_admin_custom_post_edit_css( $hook ) {
    $current_admin_screen = get_current_screen();
    global $post_type;
    global $wpvs_theme_current_version;
    $wpvs_theme_directory = get_template_directory_uri();
    wp_register_style( 'wpvs-theme-video-post-css', $wpvs_theme_directory . '/custom/admin/css/video-post.css','', $wpvs_theme_current_version);
    wp_register_style('wpvs-admin-videos-overview', $wpvs_theme_directory . '/custom/admin/css/video-overview.css','', $wpvs_theme_current_version);

    if( $current_admin_screen && $current_admin_screen->base == 'edit' ) {
        if(  $post_type == 'rvs_video' ) {
            wp_enqueue_style('wpvs-admin-videos-overview' );
        }
    }

	if ( ('post-new.php' === $hook || 'post.php' === $hook ) && isset( $_GET['post_type'] ) ) {
        $new_post_type = $_GET['post_type'];
        if ( $new_post_type ===  'rvs_video' ) {
            wp_enqueue_style('wpvs-theme-video-post-css');
        }
	}
}
add_action( 'admin_enqueue_scripts', 'wpvs_theme_register_admin_custom_post_edit_css' );

function wpvs_theme_register_admin_custom_post_edit_js( $hook ) {
    global $wpvs_theme_current_version;
    $wpvs_theme_directory = get_template_directory_uri();
    $current_post_type = get_post_type();

    wp_register_script( 'wpvs-theme-video-post-js', $wpvs_theme_directory . '/custom/admin/js/video-post.js',array('jquery'), $wpvs_theme_current_version);
    wp_register_script( 'wpvs-theme-video-upload-js', $wpvs_theme_directory . '/custom/admin/js/video-upload.js',array('jquery'), $wpvs_theme_current_version);
    wp_register_script( 'wpvs-theme-video-quick-edit', $wpvs_theme_directory . '/custom/admin/js/quick-edit.js',array('jquery'), $wpvs_theme_current_version);

    wp_register_script('vimeo-player-js', '//player.vimeo.com/api/player.js','','',true);
    wp_register_script('wpvs-vimeo-player', $wpvs_theme_directory . '/custom/js/wpvs-load-vimeo-player.js', array('jquery', 'vimeo-player-js'), $wpvs_theme_current_version, true );

    if ( $current_post_type ===  'rvs_video' ) {
        if ( 'edit.php' === $hook ) {
            wp_enqueue_script('wpvs-theme-video-quick-edit');
        }
        if ( 'post.php' === $hook ) {
            wp_enqueue_script('wpvs-vimeo-player');
        }
    }

}
add_action( 'admin_enqueue_scripts', 'wpvs_theme_register_admin_custom_post_edit_js' );
