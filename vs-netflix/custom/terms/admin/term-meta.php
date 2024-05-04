<?php

function rvs_video_category_add_new_meta_field() {
    global $wpvs_theme_thumbnail_sizing;
    wp_enqueue_media();
    wp_enqueue_script('wpvs-video-image-upload');
    wp_localize_script('wpvs-video-image-upload', 'wpvsimageloader',
        array('thumbnail' => $wpvs_theme_thumbnail_sizing->layout)
    );


    wp_enqueue_script('wpvs-cat-thumbnails');
    $placeholder_image = get_template_directory_uri() .'/images/placeholder.png';
	?>
    <h3>TV Show Settings (Optional)</h3>
    <div class="wpvs-cat-option rvs-border-box wpvs-contains-tv-shows">
        <div class="wpvs-cat-details">
		  <label for="cat_contains_shows"><?php _e( 'Contains TV Shows', 'wpvs-theme' ); ?></label>
            <p><?php _e( 'Lists TV Shows. Is this a main category for shows (TV Action, TV Comedy, etc)','wpvs-theme' ); ?></p>
        </div>
        <div class="wpvs-cat-input">
		  <input type="checkbox" name="cat_contains_shows" id="cat_contains_shows" value="1">
        </div>
	</div>
    <div class="wpvs-cat-option rvs-border-box wpvs-is-tv-show">
        <div class="wpvs-cat-details">
		  <label for="cat_has_seasons"><?php _e( 'Series / TV Show (Has Seasons)', 'wpvs-theme' ); ?></label>
            <p><?php _e( 'Is this a TV Show with Seasons and Episodes?','wpvs-theme' ); ?>.</p>
            <?php _e( 'Leave this <strong>unchecked</strong> if:','wpvs-theme' ); ?>
            <ul class="wpvs-edit-list">
                <li><strong>Contains TV Shows</strong> is already checked</li>
                <li>This is a <strong>Movie Genre</strong></li>
                <li>This is a <strong>Season</strong></li>
            </ul>
        </div>
        <div class="wpvs-cat-input">
		  <input type="checkbox" name="cat_has_seasons" id="cat_has_seasons" value="1">
        </div>
	</div>
    <div class="wpvs-cat-option rvs-border-box wpvs-is-tv-show">
        <div class="wpvs-cat-images rvs-border-box">
            <label><?php _e( 'TV Show Thumbnail Image','wpvs-theme' ); ?>: (<em><?php echo $wpvs_theme_thumbnail_sizing->recommended_size; ?></em>)</label>
            <div class="wpvs-cat-image-details">
                <div class="wpvs-cat-image-preview">
                    <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $placeholder_image ?>" data-size="thumbnail"/>
                    <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
                    <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_video_cat_thumbnail" id="wpvs_video_cat_thumbnail" value="">
                    <input type="hidden" name="wpvs_video_cat_attachment" id="wpvs_video_cat_attachment" value="">
                </div>
            </div>
            <p><?php _e( 'If this is a TV Show, upload a thumbnail image','wpvs-theme' ); ?>. You can customize your thumbnail size under <strong>Video Browsing</strong> in the <a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customizer', 'wpvs-theme'); ?></a> area.</p>
        </div>
    </div>
    <div class="wpvs-cat-option rvs-border-box wpvs-is-tv-show">
        <label><?php _e( 'TV Show Title Image','wpvs-theme' ); ?></label>
        <p><?php _e( 'The Title Image displays above the show description replacing the default heading','wpvs-theme' ); ?>.</p>
        <div class="wpvs-choose-image-container">
            <div class="wpvs-thumbnail-image-container">
            </div>
            <label class="wpvs-select-image button button-primary">Select Image</label>
            <label class="wpvs-remove-selected-image button button-primary">Remove</label>
            <input type="hidden" name="wpvs_term_title_image" class="wpvs-set-selected-image" value=""/>
            <input type="hidden" name="wpvs_term_title_image_id" class="wpvs-set-selected-image-id" value=""/>
        </div>
    </div>
    <h3><?php _e('Subcategories Order', 'wpvs-theme'); ?></h3>
	<div class="wpvs-cat-option rvs-border-box">
        <select name="wpvs_sub_cat_order">
            <option value="order"><?php _e('Order', 'wpvs-theme'); ?></option>
            <option value="id"><?php _e('ID (Creation Date)', 'wpvs-theme'); ?></option>
            <option value="title"><?php _e('Title (Default)', 'wpvs-theme'); ?></option>
        </select>
        <p><?php _e( 'How subcategories should be ordered','wpvs-theme' ); ?></p>
	</div>
    <h3>Homepage Settings</h3>
	<div class="wpvs-cat-option rvs-border-box">
        <div class="wpvs-cat-details">
		  <label for="video_cat_order"><?php _e( 'Order', 'wpvs-theme' ); ?></label>
            <p class="descriptions"><?php _e( 'Order of appearance on home page or within category', 'wpvs-theme' ); ?>. If this is a Season within a Series, use this setting to set the Season number (order).</p>
        </div>
        <div class="wpvs-cat-input">
		  <input class="small-text" type="number" min="0" max="99999" name="video_cat_order" id="video_cat_order" value="0">
        </div>

	</div>
    <div class="wpvs-cat-option rvs-border-box">
        <div class="wpvs-cat-details">
		      <label for="video_cat_hide"><?php _e( 'Hide on Homepage', 'wpvs-theme' ); ?></label>
            <p><?php _e( 'Hide this category on home page sliders','wpvs-theme' ); ?></p>
        </div>
        <div class="wpvs-cat-input">
		  <input type="checkbox" name="video_cat_hide" id="video_cat_hide" value="1">
        </div>
	</div>
<?php
}
add_action( 'rvs_video_category_add_form_fields', 'rvs_video_category_add_new_meta_field', 10, 2 );

