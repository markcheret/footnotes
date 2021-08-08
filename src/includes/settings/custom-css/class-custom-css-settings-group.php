<?php
/**
 * File providing the `CustomCSSSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\customcss;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the custom CSS settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class CustomCSSSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'custom-css';

	/**
	 * Settings container key for the Custom CSS.
	 *
	 * @var  array
	 *
	 * @since  2.2.2
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const CUSTOM_CSS = array(
		'key'           => 'footnote_inputfield_custom_css_new',
		'name'          => 'Your Existing Custom CSS Code',
		'type'          => 'string',
		'input_type'    => 'textarea',
	);
		
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::CUSTOM_CSS['key'] => $this->add_setting( self::CUSTOM_CSS ),
		);

		$this->load_values( $options );
	}
}
