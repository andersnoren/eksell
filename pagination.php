<?php

global $wp_query;

// Set the type of pagination to use. Available types: button, links, and scroll.
$pagination_type = get_theme_mod( 'eksell_pagination_type', 'button' );

// Combine the query with the query_vars into a single array.
$query_args = array_merge( $wp_query->query, $wp_query->query_vars );

// If max_num_pages is not already set, add it.
if ( ! array_key_exists( 'max_num_pages', $query_args ) ) {
	$query_args['max_num_pages'] = $wp_query->max_num_pages;
}

// If post_status is not already set, add it.
if ( ! array_key_exists( 'post_status', $query_args ) ) {
	$query_args['post_status'] = 'publish';
}

// Make sure the paged value exists and is at least 1.
if ( ! array_key_exists( 'paged', $query_args ) || 0 == $query_args['paged'] ) {
	$query_args['paged'] = 1;
}

// Encode our modified query.
$json_query_args = wp_json_encode( $query_args ); 

// Set up the wrapper class.
$wrapper_class = 'pagination-type-' . $pagination_type;

// Indicate when we're loading into the last page, so the pagination can be hidden for the button and scroll types.
if ( ! ( $query_args['max_num_pages'] > $query_args['paged'] ) ) {
	$wrapper_class .= ' last-page';
} else {
	$wrapper_class .= '';
}

?>

<div class="pagination-wrapper <?php echo esc_attr( $wrapper_class ); ?>">

	<div id="pagination" class="section-inner" data-query-args="<?php echo esc_attr( $json_query_args ); ?>" data-pagination-type="<?php echo esc_attr( $pagination_type ); ?>" data-load-more-target=".load-more-target">

		<?php if ( ( $query_args['max_num_pages'] > $query_args['paged'] ) ) : ?>

			<?php if ( $pagination_type == 'scroll' ) : ?>
				<div class="scroll-loading">
					<div class="loading-icon">
						<span class="dot-pulse"></span>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $pagination_type == 'button' ) : ?>
				<button id="load-more" class="d-no-js-none do-spot spot-fade-up">
					<span class="load-text"><?php esc_html_e( 'Load More', 'eksell' ); ?></span>
					<span class="loading-icon"><span class="dot-pulse"></span></span>
				</button>
			<?php endif;

			// The pagination links also work as a no-js fallback, so they always need to be output.
			$prev_link 	= get_previous_posts_link( '<span class="arrow stroke-cc">' . eksell_get_theme_svg( 'ui', 'arrow-left', 96, 49 ) . '</span><span class="screen-reader-text">' . esc_html__( 'Previous Page', 'eksell' ) . '</span></span>' );
			$next_link 	= get_next_posts_link( '<span class="screen-reader-text">' . esc_html__( 'Next Page', 'eksell' ) . '</span></span><span class="arrow stroke-cc">' . eksell_get_theme_svg( 'ui', 'arrow-right', 96, 49 ) . '</span>' );

			if ( $prev_link || $next_link ) :
				$pagination_class = ! $prev_link ? ' only-next' : ( ! $next_link ? ' only-previous' : '' );
				?>

				<nav class="link-pagination<?php echo esc_attr( $pagination_class ); ?>">

					<?php if ( $prev_link ) : ?>
						<div class="previous-wrapper">
							<?php echo $prev_link; ?>
						</div><!-- .previous-wrapper -->
					<?php endif; ?>

					<?php if ( $next_link ) : ?>
						<div class="next-wrapper">
							<?php echo $next_link; ?>
						</div><!-- .next-wrapper -->
					<?php endif; ?>

				</nav><!-- .posts-pagination -->

			<?php endif; ?>

		<?php endif; ?>

	</div><!-- #pagination -->

</div><!-- .pagination-wrapper -->