function rvs_video_category_edit_meta_field($term) {
    global $wpvs_theme_thumbnail_sizing;
	$term_order = get_term_meta($term->term_id, 'video_cat_order', true);
    $hide_cat = get_term_meta($term->term_id, 'video_cat_hide', true);
    $contains_shows = get_term_meta($term->term_id, 'cat_contains_shows', true);
    $cat_has_seasons = get_term_meta($term->term_id, 'cat_has_seasons', true);
    $wpvs_is_season = get_term_meta($term->term_id, 'wpvs_is_season', true);
    $cat_thumb_landscape = get_term_meta($term->term_id, 'wpvs_video_cat_thumbnail', true);
    if( empty($cat_thumb_landscape) ) {
        $cat_thumb_landscape = get_template_directory_uri() .'/images/placeholder.png';
    }
    $wpvs_video_cat_attachment = get_term_meta($term->term_id, 'wpvs_video_cat_attachment', true);

    $wpvs_term_title_image = get_term_meta($term->term_id, 'wpvs_term_title_image', true);
    $wpvs_term_title_image_id = get_term_meta($term->term_id, 'wpvs_term_title_image_id', true);

    $order_sub_categories = get_term_meta($term->term_id, 'wpvs_sub_cat_order', true);
    if( empty($order_sub_categories) ) {
        $order_sub_categories = 'order';
    }

    $video_cat_slideshow = get_term_meta($term->term_id, 'video_cat_slideshow', true);
    if( empty($video_cat_slideshow) ) {
        $video_cat_slideshow = 0;
    }
    $wpvs_slideshows = get_option('wpvs_slider_array');

    wp_enqueue_media();
    wp_enqueue_script('wpvs-video-image-upload');
    wp_localize_script('wpvs-video-image-upload', 'wpvsimageloader',
        array('thumbnail' => $wpvs_theme_thumbnail_sizing->layout)
    );

    wp_enqueue_script('wpvs-cat-thumbnails');
    ?>
    <tr class="wpvs-contains-tv-shows">
        <th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Contains TV Shows', 'wpvs-theme' ); ?></label></th>
            <td>
                <input type="checkbox" min="0" name="cat_contains_shows" id="cat_contains_shows" value="1" <?php checked(1,$contains_shows); ?>>
                <?php _e( 'Lists TV Shows. Is this a main category for shows (TV Action, TV Comedy, etc)','wpvs-theme' ); ?>
            </td>
        </tr>
	<tr>
    <tr class="wpvs-is-tv-show">
        <th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Series / TV Show (Has Seasons)', 'wpvs-theme' ); ?></label></th>
            <td>
                <input type="checkbox" min="0" name="cat_has_seasons" id="cat_has_seasons" value="1" <?php checked(1,$cat_has_seasons); ?>>
                <?php _e( 'Leave this <strong>unchecked</strong> if:','wpvs-theme' ); ?>
                <ul class="wpvs-edit-list">
                    <li><strong>Contains TV Shows</strong> is already checked</li>
                    <li>This is a <strong>Movie Genre</strong></li>
                    <li>This is a <strong>Season</strong></li>
                </ul>
            </td>
        </tr>
	<tr>
    <tr class="wpvs-contains-tv-shows">
        <th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Is A Season', 'wpvs-theme' ); ?></label></th>
            <td>
                <input type="checkbox" name="wpvs_is_season" value="1" <?php checked(1,$wpvs_is_season); ?> readonly disabled>
                <?php _e( 'This setting is automatically enabled if the Parent Genre / Category is a Series.','wpvs-theme' ); ?>
            </td>
        </tr>
	<tr>

    <tr>
        <th scope="row" valign="top"><label><?php _e( 'TV Show Thumbnail Image', 'wpvs-theme' ); ?> (<?php echo $wpvs_theme_thumbnail_sizing->recommended_size; ?>)</label></th>
		<td>
        <div id="wpvs-cat-images" class="wpvs-cat-images rvs-border-box wpvs-is-tv-show">
            <div class="wpvs-cat-image-details">
                <div class="wpvs-cat-image-preview">
                    <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $cat_thumb_landscape ?>" data-size="thumbnail"/>
                    <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
                    <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_video_cat_thumbnail" id="wpvs_video_cat_thumbnail" value="<?php echo $cat_thumb_landscape ?>">
                    <input type="hidden" name="wpvs_video_cat_attachment" id="wpvs_video_cat_attachment" value="<?php echo $wpvs_video_cat_attachment ?>">
                </div>
            </div>
            <p>You can customize your thumbnail size under <strong>Video Browsing</strong> in the <a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customizer', 'wpvs-theme'); ?></a> area.</p>
        </div>
        </td>
	</tr>
    <tr>
        <th scope="row" valign="top"><label><?php _e( 'TV Show Title Image', 'wpvs-theme' ); ?></label></th>
		<td>
            <div class="wpvs-choose-image-container">
                <div class="wpvs-thumbnail-image-container">
                    <?php if( ! empty($wpvs_term_title_image) ) : ?>
                        <img class="wpvs-set-image" src="<?php echo $wpvs_term_title_image; ?>" />
                    <?php endif; ?>
                </div>
                <label class="wpvs-select-image button button-primary">Select Image</label>
                <label class="wpvs-remove-selected-image button button-primary">Remove</label>
                <input type="hidden" name="wpvs_term_title_image" class="wpvs-set-selected-image" value="<?php echo $wpvs_term_title_image; ?>"/>
                <input type="hidden" name="wpvs_term_title_image_id" class="wpvs-set-selected-image-id" value="<?php echo $wpvs_term_title_image_id; ?>"/>
            </div>
        </td>
	</tr>
    <tr>
	<th scope="row" valign="top"><label for="wpvs_sub_cat_order"><?php _e( 'Subcategories Order', 'wpvs-theme' ); ?></label></th>
		<td>
            <select name="wpvs_sub_cat_order">
                <option value="order" <?php selected('order', $order_sub_categories); ?>><?php _e('Order', 'wpvs-theme'); ?></option>
                <option value="id" <?php selected('id', $order_sub_categories); ?>><?php _e('ID (Creation Date)', 'wpvs-theme'); ?></option>
                <option value="title" <?php selected('title', $order_sub_categories); ?>><?php _e('Title (Default)', 'wpvs-theme'); ?></option>

            </select>
		</td>
	</tr>
    <tr>
	<th scope="row" valign="top"><label for="video_cat_order"><?php _e( 'Order', 'wpvs-theme' ); ?></label></th>
		<td>
			<input class="small-text" type="number" min="0" max="99999" name="video_cat_order" id="video_cat_order" value="<?php echo $term_order; ?>">
			<p class="descriptions"><?php _e( 'Order of appearance on home page or within category', 'wpvs-theme' ); ?>. If this is a Season within a Series, use this setting to set the Season number (order).</p>
		</td>
	</tr>
    <tr>
	<th scope="row" valign="top"><label for="video_cat_hide"><?php _e( 'Hide on Homepage', 'wpvs-theme' ); ?></label></th>
		<td>
			<input type="checkbox" name="video_cat_hide" id="video_cat_hide" value="1" <?php checked(1,$hide_cat); ?>>
			<?php _e( 'Hide this category on home page sliders','wpvs-theme' ); ?>
		</td>
	</tr>
    <tr>
    <th scope="row" valign="top"><label><?php _e( 'Featured Slider', 'wpvs-theme' ); ?></label></th>
		<td>
            <select id="wpvs_cat_slideshow"  name="wpvs_cat_slideshow">
			<?php
                if( ! empty($wpvs_slideshows) ) {
                    foreach($wpvs_slideshows as $slideshow) {
                        echo '<option value="'.$slideshow['id'].'"' . selected( $slideshow['id'], $video_cat_slideshow ) . ' >'.$slideshow['name'].'</option>';
                    }
                }
            ?>
                <option value="0" <?php selected( 0, $video_cat_slideshow ); ?>>None</option>
            </select>
		</td>
	</tr>
<?php

}
add_action( 'rvs_video_category_edit_form_fields', 'rvs_video_category_edit_meta_field', 10, 2 );

