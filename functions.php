<?php


/*	-----------------------------------------------------------------------------------------------
	THEME SUPPORTS
	Default setup, some features excluded
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_theme_support' ) ) :
	function eksell_theme_support() {

		// Automatic feed
		add_theme_support( 'automatic-feed-links' );

		// Custom background color
		add_theme_support( 'custom-background', array(
			'default-color'	=> 'FFFFFF'
		) );

		// Set content-width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 580;
		}

		// Post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Set post thumbnail size
		set_post_thumbnail_size( 2240, 9999 );

		// Add image sizes
		add_image_size( 'eksell_preview_image', 1080, 9999 );

		// Custom logo
		add_theme_support( 'custom-logo', array(
			'height'      => 240,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// Title tag
		add_theme_support( 'title-tag' );

		// HTML5 semantic markup
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Make the theme translation ready
		load_theme_textdomain( 'eksell', get_template_directory() . '/languages' );

		// Alignwide and alignfull classes in the block editor
		add_theme_support( 'align-wide' );

	}
	add_action( 'after_setup_theme', 'eksell_theme_support' );
endif;


/*	-----------------------------------------------------------------------------------------------
	REQUIRED FILES
	Include required files
--------------------------------------------------------------------------------------------------- */

// Include custom template tags
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons
require get_template_directory() . '/inc/classes/class-eksell-svg-icons.php';

// Handle Customizer settings
require get_template_directory() . '/inc/classes/class-eksell-customizer.php';

// Custom CSS class
require get_template_directory() . '/inc/classes/class-eksell-custom-css.php';


