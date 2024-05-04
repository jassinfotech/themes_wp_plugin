<?php

/**
 *
 * @package pro
 * @since pro 1.0
 */
get_header(); ?>

	<div id="progression-studios-sidebar-col-main">

		
		<?php if(!get_post_meta($post->ID, 'progression_studios_disable_page_title', true)  ): ?>
		<div id="page-title-pro">
				<div id="progression-studios-page-title-container">
					<div class="width-container-pro">
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
					<?php if(get_post_meta($post->ID, 'progression_studios_sub_title', true)): ?><h4 class="progression-sub-title"><?php echo wp_kses( get_post_meta($post->ID, 'progression_studios_sub_title', true) , true); ?></h4><?php endif; ?>
					</div><!-- close .width-container-pro -->
				</div><!-- close #progression-studios-page-title-container -->
				<div class="clearfix-pro"></div>
		</div><!-- #page-title-pro -->
		<?php endif; ?>
		
		<div class="dashboard-container-pro<?php if(get_post_meta($post->ID, 'progression_studios_page_sidebar', true) == 'left-sidebar' ) : ?> left-sidebar-pro<?php endif; ?>">


			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php endwhile; ?>
			
			
		<div class="clearfix-pro"></div>
		</div><!-- close .dashboard-container-pro -->
	</div>

	
<?php get_footer(); ?>