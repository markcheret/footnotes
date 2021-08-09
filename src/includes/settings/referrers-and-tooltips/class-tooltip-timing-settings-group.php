<?php
/**
 * File providing the `TooltipTimingSettingsGroup` class.
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
 * Class defining the tooltip timing settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipTimingSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltip-timing';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Tooltip Timing';

	/**
	 * Settings container key for tooltip display fade-in delay.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const MOUSE_OVER_BOX_FADE_IN_DELAY = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_fade_in_delay',
		'name'          => 'Fade-in Delay',
		'description'   => 'milliseconds',
		'default_value' => 0,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for tooltip display fade-in duration.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const MOUSE_OVER_BOX_FADE_IN_DURATION = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_fade_in_duration',
		'name'          => 'Fade-in Duration',
		'description'   => 'milliseconds',
		'default_value' => 200,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for tooltip display fade-out delay.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const MOUSE_OVER_BOX_FADE_OUT_DELAY = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_fade_out_delay',
		'name'          => 'Fade-out Delay',
		'description'   => 'milliseconds',
		'default_value' => 400,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for tooltip display fade-out duration.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const MOUSE_OVER_BOX_FADE_OUT_DURATION = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_fade_out_duration',
		'name'          => 'Fade-out Duration',
		'description'   => 'milliseconds',
		'default_value' => 200,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);
		
	/**
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::MOUSE_OVER_BOX_FADE_IN_DELAY['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FADE_IN_DELAY ),
			self::MOUSE_OVER_BOX_FADE_IN_DURATION['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FADE_IN_DURATION ),
			self::MOUSE_OVER_BOX_FADE_OUT_DELAY['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FADE_OUT_DELAY ),
			self::MOUSE_OVER_BOX_FADE_OUT_DURATION['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FADE_OUT_DURATION ),
		);

		$this->load_values( $options );
	}
}
