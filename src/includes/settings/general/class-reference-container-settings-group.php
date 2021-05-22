<?php
/**
 * File providing the `ReferenceContainerSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the reference container settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ReferenceContainerSettingsGroup extends SettingsGroup {		
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'reference-container';
	
	/**
	 * Settings container key for combining identical footnotes.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const COMBINE_IDENTICAL_FOOTNOTES = array(
		'key' => 'footnote_inputfield_combine_identical',
		'name' => 'Combine Identical Footnotes',
		'description' => 'Whether to combine identical footnotes.',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);
	
	/**
	 * Settings container key for the label of the reference container.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const REFERENCE_CONTAINER_NAME = array(
		'key' => 'footnote_inputfield_references_label',
		'name' => 'Reference Container Title',
		'default_value' => 'References',
		'type' => 'string',
		'input_type' => 'text'
	);
	
	/**
	 * Settings container key for the reference container label element.
	 *
	 * @var  array
	 *
	 * @since  2.2.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const REFERENCE_CONTAINER_LABEL_ELEMENT =array(
		'key' => 'footnote_inputfield_references_label',
		'name' => 'Heading\'s HTML Element',
		'default_value' => 'p',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => array(
			'p'  => 'paragraph',
			'h2' => 'heading 2',
			'h3' => 'heading 3',
			'h4' => 'heading 4',
			'h5' => 'heading 5',
			'h6' => 'heading 6',
		)
	);
	
	/**
	 * Settings container key to enable the reference container label bottom border.
	 *
	 * @var  array
	 *
	 * @since  2.2.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER = array(
		'key' => 'footnotes_inputfield_reference_container_label_bottom_border',
		'name' => 'Border Under the Heading',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);
	
	/**
	 * Settings container key to collapse the reference container by default.
	 *
	 * @var  bool
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_COLLAPSE = array(
		'key' => 'footnote_inputfield_collapse_references',
		'name' => 'Collapse by Default',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);
	
	/**
	 * Settings container key to select the script mode for the reference container.
	 *
	 * @var  array
	 *
	 * @since  2.5.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE = array(
		'key' => 'footnotes_inputfield_reference_container_script_mode',
		'name' => 'Script Mode',
		'description' => 'The plain JavaScript mode will enable hard links with configurable scroll offset.',
		'default_value' => 'jquery',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => array(
			'jquery' => 'jQuery',
			'js' => 'plain JavaScript'
		)
	);

	/**
	 * Settings container key for the position of the reference container.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const REFERENCE_CONTAINER_POSITION = array(
		'key' => 'footnote_inputfield_reference_container_place',
		'name' => 'Container Position',
		'description' => 'Where the container should be placed on the page. To use the position or section shortcode, please set the position to: at the end of the post',
		'default_value' => 'post_end',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => array(
			'post_end' => 'at the end of the post',
			'widget'   => 'in the widget area',
			'footer'   => 'in the footer',
		)
	);

	/**
	 * Settings container key for reference container position shortcode.
	 *
	 * @var  array
	 *
	 * @since  2.2.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const REFERENCE_CONTAINER_POSITION_SHORTCODE = array(
		'key' => 'footnote_inputfield_reference_container_position_shortcode',
		'name' => 'Position Shortcode',
		'description' => 'If present in the content, any shortcode in this text box will be replaced with the reference container.',
		'default_value' => '[[references]]',
		'type' => 'string',
		'input_type' => 'text'
	);
	
	/**
	 * Settings container key for the footnote section shortcode.
	 *
	 * @var  array
	 *
	 * @since  2.7.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTE_SECTION_SHORTCODE = array(
		'key' => 'footnotes_inputfield_section_shortcode',
		'name' => 'Footnote Section Shortcode',
		'description' => 'If present in the content, any shortcode in this text box will delimit a section terminated by a reference container.',
		'default_value' => '[[/footnotesection]]',
		'type' => 'string',
		'input_type' => 'text'
	);

	/**
	 * Settings container key to not display the reference container on the homepage.
	 *
	 * @var  array
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Move from `Settings` to `Refere\nceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_START_PAGE_ENABLE = array(
		'key' => 'footnotes_inputfield_reference_container_start_page_enable',
		'name' => 'Display on Start Page Too',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key for reference container top margin.
	 *
	 * @var  int
	 *
	 * @since  2.3.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const REFERENCE_CONTAINER_TOP_MARGIN = array(
		'key' => 'footnotes_inputfield_reference_container_top_margin',
		'name' => 'Top Margin',
		'description' => 'pixels; may be negative',
		'default_value' => 24,
		'type' => 'integer',
		'input_type' => 'number',
		'input_max' => 500,
		'input_min' => -500
	);
	
	/**
	 * Settings container key for reference container bottom margin.
	 *
	 * @var  int
	 *
	 * @since  2.3.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const REFERENCE_CONTAINER_BOTTOM_MARGIN = array(
		'key' => 'footnotes_inputfield_reference_container_bottom_margin',
		'name' => 'Bottom Margin',
		'description' => 'pixels; may be negative',
		'default_value' => 0,
		'type' => 'integer',
		'input_type' => 'number',
		'input_max' => 500,
		'input_min' => -500
	);

	/**
	 * Settings container key for basic responsive page layout support options.
	 *
	 * Whether to concatenate an additional stylesheet.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_PAGE_LAYOUT_SUPPORT = array(
		'key' => 'footnotes_inputfield_page_layout_support',
		'name' => 'Apply Basic Responsive Page Layout',
		'description' => 'Most themes don\'t need this fix.',
		'default_value' => 'none',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => array(
			'none'                => 'No',
			'reference-container' => 'to the reference container exclusively',
			'entry-content'       => 'to the div element starting below the post title',
			'main-content'        => 'to the main element including the post title',
		)
	);

	/**
	 * Settings container key for URL wrap option.
	 *
	 * This is made optional because it causes weird line breaks. Unicode-compliant
	 * browsers break URLs at slashes.
	 *
	 * @var  array
	 *
	 * @since  2.1.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTE_URL_WRAP_ENABLED = array(
		'key' => 'footnote_inputfield_url_wrap_enabled',
		'name' => 'Allow URLs to Line-Wrap Anywhere',
		'description' => 'Unicode-conformant browsers don\'t need this fix.',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key to enable the display of a backlink symbol.
	 *
	 * @var  array
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE = array(
		'key' => 'footnotes_inputfield_reference_container_backlink_symbol_enable',
		'name' => 'Display a Backlink Symbol',
		'description' => 'Please choose or input the symbol at the top of the next dashboard tab.',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key to get the backlink symbol switch side.
	 *
	 * @var  array
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH = array(
		'key' => 'footnotes_inputfield_reference_container_backlink_symbol_switch',
		'name' => 'Append Instead of Prepend Symbol',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key to enable the legacy layout of the reference container.
	 *
	 * @var  array
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE = array(
		'key' => 'footnotes_inputfield_reference_container_3column_layout_enable',
		'name' => 'Backlink Symbol in an Extra Column',
		'description' => 'This legacy layout is available if identical footnotes are not combined.',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key to enable reference container table row borders.
	 *
	 * @var  array
	 *
	 * @since  2.2.10
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const REFERENCE_CONTAINER_ROW_BORDERS_ENABLE = array(
		'key' => 'footnotes_inputfield_reference_container_row_borders_enable',
		'name' => 'Borders Around the Table Rows',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key to enable the presence of a backlink separator.
	 *
	 * Backlink separators and terminators are often not preferred, but a choice
	 * should be provided along with the ability to customize.
	 *
	 * @see BACKLINKS_SEPARATOR_OPTION
	 * @see BACKLINKS_SEPARATOR_CUSTOM
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const BACKLINKS_SEPARATOR_ENABLED = array(
		'key' => 'footnotes_inputfield_backlinks_separator_enabled',
		'name' => 'Add a Separator When Enumerating Backlinks',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key for the backlink separator options.
	 *
	 * @see BACKLINKS_SEPARATOR_ENABLED
	 * @see BACKLINKS_SEPARATOR_CUSTOM
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_SEPARATOR_OPTION = array(
		'key' => 'footnotes_inputfield_backlinks_separator_option',
		'name' => 'Backlink Separator Symbol',
		'default_value' => 'comma',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => array(
			// Unicode character names are conventionally uppercase.
			'comma'     => ',',
			'semicolon' => ';',
			'en_dash'   => '–',
		),
		'enabled_by' => self::BACKLINKS_SEPARATOR_ENABLED,
		'overridden_by' => self::BACKLINKS_SEPARATOR_CUSTOM
	);

	/**
	 * Settings container key for a custom backlink separator.
	 *
	 * @see BACKLINKS_SEPARATOR_ENABLED
	 * @see BACKLINKS_SEPARATOR_OPTION
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_SEPARATOR_CUSTOM = array(
		'key' => 'footnotes_inputfield_backlinks_separator_custom',
		'name' => 'Custom Backlink Separator Symbol',
		'description' => 'Your input overrides the selection.',
		'default_value' => null,
		'type' => 'string',
		'input_type' => 'text',
		'enabled_by' => self::BACKLINKS_SEPARATOR_ENABLED
	);
	
	/**
	 * Settings container key to enable the presence of a backlink terminator.
	 *
	 * @see BACKLINKS_TERMINATOR_OPTION
	 * @see BACKLINKS_TERMINATOR_CUSTOM
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const BACKLINKS_TERMINATOR_ENABLED = array(
		'key' => 'footnotes_inputfield_backlinks_terminator_enabled',
		'name' => 'Add a Terminal Punctuation to Backlinks',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key for the backlink terminator options.
	 *
	 * @see BACKLINKS_TERMINATOR_ENABLED
	 * @see BACKLINKS_TERMINATOR_CUSTOM
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_TERMINATOR_OPTION = array(
		'key' => 'footnotes_inputfield_backlinks_terminator_option',
		'name' => 'Backlink Terminator Symbol',
		'default_value' => 'period',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => array(
			'period'      => '.',
			// Unicode 1.0 name of RIGHT PARENTHESIS (represented as a left parenthesis in right-to-left scripts).
			'parenthesis' => ')',
			'colon'       => ':',
		),
		'enabled_by' => self::BACKLINKS_TERMINATOR_ENABLED,
		'overridden_by' => self::BACKLINKS_TERMINATOR_CUSTOM
	);

	/**
	 * Settings container key for a custom backlink terminator.
	 *
	 * @see BACKLINKS_TERMINATOR_ENABLED
	 * @see BACKLINKS_TERMINATOR_OPTION
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_TERMINATOR_CUSTOM = array(
		'key' => 'footnotes_inputfield_backlinks_terminator_custom',
		'name' => 'Custom Backlink Terminator Symbol',
		'description' => 'Your input overrides the selection.',
		'default_value' => null,
		'type' => 'string',
		'input_type' => 'text',
		'enabled_by' => self::BACKLINKS_TERMINATOR_ENABLED
	);
	
	/**
	 * Settings container key to enable the backlinks column width.
	 *
	 * @see BACKLINKS_COLUMN_WIDTH_SCALAR
	 * @see BACKLINKS_COLUMN_WIDTH_UNIT
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const BACKLINKS_COLUMN_WIDTH_ENABLED = array(
		'key' => 'footnotes_inputfield_backlinks_column_width_enabled',
		'name' => 'Set Backlinks Column Width',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key for the backlinks column width scalar.
	 *
	 * @see BACKLINKS_COLUMN_WIDTH_ENABLED
	 * @see BACKLINKS_COLUMN_WIDTH_UNIT
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_COLUMN_WIDTH_SCALAR = array(
		'key' => 'footnotes_inputfield_backlinks_column_width_scalar',
		'name' => 'Backlinks Column Width',
		'default_value' => 50,
		'type' => 'number',
		'input_type' => 'number',
		'input_max' => 500,
		'input_min' => 0,
		'enabled_by' => self::BACKLINKS_COLUMN_WIDTH_ENABLED
	);

	/**
	 * Settings container key for the backlinks column width unit.
	 *
	 * @see BACKLINKS_COLUMN_WIDTH_ENABLED
	 * @see BACKLINKS_COLUMN_WIDTH_SCALAR
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_COLUMN_WIDTH_UNIT = array(
		'key' => 'footnotes_inputfield_backlinks_column_width_unit',
		'name' => 'Backlinks Column Width Unit',
		'description' => 'Absolute width in pixels doesn\'t need to be accurate to the tenth, but relative width in `rem` or `em` may.',
		'default_value' => 'px',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => Settings::WIDTH_UNIT_OPTIONS,
		'enabled_by' => self::BACKLINKS_COLUMN_WIDTH_ENABLED
	);
	
	/**
	 * Settings container key to enable a max width for the backlinks column.
	 *
	 * @see BACKLINKS_COLUMN_MAX_WIDTH_SCALAR
	 * @see BACKLINKS_COLUMN_MAX_WIDTH_UNIT
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const BACKLINKS_COLUMN_MAX_WIDTH_ENABLED = array(
		'key' => 'footnotes_inputfield_backlinks_column_max_width_enabled',
		'name' => 'Set Backlinks Column Max. Width',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

	/**
	 * Settings container key for the backlinks column max width scalar.
	 *
	 * @see BACKLINKS_COLUMN_MAX_WIDTH_ENABLED
	 * @see BACKLINKS_COLUMN_MAX_WIDTH_UNIT
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_COLUMN_MAX_WIDTH_SCALAR = array(
		'key' => 'footnotes_inputfield_backlinks_column_max_width_scalar',
		'name' => 'Backlinks Column Width',
		'default_value' => 140,
		'type' => 'number',
		'input_type' => 'number',
		'input_max' => 500,
		'input_min' => 0,
		'enabled_by' => self::BACKLINKS_COLUMN_MAX_WIDTH_ENABLED
	);

	/**
	 * Settings container key for the backlinks column max width unit.
	 *
	 * @see BACKLINKS_COLUMN_MAX_WIDTH_ENABLED
	 * @see BACKLINKS_COLUMN_MAX_WIDTH_SCALAR
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const BACKLINKS_COLUMN_MAX_WIDTH_UNIT = array(
		'key' => 'footnotes_inputfield_backlinks_column_max_width_unit',
		'name' => 'Backlinks Column Width Unit',
		'description' => 'Absolute width in pixels doesn\'t need to be accurate to the tenth, but relative width in `rem` or `em` may.',
		'default_value' => 'px',
		'type' => 'string',
		'input_type' => 'select',
		'input_options' => Settings::WIDTH_UNIT_OPTIONS,
		'enabled_by' => self::BACKLINKS_COLUMN_MAX_WIDTH_ENABLED
	);
	
	/**
	 * Settings container key to enable line breaks between backlinks.
	 *
	 * Whether a `<br />` HTML element is inserted.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const BACKLINKS_LINE_BREAKS_ENABLED = array(
		'key' => 'footnotes_inputfield_backlinks_line_breaks_enabled',
		'name' => 'Stack Backlinks When Enumerating',
		'description' => 'This option adds a line break before each added backlink when identical footnotes are combined.',
		'default_value' => false,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);
	
	/**
	 * Settings container key for the link element option.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const LINK_ELEMENT_ENABLED = array(
		'key' => 'footnote_inputfield_link_element_enabled',
		'name' => 'Use the Link Element for Referrers and Backlinks',
		'description' => 'The link element is needed to apply the theme\'s link color. If the link element is not desired for styling, a simple span is used instead when the above is unchecked.',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);

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
	 * @todo  Un-deprecate or delete.
	 */
	const FOOTNOTES_EXPERT_MODE = array(
		'key' => 'footnote_inputfield_enable_expert_mode',
		'name' => 'Expert Mode',
		'description' => 'DEPRECATED',
		'default_value' => true,
		'type' => 'boolean',
		'input_type' => 'checkbox'
	);
	
	/**
	 * The general settings.
	 *
	 * @var  Setting[]
	 *
	 * @since  2.8.0
	 */
	protected array $settings;
	
	public function __construct(
		/**
		 * Setting options group slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		protected string $options_group_slug,	
		
		/**
		 * Setting section slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		protected string $section_slug
	) {		
		$this->load_dependencies();
		
		$this->add_settings(get_option( $this->options_group_slug ));
	}
	
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'class-setting.php';
	}
	
	protected function add_settings(array $options): void {
		$this->settings = array(
			self::REFERENCE_CONTAINER_NAME['key'] => $this->add_setting(self::REFERENCE_CONTAINER_NAME),
			self::COMBINE_IDENTICAL_FOOTNOTES['key'] => $this->add_setting(self::COMBINE_IDENTICAL_FOOTNOTES),
			self::REFERENCE_CONTAINER_NAME['key'] => $this->add_setting(self::REFERENCE_CONTAINER_NAME),
			self::REFERENCE_CONTAINER_LABEL_ELEMENT['key'] => $this->add_setting(self::REFERENCE_CONTAINER_LABEL_ELEMENT),
			self::REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER['key'] => $this->add_setting(self::REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER),
			self::REFERENCE_CONTAINER_COLLAPSE['key'] => $this->add_setting(self::REFERENCE_CONTAINER_COLLAPSE),
			self::FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE['key'] => $this->add_setting(self::FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE),
			self::REFERENCE_CONTAINER_POSITION['key'] => $this->add_setting(self::REFERENCE_CONTAINER_POSITION),
			self::REFERENCE_CONTAINER_POSITION_SHORTCODE['key'] => $this->add_setting(self::REFERENCE_CONTAINER_POSITION_SHORTCODE),
			self::FOOTNOTE_SECTION_SHORTCODE['key'] => $this->add_setting(self::FOOTNOTE_SECTION_SHORTCODE),
			self::REFERENCE_CONTAINER_START_PAGE_ENABLE['key'] => $this->add_setting(self::REFERENCE_CONTAINER_START_PAGE_ENABLE),
			self::REFERENCE_CONTAINER_TOP_MARGIN['key'] => $this->add_setting(self::REFERENCE_CONTAINER_TOP_MARGIN),
			self::REFERENCE_CONTAINER_BOTTOM_MARGIN['key'] => $this->add_setting(self::REFERENCE_CONTAINER_BOTTOM_MARGIN),
			self::FOOTNOTES_PAGE_LAYOUT_SUPPORT['key'] => $this->add_setting(self::FOOTNOTES_PAGE_LAYOUT_SUPPORT),
			self::FOOTNOTE_URL_WRAP_ENABLED['key'] => $this->add_setting(self::FOOTNOTE_URL_WRAP_ENABLED),
			self::REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE['key'] => $this->add_setting(self::REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE),
			self::REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH['key'] => $this->add_setting(self::REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH),
			self::REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE['key'] => $this->add_setting(self::REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE),
			self::REFERENCE_CONTAINER_ROW_BORDERS_ENABLE['key'] => $this->add_setting(self::REFERENCE_CONTAINER_ROW_BORDERS_ENABLE),
			self::BACKLINKS_SEPARATOR_ENABLED['key'] => $this->add_setting(self::BACKLINKS_SEPARATOR_ENABLED),
			self::BACKLINKS_SEPARATOR_OPTION['key'] => $this->add_setting(self::BACKLINKS_SEPARATOR_OPTION),
			self::BACKLINKS_SEPARATOR_CUSTOM['key'] => $this->add_setting(self::BACKLINKS_SEPARATOR_CUSTOM),
			self::BACKLINKS_TERMINATOR_ENABLED['key'] => $this->add_setting(self::BACKLINKS_TERMINATOR_ENABLED),
			self::BACKLINKS_TERMINATOR_OPTION['key'] => $this->add_setting(self::BACKLINKS_TERMINATOR_OPTION),
			self::BACKLINKS_TERMINATOR_CUSTOM['key'] => $this->add_setting(self::BACKLINKS_TERMINATOR_CUSTOM),
			self::BACKLINKS_COLUMN_WIDTH_ENABLED['key'] => $this->add_setting(self::BACKLINKS_COLUMN_WIDTH_ENABLED),
			self::BACKLINKS_COLUMN_WIDTH_SCALAR['key'] => $this->add_setting(self::BACKLINKS_COLUMN_WIDTH_SCALAR),
			self::BACKLINKS_COLUMN_WIDTH_UNIT['key'] => $this->add_setting(self::BACKLINKS_COLUMN_WIDTH_UNIT),
			self::BACKLINKS_COLUMN_MAX_WIDTH_ENABLED['key'] => $this->add_setting(self::BACKLINKS_COLUMN_MAX_WIDTH_ENABLED),
			self::BACKLINKS_COLUMN_MAX_WIDTH_SCALAR['key'] => $this->add_setting(self::BACKLINKS_COLUMN_MAX_WIDTH_SCALAR),
			self::BACKLINKS_COLUMN_MAX_WIDTH_UNIT['key'] => $this->add_setting(self::BACKLINKS_COLUMN_MAX_WIDTH_UNIT),
			self::BACKLINKS_LINE_BREAKS_ENABLED['key'] => $this->add_setting(self::BACKLINKS_LINE_BREAKS_ENABLED),
			self::LINK_ELEMENT_ENABLED['key'] => $this->add_setting(self::LINK_ELEMENT_ENABLED),
			self::FOOTNOTES_EXPERT_MODE['key'] => $this->add_setting(self::FOOTNOTES_EXPERT_MODE)
		);
	}
	
	private function add_setting(array $setting): Setting {
		extract( $setting );
		
		return new Setting(
			self::GROUP_ID, 
			$this->options_group_slug, 
			$this->section_slug,
			$key,
			$name,
			$description ?? null,
			$default_value,
			$type,
			$input_type,
			$input_options ?? null,
			$input_max ?? null,
			$input_min ?? null,
			$enabled_by['key'] ?? null,
			$overridden_by['key'] ?? null
		);
	}
	
	public function add_settings_fields($component): void {
		foreach ($this->settings as $setting) {			
			add_settings_field(
				$setting->key, 
				__( $setting->name, 'footnotes' ),
				array ($component, 'setting_field_callback'),
				'footnotes',
				$setting->get_section_slug(),
				$setting->get_setting_field_args()
			);
		}
	}
}
