<?php
/**
 * Share Controls for the current post.
 *
 * Plain links work without JavaScript. "Copy link" and the native share sheet are
 * revealed by assets/js/shortlaxi.js only when the browser supports them.
 *
 * @package Shortlaxi
 *
 * @var array    $attributes Block attributes.
 * @var WP_Block $block      Block instance.
 */

$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
	return;
}

$url   = get_permalink( $post_id );
$title = wp_strip_all_tags( get_the_title( $post_id ) );
$enc_u = rawurlencode( $url );
$enc_t = rawurlencode( $title );

$networks = array(
	'x'        => array( 'X', "https://x.com/intent/post?url={$enc_u}&text={$enc_t}" ),
	'facebook' => array( 'Facebook', "https://www.facebook.com/sharer/sharer.php?u={$enc_u}" ),
	'linkedin' => array( 'LinkedIn', "https://www.linkedin.com/sharing/share-offsite/?url={$enc_u}" ),
	'whatsapp' => array( 'WhatsApp', 'https://wa.me/?text=' . rawurlencode( $title . ' ' . $url ) ),
	'email'    => array( __( 'Email', 'shortlaxi' ), "mailto:?subject={$enc_t}&body={$enc_u}" ),
);

$heading_id = wp_unique_id( 'shortlaxi-share-' );
$heading    = '' !== $attributes['heading'] ? $attributes['heading'] : __( 'Share this article', 'shortlaxi' );
?>
<section <?php echo get_block_wrapper_attributes( array( 'aria-labelledby' => $heading_id ) ); ?>>
	<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="screen-reader-text"><?php echo esc_html( $heading ); ?></h2>
	<ul class="shortlaxi-share__list">
		<li hidden>
			<button type="button" class="shortlaxi-share__button shortlaxi-share__native" data-url="<?php echo esc_url( $url ); ?>" data-title="<?php echo esc_attr( $title ); ?>">
				<?php echo shortlaxi_icon( 'share' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG. ?>
				<span><?php esc_html_e( 'Share', 'shortlaxi' ); ?></span>
			</button>
		</li>
		<li hidden>
			<button type="button" class="shortlaxi-share__button shortlaxi-share__copy" data-url="<?php echo esc_url( $url ); ?>">
				<?php echo shortlaxi_icon( 'link' ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG. ?>
				<span><?php esc_html_e( 'Copy link', 'shortlaxi' ); ?></span>
			</button>
		</li>
		<?php foreach ( $networks as $key => list( $label, $href ) ) : ?>
			<li>
				<a class="shortlaxi-share__button" href="<?php echo esc_url( $href ); ?>"<?php echo 'email' === $key ? '' : ' target="_blank" rel="noopener noreferrer"'; ?>>
					<?php echo shortlaxi_icon( $key ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG. ?>
					<span><?php echo esc_html( $label ); ?></span>
					<?php if ( 'email' !== $key ) : ?>
						<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'shortlaxi' ); ?></span>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
