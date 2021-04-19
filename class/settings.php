<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the Settings class to handle all Plugin settings.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 *
 * The constants are ordered by ascending version so their docblocks can replace most of this list.
 * @since 2.0.0  Update: **symbol for backlinks** removed; hyperlink moved to the reference number.
 * @since 2.0.4  Update: Restore arrow settings to customize or disable the now prepended arrow symbol, thanks to @mmallett issue report.
 * @since 2.0.7  BUGFIX: Hooks: Default-disable 'the_post', thanks to @spaceling @markcheret @nyamachi @whichgodsaves @spiralofhope2 @mmallett @andreasra @widecast @ymorin007 @tashi1es bug reports.
 * @since 2.1.3  Bugfix: Hooks: disable the_excerpt hook by default to fix issues, thanks to @nikelaos bug report.
 */

/**
 * Loads the settings values, sets to default values if undefined.
 *
 * @since 1.5.0
 */
class Footnotes_Settings {

	/**
	 * Settings container key for the label of the reference container.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_NAME = 'footnote_inputfield_references_label';

	/**
	 * Settings container key to collapse the reference container by default.
	 *
	 * @since 1.5.0
	 * @var str
	 * The string is converted to Boolean false if 'no', true if 'yes'.
	 * @see Footnotes_Convert::to_bool()
	 */
	const C_STR_REFERENCE_CONTAINER_COLLAPSE = 'footnote_inputfield_collapse_references';

	/**
	 * Settings container key for the position of the reference container.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_POSITION = 'footnote_inputfield_reference_container_place';

	/**
	 * Settings container key for combining identical footnotes.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_COMBINE_IDENTICAL_FOOTNOTES = 'footnote_inputfield_combine_identical';

	/**
	 * Settings container key for the short code of the footnote’s start.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_START = 'footnote_inputfield_placeholder_start';

	/**
	 * Settings container key for the short code of the footnote’s end.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_END = 'footnote_inputfield_placeholder_end';

	/**
	 * Settings container key for the user-defined short code of the footnotes start.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED = 'footnote_inputfield_placeholder_start_user_defined';

	/**
	 * Settings container key for the user-defined short code of the footnotes end.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED = 'footnote_inputfield_placeholder_end_user_defined';

	/**
	 * Settings container key for the counter style of the footnotes.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_COUNTER_STYLE = 'footnote_inputfield_counter_style';

	/**
	 * Settings container key for the backlink symbol selection.
	 *
	 * @since 1.5.0
	 *
	 * - Update: Restore arrow settings to customize or disable the now prepended arrow symbol, thanks to @mmallett issue report.
	 *
	 * @reporter @mmallett
	 * @link https://wordpress.org/support/topic/mouse-over-broken/#post-13593037
	 *
	 * @since 2.0.4
	 * @var str
	 */
	const C_STR_HYPERLINK_ARROW = 'footnote_inputfield_custom_hyperlink_symbol';

	/**
	 * Settings container key for the user-defined backlink symbol.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_HYPERLINK_ARROW_USER_DEFINED = 'footnote_inputfield_custom_hyperlink_symbol_user';

	/**
	 * Settings container key to look for footnotes in post excerpts.
	 *
	 * @since 1.5.0
	 * @since 2.6.2  Debug No option.
	 * @since 2.6.3  Enable by default after debugging both Yes and No options.
	 *
	 * - Bugfix: Excerpts: make excerpt handling backward compatible, thanks to @mfessler bug report.
	 *
	 * @reporter @mfessler
	 * @link https://github.com/markcheret/footnotes/issues/65
	 *
	 * @since 2.7.0
	 * @see C_STR_EXPERT_LOOKUP_THE_EXCERPT
	 * @var str  Default 'manual'.
	 */
	const C_STR_FOOTNOTES_IN_EXCERPT = 'footnote_inputfield_search_in_excerpt';

	/**
	 * Settings container key for the string before the footnote referrer.
	 *
	 * @since 1.5.0
	 * @var str
	 *
	 * The default footnote referrer surroundings should be square brackets.
	 *
	 * - with respect to baseline footnote referrers new option;
	 * - as in English or US American typesetting;
	 * - for better UX thanks to a more button-like appearance;
	 * - for stylistic consistency with the expand-collapse button.
	 */
	const C_STR_FOOTNOTES_STYLING_BEFORE = 'footnote_inputfield_custom_styling_before';

	/**
	 * Settings container key for the string after the footnote referrer.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_STYLING_AFTER = 'footnote_inputfield_custom_styling_after';

	/**
	 * Settings container key for the Custom CSS.
	 *
	 * @since 1.5.0
	 * @var str
	 *
	 * @since 1.3.0  Adding: new settings tab for custom CSS settings.
	 */
	const C_STR_CUSTOM_CSS = 'footnote_inputfield_custom_css';

	/**
	 * Settings container key for the 'I love footnotes' text.
	 *
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_LOVE = 'footnote_inputfield_love';

	/**
	 * Settings container key to enable the mouse-over box.
	 *
	 * @since 1.5.2
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED = 'footnote_inputfield_custom_mouse_over_box_enabled';

	/**
	 * Settings container key to enable tooltip truncation.
	 *
	 * @since 1.5.4
	 * @var str
	 *
	 * The mouse over content truncation should be enabled by default
	 * to raise awareness of the functionality and to prevent the screen
	 * from being filled at mouse-over, and to allow the Continue reading.
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED = 'footnote_inputfield_custom_mouse_over_box_excerpt_enabled';

	/**
	 * Settings container key for the mouse-over box to define the max. length of the enabled excerpt.
	 *
	 * @since 1.5.4
	 * @var int
	 *
	 * @since 2.0.7  Increase default truncation length from 150 to 200 chars.
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH = 'footnote_inputfield_custom_mouse_over_box_excerpt_length';

	/**
	 * Settings container key to enable the 'the_title' hook.
	 *
	 * @since 1.5.5
	 * @var str
	 *
	 * These are checkboxes; keyword 'checked' is converted to Boolean true,
	 * empty string to false (default).
	 *
	 * Hooks should all be enabled by default to prevent users from
	 * thinking at first that the feature is broken in post titles.
	 * @link https://wordpress.org/support/topic/more-feature-ideas/
	 *
	 * Yet in titles, footnotes are still buggy, because WordPress
	 * uses the title string in menus and in the title element, but
	 * Footnotes doesn’t delete footnotes therein.
	 */
	const C_STR_EXPERT_LOOKUP_THE_TITLE = 'footnote_inputfield_expert_lookup_the_title';