/*	-----------------------------------------------------------------------------------------------
	REGISTER STYLES
	Register and enqueue CSS
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_register_styles' ) ) :
	function eksell_register_styles() {

		$theme_version = wp_get_theme( 'eksell' )->get( 'Version' );
		$css_dependencies = array();

		// Retrieve and enqueue the URL for Google Fonts
		$google_fonts_url = apply_filters( 'eksell_google_fonts_url', '//fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap' );

		if ( $google_fonts_url ) {
			wp_register_style( 'eksell-google-fonts', $google_fonts_url, false, 1.0, 'all' );
			$css_dependencies[] = 'eksell-google-fonts';
		}

		// Filter the list of dependencies used by the eksell-style CSS enqueue
		$css_dependencies = apply_filters( 'eksell_css_dependencies', $css_dependencies );

		wp_enqueue_style( 'eksell-style', get_template_directory_uri() . '/style.css', $css_dependencies, $theme_version, 'all' );

		// Add output of Customizer settings as inline style
		wp_add_inline_style( 'eksell-style', Eksell_Custom_CSS::get_customizer_css() );

		// Enqueue the print styles stylesheet
		wp_enqueue_style( 'eksell-print-styles', get_template_directory_uri() . '/assets/css/print.css', false, $theme_version, 'print' );

	}
	add_action( 'wp_enqueue_scripts', 'eksell_register_styles' );
endif;


/*	-----------------------------------------------------------------------------------------------
	REGISTER SCRIPTS
	Register and enqueue JavaScript
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_register_scripts' ) ) :
	function eksell_register_scripts() {

		$theme_version = wp_get_theme( 'eksell' )->get( 'Version' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Built-in JS assets
		$js_dependencies = array( 'jquery', 'imagesloaded', 'masonry' );

		// Register the Modernizr JS check for touchevents (used to determine whether background-attachment should be active)
		wp_register_script( 'eksell-modernizr', get_template_directory_uri() . '/assets/js/modernizr-touchevents.min.js', array(), '3.6.0' );
		$js_dependencies[] = 'eksell-modernizr';

		// Filter the list of dependencies used by the eksell-construct JavaScript enqueue
		$js_dependencies = apply_filters( 'eksell_js_dependencies', $js_dependencies );

		wp_enqueue_script( 'eksell-construct', get_template_directory_uri() . '/assets/js/construct.js', $js_dependencies, $theme_version );

		// Setup AJAX
		$ajax_url = admin_url( 'admin-ajax.php' );

		// AJAX Load More
		wp_localize_script( 'eksell-construct', 'eksell_ajax_load_more', array(
			'ajaxurl'   => esc_url( $ajax_url ),
		) );

		// AJAX Filters
		wp_localize_script( 'eksell-construct', 'eksell_ajax_filters', array(
			'ajaxurl'   => esc_url( $ajax_url ),
		) );

	}
	add_action( 'wp_enqueue_scripts', 'eksell_register_scripts' );
endif;


/*	-----------------------------------------------------------------------------------------------
	MENUS
	Register navigational menus (wp_nav_menu)
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_menus' ) ) :
	function eksell_menus() {

		// Register menus
		$locations = array(
			'main'   => __( 'Main Menu', 'eksell' ),
			'social' => __( 'Social Menu', 'eksell' ),
		);

		register_nav_menus( $locations );

	}
	add_action( 'init', 'eksell_menus' );
endif;


/*	-----------------------------------------------------------------------------------------------
	BODY CLASSES
	Conditional addition of classes to the body element
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_body_classes' ) ) :
	function eksell_body_classes( $classes ) {

		global $post;
		$post_type = isset( $post ) ? $post->post_type : false;

		// Determine type of infinite scroll
		$pagination_type = get_theme_mod( 'eksell_pagination_type', 'button' );
		
		switch ( $pagination_type ) {
			case 'button':
				$classes[] = 'pagination-type-button';
				break;
			case 'scroll':
				$classes[] = 'pagination-type-scroll';
				break;
			case 'links':
				$classes[] = 'pagination-type-links';
				break;
		}

		// Check whether the current page only has content
		if ( is_page_template( array( 'template-only-content.php' ) ) ) {
			$classes[] = 'has-only-content';
		}

		// Check for disabled search
		if ( get_theme_mod( 'eksell_disable_search', false ) ) {
			$classes[] = 'disable-search-modal';
		}

		// Check for disabled animations
		if ( get_theme_mod( 'eksell_disable_animations', false ) ) {
			$classes[] = 'no-anim';
		} else {
			$classes[] = 'has-anim';
		}

		// Check for post thumbnail
		if ( is_singular() && has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		} elseif ( is_singular() ) {
			$classes[] = 'missing-post-thumbnail';
		}

		// Check whether we're in the customizer preview
		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}

		// Check if posts have single pagination
		if ( is_single() && ( get_next_post() || get_previous_post() ) ) {
			$classes[] = 'has-single-pagination';
		} else {
			$classes[] = 'has-no-pagination';
		}

		// Check if we're showing comments
		if ( is_singular() && ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) ) {
			$classes[] = 'showing-comments';
		} else {
			$classes[] = 'not-showing-comments';
		}

		if ( is_archive() || is_search() || is_home() ) {
			$classes[] = 'archive-page';
		}

		// Slim page template class names (class = name - file suffix)
		if ( is_page_template() ) {
			$classes[] = basename( get_page_template_slug(), '.php' );
		}

		return $classes;

	}
	add_action( 'body_class', 'eksell_body_classes' );
endif;


/*	-----------------------------------------------------------------------------------------------
	NO-JS CLASS
	If we're missing JavaScript support, the HTML element will have a no-js class
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_no_js_class' ) ) :
	function eksell_no_js_class() {

		?>
		<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
		<?php

	}
	add_action( 'wp_head', 'eksell_no_js_class' );
endif;


/*	-----------------------------------------------------------------------------------------------
	ADD EXCERPT SUPPORT TO PAGES
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_add_excerpt_support_to_pages' ) ) :
	function eksell_add_excerpt_support_to_pages() {

		add_post_type_support( 'page', 'excerpt' );

	}
	add_action( 'init', 'eksell_add_excerpt_support_to_pages' );
endif;


/*	-----------------------------------------------------------------------------------------------
	DISABLE ARCHIVE TITLE PREFIX
--------------------------------------------------------------------------------------------------- */

add_filter( 'get_the_archive_title_prefix', '__return_false' );


