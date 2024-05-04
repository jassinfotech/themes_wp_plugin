<div id="main-nav-mobile">
	<?php wp_nav_menu( array('theme_location' => 'progression-studios-landing-page', 'menu_class' => 'mobile-menu-pro', 'fallback_cb' => false, 'walker'  => new ProgressionFrontendWalker ) ); ?>
	
	<?php if (  is_user_logged_in() ) :  
		$current_user = wp_get_current_user(); 
		$user_id = get_current_user_id();  
	?>
		<div id="skrn-landing-mobile-login-logout-header">
			<a href="<?php echo esc_url(wp_logout_url( home_url()) )?>"><?php esc_html_e( 'Log Out', 'skrn-progression' ); ?></a>
		</div><!-- close #skrn-landing-mobile-login-logout-header -->
	<?php else: ?>
		<?php if(function_exists('arm_check_for_wp_rename')  ): ?>
		<div id="skrn-landing-mobile-login-logout-header">
			<?php 
			$login_text = esc_html__('Log In' , 'skrn-progression');
			echo do_shortcode('[arm_form id="102" assign_default_plan="0" popup="true" link_type="link" link_title="' . $login_text . '" overlay="0.85" modal_bgcolor="#ffffff" popup_height="auto" popup_width="700" link_css="" link_hover_css="" form_position="center" assign_default_plan="0" logged_in_message="You are already logged in."]'); ?>
		</div><!-- close #skrn-landing-mobile-login-logout-header -->
		<?php endif; ?>
	<?php endif; ?>
	
	<div class="sidebar progression-studios-mobile-sidebar"><?php dynamic_sidebar( 'progression-studios-mobile-sidebar-landing' ); ?></div>
			
	<div class="clearfix-pro"></div>
</div><!-- close #main-nav-mobile -->