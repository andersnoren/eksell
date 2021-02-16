<?php

$previous_post 	= get_previous_post();
$next_post 		= get_next_post();

if ( ! ( $previous_post || $next_post ) ) return;

?>

<nav class="single-navigation section-inner">
	<?php
	the_post_navigation( array(
		'prev_text' 	=> '<span class="arrow" aria-hidden="true">&larr;</span><span class="screen-reader-text">' . __( 'Previous post:', 'eksell' ) . '</span><span class="post-title">%title</span>',
		'next_text' 	=> '<span class="arrow" aria-hidden="true">&rarr;</span><span class="screen-reader-text">' . __( 'Next post:', 'eksell' ) . '</span><span class="post-title">%title</span>',
	) );
	?>
</nav><!-- .single-navigation -->