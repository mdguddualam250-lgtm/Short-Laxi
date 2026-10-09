<?php
/**
 * Title: Footer
 * Slug: shortlaxi/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Compact footer with site identity, secondary links and copyright.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"className":"shortlaxi-footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"100rem"}} -->
<div class="wp-block-group shortlaxi-footer" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","orientation":"vertical"}} -->
		<div class="wp-block-group">
			<!-- wp:site-title {"level":0,"className":"shortlaxi-brand"} /-->
			<!-- wp:site-tagline /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:navigation {"overlayMenu":"never","className":"shortlaxi-footer-nav","layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {"textColor":"contrast-2","fontSize":"x-small"} -->
	<p class="has-contrast-2-color has-text-color has-x-small-font-size"><?php /* translators: 1: current year, 2: site name. */ echo esc_html( sprintf( __( '© %1$s %2$s. All rights reserved.', 'shortlaxi' ), gmdate( 'Y' ), get_bloginfo( 'name' ) ) ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
