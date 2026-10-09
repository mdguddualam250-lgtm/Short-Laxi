<?php
/**
 * Title: Sidebar
 * Slug: shortlaxi/sidebar
 * Categories: shortlaxi
 * Block Types: core/template-part/uncategorized
 * Description: Primary destinations and categories. Collapses to an icon rail on desktop and opens as a drawer on smaller screens.
 *
 * @package Shortlaxi
 */

$shortlaxi_links = array_merge( array( 'home' => __( 'Home', 'shortlaxi' ) ), shortlaxi_views() );
?>
<!-- wp:group {"className":"shortlaxi-sidebar__inner","layout":{"type":"default"}} -->
<div class="wp-block-group shortlaxi-sidebar__inner">
	<!-- wp:navigation {"overlayMenu":"never","className":"shortlaxi-sidenav","layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"2px"}}} -->
	<?php foreach ( $shortlaxi_links as $shortlaxi_view => $shortlaxi_label ) : ?>
		<!-- wp:navigation-link {"label":"<?php echo esc_attr( $shortlaxi_label ); ?>","url":"<?php echo esc_url( shortlaxi_view_url( $shortlaxi_view ) ); ?>","kind":"custom","isTopLevelLink":true,"className":"shortlaxi-view-<?php echo esc_attr( $shortlaxi_view ); ?>"} /-->
	<?php endforeach; ?>
	<!-- /wp:navigation -->

	<!-- wp:group {"className":"shortlaxi-sidebar__section","layout":{"type":"default"}} -->
	<div class="wp-block-group shortlaxi-sidebar__section">
		<!-- wp:heading {"level":2,"className":"shortlaxi-sidebar__heading"} -->
		<h2 class="wp-block-heading shortlaxi-sidebar__heading"><?php echo esc_html_x( 'Categories', 'sidebar heading', 'shortlaxi' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:categories {"className":"shortlaxi-sidebar-categories"} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
