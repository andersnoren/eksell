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

		$post_type 			= get_post_type();
		$comments_number 	= absint( get_comments_number() );
		
		if ( get_post_type() == 'product' ) {
			// Translators: %s = the number of reviews.
			$comments_title = sprintf( _nx( '%s Review', '%s Reviews', $comments_number, 'Translators: %s = the number of reviews', 'eksell' ), $comments_number );
		} else {
			// Translators: %s = the number of comments.
			$comments_title = sprintf( _nx( '%s Comment', '%s Comments', $comments_number, 'Translators: %s = the number of comments', 'eksell' ), $comments_number );
		}

		// Filter the comments title before output.
		$comments_title = apply_filters( 'eksell_comments_title', $comments_title, $comments_number, $post_type );

		if ( $comments_title ) : 
			?>

			<div class="comments-header">
				<hr class="color-accent" aria-hidden="true" />
				<h2 class="comment-reply-title"><?php echo esc_html( $comments_title ); ?></h2>
			</div><!-- .comments-header -->

			<?php
		endif;

		wp_list_comments( array(
			'avatar_size' => 120,
			'style'       => 'div',
		) );

		$comment_pagination = paginate_comments_links( array(
			'echo'      => false,
			'end_size'  => 0,
			'mid_size'  => 0,
			'next_text' => '<span class="text"><span class="long">' . esc_html__( 'Newer Comments', 'eksell' ) . '</span><span class="short">' . esc_html__( 'Newer', 'eksell' ) . '</span></span><span class="arrow">&rarr;</span>',
			'prev_text' => '<span class="arrow">&larr;</span><span class="text"><span class="long">' . esc_html__( 'Older Comments', 'eksell' ) . '</span><span class="short">' . esc_html__( 'Older', 'eksell' ) . '</span></span>',
		) );

		if ( $comment_pagination ) :

			// If we're only showing the "Next" link, add a class indicating so.
			$pagination_classes = ( strpos( $comment_pagination, 'prev page-numbers' ) === false ) ? ' only-next' : '';

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
