<article <?php post_class( 'preview do-spot spot-fade-up preview-' . get_post_type() ); ?> id="post-<?php the_ID(); ?>">

	<a class="preview-inner" href="<?php the_permalink(); ?>">

		<?php 

		do_action( 'eksell_preview_start' );

		$fallback_image = eksell_get_fallback_image();
		
		if ( ( has_post_thumbnail() && ! post_password_required() ) || $fallback_image ) : 
			?>

			<figure class="preview-media">
				<?php 
				if ( has_post_thumbnail() && ! post_password_required() ) {
					the_post_thumbnail( $post->ID, 'eksell_preview_image' );
				} else {
					echo $fallback_image;
				}

				if ( is_sticky() ) {
					echo '<div class="sticky-note">' . esc_html__( 'Featured', 'eksell' ) . '</div>';
				}
				?>
			</figure><!-- .preview-media -->

			<?php 
		endif;
		
		if ( get_the_title() || has_action( 'eksell_preview_header_start' ) || has_action( 'eksell_preview_header_end' ) ) : 
			?>

			<header class="preview-header">
				<?php 
				do_action( 'eksell_preview_header_start' );
				the_title( '<h2 class="preview-title h4">', '</h2>' ); 
				do_action( 'eksell_preview_header_end' );
				?>
			</header><!-- .preview-header -->

			<?php
		endif;
		
		do_action( 'eksell_preview_end' );

		?>

	</a><!-- .preview-inner -->

</article><!-- .preview -->
