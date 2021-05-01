<?php // phpcs:disable PEAR.NamingConventions.ValidClassName.Invalid
/**
 * File providing core `Footnotes_i18n` class.
 *
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @since  2.8.0  Rename file from `language.php` to `class-footnotes-i18n.php`,
 *                              rename `class/` sub-directory to `includes/`.
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-config.php';

/**
 * Class providing internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it
 * is ready for translation.
 *
 * @link  https://translate.wordpress.org/projects/wp-plugins/footnotes/  GlotPress listing
 *
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @since  2.8.0 Rename class from `Footnotes_Language` to `Footnotes_i18n`.
 */
class Footnotes_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since  1.5.1
	 * @since  2.8.0  Rename from `load()` to `load_plugin_textdomain()`. Remove unused `$p_str_language_code` parameter.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'footnotes',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}
