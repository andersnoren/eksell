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
				'title'          => esc_html__( 'Theme Options', 'eksell' ),
				'description'    => esc_html__( 'Options included in the Eksell theme.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * Site Identity
			 * ------------------------------------------------------------------------ */

			/* Dark Mode Logo ---------------- */

			$wp_customize->add_setting( 'eksell_dark_mode_logo', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'absint'
			) );

			$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'eksell_dark_mode_logo', array(
				'label'			=> esc_html__( 'Dark Mode Logo', 'eksell' ),
				'description'	=> esc_html__( 'Used when a visitor views the site with dark mode active and the "Enable Dark Mode Color Palette" setting is enabled in Customizer → Colors.', 'eksell' ),
				'mime_type'		=> 'image',
				'priority'		=> 9,
				'section' 		=> 'title_tagline',
			) ) );

			/* 2X Header Logo ---------------- */

			$wp_customize->add_setting( 'eksell_retina_logo', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'eksell_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'eksell_retina_logo', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'title_tagline',
				'priority'		=> 9,
				'label' 		=> esc_html__( 'Retina logo', 'eksell' ),
				'description' 	=> esc_html__( 'Scales the logo to half its uploaded size, making it sharp on high-res screens.', 'eksell' ),
			) );

			/* Site Logo --------------------- */

			// Make the core custom_logo setting use refresh transport, so we update the markup around the site logo element as well.
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';

			/* ------------------------------------------------------------------------
			 * Colors
			 * ------------------------------------------------------------------------ */

			$color_options = self::get_color_options();

			// Contains two groups of colors: regular and dark_mode.
			$color_options_regular 		= isset( $color_options['regular'] ) ? $color_options['regular'] : array();
			$color_options_dark_mode 	= isset( $color_options['dark_mode'] ) ? $color_options['dark_mode'] : array();

			/* Regular Colors ---------------- */

			if ( $color_options_regular ) {

				// First, loop over the regular color options and add them to the customizer.
				foreach ( $color_options_regular as $color_option_name => $color_option ) {

					$wp_customize->add_setting( $color_option_name, array(
						'default' 			=> $color_option['default'],
						'type' 				=> 'theme_mod',
						'sanitize_callback' => 'sanitize_hex_color',
					) );

					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color_option_name, array(
						'label' 		=> $color_option['label'],
						'section' 		=> 'colors',
						'settings' 		=> $color_option_name,
					) ) );

				}

			}

			/* Separator --------------------- */

			$wp_customize->add_setting( 'eksell_colors_sep_1', array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new Eksell_Separator_Control( $wp_customize, 'eksell_colors_sep_1', array(
				'section'			=> 'colors',
			) ) );

			/* Dark Mode Palette Checkbox ---- */

			$wp_customize->add_setting( 'eksell_enable_dark_mode_palette', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> false,
				'sanitize_callback' => 'eksell_sanitize_checkbox'
			) );

			$wp_customize->add_control( 'eksell_enable_dark_mode_palette', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'colors',
				'label' 		=> esc_html__( 'Enable Dark Mode Color Palette', 'eksell' ),
				'description'	=> esc_html__( 'The palette is used when the visitor has set their operating system to a light-on-dark color scheme. The feature is supported by most modern OSs and browsers, but not all. Your OS needs to be set to a light-on-dark color scheme for you to preview the color palette.', 'eksell' ),
			) );

			/* Dark Mode Colors -------------- */

			if ( $color_options_dark_mode ) {

				// Second, loop over the dark mode color options and add them to the customizer.
				foreach ( $color_options_dark_mode as $color_option_name => $color_option ) {

					$wp_customize->add_setting( $color_option_name, array(
						'default' 			=> $color_option['default'],
						'type' 				=> 'theme_mod',
						'sanitize_callback' => 'sanitize_hex_color',
					) );

					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color_option_name, array(
						'label' 		=> sprintf( esc_html_x( 'Dark Mode %s', 'Customizer option label. %s = Name of the color.', 'eksell' ), $color_option['label'] ),
						'section' 		=> 'colors',
						'settings' 		=> $color_option_name,
						'priority' 		=> 10,
					) ) );

				}

			}

			/* Background Color -------------- */

			// Make the core background_color setting use refresh transport, for consistency.
			$wp_customize->get_setting( 'background_color' )->transport = 'refresh';

			/* ------------------------------------------------------------------------
			 * General Options
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_general_options', array(
				'title' 		=> esc_html__( 'General Options', 'eksell' ),
				'priority' 		=> 10,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( 'General theme options for Eksell.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			/* Disable Animations ------------ */

			$wp_customize->add_setting( 'eksell_disable_animations', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> false,
				'sanitize_callback' => 'eksell_sanitize_checkbox'
			) );

			$wp_customize->add_control( 'eksell_disable_animations', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_general_options',
				'label' 		=> esc_html__( 'Disable Animations', 'eksell' ),
				'description'	=> esc_html__( 'Check to disable animations and transitions in the theme.', 'eksell' ),
			) );

			/* Disable Google Fonts ---------- */

			$wp_customize->add_setting( 'eksell_disable_google_fonts', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> false,
				'sanitize_callback' => 'eksell_sanitize_checkbox'
			) );

			$wp_customize->add_control( 'eksell_disable_google_fonts', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_general_options',
				'label' 		=> esc_html__( 'Disable Google Fonts', 'eksell' ),
				'description'	=> esc_html__( 'Check to disable the connection to Google Fonts in the theme.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * Site Header Options
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_site_header_options', array(
				'title' 		=> esc_html__( 'Site Header', 'eksell' ),
				'priority' 		=> 20,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( 'Settings for the site header.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			/* Enable Sticky Header ---------- */

			$wp_customize->add_setting( 'eksell_enable_sticky_header', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> true,
				'sanitize_callback' => 'eksell_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'eksell_enable_sticky_header', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_site_header_options',
				'priority'		=> 10,
				'label' 		=> esc_html__( 'Enable Sticky Header', 'eksell' ),
				'description' 	=> esc_html__( 'Determines whether to header should stick to the top of the screen when scrolling.', 'eksell' ),
			) );

			/* Enable Search ----------------- */

			$wp_customize->add_setting( 'eksell_enable_search', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> true,
				'sanitize_callback' => 'eksell_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'eksell_enable_search', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_site_header_options',
				'priority'		=> 10,
				'label' 		=> esc_html__( 'Enable Search', 'eksell' ),
				'description' 	=> esc_html__( 'Uncheck to disable the search button in the header, and the search form in the mobile menu.', 'eksell' ),
			) );

			/* ------------------------------------------------------------------------
			 * Archive Pages
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_archive_pages_options', array(
				'title' 		=> esc_html__( 'Archive Pages', 'eksell' ),
				'priority' 		=> 30,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( 'Settings for archive pages.', 'eksell' ),
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
				'section' 		=> 'eksell_archive_pages_options',
				'label' 		=> esc_html__( 'Intro Text', 'eksell' ),
				'description' 	=> esc_html__( 'Shown below the site title on the front page, when the front page is set to display latest posts.', 'eksell' ),
			) );

			/* Show Home Post Filter --------- */

			$wp_customize->add_setting( 'eksell_show_home_filter', array(
				'capability' 		=> 'edit_theme_options',
				'default'			=> true,
				'sanitize_callback' => 'eksell_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'eksell_show_home_filter', array(
				'type' 			=> 'checkbox',
				'section' 		=> 'eksell_archive_pages_options',
				'label' 		=> esc_html__( 'Show Filter', 'eksell' ),
				'description' 	=> esc_html__( 'Whether to display the category filter on the post archive.', 'eksell' ),
			) );

			/* Separator --------------------- */

			$wp_customize->add_setting( 'eksell_archive_pages_options_sep_1', array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new Eksell_Separator_Control( $wp_customize, 'eksell_archive_pages_options_sep_1', array(
				'section'			=> 'eksell_archive_pages_options',
			) ) );

			/* Pagination Type --------------- */

			$wp_customize->add_setting( 'eksell_pagination_type', array(
				'capability' 		=> 'edit_theme_options',
				'default'           => 'button',
				'sanitize_callback' => 'eksell_sanitize_select',
			) );

			$wp_customize->add_control( 'eksell_pagination_type', array(
				'type'			=> 'select',
				'section' 		=> 'eksell_archive_pages_options',
				'label'   		=> esc_html__( 'Pagination Type', 'eksell' ),
				'description'	=> esc_html__( 'Determines how the pagination on archive pages should be displayed.', 'eksell' ),
				'choices' 		=> array(
					'button'		=> esc_html__( 'Load more button', 'eksell' ),
					'scroll'		=> esc_html__( 'Load more on scroll', 'eksell' ),
					'links'			=> esc_html__( 'Links', 'eksell' ),
				),
			) );

			/* Separator --------------------- */

			$wp_customize->add_setting( 'eksell_archive_pages_options_sep_2', array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new Eksell_Separator_Control( $wp_customize, 'eksell_archive_pages_options_sep_2', array(
				'section'			=> 'eksell_archive_pages_options',
			) ) );

			/* Number of Post Columns -------- */

			// Store the different screen size options in an array for brevity.
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
					'section' 		=> 'eksell_archive_pages_options',
					'label'   		=> $data['label'],
					'description'   => $data['description'],
					'choices' 		=> array(
						'1'				=> esc_html__( 'One', 'eksell' ),
						'2'				=> esc_html__( 'Two', 'eksell' ),
						'3'				=> esc_html__( 'Three', 'eksell' ),
						'4'				=> esc_html__( 'Four', 'eksell' ),
					),
				) );
			}

			/* Separator --------------------- */

			$wp_customize->add_setting( 'eksell_archive_pages_options_sep_3', array(
				'sanitize_callback' => 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new Eksell_Separator_Control( $wp_customize, 'eksell_archive_pages_options_sep_3', array(
				'section'			=> 'eksell_archive_pages_options',
			) ) );

			/* Post Meta --------------------- */

			// Get an array with the post types that support the post meta Customizer setting.
			$post_types_with_post_meta = self::get_post_types_with_post_meta();

			foreach ( $post_types_with_post_meta as $post_type => $post_type_settings ) {

				// Only output for registered post types.
				if ( ! post_type_exists( $post_type ) ) continue;

				// Get the post type name for inclusion in the label and description.
				$post_type_obj 	= get_post_type_object( $post_type );
				$post_type_name	= isset( $post_type_obj->labels->name ) ? $post_type_obj->labels->name : $post_type;

				// Parse the arguments of the post type.
				$post_type_settings = wp_parse_args( $post_type_settings, array(
					'default'	=> array(),
				) );

				$wp_customize->add_setting( 'eksell_post_meta_' . $post_type, array(
					'capability' 		=> 'edit_theme_options',
					'default'           => $post_type_settings['default'],
					'sanitize_callback' => 'eksell_sanitize_multiple_checkboxes',
				) );

				$wp_customize->add_control( new Eksell_Customize_Control_Checkbox_Multiple( $wp_customize, 'eksell_post_meta_' . $post_type, array(
					'section' 		=> 'eksell_archive_pages_options',
					'label'   		=> sprintf( esc_html_x( 'Post Meta for %s', 'Customizer setting name. %s = Post type plural name', 'eksell' ), $post_type_name ),
					'description'	=> sprintf( esc_html_x( 'Select which post meta to display for %s on archive pages.', 'Customizer setting description. %s = Post type plural name', 'eksell' ), strtolower( $post_type_name ) ),
					'choices' 		=> self::get_post_meta_options( $post_type ),
				) ) );

			}

			/* ------------------------------------------------------------------------
			 * Fallback Image Options
			 * ------------------------------------------------------------------------ */

			$wp_customize->add_section( 'eksell_image_options', array(
				'title' 		=> esc_html__( 'Images', 'eksell' ),
				'priority' 		=> 40,
				'capability' 	=> 'edit_theme_options',
				'description' 	=> esc_html__( 'Settings for images.', 'eksell' ),
				'panel'			=> 'eksell_theme_options',
			) );

			/* Fallback Image Setting -------- */

			$wp_customize->add_setting( 'eksell_fallback_image', array(
				'capability' 		=> 'edit_theme_options',
				'sanitize_callback' => 'absint'
			) );

			$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'eksell_fallback_image', array(
				'label'			=> esc_html__( 'Fallback Image', 'eksell' ),
				'description'	=> esc_html__( 'The selected image will be used on archive pages when a post is missing a featured image. A default fallback image included in the theme will be used if no image is set.', 'eksell' ),
				'mime_type'		=> 'image',
				'section' 		=> 'eksell_image_options',
			) ) );

			/* ------------------------------------------------------------------------
			 * Sanitation Functions
			 * ------------------------------------------------------------------------ */

			/* Sanitize Checkbox ------------- */

			function eksell_sanitize_checkbox( $checked ) {
				return ( ( isset( $checked ) && true == $checked ) ? true : false );
			}

			/* Sanitize Multiple Checkboxes -- */

			function eksell_sanitize_multiple_checkboxes( $values ) {
				$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
				return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
			}

			/* Sanitize Select --------------- */

			function eksell_sanitize_select( $input, $setting ) {
				$input = sanitize_key( $input );
				$choices = $setting->manager->get_control( $setting->id )->choices;
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
			}

		}


		/*	-----------------------------------------------------------------------------------------------
			RETURN POST META OPTIONS
			Contains the post meta options available on the site. The list can be modified by hooking into 
			the eksell_post_meta_options filter. Note that any additional options also need to added to the 
			action in eksell_maybe_output_post_meta(), which handles output.
		--------------------------------------------------------------------------------------------------- */

		public static function get_post_meta_options( $post_type ) {

			return apply_filters( 'eksell_post_meta_options', array(
				'author'		=> esc_html__( 'Author', 'eksell' ),
				'categories'	=> esc_html__( 'Categories', 'eksell' ),
				'comments'		=> esc_html__( 'Comments', 'eksell' ),
				'date'			=> esc_html__( 'Date', 'eksell' ),
				'edit-link'		=> esc_html__( 'Edit link (for logged in users)', 'eksell' ),
				'tags'			=> esc_html__( 'Tags', 'eksell' ),
			), $post_type );
			
		}


		/*	-----------------------------------------------------------------------------------------------
			RETURN POST TYPES WITH POST META
			Specifies which post types should have post meta options in the Customizer. Any post types set 
			here are also checked against post_type_exists() before the setting are output in the Customizer.
			The list can be modified by hooking into the eksell_post_types_with_post_meta filter.
		--------------------------------------------------------------------------------------------------- */

		public static function get_post_types_with_post_meta() {

			return apply_filters( 'eksell_post_types_with_post_meta', array( 
				'post' 				=> array(
					'default'			=> array(),
				), 
				'jetpack-portfolio' => array(
					'default'			=> array(),
				)
			) );
			
		}

		/*	-----------------------------------------------------------------------------------------------
			RETURN SITEWIDE COLOR OPTIONS
			Used by:

			Eksell_Customizer				To generate the color settings in the Customizer
			Eksell_Custom_CSS				To output the color settings on the front-end
			eksell_block_editor_settings()	To register the color palette
		--------------------------------------------------------------------------------------------------- */

		public static function get_color_options() {

			// You can modify the color options to include in the theme with this filter, 
			// or disable color options entirely by filtering it to false.
			return apply_filters( 'eksell_color_options', array(
				'regular'		=> array(
					'eksell_accent_color' => array(
						'default'	=> '#d23c50',
						'label'		=> esc_html__( 'Accent Color', 'eksell' ),
						'slug'		=> 'accent',
						'palette'	=> true,
					),
					'eksell_primary_color' => array(
						'default'	=> '#1e2d32',
						'label'		=> esc_html__( 'Primary Text Color', 'eksell' ),
						'slug'		=> 'primary',
						'palette'	=> true,
					),
					'eksell_secondary_color' => array(
						'default'	=> '#707376',
						'label'		=> esc_html__( 'Secondary Text Color', 'eksell' ),
						'slug'		=> 'secondary',
						'palette'	=> true,
					),
					'eksell_border_color' => array(
						'default'	=> '#d6d5d4',
						'label'		=> esc_html__( 'Border Color', 'eksell' ),
						'slug'		=> 'border',
						'palette'	=> true,
					),
					'eksell_light_background_color' => array(
						'default'	=> '#f3efe9',
						'label'		=> esc_html__( 'Light Background Color', 'eksell' ),
						'slug'		=> 'light-background',
						'palette'	=> true,
					),
					// Note: The body background color uses the built-in WordPress theme mod, which is why it isn't included in this array.
					'eksell_menu_modal_text_color' => array(
						'default'	=> '#ffffff',
						'label'		=> esc_html__( 'Menu Modal Text Color', 'eksell' ),
						'slug'		=> 'menu-modal-text',
						'palette'	=> false,
					),
					'eksell_menu_modal_background_color' => array(
						'default'	=> '#1e2d32',
						'label'		=> esc_html__( 'Menu Modal Background Color', 'eksell' ),
						'slug'		=> 'menu-modal-background',
						'palette'	=> false,
					),
				),
				'dark_mode'		=> array(
					'eksell_dark_mode_background_color' => array(
						'default'	=> '#1E2D32',
						'label'		=> esc_html__( 'Background Color', 'eksell' ),
						'slug'		=> 'background',
						'palette'	=> false,
					),
					'eksell_dark_mode_accent_color' => array(
						'default'	=> '#d23c50',
						'label'		=> esc_html__( 'Accent Color', 'eksell' ),
						'slug'		=> 'accent',
						'palette'	=> false,
					),
					'eksell_dark_mode_primary_color' => array(
						'default'	=> '#ffffff',
						'label'		=> esc_html__( 'Primary Text Color', 'eksell' ),
						'slug'		=> 'primary',
						'palette'	=> false,
					),
					'eksell_dark_mode_secondary_color' => array(
						'default'	=> '#939699',
						'label'		=> esc_html__( 'Secondary Text Color', 'eksell' ),
						'slug'		=> 'secondary',
						'palette'	=> false,
					),
					'eksell_dark_mode_border_color' => array(
						'default'	=> '#404C51',
						'label'		=> esc_html__( 'Border Color', 'eksell' ),
						'slug'		=> 'border',
						'palette'	=> false,
					),
					'eksell_dark_mode_light_background_color' => array(
						'default'	=> '#29373C',
						'label'		=> esc_html__( 'Light Background Color', 'eksell' ),
						'slug'		=> 'light-background',
						'palette'	=> false,
					),
					'eksell_dark_mode_menu_modal_text_color' => array(
						'default'	=> '#ffffff',
						'label'		=> esc_html__( 'Menu Modal Text Color', 'eksell' ),
						'slug'		=> 'menu-modal-text',
						'palette'	=> false,
					),
					'eksell_dark_mode_menu_modal_background_color' => array(
						'default'	=> '#344247',
						'label'		=> esc_html__( 'Menu Modal Background Color', 'eksell' ),
						'slug'		=> 'menu-modal-background',
						'palette'	=> false,
					),
				),
			) );
			
		}

		/*	-----------------------------------------------------------------------------------------------
			RETURN ARCHIVE COLUMNS OPTIONS
			Used to add the settings, and to loop over them when adding the column classes to the post grid.
		--------------------------------------------------------------------------------------------------- */

		public static function get_archive_columns_options() {
			
			// You can modify the columns options in the theme with the `eksell_archive_columns_options` filter.
			return apply_filters( 'eksell_archive_columns_options', array(
				'eksell_post_grid_columns_mobile'			=> array(
					'label'			=> esc_html__( 'Columns on Mobile', 'eksell' ),
					'default'		=> '1',
					'description'	=> esc_html__( 'Screen width: 0px - 700px. Recommended: One.', 'eksell' ),
				),
				'eksell_post_grid_columns_tablet_portrait'	=> array(
					'label'			=> esc_html__( 'Columns on Tablet Portrait', 'eksell' ),
					'default'		=> '2',
					'description'	=> esc_html__( 'Screen width: 700px - 1000px. Recommended: Two.', 'eksell' ),
				),
				'eksell_post_grid_columns_tablet_landscape'	=> array(
					'label'			=> esc_html__( 'Columns on Tablet Landscape', 'eksell' ),
					'default'		=> '2',
					'description'	=> esc_html__( 'Screen width: 1000px - 1200px. Recommended: Two.', 'eksell' ),
				),
				'eksell_post_grid_columns_desktop'			=> array(
					'label'			=> esc_html__( 'Columns on Desktop', 'eksell' ),
					'default'		=> '3',
					'description'	=> esc_html__( 'Screen width: 1200px - 1600px. Recommended: Three.', 'eksell' ),
				),
				'eksell_post_grid_columns_desktop_large'	=> array(
					'label'			=> esc_html__( 'Columns on Large Desktop', 'eksell' ),
					'default'		=> '4',
					'description'	=> esc_html__( 'Screen width: > 1600px. Recommended: Four.', 'eksell' ),
				),
			) );

		}

		// Enqueue the Customizer JavaScript.
		public static function enqueue_customizer_javascript() {
			wp_enqueue_script( 'eksell-customizer-javascript', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery', 'customize-controls' ), '', true );
		}

	}

	// Setup the Customizer settings and controls.
	add_action( 'customize_register', array( 'Eksell_Customizer', 'eksell_register' ) );

	// Enqueue the Customizer JavaScript.
	add_action( 'customize_controls_enqueue_scripts', array( 'Eksell_Customizer', 'enqueue_customizer_javascript' ) );

endif;


/* ---------------------------------------------------------------------------------------------
   REGISTER CUSTOM CUSTOMIZER CONTROLS
   --------------------------------------------------------------------------------------------- */

if ( class_exists( 'WP_Customize_Control' ) ) :

	/* Separator Control --------------------- */

	if ( ! class_exists( 'Eksell_Separator_Control' ) ) :
		class Eksell_Separator_Control extends WP_Customize_Control {

			public $type = 'eksell_separator_control';

			public function render_content() {
				echo '<hr/>';
			}

		}
	endif;

endif;
