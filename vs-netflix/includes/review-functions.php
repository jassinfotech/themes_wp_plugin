<?php

$wpvs_video_review_ratings = get_theme_mod('wpvs_video_review_ratings', 0);
if($wpvs_video_review_ratings) {
    add_action( 'comment_form_logged_in_after', 'wpvs_video_comment_review_fields' );
    add_action( 'comment_form_before_fields', 'wpvs_video_comment_review_fields' );
    add_action( 'comment_post', 'wpvs_save_custom_video_comment_data', 10, 2 );
    add_action( 'wp_set_comment_status', 'wpvs_update_video_ratings_on_comment_status', 10, 2 );
    add_action( 'untrashed_comment', 'wpvs_update_video_ratings_after_restore', 10, 1 );
    add_action( 'unspammed_comment', 'wpvs_update_video_ratings_after_restore', 10, 1 );
}

function wpvs_video_comment_review_fields() {
    global $post;
    if( $post && $post->post_type == 'rvs_video' ) {
        $wpvs_video_review_fields = '<div class="wpvs-rating-container"><label for="rating">'. __('Rating', 'wpvs-theme') . '</label><div class="wpvs-rating-box">';
        for( $i=1; $i <= 5; $i++ ) {
            $wpvs_video_review_fields .= '<span class="ease3 dashicons dashicons-star-empty wpvs-video-rating-star" data-rating="'. $i .'"></span>';
        }
        $wpvs_video_review_fields .= '<label id="wpvs-missing-rating" class="wpvs-review-error">'.__('Please select a rating', 'wpvs-theme').'</label>';
        $wpvs_video_review_fields .= '</div>';
        $wpvs_video_review_fields .= '<input type="hidden" name="wpvs_video_rating" id="wpvs_video_rating" value="" /></div>';
        echo $wpvs_video_review_fields;
    }
}

function wpvs_save_custom_video_comment_data( $comment_id, $comment_approved ) {
    if ( ( isset( $_POST['wpvs_video_rating'] ) ) && ( $_POST['wpvs_video_rating'] != '') ) {
        $video_rating = wp_filter_nohtml_kses($_POST['wpvs_video_rating']);
        if( $video_rating > 5 ) {
            $video_rating = 5;
        }
        if( $video_rating < 1 ) {
            $video_rating = 1;
        }
        add_comment_meta( $comment_id, 'wpvs_video_rating', $video_rating );
        if( $comment_approved ) {
            wpvs_update_video_average_rating($comment_id, true);
        }
    }
}

function wpvs_update_video_ratings_on_comment_status($comment_id, $comment_status) {
    if( $comment_status == "approve") {
        wpvs_update_video_average_rating($comment_id, true);
    } else {
        wpvs_update_video_average_rating($comment_id, false);
    }
}

function wpvs_update_video_ratings_after_restore($comment_id) {
    wpvs_update_video_average_rating($comment_id, true);
}

function wpvs_update_video_average_rating($comment_id, $include_id) {
    $review_count = 0;
    $rating_total = 0;
    $video_review = get_comment( $comment_id );
    $video_id = $video_review->comment_post_ID;
    $video_review_args = array(
        'post_id' => $video_id,
        'fields' => 'ids',
        'status' => 'approve'
    );
    if( ! $include_id ) {
        $video_review_args['comment__not_in'] = array($comment_id);
    }
    $video_reviews = get_comments($video_review_args);
    if( ! empty($video_reviews) ) {
        foreach($video_reviews as $review_id) {
            $video_rating = get_comment_meta($review_id, 'wpvs_video_rating', true);
            if( ! empty($video_rating) ) {
                $rating_total = $rating_total + floatval($video_rating);
                $review_count++;
            }
        }
    }

    if( $review_count > 0 && $rating_total > 0 ) {
        $video_average_rating = round(($rating_total/$review_count), 1, PHP_ROUND_HALF_UP);
    } else {
        $video_average_rating = 0;
    }
    update_post_meta($video_id, 'wpvs_video_average_rating', $video_average_rating);
    update_post_meta($video_id, 'wpvs_video_ratings_count', $review_count);
}

function wpvs_current_user_has_review() {
    global $wpvs_current_user;
    global $post;
    $user_has_review = false;
    if( ! empty($wpvs_current_user) && ! empty($post) ) {
        $check_video_review_args = array(
            'post_id' => $post->ID,
            'fields' => 'ids',
            'author_email' => $wpvs_current_user->user_email
        );
        $check_video_reviews = get_comments($check_video_review_args);
        if( ! empty($check_video_reviews) ) {
            $user_has_review = true;
        }
    }
    return $user_has_review;
}
