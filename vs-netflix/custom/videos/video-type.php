<?php

function wpvs_theme_video_post_type() {
  global $wpvs_video_slug_settings;
  $labels = array(
    'name'               => _x( 'Videos', 'post type general name' ),
    'singular_name'      => _x( 'Video', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'video' ),
    'add_new_item'       => __( 'Add New Video' ),
    'edit_item'          => __( 'Edit Video' ),
    'new_item'           => __( 'New Video' ),
    'all_items'          => __( 'All Videos' ),
    'view_item'          => __( 'View Video' ),
    'search_items'       => __( 'Search Videos' ),
    'not_found'          => __( 'No videos found' ),
    'not_found_in_trash' => __( 'No videos found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => __( 'Videos', 'wpvs-theme' )
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Video content type for WPVS Themes',
    'public'        => true,
    'menu_position' => 10,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
    'rewrite'       => array( 'slug' => $wpvs_video_slug_settings['slug'].'/%rvs_video_category%','with_front' => true ),
    'taxonomies'    => array('rvs_video_category'),
    'has_archive'   => $wpvs_video_slug_settings['slug'],
    'menu_icon'     => 'dashicons-video-alt2',
    'show_in_rest'  => true,
    'rest_base'     => 'wpvsvideos'
  );
  register_post_type( 'rvs_video', $args );
}
add_action( 'init', 'wpvs_theme_video_post_type' );
