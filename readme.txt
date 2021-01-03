=== footnotes ===
Contributors: mark.cheret, lolzim, pewgeuges, dartiss
Tags: footnote, footnotes, bibliography, formatting, notes, Post, posts, reference, referencing
Requires at least: 3.9
Tested up to: 5.6
Requires PHP: 5.6
Stable Tag: 2.3.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

Featured on wpmudev: http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/
Cheers for the review, folks!

https://www.youtube.com/watch?v=HzHaMAAJwbI

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

= 2.4.0 =
- Bugfix: Shortcodes: Dashboard: warning about '&gt;' escapement disruption in WordPress Block Editor
- Bugfix: Shortcodes: Dashboard: remove new option involving HTML comment tags only usable in source mode
- Add: Customization: support for custom templates in active theme, thanks to @misfist
- Add: Shortcodes: syntax validation for balanced footnote start and end tag short codes
- Add: Reference container: Row borders: more options for border width, style and color
- Bugfix: Reference container: Row borders: adapt left padding to the presence of a left border
- Bugfix: Reference container: add class footnote_plugin_symbol to disambiguate repurposed class footnote_plugin_link

= 2.3.0 =
- Add: optional hard links in referrers and backlinks for AMP compatibility, thanks to @psykonevro and @martinneumannat
- Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe
- Bugfix: Referrers and tooltips: disable box shadow to more effectively remove unwanted underline as bottom border, thanks to @klusik
- Bugfix: Dashboard: swap Custom CSS migration Boolean, meaning 'show legacy' instead of 'migration complete', due to storage data structure constraints
- Update: Dashboard: rename 'Priority level' tab as 'Scope and priority', to account for the new alternative depending on widget_text hook activation
- Bugfix: Referrers and tooltips: correct scope of the line height fix to only affect the referrers
- Bugfix: Referrers: extend clickable area to the full line height in sync with current pointer shape
- Bugfix: Referrers: extend scope of the underline inhibition to be more comprehensive and consistent
- Bugfix: Reference container: edits to optional basic responsive page layout style sheet

= 2.2.10 =
- Bugfix: Reference container: add option for table borders to revert 2.0.0/2.0.1 change made on user request, thanks to @noobishh
- Bugfix: Reference container: add missing container ID in function name in one of the four table row templates
- Bugfix: Reference container, tooltips: URL wrap: support also file transfer protocol URLs

= 2.2.9 =
- Bugfix: Reference container, widget_text hook: support for multiple reference containers in a page, thanks to @justbecuz
- Update: Priority levels: set widget_text default to 98 and update its description in the dashboard Priority level tab
- Bugfix: Reference container, tooltips: URL wrap: account for RFC 2396 allowed characters in parameter names
- Bugfix: Reference container, tooltips: URL wrap: exclude URLs also where the equals sign is preceded by an entity or character reference

= 2.2.8 =
- Bugfix: Reference container, tooltips: URL wrap: correct lookbehind by duplicating it with and without quotation mark class

= 2.2.7 =
- Bugfix: Reference container, tooltips: URL wrap: revert the change in the regex, thanks to @rjl20, @spaceling, @friedrichnorth, @bernardzit

= 2.2.6 =
- Bugfix: Reference container, tooltips: URL wrap: make the quotation mark optional wrt query parameters, thanks to @spiralofhope2
- Add: Customization: support for custom templates in sibling folder (should be filterable function, thanks to @misfist)

= 2.2.5 =
- Add: Dashboard: Footnotes numbering: add support for Ibid. notation in suggestions for guidance, thanks to @meglio
- Add: Reference container: support options for label element and label bottom border, thanks to @markhillyer
- Bugfix: Referernce container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe
- Bugfix: Dashboard: Tooltip position/timing settings: include alternative tooltips (for themes not supporting jQuery tooltips)
- Bugfix: Dashboard: Tooltip position/timing settings: raise above tooltip truncation settings for better consistency

= 2.2.4 =
- Bugfix: Reference container: Backlink symbol selection: moved back to previous tab “Referrers and tooltips”
- Bugfix: Custom CSS: make inserting existing in header depend on migration complete checkbox status

= 2.2.3 =
- Bugfix: Custom CSS: insert new in header after existing

