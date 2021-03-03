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

		$entry_time 		= get_the_time( get_option( 'date_format' ) );
		$edit_url 			= get_edit_post_link();

		// Determine which category and which tag taxonomy to display, depending on post type.
		if ( is_singular( 'post' ) ) {
			$entry_category_tax	= 'category';
			$entry_tag_tax		= 'post_tag';
		} else if ( is_singular( 'jetpack-portfolio' ) ) {
			$entry_category_tax	= 'jetpack-portfolio-type';
			$entry_tag_tax		= 'jetpack-portfolio-tag';
		}

		// You can use these filters in a child theme to change which taxonomy to use.
		$entry_category_tax = apply_filters( 'eksell_entry_meta_category_tax', isset( $entry_category_tax ) ? $entry_category_tax : '' );
		$entry_tag_tax 		= apply_filters( 'eksell_entry_meta_tag_tax', isset( $entry_tag_tax ) ? $entry_tag_tax : '' );

		// Get the markup for the categories and tags.
		$entry_categories 	= $entry_category_tax 	? get_the_term_list( $post->ID, $entry_category_tax, '', ', ' ) 	: '';
		$entry_tags 		= $entry_tag_tax 		? get_the_term_list( $post->ID, $entry_tag_tax, '', ', ' ) 		: '';

		// Show the entry footer if there is meta, or if set to display it with the filter.
		$show_entry_footer 	= apply_filters( 'eksell_show_entry_footer', ( ( $entry_time && ! is_page() ) || $edit_url || $entry_categories || $entry_tags ) );

		if ( $show_entry_footer ) : 
			?>

			<footer class="entry-footer color-secondary">

				<?php 
				do_action( 'eksell_entry_footer_start', $post->ID ); 
				?>

				<?php if ( $entry_time && ! is_page() ) : ?>
					<p class="entry-meta-time"><?php printf( esc_html_x( 'Published %s', '%s = The date of the post', 'eksell' ), '<time><a href="' . get_permalink() . '">' . $entry_time . '</a></time>' ); ?></p>
				<?php endif; ?>

				<?php if ( $entry_categories ) : ?>
					<p class="entry-categories"><?php printf( esc_html_x( 'Posted in %s', '%s = The list of categories', 'eksell' ), $entry_categories ); ?></p>
				<?php endif; ?>

				<?php if ( $entry_tags ) : ?>
					<p class="entry-tags"><?php printf( esc_html_x( 'Tagged %s', '%s = The list of tags', 'eksell' ), $entry_tags ); ?></p>
				<?php endif; ?>

				<?php if ( $edit_url ) : ?>
					<p class="edit-link"><a href="<?php echo esc_url( $edit_url ); ?>"><?php esc_html_e( 'Edit This', 'eksell' ); ?></a></p>
				<?php endif; ?>

				<?php 
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