/*	-----------------------------------------------------------------------------------------------
	GET ARCHIVE TITLE PREFIX
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_get_the_archive_title_prefix' ) ) :
	function eksell_get_the_archive_title_prefix() {

		$prefix = '';

		if ( is_search() ) {
			$prefix = _x( 'Search Results', 'search archive title prefix', 'eksell' );
		} elseif ( is_category() ) {
			$prefix = _x( 'Category', 'category archive title prefix', 'eksell' );
		} elseif ( is_tag() ) {
			$prefix = _x( 'Tag', 'tag archive title prefix', 'eksell' );
		} elseif ( is_author() ) {
			$prefix = _x( 'Author', 'author archive title prefix', 'eksell' );
		} elseif ( is_year() ) {
			$prefix = _x( 'Year', 'date archive title prefix', 'eksell' );
		} elseif ( is_month() ) {
			$prefix = _x( 'Month', 'date archive title prefix', 'eksell' );
		} elseif ( is_day() ) {
			$prefix = _x( 'Day', 'date archive title prefix', 'eksell' );
		} elseif ( is_post_type_archive() ) {
			// No prefix for post type archives
		} elseif ( is_tax( 'post_format' ) ) {
			// No prefix for post format archives
		} elseif ( is_tax() ) {
			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$tax    = get_taxonomy( $queried_object->taxonomy );
				$prefix = sprintf(
					/* translators: %s: Taxonomy singular name. */
					_x( '%s:', 'taxonomy term archive title prefix' ),
					$tax->labels->singular_name
				);
			}
		} elseif ( is_home() && is_paged() ) {
			$prefix = _x( 'Archives', 'general archive title prefix', 'eksell' );
		}

		return apply_filters( 'eksell_archive_title_prefix', $prefix );

	}
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE TITLE

	@param	$title string		The initial title
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_archive_title' ) ) :
	function eksell_filter_archive_title( $title ) {

		// Home: Get the Customizer option for post archive text
		if ( is_home() && ! is_paged() && get_theme_mod( 'eksell_home_text' ) ) {
			$title = get_theme_mod( 'eksell_home_text' );
		}

		// Home and paged: Output page number
		elseif ( is_home() && is_paged() ) {
			global $wp_query;
			$paged 	= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
			$max 	= isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
			$title 	= sprintf( _x( 'Page %1$s of %2$s', '%1$s = Current page number, %2$s = Number of pages', 'eksell' ), $paged, $max );
		}

		// On search, show the search query.
		elseif ( is_search() ) {
			$title = '&ldquo;' . get_search_query() . '&rdquo;';
		}

		return $title;

	}
	add_filter( 'get_the_archive_title', 'eksell_filter_archive_title' );
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE DESCRIPTION

	@param	$description string		The initial description
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_archive_description' ) ) :
	function eksell_filter_archive_description( $description ) {

		// Home: Empty description
		if ( is_home() ) {
			$description = '';
		}
		
		// On search, show a string describing the results of the search.
		elseif ( is_search() ) {
			global $wp_query;
			if ( $wp_query->found_posts ) {
				/* Translators: %s = Number of results */
				$description = sprintf( _nx( 'We found %s result for your search.', 'We found %s results for your search.',  $wp_query->found_posts, '%s = Number of results', 'eksell' ), $wp_query->found_posts );
			} else {
				$description = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'eksell' );
			}
		}

		return $description;

	}
	add_filter( 'get_the_archive_description', 'eksell_filter_archive_description' );
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER CLASSES OF WP_LIST_PAGES ITEMS TO MATCH MENU ITEMS
	Filter the class applied to wp_list_pages() items with children to match the menu class, to simplify
	styling of sub levels in the fallback. Only applied if the match_menu_classes argument is set.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_wp_list_pages_item_classes' ) ) :
	function eksell_filter_wp_list_pages_item_classes( $css_class, $item, $depth, $args, $current_page ) {

		// Only apply to wp_list_pages() calls with match_menu_classes set to true
		$match_menu_classes = isset( $args['match_menu_classes'] );

		if ( ! $match_menu_classes ) {
			return $css_class;
		}

		// Add current menu item class
		if ( in_array( 'current_page_item', $css_class ) ) {
			$css_class[] = 'current-menu-item';
		}

		// Add menu item has children class
		if ( in_array( 'page_item_has_children', $css_class ) ) {
			$css_class[] = 'menu-item-has-children';
		}

		return $css_class;

	}
	add_filter( 'page_css_class', 'eksell_filter_wp_list_pages_item_classes', 10, 5 );
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER NAV MENU ITEM ARGUMENTS
	Add a sub navigation toggle to the main menu
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_nav_menu_item_args' ) ) :
	function eksell_filter_nav_menu_item_args( $args, $item, $depth ) {

		// Add sub menu toggles to the main menu with toggles
		if ( $args->theme_location == 'main' && isset( $args->show_toggles ) ) {

			// Wrap the menu item link contents in a div, used for positioning
			$args->before = '<div class="ancestor-wrapper">';
			$args->after  = '';

			// Add a toggle to items with children
			if ( in_array( 'menu-item-has-children', $item->classes ) ) {

				$toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' > .sub-menu';

				// Add the sub menu toggle
				$args->after .= '<div class="sub-menu-toggle-wrapper"><a href="#" class="toggle sub-menu-toggle stroke-cc" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="250"><span class="screen-reader-text">' . __( 'Show sub menu', 'eksell' ) . '</span>' . eksell_get_theme_svg( 'ui', 'chevron-down', 18, 10 ) . '</a></div>';

			}

			// Close the wrapper
			$args->after .= '</div><!-- .ancestor-wrapper -->';

			// Add sub menu icons to the main menu without toggles (the fallback menu)
		}

		return $args;

	}
	add_filter( 'nav_menu_item_args', 'eksell_filter_nav_menu_item_args', 10, 3 );
