<?php
/**
 * Title: Footer
 * Slug: shortlaxi/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Site identity, section links, secondary navigation and copyright line.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"align":"full","backgroundColor":"base-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:site-title {"level":0} /-->
			<!-- wp:site-tagline /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":2,"className":"is-style-kicker"} -->
			<h2 class="wp-block-heading is-style-kicker"><?php echo esc_html_x( 'Sections', 'footer heading', 'shortlaxi' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:categories {"className":"shortlaxi-footer-list"} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":2,"className":"is-style-kicker"} -->
			<h2 class="wp-block-heading is-style-kicker"><?php echo esc_html_x( 'Shortlaxi', 'footer heading', 'shortlaxi' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
	<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
	<!-- /wp:separator -->

	<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"textColor":"contrast-2","fontSize":"x-small","fontFamily":"sans"} -->
		<p class="has-contrast-2-color has-text-color has-sans-font-family has-x-small-font-size"><?php /* translators: 1: current year, 2: site name. */ echo esc_html( sprintf( __( '© %1$s %2$s. All rights reserved.', 'shortlaxi' ), gmdate( 'Y' ), get_bloginfo( 'name' ) ) ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
