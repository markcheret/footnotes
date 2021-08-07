<?php
/**
 * File providing the `LoveSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Footnotes;
use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the footnote love settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class LoveSettingsGroup extends SettingsGroup {
	const LOVE_SYMBOL = '<span style="color:#ff6d3b; font-weight:bold;">&hearts;</span>';
	const PLUGIN_SYMBOL = '<span class="footnotes_logo footnotes_logo_part1">foot</span><span class="footnotes_logo footnotes_logo_part2">notes</span>';
	
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'love';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = self::LOVE_SYMBOL . ' Love';

	/**
	 * Settings container key for the ‘I love footnotes’ text.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_LOVE = array(
		'key'           => 'footnote_inputfield_love',
		'name'          => 'Tell the world you\'re using the plugin!',
		'default_value' => 'no',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
		 	// Logo only.
			'text-3' => self::PLUGIN_SYMBOL,
			// Logo followed by heart symbol.
			'text-4' => self::PLUGIN_SYMBOL . ' ' . self::LOVE_SYMBOL,
			// Logo preceded by heart symbol.
			'text-5' => self::LOVE_SYMBOL . ' ' . self::PLUGIN_SYMBOL,
			// Translators: 2: heart symbol 1: footnotes logogram.
			'text-1' => 'I ' . self::LOVE_SYMBOL . ' ' . self::PLUGIN_SYMBOL,
			// Translators: %s: Footnotes plugin logo.
			'text-6' => 'This website uses ' . self::PLUGIN_SYMBOL,
			// Translators: %s: Footnotes plugin logo.
			'text-7' => 'This website uses the ' . self::PLUGIN_SYMBOL . ' plugin',
			// Translators: %s: Footnotes plugin logo.
			'text-2' => 'This website uses the awesome ' . self::PLUGIN_SYMBOL . ' plugin',
			'random' => 'randomly determined display of either mention',
			// Translators: 1: Plugin logo.2: heart symbol.
			'no'     => 'no display of any mention in the footer',
		),
	);
	
	/**
	 * Settings container key for the shortcode to NOT display the ‘LOVE ME’ slug 
	 * on certain pages.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Config` to `ReferenceContainerSettingsGroup`.
	 *                Rename from `NO_LOVE_SLUG` to `FOOTNOTES_NO_LOVE_SLUG`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_NO_LOVE_SLUG = array(
		'key'           => 'footnote_inputfield_no_love_slug',
		'name'          => 'Shortcode to inhibit the display of the ' . self::PLUGIN_SYMBOL . ' mention on specific pages',
		'default_value' => '[[no footnotes: love]]',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_LOVE['key'] => $this->add_setting( self::FOOTNOTES_LOVE ),
			self::FOOTNOTES_NO_LOVE_SLUG['key'] => $this->add_setting( self::FOOTNOTES_NO_LOVE_SLUG ),
		);

		$this->load_values( $options );
	}
}