function wpvs_theme_save_taxanomy_custom_meta( $term_id ) {
	if ( isset( $_POST['video_cat_order'] ) ) {
		$new_video_order = $_POST['video_cat_order'];
        if($new_video_order == "") {
            $new_video_order = "0";
        }
		update_term_meta($term_id, 'video_cat_order', $new_video_order);
	}
    if ( isset( $_POST['video_cat_hide'] ) ) {
		update_term_meta($term_id, 'video_cat_hide', $_POST['video_cat_hide']);
	} else {
        update_term_meta($term_id, 'video_cat_hide', 0);
    }
    if ( isset( $_POST['cat_contains_shows'] ) ) {
		update_term_meta($term_id, 'cat_contains_shows', $_POST['cat_contains_shows']);
	} else {
        update_term_meta($term_id, 'cat_contains_shows', 0);
    }
    if ( isset( $_POST['cat_has_seasons'] ) ) {
		update_term_meta($term_id, 'cat_has_seasons', $_POST['cat_has_seasons']);
	} else {
        update_term_meta($term_id, 'cat_has_seasons', 0);
    }

    if ( isset( $_POST['parent'] ) && ! empty($_POST['parent']) ) {
        $parent_term_id = $_POST['parent'];
        $parent_has_seasons = get_term_meta($parent_term_id, 'cat_has_seasons', true);
        if( $parent_has_seasons ) {
            update_term_meta($term_id, 'wpvs_is_season', 1);
        } else {
            update_term_meta($term_id, 'wpvs_is_season', 0);
        }
	} else {
        update_term_meta($term_id, 'wpvs_is_season', 0);
    }

    // CATEGORY THUMBNAILS
    if ( isset( $_POST['wpvs_video_cat_attachment'] ) && !empty($_POST['wpvs_video_cat_attachment']) ) {
        update_term_meta($term_id, 'wpvs_video_cat_attachment', $_POST['wpvs_video_cat_attachment']);
	}
    if ( isset( $_POST['wpvs_video_cat_thumbnail'] ) ) {
		update_term_meta($term_id, 'wpvs_video_cat_thumbnail', $_POST['wpvs_video_cat_thumbnail']);
	}
    if ( isset( $_POST['wpvs_term_title_image'] ) ) {
		update_term_meta($term_id, 'wpvs_term_title_image', $_POST['wpvs_term_title_image']);
	}
    if ( isset( $_POST['wpvs_term_title_image_id'] ) ) {
		update_term_meta($term_id, 'wpvs_term_title_image_id', $_POST['wpvs_term_title_image_id']);
	}

    if ( isset( $_POST['wpvs_cat_slideshow'] ) ) {
		update_term_meta($term_id, 'video_cat_slideshow', $_POST['wpvs_cat_slideshow']);
	}
    if ( isset( $_POST['wpvs_sub_cat_order'] ) ) {
		update_term_meta($term_id, 'wpvs_sub_cat_order', $_POST['wpvs_sub_cat_order']);
	}
}
add_action( 'edited_rvs_video_category', 'wpvs_theme_save_taxanomy_custom_meta', 10, 2 );
add_action( 'create_rvs_video_category', 'wpvs_theme_save_taxanomy_custom_meta', 10, 2 );

