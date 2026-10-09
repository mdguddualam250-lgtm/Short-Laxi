<?php
/**
 * Title: Featured story
 * Slug: shortlaxi/front-lead
 * Categories: shortlaxi, query
 * Description: Large featured article. Shows the newest sticky post, or the newest post when none is sticky.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:query {"queryId":10,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"shortlaxiRole":"featured"},"align":"wide","className":"shortlaxi-featured"} -->
<div class="wp-block-query alignwide shortlaxi-featured">
	<!-- wp:post-template -->
		<!-- wp:group {"className":"shortlaxi-hero","layout":{"type":"default"}} -->
		<div class="wp-block-group shortlaxi-hero">
			<!-- wp:post-featured-image {"aspectRatio":"16/9","sizeSlug":"large","className":"shortlaxi-hero__media"} /-->

			<!-- wp:group {"className":"shortlaxi-hero__body","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group shortlaxi-hero__body">
				<!-- wp:paragraph {"className":"shortlaxi-label"} -->
				<p class="shortlaxi-label"><?php echo esc_html_x( 'Featured', 'label on the featured story', 'shortlaxi' ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:post-terms {"term":"category"} /-->
				<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xx-large"} /-->
				<!-- wp:post-excerpt {"excerptLength":36,"fontSize":"medium"} /-->
				<!-- wp:pattern {"slug":"shortlaxi/post-byline"} /-->
				<!-- wp:read-more {"content":"<?php echo esc_attr_x( 'Read story', 'featured story button', 'shortlaxi' ); ?>","className":"shortlaxi-button"} /-->
			</div>
			<!-- /wp:group -->
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
