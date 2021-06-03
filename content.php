<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php 
	do_action( 'eksell_entry_article_start', $post->ID );
	?>

	<header class="entry-header section-inner mw-thin i-a a-fade-up">

		<?php 
		do_action( 'eksell_entry_header_start', $post->ID );
		?>

		<hr class="color-accent" aria-hidden="true" />

		<?php
		if ( is_front_page() && is_home() ) {
			the_title( '<div class="entry-title h1">', '</div>' );
		} else {
			the_title( '<h1 class="entry-title">', '</h1>' );
		}

		if ( has_excerpt() ) : ?>

			<div class="intro-text contain-margins">
				<?php the_excerpt(); ?>
			</div><!-- .intro-text -->

			<?php 
		endif;

		do_action( 'eksell_entry_header_end', $post->ID );

		?>

	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() && ! post_password_required() ) : 
		?>

		<figure class="featured-media section-inner i-a a-fade-up a-del-200">

			<?php 
			do_action( 'eksell_featured_media_start', $post->ID );
			?>

			<div class="media-wrapper">
				<?php the_post_thumbnail(); ?>
			</div><!-- .media-wrapper -->

			<?php

			$caption = get_the_post_thumbnail_caption();
			
			if ( $caption ) : 
				?>

				<figcaption><?php echo $caption; ?></figcaption>

				<?php 
			endif; 

			do_action( 'eksell_featured_media_end', $post->ID );
			
			?>

		</figure><!-- .featured-media -->

		<?php 
	endif; // has_post_thumbnail()
	?>

	<div class="post-inner section-inner mw-thin do-spot spot-fade-up a-del-200">

		<div class="entry-content">

			<?php 
			the_content();
			wp_link_pages( array(
				'before'           => '<nav class="post-nav-links"><hr /><div class="post-nav-links-list">',
				'after'            => '</div></nav>',
			) );
			?>

		</div><!-- .entry-content -->

		<?php 

		// Show the entry footer if we have actions, or if it's set to be displayed with the filter.
		$show_entry_footer 	= apply_filters( 'eksell_show_entry_footer', ( has_action( 'eksell_entry_footer_start' ) || has_action( 'eksell_entry_footer_end' ) ) );

		if ( $show_entry_footer ) : 
			?>

			<footer class="entry-footer color-secondary">

				<?php 
				do_action( 'eksell_entry_footer_start', $post->ID ); 
				do_action( 'eksell_entry_footer_end', $post->ID ); 
				?>

			</footer><!-- .entry-footer -->

			<?php
		endif;
		?>

	</div><!-- .post-inner -->

	<?php 

	// Conditional display of the single post navigation, depending on the post type.
	// You can modify the list of post types with support for single post navigation using the `eksell_singular_post_navigation_post_types` filter.
	if ( is_singular( apply_filters( 'eksell_singular_post_navigation_post_types', array( 'post', 'jetpack-portfolio' ) ) ) ) {
		get_template_part( 'inc/parts/single-post-navigation' );
	}

	// Output comments wrapper if comments are open or if there are comments, and check for password.
	if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) : 
		?>

		<div class="comments-wrapper section-inner mw-thin">
			<?php comments_template(); ?>
		</div><!-- .comments-wrapper -->

		<?php 
	endif; 
	
	do_action( 'eksell_entry_article_end', $post->ID ); 
	
	?>

</article><!-- .post -->
