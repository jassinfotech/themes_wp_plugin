<?php
if($full_screen_access) {
    $full_screen_content .= '</div></div>';
    echo $full_screen_content;
} else { if ( have_posts() ) : while ( have_posts() ) : the_post(); $widget_videos = array($post->ID);
$display_video_details = true;
if( $video_restricted_content == 'videocontent' && ! $show_video_content ) {
    $display_video_details = false;
}
?>
<div class="video-page-container">
    <?php if($show_video_content) :
        if( $wpvs_autoplay ) {
            $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
            $seconds_label = sprintf(__('starts in <span id="wpvs-autoplay-count">%d</span> seconds', 'wpvs-theme'), $wpvs_autoplay_timer);
            $custom_content .= '<div id="wpvs-autoplay-countdown"><a href="" id="wpvs-next-video-title"></a>'.$seconds_label.'<label id="wpvs-cancel-next-video"><span class="dashicons dashicons-no-alt"></span></label></div>';
        }
// 		$thumbnail_image = get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'class' => 'thumbnail' ) );
		
    ?>
        <div id="single-video-container">
	
            <div class="row">
				
                <div id="wpvs-main-video" class="videoWrapper">
                <?php echo $custom_content; ?>
                </div>
            </div>
        </div>
        <?php if( ! empty($wpvs_single_audio_player) ) { ?>
            <div id="wpvs_audio_file_container">
                <div class="container row">
                    <?php echo $wpvs_single_audio_player; ?>
                </div>
            </div>
        <?php } ?>
    <?php else : if($wpvs_video_trailer_enabled && ! empty($video_html_code['trailer'])) : ?>
        <div id="single-video-container">
            <div class="row">
                <div class="videoWrapper">
                <?php echo $video_html_code['trailer']; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
        <div class="container row">
            <div class="col-12 wpvs-custom-content-box">
            <?php echo $custom_content; ?>
            </div>
        </div>
    <?php endif ;?>
    <div class="container row">
        <section id="main">
            <div id="main-content" class="col-12">
                <?php if($display_video_details) { ?>
                <div class="wpvs-top-video-controls">
                    <?php if( $show_video_content && ! empty($wpvs_membership_video) && ! empty($wpvs_membership_video->download_link()) ) { ?>
                        <a class="button" href="<?php echo $wpvs_membership_video->download_link(); ?>" download><span class="dashicons dashicons-download"></span> <?php echo $wpvs_membership_video->download_text(); ?></a>
                <?php }

                if( ! empty($wpvs_single_audio_player) && $show_video_content ) {
                    if( ini_get('allow_url_fopen') ) {
                        $wpvs_headphones_icon = file_get_contents(WPVS_THEME_BASE_DIR . '/icons/headphones.svg');
                    } else {
                        $wpvs_headphones_icon = __('Listen', 'wpvs-theme');
                    } ?>
                    <div class="button" id="wpvs_play_audio_file" title="<?php _e('Listen Only', 'wpvs-theme'); ?>"><?php echo $wpvs_headphones_icon; ?></div>
                <?php }

                if($wpvs_my_list_enabled) : ?>
                    <label class="button wpvs-add-to-list <?=($add_to_my_list_button['add']) ? '':'remove';?>" data-videoid="<?php echo $add_to_my_list_button['id']; ?>" data-videotype="<?php echo $add_to_my_list_button['type']; ?>"><?php echo $add_to_my_list_button['html']; ?></label>
                    <?php endif; ?>
                </div>
                <?php } if(current_user_can( 'manage_options' )) { ?>
                    <div class="text-align-right">
                        <?php if($no_access_preview) { ?>
                            <a href="<?php the_permalink(); ?>"><span class="dashicons dashicons-visibility"></span> Video Preview</a>
                            <em class="vs-note">Only site administrators can see this.</em>
                        <?php } else { ?>
                            <a href="?vsp=noaccess"><span class="dashicons dashicons-visibility"></span> No Access Preview</a>
                            <em class="vs-note">Only site administrators can see this.</em>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if( $display_video_details ) { ?>
                    <h1><?php the_title(); ?></h1>
                    <?php echo wpvs_theme_get_video_information($post->ID); ?>
                    <?php the_content(); ?>
                    <?php wpvs_theme_get_video_details($post->ID, true); ?>
                    <?php if($wpvs_video_review_ratings) {
                        comments_template('/template/reviews.php');
                    } else {
                        comments_template();
                    } ?>
                <?php } ?>
                <?php endwhile; endif;  ?>
            </div>
        </section>
        <?php if($display_video_details) {
            get_template_part('sidebar');
        }
        ?>
    </div>
</div>
<?php
if( $display_video_details && $wpvs_show_more_videos_below_standard ) {
    get_template_part('template/category-videos');
}
?>
<?php } get_footer(); ?>
