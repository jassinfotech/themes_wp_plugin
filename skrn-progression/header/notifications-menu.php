<?php if (  is_user_logged_in() ) : ?>
	<div id="header-user-notification">
		<div id="header-user-notification-click" class="noselect">
			<i class="far fa-bell"></i>
			<span class="user-notification-count">!</span>
		</div><!-- close #header-user-profile-click -->
		<div id="header-user-notification-menu">
			<h3><?php esc_html_e( 'Notifications', 'skrn-progression' ); ?></h3>
			<div id="header-notification-menu-padding">
				
				<?php
			 	$notificationsloop = new WP_Query(
			 		array(
			 	        'post_type' => 'notifications_skrn',
			 	        'posts_per_page' => 10,
			 		)
			  	);					
				if($notificationsloop->have_posts()):
				?>
				
					<ul id="header-user-notification-list">
						
						<?php while($notificationsloop->have_posts()): $notificationsloop->the_post();?>
							<li id="video-notification-<?php the_ID(); ?>" <?php if(has_post_thumbnail()): ?> class="progression-notification-with-image"<?php endif; ?>>
								<?php if(get_post_meta($post->ID, 'progression_studios_notification_link', true)): ?>
									<a href="<?php echo esc_url( get_post_meta($post->ID, 'progression_studios_notification_link', true) );?>">
								<?php else: ?>
									<a href="#!">
								<?php endif; ?>
									<?php if(has_post_thumbnail()): ?><?php the_post_thumbnail('progression-studios-notifications'); ?><?php endif; ?><?php the_title(); ?><div class="header-user-notify-time"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?> <?php esc_html_e('ago','skrn-progression'); ?></div>
								</a>
							</li>
						<?php  endwhile; // end of the loop. ?>
					</ul>
					
				<?php else: ?>
					
					<div id="header-user-notification-none"><?php esc_html_e( 'No new notifications at this time', 'skrn-progression' ); ?></div>
					
				<?php endif; ?>
				
				<?php wp_reset_postdata();?>
					<div class="clearfix"></div>
				</div><!-- close #header-user-profile-menu -->
			</div>
	</div><!-- close #header-user-notification -->
<?php endif; ?>