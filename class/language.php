<?php
/**
 * Loads text domain of current or default language for localization.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 17:47
 *
 *
 * @lastmodified 2021-02-18T2028+0100
 *
 * @since 2.0.0  Bugfix: Localization: correct function call apply_filters() with all required arguments after PHP 7.1 promoted warning to error, thanks to @matkus2 bug report and code contribution.
 * @since 2.1.6  Bugfix: Localization: conform to WordPress plugin language file name scheme, thanks to @nikelaos bug report.
 */

/**
 * Loads text domain of current or default language for localization.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Language {

	/**
	 * Register WordPress Hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public static function registerHooks() {
		add_action('plugins_loaded', array("MCI_Footnotes_Language", "loadTextDomain"));
	}

	/**
	 * Loads the text domain for current WordPress language if exists.
	 * Otherwise fallback "en_GB" will be loaded.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 *
	 *
	 * - Bugfix: Correct function call apply_filters() with all required arguments after PHP 7.1 promoted warning to error, thanks to @matkus2 bug report and code contribution.
	 *
	 * @since 2.0.0
	 * @date 2020-10-26T1609+0100
	 *
	 * @contributor @matkus2
	 * @link https://wordpress.org/support/topic/error-missing-parameter-if-using-php-7-1-or-later/
	 *
	 * Add 3rd (empty) argument in apply_filters() to prevent PHP from throwing an error:
	 * “Fatal error: Uncaught ArgumentCountError: Too few arguments to function apply_filters()”
	 *
	 * Yet get_locale() is defined w/o parameters in wp-includes/l10n.php:30, and
	 * apply_filters() is defined as apply_filters( $tag, $value ) in wp-includes/plugin.php:181.
	 * @link https://developer.wordpress.org/reference/functions/apply_filters/
	 *
	 * But apply_filters() is defined with a 3rd parameter (and w/o the first one) in
	 * wp-includes/class-wp-hook.php:264, as public function apply_filters( $value, $args ).
	 *
	 * Taking it all together, probably the full function definition would be:
	 * public function apply_filters( $tag, $value, $args ).
	 * In the case of get_locale(), $args is empty.
	 *
	 * The bug was lurking in WP. PHP 7.1 promoted the warning to an error.
	 * @link https://www.php.net/manual/en/migration71.incompatible.php
	 * @link https://www.php.net/manual/en/migration71.incompatible.php#migration71.incompatible.too-few-arguments-exception
	 */
	public static function loadTextDomain() {

		// if language file with localization exists:
		if ( self::load( apply_filters( 'plugin_locale', get_locale(), '' ) ) ) {
			return;
		}
		// else fall back to British English:
		self::load( "en_GB" );
	}

	/**
	 * Loads a specific text domain.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.1
	 * @param string $p_str_LanguageCode Language Code to load a specific text domain.
	 * @return bool
	 *
	 *
	 * - Bugfix: Localization: conform to WordPress plugin language file name scheme, thanks to @nikelaos bug report.
	 *
	 * @since 2.1.6
	 * @date 2020-12-08T1931+0100
	 *
	 * @reporter @nikelaos
	 * @link https://wordpress.org/support/topic/more-feature-ideas/
	 *
	 * That is done by using load_plugin_textdomain():
	 * “The .mo file should be named based on the text domain with a dash, and then the locale exactly.”
	 * @see wp-includes/l10n.php:857
	 */
	private static function load($p_str_LanguageCode) {
		return load_plugin_textdomain(
			MCI_Footnotes_Config::C_STR_PLUGIN_NAME,
			// This argument only fills the gap left by a deprecated argument (since WP2.7):
			false,
			// The plugin basedir is provided; trailing slash would be clipped:
			MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/languages'
		);
	}
}
