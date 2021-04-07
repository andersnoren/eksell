=== Eksell ===
Contributors: Anlino
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=anders%40andersnoren%2ese&lc=US&item_name=Free%20WordPress%20Themes%20from%20Anders%20Noren&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Requires at least: 4.5
Requires PHP: 5.4
Tested up to: 5.7
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


== Installation ==

1. Upload the theme
2. Activate the theme


== Browser Support ==

Eksell supports all modern browsers. Due to the lack of support for CSS variables in older browsers (including Internet Explorer 11 and old versions of Microsoft Edge), some visual jank is to be expected when viewing the theme in those browsers.


== How to Use the No Title Template ==

The Only Content Template hides all elements in the content area of Eksell except the block editor content, allowing you to create completely custom layouts. The site header, aside (with the navigation toggle) and footer are still displayed.

1. Go to Pages → Add New or edit an existing page.
2. In the righthand sidebar, expand the "Page Attributes" dropdown, click the "Template" dropdown, and select "No Title Template" from the list.
3. Add the block editor content you want to include on the page.
4. When you're done, click the "Publish" or "Update" button to publish your changes.


== How to Use the Blank Canvas Template ==

The Blank Canvas template hides everything on the page except the block editor content, including the site header, aside (with the navigation toggle), footer, and modals.

1. Go to Pages → Add New or edit an existing page.
2. In the righthand sidebar, expand the "Page Attributes" dropdown, click the "Template" dropdown, and select "Blank Canvas Template" from the list.
3. Add the block editor content you want to include on the page.
4. When you're done, click the "Publish" or "Update" button to publish your changes.


== Block Styles ==

Block styles allow you to set a specific style on a block in the block editor. These instructions are for the custom block styles included with Eksell. 

You can select a block style in the Block → Styles tab in the right toolbar when you have a block selected in the block editor.

=== Shared: No Vertical Margin ===

The No Vertical Margin block style removes all vertical margins from the block the style is applied to. The style is available for the Columns, Cover, Embed, Group, Heading, Image, and Paragraph blocks. You can also add the `.is-style-no-vertical-margin` CSS class to any block in the block editor to remove its vertical margins. You can add the class by selecting a block in the block editor, clicking the Block → Advanced tab in the right toolbar, and pasting "is-style-no-vertical-margin" in the field labeled "Additional CSS Classes". If the field already has a value, separate the existing value and the new class with a space.

=== Social: Logos Only Monochrome ===

Has the same styling as the Logos Only social style, but with the icon color inherited from the text color of the parent block. If there is no parent block with a text color set, the icons have the "Primary Color" set in the color settings in the Customizer.


== Block Patterns ==

Eksell includes a number of block patterns which can be used to quickly add combinations of blocks to your posts and pages. To add a block pattern, click the "Plus" icon in the top left of the block editor, select the "Patterns" tab, select "Eksell" in the dropdown, and click the pattern you want to add.

The patterns included in Eksell are:

* Call to Action: A large text paragraph followed by buttons.
* Contact Details: Three columns with contact details and social media links.
* Cover Header: Cover block with title, text, and a separator.
* Featured Items: Row of columns with each item having an image, a title, a paragraph of text and buttons.
* Stacked Full Groups: Three stacked groups with solid background color, each with two columns containing a heading and text.


== Change Colors ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Colors" panel.
4. Select the colors you want to use, and click the blue "Publish" button to save your changes.


== Set Dark Mode Colors ==

Eksell includes supports for dark mode, in which browsers and operating system displays websites with light text on a dark background. It's enabled by default, and allows you to specify a separate color palette for visitors with dark mode enabled.

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Colors" panel.
4. Make sure the "Enable Dark Mode Color Palette" checkbox is checked. When it is, a separate list of dark mode color settings should be visible beneath the checkbox.
4. Select the dark mode colors you want to use, and click the blue "Publish" button to save your changes.


== Change Fonts ==

Eksell doesn't include controls for changing fonts, but the theme is built to be compatible with third-party font plugins like Easy Google Fonts.


== Disable Animations ==

By default, Eksell will animate some elements in the theme when they first become visible. These are automatically disabled for visitors who have set their OS and/or browser to reduce non-essential motion on websites, but you can also disable them for all visitors on the site through the Customizer.

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "General Options" panel.
4. Check the "Disable Animations" checkbox, and click the blue "Publish" button to save your changes.


== Disable Sticky Header ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Site Header" panel.
4. Uncheck the "Enable Sticky Header" checkbox, and click the blue "Publish" button to save your changes.


== Disable Search ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Site Header" panel.
4. Uncheck the "Enable Search" checkbox, and click the blue "Publish" button to save your changes.


