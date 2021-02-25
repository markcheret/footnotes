<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the core function of the Plugin - Search and Replace the Footnotes.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 *
 * @since 2.0.0  Bugfix: various.
 * @since 2.0.4  Bugfix: Referrers and backlinks: remove hard links to streamline browsing history, thanks to @theroninjedi47 bug report.
 * @since 2.0.5  Bugfix: Reference container: fix relative position through priority level, thanks to @june01 @imeson @spaceling bug reports, thanks to @spaceling code contribution.
 * @since 2.0.5  Update: Hooks: Default-enable all hooks to prevent footnotes from seeming broken in some parts.
 * @since 2.0.6  Bugfix: Infinite scroll: debug autoload by adding post ID, thanks to @docteurfitness code contribution.
 * @since 2.0.6  Bugfix: Priority level back to PHP_INT_MAX (ref container positioning not this plugin’s responsibility).
 * @since 2.0.6  Bugfix: Reference container: fix line breaking behavior in footnote number clusters.
 * @since 2.0.7  BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
 * @since 2.0.9  Bugfix: Remove the_post hook  2020-11-08T1839+0100.
 * @since 2.1.0  Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
 * @since 2.1.1  Bugfix: Referrers, reference container: Combining identical footnotes: fix dead links and ensure referrer-backlink bijectivity, thanks to @happyches bug report.
 * @since 2.1.1  Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
 * @since 2.1.1  Bugfix: Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report.
 * @since 2.1.1  Bugfix: Reference container: option to append symbol (prepended by default), thanks to @spaceling code contribution.
 * @since 2.1.1  Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
 * @since 2.1.1  Bugfix: Dashboard: priority level setting for the_content hook, thanks to @imeson bug report.
 * @since 2.1.1  Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
 * @since 2.1.1  Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
 * @since 2.1.2  Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos bug report.
 * @since 2.1.3  Bugfix: Reference container: fix width in mobile view by URL wrapping for Unicode-non-conformant browsers, thanks to @karolszakiel bug report.
 * @since 2.1.4  Bugfix: Styling: Referrers and backlinks: make link elements optional to fix issues.
 * @since 2.1.4  Bugfix: Reference container: Backlink symbol: support for appending when combining identicals is on.
 * @since 2.1.4  Bugfix: Reference container: make separating and terminating punctuation optional and configurable, thanks to @docteurfitness issue report and code contribution.
 * @since 2.1.4  Bugfix: Reference container: Backlinks: fix stacked enumerations by adding optional line breaks.
 * @since 2.1.4  Bugfix: Reference container: fix layout issues by moving backlink column width to settings.
 * @since 2.1.4  Bugfix: Styling: Tooltips: fix font size issue by adding font size to settings with legacy as default.
 * @since 2.1.4  Bugfix: Scroll offset: make configurable to fix site-dependent issues related to fixed headers.
 * @since 2.1.4  Bugfix: Scroll duration: make configurable to conform to website content and style requirements.
 * @since 2.1.4  Bugfix: Tooltips: make display delays and fade durations configurable to conform to website style.
 * @since 2.1.4  Bugfix: Referrers and backlinks: Styling: make link elements optional to fix issues, thanks to @docteurfitness issue report and code contribution.
 * @since 2.1.4  Bugfix: Reference container, tooltips: fix line wrapping of URLs (hyperlinked or not) based on pattern, not link element.
 * @since 2.1.4  Bugfix: Reference container: Backlink symbol: support for appending when combining identicals is on.
 * @since 2.1.4  Bugfix: Reference container: Backlinks: fix line breaking with respect to separators and terminators.
 * @since 2.1.5  Bugfix: Reference container, tooltips: URL wrap: exclude image source too, thanks to @bjrnet21 bug report.
 * @since 2.1.6  Bugfix: Reference container, tooltips: URL wrap: fix regex, thanks to @a223123131 bug report.
 * @since 2.1.6  Bugfix: Dashboard: URL wrap: add option to properly enable/disable URL wrap.
 * @since 2.2.0  Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
 * @since 2.2.3  Bugfix: Custom CSS: insert new CSS in the public page header element after existing CSS.
 * @since 2.2.5  Bugfix: Reference container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe bug report.
 * @since 2.2.5  Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
 * @since 2.2.5  Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
 * @since 2.2.5  Update: Tooltips: Alternative tooltips: connect to position/timing settings (for themes not supporting jQuery tooltips).
 * @since 2.2.6  Bugfix: Reference container, tooltips: URL wrap: make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
 * @since 2.2.7  Bugfix: Reference container, tooltips: URL wrap: remove a bug introduced in the regex, thanks to @rjl20 @spaceling @lukashuggenberg @klusik @friedrichnorth @bernardzit bug reports.
 * @since 2.2.8  Bugfix: Reference container, tooltips: URL wrap: correctly make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
 * @since 2.2.9  Bugfix: Reference container, tooltips: URL wrap: account for RFC 2396 allowed characters in parameter names.
 * @since 2.2.9  Bugfix: Reference container, widget_text hook: support for multiple containers in a page, thanks to @justbecuz bug report.
 * @since 2.2.9  Bugfix: Reference container, tooltips: URL wrap: exclude URLs also where the equals sign is preceded by an entity or character reference.
 * @since 2.2.10 Bugfix: Reference container: add option for table borders to restore pre-2.0.0 design, thanks to @noobishh issue report.
 * @since 2.2.10 Bugfix: Reference container, tooltips: URL wrap: support also file transfer protocol URLs.
 * @since 2.3.0  Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
 * @since 2.3.0  Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro bug report, thanks to @martinneumannat code contribution.
 * @since 2.3.0  Bugfix: Dashboard: Custom CSS: swap migration Boolean, meaning 'show legacy' instead of 'migration complete', due to storage data structure constraints.
 * @since 2.4.0  Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
 * @since 2.4.0  Bugfix: Scroll offset: initialize to safer one third window height for more robustness, thanks to @lukashuggenberg bug report.
 * @since 2.4.0  Bugfix: Reference container: Label: set empty label to U+202F NNBSP for more robustness, thanks to @lukashuggenberg feedback.
 * @since 2.4.0  Bugfix: Templates: optimize template load and processing based on settings, thanks to @misfist code contribution.
 * @since 2.4.0  Bugfix: Process: initialize hard link address variables to empty string to fix 'undefined variable' bug, thanks to @a223123131 bug report.
 * @since 2.5.0  Bugfix: Hooks: support footnotes on category pages, thanks to @vitaefit bug report, thanks to @misfist code contribution.
 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
 * @since 2.5.1  Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
 * @since 2.5.2  Update: Tooltips: ability to display dedicated content before `[[/tooltip]]`, thanks to @jbj2199 issue report.
 * @since 2.5.3  Bugfix: Reference container, tooltips: URL wrap: exclude URL pattern as folder name in Wayback Machine URL, thanks to @rumperuu bug report.
 * @since 2.5.4  Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
 * @since 2.5.4  Bugfix: Reference container, tooltips: URL wrap: account for leading space in value, thanks to @karolszakiel example provision.
 * @since 2.5.4  Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
 * @since 2.5.4  Bugfix: Tooltips: fix display in Popup Maker popups by correcting a coding error.
 * @since 2.5.5  Bugfix: Process: fix numbering bug impacting footnote #2 with footnote #1 close to start, thanks to @rumperuu bug report, thanks to @lolzim code contribution.
 * @since 2.5.6  Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
 * @since 2.5.7  Bugfix: Process: fix footnote duplication by emptying the footnotes list every time the search algorithm is run on the content, thanks to @inoruhana bug report.
 */

// If called directly, abort:
defined( 'ABSPATH' ) or die;

/**
 * Searches and replaces the footnotes.
 * Generates the reference container.
 *
 * @since 1.5.0
 */
class MCI_Footnotes_Task {

	/**
	 * Contains all footnotes found on current public page.
	 *
	 * @since 1.5.0
	 * @var array
	 */
	public static $a_arr_footnotes = array();

	/**
	 * Flag if the display of 'LOVE FOOTNOTES' is allowed on the current public page.
	 *
	 * @since 1.5.0
	 * @var bool
	 */
	public static $a_bool_allow_love_me = true;

	/**
	 * Prefix for the Footnote html element ID.
	 *
	 * @since 1.5.8
	 * @var string
	 */
	public static $a_str_prefix = '';

	/**
	 * Autoload a.k.a. infinite scroll, or archive view.
	 *
	 * - Bugfix: Infinite scroll: debug autoload by adding post ID, thanks to @docteurfitness code contribution
	 *
	 * @since 2.0.6
	 * @var int
	 *
	 * @contributor @docteurfitness
	 * @link https://wordpress.org/support/topic/auto-load-post-compatibility-update/#post-13618833
	 *
	 * @reporter @docteurfitness
	 * @link https://wordpress.org/support/topic/auto-load-post-compatibility-update/
	 *
	 * As multiple posts are appended to each other, functions and fragment IDs must be disambiguated.
	 * post ID to make everything unique wrt infinite scroll and archive view.
	 */
	public static $a_int_post_id = 0;

	/**
	 * Multiple reference containers in content and widgets.
	 *
	 * - Bugfix: Reference container, widget_text hook: support for multiple containers in a page, thanks to @justbecuz bug report.
	 *
	 * @since 2.2.9
	 * @date 2020-12-25T0338+0100
	 *
	 * @reporter @justbecuz
	 * @link https://wordpress.org/support/topic/reset-footnotes-to-1/
	 * @link https://wordpress.org/support/topic/reset-footnotes-to-1/#post-13662830
	 *
	 * @var int 1; incremented every time after a reference container is inserted
	 *
	 * This ID disambiguates multiple reference containers in a page
	 * as they may occur when the widget_text hook is active and the page
	 * is built with Elementor and has an accordion or similar toggle sections.
	 */
	public static $a_int_reference_container_id = 1;

	/**
	 * Whether tooltips are enabled. Actual value depends on settings.
	 *
	 * - Bugfix: Templates: optimize template load and processing based on settings, thanks to @misfist code contribution.
	 *
	 * @since 2.4.0
	 * @date 2021-01-04T1355+0100
	 *
	 * @contributor Patrizia Lutz @misfist
	 * @link https://wordpress.org/support/topic/template-override-filter/#post-13864301
	 * @link https://github.com/misfist/footnotes/releases/tag/2.4.0d3 repository
	 * @link https://github.com/misfist/footnotes/compare/2.4.0%E2%80%A62.4.0d3 diff
	 *
	 * @var bool
	 *
	 * Template process and script / stylesheet load optimization.
	 * Streamline process depending on tooltip enabled status.
	 * Load tooltip inline script only if jQuery tooltips are enabled.
	 */
	public static $a_bool_tooltips_enabled = false;

	/**
	 * Whether alternative tooltips are enabled. Actual value depends on settings.
	 *
	 * @since 2.4.0
	 *
	 * @var bool
	 */
	public static $a_bool_alternative_tooltips_enabled = false;

	/**
	 * Hard links for AMP compatibility
	 *
	 * @since 2.0.0  Bugfix: footnote links script independent.
	 *
	 *
	 * - Bugfix: Referrers and backlinks: remove hard links to streamline browsing history, thanks to @theroninjedi47 bug report.
	 *
	 * @since 2.0.4
	 *
	 * @reporter @theroninjedi47
	 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
	 *
	 *
	 * - Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro bug report, thanks to @martinneumannat code contribution.
	 *
	 * @since 2.3.0
	 * @var bool|str|int
	 *
	 * @contributor @martinneumannat
	 * @link https://wordpress.org/support/topic/making-it-amp-compatible/
	 *
	 * @reporter @psykonevro
	 * @link https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/
	 *
	 * The official AMP plugin strips off JavaScript, breaking Footnotes’
	 * animated scrolling.
	 * When the alternative reference container is enabled, hard links are too.
	 *
	 * Used both in search() and reference_container(), these need to be class variables.
	 */
	/**
	 * Whether hard links are enabled.
	 *
	 * @since 2.3.0
	 * @var bool
	 */
	public static $a_bool_hard_links_enable = false;

