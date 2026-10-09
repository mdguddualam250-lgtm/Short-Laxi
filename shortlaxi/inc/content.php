<?php
/**
 * Article content helpers: table-of-contents data and matching heading anchors.
 *
 * The Table of Contents block lists the article's H2/H3 headings. Headings without
 * an HTML anchor get a generated id when the article body renders. Both sides use
 * shortlaxi_toc_items(), so links and ids always match.
 *
 * @package Shortlaxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collects H2/H3 heading blocks in document order.
 *
 * @param array $blocks Parsed blocks.
 * @param array $found  Accumulator.
 * @return array<int,array{level:int,text:string,anchor:string}>
 */
function shortlaxi_collect_headings( $blocks, $found = array() ) {
	foreach ( $blocks as $block ) {
		if ( 'core/heading' === $block['blockName'] ) {
			$level = (int) ( $block['attrs']['level'] ?? 2 );
			$text  = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $block['innerHTML'] ) ) );
			if ( in_array( $level, array( 2, 3 ), true ) && '' !== $text ) {
				$found[] = array(
					'level'  => $level,
					'text'   => $text,
					'anchor' => (string) ( $block['attrs']['anchor'] ?? '' ),
				);
			}
		}
		if ( ! empty( $block['innerBlocks'] ) ) {
			$found = shortlaxi_collect_headings( $block['innerBlocks'], $found );
		}
	}
	return $found;
}

/**
 * Table-of-contents entries for a post, each with a unique id.
 *
 * @param int $post_id Post ID.
 * @return array<int,array{level:int,text:string,id:string}>
 */
function shortlaxi_toc_items( $post_id ) {
	static $cache = array();

	$post_id = (int) $post_id;
	if ( isset( $cache[ $post_id ] ) ) {
		return $cache[ $post_id ];
	}

	$post  = get_post( $post_id );
	$items = array();
	$used  = array();

	if ( $post && has_blocks( $post->post_content ) ) {
		foreach ( shortlaxi_collect_headings( parse_blocks( $post->post_content ) ) as $heading ) {
			$id = $heading['anchor'];
			if ( '' === $id ) {
				$base = sanitize_title( $heading['text'] );
				$base = '' !== $base ? $base : 'section';
				$id   = $base;
				for ( $n = 2; isset( $used[ $id ] ); $n++ ) {
					$id = $base . '-' . $n;
				}
			}
			$used[ $id ] = true;
			$items[]     = array(
				'level' => $heading['level'],
				'text'  => $heading['text'],
				'id'    => $id,
			);
		}
	}

	$cache[ $post_id ] = $items;
	return $items;
}

/**
 * Tracks which post's content is rendering, so anchors are added only inside the article body.
 *
 * @param int|false|null $push Post ID to push, false to pop, null to read.
 * @return int|null Current post ID being rendered by core/post-content.
 */
function shortlaxi_content_stack( $push = null ) {
	static $stack = array();

	if ( is_int( $push ) ) {
		$stack[] = $push;
	} elseif ( false === $push ) {
		array_pop( $stack );
	}

	return $stack ? end( $stack ) : null;
}

add_filter(
	'render_block_data',
	static function ( $parsed_block ) {
		if ( 'core/post-content' === ( $parsed_block['blockName'] ?? '' ) ) {
			shortlaxi_content_stack( (int) get_the_ID() );
			shortlaxi_heading_cursor( true );
		}
		return $parsed_block;
	}
);

add_filter(
	'render_block_core/post-content',
	static function ( $content ) {
		shortlaxi_content_stack( false );
		return $content;
	}
);

/**
 * Position of the next unmatched entry in the current article's heading list.
 *
 * @param bool     $reset Reset to the first heading.
 * @param int|null $set   New position.
 * @return int
 */
function shortlaxi_heading_cursor( $reset = false, $set = null ) {
	static $cursor = 0;

	if ( $reset ) {
		$cursor = 0;
	} elseif ( null !== $set ) {
		$cursor = (int) $set;
	}

	return $cursor;
}

/**
 * Adds the table-of-contents id to H2/H3 headings in the main article body.
 *
 * @param string $content Rendered heading.
 * @param array  $block   Parsed heading block.
 * @return string
 */
function shortlaxi_heading_anchor( $content, $block ) {
	$post_id = shortlaxi_content_stack();
	if ( ! $post_id || ! is_singular() || get_queried_object_id() !== $post_id ) {
		return $content;
	}

	$level = (int) ( $block['attrs']['level'] ?? 2 );
	$text  = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $block['innerHTML'] ) ) );
	if ( ! in_array( $level, array( 2, 3 ), true ) || '' === $text ) {
		return $content;
	}

	// Match the next table-of-contents entry with the same text, so an extra heading
	// (for example from a synced pattern) cannot shift every later anchor.
	$items = shortlaxi_toc_items( $post_id );
	$index = null;
	for ( $i = shortlaxi_heading_cursor(), $count = count( $items ); $i < $count; $i++ ) {
		if ( $items[ $i ]['text'] === $text && $items[ $i ]['level'] === $level ) {
			$index = $i;
			break;
		}
	}
	if ( null === $index ) {
		return $content;
	}
	shortlaxi_heading_cursor( false, $index + 1 );

	$tags = new WP_HTML_Tag_Processor( $content );
	if ( $tags->next_tag( 'h' . $level ) && null === $tags->get_attribute( 'id' ) ) {
		$tags->set_attribute( 'id', $items[ $index ]['id'] );
	}

	return $tags->get_updated_html();
}
add_filter( 'render_block_core/heading', 'shortlaxi_heading_anchor', 10, 2 );
