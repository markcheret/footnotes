<?php // phpcs:disable Squiz.Commenting.FileComment.Missing
/**
 * File providing the `Setting` class.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed file from `settings.php` to `class-settings.php`.
 *              Renamed parent `class/` directory to `includes/`.
 */

declare(strict_types=1);

namespace footnotes\includes;

/**
 * Provides data conversion methods.
 *
 * @todo Move to {@see Loader}.
 */
require_once plugin_dir_path( __DIR__ ) . 'includes/class-convert.php';

/**
 * Class defining configurable plugin settings.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed class from `Footnotes_Settings` to `Settings`.
 *                          Moved under `footnotes\includes` namespace.
 */
class Settings {
	/**
	 * Settings container key for the label of the reference container.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const REFERENCE_CONTAINER_NAME = 'footnote_inputfield_references_label';

	/**
	 * Settings container key to collapse the reference container by default.
	 *
	 * The string is converted to Boolean false if 'no', true if 'yes'.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor to use sane typing.
	 */
	const REFERENCE_CONTAINER_COLLAPSE = 'footnote_inputfield_collapse_references';

	/**
	 * Settings container key for the position of the reference container.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const REFERENCE_CONTAINER_POSITION = 'footnote_inputfield_reference_container_place';

	/**
	 * Settings container key for combining identical footnotes.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const COMBINE_IDENTICAL_FOOTNOTES = 'footnote_inputfield_combine_identical';

	/**
	 * Settings container key for the short code of the footnote's start.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_SHORT_CODE_START = 'footnote_inputfield_placeholder_start';

	/**
	 * Settings container key for the short code of the footnote's end.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_SHORT_CODE_END = 'footnote_inputfield_placeholder_end';

	/**
	 * Settings container key for the user-defined short code of the footnotes start.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_SHORT_CODE_START_USER_DEFINED = 'footnote_inputfield_placeholder_start_user_defined';

	/**
	 * Settings container key for the user-defined short code of the footnotes end.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_SHORT_CODE_END_USER_DEFINED = 'footnote_inputfield_placeholder_end_user_defined';

	/**
	 * Settings container key for the counter style of the footnotes.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_COUNTER_STYLE = 'footnote_inputfield_counter_style';

	/**
	 * Settings container key for the backlink symbol selection.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const HYPERLINK_ARROW = 'footnote_inputfield_custom_hyperlink_symbol';

	/**
	 * Settings container key for the user-defined backlink symbol.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const HYPERLINK_ARROW_USER_DEFINED = 'footnote_inputfield_custom_hyperlink_symbol_user';

	/**
	 * Settings container key to look for footnotes in post excerpts.
	 *
	 * @see  EXPERT_LOOKUP_THE_EXCERPT
	 * @var  string
	 *
	 * @since  1.5.0
	 * @since  2.6.3  Enabled by default.
	 */
	const FOOTNOTES_IN_EXCERPT = 'footnote_inputfield_search_in_excerpt';

	/**
	 * Settings container key for the string before the footnote referrer.
	 *
	 * The default footnote referrer surroundings should be square brackets, as
	 * in English or US American typesetting, for better UX thanks to a more
	 * button-like appearance, as well as for stylistic consistency with the
	 * expand-collapse button.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_STYLING_BEFORE = 'footnote_inputfield_custom_styling_before';

	/**
	 * Settings container key for the string after the footnote referrer.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_STYLING_AFTER = 'footnote_inputfield_custom_styling_after';

	/**
	 * Settings container key for the Custom CSS.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const CUSTOM_CSS = 'footnote_inputfield_custom_css';

	/**
	 * Settings container key for the ‘I love footnotes’ text.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const FOOTNOTES_LOVE = 'footnote_inputfield_love';

	/**
	 * Settings container key to enable the mouse-over box.
	 *
	 * @var  string
	 *
	 * @since  1.5.2
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_ENABLED = 'footnote_inputfield_custom_mouse_over_box_enabled';

	/**
	 * Settings container key to enable tooltip truncation.
	 *
	 * @var  string
	 *
	 * @since  1.5.4
	 * @todo  The mouse-over content truncation should be enabled by default to raise
	 *              awareness of the functionality, prevent the screen from being filled on
	 *              mouse-over, and allow the use of ‘Continue Reading’ functionality.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED = 'footnote_inputfield_custom_mouse_over_box_excerpt_enabled';

	/**
	 * Settings container key for the mouse-over box to define the max. length of
	 * the enabled excerpt.
	 *
	 * The default truncation length is 200 chars.
	 *
	 * @var  int
	 *
	 * @since  1.5.4
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH = 'footnote_inputfield_custom_mouse_over_box_excerpt_length';

	/**
	 * Settings container key to enable the `the_title` hook.
	 *
	 * These are checkboxes; the keyword `checked` is converted to `true`, whilst
	 * an empty string (the default) is converted to `false`.
	 *
	 * Hooks should all be enabled by default to prevent users from thinking at
	 * first that the feature is broken in post titles (see {@link
	 * https://wordpress.org/support/topic/more-feature-ideas/ here} for more
	 * information).
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 * @todo  In titles, footnotes are still buggy, because WordPress uses the
	 *              title string in menus and in the title element, but Footnotes doesn't
	 *              delete footnotes in them.
	 */
	const EXPERT_LOOKUP_THE_TITLE = 'footnote_inputfield_expert_lookup_the_title';