== Add Intro Text to the Front Page ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Post Archive" panel.
4. Add the text you want to display of the front page to the "Intro Text" textarea.
5. Select the type you want to use, and click the blue "Publish" button to save your changes.


== Disable the Archive Filter ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Post Archive" panel.
4. Uncheck the "Show Filter" checkbox.
5. Select the type you want to use, and click the blue "Publish" button to save your changes.


== Change Pagination Type ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Post Archive" panel.
4. There are three options for the pagination:
	a. "Load more button": Displays a button that, when clicked, loads more posts without a hard reload.
	b. "Load more on scroll": When the visitor has reached the bottom of the page, more posts are loaded without a hard reload.
	c. "Links": Displays links that, when clicked, takes the visitor to then next or previous archive page with a hard reload.
5. Select the type you want to use, and click the blue "Publish" button to save your changes.


== Change the Number of Columns in the Post Archive ==

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Post Archive" panel.
4. Here, you'll find five settings for how many columns to display at different screen sizes. They are:
	a. Columns on Mobile (Screen width: 0px - 700px)
	b. Columns on Tablet Portrait (Screen width: 700px - 1000px)
	c. Columns on Tablet Landscape (Screen width: 1000px - 1200px)
	d. Columns on Desktop (Screen width: 1200px - 1600px)
	e. Columns on Large Desktop (Screen width: > 1600px)
5. Select the number of columns you want to use at each screen size, and click the blue "Publish" button to save your changes.


== Change Fallback Image ==

The fallback image is used for posts that are missing a featured image. By default, a fallback image with a generic image icon is used, but you can select any image in your media library to be used as a fallback image instead.

1. Log in to the administration panel of your site.
2. Go to Appearance → Customize.
3. Click the "Theme Options" panel, and then the "Images" panel.
4. Click the "Select Image" field beneath the "Fallback Image", and select the image you want to use in your media library.
5. Click the blue "Publish" button to save your changes.


== Licenses ==

Eksell is derived from the Chaplin theme, Copyright (c) 2019-2021 Anders Norén.
Chaplin is distributed under the terms of the GNU GPL version 2.0.

Icons in the "UI" group by Anders Norén
License: Creative Commons Zero (CC0), https://creativecommons.org/publicdomain/zero/1.0/

Placeholder images by Anders Norén
License: Creative Commons Zero (CC0), https://creativecommons.org/publicdomain/zero/1.0/

Eksell bundles the following third-party resources:

Images
Used in the featured images in screenshot.png
Art by Wassily Kandinsky 1866-1944. Public domain.
https://www.wikiart.org/en/wassily-kandinsky/picture-xvi-the-great-gate-of-kiev-stage-set-for-mussorgsky-s-pictures-at-an-exhibition-in-1928
https://www.wikiart.org/en/wassily-kandinsky/park-of-st-cloud-with-horseman-1906
https://www.wikiart.org/en/wassily-kandinsky/munich-schwabing-with-the-church-of-st-ursula-1908
https://www.wikiart.org/en/wassily-kandinsky/on-white-ii-1923
https://www.wikiart.org/en/wassily-kandinsky/composition-vi-1913
https://www.wikiart.org/en/wassily-kandinsky/kochel-waterfall-i
https://www.wikiart.org/en/wassily-kandinsky/composition-iv-1911

Public Sans font
License: SIL Open Font License, 1.1, https://opensource.org/licenses/OFL-1.1
Source: https://fonts.google.com/specimen/Public+Sans/

css-vars-ponyfill
License: MIT License, https://opensource.org/licenses/MIT
Source: https://github.com/jhildenbiddle/css-vars-ponyfill

Dot Pulse Loading Animation
License: MIT license, https://opensource.org/licenses/MIT
Source: https://nzbin.github.io/three-dots/

Code from Twenty Twenty-One
Copyright (c) 2020-2021 WordPress.org
License: GPLv2
Source: https://wordpress.org/themes/twentytwentyone/
Included as part of:
- Eksell_SVG_Icons class
- eksell_nav_menu_social_icons()
- searchform.php
- inc/block-patterns/contact-details.php


== Changelog ==

Version 1.1.7 (2021-04-07)
-------------------------
- Set the #site-content element to overflow: hidden to prevent issues with content overflow and viewport units in browsers on Windows 10 (thanks, @lucienlapidus).

Version 1.1.6 (2021-03-26)
-------------------------
- Fixed the "greater than" character (>) closing elements on some server configurations when used in HTML attributes.

