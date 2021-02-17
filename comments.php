<?php 

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

if ( $comments ) : 
	?>

	<div class="comments section-inner mw-thin max-percentage no-margin" id="comments">

		<?php

		$comments_number 	= absint( get_comments_number() );
		$review_post_types 	= apply_filters( 'eksell_post_types_with_reviews_instead_of_comments', array( 'product' ) );
		
		if ( in_array( get_post_type(), $review_post_types ) ) {
			// Translators: %s = the number of review
			$comments_title = sprintf( _nx( '%s Review', '%s Reviews', $comments_number, 'Translators: %s = the number of reviews', 'eksell' ), $comments_number );
		} else {
			// Translators: %s = the number of comments
			$comments_title = sprintf( _nx( '%s Comment', '%s Comments', $comments_number, 'Translators: %s = the number of comments', 'eksell' ), $comments_number );
		}
		
		?>

		<div class="comments-header">
			<hr class="color-accent" aria-hidden="true" />
			<h2 class="comment-reply-title"><?php echo esc_html( $comments_title ); ?></h2>
		</div><!-- .comments-header -->

		<?php

		wp_list_comments( array(
			'avatar_size' => 120,
			'style'       => 'div',
		) );

		$comment_pagination = paginate_comments_links( array(
			'echo'      => false,
			'end_size'  => 0,
			'mid_size'  => 0,
			'next_text' => '<span class="text"><span class="long">' . __( 'Newer Comments', 'eksell' ) . '</span><span class="short">' . __( 'Newer', 'eksell' ) . '</span></span><span class="arrow">&rarr;</span>',
			'prev_text' => '<span class="arrow">&larr;</span><span class="text"><span class="long">' . __( 'Older Comments', 'eksell' ) . '</span><span class="short">' . __( 'Older', 'eksell' ) . '</span></span>',
		) );

		if ( $comment_pagination ) :

			// If we're only showing the "Next" link, add a class indicating so
			if ( strpos( $comment_pagination, 'prev page-numbers' ) === false ) {
				$pagination_classes = ' only-next';
			} else {
				$pagination_classes = '';
			}
			?>

			<nav class="comments-pagination pagination<?php echo esc_attr( $pagination_classes ); ?>">
				<hr class="wp-block-separator is-style-wide" aria-hidden="true" />
				<div class="comments-pagination-inner">
					<?php echo wp_kses_post( $comment_pagination ); ?>
				</div><!-- .comments-pagination-inner -->
			</nav>

		<?php endif; ?>

	</div><!-- comments -->

	<?php 
endif;

if ( comments_open() || pings_open() ) {
	comment_form( array(
		'cancel_reply_before'	=> '</span><small>',
		'comment_notes_before'	=> '',
		'comment_notes_after'	=> '',
		'title_reply_before'	=> '<hr class="color-accent" aria-hidden="true" /><h2 id="reply-title" class="comment-reply-title h3"><span class="title">',
		'title_reply_after'		=> '</h2>'
	) );
}