	/**
	 * The referrer slug.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $a_str_referrer_link_slug = 'r';

	/**
	 * The footnote slug.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $a_str_footnote_link_slug = 'f';

	/**
	 * The slug and identifier separator.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	private static $a_str_link_ids_separator = '+';

	/**
	 * Contains the concatenated link.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $a_str_post_container_id_compound = '';

	/**
	 * Scroll offset.
	 *
	 * - Bugfix: Scroll offset: make configurable to fix site-dependent issues related to fixed headers.
	 *
	 * @since 2.1.4
	 * @date 2020-12-05T0538+0100
	 *
	 *
	 * - Bugfix: Scroll offset: initialize to safer one third window height for more robustness, thanks to @lukashuggenberg bug report.
	 *
	 * @since 2.4.0
	 * @date 2021-01-03T2055+0100
	 * @date 2021-01-04T0504+0100
	 *
	 * @reporter @lukashuggenberg
	 * @link https://wordpress.org/support/topic/2-2-6-breaks-all-footnotes/#post-13857922
	 *
	 * @var int
	 *
	 * Websites may use high fixed headers not contracting at scroll.
	 * Scroll offset may now need to get into inline CSS.
	 * Hence it needs to be loaded twice, because priority levels may not match.
	 */
	public static $a_int_scroll_offset = 34;

	/**
	 * Optional link element for footnote referrers and backlinks
	 *
	 * @since 2.0.0  add link elements along with hard links.
	 *
	 * - Bugfix: Referrers and backlinks: Styling: make link elements optional to fix issues, thanks to @docteurfitness issue report and code contribution.
	 *
	 * @since 2.1.4
	 * @date 2020-11-25T1306+0100
	 * @date 2020-11-26T1051+0100
	 *
	 * @contributor @docteurfitness
	 * @link https://wordpress.org/support/topic/update-2-1-3/#post-13704194
	 *
	 * @reporter @docteurfitness
	 * @link https://wordpress.org/support/topic/update-2-1-3/
	 *
	 * - Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro bug report, thanks to @martinneumannat code contribution.
	 *
	 * @since 2.3.0
	 * @date 2020-12-30T2313+0100
	 *
	 * @contributor @martinneumannat
	 * @link https://wordpress.org/support/topic/making-it-amp-compatible/
	 *
	 * @reporter @psykonevro
	 * @link https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/
	 *
	 * Although widely used for that purpose, hyperlinks are disliked for footnote linking.
	 * Browsers may need to be prevented from logging these clicks in the browsing history,
	 * as logging compromises the usability of the 'return to previous' button in browsers.
	 * For that purpose, and for scroll animation, this linking is performed by JavaScript.
	 *
	 * Link elements raise concerns, so that mitigating their proliferation may be desired.
	 *
	 * By contrast, due to an insufficiency in the CSS standard, coloring elements with the
	 * theme’s link color requires real link elements and cannot be done with named colors,
	 * as CSS does not support 'color: link|hover|active|visited', after the pseudo-classes
	 * of the link element.
	 *
	 * Yet styling these elements with the link color is not universally preferred, so that
	 * the very presence of these link elements may need to be avoided.
	 *
	 * @see self::$a_bool_hard_links_enable
	 *
	 * Used both in search() and reference_container(), these need to be class variables.
	 */

	/**
	 * The span element name.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $a_str_link_span = 'span';

	/**
	 * The opening tag.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $a_str_link_open_tag = '';

	/**
	 * The closing tag.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $a_str_link_close_tag = '';

	/**
	 * Dedicated tooltip text.
	 *
	 * - Update: Tooltips: ability to display dedicated content before `[[/tooltip]]`, thanks to @jbj2199 issue report.
	 *
	 * @since 2.5.2
	 * @date 2021-01-19T2223+0100
	 *
	 * @reporter @jbj2199
	 * @link https://wordpress.org/support/topic/change-tooltip-text/
	 *
	 * Tooltips can display another content than the footnote entry
	 * in the reference container. The trigger is a shortcode in
	 * the footnote text separating the tooltip text from the note.
	 * That is consistent with what WordPress does for excerpts.
	 */

	/**
	 * The tooltip delimiter shortcode.
	 *
	 * @since 2.5.2
	 * @var str
	 */
	public static $a_str_tooltip_shortcode = '[[/tooltip]]';

	/**
	 * The tooltip delimiter shortcode length.
	 *
	 * @since 2.5.2
	 * @var int
	 */
	public static $a_int_tooltip_shortcode_length = 12;

	/**
	 * Whether to mirror the tooltip text in the reference container.
	 *
	 * @since 2.5.2
	 * @var bool
	 */
	public static $a_bool_mirror_tooltip_text = false;

	/**
	 * Footnote delimiter syntax validation.
	 *
	 * - Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
	 *
	 * @since 2.4.0
	 * @date 2021-01-01T0227+0100
	 *
	 * @var bool
	 *
	 * The algorithm first checks for balanced footnote opening and closing tag short codes.
	 * The first encountered error triggers the display of a warning below the post title.
	 *
	 * Unbalanced short codes have caused significant trouble because they are hard to detect.
	 * Any compiler or other tool reports syntax errors in the first place. Footnotes’ exception
	 * is considered a design flaw, and the feature is released as a bug fix after overdue 2.3.0
	 * released in urgency to provide AMP compat before 2021.
	 */
	public static $a_bool_syntax_error_flag = true;

