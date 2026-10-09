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
	 * Front-end stylesheet for enhancements that theme.json cannot express.
	 */
	function shortlaxi_enqueue_styles() {
		$theme = wp_get_theme( get_template() );

		wp_enqueue_style(
			'shortlaxi',
			get_parent_theme_file_uri( 'assets/css/theme.css' ),
			array(),
			$theme->get( 'Version' )
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
