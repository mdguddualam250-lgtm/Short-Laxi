<?php
/**
 * Title: Masthead
 * Slug: shortlaxi/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Site logo and title with primary navigation and a compact search toggle. Collapses to a menu button on small screens.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"align":"full","className":"shortlaxi-masthead","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull shortlaxi-masthead" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group">
			<!-- wp:site-logo {"width":40,"shouldSyncIcon":false} /-->
			<!-- wp:site-title {"level":0} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
		<div class="wp-block-group">
			<!-- wp:navigation {"overlayBackgroundColor":"base","overlayTextColor":"contrast","layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"}} /-->
			<!-- wp:search {"label":"<?php echo esc_attr_x( 'Search', 'search form label', 'shortlaxi' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr_x( 'Search Shortlaxi', 'search form placeholder', 'shortlaxi' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'search button text', 'shortlaxi' ); ?>","buttonPosition":"button-only","buttonUseIcon":true} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