Version 1.1.5 (2021-03-24)
-------------------------
- Block editor styles: Fixed misalignment issue causing the Latest Posts block to have excessive right margin when set to no alignment.
- Block editor styles: Set the Latest Posts block featured images to fill available width, to match the front-end.
- Latest posts block: Don't make the featured image fill available width if the images are set to centered alignment.
- Latest posts block: Updated CSS targeting to reduce risk of breaking things down the road.
- Latest posts block: Remove top margin from the items in the first row of the grid.
- Latest posts block: Fixed margin of grid items when set to single column.
- Screenshot: Updated the site title and description, and changed the image format from JPG to PNG to reduce file size (from 290 KB to 147 KB).
- Added the new --eksell-headings-weight CSS variable, to make it easier to modify headings weight in child themes and custom CSS.
- JS: Camelcased the $eksellWin global variable, to match $eksellDoc.
- Increased priority of the function updating the no-js html class, so it's called as early as possible.
- Unset CSS animations triggered in JavaScript within a noscript element, to prevent the flash of unstyled animation elements that occurs when using the .no-js class.
- Added a home link to the site title when displaying both a custom logo and the site title.

Version 1.1.4 (2021-03-24)
-------------------------
- A11y: Added role="button" to all elements with the aria-pressed attribute, to make sure the aria-pressed attribute is supported for those elements.
- A11y: Removed the aria-pressed attribute from the menu-modal-cover-untoggle element (the element catching clicks outside the modal which closes the modal when clicked), since that element isn't visible to screen readers.
- Set the row with the social icons and search toggle in the header to not line break.
- Set post thumbnails of the image/gif mime type to always use the full image size, to include animations.

Version 1.1.3 (2021-03-23)
-------------------------
- Adjusted the size and spacing of the elements in the footer to allow for more content without line breaks.
– Category filter: Fade out the pagination while updating the post grid.
- Slight improvements to the styling of Jetpack Comments.
- Fixed single post navigation images not always filling the available horizontal space.
- Fixed incorrect order of arguments passed to the_post_thumbnail() in preview.php, resulting in the wrong image size being used.
- Removed default-fallback-image-tall-dark-mode.png and default-fallback-image-square-dark-mode.png, since they weren't being used.

Version 1.1.2 (2021-03-22)
-------------------------
- Block editor styles: Fixed a section inner width inconsitency with the front end between 1200 - 1600px.
- A11y: Improved the menu modal focus loop to work with more focusable elements, and fixed a loop bug when the search form was the last element in the modal.

Version 1.1.1 (2021-03-21)
-------------------------
- Updated the JS focus loop to only use one event (keydown), and simplified and condensed the code.
- Removed outline: none styles for some elements with clear text decoration changes on focus.
- Adjusted focus styles for the header toggles and header/footer social links.
- Updated focus styles in the search modal.
- Social icons: Resized the feed icon to be more consistent other icons.

Version 1.1.0 (2021-03-20)
-------------------------
- Customizer: Added a setting for which post meta to display for different post types on archive pages, with filterable lists of supported post types (defaults to post and jetpack-portfolio) and supported post meta values.
- Customizer: Added the Eksell_Customize_Control_Checkbox_Multiple class with the multiple checkbox Customizer control, used by the new post meta setting.
- Added output of the post meta setting in chaplin_maybe_output_post_meta(), with an action for outputting custom post meta and filters for modifying the output.
- Removed the inner wrapping link in previews, and added separate links to the featured media and title, in order to support links in post meta and custom preview output.
- Improved handling of line breaks in the header by allowing the header toggles (and social icons) to shrink.
- Removed duplicate function eksell_is_comment_by_post_author(), and made the $comment argument required.
- Replaced all instances of esc_html( _x() ) with esc_html_x().
- Updated readme.txt to mention the new setting for post meta.
- Updated Eksell_SVG_Icons::get_svg() to include the icon name (formatted icon-[name]) as part of the SVG class attribute.
- Added a generic link icon to the UI group, used for social menu items missing a matching SVG.
- WordPress.org theme review updates (thanks, @acosmin):
	- Updated the <link rel="profile" href="//gmpg.org/xfn/11"> in header.php to use // instead of http://.
	- Fixed empty elseif statements in eksell_get_the_archive_title_prefix().
	- Fixed whitespace before the PHP open tag in footer.php.
	- Prefixed variables with global scrope in construct.js, and removed unused global variables.
	- Keyboard navigation:
		- Moved the site aside navigation toggle to be focused before the site title/logo, and updated the focusLoop JS function to account for the new order.
		- Made the menu modal and search modal focus loop backwards and forwards depending on the tabbing direction.
		- Removed removal of outlines from inputs, including the search modal field.
		- Removed removal of outline from the mobile navigation toggle.
		- Updated focus event listener in focusManagement() to listen for a subset of elements, preventing issues with SVGs and SVG children being focusable in Chrome.

