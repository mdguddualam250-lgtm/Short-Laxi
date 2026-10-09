<?php
/**
 * Title: Top bar
 * Slug: shortlaxi/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Menu button, logo, prominent search on larger screens and a compact search toggle on phones.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"align":"full","className":"shortlaxi-topbar","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignfull shortlaxi-topbar">
	<!-- wp:group {"className":"shortlaxi-topbar__start","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group shortlaxi-topbar__start">
		<!-- wp:html -->
		<button type="button" class="shortlaxi-menu-toggle" aria-expanded="true" aria-label="<?php echo esc_attr__( 'Main menu', 'shortlaxi' ); ?>" hidden><svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>
		<!-- /wp:html -->

		<!-- wp:site-logo {"width":32,"shouldSyncIcon":false} /-->

		<!-- wp:site-title {"level":0,"className":"shortlaxi-brand"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:search {"label":"<?php echo esc_attr_x( 'Search articles', 'search form label', 'shortlaxi' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr_x( 'Search Shortlaxi', 'search form placeholder', 'shortlaxi' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'search button text', 'shortlaxi' ); ?>","buttonPosition":"button-inside","buttonUseIcon":true,"className":"shortlaxi-search shortlaxi-search--wide"} /-->

	<!-- wp:group {"className":"shortlaxi-topbar__end","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
	<div class="wp-block-group shortlaxi-topbar__end">
		<!-- wp:search {"label":"<?php echo esc_attr_x( 'Search articles', 'search form label', 'shortlaxi' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr_x( 'Search Shortlaxi', 'search form placeholder', 'shortlaxi' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'search button text', 'shortlaxi' ); ?>","buttonPosition":"button-only","buttonUseIcon":true,"className":"shortlaxi-search shortlaxi-search--compact"} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
