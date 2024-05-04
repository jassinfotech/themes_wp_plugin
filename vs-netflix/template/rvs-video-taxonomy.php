<?php
global $wp_query;
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
<div id="video-list-container">
    <div class="video-category page-video-category">
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
            <?php if( ! empty($children_taxomonies) ) {
                $has_sidebar = true;
            ?>
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

        <div class="video-list">
            <div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div>
            <div id="video-list-loaded">
                <div id="video-list"></div>
            </div>
        </div>
    </div>
</div>
