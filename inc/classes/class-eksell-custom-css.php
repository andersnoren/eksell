<?php

/* ---------------------------------------------------------------------------------------------
   CUSTOM CSS CLASS
   Handle custom CSS output.
------------------------------------------------------------------------------------------------ */

if ( ! class_exists( 'Eksell_Custom_CSS' ) ) :
	class Eksell_Custom_CSS {

		/*	-----------------------------------------------------------------------------------------------
			GET CUSTOMIZER CSS
		--------------------------------------------------------------------------------------------------- */

		public static function get_customizer_css() {

			// Get the color options.
			// This array contains two sets of colors: regular and dark_mode.
			$color_options	= Eksell_Customizer::get_color_options();

			// Determine if dark mode is enabled.
			$dark_mode_enabled = get_theme_mod( 'eksell_enable_dark_mode_palette', false );

			// Setup the array with the values for the CSS variables.
			$colors = array();

			// Loop over them and construct an array for the editor-color-palette.
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
							'css_variable'  => '--eksell-' . $color_option['slug'] . '-color',
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
					'css_variable'	=> '--eksell-background-color',
					'color' 		=> '#' . $background_color,
				);
			}

			$css = '';

			/* Regular Colors ---------------- */

			if ( isset( $colors['regular'] ) && $colors['regular'] ) {
				$css .= ':root {';
					foreach ( $colors['regular'] as $color_name => $color_data ) {
						$css .= $color_data['css_variable'] . ': ' . $color_data['color'] . ';';
					}
				$css .= '}';
			}

			/* Dark Mode Colors -------------- */

			if ( isset( $colors['dark_mode'] ) && $colors['dark_mode'] ) {
				$css .= '@media ( prefers-color-scheme: dark ) {';
				$css .= ':root {';
				foreach ( $colors['dark_mode'] as $color_name => $color_data ) {
					$css .= $color_data['css_variable'] . ': ' . $color_data['color'] . ';';
				}
				$css .= '}';
				$css .= '}';
			}

			/* P3 Colors --------------------- */
		
			// Filter for whether to output P3 colors. P3 colors have limited browser support (mainly Safari), so you might 
			// want to disable this if you want the colors to be consistent between browsers and operating systems.
			$output_p3 = apply_filters( 'eksell_custom_css_output_p3_colors', true );

			if ( $output_p3 && $colors ) {

				$css .= '@supports ( color: color( display-p3 0 0 0 / 1 ) ) {';

				// Add the regular colors.
				if ( isset( $colors['regular'] ) && $colors['regular'] ) {
					$css .= ':root {';
					foreach ( $colors['regular'] as $color_name => $color_data ) {
						$css .= $color_data['css_variable'] . ': ' . self::format_p3( self::hex_to_p3( $color_data['color'] ) ) . ';';
					}
					$css .= '}';
				}

				// Add the dark mode colors, if enabled.
				if ( isset( $colors['dark_mode'] ) && $colors['dark_mode'] ) {
					$css .= '@media ( prefers-color-scheme: dark ) {';
					$css .= ':root {';
					foreach ( $colors['dark_mode'] as $color_name => $color_data ) {
						$css .= $color_data['css_variable'] . ': ' . self::format_p3( self::hex_to_p3( $color_data['color'] ) ) . ';';
					}
					$css .= '}';
					$css .= '}';
				}

				$css .= '}';

			}

			// Return the CSS.
			return $css;

		}


		/*	-----------------------------------------------------------------------------------------------
			HEX TO RGB
			Convert hex colors to RGB colors.
		--------------------------------------------------------------------------------------------------- */

		public static function hex_to_rgb( $hex_color ) {

			$values = str_replace( '#', '', $hex_color );
			$rgb_color = array();
			switch ( strlen( $values ) ) {
				case 3 :
					list( $r, $g, $b ) = sscanf( $values, "%1s%1s%1s" );
					return [ hexdec( "$r$r" ), hexdec( "$g$g" ), hexdec( "$b$b" ) ];
				case 6 :
					return array_map( 'hexdec', sscanf( $values, "%2s%2s%2s" ) );
				default :
					return false;
			}

		}


		/*	-----------------------------------------------------------------------------------------------
			HEX TO P3
			Convert hex colors to the P3 color gamut.
		--------------------------------------------------------------------------------------------------- */

		public static function hex_to_p3( $hex_color ) {

			$rgb_color = self::hex_to_rgb( $hex_color );

			return array(
				'red'	=> round( $rgb_color[0] / 255, 3 ),
				'green'	=> round( $rgb_color[1] / 255, 3 ),
				'blue'	=> round( $rgb_color[2] / 255, 3 ),
			);

		}


		/*	-----------------------------------------------------------------------------------------------
			FORMAT P3
			Format P3 colors.
		--------------------------------------------------------------------------------------------------- */

		public static function format_p3( $p3_colors ) {
			return 'color( display-p3 ' . $p3_colors['red'] . ' ' . $p3_colors['green'] . ' ' . $p3_colors['blue'] . ' / 1 )';
		}

	}
endif;
