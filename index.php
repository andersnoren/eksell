<?php get_header(); ?>

<main id="site-content" role="main">

	<div class="site-content-inner">

		<?php

		$archive_prefix 		= eksell_get_the_archive_title_prefix();
		$archive_title 			= get_the_archive_title();
		$archive_description 	= get_the_archive_description( '<div>', '</div>' );

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
							
							if ( $archive_prefix ) : 
								?>
								<p class="archive-prefix color-accent i-a a-fade-up"><?php echo $archive_prefix; ?></p>
								<?php 
							endif;

							if ( $archive_title ) :

								// On home, where we're outputting the eksell_home_text Customizer value, output the title in a div to enable multiple paragraphs.
								if ( is_home() && ! is_paged() ) : 
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
							if ( $archive_description ) : 
								?>
								<div class="archive-description mw-small contain-margins i-a a-fade-up a-del-100"><?php echo wpautop( $archive_description ); ?></div>
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
				
		if ( have_posts() ) : 
		
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
						while ( have_posts() ) : 
							the_post(); 
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
			
		elseif ( is_search() ) : 
		
			?>

			<div class="no-search-results-form section-inner contain-margins">
				<?php get_search_form(); ?>
			</div><!-- .no-search-results -->

			<?php 
		endif;
		?>

	</div><!-- .site-content-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>
