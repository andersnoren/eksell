<?php

/* 
Template Name: Portfolio Template
*/

/*
 * Matches the structure of index.php when it's used to output Jetpack Portfolio items. The page template
 * can be used to display the Jetpack Portfolio archive as the front page. If the Jetpack Portfolio post type 
 * doesn't exist, this page template is unlisted by eksell_conditional_page_templates().
 */

get_header(); ?>

<main id="site-content" role="main">

	<div class="site-content-inner">

		<?php

		// Use the Jetpack Portfolio archive text setting in the Customizer, if it has a value.
		$archive_title 			= get_theme_mod( 'eksell_jetpack_portfolio_archive_text', '' ) ? get_theme_mod( 'eksell_jetpack_portfolio_archive_text', '' ) : get_the_title();
		$archive_description 	= get_the_content();

		do_action( 'eksell_before_archive_header' );
		
		if ( $archive_title || $archive_description || ( eksell_show_home_filter() ) ) : 

			// By default, only use the grid structure in the archive header if we have both a title and a description.
			$use_header_grid = apply_filters( 'eksell_archive_header_use_grid', $archive_title && $archive_description );

			?>
			
			<header class="archive-header section-inner">

				<?php if ( $use_header_grid ) : ?>

					<div class="archive-header-grid grid cols-tl-6 no-v-gutter">

						<div class="col">
						
							<?php 
							
							endif;

							do_action( 'eksell_archive_header_start' );

							if ( $archive_title ) :

								// If we're outputting the Jetpack Portfolio archive text, output the title in a div to enable multiple paragraphs.
								if ( get_theme_mod( 'eksell_jetpack_portfolio_archive_text', '' ) ) : 
									?>
									<div class="archive-title contain-margins i-a a-fade-up"><?php echo wpautop( $archive_title ); ?></div>
									<?php
								else : 
									?>
									<h1 class="archive-title i-a a-fade-up"><?php echo $archive_title; ?></h1>
									<?php
								endif;
							endif;
							
							if ( $use_header_grid ) : ?>

								</div><!-- .col -->

								<div class="col">

							<?php 

							endif; 
							if ( get_the_content() ) : 
								?>
								<div class="archive-description mw-small contain-margins i-a a-fade-up a-del-100"><?php the_content(); ?></div>
								<?php 
							endif;
					
							/*
							 * @hooked eksell_the_archive_filter - 10
							 */
							do_action( 'eksell_archive_header_end' ); 
							
							if ( $use_header_grid ) : 
							
							?>

						</div><!-- .col -->

					</div><!-- .archive-header-grid -->

					<?php 
				endif; 
				?>
				
			</header><!-- .archive-header -->

			<?php 
		endif; 

		do_action( 'eksell_after_archive_header' );

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

		$portfolio_posts_query = new WP_Query( array(
			'paged'				=> $paged,
			'posts_per_page'	=> get_option( 'jetpack_portfolio_posts_per_page', get_option( 'posts_per_page', 10 ) ),
			'post_type'			=> 'jetpack-portfolio',
		) );
				
		if ( $portfolio_posts_query->have_posts() ) : 
		
			?>

			<div class="posts">

				<div class="section-inner">

					<?php 

					do_action( 'eksell_posts_start' );

					// Get the column classes, based on the settings in the Customizer.
					$archive_columns_classes_array 	= eksell_get_archive_columns_classes();
					$archive_columns_classes 		= $archive_columns_classes_array ? ' ' . implode( ' ', $archive_columns_classes_array ) : '';
				
					?>

					<div class="posts-grid grid load-more-target<?php echo esc_attr( $archive_columns_classes ); ?>">

						<div class="col grid-sizer"></div>
					
						<?php 
						while ( $portfolio_posts_query->have_posts() ) : 
							$portfolio_posts_query->the_post(); 
							?>

							<div class="article-wrapper col">
								<?php get_template_part( 'inc/parts/preview', get_post_type() ); ?>
							</div>

							<?php 
						endwhile;
						?>

					</div><!-- .posts-grid -->

					<?php 
					do_action( 'eksell_posts_end' ); 
					?>
				
				</div><!-- .section-inner -->

			</div><!-- .posts -->

			<?php 
			get_template_part( 'pagination' );
		endif;
		?>

	</div><!-- .site-content-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>