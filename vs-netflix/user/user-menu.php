<?php
global $wpvs_current_user;
global $wpvs_my_list_enabled;
$wpvs_user_display_name = $wpvs_current_user->display_name;
if( empty($wpvs_user_display_name) ) {
    $wpvs_user_display_name = $wpvs_current_user->user_firstname;
}
if( empty($wpvs_user_display_name) ) {
    $wpvs_user_display_name = $wpvs_current_user->user_login;
}
$user_avatar = get_avatar($wpvs_current_user->ID, '32');
$wpvs_user_menu_option = get_theme_mod('wpvs_user_menu', 'default'); ?>
<li id="user-menu"><a href="#"><?php echo $user_avatar; ?><?php echo $wpvs_user_display_name ?></a>
<?php if( $wpvs_user_menu_option == "default") {
    $account_page_id = get_option('rvs_account_page');
    if( ! empty($account_page_id) ) {
        $account_page = get_permalink($account_page_id);
        $account_menu_text = esc_attr( get_theme_mod('vs_user_menu_link_first', 'Account') );
    }
    $user_rentals_page_id = esc_attr( get_option('rvs_user_rental_page') );
    if( ! empty($user_rentals_page_id) ) {
        $user_rentals_page = get_permalink($user_rentals_page_id);
        $rentals_menu_text = esc_attr( get_theme_mod('vs_user_menu_link_second', 'Rentals') );
    }
    $user_purchases_page_id = esc_attr( get_option('rvs_user_purchase_page') );
    if( ! empty($user_purchases_page_id) ) {
        $user_purchases_page = get_permalink($user_purchases_page_id);
        $purchases_menu_text = esc_attr( get_theme_mod('vs_user_menu_link_third', 'Purchases') );
    }
    if($wpvs_my_list_enabled) {
        $wpvs_my_list_page_id = get_option('wpvs_my_list_page');
        if( ! empty($wpvs_my_list_page_id) ) {
            $wpvs_my_list_link = get_permalink($wpvs_my_list_page_id);
            $wpvs_my_list_menu_text = esc_attr( get_theme_mod('wpvs_user_menu_list_link', 'My List') );
        }
    }
    $logout_menu_text = esc_attr( get_theme_mod('vs_user_menu_link_fourth', 'Logout') ); ?>
    <ul id="user-sub-menu">
        <?php if( !empty($account_page) && !empty($account_menu_text) ) : ?>
            <li><a href="<?php echo $account_page; ?>"><span class="dashicons dashicons-admin-users"></span> <?php echo $account_menu_text; ?></a></li>
        <?php endif; if( ! empty($wpvs_my_list_menu_text) && ! empty($wpvs_my_list_link) ) : ?>
            <li><a href="<?php echo $wpvs_my_list_link; ?>"><span class="dashicons dashicons-editor-video"></span> <?php echo $wpvs_my_list_menu_text; ?></a></li>
        <?php endif; if( !empty($user_rentals_page) && !empty($rentals_menu_text) ) : ?>
        <li><a href="<?php echo $user_rentals_page; ?>"><span class="dashicons dashicons-clock"></span> <?php echo $rentals_menu_text; ?></a></li>
        <?php endif; ?>
        <?php if( !empty($user_purchases_page) && !empty($purchases_menu_text)) : ?>
        <li><a href="<?php echo $user_purchases_page; ?>"><span class="dashicons dashicons-format-video"></span> <?php echo $purchases_menu_text; ?></a></li>
        <?php endif; ?>
        <li><a href="<?php echo wp_logout_url( home_url() ); ?>"><span class="dashicons dashicons-migrate"></span> <?php echo $logout_menu_text; ?></a></li>
    </ul>
<?php } else {
    $wpvs_theme_user_menu_args = array(
        'container' => false,
        'theme_location' => 'user',
        'menu' => 'user',
        'menu_class' => '',
        'menu_id' => 'user-sub-menu',
        'echo' => false,
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 1,
        'fallback_cb' => false
    );
    echo wp_nav_menu( $wpvs_theme_user_menu_args );
} ?>
    <span class="dashicons dashicons-arrow-down menuArrow userArrow"></span>
</li>
