<?php

function wpvs_theme_gutenberg_register_video_category_block() {

	if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}
	global $wpvs_theme_gutenberg_blocks_dir;
	global $wpvs_theme_current_version;
	global $wpvs_theme_thumbnail_sizing;

	wp_register_script(
		'wpvs-theme-video-category-slider-block-js',
		$wpvs_theme_gutenberg_blocks_dir .'/category-slider/block.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore' ),
		$wpvs_theme_current_version
	);

    wp_localize_script( 'wpvs-theme-video-category-slider-block-js', 'wpvsthemeblocks',
        array(
			'video_term_options' => wpvs_theme_generate_video_category_select_options(),
			'image_sizing' => json_encode($wpvs_theme_thumbnail_sizing)
		)
	);

	wp_register_style(
		'wpvs-theme-video-category-slider-block-editor-css',
		$wpvs_theme_gutenberg_blocks_dir .'/category-slider/editor.css',
		array( 'wp-edit-blocks' ),
		$wpvs_theme_current_version
	);

	wp_register_style(
		'wpvs-theme-video-category-slider-block-css',
		$wpvs_theme_gutenberg_blocks_dir .'/category-slider/style.css',
		array(),
		$wpvs_theme_current_version
	);

	register_block_type( 'wpvs-theme-blocks/video-category-slider-block', array(
		'style' => 'wpvs-theme-video-category-slider-block-css',
		'editor_style' => 'wpvs-theme-video-category-slider-block-editor-css',
		'editor_script' => 'wpvs-theme-video-category-slider-block-js',
        'attributes'      => array(
            'term_id'    => array(
                'type'      => 'number',
                'default'   => 0,
            ),
            'style' => array(
                'type'      => 'string',
                'default'   => '',
            ),
			'image_size' => array(
                'type'      => 'string',
                'default'   => '',
            ),
        ),
        'render_callback' => 'wpvs_theme_generate_category_shortcode_for_block'
	) );

  if ( function_exists( 'wp_set_script_translations' ) ) {
      wp_set_script_translations( 'wpvs-theme-video-category-slider-block', 'wpvs-theme-gutenberg-blocks' );
  }

}
add_action( 'init', 'wpvs_theme_gutenberg_register_video_category_block' );

function wpvs_theme_generate_category_shortcode_for_block( $attributes ) {
    if( isset($attributes['term_id']) && ! empty($attributes['term_id'])) {
        $wpvs_slider_shortcode = '[netflix-category cat="'.$attributes['term_id'].'"';
        if( isset($attributes['style']) && ! empty($attributes['style']) ) {
            $wpvs_slider_shortcode .= ' style="'.$attributes['style'].'"';
        }
		if( isset($attributes['image_size']) && ! empty($attributes['image_size']) ) {
            $wpvs_slider_shortcode .= ' image_size="'.$attributes['image_size'].'"';
        }
        $wpvs_slider_shortcode .= ']';
        return do_shortcode($wpvs_slider_shortcode);
    } else {
        return '<div class="col-12">'.__('Please select a video category from the right side menu.', 'wpvs-theme').'</div>';
    }
}

function wpvs_theme_generate_video_category_select_options() {
    $wpvs_video_categories = get_terms(array('taxonomy' => 'rvs_video_category'));
    $video_category_options = array(
        array(
            'name' => __('Select a video category', 'wpvs-theme'),
            'value' => 0
        ),
    );
    if( ! empty($wpvs_video_categories) ) {
        foreach($wpvs_video_categories as $video_category) {
            $add_term_option = array(
                'name' => $video_category->name,
                'value' => $video_category->term_id
            );
            $video_category_options[] = $add_term_option;
        }
    }
    return json_encode($video_category_options);
}