	/**
	 * Settings container key to enable the 'the_content' hook.
	 *
	 * @since 1.5.5
	 * @var str
	 */
	const C_STR_EXPERT_LOOKUP_THE_CONTENT = 'footnote_inputfield_expert_lookup_the_content';

	/**
	 * Settings container key to enable the 'the_excerpt' hook.
	 *
	 * @since 1.5.5
	 *
	 * - Bugfix: Hooks: disable the_excerpt hook by default to fix issues, thanks to @nikelaos bug report.
	 *
	 * @reporter @nikelaos
	 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068
	 * @link https://wordpress.org/support/topic/jquery-comes-up-in-feed-content/#post-13110879
	 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068
	 *
	 * @since 2.1.3
	 * @since 2.6.3  Enable by default after debugging the 'Footnotes in excerpts' setting.
	 *
	 * - Bugfix: Hooks: default-disable the_excerpt hook with respect to theme-specific excerpt handling, thanks to @mmallett bug reports.
	 *
	 * @reporter @mmallett
	 * @link https://wordpress.org/support/topic/broken-662/
	 * @link https://wordpress.org/support/topic/update-crashed-my-website-3/#post-14260969
	 *
	 * @since 2.6.5
	 * @see C_STR_FOOTNOTES_IN_EXCERPT
	 * @var str
	 */
	const C_STR_EXPERT_LOOKUP_THE_EXCERPT = 'footnote_inputfield_expert_lookup_the_excerpt';

	/**
	 * Settings container key to enable the 'widget_title' hook.
	 *
	 * @since 1.5.5
	 * @var str
	 */
	const C_STR_EXPERT_LOOKUP_WIDGET_TITLE = 'footnote_inputfield_expert_lookup_widget_title';

	/**
	 * Settings container key to enable the 'widget_text' hook.
	 *
	 * @since 1.5.5
	 * @var str
	 *
	 * The widget_text hook must be disabled by default, because it causes
	 * multiple reference containers to appear in Elementor accordions, but
	 * it must be enabled if multiple reference containers are desired, as
	 * in Elementor toggles.
	 */
	const C_STR_EXPERT_LOOKUP_WIDGET_TEXT = 'footnote_inputfield_expert_lookup_widget_text';

	/**
	 * Settings container key for the Expert mode.
	 *
	 * @since 1.5.5
	 * @var str
	 *
	 * @since 2.1.6  This setting removed as irrelevant since priority level settings need permanent visibility.
	 *
	 * Since the removal of the the_post hook, the tab is no danger zone any longer.
	 * All users, not experts only, need to be able to control relative positioning.
	 */
	const C_STR_FOOTNOTES_EXPERT_MODE = 'footnote_inputfield_enable_expert_mode';

	/**
	 * Settings container key for the mouse-over box to define the color.
	 *
	 * @since 1.5.6
	 *
	 * - Bugfix: Tooltips: Styling: Font color: set to black for maximum contrast with respect to white default background, thanks to 4msc bug report.
	 *
	 * @reporter @4msc
	 * @link https://wordpress.org/support/topic/tooltip-not-showing-on-dark-theme-with-white-text/
	 *
	 * @since 2.6.1
	 * @see C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR = 'footnote_inputfield_custom_mouse_over_box_color';

	/**
	 * Settings container key for the mouse-over box to define the background color.
	 *
	 * @since 1.5.6
	 * @since 1.2.5..1.5.5  #fff7a7 hard-coded.
	 * @since 1.5.6..2.0.6  #fff7a7 setting default.
	 * The mouse over box shouldn’t feature a colored background.
	 * By default, due to diverging user preferences. White is neutral.
	 * @since 2.0.7..2.5.10 #ffffff setting default.
	 *
	 * - Bugfix: Tooltips: Styling: Background color: empty default value to adopt theme background, thanks to 4msc bug report.
	 *
	 * @reporter @4msc
	 * @link https://wordpress.org/support/topic/tooltip-not-showing-on-dark-theme-with-white-text/
	 *
	 * @since 2.5.11
	 * Theme default background color is best.
	 * But theme default background color doesn’t seem to exist.
	 * @link https://wordpress.org/support/topic/problem-with-footnotes-in-excerpts-of-the-blog-page/#post-14241849
	 * @since 2.6.1  default #ffffff again along with #000000 as font color.
	 * @see C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND = 'footnote_inputfield_custom_mouse_over_box_background';

	/**
	 * Settings container key for the mouse-over box to define the border width.
	 *
	 * @since 1.5.6
	 * @var int
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH = 'footnote_inputfield_custom_mouse_over_box_border_width';

	/**
	 * Settings container key for the mouse-over box to define the border color.
	 *
	 * @since 1.5.6
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR = 'footnote_inputfield_custom_mouse_over_box_border_color';

	/**
	 * Settings container key for the mouse-over box to define the border radius.
	 *
	 * @since 1.5.6
	 * @var int
	 *
	 * @since 2.0.7  The mouse over box corners mustn’t be rounded as that is outdated.
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS = 'footnote_inputfield_custom_mouse_over_box_border_radius';

	/**
	 * Settings container key for the mouse-over box to define the max. width.
	 *
	 * @since 1.5.6
	 * @var int
	 *
	 * @since 2.0.7  Set default width 450.
	 * The width should be limited to start with, for the box to have shape.
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH = 'footnote_inputfield_custom_mouse_over_box_max_width';

	/**
	 * Settings container key for the mouse-over box to define the position.
	 *
	 * @since 1.5.7
	 * @var str
	 *
	 * The default position should not be lateral because of the risk
	 * the box gets squeezed between note anchor at line end and window edge,
	 * and top because reading at the bottom of the window is more likely.
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION = 'footnote_inputfield_custom_mouse_over_box_position';

	/**
	 * Settings container key for the mouse-over box to define the offset (x).
	 *
	 * @since 1.5.7
	 * @var int
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X = 'footnote_inputfield_custom_mouse_over_box_offset_x';

	/**
	 * Settings container key for the mouse-over box to define the offset (y).
	 *
	 * @since 1.5.7
	 * @var int
	 *
	 * The vertical offset must be negative for the box not to cover
	 * The current line of text (web coordinates origin is top left).
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y = 'footnote_inputfield_custom_mouse_over_box_offset_y';

	/**
	 * Settings container key for the mouse-over box to define the box-shadow color.
	 *
	 * @since 1.5.8
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR = 'footnote_inputfield_custom_mouse_over_box_shadow_color';

	/**
	 * Settings container key for the label of the Read-on button in truncated tooltips.
	 *
	 * - Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
	 *
	 * @reporter @rovanov
	 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
	 *
	 * @since 2.1.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_TOOLTIP_READON_LABEL = 'footnote_inputfield_readon_label';

	/**
	 * Settings container key to enable the alternative tooltips.
	 *
	 * - Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
	 *
	 * @reporter @andreasra
	 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/2/#post-13632566
	 *
	 * @since 2.1.1
	 * @var str
	 *
	 * These alternative tooltips work around a website related jQuery UI
	 * outage. They are low-script but use the AMP incompatible onmouseover
	 * and onmouseout arguments, along with CSS transitions for fade-in/out.
	 * The very small script is inserted after Footnotes’ internal stylesheet.
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE = 'footnote_inputfield_custom_mouse_over_box_alternative';

	/**
	 * Settings container key for the referrer element.
	 *
	 * - Bugfix: Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report.
	 *
	 * @reporter @cwbayer
	 * @link https://wordpress.org/support/topic/footnote-number-in-text-superscript-disrupts-leading/
	 *
	 * @since 2.1.1
	 * @var str
	 */
	const C_STR_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS = 'footnotes_inputfield_referrer_superscript_tags';

