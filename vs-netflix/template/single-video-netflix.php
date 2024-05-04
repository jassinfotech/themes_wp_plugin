<?php

$wpvs_background_trailer = array();
$wpvs_show_background_trailer = get_post_meta($post->ID, 'wpvs_show_background_trailer', true);
if( $wpvs_show_background_trailer ) {
    $wpvs_video_manager = new WPVS_Single_Video_Manager($post);
    $wpvs_background_trailer = $wpvs_video_manager->get_background_trailer();
}
$wpvs_video_title = the_title('','',false);
$vs_show_overlay = false;
if( (isset($_GET['failed']) && !empty($_GET['failed']) ) || ( isset($_GET['errmsg']) && !empty($_GET['errmsg']) ) ) {
    $vs_show_overlay = true;
}
$wpvs_open_videos_in_full_screen = get_theme_mod('wpvs_open_in_full_screen', 0);
if( $wpvs_open_videos_in_full_screen && isset($_GET['wpvsopen']) && $_GET['wpvsopen'] ) {
    $vs_show_overlay = true;
}
$play_button_setting = get_theme_mod( 'wpvs_play_button', 'standard');
$wpvs_full_screen_video = get_theme_mod( 'wpvs_full_screen_video', 1);
$display_video_details = true;
if( $video_restricted_content == 'videocontent' && ! $show_video_content ) {
    $display_video_details = false;
}
if($full_screen_access) {
    $full_screen_content .= '</div></div>';
    echo $full_screen_content;
} else {
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    $video_image = wpvs_theme_get_video_header_image($post->ID);

if($show_video_content) :
if( $wpvs_autoplay ) {
    $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
    $seconds_label = sprintf(__('starts in <span id="wpvs-autoplay-count">%d</span> seconds', 'wpvs-theme'), $wpvs_autoplay_timer);
    $custom_content .= '<div id="wpvs-autoplay-countdown"><a href="" id="wpvs-next-video-title"></a>'.$seconds_label.'<label id="wpvs-cancel-next-video"><span class="dashicons dashicons-no-alt"></span></label></div>';
}
?>
<div class="vs-full-screen-video border-box <?=($wpvs_full_screen_video) ? 'wpvs-full-screen-display' : ''?> <?=($vs_show_overlay) ? 'show-full-screen-video' : ''?>">
    <div class="wpvs-video-overlay">
        <label id="vs-video-back"><span class="dashicons dashicons-arrow-left-alt2"></span> <?php echo $wpvs_video_title; ?></label>
    </div>
    <div id="single-wpvstheme-video-container">
        <div id="rvs-main-video" class="row">
            <div class="videoWrapper">
            <?php echo $custom_content; ?>
            </div>
        </div>
    <!-- TRAILER -->
    <?php if($wpvs_video_trailer_enabled && !empty($video_html_code['trailer'])) : ?>
        <div id="rvs-trailer-video" class="row" <?=($vs_show_overlay) ? 'style="display: none;"' : ''?>>
            <div class="videoWrapper">
            <?php echo $video_html_code['trailer']; ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php else : ?>
<div class="vs-full-screen-video border-box <?=($wpvs_full_screen_video) ? 'wpvs-full-screen-display' : ''?> <?=($vs_show_overlay) ? 'show-full-screen-video' : ''?>">
    <div class="wpvs-video-overlay"><label id="vs-video-back"><span class="dashicons dashicons-arrow-left-alt2"></span> <?php echo $wpvs_video_title; ?></label></div>
    <div id="single-wpvstheme-video-container">
        <div id="rvs-main-video" class="<?=($wpvs_full_screen_video) ? 'wpvs-full-screen-login' : ''?> row">
            <div class="col-12">
            <?php echo $custom_content; ?>
            </div>
        </div>
        <?php if($wpvs_video_trailer_enabled && !empty($video_html_code['trailer'])) : ?>
            <div id="rvs-trailer-video" class="row" <?=($vs_show_overlay) ? 'style="display: none;"' : ''?>>
                <div class="videoWrapper">
                <?php echo $video_html_code['trailer']; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="vs-video-header">
    <img class="video-image" src="<?php echo $video_image; ?>" alt="<?php echo $wpvs_video_title; ?>" />
    <?php if( ! empty($wpvs_background_trailer) ) { ?>
        <div id="wpvs-single-background-trailer" class="trailer-background-container border-box" data-playerid="<?php echo $post->ID; ?>"><div class="trailer-wrapper <?php echo $wpvs_background_trailer['type']; ?>"><?php echo $wpvs_background_trailer['html']; ?></div></div>
    <?php } ?>
    <div class="vs-video-details">
        <?php if( ! empty($wpvs_title_image) ) { ?>
            <img class="video-title-image" src="<?php echo $wpvs_title_image; ?>" alt="<?php echo $wpvs_video_title; ?>" />
        <?php } else { ?>
            <h1><?php echo $wpvs_video_title; ?></h1>
        <?php } ?>
        <?php echo wpvs_theme_get_video_information($post->ID); ?>
        <?php if($display_video_details) { ?>
            <div class="vs-video-description">
                <?php the_content(); ?>
            </div>
        <?php }
            wpvs_theme_get_video_details($post->ID, true);
        endwhile; endif;
        $wpvs_video_button_content = '';
        if($play_button_setting == 'standard') {
            if( ! $show_video_content && ! empty($wpvs_pricing_option_buttons) ) {
                $play_button_html = '<div id="vs-play-video" class="button wpvs-play-button wpvs-no-access-button">'.$wpvs_pricing_option_buttons.'</div>';
            } else {
                $play_button_text = __('Play', 'wpvs-theme');
                if( ! empty($users_continue_watching_list) ) {
                    foreach($users_continue_watching_list as $continue_video) {
                        if($continue_video['id'] == $post->ID ) {
                            $play_button_text = __('Resume', 'wpvs-theme');
                        }
                    }
                }
                $play_button_text .= '<span class="dashicons dashicons-controls-play"></span>';
                $play_button_html = '<div id="vs-play-video" class="button wpvs-play-button">'.$play_button_text.'</div>';

                if( ! empty($wpvs_single_audio_player) ) {
                    if( ini_get('allow_url_fopen') ) {
                        $wpvs_headphones_icon = file_get_contents(WPVS_THEME_BASE_DIR . '/icons/headphones.svg');
                    } else {
                        $wpvs_headphones_icon = __('Listen', 'wpvs-theme');
                    }
                    $play_button_html .= '<div class="button" id="wpvs_play_audio_file" title="'.__('Listen Only', 'wpvs-theme').'">'.$wpvs_headphones_icon.'</div>';
                }
            }
            $wpvs_video_button_content .= $play_button_html;
        }
        if($wpvs_video_trailer_enabled && ! empty($video_html_code['trailer'])) {
            $wpvs_video_button_content .= '<div id="vs-play-trailer" class="button wpvs-play-button wpvs-show-trailer enhance">'.__('Trailer', 'wpvs-theme').' <span class="dashicons dashicons-controls-play"></span></div>';
        } if( $show_video_content && ! empty($wpvs_membership_video) && ! empty($wpvs_membership_video->download_link()) ) {
            $wpvs_video_button_content .= '<a class="button wpvs-play-button" href="'.$wpvs_membership_video->download_link().'" download><span class="dashicons dashicons-download"></span> '.$wpvs_membership_video->download_text().'</a>';
        } if($wpvs_my_list_enabled) {
            $wpvs_video_button_content .= '<div class="button wpvs-add-to-list enhance ';
            $wpvs_video_button_content .= ($add_to_my_list_button['add']) ? '':'remove';
            $wpvs_video_button_content .= '"data-videoid="'.$add_to_my_list_button['id'].'" data-videotype="'.$add_to_my_list_button['type'].'">'.$add_to_my_list_button['html'].'</div>';
        }
        echo $wpvs_video_button_content;
        if(current_user_can( 'manage_options' )) { ?>
            <div id="wpvs_admin_no_access_link">
                <?php if($no_access_preview) { ?>
                    <a href="<?php the_permalink(); ?>"><span class="dashicons dashicons-visibility"></span> Video Preview</a>
                    <em class="vs-note">Only site administrators can see this.</em>
                <?php } else { ?>
                    <a href="?vsp=noaccess"><span class="dashicons dashicons-visibility"></span> No Access Preview</a>
                    <em class="vs-note">Only site administrators can see this.</em>
                <?php } ?>
            </div>
        <?php }
        if( ! empty($wpvs_single_audio_player) ) { ?>
            <div id="wpvs_audio_file_container">
                <?php echo $wpvs_single_audio_player; ?>
            </div>
        <?php } ?>
    </div>
    <?php if($play_button_setting == 'play-icon') : ?>
        <label id="vs-play-video" class="vs-drop-play-button border-box"><span class="dashicons dashicons-controls-play"></span></label>
    <?php endif; ?>
</div>
<?php
get_template_part('template/related-videos');
} // end fullscreen else
if( comments_open() && $wpvs_video_review_ratings ) : ?>
    <div id="wpvs-video-reviews-container" class="border-box ease3">
        <label id="close-wpvs-reviews" class="border-box wpvs-close-icon"><span class="dashicons dashicons-no-alt"></span></label>
        <div class="container row">
        <?php comments_template('/template/reviews.php'); ?>
        </div>
    </div>
<?php endif; ?>
<?php get_footer();  ?>
