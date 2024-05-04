<?php
add_action( 'admin_menu', 'dynamic_slider_menu' );
function dynamic_slider_menu() {
	add_menu_page( 'Featured Area', 'Featured Area', 'manage_options', 'wpvs-dynamic-sliders', 'wpvs_dynamic_sliders', 'dashicons-align-center' );
}

function wpvs_slider_admin_scripts() {
    global $wpvs_theme_current_version;
    $wpvs_theme_directory = get_template_directory_uri();
    $current_admin_screen = get_current_screen();
    wp_register_style( 'wpvs-featured-area-editor-css', $wpvs_theme_directory . '/css/admin/slide-editor.css', '',  $wpvs_theme_current_version);
    wp_register_script( 'wpvs-featured-area-blocks-js', $wpvs_theme_directory . '/js/admin/homeblocks.js', array('jquery', 'jquery-ui-sortable'), $wpvs_theme_current_version, true);
    wp_register_script( 'wpvs-block-image-uploader', $wpvs_theme_directory . '/js/admin/slideloader.js', array('jquery'), $wpvs_theme_current_version, true);

    if ( $current_admin_screen && isset($current_admin_screen->base) && $current_admin_screen->base == 'toplevel_page_wpvs-dynamic-sliders' ) {
        wp_enqueue_style( 'wpvs-featured-area-editor-css' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'wpvs-featured-area-blocks-js');
        wp_enqueue_script( 'wpvs-block-image-uploader');
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'wpvs_slider_admin_scripts' );

function wpvs_dynamic_sliders() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'wpvs-theme' ) );
	}

    $wpvs_sliders = get_option('wpvs_slider_array');
    $wpvs_block_section = get_option('wpvs_block_section');

	if( empty($wpvs_block_section) || $wpvs_block_section < 1 ) {
		update_option('wpvs_block_section', 1);
		update_option('wpvs_slider_array', array());
        $wpvs_block_section = 1;
	}

    $all_pages = get_pages();
    $categories = get_categories();
    $posts = get_posts();

    $video_categories = get_terms(array(
		'taxonomy' => 'rvs_video_category',
		'hide_empty' => false,
		'parent' => 0)
	);
	?><div class="wrap">

		<h2><?php _e('Featured Area Sliders', 'wpvs-theme'); ?></h2>
		<form method="post" action="">
			<?php if( ! empty($wpvs_sliders) ) {
				foreach($wpvs_sliders as $slider) {
                    if( isset($slider['max_height']) && ! empty($slider['max_height'])) {
                        $slide_max_height = $slider['max_height'];
                    } else {
                        $slide_max_height = "";
                    }
                ?>
                    <div class="rogueDynamicSlider rvs-border-box" id="section_<?php echo $slider['id']; ?>" >

						<input type="text" class="sectionNumber" value="<?php echo $slider['id']; ?>" hidden />
						<input type="text" class="sectionCount" value="<?php echo $slider['count']; ?>" hidden/>

						<div class="sliderControls">
							<input type="text" class="sliderTitle" value="<?php echo $slider['name']; ?>" />
							<label class="btn saveSlideButton saveTitle"><?php _e('Save Title', 'wpvs-theme'); ?></label>

							<button class="btn deleteSection"><?php _e('Delete Slider', 'wpvs-theme'); ?></button>

							<button class="btn addNewBlock"><?php _e('New Slide', 'wpvs-theme'); ?></button>
                            <input type="text" class="wpvs-slider-shortcode" readonly value="<?php echo htmlentities('[wpvs-featured-area slider="'.$slider['id'].'" inline=1]'); ?>" onClick="this.select();"/>
						</div>

                        <div class="wpvs-slider-settings rvs-border-box">
                            <div class="wpvs-slider-setting-block">
                            <label>Max Height: <input type="text" class="slider-max-height" value="<?php echo $slide_max_height; ?>" placeholder="850px"/> (<em>Leave empty for no max height</em>)</label>
                            </div>
                            <label class="btn save-slider-settings"><?php _e('Save Settings', 'wpvs-theme'); ?></label>
                        </div>

						<div class="slideContainer wpvs-featured-area-sort">

						<?php if( isset($slider['blocks']) && ! empty($slider['blocks'])) {
                            foreach ($slider['blocks'] as $block) {
                                $slide_video_html = "";
                                if( isset($block['video']) && ! empty($block['video']) && get_post($block['video']) ) {
                                    $block_set_video = $block['video'];
                                } else {
                                    $block_set_video = "";
                                }

                                if( isset($block['backgroundtype']) && ! empty($block['backgroundtype']) ) {
                                    $background_type = $block['backgroundtype'];
                                } else {
                                    $background_type = 'image';
                                }

                                if( isset($block['videourl']) && ! empty($block['videourl']) ) {
                                    $block_video_url = $block['videourl'];
                                } else {
                                    $block_video_url = "";
                                }

                                if( isset($block['youtubeurl']) && ! empty($block['youtubeurl']) ) {
                                    $block_youtube_url = $block['youtubeurl'];
                                } else {
                                    $block_youtube_url = "";
                                }

                                if( isset($block['youtubeid']) && ! empty($block['youtubeid']) ) {
                                    $block_youtube_id = $block['youtubeid'];
                                } else {
                                    $block_youtube_id = "";
                                }

                                if( isset($block['vimeourl']) && ! empty($block['vimeourl']) ) {
                                    $block_vimeo_url = $block['vimeourl'];
                                } else {
                                    $block_vimeo_url = "";
                                }

                                if( isset($block['vimeoid']) && ! empty($block['vimeoid']) ) {
                                    $block_vimeo_id = $block['vimeoid'];
                                } else {
                                    $block_vimeo_id = "";
                                }

                                if( isset($block['muted']) ) {
                                    $block_video_muted = $block['muted'];
                                } else {
                                    $block_video_muted = 1;
                                }

                                if( isset($block['custom_iframe']) && ! empty($block['custom_iframe']) ) {
                                    $block_custom_iframe_code = stripslashes($block['custom_iframe']);
                                } else {
                                    $block_custom_iframe_code = "";
                                }

                                if($background_type == 'video' && ! empty($block_video_url) ) {
                                    $slide_video_html = '<video width="410px" height="220px" preload="metadata" autoplay="on" muted><source type="video/mp4" src="'.$block_video_url.'"></video>';
                                }

                                if($background_type == 'youtube' && ! empty($block_youtube_id) ) {
                                    $youtube_video_link = '//www.youtube.com/embed/' . $block_youtube_id . '?controls=0&showinfo=0&rel=0&enablejsapi=1&playlist='.$block_youtube_id;
                                    $slide_video_html = '<iframe src="' . $youtube_video_link . '" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" volume="0"></iframe>';
                                }

                                if($background_type == 'vimeo' && ! empty($block_vimeo_id) ) {
                                    $vimeo_video_link = 'https://player.vimeo.com/video/' . $block_vimeo_id . '?background=1';
                                    $slide_video_html = '<iframe src="' . $vimeo_video_link . '" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" volume="0"></iframe>';
                                }

                                if($background_type == 'custom' && ! empty($block_custom_iframe_code) ) {
                                    $slide_video_html = $block_custom_iframe_code;
                                }

                                if($background_type == 'video' && empty($slide_video_html) ) {
                                    $slide_video_html = '<div class="wpvs-no-slide-video">No Video Set</div>';
                                }

                                if( isset($block['image']) && ! empty($block['image'])) {
                                    $block_image_url = $block['image'];
                                } else {
                                    $block_image_url = "";
                                }

                                if( isset($block['title']) && ! empty($block['title'])) {
                                    $block_title = $block['title'];
                                } else {
                                    $block_title = "";
                                }

                                if( ! isset($block['id']) ) {
                                    $block['id'] = 0;
                                }

                                if( isset($block['video_aspect_ratio']) && ! empty($block['video_aspect_ratio'])) {
                                    $slide_aspect_ratio = $block['video_aspect_ratio'];
                                } else {
                                    $slide_aspect_ratio = '';
                                }

                            ?>
                            <div class="homeBlockEdit" id="<?php echo $block['id']; ?>">
					            <div class="saving-slider-block">
                                    <?php _e('Saving', 'wpvs-theme'); ?>...
                                </div>

                                <div class="wpvs-video-contain <?=($background_type == 'video' || $background_type == 'youtube' || $background_type == 'vimeo' || $background_type == 'custom') ? 'active' : '' ?>"><?php echo $slide_video_html; ?></div>

								<div class="imageContain <?=($background_type == 'image') ? 'active' : '' ?>">
									<img class="changeImage" src="<?php echo $block['image']; ?>" alt="<?php echo $block_title; ?>">
								</div>
                                <div class="wpvs-edit-slide-detail">
                                    <input class="upload-url" type="text" value="<?php echo $block_image_url; ?>" hidden />
                                    <label class="upload_button btn wpvs-media-button wpvs-blue-button"><span class="dashicons dashicons-format-image"></span> <?php _e('Set Image', 'wpvs-theme'); ?></label>
                                    <label class="wpvs-set-video btn wpvs-media-button wpvs-green-button"><span class="dashicons dashicons-video-alt3"></span> <?php _e('Set Video', 'wpvs-theme'); ?></label>
                                </div>
                                <input type="hidden" class="wpvs-slide-background-type" value="<?php echo $background_type; ?>" hidden/>
                                <div class="wpvs-select-background-video">

                                    <div class="wpvs-edit-slide-detail">
                                        <label><?php _e('YouTube URL', 'wpvs-theme'); ?>:</label>
                                        <input class="inputPush set-slide-trailer-youtube" type="url" value="<?php echo $block_youtube_url; ?>" placeholder="Paste YouTube video URL"/>
                                        <input type="hidden" value="<?php echo $block_youtube_id; ?>" class="set-slide-youtube-id" hidden />
                                    </div>

                                    <div class="wpvs-edit-slide-detail">
                                        <label><?php _e('Vimeo URL', 'wpvs-theme'); ?>:</label>
                                        <input class="inputPush set-slide-trailer-vimeo" type="url" value="<?php echo $block_vimeo_url; ?>" placeholder="Paste Vimeo video URL"/><br>
                                        <input type="hidden" value="<?php echo $block_vimeo_id; ?>" class="set-slide-vimeo-id" hidden />
                                    </div>

                                    <div class="wpvs-edit-slide-detail">
                                        <label><?php _e('HTML iFrame', 'wpvs-theme'); ?>:</label>
                                        <textarea class="inputPush set-slide-custom-iframe" placeholder="<iframe src='{your-streaming-source-here}' allowfullscreen></iframe>"><?php echo $block_custom_iframe_code; ?></textarea>
                                    </div>

                                    <div class="wpvs-edit-slide-detail">
                                        <label><?php _e('Upload', 'wpvs-theme'); ?>:</label>
                                        <input type="button" class="button button-primary set-slide-wordpress-video" value="<?php _e('Choose Video', 'wpvs-theme'); ?>" />
                                        <input type="hidden" class="slide-video-url" value="<?php echo $block_video_url; ?>" hidden/>
                                    </div>
                                    <div class="wpvs-edit-slide-detail">
                                        <label><?php _e('Mute Video', 'wpvs-theme'); ?>:</label>
                                        <input type="checkbox" class="set-slide-muted-video" value="1" <?php checked(1, $block_video_muted); ?> />
                                    </div>
                                    <div class="wpvs-edit-slide-detail">
                                        <label><?php _e('Aspect Ratio', 'wpvs-theme'); ?>:</label>
                                        <select class="set-video-aspect-ratio" name="video-aspect-ratio" >
                                           <option value="" <?php selected('', $slide_aspect_ratio); ?>><?php _e('16:9 (Default)', 'wpvs-theme'); ?></option>
                                           <option value="cinematic" <?php selected('cinematic', $slide_aspect_ratio); ?>><?php _e('2.39:1 (Cinematic)', 'wpvs-theme'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Videos', 'wpvs-theme'); ?>:</label>
                                    <input class="inputPush wpvs-search-slide-video" type="text" name="wpvs-search-slide-video" value="" placeholder="Search for a video..." autocomplete="off"/>
                                    <div class="wpvs-found-video-list"></div>
                                </div>
                                <?php if( ! empty($video_categories) ) { ?>
                                <div class="wpvs-edit-slide-detail">
									<select class="selectPage video-category-dropdown" name="video-category-dropdown" >
									   <option value="/"><?php _e('Video Categories', 'wpvs-theme'); ?></option>
                                        <?php foreach ( $video_categories as $video_category ) {
                                            $child_categories = get_term_children($video_category->term_id, 'rvs_video_category');
                                            $option = '<optgroup label="'.$video_category->name.'">';
                                            $option .= '<option value="' . wp_make_link_relative(get_term_link( $video_category->term_id )) . '">All '.$video_category->name.'</option>';
                                            if( ! empty($child_categories) ) {
                                                foreach($child_categories as $child_cat_id) {
                                                    $cat_option = get_term($child_cat_id, 'rvs_video_category');
                                                    $cat_option_parent = get_term($cat_option->parent, 'rvs_video_category');
                                                    if($cat_option->parent && $cat_option->parent != $video_category->term_id) {
                                                        $option .= '<option value="' . wp_make_link_relative(get_term_link( $cat_option->term_id )) . '">'.$cat_option_parent->name.': '.$cat_option->name.'</option>';
                                                    } else {
                                                        $option .= '<option value="' . wp_make_link_relative(get_term_link( $cat_option->term_id )) . '">'.$cat_option->name.'</option>';
                                                    }
                                                }
                                            }
                                            $option .= '</optgroup>';
                                            echo $option;
                                        } ?>
                                    </select>
                                </div>
                                <?php } if( ! empty($all_pages) ) { ?>
                                <div class="wpvs-edit-slide-detail">
									<select class="selectPage page-dropdown" name="page-dropdown">
                                        <option value="/"><?php _e('Pages', 'wpvs-theme'); ?></option>
									<?php foreach ( $all_pages as $page ) {
                                            $option = '<option value="' . wp_make_link_relative(get_page_link($page->ID)) . '">';
                                            $option .= $page->post_title;
                                            $option .= '</option>';
                                            echo $option;
                                        } ?>
                                    </select>
                                </div>
                                <?php } if( ! empty($categories) ) { ?>
									<div class="wpvs-edit-slide-detail">
                                        <select class="selectPage blog-dropdown" name="blog-dropdown" >
                                           <option value="/"><?php _e('Categories', 'wpvs-theme'); ?></option>
                                           <?php foreach ( $categories as $category ) {
                                                $option = '<option value="/' . $category->slug . '">';
                                                $option .= $category->name;
                                                $option .= '</option>';
                                                echo $option;
                                            } ?>
                                        </select>
                                    </div>
                                <?php } if( ! empty($posts) ) { ?>
                                <div class="wpvs-edit-slide-detail">
									<select class="selectPage post-dropdown" name="post-dropdown" >
									   <option value="/"><?php _e('Posts', 'wpvs-theme'); ?></option>
									   <?php foreach ( $posts as $post ) {
                                            $option = '<option value="' . wp_make_link_relative(get_permalink( $post->ID )) . '">';
                                            $option .= $post->post_title;
                                            $option .= '</option>';
                                            echo $option;
                                        } ?>
                                    </select>
                                </div>
                                <?php } ?>

                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Image Alt', 'wpvs-theme'); ?>:</label>
                                    <input class="imageAlt inputPush" type="text" name="<?php echo $block['image_alt']; ?>" value="<?php echo $block['image_alt']; ?>" placeholder="image alt text"/>
                                </div>
                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Heading', 'wpvs-theme'); ?>:</label>
                                    <input class="homeTitle inputPush" type="text" name="<?php echo $block_title; ?>" value="<?php echo $block_title; ?>" placeholder="Heading text"/>
                                </div>
                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Description', 'wpvs-theme'); ?>:</label>
                                    <textarea class="slideDescription" placeholder="A short description..."><?php echo stripslashes($block['description']); ?></textarea>
                                </div>
                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Button Text', 'wpvs-theme'); ?>:</label>
                                    <input class="slideLinkText inputPush" type="text" name="<?php echo $block['link_text']; ?>" value="<?php echo $block['link_text']; ?>" placeholder="Watch Now"/>
                                </div>
                                <?php
                                    if( ! isset($block['button_size']) ) {
                                        $block['button_size'] = 'default';
                                    }
                                ?>
                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Button Size', 'wpvs-theme'); ?>:</label>
									<select class="wpvs-slide-button-size post-dropdown" name="wpvs-slide-button-size">
								        <option value="default" <?php selected('default', $block['button_size']); ?>><?php _e('Normal', 'wpvs-theme'); ?></option>
								        <option value="large" <?php selected('large', $block['button_size']); ?>><?php _e('Large', 'wpvs-theme'); ?></option>
                                    </select>
                                </div>

                                <div class="wpvs-edit-slide-detail">
								    <label><?php _e('Links To', 'wpvs-theme'); ?>:</label>
								    <input type="text" class="link inputPush" name="<?php echo $block['id'] . '_link'; ?>" value="<?php echo $block['link']; ?>"/>
                                </div>
                                <?php
                                    if( ! isset($block['align']) ) {
                                        $block['align'] = 'left';
                                    }
                                ?>
                                <div class="wpvs-edit-slide-detail">
                                    <label><?php _e('Align Content', 'wpvs-theme'); ?>:</label>
									<select class="select-alignment post-dropdown" name="align-content">
								        <option value="left" <?php selected('left', $block['align']); ?>><?php _e('Left', 'wpvs-theme'); ?></option>
								        <option value="center" <?php selected('center', $block['align']); ?>><?php _e('Center', 'wpvs-theme'); ?></option>
                                        <option value="right" <?php selected('right', $block['align']); ?>><?php _e('Right', 'wpvs-theme'); ?></option>
                                    </select>
                                </div>
                                <div class="openLink">
									<label><?php _e('Link entire slide', 'wpvs-theme'); ?></label>
									<?php
                                        if( isset($block['whole']) && ! empty($block['whole']) ) {
                                            $block['whole'] = 1;
                                        } else {
                                            $block['whole'] = 0;
                                        }
                                    ?>
                                    <input type="checkbox" class="wholeslide" name="<?php echo $block['id'] . '_whole'; ?>" <?php checked(1, $block['whole']); ?>/>
                                </div>

								<div class="openLink">
									<label><?php _e('Open in new tab', 'wpvs-theme'); ?></label>
									<?php
                                        if( ! isset($block['tab']) ) {
                                            $block['tab'] = 0;
                                        }
									?>
								    <input type="checkbox" class="newTab" name="<?php echo $block['id'] . '_tab'; ?>" <?php checked(1, $block['tab']); ?> />
                                </div>
                                <div class="wpvs-edit-slide-detail wpvs-slide-edit-buttons">
                                    <input class="btn button-delete wpvs-slide-edit-button" type="button" value="Delete" />
                                    <input class="btn button-save wpvs-slide-edit-button" type="button" value="Save" />
                                    <input class="btn wpvs-button-hide wpvs-slide-edit-button" type="button" value="Hide" />
                                </div>
								<label class="rogue-edit-slider"><span class="dashicons dashicons-edit"></span> <?php _e('Edit', 'wpvs-theme'); ?></label>
                                <input type="hidden" class="wpvs-set-video-id" value="<?php echo $block_set_video; ?>" hidden />
								</div>

						<?php } } else { ?>
                            <label id="wpvs-add-new-slide"><span class="dashicons dashicons-plus"></span> Add Slide</label>
                        <?php } ?>
                        </div>
					</div> <!-- END SLIDER SECTION -->
					<hr>
				<?php } } ?><button id="addNewSection" class="btn newSection"><?php _e('Add New Slider', 'wpvs-theme'); ?></button>
					<input type="text" name="newBlockSection" id="newBlockSection" value="<?php echo esc_attr( $wpvs_block_section ); ?>" hidden/>
			</form>
	</div>

<?php }

