<?php
global $vs_dropdown_details;
$rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
$rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
$wpvs_show_recently_added = get_theme_mod('wpvs_show_recently_added', 0);
$videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
$video_categories = get_terms(array(
    'taxonomy' => 'rvs_video_category',
    'hide_empty' => false,
    'meta_key' => 'video_cat_order',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
        'relation' => 'OR',
         array(
             'key' => 'video_cat_hide',
             'value' => '0',
             'compare' => '='

         ),
         array(
             'key' => 'video_cat_hide',
             'compare' => 'NOT EXISTS'
         )
     )
));

?>
<div id="wpvs-theme-slide-loader" class="drop-loading"><label class="net-loader"></label></div>
<div id="video-list-container" class="ease5 home-video-list">
<?php
    if( ! empty($video_categories) ) {
        global $wpvs_genre_slug_settings;
        $wpvs_slider_content = "";
        foreach($video_categories as $video_category) {
            $wpvs_category_url = '/'.$wpvs_genre_slug_settings['slug'].'/'.$video_category->slug;
            $wpvs_category_link = home_url($wpvs_category_url);
            $wpvs_term_slider_content = "";
            $wpvs_term_slider_content .= '<div class="video-category slide-category slide-container" data-wpvs-term-id="'.$video_category->term_id.'">';
            $wpvs_term_slider_content .= '<a href="'.$wpvs_category_link.'"><h3>'.$video_category->name.' <span class="dashicons dashicons-arrow-right-alt2"></span></h3></a>';
            $wpvs_term_slider_content .= '<div class="video-list-slider" data-items=""></div></div>';
            if($vs_dropdown_details) {
                $wpvs_term_slider_content .= '<div class="vs-video-description-drop border-box"><label class="wpvs-close-video-drop"><span class="dashicons dashicons-no-alt"></span></label><div class="drop-loading border-box"><label class="net-loader"></label></div></div>';
            }
            $wpvs_slider_content .= $wpvs_term_slider_content;
        }
        echo $wpvs_slider_content;
    }
?>
</div>
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
    <?php endwhile; ?>
<?php endif; wp_reset_query(); ?>
