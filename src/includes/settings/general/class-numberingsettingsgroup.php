<?php
/**
 * File providing the `NumberingSettingsGroup` class.
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
 * Class defining the footnote numbering settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class NumberingSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'numbering';

	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Footnotes Numbering';

	/**
	 * Settings container key for combining identical footnotes.
	 *
	 * @link https://wordpress.org/support/topic/add-support-for-ibid-notation
	 *       Support for Ibid. notation added thanks to @meglio.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const COMBINE_IDENTICAL_FOOTNOTES = array(
		'key'           => 'footnote_inputfield_combine_identical',
		'name'          => 'Combine Identical Footnotes',
		'description'   => 'This option may require copy-pasting footnotes in multiple instances. Even when footnotes are combined, footnote numbers keep incrementing. This avoids suboptimal referrer and backlink disambiguation using a secondary numbering system. The Ibid. notation and the op. cit. abbreviation followed by the current page number avoid repeating the footnote content. For changing sources, shortened citations may be used. Repeating full citations is also an opportunity to add details.',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for the counter style of the footnotes.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `NumberingSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_COUNTER_STYLE = array(
		'key'           => 'footnote_inputfield_counter_style',
		'name'          => 'Numbering Style',
		'default_value' => 'arabic_plain',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
			'arabic_plain'   => 'plain Arabic numbers (1, 2, 3, 4, 5, &hellip;)',
			'arabic_leading' => 'zero-padded Arabic numbers (01, 02, 03, 04, 05, &hellip;)',
			'latin_low'      => 'lowercase Latin letters (a, b, c, d, e, &hellip;)',
			'latin_high'     => 'uppercase Latin letters (A, B, C, D, E, &hellip;)',
			'romanic'        => 'uppercase Roman numerals (I, II, III, IV, V, &hellip;)',
			'roman_low'      => 'lowercase Roman numerals (i, ii, iii, iv, v, &hellip;)',
		),
	);

	/**
	 * Add the settings for this settings group.
	 *
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::COMBINE_IDENTICAL_FOOTNOTES['key'] => $this->add_setting( self::COMBINE_IDENTICAL_FOOTNOTES ),
			self::FOOTNOTES_COUNTER_STYLE['key']     => $this->add_setting( self::FOOTNOTES_COUNTER_STYLE ),
		);

		$this->load_values( $options );
	}
}
