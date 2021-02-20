<?php


/* ------------------------------------------------------------------------------------------------
   CUSTOM LOGO OUTPUT
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_custom_logo' ) ) :
	function eksell_the_custom_logo( $logo_theme_mod = 'custom_logo' ) {

		echo esc_html( eksell_get_custom_logo( $logo_theme_mod ) );

	}
endif;

if ( ! function_exists( 'eksell_get_custom_logo' ) ) :
	function eksell_get_custom_logo( $logo_theme_mod = 'custom_logo' ) {

		// Get the attachment id for the specified logo
		$logo_id = get_theme_mod( $logo_theme_mod );
		
		if ( ! $logo_id ) return;

		$logo = wp_get_attachment_image_src( $logo_id, 'full' );

		if ( ! $logo ) return;

		// For clarity
		$logo_url = esc_url( $logo[0] );
		$logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', TRUE );
		$logo_width = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half
		if ( get_theme_mod( 'eksell_retina_logo', false ) ) {
			$logo_width = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );
		}

		// CSS friendly class
		$logo_theme_mod_class = str_replace( '_', '-', $logo_theme_mod );

		// Record our output
		ob_start();

		?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="custom-logo-link <?php echo esc_attr( $logo_theme_mod_class ); ?>">
			<img src="<?php echo esc_url( $logo_url ); ?>" width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>" style="height: <?php echo esc_attr( $logo_height ); ?>px;"<?php if ( $logo_alt ) echo ' alt="' . esc_attr( $logo_alt ) . '"'; ?> />
		</a>

		<?php

		// Return our output
		return ob_get_clean();

	}
endif;

	
/* ---------------------------------------------------------------------------------------------
   GET FALLBACK IMAGE
------------------------------------------------------------------------------------------------ */

if ( ! function_exists( 'eksell_get_fallback_image_url' ) ) :
	function eksell_get_fallback_image_url() {

		$fallback_image_id = get_theme_mod( 'eksell_fallback_image' );

		if ( $fallback_image_id ) {
			$fallback_image = wp_get_attachment_image_src( $fallback_image_id, 'full' );
		}

		$fallback_image_url = isset( $fallback_image ) && $fallback_image ? esc_url( $fallback_image[0] ) : get_template_directory_uri() . '/assets/images/default-fallback-image.png';

		return $fallback_image_url;

	}
endif;


/* ---------------------------------------------------------------------------------------------
   OUTPUT AND RETURN FALLBACK IMAGE
   --------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_fallback_image' ) ) :
	function eksell_the_fallback_image() {

		echo eksell_get_fallback_image();

	}
endif;

if ( ! function_exists( 'eksell_get_fallback_image' ) ) :
	function eksell_get_fallback_image() {

		$fallback_image_url = eksell_get_fallback_image_url();

		if ( ! $fallback_image_url ) return;

		return '<img src="' . esc_attr( $fallback_image_url ) . '" class="fallback-featured-image" loading="lazy" />';

	}
endif;


/*	-----------------------------------------------------------------------------------------------
	OUTPUT AND GET THEME SVG
	Output and get the SVG markup for a icon in the Eksell_SVG_Icons class.

	@param string	$group The group the icon belongs to.
	@param string	$icon The name of the icon in the group array.
	@param int		$width Icon width in pixels.
 	@param int		$height Icon height in pixels.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_theme_svg' ) ) :
	function eksell_the_theme_svg( $group, $icon, $width = 24, $height = 24 ) {
		echo eksell_get_theme_svg( $group, $icon, $width, $height );
	}
endif;

if ( ! function_exists( 'eksell_get_theme_svg' ) ) :
	function eksell_get_theme_svg( $group, $icon, $width = 24, $height = 24 ) {
		return Eksell_SVG_Icons::get_svg( $group, $icon, $width, $height );
	}
endif;


/*	-----------------------------------------------------------------------------------------------
	GET SOCIAL LINK SVG
	Detects the social network from a URL and returns the SVG code for its icon.

	@param string	$uri Social link.
 	@param int		$width Icon width in pixels.
 	@param int		$height Icon height in pixels.
--------------------------------------------------------------------------------------------------- */

function eksell_get_social_link_svg( $uri, $width = 24, $height = 24 ) {
	return Eksell_SVG_Icons::get_social_link_svg( $uri, $width, $height );
}


/*	-----------------------------------------------------------------------------------------------
	SOCIAL MENU ICONS
	Displays SVG icons in the social menu.

	@param string   $item_output The menu item's starting HTML output.
	@param WP_Post  $item        Menu item data object.
	@param int      $depth       Depth of the menu. Used for padding.
	@param stdClass $args        An object of wp_nav_menu() arguments.
--------------------------------------------------------------------------------------------------- */