add_action( 'wp_ajax_newblocksection_ajax_request', 'newblocksection_ajax_request' );

function newblocksection_ajax_request() {
    if(current_user_can('manage_options')) {
        if ( isset($_REQUEST['sectionId']) && ! empty($_REQUEST['sectionId']) ) {

            $newSection = $_REQUEST['sectionId'];

            $newSlider = array(
                'id' => $newSection,
                'name' => 'Edit Slider Title',
                'count'=> 0,
                'blocks' => array()
            );

            $slides =  'wpvs_slider_array';
            $blocks =  'wpvs_block_section';

            $sliderArray = get_option($slides);

            array_push($sliderArray, $newSlider);

            update_option($slides, $sliderArray);

            $sectionNumber = get_option($blocks);

            update_option($blocks, $sectionNumber + 1 );
        }
    }
    wp_die();
}

add_action( 'wp_ajax_deleteblocksection_ajax_request', 'deleteblocksection_ajax_request' );

function deleteblocksection_ajax_request() {
    if(current_user_can('manage_options')) {
        if ( isset($_REQUEST['sectionId']) && ! empty($_REQUEST['sectionId']) ) {

            $newSection = $_REQUEST['sectionId'];

            $slides =  'wpvs_slider_array';

            $sliderArray = get_option($slides);

            $sliderArray = array_values($sliderArray);

            foreach($sliderArray as $key => &$slide) {
                if($slide['id'] == $newSection) {
                    unset($sliderArray[$key]);
                    break;
                }
            }

            update_option($slides, $sliderArray);

        }
    }
    wp_die();
}

