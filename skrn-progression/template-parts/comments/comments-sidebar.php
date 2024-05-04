<?php
/**
 * @package pro
 */
?>

		<?php if(  comments_open() || get_comments_number() ): ?>
			<div class="content-sidebar-section">
				<h2 class="content-sidebar-sub-header adjusted-recent-reviews"><?php esc_html_e( 'Recent Reviews', 'skrn-progression' ); ?></h2>
				
				
				<?php 
				$comment_count_pro = get_comments_number();
				if( $comment_count_pro >= 1  ): ?>
					<ul class="sidebar-reviews-pro">
						<?php
						//https://deluxeblogtips.com/display-comments-in-homepage/
						$comments = get_comments( array(
						    'post_id' => get_the_ID(),
						    'status' => 'approve',
						) );
						
				    	wp_list_comments( array(
							'per_page'          => '4',
							'callback' => 'progression_studios_comment_callback',
							'type'     => 'comment',
						), $comments );

						?>
					</ul>
					<a href="#!" class="button-progression"><?php echo esc_html_e( 'See All Reviews', 'skrn-progression' ); ?></a>
					
				<?php else: ?>
					<div class="no-recent-reviews">
						<?php echo esc_html_e( 'No reviews of ', 'skrn-progression' ); ?>
						<?php the_title(); ?>
					</div>
				<?php endif; ?>
				
				
			</div>
		<?php endif; ?>