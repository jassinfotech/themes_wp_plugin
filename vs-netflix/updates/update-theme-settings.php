<?php

function wpvs_set_original_theme_mod_settings() {
    $previous_theme_saved_mods = get_option('theme_mods_vs-netflix');
    if( ! empty($previous_theme_saved_mods) ) {
        foreach($previous_theme_saved_mods as $mod_key => $mod_value ) {
            set_theme_mod($mod_key, $mod_value);
        }
    }
    delete_option('vs_netflix_current_version');
    delete_option('vs_netflix_active');
}
add_action('admin_init', 'wpvs_set_original_theme_mod_settings');