	/**
	 * Settings container key to enable the `the_content` hook.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 */
	const EXPERT_LOOKUP_THE_CONTENT = 'footnote_inputfield_expert_lookup_the_content';

	/**
	 * Settings container key to enable the `the_excerpt` hook.
	 *
	 * @var  string
	 *
	 * @see FOOTNOTES_IN_EXCERPT
	 *
	 * @since  1.5.5
	 * @since  2.6.3  Enable by default.
	 */
	const EXPERT_LOOKUP_THE_EXCERPT = 'footnote_inputfield_expert_lookup_the_excerpt';

	/**
	 * Settings container key to enable the `widget_title` hook.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 */
	const EXPERT_LOOKUP_WIDGET_TITLE = 'footnote_inputfield_expert_lookup_widget_title';

	/**
	 * Settings container key to enable the `widget_text` hook.
	 *
	 * The `widget_text` hook must be disabled by default, because it causes
	 * multiple reference containers to appear in Elementor accordions, but
	 * it must be enabled if multiple reference containers are desired, as
	 * in Elementor toggles.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 */
	const EXPERT_LOOKUP_WIDGET_TEXT = 'footnote_inputfield_expert_lookup_widget_text';

	/**
	 * Settings container key for the Expert mode.
	 *
	 * Since the removal of the `the_post` hook, the tab is no danger zone any longer.
	 * All users, not experts only, need to be able to control relative positioning.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 * @since  2.1.6  Setting deprecated.
	 * @deprecated
	 * @todo  Un-deprecate.
	 */
	const FOOTNOTES_EXPERT_MODE = 'footnote_inputfield_enable_expert_mode';

	/**
	 * Settings container key for the mouse-over box to define the color.
	 *
	 * @var  string
	 *
	 * @see FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND
	 *
	 * @since  1.5.6
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_COLOR = 'footnote_inputfield_custom_mouse_over_box_color';

	/**
	 * Settings container key for the mouse-over box to define the background color.
	 *
	 * Theme default background color is best, but theme default background color
	 * doesn't seem to exist.
	 *
	 * The default is currently `#ffffff` with `#000000` as the text color.
	 *
	 * @var  string
	 *
	 * @see FOOTNOTES_MOUSE_OVER_BOX_COLOR
	 *
	 * @since  1.5.6
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND = 'footnote_inputfield_custom_mouse_over_box_background';

	/**
	 * Settings container key for the mouse-over box to define the border width.
	 *
	 * @var  int
	 *
	 * @since  1.5.6
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH = 'footnote_inputfield_custom_mouse_over_box_border_width';

	/**
	 * Settings container key for the mouse-over box to define the border color.
	 *
	 * @var  string
	 *
	 * @since  1.5.6
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR = 'footnote_inputfield_custom_mouse_over_box_border_color';

	/**
	 * Settings container key for the mouse-over box to define the border radius.
	 *
	 * @var  int
	 *
	 * @since  1.5.6
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS = 'footnote_inputfield_custom_mouse_over_box_border_radius';

	/**
	 * Settings container key for the mouse-over box to define the max. width.
	 *
	 * The width should be limited to start with, for the box to have shape.
	 *
	 * The default width is 450.
	 *
	 * @var  int
	 *
	 * @since  1.5.6
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH = 'footnote_inputfield_custom_mouse_over_box_max_width';

	/**
	 * Settings container key for the mouse-over box to define the position.
	 *
	 * The default position should not be lateral because of the risk
	 * the box gets squeezed between note anchor at line end and window edge,
	 * and top because reading at the bottom of the window is more likely.
	 *
	 * @var  string
	 *
	 * @since  1.5.7
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_POSITION = 'footnote_inputfield_custom_mouse_over_box_position';

	/**
	 * Settings container key for the mouse-over box to define the _x_-offset.
	 *
	 * @var  int
	 *
	 * @since  1.5.7
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X = 'footnote_inputfield_custom_mouse_over_box_offset_x';

	/**
	 * Settings container key for the mouse-over box to define the _y_-offset.
	 *
	 * The vertical offset must be negative for the box not to cover the current
	 * line of text.
	 *
	 * @var  int
	 *
	 * @since  1.5.7
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y = 'footnote_inputfield_custom_mouse_over_box_offset_y';

	/**
	 * Settings container key for the mouse-over box to define the box-shadow color.
	 *
	 * @var  string
	 *
	 * @since  1.5.8
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR = 'footnote_inputfield_custom_mouse_over_box_shadow_color';

	/**
	 * Settings container key for the label of the Read-on button in truncated tooltips.
	 *
	 * @var  string
	 *
	 * @since  2.1.0
	 */
	const FOOTNOTES_TOOLTIP_READON_LABEL = 'footnote_inputfield_readon_label';

