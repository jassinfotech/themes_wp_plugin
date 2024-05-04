<?php

// DISPLAY TV SHOWS ONLY IN API REQUEST
function wpvs_theme_custom_rest_video_category_queries( $args, $request ) {
    $wpvs_order_sub_categories = null;
    if( isset($request['tvshows']) && $request['tvshows'] ) {
        $args['meta_query'] = array(
            array(
                'key'     => 'cat_has_seasons',
                'value'   => true
            ),
        );
    }

    if( isset($request['parent']) && ! empty($request['parent']) ) {
        $parent_term_id = $request['parent'];
        $args['parent'] = $parent_term_id;
        $wpvs_order_sub_categories = get_term_meta($parent_term_id, 'wpvs_sub_cat_order', true);
    }

    if( isset($request['offset']) && ! empty($request['offset']) ) {
        $args['offset'] = $request['offset'];
    }

    if( ! empty($wpvs_order_sub_categories) ) {
        if( $wpvs_order_sub_categories == 'order' ) {
            $args['meta_key'] = 'video_cat_order';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
        } else {
            $args['orderby'] = $wpvs_order_sub_categories;
        }
    }
    return $args;
}
add_filter( 'rest_rvs_video_category_query', 'wpvs_theme_custom_rest_video_category_queries', 10, 2);

// ORDER VIDEOS IN API REQUEST
function wpvs_theme_custom_rest_video_api_order( $args, $request ) {
    $wpvs_theme_video_manager = new WPVS_Theme_Video_Manager();
    if( isset($request['video_id']) && ! empty($request['video_id']) ) {
        $args['post__not_in'] = array($request['video_id']);
    }
    if( isset($request['exclude_terms']) && ! empty($request['exclude_terms']) ) {
        $exclude_term_ids = explode(',', $request['exclude_terms']);
        if( isset($args['tax_query']) && ! empty($args['tax_query']) ) {
          $args['tax_query'][] = array(
              'taxonomy' => 'rvs_video_category',
              'field' => 'term_id',
              'terms' => $exclude_term_ids,
              'operator' => 'NOT IN',
          );
        } else {
          $args['tax_query'] = array(
              array(
                  'taxonomy' => 'rvs_video_category',
                  'field' => 'term_id',
                  'terms' => $exclude_term_ids,
                  'operator' => 'NOT IN',
              )
          );
        }
    }
    $wpvs_theme_video_manager->set_default_video_args($args);
    $wpvs_theme_video_manager->apply_video_ordering_filters();
    return $wpvs_theme_video_manager->video_args;
}
add_filter( 'rest_rvs_video_query', 'wpvs_theme_custom_rest_video_api_order', 10, 2);
