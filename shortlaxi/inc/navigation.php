<?php
/**
 * Sidebar navigation: view links, current-item state and landmark labelling.
 *
 * The sidebar links to four "views". Each view has a dedicated template
 * (templates/page-{view}.html) that WordPress uses automatically for a page with
 * that slug. Until such a page exists, the link falls back to the matching
 * section on the front page, so no link ever 404s.
 *
 * @package Shortlaxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Views shown in the sidebar, keyed by page slug.
 *
 * @return array<string,string> Slug => label.
 */
function shortlaxi_views() {
	return array(
		'explore'   => __( 'Explore', 'shortlaxi' ),
		'latest'    => __( 'Latest Articles', 'shortlaxi' ),
		'trending'  => __( 'Trending', 'shortlaxi' ),
		'bookmarks' => __( 'Bookmarks', 'shortlaxi' ),
	);
}

/**
 * Published page for a view, if the site has created one.
 *
 * @param string $view View slug.
 * @return WP_Post|null
 */
function shortlaxi_view_page( $view ) {
	static $cache = array();

	if ( ! array_key_exists( $view, $cache ) ) {
		$page           = get_page_by_path( $view );
		$cache[ $view ] = ( $page instanceof WP_Post && 'publish' === $page->post_status ) ? $page : null;
	}

	return $cache[ $view ];
}

/**
 * URL for a view: its page when it exists, otherwise its section on the front page.
 *
 * @param string $view View slug, or "home".
 * @return string
 */
function shortlaxi_view_url( $view ) {
	if ( 'home' === $view ) {
		return home_url( '/' );
	}

	$page = shortlaxi_view_page( $view );

	return $page ? get_permalink( $page ) : home_url( '/#' . $view );
}

/**
 * Whether the current request is showing a given view.
 *
 * @param string $view View slug, or "home".
 * @return bool
 */
function shortlaxi_is_current_view( $view ) {
	if ( 'home' === $view ) {
		return is_front_page() || ( is_home() && ! is_paged() );
	}

	$page = shortlaxi_view_page( $view );

	return $page && is_page( $page->ID );
}

/**
 * Points sidebar links (class "shortlaxi-view-{slug}") at the right URL and marks the current one.
 *
 * Runs on render so the links stay correct even after the header or sidebar is
 * customised in the Site Editor.
 *
 * @param string $content Rendered navigation link.
 * @param array  $block   Parsed block.
 * @return string
 */
function shortlaxi_filter_view_links( $content, $block ) {
	$class = $block['attrs']['className'] ?? '';

	if ( ! preg_match( '/(?:^|\s)shortlaxi-view-([a-z]+)(?:\s|$)/', $class, $match ) ) {
		return $content;
	}

	$view = $match[1];
	if ( 'home' !== $view && ! array_key_exists( $view, shortlaxi_views() ) ) {
		return $content;
	}

	$tags = new WP_HTML_Tag_Processor( $content );

	if ( $tags->next_tag( 'li' ) && shortlaxi_is_current_view( $view ) ) {
		$tags->add_class( 'current-menu-item' );
	}

	if ( $tags->next_tag( 'a' ) ) {
		$tags->set_attribute( 'href', esc_url( shortlaxi_view_url( $view ) ) );

		if ( shortlaxi_is_current_view( $view ) ) {
			$tags->set_attribute( 'aria-current', 'page' );
		}
	}

	return $tags->get_updated_html();
}
add_filter( 'render_block_core/navigation-link', 'shortlaxi_filter_view_links', 10, 2 );

/**
 * Gives the sidebar template part a stable id (for the menu button's aria-controls) and a landmark label.
 *
 * @param string $content Rendered template part.
 * @param array  $block   Parsed block.
 * @return string
 */
function shortlaxi_filter_sidebar_part( $content, $block ) {
	if ( 'sidebar' !== ( $block['attrs']['slug'] ?? '' ) ) {
		return $content;
	}

	$tags = new WP_HTML_Tag_Processor( $content );

	if ( $tags->next_tag() ) {
		$tags->set_attribute( 'id', 'shortlaxi-sidebar' );
		$tags->set_attribute( 'aria-label', __( 'Site navigation', 'shortlaxi' ) );
	}

	return $tags->get_updated_html();
}
add_filter( 'render_block_core/template-part', 'shortlaxi_filter_sidebar_part', 10, 2 );