	/**
	 * Settings container key to enable the alternative tooltips.
	 *
	 * These alternative tooltips work around a website-related jQuery UI
	 * outage. They are low-script but use the AMP-incompatible `onmouseover`
	 * and `onmouseout` arguments, along with CSS transitions for fade-in/out.
	 * The very small script is inserted after the plugin's internal stylesheet.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE = 'footnote_inputfield_custom_mouse_over_box_alternative';

	/**
	 * Settings container key for the referrer element.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 */
	const FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS = 'footnotes_inputfield_referrer_superscript_tags';

	/**
	 * Settings container key to enable the display of a backlink symbol.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 */
	const REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE = 'footnotes_inputfield_reference_container_backlink_symbol_enable';

	/**
	 * Settings container key to not display the reference container on the homepage.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 */
	const REFERENCE_CONTAINER_START_PAGE_ENABLE = 'footnotes_inputfield_reference_container_start_page_enable';

	/**
	 * Settings container key to enable the legacy layout of the reference container.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 */
	const REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE = 'footnotes_inputfield_reference_container_3column_layout_enable';

	/**
	 * Settings container key to get the backlink symbol switch side.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 */
	const REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH = 'footnotes_inputfield_reference_container_backlink_symbol_switch';

	/**
	 * Settings container key for `the_content` hook priority level.
	 *
	 * Priority level of `the_content` and of `widget_text` as the only relevant
	 * hooks must be less than 99 because social buttons may yield scripts
	 * that contain the strings ‘((’ and ‘))’ (i.e., the default footnote
	 * start and end shortcodes), which causes issues with fake footnotes.
	 *
	 * Setting `the_content` priority to 10 instead of `PHP_INT_MAX` makes the
	 * footnotes reference container display beneath the post and above other
	 * features added by other plugins, e.g. related post lists and social buttons.
	 *
	 * For the {@link https://wordpress.org/plugins/yet-another-related-posts-plugin/
	 * YARPP} plugin to display related posts below the Footnotes reference container,
	 * priority needs to be at least 1,200.
	 *
	 * `PHP_INT_MAX` cannot be reset by leaving the number box empty, because
	 * WebKit browsers don't allow it, so we must resort to -1.
	 *
	 * @var  int
	 *
	 * @since  2.0.5
	 */
	const EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_content_priority_level';

	/**
	 * Settings container key for `the_title` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 */
	const EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_title_priority_level';

	/**
	 * Settings container key for `widget_title` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 */
	const EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_widget_title_priority_level';

	/**
	 * Settings container key for `widget_text` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 */
	const EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_widget_text_priority_level';

	/**
	 * Settings container key for `the_excerpt` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 */
	const EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_excerpt_priority_level';

	/**
	 * Settings container key for the link element option.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const LINK_ELEMENT_ENABLED = 'footnote_inputfield_link_element_enabled';

	/**
	 * Settings container key to enable the presence of a backlink separator.
	 *
	 * Backlink separators and terminators are often not preferred, but a choice
	 * should be provided along with the ability to customize.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_SEPARATOR_ENABLED = 'footnotes_inputfield_backlinks_separator_enabled';

	/**
	 * Settings container key for the backlink separator options.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_SEPARATOR_OPTION = 'footnotes_inputfield_backlinks_separator_option';

	/**
	 * Settings container key for a custom backlink separator.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_SEPARATOR_CUSTOM = 'footnotes_inputfield_backlinks_separator_custom';

	/**
	 * Settings container key to enable the presence of a backlink terminator.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_TERMINATOR_ENABLED = 'footnotes_inputfield_backlinks_terminator_enabled';

	/**
	 * Settings container key for the backlink terminator options.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_TERMINATOR_OPTION = 'footnotes_inputfield_backlinks_terminator_option';

	/**
	 * Settings container key for a custom backlink terminator.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_TERMINATOR_CUSTOM = 'footnotes_inputfield_backlinks_terminator_custom';

	/**
	 * Settings container key to enable the backlinks column width.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_COLUMN_WIDTH_ENABLED = 'footnotes_inputfield_backlinks_column_width_enabled';

	/**
	 * Settings container key for the backlinks column width scalar.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_COLUMN_WIDTH_SCALAR = 'footnotes_inputfield_backlinks_column_width_scalar';

	/**
	 * Settings container key for the backlinks column width unit.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_COLUMN_WIDTH_UNIT = 'footnotes_inputfield_backlinks_column_width_unit';

	/**
	 * Settings container key to enable a max width for the backlinks column.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_COLUMN_MAX_WIDTH_ENABLED = 'footnotes_inputfield_backlinks_column_max_width_enabled';

	/**
	 * Settings container key for the backlinks column max width scalar.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_COLUMN_MAX_WIDTH_SCALAR = 'footnotes_inputfield_backlinks_column_max_width_scalar';

	/**
	 * Settings container key for the backlinks column max width unit.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const BACKLINKS_COLUMN_MAX_WIDTH_UNIT = 'footnotes_inputfield_backlinks_column_max_width_unit';

	/**
	 * Settings container key to enable line breaks between backlinks.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 * Whether a <br /> tag is inserted.
	 */
	const BACKLINKS_LINE_BREAKS_ENABLED = 'footnotes_inputfield_backlinks_line_breaks_enabled';

