<?php
global $wp_query;
global $wpvs_current_user;
if( $wpvs_current_user ) {
    $wpvs_theme_user = new WPVS_Theme_User($wpvs_current_user);
    $users_continue_watching_list = $wpvs_theme_user->get_continue_watching_list();
}
$wpvs_theme_video_manager = new WPVS_Theme_Video_Manager();
$has_sidebar = false;
$filter_text = $wpvs_genre_slug_settings['name-plural'];
if( ! empty($current_term) ) {
    $filter_text = $current_term->name;
}
global $cat_has_seasons;
if($cat_has_seasons) {
    $filter_text = $wpvs_genre_slug_settings['name-seasons'];
}
if( function_exists('wpvs_is_current_term_purchase') ) {
    $wpvs_is_term_purchase = wpvs_is_current_term_purchase();
    if( ! empty($wpvs_is_term_purchase) ) {
        echo '<div class="wpvs-term-checkout border-box"><div class="container row"><div class="col-12"><label id="close-wpvs-checkout" class="border-box"><span class="dashicons dashicons-no-alt"></span></label>'.$wpvs_is_term_purchase.'</div></div></div>';
    }
}
?>
<div class="category-top border-box ease3">
    <div id="category-breadcrumbs" class="border-box">
        <h3>
        <?php if(!empty($parent) && !is_wp_error($parent)) {
            $parent_link = get_term_link($parent->term_id);
            $parent_title = '<span class="dashicons dashicons-arrow-left"></span> '.$parent->name;
       } else {
            global $wpvs_video_slug_settings;
            $parent_link = home_url('/'.$wpvs_video_slug_settings['slug']);
            $parent_title = __('Browse', 'wpvs-theme');
        } ?>
            <a href="<?php echo $parent_link; ?>"><?php echo $parent_title; ?></a>
        </h3>
    </div>
    <?php if(!empty($children_taxomonies)) { $has_sidebar = true; ?>
        <label id="open-sub-video-cats"><?php echo $filter_text; ?> <span class="dashicons dashicons-arrow-down"></span></label>
        <div id="select-sub-category">
            <?php foreach($children_taxomonies as $child) {
                $term_link = get_term_link($child->term_id);
                if($wp_query->get_queried_object_id() == $child->term_id) {
                    echo '<a class="sub-video-cat active" href="'.$term_link.'">'.$child->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                } else {
                    echo '<a class="sub-video-cat" href="'.$term_link.'">'.$child->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                }

            } ?>
        </div>
    <?php } ?>
</div>
<?php if( ! empty($current_term) ) { ?>
    <div class="row video-cat-description border-box">
        <h2><?php echo $current_term->name; ?></h2>
        <?php echo term_description(); ?>
    </div>
<?php } ?>
<div id="wpvs-theme-slide-loader" class="drop-loading"><label class="net-loader"></label></div>
<div id="video-list-container" class="ease5">
<?php
    if(!empty($children_taxomonies)) {
        global $wpvs_genre_slug_settings;
        global $vs_dropdown_details;
        $videos_per_slide = get_theme_mod('vs_videos_per_slider', '10');
        foreach($children_taxomonies as $child) {
            $title_category_url = '/'.$wpvs_genre_slug_settings['slug'].'/'.$child->slug;
            $title_category_link = home_url($title_category_url);
            $video_list = array();
            $contains_shows = get_term_meta($child->term_id, 'cat_contains_shows', true);
            $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($child->term_id);
            $children_shows = get_terms($wpvs_taxonomy_settings);
            if($contains_shows) {
                if( ! empty($children_shows) ) {
                    foreach($children_shows as $show_child) {
                        $child_has_seasons = get_term_meta($show_child->term_id, 'cat_has_seasons', true);
                        if($child_has_seasons) {
                            $video_list[] = (object) array(
                                'ID' => $show_child->term_id,
                                'type' => 'show',
                            );
                        }
                    }
                }

            } else if( ! empty($children_shows) ) {
                foreach($children_shows as $show_child) {
                    $child_contains_shows = get_term_meta($show_child->term_id, 'cat_contains_shows', true);
                    if($child_contains_shows) {
                        $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($show_child->term_id);
                        $sub_child_shows = get_terms($wpvs_taxonomy_settings);
                        if( ! empty($sub_child_shows) ) {
                            foreach($sub_child_shows as $sub_show_child) {
                                $sub_child_has_seasons = get_term_meta($sub_show_child->term_id, 'cat_has_seasons', true);
                                if($sub_child_has_seasons) {
                                    $video_list[] = (object) array(
                                        'ID' => $sub_show_child->term_id,
                                        'type' => 'show',
                                    );
                                }
                            }
                        }
                    }
                }
            } else {
                $video_args = array(
                    'post_type' => 'rvs_video',
                    'posts_per_page' => $videos_per_slide,
                    'tax_query' => array(
                          array(
                             'taxonomy' => 'rvs_video_category',
                             'field' => 'term_id',
                             'terms' => $child->term_id
                        )
                    )
                );
                $wpvs_theme_video_manager->set_default_video_args($video_args);
                $wpvs_theme_video_manager->apply_video_ordering_filters();
                $video_list = $wpvs_theme_video_manager->get_videos();
            }
            if( ! empty($video_list) ) {
                echo wpvs_theme_create_slider_from_videos($video_list, $child->name, $title_category_link, array());
            }
         }
     } ?>
</div>
