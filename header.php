<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="profile" href="//gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php

		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}

		?>

		<a class="skip-link faux-button" href="#site-content"><?php esc_html_e( 'Skip to the content', 'eksell' ); ?></a>

		<?php 

		// Don't output the site header, the site aside or the modals on the Blank Canvas page template.
		// The filter can be used to enable the blank canvas in different circumstances.
		$blank_canvas = apply_filters( 'eksell_blank_canvas', is_page_template( array( 'page-templates/template-blank-canvas.php' ) ) );

		// If it's a blank canvas, output nothing past this point.
		if ( $blank_canvas ) return;

		// Include the site aside, which contains the navigation toggle on desktop.
		get_template_part( 'inc/parts/site-aside' );

		// Check whether the header search is disabled in the customizer.
		$enable_search = get_theme_mod( 'eksell_enable_search', true );

		// Determine whether we have a sticky header.
		$header_classes = get_theme_mod( 'eksell_enable_sticky_header', true ) ? 'stick-me' : '';

		// Make the header classes filterable.
		$header_classes = apply_filters( 'eksell_header_classes', $header_classes );

		// Build a class attribute out of the header classes, if there are any.
		$header_class_attr = $header_classes ? ' class="' . esc_attr( $header_classes ) . '"' : '';
		
		?>

		<header id="site-header"<?php echo $header_class_attr; ?>>

			<?php 
			do_action( 'eksell_header_start' );
			?>

			<div class="header-inner section-inner">

				<div class="header-titles">

					<?php

					$logo 				= eksell_get_custom_logo();
					$site_title 		= wp_kses_post( get_bloginfo( 'name' ) );
					$site_description 	= wp_kses_post( get_bloginfo( 'description' ) );
					$show_header_text	= get_theme_mod( 'header_text', true );

					if ( $logo ) {
						$site_title_class = 'site-logo';
						$home_link_contents = $logo . '<span class="screen-reader-text">' . $site_title . '</span>';
					} else {
						$site_title_class = 'site-title';
						$home_link_contents = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . $site_title . '</a>';
					}

					if ( is_front_page() && is_home() && ! is_paged() ) : ?>
						<h1 class="<?php echo $site_title_class; ?>"><?php echo $home_link_contents; ?></h1>
					<?php else : ?>
						<div class="<?php echo $site_title_class; ?>"><?php echo $home_link_contents; ?></div>
					<?php endif; ?>

					<?php if ( $logo && $show_header_text && ( $site_title || $site_description ) ) : ?>

						<div class="header-logo-text">

							<?php
							/* 
							 * The site title is included as screen reader text next to the logo (in the H1 element),
							 * so it's hidden from screen readers here.
							 */
							if ( $site_title ) :
								?>
								<div class="site-title" aria-hidden="true"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $site_title; ?></a></div>
								<?php
							endif;

							if ( $site_description ) : 
								?>
								<div class="site-description color-secondary"><?php echo $site_description; ?></div>
								<?php
							endif;
							?>

						</div><!-- .header-logo-text -->

					<?php elseif ( $show_header_text && $site_description ) : ?>

						<div class="site-description color-secondary"><?php echo $site_description; ?></div>

					<?php endif; ?>

				</div><!-- .header-titles -->

				<div class="header-toggles">

					<?php 
					
					do_action( 'eksell_header_toggles_start' );

					eksell_the_social_menu();

					if ( $enable_search ) : 
						?>

						<a href="#" class="search-toggle toggle" data-toggle-target=".search-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-pressed="false" role="button" role="button" data-untoggle-below="700">
							<span class="screen-reader-text"><?php esc_html_e( 'Search', 'eksell' ); ?></span>
							<?php eksell_the_theme_svg( 'ui', 'search', 18, 18 ); ?>
						</a>

						<?php 
					endif;

					$nav_toggle_class = $enable_search ? ' icon-menu-search' : ' icon-menu';
					?>

					<a href="#" class="nav-toggle mobile-nav-toggle toggle<?php echo $nav_toggle_class; ?>" data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" data-set-focus=".menu-modal .nav-untoggle" aria-pressed="false" role="button">
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'eksell' ); ?></span>
						<?php 
						// Determine the menu icon based on whether search is disabled.
						if ( $enable_search ) {
							eksell_the_theme_svg( 'ui', 'menu-search', 26, 24 );
						} else {
							eksell_the_theme_svg( 'ui', 'menu', 24, 24 );
						}
						?>
					</a>

					<?php

					do_action( 'eksell_header_toggles_end' );

					?>

				</div><!-- .header-toggles -->

			</div><!-- .header-inner -->

			<?php 
			do_action( 'eksell_header_end' );
			?>

		</header><!-- #site-header -->

		<?php

		// Include the menu modal.
		get_template_part( 'inc/parts/modal-menu' );

		// Output the search modal (if it isn't deactivated in the customizer).
		if ( $enable_search ) {
			get_template_part( 'inc/parts/modal-search' );
		}

		?>
		