add_action( 'wp_ajax_block_ajax_request', 'block_ajax_request' );

function block_ajax_request() {

	if ( isset($_REQUEST) ) {

        $homeBlockId = $_REQUEST['homeBlockId'];
		$newSection = $_REQUEST['sectionId'];

        $slider_blocks = get_option('wpvs_slider_array');

		$new_slide = array(
            'id' => $homeBlockId,
            'image' => get_template_directory_uri( __FILE__ ) . '/images/no-image.jpg' ,
            'image_alt' => '',
            'title' => '',
            'description' => '',
            'link_text' => '',
            'link' => '',
            'button_size' => 'default',
            'align' => 'left',
            'tab' => 0,
            'whole' => 0
        );

		foreach($slider_blocks as &$slide) {
			if($slide['id'] == $newSection) {
				array_push($slide['blocks'], $new_slide);
				$slide['blocks'] = array_values($slide['blocks']);
				$count = $slide['count'];
				$slide['count'] = $count + 1;
				break;
			}
		}

		update_option('wpvs_slider_array', $slider_blocks);
    }

    wp_die();

}

add_action( 'wp_ajax_deleteblock_ajax_request', 'deleteblock_ajax_request' );

function deleteblock_ajax_request() {
	if ( isset($_REQUEST) ) {
        $homeBlockId = $_REQUEST['homeBlockId'];
		$newSection = $_REQUEST['sectionId'];

		$sliderArray = get_option('wpvs_slider_array');

		foreach($sliderArray as &$slide) {
			if($slide['id'] == $newSection) {
				$slide['blocks'] = array_values($slide['blocks']);
				foreach($slide['blocks'] as $key => &$block) {
                    if( ! isset($block['id']) ) {
                        $block['id'] = 0;
                    }
					if($block['id'] == $homeBlockId) {
						unset($slide['blocks'][$key]);
						break;
					}
				}
			}
		}
		update_option('wpvs_slider_array', $sliderArray);
		return false;
    }
    wp_die();
}

