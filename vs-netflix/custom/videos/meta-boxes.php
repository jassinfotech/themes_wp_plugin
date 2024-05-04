<?php

add_action( 'add_meta_boxes', 'wpvs_theme_video_metabox_settings' );

function wpvs_theme_video_metabox_settings() {
    global $post;
    add_meta_box(
        'wpvideos-video-details',
        'WPVS Video',
        'wpvs_theme_video_meta_settings',
        array('rvs_video'),
        'normal',
        'high'
    );

    add_meta_box(
        'wpvideos-video-information',
        'Video Information',
        'wpvs_theme_video_meta_information',
        array('rvs_video'),
        'normal',
        'high'
    );

    add_meta_box(
        'wpvideos-video-order',
        'Video Order',
        'wpvs_theme_video_meta_order',
        array('rvs_video'),
        'side',
        'low'
    );

    add_meta_box(
        'wpvs_featured_area_select',
        __( 'Featured Area', 'wpvs-theme' ),
        'wpvs_featured_area_select_options',
        'page',
        'side',
        'high'
    );

    add_meta_box(
        'wpvs_video_homepage_options',
        __( 'Video Options', 'wpvs-theme' ),
        'wpvs_video_homepage_options',
        array('rvs_video'),
        'side',
        'low'
    );

    add_meta_box(
        'wpvs_theme_video_title_image',
        __( 'Title Image', 'wpvs-theme' ),
        'wpvs_theme_video_title_image',
        array('rvs_video'),
        'side',
        'high'
    );

    add_meta_box(
        'wpvs_video_thumbnail_image',
        __( 'Thumbnail Image', 'wpvs-theme' ),
        'wpvs_video_thumbnail_image',
        array('rvs_video'),
        'side',
        'high'
    );

    add_meta_box(
        'wpvs_video_thumbnail_label',
        __( 'Thumbnail Label', 'wpvs-theme' ),
        'wpvs_video_thumbnail_label_admin_meta_box',
        array('rvs_video'),
        'side',
        'high'
    );

    add_meta_box(
        'wpvs_video_template_option',
        __( 'Video Page Layout', 'wpvs-theme' ),
        'wpvs_video_template_option_meta',
        array('rvs_video'),
        'side',
        'high'
    );


    add_meta_box(
        'wpvs_theme_page_settings',
        __( 'Page Options', 'wpvs-theme' ),
        'wpvs_theme_page_settings_callback',
        array('page'),
        'side',
        'high'
    );


    add_meta_box(
        'wpvs_trailer_setup',
        'WPVS Trailer',
        'wpvs_theme_trailer_video_setup_meta',
        array('rvs_video'),
        'normal',
        'high'
    );

    add_meta_box(
        'wpvs_audio_file_setting',
        'WPVS Audio',
        'wpvs_theme_audio_meta_settings',
        array('rvs_video'),
        'normal',
        'high'
    );
}