= 2.2.2 =
- Bugfix: Dashboard: Link element setting only under General settings > Reference container
- Add: Dashboard: migrate Custom CSS to dedicated new tab, keep legacy until checking a box
- Bugfix: Reference container: edits to optional basic responsive page layout style sheets

= 2.2.1 =
- Bugfix: Dashboard: duplicate moved settings under their legacy tab to account for data structure

= 2.2.0 =
- Add: Reference container: support for custom position shortcode, thanks to @hamshe
- Update: Priority levels: update the notice in the dashboard Priority tab
- Bugfix: Tooltips: add 'important' property to z-index to fix display overlay issue
- Add: Start/end short codes: more predefined options
- Add: Numbering styles: lowercase Roman numerals support
- Update: Dashboard: Tooltip settings: grouped into 3 thematic containers
- Update: Dashboard: Main settings: grouped into 3 specific containers
- Update: Dashboard: moved link element option to the Referrers options
- Update: Dashboard: moved URL wrap option to the Reference container options
- Update: Dashboard: grouped both Custom CSS and priority level settings under the same tab
- Update: Dashboard: renamed tab labels 'Referrers and tooltips', 'Priority and CSS'
- Bugfix: Localization: correct arguments for plugin textdomain load function
- Bugfix: Reference container, tooltips: URL wrap: specifically catch the quotation mark
- Add: Footnotes mention in the footer: more options

= 2.1.6 =
- Bugfix: Priority levels: set the_content priority level to 98 to prevent plugin conflict, thanks to @marthalindeman
- Bugfix: Tooltips: set z-index to maximum 2147483647 to address display issues with overlay content, thanks to @russianicons
- Bugfix: Reference container, tooltips: URL wrap: fix regex, thanks to @a223123131
- Bugfix: Dashboard: URL wrap: add option to properly enable/disable URL wrap
- Update: Dashboard: reorder tabs and update tab labels
- Bugfix: Dashboard: remove Expert mode enable setting since permanently enabled as 'Priority'
- Bugfix: Dashboard: fix punctuation-related localization issue by including colon in labels
- Bugfix: Localization: conform to WordPress plugin language file name scheme

= 2.1.5 =
- Bugfix: Reference container, tooltips: URL wrap: exclude image source too, thanks to @bjrnet21

= 2.1.4 =
- Add: Dashboard: Main settings: add settings for scroll offset and duration
- Add: Dashboard: Tooltip settings: add settings for display delays and fade durations
- Add: Styling: Tooltips: fix font size issue by adding font size to settings with legacy as default
- Add: Reference container: fix theme-dependent layout issues by optionally enqueuing additional style sheet
- Add: Reference container: fix layout issues by moving backlink column width to settings
- Add: Reference container: separating and terminating punctuation optional and customizable
- Add: Reference container: Backlinks: optional line breaks to stack enumerations
- Bugfix: Layout: Tooltips: prevent line break in Read-on link label
- Bugfix: Styling: Referrers and backlinks: make link elements optional to fix issues
- Bugfix: Styling: Referrers: disable hover underline
- Bugfix: Reference container, tooltips: fix line wrapping of URLs based on pattern, not link element
- Bugfix: Reference container: Backlink symbol: support for appending when combining identicals is on
- Bugfix: Reference container: Backlinks: deprioritize hover underline to ease customization
- Bugfix: Reference container: Backlinks: fix line breaking with respect to separators and terminators
- Bugfix: Reference container: Label: delete overflow hidden rule
- Bugfix: Reference container: Expand/collapse button: same padding to the right for right-to-left
- Bugfix: Reference container: Styles: re-add the class dedicated to combined footnotes indices
- Bugfix: Dashboard: move arrow settings from Customize to Settings > Reference container to reunite and fix issue with new heading wording
- Bugfix: Dashboard: Main settings: fix layout, raise shortcodes to top
- Bugfix: Dashboard: Tooltip settings: Truncation length: change input box type from text to numeric
- Update: Dashboard: Notices: use explicit italic style
- Bugfix: Dashboard: Other settings: Excerpt: display guidance next to select box, thanks to @nikelaos
- Bugfix: WordPress hooks: the_content: set priority to 1000 as a safeguard
- Update: Dashboard: Expert mode: streamline and update description for hooks and priority levels