	/**
	 * Settings container key to enable setting the tooltip font size.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 *
	 * Tooltip font size reset to legacy by default since 2.1.4;
	 * Was set to inherit since 2.1.1 as it overrode custom CSS,
	 * Called mouse over box not tooltip for consistency.
	 */
	const MOUSE_OVER_BOX_FONT_SIZE_ENABLED = 'footnotes_inputfield_mouse_over_box_font_size_enabled';

	/**
	 * Settings container key for the scalar value of the tooltip font size.
	 *
	 * @var  float
	 *
	 * @since  2.1.4
	 */
	const MOUSE_OVER_BOX_FONT_SIZE_SCALAR = 'footnotes_inputfield_mouse_over_box_font_size_scalar';

	/**
	 * Settings container key for the unit of the tooltip font size.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const MOUSE_OVER_BOX_FONT_SIZE_UNIT = 'footnotes_inputfield_mouse_over_box_font_size_unit';

	/**
	 * Settings container key for basic responsive page layout support options.
	 *
	 * Whether to concatenate an additional stylesheet.
	 *
	 * @var  string
	 *
	 * @since  2.1.4
	 */
	const FOOTNOTES_PAGE_LAYOUT_SUPPORT = 'footnotes_inputfield_page_layout_support';

	/**
	 * Settings container key for scroll offset.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const FOOTNOTES_SCROLL_OFFSET = 'footnotes_inputfield_scroll_offset';

	/**
	 * Settings container key for scroll duration.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const FOOTNOTES_SCROLL_DURATION = 'footnotes_inputfield_scroll_duration';

	/**
	 * Settings container key for tooltip display fade-in delay.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const MOUSE_OVER_BOX_FADE_IN_DELAY = 'footnotes_inputfield_mouse_over_box_fade_in_delay';

	/**
	 * Settings container key for tooltip display fade-in duration.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const MOUSE_OVER_BOX_FADE_IN_DURATION = 'footnotes_inputfield_mouse_over_box_fade_in_duration';

	/**
	 * Settings container key for tooltip display fade-out delay.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const MOUSE_OVER_BOX_FADE_OUT_DELAY = 'footnotes_inputfield_mouse_over_box_fade_out_delay';

	/**
	 * Settings container key for tooltip display fade-out duration.
	 *
	 * @var  int
	 *
	 * @since  2.1.4
	 */
	const MOUSE_OVER_BOX_FADE_OUT_DURATION = 'footnotes_inputfield_mouse_over_box_fade_out_duration';

	/**
	 * Settings container key for URL wrap option.
	 *
	 * This is made optional because it causes weird line breaks. Unicode-compliant
	 * browsers break URLs at slashes.
	 *
	 * @var  string
	 *
	 * @since  2.1.6
	 */
	const FOOTNOTE_URL_WRAP_ENABLED = 'footnote_inputfield_url_wrap_enabled';

	/**
	 * Settings container key for reference container position shortcode.
	 *
	 * @var  string
	 *
	 * @since  2.2.0
	 */
	const REFERENCE_CONTAINER_POSITION_SHORTCODE = 'footnote_inputfield_reference_container_position_shortcode';

	/**
	 * Settings container key for the Custom CSS migrated to a dedicated tab.
	 *
	 * @var  string
	 *
	 * @since  2.2.2
	 */
	const CUSTOM_CSS_NEW = 'footnote_inputfield_custom_css_new';

	/**
	 * Settings container key to enable display of legacy Custom CSS metaboxes.
	 *
	 * This must be `false` if its setting is contained in the container to be hidden
	 * because when saving, all missing constants are emptied, and {@see
	 * Footnotes_Convert::to_bool()} converts empty to `false`.
	 *
	 * @var  string
	 *
	 * @since  2.2.2
	 * @since  2.3.0  Swap migration Boolean, meaning ‘show legacy’ instead of
	 *                              ‘migration complete’, due to storage data structure constraints.
	 */
	const CUSTOM_CSS_LEGACY_ENABLE = 'footnote_inputfield_custom_css_legacy_enable';

	/**
	 * Settings container key for alternative tooltip position.
	 *
	 * Fixed-width is for alternative tooltips, cannot reuse `max-width` nor offsets.
	 *
	 * @var  string
	 *
	 * @since  2.2.5
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION = 'footnotes_inputfield_alternative_mouse_over_box_position';

	/**
	 * Settings container key for alternative tooltip _x_-offset.
	 *
	 * @var  int
	 *
	 * @since  2.2.5
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X = 'footnotes_inputfield_alternative_mouse_over_box_offset_x';

	/**
	 * Settings container key for alternative tooltip _y_-offset.
	 *
	 * @var  int
	 *
	 * @since  2.2.5
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y = 'footnotes_inputfield_alternative_mouse_over_box_offset_y';

	/**
	 * Settings container key for alternative tooltip width.
	 *
	 * @var  int
	 *
	 * @since  2.2.5
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH = 'footnotes_inputfield_alternative_mouse_over_box_width';


	/**
	 * Settings container key for the reference container label element.
	 *
	 * @var  string
	 *
	 * @since  2.2.5
	 */
	const REFERENCE_CONTAINER_LABEL_ELEMENT = 'footnotes_inputfield_reference_container_label_element';

