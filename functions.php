<?php


/*	-----------------------------------------------------------------------------------------------
	THEME SUPPORTS
	Default setup, some features excluded
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_theme_support' ) ) :
	function eksell_theme_support() {

		// Automatic feed.
		add_theme_support( 'automatic-feed-links' );

		// Custom background color.
		add_theme_support( 'custom-background', array(
			'default-color'	=> 'FFFFFF'
		) );

		// Set content-width.
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 652;
		}

		// Post thumbnails.
		add_theme_support( 'post-thumbnails' );

		// Set post thumbnail size.
		set_post_thumbnail_size( 2240, 9999 );

		// Add image sizes.
		add_image_size( 'eksell_preview_image', 1080, 9999 );

		// Custom logo.
		add_theme_support( 'custom-logo', array(
			'height'      => 144,
			'width'       => 192,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// Title tag.
		add_theme_support( 'title-tag' );

		// HTML5 semantic markup.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Make the theme translation ready.
		load_theme_textdomain( 'eksell', get_template_directory() . '/languages' );

		// Alignwide and alignfull classes in the block editor.
		add_theme_support( 'align-wide' );

		// Block Editor font sizes.
		add_theme_support( 'editor-font-sizes',
			array(
				array(
					'name'      => esc_html_x( 'Small', 'Name of the small font size in Gutenberg', 'eksell' ),
					'shortName' => esc_html_x( 'S', 'Short name of the small font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => esc_html_x( 'Regular', 'Name of the regular font size in Gutenberg', 'eksell' ),
					'shortName' => esc_html_x( 'M', 'Short name of the regular font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 18,
					'slug'      => 'normal',
				),
				array(
					'name'      => esc_html_x( 'Large', 'Name of the large font size in Gutenberg', 'eksell' ),
					'shortName' => esc_html_x( 'L', 'Short name of the large font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => esc_html_x( 'Larger', 'Name of the larger font size in Gutenberg', 'eksell' ),
					'shortName' => esc_html_x( 'XL', 'Short name of the larger font size in the Gutenberg editor.', 'eksell' ),
					'size'      => 32,
					'slug'      => 'larger',
				)
			)
		);

		/* Block Editor Color Palette -------- */

		$editor_color_palette 	= array();
		$color_options 			= array();

		// Get the color options. By default, this array contains two groups of colors: primary and dark-mode.
		$color_options_groups = Eksell_Customizer::get_color_options();
		
		if ( $color_options_groups ) {

			// Merge the two groups into one array with all colors.
			foreach ( $color_options_groups as $group ) {
				$color_options = array_merge( $color_options, $group );
			}

			// Loop over them and construct an array for the editor-color-palette.
			if ( $color_options ) {
				foreach ( $color_options as $color_option_name => $color_option ) {

					// Only add the colors set to be included in the color palette
					if ( ! isset( $color_option['palette'] ) || ! $color_option['palette'] ) continue;

					$editor_color_palette[] = array(
						'name'  => $color_option['label'],
						'slug'  => $color_option['slug'],
						'color' => get_theme_mod( $color_option_name, $color_option['default'] ),
					);
				}
			}

			// Add the background option.
			$background_color = '#' . get_theme_mod( 'background_color', 'ffffff' );
			$editor_color_palette[] = array(
				'name'  => esc_html__( 'Background Color', 'eksell' ),
				'slug'  => 'body-background',
				'color' => $background_color,
			);
		}

		// If we have colors, add them to the block editor palette.
		if ( $editor_color_palette ) {
			add_theme_support( 'editor-color-palette', $editor_color_palette );
		}

	}
	add_action( 'after_setup_theme', 'eksell_theme_support' );
endif;


/*	-----------------------------------------------------------------------------------------------
	REQUIRED FILES
	Include required files
--------------------------------------------------------------------------------------------------- */

// Include custom template tags.
require get_template_directory() . '/inc/template-tags.php';

// Handle Block Patterns.
require get_template_directory() . '/inc/classes/class-eksell-block-settings.php';

