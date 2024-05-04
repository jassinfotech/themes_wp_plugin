<?php /* Template Name: Page Builder (Blank) */
get_header();
global $post;
wpvs_do_featured_slider($post->ID);
$wpvs_theme_remove_top_spacing = get_post_meta($post->ID, '_vs_top_spacing', true);
$wpvs_theme_add_page_top_spacing = false;
$wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
if( (empty($wpvs_page_featured_area_type) || $wpvs_page_featured_area_type == "none" ) && ! $wpvs_theme_remove_top_spacing ) {
    $wpvs_theme_add_page_top_spacing = true;
}
if($wpvs_theme_add_page_top_spacing) { ?>
    <div class="page-container"></div>
<?php } if ( have_posts() ) {
    while ( have_posts() ) : the_post();
    the_content();
    endwhile;
} else {
    get_template_part('nothing-found');
}
get_footer(); ?>
