=== Plugin Name ===
Contributors: Aricura, mark.cheret
Tags: footnote, footnotes, smart, bibliography, formatting, notes, Post, posts, reference, referencing
Requires at least: 3.9
Tested up to: 3.9.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Stable tag: 1.0.5

== Description ==

footnotes gives you the ability to display decently-formated footnotes on your WordPress Pages or Posts.
footnotes aims to be the all-in-one solution that ships with a set of sane defaults
(those footnotes we know from offline publishing) but also give the user control over how their footnotes are being displayed.

== Frequently Asked Questions ==

= How do I use this Plugin? =

It's relatively simple. Check out [the manual](https://github.com/markcheret/footnotes#footnotes).

= Is your Plugina copy of footnotes x? =

No, this Plugin has been written from scratch. Of course some inspirations were taken from other plugins.

== Installation ==
* Download the latest version from GitHub (https://github.com/media-competence-institute/footnotes)
* in the bottom right there is a `Download ZIP` button
* Visit your WordPress Admin area
* Navigate to `Plugins\Add`
* Select the Tab `Upload`
* Upload the previously downloaded .zip file and hit `Install`
* Activate the Plugin

== Screenshots ==
coming soon

== Changelog ==

= 1.0.5 =
The Plugin has been submitted to wordpress.org for review and (hopefully) publication.
* Update: Plugin description for public directories (WordPress.org and GitHub)
* Feature: the **footnotes** WordPress Plugin now has its very own CI
  * Update: Styling
  * Update: Settings to support the styling
* Add: Inspirational Screenshots for further development
* Add: Settings screenshot
* Update: i18n fine-tuning

= 1.0.4 =
* Updated replacing function when footnote is a link (bugfix)
* Footnote hover box remains until cursor leaves footnote or hover box
* Links in the footnote hover box are click able
* New setting to allow footnotes on Summarized Posts
* New setting to tell the world you're using footnotes plugin
* New setting for the counter style of the footnote index
** Arabic Numbers (1, 2, 3, 4, 5, ...)
** Arabic Numbers leading 0 (01, 02, 03, 04, 05, ...)
** Latin Characters lower-case (a, b, c, d, e, ...)
** Latin Characters upper-case (A, B, C, D, E, ...)
** Roman Numerals (I, II, III, IV, V, ...)
* Adding a link to the WordPress plugin in the footer if the WP-admin accepts it
* Updated translations for the new settings
* re-changed the version number to have 3 digits

= 1.0.3 =
* New setting to use personal starting and ending tag for the footnotes
* Updated translations for the new setting
* Updated reading settings and fallback to default values (bugfix)

= 1.0.2 =
* New setting to collapse the reference container by default
* Added link behind the footnotes to automatically jump to the reference container
* New function to easy output input fields for the settings page
* Updated translation for the new setting

= 1.0.1 =
* Separated functions in different files for a better overview
* Added a version control to each file / class / function / variable
* New layout for the settings menu, settings split in tabs and not a list-view
* Replacing footnotes in widget texts will show the reference container at the end of the page (bugfix)
* Updated translations for EN and DE
* Changed version number from 3 digits to 2 digits

= 1.0.0 =
* First development Version of the Plugin

== Upgrade Notice ==
to upgrade our plugin is simple. Just update the plugin within your WordPress installation.
To cross-upgrade from other footnotes plugins, there will be a migration assistant in the future