	/**
	 * Settings container key to enable the display of a backlink symbol.
	 *
	 * - Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
	 *
	 * @reporter @spaceling
	 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13671138
	 *
	 * @since 2.1.1
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE = 'footnotes_inputfield_reference_container_backlink_symbol_enable';

	/**
	 * Settings container key to not display the reference container on the homepage.
	 *
	 * - Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
	 *
	 * @reporter @dragon013
	 * @link https://wordpress.org/support/topic/possible-to-hide-it-from-start-page/
	 *
	 * @since 2.1.1
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_START_PAGE_ENABLE = 'footnotes_inputfield_reference_container_start_page_enable';

	/**
	 * Settings container key to enable the legacy layout of the reference container.
	 *
	 * - Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
	 *
	 * @since 2.1.1
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE = 'footnotes_inputfield_reference_container_3column_layout_enable';

	/**
	 * Settings container key to get the backlink symbol switch side.
	 *
	 * - Bugfix: Reference container: option to append symbol (prepended by default), thanks to @spaceling code contribution.
	 *
	 * @contributor @spaceling
	 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13615994
	 *
	 * @since 2.1.1
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH = 'footnotes_inputfield_reference_container_backlink_symbol_switch';

	/**
	 * Settings container key for 'the_content' hook priority level.
	 *
	 * - Bugfix: Reference container: fix relative position through priority level, thanks to @june01 @imeson @spaceling bug reports, thanks to @spaceling code contribution.
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
	 * @since 2.0.5
	 * @link https://codex.wordpress.org/Plugin_API/#Hook_in_your_Filter
	 *
	 * - Bugfix: Dashboard: priority level setting for the_content hook, thanks to @imeson bug report.
	 *
	 * @reporter @imeson
	 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13538345
	 *
	 * @since 2.1.1
	 *
	 * - Bugfix: Priority levels: set the_content priority level to 98 to prevent plugin conflict, thanks to @marthalindeman bug report.
	 *
	 * @reporter @marthalindeman
	 * @link https://wordpress.org/support/topic/code-showing-up-in-references/
	 *
	 * @since 2.1.6
	 *
	 * Priority level of the_content and of widget_text as the only relevant
	 * hooks must be less than 99 because social buttons may yield scripts
	 * that contain the strings '((' and '))', i.e. the default footnote
	 * start and end short codes, causing issues with fake footnotes.
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
	 * @var int
	 */
	const C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_content_priority_level';

	/**
	 * Settings container key for 'the_title' hook priority level.
	 *
	 * - Bugfix: Dashboard: priority level settings for all other hooks, thanks to @nikelaos bug report.
	 *
	 * @reporter @nikelaos
	 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13676705
	 *
	 * @since 2.1.2
	 * @var int
	 */
	const C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_title_priority_level';

	/**
	 * Settings container key for 'widget_title' hook priority level.
	 *
	 * @since 2.1.2
	 * @var int
	 */
	const C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_widget_title_priority_level';

	/**
	 * Settings container key for 'widget_text' hook priority level.
	 *
	 * @since 2.1.2
	 * @var int
	 */
	const C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_widget_text_priority_level';

	/**
	 * Settings container key for 'the_excerpt' hook priority level.
	 *
	 * @since 2.1.2
	 * @var int
	 */
	const C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_excerpt_priority_level';

	/**
	 * Settings container key for the link element option.
	 *
	 * - Bugfix: Referrers and backlinks: Styling: make link elements optional to fix issues, thanks to @docteurfitness issue report and code contribution.
	 *
	 * @contributor @docteurfitness
	 * @link https://wordpress.org/support/topic/update-2-1-3/#post-13704194
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_LINK_ELEMENT_ENABLED = 'footnote_inputfield_link_element_enabled';

	/**
	 * Settings container key to enable the presence of a backlink separator.
	 *
	 * - Bugfix: Reference container: make separating and terminating punctuation optional and configurable, thanks to @docteurfitness issue report and code contribution.
	 *
	 * @contributor @docteurfitness
	 * @link https://wordpress.org/support/topic/update-2-1-3/#post-13704194
	 *
	 * @since 2.1.4
	 * @var str
	 *
	 * Backlink separators and terminators are often not preferred.
	 * But a choice must be provided along with the ability to customize.
	 */
	const C_STR_BACKLINKS_SEPARATOR_ENABLED = 'footnotes_inputfield_backlinks_separator_enabled';

