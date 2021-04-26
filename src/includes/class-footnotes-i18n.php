<?php // phpcs:disable PEAR.NamingConventions.ValidClassName.Invalid
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.5.0
 * @since      2.8.0 Renamed class to `Footnotes_i18n`.
 *
 * @package    footnotes
 * @subpackage footnotes/includes
 */

require_once dirname( __FILE__ ) . '/class-footnotes-config.php';

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.5.0
 * @since      2.8.0 Renamed class to `Footnotes_i18n`.
 * @package    footnotes
 * @subpackage footnotes/includes
 */
class Footnotes_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.5.1
	 * @since    2.8.0 Rename from `load()` to `load_plugin_textdomain()`. Remove unused `$p_str_language_code` parameter.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'footnotes',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}
