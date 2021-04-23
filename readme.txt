=== footnotes ===
Contributors: mark.cheret, lolzim, rumperuu, aricura, misfist, ericakfranz, milindmore22, westonruter, dartiss, derivationfr, docteurfitness, felipelavinz, martinneumannat, matkus2, meglio, spaceling, vonpiernik, pewgeuges
Donate link: https://cheret.org/footnotes/
Tags: footnote, footnotes, bibliography, formatting, notes, Post, posts, reference, referencing
Requires at least: 3.9
Tested up to: 5.7
Requires PHP: 7.0
Stable Tag: 2.7.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

footnotes lets you easily add highly-customisable footnotes on your WordPress Pages and Posts.

== Description ==

**footnotes** aims to be the all-in-one solution for displaying an automatically generated list of references on your Page or Post. The Plugin ships with a set of defaults while also empowering you to control how your footnotes are being displayed.
**footnotes** gives you the ability to display well-formatted footnotes on your WordPress Pages and Posts, as well as in post excerpts with fully functional tooltips if enabled.

Featured on [wpmudev][wpmudev] - cheers for the review, folks!

https://www.youtube.com/watch?v=HzHaMAAJwbI

[wpmudev]: http://premium.wpmudev.org/blog/12-surprisingly-useful-wordpress-plugins-you-dont-know-about/

= Main Features =

- Fully-customizable **footnote** start and end shortcodes;
- styled hyperlink tooltips;
- responsive reference container with customisable position;
- ability to display reference container inside a widget;
- wide choice of numbering styles;
- freely-configurable optional backlink symbol;
- configurable footnote appearance; and
- shortcodes button in Post editor.

== Installation ==

1. Go to the WordPress admin. dashboard;
1. navigate to ‘Plugins’ > ‘Add’;
1. search for **footnotes**;
1. install the latest version of this Plugin from WordPress.org; and
1. activate the Plugin.
 
Alternatively:

1. Download an archive of the Plugin (`footnotes.zip`);
1. extract the archive into the `wp-content/plugins/` directory; and
1. activate the plugin through the 'Plugins' menu in WordPress.
 
This second method can be used to install previous versions of the Plugin, which can be downloaded from WordPress.org [here][previous-versions].

[previous-versions]: https://wordpress.org/plugins/footnotes/advanced/#plugin-download-history-stats

== Frequently Asked Questions ==

= Is your Plugin a copy of footnotes *x*? =

No, this Plugin has been written from scratch. Of course some inspirations on how to do or how to not do things were taken from other plugins.

= Your Plugin is awesome! How do I convert my footnotes if I used one of the other footnotes plugins out there? =

* For anyone interested in converting from [FD Footnotes Plugin][fd-footnotes], see [this write-up][fd-writeup] from **footnotes** user @southwest
* From what we've researched, all other footnotes Plugins use open and close shortcodes, which can be left as-is. In the **footnotes** settings menu, you can setup **footnotes** to use the existing (i.e., previously-used) shortcodes. Too easy? Yippy Ki-Yey!

[fd-footnotes]: https://wordpress.org/plugins/fd-footnotes/
[fd-writeup]: https://wordpress.org/support/topic/how-to-make-this-footnote-style/

== Screenshots ==

1. Plugin settings can be found under the default ‘Settings’ menu.
2. Settings for the *References Container*.
3. Settings for footnotes styling.
4. Settings for **footnotes** love.
5. Other Settings.
6. The How-To section in the **footnotes** settings.
7. Here you can see the **footnotes** Plugin at work.

== Changelog ==

= 2.7.1 =
- Bugfix: Stylesheets: namespace collapsed CSS class, thanks to @cybermrmotte @markyz89 bug reports.
- Dashboard: move Plugin settings under default WP Settings menu.
- Bugfix: Footnotes: fix bug when using multiple paragraphs in footnotes.
- Documentation: remove outdated MCI/ManFisher references.
- Documentation: split changelog into seperate file.

== Upgrade Notice ==
 
= 2.7.1 =
This release resolves a CSS class conflict with the commonly-used `.collapsed` class.

== Usage ==

These are a few examples of possible ways to delimit your footnotes:

1. Your awesome text((with an awesome footnote))
2. Your awesome text[ref]with an awesome footnote[/ref]
3. Your awesome text&lt;fn&rt;with an awesome footnote&lt;/fn&gt;
4. Your awesome text`custom-start-shortcode`with an awesome footnote`custom-end-shortcode`

== Support ==

Please report feature requests, bugs and other support related questions in the [WordPress Support Forum][wp-support-forum].

Speak your mind, unload your burden, bring it up, and feel free to [post your rating and review!][ratings].

[wp-support-forum]: https://wordpress.org/support/plugin/footnotes
[ratings]: https://wordpress.org/support/plugin/footnotes/reviews/
