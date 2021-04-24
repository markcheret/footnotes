<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName, WordPress.Security.EscapeOutput.OutputNotEscaped
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
 * @since 2.0.6  Bugfix: Infinite scroll: debug autoload by adding post ID, thanks to @docteurfitness issue report and code contribution.
 * @since 2.0.6  Bugfix: Priority level back to PHP_INT_MAX (ref container positioning not this plugin’s responsibility).
 * @since 2.0.6  Bugfix: Reference container: fix line breaking behavior in footnote number clusters.
 * @since 2.0.7  BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
 * @since 2.0.9  Bugfix: Remove the_post hook.
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
 * @since 2.3.0  Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro issue report, thanks to @martinneumannat issue report and code contribution.
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
 * @since 2.5.11 Bugfix: Forms: remove footnotes from input field values, thanks to @bogosavljev bug report.
 * @since 2.5.14 Bugfix: Footnote delimiter short codes: fix numbering bug by cross-editor HTML escapement schema harmonization, thanks to @patrick_here @alifarahani8000 @gova bug reports.
 */

// If called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Searches and replaces the footnotes and generates the reference container.
 *
 * @since 1.5.0
 */
class Footnotes_Task {

	/**
	 * Contains all footnotes found in the searched content.
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
	 * - Bugfix: Infinite scroll: debug autoload by adding post ID, thanks to @docteurfitness issue report and code contribution
	 *
	 * @reporter @docteurfitness
	 * @link https://wordpress.org/support/topic/auto-load-post-compatibility-update/
	 *
	 * @contributor @docteurfitness
	 * @link https://wordpress.org/support/topic/auto-load-post-compatibility-update/#post-13618833
	 *
	 * @since 2.0.6
	 * @var int
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
	 * @reporter @justbecuz
	 * @link https://wordpress.org/support/topic/reset-footnotes-to-1/
	 * @link https://wordpress.org/support/topic/reset-footnotes-to-1/#post-13662830
	 *
	 * @since 2.2.9
	 * @var int   Incremented every time after a reference container is inserted.
	 *
	 * This ID disambiguates multiple reference containers in a page
	 * as they may occur when the widget_text hook is active and the page
	 * is built with Elementor and has an accordion or similar toggle sections.
	 */
	public static $a_int_reference_container_id = 1;

