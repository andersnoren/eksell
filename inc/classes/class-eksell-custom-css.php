<?php

/* ---------------------------------------------------------------------------------------------
   CUSTOM CSS CLASS
   Handle custom CSS output
------------------------------------------------------------------------------------------------ */

if ( ! class_exists( 'Eksell_Custom_CSS' ) ) :
	class Eksell_Custom_CSS {


		public static function get_customizer_css() {

			// Get the color options
			// This array contains two sets of colors: regular and dark_mode
			$color_options	= Eksell_Customizer::get_color_options();

			// Determine if dark mode in enabled
			$dark_mode_enabled = get_theme_mod( 'eksell_enable_dark_mode_palette', true );

			// Setup the array with the values for the CSS variables
			$colors = array();

			// Loop over them and construct an array for the editor-color-palette
			if ( $color_options ) {
				foreach ( $color_options as $group_name => $group_color_options ) {

					if ( $group_name == 'dark_mode' && ! $dark_mode_enabled ) continue;

					foreach ( $group_color_options as $color_option_name => $color_option ) {

						// For the regular colors, only add colors that aren't set to their default value.
						// The dark mode colors aren't included in style.css, so they need to be output even when they're set to their default values.
						if ( $group_name == 'regular' ) {
							$color = get_theme_mod( $color_option_name, $color_option['default'] );
							if ( $color == $color_option['default'] ) continue;
						}

						$colors[$group_name][$color_option['slug']] = array(
							'css_variable'  => '--' . $color_option['slug'] . '-color',
							'color' 		=> get_theme_mod( $color_option_name, $color_option['default'] ),
						);
					}
				}
			}

			// Add the background option to the regular colors, if it differs from the default.
			$background_color = get_background_color();	
			$background_color_default = get_theme_support( 'custom-background', 'default-color' );
			if ( $background_color != $background_color_default ) {
				$colors['regular']['background'] = array(
					'css_variable'	=> '--background-color',
					'color' 		=> '#' . $background_color,
				);
			}

			$css = '';

			// Add the regular colors.
			if ( $colors['regular'] ) {
				$css .= ':root {';
				foreach ( $colors['regular'] as $color_name => $color_data ) {
					$css .= $color_data['css_variable'] . ': ' . $color_data['color'] . ';';
				}
				$css .= '}';
			}

			// Add the dark mode colors, if enabled.
			if ( isset( $colors['dark_mode'] ) && $colors['dark_mode'] ) {
				$css .= '@media ( prefers-color-scheme: dark ) {';
				$css .= ':root {';
				foreach ( $colors['dark_mode'] as $color_name => $color_data ) {
					$css .= $color_data['css_variable'] . ': ' . $color_data['color'] . ';';
				}
				$css .= '}';
				$css .= '}';
			}

			// Return the CSS.
			return $css;

		}

	}
endif;
