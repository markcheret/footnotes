=== footnotes ===
Contributors: Aricura, mark.cheret, ericakfranz
Tags: footnote, bibliography, formatting, notes, post, reference
Requires at least: 3.9
Tested up to: 4.8.1
Stable Tag: 1.6.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A powerful and fully featured method of adding footnotes to your site content.

== Description ==

Featured on wpmudev: http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/
Cheers for the review, folks!

**footnotes** aims to be the all-in-one solution for displaying an automatically generated list of references on your Page or Post. The Plugin ships with a set of sane defaults but also gives the user control over how their footnotes are being displayed.
**footnotes** gives you the ability to display decently-formated footnotes on your WordPress Pages or Posts (those footnotes we know from offline publishing).

= Main Features =
- Fully customizable **footnotes** shortcode
- Decide, where your **footnotes** are displayed (position of the *Reference Container*)
- Add custom CSS to style the appeareance of the **footnotes**
- Responsive *Reference Container*
- Mouse-Over Box with clickable links displays your **footnotes** text
- Automatic numbering of your **footnotes**
- Choose from a list of symbols to represent your **footnotes**
- Display the **footnotes** *Reference Container* inside a Widget
- Button in both the Visual and the Text editor
  - Add **footnotes** into your Page / Post with ease of use by selecting your text and clicking the button

= Example Usage =
This is an example. Please note, that you can customize the shortcode you want to use.

1. Your awesome text((with an awesome footnote))
2. Your awesome text[ref]with an awesome footnote[/ref]
3. Your awesome text`<fn>`with an awesome footnote`</fn>`
4. Your awesome text `custom-shortcode` with an awesome footnote `custom-shortcode`

= Where to get footnotes? =
The current version is available on wordpress.org:
http://downloads.wordpress.org/plugin/footnotes.zip

= Support =
Please report feature requests, bugs and other support related questions in the WordPress Forums at https://wordpress.org/support/plugin/footnotes

Speak your mind, unload your burdens. Notice how we screwed up big time? Bring it to our attention in the above mentioned WordPress Forums. Be polite, though :)

= Development =
Development of the plugin is an open process. Latest code is available on wordpress.org

== Frequently Asked Questions ==

= Is your Plugin a copy of footnotes x? =

No, this Plugin has been written from scratch. Of course some inspirations on how to do or how to not do things were taken from other plugins.

= Your Plugin is awesome! How do I convert my footnotes if I used one of the other footnotes plugins out there? =

1. For anyone interested in converting from the FD Footnotes plugin:
Visit this swift write-up from a **footnotes** user by the name of **Southwest**: http://wordpress.org/support/topic/how-to-make-this-footnote-style?replies=6#post-5946306
2. From what we've researched, all other footnotes Plugins use open and close shortcodes, which can be left as is. In the **footnotes** settings menu, you can setup **footnotes** to use the existing (=previously used) shortcodes. Too easy? Yippy Ki-Yey!

== Installation ==
- Visit your WordPress Admin area
- Navigate to `Plugins\Add`
- Search for **footnotes** and find this Plugin among others
- Install the latest version of the **footnotes** Plugin from WordPress.org
- Activate the Plugin

== Screenshots ==
1. Find the footnotes plugin settings in the newly added "ManFisher" Menu
2. Settings for the *References Container*
3. Settings for **footnotes** styling
4. Settings for **footnotes** love
5. Other Settings
6. The HowTo section in the **footnotes** settings
7. Here you can see the **footnotes** Plugin at work. Isn't that plain beautiful?

== Changelog ==

= 1.6.5 =
* Bugfix: Check if quicktags script is available before loading custom QTag button. This fixes a JS error which may have interfered with other functionality on custom post type edit screens.

= 1.6.4 =

* Bugfix: The deprecated WP_Widget elements have been replaced
* Bugfix: Fixed occasional bug where footnote ordering could be out of sequence

= 1.6.3 =
* Bug: We were provided a fix by a user named toma. footnotes now works in sub-folder installations of WordPress

