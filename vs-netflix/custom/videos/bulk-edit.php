<?php

class WPVS_THEME_VIDEO_BULK_EDITOR {

    public function __construct() {
        add_filter('manage_rvs_video_posts_columns', array($this, 'wpvs_theme_create_custom_columns') );
        add_action('manage_rvs_video_posts_custom_column', [$this,'wpvs_theme_video_custom_columns_content'], 10, 2);
        add_action( 'quick_edit_custom_box', [$this, 'wpvs_theme_video_quick_edit_fields'], 10, 2 );
        add_action( 'save_post', [$this, 'wpvs_theme_video_quick_save_fields'] );
        add_action( 'bulk_edit_custom_box', [$this, 'wpvs_video_bulk_edit_fields'], 10, 2 );
        add_action( 'wp_ajax_wpvs_video_bulk_edit_save_fields', array($this, 'wpvs_video_bulk_edit_save_fields') );
    }

    public function wpvs_theme_create_custom_columns($columns) {
        global $wpvs_genre_slug_settings;
        return array_merge( $columns, array(
            'wpvs_video_category_column' => $wpvs_genre_slug_settings['name'],
            'rvs_video_post_order' => __('Order', 'wpvs-theme'),
            'wpvs_video_rating_column' => __('Rating', 'wpvs-theme'),
        ) );
    }

    function wpvs_theme_video_custom_columns_content($column_name, $video_id) {
        global $wpvs_theme_rating_icons;
        switch($column_name) {
            case 'wpvs_video_category_column':
                $wpvs_video_category_list = wp_get_post_terms($video_id, 'rvs_video_category');
                if( ! empty($wpvs_video_category_list) )  {
                    $last_term = end($wpvs_video_category_list);
                    echo '<div class="wpvs-video-category-column">';
                    foreach($wpvs_video_category_list as $wpvs_term) {
                        echo '<a href="'.get_edit_term_link($wpvs_term->term_id).'">'.$wpvs_term->name.'</a>';
                        if( $wpvs_term != $last_term ) {
                            echo ', ';
                        }
                    }
                    echo '</div>';
                }
            break;
            case 'rvs_video_post_order':
                $wpvs_video_order = get_post_meta($video_id, 'rvs_video_post_order', true);
                if( empty($wpvs_video_order) )  {
                    $wpvs_video_order = 0;
                }
                echo '<div class="wpvs-video-order-column">'.$wpvs_video_order.'</div>';
            break;
            case 'wpvs_video_rating_column':
                $wpvs_video_rating = get_post_meta($video_id, 'wpvs_video_rating', true);
                if( empty($wpvs_video_rating) )  {
                    echo '<div class="wpvs-video-rating-data" data-rating="none">'.__('None', 'wpvs-theme').'</div>';
                } else {
                    if( ! empty($wpvs_theme_rating_icons) ) {
                        echo '<div class="wpvs-video-rating-data" data-rating="'.$wpvs_video_rating.'">'.$wpvs_theme_rating_icons->$wpvs_video_rating.'</div>';
                    }
                }
            break;
        }
    }

    public function wpvs_theme_video_quick_edit_fields( $column_name, $post_type ) {
        if( $post_type == 'rvs_video' ) {
            wp_nonce_field( 'wpvs_video_quick_save_fields', 'wpvs_video_quick_save_fields_nonce' );
            if($column_name == 'wpvs_video_rating_column') { ?>
                <fieldset class="wpvs-bulk-edit-column inline-edit-video">
                    <div class="inline-edit-col column-'rvs_video_post_order_field'">
                      <div class="inline-edit-group">
                          <h4><?php _e('Order', 'wpvs-theme'); ?></h4>
                          <input type="number" min="0" name="rvs_video_post_order" />
                      </div>
                    </div>
                </fieldset>
            <?php }
            if($column_name == 'wpvs_video_rating_column') {
                global $wpvs_theme_rating_icons; ?>
                <fieldset class="wpvs-bulk-edit-column inline-edit-wpvs-video-rating">
                  <div class="inline-edit-col column-<?php echo $column_name; ?>">
                    <div class="inline-edit-group">
                        <h4><?php _e('Rating', 'wpvs-theme'); ?></h4>
                        <div class="wpvs-rating-select">
                            <label class="wpvs-rating-icon remove-rating"><?php _e('None', 'wpvs-theme'); ?>
                            <input type="radio" name="wpvs_video_rating" value="none" />
                            </label>
                        </div>
                        <?php if( ! empty($wpvs_theme_rating_icons) ) {
                            foreach($wpvs_theme_rating_icons as $r_key => $rating_icon) { ?>
                            <div class="wpvs-rating-select">
                                <label class="wpvs-rating-icon"><?php echo $rating_icon; ?>
                                <input type="radio" name="wpvs_video_rating" value="<?php echo $r_key; ?>" />
                                </label>
                            </div>
                        <?php } } ?>
                    </div>
                  </div>
                </fieldset>
        <?php }
        }
    }