Version 1.0.6 (2021-03-19)
-------------------------
- Condensed the circular icons focus style code by using box-shadow instead of a pseudo element.
- Better focus styles for the social icons and header toggles.
- Adjusted the global text-decoration-offet, and fixed text-decoration of the last line of the tallest single post navigation item not being visible.
- Adjusted the vertical margin of separators on desktop, and updated editor styles to match.
- Customizer: Added a setting for disabling Google Fonts.
- Tweaked the width of the separator outside of entry content on desktop.
- Tweaked the top margin of figure captions.
- Block styles: Added "Left aligned" and "Right aligned" styles to the separator block.
- Block editor styles: Updated heading margins to reflect front-end at 700px and up, including headings nested in columns.
- Block editor styles: Updated margin of groups and covers nested inside columns to match front-end.
- Block editor styles: Updated horizontal margin of direct descendants to the Media and Text block to match front-end.
- Block editor styles: Fixed margin issue with the social block.
- Block editor styles: Fixed margin beneath inline-block image resizing element.
- Block editor styles: Compensated bottom margins on buttons block when it's the last child, matching front-end styles.
- Block editor styles: Updated columns structure to match front-end between 600px - 781px.
- Block patterns: Changed the pattern titles to not use capitalised words, to match the Core block patterns.
- Block patterns: Fleshed out and modified the structure of the "Three columns with featured items" pattern.
- Block patterns: Made the "Lorem ipsum" placeholder text translateable (thanks, @williampatton!).
- Block patterns: Updated some block patterns will square or tall placeholder images.
- Block patterns: Added seven new patterns to the theme (thanks for the nudge, Justin):
	- Big call to action.
	- Three columns with images and text.
	- Three columns with headings, images, and text: Heading, Image, and Text.
	- Three columns with text, an image, and a pullquote.
	- Three stacked galleries.
	- Two columns with images and text.
	– Two columns with text and a pullquote.

Version 1.0.5 (2021-03-14)
-------------------------
- Adjusted letter spacing.
- Adjusted H4 and H5 heading font sizes on desktop.
- Adjusted the width of the thin separator block on mobile.
- Adjusted the text decoration of preview titles.
- Improved handling of cover, group, and media and text block nesting, and updated block editor styles to match.
- Added the .is-style-no-[top/bottom]-margin helper class to the front-end and block editor styles.
- Added missing focus styles.
- Block editor styles: Adjusted headings to match front-end.
- Block editor styles: Adjusted button margins.
- Block editor styles: Set the Block Appender Button to inherit its icon and border color from the text color of its parent blocks.
- Menu modal: Added a focus loop to improve keyboard navigation.
- Menu modal: Improved focus styles.

Version 1.0.4 (2021-03-12)
-------------------------
- Adjusted the bottom margin of headings on mobile to match the site gutter.
- Adjusted buttons block margins on mobile, and fixed buttons margin inconsistencies when set to new alignment classes in WordPress 5.7.
- Fixed Social Block margins being overwritten by new styles in 5.7.
- Updated site logo/title/description output to better match the "Display Site Title and Tagline" setting.
- Improved styles of site logo and title when used in combination on small screens.
- Changed the custom_logo Customizer setting to use refresh transport, so the Customizer preview reflects changes in markup around the site logo element.
- Block editor styles: Reduced the font size of the large and larger font sizes on mobile, and updated the block editor styles to match.
- Block editor styles: Updated Media & Text block content margins to match front-end.

Version 1.0.3 (2021-03-10)
-------------------------
- Fixed the category filter not being displayed when the Archive Pages → Intro Text setting in the Customizer is empty (thanks, @jeroenrotty).

Version 1.0.2 (2021-03-10)
-------------------------
- Refresh the Masonry layout on a conditional interval, to account for lazy loading images and dynamic changes in markup.
- Cleaned up the comment structure in construct.js, and removed a unused function.
- Removed the loading="lazy" attribute from the default fallback image.
- Focused and simplified the sticky header JS and made the stickiness more immediate.
- Adjusted spacing of the solid background pullquote style.
- Adjusted the styles of list and pre elements.
- Adjusted the theme description in style.css.
- Added column specific styles to the post grid, to make the previews scale better when more columns are used.
- Adjusted the default number of columns at different screen sizes, and updated the Customizer option descriptions to state the recommended number of columns for each option.
- Block editor styles: Adjusted the post title styles to better match the front-end display.
- Block editor styles: Unified handling of unaligned groups nested in other blocks.

Version 1.0.1 (2021-03-09)
-------------------------
- Tweaked the bottom margin of the site header.
- Adjusted the Masonry layout call.
- Eksell_Custom_CSS::get_customizer_css(): Fixed a faulty conditional causing a warning when the custom colors aren't set.
- Eksell_Custom_CSS::get_customizer_css(): Fixed the P3 color @supports CSS wrapper always being output.

Version 1.0.0 (2021-03-08)
-------------------------
- Initial version