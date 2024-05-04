<div class="wrap">
    <?php include('wpvs-admin-menu.php'); ?>
    <div class="vimeosync">
        <form method="post" action="options.php">
            <?php
                settings_fields( 'wpvs-video-settings' );
                $rvs_autoplay = get_option('rvs_video_autoplay', 0);
                $wpvs_autoplay_timer = get_option('wpvs_autoplay_timer', 5);
                $rvs_video_order_settings = get_option('rvs_video_ordering', 'recent');
                $rvs_video_order_direction = get_option('rvs_video_order_direction', 'ASC');
                global $wpvs_video_slug_settings;
                global $wpvs_genre_slug_settings;
                global $wpvs_actor_slug_settings;
                global $wpvs_director_slug_settings;
                global $wpvs_theme_is_active;
            ?>
            <h2>WP Videos Settings</h2>
            <div id="vimeosync-settings" class="rvs-container rvs-box">
                <div class="col-6">
                    <h3>Video Ordering</h3>
                    <select id="rvs_video_ordering" name="rvs_video_ordering">
                        <option value="recent" <?php selected( $rvs_video_order_settings, "recent"); ?>>Most Recent</option>
                        <option value="videoorder" <?php selected( $rvs_video_order_settings, "videoorder"); ?>>Video Order</option>
                        <option value="alpha" <?php selected( $rvs_video_order_settings, "alpha"); ?>>Alphabetical</option>
                        <option value="random" <?php selected( $rvs_video_order_settings, "random"); ?>>Random</option>
                    </select>
                    <select id="rvs_video_order_direction" name="rvs_video_order_direction">
                        <option value="ASC" <?php selected( $rvs_video_order_direction, "ASC"); ?>>ASC (Ascending)</option>
                        <option value="DESC" <?php selected( $rvs_video_order_direction, "DESC"); ?>>DESC (Descending)</option>
                    </select>
                    <p>Set whether most recent videos are shown first or video ordering is determined by their Video Order setting.</p>
                    <h3>Autoplay Next Video</h3>
                    <div class="wpvs-option">
                        <label>Enabled <input type="checkbox" value="1" name="rvs_video_autoplay" <?php checked(1, $rvs_autoplay); ?> ></label>
                    </div>
                    <div class="wpvs-option">
                        <label>Countdown (in seconds) <input type="number" min="0" value="<?php echo $wpvs_autoplay_timer; ?>" name="wpvs_autoplay_timer" /></label>
                    </div>
                    <p>If <strong>Enabled</strong>, the next video using the <strong>Video Order</strong> will automatically play when the current video ends.</p>
                    <h4>Notes:</h4>
                    <ul class="wpvs-disc-list">
                        <li>The <strong>Video Ordering</strong> setting should be set to <strong>Video Order ASC (Ascending)</strong></li>
                        <li>If videos are within a series / season (video category) the next episode using the <strong>Video Order</strong> will be played.</li>
                        <li>Only <strong>Vimeo</strong>, <strong>YouTube</strong>, <strong>WordPress</strong> and <strong>JW Player</strong> video types will work with <strong>Autoplay.</strong> If you are using a custom player, you can call the <strong>wpvs_load_next_video()</strong> function when your video finishes playing. <em>Requires custom JS code</em></li>
                    </ul>

                </div>
                <div class="rvs-container">
                <?php submit_button(); ?>
                </div>
            </div>

            <h2>Video Slug Settings</h2>
            <div class="rvs-container rvs-box">
                <div class="col-6">
                    <h3>Video Archive Slug</h3>
                    <input type="text" class="regular-text" name="wpvs-video-slug-settings[slug]" value="<?php echo $wpvs_video_slug_settings['slug']; ?>" />
                    <p>Video archive URL and Video Permalink Structure:<br><a href="<?php echo home_url('/'.$wpvs_video_slug_settings['slug']); ?>" target="_blank"><?php echo home_url('/'.$wpvs_video_slug_settings['slug']); ?></a></p>
                </div>
                <div class="col-6">
                    <h3>Single Video Slug</h3>
                    <input type="text" class="regular-text" name="wpvs-video-slug-settings[single-slug]" value="<?php echo $wpvs_video_slug_settings['single-slug']; ?>" />
                    <p>Single Video slug for videos not added to a <?php echo $wpvs_genre_slug_settings['name']; ?>.</p>
                    <p><em>If single Videos that have not been added to a <?php echo $wpvs_genre_slug_settings['name']; ?> are displaying 404 pages, change this to <strong>video</strong> or something different than the <strong>Video Archive Slug</strong></em>. Make sure to refresh your <a href="<?php echo admin_url('options-permalink.php'); ?>">Permalinks</a> after making any changes.</p>
                </div>
            </div>

            <h2><?php echo $wpvs_genre_slug_settings['name']; ?> Settings</h2>
            <div class="rvs-container rvs-box">
                <div class="col-6">
                    <h3><?php echo $wpvs_genre_slug_settings['name']; ?> Name</h3>
                    <input type="text" class="regular-text" name="wpvs-genre-slug-settings[name]" value="<?php echo $wpvs_genre_slug_settings['name']; ?>" />
                    <p>Customize the name of Video Taxonomy <?php echo $wpvs_genre_slug_settings['name']; ?></p>
                    <h3><?php echo $wpvs_genre_slug_settings['name-plural']; ?> Name</h3>
                    <input type="text" class="regular-text" name="wpvs-genre-slug-settings[name-plural]" value="<?php echo $wpvs_genre_slug_settings['name-plural']; ?>" />
                    <p>Customize the plural name of Video Taxonomy <?php echo $wpvs_genre_slug_settings['name-plural']; ?></p>
                    <?php if( $wpvs_theme_is_active ) { ?>
                    <h3><?php echo $wpvs_genre_slug_settings['name-seasons']; ?> Name</h3>
                        <input type="text" class="regular-text" name="wpvs-genre-slug-settings[name-seasons]" value="<?php echo $wpvs_genre_slug_settings['name-seasons']; ?>" />
                        <p>Change the name of the Drop Down menu for <strong><?php echo $wpvs_genre_slug_settings['name-seasons']; ?></strong>.</p>
                        <p><em>This is for <strong><?php echo $wpvs_genre_slug_settings['name-plural']; ?></strong> marked as <strong>TV Show</strong> which contain <strong><?php echo $wpvs_genre_slug_settings['name-seasons']; ?></strong>.</em></p>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <h3><?php echo $wpvs_genre_slug_settings['name']; ?> Slug</h3>
                    <input type="text" class="regular-text" name="wpvs-genre-slug-settings[slug]" value="<?php echo $wpvs_genre_slug_settings['slug']; ?>" />
                    <p><?php echo $wpvs_genre_slug_settings['name']; ?> Front Slug:<br><?php echo home_url('/'); ?><strong><?php echo $wpvs_genre_slug_settings['slug']; ?></strong>/{<?php echo $wpvs_genre_slug_settings['name']; ?>-url}</p>
                    <p><em>We recommend keeping this the same as your <strong>Video Slug</strong> for the best SEO permalink structure.</em></p>
                </div>
                <div class="rvs-container">
                    <div class="col-12">
                        <h3><?php echo $wpvs_genre_slug_settings['name']; ?> Icon</h3>
                        <label class="wpvs-open-icon-set"><span class="wpvs-icon-update"><span class="dashicons dashicons-<?php echo $wpvs_genre_slug_settings['icon']; ?>"></span></span> Change Icon</label>
                        <div class="wpvs-icon-set">
                            <input type="hidden" class="wpvs-icon-update-input" name="wpvs-genre-slug-settings[icon]" value="<?php echo $wpvs_genre_slug_settings['icon']; ?>" />
                            <?php include('wpvs-dashicons.php'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <h2><?php echo $wpvs_actor_slug_settings['name']; ?> Settings</h2>
            <div class="rvs-container rvs-box">
                <div class="col-6">
                    <h3><?php echo $wpvs_actor_slug_settings['name']; ?> Name</h3>
                    <input type="text" class="regular-text" name="wpvs-actor-slug-settings[name]" value="<?php echo $wpvs_actor_slug_settings['name']; ?>" />
                    <p>Customize the name of Video Taxonomy <?php echo $wpvs_actor_slug_settings['name']; ?></p>
                    <h3>Plural <?php echo $wpvs_actor_slug_settings['name']; ?> Name</h3>
                    <input type="text" class="regular-text" name="wpvs-actor-slug-settings[name-plural]" value="<?php echo $wpvs_actor_slug_settings['name-plural']; ?>" />
                    <p>Customize the plural name of Video Taxonomy <?php echo $wpvs_actor_slug_settings['name-plural']; ?></p>
                </div>
                <div class="col-6">
                    <h3><?php echo $wpvs_actor_slug_settings['name']; ?> Slug</h3>
                    <input type="text" class="regular-text" name="wpvs-actor-slug-settings[slug]" value="<?php echo $wpvs_actor_slug_settings['slug']; ?>" />
                    <p><?php echo $wpvs_actor_slug_settings['name']; ?> Front Slug:<br><?php echo home_url('/'); ?><strong><?php echo $wpvs_actor_slug_settings['slug']; ?></strong>/{<?php echo $wpvs_actor_slug_settings['name']; ?>-url}</p>
                    <h3><?php echo $wpvs_actor_slug_settings['name']; ?> Ordering</h3>
                    <select name="wpvs-actor-slug-settings[ordering]">
                        <option value="default" <?php selected('default', $wpvs_actor_slug_settings['ordering']); ?>>Default</option>
                        <option value="order" <?php selected('order', $wpvs_actor_slug_settings['ordering']); ?>>Order</option>
                    </select>
                    <ul>
                        <li><em>Default</em>: <?php echo $wpvs_actor_slug_settings['name-plural']; ?> are ordered alphabetically</li>
                        <li><em>Order</em>: Requires <strong>Order</strong> to be set for each <a href="<?php echo admin_url('edit-tags.php?taxonomy=rvs_actors&post_type=rvs_video'); ?>"><?php echo $wpvs_actor_slug_settings['name']; ?></a></li>
                    </ul>
                </div>
                <div class="rvs-container">
                    <div class="col-12">
                        <h3><?php echo $wpvs_actor_slug_settings['name']; ?> Icon</h3>
                        <label class="wpvs-open-icon-set"><span class="wpvs-icon-update"><span class="dashicons dashicons-<?php echo $wpvs_actor_slug_settings['icon']; ?>"></span></span> Change Icon</label>
                        <div class="wpvs-icon-set">
                            <input type="hidden" class="wpvs-icon-update-input" name="wpvs-actor-slug-settings[icon]" value="<?php echo $wpvs_actor_slug_settings['icon']; ?>" />
                            <?php include('wpvs-dashicons.php'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <h2><?php echo $wpvs_director_slug_settings['name']; ?> Settings</h2>
            <div class="rvs-container rvs-box">
                <div class="col-6">
                    <h3><?php echo $wpvs_director_slug_settings['name']; ?> Name</h3>
                    <input type="text" class="regular-text" name="wpvs-director-slug-settings[name]" value="<?php echo $wpvs_director_slug_settings['name']; ?>" />
                    <p>Customize the name of Video Taxonomy <?php echo $wpvs_director_slug_settings['name']; ?></p>
                    <h3>Plural <?php echo $wpvs_director_slug_settings['name']; ?> Name</h3>
                    <input type="text" class="regular-text" name="wpvs-director-slug-settings[name-plural]" value="<?php echo $wpvs_director_slug_settings['name-plural']; ?>" />
                    <p>Customize the plural name of Video Taxonomy <?php echo $wpvs_director_slug_settings['name-plural']; ?></p>
                </div>
                <div class="col-6">
                    <h3><?php echo $wpvs_director_slug_settings['name']; ?> Slug</h3>
                    <input type="text" class="regular-text" name="wpvs-director-slug-settings[slug]" value="<?php echo $wpvs_director_slug_settings['slug']; ?>" />
                    <p><?php echo $wpvs_director_slug_settings['name']; ?> Front Slug:<br><?php echo home_url('/'); ?><strong><?php echo $wpvs_director_slug_settings['slug']; ?></strong>/{<?php echo $wpvs_director_slug_settings['name']; ?>-url}</p>
                    <h3><?php echo $wpvs_director_slug_settings['name']; ?> Ordering</h3>
                    <select name="wpvs-director-slug-settings[ordering]">
                        <option value="default" <?php selected('default', $wpvs_director_slug_settings['ordering']); ?>>Default</option>
                        <option value="order" <?php selected('order', $wpvs_director_slug_settings['ordering']); ?>>Order</option>
                    </select>
                    <ul>
                        <li><em>Default</em>: <?php echo $wpvs_director_slug_settings['name-plural']; ?> are ordered alphabetically</li>
                        <li><em>Order</em>: Requires <strong>Order</strong> to be set for each <a href="<?php echo admin_url('edit-tags.php?taxonomy=rvs_directors&post_type=rvs_video'); ?>"><?php echo $wpvs_director_slug_settings['name']; ?></a></li>
                    </ul>
                </div>
                <div class="rvs-container">
                    <div class="col-12">
                        <h3><?php echo $wpvs_director_slug_settings['name']; ?> Icon</h3>
                        <label class="wpvs-open-icon-set"><span class="wpvs-icon-update"><span class="dashicons dashicons-<?php echo $wpvs_director_slug_settings['icon']; ?>"></span></span> Change Icon</label>
                        <div class="wpvs-icon-set">
                            <input type="hidden" class="wpvs-icon-update-input" name="wpvs-director-slug-settings[icon]" value="<?php echo $wpvs_director_slug_settings['icon']; ?>" />
                            <?php include('wpvs-dashicons.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rvs-container rvs-box">
                <p><strong>If your page links for Videos, <?php echo $wpvs_genre_slug_settings['name-plural']; ?>, <?php echo $wpvs_actor_slug_settings['name-plural']; ?> or <?php echo $wpvs_director_slug_settings['name-plural']; ?> are showing 404 pages.</strong> <a href="<?php echo admin_url('options-permalink.php'); ?>">Refresh Your Permalinks</a></p>

            </div>

            <script>
                jQuery(document).ready( function() {
                    jQuery('.rvs-color-field').wpColorPicker({});
                });
            </script>
            <div>
            <?php submit_button(); ?>
            </div>
        </form>

    </div>
</div>
