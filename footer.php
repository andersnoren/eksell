		<footer id="site-footer">

			<?php do_action( 'eksell_footer_start' ); ?>
			
			<div class="footer-inner section-inner">

				<div class="footer-credits">

					<p class="footer-copyright">&copy; <?php echo esc_html( date_i18n( __( 'Y', 'eksell' ) ) ); ?> <a href="<?php echo esc_url( home_url() ); ?>" rel="home"><?php echo bloginfo( 'name' ); ?></a></p>

					<p class="theme-credits color-secondary">
						<?php
						/* Translators: $s = name of the theme developer */
						printf( esc_html_x( 'Theme by %s', 'Translators: $s = name of the theme developer', 'eksell' ), '<a href="https://www.andersnoren.se">' . esc_html__( 'Anders Nor&eacute;n', 'eksell' ) . '</a>' ); ?>
					</p><!-- .theme-credits -->

				</div><!-- .footer-credits -->

			</div><!-- .footer-inner -->

			<?php do_action( 'eksell_footer_end' ); ?>

		</footer><!-- #site-footer -->

		<?php wp_footer(); ?>

    </body>
</html>