= 2.1.3 =
- Bugfix: Hooks: disable widget_text hook by default to fix accordions declaring headings as widgets
- Bugfix: Hooks: disable the_excerpt hook by default to fix issues, thanks to @nikelaos
- Bugfix: Reference container: fix column width when combining turned on by reverting new CSS class to legacy
- Bugfix: Reference container: fix width in mobile view by URL wrapping wrt Unicode-non-conformant browsers
- Bugfix: Reference container: table cell backlinking if index is single and combining identicals turned on
- Bugfix: Styling: raise Custom CSS priority to override settings
- Bugfix: Styling: Tooltips: raise settings priority to override theme style sheets

= 2.1.2 =
- Bugfix: Layout: Reference container: Backlinks: no underline on hover cell when combining identicals is on
- Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos
- Update: Dashboard: WordPress documentation URLs of the hooks
- Update: Dashboard: feature description for the hooks priority level settings, thanks to @nikelaos

= 2.1.1 =
- Bugfix: Combining identical footnotes: fix dead links, ensure referrer-backlink bijectivity, thanks to @happyches
- Update: Libraries: jQuery Tools: redact jQuery.browser function use in js/jquery.tools.min.js
- Update: Libraries: jQuery Tools: complete minification
- Bugfix: Libraries: made script loads depend on tooltip implementation option
- Bugfix: Libraries: jQuery UI: properly pick the libraries registered by WordPress needed for tooltips
- Bugfix: UI: Tooltips: optional alternative JS implementation with CSS animation to fix site issues
- Bugfix: UI: Tooltips: add delay (400ms) before fade-out to fix UX wrt links and Read-on button
- Bugfix: UI: Tooltips: fix line breaking for hyperlinked URLs in Unicode-non-compliant user agents
- Bugfix: Layout: Footnote referrers: select box to make superscript optional wrt themes w/o support, thanks to @cwbayer
- Bugfix: Layout: Reference container: fix relative positioning by priority level setting, thanks to june01, @spaceling, @imeson
- Bugfix: Layout: Reference container: Backlink symbol: select box to disable instead of space character
- Bugfix: Layout: Reference container: Footnote number links: disable bottom border for theme compatibility
- Bugfix: Layout: Reference container: option to restore 3-column layout when combined are turned off
- Bugfix: Layout: Reference container: option to APpend symbol in 2-column when combined are turned off
- Bugfix: Layout: Reference container: fix start pages by an option to hide the reference container
- Bugfix: Layout: Reference container: Table rows: fix top and bottom padding
- Bugfix: Layout: Footnote referrers: new fix for line height
- Bugfix: Formatting: disable overline showing in some themes on hovered backlinks

= 2.1.0 =
- Add: UI: Tooltip: made 'Continue reading' button label customizable
- Bugfix: Layout: Footnote referrers: disabled bottom border for theme compatibility
- Update: Accessibility: added 'speaker-mute' class to reference container
- Bugfix: Dashboard: Layout: added named selectors to limit applicability of styles
- UPDATE: REMOVED the_post hook, the plugin stopped supporting this hook

= 2.0.8 =
- BUGFIX: Priority level back to PHP_INT_MAX (need to get in touch with other plugins)

= 2.0.7 =
- BUGFIX: Disabled hook "the_post" **Any related code in the plugin shall disappear**
- Update: Set priority level back to 10 assuming it is unproblematic
- Update: Added backwards compatible support for legacy arrow and index placeholders in template
- Update: Settings defaults adjusted for better and more up-to-date tooltip layout

= 2.0.6 =
- Update: Autoload / infinite scroll support thanks to @docteurfitness <https://wordpress.org/support/topic/auto-load-post-compatibility-update/>
- Bugfix: Layout: Footnote referrers: deleted vertical align tweaks, for cross-theme and user agent compatibility
- Bugfix: Layout: Reference container: fixed line breaking behavior in footnote # clusters
- Bugfix: Layout: Reference container: auto-extending column to fit widest, to fix display with short note texts
- Bugfix: Layout: Reference container: IDs: slightly increased left padding
- Bugfix: Translations: fixed spelling error and erroneously changed word in en_GB and en_US
- Update: Typesetting: discarded the dot after footnote numbers as not localizable (should be optional)
- Bugfix: UI: Reference container: Collapse button fully clickable, not sign only
- Bugfix: UI: Reference container: Collapse button 'collapse' with minus sign not hyphen-minus
- Update: UX: Tooltip: set display predelay to 0 for responsiveness (was 800 since 2.0.0, 400 before)
- Update: UX: Tooltip: set fade duration to 200ms both ways (was 200 in and 2000 out since 2.0.0, 0 in and 100 out before)
- BUGFIX: Priority level back to PHP_INT_MAX (ref container positioning not this plugin’s responsibility)

