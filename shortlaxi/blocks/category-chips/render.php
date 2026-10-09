<?php
/**
 * Category Chips: "All" plus the most-used categories, as a scrollable row of links.
 *
 * @package Shortlaxi
 *
 * @var array $attributes Block attributes.
 */

$categories = get_categories(
	array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
		'number'     => max( 1, (int) $attributes['number'] ),
	)
);

if ( ! $categories ) {
	return;
}

$current_term = is_category() ? get_queried_object_id() : 0;
$is_home      = is_front_page() || is_home();
$chips        = array();

if ( ! empty( $attributes['showAll'] ) ) {
	$chips[] = array(
		'label'   => __( 'All', 'shortlaxi' ),
		'url'     => home_url( '/' ),
		'current' => $is_home,
	);
}

foreach ( $categories as $category ) {
	$chips[] = array(
		'label'   => $category->name,
		'url'     => get_category_link( $category ),
		'current' => $current_term === (int) $category->term_id,
	);
}
?>
<nav <?php echo get_block_wrapper_attributes( array( 'aria-label' => esc_attr__( 'Categories', 'shortlaxi' ) ) ); ?>>
	<ul class="shortlaxi-chips">
		<?php foreach ( $chips as $chip ) : ?>
			<li><a class="shortlaxi-chip" href="<?php echo esc_url( $chip['url'] ); ?>"<?php echo $chip['current'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $chip['label'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</nav>
