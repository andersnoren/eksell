<div class="search-modal cover-modal" data-modal-target-string=".search-modal" aria-expanded="false">

	<div class="search-modal-inner modal-inner bg-body-background">

		<div class="section-inner">

			<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

			<form role="search" method="get" class="modal-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search For&hellip;', 'eksell' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
				<label class="search-label stroke-cc" for="<?php echo esc_attr( $unique_id ); ?>">
					<span class="screen-reader-text"><?php esc_html_e( 'Search For&hellip;', 'eksell' ); ?></span>
					<?php eksell_the_theme_svg( 'ui', 'search', 24, 24 ); ?>
				</label>
				<button type="submit" class="search-submit"><?php echo esc_html_x( 'Search', 'Submit button', 'eksell' ); ?></button>
			</form><!-- .search-form -->

			<a href="#" class="toggle search-untoggle fill-cc-primary" data-toggle-target=".search-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-search-modal" data-set-focus="#site-header .search-toggle">
				<span class="screen-reader-text"><?php esc_html_e( 'Close', 'eksell' ); ?></span>
				<div class="search-untoggle-inner">
					<?php eksell_the_theme_svg( 'ui', 'close', 18, 18 ); ?>
				</div><!-- .search-untoggle-inner -->
			</a><!-- .search-toggle -->

		</div><!-- .section-inner -->

	</div><!-- .search-modal-inner -->

</div><!-- .menu-modal -->
