<?php
/**
 * Query Loop roles.
 *
 * Templates tag Query Loop blocks with a "shortlaxiRole" key inside the block's
 * "query" attribute. The key travels to the server in block context and is used
 * here to shape the WP_Query. Everything else (post type, per page, offset,
 * pagination) remains editable in the Site Editor.
 *
 * Roles:
 * - featured: newest sticky post, or the newest post when nothing is sticky.
 * - top:      newest posts, excluding the featured story.
 * - latest:   same, used for the paginated "Latest articles" feed.
 * - trending: most discussed first (comment count), newest as tie-break.
 *             Hook "shortlaxi_trending_post_ids" to rank by real analytics.
 * - related:  same category as the article being read, excluding it; falls
 *             back to recent posts when the category has no other stories.
 *
 * @package Shortlaxi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ID of the story shown in the featured slot.
 *
 * @return int Post ID, or 0 when there are no posts.
 */
function shortlaxi_featured_post_id() {
	static $id = null;

	if ( null !== $id ) {
		return $id;
	}

	$sticky = array_filter( array_map( 'absint', (array) get_option( 'sticky_posts', array() ) ) );
	$args   = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 1,
		'fields'              => 'ids',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	$ids = $sticky ? get_posts( $args + array( 'post__in' => $sticky ) ) : array();
	if ( ! $ids ) {
		$ids = get_posts( $args );
	}

	$id = $ids ? (int) $ids[0] : 0;

	/**
	 * Filters the post shown as the featured story.
	 *
	 * @param int $id Post ID (0 for none).
	 */
	$id = (int) apply_filters( 'shortlaxi_featured_post_id', $id );

	return $id;
}

/**
 * Applies a Query Loop role to the query vars.
 *
 * @param array    $query Query vars built from the block.
 * @param WP_Block $block Post Template block (carries the Query context).
 * @return array
 */
function shortlaxi_query_roles( $query, $block ) {
	$role = $block->context['query']['shortlaxiRole'] ?? '';

	switch ( $role ) {
		case 'featured':
			$featured = shortlaxi_featured_post_id();
			if ( $featured ) {
				$query['post__in']            = array( $featured );
				$query['posts_per_page']      = 1;
				$query['ignore_sticky_posts'] = true;
				unset( $query['offset'] );
			}
			break;

		case 'top':
		case 'latest':
			$featured = shortlaxi_featured_post_id();
			if ( $featured ) {
				$query['post__not_in'] = array_merge( (array) ( $query['post__not_in'] ?? array() ), array( $featured ) );
			}
			break;

		case 'trending':
			/**
			 * Filters an explicit, ordered list of trending post IDs (for example from site stats).
			 * Return an empty array to rank by comment count.
			 *
			 * @param int[] $ids Post IDs, most trending first.
			 */
			$ids = array_filter( array_map( 'absint', (array) apply_filters( 'shortlaxi_trending_post_ids', array() ) ) );
			if ( $ids ) {
				$query['post__in'] = $ids;
				$query['orderby']  = 'post__in';
			} else {
				$query['orderby'] = array(
					'comment_count' => 'DESC',
					'date'          => 'DESC',
				);
			}
			$query['ignore_sticky_posts'] = true;
			break;

		case 'related':
			$current = is_singular() ? get_queried_object_id() : 0;
			$cats    = $current ? wp_get_post_categories( $current ) : array();
			if ( $cats ) {
				$siblings = get_posts(
					array(
						'category__in'   => $cats,
						'post__not_in'   => array( $current ),
						'posts_per_page' => 1,
						'fields'         => 'ids',
						'no_found_rows'  => true,
					)
				);
				if ( $siblings ) {
					$query['category__in'] = $cats;
				}
			}
			if ( $current ) {
				$query['post__not_in'] = array_merge( (array) ( $query['post__not_in'] ?? array() ), array( $current ) );
			}
			$query['ignore_sticky_posts'] = true;
			break;
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', 'shortlaxi_query_roles', 10, 2 );

/**
 * Tags Query Loop queries that use an offset, so their page count can be corrected.
 *
 * WP_Query::$found_posts ignores "offset", so a Query Loop that skips the first N
 * posts reports N too many results and links to empty trailing pages.
 *
 * @param array    $query Query vars built from the block.
 * @param WP_Block $block Block carrying the Query context.
 * @return array
 */
function shortlaxi_tag_offset_queries( $query, $block ) {
	$offset = (int) ( $block->context['query']['offset'] ?? 0 );
	if ( $offset > 0 && empty( $block->context['query']['inherit'] ) ) {
		$query['shortlaxi_offset'] = $offset;
	}
	return $query;
}
add_filter( 'query_loop_block_query_vars', 'shortlaxi_tag_offset_queries', 20, 2 );

/**
 * Removes the skipped posts from the total of an offset Query Loop.
 *
 * @param int      $found_posts Number of posts found.
 * @param WP_Query $query       The query.
 * @return int
 */
function shortlaxi_offset_found_posts( $found_posts, $query ) {
	$offset = (int) $query->get( 'shortlaxi_offset' );
	return $offset ? max( 0, (int) $found_posts - $offset ) : $found_posts;
}
add_filter( 'found_posts', 'shortlaxi_offset_found_posts', 10, 2 );
