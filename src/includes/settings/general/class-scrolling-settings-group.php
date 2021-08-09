<?php
/**
 * File providing the `ScrollingSettingsGroup` class.
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
 * Class defining the scrolling settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ScrollingSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'scrolling';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Scrolling Behavior';

	/**
	 * Settings container key to enable CSS smooth scrolling.
	 *
	 * Native smooth scrolling only works in recent browsers.
	 *
	 * @var  array
	 *
	 * @since  2.5.12
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_CSS_SMOOTH_SCROLLING = array(
		'key'           => 'footnotes_inputfield_css_smooth_scrolling',
		'name'          => 'CSS-based Smooth Scrolling',
		'description'   => 'May slightly disturb jQuery scrolling and is therefore disabled by default. Works in recent browsers.',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for scroll-up delay.
	 *
	 * @var  array
	 *
	 * @since  2.5.11
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const FOOTNOTES_SCROLL_UP_DELAY = array(
		'key'           => 'footnotes_inputfield_scroll_up_delay',
		'name'          => 'Scroll-up Delay',
		'description'   => 'milliseconds. Less useful than the scroll-down delay.',
		'default_value' => 0,
		'type'          => 'integer',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for scroll-down delay.
	 *
	 * @var  array
	 *
	 * @since  2.5.11
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const FOOTNOTES_SCROLL_DOWN_DELAY = array(
		'key'           => 'footnotes_inputfield_scroll_down_delay',
		'name'          => 'Scroll-down Delay',
		'description'   => 'milliseconds. Useful to see the effect on input elements when referrers without hard links are clicked in form labels.',
		'default_value' => 0,
		'type'          => 'integer',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for scroll offset.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const FOOTNOTES_SCROLL_OFFSET = array(
		'key'           => 'footnotes_inputfield_scroll_offset',
		'name'          => 'Scroll Offset',
		'description'   => 'per cent viewport height from the upper edge',
		'default_value' => 20,
		'type'          => 'integer',
		'input_type'    => 'number',
		'input_max'     => 100,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for scroll duration.
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const FOOTNOTES_SCROLL_DURATION = array(
		'key'           => 'footnotes_inputfield_scroll_duration',
		'name'          => 'Scroll Duration',
		'description'   => 'milliseconds. If asymmetric scroll durations are enabled, this is the scroll-up duration.',
		'default_value' => 380,
		'type'          => 'integer',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
	);

	/**
	 * Settings container key for scroll duration asymmetricity
	 *
	 * @var  array
	 *
	 * @since  2.5.11
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `int` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY = array(
		'key'           => 'footnotes_inputfield_scroll_duration_asymmetricity',
		'name'          => 'Enable Asymmetric Scroll Durations',
		'description'   => 'With this option enabled, scrolling up may take longer than down, or conversely.',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for scroll duration.
	 *
	 * @var  array
	 *
	 * @since  2.1.11
	 * @since  2.8.0  Move from `Settings` to `ScrollingSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const FOOTNOTES_SCROLL_DOWN_DURATION = array(
		'key'           => 'footnotes_inputfield_scroll_down_duration',
		'name'          => 'Scroll-down Duration',
		'description'   => 'milliseconds',
		'default_value' => 150,
		'type'          => 'integer',
		'input_type'    => 'number',
		'input_max'     => 20000,
		'input_min'     => 0,
		'enabled_by'    => self::FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY,
	);
	
	/**
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_CSS_SMOOTH_SCROLLING['key'] => $this->add_setting( self::FOOTNOTES_CSS_SMOOTH_SCROLLING ),
			self::FOOTNOTES_SCROLL_UP_DELAY['key']      => $this->add_setting( self::FOOTNOTES_SCROLL_UP_DELAY ),
			self::FOOTNOTES_SCROLL_DOWN_DELAY['key']    => $this->add_setting( self::FOOTNOTES_SCROLL_DOWN_DELAY ),
			self::FOOTNOTES_SCROLL_OFFSET['key']        => $this->add_setting( self::FOOTNOTES_SCROLL_OFFSET ),
			self::FOOTNOTES_SCROLL_DURATION['key']      => $this->add_setting( self::FOOTNOTES_SCROLL_DURATION ),
			self::FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY['key'] => $this->add_setting( self::FOOTNOTES_SCROLL_DURATION_ASYMMETRICITY ),
			self::FOOTNOTES_SCROLL_DOWN_DURATION['key'] => $this->add_setting( self::FOOTNOTES_SCROLL_DOWN_DURATION ),
		);

		$this->load_values( $options );
	}
}
