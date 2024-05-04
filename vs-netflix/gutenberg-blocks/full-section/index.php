<?php

function wpvs_theme_gutenberg_register_full_section_block() {

	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	global $wpvs_theme_gutenberg_blocks_dir;
	global $wpvs_theme_current_version;
	wp_register_script(
		'wpvs-theme-full-section-block-js',
		$wpvs_theme_gutenberg_blocks_dir .'/full-section/block.js',
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore' ),
		$wpvs_theme_current_version
	);

	wp_register_style(
		'wpvs-theme-full-section-block-editor-css',
		$wpvs_theme_gutenberg_blocks_dir .'/full-section/editor.css',
		array( 'wp-edit-blocks' ),
		$wpvs_theme_current_version
	);

	wp_register_style(
		'wpvs-theme-full-section-block-css',
		$wpvs_theme_gutenberg_blocks_dir .'/full-section/style.css',
		array(),
		$wpvs_theme_current_version
	);

	register_block_type( 'wpvs-theme-blocks/full-section-block', array(
		'style' => 'wpvs-theme-full-section-block-css',
		'editor_style' => 'wpvs-theme-full-section-block-editor-css',
		'editor_script' => 'wpvs-theme-full-section-block-js',
	) );

  if ( function_exists( 'wp_set_script_translations' ) ) {
    wp_set_script_translations( 'wpvs-theme-full-section-block', 'wpvs-theme-gutenberg-blocks' );
  }

}
add_action( 'init', 'wpvs_theme_gutenberg_register_full_section_block' );
