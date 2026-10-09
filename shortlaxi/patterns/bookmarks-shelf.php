<?php
/**
 * Title: Saved for later
 * Slug: shortlaxi/bookmarks-shelf
 * Categories: shortlaxi
 * Description: The reader's most recent bookmarks. Hidden until they save something (or follow a link to #bookmarks).
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"tagName":"section","align":"wide","anchor":"bookmarks","className":"shortlaxi-section shortlaxi-bookmarks-shelf","layout":{"type":"default"}} -->
<section id="bookmarks" class="wp-block-group alignwide shortlaxi-section shortlaxi-bookmarks-shelf">
	<!-- wp:heading {"className":"shortlaxi-section__title"} -->
	<h2 class="wp-block-heading shortlaxi-section__title"><?php echo esc_html_x( 'Saved for later', 'front page section heading', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:shortlaxi/bookmarks {"limit":4,"hideWhenEmpty":true} /-->
</section>
<!-- /wp:group -->
