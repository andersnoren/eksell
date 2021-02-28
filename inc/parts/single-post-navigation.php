<?php

$nav = array();
$nav['prev'] 	= get_previous_post();
$nav['next'] 	= get_next_post();

if ( ! ( $nav['prev'] || $nav['next'] ) ) return;

$nav_class = ( $nav['prev'] && $nav['next'] ) ? ' has-both' : ( ! $nav['prev'] ? ' only-next' : ( ! $nav['next'] ? ' only-prev' : '' ) );

?>

<nav class="single-nav section-inner<?php echo esc_attr( $nav_class ); ?>">

	<div class="single-nav-grid grid no-v-gutter cols-t-6 cols-tl-4">

		<?php 
		
		foreach ( $nav as $slug => $nav_post ) : 

			if ( ! $nav_post ) continue;

			$fallback_image = eksell_get_fallback_image();
			$has_media 		= ( has_post_thumbnail( $nav_post->ID ) && ! post_password_required( $nav_post->ID ) ) || $fallback_image;

			$icon = ( $slug == 'prev' ) ? 'arrow-left' : 'arrow-right';

			$link_classes 	= ' ' . $slug . '-post';
			$link_classes 	.= $has_media ? ' has-media' : ' no-media';
		
			?>

			<div class="col">

				<a class="single-nav-item do-spot spot-fade-up<?php echo esc_attr( $link_classes ); ?>" href="<?php echo esc_url( get_permalink( $nav_post->ID ) ); ?>">

					<?php
					do_action( 'eksell_single_nav_item_start', $nav_post, $slug );
					?>

					<figure class="single-nav-item-media">

						<?php 
						if ( $has_media ) {
							if ( has_post_thumbnail( $nav_post->ID ) && ! post_password_required( $nav_post->ID ) ) {
								echo get_the_post_thumbnail( $nav_post->ID, 'eksell_preview_image' );
							} else {
								echo $fallback_image;
							}
						}
						?>

						<div class="arrow stroke-cc">
							<?php eksell_the_theme_svg( 'ui', $icon, 96, 49 ); ?>
						</div><!-- .arrow -->

					</figure><!-- .single-nav-item-media -->

					<?php

					$nav_post_title = get_the_title( $nav_post->ID );

					if ( $nav_post_title || has_action( 'eksell_single_nav_item_header_start' ) || has_action( 'eksell_single_nav_item_header_end' ) ) : 
						?>

						<header class="single-nav-item-header contain-margins">

							<?php
							do_action( 'eksell_single_nav_item_header_start', $nav_post, $slug );
							?>

							<h3 class="single-nav-item-title h4">
								<?php echo $nav_post_title; ?>
							</h3><!-- .single-nav-item-title -->

							<?php
							do_action( 'eksell_single_nav_item_header_end', $nav_post, $slug );
							?>

						</header><!-- .single-nav-item-header -->

						<?php 
					endif;
					
					do_action( 'eksell_single_nav_item_end', $nav_post, $slug ); 
					
					?>

				</a>

			</div><!-- .col -->

			<?php 
		endforeach;
		?>

	</div><!-- .single-nav-grid -->
	
</nav><!-- .single-nav -->