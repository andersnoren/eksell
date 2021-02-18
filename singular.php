<?php get_header(); ?>

<main id="site-content" role="main">

	<div class="site-content-inner">

		<?php

		if ( have_posts() ) :
			while ( have_posts() ) : 
			
				the_post();

				get_template_part( 'content', get_post_type() );

			endwhile;
		endif;

		?>

	</div><!-- .site-content-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>
