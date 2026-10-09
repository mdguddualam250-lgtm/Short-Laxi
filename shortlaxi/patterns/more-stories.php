<?php
/**
 * Title: More stories
 * Slug: shortlaxi/more-stories
 * Categories: shortlaxi, query
 * Description: Three recent stories, excluding the one being read.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"aside","align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<aside class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"className":"is-style-kicker"} -->
	<h2 class="wp-block-heading is-style-kicker"><?php echo esc_html_x( 'More from Shortlaxi', 'section heading after an article', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":20,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"excludeCurrent":true}} -->
	<div class="wp-block-query">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
			<!-- wp:pattern {"slug":"shortlaxi/story-card"} /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</aside>
<!-- /wp:group -->