= 2.0.5 =
- Bugfix: Get references container close to content, not below all other features, by priority level 10
- Bugfix: Public style sheet: Reference container: unset width of text column to fix site issues
- Update: Enable all hooks by default to prevent footnotes from seeming broken in post titles
- Bugfix: Restore cursor shape pointer over 'Continue reading' button after hyperlink removal
- Bugfix: Settings style sheet unenqueued to fix input boxes on public pages (enqueued for 2.0.4)

= 2.0.4 =
- Update: Restored arrow settings to customize or disable the now prepended arrow symbol
- Update: GDPR: Added jQuery UI from WordPress instead of third party
- Bugfix: UX: Removed hyperlink addresses from referrers and backlinks wrt browsing history
- Bugfix: Reference container: layout: removed inconvenient left/right cellpadding
- Bugfix: Tooltip infobox: improved layout with inherited font size by lower line height
- Bugfix: Tooltip infobox: 'Continue reading' button: disabled default underline
- Bugfix: Translations: reviewed all locales (en, de, es, fr), synced ref line # with edited code
- Bugfix: Fixed display of 2 dashboard headings

= 2.0.3 =
- Bugfix: Layout: Self-adjusting width of ID column but hidden overflow
- Update: Prepended transitional up arrow to backlinking footnote numbers after a user complaint about missing backlinking semantics of the footnote number
- Bugfix: Fragment IDs: Prepended post ID to footnote number
- Bugfix: Feed plugin version in style sheet query string for cache busting
- Bugfix: Print style: prevent a page break just after the reference container label
- Bugfix: Print style: Hide reference collapse button
- Update: Layout: Removed padding before reference container label

= 2.0.2 =
- Bugfix: Restored expand/collapse button of reference container
- Bugfix: Dashboard: Available CSS selectors, last item display
- Bugfix: Footnote anchor and ID color to default on screen, to inherit in print
- Bugfix: Disabled underline in footnote anchors, underline only on hover

= 2.0.1 =
- Bugfix: enforced borderless table cells with !important property, thanks to @ragonesi
- Update: Language fr_FR along with es_ES, de_AT, de_DE, en_GB, en_US for 2.0

= 2.0.0 =
- Major contributions taken from WordPress user pewgeuges, all details here https://github.com/media-competence-institute/footnotes/blob/master/README.md:
- Update: **symbol for backlinks** removed
- Update: hyperlink moved to the reference number
- Update: Upgrade jQuery library
- Update: Account for disruptive PHP change
- Bugfix: footnote links script independent
- Bugfix: Get the “Continue reading” link to work in the mouse-over box
- Bugfix: Debug printed posts and pages
- Bugfix: Display of combined identical notes
- Update: Adjusted scrolling time and offset
- Bugfix: No borders around footnotes in the container
- Bugfix: Mouse-over box display timing

= 1.6.6 =
- Beginning of translation to French

= 1.6.5 =
- Update: Fix for deprecated PHP function create_function() (man thanks to Felipe Lavín Z.)
- Update: The CSS had been modified in order to show the tooltip numbers a little less higher than text
- Bugfix: Fixed error on demo in backend

= 1.6.4 =
- Bugfix: The deprecated WP_Widget elements have been replaced
- Bugfix: Fixed occasional bug where footnote ordering could be out of sequence

= 1.6.3 =
- Bugfix: We were provided a fix by a user named toma. footnotes now works in sub-folder installations of WordPress

= 1.6.2 =
- Update: Changed the Preview tab
- Bugfix: Html tags has been removed in the Reference container when the excerpt mode is enabled

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
to upgrade our plugin is simple. Just update the plugin within your WordPress installation.
To cross-upgrade from other footnotes plugins, there will be a migration assistant in the future
