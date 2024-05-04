<?php 

/**
 * Let users wishlist individual posts
 *
 * @package progression
 */

if (! function_exists('progression_the_wishlist_button')) {
	/**
	 * Echoes the HTML of the `progression_get_the_wishlist_button` function. Output is filtered through 'progression_get_the_wishlist_button'.
	 * @return string HTML output of the wishlist button
	 */
	function progression_the_wishlist_button() {
		echo apply_filters( 'progression_the_wishlist_button', progression_get_the_wishlist_button() );
	}
}

if (! function_exists('progression_get_the_wishlist_button')) {
	/**
	 * Returns the HTML of the `progression_get_the_wishlist_button` function. Output is filtered through 'progression_get_the_wishlist_button'.
	 * @return string HTML output of the wishlist button
	 */
	function progression_get_the_wishlist_button() {

		$output = '';

		$action = get_permalink();
		$name 	= progression_is_wishlist() ? 'progression_remove_user_wishlist' : 'progression_add_user_wishlist';
		$class 	= 'wishlist-button-pro' . ( progression_is_wishlist() ? ' is-wishlist' : '' );
		$text 	= progression_is_wishlist() ? esc_html__( 'Watchlist', 'skrn-progression' ) : esc_html__( 'Add to Watchlist', 'skrn-progression' );
		
		$output .= '<form method="post" class="wishlist_user_post" action="'. $action .'">';
		$output .= '<button type="submit" name="'. $name .'" value="'. get_the_ID() .'" class="'. $class .'">';
		$output .= '<i class="fas fa-check"></i>';
		$output .= $text;
		$output .= '</button></form>';
		
		return apply_filters( 'progression_get_the_wishlist_button', $output );
	}
}

if (! function_exists('progression_is_wishlist')) {
	/**
	 * Returns true or false if post is in wishlists of user. Defaults to current post and current user.
	 * @param  integer $post_id post ID of the post of which to check wishlist status
	 * @param  integer $user_id user ID for which to check wishlist status
	 * @return boolean Wether post is in wishlists of user or not
	 */
	function progression_is_wishlist( $post_id = 0, $user_id = 0 ){

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		// get user wishlists
		$meta_value = progression_get_wishlist_videos( $user_id );

		// check if post is wishlist of user 
		return array_search( $post_id, $meta_value ) !== false;
	}
}

if (! function_exists('progression_add_user_wishlist')) {
	/**
	 * Adds given post ID to wishlists of given user ID
	 * @param integer $post_id post ID of the post to wishlist
	 * @param integer $user_id user ID to add post wishlist
	 * @return mixed Meta ID if the key didn't exist, true on successful update, false on failure.
	 */
	function progression_add_user_wishlist( $post_id = 0, $user_id = 0 ) {

		if ( empty( $post_id ) || empty( $user_id ) ) {
			return false;
		}
		
		// get user wishlists
		$meta_value = progression_get_wishlist_videos( $user_id );

		// add post to wishlists
		$meta_value[] = $post_id;

		return update_user_meta( $user_id, 'post_wishlists', array_unique( $meta_value ) ); 
	}
}

if (! function_exists('progression_remove_user_wishlist')) {
	/**
	 * Removes given post ID from wishlists of given user ID
	 * @param integer $post_id post ID of the post to wishlist
	 * @param integer $user_id user ID to add post wishlist
	 * @return mixed Meta ID if the key didn't exist, true on successful update, false on failure.
	 */
	function progression_remove_user_wishlist( $post_id = 0, $user_id = 0 ) {

		if ( empty( $post_id ) || empty( $user_id ) ) {
			return false;
		}
	    
	    // get user wishlists
		$meta_value = progression_get_wishlist_videos( $user_id );

		// search and remove existing post from users wishlists
		if ( false !== ( $key = array_search( $post_id, $meta_value ))) {
		    unset( $meta_value[$key] );
		}

		return update_user_meta( $user_id, 'post_wishlists', $meta_value ); 
	}
}

