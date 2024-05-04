<?php
// CUSTOM MENU OUTPUT
class wpvs_theme_mobile_menu_walker extends Walker_Nav_Menu
{
    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        global $wp_query;
        if( is_array($item->classes) && in_array("menu-item-has-children", $item->classes)) {
            $output .= '<span class="dashicons dashicons-arrow-down menuArrow mobile-arrow"></span>';
        }
    }

}

class wpvs_theme_desktop_menu_walker extends Walker_Nav_Menu
{
    function end_el(&$output, $item, $depth = 0, $args = array())
    {
        global $wp_query;
        if( is_array($item->classes) ) {
            if( in_array("menu-item-has-children", $item->classes) && ($depth === 0) ) {
                $output .= '<span class="dashicons dashicons-arrow-down menuArrow right-arrow"></span>';
            }
            if( in_array("menu-item-has-children", $item->classes) && ($depth >= 1) ) {
                $output .= '<span class="dashicons dashicons-arrow-right menuArrow sub-arrow"></span>';
            }
        }
    }

}

class WPVS_THEME_COMMENTS_WALKER extends Walker_Comment {

    // init classwide variables
    var $tree_type = 'comment';
    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
    /** CONSTRUCTOR
     * You'll have to use this if you plan to get to the top of the comments list, as
     * start_lvl() only goes as high as 1 deep nested comments */
    function __construct() { ?>
        <div class="comments-area">

    <?php }

    /** START_LVL
     * Starts the list before the CHILD elements are added. */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        <div class="comment-list">
    <?php }

    /** END_LVL
     * Ends the children list of after the elements are added. */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        </div><!-- /.children -->

    <?php }

    /** START_EL */
    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>

        <div <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
            <div class="comment-author vcard author">
                <?php echo ( $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) :'' ); ?>
                <cite class="fn n author-name">
                    <?php
                        $comment_author_url = get_comment_author_link();
                        if(strpos($comment_author_url, 'href')) { ?>
                            <a href="<?php echo comment_author_url(); ?>" target="_blank"><?php echo comment_author(); ?></a>
                    <?php } else { ?>
                        <?php echo comment_author(); ?>
                    <?php } ?>
                </cite>
            </div><!-- /.comment-author -->
            <div id="comment-content-<?php comment_ID(); ?>" class="comment-content">
                <?php if( !$comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation', 'wpvs-theme'); ?>.</em>
                <?php else:
                    comment_text(); ?>
                <?php endif; ?>
            </div><!-- /.comment-content -->

            <div class="comment-meta comment-meta-data">
                <?php comment_date(); ?> at <?php comment_time(); ?> <?php edit_comment_link( '(Edit)' ); ?>
            </div><!-- /.comment-meta -->

            <div class="reply">
                <?php $reply_args = array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'] );
                comment_reply_link( array_merge( $args, $reply_args ) );  ?>
            </div><!-- /.reply -->
    <?php }

    function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

        </div><!-- /#comment-' . get_comment_ID() . ' -->

    <?php }

    /** DESTRUCTOR
     * I'm just using this since we needed to use the constructor to reach the top
     * of the comments list, just seems to balance out nicely:) */
    function __destruct() { ?>

    </div><!-- /#comment-list -->

    <?php }
}

class WPVS_Review_Comments extends Walker_Comment {

    // init classwide variables
    var $tree_type = 'comment';
    var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
    /** CONSTRUCTOR
     * You'll have to use this if you plan to get to the top of the comments list, as
     * start_lvl() only goes as high as 1 deep nested comments */
    function __construct() {
        global $wpvs_video_review_show_author;
        $wpvs_video_review_show_author = get_theme_mod('wpvs_video_review_show_author', 1);
    ?>
        <div class="comments-area">

    <?php }

    /** START_LVL
     * Starts the list before the CHILD elements are added. */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        <div class="comment-list">
    <?php }

    /** END_LVL
     * Ends the children list of after the elements are added. */
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        </div><!-- /.children -->

    <?php }

    /** START_EL */
    function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        $parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );
        global $wpvs_video_review_show_author;?>

        <div <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
            <?php if($wpvs_video_review_show_author) { ?>
            <div class="comment-author vcard author">
                <?php echo ( $args['avatar_size'] != 0 ? get_avatar( $comment, $args['avatar_size'] ) :'' ); ?>
                <cite class="fn n author-name">
                    <?php
                        $comment_author_url = get_comment_author_link();
                        if(strpos($comment_author_url, 'href')) { ?>
                            <a href="<?php echo comment_author_url(); ?>" target="_blank"><?php echo comment_author(); ?></a>
                    <?php } else { ?>
                        <?php echo comment_author(); ?>
                    <?php } ?>
                </cite>
            </div><!-- /.comment-author -->
            <?php } ?>
            <div id="comment-content-<?php comment_ID(); ?>" class="comment-content">
                <?php if( !$comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation"><?php _e('Your review is awaiting moderation', 'wpvs-theme'); ?>.</em>
                <?php else:
                    $review_rating = get_comment_meta($comment->comment_ID, 'wpvs_video_rating', true);
                    if( ! empty($review_rating) ) {
                        $wpvs_video_stars = '<div class="wpvs-user-video-rating">';
                        for( $rating_n = 1; $rating_n <= 5; $rating_n++ ) {
                            if( $rating_n <= $review_rating ) {
                                $wpvs_video_stars .= '<span class="dashicons dashicons-star-filled wpvs-video-rating-star-complete active"></span>';
                            } else {
                                $wpvs_video_stars .= '<span class="dashicons dashicons-star-empty wpvs-video-rating-star-complete"></span>';
                            }
                        }
                        $wpvs_video_stars .= '</div>';
                        echo $wpvs_video_stars;
                    }
                    comment_text(); ?>
                <?php endif; ?>
            </div><!-- /.comment-content -->

            <div class="comment-meta comment-meta-data">
                <?php comment_date(); ?> at <?php comment_time(); ?> <?php edit_comment_link( '(Edit)' ); ?>
            </div><!-- /.comment-meta -->
    <?php }

    function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

        </div><!-- /#comment-' . get_comment_ID() . ' -->

    <?php }

    /** DESTRUCTOR
     * I'm just using this since we needed to use the constructor to reach the top
     * of the comments list, just seems to balance out nicely:) */
    function __destruct() { ?>

    </div><!-- /#comment-list -->

    <?php }
}
