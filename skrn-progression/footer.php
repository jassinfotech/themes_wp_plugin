<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package pro
 * @since pro 1.0
 */
?>

	<?php if ( is_page() && is_page_template('page-landing.php') ) : ?>
		
		<?php if (get_theme_mod( 'progression_studios_footer_elementor_library') && !is_singular( 'elementor_library') ) : ?>
			<div id="progression-studios-footer-page-builder">
				<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_footer_elementor_library', true)): ?><?php else: ?>
				<?php
				if( function_exists( 'elementor_load_plugin_textdomain' ) ) {
				$progression_studios_elementor_footer_instance = Elementor\Plugin::instance();
				echo $progression_studios_elementor_footer_instance->frontend->get_builder_content_for_display( get_theme_mod( 'progression_studios_footer_elementor_library') );
				}
				?><?php endif; ?>
			</div>
		<?php else: ?>
		<?php if (get_theme_mod( 'progression_studios_footer_copyright' ) ) : ?>
		<footer id="site-footer" class="progression-studios-footer-normal-width <?php echo esc_attr( get_theme_mod('progression_studios_footer_copyright_location', 'footer-copyright-align-left') ); ?>">
			<div id="progression-studios-copyright">
				<div id="copyright-divider-top"></div>				
					<div class="width-container-pro">
						<div id="copyright-text">
								<?php echo wp_kses(get_theme_mod( 'progression_studios_footer_copyright' ), true); ?>
						</div>
					</div> <!-- close .divider-container-pro -->			
				<div class="clearfix-pro"></div>
			</div><!-- close #progression-studios-copyright -->
		</footer>
		<?php endif; ?>
		<?php endif; ?>
		
		<?php if ( get_theme_mod( 'progression_studios_pro_scroll_top', 'scroll-on-pro') == "scroll-on-pro" ) : ?><div id="pro-scroll-top"><i class="fas fa-chevron-up"></i></div><?php endif; ?>
		
	<?php else: ?>
	
		<?php if (get_theme_mod( 'progression_studios_footer_dash_elementor_library') && !is_singular( 'elementor_library') ) : ?>
			<div id="progression-studios-footer-page-builder" class="sidebar-dashboard-footer-spacing">
				<?php if(is_page() && get_post_meta($post->ID, 'progression_studios_footer_dash_elementor_library', true)): ?><?php else: ?>
				<?php
				if( function_exists( 'elementor_load_plugin_textdomain' ) ) {
				$progression_studios_elementor_footer_instance = Elementor\Plugin::instance();
				echo  $progression_studios_elementor_footer_instance->frontend->get_builder_content_for_display( get_theme_mod( 'progression_studios_footer_dash_elementor_library') );
				}
				?><?php endif; ?>
			</div>
		<?php endif; ?>
	
		</div><!-- close #sidebar-bg-->
		
		<?php if ( get_theme_mod( 'progression_studios_pro_dashboard_scroll_top') == "scroll-on-pro" ) : ?><div id="pro-scroll-top"><i class="fas fa-chevron-up"></i></div><?php endif; ?>
		
	<?php endif; ?>
	
	
		
	</div><!-- close #boxed-layout-pro -->
	
<?php wp_footer(); ?>
</body>
</html>