// Handle SVG icons.
require get_template_directory() . '/inc/classes/class-eksell-svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/inc/classes/class-eksell-customizer.php';

// Custom CSS class.
require get_template_directory() . '/inc/classes/class-eksell-custom-css.php';

// Custom Customizer control for multiple checkboxes.
require get_template_directory() . '/inc/classes/class-eksell-customize-control-checkbox-multiple.php';


/*	-----------------------------------------------------------------------------------------------
	REGISTER STYLES
	Register and enqueue CSS.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_register_styles' ) ) :
	function eksell_register_styles() {

		$theme_version = wp_get_theme( 'eksell' )->get( 'Version' );
		$css_dependencies = array();

		// Retrieve and enqueue the URL for Google Fonts.
		// You can remove the Google Fonts enqueue by filtering `eksell_google_fonts_url`.
		$google_fonts_url = apply_filters( 'eksell_google_fonts_url', '//fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap' );

		if ( $google_fonts_url ) {
			wp_register_style( 'eksell-google-fonts', $google_fonts_url, false, 1.0, 'all' );
			$css_dependencies[] = 'eksell-google-fonts';
		}

		// Filter the list of dependencies used by the eksell-style CSS enqueue.
		$css_dependencies = apply_filters( 'eksell_css_dependencies', $css_dependencies );

		wp_enqueue_style( 'eksell-style', get_template_directory_uri() . '/style.css', $css_dependencies, $theme_version, 'all' );

		// Add output of Customizer settings as inline style.
		wp_add_inline_style( 'eksell-style', Eksell_Custom_CSS::get_customizer_css() );

		// Enqueue the print styles stylesheet.
		wp_enqueue_style( 'eksell-print-styles', get_template_directory_uri() . '/assets/css/print.css', false, $theme_version, 'print' );

	}
	add_action( 'wp_enqueue_scripts', 'eksell_register_styles' );
endif;


/*	-----------------------------------------------------------------------------------------------
	REGISTER SCRIPTS
	Register and enqueue JavaScript.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_register_scripts' ) ) :
	function eksell_register_scripts() {

		$theme_version = wp_get_theme( 'eksell' )->get( 'Version' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Built-in JS assets.
		$js_dependencies = array( 'jquery', 'imagesloaded', 'masonry' );

		// CSS variables ponyfill.
		wp_register_script( 'eksell-css-vars-ponyfill', get_template_directory_uri() . '/assets/js/css-vars-ponyfill.min.js', array(), '3.6.0' );
		$js_dependencies[] = 'eksell-css-vars-ponyfill';

		// Filter the list of dependencies used by the eksell-construct JavaScript enqueue.
		$js_dependencies = apply_filters( 'eksell_js_dependencies', $js_dependencies );

		wp_enqueue_script( 'eksell-construct', get_template_directory_uri() . '/assets/js/construct.js', $js_dependencies, $theme_version );

		// Setup AJAX.
		$ajax_url = admin_url( 'admin-ajax.php' );

		// AJAX Load More.
		wp_localize_script( 'eksell-construct', 'eksell_ajax_load_more', array(
			'ajaxurl'   => esc_url( $ajax_url ),
		) );

		// AJAX Filters.
		wp_localize_script( 'eksell-construct', 'eksell_ajax_filters', array(
			'ajaxurl'   => esc_url( $ajax_url ),
		) );

	}
	add_action( 'wp_enqueue_scripts', 'eksell_register_scripts' );
endif;


/*	-----------------------------------------------------------------------------------------------
	MENUS
	Register navigation menus.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_register_nav_menus' ) ) :
	function eksell_register_nav_menus() {

		register_nav_menus( array(
			'main'   => esc_html__( 'Main Menu', 'eksell' ),
			'social' => esc_html__( 'Social Menu', 'eksell' ),
		) );

	}
	add_action( 'init', 'eksell_register_nav_menus' );
endif;


/*	-----------------------------------------------------------------------------------------------
	BODY CLASSES
	Conditional addition of classes to the body element.

	@param array	$classes	An array of body classes.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_body_classes' ) ) :
	function eksell_body_classes( $classes ) {

		global $post;
		$post_type = isset( $post ) ? $post->post_type : false;

		// Determine type of infinite scroll.
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

		// Check whether the current page only has content.
		if ( is_page_template( array( 'page-templates/template-no-title.php', 'page-templates/template-blank-canvas.php' ) ) ) {
			$classes[] = 'has-only-content';
		}

		// Check for disabled search.
		if ( ! get_theme_mod( 'eksell_enable_search', true ) ) {
			$classes[] = 'disable-search-modal';
		}

		// Check for social menu.
		if ( has_nav_menu( 'social' ) ) {
			$classes[] = 'has-social-menu';
		}

		// Check for dark mode.
		if ( get_theme_mod( 'eksell_enable_dark_mode_palette', false ) ) {
			$classes[] = 'has-dark-mode-palette';
		}

		// Check for disabled animations.
		$classes[] = get_theme_mod( 'eksell_disable_animations', false ) ? 'no-anim' : 'has-anim';

		// Check for post thumbnail.
		if ( is_singular() && has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		} elseif ( is_singular() ) {
			$classes[] = 'missing-post-thumbnail';
		}

		// Check whether we're in the customizer preview.
		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}

		// Check if we're showing comments.
		if ( is_singular() && ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) ) {
			$classes[] = 'showing-comments';
		} else if ( is_singular() ) {
			$classes[] = 'not-showing-comments';
		}

		// Shared archive page class.
		if ( is_archive() || is_search() || is_home() ) {
			$classes[] = 'archive-page';
		}

		// Slim page template class names (class = name - file suffix).
		if ( is_page_template() ) {
			$classes[] = basename( get_page_template_slug(), '.php' );
		}

		return $classes;

	}
	add_action( 'body_class', 'eksell_body_classes' );
endif;


/*	-----------------------------------------------------------------------------------------------
	NO-JS CLASS
	If we're missing JavaScript support, the HTML element will have a no-js class.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_no_js_class' ) ) :
	function eksell_no_js_class() {

		?>
		<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
		<?php

	}
	add_action( 'wp_head', 'eksell_no_js_class', 0 );
endif;


/*	-----------------------------------------------------------------------------------------------
	NOSCRIPT STYLES
	Unset CSS animations triggered in JavaScript within a noscript element, to prevent the flash of 
	unstyled animation elements that occurs when using the .no-js class.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_noscript_styles' ) ) :
	function eksell_noscript_styles() {

		?>
		<noscript>
			<style>
				.spot-fade-in-scale, .no-js .spot-fade-up { 
					opacity: 1.0 !important; 
					transform: none !important;
				}
			</style>
		</noscript>
		<?php

	}
	add_action( 'wp_head', 'eksell_noscript_styles', 0 );
endif;


/*	-----------------------------------------------------------------------------------------------
	ADD EXCERPT SUPPORT TO PAGES
	Enables the excerpt subheading output in the page header on pages as well as posts.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_add_excerpt_support_to_pages' ) ) :
	function eksell_add_excerpt_support_to_pages() {

		add_post_type_support( 'page', 'excerpt' );

	}
	add_action( 'init', 'eksell_add_excerpt_support_to_pages' );
endif;


/*	-----------------------------------------------------------------------------------------------
	DISABLE ARCHIVE TITLE PREFIX
	The prefix is output separately in the archive header with eksell_get_the_archive_title_prefix().
--------------------------------------------------------------------------------------------------- */

