( function( blocks, editor, i18n, element, components, _ ) {
	var el = wp.element.createElement;
	var ChildBlocks = wp.blockEditor.InnerBlocks;
	var DefaultBlocks = wp.blockEditor.DefaultBlocks;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var PanelColorSettings = wp.blockEditor.PanelColorSettings;
	const { Fragment } = element;
	const { ToggleControl, Panel, PanelBody, PanelRow, BaseControl, TextControl } = components;


	blocks.registerBlockType( 'wpvs-theme-blocks/full-section-block', {
		title: i18n.__( 'WPVS Theme Full Section', 'wpvs-theme' ),
		description: 'Creates a full width section which other Blocks can be added to.',
		icon: 'editor-expand',
		category: 'layout',
		attributes: {
			content: {
				type: 'string'
			},
			has_padding: {
				type: 'boolean',
				default: true
			},
			has_container: {
				type: 'boolean',
				default: true
			},
			background_color: {
				type: 'string',
			},
			padding_top: {
				type: 'string',
				default:'40px'
			},
			padding_right: {
				type: 'string',
				default:''
			},
			padding_bottom: {
				type: 'string',
				default:'40px'
			},
			padding_left: {
				type: 'string',
				default:''
			}
		},
		supports: {
			anchor: true
		},
		edit: function( props ) {
			var has_padding_class = props.attributes.has_padding == true ? 'col-12' : '';
			var has_container_class = props.attributes.has_container == true ? 'container row' : '';
			var background_color = props.attributes.background_color;
			var wpvs_full_section_params = {
				className: 'full-width ' + props.className
			};
			if( background_color ) {
				wpvs_full_section_params.style = {backgroundColor: background_color};
			}
			if( props.attributes.padding_top ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingTop: props.attributes.padding_top};
				} else {
					wpvs_full_section_params.style.paddingTop = props.attributes.padding_top;
				}
			}
			if( props.attributes.padding_bottom ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingBottom: props.attributes.padding_bottom};
				} else {
					wpvs_full_section_params.style.paddingBottom = props.attributes.padding_bottom;
				}
			}
			if( props.attributes.padding_right ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingRight: props.attributes.padding_right};
				} else {
					wpvs_full_section_params.style.paddingRight = props.attributes.padding_right;
				}
			}
			if( props.attributes.padding_left ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingLeft: props.attributes.padding_left};
				} else {
					wpvs_full_section_params.style.paddingLeft = props.attributes.padding_left;
				}
			}
			return (
				el( Fragment, {},
					el( InspectorControls, {},
						el( PanelBody, { title: 'Section Settings', initialOpen: true },
							el( PanelRow, {},
								el( ToggleControl,
									{
										label: 'Add Content Padding',
										onChange: ( value ) => {
											props.setAttributes( { has_padding: value } );
										},
										checked: props.attributes.has_padding,
									}
								)
							),
							el( PanelRow, {},
								el( ToggleControl,
									{
										label: 'Add Container',
										onChange: ( value ) => {
											props.setAttributes( { has_container: value } );
										},
										checked: props.attributes.has_container,
									}
								)
							),
							el( PanelRow, {},
								el( TextControl,
									{
										value: props.attributes.padding_top,
										onChange: ( value ) => {
											props.setAttributes( { padding_top: value } );
										},
										label: 'Padding Top'
									}
								)
							),
							el( PanelRow, {},
								el( TextControl,
									{
										value: props.attributes.padding_bottom,
										onChange: ( value ) => {
											props.setAttributes( { padding_bottom: value } );
										},
										label: 'Padding Bottom'
									}
								)
							),
							el( PanelRow, {},
								el( TextControl,
									{
										value: props.attributes.padding_right,
										onChange: ( value ) => {
											props.setAttributes( { padding_right: value } );
										},
										label: 'Padding Right'
									}
								)
							),
							el( PanelRow, {},
								el( TextControl,
									{
										value: props.attributes.padding_left,
										onChange: ( value ) => {
											props.setAttributes( { padding_left: value } );
										},
										label: 'Padding Left'
									}
								)
							)
						),

						el( PanelColorSettings,
							{
								title: 'Color Settings',
								colorSettings: [ {
									value: background_color,
									onChange: ( value ) => {
										props.setAttributes( { background_color: value } );
									},
									label: 'Background Color'
								} ]

							}
						),

					),
					el( 'div', wpvs_full_section_params,
						el( 'div', { className: has_padding_class },
							el( 'div', { className: has_padding_class },
								el(ChildBlocks, DefaultBlocks)
							)
						)
					)
				)
			)
		},
		save: function( props ) {
			var has_padding_class = props.attributes.has_padding == true ? 'col-12' : '';
			var has_container_class = props.attributes.has_container == true ? 'container row' : '';
			var background_color = props.attributes.background_color;
			var wpvs_full_section_params = {
				className: 'full-width'
			};
			if( background_color ) {
				wpvs_full_section_params.style = {backgroundColor: background_color};
			}
			if( props.attributes.padding_top ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingTop: props.attributes.padding_top};
				} else {
					wpvs_full_section_params.style.paddingTop = props.attributes.padding_top;
				}
			}
			if( props.attributes.padding_bottom ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingBottom: props.attributes.padding_bottom};
				} else {
					wpvs_full_section_params.style.paddingBottom = props.attributes.padding_bottom;
				}
			}
			if( props.attributes.padding_right ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingRight: props.attributes.padding_right};
				} else {
					wpvs_full_section_params.style.paddingRight = props.attributes.padding_right;
				}
			}
			if( props.attributes.padding_left ) {
				if( typeof(wpvs_full_section_params.style) === 'undefined' ) {
					wpvs_full_section_params.style = {paddingLeft: props.attributes.padding_left};
				} else {
					wpvs_full_section_params.style.paddingLeft = props.attributes.padding_left;
				}
			}
			return (
				el( 'div', wpvs_full_section_params,
					el( 'div', { className: has_container_class },
						el( 'div', { className: has_padding_class },
							el(ChildBlocks.Content)
						)
					)
				)
			);
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