	/**
	 * Settings container key to enable the reference container label bottom border.
	 *
	 * @var  string
	 *
	 * @since  2.2.5
	 */
	const REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER = 'footnotes_inputfield_reference_container_label_bottom_border';

	/**
	 * Settings container key to enable reference container table row borders.
	 *
	 * @var  string
	 *
	 * @since  2.2.10
	 */
	const REFERENCE_CONTAINER_ROW_BORDERS_ENABLE = 'footnotes_inputfield_reference_container_row_borders_enable';

	/**
	 * Settings container key for reference container top margin.
	 *
	 * @var  int
	 *
	 * @since  2.3.0
	 */
	const REFERENCE_CONTAINER_TOP_MARGIN = 'footnotes_inputfield_reference_container_top_margin';

	/**
	 * Settings container key for reference container bottom margin.
	 *
	 * @var  int
	 *
	 * @since  2.3.0
	 */
	const REFERENCE_CONTAINER_BOTTOM_MARGIN = 'footnotes_inputfield_reference_container_bottom_margin';

	/**
	 * Settings container key to enable hard links.
	 *
	 * When the alternative reference container is enabled, hard links are too.
	 *
	 * @var  string
	 *
	 * @since  2.3.0
	 */
	const FOOTNOTES_HARD_LINKS_ENABLE = 'footnotes_inputfield_hard_links_enable';

	/**
	 * Settings container key for the fragment ID slug in referrers.
	 *
	 * @var  string
	 *
	 * @since  2.3.0
	 */
	const REFERRER_FRAGMENT_ID_SLUG = 'footnotes_inputfield_referrer_fragment_id_slug';

	/**
	 * Settings container key for the fragment ID slug in footnotes.

	 * @var  string
	 *
	 * @since  2.3.0
	 */
	const FOOTNOTE_FRAGMENT_ID_SLUG = 'footnotes_inputfield_footnote_fragment_id_slug';

	/**
	 * Settings container key for the ID separator in fragment IDs.
	 *
	 * @var  string
	 *
	 * @since  2.3.0
	 */
	const HARD_LINK_IDS_SEPARATOR = 'footnotes_inputfield_hard_link_ids_separator';

	/**
	 * Settings container key to enable shortcode syntax validation.
	 *
	 * @var  string
	 *
	 * @since  2.4.0
	 */
	const FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE = 'footnotes_inputfield_shortcode_syntax_validation_enable';

	/**
	 * Settings container key to enable backlink tooltips.
	 *
	 * When hard links are enabled, clicks on the backlinks are logged in the
	 * browsing history, along with clicks on the referrers.
	 * This tooltip hints to use the backbutton instead, so the history gets
	 * streamlined again.
	 * See {@link https://wordpress.org/support/topic/making-it-amp-compatible/#post-13837359
	 * here} for more information.
	 *
	 * @var  string
	 *
	 * @since  2.5.4
	 */
	const FOOTNOTES_BACKLINK_TOOLTIP_ENABLE = 'footnotes_inputfield_backlink_tooltip_enable';

	/**
	 * Settings container key to configure the backlink tooltip.
	 *
	 * @var  string
	 *
	 * @since  2.5.4
	 */
	const FOOTNOTES_BACKLINK_TOOLTIP_TEXT = 'footnotes_inputfield_backlink_tooltip_text';

	/**
	 * Settings container key to configure the tooltip excerpt delimiter.
	 *
	 * The first implementation used a fixed shortcode provided in the changelog,
	 * but footnotes should have freely-configurable shortcodes.
	 *
	 * Tooltips can display another content than the footnote entry in the
	 * reference container. The trigger is a shortcode in the footnote text
	 * separating the tooltip text from the note. That is consistent with what
	 * WordPress does for excerpts.
	 *
	 * @var  string
	 *
	 * @since  2.5.4
	 */
	const FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER = 'footnotes_inputfield_tooltip_excerpt_delimiter';

	/**
	 * Settings container key to enable mirroring the tooltip excerpt in the
	 * reference container.
	 *
	 * Tooltips, even jQuery-driven, may be hard to consult on mobiles.
	 * This option allows users to read the tooltip content in the reference
	 * container too. See {@link https://wordpress.org/support/topic/change-tooltip-text/#post-13935050
	 * here} for more information, and {@link https://wordpress.org/support/topic/change-tooltip-text/#post-13935488
	 * here} for why this must not be the default behavior.
	 *
	 * @var  string
	 *
	 * @since  2.5.4
	 */
	const FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE = 'footnotes_inputfield_tooltip_excerpt_mirror_enable';

	/**
	 * Settings container key to configure the tooltip excerpt separator in the
	 * reference container.
	 *
	 * @var  string
	 *
	 * @since  2.5.4
	 */
	const FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR = 'footnotes_inputfield_tooltip_excerpt_mirror_separator';

	/**
	 * Settings container key to enable superscript style normalization.
	 *
	 * @var  string
	 *
	 * @since  2.5.4
	 */
	const FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT = 'footnotes_inputfield_referrers_normal_superscript';