function eksell_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	// Change SVG icon inside social menu if there is a supported URL.
	if ( 'social' === $args->theme_location ) {
		$svg = eksell_get_social_link_svg( $item->url, 24, 24 );
		if ( ! empty( $svg ) ) {
			$item_output = str_replace( $args->link_before, $svg, $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'eksell_nav_menu_social_icons', 10, 4 );


/*	-----------------------------------------------------------------------------------------------
	OUTPUT SOCIAL MENU
	Output the social menu, if set.

	@param array $args		Arguments for wp_nav_menu().
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_social_menu' ) ) :
	function eksell_the_social_menu( $args = array() ) {

		$social_args = eksell_get_social_menu_args( $args );

		if ( has_nav_menu( $social_args['theme_location'] ) ) {
			wp_nav_menu( $social_args );
		}

	}
endif;


/*	-----------------------------------------------------------------------------------------------
	GET SOCIAL MENU WP_NAV_MENU ARGS
	Return the social menu arguments for wp_nav_menu().

	@param array $args		Arguments to use in conjunction with the default arguments.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_get_social_menu_args' ) ) :
	function eksell_get_social_menu_args( $args = array() ) {

		return $args = wp_parse_args( $args, array(
			'theme_location'	=> 'social',
			'container'			=> '',
			'container_class'	=> '',
			'menu_class'		=> 'social-menu reset-list-style social-icons',
			'depth'				=> 1,
			'link_before'		=> '<span class="screen-reader-text">',
			'link_after'		=> '</span>',
			'fallback_cb'		=> '',
		) );

	}
endif;


/*	-----------------------------------------------------------------------------------------------
	IS COMMENT BY POST AUTHOR?
	Check if the specified comment is written by the author of the post commented on.

	@param obj $comment		The comment object.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_is_comment_by_post_author' ) ) :
	function eksell_is_comment_by_post_author( $comment = null ) {

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


/*	-----------------------------------------------------------------------------------------------
	IS THE POST/PAGE SET TO A COVER TEMPLATE?
	Helper function for checking if the specified post is set to any of the cover templates.

	@param	$post mixed		Optional. Post ID or WP_Post object. Default is global $post.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_is_cover_template' ) ) :
	function eksell_is_cover_template( $post = null ) {

		$post = get_post( $post );

		// Filterable list of cover templates to check for
		$cover_templates = apply_filters( 'eksell_cover_templates', array( 'template-cover.php', 'template-full-width-cover.php' ) );

		return in_array( get_page_template_slug( $post ), $cover_templates );

	}
endif;


/* ------------------------------------------------------------------------------------------------
   GET POST GRID COLUMN CLASSES
   Gets the number of columns set in the Customizer, and returns the classes that should be used to
   set the post grid to the number of columns specified
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_get_archive_columns_classes' ) ) :
	function eksell_get_archive_columns_classes() {

		$classes = array();

		// Get the array holding all of the columns options
		$archive_columns_options = Eksell_Customizer::get_archive_columns_options();

		// Loop over the array, and class value of each one to the array
		foreach ( $archive_columns_options as $setting_name => $setting_data ) {

			// Get the value of the setting, or the default if none is set
			$value = get_theme_mod( $setting_name, $setting_data['default'] );

			// Convert the number in the setting (1/2/3/4) to the class names used in our twelve column grid
			switch ( $setting_name ) {
				case 'eksell_post_grid_columns_mobile' : 
					$classes['mobile'] = 'cols-' . ( 12 / $value );
					break;

				case 'eksell_post_grid_columns_tablet_portrait' : 
					$classes['tablet_portrait'] = 'cols-t-' . ( 12 / $value );
					break;

				case 'eksell_post_grid_columns_tablet_landscape' : 
					$classes['tablet_landscape'] = 'cols-tl-' . ( 12 / $value );
					break;

				case 'eksell_post_grid_columns_desktop' : 
					$classes['desktop'] = 'cols-d-' . ( 12 / $value );
					break;

				case 'eksell_post_grid_columns_desktop_large' : 
					$classes['desktop_large'] = 'cols-dl-' . ( 12 / $value );
					break;

			}
		}

		return apply_filters( 'eksell_archive_columns_classes', $classes );

	}
endif;


/*	-----------------------------------------------------------------------------------------------
	OUTPUT ARCHIVE FILTER
	Output the archive filter beneath the archive header.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_archive_filter' ) ) :
	function eksell_the_archive_filter() {

		global $paged;
		
		// Whether to display the filter (defaults to on home or on JetPack Portfolio CPT archive, and when set to active in the Customizer)
		$show_home_filter = apply_filters( 'eksell_show_home_filter', ( is_home() || is_post_type_archive( 'jetpack-portfolio' ) ) && $paged == 0 && get_theme_mod( 'eksell_show_home_filter', true ) );
		
		if ( ! $show_home_filter ) return;

		$filter_taxonomy = is_post_type_archive( 'jetpack-portfolio' ) ? 'jetpack-portfolio-type' : 'category';

		$terms = get_terms( apply_filters( 'eksell_home_filter_get_terms_args', array(
			'depth'		=> 1,
			'taxonomy'	=> $filter_taxonomy,
		) ) );

		if ( ! $terms ) return;

		$home_url = '';
		$post_type = '';

		// Determine the correct home URL to link to
		if ( is_home() ) {
			$home_url = home_url();
			$post_type = 'post';
		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type();
			$home_url = get_post_type_archive_link( $post_type );
		}

		$home_url = apply_filters( 'eksell_filter_home_url', $home_url );
	
		?>

		<div class="filter-wrapper i-a a-fade-up a-del-200">
			<ul class="filter-list reset-list-style">

				<?php if ( $home_url ) : ?>
					<li><a class="filter-link active" data-filter-post-type="<?php echo esc_attr( $post_type ); ?>" href="<?php echo esc_url( $home_url ); ?>"><?php _e( 'Show All', 'eksell' ); ?></a></li>
				<?php endif; ?>

				<?php foreach ( $terms as $term ) : ?>
					<li><a class="filter-link" data-filter-term-id="<?php echo esc_attr( $term->term_id ); ?>" data-filter-taxonomy="<?php echo esc_attr( $term->taxonomy ); ?>" data-filter-post-type="<?php echo esc_attr( $post_type ); ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo $term->name; ?></a></li>
				<?php endforeach; ?>
				
			</ul><!-- .filter-list -->
		</div><!-- .filter-wrapper -->

		<?php 

	}
	add_action( 'eksell_archive_header_end', 'eksell_the_archive_filter' );
endif;