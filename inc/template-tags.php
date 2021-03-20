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
		$fallback_image = '<img src="' . esc_attr( $fallback_image_url ) . '" class="fallback-featured-image fallback-image-regular" />';

		// If dark mode is enabled, return the dark mode fallback image as well, so it can be set to visible in CSS.
		if ( get_theme_mod( 'eksell_enable_dark_mode_palette', false ) ) {
			$fallback_image_dark_mode_url = get_template_directory_uri() . '/assets/images/default-fallback-image-dark-mode.png';
			$fallback_image .= '<img src="' . esc_attr( $fallback_image_dark_mode_url ) . '" class="fallback-featured-image fallback-image-dark-mode" />';
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
		
		// Check if we're showing the filter
		if ( ! eksell_show_home_filter() ) return;

		$filter_taxonomy = is_post_type_archive( 'jetpack-portfolio' ) ? 'jetpack-portfolio-type' : 'category';

		// Use the eksell_home_filter_get_terms_args filter to modify which taxonomy is used for the filtration.
		$terms = get_terms( apply_filters( 'eksell_home_filter_get_terms_args', array(
			'depth'		=> 1,
			'taxonomy'	=> $filter_taxonomy,
		) ) );

		if ( ! $terms ) return;

		$home_url 	= '';
		$post_type 	= '';

		// Determine the correct home URL to link to.
		if ( is_home() ) {
			$post_type 	= 'post';
			$home_url 	= home_url();
		} elseif ( is_post_type_archive() ) {
			$post_type 	= get_post_type();
			$home_url 	= get_post_type_archive_link( $post_type );
		}

		// Make the home URL filterable. If you change the taxonomy of the filtration with `eksell_home_filter_get_terms_args`,
		// you might want to filter this to make sure it points to the correct URL as well (or maybe remove it altogether).
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


/*	-----------------------------------------------------------------------------------------------
	SHOW HOME FILTER?
	Helper function for determining whether to show the home filter. Defaults to on home or on 
	Jetpack Portfolio CPT archive, and when set to active in the Customizer. The value can be 
	filtered with eksell_show_home_filter.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_show_home_filter' ) ) :
	function eksell_show_home_filter() {

		global $paged;

		return apply_filters( 'eksell_show_home_filter', ( is_home() || is_post_type_archive( 'jetpack-portfolio' ) ) && $paged == 0 && get_theme_mod( 'eksell_show_home_filter', true ) );

	}
endif;


/* ------------------------------------------------------------------------------------------------
   OUTPUT & GET POST META
   If it's a single post, output the post meta values specified in the Customizer settings.

   @param	$post_id int		The ID of the post we're outputting post meta for.
--------------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'eksell_maybe_output_post_meta' ) ) :
	function eksell_maybe_output_post_meta() {

		// Escaped in eksell_get_post_meta().
		echo eksell_get_post_meta( get_queried_object_id() );

	}
	add_action( 'eksell_preview_end', 'eksell_maybe_output_post_meta' );
endif;

if ( ! function_exists( 'eksell_get_post_meta' ) ) :
	function eksell_get_post_meta( $post_id ) {

		// Get our post type.
		$post_type = get_post_type( $post_id );

		// Get the list of the post types that support post meta, and only proceed if the current post type is supported.
		$post_type_has_post_meta 	= false;
		$post_types_with_post_meta 	= Eksell_Customizer::get_post_types_with_post_meta();

		foreach ( $post_types_with_post_meta as $post_type_with_post_meta => $data ) {
			if ( $post_type == $post_type_with_post_meta ) {
				$post_type_has_post_meta = true;
				break;
			}
		}

		if ( ! $post_type_has_post_meta ) return;

		// Get the default post meta for this post type.
		$post_meta_default = isset( $post_types_with_post_meta[$post_type]['default'] ) ? $post_types_with_post_meta[$post_type]['default'] : array();

		// Get the post meta for this post type from the Customizer setting.
		$post_meta = get_theme_mod( 'eksell_post_meta_' . $post_type, $post_meta_default );

		// If we have post meta, sort it.
		if ( $post_meta && ! in_array( 'empty', $post_meta ) ) {

			// Set the output order of the post meta.
			$post_meta_order = array( 'date', 'author', 'categories', 'tags', 'comments', 'edit-link' );

			/**
			 * Filter for the output order of the post meta.
			 * 
			 * Allows child themes to modify the output order of the post meta. Any post meta items 
			 * added with the eksell_post_meta_items filter will not be affected by this sorting, 
			 * so you'll have to provide your own sorting when you filter the post meta items.
			 * 
			 * @param array 	$post_meta_order 	Order of the post meta items.
			 * @param int 		$post_id 			ID of the post.
			 */
			$post_meta_order = apply_filters( 'eksell_post_meta_order', $post_meta_order, $post_id );

			// Store any custom post meta items in a separate array, so we can append them after sorting.
			$post_meta_custom = array_diff( $post_meta, $post_meta_order );

			// Loop over the intended order, and sort $post_meta_reordered accordingly.
			$post_meta_reordered = array();
			foreach ( $post_meta_order as $i => $post_meta_name ) {
				$original_i = array_search( $post_meta_name, $post_meta );
				if ( $original_i === false ) continue;
				$post_meta_reordered[$i] = $post_meta[$original_i];
			}

			// Reassign the reordered post meta with custom post meta items appended, and update the indexes.
			$post_meta = array_values( array_merge( $post_meta_reordered, $post_meta_custom ) );

		}

		/**
		 * Filter the post meta.
		 * 
		 * Allows child themes to add, remove and modify post meta items.
		 * 
		 * @param array 	$post_meta 	Post meta items to include in the post meta.
		 * @param int 		$post_id 	ID of the post.
		 */

		$post_meta = apply_filters( 'eksell_post_meta_items', $post_meta, $post_id );

		// If the post meta setting has the value 'empty' at this point, it's explicitly empty and the default post meta shouldn't be output.
		if ( ! $post_meta || ( $post_meta && in_array( 'empty', $post_meta ) ) ) return;

		/**
		 * Filter for the post meta CSS classes.
		 * 
		 * Allows child themes to filter the classes on the post meta wrapper elements.
		 * 
		 * @param array 	$classes 	CSS classes of the element.
		 * @param int		$post_id 	ID of the post.
		 * @param array		$post_meta 	Post meta items set for the post type.
		 */

		$post_meta_wrapper_classes 	= apply_filters( 'eksell_post_meta_wrapper_classes', array( 'post-meta-wrapper' ), $post_id, $post_meta );
		$post_meta_classes 			= apply_filters( 'eksell_post_meta_classes', array( 'post-meta' ), $post_id, $post_meta );

		// Convert the class arrays to strings for output.
		$post_meta_wrapper_classes_str 	= implode( ' ', $post_meta_wrapper_classes );
		$post_meta_classes_str 			= implode( ' ', $post_meta_classes );

		// Enable the $eksell_has_meta variable to be modified in actions.
		global $eksell_has_meta;

		// Default it to false, to make sure we don't output an empty container.
		$eksell_has_meta = false;

		global $post;
		$post = get_post( $post_id );
		setup_postdata( $post );

		// Record out output.
		ob_start();
		?>

		<div class="<?php echo esc_attr( $post_meta_wrapper_classes_str ); ?>">
			<ul class="<?php echo esc_attr( $post_meta_classes_str ); ?>">

				<?php

				foreach ( $post_meta as $post_meta_item ) :

					switch ( $post_meta_item ) {

						case 'date' : 
							$eksell_has_meta = true;
							?>
							<li class="date">
								<a href="<?php the_permalink(); ?>">
									<?php the_time( get_option( 'date_format' ) ); ?>
								</a>
							</li>
							<?php
							break;

						case 'author' : 
							$eksell_has_meta = true;
							?>
							<li class="author">
								<?php 
								// Translators: %s = the author name
								printf( esc_html_x( 'By %s', '%s = author name', 'eksell' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a>' ); ?>
							</li>
							<?php
							break;

						case 'categories' : 

							// Determine which taxonomy to use for categories. This defaults to jetpack-portfolio-type for the jetpack-portfolio post type, and to categories for posts.
							$category_taxonomy = ( $post_type == 'jetpack-portfolio' ) ? 'jetpack-portfolio-type' : 'category';
							$category_taxonomy = apply_filters( 'eksell_post_meta_category_taxonomy', $category_taxonomy, $post_id );

							if ( ! has_term( '', $category_taxonomy, $post_id ) ) break;
							$eksell_has_meta = true;
							?>
							<li class="categories">
								<?php the_terms( $post_id, $category_taxonomy, esc_html__( 'In', 'eksell' ) . ' ', ', ' ); ?>
							</li>
							<?php
							break;

						case 'comments' : 
							if ( post_password_required() || ! comments_open() || ! get_comments_number() ) break;
							$eksell_has_meta = true;
							?>
							<li class="comments">
								<?php comments_popup_link(); ?>
							</li>
							<?php
							break;

						case 'edit-link' : 
							if ( ! current_user_can( 'edit_post', $post_id ) ) break;
							$eksell_has_meta = true;
							?>
							<li class="edit">
								<a href="<?php echo esc_url( get_edit_post_link() ); ?>">
									<?php esc_html_e( 'Edit', 'eksell' ); ?>
								</a>
							</li>
							<?php
							break;

						case 'tags' : 

							// Determine which taxonomy to use for tags. This defaults to jetpack-portfolio-tag for the jetpack-portfolio post type, and to post_tag for posts.
							$tag_taxonomy = ( $post_type == 'jetpack-portfolio' ) ? 'jetpack-portfolio-tag' : 'post_tag';
							$tag_taxonomy = apply_filters( 'eksell_post_meta_tag_taxonomy', $tag_taxonomy, $post_id );

							if ( ! has_term( '', $tag_taxonomy, $post_id ) ) break;
							$eksell_has_meta = true;
							?>
							<li class="tags">
								<?php the_terms( $post_id, $tag_taxonomy, esc_html__( 'Tagged', 'eksell' ) . ' ', ', ' ); ?>
							</li>
							<?php
							break;
						
						default : 

							/**
							 * Action for handling of custom post meta items.
							 * 
							 * This action gets called if the post meta looped over doesn't match 
							 * any of the types supported out of the box in Eksell. If you've 
							 * added a custom post meta type in a child theme, you can output it 
							 * here by hooking into eksell_post_meta_[your-post-meta-key].
							 * 
							 * Note: If you add any output to this action, make sure you include 
							 * $eksell_has_meta as a global variable and set it to true. This will 
							 * tell eksell_get_post_meta() that there's post meta to output.
							 * 
							 * @param int 	$post_id 	ID of the post.
							 */

							do_action( 'eksell_post_meta_' . $post_meta_item, $post_id );

					} // End switch

				endforeach;

				?>

			</ul>
		</div>

		<?php

		wp_reset_postdata();

		// Get the recorded output.
		$meta_output = ob_get_clean();

		// If there is post meta, return it.
		return ( $eksell_has_meta && $meta_output ) ? $meta_output : '';

	}
endif;