add_action( 'wp_ajax_saveblock_ajax_request', 'saveblock_ajax_request' );

function saveblock_ajax_request() {

	if ( isset($_REQUEST) ) {

        $homeBlockId = $_REQUEST['homeBlockId'];
        if( empty($homeBlockId) ) {
            $homeBlockId = 0;
        }
		$homeBlockImage = $_REQUEST['homeBlockImage'];
        $homeBlockImageAlt = sanitize_text_field($_REQUEST['homeBlockImageAlt']);
		$homeBlockTitle = sanitize_text_field($_REQUEST['homeBlockTitle']);
        $homeBlockDescription = sanitize_textarea_field($_REQUEST['homeBlockDescription']);
        $homeBlockLinkText = $_REQUEST['homeBlockLinkText'];
		$homeBlockLink = $_REQUEST['homeBlockLink'];

        if( isset($_REQUEST['homeBlockAlign']) ) {
            $homeBlockAlign = $_REQUEST['homeBlockAlign'];
        } else {
            $homeBlockAlign = 'left';
        }


        if( isset($_REQUEST['homeBlockTab']) && ! empty($_REQUEST['homeBlockTab']) ) {
            $homeBlockTab = 1;
        } else {
            $homeBlockTab = 0;
        }

        if( isset($_REQUEST['homeBlockWhole']) && ! empty($_REQUEST['homeBlockWhole']) ) {
            $homeBlockWhole = 1;
        } else {
            $homeBlockWhole = 0;
        }

        if( isset($_REQUEST['homeBlockButtonSize']) ) {
            $homeBlockButtonSize = $_REQUEST['homeBlockButtonSize'];
        } else {
            $homeBlockButtonSize = 'default';
        }

		$newSection = $_REQUEST['sectionId'];

        if( isset($_REQUEST['videoId']) && ! empty($_REQUEST['videoId']) ) {
            $video_id = $_REQUEST['videoId'];
        } else {
            $video_id = "";
        }

        if( isset($_REQUEST['video_url']) && ! empty($_REQUEST['video_url']) ) {
            $video_url = $_REQUEST['video_url'];
        } else {
            $video_url = "";
        }

        if( isset($_REQUEST['background_type']) && ! empty($_REQUEST['background_type']) ) {
            $slide_background_type = $_REQUEST['background_type'];
        } else {
            $slide_background_type = "image";
        }

        if( isset($_REQUEST['youtube_url']) && ! empty($_REQUEST['youtube_url']) ) {
            $slide_youtube_url = $_REQUEST['youtube_url'];
        } else {
            $slide_youtube_url = "";
        }

        if( isset($_REQUEST['youtube_id']) && ! empty($_REQUEST['youtube_id']) ) {
            $slide_youtube_id = $_REQUEST['youtube_id'];
        } else {
            $slide_youtube_id = "";
        }

        if( isset($_REQUEST['vimeo_url']) && ! empty($_REQUEST['vimeo_url']) ) {
            $slide_vimeo_url = $_REQUEST['vimeo_url'];
        } else {
            $slide_vimeo_url = "";
        }

        if( isset($_REQUEST['vimeo_id']) && ! empty($_REQUEST['vimeo_id']) ) {
            $slide_vimeo_id = $_REQUEST['vimeo_id'];
        } else {
            $slide_vimeo_id = "";
        }

        if( isset($_REQUEST['mute']) && ! empty($_REQUEST['mute']) ) {
            $slide_mute_video = intval($_REQUEST['mute']);
        } else {
            $slide_mute_video = 0;
        }

        if( isset($_REQUEST['aspect_ratio']) && ! empty($_REQUEST['aspect_ratio']) ) {
            $slide_aspect_ratio = $_REQUEST['aspect_ratio'];
        } else {
            $slide_aspect_ratio = '';
        }

        if( isset($_REQUEST['custom_iframe']) && ! empty($_REQUEST['custom_iframe']) ) {
            $slide_custom_iframe = $_REQUEST['custom_iframe'];
        } else {
            $slide_custom_iframe = "";
        }

        $slides =  'wpvs_slider_array';

		$sliderArray = get_option($slides);

		foreach($sliderArray as &$slide) {
			if($slide['id'] == $newSection) {
				foreach($slide['blocks'] as &$block) {
					if($block['id'] == $homeBlockId) {
						$block['image'] = $homeBlockImage;
                        $block['image_alt'] = $homeBlockImageAlt;
						$block['title'] = $homeBlockTitle;
                        $block['description'] = $homeBlockDescription;
                        $block['link_text'] = $homeBlockLinkText;
                        $block['button_size'] = $homeBlockButtonSize;
						$block['link'] = $homeBlockLink;
                        $block['align'] = $homeBlockAlign;
						$block['tab'] = $homeBlockTab;
                        $block['whole'] = $homeBlockWhole;
                        $block['backgroundtype'] = $slide_background_type;
                        $block['video'] = $video_id;
                        $block['videourl'] = $video_url;
                        $block['youtubeurl'] = $slide_youtube_url;
                        $block['youtubeid'] = $slide_youtube_id;
                        $block['vimeourl'] = $slide_vimeo_url;
                        $block['vimeoid'] = $slide_vimeo_id;
                        $block['muted'] = $slide_mute_video;
                        $block['video_aspect_ratio'] = $slide_aspect_ratio;
                        $block['custom_iframe'] = $slide_custom_iframe;
						break;
					}
				}
			}
		}

		update_option($slides, $sliderArray);

    }
    wp_die();
}

