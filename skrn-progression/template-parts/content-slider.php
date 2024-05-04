<?php
/**
 * @package pro
 */
?>
<li class="<?php echo esc_attr($settings['progression_elements_slider_css3_animation'] ); ?> <?php if( get_post_meta($post->ID, 'progression_studios_slider_dark_version', true) ): ?>skrn-dark-slider-post<?php endif; ?>">
	
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	<div class="progression-studios-skrn-slider-background" <?php if( get_post_meta($post->ID, 'progression_studios_slider_header_image', true) ): ?>style="background-image:url('<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_slider_header_image', true)); ?>')"<?php else: ?><?php if( get_post_meta($post->ID, 'progression_studios_header_image', true) ): ?>style="background-image:url('<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_header_image', true)); ?>')"<?php endif; ?><?php endif; ?>>
		
	
			<div class="progression-skrn-slider-elements-display-table">
				
				
				<div class="progression-skrn-slider-text-floating-container">
					<div class="progression-skrn-slider-container-max-width">
					<div class="progression-skrn-slider-content-floating-container">
					<div class="progression-skrn-slider-content-max-width">
						
						
						<?php if ( $settings['progression_elements_slider_play_button'] == 'yes') : ?>
						
						<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'external' || get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'link' ): ?>
							<a class="progression-studios-slider-play-btn" href="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)); ?>" <?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'external' ): ?>target="_blank"<?php endif; ?>><i class="fas fa-play"></i></a>
							<?php else: ?>
							
						<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'mp4_video' ): ?>
							<a class="progression-studios-slider-play-btn afterglow" href="#SkrnLightbox-<?php the_ID(); ?>"><i class="fas fa-play"></i></a>
						<?php else: ?>
							<?php if( get_post_meta($post->ID, 'progression_studios_video_post', true) || get_post_meta($post->ID, 'progression_studios_youtube_video', true) || get_post_meta($post->ID, 'progression_studios_vimeo_video', true) ): ?>
							<a class="progression-studios-slider-play-btn afterglow" href="#SkrnCustomLightbox-<?php the_ID(); ?>"><i class="fas fa-play"></i></a>
							<?php endif; ?>
						<?php endif; ?>
						<?php endif; ?>
						<?php endif; ?>
						
						
						

					
						<?php if ( $settings['progression_elements_slider_rating'] == 'yes') : ?>
						<?php if ( skrn_pro_comment_rating_get_average_ratings( $post->ID ) ) : ?>
							<?php $rating_edit_format = skrn_pro_comment_rating_get_average_ratings( $post->ID );  ?>
				      	<div class="circle-rating-container-main">
						      <div
						        class="circle-rating-pro"
						        data-value="<?php if ( $rating_edit_format == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_edit_format); ?><?php endif; ?>"
						        data-animation-start-value="<?php if ( $rating_edit_format == '10'  ) : ?>1<?php else: ?>0.<?php echo str_replace(array('.', ','), '' , $rating_edit_format); ?><?php endif; ?>"
						        data-size="70"
						        data-thickness="6"
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
				      	</div><!-- close .width-container-pro -->
						<?php endif; ?>
						<?php endif; ?>
						
						
						<div class="progression-skrn-slider-content-margins">
								<div class="progression-skrn-slider-content-alignment">
								<div class="progression-skrn-slider-progression-crowd-index-content">
									
									<?php if ( $settings['progression_elements_video_type'] == 'yes') : ?>
									<?php 
										$terms = get_the_terms( $post->ID , 'video-type' ); 
										if ( !empty( $terms ) ) :
											echo '<ul class="progression-skrn-slider-type">';
										foreach ( $terms as $term ) {
											$term_link = get_term_link( $term, 'video-type' );
											if( is_wp_error( $term_link ) )
												continue;
											echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
										} 
										echo '</ul>';
									endif;
									?>
									<?php endif; ?>
									
									<?php if( get_post_meta($post->ID, 'progression_studios_film_rating', true) || get_post_meta($post->ID, 'progression_studios_screen_resolution', true)  ): ?>
									<ul class="progression-studios-slider-top-rating">
										<?php if ( $settings['progression_elements_post_rating'] == 'yes') : ?><?php if( get_post_meta($post->ID, 'progression_studios_film_rating', true) ): ?><li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_film_rating', true)); ?></li><?php endif; ?><?php endif; ?>
										<?php if ( $settings['progression_elements_post_resolution'] == 'yes') : ?><?php if( get_post_meta($post->ID, 'progression_studios_screen_resolution', true) ): ?><li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_screen_resolution', true)); ?></li><?php endif; ?><?php endif; ?>
									</ul>
									<?php endif; ?>
									
									<h2 class="progression-skrn-progression-slider-title"><?php progression_studios_blog_post_title(); ?><?php echo the_title(); ?></a></h2>
									
									<ul class="progression-skrn-video-slider-meta">
										<?php if ( $settings['progression_elements_post_release_date'] == 'yes') : ?>
										<?php if( get_post_meta($post->ID, 'progression_studios_release_date', true) ): ?>
											<li><?php 
												$video_release_date = get_post_meta($post->ID, 'progression_studios_release_date', true);
												echo esc_attr(date_i18n('j F, Y',strtotime($video_release_date) )); ?></li>
										<?php endif; ?>
										<?php endif; ?>
										
										<?php if ( $settings['progression_elements_post_duration'] == 'yes') : ?>
										<?php if( get_post_meta($post->ID, 'progression_studios_media_duration_meta', true) ): ?>
											<li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_media_duration_meta', true)); ?></li>
										<?php endif; ?>
										<?php endif; ?>
										
										<?php if ( $settings['progression_elements_post_genre'] == 'yes') : ?>
										<?php 
											$terms = get_the_terms( $post->ID , 'video-genres' ); 
											if ( !empty( $terms ) ) :
											foreach ( $terms as $term ) {
												$term_link = get_term_link( $term, 'video-genres' );
												if( is_wp_error( $term_link ) )
													continue;
												echo '<li class="progression-slider-skrn-video-genres-meta"><a href="' . $term_link . '">' . $term->name . '</a></li>';
											} 
										endif;
										?>
										<?php endif; ?>
									</ul>
									
									<div class="clearfix-pro"></div>
									
									
									<?php if ( $settings['progression_elements_post_excerpt'] == 'yes') : ?><?php if(has_excerpt() ): ?><div class="progression-studios-video-slider-excerpt"><?php the_excerpt(); ?></div><?php endif; ?><?php endif; ?>
									
									<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_text', true) ): ?>
									<a class="progression-studios-skrn-slider-button <?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'mp4_video' ): ?>afterglow<?php endif; ?>" 
										<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'mp4_video' ): ?>
											href="#SkrnLightbox-<?php the_ID(); ?>"
											<?php else: ?>
											href="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)); ?>"
										<?php endif; ?>
										<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'external' ): ?>target="_blank"<?php endif; ?>
									><?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_icon', true) ): ?><i class="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_slider_btn_icon', true)); ?>"></i><?php endif; ?><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_slider_btn_text', true)); ?></a>
									<?php endif; ?>
									
									<?php if ( $settings['progression_elements_post_starring'] == 'yes') : ?>
									<?php 
										$terms = get_the_terms( $post->ID , 'video-cast' ); 
										if ( !empty( $terms ) ) :
											echo '<div class="progression-studios-skrn-videos-slider-staring"><h4>';
											echo  esc_html_e( 'Starring', 'skrn-progression');
											echo '</h4><ul class="progression-studios-slider-video-starring">';
										foreach ( $terms as $term ) {
											$term_link = get_term_link( $term, 'video-cast' );
				
											$term_photo = get_term_meta( $term->term_id, 'progression_studios_cast_Photo', true);
				
											if( is_wp_error( $term_link ) )
												continue;
											echo '<li><a href="' . $term_link . '">';
				
											//if ( !empty( $term_photo ) ) :
												echo '<div class="skrn-slider-video-cast-photo" style="background-image:url(' . $term_photo . ')"></div>';
											//endif;
				
											echo '<div class="skrn-slider-video-cast-name">' . $term->name . '</div></a></li>';
										} 
										echo '</ul><div class="clearfix-pro"></div></div>';
									endif;
									?>
									<?php endif; ?>
									
									<div class="clearfix-pro"></div>
								</div><!-- close .progression-skrn-slider-progression-crowd-index-content -->
								</div><!-- close .progression-skrn-slider-content-alignment -->
				
							<div class="clearfix-pro"></div>
						</div>
					</div><!-- close .progression-skrn-slider-content-max-width -->
					</div><!-- close .progression-skrn-slider-content-floating-container -->
					</div><!-- close .progression-skrn-slider-container-max-width -->
				</div><!-- close .progression-skrn-slider-text-floating-container -->


			</div><!-- close .progression-skrn-slider-elements-display-table -->
		
		
		<div class="slider-background-overlay-color"></div>
		
	<div class="clearfix-pro"></div>
	</div><!-- close .progression-studios-skrn-slider-background -->
