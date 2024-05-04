<?php get_header();
global $post;
if( $post ) {
    $home_page_template = get_post_meta($post->ID, '_wp_page_template', true);
    $wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
}
if( empty($home_page_template) || $home_page_template == 'default' ) {
    $add_extra_top = false;
    if( empty($wpvs_page_featured_area_type) ) { ?>
        <div id="featured-area">
            <div class="container">
                <div class="wpvs-featured-slide-content sliderContent wpvs-example-slide border-box">
                    <h2 class="sliderTitle"><?php _e('Featured Area', 'wpvs-theme'); ?></h2>
                    <div class="sliderDescription"><p><?php _e('This is an example Featured Area. You can create multiple Featured Areas, each with multiple slides within the admin area.', 'wpvs-theme'); ?></p></div>
                    <a class="button" href="<?php echo admin_url('admin.php?page=wpvs-dynamic-sliders'); ?>"><?php _e('Create A Featured Area', 'wpvs-theme'); ?></a>
                </div>
            </div>
        </div>
    <?php } else {
        if( $wpvs_page_featured_area_type == "none") {
            $add_extra_top = true;
        } else {
            if( $post ) {
                wpvs_do_featured_slider($post->ID);
            }
        }
    }
    if($add_extra_top) {
        echo '<div class="video-page-container">';
    }
    get_template_part('template/default-home');
    if($add_extra_top) {
        echo '</div>';
    }
} else {
    $wpvs_template_name = rtrim($home_page_template, '.php');
    get_template_part($wpvs_template_name);
}
get_footer(); ?>
