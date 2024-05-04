<?php

function wpvs_check_custom_slug_settings() {
    global $wpvs_video_slug_settings;
    global $wpvs_genre_slug_settings;
    global $wpvs_actor_slug_settings;
    global $wpvs_director_slug_settings;

    if(! isset($wpvs_video_slug_settings['slug'])) {
    $wpvs_video_slug_settings['slug'] = 'videos';
    }

	if(! isset($wpvs_video_slug_settings['single-slug'])) {
    $wpvs_video_slug_settings['single-slug'] = 'videos';
    }

    if(! isset($wpvs_genre_slug_settings['name'])) {
    $wpvs_genre_slug_settings['name'] = 'Genre / Category';
    }

    if(! isset($wpvs_genre_slug_settings['name-plural'])) {
    $wpvs_genre_slug_settings['name-plural'] = 'Genres / Categories';
    }

    if(! isset($wpvs_genre_slug_settings['slug'])) {
    $wpvs_genre_slug_settings['slug'] = 'videos';
    }

    if(! isset($wpvs_genre_slug_settings['name-seasons'])) {
    $wpvs_genre_slug_settings['name-seasons'] = 'Seasons';
    }

    if(! isset($wpvs_genre_slug_settings['icon'])) {
    $wpvs_genre_slug_settings['icon'] = 'format-video';
    }

    if(! isset($wpvs_actor_slug_settings['name'])) {
    $wpvs_actor_slug_settings['name'] = 'Actor';
    }

    if(! isset($wpvs_actor_slug_settings['name-plural'])) {
    $wpvs_actor_slug_settings['name-plural'] = 'Actors';
    }

    if(! isset($wpvs_actor_slug_settings['slug'])) {
    $wpvs_actor_slug_settings['slug'] = 'actor';
    }

    if(! isset($wpvs_actor_slug_settings['icon'])) {
    $wpvs_actor_slug_settings['icon'] = 'groups';
    }

    if(! isset($wpvs_actor_slug_settings['ordering'])) {
        $wpvs_actor_slug_settings['ordering'] = 'default';
    }

    if(! isset($wpvs_director_slug_settings['name'])) {
    $wpvs_director_slug_settings['name'] = 'Director';
    }

    if(! isset($wpvs_director_slug_settings['name-plural'])) {
    $wpvs_director_slug_settings['name-plural'] = 'Directors';
    }

    if(! isset($wpvs_director_slug_settings['slug'])) {
    $wpvs_director_slug_settings['slug'] = 'director';
    }

    if(! isset($wpvs_director_slug_settings['icon'])) {
    $wpvs_director_slug_settings['icon'] = 'admin-users';
    }

    if(! isset($wpvs_director_slug_settings['ordering'])) {
        $wpvs_director_slug_settings['ordering'] = 'default';
    }
}
add_action('init', 'wpvs_check_custom_slug_settings');
