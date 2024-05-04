<?php 

/**
 * Let users favorite individual posts
 *
 * @package progression
 */

if (! function_exists('progression_the_favorite_button')) {
	/**
	 * Echoes the HTML of the `progression_get_the_favorite_button` function. Output is filtered through 'progression_get_the_favorite_button'.
	 * @return string HTML output of the favorite button
	 */
	function progression_the_favorite_button() {
		echo apply_filters( 'progression_the_favorite_button', progression_get_the_favorite_button() );
	}
}

if (! function_exists('progression_get_the_favorite_button')) {
	/**
	 * Returns the HTML of the `progression_get_the_favorite_button` function. Output is filtered through 'progression_get_the_favorite_button'.
	 * @return string HTML output of the favorite button
	 */
	function progression_get_the_favorite_button() {

		$output = '';

		$action = get_permalink();
		$name 	= progression_is_favorite() ? 'progression_remove_user_favorite' : 'progression_add_user_favorite';
		$class 	= 'favorite-button-pro' . ( progression_is_favorite() ? ' is-favorite' : '' );
		$text 	= progression_is_favorite() ? esc_html__( 'Favorite', 'skrn-progression' ) : esc_html__( 'Add to Favorites', 'skrn-progression' );
		
		$output .= '<form method="post" class="favorite_user_post" action="'. $action .'">';
		$output .= '<button type="submit" name="'. $name .'" value="'. get_the_ID() .'" class="'. $class .'">';
		$output .= '<i class="fas fa-heart"></i>';
		$output .= $text;
		$output .= '</button></form>';
		
		return apply_filters( 'progression_get_the_favorite_button', $output );
	}
}

if (! function_exists('progression_is_favorite')) {
	/**
	 * Returns true or false if post is in favorites of user. Defaults to current post and current user.
	 * @param  integer $post_id post ID of the post of which to check favorite status
	 * @param  integer $user_id user ID for which to check favorite status
	 * @return boolean Wether post is in favorites of user or not
	 */
	function progression_is_favorite( $post_id = 0, $user_id = 0 ){

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		// get user favorites
		$meta_value = progression_get_favorite_videos( $user_id );

		// check if post is favorite of user 
		return array_search( $post_id, $meta_value ) !== false;
	}
}

if (! function_exists('progression_add_user_favorite')) {
	/**
	 * Adds given post ID to favorites of given user ID
	 * @param integer $post_id post ID of the post to favorite
	 * @param integer $user_id user ID to add post favorite
	 * @return mixed Meta ID if the key didn't exist, true on successful update, false on failure.
	 */
	function progression_add_user_favorite( $post_id = 0, $user_id = 0 ) {

		if ( empty( $post_id ) || empty( $user_id ) ) {
			return false;
		}
		
		// get user favorites
		$meta_value = progression_get_favorite_videos( $user_id );

		// add post to favorites
		$meta_value[] = $post_id;

		return update_user_meta( $user_id, 'post_favorites', array_unique( $meta_value ) ); 
	}
}

if (! function_exists('progression_remove_user_favorite')) {
	/**
	 * Removes given post ID from favorites of given user ID
	 * @param integer $post_id post ID of the post to favorite
	 * @param integer $user_id user ID to add post favorite
	 * @return mixed Meta ID if the key didn't exist, true on successful update, false on failure.
	 */
	function progression_remove_user_favorite( $post_id = 0, $user_id = 0 ) {

		if ( empty( $post_id ) || empty( $user_id ) ) {
			return false;
		}
	    
	    // get user favorites
		$meta_value = progression_get_favorite_videos( $user_id );

		// search and remove existing post from users favorites
		if ( false !== ( $key = array_search( $post_id, $meta_value ))) {
		    unset( $meta_value[$key] );
		}

		return update_user_meta( $user_id, 'post_favorites', $meta_value ); 
	}
}

if (! function_exists('progression_get_favorite_videos')) {
	/**
	 * Get the favorite post IDs of user
	 * @return array an array containing the IDs of users favorite posts
	 */
	function progression_get_favorite_videos( $user_id ) {
		$meta_value = get_user_meta( $user_id, 'post_favorites', true);

		if ( empty( $meta_value )) {
			$meta_value = array();
		} 

		return apply_filters( 'progression_get_favorite_videos', array_map( 'absint', $meta_value ), $user_id );
	}
}

if (! function_exists('progression_favorite_post_request')) {
	/**
	 * Checks if there has been a POST or GET request for favorites
	 * @return void
	 */
	function progression_favorite_post_request() {

	    if ( ! empty( $_REQUEST['progression_add_user_favorite'] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$post_id = absint( $_REQUEST['progression_add_user_favorite'] );
	    		progression_add_user_favorite( $post_id, get_current_user_id() );
	    	} else {
	    		add_action( 'skrn_notices', 'skrn_notice_login_favorite' );
	    	}
	    }

	    if ( ! empty( $_REQUEST['progression_remove_user_favorite'] ) ) {
	    	$post_id = absint( $_REQUEST['progression_remove_user_favorite'] );
	    	progression_remove_user_favorite( $post_id, get_current_user_id() );
	    }
	}
	add_action( 'init', 'progression_favorite_post_request' );
}



if (! function_exists('skrn_notice_login_favorite')) {
	/**
	 *  Shows a notification message to users
	 *
	 *  @param   bool  $echo
	 *
	 *  @return  string
	 */
	function skrn_notice_login_favorite( $template = '' ) {
		

		
		$notify_text 	= wp_kses( __('Please log in to add videos to your favorites', 'skrn-progression' ) , TRUE);
		
		$html = '<p><i class="fa fa-exclamation-circle"></i> ' . sprintf( $notify_text) . '</p>';
		echo sprintf( $template, $html );
		
	}
}

if (! function_exists('progression_favorite_query_var')) {
	/**
	 * Adds custom query variable 'favorite_videos'
	 * @param  array $qvars old query variables
	 * @return array $qvars new query variables
	 */
	function progression_favorite_query_var( $qvars ) {
		$qvars[] = 'favorite_videos';
		return $qvars;
	}
	add_filter( 'query_vars', 'progression_favorite_query_var' );
}

if (! function_exists('progression_pre_get_favorites')) {
	/**
	 * Create custom query behavior for 'favorite_videos' variable. This allows using native functions such as get_posts or query_posts.
	 * @param  object $query the current query object
	 * @return void
	 */
	function progression_pre_get_favorites( $query ) {

	    if ( $query->get('favorite_videos' ) || 0 === $query->get('favorite_videos' ) ) {
	    	$favorite_videos = progression_get_favorite_videos( $query->get('favorite_videos' ) );

	    	if ( empty( $favorite_videos ) ) {
	    		$query->set( 'post__in', array( '-1' ) );
	    	} else {
	    		$query->set( 'post__in', $favorite_videos );
	    	}
	    }
	}
	add_filter( 'pre_get_posts', 'progression_pre_get_favorites' );
}

if (! function_exists('progression_get_favorite_user_videos')) {
	/**
	 * Get the favorites videos of user
	 * 
	 * @see WP_Query::get_posts()
	 * 
	 * @return array an array containing the post objects favorited by user
	 */
	function progression_get_favorite_user_videos( $user_id = null ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		} else {
			$user_id = absint( $user_id );
		}

		$videos = get_posts( array( 'favorite_videos' => $user_id, 'post_type' => 'video_skrn' ));

		return apply_filters( 'progression_get_favorite_user_videos', $videos, $user_id );
	}
}

