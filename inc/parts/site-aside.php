<aside id="site-aside">

	<?php do_action( 'eksell_site_aside_start' ); ?>

	<a href="#" class="toggle nav-toggle" data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" aria-pressed="false" data-set-focus=".menu-modal">
		<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'eksell' ); ?></span>
		<div class="bars">
			<div class="bar"></div>
			<div class="bar"></div>
			<div class="bar"></div>
		</div><!-- .bars -->
	</a><!-- .nav-toggle -->

	<?php do_action( 'eksell_site_aside_end' ); ?>

</aside><!-- #site-aside -->