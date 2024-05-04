<?php
/**
 * The template for displaying search results pages.
 *
 * @package pro
 */

get_header(); ?>
	
	
	<?php if ( get_theme_mod( 'progression_studios_blog_layout_dash', 'dashboard') == 'dashboard' ) : ?><div id="progression-studios-sidebar-col-main"><?php endif; ?>
		
	<div id="page-title-pro">
		<div id="progression-studios-page-title-container">
			<div class="width-container-pro">
				<h1 class="page-title"><?php printf( esc_html__( 'Search for: %s', 'skrn-progression' ), '<span>' . get_search_query() . '</span>' ); ?>
			</div><!-- #progression-studios-page-title-container -->
			<div class="clearfix-pro"></div>
		</div><!-- close .width-container-pro -->
	
	</div><!-- #page-title-pro -->
	
	
	<div class="<?php if ( get_theme_mod( 'progression_studios_blog_layout_dash', 'dashboard') == 'dashboard' ) : ?>dashboard-container-pro<?php else: ?>width-container-pro<?php endif; ?><?php if ( get_theme_mod( 'progression_studios_blog_cat_sidebar' ) == 'left-sidebar' ) : ?> left-sidebar-pro<?php endif; ?>">
		
		
		<?php if(get_theme_mod( 'progression_studios_blog_cat_sidebar' ) == 'left-sidebar' || get_theme_mod( 'progression_studios_blog_cat_sidebar', 'right-sidebar' ) == 'right-sidebar' ) : ?><div id="main-container-pro"><?php endif; ?>
		
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
			<?php endwhile; ?>
		
		<div class="clearfix-pro"></div>
		<?php progression_studios_show_pagination_links_pro(); ?>
		<div class="clearfix-pro"></div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
		
		
			<?php if(get_theme_mod( 'progression_studios_blog_cat_sidebar' ) == 'left-sidebar' || get_theme_mod( 'progression_studios_blog_cat_sidebar', 'right-sidebar' ) == 'right-sidebar' ) : ?></div><!-- close #main-container-pro --><?php get_sidebar(); ?><?php endif; ?>
		
				
			<div class="clearfix-pro"></div>
			</div><!-- close .dashboard-container-pro -->
			
	<?php if ( get_theme_mod( 'progression_studios_blog_layout_dash', 'dashboard') == 'dashboard' ) : ?></div><!-- close #progression-studios-sidebar-col-main --><?php endif; ?>
	
<?php get_footer(); ?>