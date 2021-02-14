<article <?php post_class( 'preview do-spot spot-fade-in-scale preview-' . get_post_type() ); ?> id="post-<?php the_ID(); ?>">

	<?php 

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
		<?php the_title( '<h2 class="preview-title h5"><a href="' . get_the_permalink() . '">', '</a></h2>' ); ?>
	</header><!-- .preview-header -->

</article><!-- .preview -->
