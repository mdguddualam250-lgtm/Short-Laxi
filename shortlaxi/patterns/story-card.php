<?php
/**
 * Title: Article card
 * Slug: shortlaxi/story-card
 * Inserter: no
 * Description: 16:9 thumbnail, category, title, excerpt, date, reading time and bookmark button. Used inside Query Loop post templates.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"className":"shortlaxi-card","layout":{"type":"default"}} -->
<div class="wp-block-group shortlaxi-card">
	<!-- wp:post-featured-image {"aspectRatio":"16/9","sizeSlug":"medium_large","className":"shortlaxi-card__media"} /-->

	<!-- wp:group {"className":"shortlaxi-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group shortlaxi-card__body">
		<!-- wp:post-terms {"term":"category","className":"shortlaxi-card__kicker"} /-->
		<!-- wp:post-title {"level":3,"isLink":true,"className":"shortlaxi-card__title","fontSize":"medium"} /-->
		<!-- wp:post-excerpt {"excerptLength":20,"className":"shortlaxi-card__excerpt"} /-->

		<!-- wp:group {"className":"shortlaxi-card__meta","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group shortlaxi-card__meta">
			<!-- wp:group {"className":"shortlaxi-meta","style":{"spacing":{"blockGap":"0.375em"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group shortlaxi-meta">
				<!-- wp:post-date /-->
				<!-- wp:post-time-to-read {"displayAsRange":false} /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:shortlaxi/bookmark-button /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
