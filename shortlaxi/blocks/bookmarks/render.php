<?php
/**
 * Bookmarked Articles: an empty, labelled container that assets/js/shortlaxi.js fills
 * with cards fetched from the REST API for the IDs saved in this browser.
 *
 * @package Shortlaxi
 *
 * @var array $attributes Block attributes.
 */

$extra = array(
	'data-endpoint' => esc_url_raw( rest_url( 'wp/v2/posts' ) ),
	'data-limit'    => (string) max( 0, (int) $attributes['limit'] ),
	'aria-live'     => 'polite',
	'aria-busy'     => 'false',
);
if ( ! empty( $attributes['hideWhenEmpty'] ) ) {
	// Start hidden; the script reveals the list once it finds saved articles.
	$extra['class'] = 'hide-when-empty is-empty';
}
?>
<div <?php echo get_block_wrapper_attributes( $extra ); ?>>
	<ul class="shortlaxi-bookmarks__grid" hidden></ul>
	<div class="shortlaxi-bookmarks__empty">
		<p><?php esc_html_e( 'No bookmarks yet. Use the bookmark button on any article to save it here. Bookmarks stay in this browser.', 'shortlaxi' ); ?></p>
		<noscript><p><?php esc_html_e( 'Bookmarks need JavaScript to be enabled.', 'shortlaxi' ); ?></p></noscript>
	</div>
</div>
