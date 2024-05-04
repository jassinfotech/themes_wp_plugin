<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pro
 */

get_header(); ?>
	
	<div id="progression-studios-sidebar-col-main">

	<div id="page-title-pro">
		<div id="progression-studios-page-title-container">
			<div class="width-container-pro">
				<?php
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$tax_term_breadcrumb_taxonomy_slug = $term->taxonomy;
				$term_photo = get_term_meta( $term->term_id, 'progression_studios_cast_Photo', true);
				?>
				<h1 class="page-title"><?php if ( !empty( $term_photo ) ) : echo '<div id="skrn-video-cast-photo-taxonomy" style="background-image:url(' . $term_photo . ')"></div>'; endif; ?><?php esc_html_e( 'Director: ', 'skrn-progression' ); ?><?php echo esc_attr('' . $term->name . '');?></h1>
				<?php the_archive_description( '<h4 class="progression-sub-title">', '</h4>' ); ?>
			</div><!-- #progression-studios-page-title-container -->
			<div class="clearfix-pro"></div>
		</div><!-- close .width-container-pro -->
	
	</div><!-- #page-title-pro -->
	
	
		<div class="dashboard-container-pro">

			<div id="progression-studios-video-index-list-spacing">
				<?php if ( have_posts() ) : ?>
				
					<div class="progression-masonry-margins" style="margin-top:-<?php echo esc_attr(get_theme_mod('progression_studios_blog_index_gap', '15')); ?>px; margin-left:-<?php echo esc_attr(get_theme_mod('progression_studios_blog_index_gap', '15')); ?>px; margin-right:-<?php echo esc_attr(get_theme_mod('progression_studios_blog_index_gap', '15')); ?>px;">
						<div class="progression-blog-index-masonry">
							<?php while ( have_posts() ) : the_post(); ?>
							
								<div class="progression-masonry-item progression-masonry-col-<?php echo esc_attr(get_theme_mod( 'progression_studios_blog_columns', '4')); ?>">
									<div class="progression-masonry-padding-blog" style="padding:<?php echo esc_attr(get_theme_mod('progression_studios_blog_index_gap', '15')); ?>px;">
										<div class="progression-studios-isotope-animation">
											<?php get_template_part( 'template-parts/content', 'video-skrn'); ?>
										</div><!-- close .studios-isotope-animation -->
									</div><!-- close .progression-masonry-padding-blog -->
								</div><!-- cl ose .progression-masonry-item -->
							<?php endwhile; ?>
						</div><!-- close .progression-blog-index-masonry -->
					</div><!-- close .progression-masonry-margins -->
				
					<div class="clearfix-pro"></div>
					<?php progression_studios_show_pagination_links_pro(); ?>
					<div class="clearfix-pro"></div>
			
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div><!-- close #progression-studios-video-index-list-spacing -->
			
			
			<div class="clearfix-pro"></div>
		</div><!-- close .dashboard-container-pro -->
		</div><!-- close #progression-studios-sidebar-col-main -->
	
	<?php get_footer(); ?>