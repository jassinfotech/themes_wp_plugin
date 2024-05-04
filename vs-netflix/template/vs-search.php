<?php
global $wpvs_genre_slug_settings;
global $wpvs_actor_slug_settings;
global $wpvs_director_slug_settings;
?>
<div id="vs-search" class="border-box ease3">
    <label id="close-wpvs-search" class="border-box wpvs-close-icon"><span class="dashicons dashicons-no-alt"></span></label>
    <div class="video-list">
        <input type="text" id="vs-search-input" name="vs-search-input" class="border-box" placeholder="<?php echo get_theme_mod('vs_search_placeholder', 'Enter search...'); ?>" />
        <div id="searching-videos" class="vs-loading border-box text-align-center">
            <span class="vs-loading-text vs-text-color"><?php _e('Searching videos', 'wpvs-theme'); ?></span>
            <span class="loadingCircle"></span>
            <span class="loadingCircle"></span>
            <span class="loadingCircle"></span>
            <span class="loadingCircle"></span>
        </div>
        <div id="vs-search-results" class="border-box">
            <div id="vs-search-videos" class="border-box"></div>
            <div id="vs-search-tax" class="border-box">
                <div id="wpvs-genre-tax-results" class="vs-results-tax border-box">
                    <label class="vs-open-tax"><?php echo $wpvs_genre_slug_settings['name-plural']; ?> <span id="genre-count"></span></label>
                    <div id="found-genres" class="border-box found-tax"></div>
                </div>
                
                <div id="wpvs-actor-tax-results" class="vs-results-tax border-box">
                    <label class="vs-open-tax"><?php echo $wpvs_actor_slug_settings['name-plural']; ?> <span id="actor-count"></span></label>
                    <div id="found-actors" class="border-box found-tax"></div>
                </div>
                
                <div id="wpvs-director-tax-results" class="vs-results-tax border-box">
                    <label class="vs-open-tax"><?php echo $wpvs_director_slug_settings['name-plural']; ?> <span id="director-count"></span></label>
                    <div id="found-directors" class="border-box found-tax"></div>
                </div>
                <div id="wpvs-tag-tax-results" class="vs-results-tax border-box">
                    <label class="vs-open-tax"><?php _e('Browse by Keyword', 'wpvs-theme'); ?> <span id="tag-count"></span></label>
                    <div id="found-tags" class="border-box found-tax"></div>
                </div>
            </div>
        </div>
    </div>
</div>