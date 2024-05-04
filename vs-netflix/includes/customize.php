<?php
function wpvs_theme_customizer_init( $wp_customize ) {
    global $wpvs_actor_slug_settings;
    global $wpvs_director_slug_settings;
    $wp_customize->add_setting( 'rogue_company_logo', array(
        'sanitize_callback' => 'sanitize_rogue_logo'
        )
    );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'main_logo', array(
        'label'    => __( 'Logo', 'wpvs-theme' ),
        'section'  => 'title_tagline',
        'settings' => 'rogue_company_logo',
        )
    ) );

    $wp_customize->add_setting( 'wpvs_desktop_logo_height', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wpvs_theme_sanitize_number',
        'default' => 50,
        )
    );

    $wp_customize->add_control( 'wpvs_desktop_logo_height', array(
      'type' => 'number',
      'section' => 'title_tagline', // Add a default or your own section
      'label' => __( 'Desktop Logo Height (px)', 'wpvs-theme' ),
      'description' => __( 'Set the height of your logo on tablets and desktops.', 'wpvs-theme' ),
    ) );

    $wp_customize->add_setting( 'wpvs_company_mobile_logo', array(
        'sanitize_callback' => 'sanitize_rogue_logo'
        )
    );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mobile_logo', array(
        'label'    => __( 'Mobile Logo', 'wpvs-theme' ),
        'section'  => 'title_tagline',
        'settings' => 'wpvs_company_mobile_logo',
        )
    ) );

    $wp_customize->add_setting( 'wpvs_mobile_logo_height', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wpvs_theme_sanitize_number',
        'default' => 40,
        )
    );

    $wp_customize->add_control( 'wpvs_mobile_logo_height', array(
      'type' => 'number',
      'section' => 'title_tagline', // Add a default or your own section
      'label' => __( 'Mobile Logo Height (px)', 'wpvs-theme' ),
      'description' => __( 'Set the height of your logo on mobile devices.', 'wpvs-theme' ),
    ) );

    $wp_customize->add_setting( 'wpvs_signin_logo_height', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wpvs_theme_sanitize_number',
        'default' => 150,
        )
    );

    $wp_customize->add_control( 'wpvs_signin_logo_height', array(
      'type' => 'number',
      'section' => 'title_tagline', // Add a default or your own section
      'label' => __( 'Login Logo Height (px)', 'wpvs-theme' ),
      'description' => __( 'Set the height of your logo on the Login screen.', 'wpvs-theme' ),
    ) );

    // ==== Primary Colours ====
    $wp_customize->add_setting( 'style_color', array(
        'default'     => 'dark',
        'transport'   => 'refresh'
    ) );

    $wp_customize->add_control( 'theme_style', array(
        'label'        => __( 'Theme Style', 'wpvs-theme' ),
        'type' => 'select',
        'choices'  => array('dark' => 'Dark','light' => 'Light'),
        'section'    => 'colors',
        'settings'   => 'style_color',
    ) );

    $wp_customize->add_setting( 'accent_color', array(
        'default'     => '#E50914',
        'transport'   => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'Accent Color', array(
        'label'        => __( 'Accent Color', 'wpvs-theme' ),
        'section'    => 'colors',
        'settings'   => 'accent_color',
    ) ) );

    $wp_customize->add_setting( 'vs_slide_gradient_color', array(
      'default' => '#000000',
      'transport'   => 'refresh',
      'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'Featured Area Gradient', array(
        'label'     => __( 'Featured Area Gradient', 'wpvs-theme' ),
        'section'   => 'colors',
        'settings'  => 'vs_slide_gradient_color',
        'description' => __( 'Changes the background gradient color for Featured Areas, Drop Down sections and Netflix style video page headers', 'wpvs-theme' )
    ) ) );

    $wp_customize->add_setting( 'featured_area_content_color', array(
      'default' => '#eeeeee',
      'transport'   => 'refresh',
      'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'Featured Area Content Color', array(
        'label'     => __( 'Featured Area Content Color', 'wpvs-theme' ),
        'section'   => 'colors',
        'settings'  => 'featured_area_content_color',
        'description' => __( 'Changes the text color for Featured Areas, Drop Down sections and Netflix style video page headers', 'wpvs-theme' )
    ) ) );

    /* == HEADER SECTION == */

    $wp_customize->add_section( 'vs_header', array(
      'title' => __( 'Header', 'wpvs-theme' ),
      'description' => __( 'Header area customization.', 'wpvs-theme' ),
      'priority' => 40,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'vs_search_placeholder', array(
      'capability' => 'edit_theme_options',
      'default' => 'Enter search...',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('vs_search_placeholder', array(
      'label' => __( 'Search placeholder text', 'wpvs-theme' ),
      'type' => 'text',
      'description' => __( 'Placeholder text for the search input', 'wpvs-theme' ),
      'section' => 'vs_header'
    ) );

    $wp_customize->add_setting( 'vs_menu_login', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('vs_menu_login', array(
        'label' => __( 'Show Sign In / User Menu', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_header'
    ));

    $wp_customize->add_setting( 'vs_menu_login_text', array(
      'capability' => 'edit_theme_options',
      'default' => 'Sign In',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('vs_menu_login_text', array(
      'label' => __( 'Sign In button text', 'wpvs-theme' ),
      'type' => 'text',
      'section' => 'vs_header'
    ) );

    $wpvs_my_list_page_id = get_option('wpvs_my_list_page');

    if( empty($wpvs_my_list_page_id) && empty(get_post($wpvs_my_list_page_id)) ) {
        $wpvs_select_my_list_pages = array();
        $wpvs_my_list_page_default = '0';
    } else {
        $wpvs_select_my_list_pages = array($wpvs_my_list_page_id => get_the_title($wpvs_my_list_page_id));
        $wpvs_my_list_page_default = $wpvs_my_list_page_id;
    }

    $wpvs_my_list_page_args = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'exclude' => $wpvs_my_list_page_id
    );

    $wpvs_my_list_other_pages = get_pages($wpvs_my_list_page_args);
    $sign_in_page_options = array('default' => 'Default Login Page');

    if( ! empty($wpvs_my_list_other_pages) ) {
        foreach($wpvs_my_list_other_pages as $site_page) {
            $sign_in_page_options["$site_page->ID"] = $site_page->post_title;
        }
    }

    $wp_customize->add_setting( 'wpvs_login_link' , array(
        'default'     => 'default',
        'transport'   => 'refresh'
    ) );

    $wp_customize->add_control( 'wpvs_login_link', array(
        'label'        => __( 'Sign In Link', 'wpvs-theme' ),
        'type' => 'select',
        'choices'  => $sign_in_page_options,
        'description' => __( 'Where the Sign In button takes users to login.', 'wpvs-theme' ),
        'section'    => 'vs_header'
    ) );

   if ( has_nav_menu( 'user' ) ) {
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term( $theme_locations['user'], 'nav_menu' );
        $user_menu_name = $menu_obj->name;
    } else {
        $user_menu_name = '(No User Menu created)';
    }

    $user_menu_options = array('default' => 'Default', 'user' => $user_menu_name);

    $wp_customize->add_setting( 'wpvs_user_menu' , array(
        'default'     => 'default',
        'transport'   => 'refresh'
    ) );

    $wp_customize->add_control( 'wpvs_user_menu', array(
        'label'        => __( 'User Menu', 'wpvs-theme' ),
        'type' => 'select',
        'choices'  => $user_menu_options,
        'description' => 'Default or custom menu for the User drop down menu. To use a custom menu, please <a href="'.admin_url('nav-menus.php?action=edit&menu=0').'">create a new menu</a> with the Display location set to <strong>User Menu</strong>.',
        'section'    => 'vs_header'
    ) );

    $wp_customize->add_setting( 'vs_user_menu_link_first', array(
      'capability' => 'edit_theme_options',
      'default' => 'Account',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('vs_user_menu_link_first', array(
      'label' => __( 'User Menu Link Texts', 'wpvs-theme' ),
      'type' => 'text',
      'description' => __( 'User Menu text links in order (Default Menu only)', 'wpvs-theme' ),
      'section' => 'vs_header'
    ) );

    $wpvs_check_my_list_enabled = get_theme_mod('wpvs_my_list_enabled', 1);

    if($wpvs_check_my_list_enabled) {
        $wp_customize->add_setting( 'wpvs_user_menu_list_link', array(
          'capability' => 'edit_theme_options',
          'default' => 'My List',
          'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control('wpvs_user_menu_list_link', array(
          'type' => 'text',
          'section' => 'vs_header'
        ) );
    }

    $wp_customize->add_setting( 'vs_user_menu_link_second', array(
      'capability' => 'edit_theme_options',
      'default' => 'Rentals',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('vs_user_menu_link_second', array(
      'type' => 'text',
      'section' => 'vs_header'
    ) );

    $wp_customize->add_setting( 'vs_user_menu_link_third', array(
      'capability' => 'edit_theme_options',
      'default' => 'Purchases',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('vs_user_menu_link_third', array(
      'type' => 'text',
      'section' => 'vs_header'
    ) );

    $wp_customize->add_setting( 'vs_user_menu_link_fourth', array(
      'capability' => 'edit_theme_options',
      'default' => 'Logout',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('vs_user_menu_link_fourth', array(
      'type' => 'text',
      'section' => 'vs_header'
    ) );

    $wp_customize->add_setting( 'vs_primary_menu_home', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('vs_primary_menu_home', array(
        'label' => __( 'Hide primary menu on home page', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_header'
    ));

    $wp_customize->add_setting( 'vs_hide_search', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('vs_hide_search', array(
        'label' => __( 'Hide search', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_header'
    ));

    /* == TYPOGRAPHY == */

    $all_google_fonts = wpvs_load_google_fonts_in_customizer();

    $wp_customize->add_section( 'wpvs_typography_settings', array(
      'title' => __( 'Typography', 'wpvs-theme' ),
      'description' => __( 'Customize your website fonts. <a href="https://fonts.google.com/" target="_blank">Browse Fonts</a>', 'wpvs-theme' ),
      'priority' => 41,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_disable_font_output', array(
      'capability' => 'edit_theme_options',
      'transport'   => 'refresh',
      'default' => 0,
    ) );

    $wp_customize->add_control('wpvs_disable_font_output', array(
      'label' => __( 'Disable Fonts', 'wpvs-theme' ),
      'type' => 'checkbox',
      'description' => __( 'Disable fonts from loading', 'wpvs-theme' ),
      'section' => 'wpvs_typography_settings',
    ) );

    $wp_customize->add_setting( 'wpvs_body_font', array(
      'capability' => 'edit_theme_options',
      'transport'   => 'refresh',
      'default' => 'Open Sans',
    ) );

    $wp_customize->add_control('wpvs_body_font', array(
      'label' => __( 'Primary Font', 'wpvs-theme' ),
      'type' => 'select',
      'description' => __( 'Main content font (body, p, a, ul, etc)', 'wpvs-theme' ),
      'section' => 'wpvs_typography_settings',
      'choices' => $all_google_fonts
    ) );

    $wp_customize->add_setting( 'wpvs_heading_font', array(
      'capability' => 'edit_theme_options',
      'transport'   => 'refresh',
      'default' => 'Open Sans',
    ) );

    $wp_customize->add_control('wpvs_heading_font', array(
      'label' => __( 'Headings Font', 'wpvs-theme' ),
      'type' => 'select',
      'description' => __( 'H1, H2, H3, H4, H5 and H6', 'wpvs-theme' ),
      'section' => 'wpvs_typography_settings',
      'choices' => $all_google_fonts
    ) );

    /* == Featured Area Home Page == */

    $wp_customize->add_section( 'vs_slider', array(
      'title' => __( 'Featured Area Sliders', 'wpvs-theme' ),
      'description' => __( 'Home page slider customization.', 'wpvs-theme' ),
      'priority' => 42,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'vs_slide_speed', array(
        'capability' => 'edit_theme_options',
        'default' => '4000',
        'sanitize_callback' => 'wpvstheme_sanitize_select',
    ) );

    $wp_customize->add_control('vs_slide_speed', array(
        'label' => __( 'Slide Speed', 'wpvs-theme' ),
        'type' => 'select',
        'description' => __( 'Change the home page featured slides speed', 'wpvs-theme' ),
        'section' => 'vs_slider',
        'choices' => array(
            '0'    => __( 'Disable Automatic Sliding', 'wpvs-theme'),
            '1000' => __( '1 Second', 'wpvs-theme' ),
            '1500' => __( '1.5 Seconds', 'wpvs-theme' ),
            '2000' => __( '2 Seconds', 'wpvs-theme' ),
            '2500' => __( '3.5 Seconds', 'wpvs-theme' ),
            '3000' => __( '3 Seconds', 'wpvs-theme' ),
            '3500' => __( '3.5 Seconds', 'wpvs-theme' ),
            '4000' => __( '4 Seconds', 'wpvs-theme' ),
            '4500' => __( '4.5 Seconds', 'wpvs-theme' ),
            '5000' => __( '5 Seconds', 'wpvs-theme' ),
            '5500' => __( '5.5 Seconds', 'wpvs-theme' ),
            '6000' => __( '6 Seconds', 'wpvs-theme' ),
            '6500' => __( '6.5 Seconds', 'wpvs-theme' ),
            '7000' => __( '7 Seconds', 'wpvs-theme' ),
            '7500' => __( '7.5 Seconds', 'wpvs-theme' ),
            '8000' => __( '8 Seconds', 'wpvs-theme' ),
            '8500' => __( '8.5 Seconds', 'wpvs-theme' ),
            '9000' => __( '9 Seconds', 'wpvs-theme' ),
            '9500' => __( '9.5 Seconds', 'wpvs-theme' ),
            '10000' => __( '10 Seconds', 'wpvs-theme' ),
        )
    ) );

    $wp_customize->add_setting( 'vs_slide_gradient', array(
      'capability' => 'edit_theme_options',
      'default' => '8',
      'sanitize_callback' => 'wpvstheme_sanitize_select',
    ) );

    $wp_customize->add_control('vs_slide_gradient', array(
        'label' => __( 'Slide Gradient Overlay', 'wpvs-theme' ),
        'type' => 'select',
        'description' => __( 'Change the featured area slides overlay intensity', 'wpvs-theme' ),
        'section' => 'vs_slider',
        'choices' => array(
            '0' => __( 'No overlay', 'wpvs-theme' ),
            '1' => __( '0.1', 'wpvs-theme' ),
            '2' => __( '0.2', 'wpvs-theme' ),
            '3' => __( '0.3', 'wpvs-theme' ),
            '4' => __( '0.4', 'wpvs-theme' ),
            '5' => __( '0.5', 'wpvs-theme' ),
            '6' => __( '0.6', 'wpvs-theme' ),
            '7' => __( '0.7', 'wpvs-theme' ),
            '8' => __( '0.8', 'wpvs-theme' ),
            '9' => __( '0.9', 'wpvs-theme' )
        )
    ) );

    $wp_customize->add_setting( 'vs_slide_content_blend', array(
      'capability' => 'edit_theme_options',
      'default' => '0',
      'sanitize_callback' => 'wpvstheme_sanitize_select',
    ) );

    $wp_customize->add_control('vs_slide_content_blend', array(
        'label' => __( 'Slide Content Blend', 'wpvs-theme' ),
        'type' => 'select',
        'description' => __( 'Enable / Disable the content blend overlay at the bottom of slides.', 'wpvs-theme' ),
        'section' => 'vs_slider',
        'choices' => array(
            '0' => __( 'Disabled', 'wpvs-theme' ),
            '1' => __( 'Enabled', 'wpvs-theme' )
        )
    ) );

    $wp_customize->add_setting( 'wpvs_featured_slides_hover', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'default' => 1,
    ) );

    $wp_customize->add_control('wpvs_featured_slides_hover', array(
        'label' => __( 'Pause Featured Area slides on mouse hover', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_slider',
        'description' => __( 'Enables / Disables the pause on hover for Featured Area sliders.', 'wpvs-theme' )
    ));

    $wp_customize->add_section( 'vs_video_sliders', array(
      'title' => __( 'Video Sliders', 'wpvs-theme' ),
      'description' => __( 'Horizontal video navigation.', 'wpvs-theme' ),
      'priority' => 43,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'vs_videos_per_slider', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 10,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('vs_videos_per_slider', array(
        'label' => __( 'Videos per slider', 'wpvs-theme' ),
        'type' => 'number',
        'section' => 'vs_video_sliders',
        'description' => __( 'How many videos to load in horizontal browsing sliders', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_disable_lazy_load_slide_images', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'default' => 0,
    ));

    $wp_customize->add_control('wpvs_disable_lazy_load_slide_images', array(
        'label' => __( 'Disable Slide Image Lazy Load', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_video_sliders',
    ));

    $wp_customize->add_setting( 'wpvs_show_see_all_link_about_sliders', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'default' => 0,
    ));

    $wp_customize->add_control('wpvs_show_see_all_link_about_sliders', array(
        'label' => __( 'Display See All Link Above Sliders', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_video_sliders',
    ));

    $wp_customize->add_setting( 'wpvs_visible_slide_count_large', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 6,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_visible_slide_count_large', array(
        'label' => __( 'Visible Thumbnails (Large Screens)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on large screens (1600px or more)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_visible_slide_count_desktop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 5,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_visible_slide_count_desktop', array(
        'label' => __( 'Visible Thumbnails (Desktop)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 9
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on desktop screens (1200px - 1600px)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_visible_slide_count_laptop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 4,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_visible_slide_count_laptop', array(
        'label' => __( 'Visible Thumbnails (Laptop)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on laptop screens (960px - 1200px)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_visible_slide_count_tablet', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 3,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_visible_slide_count_tablet', array(
        'label' => __( 'Visible Thumbnails (Tablet)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 7
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on tablet screens (600px - 960px)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_visible_slide_count_mobile', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 2,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_visible_slide_count_mobile', array(
        'label' => __( 'Visible Thumbnails (Mobile)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6
          ),
        'section' => 'vs_video_sliders',
        'description' => __( 'How many thumbnails are visible on mobile screens (600px or smaller)', 'wpvs-theme' )
    ));


    /* == VIDEO LISTINGS (ARCHIVES) == */

    $wp_customize->add_section( 'vs_video_listings', array(
      'title' => __( 'Video Browsing', 'wpvs-theme' ),
      'description' => __( 'Default video browsing pages settings', 'wpvs-theme' ),
      'priority' => 44,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_browsing_layout', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'grid',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('wpvs_browsing_layout', array(
        'label' => __( 'Browsing Layout', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'grid' => __( 'Grid', 'wpvs-theme' ),
            'sliders' => __( 'Sliders', 'wpvs-theme' )
        ),
        'section' => 'vs_video_listings',
        'description' => __( 'Video browsing pages layout.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_grid_count_large', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 6,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_grid_count_large', array(
        'label' => __( 'Visible Thumbnails (Large)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on large screens (1600px or larger)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_grid_count_desktop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 5,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_grid_count_desktop', array(
        'label' => __( 'Visible Thumbnails (Desktop)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 9
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on desktop screens (1200px - 1600px)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_grid_count_laptop', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 4,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_grid_count_laptop', array(
        'label' => __( 'Visible Thumbnails (Laptop)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on laptop screens (960px - 1200px)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_grid_count_tablet', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 3,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_grid_count_tablet', array(
        'label' => __( 'Visible Thumbnails (Tablet)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 7
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on tablet screens (600px - 960px)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_grid_count_mobile', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 2,
        'sanitize_callback' => 'wpvs_theme_sanitize_number'
    ));

    $wp_customize->add_control('wpvs_grid_count_mobile', array(
        'label' => __( 'Visible Thumbnails (Mobile)', 'wpvs-theme' ),
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6
          ),
        'section' => 'vs_video_listings',
        'description' => __( 'How many thumbnails per row on mobile screens (600px or smaller)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'vs_video_drop_details', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('vs_video_drop_details', array(
        'label' => __( 'Drop Down Video Details', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Display video details below video slides and rows.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'vs_video_slide_hover_effect', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('vs_video_slide_hover_effect', array(
        'label' => __( 'Video Thumbnail Hover Effect', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Expand video thumbnails on hover. <em>(Larger screen sizes only)</em>', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_video_slide_info_position', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'default' => 'overlay',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('wpvs_video_slide_info_position', array(
        'label' => __( 'Video Thumbnail Info Position', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'overlay' => __( 'Overlay', 'wpvs-theme' ),
            'below' => __( 'Below', 'wpvs-theme' )
        ),
        'section' => 'vs_video_listings',
        'description' => __( 'Display video information over top or below thumbnail images.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_video_slide_info_height', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wpvs_theme_sanitize_number',
        'default' => 33,
        )
    );

    $wp_customize->add_control( 'wpvs_video_slide_info_height', array(
      'type' => 'number',
      'input_attrs' => array(
        'min' => 0,
        'max' => 100
      ),
      'section' => 'vs_video_listings',
      'label' => __( 'Info Height', 'wpvs-theme' ),
      'description' => __( 'Set the height of the short description below video slide thumbnails (in px).', 'wpvs-theme' ),
    ) );

    $wp_customize->add_setting( 'vs_thumbnail_style', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'landscape',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('vs_thumbnail_style', array(
        'label' => __( 'Video thumbnail style', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'landscape' => __( 'Landscape (640px by 360px)', 'wpvs-theme' ),
            'portrait' => __( 'Portrait (380px by 590px)', 'wpvs-theme' ),
            'custom' => __( 'Custom Size', 'wpvs-theme' )
        ),
        'section' => 'vs_video_listings',
        'description' => __( 'Video thumbnail image style. If you use a <strong>Custom Size</strong>, any time you change your custom width or height, you will need to <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">regenerate your thumbnail images</a>.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_custom_thumbnail_size_width', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('wpvs_custom_thumbnail_size_width', array(
      'type' => 'number',
      'input_attrs' => array(
        'min' => 100,
        'max' => 1920
      ),
      'description' => __( 'Custom thumbnail size width', 'wpvs-theme' ),
      'section' => 'vs_video_listings'
    ) );

    $wp_customize->add_setting( 'wpvs_custom_thumbnail_size_height', array(
      'capability' => 'edit_theme_options',
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('wpvs_custom_thumbnail_size_height', array(
      'type' => 'number',
      'input_attrs' => array(
        'min' => 100,
        'max' => 1920
      ),
      'description' => __( 'Custom thumbnail size height', 'wpvs-theme' ),
      'section' => 'vs_video_listings'
    ) );

    $wp_customize->add_setting( 'wpvs_slide_mobile_display', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('wpvs_slide_mobile_display', array(
        'label' => __( 'Mobile Device Display', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Always show titles and arrows on mobile devices.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_profile_browsing', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('wpvs_profile_browsing', array(
        'label' => __('Enable', 'wpvs-theme') . ' ' . $wpvs_actor_slug_settings['name'] . ' / ' . $wpvs_director_slug_settings['name'] . ' ' . __('Profiles', 'wpvs-theme'),
        'type' => 'checkbox',
        'section' => 'vs_video_listings',
        'description' => __( 'Display profile photos and details.', 'wpvs-theme' )
    ));

    /* == SINGLE VIDEO PAGE == */

    $wp_customize->add_section( 'vs_single_video', array(
      'title' => __( 'Video Page Settings', 'wpvs-theme' ),
      'description' => __( 'Default video page settings', 'wpvs-theme' ),
      'priority' => 45,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'vs_single_layout', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'netflix',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('vs_single_layout', array(
        'label' => __( 'Layout', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'standard' => __( 'Standard', 'wpvs-theme' ),
            'netflix' => __( 'Netflix', 'wpvs-theme' ),
            'youtube' => __( 'YouTube', 'wpvs-theme' )
        ),
        'section' => 'vs_single_video',
        'description' => __( 'Default video page layout.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_show_related_videos', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('wpvs_show_related_videos', array(
        'label' => __( 'Show Related Videos', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Display related videos below Netflix layout.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_show_more_videos_below_standard', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('wpvs_show_more_videos_below_standard', array(
        'label' => __( 'Show More Videos Below Content', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Display additional videos below Standard and YouTube layout.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_related_videos_count', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wpvs_theme_sanitize_number',
        'default' => 7
    ));

    $wp_customize->add_control('wpvs_related_videos_count', array(
        'label' => __( '# of Related videos', 'wpvs-theme' ),
        'type' => 'number',
        'section' => 'vs_single_video',
        'description' => __( 'The number of related videos to display.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'vs_show_recently_added', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('vs_show_recently_added', array(
        'label' => __( 'Show Recently Added Videos', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Display recently added videos below Netflix layout.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_recently_added_count', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wpvs_theme_sanitize_number',
        'default' => 7
    ));

    $wp_customize->add_control('wpvs_recently_added_count', array(
        'label' => __( '# of Recently added videos', 'wpvs-theme' ),
        'type' => 'number',
        'section' => 'vs_single_video',
        'description' => __( 'The number of recently added videos to display.', 'wpvs-theme' )
    ));


    $wp_customize->add_setting( 'vs_moving_background', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('vs_moving_background', array(
        'label' => __( 'Enable shifting video background', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'When the screen size is smaller than the video featured image, the image will slowly pan across the screen. (Preview on mobile device below)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_full_screen_video', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('wpvs_full_screen_video', array(
        'label' => __( 'Full Screen Video', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Video players are full width of the screen when played. (Netflix video layout only)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_open_in_full_screen', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('wpvs_open_in_full_screen', array(
        'label' => __( 'Open In Full Screen', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'vs_single_video',
        'description' => __( 'Open videos in full screen on when thumbnail is pressed. (Netflix video layout only)', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'vs_single_access_layout', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'standard',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('vs_single_access_layout', array(
        'label' => __( 'Video Access Style', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'standard' => __( 'Standard', 'wpvs-theme' ),
            'fullwidth' => __( 'Full Screen', 'wpvs-theme' )
        ),
        'section' => 'vs_single_video',
        'description' => __( '(<a href="https://www.wpvideosubscriptions.com/video-memberships/" target="_blank">WP Video Memberships</a> only) How the video page displays for users without access. If you are using the Netflix layout above, we recommend using Standard for this.', 'wpvs-theme' )
    ));

    /* == VIDEO REVIEWS == */

    $wp_customize->add_section( 'wpvs_video_reviews', array(
      'title' => __( 'Video Reviews', 'wpvs-theme' ),
      'description' => __( 'Video reviews and ratings. (Reviews use default WordPress comments)', 'wpvs-theme' ),
      'priority' => 46,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_video_review_ratings', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('wpvs_video_review_ratings', array(
        'label' => __( 'Enable 5 Star Ratings', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'wpvs_video_reviews',
        'description' => __( 'Enable / Disable 5 star ratings for videos.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_star_review_color' , array(
        'default'     => '#ffd700',
        'transport'   => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'Stars Color', array(
        'label'        => __( 'Star Ratings Color', 'wpvs-theme' ),
        'section'    => 'wpvs_video_reviews',
        'settings'   => 'wpvs_star_review_color',
    ) ) );

    $wp_customize->add_setting( 'wpvs_video_review_show_author', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('wpvs_video_review_show_author', array(
        'label' => __( 'Display Review Author', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'wpvs_video_reviews',
        'description' => __( 'Show / Hide review authors photo and username', 'wpvs-theme' )
    ));

    /* == MY LIST == */

    $wp_customize->add_section( 'wpvs_my_list_settings', array(
      'title' => __( 'My List', 'wpvs-theme' ),
      'description' => __( 'My List settings', 'wpvs-theme' ),
      'priority' => 47,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_my_list_enabled', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('wpvs_my_list_enabled', array(
        'label' => __( 'Enabled', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'wpvs_my_list_settings',
        'description' => __( 'Turn on / off the My List feature. Allows users to save videos to their list.', 'wpvs-theme' )
    ));


    if( ! empty($wpvs_my_list_other_pages) ) {
        foreach($wpvs_my_list_other_pages as $site_page) {
            $wpvs_select_my_list_pages["$site_page->ID"] = $site_page->post_title;
        }
    }

    $wp_customize->add_setting( 'wpvs_my_list_page' , array(
        'default'     => $wpvs_my_list_page_default,
        'transport'   => 'refresh'
    ) );

    $wp_customize->add_control( 'wpvs_my_list_page', array(
        'label'        => __( 'My List Page', 'wpvs-theme' ),
        'type' => 'select',
        'choices'  => $wpvs_select_my_list_pages,
        'description' => __( 'The page that users My List videos will display. <em>Include <strong>[rvs_user_my_list]</strong> shortcode on page</em>', 'wpvs-theme' ),
        'section'    => 'wpvs_my_list_settings'
    ) );

    $wp_customize->add_setting( 'wpvs_my_list_show_on_home' , array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ) );

    $wp_customize->add_control( 'wpvs_my_list_show_on_home', array(
        'label'        => __( 'Show on Homepage', 'wpvs-theme' ),
        'type' => 'checkbox',
        'description' => __( 'Displays logged in users saved videos on the Front Page when using the Default page template.', 'wpvs-theme' ),
        'section'    => 'wpvs_my_list_settings'
    ) );

    $wp_customize->add_setting( 'wpvs_my_list_home_title', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => __( 'My List', 'wpvs-theme' ),
        )
    );

    $wp_customize->add_control( 'wpvs_my_list_home_title', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( 'My List', 'wpvs-theme' ),
      ),
      'section' => 'wpvs_my_list_settings',
      'label' => __( 'My List Title', 'wpvs-theme' ),
      'description' => __( 'Change the title above the My List slider.', 'wpvs-theme' ),
    ) );

    /* == BUTTONS == */

    $wp_customize->add_section( 'wpvs_button_options', array(
      'title' => __( 'Buttons', 'wpvs-theme' ),
      'description' => __( 'Buttons Settings: For more customization, use the <a href="/wp-admin/customize.php?autofocus[section]=advanced_custom">Advanced</a> area.', 'wpvs-theme' ),
      'priority' => 48,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_button_style', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'solid',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('wpvs_button_style', array(
        'label' => __( 'Button Style', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'solid' => __( 'Solid', 'wpvs-theme' ),
            'hollow' => __( 'Hollow', 'wpvs-theme' )
        ),
        'section' => 'wpvs_button_options',
        'description' => __( 'Changes the appearance of buttons.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_button_radius', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '',
        )
    );

    $wp_customize->add_control( 'wpvs_button_radius', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( '5px', 'wpvs-theme' ),
      ),
      'section' => 'wpvs_button_options',
      'label' => __( 'Button Border Radius', 'wpvs-theme' ),
      'description' => __( 'Change the border radius of buttons', 'wpvs-theme' ),
    ) );

    $wp_customize->add_setting( 'wpvs_button_padding_top_bottom', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '6px',
        )
    );

    $wp_customize->add_control( 'wpvs_button_padding_top_bottom', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( '6px', 'wpvs-theme' ),
      ),
      'section' => 'wpvs_button_options',
      'label' => __( 'Button Padding (Top/Bottom)', 'wpvs-theme' ),
      'description' => __( 'Change the top and bottom padding of buttons', 'wpvs-theme' ),
    ) );

    $wp_customize->add_setting( 'wpvs_button_padding_left_right', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '12px',
        )
    );

    $wp_customize->add_control( 'wpvs_button_padding_left_right', array(
      'type' => 'text',
      'input_attrs' => array(
          'placeholder' => __( '12px', 'wpvs-theme' ),
      ),
      'section' => 'wpvs_button_options',
      'label' => __( 'Button Padding (Left/Right)', 'wpvs-theme' ),
      'description' => __( 'Change the left and right padding of buttons', 'wpvs-theme' ),
    ) );

    $wp_customize->add_setting( 'wpvs_play_button', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'standard',
        'sanitize_callback' => 'wpvstheme_sanitize_select'
    ));

    $wp_customize->add_control('wpvs_play_button', array(
        'label' => __( 'Play Buttons', 'wpvs-theme' ),
        'type' => 'select',
        'choices' => array(
            'standard' => __( 'Standard', 'wpvs-theme' ),
            'play-icon' => __( 'Large Play Icon', 'wpvs-theme' )
        ),
        'section' => 'wpvs_button_options',
        'description' => __( 'Displays on Netflix video pages and the drop down browsing section.', 'wpvs-theme' )
    ));

    $wp_customize->add_setting( 'wpvs_watch_now_text', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 'Watch Now'
    ));

    $wp_customize->add_control('wpvs_watch_now_text', array(
        'label' => __( 'Button text for drop down video details', 'wpvs-theme' ),
        'type' => 'text',
        'section' => 'wpvs_button_options'
    ));

    /* == LOGIN PAGE == */

    $wp_customize->add_section( 'wpvs_custom_login_settings', array(
      'title' => __( 'Login Page', 'wpvs-theme' ),
      'description' => __( 'Customize your themes Login page', 'wpvs-theme' ),
      'priority' => 49,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_theme_login_background', array(
        'sanitize_callback' => 'sanitize_rogue_logo'
        )
    );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'body_background_image', array(
        'label'    => __( 'Background Image', 'wpvs-theme' ),
        'section'  => 'wpvs_custom_login_settings',
        'settings' => 'wpvs_theme_login_background',
        )
    ) );

    $wp_customize->add_setting( 'wpvs_hide_login_register_link', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('wpvs_hide_login_register_link', array(
        'label' => __( 'Hide Register Link', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'wpvs_custom_login_settings'
    ));

    /* == FOOTER SECTION == */

    $wp_customize->add_section( 'wpvs_theme_footer', array(
      'title' => __( 'Footer', 'wpvs-theme' ),
      'description' => __( 'Footer area customization.', 'wpvs-theme' ),
      'priority' => 50,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_theme_footer_copyright_text', array(
      'capability'        => 'edit_theme_options',
      'type'              => 'option',
      'default'           => '&copy; '.get_bloginfo('name').' '.date('Y'),
      'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control('wpvs_theme_footer_copyright_text', array(
      'label' => __( 'Copyright Text', 'wpvs-theme' ),
      'type' => 'text',
      'description' => __( 'Footer copyright text', 'wpvs-theme' ),
      'section' => 'wpvs_theme_footer'
    ) );

    /* ==== ADVANCED ==== */

    $wp_customize->add_section( 'advanced_custom', array(
      'title' => __( 'Advanced', 'wpvs-theme' ),
      'description' => __( 'Add custom CSS and JS.', 'wpvs-theme' ),
      'priority' => 160,
      'capability' => 'edit_theme_options'
    ) );

    $wp_customize->add_setting( 'wpvs_load_gutenberg_css', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ) );

    $wp_customize->add_control('wpvs_load_gutenberg_css', array(
        'label' => __( 'Load Theme Gutenberg CSS', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'advanced_custom'
    ));

    $wp_customize->add_setting( 'wpvs_theme_show_scrollbars', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ) );

    $wp_customize->add_control('wpvs_theme_show_scrollbars', array(
        'label' => __( 'Show Scrollbars', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'advanced_custom'
    ));

    $wp_customize->add_setting( 'wpvs_theme_enable_smoothscroll', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ) );

    $wp_customize->add_control('wpvs_theme_enable_smoothscroll', array(
        'label' => __( 'Enable Smooth Scrolling', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'advanced_custom'
    ));

    $wp_customize->add_setting( 'custom_css', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
      'sanitize_callback' => 'sanitize_custom_wpvstheme_css'
    ) );

    $wp_customize->add_setting( 'custom_js', array(
      'type' => 'theme_mod', // or 'option'
      'capability' => 'edit_theme_options',
      'transport' => 'refresh',
      'sanitize_callback' => 'sanitize_custom_wpvstheme_js'
    ) );

    if( class_exists('WP_Customize_Code_Editor_Control') ) {

        $wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'custom_css', array(
              'label' => __( 'Custom Theme CSS', 'wpvs-theme' ),
              'code_type' => 'css',
              'description' => __( 'Do not include "style" tags.', 'wpvs-theme' ),
                'settings' => 'custom_css',
              'section' => 'advanced_custom'
            )
        ) );

        $wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'custom_js', array(
              'label' => __( 'Custom Theme JS', 'wpvs-theme' ),
              'code_type' => 'javascript',
              'description' => __( 'Do not include "script" tags.', 'wpvs-theme' ),
                'settings' => 'custom_js',
              'section' => 'advanced_custom'
            )
        ) );
    }

    $wp_customize->add_setting( 'wpvs_show_recently_added', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 0
    ));

    $wp_customize->add_control('wpvs_show_recently_added', array(
        'label' => __( 'Show Recently Added Videos', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'static_front_page'
    ));

    $wp_customize->add_setting( 'wpvs_show_continue_watching', array(
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'default' => 1
    ));

    $wp_customize->add_control('wpvs_show_continue_watching', array(
        'label' => __( 'Show Continue Watching', 'wpvs-theme' ),
        'type' => 'checkbox',
        'section' => 'static_front_page'
    ));

    // WPVS MEMBERSHIPS

    if( wpvs_check_for_membership_add_on() ) {

        $wp_customize->add_section( 'wpvs_membership_settings', array(
          'title' => __( 'WPVS Memberships', 'wpvs-theme' ),
          'description' => __( 'Customize content for the WP Video Memberships sections in your theme.', 'wpvs-theme' ),
          'priority' => 60,
          'capability' => 'edit_theme_options'
        ) );

        $wp_customize->add_setting( 'wpvs_enable_pricing_text', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => 0,
            'type' => 'option'
        ));

        $wp_customize->add_control('wpvs_enable_pricing_text', array(
            'label' => __( 'Show Starting At Pricing Text', 'wpvs-theme' ),
            'type' => 'checkbox',
            'section' => 'wpvs_membership_settings',
            'description' => __( 'Displays WP Video Memberships lowest price instead of Play button on video pages when users do not have access.', 'wpvs-theme' ),
        ));

        $wp_customize->add_setting( 'wpvs_price_start_at_text', array(
          'capability' => 'edit_theme_options',
          'default' => __( 'From', 'wpvs-theme' ),
          'sanitize_callback' => 'sanitize_text_field',
          'type' => 'option',
        ) );

        $wp_customize->add_control('wpvs_price_start_at_text', array(
          'label' => __( 'Prices starting at text', 'wpvs-theme' ),
          'type' => 'text',
          'section' => 'wpvs_membership_settings'
        ) );
    }

}
add_action( 'customize_register', 'wpvs_theme_customizer_init' );

function wpvs_save_theme_global_settings() {
    update_option('wpvs_my_list_page', get_theme_mod('wpvs_my_list_page'));
}
add_action( 'customize_save_after', 'wpvs_save_theme_global_settings' );

/* ==== CUSTOM THEME OUTPUT ==== */
function wpvs_theme_custom_css_settings_output() {
    $theme_accent_colour = get_theme_mod('accent_color', '#E50914');
    $slide_gradient_rgb_color = array();
    $slider_overlay = get_theme_mod('vs_slide_gradient', '8');
    $slider_overlay = floatval($slider_overlay*0.1);
    $video_slide_content_blend = get_theme_mod('vs_slide_content_blend', '0');
    $colour_style = get_theme_mod('style_color', 'dark');
    if( $colour_style == 'light' ) {
      $slide_gradient_color = get_theme_mod('vs_slide_gradient_color', '#ffffff');
      $featured_area_content_color = get_theme_mod('featured_area_content_color', '#141414' );
    } else {
      $slide_gradient_color = get_theme_mod('vs_slide_gradient_color', '#000000');
      $featured_area_content_color = get_theme_mod('featured_area_content_color', '#eeeeee' );
    }
    $slide_gradient_rgb_color = wpvs_theme_convert_hex_to_rgb($slide_gradient_color);
    $slide_gradient_rgb_color[] = $slider_overlay;
    $wpvs_button_style = get_theme_mod('wpvs_button_style', 'solid');
    $wpvs_button_radius = get_theme_mod('wpvs_button_radius', 0);
    $wpvs_button_padding_top_bottom = get_theme_mod('wpvs_button_padding_top_bottom', '6px');
    $wpvs_button_padding_left_right = get_theme_mod('wpvs_button_padding_left_right', '12px');
    $wpvs_button_font_size = get_theme_mod('wpvs_button_font_size', '12px');
    $play_button_setting = get_theme_mod( 'wpvs_play_button', 'standard');
    $wpvs_full_screen_video = get_theme_mod( 'wpvs_full_screen_video', 1);
    $wpvs_star_ratings_color = get_theme_mod('wpvs_star_review_color', '#ffd700');
    $wpvs_disable_font_loading = get_theme_mod('wpvs_disable_font_output', 0);
    $wpvs_headings_font = get_theme_mod('wpvs_heading_font', 'Open Sans');
    $wpvs_body_font = get_theme_mod('wpvs_body_font', 'Open Sans');
    $wpvs_mobile_logo_height = get_theme_mod('wpvs_mobile_logo_height', '40');
    $wpvs_desktop_logo_height = get_theme_mod('wpvs_desktop_logo_height', '50');
    $wpvs_mobile_page_margin = intval($wpvs_mobile_logo_height) + 40;
    $wpvs_desktop_page_margin = intval($wpvs_desktop_logo_height) + 50;
    $wpvs_grid_large_item_count = get_theme_mod('wpvs_grid_count_large', '6');
    $wpvs_grid_desktop_item_count = get_theme_mod('wpvs_grid_count_desktop', '5');
    $wpvs_grid_laptop_item_count = get_theme_mod('wpvs_grid_count_laptop', '4');
    $wpvs_grid_tablet_item_count = get_theme_mod('wpvs_grid_count_tablet', '3');
    $wpvs_grid_mobile_item_count = get_theme_mod('wpvs_grid_count_mobile', '2');
    $wpvs_grid_large_width = wpvs_get_css_width_percentage( $wpvs_grid_large_item_count) ;
    $wpvs_grid_desktop_width = wpvs_get_css_width_percentage( $wpvs_grid_desktop_item_count );
    $wpvs_grid_laptop_width = wpvs_get_css_width_percentage( $wpvs_grid_laptop_item_count );
    $wpvs_grid_tablet_width = wpvs_get_css_width_percentage( $wpvs_grid_tablet_item_count );
    $wpvs_grid_mobile_width = wpvs_get_css_width_percentage( $wpvs_grid_mobile_item_count );
    $wpvs_slide_info_position = get_option('wpvs_video_slide_info_position', 'overlay');
    $wpvs_video_slide_info_height = get_option('wpvs_video_slide_info_height', 33);
    $wpvs_theme_show_scrollbars = get_theme_mod('wpvs_theme_show_scrollbars', 0);

    ?>
     <style type="text/css">
     <?php if( ! $wpvs_theme_show_scrollbars ) { ?>
         * {
           -ms-overflow-style: none;
           scrollbar-width: none;
         }

         *::-webkit-scrollbar {
           display: none;
           width: 0;
           background:transparent;
         }
     <?php } ?>
a, header#header nav#desktop ul li:hover > a, header#header nav#desktop ul li:hover > .menuArrow, footer a:hover, #sidebar ul li a:hover, #vs-video-back .dashicons, .vs-video-details h1, #wpvs-updating-box .wpvs-loading-text, header#header #logo #site-title,
header#header nav#desktop ul.sub-menu li a:hover, h2.sliderTitle, .vs-text-color, .vs-tax-result:hover, #vs-open-search:hover, #close-wpvs-search:hover, .vs-drop-play-button:hover > .dashicons, h3.drop-title, .show-vs-drop:hover, .socialmedia a:hover, .wpvs-menu-item:hover, .wpvs-menu-item.active, a.sub-video-cat:hover,
a.sub-video-cat.active, a.wpvs-purchase-term-link:hover, .rvs-access-tab:hover

{ color: <?php echo $theme_accent_colour; ?>; }

.wpvs-video-rating-star.dashicons:hover, .wpvs-video-rating-star.dashicons.active, .wpvs-video-rating-star.dashicons.setactive, .wpvs-video-rating-star-complete.dashicons.active, a.wpvs-review-anchor {color: <?php echo $wpvs_star_ratings_color ?>;}

.vs-video-details, .vs-video-details p, .sliderDescription p, .vs-drop-details, .vs-drop-details p {
  color: <?php echo $featured_area_content_color; ?>
}

/* BACKGROUNDS */

nav#mobile a:hover, .navigation span.current, .navigation a:hover, #searchform input[type="submit"], #wpvs-updating-box .loadingCircle, .loadingCircle, .net-loader, .net-loader:before, nav#mobile a.sign-in-link, header#header nav#desktop ul li a.sign-in-link, #single-wpvstheme-video-container .mejs-controls .mejs-time-rail .mejs-time-current,
label.rental-time-left, .wpvs-full-screen-display #wpvs-cancel-next-video:hover, .button, input[type="submit"], .wp-block-button .wp-block-button__link, .rvs-button, .rvs-membership-item .rvs-button, .rvs-area .rvs-button, .rvs-primary-button, a.rvs-primary-button, .wpvs-cw-progress-bar, label#menuOpen:hover > span, label#menuOpen:hover > span:before,
label#menuOpen:hover > span:after, .wpvs-thumbnail-text-label

{ background: <?php echo $theme_accent_colour ?>; }

.wp-block-button.is-style-outline .wp-block-button__link {
    background: none;
    border: 2px solid <?php echo $theme_accent_colour ?>;
    color: <?php echo $theme_accent_colour ?>;
}

/* BUTTONS */
.button, .wp-block-button .wp-block-button__link, .rvs-button, .rvs-membership-item .rvs-button, .rvs-area .rvs-button, .rvs-primary-button, a.rvs-primary-button, input[type="submit"] {
    border-radius: <?php echo $wpvs_button_radius; ?>;
    padding: <?php echo $wpvs_button_padding_top_bottom; ?> <?php echo $wpvs_button_padding_left_right; ?>;
}

.wpvs-thumbnail-text-label {
    border-radius: <?php echo $wpvs_button_radius; ?>;
}

<?php if($wpvs_button_style == 'hollow') { ?>
.button, .wp-block-button .wp-block-button__link, .rvs-button, .rvs-membership-item .rvs-button, .rvs-area .rvs-button, .rvs-primary-button, a.rvs-primary-button, input[type="submit"] {
    border: 1px solid <?php echo $theme_accent_colour; ?>;
    background:none;
}
<?php } ?>

.net-loader {
background: -moz-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: -webkit-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: -o-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: -ms-linear-gradient(left, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
background: linear-gradient(to right, <?php echo $theme_accent_colour ?> 10%, rgba(255, 255, 255, 0) 42%);
}
<?php if( ! $wpvs_disable_font_loading ) { ?>
h1, h2, h3, h4, h5, h6 {
font-family: <?php echo $wpvs_headings_font; ?>, 'Helvetica Neue', Helvetica, Arial, sans-serif;
}

body, header#header #logo #site-title {
font-family: <?php echo $wpvs_body_font; ?>, 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
<?php } ?>

.video-item {
width: <?php echo $wpvs_grid_mobile_width; ?>;
}

header#header .header-container {
    height: <?php echo $wpvs_mobile_logo_height; ?>px;
}

header#header.show-desktop-menu .header-container {
    height: <?php echo $wpvs_desktop_logo_height; ?>px;
}

.category-top {
    top: <?php echo $wpvs_mobile_page_margin; ?>px;
}

.category-top.hug-header {
    top: <?php echo $wpvs_mobile_logo_height; ?>px;
}

.video-page-container, .page-container {
    margin: <?php echo $wpvs_mobile_page_margin; ?>px 0 0;
}
<?php if( ! empty($wpvs_slide_info_position) && $wpvs_slide_info_position == 'below' ) { ?>


 .video-slide, .video-item, .video-item-content, .slick-list {
     overflow: visible;
 }

.video-slide-details {
    background: none;
    opacity: 1;
    height: auto;
    position: relative;
}

.video-slide-details p {
    margin: 0;
}

.show-vs-drop {
    background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 100%);
    background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 100%);
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.5) 60%, rgba(0,0,0,0.8) 100%);
}

<?php if( $colour_style == 'dark' ) { ?>
.video-slide:hover > .video-slide-details, .video-item:hover > .video-item-content .video-slide-details {
    background: #141414;
}
<?php } else { ?>
.video-slide:hover > .video-slide-details, .video-item:hover > .video-item-content .video-slide-details {
    background: #fafafa;
}
.video-slide-details h4, .video-slide-details p {
    color: #141414;
    text-shadow: none;
}
<?php } } else { ?>
.episode-slider .video-slide-details {
    height: auto;
}
<?php } ?>

.video-slide-details p {
    height: <?php echo $wpvs_video_slide_info_height; ?>px;
}

@media screen and (min-width: 768px) {
.category-top {
    top: <?php echo $wpvs_desktop_page_margin; ?>px;
}

.category-top.hug-header {
    top: <?php echo $wpvs_desktop_logo_height; ?>px;
}

.video-page-container, .page-container {
    margin: <?php echo $wpvs_desktop_page_margin; ?>px 0 0;
}
}

@media screen and (min-width: 600px) {
.video-item {
width: <?php echo $wpvs_grid_tablet_width; ?>;
}
}

@media screen and (min-width: 960px) {
.video-item {
width: <?php echo $wpvs_grid_laptop_width; ?>;
}
}

@media screen and (min-width: 1200px) {
.video-item {
width: <?php echo $wpvs_grid_desktop_width; ?>;
}
}

@media screen and (min-width: 1600px) {
.video-item {
width: <?php echo $wpvs_grid_large_width; ?>;
}
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_mobile_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_mobile_width; ?>;
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_tablet_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_tablet_width; ?>;
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_laptop_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_laptop_width; ?>;
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_desktop_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_desktop_width; ?>;
}

#video-list-loaded[items-per-row="<?php echo $wpvs_grid_large_item_count; ?>"] .video-item {
width: <?php echo $wpvs_grid_large_width; ?>;
}

<?php if(! empty($slide_gradient_rgb_color) ) { ?>
li.wpvs-image-flex-slide:before, .wpvs-video-flex-container:before {
background: -moz-linear-gradient(left,  rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>, <?php echo $slide_gradient_rgb_color[3]; ?>) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.1) 100%);
background: -webkit-linear-gradient(left,  rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>, <?php echo $slide_gradient_rgb_color[3]; ?>) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.1) 100%);
background: linear-gradient(to right,  rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>, <?php echo $slide_gradient_rgb_color[3]; ?>) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.1) 100%);
}
.vs-video-header:before {
    background: -moz-linear-gradient(left,  rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.85) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.25) 100%);
    background: -webkit-linear-gradient(left,  rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.85) 0%,rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.25) 100%);
    background: linear-gradient(to right,  rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.85) 0%,rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.25) 100%);
}
.drop-display:before {
    background: -moz-linear-gradient(left, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,1) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.7) 50%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.25) 100%);
    background: -webkit-linear-gradient(left, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,1) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.7) 50%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.25) 100%);
    background: linear-gradient(to right, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,1) 0%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.7) 50%, rgba(<?php echo $slide_gradient_rgb_color[0]; ?>, <?php echo $slide_gradient_rgb_color[1]; ?>, <?php echo $slide_gradient_rgb_color[2]; ?>,0.25) 100%);
}
<?php } ?>

<?php if($video_slide_content_blend) {
if($colour_style == "light") { ?>
li.wpvs-featured-slide:after, .wpvs-video-flex-container:after {
background: -moz-linear-gradient(bottom, rgba(255,255,255,<?php echo $video_slide_content_blend; ?>) 0%, rgba(255,255,255,0) 100%);
background: -webkit-linear-gradient(bottom, rgba(255,255,255,<?php echo $video_slide_content_blend; ?>) 0%,rgba(255,255,255,0) 100%);
background: linear-gradient(to top, rgba(255,255,255,<?php echo $video_slide_content_blend; ?>) 0%,rgba(255,255,255,0) 100%);
}
<?php } else { ?>
li.wpvs-featured-slide:after, .wpvs-video-flex-container:after {
background: -moz-linear-gradient(bottom, rgba(20, 20, 20,<?php echo $video_slide_content_blend; ?>) 0%, rgba(0,0,0,0) 100%);
background: -webkit-linear-gradient(bottom, rgba(20, 20, 20,<?php echo $video_slide_content_blend; ?>) 0%,rgba(0,0,0,0) 100%);
background: linear-gradient(to top, rgba(20, 20, 20,<?php echo $video_slide_content_blend; ?>) 0%,rgba(0,0,0,0) 100%);
}
<?php } } ?>

/* BUTTONS */

<?php if($play_button_setting == 'play-icon') { ?>
.vs-drop-button {
display: none;
}
<?php } else { ?>
.drop-display .vs-drop-play-button {
display: none;
}
<?php } if($wpvs_full_screen_video) { ?>

.wpvs-full-screen-login {
position: absolute;
top: 0;
padding: 150px 0 50px;
left: 0;
overflow-y: scroll;
box-sizing: border-box;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
}

.wpvs-full-screen-display #single-wpvstheme-video-container {
padding: 0;
}

.wpvs-full-screen-display #single-wpvstheme-video-container, .wpvs-full-screen-display, .wpvs-full-screen-display #single-wpvstheme-video-container #rvs-main-video, .wpvs-full-screen-display #single-wpvstheme-video-container #rvs-trailer-video{
height: 100%;
}

.wpvs-full-screen-display #single-wpvstheme-video-container #rvs-main-video .videoWrapper, .wpvs-full-screen-display #single-wpvstheme-video-container #rvs-trailer-video .videoWrapper {
max-width: none;
max-height: none;
height: 100%;
width: auto;
}

<?php } ?>

/* WP Video Memberships */

.wpvs-loading-text {
color: <?php echo $theme_accent_colour; ?>
}

<?php echo get_theme_mod('custom_css'); ?>

     </style>
<?php }
add_action( 'wp_head', 'wpvs_theme_custom_css_settings_output');

function sanitize_rogue_logo( $input ) {

    /* default output */
    $output = '';

    /* check file type */
    $filetype = wp_check_filetype( $input );
    $mime_type = $filetype['type'];

    /* only mime type "image" allowed */
    if ( strpos( $mime_type, 'image' ) !== false ) {
        $output = $input;
    }
    return $output;
}

function sanitize_custom_wpvstheme_css( $input ) {
    return $input;
}

function sanitize_custom_wpvstheme_js( $input ) {
    return $input;
}

function wpvstheme_sanitize_select( $input, $setting ) {
  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function wpvs_theme_sanitize_number( $number, $setting ) {
  // Ensure $number is an absolute integer (whole number, zero or greater).
  $number = absint( $number );

  // If the input is an absolute integer, return it; otherwise, return the default
  return ( $number ? $number : $setting->default );
}

function wpvs_customized_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/style-login.css" />';
    $theme_logo = esc_url( get_theme_mod( 'rogue_company_logo' ) );
    $wpvs_theme_login_background = esc_url( get_theme_mod( 'wpvs_theme_login_background' ) );
    $theme_logo_height = get_theme_mod( 'wpvs_signin_logo_height', '150');
    $accent_colour = get_theme_mod('accent_color', '#E50914');
    $colour_style = get_theme_mod('style_color', 'dark');
    $wpvs_hide_login_register_link = get_theme_mod('wpvs_hide_login_register_link', 0);
    if($colour_style == "dark") {
        $background_color = '#141414';
        $box_color = "#232323";
        $text_color = "#eeeeee";
        $input_background = "#1c1c1c";
        $input_border = "#353535";
    } else {
        $background_color = '#fafafa';
        $box_color = "#ffffff";
        $text_color = "#141414";
        $input_background = "#fafafa";
        $input_border = "#eeeeee";
    }
?>
     <style type="text/css">
        body {
            background: <?php echo $background_color; ?>;
            <?php if( ! empty($wpvs_theme_login_background) )  { ?>
            background-image: url(<?php echo $wpvs_theme_login_background; ?>);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            <?php } ?>
        }
        <?php if( !empty($theme_logo)) { ?>
            #login h1 a, .login h1 a {
                content:"<?php echo $theme_logo; ?>";
                background-image: url(<?php echo $theme_logo; ?>);
                background-size: auto <?php echo $theme_logo_height .'px'; ?>;
                width: 100%;
                height: <?php echo $theme_logo_height .'px'; ?>;
            }
        <?php } else { ?>
            #login h1 a {
                background-image:none;
                text-indent: 0;
                color: <?php echo $accent_colour; ?> !important;
                font-size: 36px;
                height: auto;
                width: auto;
            }
         <?php } ?>

         #login h1 a:hover {
             color: <?php echo $accent_colour; ?> !important;
         }
        .wp-core-ui .button-primary {
            background: <?php echo $accent_colour; ?>;
            border: 2px solid <?php echo $accent_colour; ?>;
        }
        .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary:active, .wp-core-ui .button-primary:focus {
            background: <?php echo $accent_colour; ?>;
            border: 2px solid <?php echo $accent_colour; ?>;
        }

        .login form, .login #login_error, .login .message {
            background: <?php echo $box_color; ?>
        }

         .login .message {
            color: <?php echo $text_color; ?>
        }

        .login #login_error, .login .message {
            border-left: 4px solid <?php echo $accent_colour; ?>;
        }

         .login #backtoblog a:hover, .login #nav a:hover {
             color: <?php echo $accent_colour; ?>;
         }

        input[type="text"], input[type="email"], input[type="password"] {
            border: 1px solid <?php echo $input_border; ?> !important;
            color: <?php echo $text_color; ?> !important;
            background: <?php echo $input_background; ?> !important;
        }

        <?php if($wpvs_hide_login_register_link && get_option( 'users_can_register' ) ) { ?>
         p#nav a:first-of-type {
             display: none;
         }
         <?php } ?>

     </style>
<?php }
add_action( 'login_head', 'wpvs_customized_login' );

function wpvs_load_google_fonts_in_customizer() {
    $wpvs_current_customizer_time = current_time('timestamp', 1);
    $check_fonts_time = get_option('wpvs_get_google_fonts_time');
    $wpvs_custom_theme_fonts = get_option('wpvs_theme_google_fonts', array());
    if( empty($wpvs_custom_theme_fonts) || empty($check_fonts_time) || ($check_fonts_time <= $wpvs_current_customizer_time) ) {
        $new_google_fonts = array();
        $google_fonts_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyANmsmvTqxtTZc-VZuh1fgyYlH3I_AWmZU";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $google_fonts_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $google_fonts = curl_exec($ch);
        curl_close($ch);
        $json_fonts = json_decode($google_fonts);
        $font_items = $json_fonts->items;
        if( ! empty($font_items) ) {
            foreach($font_items as $font) {
                $new_google_fonts[$font->family] = $font->family;
            }
        }
        if( ! empty($new_google_fonts) ) {
            $new_google_fonts = array_unique($new_google_fonts);
            update_option('wpvs_theme_google_fonts', $new_google_fonts);
            $wpvs_custom_theme_fonts = $new_google_fonts;
            $check_fonts_time = strtotime('+1 day', $wpvs_current_customizer_time );
            update_option('wpvs_get_google_fonts_time', $check_fonts_time);
        }
    }
    return $wpvs_custom_theme_fonts;
}

function wpvs_theme_convert_hex_to_rgb($hex_value) {
    $hex_value = str_replace('#', '', $hex_value);
    $rgb_array = array();
    if (strlen($hex_value) == 6) {
      $color_value = hexdec($hex_value);
      $rgb_array[] = 0xFF & ($color_value >> 0x10);
      $rgb_array[] = 0xFF & ($color_value >> 0x8);
      $rgb_array[] = 0xFF & $color_value;
    } else {
      return false;
    }
    return $rgb_array;
}

function wpvs_customized_login_link() {
	return home_url();
}
add_filter('login_headerurl','wpvs_customized_login_link');

function wpvs_customized_login_title() {
    return get_bloginfo('name', 'raw');
}
add_filter( 'login_headertext', 'wpvs_customized_login_title' );

function wpvs_get_css_width_percentage($value) {
    $css_percentage = '50%';
    if($value == 10) {
        $css_percentage = '10%';
    }
    if($value == 9) {
        $css_percentage = '11.11%';
    }
    if($value == 8) {
        $css_percentage = '12.5%';
    }
    if($value == 7) {
        $css_percentage = '14.28%';
    }
    if($value == 6) {
        $css_percentage = '16.66%';
    }
    if($value == 5) {
        $css_percentage = '20%';
    }
    if($value == 4) {
        $css_percentage = '25%';
    }
    if($value == 3) {
        $css_percentage = '33.33%';
    }
    if($value == 2) {
        $css_percentage = '50%';
    }
    if($value == 1) {
        $css_percentage = '100%';
    }
    return $css_percentage;
}
