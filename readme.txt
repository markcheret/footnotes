=== footnotes ===
Contributors: mark.cheret, lolzim, rumperuu, aricura, misfist, ericakfranz, dartiss, docteurfitness, felipelavinz, martinneumannat, matkus2, meglio, spaceling, vonpiernik, pewgeuges
Tags: footnote, footnotes, bibliography, formatting, notes, Post, posts, reference, referencing
Requires at least: 3.9
Tested up to: 5.7
Requires PHP: 5.6
Stable Tag: 2.5.10
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

Featured on wpmudev: http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/
Cheers for the review, folks!

https://www.youtube.com/watch?v=HzHaMAAJwbI

**footnotes** aims to be the all-in-one solution for displaying an automatically generated list of references on your Page or Post. The Plugin ships with a set of defaults while also empowering you to control how your footnotes are being displayed.
**footnotes** gives you the ability to display well-formatted footnotes on your WordPress Pages and Posts — those footnotes we know from offline publishing.

= Main Features =
- Fully customizable **footnotes** start and end shortcodes;
- Styled tooltips supporting hyperlinks display **footnotes** or a dedicated text;
- Responsive *Reference Container* at the end or positioned by shortcode;
- Display the **footnotes** *Reference Container* inside a Widget;
- Wide choice of numbering styles;
- Freely configurable and optional backlink symbol;
- Configure the **footnotes’** appearance by dashboard settings and Custom CSS style rules;
- Button in both the Visual and the Text editor to add shortcodes around selection.

= Example Usage =
These are a few examples of possible ways to delimit footnotes:

1. Your awesome text((with an awesome footnote))
2. Your awesome text[ref]with an awesome footnote[/ref]
3. Your awesome text`<fn>`with an awesome footnote`</fn>`
4. Your awesome text`custom-shortcode`with an awesome footnote`custom-shortcode`