= 1.6.2 =
* Update: Changed the Preview tab
* Bugfix: Html tags has been removed in the Reference container when the excerpt mode is enabled

= 1.6.1 =
- Update: Translations
- Bugfix: Move to anchor

= 1.6.0 =
- **IMPORTANT**: Improved performance. You need to Activate the Plugin again. (Settings won't change!)
- Add: Setting to customize the mouse-over box shadow
- Add: Translation: United States
- Add: Translation: Austria
- Add: Translation: Spanish (many thanks to Pablo L.)
- Update: Translations (de_DE and en_GB)
- Update: Changed Plugins init file name to improve performance (Re-activation of the Plugin is required)
- Update: ManFisher note styling
- Update: Tested with latest nightly build of WordPress 4.1
- Bugfix: Avoid multiple IDs for footnotes when multiple reference containers are displayed

= 1.5.7 =
- Add: Setting to define the positioning of the mouse-over box
- Add: Setting to define an offset for the mouse-over box (precise positioning)
- Bugfix: Target element to move down to the reference container is the footnote index instead of the arrow (possibility to hide the arrow)
- Bugfix: Rating calculation for the 'other plugins' list

= 1.5.6 =
- **IMPORTANT**: We have changed the html tag for the superscript. Please check and update your custom CSS.
- Add: .pot file to enable Translations for everybody
- Add: Settings to customize the mouse-over box (color, background color, border, max. width)
- Update: Translation file names
- Update: Translation EN and DE
- Update: Styling of the superscript (need to check custom CSS code for the superscript)
- Update: Description of CSS classes for the 'customize CSS' text area
- Bugfix: Removed 'a' tag around the superscript for Footnotes inside the content to avoid page reloads (empty href attribute)
- Bugfix: Avoid Settings fallback to its default value after submit an empty value for a setting
- Bugfix: Enable multiple WP_Post objects for the_post hook

= 1.5.5 =
- Add: Expert mode setting
- Add: Activation and Deactivation of WordPress hooks to look for Footnotes (expert mode)
- Add: WordPress hooks: 'the_title' and 'widget_title' (default: disabled) to search for Footnote short codes
- Bugfix: Default value for the WordPress hook the_post to be disabled (adds Footnotes twice to the Reference container)
- Bugfix: Activation, Deactivation and Uninstall hook class name
- Bugfix: Add submenu pages only once for each ManFisher WordPress Plugin
- Bugfix: Display the Reference container in the Footer correctly

= 1.5.4 =
- Add: Setting to enable an excerpt of the Footnotes mouse-over box text (default: disabled)
- Add: Setting to define the maximum length of the excerpt displayed in the mouse-over box (default: 150 characters)
- Update: Detail information about other Plugins from ManFisher (rating, downloads, last updated, Author name/url)
- Update: Receiving list of other Plugins from the Developer Team from an external server
- Update: Translations (EN and DE)
- Bugfix: Removed hard coded position of the 'ManFisher' main menu page (avoid errors with other Plugins)
- Bugfix: Changed function name (includes.php) to be unique (avoid errors with other Plugins)
- Bugfix: Try to replace each appearance of Footnotes in the current Post object loaded from the WordPress database

= 1.5.3 =
- Add: Developer's homepage to the 'other Plugins' list
- Update: Smoothy scroll to an anchor using Javascript
- Bugfix: Set the vertical align for each cell in the Reference container to TOP

= 1.5.2 =
- Add: Setting to enable/disable the mouse-over box
- Add: Current WordPress Theme to the Diagnostics sub page
- Add: ManFisher note in the "other Plugins" sub page
- Update: Removed unnecessary hidden inputs from the Settings page
- Update: Merged public CSS files to reduce the output and improve the performance
- Update: Translations (EN and DE)
- Bugfix: Removed the 'trim' function to allow whitespaces at the beginning and end of each setting
- Bugfix: Convert the footnotes short code to HTML special chars when adding them into the page/post editor (visual and text)
- Bugfix: Detailed error messages if other Plugins can't be loaded. Also added empty strings as default values to avoid 'undefined'

= 1.5.1 =
- Bugfix: Broken Settings link in the Plugin listing
- Bugfix: Translation overhaul for German

= 1.5.0 =
- Add: Grouped the Plugin Settings into a new Menu Page called "ManFisher Plugins"
- Add: Sub Page to list all other Plugins of the Contributors
- Add: Hyperlink to manfisher.eu in the "other plugins" page
- Update: Refactored the whole source code
- Update: Moved the Diagnostics Sections to into a new Sub Page called "Diagnostics"
- Bugfix: Line up Footnotes with multiple lines in the Reference container
- Bugfix: Load text domain
- Bugfix: Display the Footnotes button in the plain text editor of posts/pages

= 1.4.0 =
- Feature: WPML Config XML file for easy multi language string translation (WPML String Translation Support File)
- Update: Changed e-Mail support address to the WordPress support forum
- Update: Language EN and DE
- Add: Tab for Plugin Diagnostics
- Add: Donate link to the installed Plugin overview page
- Add: Donate button to the "HowTo" tab

= 1.3.4 =
- Bugfix: Settings access permission vor sub-sites
- Bugfix: Setting 'combine identical footnotes' working as it should

= 1.3.3 =
- Update: Changed the Author name from a fictitious entity towards a real registered company
- Update: Changed the Author URI

= 1.3.2 =
- Bugfix: More security recognizing Footnotes on public pages (e.g. ignoring empty Footnote short codes)
- Bugfix: Clear old Footnotes before lookup new public page (only if no reference container displayed before)
- Update: language EN and DE
- Add: Setting to customize the hyperlink symbol in der reference container for each footnote reference
- Add: Setting to enter a user defined hyperlink symbol
- 

= 1.3.1 =
- Bugfix: Allow settings to be empty
- Bugfix: Removed space between the hyperlink and superscript in the footnotes index
- Add: Setting to customize the text before and after the footnotes index in superscript

= 1.3.0 =
- Bugfix: Changed tooltip class to be unique
- Bugfix: Changed superscript styling to not manipulate the line height
- Bugfix: Changed styling of the footnotes text in the reference container to avoid line breaks
- Update: Reformatted code
- Add: new settings tab for custom CSS settings

= 1.2.5 =
- Bugfix: New styling of the mouse-over box to stay in screen (thanks to Jori, France and Manuel345, undisclosed location)

= 1.2.4 =
- Bugfix: CSS stylesheets will only be added in FootNotes settings page, nowhere else (thanks to Piet Bos, China)
- Bugfix: Styling of the reference container when the footnote text was too long (thanks to Willem Braak, undisclosed location)
- Bugfix: Added a Link to the footnote text in the reference container back to the footnote index in the page content (thanks to Willem Braak, undisclosed location)

= 1.2.3 =
- Bugfix: Removed 'Warning output' of Plugins activation and deactivation function (thanks to Piet Bos, China)
- Bugfix: Added missing meta boxes parameter on Settings page (thanks to Piet Bos, China)
- Bugfix: Removed Widget text formatting
- Bugfix: Load default settings value of setting doesn't exist yet (first usage)
- Bugfix: Replacement of footnotes tag on public pages with html special characters in the content
- Feature: Footnotes tag color is set to the default link color depending on the current Theme (thanks to Daniel Formo, Norway)

= 1.2.2 =
- Bugfix: WYSIWYG editor and plain text editor buttons insert footnote short code correctly (also if defined like html tag)
- Update: The admin can decide which "I love footnotes" text (or not text) will be displayed in the footer
- Add: Buttons next to the reference label to expand/collapse the reference container if set to "collapse by default"
- Bugfix: Replace footnote short code
- Update: Combined buttons for the "collapse/expand" reference container

= 1.2.1 =
- Bugfix: HowTo example will be displayed correctly if a user defined short code is set

= 1.2.0 =
- Feature: New button in the WYSIWYG editor and in the plain text editor to easily implement the footnotes tag
- Feature: Icon for the WYSIWYG-editor button
- Feature: Pre defined footnote short codes
- Experimental: User defined short code for defining footnotes
- Experimental: Plugin Widget to define where the reference container should appear when set to "widget area"
- Update: Moved footnotes 'love' settings to a separate container
- Update: Translation for new settings and for the Widget description
- Bugfix: Setting for the position of the "reference container" works for the options "footer", "end of post" and "widget area"

= 1.1.1 =
- Feature: Short code to not display the 'love me' slug on specific pages ( short code = [[no footnotes: love]] )
- Update: Setting where the reference container appears on public pages can also be set to the widget area
- Add: Link to the wordpress.org support page in the plugin main page
- Update: Changed plugin URL from GitHub to WordPress
- Bugfix: Uninstall function to really remove all settings done in the settings page
- Bugfix: Load default settings after plugin is installed
- Update: Translation for support link and new setting option
- Add: Label to display the user the short code to not display the 'love me' slug

= 1.1.0 =
- Update: Global styling for the public plugin name
- Update: Easier usage of the public plugin name in translations
- Update: New Layout for the settings page to group similar settings to get a better overview
- Update: Display settings submit button only if there is at least 1 editable setting in the current tab
- Add: Setting where the reference container appears on public pages (needs some corrections!)
- Bugfix: Displays only one reference container in front of the footer on category pages

= 1.0.6 =
- Bugfix: Uninstall function to delete all plugin settings
- Bugfix: Counter style internal name in the reference container to correctly link to the right footnote on the page above
- Bugfix: Footnote hover box styling to not wrap the footnote text on mouse over
- Update: 'footnotes love' text in the page footer if the admin accepts it and set its default value to 'no'

= 1.0.5 =
- The Plugin has been submitted to wordpress.org for review and (hopefully) publication.
- Update: Plugin description for public directories (WordPress.org and GitHub)
- Feature: the footnotes WordPress Plugin now has its very own CI
  - Update: Styling
  - Update: Settings to support the styling
- Add: Inspirational Screenshots for further development
- Add: Settings screenshot
- Update: i18n fine-tuning

= 1.0.4 =
- Update: replacing function when footnote is a link (bugfix)
- Footnote hover box remains until cursor leaves footnote or hover box
- Links in the footnote hover box are click able
- Add: setting to allow footnotes on Summarized Posts
- Add: setting to tell the world you're using footnotes plugin
- Add: setting for the counter style of the footnote index
  - Arabic Numbers (1, 2, 3, 4, 5, ...)
  - Arabic Numbers leading 0 (01, 02, 03, 04, 05, ...)
  - Latin Characters lower-case (a, b, c, d, e, ...)
  - Latin Characters upper-case (A, B, C, D, E, ...)
  - Roman Numerals (I, II, III, IV, V, ...)
- Add: a link to the WordPress plugin in the footer if the WP-admin accepts it
- Update: translations for the new settings
- Switch back the version numbering scheme to have 3 digits

= 1.0.3 =
- Add: setting to use personal starting and ending tag for the footnotes
- Update: translations for the new setting
- Update: reading settings and fallback to default values (bugfix)

= 1.0.2 =
- Add: setting to collapse the reference container by default
- Add: link behind the footnotes to automatically jump to the reference container
- Add: function to easy output input fields for the settings page
- Update: translation for the new setting

= 1.0.1 =
- Separated functions in different files for a better overview
- Add: a version control to each file / class / function / variable
- Add: layout for the settings menu, settings split in tabs and not a list-view
- Update: Replacing footnotes in widget texts will show the reference container at the end of the page (bugfix)
- Update: translations for EN and DE
- Changed version number from 3 digits to 2 digits

= 1.0.0 =
- First development Version of the Plugin

== Upgrade Notice ==

= 4.3.5 =
* Minor update to change branding
