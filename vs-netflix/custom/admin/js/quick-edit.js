jQuery(function($) {
	var $wp_inline_edit = inlineEditPost.edit;
	inlineEditPost.edit = function( id ) {
		$wp_inline_edit.apply( this, arguments );
		var $post_id = 0;
		if ( typeof( id ) == 'object' ) {
			$post_id = parseInt( this.getId( id ) );
		}

		if ( $post_id > 0 ) {
			var $edit_row = $( '#edit-' + $post_id );
			var $post_row = $( '#post-' + $post_id );
			var $video_order = $( '.column-rvs_video_post_order', $post_row ).text();
			$(':input[name="rvs_video_post_order"]', $edit_row ).val( $video_order );

			var wpvs_video_rating = jQuery('.column-wpvs_video_rating_column', $post_row).find('.wpvs-video-rating-data').data('rating');
			jQuery(':input[name="wpvs_video_rating"][value="'+wpvs_video_rating+'"]', $edit_row ).val( wpvs_video_rating ).parents('.wpvs-rating-select').addClass('selected-rating');
		}
	};

	jQuery('#bulk_edit').click( function() {
		var $bulk_row = $( '#bulk-edit' );
		var $video_ids = new Array();
		$bulk_row.find( '#bulk-titles' ).children().each( function() {
			$video_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
		});
		var wpvs_video_rating = $bulk_row.find('input[name="wpvs_video_rating"]:checked').val();
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			async: false,
			cache: false,
			data: {
				action: 'wpvs_video_bulk_edit_save_fields',
				video_ids: $video_ids,
				wpvs_video_rating: wpvs_video_rating
			}
		});
	});
});
