<?php
/**
 * The template for displaying all single posts.
 *
 * @package pro
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	
	
	
	<?php if ( get_theme_mod( 'progression_studios_blog_layout_dash', 'dashboard') == 'dashboard' ) : ?><div id="progression-studios-sidebar-col-main" class="site-content-blog-post"><?php endif; ?>
	
		<?php if( get_option( 'page_for_posts' ) ) : $cover_page = get_page( get_option( 'page_for_posts' ) ); ?>
		
			<?php if(!get_post_meta($cover_page->ID, 'progression_studios_disable_page_title', true)): ?>
			<div id="page-title-pro">
				<div id="progression-studios-page-title-container">
					<div class="width-container-pro">
						<h1 class="page-title"><?php echo get_the_title($cover_page); ?></h1>
						<?php if(get_post_meta($cover_page->ID, 'progression_studios_sub_title', true)): ?><h4 class="progression-sub-title"><?php echo wp_kses( get_post_meta($cover_page->ID, 'progression_studios_sub_title', true) , true); ?></h4><?php endif; ?>
					</div><!-- #progression-studios-page-title-container -->
					<div class="clearfix-pro"></div>
				</div><!-- close .width-container-pro -->
			
			</div><!-- #page-title-pro -->
			<?php endif; ?>
		
		<?php else: ?>
			<div id="page-title-pro">
				<div id="progression-studios-page-title-container">
					<div class="width-container-pro">
						<h1 class="page-title"><?php esc_html_e( 'Latest News', 'skrn-progression' ); ?></h1>
					</div><!-- #progression-studios-page-title-container -->
					<div class="clearfix-pro"></div>
				</div><!-- close .width-container-pro -->
			
			</div><!-- #page-title-pro -->
		<?php endif; ?>
	
		<div class="<?php if ( get_theme_mod( 'progression_studios_blog_layout_dash', 'dashboard') == 'dashboard' ) : ?>dashboard-container-pro<?php else: ?>width-container-pro<?php endif; ?><?php if ( get_theme_mod( 'progression_studios_blog_post_sidebar') == 'left') : ?> left-sidebar-pro<?php endif; ?> <?php if(get_post_meta($post->ID, 'progression_studios_group_552033a9a46bc', true)): ?>disable-sidebar-post-progression<?php endif; ?>">
	
			<?php if ( get_theme_mod( 'progression_studios_blog_post_sidebar', 'right') == 'right' || get_theme_mod( 'progression_studios_blog_post_sidebar', 'right') == 'left') : ?><div id="main-container-pro"><?php endif; ?>
		
				<?php get_template_part( 'template-parts/content', 'single' ); ?>
				
			<?php if ( get_theme_mod( 'progression_studios_blog_post_sidebar', 'right') =='right' || get_theme_mod( 'progression_studios_blog_post_sidebar', 'right') =='left') : ?></div><!-- close #main-container-pro --><?php get_sidebar(); ?><?php endif; ?>
				
			<div class="clearfix-pro"></div>
		</div><!-- close .dashboard-container-pro -->
		
	<?php if ( get_theme_mod( 'progression_studios_blog_layout_dash', 'dashboard') == 'dashboard' ) : ?></div><!-- close #progression-studios-sidebar-col-main --><?php endif; ?>

<?php endwhile; // end of the loop. ?>			
<?php get_footer(); ?>