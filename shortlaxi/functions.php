<?php
/**
 * Shortlaxi theme functions.
 *
 * Most of the theme is declarative (theme.json, templates, parts, patterns).
 * This file only wires up what cannot be expressed there.
 *
 * @package Shortlaxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'shortlaxi_setup' ) ) :
	/**
	 * Theme setup: editor stylesheet and optional supports.
	 */
	function shortlaxi_setup() {
		add_editor_style( 'assets/css/theme.css' );

		// Classic "Custom Logo" support so the Site Logo block can be set from the Customizer too.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 96,
				'width'       => 320,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'shortlaxi_setup' );

if ( ! function_exists( 'shortlaxi_enqueue_styles' ) ) :
	/**
	 * Front-end stylesheet and progressive-enhancement script.
	 */
	function shortlaxi_enqueue_styles() {
		$theme = wp_get_theme( get_template() );

		wp_enqueue_style(
			'shortlaxi',
			get_parent_theme_file_uri( 'assets/css/theme.css' ),
			array(),
			$theme->get( 'Version' )
		);

		// Sidebar/drawer, bookmarks and share controls. Progressive enhancement: the site works without it.
		wp_enqueue_script(
			'shortlaxi',
			get_parent_theme_file_uri( 'assets/js/shortlaxi.js' ),
			array(),
			$theme->get( 'Version' ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_localize_script(
			'shortlaxi',
			'shortlaxiL10n',
			array(
				'openMenu'     => __( 'Open main menu', 'shortlaxi' ),
				'closeMenu'    => __( 'Close main menu', 'shortlaxi' ),
				'expandMenu'   => __( 'Expand sidebar', 'shortlaxi' ),
				'collapseMenu' => __( 'Collapse sidebar', 'shortlaxi' ),
				'saved'        => __( 'Saved to bookmarks', 'shortlaxi' ),
				'removed'      => __( 'Removed from bookmarks', 'shortlaxi' ),
				'save'         => __( 'Save', 'shortlaxi' ),
				'unsave'       => __( 'Saved', 'shortlaxi' ),
				'copied'       => __( 'Link copied to clipboard', 'shortlaxi' ),
				'copyFailed'   => __( 'Could not copy the link. Copy it from the address bar.', 'shortlaxi' ),
				'loadFailed'   => __( 'Your bookmarks could not be loaded. Please try again.', 'shortlaxi' ),
				'readMore'     => __( 'Read article', 'shortlaxi' ),
			)
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'shortlaxi_enqueue_styles' );

if ( ! function_exists( 'shortlaxi_pattern_categories' ) ) :
	/**
	 * Pattern categories used by the files in /patterns.
	 */
	function shortlaxi_pattern_categories() {
		register_block_pattern_category(
			'shortlaxi',
			array(
				'label'       => __( 'Shortlaxi', 'shortlaxi' ),
				'description' => __( 'Editorial layouts from the Shortlaxi theme.', 'shortlaxi' ),
			)
		);
	}
endif;
add_action( 'init', 'shortlaxi_pattern_categories' );

if ( ! function_exists( 'shortlaxi_early_classes' ) ) :
	/**
	 * Adds "shortlaxi-js" (and the remembered sidebar state) to <html> before first paint,
	 * so the collapsible sidebar does not jump while the deferred script loads.
	 */
	function shortlaxi_early_classes() {
		wp_print_inline_script_tag(
			"(function(d){var c=d.documentElement.classList;c.add('shortlaxi-js');try{if(localStorage.getItem('shortlaxi:sidebar-collapsed')==='1'){c.add('shortlaxi-sidebar-collapsed');}}catch(e){}})(document);"
		);
	}
endif;
add_action( 'wp_head', 'shortlaxi_early_classes', 1 );

require_once get_parent_theme_file_path( 'inc/navigation.php' );
require_once get_parent_theme_file_path( 'inc/queries.php' );
require_once get_parent_theme_file_path( 'inc/content.php' );
require_once get_parent_theme_file_path( 'inc/blocks.php' );
