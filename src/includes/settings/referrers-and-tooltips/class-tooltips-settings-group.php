<?php
/**
 * File providing the `TooltipsSettingsGroup` class.
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
 * Class defining the tooltip settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipsSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltips';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Tooltips';

	/**
	 * Settings container key to enable the mouse-over box.
	 *
	 * @var  array
	 *
	 * @since  1.5.2
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_ENABLED = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_enabled',
		'name'          => 'Display Tooltips',
		'description'   => 'Formatted text boxes allowing hyperlinks, displayed on mouse-over or tap and hold.',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key to enable the alternative tooltips.
	 *
	 * These alternative tooltips work around a website-related jQuery UI
	 * outage. They are low-script but use the AMP-incompatible `onmouseover`
	 * and `onmouseout` arguments, along with CSS transitions for fade-in/out.
	 * The very small script is inserted after the plugin's internal stylesheet.
	 *
	 * @var  array
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE = array(
		'key'           => 'footnote_inputfield_custom_mouse_over_box_alternative',
		'name'          => 'Display Alternative Tooltips',
		'description'   => 'Intended to work around a configuration-related tooltip outage. These alternative tooltips work around a website related jQuery UI outage. They are low-script but use the AMP incompatible onmouseover and onmouseout arguments, along with CSS transitions for fade-in/out. The very small script is inserted after Footnotes\' internal stylesheet. When this option is enabled, footnotes does not load jQuery&nbsp;UI nor jQuery&nbsp;Tools.',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);
		
	/**
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_MOUSE_OVER_BOX_ENABLED['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_ENABLED ),
			self::FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE['key'] => $this->add_setting( self::FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ),
		);

		$this->load_values( $options );
	}
}
