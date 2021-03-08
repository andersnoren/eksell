<?php


/* ------------------------------------------------------------------------------------------------
   CUSTOM LOGO OUTPUT
   Output the logo, reflecting the settings for the retina logo and the dark mode logo.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_custom_logo' ) ) :
	function eksell_the_custom_logo() {

		echo esc_html( eksell_get_custom_logo() );

	}
endif;

if ( ! function_exists( 'eksell_get_custom_logo' ) ) :
	function eksell_get_custom_logo() {

		$has_logo = false;

		// Get the logo, the dark mode logo, and the retina logo setting.
		$logo_id 		= get_theme_mod( 'custom_logo', null );
		$logo_dark_id 	= get_theme_mod( 'eksell_dark_mode_logo', null );
		$retina_logo 	= get_theme_mod( 'eksell_retina_logo', false );

		if ( ! $logo_id ) return;

		// Build an array containing the regular and the dark mode logo, if set.
		$logos = array();
		if ( $logo_id ) $logos['regular'] = $logo_id;
		if ( $logo_dark_id ) $logos['dark-mode'] = $logo_dark_id;

		// The regular logo is required for output.
		if ( ! isset( $logos['regular'] ) ) return;

		// If they are set to the same image, unset the dark modo logo.
		if ( isset( $logos['dark-mode'] ) && $logos['dark-mode'] == $logos['regular'] ) {
			unset( $logos['dark-mode'] );
		}

		// Record our output.
		ob_start();

		?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="custom-logo-link custom-logo">
			<?php 

			// Loop over the (up to) two logos.
			foreach ( $logos as $slug => $logo_id ) : 

				$logo = wp_get_attachment_image_src( $logo_id, 'full' );

				if ( ! $logo ) continue;
				$has_logo = true;

				// For clarity.
				$logo_url 		= $logo[0];
				$logo_width 	= $logo[1];
				$logo_height 	= $logo[2];

				// Get the meta value for the alt field.
				$logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', TRUE );

				// If the retina logo setting is active, reduce the width and height by half.
				if ( $retina_logo ) {
					$logo_width 	= floor( $logo_width / 2 );
					$logo_height 	= floor( $logo_height / 2 );
				}
			
				?>

				<img class="logo-<?php echo $slug; ?>" src="<?php echo esc_url( $logo_url ); ?>" width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>" style="height: <?php echo esc_attr( $logo_height ); ?>px;"<?php if ( $logo_alt ) echo ' alt="' . esc_attr( $logo_alt ) . '"'; ?> />

				<?php 
			endforeach; 
			?>
		</a>

		<?php

		// Return our output, if there's a logo to output.
		return $has_logo ? ob_get_clean() : '';

	}
endif;


/* ---------------------------------------------------------------------------------------------
   OUTPUT AND RETURN FALLBACK IMAGE
   Functions for getting and outputting the fallback image – either the default one 
   (with one version for dark mode, and one for regular mode), or the user set one.
   --------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_the_fallback_image' ) ) :
	function eksell_the_fallback_image() {

		echo eksell_get_fallback_image();

	}
endif;

if ( ! function_exists( 'eksell_get_fallback_image' ) ) :
	function eksell_get_fallback_image() {

		// If a valid fallback image is set in the Customizer, return the markup for it.
		$fallback_image_id = get_theme_mod( 'eksell_fallback_image' );

		if ( $fallback_image_id ) {
			$fallback_image = wp_get_attachment_image( $fallback_image_id, 'full' );
			if ( $fallback_image ) return $fallback_image;
		}

		// If not, return the default fallback image.
		$fallback_image_url = get_template_directory_uri() . '/assets/images/default-fallback-image.png';
		$fallback_image = '<img src="' . esc_attr( $fallback_image_url ) . '" class="fallback-featured-image fallback-image-regular" loading="lazy" />';

		// If dark mode is enabled, return the dark mode fallback image as well, so it can be set to visible in CSS.
		if ( get_theme_mod( 'eksell_enable_dark_mode_palette', false ) ) {
			$fallback_image_dark_mode_url = get_template_directory_uri() . '/assets/images/default-fallback-image-dark-mode.png';
			$fallback_image .= '<img src="' . esc_attr( $fallback_image_dark_mode_url ) . '" class="fallback-featured-image fallback-image-dark-mode" loading="lazy" />';
		}

		return $fallback_image;

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


/* ------------------------------------------------------------------------------------------------
   GET POST GRID COLUMN CLASSES
   Gets the number of columns set in the Customizer, and returns the classes that should be used to
   set the post grid to the number of columns specified.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_get_archive_columns_classes' ) ) :
	function eksell_get_archive_columns_classes() {

		$classes = array();

		// Get the array holding all of the columns options.
		$archive_columns_options = Eksell_Customizer::get_archive_columns_options();

		// Loop over the array, and class value of each one to the array.
		foreach ( $archive_columns_options as $setting_name => $setting_data ) {

			// Get the value of the setting, or the default if none is set.
			$value = get_theme_mod( $setting_name, $setting_data['default'] );

			// Convert the number in the setting (1/2/3/4) to the class names used in our twelve column grid.
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

		// Make the column classes filterable before returning them.
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
		
		// Whether to display the filter (defaults to on home or on Jetpack Portfolio CPT archive, and when set to active in the Customizer).
		// The value can be filtered with eksell_show_home_filter.
		$show_home_filter = apply_filters( 'eksell_show_home_filter', ( is_home() || is_post_type_archive( 'jetpack-portfolio' ) ) && $paged == 0 && get_theme_mod( 'eksell_show_home_filter', true ) );
		
		if ( ! $show_home_filter ) return;

		$filter_taxonomy = is_post_type_archive( 'jetpack-portfolio' ) ? 'jetpack-portfolio-type' : 'category';

		// Use the eksell_home_filter_get_terms_args filter to modify which taxonomy is used for the filtration.
		$terms = get_terms( apply_filters( 'eksell_home_filter_get_terms_args', array(
			'depth'		=> 1,
			'taxonomy'	=> $filter_taxonomy,
		) ) );

		if ( ! $terms ) return;

		$home_url = '';
		$post_type = '';

		// Determine the correct home URL to link to.
		if ( is_home() ) {
			$home_url = home_url();
			$post_type = 'post';
		} elseif ( is_post_type_archive() ) {
			$post_type = get_post_type();
			$home_url = get_post_type_archive_link( $post_type );
		}

		// Make the home_url filterable. If you change the taxonomy of the filtration with `eksell_home_filter_get_terms_args`,
		// you'll probably want to filter this to make sure it points to the correct URL as well.
		$home_url = apply_filters( 'eksell_filter_home_url', $home_url );
	
		?>

		<div class="filter-wrapper i-a a-fade-up a-del-200">
			<ul class="filter-list reset-list-style">

				<?php if ( $home_url ) : ?>
					<li><a class="filter-link active" data-filter-post-type="<?php echo esc_attr( $post_type ); ?>" href="<?php echo esc_url( $home_url ); ?>"><?php esc_html_e( 'Show All', 'eksell' ); ?></a></li>
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
