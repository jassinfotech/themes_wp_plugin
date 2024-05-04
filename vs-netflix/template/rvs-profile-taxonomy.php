<?php
global $wp_query;
$profile_image = get_term_meta($current_term->term_id, 'wpvs_actor_profile', true);
if( empty($profile_image) ) {
    $profile_image = get_template_directory_uri() .'/images/profile.png';
}
$imdb_link = get_term_meta($current_term->term_id, 'wpvs_actor_imdb_link', true);
$profile_title = "";
if( $current_term->taxonomy == 'rvs_actors' ) {
    global $wpvs_actor_slug_settings;
    $profile_title = $wpvs_actor_slug_settings['name'];
}
if( $current_term->taxonomy == 'rvs_directors' ) {
    global $wpvs_director_slug_settings;
    $profile_title = $wpvs_director_slug_settings['name'];
}
?>
<div id="video-list-container">
    <div class="video-category page-video-category">
        <div class="wpvs-profile-side border-box">
            <div class="wpvs-profile-image-side">
                <img src="<?php echo $profile_image; ?>" alt="<?php echo $current_term->name; ?>" />
            </div>
            <div class="wpvs-profile-details">
                <h2 class="profile-name"><?php echo $current_term->name; ?></h2>
                <?php 
                if( ! empty($profile_title) ) {
                    echo '<h5 class="profile-title">'.$profile_title.'</h5>';
                } 
                ?>
                <p><?php echo $current_term->description; ?></p>
                <?php if( ! empty($imdb_link) ) { ?>
                    <a class="button" href="<?php echo $imdb_link; ?>" target="_blank"><?php _e('More Details', 'wpvs-theme'); ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="video-results-side">
            <div class="video-list">
                <div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div>
                <div id="video-list-loaded">
                    <div id="video-list"></div>
                </div>
            </div>
        </div>
    </div>
</div>
