<?php get_header(); ?>

<main id="site-content" role="main">

	<?php

	$archive_title 		= get_the_archive_title();
	$archive_subtitle 	= get_the_archive_description( '<div>', '</div>' );

	do_action( 'eksell_before_archive_header' );
	
	if ( $archive_title || $archive_subtitle ) : ?>
		
		<header class="archive-header section-inner">

			<?php 

			do_action( 'eksell_archive_header_start' );
			
			if ( $archive_title ) : 
				?>
				<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
				<?php 
			endif;
			
			if ( $archive_subtitle ) : 
				?>
				<div class="archive-subtitle mw-small intro-text contain-margins"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
				<?php 
			endif;
			
			do_action( 'eksell_archive_header_end' ); 
			
			?>
			
		</header><!-- .archive-header -->

		<?php 
	endif; 

	do_action( 'eksell_after_archive_header' );
	
	?>

	<div class="posts">

		<div class="section-inner">

			<?php if ( have_posts() ) : 

				/*
				* @hooked eksell_output_previous_posts_link - 10
				*/
				do_action( 'eksell_posts_start' );

				// Get the column classes, based on the settings in the Customizer
				$archive_columns_classes_array 	= eksell_get_archive_columns_classes();
				$archive_columns_classes 		= $archive_columns_classes_array ? ' ' . implode( ' ', $archive_columns_classes_array ) : '';
			
				?>

				<div class="posts-grid grid load-more-target<?php echo esc_attr( $archive_columns_classes ); ?>">

					<div class="col grid-sizer"></div>
				
					<?php 

					// Calculate the current offset
					$iteration = intval( $wp_query->get( 'posts_per_page' ) ) * intval( $wp_query->get( 'paged' ) );

					while ( have_posts() ) : the_post(); 

						$iteration++;

						/**
						 * Fires before output of a grid item in the posts loop.
						 * 
						 * @param int   $post_id 	Post ID.
						 * @param int   $iteration 	The current iteration of the loop.
						 */
						do_action( 'eksell_posts_loop_before_grid_item', $post->ID, $iteration );
						?>

						<div class="col article-wrapper">
							<?php get_template_part( 'inc/parts/preview', get_post_type() ); ?>
						</div>

						<?php 

						/**
						 * Fires after output of a grid item in the posts loop.
						 */
						do_action( 'eksell_posts_loop_after_grid_item', $post->ID, $iteration );

					endwhile;
					?>

				</div><!-- .posts-grid -->

				<?php do_action( 'eksell_posts_end' ); ?>

			<?php elseif ( is_search() ) : ?>

				<div class="no-search-results-form">

					<?php get_search_form(); ?>

				</div><!-- .no-search-results -->

			<?php endif; ?>
		
		</div><!-- .section-inner -->

	</div><!-- .posts -->

	<?php get_template_part( 'pagination' ); ?>

</main><!-- #site-content -->

<?php get_footer(); ?>
