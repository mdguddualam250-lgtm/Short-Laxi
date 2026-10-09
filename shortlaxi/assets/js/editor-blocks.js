/**
 * Editor previews for Shortlaxi theme blocks. No build step: plain ES5 + wp globals.
 * Block metadata (title, attributes, supports) comes from each blocks/<name>/block.json.
 */
( function ( wp ) {
	'use strict';

	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var ServerSideRender = wp.serverSideRender;
	var components = wp.components || {};

	function placeholder( label, help ) {
		return function () {
			return el(
				'div',
				useBlockProps( { className: 'shortlaxi-editor-placeholder' } ),
				el( 'strong', null, label ),
				help ? el( 'span', null, help ) : null
			);
		};
	}

	wp.blocks.registerBlockType( 'shortlaxi/category-chips', {
		edit: function ( props ) {
			var controls = components.PanelBody
				? el(
						InspectorControls,
						null,
						el(
							components.PanelBody,
							{ title: __( 'Settings', 'shortlaxi' ) },
							el( components.RangeControl, {
								label: __( 'Maximum categories', 'shortlaxi' ),
								min: 1,
								max: 50,
								value: props.attributes.number,
								onChange: function ( value ) {
									props.setAttributes( { number: value } );
								},
							} ),
							el( components.ToggleControl, {
								label: __( 'Show “All” chip', 'shortlaxi' ),
								checked: props.attributes.showAll,
								onChange: function ( value ) {
									props.setAttributes( { showAll: value } );
								},
							} )
						)
				  )
				: null;

			return el(
				'div',
				useBlockProps(),
				controls,
				el( ServerSideRender, { block: 'shortlaxi/category-chips', attributes: props.attributes } )
			);
		},
	} );

	wp.blocks.registerBlockType( 'shortlaxi/share', {
		edit: placeholder( __( 'Share controls', 'shortlaxi' ), __( 'Copy link, share sheet, X, Facebook, LinkedIn, WhatsApp and email for the current article.', 'shortlaxi' ) ),
	} );

	wp.blocks.registerBlockType( 'shortlaxi/toc', {
		edit: placeholder( __( 'Table of contents', 'shortlaxi' ), __( 'Lists the article’s H2 and H3 headings. Hidden when the article has fewer than three.', 'shortlaxi' ) ),
	} );

	wp.blocks.registerBlockType( 'shortlaxi/bookmark-button', {
		edit: placeholder( __( 'Bookmark', 'shortlaxi' ) ),
	} );

	wp.blocks.registerBlockType( 'shortlaxi/bookmarks', {
		edit: placeholder( __( 'Bookmarked articles', 'shortlaxi' ), __( 'Readers see the stories they saved in this browser.', 'shortlaxi' ) ),
	} );
} )( window.wp );
