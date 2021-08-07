<?php
/**
 * File providing the `AMPCompatSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 * @deprecated
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Footnotes;
use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the AMP compat. settings.
 *
 * @package footnotes
 * @since 2.8.0
 * @deprecated
 */
class AMPCompatSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'amp-compat';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'AMP Compatiblility (unsupported)';

	/**
	 * Settings container key to enable AMP compatibility mode.
	 *
	 * @var  array
	 *
	 * @since  2.6.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_AMP_COMPATIBILITY_ENABLE = array(
		'key'           => 'footnotes_inputfield_amp_compatibility_enable',
		'name'          => 'Enable AMP compatibility mode',
		'description'   => 'The official <a href="https://wordpress.org/plugins/amp/" target="_blank" style="font-style: normal;">AMP-WP</a> plugin is required when this option is enabled. This option enables hard links with configurable scroll offset in % viewport height.',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);
	
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_AMP_COMPATIBILITY_ENABLE['key'] => $this->add_setting( self::FOOTNOTES_AMP_COMPATIBILITY_ENABLE ),
		);

		$this->load_values( $options );
	}
}
