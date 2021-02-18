<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php

		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}

		// Check whether the header search is disabled in the customizer
		$disable_search = get_theme_mod( 'eksell_disable_search', false );

		?>

		<a class="skip-link faux-button" href="#site-content"><?php esc_html_e( 'Skip to the content', 'eksell' ); ?></a>

		<?php include( locate_template( 'inc/parts/site-aside.php' ) ); ?>

		<header id="site-header" class="stick-me">

			<?php do_action( 'eksell_header_start' ); ?>

			<div class="header-inner section-inner">

				<div class="header-titles">

					<?php

					$logo 				= eksell_get_custom_logo();
					$site_title 		= get_bloginfo( 'name' );
					$site_description 	= get_bloginfo( 'description' );

					if ( $logo ) {
						$home_link_contents = $logo . '<span class="screen-reader-text">' . esc_html( $site_title ) . '</span>';
						$site_title_class = 'site-logo';
					} else {
						$site_title_class = 'site-title';
						$home_link_contents = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . wp_kses_post( $site_title ) . '</a>';
					}

					if ( is_front_page() && is_home() && ! is_paged() ) : ?>
						<h1 class="<?php echo esc_attr( $site_title_class ); ?>"><?php echo $home_link_contents; ?></h1>
					<?php else : ?>
						<div class="<?php echo esc_attr( $site_title_class ); ?>"><?php echo $home_link_contents; ?></div>
					<?php endif; ?>

					<?php if ( $site_description ) : ?>
						<div class="site-description color-secondary"><?php echo wp_kses_post( $site_description ); ?></div>
					<?php endif; ?>

				</div><!-- .header-titles -->

				<div class="header-toggles">

					<?php 
					
					do_action( 'eksell_header_toggles_start' );

					eksell_the_social_menu();

					if ( ! $disable_search ) : 
						?>

						<a href="#" class="search-toggle toggle" data-toggle-target=".search-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-pressed="false">
							<span class="screen-reader-text"><?php esc_html_e( 'Search', 'eksell' ); ?></span>
							<?php eksell_the_theme_svg( 'ui', 'search', 18, 18 ); ?>
						</a>

						<?php 
					endif;
					?>

					<a href="#" class="nav-toggle mobile-nav-toggle toggle" data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" data-set-focus=".menu-modal" aria-pressed="false">
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'eksell' ); ?></span>
						<?php 
						// Determine the menu icon based on whether search is disabled.
						if ( $disable_search ) {
							eksell_the_theme_svg( 'ui', 'menu', 24, 24 );
						} else {
							eksell_the_theme_svg( 'ui', 'menu-search', 26, 24 );
						}
						?>
					</a>

					<?php

					do_action( 'eksell_header_toggles_end' );

					?>

				</div><!-- .header-toggles -->

			</div><!-- .header-inner -->

			<?php do_action( 'eksell_header_end' ); ?>

		</header><!-- #site-header -->

		<?php

		// Output the menu modal
		get_template_part( 'inc/parts/modal-menu' );

		// Output the search modal (if it isn't deactivated in the customizer)
		if ( ! $disable_search ) {
			get_template_part( 'inc/parts/modal-search' );
		}

		?>
		