	/**
	 * Settings container key to select the script mode for the reference container.
	 *
	 * @var  string
	 *
	 * @since  2.5.6
	 */
	const FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE = 'footnotes_inputfield_reference_container_script_mode';

	/**
	 * Settings container key to enable AMP compatibility mode.
	 *
	 * @var  string
	 *
	 * @since  2.6.0
	 */
	const FOOTNOTES_AMP_COMPATIBILITY_ENABLE = 'footnotes_inputfield_amp_compatibility_enable';

	/**
	 * Settings container key for scroll duration asymmetricity.
	 *
	 * @var  int
	 *
	 * @since  2.5.11
	 */
	const FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY = 'footnotes_inputfield_scroll_duration_asymmetricity';

	/**
	 * Settings container key for scroll-down duration.
	 *
	 * @var  int
	 *
	 * @since  2.5.11
	 */
	const FOOTNOTES_SCROLL_DOWN_DURATION = 'footnotes_inputfield_scroll_down_duration';

	/**
	 * Settings container key for scroll-down delay.
	 *
	 * @var  int
	 *
	 * @since  2.5.11
	 */
	const FOOTNOTES_SCROLL_DOWN_DELAY = 'footnotes_inputfield_scroll_down_delay';

	/**
	 * Settings container key for scroll-up delay.
	 *
	 * @var  int
	 *
	 * @since  2.5.11
	 */
	const FOOTNOTES_SCROLL_UP_DELAY = 'footnotes_inputfield_scroll_up_delay';

	/**
	 * Settings container key to set the solution of the input element label issue.
	 *
	 * If hard links are not enabled, clicking a referrer in an input element label
	 * toggles the state of the input element the label is connected to.
	 * Beside hard links, other solutions include moving footnotes off the label and
	 * append them, or disconnecting this label from the input element (discouraged).
	 * See {@link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14212318
	 * here} for more information.
	 *
	 * @var  string
	 *
	 * @since  2.5.12
	 * @todo  Review, remove?
	 */
	const FOOTNOTES_LABEL_ISSUE_SOLUTION = 'footnotes_inputfield_label_issue_solution';

	/**
	 * Settings container key to enable CSS smooth scrolling.
	 *
	 * Native smooth scrolling only works in recent browsers.
	 *
	 * @var  string
	 *
	 * @since  2.5.12
	 */
	const FOOTNOTES_CSS_SMOOTH_SCROLLING = 'footnotes_inputfield_css_smooth_scrolling';

	/**
	 * Settings container key for the footnote section shortcode.
	 *
	 * @var  string
	 *
	 * @since  2.7.0
	 */
	const FOOTNOTE_SECTION_SHORTCODE = 'footnotes_inputfield_section_shortcode';

	/**********************************************************************
	 *      SETTINGS STORAGE.
	 **********************************************************************/
	/**
	 * Stores a singleton reference of this class.
	 *
	 * @since  1.5.0
	 */
	private static ?\footnotes\includes\Settings $instance = null;

	/**
	 * Contains all Settings Container names.
	 *
	 * These are the storage container names, one per dashboard tab.
	 *
	 * @var  string[]
	 *
	 * @since  1.5.0
	 */
	private array $container = array(
		'footnotes_storage',
		'footnotes_storage_custom',
		'footnotes_storage_expert',
		'footnotes_storage_custom_css',
	);