	/**
	 * Settings container key for the backlink separator options.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_SEPARATOR_OPTION = 'footnotes_inputfield_backlinks_separator_option';

	/**
	 * Settings container key for a custom backlink separator.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_SEPARATOR_CUSTOM = 'footnotes_inputfield_backlinks_separator_custom';

	/**
	 * Settings container key to enable the presence of a backlink terminator.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_TERMINATOR_ENABLED = 'footnotes_inputfield_backlinks_terminator_enabled';

	/**
	 * Settings container key for the backlink terminator options.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_TERMINATOR_OPTION = 'footnotes_inputfield_backlinks_terminator_option';

	/**
	 * Settings container key for a custom backlink terminator.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_TERMINATOR_CUSTOM = 'footnotes_inputfield_backlinks_terminator_custom';

	/**
	 * Settings container key to enable the backlinks column width.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_COLUMN_WIDTH_ENABLED = 'footnotes_inputfield_backlinks_column_width_enabled';

	/**
	 * Settings container key for the backlinks column width scalar.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR = 'footnotes_inputfield_backlinks_column_width_scalar';

	/**
	 * Settings container key for the backlinks column width unit.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_COLUMN_WIDTH_UNIT = 'footnotes_inputfield_backlinks_column_width_unit';

	/**
	 * Settings container key to enable a max width for the backlinks column.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED = 'footnotes_inputfield_backlinks_column_max_width_enabled';

	/**
	 * Settings container key for the backlinks column max width scalar.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR = 'footnotes_inputfield_backlinks_column_max_width_scalar';

	/**
	 * Settings container key for the backlinks column max width unit.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT = 'footnotes_inputfield_backlinks_column_max_width_unit';

	/**
	 * Settings container key to enable line breaks between backlinks.
	 *
	 * @since 2.1.4
	 * @var str
	 * Whether a <br /> tag is inserted.
	 */
	const C_STR_BACKLINKS_LINE_BREAKS_ENABLED = 'footnotes_inputfield_backlinks_line_breaks_enabled';

	/**
	 * Settings container key to enable setting the tooltip font size.
	 *
	 * @since 2.1.4
	 * @var str
	 *
	 * Tooltip font size reset to legacy by default since 2.1.4;
	 * Was set to inherit since 2.1.1 as it overrode custom CSS,
	 * Called mouse over box not tooltip for consistency.
	 */
	const C_STR_MOUSE_OVER_BOX_FONT_SIZE_ENABLED = 'footnotes_inputfield_mouse_over_box_font_size_enabled';

	/**
	 * Settings container key for the scalar value of the tooltip font size.
	 *
	 * @since 2.1.4
	 * @var flo
	 */
	const C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR = 'footnotes_inputfield_mouse_over_box_font_size_scalar';

	/**
	 * Settings container key for the unit of the tooltip font size.
	 *
	 * @since 2.1.4
	 * @var str
	 */
	const C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT = 'footnotes_inputfield_mouse_over_box_font_size_unit';

	/**
	 * Settings container key for basic responsive page layout support options.
	 *
	 * @since 2.1.4
	 * @var str
	 * Whether to concatenate an additional stylesheet.
	 */
	const C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT = 'footnotes_inputfield_page_layout_support';

	/**
	 * Settings container key for scroll offset.
	 *
	 * - Bugfix: Scroll offset: make configurable to fix site-dependent issues related to fixed headers.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_FOOTNOTES_SCROLL_OFFSET = 'footnotes_inputfield_scroll_offset';

	/**
	 * Settings container key for scroll duration.
	 *
	 * - Bugfix: Scroll duration: make configurable to conform to website content and style requirements.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_FOOTNOTES_SCROLL_DURATION = 'footnotes_inputfield_scroll_duration';

	/**
	 * Settings container key for tooltip display fade-in delay.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY = 'footnotes_inputfield_mouse_over_box_fade_in_delay';

	/**
	 * Settings container key for tooltip display fade-in duration.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION = 'footnotes_inputfield_mouse_over_box_fade_in_duration';

	/**
	 * Settings container key for tooltip display fade-out delay.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY = 'footnotes_inputfield_mouse_over_box_fade_out_delay';

	/**
	 * Settings container key for tooltip display fade-out duration.
	 *
	 * @since 2.1.4
	 * @var int
	 */
	const C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION = 'footnotes_inputfield_mouse_over_box_fade_out_duration';

	/**
	 * Settings container key for URL wrap option.
	 *
	 * This is made optional because it causes weird line breaks.
	 * Unicode-compliant browsers break URLs at slashes.
	 *
	 * @since 2.1.6
	 * @var str
	 */
	const C_STR_FOOTNOTE_URL_WRAP_ENABLED = 'footnote_inputfield_url_wrap_enabled';

	/**
	 * Settings container key for reference container position shortcode.
	 *
	 * - Adding: Reference container: support for custom position shortcode, thanks to @hamshe issue report.
	 *
	 * @reporter @hamshe
	 * @link https://wordpress.org/support/topic/reference-container-in-elementor/
	 *
	 * @since 2.2.0
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE = 'footnote_inputfield_reference_container_position_shortcode';

	/**
	 * Settings container key for the Custom CSS migrated to a dedicated tab.
	 *
	 * - Update: Dashboard: Custom CSS: unearth text area and migrate to dedicated tab as designed.
	 *
	 * @since 2.2.2
	 * @var str
	 */
	const C_STR_CUSTOM_CSS_NEW = 'footnote_inputfield_custom_css_new';

