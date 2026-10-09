<?php
/**
 * Title: Lead story and top stories
 * Slug: shortlaxi/front-lead
 * Categories: shortlaxi, query
 * Description: The newest story as a large lead, with the next four stories listed beside it. Stacks on phones.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide">
	<!-- wp:column {"width":"66.66%"} -->
	<div class="wp-block-column" style="flex-basis:66.66%">
		<!-- wp:query {"queryId":10,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">
					<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","sizeSlug":"large"} /-->
					<!-- wp:post-terms {"term":"category"} /-->
					<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xx-large"} /-->
					<!-- wp:post-excerpt {"excerptLength":40,"fontSize":"medium"} /-->
					<!-- wp:pattern {"slug":"shortlaxi/post-byline"} /-->
				</div>
				<!-- /wp:group -->
			<!-- /wp:post-template -->

			<!-- wp:query-no-results -->
				<!-- wp:paragraph -->
				<p><?php echo esc_html_x( 'Stories will appear here once they are published.', 'Message shown when there are no posts yet', 'shortlaxi' ); ?></p>
				<!-- /wp:paragraph -->
			<!-- /wp:query-no-results -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"width":"33.33%"} -->
	<div class="wp-block-column" style="flex-basis:33.33%">
		<!-- wp:heading {"className":"is-style-kicker"} -->
		<h2 class="wp-block-heading is-style-kicker"><?php echo esc_html_x( 'Top stories', 'front page section heading', 'shortlaxi' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:query {"queryId":11,"query":{"perPage":4,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false}} -->
		<div class="wp-block-query">
			<!-- wp:post-template {"className":"shortlaxi-story-list"} -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">
					<!-- wp:post-terms {"term":"category"} /-->
					<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->
					<!-- wp:post-date /-->
				</div>
				<!-- /wp:group -->
			<!-- /wp:post-template -->
		</div>
		<!-- /wp:query -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
