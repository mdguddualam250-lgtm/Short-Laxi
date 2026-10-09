<?php
/**
 * Title: Related articles
 * Slug: shortlaxi/more-stories
 * Categories: shortlaxi, query
 * Description: Up to four stories from the same category as the article being read.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"aside","align":"wide","className":"shortlaxi-section shortlaxi-related","layout":{"type":"default"}} -->
<aside class="wp-block-group alignwide shortlaxi-section shortlaxi-related">
	<!-- wp:heading {"className":"shortlaxi-section__title"} -->
	<h2 class="wp-block-heading shortlaxi-section__title"><?php echo esc_html_x( 'Related articles', 'section heading after an article', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":20,"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"excludeCurrent":true,"shortlaxiRole":"related"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"className":"shortlaxi-grid","layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"15rem"}} -->
			<!-- wp:pattern {"slug":"shortlaxi/story-card"} /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</aside>
<!-- /wp:group -->
