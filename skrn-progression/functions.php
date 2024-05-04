<?php
/**
 * progression functions and definitions
 *
 * @package progression
 * @since progression 1.0
 */


if ( ! function_exists( 'progression_studios_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since progression 1.0
 */
	
function progression_studios_setup() {
	
	// Post Thumbnails
	add_theme_support( 'post-thumbnails' );
	
	add_image_size('progression-studios-video-index', 500, 705, true);
	add_image_size('progression-studios-video-poster', 500, 800, false);
	add_image_size('progression-studios-blog-index', 1200, 667, true);
	add_image_size('progression-studios-video-related', 700, 470, true);
	//add_image_size('progression-studios-notifications', 80, 80, true);
	

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on pro, use a find and replace
	 * to change 'skrn-progression' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'skrn-progression', get_template_directory() . '/languages' );
	
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'quote', 'link', 'image' ) );

	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'progression-studios-primary' => esc_html__( 'Dashboard Menu', 'skrn-progression' ),
		'progression-studios-mobile-menu' => esc_html__( 'Tablet/Mobile Primary Menu', 'skrn-progression' ),
		'progression-studios-landing-page' => esc_html__( 'Landing Page Menu', 'skrn-progression' ),
		'progression-studios-profile-menu' => esc_html__( 'Additional Profile Menu Items', 'skrn-progression' ),
	) );
	
	

}
endif; // progression_studios_setup
add_action( 'after_setup_theme', 'progression_studios_setup' );



/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since pro 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = esc_attr( get_theme_mod('progression_studios_site_width', '1200') ); /* pixels */


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since pro 1.0
 */
function progression_studios_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar', 'skrn-progression' ),
		'description'   => esc_html__('Default sidebar', 'skrn-progression'),
		'id' => 'progression-studios-sidebar',
		'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
		'after_widget' => '<div class="sidebar-divider-pro"></div></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
}
add_action( 'widgets_init', 'progression_studios_widgets_init' );




/**
 * Enqueue scripts and styles
 */
function progression_studios_scripts() {
	wp_enqueue_style(  'skrn-progression-style', get_stylesheet_uri());
	wp_enqueue_style(  'skrn-progression-google-fonts', progression_studios_fonts_url(), array( 'skrn-progression-style' ), '1.0.0' );
	wp_enqueue_script( 'skrn-progression-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'scrolltofixed', get_template_directory_uri() . '/js/scrolltofixed.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'afterglow', get_template_directory_uri() . '/js/afterglow.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'prettyPhoto', get_template_directory_uri() . '/js/prettyphoto.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'select2', get_template_directory_uri() . '/js/select2.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'jquery-asRange', get_template_directory_uri() . '/js/jquery-asRange.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'circle-progress', get_template_directory_uri() . '/js/circle-progress.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'skrn-progression-masonry', get_template_directory_uri() . '/js/masonry.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'skrn-progression-scripts', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '20120206', true );
	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_action( 'wp_enqueue_scripts', 'progression_studios_scripts' );



/**
 * Enqueue google fonts
 */
function progression_studios_fonts_url() {
    $progression_studios_font_url = '';

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'skrn-progression' ) ) {
        $progression_studios_font_url = add_query_arg( 'family', urlencode( 'Lato:400,700|Montserrat:300,400,600,700|&subset=latin' ), "//fonts.googleapis.com/css" );
    }
	 
    return $progression_studios_font_url;
}


/* Demo Content Import */
function progression_studios_demo_import_files() {
  return array(
    array(
      'import_file_name'           => esc_html__( 'Demo Content Import', 'skrn-progression' ),
      'local_import_file'            => trailingslashit( get_template_directory() ) . '/demo/content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . '/demo/widgets.json',
      'local_import_customizer_file' => trailingslashit( get_template_directory() ) . '/demo/theme_option.dat',
      'preview_url'                => 'https://skrn.progressionstudios.com',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'progression_studios_demo_import_files' );

function progression_studios_demo_after_import_setup() {
	// Assign menus to their locations.
	$progession_studios_main_menu = get_term_by( 'name', 'Dashboard Navigation', 'nav_menu' );
	$progession_studios_landing_page_menu = get_term_by( 'name', 'Landing Page Menu', 'nav_menu' );
	$progession_studios_additional_menu = get_term_by( 'name', 'Additional Profile Menu Items', 'nav_menu' );
	
	set_theme_mod( 'nav_menu_locations', array(
			'progression-studios-primary' => $progession_studios_main_menu->term_id,
			'progression-studios-landing-page' => $progession_studios_landing_page_menu->term_id,
			'progression-studios-profile-menu' => $progession_studios_additional_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Latest News' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'progression_studios_demo_after_import_setup' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';



function skrn_custom_count_post_by_author($reiew_count_args){
	$comments_query = new WP_Comment_Query;
	$comments = $comments_query->query( $reiew_count_args );
	

	$count = 0;
	if ( $comments ) {
	foreach ( $comments as $comment ) {
		$count++;
	}
	}
   return $count;
}

/**
 * Theme Customizers
 */
require get_template_directory() . '/inc/default-customizer.php';


/**
 * Theme Customizer
 */
require get_template_directory() . '/inc/mega-menu/mega-menu-framework.php';


/**
 * JS Customizer Out
 */
require get_template_directory() . '/inc/js-customizer.php';


/**
 * Elementor Page Builder Functions
 */
require get_template_directory() . '/inc/elementor-functions.php';

/**
 * Favorite and Wishlis Functions
 */
require get_template_directory() . '/inc/video-favorite.php';
require get_template_directory() . '/inc/video-watchlist.php';


/**
 * Load Plugin prohibitionation
 */
require get_template_directory() . '/inc/tgm-plugin-activation/plugin-activation.php';
