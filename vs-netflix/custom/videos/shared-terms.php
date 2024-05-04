<?php

function wpvs_theme_video_categories() {
  global $wpvs_genre_slug_settings;
  $labels = array(
    'name'              => _x( $wpvs_genre_slug_settings['name-plural'], 'taxonomy general name' ),
    'singular_name'     => _x( $wpvs_genre_slug_settings['name'], 'taxonomy singular name' ),
    'search_items'      => __( 'Search '.$wpvs_genre_slug_settings['name-plural'] ),
    'all_items'         => __( 'All '.$wpvs_genre_slug_settings['name-plural'] ),
    'parent_item'       => __( 'Parent '.$wpvs_genre_slug_settings['name'] ),
    'parent_item_colon' => __( 'Parent '.$wpvs_genre_slug_settings['name'].':' ),
    'edit_item'         => __( 'Edit '.$wpvs_genre_slug_settings['name'] ),
    'update_item'       => __( 'Update '.$wpvs_genre_slug_settings['name'] ),
    'add_new_item'      => __( 'Add New '.$wpvs_genre_slug_settings['name'] ),
    'new_item_name'     => __( 'New '.$wpvs_genre_slug_settings['name'] ),
    'parent_item_colon'  => '',
    'menu_name'         => __( $wpvs_genre_slug_settings['name-plural'] ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'rewrite'            => array( 'slug' => $wpvs_genre_slug_settings['slug'] ),
    'show_in_nav_menus' => true,
    'show_in_rest' => true,
    'rest_base' => 'wpvsgenres',
    'show_in_quick_edit' => true,
  );
  register_taxonomy( 'rvs_video_category', 'rvs_video', $args );
}
add_action( 'init', 'wpvs_theme_video_categories', 0 );

// ACTORS
function wpvs_theme_video_actors() {
  global $wpvs_actor_slug_settings;
  $labels = array(
    'name'              => _x( $wpvs_actor_slug_settings['name-plural'], 'taxonomy general name' ),
    'singular_name'     => _x( $wpvs_actor_slug_settings['name'], 'taxonomy singular name' ),
    'search_items'      => __( 'Search '.$wpvs_actor_slug_settings['name-plural'] ),
    'all_items'         => __( 'All '.$wpvs_actor_slug_settings['name-plural'] ),
    'parent_item'       => __( 'Parent '.$wpvs_actor_slug_settings['name'] ),
    'parent_item_colon' => __( 'Parent '.$wpvs_actor_slug_settings['name'].':' ),
    'edit_item'         => __( 'Edit '.$wpvs_actor_slug_settings['name'] ),
    'update_item'       => __( 'Update '.$wpvs_actor_slug_settings['name'] ),
    'add_new_item'      => __( 'Add New '.$wpvs_actor_slug_settings['name'] ),
    'new_item_name'     => __( 'New '.$wpvs_actor_slug_settings['name'] ),
    'parent_item_colon'  => '',
    'menu_name'         => __( $wpvs_actor_slug_settings['name-plural'] ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => false,
    'rewrite'            => array( 'slug' => $wpvs_actor_slug_settings['slug'] ),
    'show_in_nav_menus' => true,
    'show_in_rest' => true,
    'rest_base' => 'wpvsactors',
    'show_in_quick_edit' => true,
  );
  register_taxonomy( 'rvs_actors', 'rvs_video', $args );
}
add_action( 'init', 'wpvs_theme_video_actors', 0 );

// ACTORS
function wpvs_theme_video_directors() {
  global $wpvs_director_slug_settings;
  $labels = array(
    'name'              => _x( $wpvs_director_slug_settings['name-plural'], 'taxonomy general name' ),
    'singular_name'     => _x( $wpvs_director_slug_settings['name'], 'taxonomy singular name' ),
    'search_items'      => __( 'Search '.$wpvs_director_slug_settings['name-plural'] ),
    'all_items'         => __( 'All '.$wpvs_director_slug_settings['name-plural'] ),
    'parent_item'       => __( 'Parent '.$wpvs_director_slug_settings['name'] ),
    'parent_item_colon' => __( 'Parent '.$wpvs_director_slug_settings['name'].':' ),
    'edit_item'         => __( 'Edit '.$wpvs_director_slug_settings['name'] ),
    'update_item'       => __( 'Update '.$wpvs_director_slug_settings['name'] ),
    'add_new_item'      => __( 'Add New '.$wpvs_director_slug_settings['name'] ),
    'new_item_name'     => __( 'New '.$wpvs_director_slug_settings['name'] ),
    'parent_item_colon'  => '',
    'menu_name'         => __( $wpvs_director_slug_settings['name-plural'] ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => false,
    'rewrite'            => array( 'slug' => $wpvs_director_slug_settings['slug'] ),
    'show_in_nav_menus' => true,
    'show_in_rest' => true,
    'rest_base' => 'wpvsdirectors',
    'show_in_quick_edit' => true,
  );
  register_taxonomy( 'rvs_directors', 'rvs_video', $args );
}
add_action( 'init', 'wpvs_theme_video_directors', 0 );


// Custom Video Post Tags
function wpvs_theme_taxonomy_video_tags() {
  $labels = array(
    'name'              => _x( 'Video Tags', 'taxonomy general name' ),
    'singular_name'     => _x( 'Video Tags', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Video Tags' ),
    'all_items'         => __( 'All Video Tags' ),
    'edit_item'         => __( 'Edit Video Tag' ),
    'update_item'       => __( 'Update Video Tag' ),
    'add_new_item'      => __( 'Add New Video Tag' ),
    'new_item_name'     => __( 'New Video Tag' ),
    'parent_item_colon'  => '',
    'menu_name'         => __( 'Video Tags' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => false,
    'rewrite'            => array( 'slug' => 'video-tag' ),
    'show_in_rest' => true,
    'rest_base' => 'wpvsvideotags',
    'show_in_quick_edit' => true,
  );
  register_taxonomy( 'rvs_video_tags', 'rvs_video', $args );
}
add_action( 'init', 'wpvs_theme_taxonomy_video_tags', 0 );