function wpvs_actors_add_new_meta_field() {
    global $wpvs_actor_slug_settings;
    wp_enqueue_media();
    wp_enqueue_script('wpvs-upload-thumbnails');
	$profile_image = get_template_directory_uri() .'/images/profile.png';
    $tv_shows = get_terms( array(
        'taxonomy' => 'rvs_video_category',
        'meta_key'  => 'cat_has_seasons',
        'meta_value' => 1,
    ));
	?>
    <div class="form-field term-slug-wrap">
        <label><?php _e( 'Profile Image', 'wpvs-theme' ); ?></label>
        <div class="wpvs-cat-image-preview">
        <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $profile_image ?>" data-size="thumbnail"/>
        <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
        <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_actor_profile_photo" id="wpvs_actor_profile_photo" value="">
        <input class="wpvs-thumbnail-attachment" type="hidden" name="wpvs_actor_photo_attachment" id="wpvs_actor_photo_attachment" value="">
        </div>
        <p class="description"><?php _e('Recommended size', 'wpvs-theme'); ?> (150px by 150px)</p>
    </div>

    <div class="form-field term-slug-wrap">
        <label><?php _e( 'Profile Link (IMDb)', 'wpvs-theme' ); ?></label>
        <input type="url" name="wpvs_actor_imdb_link" value="" />
        <p><?php _e('Link to a profile such as on IMDb', 'wpvs-theme'); ?></p>
    </div>

    <div class="form-field term-slug-wrap">
        <label><?php _e( 'Add to TV Shows', 'wpvs-theme' ); ?></label>
        <?php if( ! empty($tv_shows) ) { foreach($tv_shows as $tv_show) { ?>
            <div class="wpvs_checkbox_option">
                <label><input type="checkbox" name="wpvs_actor_tv_shows[]" value="<?php echo $tv_show->term_id; ?>" /><?php echo $tv_show->name; ?></label>
            </div>
        <?php } } else { ?>
            <p><?php _e('No TV Shows created', 'wpvs-theme'); ?>. <a href="https://docs.wpvideosubscriptions.com/wpvs-theme-theme/creating-tv-shows-series/" rel="help" target="_blank"><?php _e('How to create TV Shows', 'wpvs-theme'); ?></a></p>
        <?php }?>
    </div>
    <div class="form-field term-slug-wrap">
        <label><strong><?php _e('Order', 'wpvs-theme'); ?></strong></label>
        <p>Sets the <strong>Order</strong> for this <?php echo $wpvs_actor_slug_settings['name']; ?></p>
        <input type="number" min="0" name="wpvs_video_display_order" value="" />
    </div>
    <div class="form-field term-slug-wrap">
        <label><strong><?php _e( 'Series Layout', 'wpvs-theme' ); ?></strong></label>
        <div class="wpvs_checkbox_option">
            <label><input type="checkbox" name="wpvs_actor_show_all_episodes" value="1" /><?php _e('Show All Episodes', 'vs-netflix'); ?></label>
        </div>
    </div>

<?php
}
add_action( 'rvs_actors_add_form_fields', 'wpvs_actors_add_new_meta_field', 10, 2 );
add_action( 'rvs_directors_add_form_fields', 'wpvs_actors_add_new_meta_field', 10, 2 );

