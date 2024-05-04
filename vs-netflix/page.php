<?php
get_header();
global $post;
wpvs_do_featured_slider($post->ID);
$wpvs_theme_remove_top_spacing = get_post_meta($post->ID, '_vs_top_spacing', true);
$wpvs_theme_add_page_top_spacing = false;
$wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
$wpvs_page_show_featured_image = get_post_meta( $post->ID, 'wpvs_page_show_featured_image', true );
$wpvs_page_show_title = get_post_meta( $post->ID, 'wpvs_page_show_title', true );
if( (empty($wpvs_page_featured_area_type) || $wpvs_page_featured_area_type == "none" ) && ! $wpvs_theme_remove_top_spacing ) {
    $wpvs_theme_add_page_top_spacing = true;
}
if($wpvs_theme_add_page_top_spacing) { ?>
    <div class="page-container">
<?php } if ( have_posts() ) { ?>
    <section id="main" role="main">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php if( has_post_thumbnail() && $wpvs_page_show_featured_image) { ?>
                <div class="page-thumbnail"><?php echo the_post_thumbnail('full'); ?></div>
            <?php } if( $wpvs_page_show_title ) { ?>
                <div class="container row">
                    <div class="col-12">
                        <?php the_title('<h1>','</h1>'); ?>
                    </div>
                </div>
            <?php }
            the_content();
        endwhile; ?>
    </section>
    <?php if( comments_open() ) { ?>
        <div class="container row">
            <div class="col-12">
                <?php comments_template(); ?>
            </div>
        </div>
    <?php } ?>
<?php } else {
    get_template_part('nothing-found');
}
if($wpvs_theme_add_page_top_spacing) { ?>
</div>
<?php } get_footer(); ?>