= Where to get footnotes? =
The current version is available on the [WordPress.org plugins platform, Footnotes](https://wordpress.org/plugins/footnotes/).

= Support =
Please report feature requests, bugs and other support related questions in the [Footnotes section of WordPress Support Forum](https://wordpress.org/support/plugin/footnotes).

Speak your mind, unload your burden, bring it up, and feel free to [post your rating and review!](https://wordpress.org/support/plugin/footnotes/reviews/).

= Development =
Development of the plugin is an open process. Latest code is available in the [plugin part of WordPress SVN repository, footnotes/](https://plugins.svn.wordpress.org/footnotes/).

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

= 2.5.10 =
- Bugfix: Revert to 2.5.8. OUR APOLOGIES, PLEASE, FOR THE 2.5.9d1 PLUGIN 'Stable Tag' MISHAP.

= 2.5.8 =
- Bugfix: Layout: support right-to-left writing direction by replacing remaining CSS values 'left' with 'start', thanks to @arahmanshaalan bug report.
- Bugfix: Layout: support right-to-left writing direction by enabling mirrored paddings on HTML dir="rtl" pages, thanks to @arahmanshaalan bug report.

= 2.5.7 =
- Bugfix: Process: fix footnote duplication by emptying the footnotes list every time the search algorithm is run on the content, thanks to @inoruhana bug report.

= 2.5.6 =
- Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
- Bugfix: Alternative tooltips: shrink width to short content.
- Update: Documentation: slightly revise or update the plugin’s welcome page on WordPress.org.

= 2.5.5 =
- Update: Stylesheets: increase speed and energy efficiency by tailoring stylesheets to the needs of the instance, thanks to @docteurfitness design contribution.
- Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
- Bugfix: Libraries: optimize processes by loading external and internal scripts only if needed, thanks to @docteurfitness issue report.
- Bugfix: Process: fix numbering bug impacting footnote #2 with footnote #1 close to start, thanks to @rumperuu bug report, thanks to @lolzim code contribution.
- Update: Dashboard: add or edit descriptions to the tooltips and tooltip text delimiter settings and the backlink symbol configuration setting.
- Update: Dashboard: decrease font size and padding of the descriptions.

= 2.5.4 =
- Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
- Bugfix: Tooltips: fix jQuery positioning bug moving tooltips out of view and affecting (TablePress tables in) some themes, thanks to @wisenilesh bug report.
- Bugfix: Reference container, tooltips: URL wrap: enable the 'word-wrap: anywhere' rule, thanks to @rebelc0de bug report.
- Bugfix: Reference container, tooltips: URL wrap: account for leading space in value, thanks to @karolszakiel example provision.
- Bugfix: Dashboard: Tooltip dimensions: move from 'Tooltip position' to a dedicated metabox, thanks to @codldmac issue report.
- Update: Libraries: jQuery Tools: replace deprecated function jQuery.isFunction(), thanks to @a223123131 bug report.
- Bugfix: Editor button: Classic Editor text mode: try to fix uncaught reference error of “QTags is not defined”, thanks to @dpartridge bug report.
- Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
- Update: Tooltips: Excerpt delimiter: add configuration settings in the dashboard.
- Bugfix: Tooltips: fix display in Popup Maker popups by correcting a coding error.
- Bugfix: Editor button: Classic Editor text mode: correct label to singular.
- Bugfix: Libraries: jQuery Tools: replace double equals sign discouraged in JavaScript with recommended triple equals sign.

= 2.5.3 =
- Bugfix: Reference container, tooltips: URL wrap: exclude URL pattern as folder name in Wayback Machine URL, thanks to @rumperuu bug report.

= 2.5.2 =
- Update: Tooltips: Excerpt delimiter: ability to display dedicated content before `[[/tooltip]]`, thanks to @jbj2199 issue report.
- Bugfix: Localization: plugin language file name changes effective in version control system.

= 2.5.1 =
- Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
- Bugfix: Reference container: click on label expands but also collapses, thanks to @ahmadword bug report.
- Bugfix: Reference container: Label: cursor takes pointer shape, thanks to @ahmadword bug report.
- Bugfix: Dashboard: Custom CSS: mention validity of legacy while visible, thanks to @rkupadhya bug report.
- Bugfix: Dashboard: Custom CSS: make class list column formatting effective again.
- Update: Readme/documentation: add new contributors in the file header’s Contributors field.
- Update: Readme/documentation: update or fix URLs in Download, Support and Development sections.

= 2.5.0 =
- Adding: Templates: Enable template location stack, thanks to @misfist code contribution.
- Bugfix: Hooks: support footnotes on category pages, thanks to @vitaefit bug report, thanks to @misfist code contribution.
- Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
- Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
- Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
- Update: Dashboard: Footnote delimiters: Syntax validation: add more information around the setting.
- Bugfix: Dashboard: Footnote delimiters: warning about '&gt;' escapement disruption in WordPress Block Editor.

= 2.4.0 =
- Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
- Bugfix: Templates: optimize template load and processing based on settings, thanks to @misfist code contribution.
- Bugfix: Process: initialize hard link address variables to empty string to fix 'undefined variable' bug, thanks to @a223123131 bug report.
- Bugfix: Reference container: Label: set empty label to U+202F NNBSP for more robustness, thanks to @lukashuggenberg feedback.
- Bugfix: Scroll offset: initialize to safer one third window height for more robustness, thanks to @lukashuggenberg bug report.
- Bugfix: Footnote delimiters: Dashboard: remove new option involving HTML comment tags only usable in source mode.
- Bugfix: Reference container: Row borders: adapt left padding to the presence of an optional left border.
- Bugfix: Reference container: add class 'footnote_plugin_symbol' to disambiguate repurposed class 'footnote_plugin_link'.

= 2.3.0 =
- Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro bug report, thanks to @martinneumannat code contribution.
- Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
- Bugfix: Referrers and backlinks: more effectively remove unwanted underline by disabling box shadow used instead of bottom border, thanks to @klusik feedback.
- Bugfix: Dashboard: Custom CSS: swap migration Boolean, meaning 'show legacy' instead of 'migration complete', due to storage data structure constraints.
- Update: Dashboard: Priority level: rename tab as 'Scope and priority', to account for the new alternative depending on widget_text hook activation.
- Bugfix: Referrers and tooltips: correct scope of the line height fix to only affect the referrers, not the tooltip content.
- Bugfix: Referrers: extend clickable area to the full line height in sync with current pointer shape.
- Bugfix: Referrers: extend scope of the underline inhibition to be more comprehensive and consistent.
- Bugfix: Reference container: Basic responsive page layout: edits to one of the optional stylesheets.

= 2.2.10 =
- Bugfix: Reference container: add option for table borders to restore pre-2.0.0 design, thanks to @noobishh issue report.
- Bugfix: Reference container: add missing container ID in function name in default table row template for uncombined footnotes.
- Bugfix: Reference container, tooltips: URL wrap: support also file transfer protocol URLs.

= 2.2.9 =
- Bugfix: Reference container, widget_text hook: support for multiple containers in a page, thanks to @justbecuz bug report.
- Update: Priority levels: set widget_text default to 98 and update its description in the dashboard Priority level tab.
- Bugfix: Reference container, tooltips: URL wrap: account for RFC 2396 allowed characters in parameter names.
- Bugfix: Reference container, tooltips: URL wrap: exclude URLs also where the equals sign is preceded by an entity or character reference.

= 2.2.8 =
- Bugfix: Reference container, tooltips: URL wrap: correctly make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.

= 2.2.7 =
- Bugfix: Reference container, tooltips: URL wrap: remove a bug introduced in the regex, thanks to @rjl20 @spaceling @lukashuggenberg @klusik @friedrichnorth @bernardzit bug reports.

= 2.2.6 =
- Bugfix: Reference container, tooltips: URL wrap: make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
- Adding: Templates: support for custom templates in sibling folder, thanks to @misfist issue report.

= 2.2.5 =
- Bugfix: Dashboard: Footnotes numbering: add missing support for Ibid. notation to suggestions, thanks to @meglio design contribution.
- Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
- Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
- Bugfix: Reference container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe bug report.
- Update: Tooltips: Alternative tooltips: connect to position/timing settings (for themes not supporting jQuery tooltips).
- Update: Dashboard: Tooltip position/timing settings: include alternative tooltips (for themes not supporting jQuery tooltips).
- Bugfix: Dashboard: Tooltip position/timing settings: raise above tooltip truncation settings for better consistency.

= 2.2.4 =
- Bugfix: Reference container: Backlink symbol selection: move back to previous tab “Referrers and tooltips”.
- Bugfix: Custom CSS: make inserting existing in header depend on migration complete checkbox status.

= 2.2.3 =
- Bugfix: Custom CSS: insert new CSS in the public page header element after existing CSS.

= 2.2.2 =
- Bugfix: Dashboard: Link element setting only under General settings > Reference container.
- Bugfix: Dashboard: Custom CSS: unearth text area and migrate to dedicated tab as designed.
- Bugfix: Reference container: edits to optional basic responsive page layout stylesheets.

= 2.2.1 =
- Bugfix: Dashboard: duplicate moved settings under their legacy tab to account for data structure.

= 2.2.0 =
- Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
- Adding: Start/end short codes: more predefined options.
- Adding: Numbering styles: lowercase Roman numerals support.
- Update: Priority levels: update the notice in the dashboard Priority tab.
- Update: Dashboard: Tooltip settings: group into 3 thematic containers.
- Update: Dashboard: Main settings: group into 3 specific containers.
- Update: Dashboard: move link element option to the Referrers options.
- Update: Dashboard: move URL wrap option to the Reference container options.
- Update: Dashboard: group both Custom CSS and priority level settings under the same tab.
- Update: Dashboard: rename tab labels 'Referrers and tooltips', 'Priority and CSS'.
- Bugfix: Tooltips: add 'important' property to z-index to fix display overlay issue.
- Bugfix: Localization: correct arguments for plugin textdomain load function.
- Bugfix: Reference container, tooltips: URL wrap: specifically catch the quotation mark.
- Adding: Footnotes mention in the footer: more options.

= 2.1.6 =
- Bugfix: Priority levels: set the_content priority level to 98 to prevent plugin conflict, thanks to @marthalindeman bug report.
- Bugfix: Tooltips: set z-index to maximum 2147483647 to address display issues with overlay content, thanks to @russianicons bug report.
- Bugfix: Reference container, tooltips: URL wrap: fix regex, thanks to @a223123131 bug report.
- Bugfix: Dashboard: URL wrap: add option to properly enable/disable URL wrap.
- Update: Dashboard: reorder tabs and update tab labels.
- Bugfix: Dashboard: remove Expert mode enable setting since permanently enabled as 'Priority'.
- Bugfix: Dashboard: fix punctuation-related localization issue by including colon in labels.
- Bugfix: Localization: conform to WordPress plugin language file name scheme, thanks to @nikelaos bug report.

= 2.1.5 =
- Bugfix: Reference container, tooltips: URL wrap: exclude image source too, thanks to @bjrnet21 bug report.

= 2.1.4 =
- Bugfix: Scroll offset: make configurable to fix site-dependent issues related to fixed headers.
- Bugfix: Scroll duration: make configurable to conform to website content and style requirements.
- Bugfix: Tooltips: make display delays and fade durations configurable to conform to website style.
- Bugfix: Tooltips: Styling: fix font size issue by adding font size to settings with legacy as default.
- Bugfix: Reference container: fix layout by optionally enqueuing additional stylesheet (depends on theme).
- Bugfix: Reference container: fix layout issues by moving backlink column width to settings.
- Bugfix: Reference container: make separating and terminating punctuation optional and configurable, thanks to @docteurfitness issue report and code contribution.
- Bugfix: Reference container: Backlinks: fix stacked enumerations by adding optional line breaks.
- Bugfix: Tooltips: Read-on button: Label: prevent line breaks.
- Bugfix: Referrers and backlinks: Styling: make link elements optional to fix issues, thanks to @docteurfitness issue report and code contribution.
- Bugfix: Referrers: Styling: disable hover underline.
- Bugfix: Reference container, tooltips: fix line wrapping of URLs (hyperlinked or not) based on pattern, not link element.
- Bugfix: Reference container: Backlink symbol: support for appending when combining identicals is on.
- Bugfix: Reference container: Backlinks: deprioritize hover underline to ease customization.
- Bugfix: Reference container: Backlinks: fix line breaking with respect to separators and terminators.
- Bugfix: Reference container: Label: delete overflow hidden rule.
- Bugfix: Reference container: Expand/collapse button: same padding to the right for right-to-left.
- Bugfix: Reference container: Styles: re-add the class dedicated to combined footnotes indices.
- Bugfix: Dashboard: move arrow settings from Customize to Settings > Reference container to reunite and fix issue with new heading wording.
- Bugfix: Dashboard: Main settings: fix layout, raise shortcodes to top.
- Bugfix: Dashboard: Tooltip settings: Truncation length: change input box type from text to numeric.
- Update: Dashboard: Notices: use explicit italic style.
- Bugfix: Dashboard: Other settings: Excerpt: display guidance next to select box, thanks to @nikelaos bug report.
- Bugfix: WordPress hooks: the_content: set priority to 1000 as a safeguard.
- Update: Dashboard: Expert mode: streamline and update description for hooks and priority levels.

= 2.1.3 =
- Bugfix: Hooks: disable widget_text hook by default to fix accordions declaring headings as widgets.
- Bugfix: Hooks: disable the_excerpt hook by default to fix issues, thanks to @nikelaos bug report.
- Bugfix: Reference container: fix column width when combining turned on by reverting new CSS class to legacy.
- Bugfix: Reference container: fix width in mobile view by URL wrapping for Unicode-non-conformant browsers, thanks to @karolszakiel bug report.
- Bugfix: Reference container: table cell backlinking if index is single and combining identicals turned on.
- Bugfix: Styling: raise Custom CSS priority to override settings.
- Bugfix: Styling: Tooltips: raise settings priority to override theme stylesheets.

= 2.1.2 =
- Bugfix: Reference container: Backlinks: no underline on hover cell when combining identicals is on.
- Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos bug report.
- Update: Dashboard: WordPress documentation URLs of the hooks.
- Update: Dashboard: feature description for the hooks priority level settings, thanks to @nikelaos bug report.

= 2.1.1 =
- Bugfix: Referrers, reference container: Combining identical footnotes: fix dead links and ensure referrer-backlink bijectivity, thanks to @happyches bug report.
- Bugfix: Dashboard: priority level setting for the_content hook, thanks to @imeson bug report.
- Update: Libraries: jQuery Tools: redact (comment out) all 6 instances of deprecated function jQuery.browser(), thanks to @bjrnet21 @cconser @vyassuresh @spaceling @widecast @olivlyon @maxident bug reports.
- Bugfix: Libraries: jQuery Tools: complete minification.
- Bugfix: Libraries: make script loads depend on tooltip implementation option.
- Bugfix: Libraries: jQuery UI: properly pick the libraries registered by WordPress needed for tooltips.
- Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
- Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
- Bugfix: Reference container: Footnote number links: disable bottom border for theme compatibility.
- Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
- Bugfix: Reference container: option to append symbol (prepended by default), thanks to @spaceling code contribution.
- Bugfix: Reference container: Table rows: fix top and bottom padding.
- Bugfix: Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report.
- Bugfix: Referrers: line height 0 to fix superscript, thanks to @cwbayer bug report.
- Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
- Bugfix: Tooltips: add delay (400ms) before fade-out to fix UX wrt links and Read-on button.
- Bugfix: Tooltips: fix line breaking for hyperlinked URLs in Unicode-non-compliant user agents, thanks to @andreasra bug report.
- Bugfix: Formatting: disable overline showing in some themes on hovered backlinks.

= 2.1.0 =
- Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
- Bugfix: Referrers: disable bottom border for theme compatibility.
- Update: Accessibility: add 'speaker-mute' class to reference container.
- Bugfix: Dashboard: Layout: add named selectors to limit applicability of styles.
- UPDATE: Hooks: remove 'the_post', the plugin stops supporting this hook.

= 2.0.8 =
- BUGFIX: Priority level back to PHP_INT_MAX (need to get in touch with other plugins).

= 2.0.7 =
- BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
- Update: Set priority level back to 10 assuming it is unproblematic.
- Update: Added backwards compatible support for legacy arrow and index placeholders in template.
- Update: Settings defaults adjusted for better and more up-to-date tooltip layout.

= 2.0.6 =
- Bugfix: Infinite scroll: debug autoload by adding post ID, thanks to @docteurfitness code contribution.
- Bugfix: Referrers: delete vertical align tweaks, for cross-theme and user agent compatibility.
- Bugfix: Reference container: fix line breaking behavior in footnote number clusters.
- Bugfix: Reference container: auto-extending column to fit widest, to fix display with short note texts.
- Bugfix: Reference container: IDs: slightly increased left padding.
- Bugfix: Translations: fix spelling error and erroneously changed word in en_GB and en_US.
- Bugfix: Typesetting: discard the dot after footnote numbers as not localizable (should be optional).
- Bugfix: Reference container: Collapse button fully clickable, not sign only.
- Bugfix: Reference container: Collapse button 'collapse' with minus sign not hyphen-minus.
- Update: Tooltips: set display predelay to 0 for responsiveness (was 800 since 2.0.0, 400 before).
- Update: Tooltips: set fade duration to 200ms both ways (was 200 in and 2000 out since 2.0.0, 0 in and 100 out before).
- BUGFIX: Priority level back to PHP_INT_MAX (ref container positioning not this plugin’s responsibility).
- Update: Scroll offset: raise percentage from 12% to a safer 20% inner window height, by lack of configurability.

= 2.0.5 =
- Bugfix: Reference container: fix relative position through priority level, thanks to @june01 @imeson @spaceling bug reports, thanks to @spaceling code contribution.
- Bugfix: Reference container: unset width of text column to fix site issues.
- Update: Hooks: Default-enable all hooks to prevent footnotes from seeming broken in some parts.
- Bugfix: Tooltips: Restore cursor shape 'pointer' over Read-on button after hard link removal.
- Bugfix: Settings stylesheet: unenqueue to fix input boxes on public pages (enqueued for 2.0.4).

= 2.0.4 =
- Update: Restore arrow settings to customize or disable the now prepended arrow symbol.
- Update: Libraries: Load jQuery UI from WordPress, thanks to @check2020de issue report.
- Bugfix: Referrers and backlinks: remove hard links to streamline browsing history, thanks to @theroninjedi47 bug report.
- Bugfix: Reference container: remove inconvenient left/right cellpadding.
- Bugfix: Tooltips: improve layout with inherited font size by lower line height.
- Bugfix: Tooltips: 'Continue reading' button: disable default underline.
- Bugfix: Translations: review all locales (en, de, es, fr), synced ref line # with edited code.
- Bugfix: Dashboard: fix display of two headings containing the logo.

= 2.0.3 =
- Bugfix: Reference container: Self-adjusting width of ID column but hidden overflow.
- Update: Reference container: clarify backlink semantics by prepended transitional up arrow, thanks to  bug report.
- Bugfix: Fragment IDs: Prepended post ID to footnote number.
- Bugfix: External stylesheets cache busting: add plugin version number argument in enqueuing function call.
- Bugfix: Print style: prevent a page break just after the reference container label.
- Bugfix: Print style: Hide reference collapse button.
- Update: Reference container: Headline: remove padding before reference container label.
- Update: Scroll offset: raise percentage from 5% to a safer 12% inner window height, by lack of setting.

= 2.0.2 =
- Bugfix: Reference container: restore expand/collapse button in the template, thanks to @ragonesi bug report.
- Bugfix: Dashboard: Custom CSS: Available selectors: fix display of the last item.
- Bugfix: Referrers and backlinks: restore default link color on screen, set color to inherit in print.
- Bugfix: Referrers: disable text decoration underline by default, enable underline on hover.

= 2.0.1 =
- Bugfix: Reference container: enforce borderless table cells, thanks to @ragonesi bug report.
- Update: Translations: revised fr_FR.

= 2.0.0 =
- Major contributions taken from WordPress user pewgeuges, all details here https://github.com/media-competence-institute/footnotes/blob/master/README.md:
- Update: **symbol for backlinks** removed
- Update: hyperlink moved to the reference number
- Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett @twellve_million bug reports, thanks to @vonpiernik code contribution.
- Update: Libraries: jQuery Tools: add condition whether deprecated function jQuery.browser() exists, thanks to @vonpiernik code contribution.
- Bugfix: Localization: correct function call apply_filters() with all required arguments after PHP 7.1 promoted warning to error, thanks to @matkus2 bug report and code contribution.
- Bugfix: footnote links script independent
- Bugfix: Get the “Continue reading” link to work in the mouse-over box
- Bugfix: Debug printed posts and pages
- Bugfix: Display of combined identical notes
- Update: Adjusted scrolling time and offset
- Bugfix: Reference container: no borders around footnotes, thanks to @ragonesi bug report.
- Bugfix: Mouse-over box display timing
- Update: Translations: revised de_AT, de_DE, en_GB, en_US, es_ES

= 1.6.6 =
- Beginning of translation to French

= 1.6.5 =
- Bugfix: Improve widgets registration, thanks to @felipelavinz code contribution.
- Update: Fix for deprecated PHP function create_function(), thanks to @psykonevro @daliasued bug reports, thanks to @felipelavinz code contribution.
- Update: The CSS has been modified in order to show the tooltip numbers a little less higher than text
- Bugfix: Dashboard: fix error on demo under the Preview tab.

= 1.6.4 =
- Update: replace deprecated function WP_Widget() with recommended __construct(), thanks to @dartiss code contribution.
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
- Adding: Setting to customize the mouse-over box shadow
- Adding: Translation: United States
- Adding: Translation: Austria
- Adding: Translation: Spanish (many thanks to Pablo L.)
- Update: Translations (de_DE and en_GB)
- Update: Changed Plugins init file name to improve performance (Re-activation of the Plugin is required)
- Update: ManFisher note styling
- Update: Tested with latest nightly build of WordPress 4.1
- Bugfix: Avoid multiple IDs for footnotes when multiple reference containers are displayed

= 1.5.7 =
- Adding: Setting to define the positioning of the mouse-over box
- Adding: Setting to define an offset for the mouse-over box (precise positioning)
- Bugfix: Target element to move down to the reference container is the footnote index instead of the arrow (possibility to hide the arrow)
- Bugfix: Rating calculation for the 'other plugins' list

= 1.5.6 =
- **IMPORTANT**: We have changed the html tag for the superscript. Please check and update your custom CSS.
- Adding: .pot file to enable Translations for everybody
- Adding: Settings to customize the mouse-over box (color, background color, border, max. width)
- Update: Translation file names
- Update: Translation EN and DE
- Update: Styling of the superscript (need to check custom CSS code for the superscript)
- Update: Description of CSS classes for the 'customize CSS' text area
- Bugfix: Removed 'a' tag around the superscript for Footnotes inside the content to avoid page reloads (empty href attribute)
- Bugfix: Avoid Settings fallback to its default value after submit an empty value for a setting
- Bugfix: Enable multiple WP_Post objects for the_post hook

= 1.5.5 =
- Adding: Expert mode setting
- Adding: Activation and Deactivation of WordPress hooks to look for Footnotes (expert mode)
- Adding: WordPress hooks: 'the_title' and 'widget_title' (default: disabled) to search for Footnote short codes
- Bugfix: Default value for the WordPress hook the_post to be disabled (adds Footnotes twice to the Reference container)
- Bugfix: Activation, Deactivation and Uninstall hook class name
- Bugfix: Add submenu pages only once for each ManFisher WordPress Plugin
- Bugfix: Display the Reference container in the Footer correctly

= 1.5.4 =
- Adding: Setting to enable an excerpt of the Footnotes mouse-over box text (default: disabled)
- Adding: Setting to define the maximum length of the excerpt displayed in the mouse-over box (default: 150 characters)
- Update: Detail information about other Plugins from ManFisher (rating, downloads, last updated, Author name/url)
- Update: Receiving list of other Plugins from the Developer Team from an external server
- Update: Translations (EN and DE)
- Bugfix: Removed hard coded position of the 'ManFisher' main menu page (avoid errors with other Plugins)
- Bugfix: Changed function name (includes.php) to be unique (avoid errors with other Plugins)
- Bugfix: Try to replace each appearance of Footnotes in the current Post object loaded from the WordPress database

= 1.5.3 =
- Adding: Developer's homepage to the 'other Plugins' list
- Update: Smoothy scroll to an anchor using Javascript
- Bugfix: Set the vertical align for each cell in the Reference container to TOP

= 1.5.2 =
- Adding: Setting to enable/disable the mouse-over box
- Adding: Current WordPress Theme to the Diagnostics sub page
- Adding: ManFisher note in the "other Plugins" sub page
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
- Adding: Grouped the Plugin Settings into a new Menu Page called "ManFisher Plugins"
- Adding: Sub Page to list all other Plugins of the Contributors
- Adding: Hyperlink to manfisher.eu in the "other plugins" page
- Update: Refactored the whole source code
- Update: Moved the Diagnostics Sections to into a new Sub Page called "Diagnostics"
- Bugfix: Line up Footnotes with multiple lines in the Reference container
- Bugfix: Load text domain
- Bugfix: Display the Footnotes button in the plain text editor of posts/pages

= 1.4.0 =
- Feature: WPML Config XML file for easy multi language string translation (WPML String Translation Support File)
- Update: Changed e-Mail support address to the WordPress support forum
- Update: Language EN and DE
- Adding: Tab for Plugin Diagnostics
- Adding: Donate link to the installed Plugin overview page
- Adding: Donate button to the "HowTo" tab

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
- Adding: Setting to customize the hyperlink symbol in der reference container for each footnote reference
- Adding: Setting to enter a user defined hyperlink symbol
- 

= 1.3.1 =
- Bugfix: Allow settings to be empty
- Bugfix: Removed space between the hyperlink and superscript in the footnotes index
- Adding: Setting to customize the text before and after the footnotes index in superscript

= 1.3.0 =
- Bugfix: Changed tooltip class to be unique
- Bugfix: Changed superscript styling to not manipulate the line height
- Bugfix: Changed styling of the footnotes text in the reference container to avoid line breaks
- Update: Reformatted code
- Adding: new settings tab for custom CSS settings

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
- Adding: Buttons next to the reference label to expand/collapse the reference container if set to "collapse by default"
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
- Adding: Link to the wordpress.org support page in the plugin main page
- Update: Changed plugin URL from GitHub to WordPress
- Bugfix: Uninstall function to really remove all settings done in the settings page
- Bugfix: Load default settings after plugin is installed
- Update: Translation for support link and new setting option
- Adding: Label to display the user the short code to not display the 'love me' slug

= 1.1.0 =
- Update: Global styling for the public plugin name
- Update: Easier usage of the public plugin name in translations
- Update: New Layout for the settings page to group similar settings to get a better overview
- Update: Display settings submit button only if there is at least 1 editable setting in the current tab
- Adding: Setting where the reference container appears on public pages (needs some corrections!)
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
- Adding: Inspirational Screenshots for further development
- Adding: Settings screenshot
- Update: i18n fine-tuning

= 1.0.4 =
- Update: replacing function when footnote is a link (bugfix)
- Footnote hover box remains until cursor leaves footnote or hover box
- Links in the footnote hover box are click able
- Adding: setting to allow footnotes on Summarized Posts
- Adding: setting to tell the world you're using footnotes plugin
- Adding: setting for the counter style of the footnote index
  - Arabic Numbers (1, 2, 3, 4, 5, ...)
  - Arabic Numbers leading 0 (01, 02, 03, 04, 05, ...)
  - Latin Characters lower-case (a, b, c, d, e, ...)
  - Latin Characters upper-case (A, B, C, D, E, ...)
  - Roman Numerals (I, II, III, IV, V, ...)
- Adding: a link to the WordPress plugin in the footer if the WP-admin accepts it
- Update: translations for the new settings
- Switch back the version numbering scheme to have 3 digits

= 1.0.3 =
- Adding: setting to use personal starting and ending tag for the footnotes
- Update: translations for the new setting
- Update: reading settings and fallback to default values (bugfix)

= 1.0.2 =
- Adding: setting to collapse the reference container by default
- Adding: link behind the footnotes to automatically jump to the reference container
- Adding: function to easy output input fields for the settings page
- Update: translation for the new setting

= 1.0.1 =
- Separated functions in different files for a better overview
- Adding: a version control to each file / class / function / variable
- Adding: layout for the settings menu, settings split in tabs and not a list-view
- Update: Replacing footnotes in widget texts will show the reference container at the end of the page (bugfix)
- Update: translations for EN and DE
- Changed version number from 3 digits to 2 digits

= 1.0.0 =
- First development Version of the Plugin

== Upgrade Notice ==
to upgrade our plugin is simple. Just update the plugin within your WordPress installation.
To cross-upgrade from other footnotes plugins, there will be a migration assistant in the future