function wpvs_theme_video_meta_settings() {
    global $post;
    $wpvs_js_editor = wp_enqueue_code_editor( array( 'type' => 'text/javascript') );
    $wpvs_custom_html_editor = wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    wp_enqueue_style('wpvs-theme-video-post-css');
    wp_enqueue_script('wpvs-theme-video-post-js');
    wp_localize_script('wpvs-theme-video-post-js', 'wpvsvideopost', array(
        'code_mirror_video_js' => wp_json_encode( $wpvs_js_editor ),
        'code_mirror_video_html' => wp_json_encode( $wpvs_custom_html_editor )
    ));
    wp_enqueue_script('wpvs-theme-video-upload-js');
    wp_localize_script( 'wpvs-theme-video-upload-js', 'wpvsajax', array(
        'url' => admin_url( 'admin-ajax.php' )
    ));
    wp_nonce_field( 'rvs_video_meta_save', 'rvs_video_meta_save_nonce' );

    // GET VIDEO TYPE
    $rvs_video_type = get_post_meta($post->ID, '_rvs_video_type', true);
    if(empty($rvs_video_type)) {
        $rvs_video_type = "vimeo";
    }

    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "wpvs-custom-video-js-code", %s ); } );',
            wp_json_encode( $wpvs_js_editor )
        )
    );
    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "custom-video-code", %s ); } );',
            wp_json_encode( $wpvs_custom_html_editor )
        )
    );

    // WORDPRESS
    $rvs_wordpress_id = get_post_meta($post->ID, 'rvs_video_wordpress_id', true);
    $rvs_wordpress_code = get_post_meta($post->ID, 'rvs_video_wordpress_code', true);

    // VIMEO
    $vimeo_id = get_post_meta($post->ID, 'rvs_video_post_vimeo_id', true);
    $vimeo_video_html = get_post_meta($post->ID, 'rvs_video_post_vimeo_html', true);

    // JW PLAYER
    $wpvs_jw_media_id = get_post_meta($post->ID, '_jw_media_id', true);
    if( empty($wpvs_jw_media_id) ) {
        $wpvs_jw_media_id = '';
    }

    // YOUTUBE
    $rvs_youtube_url = get_post_meta($post->ID, 'rvs_youtube_url', true);

    // CUSTOM
    $rvs_custom_video_code = get_post_meta($post->ID, 'rvs_video_custom_code', true);
    if( empty($rvs_custom_video_code) ) {
        $rvs_custom_video_code = "";
    }
    $wpvs_custom_video_js = get_post_meta($post->ID, 'wpvs_custom_video_js', true);
    if( empty($wpvs_custom_video_js) ) {
        $wpvs_custom_video_js = "";
    }

    // SHORTCODE
    $rvs_shortcode_video = get_post_meta($post->ID, 'rvs_shortcode_video', true);
    $rvs_shortcode_video_check = get_post_meta($post->ID, 'rvs_shortcode_video_check', true);

    if( empty($rvs_shortcode_video) ) {
        $rvs_shortcode_video = "";
    }
    if( empty($rvs_shortcode_video_check) ) {
        $rvs_shortcode_video_check = "";
    }

    $wpvs_featured_image = get_post_meta($post->ID, 'wpvs_featured_image', true);
    ?>
    <div id="video-type" class="rvs-container rvs-box rvs-video-container border-box">
        <label class="rvs-label"><?php _e('Select Player', 'wpvs-theme'); ?>:</label>
        <select id="select-video-type" name="select-video-type">
            <option value="vimeo" <?php selected("vimeo", $rvs_video_type); ?>>Vimeo</option>
            <option value="jwplayer" <?php selected("jwplayer", $rvs_video_type); ?>><?php _e('JW Player', 'wpvs-theme'); ?></option>
            <option value="wordpress" <?php selected("wordpress", $rvs_video_type); ?>>WordPress</option>
            <option value="youtube" <?php selected("youtube", $rvs_video_type); ?>>YouTube</option>
            <option value="custom" <?php selected("custom", $rvs_video_type); ?>>Custom</option>
            <option value="shortcode" <?php selected("shortcode", $rvs_video_type); ?>>Shortcode</option>
        </select>
    </div>

    <!-- VIMEO -->
    <div id="vimeo-type-option" class="rvs-type-area <?=($rvs_video_type == 'vimeo') ? 'rvs-display-area' : '' ?>">
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label"><?php _e('Enter Vimeo ID', 'wpvs-theme'); ?>:</label></th>
                <td><input type="url" class="wpvs-input-url" name="wpvs_video_vimeo_id" id="wpvs_video_vimeo_id" class="regular-text" placeholder="Paste Vimeo ID here..." value="<?php echo esc_attr($vimeo_id); ?>" /></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div><!-- END VIMEO -->

    <!-- JW Player -->
    <div id="jwplayer-type-option" class="rvs-type-area <?=($rvs_video_type == 'jwplayer') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <a href="https://wpvideosubscriptions.zendesk.com/hc/en-us/articles/360049934934" class="rvs-button" rel="help" target="_blank"><?php _e('JW Player Setup Guide', 'wpvs-theme'); ?></a>
        </div>
    </div><!-- END JW Player -->

    <!-- WORDPRESS -->
    <div id="wordpress-type-option" class="rvs-type-area <?=($rvs_video_type == 'wordpress') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <label id="choose-wordpress-video" class="rvs-button">Choose Video</label>
        </div>
        <input type="hidden" value="<?php echo $rvs_wordpress_id; ?>" id="rvs-wordpress-id" name="rvs-wordpress-id" />
        <textarea name="rvs-wordpress-code" id="rvs-wordpress-code" class="rvs-hidden-code"><?php echo $rvs_wordpress_code; ?></textarea>
    </div><!-- END WORDPRESS -->

    <!-- YouTube -->
    <div id="youtube-type-option" class="rvs-type-area <?=($rvs_video_type == 'youtube') ? 'rvs-display-area' : '' ?> ">
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter YouTube URL:</label></th>
                <td><input type="url" class="wpvs-input-url" name="youtube-video-url" id="youtube-video-url" class="regular-text" placeholder="Paste YouTube link here..." value="<?php echo $rvs_youtube_url; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" value="?enablejsapi=1" id="wpvs-theme-youtube-url-params" />
        </div>
    </div>

    <!-- Custom -->
    <div id="custom-type-option" class="rvs-type-area <?=($rvs_video_type == 'custom' || $rvs_video_type == 'jwplayer') ? 'rvs-display-area' : '' ?>">
        <div class="rvs-box rvs-video-container border-box">
            <table class="form-table">
                <tbody>
                    <tr id="wpvs-jw-player-media-id-input" class="<?=($rvs_video_type == 'custom') ? 'rvs-hidden-code' : '' ?>">
                        <td>
                            <h4><?php _e('Media ID', 'wpvs-theme'); ?></h4>
                            <input type="text" class="wpvs-input-url" name="wpvs_jw_media_id" class="regular-text" placeholder="JW Player Media ID" value="<?php echo $wpvs_jw_media_id; ?>" />
                        </td>
                    </tr>
                    <tr>
                    <td>
                        <h4>Paste embed / iframe / html / script code:</h4>
                        <textarea name="custom-video-code" rows="5" cols="10" id="custom-video-code"><?php echo $rvs_custom_video_code; ?></textarea></td>
                    </tr>
                    <tr>
                    <td>
                        <h4>Custom player javascript (optional):</h4>
                        <p class="description">Javascript code here should be video specific. If you need global JS / CSS files or code for all your custom player videos, add them on the <a href="<?php echo admin_url('admin.php?page=wpvs-custom-player-settings'); ?>" title="Custom Player Settings" >Custom Player</a> page.</p><br>
                        <textarea id="wpvs-custom-video-js-code" name="wpvs-custom-video-js-code" rows="5" cols="20"><?php echo $wpvs_custom_video_js; ?></textarea>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Shortcode -->
    <div id="shortcode-type-option" class="rvs-type-area <?=($rvs_video_type == 'shortcode') ? 'rvs-display-area' : '' ?> ">
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter Video Shortcode:</label></th>
                <td><input type="text" class="wpvs-input-url" name="wpvs-video-shortcode" id="wpvs-video-shortcode" class="regular-text" placeholder="[shortcode attr=example]" value="<?php echo htmlentities($rvs_shortcode_video); ?>" /><br><br>
                <em>Using a shortcode may require custom CSS for your video player.</em>
                </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

    <div class="rvs-video-container border-box rvs-container rvs-box">
        <h4><?php _e('Video Preview', 'wpvs-theme'); ?></h4>
        <p>If you are using a <strong>Custom</strong> video player, you may need to Update / Save then refresh the page to see a preview.</p>
        <div id="currentRVSVideo" class="rvs-responsive-video">
            <?php
                if( $rvs_video_type == "wordpress" && ! empty($rvs_wordpress_code) ) {
                    echo do_shortcode($rvs_wordpress_code);
                }
                if($rvs_video_type == "shortcode" && ! empty($rvs_shortcode_video) ) {
                    if(! empty($rvs_shortcode_video_check) && shortcode_exists($rvs_shortcode_video_check)) {
                        echo do_shortcode($rvs_shortcode_video);
                    } else {
                        _e('Something is wrong with your Shortcode', 'wpvs-theme');
                    }
                }
                if( ($rvs_video_type == "custom" || $rvs_video_type == "jwplayer") && ! empty($rvs_custom_video_code) ) {
                    echo $rvs_custom_video_code;
                }

                if($rvs_video_type == "vimeo") {
                    $vimeo_video_html = '<div id="wpvs-vimeo-video" class="wpvs-vimeo-video-player" data-vimeo-id="'.$vimeo_id.'"></div>';
                    echo $vimeo_video_html;
                }
                if( $rvs_video_type == "youtube" && ! empty($vimeo_video_html) ) {
                    echo $vimeo_video_html;
                }
            ?>
        </div>
    </div>
    <textarea name="new-video-html" id="new-video-html" class="rvs-hidden-code"><?php echo $vimeo_video_html; ?></textarea>
<?php if( ! has_post_thumbnail($post->ID) && ! empty($wpvs_featured_image)) { ?>
    <script>
        var temp_thumbnail = '<?php echo $wpvs_featured_image; ?>';
        jQuery(document).ready( function() {
            var wpvs_set_temp_featured;
            var wpvs_set_temp_check = 5;
            wpvs_set_temp_featured = setInterval(function() {
                if(wpvs_set_temp_check > 0) {
                    if(jQuery('.editor-post-featured-image').length > 0) {
                        jQuery('.editor-post-featured-image').before('<img id="wpvs-vimeo-featured-image" src="'+temp_thumbnail+'"/>');
                        clearInterval(wpvs_set_temp_featured);
                    } else {
                        wpvs_set_temp_check--;
                    }
                } else {
                     clearInterval(wpvs_set_temp_featured);
                }
            }, 500);

            jQuery('body').delegate('.editor-post-featured-image__toggle', 'click', function() {
                if ( jQuery('#wpvs-vimeo-featured-image').length > 0 ) {
                   jQuery('#wpvs-vimeo-featured-image').remove();
                }
            });
        });

    </script>
<?php }
}

function wpvs_theme_video_meta_order() {
    global $post;
    $wpvs_video_order = get_post_meta($post->ID, 'rvs_video_post_order', true);
    if( empty($wpvs_video_order) ) {
        $wpvs_video_order = 0;
    }
    wp_nonce_field( 'rvs_video_order_save', 'rvs_video_order_save_nonce' );
?>
    <div class="inside">
        <label><?php _e('Order', 'wpvs-theme'); ?></label>:<br><br>
        <input name="rvs-video-order" type="number" min="0" max="99999" value="<?php echo $wpvs_video_order; ?>" /><br>
    </div>
<?php
}

