<?php get_header(); ?>

<main id="site-content" role="main" class="section-inner">

	<div class="error404-inner site-content-inner">

		<h1 class="archive-title"><?php esc_html_e( 'Page Not Found', 'eksell' ); ?></h1>
			
		<p><?php printf( esc_html_x( 'The page you are looking for could not be found. It might have been deleted, renamed, or it did not exist in the first place. You can search the site with the form below, or return to the %1$sfront page%2$s.', '$1%s = Opening tag for front page link, $2%s = Closing tag for front page link', 'eksell' ), '<a href="' . home_url() . '">', '</a>' ); ?></p>

		<?php get_search_form(); ?>

	</div><!-- .error404-inner -->

</main><!-- #site-content -->

<?php get_footer(); ?>