</div><!-- #post-## -->


<div style="display:none;">
	<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'mp4_video' ): ?><?php else: ?>
			<?php if( get_post_meta($post->ID, 'progression_studios_video_post', true) || get_post_meta($post->ID, 'progression_studios_youtube_video', true) || get_post_meta($post->ID, 'progression_studios_vimeo_video', true) ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'mp4_video' ): ?>
         <video id="SkrnCustomLightbox-<?php the_ID(); ?>"  <?php if( get_post_meta($post->ID, 'progression_studios_optional_locally_hosted_mp4_button', true) ): ?>poster="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_optional_locally_hosted_mp4_button', true)); ?>"<?php else: ?><?php if( get_post_meta($post->ID, 'progression_studios_video_embed_poster', true) && get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' && get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ): ?>poster="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_video_embed_poster', true)); ?>"<?php endif; ?><?php endif; ?> width="960" height="540" <?php if( get_post_meta($post->ID, 'progression_studios_youtube_video', true)): ?>data-youtube-id="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_youtube_video', true)); ?>"<?php endif; ?> <?php if( get_post_meta($post->ID, 'progression_studios_vimeo_video', true)): ?>data-vimeo-id="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_vimeo_video', true)); ?>"<?php endif; ?>>
				<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)): ?><source src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)); ?>" type="video/mp4">
				<?php else: ?>
					 <?php if( get_post_meta($post->ID, 'progression_studios_video_post', true)): ?><source src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_video_post', true)); ?>" type="video/mp4"><?php endif; ?>
				<?php endif; ?>
				
         </video>
		
			<?php endif; ?>
		<?php endif; ?>
	
	<?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ||  get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'mp4_video' ): ?>
	<video id="SkrnLightbox-<?php the_ID(); ?>" <?php if( get_post_meta($post->ID, 'progression_studios_optional_locally_hosted_mp4_button', true) ): ?>poster="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_optional_locally_hosted_mp4_button', true)); ?>"<?php else: ?><?php if( get_post_meta($post->ID, 'progression_studios_video_embed_poster', true) && get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' && get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ): ?>poster="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_video_embed_poster', true)); ?>"<?php endif; ?><?php endif; ?>  <?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'youtube_video' ): ?>data-youtube-id="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)); ?>"<?php endif; ?> <?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_target', true) == 'vimeo_video' ): ?>data-vimeo-id="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)); ?>"<?php endif; ?> width="960" height="540"><?php if( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)): ?><source src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_slider_btn_link', true)); ?>" type="video/mp4"><?php endif; ?></video>
	<?php endif; ?>
	
</div>

</li>