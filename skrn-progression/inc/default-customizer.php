<?php
/**
 * Progression Theme Customizer
 *
 * @package pro
 */

get_template_part('inc/customizer/new', 'controls');
get_template_part('inc/customizer/typography', 'controls');
get_template_part('inc/customizer/alpha', 'control');// New Alpha Control



/* Remove Default Theme Customizer Panels that aren't useful */
function progression_studios_change_default_customizer_panels ( $wp_customize ) {
	$wp_customize->remove_section("themes"); //Remove Active Theme + Theme Changer
   $wp_customize->remove_section("static_front_page"); // Remove Front Page Section		
}
add_action( "customize_register", "progression_studios_change_default_customizer_panels" );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function progression_studios_customize_preview_js() {
	wp_enqueue_script( 'progression_studios_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'progression_studios_customize_preview_js' );


function progression_studios_customizer( $wp_customize ) {
	
	
	/* Panel - General */
	$wp_customize->add_panel( 'progression_studios_general_panel', array(
		'priority'    => 3,
		'title'       => esc_html__( 'General', 'skrn-progression' ),
		 ) 
 	);
	
	
	/* Section - General - General Layout */
	$wp_customize->add_section( 'progression_studios_section_general_layout', array(
		'title'          => esc_html__( 'General Options', 'skrn-progression' ),
		'panel'          => 'progression_studios_general_panel', // Not typically needed.
		'priority'       => 10,
		) 
	);
	
	/* Setting - Footer Elementor 
	https://gist.github.com/ajskelton/27369df4a529ac38ec83980f244a7227
	*/
	$progression_studios_elementor_library_list =  array(
		'' => 'Choose a template',
	);
	$progression_studios_elementor_args = array('post_type' => 'elementor_library', 'posts_per_page' => 99);
	$progression_studios_elementor_posts = get_posts( $progression_studios_elementor_args );
	foreach($progression_studios_elementor_posts as $progression_studios_elementor_post) {
	    $progression_studios_elementor_library_list[$progression_studios_elementor_post->ID] = $progression_studios_elementor_post->post_title;
	}
	
	$wp_customize->add_setting( 'progression_studios_404_elementor_library' ,array(
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_404_elementor_library', array(
	  'type' => 'select',
	  'section' => 'progression_studios_section_general_layout',
	  'priority'   => 5,
	  'label'    => esc_html__( '404 Page Error Elementor Template', 'skrn-progression' ),
	  'description'    => esc_html__( 'You can add a custom 404 page template under ', 'skrn-progression') . '<a href="' . admin_url() . 'edit.php?post_type=elementor_library">Elementor > My Library</a>',
	  'choices'  => 	   $progression_studios_elementor_library_list,
	) );
	
	

	
	/* Setting - General - General Layout */
	$wp_customize->add_setting('progression_studios_dashboard_width_padding',array(
		'default' => '50',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_dashboard_width_padding', array(
		'label'    => esc_html__( 'Dashboard Content Padding', 'skrn-progression' ),
		'section' => 'progression_studios_section_general_layout',
		'priority'   => 12,
		'choices'     => array(
			'min'  => 0,
			'max'  => 500,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - General - General Layout */
	$wp_customize->add_setting('progression_studios_dashboard_width_padding_tablet',array(
		'default' => '25',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_dashboard_width_padding_tablet', array(
		'label'    => esc_html__( 'Tablet Dashboard Content Padding', 'skrn-progression' ),
		'section' => 'progression_studios_section_general_layout',
		'priority'   => 15,
		'choices'     => array(
			'min'  => 0,
			'max'  => 400,
			'step' => 1
		), ) ) 
	);
	
	
	
	/* Setting - General - General Layout */
	$wp_customize->add_setting('progression_studios_site_width',array(
		'default' => '1200',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_site_width', array(
		'label'    => esc_html__( 'Landing Page Site Width', 'skrn-progression' ),
		'section' => 'progression_studios_section_general_layout',
		'priority'   => 18,
		'choices'     => array(
			'min'  => 961,
			'max'  => 4500,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_select_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_select_color', array(
		'label'    => esc_html__( 'Mouse Selection Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_general_layout',
		'priority'   => 20,
		)) 
	);
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_select_bg', array(
		'default'	=> '#3db13d',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_select_bg', array(
		'default'	=> '#3db13d',
		'label'    => esc_html__( 'Mouse Selection Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_general_layout',
		'priority'   => 25,
		)) 
	);
	
	

	
	
	
	
	
	
	/* Setting - General - General Layout */
	$wp_customize->add_setting( 'progression_studios_lightbox_caption' ,array(
		'default' => 'on',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_lightbox_caption', array(
		'label'    => esc_html__( 'Lightbox Captions', 'skrn-progression' ),
		'section' => 'progression_studios_section_general_layout',
		'priority'   => 100,
		'choices'     => array(
			'on' => esc_html__( 'On', 'skrn-progression' ),
			'off' => esc_html__( 'Off', 'skrn-progression' ),
		),
		))
	);
	
	/* Setting - General - General Layout */
	$wp_customize->add_setting( 'progression_studios_lightbox_play' ,array(
		'default' => 'on',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_lightbox_play', array(
		'label'    => esc_html__( 'Lightbox Gallery Play/Pause', 'skrn-progression' ),
		'section' => 'progression_studios_section_general_layout',
		'priority'   => 110,
		'choices'     => array(
			'on' => esc_html__( 'On', 'skrn-progression' ),
			'off' => esc_html__( 'Off', 'skrn-progression' ),
		),
		))
	);
	
	
	/* Setting - General - General Layout */
	$wp_customize->add_setting( 'progression_studios_lightbox_count' ,array(
		'default' => 'on',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_lightbox_count', array(
		'label'    => esc_html__( 'Lightbox Gallery Count', 'skrn-progression' ),
		'section' => 'progression_studios_section_general_layout',
		'priority'   => 150,
		'choices'     => array(
			'on' => esc_html__( 'On', 'skrn-progression' ),
			'off' => esc_html__( 'Off', 'skrn-progression' ),
		),
		))
	);
	
	
	
	
	
	
	
	
	/* Section - General - Page Loader */
	$wp_customize->add_section( 'progression_studios_section_page_transition', array(
		'title'          => esc_html__( 'Page Loader', 'skrn-progression' ),
		'panel'          => 'progression_studios_general_panel', // Not typically needed.
		'priority'       => 26,
		) 
	);

	/* Setting - General - Page Loader */
	$wp_customize->add_setting( 'progression_studios_page_transition' ,array(
		'default' => 'transition-off-pro',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_page_transition', array(
		'label'    => esc_html__( 'Display Page Loader?', 'skrn-progression' ),
		'section' => 'progression_studios_section_page_transition',
		'priority'   => 10,
		'choices'     => array(
			'transition-on-pro' => esc_html__( 'On', 'skrn-progression' ),
			'transition-off-pro' => esc_html__( 'Off', 'skrn-progression' ),
		),
		))
	);
	
	/* Setting - General - Page Loader */
	$wp_customize->add_setting( 'progression_studios_transition_loader' ,array(
		'default' => 'circle-loader-pro',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_transition_loader', array(
		'label'    => esc_html__( 'Page Loader Animation', 'skrn-progression' ),
		'section' => 'progression_studios_section_page_transition',
		'type' => 'select',
		'priority'   => 15,
		'choices' => array(
			'circle-loader-pro' => esc_html__( 'Circle Loader Animation', 'skrn-progression' ),
	        'cube-grid-pro' => esc_html__( 'Cube Grid Animation', 'skrn-progression' ),
	        'rotating-plane-pro' => esc_html__( 'Rotating Plane Animation', 'skrn-progression' ),
	        'double-bounce-pro' => esc_html__( 'Doube Bounce Animation', 'skrn-progression' ),
	        'sk-rectangle-pro' => esc_html__( 'Rectangle Animation', 'skrn-progression' ),
			'sk-cube-pro' => esc_html__( 'Wandering Cube Animation', 'skrn-progression' ),
			'sk-chasing-dots-pro' => esc_html__( 'Chasing Dots Animation', 'skrn-progression' ),
			'sk-circle-child-pro' => esc_html__( 'Circle Animation', 'skrn-progression' ),
			'sk-folding-cube' => esc_html__( 'Folding Cube Animation', 'skrn-progression' ),
		
		 ),
		)
	);





	/* Setting - General - Page Loader */
	$wp_customize->add_setting( 'progression_studios_page_loader_text', array(
		'default' => '#cccccc',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_page_loader_text', array(
		'label'    => esc_html__( 'Page Loader Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_page_transition',
		'priority'   => 30,
	) ) 
	);
	
	/* Setting - General - Page Loader */
	$wp_customize->add_setting( 'progression_studios_page_loader_secondary_color', array(
		'default' => '#ededed',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_page_loader_secondary_color', array(
		'label'    => esc_html__( 'Page Loader Secondary (Circle Loader)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_page_transition',
		'priority'   => 31,
	) ) 
	);


	/* Setting - General - Page Loader */
	$wp_customize->add_setting( 'progression_studios_page_loader_bg', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_page_loader_bg', array(
		'label'    => esc_html__( 'Page Loader Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_page_transition',
		'priority'   => 35,
	) ) 
	);
	
	
	
	
	
	
	


	/* Section - Footer - Scroll To Top */
	$wp_customize->add_section( 'progression_studios_section_scroll', array(
		'title'          => esc_html__( 'Scroll To Top Button', 'skrn-progression' ),
		'panel'          => 'progression_studios_general_panel', // Not typically needed.
		'priority'       => 100,
	) );

	/* Setting - Footer - Scroll To Top */
	$wp_customize->add_setting( 'progression_studios_pro_dashboard_scroll_top', array(
		'default' => 'scroll-off-pro',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_pro_dashboard_scroll_top', array(
		'label'    => esc_html__( 'Dashboard - Scroll To Top Button', 'skrn-progression' ),
		'section'  => 'progression_studios_section_scroll',
		'priority'   => 10,
		'choices'     => array(
			'scroll-on-pro' => esc_html__( 'On', 'skrn-progression' ),
			'scroll-off-pro' => esc_html__( 'Off', 'skrn-progression' ),
		),
	) ) );
	
	/* Setting - Footer - Scroll To Top */
	$wp_customize->add_setting( 'progression_studios_pro_scroll_top', array(
		'default' => 'scroll-on-pro',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_pro_scroll_top', array(
		'label'    => esc_html__( 'Landing - Scroll To Top Button', 'skrn-progression' ),
		'section'  => 'progression_studios_section_scroll',
		'priority'   => 11,
		'choices'     => array(
			'scroll-on-pro' => esc_html__( 'On', 'skrn-progression' ),
			'scroll-off-pro' => esc_html__( 'Off', 'skrn-progression' ),
		),
	) ) );

	/* Setting - Footer - Scroll To Top */
	$wp_customize->add_setting( 'progression_studios_scroll_color', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		) 
	);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_scroll_color', array(
		'label'    => esc_html__( 'Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_scroll',
		'priority'   => 15,
		) ) 
	);


	/* Setting - Footer - Scroll To Top */
	$wp_customize->add_setting( 'progression_studios_scroll_bg_color', array(
		'default' => 'rgba(0,0,0,  0.3)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
		) 
	);
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_scroll_bg_color', array(
		'default' => 'rgba(0,0,0,  0.3)',
		'label'    => esc_html__( 'Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_scroll',
		'priority'   => 20,
		) ) 
	);



	/* Setting - Footer - Scroll To Top */
	$wp_customize->add_setting( 'progression_studios_scroll_hvr_color', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_scroll_hvr_color', array(
		'label'    => esc_html__( 'Hover Arrow Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_scroll',
		'priority'   => 30,
		) ) 
	);
	
	/* Setting - Footer - Scroll To Top */
	$wp_customize->add_setting( 'progression_studios_scroll_hvr_bg_color', array(
		'default' => '#3db13d',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_scroll_hvr_bg_color', array(
		'default' => '#3db13d',
		'label'    => esc_html__( 'Hover Arrow Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_scroll',
		'priority'   => 40,
		) ) 
	);


	
	
	/* Panel - Header */
	$wp_customize->add_panel( 'progression_studios_header_dashboard_panel', array(
		'priority'    => 4,
		'title'       => esc_html__( 'Dashboard Header', 'skrn-progression' ),
		) 
	);
	

	
	
	/* Section - General - Site Logo */
	$wp_customize->add_section( 'progression_studios_section_logo_dashboard', array(
		'title'          => esc_html__( 'Logo', 'skrn-progression' ),
		'panel'          => 'progression_studios_header_dashboard_panel', // Not typically needed.
		'priority'       => 10,
		) 
	);
	
	
	
	
	/* Setting - Footer Elementor 
	https://gist.github.com/ajskelton/27369df4a529ac38ec83980f244a7227
	*/
	$progression_studios_page_list =  array(
		'' => 'Choose a page',
	);
	$progression_studios_page_args = array('post_type' => 'page', 'posts_per_page' => 99);
	$progression_studios_page_posts = get_posts( $progression_studios_page_args );
	foreach($progression_studios_page_posts as $progression_studios_page_post) {
	    $progression_studios_page_list[$progression_studios_page_post->ID] = $progression_studios_page_post->post_title;
	}
	
	$wp_customize->add_setting( 'progression_studios_dashboard_logo_link' ,array(
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_dashboard_logo_link', array(
	  'type' => 'select',
	  'section' => 'progression_studios_section_logo_dashboard',
	  'priority'   => 5,
	  'label'    => esc_html__( 'Dashboard Logo Link', 'skrn-progression' ),
	  'description'    => esc_html__( 'Link the dashboard logo to another page other than front page', 'skrn-progression'),
	  'choices'  => 	   $progression_studios_page_list,
	) );
	
	
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'progression_studios_theme_logo_dashboard' ,array(
		'default' => get_template_directory_uri().'/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_theme_logo_dashboard', array(
		'section' => 'progression_studios_section_logo_dashboard',
		'priority'   => 10,
		))
	);
	
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('progression_studios_theme_logo_width_dashboard',array(
		'default' => '95',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_theme_logo_width_dashboard', array(
		'label'    => esc_html__( 'Logo Width (px)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo_dashboard',
		'priority'   => 15,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_logo_bg_color', array(
		'default' => 'rgba(255,255,255,  0)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_logo_bg_color', array(
		'default' => 'rgba(255,255,255,  0)',
		'label'    => esc_html__( 'Logo Background Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo_dashboard',
		'priority'   => 18,
		)) 
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_logo_border_right', array(
		'default' => 'rgba(0, 0, 0, 0.04)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_logo_border_right', array(
		'default' => 'rgba(0, 0, 0, 0.04)',
		'label'    => esc_html__( 'Logo Border Right Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo_dashboard',
		'priority'   => 20,
		)) 
	);
	
	
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'progression_studios_logo_position_dashboard' ,array(
		'default' => 'center',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_logo_position_dashboard', array(
		'label'    => esc_html__( 'Logo Position', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo_dashboard',
		'priority'   => 25,
		'choices'     => array(
			'left' => esc_html__( 'Left', 'skrn-progression' ),
			'center' => esc_html__( 'Center', 'skrn-progression' ),
			'right' => esc_html__( 'Right', 'skrn-progression' ),
		),
		))
	);
	
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('progression_studios_theme_logo_container_width_dashboard',array(
		'default' => '160',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_theme_logo_container_width_dashboard', array(
		'label'    => esc_html__( 'Logo Container Width (px)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo_dashboard',
		'priority'   => 35,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	
	
	
	
	/* Section - Header - Header Options */
	$wp_customize->add_section( 'progression_studios_section_header_dashboard_main', array(
		'title'          => esc_html__( 'Header Options', 'skrn-progression' ),
		'panel'          => 'progression_studios_header_dashboard_panel', // Not typically needed.
		'priority'       => 20,
		) 
	);
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_dash_sticky' ,array(
		'default' => 'fixed',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_header_dash_sticky', array(
		'label'    => esc_html__( 'Sticky Header', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_dashboard_main',
		'priority'   => 20,
		'choices'     => array(
			'fixed' => esc_html__( 'Sticky Header', 'skrn-progression' ),
			'absolute' => esc_html__( 'Default Header', 'skrn-progression' ),
		),
		))
	);
	
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('progression_studios_header_dash_height',array(
		'default' => '90',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_header_dash_height', array(
		'label'    => esc_html__( 'Logo Container Height (px)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo_dashboard',
		'priority'   => 35,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	

	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_dash_border_btm', array(
		'default' => 'rgba(0,0,0,0.08)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_header_dash_border_btm', array(
		'default' => 'rgba(0,0,0,0.08)',
		'label'    => esc_html__( 'Header Border Bottom', 'skrn-progression' ),
		'section'  => 'progression_studios_section_header_dashboard_main',
		'priority'   => 100,
		)) 
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_dash_background', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_header_dash_background', array(
		'default' => '#ffffff',
		'label'    => esc_html__( 'Header Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_header_dashboard_main',
		'priority'   => 130,
		)) 
	);
	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'progression_studios_header_dash_background_bg_image' ,array(	
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_header_dash_background_bg_image', array(
		'label'    => esc_html__( 'Header Background Image', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_dashboard_main',
		'priority'   => 140,
		))
	);
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_dash_image_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_header_dash_image_image_position', array(
		'label'    => esc_html__( 'Image Cover', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_dashboard_main',
		'priority'   => 150,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'skrn-progression' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'skrn-progression' ),
		),
		))
	);
	
	
	
	
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_header_search_columns',array(
		'default' => '4',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_header_search_columns', array(
		'label'    => esc_html__( 'Search Columns', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 20,
		'choices'     => array(
			'min'  => 1,
			'max'  => 5,
			'step' => 1
		), ) ) 
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_field_type' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_field_type', array(
		'label'    => esc_html__( 'Display Type Field', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 22,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_field_genre' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_field_genre', array(
		'label'    => esc_html__( 'Display Genre Field', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 25,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_field_duration' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_field_duration', array(
		'label'    => esc_html__( 'Display Duration Field', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 30,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_field_category' ,array(
		'default' => 'false',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_field_category', array(
		'label'    => esc_html__( 'Display Category Field', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 35,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	

	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_field_director' ,array(
		'default' => 'false',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_field_director', array(
		'label'    => esc_html__( 'Display Director Field', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 40,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_field_rating' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_field_rating', array(
		'label'    => esc_html__( 'Display Average Rating Field', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 45,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_multiple_genre' ,array(
		'default' => 'single',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_multiple_genre', array(
		'label'    => esc_html__( 'Multiple Genre Choices', 'skrn-progression' ),
		'description'    => esc_html__( 'Choose if you want to allow single or multiple choices', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 900,
		'choices' => array(
			'single' => esc_html__( 'Single', 'skrn-progression' ),
			'multiple' => esc_html__( 'Multiple', 'skrn-progression' ),
		
		 ),
		))
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_multiple_cat' ,array(
		'default' => 'single',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_multiple_cat', array(
		'label'    => esc_html__( 'Multiple Category Choices', 'skrn-progression' ),
		'description'    => esc_html__( 'Choose if you want to allow single or multiple choices', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 905,
		'choices' => array(
			'single' => esc_html__( 'Single', 'skrn-progression' ),
			'multiple' => esc_html__( 'Multiple', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_search_multiple_director' ,array(
		'default' => 'single',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_search_multiple_director', array(
		'label'    => esc_html__( 'Multiple Director Choices', 'skrn-progression' ),
		'description'    => esc_html__( 'Choose if you want to allow single or multiple choices', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-search',
		'priority'   => 905,
		'choices' => array(
			'single' => esc_html__( 'Single', 'skrn-progression' ),
			'multiple' => esc_html__( 'Multiple', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
	
	
	
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_dash_sidebar_sticky' ,array(
		'default' => 'fixed',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_dash_sidebar_sticky', array(
		'label'    => esc_html__( 'Sticky Sidebar', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 5,
		'choices'     => array(
			'fixed' => esc_html__( 'Sticky Sidebar', 'skrn-progression' ),
			'absolute' => esc_html__( 'Default Sidebar', 'skrn-progression' ),
		),
		))
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_dash_sidebar_width',array(
		'default' => '160',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_dash_sidebar_width', array(
		'label'    => esc_html__( 'Sidebar Width (px)', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 8,
		'choices'     => array(
			'min'  => 0,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_dash_sidebar_background', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_dash_sidebar_background', array(
		'default' => '#ffffff',
		'label'    => esc_html__( 'Sidebar Background', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 10,
		)) 
	);
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_dash_sidebar_border_right', array(
		'default' => 'rgba(0, 0, 0, 0.04)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_dash_sidebar_border_right', array(
		'default' => 'rgba(0, 0, 0, 0.04)',
		'label'    => esc_html__( 'Sidebar Border Right', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 13,
		)) 
	);


	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_dash_icon_font_size',array(
		'default' => '40',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_dash_icon_font_size', array(
		'label'    => esc_html__( 'Icon Font Size', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 500,
		'choices'     => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_dash_icon_margin_btm',array(
		'default' => '6',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_dash_icon_margin_btm', array(
		'label'    => esc_html__( 'Icon Margin Bottom', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 505,
		'choices'     => array(
			'min'  => 5,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_dash_font_size',array(
		'default' => '12',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_dash_font_size', array(
		'label'    => esc_html__( 'Navigation Font Size', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 505,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_dash_padding',array(
		'default' => '26',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_dash_padding', array(
		'label'    => esc_html__( 'Navigation Padding Top/Bottom', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 510,
		'choices'     => array(
			'min'  => 5,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	


	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_dash_font_color', array(
		'default'	=> '#848484',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_nav_dash_font_color', array(
		'default'	=> '#848484',
		'label'    => esc_html__( 'Navigation Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_dash_font_color_hover', array(
		'default'	=> '#3db13d',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_nav_dash_font_color_hover', array(
		'default'	=> '#3db13d',
		'label'    => esc_html__( 'Navigation Font Hover Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 530,
		)) 
	);
	
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_dash_font_bg', array(
		'default'	=> 'rgba(255,255,255,  0)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_nav_dash_font_bg', array(
		'default'	=> 'rgba(255,255,255,  0)',
		'label'    => esc_html__( 'Navigation Item Background', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 536,
		)) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_dash_bg_hover', array(
		'default'	=> 'rgba(255,255,255,  0)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_nav_dash_bg_hover', array(
		'default'	=> 'rgba(255,255,255,  0)',
		'label'    => esc_html__( 'Navigation Item Background Hover', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 536,
		)) 
	);


	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_dash_sidebar_border_btm', array(
		'default' => '#e7e7e7',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_dash_sidebar_border_btm', array(
		'default' => '#e7e7e7',
		'label'    => esc_html__( 'Navigation Border Bottom', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 538,
		)) 
	);

	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_dash_letterspacing',array(
		'default' => '0.02',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_dash_letterspacing', array(
		'label'          => esc_html__( 'Navigation Letter-Spacing', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-options',
		'priority'   => 540,
		'choices'     => array(
			'min'  => -1,
			'max'  => 1,
			'step' => 0.01
		), ) ) 
	);
	
	
	
	
	
	
	
	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_dashboard_sub_nav_bg', array(
		'default' => '#232323',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );	
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_dashboard_sub_nav_bg', array(
		'default' => '#232323',
		'label'    => esc_html__( 'Sub-Navigation Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-sub-navigation',
		'priority'   => 10,
		)) 
	);
	
	
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_sub_nav_dashboard_font_size',array(
		'default' => '13',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sub_nav_dashboard_font_size', array(
		'label'    => esc_html__( 'Sub-Navigation Font Size', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-sub-navigation',
		'priority'   => 510,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_dashboard_letterspacing' ,array(
		'default' => '0.02',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sub_nav_dashboard_letterspacing', array(
		'label'          => esc_html__( 'Sub-Navigation Letter-Spacing', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-sub-navigation',
		'priority'   => 515,
		'choices'     => array(
			'min'  => -1,
			'max'  => 1,
			'step' => 0.01
		), ) ) 
	);

	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_dashboard_font_color', array(
		'default'	=> 'rgba(255,255,255, 0.6)',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_dashboard_font_color', array(
		'default'	=> 'rgba(255,255,255, 0.6)',
		'label'    => esc_html__( 'Sub-Navigation Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-sub-navigation',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_hover_dashboard_font_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_hover_dashboard_font_color', array(
		'default'	=> '#ffffff',
		'label'    => esc_html__( 'Sub-Navigation Font Hover Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-sub-navigation',
		'priority'   => 530,
		)) 
	);
	
	

	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_dashboard_border_color', array(
		'default' => 'rgba(255,255,255, 0.08)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_dashboard_border_color', array(
		'default' => 'rgba(255,255,255, 0.08)',
		'label'    => esc_html__( 'Sub-Navigation Divider Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-dashboard-sidebar-sub-navigation',
		'priority'   => 550,
		)) 
	);
	
	
	
	
	
	
	

	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_dashboard_profile_header_my_profile' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_dashboard_profile_header_my_profile', array(
		'label'    => esc_html__( 'Display My Profile Menu Item', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-header',
		'priority'   => 20,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_dashboard_profile_header_edit_profile' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_dashboard_profile_header_edit_profile', array(
		'label'    => esc_html__( 'Display Edit Profile Menu Item', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-header',
		'priority'   => 25,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_dashboard_profile_header_my_wathclist' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_dashboard_profile_header_my_wathclist', array(
		'label'    => esc_html__( 'Display Watchlist Menu Item', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-header',
		'priority'   => 30,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_dashboard_profile_header_my_favorites' ,array(
		'default' => 'false',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_dashboard_profile_header_my_favorites', array(
		'label'    => esc_html__( 'Display Favorites Menu Item', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-header',
		'priority'   => 35,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	   /* Section - Blog - Blog Index Post Options */
		$wp_customize->add_setting( 'progression_studios_dashboard_profile_header_logout' ,array(
			'default' => 'true',
			'sanitize_callback' => 'progression_studios_sanitize_choices',
		) );
		$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_dashboard_profile_header_logout', array(
			'label'    => esc_html__( 'Display Logout Menu Item', 'skrn-progression' ),
			'section'  => 'tt_font_progression-studios-profile-header',
			'priority'   => 40,
			'choices' => array(
				'true' => esc_html__( 'Display', 'skrn-progression' ),
				'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
			 ),
			))
		);

	
	
	
	
	
	/* Panel - Header */
	$wp_customize->add_panel( 'progression_studios_header_panel', array(
		'priority'    => 5,
		'title'       => esc_html__( 'Landing Page Header', 'skrn-progression' ),
		) 
	);
	
	
	/* Section - General - Site Logo */
	$wp_customize->add_section( 'progression_studios_section_logo', array(
		'title'          => esc_html__( 'Logo', 'skrn-progression' ),
		'panel'          => 'progression_studios_header_panel', // Not typically needed.
		'priority'       => 10,
		) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'progression_studios_theme_logo' ,array(
		'default' => get_template_directory_uri().'/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_theme_logo', array(
		'section' => 'progression_studios_section_logo',
		'priority'   => 10,
		))
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('progression_studios_theme_logo_width',array(
		'default' => '111',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_theme_logo_width', array(
		'label'    => esc_html__( 'Logo Width (px)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo',
		'priority'   => 15,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('progression_studios_theme_logo_margin_top',array(
		'default' => '27',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_theme_logo_margin_top', array(
		'label'    => esc_html__( 'Logo Margin Top (px)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo',
		'priority'   => 20,
		'choices'     => array(
			'min'  => 0,
			'max'  => 250,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('progression_studios_theme_logo_margin_bottom',array(
		'default' => '27',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_theme_logo_margin_bottom', array(
		'label'    => esc_html__( 'Logo Margin Bottom (px)', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo',
		'priority'   => 25,
		'choices'     => array(
			'min'  => 0,
			'max'  => 250,
			'step' => 1
		), ) ) 
	);
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'progression_studios_landing_page_logo_link' ,array(
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_landing_page_logo_link', array(
		'label'    => esc_html__( 'Landing Page Logo Link', 'skrn-progression' ),
		'section'  => 'progression_studios_section_logo',
		'type' => 'text',
		'priority'   => 35,
		)
	);
	



	/* Section - Header - Header Options */
	$wp_customize->add_section( 'progression_studios_section_header_bg', array(
		'title'          => esc_html__( 'Header Options', 'skrn-progression' ),
		'panel'          => 'progression_studios_header_panel', // Not typically needed.
		'priority'       => 20,
		) 
	);

	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_width' ,array(
		'default' => 'progression-studios-header-normal-width',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_header_width', array(
		'label'    => esc_html__( 'Header Layout', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_bg',
		'priority'   => 10,
		'choices'     => array(
			'progression-studios-header-full-width' => esc_html__( 'Full Width', 'skrn-progression' ),
			//'progression-studios-header-full-width-no-gap' => esc_html__( 'No Gap', 'skrn-progression' ),
			'progression-studios-header-normal-width' => esc_html__( 'Content Width', 'skrn-progression' ),
		),
		))
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_border_btm_color', array(
		'default' => 'rgba(0,0,0,  0.07)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_header_border_btm_color', array(
		'default' => 'rgba(0,0,0,  0.07)',
		'label'    => esc_html__( 'Header Border Bottom Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_header_bg',
		'priority'   => 14,
		)) 
	);
	

	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_background_color', array(
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_header_background_color', array(
		'label'    => esc_html__( 'Header Background Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_header_bg',
		'priority'   => 15,
		)) 
	);


	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'progression_studios_header_bg_image' ,array(	
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_header_bg_image', array(
		'label'    => esc_html__( 'Header Background Image', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_bg',
		'priority'   => 40,
		))
	);
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_header_bg_image_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_header_bg_image_image_position', array(
		'label'    => esc_html__( 'Image Cover', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_bg',
		'priority'   => 50,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'skrn-progression' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'skrn-progression' ),
		),
		))
	);
	
	

	
	
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_section( 'progression_studios_section_mobile_header', array(
		'title'          => esc_html__( 'Tablet/Mobile Header Options', 'skrn-progression' ),
		'panel'          => 'progression_studios_header_dashboard_panel', // Not typically needed.
		'priority'       => 23,
		) 
	);
	
	

	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'progression_studios_mobile_header_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_mobile_header_bg', array(
		'label'    => esc_html__( 'Tablet/Mobile Header Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_mobile_header',
		'priority'   => 10,
		)) 
	);
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'progression_studios_mobile_menu_text' ,array(
		'default' => 'off',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_mobile_menu_text', array(
		'label'    => esc_html__( 'Display "Menu" text for Menu', 'skrn-progression' ),
		'section'  => 'progression_studios_section_mobile_header',
		'priority'   => 11,
		'choices'     => array(
			'on' => esc_html__( 'Display', 'skrn-progression' ),
			'off' => esc_html__( 'Hide', 'skrn-progression' ),
		),
		))
	);
	

	
	
	
	
	
	
	/* Section - Header - Sticky Header */
	$wp_customize->add_section( 'progression_studios_section_sticky_header', array(
		'title'          => esc_html__( 'Sticky Header Options', 'skrn-progression' ),
		'panel'          => 'progression_studios_header_panel', // Not typically needed.
		'priority'       => 25,
		) 
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_header_sticky' ,array(
		'default' => 'none-sticky-pro',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_header_sticky', array(
		'section' => 'progression_studios_section_sticky_header',
		'priority'   => 10,
		'choices'     => array(
			'sticky-pro' => esc_html__( 'Sticky Header', 'skrn-progression' ),
			'none-sticky-pro' => esc_html__( 'Disable Sticky Header', 'skrn-progression' ),
		),
		))
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_header_background_color', array(
		'default' =>  '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sticky_header_background_color', array(
		'default' =>  '#ffffff',
		'label'    => esc_html__( 'Sticky Header Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 15,
		)) 
	);
	



	

	
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_logo' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_sticky_logo', array(
		'label'    => esc_html__( 'Sticky Logo', 'skrn-progression' ),
		'section' => 'progression_studios_section_sticky_header',
		'priority'   => 20,
		))
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting('progression_studios_sticky_logo_width',array(
		'default' => '0',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sticky_logo_width', array(
		'label'    => esc_html__( 'Sticky Logo Width (px)', 'skrn-progression' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'skrn-progression' ),
		
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 30,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting('progression_studios_sticky_logo_margin_top',array(
		'default' => '0',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sticky_logo_margin_top', array(
		'label'    => esc_html__( 'Sticky Logo Margin Top (px)', 'skrn-progression' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'skrn-progression' ),
		
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 40,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting('progression_studios_sticky_logo_margin_bottom',array(
		'default' => '0',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sticky_logo_margin_bottom', array(
		'label'    => esc_html__( 'Sticky Logo Margin Bottom (px)', 'skrn-progression' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'skrn-progression' ),
		
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 50,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting('progression_studios_sticky_nav_padding',array(
		'default' => '0',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sticky_nav_padding', array(
		'label'    => esc_html__( 'Sticky Nav Padding Top/Bottom', 'skrn-progression' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 60,
		'choices'     => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_nav_font_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_sticky_nav_font_color', array(
		'label'    => esc_html__( 'Sticky Nav Font Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 70,
		)) 
	);
	
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_nav_font_color_hover', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_sticky_nav_font_color_hover', array(
		'label'    => esc_html__( 'Sticky Nav Font Hover Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 80,
		)) 
	);
	
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_nav_underline', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_sticky_nav_underline', array(
		'label'    => esc_html__( 'Sticky Nav Underline', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 95,
		)) 
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_nav_font_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_sticky_nav_font_bg', array(
		'label'    => esc_html__( 'Sticky Nav Background Color', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 100,
		)) 
	);
	
	/* Setting - Header - Sticky Header */
	$wp_customize->add_setting( 'progression_studios_sticky_nav_font_hover_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_sticky_nav_font_hover_bg', array(
		'label'    => esc_html__( 'Sticky Nav Hover Background', 'skrn-progression' ),
		'section'  => 'progression_studios_section_sticky_header',
		'priority'   => 105,
		)) 
	);
	
	

	

	
	
	
	
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_align' ,array(
		'default' => 'progression-studios-nav-left',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_nav_align', array(
		'label'    => esc_html__( 'Navigation Alignment', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-navigation-font',
		'priority'   => 10,
		'choices'     => array(
			'progression-studios-nav-left' => esc_html__( 'Left', 'skrn-progression' ),
			'progression-studios-nav-center' => esc_html__( 'Center', 'skrn-progression' ),
			'progression-studios-nav-right' => esc_html__( 'Right', 'skrn-progression' ),
		),
		))
	);
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_font_size',array(
		'default' => '13',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_font_size', array(
		'label'    => esc_html__( 'Navigation Font Size', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 500,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_padding',array(
		'default' => '37',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_padding', array(
		'label'    => esc_html__( 'Navigation Padding Top/Bottom', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 505,
		'choices'     => array(
			'min'  => 5,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_left_right',array(
		'default' => '20',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_left_right', array(
		'label'    => esc_html__( 'Navigation Padding Left/Right', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 510,
		'choices'     => array(
			'min'  => 8,
			'max'  => 80,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_font_color', array(
		'default'	=> '#272727',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_nav_font_color', array(
		'default'	=> '#272727',
		'label'    => esc_html__( 'Navigation Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_font_color_hover', array(
		'default'	=> '#272727',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_nav_font_color_hover', array(
		'default'	=> '#272727',
		'label'    => esc_html__( 'Navigation Font Hover Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 530,
		)) 
	);
	
	

	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_underline', array(		
		'default' => '#3db13d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_nav_underline', array(
		'default' => '#3db13d',
		'label'    => esc_html__( 'Navigation Underline', 'skrn-progression' ),
		'description'    => esc_html__( 'Remove underline by clearing the color.', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 535,
		)) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_nav_bg', array(
		'label'    => esc_html__( 'Navigation Item Background', 'skrn-progression' ),
		'description'    => esc_html__( 'Remove background by clearing the color.', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 536,
		)) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_nav_bg_hover', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_nav_bg_hover', array(
		'label'    => esc_html__( 'Navigation Item Background Hover', 'skrn-progression' ),
		'description'    => esc_html__( 'Remove background by clearing the color.', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-navigation-font',
		'priority'   => 536,
		)) 
	);
	
	

	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_nav_letterspacing',array(
		'default' => '0.04',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_nav_letterspacing', array(
		'label'          => esc_html__( 'Navigation Letter-Spacing', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-navigation-font',
		'priority'   => 540,
		'choices'     => array(
			'min'  => -1,
			'max'  => 1,
			'step' => 0.01
		), ) ) 
	);
	
	

	

	
	
	


	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_bg', array(
		'default' => '#232323',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );	
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_bg', array(
		'default' => '#232323',
		'label'    => esc_html__( 'Sub-Navigation Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-sub-navigation-font',
		'priority'   => 10,
		)) 
	);
	
	
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_sub_nav_font_size',array(
		'default' => '13',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sub_nav_font_size', array(
		'label'    => esc_html__( 'Sub-Navigation Font Size', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-sub-navigation-font',
		'priority'   => 510,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_letterspacing' ,array(
		'default' => '0',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_sub_nav_letterspacing', array(
		'label'          => esc_html__( 'Sub-Navigation Letter-Spacing', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-sub-navigation-font',
		'priority'   => 515,
		'choices'     => array(
			'min'  => -1,
			'max'  => 1,
			'step' => 0.01
		), ) ) 
	);

	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_font_color', array(
		'default'	=> 'rgba(255,255,255,  0.7)',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_font_color', array(
		'default'	=> 'rgba(255,255,255,  0.7)',
		'label'    => esc_html__( 'Sub-Navigation Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-sub-navigation-font',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_hover_font_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_hover_font_color', array(
		'default'	=> '#ffffff',
		'label'    => esc_html__( 'Sub-Navigation Font Hover Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-sub-navigation-font',
		'priority'   => 530,
		)) 
	);
	
	

	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'progression_studios_sub_nav_border_color', array(
		'default' => 'rgba(255,255,255,  0.08)',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_sub_nav_border_color', array(
		'default' => 'rgba(255,255,255,  0.08)',
		'label'    => esc_html__( 'Sub-Navigation Divider Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-sub-navigation-font',
		'priority'   => 550,
		)) 
	);

	
	
	
	
	
	
	
	
	
	/* Panel - Body */
	$wp_customize->add_panel( 'progression_studios_body_panel', array(
		'priority'    => 8,
        'title'       => esc_html__( 'Body', 'skrn-progression' ),
    ) );
	 
	 
	 
 	/* Setting - Body - Body Main */
 	$wp_customize->add_setting( 'progression_studios_default_link_color', array(
 		'default'	=> '#3db13d',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_default_link_color', array(
 		'label'    => esc_html__( 'Default Link Color', 'skrn-progression' ),
 		'section'  => 'tt_font_progression-studios-body-font',
 		'priority'   => 500,
 		)) 
 	);

 	/* Setting - Body - Body Main */
 	$wp_customize->add_setting( 'progression_studios_default_link_hover_color', array(
 		'default'	=> '#9d9d9d',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_default_link_hover_color', array(
 		'label'    => esc_html__( 'Default Hover Link Color', 'skrn-progression' ),
 		'section'  => 'tt_font_progression-studios-body-font',
 		'priority'   => 510,
 		)) 
 	);
	


	
	
	/* Setting - Body - Body Main */
	$wp_customize->add_setting( 'progression_studios_background_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_background_color', array(
		'label'    => esc_html__( 'Body Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-body-font',
		'priority'   => 513,
		)) 
	);
	
	/* Setting - Body - Body Main */
	$wp_customize->add_setting( 'progression_studios_body_bg_image' ,array(		
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_body_bg_image', array(
		'label'    => esc_html__( 'Body Background Image', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-body-font',
		'priority'   => 525,
		))
	);
	
	/* Setting - Body - Body Main */
	$wp_customize->add_setting( 'progression_studios_body_bg_image_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_body_bg_image_image_position', array(
		'label'    => esc_html__( 'Image Cover', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-body-font',
		'priority'   => 530,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'skrn-progression' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'skrn-progression' ),
		),
		))
	);
	

	
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'progression_studios_page_title_bg_color', array(
		'default' => '#fafafa',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_page_title_bg_color', array(
		'label'    => esc_html__( 'Page Title Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-page-title',
		'priority'   => 501,
		)) 
	);
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'progression_studios_page_title_border_btm_color', array(
		'default' => 'rgba(0,0,0,  0.05)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_page_title_border_btm_color', array(
		'default' => 'rgba(0,0,0,  0.05)',
		'label'    => esc_html__( 'Page Title Border Bottom Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-page-title',
		'priority'   => 505,
		)) 
	);

	

	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting('progression_studios_page_title_padding_top',array(
		'default' => '90',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_page_title_padding_top', array(
		'label'    => esc_html__( 'Page Title Top Padding', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-page-title',
		'priority'   => 511,
		'choices'     => array(
			'min'  => 0,
			'max'  => 450,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting('progression_studios_page_title_padding_bottom',array(
		'default' => '85',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_page_title_padding_bottom', array(
		'label'    => esc_html__( 'Page Title Bottom Padding', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-page-title',
		'priority'   => 515,
		'choices'     => array(
			'min'  => 0,
			'max'  => 450,
			'step' => 1
		), ) ) 
	);
	
	

	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'progression_studios_page_title_bg_image' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_page_title_bg_image', array(
		'label'    => esc_html__( 'Page Title Background Image', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-page-title',
		'priority'   => 535,
		))
	);
	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'progression_studios_page_title_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_page_title_image_position', array(
		'section' => 'tt_font_progression-studios-page-title',
		'priority'   => 536,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'skrn-progression' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'skrn-progression' ),
		),
		))
	);
	
	

	
	
	
	

	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'progression_studios_sidebar_header_border', array(
		'default'	=> '#dddddd',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_sidebar_header_border', array(
		'label'    => esc_html__( 'Sidebar Heading Border Bottom', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-sidebar-headings',
		'priority'   => 328,
		)) 
	);
	


	
	
	
	
	/* Section - Blog - Blog Index Post Options */
   $wp_customize->add_section( 'progression_studios_section_blog_index', array(
   	'title'          => esc_html__( 'Blog Archive Options', 'skrn-progression' ),
   	'panel'          => 'progression_studios_blog_panel', // Not typically needed.
   	'priority'       => 20,
   ) 
	);
	

	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_layout_dash' ,array(
		'default' => 'dashboard',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_layout_dash', array(
		'label'    => esc_html__( 'Blog Container Layout', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 90,
		'choices' => array(
			'dashboard' => esc_html__( 'Dashboard', 'skrn-progression' ),
			'landing' => esc_html__( 'Landing', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_cat_sidebar' ,array(
		'default' => 'right-sidebar',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_cat_sidebar', array(
		'label'    => esc_html__( 'Archive/Category Sidebar', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 100,
		'choices' => array(
			'left-sidebar' => esc_html__( 'Left', 'skrn-progression' ),
			'right-sidebar' => esc_html__( 'Right', 'skrn-progression' ),
			'no-sidebar' => esc_html__( 'Hidden', 'skrn-progression' ),
		
		 ),
		))
	);
	

	
	

 
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('progression_studios_blog_image_opacity',array(
		'default' => '1',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_blog_image_opacity', array(
		'label'    => esc_html__( 'Image Transparency on Hover', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 206,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1,
			'step' => 0.05
		), ) ) 
	);
	
	
	
	
	

   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_image_bg', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_blog_image_bg', array(
		'default' => '#ffffff',
		'label'    => esc_html__( 'Post Image Background Color', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 207,
		)) 
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_content_bg', array(
		'default' => '#f8f8f8',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_blog_content_bg', array(
		'default' => '#f8f8f8',
		'label'    => esc_html__( 'Content Background', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 210,
		)) 
	);
	
	
	
	
	
 
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_meta_author_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_meta_author_display', array(
		'label'    => esc_html__( 'Author', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 335,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_meta_date_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_meta_date_display', array(
		'label'    => esc_html__( 'Date', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_index_meta_category_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_index_meta_category_display', array(
		'label'    => esc_html__( 'Category', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_meta_comment_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_meta_comment_display', array(
		'label'    => esc_html__( 'Comment Count', 'skrn-progression' ),
		'section' => 'progression_studios_section_blog_index',
		'priority'   => 355,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
	
  
  



	
   /* Section - Blog - Blog Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_post_sidebar' ,array(
		'default' => 'right',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_post_sidebar', array(
		'label'    => esc_html__( 'Blog Post Sidebar', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-post-options',
		'priority'   => 1650,
		'choices'     => array(
			'left' => esc_html__( 'Left', 'skrn-progression' ),
			'right' => esc_html__( 'Right', 'skrn-progression' ),
			'none' => esc_html__( 'No Sidebar', 'skrn-progression' ),
		),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_post_index_meta_category_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_post_index_meta_category_display', array(
		'label'    => esc_html__( 'Category', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-post-options',
		'priority'   => 1652,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_post_meta_author_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_post_meta_author_display', array(
		'label'    => esc_html__( 'Author', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-post-options',
		'priority'   => 2035,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_post_meta_date_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_post_meta_date_display', array(
		'label'    => esc_html__( 'Date', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-post-options',
		'priority'   => 2340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_post_meta_comment_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_post_meta_comment_display', array(
		'label'    => esc_html__( 'Comment Count', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-post-options',
		'priority'   => 2355,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
	
	/* Setting - Body - Header Login Button Styles */
	$wp_customize->add_setting( 'progression_studios_header_btn_color', array(
		'default'	=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_header_btn_color', array(
		'label'    => esc_html__( 'Login Button Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-header-button-typography',
		'priority'   => 1500,
		)) 
	);
	
	/* Setting - Body - Header Login Button Styles */
	$wp_customize->add_setting( 'progression_studios_header_btn_background', array(
		'default'	=> '#f9f9f9',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_header_btn_background', array(
		'label'    => esc_html__( 'Login Button Background', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-header-button-typography',
		'priority'   => 1510,
		)) 
	);
	
	/* Setting - Body - Header Login Button Styles */
	$wp_customize->add_setting( 'progression_studios_header_btn_border', array(
		'default'	=> '#e7e7e7',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_header_btn_border', array(
		'label'    => esc_html__( 'Login Button Border', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-header-button-typography',
		'priority'   => 1520,
		)) 
	);
	
	
	
	
	/* Setting - Body - Header Login Button Styles */
	$wp_customize->add_setting( 'progression_studios_header_btn_hover_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_header_btn_hover_color', array(
		'label'    => esc_html__( 'Hover Login Button Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-header-button-typography',
		'priority'   => 1530,
		)) 
	);
	
	/* Setting - Body - Header Login Button Styles */
	$wp_customize->add_setting( 'progression_studios_header_btn_hover_background', array(
		'default'	=> '#43af43',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_header_btn_hover_background', array(
		'label'    => esc_html__( 'Hover Login Button Background', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-header-button-typography',
		'priority'   => 1540,
		)) 
	);
	
	/* Setting - Body - Header Login Button Styles */
	$wp_customize->add_setting( 'progression_studios_header_btn_hover_border', array(
		'default'	=> '#43af43',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_header_btn_hover_border', array(
		'label'    => esc_html__( 'Hover Login Button Border', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-header-button-typography',
		'priority'   => 1550,
		)) 
	);
	
	
	
	
	
	
	




	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'progression_studios_button_font', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_armember_input_styles' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_armember_input_styles', array(
		'label'    => esc_html__( 'Button/Input Styling', 'skrn-progression' ),
		'description'    => esc_html__( 'If you would like to use ARMember to control the styles of your forms, check that box.', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 5,
		'choices' => array(
			'true' => esc_html__( 'Default Styles', 'skrn-progression' ),
			'false' => esc_html__( 'Custom Armember Styling', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_button_font', array(
		'label'    => esc_html__( 'Button Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1635,
		)) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'progression_studios_button_background', array(
		'default'	=> '#43af43',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_button_background', array(
		'label'    => esc_html__( 'Button Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1640,
		)) 
	);
	


	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'progression_studios_button_font_hover', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_button_font_hover', array(
		'label'    => esc_html__( 'Hover Button Font Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1650,
		)) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'progression_studios_button_background_hover', array(
		'default'	=> '#9d9d9d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_button_background_hover', array(
		'label'    => esc_html__( 'Hover Button Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1680,
		)) 
	);
	
	

	/* Setting - Body - Button Styles */
	$wp_customize->add_setting('progression_studios_button_font_size',array(
		'default' => '13',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_button_font_size', array(
		'label'    => esc_html__( 'Button Font Size', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1700,
		'choices'     => array(
			'min'  => 4,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting('progression_studios_button_letter_spacing',array(
		'default' => '0',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_button_letter_spacing', array(
		'label'    => esc_html__( 'Button Letter Spacing', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1710,
		'choices'     => array(
			'min'  => 0,
			'max'  => 2,
			'step' => 0.01
		), ) ) 
	);


	/* Setting - Body - Button Styles */
	$wp_customize->add_setting('progression_studios_button_bordr_radius',array(
		'default' => '4',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_button_bordr_radius', array(
		'label'    => esc_html__( 'Button Border Radius', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1750,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting('progression_studios_ionput_bordr_radius',array(
		'default' => '4',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_ionput_bordr_radius', array(
		'label'    => esc_html__( 'Input Border Radius', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1750,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'progression_studios_input_background', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_input_background', array(
		'default'	=> '#ffffff',
		'label'    => esc_html__( 'Default Input Background Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1790,
		)) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'progression_studios_input_border', array(
		'default'	=> '#dddddd',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_input_border', array(
		'default'	=> '#dddddd',
		'label'    => esc_html__( 'Default Input Border Color', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-button-typography',
		'priority'   => 1790,
		)) 
	);
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_profile_page_user_stats' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_profile_page_user_stats', array(
		'label'    => esc_html__( 'Display User Stats', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-page',
		'priority'   => 35,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_profile_page_member_since' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_profile_page_member_since', array(
		'label'    => esc_html__( 'Display Member Since', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-page',
		'priority'   => 40,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_profile_page_biography' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_profile_page_biography', array(
		'label'    => esc_html__( 'Display Biography', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-page',
		'priority'   => 45,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_profile_page_favorites' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_profile_page_favorites', array(
		'label'    => esc_html__( 'Display Favorites', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-page',
		'priority'   => 50,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_profile_page_reviews' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_profile_page_reviews', array(
		'label'    => esc_html__( 'Display Reviews', 'skrn-progression' ),
		'section'  => 'tt_font_progression-studios-profile-page',
		'priority'   => 52,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* Panel - Footer Top LEvel
	$wp_customize->add_panel( 'progression_studios_footer_panel', array(
		'priority'    => 11,
        'title'       => esc_html__( 'Footer', 'skrn-progression' ),
    ) 
 	);
	*/
	
	
	/* Section - General - General Layout */
	$wp_customize->add_section( 'progression_studios_section_dash_footer_section', array(
		'title'          => esc_html__( 'Dashboard Footer', 'skrn-progression' ),
		/* 'panel'          => 'progression_studios_footer_panel',*/  // Not typically needed.
		'priority'       => 11,
		) 
	);
	

	
	$wp_customize->add_setting( 'progression_studios_footer_dash_elementor_library' ,array(
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_footer_dash_elementor_library', array(
	  'type' => 'select',
	  'section' => 'progression_studios_section_dash_footer_section',
	  'priority'   => 5,
	  'label'    => esc_html__( 'Footer Elementor Template', 'skrn-progression' ),
	  'description'    => esc_html__( 'You can add/edit your footer under ', 'skrn-progression') . '<a href="' . admin_url() . 'edit.php?post_type=elementor_library">Elementor > My Library</a>',
	  'choices'  => 	   $progression_studios_elementor_library_list,
	) );
	
	
	/* Section - General - General Layout */
	$wp_customize->add_section( 'progression_studios_section_footer_section', array(
		'title'          => esc_html__( 'Landing Page Footer', 'skrn-progression' ),
		/* 'panel'          => 'progression_studios_footer_panel',*/  // Not typically needed.
		'priority'       => 12,
		) 
	);

	
	$wp_customize->add_setting( 'progression_studios_footer_elementor_library' ,array(
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_footer_elementor_library', array(
	  'type' => 'select',
	  'section' => 'progression_studios_section_footer_section',
	  'priority'   => 5,
	  'label'    => esc_html__( 'Footer Elementor Template', 'skrn-progression' ),
	  'description'    => esc_html__( 'You can add/edit your footer under ', 'skrn-progression') . '<a href="' . admin_url() . 'edit.php?post_type=elementor_library">Elementor > My Library</a>',
	  'choices'  => 	   $progression_studios_elementor_library_list,
	) );
	

	
	/* Setting - Footer - Footer Main */
 	$wp_customize->add_setting( 'progression_studios_footer_background', array(
 		'default'	=> '#282828',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_footer_background', array(
 		'label'    => esc_html__( 'Copyright Background', 'skrn-progression' ),
 		'section' => 'progression_studios_section_footer_section',
 		'priority'   => 500,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
 		)) 
 	);



	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'progression_studios_footer_copyright' ,array(
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control( 'progression_studios_footer_copyright', array(
		'label'          => esc_html__( 'Copyright Text', 'skrn-progression' ),
 	  'description'    => esc_html__( 'This default text will be replaced if you use a template above.', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'type' => 'textarea',
		'priority'   => 10,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		)
	);
	
	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'progression_studios_copyright_text_color', array(
		'default' => 'rgba(255,255,255,0.45)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_copyright_text_color', array(
		'default' => 'rgba(255,255,255,0.45)',
		'label'    => esc_html__( 'Copyright Text Color', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'priority'   => 525,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		)) 
	);

	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'progression_studios_copyright_link', array(
		'default' => 'rgba(255,255,255,0.75)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_copyright_link', array(
		'default' => 'rgba(255,255,255,0.75)',
		'label'    => esc_html__( 'Copyright Link Color', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'priority'   => 530,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		)) 
	);
	
	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'progression_studios_copyright_link_hover', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_copyright_link_hover', array(
		'label'    => esc_html__( 'Copyright Link Hover Color', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'priority'   => 540,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		)) 
	);
	
	

	
 	
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'progression_studios_footer_copyright_location' ,array(
		'default' => 'footer-copyright-align-left',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_footer_copyright_location', array(
		'label'    => esc_html__( 'Copyright Text Alignment', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'priority'   => 19,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		'choices'     => array(
			'footer-copyright-align-left' => esc_html__( 'Left', 'skrn-progression' ),
			'footer-copyright-align-center' => esc_html__( 'Center', 'skrn-progression' ),
			'footer-copyright-align-right' => esc_html__( 'Right', 'skrn-progression' ),
		),
		))
	);
	
	
	
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('progression_studios_copyright_margin_top',array(
		'default' => '45',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_copyright_margin_top', array(
		'label'    => esc_html__( 'Copyright Padding Top', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'priority'   => 20,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('progression_studios_copyright_margin_bottom',array(
		'default' => '50',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_copyright_margin_bottom', array(
		'label'    => esc_html__( 'Copyright Padding Bottom', 'skrn-progression' ),
		'section' => 'progression_studios_section_footer_section',
		'priority'   => 22,
		'active_callback' => function() use ( $wp_customize ) {
		        return '' === $wp_customize->get_setting( 'progression_studios_footer_elementor_library' )->value();
		    },
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);

  
  
   
	
	
	/* Panel - Video */
	$wp_customize->add_panel( 'progression_studios_videos_panel', array(
		'priority'    => 9,
        'title'       => esc_html__( 'Videos', 'skrn-progression' ),
    ) );
	
	
    /* Section - Blog - Blog Index Post Options */
 	$wp_customize->add_setting('progression_studios_media_posts_page',array(
 		'default' => '12',
 		'sanitize_callback' => 'progression_studios_sanitize_choices',
 	) );
 	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_media_posts_page', array(
 		'label'    => esc_html__( 'Archive Posts Per Page', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
 		'priority'   => 4,
 		'choices'     => array(
 			'min'  => 1,
 			'max'  => 100,
 			'step' => 1
 		), ) ) 
 	);
	
	
    /* Section - Blog - Blog Index Post Options */
 	$wp_customize->add_setting('progression_studios_blog_columns',array(
 		'default' => '4',
 		'sanitize_callback' => 'progression_studios_sanitize_choices',
 	) );
 	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_blog_columns', array(
 		'label'    => esc_html__( 'Archive Columns', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
 		'priority'   => 5,
 		'choices'     => array(
 			'min'  => 1,
 			'max'  => 6,
 			'step' => 1
 		), ) ) 
 	);
	
	
    /* Section - Blog - Blog Index Post Options */
 	$wp_customize->add_setting('progression_studios_blog_index_gap',array(
 		'default' => '15',
 		'sanitize_callback' => 'progression_studios_sanitize_choices',
 	) );
 	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_blog_index_gap', array(
 		'label'    => esc_html__( 'Archive Margins', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
 		'priority'   => 8,
 		'choices'     => array(
 			'min'  => 0,
 			'max'  => 100,
 			'step' => 1
 		), ) ) 
 	);
	
	
	
    /* Section - Blog - Blog Index Post Options */
 	$wp_customize->add_setting('progression_studios_video_image_opacity',array(
 		'default' => '1',
 		'sanitize_callback' => 'progression_studios_sanitize_choices',
 	) );
 	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_video_image_opacity', array(
 		'label'    => esc_html__( 'Image Transparency on Hover', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
 		'priority'   => 10,
 		'choices'     => array(
 			'min'  => 0,
 			'max'  => 1,
 			'step' => 0.05
 		), ) ) 
 	);
	

    /* Section - Blog - Blog Index Post Options */
 	$wp_customize->add_setting( 'progression_studios_video_index_image_bg', array(
 		'default' => '#ffffff',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_video_index_image_bg', array(
 		'label'    => esc_html__( 'Index Image Background', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
 		'priority'   => 20,
 		)) 
 	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_blog_transition' ,array(
		'default' => 'progression-studios-blog-image-no-effect',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( 'progression_studios_blog_transition', array(
		'label'    => esc_html__( 'Index Image Hover Effect', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
		'type' => 'select',
		'priority'   => 22,
		'choices' => array(
			'progression-studios-blog-image-scale' => esc_html__( 'Zoom', 'skrn-progression' ),
			'progression-studios-blog-image-zoom-grey' => esc_html__( 'Greyscale', 'skrn-progression' ),
			'progression-studios-blog-image-zoom-sepia' => esc_html__( 'Sepia', 'skrn-progression' ),
			'progression-studios-blog-image-zoom-saturate' => esc_html__( 'Saturate', 'skrn-progression' ),
			'progression-studios-blog-image-zoom-shine' => esc_html__( 'Shine', 'skrn-progression' ),
			'progression-studios-blog-image-no-effect' => esc_html__( 'No Effect', 'skrn-progression' ),
		
		 ),
		)
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_content_bg', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_video_content_bg', array(
		'default' => '#ffffff',
		'label'    => esc_html__( 'Content Background', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
		'priority'   => 25,
		)) 
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_content_border', array(
		'default' => 'rgba(0,0,0,0.08)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_video_content_border', array(
		'default' => 'rgba(0,0,0,0.08)',
		'label'    => esc_html__( 'Content Border', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
		'priority'   => 26,
		)) 
	);
	
	
	
	
	
   /* Section - Blog - Blog Post Options */
 	$wp_customize->add_setting( 'progression_studios_blog_post_sharing' ,array(
 		'default' => 'on',
 		'sanitize_callback' => 'progression_studios_sanitize_choices',
 	) );
 	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_blog_post_sharing', array(
 		'label'    => esc_html__( 'Post Sharing', 'skrn-progression' ),
 		'section' => 'progression_studios_section_blog_post_sharing',
 		'priority'   => 5,
 		'choices'     => array(
 			'on' => esc_html__( 'Display', 'skrn-progression' ),
 			'off' => esc_html__( 'Hide', 'skrn-progression' ),
 		),
 		))
 	);
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_rating_index_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_rating_index_display', array(
		'label'    => esc_html__( 'Rating', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
		'priority'   => 750,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
 
 	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_excerpt_display' ,array(
		'default' => 'false',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_video_excerpt_display', array(
		'label'    => esc_html__( 'Excerpt Text', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-index-options',
		'priority'   => 755,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
	
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('progression_studios_media_header_height',array(
		'default' => '80',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_media_header_height', array(
		'label'    => esc_html__( 'Header Height (%)', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 5,
		'choices'     => array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	
	
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'progression_studios_media_header_color', array(
		'default' => '#555555',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_media_header_color', array(
		'label'    => esc_html__( 'Header Background Color', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 10,
		)) 
	);
	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'progression_studios_media_header_image' ,array(	
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'progression_studios_media_header_image', array(
		'label'    => esc_html__( 'Header Background Image', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 15,
		))
	);
	
	
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'progression_studios_media_sidebar_meta_bg', array(
		'default' => '#fafafa',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_media_sidebar_meta_bg', array(
		'label'    => esc_html__( 'Sidebar Meta Background', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 35,
		)) 
	);
	
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_grenre_sidebar' ,array(
		'default' => 'false',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_grenre_sidebar', array(
		'label'    => esc_html__( '"Genre" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 800,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_releases_date_sidebar' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_releases_date_sidebar', array(
		'label'    => esc_html__( '"Release Date" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 805,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_duration_sidebar' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_duration_sidebar', array(
		'label'    => esc_html__( '"Duration" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 808,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_director_sidebar' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_director_sidebar', array(
		'label'    => esc_html__( '"Director" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 808,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_recent_reviews_sidebar' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_recent_reviews_sidebar', array(
		'label'    => esc_html__( '"Recent Reviews" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 810,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_lead_cast' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_lead_cast', array(
		'label'    => esc_html__( '"Lead Cast" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 810,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_media_more_like_this' ,array(
		'default' => 'true',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_media_more_like_this', array(
		'label'    => esc_html__( '"More Like This" Section', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 825,
		'choices' => array(
			'true' => esc_html__( 'Display', 'skrn-progression' ),
			'false' => esc_html__( 'Hide', 'skrn-progression' ),
		
		 ),
		))
	);
	

	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('progression_studios_media_more_like_columns',array(
		'default' => '3',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_media_more_like_columns', array(
		'label'    => esc_html__( '"More Like This" Columns', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 835,
		'choices'     => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1
		), ) ) 
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('progression_studios_media_more_like_post_count',array(
		'default' => '3',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_media_more_like_post_count', array(
		'label'    => esc_html__( '"More Like This" Post Count', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-post-options',
		'priority'   => 840,
		'choices'     => array(
			'min'  => 1,
			'max'  => 25,
			'step' => 1
		), ) ) 
	);
	
	
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_rating_color', array(
		'default' => '#42b740',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_video_rating_color', array(
		'label'    => esc_html__( 'Positive Rating Color', 'skrn-progression' ),
		'description'    => esc_html__( 'When rating is 7 or higher', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-rating-options',
		'priority'   => 20,
		)) 
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_rating_secondary_color', array(
		'default' => '#def6de',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_video_rating_secondary_color', array(
		'label'    => esc_html__( 'Positive Rating Secondary Color', 'skrn-progression' ),
		'description'    => esc_html__( 'When rating is 7 or higher', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-rating-options',
		'priority'   => 25,
		)) 
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_rating_negative_color', array(
		'default' => '#ff4141',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_video_rating_negative_color', array(
		'label'    => esc_html__( 'Positive Rating Color', 'skrn-progression' ),
		'description'    => esc_html__( 'When rating is lower than 7', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-rating-options',
		'priority'   => 30,
		)) 
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'progression_studios_video_rating_negative_secondary_color', array(
		'default' => '#ffe1e1',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_video_rating_negative_secondary_color', array(
		'label'    => esc_html__( 'Positive Rating Secondary Color', 'skrn-progression' ),
		'description'    => esc_html__( 'When rating is lower than 7', 'skrn-progression' ),
	'section' => 'tt_font_progression-studios-video-rating-options',
		'priority'   => 35,
		)) 
	);
	
	
	
	
	
	
	/* Panel - Body */
	$wp_customize->add_panel( 'progression_studios_blog_panel', array(
		'priority'    => 10,
        'title'       => esc_html__( 'Blog', 'skrn-progression' ),
    ) );
	
	


	
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'progression_studios_blog_title_link', array(
		'default' => '#282828',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_blog_title_link', array(
		'label'    => esc_html__( 'Title Color', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-headings',
		'priority'   => 5,
		)) 
	);
	
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'progression_studios_blog_title_link_hover', array(
		'default' => '#3db13d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'progression_studios_blog_title_link_hover', array(
		'label'    => esc_html__( 'Title Hover Color', 'skrn-progression' ),
		'section' => 'tt_font_progression-studios-blog-headings',
		'priority'   => 10,
		)) 
	);
	

	
	
	
	

	
	
	/* Setting - General - Page Loader */
	$wp_customize->add_setting( 'progression_studios_icon_position' ,array(
		'default' => 'default',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control(new progression_studios_Controls_Radio_Buttonset_Control($wp_customize, 'progression_studios_icon_position', array(
		'label'    => esc_html__( 'Display Page Loader?', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_icons_section',
		'priority'   => 2,
		'choices'     => array(
			'default' => esc_html__( 'Default', 'skrn-progression' ),
			'header-top-left' => esc_html__( 'Top Left', 'skrn-progression' ),
			'header-top-right' => esc_html__( 'Top Right', 'skrn-progression' ),
		),
		))
	);

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('progression_studios_social_icons_margintop',array(
		'default' => '29',
		'sanitize_callback' => 'progression_studios_sanitize_choices',
	) );
	$wp_customize->add_control( new progression_studios_Controls_Slider_Control($wp_customize, 'progression_studios_social_icons_margintop', array(
		'label'    => esc_html__( 'Icon Margin Top', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_icons_section',
		'priority'   => 3,
		'choices'     => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_social_icons_color', array(
		'default'	=> 'rgba(255,255,255,  0.85)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_social_icons_color', array(
		'default'	=> 'rgba(255,255,255,  0.85)',
		'label'    => esc_html__( 'Icon Color', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_icons_section',
		'priority'   => 5,
		)) 
	);
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_social_icons_bg', array(
		'default'	=> 'rgba(255,255,255,  0.15)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_social_icons_bg', array(
		'default'	=> 'rgba(255,255,255,  0.15)',
		'label'    => esc_html__( 'Icon Background', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_icons_section',
		'priority'   => 7,
		)) 
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_social_icons_hover_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_social_icons_hover_color', array(
		'default'	=> '#ffffff',
		'label'    => esc_html__( 'Icon Hover Color', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_icons_section',
		'priority'   => 8,
		)) 
	);
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'progression_studios_social_icons_hover_bg', array(
		'default'	=> 'rgba(255,255,255,  0.22)',
		'sanitize_callback' => 'progression_studios_sanitize_customizer',
	) );
	$wp_customize->add_control(new Progression_Studios_Revised_Alpha_Color_Control($wp_customize, 'progression_studios_social_icons_hover_bg', array(
		'default'	=> 'rgba(255,255,255,  0.22)',
		'label'    => esc_html__( 'Icon Hover Background', 'skrn-progression' ),
		'section' => 'progression_studios_section_header_icons_section',
		'priority'   => 9,
		)) 
	);
	
	

	
	
}
add_action( 'customize_register', 'progression_studios_customizer' );

//HTML Text
function progression_studios_sanitize_customizer( $input ) {
    return wp_kses( $input, TRUE);
}

//no-HTML text
function progression_studios_sanitize_choices( $input ) {
	return wp_filter_nohtml_kses( $input );
}

function progression_studios_customizer_styles() {
	global $post;
	
	//https://codex.wordpress.org/Function_Reference/wp_add_inline_style
	wp_enqueue_style( 'progression-studios-custom-style', get_template_directory_uri() . '/css/progression_studios_custom_styles.css' );

   if ( get_theme_mod( 'progression_studios_header_bg_image')  ) {
      $progression_studios_header_bg_image = "background-image:url(" . esc_attr( get_theme_mod( 'progression_studios_header_bg_image' ) ) . ");";
	}	else {
		$progression_studios_header_bg_image = "";
	}
	
   if ( get_theme_mod( 'progression_studios_media_header_image')  ) {
      $progression_studios_header_media_bg_image = "background-image:url(" . esc_attr( get_theme_mod( 'progression_studios_media_header_image' ) ) . ");";
	}	else {
		$progression_studios_header_media_bg_image = "";
	}
	
   if ( get_theme_mod( 'progression_studios_header_dash_background_bg_image')  ) {
      $progression_studios_header_dash_bg_image = "background-image:url(" . esc_attr( get_theme_mod( 'progression_studios_header_dash_background_bg_image' ) ) . ");";
	}	else {
		$progression_studios_header_dash_bg_image = "";
	}
	
   if ( get_theme_mod( 'progression_studios_header_bg_image_image_position', 'cover') == 'cover' ) {
      $progression_studios_header_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$progression_studios_header_bg_cover = "background-repeat:repeat-all; ";
	}
	
   if ( get_theme_mod( 'progression_studios_header_dash_image_image_position', 'cover') == 'cover' ) {
      $progression_studios_header_dash_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$progression_studios_header_dash_bg_cover = "background-repeat:repeat-all; ";
	}
	
   if ( get_theme_mod( 'progression_studios_body_bg_image') ) {
      $progression_studios_body_bg = "background-image:url(" .   esc_attr( get_theme_mod( 'progression_studios_body_bg_image') ). ");";
	}	else {
		$progression_studios_body_bg = "";
	}
	
   if ( get_theme_mod( 'progression_studios_page_title_bg_image') ) {
      $progression_studios_page_title_bg = "background-image:url(" .   esc_attr( get_theme_mod( 'progression_studios_page_title_bg_image') ). ");";
	}	else {
		$progression_studios_page_title_bg = "";
	}
	
   if ( get_theme_mod( 'progression_studios_body_bg_image_image_position', 'cover') == 'cover') {
      $progression_studios_body_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover; background-attachment: fixed;";
	}	else {
		$progression_studios_body_bg_cover = "background-repeat:repeat-all;";
	}
	
   if ( get_theme_mod( 'progression_studios_page_title_image_position', 'cover') == 'cover' ) {
      $progression_studios_page_tite_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$progression_studios_page_tite_bg_cover = "background-repeat:repeat-all;";
	}
	
	
   if ( get_theme_mod( 'progression_studios_post_title_bg_color')  ) {
      $progression_studios_post_tite_bg_color = "background-color: " . esc_attr( get_theme_mod('progression_studios_post_title_bg_color', '#000000') ) . ";";
	}	else {
		$progression_studios_post_tite_bg_color = "";
	}
	
   if ( get_theme_mod( 'progression_studios_post_page_title_bg_image')  ) {
      $progression_studios_post_tite_bg_image_post = "background-image:url(" .   esc_attr( get_theme_mod( 'progression_studios_post_page_title_bg_image',  get_template_directory_uri().'/images/page-title.jpg' ) ). ");";
	}	else {
		$progression_studios_post_tite_bg_image_post = "";
	}
	
   if ( get_theme_mod( 'progression_studios_blog_image_bg', '#ffffff')  ) {
      $progression_studios_post_tite_bg_featuredimg_bg = ".progression-studios-feaured-image {background:" . esc_attr( get_theme_mod('progression_studios_blog_image_bg', '#ffffff') ) . ";}";
	}	else {
		$progression_studios_post_tite_bg_featuredimg_bg = "";
	}
	
   if ( get_theme_mod( 'progression_studios_page_post_title_image_position', 'cover') == 'cover' ) {
      $progression_studios_post_tite_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$progression_studios_post_tite_bg_cover = "background-repeat:repeat-all;";
	}
	

	
   if ( get_theme_mod( 'progression_studios_sticky_logo_width', '0') != '0' ) {
      $progression_studios_sticky_logo_width = "width:" .  esc_attr( get_theme_mod('progression_studios_sticky_logo_width', '70') ) . "px;";
	}	else {
		$progression_studios_sticky_logo_width = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_logo_margin_top', '0') != '0' ) {
      $progression_studios_sticky_logo_top = "padding-top:" .  esc_attr( get_theme_mod('progression_studios_sticky_logo_margin_top', '31') ) . "px;";
	}	else {
		$progression_studios_sticky_logo_top = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_logo_margin_bottom', '0') != '0' ) {
      $progression_studios_sticky_logo_bottom = "padding-bottom:" .  esc_attr( get_theme_mod('progression_studios_sticky_logo_margin_bottom', '31') ) . "px;";
	}	else {
		$progression_studios_sticky_logo_bottom = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_padding', '0') != '0' ) {
      $progression_studios_sticky_nav_padding = "
		.progression-sticky-scrolled .progression-mini-banner-icon {
			top:" . esc_attr( (get_theme_mod('progression_studios_sticky_nav_padding') - get_theme_mod('progression_studios_nav_font_size', '13')) - 4 ). "px;
		}
		.progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a {
			padding-top:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 3 ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 3 ). "px;
		}
		.progression-sticky-scrolled #progression-shopping-cart-count span.progression-cart-count { top:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') ). "px; }
		.progression-sticky-scrolled #progression-studios-header-login-container a.progresion-studios-login-icon {
			padding-top:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 4  ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 4 ). "px;
		}
		.progression-sticky-scrolled #progression-studios-header-search-icon i.pe-7s-search {
			padding-top:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 4  ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 4 ). "px;
		}
		.progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon {
					padding-top:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 5  ). "px;
					padding-bottom:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') - 5 ). "px;
		}
		.progression-sticky-scrolled .sf-menu a {
			padding-top:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_padding') ). "px;
		}
			";
	}	else {
		$progression_studios_sticky_nav_padding = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_underline') ) {
      $progression_studios_sticky_nav_underline = "
		.progression-sticky-scrolled .sf-menu a:before {
			background:". esc_attr( get_theme_mod('progression_studios_sticky_nav_underline') ). ";
		}
		.progression-sticky-scrolled .sf-menu a:hover:before, .progression-sticky-scrolled .sf-menu li.sfHover a:before, .progression-sticky-scrolled .sf-menu li.current-menu-item a:before {
			opacity:1;
			background:". esc_attr( get_theme_mod('progression_studios_sticky_nav_underline') ). ";
		}
			";
	}	else {
		$progression_studios_sticky_nav_underline = "";
	}
	
   if (  get_theme_mod( 'progression_studios_sticky_nav_font_color') ) {
      $progression_studios_sticky_nav_option_font_color = "
			.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
			.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
			.progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
			.progression-sticky-scrolled .active-mobile-icon-pro #mobile-menu-icon-pro, .progression-sticky-scrolled #mobile-menu-icon-pro,  .progression-sticky-scrolled #mobile-menu-icon-pro:hover,
			.progression-sticky-scrolled  #progression-studios-header-login-container a.progresion-studios-login-icon,
	.progression-sticky-scrolled #progression-studios-header-search-icon i.pe-7s-search,
	.progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a, .progression-sticky-scrolled .sf-menu a {
		color:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_font_color') ) . ";
	}";
	}	else {
		$progression_studios_sticky_nav_option_font_color = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_font_color_hover') ) {
      $progression_studios_optional_sticky_nav_font_hover = "
			.progression_studios_force_light_navigation_color .progression-sticky-scrolled  #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon:hover,
			.progression_studios_force_light_navigation_color .progression-sticky-scrolled  .activated-class #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
			.progression_studios_force_dark_navigation_color .progression-sticky-scrolled  #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon:hover,
			.progression_studios_force_dark_navigation_color .progression-sticky-scrolled  .activated-class #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
		.progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon:hover,
		.progression-sticky-scrolled .activated-class #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
		.progression-sticky-scrolled #progression-studios-header-search-icon:hover i.pe-7s-search, .progression-sticky-scrolled #progression-studios-header-search-icon.active-search-icon-pro i.pe-7s-search, .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a:hover, .progression-sticky-scrolled .sf-menu a:hover, .progression-sticky-scrolled .sf-menu li.sfHover a, .progression-sticky-scrolled .sf-menu li.current-menu-item a {
		color:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_font_color_hover') ) . ";
	}";
	}	else {
		$progression_studios_optional_sticky_nav_font_hover = "";
	}
	
   if ( get_theme_mod( 'progression_studios_nav_bg') ) {
      $progression_studios_optional_nav_bg = "background:" . esc_attr( get_theme_mod('progression_studios_nav_bg') ). ";";
	}	else {
		$progression_studios_optional_nav_bg = "";
	}
	
   if ( get_theme_mod( 'progression_studios_nav_underline', '#3db13d') ) {
      $progression_studios_sticky_nav_underline_default = "
		.sf-menu a:before {
			background:" . esc_attr( get_theme_mod('progression_studios_nav_underline', '#3db13d') ). ";
			margin-top:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 5 ). "px;
		}
		.sf-menu a:hover:before, .sf-menu li.sfHover a:before, .sf-menu li.current-menu-item a:before {
			opacity:1;
			background:" . esc_attr( get_theme_mod('progression_studios_nav_underline', '#3db13d') ). ";
		}
		.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu a:before, 
		.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu a:hover:before, 
		.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover a:before, 
		.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item a:before,
	
		.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu a:before, 
		.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu a:hover:before, 
		.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover a:before, 
		.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item a:before {
			background:" . esc_attr( get_theme_mod('progression_studios_nav_underline', '#3db13d') ). ";
		}
			";
	}	else {
		$progression_studios_sticky_nav_underline_default = "";
	}
	
   if ( get_theme_mod( 'progression_studios_top_header_onoff', 'off-pro') == 'off-pro' ) {
      $progression_studios_top_header_off_on_display = "display:none;";
	}	else {
		$progression_studios_top_header_off_on_display = "";
	}


	
   if ( get_theme_mod( 'progression_studios_nav_bg_hover') ) {
      $progression_studios_optiona_nav_bg_hover = ".sf-menu a:hover, .sf-menu li.sfHover a, .sf-menu li.current-menu-item a { background:".  esc_attr( get_theme_mod('progression_studios_nav_bg_hover') ). "; }";
	}	else {
		$progression_studios_optiona_nav_bg_hover = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_font_bg') ) {
      $progression_studios_optiona_sticky_nav_font_bg = ".progression-sticky-scrolled .sf-menu a { background:".  esc_attr( get_theme_mod('progression_studios_sticky_nav_font_bg') ). "; }";
	}	else {
		$progression_studios_optiona_sticky_nav_font_bg = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_font_hover_bg') ) {
      $progression_studios_optiona_sticky_nav_hover_bg = ".progression-sticky-scrolled .sf-menu a:hover, .progression-sticky-scrolled .sf-menu li.sfHover a, .progression-sticky-scrolled .sf-menu li.current-menu-item a { background:".  esc_attr( get_theme_mod('progression_studios_sticky_nav_font_hover_bg') ). "; }";
	}	else {
		$progression_studios_optiona_sticky_nav_hover_bg = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_font_color') ) {
      $progression_studios_option_sticky_nav_font_color = ".progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon i.pe-7s-search, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container a.progresion-studios-login-icon, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon i.pe-7s-search, .progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container a.progresion-studios-login-icon, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu a {
		color:". esc_attr( get_theme_mod('progression_studios_sticky_nav_font_color') ). ";
	}";
	}	else {
		$progression_studios_option_sticky_nav_font_color = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_font_color_hover') ) {
      $progression_studios_option_stickY_nav_font_hover_color = ".progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon:hover i.pe-7s-search, .progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon.active-search-icon-pro i.pe-7s-search, .progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a:hover,  .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item a,
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon:hover i.pe-7s-search, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon.active-search-icon-pro i.pe-7s-search, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a:hover,  .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item a {
		color:" . esc_attr( get_theme_mod('progression_studios_sticky_nav_font_color_hover') ) . ";
	}";
	}	else {
		$progression_studios_option_stickY_nav_font_hover_color = "";
	}
	


	
   if ( get_theme_mod( 'progression_studios_sticky_nav_highlight_font') ) {
      $progression_studios_option_sticky_hightlight_font_color = "body .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:before, body .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:before, .progression-sticky-scrolled .sf-menu li.sfHover.highlight-button a, .progression-sticky-scrolled .sf-menu li.current-menu-item.highlight-button a, .progression-sticky-scrolled .sf-menu li.highlight-button a, .progression-sticky-scrolled .sf-menu li.highlight-button a:hover { color:".  esc_attr( get_theme_mod('progression_studios_sticky_nav_highlight_font') ). "; }";
	}	else {
		$progression_studios_option_sticky_hightlight_font_color = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_highlight_button') ) {
      $progression_studios_option_sticky_hightlight_bg_color = "body .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:hover, body .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:hover, body .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:before, body  .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:before, .progression-sticky-scrolled .sf-menu li.current-menu-item.highlight-button a:before, .progression-sticky-scrolled .sf-menu li.highlight-button a:before { background:".  esc_attr( get_theme_mod('progression_studios_sticky_nav_highlight_button') ). "; }";
	}	else {
		$progression_studios_option_sticky_hightlight_bg_color = "";
	}
	
   if ( get_theme_mod( 'progression_studios_sticky_nav_highlight_button_hover') ) {
      $progression_studios_option_sticky_hightlight_bg_color_hover = "body .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:hover:before,  body .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:hover:before,
	body .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item.highlight-button a:hover:before, body .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.highlight-button a:hover:before, .progression-sticky-scrolled .sf-menu li.current-menu-item.highlight-button a:hover:before, .progression-sticky-scrolled .sf-menu li.highlight-button a:hover:before { background:".  esc_attr( get_theme_mod('progression_studios_sticky_nav_highlight_button_hover') ). "; }";
	}	else {
		$progression_studios_option_sticky_hightlight_bg_color_hover = "";
	}

   if ( get_theme_mod( 'progression_studios_mobile_header_bg') ) {
      $progression_studios_mobile_header_bg_color = "header#videohead-pro, header#masthead-pro {background:". esc_attr( get_theme_mod('progression_studios_mobile_header_bg') ) . ";  }";
	}	else {
		$progression_studios_mobile_header_bg_color = "";
	}
	
   if ( get_theme_mod( 'progression_studios_mobile_header_logo_width') ) {
      $progression_studios_mobile_header_logo_width = "body #logo-pro img { width:" . esc_attr( get_theme_mod('progression_studios_mobile_header_logo_width') ). "px; } ";
	}	else {
		$progression_studios_mobile_header_logo_width = "";
	}
	
   if ( get_theme_mod( 'progression_studios_mobile_header_logo_margin') ) {
      $progression_studios_mobile_header_logo_margin_top = " body #logo-pro img { padding-top:". esc_attr( get_theme_mod('progression_studios_mobile_header_logo_margin') ). "px; padding-bottom:". esc_attr( get_theme_mod('progression_studios_mobile_header_logo_margin') ). "px; }";
	}	else {
		$progression_studios_mobile_header_logo_margin_top = "";
	}

	
   if ( get_theme_mod( 'progression_studios_header_background_color') ) {
      $progression_studios_header_bg_optional = "
		 body.progression-studios-header-sidebar-before #progression-inline-icons .progression-studios-social-icons, body.progression-studios-header-sidebar-before:before, header#masthead-pro { background-color:" . esc_attr( get_theme_mod('progression_studios_header_background_color', '#1e023d' ) ) . ";
	}";
	}	else {
		$progression_studios_header_bg_optional = "";
	}

	
   if ( get_theme_mod( 'progression_studios_mobile_header_nav_padding') ) {
      $progression_studios_mobile_header_nav_padding_top = "body #mobile-menu-icon-pro {padding-top:" . esc_attr( get_theme_mod('progression_studios_mobile_header_nav_padding') - 3 ) . "px; padding-bottom:" . esc_attr( get_theme_mod('progression_studios_mobile_header_nav_padding') - 5 ) . "px; }";
	}	else {
		$progression_studios_mobile_header_nav_padding_top = "";
	}
	

	
	
   if (  function_exists('z_taxonomy_image_url') && z_taxonomy_image_url() ) {
      $progression_studios_custom_tax_page_title_img = "body #page-title-pro {background-image:url('" . esc_url( z_taxonomy_image_url() ) . "'); }";
	}	else {
		$progression_studios_custom_tax_page_title_img = "";
	}
	
   if ( is_page() && get_post_meta($post->ID, 'progression_studios_header_image', true ) ) {
      $progression_studios_custom_page_title_img = "body #page-title-pro {background-image:url('" . esc_url( get_post_meta($post->ID, 'progression_studios_header_image', true)) . "'); }";
	}	else {
		$progression_studios_custom_page_title_img = "";
	}
   if ( class_exists('Woocommerce') ) {
		global $woocommerce;
		if ( is_shop() || is_singular( 'product')  || is_tax( 'product_cat')  || is_tax( 'product_tag') ) {
			$your_shop_page = get_post( wc_get_page_id( 'shop' ) );
			if ( get_post_meta($your_shop_page->ID, 'progression_studios_header_image', true ) ) {
				$progression_studios_woo_page_title = "body #page-title-pro {background-image:url('" .  esc_url( get_post_meta($your_shop_page->ID, 'progression_studios_header_image', true) ). "'); }";
			} else {
		$progression_studios_woo_page_title = "";
		}
		} else {
		$progression_studios_woo_page_title = "";
	}
	}	else {
		$progression_studios_woo_page_title = "";
	}
   if ( get_option( 'page_for_posts' ) ) {
		$cover_page = get_page( get_option( 'page_for_posts' ));
		 if ( is_home() && get_post_meta($cover_page->ID, 'progression_studios_header_image', true) || is_singular( 'post') && get_post_meta($cover_page->ID, 'progression_studios_header_image', true)|| is_category( ) && get_post_meta($cover_page->ID, 'progression_studios_header_image', true) ) {
			$progression_studios_blog_header_img = "body #page-title-pro {background-image:url('" .  esc_url( get_post_meta($cover_page->ID, 'progression_studios_header_image', true) ). "'); }";
		} else {
		$progression_studios_blog_header_img = ""; }
	}	else {
		$progression_studios_blog_header_img = "";
	}


   if ( get_theme_mod( 'progression_studios_top_header_border_bottom', 'rgba(255,255,255, 0.10)') ) {
      $progression_studios_top_header_border_bottom_option = "border-bottom:1px solid " . esc_attr( get_theme_mod('progression_studios_top_header_border_bottom', 'rgba(255,255,255, 0.10)') )  . ";";
	}	else {
		$progression_studios_top_header_border_bottom_option = "";
	}
	


	
   if ( get_theme_mod( 'progression_studios_shop_post_rating', 'false') == 'false'  ) {
      $progression_studios_shop_rating_index = "ul.products li.product .progression-studios-shop-index-content .star-rating {display:none;}	";
	}	else {
		$progression_studios_shop_rating_index = "";
	}
	
   if ( get_theme_mod( 'progression_studios_armember_input_styles', 'true') == 'true'  ) {
      $progression_studios_armember_form_styles = "
			.arm_setup_submit_btn_wrapper, .arm_setup_form_container {
			background:transparent !important;
			}
			body .arm_popup_member_form_103 .arm_form_heading_container,
			body .arm_form_103 .arm_form_heading_container,
			body .arm_form_103 .arm_form_heading_container .arm_form_field_label_wrapper_text,
			body .arm_popup_member_form_102 .arm_form_heading_container,
			body .arm_form_102 .arm_form_heading_container,
			body .arm_form_102 .arm_form_heading_container .arm_form_field_label_wrapper_text,
			body .arm_popup_member_form_101 .arm_form_heading_container,
			body .arm_form_101 .arm_form_heading_container,
			body .arm_form_101 .arm_form_heading_container .arm_form_field_label_wrapper_text{
				color: #313131;
				font-family: Montserrat, sans-serif, 'Trebuchet MS';
				font-size: 24px;
				font-weight: bold;font-style: normal;text-decoration: none;
			}

			body .arm_form_103 .arm_registration_link,
			body .arm_form_103 .arm_forgotpassword_link,
			body body .arm_form_102 .arm_registration_link,
			body .arm_form_102 .arm_forgotpassword_link,
			body .arm_form_101 .arm_registration_link,
			body .arm_form_101 .arm_forgotpassword_link{
				color: #919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 15px;
				font-weight: normal;font-style: normal;text-decoration: none;
			}


			body .arm_form_103 .arm_pass_strength_meter,
			body .arm_form_102 .arm_pass_strength_meter,
			body .arm_form_101 .arm_pass_strength_meter{
			    color: #919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
			}

			body .arm_form_103 .arm_registration_link a,
			body .arm_form_103 .arm_forgotpassword_link a{
				color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;
			}
			body .arm_form_102 .arm_registration_link a,
			body .arm_form_102 .arm_forgotpassword_link a,
			body .arm_form_101 .arm_registration_link a,
			body .arm_form_101 .arm_forgotpassword_link a{
				color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;
			}

			body .arm_form_101 .arm_form_field_container .arm_registration_link,
			body .arm_form_101 .arm_form_field_container.arm_registration_link,
			body .arm_form_101 .arm_registration_link{
			    margin: 0px 0px 0px 0px !important;
			}
			body .arm_form_101 .arm_form_field_container .arm_forgotpassword_link,
			body .arm_form_101 .arm_form_field_container.arm_forgotpassword_link,
			body .arm_form_101 .arm_forgotpassword_link{
			    margin: 0px 0px 0px 0px !important;                     
			}body .arm_form_101 .arm_form_field_container .arm_forgotpassword_link,
			body .arm_form_101 .arm_form_field_container.arm_forgotpassword_link,
			body .arm_form_101 .arm_forgotpassword_link{
			    z-index:2;
			}
			body .arm_form_101 .arm_close_account_message,
			body .arm_form_101 .arm_forgot_password_description {
				color: #919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 16px;
			}
			body .arm_form_101 .arm_form_field_container{
				margin-bottom: 15px !important;
			}
			body .arm_form_101 .arm_form_input_wrapper{
				max-width: 100%;
				width: 62%;
				width: 100%;
			}
			body .arm_form_message_container.arm_editor_form_fileds_container.arm_editor_form_fileds_wrapper,
			    body .arm_form_message_container1.arm_editor_form_fileds_container.arm_editor_form_fileds_wrapper {
			    border: none !important;
			} 



			body .arm_form_103 .arm_form_field_container .arm_registration_link,
			body .arm_form_103 .arm_form_field_container.arm_registration_link,
			body .arm_form_103 .arm_registration_link,
			body .arm_form_102 .arm_form_field_container .arm_registration_link,
			body .arm_form_102 .arm_form_field_container.arm_registration_link,
			body .arm_form_102 .arm_registration_link{
			    margin: 20px 0px 0px 0px !important;
			}

			body .arm_form_103 .arm_form_field_container .arm_forgotpassword_link,
			body .arm_form_103 .arm_form_field_container.arm_forgotpassword_link,
			body .arm_form_103 .arm_forgotpassword_link,
			body .arm_form_102 .arm_form_field_container .arm_forgotpassword_link,
			body .arm_form_102 .arm_form_field_container.arm_forgotpassword_link,
			body .arm_form_102 .arm_forgotpassword_link{
			    margin: -132px 0px 0px 315px !important;                     
			}

			body .arm_form_103 .arm_form_field_container .arm_forgotpassword_link,
			body .arm_form_103 .arm_form_field_container.arm_forgotpassword_link,
			body .arm_form_103 .arm_forgotpassword_link,
			body .arm_form_102 .arm_form_field_container .arm_forgotpassword_link,
			body .arm_form_102 .arm_form_field_container.arm_forgotpassword_link,
			body .arm_form_102 .arm_forgotpassword_link{
			    z-index:2;
			}

			body .arm_form_103 .arm_close_account_message,
			body .arm_form_103 .arm_forgot_password_description,
			body .arm_form_102 .arm_close_account_message,
			body .arm_form_102 .arm_forgot_password_description {
				color: #919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 16px;
			}


			body .arm_form_103 .arm_form_field_container,
			body .arm_form_102 .arm_form_field_container{
				margin-bottom: 15px !important;
			}

			body .arm_form_103 .arm_form_input_wrapper,
			body .arm_form_102 .arm_form_input_wrapper{
				max-width: 100%;
				width: 62%;
				width: 100%;
			}

			body .arm_form_message_container.arm_editor_form_fileds_container.arm_editor_form_fileds_wrapper,
			    body .arm_form_message_container1.arm_editor_form_fileds_container.arm_editor_form_fileds_wrapper,
			body .arm_form_message_container.arm_editor_form_fileds_container.arm_editor_form_fileds_wrapper,
			    .arm_form_message_container1.arm_editor_form_fileds_container.arm_editor_form_fileds_wrapper {
			    border: none !important;
			} 

			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_103,
			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_102{
				background:  #ffffff !important;
				background-repeat: no-repeat;
				background-position: top left;
			}
					

			body .arm_module_forms_container .arm_form_103,
			body .arm_member_form_container .arm_form_103, body .arm_editor_form_fileds_wrapper,
			body .arm_module_forms_container .arm_form_102,
			body .arm_member_form_container .arm_form_102, body .arm_editor_form_fileds_wrapper{
				background:  #ffffff;
				background-repeat: no-repeat;
				background-position: top left;
				border: 0px solid #dddddd;
				border-radius: " . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px;
				-webkit-border-radius: " . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px;
				-moz-border-radius: " . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px;
				-o-border-radius:" . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px;
			}

			body .arm_module_forms_container .arm_form_101,
			body .arm_member_form_container .arm_form_101, .arm_editor_form_fileds_wrapper{
				background:  #ffffff;
				background-repeat: no-repeat;
				background-position: top left;
				border: 0px solid #cccccc;
				border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-webkit-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-moz-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-o-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
			}

			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_103 .arm_module_forms_container .arm_form_103,
			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_103 .arm_member_form_container .arm_form_103,
			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_102 .arm_module_forms_container .arm_form_102,
			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_102 .arm_member_form_container .arm_form_102,
			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_101 .arm_module_forms_container .arm_form_101,
			body .popup_wrapper.arm_popup_wrapper.arm_popup_member_form.arm_popup_member_form_101 .arm_member_form_container .arm_form_101{
				background: none !important;
			}


			 body .arm_form_103 md-input-container.md-input-invalid.md-input-focused label,
			body .arm_form_103 md-input-container.md-default-theme:not(.md-input-invalid).md-input-focused label,
			 body .arm_form_103 md-input-container.md-default-theme.md-input-invalid.md-input-focused label,
			body .arm_form_103 md-input-container:not(.md-input-invalid).md-input-focused label,
			body .arm_form_103 .arm_form_field_label_text,
			body .arm_form_103 .arm_member_form_field_label .arm_form_field_label_text,
			                        body  .arm_form_103 .arm_member_form_field_description .arm_form_field_description_text,
			body .arm_form_103 .arm_form_label_wrapper .required_tag,
			body .arm_form_103 .arm_form_input_container label,
			body  .arm_form_103 md-input-container:not(.md-input-invalid) md-select .md-select-value.md-select-placeholder,
			body .arm_form_103 md-input-container:not(.md-input-invalid).md-input-has-value label,
			body .arm_form_102 md-input-container.md-input-invalid.md-input-focused label,
			body .arm_form_102 md-input-container.md-default-theme:not(.md-input-invalid).md-input-focused label,
			body .arm_form_102 md-input-container.md-default-theme.md-input-invalid.md-input-focused label,
			body .arm_form_102 md-input-container:not(.md-input-invalid).md-input-focused label,
			body .arm_form_102 .arm_form_field_label_text,
			body .arm_form_102 .arm_member_form_field_label .arm_form_field_label_text,
			body .arm_form_102 .arm_member_form_field_description .arm_form_field_description_text,
			body .arm_form_102 .arm_form_label_wrapper .required_tag,
			body .arm_form_102 .arm_form_input_container label,
			body .arm_form_102 md-input-container:not(.md-input-invalid) md-select .md-select-value.md-select-placeholder,
			body .arm_form_102 md-input-container:not(.md-input-invalid).md-input-has-value label,
			body  .arm_form_101 md-input-container.md-input-invalid.md-input-focused label,
			body .arm_form_101 md-input-container.md-default-theme:not(.md-input-invalid).md-input-focused label,
			body .arm_form_101 md-input-container.md-default-theme.md-input-invalid.md-input-focused label,
			body .arm_form_101 md-input-container:not(.md-input-invalid).md-input-focused label,
			body .arm_form_101 .arm_form_field_label_text,
			body .arm_form_101 .arm_member_form_field_label .arm_form_field_label_text,
			body .arm_form_101 .arm_member_form_field_description .arm_form_field_description_text,
			body .arm_form_101 .arm_form_label_wrapper .required_tag,
			body .arm_form_101 .arm_form_input_container label,
			body .arm_form_101 md-input-container:not(.md-input-invalid) md-select .md-select-value.md-select-placeholder,
			body .arm_form_101 md-input-container:not(.md-input-invalid).md-input-has-value label
			                         {
				color: #919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 15px;
				cursor: pointer;
				margin: 0px !important;
				line-height : 27px;
				font-weight: normal;font-style: normal;text-decoration: none;
			}

			body  .arm_form_103 .arm_member_form_field_description .arm_form_field_description_text,
			body .arm_form_102 .arm_member_form_field_description .arm_form_field_description_text,
			body .arm_form_101 .arm_member_form_field_description .arm_form_field_description_text
			    { 
					font-size: 15px; 
			        line-height: 15px; 
			}

			body md-select-menu.md-default-theme md-content md-option:not([disabled]):focus, body md-select-menu md-content md-option:not([disabled]):focus, body md-select-menu.md-default-theme md-content md-option:not([disabled]):hover, body md-select-menu md-content md-option:not([disabled]):hover,
			body md-select-menu.md-default-theme md-content md-option:not([disabled]):focus, body md-select-menu md-content md-option:not([disabled]):focus, body md-select-menu.md-default-theme md-content md-option:not([disabled]):hover, body md-select-menu md-content md-option:not([disabled]):hover,
			body md-select-menu.md-default-theme md-content md-option:not([disabled]):focus, body md-select-menu md-content md-option:not([disabled]):focus, body md-select-menu.md-default-theme md-content md-option:not([disabled]):hover, body md-select-menu md-content md-option:not([disabled]):hover {
			    background-color :" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " ;
			    color : " . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
			}

			body  .armSelectOption103,
			body .armSelectOption102,
			body .armSelectOption101{
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 15px;
				font-weight: normal;font-style: normal;text-decoration: none;
			}


			body .arm_form_102 .arm_form_input_container.arm_form_input_container_section,
			body .arm_form_101 .arm_form_input_container.arm_form_input_container_section{
				color: #919191;
			    font-family: Lato, sans-serif, 'Trebuchet MS';
			}

			body .arm_form_103 .arm_form_input_container.arm_form_input_container_section,
			body .arm_form_102 md-radio-button, .arm_form_102 md-checkbox,
			body .arm_form_101 md-radio-button, .arm_form_101 md-checkbox{
				color:#919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 15px;
				cursor: pointer;
				font-weight: normal;font-style: normal;text-decoration: none;
			}
			body .arm_form_103 md-radio-button, body .arm_form_103 md-checkbox{
				color:#919191;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 15px;
				cursor: pointer;
				font-weight: normal;font-style: normal;text-decoration: none;
			}

			body md-select-menu.md-default-theme md-option.armSelectOption103[selected],
			body md-select-menu md-option.armSelectOption103[selected],
			body md-select-menu.md-default-theme md-option.armSelectOption102[selected],
			body md-select-menu md-option.armSelectOption102[selected],
			body md-select-menu.md-default-theme md-option.armSelectOption101[selected],
			body md-select-menu md-option.armSelectOption101[selected]{
				font-weight: bold;
				color:#242424;
			}

			body  .arm_form_103 .arm_form_input_container input,
			body .arm_form_102 .arm_apply_coupon_container .arm_coupon_submit_wrapper .arm_apply_coupon_btn,
			body .arm_form_102 .arm_form_input_container input,
			body .arm_form_101 .arm_form_input_container input{
			    height: 36px;
			}

			body  .arm_form_103 .arm_apply_coupon_container .arm_coupon_submit_wrapper .arm_apply_coupon_btn,
			body .arm_form_101 .arm_apply_coupon_container .arm_coupon_submit_wrapper .arm_apply_coupon_btn{
			    min-height: 38px;
			    margin: 0;
			}



			body .arm_form_103 .arm_form_input_container input,
			body .arm_form_103 .arm_form_input_container textarea,
			body .arm_form_103 .arm_form_input_container select,
			body .arm_form_103 .arm_form_input_container md-select md-select-value,
			body .arm_form_102 .arm_form_input_container input,
			body .arm_form_102 .arm_form_input_container textarea,
			body .arm_form_102 .arm_form_input_container select,
			body .arm_form_102 .arm_form_input_container md-select md-select-value,
			body .arm_form_101 .arm_form_input_container input,
			body .arm_form_101 .arm_form_input_container textarea,
			body .arm_form_101 .arm_form_input_container select,
			body .arm_form_101 .arm_form_input_container md-select md-select-value{
			    background-color: " . esc_attr( get_theme_mod('progression_studios_input_background', '#ffffff') ) . " !important;
				border: 1px solid " . esc_attr( get_theme_mod('progression_studios_input_border', '#dddddd') ) . ";
				border-color: " . esc_attr( get_theme_mod('progression_studios_input_border', '#dddddd') ) . ";
				border-radius: " . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px !important;
				-webkit-border-radius: " . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px !important;
				-moz-border-radius:" . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px !important;
				-o-border-radius: " . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px !important;
				color:#242424;
				font-family: Lato, sans-serif, 'Trebuchet MS';
				font-size: 15px;
				font-weight: normal;font-style: normal;text-decoration: none;
				height: 36px;
			}




			body .arm_form_103 .armFileUploadWrapper .armFileDragArea,
			body .arm_form_102 .armFileUploadWrapper .armFileDragArea,
			body .arm_form_101 .armFileUploadWrapper .armFileDragArea{
				border-color: #dddddd;
			}

			body .arm_form_103 .armFileUploadWrapper .armFileDragArea.arm_dragover,
			body .arm_form_102 .armFileUploadWrapper .armFileDragArea.arm_dragover,
			body .arm_form_101 .armFileUploadWrapper .armFileDragArea.arm_dragover{
				border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
			}

			body .arm_form_103 md-checkbox.md-default-theme.md-checked .md-ink-ripple,
			body .arm_form_103 md-checkbox.md-checked .md-ink-ripple,
			body .arm_form_102 md-checkbox.md-default-theme.md-checked .md-ink-ripple,
			body .arm_form_102 md-checkbox.md-checked .md-ink-ripple,
			body .arm_form_101 md-checkbox.md-default-theme.md-checked .md-ink-ripple,
			body .arm_form_101 md-checkbox.md-checked .md-ink-ripple{
				color: rgba(199, 199, 199, 0.87);
			}

			body .arm_form_103 md-radio-button.md-default-theme.md-checked .md-off,
			body .arm_form_103 md-radio-button.md-default-theme .md-off,
			body .arm_form_103 md-radio-button.md-checked .md-off,
			body .arm_form_103 md-radio-button .md-off,
			body .arm_form_103 md-checkbox.md-default-theme .md-icon, 
			body .arm_form_103 md-checkbox .md-icon,
			body .arm_form_102 md-radio-button.md-default-theme.md-checked .md-off,
			body .arm_form_102 md-radio-button.md-default-theme .md-off,
			body .arm_form_102 md-radio-button.md-checked .md-off,
			body .arm_form_102 md-radio-button .md-off,
			body .arm_form_102 md-checkbox.md-default-theme .md-icon, 
			body .arm_form_102 md-checkbox .md-icon,
			body .arm_form_101 md-radio-button.md-default-theme.md-checked .md-off,
			body .arm_form_101 md-radio-button.md-default-theme .md-off,
			body .arm_form_101 md-radio-button.md-checked .md-off,
			body .arm_form_101 md-radio-button .md-off,
			body .arm_form_101 md-checkbox.md-default-theme .md-icon, 
			body .arm_form_101 md-checkbox .md-icon{
				border-color: #dddddd;
			}

			body .arm_form_103 md-radio-button.md-default-theme .md-on,
			body .arm_form_103 md-radio-button .md-on,
			body .arm_form_103 md-checkbox.md-default-theme.md-checked .md-icon,
			body .arm_form_103 md-checkbox.md-checked .md-icon,
			body .arm_form_102 md-radio-button.md-default-theme .md-on,
			body .arm_form_102 md-radio-button .md-on,
			body .arm_form_102 md-checkbox.md-default-theme.md-checked .md-icon,
			body .arm_form_102 md-checkbox.md-checked .md-icon,
			body .arm_form_101 md-radio-button.md-default-theme .md-on,
			body .arm_form_101 md-radio-button .md-on,
			body .arm_form_101 md-checkbox.md-default-theme.md-checked .md-icon,
			body .arm_form_101 md-checkbox.md-checked .md-icon{
				background-color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
			}

			body md-option.armSelectOption103 .md-ripple.md-ripple-placed,
			body md-option.armSelectOption103 .md-ripple.md-ripple-scaled,
			body .arm_form_103 .md-ripple.md-ripple-placed,
			body .arm_form_103 .md-ripple.md-ripple-scaled,
			body md-option.armSelectOption102 .md-ripple.md-ripple-placed,
			body md-option.armSelectOption102 .md-ripple.md-ripple-scaled,
			body .arm_form_102 .md-ripple.md-ripple-placed,
			body .arm_form_102 .md-ripple.md-ripple-scaled
			body md-option.armSelectOption101 .md-ripple.md-ripple-placed,
			body md-option.armSelectOption101 .md-ripple.md-ripple-scaled,
			body .arm_form_101 .md-ripple.md-ripple-placed,
			body .arm_form_101 .md-ripple.md-ripple-scaled{
				background-color: rgba(67, 175, 67, 0.87) !important;
			}

			body body .arm_form_103 .md-button .md-ripple.md-ripple-placed,
			body .arm_form_103 .md-button .md-ripple.md-ripple-scaled,
			body .arm_form_102 .md-button .md-ripple.md-ripple-placed,
			body .arm_form_102 .md-button .md-ripple.md-ripple-scaled,
			body .arm_form_101 .md-button .md-ripple.md-ripple-placed,
			body .arm_form_101 .md-button .md-ripple.md-ripple-scaled{
				background-color: rgb(255, 255, 255) !important;
			}

			body .arm_form_103 md-checkbox.md-focused:not([disabled]):not(.md-checked) .md-container:before,
			body .arm_form_102 md-checkbox.md-focused:not([disabled]):not(.md-checked) .md-container:before,
			body .arm_form_101 md-checkbox.md-focused:not([disabled]):not(.md-checked) .md-container:before{
				background-color: rgba(67, 175, 67, 0.12) !important;
			}

			body .arm_form_103 md-radio-group.md-default-theme.md-focused:not(:empty) .md-checked .md-container:before,
			body .arm_form_103 md-radio-group.md-focused:not(:empty) .md-checked .md-container:before,
			body .arm_form_103 md-checkbox.md-default-theme.md-checked.md-focused .md-container:before,
			body body .arm_form_103 md-checkbox.md-checked.md-focused .md-container:before,
			body .arm_form_102 md-radio-group.md-default-theme.md-focused:not(:empty) .md-checked .md-container:before,
			body .arm_form_102 md-radio-group.md-focused:not(:empty) .md-checked .md-container:before,
			body .arm_form_102 md-checkbox.md-default-theme.md-checked.md-focused .md-container:before,
			body .arm_form_102 md-checkbox.md-checked.md-focused .md-container:before,
			body .arm_form_101 md-radio-group.md-default-theme.md-focused:not(:empty) .md-checked .md-container:before,
			body .arm_form_101 md-radio-group.md-focused:not(:empty) .md-checked .md-container:before,
			body .arm_form_101 md-checkbox.md-default-theme.md-checked.md-focused .md-container:before,
			body .arm_form_101 md-checkbox.md-checked.md-focused .md-container:before{
				background-color: rgba(67, 175, 67, 0.26) !important;
			}

			body .arm_form_103.arm_form_layout_writer .arm_form_wrapper_container .select-wrapper input.select-dropdown,
			body .arm_form_103.arm_form_layout_writer .arm_form_wrapper_container .file-field input.file-path,
			body .arm_form_102.arm_form_layout_writer .arm_form_wrapper_container .select-wrapper input.select-dropdown,
			body .arm_form_102.arm_form_layout_writer .arm_form_wrapper_container .file-field input.file-path,
			body .arm_form_101.arm_form_layout_writer .arm_form_wrapper_container .select-wrapper input.select-dropdown,
			body .arm_form_101.arm_form_layout_writer .arm_form_wrapper_container .file-field input.file-path{
				border-color: #dddddd;
				border-width: 0 0 1px 0 !important;
			}



			body .arm_form_103 .arm_form_message_container .arm_success_msg,
			body .arm_form_103 .arm_form_message_container .arm_error_msg,
			                        body body .arm_form_103 .arm_form_message_container1 .arm_success_msg,
			                        body .arm_form_103 .arm_form_message_container1 .arm_success_msg1,
			body .arm_form_103 .arm_form_message_container1 .arm_error_msg,
			                            body .arm_form_103 .arm_form_message_container .arm_success_msg a,
			body .arm_form_102 .arm_form_message_container .arm_success_msg,
			body .arm_form_102 .arm_form_message_container .arm_error_msg,
			                        body .arm_form_102 .arm_form_message_container1 .arm_success_msg,
			                        body .arm_form_102 .arm_form_message_container1 .arm_success_msg1,
			body .arm_form_102 .arm_form_message_container1 .arm_error_msg,
			                            body .arm_form_102 .arm_form_message_container .arm_success_msg a,
			body .arm_form_101 .arm_form_message_container .arm_success_msg,
			body .arm_form_101 .arm_form_message_container .arm_error_msg,
			                        body .arm_form_101 .arm_form_message_container1 .arm_success_msg,
			                       body  .arm_form_101 .arm_form_message_container1 .arm_success_msg1,
			body .arm_form_101 .arm_form_message_container1 .arm_error_msg,
			                            body .arm_form_101 .arm_form_message_container .arm_success_msg a{
				font-family: Lato, sans-serif, 'Trebuchet MS';
			    text-decoration: none !important;
			}


			body .arm_form_103 .arm_coupon_field_wrapper .success.notify_msg,
			body .arm_form_102 .arm_coupon_field_wrapper .success.notify_msg,
			body .arm_form_101 .arm_coupon_field_wrapper .success.notify_msg{
			    font-family: Lato, sans-serif,'Trebuchet asf';
			    text-decoration: none !important;
			}

			body .arm_form_103 md-select.md-default-theme.ng-invalid.ng-dirty .md-select-value,
			body .arm_form_103 md-select.ng-invalid.ng-dirty .md-select-value,
			body .arm_form_102 md-select.md-default-theme.ng-invalid.ng-dirty .md-select-value,
			body .arm_form_102 md-select.ng-invalid.ng-dirty .md-select-value,
			body .arm_form_101 md-select.md-default-theme.ng-invalid.ng-dirty .md-select-value,
			body .arm_form_101 md-select.ng-invalid.ng-dirty .md-select-value{
				color: #242424 !important;
				border-color: #f05050 !important;
			}

			body .arm_form_103 .arm_uploaded_file_info .armbar,
			body .arm_form_102 .arm_uploaded_file_info .armbar,
			body .arm_form_101 .arm_uploaded_file_info .armbar{
				background-color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
			}

			body .arm_form_103 .arm_form_input_container input:focus,
			body .arm_form_103 .arm_form_input_container textarea:focus,
			body .arm_form_103 .arm_form_input_container select:focus,
			body .arm_form_103 .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_103 .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_102 .arm_form_input_container input:focus,
			body .arm_form_102 .arm_form_input_container textarea:focus,
			body .arm_form_102 .arm_form_input_container select:focus,
			body .arm_form_102 .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_102 .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_101 .arm_form_input_container input:focus,
			body .arm_form_101 .arm_form_input_container textarea:focus,
			body .arm_form_101 .arm_form_input_container select:focus,
			body .arm_form_101 .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_101 .arm_form_input_container md-select[aria-expanded='true'] + md-select-value{
			    color: #242424;
				border: 1px solid " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
				border-color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
			}

			body .arm_form_103 .arm_form_input_box.arm_error_msg,
			body .arm_form_103 .arm_form_input_box.arm_invalid,
			body .arm_form_103 .arm_form_input_box.ng-invalid:not(.ng-untouched) md-select-value,
			body .arm_form_103 md-input-container .md-input.ng-invalid:not(.ng-untouched),
			body .arm_form_102 .arm_form_input_box.arm_error_msg,
			body .arm_form_102 .arm_form_input_box.arm_invalid,
			body .arm_form_102 .arm_form_input_box.ng-invalid:not(.ng-untouched) md-select-value,
			body .arm_form_102 md-input-container .md-input.ng-invalid:not(.ng-untouched),
			body .arm_form_101 .arm_form_input_box.arm_error_msg,
			body .arm_form_101 .arm_form_input_box.arm_invalid,
			body .arm_form_101 .arm_form_input_box.ng-invalid:not(.ng-untouched) md-select-value,
			body .arm_form_101 md-input-container .md-input.ng-invalid:not(.ng-untouched){
				border: 1px solid #f05050;
				border-color: #f05050 !important;
			}

			body .arm_form_103.arm_form_layout_writer .arm_form_input_container textarea,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container textarea,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container textarea{
			    -webkit-transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
			    -moz-transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
				transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
				background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 99.1%, #c7c7c7 4%);
				background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 99.1%, #c7c7c7 4%);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 0 100%;
				max-height:150px;
			}

			body .arm_form_103.arm_form_layout_writer .arm_form_input_container input,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container select,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container md-select md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container input,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container select,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container md-select md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container input,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container select,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container md-select md-select-value{
				-webkit-transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
				transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
				background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 96%, #c7c7c7 4%);
				background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, #c7c7c7 4%);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 0 100%;
			}

			body .arm_form_103.arm_form_layout_writer .arm_form_input_container input:focus,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container select:focus,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container input:focus,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container select:focus,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container input:focus,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container select:focus,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container md-select[aria-expanded='true'] + md-select-value{
				background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 96%, " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " 4%);
				background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " 4%);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 100% 100%;
			}

			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_box.arm_error_msg,
			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_box.arm_invalid,
			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_box.ng-invalid:not(.ng-untouched) md-select-value,
			body .arm_form_103 .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched),
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_box.arm_error_msg,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_box.arm_invalid,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_box.ng-invalid:not(.ng-untouched) md-select-value,
			body .arm_form_102 .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched),
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_box.arm_error_msg,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_box.arm_invalid,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_box.ng-invalid:not(.ng-untouched) md-select-value,
			body .arm_form_101 .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched){
				border: 1px solid #dddddd;
				border-color: #dddddd !important;
			}

			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_container input:focus,
			body .arm_form_103 .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_container textarea:focus,
			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_container select:focus,
			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_103 .arm_editor_form_fileds_container .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_container input:focus,
			body .arm_form_102 .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_container textarea:focus,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_container select:focus,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_102 .arm_editor_form_fileds_container .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_container input:focus,
			body .arm_form_101 .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_container textarea:focus,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_container select:focus,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_101 .arm_editor_form_fileds_container .arm_form_input_container md-select[aria-expanded='true'] + md-select-value{
				border: 1px solid " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
				border-color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;
			}

			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.arm_error_msg:focus,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.arm_invalid:focus,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container input:focus,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container select:focus,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_103.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.arm_error_msg:focus,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.arm_invalid:focus,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container input:focus,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container select:focus,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container md-select[aria-expanded='true'] + md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.arm_error_msg:focus,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.arm_invalid:focus,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container input:focus,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container select:focus,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container md-select:focus md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_editor_form_fileds_container .arm_form_input_container md-select[aria-expanded='true'] + md-select-value{
			    background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 96%, " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " 4%);
				background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " 4%);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 100% 100%;
			    border-color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;
			}

			body .arm_form_103.arm_form_layout_writer textarea.arm_form_input_box.arm_error_msg:focus,
			body .arm_form_103.arm_form_layout_writer textarea.arm_form_input_box.arm_invalid:focus,
			body .arm_form_103.arm_form_layout_writer textarea.arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container_textarea md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_container textarea:focus,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container textarea:focus,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container textarea:focus{
			    background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 99.1%, " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " 4%);
				background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 99.1%, " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " 4%);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 100% 100%;
			}

			body .arm_form_103.arm_form_layout_writer .arm_form_input_box.arm_error_msg:focus,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_box.arm_invalid:focus,
			body .arm_form_103.arm_form_layout_writer .arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_103.arm_form_layout_writer md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_102.arm_form_layout_writer textarea.arm_form_input_box.arm_error_msg:focus,
			body .arm_form_102.arm_form_layout_writer textarea.arm_form_input_box.arm_invalid:focus,
			body .arm_form_102.arm_form_layout_writer textarea.arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_container_textarea md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_101.arm_form_layout_writer textarea.arm_form_input_box.arm_error_msg:focus,
			body .arm_form_101.arm_form_layout_writer textarea.arm_form_input_box.arm_invalid:focus,
			body .arm_form_101.arm_form_layout_writer textarea.arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_container_textarea md-input-container .md-input.ng-invalid:not(.ng-untouched):focus{
			    background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 99.1%, #f05050 4%);
			    background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 99.1%, #f05050 4%);
			    background-repeat: no-repeat;
			    background-position: 0 0;
			    background-size: 100% 100%;
			}

			body .arm_form_102.arm_form_layout_writer .arm_form_input_box.arm_error_msg:focus,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_box.arm_invalid:focus,
			body .arm_form_102.arm_form_layout_writer .arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_102.arm_form_layout_writer md-input-container .md-input.ng-invalid:not(.ng-untouched):focus,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_box.arm_error_msg:focus,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_box.arm_invalid:focus,
			body .arm_form_101.arm_form_layout_writer .arm_form_input_box.ng-invalid:not(.ng-untouched):focus md-select-value,
			body .arm_form_101.arm_form_layout_writer md-input-container .md-input.ng-invalid:not(.ng-untouched):focus{
				background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 96%, #f05050 4%);
				background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, #f05050 4%);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 100% 100%;
			}

			body .arm_form_103.arm_form_layout_iconic .arm_error_msg_box .arm_error_msg,
			body .arm_form_103.arm_form_layout_rounded .arm_error_msg_box .arm_error_msg,
			body .arm_form_103 .arm_error_msg_box .arm_error_msg,
			body .arm_form_102.arm_form_layout_iconic .arm_error_msg_box .arm_error_msg,
			body .arm_form_102.arm_form_layout_rounded .arm_error_msg_box .arm_error_msg,
			body .arm_form_102 .arm_error_msg_box .arm_error_msg,
			body .arm_form_101.arm_form_layout_iconic .arm_error_msg_box .arm_error_msg,
			body .arm_form_101.arm_form_layout_rounded .arm_error_msg_box .arm_error_msg,
			body .arm_form_101 .arm_error_msg_box .arm_error_msg{
				color: #ffffff;
				background: #e6594d;
			    font-family: Lato, sans-serif, 'Trebuchet MS';
			    font-size: 15px;
				padding-left: 5px;
				padding-right: 5px;
			    text-decoration: none !important;
			}

			body .arm_form_103 .arm_msg_pos_right .arm_error_msg_box .arm_error_box_arrow:after{border-right-color: #e6594d !important;} 
			body .arm_form_103 .arm_msg_pos_left .arm_error_msg_box .arm_error_box_arrow:after{border-left-color: #e6594d !important;}
			body .arm_form_103 .arm_msg_pos_top .arm_error_msg_box .arm_error_box_arrow:after{border-top-color: #e6594d !important;}
			body .arm_form_103 .arm_msg_pos_bottom .arm_error_msg_box .arm_error_box_arrow:after{border-bottom-color: #e6594d !important;}
			body .arm_form_103 .arm_writer_error_msg_box{
				color: #ffffff;
				font-size: 15px;
				font-size: " . esc_attr( get_theme_mod('progression_studios_button_font_size', '13') + 1 ) . "px;
			}

			body .arm_form_102 .arm_msg_pos_right .arm_error_msg_box .arm_error_box_arrow:after{border-right-color: #e6594d !important;} 
			body .arm_form_102 .arm_msg_pos_left .arm_error_msg_box .arm_error_box_arrow:after{border-left-color: #e6594d !important;}
			body .arm_form_102 .arm_msg_pos_top .arm_error_msg_box .arm_error_box_arrow:after{border-top-color: #e6594d !important;}
			body .arm_form_102 .arm_msg_pos_bottom .arm_error_msg_box .arm_error_box_arrow:after{border-bottom-color: #e6594d !important;}
			body .arm_form_102 .arm_writer_error_msg_box,
			body .arm_form_101 .arm_msg_pos_right .arm_error_msg_box .arm_error_box_arrow:after{border-right-color: #e6594d !important;} 
			body .arm_form_101 .arm_msg_pos_left .arm_error_msg_box .arm_error_box_arrow:after{border-left-color: #e6594d !important;}
			body .arm_form_101 .arm_msg_pos_top .arm_error_msg_box .arm_error_box_arrow:after{border-top-color: #e6594d !important;}
			body .arm_form_101 .arm_msg_pos_bottom .arm_error_msg_box .arm_error_box_arrow:after{border-bottom-color: #e6594d !important;}
			body .arm_form_101 .arm_writer_error_msg_box{
				color: #ffffff;
				font-size: " . esc_attr( get_theme_mod('progression_studios_button_font_size', '13') + 1 ) . "px;
			}

			body .arm_form_103 .arm_form_field_submit_button.md-button .md-ripple-container,
			body .arm_form_102 .arm_form_field_submit_button.md-button .md-ripple-container,
			body .arm_form_101 .arm_form_field_submit_button.md-button .md-ripple-container{
				border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-webkit-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-moz-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-o-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
			}

			/* Button */
			body .arm_form_103 .arm_form_field_submit_button.md-button,
			body .arm_form_103 .arm_form_field_submit_button,
			body .arm_form_102 .arm_form_field_submit_button.md-button,
			body .arm_form_102 .arm_form_field_submit_button,
			body .arm_form_101 .arm_form_field_submit_button.md-button,
			body .arm_form_101 .arm_form_field_submit_button {
				border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-webkit-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-moz-border-radius:" . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				-o-border-radius: " . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
				width: auto;
				max-width: 100%;
				width: 250px;
				min-height: 35px;
				min-height: 45px;
				padding: 0 10px;
				font-family: Montserrat, sans-serif, 'Trebuchet MS';
				font-size: " . esc_attr( get_theme_mod('progression_studios_button_font_size', '13') + 1 ) . "px;
				margin: 10px 0px 0px 0px;
				font-weight: normal;font-style: normal;text-decoration: none;
				text-transform: none;
			    background: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;border:none !important;color: " . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . " !important;
			}

			body .arm_form_field_submit_button.arm_form_field_container_button.arm_editable_input_button,
			body .arm_form_field_submit_button.arm_form_field_container_button.arm_editable_input_button,
			body .arm_form_field_submit_button.arm_form_field_container_button.arm_editable_input_button {
			    height: 45px;
			}

			body .arm_form_103 .arm_setup_submit_btn_wrapper .arm_form_field_submit_button.md-button,
			body .arm_form_103 .arm_setup_submit_btn_wrapper .arm_form_field_submit_button,
			body .arm_form_102 .arm_setup_submit_btn_wrapper .arm_form_field_submit_button.md-button,
			body .arm_form_102 .arm_setup_submit_btn_wrapper .arm_form_field_submit_button,
			body .arm_form_101 .arm_setup_submit_btn_wrapper .arm_form_field_submit_button.md-button,
			body .arm_form_101 .arm_setup_submit_btn_wrapper .arm_form_field_submit_button {
			    background: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;border: none !important; color: " . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . " !important;
			}

			body .arm_form_103 .arm_form_field_submit_button.md-button #arm_form_loader,
			body .arm_form_103 .arm_form_field_submit_button #arm_form_loader,
			body .arm_form_102 .arm_form_field_submit_button.md-button #arm_form_loader,
			body .arm_form_102 .arm_form_field_submit_button #arm_form_loader,
			body .arm_form_101 .arm_form_field_submit_button.md-button #arm_form_loader,
			body .arm_form_101 .arm_form_field_submit_button #arm_form_loader {
			    fill:#ffffff;
			}

			/*.arm_form_101 button:hover,*/
			body .arm_form_103 .arm_form_field_submit_button:hover,
			body .arm_form_103 .arm_form_field_submit_button.md-button:hover,
			body .arm_form_103 .arm_form_field_submit_button.md-button:not([disabled]):hover,
			body .arm_form_103 .arm_form_field_submit_button.md-button.md-default-theme:not([disabled]):hover,
			body .arm_form_103.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn:hover,
			body .arm_form_103.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn-large:hover,
			body .arm_form_102 .arm_form_field_submit_button:hover,
			body .arm_form_102 .arm_form_field_submit_button.md-button:hover,
			body .arm_form_102 .arm_form_field_submit_button.md-button:not([disabled]):hover,
			body .arm_form_102 .arm_form_field_submit_button.md-button.md-default-theme:not([disabled]):hover,
			body .arm_form_102.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn:hover,
			body .arm_form_102.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn-large:hover,
			body .arm_form_101 .arm_form_field_submit_button:hover,
			body .arm_form_101 .arm_form_field_submit_button.md-button:hover,
			body .arm_form_101 .arm_form_field_submit_button.md-button:not([disabled]):hover,
			body .arm_form_101 .arm_form_field_submit_button.md-button.md-default-theme:not([disabled]):hover,
			body .arm_form_101.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn:hover,
			body .arm_form_101.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn-large:hover{
				background-color: " . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . " !important; border: 1px solid " . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . " !important;color: " . esc_attr( get_theme_mod('progression_studios_button_font_hover', '#ffffff') ) . " !important;
			}

			body .arm_form_103 .arm_form_field_submit_button:hover #arm_form_loader,
			body .arm_form_103 .arm_form_field_submit_button.md-button:hover #arm_form_loader,
			body .arm_form_103 .arm_form_field_submit_button.md-button:not([disabled]):hover #arm_form_loader,
			body .arm_form_103 .arm_form_field_submit_button.md-button.md-default-theme:not([disabled]):hover #arm_form_loader,
			body .arm_form_103.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn:hover #arm_form_loader,
			body .arm_form_103.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn-large:hover #arm_form_loader,
			body .arm_form_102 .arm_form_field_submit_button:hover #arm_form_loader,
			body .arm_form_102 .arm_form_field_submit_button.md-button:hover #arm_form_loader,
			body .arm_form_102 .arm_form_field_submit_button.md-button:not([disabled]):hover #arm_form_loader,
			body .arm_form_102 .arm_form_field_submit_button.md-button.md-default-theme:not([disabled]):hover #arm_form_loader,
			body .arm_form_102.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn:hover #arm_form_loader,
			body .arm_form_102.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn-large:hover #arm_form_loader,
			body .arm_form_101 .arm_form_field_submit_button:hover #arm_form_loader,
			body .arm_form_101 .arm_form_field_submit_button.md-button:hover #arm_form_loader,
			body .arm_form_101 .arm_form_field_submit_button.md-button:not([disabled]):hover #arm_form_loader,
			body .arm_form_101 .arm_form_field_submit_button.md-button.md-default-theme:not([disabled]):hover #arm_form_loader,
			body .arm_form_101.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn:hover #arm_form_loader,
			body .arm_form_101.arm_form_layout_writer .arm_form_wrapper_container .arm_form_field_submit_button.btn-large:hover #arm_form_loader{
			    fill:#ffffff;
			}

			body .arm_form_103 .arm_form_wrapper_container .armFileUploadWrapper .armFileBtn,
			body .arm_form_103 .arm_form_wrapper_container .armFileUploadContainer,
			body .arm_form_102 .arm_form_wrapper_container .armFileUploadWrapper .armFileBtn,
			body .arm_form_102 .arm_form_wrapper_container .armFileUploadContainer,
			body .arm_form_101 .arm_form_wrapper_container .armFileUploadWrapper .armFileBtn,
			body .arm_form_101 .arm_form_wrapper_container .armFileUploadContainer{
				border: 1px solid " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
				background-color: " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
				color: " . esc_attr( get_theme_mod('progression_studios_button_font_hover', '#ffffff') ) . ";
			}


			body .arm_form_103 .arm_form_wrapper_container .armFileUploadWrapper .armFileBtn:hover,
			body .arm_form_103 .arm_form_wrapper_container .armFileUploadContainer:hover,
			body .arm_form_102 .arm_form_wrapper_container .armFileUploadWrapper .armFileBtn:hover,
			body .arm_form_102 .arm_form_wrapper_container .armFileUploadContainer:hover,
			body .arm_form_101 .arm_form_wrapper_container .armFileUploadWrapper .armFileBtn:hover,
			body .arm_form_101 .arm_form_wrapper_container .armFileUploadContainer:hover{
			    background-color: " . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . " !important;
				border-color: " . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . " !important;
				color: " . esc_attr( get_theme_mod('progression_studios_button_font_hover', '#ffffff') ) . " !important;
			}

			body .arm_form_102 .arm_field_fa_icons,
			body .arm_form_101 .arm_field_fa_icons{color: #bababa;}

			body .arm_form_103 .arm_field_fa_icons,
			body .arm_form_102 stop.arm_social_connect_svg,
			body .arm_form_101 stop.arm_social_connect_svg { stop-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . "; }
	
		";
	}	else {
		$progression_studios_armember_form_styles = "";
	}
	
 if ( get_theme_mod( 'progression_studios_site_boxed') == 'boxed-pro' ) {
	 $progression_studios_boxed_layout = "
	 	@media only screen and (min-width: 959px) {
		
		#boxed-layout-pro.progression-studios-preloader {margin-top:90px;}
		#boxed-layout-pro.progression-studios-preloader.progression-preloader-completed {animation-name: ProMoveUpPageLoaderBoxed; animation-delay:200ms;}
 	 	#boxed-layout-pro { margin-top:50px; margin-bottom:50px;}
	 	}
		#boxed-layout-pro #content-pro {
			overflow:hidden;
		}
	 	#boxed-layout-pro {
	 		position:relative;
	 		width:". esc_attr( get_theme_mod('progression_studios_site_width', '1200') ) . "px;
	 		margin-left:auto; margin-right:auto; 
	 		background-color:". esc_attr( get_theme_mod('progression_studios_boxed_background_color', '#ffffff') ) . ";
	 		box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.15);
	 	}
 	#boxed-layout-pro .width-container-pro { width:90%; }
 	
 	@media only screen and (min-width: 960px) and (max-width: ". esc_attr( get_theme_mod('progression_studios_site_width', '1200') + 100 ) . "px) {
		body #boxed-layout-pro{width:92%;}
	}
	
	";
 }	else {
		$progression_studios_boxed_layout = "";
	}

	$progression_studios_custom_css = "
	$progression_studios_custom_page_title_img
	$progression_studios_woo_page_title
	$progression_studios_custom_tax_page_title_img
	$progression_studios_blog_header_img
	#video-logo-background a {
		background:" .  esc_attr( get_theme_mod('progression_studios_logo_bg_color', 'rgba(255,255,255,  0)') ) . ";
		width:" .  esc_attr( get_theme_mod('progression_studios_theme_logo_container_width_dashboard', '160') ) . "px;
		text-align:" .  esc_attr( get_theme_mod('progression_studios_logo_position_dashboard', 'center') ) . ";
	}
	#video-logo-background:before {
		left:" .  esc_attr( get_theme_mod('progression_studios_theme_logo_container_width_dashboard', '160') ) . "px;
	}
	#video-logo-background:before {
		background:" .  esc_attr( get_theme_mod('progression_studios_logo_border_right', 'rgba(0, 0, 0, 0.04)') ) . ";
	}
	#video-logo-background img {
		width:" .  esc_attr( get_theme_mod('progression_studios_theme_logo_width_dashboard', '95') ) . "px;
		text-align:" .  esc_attr( get_theme_mod('progression_studios_logo_position_dashboard', 'center') ) . ";
	}
	#video-search-header {
		height:" .  esc_attr( get_theme_mod('progression_studios_header_dash_height', '90') ) . "px;
		line-height:" .  esc_attr( get_theme_mod('progression_studios_header_dash_height', '90') ) . "px;
	}
	span.user-notification-count {
		top:" .  esc_attr( ( get_theme_mod('progression_studios_header_dash_height', '90') / 2 ) - 16) . "px;
	}
	#header-user-notification-click {
		padding-top:" .  esc_attr( ( get_theme_mod('progression_studios_header_dash_height', '90') / 2 ) - 25) . "px;
		padding-bottom:" .  esc_attr( ( get_theme_mod('progression_studios_header_dash_height', '90') / 2 ) - 25) . "px;
	}
	#header-user-profile-click {
		padding-top:" .  esc_attr( ( get_theme_mod('progression_studios_header_dash_height', '90') / 2 ) - 20) . "px;
		padding-bottom:" .  esc_attr( ( get_theme_mod('progression_studios_header_dash_height', '90') / 2 ) - 20) . "px;
	}
	header#videohead-pro {
		height:" .  esc_attr( get_theme_mod('progression_studios_header_dash_height', '90') ) . "px;
		position:" .  esc_attr( get_theme_mod('progression_studios_header_dash_sticky', 'fixed') ) . ";
		background-color:" .  esc_attr( get_theme_mod('progression_studios_header_dash_background', '#ffffff') ) . ";
		border-bottom:1px solid " .  esc_attr( get_theme_mod('progression_studios_header_dash_border_btm', 'rgba(0,0,0,0.08)') ) . ";
		$progression_studios_header_dash_bg_image
		$progression_studios_header_dash_bg_cover
	}
	#main-nav-mobile {border-top:1px solid " .  esc_attr( get_theme_mod('progression_studios_header_dash_border_btm', 'rgba(0,0,0,0.08)') ) . ";}
	#content-sidebar-pro, #col-main-with-sidebar, #progression-studios-sidebar-col-main, nav#sidebar-nav-pro {
		padding-top:" .  esc_attr( get_theme_mod('progression_studios_header_dash_height', '90') ) . "px;
	}
	#video-logo-background a {
		height:" .  esc_attr( get_theme_mod('progression_studios_header_dash_height', '90') ) . "px;
		line-height:" .  esc_attr( get_theme_mod('progression_studios_header_dash_height', '90') ) . "px;
	}
	#sidebar-nav-pro ul.sf-menu { letter-spacing:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_letterspacing', '0.02') ) . "em;}
	#sidebar-nav-pro ul.sf-menu li span.progression-megamenu-icon {
		font-size:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_icon_font_size', '40') ) . "px;
		margin-bottom:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_icon_margin_btm', '6') ) . "px;
	}
	#sidebar-nav-pro ul.sf-menu li a {
		font-size:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_font_size', '12') ) . "px;
	}
	nav#sidebar-nav-pro {
		position: " .  esc_attr( get_theme_mod('progression_studios_dash_sidebar_sticky', 'fixed') ) . ";
	}
	nav#sidebar-nav-pro, #sidebar-bg:before {
		width: " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160') ) . "px;
	}
	#video-search-header-filtering {
		width:calc(100vw - " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160') ) . "px);
	}
	#content-sidebar-pro:after,
	#sidebar-bg:after {
		left: " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160') ) . "px;
	}
	#content-sidebar-pro,
	#progression-studios-footer-page-builder.sidebar-dashboard-footer-spacing, #progression-studios-sidebar-col-main {
		margin-left: " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160') ) . "px;
	}
	#col-main-with-sidebar {
		left:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160' ) + 300 ) . "px;
		width:calc(100% - " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160' ) + 300 ) . "px);
	}
	@media only screen and (min-width: 960px) and (max-width: 1100px) {
		#col-main-with-sidebar {
			left:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160' ) + 260 ) . "px;
			width:calc(100% - " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160' ) + 260 ) . "px);
		}
	}
	@media only screen and (min-width: 768px) and (max-width: 959px) {
		#col-main-with-sidebar {
			left:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160' ) + 100 ) . "px;
			width:calc(100% - " .  esc_attr( get_theme_mod('progression_studios_nav_dash_sidebar_width', '160' ) + 100 ) . "px);
		}
	}
	
	body #sidebar-bg .elementor-column-gap-default > .elementor-row > .elementor-column > .elementor-element-populated,
	#sidebar-bg footer#site-footer .dashboard-container-pro,
	#sidebar-bg .dashboard-container-pro {
		padding-left:" .  esc_attr( get_theme_mod('progression_studios_dashboard_width_padding', '50') ) . "px; padding-right:" .  esc_attr( get_theme_mod('progression_studios_dashboard_width_padding', '50') ) . "px;
	}
	
	#sidebar-bg:before {
		background:" .  esc_attr( get_theme_mod('progression_studios_dash_sidebar_background', '#ffffff') ) . ";
		position: " .  esc_attr( get_theme_mod('progression_studios_dash_sidebar_sticky', 'fixed') ) . ";
	}
	#sidebar-bg:after {	background:" .  esc_attr( get_theme_mod('progression_studios_dash_sidebar_border_right', 'rgba(0, 0, 0, 0.04)') ) . "; }
	#sidebar-nav-pro ul.sf-menu li a {
		color:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_font_color', '#848484') ) . ";
		background:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_font_bg', 'rgba(255,255,255,  0)') ) . ";
		padding-top:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_padding', '26') ) . "px;
		padding-bottom:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_padding', '26') ) . "px;
		border-bottom:1px solid " .  esc_attr( get_theme_mod('progression_studios_dash_sidebar_border_btm', '#e7e7e7') ) . "; 
	}
	#sidebar-nav-pro ul.sf-menu a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover a, #sidebar-nav-pro ul.sf-menu li.current-menu-item a {
		color:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_font_color_hover', '#3db13d') ) . ";
		background:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_bg_hover', 'rgba(255,255,255,  0)') ) . ";
	}
	#sidebar-nav-pro ul.sf-menu ul {
		background:" .  esc_attr( get_theme_mod('progression_studios_dashboard_sub_nav_bg', '#232323') ) . ";
	}
	#sidebar-nav-pro ul.sf-menu li li a {
		font-size:" .  esc_attr( get_theme_mod('progression_studios_sub_nav_dashboard_font_size', '13') ) . "px;
		letter-spacing:" .  esc_attr( get_theme_mod('progression_studios_sub_nav_dashboard_letterspacing', '0.02') ) . "em;
		border-bottom:1px solid " .  esc_attr( get_theme_mod('progression_studios_sub_nav_dashboard_border_color', 'rgba(255,255,255, 0.08)') ) . ";
	}
	#sidebar-nav-pro ul.sf-menu li.sfHover li a, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li a, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li a, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a {
		color:" .  esc_attr( get_theme_mod('progression_studios_sub_nav_dashboard_font_color', 'rgba(255,255,255, 0.6)') ) . ";
	}
	#sidebar-nav-pro ul.sf-menu li.sfHover li a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover a, #sidebar-nav-pro ul.sf-menu li.sfHover li li a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover a, #sidebar-nav-pro ul.sf-menu li.sfHover li li li a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, #sidebar-nav-pro ul.sf-menu li.sfHover li li li li a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, #sidebar-nav-pro ul.sf-menu li.sfHover li li li li li a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, #sidebar-nav-pro ul.sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a {
		color:" .  esc_attr( get_theme_mod('progression_studios_sub_nav_hover_dashboard_font_color', '#ffffff') ) . ";
	}
	body #logo-pro img {
		width:" .  esc_attr( get_theme_mod('progression_studios_theme_logo_width', '111') ) . "px;
		padding-top:" .  esc_attr( get_theme_mod('progression_studios_theme_logo_margin_top', '27') ) . "px;
		padding-bottom:" .  esc_attr( get_theme_mod('progression_studios_theme_logo_margin_bottom', '27') ) . "px;
	}
	a, #movie-detail-rating h5 .arm_form_popup_container a, ul.fullscreen-reviews-pro h6 a:hover, ul.profile-social-media-sidebar-icons li a, ul#profile-watched-stats span, #header-user-profile-menu ul li a:hover, .progression-studios-slider-more-options ul li:last-child a:hover, .progression-studios-slider-more-options ul li a:hover, ul.skrn-video-cast-list li a:hover h6, form.favorite_user_post button.favorite-button-pro.is-favorite, form.favorite_user_post button.favorite-button-pro:hover,  form.wishlist_user_post button.wishlist-button-pro.is-wishlist, form.wishlist_user_post button.wishlist-button-pro:hover, .spoiler-review {
		color:" .  esc_attr( get_theme_mod('progression_studios_default_link_color', '#3db13d') ) . ";
	}
	a:hover, #movie-detail-rating h5 .arm_form_popup_container a:hover, ul.profile-social-media-sidebar-icons li a:hover, ul.video-director-mega-sidebar a:hover, ul.video-grenes-mega-sidebar a:hover {
		color:" .  esc_attr( get_theme_mod('progression_studios_default_link_hover_color', '#9d9d9d') ). ";
	}
	header ul .sf-mega {margin-left:-" .  esc_attr( get_theme_mod('progression_studios_site_width', '1200') / 2 ) . "px; width:" .  esc_attr( get_theme_mod('progression_studios_site_width', '1200') ) . "px;}
	body .elementor-section.elementor-section-boxed > .elementor-container {max-width:" .  esc_attr( get_theme_mod('progression_studios_site_width', '1200') ) . "px;}
	.width-container-pro {  width:" .  esc_attr( get_theme_mod('progression_studios_site_width', '1200') ) . "px; }
	$progression_studios_header_bg_optional
	body.progression-studios-header-sidebar-before #progression-inline-icons .progression-studios-social-icons, body.progression-studios-header-sidebar-before:before, header#masthead-pro {
		$progression_studios_header_bg_image
		$progression_studios_header_bg_cover
	}
	header#masthead-pro:after {
		background:" .   esc_attr( get_theme_mod('progression_studios_header_border_btm_color', 'rgba(0,0,0,  0.07)') ). ";
	}
	body {
		background-color:" .   esc_attr( get_theme_mod('progression_studios_background_color', '#ffffff') ). ";
		$progression_studios_body_bg
		$progression_studios_body_bg_cover
	}
	#page-title-pro {
		background-color:" .   esc_attr( get_theme_mod('progression_studios_page_title_bg_color', '#fafafa') ). ";
		$progression_studios_page_title_bg
		$progression_studios_page_tite_bg_cover
		border-color:" .   esc_attr( get_theme_mod('progression_studios_page_title_border_btm_color', 'rgba(0,0,0,  0.05)') ). ";
	}
	#progression-studios-page-title-container {
		padding-top:" . esc_attr( get_theme_mod('progression_studios_page_title_padding_top', '90') ). "px;
		padding-bottom:" .  esc_attr( get_theme_mod('progression_studios_page_title_padding_bottom', '85') ). "px;
	}
	#progression-studios-post-page-title {
		background-color:" .   esc_attr( get_theme_mod('progression_studios_page_title_bg_color', '#afafaf') ). ";
		$progression_studios_page_title_bg
		$progression_studios_page_tite_bg_cover
		padding-top:" . esc_attr( get_theme_mod('progression_studios_page_title__postpadding_top', '130') ). "px;
		padding-bottom:" .  esc_attr( get_theme_mod('progression_studios_page_title_post_padding_bottom', '125') ). "px;
	}

	.sidebar h4.widget-title:before { background-color:" .   esc_attr( get_theme_mod('progression_studios_sidebar_header_border', '#dddddd') ). "; }
	ul.progression-studios-header-social-icons li a {
		margin-top:". esc_attr( get_theme_mod('progression_studios_social_icons_margintop', '29') ) . "px;
		background:". esc_attr( get_theme_mod('progression_studios_social_icons_bg', 'rgba(255,255,255,  0.15)') ) . ";
		color:". esc_attr( get_theme_mod('progression_studios_social_icons_color', 'rgba(255,255,255,  0.85)') ) . ";
	}
	ul.progression-studios-header-social-icons li a:hover {
		background:". esc_attr( get_theme_mod('progression_studios_social_icons_hover_bg', 'rgba(255,255,255,  0.22)') ) . ";
		color:". esc_attr( get_theme_mod('progression_studios_social_icons_hover_color', '#ffffff') ) . ";
	}
	/* START BLOG STYLES */	
	#page-title-pro.page-title-pro-post-page {
		$progression_studios_post_tite_bg_color
		$progression_studios_post_tite_bg_image_post
		$progression_studios_post_tite_bg_cover
	}
	.progression-blog-content {
		background:" . esc_attr( get_theme_mod('progression_studios_blog_content_bg', '#f8f8f8') ) . ";
	}
	$progression_studios_post_tite_bg_featuredimg_bg
	.progression-studios-feaured-image:hover a img { opacity:" . esc_attr( get_theme_mod('progression_studios_blog_image_opacity', '1') ) . ";}
	h2.progression-blog-title a, .progression-studios-blog-excerpt a.more-link {color:" . esc_attr( get_theme_mod('progression_studios_blog_title_link', '#282828') ) . ";}
	h2.progression-blog-title a:hover, .progression-studios-blog-excerpt a.more-link:hover {color:" . esc_attr( get_theme_mod('progression_studios_blog_title_link_hover', '#3db13d') ) . ";}
	/* END BLOG STYLES */
	/* START VIDEO STYLES */
	.progression-studios-video-index {border-color:" . esc_attr( get_theme_mod('progression_studios_video_content_border', 'rgba(0,0,0,0.08)') ) . ";}
	.progression-video-index-content {background:" . esc_attr( get_theme_mod('progression_studios_video_content_bg', '#ffffff') ) . "; }
	.progression-studios-feaured-video-index {background:" . esc_attr( get_theme_mod('progression_studios_video_index_image_bg', '#ffffff') ) . ";}
	.progression-studios-feaured-video-index:hover a img { opacity:" . esc_attr( get_theme_mod('progression_studios_video_image_opacity', '1') ) . ";}
	
	#movie-detail-header-pro {
		height:" . esc_attr( get_theme_mod('progression_studios_media_header_height', '80') ) . "vh;
		background-color:" . esc_attr( get_theme_mod('progression_studios_media_header_color', '#555555') ) . ";
		$progression_studios_header_media_bg_image
	}
	#content-sidebar-pro, #content-sidebar-pro:after {
		background-color:" . esc_attr( get_theme_mod('progression_studios_media_sidebar_meta_bg', '#fafafa') ) . ";
	}
	/* END VIDEO STYLES */
	
	/* START SHOP STYLES */
	.progression-studios-shop-index-content {
		background: " . esc_attr( get_theme_mod('progression_studios_shop_post_background', '#ffffff') ) . ";
		border-color:" . esc_attr( get_theme_mod('progression_studios_shop_post_border_color', 'rgba(0,0,0,0.09)') ) . ";
	}

	$progression_studios_shop_rating_index
	/* END SHOP STYLES */
	
	/* START BUTTON STYLES */
	.infinite-nav-pro a {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	.infinite-nav-pro a:hover {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font_hover', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . ";
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . ";
	}
	.select_vayvo_season_5 ul.vayvo-progression-video-season-navigation li.progression-video-season-title:nth-child(5) a,
	.select_vayvo_season_4 ul.vayvo-progression-video-season-navigation li.progression-video-season-title:nth-child(4) a,
	.select_vayvo_season_3 ul.vayvo-progression-video-season-navigation li.progression-video-season-title:nth-child(3) a,
	.select_vayvo_season_2 ul.vayvo-progression-video-season-navigation li.progression-video-season-title:nth-child(2) a,
	ul.vayvo-progression-video-season-navigation li.progression-video-season-title.current a  {
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	ul.dashboard-sub-menu li.current a:after,
	.checkbox-pro-container .checkmark-pro:after  {
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	.wpneo-fields input[type='number'], .wpneo-fields input[type='text'], .wpneo-fields input[type='email'], .wpneo-fields input[type='password'],  .wpneo-fields textarea, .campaign_update_field_copy  input, .campaign_update_field_copy  textarea, #campaign_update_addon_field input, #campaign_update_addon_field textarea,
	.woocommerce input, #content-pro .woocommerce table.shop_table .coupon input#coupon_code, #content-pro .woocommerce table.shop_table input, form.checkout.woocommerce-checkout textarea.input-text, form.checkout.woocommerce-checkout input.input-text,
	.post-password-form input, .search-form input.search-field, .wpcf7 select, #respond textarea, #respond input, .wpcf7-form input, .wpcf7-form textarea {
		background-color:" . esc_attr( get_theme_mod('progression_studios_input_background', '#ffffff') ) . ";
		border-color:" . esc_attr( get_theme_mod('progression_studios_input_border', '#dddddd') ) . ";
	}
	.wpneo-fields input[type='text'], .wpneo-fields input[type='email'], .wpneo-fields input[type='password'],  .wpneo-fields textarea {
		border-color:" . esc_attr( get_theme_mod('progression_studios_input_border', '#dddddd') ) . " !important;
	}
	body a.progression-studios-skrn-slider-button,
	.post-password-form input[type=submit], #respond input.submit, .wpcf7-form input.wpcf7-submit {
		font-size:" . esc_attr( get_theme_mod('progression_studios_button_font_size', '13') + 1 ) . "px;
	}
	.tablet-mobile-video-search-header-buttons input,
	.video-search-header-buttons input,
	.helpmeout-rewards-select_button button.select_rewards_button,
	#boxed-layout-pro .woocommerce .shop_table input.button, #boxed-layout-pro .form-submit input#submit, #boxed-layout-pro #customer_login input.button, #boxed-layout-pro .woocommerce-checkout-payment input.button, #boxed-layout-pro button.button, #boxed-layout-pro a.button  {
		font-size:" . esc_attr( get_theme_mod('progression_studios_button_font_size', '13') ) . "px;
	}
	.tablet-mobile-video-search-header-buttons input,
	.video-search-header-buttons input,
	#progression-checkout-basket a.cart-button-header-cart, .search-form input.search-field, .wpcf7 select, .post-password-form input, #respond textarea, #respond input, .wpcf7-form input, .wpcf7-form textarea {
		border-radius:" . esc_attr( get_theme_mod('progression_studios_ionput_bordr_radius', '4') ) . "px;
	}
	#helpmeeout-login-form:before {
		border-bottom: 8px solid " . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	a.edit-profile-sidebar,
	body .select2-container--default .select2-results__option--highlighted[aria-selected],
	.tablet-mobile-video-search-header-buttons input#mobile-configure-rest:hover,
	.tablet-mobile-video-search-header-buttons input,
	.video-search-header-buttons input#configreset:hover,
	.video-search-header-buttons input,
	.tags-progression a:hover,
	.progression-page-nav a:hover, .progression-page-nav span, #boxed-layout-pro ul.page-numbers li a:hover, #boxed-layout-pro ul.page-numbers li span.current {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	.column-search-header .asRange .asRange-pointer:before, .column-search-header .asRange .asRange-selected {background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";}
	.progression-page-nav a:hover span {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
	}
	.user-notification-count,
	#progression-checkout-basket a.cart-button-header-cart, .flex-direction-nav a:hover, #boxed-layout-pro .woocommerce-shop-single .summary button.button,
	#boxed-layout-pro .woocommerce-shop-single .summary a.button,
	.mc4wp-form input[type='submit'] {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	body a.progression-studios-skrn-slider-button,
	#boxed-layout-pro a.button-progression,
	.woocommerce form input.button,
	.woocommerce form input.woocommerce-Button,
	.helpmeout-rewards-select_button button.select_rewards_button,
	button.wpneo_donate_button,
	.sidebar ul.progression-studios-social-widget li a,
	footer#site-footer .tagcloud a, .tagcloud a, body .woocommerce nav.woocommerce-MyAccount-navigation li.is-active a,
	.post-password-form input[type=submit], #respond input.submit, .wpcf7-form input.wpcf7-submit,
	#boxed-layout-pro .woocommerce .shop_table input.button, #boxed-layout-pro .form-submit input#submit, #boxed-layout-pro #customer_login input.button, #boxed-layout-pro .woocommerce-checkout-payment input.button, #boxed-layout-pro button.button, #boxed-layout-pro a.button {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
		border-radius:" . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
		letter-spacing:" . esc_attr( get_theme_mod('progression_studios_button_letter_spacing', '0') ) . "em;
	}
	#skrn-header-user-profile-login a,
	#skrn-landing-login-logout-header a {
		border-radius:" . esc_attr( get_theme_mod('progression_studios_button_bordr_radius', '4') ) . "px;
		letter-spacing:" . esc_attr( get_theme_mod('progression_studios_button_letter_spacing', '0') ) . "em;
		margin-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 17 ). "px;
	}
	#skrn-landing-login-logout-header a,
	#skrn-header-user-profile-login a.arm_form_popup_link,
	#skrn-landing-login-logout-header a.arm_form_popup_link {
		color:" . esc_attr( get_theme_mod('progression_studios_header_btn_color', '#666666') ) . " !important;
		background:" . esc_attr( get_theme_mod('progression_studios_header_btn_background', '#f9f9f9') ) . " !important;
		border-color:" . esc_attr( get_theme_mod('progression_studios_header_btn_border', '#e7e7e7') ) . " !important;
	}
	#skrn-landing-login-logout-header a:hover,
	#skrn-header-user-profile-login a.arm_form_popup_link:hover,
	#skrn-landing-login-logout-header a.arm_form_popup_link:hover {
		color:" . esc_attr( get_theme_mod('progression_studios_header_btn_hover_color', '#ffffff') ) . " !important;
		background:" . esc_attr( get_theme_mod('progression_studios_header_btn_hover_background', '#43af43') ) . " !important;
		border-color:" . esc_attr( get_theme_mod('progression_studios_header_btn_hover_border', '#43af43') ) . " !important;
	}
	.progression-studios-post-slider-main .flex-control-paging li a.flex-active {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	#skrn-landing-mobile-login-logout-header a,
	.tags-progression a:hover {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	#skrn-landing-mobile-login-logout-header a.arm_form_popup_link {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font', '#ffffff') ) . " !important;
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;
	}
	#mobile-menu-icon-pro span.progression-mobile-menu-text,
	#boxed-layout-pro .woocommerce-shop-single .summary button.button,
	#boxed-layout-pro .woocommerce-shop-single .summary a.button {
		letter-spacing:" . esc_attr( get_theme_mod('progression_studios_button_letter_spacing', '0') ) . "em;
	}
	body .woocommerce nav.woocommerce-MyAccount-navigation li.is-active a {
	border-radius:0px;
	}
	#skrn-mobile-video-search-header input.skrn-mobile-search-field-progression:focus,
	ul.skrn-video-search-columns .select2.select2-container--open .select2-selection,
	.wpneo-fields input[type='number']:focus, #wpneofrontenddata .wpneo-fields select:focus, .campaign_update_field_copy  input:focus, .campaign_update_field_copy  textarea:focus, #campaign_update_addon_field input:focus, #campaign_update_addon_field textarea:focus, .wpneo-fields input[type='text']:focus, .wpneo-fields input[type='email']:focus, .wpneo-fields input[type='password']:focus,  .wpneo-fields textarea:focus {
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . " !important;
	}
	.dashboard-head-date input[type='text']:focus,
	#panel-search-progression .search-form input.search-field:focus, blockquote.alignleft, blockquote.alignright, body .woocommerce-shop-single table.variations td.value select:focus, .woocommerce input:focus, #content-pro .woocommerce table.shop_table .coupon input#coupon_code:focus, body #content-pro .woocommerce table.shop_table input:focus, body #content-pro .woocommerce form.checkout.woocommerce-checkout input.input-text:focus, body #content-pro .woocommerce form.checkout.woocommerce-checkout textarea.input-text:focus, form.checkout.woocommerce-checkout input.input-text:focus, form#mc-embedded-subscribe-form  .mc-field-group input:focus, .wpcf7-form select:focus, blockquote, .post-password-form input:focus, .search-form input.search-field:focus, #respond textarea:focus, #respond input:focus, .wpcf7-form input:focus, .wpcf7-form textarea:focus,
	.widget.widget_price_filter form .price_slider_wrapper .price_slider .ui-slider-handle {
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
		outline:none;
	}
	body .woocommerce .woocommerce-MyAccount-content {
		border-left-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	ul.progression-filter-button-group li.pro-checked {
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	.widget.widget_price_filter form .price_slider_wrapper .price_slider .ui-slider-range {
		background:" . esc_attr( get_theme_mod('progression_studios_button_background', '#43af43') ) . ";
	}
	.tablet-mobile-video-search-header-buttons input:hover,
	.video-search-header-buttons input:hover {
		border-color:" . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . ";
	}
	#skrn-landing-mobile-login-logout-header a.arm_form_popup_link:hover {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font_hover', '#ffffff') ) . " !important;
		background:" . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . " !important;
	}
	body a.progression-studios-skrn-slider-button:hover,
	#skrn-landing-mobile-login-logout-header a:hover,
	a.edit-profile-sidebar:hover,
	.tablet-mobile-video-search-header-buttons input:hover,
	.video-search-header-buttons input:hover,
	#boxed-layout-pro a.button-progression:hover,
	.woocommerce form input.button:hover,
	.woocommerce form input.woocommerce-Button:hover,
	body #progression-checkout-basket a.cart-button-header-cart:hover, #boxed-layout-pro .woocommerce-shop-single .summary button.button:hover,
	#boxed-layout-pro .woocommerce-shop-single .summary a.button:hover, .mc4wp-form input[type='submit']:hover, .progression-studios-blog-cat-overlay a, .progression-studios-blog-cat-overlay a:hover,
	.sidebar ul.progression-studios-social-widget li a:hover,
	footer#site-footer .tagcloud a:hover, .tagcloud a:hover, #boxed-layout-pro .woocommerce .shop_table input.button:hover, #boxed-layout-pro .form-submit input#submit:hover, #boxed-layout-pro #customer_login input.button:hover, #boxed-layout-pro .woocommerce-checkout-payment input.button:hover, #boxed-layout-pro button.button:hover, #boxed-layout-pro a.button:hover, .post-password-form input[type=submit]:hover, #respond input.submit:hover, .wpcf7-form input.wpcf7-submit:hover {
		color:" . esc_attr( get_theme_mod('progression_studios_button_font_hover', '#ffffff') ) . ";
		background:" . esc_attr( get_theme_mod('progression_studios_button_background_hover', '#9d9d9d') ) . ";
	}
	/* END BUTTON STYLES */
	
	/* START Sticky Nav Styles */
	.progression-sticky-scrolled #progression-studios-nav-bg,
	.progression-studios-transparent-header .progression-sticky-scrolled #progression-studios-nav-bg,
	.progression-studios-transparent-header .progression-sticky-scrolled header#masthead-pro, .progression-sticky-scrolled header#masthead-pro, #progression-sticky-header.progression-sticky-scrolled { background-color:" .   esc_attr( get_theme_mod('progression_studios_sticky_header_background_color', '#ffffff') ) ."; }
	body .progression-sticky-scrolled #logo-pro img {
		$progression_studios_sticky_logo_width
		$progression_studios_sticky_logo_top
		$progression_studios_sticky_logo_bottom
	}
	$progression_studios_sticky_nav_padding
	$progression_studios_sticky_nav_option_font_color	
	$progression_studios_optional_sticky_nav_font_hover
	$progression_studios_sticky_nav_underline
	/* END Sticky Nav Styles */
	/* START Main Navigation Customizer Styles */
	#progression-shopping-cart-count a.progression-count-icon-nav, nav#site-navigation { letter-spacing: ". esc_attr( get_theme_mod('progression_studios_nav_letterspacing', '0.04') ). "em; }
	
	#progression-inline-icons .progression-studios-social-icons a {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
		padding-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 3 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 3 ). "px;
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 3 ). "px;
	}
	#mobile-menu-icon-pro {
		min-width:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 6 ). "px;
		color:". esc_attr( get_theme_mod('progression_studios_nav_font_color_hover', '#272727') ) . ";
		padding-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 3 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 5 ). "px;
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 6 ). "px;
	}
	#mobile-menu-icon-pro:hover, .active-mobile-icon-pro #mobile-menu-icon-pro {
		color:". esc_attr( get_theme_mod('progression_studios_nav_font_color_hover', '#272727') ) . ";
	}
	#mobile-menu-icon-pro span.progression-mobile-menu-text {
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') ). "px;
	}
	#progression-shopping-cart-count span.progression-cart-count {
		top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 1). "px;
	}
	#progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
		padding-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 5 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 5 ). "px;
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 10 ). "px;
	}
	.progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
	}
	.progression-sticky-scrolled  #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon:hover,
	.progression-sticky-scrolled  .activated-class #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon,
	#progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon:hover,
	.activated-class #progression-shopping-cart-count a.progression-count-icon-nav i.shopping-cart-header-icon { 
		color:". esc_attr( get_theme_mod('progression_studios_nav_font_color_hover', '#272727') ) . ";
	}
	#progression-studios-header-login-container a.progresion-studios-login-icon {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
		padding-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 13 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 13 ). "px;
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 8 ). "px;
	}
	#progression-studios-header-search-icon i.pe-7s-search span, #progression-studios-header-login-container a.progresion-studios-login-icon span {
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13')). "px;
	}
	#progression-studios-header-login-container a.progresion-studios-login-icon i.fa-sign-in {
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 6 ). "px;
	}
	
	#progression-studios-header-search-icon i.pe-7s-search {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
		padding-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 4 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') - 4 ). "px;
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') + 8 ). "px;
	}
	.sf-menu a {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
		padding-top:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('progression_studios_nav_padding', '37') ). "px;
		font-size:" . esc_attr( get_theme_mod('progression_studios_nav_font_size', '13') ). "px;
		$progression_studios_optional_nav_bg
	}
	#main-nav-mobile { background:".  esc_attr( get_theme_mod('progression_studios_header_dash_background', '#ffffff') ). "; }
	ul.mobile-menu-pro li a { color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). "; }
	ul.mobile-menu-pro li a { letter-spacing:" .  esc_attr( get_theme_mod('progression_studios_nav_dash_letterspacing', '0.02') ) . "em; }
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled  #progression-inline-icons .progression-studios-social-icons a,
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled  #progression-inline-icons .progression-studios-social-icons a,
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon i.pe-7s-search, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container a.progresion-studios-login-icon, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu a,
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon i.pe-7s-search,
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container a.progresion-studios-login-icon, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu a  {
		color:" . esc_attr( get_theme_mod('progression_studios_nav_font_color', '#272727') ). ";
	}
	$progression_studios_sticky_nav_underline_default
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled  #progression-inline-icons .progression-studios-social-icons a:hover,
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled  #progression-inline-icons .progression-studios-social-icons a:hover,
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon:hover i.pe-7s-search, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon.active-search-icon-pro i.pe-7s-search, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container:hover a.progresion-studios-login-icon, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container.helpmeout-activated-class a.progresion-studios-login-icon, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a:hover, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav:hover, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu a:hover, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover a, 
	.progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item a,
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon:hover i.pe-7s-search, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-search-icon.active-search-icon-pro i.pe-7s-search, 
	
	
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container:hover a.progresion-studios-login-icon, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-studios-header-login-container.helpmeout-activated-class a.progresion-studios-login-icon, 
	
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-inline-icons .progression-studios-social-icons a:hover, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled #progression-shopping-cart-count a.progression-count-icon-nav:hover, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu a:hover, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover a, 
	.progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.current-menu-item a,
	
	#progression-studios-header-login-container:hover a.progresion-studios-login-icon, #progression-studios-header-login-container.helpmeout-activated-class a.progresion-studios-login-icon,
	
	#progression-studios-header-search-icon:hover i.pe-7s-search, #progression-studios-header-search-icon.active-search-icon-pro i.pe-7s-search, #progression-inline-icons .progression-studios-social-icons a:hover, #progression-shopping-cart-count a.progression-count-icon-nav:hover, .sf-menu a:hover, .sf-menu li.sfHover a, .sf-menu li.current-menu-item a {
		color:". esc_attr( get_theme_mod('progression_studios_nav_font_color_hover', '#272727') ) . ";
	}
	ul#progression-studios-panel-login, #progression-checkout-basket, #panel-search-progression, .sf-menu ul {
		background:".  esc_attr( get_theme_mod('progression_studios_sub_nav_bg', '#232323') ). ";
	}
	ul#progression-studios-panel-login li a, .sf-menu li li a { 
		letter-spacing:".  esc_attr( get_theme_mod('progression_studios_sub_nav_letterspacing', '0') ). "em;
		font-size:".  esc_attr( get_theme_mod('progression_studios_sub_nav_font_size', '13') ). "px;
	}
	#progression-checkout-basket .progression-sub-total {
		font-size:".  esc_attr( get_theme_mod('progression_studios_sub_nav_font_size', '13' ) ). "px;
	}
	ul#progression-studios-panel-login, #panel-search-progression input, #progression-checkout-basket ul#progression-cart-small li.empty { 
		font-size:".  esc_attr( get_theme_mod('progression_studios_sub_nav_font_size', '13' ) ). "px;
	}
	ul#progression-studios-panel-login a,
	.progression-sticky-scrolled #progression-checkout-basket, .progression-sticky-scrolled #progression-checkout-basket a, .progression-sticky-scrolled .sf-menu li.sfHover li a, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li a, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li a, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, #panel-search-progression .search-form input.search-field, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover.highlight-button li a, .sf-menu li.current-menu-item.highlight-button li a, .progression-sticky-scrolled #progression-checkout-basket a.checkout-button-header-cart:hover, #progression-checkout-basket a.checkout-button-header-cart:hover, #progression-checkout-basket, #progression-checkout-basket a, .sf-menu li.sfHover li a, .sf-menu li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a {
		color:" . esc_attr( get_theme_mod('progression_studios_sub_nav_font_color', 'rgba(255,255,255,  0.7)') ) . ";
	}
	
	.progression-sticky-scrolled ul#progression-studios-panel-login li a:hover, .progression-sticky-scrolled .sf-menu li li a:hover,  .progression-sticky-scrolled .sf-menu li.sfHover li a, .progression-sticky-scrolled .sf-menu li.current-menu-item li a, .sf-menu li.sfHover li a, .sf-menu li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a { 
		background:none;
	}
	ul#progression-studios-panel-login a:hover,
	.progression-sticky-scrolled #progression-checkout-basket a:hover, .progression-sticky-scrolled #progression-checkout-basket ul#progression-cart-small li h6, .progression-sticky-scrolled #progression-checkout-basket .progression-sub-total span.total-number-add, .progression-sticky-scrolled .sf-menu li.sfHover li a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover a, .progression-sticky-scrolled .sf-menu li.sfHover li li a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a, .progression-sticky-scrolled .sf-menu li.sfHover li li li a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .progression-sticky-scrolled .sf-menu li.sfHover li li li li a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression-sticky-scrolled .sf-menu li.sfHover li li li li li a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li li a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li li li a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li li li li a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_dark_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li li a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li li li a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li li li li a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li li li li li a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li li a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li li li a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li li li li li a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_light_navigation_color .progression-sticky-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li li a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li li li a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li li li li a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li li li li li a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .progression_studios_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover.highlight-button li a:hover, .sf-menu li.current-menu-item.highlight-button li a:hover, #progression-checkout-basket a.checkout-button-header-cart, #progression-checkout-basket a:hover, #progression-checkout-basket ul#progression-cart-small li h6, #progression-checkout-basket .progression-sub-total span.total-number-add, .sf-menu li.sfHover li a:hover, .sf-menu li.sfHover li.sfHover a, .sf-menu li.sfHover li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover li li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover li li li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover li li li li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a { 
		color:". esc_attr( get_theme_mod('progression_studios_sub_nav_hover_font_color', '#ffffff') ) . ";
	}
	
	ul#progression-studios-panel-login li a, #progression-checkout-basket ul#progression-cart-small li, #progression-checkout-basket .progression-sub-total, #panel-search-progression .search-form input.search-field, .sf-mega li:last-child li a, body header .sf-mega li:last-child li a, .sf-menu li li a, .sf-mega h2.mega-menu-heading, .sf-mega ul, body .sf-mega ul, #progression-checkout-basket .progression-sub-total, #progression-checkout-basket ul#progression-cart-small li { 
		border-color:" . esc_attr( get_theme_mod('progression_studios_sub_nav_border_color', 'rgba(255,255,255,  0.08)') ) . ";
	}
	
	.sf-menu a:before {
		margin-left:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') ) . "px;
		width: calc(100% - " . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') * 2 ) . "px);
	}
	.sf-menu a:hover:before, .sf-menu li.sfHover a:before, .sf-menu li.current-menu-item a:before {
	   width: calc(100% - " . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') * 2 ) . "px);
	}
	#progression-inline-icons .progression-studios-social-icons a {
		padding-left:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') -  7 ). "px;
		padding-right:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 7 ). "px;
	}
	#progression-inline-icons .progression-studios-social-icons {
		padding-right:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 7 ). "px;
	}
	.sf-menu a {
		padding-left:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') ). "px;
		padding-right:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') ). "px;
	}
	
	.sf-menu li.highlight-button { 
		margin-right:". esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 7 ) . "px;
		margin-left:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 7 ) . "px;
	}
	.sf-arrows .sf-with-ul {
		padding-right:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') + 15 ) . "px;
	}
	.sf-arrows .sf-with-ul:after { 
		right:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') + 9 ) . "px;
	}
	
	
	@media only screen and (min-width: 960px) and (max-width: 1300px) {
		.sf-menu a:before {
			margin-left:". esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 4 ) . "px;
		}
		.sf-menu a:before, .sf-menu a:hover:before, .sf-menu li.sfHover a:before, .sf-menu li.current-menu-item a:before {
		   width: calc(100% - " . esc_attr( (get_theme_mod('progression_studios_nav_left_right', '20') * 2 ) - 6) . "px);
		}
		.sf-menu a {
			padding-left:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 4 ). "px;
			padding-right:" . esc_attr( get_theme_mod('progression_studios_nav_left_right', '20') - 4 ). "px;
		}

	}
	$progression_studios_optiona_nav_bg_hover
	$progression_studios_optiona_sticky_nav_font_bg	
	$progression_studios_optiona_sticky_nav_hover_bg
	$progression_studios_option_sticky_nav_font_color	
	$progression_studios_option_stickY_nav_font_hover_color
	$progression_studios_option_sticky_hightlight_bg_color
	$progression_studios_option_sticky_hightlight_font_color
	$progression_studios_option_sticky_hightlight_bg_color_hover
	/* END Main Navigation Customizer Styles */
	/* START FOOTER STYLES */
	footer#site-footer {
		background: " . esc_attr(get_theme_mod('progression_studios_footer_background', '#282828')) . ";
	}
	#pro-scroll-top:hover {   color: " . esc_attr(get_theme_mod('progression_studios_scroll_hvr_color', '#ffffff')) . ";    background: " . esc_attr(get_theme_mod('progression_studios_scroll_hvr_bg_color', '#3db13d')) . ";  }
	footer#site-footer #copyright-text {  color: " . esc_attr(get_theme_mod('progression_studios_copyright_text_color', 'rgba(255,255,255,0.45)')) . ";}
	footer#site-footer #progression-studios-copyright a {  color: " . esc_attr(get_theme_mod('progression_studios_copyright_link', 'rgba(255,255,255,0.75)')) . ";}
	footer#site-footer #progression-studios-copyright a:hover { color: " . esc_attr(get_theme_mod('progression_studios_copyright_link_hover', '#ffffff')) . "; }
	#pro-scroll-top { color:" . esc_attr(get_theme_mod('progression_studios_scroll_color', '#ffffff')) . ";  background: " . esc_attr(get_theme_mod('progression_studios_scroll_bg_color', 'rgba(0,0,0,  0.3)')) . ";  }
	#copyright-text { padding:" . esc_attr(get_theme_mod('progression_studios_copyright_margin_top', '45')) . "px 0px " . esc_attr(get_theme_mod('progression_studios_copyright_margin_bottom', '50')) . "px 0px; }
	#progression-studios-footer-logo { max-width:" . esc_attr( get_theme_mod('progression_studios_footer_logo_width', '250') ) . "px; padding-top:" . esc_attr( get_theme_mod('progression_studios_footer_logo_margin_top', '45') ) . "px; padding-bottom:" . esc_attr( get_theme_mod('progression_studios_footer_logo_margin_bottom', '0') ) . "px; padding-right:" . esc_attr( get_theme_mod('progression_studios_footer_logo_margin_right', '0') ) . "px; padding-left:" . esc_attr( get_theme_mod('progression_studios_footer_logo_margin_left', '0') ) . "px; }
	/* END FOOTER STYLES */
	@media only screen and (max-width: 959px) { 
		body #sidebar-bg .elementor-column-gap-default > .elementor-row > .elementor-column > .elementor-element-populated,
		#sidebar-bg footer#site-footer .dashboard-container-pro,
		#sidebar-bg .dashboard-container-pro {
			padding-left:" .  esc_attr( get_theme_mod('progression_studios_dashboard_width_padding_tablet', '25') ) . "px; padding-right:" .  esc_attr( get_theme_mod('progression_studios_dashboard_width_padding_tablet', '25') ) . "px;
		}
		#progression-studios-post-page-title {
			padding-top:" . esc_attr( get_theme_mod('progression_studios_page_title__postpadding_top', '130') - 25 ). "px;
			padding-bottom:" .  esc_attr( get_theme_mod('progression_studios_page_title_post_padding_bottom', '125') - 25 ). "px;
		}
		$progression_studios_header_bg_optional
		.progression-studios-transparent-header header#masthead-pro {
			$progression_studios_header_bg_image
			$progression_studios_header_bg_cover
		}
		$progression_studios_mobile_header_bg_color
		$progression_studios_mobile_header_logo_width
		$progression_studios_mobile_header_logo_margin_top
		$progression_studios_mobile_header_nav_padding_top
	}
	@media only screen and (min-width: 960px) and (max-width: ". esc_attr( get_theme_mod('progression_studios_site_width', '1200') + 100 ) . "px) {
		#progression-shopping-cart-count a.progression-count-icon-nav {
			margin-left:4px;
		}
		.width-container-pro {
			width:94%;
			padding:0px;
		}
		footer#site-footer.progression-studios-footer-full-width .width-container-pro,
		.progression-studios-page-title-full-width #page-title-pro .width-container-pro,
		.progression-studios-header-full-width #skrn-progression-header-top .width-container-pro {
			width:94%; 
			padding:0px;
		}
		.progression-studios-header-full-width-no-gap.progression-studios-header-cart-width-adjustment header#masthead-pro .width-container-pro,
		.progression-studios-header-full-width.progression-studios-header-cart-width-adjustment header#masthead-pro .width-container-pro {
			width:98%;
			margin-left:2%;
			padding-right:0;
		}
		#skrn-progression-header-top ul .sf-mega,
		header ul .sf-mega {
			margin-right:0px;
			margin-left:2%;
			width:96%; 
			left:0px;
		}
	}
	.progression-studios-spinner { border-left-color:" . esc_attr(get_theme_mod('progression_studios_page_loader_secondary_color', '#ededed')). ";  border-right-color:" . esc_attr(get_theme_mod('progression_studios_page_loader_secondary_color', '#ededed')). "; border-bottom-color: " . esc_attr(get_theme_mod('progression_studios_page_loader_secondary_color', '#ededed')). ";  border-top-color: " . esc_attr(get_theme_mod('progression_studios_page_loader_text', '#cccccc')). "; }
	.sk-folding-cube .sk-cube:before, .sk-circle .sk-child:before, .sk-rotating-plane, .sk-double-bounce .sk-child, .sk-wave .sk-rect, .sk-wandering-cubes .sk-cube, .sk-spinner-pulse, .sk-chasing-dots .sk-child, .sk-three-bounce .sk-child, .sk-fading-circle .sk-circle:before, .sk-cube-grid .sk-cube{ 
		background-color:" . esc_attr(get_theme_mod('progression_studios_page_loader_text', '#cccccc')). ";
	}
	#page-loader-pro {
		background:" . esc_attr(get_theme_mod('progression_studios_page_loader_bg', '#ffffff')). ";
		color:" . esc_attr(get_theme_mod('progression_studios_page_loader_text', '#cccccc')). "; 
	}
	$progression_studios_armember_form_styles
	$progression_studios_boxed_layout
	::-moz-selection {color:" . esc_attr( get_theme_mod('progression_studios_select_color', '#ffffff') ) . ";background:" . esc_attr( get_theme_mod('progression_studios_select_bg', '#3db13d') ) . ";}
	::selection {color:" . esc_attr( get_theme_mod('progression_studios_select_color', '#ffffff') ) . ";background:" . esc_attr( get_theme_mod('progression_studios_select_bg', '#3db13d') ) . ";}
	";
        wp_add_inline_style( 'progression-studios-custom-style', $progression_studios_custom_css );
}
add_action( 'wp_enqueue_scripts', 'progression_studios_customizer_styles' );