endif;


/*	-----------------------------------------------------------------------------------------------
	AJAX LOAD MORE
	Called in construct.js when the user has clicked the load more button
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_ajax_load_more' ) ) :
	function eksell_ajax_load_more() {

		$query_args = json_decode( wp_unslash( $_POST['json_data'] ), true );

		$ajax_query = new WP_Query( $query_args );

		// Determine which preview to use based on the post_type
		$post_type = $ajax_query->get( 'post_type' );

		// Default to the "post" post type for previews
		if ( ! $post_type || is_array( $post_type ) ) {
			$post_type = 'post';
		}

		if ( $ajax_query->have_posts() ) :
			while ( $ajax_query->have_posts() ) : 
				$ajax_query->the_post();

				global $post;
				?>

				<div class="article-wrapper col">
					<?php get_template_part( 'inc/parts/preview', $post_type ); ?>
				</div>

				<?php 
			endwhile;
		endif;

		wp_die();

	}
	add_action( 'wp_ajax_nopriv_eksell_ajax_load_more', 'eksell_ajax_load_more' );
	add_action( 'wp_ajax_eksell_ajax_load_more', 'eksell_ajax_load_more' );
endif;


/* ---------------------------------------------------------------------------------------------
	AJAX FILTERS
	Return the query vars for the query for the taxonomy and terms supplied by JS
--------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_ajax_filters' ) ) : 
	function eksell_ajax_filters() {

		// Get the filters from AJAX
		$term_id 	= isset( $_POST['term_id'] ) ? $_POST['term_id'] : null;
		$taxonomy 	= isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : '';
		$post_type 	= isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';

		$args = array(
			'post_status'			=> 'publish',
			'post_type'				=> $post_type,
		);

		if ( $term_id && $taxonomy ) {
			$args['tax_query'] = array(
				array(
					'taxonomy'	=> $taxonomy,
					'terms'		=> $term_id,
				)
			);
		}

		$custom_query = new WP_Query( $args );

		// Combine the query with the query_vars into a single array
		$query_args = array_merge( $custom_query->query, $custom_query->query_vars );

		// If max_num_pages is not already set, add it
		if ( ! array_key_exists( 'max_num_pages', $query_args ) ) {
			$query_args['max_num_pages'] = $custom_query->max_num_pages;
		}

		// Format and return
		echo json_encode( $query_args );

		wp_die();
	}
	add_action( 'wp_ajax_nopriv_eksell_ajax_filters', 'eksell_ajax_filters' );
	add_action( 'wp_ajax_eksell_ajax_filters', 'eksell_ajax_filters' );
endif;


/*	-----------------------------------------------------------------------------------------------
	EDITOR STYLES FOR THE BLOCK EDITOR
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_block_editor_styles' ) ) :
	function eksell_block_editor_styles() {

		$css_dependencies = array();

		// Retrieve and enqueue the URL for Google Fonts
		$google_fonts_url = apply_filters( 'eksell_google_fonts_url', '//fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap' );

		if ( $google_fonts_url ) {
			wp_register_style( 'eksell_google_fonts', $google_fonts_url, false, 1.0, 'all' );
			$css_dependencies[] = 'eksell_google_fonts';
		}

		// Enqueue the editor styles
		wp_enqueue_style( 'eksell_block_editor_styles', get_theme_file_uri( 'assets/css/eksell-editor-style-block-editor.css' ), $css_dependencies, wp_get_theme( 'eksell' )->get( 'Version' ), 'all' );

		// Add inline style from the Customizer
		wp_add_inline_style( 'eksell_block_editor_styles', Eksell_Custom_CSS::get_customizer_css() );

	}
	add_action( 'enqueue_block_editor_assets', 'eksell_block_editor_styles', 1, 1 );
endif;


/* ---------------------------------------------------------------------------------------------
   BLOCK EDITOR SETTINGS
   Add custom colors and font sizes to the block editor
------------------------------------------------------------------------------------------------ */

