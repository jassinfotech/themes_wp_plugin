<?php get_header();
$current_term = get_term($wp_query->get_queried_object_id(), 'rvs_video_category' );
$video_cat_slideshow = get_term_meta($current_term->term_id, 'video_cat_slideshow', true);
if( ! empty($video_cat_slideshow) ) {
    $featured_slider_shortcode = '[wpvs-featured-area slider="' . $video_cat_slideshow . '"]';
    if(shortcode_exists('wpvs-featured-area') && do_shortcode($featured_slider_shortcode) != false) {
        echo do_shortcode($featured_slider_shortcode);
        echo '<div class="video-page-slideshow-container">';
    }
} else { ?>
    <div class="video-page-container wpvs-category-browsing">
<?php }
    $wpvs_browsing_layout = get_theme_mod('wpvs_browsing_layout', 'grid');
    $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($current_term->term_id);
    $children_taxomonies = get_terms($wpvs_taxonomy_settings);
    $contains_shows = get_term_meta($current_term->term_id, 'cat_contains_shows', true);
    $parent = get_term($current_term->parent, 'rvs_video_category' );
    $cat_has_seasons = false;
    $current_term_has_children = false;
    if($contains_shows) {
        include(locate_template('template/rvs-show-taxonomy.php', false , false));
    } else {
        global $cat_has_seasons;
        $cat_has_seasons = get_term_meta($current_term->term_id, 'cat_has_seasons', true);
        if( empty($children_taxomonies) ) {
            if( ! $cat_has_seasons ) {
                $parent_has_seasons = get_term_meta($current_term->parent, 'cat_has_seasons', true);
                if( ! $parent_has_seasons && empty($current_term->parent) ) {
                    $children_tax_array = array(
                        'taxonomy' => 'rvs_video_category',
                        'parent' => 0
                    );
                } else {
                    $children_tax_array = array(
                        'taxonomy' => 'rvs_video_category',
                        'parent' => $current_term->parent
                    );
                }
                $children_tax_array['meta_key'] = 'video_cat_order';
                $children_tax_array['orderby'] = 'meta_value_num';
                $children_tax_array['order'] = 'ASC';
                $children_taxomonies = get_terms($children_tax_array);
            }
        } else {
            $current_term_has_children = true;
        }
        if ( have_posts() ) {
            if( empty($wpvs_browsing_layout) || $wpvs_browsing_layout == 'grid') {
                include(locate_template('template/rvs-video-taxonomy.php', false , false));
            } else {
                if($current_term_has_children) {
                    include(locate_template('template/browse-sliders.php', false , false));
                } else {
                    include(locate_template('template/rvs-video-taxonomy.php', false , false));
                }
            }
        } else {
            get_template_part('nothing-found');
        }
    } ?>
</div>
<?php get_footer(); ?>
