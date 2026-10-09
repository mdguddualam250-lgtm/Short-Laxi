<?php
/**
 * Title: Top stories grid
 * Slug: shortlaxi/top-stories
 * Categories: shortlaxi, query
 * Description: Responsive 16:9 card grid of the newest stories after the featured one.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","className":"shortlaxi-section","layout":{"type":"default"}} -->
<section class="wp-block-group alignwide shortlaxi-section">
	<!-- wp:heading {"className":"shortlaxi-section__title"} -->
	<h2 class="wp-block-heading shortlaxi-section__title"><?php echo esc_html_x( 'Top stories', 'front page section heading', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":11,"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"shortlaxiRole":"top"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"className":"shortlaxi-grid","layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"17rem"}} -->
			<!-- wp:pattern {"slug":"shortlaxi/story-card"} /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
