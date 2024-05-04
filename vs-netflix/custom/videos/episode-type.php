<?php

function wpvs_theme_episode_post_type() {
  global $wpvs_video_slug_settings;
  $labels = array(
    'name'               => _x( 'Episodes', 'post type general name' ),
    'singular_name'      => _x( 'Episode', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'episode' ),
    'add_new_item'       => __( 'Add New Episode' ),
    'edit_item'          => __( 'Edit Episode' ),
    'new_item'           => __( 'New Episode' ),
    'all_items'          => __( 'All Episodes' ),
    'view_item'          => __( 'View Episode' ),
    'search_items'       => __( 'Search Episodes' ),
    'not_found'          => __( 'No episodes found' ),
    'not_found_in_trash' => __( 'No episodes found in the Trash' ),
    'parent_item_colon'  => '',
    'menu_name'          => __( 'TV Shows', 'wpvs-theme' )
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Episode content type for WPVS Themes',
    'public'        => true,
    'menu_position' => 10,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
    'rewrite'       => array( 'slug' => 'series/%wpvs_series%','with_front' => true ),
    'taxonomies'    => array('wpvs_series', 'rvs_actors', 'rvs_directors'),
    'has_archive'   => 'series',
    'menu_icon'     => 'dashicons-video-alt',
    'show_in_rest' => true,
    'rest_base' => 'wpvsepisodes'
  );
  register_post_type( 'wpvs_episode', $args );
}
//add_action( 'init', 'wpvs_theme_episode_post_type' );


function wpvs_theme_create_series_taxonomy() {
  global $wpvs_genre_slug_settings;
  $labels = array(
    'name'              => _x( 'Series', 'taxonomy general name' ),
    'singular_name'     => _x( 'Series', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Series' ),
    'all_items'         => __( 'All Series' ),
    'parent_item'       => __( 'Parent Series' ),
    'parent_item_colon' => __( 'Parent Series:' ),
    'edit_item'         => __( 'Edit Series' ),
    'update_item'       => __( 'Update Series' ),
    'add_new_item'      => __( 'Add New Series' ),
    'new_item_name'     => __( 'New Series' ),
    'parent_item_colon'  => '',
    'menu_name'         => __( 'Series' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'rewrite'            => array( 'slug' => 'series' ),
    'show_in_nav_menus' => true,
    'show_in_rest' => true,
    'rest_base' => 'wpvsseries'
  );
  register_taxonomy( 'wpvs_series', 'wpvs_episode', $args );
}
//add_action( 'init', 'wpvs_theme_create_series_taxonomy', 0 );