	/**
	 * Contains all default values for each Settings Container.
	 *
	 * @since  1.5.0
	 * @todo  Review. Why are the constants just initialised with these values?
	 *              At the very least, we should stop using ‘yes’ to mean `true` etc.
	 * @todo Create `PreferencesSet` class.
	 *
	 * @var  (string|int)[]
	 */
	private array $default = array(

		// General settings.
		'footnotes_storage'            => array(

			// AMP compatibility.
			self::FOOTNOTES_AMP_COMPATIBILITY_ENABLE => '',

			// Footnote start and end short codes.
			self::FOOTNOTES_SHORT_CODE_START         => '((',
			self::FOOTNOTES_SHORT_CODE_END           => '))',
			self::FOOTNOTES_SHORT_CODE_START_USER_DEFINED => '',
			self::FOOTNOTES_SHORT_CODE_END_USER_DEFINED => '',
			self::FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE => 'yes',

			// Footnotes numbering.
			self::FOOTNOTES_COUNTER_STYLE            => 'arabic_plain',
			self::COMBINE_IDENTICAL_FOOTNOTES        => 'yes',

			// Scrolling behavior.
			self::FOOTNOTES_CSS_SMOOTH_SCROLLING     => 'no',
			self::FOOTNOTES_SCROLL_OFFSET            => 20,
			self::FOOTNOTES_SCROLL_DURATION          => 380,
			self::FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY => 'no',
			self::FOOTNOTES_SCROLL_DOWN_DURATION     => 150,
			self::FOOTNOTES_SCROLL_DOWN_DELAY        => 0,
			self::FOOTNOTES_SCROLL_UP_DELAY          => 0,
			self::FOOTNOTES_HARD_LINKS_ENABLE        => 'no',
			self::REFERRER_FRAGMENT_ID_SLUG          => 'r',
			self::FOOTNOTE_FRAGMENT_ID_SLUG          => 'f',
			self::HARD_LINK_IDS_SEPARATOR            => '+',
			self::FOOTNOTES_BACKLINK_TOOLTIP_ENABLE  => 'yes',
			self::FOOTNOTES_BACKLINK_TOOLTIP_TEXT    => 'Alt+ ←',

			// Reference container.
			self::REFERENCE_CONTAINER_NAME           => 'References',
			self::REFERENCE_CONTAINER_LABEL_ELEMENT  => 'p',
			self::REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER => 'yes',
			self::REFERENCE_CONTAINER_COLLAPSE       => 'no',
			self::FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE => 'jquery',
			self::REFERENCE_CONTAINER_POSITION       => 'post_end',
			self::REFERENCE_CONTAINER_POSITION_SHORTCODE => '[[references]]',
			self::FOOTNOTE_SECTION_SHORTCODE         => '[[/footnotesection]]',
			self::REFERENCE_CONTAINER_START_PAGE_ENABLE => 'yes',
			self::REFERENCE_CONTAINER_TOP_MARGIN     => 24,
			self::REFERENCE_CONTAINER_BOTTOM_MARGIN  => 0,
			self::FOOTNOTES_PAGE_LAYOUT_SUPPORT      => 'none',
			self::FOOTNOTE_URL_WRAP_ENABLED          => 'yes',
			self::REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE => 'yes',
			self::REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH => 'no',
			self::REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE => 'no',
			self::REFERENCE_CONTAINER_ROW_BORDERS_ENABLE => 'no',

			self::BACKLINKS_SEPARATOR_ENABLED        => 'yes',
			self::BACKLINKS_SEPARATOR_OPTION         => 'comma',
			self::BACKLINKS_SEPARATOR_CUSTOM         => '',

			self::BACKLINKS_TERMINATOR_ENABLED       => 'no',
			self::BACKLINKS_TERMINATOR_OPTION        => 'full_stop',
			self::BACKLINKS_TERMINATOR_CUSTOM        => '',

			self::BACKLINKS_COLUMN_WIDTH_ENABLED     => 'no',
			self::BACKLINKS_COLUMN_WIDTH_SCALAR      => '50',
			self::BACKLINKS_COLUMN_WIDTH_UNIT        => 'px',

			self::BACKLINKS_COLUMN_MAX_WIDTH_ENABLED => 'no',
			self::BACKLINKS_COLUMN_MAX_WIDTH_SCALAR  => '140',
			self::BACKLINKS_COLUMN_MAX_WIDTH_UNIT    => 'px',

			self::BACKLINKS_LINE_BREAKS_ENABLED      => 'no',
			self::LINK_ELEMENT_ENABLED               => 'yes',

			// Footnotes in excerpts.
			self::FOOTNOTES_IN_EXCERPT               => 'manual',

			// Footnotes love.
			self::FOOTNOTES_LOVE                     => 'no',

			// Deprecated.
			self::FOOTNOTES_EXPERT_MODE              => 'yes',

		),

		// Referrers and tooltips.
		'footnotes_storage_custom'     => array(

			// Backlink symbol.
			self::HYPERLINK_ARROW                    => 0,
			self::HYPERLINK_ARROW_USER_DEFINED       => '',

			// Referrers.
			self::FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS => 'yes',
			self::FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT => 'no',
			self::FOOTNOTES_STYLING_BEFORE           => '[',
			self::FOOTNOTES_STYLING_AFTER            => ']',

			// Referrers in labels.
			self::FOOTNOTES_LABEL_ISSUE_SOLUTION     => 'none',

			// Tooltips.
			self::FOOTNOTES_MOUSE_OVER_BOX_ENABLED   => 'yes',
			self::FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE => 'no',

			// Tooltip position.
			self::FOOTNOTES_MOUSE_OVER_BOX_POSITION  => 'top center',
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION => 'top right',
			self::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X  => 0,
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X => -50,
			self::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y  => -7,
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y => 24,

			// Tooltip dimensions.
			self::FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH => 450,
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH => 400,

			// Tooltip timing.
			self::MOUSE_OVER_BOX_FADE_IN_DELAY       => 0,
			self::MOUSE_OVER_BOX_FADE_IN_DURATION    => 200,
			self::MOUSE_OVER_BOX_FADE_OUT_DELAY      => 400,
			self::MOUSE_OVER_BOX_FADE_OUT_DURATION   => 200,

			// Tooltip truncation.
			self::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED => 'yes',
			self::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH => 200,
			self::FOOTNOTES_TOOLTIP_READON_LABEL     => 'Continue reading',

			// Tooltip text.
			self::FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER => '[[/tooltip]]',
			self::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE => 'no',
			self::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR => ' — ',

			// Tooltip appearance.
			self::MOUSE_OVER_BOX_FONT_SIZE_ENABLED   => 'yes',
			self::MOUSE_OVER_BOX_FONT_SIZE_SCALAR    => 13,
			self::MOUSE_OVER_BOX_FONT_SIZE_UNIT      => 'px',

			self::FOOTNOTES_MOUSE_OVER_BOX_COLOR     => '#000000',
			self::FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND => '#ffffff',
			self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH => 1,
			self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR => '#cccc99',
			self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS => 0,
			self::FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR => '#666666',

			// Your existing Custom CSS code.
			self::CUSTOM_CSS                         => '',

		),

		// Scope and priority.
		'footnotes_storage_expert'     => array(

			// WordPress hooks with priority level.
			self::EXPERT_LOOKUP_THE_TITLE    => '',
			self::EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL => PHP_INT_MAX,

			self::EXPERT_LOOKUP_THE_CONTENT  => 'checked',
			self::EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL => 98,

			self::EXPERT_LOOKUP_THE_EXCERPT  => '',
			self::EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL => PHP_INT_MAX,

			self::EXPERT_LOOKUP_WIDGET_TITLE => '',
			self::EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL => PHP_INT_MAX,

			self::EXPERT_LOOKUP_WIDGET_TEXT  => '',
			self::EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL => 98,

		),

		// Custom CSS.
		'footnotes_storage_custom_css' => array(

			// Your existing Custom CSS code.
			self::CUSTOM_CSS_LEGACY_ENABLE => 'yes',

			// Custom CSS.
			self::CUSTOM_CSS_NEW           => '',

		),

	);

