<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					/* translators: %s: post title */
					printf( _x( 'One review on &ldquo;%s&rdquo;', 'reviews title', 'wpvs-theme' ), get_the_title() );
				} else {
					printf(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s review on &ldquo;%2$s&rdquo;',
							'%1$s reviews on &ldquo;%2$s&rdquo;',
							$comments_number,
							'reviews title',
							'wpvs-theme'
						),
						number_format_i18n( $comments_number ),
						get_the_title()
					);
				}
			?>
		</h3>
    
		<div class="comment-list">
			<?php
				wp_list_comments( array(
                    'walker' => new WPVS_Review_Comments,
					'style'       => 'div',
					'short_ping'  => false,
					'avatar_size' => 42,
                    'per_page' => 10
				) );
			?>
		</div><!-- .comment-list -->
		<nav class="navigation col-12 text-align-center">
            <?php paginate_comments_links( array(
                    'base' => add_query_arg( 'cpage', '%#%' ),
                    'total' => ceil($comments_number/10),
                    'echo' => true,
                    'add_fragment' => '#comments',
                    'prev_next' => true,
                    'show_all' => true
                ) ); 
            ?>
        </nav>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Reviews are closed.', 'wpvs-theme' ); ?></p>
	<?php endif; ?>

	<?php
        $current_user_has_review = wpvs_current_user_has_review();
        if( ! $current_user_has_review ) {
            comment_form( array(
                'title_reply' => __('Leave Review', 'wpvs-theme'),
                'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
                'title_reply_after'  => '</h3>',
                'class_submit'       => 'button wpvs-review-submit',
                'label_submit'       => __('Add Review', 'wpvs-theme'),
                'class_form'         => 'comment-form wpvs-review-form',
                'must_log_in'        => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to add a review.', 'wpvs-theme' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>'
            ) );
        } else {
            echo '<p>'.__('You have already submitted a review for this video', 'wpvs-theme').'</p>';
        }
	?>

</div><!-- .comments-area -->
