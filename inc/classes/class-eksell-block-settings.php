<?php

/* ---------------------------------------------------------------------------------------------
   BLOCK SETTINGS CLASS
   Handles block styles and block patterns.
------------------------------------------------------------------------------------------------ */

if ( ! class_exists( 'Eksell_Block_Settings' ) ) :
	class Eksell_Block_Settings {

		/*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK STYLES
		--------------------------------------------------------------------------------------------------- */

		public static function register_block_styles() {

			if ( ! function_exists( 'register_block_style' ) ) return;

			// Shared: No vertical margin
			$no_vertical_margin_blocks = array( 'core/columns', 'core/cover', 'core/embed', 'core/cover', 'core/group', 'core/heading', 'core/image', 'core/paragraph' );
			foreach ( $no_vertical_margin_blocks as $block ) {
				
				register_block_style( $block, array(
					'label' => esc_html__( 'No Vertical Margin', 'eksell' ),
					'name'  => 'no-vertical-margin',
				) );

			}

			// Social icons: Inherited color.
			register_block_style( 'core/social-links', array(
					'label' => esc_html__( 'Logos Only Monochrome', 'eksell' ),
					'name'  => 'logos-only-monochrome',
				)
			);

		}


		/*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK PATTERNS AND CATEGORIES
		--------------------------------------------------------------------------------------------------- */

		public static function register_block_patterns() {

			// Register the Eksell block pattern category.
			if ( function_exists( 'register_block_pattern_category' ) ) {
				register_block_pattern_category( 'eksell', array( 
					'label' => __( 'Eksell', 'eksell' ) 
				) );
			}
			
			// Register block patterns.
			// The block patterns can be modified with the eksell_block_patterns filter.
			$block_patterns = apply_filters( 'eksell_block_patterns', array(
				'eksell/call-to-action' => array(
					'title'			=> __( 'Call to Action', 'eksell' ),
					'description'	=> __( 'A large text paragraph followed by buttons.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/call-to-action.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array( 'cta', 'buttons' ),
					'viewportWidth'	=> 822,
				),
				'eksell/contact-details' => array(
					'title'			=> __( 'Contact Details', 'eksell' ),
					'description'	=> __( 'Three columns with contact details and social media links.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/contact-details.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/cover-header' => array(
					'title'			=> __( 'Cover Header', 'eksell' ),
					'description'	=> __( 'Cover block with title, text, and a separator.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/cover-header.php' ),
					'categories'	=> array( 'eksell', 'header' ),
					'keywords'		=> array( 'hero' ),
					'viewportWidth'	=> 1440,
				),
				'eksell/featured-items' => array(
					'title'			=> __( 'Featured Items', 'eksell' ),
					'description'	=> __( 'Row of columns with each item having an image, a title, a paragraph of text and buttons.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/featured-items.php' ),
					'categories'	=> array( 'eksell', 'columns' ),
					'keywords'		=> array( 'row', 'column', 'grid' ),
					'viewportWidth'	=> 1440,
				),
				'eksell/stacked-full-groups' => array(
					'title'			=> __( 'Stacked Full Groups', 'eksell' ),
					'description'	=> __( 'Three stacked groups with solid background color, each with two columns containing a heading and text.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/stacked-full-groups.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
			) );

			if ( $block_patterns && function_exists( 'register_block_pattern' ) ) {
				foreach ( $block_patterns as $name => $data ) {
					if ( isset( $data['content'] ) && $data['content'] ) {
						register_block_pattern( $name, $data );
					}
				}
			}

		}


		/*	-----------------------------------------------------------------------------------------------
			GET BLOCK PATTERN
			Returns the markup of the block pattern at the specified theme path.
		--------------------------------------------------------------------------------------------------- */

		public static function get_block_pattern_markup( $path ) {

			if ( ! locate_template( $path ) ) return;

			ob_start();
			include( locate_template( $path ) );
			return ob_get_clean();

		}

	}

	// Register block styles.
	add_action( 'init', array( 'Eksell_Block_Settings', 'register_block_styles' ) );

	// Register block patterns.
	add_action( 'init', array( 'Eksell_Block_Settings', 'register_block_patterns' ) );

endif;
