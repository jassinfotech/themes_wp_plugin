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
				<h1 class="page-title"><?php esc_html_e( 'Videos ', 'skrn-progression' ); ?></h1>
				<?php the_archive_description( '<h4 class="progression-sub-title">', '</h4>' ); ?>
			</div><!-- #progression-studios-page-title-container -->
			<div class="clearfix-pro"></div>
		</div><!-- close .width-container-pro -->
	
	</div><!-- #page-title-pro -->


		<div class="dashboard-container-pro">

			<div id="progression-studios-video-index-list-spacing">
				<?php
					if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1;}
					
					
					if(isset($_GET['search_keyword'])) {
						if($_GET['search_keyword']) {
							$keyword = $_GET['search_keyword'];
						} else {
							$keyword = "";
						}
					}
					
					$args = array(
						'post_type' => 'video_skrn',
						'paged' => $paged,
						's' => $keyword
					);
					
					
					
					$vtype_expanded = (array) $_GET['vtype'];
					if(isset($_GET['vtype'])) {
					if($_GET['vtype']) {
						$args['tax_query'][] = array(
							'taxonomy' => 'video-type',
							'field' => 'slug',
							'terms' => $vtype_expanded,
							'operator' => 'IN',
						);
					}
					}
					
					if( get_theme_mod( 'progression_studios_video_search_multiple_genre') == 'multiple' ) {
						$vgenre_expanded = (array) $_GET['vgenre'];
					} else {
						$vgenre_expanded = $_GET['vgenre'];
					}

					if(isset($_GET['vgenre'])) {
					if($_GET['vgenre']) {
						$args['tax_query'][] = array(
							'taxonomy' => 'video-genres',
							'field' => 'slug',
							'terms' => $vgenre_expanded
						);
					}
					}
					
					if(isset($_GET['vduration'])) {
					if($_GET['vduration']) {
						$args['meta_query'][] = array(
							'key' => 'progression_studios_media_duration',
							'value' => $_GET['vduration'],
						);
					}
					}
					
					if(isset($_GET['vrating'])) {
					if($_GET['vrating']) {
						$vrating = explode( ',', $_GET['vrating'] );
						$args['meta_query'][] = array(
							// I know it isn't a key but can't figure it out 'key' => skrn_pro_comment_rating_get_average_ratings( $post->ID ),
							'key' => '_average_ratings',
							'value' => array( floatval( $vrating[0] ), floatval ( $vrating[1] ) ),
							'type' => 'DECIMAL',
							'compare' => 'BETWEEN'
						);
					}
					}
					
					
					if( get_theme_mod( 'progression_studios_video_search_multiple_cat') == 'multiple' ) {
						$vcategory_expanded = (array) $_GET['vcategory'];
					} else {
						$vcategory_expanded = $_GET['vcategory'];
					}
					
					
					if(isset($_GET['vcategory'])) {
					if($_GET['vcategory']) {
						$args['tax_query'][] = array(
							'taxonomy' => 'video-category',
							'field' => 'slug',
							'terms' => $vcategory_expanded,
							'operator' => 'IN',
						);
					}
					}
					
					
					if( get_theme_mod( 'progression_studios_video_search_multiple_director') == 'multiple' ) {
						$vdirector_expanded = (array) $_GET['vdirector'];
					} else {
						$vdirector_expanded = $_GET['vdirector'];
					}
					
					if(isset($_GET['vdirector'])) {
					if($_GET['vdirector']) {
						$args['tax_query'][] = array(
							'taxonomy' => 'video-director',
							'field' => 'slug',
							'terms' => $vdirector_expanded,
							'operator' => 'IN',
						);
					}
					}
		
					
				query_posts($args); if(have_posts()):
				?>
				
				
				<div id="progression-studios-search-results-videos">
					<span><?php skrn_search_video_counter(); ?></span> <?php echo esc_html__( 'Videos Found', 'skrn-progression' ); ?>
				</div>
				
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
					
					<?php get_template_part( 'template-parts/content', 'none-videos' ); ?>
				
				<?php endif; ?>
			</div><!-- close #progression-studios-video-index-list-spacing -->
			
			
			<div class="clearfix-pro"></div>
		</div><!-- close .dashboard-container-pro -->
		</div><!-- close #progression-studios-sidebar-col-main -->
	
	<?php get_footer(); ?>