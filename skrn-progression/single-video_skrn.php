<?php
/**
 * The template for displaying all single posts.
 *
 * @package pro
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div id="content-sidebar-pro" class="hide-on-mobile-pro">

		<?php if( get_post_meta($post->ID, 'progression_studios_poster_image', true) ): ?>
			<div class="content-sidebar-image noselect">
				<img src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_poster_image', true)); ?>" alt="<?php the_title(); ?>">
			</div>
		<?php else: ?>
			<?php if(has_post_thumbnail()): ?>
				<div class="content-sidebar-image noselect">
					<?php the_post_thumbnail('progression-studios-video-poster'); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<div class="content-sidebar-section">
			<h2 class="content-sidebar-sub-header"><?php the_title(); ?></h2>
			
			<?php if( get_post_meta($post->ID, 'progression_studios_film_rating', true) || get_post_meta($post->ID, 'progression_studios_screen_resolution', true)  ): ?>
			<ul class="progression-studios-slider-rating">
				<?php if( get_post_meta($post->ID, 'progression_studios_film_rating', true) ): ?><li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_film_rating', true)); ?></li><?php endif; ?>
				<?php if( get_post_meta($post->ID, 'progression_studios_screen_resolution', true) ): ?><li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_screen_resolution', true)); ?></li><?php endif; ?>
			</ul>
			<?php endif; ?>
			
		</div><!-- close .content-sidebar-section -->
		
		<?php if (get_theme_mod( 'progression_studios_media_grenre_sidebar', 'false') == 'true') : ?>
		<?php 
			$terms = get_the_terms( $post->ID , 'video-genres' ); 
			if ( !empty( $terms ) ) :
				echo '<div class="content-sidebar-section video-sidebar-section-director"><h4 class="content-sidebar-sub-header">';
				echo  esc_html_e( 'Genre', 'skrn-progression');
				echo '</h4><ul class="video-grenes-mega-sidebar">';
			foreach ( $terms as $term ) {
				$term_link = get_term_link( $term, 'video-genres' );
				$term_photo = get_term_meta( $term->term_id, 'progression_studios_cast_Photo', true);
				if( is_wp_error( $term_link ) )
					continue;
				echo '<li><a href="' . $term_link . '"><div class="skrn-video-cast-genre-icon-sidebar" style="background-image:url(' . $term_photo . ')"></div>' . $term->name . '</a></li>';
			} 
			echo '</ul></div>';
		endif;
		?>
		<?php endif; ?>
		
		
		<?php if (get_theme_mod( 'progression_studios_media_releases_date_sidebar', 'true') == 'true') : ?>
		<?php if( get_post_meta($post->ID, 'progression_studios_release_date', true) ): ?>
		<div class="content-sidebar-section video-sidebar-section-release-date">
			<h4 class="content-sidebar-sub-header"><?php esc_html_e( 'Release Date', 'skrn-progression' ); ?></h4>
			<div class="content-sidebar-short-description"><?php 
				$video_release_date = get_post_meta($post->ID, 'progression_studios_release_date', true);
				echo esc_attr(date_i18n('j F, Y',strtotime($video_release_date) )); ?></div>
		</div><!-- close .content-sidebar-section -->
		<?php endif; ?>
		<?php endif; ?>
		
		
		<?php if (get_theme_mod( 'progression_studios_media_duration_sidebar', 'true') == 'true') : ?>
		<?php if( get_post_meta($post->ID, 'progression_studios_media_duration_meta', true) ): ?>
		<div class="content-sidebar-section video-sidebar-section-length">
			<h4 class="content-sidebar-sub-header"><?php esc_html_e( 'Duration', 'skrn-progression' ); ?></h4>
			<div class="content-sidebar-short-description"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_media_duration_meta', true)); ?></div>
		</div><!-- close .content-sidebar-section -->
		<?php endif; ?>
		<?php endif; ?>
		
		
		<?php if (get_theme_mod( 'progression_studios_media_director_sidebar', 'true') == 'true') : ?>
		<?php 
			$terms = get_the_terms( $post->ID , 'video-director' ); 
			if ( !empty( $terms ) ) :
				echo '<div class="content-sidebar-section video-sidebar-section-director"><h4 class="content-sidebar-sub-header">';
				echo  esc_html_e( 'Director', 'skrn-progression');
				echo '</h4><ul class="video-director-mega-sidebar">';
			foreach ( $terms as $term ) {
				$term_link = get_term_link( $term, 'video-director' );
				if( is_wp_error( $term_link ) )
					continue;
				echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
			} 
			echo '</ul></div>';
		endif;
		?>
		<?php endif; ?>
		
		
		<?php if (get_theme_mod( 'progression_studios_media_recent_reviews_sidebar', 'true') == 'true') : ?>
		<?php get_template_part( 'template-parts/comments/comments', 'sidebar' ); ?>
		<?php endif; ?>
		
	</div><!-- close #content-sidebar-pro -->
	
	<div id="col-main-with-sidebar">
		
		<?php if( get_post_meta($post->ID, 'progression_studios_video_post', true) || get_post_meta($post->ID, 'progression_studios_youtube_video', true) || get_post_meta($post->ID, 'progression_studios_header_image', true) || get_post_meta($post->ID, 'progression_studios_vimeo_video', true) ||  get_post_meta($post->ID, 'progression_studios_video_embed', true) ): ?>
		<div <?php if( get_post_meta($post->ID, 'progression_studios_video_embed', true) ): ?>id="embedded-video-audio-detail-header-pro"<?php else: ?>id="movie-detail-header-pro"<?php endif; ?> <?php if( get_post_meta($post->ID, 'progression_studios_header_image', true) ): ?>style="background-image:url('<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_header_image', true)); ?>')"<?php endif; ?>>
			
			<div class="progression-studios-slider-more-options">
				<i class="fas fa-ellipsis-h"></i>
				<ul>
					<li class="favorites-hero"><?php progression_the_favorite_button() ?></li>
					<li class="watchlist-hero"><?php progression_the_wishlist_button() ?></li>
					<?php if (function_exists( 'progression_studios_elements_social_sharing') && get_theme_mod( 'progression_studios_blog_post_sharing', 'on') == 'on' )  : ?><li class="share-this-hero"><a href="#!"><?php esc_html_e( 'Social Share...', 'skrn-progression' ); ?></a></li><?php endif; ?>
					<li class="write-review-hero"><a href="#!"><?php esc_html_e( 'Write A Review', 'skrn-progression' ); ?></a></li>
				</ul>
			</div><!-- close .progression-studios-slider-more-options -->
			
			<?php if( get_post_meta($post->ID, 'progression_studios_video_post', true) || get_post_meta($post->ID, 'progression_studios_youtube_video', true) || get_post_meta($post->ID, 'progression_studios_vimeo_video', true) ): ?>
			<a class="movie-detail-header-play-btn afterglow" href="#VideoLightbox-Main"><i class="fas fa-play"></i></a>
         <div style="display:none;">
	         <video id="VideoLightbox-Main"  <?php if( get_post_meta($post->ID, 'progression_studios_video_embed_poster', true) ): ?>poster="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_video_embed_poster', true)); ?>"<?php endif; ?> width="960" height="540" <?php if( get_post_meta($post->ID, 'progression_studios_youtube_video', true)): ?>data-youtube-id="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_youtube_video', true)); ?>"<?php endif; ?> <?php if( get_post_meta($post->ID, 'progression_studios_vimeo_video', true)): ?>data-vimeo-id="<?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_vimeo_video', true)); ?>"<?php endif; ?>>
					 <?php if( get_post_meta($post->ID, 'progression_studios_video_post', true)): ?><source src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_video_post', true)); ?>" type="video/mp4"><?php endif; ?>
	         </video>
         </div>
			
			<?php else: ?>
				<?php if( get_post_meta($post->ID, 'progression_studios_video_embed', true)  ): ?>
				<div id="skrn-single-video-embed"><?php echo apply_filters('progression_studios_video_content_filter', get_post_meta($post->ID, 'progression_studios_video_embed', true)); ?></div>
				<?php endif; ?>
			<?php endif; ?>
			

			<?php do_action( 'skrn_notices', '<div class="login-required-notice"><div class="login-notify-text">%s</div></div>' ) ?>


			<div id="movie-detail-gradient-pro"></div>
		</div><!-- close #movie-detail-header-pro -->
		<?php endif; ?>
		
		
		<div id="movie-detail-rating">
			<div class="dashboard-container">
				<div class="grid2column-progression">
					<?php if( is_user_logged_in()   ): ?>
						<?php
						//https://deluxeblogtips.com/display-comments-in-homepage/
						$comments = get_comments( array(
						    'post_id' => get_the_ID(),
							 'author__in' => get_current_user_id(),
						) );
						?>
						
						<?php if( $comments ): ?>
							
							<h5><?php esc_html_e( 'You Rated', 'skrn-progression' ); ?> <?php the_title();?></h5>
							<div class="rate-this-video-skrn-pro">
					    		<?php
						    	wp_list_comments( array(
									'per_page'          => '1',
									'callback' => 'progression_studios_review_callback',
									'type'     => 'comment',
								), $comments );
					    		?>
							</div><!-- close .rate-this-video-skrn-pro -->
						 		
						<?php else: ?>
							<h5 class="rating-click-to-rate-skrn"><?php esc_html_e( 'Rate', 'skrn-progression' ); ?> <?php the_title();?></h5>
							<div class="rate-this-video-skrn-pro rating-click-to-rate-skrn">
								<div class="rate-this-video-skrn-pro">
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
									<span class="dashicons dashicons-star-empty"></span>
								</div><!-- close .rate-this-video-skrn-pro -->
							</div><!-- close .rate-this-video-skrn-pro -->
						<?php endif; ?>

					<?php else: ?>
						<h5 id="skrn-require-login-holder"><?php if(function_exists('arm_check_for_wp_rename')  ): ?><?php
							echo '<i class="fa fa-exclamation-circle"></i> ';
							echo esc_html__('Please ','skrn-progression');
							$login_text = esc_html__('Log in' , 'skrn-progression');
							echo do_shortcode('[arm_form id="102" assign_default_plan="0" popup="true" link_type="link" link_title="' . $login_text . '" overlay="0.85" modal_bgcolor="#ffffff" popup_height="auto" popup_width="700" link_css="" link_hover_css="" form_position="center" assign_default_plan="0" logged_in_message="You are already logged in."]');
							echo esc_html__(' to rate & review','skrn-progression');
							;?><?php else: ?><?php echo esc_html__('Please Log in to rate & review','skrn-progression'); ?><?php endif; ?></h5>
							<div class="rate-this-video-skrn-pro">
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
								<span class="dashicons dashicons-star-empty"></span>
							</div><!-- close .rate-this-video-skrn-pro -->
					<?php endif; ?>
					
					
				</div>
				<div class="grid2column-progression lastcolumn-progression">
					<?php if ( skrn_pro_comment_rating_get_average_ratings( $post->ID ) ) : ?>
						<h6><?php esc_html_e( 'User Rating', 'skrn-progression' ); ?></h6>
			      	
						
							
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
			</div><!-- close .dashboard-container -->
		</div><!-- close #movie-detail-rating -->
		
		
		<div class="display-on-mobile-pro">
			<?php if( get_post_meta($post->ID, 'progression_studios_poster_image', true) ): ?>
				<div class="content-sidebar-image noselect">
					<img src="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_poster_image', true)); ?>" alt="<?php the_title(); ?>">
				</div>
			<?php endif; ?>
		
			<div class="content-sidebar-section">
				<h2 class="content-sidebar-sub-header"><?php the_title(); ?></h2>
				
				
				
				
				<?php if( get_post_meta($post->ID, 'progression_studios_film_rating', true) || get_post_meta($post->ID, 'progression_studios_screen_resolution', true)  ): ?>
				<ul class="progression-studios-slider-rating">
					<?php if( get_post_meta($post->ID, 'progression_studios_film_rating', true) ): ?><li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_film_rating', true)); ?></li><?php endif; ?>
					<?php if( get_post_meta($post->ID, 'progression_studios_screen_resolution', true) ): ?><li><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_screen_resolution', true)); ?></li><?php endif; ?>
				</ul>
				<?php endif; ?>
			
			</div><!-- close .content-sidebar-section -->
		
			
			<?php if (get_theme_mod( 'progression_studios_media_grenre_sidebar', 'false') == 'true') : ?>
			<?php 
				$terms = get_the_terms( $post->ID , 'video-genres' ); 
				if ( !empty( $terms ) ) :
					echo '<div class="content-sidebar-section video-sidebar-section-director"><h4 class="content-sidebar-sub-header">';
					echo  esc_html_e( 'Genre', 'skrn-progression');
					echo '</h4><ul class="video-grenes-mega-sidebar">';
				foreach ( $terms as $term ) {
					$term_link = get_term_link( $term, 'video-genres' );
					$term_photo = get_term_meta( $term->term_id, 'progression_studios_cast_Photo', true);
					if( is_wp_error( $term_link ) )
						continue;
					echo '<li><a href="' . $term_link . '"><div class="skrn-video-cast-genre-icon-sidebar" style="background-image:url(' . $term_photo . ')"></div>' . $term->name . '</a></li>';
				} 
				echo '</ul></div>';
			endif;
			?>
			<?php endif; ?>


			<?php if (get_theme_mod( 'progression_studios_media_releases_date_sidebar', 'true') == 'true') : ?>
			<?php if( get_post_meta($post->ID, 'progression_studios_release_date', true) ): ?>
			<div class="content-sidebar-section video-sidebar-section-release-date">
				<h4 class="content-sidebar-sub-header"><?php esc_html_e( 'Release Date', 'skrn-progression' ); ?></h4>
				<div class="content-sidebar-short-description"><?php 
					$video_release_date = get_post_meta($post->ID, 'progression_studios_release_date', true);
					echo esc_attr(date_i18n('j F, Y',strtotime($video_release_date) )); ?></div>
			</div><!-- close .content-sidebar-section -->
			<?php endif; ?>
			<?php endif; ?>
		
			<?php if (get_theme_mod( 'progression_studios_media_duration_sidebar', 'true') == 'true') : ?>
			
			<?php if( get_post_meta($post->ID, 'progression_studios_media_duration_meta', true) ): ?>
			<div class="content-sidebar-section video-sidebar-section-length">
				<h4 class="content-sidebar-sub-header"><?php esc_html_e( 'Duration', 'skrn-progression' ); ?></h4>
				<div class="content-sidebar-short-description"><?php echo esc_attr( get_post_meta($post->ID, 'progression_studios_media_duration_meta', true)); ?></div>
			</div><!-- close .content-sidebar-section -->
			<?php endif; ?>
		<?php endif; ?>
		
		
		<?php if (get_theme_mod( 'progression_studios_media_director_sidebar', 'true') == 'true') : ?>
			<?php 
				$terms = get_the_terms( $post->ID , 'video-director' ); 
				if ( !empty( $terms ) ) :
					echo '<div class="content-sidebar-section video-sidebar-section-director"><h4 class="content-sidebar-sub-header">';
					echo  esc_html_e( 'Director', 'skrn-progression');
					echo '</h4><ul class="video-director-mega-sidebar">';
				foreach ( $terms as $term ) {
					$term_link = get_term_link( $term, 'video-director' );
					if( is_wp_error( $term_link ) )
						continue;
					echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
				} 
				echo '</ul></div>';
			endif;
			?>
			<?php endif; ?>
			
			<?php if (get_theme_mod( 'progression_studios_media_recent_reviews_sidebar', 'true') == 'true') : ?>
			<?php get_template_part( 'template-parts/comments/comments', 'sidebar' ); ?>
			<?php endif; ?>
		</div><!-- close .display-on-mobile -->
		
		<div class="dashboard-container">

			
			<div class="movie-details-content-section">
				<?php the_content(); ?>
				<div class="clearfix-pro"></div>
			</div><!-- close .movie-details-content-section -->
			
			<?php wp_reset_postdata();?>
			<?php if (get_theme_mod( 'progression_studios_media_lead_cast', 'true') == 'true') : ?>
			<?php get_template_part( 'template-parts/cast', 'posts' ); ?>
			<?php endif; ?>
			
			<?php if(get_post_meta($post->ID, 'progression_studios_season_title', true)): ?>
				<?php get_template_part( 'template-parts/season', 'episodes' ); ?>		
			<?php endif; ?>
		
			<?php if (get_theme_mod( 'progression_studios_media_more_like_this', 'true') == 'true' && !get_post_meta($post->ID, 'progression_studios_season_title', true)) : ?>
				<?php get_template_part( 'template-parts/related', 'posts' ); ?>
			<?php endif; ?>

			
	
		</div><!-- close .dashboard-container -->
		
		<div class="clearfix-pro"></div>
	</div> <!-- close #col-main-with-sidebar -->

	
</div><!-- #post-## -->


<?php if (function_exists( 'progression_studios_elements_social_sharing') )  : ?><?php progression_studios_elements_social_sharing(); ?><?php endif; ?>


<?php get_template_part( 'template-parts/comments/comments', 'popup' ); ?>



<?php endwhile; // end of the loop. ?>			
<?php get_footer(); ?>