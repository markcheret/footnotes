<?php
/**
 * File providing the `TooltipTruncationSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\referrersandtooltips;

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the tooltip truncation settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipTruncationSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltip-truncation';

	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Tooltip Truncation';

	/**
	 * Settings container key to enable tooltip truncation.
	 *
	 * @var  array
	 *
	 * @since  1.5.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 * @todo  The mouse-over content truncation should be enabled by default to raise
	 *        awareness of the functionality, prevent the screen from being filled on
	 *        mouse-over, and allow the use of ‘Continue Reading’ functionality.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_excerpt_enabled',
		'name'          => 'Truncate the Note in the Tooltip',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for the mouse-over box to define the max. length of
	 * the enabled excerpt.
	 *
	 * The default truncation length is 200 chars.
	 *
	 * @var  array
	 *
	 * @since  1.5.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_excerpt_length',
		'name'          => 'Maximum Number of Characters in the Tooltip',
		'description'   => 'No weird cuts.',
		'default_value' => 200,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => 10000,
		'input_min'     => 3,
	);

	/**
	 * Settings container key for the label of the Read-on button in truncated tooltips.
	 *
	 * @var  array
	 *
	 * @since  2.1.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_TOOLTIP_READON_LABEL = array(
		'key'           => 'footnote_inputfield_readon_label',
		'name'          => '\'Read on\' Button Label',
		'default_value' => 'Continue reading',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	/**
	 * Add the settings for this settings group.
	 *
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED ),
			self::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH ),
			self::FOOTNOTES_TOOLTIP_READON_LABEL['key'] => $this->add_setting( self::FOOTNOTES_TOOLTIP_READON_LABEL ),
		);

		$this->load_values( $options );
	}
}