function wpvs_theme_video_meta_information() {
    global $post;
    global $wpvs_theme_rating_icons;
    wp_nonce_field( 'wpvideos_information_save', 'wpvideos_information_save_nonce' );
    $wpvs_video_information = get_post_meta($post->ID, 'wpvs_video_information', true);
    $wpvs_video_length = get_post_meta($post->ID, 'wpvs_video_length', true);

    if( empty($wpvs_video_length) ) {
        $wpvs_video_length = 0;
    }

    $wpvs_video_hours = intval(gmdate("H", $wpvs_video_length));
    $wpvs_video_minutes = intval(gmdate("i", $wpvs_video_length));

    if( empty($wpvs_video_information) ) {
        $wpvs_video_information = array(
            'length' => $wpvs_video_length,
            'hours' => $wpvs_video_hours,
            'minutes' => $wpvs_video_minutes,
            'date_released' => '',
            'rating' => '',
        );
    } else {
        if( ! isset($wpvs_video_information['length']) ) {
            $wpvs_video_information['length'] = $wpvs_video_length;
        }
        if( ! isset($wpvs_video_information['hours']) ) {
            $wpvs_video_information['hours'] = $wpvs_video_hours;
        }
        if( ! isset($wpvs_video_information['minutes']) ) {
            $wpvs_video_information['minutes'] = $wpvs_video_minutes;
        }
        if( ! isset($wpvs_video_information['date_released']) ) {
            $wpvs_video_information['date_released'] = '';
        }
        if( ! isset($wpvs_video_information['rating']) ) {
            $wpvs_video_information['rating'] = '';
        }
    }
?>
    <div class="border-box rvs-container">
        <div class="col-4">
            <h4>Video Length:</h4>
            <input type="number" min="0" max="100" id="wpvideo-video-hours" name="wpvs_video_information[hours]" value="<?php echo $wpvs_video_information['hours']; ?>" />
            <label>Hour(s):</label>
            <input type="number" min="0" max="59" id="wpvideo-video-minutes" name="wpvs_video_information[minutes]" value="<?php echo $wpvs_video_information['minutes']; ?>" />
            <label>Minutes:</label>
            <input type="hidden" id="wpvideo-video-length" name="wpvs_video_information[length]" value="<?php echo $wpvs_video_information['length']; ?>" />
        </div>
        <div class="col-4">
            <h4>Release Date:</h4>
            <input type="text" id="wpvideo-video-release-date" name="wpvs_video_information[date_released]" value="<?php echo $wpvs_video_information['date_released']; ?>" placeholder="<?php echo date('Y'); ?>" />
        </div>
        <div class="col-4">
            <h4><?php _e('Rating', 'wpvs-theme'); ?></h4>
            <div class="wpvs-rating-select <?php if( empty($wpvs_video_information['rating']) ) { echo 'selected-rating'; } ?>">
                <label class="wpvs-rating-icon remove-rating"><?php _e('None', 'wpvs-theme'); ?>
                <input type="radio" name="wpvs_video_information[rating]" value="none" />
                </label>
            </div>
            <?php if( ! empty($wpvs_theme_rating_icons) ) {
                foreach($wpvs_theme_rating_icons as $r_key => $rating_icon) { ?>
                <div class="wpvs-rating-select <?php if( $wpvs_video_information['rating'] == $r_key ) { echo 'selected-rating'; } ?>">
                    <label class="wpvs-rating-icon"><?php echo $rating_icon; ?>
                    <input type="radio" name="wpvs_video_information[rating]" value="<?php echo $r_key; ?>" />
                    </label>
                </div>
            <?php } } ?>
        </div>
    </div>
<?php
}


function wpvs_featured_area_select_options( $post ) {
    wp_nonce_field( 'rogue_slider_save', 'rogue_slider_save_nonce' );
    wp_enqueue_style('wpvs-theme-admin-css');
    wp_enqueue_script('net-admin-video-js', get_template_directory_uri() . '/js/admin-video.js', array('jquery'), '', true );
    wp_localize_script( 'net-admin-video-js', 'rvsajax',
        array( 'url' => admin_url( 'admin-ajax.php' )
    ));

    // GET HOME PAGE DATA

    $sliderId = get_post_meta( $post->ID, 'wpvs_featured_area_slider', true );
    $wpvs_page_featured_area_type = get_post_meta( $post->ID, 'wpvs_featured_area_slider_type', true );
    if( empty($wpvs_page_featured_area_type) ) {
        $wpvs_page_featured_area_type = "none";
    }
    $sliders = get_option('wpvs_slider_array');

    $wpvs_featured_shortcode = get_post_meta( $post->ID, 'wpvs_featured_shortcode', true );
    if( empty($wpvs_featured_shortcode) ) {
        $wpvs_featured_shortcode = "";
    }
    ?>
    <div class="inside">
        <ul class="categorychecklist form-no-clear">
            <li><label class="selectit"><input type="radio" name="wpvs-slider-type" value="default" <?php checked('default', $wpvs_page_featured_area_type); ?>/> Slider</label></li>
            <li><label class="selectit"><input type="radio" name="wpvs-slider-type" value="shortcode" <?php checked('shortcode', $wpvs_page_featured_area_type); ?>/> Shortcode</label></li>
            <li><label class="selectit"><input type="radio" name="wpvs-slider-type" value="none" <?php checked('none', $wpvs_page_featured_area_type); ?>/> None</label></li>
        </ul>
    </div>
    <div id="wpvs-select-featured-slider" class="wpvs-select-featured-type <?=($wpvs_page_featured_area_type == "default") ? 'wpvs-show-featured-select' : ''?>">
        <label for="rogue_slider_select"><?php _e('Slider:', 'wpvs-theme'); ?> </label>
        <select id="rogue_slider_select"  name="rogue_slider_select">
            <?php
                if( ! empty($sliders) ) {
                    foreach($sliders as $slider) {
                        echo '<option value="'.$slider['id'].'"' . selected( $slider['id'],$sliderId ) . ' >'.$slider['name'].'</option>';
                    }
                }
            ?>
        </select>
    </div>

    <div id="wpvs-set-featured-shortcode" class="wpvs-select-featured-type <?=($wpvs_page_featured_area_type == "shortcode") ? 'wpvs-show-featured-select' : ''?>">
        <label><?php _e('Shortcode:', 'wpvs-theme'); ?> </label><br>
        <input type="text" name="wpvs-featured-shortcode" value="<?php echo htmlentities2($wpvs_featured_shortcode); ?>" placeholder="Paste shortcode..." />
    </div>

<?php }


