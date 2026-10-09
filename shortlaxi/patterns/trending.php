<?php
/**
 * Title: Trending
 * Slug: shortlaxi/trending
 * Categories: shortlaxi, query
 * Description: Ranked row of the most discussed stories.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","anchor":"trending","className":"shortlaxi-section","layout":{"type":"default"}} -->
<section id="trending" class="wp-block-group alignwide shortlaxi-section">
	<!-- wp:group {"className":"shortlaxi-section__header","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group shortlaxi-section__header">
		<!-- wp:heading {"className":"shortlaxi-section__title is-trending"} -->
		<h2 class="wp-block-heading shortlaxi-section__title is-trending"><?php echo esc_html_x( 'Trending', 'front page section heading', 'shortlaxi' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"className":"shortlaxi-section__more"} -->
		<p class="shortlaxi-section__more"><a href="<?php echo esc_url( shortlaxi_view_url( 'trending' ) ); ?>"><?php echo esc_html_x( 'See all', 'link to the full trending list', 'shortlaxi' ); ?></a></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":12,"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"comment_count","author":"","search":"","exclude":[],"sticky":"","inherit":false,"shortlaxiRole":"trending"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"className":"shortlaxi-grid is-ranked","layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"17rem"}} -->
			<!-- wp:pattern {"slug":"shortlaxi/story-card"} /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
