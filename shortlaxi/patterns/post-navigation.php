<?php
/**
 * Title: Post navigation
 * Slug: shortlaxi/post-navigation
 * Inserter: no
 * Description: Links to the previous and next stories.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"nav","ariaLabel":"<?php echo esc_attr_x( 'More stories', 'post navigation label', 'shortlaxi' ); ?>","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
<nav class="wp-block-group" aria-label="<?php echo esc_attr_x( 'More stories', 'post navigation label', 'shortlaxi' ); ?>">
	<!-- wp:post-navigation-link {"type":"previous","showTitle":true,"linkLabel":true,"arrow":"arrow"} /-->
	<!-- wp:post-navigation-link {"showTitle":true,"linkLabel":true,"arrow":"arrow"} /-->
</nav>
<!-- /wp:group -->
