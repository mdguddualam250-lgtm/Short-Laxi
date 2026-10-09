<?php
/**
 * Title: Latest articles
 * Slug: shortlaxi/latest-stories
 * Categories: shortlaxi, query
 * Description: Paginated card grid that continues after the top stories. Pages change without a full reload.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","anchor":"latest","className":"shortlaxi-section","layout":{"type":"default"}} -->
<section id="latest" class="wp-block-group alignwide shortlaxi-section">
	<!-- wp:heading {"className":"shortlaxi-section__title"} -->
	<h2 class="wp-block-heading shortlaxi-section__title"><?php echo esc_html_x( 'Latest articles', 'front page section heading', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":13,"query":{"perPage":12,"pages":0,"offset":8,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"shortlaxiRole":"latest"},"enhancedPagination":true} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"className":"shortlaxi-grid","layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"17rem"}} -->
			<!-- wp:pattern {"slug":"shortlaxi/story-card"} /-->
		<!-- /wp:post-template -->

		<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
			<!-- wp:query-pagination-previous /-->
			<!-- wp:query-pagination-numbers /-->
			<!-- wp:query-pagination-next /-->
		<!-- /wp:query-pagination -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html_x( 'More stories are on the way.', 'Message shown when there are no older posts', 'shortlaxi' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