    public function wpvs_theme_video_quick_save_fields( $video_id ) {
        if ( isset($_POST['post_type']) && $_POST['post_type'] == 'rvs_video' ) {
            if ( ! current_user_can( 'edit_post', $video_id ) ) {
                return;
            }
            if( isset($_POST['wpvs_video_quick_save_fields_nonce']) ) {
                if ( ! wp_verify_nonce( $_POST['wpvs_video_quick_save_fields_nonce'], 'wpvs_video_quick_save_fields' ) ) {
                    return;
                }

                // Save video order
                if ( isset( $_POST['rvs_video_post_order'] ) ) {
                    update_post_meta( $video_id, 'rvs_video_post_order', $_POST['rvs_video_post_order'] );
                }

                // Save video rating
                if( isset($_POST['wpvs_video_rating']) ) {
                    $wpvs_video_rating = $_POST['wpvs_video_rating'];
                    $wpvs_video_information = get_post_meta( $video_id, 'wpvs_video_information', true);
                    if( empty($wpvs_video_information) ) {
                        $wpvs_video_information = array(
                            'length' => 0,
                            'hours' => intval(gmdate("H", 0)),
                            'minutes' => intval(gmdate("i", 0)),
                            'date_released' => '',
                            'rating' => '',
                        );
                    }

                    if( $wpvs_video_rating == "none" ) {
                        $wpvs_video_information['rating'] = '';
                        update_post_meta( $video_id, 'wpvs_video_rating', '');
                    } else {
                        $wpvs_video_information['rating'] = $wpvs_video_rating;
                        update_post_meta( $video_id, 'wpvs_video_rating', $wpvs_video_rating);
                    }
                    update_post_meta( $video_id, 'wpvs_video_information', $wpvs_video_information);
                }
            }
        }
    }

    public function wpvs_video_bulk_edit_fields( $column_name, $post_type ) {
        global $post;
        if( $post_type == 'rvs_video' ) {
            if($column_name == 'wpvs_video_rating_column') {
                global $wpvs_theme_rating_icons; ?>
                <fieldset class="wpvs-bulk-edit-column inline-edit-wpvs-video-rating">
                    <?php wp_nonce_field( 'wpvs_bulk_video_ratings_save', 'wpvs_bulk_video_ratings_save_nonce' ); ?>
                    <div class="inline-edit-col column-<?php echo $column_name; ?>">
                        <div class="inline-edit-group">
                            <h4><?php _e('Rating', 'wpvs-theme'); ?></h4>
                                <div class="wpvs-rating-select">
                                    <label class="wpvs-rating-icon remove-rating"><?php _e('None', 'wpvs-theme'); ?>
                                    <input type="radio" name="wpvs_video_rating" value="none" />
                                    </label>
                                </div>
                            <?php if( ! empty($wpvs_theme_rating_icons) ) {
                                foreach($wpvs_theme_rating_icons as $r_key => $rating_icon) { ?>
                                <div class="wpvs-rating-select">
                                    <label class="wpvs-rating-icon"><?php echo $rating_icon; ?>
                                    <input type="radio" name="wpvs_video_rating" value="<?php echo $r_key; ?>" />
                                    </label>
                                </div>
                            <?php } } ?>
                        </div>
                    </div>
                </fieldset>
            <?php }
        }
    }

    public function wpvs_video_bulk_edit_save_fields() {
    	$wpvs_video_ids     = ( ! empty( $_POST[ 'video_ids' ] ) ) ? $_POST[ 'video_ids' ] : array();
    	$wpvs_video_rating  = ( ! empty( $_POST[ 'wpvs_video_rating' ] ) ) ? $_POST[ 'wpvs_video_rating' ] : '';
    	if ( ! empty( $wpvs_video_ids ) && is_array( $wpvs_video_ids ) && ! empty($wpvs_video_rating) ) {
    		foreach( $wpvs_video_ids as $video_id ) {
                $wpvs_video_information = get_post_meta( $video_id, 'wpvs_video_information', true);
                if( empty($wpvs_video_information) ) {
                    $wpvs_video_information = array(
                        'length' => 0,
                        'hours' => intval(gmdate("H", 0)),
                        'minutes' => intval(gmdate("i", 0)),
                        'date_released' => '',
                        'rating' => '',
                    );
                }

                if( $wpvs_video_rating == "none" ) {
                    $wpvs_video_information['rating'] = '';
                    update_post_meta( $video_id, 'wpvs_video_rating', '');
                } else {
                    $wpvs_video_information['rating'] = $wpvs_video_rating;
                    update_post_meta( $video_id, 'wpvs_video_rating', $wpvs_video_rating);
                }
                update_post_meta( $video_id, 'wpvs_video_information', $wpvs_video_information);
    		}
    	}
    	wp_die();
    }
}
$wpvs_theme_video_bulk_editor = new WPVS_THEME_VIDEO_BULK_EDITOR();