	/**
	 * Settings container key to enable display of legacy Custom CSS metaboxes.
	 *
	 * @since 2.2.2
	 * @var str
	 *
	 * - Bugfix: Dashboard: Custom CSS: swap migration Boolean, meaning 'show legacy' instead of 'migration complete', due to storage data structure constraints.
	 *
	 * @since 2.3.0
	 *
	 * The Boolean must be false if its setting is contained in the container to be hidden,
	 * because when saving, all missing constants are emptied, and to_bool() converts empty to false.
	 */
	const C_STR_CUSTOM_CSS_LEGACY_ENABLE = 'footnote_inputfield_custom_css_legacy_enable';

	/**
	 * Settings container key for alternative tooltip position.
	 *
	 * @since 2.2.5
	 * @var str
	 *
	 * Fixed width is for alternative tooltips, cannot reuse max-width nor offsets.
	 */
	const C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION = 'footnotes_inputfield_alternative_mouse_over_box_position';

	/**
	 * Settings container key for alternative tooltip x offset.
	 *
	 * @since 2.2.5
	 * @var int
	 */
	const C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X = 'footnotes_inputfield_alternative_mouse_over_box_offset_x';

	/**
	 * Settings container key for alternative tooltip y offset.
	 *
	 * @since 2.2.5
	 * @var int
	 */
	const C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y = 'footnotes_inputfield_alternative_mouse_over_box_offset_y';

	/**
	 * Settings container key for alternative tooltip width.
	 *
	 * @since 2.2.5
	 * @var int
	 */
	const C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH = 'footnotes_inputfield_alternative_mouse_over_box_width';


	/**
	 * Settings container key for the reference container label element.
	 *
	 * - Bugfix: Reference container: Label: option to select paragraph or heading element, thanks to @markhillyer issue report.
	 *
	 * @reporter @markhillyer
	 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
	 *
	 * @since 2.2.5
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT = 'footnotes_inputfield_reference_container_label_element';

	/**
	 * Settings container key to enable the reference container label bottom border.
	 *
	 * - Bugfix: Reference container: Label: make bottom border an option, thanks to @markhillyer issue report.
	 *
	 * @reporter @markhillyer
	 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
	 *
	 * @since 2.2.5
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER = 'footnotes_inputfield_reference_container_label_bottom_border';

	/**
	 * Settings container key to enable reference container table row borders.
	 *
	 * - Bugfix: Reference container: add option for table borders to restore pre-2.0.0 design, thanks to @noobishh issue report.
	 *
	 * @reporter @noobishh
	 * @link https://wordpress.org/support/topic/borders-25/
	 *
	 * @since 2.2.10
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE = 'footnotes_inputfield_reference_container_row_borders_enable';

	/**
	 * Settings container key for reference container top margin.
	 *
	 * - Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
	 *
	 * @reporter @hamshe
	 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
	 *
	 * @since 2.3.0
	 * @var int
	 */
	const C_INT_REFERENCE_CONTAINER_TOP_MARGIN = 'footnotes_inputfield_reference_container_top_margin';

	/**
	 * Settings container key for reference container bottom margin.
	 *
	 * - Bugfix: Reference container: convert top padding to margin and make it a setting, thanks to @hamshe bug report.
	 *
	 * @reporter @hamshe
	 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
	 *
	 * @since 2.3.0
	 * @var int
	 */
	const C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN = 'footnotes_inputfield_reference_container_bottom_margin';

	/**
	 * Settings container key to enable hard links.
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
	 * @var str
	 *
	 * When the alternative reference container is enabled, hard links are too.
	 */
	const C_STR_FOOTNOTES_HARD_LINKS_ENABLE = 'footnotes_inputfield_hard_links_enable';

	/**
	 * Settings container key for the fragment ID slug in referrers.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	const C_STR_REFERRER_FRAGMENT_ID_SLUG = 'footnotes_inputfield_referrer_fragment_id_slug';

	/**
	 * Settings container key for the fragment ID slug in footnotes.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	const C_STR_FOOTNOTE_FRAGMENT_ID_SLUG = 'footnotes_inputfield_footnote_fragment_id_slug';

	/**
	 * Settings container key for the ID separator in fragment IDs.
	 *
	 * @since 2.3.0
	 * @var str
	 */
	const C_STR_HARD_LINK_IDS_SEPARATOR = 'footnotes_inputfield_hard_link_ids_separator';

	/**
	 * Settings container key to enable shortcode syntax validation.
	 *
	 * @since 2.4.0
	 * @var str
	 */
	const C_STR_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE = 'footnotes_inputfield_shortcode_syntax_validation_enable';

	/**
	 * Settings container key to enable backlink tooltips.
	 *
	 * - Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
	 *
	 * @reporter @theroninjedi47
	 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
	 *
	 * @since 2.5.4
	 * @var str
	 *
	 * When hard links are enabled, clicks on the backlinks are logged in the browsing history,
	 * along with clicks on the referrers.
	 * This tooltip hints to use the backbutton instead, so the history gets streamlined again.
	 * @link https://wordpress.org/support/topic/making-it-amp-compatible/#post-13837359
	 */
	const C_STR_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE = 'footnotes_inputfield_backlink_tooltip_enable';

	/**
	 * Settings container key to configure the backlink tooltip.
	 *
	 * - Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
	 *
	 * @reporter @theroninjedi47
	 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
	 *
	 * @since 2.5.4
	 * @var str
	 */
	const C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT = 'footnotes_inputfield_backlink_tooltip_text';

	/**
	 * Settings container key to configure the tooltip excerpt delimiter.
	 *
	 * - Update: Tooltips: ability to display dedicated content before `[[/tooltip]]`, thanks to @jbj2199 issue report.
	 *
	 * The first implementation used a fixed shortcode provided in the changelog.
	 * But Footnotes’ UI design policy is to make shortcodes freely configurable.
	 *
	 * @reporter @jbj2199
	 * @link https://wordpress.org/support/topic/change-tooltip-text/
	 *
	 * @since 2.5.4
	 * @var str
	 *
	 * Tooltips can display another content than the footnote entry
	 * in the reference container. The trigger is a shortcode in
	 * the footnote text separating the tooltip text from the note.
	 * That is consistent with what WordPress does for excerpts.
	 */
	const C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER = 'footnotes_inputfield_tooltip_excerpt_delimiter';

