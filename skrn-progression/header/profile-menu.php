<?php if (  is_user_logged_in() ) :  
	$current_user = wp_get_current_user(); 
	$user_id = get_current_user_id();  
?>
	<div id="header-user-profile">
		<div id="header-user-profile-click" class="noselect">
			<div id="avatar-small-header-skrn-progression" style="background-image:url('<?php if($current_user->avatar): ?><?php echo esc_url($current_user->avatar);  ?><?php else: ?><?php echo get_avatar_url( $current_user->user_email, 200 ); ?><?php endif; ?>')"></div>
			<div id="header-username"><?php echo esc_attr($current_user->display_name); ?></div><i class="fas fa-angle-down"></i>
		</div><!-- close #header-user-profile-click -->
				<div id="header-user-profile-menu">
					<ul>
						<?php if (get_theme_mod( 'progression_studios_dashboard_profile_header_my_profile', 'true') == 'true') : ?><li class="skrn-header-user-my-profile"><a href="<?php progression_studios_profile_link(); ?>"><span class="icon-User"></span><?php esc_html_e( 'My Profile', 'skrn-progression' ); ?></a></li><?php endif; ?>
						<?php if(function_exists('arm_check_for_wp_rename')  ): 
							global $arm_global_settings;
							$global_settings = $arm_global_settings->global_settings;
						?>
						<?php if (get_theme_mod( 'progression_studios_dashboard_profile_header_edit_profile', 'true') == 'true') : ?><li class="skrn-header-user-edit-profile"><a href="<?php echo esc_url( $arm_global_settings->arm_get_permalink('', $global_settings['edit_profile_page_id']) ); ?>"><span class="icon-Gears"></span><?php esc_html_e( 'Edit Profile', 'skrn-progression' ); ?></a></li><?php endif; ?>
						<?php endif; ?>
						<?php if (get_theme_mod( 'progression_studios_dashboard_profile_header_my_wathclist', 'true') == 'true') : ?><li class="skrn-header-user-my-watchlist"><a href="<?php progression_studios_profile_link(); ?>"><span class="icon-Bulleted-List"></span><?php esc_html_e( 'My Watchlist', 'skrn-progression' ); ?></a></li><?php endif; ?>
						<?php if (get_theme_mod( 'progression_studios_dashboard_profile_header_my_favorites', 'false') == 'true') : ?><li class="skrn-header-user-my-favorites"><a href="<?php progression_studios_profile_link(); ?>?favorites"><span class="icon-Favorite-Window"></span><?php esc_html_e( 'My Favorites', 'skrn-progression' ); ?></a></li><?php endif; ?>
						<?php wp_nav_menu( array('theme_location' => 'progression-studios-profile-menu', 'menu_class' => 'skrn-additional-profile-items', 'container' => false, 'fallback_cb' => false, 'walker'  => new ProgressionFrontendWalker ) ); ?>
						<?php if (get_theme_mod( 'progression_studios_dashboard_profile_header_logout', 'true') == 'true') : ?><li class="skrn-header-user-logout"><a href="<?php echo esc_url(wp_logout_url( home_url()) )?>"><span class="icon-Power-3"></span><?php esc_html_e( 'Log Out', 'skrn-progression' ); ?></a></li><?php endif; ?>
					</ul>
				</div><!-- close #header-user-profile-menu -->
			</div><!-- close #header-user-profile -->
<?php else: ?>
	<?php if(function_exists('arm_check_for_wp_rename')  ): ?>
	<div id="skrn-header-user-profile-login">
		<?php 
		$login_text = esc_html__('Log In' , 'skrn-progression');
		echo do_shortcode('[arm_form id="102" assign_default_plan="0" popup="true" link_type="link" link_title="' . $login_text . '" overlay="0.85" modal_bgcolor="#ffffff" popup_height="auto" popup_width="700" link_css="" link_hover_css="" form_position="center" assign_default_plan="0" logged_in_message="You are already logged in."]'); ?>
	</div>
	<?php endif; ?>
<?php endif; ?>