<?php
/**
 * The Header for our theme.
 *
 * @package pro
 * @since pro 1.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php get_template_part( 'header/social', 'sharing' ); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
	<?php get_template_part( 'header/page', 'loader' ); ?>
	<div id="boxed-layout-pro" <?php progression_studios_page_title(); ?>>
		
		<?php if ( is_page() && is_page_template('page-landing.php') || is_progression_studios_blog() && get_theme_mod( 'progression_studios_blog_layout_dash') == 'landing'   || is_search() && get_theme_mod( 'progression_studios_blog_layout_dash') == 'landing' ) : ?>
			
			<div id="progression-studios-header-position">
				<div id="progression-studios-header-width">
					<?php if (get_theme_mod( 'progression_studios_header_sticky', 'none-sticky-pro' ) == 'sticky-pro') : ?><div id="progression-sticky-header"><?php endif; ?>
					<header id="masthead-pro" class="progression-studios-site-header <?php echo esc_attr( get_theme_mod('progression_studios_nav_align', 'progression-studios-nav-left') ); ?>">
							<div id="logo-nav-pro">
								<div class="width-container-pro progression-studios-logo-container">
									<h1 id="logo-pro" class="logo-inside-nav-pro noselect"><?php progression_studios_logo(); ?></h1>
								</div><!-- close .width-container-pro -->
								<?php progression_studios_navigation(); ?>
							</div><!-- close #logo-nav-pro -->
							<?php get_template_part( 'header/mobile', 'navigation-landing' ); ?>
					</header>
					<?php if (get_theme_mod( 'progression_studios_header_sticky', 'none-sticky-pro' ) == 'sticky-pro' ) : ?></div><!-- close #progression-sticky-header --><?php endif; ?>
					
				</div><!-- close #progression-studios-header-width -->			
			</div><!-- close #progression-studios-header-position -->
		<?php else: ?>
		
		
		
		
		<div id="sidebar-bg">
			<header id="videohead-pro">
				<?php if ( get_theme_mod( 'progression_studios_theme_logo_dashboard', get_template_directory_uri() . '/images/logo.png' ) ) : ?><div id="video-logo-background"><?php if (get_theme_mod( 'progression_studios_dashboard_logo_link') ) : ?>
				<a href="<?php echo get_permalink( get_theme_mod( 'progression_studios_dashboard_logo_link' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php else: ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		<?php endif; ?><img src="<?php echo esc_attr( get_theme_mod( 'progression_studios_theme_logo_dashboard', get_template_directory_uri() . '/images/logo.png' ) ); ?>" alt="<?php bloginfo('name'); ?>"></a></div><?php endif; ?>
				<?php get_template_part( 'header/search', 'header' ); ?>
				<div id="mobile-menu-icon-pro" class="noselect"><i class="fas fa-bars"></i><?php if (get_theme_mod( 'progression_studios_mobile_menu_text') == 'on' ) : ?><span class="progression-mobile-menu-text"><?php echo esc_html__( 'Menu', 'skrn-progression' )?></span><?php endif; ?></div>
					<?php get_template_part( 'header/profile', 'menu' ); ?>
				<div class="clearfix-pro"></div>
				<?php get_template_part( 'header/mobile', 'navigation' ); ?>
			</header>
			<nav id="sidebar-nav-pro"><!-- Add class="sticky-sidebar-js" for auto-height sidebar -->
				<?php wp_nav_menu( array('theme_location' => 'progression-studios-primary', 'menu_class' => 'sf-menu', 'fallback_cb' => false, 'walker'  => new ProgressionFrontendWalker ) ); ?>
				<div class="clearfix-pro"></div>
			</nav>
			
		<?php endif; ?>