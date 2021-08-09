<?php
/**
 * File providing the `ShortcodeSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the footnote shortcode delimiter settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ShortcodeSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'shortcode';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Footnote Start and End Short Codes';

	/**
	 * Settings container key to enable shortcode syntax validation.
	 *
	 * @var  array
	 *
	 * @since  2.4.0
	 * @since  2.8.0  Move from `Settings` to `ShortcodeSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE = array(
		'key'           => 'footnotes_inputfield_shortcode_syntax_validation_enable',
		'name'          => 'Check for Balanced Shortcodes',
		'description'   => 'In the presence of a lone start tag shortcode, a warning displays below the post title. If the start tag short code is <q>((</q> or <q>(((</q>, it will not be reported as unbalanced if the following string contains braces hinting that it is a script.',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for the short code of the footnote's start.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ShortcodeSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_SHORT_CODE_START = array(
		'key'           => 'footnote_inputfield_placeholder_start',
		'name'          => 'Footnote Start Tag Short Code',
		'description'   => 'When delimiters with pointy brackets are used, the diverging escapement schemas will be unified before footnotes are processed. WARNING: Although widespread industry standard, the double parentheses are problematic because they may occur in scripts embedded in the content and be mistaken as a short code.',
		'default_value' => '((',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
			'(('          => '((',
			'((('         => '(((',
			'{{'          => '{{',
			'{{{'         => '{{{',
			'[n]'         => '[n]',
			'[fn]'        => '[fn]',
			'<fn>'        => '&lt;fn&gt;',
			'<ref>'       => '&lt;ref&gt;',
			'userdefined' => 'custom short code',
		),
	);

	/**
	 * Settings container key for the user-defined short code of the footnotes start.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ShortcodeSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_SHORT_CODE_START_USER_DEFINED = array(
		'key'        => 'footnote_inputfield_placeholder_start_user_defined',
		'name'       => 'User-defined Start Shortcode',
		'type'       => 'string',
		'input_type' => 'text',
		'enabled_by' => self::FOOTNOTES_SHORT_CODE_START,
	);

	/**
	 * Settings container key for the short code of the footnote's end.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ShortcodeSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_SHORT_CODE_END = array(
		'key'           => 'footnote_inputfield_placeholder_end',
		'name'          => 'Footnote End Tag Short Code',
		'default_value' => '))',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
			'))'          => '))',
			')))'         => ')))',
			'}}'          => '}}',
			'}}}'         => '}}}',
			'[/n]'        => '[/n]',
			'[/fn]'       => '[/fn]',
			'</fn>'       => '&lt;/fn&gt;',
			'</ref>'      => '&lt;/ref&gt;',
			'userdefined' => 'custom short code',
		),
	);

	/**
	 * Settings container key for the user-defined short code of the footnotes end.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ShortcodeSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_SHORT_CODE_END_USER_DEFINED = array(
		'key'        => 'footnote_inputfield_placeholder_end_user_defined',
		'name'       => 'User-defined End Shortcode',
		'type'       => 'string',
		'input_type' => 'text',
		'enabled_by' => self::FOOTNOTES_SHORT_CODE_END,
	);
	
	/**
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE['key'] => $this->add_setting( self::FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE ),
			self::FOOTNOTES_SHORT_CODE_START['key'] => $this->add_setting( self::FOOTNOTES_SHORT_CODE_START ),
			self::FOOTNOTES_SHORT_CODE_START_USER_DEFINED['key'] => $this->add_setting( self::FOOTNOTES_SHORT_CODE_START_USER_DEFINED ),
			self::FOOTNOTES_SHORT_CODE_END['key']   => $this->add_setting( self::FOOTNOTES_SHORT_CODE_END ),
			self::FOOTNOTES_SHORT_CODE_END_USER_DEFINED['key'] => $this->add_setting( self::FOOTNOTES_SHORT_CODE_END_USER_DEFINED ),
		);

		$this->load_values( $options );
	}
}