add_action( 'wp_ajax_newslidertitle_ajax_request', 'newslidertitle_ajax_request' );

function newslidertitle_ajax_request() {

	if ( isset($_REQUEST) ) {

        $newSection = $_REQUEST['sectionId'];
		$newTitle = $_REQUEST['newTitle'];
        $slides =  'wpvs_slider_array';

		$sliderArray = get_option($slides);

		foreach($sliderArray as &$slide) {
			if($slide['id'] == $newSection) {
				$slide['name'] = $newTitle;
				break;
			}
		}
		update_option($slides, $sliderArray);
    }
    wp_die();
}

add_action( 'wp_ajax_wpvs_slider_settings_ajax_request', 'wpvs_slider_settings_ajax_request' );

function wpvs_slider_settings_ajax_request() {
	if ( isset($_REQUEST) && isset($_REQUEST['sectionId']) ) {
		if ( empty($_REQUEST['new_max_height']) ) {
            $new_max_height = "";
        } else {
            $new_max_height = $_REQUEST['new_max_height'];
        }
        $newSection = $_REQUEST['sectionId'];


        $slides =  'wpvs_slider_array';

		$sliderArray = get_option($slides);

		foreach($sliderArray as &$slide) {
			if($slide['id'] == $newSection) {
				$slide['max_height'] = $new_max_height;
				break;
			}
		}
		update_option($slides, $sliderArray);
    }
    wp_die();
}

