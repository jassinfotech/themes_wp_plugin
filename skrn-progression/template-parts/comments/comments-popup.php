<?php
/**
 * @package pro
 */

$comment_count_pro = get_comments_number();
?>

<div id="comment-review-pop-up-fullscreen">
	<div id="close-pop-up-full-review-skrn"><span class="icon-Close"></span></div>
	<div id="comment-review-pop-up-container">
		<div id="comment-review-pop-up-padding">
			
			<div id="comment-review-popup-heading">
				<div class="grid2column-progression">
					<h2><?php esc_html_e( 'Reviews for: ', 'skrn-progression' ); ?> <?php the_title(); ?></h2>
				</div>
				<div class="grid2column-progression lastcolumn-progression">
					<?php if ( skrn_pro_comment_rating_get_average_ratings( $post->ID ) ) : ?>
						<h6><?php esc_html_e( 'Average Rating', 'skrn-progression' ); ?></h6>
		      		 <?php $rating_edit_format = skrn_pro_comment_rating_get_average_ratings( $post->ID );  ?>
				      <div
				        class="circle-rating-pro"
				        data-value="<?php if ( $rating_edit_format == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_edit_format); ?><?php endif; ?>"
				        data-animation-start-value="<?php if ( $rating_edit_format == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_edit_format); ?><?php endif; ?>"
				        data-size="40"
				        data-thickness="3"
					  
  						<?php if ( $rating_edit_format > '6.9'  ) : ?>
					        data-fill="{
					          &quot;color&quot;: &quot;<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_color', '#42b740') ); ?>&quot;
					        }"
					        data-empty-fill="<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_secondary_color', '#def6de') ); ?>"
					        data-reverse="true"
					      ><span style="color:<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_color', '#42b740') ); ?>;">
							<?php else: ?>
						        data-fill="{
						          &quot;color&quot;: &quot;<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_color', '#ff4141') ); ?>&quot;
						        }"
						        data-empty-fill="<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_secondary_color', '#ffe1e1') ); ?>"
						        data-reverse="true"
						      ><span style="color:<?php echo esc_attr( get_theme_mod( 'progression_studios_video_rating_negative_color', '#ff4141') ); ?>;">
  						<?php endif; ?>
			        
							<?php if ( $rating_edit_format == '10'  ) : ?>10<?php else: ?><?php echo number_format((float)$rating_edit_format, 1, '.', '');	?><?php endif; ?></span></div>
						<div class="clearfix"></div>
					
					
					<?php endif; ?>
				</div>
				<div class="clearfix-pro"></div>
			</div><!-- close #comment-review-popup-heading -->
			
			
			<?php 
			global $current_user;
			
			$usercomment = get_comments( array (
			            'user_id' => $current_user->ID,
			            'post_id' => $post->ID,
			    ) );;
			
			if( is_user_logged_in() && !$usercomment ): 
			?>
				
				
			<div id="comment-review-form-container">
				
				<button href="#" class="button">
					<?php esc_html_e( 'Write a Review ', 'skrn-progression' ); ?>
				</button>
				
				<div id="comment-review-form-submit">
					<?php 

					$comment_args = array( 
						'title_reply'=> '',
						'label_submit'=> esc_html__( 'Submit Review', 'skrn-progression' ),


					'comment_field' => '<p>' .


					'<textarea id="comment" name="comment" cols="45" rows="4" required="required" placeholder="' . esc_html__( "Write your review here...", 'skrn-progression' ) . ' "></textarea>' .

					'</p>',

					'comment_notes_after' => "",

					);
					
					
					comment_form($comment_args);
					?>
				</div>
			</div><!-- close #comment-review-form-container -->
			<?php endif; ?>

			
			
			<?php if( $comment_count_pro >= 1  ): ?>
				
				<?php if (0 == $comment->comment_approved) { ?>
				<p id="review-under-moderation-reivew-skrn-pro"><?php echo esc_html_e( 'Thank you for your review. Your review is currently awaiting moderation.', 'skrn-progression' ); ?></p>
				<?php } ?>
			<?php else: ?>
				<div id="no-reivew-skrn-pro"><?php echo esc_html_e( 'There are currently no reviews for ', 'skrn-progression' ); ?> <?php the_title(); ?></div>
					
			<?php endif; ?>
			
				<?php 
				
				if( $comment_count_pro >= 1  ): ?>
					<ul class="fullscreen-reviews-pro">
						<?php
						//https://deluxeblogtips.com/display-comments-in-homepage/
						$comments = get_comments( array(
						    'post_id' => get_the_ID(),
						    'status' => 'approve',
						) );
						
				    	wp_list_comments( array(
							'per_page'          => '999',
							'callback' => 'progression_studios_comment_fullscreen',
							'type'     => 'comment',
						), $comments );
			
					
						?>
					</ul>
				<?php endif; ?>
				
			<div class="clearfix-pro"></div>	
		</div><!-- close #comment-review-pop-up-padding -->
	</div><!-- close #comment-review-pop-up-container -->
</div><!-- close #comment-review-pop-up-fullscreen -->