<?php
/**
 * Title: Front page heading
 * Slug: shortlaxi/hidden-home-heading
 * Inserter: no
 * Description: Visually hidden page heading so the front page has a single, meaningful h1 for assistive technology and search engines.
 *
 * @package Shortlaxi
 */

?>
<!-- wp:heading {"level":1,"className":"screen-reader-text"} -->
<h1 class="wp-block-heading screen-reader-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
<!-- /wp:heading -->
