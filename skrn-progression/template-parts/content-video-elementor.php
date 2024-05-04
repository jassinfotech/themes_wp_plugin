<?php
/**
 * @package pro
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="progression-studios-video-index <?php echo esc_attr( $settings['progression_elements_image_hover_effect'] ); ?>">

		<?php if(has_post_thumbnail()): ?>
			<div class="progression-studios-feaured-video-index">				
				<?php progression_studios_blog_post_title(); ?>
					<?php the_post_thumbnail('progression-studios-video-index'); ?>
				</a>
			</div><!-- close .progression-studios-feaured-video-index -->
		<?php endif; ?><!-- close video -->
		
		<div class="progression-video-index-content">
			
			<h2 class="progression-video-title"><?php progression_studios_blog_post_title(); ?><?php the_title(); ?></a></h2>

			<?php if ( $settings['progression_elements_post_show_rating'] == 'yes') : ?>
			<?php if ( skrn_pro_comment_rating_get_average_ratings( $post->ID ) ) : ?>
			<?php $rating_edit_format = skrn_pro_comment_rating_get_average_ratings( $post->ID );  ?>
	      <div
	        class="circle-rating-pro"
	        data-value="<?php if ( $rating_edit_format == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_edit_format); ?><?php endif; ?>"
	        data-animation-start-value="<?php if ( $rating_edit_format == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_edit_format); ?><?php endif; ?>"
	        data-size="32"
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
			<?php endif; ?>
			
			<?php endif; ?>
			
			
			<?php if ( $settings['progression_elements_post_display_excerpt'] == 'yes') : ?>
				<?php if(has_excerpt() ): ?><div class="clearfix-pro"></div><div class="progression-studios-video-index-excerpt"><?php the_excerpt(); ?></div><?php endif; ?>
			<?php endif; ?>
			
			
			<div class="clearfix-pro"></div>
		</div><!-- close .progression-video-index-content -->
	
	</div><!-- close .progression-studios-video-index -->
</div><!-- #post-## -->