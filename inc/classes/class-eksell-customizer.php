<?php 

/* ---------------------------------------------------------------------------------------------
   CUSTOMIZER SETTINGS
   --------------------------------------------------------------------------------------------- */

if ( ! class_exists( 'Eksell_Customizer' ) ) :
	class Eksell_Customizer {

		public static function eksell_register( $wp_customize ) {

			/* ------------------------------------------------------------------------
			 * Theme Options Panel
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_panel( 'eksell_theme_options', array(
				'priority'       => 30,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __( 'Theme Options', 'eksell' ),
				'description'    => __( 'Options included in the Eksell theme.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * Site Identity
			 * ------------------------------------------------------------------------ */

			/* 2X Header Logo ---------------- */

			$wp_customize->add_setting( 'eksell_retina_logo', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'eksell_sanitize_checkbox',
				'transport'			=> 'postMessage',
			) );

			$wp_customize->add_control( 'eksell_retina_logo', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'title_tagline',
				'priority'		=> 10,
				'label' 		=> __( 'Retina logo', 'eksell' ),
				'description' 	=> __( 'Scales the logo to half its uploaded size, making it sharp on high-res screens.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * General Options
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_general_options', array(
				'title' 		=> __( 'General Options', 'eksell' ),
				'priority' 		=> 40,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> __( 'General theme options for Eksell.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			// Disable animations
			$wp_customize->add_setting( 'eksell_disable_animations', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> false,
				'sanitize_callback' => 'eksell_sanitize_checkbox'
			) );

			$wp_customize->add_control( 'eksell_disable_animations', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_general_options',
				'priority'		=> 15,
				'label' 		=> __( 'Disable Animations', 'eksell' ),
				'description'	=> __( 'Check to disable animations and transitions in the theme.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * Colors
			 * ------------------------------------------------------------------------ */

			$eksell_accent_color_options = self::get_color_options();

			// Loop over the color options and add them to the customizer
			foreach ( $eksell_accent_color_options as $color_option_name => $color_option ) {

				$wp_customize->add_setting( $color_option_name, array(
					'default' 			=> $color_option['default'],
					'type' 				=> 'theme_mod',
					'sanitize_callback' => 'sanitize_hex_color',
				) );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color_option_name, array(
					'label' 		=> $color_option['label'],
					'section' 		=> 'colors',
					'settings' 		=> $color_option_name,
					'priority' 		=> 10,
				) ) );

			}

			// Update background color with postMessage, so inline CSS output is updated as well
			$wp_customize->get_setting( 'background_color' )->transport = 'refresh';


			/* ------------------------------------------------------------------------
			 * Fallback Image Options
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_image_options', array(
				'title' 		=> __( 'Images', 'eksell' ),
				'priority' 		=> 40,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> __( 'Settings for images in Eksell.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			// Fallback image setting
			$wp_customize->add_setting( 'eksell_fallback_image', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'absint'
			) );

			$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'eksell_fallback_image', array(
				'label'			=> __( 'Fallback Image', 'eksell' ),
				'description'	=> __( 'The selected image will be used when a post is missing a featured image. A default fallback image included in the theme will be used if no image is set.', 'eksell' ),
				'priority'		=> 10,
				'mime_type'		=> 'image',
				'section' 		=> 'eksell_image_options',
			) ) );

			// Disable fallback image setting
			$wp_customize->add_setting( 'eksell_disable_fallback_image', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> false,
				'sanitize_callback' => 'eksell_sanitize_checkbox'
			) );

			$wp_customize->add_control( 'eksell_disable_fallback_image', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_image_options',
				'priority'		=> 15,
				'label' 		=> __( 'Disable Fallback Image', 'eksell' )
			) );

			/* ------------------------------------------------------------------------
			 * Site Header Options
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_site_header_options', array(
				'title' 		=> __( 'Site Header', 'eksell' ),
				'priority' 		=> 40,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> __( 'Settings for the site header.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			/* Disable Header Search --------- */

			$wp_customize->add_setting( 'eksell_disable_search', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> false,
				'sanitize_callback' => 'eksell_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'eksell_disable_search', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_site_header_options',
				'priority'		=> 10,
				'label' 		=> __( 'Disable Search Button', 'eksell' ),
				'description' 	=> __( 'Check to disable the search button in the header, and the search form in the mobile menu.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * Posts
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_post_archive_options', array(
				'title' 		=> __( 'Post Archive', 'eksell' ),
				'priority' 		=> 50,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> __( 'Settings for post archives.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			$wp_customize->add_section( 'eksell_single_post_options', array(
				'title' 		=> __( 'Single Post', 'eksell' ),
				'priority' 		=> 60,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> __( 'Settings for single posts.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			/* Home Text --------------- */

			$wp_customize->add_setting( 'eksell_home_text', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> '',
				'sanitize_callback' => 'sanitize_textarea_field',
			) );

			$wp_customize->add_control( 'eksell_home_text', array(
				'type' 			=> 'textarea',
				'section' 		=> 'eksell_post_archive_options',
				'label' 		=> __( 'Intro Text', 'eksell' ),
				'description' 	=> __( 'Shown below the site title on the post archive.', 'eksell' ),
			) );

			/* Show Home Post Filter --------- */

			$wp_customize->add_setting( 'eksell_show_home_filter', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> true,
				'sanitize_callback' => 'eksell_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'eksell_show_home_filter', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_post_archive_options',
				'label' 		=> __( 'Show Filter', 'eksell' ),
				'description' 	=> __( 'Whether to display the category filter on the post archive.', 'eksell' ),
			) );

			/* Separator --------------------- */

			$wp_customize->add_setting( 'eksell_post_archive_options_1', array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new Eksell_Separator_Control( $wp_customize, 'eksell_post_archive_options_1', array(
				'section'			=> 'eksell_post_archive_options',
			) ) );

			/* Pagination Type --------------- */

			$wp_customize->add_setting( 'eksell_pagination_type', array(
				'capability' 		=> 'edit_theme_options',
				'default'           => 'button',
				'sanitize_callback' => 'eksell_sanitize_select',
			) );

			$wp_customize->add_control( 'eksell_pagination_type', array(
				'type'			=> 'select',
				'section' 		=> 'eksell_post_archive_options',
				'label'   		=> __( 'Pagination Type', 'eksell' ),
				'description'	=> __( 'Determines how the pagination on archive pages should be displayed.', 'eksell' ),
				'choices' 		=> array(
					'button'		=> __( 'Load more on button click', 'eksell' ),
					'scroll'		=> __( 'Load more on scroll', 'eksell' ),
					'links'			=> __( 'Previous and next page links', 'eksell' ),
				),
			) );

			/* Separator --------------------- */

			$wp_customize->add_setting( 'eksell_post_archive_options_2', array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new Eksell_Separator_Control( $wp_customize, 'eksell_post_archive_options_2', array(
				'section'			=> 'eksell_post_archive_options',
			) ) );

			/* Number of Post Columns -------- */

			// Store the different screen size options in an array for brevity
			$post_column_option_sizes = Eksell_Customizer::get_archive_columns_options();

			// Loop over each screen size option and register it
			foreach ( $post_column_option_sizes as $setting_name => $data ) {
				$wp_customize->add_setting( $setting_name, array(
					'capability' 		=> 'edit_theme_options',
					'default'           => $data['default'],
					'sanitize_callback' => 'eksell_sanitize_select',
				) );

				$wp_customize->add_control( $setting_name, array(
					'type'			=> 'select',
					'section' 		=> 'eksell_post_archive_options',
					'label'   		=> $data['label'],
					'description'   => $data['description'],
					'choices' 		=> array(
						'1'				=> __( 'One', 'eksell' ),
						'2'				=> __( 'Two', 'eksell' ),
						'3'				=> __( 'Three', 'eksell' ),
						'4'				=> __( 'Four', 'eksell' ),
					),
				) );
			}

			/* Sanitation Functions ---------- */

			// Sanitize boolean for checkbox
			function eksell_sanitize_checkbox( $checked ) {
				return ( ( isset( $checked ) && true == $checked ) ? true : false );
			}

			// Sanitize select
			function eksell_sanitize_select( $input, $setting ) {
				$input = sanitize_key( $input );
				$choices = $setting->manager->get_control( $setting->id )->choices;
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
			}

		}

		// Return the sitewide color options included
		public static function get_color_options() {

			return apply_filters( 'eksell_color_options', array(
				'eksell_accent_color' => array(
					'default'	=> '#007C89',
					'label'		=> __( 'Accent Color', 'eksell' ),
					'slug'		=> 'accent',
				),
				'eksell_primary_text_color' => array(
					'default'	=> '#1A1B1F',
					'label'		=> __( 'Primary Text Color', 'eksell' ),
					'slug'		=> 'primary',
				),
				'eksell_secondary_text_color' => array(
					'default'	=> '#747579',
					'label'		=> __( 'Secondary Text Color', 'eksell' ),
					'slug'		=> 'secondary',
				),
				'eksell_border_color' => array(
					'default'	=> '#E1E1E3',
					'label'		=> __( 'Border Color', 'eksell' ),
					'slug'		=> 'border',
				),
				'eksell_light_background_color' => array(
					'default'	=> '#F1F1F3',
					'label'		=> __( 'Light Background Color', 'eksell' ),
					'slug'		=> 'light-background',
				),
			) );
			
		}

		public static function get_archive_columns_options() {
			
			return apply_filters( 'eksell_archive_columns_options', array(
				'eksell_post_grid_columns_mobile'			=> array(
					'label'			=> __( 'Columns on Mobile', 'eksell' ),
					'default'		=> '1',
					'description'	=> __( 'Screen width: 0px - 700px', 'eksell' ),
				),
				'eksell_post_grid_columns_tablet_portrait'	=> array(
					'label'			=> __( 'Columns on Tablet Portrait', 'eksell' ),
					'default'		=> '2',
					'description'	=> __( 'Screen width: 700px - 1000px', 'eksell' ),
				),
				'eksell_post_grid_columns_tablet_landscape'	=> array(
					'label'			=> __( 'Columns on Tablet Landscape', 'eksell' ),
					'default'		=> '3',
					'description'	=> __( 'Screen width: 1000px - 1200px', 'eksell' ),
				),
				'eksell_post_grid_columns_desktop'			=> array(
					'label'			=> __( 'Columns on Desktop', 'eksell' ),
					'default'		=> '3',
					'description'	=> __( 'Screen width: 1200px - 1600px', 'eksell' ),
				),
				'eksell_post_grid_columns_desktop_large'	=> array(
					'label'			=> __( 'Columns on Large Desktop', 'eksell' ),
					'default'		=> '4',
					'description'	=> __( 'Screen width: > 1600px', 'eksell' ),
				),
			) );

		}

	}

	// Setup the Theme Customizer settings and controls
	add_action( 'customize_register', array( 'Eksell_Customizer', 'eksell_register' ) );

endif;


/* ---------------------------------------------------------------------------------------------
   CUSTOM CONTROLS
   --------------------------------------------------------------------------------------------- */


if ( class_exists( 'WP_Customize_Control' ) ) :

	/* Separator Control --------------------- */

	if ( ! class_exists( 'Eksell_Separator_Control' ) ) :
		class Eksell_Separator_Control extends WP_Customize_Control {

			public function render_content() {
				echo '<hr/>';
			}

		}
	endif;

endif;