	/**
	 * Settings container key to enable mirroring the tooltip excerpt in the reference container.
	 *
	 * @since 2.5.4
	 * @var str
	 *
	 * Tooltips, even jQuery-driven, may be hard to consult on mobiles.
	 * This option allows to read the tooltip content in the reference container too.
	 * @link https://wordpress.org/support/topic/change-tooltip-text/#post-13935050
	 * But this must not be the default behavior.
	 * @link https://wordpress.org/support/topic/change-tooltip-text/#post-13935488
	 */
	const C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE = 'footnotes_inputfield_tooltip_excerpt_mirror_enable';

	/**
	 * Settings container key to configure the tooltip excerpt separator in the reference container.
	 *
	 * @since 2.5.4
	 * @var str
	 */
	const C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR = 'footnotes_inputfield_tooltip_excerpt_mirror_separator';

	/**
	 * Settings container key to enable superscript style normalization.
	 *
	 * -Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
	 *
	 * @reporter @tomturowski
	 * @link https://wordpress.org/support/topic/in-line-superscript-ref-rides-to-high/
	 *
	 * @since 2.5.4
	 * @var str
	 */
	const C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT = 'footnotes_inputfield_referrers_normal_superscript';

	/**
	 * Settings container key to select the script mode for the reference container.
	 *
	 * - Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
	 *
	 * @reporter @hopper87it
	 * @link https://wordpress.org/support/topic/footnotes-wp-rocket/
	 *
	 * @since 2.5.6
	 * @var str
	 */
	const C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE = 'footnotes_inputfield_reference_container_script_mode';

	/**
	 * Settings container key to enable AMP compatibility mode.
	 *
	 * - Adding: Tooltips: make display work purely by style rules for AMP compatibility, thanks to @milindmore22 code contribution.
	 * - Bugfix: Tooltips: enable accessibility by keyboard navigation, thanks to @westonruter code contribution.
	 * - Adding: Reference container: get expanding and collapsing to work also in AMP compatibility mode, thanks to @westonruter code contribution.
	 *
	 * @contributor @milindmore22
	 * @link https://github.com/ampproject/amp-wp/issues/5913#issuecomment-785306933
	 *
	 * @contributor @westonruter
	 * @link https://github.com/ampproject/amp-wp/issues/5913#issuecomment-785419655
	 * @link https://github.com/markcheret/footnotes/issues/48#issuecomment-799580854
	 * @link https://github.com/markcheret/footnotes/issues/48#issuecomment-799582394
	 *
	 * @since 2.5.11 (draft)
	 * @since 2.6.0  (release)
	 * @var str
	 */
	const C_STR_FOOTNOTES_AMP_COMPATIBILITY_ENABLE = 'footnotes_inputfield_amp_compatibility_enable';

	/**
	 * Settings container key for scroll duration asymmetricity.
	 *
	 * @since 2.5.11
	 * @var str
	 */
	const C_STR_FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY = 'footnotes_inputfield_scroll_duration_asymmetricity';

	/**
	 * Settings container key for scroll down duration.
	 *
	 * @since 2.5.11
	 * @var int
	 */
	const C_INT_FOOTNOTES_SCROLL_DOWN_DURATION = 'footnotes_inputfield_scroll_down_duration';

	/**
	 * Settings container key for scroll down delay.
	 *
	 * @since 2.5.11
	 * @var int
	 */
	const C_INT_FOOTNOTES_SCROLL_DOWN_DELAY = 'footnotes_inputfield_scroll_down_delay';

	/**
	 * Settings container key for scroll up delay.
	 *
	 * @since 2.5.11
	 * @var int
	 */
	const C_INT_FOOTNOTES_SCROLL_UP_DELAY = 'footnotes_inputfield_scroll_up_delay';

	/**
	 * Settings container key to set the solution of the input element label issue.
	 *
	 * @since 2.5.12
	 * @var str
	 * If hard links are not enabled, clicking a referrer in an input element label
	 * toggles the state of the input element the label is connected to.
	 * Beside hard links, other solutions include moving footnotes off the label and
	 * append them, or disconnecting this label from the input element (discouraged).
	 * @link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14212318
	 */
	const C_STR_FOOTNOTES_LABEL_ISSUE_SOLUTION = 'footnotes_inputfield_label_issue_solution';

	/**
	 * Settings container key to enable CSS smooth scrolling.
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
	 * @var str
	 * Native smooth scrolling only works in recent browsers.
	 */
	const C_STR_FOOTNOTES_CSS_SMOOTH_SCROLLING = 'footnotes_inputfield_css_smooth_scrolling';

	/**
	 * Settings container key for the footnote section shortcode.
	 *
	 * - Adding: Reference container: optionally per section by shortcode, thanks to @grflukas issue report.
	 *
	 * @reporter @grflukas
	 * @link https://wordpress.org/support/topic/multiple-reference-containers-in-single-post/
	 *
	 * @since 2.7.0
	 * @var str
	 */
	const C_STR_FOOTNOTE_SECTION_SHORTCODE = 'footnotes_inputfield_section_shortcode';


	/**
	 *      SETTINGS STORAGE.
	 */

	/**
	 * Stores a singleton reference of this class.
	 *
	 * @since  1.5.0
	 * @var Footnotes_Settings
	 */
	private static $a_obj_instance = null;

	/**
	 * Contains all Settings Container names.
	 *
	 * @since 1.5.0
	 * @var array
	 *
	 * Edited.
	 * 2.2.2  added tab for Custom CSS
	 *
	 * These are the storage container names, one per dashboard tab.
	 */
	private $a_arr_container = array(
		'footnotes_storage',
		'footnotes_storage_custom',
		'footnotes_storage_expert',
		'footnotes_storage_custom_css',
	);