function wpvs_video_homepage_options( $post ) {
    wp_nonce_field( 'rvs_home_page_options_save', 'rvs_home_page_options_save_nonce' );
    $post_categories = wp_get_post_terms( $post->ID, 'rvs_video_category', array( 'fields' => 'all', 'orderby' => 'term_id' ));
    $video_home_link = get_post_meta($post->ID, 'rvs_video_home_link', true);
    $video_custom_url = get_post_meta($post->ID, 'wpvs_video_custom_slide_link', true);
    $wpvs_open_video_in_new_tab = get_post_meta($post->ID, 'wpvs_open_video_in_new_tab', true);
    if(empty($video_home_link)) {
        $video_home_link = 'video';
    }
    if( empty($video_custom_url) ) {
        $video_custom_url = "";
    }
    if( $wpvs_open_video_in_new_tab == null ) {
        $wpvs_open_video_in_new_tab = 0;
    }
    $hide_on_home = get_post_meta($post->ID, 'rvs_hide_on_home', true);
    $hide_from_recently_added = get_post_meta($post->ID, 'wpvs_hide_from_recently_added', true);
?>
<h4><?php _e('Hide on homepage sliders', 'wpvs-theme'); ?>:</h4>
<label class="selectit"><input type="checkbox" name="rvs_hide_on_home" value="1" <?php checked($hide_on_home, "1"); ?>/><?php _e('Hide on Homepage', 'wpvs-theme'); ?></label><br>
<label class="selectit"><input type="checkbox" name="wpvs_hide_from_recently_added" value="1" <?php checked($hide_from_recently_added, "1"); ?>/><?php _e('Hide from Recently Added', 'wpvs-theme'); ?></label>
<?php
    global $wpvs_genre_slug_settings; ?>
    <h4><?php _e('Slide Links to', 'wpvs-theme'); ?>:</h4>
    <ul class="categorychecklist form-no-clear">
        <li><label class="selectit"><input type="radio" name="rvs_video_home_link" value="video" <?php checked('video', $video_home_link); ?>/><?php _e('Video Page', 'wpvs-theme'); ?></label></li>
    <?php
    if( ! empty($post_categories) ) {
        foreach($post_categories as $vid_cat) { ?>
            <li><label class="selectit"><input type="radio" name="rvs_video_home_link" value="<?php echo $vid_cat->term_id; ?>" <?php checked($vid_cat->term_id, $video_home_link); ?>/><?php echo $vid_cat->name;?></label></li>
        <?php
        }
    }
    ?>
        <li><label class="selectit"><input type="radio" name="rvs_video_home_link" value="customurl" <?php checked('customurl', $video_home_link); ?>/><?php _e('Custom URL', 'wpvs-theme'); ?></label></li>
    </ul>
    <h4><?php _e('Custom URL', 'wpvs-theme'); ?>:</h4>
    <input type="text" name="wpvs_video_custom_slide_link" value="<?php echo $video_custom_url; ?>" placeholder="/custom-url" /><br><br>
    <label class="selectit"><input type="checkbox" name="wpvs_open_video_in_new_tab" value="1" <?php checked(1, $wpvs_open_video_in_new_tab); ?> /><?php _e('Open in new tab', 'wpvs-theme'); ?></label>
   <?php
 }

function wpvs_theme_page_settings_callback( $post ) {
    wp_nonce_field( 'wpvs_theme_page_settings_save', 'wpvs_theme_page_settings_save_nonce' );
    $remove_top_spacing = get_post_meta($post->ID, '_vs_top_spacing', true);
    $wpvs_page_slider = get_post_meta( $post->ID, 'wpvs_featured_area_slider', true );
    $wpvs_page_show_featured_image = get_post_meta( $post->ID, 'wpvs_page_show_featured_image', true );
    $wpvs_page_show_title = get_post_meta( $post->ID, 'wpvs_page_show_title', true );
?>
    <div class="wpvs-theme-metabox-option">
        <label class="selectit">
            <input type="checkbox" name="wpvs_theme_page_hide_top_spacing" value="1" <?php checked($remove_top_spacing, "1"); ?>/><?php _e('Remove Top Header Spacing', 'wpvs-theme'); ?>
        </label>
    </div>
    <div class="wpvs-theme-metabox-option">
        <label class="selectit">
            <input type="checkbox" name="wpvs_theme_page_show_featured_image" value="1" <?php checked($wpvs_page_show_featured_image, "1"); ?>/><?php _e('Show Featured Image', 'wpvs-theme'); ?>
        </label>
    </div>
    <div class="wpvs-theme-metabox-option">
        <label class="selectit">
            <input type="checkbox" name="wpvs_theme_page_show_title" value="1" <?php checked($wpvs_page_show_title, "1"); ?>/><?php _e('Show Page Title', 'wpvs-theme'); ?>
        </label>
    </div>
<?php
}

