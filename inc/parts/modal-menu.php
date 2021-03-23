<div class="menu-modal cover-modal" data-modal-target-string=".menu-modal" aria-expanded="false">

	<div class="menu-modal-cover-untoggle" data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" data-set-focus="#site-aside .nav-toggle"></div>

	<div class="menu-modal-inner modal-inner bg-menu-modal-background color-menu-modal-text">

		<div class="modal-menu-wrapper">

			<div class="menu-modal-toggles">

				<a href="#" class="toggle nav-untoggle" data-toggle-target=".menu-modal" data-toggle-screen-lock="true" data-toggle-body-class="showing-menu-modal" aria-pressed="false" role="button" data-set-focus="#site-aside .nav-toggle">
					<span class="screen-reader-text"><?php esc_html_e( 'Close', 'eksell' ); ?></span>
					<?php eksell_the_theme_svg( 'ui', 'close', 18, 18 ); ?>
				</a><!-- .nav-untoggle -->

			</div><!-- .menu-modal-toggles -->

			<div class="menu-top">

				<?php 
				do_action( 'eksell_menu_modal_top_start' );
				?>

				<ul class="main-menu reset-list-style">
					<?php
					if ( has_nav_menu( 'main' ) ) {
						wp_nav_menu( array(
							'container'      		=> '',
							'items_wrap'     		=> '%3$s',
							'show_toggles'   		=> true,
							'theme_location' 		=> 'main',
						) );
					} else {
						wp_list_pages( array( 
							'match_menu_classes' 	=> true,
							'title_li'           	=> false, 
						) );
					}
					?>
				</ul><!-- .main-menu -->

				<?php 
				if ( get_theme_mod( 'eksell_enable_search', true ) ) : 
					?>
					<div class="menu-modal-search">
						<?php get_search_form(); ?>
					</div><!-- .menu-modal-search -->
					<?php 
				endif;
				
				do_action( 'eksell_menu_modal_top_end' );
				?>

			</div><!-- .menu-top -->

			<div class="menu-bottom">

				<?php
				do_action( 'eksell_menu_modal_bottom_start' );
				
				// Output the social menu, if set
				eksell_the_social_menu( array(
					'menu_class'	=> 'social-menu reset-list-style social-icons circular',
				) );

				do_action( 'eksell_menu_modal_bottom_end' );
				?>

			</div><!-- .menu-bottom -->

		</div><!-- .menu-wrapper -->

	</div><!-- .menu-modal-inner -->

</div><!-- .menu-modal -->
