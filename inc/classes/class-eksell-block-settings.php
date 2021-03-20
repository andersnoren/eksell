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

			// Shared: No Vertical Margin.
			$no_vertical_margin_blocks = array( 
				'core/columns', 
				'core/cover', 
				'core/embed', 
				'core/group', 
				'core/heading', 
				'core/image', 
				'core/paragraph' 
			);

			foreach ( $no_vertical_margin_blocks as $block ) {
				register_block_style( $block, array(
					'label' => esc_html__( 'No Vertical Margin', 'eksell' ),
					'name'  => 'no-vertical-margin',
				) );
			}

			// Separator: Left aligned.
			register_block_style( 'core/separator', array(
					'label' => esc_html__( 'Left Aligned', 'eksell' ),
					'name'  => 'left-aligned',
				)
			);

			// Separator: Right aligned.
			register_block_style( 'core/separator', array(
					'label' => esc_html__( 'Right Aligned', 'eksell' ),
					'name'  => 'right-aligned',
				)
			);

			// Social icons: Logos Only Monochrome.
			register_block_style( 'core/social-links', array(
					'label' => esc_html__( 'Logos Only Monochrome', 'eksell' ),
					'name'  => 'logos-only-monochrome',
				)
			);

		}


		/*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK PATTERNS
		--------------------------------------------------------------------------------------------------- */

		public static function register_block_patterns() {

			// Register the Eksell block pattern category.
			if ( function_exists( 'register_block_pattern_category' ) ) {
				register_block_pattern_category( 'eksell', array( 
					'label' => esc_html__( 'Eksell', 'eksell' ) 
				) );
			}
			
			// Register block patterns.
			// The block patterns can be modified with the eksell_block_patterns filter.
			$block_patterns = apply_filters( 'eksell_block_patterns', array(
				'eksell/big-call-to-action' => array(
					'title'			=> esc_html__( 'Big call to action', 'eksell' ),
					'description'	=> esc_html__( 'A full-width section with an image, a heading, text and buttons.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/big-call-to-action.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array( 'cta' ),
					'viewportWidth'	=> 1440,
				),
				'eksell/call-to-action' => array(
					'title'			=> esc_html__( 'Call to action', 'eksell' ),
					'description'	=> esc_html__( 'A large text paragraph followed by buttons.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/call-to-action.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array( 'cta' ),
					'viewportWidth'	=> 822,
				),
				'eksell/columns-featured-items' => array(
					'title'			=> esc_html__( 'Three columns with featured items', 'eksell' ),
					'description'	=> esc_html__( 'A row of columns with each item having an image, a title, a paragraph of text and buttons.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/columns-featured-items.php' ),
					'categories'	=> array( 'columns', 'eksell' ),
					'keywords'		=> array( 'row', 'column', 'grid' ),
					'viewportWidth'	=> 1440,
				),
				'eksell/columns-heading-image-text' => array(
					'title'			=> esc_html__( 'Three columns with headings, images, and text', 'eksell' ),
					'description'	=> esc_html__( 'A full-width section with three columns containing a heading, an image, and text.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/columns-heading-image-text.php' ),
					'categories'	=> array( 'columns', 'eksell', 'header' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/columns-image-text' => array(
					'title'			=> esc_html__( 'Two columns with images and text', 'eksell' ),
					'description'	=> esc_html__( 'Two columns containing an image and paragraphs of text.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/columns-image-text.php' ),
					'categories'	=> array( 'columns', 'eksell', 'text' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/columns-image-text-image' => array(
					'title'			=> esc_html__( 'Three columns with images and text', 'eksell' ),
					'description'	=> esc_html__( 'Three columns containing an image, a centered paragraph of large text, and another image.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/columns-image-text-image.php' ),
					'categories'	=> array( 'columns', 'eksell' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/columns-text-image-pullquote' => array(
					'title'			=> esc_html__( 'Three columns with text, an image, and a pullquote', 'eksell' ),
					'description'	=> esc_html__( 'Three columns containing paragraphs of text, an image, and a pullquote.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/columns-text-image-pullquote.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/columns-text-pullquote' => array(
					'title'			=> esc_html__( 'Two columns with text and a pullquote', 'eksell' ),
					'description'	=> esc_html__( 'Two columns containing paragraphs of text and a pullquote.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/columns-text-pullquote.php' ),
					'categories'	=> array( 'columns', 'eksell', 'text' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/contact-details' => array(
					'title'			=> esc_html__( 'Contact details', 'eksell' ),
					'description'	=> esc_html__( 'Three columns with contact details and social media links.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/contact-details.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/cover-header' => array(
					'title'			=> esc_html__( 'Cover header', 'eksell' ),
					'description'	=> esc_html__( 'Cover block with title, text, and a separator.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/cover-header.php' ),
					'categories'	=> array( 'eksell', 'header' ),
					'keywords'		=> array( 'hero' ),
					'viewportWidth'	=> 1440,
				),
				'eksell/stacked-full-groups' => array(
					'title'			=> esc_html__( 'Stacked color groups with text', 'eksell' ),
					'description'	=> esc_html__( 'Three stacked groups with solid background color, each with two columns containing a heading and text.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/stacked-full-groups.php' ),
					'categories'	=> array( 'eksell' ),
					'keywords'		=> array(),
					'viewportWidth'	=> 1440,
				),
				'eksell/stacked-galleries' => array(
					'title'			=> esc_html__( 'Three stacked galleries', 'eksell' ),
					'description'	=> esc_html__( 'Three stacked galleries with the same horizontal and vertical margin between each gallery item.', 'eksell' ),
					'content'		=> Eksell_Block_Settings::get_block_pattern_markup( 'inc/block-patterns/stacked-galleries.php' ),
					'categories'	=> array( 'eksell', 'gallery' ),
					'keywords'		=> array( 'gallery' ),
					'viewportWidth'	=> 822,
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

			// Define shared block pattern placeholder content, to minimize cluttering up of the polyglot list.
			$lorem_short_1 = esc_html_x( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'Block pattern demo content', 'eksell' );
			$lorem_short_2 = esc_html_x( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.', 'Block pattern demo content', 'eksell' );

			$lorem_long_1 = $lorem_short_1 . ' ' . $lorem_short_2;
			$lorem_long_2 =  esc_html_x( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 'Block pattern demo content', 'eksell' );
			$lorem_long_3 =  esc_html_x( 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', 'Block pattern demo content', 'eksell' );

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
