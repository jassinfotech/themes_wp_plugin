<?php
/**
 * @package pro
 */
?>



<div id="scroll-to-season-section"></div>
<div class="vayvo-progression-video-season-container">
	
	<ul class="vayvo-progression-video-season-navigation">
		<?php if(get_post_meta($post->ID, 'progression_studios_season_title', true)): ?><li class="current progression-video-season-title"><a href="<?php if(get_post_meta($post->ID, 'progression_studios_season_title_two', true) || get_post_meta($post->ID, 'progression_studios_season_title_three', true)): ?><?php the_permalink(); ?>?show_season_one<?php else: ?>#!<?php endif; ?>"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title', true)); ?></a></li><?php endif; ?>
		<?php if(get_post_meta($post->ID, 'progression_studios_season_title_two', true)): ?><li class="progression-video-season-title"><a href="<?php the_permalink(); ?>?show_season_two"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_two', true)); ?></a></li><?php endif; ?>
		<?php if(get_post_meta($post->ID, 'progression_studios_season_title_three', true)): ?><li class="progression-video-season-title"><a href="<?php the_permalink(); ?>?show_season_three"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_three', true)); ?></a></li><?php endif; ?>
		<?php if(get_post_meta($post->ID, 'progression_studios_season_title_four', true)): ?><li class="progression-video-season-title"><a href="<?php the_permalink(); ?>?show_season_four"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_four', true)); ?></a></li><?php endif; ?>
		<?php if(get_post_meta($post->ID, 'progression_studios_season_title_five', true)): ?><li class="progression-video-season-title"><a href="<?php the_permalink(); ?>?show_season_five"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_five', true)); ?></a></li><?php endif; ?>
	</ul>
	<div class="clearfix-pro"></div>
	
	<ul class="progression-studios-episode-list-main vayvo-episode-list-season-one-list">
		<?php    $entries = get_post_meta( get_the_ID(), 'progression_studios_display_season', true ); $count = 1; foreach ( (array) $entries as $key => $entry ) :   ?>
			<li class="progression-studios-episode-list-item">
				<div class="progression-episode-list-flex">
					
					<div class="progression-studios-episode-image-container">
						<div class="progression-episode-list-left-margin">
							
							<?php if(isset( $entry['progression_studios_episode_image'] ) && $entry['progression_studios_episode_image'] != '') : ?> 
								
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									<a href="Video-Season-1-Ep-<?php echo esc_attr($count);?>" class="afterglow">
										<div class="progression-episode-list-image-container">
										
									<?php endif; ?>
							
							
										<img src="<?php	
										$image_url = esc_url( $entry['progression_studios_episode_image']  );
										$image_id = progression_studios_get_image_id($image_url);
										$image_thumb = wp_get_attachment_image_src($image_id, 'progression-studios-video-related');
										echo esc_url($image_thumb[0]);
										?>" alt="<?php echo esc_attr( $entry['progression_studios_episode_title'] )?>">
							
							
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										
										<div class="progression-episode-list-overlay-play"><i class="fas fa-play"></i></div>
								      </div><!-- close .progression-episode-list-image-container -->
									</a>		
							      <div style="display:none;">
							         <video id="Video-Season-1-Ep-<?php echo esc_attr($count);?>" <?php if(isset( $entry['progression_studios_episode_video_poster'] ) && $entry['progression_studios_episode_video_poster'] != '') : ?> poster="<?php echo esc_attr( $entry['progression_studios_episode_video_poster'] )?>"<?php endif; ?> width="960" height="540" <?php if(isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != '' ) : ?> data-youtube-id="<?php echo esc_attr( $entry['progression_studios_episode_youtube_video'] )?>"<?php endif; ?> <?php if(isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != '') : ?> data-vimeo-id="<?php echo esc_attr( $entry['progression_studios_episode_vimeo_video'] )?>"<?php endif; ?>>
											<?php if(isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '') : ?>
												<source src="<?php echo esc_url( $entry['progression_studios_episode_video_mp4'] )?>" type="video/mp4">
											<?php endif; ?>
							         </video>
									<?php endif; ?>
								</div>
							<?php else: ?>
								<?php if(isset( $entry['progression_studios_episode_video_embed'] ) && $entry['progression_studios_episode_video_embed'] != '') : ?>	
									<div class="episode-video-list-embed-video">
										<span class="hide-embed-text"><?php echo esc_attr( $entry['progression_studios_episode_video_embed'] ); ?></span>
										<?php 
										$embed_video_code = $entry['progression_studios_episode_video_embed'];
										echo apply_filters('progression_studios_video_content_filter',  $embed_video_code ); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							
						</div><!-- close .progression-episode-list-left-margin -->
					</div><!-- close  .progression-studios-episode-image-container -->
	
					<div class="progression-studios-episode-right-container">
							<div class="progression-episode-list-right-margin">
								<?php if(isset( $entry['progression_studios_episode_title'] ) && $entry['progression_studios_episode_title'] != '') : ?>
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									<a href="Video-Season-1-Ep-<?php echo esc_attr($count);?>" class="afterglow">
									<?php endif; ?>
									<h2 class="progression-episode-list-title"><?php echo wp_kses(( $entry['progression_studios_episode_title'] ), true )?></h2>
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									</a>
									<?php endif; ?>
								<?php endif; ?>
		
								<?php if(get_post_meta($post->ID, 'progression_studios_season_title', true) || isset( $entry['progression_studios_episode_release_date'] ) || isset( $entry['progression_studios_episode_media_duration_meta'] ) ): ?>
								<ul class="progression-studios-episode-list-meta">
									<?php if(get_post_meta($post->ID, 'progression_studios_season_title', true)): ?><li class="progression-episode-season-meta-title"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title', true)); ?></li><?php endif; ?>
									<?php if(isset( $entry['progression_studios_episode_release_date'] ) && $entry['progression_studios_episode_release_date'] != '') : ?><li class="progression-episode-list-meta-release-date"><?php  $episode_video_release_date = $entry['progression_studios_episode_release_date'] ; echo esc_attr(date_i18n(get_option('date_format'), strtotime($episode_video_release_date) )); ?></li><?php endif; ?>
			
									<?php if(isset( $entry['progression_studios_episode_media_duration_meta'] ) && $entry['progression_studios_episode_media_duration_meta'] != '') : ?><li class="progression-episode-list-meta-duration"><?php echo esc_attr( $entry['progression_studios_episode_media_duration_meta'] )?></li><?php endif; ?>
								</ul>
								<?php endif; ?>
		
								<?php if(isset( $entry['progression_studios_description'] ) && $entry['progression_studios_description'] != '') : ?><div class="progression-episode-list-short-description"><?php echo wp_kses (( $entry['progression_studios_description'] ), true)?></div><?php endif; ?>
							</div><!-- close .progression-episode-list-right-margin -->
					</div><!-- close  .progression-studios-episode-right-container -->
			
			<div class="clearfix-pro"></div>
			</div><!-- close .progression-episode-list-flex -->
			</li>
		<?php  $count++;  endforeach; ?>
	</ul>
	
		
	<?php wp_reset_postdata();?>
	<ul class="progression-studios-episode-list-main vayvo-episode-list-season-two-list">
		<?php    $entries = get_post_meta( get_the_ID(), 'progression_studios_display_season_two', true ); $count = 1; foreach ( (array) $entries as $key => $entry ) :   ?>
			<li class="progression-studios-episode-list-item">
				<div class="progression-episode-list-flex">
					
					<div class="progression-studios-episode-image-container">
						<div class="progression-episode-list-left-margin">
							
							<?php if(isset( $entry['progression_studios_episode_image'] ) && $entry['progression_studios_episode_image'] != '') : ?> 
								
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									<a href="Video-Season-2-Ep-<?php echo esc_attr($count);?>" class="afterglow">
										<div class="progression-episode-list-image-container">
										
									<?php endif; ?>
							
							
										<img src="<?php	
										$image_url = esc_url( $entry['progression_studios_episode_image']  );
										$image_id = progression_studios_get_image_id($image_url);
										$image_thumb = wp_get_attachment_image_src($image_id, 'progression-studios-video-related');
										echo esc_url($image_thumb[0]);
										?>" alt="<?php echo esc_attr( $entry['progression_studios_episode_title'] )?>">
							
							
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										
										<div class="progression-episode-list-overlay-play"><i class="fas fa-play"></i></div>
								      </div><!-- close .progression-episode-list-image-container -->
									</a>		
							      <div style="display:none;">
							         <video id="Video-Season-2-Ep-<?php echo esc_attr($count);?>" <?php if(isset( $entry['progression_studios_episode_video_poster'] ) && $entry['progression_studios_episode_video_poster'] != '') : ?> poster="<?php echo esc_attr( $entry['progression_studios_episode_video_poster'] )?>"<?php endif; ?> width="960" height="540" <?php if(isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != '' ) : ?> data-youtube-id="<?php echo esc_attr( $entry['progression_studios_episode_youtube_video'] )?>"<?php endif; ?> <?php if(isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != '') : ?> data-vimeo-id="<?php echo esc_attr( $entry['progression_studios_episode_vimeo_video'] )?>"<?php endif; ?>>
											<?php if(isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '') : ?>
												<source src="<?php echo esc_url( $entry['progression_studios_episode_video_mp4'] )?>" type="video/mp4">
											<?php endif; ?>
							         </video>
									<?php endif; ?>
								</div>
							<?php else: ?>
								<?php if(isset( $entry['progression_studios_episode_video_embed'] ) && $entry['progression_studios_episode_video_embed'] != '') : ?>	
									<div class="episode-video-list-embed-video">
										<span class="hide-embed-text"><?php echo esc_attr( $entry['progression_studios_episode_video_embed'] ); ?></span>
										<?php 
										$embed_video_code = $entry['progression_studios_episode_video_embed'];
										echo apply_filters('progression_studios_video_content_filter',  $embed_video_code ); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							
						</div><!-- close .progression-episode-list-left-margin -->
					</div><!-- close  .progression-studios-episode-image-container -->
	
					<div class="progression-studios-episode-right-container">
							<div class="progression-episode-list-right-margin">
								<?php if(isset( $entry['progression_studios_episode_title'] ) && $entry['progression_studios_episode_title'] != '') : ?>
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									<a href="Video-Season-2-Ep-<?php echo esc_attr($count);?>" class="afterglow">
									<?php endif; ?>
									<h2 class="progression-episode-list-title"><?php echo wp_kses(( $entry['progression_studios_episode_title'] ), true )?></h2>
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									</a>
									<?php endif; ?>
								<?php endif; ?>
		
								<?php if(get_post_meta($post->ID, 'progression_studios_season_title_two', true) || isset( $entry['progression_studios_episode_release_date'] ) || isset( $entry['progression_studios_episode_media_duration_meta'] ) ): ?>
								<ul class="progression-studios-episode-list-meta">
									<?php if(get_post_meta($post->ID, 'progression_studios_season_title_two', true)): ?><li class="progression-episode-season-meta-title"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_two', true)); ?></li><?php endif; ?>
									<?php if(isset( $entry['progression_studios_episode_release_date'] ) && $entry['progression_studios_episode_release_date'] != '') : ?><li class="progression-episode-list-meta-release-date"><?php  $episode_video_release_date = $entry['progression_studios_episode_release_date'] ; echo esc_attr(date_i18n(get_option('date_format'), strtotime($episode_video_release_date) )); ?></li><?php endif; ?>
			
									<?php if(isset( $entry['progression_studios_episode_media_duration_meta'] ) && $entry['progression_studios_episode_media_duration_meta'] != '') : ?><li class="progression-episode-list-meta-duration"><?php echo esc_attr( $entry['progression_studios_episode_media_duration_meta'] )?></li><?php endif; ?>
								</ul>
								<?php endif; ?>
		
								<?php if(isset( $entry['progression_studios_description'] ) && $entry['progression_studios_description'] != '') : ?><div class="progression-episode-list-short-description"><?php echo wp_kses (( $entry['progression_studios_description'] ), true)?></div><?php endif; ?>
							</div><!-- close .progression-episode-list-right-margin -->
					</div><!-- close  .progression-studios-episode-right-container -->
			
			<div class="clearfix-pro"></div>
			</div><!-- close .progression-episode-list-flex -->
			</li>
		<?php  $count++;  endforeach; ?>
	</ul>
	
	
	
	<?php wp_reset_postdata();?>
	<ul class="progression-studios-episode-list-main vayvo-episode-list-season-three-list">
		<?php    $entries = get_post_meta( get_the_ID(), 'progression_studios_display_season_three', true ); $count = 1; foreach ( (array) $entries as $key => $entry ) :   ?>
			<li class="progression-studios-episode-list-item">
				<div class="progression-episode-list-flex">
					
					<div class="progression-studios-episode-image-container">
						<div class="progression-episode-list-left-margin">
							
							<?php if(isset( $entry['progression_studios_episode_image'] ) && $entry['progression_studios_episode_image'] != '') : ?> 
								
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									<a href="Video-Season-3-Ep-<?php echo esc_attr($count);?>" class="afterglow">
										<div class="progression-episode-list-image-container">
										
									<?php endif; ?>
							
							
										<img src="<?php	
										$image_url = esc_url( $entry['progression_studios_episode_image']  );
										$image_id = progression_studios_get_image_id($image_url);
										$image_thumb = wp_get_attachment_image_src($image_id, 'progression-studios-video-related');
										echo esc_url($image_thumb[0]);
										?>" alt="<?php echo esc_attr( $entry['progression_studios_episode_title'] )?>">
							
							
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										
										<div class="progression-episode-list-overlay-play"><i class="fas fa-play"></i></div>
								      </div><!-- close .progression-episode-list-image-container -->
									</a>		
							      <div style="display:none;">
							         <video id="Video-Season-3-Ep-<?php echo esc_attr($count);?>" <?php if(isset( $entry['progression_studios_episode_video_poster'] ) && $entry['progression_studios_episode_video_poster'] != '') : ?> poster="<?php echo esc_attr( $entry['progression_studios_episode_video_poster'] )?>"<?php endif; ?> width="960" height="540" <?php if(isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != '' ) : ?> data-youtube-id="<?php echo esc_attr( $entry['progression_studios_episode_youtube_video'] )?>"<?php endif; ?> <?php if(isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != '') : ?> data-vimeo-id="<?php echo esc_attr( $entry['progression_studios_episode_vimeo_video'] )?>"<?php endif; ?>>
											<?php if(isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '') : ?>
												<source src="<?php echo esc_url( $entry['progression_studios_episode_video_mp4'] )?>" type="video/mp4">
											<?php endif; ?>
							         </video>
									<?php endif; ?>
								</div>
							<?php else: ?>
								<?php if(isset( $entry['progression_studios_episode_video_embed'] ) && $entry['progression_studios_episode_video_embed'] != '') : ?>	
									<div class="episode-video-list-embed-video">
										<span class="hide-embed-text"><?php echo esc_attr( $entry['progression_studios_episode_video_embed'] ); ?></span>
										<?php 
										$embed_video_code = $entry['progression_studios_episode_video_embed'];
										echo apply_filters('progression_studios_video_content_filter',  $embed_video_code ); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							
						</div><!-- close .progression-episode-list-left-margin -->
					</div><!-- close  .progression-studios-episode-image-container -->
	
					<div class="progression-studios-episode-right-container">
							<div class="progression-episode-list-right-margin">
								<?php if(isset( $entry['progression_studios_episode_title'] ) && $entry['progression_studios_episode_title'] != '') : ?>
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									<a href="Video-Season-3-Ep-<?php echo esc_attr($count);?>" class="afterglow">
									<?php endif; ?>
									<h2 class="progression-episode-list-title"><?php echo wp_kses(( $entry['progression_studios_episode_title'] ), true )?></h2>
									<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
									</a>
									<?php endif; ?>
								<?php endif; ?>
		
								<?php if(get_post_meta($post->ID, 'progression_studios_season_title_three', true) || isset( $entry['progression_studios_episode_release_date'] ) || isset( $entry['progression_studios_episode_media_duration_meta'] ) ): ?>
								<ul class="progression-studios-episode-list-meta">
									<?php if(get_post_meta($post->ID, 'progression_studios_season_title_three', true)): ?><li class="progression-episode-season-meta-title"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_three', true)); ?></li><?php endif; ?>
									<?php if(isset( $entry['progression_studios_episode_release_date'] ) && $entry['progression_studios_episode_release_date'] != '') : ?><li class="progression-episode-list-meta-release-date"><?php  $episode_video_release_date = $entry['progression_studios_episode_release_date'] ; echo esc_attr(date_i18n(get_option('date_format'), strtotime($episode_video_release_date) )); ?></li><?php endif; ?>
			
									<?php if(isset( $entry['progression_studios_episode_media_duration_meta'] ) && $entry['progression_studios_episode_media_duration_meta'] != '') : ?><li class="progression-episode-list-meta-duration"><?php echo esc_attr( $entry['progression_studios_episode_media_duration_meta'] )?></li><?php endif; ?>
								</ul>
								<?php endif; ?>
		
								<?php if(isset( $entry['progression_studios_description'] ) && $entry['progression_studios_description'] != '') : ?><div class="progression-episode-list-short-description"><?php echo wp_kses (( $entry['progression_studios_description'] ), true)?></div><?php endif; ?>
							</div><!-- close .progression-episode-list-right-margin -->
					</div><!-- close  .progression-studios-episode-right-container -->
			
			<div class="clearfix-pro"></div>
			</div><!-- close .progression-episode-list-flex -->
			</li>
		<?php  $count++;  endforeach; ?>
		
		</ul>
	
		<div class="clearfix-pro"></div>
		
		<?php wp_reset_postdata();?>
		<ul class="progression-studios-episode-list-main vayvo-episode-list-season-four-list">
			<?php    $entries = get_post_meta( get_the_ID(), 'progression_studios_display_season_four', true ); $count = 1; foreach ( (array) $entries as $key => $entry ) :   ?>
				<li class="progression-studios-episode-list-item">
					<div class="progression-episode-list-flex">
					
						<div class="progression-studios-episode-image-container">
							<div class="progression-episode-list-left-margin">
							
								<?php if(isset( $entry['progression_studios_episode_image'] ) && $entry['progression_studios_episode_image'] != '') : ?> 
								
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										<a href="Video-Season-4-Ep-<?php echo esc_attr($count);?>" class="afterglow">
											<div class="progression-episode-list-image-container">
										
										<?php endif; ?>
							
							
											<img src="<?php	
											$image_url = esc_url( $entry['progression_studios_episode_image']  );
											$image_id = progression_studios_get_image_id($image_url);
											$image_thumb = wp_get_attachment_image_src($image_id, 'progression-studios-video-related');
											echo esc_url($image_thumb[0]);
											?>" alt="<?php echo esc_attr( $entry['progression_studios_episode_title'] )?>">
							
							
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										
											<div class="progression-episode-list-overlay-play"><i class="fas fa-play"></i></div>
									      </div><!-- close .progression-episode-list-image-container -->
										</a>		
								      <div style="display:none;">
								         <video id="Video-Season-4-Ep-<?php echo esc_attr($count);?>" <?php if(isset( $entry['progression_studios_episode_video_poster'] ) && $entry['progression_studios_episode_video_poster'] != '') : ?> poster="<?php echo esc_attr( $entry['progression_studios_episode_video_poster'] )?>"<?php endif; ?> width="960" height="540" <?php if(isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != '' ) : ?> data-youtube-id="<?php echo esc_attr( $entry['progression_studios_episode_youtube_video'] )?>"<?php endif; ?> <?php if(isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != '') : ?> data-vimeo-id="<?php echo esc_attr( $entry['progression_studios_episode_vimeo_video'] )?>"<?php endif; ?>>
												<?php if(isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '') : ?>
													<source src="<?php echo esc_url( $entry['progression_studios_episode_video_mp4'] )?>" type="video/mp4">
												<?php endif; ?>
								         </video>
										<?php endif; ?>
									</div>
								<?php else: ?>
									<?php if(isset( $entry['progression_studios_episode_video_embed'] ) && $entry['progression_studios_episode_video_embed'] != '') : ?>	
										<div class="episode-video-list-embed-video">
											<span class="hide-embed-text"><?php echo esc_attr( $entry['progression_studios_episode_video_embed'] ); ?></span>
											<?php 
											$embed_video_code = $entry['progression_studios_episode_video_embed'];
											echo apply_filters('progression_studios_video_content_filter',  $embed_video_code ); ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							
							</div><!-- close .progression-episode-list-left-margin -->
						</div><!-- close  .progression-studios-episode-image-container -->
	
						<div class="progression-studios-episode-right-container">
								<div class="progression-episode-list-right-margin">
									<?php if(isset( $entry['progression_studios_episode_title'] ) && $entry['progression_studios_episode_title'] != '') : ?>
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										<a href="Video-Season-4-Ep-<?php echo esc_attr($count);?>" class="afterglow">
										<?php endif; ?>
										<h2 class="progression-episode-list-title"><?php echo wp_kses(( $entry['progression_studios_episode_title'] ), true )?></h2>
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										</a>
										<?php endif; ?>
									<?php endif; ?>
		
									<?php if(get_post_meta($post->ID, 'progression_studios_season_title_four', true) || isset( $entry['progression_studios_episode_release_date'] ) || isset( $entry['progression_studios_episode_media_duration_meta'] ) ): ?>
									<ul class="progression-studios-episode-list-meta">
										<?php if(get_post_meta($post->ID, 'progression_studios_season_title_four', true)): ?><li class="progression-episode-season-meta-title"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_four', true)); ?></li><?php endif; ?>
										<?php if(isset( $entry['progression_studios_episode_release_date'] ) && $entry['progression_studios_episode_release_date'] != '') : ?><li class="progression-episode-list-meta-release-date"><?php  $episode_video_release_date = $entry['progression_studios_episode_release_date'] ; echo esc_attr(date_i18n(get_option('date_format'), strtotime($episode_video_release_date) )); ?></li><?php endif; ?>
			
										<?php if(isset( $entry['progression_studios_episode_media_duration_meta'] ) && $entry['progression_studios_episode_media_duration_meta'] != '') : ?><li class="progression-episode-list-meta-duration"><?php echo esc_attr( $entry['progression_studios_episode_media_duration_meta'] )?></li><?php endif; ?>
									</ul>
									<?php endif; ?>
		
									<?php if(isset( $entry['progression_studios_description'] ) && $entry['progression_studios_description'] != '') : ?><div class="progression-episode-list-short-description"><?php echo wp_kses (( $entry['progression_studios_description'] ), true)?></div><?php endif; ?>
								</div><!-- close .progression-episode-list-right-margin -->
						</div><!-- close  .progression-studios-episode-right-container -->
			
				<div class="clearfix-pro"></div>
				</div><!-- close .progression-episode-list-flex -->
				</li>
			<?php  $count++;  endforeach; ?>
		
		
	</ul>
	
	<div class="clearfix-pro"></div>
	
	
	
		<?php wp_reset_postdata();?>
		<ul class="progression-studios-episode-list-main vayvo-episode-list-season-five-list">
			<?php    $entries = get_post_meta( get_the_ID(), 'progression_studios_display_season_five', true ); $count = 1; foreach ( (array) $entries as $key => $entry ) :   ?>
				<li class="progression-studios-episode-list-item">
					<div class="progression-episode-list-flex">
					
						<div class="progression-studios-episode-image-container">
							<div class="progression-episode-list-left-margin">
							
								<?php if(isset( $entry['progression_studios_episode_image'] ) && $entry['progression_studios_episode_image'] != '') : ?> 
								
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										<a href="Video-Season-5-Ep-<?php echo esc_attr($count);?>" class="afterglow">
											<div class="progression-episode-list-image-container">
										
										<?php endif; ?>
							
							
											<img src="<?php	
											$image_url = esc_url( $entry['progression_studios_episode_image']  );
											$image_id = progression_studios_get_image_id($image_url);
											$image_thumb = wp_get_attachment_image_src($image_id, 'progression-studios-video-related');
											echo esc_url($image_thumb[0]);
											?>" alt="<?php echo esc_attr( $entry['progression_studios_episode_title'] )?>">
							
							
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										
											<div class="progression-episode-list-overlay-play"><i class="fas fa-play"></i></div>
									      </div><!-- close .progression-episode-list-image-container -->
										</a>		
								      <div style="display:none;">
								         <video id="Video-Season-5-Ep-<?php echo esc_attr($count);?>" <?php if(isset( $entry['progression_studios_episode_video_poster'] ) && $entry['progression_studios_episode_video_poster'] != '') : ?> poster="<?php echo esc_attr( $entry['progression_studios_episode_video_poster'] )?>"<?php endif; ?> width="960" height="540" <?php if(isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != '' ) : ?> data-youtube-id="<?php echo esc_attr( $entry['progression_studios_episode_youtube_video'] )?>"<?php endif; ?> <?php if(isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != '') : ?> data-vimeo-id="<?php echo esc_attr( $entry['progression_studios_episode_vimeo_video'] )?>"<?php endif; ?>>
												<?php if(isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '') : ?>
													<source src="<?php echo esc_url( $entry['progression_studios_episode_video_mp4'] )?>" type="video/mp4">
												<?php endif; ?>
								         </video>
										<?php endif; ?>
									</div>
								<?php else: ?>
									<?php if(isset( $entry['progression_studios_episode_video_embed'] ) && $entry['progression_studios_episode_video_embed'] != '') : ?>	
										<div class="episode-video-list-embed-video">
											<span class="hide-embed-text"><?php echo esc_attr( $entry['progression_studios_episode_video_embed'] ); ?></span>
											<?php 
											$embed_video_code = $entry['progression_studios_episode_video_embed'];
											echo apply_filters('progression_studios_video_content_filter',  $embed_video_code ); ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							
							</div><!-- close .progression-episode-list-left-margin -->
						</div><!-- close  .progression-studios-episode-image-container -->
	
						<div class="progression-studios-episode-right-container">
								<div class="progression-episode-list-right-margin">
									<?php if(isset( $entry['progression_studios_episode_title'] ) && $entry['progression_studios_episode_title'] != '') : ?>
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										<a href="Video-Season-5-Ep-<?php echo esc_attr($count);?>" class="afterglow">
										<?php endif; ?>
										<h2 class="progression-episode-list-title"><?php echo wp_kses(( $entry['progression_studios_episode_title'] ), true )?></h2>
										<?php if( ( isset( $entry['progression_studios_episode_video_mp4'] ) && $entry['progression_studios_episode_video_mp4'] != '' ) || isset( $entry['progression_studios_episode_youtube_video'] ) && $entry['progression_studios_episode_youtube_video'] != ''  || isset( $entry['progression_studios_episode_vimeo_video'] ) && $entry['progression_studios_episode_vimeo_video'] != ''  ) : ?>
										</a>
										<?php endif; ?>
									<?php endif; ?>
		
									<?php if(get_post_meta($post->ID, 'progression_studios_season_title_five', true) || isset( $entry['progression_studios_episode_release_date'] ) || isset( $entry['progression_studios_episode_media_duration_meta'] ) ): ?>
									<ul class="progression-studios-episode-list-meta">
										<?php if(get_post_meta($post->ID, 'progression_studios_season_title_five', true)): ?><li class="progression-episode-season-meta-title"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_season_title_five', true)); ?></li><?php endif; ?>
										<?php if(isset( $entry['progression_studios_episode_release_date'] ) && $entry['progression_studios_episode_release_date'] != '') : ?><li class="progression-episode-list-meta-release-date"><?php  $episode_video_release_date = $entry['progression_studios_episode_release_date'] ; echo esc_attr(date_i18n(get_option('date_format'), strtotime($episode_video_release_date) )); ?></li><?php endif; ?>
			
										<?php if(isset( $entry['progression_studios_episode_media_duration_meta'] ) && $entry['progression_studios_episode_media_duration_meta'] != '') : ?><li class="progression-episode-list-meta-duration"><?php echo esc_attr( $entry['progression_studios_episode_media_duration_meta'] )?></li><?php endif; ?>
									</ul>
									<?php endif; ?>
		
									<?php if(isset( $entry['progression_studios_description'] ) && $entry['progression_studios_description'] != '') : ?><div class="progression-episode-list-short-description"><?php echo wp_kses (( $entry['progression_studios_description'] ), true)?></div><?php endif; ?>
								</div><!-- close .progression-episode-list-right-margin -->
						</div><!-- close  .progression-studios-episode-right-container -->
			
				<div class="clearfix-pro"></div>
				</div><!-- close .progression-episode-list-flex -->
				</li>
			<?php  $count++;  endforeach; ?>
		
		
	</ul>
	
	<div class="clearfix-pro"></div>
</div><!-- close .vayvo-progression-video-season-container -->