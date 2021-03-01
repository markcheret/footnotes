<?php
/**
 * Includes the core function of the Plugin - Search and Replace the Footnotes.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0
 *
 * @lastmodified  2021-02-27T0225+0100
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
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Task {

	/**
	 *        PROPERTIES
	 */

	/**
	 * Contains all footnotes found on current public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	public static $a_arr_Footnotes = array();

	/**
	 * Flag if the display of 'LOVE FOOTNOTES' is allowed on the current public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var bool
	 */
	public static $a_bool_AllowLoveMe = true;

	/**
	 * Prefix for the Footnote html element ID.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.8
	 * @var string
	 */
	public static $a_str_Prefix = "";

	/**
	 * Infinite scroll / autoload or archive view
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
	 * post ID to make everything unique wrt infinite scroll and archive view:
	 */
	public static $a_int_PostId = 0;

	/**
	 * Multiple reference containers in content and widgets
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
	public static $a_int_ReferenceContainerId = 1;

	/**
	 * Template process optimization
	 *
	 * - Bugfix: Templates: optimize template load and processing based on settings, thanks to @misfist code contribution.
	 *
	 * @since 2.4.0
	 * @date 2021-01-04T1355+0100
	 *
	 * @author Patrizia Lutz @misfist
	 *
	 * @link https://wordpress.org/support/topic/template-override-filter/#post-13864301
	 * @link https://github.com/misfist/footnotes/releases/tag/2.4.0d3 repository
	 * @link https://github.com/misfist/footnotes/compare/2.4.0%E2%80%A62.4.0d3 diff
	 *
	 * @var bool
	 *
	 * Streamline process depending on tooltip enabled status.
	 * Load tooltip inline script only if jQuery tooltips are enabled.
	 * Actual value depends on settings.
	 */
	public static $a_bool_TooltipsEnabled = false;
	public static $a_bool_AlternativeTooltipsEnabled = false;

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
	 */
	public static $a_bool_HardLinksEnable        = false;
	public static $a_str_ReferrerLinkSlug        = 'r';
	public static $a_str_FootnoteLinkSlug        = 'f';
	public static $a_str_LinkIdsSeparator        = '+';
	public static $a_str_PostContainerIdCompound = '';

	/**
	 * Scroll offset
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
	public static $a_int_ScrollOffset            = 34;

	/**
	 * Optional link element for footnote referrers and backlinks
	 *
	 * @since 2.0.0  add link elements along with hard links.
	 *
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
	 * @see self::$a_bool_HardLinksEnable
	 */
	public static $a_str_LinkSpan     = 'span';
	public static $a_str_LinkOpenTag  = '';
	public static $a_str_LinkCloseTag = '';

	/**
	 * Dedicated tooltip text
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
	public static $a_bool_MirrorTooltipText = false;
	public static $a_str_TooltipShortcode = '[[/tooltip]]';
	public static $a_int_TooltipShortcodeLength = 12;

	/**
	 * Footnote delimiter syntax validation
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
	public static $a_bool_SyntaxErrorFlag = true;



	/**
	 *        METHODS
	 */

	/**
	 * Register WordPress Hooks to replace Footnotes in the content of a public page.
	 *
	 * @author Stefan Herndler
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
	public function registerHooks() {

		/**
		 * Priority levels
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
		 * priority needs to be at least 1200 (i.e. 0 =< $l_int_TheContentPriority =< 1200).
		 *
		 * PHP_INT_MAX cannot be reset by leaving the number box empty. because browsers
		 * (WebKit) don’t allow it, so we must resort to -1.
		 * @link https://github.com/Modernizr/Modernizr/issues/171
		 */

		// get values from settings:
		$l_int_TheTitlePriority    = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL));
		$l_int_TheContentPriority  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL));
		$l_int_TheExcerptPriority  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL));
		$l_int_WidgetTitlePriority = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL));
		$l_int_WidgetTextPriority  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL));

		// PHP_INT_MAX can be set by -1:
		$l_int_TheTitlePriority    = ($l_int_TheTitlePriority    == -1) ? PHP_INT_MAX : $l_int_TheTitlePriority   ;
		$l_int_TheContentPriority  = ($l_int_TheContentPriority  == -1) ? PHP_INT_MAX : $l_int_TheContentPriority ;
		$l_int_TheExcerptPriority  = ($l_int_TheExcerptPriority  == -1) ? PHP_INT_MAX : $l_int_TheExcerptPriority ;
		$l_int_WidgetTitlePriority = ($l_int_WidgetTitlePriority == -1) ? PHP_INT_MAX : $l_int_WidgetTitlePriority;
		$l_int_WidgetTextPriority  = ($l_int_WidgetTextPriority  == -1) ? PHP_INT_MAX : $l_int_WidgetTextPriority ;


		// append custom css to the header
		add_filter('wp_head', array($this, "wp_head"), PHP_INT_MAX);

		// append the love and share me slug to the footer
		add_filter('wp_footer', array($this, "wp_footer"), PHP_INT_MAX);

		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_TITLE))) {
			add_filter('the_title', array($this, "the_title"), $l_int_TheTitlePriority);
		}

		// configurable priority level for reference container relative positioning; default 98:
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_CONTENT))) {
			add_filter('the_content', array($this, "the_content"), $l_int_TheContentPriority);

			/**
			 * Hook for category pages
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
			add_filter('term_description', array($this, "the_content"), $l_int_TheContentPriority);

			/**
			 * Hook for popup maker popups
			 *
			 * - Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
			 *
			 * @since 2.5.1
			 * @date 2021-01-18T2038+0100
			 *
			 * @reporter @squatcher
			 * @link https://wordpress.org/support/topic/footnotes-use-in-popup-maker/
			 */
			add_filter('pum_popup_content', array($this, "the_content"), $l_int_TheContentPriority);
		}

		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_EXCERPT))) {
			 add_filter('the_excerpt', array($this, "the_excerpt"), $l_int_TheExcerptPriority);
		}
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE))) {
			add_filter('widget_title', array($this, "widget_title"), $l_int_WidgetTitlePriority);
		}
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT))) {
			add_filter('widget_text', array($this, "widget_text"), $l_int_WidgetTextPriority);
		}


		/**
		 * The the_post hook
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

		// reset stored footnotes when displaying the header
		self::$a_arr_Footnotes = array();
		self::$a_bool_AllowLoveMe = true;
	}

	/**
	 * Outputs the custom css to the header of the public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 *
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

		// insert start tag without switching out of PHP:
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
		$l_str_NormalizeSuperscript = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT );
		if ( $l_str_NormalizeSuperscript !== 'no' ) {
			if ( $l_str_NormalizeSuperscript === 'all' ) {
				echo "sup {";
			} else {
				echo ".footnote_plugin_tooltip_text {";
			}
			echo "vertical-align: super; font-size: smaller; position: static;}\r\n";
		}

		/**
		 * Reference container display on home page
		 *
		 * - Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
		 *
		 * @since 2.1.1
		 *
		 * @reporter @dragon013
		 * @link https://wordpress.org/support/topic/possible-to-hide-it-from-start-page/
		 */
		if (!MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE))) {
			echo ".home .footnotes_reference_container { display: none; }\r\n";
		}

		/**
		 * Reference container top and bottom margins
		 *
		 * - Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
		 *
		 * @since 2.3.0
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
		 */
		$l_int_ReferenceContainerTopMargin = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN));
		$l_int_ReferenceContainerBottomMargin = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN));
		echo ".footnotes_reference_container {margin-top: ";
		echo empty($l_int_ReferenceContainerTopMargin) ? '0' : $l_int_ReferenceContainerTopMargin;
		echo "px !important; margin-bottom: ";
		echo empty($l_int_ReferenceContainerBottomMargin) ? '0' : $l_int_ReferenceContainerBottomMargin;
		echo "px !important;}\r\n";

		/**
		 * Reference container label bottom border
		 *
		 * - Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
		 * - Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
		 *
		 * @since 2.2.5
		 * @date 2020-12-18T1447+0100
		 *
		 * @reporter @markhillyer
		 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
		 *
		 */
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER))) {
			echo ".footnote_container_prepare > ";
			echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT);
			echo " {border-bottom: 1px solid #aaaaaa !important;}\r\n";
		}

		/**
		 * Reference container table row borders
		 *
		 * - Bugfix: Reference container: add option for table borders to restore pre-2.0.0 design, thanks to @noobishh issue report.
		 *
		 * @since 2.2.10
		 * @date 2020-12-25T2304+0100
		 *
		 * @reporter @noobishh
		 * @link https://wordpress.org/support/topic/borders-25/
		 */
		if ( MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE))) {
			echo ".footnotes_table, .footnotes_plugin_reference_row {";
			echo "border: 1px solid #060606;";
			echo " !important;}\r\n";
			// adapt left padding to the presence of a border:
			echo ".footnote_plugin_index, .footnote_plugin_index_combi {";
			echo "padding-left: 6px !important}\r\n";
		}

		// ref container first column width and max-width:
		$l_bool_ColumnWidthEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED));
		$l_bool_ColumnMaxWidthEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED));

		if ( $l_bool_ColumnWidthEnabled || $l_bool_ColumnMaxWidthEnabled ) {
			echo ".footnote-reference-container { table-layout: fixed; }";
			echo ".footnote_plugin_index, .footnote_plugin_index_combi {";

			if ( $l_bool_ColumnWidthEnabled ) {

				$l_int_ColumnWidthScalar = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR);
				$l_str_ColumnWidthUnit = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT);

				if (!empty($l_int_ColumnWidthScalar)) {
					if ($l_str_ColumnWidthUnit == '%') {
						if ($l_int_ColumnWidthScalar > 100) {
							$l_int_ColumnWidthScalar = 100;
						}
					}
				} else {
					$l_int_ColumnWidthScalar = 0;
				}

				echo " width: $l_int_ColumnWidthScalar$l_str_ColumnWidthUnit !important;";
			}

			if ( $l_bool_ColumnMaxWidthEnabled ) {

				$l_int_ColumnMaxWidthScalar = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR);
				$l_str_ColumnMaxWidthUnit = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT);

				if (!empty($l_int_ColumnMaxWidthScalar)) {
					if ($l_str_ColumnMaxWidthUnit == '%') {
						if ($l_int_ColumnMaxWidthScalar > 100) {
							$l_int_ColumnMaxWidthScalar = 100;
						}
					}
				} else {
					$l_int_ColumnMaxWidthScalar = 0;
				}

				echo " max-width: $l_int_ColumnMaxWidthScalar$l_str_ColumnMaxWidthUnit !important;";

			}
		echo "}\r\n";
		}

		/**
		 * Hard links scroll offset
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

		// tooltips:
		self::$a_bool_TooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED));
		self::$a_bool_AlternativeTooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE));

		if (self::$a_bool_TooltipsEnabled) {

			echo '.footnote_tooltip {';

			// tooltip appearance:

			/**
			 * Tooltip font size
			 *
			 * - Bugfix: Styling: Tooltips: fix font size issue by adding font size to settings with legacy as default.
			 *
			 * @since 2.1.4
			 * @date 2020-12-03T0954+0100
			 */
			echo ' font-size: ';
			if(MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED))) {
				echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR);
				echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT);
			} else {
				echo 'inherit';
			}
			echo ' !important;';

			// text color:
			$l_str_Color = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR);
			if (!empty($l_str_Color)) {
				printf(" color: %s !important;", $l_str_Color);
			}

			// background color:
			$l_str_Background = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND);
			if (!empty($l_str_Background)) {
				printf(" background-color: %s !important;", $l_str_Background);
			}

			// border width:
			$l_int_BorderWidth = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH);
			if (!empty($l_int_BorderWidth) && intval($l_int_BorderWidth) > 0) {
				printf(" border-width: %dpx !important; border-style: solid !important;", $l_int_BorderWidth);
			}

			// border color:
			$l_str_BorderColor = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR);
			if (!empty($l_str_BorderColor)) {
				printf(" border-color: %s !important;", $l_str_BorderColor);
			}

			// corner radius:
			$l_int_BorderRadius = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS);
			if (!empty($l_int_BorderRadius) && intval($l_int_BorderRadius) > 0) {
				printf(" border-radius: %dpx !important;", $l_int_BorderRadius);
			}

			// shadow color:
			$l_str_BoxShadowColor = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR);
			if (!empty($l_str_BoxShadowColor)) {
				printf(" -webkit-box-shadow: 2px 2px 11px %s;", $l_str_BoxShadowColor);
				printf(" -moz-box-shadow: 2px 2px 11px %s;", $l_str_BoxShadowColor);
				printf(" box-shadow: 2px 2px 11px %s;", $l_str_BoxShadowColor);
			}


			/**
			 * Tooltip position and timing
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
			// jQuery tooltips:
			if ( ! self::$a_bool_AlternativeTooltipsEnabled) {

				// tooltip position:
				$l_int_MaxWidth = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH);
				if (!empty($l_int_MaxWidth) && intval($l_int_MaxWidth) > 0) {
					printf(" max-width: %dpx !important;", $l_int_MaxWidth);
				}
				echo "}\r\n";

			// alternative tooltips:
			} else {
				echo "}\r\n";

				// dimensions:
				$l_int_AlternativeTooltipWidth = intval( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH ) );
				echo ".footnote_tooltip.position {";
				echo " width: " . $l_int_AlternativeTooltipWidth . 'px;';
				// set also as max-width wrt short tooltip shrinking:
				echo " max-width: " . $l_int_AlternativeTooltipWidth . 'px;';

				// position:
				$l_str_AlternativePosition = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION);
				$l_int_OffsetX = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X));

				if ($l_str_AlternativePosition == 'top left' || $l_str_AlternativePosition == 'bottom left') {
					echo ' right: ' . ( !empty($l_int_OffsetX) ? $l_int_OffsetX : 0) . 'px;';
				} else {
					echo ' left: ' . ( !empty($l_int_OffsetX) ? $l_int_OffsetX : 0) . 'px;';
				}

				$l_int_OffsetY = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y));

				if ($l_str_AlternativePosition == 'top left' || $l_str_AlternativePosition == 'top right') {
					echo ' bottom: ' . ( !empty($l_int_OffsetY) ? $l_int_OffsetY : 0) . 'px;';
				} else {
					echo ' top: ' . ( !empty($l_int_OffsetY) ? $l_int_OffsetY : 0) . 'px;';
				}
				echo "}\r\n";

				// timing:
				// jQuery tooltip timing is in templates/public/tooltip.html, filled in after line 690 below.
				echo ' .footnote_tooltip.shown {';
				$l_int_FadeInDelay     = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY    ));
				$l_int_FadeInDuration  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ));
				$l_int_FadeInDelay     = !empty($l_int_FadeInDelay    ) ? $l_int_FadeInDelay     : '0';
				$l_int_FadeInDuration  = !empty($l_int_FadeInDuration ) ? $l_int_FadeInDuration  : '0';
				echo " transition-delay: $l_int_FadeInDelay" . 'ms;';
				echo " transition-duration: $l_int_FadeInDuration" . 'ms;';

				echo '} .footnote_tooltip.hidden {';
				$l_int_FadeOutDelay    = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY   ));
				$l_int_FadeOutDuration = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION));
				$l_int_FadeOutDelay     = !empty($l_int_FadeOutDelay    ) ? $l_int_FadeOutDelay     : '0';
				$l_int_FadeOutDuration  = !empty($l_int_FadeOutDuration ) ? $l_int_FadeOutDuration  : '0';
				echo " transition-delay: $l_int_FadeOutDelay" . 'ms;';
				echo " transition-duration: $l_int_FadeOutDuration" . 'ms;';

				echo "}\r\n";

			}
		}

		/**
		 * Custom CSS
		 *
		 * - Bugfix: Custom CSS: insert new CSS in the public page header element after existing CSS.
		 *
		 * @since 2.2.3
		 * @date 2020-12-15T1128+0100
		 *
		 * Set custom CSS to override settings, not conversely.
		 * Legacy Custom CSS is used until it’s set to disappear after dashboard tab migration.
		 */
		 if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE))) {
			 echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS);
			 echo "\r\n";
		}
		echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_NEW);

		// insert end tag without switching out of PHP:
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
		 * The script for alternative tooltips is printed formatted, not minified:
		 */
		if ( self::$a_bool_AlternativeTooltipsEnabled ) {
			?>
<script content="text/javascript">
	function footnoteTooltipShow(footnoteTooltipId) {
		document.getElementById(footnoteTooltipId).classList.remove('hidden');
		document.getElementById(footnoteTooltipId).classList.add('shown');
	}
	function footnoteTooltipHide(footnoteTooltipId) {
		document.getElementById(footnoteTooltipId).classList.remove('shown');
		document.getElementById(footnoteTooltipId).classList.add('hidden');
	}
</script>
<?php
		};
	}

	/**
	 * Displays the 'LOVE FOOTNOTES' slug if enabled.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 *
	 *
	 * @since 2.2.0  more options  2020-12-11T0506+0100
	 */
	public function wp_footer() {
		if (MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "footer") {
			echo $this->ReferenceContainer();
		}
		// get setting for love and share this plugin
		$l_str_LoveMeIndex = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE);
		// check if the admin allows to add a link to the footer
		if (empty($l_str_LoveMeIndex) || strtolower($l_str_LoveMeIndex) == "no" || !self::$a_bool_AllowLoveMe) {
			return;
		}
		// set a hyperlink to the word "footnotes" in the Love slug
		$l_str_LinkedName = sprintf('<a href="https://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">%s</a>', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME);
		// get random love me text
		if (strtolower($l_str_LoveMeIndex) == "random") {
			$l_str_LoveMeIndex = "text-" . rand(1,7);
		}
		switch ($l_str_LoveMeIndex) {
			// options named wrt backcompat, simplest is default:
			case "text-1": $l_str_LoveMeText = sprintf(__('I %2$s %1$s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL); break;
			case "text-2": $l_str_LoveMeText = sprintf(__('This website uses the awesome %s plugin.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName); break;
			case "text-4": $l_str_LoveMeText = sprintf('%s %s', $l_str_LinkedName, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL); break;
			case "text-5": $l_str_LoveMeText = sprintf('%s %s', MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, $l_str_LinkedName); break;
			case "text-6": $l_str_LoveMeText = sprintf(__('This website uses %s.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName); break;
			case "text-7": $l_str_LoveMeText = sprintf(__('This website uses the %s plugin.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName); break;
			case "text-3": default: $l_str_LoveMeText = sprintf('%s', $l_str_LinkedName); break;
		}
		echo sprintf('<div style="text-align:center; color:#acacac;">%s</div>', $l_str_LoveMeText);
	}

	/**
	 * Replaces footnotes in the post/page title.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function the_title($p_str_Content) {
		// appends the reference container if set to "post_end"
		return $this->exec($p_str_Content, false);
	}

	/**
	 * Replaces footnotes in the content of the current page/post.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Page/Post content.
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
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Page/Post content.
	 * @return string Content with replaced footnotes.
	 */
	public function the_excerpt($p_str_Content) {
		return $this->exec($p_str_Content, false, !MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT)));
	}

	/**
	 * Replaces footnotes in the widget title.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function widget_title($p_str_Content) {
		// appends the reference container if set to "post_end"
		return $this->exec($p_str_Content, false);
	}

	/**
	 * Replaces footnotes in the content of the current widget.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function widget_text($p_str_Content) {
		// appends the reference container if set to "post_end"
		return $this->exec($p_str_Content, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "post_end" ? true : false);
	}

	/**
	 * Replaces footnotes in each Content var of the current Post object.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.4
	 * @param array|WP_Post $p_mixed_Posts
	 */
	public function the_post(&$p_mixed_Posts) {
		// single WP_Post object received
		if (!is_array($p_mixed_Posts)) {
			$p_mixed_Posts = $this->replacePostObject($p_mixed_Posts);
			return;
		}
		// array of WP_Post objects received
		for($l_int_Index = 0; $l_int_Index < count($p_mixed_Posts); $l_int_Index++) {
			$p_mixed_Posts[$l_int_Index] = $this->replacePostObject($p_mixed_Posts[$l_int_Index]);
		}
	}

	/**
	 * Replace all Footnotes in a WP_Post object.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @param WP_Post $p_obj_Post
	 * @return WP_Post
	 */
	private function replacePostObject($p_obj_Post) {
		//MCI_Footnotes_Convert::debug($p_obj_Post);
		$p_obj_Post->post_content = $this->exec($p_obj_Post->post_content);
		$p_obj_Post->post_content_filtered = $this->exec($p_obj_Post->post_content_filtered);
		$p_obj_Post->post_excerpt = $this->exec($p_obj_Post->post_excerpt);
		return $p_obj_Post;
	}

	/**
	 * Replaces all footnotes that occur in the given content.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Any string that may contain footnotes to be replaced.
	 * @param bool $p_bool_OutputReferences Appends the Reference Container to the output if set to true, default true.
	 * @param bool $p_bool_HideFootnotesText Hide footnotes found in the string.
	 * @return string
	 *
	 *
	 * @since 2.2.0  Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
	 * @since 2.2.5  Bugfix: Reference container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe bug report.
	 */
	public function exec($p_str_Content, $p_bool_OutputReferences = false, $p_bool_HideFootnotesText = false) {

		// replace all footnotes in the content, settings are converted to html characters
		$p_str_Content = $this->search($p_str_Content, true, $p_bool_HideFootnotesText);
		// replace all footnotes in the content, settings are NOT converted to html characters
		$p_str_Content = $this->search($p_str_Content, false, $p_bool_HideFootnotesText);

		/**
		 * Reference container customized positioning through shortcode
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
		 *
		 */
		// append the reference container or insert at shortcode:
		$l_str_ReferenceContainerPositionShortcode = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE);
		if ( empty( $l_str_ReferenceContainerPositionShortcode ) ) {
			$l_str_ReferenceContainerPositionShortcode = '[[references]]';
		}

		if ( $p_bool_OutputReferences ) {

			if ( strpos( $p_str_Content, $l_str_ReferenceContainerPositionShortcode ) !== false ) {

				$p_str_Content = str_replace( $l_str_ReferenceContainerPositionShortcode, $this->ReferenceContainer(), $p_str_Content );

			} else {

				$p_str_Content .= $this->ReferenceContainer();

			}

			// increment the container ID:
			self::$a_int_ReferenceContainerId++;
		}

		// delete position shortcode should any remain:
		$p_str_Content = str_replace( $l_str_ReferenceContainerPositionShortcode, '', $p_str_Content );

		// take a look if the LOVE ME slug should NOT be displayed on this page/post, remove the short code if found
		if (strpos($p_str_Content, MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG) !== false) {
			self::$a_bool_AllowLoveMe = false;
			$p_str_Content = str_replace(MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG, "", $p_str_Content);
		}
		// return the content with replaced footnotes and optional reference container appended:
		return $p_str_Content;
	}

	/**
	 * Replaces all footnotes in the given content and appends them to the static property.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Content to be searched for footnotes.
	 * @param bool $p_bool_ConvertHtmlChars html encode settings, default true.
	 * @param bool $p_bool_HideFootnotesText Hide footnotes found in the string.
	 * @return string
	 *
	 * @since 2.0.0  various.
	 * @since 2.4.0  Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
	 */
	public function search($p_str_Content, $p_bool_ConvertHtmlChars, $p_bool_HideFootnotesText) {

		// post ID to make everything unique wrt infinite scroll and archive view
		self::$a_int_PostId = get_the_id();

		// contains the index for the next footnote on this page
		$l_int_FootnoteIndex = count(self::$a_arr_Footnotes) + 1;

		// contains the starting position for the lookup of a footnote
		$l_int_PosStart = 0;

		// get start and end tag for the footnotes short code
		$l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START);
		$l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END);
		if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
			$l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED);
			$l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED);
		}
		// decode html special chars
		if ($p_bool_ConvertHtmlChars) {
			$l_str_StartingTag = htmlspecialchars($l_str_StartingTag);
			$l_str_EndingTag = htmlspecialchars($l_str_EndingTag);
		}

		// if footnotes short code is empty, return the content without changes
		if (empty($l_str_StartingTag) || empty($l_str_EndingTag)) {
			return $p_str_Content;
		}

		/**
		 * Footnote delimiter syntax validation
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
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE))) {

			// make shortcodes conform to regex syntax:
			$l_str_StartTagRegex = preg_replace( '#([\(\)\{\}\[\]\*\.\?\!])#', '\\\\$1', $l_str_StartingTag );
			$l_str_EndTagRegex = preg_replace( '#([\(\)\{\}\[\]\*\.\?\!])#', '\\\\$1', $l_str_EndingTag );

			// apply different regex depending on whether start shortcode is double/triple opening parenthesis:
			if ( $l_str_StartingTag == '((' || $l_str_StartingTag == '(((' ) {

				// this prevents from catching a script containing e.g. a double opening parenthesis:
				$l_str_ValidationRegex = '#' . $l_str_StartTagRegex . '(((?!' . $l_str_EndTagRegex . ')[^\{\}])*?)(' . $l_str_StartTagRegex . '|$)#s';

			} else {

				// catch all only if the start shortcode is not double/triple opening parenthesis, i.e. is unlikely to occur in scripts:
				$l_str_ValidationRegex = '#' . $l_str_StartTagRegex . '(((?!' . $l_str_EndTagRegex . ').)*?)(' . $l_str_StartTagRegex . '|$)#s';
			}

			// check syntax and get error locations:
			preg_match( $l_str_ValidationRegex, $p_str_Content, $p_arr_ErrorLocation );
			if ( empty( $p_arr_ErrorLocation ) ) {
				self::$a_bool_SyntaxErrorFlag = false;
			}

			// prevent generating and inserting the warning multiple times:
			if ( self::$a_bool_SyntaxErrorFlag ) {

				// get plain text string for error location:
				$l_str_ErrorSpotString = strip_tags( $p_arr_ErrorLocation[1] );

				// limit string length to 300 characters:
				if ( strlen( $l_str_ErrorSpotString ) > 300 ) {
					$l_str_ErrorSpotString = substr( $l_str_ErrorSpotString, 0, 299 ) . '…';
				}

				// compose warning box:
				$l_str_SyntaxErrorWarning  = '<div class="footnotes_validation_error"><p>';
				$l_str_SyntaxErrorWarning .= __("WARNING: unbalanced footnote start tag short code found.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
				$l_str_SyntaxErrorWarning .= '</p><p>';

				// syntax validation setting in the dashboard under the General settings tab:
				$l_str_SyntaxErrorWarning .= sprintf( __("If this warning is irrelevant, please disable the syntax validation feature in the dashboard under %s &gt; %s &gt; %s.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("General settings", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Footnote start and end short codes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Check for balanced shortcodes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) );

				$l_str_SyntaxErrorWarning .= '</p><p>';
				$l_str_SyntaxErrorWarning .= __("Unbalanced start tag short code found before:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
				$l_str_SyntaxErrorWarning .= '</p><p>“';
				$l_str_SyntaxErrorWarning .= $l_str_ErrorSpotString;
				$l_str_SyntaxErrorWarning .= '”</p></div>';

				// prepend the warning box to the content:
				$p_str_Content = $l_str_SyntaxErrorWarning . $p_str_Content;

				// checked, set flag to false to prevent duplicate warning:
				self::$a_bool_SyntaxErrorFlag = false;

				return $p_str_Content;
			}
		}


		// load referrer templates if footnotes text not hidden:
		if (!$p_bool_HideFootnotesText) {

			// load footnote referrer template file:
			if (self::$a_bool_AlternativeTooltipsEnabled) {
				$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "footnote-alternative");
			} else {
				$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "footnote");
			}

			/**
			 * Call Boolean again for robustness when priority levels don’t match any longer.
			 *
			 * - Bugfix: Tooltips: fix display in Popup Maker popups by correcting a coding error.
			 *
			 * @since 2.5.4
			 * @see self::add_filter('pum_popup_content', array($this, "the_content"), $l_int_TheContentPriority)
			 */
			self::$a_bool_TooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED));
			self::$a_bool_AlternativeTooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE));

			// load tooltip inline script if jQuery tooltips are enabled:
			if (self::$a_bool_TooltipsEnabled && ! self::$a_bool_AlternativeTooltipsEnabled) {
				$l_obj_TemplateTooltip = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "tooltip");
			}

		} else {
			$l_obj_Template = null;
			$l_obj_TemplateTooltip = null;
		}

		// search footnotes short codes in the content
		do {
			// get first occurrence of the footnote start tag short code:
			$i_int_LenContent = strlen($p_str_Content);
			if ($l_int_PosStart > $i_int_LenContent) $l_int_PosStart = $i_int_LenContent;
			$l_int_PosStart = strpos($p_str_Content, $l_str_StartingTag, $l_int_PosStart);
			// no short code found, stop here
			if ($l_int_PosStart === false) {
				break;
			}
			// get first occurrence of the footnote end tag short code:
			$l_int_PosEnd = strpos($p_str_Content, $l_str_EndingTag, $l_int_PosStart);
			// no short code found, stop here
			if ($l_int_PosEnd === false) {
				break;
			}
			// calculate the length of the footnote
			$l_int_Length = $l_int_PosEnd - $l_int_PosStart;

			// get footnote text
			$l_str_FootnoteText = substr($p_str_Content, $l_int_PosStart + strlen($l_str_StartingTag), $l_int_Length - strlen($l_str_StartingTag));

			// get tooltip text if present:
			self::$a_str_TooltipShortcode = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER);
			self::$a_int_TooltipShortcodeLength = strlen( self::$a_str_TooltipShortcode );
			$l_int_TooltipTextLength = strpos( $l_str_FootnoteText, self::$a_str_TooltipShortcode );
			$l_bool_HasTooltipText = $l_int_TooltipTextLength === false ? false : true;
			if ( $l_bool_HasTooltipText ) {
				$l_str_TooltipText = substr( $l_str_FootnoteText, 0, $l_int_TooltipTextLength );
			} else {
				$l_str_TooltipText = '';
			}

			/**
			 * URL line wrapping for Unicode non conformant browsers
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
			if ( MCI_Footnotes_Convert::toBool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_URL_WRAP_ENABLED ) ) ) {

				$l_str_FootnoteText = preg_replace(
					'#(?<![-\w\.!~\*\'\(\);]=[\'"])(?<![-\w\.!~\*\'\(\);]=[\'"] )(?<![-\w\.!~\*\'\(\);]=[\'"]  )(?<![-\w\.!~\*\'\(\);]=)(?<!/)((ht|f)tps?://[^\\s<]+)#',
					'<span class="footnote_url_wrap">$1</span>',
					$l_str_FootnoteText
				);
			}

			// Text to be displayed instead of the footnote
			$l_str_FootnoteReplaceText = "";

			// whether hard links are enabled:
			if (self::$a_bool_HardLinksEnable) {

				// get the configurable parts:
				self::$a_str_ReferrerLinkSlug = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG);
				self::$a_str_FootnoteLinkSlug = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG);
				self::$a_str_LinkIdsSeparator = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR);

				// streamline ID concatenation:
				self::$a_str_PostContainerIdCompound  = self::$a_str_LinkIdsSeparator;
				self::$a_str_PostContainerIdCompound .= self::$a_int_PostId;
				self::$a_str_PostContainerIdCompound .= self::$a_str_LinkIdsSeparator;
				self::$a_str_PostContainerIdCompound .= self::$a_int_ReferenceContainerId;
				self::$a_str_PostContainerIdCompound .= self::$a_str_LinkIdsSeparator;

			}

			// display the footnote referrers and the tooltips:
			if (!$p_bool_HideFootnotesText) {
				$l_int_Index = MCI_Footnotes_Convert::Index($l_int_FootnoteIndex, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));

				// display only a truncated footnote text if option enabled:
				$l_bool_EnableExcerpt = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED));
				$l_int_MaxLength = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH));

				// define excerpt text as footnote text by default:
				$l_str_ExcerptText = $l_str_FootnoteText;

				/**
				 * Tooltip truncation
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
				if (self::$a_bool_TooltipsEnabled && $l_bool_EnableExcerpt) {
					$l_str_DummyText = strip_tags($l_str_FootnoteText);
					if (is_int($l_int_MaxLength) && strlen($l_str_DummyText) > $l_int_MaxLength) {
						$l_str_ExcerptText  = substr($l_str_DummyText, 0, $l_int_MaxLength);
						$l_str_ExcerptText  = substr($l_str_ExcerptText, 0, strrpos($l_str_ExcerptText, ' '));
						$l_str_ExcerptText .= '&nbsp;&#x2026; <';
						$l_str_ExcerptText .= self::$a_bool_HardLinksEnable ? 'a' : 'span';
						$l_str_ExcerptText .= ' class="footnote_tooltip_continue" ';
						$l_str_ExcerptText .= 'onclick="footnote_moveToAnchor_' . self::$a_int_PostId;
						$l_str_ExcerptText .= '_' . self::$a_int_ReferenceContainerId;
						$l_str_ExcerptText .= '(\'footnote_plugin_reference_' . self::$a_int_PostId;
						$l_str_ExcerptText .= '_' . self::$a_int_ReferenceContainerId;
						$l_str_ExcerptText .= "_$l_int_Index');\"";

						// if enabled, add the hard link fragment ID:
						if (self::$a_bool_HardLinksEnable) {

							$l_str_ExcerptText .= ' href="#';
							$l_str_ExcerptText .= self::$a_str_FootnoteLinkSlug;
							$l_str_ExcerptText .= self::$a_str_PostContainerIdCompound;
							$l_str_ExcerptText .= $l_int_Index;
							$l_str_ExcerptText .= '"';
						}

						$l_str_ExcerptText .= '>';

						/**
						 * Configurable read-on button label
						 *
						 * - Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
						 *
						 * @since 2.1.0
						 * @date 2020-11-08T2146+0100
						 *
						 * @reporter @rovanov
						 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
						 */
						$l_str_ExcerptText .= MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL);

						$l_str_ExcerptText .= self::$a_bool_HardLinksEnable ? '</a>' : '</span>';
					}
				}

				/**
				 * Referrers element superscript or baseline
				 *
				 * Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report
				 * @since 2.1.1
				 *
				 * @reporter @cwbayer
				 * @link https://wordpress.org/support/topic/footnote-number-in-text-superscript-disrupts-leading/
				 *
				 * define the HTML element to use for the referrers:
				 */
				if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS))) {

					$l_str_SupSpan = 'sup';

				} else {

					$l_str_SupSpan = 'span';
				}

				// whether hard links are enabled:
				if (self::$a_bool_HardLinksEnable) {

					self::$a_str_LinkSpan = 'a';
					self::$a_str_LinkCloseTag = '</a>';
					// self::$a_str_LinkOpenTag will be defined as needed

					// compose hyperlink address (leading space is in template):
					$l_str_FootnoteLinkArgument  = 'href="#';
					$l_str_FootnoteLinkArgument .= self::$a_str_FootnoteLinkSlug;
					$l_str_FootnoteLinkArgument .= self::$a_str_PostContainerIdCompound;
					$l_str_FootnoteLinkArgument .= $l_int_Index;
					$l_str_FootnoteLinkArgument .= '" class="footnote_hard_link"';

					/**
					 * Compose fragment ID anchor with offset, for use in reference container.
					 * Empty span, child of empty span, to avoid tall dotted rectangles in browser.
					 */
					$l_str_ReferrerAnchorElement  = '<span class="footnote_referrer_base"><span id="';
					$l_str_ReferrerAnchorElement .= self::$a_str_ReferrerLinkSlug;
					$l_str_ReferrerAnchorElement .= self::$a_str_PostContainerIdCompound;
					$l_str_ReferrerAnchorElement .= $l_int_Index;
					$l_str_ReferrerAnchorElement .= '" class="footnote_referrer_anchor"></span></span>';

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
					$l_str_FootnoteLinkArgument = '';
					$l_str_ReferrerAnchorElement = '';

					// The link element is set independently as it may be needed for styling:
					if ( MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED)) ) {

						self::$a_str_LinkSpan = 'a';
						self::$a_str_LinkOpenTag = '<a>';
						self::$a_str_LinkCloseTag = '</a>';

					}
				}

				// determine tooltip content:
				if ( self::$a_bool_TooltipsEnabled ) {
					$l_str_TooltipContent = $l_bool_HasTooltipText ? $l_str_TooltipText : $l_str_ExcerptText;
				} else {
					$l_str_TooltipContent = '';
				}

				/**
				 * Determine shrink width if alternative tooltips are enabled.
				 *
				 * @since 2.5.6
				 */
				$l_str_TooltipStyle = '';
				if ( self::$a_bool_AlternativeTooltipsEnabled && self::$a_bool_TooltipsEnabled ) {
					$l_int_TooltipLength = strlen( strip_tags( $l_str_TooltipContent ) );
					if ( $l_int_TooltipLength < 70 ) {
						$l_str_TooltipStyle  = ' style="width: ';
						$l_str_TooltipStyle .= ( $l_int_TooltipLength * .7 );
						$l_str_TooltipStyle .= 'em;"';
					}
				}

				// fill in 'templates/public/footnote.html':
				$l_obj_Template->replace(
					array(
						"link-span"      => self::$a_str_LinkSpan,
						"post_id"        => self::$a_int_PostId,
						"container_id"   => self::$a_int_ReferenceContainerId,
						"note_id"        => $l_int_Index,
						"hard-link"      => $l_str_FootnoteLinkArgument,
						"sup-span"       => $l_str_SupSpan,
						"before"         => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE),
						"index"          => $l_int_Index,
						"after"          => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER),
						"anchor-element" => $l_str_ReferrerAnchorElement,
						"style"          => $l_str_TooltipStyle,
						"text"           => $l_str_TooltipContent,
					)
				);
				$l_str_FootnoteReplaceText = $l_obj_Template->getContent();

				// reset the template
				$l_obj_Template->reload();

				// if standard tooltips are enabled but alternative are not:
				if (self::$a_bool_TooltipsEnabled && ! self::$a_bool_AlternativeTooltipsEnabled) {

					$l_int_OffsetY         = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y));
					$l_int_OffsetX         = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X));
					$l_int_FadeInDelay     = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY    ));
					$l_int_FadeInDuration  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ));
					$l_int_FadeOutDelay    = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY   ));
					$l_int_FadeOutDuration = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION));

					// fill in 'templates/public/tooltip.html':
					$l_obj_TemplateTooltip->replace(
						array(
							"post_id"           => self::$a_int_PostId,
							"container_id"      => self::$a_int_ReferenceContainerId,
							"note_id"           => $l_int_Index,
							"position"          => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION),
							"offset-y"          => !empty($l_int_OffsetY) ? $l_int_OffsetY : 0,
							"offset-x"          => !empty($l_int_OffsetX) ? $l_int_OffsetX : 0,
							"fade-in-delay"     => !empty($l_int_FadeInDelay    ) ? $l_int_FadeInDelay     : 0,
							"fade-in-duration"  => !empty($l_int_FadeInDuration ) ? $l_int_FadeInDuration  : 0,
							"fade-out-delay"    => !empty($l_int_FadeOutDelay   ) ? $l_int_FadeOutDelay    : 0,
							"fade-out-duration" => !empty($l_int_FadeOutDuration) ? $l_int_FadeOutDuration : 0,
						)
					);
					$l_str_FootnoteReplaceText .= $l_obj_TemplateTooltip->getContent();
					$l_obj_TemplateTooltip->reload();
				}
			}
			// replace the footnote with the template
			$p_str_Content = substr_replace($p_str_Content, $l_str_FootnoteReplaceText, $l_int_PosStart, $l_int_Length + strlen($l_str_EndingTag));

			// add footnote only if not empty
			if (!empty($l_str_FootnoteText)) {
				// set footnote to the output box at the end
				self::$a_arr_Footnotes[] = $l_str_FootnoteText;
				// increase footnote index
				$l_int_FootnoteIndex++;
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
			// add offset to the new starting position
			$l_int_PosStart += $l_int_Length + strlen($l_str_EndingTag);

		} while (true);

		// return content
		return $p_str_Content;
	}

	/**
	 * Generates the reference container.
	 *
	 * @author Stefan Herndler
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
	public function ReferenceContainer() {

		// no footnotes have been replaced on this page:
		if (empty(self::$a_arr_Footnotes)) {
			return "";
		}


		/**
		 * Footnote index backlink symbol
		 *
		 * - Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
		 *
		 * @since 2.1.1
		 *
		 * @reporter @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13671138
		 *
		 * If the backlink symbol is enabled:
		 */
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE))) {

			// get html arrow
			$l_str_Arrow = MCI_Footnotes_Convert::getArrow(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW));
			// set html arrow to the first one if invalid index defined
			if (is_array($l_str_Arrow)) {
				$l_str_Arrow = MCI_Footnotes_Convert::getArrow(0);
			}
			// get user defined arrow
			$l_str_ArrowUserDefined = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED);
			if (!empty($l_str_ArrowUserDefined)) {
				$l_str_Arrow = $l_str_ArrowUserDefined;
			}

			// wrap the arrow in a @media print { display:hidden } span:
			$l_str_FootnoteArrow  = '<span class="footnote_index_arrow">';
			$l_str_FootnoteArrow .= $l_str_Arrow . '</span>';

		} else {

			// If the backlink symbol isn’t enabled, set it to empty:
			$l_str_Arrow = '';
			$l_str_FootnoteArrow = '';

		}


		/**
		 * Backlink separator
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
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_SEPARATOR_ENABLED))) {

			// check if it is input-configured:
			$l_str_Separator = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM);

			if (empty($l_str_Separator)) {

				// if it is not, check which option is on:
				$l_str_SeparatorOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION);
				switch ($l_str_SeparatorOption) {
					case 'comma'    : $l_str_Separator = ',';              break;
					case 'semicolon': $l_str_Separator = ';';              break;
					case 'en_dash'  : $l_str_Separator = '&nbsp;&#x2013;'; break;
				}
			}

		} else {

			$l_str_Separator = '';
		}

		/**
		 * Backlink terminator
		 *
		 * Initially a dot was appended in the table row template.
		 * @since 2.0.6 a dot after footnote numbers is discarded as not localizable;
		 * making it optional was envisaged.
		 * @since 2.1.4 the terminator is optional, has options, and is configurable:
		 */
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_TERMINATOR_ENABLED))) {

			// check if it is input-configured:
			$l_str_Terminator = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM);

			if (empty($l_str_Terminator)) {

				// if it is not, check which option is on:
				$l_str_TerminatorOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION);
				switch ($l_str_TerminatorOption) {
					case 'period'     : $l_str_Terminator = '.'; break;
					case 'parenthesis': $l_str_Terminator = ')'; break;
					case 'colon'      : $l_str_Terminator = ':'; break;
				}
			}

		} else {

			$l_str_Terminator = '';
		}


		/**
		 * Line breaks
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
		$l_str_LineBreak = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED)) ? '<br />' : ' ';

		/**
		 * For maintenance and support, table rows in the reference container should be
		 * separated by an empty line. So we add these line breaks for source readability.
		 * Before the first table row (breaks between rows are ~200 lines below):
		 */
		$l_str_Body = "\r\n\r\n";


		/**
		 * Reference container table row template load
		 *
		 * - Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
		 *
		 * @since 2.1.1
		 * @date 2020-11-16T2024+0100
		 */

		// when combining identical footnotes is turned on, another template is needed:
		if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES))) {
			// the combining template allows for backlink clusters and supports cell clicking for single notes:
			$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body-combi");

		} else {

			// when 3-column layout is turned on (only available if combining is turned off):
			if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE))) {
				$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body-3column");

			} else {

				// when switch symbol and index is turned on, and combining and 3-columns are off:
				if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH))) {
					$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body-switch");

				} else {

					// default is the standard template:
					$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body");

				}
			}
		}

		/**
		 * Switch backlink symbol and footnote number
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
		$l_bool_SymbolSwitch = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH));

		// loop through all footnotes found in the page
		for ($l_int_Index = 0; $l_int_Index < count(self::$a_arr_Footnotes); $l_int_Index++) {

			// get footnote text
			$l_str_FootnoteText = self::$a_arr_Footnotes[$l_int_Index];

			// if footnote is empty, go to the next one;
			// With combine identicals turned on, identicals will be deleted and are skipped:
			if (empty($l_str_FootnoteText)) {
				continue;
			}

			// generate content of footnote index cell
			$l_int_FirstFootnoteIndex = ($l_int_Index + 1);

			// get the footnote index string and
			// keep supporting legacy index placeholder:
			$l_str_FootnoteId  = MCI_Footnotes_Convert::Index(($l_int_Index + 1),  MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));

			/**
			 * Case of only one backlink per table row
			 *
			 * If enabled, and for the case the footnote is single, compose hard link:
			 */
			// define anyway:
			$l_str_HardLinkAddress = '';

			if (self::$a_bool_HardLinksEnable) {

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
				if ( MCI_Footnotes_Convert::toBool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE ) ) ) {
					$l_str_UseBackbuttonHint  = ' title="';
					$l_str_UseBackbuttonHint .= MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT);
					$l_str_UseBackbuttonHint .= '"';
				} else {
					$l_str_UseBackbuttonHint = '';
				}

				/**
				 * Compose fragment ID anchor with offset, for use in reference container.
				 * Empty span, child of empty span, to avoid tall dotted rectangles in browser.
				 */
				$l_str_FootnoteAnchorElement  = '<span class="footnote_item_base"><span id="';
				$l_str_FootnoteAnchorElement .= self::$a_str_FootnoteLinkSlug;
				$l_str_FootnoteAnchorElement .= self::$a_str_PostContainerIdCompound;
				$l_str_FootnoteAnchorElement .= $l_str_FootnoteId;
				$l_str_FootnoteAnchorElement .= '" class="footnote_item_anchor"></span></span>';

				// compose optional hard link address:
				$l_str_HardLinkAddress  = ' href="#';
				$l_str_HardLinkAddress .= self::$a_str_ReferrerLinkSlug;
				$l_str_HardLinkAddress .= self::$a_str_PostContainerIdCompound;
				$l_str_HardLinkAddress .= $l_str_FootnoteId . '"';
				$l_str_HardLinkAddress .= $l_str_UseBackbuttonHint;

				// compose optional opening link tag with optional hard link, mandatory for instance:
				self::$a_str_LinkOpenTag  = '<a' . $l_str_HardLinkAddress;
				self::$a_str_LinkOpenTag  = ' class="footnote_hard_back_link">';

			} else {
				// define as empty, too:
				$l_str_FootnoteAnchorElement = '';
			}


			/**
			 * Support for combining identicals: compose enumerated backlinks
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
			// set a flag to check for the combined status of a footnote item:
			$l_bool_FlagCombined = false;

			// set otherwise unused variables as empty to avoid screwing up the placeholder array:
			$l_str_BacklinkEvent     = '';
			$l_str_FootnoteBacklinks = '';
			$l_str_FootnoteReference = '';

			if ( MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES))) {

				// ID, optional hard link address, and class:
				$l_str_FootnoteReference  = '<' . self::$a_str_LinkSpan;
				$l_str_FootnoteReference .= ' id="footnote_plugin_reference_';
				$l_str_FootnoteReference .= self::$a_int_PostId;
				$l_str_FootnoteReference .= '_' . self::$a_int_ReferenceContainerId;
				$l_str_FootnoteReference .= "_$l_str_FootnoteId\"";
				if (self::$a_bool_HardLinksEnable) {
					$l_str_FootnoteReference .= ' href="#';
					$l_str_FootnoteReference .= self::$a_str_ReferrerLinkSlug;
					$l_str_FootnoteReference .= self::$a_str_PostContainerIdCompound;
					$l_str_FootnoteReference .= $l_str_FootnoteId . '"';
					$l_str_FootnoteReference .= $l_str_UseBackbuttonHint;
				}
				$l_str_FootnoteReference .= ' class="footnote_backlink"';

				// the click event goes in the table cell if footnote remains single:
				$l_str_BacklinkEvent  = ' onclick="footnote_moveToAnchor_';
				$l_str_BacklinkEvent .= self::$a_int_PostId;
				$l_str_BacklinkEvent .= '_' . self::$a_int_ReferenceContainerId;
				$l_str_BacklinkEvent .= "('footnote_plugin_tooltip_";
				$l_str_BacklinkEvent .= self::$a_int_PostId;
				$l_str_BacklinkEvent .= '_' . self::$a_int_ReferenceContainerId;
				$l_str_BacklinkEvent .= "_$l_str_FootnoteId');\"";


				// the dedicated template enumerating backlinks uses another variable:
				$l_str_FootnoteBacklinks  = $l_str_FootnoteReference;

				// append the click event right to the backlink item for enumerations;
				// else it goes in the table cell:
				$l_str_FootnoteBacklinks .= $l_str_BacklinkEvent . '>';
				$l_str_FootnoteReference .= '>';

				// append the optional offset anchor for hard links:
				if (self::$a_bool_HardLinksEnable) {
					$l_str_FootnoteReference .= $l_str_FootnoteAnchorElement;
					$l_str_FootnoteBacklinks .= $l_str_FootnoteAnchorElement;
				}

				// continue both single note and notes cluster, depending on switch option status:
				if ($l_bool_SymbolSwitch) {

					$l_str_FootnoteReference .= "$l_str_FootnoteId$l_str_FootnoteArrow";
					$l_str_FootnoteBacklinks .= "$l_str_FootnoteId$l_str_FootnoteArrow";

				} else {

					$l_str_FootnoteReference .= "$l_str_FootnoteArrow$l_str_FootnoteId";
					$l_str_FootnoteBacklinks .= "$l_str_FootnoteArrow$l_str_FootnoteId";

				}

				// If that is the only footnote with this text, we’re almost done.

				// check if it isn't the last footnote in the array:
				if ($l_int_FirstFootnoteIndex < count(self::$a_arr_Footnotes)) {

					// get all footnotes that haven't passed yet:
					for ($l_int_CheckIndex = $l_int_FirstFootnoteIndex; $l_int_CheckIndex < count(self::$a_arr_Footnotes); $l_int_CheckIndex++) {

						// check if a further footnote is the same as the actual one:
						if ($l_str_FootnoteText == self::$a_arr_Footnotes[$l_int_CheckIndex]) {

							// if so, set the further footnote as empty so it won't be displayed later:
							self::$a_arr_Footnotes[$l_int_CheckIndex] = "";

							// set the flag to true for the combined status:
							$l_bool_FlagCombined = true;

							// update the footnote ID:
							$l_str_FootnoteId = MCI_Footnotes_Convert::Index(($l_int_CheckIndex + 1), MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));

							// resume composing the backlinks enumeration:
							$l_str_FootnoteBacklinks .= "$l_str_Separator</";
							$l_str_FootnoteBacklinks .= self::$a_str_LinkSpan . '>';
							$l_str_FootnoteBacklinks .= $l_str_LineBreak;
							$l_str_FootnoteBacklinks .= '<' . self::$a_str_LinkSpan;
							$l_str_FootnoteBacklinks .= ' id="footnote_plugin_reference_';
							$l_str_FootnoteBacklinks .= self::$a_int_PostId;
							$l_str_FootnoteBacklinks .= '_' . self::$a_int_ReferenceContainerId;
							$l_str_FootnoteBacklinks .= "_$l_str_FootnoteId\"";

							// insert the optional hard link address:
							if (self::$a_bool_HardLinksEnable) {
								$l_str_FootnoteBacklinks .= ' href="#';
								$l_str_FootnoteBacklinks .= self::$a_str_ReferrerLinkSlug;
								$l_str_FootnoteBacklinks .= self::$a_str_PostContainerIdCompound;
								$l_str_FootnoteBacklinks .= $l_str_FootnoteId . '"';
								$l_str_FootnoteBacklinks .= $l_str_UseBackbuttonHint;
							}

							$l_str_FootnoteBacklinks .= ' class="footnote_backlink"';
							$l_str_FootnoteBacklinks .= ' onclick="footnote_moveToAnchor_';
							$l_str_FootnoteBacklinks .= self::$a_int_PostId;
							$l_str_FootnoteBacklinks .= '_' . self::$a_int_ReferenceContainerId;
							$l_str_FootnoteBacklinks .= "('footnote_plugin_tooltip_";
							$l_str_FootnoteBacklinks .= self::$a_int_PostId;
							$l_str_FootnoteBacklinks .= '_' . self::$a_int_ReferenceContainerId;
							$l_str_FootnoteBacklinks .= "_$l_str_FootnoteId');\">";

							// append the offset anchor for optional hard links:
							if (self::$a_bool_HardLinksEnable) {
								$l_str_FootnoteBacklinks .= '<span class="footnote_item_base"><span id="';
								$l_str_FootnoteBacklinks .= self::$a_str_FootnoteLinkSlug;
								$l_str_FootnoteBacklinks .= self::$a_str_PostContainerIdCompound;
								$l_str_FootnoteBacklinks .= $l_str_FootnoteId;
								$l_str_FootnoteBacklinks .= '" class="footnote_item_anchor"></span></span>';
							}

							$l_str_FootnoteBacklinks .= $l_bool_SymbolSwitch ? '' : $l_str_FootnoteArrow;
							$l_str_FootnoteBacklinks .= $l_str_FootnoteId;
							$l_str_FootnoteBacklinks .= $l_bool_SymbolSwitch ? $l_str_FootnoteArrow : '';

						}
					}
				}

				// append terminator and end tag:
				$l_str_FootnoteReference .= $l_str_Terminator . '</' . self::$a_str_LinkSpan . '>';
				$l_str_FootnoteBacklinks .= $l_str_Terminator . '</' . self::$a_str_LinkSpan . '>';

			}

			// line wrapping of URLs already fixed, see above

			// get reference container item text if tooltip text goes separate:
			$l_int_TooltipTextLength = strpos( $l_str_FootnoteText, self::$a_str_TooltipShortcode );
			$l_bool_HasTooltipText = $l_int_TooltipTextLength === false ? false : true;
			if ( $l_bool_HasTooltipText ) {
				$l_str_NotTooltipText = substr( $l_str_FootnoteText, ( $l_int_TooltipTextLength + self::$a_int_TooltipShortcodeLength ) );
				self::$a_bool_MirrorTooltipText = MCI_Footnotes_Convert::toBool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE ) );
				if ( self::$a_bool_MirrorTooltipText ) {
					$l_str_TooltipText = substr( $l_str_FootnoteText, 0, $l_int_TooltipTextLength );
					$l_str_ReferenceTextIntroducer = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR);
					$l_str_ReferenceText = $l_str_TooltipText . $l_str_ReferenceTextIntroducer . $l_str_NotTooltipText;
				} else {
					$l_str_ReferenceText = $l_str_NotTooltipText;
				}
			} else {
				$l_str_ReferenceText = $l_str_FootnoteText;
			}

			// replace all placeholders in table row template:
			$l_obj_Template->replace(
				array(

					// placeholder used in all templates:
					"text"            => $l_str_ReferenceText,

					// used in standard layout W/O COMBINED FOOTNOTES:
					"post_id"         => self::$a_int_PostId,
					"container_id"    => self::$a_int_ReferenceContainerId,
					"note_id"         => MCI_Footnotes_Convert::Index($l_int_FirstFootnoteIndex, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE)),
					"link-start"      => self::$a_str_LinkOpenTag,
					"link-end"        => self::$a_str_LinkCloseTag,
					"link-span"       => self::$a_str_LinkSpan,
					"terminator"      => $l_str_Terminator,
					"anchor-element"  => $l_str_FootnoteAnchorElement,
					"hard-link"       => $l_str_HardLinkAddress,

					// used in standard layout WITH COMBINED IDENTICALS TURNED ON:
					"pointer"         => $l_bool_FlagCombined ? '' : ' pointer',
					"event"           => $l_bool_FlagCombined ? '' : $l_str_BacklinkEvent,
					"backlinks"       => $l_bool_FlagCombined ? $l_str_FootnoteBacklinks : $l_str_FootnoteReference,

					// Legacy placeholders for use in legacy layout templates:
					"arrow"           => $l_str_FootnoteArrow,
					"index"           => $l_str_FootnoteId,
				)
			);

			$l_str_Body .= $l_obj_Template->getContent();

			// extra line breaks for page source readability:
			$l_str_Body .= "\r\n\r\n";

			$l_obj_Template->reload();

		}

		// call again for robustness when priority levels don’t match any longer:
		self::$a_int_ScrollOffset = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET));

		// streamline:
		$l_bool_CollapseDefault = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE));

		/**
		 * Reference container label
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
		$l_str_ReferenceContainerLabel = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME);

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
				"post_id"         =>  self::$a_int_PostId,
				"container_id"    =>  self::$a_int_ReferenceContainerId,
				"element"         =>  MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT),
				"name"            =>  empty($l_str_ReferenceContainerLabel) ? '&#x202F;' : $l_str_ReferenceContainerLabel,
				"button-style"    => !$l_bool_CollapseDefault ? 'display: none;' : '',
				"style"           =>  $l_bool_CollapseDefault ? 'display: none;' : '',
				"content"         =>  $l_str_Body,
				"scroll-offset"   =>  (self::$a_int_ScrollOffset / 100),
				"scroll-duration" =>  intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION)),
			)
		);

		// free all found footnotes if reference container will be displayed
		self::$a_arr_Footnotes = array();

		return $l_obj_TemplateContainer->getContent();
	}
}
