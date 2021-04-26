<aside id="site-aside">

	<?php
	do_action( 'eksell_site_aside_start' );
	?>

	<a href="#" class="toggle nav-toggle has-bars" data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" aria-pressed="false" role="button" data-set-focus=".menu-modal .main-menu &gt; li:first-child a">
		<div class="nav-toggle-inner">
			<div class="bars">

				<div class="bar"></div>
				<div class="bar"></div>
				<div class="bar"></div>

				<?php if ( get_theme_mod( 'eksell_enable_menu_button_labels', false ) ) : ?>
					<span class="nav-toggle-text">
						<span class="inactive"><?php esc_html_e( 'Menu', 'eksell' ); ?></span>
						<span class="active"><?php esc_html_e( 'Close', 'eksell' ); ?></span>
					</span>
				<?php else : ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'eksell' ); ?></span>
				<?php endif; ?>

			</div><!-- .bars -->
		</div><!-- .nav-toggle-inner -->
	</a><!-- .nav-toggle -->

	<?php
	do_action( 'eksell_site_aside_end' );
	?>

</aside><!-- #site-aside -->