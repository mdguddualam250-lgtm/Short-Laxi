<?php
/**
 * Table of Contents for the current article.
 *
 * Renders nothing unless the article has at least "minHeadings" H2/H3 headings.
 *
 * @package Shortlaxi
 *
 * @var array    $attributes Block attributes.
 * @var WP_Block $block      Block instance.
 */

$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
$items   = $post_id ? shortlaxi_toc_items( $post_id ) : array();

if ( count( $items ) < max( 2, (int) $attributes['minHeadings'] ) ) {
	return;
}

$title_id = wp_unique_id( 'shortlaxi-toc-' );
?>
<nav <?php echo get_block_wrapper_attributes( array( 'aria-labelledby' => $title_id ) ); ?>>
	<details class="shortlaxi-toc__details">
		<summary class="shortlaxi-toc__summary">
			<?php echo shortlaxi_icon( 'list' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG. ?>
			<span id="<?php echo esc_attr( $title_id ); ?>"><?php esc_html_e( 'In this article', 'shortlaxi' ); ?></span>
			<span class="shortlaxi-toc__count">
				<?php
				/* translators: %d: number of sections in the article. */
				echo esc_html( sprintf( _n( '%d section', '%d sections', count( $items ), 'shortlaxi' ), count( $items ) ) );
				?>
			</span>
		</summary>
		<ol class="shortlaxi-toc__list">
			<?php foreach ( $items as $item ) : ?>
				<li class="shortlaxi-toc__item is-level-<?php echo (int) $item['level']; ?>">
					<a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ol>
	</details>
</nav>
