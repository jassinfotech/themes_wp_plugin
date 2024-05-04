( function( blocks, editor, i18n, element, components, _ ) {
	var el = wp.element.createElement;
	var InspectorControls = wp.blockEditor.InspectorControls;
	const { Fragment } = element;
	const { SelectControl, Panel, PanelBody, PanelRow } = components;
    const { serverSideRender } = wp;
    const wpvs_theme_video_terms = [];
    var existing_wpvs_theme_video_terms = JSON.parse(wpvsthemeblocks.video_term_options);
	const wpvs_image_sizing = JSON.parse(wpvsthemeblocks.image_sizing);
	const wpvs_image_sizing_options = [
		{label: 'Landscape (640px by 360px)', value: 'landscape'},
		{label: 'Portrait (380px by 590px)', value: 'portrait'}
	];
	if( wpvs_image_sizing.layout == 'wpvs-custom-thumbnail-size') {
		wpvs_image_sizing_options.push({label: 'Custom ('+wpvs_image_sizing.recommended_size+')', value: 'custom'})
	}
    jQuery(existing_wpvs_theme_video_terms).each(function(index, term) {
        wpvs_theme_video_terms.push( { label: term.name, value: term.value } );
    });
    blocks.registerBlockType( 'wpvs-theme-blocks/video-category-slider-block', {
        title: 'WPVS Video Thumbnail Slider',
        description: 'Display a carousel of video thumbnails within a category.',
        category: 'widgets',
        icon: 'align-center',
        attributes: {
            term_id: {
                type: 'number',
                default: 0
            },
            style: {
                type: 'string',
                default: ''
            },
			image_size: {
                type: 'string',
                default: wpvs_image_sizing.style
            }
        },
        edit: function( props ) {

            return [
                el( Fragment, {},
                    el( InspectorControls, {},
                        el( PanelBody, { title: 'Video Slider Settings', initialOpen: true },
                            el( PanelRow, {},
                                el( SelectControl,
                                    {
                                        label: 'Select Video Category',
                                        value: props.attributes.term_id,
                                        options: wpvs_theme_video_terms,
                                        onChange: function( value ) {
                                            props.setAttributes( { term_id: parseInt( value ) } );
                                        }
                                    }
                                )

                            ),
                            el( PanelRow, {},
                                el( SelectControl,
                                    {
                                        label: 'Slider Style',
                                        value: props.attributes.style,
                                        options: [{label: 'Default', value: ''}, {label: 'Clean', value: 'clean'}],
                                        onChange: function( value ) {
                                            props.setAttributes( { style: value } );
											wpvs_update_editor_slick_sliders();
                                        }
                                    }
                                ),
                            ),
							el( PanelRow, {},
								el( SelectControl,
                                    {
                                        label: 'Thumbnail Size',
                                        value: props.attributes.image_size,
                                        options: wpvs_image_sizing_options,
                                        onChange: function( value ) {
                                            props.setAttributes( { image_size: value } );
											wpvs_update_editor_slick_sliders();
                                        }
                                    }
                                ),
                            )
                        )
                    )
                ),
                el( serverSideRender, {
                    block: 'wpvs-theme-blocks/video-category-slider-block',
                    attributes: props.attributes,
                    onChange: wpvs_update_editor_slick_sliders()
                } )
            ]
        },
        save: function() {
           return null;
        },
    } );

} )(
    window.wp.blocks,
    window.wp.editor,
    window.wp.i18n,
    window.wp.element,
    window.wp.components,
    window._,
);

jQuery(document).ready(function() {
    setTimeout( function() {
        wpvs_theme_load_slick_slider_browsing();
        jQuery('.video-list-slider').addClass('show-list-slider');
        jQuery('.video-list-slider').find('.wpvs-no-slide-image').css({'height':  jQuery('.video-list-slider').find('.slick-track').height()});
    }, 2000);
});

function wpvs_update_editor_slick_sliders() {
    setTimeout( function() {
        wpvs_theme_load_slick_slider_browsing();
        jQuery('.video-list-slider').addClass('show-list-slider');
        jQuery('.video-list-slider').find('.wpvs-no-slide-image').css({'height':  jQuery('.video-list-slider').find('.slick-track').height()});
    }, 1000);
}
