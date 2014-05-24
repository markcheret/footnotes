=== Plugin Name ===
Contributors: Aricura, mark.cheret
Tags: footnote, footnotes, bibliography, formatting, notes, Post, posts, reference, referencing
Requires at least: 3.9
Tested up to: 3.9.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Stable Tag: 1.1.1

== Description ==

footnotes gives you the ability to display decently-formated footnotes on your WordPress Pages or Posts.
footnotes aims to be the all-in-one solution that ships with a set of sane defaults
(those footnotes we know from offline publishing) but also give the user control over how their footnotes are being displayed.

footnotes displays all footnote texts found within the customizable shortcodes below the footer of your website as a styled list of references with backlinks to the actual footnote. In future releases of the plugin, you can decide, where the reference list is displayed.

The current version is available on wordpress.org:
http://downloads.wordpress.org/plugin/footnotes.zip

Development of the plugin is an open process. Latest code is available on wordpress.org, please report feature requests and bugs on GitHub:
https://github.com/media-competence-institute/footnotes

== Frequently Asked Questions ==

= Is your Plugin a copy of footnotes x? =

No, this Plugin has been written from scratch. Of course some inspirations on how to do or how to not do things were taken from other plugins.

== Installation ==
- Visit your WordPress Admin area
- Navigate to `Plugins\Add`
- Install the latest version from WordPress.org
- Activate the Plugin

== Screenshots ==
1. find the footnotes plugin in the Settings Menu
2. an overview of the currently possible settings in footnotes
3. the HowTo section in the footnotes settings

== Changelog ==

= 1.2.0 =
- Feature: New button in the WYSIWYG editor and in the plain text editor to easily implement the footnotes tag
- Feature: Icon for the WYSIWYG-editor button
- Feature: Pre defined footnote short codes
- Experimental: User defined short code for defining footnotes
- Experimental: Plugin Widget to define where the reference container should appear when set to "widget area"
- Update: Moved footnotes 'love' settings to a separate container
- Bugfix: Setting for the position of the "reference container" works for the options "footer", "end of post" and "widget area"
- Update: Translation for new settings and for the Widget description

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
