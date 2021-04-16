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
	public static $footnotes = array();

	/**
	 * Flag if the display of 'LOVE FOOTNOTES' is allowed on the current public page.
	 *
	 * @since 1.5.0
	 * @var bool
	 */
	public static $allow_love_me = true;

	/**
	 * Prefix for the Footnote html element ID.
	 *
	 * @since 1.5.8
	 * @var string
	 */
	public static $prefix = '';

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
	public static $post_id = 0;

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
	public static $reference_container_id = 1;

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
	public static $hard_links_enabled = false;

	/**
	 * The referrer slug.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $referrer_link_slug = 'r';

	/**
	 * The footnote slug.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $footnote_link_slug = 'f';

	/**
	 * The slug and identifier separator.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	private static $link_ids_separator = '+';

	/**
	 * Contains the concatenated fragment ID base.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $post_container_id_compound = '';

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
	public static $scroll_offset = 34;

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
	 * @see self::$hard_links_enabled
	 * A property because used both in search() and reference_container().
	 */

	/**
	 * The span element name.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $link_span = 'span';

	/**
	 * The opening tag.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $link_open_tag = '';

	/**
	 * The closing tag.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	public static $link_close_tag = '';

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
	public static $tooltip_shortcode = '[[/tooltip]]';

	/**
	 * The tooltip delimiter shortcode length.
	 *
	 * @since 2.5.2
	 * @var int
	 */
	public static $tooltip_shortcode_length = 12;

	/**
	 * Whether to mirror the tooltip text in the reference container.
	 *
	 * @since 2.5.2
	 * @var bool
	 */
	public static $mirror_tooltip_text = false;

	/**
	 * Footnote delimiter start short code.
	 *
	 * @since 1.5.0 (constant, variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $start_tag = '';

	/**
	 * Footnote delimiter end short code.
	 *
	 * @since 1.5.0 (constant, variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $end_tag = '';

	/**
	 * Footnote delimiter start short code in regex format.
	 *
	 * @since 2.4.0 (variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $start_tag_regex = '';

	/**
	 * Footnote delimiter end short code in regex format.
	 *
	 * @since 2.4.0 (variable)
	 * @since 2.6.2 (property)
	 * @var str
	 */
	public static $end_tag_regex = '';

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
	public static $syntax_error_flag = true;

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
		$the_title_priority    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL ) );
		$the_content_priority  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL ) );
		$the_excerpt_priority  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL ) );
		$widget_title_priority = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL ) );
		$widget_text_priority  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL ) );

		// PHP_INT_MAX can be set by -1.
		$the_title_priority    = ( -1 === $the_title_priority ) ? PHP_INT_MAX : $the_title_priority;
		$the_content_priority  = ( -1 === $the_content_priority ) ? PHP_INT_MAX : $the_content_priority;
		$the_excerpt_priority  = ( -1 === $the_excerpt_priority ) ? PHP_INT_MAX : $the_excerpt_priority;
		$widget_title_priority = ( -1 === $widget_title_priority ) ? PHP_INT_MAX : $widget_title_priority;
		$widget_text_priority  = ( -1 === $widget_text_priority ) ? PHP_INT_MAX : $widget_text_priority;

		// Append custom css to the header.
		add_filter( 'wp_head', array( $this, 'footnotes_output_head' ), PHP_INT_MAX );

		// Append the love and share me slug to the footer.
		add_filter( 'wp_footer', array( $this, 'footnotes_output_footer' ), PHP_INT_MAX );

		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_THE_TITLE ) ) ) {
			add_filter( 'the_title', array( $this, 'footnotes_in_title' ), $the_title_priority );
		}

		// Configurable priority level for reference container relative positioning; default 98.
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_THE_CONTENT ) ) ) {
			add_filter( 'the_content', array( $this, 'footnotes_in_content' ), $the_content_priority );

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
			add_filter( 'term_description', array( $this, 'footnotes_in_content' ), $the_content_priority );

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
			add_filter( 'pum_popup_content', array( $this, 'footnotes_in_content' ), $the_content_priority );
		}

		/**
		 * Adds a filter to the excerpt hook.
		 *
		 * @since 1.5.0  The hook 'get_the_excerpt' is filtered too.
		 * @since 1.5.5  The hook 'get_the_excerpt' is removed but not documented in changelog or docblock.
		 * @since 2.6.2  The hook 'get_the_excerpt' is readded when attempting to debug excerpt handling.
		 * @since 2.6.6  The hook 'get_the_excerpt' is removed again because it seems to cause issues in some themes.
		 */
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_THE_EXCERPT ) ) ) {
			add_filter( 'the_excerpt', array( $this, 'footnotes_in_excerpt' ), $the_excerpt_priority );
		}

		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_WIDGET_TITLE ) ) ) {
			add_filter( 'widget_title', array( $this, 'footnotes_in_widget_title' ), $widget_title_priority );
		}

		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::EXPERT_LOOKUP_WIDGET_TEXT ) ) ) {
			add_filter( 'widget_text', array( $this, 'footnotes_in_widget_text' ), $widget_text_priority );
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
		self::$footnotes      = array();
		self::$allow_love_me = true;
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_CSS_SMOOTH_SCROLLING ) ) ) {
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
		$normalize_superscript = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT );
		if ( 'no' !== $normalize_superscript ) {
			if ( 'all' === $normalize_superscript ) {
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
		if ( ! Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_START_PAGE_ENABLE ) ) ) {

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
		$reference_container_top_margin    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_TOP_MARGIN ) );
		$reference_container_bottom_margin = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_BOTTOM_MARGIN ) );
		echo '.footnotes_reference_container {margin-top: ';
		echo empty( $reference_container_top_margin ) ? '0' : $reference_container_top_margin;
		echo 'px !important; margin-bottom: ';
		echo empty( $reference_container_bottom_margin ) ? '0' : $reference_container_bottom_margin;
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER ) ) ) {
			echo '.footnote_container_prepare > ';
			echo Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_LABEL_ELEMENT );
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_ROW_BORDERS_ENABLE ) ) ) {
			echo '.footnotes_table, .footnotes_plugin_reference_row {';
			echo 'border: 1px solid #060606;';
			echo " !important;}\r\n";
			// Adapt left padding to the presence of a border.
			echo '.footnote_plugin_index, .footnote_plugin_index_combi {';
			echo "padding-left: 6px !important}\r\n";
		}

		// Ref container first column width and max-width.
		$column_width_enabled     = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_COLUMN_WIDTH_ENABLED ) );
		$column_max_width_enabled = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_COLUMN_MAX_WIDTH_ENABLED ) );

		if ( $column_width_enabled || $column_max_width_enabled ) {
			echo '.footnote-reference-container { table-layout: fixed; }';
			echo '.footnote_plugin_index, .footnote_plugin_index_combi {';

			if ( $column_width_enabled ) {
				$column_width_scalar = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_COLUMN_WIDTH_SCALAR );
				$column_width_unit   = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_COLUMN_WIDTH_UNIT );

				if ( ! empty( $column_width_scalar ) ) {
					if ( '%' === $column_width_unit ) {
						if ( $column_width_scalar > 100 ) {
							$column_width_scalar = 100;
						}
					}
				} else {
					$column_width_scalar = 0;
				}

				echo ' width: ' . $column_width_scalar . $column_width_unit . ' !important;';
			}

			if ( $column_max_width_enabled ) {
				$column_max_width_scalar = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_COLUMN_MAX_WIDTH_SCALAR );
				$column_max_width_unit   = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_COLUMN_MAX_WIDTH_UNIT );

				if ( ! empty( $column_max_width_scalar ) ) {
					if ( '%' === $column_max_width_unit ) {
						if ( $column_max_width_scalar > 100 ) {
							$column_max_width_scalar = 100;
						}
					}
				} else {
					$column_max_width_scalar = 0;
				}

				echo ' max-width: ' . $column_max_width_scalar . $column_max_width_unit . ' !important;';

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
		self::$hard_links_enabled = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_HARD_LINKS_ENABLE ) );

		// Correct hard links enabled status depending on AMP compatible or alternative reference container enabled status.
		if ( Footnotes::$amp_enabled || 'jquery' !== Footnotes::$script_mode ) {
			self::$hard_links_enabled = true;
		}

		self::$scroll_offset = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_OFFSET ) );
		if ( self::$hard_links_enabled ) {
			echo '.footnote_referrer_anchor, .footnote_item_anchor {bottom: ';
			echo self::$scroll_offset;
			echo "vh;}\r\n";
		}

		/*
		 * Tooltips.
		 */
		if ( Footnotes::$tooltips_enabled ) {
			echo '.footnote_tooltip {';

			/**
			 * Tooltip appearance: Tooltip font size.
			 *
			 * - Bugfix: Styling: Tooltips: fix font size issue by adding font size to settings with legacy as default.
			 *
			 * @since 2.1.4
			 */
			echo ' font-size: ';
			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FONT_SIZE_ENABLED ) ) ) {
				echo Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FONT_SIZE_SCALAR );
				echo Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FONT_SIZE_UNIT );
			} else {
				echo 'inherit';
			}
			echo ' !important;';

			/*
			 * Tooltip Text color.
			 */
			$color = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_COLOR );
			if ( ! empty( $color ) ) {
				printf( ' color: %s !important;', $color );
			}

			/*
			 * Tooltip Background color.
			 */
			$background = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND );
			if ( ! empty( $background ) ) {
				printf( ' background-color: %s !important;', $background );
			}

			/*
			 * Tooltip Border width.
			 */
			$border_width = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH );
			if ( ! empty( $border_width ) && intval( $border_width ) > 0 ) {
				printf( ' border-width: %dpx !important; border-style: solid !important;', $border_width );
			}

			/*
			 * Tooltip Border color.
			 */
			$border_color = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR );
			if ( ! empty( $border_color ) ) {
				printf( ' border-color: %s !important;', $border_color );
			}

			/*
			 * Tooltip Corner radius.
			 */
			$border_radius = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS );
			if ( ! empty( $border_radius ) && intval( $border_radius ) > 0 ) {
				printf( ' border-radius: %dpx !important;', $border_radius );
			}

			/*
			 * Tooltip Shadow color.
			 */
			$box_shadow_color = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR );
			if ( ! empty( $box_shadow_color ) ) {
				printf( ' -webkit-box-shadow: 2px 2px 11px %s;', $box_shadow_color );
				printf( ' -moz-box-shadow: 2px 2px 11px %s;', $box_shadow_color );
				printf( ' box-shadow: 2px 2px 11px %s;', $box_shadow_color );
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
			if ( ! Footnotes::$alternative_tooltips_enabled && ! Footnotes::$amp_enabled ) {

				/**
				 * Dimensions of jQuery tooltips.
				 *
				 * Position and timing of jQuery tooltips are script defined.
				 *
				 * @see templates/public/tooltip.html.
				 */
				$max_width = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH );
				if ( ! empty( $max_width ) && intval( $max_width ) > 0 ) {
					printf( ' max-width: %dpx !important;', $max_width );
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
				$alternative_tooltip_width = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH ) );
				echo '.footnote_tooltip.position {';
				echo ' width: max-content; ';

				// Set also as max-width wrt short tooltip shrinking.
				echo ' max-width: ' . $alternative_tooltip_width . 'px;';

				/**
				 * Position.
				 *
				 * @see dev-amp-tooltips.css.
				 * @see dev-tooltips-alternative.css.
				 */
				$alternative_position = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION );
				$offset_x             = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X ) );

				if ( 'top left' === $alternative_position || 'bottom left' === $alternative_position ) {
					echo ' right: ' . ( ! empty( $offset_x ) ? $offset_x : 0 ) . 'px;';
				} else {
					echo ' left: ' . ( ! empty( $offset_x ) ? $offset_x : 0 ) . 'px;';
				}

				$offset_y = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y ) );

				if ( 'top left' === $alternative_position || 'top right' === $alternative_position ) {
					echo ' bottom: ' . ( ! empty( $offset_y ) ? $offset_y : 0 ) . 'px;';
				} else {
					echo ' top: ' . ( ! empty( $offset_y ) ? $offset_y : 0 ) . 'px;';
				}
				echo "}\r\n";

				/*
				 * Timing.
				 */
				$fade_in_delay     = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_IN_DELAY ) );
				$fade_in_delay     = ! empty( $fade_in_delay ) ? $fade_in_delay : '0';
				$fade_in_duration  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_IN_DURATION ) );
				$fade_in_duration  = ! empty( $fade_in_duration ) ? $fade_in_duration : '0';
				$fade_out_delay    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_OUT_DELAY ) );
				$fade_out_delay    = ! empty( $fade_out_delay ) ? $fade_out_delay : '0';
				$fade_out_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_OUT_DURATION ) );
				$fade_out_duration = ! empty( $fade_out_duration ) ? $fade_out_duration : '0';

				/**
				 * AMP compatible tooltips.
				 *
				 * To streamline internal CSS, immutable rules are in external stylesheet.
				 *
				 * @see dev-amp-tooltips.css.
				 */
				if ( Footnotes::$amp_enabled ) {

					echo 'span.footnote_referrer > span.footnote_tooltip {';
					echo 'transition-delay: ' . $fade_out_delay . 'ms;';
					echo 'transition-duration: ' . $fade_out_duration . 'ms;';
					echo "}\r\n";

					echo 'span.footnote_referrer:focus-within > span.footnote_tooltip, span.footnote_referrer:hover > span.footnote_tooltip {';
					echo 'transition-delay: ' . $fade_in_delay . 'ms;';
					echo 'transition-duration: ' . $fade_in_duration . 'ms;';
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
					echo 'transition-delay: ' . $fade_out_delay . 'ms;';
					echo 'transition-duration: ' . $fade_out_duration . 'ms;';
					echo "}\r\n";

					echo '.footnote_tooltip.shown {';
					echo 'transition-delay: ' . $fade_in_delay . 'ms;';
					echo 'transition-duration: ' . $fade_in_duration . 'ms;';
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			echo Footnotes_Settings::instance()->get( Footnotes_Settings::CUSTOM_CSS );
			echo "\r\n";
		}
		echo Footnotes_Settings::instance()->get( Footnotes_Settings::CUSTOM_CSS_NEW );

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
		if ( Footnotes::$alternative_tooltips_enabled ) {

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
		if ( 'footer' === Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_POSITION ) ) {
			echo $this->reference_container();
		}
		// Get setting for love and share this plugin.
		$love_me_index = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_LOVE );
		// Check if the admin allows to add a link to the footer.
		if ( empty( $love_me_index ) || 'no' === strtolower( $love_me_index ) || ! self::$allow_love_me ) {
			return;
		}
		// Set a hyperlink to the word "footnotes" in the Love slug.
		$linked_name = sprintf( '<a href="https://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">%s</a>', Footnotes_Config::PLUGIN_PUBLIC_NAME );
		// Get random love me text.
		if ( 'random' === strtolower( $love_me_index ) ) {
			$love_me_index = 'text-' . wp_rand( 1, 7 );
		}
		switch ( $love_me_index ) {
			// Options named wrt backcompat, simplest is default.
			case 'text-1':
				/* Translators: 2: Link to plugin page 1: Love heart symbol */
				$love_me_text = sprintf( __( 'I %2$s %1$s', 'footnotes' ), $linked_name, Footnotes_Config::LOVE_SYMBOL );
				break;
			case 'text-2':
				/* Translators: %s: Link to plugin page */
				$love_me_text = sprintf( __( 'This website uses the awesome %s plugin.', 'footnotes' ), $linked_name );
				break;
			case 'text-4':
				/* Translators: 1: Link to plugin page 2: Love heart symbol */
				$love_me_text = sprintf( '%1$s %2$s', $linked_name, Footnotes_Config::LOVE_SYMBOL );
				break;
			case 'text-5':
				/* Translators: 1: Love heart symbol 2: Link to plugin page */
				$love_me_text = sprintf( '%1$s %2$s', Footnotes_Config::LOVE_SYMBOL, $linked_name );
				break;
			case 'text-6':
				/* Translators: %s: Link to plugin page */
				$love_me_text = sprintf( __( 'This website uses %s.', 'footnotes' ), $linked_name );
				break;
			case 'text-7':
				/* Translators: %s: Link to plugin page */
				$love_me_text = sprintf( __( 'This website uses the %s plugin.', 'footnotes' ), $linked_name );
				break;
			case 'text-3':
			default:
				/* Translators: %s: Link to plugin page */
				$love_me_text = sprintf( '%s', $linked_name );
				break;
		}
		echo sprintf( '<div style="text-align:center; color:#acacac;">%s</div>', $love_me_text );
	}

	/**
	 * Replaces footnotes in the post/page title.
	 *
	 * @since 1.5.0
	 * @param string $content  Title.
	 * @return string $content  Title with replaced footnotes.
	 */
	public function footnotes_in_title( $content ) {
		// Appends the reference container if set to "post_end".
		return $this->exec( $content, false );
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
	 * @param string $content  Page/Post content.
	 * @return string $content  Content with replaced footnotes.
	 */
	public function footnotes_in_content( $content ) {

		$ref_container_position            = Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_POSITION );
		$footnote_section_shortcode        = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTE_SECTION_SHORTCODE );
		$footnote_section_shortcode_length = strlen( $footnote_section_shortcode );

		if ( strpos( $content, $footnote_section_shortcode ) === false ) {

			// phpcs:disable WordPress.PHP.YodaConditions.NotYoda
			// Appends the reference container if set to "post_end".
			return $this->exec( $content, 'post_end' === $ref_container_position );
			// phpcs:enable WordPress.PHP.YodaConditions.NotYoda

		} else {

			$rest_content       = $content;
			$sections_raw       = array();
			$sections_processed = array();

			do {
				$section_end    = strpos( $rest_content, $footnote_section_shortcode );
				$sections_raw[] = substr( $rest_content, 0, $section_end );
				$rest_content   = substr( $rest_content, $section_end + $footnote_section_shortcode_length );
			} while ( strpos( $rest_content, $footnote_section_shortcode ) !== false );
			$sections_raw[] = $rest_content;

			foreach ( $sections_raw as $section ) {
				$sections_processed[] = self::exec( $section, true );
			}

			$content = implode( $sections_processed );
			return $content;

		}
	}

	/**
	 * Processes existing excerpt or replaces it with a new one generated on the basis of the post.
	 *
	 * @since 1.5.0
	 * @param string $excerpt  Excerpt content.
	 * @return string $excerpt  Processed or new excerpt.
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
	public function footnotes_in_excerpt( $excerpt ) {
		$excerpt_mode = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_IN_EXCERPT );

		if ( 'yes' === $excerpt_mode ) {
			return $this->generate_excerpt_with_footnotes( $excerpt );

		} elseif ( 'no' === $excerpt_mode ) {
			return $this->generate_excerpt( $excerpt );

		} else {
			return $this->exec( $excerpt );
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
	 * @param string $content  The post.
	 * @return string $content  An excerpt of the post.
	 * Applies full WordPress excerpt processing.
	 * @link https://developer.wordpress.org/reference/functions/wp_trim_excerpt/
	 * @link https://developer.wordpress.org/reference/functions/wp_trim_words/
	 */
	public function generate_excerpt( $content ) {

		// Discard existing excerpt and start on the basis of the post.
		$content = get_the_content( get_the_id() );

		// Get footnote delimiter shortcodes and unify them.
		$content = self::unify_delimiters( $content );

		// Remove footnotes.
		$content = preg_replace( '#' . self::$start_tag_regex . '.+?' . self::$end_tag_regex . '#', '', $content );

		// Apply WordPress excerpt processing.
		$content = strip_shortcodes( $content );
		$content = excerpt_remove_blocks( $content );

		// Here the footnotes would be processed as part of WordPress content processing.
		$content = apply_filters( 'the_content', $content );

		// According to Advanced Excerpt, this is some kind of precaution against malformed CDATA in RSS feeds.
		$content = str_replace( ']]>', ']]&gt;', $content );

		$excerpt_length = (int) _x( '55', 'excerpt_length' );
		$excerpt_length = (int) apply_filters( 'excerpt_length', $excerpt_length );
		$excerpt_more   = apply_filters( 'excerpt_more', ' [&hellip;]' );

		// Function wp_trim_words() calls wp_strip_all_tags() that wrecks the footnotes.
		$content = wp_trim_words( $content, $excerpt_length, $excerpt_more );

		return $content;
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
	 * @param string $content  The post.
	 * @return string $content  An excerpt of the post.
	 * Does not apply full WordPress excerpt processing.
	 * @see self::generate_excerpt()
	 * Uses information and some code from Advanced Excerpt.
	 * @link https://wordpress.org/plugins/advanced-excerpt/
	 */
	public function generate_excerpt_with_footnotes( $content ) {

		// Discard existing excerpt and start on the basis of the post.
		$content = get_the_content( get_the_id() );

		// Get footnote delimiter shortcodes and unify them.
		$content = self::unify_delimiters( $content );

		// Apply WordPress excerpt processing.
		$content = strip_shortcodes( $content );
		$content = excerpt_remove_blocks( $content );

		// But do not process footnotes at this point; do only this.
		$content = str_replace( ']]>', ']]&gt;', $content );

		// Prepare the excerpt length argument.
		$excerpt_length = (int) _x( '55', 'excerpt_length' );
		$excerpt_length = (int) apply_filters( 'excerpt_length', $excerpt_length );

		// Prepare the Read-on string.
		$excerpt_more = apply_filters( 'excerpt_more', ' [&hellip;]' );

		// Safeguard the footnotes.
		preg_match_all(
			'#' . self::$start_tag_regex . '.+?' . self::$end_tag_regex . '#',
			$content,
			$saved_footnotes
		);

		// Prevent the footnotes from altering the excerpt: previously hard-coded '5ED84D6'.
		$placeholder = '@' . mt_rand( 100000000, 2147483647 ) . '@';
		$content     = preg_replace(
			'#' . self::$start_tag_regex . '.+?' . self::$end_tag_regex . '#',
			$placeholder,
			$content
		);

		// Replace line breaking markup with a separator.
		$separator = ' ';
		$content   = preg_replace( '#<br *>#', $separator, $content );
		$content   = preg_replace( '#<br */>#', $separator, $content );
		$content   = preg_replace( '#<(p|li|div)[^>]*>#', $separator, $content );
		$content   = preg_replace( '#' . $separator . '#', '', $content, 1 );
		$content   = preg_replace( '#</(p|li|div) *>#', '', $content );
		$content   = preg_replace( '#[\r\n]#', '', $content );

		// To count words like Advanced Excerpt does it.
		$tokens  = array();
		$output  = '';
		$counter = 0;

		// Tokenize into tags and words as in Advanced Excerpt.
		preg_match_all( '#(<[^>]+>|[^<>\s]+)\s*#u', $content, $tokens );

		// Count words following one option of Advanced Excerpt.
		foreach ( $tokens[0] as $token ) {

			if ( $counter >= $excerpt_length ) {
				break;
			}
			// If token is not a tag, increment word count.
			if ( '<' !== $token[0] ) {
				$counter++;
			}
			// Append the token to the output.
			$output .= $token;
		}

		// Complete unbalanced markup, used by Advanced Excerpt.
		$content = force_balance_tags( $output );

		// Readd footnotes in excerpt.
		$index = 0;
		while ( 0 !== preg_match( '#' . $placeholder . '#', $content ) ) {
			$content = preg_replace(
				'#' . $placeholder . '#',
				$saved_footnotes[0][ $index ],
				$content,
				1
			);
			$index++;
		}

		// Append the Read-on string as in wp_trim_words().
		$content .= $excerpt_more;

		// Process readded footnotes without appending the reference container.
		$content = self::exec( $content, false );

		return $content;

	}

	/**
	 * Replaces footnotes in the widget title.
	 *
	 * @since 1.5.0
	 * @param string $content  Widget content.
	 * @return string $content  Content with replaced footnotes.
	 */
	public function footnotes_in_widget_title( $content ) {
		// Appends the reference container if set to "post_end".
		return $this->exec( $content, false );
	}

	/**
	 * Replaces footnotes in the content of the current widget.
	 *
	 * @since 1.5.0
	 * @param string $content  Widget content.
	 * @return string $content  Content with replaced footnotes.
	 */
	public function footnotes_in_widget_text( $content ) {
		// phpcs:disable WordPress.PHP.YodaConditions.NotYoda
		// Appends the reference container if set to "post_end".
		return $this->exec( $content, 'post_end' === Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_POSITION ) ? true : false );
		// phpcs:enable WordPress.PHP.YodaConditions.NotYoda
	}

	/**
	 * Replaces all footnotes that occur in the given content.
	 *
	 * @since 1.5.0
	 * @param string $content              Any string that may contain footnotes to be replaced.
	 * @param bool   $output_references   Appends the Reference Container to the output if set to true, default true.
	 * @param bool   $hide_footnotes_text Hide footnotes found in the string.
	 * @return string
	 */
	public function exec( $content, $output_references = false, $hide_footnotes_text = false ) {

		// Process content.
		$content = $this->search( $content, $hide_footnotes_text );

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
		$reference_container_position_shortcode = Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_POSITION_SHORTCODE );
		if ( empty( $reference_container_position_shortcode ) ) {
			$reference_container_position_shortcode = '[[references]]';
		}

		if ( $output_references ) {

			if ( strpos( $content, $reference_container_position_shortcode ) ) {

				$content = str_replace( $reference_container_position_shortcode, $this->reference_container(), $content );

			} else {

				$content .= $this->reference_container();

			}

			// Increment the container ID.
			self::$reference_container_id++;
		}

		// Delete position shortcode should any remain.
		$content = str_replace( $reference_container_position_shortcode, '', $content );

		// Take a look if the LOVE ME slug should NOT be displayed on this page/post, remove the short code if found.
		if ( strpos( $content, Footnotes_Config::NO_LOVE_SLUG ) ) {
			self::$allow_love_me = false;
			$content              = str_replace( Footnotes_Config::NO_LOVE_SLUG, '', $content );
		}
		// Return the content with replaced footnotes and optional reference container appended.
		return $content;
	}

	/**
	 * Brings the delimiters and unifies their various HTML escapement schemas.
	 *
	 * @param string $content TODO.
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
	public function unify_delimiters( $content ) {

		// Get footnotes start and end tag short codes.
		$starting_tag = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SHORT_CODE_START );
		$ending_tag   = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SHORT_CODE_END );
		if ( 'userdefined' === $starting_tag || 'userdefined' === $ending_tag ) {
			$starting_tag = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$ending_tag   = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}

		// If any footnotes short code is empty, return the content without changes.
		if ( empty( $starting_tag ) || empty( $ending_tag ) ) {
			return $content;
		}

		if ( preg_match( '#[&"\'<>]#', $starting_tag . $ending_tag ) ) {

			$harmonized_start_tag = '{[(|fnote_stt|)]}';
			$harmonized_end_tag   = '{[(|fnote_end|)]}';

			// Harmonize footnotes without escaping any HTML special characters in delimiter shortcodes.
			// The footnote has been added in the Block Editor code editor (doesn’t work in Classic Editor text mode).
			$content = str_replace( $starting_tag, $harmonized_start_tag, $content );
			$content = str_replace( $ending_tag, $harmonized_end_tag, $content );

			// Harmonize footnotes while escaping HTML special characters in delimiter shortcodes.
			// The footnote has been added in the Classic Editor visual mode.
			$content = str_replace( htmlspecialchars( $starting_tag ), $harmonized_start_tag, $content );
			$content = str_replace( htmlspecialchars( $ending_tag ), $harmonized_end_tag, $content );

			// Harmonize footnotes while escaping HTML special characters except greater-than sign in delimiter shortcodes.
			// The footnote has been added in the Block Editor visual mode.
			$content = str_replace( str_replace( '&gt;', '>', htmlspecialchars( $starting_tag ) ), $harmonized_start_tag, $content );
			$content = str_replace( str_replace( '&gt;', '>', htmlspecialchars( $ending_tag ) ), $harmonized_end_tag, $content );

			// Assign the delimiter shortcodes.
			self::$start_tag = $harmonized_start_tag;
			self::$end_tag   = $harmonized_end_tag;

			// Assign the regex-conformant shortcodes.
			self::$start_tag_regex = '\{\[\(\|fnote_stt\|\)\]\}';
			self::$end_tag_regex   = '\{\[\(\|fnote_end\|\)\]\}';

		} else {

			// Assign the delimiter shortcodes.
			self::$start_tag = $starting_tag;
			self::$end_tag   = $ending_tag;

			// Make shortcodes conform to regex syntax.
			self::$start_tag_regex = preg_replace( '#([\(\)\{\}\[\]\|\*\.\?\!])#', '\\\\$1', self::$start_tag );
			self::$end_tag_regex   = preg_replace( '#([\(\)\{\}\[\]\|\*\.\?\!])#', '\\\\$1', self::$end_tag );
		}

		return $content;
	}

	/**
	 * Replaces all footnotes in the given content and appends them to the static property.
	 *
	 * @since 1.5.0
	 * @param string $content              Any content to be searched for footnotes.
	 * @param bool   $hide_footnotes_text Hide footnotes found in the string.
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
	public function search( $content, $hide_footnotes_text ) {

		// Get footnote delimiter shortcodes and unify them.
		$content = self::unify_delimiters( $content );

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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE ) ) ) {

			// Apply different regex depending on whether start shortcode is double/triple opening parenthesis.
			if ( '((' === self::$start_tag || '(((' === self::$start_tag ) {

				// This prevents from catching a script containing e.g. a double opening parenthesis.
				$validation_regex = '#' . self::$start_tag_regex . '(((?!' . self::$end_tag_regex . ')[^\{\}])*?)(' . self::$start_tag_regex . '|$)#s';

			} else {

				// Catch all only if the start shortcode is not double/triple opening parenthesis, i.e. is unlikely to occur in scripts.
				$validation_regex = '#' . self::$start_tag_regex . '(((?!' . self::$end_tag_regex . ').)*?)(' . self::$start_tag_regex . '|$)#s';
			}

			// Check syntax and get error locations.
			preg_match( $validation_regex, $content, $error_location );
			if ( empty( $error_location ) ) {
				self::$syntax_error_flag = false;
			}

			// Prevent generating and inserting the warning multiple times.
			if ( self::$syntax_error_flag ) {

				// Get plain text string for error location.
				$error_spot_string = wp_strip_all_tags( $error_location[1] );

				// Limit string length to 300 characters.
				if ( strlen( $error_spot_string ) > 300 ) {
					$error_spot_string = substr( $error_spot_string, 0, 299 ) . '…';
				}

				// Compose warning box.
				$syntax_error_warning  = '<div class="footnotes_validation_error"><p>';
				$syntax_error_warning .= __( 'WARNING: unbalanced footnote start tag short code found.', 'footnotes' );
				$syntax_error_warning .= '</p><p>';

				// Syntax validation setting in the dashboard under the General settings tab.
				/* Translators: 1: General Settings 2: Footnote start and end short codes 3: Check for balanced shortcodes */
				$syntax_error_warning .= sprintf( __( 'If this warning is irrelevant, please disable the syntax validation feature in the dashboard under %1$s &gt; %2$s &gt; %3$s.', 'footnotes' ), __( 'General settings', 'footnotes' ), __( 'Footnote start and end short codes', 'footnotes' ), __( 'Check for balanced shortcodes', 'footnotes' ) );

				$syntax_error_warning .= '</p><p>';
				$syntax_error_warning .= __( 'Unbalanced start tag short code found before:', 'footnotes' );
				$syntax_error_warning .= '</p><p>“';
				$syntax_error_warning .= $error_spot_string;
				$syntax_error_warning .= '”</p></div>';

				// Prepend the warning box to the content.
				$content = $syntax_error_warning . $content;

				// Checked, set flag to false to prevent duplicate warning.
				self::$syntax_error_flag = false;

				return $content;
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
		$value_regex = '#(<input [^>]+?value=["\'][^>]+?)' . self::$start_tag_regex . '[^>]+?' . self::$end_tag_regex . '#';

		do {
			$content = preg_replace( $value_regex, '$1', $content );
		} while ( preg_match( $value_regex, $content ) );

		/**
		 * Optionally moves footnotes outside at the end of the label element.
		 *
		 * - Bugfix: Forms: prevent inadvertently toggling input elements with footnotes in their label, by optionally moving footnotes after the end of the label.
		 *
		 * @since 2.5.12
		 * @link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14212318
		 */
		$label_issue_solution = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_LABEL_ISSUE_SOLUTION );

		if ( 'move' === $label_issue_solution ) {

			$move_regex = '#(<label ((?!</label).)+?)(' . self::$start_tag_regex . '((?!</label).)+?' . self::$end_tag_regex . ')(((?!</label).)*?</label>)#';

			do {
				$content = preg_replace( $move_regex, '$1$5<span class="moved_footnote">$3</span>', $content );
			} while ( preg_match( $move_regex, $content ) );
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
		if ( 'disconnect' === $label_issue_solution ) {

			$disconnect_text = 'optionally-disconnected-from-input-field-to-prevent-toggling-while-clicking-footnote-referrer_';

			$content = preg_replace(
				'#(<label [^>]+?for=["\'])(((?!</label).)+' . self::$start_tag_regex . ')#',
				'$1' . $disconnect_text . '$2',
				$content
			);
		}

		// Post ID to make everything unique wrt infinite scroll and archive view.
		self::$post_id = get_the_id();

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
		self::$footnotes = array();

		// Resets the footnote number.
		$footnote_index = 1;

		// Contains the starting position for the lookup of a footnote.
		$pos_start = 0;

		/*
		 * Load footnote referrer template file.
		 */

		// Set to null in case all templates are unnecessary.
		$template         = null;
		$template_tooltip = null;

		// On the condition that the footnote text is not hidden.
		if ( ! $hide_footnotes_text ) {

			// Whether AMP compatibility mode is enabled.
			if ( Footnotes::$amp_enabled ) {

				// Whether first clicking a referrer needs to expand the reference container.
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_COLLAPSE ) ) ) {

					// Load 'templates/public/amp-footnote-expand.html'.
					$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-footnote-expand' );

				} else {

					// Load 'templates/public/amp-footnote.html'.
					$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-footnote' );
				}
			} elseif ( Footnotes::$alternative_tooltips_enabled ) {

				// Load 'templates/public/footnote-alternative.html'.
				$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'footnote-alternative' );

				// Else jQuery tooltips are enabled.
			} else {

				// Load 'templates/public/footnote.html'.
				$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'footnote' );

				// Load tooltip inline script.
				$template_tooltip = new Footnotes_Template( Footnotes_Template::PUBLIC, 'tooltip' );
			}
		}

		// Search footnotes short codes in the content.
		do {
			// Get first occurrence of the footnote start tag short code.
			$i_int_len_content = strlen( $content );
			if ( $pos_start > $i_int_len_content ) {
				$pos_start = $i_int_len_content;
			}
			$pos_start = strpos( $content, self::$start_tag, $pos_start );
			// No short code found, stop here.
			if ( ! $pos_start ) {
				break;
			}
			// Get first occurrence of the footnote end tag short code.
			$pos_end = strpos( $content, self::$end_tag, $pos_start );
			// No short code found, stop here.
			if ( ! $pos_end ) {
				break;
			}
			// Calculate the length of the footnote.
			$length = $pos_end - $pos_start;

			// Get footnote text.
			$footnote_text = substr( $content, $pos_start + strlen( self::$start_tag ), $length - strlen( self::$start_tag ) );

			// Get tooltip text if present.
			self::$tooltip_shortcode        = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER );
			self::$tooltip_shortcode_length = strlen( self::$tooltip_shortcode );
			$tooltip_text_length            = strpos( $footnote_text, self::$tooltip_shortcode );
			$has_tooltip_text              = ! $tooltip_text_length ? false : true;
			if ( $has_tooltip_text ) {
				$tooltip_text = substr( $footnote_text, 0, $tooltip_text_length );
			} else {
				$tooltip_text = '';
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
			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTE_URL_WRAP_ENABLED ) ) ) {

				$footnote_text = preg_replace(
					'#(?<![-\w\.!~\*\'\(\);]=[\'"])(?<![-\w\.!~\*\'\(\);]=[\'"] )(?<![-\w\.!~\*\'\(\);]=[\'"]  )(?<![-\w\.!~\*\'\(\);]=)(?<!/)((ht|f)tps?://[^\\s<]+)#',
					'<span class="footnote_url_wrap">$1</span>',
					$footnote_text
				);
			}

			// Text to be displayed instead of the footnote.
			$footnote_replace_text = '';

			// Whether hard links are enabled.
			if ( self::$hard_links_enabled ) {

				// Get the configurable parts.
				self::$referrer_link_slug = Footnotes_Settings::instance()->get( Footnotes_Settings::REFERRER_FRAGMENT_ID_SLUG );
				self::$footnote_link_slug = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTE_FRAGMENT_ID_SLUG );
				self::$link_ids_separator = Footnotes_Settings::instance()->get( Footnotes_Settings::HARD_LINK_IDS_SEPARATOR );

				// Streamline ID concatenation.
				self::$post_container_id_compound  = self::$link_ids_separator;
				self::$post_container_id_compound .= self::$post_id;
				self::$post_container_id_compound .= self::$link_ids_separator;
				self::$post_container_id_compound .= self::$reference_container_id;
				self::$post_container_id_compound .= self::$link_ids_separator;

			}

			// Display the footnote referrers and the tooltips.
			if ( ! $hide_footnotes_text ) {
				$index = Footnotes_Convert::index( $footnote_index, Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_COUNTER_STYLE ) );

				// Display only a truncated footnote text if option enabled.
				$enable_excerpt = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED ) );
				$max_length      = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH ) );

				// Define excerpt text as footnote text by default.
				$excerpt_text = $footnote_text;

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
				if ( Footnotes::$tooltips_enabled && $enable_excerpt ) {
					$dummy_text = wp_strip_all_tags( $footnote_text );
					if ( is_int( $max_length ) && strlen( $dummy_text ) > $max_length ) {
						$excerpt_text  = substr( $dummy_text, 0, $max_length );
						$excerpt_text  = substr( $excerpt_text, 0, strrpos( $excerpt_text, ' ' ) );
						$excerpt_text .= '&nbsp;&#x2026; <';
						$excerpt_text .= self::$hard_links_enabled ? 'a' : 'span';
						$excerpt_text .= ' class="footnote_tooltip_continue" ';

						// If AMP compatibility mode is enabled.
						if ( Footnotes::$amp_enabled ) {

							// If the reference container is also collapsed by default.
							if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_COLLAPSE ) ) ) {

								$excerpt_text .= ' on="tap:footnote_references_container_';
								$excerpt_text .= self::$post_id . '_' . self::$reference_container_id;
								$excerpt_text .= '.toggleClass(class=collapsed, force=false),footnotes_container_button_plus_';
								$excerpt_text .= self::$post_id . '_' . self::$reference_container_id;
								$excerpt_text .= '.toggleClass(class=collapsed, force=true),footnotes_container_button_minus_';
								$excerpt_text .= self::$post_id . '_' . self::$reference_container_id;
								$excerpt_text .= '.toggleClass(class=collapsed, force=false)"';
							}
						} else {

							// Don’t add onclick event in AMP compatibility mode.
							// Reverted wrong linting.
							$excerpt_text .= ' onclick="footnote_moveToReference_' . self::$post_id;
							$excerpt_text .= '_' . self::$reference_container_id;
							$excerpt_text .= '(\'footnote_plugin_reference_' . self::$post_id;
							$excerpt_text .= '_' . self::$reference_container_id;
							$excerpt_text .= "_$index');\"";
						}

						// If enabled, add the hard link fragment ID.
						if ( self::$hard_links_enabled ) {

							$excerpt_text .= ' href="#';
							$excerpt_text .= self::$footnote_link_slug;
							$excerpt_text .= self::$post_container_id_compound;
							$excerpt_text .= $index;
							$excerpt_text .= '"';
						}

						$excerpt_text .= '>';

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
						$excerpt_text .= Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_TOOLTIP_READON_LABEL );

						$excerpt_text .= self::$hard_links_enabled ? '</a>' : '</span>';
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
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS ) ) ) {

					$sup_span = 'sup';

				} else {

					$sup_span = 'span';
				}

				// Whether hard links are enabled.
				if ( self::$hard_links_enabled ) {

					self::$link_span      = 'a';
					self::$link_close_tag = '</a>';
					// Self::$link_open_tag will be defined as needed.

					// Compose hyperlink address (leading space is in template).
					$footnote_link_argument  = 'href="#';
					$footnote_link_argument .= self::$footnote_link_slug;
					$footnote_link_argument .= self::$post_container_id_compound;
					$footnote_link_argument .= $index;
					$footnote_link_argument .= '" class="footnote_hard_link"';

					/**
					 * Compose fragment ID anchor with offset, for use in reference container.
					 * Empty span, child of empty span, to avoid tall dotted rectangles in browser.
					 */
					$referrer_anchor_element  = '<span class="footnote_referrer_base"><span id="';
					$referrer_anchor_element .= self::$referrer_link_slug;
					$referrer_anchor_element .= self::$post_container_id_compound;
					$referrer_anchor_element .= $index;
					$referrer_anchor_element .= '" class="footnote_referrer_anchor"></span></span>';

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
					$footnote_link_argument  = '';
					$referrer_anchor_element = '';

					// The link element is set independently as it may be needed for styling.
					if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::LINK_ELEMENT_ENABLED ) ) ) {

						self::$link_span      = 'a';
						self::$link_open_tag  = '<a>';
						self::$link_close_tag = '</a>';

					}
				}

				// Determine tooltip content.
				if ( Footnotes::$tooltips_enabled ) {
					$tooltip_content = $has_tooltip_text ? $tooltip_text : $excerpt_text;
				} else {
					$tooltip_content = '';
				}

				/**
				 * Determine shrink width if alternative tooltips are enabled.
				 *
				 * @since 2.5.6
				 */
				$tooltip_style = '';
				if ( Footnotes::$alternative_tooltips_enabled && Footnotes::$tooltips_enabled ) {
					$tooltip_length = strlen( wp_strip_all_tags( $tooltip_content ) );
					if ( $tooltip_length < 70 ) {
						$tooltip_style  = ' style="width: ';
						$tooltip_style .= ( $tooltip_length * .7 );
						$tooltip_style .= 'em;"';
					}
				}

				// Fill in 'templates/public/footnote.html'.
				$template->replace(
					array(
						'link-span'      => self::$link_span,
						'post_id'        => self::$post_id,
						'container_id'   => self::$reference_container_id,
						'note_id'        => $index,
						'hard-link'      => $footnote_link_argument,
						'sup-span'       => $sup_span,
						'before'         => Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_STYLING_BEFORE ),
						'index'          => $index,
						'after'          => Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_STYLING_AFTER ),
						'anchor-element' => $referrer_anchor_element,
						'style'          => $tooltip_style,
						'text'           => $tooltip_content,
					)
				);
				$footnote_replace_text = $template->get_content();

				// Reset the template.
				$template->reload();

				// If tooltips are enabled but neither AMP nor alternative are.
				if ( Footnotes::$tooltips_enabled && ! Footnotes::$amp_enabled && ! Footnotes::$alternative_tooltips_enabled ) {

					$offset_y          = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y ) );
					$offset_x          = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X ) );
					$fade_in_delay     = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_IN_DELAY ) );
					$fade_in_duration  = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_IN_DURATION ) );
					$fade_out_delay    = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_OUT_DELAY ) );
					$fade_out_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::MOUSE_OVER_BOX_FADE_OUT_DURATION ) );

					// Fill in 'templates/public/tooltip.html'.
					$template_tooltip->replace(
						array(
							'post_id'           => self::$post_id,
							'container_id'      => self::$reference_container_id,
							'note_id'           => $index,
							'position'          => Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_MOUSE_OVER_BOX_POSITION ),
							'offset-y'          => ! empty( $offset_y ) ? $offset_y : 0,
							'offset-x'          => ! empty( $offset_x ) ? $offset_x : 0,
							'fade-in-delay'     => ! empty( $fade_in_delay ) ? $fade_in_delay : 0,
							'fade-in-duration'  => ! empty( $fade_in_duration ) ? $fade_in_duration : 0,
							'fade-out-delay'    => ! empty( $fade_out_delay ) ? $fade_out_delay : 0,
							'fade-out-duration' => ! empty( $fade_out_duration ) ? $fade_out_duration : 0,
						)
					);
					$footnote_replace_text .= $template_tooltip->get_content();
					$template_tooltip->reload();
				}
			}
			// Replace the footnote with the template.
			$content = substr_replace( $content, $footnote_replace_text, $pos_start, $length + strlen( self::$end_tag ) );

			// Add footnote only if not empty.
			if ( ! empty( $footnote_text ) ) {
				// Set footnote to the output box at the end.
				self::$footnotes[] = $footnote_text;
				// Increase footnote index.
				$footnote_index++;
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
			$pos_start += strlen( $footnote_replace_text );

		} while ( true );

		// Return content.
		return $content;
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
		if ( empty( self::$footnotes ) ) {
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE ) ) ) {

			// Get html arrow.
			$arrow = Footnotes_Convert::get_arrow( Footnotes_Settings::instance()->get( Footnotes_Settings::HYPERLINK_ARROW ) );
			// Set html arrow to the first one if invalid index defined.
			if ( is_array( $arrow ) ) {
				$arrow = Footnotes_Convert::get_arrow( 0 );
			}
			// Get user defined arrow.
			$arrow_user_defined = Footnotes_Settings::instance()->get( Footnotes_Settings::HYPERLINK_ARROW_USER_DEFINED );
			if ( ! empty( $arrow_user_defined ) ) {
				$arrow = $arrow_user_defined;
			}

			// Wrap the arrow in a @media print { display:hidden } span.
			$footnote_arrow  = '<span class="footnote_index_arrow">';
			$footnote_arrow .= $arrow . '</span>';

		} else {

			// If the backlink symbol isn’t enabled, set it to empty.
			$arrow          = '';
			$footnote_arrow = '';

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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_SEPARATOR_ENABLED ) ) ) {

			// Check if it is input-configured.
			$separator = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_SEPARATOR_CUSTOM );

			if ( empty( $separator ) ) {

				// If it is not, check which option is on.
				$separator_option = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_SEPARATOR_OPTION );
				switch ( $separator_option ) {
					case 'comma':
						$separator = ',';
						break;
					case 'semicolon':
						$separator = ';';
						break;
					case 'en_dash':
						$separator = '&nbsp;&#x2013;';
						break;
				}
			}
		} else {

			$separator = '';
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
		if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_TERMINATOR_ENABLED ) ) ) {

			// Check if it is input-configured.
			$terminator = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_TERMINATOR_CUSTOM );

			if ( empty( $terminator ) ) {

				// If it is not, check which option is on.
				$terminator_option = Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_TERMINATOR_OPTION );
				switch ( $terminator_option ) {
					case 'period':
						$terminator = '.';
						break;
					case 'parenthesis':
						$terminator = ')';
						break;
					case 'colon':
						$terminator = ':';
						break;
				}
			}
		} else {

			$terminator = '';
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
		$line_break = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::BACKLINKS_LINE_BREAKS_ENABLED ) ) ? '<br />' : ' ';

		/**
		 * Line breaks for source readability.
		 *
		 * For maintenance and support, table rows in the reference container should be
		 * separated by an empty line. So we add these line breaks for source readability.
		 * Before the first table row (breaks between rows are ~200 lines below).
		 */
		$body = "\r\n\r\n";

		/**
		 * Reference container table row template load.
		 *
		 * - Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
		 *
		 * @since 2.1.1
	   */
		$combine_identical_footnotes = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::COMBINE_IDENTICAL_FOOTNOTES ) );

		// AMP compatibility requires a full set of AMP compatible table row templates.
		if ( Footnotes::$amp_enabled ) {

			// When combining identical footnotes is turned on, another template is needed.
			if ( $combine_identical_footnotes ) {

				// The combining template allows for backlink clusters and supports cell clicking for single notes.
				$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-reference-container-body-combi' );

			} else {

				// When 3-column layout is turned on (only available if combining is turned off).
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE ) ) ) {
					$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-reference-container-body-3column' );

				} else {

					// When switch symbol and index is turned on, and combining and 3-columns are off.
					if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) ) ) {
						$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-reference-container-body-switch' );

					} else {

						// Default is the standard template.
						$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-reference-container-body' );

					}
				}
			}
		} else {

			// When combining identical footnotes is turned on, another template is needed.
			if ( $combine_identical_footnotes ) {

				// The combining template allows for backlink clusters and supports cell clicking for single notes.
				$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'reference-container-body-combi' );

			} else {

				// When 3-column layout is turned on (only available if combining is turned off).
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE ) ) ) {
					$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'reference-container-body-3column' );

				} else {

					// When switch symbol and index is turned on, and combining and 3-columns are off.
					if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) ) ) {
						$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'reference-container-body-switch' );

					} else {

						// Default is the standard template.
						$template = new Footnotes_Template( Footnotes_Template::PUBLIC, 'reference-container-body' );

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
		$symbol_switch = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH ) );

		// Loop through all footnotes found in the page.
		$num_footnotes = count( self::$footnotes );
		for ( $index = 0; $index < $num_footnotes; $index++ ) {

			// Get footnote text.
			$footnote_text = self::$footnotes[ $index ];

			// If footnote is empty, go to the next one;.
			// With combine identicals turned on, identicals will be deleted and are skipped.
			if ( empty( $footnote_text ) ) {
				continue;
			}

			// Generate content of footnote index cell.
			$first_footnote_index = ( $index + 1 );

			// Get the footnote index string and.
			// Keep supporting legacy index placeholder.
			$footnote_id = Footnotes_Convert::index( ( $index + 1 ), Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_COUNTER_STYLE ) );

			/**
			 * Case of only one backlink per table row.
			 *
			 * If enabled, and for the case the footnote is single, compose hard link.
			 */
			// Define anyway.
			$hard_link_address = '';

			if ( self::$hard_links_enabled ) {

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
				if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_BACKLINK_TOOLTIP_ENABLE ) ) ) {
					$use_backbutton_hint  = ' title="';
					$use_backbutton_hint .= Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_BACKLINK_TOOLTIP_TEXT );
					$use_backbutton_hint .= '"';
				} else {
					$use_backbutton_hint = '';
				}

				/**
				 * Compose fragment ID anchor with offset, for use in reference container.
				 * Empty span, child of empty span, to avoid tall dotted rectangles in browser.
				 */
				$footnote_anchor_element  = '<span class="footnote_item_base"><span id="';
				$footnote_anchor_element .= self::$footnote_link_slug;
				$footnote_anchor_element .= self::$post_container_id_compound;
				$footnote_anchor_element .= $footnote_id;
				$footnote_anchor_element .= '" class="footnote_item_anchor"></span></span>';

				// Compose optional hard link address.
				$hard_link_address  = ' href="#';
				$hard_link_address .= self::$referrer_link_slug;
				$hard_link_address .= self::$post_container_id_compound;
				$hard_link_address .= $footnote_id . '"';
				$hard_link_address .= $use_backbutton_hint;

				// Compose optional opening link tag with optional hard link, mandatory for instance.
				self::$link_open_tag = '<a' . $hard_link_address;
				self::$link_open_tag = ' class="footnote_hard_back_link">';

			} else {
				// Define as empty, too.
				$footnote_anchor_element = '';
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
			$flag_combined = false;

			// Set otherwise unused variables as empty to avoid screwing up the placeholder array.
			$backlink_event     = '';
			$footnote_backlinks = '';
			$footnote_reference = '';

			if ( $combine_identical_footnotes ) {

				// ID, optional hard link address, and class.
				$footnote_reference  = '<' . self::$link_span;
				$footnote_reference .= ' id="footnote_plugin_reference_';
				$footnote_reference .= self::$post_id;
				$footnote_reference .= '_' . self::$reference_container_id;
				$footnote_reference .= "_$footnote_id\"";
				if ( self::$hard_links_enabled ) {
					$footnote_reference .= ' href="#';
					$footnote_reference .= self::$referrer_link_slug;
					$footnote_reference .= self::$post_container_id_compound;
					$footnote_reference .= $footnote_id . '"';
					$footnote_reference .= $use_backbutton_hint;
				}
				$footnote_reference .= ' class="footnote_backlink"';

				/*
				 * The click event goes in the table cell if footnote remains single.
				 */
				// Reverted wrong linting.
				$backlink_event = ' onclick="footnote_moveToAnchor_';

				$backlink_event .= self::$post_id;
				$backlink_event .= '_' . self::$reference_container_id;
				$backlink_event .= "('footnote_plugin_tooltip_";
				$backlink_event .= self::$post_id;
				$backlink_event .= '_' . self::$reference_container_id;
				$backlink_event .= "_$footnote_id');\"";

				// The dedicated template enumerating backlinks uses another variable.
				$footnote_backlinks = $footnote_reference;

				// Append the click event right to the backlink item for enumerations;.
				// Else it goes in the table cell.
				$footnote_backlinks .= $backlink_event . '>';
				$footnote_reference .= '>';

				// Append the optional offset anchor for hard links.
				if ( self::$hard_links_enabled ) {
					$footnote_reference .= $footnote_anchor_element;
					$footnote_backlinks .= $footnote_anchor_element;
				}

				// Continue both single note and notes cluster, depending on switch option status.
				if ( $symbol_switch ) {

					$footnote_reference .= "$footnote_id$footnote_arrow";
					$footnote_backlinks .= "$footnote_id$footnote_arrow";

				} else {

					$footnote_reference .= "$footnote_arrow$footnote_id";
					$footnote_backlinks .= "$footnote_arrow$footnote_id";

				}

				// If that is the only footnote with this text, we’re almost done..

				// Check if it isn't the last footnote in the array.
				if ( $first_footnote_index < count( self::$footnotes ) ) {

					// Get all footnotes that haven't passed yet.
					$num_footnotes = count( self::$footnotes );
					for ( $check_index = $first_footnote_index; $check_index < $num_footnotes; $check_index++ ) {

						// Check if a further footnote is the same as the actual one.
						if ( self::$footnotes[ $check_index ] === $footnote_text ) {

							// If so, set the further footnote as empty so it won't be displayed later.
							self::$footnotes[ $check_index ] = '';

							// Set the flag to true for the combined status.
							$flag_combined = true;

							// Update the footnote ID.
							$footnote_id = Footnotes_Convert::index( ( $check_index + 1 ), Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_COUNTER_STYLE ) );

							// Resume composing the backlinks enumeration.
							$footnote_backlinks .= "$separator</";
							$footnote_backlinks .= self::$link_span . '>';
							$footnote_backlinks .= $line_break;
							$footnote_backlinks .= '<' . self::$link_span;
							$footnote_backlinks .= ' id="footnote_plugin_reference_';
							$footnote_backlinks .= self::$post_id;
							$footnote_backlinks .= '_' . self::$reference_container_id;
							$footnote_backlinks .= "_$footnote_id\"";

							// Insert the optional hard link address.
							if ( self::$hard_links_enabled ) {
								$footnote_backlinks .= ' href="#';
								$footnote_backlinks .= self::$referrer_link_slug;
								$footnote_backlinks .= self::$post_container_id_compound;
								$footnote_backlinks .= $footnote_id . '"';
								$footnote_backlinks .= $use_backbutton_hint;
							}

							$footnote_backlinks .= ' class="footnote_backlink"';

							// Reverted wrong linting.
							$footnote_backlinks .= ' onclick="footnote_moveToAnchor_';

							$footnote_backlinks .= self::$post_id;
							$footnote_backlinks .= '_' . self::$reference_container_id;
							$footnote_backlinks .= "('footnote_plugin_tooltip_";
							$footnote_backlinks .= self::$post_id;
							$footnote_backlinks .= '_' . self::$reference_container_id;
							$footnote_backlinks .= "_$footnote_id');\">";

							// Append the offset anchor for optional hard links.
							if ( self::$hard_links_enabled ) {
								$footnote_backlinks .= '<span class="footnote_item_base"><span id="';
								$footnote_backlinks .= self::$footnote_link_slug;
								$footnote_backlinks .= self::$post_container_id_compound;
								$footnote_backlinks .= $footnote_id;
								$footnote_backlinks .= '" class="footnote_item_anchor"></span></span>';
							}

							$footnote_backlinks .= $symbol_switch ? '' : $footnote_arrow;
							$footnote_backlinks .= $footnote_id;
							$footnote_backlinks .= $symbol_switch ? $footnote_arrow : '';

						}
					}
				}

				// Append terminator and end tag.
				$footnote_reference .= $terminator . '</' . self::$link_span . '>';
				$footnote_backlinks .= $terminator . '</' . self::$link_span . '>';

			}

			// Line wrapping of URLs already fixed, see above.

			// Get reference container item text if tooltip text goes separate.
			$tooltip_text_length = strpos( $footnote_text, self::$tooltip_shortcode );
			$has_tooltip_text   = ! $tooltip_text_length ? false : true;
			if ( $has_tooltip_text ) {
				$not_tooltip_text           = substr( $footnote_text, ( $tooltip_text_length + self::$tooltip_shortcode_length ) );
				self::$mirror_tooltip_text = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE ) );
				if ( self::$mirror_tooltip_text ) {
					$tooltip_text              = substr( $footnote_text, 0, $tooltip_text_length );
					$reference_text_introducer = Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR );
					$reference_text            = $tooltip_text . $reference_text_introducer . $not_tooltip_text;
				} else {
					$reference_text = $not_tooltip_text;
				}
			} else {
				$reference_text = $footnote_text;
			}

			// Replace all placeholders in table row template.
			$template->replace(
				array(

					// Placeholder used in all templates.
					'text'           => $reference_text,

					// Used in standard layout W/O COMBINED FOOTNOTES.
					'post_id'        => self::$post_id,
					'container_id'   => self::$reference_container_id,
					'note_id'        => Footnotes_Convert::index( $first_footnote_index, Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_COUNTER_STYLE ) ),
					'link-start'     => self::$link_open_tag,
					'link-end'       => self::$link_close_tag,
					'link-span'      => self::$link_span,
					'terminator'     => $terminator,
					'anchor-element' => $footnote_anchor_element,
					'hard-link'      => $hard_link_address,

					// Used in standard layout WITH COMBINED IDENTICALS TURNED ON.
					'pointer'        => $flag_combined ? '' : ' pointer',
					'event'          => $flag_combined ? '' : $backlink_event,
					'backlinks'      => $flag_combined ? $footnote_backlinks : $footnote_reference,

					// Legacy placeholders for use in legacy layout templates.
					'arrow'          => $footnote_arrow,
					'index'          => $footnote_id,
				)
			);

			$body .= $template->get_content();

			// Extra line breaks for page source readability.
			$body .= "\r\n\r\n";

			$template->reload();

		}

		// Call again for robustness when priority levels don’t match any longer.
		self::$scroll_offset = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_OFFSET ) );

		// Streamline.
		$collapse_default = Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_COLLAPSE ) );

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
		$reference_container_label = Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_NAME );

		// Select the reference container template.
		// Whether AMP compatibility mode is enabled.
		if ( Footnotes::$amp_enabled ) {

			// Whether the reference container is collapsed by default.
			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_COLLAPSE ) ) ) {

				// Load 'templates/public/amp-reference-container-collapsed.html'.
				$template_container = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-reference-container-collapsed' );

			} else {

				// Load 'templates/public/amp-reference-container.html'.
				$template_container = new Footnotes_Template( Footnotes_Template::PUBLIC, 'amp-reference-container' );
			}
		} elseif ( 'js' === Footnotes::$script_mode ) {

			// Load 'templates/public/js-reference-container.html'.
			$template_container = new Footnotes_Template( Footnotes_Template::PUBLIC, 'js-reference-container' );

		} else {

			// Load 'templates/public/reference-container.html'.
			$template_container = new Footnotes_Template( Footnotes_Template::PUBLIC, 'reference-container' );
		}

		$scroll_offset        = '';
		$scroll_down_delay    = '';
		$scroll_down_duration = '';
		$scroll_up_delay      = '';
		$scroll_up_duration   = '';

		if ( 'jquery' === Footnotes::$script_mode ) {

			$scroll_offset      = ( self::$scroll_offset / 100 );
			$scroll_up_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_DURATION ) );

			if ( Footnotes_Convert::to_bool( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY ) ) ) {

				$scroll_down_duration = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_DOWN_DURATION ) );

			} else {

				$scroll_down_duration = $scroll_up_duration;

			}

			$scroll_down_delay = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_DOWN_DELAY ) );
			$scroll_up_delay   = intval( Footnotes_Settings::instance()->get( Footnotes_Settings::FOOTNOTES_SCROLL_UP_DELAY ) );

		}

		$template_container->replace(
			array(
				'post_id'              => self::$post_id,
				'container_id'         => self::$reference_container_id,
				'element'              => Footnotes_Settings::instance()->get( Footnotes_Settings::REFERENCE_CONTAINER_LABEL_ELEMENT ),
				'name'                 => empty( $reference_container_label ) ? '&#x202F;' : $reference_container_label,
				'button-style'         => ! $collapse_default ? 'display: none;' : '',
				'style'                => $collapse_default ? 'display: none;' : '',
				'caption'              => ( empty( $reference_container_label ) || ' ' === $reference_container_label ) ? 'References' : $reference_container_label,
				'content'              => $body,
				'scroll-offset'        => $scroll_offset,
				'scroll-down-delay'    => $scroll_down_delay,
				'scroll-down-duration' => $scroll_down_duration,
				'scroll-up-delay'      => $scroll_up_delay,
				'scroll-up-duration'   => $scroll_up_duration,
			)
		);

		// Free all found footnotes if reference container will be displayed.
		self::$footnotes = array();

		return $template_container->get_content();
	}
}
