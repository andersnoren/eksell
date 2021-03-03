<?php

/* 
Template Name: No Title Template
*/

get_header(); ?>

<main id="site-content" role="main">

	<div class="site-content-inner">

		<?php

		if ( have_posts() ) :
			while ( have_posts() ) : 
			
				the_post();

				do_action( 'eksell_entry_article_start', $post->ID );

				?>

				<div class="entry-content section-inner mw-thin">

					<?php 
					the_content();
					wp_link_pages( array(
						'before'           => '<nav class="post-nav-links"><hr /><div class="post-nav-links-list">',
						'after'            => '</div></nav>',
					) );
					?>

				</div><!-- .entry-content -->

				<?php 

			endwhile;
		endif;

		?>

	</div><!-- .site-content-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>