	/**
	 * Contains all Settings from each Settings Container.
	 *
	 * @var  (string|int)[]
	 *
	 * @since  1.5.0
	 * @todo Create `PreferencesSet` class.
	 */
	private array $settings = array();

	/**
	 * Loads all Settings from each WordPress Settings Container.
	 *
	 * @since  1.5.0
	 */
	private function __construct() {
		$this->load_all();
	}

	/**
	 * Returns a singleton of this class.
	 *
	 * @since  1.5.0
	 * @todo  Remove?
	 */
	public static function instance(): self {
		// No instance defined yet, load it.
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		// Return a singleton of this class.
		return self::$instance;
	}

	/**
	 * Returns the name of a specified Settings Container.
	 *
	 * @param  int $index  Settings Container index.
	 * @return  string  Settings Container name.
	 *
	 * @since  1.5.0
	 */
	public function get_container( int $index ): string {
		return $this->container[ $index ];
	}

	/**
	 * Returns the default value(s) of a specific Settings Container.
	 *
	 * @param  int $index  Settings Container index.
	 * @return  (string|int)[]  Settings Container default value(s).
	 *
	 * @since  1.5.6
	 */
	public function get_defaults( int $index ): array {
		return $this->default[ $this->container[ $index ] ];
	}

	/**
	 * Loads all Settings from each Settings container.
	 *
	 * @since  1.5.0
	 */
	private function load_all(): void {
		// Clear current settings.
		$this->settings = array();
		$num_settings         = count( $this->container );
		for ( $i = 0; $i < $num_settings; $i++ ) {
			// Load settings.
			$this->settings = array_merge( $this->settings, $this->load( $i ) );
		}
	}

	/**
	 * Loads all settings from specified Settings Containers.
	 *
	 * @param  int $index  Settings container index.
	 * @return  (string|int)[]  Loaded settings (or defaults if specified container is empty).
	 *
	 * @since  1.5.0
	 */
	private function load( int $index ): array {
		// Load all settings from container.
		$options = get_option( $this->get_container( $index ) );
		// Load all default settings.
		$default = $this->default[ $this->get_container( $index ) ];

		// No settings found, set them to their default value.
		if ( empty( $options ) ) {
			return $default;
		}
		// Iterate through all available settings ( = default values).
		foreach ( $default as $key => $value ) {
			// Available setting not found in the container.
			if ( ! array_key_exists( $key, $options ) ) {
				// Define the setting with its default value.
				$options[ $key ] = $value;
			}
		}
		// Return settings loaded from Container.
		return $options;
	}

	/**
	 * Updates a whole Setting Container on save.
	 *
	 * @param  int   $index  Index of the Setting Container.
	 * @param  array $new_values  The new Settings value(s).
	 *
	 * @since  1.5.0
	 */
	public function save_options( int $index, array $new_values ): bool {
		if ( update_option( $this->get_container( $index ), $new_values ) ) {
			$this->load_all();
			return true;
		}
		return false;
	}

	/**
	 * Returns the value of specified Setting.
	 *
	 * @param  string $key  Setting key.
	 * @return  string|int|null  Setting value, or `null` if setting key is invalid.
	 *
	 * @since  1.5.0
	 * @todo Add return type.
	 */
	public function get( string $key ) {
		return $this->settings[ $key ] ?? null;
	}

	/**
	 * Register all Settings Containers for the plugin Settings Page in the Dashboard.
	 *
	 * The Settings Container label will be the same as the Settings Container name.
	 *
	 * @since  1.5.0
	 */
	public function register_settings(): void {
		// Register all settings.
		$num_settings = count( $this->container );
		for ( $i = 0; $i < $num_settings; $i++ ) {
			register_setting( $this->get_container( $i ), $this->get_container( $i ) );
		}
	}
}