function wpvs_actors_edit_meta_field($term) {
    global $wpvs_actor_slug_settings;
    wp_enqueue_media();
    wp_enqueue_script('wpvs-upload-thumbnails');
    $wpvs_display_order = get_term_meta($term->term_id, 'wpvs_display_order', true);
    if( empty($wpvs_display_order) ) {
        $wpvs_display_order = "0";
    }
	$profile_image = get_term_meta($term->term_id, 'wpvs_actor_profile', true);
    $imdb_link = get_term_meta($term->term_id, 'wpvs_actor_imdb_link', true);
    $profile_image_attachment = get_term_meta($term->term_id, 'wpvs_actor_profile_attachment', true);
    $wpvs_actor_tv_shows = get_term_meta($term->term_id, 'wpvs_actor_tv_shows', true);
    $wpvs_show_all_episodes = get_term_meta($term->term_id, 'wpvs_term_show_all_episodes', true);
    if( empty($profile_image) ) {
        $profile_image = get_template_directory_uri() .'/images/profile.png';
    }
    if( empty($profile_image_attachment) ) {
        $profile_image_attachment = "";
    }
    if( empty($imdb_link) ) {
        $imdb_link = "";
    }
    if( empty($wpvs_actor_tv_shows) ) {
        $wpvs_actor_tv_shows = array();
    }
    $tv_shows = get_terms( array(
        'taxonomy' => 'rvs_video_category',
        'meta_key'  => 'cat_has_seasons',
        'meta_value' => 1,
    ));
    ?>
    <tr class="form-field term-slug-wrap">
        <th scope="row" valign="top"><label><?php _e( 'Profile Image', 'wpvs-theme' ); ?></label></th>
        <td>
        <div class="wpvs-cat-image-preview">
        <img class="wpvs-select-thumbnail update-video-cat-attachment" id="wpvs-landscape-preview" src="<?php echo $profile_image ?>" data-size="thumbnail"/>
        <label class="wpvs-cat-thumb-icon"><span class="dashicons dashicons-plus-alt"></span></label>
        <input class="wpvs-set-thumbnail" type="hidden" name="wpvs_actor_profile_photo" id="wpvs_actor_profile_photo" value="<?php echo $profile_image ?>">
        <input class="wpvs-thumbnail-attachment" type="hidden" name="wpvs_actor_photo_attachment" id="wpvs_actor_photo_attachment" value="<?php echo $profile_image_attachment; ?>">
        </div>
        <p class="description"><?php _e('Recommended size', 'wpvs-theme'); ?> (150px by 150px)</p>
        </td>
    </tr>
    <tr class="form-field">
	<th scope="row" valign="top"><label><?php _e( 'Profile Link (IMDb)', 'wpvs-theme' ); ?></label></th>
		<td>
			<input type="url" name="wpvs_actor_imdb_link" value="<?php echo $imdb_link; ?>" size="40"/>
			<p class="description"><?php _e('Link to a profile such as on IMDb', 'wpvs-theme'); ?></p>
		</td>
	</tr>
    <th scope="row" valign="top">
        <label><?php _e( 'Add to TV Shows', 'wpvs-theme' ); ?></label>
        <td>
            <?php if( ! empty($tv_shows) ) { foreach($tv_shows as $tv_show) { ?>
                <div class="wpvs_checkbox_option">
                    <label><input type="checkbox" name="wpvs_actor_tv_shows[]" value="<?php echo $tv_show->term_id; ?>" <?php checked(in_array($tv_show->term_id, $wpvs_actor_tv_shows)); ?>/><?php echo $tv_show->name; ?></label>
                </div>
            <?php } } else { ?>
                <p><?php _e('No TV Shows created', 'wpvs-theme'); ?>. <a href="https://docs.wpvideosubscriptions.com/wpvs-theme-theme/creating-tv-shows-series/" rel="help" target="_blank"><?php _e('How to create TV Shows', 'wpvs-theme'); ?></a></p>
            <?php } ?>
		</td>
    </tr>
    <tr>
        <th scope="row" valign="top">
            <label><strong><?php _e('Order', 'wpvw-theme'); ?></strong></label></th>
            <td>
                <input type="number" min="0" name="wpvs_video_display_order" value="<?php echo $wpvs_display_order; ?>" /><br><br>
                <p class="description">Sets the <strong>Order</strong> for this <?php echo $wpvs_actor_slug_settings['name']; ?></p>
            </td>
        </tr>
	<tr>
    <tr>
        <th scope="row" valign="top">
            <label><strong><?php _e('Series Layout', 'wpvw-theme'); ?></strong></label></th>
            <td>
                <label><input type="checkbox" name="wpvs_actor_show_all_episodes" value="1" <?php checked(1, $wpvs_show_all_episodes); ?> /><?php _e('Show All Episodes', 'vs-netflix'); ?></label>
                <br>
                <ul>
                    <li><strong><?php _e('Enabled', 'vs-netflix'); ?>:</strong> Shows all episodes this term is assigned to.</li>
                    <li><strong><?php _e('Disabled', 'vs-netflix'); ?>:</strong> Shows only the Series (TV Shows) for episodes this term is assigned to.</li>
                </ul>
            </td>
        </tr>
	<tr>
<?php

}
add_action( 'rvs_actors_edit_form_fields', 'wpvs_actors_edit_meta_field', 10, 2 );
add_action( 'rvs_directors_edit_form_fields', 'wpvs_actors_edit_meta_field', 10, 2 );

