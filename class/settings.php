<?php
/**
 * Includes the Settings class to handle all Plugin settings.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 10:43
 *
 *
 * @lastmodified 2021-02-19T1608+0100
 *
 * @since 2.0.4  restore arrow settings  2020-11-02T2115+0100
 * @since 2.0.7  remove hook the_post  2020-11-06T1342+0100
 * @since 2.1.0  add read-on button label customization  2020-11-08T2149+0100
 * @since 2.1.1  fix tooltips on site by alternative  2020-11-11T1819+0100
 * @since 2.1.1  fix disabling backlink symbol  2020-11-16T2021+0100
 * @since 2.1.1  fix superscript by making it optional
 * @since 2.1.1  fix start pages by option to hide ref container, thanks to @dragon013
 * @since 2.1.1  fix ref container by option restoring 3-column layout
 * @since 2.1.1  fix ref container by option to switch index/symbol  2020-11-16T2022+0100
 *
 * @since 2.1.3  excerpt hook: disable by default, thanks to @nikelaos
 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068
 *
 * @since 2.1.3  fix ref container positioning by priority level  2020-11-17T0205+0100
 *
 * @since 2.1.4  more settings container keys  2020-12-03T0955+0100
 *
 * @since 2.1.6  option to disable URL line wrapping   2020-12-09T1606+0100
 *
 * @since 2.1.6  set default priority level of the_content to 98 to prevent plugin conflict, thanks to @marthalindeman   2020-12-10T0447+0100
 *
 * @since 2.2.0  reference container custom position shortcode, thanks to @hamshe   2020-12-13T2056+0100
 * @link https://wordpress.org/support/topic/reference-container-in-elementor/
 *
 * @since 2.2.2  Custom CSS settings container migration  2020-12-15T0709+0100
 *
 * @since 2.2.4  move backlink symbol selection under previous tab  2020-12-16T1256+0100
 *
 * @since 2.2.5  alternative tooltip position settings  2020-12-17T0907+0100
 *
 * @since 2.2.5  options for reference container label element and bottom border, thanks to @markhillyer    2020-12-18T1455+0100
 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
 *
 * @since 2.2.9  set default priority level of widget_text to 98 like for the_content (since 2.1.6), thanks to @marthalindeman   2020-12-25T1646+0100
 *
 * @since 2.2.10 reference container row border option, thanks to @noobishh   2020-12-25T2316+0100
 * @link https://wordpress.org/support/topic/borders-25/
 *
 * @since 2.3.0  reference container: settings for top (and bottom) margin, thanks to @hamshe
 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
 *
 * @since 2.3.0  Bugfix: Dashboard: Custom CSS: swap migration Boolean, meaning 'show legacy' instead of 'migration complete', due to storage data structure constraints.
 * @date 2020-12-27T1243+0100

 * @since 2.3.0  referrers, reference container: settings for anchor slugs  2020-12-31T1429+0100
 *
 * @since 2.4.0  footnote shortcode syntax validation  2021-01-01T0624+0100
 */

