<div id="main-nav-mobile">
	<?php if ( has_nav_menu( 'progression-studios-mobile-menu' ) ):  ?>
		<?php wp_nav_menu( array('theme_location' => 'progression-studios-mobile-menu', 'menu_class' => 'mobile-menu-pro', 'fallback_cb' => false, 'walker'  => new ProgressionFrontendWalker ) ); ?>
	<?php else: ?>
		<?php wp_nav_menu( array('theme_location' => 'progression-studios-primary', 'menu_class' => 'mobile-menu-pro', 'fallback_cb' => false, 'walker'  => new ProgressionFrontendWalker ) ); ?>
	<?php endif; ?>
	
	
	<?php if (  is_user_logged_in() ) :  
		$current_user = wp_get_current_user(); 
		$user_id = get_current_user_id();  
	?>
	<?php else: ?>
		<?php if(function_exists('arm_check_for_wp_rename')  ): ?>
		<div id="skrn-landing-mobile-login-logout-header">
			<?php 
			$login_text = esc_html__('Log In' , 'skrn-progression');
			echo do_shortcode('[arm_form id="102" assign_default_plan="0" popup="true" link_type="link" link_title="' . $login_text . '" overlay="0.85" modal_bgcolor="#ffffff" popup_height="auto" popup_width="700" link_css="" link_hover_css="" form_position="center" assign_default_plan="0" logged_in_message="You are already logged in."]'); ?>
		</div><!-- close #skrn-landing-mobile-login-logout-header -->
		<?php endif; ?>
	<?php endif; ?>
	
	
	
	<?php
		$mobilevideourl = get_post_type_archive_link('video_skrn');
		if(!isset($_GET['search_keyword'])) { $_GET['search_keyword'] = ''; }
		if(!isset($_GET['vtype'])) { $_GET['vtype'] = ''; }
		if(!isset($_GET['vgenre'])) { $_GET['vgenre'] = ''; }
		if(!isset($_GET['vduration'])) { $_GET['vduration'] = ''; }
		if(!isset($_GET['vrating'])) { $_GET['vrating'] = ''; }
		if(!isset($_GET['vcategory'])) { $_GET['vcategory'] = ''; }
		if(!isset($_GET['vdirector'])) { $_GET['vdirector'] = ''; }
	?>
	<div id="skrn-mobile-video-search-header">
		<form method="get" class="mobile-searchform-video-header" action="<?php echo esc_url($mobilevideourl); ?>">
			<div id="tablet-mobile-search-icon-more"></div>
			<input type="hidden" name="post_type" value="video_skrn" />
			<input type="text" class="skrn-mobile-search-field-progression" name="search_keyword" placeholder="<?php esc_html_e( 'Search for Movies or TV Series', 'skrn-progression' ); ?>" value="<?php echo esc_attr($_GET['search_keyword']); ?>" />
			
			
			<div id="tablet-mobile-video-search-header-filtering">
				<div id="tablet-mobile-video-search-header-filtering-padding">
				
					<ul class="skrn-video-search-columns skrn-video-search-count-1">
					
						<?php if (get_theme_mod( 'progression_studios_video_search_field_type', 'true') == 'true') : ?>
						<?php $vtype = get_terms('video-type'); if($vtype): ?>
							<li class="column-search-header">
								<h5><?php esc_html_e( 'Type:', 'skrn-progression' ); ?></h5>					
								<ul class="video-search-type-list">
									<?php if(function_exists('progression_theme_elements_skrn')  ): ?>
									<?php foreach($vtype as $vt): ?>
									<li>
										<label class="checkbox-pro-container"><?php echo esc_attr($vt->name); ?>
											<input type="checkbox" value="<?php echo esc_attr($vt->slug); ?>" name="vtype[]" 
											<?php if($_GET['vtype']): ?><?php if(in_array($vt->slug, $_GET['vtype'])){ echo 'checked="checked"';}  ?><?php endif; ?>>
											<span class="checkmark-pro"></span>
										</label>
									</li>
									<?php endforeach; ?>
									<?php endif; ?>
								</ul>
								<div class="clearfix-pro"></div>
							</li>
						<?php endif; ?>
						<?php endif; ?>

				
						<?php if (get_theme_mod( 'progression_studios_video_search_field_genre', 'true') == 'true') : ?>
						<?php $vgenre = get_terms('video-genres'); if($vgenre): ?>
							<li class="column-search-header">
								<h5><?php esc_html_e( 'Genre:', 'skrn-progression' ); ?></h5>
								<select name="vgenre<?php if (get_theme_mod( 'progression_studios_video_search_multiple_genre') == 'multiple') : ?>[]<?php endif; ?>" class="skrn-genre-select2" <?php if (get_theme_mod( 'progression_studios_video_search_multiple_genre') == 'multiple') : ?>multiple="multiple"<?php endif; ?> style="width: 100%">
									<?php if (get_theme_mod( 'progression_studios_video_search_multiple_genre', 'single') == 'single') : ?><option value=""><?php echo esc_html__( 'All Genres', 'skrn-progression' ); ?></option><?php endif; ?>
									<?php if(function_exists('progression_theme_elements_skrn')  ): ?>
									<?php foreach($vgenre as $vg): ?><option value="<?php echo esc_attr($vg->slug); ?>" 
										<?php if (get_theme_mod( 'progression_studios_video_search_multiple_genre') == 'multiple') : ?>
											<?php if($_GET['vgenre']): ?><?php if(in_array($vg->slug, $_GET['vgenre'])){ echo 'selected="selected"';}  ?><?php endif; ?>
										<?php else: ?>
											<?php if($_GET['vgenre'] == $vg->slug ): ?>selected="selected"<?php endif; ?>
										<?php endif; ?>><?php echo esc_attr($vg->name); ?></option><?php endforeach; ?>
									<?php endif; ?>
								</select>
							</li>
						<?php endif; ?>
						<?php endif; ?>
				
					
						<?php if (get_theme_mod( 'progression_studios_video_search_field_duration', 'true') == 'true') : ?>
						<li class="column-search-header">
							<h5><?php esc_html_e( 'Duration:', 'skrn-progression' ); ?></h5>
							<select name="vduration" class="skrn-duration-select2" style="width: 100%">
								<option value=""><?php echo esc_html__( 'Any Duration', 'skrn-progression' ); ?></option>
								<option value="short" <?php if($_GET['vduration'] == 'short'): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Short (< 5 minutes)', 'skrn-progression' ); ?></option>
								<option value="medium" <?php if($_GET['vduration'] == 'medium'): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Medium (5-10 minutes)', 'skrn-progression' ); ?></option>
								<option value="long" <?php if($_GET['vduration'] == 'long'): ?>selected="selected"<?php endif; ?>><?php echo esc_html__( 'Long (> 10 minutes)', 'skrn-progression' ); ?></option>
							</select>
						</li>
						<?php endif; ?>
					
						<?php if (get_theme_mod( 'progression_studios_video_search_field_category') == 'true') : ?>
						<?php $vcategory = get_terms('video-category'); if($vcategory): ?>
							<li class="column-search-header">
								<h5><?php esc_html_e( 'Category:', 'skrn-progression' ); ?></h5>
								<select name="vcategory<?php if (get_theme_mod( 'progression_studios_video_search_multiple_cat') == 'multiple') : ?>[]<?php endif; ?>" class="skrn-category-select2" <?php if (get_theme_mod( 'progression_studios_video_search_multiple_cat') == 'multiple') : ?>multiple="multiple"<?php endif; ?> style="width: 100%">
									<?php if (get_theme_mod( 'progression_studios_video_search_multiple_cat', 'single') == 'single') : ?><option value=""><?php echo esc_html__( 'All Categories', 'skrn-progression' ); ?></option><?php endif; ?>
									<?php foreach($vcategory as $vc): ?><option value="<?php echo esc_attr($vc->slug); ?>" 
									
									<?php if (get_theme_mod( 'progression_studios_video_search_multiple_cat') == 'multiple') : ?>
										<?php if($_GET['vcategory']): ?><?php if(in_array($vc->slug, $_GET['vcategory'])){ echo 'selected="selected"';}  ?><?php endif; ?>
									<?php else: ?>
										<?php if($_GET['vcategory'] == $vc->slug ): ?>selected="selected"<?php endif; ?>
									<?php endif; ?>
									><?php echo esc_attr($vc->name); ?></option><?php endforeach; ?>
								</select>
							</li>
						<?php endif; ?>
						<?php endif; ?>
					
					
						<?php if (get_theme_mod( 'progression_studios_video_search_field_director') == 'true') : ?>
						<?php $vdirector = get_terms('video-director'); if($vdirector): ?>
							<li class="column-search-header">
								<h5><?php esc_html_e( 'Director:', 'skrn-progression' ); ?></h5>
								<select name="vdirector<?php if (get_theme_mod( 'progression_studios_video_search_multiple_director') == 'multiple') : ?>[]<?php endif; ?>" class="skrn-director-select2" <?php if (get_theme_mod( 'progression_studios_video_search_multiple_director') == 'multiple') : ?>multiple="multiple"<?php endif; ?> style="width: 100%">
									<?php if (get_theme_mod( 'progression_studios_video_search_multiple_director', 'single') == 'single') : ?><option value=""><?php echo esc_html__( 'All Directors', 'skrn-progression' ); ?></option><?php endif; ?>
									<?php foreach($vdirector as $vd): ?><option value="<?php echo esc_attr($vd->slug); ?>" 
										<?php if (get_theme_mod( 'progression_studios_video_search_multiple_director') == 'multiple') : ?>
											<?php if($_GET['vdirector']): ?><?php if(in_array($vd->slug, $_GET['vdirector'])){ echo 'selected="selected"';}  ?><?php endif; ?>
										<?php else: ?>
											<?php if($_GET['vdirector'] == $vd->slug ): ?>selected="selected"<?php endif; ?>
										<?php endif; ?>
										><?php echo esc_attr($vd->name); ?></option><?php endforeach; ?>
								</select>
							</li>
						<?php endif; ?>
						<?php endif; ?>
					
						<?php if (get_theme_mod( 'progression_studios_video_search_field_rating', 'true') == 'true') : ?>
						<li class="column-search-header">
							<h5><?php esc_html_e( 'Average Rating:', 'skrn-progression' ); ?></h5>
							<input class="rating-range-search-skrn" type="text" name="vrating" min="0" max="10" value="<?php echo isset($_GET['vrating']) && !empty($_GET['vrating']) ? $_GET['vrating'] : '0,10'; ?>" step="1"  />
						</li>
						<?php endif; ?>
					</ul>
				
					<div class="clearfix-pro"></div>
				
					<div class="tablet-mobile-video-search-header-buttons">
						<input type="submit" class="tablet-mobile-submit-search-pro" name="submit" value="<?php echo esc_html__( 'Filter Search', 'skrn-progression' ); ?>" />
						<input type="button" id="mobile-configure-rest" value="<?php echo esc_html__( 'Reset', 'skrn-progression' ); ?>" />
					</div>
				
					<div class="clearfix-pro"></div>
				</div><!-- #tablet-mobile-video-search-header-filtering-padding -->
			</div><!-- close #tablet-mobile-video-search-header-filtering -->
			
			
			<div class="clearfix-pro"></div>
		</form>
	</div><!-- close #skrn-mobile-video-search-header -->
	
	
	<div class="clearfix-pro"></div>
</div><!-- close #main-nav-mobile -->