if ( ! function_exists( 'eksell_block_editor_settings' ) ) :
	function eksell_block_editor_settings() {

		/* Block Editor Palette -------------- */

		$editor_color_palette 	= array();
		$color_options 			= array();

		// Get the color options
		// By default, this array contains two groups of colors: primary and dark-mode
		$color_options_groups = Eksell_Customizer::get_color_options();

		// Merge the two groups into one array with all colors
		foreach ( $color_options_groups as $group ) {
			$color_options = array_merge( $color_options, $group );
		}

		// Loop over them and construct an array for the editor-color-palette
		if ( $color_options ) {
			foreach ( $color_options as $color_option_name => $color_option ) {

				// Only add the colors set to be included in the color palette
				if ( ! $color_option['palette'] ) continue;

				$editor_color_palette[] = array(
					'name'  => $color_option['label'],
					'slug'  => $color_option['slug'],
					'color' => get_theme_mod( $color_option_name, $color_option['default'] ),
				);
			}
		}

		// Add the background option
		$background_color = '#' . get_background_color();
		$editor_color_palette[] = array(
			'name'  => __( 'Background Color', 'eksell' ),
			'slug'  => 'body-background',
			'color' => $background_color,
		);

		// If we have accent colors, add them to the block editor palette
		if ( $editor_color_palette ) {
			add_theme_support( 'editor-color-palette', $editor_color_palette );
		}

		/* Block Editor Font Sizes ----------- */

		add_theme_support( 'editor-font-sizes',
			array(
				array(
					'name'      => _x( 'Small', 'Name of the small font size in Gutenberg', 'eksell' ),
					'shortName' => _x( 'S', 'Short name of the small font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => _x( 'Regular', 'Name of the regular font size in Gutenberg', 'eksell' ),
					'shortName' => _x( 'M', 'Short name of the regular font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 19,
					'slug'      => 'normal',
				),
				array(
					'name'      => _x( 'Large', 'Name of the large font size in Gutenberg', 'eksell' ),
					'shortName' => _x( 'L', 'Short name of the large font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => _x( 'Larger', 'Name of the larger font size in Gutenberg', 'eksell' ),
					'shortName' => _x( 'XL', 'Short name of the larger font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 32,
					'slug'      => 'larger',
				)
			)
		);

	}
	add_action( 'after_setup_theme', 'eksell_block_editor_settings' );
endif;
