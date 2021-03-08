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

Placeholder image by Anders Norén
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

Version 1.0.1 (2021-03-XX)
-------------------------
- Tweaked the bottom margin of the site header.

Version 1.0.0 (2021-03-08)
-------------------------
- Initial version