function wpvs_theme_trailer_video_setup_meta( $post ) {
    $wpvs_theme_directory = get_template_directory_uri();
    $wpvs_trailer_js_editor = wp_enqueue_code_editor( array( 'type' => 'text/javascript') );
    $wpvs_custom_trailer_html_editor = wp_enqueue_code_editor( array( 'type' => 'text/html') );
    wp_enqueue_style('wpvs-admin-video-editing-css');
    wp_enqueue_script( 'rvs-trailer-js', $wpvs_theme_directory . '/js/trailer-video.js', array('jquery','wpvs-theme-video-post-js'), '', true);
    wp_localize_script( 'rvs-trailer-js', 'wpvstrailerpost', array( 'code_mirror_trailer_js' => wp_json_encode( $wpvs_trailer_js_editor ), 'code_mirror_trailer_html' => wp_json_encode( $wpvs_custom_trailer_html_editor )));
    wp_enqueue_script( 'rvs-trailer-upload', $wpvs_theme_directory . '/js/admin/rvs-trailer-upload.js', array('jquery'), '', true);
    wp_nonce_field( 'rvs_trailer_meta_save', 'rvs_trailer_meta_save_nonce' );
    $wpvs_video_trailer_enabled = get_post_meta($post->ID, 'rvs_trailer_enabled', true);
    $wpvs_show_background_trailer = get_post_meta($post->ID, 'wpvs_show_background_trailer', true);

    // GET TRAILER TYPE
    $rvs_trailer_type = get_post_meta($post->ID, '_rvs_trailer_type', true);
    if(empty($rvs_trailer_type)) {
        $rvs_trailer_type = "vimeo";
    }

    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "wpvs-custom-trailer-js-code", %s ); } );',
            wp_json_encode( $wpvs_trailer_js_editor )
        )
    );
    wp_add_inline_script('code-editor',
    sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "custom-trailer-code", %s ); } );',
            wp_json_encode( $wpvs_custom_trailer_html_editor )
        )
    );

    // JW PLAYER
    $wpvs_jw_trailer_media_id = get_post_meta($post->ID, '_jw_trailer_media_id', true);
    if( empty($wpvs_jw_trailer_media_id) ) {
        $wpvs_jw_trailer_media_id = '';
    }

    // WORDPRESS
    $rvs_trailer_wordpress_id = get_post_meta($post->ID, 'rvs_trailer_wordpress_id', true);
    $rvs_trailer_wordpress_code = get_post_meta($post->ID, 'rvs_trailer_wordpress_code', true);

    // VIMEO
    $trailer_vimeo_id = get_post_meta($post->ID, 'rvs_trailer_vimeo_id', true);

    // GET VIDEO HTML
    $rvs_trailer_html = get_post_meta($post->ID, 'rvs_trailer_html', true);

    // YOUTUBE
    $rvs_trailer_youtube_url = get_post_meta($post->ID, 'rvs_trailer_youtube_url', true);

    // CUSTOM
    $rvs_trailer_custom_code = get_post_meta($post->ID, 'rvs_trailer_custom_code', true);
    if( empty($rvs_trailer_custom_code) ) {
        $rvs_trailer_custom_code = "";
    }
    $wpvs_custom_trailer_js = get_post_meta($post->ID, 'wpvs_custom_trailer_js', true);
    if( empty($wpvs_custom_trailer_js) ) {
        $wpvs_custom_trailer_js = "";
    }

    ?>
    <div id="trailer-type" class="rvs-container rvs-box rvs-video-container border-box">
        <label class="rvs-label">Select Trailer Type:</label>
        <select id="select-trailer-type" name="select-trailer-type">
            <option value="vimeo" <?php selected("vimeo", $rvs_trailer_type); ?>>Vimeo</option>
            <option value="jwplayer" <?php selected("jwplayer", $rvs_trailer_type); ?>><?php _e('JW Player', 'wpvs-theme'); ?></option>
            <option value="wordpress" <?php selected("wordpress", $rvs_trailer_type); ?>>WordPress</option>
            <option value="youtube" <?php selected("youtube", $rvs_trailer_type); ?>>YouTube</option>
            <option value="custom" <?php selected("custom", $rvs_trailer_type); ?>>Custom</option>

        </select>
        <div id="rvs-enabled-trailer">
            <div class="wpvs-admin-settings-checkbox">
                <?php _e('Show Trailer', 'wpvs-theme'); ?> <input type="checkbox" name="rvs-trailer-enabled" id="rvs-trailer-enabled" value="1" <?php checked(1,$wpvs_video_trailer_enabled); ?> />
            </div>
            <div class="wpvs-admin-settings-checkbox">
                <?php _e('Show Background Trailer', 'wpvs-theme'); ?> <input type="checkbox" name="wpvs-show-background-trailer"  value="1" <?php checked(1,$wpvs_show_background_trailer); ?> />
                <br>
                <small><em><?php _e('Background Trailers currently restricted to WordPress Trailers only', 'wpvs-theme'); ?></em></small>
            </div>
        </div>
    </div>

    <!-- VIMEO -->
    <div id="trailer-vimeo-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'vimeo') ? 'rvs-display-area' : '' ?>">
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label"><?php _e('Enter Vimeo ID', 'wpvs-theme'); ?>:</label></th>
                <td><input type="url" class="wpvs-input-url" name="wpvs_vimeo_trailer_id" id="wpvs_vimeo_trailer_id" class="regular-text" placeholder="Paste Vimeo Id here..." value="<?php echo esc_attr($trailer_vimeo_id); ?>" /></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div><!-- END VIMEO -->

    <!-- JW Player -->
    <div id="trailer-jwplayer-type-option" class="rvs-type-area <?=($rvs_trailer_type == 'jwplayer') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <a href="https://wpvideosubscriptions.zendesk.com/hc/en-us/articles/360049934934" class="rvs-button" rel="help" target="_blank"><?php _e('JW Player Setup Guide', 'wpvs-theme'); ?></a>
        </div>
    </div><!-- END JW Player -->

    <!-- WORDPRESS -->
    <div id="trailer-wordpress-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'wordpress') ? 'rvs-display-area' : '' ?>">
        <div class="text-align-right rvs-box rvs-video-container border-box">
            <label id="choose-wordpress-trailer" class="rvs-button">Choose Video</label>
        </div>
        <input type="hidden" value="<?php echo $rvs_trailer_wordpress_id; ?>" id="rvs-trailer-wordpress-id" name="rvs-trailer-wordpress-id" />
        <textarea name="rvs-trailer-wordpress-code" id="rvs-trailer-wordpress-code" class="rvs-hidden-code"><?php echo $rvs_trailer_wordpress_code; ?></textarea>
    </div><!-- END WORDPRESS -->

    <!-- YouTube -->
    <div id="trailer-youtube-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'youtube') ? 'rvs-display-area' : '' ?> ">
        <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                <th scope="row"><label class="rvs-label">Enter YouTube URL:</label></th>
                <td><input type="url" name="trailer-youtube-video-url" id="trailer-youtube-video-url" class="regular-text" placeholder="Paste YouTube link here..." value="<?php echo $rvs_trailer_youtube_url; ?>" /></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

    <!-- Custom -->
    <div id="trailer-custom-type-option" class="rvs-trailer-type-area <?=($rvs_trailer_type == 'custom' || $rvs_trailer_type == 'jwplayer') ? 'rvs-display-area' : '' ?>">
        <div class="rvs-box rvs-video-container border-box">
            <table class="form-table">
                <tbody>
                    <tr id="wpvs-jw-player-trailer-media-id-input" class="<?=($rvs_trailer_type == 'custom') ? 'rvs-hidden-code' : '' ?>">
                        <td>
                            <h4><?php _e('Media ID', 'wpvs-theme'); ?></h4>
                            <input type="text" class="wpvs-input-url" name="wpvs_jw_trailer_media_id" class="regular-text" placeholder="JW Player Media ID" value="<?php echo $wpvs_jw_trailer_media_id; ?>" />
                        </td>
                    </tr>
                    <tr>
                    <td>
                        <h4>Paste embed / iframe / html code:</h4>
                        <textarea name="custom-trailer-code" rows="5" cols="10" id="custom-trailer-code"><?php echo $rvs_trailer_custom_code; ?></textarea></td>
                    </tr>
                    <td>
                        <h4>Custom player javascript (optional):</h4>
                        <p class="description">Javascript code here should be video specific. If you need global JS / CSS files or code for all your custom player videos, add them on the <a href="<?php echo admin_url('admin.php?page=wpvs-custom-player-settings'); ?>" title="Custom Player Settings" >Custom Player</a> page.</p><br>
                        <textarea id="wpvs-custom-trailer-js-code" name="wpvs-custom-trailer-js-code" rows="5" cols="20" ><?php echo $wpvs_custom_trailer_js; ?></textarea>
                    </td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="rvs-video-container border-box rvs-container rvs-box">
        <div id="rvs-trailer-video-holder" class="rvs-responsive-video">
            <h4><?php _e('Trailer Preview', 'wpvs-theme'); ?></h4>
            <p>If you are using a <strong>Custom</strong> video player, you may need to Update / Save then refresh the page to see a preview.</p>
            <?php
                if( $rvs_trailer_type == "wordpress" && ! empty($rvs_trailer_wordpress_code) ) {
                    echo do_shortcode($rvs_trailer_wordpress_code);
                }
                if( ($rvs_trailer_type == "custom" || $rvs_trailer_type == "jwplayer") && ! empty($rvs_trailer_custom_code) ) {
                    echo $rvs_trailer_custom_code;
                }
                if( $rvs_trailer_type == "vimeo" ) {
                    $rvs_trailer_html = '<div id="wpvs-vimeo-trailer" class="wpvs-vimeo-video-player" data-vimeo-id="'.$trailer_vimeo_id.'"></div>';
                    echo $rvs_trailer_html;
                }
                if( ($rvs_trailer_type == "youtube") && ! empty($rvs_trailer_html) ) {
                    echo $rvs_trailer_html;
                }
            ?>
        </div>
    </div>

    <textarea name="new-trailer-html" id="new-trailer-html" class="rvs-hidden-code"><?php echo $rvs_trailer_html; ?></textarea>
<?php }


