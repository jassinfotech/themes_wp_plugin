<?php get_header(); ?>
<div class="video-page-container">
<?php if ( have_posts() ) :
    $children_taxomonies = get_terms( array('taxonomy' => 'rvs_video_tags', 'parent' => $wp_query->get_queried_object_id()) );
    $current_term = get_term($wp_query->get_queried_object_id(), 'rvs_video_tags' );
    $parent = get_term($current_term->parent, 'rvs_video_tags' );
?>
<?php include(locate_template('template/rvs-video-taxonomy.php', false , false)); ?>
<?php else : get_template_part('nothing-found'); endif; ?>
</div>
<?php get_footer(); ?>