/**
 * Loads the settings values, sets to default values if undefined.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Settings {

	/**
	 * Settings Container Key for the label of the reference container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_NAME = "footnote_inputfield_references_label";

	/**
	 * Settings Container Key to collapse the reference container by default.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 * The string is converted to Boolean false if 'no', true if 'yes'.
	 * @see MCI_Footnotes_Convert::toBool()
	 * The type in the variable name is useful to show the intention.
	 * @todo Eventually change misleading variable names C_BOOL_… to C_STR_… (that’s how Hungarian screws things up).
	 */
	const C_BOOL_REFERENCE_CONTAINER_COLLAPSE = "footnote_inputfield_collapse_references";

	/**
	 * Settings Container Key for the position of the reference container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_REFERENCE_CONTAINER_POSITION = "footnote_inputfield_reference_container_place";

	/**
	 * Settings Container Key for combining identical footnotes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_BOOL_COMBINE_IDENTICAL_FOOTNOTES = "footnote_inputfield_combine_identical";

	/**
	 * Settings Container Key for the short code of the footnote’s start.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_START = "footnote_inputfield_placeholder_start";

	/**
	 * Settings Container Key for the short code of the footnote’s end.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_END = "footnote_inputfield_placeholder_end";

	/**
	 * Settings Container Key for the user-defined short code of the footnotes start.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED = "footnote_inputfield_placeholder_start_user_defined";

	/**
	 * Settings Container Key for the user-defined short code of the footnotes end.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED = "footnote_inputfield_placeholder_end_user_defined";

	/**
	 * Settings Container Key for the counter style of the footnotes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_COUNTER_STYLE = "footnote_inputfield_counter_style";

	/**
	 * Settings Container Key for the 'I love footnotes' text.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_LOVE = "footnote_inputfield_love";

	/**
	 * Settings Container Key to look for footnotes in post excerpts.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_BOOL_FOOTNOTES_IN_EXCERPT = "footnote_inputfield_search_in_excerpt";

	/**
	 * Settings Container Key for the Expert mode.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.5
	 * @var str
	 *
	 * @since 2.1.6  This setting removed as irrelevant since priority level settings need permanent visibility.
	 * @date 2020-12-09T2107+0100
	 *
	 * Since the removal of the the_post hook, the tab is no danger zone any longer.
	 * All users, not experts only, need to be able to control relative positioning.
	 */
	const C_BOOL_FOOTNOTES_EXPERT_MODE = "footnote_inputfield_enable_expert_mode";

	/**
	 * Settings Container Key for the string before the footnote referrer.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 *
	 * The default footnote referrer surroundings should be square brackets:
	 *
	 * - with respect to baseline footnote referrers new option;
	 * - as in English or US American typesetting;
	 * - for better UX thanks to a more button-like appearance;
	 * - for stylistic consistency with the expand-collapse button.
	 *
	 */
	const C_STR_FOOTNOTES_STYLING_BEFORE = "footnote_inputfield_custom_styling_before";

	/**
	 * Settings Container Key for the string after the footnote referrer.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_FOOTNOTES_STYLING_AFTER = "footnote_inputfield_custom_styling_after";

	/**
	 * Settings Container Key to enable the mouse-over box.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.2
	 * @var str
	 */
	const C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED = "footnote_inputfield_custom_mouse_over_box_enabled";

	/**
	 * Settings Container Key to enable the alternative tooltips.
	 *
	 * - Bugfix: Tooltips: optional alternative JS implementation with CSS transitions to fix configuration-related outage, thanks to @andreasra feedback.
	 *
	 * @since 2.1.1
	 * @date 2020-11-11T1817+0100
	 *
	 * @reporter @andreasra
	 * @link https://wordpress.org/support/topic/footnotes-appearing-in-header/page/2/#post-13632566
	 *
	 * @var str
	 *
	 * These alternative tooltips work around a website related jQuery UI
	 * outage. They are low-script but use the AMP incompatible onmouseover
	 * and onmouseout arguments, along with CSS transitions for fade-in/out.
	 * The very small script is inserted after Footnotes’ internal stylesheet.
	 *
	 */
	const C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE = "footnote_inputfield_custom_mouse_over_box_alternative";

	/**
	 * Settings Container Key to enable tooltip truncation.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.4
	 * @var str
	 */
	const C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED = "footnote_inputfield_custom_mouse_over_box_excerpt_enabled";

	/**
	 * Settings Container Key for the mouse-over box to define the max. length of the enabled excerpt.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.4
	 * @var str
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH = "footnote_inputfield_custom_mouse_over_box_excerpt_length";

	/**
	 * Settings Container Key for the mouse-over box to define the position.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.7
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION = "footnote_inputfield_custom_mouse_over_box_position";

	/**
	 * Settings Container Key for the mouse-over box to define the offset (x).
	 *
	 * @author Stefan Herndler
	 * @since 1.5.7
	 * @var str
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X = "footnote_inputfield_custom_mouse_over_box_offset_x";

	/**
	 * Settings Container Key for the mouse-over box to define the offset (y).
	 *
	 * @author Stefan Herndler
	 * @since 1.5.7
	 * @var str
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y = "footnote_inputfield_custom_mouse_over_box_offset_y";

	/**
	 * Settings Container Key for the mouse-over box to define the color.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR = "footnote_inputfield_custom_mouse_over_box_color";

	/**
	 * Settings Container Key for the mouse-over box to define the background color.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND = "footnote_inputfield_custom_mouse_over_box_background";

	/**
	 * Settings Container Key for the mouse-over box to define the border width.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @var str
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH = "footnote_inputfield_custom_mouse_over_box_border_width";

	/**
	 * Settings Container Key for the mouse-over box to define the border color.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR = "footnote_inputfield_custom_mouse_over_box_border_color";

	/**
	 * Settings Container Key for the mouse-over box to define the border radius.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @var str
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS = "footnote_inputfield_custom_mouse_over_box_border_radius";

	/**
	 * Settings Container Key for the mouse-over box to define the max. width.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @var str
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH = "footnote_inputfield_custom_mouse_over_box_max_width";

	/**
	 * Settings Container Key for the mouse-over box to define the box-shadow color.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.8
	 * @var str
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR = "footnote_inputfield_custom_mouse_over_box_shadow_color";

	/**
	 * Settings Container Key for the backlink symbol selection.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_HYPERLINK_ARROW = "footnote_inputfield_custom_hyperlink_symbol";

	/**
	 * Settings Container Key for the user-defined backlink symbol.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 */
	const C_STR_HYPERLINK_ARROW_USER_DEFINED = "footnote_inputfield_custom_hyperlink_symbol_user";

	/**
	 * Settings Container Key for the Custom CSS.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var str
	 *
	 * @since 1.3.0  Adding: new settings tab for custom CSS settings.
	 */
	const C_STR_CUSTOM_CSS                = "footnote_inputfield_custom_css";

	/**
	 * Settings Container Key for the Custom CSS migrated to a dedicated tab.
	 *
	 * @since 2.2.2  Bugfix: Dashboard: Custom CSS: unearth text area and migrate to dedicated tab as designed.
	 * @date 2020-12-15T0520+0100
	 * @var str
	 */
	const C_STR_CUSTOM_CSS_NEW            = "footnote_inputfield_custom_css_new";

	/**
	 * Settings Container Key to enable display of legacy Custom CSS metaboxes.
	 *
	 * @since 2.2.2
	 * @date 2020-12-15T0520+0100
	 * @var str
	 *
	 * @since 2.3.0  swap Boolean from 'migration complete' to 'show legacy'
	 * @date 2020-12-27T1233+0100
	 *
	 * The Boolean must be false if its setting is contained in the container to be hidden,
	 * because when saving, all missing constants are emptied, and toBool() converts empty to false.
	 */
	const C_BOOL_CUSTOM_CSS_LEGACY_ENABLE = "footnote_inputfield_custom_css_legacy_enable";

	/**
	 * Settings Container Key to enable the 'the_title' hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.5
	 * @var str
	 */
	const C_BOOL_EXPERT_LOOKUP_THE_TITLE = "footnote_inputfield_expert_lookup_the_title";

	/**
	 * Settings Container Key to enable the 'the_content' hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.5
	 * @var str
	 */
	const C_BOOL_EXPERT_LOOKUP_THE_CONTENT = "footnote_inputfield_expert_lookup_the_content";

	/**
	 * Settings Container Key to enable the 'the_excerpt' hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.5
	 * @var str
	 */
	const C_BOOL_EXPERT_LOOKUP_THE_EXCERPT = "footnote_inputfield_expert_lookup_the_excerpt";

	/**
	 * Settings Container Key to enable the 'widget_title' hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.5
	 * @var str
	 */
	const C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE = "footnote_inputfield_expert_lookup_widget_title";

	/**
	 * Settings Container Key to enable the 'widget_text' hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.5
	 * @var str
	 */
	const C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT = "footnote_inputfield_expert_lookup_widget_text";

	/**
	 * Settings Container Key for the label of the Read-on button in truncated tooltips.
	 *
	 * - Adding: Tooltips: Read-on button: Label: configurable instead of localizable, thanks to @rovanov example provision.
	 *
	 * @since 2.1.0
	 * @date 2020-11-08T2106+0100
	 *
	 * @reporter @rovanov
	 * @link https://wordpress.org/support/topic/offset-x-axis-and-offset-y-axis-does-not-working/
	 *
	 * @var str
	 */
	const C_STR_FOOTNOTES_TOOLTIP_READON_LABEL = "footnote_inputfield_readon_label";

	/**
	 * Settings Container Key for the referrer element.
	 *
	 * - Bugfix: Referrers: new setting for vertical align: superscript (default) or baseline (optional), thanks to @cwbayer bug report.
	 *
	 * @since 2.1.1
	 * @date 2020-11-16T0859+0100
	 *
	 * @reporter @cwbayer
	 * @link https://wordpress.org/support/topic/footnote-number-in-text-superscript-disrupts-leading/
	 *
	 * @var str
	 */
	const C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS        = "footnotes_inputfield_referrer_superscript_tags";

	/**
	 * Settings Container Key to enable the display of a backlink symbol.
	 *
	 * - Bugfix: Reference container: Backlink symbol: make optional, not suggest configuring it to invisible, thanks to @spaceling feedback.
	 *
	 * @since 2.1.1
	 *
	 * @reporter @spaceling
	 * @link https://wordpress.org/support/topic/change-the-position-5/page/2/#post-13671138
	 *
	 * @var str
	 */
	const C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE = "footnotes_inputfield_reference_container_backlink_symbol_enable";

	/**
	 * Settings Container Key to not display the reference container on the homepage.
	 *
	 * - Bugfix: Reference container: fix start pages by making its display optional, thanks to @dragon013 bug report.
	 *
	 * @since 2.1.1
	 *
	 * @reporter @dragon013
	 * @link https://wordpress.org/support/topic/possible-to-hide-it-from-start-page/
	 *
	 * @var str
	 */
	const C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE      = "footnotes_inputfield_reference_container_start_page_enable";

	/**
	 * Settings Container Key to enable the legacy layout of the reference container.
	 *
	 * - Bugfix: Reference container: option to restore pre-2.0.0 layout with the backlink symbol in an extra column.
	 *
	 * @since 2.1.1
	 * @var str
	 */
	const C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE  = "footnotes_inputfield_reference_container_3column_layout_enable";

	/**
	 * Settings Container Key to get the backlink symbol switch side.
	 *
	 * - Bugfix: Reference container: option to append symbol (prepended by default), thanks to @spaceling code contribution.
	 *
	 * @since 2.1.1
	 * @date 2020-11-16T2024+0100
	 *
	 * @contributor @spaceling
	 * @link https://wordpress.org/support/topic/change-the-position-5/#post-13615994
	 *
	 * @var str
	 */
	const C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH = "footnotes_inputfield_reference_container_backlink_symbol_switch";

	/**
	 * Settings Container Key for 'the_content' hook priority level.
	 *
	 * @since 2.1.1
	 * @date 2020-11-16T0859+0100
	 *
	 * @var str
	 */
	const C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL  = "footnote_inputfield_expert_lookup_the_content_priority_level";

	/**
	 * Settings Container Key for '' hook priority level
	 *
	 * @since 2.1.2
	 * @date 2020-11-20T0620+0100
	 *
	 * @var str
	 */
	const C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL    = "footnote_inputfield_expert_lookup_the_title_priority_level";
	const C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL = "footnote_inputfield_expert_lookup_widget_title_priority_level";
	const C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL  = "footnote_inputfield_expert_lookup_widget_text_priority_level";
	const C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL  = "footnote_inputfield_expert_lookup_the_excerpt_priority_level";

	/**
	 * Settings Container Keys for the link element option
	 * Settings Container Keys for backlink typography and layout
	 * Settings Container Keys for tooltip font size
	 * Settings Container Keys for page layout support
	 * Settings Container Keys for scroll offset and duration
	 * Settings Container Keys for tooltip display durations
	 *
	 * @since 2.1.4
	 * @var str|bool|int|flo
	 *
	 * 2020-11-26T1002+0100
	 * 2020-11-30T0427+0100
	 * 2020-12-03T0501+0100
	 * 2020-12-05T0425+0100
	 */

	// link element option:
	const C_BOOL_LINK_ELEMENT_ENABLED               =  "footnote_inputfield_link_element_enabled";

	// backlink typography:
	const C_BOOL_BACKLINKS_SEPARATOR_ENABLED        = "footnotes_inputfield_backlinks_separator_enabled";
	const C_STR_BACKLINKS_SEPARATOR_OPTION          = "footnotes_inputfield_backlinks_separator_option";
	const C_STR_BACKLINKS_SEPARATOR_CUSTOM          = "footnotes_inputfield_backlinks_separator_custom";
	const C_BOOL_BACKLINKS_TERMINATOR_ENABLED       = "footnotes_inputfield_backlinks_terminator_enabled";
	const C_STR_BACKLINKS_TERMINATOR_OPTION         = "footnotes_inputfield_backlinks_terminator_option";
	const C_STR_BACKLINKS_TERMINATOR_CUSTOM         = "footnotes_inputfield_backlinks_terminator_custom";

	// backlink layout:
	const C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED     = "footnotes_inputfield_backlinks_column_width_enabled";
	const C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR       = "footnotes_inputfield_backlinks_column_width_scalar";
	const C_STR_BACKLINKS_COLUMN_WIDTH_UNIT         = "footnotes_inputfield_backlinks_column_width_unit";
	const C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED = "footnotes_inputfield_backlinks_column_max_width_enabled";
	const C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR   = "footnotes_inputfield_backlinks_column_max_width_scalar";
	const C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT     = "footnotes_inputfield_backlinks_column_max_width_unit";
	const C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED      = "footnotes_inputfield_backlinks_line_breaks_enabled";

	// tooltip font size:
	// called mouse over box not tooltip for consistency
	const C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED   = "footnotes_inputfield_mouse_over_box_font_size_enabled";
	const C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR     = "footnotes_inputfield_mouse_over_box_font_size_scalar";
	const C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT       = "footnotes_inputfield_mouse_over_box_font_size_unit";

	// page layout support:
	const C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT       = "footnotes_inputfield_page_layout_support";

	/**
	 * Scroll offset and duration
	 *
	 * - Bugfix: Scroll offset: make configurable to fix site-dependent issues related to fixed headers.
	 * - Bugfix: Scroll duration: make configurable to conform to website content and style requirements.
	 *
	 * @since 2.1.4
	 * @date 2020-12-05T0538+0100
	 */
	// scroll offset and duration:
	const C_INT_FOOTNOTES_SCROLL_OFFSET             = "footnotes_inputfield_scroll_offset";
	const C_INT_FOOTNOTES_SCROLL_DURATION           = "footnotes_inputfield_scroll_duration";

	// tooltip display durations:
	// called mouse over box not tooltip for consistency
	const C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY        = "footnotes_inputfield_mouse_over_box_fade_in_delay";
	const C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION     = "footnotes_inputfield_mouse_over_box_fade_in_duration";
	const C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY       = "footnotes_inputfield_mouse_over_box_fade_out_delay";
	const C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION    = "footnotes_inputfield_mouse_over_box_fade_out_duration";

	/**
	 * Settings Container Key for URL wrap option
	 *
	 * This is made optional because it causes weird line breaks.
	 * Unicode-compliant browsers break URLs at slashes.
	 *
	 * @since 2.1.6
	 * @var str
	 *
	 * 2020-12-09T1554+0100..2020-12-13T1313+0100
	 */
	const C_BOOL_FOOTNOTE_URL_WRAP_ENABLED          =  "footnote_inputfield_url_wrap_enabled";

	/**
	 * Settings Container Key for reference container position shortcode
	 *
	 * @since 2.2.0
	 * @var str
	 *
	 * 2020-12-13T2056+0100
	 */
	const C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE  =  "footnote_inputfield_reference_container_position_shortcode";

	/**
	 * Settings Container Keys for alternative tooltip position
	 * Settings Container Keys for reference container label element, thanks to @markhillyer
	 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
	 *
	 * @since 2.2.5
	 * @var int
	 *
	 * 2020-12-17T0746+0100
	 * 2020-12-18T1509+0100
	 */
	const C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION = "footnotes_inputfield_alternative_mouse_over_box_position";
	const C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X = "footnotes_inputfield_alternative_mouse_over_box_offset_x";
	const C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y = "footnotes_inputfield_alternative_mouse_over_box_offset_y";
	const C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH    = "footnotes_inputfield_alternative_mouse_over_box_width";

	const C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT             = "footnotes_inputfield_reference_container_label_element";
	const C_BOOL_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER      = "footnotes_inputfield_reference_container_label_bottom_border";

	/**
	 * Settings Container Key for table cell borders, thanks to @noobishh
	 * @link https://wordpress.org/support/topic/borders-25/
	 *
	 * @since 2.2.10
	 * @var str
	 *
	 * 2020-12-25T2311+0100
	 */
	const C_BOOL_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE      = "footnotes_inputfield_reference_container_row_borders_enable";

	/**
	 * Settings container keys for reference container top and bottom margins
	 * Settings container keys for hard link enabling
	 * Settings container keys for hard link anchors in referrers and footnotes
	 *
	 * @since 2.3.0
	 * @var int|bool|str
	 *
	 * 2020-12-29T0914+0100
	 */
	const C_INT_REFERENCE_CONTAINER_TOP_MARGIN    = "footnotes_inputfield_reference_container_top_margin";
	const C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN = "footnotes_inputfield_reference_container_bottom_margin";
	const C_BOOL_FOOTNOTES_HARD_LINKS_ENABLE      = "footnotes_inputfield_hard_links_enable";
	const C_STR_REFERRER_FRAGMENT_ID_SLUG         = "footnotes_inputfield_referrer_fragment_id_slug";
	const C_STR_FOOTNOTE_FRAGMENT_ID_SLUG         = "footnotes_inputfield_footnote_fragment_id_slug";
	const C_STR_HARD_LINK_IDS_SEPARATOR           = "footnotes_inputfield_hard_link_ids_separator";

	/**
	 * Settings container key for shortcode syntax validation.
	 *
	 * @since 2.4.0
	 * @date 2021-01-01T0616+0100
	 *
	 * @var str
	 */
	const C_BOOL_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE = "footnotes_inputfield_shortcode_syntax_validation_enable";

	/**
	 * Settings container key to enable backlink tooltips.
	 *
	 * - Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
	 *
	 * @since 2.5.4
	 *
	 * @reporter @theroninjedi47
	 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
	 *
	 * When hard links are enabled, clicks on the backlinks are logged in the browsing history,
	 * along with clicks on the referrers.
	 * This tooltip hints to use the backbutton instead, so the history gets streamlined again.
	 * @link https://wordpress.org/support/topic/making-it-amp-compatible/#post-13837359
	 *
	 * @var str
	 */
	const C_BOOL_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE = "footnotes_inputfield_backlink_tooltip_enable";

	/**
	 * Settings container key to configure the backlink tooltip.
	 *
	 * - Update: Reference container: Hard backlinks (optional): optional configurable tooltip hinting to use the backbutton instead, thanks to @theroninjedi47 bug report.
	 *
	 * @since 2.5.4
	 *
	 * @reporter @theroninjedi47
	 * @link https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/
	 *
	 * @var str
	 */
	const C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT = "footnotes_inputfield_backlink_tooltip_text";

	/**
	 * Settings container key to configure the tooltip excerpt delimiter.
	 *
	 * - Update: Tooltips: ability to display dedicated content before `[[/tooltip]]`, thanks to @jbj2199 issue report.
	 *
	 * The first implementation used a fixed shortcode provided in the changelog.
	 * But Footnotes’ UI design policy is to make shortcodes freely configurable.
	 * @since 2.5.4
	 *
	 * @reporter @jbj2199
	 * @link https://wordpress.org/support/topic/change-tooltip-text/
	 *
	 * Tooltips can display another content than the footnote entry
	 * in the reference container. The trigger is a shortcode in
	 * the footnote text separating the tooltip text from the note.
	 * That is consistent with what WordPress does for excerpts.
	 *
	 * @var str
	 */
	const C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER = "footnotes_inputfield_tooltip_excerpt_delimiter";

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
	const C_BOOL_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE = "footnotes_inputfield_tooltip_excerpt_mirror_enable";

	/**
	 * Settings container key to configure the tooltip excerpt separator in the reference container.
	 *
	 * @since 2.5.4
	 * @var str
	 */
	const C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR = "footnotes_inputfield_tooltip_excerpt_mirror_separator";

	/**
	 * Settings container key to enable superscript style normalization.
	 *
	 * -Bugfix: Referrers: optional fixes to vertical alignment, font size and position (static) for in-theme consistency and cross-theme stability, thanks to @tomturowski bug report.
	 *
	 * @since 2.5.4
	 *
	 * @reporter @tomturowski
	 * @link https://wordpress.org/support/topic/in-line-superscript-ref-rides-to-high/
	 *
	 * @var str
	 */
	const C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT = "footnotes_inputfield_referrers_normal_superscript";

	/**
	 * Settings container key to select the script mode for the reference container.
	 *
	 * - Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
	 *
	 * @since 2.5.6
	 *
	 * @reporter @hopper87it
	 * @link https://wordpress.org/support/topic/footnotes-wp-rocket/
	 *
	 * @var str
	 */
	const C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE = "footnotes_inputfield_reference_container_script_mode";


	/**
	 *      SETTINGS STORAGE
	 */

	/**
	 * Stores a singleton reference of this class.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @var MCI_Footnotes_Settings
	 */
	private static $a_obj_Instance = null;

	/**
	 * Contains all Settings Container names.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 *
	 * Edited:
	 * 2.2.2  added tab for Custom CSS  2020-12-15T0740+0100
	 *
	 * These are the storage container names, one per dashboard tab.
	 */
	private $a_arr_Container = array(
		"footnotes_storage",
		"footnotes_storage_custom",
		"footnotes_storage_expert",
		"footnotes_storage_custom_css",
	);

	/**
	 * Contains all Default Settings for each Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 *
	 * Edited multiple times.
	 *
	 * @since 2.1.3  excerpt hook: disable by default, thanks to @nikelaos
	 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068
	 */
	private $a_arr_Default = array(

		"footnotes_storage" => array(

			self::C_STR_FOOTNOTES_SHORT_CODE_START                    => '((',
			self::C_STR_FOOTNOTES_SHORT_CODE_END                      => '))',
			self::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED       => '',
			self::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED         => '',

			self::C_BOOL_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE  => 'yes',

			self::C_STR_FOOTNOTES_COUNTER_STYLE                       => 'arabic_plain',
			self::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES                  => 'yes',

			self::C_BOOL_FOOTNOTES_HARD_LINKS_ENABLE                  => 'no',
			self::C_STR_REFERRER_FRAGMENT_ID_SLUG                     => 'r',
			self::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG                     => 'f',
			self::C_STR_HARD_LINK_IDS_SEPARATOR                       => '+',
			self::C_INT_FOOTNOTES_SCROLL_OFFSET                       => 20,
			self::C_INT_FOOTNOTES_SCROLL_DURATION                     => 380,

			// 2.5.4 fast-tracked:
			self::C_BOOL_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE            => 'yes',
			self::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT               => 'Alt+ ←',


			self::C_STR_REFERENCE_CONTAINER_NAME                      => 'References',
			self::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT             => 'p',
			self::C_BOOL_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER      => 'yes',
			self::C_BOOL_REFERENCE_CONTAINER_COLLAPSE                 => 'no',
			self::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE     => 'jquery',

			self::C_STR_REFERENCE_CONTAINER_POSITION                  => 'post_end',
			self::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE        => '[[references]]',
			self::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE        => 'yes',

			// whether to enqueue additional stylesheet:
			self::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT                 => 'none',

			// top and bottom margins:
			self::C_INT_REFERENCE_CONTAINER_TOP_MARGIN                => 24,
			self::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN             =>  0,

			// table cell borders:
			self::C_BOOL_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE       => 'no',

			// backlink symbol:
			self::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE    => 'no',
			self::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE   => 'yes',
			self::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH   => 'no',

			// backlink separators and terminators are often not preferred.
			// but a choice must be provided along with the ability to customize:
			self::C_BOOL_BACKLINKS_SEPARATOR_ENABLED                  => 'yes',
			self::C_STR_BACKLINKS_SEPARATOR_OPTION                    => 'comma',
			self::C_STR_BACKLINKS_SEPARATOR_CUSTOM                    => '',
			self::C_BOOL_BACKLINKS_TERMINATOR_ENABLED                 => 'no',
			self::C_STR_BACKLINKS_TERMINATOR_OPTION                   => 'full_stop',
			self::C_STR_BACKLINKS_TERMINATOR_CUSTOM                   => '',

			// set backlinks column width:
			self::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED               => 'no',
			self::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR                 => '50',
			self::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT                   => 'px',

			// set backlinks column max. width:
			self::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED           => 'no',
			self::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR             => '140',
			self::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT               => 'px',

			// whether a <br /> tag is inserted:
			self::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED                => 'no',

			// whether to enable URL line wrapping:
			self::C_BOOL_FOOTNOTE_URL_WRAP_ENABLED                    => 'yes',

			// whether to use link elements:
			self::C_BOOL_LINK_ELEMENT_ENABLED                         => 'yes',

			// excerpt should be disabled:
			self::C_BOOL_FOOTNOTES_IN_EXCERPT                         => 'no',

			self::C_BOOL_FOOTNOTES_EXPERT_MODE                        => 'yes',

			self::C_STR_FOOTNOTES_LOVE                                => 'no',

		),

		"footnotes_storage_custom" => array(

			self::C_STR_HYPERLINK_ARROW                               => '&#8593;',
			self::C_STR_HYPERLINK_ARROW_USER_DEFINED                  => '',

			self::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL                => 'Continue reading',

			self::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS          => 'yes',

			self::C_STR_FOOTNOTES_STYLING_BEFORE                      => '[',
			self::C_STR_FOOTNOTES_STYLING_AFTER                       => ']',

			self::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED             => 'yes',

			self::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE         => 'no',

			// The mouse over content truncation should be enabled by default
			// to raise awareness of the functionality and to prevent the screen
			// from being filled at mouse-over, and to allow the Continue reading:
			self::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED     => 'yes',

			// The truncation length is raised from 150 to 200 chars:
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH       => 200,

			// 2.5.4 fast-tracked:
			self::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER           => '[[/tooltip]]',
			self::C_BOOL_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE      => 'no',
			self::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR   => ' — ',
			self::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT   => 'no',


			// The default position should not be lateral because of the risk
			// the box gets squeezed between note anchor at line end and window edge,
			// and top because reading at the bottom of the window is more likely:
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION             => 'top center',

			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X             => 0,
			// The vertical offset must be negative for the box not to cover
			// the current line of text (web coordinates origin is top left):
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y             => -7,

			// The width should be limited to start with, for the box to have shape:
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH            => 450,

			// fixed width is for alternative tooltips, cannot reuse max-width nor offsets:
			self::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION => 'top right',
			self::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X => -50,
			self::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y =>  24,
			self::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH    => 400,

			// tooltip display durations:
			// called mouse over box not tooltip for consistency
			self::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY                  =>   0,
			self::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION               => 200,
			self::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY                 => 400,
			self::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION              => 200,

			// tooltip font size reset to legacy by default since 2.1.4;
			// was set to inherit since 2.1.1 as it overrode custom CSS,
			// is moved to settings since 2.1.4    2020-12-04T1023+0100
			self::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED             => 'yes',
			self::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR               => 13,
			self::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT                 => 'px',

			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR                => '',
			// The mouse over box shouldn’t feature a colored background
			// by default, due to diverging user preferences. White is neutral:
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND           => '#ffffff',

			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH         => 1,
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR         => '#cccc99',

			// The mouse over box corners mustn’t be rounded as that is outdated:
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS        => 0,

			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR         => '#666666',

			// Custom CSS migrates to a dedicated tab:
			self::C_STR_CUSTOM_CSS                                    => '',

		),

		"footnotes_storage_expert" => array(

			// These are checkboxes; keyword 'checked' is converted to Boolean true,
			// empty string to false (default):

			// Titles should all be enabled by default to prevent users from
			// thinking at first that the feature is broken in post titles.
			// See <https://wordpress.org/support/topic/more-feature-ideas/>
			// Yet in titles, footnotes are still buggy, because WordPress
			// uses the title string in menus and in the title element.
			self::C_BOOL_EXPERT_LOOKUP_THE_TITLE                      => '',

			self::C_BOOL_EXPERT_LOOKUP_THE_CONTENT                    => 'checked',

			// And the_excerpt is disabled by default following @nikelaos in
			// <https://wordpress.org/support/topic/jquery-comes-up-in-feed-content/#post-13110879>
			// <https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068>
			self::C_BOOL_EXPERT_LOOKUP_THE_EXCERPT                    => '',

			self::C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE                   => '',

			// The widget_text hook must be disabled by default, because it causes
			// multiple reference containers to appear in Elementor accordions, but
			// it must be enabled if multiple reference containers are desired, as
			// in Elementor toggles.
			self::C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT                    => '',

			// initially hard-coded default
			// shows "9223372036854780000" instead of 9223372036854775807 in the numbox
			// empty should be interpreted as PHP_INT_MAX, but a numbox cannot be set to empty:
			// <https://github.com/Modernizr/Modernizr/issues/171>
			// interpret -1 as PHP_INT_MAX instead
			self::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL        => PHP_INT_MAX,

			// Priority level of the_content and of widget_text as the only relevant
			// hooks must be less than 99 because social buttons may yield scripts
			// that contain the strings '((' and '))', i.e. the default footnote
			// start and end short codes, causing issues with fake footnotes.
			self::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL      => 98,
			self::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL      => PHP_INT_MAX,
			self::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL     => PHP_INT_MAX,
			self::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL      => 98,

		),

		"footnotes_storage_custom_css" => array(

			self::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE                     => 'yes',
			self::C_STR_CUSTOM_CSS_NEW                                => '',

		),

	);

	/**
	 * Contains all Settings from each Settings container as soon as this class is initialized.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_Settings = array();

	/**
	 * Class Constructor. Loads all Settings from each WordPress Settings container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function __construct() {
		$this->loadAll();
	}

	/**
	 * Returns a singleton of this class.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return MCI_Footnotes_Settings
	 */
	public static function instance() {
		// no instance defined yet, load it
		if (self::$a_obj_Instance === null) {
			self::$a_obj_Instance = new self();
		}
		// return a singleton of this class
		return self::$a_obj_Instance;
	}

	/**
	 * Returns the name of a specified Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Settings Container Array Key Index.
	 * @return str Settings Container name.
	 */
	public function getContainer($p_int_Index) {
		return $this->a_arr_Container[$p_int_Index];
	}

	/**
	 * Returns the default values of a specific Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.6
	 * @param int $p_int_Index Settings Container Aray Key Index.
	 * @return array
	 */
	public function getDefaults($p_int_Index) {
		return $this->a_arr_Default[$this->a_arr_Container[$p_int_Index]];
	}

	/**
	 * Loads all Settings from each Settings container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function loadAll() {
		// clear current settings
		$this->a_arr_Settings = array();
		for ($i = 0; $i < count($this->a_arr_Container); $i++) {
			// load settings
			$this->a_arr_Settings = array_merge($this->a_arr_Settings, $this->Load($i));
		}
	}

	/**
	 * Loads all Settings from specified Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Settings Container Array Key Index.
	 * @return array Settings loaded from Container of Default Settings if Settings Container is empty (first usage).
	 *
	 * @since   ditched trimming whitespace from text box content in response to user request.
	 * @link https://wordpress.org/support/topic/leading-space-in-footnotes-tag/#post-5347966
	 */
	private function Load($p_int_Index) {
		// load all settings from container
		$l_arr_Options = get_option($this->getContainer($p_int_Index));
		// load all default settings
		$l_arr_Default = $this->a_arr_Default[$this->getContainer($p_int_Index)];

		// no settings found, set them to their default value
		if (empty($l_arr_Options)) {
			return $l_arr_Default;
		}
		// iterate through all available settings ( = default values)
		foreach($l_arr_Default as $l_str_Key => $l_str_Value) {
			// available setting not found in the container
			if (!array_key_exists($l_str_Key, $l_arr_Options)) {
				// define the setting with its default value
				$l_arr_Options[$l_str_Key] = $l_str_Value;
			}
		}
		// iterate through each setting in the container
		foreach($l_arr_Options as $l_str_Key => $l_str_Value) {
			// remove all whitespace at the beginning and end of a setting
			// trimming whitespace is ditched:
			//$l_str_Value = trim($l_str_Value);
			// write the sanitized value back to the setting container
			$l_arr_Options[$l_str_Key] = $l_str_Value;
		}
		// return settings loaded from Container
		return $l_arr_Options;
	}

	/**
	 * Updates a whole Settings container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Index of the Settings container.
	 * @param array $p_arr_newValues new Settings.
	 * @return bool
	 */
	public function saveOptions($p_int_Index, $p_arr_newValues) {
		if (update_option($this->getContainer($p_int_Index), $p_arr_newValues)) {
			$this->loadAll();
			return true;
		}
		return false;
	}

	/**
	 * Returns the value of specified Settings name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Key Settings Array Key name.
	 * @return mixed Value of the Setting on Success or Null in Settings name is invalid.
	 */
	public function get($p_str_Key) {
		return array_key_exists($p_str_Key, $this->a_arr_Settings) ? $this->a_arr_Settings[$p_str_Key] : null;
	}

	/**
	 * Deletes each Settings Container and loads the default values for each Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 *
	 * Edit: This didn’t actually work.
	 * @since 2.2.0 this function is not called any longer when deleting the plugin,
	 * to protect user data against loss, since manually updating a plugin is safer
	 * done by deleting and reinstalling (see the warning about database backup).
	 * 2020-12-13T1353+0100
	 */
	public function ClearAll() {
		// iterate through each Settings Container
		for ($i = 0; $i < count($this->a_arr_Container); $i++) {
			// delete the settings container
			delete_option($this->getContainer($i));
		}
		// set settings back to the default values
		$this->a_arr_Settings = $this->a_arr_Default;
	}

	/**
	 * Register all Settings Container for the Plugin Settings Page in the Dashboard.
	 * Settings Container Label will be the same as the Settings Container Name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function RegisterSettings() {
		// register all settings
		for ($i = 0; $i < count($this->a_arr_Container); $i++) {
			register_setting($this->getContainer($i), $this->getContainer($i));
		}
	}
}
