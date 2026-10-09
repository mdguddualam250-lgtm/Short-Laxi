<?php
/**
 * Title: Comments
 * Slug: shortlaxi/comments
 * Inserter: no
 * Description: Discussion thread and reply form.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:comments {"className":"wp-block-comments-query-loop","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-comments wp-block-comments-query-loop" style="margin-top:var(--wp--preset--spacing--50)">
	<!-- wp:comments-title {"level":2,"fontSize":"large"} /-->

	<!-- wp:comment-template -->
		<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--40)">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group">
				<!-- wp:avatar {"size":32} /-->
				<!-- wp:comment-author-name {"fontFamily":"sans","fontSize":"small"} /-->
				<!-- wp:comment-date {"fontFamily":"sans","fontSize":"x-small","textColor":"contrast-2"} /-->
			</div>
			<!-- /wp:group -->
			<!-- wp:comment-content {"fontSize":"small"} /-->
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex"}} -->
			<div class="wp-block-group">
				<!-- wp:comment-reply-link {"fontFamily":"sans","fontSize":"x-small"} /-->
				<!-- wp:comment-edit-link {"fontFamily":"sans","fontSize":"x-small"} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:comment-template -->

	<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
		<!-- wp:comments-pagination-previous /-->
		<!-- wp:comments-pagination-numbers /-->
		<!-- wp:comments-pagination-next /-->
	<!-- /wp:comments-pagination -->

	<!-- wp:post-comments-form /-->
</div>
<!-- /wp:comments -->
