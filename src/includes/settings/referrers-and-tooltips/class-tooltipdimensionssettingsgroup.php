<?php
/**
 * File providing the `TooltipDimensionsSettingsGroup` class.
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
 * Class defining the tooltip dimension settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipDimensionsSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltip-dimensions';

	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Tooltip Dimensions';

	/**
	 * Settings container key for the mouse-over box to define the max. width.
	 *
	 * The width should be limited to start with, for the box to have shape.
	 *
	 * @var  array
	 *
	 * @since  1.5.6
	 * @since  2.0.7  Set default width to 450.
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_max_width',
		'name'          => 'Maximum Width',
		'description'   => 'pixels; set to 0 for jQuery tooltips without max width',
		'default_value' => 450,
		'type'          => 'number',
		'input_type'    => 'number',
	);

	/**
	 * Settings container key for alternative tooltip width.
	 *
	 * @var  array
	 *
	 * @since  2.2.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH = array(
		'key'           => 'footnotes_inputfield_alternative_mouse_over_box_width',
		'name'          => 'Maximum Width (alternative tooltips)',
		'default_value' => 400,
		'type'          => 'number',
		'input_type'    => 'number',
	);

	/**
	 * Add the settings for this settings group.
	 *
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH ),
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH['key'] => $this->add_setting( self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH ),
		);

		$this->load_values( $options );
	}
}
