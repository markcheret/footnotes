<?php
/**
 * File providing the `BacklinkSymbolSettingsGroup` class.
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
 * Class defining the backlink symbol settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class BacklinkSymbolSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'backlink-symbol';

	/**
	 * Settings container key for the backlink symbol selection.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const HYPERLINK_ARROW = array(
		'key'           => 'footnote_inputfield_custom_hyperlink_symbol',
		'name'          => 'Select the Backlink Symbol',
		'description'   => 'This symbol is used in the reference container. But this setting pre-existed under this tab and cannot be moved to another one.',
		'default_value' => 0,
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array( 
		  '&#8593;', 
		  '&#8613;', 
		  '&#8607;', 
		  '&#8617;', 
		  '&#8626;', 
		  '&#8629;', 
		  '&#8657;', 
		  '&#8673;', 
		  '&#8679;', 
		  '&#65514;' 
		),
		//'overridden_by' => self::HYPERLINK_ARROW_USER_DEFINED,
	);
	
	/**
	 * Settings container key for the user-defined backlink symbol.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `BacklinkSymbolSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const HYPERLINK_ARROW_USER_DEFINED = array(
		'key'           => 'footnote_inputfield_custom_hyperlink_symbol_user',
		'name'          => 'Input the Backlink Symbol',
		'description'   => 'Your input overrides the selection.',
		'type'          => 'string',
		'input_type'    => 'text',
		'enabled_by'    => self::HYPERLINK_ARROW
	);

	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::HYPERLINK_ARROW['key'] => $this->add_setting( self::HYPERLINK_ARROW ),
			self::HYPERLINK_ARROW_USER_DEFINED['key'] => $this->add_setting( self::HYPERLINK_ARROW_USER_DEFINED ),
		);

		$this->load_values( $options );
	}
}