	/**
	 * Register WordPress Hooks to replace Footnotes in the content of a public page.
	 *
	 * @since 1.5.0
	 *
	 * @since 1.5.4  Adding: Hooks: support 'the_post' in response to user request for custom post types.
	 * @since 2.0.5  Bugfix: Reference container: fix relative position through priority level, thanks to @june01 @imeson @spaceling bug reports, thanks to @spaceling code contribution.
	 * @since 2.0.5  Update: Hooks: Default-enable all hooks to prevent footnotes from seeming broken in some parts.
	 * @since 2.0.6  Bugfix: Priority level back to PHP_INT_MAX (ref container positioning not this plugin’s responsibility).
	 * @since 2.0.7  BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
	 * @since 2.0.7  Bugfix: Set priority level back to 10 assuming it is unproblematic  2020-11-06T1344+0100.
	 * @since 2.0.8  Bugfix: Priority level back to PHP_INT_MAX (need to get in touch with other plugins).
	 * @since 2.1.0  UPDATE: Hooks: remove 'the_post', the plugin stops supporting this hook.
	 * @since 2.1.1  Bugfix: Dashboard: priority level setting for the_content hook, thanks to @imeson bug report.
	 * @since 2.1.2  Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos bug report.
	 * @since 2.5.0  Bugfix: Hooks: support footnotes on category pages, thanks to @vitaefit bug report, thanks to @misfist code contribution.
	 * @since 2.5.1  Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
	 */
	public function register_hooks() {

		/**
		 * Priority levels.
		 *
		 * - Bugfix: Reference container: fix relative position through priority level, thanks to @june01 @imeson @spaceling bug reports, thanks to @spaceling code contribution.
		 *
		 * @since 2.0.5
		 * @date 2020-11-02T0330+0100
		 * @link https://codex.wordpress.org/Plugin_API/#Hook_in_your_Filter
		 *
		 * @contributor @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13608594
		 *
		 * @reporter @june01
		 * @link https://wordpress.org/support/topic/change-the-position-5/
		 *
		 * @reporter @imeson
		 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13538345
		 *
		 *
		 * - Bugfix: Dashboard: priority level setting for the_content hook, thanks to @imeson bug report.
		 *
		 * @since 2.1.1
		 * @date 2020-11-17T0254+0100
		 *
		 * @reporter @imeson
		 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13538345
		 *
		 *
		 * - Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos bug report.
		 *
		 * @since 2.1.2
		 * @date 2020-11-19T1849+0100
		 *
		 * @reporter @nikelaos
		 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13676705
		 *
		 *
		 * Setting the_content priority to 10 instead of PHP_INT_MAX i.e. 9223372036854775807
		 * makes the footnotes reference container display beneath the post and above other
		 * features added by other plugins, e.g. related post lists and social buttons.
		 *
		 * For YARPP to display related posts below the Footnotes reference container,
		 * priority needs to be at least 1200 (i.e. 0 =< $l_int_the_content_priority =< 1200).
		 *
		 * PHP_INT_MAX cannot be reset by leaving the number box empty. because browsers
		 * (WebKit) don’t allow it, so we must resort to -1.
		 * @link https://github.com/Modernizr/Modernizr/issues/171
		 */

		// Get values from settings.
		$l_int_the_title_priority    = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL ) );
		$l_int_the_content_priority  = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL ) );
		$l_int_the_excerpt_priority  = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL ) );
		$l_int_widget_title_priority = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL ) );
		$l_int_widget_text_priority  = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL ) );

		// PHP_INT_MAX can be set by -1.
		$l_int_the_title_priority    = ( -1 === $l_int_the_title_priority ) ? PHP_INT_MAX : $l_int_the_title_priority;
		$l_int_the_content_priority  = ( -1 === $l_int_the_content_priority ) ? PHP_INT_MAX : $l_int_the_content_priority;
		$l_int_the_excerpt_priority  = ( -1 === $l_int_the_excerpt_priority ) ? PHP_INT_MAX : $l_int_the_excerpt_priority;
		$l_int_widget_title_priority = ( -1 === $l_int_widget_title_priority ) ? PHP_INT_MAX : $l_int_widget_title_priority;
		$l_int_widget_text_priority  = ( -1 === $l_int_widget_text_priority ) ? PHP_INT_MAX : $l_int_widget_text_priority;

		// Append custom css to the header.
		add_filter( 'wp_head', array( $this, 'wp_head' ), PHP_INT_MAX );

		// Append the love and share me slug to the footer.
		add_filter( 'wp_footer', array( $this, 'wp_footer' ), PHP_INT_MAX );

		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_TITLE ) ) ) {
			add_filter( 'the_title', array( $this, 'the_title' ), $l_int_the_title_priority );
		}

		// Configurable priority level for reference container relative positioning; default 98.
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_CONTENT ) ) ) {
			add_filter( 'the_content', array( $this, 'the_content' ), $l_int_the_content_priority );

			/**
			 * Hook for category pages.
			 *
			 * - Bugfix: Hooks: support footnotes on category pages, thanks to @vitaefit bug report, thanks to @misfist code contribution.
			 *
			 * @since 2.5.0
			 * @date 2021-01-05T1402+0100
			 *
			 * @contributor @misfist
			 * @link https://wordpress.org/support/topic/footnote-doesntwork-on-category-page/#post-13864859
			 *
			 * @reporter @vitaefit
			 * @link https://wordpress.org/support/topic/footnote-doesntwork-on-category-page/
			 *
			 * Category pages can have rich HTML content in a term description with article status.
			 * For this to happen, WordPress’ built-in partial HTML blocker needs to be disabled.
			 * @link https://docs.woocommerce.com/document/allow-html-in-term-category-tag-descriptions/
			 */
			add_filter( 'term_description', array( $this, 'the_content' ), $l_int_the_content_priority );

			/**
			 * Hook for popup maker popups.
			 *
			 * - Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
			 *
			 * @since 2.5.1
			 * @date 2021-01-18T2038+0100
			 *
			 * @reporter @squatcher
			 * @link https://wordpress.org/support/topic/footnotes-use-in-popup-maker/
			 */
			add_filter( 'pum_popup_content', array( $this, 'the_content' ), $l_int_the_content_priority );
		}

		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_EXCERPT ) ) ) {
			add_filter( 'the_excerpt', array( $this, 'the_excerpt' ), $l_int_the_excerpt_priority );
		}
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TITLE ) ) ) {
			add_filter( 'widget_title', array( $this, 'widget_title' ), $l_int_widget_title_priority );
		}
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TEXT ) ) ) {
			add_filter( 'widget_text', array( $this, 'widget_text' ), $l_int_widget_text_priority );
		}

		/**
		 * The the_post hook.
		 *
		 * - Adding: Hooks: support 'the_post' in response to user request for custom post types.
		 *
		 * @since 1.5.4
		 * @accountable @aricura
		 * @link https://wordpress.org/support/topic/doesnt-work-in-custon-post-types/#post-5339110
		 *
		 *
		 * - Update: Hooks: Default-enable all hooks to prevent footnotes from seeming broken in some parts.
		 *
		 * @since 2.0.5
		 * @accountable @pewgeuges
		 *
		 *
		 * - BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
		 *
		 * @since 2.0.7
		 * @accountable @pewgeuges
		 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13630114
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/#post-13630303
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/2/#post-13630799
		 * @link https://wordpress.org/support/topic/no-footnotes-anymore/#post-13813233
		 *
		 * @reporter @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13612697
		 *
		 * @reporter @markcheret on behalf of W. Beinert
		 * @link https://wordpress.org/support/topic/footnotes-now-appear-in-summaries-even-though-this-is-marked-no/
		 *
		 * @reporter @nyamachi
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/
		 *
		 * @reporter @whichgodsaves
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/#post-13622694
		 *
		 * @reporter @spiralofhope2
		 * @link https://wordpress.org/support/topic/2-0-5-broken/
		 *
		 * @reporter @mmallett
		 * @link https://wordpress.org/support/topic/2-0-5-broken/#post-13623208
		 *
		 * @reporter @andreasra
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/#post-13624091
		 *
		 * @reporter @widecast
		 * @link https://wordpress.org/support/topic/2-0-5-broken/#post-13626222
		 *
		 * @reporter @ymorin007
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/#post-13627050
		 *
		 * @reporter @markcheret on behalf of L. Smith
		 * @link https://wordpress.org/support/topic/footnotes-appear-in-random-places-on-academic-website/
		 *
		 * @reporter @tashi1es
		 * @link https://wordpress.org/support/topic/footnotes-appear-in-random-places-on-academic-website/#post-13630495
		 *
		 *
		 * - UPDATE: Hooks: remove 'the_post', the plugin stops supporting this hook.
		 *
		 * @since 2.1.0
		 * @date 2020-11-08T1839+0100
		 * @accountable @pewgeuges
		 */

		// Reset stored footnotes when displaying the header.
		self::$a_arr_footnotes      = array();
		self::$a_bool_allow_love_me = true;
	}

	/**
	 * Outputs the custom css to the header of the public page.
	 *
	 * @since 1.5.0
	 *
	 * @since 2.1.1  Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
	 * @since 2.1.1  Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
	 * @since 2.1.3  raise settings priority to override theme stylesheets
	 * @since 2.1.4  Bugfix: Tooltips: Styling: fix font size issue by adding font size to settings with legacy as default.
	 * @since 2.1.4  Bugfix: Reference container: fix layout issues by moving backlink column width to settings.
	 * @since 2.2.5  Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
	 * @since 2.2.5  Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
	 * @since 2.3.0  Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
	 * @since 2.5.4  Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
	 */
	public function wp_head() {

		// Insert start tag without switching out of PHP.
		echo "\r\n<style type=\"text/css\" media=\"all\">\r\n";

		/**
		 * Normalizes the referrers’ vertical alignment and font size.
		 *
		 * - Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
		 *
		 * @since 2.5.4
		 * @date 2021-02-12T1631+0100
		 *
		 * @reporter @tomturowski
		 * @link https://wordpress.org/support/topic/in-line-superscript-ref-rides-to-high/
		 *
		 * Cannot be included in external stylesheet, as it is only optional.
		 * The scope is variable too: referrers only, or all superscript elements.
		 */
		$l_str_normalize_superscript = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT );
		if ( 'no' !== $l_str_normalize_superscript ) {
			if ( 'all' === $l_str_normalize_superscript ) {
				echo 'sup {';
			} else {
				echo '.footnote_plugin_tooltip_text {';
			}
			echo "vertical-align: super; font-size: smaller; position: static;}\r\n";
		}

		/**
		 * Reference container display on home page.
		 *
		 * - Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
		 *
		 * @since 2.1.1
		 *
		 * @reporter @dragon013
		 * @link https://wordpress.org/support/topic/possible-to-hide-it-from-start-page/
		 */
		if ( ! MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_START_PAGE_ENABLE ) ) ) {
			echo ".home .footnotes_reference_container { display: none; }\r\n";
		}

		/**
		 * Reference container top and bottom margins.
		 *
		 * - Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
		 *
		 * @since 2.3.0
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
		 */
		$l_int_reference_container_top_margin    = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN ) );
		$l_int_reference_container_bottom_margin = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN ) );
		echo '.footnotes_reference_container {margin-top: ';
		echo empty( $l_int_reference_container_top_margin ) ? '0' : esc_html( $l_int_reference_container_top_margin );
		echo 'px !important; margin-bottom: ';
		echo empty( $l_int_reference_container_bottom_margin ) ? '0' : esc_html( $l_int_reference_container_bottom_margin );
		echo "px !important;}\r\n";

		/**
		 * Reference container label bottom border.
		 *
		 * - Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
		 * - Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
		 *
		 * @since 2.2.5
		 * @date 2020-12-18T1447+0100
		 *
		 * @reporter @markhillyer
		 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER ) ) ) {
			echo '.footnote_container_prepare > ';
			echo esc_html( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT ) );
			echo " {border-bottom: 1px solid #aaaaaa !important;}\r\n";
		}

		/**
		 * Reference container table row borders.
		 *
		 * - Bugfix: Reference container: add option for table borders to restore pre-2.0.0 design, thanks to @noobishh issue report.
		 *
		 * @since 2.2.10
		 * @date 2020-12-25T2304+0100
		 *
		 * @reporter @noobishh
		 * @link https://wordpress.org/support/topic/borders-25/
		 *
		 * TODO: use `wp_add_inline_style()` or something like that instead.
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE ) ) ) {
			echo '.footnotes_table, .footnotes_plugin_reference_row {';
			echo 'border: 1px solid #060606;';
			echo " !important;}\r\n";
			// Adapt left padding to the presence of a border.
			echo '.footnote_plugin_index, .footnote_plugin_index_combi {';
			echo "padding-left: 6px !important}\r\n";
		}

		// Ref container first column width and max-width.
		$l_bool_column_width_enabled     = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_ENABLED ) );
		$l_bool_column_max_width_enabled = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED ) );

		if ( $l_bool_column_width_enabled || $l_bool_column_max_width_enabled ) {
			echo '.footnote-reference-container { table-layout: fixed; }';
			echo '.footnote_plugin_index, .footnote_plugin_index_combi {';

			if ( $l_bool_column_width_enabled ) {

				$l_int_column_width_scalar = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR );
				$l_str_column_width_unit   = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT );

				if ( ! empty( $l_int_column_width_scalar ) ) {
					if ( '%' === $l_str_column_width_unit ) {
						if ( $l_int_column_width_scalar > 100 ) {
							$l_int_column_width_scalar = 100;
						}
					}
				} else {
					$l_int_column_width_scalar = 0;
				}

				echo ' width: ' . esc_html( $l_int_column_width_scalar ) . esc_html( $l_str_column_width_unit ) . ' !important;';
			}

			if ( $l_bool_column_max_width_enabled ) {

				$l_int_column_max_width_scalar = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR );
				$l_str_column_max_width_unit   = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT );

				if ( ! empty( $l_int_column_max_width_scalar ) ) {
					if ( '%' === $l_str_column_max_width_unit ) {
						if ( $l_int_column_max_width_scalar > 100 ) {
							$l_int_column_max_width_scalar = 100;
						}
					}
				} else {
					$l_int_column_max_width_scalar = 0;
				}

				echo ' max-width: ' . esc_html( $l_int_column_max_width_scalar ) . esc_html( $l_str_column_max_width_unit ) . ' !important;';

			}
			echo "}\r\n";
		}

		/**
		 * Hard links scroll offset.
		 *
		 * - Bugfix: Scroll offset: make configurable to fix site-dependent issues related to fixed headers.
		 *
		 * @since 2.1.4
		 *
		 * @since 2.5.6 hard links are always enabled when the alternative reference container is.
		 */
		self::$a_bool_HardLinksEnable = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_HARD_LINKS_ENABLE));

		// correct hard links enabled status depending on alternative reference container enabled status:
		$l_str_ScriptMode = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE);
		if ( $l_str_ScriptMode != 'jquery' ) {
			self::$a_bool_HardLinksEnable = true;
		}

		self::$a_int_ScrollOffset = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET));
		if (self::$a_bool_HardLinksEnable) {
			echo ".footnote_referrer_anchor, .footnote_item_anchor {bottom: ";
			echo self::$a_int_ScrollOffset;
			echo "vh;}\r\n";
		}

		/*
		 * Tooltips.
		 */
		self::$a_bool_tooltips_enabled             = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED ) );
		self::$a_bool_alternative_tooltips_enabled = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ) );

		if ( self::$a_bool_tooltips_enabled ) {

			echo '.footnote_tooltip {';

			/**
			 * Tooltip appearance: Tooltip font size.
			 *
			 * - Bugfix: Styling: Tooltips: fix font size issue by adding font size to settings with legacy as default.
			 *
			 * @since 2.1.4
			 * @date 2020-12-03T0954+0100
			 */
			echo ' font-size: ';
			if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_ENABLED ) ) ) {
				echo esc_html( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR ) );
				echo esc_html( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT ) );
			} else {
				echo 'inherit';
			}
			echo ' !important;';

			/*
			 * Tooltip Text color.
			 */
			$l_str_color = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR );
			if ( ! empty( $l_str_color ) ) {
				printf( ' color: %s !important;', esc_html( $l_str_color ) );
			}

			/*
			 * Tooltip Background color.
			 */
			$l_str_background = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND );
			if ( ! empty( $l_str_background ) ) {
				printf( ' background-color: %s !important;', esc_html( $l_str_background ) );
			}

			/*
			 * Tooltip Border width.
			 */
			$l_int_border_width = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH );
			if ( ! empty( $l_int_border_width ) && intval( $l_int_border_width ) > 0 ) {
				printf( ' border-width: %dpx !important; border-style: solid !important;', esc_html( $l_int_border_width ) );
			}

			/*
			 * Tooltip Border color.
			 */
			$l_str_border_color = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR );
			if ( ! empty( $l_str_border_color ) ) {
				printf( ' border-color: %s !important;', esc_html( $l_str_border_color ) );
			}

			/*
			 * Tooltip Corner radius.
			 */
			$l_int_border_radius = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS );
			if ( ! empty( $l_int_border_radius ) && intval( $l_int_border_radius ) > 0 ) {
				printf( ' border-radius: %dpx !important;', esc_html( $l_int_border_radius ) );
			}

			/*
			 * Tooltip Shadow color.
			 */
			$l_str_box_shadow_color = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR );
			if ( ! empty( $l_str_box_shadow_color ) ) {
				printf( ' -webkit-box-shadow: 2px 2px 11px %s;', esc_html( $l_str_box_shadow_color ) );
				printf( ' -moz-box-shadow: 2px 2px 11px %s;', esc_html( $l_str_box_shadow_color ) );
				printf( ' box-shadow: 2px 2px 11px %s;', esc_html( $l_str_box_shadow_color ) );
			}

			/**
			 * Tooltip position and timing.
			 *
			 * - Bugfix: Tooltips: make display delays and fade durations configurable to conform to website style.
			 *
			 * @since 2.1.4
			 * @date 2020-12-06T1320+0100
			 *
			 *
			 * - Update: Tooltips: Alternative tooltips: connect to position/timing settings (for themes not supporting jQuery tooltips).
			 *
			 * @since 2.2.5
			 * @date 2020-12-18T1113+0100
			 */
			if ( ! self::$a_bool_alternative_tooltips_enabled ) {
				/*
				 * jQuery tooltips.
				 */
				$l_int_max_width = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH );
				if ( ! empty( $l_int_max_width ) && intval( $l_int_max_width ) > 0 ) {
					printf( ' max-width: %dpx !important;', esc_html( $l_int_max_width ) );
				}
				echo "}\r\n";

			} else {
				/*
				 * Alternative tooltips.
				 */
				echo "}\r\n";

				// Dimensions.
				$l_int_alternative_tooltip_width = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH ) );
				echo '.footnote_tooltip.position {';
				echo ' width: ' . esc_html( $l_int_alternative_tooltip_width ) . 'px;';
				// Set also as max-width wrt short tooltip shrinking.
				echo ' max-width: ' . esc_html( $l_int_alternative_tooltip_width ) . 'px;';

				// Position.
				$l_str_alternative_position = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION );
				$l_int_offset_x             = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X ) );

				if ( 'top left' === $l_str_alternative_position || 'bottom left' === $l_str_alternative_position ) {
					echo ' right: ' . ( ! empty( $l_int_offset_x ) ? esc_html( $l_int_offset_x ) : 0 ) . 'px;';
				} else {
					echo ' left: ' . ( ! empty( $l_int_offset_x ) ? esc_html( $l_int_offset_x ) : 0 ) . 'px;';
				}

				$l_int_offset_y = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y ) );

				if ( 'top left' === $l_str_alternative_position || 'top right' === $l_str_alternative_position ) {
					echo ' bottom: ' . ( ! empty( $l_int_offset_y ) ? esc_html( $l_int_offset_y ) : 0 ) . 'px;';
				} else {
					echo ' top: ' . ( ! empty( $l_int_offset_y ) ? esc_html( $l_int_offset_y ) : 0 ) . 'px;';
				}
				echo "}\r\n";

				/**
				 * Alternative tooltip timing.
				 *
				 * For jQuery tooltip timing @see templates/public/tooltip.html.
				 */
				echo ' .footnote_tooltip.shown {';
				$l_int_fade_in_delay    = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY ) );
				$l_int_fade_in_duration = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ) );
				$l_int_fade_in_delay    = ! empty( $l_int_fade_in_delay ) ? $l_int_fade_in_delay : '0';
				$l_int_fade_in_duration = ! empty( $l_int_fade_in_duration ) ? $l_int_fade_in_duration : '0';
				echo ' transition-delay: ' . esc_html( $l_int_fade_in_delay ) . 'ms;';
				echo ' transition-duration: ' . esc_html( $l_int_fade_in_duration ) . 'ms;';

				echo '} .footnote_tooltip.hidden {';
				$l_int_fade_out_delay    = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY ) );
				$l_int_fade_out_duration = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION ) );
				$l_int_fade_out_delay    = ! empty( $l_int_fade_out_delay ) ? $l_int_fade_out_delay : '0';
				$l_int_fade_out_duration = ! empty( $l_int_fade_out_duration ) ? $l_int_fade_out_duration : '0';
				echo ' transition-delay: ' . esc_html( $l_int_fade_out_delay ) . 'ms;';
				echo ' transition-duration: ' . esc_html( $l_int_fade_out_duration ) . 'ms;';

				echo "}\r\n";

			}
		}

		/**
		 * Custom CSS.
		 *
		 * - Bugfix: Custom CSS: insert new CSS in the public page header element after existing CSS.
		 *
		 * @since 2.2.3
		 * @date 2020-12-15T1128+0100
		 *
		 * Set custom CSS to override settings, not conversely.
		 * Legacy Custom CSS is used until it’s set to disappear after dashboard tab migration.
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			echo esc_html( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS ) );
			echo "\r\n";
		}
		echo esc_html( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_NEW ) );

		// Insert end tag without switching out of PHP.
		echo "\r\n</style>\r\n";

		/**
		 * Alternative tooltip implementation relying on plain JS and CSS transitions.
		 *
		 * - Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
		 *
		 * @since 2.1.1
		 *
		 * @reporter @andreasra
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/2/#post-13632566
		 *
		 * The script for alternative tooltips is printed formatted, not minified,
		 * for transparency. It isn’t indented though (the PHP open tag neither).
		 */
		if ( self::$a_bool_alternative_tooltips_enabled ) {

			// Start internal script.
			?>
<script content="text/javascript">
	function footnote_tooltip_show(footnote_tooltip_id) {
		document.getElementById(footnote_tooltip_id).classList.remove('hidden');
		document.getElementById(footnote_tooltip_id).classList.add('shown');
	}
	function footnote_tooltip_hide(footnote_tooltip_id) {
		document.getElementById(footnote_tooltip_id).classList.remove('shown');
		document.getElementById(footnote_tooltip_id).classList.add('hidden');
	}
</script>
<?php
			// End internal script.

		};
	}

	/**
	 * Displays the 'LOVE FOOTNOTES' slug if enabled.
	 *
	 * @since 1.5.0
	 *
	 * @since 2.2.0  more options  2020-12-11T0506+0100
	 */
	public function wp_footer() {
		if ( 'footer' === MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION ) ) {
			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $this->reference_container();
			// phpcs:enable
		}
		// Get setting for love and share this plugin.
		$l_str_love_me_index = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE );
		// Check if the admin allows to add a link to the footer.
		if ( empty( $l_str_love_me_index ) || 'no' === strtolower( $l_str_love_me_index ) || ! self::$a_bool_allow_love_me ) {
			return;
		}
		// Set a hyperlink to the word "footnotes" in the Love slug.
		$l_str_linked_name = sprintf( '<a href="https://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">%s</a>', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME );
		// Get random love me text.
		if ( 'random' === strtolower( $l_str_love_me_index ) ) {
			$l_str_love_me_index = 'text-' . wp_rand( 1, 7 );
		}
		switch ( $l_str_love_me_index ) {
			// Options named wrt backcompat, simplest is default.
			case 'text-1':
				/* Translators: 2: Link to plugin page 1: Love heart symbol */
				$l_str_love_me_text = sprintf( __( 'I %2$s %1$s', 'footnotes' ), $l_str_linked_name, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL );
				break;
			case 'text-2':
				/* Translators: %s: Link to plugin page */
				$l_str_love_me_text = sprintf( __( 'This website uses the awesome %s plugin.', 'footnotes' ), $l_str_linked_name );
				break;
			case 'text-4':
				/* Translators: 1: Link to plugin page 2: Love heart symbol */
				$l_str_love_me_text = sprintf( '%1$s %2$s', $l_str_linked_name, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL );
				break;
			case 'text-5':
				/* Translators: 1: Love heart symbol 2: Link to plugin page */
				$l_str_love_me_text = sprintf( '%1$s %2$s', MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, $l_str_linked_name );
				break;
			case 'text-6':
				/* Translators: %s: Link to plugin page */
				$l_str_love_me_text = sprintf( __( 'This website uses %s.', 'footnotes' ), $l_str_linked_name );
				break;
			case 'text-7':
				/* Translators: %s: Link to plugin page */
				$l_str_love_me_text = sprintf( __( 'This website uses the %s plugin.', 'footnotes' ), $l_str_linked_name );
				break;
			case 'text-3':
			default:
				/* Translators: %s: Link to plugin page */
				$l_str_love_me_text = sprintf( '%s', $l_str_linked_name );
				break;
		}
		echo sprintf( '<div style="text-align:center; color:#acacac;">%s</div>', esc_html( $l_str_love_me_text ) );
	}

	/**
	 * Replaces footnotes in the post/page title.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function the_title( $p_str_content ) {
		// Appends the reference container if set to "post_end".
		return $this->exec( $p_str_content, false );
	}

	/**
	 * Replaces footnotes in the content of the current page/post.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Page/Post content.
	 * @return string Content with replaced footnotes.
	 */
	public function the_content($p_str_Content) {

		/**
		 * Empties the footnotes list every time Footnotes is run when the_content hook is called.
		 *
		 * - Bugfix: Process: fix footnote duplication by emptying the footnotes list every time the search algorithm is run on the content, thanks to @inoruhana bug report.
		 *
		 * @since 2.5.7
		 *
		 * @reporter @inoruhana
		 * @link https://wordpress.org/support/topic/footnote-duplicated-in-the-widget/
		 *
		 * Under certain circumstances, footnotes were duplicated, because the footnotes list was
		 * not emptied every time before the search algorithm was run. That happened eg when both
		 * the reference container resides in the widget area, and the YOAST SEO plugin is active
		 * and calls the hook the_content to generate the Open Graph description, while Footnotes
		 * is set to avoid missing out on the footnotes (in the content) by hooking in as soon as
		 * the_content is called, whereas at post end Footnotes seems to hook in the_content only
		 * the time it’s the blog engine processing the post for display and appending the refs.
		 */
		self::$a_arr_Footnotes = array();
		// appends the reference container if set to "post_end"
		return $this->exec($p_str_Content, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "post_end" ? true : false);
	}

	/**
	 * Replaces footnotes in the excerpt of the current page/post.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Page/Post content.
	 * @return string Content with replaced footnotes.
	 */
	public function the_excerpt( $p_str_content ) {
		return $this->exec( $p_str_content, false, ! MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_IN_EXCERPT ) ) );
	}

	/**
	 * Replaces footnotes in the widget title.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function widget_title( $p_str_content ) {
		// Appends the reference container if set to "post_end".
		return $this->exec( $p_str_content, false );
	}

	/**
	 * Replaces footnotes in the content of the current widget.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function widget_text( $p_str_content ) {
		// phpcs:disable WordPress.PHP.YodaConditions.NotYoda
		// Appends the reference container if set to "post_end".
		return $this->exec( $p_str_content, 'post_end' === MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION ) ? true : false );
		// phpcs:enable
	}

	/**
	 * Replaces footnotes in each Content var of the current Post object.
	 *
	 * @since 1.5.4
	 * @param array|WP_Post $p_mixed_posts The current Post object.
	 */
	public function the_post( &$p_mixed_posts ) {
		// Single WP_Post object received.
		if ( ! is_array( $p_mixed_posts ) ) {
			$p_mixed_posts = $this->replace_post_object( $p_mixed_posts );
			return;
		}
		$num_posts = count( $p_mixed_posts );
		// Array of WP_Post objects received.
		for ( $l_int_index = 0; $l_int_index < $num_posts; $l_int_index++ ) {
			$p_mixed_posts[ $l_int_index ] = $this->replace_post_object( $p_mixed_posts[ $l_int_index ] );
		}
	}

	/**
	 * Replace all Footnotes in a WP_Post object.
	 *
	 * @since 1.5.6
	 * @param WP_Post $p_obj_post The Post object.
	 * @return WP_Post
	 */
	private function replace_post_object( $p_obj_post ) {
		$p_obj_post->post_content          = $this->exec( $p_obj_post->post_content );
		$p_obj_post->post_content_filtered = $this->exec( $p_obj_post->post_content_filtered );
		$p_obj_post->post_excerpt          = $this->exec( $p_obj_post->post_excerpt );
		return $p_obj_post;
	}

	/**
	 * Replaces all footnotes that occur in the given content.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Any string that may contain footnotes to be replaced.
	 * @param bool   $p_bool_output_references Appends the Reference Container to the output if set to true, default true.
	 * @param bool   $p_bool_hide_footnotes_text Hide footnotes found in the string.
	 * @return string
	 *
	 * @since 2.2.0  Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
	 * @since 2.2.5  Bugfix: Reference container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe bug report.
	 */
	public function exec( $p_str_content, $p_bool_output_references = false, $p_bool_hide_footnotes_text = false ) {

		// Replace all footnotes in the content, settings are converted to html characters.
		$p_str_content = $this->search( $p_str_content, true, $p_bool_hide_footnotes_text );
		// Replace all footnotes in the content, settings are NOT converted to html characters.
		$p_str_content = $this->search( $p_str_content, false, $p_bool_hide_footnotes_text );

		/**
		 * Reference container customized positioning through shortcode.
		 *
		 * - Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
		 *
		 * @since 2.2.0
		 * @date 2020-12-13T2057+0100
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/
		 *
		 *
		 * - Bugfix: Reference container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe bug report.
		 *
		 * @since 2.2.5
		 * @date 2020-12-18T1434+0100
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13784126
		 */
		// Append the reference container or insert at shortcode.
		$l_str_reference_container_position_shortcode = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE );
		if ( empty( $l_str_reference_container_position_shortcode ) ) {
			$l_str_reference_container_position_shortcode = '[[references]]';
		}

		if ( $p_bool_output_references ) {

			if ( strpos( $p_str_content, $l_str_reference_container_position_shortcode ) ) {

				$p_str_content = str_replace( $l_str_reference_container_position_shortcode, $this->reference_container(), $p_str_content );

			} else {

				$p_str_content .= $this->reference_container();

			}

			// Increment the container ID.
			self::$a_int_reference_container_id++;
		}

		// Delete position shortcode should any remain.
		$p_str_content = str_replace( $l_str_reference_container_position_shortcode, '', $p_str_content );

		// Take a look if the LOVE ME slug should NOT be displayed on this page/post, remove the short code if found.
		if ( strpos( $p_str_content, MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG ) ) {
			self::$a_bool_allow_love_me = false;
			$p_str_content              = str_replace( MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG, '', $p_str_content );
		}
		// Return the content with replaced footnotes and optional reference container appended.
		return $p_str_content;
	}

	/**
	 * Replaces all footnotes in the given content and appends them to the static property.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content Content to be searched for footnotes.
	 * @param bool   $p_bool_convert_html_chars html encode settings, default true.
	 * @param bool   $p_bool_hide_footnotes_text Hide footnotes found in the string.
	 * @return string
	 *
	 * @since 2.0.0  various.
	 * @since 2.4.0  Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
	 */
	public function search( $p_str_content, $p_bool_convert_html_chars, $p_bool_hide_footnotes_text ) {

		// Post ID to make everything unique wrt infinite scroll and archive view.
		self::$a_int_post_id = get_the_id();

		// Contains the index for the next footnote on this page.
		$l_int_footnote_index = count( self::$a_arr_footnotes ) + 1;

		// Contains the starting position for the lookup of a footnote.
		$l_int_pos_start = 0;

		// Get start and end tag for the footnotes short code.
		$l_str_starting_tag = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START );
		$l_str_ending_tag   = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END );
		if ( 'userdefined' === $l_str_starting_tag || 'userdefined' === $l_str_ending_tag ) {
			$l_str_starting_tag = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$l_str_ending_tag   = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}
		// Decode html special chars.
		if ( $p_bool_convert_html_chars ) {
			$l_str_starting_tag = htmlspecialchars( $l_str_starting_tag );
			$l_str_ending_tag   = htmlspecialchars( $l_str_ending_tag );
		}

		// If footnotes short code is empty, return the content without changes.
		if ( empty( $l_str_starting_tag ) || empty( $l_str_ending_tag ) ) {
			return $p_str_content;
		}

		/**
		 * Footnote delimiter syntax validation.
		 *
		 * - Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
		 *
		 * @since 2.4.0
		 *
		 *
		 * - Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
		 * - Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
		 * - Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
		 *
		 * @since 2.5.0
		 * @date 2021-01-07T0824+0100
		 *
		 * @reporter @andreasra
		 * @link https://wordpress.org/support/topic/warning-unbalanced-footnote-start-tag-short-code-before/
		 *
		 *
		 * If footnotes short codes are unbalanced, and syntax validation is not disabled,
		 * prepend a warning to the content; displays de facto beneath the post title.
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE ) ) ) {

			// Make shortcodes conform to regex syntax.
			$l_str_start_tag_regex = preg_replace( '#([\(\)\{\}\[\]\*\.\?\!])#', '\\\\$1', $l_str_starting_tag );
			$l_str_end_tag_regex   = preg_replace( '#([\(\)\{\}\[\]\*\.\?\!])#', '\\\\$1', $l_str_ending_tag );

			// Apply different regex depending on whether start shortcode is double/triple opening parenthesis.
			if ( '((' === $l_str_starting_tag || '(((' === $l_str_starting_tag ) {

				// This prevents from catching a script containing e.g. a double opening parenthesis.
				$l_str_validation_regex = '#' . $l_str_start_tag_regex . '(((?!' . $l_str_end_tag_regex . ')[^\{\}])*?)(' . $l_str_start_tag_regex . '|$)#s';

			} else {

				// Catch all only if the start shortcode is not double/triple opening parenthesis, i.e. is unlikely to occur in scripts.
				$l_str_validation_regex = '#' . $l_str_start_tag_regex . '(((?!' . $l_str_end_tag_regex . ').)*?)(' . $l_str_start_tag_regex . '|$)#s';
			}

			// Check syntax and get error locations.
			preg_match( $l_str_validation_regex, $p_str_content, $p_arr_error_location );
			if ( empty( $p_arr_error_location ) ) {
				self::$a_bool_syntax_error_flag = false;
			}

			// Prevent generating and inserting the warning multiple times.
			if ( self::$a_bool_syntax_error_flag ) {

				// Get plain text string for error location.
				$l_str_error_spot_string = wp_strip_all_tags( $p_arr_error_location[1] );

				// Limit string length to 300 characters.
				if ( strlen( $l_str_error_spot_string ) > 300 ) {
					$l_str_error_spot_string = substr( $l_str_error_spot_string, 0, 299 ) . '…';
				}

				// Compose warning box.
				$l_str_syntax_error_warning  = '<div class="footnotes_validation_error"><p>';
				$l_str_syntax_error_warning .= __( 'WARNING: unbalanced footnote start tag short code found.', 'footnotes' );
				$l_str_syntax_error_warning .= '</p><p>';

				// Syntax validation setting in the dashboard under the General settings tab.
				/* Translators: 1: General Settings 2: Footnote start and end short codes 3: Check for balanced shortcodes */
				$l_str_syntax_error_warning .= sprintf( __( 'If this warning is irrelevant, please disable the syntax validation feature in the dashboard under %1$s &gt; %2$s &gt; %3$s.', 'footnotes' ), __( 'General settings', 'footnotes' ), __( 'Footnote start and end short codes', 'footnotes' ), __( 'Check for balanced shortcodes', 'footnotes' ) );

				$l_str_syntax_error_warning .= '</p><p>';
				$l_str_syntax_error_warning .= __( 'Unbalanced start tag short code found before:', 'footnotes' );
				$l_str_syntax_error_warning .= '</p><p>“';
				$l_str_syntax_error_warning .= $l_str_error_spot_string;
				$l_str_syntax_error_warning .= '”</p></div>';

				// Prepend the warning box to the content.
				$p_str_content = $l_str_syntax_error_warning . $p_str_content;

				// Checked, set flag to false to prevent duplicate warning.
				self::$a_bool_syntax_error_flag = false;

				return $p_str_content;
			}
		}

		// Load referrer templates if footnotes text not hidden.
		if ( ! $p_bool_hide_footnotes_text ) {

			// Load footnote referrer template file.
			if ( self::$a_bool_alternative_tooltips_enabled ) {
				$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'footnote-alternative' );
			} else {
				$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'footnote' );
			}

			/**
			 * Call Boolean again for robustness when priority levels don’t match any longer.
			 *
			 * - Bugfix: Tooltips: fix display in Popup Maker popups by correcting a coding error.
			 *
			 * @since 2.5.4
			 * @see self::add_filter('pum_popup_content', array($this, "the_content"), $l_int_the_content_priority)
			 */
			self::$a_bool_tooltips_enabled             = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED ) );
			self::$a_bool_alternative_tooltips_enabled = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ) );

			// Load tooltip inline script if jQuery tooltips are enabled.
			if ( self::$a_bool_tooltips_enabled && ! self::$a_bool_alternative_tooltips_enabled ) {
				$l_obj_template_tooltip = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'tooltip' );
			}
		} else {
			$l_obj_template         = null;
			$l_obj_template_tooltip = null;
		}

		// Search footnotes short codes in the content.
		do {
			// Get first occurrence of the footnote start tag short code.
			$i_int_len_content = strlen( $p_str_content );
			if ( $l_int_pos_start > $i_int_len_content ) {
				$l_int_pos_start = $i_int_len_content;
			}
			$l_int_pos_start = strpos( $p_str_content, $l_str_starting_tag, $l_int_pos_start );
			// No short code found, stop here.
			if ( ! $l_int_pos_start ) {
				break;
			}
			// Get first occurrence of the footnote end tag short code.
			$l_int_pos_end = strpos( $p_str_content, $l_str_ending_tag, $l_int_pos_start );
			// No short code found, stop here.
			if ( ! $l_int_pos_end ) {
				break;
			}
			// Calculate the length of the footnote.
			$l_int_length = $l_int_pos_end - $l_int_pos_start;

			// Get footnote text.
			$l_str_footnote_text = substr( $p_str_content, $l_int_pos_start + strlen( $l_str_starting_tag ), $l_int_length - strlen( $l_str_starting_tag ) );

			// Get tooltip text if present.
			self::$a_str_tooltip_shortcode        = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER );
			self::$a_int_tooltip_shortcode_length = strlen( self::$a_str_tooltip_shortcode );
			$l_int_tooltip_text_length            = strpos( $l_str_footnote_text, self::$a_str_tooltip_shortcode );
			$l_bool_has_tooltip_text              = ! $l_int_tooltip_text_length ? false : true;
			if ( $l_bool_has_tooltip_text ) {
				$l_str_tooltip_text = substr( $l_str_footnote_text, 0, $l_int_tooltip_text_length );
			} else {
				$l_str_tooltip_text = '';
			}

			/**
			 * URL line wrapping for Unicode non conformant browsers.
			 *
			 * @since 2.1.1 (CSS)
			 * @since 2.1.4 (PHP)
			 *
			 * Despite Unicode recommends to line-wrap URLs at slashes, and Firefox follows
			 * the Unicode standard, Chrome does not, making long URLs hang out of tooltips
			 * or extend reference containers, so that the end is hidden outside the window
			 * and may eventually be viewed after we scroll horizontally or zoom out. It is
			 * up to the web page to make URLs breaking anywhere by wrapping them in a span
			 * that is assigned appropriate CSS properties and values.
			 * @see css/public.css
			 *
			 * - Bugfix: Tooltips: fix line breaking for hyperlinked URLs in Unicode-non-compliant user agents, thanks to @andreasra bug report.
			 *
			 * @since 2.1.1
			 *
			 * @reporter @andreasra
			 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/3/#post-13657398
			 *
			 *
			 * - Bugfix: Reference container: fix width in mobile view by URL wrapping for Unicode-non-conformant browsers, thanks to @karolszakiel bug report.
			 *
			 * @since 2.1.3
			 * @date 2020-11-23
			 *
			 * @reporter @karolszakiel
			 * @link https://wordpress.org/support/topic/footnotes-on-mobile-phones/
			 *
			 *
			 * - Bugfix: Reference container, tooltips: fix line wrapping of URLs (hyperlinked or not) based on pattern, not link element.
			 *
			 * @since 2.1.4
			 * @date 2020-11-25T0837+0100
			 * @link https://wordpress.org/support/topic/footnotes-on-mobile-phones/#post-13710682
			 *
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: exclude image source too, thanks to @bjrnet21 bug report.
			 *
			 * @since 2.1.5
			 *
			 * @reporter @bjrnet21
			 * @link https://wordpress.org/support/topic/2-1-4-breaks-on-my-site-images-dont-show/
			 *
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: fix regex, thanks to @a223123131 bug report.
			 *
			 * @since 2.1.6
			 * @date 2020-12-09T1921+0100
			 *
			 * @reporter @a223123131
			 * @link https://wordpress.org/support/topic/broken-layout-starting-version-2-1-4/
			 *
			 * Even ARIA labels may take a URL as value, so use \w=[\'"] as a catch-all    2020-12-10T1005+0100
			 *
			 * - Bugfix: Dashboard: URL wrap: add option to properly enable/disable URL wrap.
			 *
			 * @since 2.1.6
			 * @date 2020-12-09T1606+0100
			 *
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
			 *
			 * @since 2.2.6
			 * @date 2020-12-23T0409+0100
			 *
			 * @reporter @spiralofhope2
			 * @link https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/
			 *
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: remove a bug introduced in the regex, thanks to @rjl20 @spaceling @lukashuggenberg @klusik @friedrichnorth @bernardzit bug reports.
			 *
			 * @since 2.2.7
			 * @date 2020-12-23T1046+0100
			 *
			 * @reporter @rjl20
			 * @link https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/#post-13825479
			 *
			 * @reporter @spaceling
			 * @link https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/#post-13825532
			 *
			 * @reporter @lukashuggenberg
			 * @link https://wordpress.org/support/topic/2-2-6-breaks-all-footnotes/
			 *
			 * @reporter @klusik
			 * @link https://wordpress.org/support/topic/2-2-6-breaks-all-footnotes/#post-13825885
			 *
			 * @reporter @friedrichnorth
			 * @link https://wordpress.org/support/topic/footnotes-dont-show-after-update-to-2-2-6/
			 *
			 * @reporter @bernardzit
			 * @link https://wordpress.org/support/topic/footnotes-dont-show-after-update-to-2-2-6/#post-13826029
			 *
			 * @since 2.2.8  Bugfix: Reference container, tooltips: URL wrap: correctly make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
			 * @date 2020-12-23T1107+0100
			 *
			 * Correct is duplicating the negative lookbehind w/o quotes: '(?<!\w=)'
			 *
			 * @since 2.2.9  Bugfix: Reference container, tooltips: URL wrap: account for RFC 2396 allowed characters in parameter names.
			 * @date 2020-12-24T1956+0100
			 * @link https://stackoverflow.com/questions/814700/http-url-allowed-characters-in-parameter-names
			 *
			 * @since 2.2.9  Bugfix: Reference container, tooltips: URL wrap: exclude URLs also where the equals sign is preceded by an entity or character reference.
			 * @date 2020-12-25T1251+0100
			 *
			 * @since 2.2.10 Bugfix: Reference container, tooltips: URL wrap: support also file transfer protocol URLs.
			 * @date 2020-12-25T2220+0100
			 *
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: exclude URL pattern as folder name in Wayback Machine URL, thanks to @rumperuu bug report.
			 *
			 * @since 2.5.3
			 * @date 2021-01-24
			 *
			 * @reporter @rumperuu
			 * @link https://wordpress.org/support/topic/line-wrap-href-regex-bug/
			 *
			 * By adding a 3rd negative lookbehind: '(?<!/)'.
			 *
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: account for leading space in value, thanks to @karolszakiel example provision.
			 *
			 * @since 2.5.4
			 *
			 * @reporter @karolszakiel
			 * @link https://wordpress.org/support/topic/footnotes-on-mobile-phones/
			 *
			 * The value of an href argument may have leading (and trailing) space.
			 * @link https://webmasters.stackexchange.com/questions/93540/are-spaces-in-href-valid
			 * Needs to replicate the relevant negative lookbehind at least with one and with two spaces.
			 * Note: The WordPress blog engine edits these values, cropping these leading/trailing spaces.
			 *       But given they can occur on WP-powered websites, some page builders may probably not.
			 */
			if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTE_URL_WRAP_ENABLED ) ) ) {

				$l_str_footnote_text = preg_replace(
					'#(?<![-\w\.!~\*\'\(\);]=[\'"])(?<![-\w\.!~\*\'\(\);]=[\'"] )(?<![-\w\.!~\*\'\(\);]=[\'"]  )(?<![-\w\.!~\*\'\(\);]=)(?<!/)((ht|f)tps?://[^\\s<]+)#',
					'<span class="footnote_url_wrap">$1</span>',
					$l_str_footnote_text
				);
			}

			// Text to be displayed instead of the footnote.
			$l_str_footnote_replace_text = '';

			// Whether hard links are enabled.
			if ( self::$a_bool_hard_links_enable ) {

				// Get the configurable parts.
				self::$a_str_referrer_link_slug = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG );
				self::$a_str_footnote_link_slug = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG );
				self::$a_str_link_ids_separator = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR );

				// Streamline ID concatenation.
				self::$a_str_post_container_id_compound  = self::$a_str_link_ids_separator;
				self::$a_str_post_container_id_compound .= self::$a_int_post_id;
				self::$a_str_post_container_id_compound .= self::$a_str_link_ids_separator;
				self::$a_str_post_container_id_compound .= self::$a_int_reference_container_id;
				self::$a_str_post_container_id_compound .= self::$a_str_link_ids_separator;

			}

			// Display the footnote referrers and the tooltips.
			if ( ! $p_bool_hide_footnotes_text ) {
				$l_int_index = MCI_Footnotes_Convert::index( $l_int_footnote_index, MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) );

				// Display only a truncated footnote text if option enabled.
				$l_bool_enable_excerpt = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED ) );
				$l_int_max_length      = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH ) );

				// Define excerpt text as footnote text by default.
				$l_str_excerpt_text = $l_str_footnote_text;

				/**
				 * Tooltip truncation.
				 *
				 * - Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
				 *
				 * @since 2.1.0
				 * @date 2020-11-08T2146+0100
				 *
				 * @reporter @rovanov
				 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
				 *
				 * If the tooltip truncation option is enabled, it’s done based on character count,
				 * and a trailing incomplete word is cropped.
				 * This is equivalent to the WordPress default excerpt generation, i.e. without a
				 * custom excerpt and without a delimiter. But WordPress does word count, usually 55.
				 */
				if ( self::$a_bool_tooltips_enabled && $l_bool_enable_excerpt ) {
					$l_str_dummy_text = wp_strip_all_tags( $l_str_footnote_text );
					if ( is_int( $l_int_max_length ) && strlen( $l_str_dummy_text ) > $l_int_max_length ) {
						$l_str_excerpt_text  = substr( $l_str_dummy_text, 0, $l_int_max_length );
						$l_str_excerpt_text  = substr( $l_str_excerpt_text, 0, strrpos( $l_str_excerpt_text, ' ' ) );
						$l_str_excerpt_text .= '&nbsp;&#x2026; <';
						$l_str_excerpt_text .= self::$a_bool_hard_links_enable ? 'a' : 'span';
						$l_str_excerpt_text .= ' class="footnote_tooltip_continue" ';
						$l_str_excerpt_text .= 'onclick="footnote_move_to_anchor_' . self::$a_int_post_id;
						$l_str_excerpt_text .= '_' . self::$a_int_reference_container_id;
						$l_str_excerpt_text .= '(\'footnote_plugin_reference_' . self::$a_int_post_id;
						$l_str_excerpt_text .= '_' . self::$a_int_reference_container_id;
						$l_str_excerpt_text .= "_$l_int_index');\"";

						// If enabled, add the hard link fragment ID.
						if ( self::$a_bool_hard_links_enable ) {

							$l_str_excerpt_text .= ' href="#';
							$l_str_excerpt_text .= self::$a_str_footnote_link_slug;
							$l_str_excerpt_text .= self::$a_str_post_container_id_compound;
							$l_str_excerpt_text .= $l_int_index;
							$l_str_excerpt_text .= '"';
						}

						$l_str_excerpt_text .= '>';

						/**
						 * Configurable read-on button label.
						 *
						 * - Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
						 *
						 * @since 2.1.0
						 * @date 2020-11-08T2146+0100
						 *
						 * @reporter @rovanov
						 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
						 */
						$l_str_excerpt_text .= MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL );

						$l_str_excerpt_text .= self::$a_bool_hard_links_enable ? '</a>' : '</span>';
					}
				}

				/**
				 * Referrers element superscript or baseline.
				 *
				 * Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report
				 *
				 * @since 2.1.1
				 *
				 * @reporter @cwbayer
				 * @link https://wordpress.org/support/topic/footnote-number-in-text-superscript-disrupts-leading/
				 *
				 * define the HTML element to use for the referrers.
				 */
				if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS ) ) ) {

					$l_str_sup_span = 'sup';

				} else {

					$l_str_sup_span = 'span';
				}

				// Whether hard links are enabled.
				if ( self::$a_bool_hard_links_enable ) {

					self::$a_str_link_span      = 'a';
					self::$a_str_link_close_tag = '</a>';
					// Self::$a_str_link_open_tag will be defined as needed.

					// Compose hyperlink address (leading space is in template).
					$l_str_footnote_link_argument  = 'href="#';
					$l_str_footnote_link_argument .= self::$a_str_footnote_link_slug;
					$l_str_footnote_link_argument .= self::$a_str_post_container_id_compound;
					$l_str_footnote_link_argument .= $l_int_index;
					$l_str_footnote_link_argument .= '" class="footnote_hard_link"';

					/**
					 * Compose fragment ID anchor with offset, for use in reference container.
					 * Empty span, child of empty span, to avoid tall dotted rectangles in browser.
					 */
					$l_str_referrer_anchor_element  = '<span class="footnote_referrer_base"><span id="';
					$l_str_referrer_anchor_element .= self::$a_str_referrer_link_slug;
					$l_str_referrer_anchor_element .= self::$a_str_post_container_id_compound;
					$l_str_referrer_anchor_element .= $l_int_index;
					$l_str_referrer_anchor_element .= '" class="footnote_referrer_anchor"></span></span>';

				} else {

					/**
					 * Initialize hard link variables when hard links are disabled.
					 *
					 * - Bugfix: Process: initialize hard link address variables to empty string to fix 'undefined variable' bug, thanks to @a223123131 bug report.
					 *
					 * @since 2.4.0
					 * @date 2021-01-04T1622+0100
					 *
					 * @reporter @a223123131
					 * @link https://wordpress.org/support/topic/wp_debug-php-notice/
					 *
					 * If no hyperlink nor offset anchor is needed, initialize as empty.
					 */
					$l_str_footnote_link_argument  = '';
					$l_str_referrer_anchor_element = '';

					// The link element is set independently as it may be needed for styling.
					if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_LINK_ELEMENT_ENABLED ) ) ) {

						self::$a_str_link_span      = 'a';
						self::$a_str_link_open_tag  = '<a>';
						self::$a_str_link_close_tag = '</a>';

					}
				}

				// Determine tooltip content.
				if ( self::$a_bool_tooltips_enabled ) {
					$l_str_tooltip_content = $l_bool_has_tooltip_text ? $l_str_tooltip_text : $l_str_excerpt_text;
				} else {
					$l_str_tooltip_content = '';
				}

				/**
				 * Determine shrink width if alternative tooltips are enabled.
				 *
				 * @since 2.5.6
				 */
				$l_str_tooltip_style = '';
				if ( self::$a_bool_alternative_tooltips_enabled && self::$a_bool_tooltips_enabled ) {
					$l_int_tooltip_length = strlen( wp_strip_all_tags( $l_str_tooltip_content ) );
					if ( $l_int_tooltip_length < 70 ) {
						$l_str_tooltip_style  = ' style="width: ';
						$l_str_tooltip_style .= ( $l_int_tooltip_length * .7 );
						$l_str_tooltip_style .= 'em;"';
					}
				}

				// Fill in 'templates/public/footnote.html'.
				$l_obj_template->replace(
					array(
						'link-span'      => self::$a_str_link_span,
						'post_id'        => self::$a_int_post_id,
						'container_id'   => self::$a_int_reference_container_id,
						'note_id'        => $l_int_index,
						'hard-link'      => $l_str_footnote_link_argument,
						'sup-span'       => $l_str_sup_span,
						'before'         => MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE ),
						'index'          => $l_int_index,
						'after'          => MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER ),
						'anchor-element' => $l_str_referrer_anchor_element,
						'style'          => $l_str_tooltip_style,
						'text'           => $l_str_tooltip_content,
					)
				);
				$l_str_footnote_replace_text = $l_obj_template->get_content();

				// Reset the template.
				$l_obj_template->reload();

				// If standard tooltips are enabled but alternative are not.
				if ( self::$a_bool_tooltips_enabled && ! self::$a_bool_alternative_tooltips_enabled ) {

					$l_int_offset_y          = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y ) );
					$l_int_offset_x          = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X ) );
					$l_int_fade_in_delay     = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY ) );
					$l_int_fade_in_duration  = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ) );
					$l_int_fade_out_delay    = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY ) );
					$l_int_fade_out_duration = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION ) );

					// Fill in 'templates/public/tooltip.html'.
					$l_obj_template_tooltip->replace(
						array(
							'post_id'           => self::$a_int_post_id,
							'container_id'      => self::$a_int_reference_container_id,
							'note_id'           => $l_int_index,
							'position'          => MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION ),
							'offset-y'          => ! empty( $l_int_offset_y ) ? $l_int_offset_y : 0,
							'offset-x'          => ! empty( $l_int_offset_x ) ? $l_int_offset_x : 0,
							'fade-in-delay'     => ! empty( $l_int_fade_in_delay ) ? $l_int_fade_in_delay : 0,
							'fade-in-duration'  => ! empty( $l_int_fade_in_duration ) ? $l_int_fade_in_duration : 0,
							'fade-out-delay'    => ! empty( $l_int_fade_out_delay ) ? $l_int_fade_out_delay : 0,
							'fade-out-duration' => ! empty( $l_int_fade_out_duration ) ? $l_int_fade_out_duration : 0,
						)
					);
					$l_str_footnote_replace_text .= $l_obj_template_tooltip->get_content();
					$l_obj_template_tooltip->reload();
				}
			}
			// Replace the footnote with the template.
			$p_str_content = substr_replace( $p_str_content, $l_str_footnote_replace_text, $l_int_pos_start, $l_int_length + strlen( $l_str_ending_tag ) );

			// Add footnote only if not empty.
			if ( ! empty( $l_str_footnote_text ) ) {
				// Set footnote to the output box at the end.
				self::$a_arr_footnotes[] = $l_str_footnote_text;
				// Increase footnote index.
				$l_int_footnote_index++;
			}

			/**
			 * Fixes a footnotes numbering bug (happening under de facto rare circumstances).
			 *
			 * - Bugfix: Fixed occasional bug where footnote ordering could be out of sequence
			 *
			 * @since 1.6.4
			 * @date 2016-06-29T0054+0000
			 * @committer @dartiss
			 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class/task.php?rev=1445718 @dartiss’ class/task.php
			 * @link https://plugins.trac.wordpress.org/log/footnotes/trunk/class/task.php?rev=1445718 @dartiss re-added class/task.php
			 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class?rev=1445711 class/ w/o task.php
			 * @link https://plugins.trac.wordpress.org/changeset/1445711/footnotes/trunk/class @dartiss deleted class/task.php
			 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class/task.php?rev=1026210 @aricura’s latest class/task.php
			 *
			 *
			 * - Bugfix: Process: fix numbering bug impacting footnote #2 with footnote #1 close to start, thanks to @rumperuu bug report, thanks to @lolzim code contribution.
			 *
			 * @since 2.5.5
			 *
			 * @contributor @lolzim
			 * @link https://wordpress.org/support/topic/footnotes-numbered-incorrectly/#post-14062032
			 *
			 * @reporter @rumperuu
			 * @link https://wordpress.org/support/topic/footnotes-numbered-incorrectly/
			 *
			 * This assignment was overridden by another one, causing the algorithm to jump back
			 * near the post start to a position calculated as the sum of the length of the last
			 * footnote and the length of the last footnote replace text.
			 * A bug disturbing the order of the footnotes depending on the text before the first
			 * footnote, the length of the first footnote and the length of the templates for the
			 * footnote and the tooltip. Moreover, it was causing non-trivial process garbage.
			 */
			// Add offset to the new starting position.
			$l_int_pos_start += $l_int_length + strlen( $l_str_ending_tag );

		} while ( true );

		// Return content.
		return $p_str_content;
	}

	/**
	 * Generates the reference container.
	 *
	 * @since 1.5.0
	 * @return string
	 *
	 * @since 2.0.0  Update: remove backlink symbol along with column 2 of the reference container
	 * @since 2.0.3  Bugfix: prepend an arrow on user request
	 * @since 2.0.6  Bugfix: Reference container: fix line breaking behavior in footnote number clusters.
	 * @since 2.0.4  Bugfix: restore the arrow select and backlink symbol input settings
	 * @since 2.1.1  Bugfix: Referrers, reference container: Combining identical footnotes: fix dead links and ensure referrer-backlink bijectivity, thanks to @happyches bug report.
	 * @since 2.1.1  Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
	 */
	public function reference_container() {

		// No footnotes have been replaced on this page.
		if ( empty( self::$a_arr_footnotes ) ) {
			return '';
		}

		/**
		 * Footnote index backlink symbol.
		 *
		 * - Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
		 *
		 * @since 2.1.1
		 *
		 * @reporter @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13671138
		 *
		 * If the backlink symbol is enabled.
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE ) ) ) {

			// Get html arrow.
			$l_str_arrow = MCI_Footnotes_Convert::get_arrow( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW ) );
			// Set html arrow to the first one if invalid index defined.
			if ( is_array( $l_str_arrow ) ) {
				$l_str_arrow = MCI_Footnotes_Convert::get_arrow( 0 );
			}
			// Get user defined arrow.
			$l_str_arrow_user_defined = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED );
			if ( ! empty( $l_str_arrow_user_defined ) ) {
				$l_str_arrow = $l_str_arrow_user_defined;
			}

			// Wrap the arrow in a @media print { display:hidden } span.
			$l_str_footnote_arrow  = '<span class="footnote_index_arrow">';
			$l_str_footnote_arrow .= $l_str_arrow . '</span>';

		} else {

			// If the backlink symbol isn’t enabled, set it to empty.
			$l_str_arrow          = '';
			$l_str_footnote_arrow = '';

		}

		/**
		 * Backlink separator.
		 *
		 * - Bugfix: Reference container: make separating and terminating punctuation optional and configurable, thanks to @docteurfitness issue report and code contribution.
		 *
		 * @since 2.1.4
		 * @date 2020-11-28T1048+0100
		 *
		 * @contributor @docteurfitness
		 * @link https://wordpress.org/support/topic/update-2-1-3/#post-13704194
		 *
		 * @reporter @docteurfitness
		 * @link https://wordpress.org/support/topic/update-2-1-3/
		 *
		 * Initially a comma was appended in this algorithm for enumerations.
		 * The comma in enumerations is not generally preferred.
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_ENABLED ) ) ) {

			// Check if it is input-configured.
			$l_str_separator = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM );

			if ( empty( $l_str_separator ) ) {

				// If it is not, check which option is on.
				$l_str_separator_option = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION );
				switch ( $l_str_separator_option ) {
					case 'comma':
						$l_str_separator = ',';
						break;
					case 'semicolon':
						$l_str_separator = ';';
						break;
					case 'en_dash':
						$l_str_separator = '&nbsp;&#x2013;';
						break;
				}
			}
		} else {

			$l_str_separator = '';
		}

		/**
		 * Backlink terminator.
		 *
		 * Initially a dot was appended in the table row template.
		 *
		 * @since 2.0.6 a dot after footnote numbers is discarded as not localizable;
		 * making it optional was envisaged.
		 * @since 2.1.4 the terminator is optional, has options, and is configurable.
		 */
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_ENABLED ) ) ) {

			// Check if it is input-configured.
			$l_str_terminator = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM );

			if ( empty( $l_str_terminator ) ) {

				// If it is not, check which option is on.
				$l_str_terminator_option = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION );
				switch ( $l_str_terminator_option ) {
					case 'period':
						$l_str_terminator = '.';
						break;
					case 'parenthesis':
						$l_str_terminator = ')';
						break;
					case 'colon':
						$l_str_terminator = ':';
						break;
				}
			}
		} else {

			$l_str_terminator = '';
		}

		/**
		 * Line breaks.
		 *
		 * - Bugfix: Reference container: Backlinks: fix stacked enumerations by adding optional line breaks.
		 *
		 * @since 2.1.4
		 * @date 2020-11-28T1049+0100
		 *
		 * The backlinks of combined footnotes are generally preferred in an enumeration.
		 * But when few footnotes are identical, stacking the items in list form is better.
		 * Variable number length and proportional character width require explicit line breaks.
		 * Otherwise, an ordinary space character offering a line break opportunity is inserted.
		 */
		$l_str_line_break = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_BACKLINKS_LINE_BREAKS_ENABLED ) ) ? '<br />' : ' ';

		/**
		 * Line breaks for source readability.
		 *
		 * For maintenance and support, table rows in the reference container should be
		 * separated by an empty line. So we add these line breaks for source readability.
		 * Before the first table row (breaks between rows are ~200 lines below).
		 */
		$l_str_body = "\r\n\r\n";

		/**
		 * Reference container table row template load.
		 *
		 * - Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
		 *
		 * @since 2.1.1
		 * @date 2020-11-16T2024+0100
		 */

		// When combining identical footnotes is turned on, another template is needed.
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_COMBINE_IDENTICAL_FOOTNOTES ) ) ) {
			// The combining template allows for backlink clusters and supports cell clicking for single notes.
			$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'reference-container-body-combi' );

		} else {

			// When 3-column layout is turned on (only available if combining is turned off).
			if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE ) ) ) {
				$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'reference-container-body-3column' );

			} else {

				// When switch symbol and index is turned on, and combining and 3-columns are off.
				if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) ) ) {
					$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'reference-container-body-switch' );

				} else {

					// Default is the standard template.
					$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_PUBLIC, 'reference-container-body' );

				}
			}
		}

		/**
		 * Switch backlink symbol and footnote number.
		 *
		 * - Bugfix: Reference container: option to append symbol (prepended by default), thanks to @spaceling code contribution.
		 *
		 * @since 2.1.1
		 * @date 2020-11-16T2024+0100
		 *
		 * @contributor @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13615994
		 *
		 *
		 * - Bugfix: Reference container: Backlink symbol: support for appending when combining identicals is on.
		 *
		 * @since 2.1.4
		 * @date 2020-11-26T1633+0100
		 */
		$l_bool_symbol_switch = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) );

		// Loop through all footnotes found in the page.
		$num_footnotes = count( self::$a_arr_footnotes );
		for ( $l_int_index = 0; $l_int_index < $num_footnotes; $l_int_index++ ) {

			// Get footnote text.
			$l_str_footnote_text = self::$a_arr_footnotes[ $l_int_index ];

			// If footnote is empty, go to the next one;.
			// With combine identicals turned on, identicals will be deleted and are skipped.
			if ( empty( $l_str_footnote_text ) ) {
				continue;
			}

			// Generate content of footnote index cell.
			$l_int_first_footnote_index = ( $l_int_index + 1 );

			// Get the footnote index string and.
			// Keep supporting legacy index placeholder.
			$l_str_footnote_id = MCI_Footnotes_Convert::index( ( $l_int_index + 1 ), MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) );

			/**
			 * Case of only one backlink per table row.
			 *
			 * If enabled, and for the case the footnote is single, compose hard link.
			 */
			// Define anyway.
			$l_str_hard_link_address = '';

			if ( self::$a_bool_hard_links_enable ) {

				/**
				 * Use-Backbutton-Hint tooltip, optional and configurable.
				 *
				 * - Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
				 *
				 * @since 2.5.4
				 *
				 * @reporter @theroninjedi47
				 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
				 *
				 * When hard links are enabled, clicks on the backlinks are logged in the browsing history.
				 * This tooltip hints to use the backbutton instead, so the history gets streamlined again.
				 * @link https://wordpress.org/support/topic/making-it-amp-compatible/#post-13837359
				 */
				if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE ) ) ) {
					$l_str_use_backbutton_hint  = ' title="';
					$l_str_use_backbutton_hint .= MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT );
					$l_str_use_backbutton_hint .= '"';
				} else {
					$l_str_use_backbutton_hint = '';
				}

				/**
				 * Compose fragment ID anchor with offset, for use in reference container.
				 * Empty span, child of empty span, to avoid tall dotted rectangles in browser.
				 */
				$l_str_footnote_anchor_element  = '<span class="footnote_item_base"><span id="';
				$l_str_footnote_anchor_element .= self::$a_str_footnote_link_slug;
				$l_str_footnote_anchor_element .= self::$a_str_post_container_id_compound;
				$l_str_footnote_anchor_element .= $l_str_footnote_id;
				$l_str_footnote_anchor_element .= '" class="footnote_item_anchor"></span></span>';

				// Compose optional hard link address.
				$l_str_hard_link_address  = ' href="#';
				$l_str_hard_link_address .= self::$a_str_referrer_link_slug;
				$l_str_hard_link_address .= self::$a_str_post_container_id_compound;
				$l_str_hard_link_address .= $l_str_footnote_id . '"';
				$l_str_hard_link_address .= $l_str_use_backbutton_hint;

				// Compose optional opening link tag with optional hard link, mandatory for instance.
				self::$a_str_link_open_tag = '<a' . $l_str_hard_link_address;
				self::$a_str_link_open_tag = ' class="footnote_hard_back_link">';

			} else {
				// Define as empty, too.
				$l_str_footnote_anchor_element = '';
			}

			/**
			 * Support for combining identicals: compose enumerated backlinks.
			 *
			 * - Bugfix: Referrers, reference container: Combining identical footnotes: fix dead links and ensure referrer-backlink bijectivity, thanks to @happyches bug report.
			 *
			 * @since 2.1.1
			 * @date 2020-11-14T2233+0100
			 *
			 * @reporter @happyches
			 * @link https://wordpress.org/support/topic/custom-css-for-jumbled-references/
			 *
			 * Prepare to have single footnotes, where the click event and
			 * optional hard link need to be set to cover the table cell,
			 * for better usability and UX.
			 */
			// Set a flag to check for the combined status of a footnote item.
			$l_bool_flag_combined = false;

			// Set otherwise unused variables as empty to avoid screwing up the placeholder array.
			$l_str_backlink_event     = '';
			$l_str_footnote_backlinks = '';
			$l_str_footnote_reference = '';

			if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_COMBINE_IDENTICAL_FOOTNOTES ) ) ) {

				// ID, optional hard link address, and class.
				$l_str_footnote_reference  = '<' . self::$a_str_link_span;
				$l_str_footnote_reference .= ' id="footnote_plugin_reference_';
				$l_str_footnote_reference .= self::$a_int_post_id;
				$l_str_footnote_reference .= '_' . self::$a_int_reference_container_id;
				$l_str_footnote_reference .= "_$l_str_footnote_id\"";
				if ( self::$a_bool_hard_links_enable ) {
					$l_str_footnote_reference .= ' href="#';
					$l_str_footnote_reference .= self::$a_str_referrer_link_slug;
					$l_str_footnote_reference .= self::$a_str_post_container_id_compound;
					$l_str_footnote_reference .= $l_str_footnote_id . '"';
					$l_str_footnote_reference .= $l_str_use_backbutton_hint;
				}
				$l_str_footnote_reference .= ' class="footnote_backlink"';

				// The click event goes in the table cell if footnote remains single.
				$l_str_backlink_event  = ' onclick="footnote_move_to_anchor_';
				$l_str_backlink_event .= self::$a_int_post_id;
				$l_str_backlink_event .= '_' . self::$a_int_reference_container_id;
				$l_str_backlink_event .= "('footnote_plugin_tooltip_";
				$l_str_backlink_event .= self::$a_int_post_id;
				$l_str_backlink_event .= '_' . self::$a_int_reference_container_id;
				$l_str_backlink_event .= "_$l_str_footnote_id');\"";

				// The dedicated template enumerating backlinks uses another variable.
				$l_str_footnote_backlinks = $l_str_footnote_reference;

				// Append the click event right to the backlink item for enumerations;.
				// Else it goes in the table cell.
				$l_str_footnote_backlinks .= $l_str_backlink_event . '>';
				$l_str_footnote_reference .= '>';

				// Append the optional offset anchor for hard links.
				if ( self::$a_bool_hard_links_enable ) {
					$l_str_footnote_reference .= $l_str_footnote_anchor_element;
					$l_str_footnote_backlinks .= $l_str_footnote_anchor_element;
				}

				// Continue both single note and notes cluster, depending on switch option status.
				if ( $l_bool_symbol_switch ) {

					$l_str_footnote_reference .= "$l_str_footnote_id$l_str_footnote_arrow";
					$l_str_footnote_backlinks .= "$l_str_footnote_id$l_str_footnote_arrow";

				} else {

					$l_str_footnote_reference .= "$l_str_footnote_arrow$l_str_footnote_id";
					$l_str_footnote_backlinks .= "$l_str_footnote_arrow$l_str_footnote_id";

				}

				// If that is the only footnote with this text, we’re almost done..

				// Check if it isn't the last footnote in the array.
				if ( $l_int_first_footnote_index < count( self::$a_arr_footnotes ) ) {

					// Get all footnotes that haven't passed yet.
					$num_footnotes = count( self::$a_arr_footnotes );
					for ( $l_int_check_index = $l_int_first_footnote_index; $l_int_check_index < $num_footnotes; $l_int_check_index++ ) {

						// Check if a further footnote is the same as the actual one.
						if ( self::$a_arr_footnotes[ $l_int_check_index ] === $l_str_footnote_text ) {

							// If so, set the further footnote as empty so it won't be displayed later.
							self::$a_arr_footnotes[ $l_int_check_index ] = '';

							// Set the flag to true for the combined status.
							$l_bool_flag_combined = true;

							// Update the footnote ID.
							$l_str_footnote_id = MCI_Footnotes_Convert::index( ( $l_int_check_index + 1 ), MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) );

							// Resume composing the backlinks enumeration.
							$l_str_footnote_backlinks .= "$l_str_separator</";
							$l_str_footnote_backlinks .= self::$a_str_link_span . '>';
							$l_str_footnote_backlinks .= $l_str_line_break;
							$l_str_footnote_backlinks .= '<' . self::$a_str_link_span;
							$l_str_footnote_backlinks .= ' id="footnote_plugin_reference_';
							$l_str_footnote_backlinks .= self::$a_int_post_id;
							$l_str_footnote_backlinks .= '_' . self::$a_int_reference_container_id;
							$l_str_footnote_backlinks .= "_$l_str_footnote_id\"";

							// Insert the optional hard link address.
							if ( self::$a_bool_hard_links_enable ) {
								$l_str_footnote_backlinks .= ' href="#';
								$l_str_footnote_backlinks .= self::$a_str_referrer_link_slug;
								$l_str_footnote_backlinks .= self::$a_str_post_container_id_compound;
								$l_str_footnote_backlinks .= $l_str_footnote_id . '"';
								$l_str_footnote_backlinks .= $l_str_use_backbutton_hint;
							}

							$l_str_footnote_backlinks .= ' class="footnote_backlink"';
							$l_str_footnote_backlinks .= ' onclick="footnote_move_to_anchor_';
							$l_str_footnote_backlinks .= self::$a_int_post_id;
							$l_str_footnote_backlinks .= '_' . self::$a_int_reference_container_id;
							$l_str_footnote_backlinks .= "('footnote_plugin_tooltip_";
							$l_str_footnote_backlinks .= self::$a_int_post_id;
							$l_str_footnote_backlinks .= '_' . self::$a_int_reference_container_id;
							$l_str_footnote_backlinks .= "_$l_str_footnote_id');\">";

							// Append the offset anchor for optional hard links.
							if ( self::$a_bool_hard_links_enable ) {
								$l_str_footnote_backlinks .= '<span class="footnote_item_base"><span id="';
								$l_str_footnote_backlinks .= self::$a_str_footnote_link_slug;
								$l_str_footnote_backlinks .= self::$a_str_post_container_id_compound;
								$l_str_footnote_backlinks .= $l_str_footnote_id;
								$l_str_footnote_backlinks .= '" class="footnote_item_anchor"></span></span>';
							}

							$l_str_footnote_backlinks .= $l_bool_symbol_switch ? '' : $l_str_footnote_arrow;
							$l_str_footnote_backlinks .= $l_str_footnote_id;
							$l_str_footnote_backlinks .= $l_bool_symbol_switch ? $l_str_footnote_arrow : '';

						}
					}
				}

				// Append terminator and end tag.
				$l_str_footnote_reference .= $l_str_terminator . '</' . self::$a_str_link_span . '>';
				$l_str_footnote_backlinks .= $l_str_terminator . '</' . self::$a_str_link_span . '>';

			}

			// Line wrapping of URLs already fixed, see above.

			// Get reference container item text if tooltip text goes separate.
			$l_int_tooltip_text_length = strpos( $l_str_footnote_text, self::$a_str_tooltip_shortcode );
			$l_bool_has_tooltip_text   = ! $l_int_tooltip_text_length ? false : true;
			if ( $l_bool_has_tooltip_text ) {
				$l_str_not_tooltip_text           = substr( $l_str_footnote_text, ( $l_int_tooltip_text_length + self::$a_int_tooltip_shortcode_length ) );
				self::$a_bool_mirror_tooltip_text = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE ) );
				if ( self::$a_bool_mirror_tooltip_text ) {
					$l_str_tooltip_text              = substr( $l_str_footnote_text, 0, $l_int_tooltip_text_length );
					$l_str_reference_text_introducer = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR );
					$l_str_reference_text            = $l_str_tooltip_text . $l_str_reference_text_introducer . $l_str_not_tooltip_text;
				} else {
					$l_str_reference_text = $l_str_not_tooltip_text;
				}
			} else {
				$l_str_reference_text = $l_str_footnote_text;
			}

			// Replace all placeholders in table row template.
			$l_obj_template->replace(
				array(

					// Placeholder used in all templates.
					'text'           => $l_str_reference_text,

					// Used in standard layout W/O COMBINED FOOTNOTES.
					'post_id'        => self::$a_int_post_id,
					'container_id'   => self::$a_int_reference_container_id,
					'note_id'        => MCI_Footnotes_Convert::index( $l_int_first_footnote_index, MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) ),
					'link-start'     => self::$a_str_link_open_tag,
					'link-end'       => self::$a_str_link_close_tag,
					'link-span'      => self::$a_str_link_span,
					'terminator'     => $l_str_terminator,
					'anchor-element' => $l_str_footnote_anchor_element,
					'hard-link'      => $l_str_hard_link_address,

					// Used in standard layout WITH COMBINED IDENTICALS TURNED ON.
					'pointer'        => $l_bool_flag_combined ? '' : ' pointer',
					'event'          => $l_bool_flag_combined ? '' : $l_str_backlink_event,
					'backlinks'      => $l_bool_flag_combined ? $l_str_footnote_backlinks : $l_str_footnote_reference,

					// Legacy placeholders for use in legacy layout templates.
					'arrow'          => $l_str_footnote_arrow,
					'index'          => $l_str_footnote_id,
				)
			);

			$l_str_body .= $l_obj_template->get_content();

			// Extra line breaks for page source readability.
			$l_str_body .= "\r\n\r\n";

			$l_obj_template->reload();

		}

		// Call again for robustness when priority levels don’t match any longer.
		self::$a_int_scroll_offset = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET ) );

		// Streamline.
		$l_bool_collapse_default = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE ) );

		/**
		 * Reference container label.
		 *
		 * - Bugfix: Reference container: Label: set empty label to U+202F NNBSP for more robustness, thanks to @lukashuggenberg feedback.
		 *
		 * @since 2.4.0
		 * @date 2021-01-04T0504+0100
		 *
		 * @reporter @lukashuggenberg
		 *
		 * Themes may drop-cap a first letter of initial paragraphs, like this label.
		 * In case of empty label that would apply to the left half button character.
		 * Hence the point in setting an empty label to U+202F NARROW NO-BREAK SPACE.
		 */
		$l_str_reference_container_label = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME );

		/**
		 * Select the reference container template according to the script mode.
		 *
		 * - Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
		 *
		 * @since 2.5.6
		 *
		 * @reporter @hopper87it
		 * @link https://wordpress.org/support/topic/footnotes-wp-rocket/
		 *
		 * @reporter @pkverma99
		 * @link https://wordpress.org/support/topic/footnotes-wp-rocket/#post-14076188
		 */
		$l_str_ScriptMode = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE);

		if ( $l_str_ScriptMode == 'jquery' ) {

			// load 'templates/public/reference-container.html':
			$l_obj_TemplateContainer = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container");

		} else {

			// load 'templates/public/js-reference-container.html':
			$l_obj_TemplateContainer = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "js-reference-container");
		}

		$l_obj_TemplateContainer->replace(
			array(
				'post_id'         => self::$a_int_post_id,
				'container_id'    => self::$a_int_reference_container_id,
				'element'         => MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT ),
				'name'            => empty( $l_str_reference_container_label ) ? '&#x202F;' : $l_str_reference_container_label,
				'button-style'    => ! $l_bool_collapse_default ? 'display: none;' : '',
				'style'           => $l_bool_collapse_default ? 'display: none;' : '',
				'content'         => $l_str_body,
				'scroll-offset'   => ( self::$a_int_scroll_offset / 100 ),
				'scroll-duration' => intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION ) ),
			)
		);

		// Free all found footnotes if reference container will be displayed.
		self::$a_arr_footnotes = array();

		return $l_obj_template_container->get_content();
	}
}