function wpvs_video_thumbnail_image( $post ) {
    global $wpvs_theme_thumbnail_sizing;
    wp_nonce_field( 'wpvs_video_image_settings_save', 'wpvs_video_image_settings_save_nonce' );
    wp_enqueue_media();
    wp_enqueue_script('wpvs-video-image-upload');
    wp_localize_script( 'wpvs-video-image-upload', 'wpvsimageloader',
        array( 'thumbnail' => $wpvs_theme_thumbnail_sizing->layout)
    );

    $video_thumbnail_image = get_post_meta($post->ID, 'rvs_thumbnail_image', true);
    if( empty($video_thumbnail_image) ) {
        $video_thumbnail_image = "";
    }
    $video_thumbnail_image_id = get_post_meta($post->ID, 'wpvs_thumbnail_image_id', true);
    if( empty($video_thumbnail_image_id) ) {
        $video_thumbnail_image_id = "";
    }
?>
<p>The thumbnail image is used for video sliders and video browsing pages.</p>
<p>Allows you to set a different Featured Image for the video page. Recommended if using the <a href="<?php echo admin_url('customize.php'); ?>">Netflix video page layout</a>.</p>
<p>You can customize your thumbnail size under <strong>Video Browsing</strong> in the <a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Customizer', 'wpvs-theme'); ?></a> area.</p>
<p><strong>Recommend size:</strong> <em><?php echo $wpvs_theme_thumbnail_sizing->recommended_size; ?></em></p>
<div class="wpvs-choose-image-container">
    <div class="wpvs-thumbnail-image-container">
        <?php if( ! empty($video_thumbnail_image) ) : ?>
            <img id="rvs-set-thumbnail-image" class="wpvs-set-image" src="<?php echo $video_thumbnail_image; ?>" />
        <?php endif; ?>
    </div>
    <label class="wpvs-select-image button button-primary">Select Image</label>
    <label class="wpvs-remove-selected-image button button-primary">Remove</label>
    <input type="hidden" name="rvs_thumbnail_image" class="wpvs-set-selected-image" value="<?php echo $video_thumbnail_image; ?>"/>
    <input type="hidden" name="wpvs_thumbnail_image_id" class="wpvs-set-selected-image-id" value="<?php echo $video_thumbnail_image_id; ?>"/>
</div>
<?php }

// Title Image Meta Box

function wpvs_theme_video_title_image( $post ) {
    global $post;
    $video_title_image = get_post_meta($post->ID, 'wpvs_title_image', true);
    if( empty($video_title_image) ) {
        $video_title_image = "";
    }
    $video_title_image_id = get_post_meta($post->ID, 'wpvs_title_image_id', true);
    if( empty($video_title_image_id) ) {
        $video_title_image_id = "";
    }
?>
<p class="description"><?php _e('The Title Image allows you to set an image that displays above the video description', 'wpvs-theme' ); ?>.</p>
<div class="wpvs-choose-image-container">
    <div class="wpvs-thumbnail-image-container">
        <?php if( ! empty($video_title_image) ) : ?>
            <img class="wpvs-set-image" src="<?php echo $video_title_image; ?>" />
        <?php endif; ?>
    </div>
    <label class="wpvs-select-image button button-primary">Select Image</label>
    <label class="wpvs-remove-selected-image button button-primary">Remove</label>
    <input type="hidden" name="wpvs_video_title_image" class="wpvs-set-selected-image" value="<?php echo $video_title_image; ?>"/>
    <input type="hidden" name="wpvs_video_title_image_id" class="wpvs-set-selected-image-id" value="<?php echo $video_title_image_id; ?>"/>
</div>
<?php }

function wpvs_video_thumbnail_label_admin_meta_box( $post ) {
    global $post;
    $video_thumbnail_label = get_post_meta($post->ID, 'wpvs_thumbnail_label', true);
    if( empty($video_thumbnail_label) ) {
        $video_thumbnail_label = "";
    }
?>
<div>
    <label><?php _e('Label Text', 'wpvs-theme'); ?> </label><br>
    <input type="text" name="wpvs_thumbnail_label" value="<?php echo $video_thumbnail_label; ?>"/>
</div>
<?php }

// CUSTOM VIDEO TEMPLATE
function wpvs_video_template_option_meta( $post ) {
    wp_nonce_field( 'rvs_video_template_save', 'rvs_video_template_save_nonce' );
    $rvs_video_template = get_post_meta($post->ID, 'rvs_video_template', true);
    if(empty($rvs_video_template)) {
        $rvs_video_template = "default";
    }
?>
<p>Use a specific video page layout.</p><p><strong>Use Default</strong> uses <a href="<?php echo admin_url('customize.php?autofocus[section]=vs_single_video'); ?>" target="_blank">Single Video</a> setting.</p>
<select name="rvs_video_template">
    <option value="default" <?php selected($rvs_video_template, "default"); ?>>Use Default</option>
    <option value="standard" <?php selected($rvs_video_template, "standard"); ?>>Standard</option>
    <option value="netflix" <?php selected($rvs_video_template, "netflix"); ?>>Netflix</option>
    <option value="youtube" <?php selected($rvs_video_template, "youtube"); ?>>YouTube</option>
</select>
<?php }

function wpvs_theme_audio_meta_settings() {
    global $post;
    wp_nonce_field( 'wpvs_audio_file_meta_save', 'wpvs_audio_file_meta_save_nonce' );
    $wpvs_audio_file_url = get_post_meta($post->ID, 'wpvs_audio_file_url', true);
    $wpvs_audio_wordpress_id = get_post_meta($post->ID, 'wpvs_audio_wordpress_id', true);
    $wpvs_audio_custom_html = get_post_meta($post->ID, 'wpvs_audio_custom_html', true);
    if( empty($wpvs_audio_file_url) ) {
        $wpvs_audio_file_url = "";
    }
    if( empty($wpvs_audio_wordpress_id) ) {
        $wpvs_audio_wordpress_id = "";
    }
    if( empty($wpvs_audio_custom_html) ) {
        $wpvs_audio_custom_html = "";
    }
    ?>
    <!-- AUDIO -->
    <div class="rvs-container rvs-box rvs-video-container border-box">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label class="rvs-label">Audio File URL:</label></th>
                    <td>
                        <input type="url" class="wpvs-input-url regular-text" name="wpvs_audio_file_url" id="wpvs_audio_file_url"  placeholder="Add audio file url..." value="<?php echo $wpvs_audio_file_url; ?>" />
                        <input type="hidden" name="wpvs_audio_wordpress_id" id="wpvs_audio_wordpress_id" value="<?php echo $wpvs_audio_wordpress_id; ?>" />
                    </td>
                    <td><span id="wpvs_select_audio_file" class="rvs-button">Choose Audio File</span></td>
                </tr>
                <tr>
                    <th scope="row"><label class="rvs-label">Audio HTML (Embed):</label></th>
                    <td>
                        <textarea name="wpvs_audio_custom_html" class="large-text code"><?php echo $wpvs_audio_custom_html; ?></textarea>
                    </td>
                </tr>

            </tbody>
        </table>
    </div><!-- END AUDIO -->
<?php
}

