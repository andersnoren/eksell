<?php

/* 
Template Name: Only Content Template
*/

get_header(); ?>

<main id="site-content" role="main">

	<div class="site-content-inner">

		<?php

		if ( have_posts() ) :
			while ( have_posts() ) : 
			
				the_post();

				do_action( 'eksell_entry_article_start', $post->ID );

				if ( is_front_page() && is_home() ) {
					the_title( '<div class="entry-title screen-reader-text h1">', '</div>' );
				} else {
					the_title( '<h1 class="entry-title screen-reader-text">', '</h1>' );
				}

				?>

				<div class="section-inner mw-thin">

					<div class="entry-content">

						<?php 
						the_content();
						wp_link_pages( array(
							'before'           => '<nav class="post-nav-links"><hr /><div class="post-nav-links-list">',
							'after'            => '</div></nav>',
						) );
						?>

					</div><!-- .entry-content -->

				</div><!-- .section-inner -->

				<?php 

			endwhile;
		endif;

		?>

	</div><!-- .site-content-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>