var wpvs_search_timeout;
jQuery(document).ready( function() {
    jQuery('#vs-open-search').click(function() {
        jQuery(this).toggleClass('vs-rotate-search');
        jQuery('#vs-search').toggleClass('vs-show-search');
    });

    jQuery('#close-wpvs-search').click(function() {
        jQuery('#vs-open-search').removeClass('vs-rotate-search');
        jQuery('#vs-search').removeClass('vs-show-search');
    });


    jQuery('#vs-search-input').keyup( function() {
        if( wpvs_search_timeout ) {
            clearTimeout(wpvs_search_timeout);
        }
        var search_for = jQuery(this).val();
        if(search_for != "") {
             wpvs_search_timeout = setTimeout( function() {
                 wpvs_theme_main_search(search_for);
             }, 800);
        } else {
            jQuery('#found-genres').html("");
            jQuery('#found-actors').html("");
            jQuery('#found-directors').html("");
            jQuery('#found-tags').html("");
            jQuery('#genre-count').text('');
            jQuery('#actor-count').text('');
            jQuery('#director-count').text('');
            jQuery('#tag-count').text('');
            jQuery('#vs-search-videos').html('');
            jQuery('#wpvs-genre-tax-results').hide();
            jQuery('#wpvs-actor-tax-results').hide();
            jQuery('#wpvs-director-tax-results').hide();
            jQuery('#wpvs-tag-tax-results').hide();
        }

    });
});

function wpvs_theme_main_search(search_for) {
    jQuery('#searching-videos').show();
    jQuery('#vs-search-results').hide();
    jQuery.ajax({
        url: rvssearch.url,
        type: "POST",
        data: {
            'action': 'wpvs_theme_search_videos_ajax',
            'search_term': search_for
        },
        success:function(response) {
            var vs_found = JSON.parse(response);
            var videos = vs_found.videos;
            var genres = vs_found.genres;
            var actors = vs_found.actors;
            var directors = vs_found.directors;
            var keywords = vs_found.tags;
            jQuery('#searching-videos').hide();
            jQuery('#found-genres').html("");
            jQuery('#found-actors').html("");
            jQuery('#found-directors').html("");
            jQuery('#found-tags').html("");
            if(genres.length <= 0) {
                jQuery('#genre-count').text('');
                jQuery('#wpvs-genre-tax-results').hide();
            } else {
                var add_to_genres = "";
                jQuery.each(genres, function(index, genre) {
                    add_to_genres += '<a href="'+genre.genre_link+'" class="vs-tax-result border-box">'+genre.genre_title+'</a>';
                });
                jQuery('#found-genres').html(add_to_genres);
                jQuery('#genre-count').text('('+genres.length+')');
                jQuery('#wpvs-genre-tax-results').show();
            }
            if(actors.length <= 0) {
                jQuery('#actor-count').text('');
                jQuery('#wpvs-actor-tax-results').hide();
            } else {
                var add_to_actors = "";
                jQuery.each(actors, function(index, actor) {
                    if( rvssearch.profiles ) {
                        add_to_actors += '<a href="'+actor.actor_link+'" class="vs-tax-result wpvs-profile border-box"><span class="wpvs-profile-image"><img src="'+actor.actor_image+'" alt="'+actor.actor_title+'" /></span><span class="wpvs-profile-name">'+actor.actor_title+'</span></a>';
                    } else {
                        add_to_actors += '<a href="'+actor.actor_link+'" class="vs-tax-result border-box">'+actor.actor_title+'</a>';
                    }
                });
                jQuery('#found-actors').html(add_to_actors);
                jQuery('#actor-count').text('('+actors.length+')');
                jQuery('#wpvs-actor-tax-results').show();
            }

            if(directors.length <= 0) {
                jQuery('#director-count').text('');
                jQuery('#wpvs-director-tax-results').hide();
            } else {
                var add_to_directors = "";
                jQuery.each(directors, function(index, director) {
                    if( rvssearch.profiles ) {
                        add_to_directors += '<a href="'+director.director_link+'" class="vs-tax-result wpvs-profile border-box"><span class="wpvs-profile-image"><img src="'+director.director_image+'" alt="'+director.actor_title+'" /></span><span class="wpvs-profile-name">'+director.director_title+'</span></a>';
                    } else {
                        add_to_directors += '<a href="'+director.director_link+'" class="vs-tax-result border-box">'+director.director_title+'</a>';
                    }
                });
                jQuery('#found-directors').html(add_to_directors);
                jQuery('#director-count').text('('+directors.length+')');
                jQuery('#wpvs-director-tax-results').show();
            }

            if(keywords.length > 0) {
                var add_to_keywords = "";
                jQuery.each(keywords, function(index, keyword) {
                    add_to_keywords += '<a href="'+keyword.tag_link+'" class="vs-tax-result border-box">'+keyword.tag_title+'</a>';
                });
                jQuery('#found-tags').html(add_to_keywords);
                jQuery('#tag-count').text('('+keywords.length+')');
                jQuery('#wpvs-tag-tax-results').show();
            } else {
                jQuery('#tag-count').text('');
                jQuery('#wpvs-tag-tax-results').hide();
            }

            if(videos.length <= 0) {
                jQuery('#vs-search-videos').html('<div class="text-align-center">No videos found.</div>');
            } else {
                var add_to_list = "";
                jQuery.each(videos, function(index, video) {
                    add_to_list += '<a class="video-item border-box" href="'+video.video_link+'"><div class="video-item-content">';
                    if( video.video_thumbnail.src ) {
                        add_to_list += '<img src="'+video.video_thumbnail.src+'" alt="'+video.video_title+'" ';
                        if( video.video_thumbnail.srcset ) {
                            add_to_list += 'srcset="'+video.video_thumbnail.srcset+'" ';
                        }
                        add_to_list += '/>';
                    } else {
                        add_to_list += '<div class="wpvs-no-slide-image"></div>';
                    }

                    add_to_list += '<div class="video-slide-details border-box"><h4>'+video.video_title+'</h4><p>'+video.video_excerpt+'</p></div></div></a>';
                });
                jQuery('#vs-search-videos').html(add_to_list);
            }
            jQuery('#vs-search-results').show();
        }
    });
}
