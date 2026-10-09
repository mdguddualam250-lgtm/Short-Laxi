<?php
/**
 * Title: Byline
 * Slug: shortlaxi/post-byline
 * Inserter: no
 * Description: Author avatar and name, publish date and estimated reading time.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"className":"shortlaxi-byline","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group shortlaxi-byline">
	<!-- wp:avatar {"size":40} /-->

	<!-- wp:group {"style":{"spacing":{"blockGap":"0.125rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
	<div class="wp-block-group">
		<!-- wp:post-author-name {"isLink":true} /-->

		<!-- wp:group {"className":"shortlaxi-meta","style":{"spacing":{"blockGap":"0.375em"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
		<div class="wp-block-group shortlaxi-meta">
			<!-- wp:post-date /-->
			<!-- wp:post-time-to-read {"displayAsRange":false} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
