<?php
/**
 * @package pro
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="progression-single-container">
		
		<?php if( !get_post_meta($post->ID, 'progression_studios_disable_featured_image', true) ): ?>
			<?php if(has_post_format( 'video' ) && get_post_meta($post->ID, 'progression_studios_video_post', true) || has_post_format( 'audio' ) && get_post_meta($post->ID, 'progression_studios_video_post', true)  ): ?>
	
				<div class="progression-studios-feaured-image video-progression-studios-format">
					<?php
							$videoURL = esc_url( get_post_meta($post->ID, 'progression_studios_video_post', true) );
							$oEmbed = wp_oembed_get( $videoURL );
							if ( $oEmbed != false ) {
								echo $oEmbed;
							} else {
								echo apply_filters('progression_studios_video_content_filter', get_post_meta($post->ID, 'progression_studios_video_post', true));
							}
						 ?>
				</div>
	
				<?php else: ?>
		
					<?php if( has_post_format( 'gallery' ) && get_post_meta($post->ID, 'progression_studios_gallery', true)  ): ?>
						<div class="progression-studios-feaured-image">
							<div class="flexslider progression-studios-gallery">
						      <ul class="slides">
									<?php $files = get_post_meta( get_the_ID(),'progression_studios_gallery', 1 ); ?>
									<?php foreach ( (array) $files as $attachment_id => $attachment_url ) : ?>
									<?php $lightbox_pro = wp_get_attachment_image_src($attachment_id, 'large'); ?>
									<li>
										<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_lightbox_video'): ?>
										<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" data-rel="prettyPhoto" <?php $get_description = get_post(get_post_thumbnail_id())->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?>>
										<div class="icon-overlay-blog"><i class="fa fa-file-image-o" aria-hidden="true"></i></div>
									
										<?php else: ?>
										<a href="<?php echo esc_attr($lightbox_pro[0]);?>" data-rel="prettyPhoto[gallery]" <?php $get_description = get_post($attachment_id)->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?>>
																					
										<?php endif; ?>
										<?php echo wp_get_attachment_image( $attachment_id, 'progression-studios-blog-index' ); ?>
									</a></li>
									<?php endforeach;  ?>
								</ul>
							</div><!-- close .flexslider -->
	
						</div><!-- close .progression-studios-feaured-image -->
						<?php else: ?>
				
							<?php if(has_post_thumbnail()): ?>
								<div class="progression-studios-feaured-image">
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?>	
									<?php if(get_post_meta($post->ID, 'progression_studios_blog_featured_image_link', true) == 'progression_lightbox_video'): ?>
									<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_external_link', true) );?>" data-rel="prettyPhoto" <?php $get_description = get_post(get_post_thumbnail_id())->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?>>
									<?php else: ?>
									<a href="<?php echo esc_attr($image[0]);?>" <?php $get_description = get_post(get_post_thumbnail_id())->post_excerpt; if(!empty($get_description)){ echo 'title="' . $get_description . '"'; } ?> data-rel="prettyPhoto">
									<?php endif; ?>				
										<?php the_post_thumbnail('progression-studios-blog-index'); ?>
									</a>
								</div><!-- close .progression-studios-feaured-image -->
							<?php endif; ?><!-- close featured thumbnail -->
			
					<?php endif; ?><!-- close gallery -->
		
			<?php endif; ?><!-- close video -->
		<?php endif; ?>

		<div class="progression-blog-content progression-blog-single-content">
			
			<h2 class="progression-blog-title"><?php the_title(); ?></h2>

			<?php if ( 'post' == get_post_type() ) : ?>
				<ul class="progression-post-meta">
					<?php if (get_theme_mod( 'progression_studios_blog_post_meta_author_display', 'true') == 'true') : ?><li class="blog-meta-author-display"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><i class="fas fa-user"></i><?php the_author(); ?></a></li><?php endif; ?>
						
					<?php if ( get_theme_mod( 'progression_studios_blog_post_meta_date_display', 'true') == 'true' && 'post' == get_post_type() ) : ?>	
						<li class="blog-meta-date-list"><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><i class="fas fa-calendar" aria-hidden="true"></i><?php the_time(get_option('date_format')); ?></a></li>
					<?php endif; ?>
					
					<?php if (get_theme_mod( 'progression_studios_blog_post_index_meta_category_display', 'true') == 'true') : ?>
						<li class="blog-meta-category-list"><i class="fas fa-folder-open" aria-hidden="true"></i><?php the_category(', '); ?></li>
					<?php endif; ?>

					<?php if (get_theme_mod( 'progression_studios_blog_post_meta_comment_display', 'true') == 'true') : ?><li class="blog-meta-comments"><?php comments_popup_link( '' . wp_kses( __( '<i class="fas fa-comments" aria-hidden="true"></i>0 comments', 'skrn-progression' ), true ) . '', wp_kses( __( '<i class="fas fa-comments" aria-hidden="true"></i>1 comment', 'skrn-progression' ), true), wp_kses( __( '<i class="fas fa-comments" aria-hidden="true"></i>% comments', 'skrn-progression' ), true ) ); ?></li><?php endif; ?>
				</ul>
				<div class="clearfix-pro"></div>
			<?php endif; ?>
			
			
			<div class="progression-studios-blog-excerpt">
				
				<?php the_content(); ?>
			<div class="clearfix-pro"></div>
			
			
			
			<?php the_tags(  '<div class="tags-progression"><span><i class="fa fa-tags"></i></span>', '', '</div><div class="clearfix-pro"></div>' ); ?>
			
			
			
			<?php wp_link_pages( array(
				'before' => '<div class="progression-page-nav">' . esc_html__( 'Pages:', 'skrn-progression' ),
				'after'  => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				) );
			?>
			<div class="clearfix-pro"></div>
			
			</div>

		</div><!-- close .progression-blog-content -->
		
		
		

			
	

		<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?><div class="clearfix-pro"></div>
			
	</div><!-- close .progression-single-container -->
</div><!-- #post-## -->