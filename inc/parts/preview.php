<article <?php post_class( 'preview do-spot spot-fade-in-scale preview-' . get_post_type() ); ?> id="post-<?php the_ID(); ?>">

	<?php 

	do_action( 'eksell_preview_start' );

	$fallback_image = eksell_get_fallback_image();
	
	if ( ( has_post_thumbnail() && ! post_password_required() ) || $fallback_image ) : 
		?>

		<figure class="preview-media">

			<a href="<?php the_permalink(); ?>" class="preview-media-link">
				<?php 
				if ( has_post_thumbnail() && ! post_password_required() ) {
					the_post_thumbnail( $post->ID, 'eksell_preview_image' );
				} else {
					echo $fallback_image;
				}
				?>
			</a>

		</figure><!-- .preview-media -->

		<?php 
	endif;
	?>

	<header class="preview-header">
		<?php 
		do_action( 'eksell_preview_header_start' );
		the_title( '<h2 class="preview-title h4"><a href="' . get_the_permalink() . '">', '</a></h2>' ); 
		do_action( 'eksell_preview_header_end' );
		?>
	</header><!-- .preview-header -->

	<?php
	do_action( 'eksell_preview_end' );
	?>

</article><!-- .preview -->
