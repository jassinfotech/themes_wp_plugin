var wpvs_jw_player = null;
var wpvs_jw_trailer_player = null;
jQuery(document).ready(function() {
    jQuery('#vs-play-video').click( function() {
        if( jQuery('#rvs-main-video .jwplayer').length > 0 && wpvs_jw_player == null ) {
            var jw_player_id = jQuery('#rvs-main-video .jwplayer').attr('id');
            wpvs_jw_player = jwplayer(jw_player_id);
            wpvs_run_jw_player_created_events();
        }
        if( wpvs_jw_player ) {
            wpvs_jw_player.play();
        }
    });

    jQuery('#vs-play-trailer').click( function() {
        if( jQuery('#rvs-trailer-video .jwplayer').length > 0 && wpvs_jw_trailer_player == null  ) {
            var jw_trailer_player_id = jQuery('#rvs-trailer-video .jwplayer').attr('id');
            wpvs_jw_trailer_player = jwplayer(jw_trailer_player_id);
        }
        if( wpvs_jw_trailer_player ) {
            wpvs_jw_trailer_player.play();
        }
    });

    jQuery('#vs-video-back').click( function() {
        if( wpvs_jw_player ) {
            wpvs_jw_player.pause();
        }
        if( wpvs_jw_trailer_player ) {
            wpvs_jw_trailer_player.pause();
        }
    });
});