	/**
	 * Hard links for AMP compatibility.
	 *
	 * @since 2.0.0  Bugfix: footnote links script independent.
	 *
	 * - Bugfix: Referrers and backlinks: remove hard links to streamline browsing history, thanks to @theroninjedi47 bug report.
	 *
	 * @reporter @theroninjedi47
	 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
	 *
	 * @since 2.0.4
	 *
	 * - Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro issue report, thanks to @martinneumannat issue report and code contribution.
	 *
	 * @contributor @martinneumannat
	 * @link https://wordpress.org/support/topic/making-it-amp-compatible/
	 *
	 * @reporter @psykonevro
	 * @link https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/
	 *
	 * @since 2.3.0
	 * @var bool
	 * A property because used both in search() and reference_container().
	 */
	public static $a_bool_hard_links_enabled = false;

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
	 * Contains the concatenated fragment ID base.
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
	 *
	 * - Bugfix: Scroll offset: initialize to safer one third window height for more robustness, thanks to @lukashuggenberg bug report.
	 *
	 * @reporter @lukashuggenberg
	 * @link https://wordpress.org/support/topic/2-2-6-breaks-all-footnotes/#post-13857922
	 *
	 * @since 2.4.0
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
	 * @reporter @docteurfitness
	 * @link https://wordpress.org/support/topic/update-2-1-3/
	 *
	 * @contributor @docteurfitness
	 * @link https://wordpress.org/support/topic/update-2-1-3/#post-13704194
	 *
	 * @since 2.1.4
	 *
	 * - Adding: Referrers and backlinks: optional hard links for AMP compatibility, thanks to @psykonevro issue report, thanks to @martinneumannat issue report and code contribution.
	 *
	 * @contributor @martinneumannat
	 * @link https://wordpress.org/support/topic/making-it-amp-compatible/
	 *
	 * @reporter @psykonevro
	 * @link https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/
	 *
	 * @since 2.3.0
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
	 * @see self::$a_bool_hard_links_enabled
	 * A property because used both in search() and reference_container().
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
	 * @reporter @jbj2199
	 * @link https://wordpress.org/support/topic/change-tooltip-text/
	 *
	 * @since 2.5.2
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
	 * Footnote delimiter start short code.
	 *
	 * @since 1.5.0 (constant, variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $a_str_start_tag = '';

	/**
	 * Footnote delimiter end short code.
	 *
	 * @since 1.5.0 (constant, variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $a_str_end_tag = '';

	/**
	 * Footnote delimiter start short code in regex format.
	 *
	 * @since 2.4.0 (variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $a_str_start_tag_regex = '';

	/**
	 * Footnote delimiter end short code in regex format.
	 *
	 * @since 2.4.0 (variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $a_str_end_tag_regex = '';

	/**
	 * Footnote delimiter syntax validation enabled.
	 *
	 * - Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
	 *
	 * @since 2.4.0
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
	 * Register WordPress hooks to replace Footnotes in the content of a public page.
	 *
	 * @since 1.5.0
	 *
	 * @since 1.5.4  Adding: Hooks: support 'the_post' in response to user request for custom post types.
	 * @since 2.0.5  Bugfix: Reference container: fix relative position through priority level, thanks to @june01 @imeson @spaceling bug reports, thanks to @spaceling code contribution.
	 * @since 2.0.5  Update: Hooks: Default-enable all hooks to prevent footnotes from seeming broken in some parts.
	 * @since 2.0.6  Bugfix: Priority level back to PHP_INT_MAX (ref container positioning not this plugin’s responsibility).
	 * @since 2.0.7  BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
	 * @since 2.0.7  Bugfix: Set priority level back to 10 assuming it is unproblematic.
	 * @since 2.0.8  Bugfix: Priority level back to PHP_INT_MAX (need to get in touch with other plugins).
	 * @since 2.1.0  UPDATE: Hooks: remove 'the_post', the plugin stops supporting this hook.
	 * @since 2.1.1  Bugfix: Dashboard: priority level setting for the_content hook, thanks to @imeson bug report.
	 * @since 2.1.2  Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos bug report.
	 * @since 2.5.0  Bugfix: Hooks: support footnotes on category pages, thanks to @vitaefit bug report, thanks to @misfist code contribution.
	 * @since 2.5.1  Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
	 */
	public function register_hooks() {

		// Get values from settings.
		$l_int_the_title_priority    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL ) );
		$l_int_the_content_priority  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL ) );
		$l_int_the_excerpt_priority  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL ) );
		$l_int_widget_title_priority = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL ) );
		$l_int_widget_text_priority  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL ) );

		// PHP_INT_MAX can be set by -1.
		$l_int_the_title_priority    = ( -1 === $l_int_the_title_priority ) ? PHP_INT_MAX : $l_int_the_title_priority;
		$l_int_the_content_priority  = ( -1 === $l_int_the_content_priority ) ? PHP_INT_MAX : $l_int_the_content_priority;
		$l_int_the_excerpt_priority  = ( -1 === $l_int_the_excerpt_priority ) ? PHP_INT_MAX : $l_int_the_excerpt_priority;
		$l_int_widget_title_priority = ( -1 === $l_int_widget_title_priority ) ? PHP_INT_MAX : $l_int_widget_title_priority;
		$l_int_widget_text_priority  = ( -1 === $l_int_widget_text_priority ) ? PHP_INT_MAX : $l_int_widget_text_priority;

		// Append custom css to the header.
		add_filter( 'wp_head', array( $this, 'footnotes_output_head' ), PHP_INT_MAX );

		// Append the love and share me slug to the footer.
		add_filter( 'wp_footer', array( $this, 'footnotes_output_footer' ), PHP_INT_MAX );

		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_TITLE ) ) ) {
			add_filter( 'the_title', array( $this, 'footnotes_in_title' ), $l_int_the_title_priority );
		}

		// Configurable priority level for reference container relative positioning; default 98.
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_CONTENT ) ) ) {
			add_filter( 'the_content', array( $this, 'footnotes_in_content' ), $l_int_the_content_priority );

			/**
			 * Hook for category pages.
			 *
			 * - Bugfix: Hooks: support footnotes on category pages, thanks to @vitaefit bug report, thanks to @misfist code contribution.
			 *
			 * @reporter @vitaefit
			 * @link https://wordpress.org/support/topic/footnote-doesntwork-on-category-page/
			 *
			 * @contributor @misfist
			 * @link https://wordpress.org/support/topic/footnote-doesntwork-on-category-page/#post-13864859
			 *
			 * @since 2.5.0
			 *
			 * Category pages can have rich HTML content in a term description with article status.
			 * For this to happen, WordPress’ built-in partial HTML blocker needs to be disabled.
			 * @link https://docs.woocommerce.com/document/allow-html-in-term-category-tag-descriptions/
			 */
			add_filter( 'term_description', array( $this, 'footnotes_in_content' ), $l_int_the_content_priority );

			/**
			 * Hook for popup maker popups.
			 *
			 * - Bugfix: Hooks: support footnotes in Popup Maker popups, thanks to @squatcher bug report.
			 *
			 * @reporter @squatcher
			 * @link https://wordpress.org/support/topic/footnotes-use-in-popup-maker/
			 *
			 * @since 2.5.1
			 */
			add_filter( 'pum_popup_content', array( $this, 'footnotes_in_content' ), $l_int_the_content_priority );
		}

		/**
		 * Adds a filter to the excerpt hook.
		 *
		 * @since 1.5.0  The hook 'get_the_excerpt' is filtered too.
		 * @since 1.5.5  The hook 'get_the_excerpt' is removed but not documented in changelog or docblock.
		 * @since 2.6.2  The hook 'get_the_excerpt' is readded when attempting to debug excerpt handling.
		 * @since 2.6.6  The hook 'get_the_excerpt' is removed again because it seems to cause issues in some themes.
		 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_EXCERPT ) ) ) {
			add_filter( 'the_excerpt', array( $this, 'footnotes_in_excerpt' ), $l_int_the_excerpt_priority );
		}

		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TITLE ) ) ) {
			add_filter( 'widget_title', array( $this, 'footnotes_in_widget_title' ), $l_int_widget_title_priority );
		}

		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TEXT ) ) ) {
			add_filter( 'widget_text', array( $this, 'footnotes_in_widget_text' ), $l_int_widget_text_priority );
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
		 * @since 2.0.7
		 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13630114
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/#post-13630303
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/2/#post-13630799
		 * @link https://wordpress.org/support/topic/no-footnotes-anymore/#post-13813233
		 *
		 * - UPDATE: Hooks: remove 'the_post', the plugin stops supporting this hook.
		 *
		 * @since 2.1.0
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
	public function footnotes_output_head() {

		// Insert start tag without switching out of PHP.
		echo "\r\n<style type=\"text/css\" media=\"all\">\r\n";

		/**
		 * Enables CSS smooth scrolling.
		 *
		 * - Update: Scrolling: CSS-based smooth scroll behavior (optional), thanks to @paulgpetty and @bogosavljev issue reports.
		 *
		 * @reporter @paulgpetty
		 * @link https://wordpress.org/support/topic/functionally-great/#post-13607795
		 *
		 * @reporter @bogosavljev
		 * @link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14214720
		 *
		 * @since 2.5.12
		 * Native smooth scrolling only works in recent browsers.
		 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_CSS_SMOOTH_SCROLLING ) ) ) {
			echo "html {scroll-behavior: smooth;}\r\n";
		}

		/**
		 * Normalizes the referrers’ vertical alignment and font size.
		 *
		 * - Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
		 *
		 * @reporter @tomturowski
		 * @link https://wordpress.org/support/topic/in-line-superscript-ref-rides-to-high/
		 *
		 * @since 2.5.4
		 *
		 * Cannot be included in external stylesheet, as it is only optional.
		 * The scope is variable too: referrers only, or all superscript elements.
		 */
		$l_str_normalize_superscript = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT );
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
		 * @reporter @dragon013
		 * @link https://wordpress.org/support/topic/possible-to-hide-it-from-start-page/
		 *
		 * @since 2.1.1
		 */
		if ( ! Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_START_PAGE_ENABLE ) ) ) {

			echo ".home .footnotes_reference_container { display: none; }\r\n";
		}

		/**
		 * Reference container top and bottom margins.
		 *
		 * - Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
		 *
		 * @since 2.3.0
		 */
		$l_int_reference_container_top_margin    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN ) );
		$l_int_reference_container_bottom_margin = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN ) );
		echo '.footnotes_reference_container {margin-top: ';
		echo empty( $l_int_reference_container_top_margin ) ? '0' : $l_int_reference_container_top_margin;
		echo 'px !important; margin-bottom: ';
		echo empty( $l_int_reference_container_bottom_margin ) ? '0' : $l_int_reference_container_bottom_margin;
		echo "px !important;}\r\n";

		/**
		 * Reference container label bottom border.
		 *
		 * - Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
		 * - Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
		 *
		 * @reporter @markhillyer
		 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
		 *
		 * @since 2.2.5
			 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER ) ) ) {
			echo '.footnote_container_prepare > ';
			echo Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT );
			echo " {border-bottom: 1px solid #aaaaaa !important;}\r\n";
		}

		/**
		 * Reference container table row borders.
		 *
		 * - Bugfix: Reference container: add option for table borders to restore pre-2.0.0 design, thanks to @noobishh issue report.
		 *
		 * @reporter @noobishh
		 * @link https://wordpress.org/support/topic/borders-25/
		 *
		 * @since 2.2.10
		 * Moving this internal CSS to external using `wp_add_inline_style()` is
		 * discouraged, because that screws up support, and it is pointless from
		 * a performance point of view. Moreover, that would cause cache busting
		 * issues as browsers won’t reload these style sheets after settings are
		 * changed while the version string is not.
		 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE ) ) ) {
			echo '.footnotes_table, .footnotes_plugin_reference_row {';
			echo 'border: 1px solid #060606;';
			echo " !important;}\r\n";
			// Adapt left padding to the presence of a border.
			echo '.footnote_plugin_index, .footnote_plugin_index_combi {';
			echo "padding-left: 6px !important}\r\n";
		}

		// Ref container first column width and max-width.
		$l_bool_column_width_enabled     = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_ENABLED ) );
		$l_bool_column_max_width_enabled = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED ) );

		if ( $l_bool_column_width_enabled || $l_bool_column_max_width_enabled ) {
			echo '.footnote-reference-container { table-layout: fixed; }';
			echo '.footnote_plugin_index, .footnote_plugin_index_combi {';

			if ( $l_bool_column_width_enabled ) {
				$l_int_column_width_scalar = Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR );
				$l_str_column_width_unit   = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT );

				if ( ! empty( $l_int_column_width_scalar ) ) {
					if ( '%' === $l_str_column_width_unit ) {
						if ( $l_int_column_width_scalar > 100 ) {
							$l_int_column_width_scalar = 100;
						}
					}
				} else {
					$l_int_column_width_scalar = 0;
				}

				echo ' width: ' . $l_int_column_width_scalar . $l_str_column_width_unit . ' !important;';
			}

			if ( $l_bool_column_max_width_enabled ) {
				$l_int_column_max_width_scalar = Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR );
				$l_str_column_max_width_unit   = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT );

				if ( ! empty( $l_int_column_max_width_scalar ) ) {
					if ( '%' === $l_str_column_max_width_unit ) {
						if ( $l_int_column_max_width_scalar > 100 ) {
							$l_int_column_max_width_scalar = 100;
						}
					}
				} else {
					$l_int_column_max_width_scalar = 0;
				}

				echo ' max-width: ' . $l_int_column_max_width_scalar . $l_str_column_max_width_unit . ' !important;';

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
		self::$a_bool_hard_links_enabled = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_HARD_LINKS_ENABLE ) );

		// Correct hard links enabled status depending on AMP compatible or alternative reference container enabled status.
		if ( Footnotes::$a_bool_amp_enabled || 'jquery' !== Footnotes::$a_str_script_mode ) {
			self::$a_bool_hard_links_enabled = true;
		}

		self::$a_int_scroll_offset = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET ) );
		if ( self::$a_bool_hard_links_enabled ) {
			echo '.footnote_referrer_anchor, .footnote_item_anchor {bottom: ';
			echo self::$a_int_scroll_offset;
			echo "vh;}\r\n";
		}

		/*
		 * Tooltips.
		 */
		if ( Footnotes::$a_bool_tooltips_enabled ) {
			echo '.footnote_tooltip {';

			/**
			 * Tooltip appearance: Tooltip font size.
			 *
			 * - Bugfix: Styling: Tooltips: fix font size issue by adding font size to settings with legacy as default.
			 *
			 * @since 2.1.4
			 */
			echo ' font-size: ';
			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_ENABLED ) ) ) {
				echo Footnotes_Settings::instance()->get( Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR );
				echo Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT );
			} else {
				echo 'inherit';
			}
			echo ' !important;';

			/*
			 * Tooltip Text color.
			 */
			$l_str_color = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR );
			if ( ! empty( $l_str_color ) ) {
				printf( ' color: %s !important;', $l_str_color );
			}

			/*
			 * Tooltip Background color.
			 */
			$l_str_background = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND );
			if ( ! empty( $l_str_background ) ) {
				printf( ' background-color: %s !important;', $l_str_background );
			}

			/*
			 * Tooltip Border width.
			 */
			$l_int_border_width = Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH );
			if ( ! empty( $l_int_border_width ) && intval( $l_int_border_width ) > 0 ) {
				printf( ' border-width: %dpx !important; border-style: solid !important;', $l_int_border_width );
			}

			/*
			 * Tooltip Border color.
			 */
			$l_str_border_color = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR );
			if ( ! empty( $l_str_border_color ) ) {
				printf( ' border-color: %s !important;', $l_str_border_color );
			}

			/*
			 * Tooltip Corner radius.
			 */
			$l_int_border_radius = Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS );
			if ( ! empty( $l_int_border_radius ) && intval( $l_int_border_radius ) > 0 ) {
				printf( ' border-radius: %dpx !important;', $l_int_border_radius );
			}

			/*
			 * Tooltip Shadow color.
			 */
			$l_str_box_shadow_color = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR );
			if ( ! empty( $l_str_box_shadow_color ) ) {
				printf( ' -webkit-box-shadow: 2px 2px 11px %s;', $l_str_box_shadow_color );
				printf( ' -moz-box-shadow: 2px 2px 11px %s;', $l_str_box_shadow_color );
				printf( ' box-shadow: 2px 2px 11px %s;', $l_str_box_shadow_color );
			}

			/**
			 * Tooltip position, dimensions and timing.
			 *
			 * - Bugfix: Tooltips: make display delays and fade durations configurable to conform to website style.
			 *
			 * @since 2.1.4
			 *
			 * - Update: Tooltips: Alternative tooltips: connect to position/timing settings (for themes not supporting jQuery tooltips).
			 *
			 * @since 2.2.5
			 */
			if ( ! Footnotes::$a_bool_alternative_tooltips_enabled && ! Footnotes::$a_bool_amp_enabled ) {

				/**
				 * Dimensions of jQuery tooltips.
				 *
				 * Position and timing of jQuery tooltips are script defined.
				 *
				 * @see templates/public/tooltip.html.
				 */
				$l_int_max_width = Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH );
				if ( ! empty( $l_int_max_width ) && intval( $l_int_max_width ) > 0 ) {
					printf( ' max-width: %dpx !important;', $l_int_max_width );
				}
				echo "}\r\n";

			} else {
				/*
				 * AMP compatible and alternative tooltips.
				 */
				echo "}\r\n";

				/**
				 * Dimensions.
				 *
				 * @see 'Determine shrink width if alternative tooltips are enabled'.
				 */
				$l_int_alternative_tooltip_width = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH ) );
				echo '.footnote_tooltip.position {';
				echo ' width: max-content; ';

				// Set also as max-width wrt short tooltip shrinking.
				echo ' max-width: ' . $l_int_alternative_tooltip_width . 'px;';

				/**
				 * Position.
				 *
				 * @see dev-amp-tooltips.css.
				 * @see dev-tooltips-alternative.css.
				 */
				$l_str_alternative_position = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION );
				$l_int_offset_x             = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X ) );

				if ( 'top left' === $l_str_alternative_position || 'bottom left' === $l_str_alternative_position ) {
					echo ' right: ' . ( ! empty( $l_int_offset_x ) ? $l_int_offset_x : 0 ) . 'px;';
				} else {
					echo ' left: ' . ( ! empty( $l_int_offset_x ) ? $l_int_offset_x : 0 ) . 'px;';
				}

				$l_int_offset_y = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y ) );

				if ( 'top left' === $l_str_alternative_position || 'top right' === $l_str_alternative_position ) {
					echo ' bottom: ' . ( ! empty( $l_int_offset_y ) ? $l_int_offset_y : 0 ) . 'px;';
				} else {
					echo ' top: ' . ( ! empty( $l_int_offset_y ) ? $l_int_offset_y : 0 ) . 'px;';
				}
				echo "}\r\n";

				/*
				 * Timing.
				 */
				$l_int_fade_in_delay     = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY ) );
				$l_int_fade_in_delay     = ! empty( $l_int_fade_in_delay ) ? $l_int_fade_in_delay : '0';
				$l_int_fade_in_duration  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ) );
				$l_int_fade_in_duration  = ! empty( $l_int_fade_in_duration ) ? $l_int_fade_in_duration : '0';
				$l_int_fade_out_delay    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY ) );
				$l_int_fade_out_delay    = ! empty( $l_int_fade_out_delay ) ? $l_int_fade_out_delay : '0';
				$l_int_fade_out_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION ) );
				$l_int_fade_out_duration = ! empty( $l_int_fade_out_duration ) ? $l_int_fade_out_duration : '0';

				/**
				 * AMP compatible tooltips.
				 *
				 * To streamline internal CSS, immutable rules are in external stylesheet.
				 *
				 * @see dev-amp-tooltips.css.
				 */
				if ( Footnotes::$a_bool_amp_enabled ) {

					echo 'span.footnote_referrer > span.footnote_tooltip {';
					echo 'transition-delay: ' . $l_int_fade_out_delay . 'ms;';
					echo 'transition-duration: ' . $l_int_fade_out_duration . 'ms;';
					echo "}\r\n";

					echo 'span.footnote_referrer:focus-within > span.footnote_tooltip, span.footnote_referrer:hover > span.footnote_tooltip {';
					echo 'transition-delay: ' . $l_int_fade_in_delay . 'ms;';
					echo 'transition-duration: ' . $l_int_fade_in_duration . 'ms;';
					echo "}\r\n";

					/**
					 * Alternative tooltips.
					 *
					 * To streamline internal CSS, immutable rules are in external stylesheet.
				   *
					 * @see dev-tooltips-alternative.css.
					 */
				} else {

					echo '.footnote_tooltip.hidden {';
					echo 'transition-delay: ' . $l_int_fade_out_delay . 'ms;';
					echo 'transition-duration: ' . $l_int_fade_out_duration . 'ms;';
					echo "}\r\n";

					echo '.footnote_tooltip.shown {';
					echo 'transition-delay: ' . $l_int_fade_in_delay . 'ms;';
					echo 'transition-duration: ' . $l_int_fade_in_duration . 'ms;';
					echo "}\r\n";
				}
			}
		}

		/**
		 * Custom CSS.
		 *
		 * - Bugfix: Custom CSS: insert new CSS in the public page header element after existing CSS.
		 *
		 * @since 2.2.3
		 *
		 * Set custom CSS to override settings, not conversely.
		 * Legacy Custom CSS is used until it’s set to disappear after dashboard tab migration.
		 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			echo Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_CUSTOM_CSS );
			echo "\r\n";
		}
		echo Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_CUSTOM_CSS_NEW );

		// Insert end tag without switching out of PHP.
		echo "\r\n</style>\r\n";

		/**
		 * Alternative tooltip implementation relying on plain JS and CSS transitions.
		 *
		 * - Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
		 *
		 * @reporter @andreasra
		 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/2/#post-13632566
		 *
		 * @since 2.1.1
		 * The script for alternative tooltips is printed formatted, not minified,
		 * for transparency. It isn’t indented though (the PHP open tag neither).
		 */
		if ( Footnotes::$a_bool_alternative_tooltips_enabled ) {

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
			// Indenting this PHP open tag would mess up the page source.
			// End internal script.
		};
	}

	/**
	 * Displays the 'LOVE FOOTNOTES' slug if enabled.
	 *
	 * @since 1.5.0
	 * @since 2.2.0  More options.
	 */
	public function footnotes_output_footer() {
		if ( 'footer' === Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION ) ) {
			echo $this->reference_container();
		}
		// Get setting for love and share this plugin.
		$l_str_love_me_index = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_LOVE );
		// Check if the admin allows to add a link to the footer.
		if ( empty( $l_str_love_me_index ) || 'no' === strtolower( $l_str_love_me_index ) || ! self::$a_bool_allow_love_me ) {
			return;
		}
		// Set a hyperlink to the word "footnotes" in the Love slug.
		$l_str_linked_name = sprintf( '<a href="https://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">%s</a>', Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME );
		// Get random love me text.
		if ( 'random' === strtolower( $l_str_love_me_index ) ) {
			$l_str_love_me_index = 'text-' . wp_rand( 1, 7 );
		}
		switch ( $l_str_love_me_index ) {
			// Options named wrt backcompat, simplest is default.
			case 'text-1':
				/* Translators: 2: Link to plugin page 1: Love heart symbol */
				$l_str_love_me_text = sprintf( __( 'I %2$s %1$s', 'footnotes' ), $l_str_linked_name, Footnotes_Config::C_STR_LOVE_SYMBOL );
				break;
			case 'text-2':
				/* Translators: %s: Link to plugin page */
				$l_str_love_me_text = sprintf( __( 'This website uses the awesome %s plugin.', 'footnotes' ), $l_str_linked_name );
				break;
			case 'text-4':
				/* Translators: 1: Link to plugin page 2: Love heart symbol */
				$l_str_love_me_text = sprintf( '%1$s %2$s', $l_str_linked_name, Footnotes_Config::C_STR_LOVE_SYMBOL );
				break;
			case 'text-5':
				/* Translators: 1: Love heart symbol 2: Link to plugin page */
				$l_str_love_me_text = sprintf( '%1$s %2$s', Footnotes_Config::C_STR_LOVE_SYMBOL, $l_str_linked_name );
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
		echo sprintf( '<div style="text-align:center; color:#acacac;">%s</div>', $l_str_love_me_text );
	}

	/**
	 * Replaces footnotes in the post/page title.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content  Title.
	 * @return string $p_str_content  Title with replaced footnotes.
	 */
	public function footnotes_in_title( $p_str_content ) {
		// Appends the reference container if set to "post_end".
		return $this->exec( $p_str_content, false );
	}

	/**
	 * Replaces footnotes in the content of the current page/post.
	 *
	 * @since 1.5.0
	 *
	 * - Adding: Reference container: optionally per section by shortcode, thanks to @grflukas issue report.
	 *
	 * @reporter @grflukas
	 * @link https://wordpress.org/support/topic/multiple-reference-containers-in-single-post/
	 *
	 * @since 2.7.0
	 * @param string $p_str_content  Page/Post content.
	 * @return string $p_str_content  Content with replaced footnotes.
	 */
	public function footnotes_in_content( $p_str_content ) {

		$l_str_ref_container_position            = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION );
		$l_str_footnote_section_shortcode        = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTE_SECTION_SHORTCODE );
		$l_int_footnote_section_shortcode_length = strlen( $l_str_footnote_section_shortcode );

		if ( strpos( $p_str_content, $l_str_footnote_section_shortcode ) === false ) {

			// phpcs:disable WordPress.PHP.YodaConditions.NotYoda
			// Appends the reference container if set to "post_end".
			return $this->exec( $p_str_content, 'post_end' === $l_str_ref_container_position );
			// phpcs:enable WordPress.PHP.YodaConditions.NotYoda

		} else {

			$l_str_rest_content       = $p_str_content;
			$l_arr_sections_raw       = array();
			$l_arr_sections_processed = array();

			do {
				$l_int_section_end    = strpos( $l_str_rest_content, $l_str_footnote_section_shortcode );
				$l_arr_sections_raw[] = substr( $l_str_rest_content, 0, $l_int_section_end );
				$l_str_rest_content   = substr( $l_str_rest_content, $l_int_section_end + $l_int_footnote_section_shortcode_length );
			} while ( strpos( $l_str_rest_content, $l_str_footnote_section_shortcode ) !== false );
			$l_arr_sections_raw[] = $l_str_rest_content;

			foreach ( $l_arr_sections_raw as $l_str_section ) {
				$l_arr_sections_processed[] = self::exec( $l_str_section, true );
			}

			$p_str_content = implode( $l_arr_sections_processed );
			return $p_str_content;

		}
	}

	/**
	 * Processes existing excerpt or replaces it with a new one generated on the basis of the post.
	 *
	 * @since 1.5.0
	 * @param string $p_str_excerpt  Excerpt content.
	 * @return string $p_str_excerpt  Processed or new excerpt.
	 * @since 2.6.2  Debug No option.
	 * @since 2.6.3  Debug Yes option, the setting becomes fully effective.
	 *
	 * - Bugfix: Excerpts: make excerpt handling backward compatible, thanks to @mfessler bug report.
	 *
	 * @reporter @mfessler
	 * @link https://github.com/markcheret/footnotes/issues/65
	 *
	 * @since 2.7.0
	 * The input was already the processed excerpt, no more footnotes to search.
	 * But issue #65 brought up that manual excerpts can include processable footnotes.
	 * Default 'manual' is fallback and is backward compatible with the initial setup.
	 */
	public function footnotes_in_excerpt( $p_str_excerpt ) {
		$l_str_excerpt_mode = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_IN_EXCERPT );

		if ( 'yes' === $l_str_excerpt_mode ) {
			return $this->generate_excerpt_with_footnotes( $p_str_excerpt );

		} elseif ( 'no' === $l_str_excerpt_mode ) {
			return $this->generate_excerpt( $p_str_excerpt );

		} else {
			return $this->exec( $p_str_excerpt );
		}
	}

	/**
	 * Generates excerpt on the basis of the post.
	 *
	 * - Bugfix: Excerpts: debug the 'No' option by generating excerpts on the basis of the post without footnotes, thanks to @nikelaos @markcheret @martinneumannat bug reports.
	 *
	 * @reporter @nikelaos
	 * @link https://wordpress.org/support/topic/jquery-comes-up-in-feed-content/
	 * @link https://wordpress.org/support/topic/doesnt-work-with-mailpoet/
	 *
	 * @reporter @markcheret
	 * @link https://wordpress.org/support/topic/footnotes-now-appear-in-summaries-even-though-this-is-marked-no/
	 *
	 * @reporter @martinneumannat
	 * @link https://wordpress.org/support/topic/problem-with-footnotes-in-excerpts-of-the-blog-page/
	 *
	 * @since 2.6.2
	 * @param string $p_str_content  The post.
	 * @return string $p_str_content  An excerpt of the post.
	 * Applies full WordPress excerpt processing.
	 * @link https://developer.wordpress.org/reference/functions/wp_trim_excerpt/
	 * @link https://developer.wordpress.org/reference/functions/wp_trim_words/
	 */
	public function generate_excerpt( $p_str_content ) {

		// Discard existing excerpt and start on the basis of the post.
		$p_str_content = get_the_content( get_the_id() );

		// Get footnote delimiter shortcodes and unify them.
		$p_str_content = self::unify_delimiters( $p_str_content );

		// Remove footnotes.
		$p_str_content = preg_replace( '#' . self::$a_str_start_tag_regex . '.+?' . self::$a_str_end_tag_regex . '#', '', $p_str_content );

		// Apply WordPress excerpt processing.
		$p_str_content = strip_shortcodes( $p_str_content );
		$p_str_content = excerpt_remove_blocks( $p_str_content );

		// Here the footnotes would be processed as part of WordPress content processing.
		$p_str_content = apply_filters( 'the_content', $p_str_content );

		// According to Advanced Excerpt, this is some kind of precaution against malformed CDATA in RSS feeds.
		$p_str_content = str_replace( ']]>', ']]&gt;', $p_str_content );

		$l_int_excerpt_length = (int) _x( '55', 'excerpt_length' );
		$l_int_excerpt_length = (int) apply_filters( 'excerpt_length', $l_int_excerpt_length );
		$l_str_excerpt_more   = apply_filters( 'excerpt_more', ' [&hellip;]' );

		// Function wp_trim_words() calls wp_strip_all_tags() that wrecks the footnotes.
		$p_str_content = wp_trim_words( $p_str_content, $l_int_excerpt_length, $l_str_excerpt_more );

		return $p_str_content;
	}

	/**
	 * Generates excerpt with footnotes on the basis of the post.
	 *
	 * - Bugfix: Excerpts: debug the 'Yes' option by generating excerpts with footnotes on the basis of the posts, thanks to @nikelaos @martinneumannat bug reports.
	 *
	 * @reporter @nikelaos
	 * @link https://wordpress.org/support/topic/jquery-comes-up-in-feed-content/
	 * @link https://wordpress.org/support/topic/doesnt-work-with-mailpoet/
	 *
	 * @reporter @martinneumannat
	 * @link https://wordpress.org/support/topic/problem-with-footnotes-in-excerpts-of-the-blog-page/
	 *
	 * @since 2.6.3
	 *
	 * - Bugfix: Process: remove trailing comma after last argument in multiline function calls for PHP < 7.3, thanks to @scroom @copylefter @lagoon24 bug reports.
	 *
	 * @reporter @scroom
	 * @link https://wordpress.org/support/topic/update-crashed-my-website-3/
	 *
	 * @reporter @copylefter
	 * @link https://wordpress.org/support/topic/update-crashed-my-website-3/#post-14259151
	 *
	 * @reporter @lagoon24
	 * @link https://wordpress.org/support/topic/update-crashed-my-website-3/#post-14259396
	 *
	 * @since 2.6.4
	 * @param string $p_str_content  The post.
	 * @return string $p_str_content  An excerpt of the post.
	 * Does not apply full WordPress excerpt processing.
	 * @see self::generate_excerpt()
	 * Uses information and some code from Advanced Excerpt.
	 * @link https://wordpress.org/plugins/advanced-excerpt/
	 */
	public function generate_excerpt_with_footnotes( $p_str_content ) {

		// Discard existing excerpt and start on the basis of the post.
		$p_str_content = get_the_content( get_the_id() );

		// Get footnote delimiter shortcodes and unify them.
		$p_str_content = self::unify_delimiters( $p_str_content );

		// Apply WordPress excerpt processing.
		$p_str_content = strip_shortcodes( $p_str_content );
		$p_str_content = excerpt_remove_blocks( $p_str_content );

		// But do not process footnotes at this point; do only this.
		$p_str_content = str_replace( ']]>', ']]&gt;', $p_str_content );

		// Prepare the excerpt length argument.
		$l_int_excerpt_length = (int) _x( '55', 'excerpt_length' );
		$l_int_excerpt_length = (int) apply_filters( 'excerpt_length', $l_int_excerpt_length );

		// Prepare the Read-on string.
		$l_str_excerpt_more = apply_filters( 'excerpt_more', ' [&hellip;]' );

		// Safeguard the footnotes.
		preg_match_all(
			'#' . self::$a_str_start_tag_regex . '.+?' . self::$a_str_end_tag_regex . '#',
			$p_str_content,
			$p_arr_saved_footnotes
		);

		// Prevent the footnotes from altering the excerpt: previously hard-coded '5ED84D6'.
		$l_int_placeholder = '@' . mt_rand( 100000000, 2147483647 ) . '@';
		$p_str_content     = preg_replace(
			'#' . self::$a_str_start_tag_regex . '.+?' . self::$a_str_end_tag_regex . '#',
			$l_int_placeholder,
			$p_str_content
		);

		// Replace line breaking markup with a separator.
		$l_str_separator = ' ';
		$p_str_content   = preg_replace( '#<br *>#', $l_str_separator, $p_str_content );
		$p_str_content   = preg_replace( '#<br */>#', $l_str_separator, $p_str_content );
		$p_str_content   = preg_replace( '#<(p|li|div)[^>]*>#', $l_str_separator, $p_str_content );
		$p_str_content   = preg_replace( '#' . $l_str_separator . '#', '', $p_str_content, 1 );
		$p_str_content   = preg_replace( '#</(p|li|div) *>#', '', $p_str_content );
		$p_str_content   = preg_replace( '#[\r\n]#', '', $p_str_content );

		// To count words like Advanced Excerpt does it.
		$l_arr_tokens  = array();
		$l_str_output  = '';
		$l_int_counter = 0;

		// Tokenize into tags and words as in Advanced Excerpt.
		preg_match_all( '#(<[^>]+>|[^<>\s]+)\s*#u', $p_str_content, $l_arr_tokens );

		// Count words following one option of Advanced Excerpt.
		foreach ( $l_arr_tokens[0] as $l_str_token ) {

			if ( $l_int_counter >= $l_int_excerpt_length ) {
				break;
			}
			// If token is not a tag, increment word count.
			if ( '<' !== $l_str_token[0] ) {
				$l_int_counter++;
			}
			// Append the token to the output.
			$l_str_output .= $l_str_token;
		}

		// Complete unbalanced markup, used by Advanced Excerpt.
		$p_str_content = force_balance_tags( $l_str_output );

		// Readd footnotes in excerpt.
		$l_int_index = 0;
		while ( 0 !== preg_match( '#' . $l_int_placeholder . '#', $p_str_content ) ) {
			$p_str_content = preg_replace(
				'#' . $l_int_placeholder . '#',
				$p_arr_saved_footnotes[0][ $l_int_index ],
				$p_str_content,
				1
			);
			$l_int_index++;
		}

		// Append the Read-on string as in wp_trim_words().
		$p_str_content .= $l_str_excerpt_more;

		// Process readded footnotes without appending the reference container.
		$p_str_content = self::exec( $p_str_content, false );

		return $p_str_content;

	}

	/**
	 * Replaces footnotes in the widget title.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content  Widget content.
	 * @return string $p_str_content  Content with replaced footnotes.
	 */
	public function footnotes_in_widget_title( $p_str_content ) {
		// Appends the reference container if set to "post_end".
		return $this->exec( $p_str_content, false );
	}

	/**
	 * Replaces footnotes in the content of the current widget.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content  Widget content.
	 * @return string $p_str_content  Content with replaced footnotes.
	 */
	public function footnotes_in_widget_text( $p_str_content ) {
		// phpcs:disable WordPress.PHP.YodaConditions.NotYoda
		// Appends the reference container if set to "post_end".
		return $this->exec( $p_str_content, 'post_end' === Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION ) ? true : false );
		// phpcs:enable WordPress.PHP.YodaConditions.NotYoda
	}

	/**
	 * Replaces all footnotes that occur in the given content.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content              Any string that may contain footnotes to be replaced.
	 * @param bool   $p_bool_output_references   Appends the Reference Container to the output if set to true, default true.
	 * @param bool   $p_bool_hide_footnotes_text Hide footnotes found in the string.
	 * @return string
	 */
	public function exec( $p_str_content, $p_bool_output_references = false, $p_bool_hide_footnotes_text = false ) {

		// Process content.
		$p_str_content = $this->search( $p_str_content, $p_bool_hide_footnotes_text );

		/**
		 * Reference container customized positioning through shortcode.
		 *
		 * - Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/
		 *
		 * @since 2.2.0
		 *
		 * - Bugfix: Reference container: delete position shortcode if unused because position may be widget or footer, thanks to @hamshe bug report.
		 *
		 * @reporter @hamshe
		 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13784126
		 *
		 * @since 2.2.5
		 */
		// Append the reference container or insert at shortcode.
		$l_str_reference_container_position_shortcode = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE );
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
		if ( strpos( $p_str_content, Footnotes_Config::C_STR_NO_LOVE_SLUG ) ) {
			self::$a_bool_allow_love_me = false;
			$p_str_content              = str_replace( Footnotes_Config::C_STR_NO_LOVE_SLUG, '', $p_str_content );
		}
		// Return the content with replaced footnotes and optional reference container appended.
		return $p_str_content;
	}

	/**
	 * Brings the delimiters and unifies their various HTML escapement schemas.
	 *
	 * @param string $p_str_content TODO.
	 *
	 * - Bugfix: Footnote delimiter short codes: fix numbering bug by cross-editor HTML escapement schema unification, thanks to @patrick_here @alifarahani8000 @gova bug reports.
	 *
	 * @reporter @patrick_here
	 * @link https://wordpress.org/support/topic/how-to-add-footnotes-shortcode-in-elementor/
	 *
	 * @reporter @alifarahani8000
	 * @link https://wordpress.org/support/topic/after-version-2-5-10-the-ref-or-tags-are-not-longer-working/
	 *
	 * @reporter @gova
	 * @link https://wordpress.org/support/topic/footnotes-content-number-not-sequential/
	 *
	 * @since 2.1.14
	 * While the Classic Editor (visual mode) escapes both pointy brackets,
	 * the Block Editor enforces balanced escapement only in code editor mode
	 * when the opening tag is already escaped. In visual mode, the Block Editor
	 * does not escape the greater-than sign.
	 */
	public function unify_delimiters( $p_str_content ) {

		// Get footnotes start and end tag short codes.
		$l_str_starting_tag = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START );
		$l_str_ending_tag   = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END );
		if ( 'userdefined' === $l_str_starting_tag || 'userdefined' === $l_str_ending_tag ) {
			$l_str_starting_tag = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$l_str_ending_tag   = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}

		// If any footnotes short code is empty, return the content without changes.
		if ( empty( $l_str_starting_tag ) || empty( $l_str_ending_tag ) ) {
			return $p_str_content;
		}

		if ( preg_match( '#[&"\'<>]#', $l_str_starting_tag . $l_str_ending_tag ) ) {

			$l_str_harmonized_start_tag = '{[(|fnote_stt|)]}';
			$l_str_harmonized_end_tag   = '{[(|fnote_end|)]}';

			// Harmonize footnotes without escaping any HTML special characters in delimiter shortcodes.
			// The footnote has been added in the Block Editor code editor (doesn’t work in Classic Editor text mode).
			$p_str_content = str_replace( $l_str_starting_tag, $l_str_harmonized_start_tag, $p_str_content );
			$p_str_content = str_replace( $l_str_ending_tag, $l_str_harmonized_end_tag, $p_str_content );

			// Harmonize footnotes while escaping HTML special characters in delimiter shortcodes.
			// The footnote has been added in the Classic Editor visual mode.
			$p_str_content = str_replace( htmlspecialchars( $l_str_starting_tag ), $l_str_harmonized_start_tag, $p_str_content );
			$p_str_content = str_replace( htmlspecialchars( $l_str_ending_tag ), $l_str_harmonized_end_tag, $p_str_content );

			// Harmonize footnotes while escaping HTML special characters except greater-than sign in delimiter shortcodes.
			// The footnote has been added in the Block Editor visual mode.
			$p_str_content = str_replace( str_replace( '&gt;', '>', htmlspecialchars( $l_str_starting_tag ) ), $l_str_harmonized_start_tag, $p_str_content );
			$p_str_content = str_replace( str_replace( '&gt;', '>', htmlspecialchars( $l_str_ending_tag ) ), $l_str_harmonized_end_tag, $p_str_content );

			// Assign the delimiter shortcodes.
			self::$a_str_start_tag = $l_str_harmonized_start_tag;
			self::$a_str_end_tag   = $l_str_harmonized_end_tag;

			// Assign the regex-conformant shortcodes.
			self::$a_str_start_tag_regex = '\{\[\(\|fnote_stt\|\)\]\}';
			self::$a_str_end_tag_regex   = '\{\[\(\|fnote_end\|\)\]\}';

		} else {

			// Assign the delimiter shortcodes.
			self::$a_str_start_tag = $l_str_starting_tag;
			self::$a_str_end_tag   = $l_str_ending_tag;

			// Make shortcodes conform to regex syntax.
			self::$a_str_start_tag_regex = preg_replace( '#([\(\)\{\}\[\]\|\*\.\?\!])#', '\\\\$1', self::$a_str_start_tag );
			self::$a_str_end_tag_regex   = preg_replace( '#([\(\)\{\}\[\]\|\*\.\?\!])#', '\\\\$1', self::$a_str_end_tag );
		}

		return $p_str_content;
	}

	/**
	 * Replaces all footnotes in the given content and appends them to the static property.
	 *
	 * @since 1.5.0
	 * @param string $p_str_content              Any content to be searched for footnotes.
	 * @param bool   $p_bool_hide_footnotes_text Hide footnotes found in the string.
	 * @return string
	 *
	 * @since 2.0.0  various.
	 * @since 2.4.0  Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
	 * @since 2.5.0  Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
	 *
	 * - Bugfix: Footnote delimiter short codes: debug closing pointy brackets in the Block Editor by accounting for unbalanced HTML escapement, thanks to @patrick_here @alifarahani8000 bug reports.
	 *
	 * @reporter @patrick_here
	 * @link https://wordpress.org/support/topic/how-to-add-footnotes-shortcode-in-elementor/
	 *
	 * @reporter @alifarahani8000
	 * @link https://wordpress.org/support/topic/after-version-2-5-10-the-ref-or-tags-are-not-longer-working/
	 *
	 * @since 2.5.13
	 */
	public function search( $p_str_content, $p_bool_hide_footnotes_text ) {

		// Get footnote delimiter shortcodes and unify them.
		$p_str_content = self::unify_delimiters( $p_str_content );

		/**
		 * Checks for balanced footnote delimiters; delimiter syntax validation.
		 *
		 * - Adding: Footnote delimiters: syntax validation for balanced footnote start and end tag short codes.
		 *
		 * @since 2.4.0
		 *
		 * - Bugfix: Footnote delimiters: Syntax validation: exclude certain cases involving scripts, thanks to @andreasra bug report.
		 * - Bugfix: Footnote delimiters: Syntax validation: complete message with hint about setting, thanks to @andreasra bug report.
		 * - Bugfix: Footnote delimiters: Syntax validation: limit length of quoted string to 300 characters, thanks to @andreasra bug report.
		 *
		 * @reporter @andreasra
		 * @link https://wordpress.org/support/topic/warning-unbalanced-footnote-start-tag-short-code-before/
		 *
		 * @since 2.5.0
		 * If footnotes short codes are unbalanced, and syntax validation is not disabled,
		 * prepend a warning to the content; displays de facto beneath the post title.
		 */
		// If enabled.
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE ) ) ) {

			// Apply different regex depending on whether start shortcode is double/triple opening parenthesis.
			if ( '((' === self::$a_str_start_tag || '(((' === self::$a_str_start_tag ) {

				// This prevents from catching a script containing e.g. a double opening parenthesis.
				$l_str_validation_regex = '#' . self::$a_str_start_tag_regex . '(((?!' . self::$a_str_end_tag_regex . ')[^\{\}])*?)(' . self::$a_str_start_tag_regex . '|$)#s';

			} else {

				// Catch all only if the start shortcode is not double/triple opening parenthesis, i.e. is unlikely to occur in scripts.
				$l_str_validation_regex = '#' . self::$a_str_start_tag_regex . '(((?!' . self::$a_str_end_tag_regex . ').)*?)(' . self::$a_str_start_tag_regex . '|$)#s';
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

		/**
		 * Patch to allow footnotes in input field labels.
		 *
		 * - Bugfix: Forms: remove footnotes from input field values, thanks to @bogosavljev bug report.
		 *
		 * @reporter @bogosavljev
		 * @link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/
		 *
		 * @since 2.5.11
		 * When the HTML 'input' element 'value' attribute value
		 * is derived from 'label', footnotes need to be removed
		 * in the value of 'value'.
		 */
		$l_str_value_regex = '#(<input [^>]+?value=["\'][^>]+?)' . self::$a_str_start_tag_regex . '[^>]+?' . self::$a_str_end_tag_regex . '#';

		do {
			$p_str_content = preg_replace( $l_str_value_regex, '$1', $p_str_content );
		} while ( preg_match( $l_str_value_regex, $p_str_content ) );

		/**
		 * Optionally moves footnotes outside at the end of the label element.
		 *
		 * - Bugfix: Forms: prevent inadvertently toggling input elements with footnotes in their label, by optionally moving footnotes after the end of the label.
		 *
		 * @since 2.5.12
		 * @link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14212318
		 */
		$l_str_label_issue_solution = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_LABEL_ISSUE_SOLUTION );

		if ( 'move' === $l_str_label_issue_solution ) {

			$l_str_move_regex = '#(<label ((?!</label).)+?)(' . self::$a_str_start_tag_regex . '((?!</label).)+?' . self::$a_str_end_tag_regex . ')(((?!</label).)*?</label>)#';

			do {
				$p_str_content = preg_replace( $l_str_move_regex, '$1$5<span class="moved_footnote">$3</span>', $p_str_content );
			} while ( preg_match( $l_str_move_regex, $p_str_content ) );
		}

		/**
		 * Optionally disconnects labels with footnotes from their input element.
		 *
		 * - Bugfix: Forms: prevent inadvertently toggling input elements with footnotes in their label, by optionally disconnecting those labels.
		 *
		 * @since 2.5.12
		 * This option is discouraged because of accessibility issues.
		 * This only edits those labels’ 'for' value that have footnotes,
		 * but leaves all other labels (those without footnotes) alone.
		 * @link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14212318
		 */
		if ( 'disconnect' === $l_str_label_issue_solution ) {

			$l_str_disconnect_text = 'optionally-disconnected-from-input-field-to-prevent-toggling-while-clicking-footnote-referrer_';

			$p_str_content = preg_replace(
				'#(<label [^>]+?for=["\'])(((?!</label).)+' . self::$a_str_start_tag_regex . ')#',
				'$1' . $l_str_disconnect_text . '$2',
				$p_str_content
			);
		}

		// Post ID to make everything unique wrt infinite scroll and archive view.
		self::$a_int_post_id = get_the_id();

		/**
		 * Empties the footnotes list every time Footnotes is run when the_content hook is called.
		 *
		 * - Bugfix: Process: fix footnote duplication by emptying the footnotes list every time the search algorithm is run on the content, thanks to @inoruhana bug report.
		 *
		 * @reporter @inoruhana
		 * @link https://wordpress.org/support/topic/footnote-duplicated-in-the-widget/
		 *
		 * @since 2.5.7
		 * Under certain circumstances, footnotes were duplicated, because the footnotes list was
		 * not emptied every time before the search algorithm was run. That happened eg when both
		 * the reference container resides in the widget area, and the YOAST SEO plugin is active
		 * and calls the hook the_content to generate the Open Graph description, while Footnotes
		 * is set to avoid missing out on the footnotes (in the content) by hooking in as soon as
		 * the_content is called, whereas at post end Footnotes seems to hook in the_content only
		 * the time it’s the blog engine processing the post for display and appending the refs.
		 *
		 * @since 2.6.3  Move footnotes list reset from footnotes_in_content() to search().
		 * Emptying the footnotes list only when the_content hook is called is ineffective
		 * when footnotes are processed in generate_excerpt_with_footnotes().
		 * Footnotes duplication is prevented also when resetting the list here.
		 */
		self::$a_arr_footnotes = array();

		// Resets the footnote number.
		$l_int_footnote_index = 1;

		// Contains the starting position for the lookup of a footnote.
		$l_int_pos_start = 0;

		/*
		 * Load footnote referrer template file.
		 */

		// Set to null in case all templates are unnecessary.
		$l_obj_template         = null;
		$l_obj_template_tooltip = null;

		// On the condition that the footnote text is not hidden.
		if ( ! $p_bool_hide_footnotes_text ) {

			// Whether AMP compatibility mode is enabled.
			if ( Footnotes::$a_bool_amp_enabled ) {

				// Whether first clicking a referrer needs to expand the reference container.
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE ) ) ) {

					// Load 'templates/public/amp-footnote-expand.html'.
					$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-footnote-expand' );

				} else {

					// Load 'templates/public/amp-footnote.html'.
					$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-footnote' );
				}
			} elseif ( Footnotes::$a_bool_alternative_tooltips_enabled ) {

				// Load 'templates/public/footnote-alternative.html'.
				$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'footnote-alternative' );

				// Else jQuery tooltips are enabled.
			} else {

				// Load 'templates/public/footnote.html'.
				$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'footnote' );

				// Load tooltip inline script.
				$l_obj_template_tooltip = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'tooltip' );
			}
		}

		// Search footnotes short codes in the content.
		do {
			// Get first occurrence of the footnote start tag short code.
			$i_int_len_content = strlen( $p_str_content );
			if ( $l_int_pos_start > $i_int_len_content ) {
				$l_int_pos_start = $i_int_len_content;
			}
			$l_int_pos_start = strpos( $p_str_content, self::$a_str_start_tag, $l_int_pos_start );
			// No short code found, stop here.
			if ( ! $l_int_pos_start ) {
				break;
			}
			// Get first occurrence of the footnote end tag short code.
			$l_int_pos_end = strpos( $p_str_content, self::$a_str_end_tag, $l_int_pos_start );
			// No short code found, stop here.
			if ( ! $l_int_pos_end ) {
				break;
			}
			// Calculate the length of the footnote.
			$l_int_length = $l_int_pos_end - $l_int_pos_start;

			// Get footnote text.
			$l_str_footnote_text = substr( $p_str_content, $l_int_pos_start + strlen( self::$a_str_start_tag ), $l_int_length - strlen( self::$a_str_start_tag ) );

			// Get tooltip text if present.
			self::$a_str_tooltip_shortcode        = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER );
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
			 * @reporter @andreasra
			 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/3/#post-13657398
			 *
			 * @since 2.1.1
			 *
			 * - Bugfix: Reference container: fix width in mobile view by URL wrapping for Unicode-non-conformant browsers, thanks to @karolszakiel bug report.
			 *
			 * @reporter @karolszakiel
			 * @link https://wordpress.org/support/topic/footnotes-on-mobile-phones/
			 *
			 * @since 2.1.3
					 *
			 * - Bugfix: Reference container, tooltips: fix line wrapping of URLs (hyperlinked or not) based on pattern, not link element.
			 *
			 * @since 2.1.4
					 * @link https://wordpress.org/support/topic/footnotes-on-mobile-phones/#post-13710682
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: exclude image source too, thanks to @bjrnet21 bug report.
			 *
			 * @reporter @bjrnet21
			 * @link https://wordpress.org/support/topic/2-1-4-breaks-on-my-site-images-dont-show/
			 *
			 * @since 2.1.5
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: fix regex, thanks to @a223123131 bug report.
			 *
			 * @reporter @a223123131
			 * @link https://wordpress.org/support/topic/broken-layout-starting-version-2-1-4/
			 *
			 * @since 2.1.6
					 *
			 * Even ARIA labels may take a URL as value, so use \w=[\'"] as a catch-all
			 *
			 * - Bugfix: Dashboard: URL wrap: add option to properly enable/disable URL wrap.
			 *
			 * @since 2.1.6
					 *
			 * - Bugfix: Reference container, tooltips: URL wrap: make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
			 *
			 * @reporter @spiralofhope2
			 * @link https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/
			 *
			 * @since 2.2.6
					 *
			 * - Bugfix: Reference container, tooltips: URL wrap: remove a bug introduced in the regex, thanks to @rjl20 @spaceling @lukashuggenberg @klusik @friedrichnorth @bernardzit bug reports.
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
			 * @since 2.2.7
					 *
			 * - Bugfix: Reference container, tooltips: URL wrap: correctly make the quotation mark optional wrt query parameters, thanks to @spiralofhope2 bug report.
			 *
			 * @reporter @spiralofhope2
			 * @link https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/
			 *
			 * @since 2.2.8
					 * Correct is duplicating the negative lookbehind w/o quotes: '(?<!\w=)'
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: account for RFC 2396 allowed characters in parameter names.
			 * - Bugfix: Reference container, tooltips: URL wrap: exclude URLs also where the equals sign is preceded by an entity or character reference.
			 *
			 * @since 2.2.9
					 * @link https://stackoverflow.com/questions/814700/http-url-allowed-characters-in-parameter-names
					 *
			 * - Bugfix: Reference container, tooltips: URL wrap: support also file transfer protocol URLs.
			 *
			 * @since 2.2.10
					 *
			 * - Bugfix: Reference container, tooltips: URL wrap: exclude URL pattern as folder name in Wayback Machine URL, thanks to @rumperuu bug report.
			 *
			 * @reporter @rumperuu
			 * @link https://wordpress.org/support/topic/line-wrap-href-regex-bug/
			 *
			 * @since 2.5.3
					 * By adding a 3rd negative lookbehind: '(?<!/)'.
			 *
			 * - Bugfix: Reference container, tooltips: URL wrap: account for leading space in value, thanks to @karolszakiel example provision.
			 *
			 * @reporter @karolszakiel
			 * @link https://wordpress.org/support/topic/footnotes-on-mobile-phones/
			 *
			 * @since 2.5.4
			 * The value of an href argument may have leading (and trailing) space.
			 * @link https://webmasters.stackexchange.com/questions/93540/are-spaces-in-href-valid
			 * Needs to replicate the relevant negative lookbehind at least with one and with two spaces.
			 * Note: The WordPress blog engine edits these values, cropping these leading/trailing spaces.
			 */
			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTE_URL_WRAP_ENABLED ) ) ) {

				$l_str_footnote_text = preg_replace(
					'#(?<![-\w\.!~\*\'\(\);]=[\'"])(?<![-\w\.!~\*\'\(\);]=[\'"] )(?<![-\w\.!~\*\'\(\);]=[\'"]  )(?<![-\w\.!~\*\'\(\);]=)(?<!/)((ht|f)tps?://[^\\s<]+)#',
					'<span class="footnote_url_wrap">$1</span>',
					$l_str_footnote_text
				);
			}

			// Text to be displayed instead of the footnote.
			$l_str_footnote_replace_text = '';

			// Whether hard links are enabled.
			if ( self::$a_bool_hard_links_enabled ) {

				// Get the configurable parts.
				self::$a_str_referrer_link_slug = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG );
				self::$a_str_footnote_link_slug = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG );
				self::$a_str_link_ids_separator = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR );

				// Streamline ID concatenation.
				self::$a_str_post_container_id_compound  = self::$a_str_link_ids_separator;
				self::$a_str_post_container_id_compound .= self::$a_int_post_id;
				self::$a_str_post_container_id_compound .= self::$a_str_link_ids_separator;
				self::$a_str_post_container_id_compound .= self::$a_int_reference_container_id;
				self::$a_str_post_container_id_compound .= self::$a_str_link_ids_separator;

			}

			// Display the footnote referrers and the tooltips.
			if ( ! $p_bool_hide_footnotes_text ) {
				$l_int_index = Footnotes_Convert::index( $l_int_footnote_index, Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) );

				// Display only a truncated footnote text if option enabled.
				$l_bool_enable_excerpt = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED ) );
				$l_int_max_length      = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH ) );

				// Define excerpt text as footnote text by default.
				$l_str_excerpt_text = $l_str_footnote_text;

				/**
				 * Tooltip truncation.
				 *
				 * - Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
				 *
				 * @reporter @rovanov
				 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
				 *
				 * @since 2.1.0
				 * If the tooltip truncation option is enabled, it’s done based on character count,
				 * and a trailing incomplete word is cropped.
				 * This is equivalent to the WordPress default excerpt generation, i.e. without a
				 * custom excerpt and without a delimiter. But WordPress does word count, usually 55.
				 */
				if ( Footnotes::$a_bool_tooltips_enabled && $l_bool_enable_excerpt ) {
					$l_str_dummy_text = wp_strip_all_tags( $l_str_footnote_text );
					if ( is_int( $l_int_max_length ) && strlen( $l_str_dummy_text ) > $l_int_max_length ) {
						$l_str_excerpt_text  = substr( $l_str_dummy_text, 0, $l_int_max_length );
						$l_str_excerpt_text  = substr( $l_str_excerpt_text, 0, strrpos( $l_str_excerpt_text, ' ' ) );
						$l_str_excerpt_text .= '&nbsp;&#x2026; <';
						$l_str_excerpt_text .= self::$a_bool_hard_links_enabled ? 'a' : 'span';
						$l_str_excerpt_text .= ' class="footnote_tooltip_continue" ';

						// If AMP compatibility mode is enabled.
						if ( Footnotes::$a_bool_amp_enabled ) {

							// If the reference container is also collapsed by default.
							if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE ) ) ) {

								$l_str_excerpt_text .= ' on="tap:footnote_references_container_';
								$l_str_excerpt_text .= self::$a_int_post_id . '_' . self::$a_int_reference_container_id;
								$l_str_excerpt_text .= '.toggleClass(class=collapsed, force=false),footnotes_container_button_plus_';
								$l_str_excerpt_text .= self::$a_int_post_id . '_' . self::$a_int_reference_container_id;
								$l_str_excerpt_text .= '.toggleClass(class=collapsed, force=true),footnotes_container_button_minus_';
								$l_str_excerpt_text .= self::$a_int_post_id . '_' . self::$a_int_reference_container_id;
								$l_str_excerpt_text .= '.toggleClass(class=collapsed, force=false)"';
							}
						} else {

							// Don’t add onclick event in AMP compatibility mode.
							// Reverted wrong linting.
							$l_str_excerpt_text .= ' onclick="footnote_moveToReference_' . self::$a_int_post_id;
							$l_str_excerpt_text .= '_' . self::$a_int_reference_container_id;
							$l_str_excerpt_text .= '(\'footnote_plugin_reference_' . self::$a_int_post_id;
							$l_str_excerpt_text .= '_' . self::$a_int_reference_container_id;
							$l_str_excerpt_text .= "_$l_int_index');\"";
						}

						// If enabled, add the hard link fragment ID.
						if ( self::$a_bool_hard_links_enabled ) {

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
						 * @reporter @rovanov
						 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
						 *
						 * @since 2.1.0
						 */
						$l_str_excerpt_text .= Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL );

						$l_str_excerpt_text .= self::$a_bool_hard_links_enabled ? '</a>' : '</span>';
					}
				}

				/**
				 * Referrers element superscript or baseline.
				 *
				 * - Bugfix: Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report.
				 *
				 * @reporter @cwbayer
				 * @link https://wordpress.org/support/topic/footnote-number-in-text-superscript-disrupts-leading/
				 *
				 * @since 2.1.1
				 * Define the HTML element to use for the referrers.
				 */
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS ) ) ) {

					$l_str_sup_span = 'sup';

				} else {

					$l_str_sup_span = 'span';
				}

				// Whether hard links are enabled.
				if ( self::$a_bool_hard_links_enabled ) {

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
					 * @reporter @a223123131
					 * @link https://wordpress.org/support/topic/wp_debug-php-notice/
					 *
					 * @since 2.4.0
					 * If no hyperlink nor offset anchor is needed, initialize as empty.
					 */
					$l_str_footnote_link_argument  = '';
					$l_str_referrer_anchor_element = '';

					// The link element is set independently as it may be needed for styling.
					if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_LINK_ELEMENT_ENABLED ) ) ) {

						self::$a_str_link_span      = 'a';
						self::$a_str_link_open_tag  = '<a>';
						self::$a_str_link_close_tag = '</a>';

					}
				}

				// Determine tooltip content.
				if ( Footnotes::$a_bool_tooltips_enabled ) {
					$l_str_tooltip_content = $l_bool_has_tooltip_text ? $l_str_tooltip_text : $l_str_excerpt_text;
					/**
					 * Ensures paragraph separation
					 *
					 * @reporter @pewgeuges
					 * @link https://github.com/markcheret/footnotes/issues/103
					 * @since 2.7.1
					 * Ensures that footnotes containing paragraph separators get displayed correctly.
					 */
					$l_arr_paragraph_splitters = array( '#(</p *>|<p[^>]*>)#', '#(</div *>|<div[^>]*>)#' );
					$l_str_tooltip_content     = preg_replace( $l_arr_paragraph_splitters, '<br />', $l_str_tooltip_content );
				} else {
					$l_str_tooltip_content = '';
				}

				/**
				 * Determine shrink width if alternative tooltips are enabled.
				 *
				 * @since 2.5.6
				 */
				$l_str_tooltip_style = '';
				if ( Footnotes::$a_bool_alternative_tooltips_enabled && Footnotes::$a_bool_tooltips_enabled ) {
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
						'before'         => Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE ),
						'index'          => $l_int_index,
						'after'          => Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER ),
						'anchor-element' => $l_str_referrer_anchor_element,
						'style'          => $l_str_tooltip_style,
						'text'           => $l_str_tooltip_content,
					)
				);
				$l_str_footnote_replace_text = $l_obj_template->get_content();

				// Reset the template.
				$l_obj_template->reload();

				// If tooltips are enabled but neither AMP nor alternative are.
				if ( Footnotes::$a_bool_tooltips_enabled && ! Footnotes::$a_bool_amp_enabled && ! Footnotes::$a_bool_alternative_tooltips_enabled ) {

					$l_int_offset_y          = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y ) );
					$l_int_offset_x          = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X ) );
					$l_int_fade_in_delay     = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY ) );
					$l_int_fade_in_duration  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ) );
					$l_int_fade_out_delay    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY ) );
					$l_int_fade_out_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION ) );

					// Fill in 'templates/public/tooltip.html'.
					$l_obj_template_tooltip->replace(
						array(
							'post_id'           => self::$a_int_post_id,
							'container_id'      => self::$a_int_reference_container_id,
							'note_id'           => $l_int_index,
							'position'          => Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION ),
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
			$p_str_content = substr_replace( $p_str_content, $l_str_footnote_replace_text, $l_int_pos_start, $l_int_length + strlen( self::$a_str_end_tag ) );

			// Add footnote only if not empty.
			if ( ! empty( $l_str_footnote_text ) ) {
				// Set footnote to the output box at the end.
				self::$a_arr_footnotes[] = $l_str_footnote_text;
				// Increase footnote index.
				$l_int_footnote_index++;
			}

			/**
			 * Fixes a partial footnotes process outage happening when tooltips are truncated or disabled.
			 * Fixed a footnotes numbering bug happening under de facto rare circumstances.
			 *
			 * - Bugfix: Fixed occasional bug where footnote ordering could be out of sequence
			 *
			 * @since 1.6.4
			 * @committer @dartiss
			 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class/task.php?rev=1445718 @dartiss’ class/task.php
			 * @link https://plugins.trac.wordpress.org/log/footnotes/trunk/class/task.php?rev=1445718 @dartiss re-added class/task.php
			 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class?rev=1445711 class/ w/o task.php
			 * @link https://plugins.trac.wordpress.org/changeset/1445711/footnotes/trunk/class @dartiss deleted class/task.php
			 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class/task.php?rev=1026210 @aricura’s latest class/task.php
			 *
			 * - Bugfix: Process: fix numbering bug impacting footnote #2 with footnote #1 close to start, thanks to @rumperuu bug report, thanks to @lolzim code contribution.
			 *
			 * @reporter @rumperuu
			 * @link https://wordpress.org/support/topic/footnotes-numbered-incorrectly/
			 *
			 * @contributor @lolzim
			 * @link https://wordpress.org/support/topic/footnotes-numbered-incorrectly/#post-14062032
			 *
			 * @since 2.5.5
			 * This assignment was overridden by another one, causing the algorithm to jump back
			 * near the post start to a position calculated as the sum of the length of the last
			 * footnote and the length of the last footnote replace text.
			 * A bug disturbing the order of the footnotes depending on the text before the first
			 * footnote, the length of the first footnote and the length of the templates for the
			 * footnote and the tooltip.
			 * Deleting both lines instead, to resume the search at the position where it left off,
			 * would have prevented also the following bug.
			 *
			 * - Bugfix: Process: fix issue that caused some footnotes to not be processed, thanks to @docteurfitness @rkupadhya @offpeakdesign bug reports.
			 *
			 * @reporter @docteurfitness
			 * @link https://wordpress.org/support/topic/problem-since-footnotes-2-5-14/
			 *
			 * @reporter @rkupadhya
			 * @link https://wordpress.org/support/topic/adjacent-footnotes-not-working-sometimes/
			 *
			 * @reporter @offpeakdesign
			 * @link https://wordpress.org/support/topic/character-limit-bug/
			 *
			 * @since 2.6.6
			 * The origin of the bug was present since the beginning (v1.0.0).
			 * For v1.3.2 the wrong code was refactored but remained wrong,
			 * and was unaffected by the v1.5.0 refactoring.
			 * The reason why the numbering disorder reverted to a partial process outage
			 * since 2.5.14 is that with this version, the plugin stopped processing the
			 * content multiple times, and started unifying the shortcodes instead, to fix
			 * the numbering disorder affecting delimiter shortcodes with pointy brackets
			 * and mixed escapement schemas.
			 */
			// Add offset to the new starting position.
			$l_int_pos_start += strlen( $l_str_footnote_replace_text );

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
		 * @reporter @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13671138
		 *
		 * @since 2.1.1
		 */
		// If the backlink symbol is enabled.
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE ) ) ) {

			// Get html arrow.
			$l_str_arrow = Footnotes_Convert::get_arrow( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_HYPERLINK_ARROW ) );
			// Set html arrow to the first one if invalid index defined.
			if ( is_array( $l_str_arrow ) ) {
				$l_str_arrow = Footnotes_Convert::get_arrow( 0 );
			}
			// Get user defined arrow.
			$l_str_arrow_user_defined = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED );
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
		 * @reporter @docteurfitness
		 * @link https://wordpress.org/support/topic/update-2-1-3/
		 *
		 * @contributor @docteurfitness
		 * @link https://wordpress.org/support/topic/update-2-1-3/#post-13704194
		 *
		 * @since 2.1.4
		 * Initially an appended comma was hard-coded in this algorithm for enumerations.
		 * The comma in enumerations is not universally preferred.
		 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_ENABLED ) ) ) {

			// Check if it is input-configured.
			$l_str_separator = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM );

			if ( empty( $l_str_separator ) ) {

				// If it is not, check which option is on.
				$l_str_separator_option = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION );
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_ENABLED ) ) ) {

			// Check if it is input-configured.
			$l_str_terminator = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM );

			if ( empty( $l_str_terminator ) ) {

				// If it is not, check which option is on.
				$l_str_terminator_option = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION );
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
		 *
		 * The backlinks of combined footnotes are generally preferred in an enumeration.
		 * But when few footnotes are identical, stacking the items in list form is better.
		 * Variable number length and proportional character width require explicit line breaks.
		 * Otherwise, an ordinary space character offering a line break opportunity is inserted.
		 */
		$l_str_line_break = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_BACKLINKS_LINE_BREAKS_ENABLED ) ) ? '<br />' : ' ';

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
	   */
		$l_bool_combine_identical_footnotes = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_COMBINE_IDENTICAL_FOOTNOTES ) );

		// AMP compatibility requires a full set of AMP compatible table row templates.
		if ( Footnotes::$a_bool_amp_enabled ) {

			// When combining identical footnotes is turned on, another template is needed.
			if ( $l_bool_combine_identical_footnotes ) {

				// The combining template allows for backlink clusters and supports cell clicking for single notes.
				$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-reference-container-body-combi' );

			} else {

				// When 3-column layout is turned on (only available if combining is turned off).
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE ) ) ) {
					$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-reference-container-body-3column' );

				} else {

					// When switch symbol and index is turned on, and combining and 3-columns are off.
					if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) ) ) {
						$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-reference-container-body-switch' );

					} else {

						// Default is the standard template.
						$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-reference-container-body' );

					}
				}
			}
		} else {

			// When combining identical footnotes is turned on, another template is needed.
			if ( $l_bool_combine_identical_footnotes ) {

				// The combining template allows for backlink clusters and supports cell clicking for single notes.
				$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'reference-container-body-combi' );

			} else {

				// When 3-column layout is turned on (only available if combining is turned off).
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE ) ) ) {
					$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'reference-container-body-3column' );

				} else {

					// When switch symbol and index is turned on, and combining and 3-columns are off.
					if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) ) ) {
						$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'reference-container-body-switch' );

					} else {

						// Default is the standard template.
						$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'reference-container-body' );

					}
				}
			}
		}

		/**
		 * Switch backlink symbol and footnote number.
		 *
		 * - Bugfix: Reference container: option to append symbol (prepended by default), thanks to @spaceling code contribution.
		 *
		 * @since 2.1.1
		 *
		 * @contributor @spaceling
		 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13615994
		 *
		 *
		 * - Bugfix: Reference container: Backlink symbol: support for appending when combining identicals is on.
		 *
		 * @since 2.1.4
		 */
		$l_bool_symbol_switch = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) );

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
			$l_str_footnote_id = Footnotes_Convert::index( ( $l_int_index + 1 ), Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) );

			/**
			 * Case of only one backlink per table row.
			 *
			 * If enabled, and for the case the footnote is single, compose hard link.
			 */
			// Define anyway.
			$l_str_hard_link_address = '';

			if ( self::$a_bool_hard_links_enabled ) {

				/**
				 * Use-Backbutton-Hint tooltip, optional and configurable.
				 *
				 * - Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
				 *
				 * @reporter @theroninjedi47
				 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
				 *
				 * @since 2.5.4
				 * When hard links are enabled, clicks on the backlinks are logged in the browsing history.
				 * This tooltip hints to use the backbutton instead, so the history gets streamlined again.
				 * @link https://wordpress.org/support/topic/making-it-amp-compatible/#post-13837359
				 */
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE ) ) ) {
					$l_str_use_backbutton_hint  = ' title="';
					$l_str_use_backbutton_hint .= Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT );
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
			 * @reporter @happyches
			 * @link https://wordpress.org/support/topic/custom-css-for-jumbled-references/
			 *
			 * @since 2.1.1
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

			if ( $l_bool_combine_identical_footnotes ) {

				// ID, optional hard link address, and class.
				$l_str_footnote_reference  = '<' . self::$a_str_link_span;
				$l_str_footnote_reference .= ' id="footnote_plugin_reference_';
				$l_str_footnote_reference .= self::$a_int_post_id;
				$l_str_footnote_reference .= '_' . self::$a_int_reference_container_id;
				$l_str_footnote_reference .= "_$l_str_footnote_id\"";
				if ( self::$a_bool_hard_links_enabled ) {
					$l_str_footnote_reference .= ' href="#';
					$l_str_footnote_reference .= self::$a_str_referrer_link_slug;
					$l_str_footnote_reference .= self::$a_str_post_container_id_compound;
					$l_str_footnote_reference .= $l_str_footnote_id . '"';
					$l_str_footnote_reference .= $l_str_use_backbutton_hint;
				}
				$l_str_footnote_reference .= ' class="footnote_backlink"';

				/*
				 * The click event goes in the table cell if footnote remains single.
				 */
				// Reverted wrong linting.
				$l_str_backlink_event = ' onclick="footnote_moveToAnchor_';

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
				if ( self::$a_bool_hard_links_enabled ) {
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
							$l_str_footnote_id = Footnotes_Convert::index( ( $l_int_check_index + 1 ), Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) );

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
							if ( self::$a_bool_hard_links_enabled ) {
								$l_str_footnote_backlinks .= ' href="#';
								$l_str_footnote_backlinks .= self::$a_str_referrer_link_slug;
								$l_str_footnote_backlinks .= self::$a_str_post_container_id_compound;
								$l_str_footnote_backlinks .= $l_str_footnote_id . '"';
								$l_str_footnote_backlinks .= $l_str_use_backbutton_hint;
							}

							$l_str_footnote_backlinks .= ' class="footnote_backlink"';

							// Reverted wrong linting.
							$l_str_footnote_backlinks .= ' onclick="footnote_moveToAnchor_';

							$l_str_footnote_backlinks .= self::$a_int_post_id;
							$l_str_footnote_backlinks .= '_' . self::$a_int_reference_container_id;
							$l_str_footnote_backlinks .= "('footnote_plugin_tooltip_";
							$l_str_footnote_backlinks .= self::$a_int_post_id;
							$l_str_footnote_backlinks .= '_' . self::$a_int_reference_container_id;
							$l_str_footnote_backlinks .= "_$l_str_footnote_id');\">";

							// Append the offset anchor for optional hard links.
							if ( self::$a_bool_hard_links_enabled ) {
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
				self::$a_bool_mirror_tooltip_text = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE ) );
				if ( self::$a_bool_mirror_tooltip_text ) {
					$l_str_tooltip_text              = substr( $l_str_footnote_text, 0, $l_int_tooltip_text_length );
					$l_str_reference_text_introducer = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR );
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
					'note_id'        => Footnotes_Convert::index( $l_int_first_footnote_index, Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE ) ),
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
		self::$a_int_scroll_offset = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET ) );

		// Streamline.
		$l_bool_collapse_default = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE ) );

		/**
		 * Reference container label.
		 *
		 * - Bugfix: Reference container: Label: set empty label to U+202F NNBSP for more robustness, thanks to @lukashuggenberg feedback.
		 *
		 * @reporter @lukashuggenberg
		 *
		 * @since 2.4.0
		 * Themes may drop-cap a first letter of initial paragraphs, like this label.
		 * In case of empty label that would apply to the left half button character.
		 * Hence the point in setting an empty label to U+202F NARROW NO-BREAK SPACE.
		 */
		$l_str_reference_container_label = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME );

		// Select the reference container template.
		// Whether AMP compatibility mode is enabled.
		if ( Footnotes::$a_bool_amp_enabled ) {

			// Whether the reference container is collapsed by default.
			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE ) ) ) {

				// Load 'templates/public/amp-reference-container-collapsed.html'.
				$l_obj_template_container = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-reference-container-collapsed' );

			} else {

				// Load 'templates/public/amp-reference-container.html'.
				$l_obj_template_container = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'amp-reference-container' );
			}
		} elseif ( 'js' === Footnotes::$a_str_script_mode ) {

			// Load 'templates/public/js-reference-container.html'.
			$l_obj_template_container = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'js-reference-container' );

		} else {

			// Load 'templates/public/reference-container.html'.
			$l_obj_template_container = new Footnotes_Template( Footnotes_Template::C_STR_PUBLIC, 'reference-container' );
		}

		$l_int_scroll_offset        = '';
		$l_int_scroll_down_delay    = '';
		$l_int_scroll_down_duration = '';
		$l_int_scroll_up_delay      = '';
		$l_int_scroll_up_duration   = '';

		if ( 'jquery' === Footnotes::$a_str_script_mode ) {

			$l_int_scroll_offset      = ( self::$a_int_scroll_offset / 100 );
			$l_int_scroll_up_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION ) );

			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY ) ) ) {

				$l_int_scroll_down_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DOWN_DURATION ) );

			} else {

				$l_int_scroll_down_duration = $l_int_scroll_up_duration;

			}

			$l_int_scroll_down_delay = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DOWN_DELAY ) );
			$l_int_scroll_up_delay   = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_UP_DELAY ) );

		}

		$l_obj_template_container->replace(
			array(
				'post_id'              => self::$a_int_post_id,
				'container_id'         => self::$a_int_reference_container_id,
				'element'              => Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT ),
				'name'                 => empty( $l_str_reference_container_label ) ? '&#x202F;' : $l_str_reference_container_label,
				'button-style'         => ! $l_bool_collapse_default ? 'display: none;' : '',
				'style'                => $l_bool_collapse_default ? 'display: none;' : '',
				'caption'              => ( empty( $l_str_reference_container_label ) || ' ' === $l_str_reference_container_label ) ? 'References' : $l_str_reference_container_label,
				'content'              => $l_str_body,
				'scroll-offset'        => $l_int_scroll_offset,
				'scroll-down-delay'    => $l_int_scroll_down_delay,
				'scroll-down-duration' => $l_int_scroll_down_duration,
				'scroll-up-delay'      => $l_int_scroll_up_delay,
				'scroll-up-duration'   => $l_int_scroll_up_duration,
			)
		);

		// Free all found footnotes if reference container will be displayed.
		self::$a_arr_footnotes = array();

		return $l_obj_template_container->get_content();
	}
}
