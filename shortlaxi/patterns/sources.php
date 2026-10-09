<?php
/**
 * Title: Sources and references
 * Slug: shortlaxi/sources
 * Categories: shortlaxi, text
 * Keywords: sources, references, citations, bibliography
 * Description: A styled, numbered list of sources to add at the end of an article.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:group {"className":"shortlaxi-sources","layout":{"type":"constrained"}} -->
<div class="wp-block-group shortlaxi-sources">
	<!-- wp:heading -->
	<h2 class="wp-block-heading"><?php echo esc_html_x( 'Sources and references', 'heading for an article bibliography', 'shortlaxi' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:list {"ordered":true} -->
	<ol class="wp-block-list">
		<!-- wp:list-item -->
		<li><?php echo esc_html_x( 'Author or organisation, “Title of the source”, Publisher, date. Add the link to the title.', 'example source entry', 'shortlaxi' ); ?></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><?php echo esc_html_x( 'Interview or dataset, with the date accessed.', 'example source entry', 'shortlaxi' ); ?></li>
		<!-- /wp:list-item -->
	</ol>
	<!-- /wp:list -->
</div>
<!-- /wp:group -->
