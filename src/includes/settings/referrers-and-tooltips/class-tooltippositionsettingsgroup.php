<?php
/**
 * File providing the `TooltipPositionSettingsGroup` class.
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
 * Class defining the tooltip position settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipPositionSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltip-position';

	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Tooltip Position';

	/**
	 * Settings container key for the mouse-over box to define the position.
	 *
	 * The default position should not be lateral because of the risk
	 * the box gets squeezed between note anchor at line end and window edge,
	 * and top because reading at the bottom of the window is more likely.
	 *
	 * @var  array
	 *
	 * @since  1.5.7
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_POSITION = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_position',
		'name'          => 'Position',
		'description'   => 'The second column of settings boxes is for the alternative tooltips.',
		'default_value' => 'top center',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
			'top left'      => 'top left',
			'top center'    => 'top center',
			'top right'     => 'top right',
			'center right'  => 'center right',
			'bottom right'  => 'bottom right',
			'bottom center' => 'bottom center',
			'bottom left'   => 'bottom left',
			'center left'   => 'center left',
		),
	);

	/**
	 * Settings container key for alternative tooltip position.
	 *
	 * Fixed-width is for alternative tooltips, cannot reuse `max-width` nor offsets.
	 *
	 * @var  array
	 *
	 * @since  2.2.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION = array(
		'key'           => 'footnotes_inputfield_alternative_mouse_over_box_position',
		'name'          => 'Position (alternative Tooltips)',
		'default_value' => 'top right',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
			'top left'     => 'top left',
			'top right'    => 'top right',
			'bottom right' => 'bottom right',
			'bottom left'  => 'bottom left',
		),
	);

	/**
	 * Settings container key for the mouse-over box to define the _x_-offset.
	 *
	 * @var  array
	 *
	 * @since  1.5.7
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_offset_x',
		'name'          => 'Horizontal Offset',
		'description'   => 'pixels; negative value for a leftwards offset; alternative tooltips: direction depends on position',
		'default_value' => 0,
		'type'          => 'number',
		'input_type'    => 'number',
	);

	/**
	 * Settings container key for alternative tooltip _x_-offset.
	 *
	 * @var  array
	 *
	 * @since  2.2.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X = array(
		'key'           => 'footnotes_inputfield_alternative_mouse_over_box_offset_x',
		'name'          => 'Horizontal Offset (alternative tooltips)',
		'description'   => 'pixels; negative value for a leftwards offset; alternative tooltips: direction depends on position',
		'default_value' => -50,
		'type'          => 'number',
		'input_type'    => 'number',
	);

	/**
	 * Settings container key for the mouse-over box to define the _y_-offset.
	 *
	 * The vertical offset must be negative for the box not to cover the current
	 * line of text.
	 *
	 * @var  array
	 *
	 * @since  1.5.7
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_offset_y',
		'name'          => 'Vertical Offset',
		'description'   => 'pixels; negative value for an upwards offset; alternative tooltips: direction depends on position',
		'default_value' => -7,
		'type'          => 'number',
		'input_type'    => 'number',
	);

	/**
	 * Settings container key for alternative tooltip _y_-offset.
	 *
	 * @var  array
	 *
	 * @since  2.5.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y = array(
		'key'           => 'footnotes_inputfield_alternative_mouse_over_box_offset_y',
		'name'          => 'Vertical Offset (alternative tooltips)',
		'description'   => 'pixels; negative value for an upwards offset; alternative tooltips: direction depends on position',
		'default_value' => 24,
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
			self::FOOTNOTES_MOUSE_OVER_BOX_POSITION['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_POSITION ),
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION['key'] => $this->add_setting( self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION ),
			self::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X ),
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X['key'] => $this->add_setting( self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X ),
			self::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y ),
			self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y['key'] => $this->add_setting( self::FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y ),
		);

		$this->load_values( $options );
	}
}
