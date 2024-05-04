<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package pro
 */

get_header(); ?>
	
	<?php if (get_theme_mod( 'progression_studios_404_elementor_library') && !is_singular( 'elementor_library') ) : ?>
		
		<?php
		if( function_exists( 'elementor_load_plugin_textdomain' ) ) {
			$progression_studios_elementor_footer_instance = Elementor\Plugin::instance();
			echo $progression_studios_elementor_footer_instance->frontend->get_builder_content_for_display( get_theme_mod( 'progression_studios_404_elementor_library') );
		}
		?>
		
	<?php else: ?>
		
		<div id="progression-studios-sidebar-col-main">
		
			<div id="page-title-pro">
				<div id="progression-studios-page-title-container">
					<div class="width-container-pro">
						<h1 class="page-title"><?php esc_html_e( "Oops! That page can&rsquo;t be found.", 'skrn-progression' ); ?></h1>
						<h4 class="progression-sub-title"><?php esc_html_e( "404 Page Error", 'skrn-progression' ); ?></h4>
					</div>
					<div class="clearfix-pro"></div>
				</div>
		
			</div><!-- #page-title-pro -->
		
			<div class="dashboard-container-pro">
	
				<br>
				<p><?php esc_html_e( "Sorry, We couldn&rsquo;t find the page you&rsquo;re looking for. Maybe Try one of the links in the navigation or a search.", 'skrn-progression' ); ?></p>
			
				<br>
			
			<div class="clearfix-pro"></div>
			</div><!-- close .dashboard-container-pro -->
		</div>
		
	<?php endif; ?>
	
	
	
<?php get_footer(); ?>