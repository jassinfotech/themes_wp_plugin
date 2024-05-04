<?php get_header();

global $post;
$video_id = $post->ID;
$vs_display_layout = get_post_meta($video_id, 'rvs_video_template', true);
if(empty($vs_display_layout) || $vs_display_layout == "default") {
    $vs_display_layout = get_theme_mod('vs_single_layout', 'netflix');
}
if( $vs_display_layout == 'standard' || $vs_display_layout == 'youtube' ) {
    $wpvs_show_more_videos_below_standard = get_theme_mod('wpvs_show_more_videos_below_standard', 0);
}
global $widget_videos;
global $wpvs_current_user;
global $wpvs_my_list_enabled;
$video_html_code = wpvs_get_video_html_code($video_id);
$wpvs_video_trailer_enabled = get_post_meta($video_id, 'rvs_trailer_enabled', true);
$wpvs_autoplay = get_option('rvs_video_autoplay', 0);
$wpvs_video_review_ratings = get_theme_mod('wpvs_video_review_ratings', 0);
$custom_content = "";
$show_video_content = false;
$wpvs_video_has_restriction = false;
$full_screen_access = false;
$no_access_preview = false;
$video_restricted_content = 'video';
$wpvs_membership_video = null; // incase of old theme versions
$wpvs_pricing_option_buttons = '';
$full_screen_content = '<div id="vs-full-screen-login" class="border-box">';
if( empty($wpvs_current_user) ) {
    $full_screen_content .= '<div id="vs-login-content">';
} else {
    $full_screen_content .= '<div id="vs-login-content" class="logged-in">';
    $users_continue_watching_list = get_user_meta($wpvs_current_user->ID, 'wpvs_users_continue_watching_list', true);
}
if( class_exists('WPVS_Customer') ) {
    $user_has_access = false;
    $wpvs_customer = new WPVS_Customer($wpvs_current_user);
    $vs_access_layout = get_theme_mod('vs_single_access_layout', 'standard');
    $wpvs_free_for_users = get_post_meta( $video_id, '_rvs_membership_users_free', true );
    $video_restricted_content = get_post_meta($video_id, 'wpvs_restricted_video_content', true);
    if( empty($video_restricted_content) ) {
        $video_restricted_content = 'video';
    }

    if( class_exists('WPVS_MEMBERSHIPS_VIDEO') ) {
        $wpvs_membership_video = new WPVS_MEMBERSHIPS_VIDEO($video_id);
        if( $wpvs_membership_video->is_restricted() ) {
            $wpvs_video_has_restriction = true;
        }
    }

    if ( is_user_logged_in() ) {
        if($wpvs_free_for_users || current_user_can( 'manage_options' )) {
            $show_video_content = true;
        }

        if( ! $wpvs_video_has_restriction ) {
            $show_video_content = true;
        }

        if( ! $show_video_content) {
            $user_has_access = $wpvs_customer->has_access($wpvs_membership_video->required_memberships, $video_id);
            if($user_has_access['has_access']) {
                $show_video_content = true;
            }
        }

        if(isset($_GET['vsp']) && $_GET['vsp'] == 'noaccess') {
            $show_video_content = false;
            $no_access_preview = true;
        }

        if( ! $show_video_content ) {

            if($vs_access_layout == "standard") {
                $custom_content .= '<div class="container row">';
                if( ! empty($wpvs_membership_video) ) {
                    $custom_content .= $wpvs_membership_video->payment_options_content();
                }
                $custom_content .= '</div>';
            } else {
                $full_screen_access = true;
                if( ! empty($wpvs_membership_video) ) {
                    $full_screen_content .= $wpvs_membership_video->payment_options_content();
                }

            }
        }

        if($show_video_content) {
            $custom_content .= $video_html_code['video'];
        }
    } else {
        if( ! $wpvs_video_has_restriction ) {
            $show_video_content = true;
            $custom_content .= $video_html_code['video'];
            $full_screen_access = false;
        } else {
            // STANDARD NO ACCESS CONTENT
            if($vs_access_layout == "standard") {
                $custom_content .= rvs_not_logged_in();
            } else {
                $full_screen_access = true;
                $full_screen_content .= '<h3 class="text-align-center">' . __('This content is for members only', 'wpvs-theme') . '</h3>';
                ob_start();
                include(get_template_directory().'/template/full-screen-access.php');
                $full_screen_content .= ob_get_contents();
                ob_end_clean();
            }
        }
    }
    if( ! $show_video_content && get_option('wpvs_enable_pricing_text', 0) ) {
        $wpvs_pricing_option_buttons = wpvs_theme_get_price_starting_at_label($video_id, 'video');
    }
} else {
    $show_video_content = true;
    $custom_content .= $video_html_code['video'];
}
if($wpvs_my_list_enabled) {
    $add_to_my_list_button = wpvs_create_my_list_button($video_id);
}
$wpvs_title_image = get_post_meta($video_id, 'wpvs_title_image', true);
$wpvs_single_audio_player = wpvs_theme_get_audio_player($video_id);

if( ! post_password_required() ) {
    if($vs_display_layout == "youtube") :
        include(locate_template('template/single-video-youtube.php'));
    elseif($vs_display_layout == "netflix") :
        include(locate_template('template/single-video-netflix.php'));
    else :
        include(locate_template('template/single-video-standard.php'));
    endif;
} else { ?>
    <div class="video-page-container">
        <div class="container row">
            <div class="col-12">
            <?php the_content(); ?>
            </div>
        </div>
    </div>
<?php } ?>
