<?php get_header(); ?>
<div class="video-page-container">
<?php if ( have_posts() ) :
    $children_taxomonies = get_terms( array(
        'taxonomy' => 'rvs_video_category',
        'parent' => 0,
        'meta_key' => 'video_cat_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'hide_empty' => false
    ));
    $is_rvs_video_archive = true;
?>
<?php
    $wpvs_browsing_layout = get_theme_mod('wpvs_browsing_layout', 'grid');
    if( empty($wpvs_browsing_layout) || $wpvs_browsing_layout == 'grid') {
        include(locate_template('template/rvs-video-taxonomy.php', false , false));
    } else {
        include(locate_template('template/browse-sliders.php', false , false));
    }
?>
<?php else : get_template_part('nothing-found'); endif; ?>
</div>
<?php get_footer(); ?>