if (! function_exists('progression_get_wishlist_videos')) {
	/**
	 * Get the wishlist post IDs of user
	 * @return array an array containing the IDs of users wishlist posts
	 */
	function progression_get_wishlist_videos( $user_id ) {
		$meta_value = get_user_meta( $user_id, 'post_wishlists', true);

		if ( empty( $meta_value )) {
			$meta_value = array();
		} 

		return apply_filters( 'progression_get_wishlist_videos', array_map( 'absint', $meta_value ), $user_id );
	}
}

if (! function_exists('progression_wishlist_post_request')) {
	/**
	 * Checks if there has been a POST or GET request for wishlists
	 * @return void
	 */
	function progression_wishlist_post_request() {

	    if ( ! empty( $_REQUEST['progression_add_user_wishlist'] ) ) {
	    	if ( is_user_logged_in() ) {
	    		$post_id = absint( $_REQUEST['progression_add_user_wishlist'] );
	    		progression_add_user_wishlist( $post_id, get_current_user_id() );
	    	} else {
	    		add_action( 'skrn_notices', 'skrn_notice_login_wishlist' );
	    	}
	    }

	    if ( ! empty( $_REQUEST['progression_remove_user_wishlist'] ) ) {
	    	$post_id = absint( $_REQUEST['progression_remove_user_wishlist'] );
	    	progression_remove_user_wishlist( $post_id, get_current_user_id() );
	    }
	}
	add_action( 'init', 'progression_wishlist_post_request' );
}



if (! function_exists('skrn_notice_login_wishlist')) {
	/**
	 *  Shows a notification message to users
	 *
	 *  @param   bool  $echo
	 *
	 *  @return  string
	 */
	function skrn_notice_login_wishlist( $template = '' ) {

		$notify_text 	= wp_kses( __('Please log in to add videos to your wishlist', 'skrn-progression' ) , TRUE);
		
		$html = '<p><i class="fa fa-exclamation-circle"></i> ' . sprintf( $notify_text) . '</p>';
		echo sprintf( $template, $html );
		
	}
}

if (! function_exists('progression_wishlist_query_var')) {
	/**
	 * Adds custom query variable 'wishlist_videos'
	 * @param  array $qvars old query variables
	 * @return array $qvars new query variables
	 */
	function progression_wishlist_query_var( $qvars ) {
		$qvars[] = 'wishlist_videos';
		return $qvars;
	}
	add_filter( 'query_vars', 'progression_wishlist_query_var' );
}

if (! function_exists('progression_pre_get_wishlists')) {
	/**
	 * Create custom query behavior for 'wishlist_videos' variable. This allows using native functions such as get_posts or query_posts.
	 * @param  object $query the current query object
	 * @return void
	 */
	function progression_pre_get_wishlists( $query ) {

	    if ( $query->get('wishlist_videos' ) || 0 === $query->get('wishlist_videos' ) ) {
	    	$wishlist_videos = progression_get_wishlist_videos( $query->get('wishlist_videos' ) );

	    	if ( empty( $wishlist_videos ) ) {
	    		$query->set( 'post__in', array( '-1' ) );
	    	} else {
	    		$query->set( 'post__in', $wishlist_videos );
	    	}
	    }
	}
	add_filter( 'pre_get_posts', 'progression_pre_get_wishlists' );
}

if (! function_exists('progression_get_wishlist_user_videos')) {
	/**
	 * Get the wishlists videos of user
	 * 
	 * @see WP_Query::get_posts()
	 * 
	 * @return array an array containing the post objects wishlistd by user
	 */
	function progression_get_wishlist_user_videos( $user_id = null ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		} else {
			$user_id = absint( $user_id );
		}

		$videos = get_posts( array( 'wishlist_videos' => $user_id, 'post_type' => 'video_skrn' ));

		return apply_filters( 'progression_get_wishlist_user_videos', $videos, $user_id );
	}
}

