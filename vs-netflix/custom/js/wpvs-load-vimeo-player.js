var wpvs_vimeo_player = null;
var wpvs_vimeo_trailer_player = null;
class WPVS_VIMEO_PLAYER_MANAGER {

    constructor() {}

    load_vimeo_player(player_element_id) {
        wpvs_vimeo_player = new Vimeo.Player(player_element_id);
        wpvs_vimeo_player.on('ended', function() {
            if(wpvsvimeoplayer.autoplay && typeof(wpvs_load_next_video) == 'function') {
                wpvs_load_next_video();
            }
        });
    }

    load_vimeo_trailer(trailer_element_id) {
        wpvs_vimeo_trailer_player = new Vimeo.Player(trailer_element_id);
    }

}
const wpvs_vimeo_player_manager = new WPVS_VIMEO_PLAYER_MANAGER();
jQuery(document).ready(function() {
    if( jQuery('#wpvs-vimeo-video').length > 0 ) {
        wpvs_vimeo_player_manager.load_vimeo_player('wpvs-vimeo-video');
    }

    if( jQuery('#wpvs-vimeo-trailer').length > 0 ) {
        wpvs_vimeo_player_manager.load_vimeo_trailer('wpvs-vimeo-trailer');
    }
});
