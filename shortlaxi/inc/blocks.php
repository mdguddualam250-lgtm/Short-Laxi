<?php
/**
 * Theme blocks: category chips, share controls, table of contents, bookmarks.
 *
 * All are server-rendered (render.php), so they always output fresh markup and
 * never trigger block-validation errors. A single, build-free editor script
 * (assets/js/editor-blocks.js) supplies their editor previews.
 *
 * @package Shortlaxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the editor script and every block in /blocks.
 */
function shortlaxi_register_blocks() {
	$theme = wp_get_theme( get_template() );

	wp_register_script(
		'shortlaxi-editor-blocks',
		get_parent_theme_file_uri( 'assets/js/editor-blocks.js' ),
		array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n', 'wp-server-side-render' ),
		$theme->get( 'Version' ),
		true
	);

	foreach ( glob( get_parent_theme_file_path( 'blocks/*/block.json' ) ) as $metadata ) {
		register_block_type( dirname( $metadata ) );
	}
}
add_action( 'init', 'shortlaxi_register_blocks' );

/**
 * Small inline SVG icon used by theme blocks. Decorative: hidden from assistive technology.
 *
 * @param string $name Icon name.
 * @return string SVG markup.
 */
function shortlaxi_icon( $name ) {
	$paths = array(
		'bookmark' => '<path d="M6 3h12a1 1 0 0 1 1 1v17l-7-4.5L5 21V4a1 1 0 0 1 1-1z"/>',
		'link'     => '<path d="M10 14a4.5 4.5 0 0 0 6.4 0l3-3a4.5 4.5 0 0 0-6.4-6.4l-1 1"/><path d="M14 10a4.5 4.5 0 0 0-6.4 0l-3 3a4.5 4.5 0 0 0 6.4 6.4l1-1"/>',
		'share'    => '<path d="M12 3v12"/><path d="m7 8 5-5 5 5"/><path d="M5 13v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6"/>',
		'x'        => '<path d="M4 4l16 16M20 4 4 20"/>',
		'facebook' => '<path d="M14 8h3V4h-3a4 4 0 0 0-4 4v3H7v4h3v6h4v-6h3l1-4h-4V8z"/>',
		'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/>',
		'whatsapp' => '<path d="M4 20l1.3-3.9A8 8 0 1 1 8 19z"/><path d="M9 9c0 3 3 6 6 6l1-1.5-2-1-1 1c-1 0-2.5-1.5-2.5-2.5l1-1-1-2z"/>',
		'email'    => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'list'     => '<path d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return '<svg class="shortlaxi-icon" aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' . $paths[ $name ] . '</svg>';
}
