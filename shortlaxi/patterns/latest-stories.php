<?php
/**
 * Title: Latest stories grid
 * Slug: shortlaxi/latest-stories
 * Categories: shortlaxi, query
 * Description: A paginated, responsive grid of stories that skips the five shown in the lead section. One column on phones, up to three on desktop.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","layout":{"type":"default"}} -->
<section class="wp-block-group alignwide">
	<!-- wp:heading {"className":"is-style-kicker"} -->
	<h2 class="wp-block-heading is-style-kicker"><?php echo esc_html_x( 'Latest', 'front page section heading', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":12,"query":{"perPage":9,"pages":0,"offset":5,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
			<!-- wp:pattern {"slug":"shortlaxi/story-card"} /-->
		<!-- /wp:post-template -->

		<!-- wp:pattern {"slug":"shortlaxi/query-pagination"} /-->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html_x( 'More stories are on the way.', 'Message shown when there are no older posts', 'shortlaxi' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