add_filter( 'get_the_archive_title_prefix', '__return_false' );


/*	-----------------------------------------------------------------------------------------------
	GET ARCHIVE TITLE PREFIX
	Replicates the prefix removed with the get_the_archive_title_prefix filter, with some modifications.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_get_the_archive_title_prefix' ) ) :
	function eksell_get_the_archive_title_prefix() {

		$prefix = '';

		if ( is_search() ) {
			$prefix = esc_html_x( 'Search Results', 'search archive title prefix', 'eksell' );
		} elseif ( is_category() ) {
			$prefix = esc_html_x( 'Category', 'category archive title prefix', 'eksell' );
		} elseif ( is_tag() ) {
			$prefix = esc_html_x( 'Tag', 'tag archive title prefix', 'eksell' );
		} elseif ( is_author() ) {
			$prefix = esc_html_x( 'Author', 'author archive title prefix', 'eksell' );
		} elseif ( is_year() ) {
			$prefix = esc_html_x( 'Year', 'date archive title prefix', 'eksell' );
		} elseif ( is_month() ) {
			$prefix = esc_html_x( 'Month', 'date archive title prefix', 'eksell' );
		} elseif ( is_day() ) {
			$prefix = esc_html_x( 'Day', 'date archive title prefix', 'eksell' );
		} elseif ( is_post_type_archive() ) {
			// No prefix for post type archives.
			$prefix = '';
		} elseif ( is_tax( 'post_format' ) ) {
			// No prefix for post format archives.
			$prefix = '';
		} elseif ( is_tax() ) {
			$queried_object = get_queried_object();
			if ( $queried_object ) {
				$tax    = get_taxonomy( $queried_object->taxonomy );
				$prefix = sprintf(
					/* translators: %s: Taxonomy singular name. */
					esc_html_x( '%s:', 'taxonomy term archive title prefix', 'eksell' ),
					$tax->labels->singular_name
				);
			}
		} elseif ( is_home() && is_paged() ) {
			$prefix = esc_html_x( 'Archives', 'general archive title prefix', 'eksell' );
		}

		// Make the prefix filterable before returning it.
		return apply_filters( 'eksell_archive_title_prefix', $prefix );

	}
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE TITLE
	Modify the title of archive pages.

	@param string	$title 	The initial title.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_archive_title' ) ) :
	function eksell_filter_archive_title( $title ) {

		// Home: Get the Customizer option for post archive text.
		if ( is_home() && ! is_paged() ) {
			$title = get_theme_mod( 'eksell_home_text', '' );
		}

		// Home and paged: Output page number.
		elseif ( is_home() && is_paged() ) {
			global $wp_query;
			$paged 	= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
			$max 	= isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
			$title 	= sprintf( esc_html_x( 'Page %1$s of %2$s', '%1$s = Current page number, %2$s = Number of pages', 'eksell' ), $paged, $max );
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
	Modify the description of archive pages.

	@param string	$description 	The initial description.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_archive_description' ) ) :
	function eksell_filter_archive_description( $description ) {

		// Home: Empty description.
		if ( is_home() ) {
			$description = '';
		}
		
		// On search, show a string describing the results of the search.
		elseif ( is_search() ) {
			global $wp_query;
			if ( $wp_query->found_posts ) {
				/* Translators: %s = Number of results */
				$description = esc_html( sprintf( _nx( 'We found %s result for your search.', 'We found %s results for your search.',  $wp_query->found_posts, '%s = Number of results', 'eksell' ), $wp_query->found_posts ) );
			} else {
				$description = esc_html__( 'We could not find any results for your search. You can give it another try through the search form below.', 'eksell' );
			}
		}

		return $description;

	}
	add_filter( 'get_the_archive_description', 'eksell_filter_archive_description' );
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER THE EXCERPT SUFFIX
	Replaces the default [...] with a &hellip; (three dots)
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_excerpt_more' ) ) :
	function eksell_excerpt_more() {

		return '&hellip;';

	}
	add_filter( 'excerpt_more', 'eksell_excerpt_more' );
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER CLASSES OF WP_LIST_PAGES ITEMS TO MATCH MENU ITEMS
	Filter the class applied to wp_list_pages() items with children to match the menu class, to simplify
	styling of sub levels in the fallback. Only applied if the match_menu_classes argument is set.

	@param string[] $css_class    An array of CSS classes to be applied to each list item.
	@param WP_Post  $page         Page data object.
	@param int      $depth        Depth of page, used for padding.
	@param array    $args         An array of arguments.
	@param int      $current_page ID of the current page.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_wp_list_pages_item_classes' ) ) :
	function eksell_filter_wp_list_pages_item_classes( $css_class, $item, $depth, $args, $current_page ) {

		// Only apply to wp_list_pages() calls with match_menu_classes set to true.
		$match_menu_classes = isset( $args['match_menu_classes'] );

		if ( ! $match_menu_classes ) {
			return $css_class;
		}

		// Add current menu item class.
		if ( in_array( 'current_page_item', $css_class ) ) {
			$css_class[] = 'current-menu-item';
		}

		// Add menu item has children class.
		if ( in_array( 'page_item_has_children', $css_class ) ) {
			$css_class[] = 'menu-item-has-children';
		}

		return $css_class;

	}
	add_filter( 'page_css_class', 'eksell_filter_wp_list_pages_item_classes', 10, 5 );
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER NAV MENU ITEM ARGUMENTS
	Add a sub navigation toggle to the main menu.

	@param stdClass $args  An object of wp_nav_menu() arguments.
	@param WP_Post  $item  Menu item data object.
	@param int      $depth Depth of menu item. Used for padding.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_nav_menu_item_args' ) ) :
	function eksell_filter_nav_menu_item_args( $args, $item, $depth ) {

		// Add sub menu toggles to the main menu with toggles.
		if ( $args->theme_location == 'main' && isset( $args->show_toggles ) ) {

			// Wrap the menu item link contents in a div, used for positioning.
			$args->before = '<div class="ancestor-wrapper">';
			$args->after  = '';

			// Add a toggle to items with children.
			if ( in_array( 'menu-item-has-children', $item->classes ) ) {

				$toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' &gt; .sub-menu';

				// Add the sub menu toggle.
				$args->after .= '<div class="sub-menu-toggle-wrapper"><a href="#" class="toggle sub-menu-toggle stroke-cc" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="250"><span class="screen-reader-text">' . esc_html__( 'Show sub menu', 'eksell' ) . '</span>' . eksell_get_theme_svg( 'ui', 'chevron-down', 18, 10 ) . '</a></div>';

			}

			// Close the wrapper.
			$args->after .= '</div><!-- .ancestor-wrapper -->';

		}

		return $args;

	}
	add_filter( 'nav_menu_item_args', 'eksell_filter_nav_menu_item_args', 10, 3 );
endif;


/*	-----------------------------------------------------------------------------------------------
	IS COMMENT BY POST AUTHOR?
	Check if the specified comment is written by the author of the post commented on.

	@param obj $comment		The comment object.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_is_comment_by_post_author' ) ) :
	function eksell_is_comment_by_post_author( $comment ) {

		if ( is_object( $comment ) && $comment->user_id > 0 ) {
			$user = get_userdata( $comment->user_id );
			$post = get_post( $comment->comment_post_ID );
			if ( ! empty( $user ) && ! empty( $post ) ) {
				return $comment->user_id === $post->post_author;
			}
		}
		return false;

	}
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER COMMENT TEXT
	If the comment is by the post author, append an element which says so.

	@param string          $comment_text Text of the current comment.
	@param WP_Comment|null $comment      The comment object. Null if not found.
	@param array           $args         An array of arguments.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_comment_text' ) ) :
	function eksell_filter_comment_text( $comment_text, $comment, $args ) {

		if ( eksell_is_comment_by_post_author( $comment ) ) {
			$comment_text .= '<p class="by-post-author">' . esc_html__( 'By Post Author', 'eksell' ) . '</p>';
		}

		return $comment_text;

	}
	add_filter( 'comment_text', 'eksell_filter_comment_text', 10, 3 );
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER IMAGE SIZE FOR GIF POST THUMBNAILS
	Set post thumbnails of the GIF file type to always use the `full` size, so they include animations.

	@param string|int[] $size		Requested image size. Can be any registered image size name, or 
									an array of width and height values in pixels (in that order).
    @param int 			$post_id 	The post ID.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_filter_post_thumbnail_size' ) ) :
	function eksell_filter_post_thumbnail_size( $size, $post_id ) {

		$mime_type = get_post_mime_type( get_post_thumbnail_id( $post_id ) );

		if ( $mime_type && $mime_type === 'image/gif' ) {
			return 'full';
		}

		return $size;

	}
	add_filter( 'post_thumbnail_size', 'eksell_filter_post_thumbnail_size', 10, 3 );
endif;


/* 	-----------------------------------------------------------------------------------------------
	MAYBE DISABLE GOOGLE FONTS
	Check whether to disable Google Fonts based on the setting in the Customizer.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_maybe_disable_google_fonts' ) ) :
	function eksell_maybe_disable_google_fonts( $url ) {

		// If the Customizer setting is set to disable, return false.
		$disable_google_fonts = get_theme_mod( 'eksell_disable_google_fonts' );

		if ( $disable_google_fonts ) {
			return false;
		}
		
		// If not, return the Google Fonts URL.
		return $url;

	}
	add_filter( 'eksell_google_fonts_url', 'eksell_maybe_disable_google_fonts' );
endif;


/*	-----------------------------------------------------------------------------------------------
	AJAX LOAD MORE
	Called in construct.js when the the pagination is triggered to load more posts.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_ajax_load_more' ) ) :
	function eksell_ajax_load_more() {

		$query_args = json_decode( wp_unslash( $_POST['json_data'] ), true );

		$ajax_query = new WP_Query( $query_args );

		// Determine which preview to use based on the post_type.
		$post_type = $ajax_query->get( 'post_type' );

		// Default to the "post" post type for mixed content.
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
	Return the query vars for the query for the taxonomy and terms supplied by JS.
--------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_ajax_filters' ) ) : 
	function eksell_ajax_filters() {

		// Get the filters from AJAX.
		$term_id 	= isset( $_POST['term_id'] ) ? $_POST['term_id'] : null;
		$taxonomy 	= isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : '';
		$post_type 	= isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';

		$args = array(
			'ignore_sticky_posts'	=> false,
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

		// Combine the query with the query_vars into a single array.
		$query_args = array_merge( $custom_query->query, $custom_query->query_vars );

		// If max_num_pages is not already set, add it.
		if ( ! array_key_exists( 'max_num_pages', $query_args ) ) {
			$query_args['max_num_pages'] = $custom_query->max_num_pages;
		}

		// Format and return.
		echo json_encode( $query_args );

		wp_die();
	}
	add_action( 'wp_ajax_nopriv_eksell_ajax_filters', 'eksell_ajax_filters' );
	add_action( 'wp_ajax_eksell_ajax_filters', 'eksell_ajax_filters' );
endif;


/*	-----------------------------------------------------------------------------------------------
	BLOCK EDITOR ASSETS
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_block_editor_styles' ) ) :
	function eksell_block_editor_styles() {

		$theme_version = wp_get_theme( 'eksell' )->get( 'Version' );
		$css_dependencies = array();

		// Retrieve and enqueue the URL for Google Fonts.
		// You can remove the Google Fonts enqueue by filtering `eksell_google_fonts_url`.
		$google_fonts_url = apply_filters( 'eksell_google_fonts_url', '//fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap' );

		if ( $google_fonts_url ) {
			wp_register_style( 'eksell_google_fonts', $google_fonts_url, false, 1.0, 'all' );
			$css_dependencies[] = 'eksell_google_fonts';
		}

		// Enqueue the editor styles.
		wp_enqueue_style( 'eksell_block_editor_styles', 'get_theme_file_uri'( 'assets/css/eksell-editor-styles.css' ), $css_dependencies, $theme_version, 'all' );

		// Add inline style from the Customizer.
		wp_add_inline_style( 'eksell_block_editor_styles', Eksell_Custom_CSS::get_customizer_css() );

	}
	add_action( 'enqueue_block_editor_assets', 'eksell_block_editor_styles', 1, 1 );
endif;