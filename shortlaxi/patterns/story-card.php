<?php
/**
 * Title: Story card
 * Slug: shortlaxi/story-card
 * Inserter: no
 * Description: Image, section kicker, headline, summary and date. Used inside Query Loop post templates.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group">
	<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","sizeSlug":"medium_large","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}}} /-->
	<!-- wp:post-terms {"term":"category"} /-->
	<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->
	<!-- wp:post-excerpt {"excerptLength":24} /-->
	<!-- wp:post-date /-->
</div>
<!-- /wp:group -->