	/**
	 * Contains all Default Settings for each Settings Container.
	 *
	 * @since 1.5.0
	 * @var array
	 *
	 * Comments are moved to constant docblocks.
	 */
	private $a_arr_default = array(

		// General settings.
		'footnotes_storage'            => array(

			// AMP compatibility.
			self::C_STR_FOOTNOTES_AMP_COMPATIBILITY_ENABLE => '',

			// Footnote start and end short codes.
			self::C_STR_FOOTNOTES_SHORT_CODE_START         => '((',
			self::C_STR_FOOTNOTES_SHORT_CODE_END           => '))',
			self::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED => '',
			self::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED => '',
			self::C_STR_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE => 'yes',

			// Footnotes numbering.
			self::C_STR_FOOTNOTES_COUNTER_STYLE            => 'arabic_plain',
			self::C_STR_COMBINE_IDENTICAL_FOOTNOTES        => 'yes',

			// Scrolling behavior.
			self::C_STR_FOOTNOTES_CSS_SMOOTH_SCROLLING     => 'no',
			self::C_INT_FOOTNOTES_SCROLL_OFFSET            => 20,
			self::C_INT_FOOTNOTES_SCROLL_DURATION          => 380,
			self::C_STR_FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY => 'no',
			self::C_INT_FOOTNOTES_SCROLL_DOWN_DURATION     => 150,
			self::C_INT_FOOTNOTES_SCROLL_DOWN_DELAY        => 0,
			self::C_INT_FOOTNOTES_SCROLL_UP_DELAY          => 0,
			self::C_STR_FOOTNOTES_HARD_LINKS_ENABLE        => 'no',
			self::C_STR_REFERRER_FRAGMENT_ID_SLUG          => 'r',
			self::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG          => 'f',
			self::C_STR_HARD_LINK_IDS_SEPARATOR            => '+',
			self::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE  => 'yes',
			self::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT    => 'Alt+ ←',

			// Reference container.
			self::C_STR_REFERENCE_CONTAINER_NAME           => 'References',
			self::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT  => 'p',
			self::C_STR_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER => 'yes',
			self::C_STR_REFERENCE_CONTAINER_COLLAPSE       => 'no',
			self::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE => 'jquery',
			self::C_STR_REFERENCE_CONTAINER_POSITION       => 'post_end',
			self::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE => '[[references]]',
			self::C_STR_FOOTNOTE_SECTION_SHORTCODE         => '[[/footnotesection]]',
			self::C_STR_REFERENCE_CONTAINER_START_PAGE_ENABLE => 'yes',
			self::C_INT_REFERENCE_CONTAINER_TOP_MARGIN     => 24,
			self::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN  => 0,
			self::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT      => 'none',
			self::C_STR_FOOTNOTE_URL_WRAP_ENABLED          => 'yes',
			self::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE => 'yes',
			self::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH => 'no',
			self::C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE => 'no',
			self::C_STR_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE => 'no',

			self::C_STR_BACKLINKS_SEPARATOR_ENABLED        => 'yes',
			self::C_STR_BACKLINKS_SEPARATOR_OPTION         => 'comma',
			self::C_STR_BACKLINKS_SEPARATOR_CUSTOM         => '',

			self::C_STR_BACKLINKS_TERMINATOR_ENABLED       => 'no',
			self::C_STR_BACKLINKS_TERMINATOR_OPTION        => 'full_stop',
			self::C_STR_BACKLINKS_TERMINATOR_CUSTOM        => '',

			self::C_STR_BACKLINKS_COLUMN_WIDTH_ENABLED     => 'no',
			self::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR      => '50',
			self::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT        => 'px',

			self::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED => 'no',
			self::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR  => '140',
			self::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT    => 'px',

			self::C_STR_BACKLINKS_LINE_BREAKS_ENABLED      => 'no',
			self::C_STR_LINK_ELEMENT_ENABLED               => 'yes',

			// Footnotes in excerpts.
			self::C_STR_FOOTNOTES_IN_EXCERPT               => 'manual',

			// Footnotes love.
			self::C_STR_FOOTNOTES_LOVE                     => 'no',

			// Deprecated.
			self::C_STR_FOOTNOTES_EXPERT_MODE              => 'yes',

		),

		// Referrers and tooltips.
		'footnotes_storage_custom'     => array(

			// Backlink symbol.
			self::C_STR_HYPERLINK_ARROW                    => '&#8593;',
			self::C_STR_HYPERLINK_ARROW_USER_DEFINED       => '',

			// Referrers.
			self::C_STR_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS => 'yes',
			self::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT => 'no',
			self::C_STR_FOOTNOTES_STYLING_BEFORE           => '[',
			self::C_STR_FOOTNOTES_STYLING_AFTER            => ']',

			// Referrers in labels.
			self::C_STR_FOOTNOTES_LABEL_ISSUE_SOLUTION     => 'none',

			// Tooltips.
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED   => 'yes',
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE => 'no',

			// Tooltip position.
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION  => 'top center',
			self::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION => 'top right',
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X  => 0,
			self::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X => -50,
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y  => -7,
			self::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y => 24,

			// Tooltip dimensions.
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH => 450,
			self::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH => 400,

			// Tooltip timing.
			self::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY       => 0,
			self::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION    => 200,
			self::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY      => 400,
			self::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION   => 200,

			// Tooltip truncation.
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED => 'yes',
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH => 200,
			self::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL     => 'Continue reading',

			// Tooltip text.
			self::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER => '[[/tooltip]]',
			self::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE => 'no',
			self::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR => ' — ',

			// Tooltip appearance.
			self::C_STR_MOUSE_OVER_BOX_FONT_SIZE_ENABLED   => 'yes',
			self::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR    => 13,
			self::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT      => 'px',

			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR     => '#000000',
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND => '#ffffff',
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH => 1,
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR => '#cccc99',
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS => 0,
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR => '#666666',

			// Your existing Custom CSS code.
			self::C_STR_CUSTOM_CSS                         => '',

		),

		// Scope and priority.
		'footnotes_storage_expert'     => array(

			// WordPress hooks with priority level.
			self::C_STR_EXPERT_LOOKUP_THE_TITLE    => '',
			self::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL => PHP_INT_MAX,

			self::C_STR_EXPERT_LOOKUP_THE_CONTENT  => 'checked',
			self::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL => 98,

			self::C_STR_EXPERT_LOOKUP_THE_EXCERPT  => '',
			self::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL => PHP_INT_MAX,

			self::C_STR_EXPERT_LOOKUP_WIDGET_TITLE => '',
			self::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL => PHP_INT_MAX,

			self::C_STR_EXPERT_LOOKUP_WIDGET_TEXT  => '',
			self::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL => 98,

		),

		// Custom CSS.
		'footnotes_storage_custom_css' => array(

			// Your existing Custom CSS code.
			self::C_STR_CUSTOM_CSS_LEGACY_ENABLE => 'yes',

			// Custom CSS.
			self::C_STR_CUSTOM_CSS_NEW           => '',

		),

	);

