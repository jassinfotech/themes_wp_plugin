<?php
$set_title = single_term_title('', false);
$filter_text = $current_term->name;
$child_contains_shows = false;
$wpvs_term_purchase_price = null;
$wpvs_user_has_purchased = false;
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
            <?php if(!empty($children_taxomonies)) {
                foreach($children_taxomonies as $child) {
                    if(get_term_meta($child->term_id, 'cat_contains_shows', true)) {
                        $child_contains_shows = true;
                        break;
                    }
                } ?>
            <label id="open-sub-video-cats"><?php echo $filter_text; ?> <span class="dashicons dashicons-arrow-down"></span></label>
            <div id="select-sub-category">
            <?php if($child_contains_shows) { ?>
                <?php foreach($children_taxomonies as $child) {
                    $term_link = get_term_link($child->term_id);
                    if($current_term->term_id == $child->term_id) {
                        echo '<a class="sub-video-cat active" href="'.$term_link.'">'.$child->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                    } else {
                        echo '<a class="sub-video-cat" href="'.$term_link.'">'.$child->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                    }
                } ?>
            <?php } else {
                $wpvs_taxonomy_settings = wpvs_theme_set_child_taxonomy_filters($current_term->parent);
                $children_video_cats = get_terms($wpvs_taxonomy_settings);
                foreach($children_video_cats as $video_cat) {
                    $term_link = get_term_link($video_cat->term_id);
                    if($current_term->term_id == $video_cat->term_id) {
                        echo '<a class="sub-video-cat active" href="'.$term_link.'">'.$video_cat->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                    } else {
                        echo '<a class="sub-video-cat" href="'.$term_link.'">'.$video_cat->name.' <span class="dashicons dashicons-arrow-right"></span></a>';
                    }
                } ?>
        <?php } ?>
            </div>
        <?php } ?>
        </div>
        <div class="row video-cat-description border-box">
            <h2><?php echo $current_term->name; ?></h2>
             <?php echo term_description(); ?>
        </div>
        <div class="video-list">
            <div id="loading-video-list" class="drop-loading border-box"><label class="net-loader"></label></div>
            <div id="video-list-loaded">
                <div id="video-list"></div>
            </div>
        </div>
    </div>
</div>