add_action( 'wp_ajax_wpvs_slide_video_title_search_ajax_request', 'wpvs_slide_video_title_search_ajax_request' );

function wpvs_slide_video_title_search_ajax_request() {
    if(current_user_can('manage_options')) {
        $found_videos = array();
        if ( isset($_REQUEST['videotitle']) && ! empty($_REQUEST['videotitle']) ) {
            $search_keyword = $_REQUEST['videotitle'];
            $video_args = array(
                'post_type' => 'rvs_video',
                'posts_per_page' => -1,
                'nopaging' => true,
                'fields' => 'ids',
                's' => $search_keyword
            );
            $video_list = get_posts($video_args);
            if( ! empty($video_list) ) {
                foreach($video_list as $found_video) {
                    $video_title = get_the_title($found_video);
                    $video_link = wp_make_link_relative(get_permalink( $found_video ));
                    $video_thumbnail = get_the_post_thumbnail_url( $found_video, 'header' );
                    if( empty($video_thumbnail) ) {
                        $video_thumbnail = get_the_post_thumbnail_url( $found_video, 'full' );
                    }
                    $found_videos[] = array('video_title' => $video_title, 'video_id' => $found_video, 'video_link' => $video_link, 'video_header' => $video_thumbnail);
                }
            }

        }
        if( empty($found_videos) ) {
            echo 'novideos';
        } else {
            echo json_encode($found_videos);
        }
    }
    wp_die();
}

