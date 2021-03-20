<?php

		// Don't output the site footer on the Blank Canvas page template.
		// The filter can be used to enable the blank canvas in different circumstances.
		$blank_canvas = apply_filters( 'eksell_blank_canvas', is_page_template( array( 'page-templates/template-blank-canvas.php' ) ) );

		// Output the site footer if we're not doing a blank canvas.
		if ( ! $blank_canvas ) :
			?>
		
			<footer id="site-footer">

				<?php 
				do_action( 'eksell_footer_start' ); 
				?>
				
				<div class="footer-inner section-inner">

					<?php 
					do_action( 'eksell_footer_inner_start' ); 
					?>

					<div class="footer-credits">

						<p class="footer-copyright">&copy; <?php echo esc_html( date_i18n( esc_html__( 'Y', 'eksell' ) ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>" rel="home"><?php echo bloginfo( 'name' ); ?></a></p>

						<p class="theme-credits color-secondary">
							<?php
							// Translators: $s = name of the theme developer.
							printf( esc_html_x( 'Theme by %s', 'Translators: $s = name of the theme developer', 'eksell' ), '<a href="https://www.andersnoren.se">' . esc_html__( 'Anders Nor&eacute;n', 'eksell' ) . '</a>' ); ?>
						</p><!-- .theme-credits -->

					</div><!-- .footer-credits -->

					<?php 
					eksell_the_social_menu(); 

					do_action( 'eksell_footer_inner_end' ); 
					?>

				</div><!-- .footer-inner -->

				<?php 
				do_action( 'eksell_footer_end' ); 
				?>

			</footer><!-- #site-footer -->

			<?php
		endif; // if ! $blank_canvas
		
		wp_footer(); 
		
		?>

    </body>
</html>
