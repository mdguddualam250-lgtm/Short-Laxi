<?php
/**
 * Bookmark toggle for a post. Bookmarks are stored in the reader's browser (localStorage),
 * so the button is revealed only once assets/js/shortlaxi.js has loaded.
 *
 * @package Shortlaxi
 *
 * @var array    $attributes Block attributes.
 * @var WP_Block $block      Block instance.
 */

$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
if ( ! $post_id || 'post' !== get_post_type( $post_id ) ) {
	return;
}

$title = wp_strip_all_tags( get_the_title( $post_id ) );
$extra = array(
	'class'        => ! empty( $attributes['showLabel'] ) ? 'has-label' : '',
	'type'         => 'button',
	'hidden'       => 'hidden',
	'aria-pressed' => 'false',
	'data-post-id' => (string) $post_id,
);
?>
<button <?php echo get_block_wrapper_attributes( $extra ); ?>>
	<?php echo shortlaxi_icon( 'bookmark' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG. ?>
	<span class="shortlaxi-bookmark__label<?php echo empty( $attributes['showLabel'] ) ? ' screen-reader-text' : ''; ?>"><?php esc_html_e( 'Save', 'shortlaxi' ); ?></span>
	<span class="screen-reader-text">
		<?php
		/* translators: %s: article title. */
		echo esc_html( sprintf( __( '“%s”', 'shortlaxi' ), $title ) );
		?>
	</span>
</button>