function wpvs_theme_save_actors_custom_meta( $term_id ) {
    if ( isset( $_POST['wpvs_actor_profile_photo'] ) && !empty($_POST['wpvs_actor_profile_photo']) ) {
        update_term_meta($term_id, 'wpvs_actor_profile', $_POST['wpvs_actor_profile_photo']);
	}
    if ( isset( $_POST['wpvs_actor_photo_attachment'] ) ) {
		update_term_meta($term_id, 'wpvs_actor_profile_attachment', $_POST['wpvs_actor_photo_attachment']);
	}
    if ( isset( $_POST['wpvs_actor_imdb_link'] ) ) {
		update_term_meta($term_id, 'wpvs_actor_imdb_link', $_POST['wpvs_actor_imdb_link']);
	}
    if ( isset( $_POST['wpvs_actor_tv_shows'] ) ) {
		update_term_meta($term_id, 'wpvs_actor_tv_shows', $_POST['wpvs_actor_tv_shows']);
	} else {
        update_term_meta($term_id, 'wpvs_actor_tv_shows', array());
    }
    if ( isset( $_POST['wpvs_video_display_order'] ) ) {
        update_term_meta($term_id, 'wpvs_display_order', $_POST['wpvs_video_display_order']);
    }
    if ( isset( $_POST['wpvs_actor_show_all_episodes'] ) ) {
        update_term_meta($term_id, 'wpvs_term_show_all_episodes', 1);
    } else {
        update_term_meta($term_id, 'wpvs_term_show_all_episodes', 0);
    }
}
add_action( 'edited_rvs_actors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );
add_action( 'create_rvs_actors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );
add_action( 'edited_rvs_directors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );
add_action( 'create_rvs_directors', 'wpvs_theme_save_actors_custom_meta', 10, 2 );