	/**
	 * Contains all Settings from each Settings container as soon as this class is initialized.
	 *
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_settings = array();

	/**
	 * Class Constructor. Loads all Settings from each WordPress Settings container.
	 *
	 * @since 1.5.0
	 */
	private function __construct() {
		$this->load_all();
	}

	/**
	 * Returns a singleton of this class.
	 *
	 * @since 1.5.0
	 * @return Footnotes_Settings
	 */
	public static function instance() {
		// No instance defined yet, load it.
		if ( ! self::$a_obj_instance ) {
			self::$a_obj_instance = new self();
		}
		// Return a singleton of this class.
		return self::$a_obj_instance;
	}

	/**
	 * Returns the name of a specified Settings Container.
	 *
	 * @since 1.5.0
	 * @param int $p_int_index Settings Container Array Key Index.
	 * @return str Settings Container name.
	 */
	public function get_container( $p_int_index ) {
		return $this->a_arr_container[ $p_int_index ];
	}

	/**
	 * Returns the default values of a specific Settings Container.
	 *
	 * @since 1.5.6
	 * @param int $p_int_index Settings Container Aray Key Index.
	 * @return array
	 */
	public function get_defaults( $p_int_index ) {
		return $this->a_arr_default[ $this->a_arr_container[ $p_int_index ] ];
	}

	/**
	 * Loads all Settings from each Settings container.
	 *
	 * @since 1.5.0
	 */
	private function load_all() {
		// Clear current settings.
		$this->a_arr_settings = array();
		$num_settings         = count( $this->a_arr_container );
		for ( $i = 0; $i < $num_settings; $i++ ) {
			// Load settings.
			$this->a_arr_settings = array_merge( $this->a_arr_settings, $this->load( $i ) );
		}
	}

	/**
	 * Loads all settings from specified settings container.
	 *
	 * @since 1.5.0
	 *
	 * - Bugfix: Removed the 'trim' function to allow leading and trailing whitespace in settings text boxes, thanks to @compasscare bug report.
	 *
	 * @reporter @compasscare
	 * @link https://wordpress.org/support/topic/leading-space-in-footnotes-tag/
	 *
	 * @since 1.5.2
	 * @param int $p_int_index  Settings container array key index.
	 * @return array            Settings loaded from defaults if container is empty (first usage).
	 */
	private function load( $p_int_index ) {
		// Load all settings from container.
		$l_arr_options = get_option( $this->get_container( $p_int_index ) );
		// Load all default settings.
		$l_arr_default = $this->a_arr_default[ $this->get_container( $p_int_index ) ];

		// No settings found, set them to their default value.
		if ( empty( $l_arr_options ) ) {
			return $l_arr_default;
		}
		// Iterate through all available settings ( = default values).
		foreach ( $l_arr_default as $l_str_key => $l_str_value ) {
			// Available setting not found in the container.
			if ( ! array_key_exists( $l_str_key, $l_arr_options ) ) {
				// Define the setting with its default value.
				$l_arr_options[ $l_str_key ] = $l_str_value;
			}
		}
		// Return settings loaded from Container.
		return $l_arr_options;
	}

	/**
	 * Updates a whole Settings container.
	 *
	 * @since 1.5.0
	 * @param int   $p_int_index Index of the Settings container.
	 * @param array $p_arr_new_values new Settings.
	 * @return bool
	 */
	public function save_options( $p_int_index, $p_arr_new_values ) {
		if ( update_option( $this->get_container( $p_int_index ), $p_arr_new_values ) ) {
			$this->load_all();
			return true;
		}
		return false;
	}

	/**
	 * Returns the value of specified Settings name.
	 *
	 * @since 1.5.0
	 * @param string $p_str_key Settings Array Key name.
	 * @return mixed Value of the Setting on Success or Null in Settings name is invalid.
	 */
	public function get( $p_str_key ) {
		return array_key_exists( $p_str_key, $this->a_arr_settings ) ? $this->a_arr_settings[ $p_str_key ] : null;
	}

	/**
	 * Deletes each Settings Container and loads the default values for each Settings Container.
	 *
	 * @since 1.5.0
	 *
	 * Edit: This didn’t actually work.
	 * @since 2.2.0 this function is not called any longer when deleting the plugin,
	 * to protect user data against loss, since manually updating a plugin is safer
	 * done by deleting and reinstalling (see the warning about database backup).
	 */
	public function clear_all() {
		// Iterate through each Settings Container.
		$num_settings = count( $this->a_arr_container );
		for ( $i = 0; $i < $num_settings; $i++ ) {
			// Delete the settings container.
			delete_option( $this->get_container( $i ) );
		}
		// Set settings back to the default values.
		$this->a_arr_settings = $this->a_arr_default;
	}

	/**
	 * Register all Settings Container for the Plugin Settings Page in the Dashboard.
	 * Settings Container Label will be the same as the Settings Container Name.
	 *
	 * @since 1.5.0
	 */
	public function register_settings() {
		// Register all settings.
		$num_settings = count( $this->a_arr_container );
		for ( $i = 0; $i < $num_settings; $i++ ) {
			register_setting( $this->get_container( $i ), $this->get_container( $i ) );
		}
	}
}