add_action( 'wp_ajax_wpvs_update_featured_area_order', 'wpvs_update_featured_area_order' );

function wpvs_update_featured_area_order() {
    if(current_user_can('manage_options')) {
        if( isset($_POST['slider_id']) && ! empty($_POST['slider_id']) && isset($_POST['slide_order']) && ! empty($_POST['slide_order']) ) {
            $slider_id = $_POST['slider_id'];
            $slide_item_ids = $_POST['slide_order'];
            $wpvs_slider_array = get_option('wpvs_slider_array', array());
            $slider_key = null;
            $slider_slides = array();

            foreach($wpvs_slider_array as $s_key => $featured_slider) {
                if($featured_slider['id'] == $slider_id) {
                    $slider_slides = $featured_slider['blocks'];
                    $slider_key = $s_key;
                    break;
                }
            }

            if( ! empty($slider_slides) && $slider_key !== null ) {
                $new_slide_order = array();
                foreach($slide_item_ids as $slide_id ) {
                    $slide_details = wpvs_get_featured_area_slide_by_id($slide_id, $slider_slides);
                    if( ! empty($slide_details) ) {
                        $new_slide_order[] = $slide_details;
                    }
                }
                if( ! empty($new_slide_order) ) {
                    $wpvs_slider_array[$slider_key]['blocks'] = $new_slide_order;
                    update_option('wpvs_slider_array', $wpvs_slider_array);
                }
            }
        }
    }
    wp_die();
}

function wpvs_get_featured_area_slide_by_id($slide_id, $slide_array) {
    $found_slide = array();
    if( ! empty($slide_array) ) {
        foreach($slide_array as $key => $slide) {
            if( $slide['id'] == $slide_id) {
                $found_slide = $slide;
                break;
            }
        }
    }
    return $found_slide;
}