function wpvs_save_rvs_video_meta_data_admin( $post_id ) {

    // SAVE VIDEO SETTINGS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'rvs_video_meta_save_nonce', 'rvs_video_meta_save' )) {

        // SAVE VIDEO HTML
        if ( isset( $_POST['new-video-html'] ) ) {
            $new_video_html = $_POST['new-video-html'];
            update_post_meta($post_id, 'rvs_video_post_vimeo_html', $new_video_html);
        }

        // SAVE VIDEO TYPE
        if ( isset( $_POST['select-video-type'] ) ) {
            $save_video_type = $_POST['select-video-type'];
            update_post_meta( $post_id, '_rvs_video_type', $save_video_type);
        }

        // SAVE VIDEO TYPE
        if ( isset( $_POST['wpvs_video_vimeo_id'] ) ) {
            $save_vimeo_id = $_POST['wpvs_video_vimeo_id'];
            update_post_meta( $post_id, 'rvs_video_post_vimeo_id', $save_vimeo_id);
        }

        if ( isset( $_POST['wpvs_jw_media_id'] ) ) {
            $new_jw_media_id = $_POST['wpvs_jw_media_id'];
            update_post_meta($post_id, '_jw_media_id', $new_jw_media_id);
        }

        if ( isset( $_POST['youtube-video-url'] ) ) {
            $new_youtube_url = $_POST['youtube-video-url'];
            update_post_meta($post_id, 'rvs_youtube_url', $new_youtube_url);
        }

        if ( isset( $_POST['custom-video-code'] ) ) {
            $new_custom_code = $_POST['custom-video-code'];
            update_post_meta($post_id, 'rvs_video_custom_code', $new_custom_code);
        }

        if ( isset( $_POST['wpvs-custom-video-js-code'] ) ) {
            $new_custom_video_js_code = $_POST['wpvs-custom-video-js-code'];
            update_post_meta($post_id, 'wpvs_custom_video_js', $new_custom_video_js_code);
        }

        if ( isset( $_POST['rvs-wordpress-id'] ) ) {
            $new_wordpress_video_id = $_POST['rvs-wordpress-id'];
            update_post_meta($post_id, 'rvs_video_wordpress_id', $new_wordpress_video_id);
        }

        if ( isset( $_POST['rvs-wordpress-code'] ) ) {
            $new_wordpress_video_code = $_POST['rvs-wordpress-code'];
            update_post_meta($post_id, 'rvs_video_wordpress_code', $new_wordpress_video_code);
        }

        if ( isset( $_POST['wpvs-video-shortcode'] ) ) {
            $new_shortcode_video_text = sanitize_text_field($_POST['wpvs-video-shortcode']);
            update_post_meta($post_id, 'rvs_shortcode_video', $new_shortcode_video_text);
            $new_shortcode_check = explode(" ", $new_shortcode_video_text);
            $shortcode_check_first = $new_shortcode_check[0];
            if (strpos($shortcode_check_first, '[') !== false) {
                $new_shortcode_check = explode("[", $shortcode_check_first);
                if( isset($new_shortcode_check[1]) && ! empty($new_shortcode_check[1])) {
                    $new_shortcode_check = $new_shortcode_check[1];
                    update_post_meta($post_id, 'rvs_shortcode_video_check', $new_shortcode_check);
                }
            }
        }
    }

    // SAVE TRAILER SETTINGS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'rvs_trailer_meta_save_nonce', 'rvs_trailer_meta_save' )) {

        // SAVE VIDEO HTML
        if ( isset( $_POST['new-trailer-html'] ) ) {
            $new_trailer_html = $_POST['new-trailer-html'];
            update_post_meta($post_id, 'rvs_trailer_html', $new_trailer_html);
        }

        // SAVE VIDEO TYPE
        if ( isset( $_POST['select-trailer-type'] ) ) {
            $save_trailer_type = $_POST['select-trailer-type'];
            update_post_meta( $post_id, '_rvs_trailer_type', $save_trailer_type);
        }

        if ( isset( $_POST['wpvs_vimeo_trailer_id'] ) ) {
            $new_vimeo_trailer_id = $_POST['wpvs_vimeo_trailer_id'];
            update_post_meta($post_id, 'rvs_trailer_vimeo_id', $new_vimeo_trailer_id);
        }

        if ( isset( $_POST['trailer-youtube-video-url'] ) ) {
            $new_trailer_youtube_url = $_POST['trailer-youtube-video-url'];
            update_post_meta($post_id, 'rvs_trailer_youtube_url', $new_trailer_youtube_url);
        }

        if ( isset( $_POST['custom-trailer-code'] ) ) {
            $new_trailer_custom_code = $_POST['custom-trailer-code'];
            update_post_meta($post_id, 'rvs_trailer_custom_code', $new_trailer_custom_code);
        }

        if ( isset( $_POST['wpvs-custom-trailer-js-code'] ) ) {
            $new_custom_trailer_js_code = $_POST['wpvs-custom-trailer-js-code'];
            update_post_meta($post_id, 'wpvs_custom_trailer_js', $new_custom_trailer_js_code);
        }

        if ( isset( $_POST['rvs-trailer-enabled'] ) ) {
            update_post_meta($post_id, 'rvs_trailer_enabled', true);
        } else {
            update_post_meta($post_id, 'rvs_trailer_enabled', false);
        }

        if ( isset( $_POST['wpvs-show-background-trailer'] ) ) {
            update_post_meta($post_id, 'wpvs_show_background_trailer', true);
        } else {
            update_post_meta($post_id, 'wpvs_show_background_trailer', false);
        }

        if ( isset( $_POST['rvs-trailer-wordpress-id'] ) ) {
            $new_wordpress_trailer_id = $_POST['rvs-trailer-wordpress-id'];
            update_post_meta($post_id, 'rvs_trailer_wordpress_id', $new_wordpress_trailer_id);
        }

        if ( isset( $_POST['rvs-trailer-wordpress-code'] ) ) {
            $new_wordpress_trailer_code = $_POST['rvs-trailer-wordpress-code'];
            update_post_meta($post_id, 'rvs_trailer_wordpress_code', $new_wordpress_trailer_code);
        }

        if ( isset( $_POST['wpvs_jw_trailer_media_id'] ) ) {
            $new_jw_trailer_media_id = $_POST['wpvs_jw_trailer_media_id'];
            update_post_meta($post_id, '_jw_trailer_media_id', $new_jw_trailer_media_id);
        }
    }

    if(wpvs_theme_save_custom_meta_data( $post_id, 'wpvideos_information_save_nonce', 'wpvideos_information_save' )) {
        $new_video_length = 0;
        if ( isset( $_POST['wpvs_video_information'] ) ) {
            $new_video_information = $_POST['wpvs_video_information'];
            if ( isset( $new_video_information['hours'] ) ) {
                $new_video_hours = $new_video_information['hours'];
            }
            if ( isset( $new_video_information['minutes'] ) ) {
                $new_video_minutes = $new_video_information['minutes'];
            }
            if( ! empty($new_video_hours) ) {
                $add_hour_seconds = intval($new_video_hours)*3600;
                $new_video_length += $add_hour_seconds;
            }
            if( ! empty($new_video_minutes) ) {
                $add_minute_seconds = intval($new_video_minutes)*60;
                $new_video_length += $add_minute_seconds;
            }
            if( ! empty($new_video_length) ) {
                update_post_meta( $post_id, 'wpvs_video_length', $new_video_length);
                $new_video_information['length'] = $new_video_length;
            } else {
                update_post_meta( $post_id, 'wpvs_video_length', $new_video_length);
                $new_video_information['length'] = 0;
            }
            if ( isset( $new_video_information['rating'] ) ) {
                if( $new_video_information['rating'] == 'none' ) {
                    $new_video_information['rating'] = '';
                    update_post_meta( $post_id, 'wpvs_video_rating', '');
                } else {
                    update_post_meta( $post_id, 'wpvs_video_rating', $new_video_information['rating']);
                }
            }
            update_post_meta( $post_id, 'wpvs_video_information', $new_video_information);
        }
    }

    // SAVE AUDIO FILE DATA
    if(wpvs_theme_save_custom_meta_data( $post_id, 'wpvs_audio_file_meta_save_nonce', 'wpvs_audio_file_meta_save' )) {
        if( isset($_POST['wpvs_audio_file_url']) ) {
            update_post_meta( $post_id, 'wpvs_audio_file_url', sanitize_text_field($_POST['wpvs_audio_file_url']) );
        }
        if( isset($_POST['wpvs_audio_wordpress_id']) ) {
            update_post_meta( $post_id, 'wpvs_audio_wordpress_id', intval($_POST['wpvs_audio_wordpress_id']) );
        }
        if( empty($_POST['wpvs_audio_file_url']) ) {
            update_post_meta( $post_id, 'wpvs_audio_wordpress_id', 0 );
        }
        if ( isset( $_POST['wpvs_audio_custom_html'] ) ) {
            update_post_meta($post_id, 'wpvs_audio_custom_html', $_POST['wpvs_audio_custom_html']);
        }
    }

    // SAVE TEMPLATE SETTINGS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'rvs_video_template_save_nonce', 'rvs_video_template_save' )) {
        if(isset($_POST['rvs_video_template'])) {
            $new_rvs_video_template = $_POST['rvs_video_template'];
            update_post_meta( $post_id, 'rvs_video_template', $new_rvs_video_template );
        }
    }

    // SAVE SLIDER SETTINGS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'rogue_slider_save_nonce', 'rogue_slider_save' )) {
        if( isset($_POST['wpvs-slider-type']) ) {
            $new_slider_type = $_POST['wpvs-slider-type'];
            update_post_meta( $post_id, 'wpvs_featured_area_slider_type', $new_slider_type );
        }

        if( isset($_POST['rogue_slider_select']) ) {
            $newSliderId = $_POST['rogue_slider_select'];
            update_post_meta( $post_id, 'wpvs_featured_area_slider', $newSliderId );
        }

        if( isset($_POST['wpvs-featured-shortcode']) ) {
            $new_featured_shortcode = $_POST['wpvs-featured-shortcode'];
            update_post_meta( $post_id, 'wpvs_featured_shortcode', $new_featured_shortcode );
        }
    }

    // SAVE HOME PAGE OPTIONS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'rvs_home_page_options_save_nonce', 'rvs_home_page_options_save' )) {
        if(isset($_POST['rvs_hide_on_home'])) {
            update_post_meta( $post_id, 'rvs_hide_on_home', 1);
        } else {
            update_post_meta( $post_id, 'rvs_hide_on_home', 0);
        }

        if(isset($_POST['wpvs_hide_from_recently_added'])) {
            update_post_meta( $post_id, 'wpvs_hide_from_recently_added', 1);
        } else {
            update_post_meta( $post_id, 'wpvs_hide_from_recently_added', 0);
        }

        if( isset($_POST['rvs_video_home_link']) ) {
            $new_home_link = $_POST['rvs_video_home_link'];
            update_post_meta( $post_id, 'rvs_video_home_link', $new_home_link );
        } else {
            update_post_meta( $post_id, 'rvs_video_home_link', 'video');
        }

        if( isset($_POST['wpvs_video_custom_slide_link']) ) {
            update_post_meta( $post_id, 'wpvs_video_custom_slide_link', esc_attr($_POST['wpvs_video_custom_slide_link']));
        }
        if( isset($_POST['wpvs_open_video_in_new_tab']) ) {
            update_post_meta( $post_id, 'wpvs_open_video_in_new_tab', 1);
        } else {
            update_post_meta( $post_id, 'wpvs_open_video_in_new_tab', 0);
        }
    }

    // SAVE THEME PAGE SETTINGS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'wpvs_theme_page_settings_save_nonce', 'wpvs_theme_page_settings_save' )) {
        if(isset($_POST['wpvs_theme_page_hide_top_spacing'])) {
            update_post_meta( $post_id, '_vs_top_spacing', 1 );
        } else {
            update_post_meta( $post_id, '_vs_top_spacing', 0 );
        }
        if(isset($_POST['wpvs_theme_page_show_featured_image'])) {
            update_post_meta( $post_id, 'wpvs_page_show_featured_image', 1 );
        } else {
            update_post_meta( $post_id, 'wpvs_page_show_featured_image', 0 );
        }
        if(isset($_POST['wpvs_theme_page_show_title'])) {
            update_post_meta( $post_id, 'wpvs_page_show_title', 1 );
        } else {
            update_post_meta( $post_id, 'wpvs_page_show_title', 0 );
        }
    }

    // IMAGE SETTINGS
    if(wpvs_theme_save_custom_meta_data( $post_id, 'wpvs_video_image_settings_save_nonce', 'wpvs_video_image_settings_save' )) {
        if(isset($_POST['rvs_thumbnail_image'])) {
            $new_thumbnail_image = $_POST['rvs_thumbnail_image'];
            update_post_meta( $post_id, 'rvs_thumbnail_image', $new_thumbnail_image );
        }

        if(isset($_POST['wpvs_thumbnail_image_id'])) {
            $new_thumbnail_image_id = $_POST['wpvs_thumbnail_image_id'];
            update_post_meta( $post_id, 'wpvs_thumbnail_image_id', $new_thumbnail_image_id );
        }

        if(isset($_POST['wpvs_video_title_image'])) {
            $new_wpvs_video_title_image = $_POST['wpvs_video_title_image'];
            update_post_meta( $post_id, 'wpvs_title_image', $new_wpvs_video_title_image );
        }

        if(isset($_POST['wpvs_video_title_image_id'])) {
            $new_wpvs_video_title_image_id = $_POST['wpvs_video_title_image_id'];
            update_post_meta( $post_id, 'wpvs_title_image_id', $new_wpvs_video_title_image_id );
        }

        if(isset($_POST['wpvs_thumbnail_label'])) {
            update_post_meta( $post_id, 'wpvs_thumbnail_label', $_POST['wpvs_thumbnail_label']);
        }
    }

    // BULK EDIT SAVE
    if(wpvs_theme_save_custom_meta_data( $post_id, 'rvs_video_column_save_nonce', 'rvs_video_column_save' )) {
        if ( isset( $_REQUEST['rvs_video_post_order'] ) ) {
            update_post_meta( $post_id, 'rvs_video_post_order', $_REQUEST['rvs_video_post_order'] );
        }
    }

    if(wpvs_theme_save_custom_meta_data( $post_id, 'rvs_video_order_save_nonce', 'rvs_video_order_save' )) {
        if ( isset( $_REQUEST['rvs-video-order'] ) ) {
            update_post_meta( $post_id, 'rvs_video_post_order', $_REQUEST['rvs-video-order']);
        }
    }
}
add_action( 'save_post', 'wpvs_save_rvs_video_meta_data_admin' );
