<?php

function wpvs_theme_update_depcrecated_page_templates() {
    $wpvs_page_args = array(
        'post_type' => 'page',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_wp_page_template',
                'value' => 'default'
            ),
            array(
                'key' => '_wp_page_template',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    $wpvs_template_pages = get_posts($wpvs_page_args);
    if( ! empty($wpvs_template_pages) ) {
        foreach($wpvs_template_pages as $page_id) {
            update_post_meta($page_id, '_wp_page_template', 'page_sidebar.php');
        }
    }
}
add_action('init', 'wpvs_theme_update_depcrecated_page_templates');
