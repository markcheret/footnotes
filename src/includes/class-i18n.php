<?php // phpcs:disable PEAR.NamingConventions.ValidClassName.StartWithCapital
/**
 * File providing core `i18n` class.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Rename file from `language.php` to `class-footnotes-i18n.php`,
 *                              rename `class/` sub-directory to `includes/`.
 */

declare(strict_types=1);

namespace footnotes\includes;

require_once plugin_dir_path( __DIR__ ) . 'includes/class-config.php';

/**
 * Class providing internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it
 * is ready for translation.
 *
 * @link https://translate.wordpress.org/projects/wp-plugins/footnotes/ GlotPress listing
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Rename class from `Language` to `i18n`.
 */
class i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since  1.5.1
	 * @since  2.8.0  Rename from `load()` to `load_plugin_textdomain()`. Remove unused `$p_str_language_code` parameter.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'footnotes',
			false,
			dirname(plugin_basename( __FILE__ ), 2) . '/languages/'
		);
	}

}
