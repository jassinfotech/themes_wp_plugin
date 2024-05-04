<?php
function wpvs_theme_create_video_html_request() {
    if ( isset($_POST['videosrc']) && ! empty($_POST['videosrc']) && isset($_POST['videowidth']) && ! empty($_POST['videowidth']) && isset($_POST['videoheight']) && ! empty($_POST['videoheight']) && isset($_POST['videotype']) && ! empty($_POST['videotype'])) {
        $video_src = $_POST['videosrc'];
        $video_width = $_POST['videowidth'];
        $video_height = $_POST['videoheight'];
        $video_type = $_POST['videotype'];
        $video_shortcode = '[video width="'.$video_width.'" height="'.$video_height.'" '.$video_type.'="'.$video_src.'"][/video]';
        echo do_shortcode( $video_shortcode );
    }
    wp_die();
}
add_action( 'wp_ajax_wpvs_theme_create_video_html_request', 'wpvs_theme_create_video_html_request' );
