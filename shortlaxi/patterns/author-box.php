<?php
/**
 * Title: Author box
 * Slug: shortlaxi/author-box
 * Inserter: no
 * Description: Author avatar, name and biography shown after an article.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"className":"shortlaxi-author-box","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group shortlaxi-author-box has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:post-author {"avatarSize":48,"showBio":true,"isLink":true} /-->
</div>
<!-- /wp:group -->
