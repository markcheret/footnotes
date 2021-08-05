<?php
/**
 * File providing the `GROUPNAMESettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the TEMP_SETTINGS settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TEMP_GROUP_NAMESettingsGroup extends SettingsGroup {		
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'TEMP_GROUP_ID';
	
	/**
	 * TEMP_SETTING_DOCBLOCK (from `includes/class-settings.php`)
	 *
	 * @var  array
	 *
	 * @since  TEMP_ORIGINAL_SINCE (from `includes/class-settings.php`)
	 * @since  2.8.0  Move from `Settings` to `TEMP_GROUP_NAMESettingsGroup`.
	 *                Convert from `TEMP_ORIG_DATATYPE` to `array`.
	 *                [Convert setting data type from `string` to `boolean`.]
	 */
	const TEMP_SETTING_NAME = array(
		'key' => 'TEMP_SETTING_KEY',
		'name' => 'TEMP_SETTING_LABEL',
		'description' => 'TEMP_SETTING_DESC',
		'default_value' => TEMP_DEFAULT_VALUE,
		'type' => 'integer',
		'input_type' => 'number',
		['input_max' => TEMP_MAX,]
		['input_min' => TEMP_MIN,]
		['enabled_by' => self::TEMP_ENABLED_BY_SETTING_NAME]
	);
	
	protected function add_settings(array|false $options): void {
		$this->settings = array(
			self::TEMP_SETTING_NAME['key'] => $this->add_setting(self::TEMP_SETTING_NAME),
		);
		
		$this->load_values( $options );
	}
}
