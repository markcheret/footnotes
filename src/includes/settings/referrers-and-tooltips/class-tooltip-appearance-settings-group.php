<?php
/**
 * File providing the `TooltipAppearanceSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\referrersandtooltips;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the tooltip appearance settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipAppearanceSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltip-appearance';

	/**
	 * Settings container key to enable setting the tooltip font size.
	 *
	 * Tooltip font size reset to legacy by default since 2.1.4;
	 * Was set to inherit since 2.1.1 as it overrode custom CSS,
	 * Called mouse over box not tooltip for consistency.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const MOUSE_OVER_BOX_FONT_SIZE_ENABLED = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_font_size_enabled',
		'name'          => 'Set Font Size',
		'description'   => '',
		'default_value' => '',
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for the scalar value of the tooltip font size.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const MOUSE_OVER_BOX_FONT_SIZE_SCALAR = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_font_size_scalar',
		'name'          => 'Font Size',
		'description'   => 'By default, the font size is set to equal the surrounding text.',
		'default_value' => 13.0,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => 50.0,
		'input_min'     => 0.0
	);

	/**
	 * Settings container key for the unit of the tooltip font size.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const MOUSE_OVER_BOX_FONT_SIZE_UNIT = array(
		'key'           => 'footnotes_inputfield_mouse_over_box_font_size_unit',
		'name'          => 'Font Size Unit',
		'default_value' => 'px',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => Setting::FONT_SIZE_UNIT_OPTIONS
	);

	/**
	 * Settings container key for the mouse-over box to define the color.
	 *
	 * @var  array
	 *
	 * @since  1.5.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_COLOR = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_color',
		'name'          => 'Text Color',
		'description'   => 'To use the current theme\'s default text color, clear or leave empty',
		'default_value' => '#000000',
		'type'          => 'string',
		'input_type'    => 'color',
	);

	/**
	 * Settings container key for the mouse-over box to define the background color.
	 *
	 * Theme default background color is best, but theme default background color
	 * doesn't seem to exist.
	 *
	 * The default is currently `#ffffff` with `#000000` as the text color.
	 *
	 * @var  array
	 *
	 * @since  1.5.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_background',
		'name'          => 'Background Color',
		'description'   => 'To use the current theme\'s default background color, clear or leave empty',
		'default_value' => '#ffffff',
		'type'          => 'string',
		'input_type'    => 'color',
	);
	
	/**
	 * Settings container key for the mouse-over box to define the border width.
	 *
	 * @var  array
	 *
	 * @since  1.5.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_border_width',
		'name'          => 'Border Width',
		'description'   => 'pixels; 0 for borderless',
		'default_value' => 1.0,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max' => 4.0,
		'input_min' => 0.0,
	);

	/**
	 * Settings container key for the mouse-over box to define the border color.
	 *
	 * @var  array
	 *
	 * @since  1.5.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_border_color',
		'name'          => 'Border Color',
		'description'   => 'To use the current theme\'s default border color, clear or leave empty',
		'default_value' => '#ffffff',
		'type'          => 'string',
		'input_type'    => 'color',
	);
	
	/**
	 * Settings container key for the mouse-over box to define the border radius.
	 *
	 * @var  array
	 *
	 * @since  1.5.6
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_border_radius',
		'name'          => 'Rounded Corner Radius',
		'description'   => 'pixels; 0 for sharp corners',
		'default_value' => 0,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max' => 500,
		'input_min' => 0,
	);

	/**
	 * Settings container key for the mouse-over box to define the box-shadow color.
	 *
	 * @var  array
	 *
	 * @since  1.5.8
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_shadow_color',
		'name'          => 'Box Shadow Color',
		'description'   => 'To use the current theme\'s default box shadow color, clear or leave empty',
		'default_value' => '#666666',
		'type'          => 'string',
		'input_type'    => 'color',
	);
	
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::MOUSE_OVER_BOX_FONT_SIZE_ENABLED['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FONT_SIZE_ENABLED ),
			self::MOUSE_OVER_BOX_FONT_SIZE_SCALAR['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FONT_SIZE_SCALAR ),
			self::MOUSE_OVER_BOX_FONT_SIZE_UNIT['key'] => $this->add_setting( self::MOUSE_OVER_BOX_FONT_SIZE_UNIT ),
			self::FOOTNOTES_MOUSE_OVER_BOX_COLOR['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_COLOR ),
			self::FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND ),
			self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH ),
			self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR ),
			self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS ),
			self::FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR ),
		);

		$this->load_values( $options );
	}
}
